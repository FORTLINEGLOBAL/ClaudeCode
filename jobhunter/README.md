# Job Hunter Agent (WhatsApp)

Eddie's personal job-search agent. It scans for opportunities, drafts LinkedIn DMs in Eddie's voice, and talks to Eddie over WhatsApp. Eddie approves every DM and sends it himself from LinkedIn (no LinkedIn automation, zero account risk).

## What it does

| Hunter | Source (all free) | Output |
|---|---|---|
| 1. Jobs in Israel | LinkedIn public job search, Greenhouse / Lever / Ashby boards | Director+ commercial, GTM, RevOps, BizOps roles scored 0..100 by Claude; only 70+ are sent |
| 2. Emerging companies | Google News RSS funding queries, LinkedIn posts via DuckDuckGo | Companies that raised $75M+ (AI, infra, B2B apps like CRM). Finds C-suite / regional leaders on LinkedIn, drafts a DM. US HQ gets the "I open EMEA and APAC" pitch, non-US HQ gets the "I open the US" pitch. Regional leaders get the "join your team" pitch |
| 3. Big labs | Fixed watch list in `src/profile.ts` (OpenAI, Anthropic, Mistral, Cohere, ...) | International / regional GTM roles from their ATS boards plus cold DMs to international leaders |
| Follow-ups | Tracker | 7 days after a DM is sent, a follow-up that adds something new is drafted. Max 3 touches, then auto-closed |

Rules baked in: 10 new drafts per day, every fact used in a DM carries a source URL or is not used, no duplicates (a person is only ever contacted once through the tracker), blocked companies are never surfaced.

## WhatsApp commands

```
digest | status | help
show N              full draft or job
sent N[,N]          you sent the DM; the follow-up is scheduled
skip N | skip <company>
rewrite N <how>     e.g. rewrite 3 shorter, mention I'm in London in Oct
replied N: <text>   paste their reply, the agent drafts yours
find contacts at <company>
add company <company> | block company <company>
set cap 10 | pause | resume | scan now
```

Anything else in plain language is interpreted by Claude and mapped to one of those.

Messages arrive only when something new appears: scans run every 6 hours, follow-ups are checked daily at 08:00/09:00 Israel time.

## Costs

- Netlify: free Starter plan covers everything used here (Functions, Scheduled Functions, Blobs). No card needed.
- WhatsApp Cloud API: free. The Meta test number can message up to 5 verified numbers at no cost.
- Anthropic API: the only paid piece. At 10 drafts a day plus scoring, expect a few dollars a month.

## Setup (about 30 minutes)

### 1. Anthropic key
Create a key at console.anthropic.com. That is `ANTHROPIC_API_KEY`.

### 2. WhatsApp Cloud API (free test number)
1. Go to developers.facebook.com, create an app of type Business, add the WhatsApp product.
2. In WhatsApp > API Setup you get a free test phone number and its Phone number ID (`WHATSAPP_PHONE_NUMBER_ID`).
3. Add +972 54 320 3976 as a recipient under "To" and confirm the code sent to that phone.
4. Create a permanent token: Business Settings > System Users > Add > assign the app with `whatsapp_business_messaging` and `whatsapp_business_management` > Generate token. That is `WHATSAPP_TOKEN`.
5. App > Settings > Basic > App secret is `WHATSAPP_APP_SECRET`.
6. Create a message template (WhatsApp Manager > Message templates): name `jobhunter_ping`, category Utility, language English (US), body exactly:
   ```
   Job hunter update: {{1}}
   ```
   Wait for approval (usually minutes to a few hours). This template is used only when Eddie has not messaged the bot in the last 24 hours; otherwise messages are free-form.

### 3. Deploy on Netlify
1. Push this repo to GitHub and in Netlify choose "Import from Git". Set the base directory to `jobhunter`.
2. Site settings > Environment variables: add every variable from `.env.example`.
3. Deploy. Your webhook URL is `https://<site>.netlify.app/whatsapp`.

### 4. Connect the webhook
In the Meta app: WhatsApp > Configuration > Webhook. Callback URL is the URL above, Verify token is your `WHATSAPP_VERIFY_TOKEN`. Subscribe to the `messages` field.

### 5. First run
Send "help" from WhatsApp to the test number. Then send "scan now". The first scan takes a couple of minutes and returns the first digest.

You can also trigger a scan from a browser: `https://<site>.netlify.app/.netlify/functions/scan?key=<JOBHUNTER_ADMIN_KEY>`.

## Local use (no Netlify needed)

```
cd jobhunter && npm install
cp .env.example .env   # fill in ANTHROPIC_API_KEY at minimum
npm run smoke:sources  # checks every free data source is reachable
npm run scan:local     # runs all hunters, prints the digest, stores state in .local-state.json
npm run cmd:local -- "show 1"
npm run followups:local
npm test               # offline logic tests
```

## Tuning

Everything about targets lives in `src/profile.ts`: title keywords, minimum raise, sectors, the big-company list and their ATS slugs, the expansion pitch per HQ region, and the voice rules with Eddie's reference DMs. `src/store.ts` has the defaults for cap, cadence and max touches (also changeable over WhatsApp).

## Known limits

- LinkedIn has no public API. Job search uses LinkedIn's public guest endpoint (may rate-limit; ATS boards fill the gap) and LinkedIn posts are found through a web search engine, so coverage there is partial.
- Company discovery relies on news, so a raise that only appears on Crunchbase is missed.
- The ATS slugs in the big-company list are best guesses, but a wrong one self-heals: if the configured slug returns nothing the agent probes the other boards, then caches what worked for 30 days (a company with no public board is retried weekly). `npm run smoke:sources` still shows you which slugs are wrong if you want to correct them in `src/profile.ts`.
