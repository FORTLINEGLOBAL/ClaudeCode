// WhatsApp message templates, for writing first outside the 24-hour window. Each must be
// submitted in WhatsApp Manager under exactly this name, with these bodies, in Hebrew
// ("he") and English ("en_US"), as Utility. The chat log records the same text.
// The check-in is worded as a service notice: Meta reclassifies a chatty greeting as Marketing.
import type { Lang } from "./types.js";

export type TemplateName = "companion_checkin" | "companion_reminder";

export const TEMPLATE_BODIES: Record<TemplateName, Record<Lang, string>> = {
  companion_checkin: {
    he: "תזכורת: זו הבדיקה היומית המתוזמנת שלך, {{1}}. אפשר להשיב להודעה זו כדי לאשר.",
    en: "Reminder: this is your scheduled daily check-in, {{1}}. Please reply to this message to confirm.",
  },
  companion_reminder: {
    he: "תזכורת מאת {{1}}, מתוזמנת לשעה {{2}}: {{3}}. נא להשיב להודעה זו כדי לאשר.",
    en: "Reminder from {{1}}, scheduled for {{2}}: {{3}}. Please reply to this message to confirm.",
  },
};

export interface TemplateUse { name: TemplateName; params: string[] }

export const renderTemplate = (t: TemplateUse, lang: Lang) =>
  TEMPLATE_BODIES[t.name][lang].replace(/\{\{(\d)\}\}/g, (_, i) => t.params[Number(i) - 1] ?? "");

export const templateLang = (lang: Lang) => (lang === "he" ? "he" : "en_US");

/** Templates are used only once they are approved in WhatsApp Manager. */
export const templatesApproved = () => process.env.WHATSAPP_TEMPLATES_APPROVED === "1";
