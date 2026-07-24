# Empero Product Research

Research notes behind the EMPERO enrichment/audit pass on `products.json` (July 2026).
Covers all 13 EMPERO SKUs, spanning seven very different product families: a vegetable
dryer, a potato peeler, a pizza oven, two spiral dough mixers, a bread slicer, a
pretzel/sandwich slicer, an electric water/steam grill, a charcoal grill, two food-service
trolleys, an Avatherm-brand thermotray, and a knife steriliser. Specs were sourced from
Empero's own PDF product manuals (`empero.com.tr/kilavuz/...`), Empero's own product
pages, and multiple independent resellers (Mariot Store, CafeMutfak, HorecaStore, Ekuep,
Empero Kosova, Stovia, Cafemarkt), then cross-checked against each other.

**Two of the thirteen records are confirmed contaminated with another product's copy**
(short_description, and in one case a mismatched spec paragraph). **One pizza oven record
mixes gas-variant features into what the manufacturer's own parts manual proves is the
wood-fired variant, and has a height dimension that is roughly double the true figure.**
**A recurring `width`/`height`-axis swap between the stored numeric fields and the stored
`technical_specification` prose was found on at least four SKUs** (this looks like a
general import-time bug, not an Empero-specific one, but is documented per-SKU below).
One dough mixer's stated capacity (150 kg) is provably wrong and traces to the same
error already present on the client's own predecessor site. No `model_number` was changed
by this pass — every code was individually verified against Empero's own literature or
flagged as unresolved. No image field was changed — image sourcing (§6) is presented as
links for manual review.

---

## 1. Brand identification

**Empero** = **Empero Endüstriyel Mutfak Ekipmanları Pazarlama İç ve Dış Ticaret A.Ş.**
("Empero Industrial Kitchen Equipment"), headquartered in **Konya, Turkey**. The company
traces to **1983**, starting as "Ersöz Kitchen Equipment"; in **2005** five affiliated
manufacturing companies were unified under the **EMPERO GROUP** brand. It is a genuine
manufacturer (500-1,000 staff, single production site in Konya), not a pure reseller,
though — like most large commercial-kitchen groups — it also distributes third-party
"imported products" alongside its own output (see the Avatherm note under §3.12/§4.10).

Product scope is broad: preparation equipment, cafeteria/service equipment, dishwashers,
cooking equipment (ovens, grills, ranges), refrigeration/display units, shelving, medical
equipment (hospital laundry, hand-wash stations), mobile/field kitchens ("Empero Mobile"),
and disinfection products. Export network: 300 domestic + 350 international sales points
across roughly 80 countries, ~60% of exports into Europe, plus a dedicated Kosovo
distributor site (`empero-ks.com`).

**⚠ `brands.json` currently lists `website_url` as `https://www.empero.com` — this is the
wrong domain.** `empero.com` is not the Turkish kitchen-equipment company; it resolves to
an unrelated/parked property (there is also an unrelated "Empero" AI research lab at
`empero.org`, confirmed irrelevant). **The real corporate site is `https://www.empero.com.tr`**
(English toggle: `empero.com.tr/index.php?dil=en`). Recommend correcting the domain in
`brands.json` (not changed here — out of scope for this products.json-only pass, but
flagged for the same manual-approval step).

This is a single-manufacturer situation for the Empero-branded lines in our catalogue
(potato peelers, dryer, dough mixers, bread/pretzel slicers, pizza oven, grills, banquet
trolley, meal-distribution trolley, knife steriliser all check out against Empero's own
PDF manuals or product pages under the `EMP.` / bare-code Empero naming scheme). **One
exception**: the "Avatherm" thermotray (§3.12) is manufactured by a *different* Turkish
company, **Ava Plastik** (brand "Avatherm", `avaplastik.com` / `avatherm.com.tr`) and sold
by Empero as an imported/distributed line — see the brand-attribution note there.

---

## 2. Where to look — and the traps

| Resource | URL | Notes |
|---|---|---|
| Official site | <https://www.empero.com.tr> (`?dil=en` for English) | Product category pages fetch cleanly; PDF manuals live under `/kilavuz/<family>/<code>-en.pdf` |
| Official PDF manuals | e.g. `empero.com.tr/kilavuz/hazirlik/ps-05-06-07-08-09-10-en.pdf` | **Gold-standard source** — full dimension/capacity/power tables per model, plus spare-parts lists that reveal which variants share/omit which components (used to settle the pizza-oven gas-vs-wood question, §4.3) |
| Empero Kosova (distributor) | <https://empero-ks.com> | Clean per-family comparison tables (e.g. all SH.01/02/03 mixers side by side) |
| Mariot Store, CafeMutfak, HorecaStore, Ekuep, Stovia, Cafemarkt, Kawaderstore | various | Independent resellers; generally clean spec tables and studio photos, occasional unit/price drift between them |
| **Sheffield Africa's own predecessor storefront** | `sheffieldafrica.com/kitchen/product/<id>/...` | **Important trap and confirmation tool**: this is the client's own prior live site. Several current `products.json` errors (wrong dough-mixer capacity, a differently-coded thermotray) were traced directly to this predecessor site still carrying the same numbers/codes — i.e. the current catalogue **inherited** these errors rather than introducing new ones. Also useful as a positive check: where its numbers agree with independent manufacturer/reseller sources, that's strong confirmation. |

