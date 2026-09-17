// Local runner: `npm run scan:local`, `npm run followups:local`, `npm run cmd:local -- "show 1"`.
// Uses .local-state.json instead of Netlify Blobs and prints instead of sending WhatsApp.
import { loadState, saveState, enqueue } from "../src/store.js";
import { runScan } from "../src/scan.js";
import { prepareFollowUps } from "../src/followups.js";
import { handleCommand } from "../src/commands.js";
import { fmtContactFull } from "../src/digest.js";

const [mode, ...rest] = process.argv.slice(2);
const state = await loadState();
let out = "";
if (mode === "scan") out = (await runScan(state, { force: true })) || "nothing new";
else if (mode === "followups") out = (await prepareFollowUps(state)).map((c) => fmtContactFull(enqueue(state, "contact", c.id), c)).join("\n\n") || "no follow-ups due";
else if (mode === "cmd") out = await handleCommand(state, rest.join(" "));
else out = "usage: run-local.ts scan|followups|cmd <text>";
await saveState(state);
console.log(out);
