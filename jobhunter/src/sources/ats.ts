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
