#!/usr/bin/env python3
"""Send email for the Hatul project as eddie@moneyplan.co.il.

This intentionally sends from the Hatul (moneyplan.co.il) mailbox, NOT from
Fortline Global. Server/port/from-address are fixed below; the password is
read from the HATUL_SMTP_PASSWORD environment variable and is never stored in
this repository.

Setup once: put the password in hatul/.env (see .env.example) as
    HATUL_SMTP_PASSWORD=your-password
It is loaded automatically; an exported env var of the same name still wins.

Usage:
    python3 send_email.py \
        --to someone@example.com \
        --subject "Hello from Hatul" \
        --body "Message text here"

    # From a file, with attachments, to multiple recipients:
    python3 send_email.py --to a@x.com --to b@y.com \
        --subject "Europe one-pager" \
        --body-file message.txt \
        --attach "../Europe One-Pager.pdf"

    # Preview without sending:
    python3 send_email.py --to a@x.com --subject Hi --body Hi --dry-run
"""
from __future__ import annotations

import argparse
import html
import mimetypes
import os
import smtplib
import ssl
import sys
from email.message import EmailMessage
from pathlib import Path

import signature as signature_mod

# --- Hatul mailbox configuration (moneyplan.co.il, NOT Fortline) -------------
SMTP_HOST = "mail.moneyplan.co.il"
SMTP_PORT = 465  # implicit SSL/TLS
FROM_ADDRESS = "eddie@moneyplan.co.il"
FROM_NAME = "Hatul"  # recipients see "Hatul <eddie@moneyplan.co.il>"
PASSWORD_ENV_VAR = "HATUL_SMTP_PASSWORD"
CONNECT_TIMEOUT = 30  # seconds

HERE = Path(__file__).resolve().parent

# Inline logo for the HTML signature. If this file exists it is embedded in the
# message and referenced from the signature by this Content-ID.
LOGO_PATH = HERE / "assets" / "logo.png"
LOGO_CID = "hatul-logo"


def load_env_file(path: Path) -> None:
    """Load simple KEY=VALUE lines from a .env file into os.environ.

    Existing environment variables take precedence, so an explicit `export`
    still wins. Missing file is a no-op.
    """
    if not path.is_file():
        return
    for raw in path.read_text(encoding="utf-8").splitlines():
        line = raw.strip()
        if not line or line.startswith("#") or "=" not in line:
            continue
        key, _, value = line.partition("=")
        key = key.strip()
        value = value.strip().strip('"').strip("'")
        if key and key not in os.environ:
            os.environ[key] = value


def build_message(args: argparse.Namespace) -> EmailMessage:
    if args.body_file:
        body = Path(args.body_file).read_text(encoding="utf-8")
    elif args.body is not None:
        body = args.body
    else:
        body = sys.stdin.read()

    msg = EmailMessage()
    msg["From"] = f"{FROM_NAME} <{FROM_ADDRESS}>"
    msg["To"] = ", ".join(args.to)
    if args.cc:
        msg["Cc"] = ", ".join(args.cc)
    msg["Subject"] = args.subject
    if args.reply_to:
        msg["Reply-To"] = args.reply_to

    # Every message is multipart/alternative: a plain-text part for clients
    # that can't render HTML, and an HTML part carrying the styled signature.
    embed_logo = not args.no_signature and LOGO_PATH.is_file()
    logo_cid = LOGO_CID if embed_logo else None

    # HTML body: use as-is when --html, otherwise escape the plain text.
    if args.html:
        html_body = body
    else:
        html_body = html.escape(body).replace("\n", "<br>\n")

    text_part = body if args.no_signature else body + signature_mod.TEXT_SIGNATURE
    html_part_body = (html_body if args.no_signature
                      else html_body + signature_mod.html_signature(logo_cid))

    msg.set_content(text_part)
    msg.add_alternative(html_part_body, subtype="html")
    if embed_logo:
        msg.get_payload()[-1].add_related(
            LOGO_PATH.read_bytes(), "image", "png", cid=f"<{LOGO_CID}>")

    for path_str in args.attach:
        path = Path(path_str)
        if not path.is_file():
            raise FileNotFoundError(f"Attachment not found: {path}")
        ctype, encoding = mimetypes.guess_type(path.name)
        if ctype is None or encoding is not None:
            ctype = "application/octet-stream"
        maintype, subtype = ctype.split("/", 1)
        msg.add_attachment(
            path.read_bytes(),
            maintype=maintype,
            subtype=subtype,
            filename=path.name,
        )
    return msg


