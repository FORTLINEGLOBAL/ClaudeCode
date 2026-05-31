# Fortline Global — Prospecting

A Claude Code subagent that finds and researches prospects for Fortline's passive
defense / building-hardening offering, then prepares review-ready outreach drafts.

## What it does
- Identifies target organizations and decision-makers in **Poland, Estonia,
  Romania, Latvia** across all four segments (govt/civil defense, critical
  infrastructure, public buildings, defense primes/EPCs).
- Scores fit, writes a per-prospect briefing, and prepares a tailored cold email
  **as a Gmail draft** (it never sends).

## How to use it
Just ask Claude Code, e.g.:
- "Use the prospecting agent to find 5 critical-infrastructure prospects in Poland."
- "Prospect civil-defense agencies in the Baltics and draft outreach."
- "Research <Organization> as a Fortline prospect and draft an intro email."

Claude will delegate to the `prospecting-agent` subagent. Review the briefings in
`prospecting/briefings/` and the Gmail drafts before sending anything.

## Files
- `.claude/agents/prospecting-agent.md` — the agent definition.
- `playbook.md` — ICP, country angles, messaging pillars, email rules.
- `briefing-template.md` — output format per prospect.
- `briefings/` — generated briefings.
- `prospects.csv` — running tracker.

## Guardrails
- Draft-only: never sends email or schedules meetings.
- No fabricated contacts/emails/stats; unverified items are flagged and sourced.
- Public B2B/B2G contact info only; GDPR-conscious.
