import type { Config } from "@netlify/functions";
import { dispatch } from "../../src/internal.js";
import { sendText } from "../../src/whatsapp.js";

// Scheduled functions are capped at 30 seconds, which a real scan exceeds. This
// only hands the work to the background worker (15 min) and returns.
export default async () => {
  try {
    await dispatch({ kind: "scan" });
  } catch (e: any) {
    // A scan that never starts must not fail quietly: that is the bug this whole
    // path exists to prevent.
    console.error("scheduled scan dispatch failed", e);
    await sendText(`The scheduled scan could not start: ${e?.message || e}`);
  }
};

export const config: Config = { schedule: "0 */6 * * *" };