def parse_args(argv: list[str] | None = None) -> argparse.Namespace:
    p = argparse.ArgumentParser(
        description="Send email as the Hatul mailbox (eddie@moneyplan.co.il)."
    )
    p.add_argument("--to", action="append", required=True,
                   help="Recipient (repeatable).")
    p.add_argument("--cc", action="append", default=[],
                   help="CC recipient (repeatable).")
    p.add_argument("--subject", required=True, help="Email subject.")
    body_group = p.add_mutually_exclusive_group()
    body_group.add_argument("--body", help="Message body text.")
    body_group.add_argument("--body-file", help="Read body from this file.")
    p.add_argument("--html", action="store_true",
                   help="Body is already HTML (skip escaping). The signature "
                        "is always sent as HTML regardless.")
    p.add_argument("--attach", action="append", default=[],
                   help="File to attach (repeatable).")
    p.add_argument("--reply-to", help="Reply-To address.")
    p.add_argument("--no-signature", action="store_true",
                   help="Do not append the Eddie Nudel signature.")
    p.add_argument("--port", type=int, default=SMTP_PORT,
                   help=f"SMTP port (default {SMTP_PORT}). 465=SSL, "
                        f"587=STARTTLS; the method is chosen from the port "
                        f"unless overridden.")
    tls = p.add_mutually_exclusive_group()
    tls.add_argument("--ssl", dest="method", action="store_const", const="ssl",
                     help="Force implicit SSL/TLS (typical for port 465).")
    tls.add_argument("--starttls", dest="method", action="store_const",
                     const="starttls",
                     help="Force STARTTLS (typical for port 587).")
    p.add_argument("--dry-run", action="store_true",
                   help="Build and print the message without sending.")
    p.set_defaults(method=None)
    return p.parse_args(argv)


def send(msg: EmailMessage, recipients: list[str], password: str,
         host: str, port: int, method: str | None) -> None:
    """Deliver msg over SSL or STARTTLS depending on port/method."""
    if method is None:
        method = "starttls" if port == 587 else "ssl"
    context = ssl.create_default_context()
    if method == "ssl":
        with smtplib.SMTP_SSL(host, port, timeout=CONNECT_TIMEOUT,
                              context=context) as server:
            server.login(FROM_ADDRESS, password)
            server.send_message(msg, from_addr=FROM_ADDRESS,
                                to_addrs=recipients)
    else:
        with smtplib.SMTP(host, port, timeout=CONNECT_TIMEOUT) as server:
            server.ehlo()
            server.starttls(context=context)
            server.ehlo()
            server.login(FROM_ADDRESS, password)
            server.send_message(msg, from_addr=FROM_ADDRESS,
                                to_addrs=recipients)


def main(argv: list[str] | None = None) -> int:
    args = parse_args(argv)

    # Auto-load the password from hatul/.env so no manual `export` is needed.
    load_env_file(HERE / ".env")

    method = args.method or ("starttls" if args.port == 587 else "ssl")
    all_recipients = list(args.to) + list(args.cc)
    msg = build_message(args)

    if args.dry_run:
        print("--- DRY RUN (not sent) ---")
        print(f"SMTP:       {SMTP_HOST}:{args.port} ({method.upper()})")
        print(f"From:       {msg['From']}")
        print(f"To:         {msg['To']}")
        if msg["Cc"]:
            print(f"Cc:         {msg['Cc']}")
        print(f"Subject:    {msg['Subject']}")
        print(f"Recipients: {', '.join(all_recipients)}")
        if args.attach:
            print(f"Attachments: {', '.join(args.attach)}")
        return 0

    password = os.environ.get(PASSWORD_ENV_VAR)
    if not password:
        sys.stderr.write(
            f"ERROR: no password found. Put it in {HERE / '.env'} as\n"
            f"    {PASSWORD_ENV_VAR}=your-password\n"
            f"or export {PASSWORD_ENV_VAR} before running.\n"
        )
        return 2

    try:
        send(msg, all_recipients, password, SMTP_HOST, args.port, args.method)
    except smtplib.SMTPAuthenticationError:
        sys.stderr.write(
            "ERROR: authentication failed (wrong username/password, or the "
            "mailbox blocks this login). Check the password.\n"
        )
        return 3
    except (TimeoutError, ConnectionError, OSError) as exc:
        sys.stderr.write(
            f"ERROR: could not reach {SMTP_HOST}:{args.port} ({exc}).\n"
            f"  - Check you are on a network that can reach the mail server.\n"
            f"  - If port {args.port} is blocked, try the other one: "
            f"--port {'587' if args.port == 465 else '465'}\n"
        )
        return 4
    except smtplib.SMTPException as exc:
        sys.stderr.write(f"ERROR sending mail: {exc}\n")
        return 4

    print(f"Sent as {msg['From']} to {', '.join(all_recipients)} "
          f"via {SMTP_HOST}:{args.port} ({method.upper()})")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
