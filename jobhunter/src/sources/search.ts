// DuckDuckGo HTML endpoint: free web search without an API key.
// Everything about finding people runs through here, so when it returns nothing it
// has to say whether that means "no such people" or "the page was not what we expect".
import * as cheerio from "cheerio";
import { fetchText, strip } from "./http.js";

export interface SearchResult { title: string; url: string; snippet: string }

export interface SearchNote { query: string; bytes: number; results: number; verdict: "ok" | "empty" | "blocked" | "unrecognised" | "no-response" }

let searchTrace: SearchNote[] | null = null;
export function startSearchTrace(): void { searchTrace = []; }
export function endSearchTrace(): SearchNote[] { const t = searchTrace ?? []; searchTrace = null; return t; }

export function searchSummary(notes: SearchNote[]): string {
  if (!notes.length) return "no searches ran";
  const by = new Map<string, number>();
  for (const n of notes) by.set(n.verdict, (by.get(n.verdict) || 0) + 1);
  const total = notes.reduce((s, n) => s + n.results, 0);
  return `${notes.length} searches, ${total} results — ${[...by].map(([k, v]) => `${v} ${k}`).join(", ")}`;
}

// Pages served instead of results when the endpoint declines to answer.
const BLOCK_MARKERS = /anomaly|unusual traffic|captcha|are you a robot|rate limit|too many requests/i;
// Result containers, oldest to newest markup. DuckDuckGo has shipped several.
const ROW_SELECTORS = [".result", ".web-result", ".results_links", "article[data-testid=result]"];
const LINK_SELECTORS = ["a.result__a", "a.result__url", "h2 a", "a[href]"];

/**
 * Parse a results page into rows plus a verdict on what the page actually was.
 * Pure, so the markup handling is testable without reaching the network - which is
 * the whole point, since a silent parse failure here empties both people hunters.
 */
export function parseSearchHtml(html: string): { results: SearchResult[]; verdict: SearchNote["verdict"] } {
  const $ = cheerio.load(html);
  const out: SearchResult[] = [];
  const seen = new Set<string>();
  for (const rowSel of ROW_SELECTORS) {
    $(rowSel).each((_, el) => {
      const row = $(el);
      let a = $();
      for (const ls of LINK_SELECTORS) { a = row.find(ls).first(); if (a.length) break; }
      let url = a.attr("href") || "";
      // DuckDuckGo wraps outbound links in a redirect carrying the real target in uddg=.
      const m = url.match(/uddg=([^&]+)/);
      if (m) url = decodeURIComponent(m[1]);
      if (url.startsWith("//")) url = `https:${url}`;
      const title = a.text().trim();
      const snippet = row.find(".result__snippet, .result__body").text().trim();
      if (title && url.startsWith("http") && !seen.has(url)) { seen.add(url); out.push({ title, url, snippet }); }
    });
    if (out.length) break;
  }
  if (out.length) return { results: out, verdict: "ok" };
  if (BLOCK_MARKERS.test(strip(html).slice(0, 2000))) return { results: out, verdict: "blocked" };
  // A real results page that genuinely matched nothing still carries the search form.
  if (/name=["']q["']/.test(html)) return { results: out, verdict: "empty" };
  return { results: out, verdict: "unrecognised" };
}

export async function duckSearch(query: string): Promise<SearchResult[]> {
  // POST is what this endpoint is built for; the GET form is the one that gets declined.
  const html = await fetchText("https://html.duckduckgo.com/html/", {
    method: "POST",
    headers: { accept: "text/html", "content-type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({ q: query }).toString(),
  });
  const note = (results: number, verdict: SearchNote["verdict"]) => {
    if (searchTrace) searchTrace.push({ query: query.slice(0, 60), bytes: html?.length ?? 0, results, verdict });
  };
  if (!html) { note(0, "no-response"); return []; }

  const { results: out, verdict } = parseSearchHtml(html);
  note(out.length, verdict);
  return out;
}

// Find senior people at a company on LinkedIn through the search engine.
export async function findPeople(company: string, titles: string[]): Promise<SearchResult[]> {
  const groups = [titles.slice(0, 6), titles.slice(6, 12), titles.slice(12)].filter((g) => g.length);
  const queries = groups.map((g) => `site:linkedin.com/in "${company}" (${g.map((t) => `"${t}"`).join(" OR ")})`);
  const res = await Promise.all(queries.map((q) => duckSearch(q)));
  const seen = new Set<string>();
  return res.flat().filter((r) => /linkedin\.com\/in\//.test(r.url) && !seen.has(r.url) && seen.add(r.url));
}

// Recent facts about a company (for hooks). Only results with a URL are returned, so every hook is sourced.
export async function companyFacts(company: string): Promise<SearchResult[]> {
  const res = await duckSearch(`"${company}" (raises OR funding OR expansion OR "opens office" OR EMEA OR APAC OR hiring) 2026`);
  return res.slice(0, 5);
}
