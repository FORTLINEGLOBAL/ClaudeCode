const UA = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36";

// --- fetch tracing -----------------------------------------------------------
// Every source swallows its own failures and returns [], which makes a dead
// source and a genuinely empty result look identical ("nothing new"). The trace
// records what actually happened on the wire so a scan can report it.

export interface FetchNote { host: string; ok: boolean; status: number | null; reason?: string; ms: number; bytes: number }

let trace: FetchNote[] | null = null;

export function startTrace(): void { trace = []; }
export function endTrace(): FetchNote[] { const t = trace ?? []; trace = null; return t; }

function note(n: FetchNote): void { if (trace) trace.push(n); }

function hostOf(url: string): string { try { return new URL(url).host; } catch { return url.slice(0, 40); } }

// One line per host: how many calls worked, and why the rest did not.
export function traceSummary(notes: FetchNote[]): string {
  const byHost = new Map<string, FetchNote[]>();
  for (const n of notes) { const a = byHost.get(n.host) || []; a.push(n); byHost.set(n.host, a); }
  const lines: string[] = [];
  for (const [host, ns] of byHost) {
    const ok = ns.filter((n) => n.ok);
    const bytes = ok.reduce((s, n) => s + n.bytes, 0);
    const why = new Map<string, number>();
    for (const n of ns.filter((x) => !x.ok)) {
      const k = n.status ? `HTTP ${n.status}` : (n.reason || "error");
      why.set(k, (why.get(k) || 0) + 1);
    }
    const detail = why.size ? ` — ${[...why].map(([k, v]) => `${v}x ${k}`).join(", ")}` : "";
    lines.push(`${host}: ${ok.length}/${ns.length} ok, ${Math.round(bytes / 1024)}kb${detail}`);
  }
  return lines.join("\n");
}

export async function fetchText(url: string, init: RequestInit = {}, timeoutMs = 15000): Promise<string | null> {
  const ctrl = new AbortController();
  const t = setTimeout(() => ctrl.abort(), timeoutMs);
  const started = Date.now();
  const host = hostOf(url);
  try {
    const res = await fetch(url, { ...init, signal: ctrl.signal, headers: { "user-agent": UA, accept: "*/*", ...(init.headers || {}) } });
    if (!res.ok) { note({ host, ok: false, status: res.status, ms: Date.now() - started, bytes: 0 }); return null; }
    const body = await res.text();
    note({ host, ok: true, status: res.status, ms: Date.now() - started, bytes: body.length });
    return body;
  } catch (e: any) {
    const aborted = e?.name === "AbortError";
    note({ host, ok: false, status: null, reason: aborted ? `timeout ${timeoutMs}ms` : (e?.cause?.code || e?.code || e?.message || "error"), ms: Date.now() - started, bytes: 0 });
    return null;
  } finally {
    clearTimeout(t);
  }
}

export async function fetchJSON<T = unknown>(url: string): Promise<T | null> {
  const txt = await fetchText(url, { headers: { accept: "application/json" } });
  if (!txt) return null;
  try { return JSON.parse(txt) as T; } catch { return null; }
}

export function strip(html: string): string {
  return html.replace(/<[^>]+>/g, " ").replace(/&amp;/g, "&").replace(/&#39;|&#x27;/g, "'").replace(/&quot;/g, '"').replace(/&nbsp;/g, " ").replace(/\s+/g, " ").trim();
}
