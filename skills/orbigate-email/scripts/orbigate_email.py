#!/usr/bin/env python3
"""Orbigate email CLI for eddie@orbigate.com on Titan (IMAP/SMTP, stdlib only).

The password is read from the ORBIGATE_EMAIL_PASSWORD environment variable.
Every command prints JSON with a "status" field ("ok" or "error").
"""
import argparse
import email
import email.utils
import html as htmllib
import imaplib
import json
import mimetypes
import os
import re
import smtplib
import ssl
import sys
import time
from email.header import decode_header, make_header
from email.message import EmailMessage

CONFIG = {
    "email": "eddie@orbigate.com",
    "from_name": "Eddie",
    "imap_host": "imap.titan.email",
    "imap_port": 993,
    "smtp_host": "smtp.titan.email",
    "smtp_port": 465,
    "timeout": 30,
}
SIGNATURE_FILE = os.path.join(os.path.dirname(os.path.abspath(__file__)), "signature.html")


def _password():
    pw = os.environ.get("ORBIGATE_EMAIL_PASSWORD")
    if not pw:
        raise RuntimeError("ORBIGATE_EMAIL_PASSWORD is not set")
    return pw


def imap_connect():
    m = imaplib.IMAP4_SSL(CONFIG["imap_host"], CONFIG["imap_port"],
                          ssl_context=ssl.create_default_context(), timeout=CONFIG["timeout"])
    m.login(CONFIG["email"], _password())
    return m


def smtp_connect():
    s = smtplib.SMTP_SSL(CONFIG["smtp_host"], CONFIG["smtp_port"],
                         context=ssl.create_default_context(), timeout=CONFIG["timeout"])
    s.login(CONFIG["email"], _password())
    return s


def dh(v):
    if not v:
        return ""
    try:
        return str(make_header(decode_header(v)))
    except Exception:
        return str(v)


def body_of(msg):
    plain = htm = None
    for part in msg.walk():
        if part.is_multipart() or part.get_content_disposition() == "attachment":
            continue
        ct = part.get_content_type()
        if ct not in ("text/plain", "text/html"):
            continue
        payload = part.get_payload(decode=True) or b""
        text = payload.decode(part.get_content_charset() or "utf-8", errors="replace")
        if ct == "text/plain" and plain is None:
            plain = text
        elif ct == "text/html" and htm is None:
            htm = text
    if plain is not None:
        return plain
    if htm is not None:
        t = re.sub(r"(?is)<(script|style).*?</\1>", "", htm)
        t = re.sub(r"(?i)<br\s*/?>|</p>", "\n", t)
        return htmllib.unescape(re.sub(r"<[^>]+>", "", t)).strip()
    return ""


def attachments_of(msg):
    out = []
    for part in msg.walk():
        if part.get_content_disposition() == "attachment":
            out.append({"filename": dh(part.get_filename()), "type": part.get_content_type(),
                        "size": len(part.get_payload(decode=True) or b"")})
    return out


def summary(uid, msg):
    return {"id": uid, "from": dh(msg["From"]), "to": dh(msg["To"]), "subject": dh(msg["Subject"]),
            "date": msg["Date"]}


def fetch(m, uid, spec="(RFC822)"):
    typ, data = m.uid("fetch", uid, spec)
    if typ != "OK" or not data or not isinstance(data[0], tuple):
        raise RuntimeError(f"message {uid} not found")
    return email.message_from_bytes(data[0][1])


def select(m, folder, readonly=True):
    typ, _ = m.select(f'"{folder}"', readonly=readonly)
    if typ != "OK":
        raise RuntimeError(f"cannot open folder {folder}")


def list_msgs(m, criteria, count):
    typ, data = m.uid("search", None, *criteria)
    uids = data[0].split()[-count:][::-1]
    return [summary(u.decode(), fetch(m, u, "(BODY.PEEK[HEADER])")) for u in uids]


