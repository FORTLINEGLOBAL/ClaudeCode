// Eddie's profile, target criteria and writing voice. Everything the LLM needs to
// score opportunities and draft messages lives here so it is easy to tune.

export const EDDIE = {
  name: "Eddie Nudel",
  firstName: "Eddie",
  location: "Tel Aviv, Israel",
  travel: "travels ~40% of the time, open to relocation for the right role",
  phones: { us: "+1-646-338-3012", il: "+972-54-3203976" },
  linkedin: "https://www.linkedin.com/in/eddienudel",
  email: "eddie.nudel@gmail.com",
};

export const RESUME_SUMMARY = `
Eddie Nudel. Scaling from $1M to $1B+ ARR. ex-monday.com and AppsFlyer.
Expertise: revenue growth, GTM strategy and ops, enterprise sales, AI, pricing, business models,
opening EMEA, US and APAC markets. Half of career carrying the number (enterprise sales), half
building the engine behind it (GTM / Rev Ops), often both at once.

2025-today: CRO, Flexor.AI (AI startup). Built the largest pipeline in company history with AI-driven outreach.
2024-2025: Executive Director, GTM Strategy and Operations, monday.com (NASDAQ: MNDY). Reported to both co-CEOs,
  revenue architecture from $1B toward $10B.
2019-2024: VP Business Strategy and GTM Operations, AppsFlyer ($4B valuation). Teams in IL and UK. +$100M revenue
  growth initiatives, new business models and pricing (+30% ACV), M&A due diligence and two post-merger integrations.
2015-2019: Head of Sales and BD, Minute.ly. Closed Disney, BBC, Viacom, NBA, NFL. Enterprise sales in N. America and EMEA.
2014-2015: Founder and CEO, Engage X1 (raised $1.5M).
2012-2014: CRO, Prana Essentials. 2010-2012: CEO, Goome Interactive. 2007-2010: Head of Product Marketing, Orange.
Education: HBS CORe, Tel Aviv University MBA, Ben Gurion University BSc Computer Engineering.
`.trim();

// ---------- Hunter 1: jobs in Israel ----------
export const JOB_TARGET = {
  location: "Israel",
  // Titles we consider relevant. Used for search queries and for LLM scoring guidance.
  titleKeywords: [
    "VP Sales", "Chief Revenue Officer", "CRO", "VP Revenue", "Head of Sales", "GM", "General Manager",
    "VP GTM", "Head of GTM", "Go-to-Market", "VP Business Development", "VP Commercial", "Chief Commercial Officer",
    "Revenue Operations", "RevOps", "GTM Operations", "Business Operations", "BizOps", "VP Strategy",
    "Head of Revenue Operations", "Director Revenue Operations", "Country Manager", "Regional Director",
  ],
  minSeniority: "Director and above (Director, Head of, VP, SVP, C-level, GM). Senior IC roles are not relevant.",
  // Search queries fed to the LinkedIn guest jobs endpoint and Google News.
  searchQueries: [
    "VP Sales", "Chief Revenue Officer", "Head of Sales", "VP Revenue", "General Manager",
    "Revenue Operations", "GTM Operations", "Business Operations", "VP Business Development", "VP GTM",
  ],
};

// ---------- Hunter 2: emerging companies ----------
export const EMERGING_TARGET = {
  minRaiseUSD: 75_000_000,
  // Sectors of interest for the LLM classifier.
  sectors: "AI (models, inference, agents, infra), developer/data infrastructure, and B2B applications such as CRM, sales tech, work management, martech, fintech infra",
  // Titles to look for at target companies.
  execTitles: [
    "CEO", "Chief Revenue Officer", "CRO", "COO", "Chief Commercial Officer", "President",
    "VP International", "Head of International", "VP EMEA", "GM EMEA", "VP APAC", "GM APAC",
    "Managing Director", "VP Sales", "Head of Sales", "VP Go-to-Market", "Chief Business Officer",
  ],
  // Seed examples the user gave; scanning adds more automatically.
  seedCompanies: ["Cognition", "Baseten", "Together AI"],
};

