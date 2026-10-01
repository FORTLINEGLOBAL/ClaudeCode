// The parent's web chat. GET returns the conversation (polled by the page),
// POST sends a message. The access link's token identifies the parent.
import type { Config } from "@netlify/functions";
import { getChat, parentForToken, saveParent } from "../../src/store.js";
import { receive } from "../../src/companion.js";
import { webChannel } from "../../src/channel.js";
import { dispatch } from "../../src/internal.js";

const json = (body: unknown, status = 200) => new Response(JSON.stringify(body), { status, headers: { "content-type": "application/json", "cache-control": "no-store" } });

export default async (req: Request) => {
  const token = req.headers.get("x-companion-token") || "";
  const p = await parentForToken(token);
  if (!p) return json({ error: "This link is not valid. Please ask your family for a new one." }, 401);

  if (req.method === "GET") {
    const after = new URL(req.url).searchParams.get("after") || "";
    const log = await getChat(p.id);
    const i = after ? log.findIndex((m) => m.id === after) : -1;
    return json({
      name: p.name, gender: p.gender ?? null, lang: p.lang, lastLang: p.lastLang,
      messages: (i >= 0 ? log.slice(i + 1) : log.slice(-50)).map(({ id, role, text, at, kind, lang }) => ({ id, role, text, at, kind, lang })),
    });
  }

  if (req.method !== "POST") return json({ error: "method not allowed" }, 405);
  let body: { text?: string; lang?: string };
  try { body = await req.json(); } catch { return json({ error: "bad request" }, 400); }

  // Language toggle on the page: an explicit preference always wins over detection.
  if (body.lang === "he" || body.lang === "en" || body.lang === "auto") {
    p.lang = body.lang;
    if (body.lang !== "auto") p.lastLang = body.lang;
    await saveParent(p);
    return json({ ok: true });
  }

  const text = (body.text || "").trim().slice(0, 4000);
  if (!text) return json({ error: "empty message" }, 400);
  const r = await receive(p, text, webChannel);
  if (!r.handled) await dispatch({ kind: "turn", parentId: p.id, parentMsgId: r.parentMsgId });
  return json({ ok: true, pending: !r.handled });
};

export const config: Config = { path: "/api/chat" };
