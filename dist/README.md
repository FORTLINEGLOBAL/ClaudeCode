# dist — upload-ready skill builds

Single-file builds of the skills in `.claude/skills/`, flattened for uploading to a claude.ai
account (which is how Cowork and cloud sessions get skills — they do not read `~/.claude/skills/`
on your machine).

| File | Source |
|---|---|
| `gtm-advisor-crossing-the-chasm.md` | `.claude/skills/gtm-advisor-crossing-the-chasm/` |

Each build is self-contained: the reference material, templates, and scoring procedure are
inlined, and there are no pointers to bundled files. Upload the `.md` directly, or rename it to
`SKILL.md` inside a folder named after the skill and zip that folder if the uploader wants an
archive.

These are builds, not sources. Edit the skill under `.claude/skills/` and regenerate, or if you
maintain the single file by hand, treat it as the source of truth and stop editing the split
version — do not edit both.
