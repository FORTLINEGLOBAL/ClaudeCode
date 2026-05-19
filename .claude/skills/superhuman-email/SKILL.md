---
name: superhuman-email
description: Automatically use Superhuman MCP to handle all email operations. Trigger whenever the user mentions emails in any context - sending, drafting, composing, writing emails, searching inbox, finding messages, replying, forwarding, archiving, deleting, starring, snoozing, labeling emails, or any email-related action. Also trigger when user mentions "send to [email]", "email [person]", "check my inbox", "search for email about [topic]", "reply to [person]", "forward this to [person]", or any variation of email tasks. This skill uses the Superhuman MCP server to execute email operations directly through the Superhuman app.
---

# Superhuman Email Handler

You have access to Superhuman email management through MCP tools. Use these tools whenever the user asks to perform any email-related action.

## When to Use This Skill

Trigger this skill for ANY email-related request, including:
- **Sending emails**: "send email to [address]", "email [person] about [topic]"
- **Drafting emails**: "draft an email", "write an email to [person]", "compose a message"
- **Searching inbox**: "search my emails", "find emails from [person]", "look for emails about [topic]"
- **Reading emails**: "show me my inbox", "what emails do I have", "read my recent emails"
- **Replying**: "reply to [person]", "respond to that email", "reply all"
- **Forwarding**: "forward this to [person]", "send this email to [person]"
- **Managing emails**: "archive that email", "delete this message", "star this email", "snooze until tomorrow"
- **Organizing**: "label this as [category]", "move to [folder]"
- **Calendar**: "schedule a meeting", "check my calendar", "when am I free"

## Available Superhuman MCP Tools

### Email Composition
- `superhuman_draft`: Create an email draft
- `superhuman_send`: Send an email immediately
- `superhuman_reply`: Reply to an email thread
- `superhuman_reply_all`: Reply-all to an email thread
- `superhuman_forward`: Forward an email thread

### Inbox Management
- `superhuman_inbox`: List recent emails from inbox
- `superhuman_search`: Search emails by query
- `superhuman_read`: Read a specific email thread by ID

### Email Organization
- `superhuman_archive`: Archive email threads
- `superhuman_delete`: Delete (trash) email threads
- `superhuman_star`: Star email threads
- `superhuman_unstar`: Unstar email threads
- `superhuman_snooze`: Snooze email threads until a specific time
- `superhuman_unsnooze`: Unsnooze email threads
- `superhuman_mark_read`: Mark threads as read
- `superhuman_mark_unread`: Mark threads as unread

### Labels & Folders
- `superhuman_labels`: List all available labels/folders
- `superhuman_get_labels`: Get labels on a specific thread
- `superhuman_add_label`: Add a label to threads
- `superhuman_remove_label`: Remove a label from threads

### Starred & Snoozed
- `superhuman_starred`: List all starred threads
- `superhuman_snoozed`: List all snoozed threads

### Attachments
- `superhuman_attachments`: List attachments in a thread
- `superhuman_download_attachment`: Download a specific attachment

### Calendar
- `superhuman_calendar_list`: List calendar events
- `superhuman_calendar_create`: Create a new calendar event
- `superhuman_calendar_update`: Update an existing event
- `superhuman_calendar_delete`: Delete a calendar event
- `superhuman_calendar_free_busy`: Check free/busy availability

### Snippets & AI
- `superhuman_snippets`: List all snippets (email templates)
- `superhuman_snippet`: Use a snippet to compose an email
- `superhuman_ask_ai`: Ask Superhuman AI to search or compose

### Account Management
- `superhuman_accounts`: List all linked email accounts
- `superhuman_switch_account`: Switch to a different email account

## Workflow Patterns

### Sending vs Drafting

When the user asks to send an email, **ask for clarification** whether to:
1. Send immediately using `superhuman_send`
2. Create a draft for review using `superhuman_draft`

**Example:**
```
User: "Send an email to john@example.com about the meeting"
You: "Would you like me to:
1. Send the email immediately, or
2. Create a draft for you to review first?"
```

Only send immediately if the user explicitly says "send" or confirms after you ask.

### Searching and Reading

When searching for emails:
1. Use `superhuman_search` with relevant query
2. Present results to user with thread IDs
3. If user wants to read a specific email, use `superhuman_read` with the thread ID

