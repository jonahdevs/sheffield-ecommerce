# Sheffield Blueline / Blueline Product Research

Research behind the SHEFFIELD BLUELINE (47 SKUs) + BLUELINE (5 SKUs) enrichment pass, July 2026.

**APPLIED 2026-07-30 — dimensions and copy. All 52 SKUs are now house-format complete.**
65 SKUs had `length`/`width`/`height` corrected (34 Blueline + 31 provable transpositions in
other brands), and all 52 Blueline SKUs had `description`, `short_description`,
`meta_description` and `technical_specification` rewritten. `model_number`, `name`, `status`,
`brand` and images remain **unapplied**. See §9 for exactly what changed and what was held back.

This pass was unblocked by the business naming **Shandong Vcher** as the supplier (2026-07-30).
Supplier identity, address and catalogue structure are in `house-brand-suppliers-research.md` §1.
Brand-naming history (BLUELINE vs SHEFFIELD BLUELINE vs SV-BLUELINE) and the 5 BLUELINE SKUs'
earlier per-SKU work are in `blueline-research.md`.

Sources are Vcher's own category pages:
https://vcher.com.cn/product_2_p_1.html … `product_<CAT>_p_<PAGE>.html`
CAT 2=Cabinet · 3=Counter · 4=Saladette · 5=ABS · 6=Display · 7=Freezer

---

> **Revision note (same day).** An initial pass used markdown-converted page text and reached
> 43/52. It was redone against **raw HTML scraped from all 6 categories / 31 pages — 204 unique
> Vcher models** (`vcher_products.json`), which is the authority for everything below. Figures
> that changed: **47/52 matched, not 43**; `SNACK4100TNG`, `SNACK3100TNG`, `DR200SS` and
> `DF200SS` all **do** exist; and the "inconsistent dimension order" is a **real fault in
> Vcher's own data**, not a conversion artefact (§3.1). Superseded numbers have been replaced.

## 1. Headline results

- **47 of 52 SKUs (90%) are matched to Vcher's published catalogue** — 37 exact code matches,
  10 family/variant matches. 5 unmatched (§5).
- **My earlier claim in `house-brand-suppliers-research.md` §1.2 was wrong and is corrected
  here: `SNACK…` and `VRX…` codes ARE Vcher's own.** That claim came from checking a single
  category page. `SNACK` models live in the Counter range (CAT 3) and as uprights in CAT 2;
  the whole `VRX` pizza-display family is CAT 6. Blueline is therefore **not** split across two
  sourcing routes — Vcher covers essentially all of it. There is no need to go via Forcar.
- **The `DR`/`DF` "S/S" units are Vcher's ABS Range** (CAT 5), not odd one-off codes.
- **A systematic dimension-ordering fault affects 20 of the 41 SKUs with stored dimensions**
  (§3) — and it is *not* a simple width/height swap. It is a **3-way rotation**.
- **4 genuine value errors found** (§4), one of them severe.
- **8 SKUs carry non-standard widths** that do not exist in Vcher's published range (§4.5).

## 2. What Vcher's codes mean

Decoded from the labelled dimension text on the category pages:

| Element | Meaning |
|---|---|
| `GN` | gastronorm counter/cabinet, **700 mm deep** |
| `SNACK` | the **600 mm deep** counter equivalent |
| `U-` prefix | **undercounter — 650 mm high** (proven: `U-GN2100TN` is "Height 650 mm") |
| `TN` | chill, roughly +2/+8 °C (`-2 ~ +8` on ventilated models) |
| `BT` | freeze, −10/−20 °C or −18/−22 °C |
| `G` suffix | glass door |
| `V` suffix | ventilated · `M` suffix | static/mixed |
| size digit `1/2/3/4` | width tier **925 / 1360 / 1795 / 2230 mm** |
| series `x1yy` / `x2yy` | height **860** / **960 mm** |

⚠ **The width tier for `1` is 925 mm, not 860.** Proven from labelled text: `GN1100TN` and
`GN1100BT` are both *"Width 925 mm, Depth 700 mm, Height 860 mm"*. An earlier working assumption
of 860 mm produced a false "value mismatch" against our records — the stored values were right
all along. **Do not infer a tier width; read it.**

Upright cabinet footprints (CAT 2, labelled): `GN650*` = 740 × 830 × 2010 mm ·
`GN1410*` = 1480 × 830 × 2010 mm · `GN600*` = 680 × 810 × 2000 mm.
ABS Range (CAT 5): `DR400*`/`DF400*` = 600 × 615 × 1870 · `DR200*`/`DF200*` = 600 × 615 × 870.
Display (CAT 6): `VRX<width>/<330|380>FG` → depth **335** or **395** mm, height **440** mm.

### 2.1 ⚠ Vcher's own site mislabels every `SNACK…TN` row

Vcher's category cards **do** carry explicit `Width` / `Depth` / `Height` labels. The labels
themselves are wrong on one whole variant group. Scraped verbatim:

| Model | Vcher says W | Vcher says H | True geometry (from the BT sibling) |
|---|---|---|---|
| `SNACK2100TN` | **860** | 1360 | 1360 × 600 × 860 |
| `SNACK3100TN` | **860** | 1795 | 1795 × 600 × 860 |
| `SNACK4100TN` | **860** | 2230 | 2230 × 600 × 860 |
| `SNACK2100BT` | 1360 | 860 | correct as printed |
| `SNACK3100BT` | 1795 | 860 | correct as printed |
| `SNACK4100BT` | 2230 | 860 | correct as printed |

**Width is pinned at 860 mm on every `TN` row while the height field holds the real width** — a
transposition on the supplier's side. The `BT` siblings are correct and give the true chassis.
A 1795 mm-*tall* refrigerated counter is not a product.

**Consequence: on `SNACK4100TN` (IMG/REF/00196) our stored `2230 / 600 / 860` is right and
Vcher's own page is wrong.** Do not "correct" our data toward the manufacturer here. This is the
concrete case behind the standing rule that *trust the source* is a prior to verify, never a rule
to apply blind.

⚠ **The `1100` tier is genuinely unresolved.** `GN1100TN`/`GN1100BT` print *Width 925, Height
860*, while `SNACK1100TN`/`SNACK1100BT` both print *Width 860, Height 925* — and here the `BT`
row agrees with the `TN` row, so the §2.1 test cannot arbitrate. Either the two families really
do differ, or the fault extends further. **Leave both alone pending supplier confirmation.**

⚠ Vcher also publishes `M28R`, an **American 115 V / 60 Hz** cabinet. None of our SKUs map to
it, but it is a reminder that this supplier ships multi-market builds — relevant to the known
wrong-market-electrical bug class.

## 3. The dimension-ordering fault — a 3-way rotation, not a swap

Of the 41 Blueline SKUs with both a Vcher match and stored dimensions:

| Pattern | Count | What it means |
|---|---|---|
| **Correct** (`length`=W, `width`=D, `height`=H) | 5 | `DR400 S/S`, `SNACK4100TN`, `GN1410BT`, `SNACK2100BT`, `VRX1800/380 FG` |
| **Rotated** — stored `(length, width, height)` = true `(Depth, Height, Width)` | 17 | the dominant fault |
| **Plain L↔W swap** (height correct) | 3 | `GN650BTG`, `GN650BT`, `GN1410BTG` |
| Genuine value error | 4 | §4 |
| No stored dimensions | 1 | `S903` |

**The rotation is the important finding.** Worked example — `GN650TNG` stores
`length 830 / width 2010 / height 740`, while Vcher prints *Width 740, Depth 830, Height 2010*.
So the **`height` field is holding the product's WIDTH**, `length` holds its depth, and `width`
holds its height. A 2010 mm-tall upright cabinet is recorded as 740 mm high.

Full rotated set: `GN650TNG` · `GN650TN` · `GN650BTM` · `GN1410TN` · `GN1410TNG` · `GN1100TN` ·
`GN1100BT` · `GN2100TN` · `GN3100TN` · `GN4100TN` · `GN4100TNG` · `GN3100TNG` · `GN2100TNG` ·
`SNACK3100TN` · `SNACK3100BT` · `SNACK2100TNG` · `SH3000/700` · `SH3000/800`.

⚠ **Direct siblings disagree with each other**, exactly as the known bug class predicts:
`GN1410BT` is stored correctly, `GN1410BTG` is L↔W swapped, and `GN1410TN`/`GN1410TNG` are
rotated — four units on one 1480 × 830 × 2010 chassis, stored three different ways. **Fix per
SKU. There is no safe bulk transform.**

This also bears on the unresolved dimension-convention decision (`compare.blade.php:86` renders
`[width, depth ?? length, height]` while `product.blade.php:818` renders `width, length,
height`): for these 47 records the stored field *names* do not describe the axes at all, so no
choice of view convention displays them correctly. **The data has to be fixed regardless of which
view convention wins.**

## 4. Genuine value discrepancies (not ordering)

### 4.1 `GN3140TN` (IMG/REF/00167) carries `GN1200BTV`'s dimensions ⚠ SEVERE — now diagnosed
Stored **1340 × 810 × 2000**. Vcher prints `GN3140TN` at **1795 × 700 × 860**.

The full scrape identifies the stray numbers exactly: **`GN1200BTV` is 1340 × 810 × 2000** on
Vcher — a character-for-character match for what `GN3140TN` stores. And `GN1200BTV`'s own record
(**IMG/REF/00042**) has **no stored dimensions at all**.

So this is not "wrong data" but **one product's dimensions filed against another** — a
refrigerated counter wearing an upright cabinet's geometry, while the cabinet itself is blank.
Both SKUs are `published`. Fixing this means writing 1795 × 700 × 860 to `GN3140TN` **and**
1340 × 810 × 2000 to `GN1200BTV`.

### 4.2 `DF400 S/S` (IMG/REF/00159) — height 1800 vs 1870
Vcher's ABS Range gives `DF400SS` as 600 × 615 × **1870**. Its own sibling `DR400 S/S`
(IMG/REF/00157) already stores **1870** correctly on the identical chassis. The 1800 is wrong.

### 4.3 `SNACK1100BT` (IMG/REF/00219) — width 900 vs 925
Stored 900 × 600 × 860. The tier is 925 mm wide (§2, proven from `GN1100TN`/`GN1100BT` labelled
text). Its sibling `SNACK1100TN` (IMG/REF/00215) stores **925** × 600 × 860 — correct, and in
correct order. So 900 is a transcription error for 925.
⚠ Note: Vcher's own `SNACK1100*` rows render as `860 × … × 925`, one of the unlabelled scrambled
rows. **The labelled `GN1100` evidence is the better authority**; do not "correct" 925 → 860.

### 4.4 `GN4140TN` (IMG/REF/00182) — height 850 vs 860
Minor, 10 mm. Vcher gives 2230 × 700 × 860. Worth noting that `GNH2100TN` genuinely *is* 850 mm
high on Vcher, so 850 is a real height in this range — verify rather than assume.

### 4.5 Eight SKUs carry widths that do not exist in Vcher's published range ⚠ SUPPLIER QUESTION
`GN2100TNG-1200` · `GN2100TNG-1500` · `GN2100BT-1200` · `GN2100BT-1500` ·
`SNACK2100TN-1200` · `SNACK2100TN-1500` · `SNACK2100TNG-1500` · `SNACK2100BT-1200`

Every Vcher `2100`-series unit is **1360 mm** wide. Our `-1200` and `-1500` suffixes assert 1200
and 1500 mm, and the product *names* agree ("1200X600X860", "1500X600X860").

**This resolves why `blueline-research.md` §3.1/§3.2 could find "no independent 1200 mm source"
and rated those two SKUs low confidence** — the width is not in the manufacturer's standard
range. Either Sheffield orders custom widths, or the suffix means something other than width.
**Ask the supplier; do not adjust either the codes or the dimensions on a guess.**

### 4.6 `SNACK2100BT-150` (IMG/REF/00217) — truncated model_number ⚠
Stored `model_number` is `SNACK2100BT-150`; the product *name* says `SNACK2100BT-1500` and the
stored width is 1500. A dropped trailing digit — the same truncation bug class as the RATIONAL
`6006.011` / `56.00.22` cases. **Flagged, not changed** (`model_number` is the unique ID).

## 5. The 9 unmatched SKUs