def cmd_inbox(a):
    m = imap_connect()
    try:
        select(m, a.folder)
        return {"messages": list_msgs(m, ["ALL"], a.n)}
    finally:
        m.logout()


def cmd_search(a):
    m = imap_connect()
    try:
        select(m, a.folder)
        return {"messages": list_msgs(m, [a.query], a.n)}
    finally:
        m.logout()


def cmd_read(a):
    m = imap_connect()
    try:
        select(m, a.folder, readonly=False)
        msg = fetch(m, a.id)
        return {**summary(a.id, msg), "cc": dh(msg["Cc"]), "message_id": msg["Message-ID"],
                "body": body_of(msg), "attachments": attachments_of(msg)}
    finally:
        m.logout()


def _text_to_html(text):
    text = text.replace("\\n", "\n")
    paras = [p for p in re.split(r"\n\s*\n", text.strip()) if p.strip()]
    return "".join("<p>" + htmllib.escape(p).replace("\n", "<br>") + "</p>" for p in paras)


def _signature():
    try:
        with open(SIGNATURE_FILE, encoding="utf-8") as f:
            return f.read()
    except OSError:
        return ""


def _build(to, subject, body, cc=None, bcc=None, html=False, attach=None, headers=None):
    msg = EmailMessage()
    msg["From"] = email.utils.formataddr((CONFIG["from_name"], CONFIG["email"]))
    msg["To"] = to
    if cc:
        msg["Cc"] = cc
    if bcc:
        msg["Bcc"] = bcc
    msg["Subject"] = subject
    msg["Date"] = email.utils.formatdate(localtime=True)
    msg["Message-ID"] = email.utils.make_msgid(domain="orbigate.com")
    for k, v in (headers or {}).items():
        msg[k] = v
    inner = body if html else _text_to_html(body)
    plain = re.sub(r"<[^>]+>", "", re.sub(r"(?i)<br\s*/?>|</p>", "\n", inner))
    msg.set_content(htmllib.unescape(plain).strip())
    msg.add_alternative(f"<html><body>{inner}{_signature()}</body></html>", subtype="html")
    for path in attach or []:
        ctype = mimetypes.guess_type(path)[0] or "application/octet-stream"
        main, sub = ctype.split("/", 1)
        with open(path, "rb") as f:
            msg.add_attachment(f.read(), maintype=main, subtype=sub, filename=os.path.basename(path))
    return msg


def _deliver(msg):
    recipients = [x for h in ("To", "Cc", "Bcc") for _, x in email.utils.getaddresses([msg[h] or ""]) if x]
    del msg["Bcc"]  # never leak Bcc in stored/sent headers
    s = smtp_connect()
    try:
        s.send_message(msg, to_addrs=recipients)
    finally:
        s.quit()
    # Titan does not auto-save sent mail, so file a copy ourselves.
    saved = None
    m = imap_connect()
    try:
        for folder in ("Sent", "Sent Items", "INBOX.Sent"):
            typ, _ = m.append(f'"{folder}"', "\\Seen", imaplib.Time2Internaldate(time.time()), msg.as_bytes())
            if typ == "OK":
                saved = folder
                break
    finally:
        m.logout()
    return {"to": recipients, "subject": msg["Subject"], "saved_to": saved}


def cmd_send(a):
    return _deliver(_build(a.to, a.subject, a.body, a.cc, a.bcc, a.html, a.attach))


