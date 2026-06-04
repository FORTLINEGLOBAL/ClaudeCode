---
name: outreach-basic
description: >-
  Draft Fortline Global cold outreach emails from Eddie Nudel using the standard
  "Protecting buildings against potential threats" template. Use when the user
  wants to send a basic intro/outreach email (or batch of them) to a company or
  list of companies about Fortline's missile/drone structural protection. Handles
  the construction-company wording variations, uses Eddie's native signature, and
  ALWAYS drafts the first email for approval before doing the rest.
---

# Outreach — Basic Intro Email

Drafts Fortline Global's standard cold intro email from **Eddie Nudel** (founding team).

## CRITICAL RULE — approval gate

No matter how many emails are requested, **always produce the FIRST email only, show it
to the user in full, and STOP for approval.** Do not draft, create, or send any of the
remaining emails until the user approves. After approval, process the rest using the
same template and the inputs already gathered.

## Inputs to collect (per recipient)

- **First name** — recipient's first name.
- **Company name** — the company being contacted.
- **Company type / industry** — what the company does (used to decide the construction variation).
- **Email address** — recipient's email (needed to create the Gmail draft).

If sending to a list, gather these for each row, but still only build the first one first.

## Template

**Subject:**

```
Protecting buildings against missiles and drones attacks
```

**Body:**

> Hi {{first_name}},
>
> I'm Eddie Nudel, part of the founding team at Fortline Global.
>
> We help {{company_type}} to protect existing structures against drone and missile
> attacks, using special technology that has been developed in Israel for two decades.
>
> I hope you can advise me on who I can present our solution to in {{company_name}},
> and how it can help{{variation}}.
>
> Thanks,
> Eddie
>
> {{native_signature}}

## Placeholder logic

| Placeholder | Construction company | Any other company |
|---|---|---|
| `{{company_type}}` | `construction companies and their customers` | the recipient's industry/type (e.g. "data center operators", "hospital networks") |
| `{{variation}}` | ` your clients` (note leading space → "...how it can help your clients.") | *(empty)* → "...how it can help." |

A company counts as "construction" if it builds, develops, or contracts buildings
(construction firms, developers, general contractors, real-estate developers). If unsure,
ask the user before classifying.

## Formatting

- Send as a **formatted (HTML) email** — set `htmlBody` on the draft, with paragraph
  breaks between each section (greeting / intro / pitch / ask / sign-off / signature).
- Keep a plain-text `body` as the fallback alternative.
- Preserve the line breaks; do not collapse paragraphs into one block.

## Native signature

Use Eddie's **native Gmail signature** — do not invent one. To get it:
1. Pull it from one of Eddie's recent sent emails via the Gmail MCP
   (`search_threads` with `in:sent`, then `get_thread`), or
2. If the Gmail token needs re-authorization or no signature is found, ask the user to
   paste their signature block before sending.

Append the signature below "Thanks, Eddie" in the HTML body.

## Workflow

1. Gather inputs (above). For a batch, collect the full list but proceed with row 1.
2. Determine `company_type` and `variation` from the construction logic.
3. Retrieve Eddie's native signature.
4. **Build email #1**, render it in full to the user, and STOP — ask for approval.
   Offer to (a) create it as a Gmail draft, or (b) adjust wording first.
5. On approval, create the email(s) via the Gmail MCP `create_draft` tool
   (`to`, `subject`, `htmlBody`, plain `body`). Note: only draft creation is available —
   the user reviews/sends from Gmail. If the Gmail token is expired, surface the
   re-authorization prompt.
6. For a batch, repeat step 5 for each remaining recipient using the same approved format.

## Example (non-construction)

> Subject: Protecting buildings against missiles and drones attacks
>
> Hi Sarah,
>
> I'm Eddie Nudel, part of the founding team at Fortline Global.
>
> We help data center operators to protect existing structures against drone and missile
> attacks, using special technology that has been developed in Israel for two decades.
>
> I hope you can advise me on who I can present our solution to in NorthGrid, and how it
> can help.
>
> Thanks,
> Eddie
>
> *(Eddie's native signature)*
