---
name: prospect-outreach
description: "Unified outreach skill for single or batch prospect engagement for Fortline Global. Handles first-touch cold outreach (research + personalized email + LinkedIn connect/DM) AND follow-up outreach for non-responding contacts (tiered by touchpoints). Auto-detects whether a contact is new or has prior outreach history. Supports single contact or batch mode with interactive HTML dashboard. MUST trigger whenever Eddie mentions: 'reach out to [person]', 'draft outreach to [person/company]', 'write email to [prospect]', 'follow up on non-responding contacts', 'outreach to [person]', 'send outreach', 'prospect outreach', 'outreach these contacts', 'follow up with [person]', 're-engage [person]', or any request to contact a government, defense, or infrastructure prospect for the first time or follow up on unanswered outreach."
---

## MANDATORY: Every Step is Non-Negotiable

Every step in this skill is MANDATORY regardless of batch size. Whether processing 1 contact or 100 contacts, every step must be executed fully for every contact. Batch size is never an excuse to skip, shortcut, or "optimize" by dropping steps. If a step exists in this skill, it exists for a reason. If you skip it, the output will be rejected and the entire batch will need to be redone.

---

# Prospect Outreach — Fortline Global

Unified outreach engine for Fortline Global's European defense and critical infrastructure market: from first-touch cold outreach to tiered follow-up for non-responding contacts. Handles single contacts and batches. Auto-detects whether a contact is new or has prior history, then applies the right playbook.

---

## Prerequisites

Before starting, load the companion skill by reading its SKILL.md file:
1. **writing-guidelines** (Fortline) — Eddie's voice, banned phrases, CTA style, quality standards. Every message must follow these rules.

---

## Modes of Operation

This skill auto-detects the right mode based on what Eddie provides and what CRM/email history shows:

| Mode | Trigger | What Happens |
|------|---------|--------------|
| **First Touch** | No prior outbound touchpoints found in CRM/email | Full research + personalized first email + LinkedIn connect/DM |
| **Follow-Up** | 1+ prior outbound touchpoints with no reply | Tiered outreach based on touchpoint count (Tier 3/2/1) |
| **Single** | Eddie gives one contact | Process immediately, present drafts inline |
| **Batch** | Eddie gives 2+ contacts or a list | Process all, build interactive HTML dashboard |
| **Short** | Eddie says "prospect-outreach short" or "use the short template" | Same research + hook verification, condensed 2-paragraph email (~50-60 words body) |

The mode is determined PER CONTACT. In a batch, some contacts may be First Touch and others Follow-Up.

---

## Data Lookup Order (ALWAYS follow this)

When researching any contact:
1. **HubSpot CRM first** — Search for the contact. Pull name, title, organization, lead status, notes, associated deals, meetings, calls, logged emails, tasks, and "Logged LinkedIn message" activities.
2. **Then check email (Gmail)** — Search for the latest email threads with the contact's email and organization domain. Read the most recent messages for full context.
3. **Check LinkedIn activity in HubSpot** — Pull "Logged LinkedIn message" activities (synced via Surfe). Classify each as outbound (sent by Eddie) or inbound (sent by the contact).
4. **Always prioritize the latest activity** — Present the most recent touchpoints first.

---

## Step 0: Understand What Eddie Wants

When Eddie triggers this skill, determine:

1. **Single or batch?** One contact vs. multiple contacts/list
2. **Short mode?** If Eddie says "prospect-outreach short" or "use the short template" — activate SHORT EMAIL MODE for Step 3. All research steps (1a through 1g) still apply in full. Only the email drafting template changes.
3. **Any campaign context?** If Eddie mentions a specific event (NATO summit, defense expo, bilateral meeting), store it for personalization
4. **Subject line preference?** Ask if Eddie wants a specific subject line or if you should draft one

For single contact: ask "Any specific context I should use?" and proceed.
For batch: ask "Any event or context that ties these contacts together? And any subject line preference?"

If Eddie has already provided enough context, skip the questions and proceed.

---

## Step 1: Research Each Contact

### 1a. CRM + Email History Lookup

For each contact:

```
1. Search HubSpot by email or name
2. Pull: name, title, organization, lead status, notes, associated deals
3. Pull all engagements: emails, calls, meetings, notes, tasks
4. Pull "Logged LinkedIn message" activities
5. Search Gmail for email threads with this contact
6. Read the most recent messages to understand what was said
```

### 1x. Contact Relationship Classification (MANDATORY)

After completing Step 1a, classify every contact into one of three relationship types. This classification determines the ENTIRE email strategy — tone, structure, content, and CTA.

| Type | Badge | Criteria | Email Strategy |
|------|-------|----------|----------------|
| **COLD** | Gray | 0 inbound replies. No associated deals. No meetings. No two-way conversation. | Standard First Touch or Follow-Up per touchpoint tier. Use hooks, intros, pitch. |
| **WARM** | Amber | 1+ inbound reply OR attended an event/received a briefing, BUT no active deal and no live scheduling. The contact knows who Eddie/Fortline is but there's no live opportunity. | Lighter intro (can skip the full "I'm Eddie" intro if they've replied before). Reference the specific prior exchange. More direct CTA. |
| **DEAL** | Green | Associated with a HubSpot deal (any stage, including closed-lost) OR active two-way email conversation (scheduling, follow-up, exchanging info) OR a meeting was booked/occurred. | NO cold intro. NO pitch. Reference the SPECIFIC last interaction. Short, contextual, action-oriented. |

**How to determine classification:**

