# Kitchenware Product Research

Research notes behind a KITCHENWARE audit pass on `products.json` (July 2026). Covers all
20 KITCHENWARE SKUs: 10 items of stainless cookware (5 stock pots, 5 high sauce pans),
4 chafing dishes, 2 non-stick GN containers, 1 vegetable processor, 1 juice dispenser,
1 infrared heat lamp and 1 induction cooker.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema and Cambro passes before a scope decision.

Headline, stated plainly up front: **"Kitchenware" is not a manufacturer.** It is a house
label covering product from at least three unrelated sources, and no amount of searching
will produce a company behind it (§1). That was established early and the pass was then
spent where there *is* real signal — decoding the cookware codes against geometry (§2),
which required no web source at all and reconciled **all 12** capacity figures, and
chasing the codes that *do* belong to real brands (§3), which turned up **Signature** as
the actual source of the buffet SKUs.

---

## 1. Brand identification — "Kitchenware" is a house label, not a company

`brands.json` entry:

```
slug: kitchenware  |  name: Kitchenware  |  website_url: null  |  logo: null
description: "Wanhui manufactures commercial kitchen equipment and appliances. They focus
              on providing efficient cooking and food preparation solutions for
              professional kitchens."
```

**The row's own description is about a different company.** It describes *Wanhui*, not
anything called Kitchenware. Whoever wrote it already knew this row was a placeholder.

Six independent reasons this is not a real brand:

1. **"Kitchenware" is a generic English noun.** No manufacturer trades under it bare. It
   is, however, an extremely common *suffix* in Chinese OEM company names — Chaozhou
   Diwell Stainless Steel Kitchenware, Yongyu Kitchenware, Jiangsu Xinyuehai Commercial
   Kitchenware, Jiangmen Changwen Cookware & Kitchenware. Dozens exist; none is simply
   "Kitchenware". A buyer writing "Kitchenware" on a purchase order has recorded the
   *category*, not the vendor.
2. **`website_url` is null and no logo exists** — unlike Brema or Cambro, there is nothing
   to link to.
3. **The 20 SKUs carry at least seven unrelated code grammars** — `QC205A`, `SJD10A`,
   `RA23xx`, `ECD09C`, `XD-HHB900`, `NF811-xx`, and the `SDI`/`SD2`/`CSP` cookware family.
   No single manufacturer numbers its range seven different ways. This is a purchasing
   bucket, not a catalogue.
4. **The one code that is fully traceable belongs to someone else.** `QC205A` is a generic
   Chinese OEM vegetable cutter sold under Welldone, Fomac, Horus, Yunxun, Adexa, Canmac,
   KRD and others (§3.1).
5. **The buffet codes belong to Signature.** `RA2302` and `SJD10A` both resolve to
   Signature part numbers with the `CS-` prefix stripped (§3.2, §3.3).
6. **The catalogue already contains the real brand for part of this set.** `WANHUI` exists
   as a brand value on 2 products and its cookware is *the same family* as this one (§4.1).

**Recommendation: leave `model_number` alone, but treat `brand: KITCHENWARE` as an
unresolved placeholder** to be split by source once a supplier confirms who ships what.
Do not invent a `website_url` for it.

---

## 2. Decoding the cookware codes — geometry, not sourcing

This is the part of the pass that needs no web source and is therefore the most defensible
thing in this file.

The 10 cookware codes encode **internal diameter × height in centimetres**:

```
SDI | SD2 | CSP   +   DD   +   HH
                      │        └─ height, cm
                      └────────── diameter, cm
```

If that reading is right, the stated litre figure must reconcile with the volume of a
cylinder, **V = π(d/2)²h**. It does — for every one of them, including the two sibling
records filed under `WANHUI`:

| SKU | Code | d × h (cm) | Brim-full πr²h | Stated | Δ | Direction |
|---|---|---|---|---|---|---|
| IMG/TCW/00355 | `SDI2828` | 28 × 28 | 17.24 L | 17 L | −1.4 % | under ✔ |
| IMG/TCW/00368 | `SDI3636` | 36 × 36 | 36.64 L | 36 L | −1.8 % | under ✔ |
| IMG/TCW/00386 | `CSP 2525` | 25 × 25 | 12.27 L | 12 L | −2.2 % | under ✔ |
| IMG/TCW/00388 | `SDI4545` | 45 × 45 | 71.57 L | 71 L | −0.8 % | under ✔ |
| IMG/TCW/00389 | `SDI4040` | 40 × 40 | 50.27 L | 50 L | −0.5 % | under ✔ |
| IMG/TCW/00354 | `SD22816` | 28 × 16 | 9.85 L | 10 L | **+1.5 %** | **over** ⚠ |
| IMG/TCW/00357 | `SD22414` | 24 × 14 | 6.33 L | 6.5 L | **+2.6 %** | **over** ⚠ |
| IMG/TCW/00382 | `SD22013` | 20 × 13 | 4.08 L | 4 L | −2.1 % | under ✔ |
| IMG/TCW/00519 | `SDI2518` | 25 × 18 | 8.84 L | 8.5 L | −3.8 % | under ✔ |
| IMG/TCW/00520 | `SDI3222` | 32 × 22 | 17.69 L | 18 L | **+1.7 %** | **over** ⚠ |
| IMG/TCW/00363 † | `SDI2525` | 25 × 25 | 12.27 L | 12 L | −2.2 % | under ✔ |
| IMG/TCW/00366 † | `SDI3624` | 36 × 24 | 24.43 L | 24 L | −1.8 % | under ✔ |

† filed under brand `WANHUI`, included because they are the same code family (§4.1).

### 2.1 What reconciled, and what the sign pattern means

**Nothing fails outright — all 12 land within ±4 %**, which on its own confirms the
cm-encoding reading beyond reasonable doubt. A wrong decoding would produce errors of tens
of percent, not single digits. **The codes are trustworthy and the capacities are broadly
honest.**

The interesting result is in the *sign*, not the size, of the error:

- **All 5 stock pots understate** brim-full volume by 0.5–2.2 %. That is the physically
  correct direction — a pot's usable capacity is always a little less than its brim-full
  geometry, because you cannot fill to the rim. Both `WANHUI` siblings behave the same way.
- **3 of the 5 sauce pans overstate it** — `SD22816` (10 L claimed vs 9.85 L brim-full),
  `SD22414` (6.5 vs 6.33) and `SDI3222` (18 vs 17.69).

A vessel cannot hold more than its own brim-full volume. If the code dimensions are
internal, those three figures are **impossible as usable capacities** and are marketing
round-ups to the nearest convenient number. If the code dimensions are *external* — which
is at least as likely for a stamped code — then the internal volume is smaller still and
the overstatement is worse, not better.

The overstatements are small (1.5–2.6 %) and no customer will ever measure them. **This is
a copy-accuracy note, not a product defect.** The honest fix is to describe these as
nominal sizes ("28 × 16 cm, approx. 10 L") rather than asserting an exact litreage.

`SDI2518` is the largest single gap (−3.8 %, 8.84 L geometry vs 8.5 L claimed) but errs in
the safe direction and needs no action.

### 2.2 Three prefixes for one product family

The same physical range carries **three different prefixes** with no discernible rule:

- `SDI` — 6 SKUs (`SDI2828`, `SDI3636`, `SDI4545`, `SDI4040`, `SDI2518`, `SDI3222`, plus
  `SDI2525`/`SDI3624` on the WANHUI records)
- `SD2` — 3 SKUs (`SD22816`, `SD22414`, `SD22013`)
- `CSP` — 1 SKU (`CSP 2525`, the only one with an embedded space)

`SDI` and `CSP` are demonstrably applied to **the same pot**: `CSP 2525` (00386) and
`SDI2525` (00363) are both 25 × 25 cm, both 12 L (§4.1).

`SDI` vs `SD2` is very likely an **I/1/2 transcription artefact** rather than a real
distinction — the same `I`↔`1` confusion shows up in the product names, where the WANHUI
casserole is named `E13624` while its model is `SDI3624`.

### 2.3 The names carry a *different, contradictory* code

