#!/usr/bin/env python3
"""Score target customer scenarios against the Market Development Strategy Checklist.

Implements the two-stage selection process from Geoffrey Moore's *Crossing the Chasm*
(3rd ed., ch. 4):

  Stage 1 — four showstoppers: target customer, compelling reason to buy, whole product,
            competition. Rated 1-5. Total 4-20. A very low score on any single showstopper
            is, on its own, usually disqualifying for a beachhead.
  Stage 2 — five nice-to-haves: partners and allies, distribution, pricing, positioning,
            next target customer. Rated 1-5. Total 5-25. Low scores here are recoverable
            with time and money.

Ties are broken by compelling reason to buy, per Moore: "When in doubt, favor scenarios that
have a high-rated compelling reason to buy."

Usage:
    python3 score_scenarios.py scorecard.csv
    python3 score_scenarios.py scorecard.csv --html beachhead-scorecard.html
    python3 score_scenarios.py scorecard.csv --veto-threshold 2 --keep 4
    python3 score_scenarios.py scorecard.csv --no-veto

Input CSV columns (header required; scenario_id and scenario_name plus the nine factors):
    scenario_id,scenario_name,
    target_customer,compelling_reason,whole_product,competition,
    partners_allies,distribution,pricing,positioning,next_target

See ../assets/target-market-scorecard.csv for a filled example.
"""

from __future__ import annotations

import argparse
import csv
import html
import math
import sys
from dataclasses import dataclass, field

SHOWSTOPPERS = [
    ("target_customer", "Target customer"),
    ("compelling_reason", "Compelling reason to buy"),
    ("whole_product", "Whole product"),
    ("competition", "Competition"),
]

NICE_TO_HAVES = [
    ("partners_allies", "Partners and allies"),
    ("distribution", "Distribution"),
    ("pricing", "Pricing"),
    ("positioning", "Positioning"),
    ("next_target", "Next target customer"),
]

ALL_FACTORS = SHOWSTOPPERS + NICE_TO_HAVES


@dataclass
class Scenario:
    sid: str
    name: str
    scores: dict[str, int]
    vetoes: list[str] = field(default_factory=list)
    eliminated_by_veto: bool = False
    made_cut: bool = False
    rank: int | None = None

    @property
    def stage1(self) -> int:
        return sum(self.scores[k] for k, _ in SHOWSTOPPERS)

    @property
    def stage2(self) -> int:
        return sum(self.scores[k] for k, _ in NICE_TO_HAVES)

    @property
    def total(self) -> int:
        return self.stage1 + self.stage2


def load(path: str) -> list[Scenario]:
    with open(path, newline="", encoding="utf-8") as fh:
        reader = csv.DictReader(fh)
        if reader.fieldnames is None:
            sys.exit(f"{path}: empty file")
        missing = [k for k, _ in ALL_FACTORS if k not in reader.fieldnames]
        if missing:
            sys.exit(f"{path}: missing required column(s): {', '.join(missing)}")

        scenarios: list[Scenario] = []
        for lineno, row in enumerate(reader, start=2):
            if not any((v or "").strip() for v in row.values()):
                continue
            scores: dict[str, int] = {}
            for key, label in ALL_FACTORS:
                raw = (row.get(key) or "").strip()
                try:
                    value = int(raw)
                except ValueError:
                    sys.exit(f"{path}:{lineno}: {key} is '{raw}', expected an integer 1-5")
                if not 1 <= value <= 5:
                    sys.exit(f"{path}:{lineno}: {key} is {value}, expected 1-5")
                scores[key] = value
            scenarios.append(
                Scenario(
                    sid=(row.get("scenario_id") or str(lineno - 1)).strip(),
                    name=(row.get("scenario_name") or f"Scenario {lineno - 1}").strip(),
                    scores=scores,
                )
            )
    if not scenarios:
        sys.exit(f"{path}: no scenario rows found")
    return scenarios


