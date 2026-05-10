"""
Fortline State MCP Server
FastMCP server exposing State DB operations to Fortline agents.
Isolated from Flexor. Connects to FORTLINE_DB_URL only.
"""

from __future__ import annotations

import json
import os
import uuid
from datetime import datetime, timezone
from typing import Any

import psycopg2
import psycopg2.extras
from mcp.server.fastmcp import FastMCP

# ---------------------------------------------------------------------------
# Database connection
# ---------------------------------------------------------------------------

_DB_URL: str = os.environ["FORTLINE_DB_URL"]  # postgres://user:pass@host:5432/fortline_db


def _conn() -> psycopg2.extensions.connection:
    conn = psycopg2.connect(_DB_URL)
    conn.autocommit = False
    psycopg2.extras.register_uuid(conn)
    return conn


def _execute(sql: str, params: tuple = (), fetch: bool = False) -> list[dict[str, Any]]:
    with _conn() as conn:
        with conn.cursor(cursor_factory=psycopg2.extras.RealDictCursor) as cur:
            cur.execute(sql, params)
            if fetch:
                return [dict(r) for r in cur.fetchall()]
            conn.commit()
            return []


# ---------------------------------------------------------------------------
# MCP server
# ---------------------------------------------------------------------------

mcp = FastMCP("fortline-state")


# ---------------------------------------------------------------------------
# Drafts
# ---------------------------------------------------------------------------

@mcp.tool()
def get_drafts(
    status: str | None = None,
    agent: str | None = None,
    limit: int = 50,
    offset: int = 0,
) -> list[dict[str, Any]]:
    """
    Fetch drafts from the queue.
    status: 'queued' | 'approved' | 'edited' | 'killed' | 'sent' | 'replied'
    agent: filter by agent name
    """
    conditions = []
    params: list[Any] = []
    if status:
        conditions.append("d.status = %s")
        params.append(status)
    if agent:
        conditions.append("d.agent = %s")
        params.append(agent)

    where = ("WHERE " + " AND ".join(conditions)) if conditions else ""
    sql = f"""
        SELECT d.*, c.full_name, c.role, c.email, c.linkedin_url,
               a.org_name, a.vertical, a.geography
        FROM drafts d
        JOIN contacts c ON d.contact_id = c.id
        JOIN accounts a ON c.account_id = a.id
        {where}
        ORDER BY d.created_at DESC
        LIMIT %s OFFSET %s
    """
    params.extend([limit, offset])
    return _execute(sql, tuple(params), fetch=True)


@mcp.tool()
def create_draft(
    contact_id: str,
    agent: str,
    template_version: str,
    template_reason: str,
    draft_type: str,
    subject: str,
    body: str,
    hooks: list[dict[str, Any]],
    enrichment_json: dict[str, Any] | None = None,
    reasoning_trace: str | None = None,
) -> dict[str, Any]:
    """
    Write a new draft to the dashboard queue.
    Called by the Prospector and Follow-Up Tracker agents.
    """
    draft_id = str(uuid.uuid4())
    sql = """
        INSERT INTO drafts
            (id, contact_id, agent, template_version, template_reason,
             draft_type, subject, body, hooks, enrichment_json,
             reasoning_trace, created_at, status)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW(), 'queued')
        RETURNING id, created_at, status
    """
    rows = _execute(
        sql,
        (
            draft_id,
            contact_id,
            agent,
            template_version,
            template_reason,
            draft_type,
            subject,
            body,
            json.dumps(hooks),
            json.dumps(enrichment_json or {}),
            reasoning_trace,
        ),
        fetch=True,
    )
    return rows[0] if rows else {"id": draft_id}


@mcp.tool()
def update_draft_status(
    draft_id: str,
    status: str,
    kill_reason: str | None = None,
    edit_diff: str | None = None,
    sent_at: str | None = None,
    replied_at: str | None = None,
    reply_sentiment: str | None = None,
) -> dict[str, Any]:
    """
    Update draft status from dashboard actions.
    status: 'approved' | 'edited' | 'killed' | 'sent' | 'replied'
    """
    valid_statuses = {"approved", "edited", "killed", "sent", "replied"}
    if status not in valid_statuses:
        raise ValueError(f"Invalid status '{status}'. Must be one of {valid_statuses}")

    fields = ["status = %s", "decided_at = NOW()"]
    params: list[Any] = [status]

    if kill_reason is not None:
        fields.append("kill_reason = %s")
        params.append(kill_reason)
    if edit_diff is not None:
        fields.append("edit_diff = %s")
        params.append(edit_diff)
    if sent_at is not None:
        fields.append("sent_at = %s")
        params.append(sent_at)
    if replied_at is not None:
        fields.append("replied_at = %s")
        params.append(replied_at)
    if reply_sentiment is not None:
        fields.append("reply_sentiment = %s")
        params.append(reply_sentiment)

    params.append(draft_id)
    sql = f"UPDATE drafts SET {', '.join(fields)} WHERE id = %s RETURNING id, status"
    rows = _execute(sql, tuple(params), fetch=True)
    return rows[0] if rows else {"id": draft_id, "status": status}


