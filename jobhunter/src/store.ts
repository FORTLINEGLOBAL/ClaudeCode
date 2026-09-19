// Persistence on Netlify Blobs (free tier). Falls back to a local JSON file when
// running outside Netlify (scripts/run-local.ts).
import { getStore } from "@netlify/blobs";
import type { AtsRef } from "./sources/ats.js";
import fs from "node:fs";
import path from "node:path";

export type ContactStatus = "drafted" | "sent" | "replied" | "closed" | "skipped";

export interface Touch { n: number; text: string; sentAt: string }

export interface Contact {
  id: string;                 // stable id, e.g. slug of linkedin url or name+company
  name: string;
  title: string;
  company: string;
  linkedinUrl?: string;
  hunter: "emerging" | "biglabs" | "manual";
  angle: string;              // why we are contacting them (pitch angle)
  hook?: string;              // verified fact used in the draft, with source URL
  draft: string;              // current pending draft (first touch or follow-up)
  status: ContactStatus;
  touches: Touch[];
  nextFollowUpAt?: string;
  createdAt: string;
  updatedAt: string;
  notes?: string;
}

export interface Job {
  id: string;
  title: string;
  company: string;
  location: string;
  url: string;
  source: string;
  score: number;              // 0..100 relevance
  reason: string;
  firstSeen: string;
  status: "new" | "shown" | "applied" | "skipped";
}

export interface Company {
  id: string;
  name: string;
  hq: string;
  raisedUSD?: number;
  round?: string;
  raisedAt?: string;
  sector?: string;
  sourceUrl?: string;
  status: "new" | "contacts_found" | "skipped" | "blocked";
  createdAt: string;
}

export interface Settings {
  dailyDraftCap: number;      // new DMs per day
  followUpDays: number;
  maxTouches: number;
  paused: boolean;
  blockedCompanies: string[];
}

export interface QueueItem { n: number; kind: "job" | "contact"; id: string; createdAt: string }

// What the last scan actually did on the wire. Kept so "nothing new" can always
// be explained after the fact, including for the unattended scheduled runs.
export interface ScanReport {
  at: string;
  elapsedSec: number;
  fetches: number;
  fetchesOk: number;
  jobs: number;
  contacts: number;
  companies: number;
  trace: string;
  errors: string;
  search?: string;    // how the web searches behaved (people lookup depends entirely on them)
  prospect?: string;  // the company -> candidates -> picked -> drafted funnel
}

export interface State {
  jobs: Record<string, Job>;
  contacts: Record<string, Contact>;
  companies: Record<string, Company>;
  queue: QueueItem[];         // numbered items Eddie can refer to over WhatsApp
  nextQueueNumber: number;
  lastInboundAt?: string;     // for WhatsApp 24h service window
  draftsToday: { date: string; count: number };
  atsCache: Record<string, AtsRef>;   // company (lowercased) -> resolved job board, or a known miss
  lastScan?: ScanReport;
  settings: Settings;
}

export const DEFAULT_SETTINGS: Settings = {
  dailyDraftCap: 10,
  followUpDays: 7,
  maxTouches: 3,
  paused: false,
  blockedCompanies: [],
};

function emptyState(): State {
  return {
    jobs: {}, contacts: {}, companies: {}, queue: [], nextQueueNumber: 1, atsCache: {},
    draftsToday: { date: today(), count: 0 }, settings: { ...DEFAULT_SETTINGS },
  };
}

export function today(): string {
  // Israel-local date (UTC+2/+3). Good enough for daily caps.
  return new Date(Date.now() + 3 * 3600 * 1000).toISOString().slice(0, 10);
}

const KEY = "state-v1";
const LOCAL_FILE = path.resolve(process.cwd(), ".local-state.json");

function useBlobs(): boolean {
  return !!(process.env.NETLIFY || process.env.NETLIFY_BLOBS_CONTEXT || process.env.NETLIFY_SITE_ID);
}

export async function loadState(): Promise<State> {
  if (useBlobs()) {
    const store = getStore("jobhunter");
    const s = (await store.get(KEY, { type: "json" })) as State | null;
    return s ? { ...emptyState(), ...s } : emptyState();
  }
  if (fs.existsSync(LOCAL_FILE)) return { ...emptyState(), ...JSON.parse(fs.readFileSync(LOCAL_FILE, "utf8")) };
  return emptyState();
}

export async function saveState(s: State): Promise<void> {
  if (useBlobs()) {
    await getStore("jobhunter").setJSON(KEY, s);
    return;
  }
  fs.writeFileSync(LOCAL_FILE, JSON.stringify(s, null, 2));
}

export function enqueue(s: State, kind: QueueItem["kind"], id: string): number {
  const existing = s.queue.find((q) => q.kind === kind && q.id === id);
  if (existing) return existing.n;
  const n = s.nextQueueNumber++;
  s.queue.push({ n, kind, id, createdAt: new Date().toISOString() });
  // keep queue bounded
  if (s.queue.length > 200) s.queue = s.queue.slice(-200);
  return n;
}

export function byNumber(s: State, n: number): QueueItem | undefined {
  return s.queue.find((q) => q.n === n);
}

export function slug(x: string): string {
  return x.toLowerCase().replace(/https?:\/\/(www\.)?/, "").replace(/[^a-z0-9]+/g, "-").replace(/^-|-$/g, "").slice(0, 80);
}

export function canDraftMore(s: State): boolean {
  if (s.draftsToday.date !== today()) s.draftsToday = { date: today(), count: 0 };
  return s.draftsToday.count < s.settings.dailyDraftCap;
}

export function countDraft(s: State): void {
  if (s.draftsToday.date !== today()) s.draftsToday = { date: today(), count: 0 };
  s.draftsToday.count++;
}
