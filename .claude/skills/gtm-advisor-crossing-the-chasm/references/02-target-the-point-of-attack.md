# 2. Target the Point of Attack — Choosing the Beachhead

Source: *Crossing the Chasm*, 3rd ed., chapters 3–4 (The D-Day Analogy, Target the Point of Attack).

## The D-Day frame

The strategy is an invasion, not a rollout. Concentrate an overwhelmingly superior force on a
highly constrained target, take it completely, and use it as the base for everything after.
Normandy, not a broad front.

Four consequences that clients resist:

1. **The target is deliberately small.** Small enough that you can be the undisputed leader
   within months. If the segment is big enough to be comfortable, it is too big to dominate.
2. **You cross in exactly one place.** Moore is unusually blunt about this — you cannot cross
   the chasm in two places, and the most-asked question of the Chasm Group has one answer: no.
3. **The point is the base, not the prize.** Crossing the chasm is the beginning of mainstream
   market development, not the end.
4. **It is a high-risk, low-data decision.** You will never have enough data. Pick anyway. The
   greater risk is the drift of not picking.

## Informed intuition over analysis

Moore's argument: numerical analysis needs data that does not exist yet, and formal segmentation
surveys are slow and produce dry output nobody acts on. The alternative is *informed intuition* —
structured, disciplined use of vivid concrete images drawn from the experience of people who
face customers.

Practically: get 8–15 field-savvy people in a room for a day and harvest anecdotes. The
anecdotes will contain fictions and prejudices. They are still, at this stage, more accurate and
far more useful than SIC codes.

## Target CUSTOMER characterization, not target market

The single most common failure: teams start with a market ("the mid-market CRM market") instead
of a customer. Market names evoke no images, elicit no intuition, and describe sets of
competitors rather than populations of buyers.

So invent people. Build a library of one-page scenarios, one per distinct customer type and
application. Keep going until new scenarios are only minor variations on existing ones — Moore
notes that somewhere between twenty and fifty you find you actually have eight to ten distinct
alternatives.

Each scenario has three parts (template: `assets/scenario-template.md`):

1. **A day in the life — before.** Named person, real job title, the moment the broken process
   bites. Include the emotional texture; it is what makes the scenario memorable and therefore
   usable.
2. **The economic consequence.** What the broken process costs, in money, risk, or time, to a
   named budget holder. This is what turns a nuisance into a compelling reason to buy.
3. **A day in the life — after.** The same moment with the whole product in place, and the
   payoff, stated the way the buyer would state it.

## The Market Development Strategy Checklist

Score every scenario against nine factors, in two stages, 1–5 each.

### Stage 1 — the four showstoppers

A low relative score on any one of these disqualifies the scenario as a *beachhead* (it may
still be a fine niche later).

**Target customer** — Is there a single, identifiable economic buyer for this offer, reachable
by the channel we intend to use, and funded well enough to pay for the whole product?
*Score 1 when:* the buyer is a committee, or has to be assembled from several budget holders, or
cannot be reached by our channel. Without one buyer, sales cycles drag and the project can die
at any moment.

**Compelling reason to buy** — Are the economic consequences severe enough that a reasonable
economic buyer is *anxious* to fix this now?
*Score 1 when:* the customer can live with the problem for another year. They will. And they will
keep inviting your salespeople back, because they learn something and buy nothing. "Great
presentation!" means "I learned more and didn't have to buy."
*This is the tiebreaker factor.* When two scenarios score close, take the one with the higher
compelling reason to buy.

**Whole product** — Can we, with partners and allies, field a *complete* solution to that
compelling reason to buy within about three months — in market by end of next quarter,
dominating within twelve months after?
*Expect the best scenarios to be whole-product challenged.* If it were easy, someone would have
done it. The difficulty becomes your barrier to entry once you step up to it.

**Competition** — Has someone already crossed into this space and occupied it? Dick Hackborn's
rule, quoted by Moore: never attack a fortified hill. If a competitor got there first, every
dynamic you are trying to create is already working for them. Go elsewhere, or find an end-run.

Worst possible Stage-1 total is 4, best is 20. But total alone is not the decision: a very low
score on any single showstopper, relative to the other scenarios, is usually fatal on its own.

### Stage 2 — the five nice-to-haves

Low scores here can be overcome with time and money — both of which are scarce, so cheaper and
sooner still win.

**Partners and allies** — Do we already have relationships with the companies needed to complete
the whole product? Usually only if we have a prior early-market project together, or luck.

**Distribution** — Do we have a channel that can call on this customer and meet the whole-product
demands placed on distribution? Selling to a line of business needs fluency in that niche's
language; the standard fix is hiring a well-connected person out of the target industry to lead
the sales force in.

**Pricing** — Is the *whole product* price consistent with the customer's budget and with the
value of fixing the broken process? Do all partners and the channel get paid enough to keep
their attention? Note: whole product price, not product price. Services are often the larger half.

**Positioning** — Is the company credible to this niche today? Usually not very, at the outset.
Niche marketing's payoff is how fast that resistance collapses once you genuinely commit to a
whole product that fixes the broken process.

**Next target customer** — Bowling-pin potential. If we dominate this niche, do these customers
and partners open adjacent niches? Without follow-on niches the economics of niche marketing do
not hold up.

## Running the selection (Moore's process)

1. Build the scenario library. Solicit broadly; weight input from customer-facing people. Stop
   when additions are minor variations.
2. Appoint a small subcommittee — as small as possible, but including anyone who could veto
   the outcome.
3. Publish scenarios, numbered, one page each, with a scoring spreadsheet: scenarios as rows,
   factors as columns, two subtotals (showstoppers, then nice-to-haves).
4. Each member scores the showstoppers **privately** first, then roll up. Discuss disagreements —
   they surface differing views of the same scenario and build the consensus that makes the
   decision stick.
5. Rank and cut. Roughly two-thirds fall out at Stage 1.
6. Score survivors on Stage 2, rank again.
7. Discuss until the team commits to one — and only one — beachhead.

Use `scripts/score_scenarios.py` for steps 3–6. It applies the cut, flags any showstopper score
of 1–2 as a veto candidate, and writes a shareable HTML scorecard.

## Committing

The commitment is the hard part, especially for founders who are themselves technology
enthusiasts or visionaries — they have no pragmatist instincts and do not trust these dynamics.
Name that dynamic when you see it in the room. The decision is a defining moment, and the
company either crosses or dies.

Sizing guidance for funding conversations: forecast the beachhead *and* the bowling alley it
opens. A beachhead alone will not clear an investor's bar; an aggregated mass-market number is
not credible and destroys the focus you just fought for.