1. **Check HubSpot deals**: If any deal exists (active, closed, nurture) AND this contact is associated → **DEAL**
2. **Check email thread depth**: Read the full thread. If the contact replied with substantive content → at minimum **WARM**, possibly **DEAL** if it involved scheduling or sharing info
3. **Check meetings**: Any meeting booked (even cancelled/rescheduled) → **DEAL**
4. **Check calls/notes**: Logged calls or detailed notes → **DEAL**
5. **Default**: If none of the above → **COLD**

**CRITICAL: You MUST read the full email thread for every contact before classifying.** Gmail snippets are worthless for classification. A snippet showing "following up" tells you nothing about the conversation underneath.

### 1b. Verify LinkedIn DM/InMail History via Chrome (MANDATORY)

Before counting touchpoints, verify HubSpot has the complete LinkedIn messaging history. Surfe sync is unreliable.

**For each contact:**
1. Open their LinkedIn profile in Chrome
2. Open the DM/InMail thread
3. Read the full conversation — capture every message (sent and received), with dates
4. Compare against HubSpot's "Logged LinkedIn message" activities
5. Sync any unlogged messages — create a HubSpot note via `manage_crm_objects` for the contact:
   ```
   [Logged LinkedIn DM - {date}]
   {message text}
   ```

### 1c. Count Outbound Touchpoints

Count total REAL outbound touchpoints:
- Outbound emails (exclude bounce-backs)
- Outbound "Logged LinkedIn message" activities
- Outbound LinkedIn DMs/InMails discovered in the Chrome check (Step 1b) not previously logged
- This combined count determines the tier

**If touchpoints = 0 → First Touch mode**
**If touchpoints >= 1 → Follow-Up mode (apply tier logic)**

### 1d. Personal Email Enrichment

If the contact's email is personal (Gmail, Yahoo, Hotmail personal, etc.), use Clay (if available) to find their organizational email:

```
Tool: find-and-enrich-list-of-contacts
contacts: [{ contactName: "Full Name", companyIdentifier: "organization.gov/eu/mil" }]
dataPoints: { contactDataPoints: [{ type: "Email" }] }
```

**Do NOT override the existing email in HubSpot.** Log the discovered email as a HubSpot note:
```
[Business/organizational email found via Clay enrichment]
Email: [new_email]
Original email on record: [personal_email]
Status: Inferred — verify before use
```

### 1e. Flag Disqualified Contacts

If a contact is "DISQUALIFIED" in HubSpot, flag it and ask Eddie before proceeding.

### 1f. Champion Detection (First Touch contacts only)

When reaching out to a new contact at an organization, check whether Fortline already has or had relationships there. A familiar colleague's name creates instant credibility — especially in defense and government circles where trusted introductions are the norm.

**How to find existing relationships at the organization:**
1. After the CRM lookup in Step 1a, search HubSpot for deals associated with the contact's organization (search by organization name or domain).
2. Look across all pipelines: active, closed, and nurture.
3. If no deals are found, skip this step entirely.

**How to identify the champion (1-2 people max):**
1. **Email volume**: Search Gmail for email threads between each associated contact and Fortline. The person with the highest volume of back-and-forth exchanges is likely the champion.
2. **Direct addressing**: Prioritize anyone Eddie was addressing directly in the "To:" field.
3. Pick top 1-2 contacts. Store their name, title, and brief context (what was discussed, what problem was being explored).

**When NOT to name-drop:**
If the champion is the same person you're now reaching out to, skip entirely.

**How to weave the champion into the email:**
Place the reference in the personalized hook section. Keep it vague and positive regardless of how the relationship ended — never mention deal outcomes, pipeline stages, or that anything didn't progress.

Good examples:
- "We had some valuable conversations with [Champion Name] on your team about [topic, e.g., protection requirements for your eastern facilities]."
- "[Champion Name] and I connected a while back around [context, e.g., building hardening requirements for your infrastructure portfolio]. Thought it was worth reaching out to you directly."
- "Your colleague [Champion Name] and I explored [context] together. Given your role in [prospect's area], figured it was worth saying hello."

Bad examples (never do these):
- "We had a project with your organization that didn't move forward..." (reveals outcome)
- "[Champion Name] was interested but couldn't get approval..." (too specific about blockers)
- "I noticed [Champion Name] in our CRM..." (exposes internal tooling)

**MANDATORY ENFORCEMENT — Champion Detection CANNOT be skipped in batch mode.** For batches, run a bulk deal search FIRST (search HubSpot deals by organization name for all unique organizations in the batch). Skipping this step means every email to an organization where Fortline has existing relationships will sound cold and generic.

### 1g. Web Research + Hook Verification (First Touch contacts only)

For First Touch contacts, do deeper research:
- **LinkedIn profile**: Find profile, extract title, career summary, focus areas, location
- **Recent organizational news (last 3 months only, hard rule)**: Search for recent news: defense spending announcements, infrastructure protection initiatives, building programs, legislative changes, bilateral agreements, new mandates. The source MUST be dated within 3 months of today. Anything older is BLOCKED. If no fresh news exists, use a role-based hook instead.
- This becomes the personalization hook (in addition to any champion context from Step 1f)

**Hook categories for Fortline (in priority order):**
1. **Champion name-drop from Step 1f** (highest priority)
2. **Recent threat incident or vulnerability** affecting their country, sector, or facilities (within 3 months)
3. **Defense/resilience budget announcement or legislative change** (within 3 months): NATO spending commitments, national resilience laws, civil defense legislation, NIS2 compliance mandates
4. **Organization-specific initiative**: new facility construction, infrastructure expansion, stated resilience gap, public procurement related to protection
5. **Role-based hook**: specific to their title + Fortline's relevance to their function

