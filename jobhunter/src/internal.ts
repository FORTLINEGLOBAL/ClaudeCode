// Internal function-to-function calls. The webhook (10s limit) and the scheduled
// scan (30s limit) cannot run a real scan, so they hand the work to a background
// function (15min limit) and return immediately.
import crypto from "node:crypto";

export const BACKGROUND_PATH = "/.netlify/functions/work-background";

// Commands that do network fetches or several Claude calls. Anything here would
// blow the 10s synchronous budget, so it is answered asynchronously.
const SLOW = new Set(["scan_now", "diag", "find_contacts", "add_company", "rewrite", "replied"]);

export function isSlow(action: string): boolean { return SLOW.has(action); }

export interface Work { kind: "command" | "scan" | "followups"; text?: string; lastInboundAt?: string }

function secret(): string {
  const s = process.env.WHATSAPP_APP_SECRET;
  if (!s) throw new Error("WHATSAPP_APP_SECRET is required to sign internal calls");
  return s;
}

export function sign(body: string): string {
  return `sha256=${crypto.createHmac("sha256", secret()).update(body).digest("hex")}`;
}

// Fails closed: an unsigned or wrongly signed call is never executed.
export function verifyInternal(body: string, header: string | null): boolean {
  if (!process.env.WHATSAPP_APP_SECRET) return false;
  if (!header?.startsWith("sha256=")) return false;
  const expected = crypto.createHmac("sha256", secret()).update(body).digest("hex");
  const given = header.slice(7);
  return expected.length === given.length && crypto.timingSafeEqual(Buffer.from(expected), Buffer.from(given));
}

function baseUrl(): string {
  const u = process.env.URL || process.env.DEPLOY_URL;
  if (!u) throw new Error("No site URL available for the internal call");
  return u.replace(/\/$/, "");
}

/** Hand work to the background function. Resolves once it is accepted (202), not once it is done. */
export async function dispatch(work: Work): Promise<void> {
  const body = JSON.stringify(work);
  const res = await fetch(`${baseUrl()}${BACKGROUND_PATH}`, {
    method: "POST",
    headers: { "content-type": "application/json", "x-jobhunter-signature": sign(body) },
    body,
  });
  // Background functions answer 202 immediately; anything else means it never started.
  if (res.status !== 202 && !res.ok) throw new Error(`background dispatch failed: HTTP ${res.status}`);
}
