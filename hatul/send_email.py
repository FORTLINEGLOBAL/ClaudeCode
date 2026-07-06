#!/usr/bin/env python3
"""Send email for the Hatul project as eddie@moneyplan.co.il.

This intentionally sends from the Hatul (moneyplan.co.il) mailbox, NOT from
Fortline Global. Server/port/from-address are fixed below; the password is
read from the HATUL_SMTP_PASSWORD environment variable and is never stored in
this repository.

Usage:
    export HATUL_SMTP_PASSWORD='...'        # do NOT commit this
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
import mimetypes
import os
import smtplib
import ssl
import sys
from email.message import EmailMessage
from pathlib import Path

# --- Hatul mailbox configuration (moneyplan.co.il, NOT Fortline) -------------
SMTP_HOST = "mail.moneyplan.co.il"
SMTP_PORT = 465  # implicit SSL/TLS
FROM_ADDRESS = "eddie@moneyplan.co.il"
FROM_NAME = "Hatul"  # recipients see "Hatul <eddie@moneyplan.co.il>"
PASSWORD_ENV_VAR = "HATUL_SMTP_PASSWORD"


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

    if args.html:
        msg.set_content("This message requires an HTML-capable email client.")
        msg.add_alternative(body, subtype="html")
    else:
        msg.set_content(body)

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
                   help="Treat the body as HTML.")
    p.add_argument("--attach", action="append", default=[],
                   help="File to attach (repeatable).")
    p.add_argument("--reply-to", help="Reply-To address.")
    p.add_argument("--dry-run", action="store_true",
                   help="Build and print the message without sending.")
    return p.parse_args(argv)


def main(argv: list[str] | None = None) -> int:
    args = parse_args(argv)

    all_recipients = list(args.to) + list(args.cc)
    msg = build_message(args)

    if args.dry_run:
        print("--- DRY RUN (not sent) ---")
        print(f"SMTP:       {SMTP_HOST}:{SMTP_PORT} (SSL)")
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
            f"ERROR: set the {PASSWORD_ENV_VAR} environment variable with the "
            f"{FROM_ADDRESS} mailbox password before sending.\n"
        )
        return 2

    context = ssl.create_default_context()
    try:
        with smtplib.SMTP_SSL(SMTP_HOST, SMTP_PORT, context=context) as server:
            server.login(FROM_ADDRESS, password)
            server.send_message(msg, from_addr=FROM_ADDRESS,
                                to_addrs=all_recipients)
    except smtplib.SMTPAuthenticationError:
        sys.stderr.write(
            "ERROR: authentication failed. Check the mailbox password in "
            f"{PASSWORD_ENV_VAR}.\n"
        )
        return 3
    except (smtplib.SMTPException, OSError) as exc:
        sys.stderr.write(f"ERROR sending mail: {exc}\n")
        return 4

    print(f"Sent as {msg['From']} to {', '.join(all_recipients)}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
