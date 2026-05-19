#!/usr/bin/env python3
"""
forti-email: IMAP/SMTP email client for eddie@fortlineglobal.com

Full email management via Python's built-in imaplib/smtplib.
Designed to be run from Eddie's local terminal (Cowork sandbox blocks outbound TCP).

Usage:
    python3 forti_email.py <command> [options]

Commands:
    inbox           List recent inbox messages
    read <id>       Read a specific email by message ID
    search <query>  Search emails (IMAP search syntax)
    send            Send a new email
    reply <id>      Reply to a specific email
    folders         List all mail folders
    move <id> <folder>  Move message to folder
    delete <id>     Delete a message (move to Trash)
    flag <id>       Flag/star a message
    unflag <id>     Unflag/unstar a message
    mark_read <id>  Mark message as read
    mark_unread <id> Mark message as unread
"""

import imaplib
import smtplib
import ssl
import email
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from email.mime.base import MIMEBase
from email import encoders
from email.header import decode_header
from email.utils import formatdate, make_msgid
import json
import sys
import os
import argparse
from datetime import datetime, timedelta
from pathlib import Path

# ─── Configuration ────────────────────────────────────────────────────────────
CONFIG = {
    "email": "eddie@fortlineglobal.com",
    "password": "Flexor12?*",
    "imap_server": "imap.gmail.com",
    "imap_port": 993,
    "smtp_server": "smtp.gmail.com",
    "smtp_port": 587,
    "display_name": "Eddie"
}

# ─── IMAP Connection ─────────────────────────────────────────────────────────

def get_imap_connection():
    """Connect and authenticate to IMAP server."""
    context = ssl.create_default_context()
    mail = imaplib.IMAP4_SSL(CONFIG["imap_server"], CONFIG["imap_port"], ssl_context=context)
    mail.login(CONFIG["email"], CONFIG["password"])
    return mail

def get_smtp_connection():
    """Connect and authenticate to SMTP server via STARTTLS (Gmail port 587)."""
    context = ssl.create_default_context()
    server = smtplib.SMTP(CONFIG["smtp_server"], CONFIG["smtp_port"])
    server.ehlo()
    server.starttls(context=context)
    server.ehlo()
    server.login(CONFIG["email"], CONFIG["password"])
    return server

# ─── Helper Functions ─────────────────────────────────────────────────────────

def decode_mime_header(header_value):
    """Decode a MIME-encoded header into a readable string."""
    if header_value is None:
        return ""
    decoded_parts = decode_header(header_value)
    result = []
    for part, charset in decoded_parts:
        if isinstance(part, bytes):
            result.append(part.decode(charset or "utf-8", errors="replace"))
        else:
            result.append(part)
    return " ".join(result)

def get_email_body(msg):
    """Extract the text body from an email message."""
    body = ""
    if msg.is_multipart():
        for part in msg.walk():
            content_type = part.get_content_type()
            content_disposition = str(part.get("Content-Disposition", ""))
            if content_type == "text/plain" and "attachment" not in content_disposition:
                payload = part.get_payload(decode=True)
                if payload:
                    charset = part.get_content_charset() or "utf-8"
                    body = payload.decode(charset, errors="replace")
                    break
            elif content_type == "text/html" and not body and "attachment" not in content_disposition:
                payload = part.get_payload(decode=True)
                if payload:
                    charset = part.get_content_charset() or "utf-8"
                    body = payload.decode(charset, errors="replace")
    else:
        payload = msg.get_payload(decode=True)
        if payload:
            charset = msg.get_content_charset() or "utf-8"
            body = payload.decode(charset, errors="replace")
    return body

def get_attachments(msg):
    """List attachments in an email."""
    attachments = []
    if msg.is_multipart():
        for part in msg.walk():
            content_disposition = str(part.get("Content-Disposition", ""))
            if "attachment" in content_disposition:
                filename = part.get_filename()
                if filename:
                    attachments.append(decode_mime_header(filename))
    return attachments

