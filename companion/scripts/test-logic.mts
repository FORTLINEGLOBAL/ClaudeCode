// Offline tests of the deterministic rules and the fast path. No model calls.
// Run: npm test
import assert from "node:assert/strict";
import fs from "node:fs";
import os from "node:os";
process.env.ANTHROPIC_API_KEY ||= "test-key";
process.chdir(fs.mkdtempSync(`${os.tmpdir()}/companion-test-`));   // local store goes to a temp dir
for (const k of ["RESEND_API_KEY", "OPERATOR_EMAIL", "ALERT_FROM_EMAIL", "COVERAGE_START", "COVERAGE_END", "COVERAGE_TZ", "COMPANION_MODEL", "COMPANION_EXTRACT_MODEL", "WHATSAPP_TOKEN", "WHATSAPP_PHONE_NUMBER_ID", "WHATSAPP_APP_SECRET", "WHATSAPP_VERIFY_TOKEN", "WHATSAPP_TEMPLATES_APPROVED", "WHATSAPP_DISPLAY_NUMBER", "WHATSAPP_TEMPLATE", "OPERATOR_WHATSAPP", "NETLIFY", "NETLIFY_SITE_ID", "NETLIFY_BLOBS_CONTEXT"]) delete process.env[k];

// Stand-in for the Anthropic API, installed before the SDK client is built. It records
// each request so the tests can check what we send, and answers like the real API.
const calls: any[] = [];
const resendCalls: any[] = [];
const waCalls: any[] = [];
let failMain = false;   // makes the main model fail, to test the quick-model fallback
const realFetch = globalThis.fetch;
globalThis.fetch = (async (url: any, init?: any) => {
  if (String(url).includes("api.resend.com")) {
    resendCalls.push({ headers: init.headers, body: JSON.parse(init.body) });
    return new Response(JSON.stringify({ id: "email_test" }), { status: 200, headers: { "content-type": "application/json" } });
  }
  if (String(url).includes("graph.facebook.com")) {
    waCalls.push(JSON.parse(init.body));
    return new Response(JSON.stringify({ messages: [{ id: "wamid.out" }] }), { status: 200, headers: { "content-type": "application/json" } });
  }
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

// 13. SOS inside coverage with email configured: the operator gets an email and only then is the parent told
await t("sos email", async () => {
  const { webChannel } = await import("../src/channel.js");
  Object.assign(process.env, { RESEND_API_KEY: "re_test", OPERATOR_EMAIL: "ops@example.com", COVERAGE_START: "00:00", COVERAGE_END: "23:59" });
  try {
    const p = (await getParent("p1"))!;
    const r = await receive(p, "נפלתי", webChannel);
    assert.equal(r.handled, true);
    assert.equal(resendCalls.length, 1);
    assert.deepEqual(resendCalls[0].body.to, ["ops@example.com"]);
    assert.match(resendCalls[0].body.subject, /^SOS: SOS from רחל/);
    assert.match(resendCalls[0].body.text, /Dana \(daughter\) \+12125550100/);
    assert.equal((await getAlerts()).at(-1)!.operatorNotified, true);
    assert.match((await getChat(p.id)).at(-1)!.text, /הודעתי לצוות שלנו/);
  } finally {
    for (const k of ["RESEND_API_KEY", "OPERATOR_EMAIL", "COVERAGE_START", "COVERAGE_END"]) delete process.env[k];
  }
});

// 14. family page: weekly activity counts days and check-ins, never content
await t("family activity", async () => {
  const { weeklyActivity, familyView, familyAlerts } = await import("../src/family.js");
  const p = parent({ tz: "America/New_York", codeWord: "banana" });
  const m = (role: "parent" | "companion", at: string, kind = "chat") => ({ id: at + role, role, text: "secret words", at, kind }) as any;
  const now = new Date("2026-10-07T18:00:00Z");   // Wed 7 Oct, 14:00 in New York
  const log = [
    m("companion", "2026-10-05T14:00:00Z", "checkin"), m("parent", "2026-10-05T15:00:00Z"),          // Mon: answered
    m("companion", "2026-10-06T14:00:00Z", "checkin"),                                                // Tue
    m("parent", "2026-10-07T03:30:00Z"),   // 23:30 Tuesday in New York: answers Tuesday's check-in
    m("companion", "2026-10-07T14:00:00Z", "checkin"),                                                // Wed: waiting
  ];
  const a = weeklyActivity(p, log, now);
  assert.equal(a.days.length, 7);
  assert.equal(a.days.at(-1)!.date, "2026-10-07");
  const by = Object.fromEntries(a.days.map((d) => [d.date, d]));
  assert.deepEqual([by["2026-10-05"].checkin, by["2026-10-05"].messages], ["answered", 1]);
  assert.equal(by["2026-10-06"].checkin, "answered");   // the 23:30 local message counts for Tuesday
  assert.equal(by["2026-10-06"].messages, 1);
  assert.equal(by["2026-10-07"].checkin, "waiting");
  assert.equal(a.missedCheckins, 0);
  const a2 = weeklyActivity(p, log.filter((x) => x.at !== "2026-10-07T03:30:00Z"), now);
  assert.equal(a2.days.find((d) => d.date === "2026-10-06")!.checkin, "missed");
  assert.equal(a2.missedCheckins, 1);
  assert.equal(a2.lastActiveAt, "2026-10-05T15:00:00Z");
  assert.ok(!JSON.stringify(a).includes("secret"));

  const v = familyView(p);
  assert.equal((v as any).codeWord, undefined); assert.equal(v.codeWordSet, true);
  const al = familyAlerts([{ id: "a", parentId: p.id, kind: "sos", text: "נפלתי במטבח", at: "2026-10-06T10:00:00Z", withinCoverage: true, operatorNotified: true }], p.id);
  assert.deepEqual(al, [{ at: "2026-10-06T10:00:00Z", withinCoverage: true, operatorNotified: true }]);
});

// 15. family API: viewer can only look; admin edits settings (not consent), adds and removes notes
await t("family api", async () => {
  const { default: family } = await import("../netlify/functions/family.js");
  const { issueFamilyToken, getFacts } = await import("../src/store.js");
  const p = parent({ id: "fam1" });
  await saveParent(p);
  const admin = await issueFamilyToken(p.id, "admin", "Dana");
  const viewer = await issueFamilyToken(p.id, "viewer", "Yossi");
  const call = (tok: string, method: string, path = "", body?: unknown) =>
    family(new Request(`https://x.test/api/family${path}`, { method, headers: { "x-family-token": tok, "content-type": "application/json" }, body: body ? JSON.stringify(body) : undefined }), {} as any);

  assert.equal((await call("nope-nope-nope-nope-nope", "GET")).status, 401);
  const g = await (await call(viewer, "GET")).json();
  assert.equal(g.role, "viewer"); assert.equal(g.parent.name, "רחל"); assert.equal(g.activity.days.length, 7);
  assert.equal((await call(viewer, "PUT", "/settings", { name: "X" })).status, 403);

  const bad = await call(admin, "PUT", "/settings", { emergencyNumber: "call me" });
  assert.equal(bad.status, 400);
  const ok = await (await call(admin, "PUT", "/settings", { checkinTime: "09:30", consent: { memory: false }, contacts: [{ name: "Dana", relation: "daughter", phone: "+1 (212) 555-0100" }] })).json();
  assert.equal(ok.parent.checkinTime, "09:30");
  assert.equal(ok.parent.consent.memory, true);            // consent is the parent's, not the family's
  assert.equal(ok.parent.contacts[0].phone, "+12125550100");

  const added = await (await call(admin, "POST", "/notes", { text: "נועה מגיעה ביום ראשון" })).json();
  assert.equal(added.notes.length, 1);
  const f = (await getFacts(p.id)).find((x) => x.source === "family")!;
  assert.equal(f.lang, "he");
  const removed = await (await call(admin, "DELETE", "/notes/" + f.id)).json();
  assert.equal(removed.notes.length, 0);
  assert.equal((await getFacts(p.id)).find((x) => x.id === f.id)!.supersededBy, "removed-by-family");

  const link = await (await call(admin, "POST", "/parent-link")).json();
  assert.match(link.link, /^https:\/\/x\.test\/#t=/);
});

// 16. a new family note is passed on in the next reply, once, then stays as memory
await t("family note passed on", async () => {
  const { default: family } = await import("../netlify/functions/family.js");
  const { issueFamilyToken, getFacts } = await import("../src/store.js");
  const { converse } = await import("../src/companion.js");
  const { webChannel } = await import("../src/channel.js");
  const p = parent({ id: "fam2", name: "אנה" });
  await saveParent(p);
  const admin = await issueFamilyToken(p.id, "admin", "Dana");
  await family(new Request("https://x.test/api/family/notes", { method: "POST", headers: { "x-family-token": admin, "content-type": "application/json" }, body: JSON.stringify({ text: "לא לשכוח לקחת תרופות" }) }), {} as any);
  const sys = (c: any) => JSON.stringify(c.body.system);
  const say = async (text: string) => {
    const r = await receive(p, text, webChannel);
    assert.equal(r.handled, false);
    const before = calls.length;
    await converse(p, (r as any).parentMsgId, webChannel);
    return calls.slice(before).find((c) => !c.body.output_config?.format)!;
  };
  const first = await say("מה נשמע?");
  assert.ok(sys(first).includes("New from the family") && sys(first).includes("לא לשכוח לקחת תרופות"));
  const note = (await getFacts(p.id)).find((f) => f.source === "family")!;
  assert.ok(note.passedOn);
  const second = await say("ומה עוד?");
  assert.ok(!sys(second).includes("New from the family"));
  assert.ok(sys(second).includes("לא לשכוח לקחת תרופות"));   // still remembered, just not news
});

// 17. reminders: due at the parent's local time on the chosen days, sent once, word for word
await t("reminders", async () => {
  const { reminderDue, sendDueReminders, newReminder, familyReminders } = await import("../src/reminders.js");
  const { saveReminders, getReminders } = await import("../src/store.js");
  const { webChannel } = await import("../src/channel.js");
  const p = parent({ id: "rem1", tz: "Asia/Jerusalem", lang: "he" });
  await saveParent(p);
  assert.throws(() => newReminder({ text: "x", time: "25:00" }, "family"));
  assert.throws(() => newReminder({ text: " ", time: "20:00" }, "family"));
  const daily = newReminder({ text: "לקחת את הכדור של הערב", time: "20:00", by: "פורטי" }, "family");
  const sunday = newReminder({ text: "חוג ציור", time: "9:30", days: [0] }, "family");
  assert.equal(sunday.time, "09:30"); assert.equal(sunday.by, "family");
  assert.deepEqual(newReminder({ text: "x", time: "08:00", days: [0, 1, 2, 3, 4, 5, 6] }, "f").days, []);
  // 2026-10-04 is a Sunday; Israel is UTC+3 then
  const at = (iso: string) => new Date(iso);
  assert.ok(!reminderDue(daily, p, at("2026-10-04T16:59:00Z")));   // 19:59
  assert.ok(reminderDue(daily, p, at("2026-10-04T17:10:00Z")));    // 20:10
  assert.ok(!reminderDue(daily, p, at("2026-10-04T18:00:00Z")));   // 21:00, too late
  assert.ok(reminderDue(sunday, p, at("2026-10-04T06:40:00Z")));   // Sunday 09:40
  assert.ok(!reminderDue(sunday, p, at("2026-10-05T06:40:00Z")));  // Monday
  await saveReminders(p.id, [daily, sunday]);
  assert.equal(await sendDueReminders(p, webChannel, at("2026-10-04T17:05:00Z")), 1);
  assert.equal(await sendDueReminders(p, webChannel, at("2026-10-04T17:20:00Z")), 0);   // once a day
  const sent = (await getChat(p.id)).filter((m) => m.kind === "reminder");
  assert.equal(sent.length, 1);
  assert.equal(sent[0].text, "⏰ תזכורת מפורטי, לשעה 20:00\nלקחת את הכדור של הערב");
  let view = familyReminders(await getReminders(p.id), p, await getChat(p.id), at("2026-10-04T17:30:00Z"));
  assert.equal(view[0].answeredAfter, false); assert.ok(view[0].sentToday); assert.equal(view[1].sentToday, null);
  const { appendChat } = await import("../src/store.js");
  await appendChat(p.id, { id: "pm1", role: "parent", text: "לקחתי", at: "2026-10-04T17:12:00Z", kind: "chat" });
  view = familyReminders(await getReminders(p.id), p, await getChat(p.id), at("2026-10-04T17:30:00Z"));
  assert.equal(view[0].answeredAfter, true);
  await saveParent({ ...p, stopped: true });
  assert.equal(await sendDueReminders({ ...p, stopped: true }, webChannel, at("2026-10-05T17:05:00Z")), 0);   // STOP pauses reminders

  const { default: family } = await import("../netlify/functions/family.js");
  const { issueFamilyToken } = await import("../src/store.js");
  const admin = await issueFamilyToken(p.id, "admin", "family");
  const viewer = await issueFamilyToken(p.id, "viewer", "family");
  const call = (tok: string, method: string, path: string, body?: unknown) =>
    family(new Request(`https://x.test/api/family${path}`, { method, headers: { "x-family-token": tok, "content-type": "application/json" }, body: body ? JSON.stringify(body) : undefined }), {} as any);
  assert.equal((await call(viewer, "POST", "/reminders", { text: "x", time: "10:00" })).status, 403);
  const bad = await (await call(admin, "POST", "/reminders", { text: "x", time: "99:00" })).json();
  assert.match(bad.errorHe, /השעה/);
  const added = await (await call(admin, "POST", "/reminders", { text: "לשתות מים", time: "12:00" })).json();
  assert.equal(added.reminders.length, 3);
  const id = added.reminders[2].id;
  assert.equal((await (await call(admin, "DELETE", "/reminders/" + id)).json()).reminders.length, 2);
  assert.equal((await (await call(viewer, "GET", "")).json()).reminders.length, 2);
});

// 18. weekly email: Sunday 09:00 local, counts only, settings validation, test send
await t("weekly email", async () => {
  const { digestDue, digestWeek, digestEmail, sendDigestIfDue } = await import("../src/digest.js");
  const { applySettings } = await import("../src/settings.js");
  const { appendChat } = await import("../src/store.js");
  const p = parent({ id: "dig1", name: "אנה", tz: "Asia/Jerusalem" });
  assert.throws(() => applySettings(p, { digestEmails: "not-an-email" }));
  assert.throws(() => applySettings(p, { digestEmails: "a@x.co,b@x.co,c@x.co,d@x.co,e@x.co,f@x.co" }));
  applySettings(p, { digestEmails: "Dana@Example.com; forti@example.com", digestLang: "he" });
  assert.deepEqual(p.digest!.emails, ["dana@example.com", "forti@example.com"]);
  await saveParent(p);
  // 2026-10-04 is a Sunday; Israel is UTC+3
  assert.ok(!digestDue(p, new Date("2026-10-04T05:59:00Z")));   // 08:59
  assert.ok(digestDue(p, new Date("2026-10-04T06:05:00Z")));    // 09:05
  assert.ok(!digestDue(p, new Date("2026-10-05T06:05:00Z")));   // Monday
  await appendChat(p.id,
    { id: "d1", role: "companion", text: "בוקר טוב", at: "2026-09-29T07:00:00Z", kind: "checkin" },
    { id: "d2", role: "parent", text: "סוד גדול", at: "2026-09-29T08:00:00Z", kind: "chat" },
    { id: "d3", role: "companion", text: "בוקר טוב", at: "2026-09-30T07:00:00Z", kind: "checkin" },
    { id: "d4", role: "companion", text: "בוקר טוב", at: "2026-10-01T07:00:00Z", kind: "checkin" },
    { id: "d5", role: "parent", text: "היום בשוק", at: "2026-10-04T06:00:00Z", kind: "chat" },   // Sunday itself: next week
  );
  const week = digestWeek(p, await getChat(p.id), new Date("2026-10-04T06:05:00Z"));
  assert.equal(week.days[0].date, "2026-09-27"); assert.equal(week.days.at(-1)!.date, "2026-10-03");
  assert.equal(week.missedCheckins, 2);
  const mail = digestEmail(p, week, "he");
  assert.match(mail.text, /ימים עם שיחה: 1 מתוך 7/);
  assert.match(mail.text, /צ'ק-אינים: 1 נענו מתוך 3/);
  assert.match(mail.text, /להתקשר/);
  assert.ok(!mail.text.includes("סוד") && !mail.html.includes("סוד"));
  assert.match(mail.html, /dir="rtl"/);

  process.env.RESEND_API_KEY = "re_test";
  resendCalls.length = 0;
  assert.equal(await sendDigestIfDue(p, new Date("2026-10-04T06:05:00Z")), true);
  assert.equal(await sendDigestIfDue(p, new Date("2026-10-04T06:20:00Z")), false);   // once
  assert.equal(resendCalls.length, 1);
  assert.deepEqual(resendCalls[0].body.to, ["dana@example.com", "forti@example.com"]);
  assert.equal(resendCalls[0].body.subject, "אנה: השבוע בקצרה");

  const { default: family } = await import("../netlify/functions/family.js");
  const { issueFamilyToken } = await import("../src/store.js");
  const admin = await issueFamilyToken(p.id, "admin", "family");
  const res = await family(new Request("https://x.test/api/family/digest-test", { method: "POST", headers: { "x-family-token": admin } }), {} as any);
  assert.equal(res.status, 200);
  assert.equal(resendCalls.length, 2);
  delete process.env.RESEND_API_KEY;
});

// 19. scam shield: precise detection, fixed warning, family told only when the parent says yes
await t("scam shield", async () => {
  const { scamCheck } = await import("../src/scam.js");
  const { webChannel } = await import("../src/channel.js");
  for (const s of ["קיבלתי הודעה מהבנק: החשבון שלך ייחסם, שלחי את קוד האימות שקיבלת", "סבתא, זה אני הנכד. אני צריך שתעבירי לי כסף דחוף, אל תגידי לאבא",
    "התקשרו מהבנק וביקשו שאתקין AnyDesk", "Hi grandma it's me, send money with gift cards and don't tell mom", "Your package is on hold, pay the fee at http://usps-track.info within 24 hours",
    "זכית בפרס! היכנסי ל www.prize-il.top כדי לקבל"]) assert.ok(scamCheck(s).suspect, s);
  for (const s of ["שילמתי לגנן היום", "הנכד שלי בא לבקר", "הלכתי לבנק להפקיד צ'ק", "I paid the electric bill today", "שכחתי את הסיסמה של הטלפון",
    "היום יש לי תור דחוף לרופא", "I won at bridge today!", "צריך לשלם לבנק את המשכנתא", "נועה שלחה לי קישור לתמונות www.photos.com"]) assert.ok(!scamCheck(s).suspect, s);

  const p = parent({ id: "scam1", name: "אנה", gender: "f" });
  p.digest = { emails: ["dana@example.com"], lang: "he" };
  await saveParent(p);
  process.env.RESEND_API_KEY = "re_test"; resendCalls.length = 0;
  const before = calls.length;
  assert.deepEqual(await receive(p, "הודעה מהבנק: החשבון שלך ייחסם, שלחי את קוד האימות שקיבלת", webChannel), { handled: true });
  assert.equal(calls.length, before);   // no model involved
  let log = await getChat(p.id);
  const warn = log.at(-1)!;
  assert.equal(warn.kind, "scam");
  assert.match(warn.text, /עצרי/); assert.match(warn.text, /קוד או לסיסמה/); assert.match(warn.text, /"כן" או "לא"/);
  assert.ok(p.scamOffer);
  assert.deepEqual(await receive(p, "כן", webChannel), { handled: true });
  assert.equal(resendCalls.length, 1);
  assert.deepEqual(resendCalls[0].body.to, ["dana@example.com"]);
  assert.ok(!resendCalls[0].body.text.includes("קוד האימות שקיבלת"));   // the message itself stays private
  assert.match((await getChat(p.id)).at(-1)!.text, /כתבתי למשפחה/);
  assert.equal(p.scamOffer, undefined);
  const r = await receive(p, "כן", webChannel);   // no open offer: an ordinary message
  assert.equal(r.handled, false);
  // no family email on file: the warning points to the primary contact instead of offering
  const q = parent({ id: "scam2" });
  await saveParent(q);
  await receive(q, "Microsoft support says install AnyDesk now", webChannel);
  assert.match((await getChat(q.id)).at(-1)!.text, /Dana \(\+12125550100\)|דנה|Dana/);
  assert.equal(q.scamOffer, undefined);
  // SOS still wins
  await receive(q, "נפלתי, הבנק ביקש קוד", webChannel);
  assert.equal((await getChat(q.id)).at(-1)!.kind, "sos");
  // the family page lists SOS only
  const { familyAlerts } = await import("../src/family.js");
  assert.ok(familyAlerts(await getAlerts(), q.id).length === 1);
  delete process.env.RESEND_API_KEY;
});

// 20. WhatsApp: verified webhook, known numbers only, replies in the window, templates outside it
await t("whatsapp", async () => {
  const crypto = await import("node:crypto");
  Object.assign(process.env, { WHATSAPP_TOKEN: "t", WHATSAPP_PHONE_NUMBER_ID: "123", WHATSAPP_APP_SECRET: "s3cret", WHATSAPP_VERIFY_TOKEN: "verify-me" });
  const { default: wa } = await import("../netlify/functions/whatsapp.js");
  const { channelFor, whatsappChannel } = await import("../src/channel.js");
  const { checkIn } = await import("../src/companion.js");
  const { applySettings } = await import("../src/settings.js");
  const ctx = { waitUntil: () => {} } as any;

  const ok = await wa(new Request("https://x.test/api/whatsapp?hub.mode=subscribe&hub.verify_token=verify-me&hub.challenge=42"), ctx);
  assert.equal(await ok.text(), "42");
  assert.equal((await wa(new Request("https://x.test/api/whatsapp?hub.mode=subscribe&hub.verify_token=nope&hub.challenge=42"), ctx)).status, 403);

  const p = parent({ id: "wa1", name: "אנה", gender: "f" });
  assert.throws(() => applySettings(p, { whatsapp: "123" }));
  applySettings(p, { whatsapp: "+972 (50) 111-2233" });
  assert.equal(p.whatsapp, "+972501112233");
  await saveParent(p);
  assert.equal(channelFor(p).name, "whatsapp");

  const post = (msgs: any[], secret = "s3cret") => {
    const raw = JSON.stringify({ object: "whatsapp_business_account", entry: [{ changes: [{ field: "messages", value: { messages: msgs } }] }] });
    const sig = "sha256=" + crypto.createHmac("sha256", secret).update(raw).digest("hex");
    return wa(new Request("https://x.test/api/whatsapp", { method: "POST", headers: { "x-hub-signature-256": sig, "content-type": "application/json" }, body: raw }), ctx);
  };
  const text = (id: string, from: string, body: string) => ({ id, from, type: "text", text: { body } });

  assert.equal((await post([text("w0", "972501112233", "hi")], "wrong")).status, 401);
  waCalls.length = 0;
  await post([text("w1", "972509999999", "who is this")]);   // unknown number
  assert.equal(waCalls.length, 0);

  await post([text("w2", "972501112233", "מה נשמע?")]);
  assert.equal(waCalls.length, 1);
  assert.equal(waCalls[0].to, "972501112233"); assert.equal(waCalls[0].type, "text");
  assert.equal(waCalls[0].text.body, "What kind of cake did you bake?");
  const after = (await getParent(p.id))!;
  assert.ok(after.lastInboundAt);
  assert.equal((await getChat(p.id)).filter((m) => m.role === "parent").length, 1);
  await post([text("w2", "972501112233", "מה נשמע?")]);   // Meta retry: ignored
  assert.equal(waCalls.length, 1);

  await post([{ id: "w3", from: "972501112233", type: "audio", audio: { id: "a" } }]);
  assert.match(waCalls[1].text.body, /רק הודעות כתובות/);

  await post([text("w4", "972501112233", "נפלתי")]);   // SOS still deterministic
  assert.match(waCalls[2].text.body, /101|911/);

  // outside the 24h window: no template approved = nothing sent; approved = the template
  const old = { ...(await getParent(p.id))!, lastInboundAt: "2026-01-01T00:00:00Z", lastCheckinDate: undefined };
  waCalls.length = 0;
  await checkIn(old, whatsappChannel);
  assert.equal(waCalls.length, 0);
  process.env.WHATSAPP_TEMPLATES_APPROVED = "1";
  await checkIn(old, whatsappChannel);
  assert.equal(waCalls.length, 1);
  assert.equal(waCalls[0].type, "template");
  assert.equal(waCalls[0].template.name, "companion_checkin"); assert.equal(waCalls[0].template.language.code, "he");
  assert.deepEqual(waCalls[0].template.components[0].parameters, [{ type: "text", text: "אנה" }]);
  assert.equal((await getChat(p.id)).at(-1)!.text, "בוקר טוב אנה! מה נשמע היום? אפשר לענות כאן בהודעה.");

  for (const k of ["WHATSAPP_TOKEN", "WHATSAPP_PHONE_NUMBER_ID", "WHATSAPP_APP_SECRET", "WHATSAPP_VERIFY_TOKEN", "WHATSAPP_TEMPLATES_APPROVED"]) delete process.env[k];
  assert.equal(channelFor(p).name, "web");   // not configured: stays on the web chat
});

console.log(`${n} test groups passed`);
