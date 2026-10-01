// The family page. The link's token says which parent and which role (admin or viewer).
//   GET    /api/family                 settings, weekly activity, SOS times, family notes
//   PUT    /api/family/settings        admin: change settings and contacts (never consent)
//   POST   /api/family/notes           admin: tell the companion something ({text})
//   DELETE /api/family/notes/:id       admin: remove a note the family added
//   POST   /api/family/reminders       admin: a reminder sent word for word at a set time ({text, time, days})
//   DELETE /api/family/reminders/:id   admin: remove a reminder
//   POST   /api/family/parent-link     admin: a new private chat link for the parent
// The private conversation is never returned here.
import type { Config } from "@netlify/functions";
import { familyForToken, getAlerts, getChat, getFacts, getParent, getReminders, issueToken, newId, saveFacts, saveParent, saveReminders } from "../../src/store.js";
import { MAX_REMINDERS, familyReminders, newReminder } from "../../src/reminders.js";
import { familyAlerts, familyNotes, familyView, weeklyActivity } from "../../src/family.js";
import { applySettings } from "../../src/settings.js";
import type { Fact } from "../../src/types.js";

const json = (body: unknown, status = 200) => new Response(JSON.stringify(body), { status, headers: { "content-type": "application/json", "cache-control": "no-store" } });

export default async (req: Request) => {
  const access = await familyForToken(req.headers.get("x-family-token") || "");
  const p = access ? await getParent(access.parentId) : null;
  if (!access || !p) return json({ error: "This link is not valid. Ask for a new one.", errorHe: "הקישור הזה לא תקין. בקשו קישור חדש." }, 401);

  const route = new URL(req.url).pathname.replace(/^\/api\/family\/?/, "");
  const isAdmin = access.role === "admin";

  if (req.method === "GET" && route === "") {
    return json({
      role: access.role, label: access.label,
      parent: familyView(p),
      activity: weeklyActivity(p, await getChat(p.id)),
      alerts: familyAlerts(await getAlerts(), p.id),
      notes: familyNotes(await getFacts(p.id)),
      reminders: familyReminders(await getReminders(p.id), p, await getChat(p.id)),
    });
  }

  if (!isAdmin) return json({ error: "This link can view but not change anything.", errorHe: "הקישור הזה מאפשר לצפות בלבד, לא לשנות." }, 403);
  const body = req.method === "GET" || req.method === "DELETE" ? {} : await req.json().catch(() => ({}));

  if (req.method === "PUT" && route === "settings") {
    try { applySettings(p, body); } catch (e: any) { return json({ error: e?.message || String(e), errorHe: e?.he }, 400); }
    await saveParent(p);
    return json({ parent: familyView(p) });
  }

  if (req.method === "POST" && route === "notes") {
    const text = String(body.text ?? "").trim().slice(0, 500);
    if (!text) return json({ error: "Write something first.", errorHe: "צריך לכתוב משהו קודם." }, 400);
    const facts = await getFacts(p.id);
    const f: Fact = {
      id: newId(), kind: "recent", text, lang: /[֐-׿]/.test(text) ? "he" : "en",
      confidence: 1, sensitive: false, source: "family", at: new Date().toISOString(),
    };
    await saveFacts(p.id, [...facts, f]);
    return json({ notes: familyNotes([...facts, f]) }, 201);
  }

  const del = /^notes\/([\w-]+)$/.exec(route);
  if (req.method === "DELETE" && del) {
    const facts = await getFacts(p.id);
    const f = facts.find((x) => x.id === del[1] && x.source === "family" && !x.supersededBy);
    if (!f) return json({ error: "Note not found.", errorHe: "ההערה לא נמצאה." }, 404);
    f.supersededBy = "removed-by-family";   // kept for audit, no longer used
    await saveFacts(p.id, facts);
    return json({ notes: familyNotes(facts) });
  }

  if (req.method === "POST" && route === "reminders") {
    const list = await getReminders(p.id);
    if (list.length >= MAX_REMINDERS) return json({ error: `Up to ${MAX_REMINDERS} reminders.`, errorHe: `אפשר עד ${MAX_REMINDERS} תזכורות.` }, 400);
    try { list.push(newReminder(body, access.label)); } catch (e: any) { return json({ error: e?.message || String(e), errorHe: e?.he }, 400); }
    await saveReminders(p.id, list);
    return json({ reminders: familyReminders(list, p, await getChat(p.id)) }, 201);
  }

  const delRem = /^reminders\/([\w-]+)$/.exec(route);
  if (req.method === "DELETE" && delRem) {
    const list = await getReminders(p.id);
    const rest = list.filter((r) => r.id !== delRem[1]);
    if (rest.length === list.length) return json({ error: "Reminder not found.", errorHe: "התזכורת לא נמצאה." }, 404);
    await saveReminders(p.id, rest);
    return json({ reminders: familyReminders(rest, p, await getChat(p.id)) });
  }

  if (req.method === "POST" && route === "parent-link") {
    return json({ link: `${new URL(req.url).origin}/#t=${await issueToken(p.id)}` });
  }

  return json({ error: "not found" }, 404);
};

export const config: Config = { path: ["/api/family", "/api/family/*"] };
