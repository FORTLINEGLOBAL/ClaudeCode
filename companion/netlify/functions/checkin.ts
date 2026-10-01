// Scheduled every 15 minutes (netlify.toml): sends each parent's daily check-in and
// any family reminders when due, and the family's weekly email on Sunday morning.
import { listParents } from "../../src/store.js";
import { checkIn } from "../../src/companion.js";
import { checkinDue } from "../../src/policy.js";
import { channelFor } from "../../src/channel.js";
import { sendDueReminders } from "../../src/reminders.js";
import { sendDigestIfDue } from "../../src/digest.js";

export default async () => {
  for (const p of await listParents()) {
    try { await sendDueReminders(p, channelFor(p)); }
    catch (e) { console.error(`reminders failed for ${p.id}`, e); }
    try { await sendDigestIfDue(p); }
    catch (e) { console.error(`digest failed for ${p.id}`, e); }
    if (!checkinDue(p)) continue;
    try { await checkIn(p, channelFor(p)); }
    catch (e) { console.error(`check-in failed for ${p.id}`, e); }
  }
};
