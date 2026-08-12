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