### Traps

1. **Model-line proliferation.** Empero uses dense family codes (`PS.05`-`PS.10` peelers,
   `SH.01`-`SH.03`/`HY.05` mixers, `EMP.6LE010`-`EMP.6LE040` grills, `EMP.BQ1`-`BQ4`
   trolleys). Adjacent codes in the same family often differ only in one dimension
   (voltage, capacity, one axis of size) — easy to transpose a neighbouring model's spec
   onto the wrong code. This is exactly what happened to two SKUs in this catalogue (§4.1,
   §4.2).
2. **`-F` / `-AS` / `-W` suffixes matter and are not cosmetic.** `-F` on potato peelers
   means "with filter" (same capacity/power, added filter housing, taller). On the pizza
   oven, `-W` means **wood-fired** and `-AS` means "with stand" — confirmed definitively
   from the official spare-parts manual, where the `-W` variant's parts list has a
   "WOODHOUSE SHEET" and *no* burner/injector/gas-valve/gas-tank parts at all, while the
   plain (no-suffix) code has the full gas train. Do not assume a bare model name implies
   "the gas one" or "the base one" — check the suffix against the parts list, not just the
   marketing name a reseller gives it.
3. **Voltage/market variants.** Kenya wants 220-230 V single-phase where an option exists.
   Empero's own tables often show a 220 V variant *and* a 380 V three-phase variant under
   adjacent codes (e.g. potato peeler PS.09 = 1.5 kW/220 V single-phase vs PS.10 = 1.1
   kW/380 V — same tank/capacity, different motor/voltage). Confirm which specific code is
   being sold, not just the family.
4. **Reseller dimension drift.** Multiple independent resellers occasionally give slightly
   different overall dimensions for the same model (e.g. ±10-20 mm on the SH.03 mixer
   between Empero Kosova and Cafemarkt). Where an **official Empero PDF manual** exists,
   it was treated as authoritative over any reseller figure.
5. **The stored `technical_specification` HTML text and the stored numeric `width`/
   `height` fields disagree with each other on several SKUs**, and disagree with the
   manufacturer's own axis convention besides. See §4.6 for the consolidated finding —
   this pattern recurs across unrelated product families (a dough mixer, two trolleys, a
   knife steriliser), which suggests a general data-entry/import quirk rather than
   anything specific to Empero, but every instance is enumerated per-SKU below since only
   Empero was in scope for this pass.
