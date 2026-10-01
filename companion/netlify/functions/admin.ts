// Operator endpoints, protected by COMPANION_ADMIN_KEY.
//   POST /api/admin/parents   create a parent, returns their private chat link
//   POST /api/admin/link      issue a new link for an existing parent
//   POST /api/admin/family-link  issue a family page link ({id, role, label})
//   GET  /api/admin/parents   parents (id and name only)
//   GET  /api/admin/alerts    SOS alerts, newest first
//   GET  /api/admin/diag      tries each model once and reports any error
// The operator never sees the parent's private conversation here.
import type { Config } from "@netlify/functions";
import crypto from "node:crypto";
import { getAlerts, getParent, listParents, issueFamilyToken, issueToken, newId, saveParent } from "../../src/store.js";
import { applySettings } from "../../src/settings.js";
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

  if (req.method === "GET" && route === "parents") {
    return json((await listParents()).map(({ id, name, tz, createdAt }) => ({ id, name, tz, createdAt })).sort((a, b) => a.createdAt.localeCompare(b.createdAt)));
  }

  if (req.method === "GET" && route === "diag") {
    return json({ apiKeySet: !!process.env.ANTHROPIC_API_KEY, models: await diagnose() });
  }

  if (req.method === "POST" && route === "parents") {
    const b = await req.json().catch(() => ({}));
    if (!b.name) return json({ error: "name is required" }, 400);
    const p: Parent = {
      id: newId(), name: "", lang: "auto", lastLang: b.lang === "en" ? "en" : "he",
      tz: "America/New_York", checkinTime: "10:00", quietStart: "21:00", quietEnd: "08:00", emergencyNumber: "911",
      contacts: [],
      consent: { checkins: b.consent?.checkins ?? true, memory: b.consent?.memory ?? true, escalation: b.consent?.escalation ?? true },
      stopped: false,
      createdAt: new Date().toISOString(),
    };
    try {
      applySettings(p, b);
    } catch (e: any) {
      return json({ error: e?.message || String(e) }, 400);
    }
    await saveParent(p);
    const familyLink = `${new URL(req.url).origin}/family.html#t=${await issueFamilyToken(p.id, "admin", p.contacts[0]?.name || "family")}`;
    return json({ id: p.id, link: linkFor(req, await issueToken(p.id)), familyLink }, 201);
  }

  if (req.method === "POST" && route === "link") {
    const b = await req.json().catch(() => ({}));
    const p = b.id ? await getParent(String(b.id)) : null;
    if (!p) return json({ error: "unknown parent id" }, 404);
    return json({ id: p.id, link: linkFor(req, await issueToken(p.id)) });
  }

  if (req.method === "POST" && route === "family-link") {
    const b = await req.json().catch(() => ({}));
    const p = b.id ? await getParent(String(b.id)) : null;
    if (!p) return json({ error: "unknown parent id" }, 404);
    const role = b.role === "viewer" ? "viewer" : "admin";
    const token = await issueFamilyToken(p.id, role, String(b.label || "family").slice(0, 60));
    return json({ id: p.id, role, familyLink: `${new URL(req.url).origin}/family.html#t=${token}` });
  }

  return json({ error: "not found" }, 404);
};

export const config: Config = { path: ["/api/admin/*"] };
