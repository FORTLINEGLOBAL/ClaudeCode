// The core never knows which app a message came from. The web chat and WhatsApp are two
// implementations of this interface; both also write to the stored log, which the web
// chat reads and the family page counts.
import type { Msg, Parent } from "./types.js";
import { appendChat } from "./store.js";
import { WINDOW_MS, sendTemplate, sendText, waConfigured } from "./whatsapp.js";
import { type TemplateUse, renderTemplate, templateLang, templatesApproved } from "./templates.js";

export interface ChannelCaps {
  /** Can we message the parent first right now, as free text? (WhatsApp: only inside the 24h window.) */
  canSendFreeform(p: Parent): boolean;
  /** Outside the window, can we write first with an approved template? */
  canSendTemplate(p: Parent): boolean;
}

export interface Channel extends ChannelCaps {
  name: "web" | "whatsapp";
  /** `template`: what to send instead when free text isn't allowed; the log then records the template's text. */
  deliver(p: Parent, msg: Msg, template?: TemplateUse): Promise<void>;
}

export const webChannel: Channel = {
  name: "web",
  canSendFreeform: () => true,
  canSendTemplate: () => false,
  // The web chat reads the log, so delivering is appending to it.
  deliver: async (p, msg) => { await appendChat(p.id, msg); },
};

const inWindow = (p: Parent) => !!p.lastInboundAt && Date.now() - new Date(p.lastInboundAt).getTime() < WINDOW_MS;

export const whatsappChannel: Channel = {
  name: "whatsapp",
  canSendFreeform: inWindow,
  canSendTemplate: () => templatesApproved(),
  deliver: async (p, msg, template) => {
    if (msg.role === "companion" && p.whatsapp) {
      const lang = msg.lang ?? p.lastLang;
      if (inWindow(p)) {
        if (!(await sendText(p.whatsapp, msg.text))) msg = { ...msg, kind: "system", text: `[not delivered on WhatsApp] ${msg.text}` };
      } else if (template && templatesApproved()) {
        msg = { ...msg, text: renderTemplate(template, lang) };
        if (!(await sendTemplate(p.whatsapp, template.name, templateLang(lang), template.params))) msg = { ...msg, kind: "system", text: `[not delivered on WhatsApp] ${msg.text}` };
      } else {
        msg = { ...msg, kind: "system", text: `[not sent: outside WhatsApp's 24h window] ${msg.text}` };
      }
    }
    await appendChat(p.id, msg);
  },
};

/** Where the companion talks to this parent. */
export const channelFor = (p: Parent): Channel => (p.whatsapp && waConfigured() ? whatsappChannel : webChannel);