def format_email_summary(msg_id, msg):
    """Format a single email as a summary dict."""
    return {
        "id": msg_id,
        "from": decode_mime_header(msg.get("From", "")),
        "to": decode_mime_header(msg.get("To", "")),
        "subject": decode_mime_header(msg.get("Subject", "")),
        "date": msg.get("Date", ""),
        "attachments": get_attachments(msg),
        "message_id": msg.get("Message-ID", "")
    }

EMAIL_SIGNATURE_HTML = """<br><br>
<table cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #1e293b; line-height: 1.4;">
  <tr>
    <td style="padding-right: 16px; vertical-align: top;">
      <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" width="48" height="48">
        <path d="M20 2L36 11V29L20 38L4 29V11L20 2Z" stroke="#3b82f6" stroke-width="1.5" fill="rgba(37,99,235,0.1)"/>
        <path d="M20 8L30 14V26L20 32L10 26V14L20 8Z" stroke="#3b82f6" stroke-width="1" fill="none"/>
        <line x1="20" y1="14" x2="20" y2="26" stroke="#3b82f6" stroke-width="1"/>
        <line x1="14" y1="18" x2="26" y2="18" stroke="#3b82f6" stroke-width="0.8"/>
        <line x1="14" y1="22" x2="26" y2="22" stroke="#3b82f6" stroke-width="0.8"/>
      </svg>
    </td>
    <td style="vertical-align: top;">
      <div style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 2px;">Eddie Nudel</div>
      <div style="font-size: 13px; color: #475569; margin-bottom: 10px;">
        Strategic Advisor&nbsp;&nbsp;|&nbsp;&nbsp;<span style="font-weight: 600; color: #0f172a;">Fort</span><span style="font-weight: 600; color: #3b82f6;">line</span> Global
      </div>
      <div style="border-top: 2px solid #3b82f6; width: 50px; margin-bottom: 10px;"></div>
      <div style="font-size: 12px; color: #64748b;">
        <span style="color: #3b82f6;">M</span>&nbsp;&nbsp;<a href="tel:+16463383012" style="color: #475569; text-decoration: none;">+1 (646) 338-3012</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="tel:+972543203976" style="color: #475569; text-decoration: none;">+972 (54) 320-3976</a>
      </div>
      <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
        <span style="color: #3b82f6;">E</span>&nbsp;&nbsp;<a href="mailto:eddie@fortlineglobal.com" style="color: #475569; text-decoration: none;">eddie@fortlineglobal.com</a>
      </div>
      <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
        <span style="color: #3b82f6;">W</span>&nbsp;&nbsp;<a href="https://fortlineglobal.com" style="color: #475569; text-decoration: none;">fortlineglobal.com</a>
      </div>
      <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
        <span style="color: #3b82f6;">in</span>&nbsp;&nbsp;<a href="https://www.linkedin.com/in/eddienudel" style="color: #475569; text-decoration: none;">linkedin.com/in/eddienudel</a>
      </div>
      <div style="margin-top: 10px; font-size: 11px; color: #94a3b8; font-style: italic;">
        Defense-Grade Protection Technology
      </div>
    </td>
  </tr>
</table>
"""

EMAIL_SIGNATURE_PLAIN = """

--
Eddie Nudel
Strategic Advisor | Fortline Global
M: +1 (646) 338-3012 / +972 (54) 320-3976
E: eddie@fortlineglobal.com
W: fortlineglobal.com
LinkedIn: linkedin.com/in/eddienudel
Defense-Grade Protection Technology
"""

def save_to_sent(msg):
    """Gmail automatically saves sent messages — no manual save needed."""
    pass

# ─── Commands ─────────────────────────────────────────────────────────────────

def cmd_inbox(count=20, folder="INBOX"):
    """List recent messages from inbox (or specified folder)."""
    mail = get_imap_connection()
    try:
        mail.select(folder, readonly=True)
        status, messages = mail.search(None, "ALL")
        msg_ids = messages[0].split()

        # Get the most recent N
        recent_ids = msg_ids[-count:] if len(msg_ids) > count else msg_ids
        recent_ids = list(reversed(recent_ids))  # newest first

        results = []
        for mid in recent_ids:
            status, msg_data = mail.fetch(mid, "(RFC822)")
            if status == "OK":
                raw = msg_data[0][1]
                msg = email.message_from_bytes(raw)
                results.append(format_email_summary(mid.decode(), msg))

        return {"status": "ok", "count": len(results), "total_in_folder": len(msg_ids), "emails": results}
    finally:
        mail.logout()

