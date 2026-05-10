"""
fortline-followup-tracker — Claude Managed Agent runner
Schedule: cron 0 5 * * 1,4 (Mon + Thu 5am UTC)

Scans stalled threads and drafts next-touchpoint follow-up messages.
"""

from __future__ import annotations

import os
import pathlib
import sys

import anthropic

ROOT = pathlib.Path(__file__).parent.parent.parent
PROMPTS_DIR = ROOT / "prompts"
SKILLS_DIR = ROOT / "skills"


def _read(path: pathlib.Path) -> str:
    return path.read_text(encoding="utf-8")


MCP_SERVERS = [
    anthropic.types.beta.BetaRequestMCPServerURLDefinitionParam(
        type="url",
        name="fortline-state",
        url=os.environ["FORTLINE_STATE_MCP_URL"],
        authorization_token=os.environ["FORTLINE_STATE_MCP_TOKEN"],
    ),
    anthropic.types.beta.BetaRequestMCPServerURLDefinitionParam(
        type="url",
        name="forti-email",
        url=os.environ["FORTI_EMAIL_BACKEND_URL"],
        authorization_token=os.environ["FORTI_EMAIL_API_KEY"],
    ),
    anthropic.types.beta.BetaRequestMCPServerURLDefinitionParam(
        type="url",
        name="clay",
        url="https://api.clay.com/v3/mcp",
        authorization_token=os.environ["CLAY_API_KEY"],
    ),
    anthropic.types.beta.BetaRequestMCPServerURLDefinitionParam(
        type="url",
        name="slack",
        url="https://mcp.slack.com/mcp",
        authorization_token=os.environ["SLACK_MCP_TOKEN"],
    ),
]


def build_system_prompt() -> str:
    core = _read(PROMPTS_DIR / "fortline-followup-tracker.md")
    guidelines = _read(SKILLS_DIR / "writing-guidelines" / "SKILL.md")
    return f"{core}\n\n---\n\n# SKILL: Writing Guidelines\n\n{guidelines}"


def run() -> None:
    client = anthropic.Anthropic(
        api_key=os.environ["ANTHROPIC_API_KEY"],
        default_headers={"anthropic-beta": "managed-agents-2025-01"},
    )

    system_prompt = build_system_prompt()
    user_message = (
        "Run the Fortline Follow-Up Tracker pipeline now. "
        "Scan for stalled threads (5+ days, no reply), determine touchpoint number, "
        "draft the appropriate follow-up for each, and write to the dashboard queue. "
        "Follow the system prompt exactly. Report your run summary when complete."
    )

    print(f"[fortline-followup-tracker] Starting run at {__import__('datetime').datetime.utcnow().isoformat()}Z")

    response = client.beta.messages.create(
        model="claude-sonnet-4-6",
        max_tokens=12000,
        system=system_prompt,
        messages=[{"role": "user", "content": user_message}],
        mcp_servers=MCP_SERVERS,
        tools=[{"type": "web_search_20250305", "name": "web_search"}],
        betas=["managed-agents-2025-01", "web-search-2025-03-05"],
    )

    for block in response.content:
        if hasattr(block, "text"):
            print(f"[fortline-followup-tracker] {block.text}")

    print(f"[fortline-followup-tracker] Run complete. Stop reason: {response.stop_reason}")
    print(f"[fortline-followup-tracker] Tokens: input={response.usage.input_tokens} output={response.usage.output_tokens}")


if __name__ == "__main__":
    missing = [v for v in [
        "ANTHROPIC_API_KEY", "FORTLINE_STATE_MCP_URL", "FORTLINE_STATE_MCP_TOKEN",
        "FORTI_EMAIL_BACKEND_URL", "FORTI_EMAIL_API_KEY", "CLAY_API_KEY", "SLACK_MCP_TOKEN",
    ] if not os.environ.get(v)]
    if missing:
        print(f"ERROR: Missing required env vars: {', '.join(missing)}", file=sys.stderr)
        sys.exit(1)
    run()
