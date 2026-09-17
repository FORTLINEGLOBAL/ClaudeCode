// Hunter 2: emerging companies that raised $75M+ and are expanding internationally.
import { EMERGING_TARGET } from "../profile.js";
import { fundingNews, linkedinPostsAboutFunding } from "../sources/news.js";
import { extractFunding } from "../llm.js";
import { resolveAts, fetchAts, looksRelevant } from "../sources/ats.js";
import { prospectCompany } from "./people.js";
import { slug, type State, type Contact, type Company } from "../store.js";

export async function huntEmerging(state: State): Promise<{ companies: Company[]; contacts: Contact[] }> {
  const [news, posts] = await Promise.all([fundingNews(7), linkedinPostsAboutFunding()]);
  const items = [...news, ...posts].slice(0, 80);
  const found = await extractFunding(items.map((i) => ({ title: i.title, snippet: i.snippet, url: i.url, date: i.date })));
  const newCompanies: Company[] = [];
  for (const f of found) {
    if (!f.relevant || f.raisedUSD < EMERGING_TARGET.minRaiseUSD) continue;
    const id = slug(f.name);
    if (state.companies[id]) continue;
    const c: Company = { id, name: f.name, hq: f.hq, raisedUSD: f.raisedUSD, round: f.round, raisedAt: new Date().toISOString().slice(0, 10), sector: f.sector, sourceUrl: f.sourceUrl, status: "new", createdAt: new Date().toISOString() };
    state.companies[id] = c;
    newCompanies.push(c);
  }
  const contacts: Contact[] = [];
  for (const c of newCompanies.slice(0, 5)) {
    contacts.push(...(await prospectOne(state, c)));
  }
  return { companies: newCompanies, contacts };
}

export async function prospectOne(state: State, c: Company): Promise<Contact[]> {
  // Any relevant international / GTM leadership roles open? (helps the pitch)
  let openRoles: string[] = [];
  const ats = await resolveAts(state.atsCache, c.name);
  if (ats) openRoles = (await fetchAts(ats.kind, ats.slug, c.name)).filter((j) => looksRelevant(j, false)).slice(0, 5).map((j) => `${j.title} (${j.location}) ${j.url}`);
  const extra = c.raisedUSD ? [`${c.name} raised $${Math.round(c.raisedUSD / 1e6)}M (${c.round || "round"}) (source: ${c.sourceUrl || "news scan"})`] : [];
  const contacts = await prospectCompany(state, { name: c.name, hq: c.hq, openRoles, extraFacts: extra, hunter: "emerging" });
  c.status = contacts.length ? "contacts_found" : c.status;
  return contacts;
}
