// Offline tests of the non-network logic. Run: npm test
import assert from "node:assert/strict";
process.env.ANTHROPIC_API_KEY ||= "test-key";
const { handleCommand } = await import("../src/commands.js");
const { chunk, parseInbound, verifySignature } = await import("../src/whatsapp.js");
const { enqueue, byNumber, canDraftMore, countDraft, DEFAULT_SETTINGS, today } = await import("../src/store.js");
const { markSent, prepareFollowUps } = await import("../src/followups.js");
const { buildDigest, pendingDigest } = await import("../src/digest.js");
import type { State, Contact, Job } from "../src/store.js";

function fresh(): State {
  return { jobs: {}, contacts: {}, companies: {}, queue: [], nextQueueNumber: 1, draftsToday: { date: today(), count: 0 }, settings: { ...DEFAULT_SETTINGS, blockedCompanies: [] } };
}
const now = new Date().toISOString();
const contact = (id: string, company = "Together AI"): Contact => ({ id, name: "James Barker", title: "EMEA VP", company, linkedinUrl: "https://linkedin.com/in/x", hunter: "emerging", angle: "join EMEA team", draft: "Hi James, draft text.", status: "drafted", touches: [], createdAt: now, updatedAt: now });
const job = (id: string): Job => ({ id, title: "VP Sales", company: "Acme", location: "Tel Aviv", url: "https://x/j", source: "ashby", score: 88, reason: "fit", firstSeen: now, status: "new" });

// 1. digest numbering is stable and idempotent
{
  const s = fresh(); s.contacts.c1 = contact("c1"); s.jobs.j1 = job("j1");
  const d = buildDigest(s, [s.jobs.j1], [s.contacts.c1], "hdr");
  assert.match(d, /#1 JOB VP Sales/); assert.match(d, /#2 First touch: James Barker/); assert.match(d, /Reply: sent 2/);
  assert.equal(enqueue(s, "contact", "c1"), 2); assert.equal(s.jobs.j1.status, "shown");
}
// 2. sent -> follow-up scheduled 7 days out; skip; status; show
{
  const s = fresh(); s.contacts.c1 = contact("c1"); enqueue(s, "contact", "c1");
  const r = await handleCommand(s, "sent 1");
  assert.match(r, /follow-up on \d{4}-\d{2}-\d{2}/); assert.equal(s.contacts.c1.status, "sent"); assert.equal(s.contacts.c1.touches.length, 1);
  const days = (Date.parse(s.contacts.c1.nextFollowUpAt!) - Date.now()) / 86400000; assert.ok(days > 6.9 && days < 7.1);
  assert.match(await handleCommand(s, "status"), /1 sent/);
  s.contacts.c2 = contact("c2", "Baseten"); enqueue(s, "contact", "c2");
  assert.match(await handleCommand(s, "skip baseten"), /Skipped 1/); assert.equal(s.contacts.c2.status, "skipped");
  assert.match(await handleCommand(s, "show 1"), /Hi James, draft text/);
  assert.match(await handleCommand(s, "block company Baseten"), /Blocked/); assert.deepEqual(s.settings.blockedCompanies, ["Baseten"]);
  assert.match(await handleCommand(s, "pause"), /Paused/); assert.equal(s.settings.paused, true);
  assert.match(await handleCommand(s, "set cap 5"), /5/); assert.equal(s.settings.dailyDraftCap, 5);
  assert.match(await handleCommand(s, "help"), /Commands/);
}
// 3. follow-up lifecycle: after max touches, auto-close (no LLM needed when nothing is due)
{
  const s = fresh(); s.contacts.c1 = contact("c1");
  markSent(s, s.contacts.c1); markSent(s, s.contacts.c1); markSent(s, s.contacts.c1);
  s.contacts.c1.nextFollowUpAt = new Date(Date.now() - 1000).toISOString();
  const due = await prepareFollowUps(s);
  assert.equal(due.length, 0); assert.equal(s.contacts.c1.status, "closed");
}
// 4. daily cap
{
  const s = fresh(); s.settings.dailyDraftCap = 2;
  assert.ok(canDraftMore(s)); countDraft(s); countDraft(s); assert.ok(!canDraftMore(s));
}
// 5. WhatsApp helpers
{
  const long = Array.from({ length: 30 }, (_, i) => `paragraph ${i} ` + "x".repeat(200)).join("\n\n");
  const parts = chunk(long); assert.ok(parts.length > 1); assert.ok(parts.every((p) => p.length <= 3900));
  const inb = parseInbound({ entry: [{ changes: [{ value: { messages: [{ from: "972543203976", id: "m1", type: "text", text: { body: " sent 3 " } }] } }] }] });
  assert.deepEqual(inb, { from: "972543203976", text: "sent 3", id: "m1" });
  assert.equal(parseInbound({ entry: [{ changes: [{ value: { statuses: [{}] } }] }] }), null);
  process.env.WHATSAPP_APP_SECRET = "s3cret";
  const crypto = await import("node:crypto");
  const sig = "sha256=" + crypto.createHmac("sha256", "s3cret").update("body").digest("hex");
  assert.ok(verifySignature("body", sig)); assert.ok(!verifySignature("body", "sha256=00"));
}
// 6. pending digest lists drafts and jobs
{
  const s = fresh(); s.contacts.c1 = contact("c1"); s.jobs.j1 = job("j1");
  const p = pendingDigest(s); assert.match(p, /OPEN JOBS/); assert.match(p, /DRAFTS WAITING/); assert.ok(byNumber(s, 1));
}
// 7. ATS cache policy: fresh hit reused, fresh miss suppressed, stale entries re-looked-up
{
  const { cachedAts } = await import("../src/sources/ats.js");
  const iso = (daysAgo: number) => new Date(Date.now() - daysAgo * 86400000).toISOString();
  const cache: Record<string, any> = {
    "fresh hit": { kind: "ashby", slug: "fresh-hit", checkedAt: iso(3) },
    "stale hit": { kind: "ashby", slug: "stale-hit", checkedAt: iso(45) },
    "fresh miss": { kind: null, slug: "", checkedAt: iso(2) },
    "stale miss": { kind: null, slug: "", checkedAt: iso(20) },
  };
  assert.deepEqual(cachedAts(cache, "Fresh Hit"), { kind: "ashby", slug: "fresh-hit" }); // case-insensitive
  assert.equal(cachedAts(cache, "fresh miss"), null);        // known-missing, do not re-probe
  assert.equal(cachedAts(cache, "stale hit"), undefined);    // expired, look up again
  assert.equal(cachedAts(cache, "stale miss"), undefined);   // retry weekly
  assert.equal(cachedAts(cache, "never seen"), undefined);
}
console.log("all logic tests passed");