**Example:**
```
User: "Find emails from Sarah about the project"
1. Call superhuman_search(query="from:sarah project")
2. Show results with subject lines and thread IDs
3. If user says "read the first one", call superhuman_read(threadId=...)
```

### Replying and Forwarding

When replying or forwarding:
1. First identify the thread (via search or recent inbox)
2. Ask if they want to draft or send immediately
3. Use `superhuman_reply`, `superhuman_reply_all`, or `superhuman_forward`

**Note:** These tools support a `send` parameter:
- `send=false` (default): Creates a draft
- `send=true`: Sends immediately

### Managing Multiple Emails

Many tools accept arrays of thread IDs for batch operations:
- `superhuman_archive(threadIds=[...])`
- `superhuman_delete(threadIds=[...])`
- `superhuman_star(threadIds=[...])`

**Example:**
```
User: "Archive all emails from yesterday about the budget"
1. Search for matching emails
2. Extract thread IDs
3. Call superhuman_archive with all thread IDs at once
```

### Calendar Integration

When the user mentions meetings or scheduling:
1. Use `superhuman_calendar_list` to show upcoming events
2. Use `superhuman_calendar_create` to schedule new meetings
3. Use `superhuman_calendar_free_busy` to find available time slots

### Snoozing Emails

The `superhuman_snooze` tool supports preset times:
- `"tomorrow"`: Tomorrow morning
- `"next-week"`: Next Monday
- `"weekend"`: Next Saturday
- `"evening"`: Today evening
- Or ISO datetime: `"2026-02-15T14:00:00Z"`

### Using Snippets

Snippets are reusable email templates. To use them:
1. Use `superhuman_snippets` to list available templates
2. Use `superhuman_snippet` with fuzzy name matching to compose from template
3. Variables can be passed as `vars="name=John,company=Acme"`

### AI Assistant

The `superhuman_ask_ai` tool can:
- Search emails with natural language queries
- Answer questions about email threads
- Compose drafts from descriptions

**Example:**
```
User: "What did the team say about the deadline?"
Call superhuman_ask_ai(query="what did the team say about the deadline")
```

## CRITICAL: Character Encoding in Superhuman

Superhuman's API has a known issue where certain Unicode characters get corrupted during sending. The most common offender is the em-dash character "—" (U+2014), which renders in the recipient's inbox as garbled text: "Ã¢Â€Â"". The en-dash "–" (U+2013) has the same problem.

**Before sending any email via `superhuman_send`, `superhuman_reply`, or `superhuman_forward`:**
1. Scan the subject line AND body for em-dashes (—), en-dashes (–), and any hyphens used as clause separators
2. Replace ALL of them with commas, periods, or restructure the sentence
3. Also avoid CDATA wrappers in HTML body content, as these can leak closing tags into rendered emails
4. Stick to basic ASCII punctuation in subject lines: commas, periods, colons, question marks, exclamation points

This is not optional. A garbled subject line like "Trade data + AI at Scotia Ã¢Â€Â" thought this was worth a note" makes the sender look unprofessional and undermines the entire outreach effort.

## CRITICAL: Hook Verification Before Sending Outreach Emails

When sending outreach, prospecting, or sales emails via `superhuman_send`, every factual personalization hook in the email body must be verified BEFORE sending. This applies to any email that references company news, metrics, partnerships, hiring numbers, product launches, or executive appointments as a way to personalize the message.

**Pre-send verification gate:**

1. Identify every factual claim in the email body that goes beyond the recipient's name and title
2. For each claim, confirm via web search that:
   - The fact is real and from a credible public source
   - It belongs to the correct company (not a competitor)
   - **The source MUST be dated within 3 months of today. Hard block, no exceptions.** If the source is older than 3 months, the hook is DEAD. Do not send the email with that hook. Do not soften it. Do not rephrase it. Remove the hook entirely and replace with a role-based or CRM-based hook before sending.
3. If any claim fails verification OR is older than 3 months, do NOT send. Remove the stale/unverified hook, rewrite the email with a fresh hook or CRM context, then send.

**Post-batch evidence report:**

After sending a batch of outreach emails, send a Hook Evidence Report to eddie@flexor.ai via `superhuman_send` with subject "Hook Evidence Report: [batch name]". The body should be a clean HTML table with columns: Contact, Company, Hook Claim, Source URL, Source Date, Freshness (Fresh/Stale), Status (Verified/Partial/Stale/Inaccurate).

