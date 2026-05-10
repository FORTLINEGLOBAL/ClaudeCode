"""
forti-email backend — IMAP/SMTP REST API for Fortline Global
Exposes: POST /send, GET /inbox/scan, GET /thread/{message_id}
Auth: X-API-Key header
"""

from __future__ import annotations

import email
import email.mime.multipart
import email.mime.text
import imaplib
import os
import re
import smtplib
import ssl
import time
import uuid
from datetime import datetime, timezone
from email.header import decode_header
from email.utils import parseaddr, parsedate_to_datetime
from typing import Any

from fastapi import Depends, FastAPI, HTTPException, Security, status
from fastapi.security.api_key import APIKeyHeader
from pydantic import BaseModel, EmailStr

# ---------------------------------------------------------------------------
# Configuration (loaded exclusively from environment variables)
# ---------------------------------------------------------------------------

FORTI_EMAIL_USER: str = os.environ["FORTI_EMAIL_USER"]          # eddie@fortlineglobal.com
FORTI_EMAIL_PASSWORD: str = os.environ["FORTI_EMAIL_PASSWORD"]
FORTI_SMTP_HOST: str = os.environ.get("FORTI_SMTP_HOST", "mail.fortlineglobal.com")
FORTI_SMTP_PORT: int = int(os.environ.get("FORTI_SMTP_PORT", "587"))
FORTI_IMAP_HOST: str = os.environ.get("FORTI_IMAP_HOST", "mail.fortlineglobal.com")
FORTI_IMAP_PORT: int = int(os.environ.get("FORTI_IMAP_PORT", "993"))
FORTI_EMAIL_API_KEY: str = os.environ["FORTI_EMAIL_API_KEY"]    # dashboard-only API key

# ---------------------------------------------------------------------------
# FastAPI app
# ---------------------------------------------------------------------------

app = FastAPI(
    title="forti-email",
    description="IMAP/SMTP relay for Fortline Global outreach. Dashboard-only.",
    version="1.0.0",
    docs_url=None,   # disable Swagger in production
    redoc_url=None,
)

_api_key_header = APIKeyHeader(name="X-API-Key", auto_error=True)


def _require_api_key(api_key: str = Security(_api_key_header)) -> None:
    if api_key != FORTI_EMAIL_API_KEY:
        raise HTTPException(status_code=status.HTTP_403_FORBIDDEN, detail="Invalid API key")


# ---------------------------------------------------------------------------
# SMTP send
# ---------------------------------------------------------------------------

class SendRequest(BaseModel):
    to: EmailStr
    subject: str
    body: str          # plain text
    draft_id: str      # UUID, for State DB correlation


class SendResponse(BaseModel):
    message_id: str
    sent_at: str       # ISO 8601


@app.post("/send", response_model=SendResponse, dependencies=[Depends(_require_api_key)])
def send_email(req: SendRequest) -> SendResponse:
    """
    Send a single email from eddie@fortlineglobal.com via SMTP.
    Called exclusively by the dashboard after Eddie clicks Approve → Send.
    """
    msg = email.mime.multipart.MIMEMultipart("alternative")
    msg["From"] = FORTI_EMAIL_USER
    msg["To"] = req.to
    msg["Subject"] = req.subject

    # Unique Message-ID for IMAP reply matching
    domain = FORTI_EMAIL_USER.split("@")[-1]
    message_id = f"<{uuid.uuid4().hex}@{domain}>"
    msg["Message-ID"] = message_id

    msg.attach(email.mime.text.MIMEText(req.body, "plain", "utf-8"))

    context = ssl.create_default_context()
    retries = 0
    last_exc: Exception | None = None

    while retries < 3:
        try:
            with smtplib.SMTP(FORTI_SMTP_HOST, FORTI_SMTP_PORT, timeout=30) as smtp:
                smtp.ehlo()
                smtp.starttls(context=context)
                smtp.login(FORTI_EMAIL_USER, FORTI_EMAIL_PASSWORD)
                smtp.sendmail(FORTI_EMAIL_USER, req.to, msg.as_bytes())
            sent_at = datetime.now(timezone.utc).isoformat()
            return SendResponse(message_id=message_id, sent_at=sent_at)
        except smtplib.SMTPException as exc:
            last_exc = exc
            retries += 1
            time.sleep(2 ** retries)

    raise HTTPException(
        status_code=status.HTTP_502_BAD_GATEWAY,
        detail=f"SMTP delivery failed after {retries} attempts: {last_exc}",
    )


# ---------------------------------------------------------------------------
# IMAP helpers
# ---------------------------------------------------------------------------

def _imap_connect() -> imaplib.IMAP4_SSL:
    conn = imaplib.IMAP4_SSL(FORTI_IMAP_HOST, FORTI_IMAP_PORT)
    conn.login(FORTI_EMAIL_USER, FORTI_EMAIL_PASSWORD)
    return conn


def _decode_header_value(value: str | None) -> str:
    if not value:
        return ""
    parts = decode_header(value)
    result = []
    for chunk, charset in parts:
        if isinstance(chunk, bytes):
            result.append(chunk.decode(charset or "utf-8", errors="replace"))
        else:
            result.append(chunk)
    return "".join(result)


def _get_plain_body(msg: email.message.Message) -> str:
    if msg.is_multipart():
        for part in msg.walk():
            if part.get_content_type() == "text/plain" and "attachment" not in str(
                part.get("Content-Disposition", "")
            ):
                payload = part.get_payload(decode=True)
                charset = part.get_content_charset() or "utf-8"
                return payload.decode(charset, errors="replace")  # type: ignore[union-attr]
    else:
        payload = msg.get_payload(decode=True)
        if payload:
            charset = msg.get_content_charset() or "utf-8"
            return payload.decode(charset, errors="replace")  # type: ignore[union-attr]
    return ""


