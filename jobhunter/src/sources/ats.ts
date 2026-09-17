// Public job boards of Greenhouse, Lever and Ashby. Free, no auth, stable JSON.
import { fetchJSON } from "./http.js";

export interface RawJob { id: string; title: string; company: string; location: string; url: string; source: string; snippet?: string }
export type AtsKind = "greenhouse" | "lever" | "ashby";

export async function fetchAts(kind: AtsKind, slug: string, company: string): Promise<RawJob[]> {
  try {
    if (kind === "greenhouse") {
      const d = await fetchJSON<{ jobs: Array<{ id: number; title: string; absolute_url: string; location?: { name: string } }> }>(
        `https://boards-api.greenhouse.io/v1/boards/${slug}/jobs`);
      return (d?.jobs || []).map((j) => ({ id: `gh-${slug}-${j.id}`, title: j.title, company, location: j.location?.name || "", url: j.absolute_url, source: "greenhouse" }));
    }
    if (kind === "lever") {
      const d = await fetchJSON<Array<{ id: string; text: string; hostedUrl: string; categories?: { location?: string; team?: string } }>>(
        `https://api.lever.co/v0/postings/${slug}?mode=json`);
      return (d || []).map((j) => ({ id: `lv-${slug}-${j.id}`, title: j.text, company, location: j.categories?.location || "", url: j.hostedUrl, source: "lever", snippet: j.categories?.team }));
    }
    const d = await fetchJSON<{ jobs: Array<{ id: string; title: string; location: string; jobUrl: string; department?: string; isRemote?: boolean }> }>(
      `https://api.ashbyhq.com/posting-api/job-board/${slug}`);
    return (d?.jobs || []).map((j) => ({ id: `ab-${slug}-${j.id}`, title: j.title, company, location: `${j.location}${j.isRemote ? " (remote)" : ""}`, url: j.jobUrl, source: "ashby", snippet: j.department }));
  } catch {
    return [];
  }
}

// A resolved (or known-missing) job board for a company, cached in state so a wrong
// hardcoded slug self-heals and a company with no public board is not re-probed every run.
export interface AtsRef { kind: AtsKind | null; slug: string; checkedAt: string }

const HIT_TTL_DAYS = 30;   // re-verify a working board monthly
const MISS_TTL_DAYS = 7;   // retry a company with no board weekly

function fresh(ref: AtsRef | undefined, days: number): boolean {
  return !!ref && Date.now() - Date.parse(ref.checkedAt) < days * 86400 * 1000;
}

/**
 * What the cache alone can tell us about a company's board.
 * Returns the board, null for a known-missing board, or undefined when a lookup is needed.
 * Pure, so the cache policy is testable without touching the network.
 */
export function cachedAts(cache: Record<string, AtsRef>, company: string): { kind: AtsKind; slug: string } | null | undefined {
  const cached = cache[company.toLowerCase()];
  if (cached?.kind && fresh(cached, HIT_TTL_DAYS)) return { kind: cached.kind, slug: cached.slug };
  if (cached && cached.kind === null && fresh(cached, MISS_TTL_DAYS)) return null;
  return undefined;
}

/**
 * Find a company's job board, preferring (in order) a fresh cache hit, the slug configured
 * in profile.ts, then probed guesses. The cache is mutated in place by the caller's state.
 */
export async function resolveAts(
  cache: Record<string, AtsRef>,
  company: string,
  configured?: { kind: AtsKind; slug: string },
): Promise<{ kind: AtsKind; slug: string } | null> {
  const key = company.toLowerCase();
  const known = cachedAts(cache, company);
  if (known !== undefined) return known;

  const now = new Date().toISOString();
  if (configured) {
    const jobs = await fetchAts(configured.kind, configured.slug, company);
    if (jobs.length) {
      cache[key] = { ...configured, checkedAt: now };
      return configured;
    }
  }
  const probed = await probeAts(company);
  cache[key] = probed ? { ...probed, checkedAt: now } : { kind: null, slug: "", checkedAt: now };
  return probed;
}

// Try all three boards for a guessed slug. Used for companies discovered by the news scan.
export async function probeAts(company: string): Promise<{ kind: AtsKind; slug: string } | null> {
  const base = company.toLowerCase().replace(/\s*(ai|inc|labs)\s*$/i, "").trim();
  const guesses = Array.from(new Set([
    base.replace(/[^a-z0-9]+/g, ""), base.replace(/[^a-z0-9]+/g, "-"), company.toLowerCase().replace(/[^a-z0-9]+/g, "-"),
    company.toLowerCase().replace(/[^a-z0-9]+/g, "") + "ai", base.replace(/[^a-z0-9]+/g, "-") + "-ai",
  ].filter(Boolean)));
  for (const slug of guesses) {
    for (const kind of ["ashby", "greenhouse", "lever"] as AtsKind[]) {
      const jobs = await fetchAts(kind, slug, company);
      if (jobs.length) return { kind, slug };
    }
  }
  return null;
}

const RELEVANT = /(sales|revenue|commercial|go.?to.?market|gtm|business (operations|development)|bizops|revops|general manager|country manager|regional|emea|apac|international|partnerships|strategy)/i;
const SENIOR = /(vp|vice president|head|director|chief|officer|general manager|gm\b|managing director|lead)/i;

export function looksRelevant(j: RawJob, wantIsrael: boolean): boolean {
  const t = `${j.title} ${j.snippet || ""}`;
  if (!RELEVANT.test(t) || !SENIOR.test(j.title)) return false;
  if (!wantIsrael) return true;
  return /israel|tel aviv|remote/i.test(j.location);
}
