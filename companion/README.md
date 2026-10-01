# Companion (web chat, phase 1)

A warm, bilingual (Hebrew and English) companion for older parents. This is phase 1 of [the build plan](../docs/companion-build-plan.he.md): the companion core runs behind a channel interface and is used through a simple web chat. WhatsApp plugs into the same core in phase 2b.

## What works now

| Piece | What it does |
|---|---|
| Web chat | Right-to-left Hebrew or English, large type, a Hebrew/English toggle, voice dictation and read-aloud through the browser. Each parent has a private link; there is no password. |
| Conversation | Claude (`claude-opus-5-5`, low effort) answers in the parent's language, keeps names as they were said, and uses the right Hebrew gender. Server-side refusal fallback is on. |
| Memory v1 | After each reply, a cheaper model (`claude-haiku-4-5`) pulls out durable facts (life story, family, routines, recent events). Corrections create a new version and keep the old one. Sensitive or low-confidence facts are checked with the parent before being relied on. |
| Daily check-in | Every 15 minutes the scheduler checks each parent's own local time. One check-in per day, at or after their chosen time, never in quiet hours, never after STOP or without consent. |
| SOS | Fixed, deterministic text in both languages, with the emergency number and tap-to-call. Between 08:00 and 22:00 Israel time the operator gets a WhatsApp alert, and the parent is told a person is on it only when that alert actually went out. Outside those hours the parent is told to call their family contact. It never claims emergency services were called. |
| STOP | "STOP" / "עצור" turns off messages the companion sends first; "start" / "המשך" turns them back on. |

Not in this phase (see the plan): the family dashboard, digest and scam shield (phase 2), WhatsApp (phase 2b), and the real speech providers, which the phase 0 voice bake-off picks.

## Decisions in effect

- Human safety coverage: 08:00-22:00 Israel time (`COVERAGE_*`).
- WhatsApp: Meta Cloud API directly, no Twilio. Only operator alerts use it in this phase.
- Family digest (phase 2): every category off by default except "active this week" and missed check-ins.

## Run it

```bash
npm install
npm test                  # offline tests, no API calls
ANTHROPIC_API_KEY=... npm run chat:local -- he   # talk to it in the terminal
```

## Deploy on Netlify

1. In Netlify, import this repository and set the base directory to `companion`.
2. Add the environment variables from `.env.example`. `ANTHROPIC_API_KEY`, `COMPANION_ADMIN_KEY` and `COMPANION_INTERNAL_SECRET` are required.
3. Create a parent and get their private link:

```bash
curl -X POST https://YOUR-SITE.netlify.app/api/admin/parents \
  -H "x-admin-key: $COMPANION_ADMIN_KEY" -H "content-type: application/json" \
  -d '{"name":"רחל","gender":"f","lang":"auto","tz":"America/New_York","checkinTime":"10:00",
       "emergencyNumber":"911","contacts":[{"name":"Dana","relation":"daughter","phone":"+12125550100"}]}'
```

Send the returned `link` to the parent. The token sits after `#`, so it never reaches server logs. `POST /api/admin/link` with `{"id": "..."}` issues a new link, and `GET /api/admin/alerts` lists SOS alerts. The operator endpoints never show the private conversation.

## Layout

```
src/policy.ts      deterministic rules: language, SOS, STOP, coverage, check-in timing, fixed replies
src/companion.ts   the core: fast path (SOS, STOP) in the request, conversation and memory in the background
src/llm.ts         every Claude call
src/channel.ts     the channel interface; the web chat is the first implementation
src/store.ts       Netlify Blobs, one key prefix per parent
netlify/functions  chat (web), turn-background (replies, check-ins), checkin (schedule), admin
public/index.html  the chat page
```
