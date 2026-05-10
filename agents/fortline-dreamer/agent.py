"""
fortline-dreamer — Claude Managed Agent runner
Schedule: cron 0 20 * * 0 (Sunday 8pm UTC)

Analyzes the week's decisions, updates the voice profile, posts Slack digest.
"""

from __future__ import annotations

import os
import pathlib
import sys

import anthropic

ROOT = pathlib.Path(__file__).parent.parent.parent
PROMPTS_DIR = ROOT / "prompts"
SKILLS_DIR = ROOT / "skills"
STATE_DIR = ROOT / "state"


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
        name="slack",
        url="https://mcp.slack.com/mcp",
        authorization_token=os.environ["SLACK_MCP_TOKEN"],
    ),
]


def build_system_prompt() -> str:
    core = _read(PROMPTS_DIR / "fortline-dreamer.md")
    voice_profile = _read(STATE_DIR / "fortline-voice-profile.md")
    return (
        f"{core}\n\n---\n\n"
        f"# CURRENT VOICE PROFILE (read before analysis)\n\n{voice_profile}"
    )


def run() -> None:
    client = anthropic.Anthropic(
        api_key=os.environ["ANTHROPIC_API_KEY"],
        default_headers={"anthropic-beta": "managed-agents-2025-01"},
    )

    system_prompt = build_system_prompt()
    user_message = (
        "Run the Fortline Dreamer pipeline now. "
        "Pull last week's decision data, analyze patterns, update the voice profile, "
        "update source URL reputation in the DB, and post the weekly Slack digest to #fortline-agent-ops. "
        "Follow the system prompt exactly. Do not change the template version mapping or Israeli angle rule. "
        "Report what you changed when complete."
    )

    print(f"[fortline-dreamer] Starting run at {__import__('datetime').datetime.utcnow().isoformat()}Z")

    response = client.beta.messages.create(
        model="claude-sonnet-4-6",
        max_tokens=8000,
        system=system_prompt,
        messages=[{"role": "user", "content": user_message}],
        mcp_servers=MCP_SERVERS,
        betas=["managed-agents-2025-01"],
    )

    for block in response.content:
        if hasattr(block, "text"):
            print(f"[fortline-dreamer] {block.text}")

    print(f"[fortline-dreamer] Run complete. Stop reason: {response.stop_reason}")
    print(f"[fortline-dreamer] Tokens: input={response.usage.input_tokens} output={response.usage.output_tokens}")


if __name__ == "__main__":
    missing = [v for v in [
        "ANTHROPIC_API_KEY", "FORTLINE_STATE_MCP_URL", "FORTLINE_STATE_MCP_TOKEN", "SLACK_MCP_TOKEN",
    ] if not os.environ.get(v)]
    if missing:
        print(f"ERROR: Missing required env vars: {', '.join(missing)}", file=sys.stderr)
        sys.exit(1)
    run()
