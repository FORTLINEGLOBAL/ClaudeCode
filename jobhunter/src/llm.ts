// All Claude calls. Structured outputs via zod so the rest of the code never parses free text.
import Anthropic from "@anthropic-ai/sdk";
import { zodOutputFormat } from "@anthropic-ai/sdk/helpers/zod";
// zod v4 is required, not optional: the SDK's zodOutputFormat calls z.toJSONSchema
// from "zod/v4", which reads schema._zod. A v3 schema has no _zod, so it throws
// "Cannot read properties of undefined (reading 'def')" and every Claude call fails.
import { z } from "zod";
import { EDDIE, RESUME_SUMMARY, JOB_TARGET, EMERGING_TARGET, VOICE_RULES, expansionPitchFor } from "./profile.js";

const client = new Anthropic();
const MODEL = process.env.JOBHUNTER_MODEL || "claude-opus-5";

const SYSTEM_PROFILE = `You are the private job-search agent of ${EDDIE.name}, based in ${EDDIE.location} (${EDDIE.travel}).

RESUME:
${RESUME_SUMMARY}

TARGETS:
- Jobs: senior commercial / GTM roles or GTM / Revenue / Business Operations roles, based in ${JOB_TARGET.location}. ${JOB_TARGET.minSeniority}
- Emerging companies: raised $${EMERGING_TARGET.minRaiseUSD / 1e6}M+ recently, sectors: ${EMERGING_TARGET.sectors}, looking at international expansion.
- Large AI labs and platforms: OpenAI, Anthropic, Mistral and similar; international / regional GTM leadership.`;

async function parse<T extends z.ZodType>(schema: T, user: string, opts?: { effort?: "low" | "medium" | "high" }): Promise<z.infer<T>> {
  const res = await client.messages.parse({
    model: MODEL,
    max_tokens: 4000,
    system: [{ type: "text", text: SYSTEM_PROFILE, cache_control: { type: "ephemeral" } }],
    messages: [{ role: "user", content: user }],
    output_config: { format: zodOutputFormat(schema), effort: opts?.effort ?? "medium" },
  });
  if (!res.parsed_output) throw new Error(`LLM returned unparseable output (stop_reason=${res.stop_reason})`);
  return res.parsed_output;
}

// ---------- Job scoring ----------
const JobScore = z.object({
  scores: z.array(z.object({ id: z.string(), score: z.number().min(0).max(100), reason: z.string() })),
});

export async function scoreJobs(jobs: Array<{ id: string; title: string; company: string; location: string; snippet?: string }>) {
  if (!jobs.length) return [];
  const out = await parse(JobScore, `Score each job 0..100 for fit with Eddie's job target (relevance of function, seniority, Israel location).
Score >= 70 only for Director+ commercial/GTM/RevOps/BizOps roles in Israel (or explicitly remote from Israel). Reason in under 15 words.
JOBS:\n${JSON.stringify(jobs, null, 1)}`, { effort: "low" });
  return out.scores;
}

// ---------- Funding news extraction ----------
const Funding = z.object({
  companies: z.array(z.object({
    name: z.string(),
    hq: z.string().describe("country or 'US' / 'EMEA' / 'APAC' / 'Israel' / 'unknown'"),
    raisedUSD: z.number().describe("amount in USD, 0 if unknown"),
    round: z.string(),
    sector: z.string(),
    relevant: z.boolean().describe(`true if raisedUSD >= ${EMERGING_TARGET.minRaiseUSD} and sector matches targets`),
    internationalExpansionSignal: z.string().describe("quote or 'none'"),
    sourceUrl: z.string(),
  })),
});

export async function extractFunding(items: Array<{ title: string; snippet: string; url: string; date?: string }>) {
  if (!items.length) return [];
  const out = await parse(Funding, `From these news items, extract funding rounds. Be strict about amounts. Ignore items that are not a primary funding announcement.
ITEMS:\n${JSON.stringify(items, null, 1)}`, { effort: "low" });
  return out.companies;
}

// ---------- People selection ----------
const People = z.object({
  people: z.array(z.object({
    name: z.string(), title: z.string(), company: z.string(), linkedinUrl: z.string(),
    priority: z.number().min(1).max(5).describe("1 = best person to DM"),
    role: z.enum(["c_suite", "regional_leader", "other"]),
    reason: z.string(),
  })),
});