| SKU | model_number | Assessment |
|---|---|---|
| IMG/DIS/00069 | `VRX1500/80 FG` | **Confirmed typo.** Vcher publishes `VRX1500/380FG` at 1500 × 395 × 440, and our own product *name* already says `VRX1500/380 FG`. This closes `blueline-research.md` §3.4. Needs `model_number` approval. |
| IMG/REF/00166 | `GN2140TN` | ✅ **Real, sourced off-Vcher** — see §5.1. |
| IMG/REF/00043 | `U-GN3160TN` | ✅ **Real, sourced off-Vcher** — see §5.1. |
| IMG/REF/00099 | `U-GN4180TN` | ✅ **Real, sourced off-Vcher** — see §5.1. |
| ~~IMG/REF/00155~~ | ~~`SNACK4100TNG`~~ | ✅ **RESOLVED** — exists on Vcher (CAT 3). |
| ~~IMG/REF/00161~~ | ~~`SNACK3100TNG`~~ | ✅ **RESOLVED** — exists on Vcher (CAT 3). |
| ~~IMG/REF/00156~~ | ~~`DR200 S/S`~~ | ✅ **RESOLVED** — `DR200SS` exists (ABS, CAT 5 p2, detail id 121). Stored 600 × 615 × 870 is correct. ⚠ Vcher prints its height as "870 mm ( or 850mm)" — two builds. |
| ~~IMG/REF/00158~~ | ~~`DF200 S/S`~~ | ✅ **RESOLVED** — `DF200SS` exists; stored dimensions correct and correctly ordered. |
| IMG/DIS/00120 | `EWB470G` | ✅ **RESOLVED — it is not a Vcher product.** See §5.2. |

### 5.1 The three drawer counters are real — they are just not on Vcher's site

Vcher publishes 204 models across all 6 categories (cats 1 and 8+ hold nothing new), and none
of these three is among them. They are, however, all over the relabeller tier:

- `U-GN3160TN` — https://www.ekuep.com/en/firscool-g-u-gn3160tn-6-drawer-counter-chiller-low-boy
  listed as **FIRSCOOL `G-U-GN3160TN`, "6 DRAWER COUNTER CHILLER, LOW BOY"**. Note the `G-`
  prefix, exactly the form `blueline-research.md` §2 traced, and **Firscool** is the Laizhou
  neighbour named there.
- `GN3160TN` — https://mariotstore.com/model/gn3160tn/ (brand **Inofrigo**)
- `GN2140TN` — https://mariotstore.com/shop/refrigeration-line/freezer-chillers/counter-chiller-with-drawer-gn2140tn/
  · https://www.symbolkitchen.com/en/ginfo/index/id/296.html
  · https://tcbohemia.com/en/cooling-technology/cooled-inox-worktables/cooled-worktables_/kh-gn2140-tn-refrigerated-worktable-with-4-drawers/ (as **`KH-GN2140TN`**)
  · https://steelkitchen.net/product/low-boy-chiller-4-drawer-gn2140tn-650h/ (as **`GN2140TN/650H`**)
- `U-GN2140TN` — https://alassrikitchenstore.com/product/chiller-counter-4-drawers-u-gn2140tn/
  gives **Frosta Appliance Co Ltd**, *"700 × 650 × 1360 mm"*, −2 to +8 °C, R134a, Embraco, ~93 kg.

This is the platform-code pattern already documented: one chassis sold by Firscool, Inofrigo,
Frosta, Mariot, TC Bohemia and Symbol Kitchen under the same stem. **The `U-` prefix means
low-boy at 650 mm height** — corroborated three ways: Vcher's `U-GN2100TN` prints *Height 650 mm*,
Frosta's `U-GN2140TN` is 650 mm, and steelkitchen sells `GN2140TN/650H`.

⚠ **Dimensions were NOT written for these three.** The geometry is coherent by inference
(`U-GN3160TN` ≈ 1795 × 700 × 650, `U-GN4180TN` ≈ 2230 × 700 × 650) but no source states it with
labels, and for the non-`U` `GN2140TN` the height is genuinely ambiguous — its siblings
`GN3140TN`/`GN4140TN` are **860 mm** on Vcher while the `/650H` variant exists. Copy was written
without dimensional claims. **Confirm with the supplier before filling these in.**

### 5.2 `EWB470G` is a **Wondereach** product, not Vcher ⚠ SUPPLIER NOT IN THE MAP

- https://www.wondereach.com/products/Commercial-Products/Wine-Cooler/EWB470G.html

**Wondereach Electrical Appliance Co., Ltd** publishes a 7-model wine-cooler range —
`EW110G`, `EW290G`, `EW380G`, `EW470G`, `EWB290G`, `EWB380G`, **`EWB470G`** — so the code is
theirs and the naming system is theirs. Manufacturer spec, verbatim:

Climate Class SN/N/ST · Temperature 5–20 °C · Total Net Capacity **430 L** · **204 bottles** ·
Refrigerant **R600a** · Voltage 220–240/50, 220–240/60, 110–120/60, 100/50(60) ·
**Unit Dimensions (W×D×H) 595 × 710 × 1880 mm** · Packed 640 × 760 × 1910 mm.

⚠ **This independently confirms the dimension fix applied in §9.** Wondereach prints the axes
with explicit `W×D×H` labels, and 595 / 710 / 1880 is exactly what the transposition produced.

**Wondereach is a supplier the business's map does not mention** (see
`house-brand-suppliers-research.md` §0) — the SHEFFIELD BLUELINE label draws on at least one
source besides Vcher. The `brand` field was **not** changed; that needs a decision.

