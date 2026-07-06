"""Email signature for the Hatul mailbox (Eddie Nudel).

Reproduces the brand signature card layout: the "חתול פיננסי" cat-logo lockup
on the left, a gold vertical divider, then name / title and the contact block.

The logo is embedded inline from ``assets/logo.png`` (see send_email.py). When
that file is absent the layout falls back to the brand name as text so the rest
of the signature still renders.
"""
from __future__ import annotations

# --- Signature fields --------------------------------------------------------
NAME = "Eddie Nudel"
TITLE = "VP Marketing"
COMPANY = "חתול פיננסי"  # Hatul Financy
MOBILE = "054-3203976"
WEBSITES = [
    ("www.moneyplan.co.il", "https://www.moneyplan.co.il"),
    ("www.fincat.co.il", "https://www.fincat.co.il"),
]
FACEBOOK_LABEL = "facebook.com/groups/hatulfinancy"
FACEBOOK_URL = "https://www.facebook.com/groups/hatulfinancy/"

# Brand accent — the gold of the logo mark and the divider bar.
ACCENT = "#F5B301"
NAME_COLOR = "#262626"
TITLE_COLOR = "#8c8c8c"
LINK_COLOR = "#262626"


def _text_signature() -> str:
    sites = ", ".join(label for label, _ in WEBSITES)
    return (
        "\n--\n"
        f"{NAME}\n"
        f"{TITLE} | {COMPANY}\n"
        f"M: {MOBILE}\n"
        f"W: {sites}\n"
        f"F: {FACEBOOK_URL}\n"
    )


def _logo_cell(logo_cid: str | None) -> str:
    """Left cell: the cat-logo lockup, or a text fallback when absent."""
    if logo_cid:
        return (
            f'<img src="cid:{logo_cid}" width="120" '
            f'alt="{COMPANY}" style="display:block;border:0;">'
        )
    return (
        f'<div style="font-size:20px;font-weight:bold;color:{NAME_COLOR};'
        f'direction:rtl;">חתו<span style="color:{ACCENT};">ל</span> '
        f'פיננסי</div>'
    )


def _html_signature(logo_cid: str | None = None) -> str:
    sites_html = ", ".join(
        f'<a href="{url}" style="color:{LINK_COLOR};text-decoration:underline;">'
        f'{label}</a>'
        for label, url in WEBSITES
    )
    a = 'style="color:{c};text-decoration:underline;"'.format(c=LINK_COLOR)
    return f"""\
<br>
<table cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;">
  <tr>
    <td style="padding-right:22px;vertical-align:middle;text-align:center;">
      {_logo_cell(logo_cid)}
    </td>
    <td style="padding-left:22px;border-left:3px solid {ACCENT};vertical-align:middle;font-size:14px;color:{NAME_COLOR};line-height:1.5;">
      <div style="font-size:18px;font-weight:bold;color:{NAME_COLOR};">{NAME}</div>
      <div style="color:{TITLE_COLOR};padding-bottom:10px;">{TITLE}</div>
      <div><strong>M:</strong> {MOBILE}</div>
      <div><strong>W:</strong> {sites_html}</div>
      <div><strong>F:</strong> <a href="{FACEBOOK_URL}" {a}>{FACEBOOK_LABEL}</a></div>
    </td>
  </tr>
</table>
"""


TEXT_SIGNATURE = _text_signature()


def html_signature(logo_cid: str | None = None) -> str:
    """HTML signature; pass the inline logo's Content-ID to embed the image."""
    return _html_signature(logo_cid)


def append(body: str, *, html: bool, logo_cid: str | None = None) -> str:
    """Return body with the signature appended."""
    if html:
        return body + html_signature(logo_cid)
    return body + TEXT_SIGNATURE
