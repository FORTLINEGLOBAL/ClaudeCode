// WhatsApp Cloud API (Meta). Free-form text is allowed within 24h of Eddie's last message;
// outside that window we send an approved utility template with one text parameter.
import crypto from "node:crypto";

const API = "https://graph.facebook.com/v21.0";

function env(name: string): string {
  const v = process.env[name];
  if (!v) throw new Error(`Missing env ${name}`);
  return v;
}

async function post(body: unknown): Promise<{ ok: boolean; error?: any }> {
  const res = await fetch(`${API}/${env("WHATSAPP_PHONE_NUMBER_ID")}/messages`, {
    method: "POST",
    headers: { authorization: `Bearer ${env("WHATSAPP_TOKEN")}`, "content-type": "application/json" },
    body: JSON.stringify({ messaging_product: "whatsapp", to: env("EDDIE_WHATSAPP"), ...(body as object) }),
  });
  if (res.ok) return { ok: true };
  let error: any = await res.text();
  try { error = JSON.parse(error); } catch { /* keep text */ }
  return { ok: false, error };
}

export function chunk(text: string, max = 3900): string[] {
  const parts: string[] = [];
  let cur = "";
  for (const para of text.split("\n\n")) {
    if ((cur + "\n\n" + para).length > max) { if (cur) parts.push(cur); cur = para; } else cur = cur ? cur + "\n\n" + para : para;
  }
  if (cur) parts.push(cur);
  return parts.length ? parts : [text.slice(0, max)];
}

export async function sendText(text: string, lastInboundAt?: string): Promise<void> {
  const withinWindow = !!lastInboundAt && Date.now() - Date.parse(lastInboundAt) < 23.5 * 3600 * 1000;
  for (const part of chunk(text)) {
    let r = withinWindow ? await post({ type: "text", text: { body: part, preview_url: false } }) : { ok: false, error: "outside-window" };
    if (!r.ok) {
      const tpl = process.env.WHATSAPP_TEMPLATE;
      if (!tpl) { console.error("WhatsApp send failed and no template configured", r.error); return; }
      // Template body params cannot contain newlines or more than ~1000 chars.
      const flat = part.replace(/\s*\n+\s*/g, " | ").slice(0, 1000);
      r = await post({ type: "template", template: { name: tpl, language: { code: "en_US" }, components: [{ type: "body", parameters: [{ type: "text", text: flat }] }] } });
      if (!r.ok) console.error("WhatsApp template send failed", JSON.stringify(r.error));
    }
  }
}

export function verifySignature(rawBody: string, header: string | null): boolean {
  const secret = process.env.WHATSAPP_APP_SECRET;
  if (!secret) return true; // not configured: accept (dev only)
  if (!header?.startsWith("sha256=")) return false;
  const expected = crypto.createHmac("sha256", secret).update(rawBody).digest("hex");
  const given = header.slice(7);
  return expected.length === given.length && crypto.timingSafeEqual(Buffer.from(expected), Buffer.from(given));
}

export interface Inbound { from: string; text: string; id: string }

export function parseInbound(body: any): Inbound | null {
  const msg = body?.entry?.[0]?.changes?.[0]?.value?.messages?.[0];
  if (!msg) return null;
  const text = msg.type === "text" ? msg.text?.body : msg.type === "button" ? msg.button?.text : msg.type === "interactive" ? (msg.interactive?.button_reply?.title || msg.interactive?.list_reply?.title) : "";
  if (!text) return null;
  return { from: msg.from, text: String(text).trim(), id: msg.id };
}
