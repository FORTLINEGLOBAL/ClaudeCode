// Talk to the companion from a terminal, with real Claude calls and a local store.
// Needs ANTHROPIC_API_KEY. Run: npm run chat:local -- [he|en]
import readline from "node:readline/promises";
import { stdin, stdout } from "node:process";
import { getChat, getParent, saveParent } from "../src/store.js";
import { converse, receive } from "../src/companion.js";
import { webChannel } from "../src/channel.js";
import type { Parent } from "../src/types.js";

const lang = process.argv[2] === "en" ? "en" : "he";
const id = "local-parent";
const p: Parent = (await getParent(id)) ?? {
  id, name: lang === "he" ? "רחל" : "Rachel", gender: "f", lang: "auto", lastLang: lang, tz: "America/New_York",
  checkinTime: "10:00", quietStart: "21:00", quietEnd: "08:00", emergencyNumber: "911",
  contacts: [{ name: "Dana", relation: "daughter", phone: "+12125550100" }],
  consent: { checkins: true, memory: true, escalation: true }, stopped: false, createdAt: new Date().toISOString(),
};
await saveParent(p);

const rl = readline.createInterface({ input: stdin, output: stdout });
console.log(`Chatting as ${p.name}. Empty line to quit. Data is in .local-store/.`);
for (;;) {
  const text = (await rl.question("> ")).trim();
  if (!text) break;
  const r = await receive(p, text, webChannel);
  if (!r.handled) await converse(p, r.parentMsgId, webChannel);
  console.log(`\n${(await getChat(p.id)).at(-1)?.text}\n`);
}
rl.close();
