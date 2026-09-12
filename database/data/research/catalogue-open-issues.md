# Catalogue open issues — flagged, awaiting a decision or a source

Raised during the product-copy pass, 2026-08-11. Each item is **blocked on something a copy
edit cannot supply**: a business decision, a physical measurement, or a supplier figure.

> **2026-08-12 verification pass.** Every 🔴 finding across all 48 research files was re-checked
> against the live record. **11 of 13 were already applied** by the August copy pass (Tefcold
> R600a + input power, Pasmo S110F hopper, Hatton HT-Z1, Roller Grill 8 kW, Robot Coupe
> CMP 400 V.V, Brema R290 ×5, Diqian 2 kW, Baron height 340 + three-phase). The catalogue-wide
> brand-linkage defect is **also fixed** — no product carries `SKYMSEN (DISCOVERY)` or
> `ZUMMO INNOCACIONES` any more and every brand string now resolves against `brands.json`.
> No published product is missing an image, and all 12 shared-image references are
> parent↔variant pairs. **Three new electrical defects were found and fixed — see E below.**
Nothing here is a formatting problem — the copy has already been written around every one of
them, omitting disputed values rather than picking one.

Fixed items are not listed. Sources are bare URLs by convention.

---

## A. Records that need a business decision

### A1. `IMG/DWW/00110` and `IMG/DWW/00143` are the same product
Both carry `model_number` **`JW-S`**, identical specs (500 × 500 × 100 mm, 36 × 36 mm mesh)
and identical price (KES 10,350). 00110 is named "Open Rack **Jw-Ss**" and is published;
00143 is "Open Rack JW-S" and is archived.

**There is no `JW-Ss`.** The full 137-product JIWINS catalogue and four distributor catalogues
were searched; the string does not exist. The "Ss" is a typo.

→ **Decision needed:** merge/delete the duplicate, or establish that `JW-SS` is a real second
product and correct 00110's `model_number`. Only 00110 has been given copy.

### A2. `IMG/BUF/00028` and `IMG/BUF/00143` are the same product, with swapped axes
Both are `AT60293` "Chafing Dish Induction Square". Dimensions disagree by an axis swap:
00028 stores **400 × 400 × 210**, 00143 stores **400 × 210 × 400**. 00028 is archived,
00143 published.

→ **Decision needed:** same merge question as A1, plus which axis order is right.

### A3. `IMG/DWW/00097` `JW-64B` — Blue or Beige?
The spec table says `Blue PP`; the row's own SAP-derived bullet said *"Plate & Tray Rack
Beige"*. The JIWINS Art.No. table **has no colour column**, so this cannot be settled from the
research already on file. Colour is currently omitted from the copy.

→ **Needs:** a look at stock, or a supplier confirmation.

---

## B. Wrong or missing product data — needs a source

### B1. Three products now have NO electrical specification
`IMG/FPR/00046` (HK-Redline 300ES-12 meat slicer), `IMG/OVE/00201` (HDS gas convection oven)
and `IMG/HOT/00333` (Broaster 1800G) each carried a **US/export voltage** figure —
127 V/60 Hz, 120 V/60 Hz/9.3 A and a 120 V/60 Hz control circuit respectively — wrapped in an
internal research note that was publishing to customers. The notes and the wrong-market figures
have been removed, which leaves these three with no electrical row at all.

→ **Needs:** the Kenyan-build figure (240 V / 50 Hz) from the supplier for each.
⚠ A buyer's electrician would size the wrong circuit from the old figures, so do not restore them.

### B2. `IMG/BUF/00030` EB-1200 induction cooker — unwritable as it stands
No wattage and no voltage anywhere on the record, and the height field reads **9 mm**.
Its only descriptive content is the phrase "Square Induction Cooker".

→ **Needs:** a full spec from the supplier before any copy can be written.

