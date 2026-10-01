// Persistence on Netlify Blobs. Falls back to a local folder when running outside
// Netlify (scripts, tests), same as jobhunter.
import { getStore } from "@netlify/blobs";
import fs from "node:fs";
import path from "node:path";
import crypto from "node:crypto";
import type { Alert, Fact, Msg, Parent } from "./types.js";

const LOCAL_DIR = path.resolve(process.cwd(), ".local-store");

function useBlobs(): boolean {
  return !!(process.env.NETLIFY || process.env.NETLIFY_BLOBS_CONTEXT || process.env.NETLIFY_SITE_ID);
}

const localPath = (key: string) => path.join(LOCAL_DIR, key.replace(/\//g, "__") + ".json");

async function getJSON<T>(key: string): Promise<T | null> {
  if (useBlobs()) return (await getStore("companion").get(key, { type: "json" })) as T | null;
  const f = localPath(key);
  return fs.existsSync(f) ? JSON.parse(fs.readFileSync(f, "utf8")) : null;
}

async function setJSON(key: string, value: unknown): Promise<void> {
  if (useBlobs()) { await getStore("companion").setJSON(key, value); return; }
  fs.mkdirSync(LOCAL_DIR, { recursive: true });
  fs.writeFileSync(localPath(key), JSON.stringify(value, null, 2));
}

async function listKeys(prefix: string): Promise<string[]> {
  if (useBlobs()) {
    const { blobs } = await getStore("companion").list({ prefix });
    return blobs.map((b) => b.key);
  }
  if (!fs.existsSync(LOCAL_DIR)) return [];
  const p = prefix.replace(/\//g, "__");
  return fs.readdirSync(LOCAL_DIR).filter((f) => f.startsWith(p)).map((f) => f.slice(0, -5).replace(/__/g, "/"));
}

export const newId = () => crypto.randomUUID();
export const hashToken = (t: string) => crypto.createHash("sha256").update(t).digest("hex");

// ---------- parents and access links ----------
export const getParent = (id: string) => getJSON<Parent>(`parent/${id}`);
export const saveParent = (p: Parent) => setJSON(`parent/${p.id}`, p);

export async function listParents(): Promise<Parent[]> {
  const keys = await listKeys("parent/");
  const out: Parent[] = [];
  for (const k of keys) { const p = await getJSON<Parent>(k); if (p) out.push(p); }
  return out;
}

/** Access link token -> parent. Only the hash is stored. */
export async function parentForToken(token: string): Promise<Parent | null> {
  if (!token || token.length < 20) return null;
  const ref = await getJSON<{ parentId: string }>(`token/${hashToken(token)}`);
  return ref ? getParent(ref.parentId) : null;
}

export async function issueToken(parentId: string): Promise<string> {
  const token = crypto.randomBytes(24).toString("base64url");
  await setJSON(`token/${hashToken(token)}`, { parentId, at: new Date().toISOString() });
  return token;
}

// ---------- chat log ----------
const MAX_LOG = 500;

export async function getChat(parentId: string): Promise<Msg[]> {
  return (await getJSON<Msg[]>(`chat/${parentId}`)) ?? [];
}

export async function appendChat(parentId: string, ...msgs: Msg[]): Promise<Msg[]> {
  const log = [...(await getChat(parentId)), ...msgs].slice(-MAX_LOG);
  await setJSON(`chat/${parentId}`, log);
  return log;
}

// ---------- memory ----------
export async function getFacts(parentId: string): Promise<Fact[]> {
  return (await getJSON<Fact[]>(`facts/${parentId}`)) ?? [];
}
export const saveFacts = (parentId: string, facts: Fact[]) => setJSON(`facts/${parentId}`, facts);

// ---------- alerts (operator view) ----------
export async function getAlerts(): Promise<Alert[]> {
  return (await getJSON<Alert[]>("alerts")) ?? [];
}
export async function addAlert(a: Alert): Promise<void> {
  await setJSON("alerts", [...(await getAlerts()), a].slice(-1000));
}
