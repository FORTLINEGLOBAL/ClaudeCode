import type { Config } from "@netlify/functions";
import { loadState, saveState } from "../../src/store.js";
import { runScan } from "../../src/scan.js";
import { sendText } from "../../src/whatsapp.js";

export default async (req: Request) => {
  const url = new URL(req.url);
  const manual = url.searchParams.has("key");
  if (manual && url.searchParams.get("key") !== process.env.JOBHUNTER_ADMIN_KEY) return new Response("forbidden", { status: 403 });
  const state = await loadState();
  const digest = await runScan(state, { force: manual });
  await saveState(state);
  if (digest) await sendText(digest, state.lastInboundAt);
  return new Response(digest || "nothing new", { status: 200 });
};

export const config: Config = { schedule: "0 */6 * * *" };
