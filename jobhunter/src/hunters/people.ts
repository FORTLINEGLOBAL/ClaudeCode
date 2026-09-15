// Shared: find decision makers at a company, verify facts, draft a DM, register the contact.
import { EMERGING_TARGET } from "../profile.js";
import { findPeople, companyFacts } from "../sources/search.js";
import { pickPeople, draftDM } from "../llm.js";
import { canDraftMore, countDraft, slug, type State, type Contact } from "../store.js";

export interface CompanyCtx { name: string; hq?: string; openRoles?: string[]; extraFacts?: string[]; hunter: Contact["hunter"] }

export async function prospectCompany(state: State, ctx: CompanyCtx, maxPeople = 2): Promise<Contact[]> {
  if (state.settings.blockedCompanies.some((b) => ctx.name.toLowerCase().includes(b.toLowerCase()))) return [];
  const candidates = await findPeople(ctx.name, EMERGING_TARGET.execTitles);
  const people = await pickPeople(ctx.name, candidates);
  const facts = (await companyFacts(ctx.name)).map((f) => `${f.title}: ${f.snippet} (source: ${f.url})`);
  const created: Contact[] = [];
  for (const p of people.slice(0, maxPeople)) {
    const id = slug(p.linkedinUrl || `${p.name}-${p.company}`);
    if (state.contacts[id]) continue;             // already in pipeline, never duplicate
    if (!canDraftMore(state)) break;              // respect daily cap
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
  return created;
}
