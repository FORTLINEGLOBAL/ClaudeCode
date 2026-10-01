# Companion (web chat, phase 1)

A warm, bilingual (Hebrew and English) companion for older parents. This is phase 1 of [the build plan](../docs/companion-build-plan.he.md): the companion core runs behind a channel interface and is used through a simple web chat. WhatsApp plugs into the same core in phase 2b.

## What works now

| Piece | What it does |
|---|---|
| Web chat | Right-to-left Hebrew or English, large type, a Hebrew/English toggle, voice dictation and read-aloud through the browser. Each parent has a private link; there is no password. |
| Conversation | Claude (`claude-opus-5-5`, low effort) answers in the parent's language, keeps names as they were said, and uses the right Hebrew gender. Server-side refusal fallback is on. |
| Memory v1 | After each reply, a cheaper model (`claude-haiku-4-5`) pulls out durable facts (life story, family, routines, recent events). Corrections create a new version and keep the old one. Sensitive or low-confidence facts are checked with the parent before being relied on. |
| Daily check-in | Every 15 minutes the scheduler checks each parent's own local time. One check-in per day, at or after their chosen time, never in quiet hours, never after STOP or without consent. |
| SOS | Fixed, deterministic text in both languages, with the emergency number and tap-to-call. Between 08:00 and 22:00 Israel time the operator gets an email (Resend) and/or WhatsApp alert, whichever is configured, and the parent is told a person is on it only when that alert actually went out. Outside those hours the parent is told to call their family contact. It never claims emergency services were called. |
| STOP | "STOP" / "עצור" turns off messages the companion sends first; "start" / "המשך" turns them back on. |

Family page: `/family.html#t=...` shows the parent's week (messages per day, check-ins answered or missed, last activity), SOS times, and the settings and contacts, never the conversation. A family link is either "admin" (edits settings and contacts, adds notes the companion should know, makes a new chat link) or "viewer". Consent is shown but only the parent changes it. The admin page creates the first family link with each new parent, and lists existing parents to make more. A new family note is passed on in the companion's next message (reply or check-in), saying the family asked, and is kept as memory after that; the family page shows whether it was passed on yet.

Reminders: an admin family link can set reminders (text, time in the parent's local time, optional weekdays, and who it is from). The scheduled `checkin` function sends each one word for word when due, once a day, up to 45 minutes late; STOP pauses them. The family page shows whether today's reminder went out and whether the parent wrote after it.

Weekly email: on the family page, up to 5 addresses and a language. Every Sunday at 09:00 in the parent's time zone the scheduled function emails the past 7 days: days with a conversation, message counts, check-ins answered or missed, last activity. Never message text. A "send a sample now" button tests it. It goes out through Resend (`RESEND_API_KEY`); to reach anyone other than the Resend account's own address, verify a domain in Resend and set `ALERT_FROM_EMAIL` to a sender on it.

Scam shield (`src/scam.ts`): when the parent pastes or describes a message with a scam pattern (a code or password with a bank or urgency, money with secrecy or urgency, a prize with a link, remote-access apps, or any three warning signs), the companion answers at once with a fixed warning. The warning lists the signs and says not to click, pay or share a code, and to call back on a number they already know. It is deterministic like SOS, with no model, and links are never opened. If the family has a weekly-email address, it offers to tell them. Only a "yes" sends an email, and it lists the warning signs, never the message itself. Each case is logged for the operator; the family page's SOS list is unaffected.

Not in this phase (see the plan): family logins with passkeys, the other digest categories (phase 2), WhatsApp (phase 2b), and the real speech providers, which the phase 0 voice bake-off picks.

## Decisions in effect

- Human safety coverage: 08:00-22:00 Israel time (`COVERAGE_*`).
- WhatsApp: Meta Cloud API directly, no Twilio. Only operator alerts use it in this phase; until Meta is set up, operator alerts go by email.
- Family digest (phase 2): every category off by default except "active this week" and missed check-ins.

## Run it

```bash
npm install
npm test                  # offline tests, no API calls
ANTHROPIC_API_KEY=... npm run chat:local -- he   # talk to it in the terminal
```

## Deploy on Netlify

1. In Netlify, import this repository and set the base directory to `companion`.
2. Add the environment variables from `.env.example`. `ANTHROPIC_API_KEY` and `COMPANION_ADMIN_KEY` are required.
3. Create a parent and get their private link:

```bash
curl -X POST https://YOUR-SITE.netlify.app/api/admin/parents \
  -H "x-admin-key: $COMPANION_ADMIN_KEY" -H "content-type: application/json" \
  -d '{"name":"רחל","gender":"f","lang":"auto","tz":"America/New_York","checkinTime":"10:00",
       "emergencyNumber":"911","contacts":[{"name":"Dana","relation":"daughter","phone":"+12125550100"}]}'
```

Or open `/admin.html` on the site, enter the admin key, and fill in the form; it returns the same link and lists SOS alerts.

Send the returned `link` to the parent. The token sits after `#`, so it never reaches server logs. `POST /api/admin/link` with `{"id": "..."}` issues a new link, and `GET /api/admin/alerts` lists SOS alerts. The operator endpoints never show the private conversation.

## Layout

```
src/policy.ts      deterministic rules: language, SOS, STOP, coverage, check-in timing, fixed replies
src/companion.ts   the core: SOS and STOP answered with fixed text, then the conversation and memory
src/llm.ts         every Claude call
src/channel.ts     the channel interface; the web chat is the first implementation
src/store.ts       Netlify Blobs, one key prefix per parent
netlify/functions  chat (web, replies within the request), checkin (schedule), admin
public/index.html  the chat page
```