# ---------------------------------------------------------------------------
# Voice profile
# ---------------------------------------------------------------------------

@mcp.tool()
def get_voice_profile() -> str:
    """Return the full content of /state/fortline-voice-profile.md."""
    path = os.path.join(os.path.dirname(__file__), "../state/fortline-voice-profile.md")
    with open(path, encoding="utf-8") as f:
        return f.read()


@mcp.tool()
def update_voice_profile(new_content: str) -> dict[str, Any]:
    """
    Overwrite /state/fortline-voice-profile.md with updated content.
    Called only by fortline-dreamer. Validates that key sections are present.
    """
    required_sections = [
        "## Template version → vertical mapping",
        "## Banned phrases",
        "## Trusted source domains",
    ]
    for section in required_sections:
        if section not in new_content:
            raise ValueError(f"Voice profile update missing required section: '{section}'")

    path = os.path.join(os.path.dirname(__file__), "../state/fortline-voice-profile.md")
    with open(path, "w", encoding="utf-8") as f:
        f.write(new_content)

    return {"updated": True, "path": path, "length": len(new_content)}


# ---------------------------------------------------------------------------
# ICP briefs
# ---------------------------------------------------------------------------

@mcp.tool()
def get_active_icp_briefs() -> str:
    """Return the content of /state/fortline-icp-briefs/active.md."""
    path = os.path.join(os.path.dirname(__file__), "../state/fortline-icp-briefs/active.md")
    with open(path, encoding="utf-8") as f:
        return f.read()


# ---------------------------------------------------------------------------
# Contact management
# ---------------------------------------------------------------------------

@mcp.tool()
def is_already_contacted(email: str | None = None, linkedin_url: str | None = None) -> dict[str, Any]:
    """
    Check whether a contact has been emailed in the last 120 days (cold queue exclusion).
    Returns: {contacted: bool, last_contacted_at: str | None, days_ago: int | None}
    """
    if not email and not linkedin_url:
        raise ValueError("Provide email or linkedin_url")

    conditions = []
    params: list[Any] = []
    if email:
        conditions.append("c.email ILIKE %s")
        params.append(email)
    if linkedin_url:
        conditions.append("c.linkedin_url ILIKE %s")
        params.append(linkedin_url)

    sql = f"""
        SELECT c.last_contacted_at,
               EXTRACT(DAY FROM NOW() - c.last_contacted_at)::INT AS days_ago
        FROM contacts c
        WHERE ({' OR '.join(conditions)})
          AND c.last_contacted_at IS NOT NULL
        ORDER BY c.last_contacted_at DESC
        LIMIT 1
    """
    rows = _execute(sql, tuple(params), fetch=True)
    if not rows:
        return {"contacted": False, "last_contacted_at": None, "days_ago": None}
    row = rows[0]
    days_ago: int = row.get("days_ago") or 0
    return {
        "contacted": days_ago < 120,
        "last_contacted_at": str(row["last_contacted_at"]),
        "days_ago": days_ago,
    }


@mcp.tool()
def upsert_contact(
    full_name: str,
    org_name: str,
    role: str,
    vertical: str,
    geography: str,
    email: str | None = None,
    linkedin_url: str | None = None,
    icp_fit_score: int | None = None,
    domain: str | None = None,
) -> dict[str, Any]:
    """
    Insert or update a contact and their parent account.
    Returns contact_id and account_id.
    """
    # Upsert account
    acc_id = str(uuid.uuid4())
    _execute(
        """
        INSERT INTO accounts (id, org_name, domain, vertical, geography, first_seen_at)
        VALUES (%s, %s, %s, %s, %s, NOW())
        ON CONFLICT (domain) DO UPDATE
            SET last_activity_at = NOW(),
                vertical = EXCLUDED.vertical,
                geography = EXCLUDED.geography
        """,
        (acc_id, org_name, domain or "", vertical, geography),
    )

    # Resolve actual account id (may differ if domain already existed)
    rows = _execute(
        "SELECT id FROM accounts WHERE domain = %s OR org_name ILIKE %s LIMIT 1",
        (domain or "", org_name),
        fetch=True,
    )
    account_id = rows[0]["id"] if rows else acc_id

    # Upsert contact
    contact_id = str(uuid.uuid4())
    _execute(
        """
        INSERT INTO contacts (id, account_id, full_name, role, email, linkedin_url, icp_fit_score)
        VALUES (%s, %s, %s, %s, %s, %s, %s)
        ON CONFLICT (email) WHERE email IS NOT NULL DO UPDATE
            SET full_name = EXCLUDED.full_name,
                role = EXCLUDED.role,
                linkedin_url = COALESCE(EXCLUDED.linkedin_url, contacts.linkedin_url),
                icp_fit_score = COALESCE(EXCLUDED.icp_fit_score, contacts.icp_fit_score)
        """,
        (contact_id, account_id, full_name, role, email, linkedin_url, icp_fit_score),
    )

    rows = _execute(
        "SELECT id FROM contacts WHERE email ILIKE %s OR linkedin_url ILIKE %s LIMIT 1",
        (email or "", linkedin_url or ""),
        fetch=True,
    )
    resolved_contact_id = rows[0]["id"] if rows else contact_id

    return {"contact_id": resolved_contact_id, "account_id": account_id}