def evaluate(scenarios: list[Scenario], veto_threshold: int, apply_veto: bool,
             keep: int | None) -> list[Scenario]:
    for s in scenarios:
        s.vetoes = [label for key, label in SHOWSTOPPERS
                    if s.scores[key] <= veto_threshold]
        s.eliminated_by_veto = apply_veto and bool(s.vetoes)

    # Stage 1 ranking. Moore's tiebreak: higher compelling reason to buy.
    order = sorted(
        scenarios,
        key=lambda s: (-s.stage1, -s.scores["compelling_reason"], s.sid),
    )

    survivors = [s for s in order if not s.eliminated_by_veto]
    # Moore: roughly two-thirds of submissions fall out at the first cut.
    limit = keep if keep is not None else max(1, math.ceil(len(scenarios) / 3))
    for s in survivors[:limit]:
        s.made_cut = True

    finalists = sorted(
        [s for s in scenarios if s.made_cut],
        key=lambda s: (-(s.total), -s.stage1, -s.scores["compelling_reason"], s.sid),
    )
    for i, s in enumerate(finalists, start=1):
        s.rank = i
    return order


def status(s: Scenario) -> str:
    if s.eliminated_by_veto:
        return "VETO"
    if s.made_cut:
        return f"FINALIST #{s.rank}"
    return "cut"


def print_report(order: list[Scenario], veto_threshold: int, apply_veto: bool) -> None:
    width = max(len(s.name) for s in order)
    width = min(max(width, 20), 44)

    print()
    print("MARKET DEVELOPMENT STRATEGY CHECKLIST — SCENARIO SCORING")
    print("=" * (width + 46))
    header = f"{'#':<4}{'Scenario':<{width}}  {'S1/20':>6} {'S2/25':>6} {'Tot/45':>7}  Status"
    print(header)
    print("-" * (width + 46))
    for s in order:
        print(f"{s.sid:<4}{s.name[:width]:<{width}}  "
              f"{s.stage1:>6} {s.stage2:>6} {s.total:>7}  {status(s)}")
    print("-" * (width + 46))

    vetoed = [s for s in order if s.vetoes]
    if vetoed:
        print()
        label = "ELIMINATED" if apply_veto else "FLAGGED (veto not applied)"
        print(f"SHOWSTOPPER {label} — scored <= {veto_threshold} on a showstopper:")
        for s in vetoed:
            print(f"  [{s.sid}] {s.name}: {', '.join(s.vetoes)}")
        print("  Moore: a very low relative score on any one showstopper is almost always")
        print("  disqualifying for the beachhead. These may still be good niches later.")

    finalists = sorted((s for s in order if s.made_cut), key=lambda s: s.rank or 0)
    if finalists:
        print()
        print("FINALISTS, RANKED:")
        for s in finalists:
            weakest_key, weakest_label = min(
                SHOWSTOPPERS, key=lambda kv: s.scores[kv[0]]
            )
            print(f"  #{s.rank} [{s.sid}] {s.name}")
            print(f"      showstoppers {s.stage1}/20, nice-to-haves {s.stage2}/25, "
                  f"total {s.total}/45")
            print(f"      weakest showstopper: {weakest_label} "
                  f"({s.scores[weakest_key]}/5) — this is the risk to name out loud")
        top = finalists[0]
        print()
        print(f"RECOMMENDED BEACHHEAD: [{top.sid}] {top.name}")
        print("  Commit to one — and only one. Put the runners-up on the bowling-pin list.")
    print()


