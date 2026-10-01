// Local-time helpers. Everything proactive is decided in the parent's own time
// zone (DST included), never in server time.

export interface LocalNow { date: string; hhmm: string; minutes: number }

export function localNow(tz: string, at: Date = new Date()): LocalNow {
  const parts = Object.fromEntries(
    new Intl.DateTimeFormat("en-CA", { timeZone: tz, year: "numeric", month: "2-digit", day: "2-digit", hour: "2-digit", minute: "2-digit", hourCycle: "h23" })
      .formatToParts(at).map((p) => [p.type, p.value]),
  );
  const hhmm = `${parts.hour}:${parts.minute}`;
  return { date: `${parts.year}-${parts.month}-${parts.day}`, hhmm, minutes: toMinutes(hhmm) };
}

export function toMinutes(hhmm: string): number {
  const m = /^(\d{1,2}):(\d{2})$/.exec(hhmm);
  if (!m) throw new Error(`Bad time "${hhmm}", expected HH:MM`);
  return Number(m[1]) * 60 + Number(m[2]);
}

/** True when `minutes` is inside [start, end). Handles windows that cross midnight. */
export function inWindow(minutes: number, start: string, end: string): boolean {
  const s = toMinutes(start), e = toMinutes(end);
  return s <= e ? minutes >= s && minutes < e : minutes >= s || minutes < e;
}
