import type { Config } from "@netlify/functions";
import { dispatch } from "../../src/internal.js";
import { sendText } from "../../src/whatsapp.js";

// Drafting each due follow-up is a Claude call, so a busy day exceeds the 30s
// scheduled limit. The background worker does the drafting and sends the result.
export default async () => {
  try {
    await dispatch({ kind: "followups" });
  } catch (e: any) {
    console.error("scheduled follow-ups dispatch failed", e);
    await sendText(`The follow-up run could not start: ${e?.message || e}`);
  }
};

export const config: Config = { schedule: "0 6 * * *" };
