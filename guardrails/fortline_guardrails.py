"""
Fortline Global — Draft Guardrails
Fail-closed: a draft that cannot pass after 2 regeneration attempts is skipped.
"""

from __future__ import annotations

import re
import urllib.request
from dataclasses import dataclass, field
from typing import Any

# ---------------------------------------------------------------------------
# Banned phrases
# ---------------------------------------------------------------------------

BANNED_PHRASES_BASE = [
    "I hope this email finds you well",
    "circle back",
    "synergies",
]

BANNED_PHRASES_FORTLINE = [
    "guarantee",
    "100% protection",
    "fully protected",
    "secure your",
    "we can stop",
    "act now",
    "before it's too late",
    "next attack",
    # em-dash and en-dash (also checked by character)
    "—",
    "–",
]

# Runtime-extended by Dreamer; loaded from voice profile on startup
_runtime_banned: list[str] = []


def load_runtime_banned(phrases: list[str]) -> None:
    global _runtime_banned
    _runtime_banned = [p.lower() for p in phrases]


def _all_banned() -> list[str]:
    return [p.lower() for p in BANNED_PHRASES_BASE + BANNED_PHRASES_FORTLINE] + _runtime_banned


# ---------------------------------------------------------------------------
# Word-length limits per template version
# ---------------------------------------------------------------------------

BODY_WORD_LIMITS: dict[str, int] = {
    "v2.2": 140,
    "v2.1": 120,
    "v2": 130,
}

# ---------------------------------------------------------------------------
# Trusted / untrusted domains
# These lists are the in-memory baseline; the DB is the authoritative store.
# Dreamer auto-grows them. At startup, load from DB and call load_domain_lists().
# ---------------------------------------------------------------------------

TRUSTED_DOMAINS_DEFAULT = {
    "reuters.com",
    "bloomberg.com",
    "ft.com",
    "wsj.com",
    "thenational.ae",
    "gulfnews.com",
    "khaleejtimes.com",
    "haaretz.com",
    "timesofisrael.com",
    "janes.com",
    "defensenews.com",
    "linkedin.com",
    "arabianbusiness.com",
    "zawya.com",
    "constructionweekline.com",
    "hospitalitynet.org",
    "hotelnewsme.com",
    "aviationweek.com",
}

UNTRUSTED_DOMAINS_DEFAULT: set[str] = set()

_trusted_domains: set[str] = set(TRUSTED_DOMAINS_DEFAULT)
_untrusted_domains: set[str] = set(UNTRUSTED_DOMAINS_DEFAULT)


def load_domain_lists(trusted: list[str], untrusted: list[str]) -> None:
    _trusted_domains.update(d.lower() for d in trusted)
    _untrusted_domains.update(d.lower() for d in untrusted)


def domain_trust(url: str) -> str:
    """Return 'trusted', 'untrusted', or 'unknown'."""
    try:
        from urllib.parse import urlparse
        host = urlparse(url).hostname or ""
        host = host.lower().removeprefix("www.")
        if host in _trusted_domains:
            return "trusted"
        if host in _untrusted_domains:
            return "untrusted"
        # Check suffix match (e.g. 'bloomberg.com' matches 'www.bloomberg.com')
        for d in _trusted_domains:
            if host.endswith("." + d) or host == d:
                return "trusted"
        for d in _untrusted_domains:
            if host.endswith("." + d) or host == d:
                return "untrusted"
    except Exception:
        pass
    return "unknown"


# ---------------------------------------------------------------------------
# HTTP reachability check
# ---------------------------------------------------------------------------

def is_url_reachable(url: str, timeout: int = 8) -> bool:
    try:
        req = urllib.request.Request(
            url,
            headers={"User-Agent": "Mozilla/5.0 (compatible; FortlineBot/1.0)"},
        )
        with urllib.request.urlopen(req, timeout=timeout) as resp:
            return resp.status == 200
    except Exception:
        return False


# ---------------------------------------------------------------------------
# Core validation dataclass
# ---------------------------------------------------------------------------

@dataclass
class GuardrailResult:
    passed: bool
    failures: list[str] = field(default_factory=list)

    def __bool__(self) -> bool:
        return self.passed


# ---------------------------------------------------------------------------
# Main check function
# ---------------------------------------------------------------------------

