# KITCHENWARE Research

**This file supersedes `old/kitchenware-research.md`.** That file predates the SAP export and
was written before Wanhui's own published specification tables were recovered. Its geometric
derivation of the cookware codes was sound and is confirmed here by the manufacturer; several
of its other conclusions - the Signature attribution, the `CS-SJD-10A` non-existence finding,
the sauce-pan handle configuration, and the reading of the stored chafer heights - are
corrected below. Read this file; keep the old one only for the rejection log in its §6/§6A.

Covers all **20 KITCHENWARE SKUs**: 5 stock pots, 5 "high sauce pans", 2 non-stick GN
containers, 4 roll-top chafing dishes, 1 juice dispenser, 1 infrared heat lamp, 1 induction
cooker, 1 vegetable food processor.

Companion: `house-brand-suppliers-research.md` (supplier map),
`oem-sheffield-research` findings in `products resorce final\oem-sheffield\_FINDINGS-buffet-ice.md`
(Heavybao, and the sibling `431001`/`432102` chafers).
Image ledger and staged files: `Desktop\ecommerce\products resorce final\kitchenware\`
(`_sourced.json`, `_FINDINGS.md`).

**No `products.json` or `brands.json` change has been applied, and no `model_number` is
proposed for change anywhere in this file.**

---

## 1. Supplier: KITCHENWARE is Wanhui - now proved, not inferred

**Wanhui Industrial (China) Limited / Jiangmen Wanhui Manufacturing Company Limited**,
Fenghua Industrial Park, Pengjiang District, Jiangmen, Guangdong. Chinese name 万晖实业.

http://www.whkitchenware.com/
https://www.tradewheel.com/co/jiangmen-wanhui-manufacturing-company-li-1051002/
https://ownfit.en.alibaba.com/
https://www.facebook.com/wanhuicatering

`house-brand-suppliers-research.md` §7.1 already argued Wanhui over the business's stated
"Osion", on three grounds: the product name "Induction Cooker Wanhui", the `brands.json`
description, and the domain `whkitchenware.com`. All circumstantial.

**Five of our code families now map onto codes Wanhui publishes, and one matches exactly:**

| Our model | Wanhui's own code | Wanhui page |
|---|---|---|
| `RA2301` | **`RA2301`** - identical, with dimensions and capacity | 9L Full Size Roll Top Chafer |
| `SDI2828` `SDI3636` `SDI4040` `SDI4545` `SDI2518` `SDI3222` `CSP 2525` | `12828` `13636` `14040` `14545` `12518` `13222` `12525` | Stock pot range table |
| `SD22816` `SD22414` `SD22013` | `22816` `22414` `22013` | Sauce pan range table |
| `NF811-20` `NF811-40` | `811-20` `811-40` | Gastronorm pan range table |
| `SJD10A` | `SJD08A` / `SJD08B` / `SJD08C` | Juice dispenser |

14 of 20 SKUs. The house label either bolts a prefix on the front (`SD`, `NF`) or transcribes
Wanhui's leading `1` as a capital `I` (§3.1). **The attribution is closed.**

Wanhui's live catalogue (16 items, categories: Chafing Dish · Gastronorm Pan · NSF Commercial
Cookware · Drinks Dispenser · Electrical Equipment · Coffee Urn · Service Trolley and Cart ·
Wall Shelf · Work Table and Sink Bench):

http://www.whkitchenware.com/col.jsp?id=104
http://www.whkitchenware.com/pd.jsp?id=280
http://www.whkitchenware.com/pd.jsp?id=401
http://www.whkitchenware.com/pd.jsp?id=405
http://www.whkitchenware.com/pd.jsp?id=406
http://www.whkitchenware.com/pd.jsp?id=408

⚠ **The site was unreachable for the whole of this pass** (port 80 times out, port 443 refuses
connection). Everything cited above was read from the Internet Archive's 2026-05-14 capture:
https://web.archive.org/web/20260514095121/https://www.whkitchenware.com/col.jsp?id=104
https://web.archive.org/web/20260514100238/https://www.whkitchenware.com/pd.jsp?id=408

⚠ **Consequence: the "Electrical Equipment" category was never read.** That is the one place a
Wanhui part number for `XD-HHB900` or `A6-650N-32` would live (§6).

---

## 2. SAP dimension order on this brand

Established from SAP against itself, before any fetching. The order is
**[short horizontal, long horizontal, height]**, consistent on every testable row:

| SKU | SAP fields | SAP's own text | Forces |
|---|---|---|---|
| `IMG/TCW/00519` | – / 25 / 18 | "SS **25X18**" | field 2 = diameter, field 3 = height |
| `IMG/TCW/00520` | – / 32 / – | "SS **32X22**" | field 2 = diameter |
| `IMG/TCW/00526` | 325 / 530 / 20 | "GN CONTAINER **1/1**" (EN 631 = 530 x 325) | field 1 = short side, field 2 = long side |
| `IMG/BUF/00236` | – / 900 / – | "INFRARED **900MM**" | field 2 = largest dimension |

No SAP row contradicts another on order. `products.json` stores the same numbers with fields 1
and 2 swapped, which is a convention difference rather than an error.

Two things SAP *does* get wrong here:

- **⚠ Mixed units.** `SDI2518` (25/18) and `SDI3222` (32) are in **centimetres**; every other
  row is millimetres.
- **⚠⚠ Carton values recorded as product values** on the chafers - §4.

---

## 3. The cookware codes, from the manufacturer's own tables

The old research derived "diameter x height in cm" from cylinder volume and reconciled all 12
capacities within ±4 %. **That derivation was right about the grammar.** Wanhui publishes the
tables, so it can now be cited rather than derived - and the tables correct three heights and
five capacities.

### 3.1 Stock pots - Wanhui's `1DDHH` series

http://www.whkitchenware.com/pd.jsp?id=405

| SKU | Our model | Wanhui | d x h (cm) | Wanhui L | Our stated L |
|---|---|---|---|---|---|
| IMG/TCW/00386 | `CSP 2525` | `12525` | 25 x 25 | 12.0 | 12 ✔ |
| IMG/TCW/00355 | `SDI2828` | `12828` | 28 x 28 | 17.2 | 17 ✔ |
| IMG/TCW/00368 | `SDI3636` | `13636` | 36 x 36 | 36.6 | 36 ✔ |
| IMG/TCW/00389 | `SDI4040` | `14040` | 40 x 40 | 50.2 | 50 ✔ |
| IMG/TCW/00388 | `SDI4545` | `14545` | 45 x 45 | 71.5 | 71 ✔ |
| IMG/TCW/00519 | `SDI2518` | `12518` | 25 x 18 | **8.8** | 8.5 ⚠ |
| IMG/TCW/00520 | `SDI3222` | `13222` | 32 x 22 | **17.7** | 18 ⚠ |

**⭐ The `SDI` prefix is decoded.** Wanhui writes `12828`; we write `SDI2828`. Strip `SD` and
`I2828` remains - **a leading `1` transcribed as `I`.** The old research called this "very
likely an I/1 transcription artefact"; it is now certain, and it explains why our stock pots
carry `SDI` while our sauce pans carry a bare `SD` (§3.2): there is no `SD`/`SDI` distinction
at all, only Wanhui's series digit `1` versus `2`.

⚠ **`SDI2518` and `SDI3222` sit in the stock-pot table's low-body block**, not on the sauce-pan
table. We call both "High Sauce Pan". By the maker's classification they are low-bodied
two-handled stock pots.

Wanhui's full stock-pot range, for context: tall bodies 12525, 12828, 13030, 13232, 13636,
14040, 14545, 15050, 15060, 15555, 16060, 16070, 16080; low bodies 12518, 13020, 13222, 13524,
14026, 14528, 15030, 15535, 16040.

### 3.2 Sauce pans - Wanhui's `2DDHH` series

http://www.whkitchenware.com/pd.jsp?id=406

| SKU | Our model | Wanhui | d x h (cm) | Wanhui L | Our stated L | Wanhui remark |
|---|---|---|---|---|---|---|
| IMG/TCW/00382 | `SD22013` | `22013` | 20 x **12.0** | **3.8** | 4 | SAUCEPAN HIGHT (w/lid) |
| IMG/TCW/00357 | `SD22414` | `22414` | 24 x 14.0 | **6.3** | 6.5 | SAUCEPAN HIGHT (w/lid) |
| IMG/TCW/00354 | `SD22816` | `22816` | 28 x 16.0 | **9.8** | 10 | SAUCEPAN HIGHT (w/lid & helper) |

Our codes are Wanhui's five-digit codes with `SD` prefixed - the numerals are identical.

**⚠ On this series the last two digits are NOT the height.** `22013` measures 12.0 cm, not 13.
`21208` is 7.5 cm and `21408` is 8.5 cm - both suffixed `08`. `22214` is 13.0 and `22414` is
14.0 - both suffixed `14`. The suffix is a size index that approximates the height. On the
stock-pot series it *is* the exact height. **The rule differs between the two series and must
not be generalised.** The 2026-07-30 dimension fill used the suffix as the height throughout;
`SD22013` is the row that is wrong as a result.

This also closes the old research's "three sauce pans claim more than brim-full volume" flag.
Wanhui publishes 3.8 / 6.3 / 9.8 L against our 4 / 6.5 / 10 L. Ours are marketing round-ups,
confirmed by the maker rather than only by arithmetic. External corroboration from Adexa's
identically-dimensioned `JJD6322` (320 x 220 mm rated **17 L** against our 18 L) still stands:
https://adexa.co.uk/professional-stainless-steel-17l-saucepan-320-x-220mm-adexa-jjd6322

**⚠ 3.3 The sauce pans are long-handled.** Wanhui's Sauce Pan page photograph shows a
long-handled saucepan with a helper handle, and its own remark column reads "w/lid" for the
small sizes and "w/lid & helper" for 26/28/30 cm. Our stored catalogue photographs show
two-handled casseroles.

The old research **rejected an Adexa `JJD6322` photograph specifically for being long-handled**
("correct dimensions, wrong configuration - a good illustration of why dimension agreement
alone does not make a photo safe"). On this evidence that rejection looks like the error.
**Check the actual stock before any description asserts a handle configuration.**

### 3.4 GN containers - Wanhui's `8xx-NN` series

http://www.whkitchenware.com/pd.jsp?id=401

`NF811-20` and `NF811-40` are Wanhui **`811-20`** and **`811-40`**, published at
**530 x 325 x 20 mm** and **530 x 325 x 40 mm** - matching SAP exactly, and matching EN 631.

Family: `821` = GN 2/1 (650x530) · **`811` = GN 1/1 (530x325)** · `812` = 1/2 (325x265) ·
`813` = 1/3 (325x176) · `814` = 1/4 (265x162) · `816` = 1/6 (176x162) · `819` = 1/9 (176x108) ·
`823` (355x325) · `824` (530x162). Depths: 20, 40, 65, 100, 150, 200 mm.

**⚠ Wanhui lists the `811` range as STAINLESS STEEL.** Ours are the non-stick variant - `NF` =
non-stick + `811`. That weighs *against* the old research's coated-aluminium reading (§3.5
there), which rested on third-party comparables rather than on our own supplier. It is not
decisive, because Wanhui may coat a different substrate for the non-stick line, but the
substrate question should now go to Wanhui rather than to the web. It matters: coated aluminium
is unsuitable for prolonged acidic contact and often not dishwasher-rated, and that is a
permitted-use claim, not a spec line.

---

## 4. ⚠⚠ The chafer dimensions in our records are the SHIPPING CARTON

Wanhui's spec strip for the 9 L full-size roll top, read verbatim:

> **`RA2301` · Stainless Steel · 635 x 455 x 440 mm · 9 L · Box Size 645 x 455 x 290 mm**

http://www.whkitchenware.com/pd.jsp?id=280

| SKU | Model | SAP W/D/H | What it is |
|---|---|---|---|
| IMG/BUF/00178 | `RA2301AE` | **455 / 645 / 290** | Wanhui's box size, exactly |
| IMG/BUF/00177 | `RA2301` | 460 / 650 / 290 | the same carton, rounded up 5 mm on two axes |

The product is **635 x 455 x 440 mm**. The old research flagged 290 mm as impossible for a
roll-top lid to clear a GN 1/1 pan but could not say what it was. It is the flat-packed carton.

**The error is not ours alone.** Empire Supplies (UK) publishes `EMP-RA2301B` as
*"Width 645mm, Depth 455mm, Height 290mm"* - the same carton triple, presented as the product:
https://www.empiresuppliesonline.co.uk/products/empire-9ltr-full-size-roll-top-chaffing-dish-emp-ra2301b

So anyone checking our figure against a reseller will find agreement and conclude it is right.

Wanhui's other chafer strips, all with the same product/box split:

| Wanhui | Product (mm) | Cap | Box (mm) | Notes |
|---|---|---|---|---|
| `RA2301` | 635 x 455 x 440 | 9 L | 645 x 455 x 290 | ours |
| `RA2101` | 470 x 470 x 450 | 6 L | 480 x 480 x 290 | 6 L round; `CS-RA2102` is its window twin |
| `WH823C` | 610 x 350 x 430 | 9 L | 625 x 360 x 445 | 9 L half roll top |
| `WH533B` | 610 x 360 x 450 | 9 L | 625 x 370 x 460 | 9 L half roll top, PC cover |
| `F433P` | 600 x 370 x 290 | 9 L | 605 x 360 x 155 | full-size folding frame |

### 4.1 The `RA` grammar, confirmed on Wanhui's own numbering

`RA21xx` = 6 L round · `RA23xx` = 9 L full size · `-01` = plain lid · `-02` = viewing window.
The window reading now rests on Wanhui's own `RA2101`/`RA2301` pair plus two live listings:

https://patam.co.ke/shop/kitchen-commercial-equipment/chafing-dishes/signature-chaffing-dish-6l/ (`CS-RA2102`, 6 L round rolltop with glass window)
https://idecoratorkenya.com/products/chaffing-dish-stainless-steel-roll-top-with-glass-window-signature-9-ltr-electric-roll-top-chaffing-dish-cs-ra-2302e (`CS-RA-2302E`, 9 L rolltop with window, electric)

⚠ Note the trailing `E` on `CS-RA-2302E`. Signature distinguishes electric with `E`; we
distinguish it with `AE` on `RA2301AE`. The suffix conventions are per-reseller and should not
be treated as a manufacturer standard.

`almardesigns.com`, the old research's §3.2 source for `CS-RA2302`, remains dead.

---

## 5. The juice dispenser - `SJD` is Wanhui's prefix, `CS-` is Signature's

Wanhui's own table (http://www.whkitchenware.com/pd.jsp?id=408):

| Model | Product | Material | Size (cm) | Capacity |
|---|---|---|---|---|
| `SJD08A` | single head juice dispenser | stainless steel + PC | 26.5 x 35 x 58 | 8 L |
| `SJD08B` | double head | stainless + PC | 56 x 35 x 58 | 8 L x 2 |
| `SJD08C` | triple head | stainless + PC | 86 x 35 x 58 | 8 L x 3 |

Grammar: **`SJD` + litres-per-bowl + head-count letter.** `A` = single head. Our `SJD10A` reads
as a single-head 10 L unit, agreeing with our record's name on both halves.

**Two corrections to the old research:**

1. §3.3 there derived `SJD10A` -> Signature `CS-SJD-10A`. The direction is backwards. `SJD` is
   **Wanhui's** code; `CS-` is a **Signature retail prefix bolted on**, exactly as our `SD`/`NF`
   prefixes are. Signature resells Wanhui goods in the Kenyan market; it does not originate the
   numbering.
2. §6A.2 concluded "there is no such product as `CS-SJD-10A`... the leading number is fixed at
   08 across the whole family". The letter is the **head count**, so the number is free to vary
   and the four Kenyan retailers simply all stock the 8 L tier. A 10 L tier is not disproved.
   It is also not evidenced - Wanhui publishes only 08. **Open, not closed.**

Also settled: the old research's price flag (KSh 22,500 for ours against KSh 6,500 for the 8 L
sibling). Wanhui's own table shows `SJD08B` is **16 L in two bowls**, not a 16 L bowl, so the
Kenyan ladder is 8 / 16 / 24 L by bowl count. That does not explain a 3.5x price gap, and the
gap is still worth a deliberate look.

https://smartenterprise.co.ke/product/8l-signature-single-bowl-juice-dispenser-cs-sjd-08a/
https://patam.co.ke/shop/kitchen-commercial-equipment/juice-dispensers/signature-juice-dispenser-8l-cs-sjd-08a/
https://patam.co.ke/shop/kitchen-commercial-equipment/juice-dispensers/signature-juice-dispenser-24l-cs-sjd-08c/
https://citystore.co.ke/products/juice-dispenser-triple-24l8ltrs-cs-sjd-08c

---

## 6. The three unfindable codes

| SKU | Model | Status |
|---|---|---|
| IMG/BUF/00179 | `ECD09C` | Nothing outside `sheffieldafrica.com` - circular, excluded. **The nearest real code is Signature `CS-ECD-09A`, a 9 L electric DOUBLE-COMPARTMENT chafer**, which independently corroborates the "Double Pan" designation the old research took from our own site. https://citystore.co.ke/products/signature-9l-electric-chafing-dish-double-compartment-cs-ecd-09a — its listing photograph is a flat-lid chafer, not a roll top, so it is not usable for this SKU. |
| IMG/BUF/00236 | `XD-HHB900` | `XD-HHB900`, `HHB900`, `HHB-900` return zero across web search, Made-in-China product search and Wanhui's catalogue. **Second independent negative.** |
| IMG/BUF/00090 | `A6-650N-32` | `A6-650N-32`, `A6-650N`, `650N` return zero. Wanhui's archived induction pages use `AC6002G1`, `AD1102G2`, `WD060L`, `A011`, `A032`, `A060`, `W011`, `W032` - a different family. SAP's description names WANHUI outright, so the supplier is known and the code is not. |

**This is not a search outage.** The same session returned live results for `RA2301`,
`CS-RA-2302E`, `CS-ECD-09A`, `CS-SJD-08A`, `EMP-RA2301B`, `QC205A` and `WED-QC205A`. These three
codes need a supplier document, not more searching - with the single exception noted in §1: the
Wanhui "Electrical Equipment" category has never been read, and is the one place left to look.

---

## 7. `QC205A` - the same machine filed under two brands, made by neither

`IMG/FPR/00239` (KITCHENWARE, `QC205A`) and `IMG/FPR/00177` (ASTAR, `S-QC205`) are one machine.

1. **Guangzhou Astar hosts its own product image as `WED-QC205A.png`.** `WED-` is **Welldone**'s
   prefix (Welldone Machine Equipment, Shunde, Foshan). Astar is a rebadger.
   https://www.astarkitchen.com/Astar-Vegetable-Preparation-Machines-QC205A-pd547958638.html
2. **Both our records store 590 / 265 / 540** - exactly Astar's published *machine size*.
3. **`QC205A` is a generic Chinese industry designation**, sold as `WED-QC205A` (Welldone),
   `GD-QC205A` (Guangzhou R&M), `YSN-QC205A` (Yoslun), `QC-205A` (Zhejiang Horus), `YFC205`
   (Adexa, Canmac), `VGC-QC205A` (Fomac). `QC` = *qie cai*; `205` = knife-disc diameter in mm.

**No brand change is proposed.** What the business should check is whether these are two stock
lines for one machine.

### 7.1 ⚠ The 350 W mystery is solved - it belongs to a different variant

Welldone's own comparison table:

| Welldone model | Power | N.W. | Product size | Knife set |
|---|---|---|---|---|
| `WED-QC205` | **350 W** | 23 kg | 535 x 270 x 525 | slices 4.5/2 mm, **shreds 3/4/7 mm** |
| `WED-QC205A` | **1000 W** | 28 kg | 675 x 345 x 540 | slices 4.5/2, shreds 3, **dice 8x8** |
| `WED-QC205B` | 1000 W | 27 kg | 675 x 345 x 540 | as A |

https://foodmachineryunion.en.made-in-china.com/product/mCXnsVRzCvkL/China-Welldone-Wed-QC205A-Durable-and-Energy-Saving-Vegetable-Cutter.html

**350 W is the base `QC205`.** And our own SAP remark for `IMG/FPR/00239` lists the disc set as
*"4.5mm & 2mm plastic slicers ... + 3mm & 4mm & 7mm plastic shreders"* - that is the **base
`QC205` knife set**, not the `A`'s, which swaps the 4/7 mm shredders for a dicing disc. So our
SAP remark describes `QC205` while our `model_number` says `QC205A`. The remark's 750 W matches
neither Welldone figure and is the Adexa/Canmac `YFC205` badge rating.
https://adexa.co.uk/Food-Prep-Machines-29/Vegetable-Prep-Machines-224/Commercial-Fruit-and-Vegetable-Cutter-750W-Adexa-YFC205

**Ask the supplier which variant ships. Do not publish 350 W or 750 W.**

Astar publishes for `QC205A`: 329 r/min, >180 kg/h, 5 knives, 220 V, **1.0 kW**, 28 kg,
machine 590 x 265 x 540, package 580 x 385 x 550, blade 205 mm.

⚠ Welldone and Astar disagree on the `A`'s machine size (675 x 345 x 540 vs 590 x 265 x 540),
and their product photographs show **two visibly different machines**. Both are staged so the
ambiguity stays visible.

---

## 8. Heavybao - our chafers are not theirs

The lead into this pass was that Guangdong Shunde Heavybao makes `431001`/`432102`, two roll-top
chafers stored at 645 x 455 x 290, and our `RA2301AE` is stored at exactly 645 x 455 x 290.

**That triple is Wanhui's carton size (§4), not a Heavybao dimension.** Heavybao's own published
figure for `431001` is **635 x 425 x 440**:

| | Wanhui `RA2301` | Heavybao `431001` |
|---|---|---|
| Product | 635 x **455** x 440 | 635 x **425** x 440 |
| Carton | **645 x 455 x 290** | not published |

Same class of goods, 30 mm apart in depth - two factories building the industry-standard 9 L
GN 1/1 roll-top chafer. **Our `RA23xx` chafers are Wanhui's, on the strength of the published
code.** Nothing was merged.

⚠ **This does raise a question for OEM SHEFFIELD.** `IMG/BUF/00219` and `IMG/BUF/00220` are
stored at 645/455/290 - a *Wanhui* carton figure - while their SAP `Item Remarks` reproduce
*Heavybao's* steel-thickness text verbatim. Either the dimension fields on those two SKUs were
copied from a Wanhui datasheet while the goods are Heavybao, or 645 x 455 x 290 is a shared
industry carton spec that carries no provenance at all. **Needs the business.**

https://www.heavybao.com/
https://waterboiler.en.made-in-china.com/

---

## 9. Imagery - what exists and what does not

Full ledger: `Desktop\ecommerce\products resorce final\kitchenware\_sourced.json`.

| SKU | Model | Result | Best px | Code proven |
|---|---|---|---|---|
| IMG/BUF/00177 | `RA2301` | **sourced** - 3 photos + manufacturer spec strip | 1500 x 1500 | **✔** |
| IMG/BUF/00092 | `SJD10A` | partial - Wanhui `SJD08A` single head + range table | 1346 x 1462 | ✗ |
| IMG/FPR/00239 | `QC205A` | partial - Welldone photo + Astar A and B | 3000 x 3000* | ✗ |
| IMG/BUF/00095 | `RA2302` | partial - Signature `CS-RA-2302E`, under floor | 572 x 441 | ✗ |
| IMG/BUF/00178 | `RA2301AE` | partial - Empire `EMP-RA2301B`, under floor | 1021 x 679 | ✗ |
| 12 cookware SKUs | – | manufacturer range tables + 1 range photo each | 1500 x 1500 (GN) / 600 / 500 | ✔ (code), ✗ (photo) |
| IMG/BUF/00179 | `ECD09C` | **not reached** | – | ✗ |
| IMG/BUF/00236 | `XD-HHB900` | **not reached** | – | ✗ |
| IMG/BUF/00090 | `A6-650N-32` | **not reached** | – | ✗ |

\* ⚠ **The 3000 x 3000 carries no more real detail than its 1500 x 1500 sibling.** Downsampled
to 1500 it matches that file at RMS 1.40, and it differs from a lanczos upscale of the 1500 by
only RMS 1.83. "Pick the biggest" would have overstated this asset twofold. Both are staged.

### 9.1 The cookware abstention stands, and now has the maker's endorsement

**Wanhui itself illustrates a 23-model stock-pot range with one photograph and a 20-model
sauce-pan range with one photograph.** Per-size cookware photography does not exist to be
sourced - the maker does not shoot it. What was recovered instead is better: the manufacturer's
range tables, which give diameter, height and capacity for every one of the 12 SKUs. Those are
staged as `-spec-SHARED-DOC` files.

The old research's 14 deliberate abstentions on cookware photography were correct.
**If size-specific cookware imagery is wanted, shoot the stock.**

### 9.2 Resolution ceilings proven

- **Wanhui = per-page, not per-site.** 1500 x 1500 for chafers, GN pans and shelving;
  1807 x 1774 for the juice dispenser; but only **500 x 500** (stock pots) and **600 x 600**
  (sauce pans, fry pans).
- **Astar (`micyjz.com`) = 800 x 800.** The `-800-800` suffix strips to the same original.
- **idecoratorkenya = 572 x 441** real; its 1080 x 1080 file is that photo padded onto a white
  canvas - nominally over the floor, actually under it.
- **Empire Supplies = 1021 x 679** (short edge under the floor).

### 9.3 Duplicate-image sweep, and no synthetic imagery

16 x 16 average hash shortlisting confirmed by per-pixel RMS on 256 x 256 greyscale, across all
41 staged files: **51 same-image pairs, every one a deliberate duplicate already declared in its
filename** (`-x7`, `-x3`, `-x2`, `SHARED-DOC`), plus the QC205A 3000/1500 pair which is named as
a variant. No shared photograph sits under a bare code-asserting filename.

Every file was rendered before acceptance. **No AI-generated image was found** - the
`_ai-generated\` folder is empty. Worth stating explicitly, because the sibling OEM SHEFFIELD
pass quarantined one from Heavybao.

---

## 10. Recommended changes (none applied)

**Tier 1 - manufacturer-sourced, no supplier input needed**

1. **Replace the chafer dimensions on `IMG/BUF/00177` and `IMG/BUF/00178`** with
   **635 x 455 x 440 mm**. The stored 650/460/290 and 645/455/290 are the shipping carton (§4).
   Highest-value fix available, and it also invalidates the reseller figure anyone would check
   it against.
2. **Adopt Wanhui's published capacities**: 8.8 L (`SDI2518`), 17.7 L (`SDI3222`), 3.8 L
   (`SD22013`), 6.3 L (`SD22414`), 9.8 L (`SD22816`) (§3.1, §3.2).
3. **Correct `SD22013` to 20 x 12 cm**, not 20 x 13 (§3.2). The 2026-07-30 fill used the code
   suffix as the height; on the sauce-pan series that is not what the suffix means.
4. **Reclassify `SDI2518` and `SDI3222`** - the maker files them as low-body stock pots, we call
   them High Sauce Pans (§3.1).
5. **Record the `SD`/`NF`/`I`-for-`1` prefix rule** somewhere durable (§3.1). It is the key to
   every future KITCHENWARE code and it took two passes to find.

**Tier 2 - needs the supplier or the stock**

6. **Check the sauce-pan handle configuration against actual stock** before writing copy -
   Wanhui says long-handled with helper handle, our stored photos say two-handled casserole
   (§3.3). This is the one place where the old research's photo-rejection reasoning may have
   been backwards.
7. **Ask Wanhui the `NF811` substrate.** Their plain `811` is stainless; the non-stick variant's
   base metal decides the permitted-use copy, not just a spec line (§3.4).
8. **Resolve `QC205A` vs `QC205`** - our SAP remark's disc set and the 350/750 W figures describe
   the base model while `model_number` says `A` (§7.1). **Do not publish 350 W or 750 W.**
9. **Get supplier documents for `ECD09C`, `XD-HHB900` and `A6-650N-32`** (§6). Three SKUs, two
   independent web passes, zero external evidence.
10. **Retry `whkitchenware.com` when reachable** and read the Electrical Equipment category -
    the last plausible home for the induction cooker and the heat lamp (§1, §6).

**Tier 3 - data-model decisions**

11. **Check `IMG/FPR/00239` and `IMG/FPR/00177` for duplicate stock** - same machine, two
    brands, identical stored dimensions (§7).
12. **Put the OEM SHEFFIELD `431001`/`432102` dimension question to the business** (§8).
13. **The `IMG/TCW/00386` (`CSP 2525`, KITCHENWARE) ↔ `IMG/TCW/00363` (`SDI2525`, WANHUI)
    duplicate is now explained**: both are Wanhui `12525`, 25 x 25 cm, 12.0 L. They are the same
    pot listed twice under two brand strings at a 15 % price difference. The old research raised
    this; the manufacturer's table settles that there is no product difference to find.
14. **`KITCHENWARE` and `WANHUI` are the same supplier** (§1, §13 above). Whether to merge the
    brand strings is a business decision, but nothing in the data distinguishes them.
15. **Update `house-brand-suppliers-research.md` §7.1** - the Wanhui attribution is now supported
    by a manufacturer-published model number (`RA2301`), not only by circumstantial evidence.

---

## 11. What the old research got right, and what it got wrong

Recorded so the next pass does not re-litigate either.

**Right, and now confirmed by the manufacturer:**

- The cm x cm decoding of the cookware codes, derived from cylinder volume with no source
  (old §2). Wanhui's tables agree on all 10.
- The `I`/`1` transcription hypothesis for `SDI` (old §2.2), now certain.
- That `-01` = plain lid and `-02` = viewing window on the `RA` chafers (old §3.2).
- That the three "over-brim" sauce-pan capacities are round-ups (old §2.1).
- The 14 abstentions on cookware photography (old §6, §6A) - the maker does not shoot per-size
  imagery either.
- That the stored chafer heights were not credible (old §4.2) - they are carton heights.
- That `QC205A` is a generic OEM design sold under many labels (old §3.1).

**Wrong, and corrected here:**

- **Signature is not the source of the buffet SKUs** (old §1 point 5, §3.2, §3.3). Signature is a
  Kenyan reseller that prefixes Wanhui codes with `CS-`.
- **`SJD10A` is not `CS-SJD-10A`, and "no 10 L tier exists" was over-stated** (old §3.3, §6A.2).
  The letter is the head count, not the bowl size (§5).
- **The width/height "transposition bug"** (old §4.2) is a convention difference between SAP and
  `products.json`, not a defect in SAP's ordering (§2).
- **The long-handled Adexa photo rejection** (old §6A.6) looks like the wrong call - Wanhui's own
  sauce pans are long-handled (§3.3).
- **"Kitchenware is a house label covering product from at least three unrelated sources"**
  (old §1). One source: Wanhui. The seven "unrelated code grammars" are Wanhui's own series
  prefixes plus two Sheffield-added prefixes.
