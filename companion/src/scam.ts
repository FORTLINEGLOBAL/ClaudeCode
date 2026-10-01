// Scam shield. Deterministic, like SOS: the parent pastes or describes a message and
// the warning never waits on a model. Links are only matched as text, never opened.
import type { Lang, Parent } from "./types.js";
import { g } from "./policy.js";

export type Signal = "urgency" | "secrecy" | "payment" | "codes" | "impersonation" | "remote" | "link" | "prize";

const PATTERNS: Record<Signal, RegExp> = {
  urgency: /דחוף|מיד(?:ית)?\b|תוך (?:שעה|\d+ שעות)|היום בלבד|הודעה אחרונה|ייחסם|נחסם|חסום|יושעה|יבוטל|urgent|immediately|right away|right now|within \d+ hours?|final notice|suspended|locked|expires? today/i,
  secrecy: /אל תספר|אל תספרי|אל תגיד|אל תגידי|בסוד|בינינו|don'?t tell|keep (?:this|it) (?:between|secret|quiet)|secret/i,
  payment: /להעביר (?:כסף|לי)|תעביר(?:י|ו)?(?: לי)? (?:את ה)?כסף|תשלח(?:י|ו)?(?: לי)? (?:את ה)?כסף|העברה בנקאית|העברת כסף|לשלם|תשלום|פרטי (?:ה)?אשראי|כרטיס אשראי|גיפט ?קארד|כרטיס(?:י)? מתנה|ביטקוין|קריפטו|ביט\b|פייבוקס|wire (?:transfer|money)|transfer (?:the )?money|send (?:me )?money|gift ?cards?|bitcoin|crypto|zelle|venmo|western union|pay (?:a |the )?fee|card (?:number|details)/i,
  codes: /קוד(?: ה)?(?:אימות|סודי|שקיבלת|שנשלח)|ה?סיסמ(?:ה|א)|קוד חד[- ]פעמי|\bOTP\b|\bPIN\b|password|verification code|the code (?:you|we) (?:got|received|sent)|one[- ]time code/i,
  impersonation: /מה?בנק|הבנק|משטרה|ביטוח לאומי|מס הכנסה|דואר ישראל|רשות המסים|קופת חולים|הנכד|הנכדה|נכד שלך|סבתא,? זה אני|סבא,? זה אני|\bbank\b|police|\bIRS\b|social security|medicare|grandson|granddaughter|it'?s me,? grandma|it'?s me,? grandpa|amazon|microsoft|apple support|tech support/i,
  remote: /anydesk|teamviewer|quick ?support|rustdesk|גישה מרחוק|להתקין (?:את )?(?:ה)?(?:אפליקציה|תוכנה)|שיתוף מסך|remote access|install (?:this|the|an) app|screen ?shar/i,
  link: /https?:\/\/|www\.|\bbit\.ly\b|\b[a-z0-9-]+\.(?:com|net|org|info|xyz|top|co\.il|ru)\b/i,
  prize: /זכית|זכייה|פרס|הגרלה|you(?:'ve)? won|winner|prize|lottery|claim your/i,
};

export interface ScamCheck { suspect: boolean; signals: Signal[] }

/**
 * High precision over recall, like SOS: one signal is ordinary life ("I paid the
 * gardener"), so a warning needs a pattern scams share.
 */
export function scamCheck(text: string): ScamCheck {
  const signals = (Object.keys(PATTERNS) as Signal[]).filter((s) => PATTERNS[s].test(text));
  const has = (s: Signal) => signals.includes(s);
  const suspect = has("remote")
    || (has("codes") && (has("impersonation") || has("urgency") || has("link")))
    || (has("payment") && (has("secrecy") || has("urgency") || has("prize") || has("link")))
    || (has("prize") && (has("link") || has("payment")))
    || signals.filter((s) => s !== "link").length >= 3;
  return { suspect, signals };
}

const REASONS: Record<Lang, Record<Signal, string>> = {
  he: {
    urgency: "לחץ לפעול מהר", secrecy: "בקשה לשמור בסוד", payment: "בקשה לכסף או לתשלום",
    codes: "בקשה לקוד או לסיסמה", impersonation: "מישהו שמציג את עצמו כבנק, גוף רשמי או בן משפחה",
    remote: "בקשה להתקין תוכנה או לתת גישה לטלפון או למחשב", link: "קישור", prize: "הבטחה לפרס או זכייה",
  },
  en: {
    urgency: "pressure to act fast", secrecy: "a request to keep it secret", payment: "a request for money or payment",
    codes: "a request for a code or password", impersonation: "someone claiming to be a bank, an official body or a relative",
    remote: "a request to install software or give access to your phone or computer", link: "a link", prize: "a prize or winnings",
  },
};

export const scamReasons = (signals: Signal[], lang: Lang) => signals.map((s) => REASONS[lang][s]);

/** The warning. `canAlertFamily`: the family has an email on file, so we can offer to tell them. */
export function scamReply(p: Parent, lang: Lang, signals: Signal[], canAlertFamily: boolean): string {
  const c = p.contacts[0];
  const reasons = scamReasons(signals, lang).map((r) => `• ${r}`).join("\n");
  if (lang === "he") {
    return [
      `רגע, ${g(p, "עצור", "עצרי")} לפני שעושים משהו. זה נראה כמו ניסיון הונאה:`,
      reasons,
      `מה כדאי: לא ללחוץ על קישורים, לא לשלם ולא למסור קוד או סיסמה. אם כתוב שזה מהבנק, מגוף רשמי או ממישהו מהמשפחה, ${g(p, "תתקשר", "תתקשרי")} אליהם בעצמך, במספר ש${g(p, "אתה מכיר", "את מכירה")} (למשל מגב הכרטיס), לא במספר מההודעה.`,
      canAlertFamily
        ? `רוצה שאכתוב למשפחה שיבדקו איתך? ${g(p, "כתוב", "כתבי")} "כן" או "לא".`
        : c ? `אפשר גם להתקשר ל${c.name}${c.phone ? ` (${c.phone})` : ""} ולבדוק יחד.` : `אפשר גם לבדוק עם מישהו מהמשפחה לפני שעושים משהו.`,
    ].join("\n");
  }
  return [
    "Wait, please stop before doing anything. This looks like a scam attempt:",
    reasons,
    "What to do: don't click links, don't pay, and don't share any code or password. If it says it's from your bank, an official body or a relative, call them yourself on a number you already know (like the back of your card), not the number in the message.",
    canAlertFamily
      ? `Would you like me to write to your family so they can check with you? Reply "yes" or "no".`
      : c ? `You can also call ${c.name}${c.phone ? ` (${c.phone})` : ""} and check together.` : "You can also check with someone in your family before doing anything.",
  ].join("\n");
}

export const isYes = (t: string) => /^\s*(כן|כן בבקשה|בטח|תכתוב|תכתבי|תודיע|yes|yes please|ok|okay|sure|please do)\s*[.!]*\s*$/i.test(t);
export const isNo = (t: string) => /^\s*(לא|לא תודה|אין צורך|no|no thanks|nope)\s*[.!]*\s*$/i.test(t);

export function familyScamEmail(p: Parent, signals: Signal[], lang: Lang): { subject: string; text: string } {
  const r = scamReasons(signals, lang).join(", ");
  return lang === "he"
    ? { subject: `${p.name} ${g(p, "קיבל", "קיבלה")} הודעה חשודה`, text: `${p.name} ${g(p, "שיתף", "שיתפה")} עם Companion הודעה שנראית כמו ניסיון הונאה (${r}).\nהזהרנו לא ללחוץ, לא לשלם ולא למסור קודים, ו${p.name} ${g(p, "ביקש", "ביקשה")} שנעדכן אתכם.\nכדאי להתקשר ולבדוק יחד. תוכן ההודעה לא נשלח כאן.` }
    : { subject: `${p.name} received a suspicious message`, text: `${p.name} shared a message with the companion that looks like a scam attempt (${r}).\nWe warned not to click, pay or share codes, and ${p.name} asked us to let you know.\nIt's worth calling to check together. The message itself is not included here.` };
}
