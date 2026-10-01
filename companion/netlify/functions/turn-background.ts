// Background worker (15-minute budget): the companion's replies and the daily check-ins.
import { getParent, listParents } from "../../src/store.js";
import { checkIn, converse } from "../../src/companion.js";
import { checkinDue } from "../../src/policy.js";
import { webChannel } from "../../src/channel.js";
import { verifyInternal, type Work } from "../../src/internal.js";

export default async (req: Request) => {
  const raw = await req.text();
  if (!verifyInternal(raw, req.headers.get("x-companion-signature"))) {
    console.error("turn-background: rejected unsigned call");
    return;
  }
  const work = JSON.parse(raw) as Work;

  if (work.kind === "turn") {
    const p = await getParent(work.parentId);
    if (p) await converse(p, work.parentMsgId, webChannel);
    return;
  }

  for (const p of await listParents()) {
    if (!checkinDue(p)) continue;
    try { await checkIn(p, webChannel); }
    catch (e) { console.error(`check-in failed for ${p.id}`, e); }
  }
};
