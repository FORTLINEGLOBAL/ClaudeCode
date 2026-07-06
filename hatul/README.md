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

## Setup

The password is **never stored in this repo**. It's read from the
`HATUL_SMTP_PASSWORD` environment variable.

```bash
cp .env.example .env      # then edit .env and paste the mailbox password
set -a; source .env; set +a
```

⚠️ If the password was ever shared in plaintext (chat, email, ticket), rotate
it in your mail host's control panel first.

## Usage

```bash
# Simple message
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
| `--dry-run`  | Build and print the message without sending    |

Exit codes: `0` success · `2` missing password · `3` auth failed · `4` send error.
