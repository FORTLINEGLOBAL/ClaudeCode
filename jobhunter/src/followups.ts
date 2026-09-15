import { draftDM } from "./llm.js";
import type { State, Contact } from "./store.js";

// Contacts whose follow-up is due: draft the next touch. Returns contacts with a fresh draft.
export async function prepareFollowUps(state: State): Promise<Contact[]> {
  const now = Date.now();
  const due = Object.values(state.contacts).filter((c) => c.status === "sent" && c.nextFollowUpAt && Date.parse(c.nextFollowUpAt) <= now && c.touches.length < state.settings.maxTouches);
  const out: Contact[] = [];
  for (const c of due) {
    const d = await draftDM({ name: c.name, title: c.title, company: c.company, facts: c.hook && c.hook !== "none" ? [c.hook] : [], priorTouches: c.touches });
    c.draft = d.message; c.status = "drafted"; c.updatedAt = new Date().toISOString(); c.nextFollowUpAt = undefined;
    out.push(c);
  }
  // Contacts that exhausted touches: close quietly.
  for (const c of Object.values(state.contacts)) {
    if (c.status === "sent" && c.touches.length >= state.settings.maxTouches && c.nextFollowUpAt && Date.parse(c.nextFollowUpAt) <= now) {
      c.status = "closed"; c.notes = (c.notes || "") + " auto-closed after max touches"; c.updatedAt = new Date().toISOString();
    }
  }
  return out;
}

export function markSent(state: State, c: Contact): void {
  const n = c.touches.length + 1;
  c.touches.push({ n, text: c.draft, sentAt: new Date().toISOString() });
  c.status = "sent";
  c.nextFollowUpAt = new Date(Date.now() + state.settings.followUpDays * 86400 * 1000).toISOString();
  c.updatedAt = new Date().toISOString();
}
