// The companion core: what happens when a parent writes, and when it is time to
// check in. Channel-agnostic; safety paths are deterministic and never wait on a model.
import type { Channel } from "./channel.js";
import type { Fact, Lang, Msg, Parent } from "./types.js";
import { addAlert, getChat, getFacts, newId, saveFacts, saveParent } from "./store.js";
import { chooseLang, g, isSos, isStart, isStop, sosReply, startReply, stopReply, withinCoverage } from "./policy.js";
import { SORRY, checkinFallback, checkinOrNull, extractFacts, freshFamilyNotes, replyOrNull, type Candidate } from "./llm.js";
import { notifyOperator } from "./operator.js";
import { familyScamEmail, isNo, isYes, scamCheck, scamReply, type Signal } from "./scam.js";
import { sendEmail } from "./mail.js";
import { localNow } from "./time.js";

const now = () => new Date().toISOString();
const msg = (role: Msg["role"], text: string, kind: Msg["kind"], lang?: Lang): Msg => ({ id: newId(), role, text, at: now(), kind, lang });

const OFFER_TTL_MS = 60 * 60 * 1000;   // a "yes" an hour later is about something else

export type Inbound = { handled: true } | { handled: false; parentMsgId: string };

/**
 * Fast path, run inside the request (seconds): records the parent's message and
 * answers STOP/START and SOS with fixed text. Anything that needs a model is
 * left to `converse`.
 */
export async function receive(p: Parent, text: string, ch: Channel): Promise<Inbound> {
  const lang = chooseLang(text, p.lang, p.lastLang);
  p.lastLang = lang;

  if (isSos(text, p.codeWord)) {
    const m = msg("parent", text, "sos", lang);
    await ch.deliver(p, m);
    const covered = withinCoverage();
    let notified = false;
    if (p.consent.escalation && covered) {
      const c = p.contacts[0];
      notified = await notifyOperator(`SOS from ${p.name}: "${text}"\nPrimary contact: ${c ? `${c.name} (${c.relation}) ${c.phone ?? "no phone on file"}` : "none on file"}`);
    }
    await addAlert({ id: newId(), parentId: p.id, kind: "sos", text, at: m.at, withinCoverage: covered, operatorNotified: notified });
    await ch.deliver(p, msg("companion", sosReply(p, lang, notified), "sos", lang));
    await saveParent(p);
    return { handled: true };
  }

  // An answer to "shall I tell your family?" after a scam warning.
  const offer = p.scamOffer;
  if (offer && Date.now() - new Date(offer.at).getTime() < OFFER_TTL_MS && (isYes(text) || isNo(text))) {
    p.scamOffer = undefined;
    await ch.deliver(p, msg("parent", text, "scam", lang));
    let answer: string;
    if (isYes(text)) {
      const mail = familyScamEmail(p, offer.signals as Signal[], p.digest?.lang ?? lang);
      const r = await sendEmail({ to: p.digest?.emails ?? [], ...mail });
      answer = r.ok
        ? (lang === "he" ? "כתבתי למשפחה. הם יבדקו איתך. עד אז, לא לשלם ולא למסור שום קוד." : "I've written to your family, and they'll check with you. Until then, don't pay or share any code.")
        : (lang === "he" ? `לא הצלחתי לשלוח למשפחה. בבקשה ${g(p, "תתקשר", "תתקשרי")} אליהם${p.contacts[0]?.phone ? ` (${p.contacts[0].name}: ${p.contacts[0].phone})` : ""}.` : `I couldn't reach your family. Please call them${p.contacts[0]?.phone ? ` (${p.contacts[0].name}: ${p.contacts[0].phone})` : ""}.`);
    } else {
      answer = lang === "he" ? `בסדר. אם ${g(p, "תרצה", "תרצי")}, אפשר לבדוק את זה יחד בכל רגע.` : "Okay. If you want, we can look at it together any time.";
    }
    await ch.deliver(p, msg("companion", answer, "scam", lang));
    await saveParent(p);
    return { handled: true };
  }

  const scam = scamCheck(text);
  if (scam.suspect) {
    const m = msg("parent", text, "scam", lang);
    await ch.deliver(p, m);
    const canAlert = !!p.digest?.emails.length && !!process.env.RESEND_API_KEY;
    await ch.deliver(p, msg("companion", scamReply(p, lang, scam.signals, canAlert), "scam", lang));
    p.scamOffer = canAlert ? { at: m.at, signals: scam.signals } : undefined;
    await addAlert({ id: newId(), parentId: p.id, kind: "scam", text: scam.signals.join(", "), at: m.at, withinCoverage: false, operatorNotified: false });
    await saveParent(p);
    return { handled: true };
  }

  if (isStop(text) || isStart(text)) {
    p.stopped = isStop(text);
    await ch.deliver(p, msg("parent", text, "system", lang));
    await ch.deliver(p, msg("companion", p.stopped ? stopReply(p, lang) : startReply(lang), "system", lang));
    await saveParent(p);
    return { handled: true };
  }

  const m = msg("parent", text, "chat", lang);
  await ch.deliver(p, m);
  await saveParent(p);
  return { handled: false, parentMsgId: m.id };
}

