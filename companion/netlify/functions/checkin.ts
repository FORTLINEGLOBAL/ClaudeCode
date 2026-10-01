// Scheduled every 15 minutes (netlify.toml): sends each parent's daily check-in and
// any family reminders when due.
import { listParents } from "../../src/store.js";
import { checkIn } from "../../src/companion.js";
import { checkinDue } from "../../src/policy.js";
import { webChannel } from "../../src/channel.js";
import { sendDueReminders } from "../../src/reminders.js";

export default async () => {
  for (const p of await listParents()) {
    try { await sendDueReminders(p, webChannel); }
    catch (e) { console.error(`reminders failed for ${p.id}`, e); }
    if (!checkinDue(p)) continue;
    try { await checkIn(p, webChannel); }
    catch (e) { console.error(`check-in failed for ${p.id}`, e); }
  }
};
