// Deterministic rules around the model. The LLM proposes; these decide.
// Nothing here calls a model, so every rule is covered by offline tests.
import type { Lang, Parent } from "./types.js";
import { inWindow, localNow, toMinutes } from "./time.js";

// ---------- language ----------
const HEBREW = /[֐-׿]/g;
const LATIN = /[A-Za-z]/g;

/** Explicit preference wins. Otherwise pick by script; no letters at all keeps the last language. */
export function chooseLang(text: string, pref: Lang | "auto", last: Lang): Lang {
  if (pref !== "auto") return pref;
  const he = (text.match(HEBREW) || []).length;
  const en = (text.match(LATIN) || []).length;
  if (he === 0 && en === 0) return last;
  return he >= en ? "he" : "en";
}

// ---------- SOS ----------
// High-precision phrases only. A false alarm here alerts a real person, and a
// missed one is caught by the companion's prompt telling the parent how to get help.
const SOS_EN = [
  /\bsos\b/i, /\bemergency\b/i, /\bi(?:'ve| have)? fallen\b/i, /\bi fell\b(?!\s+(?:asleep|in love|behind|for\b))/i,
  /\bcan(?:'t|not) breathe\b/i, /\bchest pains?\b/i, /\bcall (?:911|an ambulance)\b/i,
  /\bambulance\b/i, /\bheart attack\b/i, /\bstroke\b/i, /\bi'?m bleeding\b/i,
  /^\s*help(?: me)?\s*!*\s*$/i,
];
const SOS_HE = [
  /הצילו/, /נפלתי/, /(?:לא\s*(?:יכול(?:ה)?\s*)?|קשה לי\s*)לנשום/, /כאב(?:ים)? ב?חזה/,
  /אמבולנס/, /מד["״׳']?א/, /חירום/, /התקף לב/, /שבץ/, /מדמם(?:ת)?/, /^\s*עזרה\s*!*\s*$/,
];

export function isSos(text: string, codeWord?: string): boolean {
  if (codeWord && text.toLowerCase().includes(codeWord.toLowerCase())) return true;
  return SOS_EN.some((r) => r.test(text)) || SOS_HE.some((r) => r.test(text));
}

// ---------- STOP / resume ----------
export function isStop(text: string): boolean {
  return /^\s*(stop|עצור|עצרי|הפסק|הפסיקי)\s*[.!]*\s*$/i.test(text);
}
export function isStart(text: string): boolean {
  return /^\s*(start|resume|המשך|תמשיך|תמשיכי)\s*[.!]*\s*$/i.test(text);
}

// ---------- human coverage ----------
export function coverage() {
  return {
    tz: process.env.COVERAGE_TZ || "Asia/Jerusalem",
    start: process.env.COVERAGE_START || "08:00",
    end: process.env.COVERAGE_END || "22:00",
  };
}

export function withinCoverage(at: Date = new Date()): boolean {
  const c = coverage();
  return inWindow(localNow(c.tz, at).minutes, c.start, c.end);
}

// ---------- proactive rules ----------
export function inQuietHours(p: Parent, at: Date = new Date()): boolean {
  return inWindow(localNow(p.tz, at).minutes, p.quietStart, p.quietEnd);
}

/** Should the daily check-in go out now? One per local day, at or after the chosen time. */
export function checkinDue(p: Parent, at: Date = new Date()): boolean {
  if (p.stopped || !p.consent.checkins) return false;
  if (inQuietHours(p, at)) return false;
  const now = localNow(p.tz, at);
  if (p.lastCheckinDate === now.date) return false;
  return now.minutes >= toMinutes(p.checkinTime);
}

// Hebrew second person is gendered. Unknown gender falls back to "m/f".
export function g(p: Pick<Parent, "gender">, m: string, f: string): string {
  return p.gender === "f" ? f : p.gender === "m" ? m : `${m}/${f}`;
}

// ---------- SOS reply (fixed text, never generated) ----------
// Never claims emergency services were called: there is no verified integration.
export function sosReply(p: Parent, lang: Lang, humanOnDuty: boolean): string {
  const c = p.contacts[0];
  const n = p.emergencyNumber;
  const who = c ? `${c.name}${c.phone ? ` (${c.phone})` : ""}` : "";
  if (lang === "he") {
    return [
      `אם ${g(p, "אתה", "את")} בסכנה מיידית, ${g(p, "התקשר", "התקשרי")} עכשיו ל-${n}.`,
      humanOnDuty
        ? `הודעתי לצוות שלנו, והם יוצרים קשר עם ${c ? c.name : "המשפחה"} עכשיו.`
        : `כרגע אין איש צוות זמין. בבקשה ${g(p, "התקשר", "התקשרי")} ל-${who || "מישהו מהמשפחה"}.`,
      `אני כאן איתך. ${g(p, "ספר", "ספרי")} לי מה קורה.`,
    ].join("\n");
  }
  return [
    `If you are in immediate danger, call ${n} now.`,
    humanOnDuty
      ? `I've alerted our team, and they are contacting ${c ? c.name : "your family"} now.`
      : `No one from our team is available right now. Please call ${who || "someone in your family"}.`,
    "I'm here with you. Tell me what's happening.",
  ].join("\n");
}

export function stopReply(p: Parent, lang: Lang): string {
  return lang === "he"
    ? `בסדר, הפסקתי לשלוח הודעות יזומות. ${g(p, "אתה תמיד יכול", "את תמיד יכולה")} לכתוב לי. כדי לחדש, ${g(p, "כתוב", "כתבי")} "המשך".`
    : `Okay, I've stopped sending you messages first. You can always write to me. To turn them back on, write "start".`;
}

export function startReply(lang: Lang): string {
  return lang === "he" ? "חידשתי את הצ'ק-אין היומי. נדבר!" : "Your daily check-in is back on. Talk soon!";
}