**Hook Verification (mandatory, do NOT skip):**

Every factual claim you plan to use as a personalization hook must be verified before it goes into a draft. Eddie's credibility in defense/government circles is everything — a wrong fact destroys it instantly.

Verification checklist for each hook:
1. Web search the specific claim
2. Find a credible public source: official government press release, NATO announcement, credible defense news outlet, legislative record
3. Confirm the fact belongs to THIS country/organization, not a peer. When researching multiple Eastern European contacts, it's very easy to accidentally swap Poland's defense budget figure with Finland's.
4. **Check the date. Hard block: source MUST be within 3 months of today.** If older than 3 months, the hook is BLOCKED. Drop it entirely. Use a role-based or CRM hook instead.
5. Record per hook: claim text, source URL, source date, verification status (Verified / Partial / Stale / Unverifiable)

6. **Relevance gate: does this hook connect to Fortline's value prop?** After confirming a hook is real and fresh, score its relevance to passive defense, building hardening, critical infrastructure protection, or civilian resilience:
   - **STRONG** — Hook directly involves a protection gap, structural vulnerability, passive defense legislation, a threat incident, or infrastructure hardening need. Use it.
   - **MEDIUM** — Hook implies increased risk or urgency (general defense spending, new leadership). Flag for Eddie's call.
   - **WEAK** — General geopolitical news with no clear link to passive defense or building protection. Drop it. Use a role-based hook instead.

If a claim fails ANY check, it is BLOCKED. No softening, no rephrasing:
- Source older than 3 months → BLOCKED
- No organization-specific source → BLOCKED
- Fact belongs to a different country or organization → BLOCKED
- No source at all → BLOCKED

Store the verification data per contact for the Post-Send Evidence Report (Step 6).

