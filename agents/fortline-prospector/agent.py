"""
fortline-prospector — Claude Managed Agent runner
Schedule: cron 0 4 * * 1-5 (Mon-Fri 4am UTC)

This script defines and launches the Prospector as a Claude Managed Agent.
The system prompt lives in /prompts/fortline-prospector.md.
All skills are mounted as file context.
"""

from __future__ import annotations

import os
import pathlib
import sys

import anthropic

# ---------------------------------------------------------------------------
# Paths
# ---------------------------------------------------------------------------

ROOT = pathlib.Path(__file__).parent.parent.parent
PROMPTS_DIR = ROOT / "prompts"
SKILLS_DIR = ROOT / "skills"
STATE_DIR = ROOT / "state"


def _read(path: pathlib.Path) -> str:
    return path.read_text(encoding="utf-8")


# ---------------------------------------------------------------------------
# MCP server configuration
# ---------------------------------------------------------------------------

MCP_SERVERS = [
    # Fortline State DB (custom)
    anthropic.types.beta.BetaRequestMCPServerURLDefinitionParam(
        type="url",
        name="fortline-state",
        url=os.environ["FORTLINE_STATE_MCP_URL"],
        authorization_token=os.environ["FORTLINE_STATE_MCP_TOKEN"],
    ),
    # Clay (LinkedIn enrichment)
    anthropic.types.beta.BetaRequestMCPServerURLDefinitionParam(
        type="url",
        name="clay",
        url="https://api.clay.com/v3/mcp",
        authorization_token=os.environ["CLAY_API_KEY"],
    ),
    # Slack (ops notifications)
    anthropic.types.beta.BetaRequestMCPServerURLDefinitionParam(
        type="url",
        name="slack",
        url="https://mcp.slack.com/mcp",
        authorization_token=os.environ["SLACK_MCP_TOKEN"],
    ),
]


# ---------------------------------------------------------------------------
# System prompt assembly
# ---------------------------------------------------------------------------

def build_system_prompt() -> str:
    core = _read(PROMPTS_DIR / "fortline-prospector.md")

    skills = "\n\n---\n\n".join([
        "# SKILL: Writing Guidelines\n" + _read(SKILLS_DIR / "writing-guidelines" / "SKILL.md"),
        "# SKILL: forti-outreach-v2\n" + _read(SKILLS_DIR / "forti-outreach-v2" / "SKILL.md"),
        "# SKILL: forti-outreach-v21\n" + _read(SKILLS_DIR / "forti-outreach-v21" / "SKILL.md"),
        "# SKILL: forti-outreach-v22\n" + _read(SKILLS_DIR / "forti-outreach-v22" / "SKILL.md"),
    ])

    return f"{core}\n\n---\n\n# SKILLS BUNDLE\n\n{skills}"


# ---------------------------------------------------------------------------
# Agent launch
# ---------------------------------------------------------------------------

def run() -> None:
    client = anthropic.Anthropic(
        api_key=os.environ["ANTHROPIC_API_KEY"],
        default_headers={"anthropic-beta": "managed-agents-2025-01"},
    )

    system_prompt = build_system_prompt()

    # Initial user message triggers the full run
    user_message = (
        "Run the Fortline Prospector pipeline now. "
        "Read all active ICP briefs, research matching contacts, "
        "draft outreach packages, and write qualified drafts to the dashboard queue. "
        "Follow the system prompt exactly. Report your run summary when complete."
    )

    print(f"[fortline-prospector] Starting run at {__import__('datetime').datetime.utcnow().isoformat()}Z")

    response = client.beta.messages.create(
        model="claude-sonnet-4-6",
        max_tokens=16000,
        system=system_prompt,
        messages=[{"role": "user", "content": user_message}],
        mcp_servers=MCP_SERVERS,
        tools=[{"type": "web_search_20250305", "name": "web_search"}],
        betas=["managed-agents-2025-01", "web-search-2025-03-05"],
    )

    # Log final response text
    for block in response.content:
        if hasattr(block, "text"):
            print(f"[fortline-prospector] {block.text}")

    print(f"[fortline-prospector] Run complete. Stop reason: {response.stop_reason}")
    print(f"[fortline-prospector] Tokens: input={response.usage.input_tokens} output={response.usage.output_tokens}")


if __name__ == "__main__":
    missing = [v for v in [
        "ANTHROPIC_API_KEY", "FORTLINE_STATE_MCP_URL", "FORTLINE_STATE_MCP_TOKEN",
        "CLAY_API_KEY", "SLACK_MCP_TOKEN",
    ] if not os.environ.get(v)]
    if missing:
        print(f"ERROR: Missing required env vars: {', '.join(missing)}", file=sys.stderr)
        sys.exit(1)
    run()