### B3. `IMG/PAS/00159` NFK-30I — height unresolved
Power and weight are settled (**1.5 kW / 485 kg**, applied — corroborated independently by
Guangzhou Ola-Oficina against h-kitchen.com's current row, against SAP's 0.75 kW / 300 kg which
descends from a supplier sheet known to duplicate the semi-automatic's row).

**Height is still open: 2100 mm (stored) vs 1460 mm (live supplier site).**
⚠ Do not re-argue that 2100 mm is implausible — three unrelated suppliers list ~2100 mm for this
machine class. This needs a tape measure, not an argument.

### B4. `IMG/FPR/00232` DZ400 — the stored dimensions are the chamber, not the machine
`length`/`width`/`height` hold **420 / 440 / 130**. A machine the record itself calls *vertical*
cannot be 130 mm tall, and the truncated source text read *"Vacuum chamber volume: 420"*.
The spec table row has been relabelled **Vacuum Chamber**; the three JSON dimension fields still
hold the chamber figures.

→ **Needs:** real external dimensions, then a `--allow-dims` correction.

### B5. `IMG/FPR/00231` DZ300 — ultimate vacuum figure not credible
The source bullet said *"Lowest absolute pressure of vacuum case 0.1pa"*. 0.1 Pa is far below
what a chamber machine of this class achieves; it is most likely **0.1 kPa (100 Pa)**.
Deliberately left out of the rebuilt spec table and the copy.

→ **Needs:** the factory figure with its unit.

### B6. `IMG/HYS/00265` RATIONAL Care Cartridge (draft)
Its weight row disagreed with itself by 11× across two distributors (13 lb vs 1.18 lb per
6-pack) and was dropped. A single-distributor **"approximately 3 months per cartridge"** service
life was dropped along with it and is worth restoring as its own row if it can be confirmed
against RATIONAL's own documentation.

---

### B7. Two model numbers disagree between the workbook and `products.json`
Surfaced when syncing `Ecommerce Listing- All Categories.xlsx` on 2026-08-11. Both were
**held back from the sync** rather than guessed, so the two sources still disagree:

| SKU | Workbook | products.json |
|---|---|---|
| `IMG/FPR/00038` | `LAR 25MB` | `LAR-25LMB` |
| `IMG/DIS/00069` | `VRX1500/80 FG` | `VRX1500/380 FG` |

→ **Needs:** confirmation against the supplier, then one source corrected to match the other.
⚠ `model_number` is the unique product ID — do not "tidy" either value into the other.

(The two KEF codes `IMG/COF/00103` → `FLT120 BLACK` and `IMG/COF/00104` → `FLT120-2 INOX`
*were* synced, because the FTL/FLT transposition and the `-2` suffix are both already settled.)

---

## C. Imagery

### C1. `IMG/DWW/00144` `JW-C` is showing the wrong product
Its photograph is **byte-identical** to `JW-S`'s (identical MD5, RMS 0.00 at 256 × 256) and
renders as the open-lattice rack, **not** a 10 × 10 mm cutlery grid. Both files came from the
manufacturer's own gallery under distinct, code-keyed filenames — so a code-keyed filename
proves intent, not provenance.

**No true `JW-C` photograph exists on the open web** — not on jiwins.cn, not in any of four
distributor catalogues.

→ **Needs:** own photography, or acceptance that the image is representative-of-range.
Images are assigned manually, so nothing has been changed.

---

## D. Renames now unblocked (the URL objection was never real)

`ProductSeeder::buildSlug()` (`database/seeders/ProductSeeder.php:365`, called at `:237`) already
honours an explicit **`slug`** key in `products.json`, falling back to
`Str::slug($name.' '.$sku)` only when absent. **A product can therefore be renamed with its
current URL pinned verbatim** — proven on the three chafing dishes, which were renamed
Square → Oblong on 2026-08-11 with zero URL change.

⚠ An explicit slug deliberately stops matching its own name, so it can **collide** with another
product's derived slug and take its URL. `ProductCatalogueKeysTest` now guards this
("never lets two products resolve to the same URL").

### ✅ APPLIED 2026-08-12 on the user's approval — 6 renames, every URL pinned

Each was given an explicit `slug` equal to its **live database slug**, read from the `products`
table rather than derived, so no URL changed. Verified: all 683 products still resolve to
unique URLs, `ProductCatalogueKeysTest` 12/12 green.

| SKU | Was | Now |
|---|---|---|
| `IMG/FPR/00131` | Manual Vegetable Slicer Systematic JSCC-9 | **Cheese Cuber** Systematic JSCC-9 |
| `IMG/FPR/00132` | Gravity Vegetable Slicer Systematic JSEC-08 | **Vegetable Chopper and Dicer** Systematic JSEC-08 |
| `IMG/FPR/00133` | Manual Vegetable Slicer Systematic JSVC2100 | **Lettuce Cutter** Systematic JSVC2100 |
| `IMG/HOT/00189` | …15 Ltr **Table Top** Baron DI7FRE415 | …15 Ltr **Drop-In** Baron DI7FRE415 |
| `IMG/COF/00103` | Coffee Brewer with 1 Decanter **FTL**120 Black | …**FLT**120 Black |
| `IMG/COF/00104` | Coffee Brewer with 2 Decanter **FTL**120-2 Inox | …**FLT**120-2 Inox |

Also applied: Zummo `IMG/FPR/00079` dimensions **548/431/811 → 542/427/810** (technical sheet
M0408ENEN/23-1), with the spec table's own LENGTH/WIDTH/HEIGHT text kept in step.

### Still pending

| SKU | Stored name | Issue |
|---|---|---|
| `IMG/FPR/00110` | "Potato Chipper Table Top Kayalar" | the **name and copy are now correct**, but the **image is still the Waring WSG60 spice grinder** — see C2 |
| 6 × Iberna | show superseded codes | see `iberna` rows in the batch-2 research |

### C2. `IMG/FPR/00110` is still displaying a Waring spice grinder
**Published at KES 22,770.** The stored file
`products/potato-chipper-table-top-kayalar-imgfpr00110.jpg` was rendered this session and is
unmistakably a **Waring WSG60 spice grinder** — the WARING wordmark is legible on the badge.
Waring is a separate live brand in this catalogue.

The filename is derived from the product name, so it asserts a potato chipper while showing a
grinder — [[feedback_one_photo_many_skus]]'s exact failure mode. The description was already
rewritten to correct potato-chipper copy; only the photograph is wrong.

→ **Needs:** a replacement image. Images are assigned manually, so nothing was touched.

⚠ `Str::slug` **removes** `/` rather than replacing it, so `IMG/BUF/00019` becomes
`imgbuf00019`, not `img-buf-00019`. Read the live slug from the database before pinning it.

---

## E. Electrical defects found and FIXED 2026-08-12

All three were on **published** records and all three are now corrected in `products.json`.

### E1. `IMG/COF/00054` Simonelli Microbar II — was `110V / 2000W / 18A`
⭐ **The stored figure was a splice of two different market builds.** Nuova Simonelli's own
brochure (staged, `IMG-COF-00054__brochure.pdf` p9) prints the machine as **115 V (18 A) or
230 V (8 A)**, with **1000 W** for the Coffee versions and **2000 W** for the Cappuccino
versions. Our record took the **18 A off the 115 V column**, the **2000 W off the Cappuccino
column**, and labelled the result **110 V** — a figure that appears nowhere.

The record's own description (two 0.7 L boilers, milk drinks) confirms it is the **Cappuccino**
build, so 2000 W was right. **Corrected to `230 V / 2000 W / 8 A`.**

⚠ The staged `IMG-COF-00054__spec-sheet.pdf` is the **US** sheet (Ferndale, WA — 110 V / 1500 W
/ 13 A). It matches neither our record nor the Kenyan build. Do not source electrical data from
it.

### E2. `IMG/FPR/00079` Zummo Z06A-N — was a three-market voltage list
`POWER RATING: 230 V – 50 Hz. 220 V – 60 Hz. 120 V – 60 Hz.` was Zummo's **global build list**,
not a rating — exactly the defect `zummo-research.md` §4 raised and nobody had applied.
**Cut to `230 V – 50 Hz (other market voltages built to order)`.**

Also applied from that research (§6 #2), all from Zummo's technical sheet M0408ENEN/23-1:
feeder 1.5 kg, bin 22 L (2 × 11 L), filling height 178 mm, electrical consumption
0.007 kWh/10 L·day, squeezing kits M + L supplied and S optional, weight 51 kg, automatic
belt-driven filter, blocking sensors. The Spanish comma decimal `0,33 CV` was normalised.

→ **Still open on this SKU:** Zummo's own datasheet gives **542 / 427 / 810**, we store
548 / 431 / 811. A dimension change needs your per-SKU approval.

### E3. `IMG/REF/00076` Brema CB 1565A HC — was `1050 W`
Settled from Brema's own datasheet (staged `IMG-REF-00076__CB-1565A-HC-brema-spec.pdf`,
**Rev. 02, January 2025**), read directly rather than from the research summary because the
research file quoted **three different figures** (1050 W stored, 1150 W in its §2 table,
1280 W in its §2.1 table).

The datasheet prints **`Average power consumption 1280 W`**, alongside `Refrigerant R290`,
`Standard voltage 220-240 V ~ 50 Hz`, `Fuse 16 A`, `Sizes (L-P-H mm) 840 - 740 - 1075`
(matching our stored dimensions) and `Net weight 118 kg`. **Corrected to 1280 W.**

⚠ This record is still `status: draft` with an **empty `image`** — the remaining blocker on it.

---

## F. Sheffield Blueline — defects exposed by the 2026-09-03 copy rewrite

The 47 Sheffield Blueline records were rewritten from their own spec tables. The generator
cross-checks every figure before writing it: **gross capacity must agree with the internal
dimensions** (ratio 0.85-1.45 of the internal volume), and **every external axis must exceed
the matching internal one**. Four records failed, so the offending figure was left out of the
customer copy rather than repeated. All four still need a decision.

### F1. `IMG/REF/00034` GN1100TN — capacity is the GN2100's
Stored `Gross Capacity: 314 L`, but the stored interior of `365 × 580 × 589 mm` is **125 L**.
314 L is exactly what `GN2100TN` (`IMG/REF/00036`) carries, on a 795 mm wide interior.
The sibling `SNACK1100TN` (`IMG/REF/00215`) stores 103 L on a 365 × 480 × 589 interior, which
is self-consistent — so the 1100 body really is the small one. **Capacity suppressed from the
copy.** Likely correct value ~124 L, matching `GN1100BT`'s stored figure.

⚠ Its external dimensions are also stored axis-scrambled as `700 × 860 × 925 mm`. Every other
counter in the range is 860 mm high; this reads as W 700 / D 860 / H 925. Probably `925 × 700 × 860`.

### F2. `IMG/REF/00035` GN1100BT — interior is the GN2100's
The mirror of F1. Stored `Gross Capacity: 124 L` against a stored interior of
`795 × 580 × 589 mm` = **272 L**, which is the GN2100 interior. Here the *capacity* looks right
for a 1100 body and the *interior* looks wrong. **Both suppressed from the copy**; its external
dimensions carry the same `700 × 860 × 925` axis scramble as F1.

### F3. `IMG/REF/00095` GN1410TN — capacity is the GN650's, shell is the GN1200BTV's
Stored `Gross Capacity: 685 L` against a stored interior of `1364 × 700 × 1401 mm` = **1338 L**.
685 L is what all four GN650 records carry. The three other GN1410 records
(`00096`, `00097`, `00098`) all store **1476 L** on that same interior.
Its external `1340 × 810 × 2000 mm` is also **narrower than its own interior** (1364 mm) and is
the figure `GN1200BTV` (`IMG/REF/00042`) carries. **Capacity and external dimensions both
suppressed.** Expected 1476 L and 1480 × 830 × 2010 mm, matching its siblings — but that is an
inference, not a source.

### F4. `IMG/REF/00096` GN1410BT — external shell narrower than its own interior
Capacity (1476 L) is consistent, but external `1340 × 810 × 2000 mm` is again narrower than the
stored interior `1364 × 700 × 1401 mm`, and again matches `GN1200BTV`. **External dimensions
suppressed from the copy.** Same expected correction as F3.

### F5. Three drawer chillers hold no data at all
`IMG/REF/00166` GN2140TN, `IMG/REF/00043` U-GN3160TN and `IMG/REF/00099` U-GN4180TN carry only
Type, Temperature Range and Power — no capacity, no dimensions, no weight, no compressor.
Their siblings `GN3140TN` (`00167`) and `GN4140TN` (`00182`) are fully populated.
**Not rewritten**; they need supplier data, not writing.

### F6. `IMG/DIS/00120` EWB470G wine cooler — no internal dimensions
Carries `Bottle Capacity 430`, external `595 × 710 × 1880 mm` and a `5 to 20 °C` range, but no
internal dimensions, weight, refrigerant or compressor, and it is the only wine cooler in the
range so there is no sibling to check against. **Not rewritten.**

### F7. `IMG/REF/00217` SNACK2100BT-150 — model number looks truncated
Its external width is 1500 mm and every sibling suffix names the width
(`-1200`, `-1500`). The stored `model_number` reads **`SNACK2100BT-150`**. Almost certainly
`-1500`, but `model_number` is the unique ID, so this is flagged rather than changed.

### F8. `IMG/REF/00042` GN1200BTV is filed as an Upright Chiller
Its stored temperature range is **-18 to -22 °C**, which is a freezer. Its category is
`Refrigeration > Upright Chillers`. The copy describes it from its own temperature range, so it
reads correctly, but the category is wrong for browsing and filtering.

## G. SV-Blueline — defects exposed by the 2026-09-03 copy rewrite

10 of the 12 SV-Blueline records were rewritten from their spec tables. Two were excluded
because their spec cells carry research prose rather than values, and are listed here.

### G1. `IMG/REF/00198` SD/SC-158Y — a research note is published in the spec table
Its `Temperature Range` cell reads, verbatim:
*"For the freezer version: typically -18°C to -22°C. Power consumption / input power: Around
~180 W input power. :Inner dimensions for 158L: ~ 600*700*800"*

That is a working note, not a specification: three separate fields merged into one cell, every
one of them hedged (*typically*, *around*, *~*). It also asserts `600*700*800` as the **inner**
dimensions while the record's own `Dimensions` row stores the same figures as the **external**
size. `Capacity` reads `158 litres` rather than a number and unit.
**Not rewritten.** The cell needs splitting into Temperature Range / Power / Internal
Dimensions, and every value needs a firm source before it is published. This is the same
leaked-research-note class as section E, and the reason to re-run the spec scan after any
research-application wave.

⚠ Already flagged separately in `sheet-findings.md`: SAP height 800 is internal, external 850.

### G2. `IMG/REF/00200` SD/SC-518 — merged values and a self-contradiction
`Capacity` reads `518 litres. deepchestfreezer`; `Temperature Range` reads
*"≤ -18 °C. Dimensions 1475*750*880. power 220-240 V, 50 Hz"*.

Three fields in one cell again — and the dimensions inside that cell (**1475 × 750 × 880**)
disagree with the record's own `Dimensions` row (**1475 × 757 × 860**) on two of three axes.
**Not rewritten.** `≤ -18 °C` and `220-240 V, 50 Hz` are firm and can be split out; the
dimension conflict needs a source before either figure is published.

### G3. All four CFR/CFD uprights carry the same 205 W
`CFR-20N1F(HB)` and `CFD-20N1(HB)` are 430 L; `CFR-40N2F(HB)` and `CFD-40N2F(HB)` are 860 L —
double the volume, two doors instead of one — yet all four store `Power: 205 W`, and the two
430 L cabinets share identical dimensions across chiller and freezer duty. One figure
copy-pasted across a range is the likeliest explanation. The value was written as recorded
because it is the only power figure on file, but it should be checked against Snow Village's
own sheets before it is trusted.

### G4. `IMG/REF/00184` and `IMG/REF/00186` have no temperature range at all
Both CFR chillers store no `Temperature Range`. Their CFD freezer counterparts store
`≤ -15 °C`. The copy omits the range rather than borrowing the freezer's.

## H. The "Built in stainless steel" template skeleton — 2026-09-03

23 records carried a generated two-sentence description ending *"Built in stainless steel for
daily commercial service."* **20 were rewritten from their own records.** The skeleton was
applied wherever a record was near-empty, so it hid a data gap rather than filling one.

⚠ **It also published a factual error.** Four of the 23 are the colour-coded chopping boards
(`IMG/FPR/00012`, `00014`, `00015`, `00081`). Their own spec tables say `Material: Polyethylene`
— the skeleton told customers they were stainless steel. Anything that generic sentence touched
should be assumed wrong until checked against the record.

### H1. Three records still carry it, deliberately
- `IMG/BUF/00030` EB-1200 — unwritable per B2 (no wattage or voltage, stored height 9 mm).
- `IMG/BUF/00244` A032 heat lamp — its only figures are documented as byte-identical to a juice
  dispenser record and impossible for a pendant lamp.
- `IMG/BUF/00028` — archived duplicate of `IMG/BUF/00143`, pending the merge decision in A2.

### H2. Chopping board thickness contradicts the stored height
All four boards store `Thickness: 20mm` in the spec table while the record's `height` field
reads **40**. The copy states 20 mm, following the spec table. One of the two is wrong.

### H3. `IMG/HOT/00354` GH-813 — spec cell carried a `. -` artifact
`Temperature Range` read `50 °C to 320°C. -`, and the fragment had been copied into both the
short description and the meta description. **Cleaned in all three places.** Its sibling
`IMG/HOT/00353` had the same malformed short description and meta and was cleaned with it.
⚠ The depth conflict on `00354` (350 vs 305) is untouched and still open.

### H4. Records rewritten while a flagged conflict was suppressed
`IMG/OVE/00087` (Garyton 1350x850x600 vs our 980x540x600) and `IMG/HOT/00421` (maker figure vs
our 400x700x290) were rewritten **without stating dimensions**, since the conflict is unsettled.
`IMG/OVE/00234`/`00235` hamburger pans were written without dimensions because their stored
915 x 690 x 355 reads as a carton, not a 4 inch pan.

---

## I. Harvest from the live site — 2026-09-03 (Upright Chillers pilot)

`sheffieldafrica.com` is a Laravel app whose `products` table uses **the same `IMG/REF/00032`
SKU format we do**. 404 of our 683 join to it directly. Its `technical_specification` is stored
as `<p>`/`<li>` prose rather than a table, which is why an earlier `<tr>` count read it as empty.

⭐⭐ **The live site holds facts our catalogue lost.** Across the 398 uniquely-matched products,
**192 (48%) name a spec concept the live record has and ours does not** — most often insulation
(39), castors or feet (37), capacity (25), voltage or power (21), temperature (16), shelves (14),
compressor (10), climate class (8) and refrigerant (8). The per-SKU list is
`database/data/research/live-harvest-gaps.csv`.

⚠ **This reverses the direction of the sync for those items.** Pushing our copy over theirs
without harvesting first would destroy data on roughly half the matched catalogue. Harvest, then
push.

### ✅ RESOLVED by the live record

**F3 `IMG/REF/00095` GN1410TN** — live gives `Volume 1400 L` and `Width 1480 / Depth 830 /
Height 2010`, with the same `1364 × 700 × 1401` interior we store. Both figures had been
suppressed from the copy as self-contradictory (685 L against a 1338 L interior; a shell
narrower than its own interior). **Applied: capacity 685 → 1400 L, external
1340 × 810 × 2000 → 1480 × 830 × 2010 mm**, and the description rewritten to state them.
⭐ The suppression was correct and the arithmetic prediction was right — worth remembering that
the consistency gate found a real defect three weeks before the source turned up.

**F8 `IMG/REF/00042` GN1200BTV** — not a mis-categorised freezer. It is a **dual-temperature
cabinet**: live reads *"2 door solid Dual fridge & Freezer … Volume (L) fridge: 537/ freezer 537
… Temperature Range fridge: +2~+8, freezer: -18~-22 … Climate Class 4 … Refrigerant R134a/R404a
… Net Weight (kg) 195, Gross Weight (kg) 210 … 4 pcs castors, 8 shelves … 1340x810x2010mm"*.
Our record was wrong on **five** fields. All applied and the copy rewritten as a dual cabinet.
⚠ Its category is still `Refrigeration > Upright Chillers`; it belongs in neither chillers nor
freezers alone.

**G4 `IMG/REF/00184` / `IMG/REF/00186`** — live states `Temperature 0-10 Deg C` for both CFR
chillers. **Applied.** Also harvested `Copper tube refrigeration` as its own row, and split
`IMG/REF/00186`'s merged `Compressor: Secop Copper tube refrigeration` cell back to `Secop`.
⚠ G3 stands: all four CFR/CFD uprights still carry the same 205 W.

**`IMG/REF/00060`** — live description names **R452A** gas; we held no refrigerant. **Applied.**

### I1. Tecnodom Perfekt line — dimension conflict, left open
`IMG/REF/00060` (AF14PKMTN) and `IMG/REF/00062` (AF07PKMTN) both store depth **790** and height
**2020**; the live site states depth **800** and height **2030** for both. A consistent
disagreement across the line, so it is one decision, not two. Neither figure applied.

### I2. Corroborated, no change needed
`IMG/REF/00032`, `IMG/REF/00044`, `IMG/REF/00097` and `IMG/REF/00157` match the live record on
every shared value. `IMG/REF/00049` and `IMG/REF/00157` are richer on our side than on theirs.

## J. Ice Cube Machines harvest — 2026-09-03

Second sync category. 17 spec rows harvested from the live site into 5 records, **additions
only** — no value we already held was overwritten. Two records were nearly empty on our side
and are now substantive.

- `IMG/REF/00022` ZBJ-40P and `IMG/REF/00019` ZBJ-150P held **4 spec rows each** (brand, model,
  type, dimensions). Both gained production rate, cube size, spray-water system, cooling and
  supply voltage from the live record.
- ⭐ `IMG/REF/00019` — the live record states *"Split Ice Cube Machine with Storage Bin and
  Production Machine"*. **This resolves the open note that its stored figure "is the head unit
  only, not the split machine"**: the machine genuinely is a two-part unit, so a head-unit
  dimension is not an error, just incomplete. Recorded as a `Configuration` row.

### J1. Conflicts found — none adopted, all still open

| SKU | Ours | Live | Note |
|---|---|---|---|
| `IMG/REF/00154` CB-640A | 72 kg/24h | 67 kg/24h | ⚠ 67 kg is **our stored net weight**. Looks like the live record has the weight in its capacity field — the same defect class as `IMG/PAS/00166`. Do not adopt without a Brema datasheet. |
| `IMG/REF/00021` ZBJ-60P | 550 W | 450 W | The live site prints `450W Power` on **both** the 40P and the 60P, so it reads as one figure copy-pasted across the range. |
| `IMG/REF/00022` ZBJ-40P | 510 × 585 × 895 | 500 × 580 × 950 | 55 mm on height. Its siblings 60P and 80PA are both 895 tall, which favours ours. |
| `IMG/REF/00019` ZBJ-150P | 764 × 600 × 559 | 765 × 780 × 1500 | Live prints the **same** 765x780x1500 for both the 150P and the 250P, so at least one is wrong. Ours is the head unit only (see above). |
| ZBJ range refrigerant | R404a | R290 (description) / R404a (spec) | ⚠ **The live record contradicts itself** — its description says R290 while its own spec table says R404a. Ours agrees with the live spec. Nothing changed. |
| `IMG/REF/00082` CB-416A | Cube approx. 23 g | 13 g, 18 g, 33 g, 42 g | Our 23 g appears identically on the 416A, 640A and 955A, which reads as a copy-pasted default; 23 g is not among the four sizes the live record lists. Needs a Brema source. |

⚠ **The live site is not automatically the better source.** Of six disagreements here, at least
three look like defects on the live side, not ours. Harvest additions freely; adjudicate
conflicts individually.

## K. Convection Ovens — 2026-09-03 (third sync category)

⭐ **Harvest yield here was near zero, and that is the finding.** Unlike the ice machines, our
Tecnodom, Skymsen and Blodgett records are consistently richer than the live site's, and the
live records carry several demonstrable errors. **The live site is a source to check against,
not a source to defer to.** Nothing was adopted from it in this category.

### K1. `IMG/OVE/00215` MAXICONV — the live site has the wrong oven's dimensions
Live states **1490 x 1070 x 1900 mm** for a 4-tray bench-top oven weighing 29 kg. Those are
**byte-identical to the Discovery 10** (`IMG/OVE/00214`), a 10-tray floor-standing oven on
casters. Our 700 x 590 x 435 mm is consistent with a 46.8 litre chamber and a 29 kg net weight.
**The live product page is wrong and is published.** Worth correcting there independently of
this sync.

### K2. `IMG/OVE/00201` HDSGCO-1 — live gives the US build
Live states `Voltage 120VAC, 60Hz, 9.3A`. That is the North American configuration and must not
be published for this market. This is the record open issue B1 flags as *"no electrical rating -
needs the Kenyan-build figure"*; the live site does **not** answer it, it answers a different
question. Left blank deliberately.
⚠ Live also gives `967 x 1099 x 1384 mm` and `185kg/275kg` against our `737 x 660 x 508 mm`.
Ours reads as the oven, live's as the crated shipment - but neither is labelled, so unresolved.

### K3. `IMG/OVE/00230` YXD-8A-3 — four values disagree at once
| | ours | live |
|---|---|---|
| Power | 3.5 kW | 6.4 kW |
| Trays | 3 x 600x400 | 4 x 400x600 |
| Net weight | 50 kg | 67 kg |
| Height | 500 mm | 572 mm |
3.5 kW is low for a 4-tray 600x400 oven, which favours the live figures - but our record may
simply be the **YXD-8A** rather than the **-3** variant. Needs the Kator/H-Kitchen sheet.

### K4. Smaller conflicts, none adopted
- `IMG/OVE/00224` HDSECO-8A — temperature `160-570 F` (live) vs `86-572 F` (ours). Ours is
  identical to the 4A's range, so ours looks like a copy-paste from its sibling.
- `IMG/OVE/00076` FEM03NE02V — weight `33 kg` (live) vs `21 kg` (ours). ⚠ Live prints `33 KG`
  for **both** the 3-tray 00076 and the 4-tray 00078, so the live figure is the copy-paste.
- `IMG/OVE/00214` DISCOVERY 10 — length `1490` (live) vs `1590` (ours); live says 220 V, ours
  says 380 V primary with a 220 V option.
- `IMG/OVE/00107` Blodgett CTB SGL — live gives `208v/60/1-ph, 27.0 amps`, the US build. Ours
  records the 50 Hz configuration and already carries the caveat *"confirm configuration on
  order"*. Correct as it stands.
- `IMG/OVE/00229` YXD-1AE — the live record contradicts itself: its spec says `3x454x327mm
  Trays`, its description says `Four aluminum baking trays 325x450mm`. Neither adopted.
  ⚠ Its spec table also carries `Size:25L Food Mixer` - a field from a different product.
  ⭐ Its `530 x 595 x 570` does corroborate the spec-sheet figure over the SAP row, which
  settles that half of the earlier note.

## L. Pastry Displays — 2026-09-03 (fourth sync category)

14 spec rows harvested into 2 records, additions only.

- `IMG/DIS/00019` FGDG 1500LS-3 and `IMG/DIS/00021` FGDG 1500LSD-3 each held **6 spec rows**
  and **no dimensions**. Live supplies `1500 x 740 x 1300` and `1500 x 740 x 1360` respectively
  — the 60 mm height difference is the only thing separating the LS from the LSD, so it is the
  distinguishing figure and we were missing it on both.
- Both also gained shelving, lighting, controller, glazing, mobility and condenser-access rows
  from the live description, which is identical across the FGDG family.

### L1. ⚠ The live site has one cabinet's figures copy-pasted across two whole ranges

**Cake cabinets (SV-Blueline DG-FZ).** The live description prints `Volume(L) - 250; Power(W)-
400` on **all three** of the 900FZ, 1200FZ and 1500FZ, and its spec line reads `POWER RATING:
400W` on all three. Our records differentiate them properly:

| SKU | model | ours | live |
|---|---|---|---|
| `IMG/DIS/00126` | DG-900FZ | 250 L / 400 W | 250 L / 400 W ✓ |
| `IMG/DIS/00127` | DG-1200FZ | **300 L / 430 W** | 250 L / 400 W ✗ |
| `IMG/DIS/00128` | DG-1500FZ | **350 L / 450 W** | 250 L / 400 W ✗ |

**Table-top cabinets.** Same defect: live gives `Volume(L)- 72` for both `IMG/DIS/00129`
(DG-TY700) and `IMG/DIS/00130` (DG-TZ700). Ours holds 72 L and **96 L** — and the 96 L is what
makes the TZ worth buying over the TY, since both share a 700 x 500 x 730 shell.

**Nothing adopted.** A 1500 mm cabinet does not hold the same volume as a 900 mm one. Ours is
right and the live pages are wrong on four published products.

⭐ Running tally of live-vs-ours disagreements across four categories: the live site has been
the defective source roughly two times in three. Its value is in the **facts we lack**, not in
adjudicating the ones we hold.

## M. Counter Chillers + Chafing Dishes — 2026-09-03 (fifth and sixth sync categories)

### ✅ RESOLVED — F1 `IMG/REF/00034` GN1100TN, with double corroboration
Live states `Volume(L) 124 L`, `Width 925`, `Height 860` and the same `365 x 580 x 589` interior
we hold. That is exactly what F1 predicted from the interior volume.
⭐ **The corroboration is better than a single source.** The live page for its sibling
`IMG/REF/00215` SNACK1100TN carries `Volume 124 L / Net Weight 60 kg` — and 60 kg is the weight
**our** GN1100TN record holds. So the GN1100TN's true figures (124 L, 60 kg) exist in two places;
what happened is that the two 1100 records got their data shuffled between them.
**Applied:** capacity `314 L` -> **`124 L`**; external `700 x 860 x 925` -> **`925 x 700 x 860`**;
copy rewritten to state both.
⚠ `IMG/REF/00215` SNACK1100TN keeps **our** 103 L / 48 kg: its own `365 x 480 x 589` interior is
103 L to three significant figures, so ours is self-consistent and the live page is the one
carrying the wrong siblings' numbers. F2 (`GN1100BT`) is untouched and still open.

### ✅ Corrects a fix that was only half-applied — the Square/Oblong chafers
The 2026-08-11 rename fixed the **names** of the mis-titled chafing dishes but left their
**`Type` spec rows** saying "Square". Both survivors corrected from their own names and
dimensions, not from the live site:
- `IMG/BUF/00019` `Chafing Dish Drop in Square` -> **`Chafing Dish Drop In Oblong`** (670 x 455)
- `IMG/BUF/00021` `Chafing Dish Square` -> **`Chafing Dish Oblong`** (670 x 460)
⭐ Worth a general sweep: when a rename is approved, check whether the same word appears in the
`Type` row, the short description and the meta description, not just the `name`.

### Harvested
- `IMG/BUF/00178` RA2301AE and `IMG/BUF/00179` ECD09C — live gives `220V, 800W` and a
  thermostat with temperature display. Neither held any electrical data at all.
- `IMG/BUF/00253` EG2017X — live gives `Capacity: 9 Litres`; ours held none.
- `IMG/BUF/00021` — live gives `GN1/1x1pc`, the pan format.

### M1. A2 partially settled — `IMG/BUF/00028` / `IMG/BUF/00143`
Live gives `400 x 400 x 210` for AT60293. Our `00028` stores exactly that; our `00143` stores
`400 / 210 / 400`. So **00143 is the axis-scrambled one**, which narrows A2 from "both wrong"
to "merge onto 00028's figures". The merge/delete decision itself is still yours.

### M2. Live-side copy-paste, nothing adopted (the pattern holds)
- **SV-Blueline PLR range** — live prints `Volume(L)- 212; Power(W)- 275` on **all four** of the
  1200, 1500, 1800x700 and 1800x600 cabinets. Ours differentiates 212/275, 299/315, 385/335.
- `IMG/REF/00196` SNACK4100TN — live `386 L`; ours `511 L`. 386 L is the **SNACK3100's** figure,
  and our 511 L is consistent with our own `1663 x 480 x 589` interior.
- `IMG/REF/00195` SNACK2100TN-1500 — live `390 L` vs our `260 L`. Unresolved: ours shares an
  interior with the 1200 model, which is the "same well, longer bench" pattern seen on the
  GN2100TNG pair, so 260 L may be right for both. Needs the Blueline sheet.
- `IMG/BUF/00115` — the live record contradicts itself, giving `LENGTH 360 / WIDTH 360` beside
  `DIMENSION: 320 x 355 x 60`. Ours holds the latter.
- `IMG/BUF/00027` — the live `technical_specification` is the literal string `null`.

## N. ⚠ A fifth of the live catalogue has no usable SKU — 2026-09-03

Found while checking why 21 GN containers were skipped (they were genuinely absent; the skip was
correct). The live `products` table holds 1,300 rows, of which:

| | rows |
|---|---:|
| SKU is the literal four-character string `NULL` | **223** |
| SKU is the truncated prefix `IMG` | 11 |
| SKU is `FAB` / `FB` | 9 |
| SKU empty | 34 |
| **No usable SKU** | **~277 (21%)** |
| Genuine duplicate SKU values | 22 (incl. `IMGREF00127` on ids 43 and 1348) |

`NULL` stored as a **string** rather than a null points at a bad import that stringified an empty
value. Nothing here was touched.

⭐ **This is the real reason our 683 join to only ~415.** It is not a matching failure on our
side — a fifth of their catalogue cannot be addressed by any external system.
⚠ It also means the sync script's multi-hit guard is load-bearing: without it, one update to
SKU `NULL` would have written the same copy to **223 products at once**.

**Before any further automation touches those rows, they need real SKUs assigned on the live
site.** Until then they are invisible to the sync by design.

## O. Upright Freezers + Barline Chillers — 2026-09-03 (eighth and ninth categories)

### Harvested
- `IMG/REF/00202` CFD-60D3F-K held **4 spec rows** and two generic bullets. Live supplies its
  temperature range (-18 to -22 °C), refrigerant (R290), LED lighting with illuminated canopy,
  and CFC-free insulation. Its dimensions already agreed.
- `IMG/REF/00096` GN1410BT gained `Climate Class 4`.

### O1. ⭐ The copy-paste runs the OTHER way on the barline range
Every previous category had the live site repeating one sibling's figures. Here it is **ours**
that does not differentiate, and live that does:

| SKU | model | width | ours | live |
|---|---|---:|---|---|
| `IMG/REF/00105` | GN2100TNG-1200 | 1200 | 314 L | **294 L** |
| `IMG/REF/00144` | GN2100TNG | 1360 | 314 L | 314 L ✓ |
| `IMG/REF/00106` | GN2100TNG-1500 | 1500 | 314 L | **390 L** |

We store 314 L on all three, on the reasoning that they share one `795 x 580 x 589` cooled well
and only the bench length changes. Live's figures rise monotonically with width, which is what
you would expect if the well scales too.

⚠ **Not adopted, and not dismissed.** The reason to hold: live prints **390 L** for the
`SNACK2100TN-1500` as well — a 600 mm deep cabinet, against this one's 700 mm. The same volume on
two different depths is the signature of a shared value, so live's 390 may be no better than our
314. This needs the Blueline spec sheet, and it decides four records at once (the two above plus
`IMG/REF/00195` and the GN2100BT pair).

### O2. `IMG/REF/00096` GN1410BT — refrigerant now contested
Live says **R404a**, we hold **R290**. Its glass-door sibling `IMG/REF/00098` holds R290 on both
sides. Nothing changed. Note this record already carries open issue **F4** (external shell
narrower than its own interior); live gives no dimensions for it, so F4 remains open.

### O3. Live product names carry a different brand
`IMG/REF/00033` is named *"Upright Glass Door Freezer Single 7008 **Meileda**"* on the live site
and *"... Blueline"* in ours. Names are never synced, so nothing changed, but one of the two is
mis-branded.

## P. Counter Freezers + Rational Accessories — 2026-09-03 (tenth and eleventh categories)

### ✅ RESOLVED — F2 `IMG/REF/00035` GN1100BT, mirroring F1 exactly
Live gives `Volume 124 L`, `Width 925`, `Height 860`, `Inner Depth 580`, `Inner Height 589`.
Our capacity (124 L) was already right; what was wrong was the geometry around it.
**Applied:** external `700 x 860 x 925` -> **`925 x 700 x 860`** (the same axis scramble F1 had),
internal `795 x 580 x 589` -> **`365 x 580 x 589`**.
⭐ The 365 mm inner width is not taken from live, which does not state it — it is derived: the
GN1100TN in the identical shell holds `365 x 580 x 589`, and 365 x 580 x 589 = **124.7 L**, which
is the 124 L both records agree on. The stored 795 mm was the GN2100's inner width.
**F1 and F2 were the same defect in mirror image**: the two 1100-series records had swapped
fragments of each other's geometry with the 2100 series. Both now closed.

### P1. The barline capacity question now spans six records
The `GN2100BT-1200` / `-1500` pair repeats the O1 pattern precisely — we store **314 L** for both,
live gives **294 L** and **390 L**. Together with the GN2100TNG trio and `SNACK2100TN-1500`, one
decision from the Blueline spec sheet settles six records. Still unadopted.

### P2. `IMG/REF/00217` SNACK2100BT-1500 — temperature contested
Live `-18 to -22 °C`; ours `-10 to -20 °C`. Live also hedges its refrigerant as
*"R290 / R404a depending on model"*, which is not a specification. Nothing adopted.

### P3. `IMG/REF/00158` DF200 S/S — live states a capacity *range*
Live reads `Gross Capacity: 113 - 140 Litres`. A single cabinet has one gross capacity; a range
suggests the figure covers a family. Ours holds 140 L, consistent with its own
`510 x 485 x 620` interior. Nothing adopted.

## Q. Induction Cookers + Blenders + Multideck Displays — 2026-09-03 (categories 12-14)

**No harvest.** Our records are richer than live across all three, and the one apparent
opportunity turned out to be a live-side copy-paste. Conflicts logged, none adopted.

### Q1. ⚠ `IMG/BUF/00090` Wanhui — the live spec is the Eurotec Riga's
Our record holds only Brand, Model and Type, so live's `360 x 382 x 120 mm, 3500 W,
220-240 V 50/60 Hz` looked like a valuable harvest. It is **byte-identical to the live spec for
`IMG/BUF/00012`**, the Eurotec Riga RIB 3520 EB — and our own Riga record independently holds
exactly those figures. So live has the Riga's specification sitting on the Wanhui's page.
**Not harvested.** The Wanhui A6-650N-320 still needs real data; the imports crosswalk names
WANHUI as the supplier, so their own sheet is the place to look.

### Q2. `IMG/BUF/00030` EB-1200 — the 9 mm height is in the source, not a transcription slip
Open issue B2 flags a stored height of **9 mm** on an induction cooker. Live states the same
`350 x 410 x 9 mm`. That does not make 9 mm correct, but it does rule out our own data entry as
the cause — the error is upstream of both systems. Still unwritable, still open.

### Q3. `IMG/FPR/00023` Santos 37A — power contested
Live `600 W` and `1800 rpm`; ours `1,550 W` and `0-15,000 rpm, pulse 18,000`.
⚠ Live prints `600 W` for the **33E bar blender** too, which is a 1.25 litre machine against this
one's 2+4 litres — the same figure on two very different blenders. Ours also carries voltage and
the Santosafe locking system, which live does not. Nothing adopted.

### Q4. `IMG/FPR/00034` Skymsen LAR — a difference that is not a conflict
Live `3500 rpm`, ours `3,000 rpm at 50 Hz`. Both are right: a 60 Hz motor runs proportionally
faster, and ours states the frequency it applies to. No change; noted so nobody "fixes" it later.

## R. Blueline brand naming — 2026-09-03

Raised by the user: a product page titled **"BARLINE CHILLER 1506 BLUELINE SNACK2100TNG-1500"**
opened with *"The Sheffield Blueline SNACK2100TNG-1500…"* — a brand appearing nowhere else on
the page.

⭐ **Not one product name in the entire Blueline family contains the word "Sheffield."**
32 names say "Blueline", 15 say neither, **0 say Sheffield** — while the `brand` field on 47 of
them read `SHEFFIELD BLUELINE`. The copy was following the field, not the page.

### Applied
1. **Brand field normalised.** `IMG/REF/00194`, `00195`, `00196` (SNACK2100TN-1200/-1500,
   SNACK4100TN) moved from `BLUELINE` to `SHEFFIELD BLUELINE`, spec `Brand` row with them. They
   are the same SNACK counter range as the other eleven, which were already
   `SHEFFIELD BLUELINE` — `SNACK2100TN-1200` and `SNACK2100BT-1200` are the chiller and freezer
   of one cabinet and had been sitting under different brands.
2. **Prose now uses the selling name.** 46 descriptions changed from *"The Sheffield Blueline
   X…"* to *"The Blueline X…"*, matching the product name and page title.

**The convention this sets:** `brand` field and the spec table's `Brand` row carry the formal
name **Sheffield Blueline** (which is what the imports workbook's BLUELINE sheet records as its
`Make`); the description prose uses **Blueline**, which is what the product is sold as. The
spec table is where a customer sees the full brand.

### R1. ⚠ Two records left under `BLUELINE` deliberately
`IMG/DIS/00069` and `IMG/DIS/00137` — the `VRX1500/380 FG` and `VRX1800/380 FG` refrigerated
pizza displays. A different model prefix and a different product line from the SNACK/GN ranges,
and `brands.json` describes **Blueline** as an independent manufacturer while **Sheffield
Blueline** is Sheffield's own range. They may genuinely be another maker. **Needs a decision:**
if they move, the `blueline` brand has no products left and its brand page goes empty.

## S. Coffee Machines + Heat Lamps + Spiral Mixers — 2026-09-03 (categories 15-17)

### Harvested (8 rows, 6 records)
- `IMG/BUF/00023` / `00024` diameter **175 mm**, `IMG/BUF/00026` diameter **290 mm**. The
  diameter is in each product's *name* ("Heating Lamp Black Dia 175") but was absent from every
  spec table.
- `IMG/BUF/00272` power **270 W**; `IMG/BUF/00269` power 150 W, dimensions and colour.
- `IMG/PAS/00012` Prisma spiral mixer had **no dimensions**; live gives 385 x 415 x 795 mm.
Coffee Machines yielded nothing - our Dr. Coffee records are far richer than live.

### S1. `IMG/PAS/00003` Empero - our own record contradicts itself
The name reads *"Dough Mixer Spiral **50 Litres** Empero"*; its own spec says **65 L**, and the
live record agrees at 65 L. **The name is wrong, not the spec.** A rename, so it needs approval.

### S2. Model numbers contested
- `IMG/BUF/00272` - live `DL206`, ours `ZT001`.
- `IMG/PAS/00155` - live `HM-25`, ours `BM-25`.
- ⚠ `IMG/BUF/00023`, `00024` and `00244` all carry model **`A032`** - the black, gold and copper
  heat lamps share one model number. At least two must be wrong.

### S3. `IMG/COF/00054` Simonelli - live still carries the US build
Live shows `110V / 2000W / 18A`. That is the defect fixed on our side in section E1; our push
corrects it on live.

### S4. ⚠ `IMG/BUF/00259` stores its spec as a `<p>` list, not a table
11 records catalogue-wide do this. A row-adding tool that counts `<tr>` reads them as empty and
will append a bare `<tr>` into a paragraph list. Hit once here and reverted; the record already
held Model, Type, Shape, Material, Voltage and three dimension lines.
**Check for `<table>` before appending a spec row.**

## T. Semi-Automatic Coffee + Back Bar Coolers — 2026-09-03 (categories 18-20)

**31 rows harvested into 10 records** — the densest yield of the whole effort. The live site's
Rancilio spec sheets carry **dimensions and cup clearance for the entire Classe range**, which we
held for none of them:

| SKU | model | gained |
|---|---|---|
| `IMG/COF/00041` | Silvia | 235 x 290 x 340 mm, 14.5 cm cup clearance, 8.5/16 g baskets |
| `IMG/COF/00079` | Silvia Pro | 250 x 420 x 390 mm, cup clearance, 8.5/18 g baskets |
| `IMG/COF/00035` | Classe 5 S GR1 | 410 x 539 x 520 mm, cup clearance |
| `IMG/COF/00036` | Classe 5 ST GR1 | 410 x 539 x 520 mm, cup clearance |
| `IMG/COF/00037`/`00038` | Classe 5 S GR2 | 771 x 539 x 520 mm, cup clearance |
| `IMG/COF/00039` | Classe 7 S GR3 | 1010 x 540 x 520 mm, cup clearance, **boiler 16 L** |

⭐ **Cup clearance (14.5 cm) is a real buying criterion** on an espresso machine - it decides
whether a takeaway cup fits under the group - and we had it on none of the seven.

Back bar coolers gained `Temperature Range 2-10 °C` and `Voltage 220 V / 50 Hz` on all five.
`IMG/DIS/00024` (triple door) also gained its dimensions and power.

### T1. Conflicts, not adopted
- `IMG/DIS/00024` - live gives `Capacity 201 L`, which is the **double** door's figure; ours
  holds 303 L for a triple door with a 1335 mm body. Ours is right; live repeats the sibling.
- `IMG/COF/00079` Silvia Pro - live `1100 W`, ours `1300 W`. Neither adopted.

### T2. ⭐ The `Classe 5 S` vs `5 ST` difference is now recorded
Live states the S takes a `FIXED WATER CONNECTION` while the ST takes `FIXED WATER CONNECTION &
BUILT IN 2 LITRE WATER TANK`. That tank is the only functional difference between two otherwise
identical machines, and neither record said so. Now on both.

## U. Harvest into the source-blocked rows — 2026-09-04

A different cut from sections I–T. Rather than sweeping by category, this took the **82
published rows whose copy could not be written because the record held nothing** (see
`copy-blocked-on-source.md`) and asked the live site for each of them.

| | rows |
|---|---:|
| Source-blocked rows | 82 |
| Matched on the live site | 51 |
| Carrying a substantial live `technical_specification` | 26 |
| **Records rebuilt from live in this pass** | **18** |

⭐ **Eleven of the eighteen had no spec table at all on our side.** `IMG/HOT/00257`,
`IMG/HYS/00274`, `IMG/DIS/00144`, `IMG/BUF/00259`, `IMG/FPR/00079`, `IMG/HOT/00382`,
`IMG/HYS/00220` and `IMG/HYS/00221` went from zero informative rows to between four and ten.

⭐ **`IMG/REF/00204` was not the product our copy described.** Our record held only a
dimensions line. Live reveals a **dual-temperature cabinet — chiller over chest freezer**,
+10 to 0 °C above and ≤ -12 °C below, on R600a with copper-pipe cooling. Nothing in our copy
said the machine had two compartments.

⭐ **`IMG/HYS/00220` / `IMG/HYS/00221` are a knee-operated / manual pair.** Live states
"controlled water out of knee joint" for the YLS42 and "manually controlled water discharge"
for the YLS44B. That is the only functional difference between two otherwise identical basins
and neither record mentioned it.

Every dimension harvested **corroborated our stored values exactly** except where noted below.
Nothing was adopted over a disagreement.

### U1. `IMG/BUF/00249` TC-2F — the stored dimensions cannot be right
Both records say **29 × 23 × 22 mm**. The same live record gives a **526 × 324 mm heated
glass**, so the cabinet cannot be 29 mm across. The dimensions row has been **dropped from the
spec table rather than published**; stored `length`/`width`/`height` left untouched.
→ **Needs:** a tape measure.

### U2. `IMG/REF/00198` SD/SC-158Y — we were publishing internal dimensions as external
Live states *"Inner dimensions for 158L: ~ 600*700*800"*. Our record published that triple as
`Dimensions (W × D × H)` and stores it in `length`/`width`/`height`. Relabelled to **Internal
Dimensions** per the source. The external footprint is now unknown.
→ **Needs:** the external size. ⚠ Do not assume the stored fields are external.

### U3. `IMG/REF/00205` LCD-639 — temperature omitted, depth left open
Ours says a flat **-18 °C**; live says **dual temperature, "0 ~ 10 °C | ≤-22"**. Neither
published. Depth **790 (ours) vs 798 (live)** — ours retained so the stored fields and the
table stay in step. Harvested cleanly: dual-temperature configuration, cyclopentane
insulation, R290.

### U4. `IMG/FPR/00079` Z06A-N — dimension conflict, not adopted
Ours 542 × 427 × 810, live 548 × 431 × 811. Ours retained.
Live still carries the **three-market voltage list** that section E2 identified as this row's
original defect; only the 230 V / 50 Hz figure was taken. The US-catalogue bullets
("7.5 Gal of juice/hour", "Smokey gray front cover", "Customizable bins") were dropped.

### U5. `IMG/DIS/00144` LK-1.6BY — temperature range not credible
Live gives **"-2 °C to 20 °C"** for an ice cream display cabinet. A cabinet topping out at
+20 °C does not hold ice cream; the figure is almost certainly -2 to **-20**. Left out of the
rebuilt table and the copy, on the same reasoning as B5.
→ **Needs:** the factory figure.

### U6. `IMG/BUF/00259` D7016T — overall height contradicts its own food pan
Live gives overall **805 × 455 × 205 mm** and a food pan **600 × 410 × 240 mm**. A 240 mm pan
does not sit in a 205 mm body. Pan and stand sizes published; **overall dimensions omitted.**

### U7. ⚠ `IMG/FPR/00217` IB350CV — the live row mixes two products
It carries this machine's `POWER: 350 W / 240 V / 50 Hz` **and** a separate `Power: 500W`, under
model **`BLD300`** rather than IB350CV. Only the facts explicitly tied to the 350 W identity
were taken. The net weight (3.1 kg), the 4,000–16,000 rpm range and the 110 V/60 Hz line were
all left, because none can be attributed to this model while the row is in that state.
⚠ The 4,000–16,000 rpm range is identical to `IMG/FPR/00218` (IB500LV), which supports the
reading that the 500 W content belongs to that machine.
→ **Needs:** the live row split, or a supplier sheet for the IB350CV.

### U8. `IMG/PAS/00145` B30GA — speeds run together, model number disagrees with itself
Live reads **"3-Speed gear box 197317 & 462rpm"**, almost certainly 197 / 317 / 462 rpm but not
separated in the source. The three-speed gearbox is published; the figures are not.
Our own record also disagrees with itself: `model_number` is **B30GA2**, the spec table says
**B30GA**, and live says **B30GA**.
⚠ Live dimensions for this row are a `100 × 100 × 100` placeholder and were ignored.

### U9. `IMG/PAS/00102` HK-B7 — name and capacity disagree
The product name says **7 Litres**; the live spec says a **7.5 L** bowl. The spec figure is
published. A rename would need approval, so the name is untouched.

### U10. Garbled control strings on two fryers, not published
`IMG/HOT/00257` — *"Thermostat adjusts from 200°F to 204"* and *"400°F450°F hi-limiter"*.
`IMG/HOT/00388` — *"Thermostat adjusts from 450°F (232°C) hi-limiter guarantees safety"*,
which merges a thermostat range with a high-limit cut-out.
Neither row's thermostat range or hi-limiter figure was published.
⚠ `IMG/HOT/00388`'s first paragraph **was** the raw supplier string — 85 words of hyphen-joined
spec publishing to shoppers. Replaced with prose; the facts moved into the spec table.

### U11. Ten rows carried `<p><br></p>` spacers — fixed
Raw supplier imports separated paragraphs with an empty paragraph holding a `<br>`. These
render as a stray blank line on the PDP and counted as a paragraph against the standard.
All ten cleaned catalogue-wide: `IMG/FPR/00080`, `IMG/FPR/00140`, `IMG/FPR/00139`,
`IMG/DIS/00145`, `IMG/DIS/00144`, `IMG/BUF/00259`, `IMG/HOT/00382`, `IMG/HOT/00384`,
`IMG/HYS/00274` and one further row.

### U12. Still to sweep
Eight of the 26 rows with substantial live specification were not reached in this pass:
`IMG/DIS/00145`, `IMG/FPR/00140`, `IMG/HOT/00275`, `IMG/REF/00197`, `IMG/FPR/00239`,
`IMG/FPR/00093`, `IMG/BUF/00090`, `IMG/HOT/00195`.
The remaining 31 source-blocked rows do not match any live record, and **114 of the
catalogue's thin spec tables sit in categories the I–T category sweep never reached** — that
remains the larger seam.

## V. The un-swept categories are a much thinner seam than expected — 2026-09-04

Section U closed by naming the next target: *"114 of the catalogue's thin spec tables sit in
categories the I–T category sweep never reached — that remains the larger seam."* This section
tested that claim. **It does not hold.**

The 100 rows that still had a thin spec table in a never-swept category (down from 114 after
the U pass) were each looked up on the live site:

| | rows | |
|---|---:|---|
| Sweep target | 100 | thin spec, category never swept |
| Matched on the live site | 29 | |
| — with a substantial live specification | **8** | rebuilt, see below |
| — thin or empty on live as well | 21 | live knows no more than we do |
| Skipped as a multi-hit SKU | 1 | `IMG/HOT/00256` |
| **No live counterpart at all** | **70** | |

⚠ **The live site cannot supply 92 of these 100 rows.** Seventy of them do not exist there in
any addressable form, and twenty-one exist but are as empty as ours. The category sweep is not
a large remaining seam; sections I–T took most of what the live record had.

The rows with no live counterpart cluster hard by brand and by category:

| brand | rows | | category | rows |
|---|---:|---|---|---:|
| HK-REDLINE | 16 | | Kitchen Smalls > Pots & Pans | 9 |
| SHEFFIELD | 7 | | Ovens > Oven Accessories | 4 |
| STEELOLOGY | 6 | | Cooking Equipment > Fryers | 4 |
| KITCHENWARE | 6 | | Hygiene > Storage Containers | 4 |
| OEM SHEFFIELD | 5 | | Buffet & Servery > Bain Maries | 3 |
| RIMPAR | 4 | | Beverage Machines > Water Boilers | 3 |

That shape is consistent with section N: these are largely **house-brand and kitchen-smalls
lines that were never listed on the live site at all**, not a matching failure.

→ **Conclusion: the remaining catalogue gap is a supplier-data problem, not a sync problem.**
Further sweeping has little left to give. The chase-list in `copy-blocked-on-source.md` — 82
rows across 21 brands, 39 of them holding no specification whatsoever — is the work that
actually closes it.

### Harvested in this pass (8 records)

| SKU | model | gained |
|---|---|---|
| `IMG/DIS/00145` | LK-1.2DD | 12 × GN 1/4, 265 W, R290, dimensions — had no spec table |
| `IMG/FPR/00140` | JSJC-12 | fruit 40-90 mm, 20 oranges/min, 0.37 kW, 55 kg — had no spec table |
| `IMG/BUF/00151` | Santos 34-2A | 260 W, 230 V, 380 × 430 × 545 mm |
| `IMG/BUF/00152` | Santos 34-3A | 260 W, 230 V, 570 × 430 × 545 mm |
| `IMG/HOT/00275` | BS-4V | 4 pans, 1.5 kW, 220-240 V, 17 kg |
| `IMG/REF/00197` | BD/BC-388 | **capacity 388 L**, which the model number itself encodes |
| `IMG/FPR/00239` | QC205A | 5-disc set, 350 W, 220 V |
| `IMG/HOT/00195` | OT-10B-21 | 2.6 kW, 220 V |

### V1. `IMG/DIS/00145` LK-1.2DD — capacity omitted, same pattern as section L
Live gives **256 litres for both** the LK-1.2DD and the LK-1.6BY. This is the 1.2 m cabinet
taking **12** GN 1/4 pans against the 1.6 m cabinet's **18**. A shorter cabinet with two thirds
the pans does not hold the same volume — the identical figure is the copy-paste that section L
found across two whole ranges. Pan count published, litres not.
→ **Needs:** the real capacity for the 1.2 m model.

### V2. `IMG/FPR/00140` JSJC-12 — a voltage list mislabelled as watts
Live reads **"Power 220/120 W"** directly above **"Engine 0.37 kw"**. The first is a
two-market *voltage* list wearing a watts unit; the real power is 0.37 kW. Only the 220 V
figure was published, on the same reasoning as section E.

### V3. `IMG/HOT/00256` — skipped, multi-hit SKU
Resolves to more than one live row and was not read. Same class of problem as section N.

---

## W. Findings from the SAP-export × imports-workbook cross-read, 2026-09-07

Source folders the user pointed at this session: `Desktop\ecommerce\product sap source`
(18 per-namespace SAP exports) and `Desktop\ecommerce\products resorce final`
(44 brand folders, 558 spec PDFs).

⚠⚠ **First, a method correction that affects every "sources disagree" judgement below.**
SAP's `Item Remarks` and the IMPORTED ITEMS workbook's `Description` column are **one lineage,
not two sources.** Measured over the 39 §B1 SKUs: **18 byte-identical after normalisation,
9 more the same text lightly edited, only 12 genuinely different.** SAP agreeing with the
workbook is therefore *not* corroboration. Only a manufacturer or dealer source counts.

### W1. ✅ APPLIED — `IMG/HOT/00169` / `IMG/HOT/00170` were described as the wrong metal
Both rows read *"Stainless steel pressure cooker"*. Two independent sources say **aluminium**:
SAP Remarks (*"Heavy gauge aluminium construction … hard anodised aluminium"*) and the Amazon
"Time Saver Commercial Aluminium Cooker" listing already cited in
`broaster-geneva-rimpar-research.md`. Both rewritten to house format from the SAP remark, which
also supplied the three safety devices (locking handle, overpressure release valve, gasket
release window), the rustproof/polished/dishwasher-safe finish and the type.
⚠ **Tension left standing:** the model code `SSPC-*` reads as *Stainless Steel Pressure Cooker*.
The code is the only thing suggesting steel; the prose evidence is on the side of aluminium.
→ **Needs:** confirmation from the supplier, since it is a published material claim.

### W2. `GENEVA` is not the maker — and reassigning it empties the brand
The crosswalk established `SSPC-16/25/40/60` are H-Kitchen **"Timesaver"** units. `GENEVA` has
**exactly two products, both of them these**, so correcting the brand orphans the `GENEVA` row in
`brands.json` — the same outcome as `IBERNA`/`BROASTER` in the SAP reconciliation. The spec table
now names **Timesaver** as the brand while the `brand` field still says `GENEVA`.
→ **Needs a decision:** reassign to `H-KITCHEN` (and delete or keep the empty `GENEVA` brand), or
introduce `TIMESAVER` as a brand in its own right.

### W3. `IMG/DWW/00043` — the workbook row matched is a **different product** (false join)
Crosswalk §B1 joined our `JW-253` *Glass Rack Extender 25 Compartment* to Guangzhou `JW-25` on a
"near" match. They disagree on what the thing is: SAP says *"Rack Extender - 25 Compartment"*,
the workbook says *"Glass Rack Beige - **16 Compt**; Compartment size 90x90x45"*. 25 vs 16
compartments, extender vs rack. **`JW-25` is a 16-compartment beige glass rack; `JW-253` is the
25-compartment extender.** Do not apply the workbook figures to this SKU.

### W4. `IMG/HOT/00098` Roller Grill — power disagrees by ~40%, and one side looks estimated
SAP: *"Power / Gas rating~8 kW to 9 kW"*, outside 400 × 700 × 325, 12 L tank, 18 kg/hr, 34 kg,
190 °C. Workbook: *"RF 12 S ; **6.4KW 380V** (12 Liters) with cold zone"*, automatic oil filtering
by decanting. ⚠ The SAP text is littered with `~` approximations and reads as estimated rather
than transcribed; the workbook gives a definite nameplate figure. The model naming also differs
(`RFG 12` vs `RF 12 S`).
→ **Needs:** the Roller Grill datasheet. Nothing applied. Note `roller-grill/` exists in the
final research folder — check its PDFs before asking the supplier.

### W5. `IMG/BUF/00244` A032 heat lamp — colour conflicts, electricals agree
SAP *"230V/50hz/250W/dia: 175mm/**copper**"* vs workbook *"Retractable Heating Lamp;
230V/50hz/250W/dia: 175mm/**Black color**"*. The electrical figures and the 175 mm diameter agree
and are safe to publish; the colour does not, and our name says *Copper*. Probably a two-finish
variant sharing one code. The workbook also adds **retractable** and a 600-1500 mm height range,
which the record does not carry.
→ Apply the electricals; omit colour; confirm whether the finish is a variant.

### W6. `IMG/BUF/00051` TC-1 — the two sources disagree on what the product is
SAP says *"Induction Cooker"*, the workbook says *"Heating Pad"*. Our name says *Induction Cooker
Kassidy*. Neither side carries a single specification. Stays blocked; this is a supplier question,
not a writing one.

### W7. Additive detail found for rows that were flagged "no spec"
Where SAP and the workbook diverge, each usually holds something the other lacks — worth mining
rather than choosing between:

* `IMG/DWW/00107` Cambro — SAP gives **compartment size 45 × 45 × 72** and "peg rack, 64
  compartment"; the workbook gives chemical/temperature resistance to **200 °F**, one-direction
  plate loading, inter-stacking and an outside height of **4 in**. Together they are enough for a
  full write-up. (Row still carries `no price`.)
* `IMG/BUF/00027` / `IMG/BUF/00028` — SAP supplies the pan format the records lack:
  **2/3 GN round** for `AT50293`, **2/3 GN square** for `AT60293`.
* `IMG/COF/00009` — SAP adds output **21 litres/hour**; `IMG/COF/00010` adds **30 L/hr
  (200 cups/hr)**.

### W8. ⚠ `IMG/COF/00010` — do not apply its power rating, from either source
Both SAP and the workbook carry **"400V 3N/ 9000W"** on the 5-litre *serving station*. That is the
CQ Tower brewer's rating, which sits directly above it on the same sheet; an unheated vacuum
serving vessel has no 9 kW element. It is a copy-paste that propagated through both systems, and
is the clearest single proof that they share one lineage.

### W9. ✅ APPLIED — CREM dimension corrections
* `IMG/COF/00006` M2 — stored 205 × 410 × 428 matched no source. **205 × 360 × 430** applied: the
  SAP export, the workbook and the independent South African dealer in `crem-research.md` all give
  it (the dealer being the one that counts).
* `IMG/COF/00009` 2.5 L serving station — stored 206 × 274 × 436 came from the CREM product sheet
  alone. **220 × 220 × 440** applied on Parts Town's independent listing, which SAP/workbook
  (220 × 440) match. Its **weight row was dropped**: contested three ways at 1 kg / 2.5 kg /
  3.0-3.1 kg with nothing to settle it.
* `IMG/COF/00010` 5 L serving station — **left alone**. Four figures, no majority: Parts Town
  280 × 280 × 470, CREM sheet 483 × 325 × 373, CREM UK brochure H545/D460/W280, SAP/workbook
  300 × 500.
* `IMG/COF/00011` airpot — **left alone**, and a *new* conflict recorded: SAP and the workbook both
  say *"Chrome finish with black trim"* and *"**Glass** insulation"*, where our spec table says
  *stainless steel exterior* and *vacuum-insulated*. Glass-lined vs steel-lined matters to a buyer.
  ✅ The same remark settles the sight-gauge question in favour of the status quo: *"Has a glass
  sight gauge"* confirms the **"with Sight Gauge" in the name is real**. No rename needed.

### W10. `IMG/COF/00012` — spec written, but the name is still wrong
SAP and the workbook both give **1.9 litres / 12 cups / unbreakable stainless steel interior and
exterior / brew-through lid**, applied as the row's first ever spec table plus full copy. But
`crem-research.md` established the article is CREM's **"Thermos 1.9 L Stainless"** — a thermal jug,
not a percolator. Both our name and both source texts call it a percolator, because they share the
same ancestor. The new copy calls it a *thermal serving jug* and avoids claiming it percolates.
→ **Needs a rename decision** (`Thermos Percolator SS` → e.g. `Thermos Jug 1.9 Litres SS`), with
the slug pinned as in section D. Flag left as `named in open issues`.

### W11. The 558 spec PDFs are the unmined asset
`Desktop\ecommerce\products resorce final\` holds **558 manufacturer PDFs** already tied to a SKU
by filename — densest on sheffield-blueline (69), rational (53), taski (48), bilge (36), skymsen
(29), santos (29), hds (29), tecnodom (28), hk-redline (27), berjaya (20). These are the one source
that can close *"under 3 informative spec rows"* and *"sources disagree"* **without asking a
supplier**, and no pass has read them yet. Every brand folder also carries `_FINDINGS.md` (per-SKU
verdicts, proven resolution ceilings) and `_sourced.json` (per-image provenance with an
`agrees_with_sap` field that flags conflicts directly).
→ **Suggested next batch**, ahead of sending the supplier-request sheets.

---

## X. The live site's `name` and `model_number` are the wrong side — 2026-09-10

Found while auditing live product copy for descriptions that describe a different product. A
detector flagged 8 live descriptions naming another product's model code and never their own.
Three looked like clear copy defects and were corrected on live. **SAP then proved the copy was
right and the live `name` and `model_number` were wrong**, so all three writes were reverted the
same session and the live catalogue was verified byte-identical to its pre-session baseline.

⚠⚠ **The lesson: on the main site, do not treat `name` + `model_number` agreeing as corroboration.**
They share a lineage and can be wrong together. The description was written by us from
`products.json`, so it is an *independent* witness. Settle every such conflict with SAP first.

| SKU | SAP `Model Number` | our `products.json` | live `model_number` | live copy said |
|---|---|---|---|---|
| IMG/BUF/00272 | **ZT001** | ZT001 | DL206 ✗ | ZT001 ✓ |
| IMG/BUF/00274 | **DL206** | DL206 | ZT001 ✗ | DL206 ✓ |
| IMG/PAS/00103 | **B10GFA** | B10GFA | B10GA ✗ | B10GFA ✓ |
| IMG/HOT/00278 | **MDXZ-16** | MDXZ-16 | MDX15 ✗ | MDXZ-16 ✓ |
| IMG/BUF/00026 | **A035** | A035 | AO35S ✗ | A035 ✓ |
| IMG/BUF/00024 | **A032** | A032 | AO32G ✗ | A032 ✓ |
| IMG/BUF/00023 | **A032** | A032 | AO32B ✗ | A032 ✓ |
| IMG/BUF/00186 | **CPWK090-31** | CPWK090-31 | *(sku as model)* | CPWK090-1-31 |

⭐ `IMG/BUF/00272` and `IMG/BUF/00274` are **swapped on live in both fields at once** — the warmer
lamp carries the vegetable warmer's code and vice versa. That is a transposition of two records,
not two independent typos.
⚠ The three heat lamps show the live column substituting **letter O for digit zero** and appending
a colour letter (`A035` → `AO35S`). `A032` is genuinely shared by the black and the gold 175 mm
lamps in both SAP and our catalogue, so the colour suffix on live is an invention, not a finding.
⚠ `IMG/COF/00103`/`00104` are the one case SAP does **not** settle: SAP itself writes `FTL120 BLACK`
for one and `FLT120 INOX` for the other, our catalogue says `FLT120`, live says `FTL120`.
**SAP contradicts itself across two rows of the same family** — needs the manufacturer, KEF.

→ **Decision needed:** whether to write the SAP code back over the live `name` and `model_number`
on the seven settled rows. That is a `model_number` change, so it waits for approval per the
standing rule.

### X1. `IMG/BUF/00186` Thermo Box 6 GN Heated — copy belongs to a 90 litre carrier
Live id 1126 (6 GN, heated) and live id 1050 (3 GN) both publish the same
`CPWK090-1` 90-litre insulated carrier text, and neither mentions heating; the copy quotes a
passive range of -40 ºC to 80 ºC. Two different boxes cannot share one interior volume.
→ **Needs a source** for the 6 GN heated box before either row is rewritten.

### X2. Live id 1321 `SHAWARMA GAS RG-2` — copy is for a different machine
The description reads *"Electric kebab grill: The GR 80 E enables you to cook a spit of kebab or
gyros meat of 40 kg…"*. Wrong model and wrong fuel; the product is gas. This SKU is **live-only**,
absent from `products.json`, so there is no in-house copy to fall back on.
→ **Needs a source** (Roller Grill RG-2 gas specification).