Every cookware name embeds a code, and it disagrees with `model_number` in 9 of 10 cases:

| SKU | Code in `name` | `model_number` | Agree? |
|---|---|---|---|
| IMG/TCW/00355 | `EI2828` | `SDI2828` | ✗ prefix |
| IMG/TCW/00368 | `EI3636` | `SDI3636` | ✗ prefix |
| IMG/TCW/00386 | `CSP 2525` | `CSP 2525` | **✔** |
| IMG/TCW/00388 | **`CSP 4545`** | **`SDI4545`** | ✗ **different family** |
| IMG/TCW/00389 | **`CSP 4040`** | **`SDI4040`** | ✗ **different family** |
| IMG/TCW/00354 | `E22816` | `SD22816` | ✗ prefix |
| IMG/TCW/00357 | `E22414` | `SD22414` | ✗ prefix |
| IMG/TCW/00382 | *(none)* | `SD22013` | — |
| IMG/TCW/00519 | `SS 25X18` | `SDI2518` | ✔ numerically |
| IMG/TCW/00520 | `SS 32X22` | `SDI3222` | ✔ numerically |

**The numeric part always agrees; only the prefix ever differs.** Dropping the leading `S`
from `SEI2828`/`SE22816`-style codes produces exactly the `EI`/`E2` name forms, so the two
sets look like the same code transcribed from two sources, one of which lost a character.

Two rows are worse than a prefix slip: **00388 and 00389 are named `CSP 4545` / `CSP 4040`
but modelled `SDI4545` / `SDI4040`** — the name asserts one family and the model another.
And **00519/00520 use a third naming convention again** (`SS 25X18`), which at least states
the dimensions in plain text and is the clearest of the three.

### 2.4 Contrast — this grammar is supplier-specific, not a standard

Worth recording so nobody generalises it: Adexa's aluminium pot range uses codes like
`ALSTP12` → 11 L, `ALSTP32` → 30 L, `ALSTP100` → 94 L. Those decode as **US quarts**
(12 qt = 11.4 L, 32 qt = 30.3 L, 100 qt = 94.6 L), not centimetres.
https://adexa.co.uk

So a numeric cookware suffix means nothing until the vendor's grammar is known. Our
`SDI`/`SD2`/`CSP` family is cm × cm; Adexa's is quarts. **Never decode a cookware code by
analogy with another brand.**

---

## 3. The codes that trace to real products

### 3.1 IMG/FPR/00239 — `QC205A` vegetable processor ✅ real, widely-copied OEM model; **power figure looks wrong**

`QC205A` is a genuine, findable model — but it belongs to no one in particular. It is a
generic Chinese OEM design resold under at least eight labels:

| Seller / label | Their code |
|---|---|
| Welldone (Food Machinery Union) | `WED-QC205A` |
| Fomac (Indonesia) | `VGC-QC205A` |
| Horus | `QC-205A` / `QC-205B` |
| Yunxun | `WED-QC205A` |
| Adexa (UK) | `YFC205` |
| Canmac (UK) | `YFC205` |
| KRD Catering (UK) | `QC205A` |
| NEWRTY (Amazon) | unbranded |

**Decoding: "205" is the cutting-disc diameter in mm.** Welldone's own spec table lists
"Knife Disc Diameter 205 mm", which pins it down. `QC` is almost certainly *qiē cài*
(切菜, "vegetable cutting").

**⚠ The stored power rating of 350 W matches no source.** Our `description` and
`technical_specification` both say "Power: 350W". Published figures:

| Source | Power |
|---|---|
| Welldone `WED-QC205A` spec table | **1000 W** |
| Adexa `YFC205`, Canmac `YFC205`, Amazon NEWRTY, KRD title | **750 W** |
| KRD body copy / URL slug | **1100 W** |
| **Our record** | **350 W** |

Sources disagree with each other (750 / 1000 / 1100 W) because different factories build to
different motors, but **none is anywhere near 350 W**, and 350 W is implausible for a
machine rated at 120–150 kg/h. Treat 350 W as an error; do not publish a replacement figure
until the supplier states which motor ships.

**⚠ Dimensions — three sets in circulation, and the popular one is a packing size.**

| Source | Figure |
|---|---|
| Welldone — *machine* | 675 × 345 × 540 mm |
| Welldone — *packing* | 580 × 385 × 550 mm |
| Adexa / KRD (quoted as product dims) | 580 × 385 × 550 mm |
| Amazon NEWRTY | 590 × 270 × 480 mm |
| **Our record** | **590 × 265 × 540 mm** |

The UK resellers are quoting **Welldone's carton size as if it were the machine** — the
figures are identical. Our stored height (540) matches Welldone's machine height exactly,
and our length/width (590 × 265) match Amazon's (590 × 270) closely. Our record is
internally plausible; just don't "correct" it to the 580 × 385 × 550 carton.

**Confirmed and safe to add:** 5 grating/slicing discs (already in the description ✔);
cutting sizes slice 4.5 mm / 2 mm, shred 3 mm, dice 8 × 8 mm; output 120–150 kg/h;
net 28 kg / gross 33 kg (Welldone) or 26 kg net (resellers); 220 V/50 Hz (✔ as stored);
300 rpm; aluminium body; magnetic safety cut-off that stops the machine when the feed
handle or cover is lifted; CE marked.

Sources:
https://foodmachineryunion.en.made-in-china.com/product/mCXnsVRzCvkL/China-Welldone-Wed-QC205A-Durable-and-Energy-Saving-Vegetable-Cutter.html
https://adexa.co.uk/Food-Prep-Machines-29/Vegetable-Prep-Machines-224/Commercial-Fruit-and-Vegetable-Cutter-750W-Adexa-YFC205
https://canmac.co.uk/products/commercial-fruit-and-vegetable-cutter-750w-yfc205
https://krdcatering.co.uk/products/krd-commercial-fruit-vegetable-cutter-120kg-hr-1100w-qc205a
https://www.fomac.co.id/asset/manual-book/VGC-QC205A.pdf
https://haruisappliance.en.made-in-china.com/product/OdaGoPRvlSpw/China-Horus-Multi-Functional-Slicer-Vegetable-Cutter-QC-205A-QC-205b-for-Sale.html
https://www.alibaba.com/product-detail/QC205A-Professional-Electric-Fruit-and-Vegetable_1601023065721.html

### 3.2 The `RA23xx` chafing dishes — **Signature codes with the `CS-` prefix stripped**

Three of our four chafers share an `RA23xx` root, and the family decodes cleanly:

| Our model | Full manufacturer code | Meaning | Our SKU | Price |
|---|---|---|---|---|
| `RA2301` | `CS-RA2301` | 9 L GN1/1 roll-top, **fuel-heated, plain lid** | IMG/BUF/00177 | KSh 28,980 |
| `RA2301AE` | `CS-RA2301AE` | same, **`AE` = electric** water pan 220 V / 800 W | IMG/BUF/00178 | KSh 43,470 |
| `RA2302` | `CS-RA2302` | 9 L roll-top **with viewing window / glass lid** | IMG/BUF/00095 | KSh 37,260 |

The `-02` = window reading is confirmed by a live listing of the exact code:
**"Signature 9L Roll Top/Window Cheffing Dish CS-RA2302"**
https://almardesigns.com/signature-9l-roll-top-window-cheffing-dish-cs-ra2302/

…and our own `RA2302` description already says "with Glass Lid", which agrees. The plain
`-01` variant is documented independently as **"9 ltr 1/1 full size chafing dish complete
with roll top lid and twin fuel holders"** (Quattro `RA2301B`).

**The price ladder independently corroborates the whole decoding**: plain (28,980) <
window (37,260) < electric (43,470). Three prices in exactly the order the code grammar
predicts.

**This is the single most useful result for `IMG/BUF/00177`, which currently has no
description at all** — it can now be written with confidence as the entry-level,
fuel-heated, plain-lid member of a three-model ladder, explicitly contrasted with its two
siblings already in the catalogue.

