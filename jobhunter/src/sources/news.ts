// Funding news via Google News RSS (free, reliable). LinkedIn posts via DuckDuckGo as best effort.
import { XMLParser } from "fast-xml-parser";
import { fetchText, strip } from "./http.js";
import { duckSearch } from "./search.js";

export interface NewsItem { title: string; snippet: string; url: string; date?: string; source: string }

const parser = new XMLParser({ ignoreAttributes: false });

export async function googleNews(query: string, days = 7): Promise<NewsItem[]> {
  const url = `https://news.google.com/rss/search?q=${encodeURIComponent(`${query} when:${days}d`)}&hl=en-US&gl=US&ceid=US:en`;
  const xml = await fetchText(url);
  if (!xml) return [];
  try {
    const j = parser.parse(xml);
    const items = j?.rss?.channel?.item || [];
    return (Array.isArray(items) ? items : [items]).map((it: any) => ({
      title: String(it.title || ""), snippet: strip(String(it.description || "")).slice(0, 300), url: String(it.link || ""), date: it.pubDate, source: "google-news",
    }));
  } catch { return []; }
}

export const FUNDING_QUERIES = [
  '"raises" "$100 million" AI', '"raises" "$150 million"', '"raises" "$200 million" startup', '"raised" "$75 million" AI',
  '"Series B" "million" AI infrastructure', '"Series C" "million" AI', '"Series D" million startup', 'AI startup funding round "international expansion"',
  'CRM startup raises million', 'inference startup raises', 'AI agents startup raises million', 'Israeli startup raises million',
];

export async function fundingNews(days = 7): Promise<NewsItem[]> {
  const all = await Promise.all(FUNDING_QUERIES.map((q) => googleNews(q, days)));
  const seen = new Set<string>();
  const out: NewsItem[] = [];
  for (const it of all.flat()) {
    const k = it.title.toLowerCase().slice(0, 80);
    if (seen.has(k)) continue;
    seen.add(k);
    out.push(it);
  }
  return out;
}

// LinkedIn posts about funding, found through a web search engine (LinkedIn itself is closed).
export async function linkedinPostsAboutFunding(): Promise<NewsItem[]> {
  const queries = [
    'site:linkedin.com/posts "raised" "Series" million AI', 'site:linkedin.com/posts "excited to announce" "$100M"',
    'site:linkedin.com/posts "we raised" "expanding" EMEA', 'site:linkedin.com/posts funding "international expansion" APAC',
  ];
  const res = await Promise.all(queries.map((q) => duckSearch(q)));
  return res.flat().map((r) => ({ title: r.title, snippet: r.snippet, url: r.url, source: "linkedin-post" }));
}