def check_draft(
    *,
    body: str,
    subject: str,
    template_version: str,
    hooks: list[dict[str, Any]],
    draft_type: str = "email_cold",
    skip_url_fetch: bool = False,
) -> GuardrailResult:
    """
    Run all Fortline guardrails against a draft.

    hooks: list of {"hook": str, "source_url": str}
    draft_type: used to skip email-only checks for DM drafts
    skip_url_fetch: set True in tests / offline environments
    """
    failures: list[str] = []
    text_lower = body.lower()
    full_text_lower = (subject + " " + body).lower()

    # 1. Banned phrases
    for phrase in _all_banned():
        if phrase in full_text_lower:
            failures.append(f"Banned phrase detected: '{phrase}'")

    # 2. Every factual hook must cite a source URL
    for i, hook in enumerate(hooks):
        if not hook.get("source_url"):
            failures.append(f"Hook {i + 1} missing source_url: '{hook.get('hook', '')[:60]}'")

    # 3. Source URL reachability (HTTP 200)
    if not skip_url_fetch:
        for hook in hooks:
            url = hook.get("source_url", "")
            if url and not is_url_reachable(url):
                failures.append(f"Source URL not reachable (non-200): {url}")

    # 4. Source domain trust check — flag untrusted (does not hard-fail, flags for review)
    for hook in hooks:
        url = hook.get("source_url", "")
        if url:
            trust = domain_trust(url)
            hook["domain_trust"] = trust
            if trust == "untrusted":
                failures.append(f"Source URL from untrusted domain: {url}")

    # 5. Body word count
    if draft_type.startswith("email") or draft_type == "dm_long":
        word_count = len(re.findall(r"\S+", body))
        limit = BODY_WORD_LIMITS.get(template_version, 140)
        if word_count > limit:
            failures.append(
                f"Body too long: {word_count} words (limit {limit} for {template_version})"
            )

    # 6. Exactly one ask (CTA) — heuristic: count "?"s that look like asks
    question_marks = body.count("?")
    if question_marks == 0 and draft_type.startswith("email"):
        failures.append("No CTA / ask found in draft (no question mark detected)")
    elif question_marks > 2:
        failures.append(f"Multiple CTAs detected ({question_marks} question marks) — exactly one ask required")

    # 7. Correct signature
    if draft_type.startswith("email") and "Eddie Nudel | Strategic Advisor | Fortline Global" not in body:
        failures.append("Missing correct signature: 'Eddie Nudel | Strategic Advisor | Fortline Global'")

    # 8. No exclamation marks
    if "!" in body or "!" in subject:
        failures.append("Exclamation mark found — prohibited")

    # 9. No emojis
    emoji_pattern = re.compile(
        "[\U0001F300-\U0001F9FF"
        "\U00002600-\U000027BF"
        "\U0001FA00-\U0001FA6F"
        "\U0001FA70-\U0001FAFF]+",
        flags=re.UNICODE,
    )
    if emoji_pattern.search(body) or emoji_pattern.search(subject):
        failures.append("Emoji found — prohibited")

    # 10. No em-dash or en-dash characters (belt-and-suspenders, also in banned phrases)
    if "—" in body or "–" in body:
        failures.append("Em-dash or en-dash character found — prohibited")

    return GuardrailResult(passed=len(failures) == 0, failures=failures)


# ---------------------------------------------------------------------------
# Volume guard checks (called at run level, not draft level)
# ---------------------------------------------------------------------------

def check_volume(
    *,
    drafts_this_run: int,
    agent: str,
    drafts_this_week: int,
    contact_last_cold_days: int | None,
    org_last_contact_days: int | None,
) -> GuardrailResult:
    failures = []

    if agent == "fortline-prospector":
        if drafts_this_run >= 12:
            failures.append("Volume cap reached: max 12 cold drafts per Prospector run")
        if drafts_this_week >= 60:
            failures.append("Weekly cold draft cap reached: max 60 cold drafts per week")

    if agent == "fortline-followup-tracker":
        if drafts_this_run >= 15:
            failures.append("Volume cap reached: max 15 follow-up drafts per Follow-Up run")

    if contact_last_cold_days is not None and contact_last_cold_days < 120:
        failures.append(
            f"Contact emailed too recently: {contact_last_cold_days}d ago (min 120d for cold outreach)"
        )

    if org_last_contact_days is not None and org_last_contact_days < 60:
        failures.append(
            f"Org contacted too recently: {org_last_contact_days}d ago (min 60d per org)"
        )

    return GuardrailResult(passed=len(failures) == 0, failures=failures)
