// Shared: find decision makers at a company, verify facts, draft a DM, register the contact.
import { EMERGING_TARGET } from "../profile.js";
import { findPeople, companyFacts } from "../sources/search.js";
import { pickPeople, draftDM } from "../llm.js";
import { canDraftMore, countDraft, slug, type State, type Contact } from "../store.js";

export interface CompanyCtx { name: string; hq?: string; openRoles?: string[]; extraFacts?: string[]; hunter: Contact["hunter"] }

// Where a company drops out of the funnel. Nine companies producing zero drafts was
// invisible before: search, the pick, the cap and the duplicate check all end in [].
export interface ProspectNote { company: string; candidates: number; picked: number; drafted: number; stopped?: string }

let prospectTrace: ProspectNote[] | null = null;
export function startProspectTrace(): void { prospectTrace = []; }
export function endProspectTrace(): ProspectNote[] { const t = prospectTrace ?? []; prospectTrace = null; return t; }

export function prospectSummary(notes: ProspectNote[]): string {
  if (!notes.length) return "no companies were prospected";
  const tot = notes.reduce((a, n) => ({ c: a.c + n.candidates, p: a.p + n.picked, d: a.d + n.drafted }), { c: 0, p: 0, d: 0 });
  const stops = new Map<string, number>();
  for (const n of notes) if (n.stopped) stops.set(n.stopped, (stops.get(n.stopped) || 0) + 1);
  return [
    `${notes.length} companies prospected: ${tot.c} candidates found, ${tot.p} picked, ${tot.d} drafted`,
    stops.size ? `Stopped at: ${[...stops].map(([k, v]) => `${v}x ${k}`).join(", ")}` : "",
  ].filter(Boolean).join("\n");
}

export async function prospectCompany(state: State, ctx: CompanyCtx, maxPeople = 2): Promise<Contact[]> {
  const note: ProspectNote = { company: ctx.name, candidates: 0, picked: 0, drafted: 0 };
  if (prospectTrace) prospectTrace.push(note);
  if (state.settings.blockedCompanies.some((b) => ctx.name.toLowerCase().includes(b.toLowerCase()))) {
    note.stopped = "company blocked";
    return [];
  }
  const candidates = await findPeople(ctx.name, EMERGING_TARGET.execTitles);
  note.candidates = candidates.length;
  if (!candidates.length) note.stopped = "no LinkedIn profiles found by search";
  const people = await pickPeople(ctx.name, candidates);
  note.picked = people.length;
  if (candidates.length && !people.length) note.stopped = "search found profiles but none were picked as senior enough";
  const facts = (await companyFacts(ctx.name)).map((f) => `${f.title}: ${f.snippet} (source: ${f.url})`);
  const created: Contact[] = [];
  for (const p of people.slice(0, maxPeople)) {
    const id = slug(p.linkedinUrl || `${p.name}-${p.company}`);
    if (state.contacts[id]) { note.stopped ||= "already in the pipeline"; continue; }
    if (!canDraftMore(state)) { note.stopped ||= "daily draft cap reached"; break; }
    const d = await draftDM({
      name: p.name.split(" ")[0] ? p.name : p.name, title: p.title, company: ctx.name, hq: ctx.hq,
      facts: [...(ctx.extraFacts || []), ...facts], hasRegionalLeader: p.role === "regional_leader", openRoles: ctx.openRoles,
    });
    const now = new Date().toISOString();
    const c: Contact = {
      id, name: p.name, title: p.title, company: ctx.name, linkedinUrl: p.linkedinUrl, hunter: ctx.hunter,
      angle: d.angle, hook: d.hookUsed, draft: d.message, status: "drafted", touches: [], createdAt: now, updatedAt: now,
    };
    state.contacts[id] = c;
    countDraft(state);
    created.push(c);
  }
  note.drafted = created.length;
  if (created.length) note.stopped = undefined;
  return created;
}