def render_html(order: list[Scenario], out_path: str, source: str,
                veto_threshold: int, apply_veto: bool) -> None:
    def esc(x: object) -> str:
        return html.escape(str(x))

    def cell(s: Scenario, key: str) -> str:
        v = s.scores[key]
        cls = "s-lo" if v <= 2 else ("s-mid" if v == 3 else "s-hi")
        return f'<td class="num {cls}">{v}</td>'

    rows = []
    for s in order:
        if s.eliminated_by_veto:
            row_cls, badge = "veto", '<span class="badge b-veto">veto</span>'
        elif s.made_cut:
            row_cls, badge = "finalist", f'<span class="badge b-fin">#{s.rank}</span>'
        else:
            row_cls, badge = "cutrow", '<span class="badge b-cut">cut</span>'
        cells = "".join(cell(s, k) for k, _ in SHOWSTOPPERS)
        cells += f'<td class="num sub">{s.stage1}</td>'
        cells += "".join(cell(s, k) for k, _ in NICE_TO_HAVES)
        cells += f'<td class="num sub">{s.stage2}</td>'
        cells += f'<td class="num tot">{s.total}</td>'
        rows.append(
            f'<tr class="{row_cls}"><td class="sid">{esc(s.sid)}</td>'
            f'<td class="nm">{esc(s.name)}</td>{cells}<td>{badge}</td></tr>'
        )

    finalists = sorted((s for s in order if s.made_cut), key=lambda s: s.rank or 0)
    if finalists:
        top = finalists[0]
        wk_key, wk_label = min(SHOWSTOPPERS, key=lambda kv: top.scores[kv[0]])
        rec = (
            f'<div class="rec"><div class="rec-k">Recommended beachhead</div>'
            f'<div class="rec-v">{esc(top.name)}</div>'
            f'<div class="rec-n">Showstoppers {top.stage1}/20 &middot; '
            f'nice-to-haves {top.stage2}/25 &middot; total {top.total}/45. '
            f'Weakest showstopper: {esc(wk_label)} ({top.scores[wk_key]}/5) — '
            f'name this risk out loud. Commit to one beachhead only; the runners-up are '
            f'bowling pins, not parallel bets.</div></div>'
        )
    else:
        rec = ('<div class="rec"><div class="rec-k">No finalist</div>'
               '<div class="rec-n">Every scenario tripped a showstopper. Build more '
               'scenarios, or re-scope the ones you have.</div></div>')

    head = "".join(f'<th class="rot">{esc(l)}</th>' for _, l in SHOWSTOPPERS)
    head += '<th class="rot sub">Stage 1</th>'
    head += "".join(f'<th class="rot">{esc(l)}</th>' for _, l in NICE_TO_HAVES)
    head += '<th class="rot sub">Stage 2</th><th class="rot tot">Total</th>'

    veto_note = (
        f"Scenarios scoring {veto_threshold} or below on any showstopper are "
        + ("eliminated" if apply_veto else "flagged only")
        + "."
    )

    doc = f"""<!doctype html>
<html lang="en"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Beachhead Scorecard</title>
<style>
:root {{
  --bg:#fbfaf8; --panel:#ffffff; --ink:#1c1b19; --muted:#6b6660; --line:#e4e0da;
  --hi:#1f6f4a; --mid:#8a6d1f; --lo:#a33a2a; --accent:#1a4f7a;
  --fin:#1f6f4a; --cut:#8f8a83; --vetoc:#a33a2a;
}}
@media (prefers-color-scheme: dark) {{
  :root:not([data-theme="light"]) {{
    --bg:#15161a; --panel:#1d1f24; --ink:#eceae6; --muted:#9a958d; --line:#2f3238;
    --hi:#61c295; --mid:#d8b45c; --lo:#e08b7a; --accent:#7bb6e8;
    --fin:#61c295; --cut:#8a857e; --vetoc:#e08b7a;
  }}
}}
:root[data-theme="dark"] {{
  --bg:#15161a; --panel:#1d1f24; --ink:#eceae6; --muted:#9a958d; --line:#2f3238;
  --hi:#61c295; --mid:#d8b45c; --lo:#e08b7a; --accent:#7bb6e8;
  --fin:#61c295; --cut:#8a857e; --vetoc:#e08b7a;
}}
* {{ box-sizing:border-box; }}
body {{ margin:0; background:var(--bg); color:var(--ink);
  font:15px/1.55 ui-sans-serif,-apple-system,"Segoe UI",Helvetica,Arial,sans-serif; }}
.wrap {{ max-width:1120px; margin:0 auto; padding:40px 24px 64px; }}
h1 {{ font-size:26px; letter-spacing:-.02em; margin:0 0 4px; }}
.sub-t {{ color:var(--muted); font-size:14px; margin:0 0 28px; }}
.rec {{ background:var(--panel); border:1px solid var(--line); border-left:4px solid var(--accent);
  border-radius:8px; padding:18px 20px; margin:0 0 28px; }}
.rec-k {{ text-transform:uppercase; letter-spacing:.09em; font-size:11px; color:var(--muted); }}
.rec-v {{ font-size:21px; font-weight:650; margin:4px 0 8px; }}
.rec-n {{ color:var(--muted); font-size:14px; }}
.scroll {{ overflow-x:auto; border:1px solid var(--line); border-radius:8px; background:var(--panel); }}
table {{ border-collapse:collapse; width:100%; font-size:13px; }}
th,td {{ padding:9px 8px; border-bottom:1px solid var(--line); text-align:left; white-space:nowrap; }}
thead th {{ position:sticky; top:0; background:var(--panel); font-size:11px; font-weight:600;
  text-transform:uppercase; letter-spacing:.05em; color:var(--muted); vertical-align:bottom; }}
td.num, th.rot {{ text-align:center; }}
td.sid {{ color:var(--muted); font-variant-numeric:tabular-nums; }}
td.nm {{ font-weight:550; white-space:normal; min-width:200px; }}
td.num {{ font-variant-numeric:tabular-nums; }}
.s-hi {{ color:var(--hi); font-weight:650; }}
.s-mid {{ color:var(--mid); }}
.s-lo {{ color:var(--lo); font-weight:650; }}
.sub {{ background:color-mix(in srgb, var(--accent) 7%, transparent); font-weight:650; }}
.tot {{ background:color-mix(in srgb, var(--accent) 12%, transparent); font-weight:700; }}
tr.veto td.nm {{ text-decoration:line-through; color:var(--muted); }}
tr.cutrow {{ opacity:.62; }}
.badge {{ font-size:11px; padding:2px 8px; border-radius:99px; font-weight:650;
  border:1px solid currentColor; }}
.b-fin {{ color:var(--fin); }} .b-cut {{ color:var(--cut); }} .b-veto {{ color:var(--vetoc); }}
.notes {{ margin-top:26px; color:var(--muted); font-size:13px; }}
.notes li {{ margin:5px 0; }}
</style></head><body><div class="wrap">
<h1>Beachhead Scorecard</h1>
<p class="sub-t">Market Development Strategy Checklist &mdash; <em>Crossing the Chasm</em>,
Geoffrey A. Moore, ch. 4. Source: {esc(source)}</p>
{rec}
<div class="scroll"><table>
<thead><tr><th>#</th><th>Scenario</th>{head}<th>Status</th></tr></thead>
<tbody>{''.join(rows)}</tbody>
</table></div>
<ul class="notes">
<li>Stage 1 showstoppers are rated 1&ndash;5; total ranges 4&ndash;20. {esc(veto_note)}</li>
<li>Stage 2 factors are recoverable with time and money &mdash; both scarce, so cheaper and
sooner still wins.</li>
<li>Ties break toward the higher compelling reason to buy.</li>
<li>Expect the best scenario to be whole-product challenged. If it were easy, someone would
already have done it &mdash; and the difficulty becomes your barrier to entry.</li>
<li>Commit to one beachhead. You cannot cross the chasm in two places.</li>
</ul>
</div></body></html>"""

    with open(out_path, "w", encoding="utf-8") as fh:
        fh.write(doc)


