# Skill: forti-email — Email Send Pipeline

This skill is invoked by the dashboard send flow, not by agents directly.
Agents write drafts. Humans approve them. The dashboard calls the forti-email backend to send.

---

## Send flow (dashboard → backend → SMTP)

1. User clicks "Approve" on a draft in the dashboard.
2. Dashboard opens the send modal: choose channel (Email or LinkedIn copy-paste).
3. For Email: dashboard calls `POST /send` on the forti-email backend.
4. Backend authenticates with the IMAP/SMTP server using `FORTI_EMAIL_USER` + `FORTI_EMAIL_PASSWORD` credentials (from env, never in agent context).
5. Backend sends via SMTP, returns `message_id`.
6. Dashboard marks draft `status = 'sent'`, records `sent_at`.
7. IMAP poller (`GET /inbox/scan`) runs every 30 minutes, matches replies by `In-Reply-To` header, updates `replied_at` and `reply_sentiment`.

---

## Backend endpoints

### POST /send
```json
{
  "to": "recipient@example.com",
  "subject": "Subject line",
  "body": "Plain text email body",
  "draft_id": "uuid"
}
```
Returns: `{"message_id": "...", "sent_at": "ISO8601"}`

### GET /inbox/scan
Scans inbox for replies to sent threads (last 24h by default).
Returns: list of matched threads with reply metadata.

### GET /thread/{message_id}
Fetches the full email thread by original message-id.
Returns: thread messages in chronological order.

---

## Authentication

All backend calls require `X-API-Key` header. Key stored in `FORTI_EMAIL_API_KEY` env var.
Never expose SMTP credentials outside the backend process.

---

## Important constraints

- This backend is exclusively for `eddie@fortlineglobal.com`. Never connect to any other account.
- Zero auto-sends. Every send is explicitly triggered by a human action in the dashboard.
- Do not share this backend or its credentials with any Flexor system.
- SMTP credentials are loaded from environment variables only:
  - `FORTI_EMAIL_USER` = `eddie@fortlineglobal.com`
  - `FORTI_EMAIL_PASSWORD` = IMAP/SMTP password
  - `FORTI_SMTP_HOST`, `FORTI_SMTP_PORT`
  - `FORTI_IMAP_HOST`, `FORTI_IMAP_PORT`
