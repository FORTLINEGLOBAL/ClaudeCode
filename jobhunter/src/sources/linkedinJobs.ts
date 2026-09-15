// LinkedIn public "guest" job search. No login, HTML only, may rate-limit; best effort.
import * as cheerio from "cheerio";
import { fetchText } from "./http.js";
import type { RawJob } from "./ats.js";

export async function searchLinkedInJobs(keywords: string, location = "Israel", hours = 24 * 7): Promise<RawJob[]> {
  const url = `https://www.linkedin.com/jobs-guest/jobs/api/seeMoreJobPostings/search?keywords=${encodeURIComponent(keywords)}&location=${encodeURIComponent(location)}&f_TPR=r${hours * 3600}&start=0`;
  const html = await fetchText(url, { headers: { accept: "text/html" } });
  if (!html) return [];
  const $ = cheerio.load(html);
  const out: RawJob[] = [];
  $("li").each((_, li) => {
    const el = $(li);
    const title = el.find(".base-search-card__title").text().trim();
    const company = el.find(".base-search-card__subtitle").text().trim();
    const loc = el.find(".job-search-card__location").text().trim();
    const href = el.find("a.base-card__full-link").attr("href") || el.find("a").attr("href") || "";
    const m = href.match(/-(\d{6,})\?|\/(\d{6,})\/?/);
    const id = m ? (m[1] || m[2]) : href;
    if (title && href) out.push({ id: `li-${id}`, title, company, location: loc, url: href.split("?")[0], source: "linkedin" });
  });
  return out;
}
