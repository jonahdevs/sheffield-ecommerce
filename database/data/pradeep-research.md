# Pradeep Product Research

Research notes behind the PRADEEP enrichment pass on `products.json` (July 2026). Covers
all 13 PRADEEP SKUs: 3 indirect-jacket milk boilers (9228 series), 3 non-heated insulated
catering urns/thermoses (7217 series), 4 electric hot-water catering urns (111100 series),
1 heated insulated water urn (7227/9G), and 1 filter-coffee brewer (9230).

**Caution: `sheffieldafrica.com` is NOT an independent source for this brand — it is
Sheffield Africa's own live storefront**, the same Kenyan business this catalogue belongs
to (see [[reference_sheffield_africa_company]]), and very likely the original source of
the erroneous `products.json` data this whole research effort exists to correct. 10 of the
13 SKUs are still listed there today under sequential product IDs 354&ndash;361, and early
in this pass they were used as a "confirmation" source — that was circular for anything
beyond a plain internal-consistency check, since it just re-confirms whatever Sheffield
already has (bugs included). **Corrected after review**: two pieces of data that had *no*
source except Sheffield's own site (`model_number` "7227/9G" for the 36L heated urn, and an
800W rating for the 9230 brewer) were reverted since they could not be independently
verified — see §4.4/§4.5. Everything else in this file is corroborated by a genuinely
external source: `pradeepibrew.com`/`pradeepstainless.com` (official manufacturer sites),
independent Indian distributors (velanstore.com, indiamart.com), or is a self-evident
internal-consistency fix that needed no external source at all (a product's own
description contradicting its own name/model).

**This pass found and fixed three copy-paste data bugs** (wrong capacity/model text and a
phantom power rating bleeding from one SKU's fields into another's) and filled in missing
description/spec/meta content across most SKUs. **`model_number` was changed on one SKU**
(filling a previously-`null` field, confirmed independently) — see
[[feedback_model_number_unique_id]] and §4.4.

---

## 1. Brand identification

**Pradeep** (Pradeep Stainless India), a Chennai-based manufacturer with **35+ years** in
catering/HORECA equipment, exporting kitchenware to 10+ countries. Its beverage-equipment
line trades under the sub-brand **"iBrew" / "Pradeep iBrew"** (`pradeepibrew.com`) —
milk boilers, hot water boilers/urns, filter-coffee and Indian chai brewing equipment —
separate from the main `pradeepstainless.com` site, which covers hotpots, cookware,
buffet ware and stainless food-storage drums.

---

## 2. Where to look — and the traps

| Resource | URL | Value |
|---|---|---|
| Official beverage-equipment site | `pradeepibrew.com` (product-category pages: `milk-boiler-warmer`, `hot-water-dispensers`, `filter-coffee-machines`) | **Best independent source** — official model tables, no images/dimensions |
| Official manufacturer site (non-beverage lines + one matching table) | `pradeepstainless.com` | Confirmed the 7217 series table exactly |
| Distributor mirrors (India) | velanstore.com, indiamart.com listings | Independent — useful for gap-filling model numbers not on either official site |
| Sheffield Africa's own live catalogue | `sheffieldafrica.com/kitchen/product/{354–361}/...` | **Not independent** — this is the business's own storefront and likely the origin of the errors this pass is meant to catch. Do not use it to "confirm" a fix; only useful as a plain reference for what's currently live |

### Traps

1. **Two separate, similarly-numbered "urn" product families — don't conflate them.**
   - **7217 series** = non-heated, vacuum/PUF-insulated **thermos** urns (no element, no
     plug) — our 16L/20L/30L SKUs. Confirmed verbatim on `pradeepstainless.com`'s own
     catalogue table (7217/6 through 7217/35).
   - **111100 series** = **electric** hot-water boilers with a heating element — our 9L/
     18L/27L/40L SKUs (`111102`/`111104`/`111106`/`111109`). Confirmed on `pradeepibrew.com`.
   Similar "catering urn" / "water boiler" naming in casual copy makes it easy to cross a
   heated model's spec into a non-heated listing or vice versa — check the model prefix
   before reusing any spec text.
