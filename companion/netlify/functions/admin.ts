// Operator endpoints, protected by COMPANION_ADMIN_KEY.
//   POST /api/admin/parents   create a parent, returns their private chat link
//   POST /api/admin/link      issue a new link for an existing parent
//   GET  /api/admin/alerts    SOS alerts, newest first
//   GET  /api/admin/diag      tries each model once and reports any error
// The operator never sees the parent's private conversation here.
import type { Config } from "@netlify/functions";
import crypto from "node:crypto";
import { getAlerts, getParent, issueToken, newId, saveParent } from "../../src/store.js";
import { toMinutes } from "../../src/time.js";
import { diagnose } from "../../src/llm.js";
import type { Parent } from "../../src/types.js";

const json = (body: unknown, status = 200) => new Response(JSON.stringify(body, null, 2), { status, headers: { "content-type": "application/json" } });

function authorized(req: Request): boolean {
  const want = process.env.COMPANION_ADMIN_KEY;
  const got = req.headers.get("x-admin-key") || "";
  return !!want && want.length === got.length && crypto.timingSafeEqual(Buffer.from(want), Buffer.from(got));
}

const linkFor = (req: Request, token: string) => `${new URL(req.url).origin}/#t=${token}`;

export default async (req: Request) => {
  if (!authorized(req)) return json({ error: "unauthorized" }, 401);
  const route = new URL(req.url).pathname.replace(/^\/api\/admin\/?/, "");

  if (req.method === "GET" && route === "alerts") {
    return json((await getAlerts()).reverse());
  }

  if (req.method === "GET" && route === "diag") {
    return json({ apiKeySet: !!process.env.ANTHROPIC_API_KEY, models: await diagnose() });
  }

  if (req.method === "POST" && route === "parents") {
    const b = await req.json().catch(() => ({}));
    if (!b.name) return json({ error: "name is required" }, 400);
    const p: Parent = {
      id: newId(),
      name: String(b.name),
      gender: b.gender === "f" || b.gender === "m" ? b.gender : undefined,
      lang: b.lang === "he" || b.lang === "en" ? b.lang : "auto",
      lastLang: b.lang === "en" ? "en" : "he",
      tz: b.tz || "America/New_York",
      checkinTime: b.checkinTime || "10:00",
      quietStart: b.quietStart || "21:00",
      quietEnd: b.quietEnd || "08:00",
      emergencyNumber: b.emergencyNumber || "911",
      codeWord: b.codeWord || undefined,
      contacts: Array.isArray(b.contacts) ? b.contacts : [],
      consent: { checkins: b.consent?.checkins ?? true, memory: b.consent?.memory ?? true, escalation: b.consent?.escalation ?? true },
      stopped: false,
      createdAt: new Date().toISOString(),
    };
    try {
      new Intl.DateTimeFormat("en", { timeZone: p.tz });
      [p.checkinTime, p.quietStart, p.quietEnd].forEach(toMinutes);
    } catch (e: any) {
      return json({ error: e?.message || String(e) }, 400);
    }
    await saveParent(p);
    return json({ id: p.id, link: linkFor(req, await issueToken(p.id)) }, 201);
  }

  if (req.method === "POST" && route === "link") {
    const b = await req.json().catch(() => ({}));
    const p = b.id ? await getParent(String(b.id)) : null;
    if (!p) return json({ error: "unknown parent id" }, 404);
    return json({ id: p.id, link: linkFor(req, await issueToken(p.id)) });
  }

  return json({ error: "not found" }, 404);
};

export const config: Config = { path: ["/api/admin/*"] };