6. **Avatherm is not Empero.** The "Avatherm" thermotray/thermobox range is manufactured
   by Ava Plastik and marketed independently at `avatherm.com.tr` / `avaplastik.com`.
   Empero (and Sheffield's own predecessor site) list it under their own catalogues as a
   distributed/imported line — treat "Avatherm"-branded specs as belonging to Ava Plastik,
   not to Empero's own engineering, when sourcing data.

---

## 3. Product reference

| # | SKU | Catalogue name (now) | Model | Official page | Verified against | Status |
|---|---|---|---|---|---|---|
| 1 | IMG/FPR/00234 | Salad and Vegetable Dryer 40 Lt 220V SY.40-09 | `SY.40-09` | [empero.com.tr](https://www.empero.com.tr/en/detay-vegetable-washing-and-dryer-machines-32) | [CafeMutfak](https://www.cafemutfak.com/en/product/empero-vegetable-and-salad-dryer-220v-40-lt-sy-40-09-521) | **Genuine, dims/power correct** |
| 2 | IMG/FPR/00008 | Potato Peeler 20 Kg Empero | `PS.09` | [empero.com.tr](https://www.empero.com.tr/en/detay-potato-peeler-machines-31) | Empero official PDF manual ([ps-05-06-07-08-09-10-en.pdf](https://www.empero.com.tr/kilavuz/hazirlik/ps-05-06-07-08-09-10-en.pdf)) | **Genuine model, but capacity/name/power wrong — see §4.1** |
| 3 | IMG/OVE/00219 | Gas Stone Base Pizza Oven EMP.SPO.H-70-W | `EMP.SPO.H-70-W` | [empero.com.tr](https://www.empero.com.tr/en/detay-odunlu-tas-tabanli-pizza-firinlari-205) | Empero official PDF manual ([emp-spo-h-60-70-plf-pls-d5-en.pdf](https://www.empero.com.tr/kilavuz/firin/emp-spo-h-60-70-plf-pls-d5-en.pdf)) | **Genuine model, but is the WOOD variant, not gas — see §4.3** |
| 4 | IMG/PAS/00003 | Dough Mixer Spiral 50 Litres Empero | `HY 05` | not found this pass — current site's "Dough Kneading Machines (with Wheels)" family (HY.05.K/HY.06.K = 50 kg, not 65 L) does not clearly match this code | [Mariot Store](https://mariotstore.com/shop/bakery-line/bakery-mixers/dough-mixer-hy-05/) | **Genuine model, capacity/dims wrong — see §4.4** |
| 5 | IMG/PAS/00007 | Dough Mixer Spiral 60 Litres Empero | `SH 03` | [empero.com.tr](https://www.empero.com.tr/en/detay-double-speed-spiral-dough-mixers-with-wheels-17) | [Empero Kosova](https://empero-ks.com/portfolio/spiral-dough-mixers-double-speed/), [Cafemarkt](https://www.cafemarkt.com/empero-sh-03-spiral-dough-kneading-machine-double-speed-60-kg-en) | **Genuine model, capacity claim wrong — see §4.2** |
| 6 | IMG/PAS/00002 | Bread Slicer Empero | `EMP.3004` | [empero.com.tr](https://www.empero.com.tr/en/detay-bread-slicer-machines-39) | [CafeMutfak](https://www.cafemutfak.com/en/product/empero-fry-top-bread-slicer-13-mm-emp-3004-13-2043) | **Genuine, specs correct; description has stray other-model text — see §4.5** |
| 7 | IMG/PAS/00005 | Pretzel & Sandwich Slicer | `EMP.3005` | [empero.com.tr](https://www.empero.com.tr/en/detay-pretzel-and-sandwich-slicer-machines-40) | [Mariot Store](https://mariotstore.com/shop/bakery-equipment/pretzel-sandwich-slicer-emp-3005/) | **Genuine, all specs confirmed correct** |
| 8 | IMG/HOT/00385 | Steam Cooker Grills Electric Empero | `EMP.6LE010` | [empero.com.tr](https://www.empero.com.tr/en/detay-electrical-vapor-grills-111) | [CafeMutfak (EMP.6LE020 family table)](https://www.cafemutfak.com/en/product/empero-electric-water-grill-60-series-emp-6le020-3734) | **Genuine, dims correct; power (3.75 kW) missing, add** |
| 9 | IMG/HOT/00400 | Lifted Charcoal Grill EMP.BTG.01 | `EMP.BTG.01` | [empero.com.tr](https://www.empero.com.tr/en/detay-lifted-charcoal-grills-180) | [CafeMutfak](https://www.cafemutfak.com/en/product/empero-elevator-coal-grill-emp-btg-01-2118) | **Genuine, dims confirmed correct; weight (160 kg) missing, add** |
| 10 | IMG/BUF/00009 | Banquet Trolley Hot Single EMP.BQ1 | `EMP.BQ1` | [empero.com.tr](https://www.empero.com.tr/en/detay-hot-banquet-trolleys-375) | Empero official PDF manual ([emp-bq1-2-3-4-en.pdf](https://www.empero.com.tr/kilavuz/hazirlik/emp-bq1-2-3-4-en.pdf)) | **Genuine model, power/weight wrong, width/height swapped — see §4.6** |
| 11 | IMG/BUF/00155 | Hot and Cold Meal Distribution Trolley 24 Tray | `EMP.MED.S.24-1/3` | [empero.com.tr](https://www.empero.com.tr/en/detay-hot-cold-meal-distribution-trolleys-383) | [Mariot Store](https://mariotstore.com/shop/uncategorized/hot-cold-food-distribution-carts-emp-med-s-24-1-3/) | **Genuine, tray size confirmed; width/height likely swapped — see §4.6** |
| 12 | IMG/BUF/00099 | Avatherm Thermotray with Locks | `AVT-PP-LCK` | n/a — manufactured by Ava Plastik, not Empero (see §1/§4.7) | Sheffield's own predecessor listing (same item #, model shown as `UGC TT6`) | **Model-code discrepancy — unresolved, see §4.7 — do not change without approval** |
| 13 | IMG/HYS/00003 | Knife Sterilizer EMP.BST.001 | `EMP.BST.001` | [empero.com.tr](https://www.empero.com.tr/en/detay-knife-sterilizer-43) | [HorecaStore](https://horecastore.ae/products/empero-emp-bst-001-knife-sterilizer-capacity-10-knives-1-kw-55-2-x-13-1-x-62-cm) | **Genuine, dims scrambled on both stored fields and spec text — see §4.6** |

---

## 4. Data audit — errors found and corrected

### 4.1 Potato Peeler PS.09 (IMG/FPR/00008) — the flagged contamination, confirmed real ⚠

This is the SKU flagged in the brief as suspicious, and it is indeed contaminated, though
in a narrower way than first appears:

- **`short_description` is entirely wrong-product copy**: *"SYSTEMATIC JSPCC-08 commercial
  potato chipper on stand for french fry preparation..."* — SYSTEMATIC is a different
  brand, JSPCC-08 a different model, "chipper" is a different machine class from
  "peeler." **This exact sentence is copy-pasted onto at least eight other unrelated SKUs
  across the catalogue** (`FAB/FPR/00241`, `FAB/FPR/00315`, `FAB/FPR/00372`,
  `FAB/FPR/00435`, `FAB/FPR/00458`, `IMS/MEC/00309`, `IMS/MEC/00312`, plus this one) —
  it is a pre-existing templated bug affecting the whole Potato Processors category, not
  something specific to Empero. Flagged here for this SKU; a full fix would need a
  separate cross-brand pass.
- **`description`/`technical_specification`, by contrast, are genuinely about a peeler**
  (not chipper) and are mostly right, but the **capacity is wrong**: name and body both
  say **"20 kg"**; Empero's own PDF manual ([ps-05-06-07-08-09-10-en.pdf](https://www.empero.com.tr/kilavuz/hazirlik/ps-05-06-07-08-09-10-en.pdf), Table A2) states
  **PS.09 = 30 kg capacity**, tank 500×500 mm (which the record *does* state correctly).
  PS.07/PS.08 are the 20 kg-capacity codes in this family — this looks like a one-step
  slip to the neighbouring capacity tier, the same failure mode as the Pasmo pass's
  scrambled-dimension errors.
- **Motor power is a PS.09/PS.10 blend**: the record says *"1.1kW 900 rpm-220V/380V"*.
  Empero's manual gives **PS.09 = 1.5 kW at 220 V only**; **PS.10 = 1.1 kW at 380 V only**
  (same tank/capacity, different motor/voltage pairing). The stored figure mixes the two.
- **Overall dimensions are close but not exact**: record gives 552×800×1168 mm; Empero's
  manual gives **600×870×1160 mm** for PS.09 (weight 58 kg, packaging 700×950×1300 mm).
  Height is close (1168 vs 1160) but length/width are off by 48-70 mm each.
- Model code `PS.09` itself is **genuine and correctly a peeler** — no change proposed to
  `model_number`.

### 4.2 Dough Mixer Spiral 60 L (IMG/PAS/00007) — capacity figure traced to a legacy error ⚠

- Record's `description`/`technical_specification` state **capacity "150kg"**. This is
  provably wrong: Empero's own comparison table (Empero Kosova) and an independent
  reseller (Cafemarkt) agree that **SH.03 = 60 L bowl / 35 kg flour capacity** (dims
  620×1040×1100 mm or 637×1040×1105 mm per Cafemarkt, 1.5-2.5 kW dual-speed motor,
  750/1500 rpm, 380 V three-phase, ~240-245 kg machine weight).
- **The "150kg" error already exists on Sheffield's own predecessor site**
  (`sheffieldafrica.com/kitchen/product/724/spiral-dough-mixer-150kg-sh-03-60l`, same item
  number `IMG/PAS/00007`) — confirming this is an inherited data error, not one introduced
  in the current catalogue.
- The catalogue **name** ("...60 Litres Empero") is correct — 60 L is the bowl volume, and
  matches Empero's own model-family naming. Only the "150kg" capacity claim in the body
  copy is wrong; recommend correcting to 35 kg flour / ~60 kg dough capacity.
- No dimensions or power are currently stored for this SKU at all (top-level
  length/width/height are absent) — an opportunity to add the verified 620×1040×1100 mm /
  1.5-2.5 kW / 750-1500 rpm / 380 V / ~245 kg figures.
- Model code `SH 03` genuine, unchanged.

### 4.3 Gas Stone Base Pizza Oven (IMG/OVE/00219) — wrong fuel type and a doubled height ⚠

- **The "-W" suffix means wood-fired, not gas.** Confirmed definitively from Empero's own
  spare-parts manual ([emp-spo-h-60-70-plf-pls-d5-en.pdf](https://www.empero.com.tr/kilavuz/firin/emp-spo-h-60-70-plf-pls-d5-en.pdf)): the `EMP.SPO.H-70-W` parts list
  includes a **"WOODHOUSE SHEET"** and contains **no burner, no injector, no gas valve, no
  gas tank, no piezo/battery lighter** — all present in the plain `EMP.SPO.H-70` (no
  suffix) parts list, which is the gas variant. The catalogue's own name — **"Gas Stone
  Base Pizza Oven EMP.SPO.H-70-W"** — is self-contradictory: a wood-fired model is being
  called "Gas."
- **The description content is also gas-variant text wrongly attached to the wood model**:
  "Adaptable to LPG or NG," "Piezo lighter ignition system," "Magnet safety valve" are all
  features of the gas oven's operation manual (control panel A/B/C = flame
  setting/lighter/thermostat, injector-change tables for G20/G25/G30/G31 gases) — none of
  which apply to the `-W` wood-fired unit per its own parts list.
- **Height dimension is roughly double the true figure.** Record states 850×920×**1450**
  mm. Empero's manual gives **EMP.SPO.H-70-W = 857×922×828 mm**, weight 110.5 kg,
  packaging 950×1000×1000 mm. Length/width are a close match (850×920 vs 857×922); height
  (1450 vs 828 mm) is not — 1450 mm looks like it may have been conflated with an
  oven-plus-stand combination (Empero sells a separate `-AS` stand accessory, itself
  ~822 mm tall, but the two heights don't simply add to 1450 either) rather than the
  countertop unit alone.
- Power (11 kW) and 0-500°C thermostat are correctly stated and match the manual (NG:
  11.00 kW / LPG: 11 kW, operating range 500°C — though this is the shared -60/-70 gas
  table; the wood model doesn't carry a kW gas rating at all, so "11kW" is itself a
  leftover from the gas variant, not a wood-oven figure).
- Internal stone diameter (600 mm) / internal height (265 mm) / door size (360×200 mm) in
  the description could not be verified against the manual (which gives only the pizza
  stone panel size — 698×349×20 mm for the H-70 family — not a chamber-internal diameter)
  — left as unverified rather than corrected.
- Model code `EMP.SPO.H-70-W` genuine and correctly identifies a real product; the
  **fuel-type labelling and the height figure** are what need correcting.

### 4.4 Dough Mixer Spiral "50 Litres" (IMG/PAS/00003) — self-contradicting capacity + wrong dims ⚠

- **Name says "50 Litres"; the record's own description says "Capacity lt 65"** — an
  internal contradiction. Independent confirmation (Mariot Store) gives **HY.05 = 65 L
  bowl / 30 kg flour capacity** — so the description is right and the product **name** is
  wrong; recommend renaming to "65 Litres."
- **Dimensions do not match any source found.** Record: 668×791×963 mm (with the stored
  `technical_specification` text scrambling width/height further to 668×963×791 — see
  §4.6). Independent reseller (Mariot Store) states **HY.05 = 500×820×740 mm**, 140 kg net
  weight, bowl 600 mm diameter/290 mm depth, motor 0.75 kW/1400 rpm/220-380 V — all of
  which match the record's *power* figures (0.75 kW/1400 rpm/220-380 V, bowl 600/290 mm)
  but not its *dimensions* on any axis. Flagged for correction to 500×820×740 mm, pending
  one more independent confirmation before applying (only one reseller source found for
  this specific figure).
- Model code `HY 05` genuine, unchanged.

### 4.5 Bread Slicer EMP.3004 (IMG/PAS/00002) — correct product, stray other-model text

- All specs check out against CafeMutfak's EMP.3004-13 listing: 0.37 kW, 1400 rpm, 220 V,
  480 mm bread length, 130 mm bread height, **13 mm slice thickness, 30 blades** — this is
  precisely the "-13" variant of the EMP.3004 line, correctly represented. Dimensions
  650×650×700 mm not independently re-confirmed but not contradicted by any source found.
- **However, the stored `description` field appends an unrelated paragraph**: *"EMP.3001-10
  - 13 mm slice thickness - 30 stainless steel blades."* `EMP.3001` is a **different**
  Empero bread-slicer line from `EMP.3004` (confirmed distinct model families via
  CafeMutfak's catalogue), and independently, EMP.3001-10 is itself a 10 mm-thickness
  variant by its own product name — so this trailing paragraph is wrong on two counts (wrong
  model family, and internally contradicts the "-10" in its own name by claiming 13 mm).
  Recommend removing this paragraph rather than trying to reconcile it.
- Model code `EMP.3004` genuine, unchanged.

### 4.6 Recurring width/height-axis inconsistency — four SKUs affected

On four unrelated SKUs, the stored numeric `width`/`height` fields, the stored
`technical_specification` HTML prose, and the true manufacturer dimensions do not all
agree with each other in the same way twice — this looks like a general data-handling
issue rather than anything Empero-specific, but is catalogued per-SKU since only Empero
was in scope:

- **IMG/PAS/00003 (HY 05 mixer)**: top-level fields (width 791/height 963) and the prose
  spec (width 963/height 791) simply swap the same two numbers relative to each other; as
  established in §4.4, *neither* ordering matches the verified 820×740 mm figure anyway.
- **IMG/BUF/00009 (EMP.BQ1 banquet trolley)**: Empero's own PDF manual gives **720×885×1810
  mm** (L×W×H). The record's `technical_specification` prose (717/888/1803) is
  **essentially correct** (width ≈ 885→888, height ≈ 1810→1803). But the **top-level
  fields have width and height swapped** (stored as width=1803, height=888 — backwards).
  Recommend correcting the top-level fields to match the (correct) prose: width ≈ 888 mm,
  height ≈ 1803-1810 mm. Also see §4.6.1 below for the power/weight errors on this SKU.
- **IMG/BUF/00155 (24-tray meal distribution trolley)**: same pattern — top-level
  (width=1684, height=768) vs prose (width=768, height=1684). No independent overall-
  dimension source was found to confirm which is correct, but given the identical failure
  mode confirmed on the sibling BQ1 trolley (where the prose matched the manufacturer),
  the **prose ordering (width ≈ 768, height ≈ 1684 mm) is more likely correct** — flagged
  for confirmation rather than asserted.
- **IMG/HYS/00003 (EMP.BST.001 knife steriliser)**: this one is scrambled worse. Verified
  manufacturer dimensions (HorecaStore, matching Empero's own manual per ManualsLib
  listing) are **552 (L) × 131 (W) × 620 (H) mm**. The record's top-level fields
  (length=620, width=131, height=552) have **length and height swapped** relative to the
  true figures (width happens to be correct). The stored prose text (LENGTH 620/WIDTH
  552/HEIGHT 131) is a **different, unrelated scramble** that doesn't match the true
  figures on any axis. Recommend correcting to length=552, width=131, height=620 mm
  throughout.

#### 4.6.1 EMP.BQ1 banquet trolley — additional power/weight errors

Beyond the width/height field swap above, Empero's own PDF manual
([emp-bq1-2-3-4-en.pdf](https://www.empero.com.tr/kilavuz/hazirlik/emp-bq1-2-3-4-en.pdf)) gives definitive EMP.BQ1 figures that the record's `description`
gets wrong on two more points:

- **Power: record says "1,7Kw / 230V"; manual states 3.25 kW**, 220-230 V, 50-60 Hz,
  3×2.5 mm² cable, 11×GN2/1 capacity. The record understates power by roughly half.
- **Weight: record says 111 kg; manual states 124 kg.** Minor but worth correcting.
- Isolation density (40 kg/m³) and 11×GN2/1 capacity in the record are both correct.

### 4.7 Avatherm Thermotray (IMG/BUF/00099) — a model-code discrepancy, left unresolved ⚠

- The current record's `model_number` is `AVT-PP-LCK`. **Sheffield's own predecessor
  storefront**, listing the *same item number* (`IMG/BUF/00099`), shows the model code as
  **`UGC TT6`** instead, describing an identical product (6-compartment thermotray, side
  lock system with replaceable locks) — confirmed via an independent source describing
  "the AVATHERM UGC TT6" in the same terms.
- It was not possible to determine with confidence whether `AVT-PP-LCK` is (a) a genuine
  alternative/internal code for the same physical product (a plausible reading: **AV**atherm
  – **P**oly**p**ropylene – **L**o**CK**), (b) a different but related SKU in the Avatherm
  range, or (c) a transcription error. Ava Plastik's own English-language site
  (`avatherm.com.tr`) could not be fetched (expired TLS certificate at time of writing) to
  settle this directly.
- **Per project convention, `model_number` is not changed here.** This is flagged for
  manual review/approval — someone with access to an actual delivery note, packing
  label, or the manufacturer directly should confirm which code is correct before any
  change is applied.
- Dimensions (length 530, height 380 mm, width missing) are not contradicted by any source
  found; the missing `width` could not be sourced from any listing (all describe the
  6-compartment/lock features but not a full W dimension) — left blank rather than guessed.
- Brand attribution: **the true manufacturer is Ava Plastik ("Avatherm"), not Empero**,
  though Empero's own catalogue (and Sheffield's predecessor site) both list it under an
  "Empero" brand banner as a distributed/imported product — see §1 and §2 trap 6. No
  change to `brand` proposed; this is presented as context, not an error.

---

## 5. Not published / unverified — left out rather than invented

- **PS.09 peeler**: could not find the exact overall-dimension figure independently
  corroborated beyond Empero's own single manual table; treated as authoritative but not
  cross-confirmed by a second source.
- **EMP.SPO.H-70-W pizza oven**: internal stone diameter (600 mm), internal chamber height
  (265 mm), and door dimensions (360×200 mm) as currently stated in the description could
  not be confirmed or refuted from Empero's own manual (which gives only the external pizza
  stone panel size, 698×349×20 mm, not an internal chamber diameter/height/door size) —
  left as-is rather than invented or removed.
- **HY 05 mixer**: only one independent source (Mariot Store) was found for the corrected
  500×820×740 mm dimension; recommend one further confirmation before applying.
- **EMP.MED.S.24-1/3 trolley**: no independent source was found for overall machine
  dimensions (only tray size 575×325 mm was corroborated); the likely width/height swap
  (§4.6) is inferred from the sibling BQ1 trolley's confirmed pattern, not independently
  verified for this specific model.
- **Avatherm thermotray**: width dimension, and the `AVT-PP-LCK` vs `UGC TT6` model-code
  question, both unresolved (§4.7).
- **EMP.6LE010 grill / EMP.BTG.01 grill**: net vs gross weight breakdowns not found beyond
  the single figures already noted; not invented.

---

## 6. Image sourcing — for manual review

No image field was changed this pass. Links below are for manual review only, ranked by
source quality where multiple were found. Official Empero PDF manuals do not embed
usable product photos (line-art spare-parts diagrams only), so photography is sourced from
resellers who carry official studio images.

| SKU | Model | Best source(s) for manual review |
|---|---|---|
| IMG/FPR/00234 | SY.40-09 | [CafeMutfak](https://www.cafemutfak.com/en/product/empero-vegetable-and-salad-dryer-220v-40-lt-sy-40-09-521) — clean studio shot, exact model |
| IMG/FPR/00008 | PS.09 | [eBay listing, "Empero 30kg Potato Peeler PS.09 - Brand New"](https://www.ebay.co.uk/itm/224828705706) — exact model, boxed/product photo; also compare against sibling codes on [Empero Kosova's Potato Peelers page](https://empero-ks.com/portfolio/potato-peelers/) |
| IMG/OVE/00219 | EMP.SPO.H-70-W | [Cafemarkt — "Wood-Fired, Black"](https://www.cafemarkt.com/empero-spoh-70-home-type-pizza-oven-with-stone-floor-wood-fired-black-en) — **use the Wood-Fired listing, not the Gas one**, given §4.3 |
| IMG/PAS/00003 | HY 05 | [Mariot Store](https://mariotstore.com/shop/bakery-line/bakery-mixers/dough-mixer-hy-05/) |
| IMG/PAS/00007 | SH 03 | [Cafemarkt](https://www.cafemarkt.com/empero-sh-03-spiral-dough-kneading-machine-double-speed-60-kg-en) |
| IMG/PAS/00002 | EMP.3004 | [CafeMutfak — EMP.3004-13](https://www.cafemutfak.com/en/product/empero-fry-top-bread-slicer-13-mm-emp-3004-13-2043) — matches the 13 mm/30-blade variant on record |
| IMG/PAS/00005 | EMP.3005 | [Mariot Store](https://mariotstore.com/shop/bakery-equipment/pretzel-sandwich-slicer-emp-3005/); also [CafeMutfak](https://www.cafemutfak.com/en/product/empero-bagel-and-sandwich-cutting-machine-emp-3005-1800) |
| IMG/HOT/00385 | EMP.6LE010 | [CafeMutfak — EMP.6LE020 family page](https://www.cafemutfak.com/en/product/empero-electric-water-grill-60-series-emp-6le020-3734) shows the 60-series lineup including 6LE010; also Sheffield's own predecessor page (same item #) at `sheffieldafrica.com/kitchen/product/1078/` |
| IMG/HOT/00400 | EMP.BTG.01 | [CafeMutfak](https://www.cafemutfak.com/en/product/empero-elevator-coal-grill-emp-btg-01-2118) |
| IMG/BUF/00009 | EMP.BQ1 | [Ekuep](https://www.ekuep.com/en/empero-emp-bq1-hot-banquet-trolley); [HorecaStore](https://horecastore.ae/products/empero-emp-bq1-hot-banquet-trolley-11-x-gn-2-1-tray-capacity-1-7-kw-71-7-x-88-8-x-180-3-cm); [Stovia](https://www.stovia.com/en/emp-bq1-empero-emp-bq1-hot-banquet-trolley-single-door-11-gn-2-1.html) |
| IMG/BUF/00155 | EMP.MED.S.24-1/3 | [Mariot Store](https://mariotstore.com/shop/uncategorized/hot-cold-food-distribution-carts-emp-med-s-24-1-3/) |
| IMG/BUF/00099 | AVT-PP-LCK / UGC TT6 | Existing gallery image already on record; cross-reference [Sheffield's own predecessor page](https://www.sheffieldafrica.com/kitchen/product/517/avatherm-thermotray-with-locks-ugc-tt6) before sourcing any replacement, given the unresolved model-code question (§4.7) |
| IMG/HYS/00003 | EMP.BST.001 | [HorecaStore](https://horecastore.ae/products/empero-emp-bst-001-knife-sterilizer-capacity-10-knives-1-kw-55-2-x-13-1-x-62-cm); [CafeMutfak](https://www.cafemutfak.com/en/product/empero-knife-sterilizer-10-blades-emp-bst-001-870); [Mariot Store](https://mariotstore.com/shop/food-processing/knife-sterilizers/knife-sterilizers-emp-bst-001/) |

---

## 7. Summary of proposed changes for `products.json`

All 13 SKUs individually re-verified; **no `model_number` changed** (all confirmed genuine
except the Avatherm thermotray, whose code is flagged as unresolved rather than corrected).

- **IMG/FPR/00008 (PS.09 peeler)**: fix `short_description` (currently wrong-product
  filler shared with 7 other SKUs); correct capacity 20 kg → **30 kg** in name/body;
  correct power to **1.5 kW / 220 V** (drop the 1.1 kW/380 V figure, which belongs to
  PS.10); correct dimensions to **600×870×1160 mm**, add weight 58 kg.
- **IMG/PAS/00007 (SH 03 mixer)**: correct capacity claim "150kg" → **35 kg flour / ~60 kg
  dough**; add dimensions **620×1040×1100 mm**, power **1.5-2.5 kW**, 750/1500 rpm dual
  speed, 380 V, weight **~245 kg** (currently no dims/power stored at all).
- **IMG/OVE/00219 (pizza oven)**: relabel as **wood-fired**, not gas (rename + rewrite
  description to drop LPG/NG/piezo/gas-valve content, which belongs to the plain
  `EMP.SPO.H-70` gas variant); correct height **1450 → 828 mm** (length/width already
  close to correct at 850×920 vs true 857×922); reconsider whether the "11 kW" gas power
  figure belongs on a wood-fired record at all.
- **IMG/PAS/00003 (HY 05 mixer)**: rename "50 Litres" → **"65 Litres"** (matches the
  record's own description text and independent sourcing); correct dimensions
  **668×791×963 → 500×820×740 mm** (pending one further confirmation, §5).
- **IMG/PAS/00002 (bread slicer)**: remove the trailing "EMP.3001-10" paragraph from
  `description` — wrong model family, and internally self-contradictory.
- **IMG/BUF/00009 (EMP.BQ1 trolley)**: swap top-level `width`/`height` (currently
  width=1803/height=888, should be width≈888/height≈1803-1810); correct power **1.7 kW →
  3.25 kW**; correct weight **111 kg → 124 kg**.
- **IMG/BUF/00155 (24-tray trolley)**: likely needs the same top-level `width`/`height`
  swap as BQ1 (width≈768/height≈1684) — flagged for confirmation, not asserted as certain
  (§4.6, §5).
- **IMG/HYS/00003 (knife steriliser)**: correct all three axes to **length=552, width=131,
  height=620 mm** (current top-level and prose values are both wrong, in different ways).
- **IMG/BUF/00099 (Avatherm thermotray)**: **do not change `model_number`** — surface the
  `AVT-PP-LCK` vs `UGC TT6` discrepancy to the team for a decision with better source
  material (packing label / manufacturer contact) before touching it.
- **IMG/FPR/00234 (SY.40-09 dryer)**, **IMG/PAS/00005 (EMP.3005 slicer)**, **IMG/HOT/00385
  (EMP.6LE010 grill)**, **IMG/HOT/00400 (EMP.BTG.01 grill)**: verified correct as stored;
  only minor additions proposed (EMP.6LE010 power 3.75 kW; EMP.BTG.01 weight 160 kg) and,
  for the dryer, a copy-quality note that its `short_description` never mentions Empero
  (generic filler, not factually wrong — lower priority than the contaminated records
  above).
- **No image field changed** — §6 links presented for manual review. All 13 records
  remain in their current `status`.
