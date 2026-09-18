// Offline check of the forced-scan report. No network here, so every source fails:
// this is exactly the "nothing new" case, and it must now explain itself.
import { runScan } from "../src/scan.js";
import type { State } from "../src/store.js";

const state: State = {
  jobs: {}, contacts: {}, companies: {}, queue: [], nextQueueNumber: 1, atsCache: {},
  draftsToday: { date: "2026-09-18", count: 0 },
  settings: { dailyDraftCap: 10, followUpDays: 7, maxTouches: 3, paused: false, blockedCompanies: [] },
};
console.log(await runScan(state, { force: true }));
console.log("\n--- stored report ---");
console.log(JSON.stringify(state.lastScan, null, 2).slice(0, 700));