// ---------- Hunter 3: large AI labs and platforms ----------
export const BIG_COMPANIES: Array<{ name: string; ats?: { kind: "greenhouse" | "lever" | "ashby"; slug: string } }> = [
  { name: "OpenAI", ats: { kind: "ashby", slug: "openai" } },
  { name: "Anthropic", ats: { kind: "greenhouse", slug: "anthropic" } },
  { name: "Mistral AI", ats: { kind: "lever", slug: "mistral" } },
  { name: "Cohere", ats: { kind: "ashby", slug: "cohere" } },
  { name: "Together AI", ats: { kind: "ashby", slug: "together-ai" } },
  { name: "Baseten", ats: { kind: "ashby", slug: "baseten" } },
  { name: "Cognition", ats: { kind: "ashby", slug: "cognition" } },
  { name: "Scale AI", ats: { kind: "greenhouse", slug: "scaleai" } },
  { name: "Databricks", ats: { kind: "greenhouse", slug: "databricks" } },
  { name: "Perplexity", ats: { kind: "ashby", slug: "perplexity" } },
  { name: "ElevenLabs", ats: { kind: "ashby", slug: "elevenlabs" } },
  { name: "Glean", ats: { kind: "greenhouse", slug: "gleanwork" } },
  { name: "Writer", ats: { kind: "ashby", slug: "writer" } },
  { name: "Fireworks AI", ats: { kind: "ashby", slug: "fireworks-ai" } },
  { name: "Cursor (Anysphere)", ats: { kind: "ashby", slug: "cursor" } },
  { name: "Harvey", ats: { kind: "ashby", slug: "harvey" } },
  { name: "Sierra", ats: { kind: "ashby", slug: "sierra" } },
  { name: "Snowflake", ats: { kind: "greenhouse", slug: "snowflakecomputing" } },
  { name: "HubSpot", ats: { kind: "greenhouse", slug: "hubspotjobs" } },
];

// Regions Eddie can offer to open, depending on where the company is based.
export function expansionPitchFor(hqRegion: string): string {
  const r = hqRegion.toLowerCase();
  if (r.includes("us") || r.includes("united states") || r.includes("north america") || r.includes("canada")) {
    return "opening and scaling EMEA and APAC (Israel as a base, London/Europe and APAC coverage)";
  }
  return "opening and scaling the US market (Eddie has a US number, US enterprise track record and travels there regularly), plus EMEA where needed";
}

// ---------- Writing voice (distilled from Eddie's writing-guidelines skill, adapted to job outreach) ----------
export const VOICE_RULES = `
You write LinkedIn DMs on behalf of Eddie Nudel, a senior GTM executive looking for his next role.
Peer to peer, executive to executive. Warm, direct, no fluff. Never pitch, never grovel, never sound templated.

Hard rules:
- LinkedIn DM: 2 to 4 sentences for a first touch, 1 to 2 sentences for a follow-up. Under 90 words.
- Open with something real: a mutual connection, a specific fact about the company (recent raise, expansion, product),
  or a prior interaction. Never open with an industry statement or "Hope you're doing well".
- Say plainly what Eddie wants: to join the team, to open a region, to talk about a specific role.
- One credibility line max, drawn from the resume (e.g. "20 years of enterprise sales and ops, $0 to $1.3B ARR, last 8 in VP/C-suite roles in Tel Aviv").
- One CTA, low friction: a short intro call, a virtual coffee, or "point me to whoever owns EMEA hiring".
- No "if not, no worries" safety nets. No filler closers after the CTA.
- No dashes of any kind (no em-dash, en-dash, or hyphen used as a separator). Use commas or periods.
- Banned: "I've noticed", "Curious if", "Wondering if", "Quick question", "Just wanted to", "Would you be open to",
  "Touching base", "Circling back", "Leverage", "Resonates", "Happy to share", "Hope you're doing well",
  "cold message", "cold outreach", "no joke", "no small feat", any corporate buzzword.
- Follow-ups must add something new (travel to their city, a relevant intro, a new angle like "I can do sales and ops in one role",
  or a concrete offer such as mentioning their product to accounts Eddie is meeting). Never "just following up".
- Sign off with "Eddie" on its own line. Include the phone numbers only in a first touch.
- Vary phrasing between contacts. If a reader could tell an AI wrote it, rewrite.

Reference examples of Eddie's real DMs (match this register):

Example A (emerging company, EMEA VP):
"Hi James, Jon Fields suggested to talk to you.
I'm reaching out to see if Together is hiring GTM execs to the EMEA market... IMO you guys are one of best Inference as a Service companies, a space I want to be part of.
I've 20 years of enterprise sales & ops (scaling from $0 to $1.3B ARR, last 8 in VP/C-suite roles in Tel Aviv), specializing in building revenue engines and opening EMEA & US markets.
I hope it's enough for a short intro call with you or someone else in the company ...
Thanks, Eddie"

Example B (big lab, MD International):
"Hi Oliver, I'd like to work in your department at OpenAI.
I've spent half my career carrying the number (Enterprise Sales) and half building the engine behind it (GTM Ops), usually at the same time. monday.com (+$1B ARR), AppsFlyer ($500M), and a few early-stage ones before that, including raising the round for my own gig. Across the US, Europe and APAC.
I hope it's enough to convince you to have a short virtual coffee ...
Eddie"

Example C (follow-up that adds something):
"Hi James, I'll be meeting a few prospects in London on the 14th and 15th of September and thought it could be nice to grab a quick coffee if you're around.
Who knows, maybe something could make sense to work on together in the future, so it'd be great to connect in person"
`.trim();
