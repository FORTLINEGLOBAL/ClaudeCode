// Offline tests of the deterministic rules and the fast path. No model calls.
// Run: npm test
import assert from "node:assert/strict";
import fs from "node:fs";
import os from "node:os";
process.env.ANTHROPIC_API_KEY ||= "test-key";
process.chdir(fs.mkdtempSync(`${os.tmpdir()}/companion-test-`));   // local store goes to a temp dir
for (const k of ["COMPANION_MODEL", "COMPANION_EXTRACT_MODEL", "WHATSAPP_TOKEN", "WHATSAPP_PHONE_NUMBER_ID", "OPERATOR_WHATSAPP", "NETLIFY", "NETLIFY_SITE_ID", "NETLIFY_BLOBS_CONTEXT"]) delete process.env[k];

// Stand-in for the Anthropic API, installed before the SDK client is built. It records
// each request so the tests can check what we send, and answers like the real API.
const calls: any[] = [];
let failMain = false;   // makes the main model fail, to test the quick-model fallback
const realFetch = globalThis.fetch;
globalThis.fetch = (async (url: any, init?: any) => {
  if (!String(url).includes("api.anthropic.com")) return realFetch(url, init);
  const body = JSON.parse(init.body);
  calls.push({ url: String(url), headers: init.headers, body });
  if (failMain && body.model === "claude-opus-5-5") {
    return new Response(JSON.stringify({ type: "error", error: { type: "overloaded_error", message: "test" } }), { status: 529, headers: { "content-type": "application/json" } });
  }
  const text = body.output_config?.format
    ? JSON.stringify({ facts: [{ kind: "recent", text: "Baked a cake today", confidence: 0.9, sensitive: false, replaces: null }] })
    : "What kind of cake did you bake?";
  return new Response(JSON.stringify({
    id: "msg_test", type: "message", role: "assistant", model: body.model, stop_reason: "end_turn", stop_sequence: null,
    content: [{ type: "text", text }], usage: { input_tokens: 10, output_tokens: 5 },
  }), { status: 200, headers: { "content-type": "application/json" } });
}) as typeof fetch;

const { chooseLang, isSos, isStop, isStart, checkinDue, inQuietHours, sosReply, withinCoverage } = await import("../src/policy.js");
const { inWindow, localNow } = await import("../src/time.js");
const { mergeFacts, receive } = await import("../src/companion.js");
const { getAlerts, getChat, getParent, saveParent, issueToken, parentForToken } = await import("../src/store.js");
import type { Parent } from "../src/types.js";

const parent = (over: Partial<Parent> = {}): Parent => ({
  id: "p1", name: "רחל", gender: "f", lang: "auto", lastLang: "he", tz: "America/New_York",
  checkinTime: "10:00", quietStart: "21:00", quietEnd: "08:00", emergencyNumber: "911",
  contacts: [{ name: "Dana", relation: "daughter", phone: "+12125550100" }],
  consent: { checkins: true, memory: true, escalation: true }, stopped: false, createdAt: "2026-10-01T00:00:00Z", ...over,
});
let n = 0;
const t = (name: string, fn: () => void | Promise<void>) => Promise.resolve(fn()).then(() => { n++; }, (e) => { console.error(`FAIL ${name}`); throw e; });

// 1. language: explicit preference wins, otherwise by script, otherwise keep the last one
await t("language", () => {
  assert.equal(chooseLang("מה שלומך?", "auto", "en"), "he");
  assert.equal(chooseLang("How are you?", "auto", "he"), "en");
  assert.equal(chooseLang("I saw נועה today, היא גדלה", "auto", "en"), "he");
  assert.equal(chooseLang("👍", "auto", "en"), "en");
  assert.equal(chooseLang("How are you?", "he", "he"), "he");
});

// 2. SOS: high-precision phrases in both languages, code word, and no false alarms on everyday "help"
await t("sos", () => {
  for (const s of ["I fell in the kitchen", "I can't breathe", "chest pain", "call 911", "HELP!", "help me", "SOS",
    "נפלתי באמבטיה", "קשה לי לנשום", "יש לי כאבים בחזה", "תזמינו אמבולנס", "הצילו", "עזרה!", "תתקשרו למד\"א"]) assert.ok(isSos(s), s);
  for (const s of ["can you help me find a recipe?", "my friend helped me today", "אני צריכה עזרה עם הטלפון", "I fell asleep early", "I fell in love with this song", "the help desk was closed"]) assert.ok(!isSos(s), s);
  assert.ok(isSos("blue bird", "Blue Bird"));
});

