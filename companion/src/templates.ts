// WhatsApp message templates, for writing first outside the 24-hour window. Each must be
// submitted in WhatsApp Manager under exactly this name, with these bodies, in Hebrew
// ("he") and English ("en_US"), as Utility. The chat log records the same text.
import type { Lang } from "./types.js";

export type TemplateName = "companion_checkin" | "companion_reminder";

export const TEMPLATE_BODIES: Record<TemplateName, Record<Lang, string>> = {
  companion_checkin: {
    he: "בוקר טוב {{1}}! מה נשמע היום? אפשר לענות כאן בהודעה.",
    en: "Good morning {{1}}! How is your day going? You can reply right here.",
  },
  companion_reminder: {
    he: "⏰ תזכורת מ{{1}} לשעה {{2}}: {{3}}. אפשר לענות כאן בהודעה.",
    en: "⏰ A reminder from {{1}} for {{2}}: {{3}}. You can reply right here.",
  },
};

export interface TemplateUse { name: TemplateName; params: string[] }

export const renderTemplate = (t: TemplateUse, lang: Lang) =>
  TEMPLATE_BODIES[t.name][lang].replace(/\{\{(\d)\}\}/g, (_, i) => t.params[Number(i) - 1] ?? "");

export const templateLang = (lang: Lang) => (lang === "he" ? "he" : "en_US");

/** Templates are used only once they are approved in WhatsApp Manager. */
export const templatesApproved = () => process.env.WHATSAPP_TEMPLATES_APPROVED === "1";
