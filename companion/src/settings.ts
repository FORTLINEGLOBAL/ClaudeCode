// Parent settings that the operator (admin page) and the family (family page) may set.
// Consent is deliberately not here: only the parent changes it.
import type { Contact, Parent } from "./types.js";
import { toMinutes } from "./time.js";

const str = (v: unknown, max: number) => String(v ?? "").trim().slice(0, max);

/** Applies the fields present in `b` to `p`. Throws with a readable message on bad input. */
export function applySettings(p: Parent, b: Record<string, any>): Parent {
  if ("name" in b) { const n = str(b.name, 60); if (!n) throw new Error("name is required"); p.name = n; }
  if ("gender" in b) p.gender = b.gender === "f" || b.gender === "m" ? b.gender : undefined;
  if ("lang" in b) {
    p.lang = b.lang === "he" || b.lang === "en" ? b.lang : "auto";
    if (p.lang !== "auto") p.lastLang = p.lang;
  }
  if ("tz" in b) {
    const tz = str(b.tz, 60);
    try { new Intl.DateTimeFormat("en", { timeZone: tz }); } catch { throw new Error(`Unknown time zone "${tz}"`); }
    p.tz = tz;
  }
  for (const k of ["checkinTime", "quietStart", "quietEnd"] as const) {
    if (k in b) { const v = str(b[k], 5); toMinutes(v); p[k] = v; }
  }
  if ("emergencyNumber" in b) {
    const n = str(b.emergencyNumber, 20);
    if (!/^[0-9+*#]{2,20}$/.test(n)) throw new Error("Emergency number should be digits, e.g. 911 or 101");
    p.emergencyNumber = n;
  }
  if ("codeWord" in b) p.codeWord = str(b.codeWord, 40) || undefined;
  if ("contacts" in b) {
    if (!Array.isArray(b.contacts)) throw new Error("contacts must be a list");
    p.contacts = b.contacts.slice(0, 5).map((c: any): Contact => {
      const phone = str(c?.phone, 20).replace(/[\s()-]/g, "");
      if (phone && !/^\+?[0-9]{6,16}$/.test(phone)) throw new Error(`Phone "${c.phone}" should include the country code, e.g. +12125550100`);
      return { name: str(c?.name, 60), relation: str(c?.relation, 40), ...(phone ? { phone } : {}) };
    }).filter((c: Contact) => c.name);
  }
  return p;
}
