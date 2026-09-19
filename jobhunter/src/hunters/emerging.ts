// Hunter 2: emerging companies that raised $75M+ and are expanding internationally.
import { EMERGING_TARGET } from "../profile.js";
import { fundingNews, linkedinPostsAboutFunding } from "../sources/news.js";
import { extractFunding } from "../llm.js";
import { resolveAts, fetchAts, looksRelevant } from "../sources/ats.js";
import { prospectCompany } from "./people.js";
import { slug, type State, type Contact, type Company } from "../store.js";

/**
 * A company we cannot actually prospect. The news scan yields entries like
 * "Unnamed ex-HiSilicon chip chief's startup" - a real raise, but there is no name to
 * search LinkedIn for, and only a handful of companies get prospected per run.
 */
export function isUnprospectable(name: string): boolean {
  const n = name.trim().toLowerCase();
  if (n.length < 2) return true;
  return /^(an?|the)?\s*(unnamed|undisclosed|unknown|stealth|anonymous)\b/.test(n) || /\b(unnamed|undisclosed|stealth[- ]mode)\b/.test(n);
}

/**
 * Dedupe key for a company name. The same raise is reported as both "Arcee" and
 * "Arcee AI", which otherwise slug to different ids and get prospected twice.
 */
export function companyKey(name: string): string {
  return slug(name.trim().toLowerCase()
    .replace(/[.,]/g, "")
    .replace(/\s+(ai|inc|llc|ltd|corp|co|technologies|labs)$/i, "")
    .trim());
}

export async function huntEmerging(state: State): Promise<{ companies: Company[]; contacts: Contact[] }> {
  const [news, posts] = await Promise.all([fundingNews(7), linkedinPostsAboutFunding()]);
  const items = [...news, ...posts].slice(0, 80);
  const found = await extractFunding(items.map((i) => ({ title: i.title, snippet: i.snippet, url: i.url, date: i.date })));
  const newCompanies: Company[] = [];
  const seenThisRun = new Set<string>();
  for (const f of found) {
    if (!f.relevant || f.raisedUSD < EMERGING_TARGET.minRaiseUSD) continue;
    if (isUnprospectable(f.name)) continue;      // nothing to search LinkedIn for
    const key = companyKey(f.name);
    if (seenThisRun.has(key)) continue;          // "Arcee" and "Arcee AI" are one company
    seenThisRun.add(key);
    const id = slug(f.name);
    if (state.companies[id] || Object.values(state.companies).some((c) => companyKey(c.name) === key)) continue;
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
