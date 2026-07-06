# Hatul email sender

Sends email **as the Hatul mailbox** (`eddie@moneyplan.co.il`) — deliberately
**not** from Fortline Global. Pure Python standard library, no dependencies to
install.

## Mailbox settings (baked into `send_email.py`)

| Setting        | Value                     |
| -------------- | ------------------------- |
| Outgoing SMTP  | `mail.moneyplan.co.il`    |
| SMTP port      | `465` (implicit SSL/TLS)  |
| From address   | `eddie@moneyplan.co.il`   |
| From name      | `Hatul`                   |

Recipients see the sender as `Hatul <eddie@moneyplan.co.il>`.

> Incoming mail (IMAP `993` / POP `995`) is for *reading* mail and is handled by
> your mail client, not this sender.

## Signature

Every email is sent as `multipart/alternative` (plain text + HTML) with the
Eddie Nudel signature appended automatically — bold name, VP Marketing title,
gold divider, and the M/E/W/F contact block. Edit `signature.py` to change any
field. Pass `--no-signature` to omit it.

The cat logo is embedded inline from `assets/logo.png` when that file exists
(see `assets/README.md`); otherwise the brand name shows as text.

## Setup (once)

The password is **never stored in this repo**. Put it in a local `.env` file,
which the script loads automatically:

```bash
cp .env.example .env      # then edit .env and paste the mailbox password
```

`.env` is gitignored. That's it — no `export` needed on every run. (An exported
`HATUL_SMTP_PASSWORD` still takes precedence if you set one.)

⚠️ If the password was ever shared in plaintext (chat, email, ticket), rotate
it in your mail host's control panel first.

### Ports

Defaults to `465` (implicit SSL). If your network or host prefers STARTTLS,
add `--port 587`. Force a method explicitly with `--ssl` or `--starttls`.

## Usage

```bash
# Simple message (password comes from .env automatically)
python3 send_email.py \
    --to someone@example.com \
    --subject "Hello from Hatul" \
    --body "Message text here"

# Multiple recipients, body from a file, with an attachment
python3 send_email.py \
    --to a@example.com --to b@example.com \
    --subject "Europe one-pager" \
    --body-file message.txt \
    --attach "../Europe One-Pager.pdf"

# HTML body
python3 send_email.py --to a@example.com --subject Hi --html \
    --body-file "../Europe One-Pager.html"

# Preview what would be sent, without sending or needing the password
python3 send_email.py --to a@example.com --subject Hi --body Hi --dry-run
```

## Options

| Flag         | Meaning                                        |
| ------------ | ---------------------------------------------- |
| `--to`       | Recipient (repeat for multiple)                |
| `--cc`       | CC recipient (repeat for multiple)             |
| `--subject`  | Subject line (required)                        |
| `--body`     | Body text                                      |
| `--body-file`| Read body from a file                          |
| `--html`     | Treat the body as HTML                          |
| `--attach`   | Attach a file (repeat for multiple)            |
| `--reply-to` | Set a Reply-To address                         |
| `--port`     | SMTP port (default `465`; `587` = STARTTLS)    |
| `--ssl` / `--starttls` | Force the TLS method                 |
| `--dry-run`  | Build and print the message without sending    |

Exit codes: `0` success · `2` missing password · `3` auth failed · `4` connection/send error.
