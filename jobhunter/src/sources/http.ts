const UA = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36";

export async function fetchText(url: string, init: RequestInit = {}, timeoutMs = 15000): Promise<string | null> {
  const ctrl = new AbortController();
  const t = setTimeout(() => ctrl.abort(), timeoutMs);
  try {
    const res = await fetch(url, { ...init, signal: ctrl.signal, headers: { "user-agent": UA, accept: "*/*", ...(init.headers || {}) } });
    if (!res.ok) return null;
    return await res.text();
  } catch {
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