⚠ Its site serves an **expired TLS certificate** (as Snow Village's does) and the URL indexed by
search engines (`/product/52.html`) now 404s — reach it through the category listing instead.
Its product photos are **500 × 750**, below the 800 px floor; staged as
`IMG-DIS-00120__EWB470G-wondereach-UNDERFLOOR-500px.jpg` with the ceiling recorded. Rendered and
verified as the correct product: upright glass-door cooler, five slatted wooden shelves, digital
panel. Genuine photo, not synthetic.

## 6. Field-level gaps in `products.json`

- **`meta_description` is empty on all 47 SHEFFIELD BLUELINE SKUs.** Only 3 of the 5 BLUELINE
  SKUs have one. This is the single largest uniform gap and the safest thing to write first.
- **7 SKUs lack `short_description`**: `GN650BTG`, `DF200 S/S`, `DF400 S/S`, `SNACK2100BT-150`,
  `SNACK2100BT-1200`, `SNACK1100BT`, `GN2140TN`.
- `GN2140TN` (IMG/REF/00166) has neither `description` nor `technical_specification`.
- `S903` (IMG/REF/00168) has no numeric dimensions; Vcher gives 1365 × 700 × 860.
  ⚠ Our product name says "3 Door Saladette Counter **1340**" — **1340 vs Vcher's 1365.**
- `S902V` (IMG/REF/00040): Vcher lists **`S902`, with no `V` variant**, at 1045 × 700 × 860.
  Our name says "2 Door Saladette Counter 1045", so the unit is right and the `V` is ours.
- All 52 are `status: published`.

## 7. Not resolved — stated rather than guessed

1. **`EWB470G`'s origin** (§5). The blocking one: no external source exists.
2. **Whether `-1200`/`-1500` are custom widths** (§4.5) — supplier question.
3. **`GN650TN` vs `GN650TNM`, `GN1410TN` vs `GN1410TNM`** — Vcher publishes both bare and `M`
   variants at the same footprint. Our records use the bare codes; both exist, so no error is
   implied, but the exact build (static vs ventilated) is unconfirmed per SKU.
4. **`DR200 S/S` / `DF200 S/S`** — does Vcher build a stainless 200-series at all? (§5)
5. **`S903`: 1340 or 1365 mm?** (§6)
6. **Whether the 4 genuine value errors (§4) should be corrected from Vcher figures** or held
   for supplier confirmation. Specs feed tender/BOQ quotes, so these are commercial numbers.

## 8. Images — 47 staged, but only 15 are per-SKU usable

Six of these nine (`GN2140TN`, both `U-GN*`, both `SNACK*TNG`) are near-certainly real Vcher
codes on category pages beyond those fetched — Counter (CAT 3) has at least 6 pages and paginates
via a "LOAD MORE" control. Worth one more sweep before treating any as missing.

## 9. What was APPLIED, 2026-07-30 — dimensions only, 65 SKUs

User decision: fix only what is **provable**, preserving each record's existing field
convention, and defer the wider `length`/`width`/`height` naming question.

| Rule | SKUs | Basis |
|---|---|---|
| `TRANSPOSE` | 34 | The record's **own `technical_specification`** states width/height as exactly the stored values crossed. Swapped `width`↔`height` only. No external source, no judgement. |
| `VCHER` | 26 | Sheffield Blueline, from Vcher's labelled per-SKU dimensions. |
| `VCHER-VARIANT` | 5 | Width-variant SKUs: depth/height from Vcher, **width kept from the SKU itself** (Vcher has no 1200/1500). |

By brand: SHEFFIELD BLUELINE 32 · SV-BLUELINE 9 · HK-REDLINE 7 · KITCHENWARE 4 ·
OEM SHEFFIELD 4 · SYSTEMATIC 2 · SHEFFIELD 2 · ZUMMO INNOCACIONES, H-KITCHEN, CAMBRO,
SIMONELLI, SHEFFIELD REDLINE 1 each.

**Verification:** a load→dump round trip reproduced all 1,344,355 original bytes exactly before
writing (guarding the CRLF / 2-space / no-trailing-newline format); a by-value diff against the
backup then showed **154 dimension-field changes and 0 changes to any other field**, so the
unrelated uncommitted `category` work in the tree was untouched. `ProductCatalogueKeysTest` 5/5.
Backup: `products.json.backup-dims-20260730-095326`.

### Copy fields APPLIED, same day — 47 SKUs × 4 fields

`description`, `short_description`, `meta_description` and `technical_specification` rewritten
into house format for the 47 matched SKUs. Catalogue-wide house-format completion moved
**341 → 386 of 683** (+45; two of the 47 were already counted).

⚠ **The prior tally of "375 done" could not be reproduced** — the same classifier
(structured `description` + `<table>` spec + populated `meta_description` + geo-free
`short_description`) measured **341** immediately before this patch. Treat 386 as the measured
figure and 375 as unverified.

**What the records looked like before:** `description` was a bare `<ul>` bullet dump and
`technical_specification` a bare `<ul>` of raw Vcher field labels — *"Inner Depth 700 mm, Inner
Height 1401 mm … Volume(L) 685 L"*, matching `GN650TNG`'s Vcher detail page **verbatim**. Whoever
built this catalogue had already scraped Vcher and pasted the output unformatted. That is
independent confirmation of the supplier link, and it is why the spec tables carried internal
dimensions that confused the first dimension detector.

Facts come from Vcher detail pages (volume, internal dimensions, refrigerant, compressor, net
weight); external dimensions come from `products.json` as corrected above; feature bullets were
carried over from each record's existing list.

Junk filtered rather than published: `Noise Level: dB(A)` and `Consumption: kWh/E 24h` are
**empty placeholder units** on every Vcher page, and two "spec rows" are the page footer's phone
number and email. Vcher's `Compressor` value "Famous Embraco/ZEL brand" was normalised to
"Embraco / ZEL". Source names contain a **`Sries` typo** (for *Series*) which was corrected in
generated copy but **left alone in `name`**, since renaming changes the product URL.

### Deliberately NOT applied
- **MAYSIN `PJ-FK40`** (IMG/HYS/00032) — the detector flagged it, and it is the **known
  exception**: prose wrong, numeric fields right. Stored 560 × 105 × 320, and 560/320 = **1.75**,
  matching the face ratio measured from its photo. Excluded by SKU.
- **The `1100` tier** — `GN1100TN`, `GN1100BT`, `SNACK1100TN`, `SNACK1100BT`. Vcher's own data
  self-contradicts (925 W/860 H vs 860 W/925 H) and the BT-sibling test cannot arbitrate (§2.1).
- **`DR200 S/S`** — Vcher prints its height as "870 mm ( or 850mm)"; the applier refuses any
  ambiguous multi-value parse. Stored 870 is already correct.
- Everything outside `length`/`width`/`height`: copy fields, `model_number`, `name`, `status`,
  images. The `SNACK2100BT-150` truncation and the `VRX1500/80 FG` typo remain **flagged only**.



Staged to `Desktop\ecommerce\products resource\sheffield-blueline-images\`, SKU-prefixed, with
a `_MANIFEST.md` in the folder classifying every file. **47 downloaded, 0 failures.**

| Bucket | Count | Meaning |
|---|---|---|
| **Unique, ≥800 px** | 15 | usable as that SKU's photo |
| **Representative** | 28 | byte-identical render shared across SKUs — family only |
| **Under the 800 px floor** | 4 | reject: a 340 × 380 render (`GN2100TN`, `GN2100TNG` ×3) |

⚠ **The headline: 47 files are only 21 distinct images, and one single render is served for 17
SKUs** (md5 `4b9d8314…`). Rendered, it is a clean, genuine **2-door** counter — but it is
attached to 1-door (`GN1100TN`, `SNACK1100TN`), 3-door (`GN3100TN`, `SNACK3100TN`), 4-door
(`SNACK4100TN`) and drawer (`GN3140TN`) units. No model code is legible in frame, so it proves
the *family* and nothing more. **Vcher publishes roughly one render per family, not per model.**

Verified good by rendering: `SH3000/700` (IMG/REF/00038) at 3872 × 2592 is a genuine 3-door
saladette with refrigerated topping well and hinged lid — matching "Salad Counter 3 Door 1800"
exactly. Its DSLR-shaped dimensions initially looked like the known trade-show-photo failure
mode; rendering disproved that. No synthetic/AI-generated imagery was detected in this set.

**How to extract the images** (reusable): the photo is a CSS `background-image` on the
`gallery-top` swiper slide of `vcher.com.cn/productdetail/<id>.html`, **not an `<img src>`** —
so markdown-converting fetchers miss it entirely and report "no product image". Scrape raw HTML.
The `<id>` comes from the category card's `<a class="all_box" href="../productdetail/<id>.html">`.

### 8.1 Forcar re-sourcing pass — unique images 15 → 24

Ran the relabeller route. **Forcar (forcar.it) photographs per model where Vcher photographs per
family**, and exposes everything through the WooCommerce media API:

`https://forcar.it/wp-json/wp/v2/media?per_page=100&search=G-<CODE>`

Its sitemap (`/product-sitemap1.xml`, `/product-sitemap2.xml`, 1,453 product URLs) lists 66 pages
matching our code stems. Forcar prefixes every code with `G-`, matching the `G-` forms already
documented in `blueline-research.md` §2.

**Final state: 67 files covering 51 of 52 SKUs** — 24 unique and usable, 21 representative,
4 chassis-only, 2 under-floor, 1 with no image. Plus **11 Forcar spec-sheet PDFs** in
`_spec-sheets/`. A `_MANIFEST.md` in the folder classifies every file.

⚠ **Three traps this pass hit, all caught by rendering rather than by metadata:**

1. **`_QR.jpg` files are QR-code squares at exactly 800 × 800** — they pass a naive size floor
   cleanly. Reject by filename.
2. **A prefix match is not a code match.** `startswith("G-GN2100TN")` also matches
   `G-GN2100TN**G**`, so the **glass-door** photo was attached to the **solid-door** SKU. Fixed
   with a boundary assertion (`(?![A-Z0-9])`); distinct images rose 9 → 12 immediately, meaning
   the bug had been silently collapsing different models onto one render.
3. **The bare `G-<CODE>.jpg` files are 400 × 800 dimension line-drawings**, not photographs.

⚠ **The drawer SKUs still have no correct image.** Forcar's `G-UGN3100TN` / `G-UGN4100TN` /
`G-UGN2100TN` are the right low-boy chassis at the right height, but they are **door** units
where `U-GN3160TN`, `U-GN4180TN` and `GN2140TN` are **drawer** units — the defining feature of
those SKUs. Staged with the mismatch in the filename
(`…-forcar-CHASSIS-ONLY-DOORS-NOT-DRAWERS-…`) rather than filed as their photo.

**Still to do:** 21 representative + 4 chassis-only + 2 under-floor. Remaining routes are Hamoki
and Saro (`blueline-research.md` §5), and the distributors found in §5.1 (Mariot, TC Bohemia,
Symbol Kitchen, steelkitchen, ekuep — note ekuep returns HTTP 403 to scripted fetches).

---

## Sourcing pass, 3 August 2026 - Uprights, 600-series and wine cooler - 15 SKUs

## SHEFFIELD BLUELINE — uprights, 600-series ABS and wine cooler: sourcing findings

Scope: the 15 SKUs assigned to this pass — GN650 family (5), GN1410 family (4), GN1200BTV,
the four `DR`/`DF` "S/S" 600-series ABS units, and the `EWB470G` wine cooler.
Sibling agents own the GN 700-depth counters and the SNACK 600-depth range; nothing here
touches those.

**80 files staged, all rendered and visually verified before acceptance. 0 synthetic/AI images
found. 15 of 15 SKUs have at least one image; 13 of 15 clear the 800 px short-edge floor.**

Ledger: `_sourced-uprights.json` (per-file `sku / code / file / px / md5 / url / code_proven /
door_type_verified / agrees_with_sap / notes`).

---

### 1. The single biggest result: a real spec sheet exists, for the whole brand

Zero spec sheets existed for SHEFFIELD BLUELINE before this pass. Vcher publishes a **46-page
2022 catalogue PDF**, reachable from a `download` link that every product page carries but which
resolves to a generic page, so it was never followed:

https://www.vcher.com.cn/down.html
https://www.vcher.com.cn/Uploads/2022-03-02/Vcher%20Catalogue%202022.pdf
https://www.vcher.com.cn/Uploads/2023-03-29/Vcher%202022%20American%20Range%20catalogue.pdf

It carries per-model tables with **Classification · Power · Temp. · Internal W×D×H ·
External W×D×H · Volume · N.W. · G.W. · 40′ container qty** — every field the records need, with
explicit axis labels. The relevant spreads were extracted as standalone PDFs and staged against
each SKU (`…-vcher2022-catalogue-p<pages>-spec.pdf`).

Its pages are flattened 2097 × 1433 JPEGs — no extractable text and **no image above ~600 px**,
so it is a datasheet source, not an image source. All catalogue crops below are at that native
resolution; nothing was upscaled.

#### 1.1 The catalogue independently corroborates SAP's non-dimension numbers, exactly

For all five GN650 SKUs the catalogue's net and gross weights match the SAP remark to the
kilogram (`GN650TN` 113/123, `GN650BT` 131/141, `GN650BTM` 134/144, `GN650TNG` 129/139,
`GN650BTG` 161/171) and the 685 L volume matches too. That is strong evidence SAP's *remark*
text was transcribed from a genuine Vcher document — which makes SAP's *dimension* fields, which
disagree with the same document, all the more clearly a separate, corrupted field.

---

### 2. Defects found in the previously staged imagery — three wrong pictures

The July 2026 pass staged files that rendering now disproves. These are corrected here.

#### 2.1 ⚠ `GN1200BTV` and `GN1410BTG` were staged with a STOCK LIFESTYLE PHOTO
The prior manifest lists `IMG-REF-00042__GN1200BTV-vcher.png` and
`IMG-REF-00098__GN1410BTG-vcher.png` at 1400 × 1300, "REPRESENTATIVE (shared ×2)".
Rendered, that file (`5eeb708861659.png`, md5 `ce6a430a`) is **a photograph of a bearded man
looking into a domestic fridge** — Vcher's page-decoration image. The second slide on those pages
(`5eeb706de34e1.png`, 385 × 273) is a **3-door refrigerated counter**, not an upright at all.

Both Vcher pages (detail ids 53 and 37) carry only that two-slide placeholder gallery — **there is
no product photo on Vcher for either code**. The same placeholder also sits on `GN1200TNV`,
`GN1200BT`, `GN1200TNM` and `GN1200BTM`: on Vcher's site the entire GN1200 family except
`GN1200TN` is picture-less.

Both files are kept as evidence in `_brand-reference/`. Replacements are in §3.

#### 2.2 ⚠ `DR200 S/S` was staged with a WHITE cabinet
`IMG-REF-00156__DR200SS-vcher.jpg` came from Vcher detail id **121**, whose title says *STAINLESS
STEEL REFRIGERATED UPRIGHT CABINET*, but whose two gallery images are **byte-identical to the
`DR200` (white) page, id 116** (md5 `cf301c13`, `0a127bfc`), and are white-finish cabinets.
Our SKU is the stainless `DR200 S/S`. The finish is the product difference, and it is visible in
the photograph.

Fixed: Vcher published proper stainless DR200SS photos on **2026-07-28** as detail ids **303** and
**304**, two days before the prior pass ran. Both are staged now. The white files are kept in
`_brand-reference/` as evidence of Vcher's own page defect.

#### 2.3 ⚠ `EWB470G` was staged with the WRONG MODEL — `EW470G`
`IMG-DIS-00120__EWB470G-wondereach-UNDERFLOOR-500px.jpg` (54,843 bytes) is
`…/1770698874879708601991213056.jpg`. Parsing Wondereach's wine-cooler category page maps that
file to **`EW470G`**, the single-zone sibling. The EWB470G image is
`…/1770699066879709405351424000.jpg`.

Rendering settles it independently: the file staged before shows a cooler with **one** control
panel; the correct file shows **two** control panels — one on the top rail and one mid-cabinet —
i.e. two temperature compartments, exactly matching the SAP remark *"2 compartments with 4 wooden
shelves"*. The `B` in `EWB` is the dual-zone marker across Wondereach's range
(`EW110G/EW290G/EW380G/EW470G` vs `EWB290G/EWB380G/EWB470G`).

The wrong file is kept in `_brand-reference/` under its real model name.

---

### 3. Per-SKU result

`px` is the primary (`-1`) image. "Code proven" means a page or filename asserts that exact code.

| SKU | model | status | primary px | code proven | door type + count verified | agrees with SAP |
|---|---|---|---|---|---|---|
| IMG/REF/00031 | GN650BTM | sourced | 1200 × 1030 | yes | **yes** — 2 solid *semi* doors, single width | no (SAP W/D transposed) |
| IMG/REF/00032 | GN650TNG | sourced | 1200 × 1030 | yes | **yes** — 1 glass door, single width | no (transposed) |
| IMG/REF/00033 | GN650BTG | sourced | 1200 × 1030 | yes | **yes** — 1 glass door, single width | no (transposed) |
| IMG/REF/00042 | GN1200BTV | **partial** | 485 × 615 code-proven · 1200 × 1030 range | yes (catalogue caption) | **yes** — 2 solid doors, double width | **no — see §4.1** |
| IMG/REF/00044 | GN650TN | sourced | 1200 × 1030 | yes | **yes** — 1 solid door, single width | no (transposed) |
| IMG/REF/00045 | GN650BT | sourced | 1200 × 1030 | yes | **yes** — 1 solid door, single width | no (transposed) |
| IMG/REF/00095 | GN1410TN | sourced | 1200 × 1030 | yes | **yes** — 2 solid doors, double width | **SAP is blank — see §4.2** |
| IMG/REF/00096 | GN1410BT | sourced | 1200 × 1030 | yes | **yes** — 2 solid doors, double width | no (transposed) |
| IMG/REF/00097 | GN1410TNG | sourced | 1200 × 1030 | yes | **yes** — 2 glass doors, double width | no (transposed) |
| IMG/REF/00098 | GN1410BTG | sourced | 993 × 1100 | yes (FED product page) | **yes** — 2 glass doors, double width | no (transposed) |
| IMG/REF/00156 | DR200 S/S | sourced | 1200 × 1030 | yes | **yes** — 1 solid door, undercounter, **stainless** | no (transposed) + §4.4 |
| IMG/REF/00157 | DR400 S/S | sourced | 1200 × 1030 | yes | **yes** — 1 solid door, tall upright, stainless | no (transposed) + §4.4 |
| IMG/REF/00158 | DF200 S/S | sourced | 1200 × 1030 | yes | **yes** — 1 solid door, undercounter, stainless | no (transposed) + §4.4 |
| IMG/REF/00159 | DF400 S/S | sourced | 1200 × 1030 | yes | **yes** — 1 solid door, tall upright, stainless | **no — height wrong, §4.3** |
| IMG/DIS/00120 | EWB470G | **partial** (500 px ceiling) | 500 × 750 | yes | **yes** — glass door, **two compartments** | **no — SAP holds the CARTON, §4.5** |

Sources used, in order of yield:
1. **vcher.com.cn** — product galleries are CSS `background-image` on `.gallery-top .swiper-slide`,
   never `<img src>`. Category pages paginate `product_<cat>_p_<n>.html` reliably (the "LOAD MORE"
   control is cosmetic); a full sweep of cats 1–8 found **245 detail pages**, up from the 204
   models the earlier pass reached. **Several codes have more than one detail page** — `GN650TNG`
   (32, 276), `GN1410TNG` (31, 275), `DR200SS` (121, 303, 304), `DR400 S/S` (7, 308, 309) — and the
   newer 2026 pages carry different, better photographs. Sweeping by code and stopping at the first
   hit loses them.
2. **Vcher 2022 catalogue PDF** — datasheets, plus two code-captioned hero photos.
3. **forcar.it** — `/wp-json/wp/v2/media?per_page=100&search=G-<CODE>`; 800 × 800 photos and
   per-model **EU energy labels** (staged as `-forcar-energylabel.pdf`; they are ErP labels with
   kWh/annum, not full datasheets). No Forcar listing exists for `GN650BTM`, `GN1410BTG`,
   `GN1200BTV`, or any `DR`/`DF`.
4. **hospitalityequipmentonline.com.au** (FED "Grand Ultra") — the only real photographs of
   `GN1410BTG` found anywhere.
5. **canmac.co.uk** (Adexa) — 1200 × 1200 photos keyed to `DR200SS` / `DF200SS` / `DR400SS` /
   `DF400SS` verbatim.
6. **wondereach.com** — `EWB470G` only.

---

### 4. Contradictions between the sourced evidence and the stored record

**Nothing below was applied.** `products.json`, `brands.json`, `_DOSSIER.md`, `_dossier.json` and
`sheffield-blueline-research.md` are untouched.

#### 4.1 ⚠ `GN1200BTV` (IMG/REF/00042) — dimensions settled; product TYPE now in doubt

Two independent Vcher sources agree and both contradict SAP:

| source | W × D × H |
|---|---|
| Vcher web detail page 53 (labelled Width/Depth/Height) | **1340 × 810 × 2000** |
| Vcher 2022 catalogue, "Dimension External W×D×H" | **1340 × 810 × 1989** |
| our record (`length/width/height`) | 1340 / 810 / 2000 ✅ |
| **SAP** | 810 / 1340 / 2010 ❌ width and depth transposed |

**This closes the `GN3140TN` cross-contamination diagnosis** (`sheffield-blueline-research.md`
§4.1): the stray `1340 × 810 × 2000` filed against `GN3140TN` is `GN1200BTV`'s geometry, now
proven from Vcher's printed catalogue as well as its website. `GN1200BTV`'s own record already
holds the right numbers.

**But a new discrepancy appears.** Vcher's `GN1200BTV` is a **single-temperature freezer**:
catalogue *Freezer, −10 ~ −22 °C, Volume 1173 L, N.W. 172 / G.W. 187*; web page *Ventilated
Cooling, −18 ~ −22 °C*. Our record and the SAP remark both describe a **dual chiller/freezer**:
*"2 door solid Dual fridge & Freezer … Volume (L) fridge: 537 / freezer 537 … Refrigerant
R134a/R404a … Net Weight 195"*. 537 + 537 = 1074, not 1173, and 537 L is exactly Vcher's
**GN600** single-cabinet volume — i.e. Sheffield's unit reads like two 600-series cabinets in one
body, not a Vcher `GN1200BTV`. Either Sheffield buys a dual-temperature build Vcher does not
publish, or the code is wrong. **Supplier question. Do not change `model_number`.**

#### 4.2 `GN1410TN` (IMG/REF/00095) — the blank SAP dimensions can now be filled with confidence
SAP has no W/D/H at all for this SKU. Vcher's web page and the 2022 catalogue both give the
GN1410 chassis as **1480 × 830 × 2010 (web) / 1989 (catalogue)**, identical across all six
GN1410 variants. Our stored `1480 / 830 / 2010` therefore stands and matches its four siblings.
Catalogue also gives *Chiller, −2 ~ +8, internal 1364 × 700 × 1396, 1476 L, N.W. 188 / G.W. 203* —
the 188 kg matches the SAP remark exactly.

#### 4.3 ⚠ `DF400 S/S` (IMG/REF/00159) — stored height 1800 is wrong under BOTH Vcher sources
Vcher web says **1870**; the 2022 catalogue says **1850**. Neither is 1800. Its sibling
`DR400 S/S` stores 1870 on the identical chassis. This confirms `sheffield-blueline-research.md`
§4.2 but adds that **1870 is not certain either** — see §4.4.

#### 4.4 ⚠ Vcher's own two publications disagree on the entire ABS range's external size

The 2022 catalogue prints the models as **`DR200 S/S`, `DF200 S/S`, `DR400 S/S`, `DF400 S/S`** —
with the space and the slash, i.e. **character-for-character our `model_number` strings**. That is
the strongest confirmation yet that these codes are Vcher's own. The dimensions it gives, however,
are not the ones on Vcher's website:

| model | catalogue external W×D×H | Vcher web | our record | catalogue temp / volume / N.W. |
|---|---|---|---|---|
| DR200 S/S | **595 × 650 × 830** | 600 × 615 × 870 | 600 / 615 / 870 | Chiller 0 ~ +10 · 113 L · 36 kg |
| DF200 S/S | **595 × 650 × 830** | 600 × 615 × 870 | 600 / 615 / 870 | Freezer −10 ~ −22 · 113 L · 38 kg |
| DR400 S/S | **595 × 650 × 1850** | 600 × 615 × 1870 | 600 / 615 / 1870 | Chiller 0 ~ +10 · 305 L · 74 kg |
| DF400 S/S | **595 × 650 × 1850** | 600 × 615 × 1870 | 600 / 615 / 1870 ← *stored 1800* | Freezer −10 ~ −22 · 321 L · 75 kg |

Canmac/Adexa, an independent UK relabeller, quotes **113 L** and **321 L** — matching the
catalogue's volumes exactly, which suggests the catalogue is the later/authoritative document.
**Unresolved; a supplier question, not a correction.** Note also the temperature bands: the
catalogue's chillers run **0 ~ +10 °C**, not the +2/+8 the copy currently states.

#### 4.5 ⚠ `EWB470G` (IMG/DIS/00120) — SAP is holding the CARTON, as suspected. Confirmed verbatim
Wondereach's own page, read this pass:

> Climate Class SN、N、ST · Temperature 5～20 ℃ · Total Net Capacity 430 L · **204 bottles** ·
> Refrigerant R600a · Voltage 220～240/50, 220～240/60, 110～120/60, 100/50(60) ·
> **Unit Dimensions (W×D×H) 595 × 710 × 1880 mm** · **Pack Dimensions 640 × 760 × 1910 mm**

SAP stores `640 / 1910 / 765`. That is the **pack**, and mis-ordered on top: the pack is
640 × 760 × 1910, so SAP's second and third fields are also transposed. **Our stored
595 / 710 / 1880 is the unit and is correct. Do not move it toward SAP.**

Wondereach's TLS certificate is still broken, but the site now serves fine over plain `http` and
the old `/product/52.html` URL still 404s — reach it at
http://www.wondereach.com/products/Commercial-Products/Wine-Cooler/EWB470G.html

#### 4.6 GN650 / GN1410 / GN1200: catalogue height 1989 vs website height 2010 / 2000
Every upright in the catalogue is **21 mm shorter** than the same model on the website
(GN650 and GN1410: 1989 vs 2010; GN1200: 1989 vs 2000). The catalogue's own line drawings label
1989 as the overall height *including castors*, so this is more likely two build revisions than a
typo. **Flagged, not applied** — our records all carry the website figure, consistently.

#### 4.7 SAP transposes width and depth on 13 of these 15 SKUs
`GN650*` SAP prints `830/740/2010` where Vcher labels *Width 740, Depth 830*; `GN1410*` SAP prints
`830/1480/2010`; `DR/DF*` SAP prints `615/600/…`. In every case **our stored record is right and
SAP's field order is wrong for these rows**, which is the opposite of the dossier's default
assumption that SAP's order is trustworthy. It is trustworthy in general; it is not on this brand.

---

### 5. Shared images — every one is tagged

Of the 15 SKUs, **11 carry at least one file that is byte-identical to another SKU's file.**
No SKU's *primary* (`-1`) image is shared with another SKU. Every shared file carries an explicit
token in its filename and the ledger records the md5.

| md5 | what it is | SKUs sharing it | tag used |
|---|---|---|---|
| `389c38a7` | shelf-support close-up | 8 GN cabinets | `DETAIL-RANGE` |
| `3e56c57b` | door lock + keys close-up | 8 GN cabinets | `DETAIL-RANGE` |
| `e82d351f` | Dixell thermostat + rocker switch close-up | 5 GN cabinets | `DETAIL-RANGE` |
| `ee7d0286` | door handle close-up | 3 GN cabinets | `DETAIL-RANGE` |
| `e6f8f974` | Forcar 1-glass-door photo | GN650TNG + GN650BTG | `REPRESENTATIVE-RANGE` |
| `5df970a1` | Forcar 1-solid-door photo | GN650TN + GN650BT | `REPRESENTATIVE-RANGE` |
| `e0c0ba46` | Forcar 2-solid-door photo | GN1410TN + GN1410BT | `REPRESENTATIVE-RANGE` |
| `6ddfb161` | Adexa 200-series S/S undercounter | DR200 S/S + DF200 S/S | `REPRESENTATIVE-RANGE` |
| `543569d5` | Adexa 400-series S/S upright | DR400 S/S + DF400 S/S | `REPRESENTATIVE-RANGE` |

The four Vcher `DETAIL-RANGE` close-ups are genuinely present on each of those product pages —
they are the manufacturer's range-wide detail set, not a substitute for a product shot.
The three Forcar filenames announce the sharing themselves
(`G-GN650TNG-BTG_…`, `G-GN650TN-BT_…`, `G-GN1410TN-BT_…`); the boundary-assertion trap the earlier
pass documented (a `startswith` match putting the `…TNG` glass-door photo on the `…TN` solid-door
SKU) was avoided with a `(?![A-Z0-9])` guard, and every file was rendered regardless.

Spec-sheet PDFs are also shared by design — one catalogue spread covers a whole series
(GN650 ×5 SKUs, GN1410 ×4, ABS ×4). That is correct: the document itself is series-level.

---

### 6. Resolution ceilings, honestly recorded

| source | ceiling | how established |
|---|---|---|
| vcher.com.cn product galleries | **1200 × 1030** | uniform across all 245 detail pages; the only larger files on the site are the 1920 × 700 page banner and the stock lifestyle PNG |
| Vcher 2022 catalogue PDF | **~600 px** per hero crop | each page is one flattened 2097 × 1433 JPEG; extracted with PyMuPDF `extract_image`, not page rasterisation. Rasterising at 300 dpi produces a 5454 px Lanczos upscale of the same 485 px of real detail — not done |
| forcar.it | **800 × 800** | `_QR.jpg` files are also exactly 800 × 800 and are QR codes; bare `G-<CODE>.jpg` files are 400 × 800 dimension line-drawings. Both rejected by inspection, as documented previously |
| hospitalityequipmentonline.com.au | **1045 × 1100** | OpenCart; the `image/cache/…-500x500.webp` path resolves to `image/catalog/…` for the original, but only as `.webp` — `.jpg`/`.png` 404 |
| canmac.co.uk | **1200 × 1200** | Shopify; `?width=3000` returns the stored 1200 px file, so 1200 is the real original |
| wondereach.com | **500 × 750** | Aliyun OSS: the bare URL *is* the original and only `?x-oss-process=image/resize` variants are smaller. Requesting the bare URL confirms 500 × 750. **Ceiling confirmed, not a fetch failure** |

---

### 7. What could not be reached

1. **`GN1200BTV` above 485 px with its own code on it.** Vcher has no photo of it; Forcar,
   Canmac and KRD do not list the `BTV` suffix; allfoodproject carries only `G-GN1200BT-FC`.
   What is staged: the catalogue hero captioned *"Ventilated Cooling GN1200TNV & GN1200BTV"*
   (485 × 615, code proven, 2 solid doors confirmed) plus Vcher's `GN1200TN` photo at
   1200 × 1030 as `REPRESENTATIVE-RANGE` — right chassis, right door count, wrong variant letter.
2. **`EWB470G` above 500 px.** Ceiling proven at the manufacturer; no distributor listing found
   anywhere. No spec-sheet PDF exists — Wondereach publishes specs as page text only, transcribed
   verbatim in §4.5.
3. **A true datasheet (rather than an EU energy label) for any single model.** The Vcher catalogue
   spread is the closest thing that exists and is what has been staged.
4. **`GN650BTM` has no second source.** Neither Forcar nor any distributor lists the `BTM`
   (2 semi-door) variant; the single Vcher photo is all there is, and it does clearly show the
   two half-doors.
5. **`GN1410BTG`'s two FED photographs carry a "2 YEAR WARRANTY" badge** burnt into the lower
   right. They are genuine photographs of the right product; the badge would need removing before
   publication, or a cleaner source finding.

### 8. Reusable notes for the rest of this effort

- **Follow the generic `download` link on a Chinese manufacturer site even when it looks like a
  dead end.** `vcher.com.cn/down.html` is linked from every product page, is not indexed, contains
  no model name, and holds the entire brand's datasheet.
- **A supplier can publish the same model twice.** Vcher has up to three detail pages per code and
  the newest one (2026-07-28 for the ABS range) carries the photo the older one lacks. Index the
  whole catalogue by code and keep every page, rather than resolving code → one page.
- **Reseller product pages disambiguate models that a manufacturer's gallery cannot.** The
  `EWB470G` vs `EW470G` error was invisible in the file itself and invisible in the URL; it fell
  out of parsing the *category listing*, where each thumbnail sits next to its model name.
- **A supplier's own page title can contradict its own photographs** — Vcher's DR200SS page 121 is
  titled *STAINLESS STEEL* and shows a white cabinet. Rendering caught it; no metadata would have.


---

## Sourcing pass, 3 August 2026 - GN 700-depth counters - 21 SKUs

## SHEFFIELD BLUELINE — GN 700 mm counter range (21 SKUs) — provenance pass

Scope: the GN 700-deep counters, barlines, drawer counters, saladettes and salad counters.
Sibling agents own the upright cabinets and the SNACK 600-deep range.

Ledger: `_sourced-gn700.json` (77 rows: 35 images + 42 spec sheets).
**All 21 SKUs reached. All 21 have a door/drawer-count-verified image. 17 of 21 are
code-proven. Zero unreachable, zero partial.**

---

### 0. The single most valuable find: the manufacturer's own 2022 catalogue

`https://vcher.com.cn/Uploads/2022-03-02/Vcher Catalogue 2022.pdf` — 46 spread pages, **fully
rasterised** (`get_text()` returns an empty string on every page, which is why a text-based
sweep of the site never surfaces it). A sibling agent found it for the uprights; it turns out to
cover **my entire range** on spreads p31|32 through p53|54, and it outclasses everything else:

- **Per-model photographs with the model code printed beside them** — so the code is proven by
  the manufacturer, not inferred from a filename.
- **Dimensioned line drawings** (width, depth, height, drawer pitch, base height).
- **Model spec tables**: internal and external W×D×H, volume, net and gross weight.

Extracted at 300 dpi, the product crops run **5,300–9,300 px** on the long edge — an order of
magnitude past the 800 px web ceiling every reseller enforces. **Nine catalogue crops and 17
catalogue spec-spread PDFs are staged**, and they are the primary image for 9 of my 21 SKUs
including all five drawer counters.

The spec tables also settle several arguments by matching SAP's free-text remarks **exactly**:

| SKU | Catalogue N.W. / G.W. / volume | SAP remark |
|---|---|---|
| GN1100TN | 60 / 68 kg | net 60, gross 68 ✓ |
| GN1100BT | 64 / 72 kg | net 64, gross 72 ✓ |
| GN2100TN | 93 / 108 kg | net 93, gross 108 ✓ |
| U-GN3160TN | 123 / 138 kg, 317 L | net 123, gross 138, 317 L ✓✓✓ |
| SH3000/700 | 121 / 146 kg, 470 L | net 121, gross 146, 470 L ✓✓✓ |
| SH3000/800 | 145 / 173 kg, 576 L | net 145, gross 173, 576 L ✓✓✓ |

**Lesson for the remaining brands: look for a rasterised catalogue PDF before grinding through
reseller sites.** It cost one fetch and beat two hours of relabeller work.

---

### 1. Headline

**The previous pass's biggest factual error is corrected: all three "missing" drawer counters
ARE on Vcher.** `GN2140TN` (detail id 167), `U-GN3160TN` (179) and `U-GN4180TN` (180) are
published with fully labelled dimension tables. The earlier scrape stopped at 204 models across
31 pages; a full sweep returns **245 detail pages / 224 distinct codes**, and 19 of my 21 codes
match exactly. The two that do not are `S902V` (Vcher publishes `S902`, no `V` build) and the
`-1200`/`-1500` width variants, which are not in the manufacturer's standard range.

**Spec sheets: 42 staged, from zero.** The prior pass reported none existed for this brand.
17 are manufacturer catalogue spreads (the good ones), 10 Forcar and 3 TC Bohemia EU energy
labels, 6 Frosta distributor datasheets, plus duplicates filed per SKU.

**Vcher photographs per family, never per model — confirmed and quantified.** Gallery slides
2, 3 and 4 are byte-identical (md5 `e82d351f`, `6f4230b5`, `3f0580c4`) on *every* 700-depth page.
Rendered, they are genuine range-wide detail shots — Dixell panel, worktop edge, magnetic gasket
— so they are staged **once** in `_brand-reference\` as `REPRESENTATIVE-RANGE`, not copied under
18 code-asserting filenames.

**The scraping fact held.** Vcher images are `background-image` on `.gallery-top .swiper-slide`,
never `<img src>`. Parsing page-wide `background-image` is not enough either — it also picks up
the header banner and the "HOT PRODUCTS" footer thumbnails. Only the `gallery-top … gallery-thumbs`
slice is the product gallery.

---

### 2. Explicit answers on the six flagged items

#### 2.1 `GN3140TN` (IMG/REF/00167) — RESOLVED, and our data is already correct
Vcher's own page for `GN3140TN` (https://vcher.com.cn/productdetail/132.html) prints
**Width 1795 · Depth 700 · Height 860**, inner 1230 × 580 × 589, volume 465 L, net 154 kg.

The SAP remark for this SKU reads *"Inner Depth-580 mm. Inner Height-589 mm. Inner Width-1230 mm
… Volume(L)-465 L"* — **character for character Vcher's table.** SAP's W/D/H (700/1795/860) agrees.
Our stored 1795/700/860 agrees. **The `GN1200BTV` contamination is fully cleared; nothing to change.**

#### 2.2 `GN4140TN` (IMG/REF/00182) — 850 vs 860: I could NOT confirm 850 *at the manufacturer*, but 850 is well supported elsewhere
I did not re-derive 860, and I am not proposing any change. Honest state of the evidence:

| Source | GN4140TN / this chassis | Height |
|---|---|---|
| **SAP** | GN4140TN | **850** |
| **Vcher Catalogue 2022** (manufacturer, printed) | GN4140TN 2230×700×860 | 860 |
| **Symbol Kitchen** | GN4140TN 2230×700×850 — and GN2140TN, GN3140TN, GN3160TN, GN4180TN all 850 | **850** |
| **TC Bohemia** (KH- line) | the *entire* 700-deep range: GN2100TN, GN3100TN, GN4100TN, GN2140TN, GN3140TN, GN3160TN, S903TOP | **850** |
| **Forcar** | S902, S903, S903TOP saladettes | **850** |
| **Forcar** | GN2100/3100/4100 counters | 860 |
| **Vcher** (manufacturer) | GN4140TN's own page, and everything else bar `GNH2100TN` | 860 |

**850 is not an error — it is a real, widely published build height for this chassis**, appearing
across three independent relabellers and on whole ranges, not on one stray row. The 10 mm is the
adjustable-feet vs castor difference (Vcher's renders sit on castors; TC Bohemia and Symbol Kitchen
show adjustable feet). **SAP's 850 is defensible. Leave it.**

#### 2.3 `S903` (IMG/REF/00168) — 1340 vs 1365 vs 2400: **1365, decisively**
Three independent confirmations, and SAP convicts itself:

- **Forcar** `G-S903`: external **1365 × 700 × 850**, inner **1295 × 530 × 500**, net **107 kg**.
- **Vcher** `S903` (id 190): **1365 × 700 × 860**, inner **1295 × 595 × 500**.
- **TC Bohemia** `KH-S903TOP`: **1365 × 700 × 850**.

The SAP *remark* for this SKU states *"Inner Width-1295 mm … Inner Height-500 mm … Net Weight-107 Kg"*
— exactly Forcar's and Vcher's figures. **SAP's own free text corroborates 1365 while its W/D/H
field says 2400.** Our stored 1365 is right; the product *name*'s "1340" is wrong; SAP's 2400 is
wrong. This is a clean case of the dossier rule that SAP's dimension VALUES lose to a manufacturer.

#### 2.4 The `1100` tier — **925 mm confirmed, no longer unresolved**
Vcher's labelled tables for `GN1100TN` (id 60) and `GN1100BT` (id 62) both read
**Width 925 · Depth 700 · Height 860**, and `GN1100TN`'s net weight of **60 kg** matches the SAP
remark exactly. SAP stores 925. Our records store 925. **All three agree; nothing to change.**
(The prior pass held this open because Vcher's `SNACK1100*` rows print 860/925 — that is the
sibling agent's range, and it is the `SNACK` rows that are scrambled, not these.)

#### 2.5 `U-GN3160TN` (IMG/REF/00043) — **1795 × 700 × 650, from the manufacturer directly**
Not an inference any more. Vcher publishes the code itself (https://vcher.com.cn/productdetail/179.html):
**1795 × 700 × 650**, inner 1230 × 580 × 355, volume **317 L**, net **123 kg**. The SAP remark reads
*"Volume 317 Litres. - Net Weight 123 Kg"* — an exact match on both. SAP's W/D/H agrees.
**Our stored width 1800 is the lone outlier and should become 1795.** Forcar's `G-UGN3100TN`
(1795 × 700 × 650) and TC Bohemia's `KH-GN3160TN` (1790, rounded) corroborate.

#### 2.6 `U-GN4180TN` (IMG/REF/00099) — clean
Vcher (id 180): **2230 × 700 × 650**, volume 420 L, net 150 kg. Matches SAP and our record on all
three axes. ⚠ SAP's *remark* claims "Volume 317 Litres" and "Net Weight 170 Kg" — the 317 is
copy-pasted from `U-GN3160TN`. Free-text contamination only; the dimensions are fine.

---

### 3. Per-SKU result

`P` = door/drawer count verified against the SKU definition by rendering.

| SKU | Code | Status | Best px | Primary source | Code proven | P | Agrees w/ SAP |
|---|---|---|---|---|---|---|---|
| IMG/REF/00034 | GN1100TN | sourced | **7444×6948** | Vcher catalogue | yes | **1 door** ✓ | yes |
| IMG/REF/00035 | GN1100BT | sourced | **7444×6948** | Vcher catalogue | yes | **1 door** ✓ | yes |
| IMG/REF/00036 | GN2100TN | sourced | 800×800 | Forcar | yes | **2 doors** ✓ | yes |
| IMG/REF/00037 | GN3100TN | sourced | 800×800 | Forcar | yes | **3 doors** ✓ | yes |
| IMG/REF/00038 | SH3000/700 | sourced | **9330×6016** | Vcher catalogue + web + Mariot | yes | 3 doors + salad well ✓ | yes |
| IMG/REF/00039 | SH3000/800 | sourced | **9330×6016** | Vcher catalogue + web | yes | 3 doors + salad well ✓ | yes |
| IMG/REF/00040 | S902V | sourced | 1200×1030 | Forcar + Vcher | no (`S902`) | **2 doors** ✓ | yes |
| IMG/REF/00041 | GN4100TNG | sourced | 800×800 | Forcar | yes | **4 glass doors** ✓ | yes |
| IMG/REF/00043 | U-GN3160TN | sourced | **5556×2937** | Vcher catalogue + Mariot | yes | **6 drawers** ✓ | width 1800→1795 |
| IMG/REF/00099 | U-GN4180TN | sourced | **5347×3223** | Vcher catalogue + Mariot | yes | **8 drawers** ✓ | yes |
| IMG/REF/00102 | GN4100TN | sourced | 1200×1030 | Forcar + Vcher | yes | **4 doors** ✓ | yes |
| IMG/REF/00103 | GN2100BT-1200 | sourced | 1164×808 | Mariot + Forcar | no | 2 doors ✓ | width n/a |
| IMG/REF/00104 | GN2100BT-1500 | sourced | 1164×808 | Mariot | no | 2 doors ✓ | width n/a |
| IMG/REF/00105 | GN2100TNG-1200 | sourced | 800×800 | Forcar | no | 2 glass doors ✓ | width n/a |
| IMG/REF/00106 | GN2100TNG-1500 | sourced | 800×800 | Forcar | no | 2 glass doors ✓ | width n/a |
| IMG/REF/00107 | GN3100TNG | sourced | 800×800 | Forcar | yes | **3 glass doors** ✓ | yes |
| IMG/REF/00144 | GN2100TNG | sourced | 847×847 | Forcar + Mariot | yes | **2 glass doors** ✓ | ⚠ see §5 |
| IMG/REF/00166 | GN2140TN | sourced | **5348×3366** | Vcher catalogue + Mariot + Symbol | yes | **4 drawers** ✓ | yes |
| IMG/REF/00167 | GN3140TN | sourced | **9228×4226** | Vcher catalogue + Symbol | yes | **4 drawers + 1 door** ✓ | yes |
| IMG/REF/00168 | S903 | sourced | 800×800 | Forcar | yes | **3 doors** ✓ | ⚠ width 2400 wrong |
| IMG/REF/00182 | GN4140TN | sourced | **5767×3940** | Vcher catalogue + Symbol | yes | **4 drawers + 2 doors** ✓ | ⚠ height, §2.2 |

**`GN3140TN`, `GN4140TN`, `U-GN3160TN`, `U-GN4180TN` and `GN2140TN` now have a correct
drawer-count image for the first time** — and from the manufacturer, with the code in frame.
The prior pass staged door units against all of them and flagged the mismatch in the filename;
those are superseded. Each of the five is corroborated by a second independent source
(Mariot or Symbol Kitchen) that arrives at the same configuration.

#### The four not code-proven
`S902V` and the four `-1200`/`-1500` width variants. In every case the *code* is the problem,
not the image: no manufacturer or relabeller publishes an `S902V`, a 1200 mm or a 1500 mm build.
The images are the correct chassis and correct door count, named `CODEMISMATCH` or `NEARMATCH`
so the gap is visible in the filename.

`GN1100BT` was a partial earlier in this pass and is no longer: the catalogue prints **one photo
badged "GN1100TN & GN1100BT"**, so the manufacturer itself certifies a single image for both
builds. The interim Mariot sibling file was deleted once the code-proven one landed.

---

### 4. Shared images — 8 of my 21 SKUs share a file, all tagged

| md5 shared by | Files | Tag correct? |
|---|---|---|
| 00034 + 00035 | `GN1100TN-mariot-1` / `GN1100BT-…-REPRESENTATIVE-SIBLING-GN1100TN` | ✅ |
| 00036 + 00103 | `GN2100TN-forcar-1` / `GN2100BT-1200-forcar-NEARMATCH-G-GN2100TN-BT-2` | ✅ |
| 00103 + 00104 | both `…-mariot-NEARMATCH-GN2100BT-1` | ✅ |
| 00105 + 00106 + 00144 | two `…-NEARMATCH-G-GN2100TNG-1`, one `GN2100TNG-forcar-1` | ✅ (00144 *is* GN2100TNG) |

No file sits under a bare code-asserting name that it cannot support. Two byte-identical
"second gallery views" (Forcar uploads the same render twice under `-1` and `-2` URLs on
`G-GN3100TNG` and `G-S902`) were **deleted** rather than staged as fake extra coverage.

---

### 5. Reported, not applied

1. **`GN2100TNG` (IMG/REF/00144)** — we store **1360** wide, SAP stores **1200**. Vcher's
   `GN2100TNG` (id 69) is **1360**; every Vcher `2100`-series unit is 1360. SAP's 1200 looks like
   contamination from the sibling `GN2100TNG-1200` (IMG/REF/00105). **Our 1360 is the better figure.**
2. **`U-GN3160TN` width 1800 → 1795** — the only dimension change my range actually warrants (§2.5).
3. **`S902V`** — no `V` build exists at Vcher or Forcar; both publish plain `S902` at 1045 × 700.
   The `V` is ours. `model_number` untouched.
4. **The `-1200` / `-1500` widths remain a supplier question.** Confirmed again: no manufacturer
   or relabeller publishes anything but 1360 on the 2100 chassis.
5. **`SH3000/700` height** — the Frosta datasheet prints 860; Vcher, SAP and our record all say
   **1085**. 860 is the plain worktop height; 1085 includes the salad well. Our 1085 is right.

---

### 6. Provenance and quality notes

- **Every image was rendered before acceptance.** No synthetic/AI-generated imagery was found in
  this range — `_ai-generated\` is empty. Forcar's are studio photographs with legible Forcar
  branding on the control panel; Vcher's, Mariot's and Symbol Kitchen's are CAD product renders
  with physically coherent hardware (GN pan runners, gasket profiles, castor forks).
- **A code-keyed filename is still not provenance.** Mariot's `WORK-TOP-CHILLER-UNGN3160TN.png`
  is filed under the 6-drawer code but renders as a **3-door** low boy. Kept only as
  `…-CODEMISMATCH-DOORS-NOT-DRAWERS.png`. Its `Bar-Cooler-GN1100TN-W.png` is a glass-door back-bar
  cooler, a different product entirely — rejected outright.
- **Symbol Kitchen attribution is mine, not theirs.** They serve one 12-image gallery on every
  model page in the range and never bind image to model. I mapped each render by counting
  sections, doors and drawers against the SKU definition; that is *stronger* than the vendor's
  own filing, but `code_proven` is recorded as `false` because the URL carries no code.
- **Resolution ceilings, measured:** the **Vcher 2022 catalogue PDF is the ceiling-breaker** —
  300 dpi crops give 5,300–9,300 px on the long edge, past every web source by an order of
  magnitude, and it can be re-extracted at any dpi. Web ceilings: Forcar **800×800** (hard cap;
  the bare `G-<CODE>.jpg` files
  are 400×800 dimension line-drawings, not photographs, and `_QR.jpg` files are QR squares at
  exactly 800×800 — both reject by filename). Symbol Kitchen **800×800**. Mariot **847–1500**.
  Vcher **1200×1030**, except two genuine outliers: `SH3000/700` at **3872×2592** and the
  `GN2100TN`/`GN2100TNG`/`GN2140TN` slide at only **340×380** (rejected, under floor).
  Al Assri 669×765 — under the floor on the short edge, so used for its PDFs only.
- **Forcar's PDFs are EU energy labels, not datasheets** — model code, energy class, annual kWh,
  no dimensions. Same for TC Bohemia's. The **Frosta** sheets from Al Assri are the only ones
  carrying full W/D/H, and they are re-typed rather than manufacturer originals (see §5.5).
  All three kinds are staged with `-spec`; treat them accordingly.
- **Watermarks:** every Mariot file carries a large semi-transparent "MARIOT" watermark. They are
  the only correct images for `GN1100TN`, `U-GN3160TN` and `U-GN4180TN`, so they are staged, but
  they are provenance evidence rather than shelf-ready product photography.

### 7. Sources

https://vcher.com.cn/Uploads/2022-03-02/Vcher%20Catalogue%202022.pdf
https://vcher.com.cn/productdetail/132.html
https://vcher.com.cn/productdetail/179.html
https://vcher.com.cn/productdetail/180.html
https://vcher.com.cn/productdetail/167.html
https://vcher.com.cn/productdetail/134.html
https://vcher.com.cn/productdetail/190.html
https://vcher.com.cn/productdetail/60.html
https://vcher.com.cn/productdetail/109.html
https://forcar.it/prodotto/saladette-refrigerate-per-insalate-gn1-1-statiche-g-s903/
https://forcar.it/prodotto/saladette-refrigerate-per-insalate-gn1-1-statiche-g-s902/
https://forcar.it/prodotto/tavoli-refrigerati-gastronomia-gn1-1-ventilati-g-gn2100tn/
https://forcar.it/prodotto/tavoli-refrigerati-gastronomia-gn1-1-ventilati-g-ugn3100tn/
https://forcar.it/wp-json/wp/v2/media?per_page=100&search=G-GN3100TN
https://mariotstore.com/model/gn2140tn/
https://mariotstore.com/wp-json/wp/v2/media?per_page=100&search=GN3160
https://www.symbolkitchen.com/en/ginfo/index/id/300.html
https://www.symbolkitchen.com/en/ginfo/index/id/304.html
https://www.symbolkitchen.com/en/ginfo/index/id/296.html
https://tcbohemia.com/en/cooling-technology/cooled-inox-worktables/cooled-worktables_/kh-gn3140-tn-hc-refrigerated-worktable-with-1-door-4-drawers/
https://tcbohemia.com/en/cooling-technology/cooled-inox-worktables/cooled-worktables_/kh-gn2140-tn-refrigerated-worktable-with-4-drawers/
https://tcbohemia.com/en/cooling-technology/cooled-inox-worktables/cooled-worktables_/kh-s903top-refrigerated-worktable-with-3-doors/
https://alassrikitchenstore.com/wp-content/uploads/2026/07/Frosta_GN2140TN_Data_Sheet.pdf
https://steelkitchen.net/product/low-boy-chiller-4-drawer-gn2140tn-650h/


---

## Sourcing pass, 3 August 2026 - SNACK 600-depth range - 11 SKUs

## SHEFFIELD BLUELINE - SNACK 600-depth counter range: sourcing findings

Scope of this pass: the **11 SNACK 600-mm-depth counter SKUs** only
(`IMG/REF/00126 · 00127 · 00128 · 00155 · 00160 · 00161 · 00215 · 00217 · 00218 · 00219 · 00220`).
The upright cabinets and the GN 700-depth counters in this folder belong to sibling agents.
The 5 BLUELINE SKUs are covered in `blueline\_FINDINGS-blueline.md`.

Ledger: `_sourced-snack.json` (one row per staged file).
Range-level assets that belong to no single SKU: `_brand-reference\RANGE-SNACK600__*`.

---

### 1. The single biggest find: Vcher publishes a full printed catalogue, and nobody had opened it

`https://vcher.com.cn/down.html` is a plain downloads page linked from the *"download"* button on
every product detail page. It carries three PDFs. The one that matters is:

`https://vcher.com.cn/Uploads/2022-03-02/Vcher%20Catalogue%202022.pdf` - 46 pages, 7.8 MB,
"European style product album".

Every page is a single flattened 2097 x 1433 JPEG (no text layer - a text search for `SNACK3100TN`
returns nothing, which is almost certainly why earlier passes concluded there was no catalogue).
Extract the page images with PyMuPDF `extract_image()` on the one XObject per page.

Pages **43|44 (PDF p25)**, **45|46 (p26)** and **47|48 (p27)** carry the whole SNACK 600 range with
per-model labelled renders **and** a manufacturer spec table with an explicit
`Dimension External W x D x H (mm)` column. Verbatim:

| Model | Class | Temp | Internal W x D x H | **External W x D x H** | Volume | N.W. | G.W. |
|---|---|---|---|---|---|---|---|
| SNACK1100TN | Chiller | -2 ~ +8 | 365x480x589 | **925 x 600 x 860** | 103 L | 48 | 56 |
| SNACK1100BT | Freezer | -10 ~ -20 | 365x480x589 | **925 x 600 x 860** | 103 L | 52 | 60 |
| SNACK2100TN | Chiller | -2 ~ +8 | 795x480x589 | **1360 x 600 x 860** | 260 L | 81 | 96 |
| SNACK2100BT | Freezer | -10 ~ -20 | 795x480x589 | **1360 x 600 x 860** | 260 L | 86 | 101 |
| SNACK3100TN | Chiller | -2 ~ +8 | 1230x480x589 | **1795 x 600 x 860** | 386 L | 102 | 119 |
| SNACK3100BT | Freezer | -10 ~ -20 | 1230x480x589 | **1795 x 600 x 860** | 386 L | 107 | 124 |
| SNACK4100TN | Chiller | -2 ~ +8 | 1663x480x589 | **2230 x 600 x 860** | 511 L | 126 | 146 |
| SNACK2100TNG | Chiller | +2 ~ +8 | 795x480x589 | **1360 x 600 x 860** | 260 L | 95 | 110 |
| SNACK3100TNG | Chiller | +2 ~ +8 | 1230x480x589 | **1795 x 600 x 860** | 386 L | 116 | 133 |
| SNACK4100TNG | Chiller | +2 ~ +8 | 1663x480x589 | **2230 x 600 x 860** | 511 L | 130 | 150 |

The relevant page is staged as a one-page PDF per SKU:
`<SKU>__<CODE>-vcher-catalogue2022-spec.pdf`. That is the first genuine manufacturer spec document
this brand has had.

### 2. RESOLVED: the "Vcher mislabels every SNACK...TN row" fault is confined to the website's card block

`sheffield-blueline-research.md` 2.1 recorded that Vcher prints `Width 860` on every `SNACK...TN`
row while the height field holds the real width, and left the `1100` tier unresolved because the
`BT`-sibling test could not arbitrate it.

Confirmed and now bounded. On `https://vcher.com.cn/productdetail/136.html` (SNACK3100TN) the
**summary block** at the top prints *Depth 600 / Height 1795 / Width 860* - wrong - while the
**"Technical specification" table further down the same page** prints *Depth 600 / Height 860 /
Width 1795* - correct. The printed 2022 catalogue agrees with the table. So:

- The defect is a field-mapping bug in the CMS template that renders the summary/card block, not
  in Vcher's data. It affects the category cards too, which is what earlier scrapes read.
- **Vcher's technical-specification table and its printed catalogue are safe to use.** Its category
  cards and detail summary block are not.
- Every one of our 11 stored widths/depths/heights is confirmed correct against the catalogue,
  except `SNACK1100BT` (section 4).

### 3. The `1100` tier is settled: 925 x 600 x 860

Both `SNACK1100TN` **and** `SNACK1100BT` print **925 x 600 x 860** in the catalogue table, on one
chassis (identical internal 365x480x589 and 103 L; only the weight differs). This closes the
question left open in `sheffield-blueline-research.md` 2.1 and 9 ("the 1100 tier - deliberately NOT
applied"). Our `SNACK1100TN` (IMG/REF/00215) stores 925/600/860 and is right.

### 4. Contradiction: `IMG/REF/00219` SNACK1100BT stores 900, manufacturer says 925

SAP and our record both hold **900** x 600 x 860. Vcher's catalogue holds **925** x 600 x 860, on the
same chassis as its TN sibling which we already store as 925. This corroborates
`sheffield-blueline-research.md` 4.3 with an independent, labelled, printed source.
**Reported, not applied** - dimensions are commercial figures.

### 5. Contradiction: Adexa prints 850 mm height on two glass-door models

Adexa (Stalwart) sells this exact range in the UK as `THSNACK...`:

- `https://www.adexashop.com/professional-refrigerated-counter-2-glass-doors-depth-600mm-adexa-thsnack2100tng/`
  1360 x 600 x **860**, 260 litres, 95 kg - agrees with Vcher to the kilogram.
- `https://www.adexashop.com/commercial-refrigerated-counter-3-glass-doors-depth-600mm-adexa-thsnack3100tng/`
  1795 x 600 x **850**, 339 litres, 106 kg - Vcher says 860 / 386 L / 116 kg.
- `https://www.adexashop.com/commercial-refrigerated-counter-4-glass-doors-depth-600mm-adexa-thsnack4100tng/`
  2230 x 600 x **850**, 449 litres, 131 kg - Vcher says 860 / 511 L / 130 kg.

A 10 mm height difference on two of three sizes, with the 2-door agreeing exactly. This is the same
850-vs-860 pattern already noted for `GN4140TN` in `sheffield-blueline-research.md` 4.4, and Vcher
does genuinely build an 850 mm variant (`GNH2100TN`). Most likely Adexa quotes the height without
feet/castors, or a second build exists. **Not applied.** Our stored 860 matches the manufacturer.

### 6. `SNACK2100BT-150` (IMG/REF/00217) - truncation confirmed, RECOMMENDATION ONLY

- Our `model_number`: `SNACK2100BT-150`
- Our product `name`: "2 Door Counter Freezer 1500X600X860 SNACK2100BT-**1500**"
- SAP description: "2 DOOR COUNTER FREEZER 1500X600X860 SNACK2100BT-**1500**"
- SAP W/D/H: 1500 / 600 / 860

Three independent fields in two systems say **1500**; only `model_number` says `150`. It is a
dropped trailing digit, same bug class as the RATIONAL truncations. `model_number` is the unique ID,
so this is **a recommendation to the business, not a change** - and note that the correct code
`SNACK2100BT-1500` does not exist at Vcher either (section 7), so fixing the digit does not make
it a catalogue code.

### 7. The `-1200` / `-1500` widths are still unfindable anywhere

`SNACK2100BT-1200`, `SNACK2100BT-150(0)` and `SNACK2100TNG-1500` assert 1200 and 1500 mm widths.
Checked against: Vcher's website (204 models across all 6 categories), Vcher's printed 2022
catalogue, Forcar, Forcold, Hamoki (which resells this exact range under W-2210xx codes), Adexa,
Cater Focus, Blueheat, Ace Cater, Canmac, Empire Supplies. **Every 2100-series unit everywhere is
1360 mm.** No 1200 or 1500 mm SNACK counter exists in any published range.

This is not a data error we can resolve by research - it is a supplier question, unchanged from
`sheffield-blueline-research.md` 4.5. Either Sheffield orders custom widths from Vcher, or the
suffix means something other than width. Their images are staged `NEARMATCH` against the standard
1360 mm unit, which is honest: the door count and the build are right, the width is not.

### 8. Image sources and their proven ceilings

| Source | What it gives | Ceiling | Per model? |
|---|---|---|---|
| Vcher category card (`/Uploads/<date>/<hash>.jpg`) | correct door count and door type for **every** model | **340 x 380 - proven ceiling** | yes |
| Vcher detail gallery (CSS `background-image` on `.gallery-top .swiper-slide`) | 6 files for the whole SNACK 600 line | 1200 x 1030 | **no** |
| Vcher 2022 catalogue page crop | labelled per-model render | 640 x 680 max (SNACK1100) | yes |
| Forcar `G-<CODE>` | 2 studio renders per code | 800 x 800 | yes, TN counters only |
| Hamoki `W-2210xx` | render + real warehouse photos | 1080-1156 | per door count |
| Adexa `THSNACK...` | render + real customer photos | **1500 x 1500** | yes, glass-door models |

Notes on each:

- **The CSS `background-image` warning in the brief is correct and applies to both the category
  cards and the detail gallery.** No `<img src>` anywhere; parse inline `style` attributes.
- The 340 x 380 card files are **the stored originals**, not thumbnails - there is no larger variant
  behind them (no `-800x800`-style suffix to strip, and the same file is referenced everywhere).
  340 x 380 is Vcher's real ceiling for per-model imagery.
- **Forcar only lists the TN counters** (`G-SNACK2100TN`, `2200TN`, `3100TN`, `3200TN`, `4100TN`,
  `4200TN`). No 1100, no BT counters, no TNG counters. Its `G-<CODE>.pdf` files are **EU energy
  labels, not datasheets** - staged as `-forcar-energylabel.pdf`, not `-spec`. (The "11 Forcar
  spec-sheet PDFs" in `sheffield-blueline-research.md` 8.1 are these same energy labels.)
- **Adexa is a new and better route than anything in the prior research** and is the only source
  above 1200 px. `RG21VGLASS` / `RG31VGLASS` / `RG41VGLASS` are its file stems for the 2/3/4
  glass-door 600-depth counters; `THSNACK4100TNG-cust00N` are genuine customer photographs.
  The `-1500x1500-N` filename suffix is **not** strippable - the bare stem 404s.
- adexashop.com returns **HTTP 522** under rapid requests; back off and retry, it recovers.

### 9. Door count and door type: verified by rendering, 11/11

Every image was opened and looked at. Vcher's card renders make this easy because they are
genuinely per-model: `SNACK1100TN/BT` = 1 solid door, `SNACK2100BT` = 2 solid,
`SNACK3100TN/BT` = 3 solid, `SNACK2100TNG` = 2 glass, `SNACK3100TNG` = 3 glass,
`SNACK4100TNG` = 4 glass. Adexa's and Forcar's per-code renders agree. **No door-count or
door-type defect was found in anything staged.**

**No AI-generated imagery was detected.** Everything is either a studio 3D render (Vcher, Forcar,
Adexa) or a real photograph (Hamoki's factory/warehouse shots, Adexa's customer photos - both with
the pallets, floor grime and phone-camera geometry that synthetic images do not produce).
No `_ai-generated\` folder was needed.

### 10. Shared-image audit - md5 AND perceptual hash

79 staged image files, **58 distinct by md5**. Byte-identical groups are all expected: the same
image legitimately serving several of our own SKUs (the three SNACK2100BT SKUs; the two
SNACK2100TNG SKUs; the two SNACK1100 catalogue crops). Every one carries `REPRESENTATIVE-RANGE`,
`NEARMATCH` or `UNDERFLOOR` in its filename.

**md5 alone was not enough.** A 16 x 16 average-hash comparison caught a group md5 missed:

> Hamoki serves **the same three warehouse photographs, re-encoded**, on its `SNACK3100TN`
> (W-221023) and `SNACK3100BT` (W-221028) listings. Different md5, perceptual-hash distance **0**.

Those six files were initially staged under plain `-hamoki-N` names asserting a per-model
photograph. They have been **renamed to `-hamoki-REPRESENTATIVE-RANGE-N`** and their ledger rows set
`code_proven: false`. Consequence: **`IMG/REF/00128` SNACK3100BT has no image anywhere that
distinguishes it from its TN sibling.** The 3-door 600-depth chassis is proven at 1156 px; the
freezer build is not. (In fairness the two units are visually identical apart from the rating
plate, so this is a limit of the product, not only of the sourcing.)

Recommendation for later passes on this effort: **run a perceptual hash, not just md5.** A vendor
that re-exports the same JPEG per listing defeats byte comparison completely.

### 11. Per-SKU result

| SKU | Code | Result | Best px | Code proven | Doors verified | Agrees with SAP |
|---|---|---|---|---|---|---|
| IMG/REF/00126 | SNACK3100TN | sourced | 800 x 800 (Forcar) | yes | 3 solid | yes |
| IMG/REF/00127 | SNACK2100BT | sourced | 1156 x 1156 (Hamoki) | yes | 2 solid | yes |
| IMG/REF/00128 | SNACK3100BT | partial | 1156 x 1156 (Hamoki, shared with TN) | no | 3 solid | yes |
| IMG/REF/00155 | SNACK4100TNG | sourced | 1500 x 1500 (Adexa) | yes | 4 glass | yes (Adexa h=850) |
| IMG/REF/00160 | SNACK2100TNG | sourced | 1500 x 1500 (Adexa) | yes | 2 glass | yes |
| IMG/REF/00161 | SNACK3100TNG | sourced | 1500 x 1500 (Adexa) | yes | 3 glass | yes (Adexa h=850) |
| IMG/REF/00215 | SNACK1100TN | partial - under floor | 640 x 680 (catalogue crop) | yes | 1 solid | yes |
| IMG/REF/00217 | SNACK2100BT-150 | partial - NEARMATCH only | 1156 x 1156 | no (1360 unit) | 2 solid | yes |
| IMG/REF/00218 | SNACK2100BT-1200 | partial - NEARMATCH only | 1156 x 1156 | no (1360 unit) | 2 solid | yes |
| IMG/REF/00219 | SNACK1100BT | partial - under floor | 640 x 680 (catalogue crop) | yes | 1 solid | **no - 900 vs 925** |
| IMG/REF/00220 | SNACK2100TNG-1500 | partial - NEARMATCH only | 1500 x 1500 | no (1360 unit) | 2 glass | yes |

Spec documents: **11/11 SKUs now have a manufacturer spec PDF** (the relevant Vcher 2022 catalogue
page). Three also carry a Forcar EU energy label. Zero existed before this pass.

### 12. What I could not reach

- **No image at or above the 800 px floor for `SNACK1100TN` or `SNACK1100BT`.** The 1-door
  600-depth counter is simply not carried by any of the relabellers - not Forcar, Forcold, Hamoki,
  Adexa, Cater Focus, Blueheat, Ace Cater, Canmac or Empire Supplies, all of which start their SNACK
  counter range at the 2-door 2100. Best available is the 640 x 680 crop from the catalogue page,
  which at least carries the model code in the caption beneath it.
- **No true datasheet from any reseller** - only the catalogue pages and EU energy labels. Cooleq
  publishes a genuine user guide covering `GN1100BT ... SNACK1100BT`
  (`https://manualmachine.com/cooleq/gn1100bt/18887853-user-guide/`) but it is paywalled and Cooleq
  has no reachable product site.
- **No source at all confirms a 1200 or 1500 mm wide SNACK counter** (section 7).
- WebSearch and the DuckDuckGo HTML endpoint both rate-limited part way through; the productive
  routes were all direct: `sitemap`-free WordPress media APIs (`forcar.it`, `forcold.it`,
  `adexashop.com`) and Shopify `/products.json` (`hamoki.co.uk`, `caterfocus.com`, `canmac.co.uk`).

### 13. BLUELINE vs SHEFFIELD BLUELINE - no brand change proposed

Nothing found in this pass separates the two labels. The `SNACK2100TN-1200` / `-1500` /
`SNACK4100TN` SKUs filed under **BLUELINE** and the `SNACK2100BT-1200` / `SNACK3100TN` SKUs filed
under **SHEFFIELD BLUELINE** are the same Vcher product line, from the same catalogue pages, with
the same suffix grammar and the same width tiers. `IMG/DIS/00069` and `IMG/DIS/00137` sit in the
BLUELINE dossier but SAP stamps them **SHEFFIELD BLUELINE**, and SAP stamps the three
BLUELINE SNACK SKUs **BLUELINE** - so the split is not even consistent inside SAP.

The one distinction worth recording is **numeric, not brand-related**: every SKU carrying a
non-standard width suffix (`-1200`, `-1500`) is on the BLUELINE side or is one of the three SHEFFIELD
BLUELINE oddities, while every SKU matching a catalogue width exactly is a clean match. That looks
like a purchasing-era artefact, not two suppliers. **Recommend the merge stays on the table; this
pass found no evidence against it.**


---

## Sourcing pass, 3 August 2026 - BLUELINE - 5 SKUs

## BLUELINE - all 5 SKUs: sourcing findings

`IMG/DIS/00069` VRX1500/80 FG · `IMG/DIS/00137` VRX1800/380 FG ·
`IMG/REF/00194` SNACK2100TN-1200 · `IMG/REF/00195` SNACK2100TN-1500 · `IMG/REF/00196` SNACK4100TN

Ledger: `_sourced-blueline.json`. Range-level assets: `_brand-reference\RANGE-VRX380__*` and
`RANGE-VRX__vcher-catalogue2022-p67-68-range-table.jpg`.

Shared background - the Vcher 2022 printed catalogue, the CSS-background-image trap, the reseller
routes and the perceptual-duplicate audit - is written up once in
`sheffield-blueline\_FINDINGS-snack.md`. This file covers what is specific to these five.

---

### 1. The two VRX pizza displays - explicit answers

Three independent manufacturer-tier sources were reached. All three agree on width and depth and
disagree only on how the glass guard is counted into the height.

#### `IMG/DIS/00069` - our `VRX1500/80 FG`, really **VRX1500/380FG**

| Source | External W x D x H | Wells | Weight |
|---|---|---|---|
| Vcher 2022 catalogue, p67 table (explicit `W x D x H` header) | **1500 x 395 x 440** | 5 x GN1/3 + 1 x GN1/2 | 49 kg |
| Vcher detail page 8 tech-spec table | 1500 x 395 x 440 (internal 1145 x 305 x 155) | GN1/3 x5 + GN1/2 x1 | 49 kg |
| Forcold `G-VRX1500-380` | 1500 x 395 x **230 / 435 (h) without / with glass** | 5 x GN1/3 + 1 x GN1/2 | - |
| Hamoki W-221046 spec table | 1500 x 395 x **455** | 51 L, 5 x GN1/3 + 1 x GN1/2 | 45 kg |
| **our record** | **1500 / 395 / 440** | | |
| SAP | **395 / 1500 / 239** | | |

**Our stored 1500 / 395 / 440 is correct.** SAP is wrong twice over:

1. Its width and depth are **transposed** - it holds 395 as width and 1500 as depth.
2. Its **239 is the height of the base unit with the glass guard removed**, not the product height.
   Forcold states this outright: "230 / 435 (h) mm without / with glass". SAP has captured the
   without-glass figure, off by 9 mm from Forcold's 230.

So this is not a SAP typo, it is SAP measuring a different thing. Anyone reconciling this range
should expect a ~205 mm gap between the two conventions.

The 440-vs-435-vs-455 spread across Vcher / Forcold / Hamoki is glass-height rounding, not a real
disagreement. **Vcher's 440 is what we already store; leave it.**

#### `IMG/DIS/00137` - `VRX1800/380 FG`

| Source | External W x D x H | Wells | Weight |
|---|---|---|---|
| Vcher 2022 catalogue, p67 table | **1800 x 395 x 440** | 8 x GN1/3 | 55 kg |
| Vcher detail page 103 tech-spec table | 1800 x 395 x 440 (internal 1445 x 305 x 155) | GN1/3 x8 | 55 kg |
| Forcold `G-VRX1800-380` | 1800 x 395 x **230 / 435 (h) without / with glass**, internal 1450 x 305 x 150, R600a 42 g, 145 W | 8 x GN1/3 | - |
| Hamoki W-221048 spec table | 1800 x 395 x **455** | 65 L, 8 x GN1/3, 150 W | 47 kg |
| **our record** | **1800 / 395 / 440** | | |
| SAP | **740 / 1230 / 1360** | | |

**Our stored 1800 / 395 / 440 is correct. SAP's 740 / 1230 / 1360 is another product's row** - the
brief's suspicion is confirmed. It is not a transposition, not a units problem and not a
with/without-glass figure: no VRX in the manufacturer's 16-model table is anywhere near it, and a
1360 mm tall countertop pizza display does not exist. 740 x 1230 x 1360 is upright-cabinet
geometry. **Do not apply. Flag the SAP row for correction.**

Corroboration on the SAP remark for `00069`: it says *"GN Pans 5 x GN1/4"*. Every source says
**5 x GN1/3 + 1 x GN1/2**, and the Forcold photograph shows six wells with the rightmost one wider
than the other five. SAP's `1/4` is wrong; the well count is 6, not 5.

#### Pan count is the reliable visual discriminator for this family

`VRX<width>/380` well counts, from the catalogue's own pan-layout diagram (p67) and confirmed by
rendering: 1200 = 4 · 1400 = 6 · **1500 = 6 (5 x 1/3 + 1 x 1/2)** · 1600 = 7 · **1800 = 8** ·
2000 = 9. The Forcold photographs of `G-VRX1500-380` and `G-VRX1800-380` show exactly 6 and 8 wells
respectively, so both are model-verified, not family-verified.

⚠ Vcher's own detail-page gallery serves **one 1200 x 1030 render for the entire VRX range** and it
shows 8 wells - i.e. it is a VRX1800-shaped render attached to VRX1500 as well. Staged under
`00137` only, tagged `REPRESENTATIVE-RANGE`. It was **not** staged against `00069`, where it would
have asserted the wrong well count.

### 2. `IMG/DIS/00069`'s model_number is a typo - RECOMMENDATION ONLY

`model_number` reads `VRX1500/80 FG`. Our own product `name` reads "Refrigerated Pizza Display
VRX1500/**380** FG" and SAP's description reads "REFRIGERATED PIZZA DISPLAY VRX1500/**380** FG".
The manufacturer publishes `VRX1500/380FG`; there is no `/80` series - the two series are `/330`
(335 mm deep) and `/380` (395 mm deep), and our stored depth of 395 puts it unambiguously in `/380`.
A dropped `3`.

`model_number` is the unique ID, so **this is reported, not changed.** All files for this SKU carry
the `CODEMISMATCH-VRX1500-380FG` token so the discrepancy travels with the assets.

### 3. The three SNACK counters

- **`IMG/REF/00196` SNACK4100TN** is a clean catalogue match: Vcher's 2022 catalogue p45 gives
  2230 x 600 x 860, 511 L, 126 kg. SAP's `600 / 2230 / 860` carries the same three numbers in a
  depth-first order. **This is the SKU that `sheffield-blueline-research.md` 2.1 used to argue that
  our data was right and Vcher's page was wrong - that conclusion is now confirmed from the printed
  catalogue, and the cause is located** (a CMS bug in the website's summary/card block only; see
  `_FINDINGS-snack.md` section 2). Sourced from Forcar `G-SNACK4100TN` at 800 x 800 x2 plus three
  Hamoki 1080 renders including an all-doors-open interior; 4 solid doors verified in every frame.

- **`IMG/REF/00194` SNACK2100TN-1200** and **`IMG/REF/00195` SNACK2100TN-1500** assert 1200 mm and
  1500 mm widths that **do not exist in any published range anywhere** - Vcher's site and printed
  catalogue, Forcar, Forcold, Hamoki, Adexa, Cater Focus, Blueheat, Ace Cater, Canmac and Empire
  Supplies all list exactly one 2100-series counter and it is 1360 mm. Their images are therefore
  staged `NEARMATCH` against the standard `SNACK2100TN`: right door count, right chassis, right
  600 mm depth, wrong width. This is a supplier question, not a research gap.

### 4. Per-SKU result

| SKU | Code | Result | Best px | Code proven | Doors / wells verified | Agrees with SAP |
|---|---|---|---|---|---|---|
| IMG/DIS/00069 | VRX1500/80 FG | sourced | 1125 x 750 (Forcold) | yes, as `VRX1500/380FG` | 6 wells (5x1/3 + 1x1/2) | **no** - W/D transposed, H is without-glass |
| IMG/DIS/00137 | VRX1800/380 FG | sourced | 1125 x 750 (Forcold) | yes | 8 wells (8x GN1/3) | **no** - SAP row is another product |
| IMG/REF/00194 | SNACK2100TN-1200 | partial - NEARMATCH only | 800 x 800 (Forcar) | no (1360 unit) | 2 solid doors | yes (values), width unfindable |
| IMG/REF/00195 | SNACK2100TN-1500 | partial - NEARMATCH only | 800 x 800 (Forcar) | no (1360 unit) | 2 solid doors | yes (values), width unfindable |
| IMG/REF/00196 | SNACK4100TN | sourced | 1080 x 1080 (Hamoki) | yes | 4 solid doors | yes |

Spec documents: **5/5 SKUs now have a manufacturer spec PDF** (the relevant Vcher 2022 catalogue
page). The two VRX SKUs additionally carry Hamoki's published `VRX/380` range spec table as an
image, and `00194`/`00195` carry a Forcar EU energy label. Zero documents existed before this pass.

### 5. Shared images across the two folders

35 ledger rows / 22 image files here. Byte-identical groups:

- `00194` and `00195` share **all four** images and the energy label - they are the same
  `NEARMATCH` source (`G-SNACK2100TN`), tagged as such.
- The two VRX SKUs share the Hamoki `VRX/380` range spec table and the catalogue `VRX WITH FLAT
  GLASS` crop; both are tagged `REPRESENTATIVE-RANGE`.
- The nine Hamoki VRX gallery images are **identical across every VRX width Hamoki sells**, so they
  are filed once in `_brand-reference\RANGE-VRX380__hamoki-REPRESENTATIVE-RANGE-*.png` rather than
  under any SKU. One of them is the useful spec table; the rest are range renders whose well counts
  match no particular model.
- Nothing here is byte-identical to anything staged in `sheffield-blueline\` **except** the Forcar
  `G-SNACK2100TN` pair and the Vcher `SNACK2100TN` card, which are not used on that side.

**All 22 files were rendered before acceptance. Nothing synthetic was found**; the Forcold 1125 x 750
files are studio photographs on white, the Hamoki 1156 files are factory/warehouse photographs.
No `_ai-generated\` folder was needed.

### 6. What I could not reach

- No datasheet PDF from Forcold, Hamoki or Vcher for the VRX range - only the catalogue page and
  Hamoki's spec-table graphic. Forcold's product pages carry the full attribute table in HTML
  (transcribed above) but expose no download.
- No source anywhere for a 1200 mm or 1500 mm wide SNACK counter (section 3).
- Forcold's own site returns 404 on the `refrigerated-counters-ventilated-g-snack....` URL pattern;
  its SNACK counter images are reachable through the media API
  (`https://www.forcold.it/wp-json/wp/v2/media?per_page=100&search=SNACK`) but the product pages
  live under a different slug I did not need to resolve, since Forcar covers the same codes.

### 7. BLUELINE vs SHEFFIELD BLUELINE

**No brand change proposed.** Evidence gathered here argues the two labels are one product line:

- `IMG/DIS/00069` and `IMG/DIS/00137` are filed in the **BLUELINE** dossier but SAP's `Make` field
  for both reads **SHEFFIELD BLUELINE**. Meanwhile SAP reads **BLUELINE** for the three SNACK SKUs
  in the same folder. The split is inconsistent inside SAP itself.
- `IMG/REF/00196` SNACK4100TN (BLUELINE) and `IMG/REF/00126` SNACK3100TN (SHEFFIELD BLUELINE) come
  off the same catalogue page, share the same Forcar `G-` codes and the same Hamoki `W-2210xx`
  numbering, and differ only in door count.
- Both labels contain the same anomaly - width suffixes (`-1200`, `-1500`) that the manufacturer
  does not build.

Nothing in this pass distinguishes them. The merge decision has no evidence against it.
