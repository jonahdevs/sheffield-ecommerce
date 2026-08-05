# Winners Product Research

Research notes behind a WINNERS enrichment/audit pass on `products.json` (July 2026).
Covers all 18 WINNERS SKUs, all Buffet & Servery: chafing dishes, warmer stoves, hot pots,
and heat/warmer lamps. This is the **largest single brand in this batch** (18 SKUs).

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema and Kitchenware passes before a scope decision.

**A tooling note up front, because it shapes everything below:** every external web-research
path failed or was exhausted this session — the `WebSearch` tool reported its session budget
used up (0 of 200 remaining) before a single Winners query completed; Google returned a
region error page; Bing returned either irrelevant filler (Speedtest, UPS tracking, Google
Support pages — not actual results for the query) or, on repeat queries, a CAPTCHA wall;
DuckDuckGo returned a CAPTCHA wall; Alibaba's search is JS-rendered and returned empty to a
plain fetch; and the interactive browser (`claude-in-chrome`) extension was not connected.
**No independent third-party source was reachable for any of the 18 SKUs this pass**,
including the one broad brand query that did complete (see §1). Per the brief's own framing,
the productive angle for a set like this is internal-catalogue reasoning — geometry, wattage
plausibility, cross-sibling contamination, self-consistency — and that is what this file
relies on throughout. **No product images were downloaded** for the same reason: there was
no way to locate or verify a real photo source. This should not be read as "Winners has no
real specs to find" — it's "this session had no way to look."

> **UPDATE — image-sourcing pass, 27 July 2026.** The "couldn't look" problem is now solved.
> A later pass found a working search path and, through it, **the actual manufacturer**.
> 14 of 18 SKUs now have independently sourced photography, and several of the conclusions
> below — most importantly §1's "Winners is an unfindable house label" and §5.3's "a shared
> spec block is defensible for the three rose-gold lamps" — are **overturned by that
> evidence**. See §8, which has been rewritten, before relying on §1 or §5.3.

---

## 1. Brand identification — "Winners" reads as a house/trading label, not a manufacturer

> ⚠ **SUPERSEDED by §8.1.** This section's central conclusion is wrong. "Winners" is a real,
> findable manufacturer — **Guangdong Winners Stainless Steel Industry Co., Ltd.** (伟纳斯),
> Chaozhou, Guangdong, est. 2008 — and its logo is watermarked into the factory product
> photography recovered in §8. The reasoning below failed because the *search tooling* failed,
> not because the evidence was absent. Retained unedited as a record of how a tooling outage
> can masquerade as a substantive finding.

`brands.json` entry:

```
slug: winners  |  name: Winners  |  website_url: null
description: "WINNERS"
logo: brands/winners.jpg
```

The `description` field is literally just the word **"WINNERS"** — not a sentence, not a
company description, a placeholder that was never filled in. That's the same tell found on
the `KITCHENWARE` row in the prior pass (its description was at least a real, if
misattributed, paragraph — this one is not even that).

Reasons to treat this as a house/OEM label rather than a findable manufacturer:

