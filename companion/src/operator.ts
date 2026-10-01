// Alerts to the human on duty (the operator). Optional: WhatsApp via the Meta
// Cloud API when configured; otherwise the alert is only stored for /api/admin/alerts.
const API = "https://graph.facebook.com/v21.0";

async function post(body: unknown): Promise<boolean> {
  const res = await fetch(`${API}/${process.env.WHATSAPP_PHONE_NUMBER_ID}/messages`, {
    method: "POST",
    headers: { authorization: `Bearer ${process.env.WHATSAPP_TOKEN}`, "content-type": "application/json" },
    body: JSON.stringify({ messaging_product: "whatsapp", to: process.env.OPERATOR_WHATSAPP, ...(body as object) }),
  });
  if (!res.ok) console.error("operator alert failed", res.status, await res.text());
  return res.ok;
}

/** True only when the operator was actually reached; the parent is told so only then. */
export async function notifyOperator(text: string): Promise<boolean> {
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