Also generate and save an HTML dashboard version to the outputs folder, and show it in chat.

This is the same importance level as the character encoding rule: a wrong fact in an email from Eddie is worse than a garbled em-dash.

## Important Notes

### Thread IDs
Most operations require thread IDs. Get them from:
- `superhuman_inbox`: Recent emails
- `superhuman_search`: Search results
- `superhuman_starred`: Starred emails
- `superhuman_snoozed`: Snoozed emails

### Email Addresses
When the user provides names instead of email addresses:
- Try to use `superhuman_search` to find previous emails from that person
- Or ask the user for the email address

### Multiple Accounts
If the user has multiple email accounts linked:
- Use `superhuman_accounts` to list them
- Use `superhuman_switch_account` to switch contexts
- Always confirm which account you're operating on

### Attachments
To work with attachments:
1. Use `superhuman_attachments(threadId=...)` to list files
2. Use `superhuman_download_attachment` with messageId and attachmentId
3. The downloaded content is base64-encoded

### Error Handling

If a Superhuman MCP tool fails:
- Check if Superhuman is running with debugging enabled:
  ```bash
  /Applications/Superhuman.app/Contents/MacOS/Superhuman --remote-debugging-port=9333
  ```
- Verify the MCP server is connected
- Provide clear error messages to the user

## Examples

### Example 1: Send Email
```
User: "Send an email to eddie.nudel@gmail.com with subject 'Meeting Follow-up' and say thanks for the meeting"

You: "Would you like me to send this immediately or create a draft first?"
User: "Draft it"

Call: superhuman_draft(
  to="eddie.nudel@gmail.com",
  subject="Meeting Follow-up",
  body="Thanks for the meeting!"
)
```

### Example 2: Search and Archive
```
User: "Find all emails from last week about the budget and archive them"

1. Call: superhuman_search(query="budget after:2026-02-04")
2. Extract thread IDs from results
3. Call: superhuman_archive(threadIds=[id1, id2, id3, ...])
```

### Example 3: Reply to Email
```
User: "Reply to Sarah's email about the deadline"

1. Call: superhuman_search(query="from:sarah deadline")
2. Show results, confirm which email
3. Ask: "Would you like to send immediately or create a draft?"
User: "Send it"
4. Call: superhuman_reply(threadId="...", body="...", send=true)
```

### Example 4: Schedule Meeting
```
User: "Schedule a meeting with the team tomorrow at 2pm"

Call: superhuman_calendar_create(
  title="Team Meeting",
  startTime="2026-02-12T14:00:00Z",
  endTime="2026-02-12T15:00:00Z"
)
```

### Example 5: Use Snippet
```
User: "Use my follow-up snippet to email john@example.com"

1. Call: superhuman_snippets() to list available templates
2. Call: superhuman_snippet(
     name="follow-up",
     to="john@example.com"
   )
```

## Best Practices

1. **Always confirm destructive actions**: Before deleting or archiving multiple emails, show the user what will be affected

2. **Be helpful with search queries**: If the user's request is vague, construct a smart search query and explain what you're searching for

3. **Provide context**: When showing search results, include sender, subject, and date to help the user identify the right email

4. **Respect user preferences**: If they always want drafts instead of immediate sends, remember that pattern

5. **Handle errors gracefully**: If Superhuman MCP times out, explain that Superhuman needs to be running with the debug port enabled

6. **Use batch operations**: When possible, operate on multiple emails at once rather than one-by-one

7. **Leverage AI assistant**: For complex queries or unclear requests, use `superhuman_ask_ai` to help interpret and execute

## Troubleshooting

If Superhuman MCP tools are not working:

1. **Check Superhuman is running with debug port**:
   ```bash
   /Applications/Superhuman.app/Contents/MacOS/Superhuman --remote-debugging-port=9333
   ```

2. **Verify MCP connection**: The MCP server should be configured in Claude Desktop at:
   ```
   ~/Library/Application Support/Claude/claude_desktop_config.json
   ```

3. **Restart Claude Desktop**: After configuration changes, fully quit (Cmd+Q) and restart

4. **Check logs**: Claude Desktop logs are at:
   ```
   ~/Library/Logs/Claude/mcp*.log
   ```

Remember: This skill exists to make email management seamless. Always use Superhuman MCP tools for any email-related request, and provide a smooth, intuitive experience for the user.
