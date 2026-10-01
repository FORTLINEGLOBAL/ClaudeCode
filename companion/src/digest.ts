// The weekly email to the family. Per the decided defaults it carries only activity
// and check-ins: counts and dates, never what was said.
import type { Lang, Msg, Parent } from "./types.js";
import { weeklyActivity, type Activity } from "./family.js";
import { getChat, saveParent } from "./store.js";
import { localNow } from "./time.js";
import { sendEmail, type MailResult } from "./mail.js";

const SEND_DAY = 0;          // Sunday, the parent's local day
const SEND_TIME = 9 * 60;    // 09:00 local

export function digestDue(p: Parent, at: Date = new Date()): boolean {
  if (!p.digest?.emails.length) return false;
  const now = localNow(p.tz, at);
  if (p.digest.lastSentDate === now.date) return false;
  return new Date(`${now.date}T12:00:00Z`).getUTCDay() === SEND_DAY && now.minutes >= SEND_TIME;
}

/** The seven full days before `at` (so nothing is still "waiting"). */
export function digestWeek(p: Parent, log: Msg[], at: Date = new Date()): Activity {
  const yesterday = new Date(`${localNow(p.tz, at).date}T12:00:00Z`);
  yesterday.setUTCDate(yesterday.getUTCDate() - 1);
  // Noon UTC on the local "yesterday" lands on that date in every zone we serve.
  return weeklyActivity(p, log, yesterday);
}

const esc = (s: string) => s.replace(/[&<>"]/g, (c) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" })[c]!);

export function digestEmail(p: Parent, a: Activity, lang: Lang): { subject: string; text: string; html: string } {
  const he = lang === "he";
  const n = p.name;
  const fmtDay = new Intl.DateTimeFormat(he ? "he-IL" : "en-US", { weekday: "long", day: "numeric", month: "numeric", timeZone: "UTC" });
  const day = (d: string) => fmtDay.format(new Date(`${d}T12:00:00Z`));
  const active = a.days.filter((d) => d.messages > 0).length;
  const msgs = a.days.reduce((s, d) => s + d.messages, 0);
  const sent = a.days.filter((d) => d.checkin).length;
  const answered = a.days.filter((d) => d.checkin === "answered").length;
  const last = a.lastActiveAt
    ? new Date(a.lastActiveAt).toLocaleString(he ? "he-IL" : "en-US", { weekday: "long", day: "numeric", month: "numeric", hour: "2-digit", minute: "2-digit", hourCycle: "h23", timeZone: p.tz })
    : null;
  const ci = { answered: he ? "✓ ענה/תה" : "✓ answered", missed: he ? "✗ לא נענה" : "✗ missed", waiting: "…" } as const;

  const subject = he ? `${n}: השבוע בקצרה` : `${n}: the week in brief`;
  const intro = he ? `הסיכום השבועי של ${n} מ-Companion.` : `${n}'s weekly summary from the companion.`;
  const stats = he ? [
    `ימים עם שיחה: ${active} מתוך 7`,
    `הודעות ש${n} כתב/ה: ${msgs}`,
    sent ? `צ'ק-אינים: ${answered} נענו מתוך ${sent}` : "לא נשלחו צ'ק-אינים השבוע.",
    last ? `פעילות אחרונה: ${last}` : `${n} עוד לא כתב/ה.`,
  ] : [
    `Days with a conversation: ${active} of 7`,
    `Messages ${n} wrote: ${msgs}`,
    sent ? `Check-ins: ${answered} of ${sent} answered` : "No check-ins were sent this week.",
    last ? `Last active: ${last}` : `${n} hasn't written yet.`,
  ];
  const notes = [
    ...(p.stopped ? [he ? `${n} ביקש/ה לעצור הודעות יזומות (STOP), ולכן הצ'ק-אין היומי מושהה.` : `${n} asked to stop proactive messages (STOP), so the daily check-in is paused.`] : []),
    ...(a.missedCheckins >= 2 || active === 0 ? [he ? "אולי כדאי להתקשר ולשאול מה נשמע." : "It may be a good week to call and say hello."] : []),
  ];
  const footer = he
    ? ["תוכן השיחות פרטי ולא נשלח. רואים רק כמה ומתי.", "לשינוי או להפסקת המייל הזה: בדף המשפחה, בהגדרות."]
    : ["The conversations stay private and are never sent. You see only how much and when.", "To change or stop this email: the family page, under settings."];

  const rows = a.days.map((d) => `<tr><td style="padding:4px 8px">${esc(day(d.date))}</td><td style="padding:4px 8px;text-align:center"><b>${d.messages}</b></td><td style="padding:4px 8px">${d.checkin ? ci[d.checkin] : ""}</td></tr>`).join("");
  const head = he ? ["יום", "הודעות", "צ'ק-אין"] : ["Day", "Messages", "Check-in"];
  const html = `<div dir="${he ? "rtl" : "ltr"}" style="font:16px/1.5 Arial,sans-serif;color:#1d1d1f;max-width:560px">`
    + `<p>${esc(intro)}</p><p>${stats.map(esc).join("<br>")}</p>`
    + `<table style="border-collapse:collapse;margin:12px 0;font-size:15px"><tr style="color:#5b5b60">${head.map((h) => `<th style="padding:4px 8px;text-align:start">${h}</th>`).join("")}</tr>${rows}</table>`
    + notes.map((l) => `<p><b>${esc(l)}</b></p>`).join("")
    + footer.map((l) => `<p style="color:#5b5b60;font-size:14px">${esc(l)}</p>`).join("")
    + `</div>`;
  const text = [intro, "", ...stats, "", ...a.days.map((d) => `${day(d.date)}: ${d.messages}${d.checkin ? " · " + ci[d.checkin] : ""}`),
    ...(notes.length ? ["", ...notes] : []), "", ...footer].join("\n");
  return { subject, text, html };
}

/** Sends the digest now (the weekly run, or the family page's test button). */
export async function sendDigest(p: Parent, at: Date = new Date()): Promise<MailResult> {
  const d = p.digest;
  if (!d?.emails.length) return { ok: false, error: "no recipients" };
  const mail = digestEmail(p, digestWeek(p, await getChat(p.id), at), d.lang);
  return sendEmail({ to: d.emails, ...mail });
}

export async function sendDigestIfDue(p: Parent, at: Date = new Date()): Promise<boolean> {
  if (!digestDue(p, at)) return false;
  const r = await sendDigest(p, at);
  // Mark the day either way, so a bad address doesn't retry every 15 minutes all day.
  p.digest = { ...p.digest!, lastSentDate: localNow(p.tz, at).date };
  await saveParent(p);
  return r.ok;
}
