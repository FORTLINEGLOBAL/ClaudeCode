# Fortline Voice Profile
**Auto-updated by `fortline-dreamer` every Sunday night. Version: 1**
**Last updated:** (initial version — awaiting first Dreamer run)

---

## Identity

Eddie Nudel is a Strategic Advisor at Fortline Global. The advisory business serves defense tech companies, UAE/Gulf property and hospitality organizations, energy infrastructure clients, and select defense verticals globally.

This is not a vendor. It is an advisory practice. The voice reflects that: peer-to-peer, precise, confident without being pushy.

---

## Template version → vertical mapping

This table is authoritative. Do not deviate without Eddie's explicit sign-off.

| Vertical | Template | Israeli angle |
|---|---|---|
| UAE/Gulf luxury hospitality | v2.2 | OFF — never |
| UAE/Gulf upper-midscale hospitality | v2.2 | OFF — never |
| UAE/Gulf healthcare | v2.2 | OFF — never |
| Gulf aviation (airports, MRO) | v2.2 | OFF — never |
| UAE/Gulf commercial real estate | v2.2 | OFF — never |
| Sovereign/government-adjacent (ADQ, Mubadala, NEOM) | v2.2 | OFF — never |
| KSA hospitality / giga-projects | v2.2 | OFF — never |
| Israel-based defense companies | v2.1 | ON |
| Israeli dual-use tech | v2.1 or v2 | ON |
| Ukraine defense / reconstruction | v2.1 | OFF (Ukrainian context, not Israeli) |
| Energy infrastructure (global) | v2.1 | OFF unless Israeli company |
| Defense tech companies (non-Israeli) | v2 | OFF unless Israel-specific product |
| Security-vertical SaaS | v2 | OFF unless Israeli company |
| Dual-use technology (non-Israeli) | v2 | OFF |

**Rule:** Israeli angle is OFF for UAE/Gulf contacts regardless of template version. This is a hard constraint. Dreamer cannot toggle it. Only Eddie's manual sign-off changes it.

---

## What works (by template + vertical)

*Populated by Dreamer based on reply and approval patterns.*

### v2.2 — UAE/Gulf hospitality
- Property opening or expansion hooks perform best (high specificity, positive framing)
- Leadership change hooks work when the new person is from outside the region (implies fresh advisory slate)
- Avoid referencing competitor properties — too obvious

### v2.1 — Israel defense
- Integration window hooks are most credible (procurement teams recognize them)
- Post-procurement timing hooks: effective when the procurement is publicly announced

### v2 — Defense tech / security SaaS
- Module B (procurement pressure) hooks get highest response when tied to named tenders

---

## What to avoid

*Populated by Dreamer based on kill patterns.*

- Hooks referencing generic "regional instability" without a specific source
- Subject lines with more than 7 words (drafts with these get killed 80%+ of the time)
- Any hook referencing competitors by name in the body (consistently killed)
- v2.1 tone applied to UAE hospitality (mismatched — always killed immediately)

---

## Banned phrases (runtime list)

*In addition to the hard-coded list in fortline_guardrails.py. Auto-grown by Dreamer.*

<!-- Dreamer appends here based on Eddie's kills -->

---

## Trusted source domains (supplemental)

*In addition to the hard-coded baseline in fortline_guardrails.py. Auto-grown by Dreamer.*

<!-- Dreamer appends here based on approval patterns -->

---

## Untrusted source domains

*Auto-grown by Dreamer based on kill-due-to-source patterns.*

<!-- Dreamer appends here -->

---

## Hook type effectiveness by geography

*Populated by Dreamer.*

| Geography | Best hook type | Avoid |
|---|---|---|
| UAE | Property milestone, leadership change | Regional security incidents |
| Israel | Integration gap, procurement timing | Generic threat claims |
| Ukraine | Reconstruction opportunity | (pending data) |
| KSA | Giga-project milestone | Anything political |

---

## Notes for agents

- Always read this file at the start of each run.
- The template version mapping table is authoritative — do not use LLM judgment to override it.
- If a contact's vertical is not in the table, default to v2.2 and flag for Eddie's review.
- The Israeli angle rule is a hard constraint. It is not overridable at runtime.
