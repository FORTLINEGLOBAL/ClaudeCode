// Source health check. Probes each feed the hunters depend on, one representative
// call each, and reports exactly what came back. Turns "nothing new" into a fact.
import { fetchAts } from "./sources/ats.js";
import { searchLinkedInJobs } from "./sources/linkedinJobs.js";
import { googleNews } from "./sources/news.js";
import { duckSearch } from "./sources/search.js";
import { startTrace, endTrace, traceSummary } from "./sources/http.js";
import { startSearchTrace, endSearchTrace } from "./sources/search.js";
import { scoreJobs } from "./llm.js";
import type { State } from "./store.js";

interface Probe { name: string; items: number; ok: boolean; detail: string }

async function probe(name: string, run: () => Promise<{ length: number }>): Promise<Probe> {
  const t = Date.now();
  try {
    const r = await run();
    return { name, items: r.length, ok: r.length > 0, detail: `${r.length} items in ${Date.now() - t}ms` };
  } catch (e: any) {
    return { name, items: 0, ok: false, detail: `threw: ${e?.message || e}` };
  }
}

export async function runDiagnostics(state: State): Promise<string> {
  startTrace();
  startSearchTrace();
  const probes = await Promise.all([
    probe("Google News RSS", () => googleNews('"raises" "$100 million" AI', 7)),
    probe("DuckDuckGo search", () => duckSearch('site:linkedin.com/in "Anthropic" "VP"')),
    probe("LinkedIn guest jobs", () => searchLinkedInJobs("revenue operations", "Israel")),
    probe("Greenhouse board", () => fetchAts("greenhouse", "anthropic", "Anthropic")),
    probe("Lever board", () => fetchAts("lever", "mistral", "Mistral")),
    probe("Ashby board", () => fetchAts("ashby", "openai", "OpenAI")),
  ]);

  // The Claude key matters as much as the feeds: scoring failures also yield an empty scan.
  let llm = "Claude API: not reached";
  try {
    const s = await scoreJobs([{ id: "probe", title: "VP Revenue Operations", company: "Test", location: "Tel Aviv, Israel" }]);
    llm = s.length ? `Claude API: ok (probe scored ${s[0]?.score})` : "Claude API: returned no scores";
  } catch (e: any) {
    llm = `Claude API: FAILED — ${e?.message || e}`;
  }

  const notes = endTrace();
  const searches = endSearchTrace();
  const dead = probes.filter((p) => !p.ok);

  return [
    "SOURCE CHECK",
    probes.map((p) => `${p.ok ? "ok  " : "DEAD"} ${p.name}: ${p.detail}`).join("\n"),
    llm,
    "",
    "WIRE",
    traceSummary(notes) || "no fetches recorded",
    // The people hunters live or die on this: a parsed page with zero rows is not the
    // same as a page that was declined, and only the verdict tells them apart.
    searches.length ? `Search verdicts: ${searches.map((s) => `${s.verdict} (${s.results} results, ${Math.round(s.bytes / 1024)}kb)`).join("; ")}` : "",
    "",
    dead.length === probes.length
      ? "Every feed is dead. Nothing reaches the network — check outbound access, not the market."
      : dead.length
        ? `Dead feeds: ${dead.map((d) => d.name).join(", ")}. The rest work, so the scan is running on partial data.`
        : "All feeds alive.",
    state.lastScan
      ? `\nLAST SCAN ${state.lastScan.at.slice(0, 16).replace("T", " ")} UTC: ${state.lastScan.elapsedSec}s, ${state.lastScan.fetchesOk}/${state.lastScan.fetches} fetches ok, ${state.lastScan.jobs} jobs, ${state.lastScan.contacts} contacts, ${state.lastScan.companies} companies.${state.lastScan.search ? `\nSearch: ${state.lastScan.search}` : ""}${state.lastScan.prospect ? `\n${state.lastScan.prospect}` : ""}${state.lastScan.errors ? `\nErrors: ${state.lastScan.errors}` : ""}`
      : "\nNo scan recorded yet.",
  ].join("\n");
}