**Every First Touch email MUST contain at least ONE verified hook from one of these sources (in priority order):**
1. Champion name-drop from Step 1f
2. Fresh organization or country-specific news (within 3 months)
3. CRM context hook (past interaction, event attendance, briefing received)
4. Role-based hook (specific to their title + Fortline's relevance to their function)

If NONE of the above exist for a contact, flag them for Eddie's review instead of drafting a generic email. A generic email with {Organization} swapped in is worse than no email.

### 1h. Tier Classification (for dashboard)

Classify each contact by seniority:

| Tier | Criteria | Badge Color |
|------|----------|-------------|
| VP+ / C-Suite / Minister | Minister, Secretary, General, Ambassador, Chief, VP, Managing Director, Deputy Minister, Assistant Secretary, Director General | Purple |
| Director / Head | Director, Head of, Department Head, Deputy Director, Senior Advisor, Commander | Blue |
| Mid-Level | Manager, Officer, Specialist, Coordinator, Engineer, Analyst | Green |

---

## Step 2: Determine Outreach Action

### First Touch Contacts (0 prior touchpoints)

| Channel | Action |
|---------|--------|
| **Email** | Send personalized first email via Gmail |
| **LinkedIn (if connected)** | Send short "just sent you something" DM |
| **LinkedIn (if NOT connected)** | Send connection request (no note) |

### Follow-Up Contacts (1+ prior touchpoints, no reply)

| Outbound Touchpoints | Email Action | LinkedIn (if connected) | LinkedIn (if NOT connected) |
|---|---|---|---|
| **1** (Tier 3) | Reply-all in existing thread (via Gmail MCP) | Send DM | Send connection request |
| **2-3** (Tier 2) | New email, new thread, new subject line (via Gmail) | Send DM | Send connection request |
| **4+** (Tier 1) | NO more email (email is dead) | Send DM only | Send InMail + connection request |

---

## Step 3: Draft Messages

**PRE-DRAFT CHECKLIST (mandatory before writing any email):**
1. Did you complete Step 1f Champion Detection for ALL organizations? If not, STOP and do it now.
2. Did you complete Step 1g Hook Research for ALL First Touch contacts? If not, STOP and do it now.
3. Does every email have at least ONE verified hook (champion, news, CRM, or role-based)? If not, flag for Eddie.
4. Are you rotating Eddie's intro from writing-guidelines? NEVER use "I'm Eddie, Strategic Advisor at Fortline Global."
5. Does every contact card have ALL applicable channels mapped per the Step 2 action table?
6. For EVERY contact, did you read the FULL email thread (not just snippets)?

### FIRST TOUCH Email Structure

**Target length: 3 short paragraphs + CTA + sign-off. Aim for ~80-100 words in the body (excluding signature). Senior officials scan, they don't read essays.**

1. **Greeting:** "Hi [First Name],"
2. **Paragraph 1 — Eddie's intro + research acknowledgment** (1-2 sentences, same paragraph):
   - Eddie's intro (rotate from writing-guidelines intro variations)
   - Immediately followed by a short research acknowledgment. Alternate across contacts:
     - "I did some homework before reaching out, so hopefully this lands."
     - "I did some research to make sure this is relevant to you before reaching out."
   - **NEVER use "cold email", "cold outreach", or any phrase that labels the email as cold.**
3. **Paragraph 2 — Hook + Fortline bridge** (ONE combined paragraph, 2-3 sentences max):
   - Open with the hook (champion name-drop, specific news, role/CRM context)
   - Flow directly into the conditional value bridge: "If [specific exposure] is the hard part..."
   - End with one clause describing what Fortline does in their context
   - NEVER pitch. NEVER list services. Keep it tight.
4. **CTA** (one sentence): Use CTA rotation from writing-guidelines. For Fortline, almost always points to the confidential protection assessment.
5. **Sign-off:** "Thanks, Eddie"
6. **Signature block:**
   ```
   Eddie Nudel
   Strategic Advisor, Founding Team
   Fortline Global
   M: (646) 338-3012 | E: eddie@fortlineglobal.com
   https://www.linkedin.com/in/eddienudel
   https://fortlineglobal.com
   ```

### SHORT EMAIL MODE (triggered by "prospect-outreach short")

**Target length: 2 short paragraphs + CTA. ~50-60 words in the body (excluding signature).**

All research steps (1a through 1g), hook verification, and quality checks still apply in full. Only the email structure changes.

**Structure:**
1. **Greeting:** "Hi [First Name],"
2. **Paragraph 1 — Eddie's intro + research acknowledgment** (same as standard First Touch)
3. **Paragraph 2 — Hook + bridge** (ONE tight paragraph, 3 sentences max):
   - Sentence 1: Personalized hook (what you saw about their role, organization, or context)
   - Sentence 2: "If [the specific protection gap they face] is the exposure, that's exactly what my team works on."
   - No additional elaboration
4. **CTA** (one short sentence): "Worth a call to see if a protection assessment makes sense?"
5. **Sign-off:** "Thanks, Eddie"
6. **Signature block**

---

### FIRST TOUCH LinkedIn DM (if already connected)

Short, 1-2 sentence nudge after the email is sent. Do NOT repeat email content.

Templates (vary across contacts):
- "Hey [Name], just sent you a quick note to your inbox. Would love to connect if the timing works."
- "Hey [Name], dropped you an email, figured I'd say hi here too. No rush."
- "Hey [Name], sent something your way by email. Let me know if it lands."

### FOLLOW-UP Email Rules

**Opening:**
- Use "Hi [Name],"
- **Include Eddie's founding team intro** (rotate from writing-guidelines intro variations) unless WARM (contact has replied before). The intro goes right after the greeting, before the "trying my luck" line.
- Include "trying my luck again to get your attention :)" in emails and InMails (not DMs)
- NEVER open with "Good morning", "Hope you're doing well", or any filler

**Body:**
- Reference a SPECIFIC past interaction from CRM (a conversation, a meeting discussion, a document shared, an event attended)
- NEVER open with generic threat landscape statements
- Keep emails to 2 short paragraphs max
- No dashes of ANY kind (em-dashes, en-dashes, hyphens as separators)
- No bullet points in outreach messages
- NEVER use "no joke", "no small feat", or casual/buddy-tone phrases
- No "if not" safety nets
- Second trigger paragraph must start conversationally. BANNED starters: "With...", "A lot of...", "Most...", "Now that...", "Many..."
- Include event trigger in subject line when applicable. Keep subjects short (under 8 words)

**CTA (always use this pattern, rotate across contacts):**
1. "I'd suggest starting with a confidential assessment of your priority facilities, no commitment required, and the deliverable is a classified Protection Vulnerability Report under NDA."
2. "Worth a call to walk through the assessment scope and whether it makes sense for your portfolio?"
3. "I can walk you through the assessment on a call or send something over first."
4. "I'd love to show you the methodology on a call, or I can send it over."

**Sign-off for emails:**
```
Eddie Nudel
Strategic Advisor, Founding Team
Fortline Global
M: (646) 338-3012 | E: eddie@fortlineglobal.com
https://fortlineglobal.com
https://www.linkedin.com/in/eddienudel
```

### FOLLOW-UP LinkedIn DM Rules

- "Hey [Name]," (not "Hi")
- 2-4 sentences, conversational
- Reference CRM context naturally
- No dashes of any kind
- End with "Eddie"

### FOLLOW-UP LinkedIn InMail Rules (Tier 1 only)

- "Hi [Name],"
- 3-5 sentences
- Include "trying my luck again to get your attention :)"
- Reference specific CRM context
- End with "Eddie"

### ALL Messages - Banned Phrases

(See writing-guidelines for the full banned list. Key ones for Fortline outreach:)
- "Europe is facing unprecedented threats"
- "I've noticed that..."
- "Wondering if..." / "Curious if..."
- "Just circling back" / "Touching base"
- "Would you be open to" / "Just wanted to"
- "Happy to share" / "Resonates" / "Leverage"
- "Hope you're doing well" / "Good morning"
- "Quick question"
- Any phrase with dashes (em-dashes, en-dashes, hyphens as separators)
- "If not, no worries" / any "if not" safety net
- "Either way works" / "No pressure" / "Just a thought" (filler closers after CTA)
- "no joke" in any context
- "no small feat" / "no easy task"
- "I'm Eddie, Strategic Advisor at Fortline Global" — SDR template intro. Use approved variations.

### Quality Checks (run on EVERY message before finalizing)

1. **Dash scan**: Search entire message for "—" (U+2014), "–" (U+2013), and any hyphen as separator. Replace every single one.
2. **Banned phrase scan**: Check against the full banned list in writing-guidelines.
3. No generic threat landscape openers
4. Opening references THIS person and THIS relationship
5. Under 7 sentences for emails, 2-4 for DMs, 3-5 for InMails
6. CTA points toward the protection assessment, not a generic call
7. No "if not" safety net phrases
8. No filler closers after the CTA
9. If CRM activity exists, it's referenced
10. Does the second trigger paragraph start conditionally/conversationally?
11. Would a senior defense or government official actually read and respond to this?
12. **Champion reference check** (if name-dropping): Does the message mention deal outcomes, budget issues, or anything negative? If so, rewrite to keep it vague and positive.
13. **Hook presence check**: Does this email contain at least one verified hook?
14. **Post-generation validation (batch mode only)**: Before presenting the dashboard:
    - "Strategic Advisor at Fortline Global" (as standalone intro) → must return 0 results
    - "no joke" → must return 0 results
    - Double intros → must return 0 results
    - Em-dashes / en-dashes → must return 0 results
    - Generic filler pattern "[Organization]'s challenge" with no specific hook → FAIL
    - Verify champion name-drops exist for every organization that has a HubSpot deal
    - Verify each email has exactly ONE Eddie intro variation
    - Verify every contact has a LinkedIn action defined
    - Verify Tier 1 contacts (4+ touches) have NO email draft and DO have a DM or InMail
    - Verify every DEAL contact has a contextual follow-up (no cold intros, no pitch, references specific last interaction)
    - Verify every contact has a `relationship_type` classification (COLD / WARM / DEAL)
    - Verify every contact has a `thread_summary` that's specific

---

## Step 4: Present Drafts

### HARD GATE: Step 7 Self-Evaluation Scorecard MUST Run Before Presenting

**DO NOT present any drafts until the Step 7 Self-Evaluation Scorecard has been fully completed for ALL contacts, covering Categories 1-4.** If any contact scores BLOCKED (1+ FAILs), fix those FAILs and re-score before proceeding.

### Single Contact Mode

Show inline:
1. **Situation summary**: Who they are, touchpoint count, key CRM context, mode (First Touch vs. Follow-Up). If a champion was found: "Champion found: [Name] ([Title]) — context: [brief summary]"
2. **Tier applied** (for Follow-Up) or "First Touch" label
3. **Draft messages** for each channel (email + DM/InMail/connection request per the action table)
4. **Recommended subject line**

Wait for Eddie's explicit instruction before sending.

### Batch Mode - Interactive HTML Dashboard

Create a single-file HTML dashboard saved to `/sessions/[session]/mnt/outputs/prospect-outreach-dashboard.html`

**Dashboard Structure:**

**Header:**
- Title: "Prospect Outreach — Fortline Global" + date
- Subtitle: Campaign name (if applicable) or "Batch outreach for [N] contacts"

**Stats Row (KPI cards):**
- Total contacts
- First Touch count
- Follow-Up count (with tier breakdown: Tier 3 / Tier 2 / Tier 1)
- VP+ / Minister count

**Filter Buttons:**
- All | First Touch | Follow-Up | VP+ | Director | Mid-Level | Has Champion | Has Recent News

**Contact Cards (for each contact):**

```html
<div class="card" data-mode="[first-touch|follow-up]" data-tier="[vp|dir|mid]" data-followup-tier="[3|2|1|new]" data-news="[0|1]" data-champion="[0|1]">
  <div class="card-header">
    <div>
      <div class="card-name">[Full Name]</div>
      <div class="card-title">[Job Title]</div>
      <div class="card-company">[Organization]</div>
      <div class="card-linkedin"><a href="[URL]">LinkedIn</a></div>
    </div>
    <div class="badges">
      <span class="tier-badge tier-[vp|dir|mid]">[Seniority Tier]</span>
      <span class="mode-badge mode-[first-touch|follow-up]">[First Touch | Follow-Up Tier X]</span>
      <span class="rel-badge rel-[cold|warm|deal]">[COLD | WARM | DEAL]</span>
    </div>
  </div>

  <div class="thread-summary">[Thread summary: 1-2 sentences on last meaningful exchange]</div>

  <!-- Champion context (First Touch only, if found) -->
  <div class="champion-box" style="background: rgba(168,85,247,0.08); border: 1px solid rgba(168,85,247,0.25); border-radius: 6px; padding: 8px 12px; margin-bottom: 8px; font-size: 13px;">
    <strong style="color: #a855f7;">Champion:</strong> [Champion Name] ([Title]) — [brief engagement context]
  </div>

  <!-- Research context -->
  <div class="context-box">
    <strong>Profile:</strong> [summary]<br>
    <span class="news-tag">Recent: [hook / news]</span>
  </div>

  <!-- Email section -->
  <div class="email-section">
    <div class="email-label">To: [email]</div>
    <div class="email-subject"><strong>Subject:</strong> [subject line]</div>
    <div class="email-body" contenteditable="true">[full email body with signature]</div>
  </div>

  <!-- LinkedIn DM section -->
  <div class="dm-section">
    <div class="dm-label">LinkedIn DM:</div>
    <div class="dm-body" contenteditable="true">[DM text]</div>
  </div>

  <!-- LinkedIn InMail section (Tier 1 only) -->
  <div class="inmail-section">
    <div class="inmail-label">LinkedIn InMail:</div>
    <div class="inmail-subject"><strong>Subject:</strong> [subject]</div>
    <div class="inmail-body" contenteditable="true">[InMail text]</div>
  </div>

  <!-- Action buttons -->
  <div class="card-actions">
    <input type="checkbox" class="row-select" onchange="updateBulkBar()">
    <button class="btn btn-copy" onclick="copyEmail(this)">Copy Email</button>
    <button class="btn btn-gmail" onclick="openGmail(this, '[email]')">Send via Gmail</button>
  </div>
</div>
```

**Dashboard must include:**
- Editable email/DM/InMail content (contenteditable divs)
- Copy to clipboard buttons
- Gmail compose buttons
- Bulk select with "Select All" + "Copy All"
- Filter buttons that show/hide cards
- Dark theme (navy/blue palette matching Fortline brand: --navy #09141F, --blue #1A56C4, --gold #C8A84B)
- Mode badge colors: First Touch = green, Follow-Up Tier 3 = blue, Tier 2 = amber, Tier 1 = red

**Gmail compose URL format:**
```javascript
function openGmail(btn, email) {
    const card = btn.closest('.card');
    const subject = encodeURIComponent(card.querySelector('.email-subject').textContent.replace('Subject: ', ''));
    const body = encodeURIComponent(card.querySelector('.email-body').innerText);
    window.open('https://mail.google.com/mail/u/0/?view=cm&to=' + encodeURIComponent(email) + '&su=' + subject + '&body=' + body, '_blank');
}
```

---

## Step 5: Execute (after Eddie confirms)

### POST-SEND CHECKLIST — MANDATORY FOR EVERY EMAIL SENT

After each email is sent, complete ALL of these steps before moving to the next contact:

1. ✅ **BCC HubSpot** — Email must include the HubSpot BCC address in BCC. If missed at send time, log the email manually as a note on the contact record.
2. ✅ **Set Gmail reminder/label** — Apply a "Follow-Up in 7 days" label or create a HubSpot task with the follow-up date.
3. ✅ **HubSpot activity log** — Log the outreach as an activity on the contact: date, email subject, LinkedIn action taken, reminder date.

### Email Sending

**All email sending is via Gmail.** There is no Superhuman for Fortline outreach.

**BCC RULE (mandatory):** Every outbound email MUST include the HubSpot BCC address. This ensures all outreach is logged against the contact record.

**For First Touch and Tier 2 (new thread):** Use Gmail compose (via Gmail MCP `gmail_send_draft` or directly via Chrome) with the contact's email in To:, subject, body, and HubSpot BCC.

**For Tier 3 (reply in existing thread):** Use Gmail reply in the existing thread. Use `gmail_create_draft` with the `threadId` AND the `to` parameter explicitly set to the prospect's email address. This prevents replies going to incorrect addresses when reminders are the last message in the thread.

#### Gmail MCP Reply Workflow (for Tier 3)

1. Find the thread: `gmail_search_messages` with `to:<prospect_email>`
2. Read the thread: `gmail_read_thread` to confirm contents and recipient email
3. Create draft reply: `gmail_create_draft` with `threadId` AND explicit `to` parameter. Include HubSpot BCC.
4. Send: Open the draft in Chrome (`https://mail.google.com/mail/u/0/#drafts?compose=<messageId>`) or use `gmail_send_draft` if available.

#### Post-Send Email Housekeeping

After sending each email:
1. **Create HubSpot follow-up task** or apply a Gmail label for +7 days follow-up
2. **Log the activity** in HubSpot: date, email subject, channel, next follow-up date

### LinkedIn Execution

Use Chrome browser tools for all LinkedIn actions:

**Connection Requests (First Touch + Tier 3/2 for non-connected):**
1. Navigate to their LinkedIn profile
2. Screenshot to assess the page
3. Determine connection state and follow the appropriate flow
4. Click "Send without a note"
5. Screenshot to confirm
6. Wait 2-3 seconds between requests

**DMs (for connected contacts):**
1. Open contact's LinkedIn profile
2. Click "Message"
3. Type and send the DM text
4. Click "Sync chat" (Surfe button) if visible

**InMails (Tier 1, non-connected):**
1. Open via Sales Navigator or LinkedIn InMail
2. Fill subject line and body
3. Send

**If LinkedIn shows "weekly invitation limit":** STOP immediately and inform Eddie.

### Batch Execution

For batch mode, after Eddie reviews the dashboard:
1. Ask: "Ready to send? Any contacts to skip or edits to make?"
2. Send emails in parallel batches of 5
3. Post-send housekeeping (HubSpot logging + follow-up tasks) for each contact
4. Process LinkedIn actions sequentially (2-3 second gaps)
5. Report results as you go

---

## Step 6: Track, Report Results, and Send Hook Evidence Report

### Single Contact
```
[Name] - [Organization] - [Mode: First Touch / Follow-Up Tier X]
  Email: Sent / Skipped (Tier 1)
  LinkedIn: Connected → DM sent / Not connected → Request sent / InMail sent
  Hook: "[claim]" — Source: [URL] — Date: [source date] — Status: Verified/Partial/Stale
```

### Batch
```
## Prospect Outreach Complete — Fortline Global

### Summary
- Total contacts: [X]
- First Touch: [X]
- Follow-Up: [X] (Tier 3: [X], Tier 2: [X], Tier 1: [X])

### Emails
- [X] sent via Gmail (new thread)
- [X] sent via Gmail (reply-all)
- [X] skipped (Tier 1 - email dead)

### LinkedIn
- [X] connection requests sent
- [X] DMs sent (already connected)
- [X] InMails sent (Tier 1, not connected)

### HubSpot Logging
- [X] activities logged
- [X] follow-up tasks created
```

### Post-Send Hook Evidence Report (mandatory for every batch)

After all emails in a batch are sent, compile a Hook Evidence Report.

| Column | Description |
|--------|-------------|
| Contact | Full name |
| Organization | Organization name |
| Hook Claim | The specific factual claim used in the email |
| Source URL | The URL that confirms the claim |
| Source Date | The publication date |
| Freshness | Fresh (within 3 months) / Stale |
| Status | Verified / Partial / Stale / Inaccurate |

Deliver as:
1. **HTML dashboard** saved to `/sessions/[session]/mnt/outputs/[batch-name]-hook-evidence.html`
2. **Email to Eddie** via Gmail: send to eddie@fortlineglobal.com with subject "Hook Evidence Report: [batch name]". Body: clean HTML summary table with all columns, plus a summary line at the top.

---

## Step 7: Self-Evaluation Scorecard (MANDATORY after every execution)

Run this scorecard on every contact before declaring the batch done. **Strong or pass. A weak output is worse than no output.**

### How Scoring Works

| Score | Meaning | Action |
|-------|---------|--------|
| **STRONG** | Fully executed, high quality | Ship it |
| **PASS** | Not applicable or intentionally skipped with valid reason | Acceptable, log the reason |
| **FAIL** | Weak execution, missing data, shortcut taken | **BLOCK. Do not send. Fix or flag.** |

---

### Category 1: Research Depth

| # | Check | STRONG | PASS | FAIL |
|---|-------|--------|------|------|
| 1.1 | **Full CRM lookup**: All engagements pulled | All data pulled and reviewed | Contact not in HubSpot | Engagements not fully pulled |
| 1.2 | **Full email thread read**: Every thread read, not snippets | Every thread read in full | No email threads exist | Drafted based on snippet only |
| 1.3 | **LinkedIn DM verification via Chrome**: Full conversation read | Chrome verification done | No LinkedIn profile available | Skipped Chrome check |
| 1.4 | **Touchpoint count accuracy**: Count verified, tier correct | Count verified from multiple sources | N/A (always required) | Count based on incomplete data |
| 1.5 | **12-month lookback**: Full history reviewed | Full 12-month history reviewed | No activity in 12-month window | Only recent activity checked |
| 1.6 | **Contact relationship classification**: Correctly classified | Classification matches all evidence | N/A (always required) | Misclassified |
| 1.7 | **Disqualified check**: Status verified before drafting | Checked and confirmed | Not in HubSpot | Did not check, or drafted for DISQUALIFIED contact |

---

### Category 2: Hook Quality

| # | Check | STRONG | PASS | FAIL |
|---|-------|--------|------|------|
| 2.1 | **Champion detection**: Searched HubSpot deals by organization | Champion found and woven in naturally | No deals at this organization (confirmed) | Deal exists but champion detection skipped |
| 2.2 | **Recent news/event hook**: Verified, within 3 months, organization-specific | Source URL confirmed, dated within 3 months, correct organization | No news within 3 months, fell back to role/CRM hook | Used stale news, unverified claim, or wrong organization |
| 2.3 | **Hook verification**: Every claim web-searched | Source URL recorded, date confirmed, fact confirmed | Hook is role-based or CRM-based (no factual claim to verify) | Claim used without verification |
| 2.4 | **Hook specificity**: References specific initiative/incident/person, not generic | Mentions specific detail | DEAL contact (no hook needed) | Hook is generic |
| 2.5 | **No weak hooks shipped**: All hooks are strong or replaced with pass | All hooks verified and specific | Contact flagged for Eddie's review — no strong hook available | Weak hook made it into final draft |

---

### Category 3: Message Quality

| # | Check | STRONG | PASS | FAIL |
|---|-------|--------|------|------|
| 3.1 | **Eddie's intro rotation**: Different approved variation, never "I'm Eddie, Strategic Advisor at Fortline Global" | Unique intro from approved pool | DEAL contact (no intro needed) | Used banned intro format or reused same intro |
| 3.2 | **Dash scan**: Zero em-dashes, en-dashes, or hyphens-as-separators | Literal character search done, zero dashes | N/A | Any dash in final output |
| 3.3 | **Banned phrase scan**: Zero banned phrases | Literal check done against full banned list | N/A | Any banned phrase found |
| 3.4 | **CRM context referenced**: Specific past interaction mentioned if it exists | Referenced | No CRM activity exists | Activity exists but email reads like first touch |
| 3.5 | **Word count**: ~80-100 words (excluding signature) | Within range | Slightly over/under but reads well | Wall of text or too short |
| 3.6 | **CTA from approved pool**: No "if not" safety nets, no filler closers | Clean CTA, from the approved list | N/A | Unapproved CTA or filler closer present |
| 3.7 | **Value bridge structure**: Opens with "If..." — specific named scenarios, no explanation of why it matters | Follows the gold-standard structure | N/A | Generic bridge, lecture format, or brochure language |
| 3.8 | **DEAL contacts: no cold intro, no pitch** | Reads like a colleague following up | N/A (contact is COLD or WARM) | DEAL contact got standard cold email |
| 3.9 | **Would a senior defense/government official respond to this?** | Yes, reads credible, specific, human | N/A | Reads like AI-generated template |

---

### Category 4: Channel Coverage

| # | Check | STRONG | PASS | FAIL |
|---|-------|--------|------|------|
| 4.1 | **Multi-channel per action table**: All applicable channels mapped | All channels present per tier and connection status | Tier 1: no email (correct) | Email drafted but LinkedIn action missing |
| 4.2 | **LinkedIn connection status verified**: Checked via Chrome | Status confirmed | N/A | Assumed connection status without checking |
| 4.3 | **Thread reply vs. new thread**: Tier 3 replies in existing thread, Tier 2 starts new | Correct thread handling | N/A | Wrong thread handling |
| 4.4 | **HubSpot BCC**: HubSpot BCC address included on all outbound emails | BCC confirmed | N/A | BCC missing on any sent email |

---

### Category 5: Post-Send Operations

| # | Check | STRONG | PASS | FAIL |
|---|-------|--------|------|------|
| 5.1 | **Follow-up task created**: HubSpot task or Gmail label set for +7 days | Confirmed for every sent email | N/A | Any email left without a follow-up reminder |
| 5.2 | **HubSpot activity logged**: Outreach logged on contact record | Logged for every contact | N/A | Any contact without activity log |
| 5.3 | **LinkedIn actions executed**: All connection requests, DMs, InMails sent | All completed with 2-3 sec gaps | LinkedIn weekly limit hit (stopped and informed Eddie) | LinkedIn actions skipped without explanation |
| 5.4 | **Hook Evidence Report sent**: HTML dashboard created + email sent to eddie@fortlineglobal.com | Both deliverables completed | Single contact mode (inline report sufficient) | Report skipped |

---

### Scorecard Output Format

```
## Self-Evaluation Scorecard: [Batch Name / Contact Name]

### Overall
Total checks run: [X]
STRONG: [X] ([%])
PASS: [X] ([%])
FAIL: [X] ([%])
Batch grade: [A / B / C / BLOCKED]

### Grade Scale
A: 0 FAILs, 90%+ STRONG
B: 0 FAILs, 70-89% STRONG
C: 0 FAILs, <70% STRONG (review with Eddie before sending)
BLOCKED: 1+ FAILs (do NOT send, fix first)

### Per-Contact Breakdown
| Contact | Org | Research | Hooks | Message | Channels | Post-Send | Grade |
|---------|-----|----------|-------|---------|----------|-----------|-------|

### FAIL Details (if any)
[Contact Name]: [Check #, description of what failed and how to fix it]
```

### Enforcement Rules

1. **Any FAIL = BLOCKED.** Fix before presenting or sending.
2. **PASS requires a reason.** Every PASS must include a one-line justification.
3. **Run the scorecard TWICE per execution.** First run: before presenting drafts (Categories 1-4). Second run: after sending (Category 5 + re-check of Categories 1-4).
4. **In batch mode, include the scorecard as a collapsible section in the HTML dashboard.**
5. **The scorecard is non-negotiable.** Every execution, every contact.
6. **The scorecard is a prerequisite to Step 4.** No drafts may be presented until the first-run scorecard is complete and all FAILs resolved.

---

## Additional Rules

### Thread Hygiene
- If the existing thread contains bounce-backs, error messages, or messy chains, always start a new thread
- Bounce-backs do NOT count as emails sent

### OOO Auto-Replies
- Note when they were out and when they returned
- Use as context: "I sent you a note while you were traveling"

### HubSpot Updates
- If enrichment finds a new organizational email, log it as a HubSpot note (do not overwrite the existing email without Eddie's confirmation)
- If an email bounces, log it and flag to Eddie
- Log all outreach activities

### Rate Limiting
- LinkedIn connection requests: process in batches of 10-15
- Emails: send in parallel batches of 5
- Wait 2-3 seconds between LinkedIn actions

---

## Fortline Global Context

- **Company:** Fortline Global (fortlineglobal.com)
- **What Fortline does:** Structural hardening of new and existing buildings against missile strikes, drone strikes, blast overpressure, and unconventional threats (including CBRN), using a patented super-polymer spray technology. No demolition, no permits, deployed in days.
- **Credentials:** Israeli Ministry of Defense approved, IDF Home Front Command certified, 35+ years of live operational experience in Israel under multi-vector threat conditions.
- **Services:** (1) Protection Assessment & Advisory — on-site engineering survey delivering a classified Protection Vulnerability Report under NDA. (2) Physical Building Hardening. (3) Population Preparedness (GEM). (4) National Regulatory Framework advisory.
- **First step / entry point:** Always the confidential protection assessment. No commitment required. Classified deliverable under NDA.
- **Eddie's role:** Strategic Advisor, Founding Team
- **Eddie's email:** eddie@fortlineglobal.com
- **Phone:** (646) 338-3012
- **Key sectors:** Government and defense infrastructure (Ministries, NATO facilities, command centers, border infrastructure), Critical infrastructure (power grids, gas pipelines, data centers, water treatment), Eastern Flank priority nations (Poland, Estonia, Latvia, Lithuania, Finland, Romania), Public/essential services (hospitals, schools, transport hubs, emergency services)
- **Value prop framing:** Never pitch features or services. Frame as: "if this specific exposure is your hard part, that's exactly what we've built a methodology for." Then offer the confidential assessment as the no-commitment first step.
- **Geographic focus:** Israel and Europe, with particular focus on NATO Eastern Flank nations.

---

## Common Issues & Fixes

**No recent news found (older than 3 months):** Write a role-based or CRM-based email focused on the contact's title, responsibilities, and the specific protection gap relevant to their function. Do NOT use stale news as a hook.

**Em-dashes in generated messages:** Always do a final pass: search for all dashes and replace with commas or periods.

**Contact is a government official with no public email:** Flag to Eddie — outreach to government officials often requires a formal introduction or a warm path in rather than cold outreach. Suggest an alternative approach (mutual contact, event, formal inquiry channel).

**LinkedIn weekly invitation limit:** STOP immediately and inform Eddie. Complete remaining work (emails, dashboard) without LinkedIn actions.

**Contact at NATO or EU institutional email:** These addresses often have strict spam/security filters. Keep email subject lines clean and professional. Avoid marketing-sounding subject lines entirely.
