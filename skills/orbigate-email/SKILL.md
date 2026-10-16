---
name: orbigate-email
description: Send, read, search, reply to, and manage email for eddie@orbigate.com (Eddie's Orbigate account, hosted on Titan) over IMAP/SMTP. Use whenever Eddie mentions orbigate email, orbigate inbox, eddie@orbigate.com, "send from orbigate", "check orbigate mail", or any request to read, send, search, or reply to email on the orbigate.com domain. Do not use Gmail MCP, Superhuman, or the forti-email skill for this account.
---

# Orbigate Email

Manages **eddie@orbigate.com** through `scripts/orbigate_email.py` (Python stdlib only, no installs).
This account is separate from Fortline (`forti-email`) and Flexor. Never mix them.

## Connection

- IMAP: `imap.titan.email:993` (SSL)
- SMTP: `smtp.titan.email:465` (SSL)
- Login: `eddie@orbigate.com`, password from the `ORBIGATE_EMAIL_PASSWORD` environment variable. Never print it, hardcode it, or commit it.
- Titan does not auto-save sent mail. The script appends a copy to the `Sent` folder itself (the JSON result shows `saved_to`).

## Commands

Run `python3 <skill-dir>/scripts/orbigate_email.py <command>`. All output is JSON with `status` of `ok` or `error`.

```bash
inbox -n 20 [--folder INBOX]
read <id>
search 'FROM "john@example.com"'     # any IMAP criteria: UNSEEN, SINCE "01-Jan-2026", TEXT "x"
send --to a@x.com --subject "Hi" --body "Para one.\n\nPara two." [--cc ..] [--bcc ..] [--html] [--attach f1.pdf f2.xlsx]
reply <id> --body "Thanks." [--all]
folders
move <id> "Archive"
delete <id>                          # copies to Trash, then expunges
flag | unflag | mark_read | mark_unread <id>
```

`<id>` is the IMAP UID returned by `inbox` and `search`, scoped to `--folder` (default INBOX).

## Instructions for Claude

1. Pick the operation and run the script directly with Bash.
2. If `ORBIGATE_EMAIL_PASSWORD` is unset, say so and stop. Do not ask for the password in chat.
3. On a connection error (DNS, timeout, refused), the sandbox likely blocks outbound IMAP/SMTP. Give Eddie the exact command to run in his own terminal.
4. Before any send or reply, confirm recipient, subject, and body with Eddie. `delete` and `move` also need confirmation.
5. Separate paragraphs with `\n\n` in `--body`; the script turns them into `<p>` tags. Without them the email is one block of text.
6. Avoid dashes (em, en, or hyphen as separator) in subject and body, to prevent encoding problems. Use commas or periods.
7. If drafting outbound sales or prospect messages, load `writing-guidelines` first.
8. A signature is appended automatically from `scripts/signature.html` if that file exists. Do not write a signature in the body.
9. `read` marks the message as seen. `inbox` and `search` do not.

## Troubleshooting

- **Login failed**: check `ORBIGATE_EMAIL_PASSWORD`; Titan may need an app-specific password if 2FA is on.
- **Cannot open folder**: run `folders` to see exact names (Titan uses `Sent`, `Trash`, `Archive`, `Drafts`).
- **`saved_to` is null after send**: mail was delivered but no Sent copy was filed; check `folders` for the Sent name.