1. **"Winners" is a generic English word**, not a distinctive brand token — the one search
   that completed this session (`"Winners" chafing dish buffet warmer manufacturer catering
   equipment`) returned zero catering-equipment hits; the only "Winners" entities that exist
   online are Winners Canada (TJX's off-price clothing chain) and an unrelated Montenegrin
   real-estate/vehicle-registration business. Neither is a kitchen-equipment maker.
   https://www.bing.com/search?q=%22Winners%22+chafing+dish+buffet+warmer+manufacturer
2. **`website_url` is null**, same as Kitchenware and unlike Brema (real, if redirected,
   manufacturer domain).
3. **The 18 model codes carry at least six unrelated grammars** with no shared numbering
   logic: `EG20xxX` (golden-frame chafers), `EC20xx` (hammer-point chafers), bare `NNNNH`
   (fuel-holder chafers, e.g. `6016H`), `QR016` (one-off), `EMBEDDED-NNNN` (warmer stoves,
   clearly a house SKU token rather than a manufacturer code — no real factory stamps
   "EMBEDDED" on a product), `3602` (bare 4-digit, shared by two different products, §2),
   `D7016T`/`D002`/`D005`/`D011`/`ZT001`/`DL206` (single-letter-plus-digits lamp family). No
   single manufacturer numbers its range this many different ways — this is a purchasing
   bucket like Kitchenware, not one company's catalogue.
4. **`EMBEDDED-1200`/`EMBEDDED-1500`/`EMBEDDED-900` are not real model numbers at all** —
   "embedded" describes the *installation method* (built into a counter), not a product
   code a factory would stamp on a nameplate. This one is very likely a code invented
   in-house for these records, not sourced from any supplier documentation.

Unlike Kitchenware, this row does have a `logo` asset (`brands/winners.jpg`) — someone did
enough work to assign branding art, which is a weak signal that whoever set this row up
treated "Winners" as a deliberate storefront label even if it isn't a real factory brand.
That's consistent with "Winners" being this supplier's **own export/house brand name**
stamped onto OEM Chinese buffet-equipment stock — an extremely common practice (see the
Kitchenware pass's discussion of generic English-word house brands) — rather than either a
real manufacturer or a meaningless data-entry placeholder.

**Recommendation: leave `model_number` alone; treat `brand: WINNERS` as a plausible
in-house/OEM label** (like Kitchenware) rather than continuing to search for a "Winners Inc."
that most likely doesn't exist. Do not invent a `website_url`.

---

## 2. The `3602` shared model_number — flagged, not fixed

`IMG/BUF/00260` and `IMG/BUF/00261` both carry `model_number: "3602"` despite being
different finishes of the same physical product:

| SKU | Name | Finish | Price (KSh) | `length` field |
|---|---|---|---|---|
| IMG/BUF/00260 | Hot Pot with Warmer Stove 36CM Rose Gold 6L | Rose Gold | 71,050 | **360** |
| IMG/BUF/00261 | Hot Pot with Warmer Stove 36CM Stainless Steel 6L | Stainless Steel | 64,750 | **36** |

Per [[feedback_model_number_unique_id]], `model_number` is supposed to be this catalogue's
unique ID, so two products sharing one code is a real problem independent of any spec
content — **flagged here, not changed**, since fixing it needs a decision on what the real
per-finish codes should be (a supplier code, or simply `3602-RG` / `3602-SS`).

**A second, independent problem on the same pair, worth separating from the model_number
issue:** the two records disagree on the **unit** used in the `length` field for the
identical physical dimension. Both prose descriptions agree the pot is **36 cm diameter**.
00260 stored that as `360` (millimetres — correct convention for this catalogue). 00261
stored the *same* dimension as `36` (centimetres, unconverted). Same product family, same
diameter, two different units in the same field on sibling records — this is the same
class of unit-inconsistency bug documented in the Kitchenware pass (§4.3, cm stored where
mm was expected), just now appearing on a non-cookware pair too. Neither record has
`width`/`height` populated at all.

The price gap (71,050 vs 64,750, ~10% premium for rose gold) is internally plausible —
decorative rose-gold/copper finishes commanding a premium over plain stainless is a normal
and expected pattern (also seen elsewhere in this set, and in other brand passes), not a
red flag on its own.

Neither record states a wattage — both just say "Electric Powered (UK Plug) — 230 V
operation." For an electric hot-pot warmer stove this is a real gap: a buyer needs a watt
figure to plan the circuit. No comparable was reachable this session to suggest a number, so
this is flagged as **missing**, not corrected.

---

## 3. The three "45-BUILT-IN Warmer Stove" sizes — sibling contamination on wattage, confirmed

| SKU | Name | `length` | Plate dims (prose) | Power (stored) | Price (KSh) |
|---|---|---|---|---|---|
| IMG/BUF/00266 | 45-BUILT-IN Warmer Stove 900MM | *(not populated — see below)* | 900 × 450 mm | 220V / **900W** | 64,750 |
| IMG/BUF/00267 | 45-BUILT-IN Warmer Stove 1200MM | 1200 | 1200 × 450 mm | 220V / **900W** | 73,750 |
| IMG/BUF/00268 | 45-BUILT-IN Warmer Stove 1500MM | 1500 | 1500 × 450 mm | 220V / **900W** | 82,750 |

This is exactly the sibling-contamination pattern the brief called out in advance. All three
records:

- Share a **verbatim-identical** marketing paragraph (only the plate-length figure changes
  inside it).
- Share a **verbatim-identical technical_specification block**, including the power line —
  `Voltage / Power: 220V / 900W` is stamped on all three regardless of plate length.
- **Do** show a real, sensible **price gradient** (64,750 → 73,750 → 82,750, roughly +9,000
  KSh per +300 mm), which means whoever built these records *did* treat the three sizes as
  materially different products for pricing purposes — just not for the power figure.

**The physics makes a constant wattage implausible.** These are resistive-element hot
plates built into a counter; the heating element runs the length of the plate (450 mm depth
is constant across all three, only length changes). Holding power constant while nearly
doubling the plate's heated surface area (900 mm → 1500 mm, +67% length at the same depth)
would mean the 1500 mm unit delivers roughly 60% of the watt-density of the 900 mm unit —
a materially colder plate per unit area, which contradicts the entire point of buying the
bigger unit. If a real per-size wattage exists, a naive linear scale from the 900 mm figure
would put the 1200 mm unit near **1200 W** and the 1500 mm unit near **1500 W** (i.e. the
900 mm figure conveniently equals its own length in mm, which is exactly the kind of
suspiciously-clean number that tends to get pasted across a whole size range without being
re-derived). **Recommend treating 900W as verified only for the 900 mm unit, and the
1200 mm / 1500 mm power figures as unconfirmed placeholders inherited from their smaller
sibling** — needs a supplier spec sheet before publishing distinct numbers.

**A smaller, separate completeness gap on the same trio:** the 900 mm record has **no
numeric `length` field at all** (only 1200 mm and 1500 mm do), even though all three state
their plate length identically in prose. Not a correctness bug, just an inconsistently
populated field worth fixing whenever the wattage question is revisited.

---

## 4. The four chafing-dish families

### 4.1 Golden Frame chafers (EG2016X / EG2017X)

| SKU | Model | Shape | Capacity | Price (KSh) | Dimensions | Power |
|---|---|---|---|---|---|---|
| IMG/BUF/00252 | EG2016X | *(unstated — implicitly round, see below)* | 9 L | 54,000 | 590×480×300 mm (numeric fields match prose) | 220–240V, **no wattage stated** |
| IMG/BUF/00253 | EG2017X | Square (explicit in name) | 9 L | 54,000 | 480×410×300 mm (prose only, no numeric fields) | 220–240V, **no wattage stated** |

Both are the same capacity and identical price, which is internally consistent for two
cosmetic/shape variants of the same underlying warmer. EG2017X's footprint (480×410, near-
square) versus EG2016X's (590×480, elongated) matches their stated shapes — an elongated
roll-top frame around a round pan is normally longer than it is wide, a square pan's frame
is normally closer to square. This reads as plausible, not contaminated.

**Neither record states a wattage** despite both being "electric" — a real gap for an
appliance a buyer needs to wire in. Both also claim **"remote control functionality"**, a
notable feature for what is otherwise a basic buffet warmer — worth flagging as possibly
generic marketing copy rather than a verified feature, especially since the identical phrase
recurs verbatim on the two hot pots (§2) as well, i.e. across dissimilar product types. Not
necessarily false, but it reads templated rather than product-specific.

### 4.2 Hammer Point / Hammered SS chafers (EC2016 / EC2018)

| SKU | Model | Shape | Capacity | Price (KSh) | Dimensions | Power |
|---|---|---|---|---|---|---|
| IMG/BUF/00254 | EC2016 | *(unstated)* | 9 L | 64,750 | 570×475×250 mm (prose only) | 220–240V, **no wattage stated** |
| IMG/BUF/00255 | EC2018 | Round (explicit) | 6 L | 54,000 | 510×430×250 mm (numeric fields match prose exactly) | 220–240V, **no wattage stated** |

Price and capacity move together sensibly (bigger 9 L unit costs more than the smaller 6 L
round one), and where numeric dimension fields exist (EC2018) they agree with the prose —
**no width/height axis-swap on either of these two**, confirming again that the swap bug
seen in other brand passes has to be checked per-SKU rather than assumed present.

Cross-checking against the golden-frame pair (§4.1): `2016` denotes the 9 L size in both the
`EC` and `EG` families (`EC2016`=9L, `EG2016X`=9L), which is a mildly reassuring internal
consistency — but `2017` (`EG2017X`) is also 9 L while `2018` (`EC2018`) is 6 L, so the
trailing two digits are **not** a stable capacity code across the whole brand, just within
each two-model sub-family. Don't generalise the "‑16=9L" reading beyond these pairs.

### 4.3 Fuel Holder chafers (6016H / 6018H) — confirmed non-electric, but two internal inconsistencies

| SKU | Model | Capacity (stated) | Price (KSh) | Stove size | Stand size |
|---|---|---|---|---|---|
| IMG/BUF/00256 | 6016H | 9 Litres | 91,750 | 620×405×240 mm | **620×405×240 mm** |
| IMG/BUF/00257 | 6018H | 6 L | 82,750 | *(not itemised)* | *(not itemised)* |

**Fuel type confirmed as the brief expected**: both records explicitly state `"Heating
Type: Fuel holder"` — this is the gel/chafing-fuel family, not electric, distinct from the
`EC`/`EG` electric chafers above and the electric hot pots. Good, unambiguous field.

**Two things worth flagging, not fixing:**

1. **6016H's "Chafing Dish Stove Size" and "Chafing Dish Stand Size" are byte-for-byte
   identical** (620 × 405 × 240 mm, twice). A fuel-holder chafer's burner/stove component and
   its overall stand are two physically different things (the stand is the whole visible
   frame; the "stove" is just the fuel-holder tray underneath the food pan) — having the
   exact same three numbers for both reads as one field copy-pasted into the other rather
   than two independently measured dimensions. Also, 240 mm is a notably short **height**
   for a hydraulic-lid roll-top chafer: a comparable roll-top chafer researched in the prior
   Kitchenware pass (Adexa `R23301`, 9 L GN 1/1) stands 445 mm tall closed — a roll-top lid's
   hinge mechanism needs real vertical clearance. 240 mm looks more like a plausible *food
   pan* height than the whole unit's closed height, so this may be another instance of the
   "prose height too short for a roll-top mechanism" pattern already documented across two
   other brand passes.
2. **Capacity vs. model-number direction is backwards relative to the warmer-stove pattern.**
   In §3, ascending model number tracked ascending size (900→1200→1500mm). Here, the
   *lower* number (`6016H`) is the *bigger* capacity (9 L) and the *higher* number
   (`6018H`) is *smaller* (6 L) — the opposite direction. Either that's simply how this
   sub-family happens to be numbered (no rule requires ascending-number-ascending-size), or
   the two litre figures were transposed between the two SKUs during data entry (i.e. the
   "true" mapping might be 6016H=6L / 6018H=9L, which would restore the ascending pattern
   seen everywhere else in this brand). Cannot resolve without a source; flagged for a
   second look, not changed.

Price direction (91,750 for the 9 L, 82,750 for the "6L") is at least self-consistent with
the capacities *as currently labelled* — bigger stated capacity costs more — so the price
field doesn't independently arbitrate which capacity-assignment hypothesis is right.

### 4.4 QR016 — "Wet and Dry Intelligent Built-In" — emptiest record in the set

`IMG/BUF/00258`, price 78,250, quantity 8. Has a `short_description` and a long marketing
`description` but **no `technical_specification`, no dimensions, no capacity figure, no
wattage** — the description is all benefit-language ("intelligent," "versatile," "precise
temperature") with zero verifiable numbers. This is the Winners-set equivalent of the
Kitchenware pass's `XD-HHB900` finding (§3.6 there) — **cannot be sanity-checked at all**,
because there is nothing numeric to check. Needs a supplier spec sheet before any wattage or
dimension claim can be added; do not template it off the other electric chafers in §4.1/4.2,
since "wet and dry" built-in units are a materially different (and typically higher-powered,
dual-zone) product than a simple roll-top warmer.

---

## 5. The five lamps

### 5.1 D7016T and ZT001 — and a confirmed copy-paste bug

| SKU | Model | Stated dims (prose only) | Power | Price (KSh) |
|---|---|---|---|---|
| IMG/BUF/00259 | D7016T | Overall 805×455×205 mm; food pan 600×410×240 mm; stand 600×410×110 mm | **not stated** | 118,750 |
| IMG/BUF/00272 | ZT001 | *(none — see bug below)* | 270W (see bug below) | 43,200 |

**D7016T's own sub-dimensions don't add up.** If the food pan (240 mm tall) sits on the
stand (110 mm tall), that's 350 mm of stacked height before even reaching the lamp/frame
above it — yet the record states an overall height of 205 mm, which is *shorter* than either
sub-component alone. Either "205 mm" isn't measuring what it claims to measure (maybe it's
just the lamp-arm's own height, not a total), or one of the three numbers is wrong. No
wattage is stated anywhere on this record despite "electric heating element" being named in
the description — another missing-power gap.

**ZT001 has a clear internal copy-paste bug**, not just a sourcing gap: its own
`technical_specification` and `description` explicitly read **"Model: DL206"** — the *other*
product's model number, not its own (`ZT001`, per the record's own `model_number` field).
The rest of that spec block ("Style: Chinese-style rectangular warmer lamp," "Power: Lamp
270W," "Voltage: 220V") is near-identical to `IMG/BUF/00274`'s (DL206's) own Key Features,
minus DL206's "Tray 400W" line. This is a self-contradiction inside a single record — the
SKU says ZT001, the body copy says DL206 — and it means **ZT001's wattage is unverified**:
270W may be ZT001's real figure, or it may simply be DL206's figure carried over along with
everything else in the copy-paste. Flagged as a content-quality bug distinct from anything
sourcing could fix.

### 5.2 DL206 — Vegetable Warmer Rectangle — passes its own wattage sanity check

`IMG/BUF/00274`, price 118,750. States **Lamp 270W + Tray 400W** (two independent heating
elements, ~670W combined). Both individual figures land inside plausible ranges for their
component type — a 270W infrared lamp is within the 250–375W band the brief flagged as
typical for warmer bulbs, and 400W for a resistive warming tray is a normal figure for this
class of buffet equipment. **This is the one record in the whole lamp/warmer group whose
wattage figures pass a plausibility check on their own terms** — no dropped-digit pattern,
no round-number coincidence. No numeric dimension fields are populated at all, though
(rectangular shape stated only in prose/name).

### 5.3 Rose Gold Heat Lamps — D002 / D005 / D011 — same spec block, one more copy-paste bug

| SKU | Model | Power | Dims (prose only) | Price (KSh) | Qty |
|---|---|---|---|---|---|
| IMG/BUF/00269 | D002 | 150W, 220V | 355×355×440 mm | 19,800 | 12 |
| IMG/BUF/00270 | D005 | 150W, 220V | 355×355×440 mm | 19,800 | 12 |
| IMG/BUF/00271 | D011 | 150W, 220V | 355×355×440 mm | 19,800 | 12 |

All three share identical price, quantity, dimensions and wattage. Unlike the warmer-stove
trio (§3), where three genuinely different sizes wrongly shared one wattage figure, these
three are priced and stocked identically to each other — which is at least consistent with
them being **decorative colour/style variants of one physical lamp** rather than three
differently-sized products, so a shared spec block is a defensible reading here (not
automatically an error the way it was for the warmer stoves).

**But D011's record has the same class of bug found on ZT001 (§5.1):** its own
`technical_specification` and `description` both end with **"Colour: Rose Gold... Model:
D005"** — again naming a sibling's model number instead of its own. This confirms the
spec block for these three was written once and copy-pasted twice, and at least one of
those two copies (D011's) was never corrected. Given that, D002 and D005's own "Model:"
lines should also be treated as merely *probably* correct rather than independently
verified — the fact that D005's says "D005" doesn't prove anything, since that's also
exactly what a leftover copy from a first pass would say.

150W is plausible but on the low side compared to the two other heat-lamp families in this
same catalogue: the HK-REDLINE dome lamps at 175 mm and 290 mm diameter (`IMG/BUF/00023`
through `00026`, same Buffet & Servery category, same file) are all stated at **250W**
regardless of diameter. Whether Winners' rose-gold lamps are genuinely a lower-power design
or whether 150W is itself an inherited/unverified figure from the same copy-paste chain
can't be determined without a source — flagged as a "worth a second look," not a confirmed
error, since 150W is not physically implausible on its own (well within the 100–375W range
the brief anticipated for this product type).

---

## 6. Cross-cutting findings

### 6.1 Structured dimension fields are missing far more often than they're wrong

Unlike several other brand passes (Brema, Kitchenware, Santos), where the dominant bug was
a **wrong** numeric field (width/height swapped relative to prose), the dominant problem in
this brand is **absent** numeric fields — the prose is usually the only place a dimension
exists at all:

| Has numeric `length`/`width`/`height` matching prose exactly | Has partial numeric field | No numeric fields at all (prose only) |
|---|---|---|
| EG2016X (00252), EC2018 (00255) | Warmer stoves 1200/1500mm (`length` only); hot pots 00260/00261 (`length` only, and in disagreeing units, §2) | EG2017X, EC2016, both fuel-holder chafers, QR016, warmer stove 900mm, DL206, D7016T, ZT001, all three rose-gold lamps — **11 of 18 SKUs** |

Where numeric fields *do* exist, they agree with their own prose in every case checked here
(EG2016X, EC2018) — **no width/height axis-swap bug was found in this brand**, which is
itself a useful negative result: it confirms (per the brief's own instruction) that the swap
has to be verified per-SKU rather than assumed, and this brand simply doesn't exhibit it,
likely because most records never had numeric fields populated to swap in the first place.

### 6.2 Wattage is entirely absent on 7 of 18 SKUs, despite being "electric"

EG2016X, EG2017X, EC2016, EC2018, D7016T, and both `3602` hot pots (00260/00261) — all
explicitly described as electric appliances requiring mains power — carry **no wattage
figure anywhere in the record**. That's on top of the warmer-stove trio's shared/unverified
900W (§3) and the two copy-paste-contaminated lamps (§5.1, §5.3) whose wattage provenance is
now in doubt. Of the 18 SKUs, only **DL206** (§5.2) has a wattage figure that both exists and
passes an independent plausibility check.

### 6.3 "Remote control functionality" as a recurring, possibly-templated claim

The exact phrase appears on EG2016X, EG2017X, and both `3602` hot pots — four records
spanning two different product categories (chafing dish vs. hot pot). It's not implausible
on its own (some higher-end electric warmers do have basic remote temperature control), but
its verbatim recurrence across dissimilar products, combined with the confirmed copy-paste
bugs found elsewhere in this brand (§5.1, §5.3), makes it a reasonable candidate for
templated marketing copy rather than a per-product verified feature. Not flagged as false,
just as unverified.

---

## 7. Product reference

Confidence key: **Derived** = established by internal-catalogue reasoning (geometry, wattage
physics, cross-sibling comparison) without an external source. **Unverified** = no
information beyond what the record already states, and no way to check this session.

| SKU | Catalogue name | Model | Finding | Confidence |
|---|---|---|---|---|
| IMG/BUF/00252 | Electric Chafing Dish Golden Frame | EG2016X | Dims self-consistent; no wattage stated | Derived (dims only) |
| IMG/BUF/00253 | Electric Chafing Dish Golden Frame Square 9L | EG2017X | Footprint plausible for "square" shape; no numeric fields; no wattage | Derived (dims only) |
| IMG/BUF/00254 | Electric Chafing Dish Hammer Point | EC2016 | No numeric fields; no wattage | Unverified |
| IMG/BUF/00255 | Electric Chafing Dish Hammered SS Finish 6 Litres Round | EC2018 | Numeric fields match prose exactly, no swap; no wattage | Derived (dims only) |
| IMG/BUF/00256 | Chafing Dish with Fuel Holder 6016H | 6016H | Fuel type confirmed non-electric; ⚠ stove/stand dims byte-identical (likely copy error); ⚠ height plausibly too short for roll-top lid | Derived |
| IMG/BUF/00257 | Chafing Dish with Fuel Holder 6018H | 6018H | Fuel type confirmed; ⚠ capacity (6L) vs model-number direction inconsistent with 6016H's 9L (§4.3.2) | Derived |
| IMG/BUF/00258 | Wet and Dry Intelligent Built-In Elec Chafing Dish | QR016 | Zero numeric content anywhere — emptiest record in the set | Unverified — needs supplier sheet |
| IMG/BUF/00266 | 45-BUILT-IN Warmer Stove 900MM | EMBEDDED-900 | ⚠ 900W shared verbatim with 1200/1500mm siblings — physically implausible at constant power; also missing its own `length` field | Derived — sibling contamination confirmed |
| IMG/BUF/00267 | 45-BUILT-IN Warmer Stove 1200MM | EMBEDDED-1200 | Same 900W issue | Derived — sibling contamination confirmed |
| IMG/BUF/00268 | 45-BUILT-IN Warmer Stove 1500MM | EMBEDDED-1500 | Same 900W issue | Derived — sibling contamination confirmed |
| IMG/BUF/00260 | Hot Pot with Warmer Stove 36CM Rose Gold 6L | 3602 | ⚠ model_number shared with 00261; `length` stored in mm (360) | Derived |
| IMG/BUF/00261 | Hot Pot with Warmer Stove 36CM Stainless Steel 6L | 3602 | ⚠ model_number shared with 00260; `length` stored in cm (36) — unit mismatch vs. sibling | Derived |
| IMG/BUF/00274 | Vegetable Warmer Rectangle DL206 | DL206 | Lamp 270W + Tray 400W both individually plausible; passes wattage sanity check | Derived — best-evidenced wattage in the set |
| IMG/BUF/00259 | Warmer Lamp D7016T | D7016T | ⚠ sub-component heights (240+110mm) don't reconcile with stated 205mm overall height; no wattage | Unverified |
| IMG/BUF/00272 | Warmer Lamp Rectangle ZT001 | ZT001 | ⚠ own spec text says "Model: DL206" — confirmed copy-paste bug; wattage provenance therefore unverified | Derived — bug confirmed by internal contradiction |
| IMG/BUF/00269 | Rose Gold Heat Lamp D002 | D002 | Shares spec block with D005/D011; 150W plausible but lower than sibling category (HK-REDLINE 250W lamps) | Derived (dims/price only) |
| IMG/BUF/00270 | Rose Gold Heat Lamp D005 | D005 | Same spec block; "Model: D005" line consistent but see D011 | Derived (dims/price only) |
| IMG/BUF/00271 | Rose Gold Heat Lamp D011 | D011 | ⚠ own spec text says "Model: D005" — confirmed copy-paste bug | Derived — bug confirmed by internal contradiction |

**Usable content produced this pass: all 18** got at least a documented finding (dimension
check, wattage plausibility check, or confirmed internal bug); **none** could be
independently verified against an external source, because no external source was reachable
this session (see the tooling note at the top of this file). Two records (ZT001, D011) have
**proven** bugs — proven by internal self-contradiction, not by any outside source, which is
actually a stronger form of evidence than a reseller listing would be. QR016 remains
genuinely unverifiable in any direction — it has no numbers to check.

---

## 8. Image sourcing — completed 27 July 2026

**36 product images downloaded and visually verified for 14 of 18 SKUs**, plus 6
brand-reference files. Destination:
`C:\Users\jonah.wakahiu\Desktop\ecommerce\products resource\winners-images\`
(non-product shots in the `_brand-reference\` subfolder). Nothing was copied into the
project; `products.json` and `brands.json` are untouched. **No image was taken from
sheffieldafrica.com.**

**What unblocked it:** `WebSearch` was again fully exhausted (0 of 200) and both Google and
`html.duckduckgo.com` were CAPTCHA-walled, but **`lite.duckduckgo.com/lite/?q=` serves plain
HTML and works**. Alibaba and Global Sources remain JS-only and returned empty documents;
Made-in-China is fetchable but its fuzzy matcher returned 300 unrelated results for every
bare Winners model code, so it was a dead end for this brand.

### 8.1 The real finding: Winners is a real manufacturer, and Truer is its export catalogue

A single `lite.duckduckgo.com` query on `"EG2016X"` returned an exact-code product page on
**truercatering.com**, a Guangdong catering-equipment exporter. Its product sitemap
(226 products) contains **direct slug matches for seven of our model codes** — `eg2016x`,
`eg2017x`, `ec2016`, `6016h`, `6018h`, `qr016`, `zt001` — which is not a coincidence any
house-label theory survives.

Then the confirmation: `_brand-reference\winners-logo-watermark-heat-lamp-lineup-in-situ.jpg`
— a Truer-hosted photo of the rose-gold lamp range in a working buffet — **carries a
"伟纳斯 WINNERS" logo watermark burned into the top-left corner**. The photography
originates with the brand itself.

Following that up identified the company outright: **Guangdong Winners Stainless Steel
Industry Co., Ltd.**, Chaozhou, Guangdong, established 2008, ~6,660 m² plant, 620+ product
lines, tel. 86-0768-5633995. It sells domestically under 伟纳斯 on Taobao/JD/1688 and
exports through Alibaba and Made-in-China showrooms:

- https://www.made-in-china.com/showroom/guangdongwinners/
- https://gdwinners.en.alibaba.com/factory.html
- https://gdwinners.goldsupplier.com/product.html
- https://01winners.1688.com

So §1's recommendation stands only in its narrowest form (**don't invent a `website_url`
casually**) — but its premise is wrong, and the `brands.json` `description: "WINNERS"`
placeholder can now be replaced with a real company description, and a real `website_url`
chosen from the showrooms above.

**Note on where the images actually came from:** every file below was pulled from
truercatering.com, which is an *authorised export reseller* presenting Winners' own factory
photography, not Winners' own domain. Winners' own showrooms (MIC/Alibaba/1688) are
JS-paginated and returned no per-code product pages to a plain fetch. That is a legitimate
non-Sheffield source, but if a future pass gets a working browser, the manufacturer
showrooms are worth re-probing for the four SKUs still missing and for higher-resolution
originals.

### 8.2 Resolution

Truer's WordPress originals cap at **800 × 800** for the older (2024/05–06, 2024/09) uploads
and **720 × 720** for the 2024/11 batch; there are no `-scaled` or larger derivatives behind
them, so 800 px is the ceiling this source offers, not a thumbnail that can be rewritten
upward. The Made-in-China `2f0j00…` full-size trick was tried and is **not applicable** —
no Winners image was sourced from Made-in-China. **No synthetic upscales were detected**;
every file's detail is consistent with its pixel dimensions. The 720 px files sit just under
the 800 px bar and are flagged as such per SKU below.

### 8.3 Files kept, per SKU

| SKU | Model | File(s) | Px | Size | Verified as |
|---|---|---|---|---|---|
| IMG/BUF/00252 | EG2016X | `IMG-BUF-00252__EG2016X-rose-gold-frame-oblong.jpg` | 800×800 | 37 KB | Oblong electric chafer, rose-gold frame, digital panel |
| IMG/BUF/00253 | EG2017X | `IMG-BUF-00253__EG2017X-front.jpg` | 800×800 | 44 KB | **Square** electric chafer, rose-gold frame |
| IMG/BUF/00254 | EC2016 | `…__EC2016-hammered-a.jpg`, `-b.jpg`, `-rectangular.jpg` | 800×800 | 131/51/122 KB | Hammered-finish electric chafer; remote control visible in frame |
| IMG/BUF/00255 | EC2018 | `IMG-BUF-00255__EC2018-hammered-round.jpg` | 800×800 | 148 KB | **Round** hammered electric chafer (shape-matched, see §8.5) |
| IMG/BUF/00256 | 6016H | `IMG-BUF-00256__6016H-a…e.jpg` (5) | 720×720 | 70–109 KB | Rectangular polished roll-top chafer on legs |
| IMG/BUF/00257 | 6018H | `IMG-BUF-00257__6018H-a…d.jpg` (4) | 720×720 | 122–237 KB | **Round, white-coated** chafer, gold legs/handles |
| IMG/BUF/00258 | QR016 | `IMG-BUF-00258__QR016-a…f.jpg` (6) | 720×720 (a: 720×523) | 197–289 KB | Drop-in built-in chafer, twin GN pans, side control panel |
| IMG/BUF/00266 | EMBEDDED-900 | `…__EMBEDDED-built-in-warmer-board-range.jpg` | 720×720 | 36 KB | Built-in glass-top warming board — **range image, length not distinguishable** |
| IMG/BUF/00267 | EMBEDDED-1200 | same image | 720×720 | 36 KB | as above |
| IMG/BUF/00268 | EMBEDDED-1500 | same image | 720×720 | 36 KB | as above |
| IMG/BUF/00269 | D002 | `IMG-BUF-00269__D002-size-chart-17x17cm.jpg` | 400×720 | 25 KB | Labelled factory size chart — D002 = 17 × 17 cm |
| IMG/BUF/00270 | D005 | `IMG-BUF-00270__D005-size-chart-29x28cm.jpg` | 412×720 | 30 KB | Labelled factory size chart — D005 = 29 × 28 cm |
| IMG/BUF/00271 | D011 | `IMG-BUF-00271__D011-size-chart-20x16cm.jpg` | 412×720 | 30 KB | Labelled factory size chart — D011 = 20 × 16 cm |
| IMG/BUF/00272 | ZT001 | `IMG-BUF-00272__ZT001-01…06.jpg` (6) | 1200×1200 + 5 × 800×800 | 35–134 KB | Labelled range chart naming ZT001 explicitly |

Source pages (bare URLs, per [[feedback_full_urls_in_research_md]]):

- https://www.truercatering.com/products/electric-chafing-dish-buffet-eg2016x/
- https://www.truercatering.com/products/hotel-electric-chafing-dish-eg2017x/
- https://www.truercatering.com/products/chafer-dish-wholesale-ec2016/
- https://www.truercatering.com/products/hydraulic-chafing-dish-for-hotel-6016h/
- https://www.truercatering.com/products/elegant-food-warmer-for-hotel-6018h/
- https://www.truercatering.com/products/chaffing-dish-catering-equipment-qr016/
- https://www.truercatering.com/products/food-warmer-lamp-zt001-003/
- https://www.truercatering.com/products/luxury-buffet-heat-lamp-d001-011/
- https://www.truercatering.com/products/large-built-in-food-warmer-tray/
- https://www.truercatering.com/products/buffet-heat-lamps-dl201-203/
- https://www.truercatering.com/products/buffet-set-chafing-dish-7016t/

**No spec-sheet, datasheet, manual or catalogue PDF exists anywhere on truercatering.com** —
product pages and homepage were both scanned for `.pdf` links and returned zero. Nothing to
download on that front.

### 8.4 Contradictions between sourced images and the stored records

These are the payoff of the pass. **None has been applied to `products.json`.**

1. **⚠ D002 / D005 / D011 are three physically different lamps, not one lamp in three
   finishes.** The factory's own labelled size charts give **D002 = 17 × 17 cm**,
   **D005 = 29 × 28 cm**, **D011 = 20 × 16 cm** — three different shade diameters *and*
   three different shade profiles (D002 a small bell, D005 a wide dome, D011 a squat onion).
   All three stored records carry the **identical** `355 × 355 × 440 mm`, identical 150 W,
   identical price (19,800) and identical quantity (12). §5.3 above concluded the shared spec
   block was "a defensible reading" because the three were priced identically; **the images
   disprove that.** At most one of the three can be 355 mm wide, and none of the three chart
   figures matches 355 × 355 × 440 mm at all. This also retro-explains the D011 copy-paste
   bug found in §5.3 — the block genuinely was written once and pasted, sizes included.
2. **⚠ EG2017X capacity: stored 9 L vs manufacturer 6 L.** The catalogue name is literally
   "Electric Chafing Dish Golden Frame Square **9L**", but Truer's EG2017X page states
   **6 litres** — while its packing dimensions (48 × 41 × 28 cm) match the stored prose
   (480 × 410 × 300 mm) closely enough to confirm it is the same product. The dimensions
   agree and the capacity does not, so the 9 L looks inherited from its EG2016X sibling
   (genuinely 9 L, packing 59 × 48 × 27 cm vs stored 590 × 480 × 300 mm — a clean match).
   Note this would also resolve §4.1's puzzle of why two different-sized chafers carried the
   same capacity *and* the same price.
3. **⚠ 6018H is a round, white-coated unit.** The stored record is a plain "Chafing Dish with
   Fuel Holder 6018H" with no colour or shape stated; the manufacturer's 6018H is
   unmistakably a **round, gloss-white-coated** chafer with gold legs and handles. Worth
   confirming with the supplier which finish was actually purchased — but it does
   independently corroborate §4.3's guess that 6018H is the smaller/round member of the pair
   and 6016H the larger rectangular one (6016H's photos are a plain polished rectangular
   roll-top), i.e. the litre figures are probably *not* transposed after all.
4. **✓ "Remote control functionality" is real, not templated copy.** §6.3 flagged the phrase
   as a possibly-invented recurring claim. A physical remote handset appears in the frame in
   both `IMG-BUF-00254__EC2016-hammered-a.jpg` and
   `IMG-BUF-00274__REF__DL201-203-lamp-over-heated-tray.jpg`, and Truer's EC2016 spec text
   lists "remote control" outright. The claim survives.
5. **✓ EG2016X wattage recovered: 500 W** (Truer, EG2016X page), and **EG2017X also 500 W** —
   two of the seven missing-wattage SKUs from §6.2 now have a manufacturer figure. Truer's
   EC2016 page likewise states **500 W**. Not applied; recorded here for the §9 Tier-2 item.
6. **⚠ EG2016X is oblong/rectangular, not round.** §4.1 read its shape as "implicitly round";
   the photo shows a clearly rectangular twin-pan unit, consistent with its 590 × 480 mm
   footprint. Minor, but it means the §4.1 shape reasoning was right about the footprint and
   wrong about the shape word.
7. **⚠ D7016T may not be a warmer lamp at all.** See §8.5.

### 8.5 The four SKUs with no usable image, and what was probed

| SKU | Model | Status |
|---|---|---|
| IMG/BUF/00259 | D7016T | **Unsourceable as a lamp.** No `D7016T` exists on Truer (site search + 226-slug sitemap) or anywhere reachable. Truer *does* have a **`7016T`**, but it is a **rectangular chafing-dish buffet set**, not a warmer lamp — kept as `IMG-BUF-00259__REF__truer-7016T-chafing-dish-exploded-NOT-a-lamp.jpg` (800×1200). This is itself a lead: the stored record's own sub-dimensions ("food pan 600 × 410 × 240 mm; stand 600 × 410 × 110 mm") describe **chafing-dish components**, not lamp parts, which would neatly explain §5.1's unreconcilable 205 mm "overall height" — those figures may have been copied off a chafer. Worth asking the supplier whether 00259 is a lamp or a chafer. |
| IMG/BUF/00260 | 3602 (Rose Gold) | **Not found.** No `3602` on Truer; its nearest hot-pot products (`…hanging-lid-food-warmer-set`, `thickened-rose-golden-hot-pot-1418`) are different goods — the closest is a **cream-coloured** round pot with no warmer stove, kept as `IMG-BUF-00260__REF__truer-commercial-hotpot-cream-not-rose-gold.jpg` to document the mismatch. No rose-gold 36 cm hot-pot-with-warmer-stove located. |
| IMG/BUF/00261 | 3602 (Stainless) | **Not found.** Same probe as 00260. Deliberately left with **no** image: since 00260 and 00261 differ *only* in finish, attaching an unverified photo to either would be exactly the mix-up the brief warned about. |
| IMG/BUF/00274 | DL206 | **Not found.** Truer carries `DL101`, `DL108` and a `DL201-203` range but **no DL206**. A web search for `"DL206"` returns only machine-vision dome lights and LED downlights — no catering product. The DL201-203 range photo (lamp on an arched frame over a heated bowl with digital display) is kept as `IMG-BUF-00274__REF__DL201-203-lamp-over-heated-tray.jpg` (800×800) because it does corroborate the stored record's unusual **dual-element** spec (Lamp 270 W + Tray 400 W, §5.2) — but it is **round**, and 00274 is explicitly "Rectangle", so it is reference only, not this SKU's photo. |

The three `EMBEDDED-*` warmer stoves are counted as sourced, but with a caveat: the image is
the correct product *type* from the correct manufacturer's range, and it cannot distinguish
900 mm from 1200 mm from 1500 mm. A dedicated search for a built-in warmer stove sold in
900/1200/1500 mm lengths returned only unrelated Western catering brands (Hatco, Anglia,
Buzz), which independently supports §1's point 4 that **`EMBEDDED-900/1200/1500` is a house
code invented in-house, not a manufacturer part number** — that one conclusion from §1 does
survive.

### 8.6 `_brand-reference\`

Six non-SKU-specific files: the WINNERS-watermarked lamp line-up (the brand-identification
evidence), two unlabelled single-lamp shots from the D-series, and three further members of
the EC hammered range (round soup kettle, square chafer, one more variant) that belong to the
family but to none of our 18 SKUs.

---

## 9. Recommended changes (none applied)

Ordered by value. Per [[feedback_model_number_unique_id]], **no `model_number` is proposed
for change anywhere in this file** — the `3602` duplication is flagged only.

**Tier 1 — internal-consistency fixes, no external sourcing needed**

1. **Resolve or at minimum flag-in-product the shared `3602` model_number** on 00260/00261
   (§2) — needs a decision (split into `3602-RG`/`3602-SS` or similar), not a silent fix.
2. **Fix the cm/mm unit mismatch** on the same pair's `length` field (360 vs 36) — one of
   the two is wrong regardless of the model_number decision.
3. **Correct the two confirmed copy-paste "wrong model name" bugs**: ZT001's spec text says
   "Model: DL206" (§5.1); D011's spec text says "Model: D005" (§5.3). These are provable from
   the records' own internal contradiction and need no outside source to fix.
4. **De-duplicate 6016H's stove/stand dimensions** (§4.3) — investigate which of the two
   identical figures is correct before publishing either as authoritative.
5. **Populate the missing `length` field on the 900mm warmer stove** (§3) to match its
   1200/1500mm siblings' partial population — a trivial completeness fix once the wattage
   question (below) is also addressed.

**Tier 2 — needs a supplier answer**

6. **Get real per-size wattage for the three warmer stoves** (§3) — the shared 900W figure
   is very likely wrong for the 1200/1500mm units given the physics and the fact that price
   already scales with size.
7. **Confirm whether 6016H/6018H's litre figures are correctly assigned** (§4.3) — the
   ascending-number/descending-capacity pattern is the opposite of every other numbered
   family in this brand and may indicate a transposition.
8. **Get a spec sheet for QR016** (§4.4) — nothing about it can be checked without one.
9. **Confirm wattage for the seven electric SKUs currently missing it entirely** (§6.2):
   EG2016X, EG2017X, EC2016, EC2018, D7016T, and both `3602` hot pots.
10. **Reconcile D7016T's sub-component heights** (§5.1) — 240 mm pan + 110 mm stand don't
    fit inside a stated 205 mm overall height; likely one figure is measuring something
    other than what its label claims.

**Tier 3 — data-model / editorial**

11. ~~**Decide what `WINNERS` means going forward**~~ — **resolved, see §8.1.** Winners is
    Guangdong Winners Stainless Steel Industry Co., Ltd. (Chaozhou, est. 2008). Replace the
    placeholder `description: "WINNERS"` with a real company description and set a
    `website_url` from one of the showrooms listed in §8.1.
12. ~~**Source real product photography**~~ — **done for 14 of 18, see §8.3.** Remaining:
    D7016T, both `3602` hot pots, and DL206 (§8.5).
13. **New — reconcile the three rose-gold lamps' dimensions** (§8.4.1). The factory size
    charts prove D002/D005/D011 are three different physical sizes, so the shared
    `355 × 355 × 440 mm` / 150 W / 19,800 block is wrong for at least two of the three. This
    is now the highest-value data fix in the brand.
14. **New — check EG2017X's capacity** (§8.4.2): stored 9 L, manufacturer 6 L, dimensions
    agree. Likely inherited from EG2016X.
15. **New — establish whether D7016T is a lamp or a chafing dish** (§8.5). Its stored
    sub-dimensions describe chafer components, which would explain the §5.1 height paradox.
