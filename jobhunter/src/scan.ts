import { huntJobs } from "./hunters/jobs.js";
import { huntEmerging } from "./hunters/emerging.js";
import { huntBigLabs } from "./hunters/biglabs.js";
import { buildDigest } from "./digest.js";
import type { State } from "./store.js";

// Runs all hunters. Returns the digest text when there is something new, otherwise "".
export async function runScan(state: State, opts: { force?: boolean } = {}): Promise<string> {
  if (state.settings.paused && !opts.force) return "";
  const errors: string[] = [];
  const safe = async <T>(name: string, p: Promise<T>, fallback: T): Promise<T> => {
    try { return await p; } catch (e: any) { errors.push(`${name}: ${e?.message || e}`); return fallback; }
  };
  const jobs = await safe("jobs", huntJobs(state), []);
  const emerging = await safe("emerging", huntEmerging(state), { companies: [], contacts: [] });
  const big = await safe("biglabs", huntBigLabs(state), { jobs: [], contacts: [] });
  const allJobs = [...jobs, ...big.jobs];
  const contacts = [...emerging.contacts, ...big.contacts];
  if (!allJobs.length && !contacts.length && !emerging.companies.length) return "";
  const header = [
    `New from the scan (${new Date().toISOString().slice(0, 16).replace("T", " ")} UTC):`,
    emerging.companies.length ? `Funding radar: ${emerging.companies.map((c) => `${c.name} ($${Math.round((c.raisedUSD || 0) / 1e6)}M, ${c.hq})`).join(", ")}` : "",
    errors.length ? `Source errors: ${errors.join(" | ")}` : "",
  ].filter(Boolean).join("\n");
  return buildDigest(state, allJobs, contacts, header);
}
