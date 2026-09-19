import { huntJobs } from "./hunters/jobs.js";
import { huntEmerging } from "./hunters/emerging.js";
import { huntBigLabs } from "./hunters/biglabs.js";
import { buildDigest } from "./digest.js";
import { startTrace, endTrace, traceSummary } from "./sources/http.js";
import type { State } from "./store.js";

// Runs all hunters. Returns the digest text when there is something new.
// When opts.force is set (a manual "scan now") it always returns something: either
// the digest or a report of what every source did, so an empty result is never
// silently indistinguishable from a broken one.
export async function runScan(state: State, opts: { force?: boolean } = {}): Promise<string> {
  if (state.settings.paused && !opts.force) return "";
  const errors: string[] = [];
  const safe = async <T>(name: string, p: Promise<T>, fallback: T): Promise<T> => {
    try { return await p; } catch (e: any) { errors.push(`${name}: ${e?.message || e}`); return fallback; }
  };
  startTrace();
  const started = Date.now();
  const jobs = await safe("jobs", huntJobs(state), []);
  const emerging = await safe("emerging", huntEmerging(state), { companies: [], contacts: [] });
  const big = await safe("biglabs", huntBigLabs(state), { jobs: [], contacts: [] });
  const notes = endTrace();
  const elapsed = Math.round((Date.now() - started) / 1000);

  const allJobs = [...jobs, ...big.jobs];
  const contacts = [...emerging.contacts, ...big.contacts];
  const empty = !allJobs.length && !contacts.length && !emerging.companies.length;

  state.lastScan = {
    at: new Date().toISOString(), elapsedSec: elapsed,
    fetches: notes.length, fetchesOk: notes.filter((n) => n.ok).length,
    jobs: allJobs.length, contacts: contacts.length, companies: emerging.companies.length,
    trace: traceSummary(notes), errors: errors.join(" | "),
  };

  if (empty && !opts.force) return "";
  if (empty) {
    // Manual scan that found nothing: say why, in terms of the wire.
    const ok = notes.filter((n) => n.ok).length;
    return [
      `Scan finished in ${elapsed}s. Nothing new.`,
      `Fetches: ${ok}/${notes.length} succeeded.`,
      notes.length ? traceSummary(notes) : "No fetches were made at all — that points at a code path, not the network.",
      errors.length ? `Hunter errors: ${errors.join(" | ")}` : "",
      ok === 0 && notes.length ? "Every source failed. This is not an empty market, it is a broken feed." : "",
    ].filter(Boolean).join("\n\n");
  }

  // A per-hunter tally, always. Without it a hunter that returns nothing is
  // indistinguishable from one that was never asked, which is how an empty DM
  // section went unexplained.
  const tally = `Israel jobs ${jobs.length} | big-lab roles ${big.jobs.length} | funded companies ${emerging.companies.length} | DM drafts ${contacts.length} (${state.draftsToday.count}/${state.settings.dailyDraftCap} today)`;
  const header = [
    `New from the scan (${new Date().toISOString().slice(0, 16).replace("T", " ")} UTC, ${elapsed}s):`,
    tally,
    emerging.companies.length ? `Funding radar: ${emerging.companies.map((c) => `${c.name} ($${Math.round((c.raisedUSD || 0) / 1e6)}M, ${c.hq})`).join(", ")}` : "",
    errors.length ? `Source errors: ${errors.join(" | ")}` : "",
  ].filter(Boolean).join("\n");
  return buildDigest(state, allJobs, contacts, header);
}
