// Reminders the family types in on the family page. Deterministic: the text and time
// are read back exactly as stored, never rewritten by a model.
import type { Channel } from "./channel.js";
import type { Lang, Msg, Parent, Reminder } from "./types.js";
import { appendChat, getReminders, newId, saveReminders } from "./store.js";
import { localNow, toMinutes } from "./time.js";
import { SettingsError } from "./settings.js";

const LATE_LIMIT = 45;   // minutes; a reminder that missed its time by more is skipped for the day
export const MAX_REMINDERS = 10;

const weekday = (date: string) => new Date(`${date}T12:00:00Z`).getUTCDay();

export function reminderDue(r: Reminder, p: Parent, at: Date = new Date()): boolean {
  const now = localNow(p.tz, at);
  if (r.lastSentDate === now.date) return false;
  if (r.days.length && !r.days.includes(weekday(now.date))) return false;
  const late = now.minutes - toMinutes(r.time);
  return late >= 0 && late <= LATE_LIMIT;
}

export function reminderText(r: Reminder, lang: Lang): string {
  const family = !r.by || r.by === "family";
  return lang === "he"
    ? `⏰ תזכורת ${family ? "מהמשפחה" : `מ${r.by}`}, לשעה ${r.time}\n${r.text}`
    : `⏰ A reminder ${family ? "from your family" : `from ${r.by}`}, for ${r.time}\n${r.text}`;
}

/** Sends every reminder that is due now. STOP pauses reminders like any message we start. */
export async function sendDueReminders(p: Parent, ch: Channel, at: Date = new Date()): Promise<number> {
  if (p.stopped || (!ch.canSendFreeform(p) && !ch.canSendTemplate(p))) return 0;
  const list = await getReminders(p.id);
  const due = list.filter((r) => reminderDue(r, p, at));
  if (!due.length) return 0;
  const lang: Lang = p.lang === "auto" ? p.lastLang : p.lang;
  const today = localNow(p.tz, at).date;
  for (const r of due) {
    const m: Msg = { id: newId(), role: "companion", text: reminderText(r, lang), at: at.toISOString(), kind: "reminder", lang };
    const family = !r.by || r.by === "family";
    await ch.deliver(p, m, { name: "companion_reminder", params: [family ? (lang === "he" ? "המשפחה" : "your family") : r.by, r.time, r.text] });
    r.lastSentDate = today; r.lastSentAt = m.at;
  }
  await saveReminders(p.id, list);
  return due.length;
}

/** Validates what the family page sent. */
export function newReminder(b: Record<string, any>, linkLabel: string): Reminder {
  const by = String(b.by ?? "").trim().slice(0, 40) || linkLabel;
  const text = String(b.text ?? "").trim().slice(0, 300);
  if (!text) throw new SettingsError("Write what to remind about.", "צריך לכתוב על מה להזכיר.");
  const time = String(b.time ?? "").trim();
  let mins = -1;
  try { mins = toMinutes(time); } catch {}
  if (mins < 0 || mins >= 24 * 60 || Number(time.split(":")[1]) > 59) {
    throw new SettingsError(`Time "${time}" should look like 20:00.`, `השעה "${time}" צריכה להיות בצורה 20:00.`);
  }
  const days = Array.isArray(b.days) ? [...new Set(b.days.map(Number).filter((d: number) => Number.isInteger(d) && d >= 0 && d <= 6))].sort() as number[] : [];
  return { id: newId(), text, time: time.padStart(5, "0"), days: days.length === 7 ? [] : days, by: by || "family", at: new Date().toISOString() };
}

/** What the family page shows: was today's reminder sent, and did the parent write after it? */
export function familyReminders(list: Reminder[], p: Parent, log: Msg[], at: Date = new Date()) {
  const today = localNow(p.tz, at).date;
  return list.map((r) => {
    const sentAt = r.lastSentDate === today ? r.lastSentAt ?? null : null;
    const answeredAfter = !!sentAt && log.some((m) => m.role === "parent" && m.at > sentAt);
    return { id: r.id, text: r.text, time: r.time, days: r.days, by: r.by, sentToday: sentAt, answeredAfter };
  });
}