def cmd_read(msg_id, folder="INBOX"):
    """Read a specific email by its IMAP message ID."""
    mail = get_imap_connection()
    try:
        mail.select(folder)
        status, msg_data = mail.fetch(str(msg_id).encode(), "(RFC822)")
        if status != "OK":
            return {"status": "error", "message": f"Could not fetch message {msg_id}"}

        raw = msg_data[0][1]
        msg = email.message_from_bytes(raw)
        summary = format_email_summary(msg_id, msg)
        summary["body"] = get_email_body(msg)
        summary["cc"] = decode_mime_header(msg.get("Cc", ""))
        summary["reply_to"] = decode_mime_header(msg.get("Reply-To", ""))

        # Mark as read
        mail.store(str(msg_id).encode(), "+FLAGS", "\\Seen")

        return {"status": "ok", "email": summary}
    finally:
        mail.logout()

def cmd_search(query, folder="INBOX", count=20):
    """
    Search emails using IMAP search criteria.

    Examples:
        FROM "john@example.com"
        SUBJECT "meeting"
        SINCE "01-Jan-2025"
        UNSEEN
        FROM "john" SUBJECT "project"
        TEXT "quarterly report"
    """
    mail = get_imap_connection()
    try:
        mail.select(folder, readonly=True)
        status, messages = mail.search(None, query)
        if status != "OK":
            return {"status": "error", "message": f"Search failed: {query}"}

        msg_ids = messages[0].split()
        recent_ids = msg_ids[-count:] if len(msg_ids) > count else msg_ids
        recent_ids = list(reversed(recent_ids))

        results = []
        for mid in recent_ids:
            status, msg_data = mail.fetch(mid, "(RFC822)")
            if status == "OK":
                raw = msg_data[0][1]
                msg = email.message_from_bytes(raw)
                results.append(format_email_summary(mid.decode(), msg))

        return {"status": "ok", "count": len(results), "total_matches": len(msg_ids), "emails": results}
    finally:
        mail.logout()

def cmd_send(to, subject, body, cc=None, bcc=None, html=False, attachment_paths=None):
    """Send a new email."""
    msg = MIMEMultipart()
    msg["From"] = f"{CONFIG['display_name']} <{CONFIG['email']}>"
    msg["To"] = to
    msg["Subject"] = subject
    msg["Date"] = formatdate(localtime=True)
    msg["Message-ID"] = make_msgid(domain="fortlineglobal.com")

    if cc:
        msg["Cc"] = cc
    if bcc:
        msg["Bcc"] = bcc

    if html:
        body_html = body + EMAIL_SIGNATURE_HTML
    else:
        # Handle literal \n from CLI args (shell doesn't expand them)
        normalized = body.replace("\\n", "\n")
        # Split into paragraphs on double newlines, wrap each in <p> tags
        paragraphs = [p.strip() for p in normalized.split("\n\n") if p.strip()]
        if len(paragraphs) > 1:
            body_html = "".join(f"<p style='margin:0 0 12px 0;'>{p.replace(chr(10), '<br>')}</p>" for p in paragraphs)
        else:
            # Single paragraph or no double newlines: use <br> for single newlines
            body_html = normalized.replace("\n", "<br>")
        body_html = body_html + EMAIL_SIGNATURE_HTML
    msg.attach(MIMEText(body_html, "html", "utf-8"))

    # Handle attachments
    if attachment_paths:
        for filepath in attachment_paths:
            filepath = Path(filepath)
            if filepath.exists():
                with open(filepath, "rb") as f:
                    part = MIMEBase("application", "octet-stream")
                    part.set_payload(f.read())
                    encoders.encode_base64(part)
                    part.add_header("Content-Disposition", f"attachment; filename={filepath.name}")
                    msg.attach(part)

    # Build recipient list
    recipients = [addr.strip() for addr in to.split(",")]
    if cc:
        recipients += [addr.strip() for addr in cc.split(",")]
    if bcc:
        recipients += [addr.strip() for addr in bcc.split(",")]

    server = get_smtp_connection()
    try:
        server.sendmail(CONFIG["email"], recipients, msg.as_string())
        save_to_sent(msg)
        return {"status": "ok", "message": f"Email sent to {to}", "subject": subject}
    finally:
        server.quit()

