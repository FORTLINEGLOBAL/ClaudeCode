// Function-to-function calls. The chat request answers within seconds, so model
// work is handed to a background function (15 minutes) and the page polls.
import crypto from "node:crypto";

export const BACKGROUND_PATH = "/.netlify/functions/turn-background";

export type Work = { kind: "turn"; parentId: string; parentMsgId: string } | { kind: "checkins" };

function secret(): string {
  const s = process.env.COMPANION_INTERNAL_SECRET;
  if (!s) throw new Error("COMPANION_INTERNAL_SECRET is required to sign internal calls");
  return s;
}

const sign = (body: string) => `sha256=${crypto.createHmac("sha256", secret()).update(body).digest("hex")}`;

// Fails closed: an unsigned or wrongly signed call is never executed.
export function verifyInternal(body: string, header: string | null): boolean {
  if (!process.env.COMPANION_INTERNAL_SECRET || !header?.startsWith("sha256=")) return false;
  const expected = Buffer.from(sign(body));
  const given = Buffer.from(header);
  return expected.length === given.length && crypto.timingSafeEqual(expected, given);
}

export async function dispatch(work: Work): Promise<void> {
  const base = (process.env.URL || process.env.DEPLOY_URL || "").replace(/\/$/, "");
  if (!base) throw new Error("No site URL available for the internal call");
  const body = JSON.stringify(work);
  const res = await fetch(`${base}${BACKGROUND_PATH}`, {
    method: "POST",
    headers: { "content-type": "application/json", "x-companion-signature": sign(body) },
    body,
  });
  if (res.status !== 202 && !res.ok) throw new Error(`background dispatch failed: HTTP ${res.status}`);
}
