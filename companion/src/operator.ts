// Alerts to the human on duty (the operator), by email (Resend) and/or WhatsApp
// (Meta Cloud API), whichever is configured. Either way the alert is also stored
// for /api/admin/alerts.
import { sendEmail } from "./mail.js";
import { sendTemplate, sendText, waConfigured } from "./whatsapp.js";

const ALERT_TIMEOUT_MS = 4000;   // the parent is waiting on the SOS reply

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
  const to = process.env.OPERATOR_WHATSAPP;
  if (!waConfigured() || !to) return false;
  // Free text works only inside the operator's 24h window; the template works any time.
  if (await sendText(to, text.slice(0, 3900), ALERT_TIMEOUT_MS)) return true;
  const tpl = process.env.WHATSAPP_TEMPLATE;
  return tpl ? sendTemplate(to, tpl, "en_US", [text], ALERT_TIMEOUT_MS) : false;
}