**Comparable published spec** for a 9 L GN1/1 roll-top chafer (Adexa `R23301` — note the
near-identical code root, though it is a different vendor's part):
625 × 365 × 445 mm, 6 kg, stainless steel, mirror polish, wet-heat operation with
stainless water and food pans.
https://adexa.co.uk/Roll-top-Chafer-GN1-1-Stainless-steel-Mirror-polish-9-litres-Adexa-R23301

⚠ **That comparable puts our stored heights in doubt** — see §4.2. A roll-top chafer is
~445 mm tall closed; our records variously claim 290 mm and 550 mm.

Further sources:
https://www.ecatering.co.uk/products/stainless-steel-roll-top-chafing-dish-full-size-1-1-gn-9-litre-capacity
https://www.buzzcateringsupplies.com/roll-top-chafing-dish-with-window-gastronorm-gn-1-1-9-litre.html

### 3.3 IMG/BUF/00092 — `SJD10A` juice dispenser ✅ decoded via a Kenyan-market sibling; **price needs a sanity check**

`SJD10A` did not resolve directly, but its **8-litre sibling did**, on a Kenyan retail site:

**"8L Signature Single Bowl Juice Dispenser `CS-SJD-08A`"** — KSh 6,500 (from KSh 6,800),
food-grade stainless body, transparent bowl, tap with flow control, 6 kg, detachable parts.
A `CS-SJD-08B` also exists: **16 L double bowl**, KSh 12,500.
https://smartenterprise.co.ke/product/8l-signature-single-bowl-juice-dispenser-cs-sjd-08a/

That gives the whole grammar:

```
CS-  SJD  -  NN  -  A|B
 │    │      │      └─ A = single bowl, B = double bowl
 │    │      └──────── litres per bowl
 │    └─────────────── Signature Juice Dispenser
 └──────────────────── Signature prefix (same as CS-RA2302, §3.2)
```

So **`SJD10A` = `CS-SJD-10A`, Signature, 10 litres, single bowl** — which matches our
record's name ("Juice Dispenser 1 Bowl - 10 Litres") exactly. Note the `08B` is *16 L*
because it is 2 × 8 L bowls, confirming the number is litres **per bowl**, not total.

**⚠ Price flag.** Our `SJD10A` is KSh 22,500. The Kenyan market price for the 8 L sibling
is KSh 6,500 — **3.5× less for 25 % less capacity**. Some of that gap is real (different
retailer, possibly a heavier-duty commercial unit vs a light one, different margin), but a
3.5× spread on the same product family in the same market is large enough to be worth a
deliberate look rather than an assumption.

### 3.4 IMG/BUF/00179 — `ECD09C` ⚠ unverifiable externally, **and our own live site disagrees with `products.json`**

`ECD09C` returns nothing anywhere except **sheffieldafrica.com itself**, which is circular
and not independent verification. The code is self-consistent though — `ECD` = Electric
Chafing Dish, `09` = 9 litres.

**The genuinely useful finding is a name discrepancy inside our own estate.** The live
Sheffield site calls this product:

> **"CHAFING DISH ROLL TOP DOUBLE PAN 9 LITRES ELECTRIC"**
> https://sheffieldafrica.com/kitchen/product/429/chafing-dish-roll-top-double-pan-9-litres-electric-ecd09c

`products.json` calls it **"Chafing Dish Roll Top Electric ECD09C"** — **"Double Pan" is
missing**. That is the one feature distinguishing it from `RA2301AE` (also electric, also
9 L, also roll-top, KSh 43,470 vs 37,800). Without it the two records are near-duplicates
with no stated reason for the price difference; with it, the difference is explained.

Everything else on the live page (620 × 370 × 290 mm, 220 V/800 W, temperature control and
display) matches `products.json` — including, notably, matching the **prose** dimension
order rather than the numeric fields (§4.2).

### 3.5 IMG/TCW/00526 & 00527 — `NF811-20` / `NF811-40` ⚠ code unverifiable; **material is unstated and it matters**

`NF811` returns nothing. The suffix is self-consistent — **`-20` and `-40` are the depth in
mm**, and both are standard EN 631 Gastronorm depths, so the code follows the same
dimension-encoding habit as the cookware. `NF` plausibly = "Non-stick, Full-size".

What *is* solid is the standard these must conform to. GN 1/1 is **530 × 325 mm** by
EN 631, and published capacities for that footprint are **≈ 2.5 L at 20 mm** and
**≈ 5.5 L at 40 mm**.
https://www.gastronorm.it/en/GN-1-1-containers-530x325-mm-in-stainless-steel
https://www.gastronorm.it/en/The-Gastronorm-measures

**⚠ The material is not stated on either record, and the two candidates behave very
differently.** Shallow non-stick GN pans in this depth range are typically **aluminium with
a PTFE coating** — bakery and roasting trays — rather than coated stainless:
https://www.intergastro.com/gastronorm-container-gn-1-1-aluminum-non-stick-coated-h-20-mm-250845
https://maxima.com/en/non-stick-teflon-gastronorm-container-1-1gn-20mm-5.html
https://www.gastroland.fr/en/gn-11-non-stick-containers/1143-gn-11-non-stick-gastronorm-container-height-65-mm-3701666006715.html

If they are coated aluminium, then the current `short_description` ("for baking and
serving") is right about baking but the records must **not** later be written up as
general-purpose bain-marie or storage pans: coated aluminium is unsuitable for prolonged
contact with acidic food, intolerant of metal utensils, and often not dishwasher-rated.
That is a usage-restriction question, so it should be answered before the descriptions are
written, not after.

**⚠ Pricing/stock oddity:** both SKUs are priced **identically at KSh 8,280** despite one
being twice the depth of the other, and stock is 205 units vs 1.

**Good news for the write-up:** 25 sibling GN container records (mostly BERJAYA) already
carry well-structured descriptions explaining the EN 631 interchangeability argument. These
two can follow that established house pattern directly, with the non-stick angle added —
no new research needed once the material is confirmed.

### 3.6 IMG/BUF/00236 — `XD-HHB900` heat lamp ❌ **not verified; the emptiest record in the set**

Nothing found for `XD-HHB900`, `HHB900` or `HHB-900` under any vendor. The only decodable
element is **`900` = 900 mm length**, which agrees with the product name.

The record has **no description, no technical specification and no dimensions**. For a
strip-type infrared warmer the unknowns are all the ones that matter commercially:

- **Power rating** — unknown. Comparable full-size infrared strip warmers run ~940 W.
- **Mounting method** — unknown, and there are three incompatible options (bridge/gantry
  mount, ceiling suspension, free-standing on legs). A buyer cannot order without this.
- **Element type** — quartz vs ceramic vs metal-sheathed.
- **Controls** — switched, or infinite-control/dimmer.
- **Finish/material.**

⚠ **The 9 sibling heat-lamp records in the catalogue are not a safe template.** They are
WINNERS and HK-REDLINE **bulb/dome** lamps (`D7016T`, `ZT001`, `A032`, `A035`, `D002`,
`D005`, `D011`) — a decorative single-point product. A 900 mm strip warmer is a different
category with different physics and mounting. Copying their copy across would produce a
confidently wrong description.

**This SKU cannot be written up from research. It needs the supplier's spec sheet.**

### 3.7 IMG/BUF/00090 — `A6-650N-32` induction cooker ❌ not verified, **internally contradictory**, and **filed under the wrong brand**

`A6-650N-32` returns nothing. The nearest thing found is AT Cooker's `BZT-A6 650` series
naming, which is suggestive of a shared OEM lineage but is **not a match** and should not
be used as a source. https://www.atcooker.com/product/commercial-induction-stove/

**⚠ The record contradicts itself.** Its `description` says:

> "Chaffing induction warmer"

…while its `technical_specification` says **3500 W**. Those describe two different
products. A chafing-dish induction *warmer* is a low-power (typically ~400–600 W) buffet
holding plate. A 3500 W unit is a full induction **cooking hob**. One of the two fields is
wrong and they cannot be reconciled.

The stored dimensions (360 × 382 × 120 mm, taking the prose reading — §4.2) are consistent
with a **countertop cooking hob**, which weighs the evidence toward 3500 W being right and
the "chafing warmer" description being the error. The `short_description` ("entry-level
induction hob") agrees. **Recommend deleting the "chaffing induction warmer" line** — but
confirm the wattage with the supplier before publishing 3500 W, since nothing external
corroborates it.

**⚠ Brand assignment — flagged, not changed.** The product is named **"Induction Cooker
Wanhui"** but filed under `brand: KITCHENWARE`, while a separate `WANHUI` brand exists in
the catalogue on 2 other products. See §4.1.

---

## 4. Cross-cutting findings

### 4.1 The KITCHENWARE / WANHUI split is not a real distinction — and one product is duplicated across it

Four separate pieces of evidence, which together are stronger than any of them alone:

1. **`brands.json`'s `kitchenware` description is verbatim about Wanhui** (§1). Someone
   already treated the two as the same thing.
2. **`IMG/BUF/00090` is named "Induction Cooker Wanhui" but branded KITCHENWARE.**
3. **The cookware is one continuous family across both brands.** `SDI2828`, `SDI3636`,
   `SDI4040`, `SDI4545`, `SDI2518`, `SDI3222` sit under KITCHENWARE; `SDI2525` and
   `SDI3624` sit under WANHUI. Same prefix, same cm×cm grammar, same 18/8 stainless
   3-ply-base build, same naming convention (`EI2828`, `EI2525`, `E13624`). Splitting them
   by brand is arbitrary.
4. **⚠ There is a probable duplicate SKU across the split:**

| | IMG/TCW/00386 | IMG/TCW/00363 |
|---|---|---|
| Name | Stock Pot 12 Litres CSP 2525 | Stock Pot 12 Litres EI2525 |
| Brand | **KITCHENWARE** | **WANHUI** |
| `model_number` | **`CSP 2525`** | **`SDI2525`** |
| Dimensions | 25 × 25 cm | 25 × 25 cm |
| Capacity | 12 L | 12 L |
| Price | **KSh 6,900** | **KSh 6,000** |
| Quantity | 2 | 15 |

Same diameter, same height, same capacity, same product category — **listed twice, under
two brands, with two model numbers, at a 15 % price difference.** Either these are one
product duplicated (and one record should be retired, with its stock merged), or they are
two genuinely different builds that happen to share every published figure — in which case
nothing in the catalogue distinguishes them and a customer cannot choose between them.

**⚠ Additionally, `WANHUI` has no `brands.json` row at all.** It is used as a brand value
by 2 products but is absent from the brands file — consistent with the known backlog of
brands referenced by `products.json` but missing from `brands.json`. `WANHUI` does appear
to be a real (if small) Chinese supplier: an Alibaba listing exists for "Wanhui BC001
stainless steel kitchen supplies, optional induction burner & chafing dish", which lines up
with exactly the product types in this set.
https://www.alibaba.com/product-introduction/Stainless-steel-kitchen-supplies-industrial-kitchen_1600071196986.html

### 4.2 The width/height transposition bug appears again — on all 4 dimensioned non-cookware SKUs

In every record here that has numeric dimensions and a prose spec, **the numeric `width`
and `height` fields are swapped relative to the record's own prose**:

| SKU | Numeric `length`/`width`/`height` | Prose `technical_specification` |
|---|---|---|
| IMG/BUF/00095 `RA2302` | 635 / **550** / **425** | L 635, W **425**, H **550** |
| IMG/BUF/00178 `RA2301AE` | 645 / **290** / **455** | L 645, W **455**, H **290** |
| IMG/BUF/00179 `ECD09C` | 620 / **290** / **370** | L 620, W **370**, H **290** |
| IMG/BUF/00090 induction | 360 / **120** / **382** | L 360, W **382**, H **120** |

Same bug already documented in the Santos, Empero, Brema and Cambro passes. **The prose is
the correct orientation here**, on two independent grounds:

- **`ECD09C` is confirmed by our own live site**, which publishes 620 / 370 / 290 in the
  prose order. https://sheffieldafrica.com/kitchen/product/429/chafing-dish-roll-top-double-pan-9-litres-electric-ecd09c
- **The induction cooker is decidable on physics alone**: the numeric reading would make it
  360 mm wide × 120 mm deep × 382 mm tall — a 382 mm-tall countertop hob 120 mm deep is not
  a real object. The prose reading (360 × 382 × 120) is an ordinary countertop induction
  hob. Only one reading is possible.

**So the fix is to swap the numeric `width` and `height` fields on all four.**

⚠ **But do not treat the prose as fully correct either.** A comparable 9 L GN1/1 roll-top
chafer is **445 mm tall** (Adexa `R23301`, §3.2). Our prose heights are **290 mm** for both
electric chafers and **550 mm** for `RA2302`. 290 mm is too short for a roll-top lid to
clear a GN 1/1 pan; 550 mm is unusually tall. Likewise the prose depths (425–455 mm) exceed
the 365 mm of the comparable. **The transposition fix is safe and worth doing; the
underlying source figures still want a tape measure.**

### 4.3 The cookware dimension fields are in the wrong unit and inconsistently populated

Separate from §4.2, the cookware records store **centimetres** where the rest of the
catalogue uses **millimetres** — and put them in different fields each time:

| SKU | `length` | `width` | `height` | Should be |
|---|---|---|---|---|
| IMG/TCW/00355 | 28 | *null* | 28 | Ø280 × 280 mm |
| IMG/TCW/00368 | 36 | *null* | 36 | Ø360 × 360 mm |
| IMG/TCW/00386 | 25 | **25** | *null* | Ø250 × 250 mm |
| IMG/TCW/00388 | 45 | *null* | 45 | Ø450 × 450 mm |
| IMG/TCW/00389 | *null* | *null* | *null* | Ø400 × 400 mm |
| all 5 sauce pans | *null* | *null* | *null* | per §2 table |

Three different patterns across five pots, values in cm not mm, and **10 of the 10 cookware
SKUs are missing at least one dimension** (00389 and all five sauce pans have none at all).
Since §2 establishes the true diameter and height for every one of them from the code, **all
10 can be populated correctly from the model number with no supplier input required.** A
round pot has no meaningful "length"/"width" distinction, so the sane convention is
diameter → `length` (or `width`), height → `height`, in mm.

### 4.4 Description coverage is the real problem, and the boilerplate is copy-pasted

10 of 20 SKUs have **no `description` and no `technical_specification` whatsoever**. Of the
10 that do, the four stock pots share a **verbatim identical** block:

> "Constructed of 20 gauge 18/8 stainless steel with a heavy-duty, 3-ply bottom consisting
> of two layers of stainless steel surrounding a 5 mm thick aluminum core… Two reinforced
> stainless steel handles aid in easy transportation throughout your kitchen."

Only the "Heavy-Duty NxN" line changes. That is genuinely useful — it means **`SDI4040`
(00389) can be completed from its four siblings with zero risk**, since it is the same
product at a different size. Note this copy is US-market boilerplate ("20 gauge 18/8",
"aluminum") and reads as lifted from a WebstaurantStore-style listing rather than written
for this catalogue.

**The five sauce pans have no such luck — not one of the five has a description**, so there
is no in-house template to copy. They will have to be written from the geometry in §2 plus
whatever the supplier confirms about gauge and base construction. Do **not** assume they
share the stock pots' 3-ply 5 mm aluminium-core base; that is a real construction claim and
nothing in the record supports extending it.

Every one of the 20 does at least have a `short_description`, and all 20 are `published`
with a non-empty `image` — so nothing here is invisible on the storefront. The gap is depth,
not existence.

⚠ Several `short_description` values still end with "…in Kenya" / "across Kenya", which is
SEO copy sitting in the neutral-summary field — the split documented in
[[project_description_field_split]] has not been applied to any of these 20.

---

## 5. Product reference

Confidence key: **Verified** = exact code confirmed on an independent third-party source.
**Derived** = established by geometry/grammar without a source. **Unverified** = no external
source found.

| SKU | Catalogue name | Model | Real identity found | Source | Confidence |
|---|---|---|---|---|---|
| IMG/FPR/00239 | Commercial Vegetable Food Processor QC205A | `QC205A` | Generic OEM cutter, 205 mm disc; Welldone `WED-QC205A` et al. | https://foodmachineryunion.en.made-in-china.com/product/mCXnsVRzCvkL/China-Welldone-Wed-QC205A-Durable-and-Energy-Saving-Vegetable-Cutter.html | **Verified** — exact code, 8 sellers. ⚠ stored 350 W contradicted by all |
| IMG/BUF/00092 | Juice Dispenser 1 Bowl - 10 Litres | `SJD10A` | **Signature `CS-SJD-10A`** — 10 L single bowl | https://smartenterprise.co.ke/product/8l-signature-single-bowl-juice-dispenser-cs-sjd-08a/ | **Derived (high)** — 8 L sibling `CS-SJD-08A` verified; grammar unambiguous. ⚠ price 3.5× sibling |
| IMG/BUF/00095 | Chafing Dish Roll Top 9 Litres RA2302 | `RA2302` | **Signature `CS-RA2302`** — 9 L roll-top **with window** | https://almardesigns.com/signature-9l-roll-top-window-cheffing-dish-cs-ra2302/ | **Verified** — exact code incl. the window distinction |
| IMG/BUF/00177 | Chafing Dish Roll Top 9 Litres RA2301 | `RA2301` | 9 L GN1/1 roll-top, fuel-heated, plain lid, twin fuel holders | https://www.ecatering.co.uk/products/stainless-steel-roll-top-chafing-dish-full-size-1-1-gn-9-litre-capacity | **Verified** — code + price ladder + sibling contrast all agree |
| IMG/BUF/00178 | Chafing Dish Roll Top 9 Litres Electric RA2301AE | `RA2301AE` | `RA2301` + `AE` electric water pan 220 V/800 W | grammar from §3.2 | **Derived (high)** — `AE` suffix + stored spec + price ladder |
| IMG/BUF/00179 | Chafing Dish Roll Top Electric ECD09C | `ECD09C` | Electric Chafing Dish, 9 L, **double pan** | https://sheffieldafrica.com/kitchen/product/429/chafing-dish-roll-top-double-pan-9-litres-electric-ecd09c | **Unverified externally** (own site only). ⚠ name missing "Double Pan" |
| IMG/BUF/00236 | Heating Lamp Infrared 900MM | `XD-HHB900` | — nothing found — | none | **Unverified.** Only `900` = 900 mm decodes. Needs supplier sheet |
| IMG/BUF/00090 | Induction Cooker Wanhui | `A6-650N-32` | — nothing found — | none | **Unverified.** ⚠ self-contradictory (warmer vs 3500 W); ⚠ wrong brand |
| IMG/TCW/00526 | GN Container 1/1 20 Non Stick | `NF811-20` | GN 1/1 530 × 325 mm, 20 mm deep, ≈2.5 L | https://www.gastronorm.it/en/The-Gastronorm-measures | **Derived** — EN 631 standard; `NF811` itself unverified. ⚠ material unstated |
| IMG/TCW/00527 | GN Container 1/1 40 Non Stick | `NF811-40` | GN 1/1 530 × 325 mm, 40 mm deep, ≈5.5 L | as above | **Derived** — as above. ⚠ same price as 00526 |
| IMG/TCW/00355 | Stock Pot 17 Litres EI2828 | `SDI2828` | Ø280 × 280 mm, 17.24 L brim-full | §2 geometry | **Derived (high)** — reconciles −1.4 % |
| IMG/TCW/00368 | Stock Pot 36 Litres EI3636 | `SDI3636` | Ø360 × 360 mm, 36.64 L | §2 | **Derived (high)** — −1.8 % |
| IMG/TCW/00386 | Stock Pot 12 Litres CSP 2525 | `CSP 2525` | Ø250 × 250 mm, 12.27 L | §2 | **Derived (high)** — −2.2 %. ⚠ duplicate of 00363 |
| IMG/TCW/00388 | Stock Pot 71 Litres CSP 4545 | `SDI4545` | Ø450 × 450 mm, 71.57 L | §2 | **Derived (high)** — −0.8 %. ⚠ name/model family clash |
| IMG/TCW/00389 | Stock Pot 50 Litres CSP 4040 | `SDI4040` | Ø400 × 400 mm, 50.27 L | §2 | **Derived (high)** — −0.5 %. ⚠ name/model family clash |
| IMG/TCW/00354 | High Sauce Pan 10 Litres E22816 | `SD22816` | Ø280 × 160 mm, 9.85 L brim-full | §2 | **Derived (high)** — ⚠ stated 10 L **exceeds** brim-full |
| IMG/TCW/00357 | High Sauce Pan 6.5 Litres E22414 | `SD22414` | Ø240 × 140 mm, 6.33 L brim-full | §2 | **Derived (high)** — ⚠ stated 6.5 L **exceeds** brim-full (+2.6 %, worst) |
| IMG/TCW/00382 | High Sauce Pan 4 Litres | `SD22013` | Ø200 × 130 mm, 4.08 L | §2 | **Derived (high)** — −2.1 % |
| IMG/TCW/00519 | High Sauce Pan 8.5 Litres SS 25X18 | `SDI2518` | Ø250 × 180 mm, 8.84 L | §2 | **Derived (high)** — −3.8 %, largest gap but safe direction |
| IMG/TCW/00520 | High Sauce Pan 18 Litres SS 32X22 | `SDI3222` | Ø320 × 220 mm, 17.69 L | §2 | **Derived (high)** — ⚠ stated 18 L **exceeds** brim-full |

**Could not verify at all (no external source exists):** `XD-HHB900` (00236), `A6-650N-32`
(00090), `ECD09C` (00179, own site only), `NF811-20`/`NF811-40` (00526/00527, standard
inferred but code unfound), and all 10 cookware codes — the cookware is *derived* rather
than *sourced*, which for this family is stronger evidence than a supplier listing would
be, but it is not third-party confirmation and should not be presented as such.

---

## 6. Image sourcing (July 2026) — downloaded to `Downloads/kitchenware-images/`

**3 files kept.** This is a deliberately small set. The catalogue is dominated by generic
stainless cookware where a photo of "a stock pot" is trivially easy to attach at the wrong
size, so images were only kept where the *exact* product could be identified. Every file
below was opened and visually inspected before being kept.

| File | Pixels | Size | Source | Verdict |
|---|---|---|---|---|
| `IMG-FPR-00239__QC205A-welldone-madeinchina.jpg` | **3000 × 3000** | 397 KB | https://image.made-in-china.com/2f0j00QPhUWlYBVGbk/Welldone-Wed-QC205A-Durable-and-Energy-Saving-Vegetable-Cutter.jpg | **Best file in the set.** Verified visually: stainless continuous-feed vegetable cutter, large hopper, hinged pusher arm, cutting disc, rubber feet. **Exact model** (`WED-QC205A`). Clean white background. Recommended. |
| `IMG-BUF-00177__RA2301-adexa-R23301-rolltop-plain.jpg` | **1200 × 1200** | 322 KB | https://adexa.co.uk/image/catalog/Adexa/R23301.jpg | Verified visually: 9 L GN1/1 roll-top chafer, mirror polish, full stand with legs, **two fuel holders visible, plain lid with no window** — exactly the `RA2301` profile (§3.2). Different vendor's part, so **representative of the type, not our exact unit**, but it is the correct *configuration*, which is the thing that distinguishes 00177 from its two siblings. |
| `IMG-BUF-00095__RA2302-rolltop-cutout-lid-rovsun-REPRESENTATIVE.jpg` | **1600 × 1600** | 122 KB | https://www.rovsun.com/cdn/shop/products/image_1_2cc19fb5-ca85-4e67-bb55-35dbef8ff37a.jpg | ⚠ **Not recommended for the storefront.** Verified visually: single roll-top chafer, food-styled. Two problems — it carries **visible "ROVSUN" competitor branding** on the frame, and the lid has an **open cut-out, not the glass window** that defines `RA2302`. Kept only as a shape reference. |

### Rejected during verification — worth recording so the mistakes aren't repeated

- **A "Signature 8 L juice dispenser" image (720 × 716) was downloaded and then deleted.**
  On inspection it turned out to be a **domestic glass mason-jar drinks dispenser on a wire
  stand** — not a commercial polycarbonate-bowl juice dispenser at all. The retailer's page
  is illustrated with the wrong product. This is exactly the failure mode to watch for:
  the filename and page title were both right, the image was not. **`IMG/BUF/00092` has no
  usable sourced image.**
- Two ROVSUN files (a lifestyle banner with text overlay and people, and a four-panel party
  collage) — marketing assets, not product photography.
- Two gastroland.fr GN-tray files — 431 B and 793 B placeholder/spacer images.
- An ecatering `ECS002` roll-top chafer photo — maxes out at **583 × 520**, below the
  usable bar, and redundant against the 1200 px Adexa file showing the same configuration.
- An Adexa `-1500x1500` cache variant — an upscale of the 1200 px original (189 KB vs
  322 KB, i.e. re-encoded), so the 1200 px original was kept instead.

### No image sourced for 17 of 20 SKUs

Nothing was found that could be trusted for the 10 cookware SKUs, the 2 GN containers, the
heat lamp, the induction cooker, `ECD09C`, `RA2301AE`, or the juice dispenser. For the
cookware this is a deliberate abstention rather than a failure: the pots are visually
near-identical across the whole size range, so any photo would be *representative* at best
and actively misleading at worst — a 71 L `SDI4545` and a 12 L `CSP 2525` look the same in
a studio shot. **If representative cookware photography is wanted, shoot the actual stock
rather than sourcing it.**

Nothing has been copied into `storage/app/public/products/` or referenced in
`products.json` — staged in Downloads for review, same as the Brema and Cambro sets. All 20
records already have a non-empty `image`, so none of this is urgent.

---

## 6A. Image sourcing re-run (July 2026) — `Desktop/ecommerce/products resource/kitchenware-images/`

All 20 SKUs re-examined, **including those with an existing catalogue image** — which is
where the useful results came from. **6 files now staged** (the 3 above, relocated out of
`Downloads`, plus 3 new). Every file was opened and visually inspected.

| File | Pixels | Size | Source | Verdict |
|---|---|---|---|---|
| `IMG-FPR-00239__QC205A-welldone-madeinchina.jpg` | **3000 × 3000** | 387 KB | https://image.made-in-china.com/2f0j00QPhUWlYBVGbk/Welldone-Wed-QC205A-Durable-and-Energy-Saving-Vegetable-Cutter.jpg | Unchanged from the first pass. Exact model `WED-QC205A`. Best file in the set. |
| `IMG-BUF-00177__RA2301-adexa-R23301-rolltop-plain.jpg` | **1200 × 1200** | 314 KB | https://adexa.co.uk/image/catalog/Adexa/R23301.jpg | Unchanged. Correct *configuration* (plain lid, twin fuel holders); different vendor's part. |
| `IMG-BUF-00095__RA2302-rolltop-cutout-lid-rovsun-REPRESENTATIVE.jpg` | **1600 × 1600** | 120 KB | https://www.rovsun.com/cdn/shop/products/image_1_2cc19fb5-ca85-4e67-bb55-35dbef8ff37a.jpg | Unchanged. ⚠ Still **not storefront-usable** — visible ROVSUN branding, and a cut-out lid rather than `RA2302`'s glass window. Shape reference only. |
| `IMG-BUF-00092__REF__signature-CS-SJD-08A-8L-single-bowl.jpg` | **1052 × 1280** | 86 KB | https://cdn.shopify.com/s/files/1/0026/1318/2510/files/photo_2024-05-13_10-08-43-I1.jpg | **NEW.** Official **Signature** marketing image — logo, "The Sign of Quality" strapline and the model number `CS-SJD-08A` printed on the artwork. Dome lid, polycarbonate bowl, central ice tube, tap, drip tray on a square base. **This is the image the first pass failed to find** (§6 rejected a domestic mason-jar photo). `REF__` because it is the **8 L** unit, not the 10 L our record claims — see §6A.2. |
| `IMG-TCW-00355__REPRESENTATIVE-stock-pot-shape-not-exact-size.jpg` | **800 × 800** | 106 KB | https://image.made-in-china.com/2f0j00njGlqRegHrfB/Daosheng-Durable-Commercial-New-Style-with-Double-Handle-Metal-Sunken-Lids-6L-213L-Stainless-Steel-Low-and-High-Body-Stock-Pots.jpg | **NEW.** Clean, unwatermarked, white background. Commercial all-stainless **tall "high-body" stock pots**, twin riveted tubular handles, sunken metal lids — matching the configuration in the stored catalogue photos. **REPRESENTATIVE OF THE STOCK-POT RANGE ONLY — this is not `SDI2828`, and it is not a 17 L pot.** Filed under 00355 purely because a file needs one SKU; it stands in equally for 00368 / 00386 / 00388 / 00389. |
| `IMG-TCW-00520__REPRESENTATIVE-high-sauce-pan-shape-not-exact-size.jpg` | **800 × 800** | 64 KB | https://image.made-in-china.com/2f0j00QaRBeTEKHAbd/Superior-Durability-Deep-Design-Double-Handles-Stainless-Steel-Sauce-Pot-with-Lid.jpg | **NEW.** Clean, unwatermarked. Two-handled all-stainless **low-body** pot with a stainless lid — the "high sauce pan" proportion (d > h), matching the stored photos. **REPRESENTATIVE OF THE SAUCE-PAN RANGE ONLY — not `SDI3222`, not an 18 L pan.** Stands in equally for 00354 / 00357 / 00382 / 00519. |

Only **two** cookware photos were taken for **ten** cookware SKUs, deliberately — the first
pass's reasoning (a 71 L and a 12 L pot are indistinguishable in a studio shot) is correct
and is now reinforced by §6A.3. Ten near-identical staged photos would imply a size
specificity that does not exist.

### 6A.0 Applied to the project — 29 July 2026

Two more §6A files went live the same day:

| SKU | Product | Was | Now |
|---|---|---|---|
| IMG/FPR/00239 | Vegetable Food Processor `QC205A` | 383×424 | Welldone render — exact model, the best file in the set |
| IMG/BUF/00177 | Chafing Dish Roll Top `RA2301` | 600 px | Adexa plain-lid shot |

00177 carries a caveat worth keeping in view: §6A calls it the correct *configuration* (plain
lid, twin fuel holders) but **a different vendor's part**. It is unflagged in the filename, so
it went live under the standing rule; if that rule ever tightens, this is the one to revisit.

Still staged, not published: `IMG/BUF/00092` (`REF__` — the Signature image is the **8 L**
unit against a record claiming 10 L, per §6A.2) and `IMG/BUF/00095` (`REPRESENTATIVE` — visible
ROVSUN branding and a cut-out lid rather than `RA2302`'s glass window; §6A already rules it
not storefront-usable).

---

The sauce-pan file above is now the cover for **both** SS sauce pans, on explicit instruction:

| SKU | Name | Was | Now |
|---|---|---|---|
| IMG/TCW/00519 | High Sauce Pan 8.5 Litres SS 25X18 (`SDI2518`) | 600 px generic pot | shared representative shot |
| IMG/TCW/00520 | High Sauce Pan 18 Litres SS 32X22 (`SDI3222`) | 600 px generic pot | shared representative shot |

Deliberately one photograph across two SKUs — the same reasoning as above, and no worse than
what it replaced: the two 600 px files it supersedes were themselves near-identical crops of
one generic pot, so the catalogue was already sharing an image here without saying so.

`products.json` needed no edit; both records already pointed at these filenames.

Two things left open:

- The file applied is the **1512 px** re-fetch, which is an upscale of the 800 px source in the
  table above. No added detail, but a large gain over the 600 px files it replaced.
- The same photograph stands in equally for **00354 / 00357 / 00382**, which still carry their
  own low-resolution stored shots. Not applied — only the two SS pans were asked for.

### 6A.1 ⚠ `RA2301AE` and `ECD09C` are the **same photograph** — and it shows a single pan

`chafing-dish-roll-top-9-litres-electric-ra2301ae-imgbuf00178.jpg` and
`chafing-dish-roll-top-electric-ecd09c-imgbuf00179.jpg` are **byte-identical** (both
800×800, both 123,553 bytes, identical MD5).

That matters because §3.4 established — from sheffieldafrica.com's own page title — that
`ECD09C` is the **"DOUBLE PAN"** model, and that "Double Pan" is precisely the feature
distinguishing it from `RA2301AE`. The shared photograph shows a roll-top electric chafer
with a **digital readout reading 85 °C and one single full-size GN pan**.

**So the photo can be correct for at most one of the two records, and it is the one that is
*not* double-pan.** Either `ECD09C` is mis-illustrated, or the "Double Pan" designation on
the live site is wrong. This is a genuine sourced-vs-stored contradiction and it bears
directly on Tier-1 recommendation 5.

### 6A.2 ⚠ There is no such product as `CS-SJD-10A`

§3.3 derived `SJD10A` → `CS-SJD-10A`, "Signature, 10 litres, single bowl", from the code
grammar. The grammar is sound but **the product does not exist.** Four independent Kenyan
retailers stock the Signature juice-dispenser range and all four list the same three
variants — **all of them 8 litres per bowl**:

| Code | Configuration | Retailers |
|---|---|---|
| `CS-SJD-08A` | 1 × 8 L single bowl | digitalstore.co.ke, patam.co.ke |
| `CS-SJD-08B` | 2 × 8 L double bowl (16 L) | Jumia, Kilimall, patam.co.ke, Jiji |
| `CS-SJD-08C` | 3 × 8 L triple bowl (24 L) | patam.co.ke, deluxehomehaven.co.ke |

**No `-10A`, and no 10 L tier anywhere in the range.** The `08A/08B/08C` ladder varies the
*bowl count*, not the litreage — which is the opposite of what §3.3 inferred from the `08B
= 16 L` data point (right conclusion, "litres per bowl", but it also means the leading
number is fixed at 08 across the whole family).

So either our record's **"10 Litres" is wrong** and this is a `CS-SJD-08A`, or `SJD10A`
is not a Signature code at all. **The stored photograph does not settle it** — it shows a
correct commercial single-bowl dispenser of exactly the `CS-SJD-08A` type, with no capacity
marking visible. Note this compounds the §3.3 price flag: KSh 22,500 against a KSh 6,500
market price looks worse if the unit is in fact the 8 L.

https://www.digitalstore.co.ke/products/signature-cs-sjd-08a-8l-juice-dispenser
https://patam.co.ke/shop/kitchen-commercial-equipment/juice-dispensers/signature-juice-dispenser-8l-cs-sjd-08a/
https://www.jumia.co.ke/signature-82-ltr-stainless-steel-double-bowls-juice-dispenser-cs-sjd-08b-328598468.html
https://deluxehomehaven.co.ke/collections/kitchen/juicers-in-kenya

### 6A.3 ⚠ Four stock-pot SKUs share one photograph

| SKU | Name | Stated capacity | Stored file | Bytes |
|---|---|---|---|---|
| IMG/TCW/00386 | Stock Pot 12 Litres `CSP 2525` | 12 L | `stock-pot-12-litres-csp-2525-imgtcw00386.jpg` | **7,725** |
| IMG/TCW/00355 | Stock Pot 17 Litres `EI2828` | 17 L | `stock-pot-17-litres-ei2828-imgtcw00355.jpg` | **7,725** |
| IMG/TCW/00368 | Stock Pot 36 Litres `EI3636` | 36 L | `stock-pot-36-litres-ei3636-imgtcw00368.jpg` | **7,725** |
| IMG/TCW/00388 | Stock Pot 71 Litres `CSP 4545` | 71 L | `stock-pot-71-litres-csp-4545-imgtcw00388.jpg` | **7,725** |

All four are **byte-identical, identical MD5, 341 × 341 px**. A 12 L and a 71 L pot are
illustrated with the same picture. (Only `SDI4040` / 00389 differs — a separate 600×600
file.) This is exactly the failure mode the first pass predicted, already present in the
live catalogue. It also means **§6A's two representative files are no worse than what is
published today, and are 2.3× the resolution.**

### 6A.4 `XD-HHB900` — the stored photo answers the mounting question §3.6 could not

§3.6 listed **mounting method** as one of three unknowns blocking a write-up, with three
incompatible options. The stored image (`heating-lamp-infrared-900mm-imgbuf00236.jpg`,
600×600) settles it: a stainless strip warmer **suspended on four chains** from above, with
a vented top panel and **two rocker switches** on the front fascia.

So: **ceiling/chain suspended, two-zone switching.** Power rating and element type remain
unknown, and no external source for `XD-HHB900` was found (re-probed; still nothing). But
one of the three blocking unknowns is now answered from an asset already in hand.

### 6A.5 `NF811-20` / `NF811-40` — stored photos support the coated-aluminium reading

§3.5 flagged that the material is unstated and that coated aluminium vs coated stainless
changes the permitted-use copy. Both stored images (600×600) show a **matte black
non-stick-coated GN 1/1 tray** with the standard EN 631 rolled rim and corner handles —
visually a bakery/roasting tray, consistent with the PTFE-coated aluminium reading and
**not** with a stainless bain-marie pan. Not proof of substrate, but it points the same way
as §3.5's comparables. The material question still needs the supplier.

### 6A.6 External corroboration for the over-brim sauce-pan capacities (§2.1)

Adexa's `JJD63xx` range is dimension-coded in the same mm grammar as ours, which makes it a
direct check on §2.1's finding that three sauce-pan capacities exceed brim-full volume:

| Adexa part | Dimensions | Adexa's stated capacity | Our equivalent | Our stated capacity |
|---|---|---|---|---|
| `JJD6322` | **320 × 220 mm** | **17 L** | `SDI3222` (00520) | **18 L** |
| `JJD6314` | 240 × 135 mm | 6 L | `SD22414` (00357) — 240 × 140 mm | 6.5 L |
| `JJD6312` | 220 × 130 mm | 4.9 L | `SD22013` (00382) — 200 × 130 mm | 4 L |

**A vendor selling the identical 320 × 220 mm vessel rates it 17 L where we claim 18 L** —
brim-full geometry is 17.69 L, so Adexa's figure is the honest usable one and ours is a
round-up past the physical maximum. This is independent third-party support for
recommendation 18 (describe these as nominal).
https://adexa.co.uk/professional-stainless-steel-17l-saucepan-320-x-220mm-adexa-jjd6322
https://adexa.co.uk/professional-stainless-steel-6l-saucepan-240-x-135mm-adexa-jjd6314

⚠ Adexa's `JJD6322` photo was downloaded (930 × 930 original) and then **discarded**: it is a
**long-handled** saucepan, whereas our "high sauce pan" is a two-handled casserole. Correct
dimensions, wrong configuration — a good illustration of why dimension agreement alone does
not make a photo safe to attach.

### 6A.7 `CS-RA2102` independently re-confirms the `-02` = window grammar

A second, separate Signature part surfaced on a Kenyan retailer:
**"Signature Chaffing Dish 6L Round Rolltop with Glass Window `CS-RA2102`"**.
Same `CS-RA2x02` shape, same window meaning — §3.2's decoding of `RA2302` now rests on two
independent listings rather than one.
https://patam.co.ke/shop/kitchen-commercial-equipment/chafing-dishes/signature-chaffing-dish-6l/

### 6A.8 Rejected during this re-run

- **A Made-in-China "stock pot" photo (800 × 800)** — a *domestic* cookware set with glass
  lids and black plastic handles, shot in a styled kitchen. Wrong market segment entirely.
  Deleted.
- **Two watermarked commercial stock-pot photos** (Xinxin Houseware 999 × 999; Eagle
  Catering 800 × 800) — correct product type, but both carry large supplier watermarks and
  in one case a competitor's URL. Rejected in favour of the clean Daosheng file.
- **Adexa `JJD6322_1-1500x1500.jpg`** — a **synthetic upscale**: 1500 × 1500 at 106 KB
  against the 930 × 930 original at 157 KB. Larger dimensions, smaller file. The same
  upscale trap the first pass caught on `R23301`; Adexa's cache does this systematically.
- **`almardesigns.com`** (§3.2's source for `CS-RA2302`) — **the page is dead**, returning a
  2-byte body. The `CS-RA2302` citation in §3.2 no longer resolves; §6A.7 is now the live
  corroboration for that decoding.

### 6A.9 Scoreboard

| Outcome | SKUs |
|---|---|
| Exact-model image | **1** (00239, `WED-QC205A`, 3000 × 3000) |
| Correct-configuration image, different vendor | **1** (00177) |
| `REF__` / representative only | **4** (00092, 00095, 00355, 00520) |
| Covered by a representative-of-range file | **10 cookware** (2 files, explicitly not size-specific) |
| Proven unsourceable | **6** (00178, 00179, 00236, 00090, 00526, 00527) |
| Contradictions found | **3** (§6A.1 shared chafer photo, §6A.2 no `CS-SJD-10A`, §6A.3 four stock pots one photo) |

Nothing has been copied into `storage/app/public/products/` and neither `products.json` nor
`brands.json` was touched. sheffieldafrica.com was **not** used as an image source.

---

## 7. Recommended changes (none applied)

Ordered by value. Everything here needs approval; per [[feedback_model_number_unique_id]]
**no `model_number` is proposed for change anywhere in this file.**

**Tier 1 — free wins, no supplier input needed**

1. **Populate dimensions on all 10 cookware SKUs from their model numbers** (§2, §4.3).
   Diameter and height are fully determined by the code, in mm, and currently 6 of 10 have
   no dimensions at all. This is the single highest-value change available and carries zero
   research risk.
2. **Complete `IMG/TCW/00389` (`SDI4040`) from its four identical siblings** (§4.4). It is
   the same pot at a different size and the boilerplate is verbatim across the family — a
   no-risk fill for one of the 10 empty records.
3. **Write `IMG/BUF/00177` (`RA2301`) as the entry-level member of a confirmed three-model
   ladder** (§3.2) — plain fuel-heated lid, versus `RA2302`'s window and `RA2301AE`'s
   electric pan. This is the best-evidenced of the 10 empty records.
4. **Fix the numeric width/height transposition on the 4 dimensioned non-cookware SKUs**
   (§4.2) — 00095, 00178, 00179, 00090. Swap the two numeric fields to match the prose.
   Independently confirmed for `ECD09C` by our own live site and forced by physics for the
   induction cooker.
5. **Add "Double Pan" to `IMG/BUF/00179`'s name** (§3.4) to match sheffieldafrica.com and to
   distinguish it from `RA2301AE`.
6. **Build out `IMG/TCW/00526`/`00527` on the existing 25-record GN house pattern** (§3.5)
   — *after* the material question is answered (see Tier 2).
7. **Apply the `short_description` / `meta_description` split** to all 20 (§4.4); none of
   them has a `meta_description` and the "in Kenya" SEO copy is in the wrong field.

**Tier 2 — needs a supplier answer first**

8. **Resolve the `QC205A` power rating** (§3.1). The stored 350 W is contradicted by every
   source (750 / 1000 / 1100 W). Correct it — but ask which motor ships rather than picking
   one. **Do not publish 350 W.**
9. **Resolve the `A6-650N-32` contradiction** (§3.7): "chafing induction warmer" vs 3500 W.
   The dimensions favour a cooking hob. Delete the losing line once confirmed.
10. **Confirm whether `NF811-20`/`-40` are coated aluminium or coated stainless** (§3.5).
    This changes the permitted-use copy, not just a spec line, so it must precede the
    write-up. Also check why both are priced identically at KSh 8,280.
11. **Obtain a spec sheet for `XD-HHB900`** (§3.6). Power, mounting method and element type
    are all unknown and it cannot be described without them. **Do not template it off the
    bulb/dome heat lamps already in the catalogue** — different product category.
12. **Sanity-check the `SJD10A` price** (§3.3) — KSh 22,500 against a KSh 6,500 Kenyan
    market price for the 8 L sibling.

**Tier 3 — data-model decisions**

13. **Resolve the `IMG/TCW/00386` ↔ `IMG/TCW/00363` duplicate** (§4.1). Same 25 × 25 cm
    12 L pot listed twice, under two brands, two model numbers, 15 % apart in price. Either
    retire one and merge the stock, or establish what actually differs.
14. **Reassign `IMG/BUF/00090` to `WANHUI`** — its own name says Wanhui and the brand
    exists. Flagged only; **not changed**, per the brief.
15. **Add the missing `WANHUI` row to `brands.json`** (§4.1) — it is referenced by 2
    products but absent from the brands file.
16. **Decide what `KITCHENWARE` means going forward** (§1). Options: keep it as an explicit
    house label (and rewrite the `brands.json` description, which currently describes
    Wanhui), or split the 20 SKUs by real source — Signature for the buffet items, Wanhui
    for the cookware and induction, generic-OEM for `QC205A`. Until then, leave
    `website_url` null rather than inventing one.
17. **Reconcile the name-embedded codes with `model_number`** (§2.3), especially 00388 and
    00389 where the name says `CSP 4545`/`CSP 4040` and the model says `SDI4545`/`SDI4040`.
    The numbers always agree; only the prefix drifts.
18. **Describe the three over-brim sauce-pan capacities as nominal** (§2.1) — "Ø280 × 160 mm,
    approx. 10 L" rather than asserting an exact litreage a cylinder that size cannot hold.

---

## APPLIED 2026-07-30 — 20/20 house-format complete

Copy generated from SAP `Item Remarks` plus a derivation the codes made available.

### ⭐ The cookware codes encode diameter x height in cm — verified by volume

Every stock pot and sauce pan code carries its own geometry, and the arithmetic confirms the
stated capacity. **10 of 10 testable codes matched within a few percent**, so this is a
derivation rather than a guess:

| Code | Decode | Calculated | Stated on the product |
|---|---|---|---|
| `SD22013` | 20 cm dia x 13 cm | 4.1 L | 4 L |
| `SD22414` | 24 x 14 | 6.3 L | 6.5 L |
| `SD22816` | 28 x 16 | 9.9 L | 10 L |
| `SDI2518` | 25 x 18 | 8.8 L | 8.5 L |
| `CSP 2525` | 25 x 25 | 12.3 L | 12 L |
| `SDI2828` | 28 x 28 | 17.2 L | 17 L |
| `SDI3222` | 32 x 22 | 17.7 L | 18 L |
| `SDI3636` | 36 x 36 | 36.6 L | 36 L |
| `SDI4040` | 40 x 40 | 50.3 L | 50 L |
| `SDI4545` | 45 x 45 | 71.6 L | 71 L |

**10 dimension fills applied** on that basis (cylindrical: diameter x diameter x height in mm).
Before this, five stored a bare `25/25/None`-style fragment and five were entirely blank.

The two GN containers already held the correct **EN 631** figures — GN 1/1 is 530 x 325 mm with
the code tail giving the depth (`NF811-20` = 20 mm, `NF811-40` = 40 mm) — so they needed nothing.

### ⚠ Supplier: the Wanhui evidence strengthens again

`IMG/BUF/00090` is named **"Induction Cooker Wanhui"** and its SAP remark reads *"Induction hob
for chafing dishes"*. Combined with `whkitchenware.com` (WH = Wanhui) and the range matching
item-for-item, the attribution to **Wanhui** rather than the map's "Osion" stands — see
`house-brand-suppliers-research.md` §7.1.

⚠ Eight of the 20 SAP remarks are **just the product name lowercased** (*"stock pot 12 litres csp
2525"*), so they carry no specification at all. Those SKUs rely on the code decode above plus the
capacity in the product name.
