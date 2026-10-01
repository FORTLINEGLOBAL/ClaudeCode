// What the family page shows. Activity is counted, never quoted: the family sees
// that the parent was active and whether check-ins were answered, not what was said.
import type { Alert, Fact, Msg, Parent } from "./types.js";
import { localNow } from "./time.js";

export type CheckinState = "answered" | "missed" | "waiting" | null;

export interface DayActivity {
  date: string;              // parent's local YYYY-MM-DD
  messages: number;          // how many messages the parent sent that day
  checkin: CheckinState;     // null when no check-in was sent that day
}

export interface Activity {
  days: DayActivity[];       // oldest first, the last 7 local days including today
  lastActiveAt: string | null;
  missedCheckins: number;
}

/** The local date `n` days before `date` (YYYY-MM-DD), calendar arithmetic only. */
function minusDays(date: string, n: number): string {
  const d = new Date(`${date}T12:00:00Z`);
  d.setUTCDate(d.getUTCDate() - n);
  return d.toISOString().slice(0, 10);
}

export function weeklyActivity(p: Parent, log: Msg[], now: Date = new Date()): Activity {
  const today = localNow(p.tz, now).date;
  const dates = Array.from({ length: 7 }, (_, i) => minusDays(today, 6 - i));
  const dayOf = (m: Msg) => localNow(p.tz, new Date(m.at)).date;

  const days = dates.map((date): DayActivity => {
    const that = log.filter((m) => dayOf(m) === date);
    const checkin = that.find((m) => m.role === "companion" && m.kind === "checkin");
    let state: CheckinState = null;
    if (checkin) {
      // Answered: the parent wrote after the check-in, the same local day.
      const answered = that.some((m) => m.role === "parent" && m.at > checkin.at);
      state = answered ? "answered" : date === today ? "waiting" : "missed";
    }
    return { date, messages: that.filter((m) => m.role === "parent").length, checkin: state };
  });

  const last = [...log].reverse().find((m) => m.role === "parent");
  return { days, lastActiveAt: last?.at ?? null, missedCheckins: days.filter((d) => d.checkin === "missed").length };
}

/** Settings the family page shows. Consent is shown but not changed here: only the parent decides it. */
export function familyView(p: Parent) {
  const { name, gender, lang, tz, checkinTime, quietStart, quietEnd, emergencyNumber, contacts, consent, stopped } = p;
  const digest = { emails: p.digest?.emails ?? [], lang: p.digest?.lang ?? "he" };
  return { name, gender: gender ?? null, lang, tz, checkinTime, quietStart, quietEnd, emergencyNumber, codeWordSet: !!p.codeWord, contacts, consent, stopped, digest };
}

/** SOS alerts for the family: when, and whether a person was alerted. The words stay private. */
export function familyAlerts(alerts: Alert[], parentId: string) {
  return alerts.filter((a) => a.parentId === parentId).reverse().slice(0, 20)
    .map(({ at, withinCoverage, operatorNotified }) => ({ at, withinCoverage, operatorNotified }));
}

/** Notes the family added, newest first. Other memories stay private. */
export function familyNotes(facts: Fact[]) {
  return facts.filter((f) => f.source === "family" && !f.supersededBy).reverse().map(({ id, text, at, passedOn }) => ({ id, text, at, passedOn: passedOn ?? null }));
}