def cmd_reply(msg_id, body, reply_all=False, folder="INBOX"):
    """Reply to a specific email."""
    mail = get_imap_connection()
    try:
        mail.select(folder)
        status, msg_data = mail.fetch(str(msg_id).encode(), "(RFC822)")
        if status != "OK":
            return {"status": "error", "message": f"Could not fetch message {msg_id}"}

        raw = msg_data[0][1]
        original = email.message_from_bytes(raw)
    finally:
        mail.logout()

    # Build reply
    reply = MIMEMultipart()
    reply_to_addr = original.get("Reply-To") or original.get("From")
    reply["To"] = reply_to_addr
    reply["From"] = f"{CONFIG['display_name']} <{CONFIG['email']}>"

    orig_subject = decode_mime_header(original.get("Subject", ""))
    reply["Subject"] = f"Re: {orig_subject}" if not orig_subject.lower().startswith("re:") else orig_subject
    reply["Date"] = formatdate(localtime=True)
    reply["Message-ID"] = make_msgid(domain="fortlineglobal.com")
    reply["In-Reply-To"] = original.get("Message-ID", "")
    reply["References"] = original.get("References", "") + " " + original.get("Message-ID", "")

    if reply_all:
        cc_addrs = []
        for header in ["To", "Cc"]:
            if original.get(header):
                addrs = original.get(header).split(",")
                cc_addrs.extend([a.strip() for a in addrs if CONFIG["email"] not in a])
        if cc_addrs:
            reply["Cc"] = ", ".join(cc_addrs)

    # Handle literal \n from CLI args (shell doesn't expand them)
    normalized = body.replace("\\n", "\n")
    paragraphs = [p.strip() for p in normalized.split("\n\n") if p.strip()]
    if len(paragraphs) > 1:
        body_html = "".join(f"<p style='margin:0 0 12px 0;'>{p.replace(chr(10), '<br>')}</p>" for p in paragraphs)
    else:
        body_html = normalized.replace("\n", "<br>")
    body_html = body_html + EMAIL_SIGNATURE_HTML
    reply.attach(MIMEText(body_html, "html", "utf-8"))

    recipients = [reply_to_addr]
    if reply.get("Cc"):
        recipients += [a.strip() for a in reply["Cc"].split(",")]

    server = get_smtp_connection()
    try:
        server.sendmail(CONFIG["email"], recipients, reply.as_string())
        save_to_sent(reply)
        return {"status": "ok", "message": f"Reply sent to {reply_to_addr}", "subject": reply["Subject"]}
    finally:
        server.quit()

def cmd_folders():
    """List all mail folders."""
    mail = get_imap_connection()
    try:
        status, mailboxes = mail.list()
        folders = []
        for mb in mailboxes:
            decoded = mb.decode()
            # Parse IMAP folder listing: (\\flags) "delimiter" "name"
            parts = decoded.split(' "')
            if len(parts) >= 3:
                name = parts[-1].strip('"')
                folders.append(name)
            else:
                folders.append(decoded)
        return {"status": "ok", "folders": folders}
    finally:
        mail.logout()

def cmd_move(msg_id, destination, folder="INBOX"):
    """Move a message to a different folder."""
    mail = get_imap_connection()
    try:
        mail.select(folder)
        # Copy to destination
        status, _ = mail.copy(str(msg_id).encode(), destination)
        if status != "OK":
            return {"status": "error", "message": f"Failed to copy message to {destination}"}
        # Mark original as deleted
        mail.store(str(msg_id).encode(), "+FLAGS", "\\Deleted")
        mail.expunge()
        return {"status": "ok", "message": f"Message {msg_id} moved to {destination}"}
    finally:
        mail.logout()