// 3. STOP / START
await t("stop", () => {
  assert.ok(isStop("STOP")); assert.ok(isStop("עצור")); assert.ok(isStop("עצרי!"));
  assert.ok(!isStop("don't stop talking to me")); assert.ok(isStart("המשך")); assert.ok(isStart("start"));
});

// 4. time windows, including ones that cross midnight
await t("windows", () => {
  assert.ok(inWindow(23 * 60, "21:00", "08:00")); assert.ok(inWindow(7 * 60, "21:00", "08:00"));
  assert.ok(!inWindow(12 * 60, "21:00", "08:00")); assert.ok(inWindow(9 * 60, "08:00", "22:00"));
  assert.ok(!inWindow(22 * 60, "08:00", "22:00"));
  assert.equal(localNow("Asia/Jerusalem", new Date("2026-10-01T05:30:00Z")).hhmm, "08:30");   // IDT, UTC+3
  assert.equal(localNow("Asia/Jerusalem", new Date("2026-12-01T05:30:00Z")).hhmm, "07:30");   // IST, UTC+2
});

// 5. human coverage: 08:00-22:00 Israel time
await t("coverage", () => {
  assert.ok(withinCoverage(new Date("2026-10-01T05:00:00Z")));    // 08:00 IDT
  assert.ok(!withinCoverage(new Date("2026-10-01T04:59:00Z")));   // 07:59 IDT
  assert.ok(!withinCoverage(new Date("2026-10-01T19:00:00Z")));   // 22:00 IDT
  assert.ok(withinCoverage(new Date("2026-10-01T18:59:00Z")));
});

// 6. check-in: once a local day, after the chosen time, never in quiet hours, never after STOP or without consent
await t("checkin", () => {
  const at10 = new Date("2026-10-01T14:05:00Z");   // 10:05 New York (EDT)
  assert.ok(checkinDue(parent(), at10));
  assert.ok(!checkinDue(parent(), new Date("2026-10-01T13:55:00Z")));   // 09:55
  assert.ok(!checkinDue(parent({ lastCheckinDate: "2026-10-01" }), at10));
  assert.ok(!checkinDue(parent({ stopped: true }), at10));
  assert.ok(!checkinDue(parent({ consent: { checkins: false, memory: true, escalation: true } }), at10));
  assert.ok(inQuietHours(parent(), new Date("2026-10-02T02:00:00Z")));   // 22:00 New York
  assert.ok(!checkinDue(parent({ checkinTime: "07:00" }), new Date("2026-10-01T11:30:00Z")));   // 07:30, still quiet hours
});

// 7. SOS text: never claims emergency services were called; only claims a human when one was reached
await t("sos reply", () => {
  for (const lang of ["he", "en"] as const) for (const on of [true, false]) {
    const r = sosReply(parent(), lang, on);
    assert.match(r, /911/);
    assert.doesNotMatch(r, /called (911|emergency)|הזעקתי|התקשרתי ל/);
    if (!on) assert.match(r, lang === "en" ? /Please call Dana \(\+12125550100\)/ : /התקשרי ל-Dana/);
    else assert.match(r, lang === "en" ? /alerted our team/ : /הודעתי לצוות/);
  }
  assert.match(sosReply(parent({ gender: undefined }), "he", false), /התקשר\/התקשרי/);
});

// 8. memory: corrections supersede, duplicates are skipped
await t("memory", () => {
  const f1 = mergeFacts([], [{ kind: "family", text: "Granddaughter Noa is 7", confidence: 0.9, sensitive: false, replaces: null }], "en");
  assert.equal(f1.length, 1);
  const f2 = mergeFacts(f1, [{ kind: "family", text: "Granddaughter Noa is 8", confidence: 0.9, sensitive: false, replaces: f1[0].id }], "en");
  assert.equal(f2.length, 2); assert.equal(f2[0].supersededBy, f2[1].id);
  assert.equal(mergeFacts(f2, [{ kind: "family", text: "Granddaughter Noa is 8", confidence: 0.9, sensitive: false, replaces: null }], "en").length, 2);
});

