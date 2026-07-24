# HDS Product Research

Research notes behind an HDS enrichment/verification pass on `products.json` (July 2026).
Covers all 18 SKUs currently tagged `"brand": "HDS"`: 3 Broaster pressure fryers, 8 gas/electric
fryers (single-well, split-tank, and 2 replacement-basket parts), 2 electric convection ovens,
1 gas convection oven, 2 heated countertop displays, and 2 archived/incomplete records (a
split electric fryer and a gas range with griddle/salamander).

**No `products.json` changes have been applied yet** — this file is findings + proposals,
same as the outstanding Pradeep items. The one finding below that's fairly high-confidence
(the Broaster brand mistag) is flagged for approval before touching the data.

---

## 1. Brand identification — "HDS" is actually two different things here

The `brands.json` entry for `HDS` points to `https://hdsheldon.com/` — **H.D. Sheldon & Co.**,
a US-based international *representative/distributor* (not a manufacturer) founded in 1944,
representing 50+ foodservice equipment manufacturers (Hatco, Vulcan, Waring, Beverage-Air,
**Broaster**, and others) for export markets. Source:
https://hdsheldon.com/

But most of the 18 SKUs in our catalogue carry **`HDS`-prefixed model numbers themselves**
(`HDSFGH-`, `HDSECO-`, `HDSGCO-`, `HDSGR-`, `HDSHDN-`) — these belong to a **separate company
called Heavy Duty Systems**, whose own site is `heavydutysystems.com` and which is *also*
abbreviated "HDS." It is a distinct entity from H.D. Sheldon & Co — no relationship between the
two is mentioned on either's site, and a third-party distributor page confirms they're presented
as separate brands:
https://www.foodmach.com.ph/hds-heavy-duty-systems/

So the single `HDS` brand tag in this catalogue actually covers two unrelated sourcing chains:

| SKUs | Real manufacturer | Where "HDS" comes from |
|---|---|---|
| 15 fryers/ovens/displays with `HDS*` model numbers | **Heavy Duty Systems** (heavydutysystems.com) | Heavy Duty Systems' own brand initials |
| 3 Broaster pressure fryers (`BROASTER 1600E`/`1800E`/`1800G`) | **Broaster Company** (broaster.com) | Exported via H.D. Sheldon & Co, an unrelated rep firm |

**Broaster is already its own brand in this catalogue** (`brands.json` has a `Broaster` entry,
`https://www.broaster.com`) — so the 3 pressure fryers being tagged `"brand": "HDS"` instead of
`"brand": "BROASTER"` looks like a straightforward brand mis-tag, not a deliberate choice. See
§4.1.

As with the Pradeep research, `sheffieldafrica.com` shows up again as a likely origin of this
catalogue's raw data (e.g. its own listing for the 900mm heated display, same model number) —
treated the same way here: usable as a "what's currently live" reference, never as a
confirmation source. https://sheffieldafrica.com/product/1147/counter-top-heated-display-900mm-hds-hdshdn-36

---

## 2. Where to look — and the traps

| Resource | URL | Value |
|---|---|---|
| Heavy Duty Systems official site | https://heavydutysystems.com/products/ | Best independent source for the 15 `HDS*`-numbered SKUs — category pages list current model numbers; several link to PDF spec sheets |
| Broaster Company official site | https://broaster.com/equipment/broaster-1800/ | Official source for the pressure-fryer family; also has an operation/service manual PDF covering both 1600 and 1800 |
| Independent resellers (multiple countries) | tomadostore.com, benitezcommercial.com, foodmach.com.ph, ekuep.com, inter-americana.com, amsagt.com, phoenixfoodequipment.com | Useful for gap-filling dimensions/specs Heavy Duty Systems' own pages omit |
| Sheffield Africa's own live catalogue | sheffieldafrica.com | **Not independent** — same caution as the Pradeep file; likely the origin of this catalogue's copy |

### Traps

1. **Heavy Duty Systems' current lineup has moved on from some of our exact model codes.**
   The live electric-convection-oven category groups `HDSECO-3A 4A` together under "with Top
   Grill" and separately lists `HDSECO-1` (full size), `HDSECO-6A` (cook & hold), and
   `HDSECO-8A 8AS` — our catalogue's plain `HDSECO-4A` and `HDSECO-8A` aren't wrong, but they
   may be an earlier/simpler generation before Heavy Duty Systems added the top-grill/cook-hold
   variants. Don't assume the current site's grouping text (e.g. "with Top Grill") applies to
   our SKU without separate confirmation.
