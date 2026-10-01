// Data model. One parent = one tenant: every key in the store is prefixed by the
// parent id, so one family's data is never read while serving another.

export type Lang = "he" | "en";

export interface Contact {
  name: string;
  relation: string;          // e.g. "son", "בת"
  phone?: string;            // E.164, used for tap-to-call in an SOS
}

export interface Consent {
  checkins: boolean;         // proactive daily check-in
  memory: boolean;           // remember facts across conversations
  escalation: boolean;       // SOS may alert the operator / family contact
}

export interface Parent {
  id: string;
  name: string;
  gender?: "f" | "m";        // Hebrew addresses people in gendered forms
  lang: Lang | "auto";       // explicit preference wins; "auto" detects per message
  lastLang: Lang;            // what we last answered in
  tz: string;                // IANA, e.g. "America/New_York"
  checkinTime: string;       // "HH:MM" local
  quietStart: string;        // "HH:MM" local, no proactive messages from here...
  quietEnd: string;          // ...until here
  emergencyNumber: string;   // "911" in the US, "101" in Israel
  codeWord?: string;         // personal SOS code word
  contacts: Contact[];       // first one is the primary emergency contact
  consent: Consent;
  stopped: boolean;          // parent said STOP / עצור: no proactive messages
  lastCheckinDate?: string;  // local YYYY-MM-DD of the last check-in sent
  createdAt: string;
}

export type MsgKind = "chat" | "checkin" | "sos" | "system";

export interface Msg {
  id: string;
  role: "parent" | "companion";
  text: string;
  at: string;
  kind: MsgKind;
  lang?: Lang;
}

export type FactKind = "life" | "family" | "routine" | "recent";

export interface Fact {
  id: string;
  kind: FactKind;
  text: string;              // in the language it was said; names kept as said
  lang: Lang;
  confidence: number;        // 0..1
  sensitive: boolean;        // health, money, medication: confirm before relying on it
  source: "said" | "confirmed" | "family";   // "family": added on the family page
  at: string;
  supersededBy?: string;     // corrections create a new fact; the old one stays for audit
}

// Family page access. The family sees activity and settings, never the conversation.
export type FamilyRole = "admin" | "viewer";   // admin edits settings and adds notes; viewer only looks

export interface FamilyAccess {
  parentId: string;
  role: FamilyRole;
  label: string;             // who the link was made for, e.g. "Dana"
  at: string;
}

export interface Alert {
  id: string;
  parentId: string;
  kind: "sos";
  text: string;              // what the parent wrote
  at: string;
  withinCoverage: boolean;
  operatorNotified: boolean;
}
