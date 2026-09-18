// Background worker: 15-minute budget, so the real scans and the multi-step
// commands run here instead of inside the 10s webhook. Results are pushed to
// WhatsApp when they are ready.
import { loadState, saveState } from "../../src/store.js";
import { runScan } from "../../src/scan.js";
import { handleCommand } from "../../src/commands.js";
import { sendText } from "../../src/whatsapp.js";
import { prepareFollowUps } from "../../src/followups.js";
import { fmtContactFull } from "../../src/digest.js";
import { enqueue } from "../../src/store.js";
import { verifyInternal, type Work } from "../../src/internal.js";

export default async (req: Request) => {
  const raw = await req.text();
  if (!verifyInternal(raw, req.headers.get("x-jobhunter-signature"))) {
    console.error("work-background: rejected unsigned call");
    return;
  }
  let work: Work;
  try { work = JSON.parse(raw); } catch { return; }

  const state = await loadState();
  let reply = "";
  try {
    if (work.kind === "scan") {
      reply = await runScan(state);
    } else if (work.kind === "followups") {
      const due = await prepareFollowUps(state);
      reply = due.length ? "FOLLOW-UPS DUE TODAY\n\n" + due.map((c) => fmtContactFull(enqueue(state, "contact", c.id), c)).join("\n\n") : "";
    } else {
      reply = await handleCommand(state, work.text || "");
    }
  } catch (e: any) {
    reply = `That broke while running: ${e?.message || e}`;
  }
  await saveState(state);
  if (reply) await sendText(reply, work.lastInboundAt || state.lastInboundAt);
};
