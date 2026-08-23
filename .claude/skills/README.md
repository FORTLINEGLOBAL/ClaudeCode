# Book-based consulting agents

Each skill in this directory turns one business book into a working consultant: not a summary of
the book, but an advisor that runs the book's frameworks on the client's actual situation and
ends with decisions.

## Current agents

| Skill | Book | What it advises on |
|---|---|---|
| `gtm-advisor-crossing-the-chasm` | Geoffrey A. Moore, *Crossing the Chasm* (3rd ed., 2014) | Go-to-market for disruptive technology products: life-cycle diagnosis, beachhead segment selection, whole product, positioning, distribution and pricing |

## Installing

These are project skills — they load automatically for Claude Code sessions in this repo.
To make one available everywhere, copy it into your personal skills directory:

```bash
cp -r .claude/skills/gtm-advisor-crossing-the-chasm ~/.claude/skills/
```

Invoke it by name (`/gtm-advisor-crossing-the-chasm`) or just describe the problem — the
description in each SKILL.md is written to trigger on the situations the book addresses.

## The pattern, for adding the next book

Keep the shape consistent so the agents feel like one family.

```
<advisor-name>/
├── SKILL.md          # persona, non-negotiables, modes, method, deliverable format
├── references/       # one file per framework or chapter cluster, read on demand
├── assets/           # templates the advisor fills in with the client
└── scripts/          # the arithmetic the advisor should never do by hand
```

What makes these work as advisors rather than book reports:

1. **A stance, not a summary.** State how the advisor behaves: what it insists on, what it
   refuses to hedge on, when it tells the client they are wrong.
2. **Non-negotiables.** The three to eight rules of the framework that must never be softened to
   make a client comfortable. This is most of the value — books get diluted in practice exactly
   at these points.
3. **Modes.** Clients arrive at different stages. Map the likely asks to entry points so the
   advisor does not run the whole methodology on someone who asked one question.
4. **Intake before advice.** A short list of what the advisor must know, asked in one batch.
   Then advise on stated assumptions rather than stalling for perfect data.
5. **Progressive disclosure.** SKILL.md stays under ~500 lines and points to `references/`.
   Only the reference for the step being run gets read.
6. **A commitment block.** Every engagement ends with the decisions in a fixed, copyable format.
   Prose is not actionable.
7. **An objection table.** The five to ten things clients always say back, with the answer the
   book gives. This is what turns the skill from a framework into a consultant.

Do not commit book text. These skills carry synthesis, frameworks, and short attributed
quotations — enough to apply the method, not a reproduction of the work. Cite the edition and
chapter so a client can go read the source.