def cmd_delete(msg_id, folder="INBOX"):
    """Delete a message (move to Trash)."""
    # Try common trash folder names
    trash_names = ["Trash", "INBOX.Trash", "[Gmail]/Trash", "Deleted Items", "Deleted"]

    mail = get_imap_connection()
    try:
        status, mailboxes = mail.list()
        available = []
        for mb in mailboxes:
            decoded = mb.decode()
            parts = decoded.split(' "')
            if len(parts) >= 3:
                available.append(parts[-1].strip('"'))

        trash_folder = None
        for name in trash_names:
            if name in available:
                trash_folder = name
                break

        if trash_folder:
            mail.select(folder)
            mail.copy(str(msg_id).encode(), trash_folder)
            mail.store(str(msg_id).encode(), "+FLAGS", "\\Deleted")
            mail.expunge()
            return {"status": "ok", "message": f"Message {msg_id} moved to {trash_folder}"}
        else:
            # If no trash folder found, just flag as deleted
            mail.select(folder)
            mail.store(str(msg_id).encode(), "+FLAGS", "\\Deleted")
            mail.expunge()
            return {"status": "ok", "message": f"Message {msg_id} permanently deleted (no Trash folder found)"}
    finally:
        mail.logout()

def cmd_flag(msg_id, folder="INBOX"):
    """Flag/star a message."""
    mail = get_imap_connection()
    try:
        mail.select(folder)
        mail.store(str(msg_id).encode(), "+FLAGS", "\\Flagged")
        return {"status": "ok", "message": f"Message {msg_id} flagged"}
    finally:
        mail.logout()

def cmd_unflag(msg_id, folder="INBOX"):
    """Unflag/unstar a message."""
    mail = get_imap_connection()
    try:
        mail.select(folder)
        mail.store(str(msg_id).encode(), "-FLAGS", "\\Flagged")
        return {"status": "ok", "message": f"Message {msg_id} unflagged"}
    finally:
        mail.logout()

def cmd_mark_read(msg_id, folder="INBOX"):
    """Mark a message as read."""
    mail = get_imap_connection()
    try:
        mail.select(folder)
        mail.store(str(msg_id).encode(), "+FLAGS", "\\Seen")
        return {"status": "ok", "message": f"Message {msg_id} marked as read"}
    finally:
        mail.logout()

def cmd_mark_unread(msg_id, folder="INBOX"):
    """Mark a message as unread."""
    mail = get_imap_connection()
    try:
        mail.select(folder)
        mail.store(str(msg_id).encode(), "-FLAGS", "\\Seen")
        return {"status": "ok", "message": f"Message {msg_id} marked as unread"}
    finally:
        mail.logout()

# ─── CLI Entry Point ──────────────────────────────────────────────────────────