/**
 * The companion's reply, then memory. `defer` lets the web request return as soon
 * as the reply is delivered and finish the memory step afterwards.
 */
export async function converse(p: Parent, parentMsgId: string, ch: Channel, defer: (work: Promise<void>) => void | Promise<void> = (w) => w): Promise<void> {
  const history = await getChat(p.id);
  const last = [...history].reverse().find((m) => m.role === "parent");
  // Per-parent serialization: if they already wrote again, the newer turn answers both.
  if (!last || last.id !== parentMsgId) return;

  const facts = await getFacts(p.id);
  const lang = last.lang ?? p.lastLang;
  const fresh = freshFamilyNotes(facts).map((f) => f.id);
  let text: string, answered: boolean;
  try {
    const r = await replyOrNull(p, facts, history, lang);
    text = r ?? SORRY[lang]; answered = r !== null;
  } catch (e) {
    // The page is waiting on a reply; never leave it hanging.
    console.error("reply failed", e);
    text = lang === "he" ? "סליחה, יש לי תקלה קטנה. אפשר לכתוב לי שוב בעוד רגע?" : "Sorry, I'm having a small problem. Could you write to me again in a moment?";
    await ch.deliver(p, msg("companion", text, "system", lang));
    return;
  }
  await ch.deliver(p, msg("companion", text, "chat", lang));
  if (answered && fresh.length) await markPassedOn(p.id, fresh);

  if (!p.consent.memory) return;
  await defer((async () => {
    try {
      const found = await extractFacts(p, facts, last.text, text);
      // Re-read: the family may have added a note while the reply was being written.
      if (found.length) await saveFacts(p.id, mergeFacts(await getFacts(p.id), found, lang));
    } catch (e) {
      console.error("memory extraction failed (conversation unaffected)", e);
    }
  })());
}

/** Family notes the parent has now been told; they stay as ordinary memory after this. */
async function markPassedOn(parentId: string, ids: string[]): Promise<void> {
  const facts = await getFacts(parentId);
  for (const f of facts) if (ids.includes(f.id) && !f.passedOn) f.passedOn = now();
  await saveFacts(parentId, facts);
}

/** Corrections create a new version; the old fact is kept and marked superseded. */
export function mergeFacts(facts: Fact[], found: Candidate[], lang: Lang): Fact[] {
  const out = [...facts];
  for (const c of found) {
    const f: Fact = { id: newId(), kind: c.kind, text: c.text, lang, confidence: c.confidence, sensitive: c.sensitive, source: "said", at: now() };
    const old = c.replaces ? out.find((x) => x.id === c.replaces && !x.supersededBy) : undefined;
    if (old) old.supersededBy = f.id;
    if (!out.some((x) => !x.supersededBy && x.text.trim() === f.text.trim())) out.push(f);
  }
  return out;
}

/** Daily check-in for one parent. The caller has already checked `checkinDue`. */
export async function checkIn(p: Parent, ch: Channel): Promise<void> {
  if (!ch.canSendFreeform(p)) return;   // WhatsApp outside the window will use a template (phase 2b)
  const lang: Lang = p.lang === "auto" ? p.lastLang : p.lang;
  const facts = await getFacts(p.id);
  const fresh = freshFamilyNotes(facts).map((f) => f.id);
  const r = await checkinOrNull(p, facts, await getChat(p.id), lang);
  const text = r ?? checkinFallback(p, lang);
  await ch.deliver(p, msg("companion", text, "checkin", lang));
  if (r !== null && fresh.length) await markPassedOn(p.id, fresh);
  p.lastCheckinDate = localNow(p.tz).date;
  await saveParent(p);
}
