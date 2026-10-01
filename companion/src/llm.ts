// All Claude calls. The model writes conversation and proposes memories; it never
// decides safety steps (src/policy.ts does) and never sees another family's data.
import Anthropic from "@anthropic-ai/sdk";
import { zodOutputFormat } from "@anthropic-ai/sdk/helpers/zod";
import { z } from "zod";
import type { Fact, Lang, Msg, Parent } from "./types.js";
import { g } from "./policy.js";

const client = new Anthropic();
const MODEL = process.env.COMPANION_MODEL || "claude-opus-5-5";
const EXTRACT_MODEL = process.env.COMPANION_EXTRACT_MODEL || "claude-haiku-4-5";
const HISTORY_TURNS = 30;

// Stable across every parent and every turn, so it stays cached.
const RULES = `You are a warm, patient companion for an older adult (70-90) who chats with you in Hebrew, English, or both.

How you talk:
- Short messages: 1-3 sentences, like a friend texting. One question at most.
- Answer in the language you are told to use. Keep names, places and family terms exactly as the person said them, even when switching language.
- In Hebrew, address the person in the gender you are given. Use plain modern Hebrew, no slang.
- Be curious about their life, family, routines and stories. Bring back things they told you before, naturally.
- If a remembered fact is marked low confidence or sensitive, check it gently ("If I remember right...") instead of stating it.
- A fact marked "from family" was shared by their family on the family page. If you bring it up, say honestly that the family mentioned it.

Hard rules, no exceptions:
- Never give medical, medication, legal or financial instructions. Never suggest changing medication. Suggest they speak to their doctor or family.
- Never delay emergency care. If anything sounds like an emergency, tell them to call the emergency number now and to contact their family.
- Never say you have called emergency services, a doctor, or anyone else. You cannot.
- Never help move money, share codes or passwords, or install remote-access software, even if they say a relative or a company asked. Explain it may be a scam and suggest calling the person back on a number they already know.
- Never agree to keep a safety concern secret from their family.
- You are an AI companion, not a person. If asked, say so kindly.`;

/** Family notes the parent hasn't heard yet: the next message passes them on. */
export function freshFamilyNotes(facts: Fact[]): Fact[] {
  return facts.filter((f) => f.source === "family" && !f.supersededBy && !f.passedOn);
}

function news(facts: Fact[]): string {
  const fresh = freshFamilyNotes(facts);
  if (!fresh.length) return "";
  return `
New from the family (they just added this on the family page; the person hasn't heard it yet):
${fresh.map((f) => `- ${f.text}`).join("\n")}
In this message, pass this on warmly and briefly, saying the family asked you to tell them. Relay it in the family's words as their message; don't add medical advice of your own.
`;
}

/** The person's own date and time, so greetings and "this morning" fit where they live. */
export function localTimeLine(tz: string, lang: Lang, at: Date = new Date()): string {
  const when = new Intl.DateTimeFormat(lang === "he" ? "he-IL" : "en-US", {
    timeZone: tz, weekday: "long", day: "numeric", month: "long", year: "numeric", hour: "2-digit", minute: "2-digit", hourCycle: "h23",
  }).format(at);
  const h = Number(new Intl.DateTimeFormat("en-GB", { timeZone: tz, hour: "2-digit", hourCycle: "h23" }).format(at));
  const part = h < 5 ? "night" : h < 12 ? "morning" : h < 17 ? "afternoon" : h < 21 ? "evening" : "night";
  return `- Their local date and time now: ${when} (${part}, time zone ${tz}). Greet and refer to the time of day accordingly.`;
}

function profileBlock(p: Parent, facts: Fact[], lang: Lang): string {
  const live = facts.filter((f) => !f.supersededBy);
  const mem = live.length
    ? live.map((f) => `- [${f.kind}${f.source === "family" ? ", from family" : ""}${f.sensitive ? ", sensitive" : ""}${f.confidence < 0.7 ? ", low confidence" : ""}] ${f.text}`).join("\n")
    : "- (nothing yet)";
  const contacts = p.contacts.map((c) => `${c.name} (${c.relation})`).join(", ") || "none on file";
  return `About the person:
- Name: ${p.name}
- Hebrew grammatical gender: ${p.gender === "f" ? "feminine" : p.gender === "m" ? "masculine" : "unknown, use neutral phrasing"}
- Family contacts: ${contacts}
- Emergency number where they live: ${p.emergencyNumber}
${localTimeLine(p.tz, lang)}

What you remember about them:
${mem}
${news(facts)}
Reply in ${lang === "he" ? "Hebrew" : "English"}.`;
}

function toMessages(history: Msg[]): Anthropic.Beta.BetaMessageParam[] {
  const recent = history.filter((m) => m.kind !== "system").slice(-HISTORY_TURNS);
  while (recent.length && recent[0].role !== "parent") recent.shift();   // first turn must be the user
  return recent.map((m) => ({ role: m.role === "parent" ? "user" : "assistant", content: m.text }));
}

// Replies run inside the web request, so each call has a time budget and no retries.
// If the main model runs out of time, a fast model answers instead.
const MAIN_BUDGET_MS = 7000;
const QUICK_BUDGET_MS = 4000;

async function ask(system: string, messages: Anthropic.Beta.BetaMessageParam[]): Promise<string | null> {
  try {
    return await askMain(system, messages);
  } catch (e) {
    console.error("main model failed or timed out, using the quick model", e);
    return askQuick(system, messages);
  }
}