2. **9228 series (indirect water-jacket milk boilers) uses the same 2800–3000W /
   230–240V spec text for every size** (12L/20L/30L) — the wattage doesn't scale with
   capacity in the sourced copy. This was true across all three sizes on Sheffield
   Africa's own site too, so it's the manufacturer's own generic spec sheet repeated per
   size, not a data-entry error to "fix."
3. **The 40L electric urn's model number is `111109`, not `111108`** — official
   `pradeepibrew.com` table skips straight from `111106` (27L) to `111109` (40L); no
   `111108`/`111107` exists.
4. **The 36L heated urn (IMG/COF/00032, `model_number: "9G"`) does not exist anywhere in
   Pradeep's *current* official catalogue.** `pradeepibrew.com`'s insulated-dispenser line
   runs `111201`(4.5L)/`111202`(9L)/`111204`(18L)/`111206`(27L)/`111209`(40L) — no 36L size,
   no `72xx` numbering at all. Sheffield Africa's own live page states a fuller code
   (`7227/9G`) and confirms 36L, but since that page isn't independent (see §2), **this is
   either a genuine older/discontinued Pradeep code or an error on Sheffield's own
   listing — left unresolved, not applied**. See §4.4/§4.5.
5. **Coffee brewer 9230 and milk boilers 9228 share the "92xx" prefix but are unrelated
   product lines** (brewer vs boiler) — don't assume adjacency implies a shared spec sheet.

---

## 3. Product reference

| SKU | Catalogue name | Model | Independent source | Confidence |
|---|---|---|---|---|
| IMG/COF/00023 | Milk Boiler ... 12 Litres | 9228/12 | none found independently — see §7 correction | **Low — unresolved** |
| IMG/COF/00024 | Milk Boiler ... 20 Litres | 9228/20 | none found independently — see §7 correction | **Low — unresolved** |
| IMG/COF/00025 | Milk Boiler ... 30 Litres | 9228/30 | none found independently — see §7 correction | **Low — unresolved** |
| IMG/COF/00112 | Electric Catering Urn 9 Ltr | 111102 | `pradeepibrew.com` official table — see §7 | **High** |
| IMG/COF/00113 | Electric Catering Urn 18 Ltr | 111104 | same | **High** |
| IMG/COF/00114 | Electric Catering Urn 27 Ltr | 111106 | same | **High** |
| IMG/COF/00115 | Electric Catering Urn 40 Ltr | 111109 | same (40L is the only gap after 111106) | **High** |
| IMG/COF/00111 | Coffee Filter with Heater Plate 5 Ltr | 111504 | IndiaMart distributor listing — see §7 | Medium |
| IMG/COF/00032 | Heated Insulated Water Urn 36 Litres | `9G` (unresolved — see §2 trap 4) | none found independently | **Low — unresolved** |
| IMG/COF/00029 | Non Heated Insulated Catering Urn/Thermos 16 Litres | 7217/16 | `pradeepstainless.com` official table (exact match) — see §7 | **High** |
| IMG/COF/00030 | Non Heated Insulated Catering Urn/Thermos 20 Litres | 7217/20 | same | **High** |
| IMG/COF/00031 | Non Heated Insulated Catering Urn/Thermos 30 Litres | 7217/30 | same | **High** |
| IMG/COF/00033 | Coffee Brewer with Coffee Filter (3L) | 9230 | none found independently (model/capacity plausible, unconfirmed) | Low |

---

## 4. Data audit — errors found and fixed

### 4.1 Copy-paste bug — 20L milk boiler had the 30L boiler's fields ⚠ (fixed)

`IMG/COF/00024` (Milk Boiler ... **20** Litres, model `9228/20`) had:
- `description`: *"Milk boiler **36** liters..."* — wrong capacity, and belongs to neither
  this product (20L) nor its own model family (36L is the unrelated, unresolved
  `9G`/heated-urn SKU).
