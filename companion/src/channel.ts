// The core never knows which app a message came from. Phase 1 has one channel,
// the web chat; WhatsApp (phase 2b) is a second implementation of this interface.
import type { Msg, Parent } from "./types.js";
import { appendChat } from "./store.js";

export interface ChannelCaps {
  /** Can we message the parent first right now, as free text? (WhatsApp: only inside the 24h window.) */
  canSendFreeform(p: Parent): boolean;
}

export interface Channel extends ChannelCaps {
  name: "web" | "whatsapp";
  deliver(p: Parent, msg: Msg): Promise<void>;
}

export const webChannel: Channel = {
  name: "web",
  canSendFreeform: () => true,
  // The web chat reads the log, so delivering is appending to it.
  deliver: async (p, msg) => { await appendChat(p.id, msg); },
};