2. **The split-tank fryer basket parts (00407, 00424, 00425) reuse part numbers across
   different host fryers in a way that isn't independently confirmed.** `70201104400` is used
   for both the `HDSFGH-150S` basket (00407) and the `HDSFGH-90S` basket (00424) — plausible if
   both fryers share a basket size, but no official parts list was found to confirm it; could
   equally be a copy-paste carried over from one SKU to the other (same pattern as the Pradeep
   milk-boiler bug). See §4.2.
3. **`HDSFGH-90S` doesn't appear on Heavy Duty Systems' own split-tank fryer page** — only
   `HDSFGH-120S` and `HDSFGH-150S` are listed there
   (https://heavydutysystems.com/product/gas-split-tank-fryer/). Our SKU 00424 sells "Fryer
   Baskets for HDSFGH-90S" as a standalone accessory, but there's no confirmed HDSFGH-90S fryer
   itself — either a genuine older/regional variant, or a naming slip for the (confirmed)
   single-well `HDSFGH-90`. Left as-is, flagged only.
4. **The "LP" suffix on `HDSFGH-120S LP`** (fryer basket SKU 00425) isn't attested on Heavy Duty
   Systems' own site either — same shape of trap as Fagor's "H" suffix and Sheffield's "PR"
   codes noted in other brand-research files: plausibly a reseller/regional fuel-type tag layered
   on the base model code, not confirmed independently.
5. **SKU typo:** `IMG/HOT/OO438` (Gas Burners with Oven and 24" Griddle/Salamander) uses the
   letter `O` twice instead of the digit `0` — almost certainly should be `IMG/HOT/00438` to
   match the catalogue's `IMG/HOT/00XXX` numbering convention. Not changed — flagging only,
   this is a "fix the underlying data" call for the business, not an independent-research
   finding.

---

## 3. Product reference

| SKU | Catalogue name | Model | Independent source | Confidence |
|---|---|---|---|---|
| IMG/HOT/00332 | Pressure Fryer Electric Broaster 1600 | BROASTER 1600E | https://broaster.com/wp-content/uploads/2020/02/14679-0-1600-1800-Oper-Man-rev-01-18.pdf | **High** — oil capacity (21 lb) matches exactly; dims close but not identical, see §4.3 |
| IMG/HOT/00333 | Pressure Fryer Gas Broaster 1800 | BROASTER 1800G | https://broaster.com/equipment/broaster-1800/ | **High** — 42 lb oil capacity matches exactly |
| IMG/HOT/00390 | Pressure Fryer Electric Broaster 1800 | BROASTER 1800E | same | **High** — 42 lb oil capacity matches exactly |
| IMG/HOT/00344 | Fryer Single 22 Litres Gas HDS-120 | HDSFGH-120 | https://heavydutysystems.com/wp-content/uploads/2024/07/HDS-Gas-HDSFGH-Gas-Fryer.pdf | Medium — model confirmed, per-model BTU/dims not broken out in the PDF text extract |
| IMG/HOT/00345 | Fryer Single 30 Litres Gas HDS-150 | HDSFGH-150 | same | Medium |
| IMG/HOT/00406 | Free Standing 21 Ltrs Single Well Fryer HDSFGH-90 | HDSFGH-90 | https://tomadostore.com/en/hds-fgh-90-gas-floor-fryer-40-lb-stainless-steel-90-000-btu.html | **High** — 40 lb / 90,000 BTU confirmed independently |
| IMG/HOT/00347 | Fryer Split Type 15+15 Ltrs HDS-150S | HDSFGH-150S | https://heavydutysystems.com/product/gas-split-tank-fryer/ | **High** — model confirmed on official split-tank page |
| IMG/HOT/00407 | Fryer Baskets for HDSFGH-150S | 70201104400 | none found independently | Low — part number unconfirmed, see §4.2 |
| IMG/HOT/00424 | Fryer Baskets for HDSFGH-90S | 70201104400 | none found independently | Low — same part number as 00407, host model itself unconfirmed, see §2 trap 3 |
| IMG/HOT/00425 | Fryer Baskets for HDSFGH-120S LP | 70201105746 | none found independently | Low — part number and "LP" suffix both unconfirmed |
| IMG/HOT/00436 | Fryer Split Type 10+10 Litres HDS Electric | (blank) | none — archived, no content | N/A — archived/incomplete record |
| IMG/OVE/00223 | Convection Oven HDSECO-4A | HDSECO-4A | https://anyflip.com/iikmz/yedn/basic (Eagle catering catalogue) | Medium — 62L cavity/spec confirmed via a distributor catalogue, not Heavy Duty Systems' own site directly; current official listing groups this model under "3A 4A ... with Top Grill" (§2 trap 1) |
| IMG/OVE/00224 | Convection Oven HDSECO-8A | HDSECO-8A | same catalogue | Medium — 116L cavity (700×460×360mm) confirmed; our stored 838×685×584mm reads as exterior vs this being interior cavity, not a contradiction |
| IMG/OVE/00201 | Oven Convection Gas HDS GCO | HDSGCO-1 | https://benitezcommercial.com/products/heavy-duty-systems-hdsgco-1 | Medium — 54,000 BTU confirmed exactly; **dimensions do not match**, see §4.4 |
| IMG/DIS/00138 | Heated Display Counter Top 700MM HDS | HDSHDN-26 | https://heavydutysystems.com/product/hot-display-case/ | Medium — the confirmed official line is `HDSHD-26/36/48`; our `HDSHDN-26` carries an extra "N" not seen on the official page, see §4.5 |
| IMG/DIS/00139 | Heated Display Counter Top 900MM HDS | HDSHDN-36 | same | Medium — same "N" discrepancy; also the exact model appears on Sheffield Africa's site (non-independent) |
| IMG/HOT/00437 | 6 Burner Gas Range with Gas Oven HDSGR-36 | HDSGR-36 | https://amsagt.com/wp-content/uploads/2023/07/HDSGR-24.pdf (sibling model's official-style sheet) | Low — archived/no price, name partially confirmed by a sibling model's spec sheet only |
| IMG/HOT/OO438 | Gas Burners with Oven and 24" Griddle/Salamander | (blank) | https://heavydutysystems.com/product/gas-burners-with-oven-and-24-griddle/ (category exists) | N/A — archived/incomplete record; SKU itself has a likely typo, see §2 trap 5 |

---

## 4. Findings (proposals — nothing applied to `products.json` yet)

### 4.1 Brand mis-tag: the 3 Broaster pressure fryers should probably be `brand: "BROASTER"`, not `"HDS"`

`IMG/HOT/00332`/`00333`/`00390` are genuine Broaster Company products (confirmed via
broaster.com and its official spec/operation manuals) — H.D. Sheldon & Co is simply an export
representative for Broaster in some markets, not the manufacturer. This catalogue already has
a proper `Broaster` brand entry in `brands.json` with the correct logo and
`https://www.broaster.com` website. Tagging these 3 SKUs `"brand": "HDS"` both misattributes
the manufacturer and points customers at the wrong brand page/logo on the storefront.
**Proposed:** change `brand` from `HDS` to `BROASTER` on these 3 SKUs. Not applied — brand
reassignment touches storefront brand pages and is a business call, flagged for approval same
as a `model_number` change would be.

### 4.2 Fryer-basket part numbers — plausible but unconfirmed, one possible copy-paste

`70201104400` is used as the `model_number` for **both** the `HDSFGH-150S` basket (00407) and
the `HDSFGH-90S` basket (00424) — two different-sized fryers sharing an identical part number.
No official Heavy Duty Systems parts list was found to confirm whether this is intentional
(same basket size fits both tanks) or a copy-paste of one SKU's spec into the other, the same
kind of bug found and fixed in the Pradeep milk-boiler pass. **Not changed** — no independent
source exists either way, so there's nothing to correct *to*. Flagging only.

### 4.3 Broaster 1600E — dimensions close but not identical to the official manual

Our record: `LENGTH: 406MM, WIDTH: 737MM, HEIGHT: 1088MM`. The official Broaster
operation/service manual area (via a distributor citing it) gives `457×914×1168mm`. Same
general size class, cooking-oil capacity matches exactly (21 lb both), so this reads as a
minor sourcing/rounding difference or a running product change rather than a wrong-model
mix-up. Left as-is — noted for awareness, not corrected (would need the primary PDF measured
directly, not a secondary citation, before overwriting a specific number).

### 4.4 HDSGCO-1 — BTU matches exactly, but stored dimensions look very wrong

Our record: `Dimension 967 x 1099 x 1384 mm - Weight 185kg/275kg`, `54,000 BTU`. Heavy Duty
Systems' official spec (via https://benitezcommercial.com/products/heavy-duty-systems-hdsgco-1)
gives **29" W × 26" D × 20" H** (≈737 × 660 × 508 mm) for the same 54,000 BTU model — the BTU
figure matches exactly, but our stored dimensions are roughly 2–3× larger on every axis. That's
too large a gap to be measurement variance; it reads like our dimension field may have been
copied from a different (larger/double-stack) oven or a shipping-crate figure. **Proposed:**
replace `967 x 1099 x 1384 mm` with `737 x 660 x 508 mm` (29"×26"×20") — needs approval before
editing `products.json`, and ideally a second independent source before committing to the exact
mm conversion (only one distributor page was checked).

### 4.5 Heated displays — our model numbers carry an extra "N" not seen on Heavy Duty Systems' own site

Heavy Duty Systems' current hot-display-case page lists the family as `HDSHD-26`/`HDSHD-36`/
`HDSHD-48` (https://heavydutysystems.com/product/hot-display-case/). Our catalogue's
`HDSHDN-26`/`HDSHDN-36` insert an extra "N". This exact "HDSHDN-36" spelling *does* appear on
Sheffield Africa's own listing (non-independent — see §1), so the "N" isn't a one-off
catalogue typo, but no source independent of Sheffield confirms it either. Left unresolved —
same shape of gap as the Pradeep `9G`/36L urn (a spelling/code variant that only the
non-independent source corroborates).

---

## 5. Net effect of this pass

**Applied to `products.json` (user-approved, July 2026):**

- **§4.1 brand fix:** `IMG/HOT/00332`/`00333`/`00390` changed from `brand: "HDS"` to
  `brand: "BROASTER"` (matching the existing `Broaster` entry in `brands.json`). Their
  `short_description` text also had the now-inaccurate "by HDS" phrase removed.
- **§4.4 HDSGCO-1 dimension fix:** `length`/`width`/`height` changed from `967/1099/1384` to
  `737/660/508` (29"×26"×20", the officially confirmed size), and `technical_specification`
  updated to match, with interior details added (porcelain enamel interior, 13-position rack, 4
  chrome-plated racks, side-hinged double doors, double-pane thermal glass, 150–550°F range,
  ½ HP motor, 6 ft cord).
- **New: HDSFGH-120 (`IMG/HOT/00344`) copy-paste bug fixed.** Its description said "Gas Fryer
  **150K** BTU" — verbatim copied from the 150 model's description (see §2, this wasn't caught
  in the original pass, only surfaced while sourcing confirmation data). Corrected to
  **120,000 BTU** to match its own model number, and a full `technical_specification` was added
  from Heavy Duty Systems' own official spec PDF (confirmed dims 394×767×1182mm, net/gross
  weight 71/82 lbs): https://amsagt.com/wp-content/uploads/2023/07/HDSFGH-120.pdf
- **New: HDSFGH-90 (`IMG/HOT/00406`) filled in.** Was a bare name/price with no description or
  spec at all. Added description and `technical_specification` from two independent sources
  agreeing on 90,000 BTU / 40 lbs oil capacity, and dims (394×767×1182mm, matching the 120's
  cabinet footprint, confirmed by both the official 120 spec sheet and a third-party HDSFGH-90
  listing): https://www.inter-americana.com/product-page/freidora-a-gas-hdsfgh-90?lang=en and
  https://www.foodmach.com.ph/hds/hds-professional-gas-deep-fryer-model-hdsfgh-90/
- **HDSECO-4A / HDSECO-8A enrichment:** added the confirmed cavity capacities (62L for the 4A;
  116L / 700×460×360mm interior cavity plus 4× 600×400mm trays for the 8A) to
  `technical_specification`, without touching the existing exterior dimensions or thermostat
  ranges those secondary sources didn't clearly corroborate.

**Not applied — still open:**

- §4.2 (fryer-basket part number `70201104400` shared between the 90S and 150S baskets) — no
  independent source either way, nothing to correct *to*.
- §4.5 (the "N" in `HDSHDN-26`/`HDSHDN-36`) — only Sheffield Africa's site uses this exact
  spelling; no independent corroboration found.
- §2 trap 3 (`HDSFGH-90S` doesn't appear on Heavy Duty Systems' own split-tank page).
- §2 trap 5 (`IMG/HOT/OO438` SKU typo — letter-O instead of zero) — a data-entry fix, not
  something research can resolve; flagged for the business to correct directly.