- `technical_specification`: listed **`Model: 9228/30`, `Capacity: 30 LITRES`** — this is
  verbatim the next SKU's (`IMG/COF/00025`, the 30L boiler) spec block.

This is a self-evident internal-consistency bug — the product's own name/`model_number`
say 20L, its own description/spec said 36L and 30L respectively — detectable from
`products.json` alone, no external source needed. Both fields corrected to 20L.

### 4.2 Copy-paste bug — 30L milk boiler also had "36 liters" in its description ⚠ (fixed)

`IMG/COF/00025` (Milk Boiler ... **30** Litres, model `9228/30`) had the same
*"Milk boiler 36 liters"* description text (same internal-consistency logic as §4.1), and
had **no `technical_specification` at all**. Description corrected to 30L; a spec table
was added using the 9228 family's generic wattage/voltage text (§2 trap 2).

### 4.3 Copy-paste bug — all three 7217-series thermos urns had a phantom wattage rating ⚠ (fixed)

`IMG/COF/00029`/`00030`/`00031` (16L/20L/30L non-heated insulated urns) each had a
`technical_specification` with a **"Voltage/Frequency: 50/60 HZ, 230-240V" and "Wattage:
2800-3000W"** line — but these are **non-heated, unplugged thermos urns** (that's the
whole point of the product name), confirmed by `pradeepstainless.com`'s own 7217-series
table (independent, official), which lists no power spec at all for this line. The
voltage/wattage lines were carried over from the electric 9228 milk-boiler template.
Replaced with a "Power source: None" line; also normalised each `Model:` line inside the
spec text to match the catalogue's own `model_number` field (`7217/16`/`7217/20`/`7217/30`)
— an internal-consistency fix inside free-text spec HTML, not a change to the
`model_number` field itself.

### 4.4 `model_number` filled in, with approval and independent confirmation

`IMG/COF/00115` (40L electric urn) had `model_number: null`. Filled in as **`111109`**,
confirmed on `pradeepibrew.com`'s own official spec table (the only gap in the sequence
`111102`/`111104`/`111106`/`111109` for 9/18/27/40L) — independent of Sheffield Africa.
Approved by the user before applying, per [[feedback_model_number_unique_id]].

### 4.5 Reverted — two fields whose only source was Sheffield Africa's own site ⚠

