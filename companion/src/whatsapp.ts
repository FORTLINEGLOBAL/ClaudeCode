// WhatsApp Cloud API (Meta direct). Free text works only inside the 24-hour window that
// opens when the person writes to us; outside it, only an approved template can be sent.
import crypto from "node:crypto";

const API = "https://graph.facebook.com/v21.0";
export const WINDOW_MS = 24 * 60 * 60 * 1000;

export const waConfigured = () => !!(process.env.WHATSAPP_TOKEN && process.env.WHATSAPP_PHONE_NUMBER_ID);

/** Digits only, as the Cloud API sends and expects numbers ("972501234567"). */
export const waNumber = (phone: string) => phone.replace(/\D/g, "");

async function post(to: string, body: object, timeoutMs: number): Promise<boolean> {
  try {
    const res = await fetch(`${API}/${process.env.WHATSAPP_PHONE_NUMBER_ID}/messages`, {
      method: "POST",
      headers: { authorization: `Bearer ${process.env.WHATSAPP_TOKEN}`, "content-type": "application/json" },
      body: JSON.stringify({ messaging_product: "whatsapp", to: waNumber(to), ...body }),
      signal: AbortSignal.timeout(timeoutMs),
    });
    if (!res.ok) console.error("whatsapp send failed", res.status, await res.text());
    return res.ok;
  } catch (e) {
    console.error("whatsapp send threw", e);
    return false;
  }
}

export const sendText = (to: string, text: string, timeoutMs = 8000) =>
  post(to, { type: "text", text: { body: text.slice(0, 4096), preview_url: false } }, timeoutMs);

export const sendTemplate = (to: string, name: string, lang: string, params: string[], timeoutMs = 8000) =>
  post(to, {
    type: "template",
    template: {
      name, language: { code: lang },
      components: params.length ? [{ type: "body", parameters: params.map((text) => ({ type: "text", text: text.replace(/\s*\n+\s*/g, " | ").slice(0, 1000) })) }] : [],
    },
  }, timeoutMs);

/** Meta signs each webhook with the app secret; anything else is not from Meta. */
export function validSignature(raw: string, header: string | null, secret = process.env.WHATSAPP_APP_SECRET): boolean {
  if (!secret || !header?.startsWith("sha256=")) return false;
  const want = Buffer.from("sha256=" + crypto.createHmac("sha256", secret).update(raw).digest("hex"));
  const got = Buffer.from(header);
  return want.length === got.length && crypto.timingSafeEqual(want, got);
}

export interface Inbound { id: string; from: string; text: string | null; type: string }

/** The messages in a webhook payload (delivery and read statuses are ignored). */
export function inboundMessages(payload: any): Inbound[] {
  const out: Inbound[] = [];
  for (const entry of payload?.entry ?? []) {
    for (const change of entry?.changes ?? []) {
      for (const m of change?.value?.messages ?? []) {
        const text = m.type === "text" ? m.text?.body
          : m.type === "button" ? m.button?.text
          : m.type === "interactive" ? (m.interactive?.button_reply?.title ?? m.interactive?.list_reply?.title)
          : null;
        out.push({ id: String(m.id), from: waNumber(String(m.from)), text: text ? String(text) : null, type: String(m.type) });
      }
    }
  }
  return out;
}
