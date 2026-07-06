"""Email signature for the Hatul mailbox (Eddie Nudel).

Exposes a plain-text and an HTML signature plus helpers that append the
appropriate one to a message body. Edit the fields below to update the
signature everywhere.
"""
from __future__ import annotations

# --- Signature fields --------------------------------------------------------
NAME = "Eddie Nudel"
TITLE = "VP Marketing"
COMPANY = "חתול פיננסי"  # Hatul Financy
MOBILE = "054-3203976"
EMAIL = "cat@fincat.co.il"
WEBSITES = [
    ("www.moneyplan.co.il", "https://www.moneyplan.co.il"),
    ("www.fincat.co.il", "https://www.fincat.co.il"),
]
FACEBOOK = "https://www.facebook.com/groups/hatulfinancy/"

# Accent colour taken from the brand mark (the yellow divider / logo accent).
ACCENT = "#F2B705"


def _text_signature() -> str:
    sites = ", ".join(label for label, _ in WEBSITES)
    return (
        "\n--\n"
        f"{NAME}\n"
        f"{TITLE} | {COMPANY}\n"
        f"M: {MOBILE}\n"
        f"E: {EMAIL}\n"
        f"W: {sites}\n"
        f"F: {FACEBOOK}\n"
    )


def _html_signature() -> str:
    sites_html = ", ".join(
        f'<a href="{url}" style="color:#1a1a1a;">{label}</a>'
        for label, url in WEBSITES
    )
    # NOTE: to include the real cat logo, host the image and drop an
    # <img src="https://.../logo.png" width="64" alt="{COMPANY}"> into the
    # left cell below (the CSP-safe placeholder is the accent bar for now).
    return f"""
<br>
<table cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#1a1a1a;border-collapse:collapse;">
  <tr>
    <td style="padding-right:14px;border-right:3px solid {ACCENT};vertical-align:top;">
      <div style="font-weight:bold;font-size:15px;">{NAME}</div>
      <div style="color:#666;">{TITLE}</div>
    </td>
    <td style="padding-left:14px;vertical-align:top;line-height:1.6;">
      <div><strong>M:</strong> {MOBILE}</div>
      <div><strong>E:</strong> <a href="mailto:{EMAIL}" style="color:#1a1a1a;">{EMAIL}</a></div>
      <div><strong>W:</strong> {sites_html}</div>
      <div><strong>F:</strong> <a href="{FACEBOOK}" style="color:#1a1a1a;">facebook.com/groups/hatulfinancy</a></div>
      <div style="margin-top:6px;color:{ACCENT};font-weight:bold;direction:rtl;">{COMPANY}</div>
    </td>
  </tr>
</table>
"""


TEXT_SIGNATURE = _text_signature()
HTML_SIGNATURE = _html_signature()


def append(body: str, *, html: bool) -> str:
    """Return body with the signature appended."""
    return body + (HTML_SIGNATURE if html else TEXT_SIGNATURE)