@mcp.tool()
def add_to_blocklist(email: str, reason: str) -> dict[str, Any]:
    """Add an email address to the blocklist."""
    _execute(
        "INSERT INTO blocklist (email, reason, added_at) VALUES (%s, %s, NOW()) ON CONFLICT (email) DO NOTHING",
        (email, reason),
    )
    return {"blocklisted": True, "email": email}


# ---------------------------------------------------------------------------
# LinkedIn DM tracking
# ---------------------------------------------------------------------------

@mcp.tool()
def mark_dm_sent(draft_id: str) -> dict[str, Any]:
    """
    Mark a DM draft as sent (LinkedIn DMs are manually sent; dashboard tracks state).
    Updates draft status to 'sent' and records sent_at.
    """
    rows = _execute(
        "UPDATE drafts SET status = 'sent', sent_at = NOW(), decided_at = NOW() WHERE id = %s RETURNING id, status, sent_at",
        (draft_id,),
        fetch=True,
    )
    return rows[0] if rows else {"draft_id": draft_id, "status": "sent"}


# ---------------------------------------------------------------------------
# Metrics
# ---------------------------------------------------------------------------

@mcp.tool()
def upsert_weekly_metrics(
    week_starting: str,
    drafts_created: int = 0,
    drafts_sent: int = 0,
    replies_received: int = 0,
    meetings_booked: int = 0,
    template_v22_replies: int = 0,
    template_v21_replies: int = 0,
    template_v2_replies: int = 0,
    voice_profile_version: int = 1,
) -> dict[str, Any]:
    """Insert or update the weekly metrics row."""
    _execute(
        """
        INSERT INTO weekly_metrics
            (week_starting, drafts_created, drafts_sent, replies_received,
             meetings_booked, template_v22_replies, template_v21_replies,
             template_v2_replies, voice_profile_version)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
        ON CONFLICT (week_starting) DO UPDATE SET
            drafts_created = EXCLUDED.drafts_created,
            drafts_sent = EXCLUDED.drafts_sent,
            replies_received = EXCLUDED.replies_received,
            meetings_booked = EXCLUDED.meetings_booked,
            template_v22_replies = EXCLUDED.template_v22_replies,
            template_v21_replies = EXCLUDED.template_v21_replies,
            template_v2_replies = EXCLUDED.template_v2_replies,
            voice_profile_version = EXCLUDED.voice_profile_version
        """,
        (
            week_starting,
            drafts_created,
            drafts_sent,
            replies_received,
            meetings_booked,
            template_v22_replies,
            template_v21_replies,
            template_v2_replies,
            voice_profile_version,
        ),
    )
    return {"week_starting": week_starting, "updated": True}


@mcp.tool()
def get_weekly_metrics(weeks: int = 4) -> list[dict[str, Any]]:
    """Return the last N weeks of metrics for Dreamer analysis."""
    return _execute(
        "SELECT * FROM weekly_metrics ORDER BY week_starting DESC LIMIT %s",
        (weeks,),
        fetch=True,
    )


# ---------------------------------------------------------------------------
# Source URL reputation
# ---------------------------------------------------------------------------

@mcp.tool()
def update_source_reputation(
    domain: str,
    event: str,  # 'used' | 'killed' | 'trusted' | 'untrusted'
) -> dict[str, Any]:
    """Update source URL reputation tracking for Dreamer analysis."""
    if event == "used":
        _execute(
            """
            INSERT INTO source_url_reputation (domain, status, times_used)
            VALUES (%s, 'unknown', 1)
            ON CONFLICT (domain) DO UPDATE
                SET times_used = source_url_reputation.times_used + 1,
                    last_decided_at = NOW()
            """,
            (domain,),
        )
    elif event == "killed":
        _execute(
            """
            INSERT INTO source_url_reputation (domain, status, times_killed_due_to_source)
            VALUES (%s, 'unknown', 1)
            ON CONFLICT (domain) DO UPDATE
                SET times_killed_due_to_source = source_url_reputation.times_killed_due_to_source + 1,
                    last_decided_at = NOW()
            """,
            (domain,),
        )
    elif event in ("trusted", "untrusted"):
        _execute(
            """
            INSERT INTO source_url_reputation (domain, status)
            VALUES (%s, %s)
            ON CONFLICT (domain) DO UPDATE
                SET status = EXCLUDED.status,
                    last_decided_at = NOW()
            """,
            (domain, event),
        )
    return {"domain": domain, "event": event, "updated": True}


# ---------------------------------------------------------------------------
# Entry point
# ---------------------------------------------------------------------------

if __name__ == "__main__":
    mcp.run()