def cmd_reply(a):
    m = imap_connect()
    try:
        select(m, a.folder)
        orig = fetch(m, a.id)
    finally:
        m.logout()
    me = CONFIG["email"].lower()
    to = orig["Reply-To"] or orig["From"]
    cc = None
    if a.all:
        addrs = email.utils.getaddresses([orig["To"] or "", orig["Cc"] or ""])
        cc = ", ".join(x for _, x in addrs if x and x.lower() != me) or None
    subj = dh(orig["Subject"])
    if not subj.lower().startswith("re:"):
        subj = "Re: " + subj
    refs = " ".join(filter(None, [orig["References"], orig["Message-ID"]]))
    headers = {"In-Reply-To": orig["Message-ID"], "References": refs} if orig["Message-ID"] else {}
    quoted = "\n".join("> " + l for l in body_of(orig).splitlines()[:50])
    body = f"{a.body.replace(chr(92) + 'n', chr(10))}\n\nOn {orig['Date']}, {dh(orig['From'])} wrote:\n{quoted}"
    return _deliver(_build(to, subj, body, cc=cc, headers=headers))


def cmd_folders(a):
    m = imap_connect()
    try:
        typ, data = m.list()
        return {"folders": [d.decode() for d in data]}
    finally:
        m.logout()


def _store(a, flag, add=True):
    m = imap_connect()
    try:
        select(m, a.folder, readonly=False)
        m.uid("store", a.id, "+FLAGS" if add else "-FLAGS", flag)
        return {"id": a.id, "flag": flag, "set": add}
    finally:
        m.logout()


def cmd_move(a):
    m = imap_connect()
    try:
        select(m, a.folder, readonly=False)
        typ, _ = m.uid("copy", a.id, f'"{a.destination}"')
        if typ != "OK":
            raise RuntimeError(f"cannot copy to {a.destination}")
        m.uid("store", a.id, "+FLAGS", "\\Deleted")
        m.expunge()
        return {"id": a.id, "moved_to": a.destination}
    finally:
        m.logout()


def cmd_delete(a):
    m = imap_connect()
    try:
        select(m, a.folder, readonly=False)
        typ, _ = m.uid("copy", a.id, '"Trash"')
        m.uid("store", a.id, "+FLAGS", "\\Deleted")
        m.expunge()
        return {"id": a.id, "deleted": True, "to_trash": typ == "OK"}
    finally:
        m.logout()


def main():
    p = argparse.ArgumentParser(description="Orbigate email CLI (eddie@orbigate.com)")
    sub = p.add_subparsers(dest="command", required=True)

    def add(name, fn, folder=True, id_=False):
        sp = sub.add_parser(name)
        sp.set_defaults(fn=fn)
        if id_:
            sp.add_argument("id")
        if folder:
            sp.add_argument("--folder", default="INBOX")
        return sp

    add("inbox", cmd_inbox).add_argument("-n", type=int, default=20)
    sp = add("search", cmd_search)
    sp.add_argument("query")
    sp.add_argument("-n", type=int, default=20)
    add("read", cmd_read, id_=True)
    sp = add("send", cmd_send, folder=False)
    sp.add_argument("--to", required=True)
    sp.add_argument("--subject", required=True)
    sp.add_argument("--body", required=True)
    sp.add_argument("--cc")
    sp.add_argument("--bcc")
    sp.add_argument("--html", action="store_true")
    sp.add_argument("--attach", nargs="*")
    sp = add("reply", cmd_reply, id_=True)
    sp.add_argument("--body", required=True)
    sp.add_argument("--all", action="store_true")
    add("folders", cmd_folders, folder=False)
    add("move", cmd_move, id_=True).add_argument("destination")
    add("delete", cmd_delete, id_=True)
    for name, flag, on in (("flag", "\\Flagged", True), ("unflag", "\\Flagged", False),
                           ("mark_read", "\\Seen", True), ("mark_unread", "\\Seen", False)):
        add(name, lambda a, f=flag, o=on: _store(a, f, o), id_=True)

    args = p.parse_args()
    try:
        print(json.dumps({"status": "ok", **args.fn(args)}, indent=2, ensure_ascii=False))
    except Exception as e:
        print(json.dumps({"status": "error", "error": f"{type(e).__name__}: {e}"}, indent=2))
        sys.exit(1)


if __name__ == "__main__":
    main()