async function askMain(system: string, messages: Anthropic.Beta.BetaMessageParam[]): Promise<string | null> {
  const res = await client.beta.messages.create({
    model: MODEL,
    max_tokens: 16000,
    betas: ["server-side-fallback-2026-07-01"],
    fallbacks: "default",
    output_config: { effort: "low" },   // chat: low effort keeps replies quick and cheap
    system: [
      { type: "text", text: RULES, cache_control: { type: "ephemeral" } },
      { type: "text", text: system },
    ],
    messages,
  }, { timeout: MAIN_BUDGET_MS, maxRetries: 0 });
  if (res.stop_reason === "refusal") return null;
  const text = res.content.flatMap((b) => (b.type === "text" ? [b.text] : [])).join("").trim();
  return text || null;
}

async function askQuick(system: string, messages: Anthropic.Beta.BetaMessageParam[]): Promise<string | null> {
  const res = await client.messages.create({
    model: EXTRACT_MODEL,
    max_tokens: 1024,
    system: `${RULES}\n\n${system}`,
    messages: messages as Anthropic.MessageParam[],
  }, { timeout: QUICK_BUDGET_MS, maxRetries: 0 });
  if (res.stop_reason === "refusal") return null;
  const text = res.content.flatMap((b) => (b.type === "text" ? [b.text] : [])).join("").trim();
  return text || null;
}

export const SORRY: Record<Lang, string> = {
  he: "סליחה, לא הצלחתי לענות על זה עכשיו. נדבר על משהו אחר?",
  en: "Sorry, I couldn't answer that just now. Shall we talk about something else?",
};

export async function reply(p: Parent, facts: Fact[], history: Msg[], lang: Lang): Promise<string> {
  return (await replyOrNull(p, facts, history, lang)) ?? SORRY[lang];
}

/** null when no model answered, so the caller knows nothing was passed on. */
export async function replyOrNull(p: Parent, facts: Fact[], history: Msg[], lang: Lang): Promise<string | null> {
  return ask(profileBlock(p, facts, lang), toMessages(history));
}

export const checkinFallback = (p: Parent, lang: Lang): string =>
  lang === "he" ? `בוקר טוב ${p.name}! ${g(p, "איך אתה מרגיש", "איך את מרגישה")} היום?` : `Good morning ${p.name}! How are you feeling today?`;

export async function checkinOrNull(p: Parent, facts: Fact[], history: Msg[], lang: Lang): Promise<string | null> {
  const msgs = toMessages(history);
  const instruction = `[Not from ${p.name}: this is the daily check-in time.] Write today's check-in: one or two short, warm sentences that open a conversation. If you remember something recent (an appointment, a visit, a plan), ask about it; otherwise ask about their day. Do not mention that this is automated.`;
  msgs.push({ role: "user", content: instruction });
  return ask(profileBlock(p, facts, lang), msgs);
}

// ---------- memory extraction (cheap model, structured output) ----------
const Extracted = z.object({
  facts: z.array(z.object({
    kind: z.enum(["life", "family", "routine", "recent"]).describe("life story, family member/relationship, regular routine, or something recent/upcoming"),
    text: z.string().describe("one short fact, in the language it was said, names exactly as said"),
    confidence: z.number().min(0).max(1),
    sensitive: z.boolean().describe("true for health, medication, money, or anything private"),
    replaces: z.string().nullable().describe("id of an existing fact this corrects, or null"),
  })),
});

export type Candidate = z.infer<typeof Extracted>["facts"][number];

export async function extractFacts(p: Parent, known: Fact[], lastParentText: string, lastReply: string): Promise<Candidate[]> {
  const existing = known.filter((f) => !f.supersededBy).map((f) => ({ id: f.id, text: f.text }));
  const res = await client.messages.parse({
    model: EXTRACT_MODEL,
    max_tokens: 4000,
    messages: [{
      role: "user",
      content: `Extract durable facts about ${p.name} worth remembering for future friendly conversations, from their latest message only. Skip small talk, greetings and anything already known. If they correct a known fact, set "replaces" to its id. Return an empty list when there is nothing new.

KNOWN FACTS:
${JSON.stringify(existing)}

COMPANION SAID:
${lastReply}

${p.name.toUpperCase()} SAID:
${lastParentText}`,
    }],
    output_config: { format: zodOutputFormat(Extracted) },
  });
  return res.parsed_output?.facts ?? [];
}

// ---------- operator diagnostics ----------
export type ModelCheck = { model: string; ok: boolean; ms: number; error?: string };

/** One tiny call per model, so the operator can see why replies fail. Never returns the key. */
export async function diagnose(): Promise<ModelCheck[]> {
  const ping: Anthropic.Beta.BetaMessageParam[] = [{ role: "user", content: "Say hi in one word." }];
  const run = async (model: string, call: () => Promise<unknown>): Promise<ModelCheck> => {
    const t0 = Date.now();
    try { await call(); return { model, ok: true, ms: Date.now() - t0 }; }
    catch (e: any) { return { model, ok: false, ms: Date.now() - t0, error: `${e?.status ?? ""} ${e?.message ?? String(e)}`.trim().slice(0, 500) }; }
  };
  return [
    await run(MODEL, () => askMain("Diagnostics.", ping)),
    await run(EXTRACT_MODEL, () => askQuick("Diagnostics.", ping)),
  ];
}