def main() -> None:
    ap = argparse.ArgumentParser(description=__doc__,
                                 formatter_class=argparse.RawDescriptionHelpFormatter)
    ap.add_argument("csv_path", help="scorecard CSV (see assets/target-market-scorecard.csv)")
    ap.add_argument("--html", metavar="PATH", help="also write a shareable HTML scorecard")
    ap.add_argument("--veto-threshold", type=int, default=2, metavar="N",
                    help="showstopper score at or below which a scenario is vetoed (default 2)")
    ap.add_argument("--no-veto", action="store_true",
                    help="flag low showstoppers but do not eliminate on them")
    ap.add_argument("--keep", type=int, metavar="N",
                    help="how many scenarios survive the first cut "
                         "(default: one third, rounded up)")
    args = ap.parse_args()

    if not 1 <= args.veto_threshold <= 4:
        sys.exit("--veto-threshold must be between 1 and 4")

    scenarios = load(args.csv_path)
    apply_veto = not args.no_veto
    order = evaluate(scenarios, args.veto_threshold, apply_veto, args.keep)
    print_report(order, args.veto_threshold, apply_veto)

    if args.html:
        render_html(order, args.html, args.csv_path, args.veto_threshold, apply_veto)
        print(f"HTML scorecard written to {args.html}\n")


if __name__ == "__main__":
    try:
        main()
    except BrokenPipeError:  # e.g. piped into head
        sys.stdout = None
        sys.exit(0)
