import { fetchAts, looksRelevant } from "../src/sources/ats.js";
import { searchLinkedInJobs } from "../src/sources/linkedinJobs.js";
import { googleNews } from "../src/sources/news.js";
import { findPeople, duckSearch } from "../src/sources/search.js";
import { BIG_COMPANIES, EMERGING_TARGET } from "../src/profile.js";

for (const c of BIG_COMPANIES) {
  const j = await fetchAts(c.ats!.kind, c.ats!.slug, c.name);
  console.log("ATS", c.name, c.ats!.kind, c.ats!.slug, j.length, "relevant intl:", j.filter(x => looksRelevant(x, false)).length);
}
const li = await searchLinkedInJobs("VP Sales", "Israel");
console.log("LinkedIn guest jobs:", li.length, li.slice(0, 2));
const gn = await googleNews('"raises" "$100 million" AI', 7);
console.log("Google News:", gn.length, gn.slice(0, 2).map(x => x.title));
const dd = await duckSearch('site:linkedin.com/posts "raised" "Series" million AI');
console.log("DDG posts:", dd.length, dd.slice(0, 2));
const pp = await findPeople("Together AI", EMERGING_TARGET.execTitles);
console.log("People:", pp.length, pp.slice(0, 3));