export async function pickPeople(company: string, candidates: Array<{ title: string; url: string; snippet?: string }>) {
  if (!candidates.length) return [];
  const out = await parse(People, `These are search results for LinkedIn profiles at ${company}. Keep only real people currently at ${company} who are
C-suite, founders, CRO/COO/CCO, VP/Head of International, or regional GM/VP (EMEA, APAC, US). Extract clean name and title.
Prefer regional leaders (Eddie can join their team) and CEO/CRO (Eddie can offer to open a region). Max 3 people.
RESULTS:\n${JSON.stringify(candidates, null, 1)}`, { effort: "low" });
  return out.people.sort((a, b) => a.priority - b.priority);
}

// ---------- Drafting ----------
const Draft = z.object({ message: z.string(), angle: z.string(), hookUsed: z.string() });

export interface DraftInput {
  name: string; title: string; company: string; hq?: string;
  facts: string[];             // verified facts with source URLs
  hasRegionalLeader?: boolean; // true when the person IS a regional leader
  openRoles?: string[];        // relevant open roles at the company, if any
  priorTouches?: Array<{ n: number; text: string; sentAt: string }>;
  instruction?: string;        // rewrite instruction from Eddie
}

export async function draftDM(input: DraftInput) {
  const firstTouch = !input.priorTouches?.length;
  const region = input.hq ? expansionPitchFor(input.hq) : "opening EMEA and APAC, or the US, depending on where they are";
  const angleHint = input.hasRegionalLeader
    ? `${input.name} leads a region at ${input.company}. Angle: Eddie wants to join their team / their region's GTM leadership.`
    : `${input.name} is a senior executive at ${input.company}. Angle: Eddie offers ${region}; ask who owns international GTM hiring.`;
  const roles = input.openRoles?.length ? `Relevant open roles at ${input.company}: ${input.openRoles.join("; ")}. Mention at most one if it fits.` : "No relevant open roles found; treat as a proactive approach.";
  const prior = firstTouch ? "This is the FIRST touch." : `Prior messages Eddie sent (write follow-up #${input.priorTouches!.length + 1}, must add something new):\n${input.priorTouches!.map((t) => `#${t.n} (${t.sentAt.slice(0, 10)}): ${t.text}`).join("\n")}`;
  const facts = input.facts.length ? `Verified facts you may reference (cite none if not needed):\n${input.facts.map((f) => "- " + f).join("\n")}` : "No verified company facts available. Do NOT invent any.";
  const out = await parse(Draft, `${VOICE_RULES}

TASK: write a LinkedIn DM from Eddie to ${input.name}, ${input.title} at ${input.company}${input.hq ? ` (HQ: ${input.hq})` : ""}.
${angleHint}
${roles}
${facts}
${prior}
${input.instruction ? `Eddie's rewrite instruction: ${input.instruction}` : ""}
Return the message text only in "message" (ready to paste), the angle in one line, and which fact you used (or "none").`, { effort: "high" });
  return out;
}

// ---------- Reply suggestion ----------
export async function suggestReply(contact: { name: string; company: string; touches: Array<{ text: string; sentAt: string }> }, theirReply: string) {
  const out = await parse(Draft, `${VOICE_RULES}

${contact.name} at ${contact.company} replied to Eddie. Draft Eddie's reply (1 to 3 sentences). Address what they said directly, then move to one concrete next step.
Eddie's earlier messages:\n${contact.touches.map((t) => `(${t.sentAt.slice(0, 10)}) ${t.text}`).join("\n")}
THEIR REPLY: ${theirReply}`, { effort: "high" });
  return out;
}

// ---------- WhatsApp command interpretation ----------
export const Intent = z.object({
  action: z.enum([
    "digest", "show", "sent", "skip", "rewrite", "replied", "find_contacts", "add_company", "block_company",
    "status", "pause", "resume", "help", "set_cap", "scan_now", "diag", "unknown",
  ]),
  numbers: z.array(z.number()).describe("queue item numbers referenced, if any"),
  company: z.string().describe("company name if referenced, else empty"),
  text: z.string().describe("free text payload: rewrite instruction, reply text, etc."),
  value: z.number().describe("numeric value for set_cap, else 0"),
});

export async function interpret(message: string) {
  return parse(Intent, `Map this WhatsApp message from Eddie to one action.
Actions: digest (show pending items), show N (full draft), sent N[,N] (Eddie sent the DM), skip N or skip <company>, rewrite N <instruction>,
replied N: <their reply text>, find_contacts <company>, add_company <company>, block_company <company>, status, pause, resume, help, set_cap <n>, scan_now, diag (check whether the data sources are working).
MESSAGE: ${message}`, { effort: "low" });
}
