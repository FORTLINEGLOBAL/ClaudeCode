---
name: forti-email
description: >
  Send, read, search, and manage emails for the eddie@fortlineglobal.com account via IMAP/SMTP.
  This is Eddie's Fortline Global email — completely separate from his Flexor/Superhuman email.
  MUST trigger whenever Eddie mentions: 'fortline email', 'forti email', 'forti-email',
  'fortlineglobal email', 'eddie@fortlineglobal', 'send from fortline', 'check fortline inbox',
  'fortline mail', 'read fortline email', 'send email from fortline', 'fortline outgoing mail',
  or any request to read, send, search, reply, or manage emails on the fortlineglobal.com domain.
  Also trigger when Eddie says 'send from my other email', 'the fortline account', 'non-Superhuman email',
  or references fortlineglobal.com in any email context. Do NOT use Superhuman or Gmail MCP for this account.
---

# Forti-Email: Fortline Global Email Management

This skill manages Eddie's **eddie@fortlineglobal.com** email account via direct IMAP/SMTP connection.
This is completely separate from his Flexor email (which uses Superhuman). Never mix the two.

## How It Works

The skill uses a Python script (`scripts/forti_email.py`) that connects directly to Gmail's servers
using Python's built-in `imaplib` and `smtplib` libraries. No external dependencies needed.

**Important sandbox limitation**: The Cowork sandbox blocks outbound TCP connections (including IMAP/SMTP).
When running inside Cowork, generate the Python command and tell Eddie to run it in his own terminal.
When running in Claude Code or a non-sandboxed environment, execute the script directly.

## Connection Details

- **Email**: eddie@fortlineglobal.com
- **IMAP**: imap.gmail.com:993 (SSL)
- **SMTP**: smtp.gmail.com:587 (STARTTLS)
- **Auth**: Username + password (embedded in script config)
- **Note**: Gmail automatically saves sent messages — no manual Sent folder save needed.

## Available Operations

### Reading & Searching

**List recent inbox messages:**
```bash
python3 forti_email.py inbox -n 20
```

**Read a specific email by ID:**
```bash
python3 forti_email.py read <msg_id>
```

**Search emails (IMAP search syntax):**
```bash
python3 forti_email.py search 'FROM "john@example.com"'
python3 forti_email.py search 'SUBJECT "meeting"'
python3 forti_email.py search 'SINCE "01-Jan-2025"'
python3 forti_email.py search 'UNSEEN'
python3 forti_email.py search 'FROM "john" SUBJECT "project"'
python3 forti_email.py search 'TEXT "quarterly report"'
```

### Sending & Replying

**Send a new email:**
```bash
python3 forti_email.py send --to "recipient@example.com" --subject "Subject here" --body "Email body"
python3 forti_email.py send --to "a@x.com" --cc "b@x.com" --subject "Hi" --body "Hello" --html
python3 forti_email.py send --to "a@x.com" --subject "Report" --body "Attached." --attach file1.pdf file2.xlsx
```

**Reply to an email:**
```bash
python3 forti_email.py reply <msg_id> --body "Thanks for the update."
python3 forti_email.py reply <msg_id> --body "Noted." --all  # reply-all
```

### Folder Management

**List all folders:**
```bash
python3 forti_email.py folders
```

**Move a message:**
```bash
python3 forti_email.py move <msg_id> "Archive"
```

### Message Actions

```bash
python3 forti_email.py delete <msg_id>
python3 forti_email.py flag <msg_id>
python3 forti_email.py unflag <msg_id>
python3 forti_email.py mark_read <msg_id>
python3 forti_email.py mark_unread <msg_id>
```

## How to Use This Skill (Instructions for Claude)

1. **Determine the operation** Eddie needs (read, send, search, etc.)
2. **Try running the script directly first** using Bash:
   ```bash
   python3 <path-to-skill>/scripts/forti_email.py <command> [args]
   ```
3. **If it fails with a connection error** (DNS resolution, timeout, connection refused), the sandbox is blocking it. In that case:
   - Generate the exact Python command Eddie should run
   - Tell Eddie: "The Cowork sandbox blocks outbound email connections. Run this in your terminal:"
   - Provide the command with the full script path
4. **Parse the JSON output** — all commands return JSON with a `status` field ("ok" or "error")
5. **Present results cleanly** — format inbox listings as readable summaries, show email bodies with proper formatting

### When sending emails on behalf of Eddie:
- Always confirm the recipient, subject, and body with Eddie before sending
- Load the `writing-guidelines` skill if drafting outbound prospect/sales messages
- **No dashes of any kind** (em-dash, en-dash, hyphens as separators) in subject lines or body text. These cause UTF-8 encoding corruption in email clients. Use commas, periods, or restructure the sentence instead.
- **CRITICAL: Paragraph formatting.** The body text MUST use `\n\n` (literal backslash-n backslash-n) between paragraphs when passed via the CLI `--body` argument. The script converts these into `<p>` tags for proper HTML rendering. Without `\n\n` separators, the email will render as one giant wall of text with no paragraph breaks. Example: `--body "Dear Mr. Smith,\n\nFirst paragraph here.\n\nSecond paragraph here.\n\nThanks, Eddie Nudel"`
- The "From" address will always be `Eddie <eddie@fortlineglobal.com>`
- **Signature is automatic**: The script appends Eddie's branded HTML signature to every outgoing email (send and reply). Do NOT add a signature in the body text — it's already handled. The signature includes: Fortline logo, name, title, both phone numbers (US & IL), email, website, LinkedIn (linkedin.com/in/eddienudel), and the tagline "Defense-Grade Protection Technology".

### Programmatic usage (for other skills):
You can also import the functions directly in Python:
```python
import sys
sys.path.insert(0, "<path-to-skill>/scripts")
from forti_email import cmd_inbox, cmd_read, cmd_send, cmd_search, cmd_reply, cmd_folders
```

## Troubleshooting

- **DNS resolution failure**: Sandbox is blocking — provide command for Eddie's terminal
- **Login failed**: If using Google Workspace with 2FA, a Gmail App Password may be required instead of the account password. Ask Eddie to generate one at myaccount.google.com → Security → App Passwords.
- **Timeout**: Server might be down or port blocked — try again
- **SSL error**: Certificate issue — check ssl context settings
- **"Less secure app" error**: Gmail may require an App Password if 2-step verification is enabled on the account