// 9. fast path end to end on the local store: tokens, STOP, SOS with no operator configured
await t("fast path", async () => {
  const { webChannel } = await import("../src/channel.js");
  const p = parent(); await saveParent(p);
  const token = await issueToken(p.id);
  assert.equal((await parentForToken(token))?.id, p.id);
  assert.equal(await parentForToken("x".repeat(32)), null);

  assert.deepEqual(await receive(p, "עצרי", webChannel), { handled: true });
  assert.equal((await getParent(p.id))?.stopped, true);

  assert.deepEqual(await receive(p, "נפלתי", webChannel), { handled: true });
  const alerts = await getAlerts();
  assert.equal(alerts.length, 1); assert.equal(alerts[0].operatorNotified, false);
  const last = (await getChat(p.id)).at(-1)!;
  assert.equal(last.kind, "sos"); assert.match(last.text, /התקשרי ל-Dana/);   // nobody reached, so no promise of a human

  const r = await receive(p, "Hi, I baked a cake today", webChannel);
  assert.equal(r.handled, false);
  assert.equal((await getParent(p.id))?.lastLang, "en");
});

// 10. slow path with the API stand-in: reply delivered, memory saved, request shape as intended
await t("converse", async () => {
  const { webChannel } = await import("../src/channel.js");
  const { converse } = await import("../src/companion.js");
  const { getFacts } = await import("../src/store.js");
  const p = (await getParent("p1"))!;
  const lastParent = (await getChat(p.id)).filter((m) => m.role === "parent").at(-1)!;
  await converse(p, lastParent.id, webChannel);
  const last = (await getChat(p.id)).at(-1)!;
  assert.equal(last.role, "companion"); assert.equal(last.text, "What kind of cake did you bake?");
  assert.deepEqual((await getFacts(p.id)).map((f) => f.text), ["Baked a cake today"]);

  const [chat, extract] = calls;
  assert.equal(chat.body.model, "claude-opus-5-5");
  assert.equal(chat.body.fallbacks, "default");
  assert.match(String(chat.headers["anthropic-beta"] ?? new Headers(chat.headers).get("anthropic-beta")), /server-side-fallback-2026-07-01/);
  assert.equal(chat.body.messages[0].role, "user");   // history never starts with the companion
  assert.match(chat.body.system[1].text, /Reply in English/);
  assert.equal(extract.body.model, "claude-haiku-4-5");

  // A stale turn (the parent wrote again) makes no call and no reply.
  const before = calls.length;
  await converse(p, "not-the-latest", webChannel);
  assert.equal(calls.length, before);
});

// 11. check-in goes out in the parent's language and is recorded for the local day
await t("check-in", async () => {
  const { webChannel } = await import("../src/channel.js");
  const { checkIn } = await import("../src/companion.js");
  const p = (await getParent("p1"))!;
  p.lang = "he";
  await checkIn(p, webChannel);
  const last = (await getChat(p.id)).at(-1)!;
  assert.equal(last.kind, "checkin"); assert.equal(last.lang, "he");
  assert.equal((await getParent("p1"))?.lastCheckinDate, localNow(p.tz).date);
  assert.match(calls.at(-1).body.messages.at(-1).content, /daily check-in time/);
});


// 12. the main model fails: the quick model answers in one try, so the page still gets a reply
await t("quick fallback", async () => {
  const { webChannel } = await import("../src/channel.js");
  const { converse } = await import("../src/companion.js");
  const p = (await getParent("p1"))!;
  const r = await receive(p, "Tell me something nice", webChannel);
  assert.equal(r.handled, false);
  failMain = true;
  const before = calls.length;
  try { await converse(p, (r as { parentMsgId: string }).parentMsgId, webChannel, () => {}); }
  finally { failMain = false; }
  const made = calls.slice(before).map((c) => c.body.model);
  assert.deepEqual(made, ["claude-opus-5-5", "claude-haiku-4-5"]);   // no retries of the main model; memory deferred
  const last = (await getChat(p.id)).at(-1)!;
  assert.equal(last.role, "companion"); assert.equal(last.kind, "chat");
});

console.log(`${n} test groups passed`);
