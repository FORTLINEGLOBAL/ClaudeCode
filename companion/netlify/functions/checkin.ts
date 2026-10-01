// Scheduled every 15 minutes (netlify.toml): sends each parent's daily check-in when due.
import { listParents } from "../../src/store.js";
import { checkIn } from "../../src/companion.js";
import { checkinDue } from "../../src/policy.js";
import { webChannel } from "../../src/channel.js";

export default async () => {
  for (const p of await listParents()) {
    if (!checkinDue(p)) continue;
    try { await checkIn(p, webChannel); }
    catch (e) { console.error(`check-in failed for ${p.id}`, e); }
  }
};
