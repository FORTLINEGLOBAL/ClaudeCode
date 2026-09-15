// DuckDuckGo HTML endpoint: free web search without an API key. Best effort.
import * as cheerio from "cheerio";
import { fetchText } from "./http.js";

export interface SearchResult { title: string; url: string; snippet: string }

export async function duckSearch(query: string): Promise<SearchResult[]> {
  const html = await fetchText(`https://html.duckduckgo.com/html/?q=${encodeURIComponent(query)}`, { headers: { accept: "text/html" } });
  if (!html) return [];
  const $ = cheerio.load(html);
  const out: SearchResult[] = [];
  $(".result").each((_, el) => {
    const a = $(el).find("a.result__a");
    let url = a.attr("href") || "";
    const m = url.match(/uddg=([^&]+)/);
    if (m) url = decodeURIComponent(m[1]);
    const title = a.text().trim();
    const snippet = $(el).find(".result__snippet").text().trim();
    if (title && url.startsWith("http")) out.push({ title, url, snippet });
  });
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
