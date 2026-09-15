// Hunter 3: large AI labs and platforms. Mix of open roles (any region that fits) and cold DMs to international leaders.
import { BIG_COMPANIES } from "../profile.js";
import { fetchAts, looksRelevant, type RawJob } from "../sources/ats.js";
import { scoreJobs } from "../llm.js";
import { prospectCompany } from "./people.js";
import type { State, Job, Contact } from "../store.js";

const INTL = /(emea|apac|international|europe|israel|london|uk|middle east|global|regional|country)/i;

export async function huntBigLabs(state: State, prospectBudget = 2): Promise<{ jobs: Job[]; contacts: Contact[] }> {
  const boards = await Promise.all(BIG_COMPANIES.filter((c) => c.ats).map((c) => fetchAts(c.ats!.kind, c.ats!.slug, c.name)));
  const raw: RawJob[] = boards.flat().filter((j) => looksRelevant(j, false) && INTL.test(`${j.title} ${j.location}`) && !state.jobs[j.id]);
  const jobs: Job[] = [];
  if (raw.length) {
    const scores = await scoreJobs(raw.slice(0, 60).map((j) => ({ id: j.id, title: j.title, company: j.company, location: j.location, snippet: j.snippet })));
    for (const j of raw.slice(0, 60)) {
      const s = scores.find((x) => x.id === j.id);
      // For big labs we accept non-Israel international leadership roles (Eddie travels / relocates), so threshold is lower.
      const score = s?.score ?? 0;
      const job: Job = { ...j, score, reason: s?.reason ?? "", firstSeen: new Date().toISOString(), status: score >= 55 ? "new" : "skipped" };
      state.jobs[j.id] = job;
      if (job.status === "new") jobs.push(job);
    }
  }
  // Rotate through the big list: prospect the companies we have not touched yet, a couple per run.
  const touched = new Set(Object.values(state.contacts).map((c) => c.company.toLowerCase()));
  const todo = BIG_COMPANIES.filter((c) => !touched.has(c.name.toLowerCase())).slice(0, prospectBudget);
  const contacts: Contact[] = [];
  for (const c of todo) {
    const openRoles = jobs.filter((j) => j.company === c.name).map((j) => `${j.title} (${j.location}) ${j.url}`);
    contacts.push(...(await prospectCompany(state, { name: c.name, hq: "US", openRoles, hunter: "biglabs" }, 1)));
  }
  return { jobs, contacts };
}