# ---------------------------------------------------------------------------
# IMAP inbox scan
# ---------------------------------------------------------------------------

class ReplyMatch(BaseModel):
    original_message_id: str
    reply_message_id: str
    from_address: str
    from_name: str
    subject: str
    received_at: str
    snippet: str


class InboxScanResponse(BaseModel):
    scanned_count: int
    reply_matches: list[ReplyMatch]


@app.get("/inbox/scan", response_model=InboxScanResponse, dependencies=[Depends(_require_api_key)])
def scan_inbox(days: int = 1) -> InboxScanResponse:
    """
    Scan the INBOX for recent messages that are replies to Fortline-sent emails.
    Returns matched replies keyed by the original Message-ID.
    Runs every 30 minutes via a cron job or dashboard poll.
    """
    conn = _imap_connect()
    try:
        conn.select("INBOX")
        # Search unseen messages from the last `days` days
        since_date = datetime.now(timezone.utc)
        since_str = since_date.strftime("%d-%b-%Y")
        _, data = conn.search(None, f"(SINCE {since_str})")
        message_ids = data[0].split() if data[0] else []

        matches: list[ReplyMatch] = []

        for num in message_ids:
            _, msg_data = conn.fetch(num, "(RFC822)")
            if not msg_data or not msg_data[0]:
                continue
            raw = msg_data[0][1]
            if not isinstance(raw, bytes):
                continue

            msg = email.message_from_bytes(raw)
            in_reply_to = msg.get("In-Reply-To", "").strip()
            references = msg.get("References", "").strip()

            # Match if this is a reply to a Fortline-sent message
            domain = FORTI_EMAIL_USER.split("@")[-1]
            is_reply = (
                re.search(rf"@{re.escape(domain)}", in_reply_to)
                or re.search(rf"@{re.escape(domain)}", references)
            )
            if not is_reply:
                continue

            from_name, from_address = parseaddr(msg.get("From", ""))
            try:
                received_at = parsedate_to_datetime(msg.get("Date", "")).isoformat()
            except Exception:
                received_at = datetime.now(timezone.utc).isoformat()

            body = _get_plain_body(msg)
            snippet = body[:200].replace("\n", " ").strip()
            original_id = in_reply_to or references.split()[-1]

            matches.append(
                ReplyMatch(
                    original_message_id=original_id,
                    reply_message_id=msg.get("Message-ID", ""),
                    from_address=from_address,
                    from_name=_decode_header_value(from_name),
                    subject=_decode_header_value(msg.get("Subject", "")),
                    received_at=received_at,
                    snippet=snippet,
                )
            )

        return InboxScanResponse(scanned_count=len(message_ids), reply_matches=matches)
    finally:
        try:
            conn.logout()
        except Exception:
            pass


# ---------------------------------------------------------------------------
# Full thread fetch
# ---------------------------------------------------------------------------

class ThreadMessage(BaseModel):
    message_id: str
    direction: str       # 'sent' or 'received'
    from_address: str
    to_address: str
    subject: str
    body: str
    sent_at: str


class ThreadResponse(BaseModel):
    original_message_id: str
    messages: list[ThreadMessage]


@app.get(
    "/thread/{original_message_id:path}",
    response_model=ThreadResponse,
    dependencies=[Depends(_require_api_key)],
)
def get_thread(original_message_id: str) -> ThreadResponse:
    """
    Fetch all messages in a thread by the original sent message-id.
    Searches both INBOX (received) and Sent folder.
    """
    messages: list[dict[str, Any]] = []
    search_query = f'(HEADER "Message-ID" "{original_message_id}")'
    search_references = f'(OR (HEADER "In-Reply-To" "{original_message_id}") (HEADER "References" "{original_message_id}"))'

    conn = _imap_connect()
    try:
        folders_to_search = [
            ("INBOX", "received"),
            ("Sent", "sent"),
            ("Sent Items", "sent"),
            ("Sent Messages", "sent"),
        ]

        for folder, direction in folders_to_search:
            try:
                status_code, _ = conn.select(f'"{folder}"', readonly=True)
                if status_code != "OK":
                    continue
            except Exception:
                continue

            query = search_query if direction == "sent" else search_references
            _, data = conn.search(None, query)
            nums = data[0].split() if data[0] else []

            for num in nums:
                _, msg_data = conn.fetch(num, "(RFC822)")
                if not msg_data or not msg_data[0]:
                    continue
                raw = msg_data[0][1]
                if not isinstance(raw, bytes):
                    continue
                msg = email.message_from_bytes(raw)
                try:
                    sent_at = parsedate_to_datetime(msg.get("Date", "")).isoformat()
                except Exception:
                    sent_at = ""
                messages.append(
                    {
                        "message_id": msg.get("Message-ID", ""),
                        "direction": direction,
                        "from_address": parseaddr(msg.get("From", ""))[1],
                        "to_address": parseaddr(msg.get("To", ""))[1],
                        "subject": _decode_header_value(msg.get("Subject", "")),
                        "body": _get_plain_body(msg),
                        "sent_at": sent_at,
                    }
                )

        messages.sort(key=lambda m: m.get("sent_at", ""))
        return ThreadResponse(
            original_message_id=original_message_id,
            messages=[ThreadMessage(**m) for m in messages],
        )
    finally:
        try:
            conn.logout()
        except Exception:
            pass


# ---------------------------------------------------------------------------
# Health check
# ---------------------------------------------------------------------------

@app.get("/health")
def health() -> dict[str, str]:
    return {"status": "ok", "service": "forti-email"}
