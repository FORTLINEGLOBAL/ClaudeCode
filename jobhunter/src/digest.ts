import { enqueue, type State, type Job, type Contact } from "./store.js";

export function fmtJob(n: number, j: Job): string {
  return `#${n} JOB ${j.title} @ ${j.company}\n${j.location} | fit ${j.score}/100, ${j.reason}\n${j.url}`;
}

export function fmtContactShort(n: number, c: Contact): string {
  const touch = c.touches.length ? `follow-up ${c.touches.length + 1}` : "first touch";
  return `#${n} DM ${c.name}, ${c.title} @ ${c.company} (${touch})\n${c.linkedinUrl || ""}`;
}

export function fmtContactFull(n: number, c: Contact): string {
  const touch = c.touches.length ? `Follow-up ${c.touches.length + 1}` : "First touch";
  return `#${n} ${touch}: ${c.name}, ${c.title} @ ${c.company}\n${c.linkedinUrl || ""}\nAngle: ${c.angle}\n\n${c.draft}\n\nReply: sent ${n} | rewrite ${n} <how> | skip ${n}`;
}

export function buildDigest(state: State, jobs: Job[], contacts: Contact[], header: string): string {
  const parts: string[] = [header];
  if (jobs.length) parts.push("JOBS\n" + jobs.map((j) => fmtJob(enqueue(state, "job", j.id), j)).join("\n\n"));
  if (contacts.length) parts.push("DMS TO SEND (copy, paste on LinkedIn, then reply 'sent N')\n" + contacts.map((c) => fmtContactFull(enqueue(state, "contact", c.id), c)).join("\n\n"));
  for (const j of jobs) j.status = "shown";
  return parts.join("\n\n");
}

export function pendingDigest(state: State): string {
  const jobs = Object.values(state.jobs).filter((j) => j.status === "new" || j.status === "shown").sort((a, b) => b.score - a.score).slice(0, 10);
  const contacts = Object.values(state.contacts).filter((c) => c.status === "drafted").slice(0, 10);
  if (!jobs.length && !contacts.length) return "Nothing pending. Say 'scan now' to run a fresh scan or 'find contacts at <company>'.";
  const parts: string[] = [];
  if (jobs.length) parts.push("OPEN JOBS\n" + jobs.map((j) => fmtJob(enqueue(state, "job", j.id), j)).join("\n\n"));
  if (contacts.length) parts.push("DRAFTS WAITING\n" + contacts.map((c) => fmtContactShort(enqueue(state, "contact", c.id), c)).join("\n\n") + "\n\nSay 'show N' for the full text.");
  return parts.join("\n\n");
}

export function statusLine(state: State): string {
  const cs = Object.values(state.contacts);
  const count = (s: string) => cs.filter((c) => c.status === s).length;
  const dueSoon = cs.filter((c) => c.status === "sent" && c.nextFollowUpAt).sort((a, b) => a.nextFollowUpAt!.localeCompare(b.nextFollowUpAt!)).slice(0, 5)
    .map((c) => `${c.name} @ ${c.company} on ${c.nextFollowUpAt!.slice(0, 10)}`);
  return [
    `Pipeline: ${count("drafted")} drafted, ${count("sent")} sent (waiting), ${count("replied")} replied, ${count("closed")} closed, ${count("skipped")} skipped.`,
    `Jobs tracked: ${Object.keys(state.jobs).length}. Companies tracked: ${Object.keys(state.companies).length}.`,
    `Drafts today: ${state.draftsToday.count}/${state.settings.dailyDraftCap}. Follow-up every ${state.settings.followUpDays}d, max ${state.settings.maxTouches} touches. ${state.settings.paused ? "PAUSED." : ""}`,
    dueSoon.length ? `Next follow-ups: ${dueSoon.join("; ")}` : "",
  ].filter(Boolean).join("\n");
}
