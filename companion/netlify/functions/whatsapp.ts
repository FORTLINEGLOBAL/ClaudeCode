// WhatsApp webhook (Meta Cloud API).
//   GET  /api/whatsapp   Meta's one-time verification (hub.verify_token must match WHATSAPP_VERIFY_TOKEN)
//   POST /api/whatsapp   incoming messages, signed with WHATSAPP_APP_SECRET
// A message from a number that isn't a parent's is ignored. The reply is sent inside the
// request, like the web chat; memory is finished after the response.
import type { Config, Context } from "@netlify/functions";
import { firstTime, listParents, saveParent } from "../../src/store.js";
import { converse, receive } from "../../src/companion.js";
import { whatsappChannel } from "../../src/channel.js";
import { inboundMessages, sendText, validSignature, waNumber } from "../../src/whatsapp.js";

const TEXT_ONLY = {
  he: "כרגע אני יכול לקרוא רק הודעות כתובות. אפשר לכתוב לי במילים?",
  en: "For now I can only read written messages. Could you write it to me in words?",
};

export default async (req: Request, context: Context) => {
  if (req.method === "GET") {
    const q = new URL(req.url).searchParams;
    const want = process.env.WHATSAPP_VERIFY_TOKEN;
    if (q.get("hub.mode") === "subscribe" && want && q.get("hub.verify_token") === want) return new Response(q.get("hub.challenge") ?? "", { status: 200 });
    return new Response("forbidden", { status: 403 });
  }
  if (req.method !== "POST") return new Response("method not allowed", { status: 405 });

  const raw = await req.text();
  if (!validSignature(raw, req.headers.get("x-hub-signature-256"))) return new Response("bad signature", { status: 401 });
  let payload: unknown;
  try { payload = JSON.parse(raw); } catch { return new Response("bad request", { status: 400 }); }

  const messages = inboundMessages(payload);
  if (!messages.length) return new Response("ok");   // delivery/read statuses
  const parents = await listParents();

  for (const m of messages) {
    if (!(await firstTime(`wa/${m.id}`))) continue;   // Meta retries
    const p = parents.find((x) => x.whatsapp && waNumber(x.whatsapp) === m.from);
    if (!p) { console.warn("whatsapp message from an unknown number, ignored"); continue; }
    p.lastInboundAt = new Date().toISOString();   // opens the 24h window before we answer
    if (!m.text) {
      await saveParent(p);
      await sendText(m.from, TEXT_ONLY[p.lang === "auto" ? p.lastLang : p.lang]);
      continue;
    }
    const text = m.text.trim().slice(0, 4000);
    const r = await receive(p, text, whatsappChannel);
    if (!r.handled) await converse(p, r.parentMsgId, whatsappChannel, (work) => context.waitUntil(work));
  }
  return new Response("ok");
};

export const config: Config = { path: "/api/whatsapp" };
