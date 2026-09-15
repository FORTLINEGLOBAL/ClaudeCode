import type { Config, Context } from "@netlify/functions";
import { loadState, saveState } from "../../src/store.js";
import { parseInbound, sendText, verifySignature } from "../../src/whatsapp.js";
import { handleCommand } from "../../src/commands.js";

export default async (req: Request, _ctx: Context) => {
  const url = new URL(req.url);
  if (req.method === "GET") {
    // Meta webhook verification handshake
    if (url.searchParams.get("hub.mode") === "subscribe" && url.searchParams.get("hub.verify_token") === process.env.WHATSAPP_VERIFY_TOKEN) {
      return new Response(url.searchParams.get("hub.challenge") || "", { status: 200 });
    }
    return new Response("forbidden", { status: 403 });
  }
  if (req.method !== "POST") return new Response("method not allowed", { status: 405 });
  const raw = await req.text();
  if (!verifySignature(raw, req.headers.get("x-hub-signature-256"))) return new Response("bad signature", { status: 401 });
  let body: any;
  try { body = JSON.parse(raw); } catch { return new Response("ok", { status: 200 }); }
  const inbound = parseInbound(body);
  if (!inbound) return new Response("ok", { status: 200 });          // status updates etc.
  if (inbound.from !== process.env.EDDIE_WHATSAPP) return new Response("ok", { status: 200 }); // ignore strangers

  const state = await loadState();
  state.lastInboundAt = new Date().toISOString();
  let reply: string;
  try { reply = await handleCommand(state, inbound.text); }
  catch (e: any) { reply = `Something broke: ${e?.message || e}`; }
  await saveState(state);
  await sendText(reply, state.lastInboundAt);
  return new Response("ok", { status: 200 });
};

export const config: Config = { path: "/whatsapp" };
