// Hunter 1: senior commercial / GTM / RevOps / BizOps jobs in Israel.
import { BIG_COMPANIES, JOB_TARGET } from "../profile.js";
import { fetchAts, resolveAts, looksRelevant, type RawJob } from "../sources/ats.js";
import { searchLinkedInJobs } from "../sources/linkedinJobs.js";
import { scoreJobs } from "../llm.js";
import type { State, Job } from "../store.js";

export async function huntJobs(state: State): Promise<Job[]> {
  const raw: RawJob[] = [];
  // LinkedIn guest search, one query at a time to stay polite.
  for (const q of JOB_TARGET.searchQueries) {
    raw.push(...(await searchLinkedInJobs(q, JOB_TARGET.location)));
  }
  // ATS boards of the big list, filtered to Israel / remote. resolveAts is sequential on
  // purpose: it may probe, and the cache it fills must not be written from parallel branches.
  for (const c of BIG_COMPANIES) {
    const ref = await resolveAts(state.atsCache, c.name, c.ats);
    if (!ref) continue;
    const jobs = await fetchAts(ref.kind, ref.slug, c.name);
    raw.push(...jobs.filter((j) => looksRelevant(j, true)));
  }

  const fresh = raw.filter((j) => !state.jobs[j.id] && !state.settings.blockedCompanies.some((b) => j.company.toLowerCase().includes(b.toLowerCase())));
  const dedup = Array.from(new Map(fresh.map((j) => [j.id, j])).values()).slice(0, 60);
  if (!dedup.length) return [];

  const scores = await scoreJobs(dedup.map((j) => ({ id: j.id, title: j.title, company: j.company, location: j.location, snippet: j.snippet })));
  const now = new Date().toISOString();
  const out: Job[] = [];
  for (const j of dedup) {
    const s = scores.find((x) => x.id === j.id);
    const job: Job = { ...j, score: s?.score ?? 0, reason: s?.reason ?? "", firstSeen: now, status: (s?.score ?? 0) >= 70 ? "new" : "skipped" };
    state.jobs[j.id] = job;
    if (job.status === "new") out.push(job);
  }
  return out.sort((a, b) => b.score - a.score);
}
