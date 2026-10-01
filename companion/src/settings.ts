// Parent settings that the operator (admin page) and the family (family page) may set.
// Consent is deliberately not here: only the parent changes it.
import type { Contact, Parent } from "./types.js";
import { toMinutes } from "./time.js";

/** Bad input, worded for the family page in both languages. */
export class SettingsError extends Error {
  constructor(message: string, readonly he: string) { super(message); }
}

const str = (v: unknown, max: number) => String(v ?? "").trim().slice(0, max);

/** Applies the fields present in `b` to `p`. Throws with a readable message on bad input. */
export function applySettings(p: Parent, b: Record<string, any>): Parent {
  if ("name" in b) { const n = str(b.name, 60); if (!n) throw new SettingsError("Name is required.", "צריך למלא שם."); p.name = n; }
  if ("gender" in b) p.gender = b.gender === "f" || b.gender === "m" ? b.gender : undefined;
  if ("lang" in b) {
    p.lang = b.lang === "he" || b.lang === "en" ? b.lang : "auto";
    if (p.lang !== "auto") p.lastLang = p.lang;
  }
  if ("tz" in b) {
    const tz = str(b.tz, 60);
    try { new Intl.DateTimeFormat("en", { timeZone: tz }); } catch { throw new SettingsError(`Unknown time zone "${tz}".`, `אזור הזמן "${tz}" לא מוכר.`); }
    p.tz = tz;
  }
  for (const k of ["checkinTime", "quietStart", "quietEnd"] as const) {
    if (k in b) {
      const v = str(b[k], 5);
      try { toMinutes(v); } catch { throw new SettingsError(`Time "${v}" should look like 09:30.`, `השעה "${v}" צריכה להיות בצורה 09:30.`); }
      p[k] = v;
    }
  }
  if ("emergencyNumber" in b) {
    const n = str(b.emergencyNumber, 20);
    if (!/^[0-9+*#]{2,20}$/.test(n)) throw new SettingsError("Emergency number should be digits, e.g. 911 or 101.", "מספר החירום צריך להיות ספרות, למשל 101 או 911.");
    p.emergencyNumber = n;
  }
  if ("codeWord" in b) p.codeWord = str(b.codeWord, 40) || undefined;
  if ("contacts" in b) {
    if (!Array.isArray(b.contacts)) throw new SettingsError("Contacts must be a list.", "רשימת אנשי הקשר לא תקינה.");
    p.contacts = b.contacts.slice(0, 5).map((c: any): Contact => {
      const phone = str(c?.phone, 20).replace(/[\s()-]/g, "");
      if (phone && !/^\+?[0-9]{6,16}$/.test(phone)) throw new SettingsError(`Phone "${c.phone}" should include the country code, e.g. +972501234567.`, `הטלפון "${c.phone}" צריך לכלול קידומת מדינה, למשל 972501234567+.`);
      return { name: str(c?.name, 60), relation: str(c?.relation, 40), ...(phone ? { phone } : {}) };
    }).filter((c: Contact) => c.name);
  }
  if ("digestEmails" in b || "digestLang" in b) {
    const raw: unknown[] = Array.isArray(b.digestEmails) ? b.digestEmails : String(b.digestEmails ?? "").split(/[,;\s]+/);
    const emails = [...new Set(raw.map((e) => str(e, 120).toLowerCase()).filter(Boolean))];
    if (emails.length > 5) throw new SettingsError("Up to 5 email addresses.", "אפשר עד 5 כתובות מייל.");
    const bad = emails.find((e) => !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(e));
    if (bad) throw new SettingsError(`"${bad}" is not an email address.`, `"${bad}" היא לא כתובת מייל תקינה.`);
    const lang = b.digestLang === "en" ? "en" : b.digestLang === "he" ? "he" : p.digest?.lang ?? "he";
    p.digest = { ...p.digest, emails, lang };
  }
  return p;
}
