// WhatsApp command handling. Fast regex path for the common commands, LLM fallback for free text.
import { interpret, draftDM, suggestReply } from "./llm.js";
import { byNumber, enqueue, slug, type State, type Contact, type Company } from "./store.js";
import { markSent } from "./followups.js";
import { fmtContactFull, fmtJob, pendingDigest, statusLine } from "./digest.js";
import { prospectOne } from "./hunters/emerging.js";
import { runScan } from "./scan.js";

const HELP = `Commands:
digest | status | help
show N              full draft / job
sent N[,N]          you sent the DM, I schedule the follow-up
skip N | skip <company>
rewrite N <how>     e.g. rewrite 3 shorter, mention I'm in London in Oct
replied N: <text>   paste their reply, I draft yours
find contacts at <company>
add company <company> | block company <company>
set cap 10 | pause | resume | scan now`;

type Intent = Awaited<ReturnType<typeof interpret>>;

function quick(msg: string): Intent | null {
  const m = msg.trim();
  const nums = (s: string) => (s.match(/\d+/g) || []).map(Number);
  let r: RegExpMatchArray | null;
  if (/^(digest|show all|pending|list)$/i.test(m)) return { action: "digest", numbers: [], company: "", text: "", value: 0 };
  if (/^(status|pipeline)$/i.test(m)) return { action: "status", numbers: [], company: "", text: "", value: 0 };
  if (/^(help|\?)$/i.test(m)) return { action: "help", numbers: [], company: "", text: "", value: 0 };
  if (/^pause$/i.test(m)) return { action: "pause", numbers: [], company: "", text: "", value: 0 };
  if (/^resume$/i.test(m)) return { action: "resume", numbers: [], company: "", text: "", value: 0 };
  if (/^scan( now)?$/i.test(m)) return { action: "scan_now", numbers: [], company: "", text: "", value: 0 };
  if ((r = m.match(/^show\s+#?(\d+)$/i))) return { action: "show", numbers: [Number(r[1])], company: "", text: "", value: 0 };
  if ((r = m.match(/^(sent|done)\s+([\d,#\s]+)$/i))) return { action: "sent", numbers: nums(r[2]), company: "", text: "", value: 0 };
  if ((r = m.match(/^skip\s+#?(\d+)$/i))) return { action: "skip", numbers: [Number(r[1])], company: "", text: "", value: 0 };
  if ((r = m.match(/^skip\s+(.+)$/i))) return { action: "skip", numbers: [], company: r[1].trim(), text: "", value: 0 };
  if ((r = m.match(/^rewrite\s+#?(\d+)\s*[:,]?\s*(.*)$/is))) return { action: "rewrite", numbers: [Number(r[1])], company: "", text: r[2].trim(), value: 0 };
  if ((r = m.match(/^replied\s+#?(\d+)\s*[:,]?\s*(.*)$/is))) return { action: "replied", numbers: [Number(r[1])], company: "", text: r[2].trim(), value: 0 };
  if ((r = m.match(/^find (contacts|people)( at| for)?\s+(.+)$/i))) return { action: "find_contacts", numbers: [], company: r[3].trim(), text: "", value: 0 };
  if ((r = m.match(/^add company\s+(.+)$/i))) return { action: "add_company", numbers: [], company: r[1].trim(), text: "", value: 0 };
  if ((r = m.match(/^block( company)?\s+(.+)$/i))) return { action: "block_company", numbers: [], company: r[2].trim(), text: "", value: 0 };
  if ((r = m.match(/^set cap\s+(\d+)$/i))) return { action: "set_cap", numbers: [], company: "", text: "", value: Number(r[1]) };
  return null;
}

function contactByN(state: State, n: number): Contact | null {
  const q = byNumber(state, n);
  return q?.kind === "contact" ? state.contacts[q.id] || null : null;
}

export async function handleCommand(state: State, msg: string): Promise<string> {
  const it = quick(msg) || (await interpret(msg));
  switch (it.action) {
    case "help": return HELP;
    case "digest": return pendingDigest(state);
    case "status": return statusLine(state);
    case "pause": state.settings.paused = true; return "Paused. No new drafts until you say 'resume'.";
    case "resume": state.settings.paused = false; return "Resumed.";
    case "set_cap": state.settings.dailyDraftCap = Math.max(1, it.value || 10); return `Daily draft cap set to ${state.settings.dailyDraftCap}.`;
    case "show": {
      const q = byNumber(state, it.numbers[0]);
      if (!q) return `No item #${it.numbers[0]}.`;
      if (q.kind === "job") return fmtJob(q.n, state.jobs[q.id]);
      return fmtContactFull(q.n, state.contacts[q.id]);
    }
    case "sent": {
      const done: string[] = [];
      for (const n of it.numbers) {
        const c = contactByN(state, n);
        if (!c) { const q = byNumber(state, n); if (q?.kind === "job") { state.jobs[q.id].status = "applied"; done.push(`#${n} job marked applied`); } continue; }
        markSent(state, c);
        done.push(`#${n} ${c.name}: follow-up on ${c.nextFollowUpAt!.slice(0, 10)}`);
      }
      return done.length ? done.join("\n") : "Nothing matched those numbers.";
    }
    case "skip": {
      if (it.numbers.length) {
        const out: string[] = [];
        for (const n of it.numbers) {
          const q = byNumber(state, n);
          if (!q) continue;
          if (q.kind === "job") { state.jobs[q.id].status = "skipped"; out.push(`#${n} job skipped`); }
          else { state.contacts[q.id].status = "skipped"; out.push(`#${n} ${state.contacts[q.id].name} skipped`); }
        }
        return out.join("\n") || "Nothing matched.";
      }
      const co = it.company.toLowerCase();
      let k = 0;
      for (const c of Object.values(state.contacts)) if (c.status === "drafted" && c.company.toLowerCase().includes(co)) { c.status = "skipped"; k++; }
      return `Skipped ${k} draft(s) at ${it.company}. Say 'block company ${it.company}' to never surface them again.`;
    }
    case "block_company": {
      state.settings.blockedCompanies.push(it.company);
      for (const c of Object.values(state.contacts)) if (c.status === "drafted" && c.company.toLowerCase().includes(it.company.toLowerCase())) c.status = "skipped";
      return `Blocked ${it.company}.`;
    }
    case "rewrite": {
      const c = contactByN(state, it.numbers[0]);
      if (!c) return `No DM #${it.numbers[0]}.`;
      const d = await draftDM({ name: c.name, title: c.title, company: c.company, facts: c.hook && c.hook !== "none" ? [c.hook] : [], priorTouches: c.touches, instruction: it.text || "make it tighter" });
      c.draft = d.message; c.angle = d.angle; c.updatedAt = new Date().toISOString();
      return fmtContactFull(it.numbers[0], c);
    }
    case "replied": {
      const c = contactByN(state, it.numbers[0]);
      if (!c) return `No DM #${it.numbers[0]}.`;
      c.status = "replied"; c.nextFollowUpAt = undefined; c.notes = ((c.notes || "") + `\nReply ${new Date().toISOString().slice(0, 10)}: ${it.text}`).trim();
      const d = await suggestReply(c, it.text || "(no text pasted)");
      c.draft = d.message;
      return `Logged. Suggested reply to ${c.name}:\n\n${d.message}\n\nReply 'sent ${it.numbers[0]}' once sent, or 'rewrite ${it.numbers[0]} <how>'.`;
    }
    case "add_company":
    case "find_contacts": {
      if (!it.company) return "Which company?";
      const id = slug(it.company);
      const c: Company = state.companies[id] || { id, name: it.company, hq: "unknown", status: "new", createdAt: new Date().toISOString() };
      state.companies[id] = c;
      const contacts = await prospectOne(state, c);
      if (!contacts.length) return `Could not find new senior people at ${it.company} (or all are already in the pipeline / daily cap reached).`;
      return contacts.map((x) => fmtContactFull(enqueue(state, "contact", x.id), x)).join("\n\n");
    }
    case "scan_now": {
      const r = await runScan(state, { force: true });
      return r || "Scan done, nothing new.";
    }
    default:
      return `Not sure what you meant. ${HELP}`;
  }
}
