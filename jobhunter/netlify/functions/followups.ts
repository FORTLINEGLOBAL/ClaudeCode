import type { Config } from "@netlify/functions";
import { loadState, saveState, enqueue } from "../../src/store.js";
import { prepareFollowUps } from "../../src/followups.js";
import { fmtContactFull } from "../../src/digest.js";
import { sendText } from "../../src/whatsapp.js";

export default async (req: Request) => {
  const url = new URL(req.url);
  if (url.searchParams.has("key") && url.searchParams.get("key") !== process.env.JOBHUNTER_ADMIN_KEY) return new Response("forbidden", { status: 403 });
  const state = await loadState();
  const due = await prepareFollowUps(state);
  let text = "";
  if (due.length) {
    text = "FOLLOW-UPS DUE TODAY\n\n" + due.map((c) => fmtContactFull(enqueue(state, "contact", c.id), c)).join("\n\n");
  }
  await saveState(state);
  if (text) await sendText(text, state.lastInboundAt);
  return new Response(text || "no follow-ups due", { status: 200 });
};

export const config: Config = { schedule: "0 6 * * *" };
