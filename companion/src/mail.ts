// Outgoing email through Resend. The sender must be on a domain verified in Resend;
// the default test sender (onboarding@resend.dev) only reaches the Resend account's own address.
export type MailResult = { ok: true } | { ok: false; error: string };

export async function sendEmail(m: { to: string[]; subject: string; text: string; html?: string; timeoutMs?: number }): Promise<MailResult> {
  const key = process.env.RESEND_API_KEY;
  if (!key) return { ok: false, error: "RESEND_API_KEY is not set" };
  if (!m.to.length) return { ok: false, error: "no recipients" };
  try {
    const res = await fetch("https://api.resend.com/emails", {
      method: "POST",
      headers: { authorization: `Bearer ${key}`, "content-type": "application/json" },
      body: JSON.stringify({ from: process.env.ALERT_FROM_EMAIL || "Companion <onboarding@resend.dev>", to: m.to, subject: m.subject, text: m.text, html: m.html }),
      signal: AbortSignal.timeout(m.timeoutMs ?? 10000),
    });
    if (res.ok) return { ok: true };
    const body = await res.text();
    console.error("email failed", res.status, body);
    let msg = body;
    try { msg = JSON.parse(body).message || body; } catch {}
    return { ok: false, error: `${res.status}: ${msg}`.slice(0, 300) };
  } catch (e) {
    console.error("email threw", e);
    return { ok: false, error: String(e).slice(0, 300) };
  }
}
