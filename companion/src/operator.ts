// Alerts to the human on duty (the operator), by email (Resend) and/or WhatsApp
// (Meta Cloud API), whichever is configured. Either way the alert is also stored
// for /api/admin/alerts.
import { sendEmail } from "./mail.js";

const API = "https://graph.facebook.com/v21.0";
const ALERT_TIMEOUT_MS = 4000;   // the parent is waiting on the SOS reply

async function post(body: unknown): Promise<boolean> {
  const res = await fetch(`${API}/${process.env.WHATSAPP_PHONE_NUMBER_ID}/messages`, {
    method: "POST",
    headers: { authorization: `Bearer ${process.env.WHATSAPP_TOKEN}`, "content-type": "application/json" },
    body: JSON.stringify({ messaging_product: "whatsapp", to: process.env.OPERATOR_WHATSAPP, ...(body as object) }),
    signal: AbortSignal.timeout(ALERT_TIMEOUT_MS),
  });
  if (!res.ok) console.error("operator alert failed", res.status, await res.text());
  return res.ok;
}

/** True only when the operator was actually reached; the parent is told so only then. */
export async function notifyOperator(text: string): Promise<boolean> {
  const [mail, wa] = await Promise.all([byEmail(text), byWhatsApp(text)]);
  return mail || wa;
}

async function byEmail(text: string): Promise<boolean> {
  const to = process.env.OPERATOR_EMAIL;
  if (!process.env.RESEND_API_KEY || !to) return false;
  const r = await sendEmail({
    to: to.split(",").map((x) => x.trim()).filter(Boolean),
    subject: `SOS: ${text.split("\n")[0].slice(0, 120)}`,
    text, timeoutMs: ALERT_TIMEOUT_MS,
  });
  return r.ok;
}

async function byWhatsApp(text: string): Promise<boolean> {
  if (!process.env.WHATSAPP_TOKEN || !process.env.WHATSAPP_PHONE_NUMBER_ID || !process.env.OPERATOR_WHATSAPP) return false;
  try {
    // Free text works only inside the operator's 24h window; the template works any time.
    if (await post({ type: "text", text: { body: text.slice(0, 3900) } })) return true;
    const tpl = process.env.WHATSAPP_TEMPLATE;
    if (!tpl) return false;
    const flat = text.replace(/\s*\n+\s*/g, " | ").slice(0, 1000);
    return await post({ type: "template", template: { name: tpl, language: { code: "en_US" }, components: [{ type: "body", parameters: [{ type: "text", text: flat }] }] } });
  } catch (e) {
    console.error("operator alert threw", e);
    return false;
  }
}