Two changes made earlier in this pass were **reverted** after review, because the only
source for them was `sheffieldafrica.com` itself (see the caution at the top of this file
and §2's trap 4):

- `IMG/COF/00032` `model_number`: attempted `9G` → `7227/9G`, **reverted back to `9G`**.
  Pradeep's current official catalogue has no 36L / `72xx` product at all (§2 trap 4), so
  the fuller code could not be independently confirmed either way.
- `IMG/COF/00033` (9230 brewer) `technical_specification`: an added **800W** wattage/
  voltage row was **removed** — no independent source states a wattage for this model.

Neither field was left worse than it started (both are back to their pre-pass values);
this file records the attempt and the reason it didn't stick, so it isn't silently
re-attempted later.

---

## 5. Not published — left blank rather than invented

- **111102 / 111104 / 111106 / 111109** (electric urns): no dimensions found on either
  Pradeep site; wattage/voltage is uniform across the family (3000W, 220&ndash;240V/50Hz/
  15A single-phase) per the official table, so recorded as such.
- **111504** (coffee filter 5L): wattage not confirmed anywhere (distributor pages give
  fill/dispense mechanics — manual fill, 2L max water input, 5.5L max brew-storage level
  &mdash; but no power rating); left blank rather than assumed from the family.
- **9230** (coffee brewer): wattage NOT added — see §4.5. Existing spec table left as
  found (no power rating).
- **`9G`/36L heated urn**: fuller model code and dimensions NOT added — see §4.5/§2 trap 4.
  This SKU may be worth a closer look independent of this research pass (e.g. checking
  whether it's actually a discontinued product, or a data-entry error inherited from
  wherever the original catalogue was built).

---

## 6. Summary of `products.json` changes this pass

- **Fixed** the three copy-paste bugs in §4.1/§4.2/§4.3 (20L and 30L milk boilers' wrong
  capacity/spec text; all three 7217-series thermos urns' phantom wattage rating) — all
  detectable from internal inconsistency or confirmed via official manufacturer pages,
  independent of Sheffield Africa.
- **Added** `technical_specification` to the 30L milk boiler (was missing).
- **Added** `meta_description` across all 12 SKUs that lacked one.
- **Built out** `short_description` / `description` / `meta_description` /
  `technical_specification` from scratch for the four 111100-series electric urns
  (00112/00113/00114/00115) and the 111504 coffee filter (00111) — all five had no
  content beyond a name and (mostly) a price before this pass. Sourced from official
  `pradeepibrew.com` tables and independent distributor listings.
- **`model_number` filled in on 1 SKU** (§4.4): `IMG/COF/00115` `null` → `111109`,
  independently confirmed and user-approved.
- **Reverted 2 changes** (§4.5) whose only source was Sheffield Africa's own site: the
  `9G` → `7227/9G` model-number change, and an 800W spec added to the 9230 brewer.
- **No image fields changed.**

---

## 7. Source links (verification pass, July 2026)

Direct links behind the confidence claims in §3 — added after review flagged that this file,
unlike `skymsen-research.md`, had no clickable references.

| SKU | Model | Link | Confirms |
|---|---|---|---|
| IMG/COF/00029 | 7217/16 | https://pradeepstainless.com/stainless-steel-food-storage-drums/catering-urn/ | Official table lists `7217/16`, 16.00 L, exactly |
| IMG/COF/00030 | 7217/20 | same | `7217/20`, 20.00 L |
| IMG/COF/00031 | 7217/30 | same | `7217/30`, 30.00 L |
| IMG/COF/00112 | 111102 | https://pradeepibrew.com/products/electric-hot-water-machine/ | Official spec table: `111102`/9 L, 3000 W |
| IMG/COF/00113 | 111104 | same | `111104`/18 L, 3000 W |
| IMG/COF/00114 | 111106 | same | `111106`/27 L, 3000 W |
| IMG/COF/00115 | 111109 | same | `111109`/40 L, 3000 W — the gap-fill from §4.4 |
| IMG/COF/00111 | 111504 | https://www.indiamart.com/proddetail/south-indian-filter-coffee-maker-21436365588.html | Independent distributor listing: "Model Number: 111503, 111504", 2 L max fill / 5.5 L max brew storage — matches |
| IMG/COF/00023 | 9228/12 | none found | see correction below |
| IMG/COF/00024 | 9228/20 | none found | see correction below |
| IMG/COF/00025 | 9228/30 | none found | see correction below |
| IMG/COF/00032 | `9G` | none found | unresolved, see §4.5/§2 trap 4 |
| IMG/COF/00033 | 9230 | none independent — only https://www.sheffieldafrica.com/kitchen/product/358/coffee-brewer-with-coffee-filter-3.0ltr-9230 | not independent, unchanged from §4.5 |

### Correction: the "IndiaMart confirms 9228" claim in §3 did not hold up on re-check

§3 previously credited an "IndiaMart listing" with confirming the 9228 milk-boiler family at
Medium confidence. Re-checked July 2026, and **no independent source uses the model number
"9228" at all**:

- `pradeepibrew.com`'s three milk-boiler pages (`milk-boiler-machine`,
  `insulated-milk-boiler-machines`, `non-insulated-pradeep-milk-boiler`) do cover 5/12/20/30 L
  capacities, but under entirely different model codes — `111300`/`111312`/`111320`/`111330`
  (non-insulated) and `111600`/`111612`/`111620`/`111630` (insulated).
- Every IndiaMart listing checked (the `graceinc` storefront and two `proddetail` pages
  advertising "Capacity 5, 12, 20, 30 Liters") uses those same `1113xx`/`1116xx` codes — none
  mention "9228" anywhere.
- The **only** place `9228/12` / `9228/20` / `9228/30` appears is Sheffield Africa's own live
  catalogue (`sheffieldafrica.com/.../milk-boiler-XX-litres-9228-XX`, product IDs 354–356) —
  the same non-independent source flagged at the top of this file.

The 5/12/20/30 L capacity range is a genuine Pradeep product family (confirmed
independently). What's unconfirmed is the specific `9228` model code attached to it in
`products.json` — that traces only back to Sheffield's own site. **§3's confidence for the
three 9228 SKUs has been downgraded from Medium to Low/unresolved**, the same tier as the `9G`
urn and the 9230 brewer. No `products.json` fields were changed by this finding — the
`model_number` values were left as-is (changing them would need a *better* source, not just a
downgrade), but they should now be read as unconfirmed rather than confirmed.

---

## 8. Second follow-up pass (July 2026) — chasing the last 5 low-confidence SKUs further

The business flagged that `sheffieldafrica.com` should never have been leaned on at all (it's
our own storefront, not a supplier — see the caution at the top of this file) and asked for
another independent pass specifically on the SKUs still resting on it. Findings below are all
from sources with no relationship to Sheffield Africa (pradeepibrew.com's own pages, IndiaMart
listings unconnected to the `graceinc`/Sheffield-linked ones already cited).

### 8.1 9228/12, 9228/20, 9228/30 — family confirmed independently, legacy code still isn't

`pradeepibrew.com/products/insulated-milk-boiler-machines/` (official, independent) gives a
clean model/capacity/dimension table for the **current** "double-layered"/jacketed milk-boiler
line:

| Model | Capacity | Dimensions (L×W×H mm) |
|---|---|---|
| 111600 | 5 L | 470×280 |
| 111612 | 12 L | 580×320 |
| 111620 | 20 L | 550×380 |
| 111630 | 30 L | 670×390 |

All four share "220–240V AC, 15Hz, 15A" and manual fill, dispensing hot milk/hot water at
7–8 cups/min — no per-size wattage is published (unlike the non-insulated 111300 line, which
is a flat 3000 W across all sizes). Our three SKUs' "double layered"/"indirect water heating
jacket" description matches this **insulated** family, not the non-insulated 111300 one, on
design grounds (indirect jacket = double wall), and the capacities (12/20/30 L) line up exactly
with `111612`/`111620`/`111630`.

This still does **not** confirm the `9228` code itself — no independent source anywhere uses
that number, only Sheffield's site does. What it does establish is that the product *family*
matches a genuine, currently-sold Pradeep line, so this reads as an old/legacy Pradeep code for
the same physical product rather than an invented one (parallel to the `9230`→`111503` finding
in §8.2 and the `111108`→`111109` gap already documented in §2 trap 3).

**Applied (user decision, July 2026):** rather than adopt `111612`/`111620`/`111630`, the
business chose to keep the existing `92xx`-style numbering but correct the leading digit —
`9228/12`/`9228/20`/`9228/30` → **`7228/12`/`7228/20`/`7228/30`** (matching the `72xx` prefix
already used by the 7217 (thermos urn) and 7227 (heated urn) families) — approved and applied
directly, no further confirmation attempted on `7228` itself. At the same time the three
separate SKUs (`IMG/COF/00023`/`00024`/`00025`) were **merged into one variable-type parent
product** ("Milk Boiler with Indirect Water Heating Jacket" (`sku: null` — variant-group parents carry no SKU of their own, per the seeder's existing rule; the three original SKUs live on the variants)), following the same pattern already
used for `GROUP/ELECTRIC-CATERING-URN-PRADEEP` and `GROUP/INSULATED-CATERING-URN-PRADEEP` —
one shared parent image (the three variants look visually identical, so no per-variant images
were added, same as the insulated-urn group), one `volume` variation attribute
(12/20/30 litres), and the three original SKUs preserved as variants. The three old per-SKU
stock photos (which turned out to be generic — 12L and 20L were literally the same file) were
deleted from `storage/app/public/products/` and replaced with a single new photo
(`milk-boiler-with-indirect-water-heating-jacket-pradeep.jpg`).

### 8.2 9230 (3L coffee brewer) — found a genuinely independent 800W confirmation, under a different code

Two separate IndiaMart listings (unconnected to Sheffield or to the `graceinc`/`velanstore`
sources already cited), both for a **Pradeep 111503, 3-litre filter coffee machine**:

- "111503 800" PRADEEP Filter Coffee Machine 3 Liter — ₹6,396/unit, Tiruvallur:
  https://www.indiamart.com/proddetail/pradeep-filter-coffee-machine-3-liter-21746553033.html
- Stainless Steel 111503 PRADEEP Coffee Filter Machine — same model/price, Tiruvallur:
  https://www.indiamart.com/proddetail/pradeep-coffee-filter-machine-21601575991.html

Both independently agree: **model 111503, 3000 ml max storage, 800 W, 220–240V AC, 15Hz, 5A,
single phase, manual fill/dispense, stainless steel tap.** This is the same "111503" model
number already cited in §3/§7 for the *5-litre* SKU (`IMG/COF/00111`, catalogued there as
`111504`) — IndiaMart's own "South Indian Filter Coffee Maker" listing gives "Model Number:
111503, 111504" for the 3 L/5 L pair, which matches this new 3 L-specific listing cleanly.

This directly bears on the §4.5 revert: an 800 W spec was pulled from `IMG/COF/00033` (the 9230
brewer) because at the time its *only* source was Sheffield. There is now a genuinely
independent 800 W source for the 3-litre Pradeep filter coffee machine — but it's attached to
model `111503`, not `9230`. Read together with §7's Indian rebrand pattern, `9230` is very
likely an old/legacy code for the same 3 L product now sold as `111503`, the same relationship
as the 9228 family above. **Proposed, not applied:** re-adding an 800 W / 220–240V / manual-fill
spec line to `IMG/COF/00033`, and optionally updating `model_number` from `9230` to `111503` —
both need approval before touching `products.json` (spec-content changes are lower-stakes, but
the model number itself is a unique ID per [[feedback_model_number_unique_id]]).

### 8.3 9G / 36L heated urn — still unresolved; one lead checked out and didn't hold up

A search summary surfaced a claim that the `7227` series maps `7227/9G` to "9 gallons / 40
litres" (alongside `7227/1G`=4.5L, `7227/2G`=9L, `7227/4G`=18L, `7227/6G`=27L). This looked
promising — it would mean our 36 L figure is simply wrong and the real capacity is 40 L,
matching the already-confirmed `111209` (40 L) in the current catalogue. **This could not be
substantiated on follow-up**: the two pages that would carry it both 404 —
https://www.pradeepibrew.com/product/stainless-steel-insulated-hot-water-dispensers/ and
https://velanstore.com/product/pradeep-insulated-hot-water-dispenser/ — a direct search for
the exact string `"7227/9G"` returned nothing, and the one `pradeepibrew.com` product page that
did load for this line (https://pradeepibrew.com/product/insulated-hot-water-dispenser/) was
just a product photo with no spec table. Treating the "40 L" claim as unverified rather than
acting on it — **no change proposed**. The `9G`/36L urn remains exactly where §4.5/§2 trap 4
left it: no independent source, nothing changed.

### 8.4 Net effect of this pass

- **9228/12, 9228/20, 9228/30 — applied.** `model_number` changed to `7228/12`/`7228/20`/
  `7228/30` (business decision, keeping the `92xx`→`72xx` family style rather than adopting
  `111612`/`111620`/`111630`), and the three SKUs merged into one variant-group product
  ("Milk Boiler with Indirect Water Heating Jacket" (`sku: null` — variant-group parents carry no SKU of their own, per the seeder's existing rule; the three original SKUs live on the variants)) with a single shared image, replacing the
  three old per-SKU photos (two of which were duplicates of each other). See §8.1.
- **9230**: independent 800 W/220–240V spec found, but under code `111503`. Still a proposal —
  restoring an 800 W spec line, and considering `model_number` → `111503`, both need approval.
- **9G/36L urn**: no progress — a promising lead (7227/9G = 40 L) didn't survive verification
  and was discarded rather than used.