def main():
    parser = argparse.ArgumentParser(description="Fortline Global Email CLI")
    subparsers = parser.add_subparsers(dest="command", help="Command to execute")

    # inbox
    p_inbox = subparsers.add_parser("inbox", help="List recent inbox messages")
    p_inbox.add_argument("-n", "--count", type=int, default=20, help="Number of messages")
    p_inbox.add_argument("-f", "--folder", default="INBOX", help="Mail folder")

    # read
    p_read = subparsers.add_parser("read", help="Read a specific email")
    p_read.add_argument("msg_id", help="Message ID")
    p_read.add_argument("-f", "--folder", default="INBOX", help="Mail folder")

    # search
    p_search = subparsers.add_parser("search", help="Search emails")
    p_search.add_argument("query", help='IMAP search query, e.g. FROM "john" SUBJECT "meeting"')
    p_search.add_argument("-f", "--folder", default="INBOX", help="Mail folder")
    p_search.add_argument("-n", "--count", type=int, default=20, help="Max results")

    # send
    p_send = subparsers.add_parser("send", help="Send a new email")
    p_send.add_argument("--to", required=True, help="Recipient email(s)")
    p_send.add_argument("--subject", required=True, help="Email subject")
    p_send.add_argument("--body", required=True, help="Email body text")
    p_send.add_argument("--cc", help="CC recipients")
    p_send.add_argument("--bcc", help="BCC recipients")
    p_send.add_argument("--html", action="store_true", help="Send as HTML")
    p_send.add_argument("--attach", nargs="*", help="File paths to attach")

    # reply
    p_reply = subparsers.add_parser("reply", help="Reply to an email")
    p_reply.add_argument("msg_id", help="Message ID to reply to")
    p_reply.add_argument("--body", required=True, help="Reply body text")
    p_reply.add_argument("--all", action="store_true", dest="reply_all", help="Reply all")
    p_reply.add_argument("-f", "--folder", default="INBOX", help="Mail folder")

    # folders
    subparsers.add_parser("folders", help="List all mail folders")

    # move
    p_move = subparsers.add_parser("move", help="Move message to folder")
    p_move.add_argument("msg_id", help="Message ID")
    p_move.add_argument("destination", help="Destination folder")
    p_move.add_argument("-f", "--folder", default="INBOX", help="Source folder")

    # delete
    p_delete = subparsers.add_parser("delete", help="Delete a message")
    p_delete.add_argument("msg_id", help="Message ID")
    p_delete.add_argument("-f", "--folder", default="INBOX", help="Mail folder")

    # flag / unflag
    p_flag = subparsers.add_parser("flag", help="Flag/star a message")
    p_flag.add_argument("msg_id", help="Message ID")
    p_flag.add_argument("-f", "--folder", default="INBOX", help="Mail folder")

    p_unflag = subparsers.add_parser("unflag", help="Unflag a message")
    p_unflag.add_argument("msg_id", help="Message ID")
    p_unflag.add_argument("-f", "--folder", default="INBOX", help="Mail folder")

    # mark_read / mark_unread
    p_mr = subparsers.add_parser("mark_read", help="Mark as read")
    p_mr.add_argument("msg_id", help="Message ID")
    p_mr.add_argument("-f", "--folder", default="INBOX", help="Mail folder")

    p_mu = subparsers.add_parser("mark_unread", help="Mark as unread")
    p_mu.add_argument("msg_id", help="Message ID")
    p_mu.add_argument("-f", "--folder", default="INBOX", help="Mail folder")

    args = parser.parse_args()

    if not args.command:
        parser.print_help()
        sys.exit(1)

    try:
        if args.command == "inbox":
            result = cmd_inbox(count=args.count, folder=args.folder)
        elif args.command == "read":
            result = cmd_read(args.msg_id, folder=args.folder)
        elif args.command == "search":
            result = cmd_search(args.query, folder=args.folder, count=args.count)
        elif args.command == "send":
            result = cmd_send(args.to, args.subject, args.body, cc=args.cc, bcc=args.bcc, html=args.html, attachment_paths=args.attach)
        elif args.command == "reply":
            result = cmd_reply(args.msg_id, args.body, reply_all=args.reply_all, folder=args.folder)
        elif args.command == "folders":
            result = cmd_folders()
        elif args.command == "move":
            result = cmd_move(args.msg_id, args.destination, folder=args.folder)
        elif args.command == "delete":
            result = cmd_delete(args.msg_id, folder=args.folder)
        elif args.command == "flag":
            result = cmd_flag(args.msg_id, folder=args.folder)
        elif args.command == "unflag":
            result = cmd_unflag(args.msg_id, folder=args.folder)
        elif args.command == "mark_read":
            result = cmd_mark_read(args.msg_id, folder=args.folder)
        elif args.command == "mark_unread":
            result = cmd_mark_unread(args.msg_id, folder=args.folder)
        else:
            parser.print_help()
            sys.exit(1)

        print(json.dumps(result, indent=2, ensure_ascii=False, default=str))

    except Exception as e:
        error_result = {"status": "error", "error_type": type(e).__name__, "message": str(e)}
        print(json.dumps(error_result, indent=2))
        sys.exit(1)

if __name__ == "__main__":
    main()
