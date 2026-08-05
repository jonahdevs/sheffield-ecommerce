# Dr. Coffee Product Research

Research notes behind a DR. COFFEE enrichment/audit pass on `products.json` (July 2026).
Covers all 3 DR. COFFEE SKUs: two fully-automatic bean-to-cup machines (F11 BIG, MINIBAR)
and one counter refrigerator sold as an accessory (SC15).

**No `products.json` or `brands.json` changes have been applied** - this file is findings
only, same starting point as the Brema/Santos passes before a scope decision.

Headline: this is the **best-documented brand researched so far** - the manufacturer
publishes a real English spec table for every model, plus a variant-labelled hi-res photo
library. Everything below is confirmed against that primary source. Despite that, all
three records carry the **same width/height numeric swap** seen on Santos/Brema/Empero,
the F11's numeric dimensions are the **shipping carton** rather than the machine, and the
SC15 has **two values copied from its sibling models** plus a **naming/food-safety
problem** (§4.3, §5).

---

## 1. Brand identification

**Dr.Coffee** = **Suzhou Dr.coffee System Technology Co., Ltd.**, a Chinese manufacturer of
commercial and household fully-automatic coffee machines. Site copyright line reads
"Copyright © 2021 Suzhou Dr.coffee System Technology Co., Ltd."; the company states its
products reach 100+ countries.

- `brands.json` `website_url` is **https://www.drcoffee.com** - **correct and live**
  (HTTP 200, fully English, current product catalogue). No change needed.
- The company also runs **https://www.dr-coffee.com** (linked from its own footer) as a
  parallel domain. Not needed - `.com` is the primary.
- Located in **Suzhou, Jiangsu** (not Shanghai and not Zhejiang - both appear in third-party
  write-ups). The Shanghai association comes from marketing/events copy ("Shanghai by the
  Pujiang River", PCA Shanghai), not the corporate registration.
- **Casing note** (per the brand-name-casing convention): the manufacturer styles itself
  **"Dr.coffee"** - lowercase `c`, no space - in its own wordmark and legal name.
  `brands.json` currently has `"name": "Dr. Coffee"` and `products.json` uses
  `"brand": "DR. COFFEE"`. Flagged only, not changed.

---

## 2. Where to look

| Resource | URL pattern | Value |
|---|---|---|
| Product overview | `drcoffee.com/<category>/<model>.html` | Feature copy, brew system, burrs, IoT |
| **Spec table (gold standard)** | `drcoffee.com/specifications/<model>.html` | Full technical sheet **plus** the series-variant table |
| **Variant photo library** | `drcoffee.com/p-<category>/<model>.html` | Hi-res product shots **labelled per variant/angle**, with direct download links |
| Accessories | https://www.drcoffee.com/accessories/ | Every accessory's spec block on one page |
| Accessory photo library | https://www.drcoffee.com/p-accessories/milk-fridge.html | Labelled hi-res shots of SC08/SC10/SC12/SC15/SC05 |
| Sitemap | https://www.drcoffee.com/sitemap.xml | 259 URLs; the fastest way to find the `p-` photo pages |

Categories used by the site: `ocs/` (office), `cvs-ho-re-ca/` (convenience store + HoReCa),
`coffee-shop/`, `home_pro/`, `accessories/`. **The F11 lives under `ocs/`, the Minibar under
`cvs-ho-re-ca/`** - they are not in the same section despite both being in our
"Coffee Machines > Automatic" category.

### Traps

1. **One spec table covers a whole series.** `specifications/f11.html` gives a single column
   of numbers - `30*50*58 cm`, `15.5 kg`, water tank `2/8` L. Those are the **standard F11**
   (2 L tank). The **F11 Big** is a physically different, deeper cabinet (410 mm vs 300 mm)
   and heavier (17 kg vs 15.5 kg) because the 8 L tank hangs off the side. Do **not** copy
   the series table's dimensions onto the Big variant. See §4.1.
2. **The real orderable model codes live in the "Series model" block** at the bottom of each
   spec page, not in the page title. F11 → `F11 / F11 Big / F11 Plus / F11 Big Plus / F11 Pro`.
   Minibar → `Minibar-S / Minibar-S1 / Minibar-S2`. Our bare `MINIBAR` model_number matches
   none of those exactly (§4.2).
3. **Feature graphics are shared verbatim across product pages.** Five of the images pulled
   off the F11 page are byte-identical (same MD5) to images on the Minibar page - they are
   generic "ceramic burrs / 9 grind sizes / pre-brewing" artwork, not model-specific. Only
   the `p-<category>/` photo pages carry genuinely per-model imagery.
4. **The F11 user manual PDF is a scanned image** (https://www.drcoffee.com/data/upload/main/20250814/689d43797e0a8.pdf,
   10 MB) - `pdftotext` returns nothing. Unlike the Santos leaflets, `Read` on it is not
   worth the pages; the HTML spec table is better anyway.
5. **The `_` suffix on image filenames is the thumbnail.** `...6880a7d22b980_.jpg` is a
   ~90 KB display copy; **dropping the underscore** (`...6880a7d22b980.jpg`) returns the
   full-resolution original (up to 500 KB, 1500 px wide). Same trick works on the accessories
   page (SC15 went from a 16 KB 130-px thumbnail to a 443 KB 1500-px white-background shot).

---

## 3. The width/height swap - all three SKUs, again

Every one of the three records has a **prose `technical_specification` table that is
correct** and **numeric `length`/`width`/`height` fields that are not**:

| SKU (model) | Numeric L/W/H stored | Prose table says | Manufacturer (W×D×H) | Verdict |
|---|---|---|---|---|
| 00099 (F11 BIG) | 520 / 620 / 680 | 410 × 500 × 580 | 410 × 500 × 580 | numeric fields are the **carton**, not the machine (§4.1) |
| 00096 (MINIBAR) | 340 / 620 / 545 | 340 × 545 × 620 | 340 × 545 × 620 | **W↔H swapped** |
| 00097 (SC15) | 252 / 450 / 512 | 252 × 512 × 450 | 252 × 512 × 450 | **W↔H swapped** |

Same signature as the Santos (7 of 8 SKUs), Brema (2 of 5) and Empero passes: the prose
string was transcribed correctly and the numeric fields were filled in from a differently
ordered source. On the Minibar and SC15 the fix is a straight `width`↔`height` exchange.
On the F11 it is not a swap at all - see below.

---

## 4. Per-SKU findings

### 4.1 F11 BIG (IMG/COF/00099) - prose specs good; numeric dimensions are the shipping carton

**Manufacturer's F11 series technical sheet** (https://www.drcoffee.com/specifications/f11.html):

| Field | Official (F11 series) |
|---|---|
| Advised daily output | 100 cups |
| Hourly output | 70 cups |
| Water tank | 2 / 8 L (2 L standard, **8 L = "Big"**) |
| Bean hopper | 1200 g × 1 |
| Powder hopper | none |
| Grounds box | 700 g |
| Display | 7.0", lateral |
| Rated voltage / frequency | 220-240 V, 50/60 Hz |
| Rated power | **1500 W** |
| Machine weight | 15.5 kg (standard F11) |
| Machine L×W×H | 30 × 50 × 58 cm (standard F11) |
| Series models | F11 (standard) · **F11 Big (8 L water tank)** · F11 Plus (auto pressure pump) · F11 Big Plus (auto pressure pump + 8 L tank) · F11 Pro (solenoid valve) |
| Accessory scheme | **F11 + SC08** professional refrigerator · **F11 Big + CH01** cup warmer rack |

**"F11 Big" is confirmed as a current, official variant name** - it is listed by Dr.Coffee
itself in the series table and has its own labelled photo on the manufacturer's photo page
("F11 Big front (black)" / "F11 Big front (silver)"). Our `model_number: "F11 BIG"` is
therefore genuinely correct, which is unusual for this catalogue.

**Big-variant dimensions/weight**, confirmed by two independent distributors that agree
exactly - 410 × 500 × 580 mm (W×D×H), 17 kg:
https://www.kbean.com.au/coffee-machines/dr-coffee-espresso-coffee-machine
https://www.coffeematicmachine.com/products/dr-coffee-f11-big-plus-fully-automatic-coffee-machine/

Our stored prose table already says **410 × 500 × 580 mm / 17 kg** - **correct**.

**What is wrong:**

- **Numeric `length: 520, width: 620, height: 680` are the packing-carton dimensions.**
  Traced to the exact string `620*520*680mm` on the Sophia Electric Appliance / coffeematic
  listing above. That reseller lists carton size where the machine size belongs; our import
  took it, then reordered it. These three fields describe **no dimension of the appliance at
  all** and are the worst data error in this brand.
- **Power "1500–1700 W"** is that same reseller's loose family range (`1.5-1.7 kw`).
  Manufacturer's rated power is a flat **1500 W**. (The kbean listing repeats
  "1500-1700W" too, so the range propagates - but the factory sheet is unambiguous.)
- **Display "7.1-inch"** → official **7.0"** (lateral orientation).
- **Missing:** grounds box 700 g (≈70 pucks at 10 g), hourly output 70 cups, 16 g brew
  chamber, ceramic flat burrs / 9 grind sizes, 60-70 °C frothing temperature.
- **"24 pre-programmed beverages"** - appears in Amazon and distributor copy but **nowhere
  on Dr.Coffee's own F11 pages**, which say only "in addition to the default menu, you may
  customize your own recipes". Plausible, unverified. Low-risk to keep, but it is not a
  manufacturer figure.
- **"Self-Cleaning System with automatic rinsing"** - ⚠ the official F11 feature matrix marks
  **"Milk system automatic clean: –"** (the Minibar gets a filled square for the same row).
  The Czech distributor https://dr-coffee.cz/en/dr-coffee-f11/ does claim automatic milk-system
  cleaning, so the two sources conflict. Treat this bullet as **uncertain** - it is the one
  F11 feature claim I would not put in front of a customer unverified.
- **Confirmed correct as stored:** 8 L water tank, 1.2 kg bean hopper, 220-240 V 50/60 Hz,
  100 cups/day, bean-to-cup one-touch operation.

**Image check:** the catalogue photo `automatic-coffee-machine-f11-big-imgcof00099.png` is
byte-for-byte the same shot as Dr.Coffee's own "F11 Big front (black)" - correct variant,
side 8 L tank visible. Good.

### 4.2 MINIBAR (IMG/COF/00096) - dimensions right in prose, powder hopper wrong, milk-system copy overstated

**Manufacturer's Minibar technical sheet** (https://www.drcoffee.com/specifications/minibar.html):

| Field | Official |
|---|---|
| Advised daily output | 200 cups |
| Hourly output | 100 cups |
| Water tank | 4 L |
| Bean hopper | 1500 g × 1 |
| **Powder hopper** | **2.5 L × 1** |
| Grounds box | 700 g |
| Display | 7.0", **vertical** |
| Rated voltage / frequency | 220-240 V, 50/60 Hz |
| Rated power | 2900 W |
| Machine weight | 25 kg |
| Machine L×W×H | 34 × 54.5 × 62 cm |
| Series models | Minibar-S (standard) · Minibar-S1 (hot water wand) · Minibar-S2 (hot water wand + steam wand) |
| Accessory scheme | **Minibar-S1 + SC10** professional refrigerator |

**Almost everything in our record matches exactly** - 4 L tank, 1.5 kg beans, 2900 W,
25 kg, 200 cups/day, 100 cups/hour, 7" touchscreen, 220-240 V, and the prose dimensions
340 × 545 × 620 mm. This is the closest-to-correct record of the three.

**What is wrong / missing:**

- **Powder hopper "1.5 kg" ✗ → official "2.5 L".** The stored figure is the *bean* hopper's
  1.5 number duplicated onto the powder row - the same intra-record duplication class seen
  on the Santos 34-1A and the Pradeep milk boilers.
- **Numeric `width: 620` / `height: 545` swapped** (§3). Real height is 620.
- **Missing:** grounds box 700 g, 21 g brew chamber ("300,000 cups lasting performance"),
  vertical display orientation, mains-water self-priming.
- **"Dual Boiler System for simultaneous brewing and milk frothing"** - ⚠ overstated. The
  manufacturer's wording is **"Respective boilers for hot water and steam"**
  (https://www.drcoffee.com/cvs-ho-re-ca/minibar.html). The second boiler serves the hot-water
  and steam wands, not a separate brew circuit. "Dual boiler" is true; the *reason given*
  is not the manufacturer's.
- **"Automatic Milk Frothing"** - ⚠ misleading for this model. The Minibar's milk texturing
  is a **manual stainless steam wand**, and only the **S2** variant has one at all (S has
  neither wand, S1 has hot water only). The official feature matrix does tick "one-touch
  milk coffee", which on this machine is served from the **2.5 L powder hopper** (milk
  powder), not a fresh-milk auto-frother. Our copy reads as if it has an F11-style automatic
  fresh-milk system. Worth rewording.
- **`model_number: "MINIBAR"` is a family name, not an orderable code.** Real codes are
  Minibar-S / S1 / S2. Our catalogue photo shows **two wands = the S2**. Per the
  model-number convention this is flagged, not changed - but if the supplier ships S1 the
  product photo is wrong, and if they ship S the steam-wand copy is wrong.
- **"24 beverage options"** - same as the F11: distributor copy, not on Dr.Coffee's own page.

### 4.3 SC15 (IMG/COF/00097) - ⚠ two specs copied from sibling models, and it is not a milk fridge

**Manufacturer's accessories page** (https://www.drcoffee.com/accessories/) lists five cold
units, and **explicitly splits them into two different product types**:

| Model | Dr.Coffee's own type name | Temp range | Capacity | Power | Dimensions (W×D×H) | Weight |
|---|---|---|---|---|---|---|
| SC08 | **Milk cooler** | 1 °C ~ 5 °C | 8 L | 65 W | 240 × 470 × 472 mm | 12 kg |
| SC10 | **Milk cooler** | 1 °C ~ 5 °C | 10 L | 65 W | 240 × 420 × 610 mm | 14 kg |
| SC12 | **Milk cooler** | 1 °C ~ 5 °C | 20 L (10 L milk container) | 61 W | 300 × 420 × 527 mm | - |
| **SC15** | **electronic refrigerator** | **8 °C ~ 18 °C** | **15 L** | **40-45 W** | **252 × 512 × 450 mm** | **8.5 kg** |
| SC06 | Electronic refrigerator | -9 ~ 65 °C (cool/heat) | 8 L | 42 W / 38 W | 210 × 265 × 330 mm | - |

Against our record:

| Field | Stored | Official | Verdict |
|---|---|---|---|
| Capacity | **10 Litres** | **15 L** | ✗ **wrong - and it is the SC10's number.** The model code literally encodes 15 L |
| Power consumption | **65 W** | **40-45 W** | ✗ **wrong - 65 W is the SC08/SC10 compressor coolers' rating** |
| Temperature range | 8 °C - 18 °C | 8 °C ~ 18 °C | ✓ |
| Dimensions (prose) | 252 × 512 × 450 mm | 252 × 512 × 450 mm | ✓ |
| Dimensions (numeric) | 252 / 450 / 512 | height is 450 | ✗ W↔H swapped (§3) |
| Net weight | 8.5 kg | 8.5 kg | ✓ |
| Power supply | 220-240 V 50/60 Hz | 220-240 V 50/60 Hz | ✓ |
| Colour | Black | black (glass door) | ✓ |

Four fields match the official table character-for-character, which means the record **was**
built from this exact source - someone simply read two values off the wrong rows. Same
sibling cross-contamination bug documented on Santos (34-1 taking the 34-2's motor) and
Pradeep (milk boilers).

**The bigger problem: the SC15 is not a milk fridge.**

- Dr.Coffee's own taxonomy calls it an **"electronic refrigerator"** (thermoelectric /
  Peltier - consistent with its 40-45 W draw and 8.5 kg weight), and reserves **"Milk cooler"**
  for the compressor units SC08/SC10/SC12 that hold **1-5 °C**.
- **8-18 °C is above the cold-chain band for dairy.** A unit whose *coldest* setting is 8 °C
  should not be sold with copy promising to "keep milk fresh"; that is a food-safety-adjacent
  claim we cannot support from the manufacturer's own numbers. Our `short_description`
  ("Frost-free cooling, adjustable from 8C to 18C, keeps milk chilled and service-ready")
  and `description` ("ensures a consistent supply of chilled milk") both make it.
- **It is not the documented partner for either machine we sell.** Dr.Coffee pairs
  **F11 → SC08** and **Minibar-S1 → SC10**. SC15 appears in neither accessory scheme.
- **Our own imagery contradicts the listing.** The catalogue hero for the Minibar
  (`automatic-coffee-machine-minibar-imgcof00096.png`) shows the machine beside a
  **solid-panel compressor cooler displaying 3 °C** - i.e. an SC08/SC10-class milk cooler,
  not the glass-door SC15 we list as the accessory.
- Dr.Coffee's export storefront likewise promotes only SC08 and SC10 as "milk cooler / mini
  milk fridge": https://dr-coffee.en.made-in-china.com/
- **Product photo is correct for the SC15 itself** - our stored
  `milk-fridge-sc15-imgcof00097.png` is the same glass-door cabinet as Dr.Coffee's official
  SC15 shot. The product is real and correctly pictured; it is the *name, capacity, wattage
  and use-case framing* that are wrong.

**Also worth noting:** `products.json` currently links IMG/COF/00097 as an accessory of
**IMG/COF/00071 (Kalerm FAO 30)** only. Neither the F11 nor the Minibar - the two Dr.Coffee
machines - references it. If the SC15 stays in the catalogue, the accessory wiring is
pointing at a different brand's machine.

---

## 5. Cross-cutting notes

- **Width/height numeric swap on all three SKUs** (§3), with the F11 additionally holding
  carton dimensions rather than machine dimensions. The prose tables are the trustworthy
  half of every record; the numeric fields are the corrupted half. Consistent with the
  Santos/Brema/Empero findings - this import bug is now confirmed on five brands.
- **Reseller "ranges" leaking in as fake specs.** "1500–1700 W" on the F11 is one
  distributor's sloppy family range presented as a rated figure. Wherever a stored wattage
  is a *range*, suspect a reseller source.
- **Sibling cross-contamination on the SC15** (capacity from SC10, wattage from SC08/SC10) -
  the same failure mode as Santos 34-1A and the Pradeep milk boilers. When a brand sells a
  numbered family, always read the *row*, not the *table*.
- **"24 beverages" is a house figure, not a manufacturer figure.** It appears on both machine
  records and on no Dr.Coffee page. Not necessarily wrong, but do not treat it as sourced.
- **Model naming is unusually clean here.** Unlike Santos ("A" suffixes) or Fagor ("H"
  suffixes), our F11 BIG and SC15 codes are exactly the manufacturer's. Only MINIBAR is a
  family name rather than an orderable variant (§4.2). Nothing changed, per the
  model-number convention.

---

## 6. Product reference

| SKU | Catalogue name | Model | Official overview | Official spec table | Official photos | Confidence |
|---|---|---|---|---|---|---|
| IMG/COF/00099 | Automatic Coffee Machine F11 Big | F11 BIG | https://www.drcoffee.com/ocs/f11.html | https://www.drcoffee.com/specifications/f11.html | https://www.drcoffee.com/p-ocs/f11.html | **High** - official series data + two independent distributors agreeing on the Big's 410×500×580 / 17 kg |
| IMG/COF/00096 | Automatic Coffee Machine Minibar | MINIBAR | https://www.drcoffee.com/cvs-ho-re-ca/minibar.html | https://www.drcoffee.com/specifications/minibar.html | https://www.drcoffee.com/p-cvs-ho-re-ca/minibar.html | **High** - every figure from the manufacturer's own sheet; only the S/S1/S2 variant is ambiguous |
| IMG/COF/00097 | Milk Fridge SC15 | SC15 | https://www.drcoffee.com/accessories/ | https://www.drcoffee.com/accessories/ | https://www.drcoffee.com/p-accessories/milk-fridge.html | **High** on the numbers (single authoritative table); **the product framing is the issue, not the data** (§4.3) |

Secondary sources used:
https://www.kbean.com.au/coffee-machines/dr-coffee-espresso-coffee-machine
https://www.coffeematicmachine.com/products/dr-coffee-f11-big-plus-fully-automatic-coffee-machine/
https://dr-coffee.cz/en/dr-coffee-f11/
https://dr-coffee.en.made-in-china.com/

Not usable: https://www.drcoffee.com/data/upload/main/20250814/689d43797e0a8.pdf (F11 manual -
scanned images, no text layer, §2 trap 4).

---

## 7. Image sourcing (July 2026) - downloaded to `Downloads/dr-coffee-images/`

Dr.Coffee maintains a proper **variant-labelled photo library** at `p-<category>/<model>.html`
- each `<li>` carries an `alt` like "F11 Big front (black)" plus a direct download link. That
made this the cleanest image pass of any brand so far: no guessing which render is which
variant. Full-resolution originals obtained by dropping the `_` thumbnail suffix (§2 trap 5).

**19 files.**

| SKU | Model | Files | Notes |
|---|---|---|---|
| IMG/COF/00099 | F11 BIG | `IMG-COF-00099__f11-big-front-black.jpg`, `...-big-front-silver.jpg` | **The two that actually depict our variant** (side 8 L tank visible). `-black` is the same shot as our current catalogue image |
| IMG/COF/00099 | F11 (standard) | `...__f11-std-front/left/right-black.jpg`, `...-silver.jpg` (6 files, all 1523×757) + `...__f11-std-render-black-TOOSMALL.png`, `...-render-silver-TOOSMALL.png` (both **224×415**, 58/119 KB - capped, §7.1) | **Standard 2 L F11 - no side tank, 300 mm deep.** Kept as angle references only; do **not** use as the F11 Big's product photo |
| IMG/COF/00096 | Minibar | `IMG-COF-00096__minibar-s2-front.jpg`, `-s2-left.jpg`, `-s2-right.jpg` (1523×757), `-s2-render-TOOSMALL.png` (**231×430**, 118 KB - capped, §7.1) | **S2** = two wands (steam + hot water); matches our catalogue photo |
| IMG/COF/00096 | Minibar | `IMG-COF-00096__minibar-s-front.jpg`, `-s1-front.jpg` | The S (no wands) and S1 (hot water wand only) siblings - pick whichever the supplier actually ships (§4.2) |
| IMG/COF/00097 | SC15 | `IMG-COF-00097__sc15-official.jpg` | 1500 px white-background front shot, glass door, touch temperature panel. Matches our existing catalogue image |
| IMG/COF/00097 | SC08 / SC10 | `IMG-COF-00097__ref-sc08-milk-cooler.jpg`, `-sc10-milk-cooler.jpg` | **Reference only** - the *actual* Dr.Coffee milk coolers (compressor, 1-5 °C) that pair with the F11 and Minibar. Included because §4.3 may end up recommending one of these instead of the SC15 |

Notes for whoever adopts these:

- **Two F11 bodies exist and they look different.** The standard F11 is a plain cabinet; the
  F11 Big has a visible transparent 8 L tank bolted to the left side, adding 110 mm of depth.
  Any listing photo without that side tank is the wrong machine for this SKU.
- **The "silver" F11 files are the higher-resolution set** (~500 KB, 1500 px) where the black
  ones are ~90 KB. If storefront quality matters more than matching the black finish, the
  silver shots are noticeably better source material.
- **Feature graphics were deliberately excluded.** Five images pulled from the F11 and Minibar
  overview pages turned out byte-identical across the two models (§2 trap 3) - shared
  "ceramic burrs / 9 grind sizes / pre-brewing" artwork with no model-specific content. They
  were downloaded, identified as duplicates by MD5, and deleted rather than filed under a
  misleading name.
- **Not copied into `storage/app/public/products/` and not referenced in `products.json`** -
  staged in Downloads for review, same as the Brema and Santos sets. All three SKUs already
  have correct primary images, so nothing here is urgent; the value is the extra angles and
  the SC08/SC10 references.

### 7.1 Re-sourcing pass (July 2026) - the three PNG renders are capped site-wide

A minimum-resolution rule (**800 px long edge, 1000 px+ preferred**) was introduced after
this brand's original image pass. **All 16 `.jpg` files clear it comfortably at 1523 × 757.**
The three `.png` files did not:

| File | Size | Verdict |
|---|---|---|
| `IMG-COF-00099__f11-std-render-black-TOOSMALL.png` | 224 × 415, 58 KB | capped |
| `IMG-COF-00099__f11-std-render-silver-TOOSMALL.png` | 224 × 415, 119 KB | capped |
| `IMG-COF-00096__minibar-s2-render-TOOSMALL.png` | 231 × 430, 118 KB | capped |

These three are **transparent-background page-decoration renders**, not photo-library
assets. `drcoffee.com` publishes them at that size and no larger. Nothing was deleted -
each is already the largest copy that exists.

What was probed to prove the ceiling:

1. **The `_` thumbnail-suffix drop (§2 trap 5) was already applied** and is already baked
   into the staged files. Confirmed byte-for-byte: `6875c42da9a34.png` = 59 834 B =
   `f11-std-render-black.png`; `6875c436c22dc.png` = 122 002 B = `f11-std-render-silver.png`;
   `6874cdd490a9e.png` = 121 109 B = `minibar-s2-render.png`. The suffixed `_` copies are
   the *smaller* ones (46/100/84 KB) at identical pixel dimensions - so on these PNGs the
   `_` suffix only changes compression, not size. **The trick works; it just has nothing
   left to give here.**
2. **`data/watermark/` → `data/upload/` path swap** (the SimpleBootX original-vs-derivative
   pattern, suggested by the manual PDF living under `data/upload/`): returns byte-identical
   responses. There is no separate un-watermarked original tree.
3. **The `p-<category>/<model>.html` photo library** (`p-ocs/f11.html`,
   `p-cvs-ho-re-ca/minibar.html`) was re-read in full. Its `<a download="…">` links are the
   authoritative originals and they are **only the eight 1523 × 757 JPEGs** ("F11 front
   (black)" … "F11 Big front (silver)"). **The PNG renders are not in the download library
   at all** - they are layout art from the overview pages.
4. **No `srcset`, `data-zoom-image`, `data-large_image` or `data-src` attributes** anywhere
   on the product, photo-library or overview pages - the site serves one flat `src` per image.
5. **Site-wide sweep.** Every PNG referenced by the overview pages, the language-variant
   pages (`ocs-/f11.html`, `cvs-ho-re-ca-/minibar.html`), both category indexes and the home
   page was enumerated and downloaded - **79 unique PNGs**. Sorted by long edge, the product
   renders top out at **231-330 × 430-450**; the only PNGs above 800 px on the entire site
   are three 750 × 1500 marketing banners. The ~430 px cap is a site-wide design constant,
   not a per-file accident.

**Conclusion: keep the JPEGs, ignore the PNG renders for storefront use.** Both SKUs are
already covered above the bar - the F11 Big by `f11-big-front-black/silver.jpg` and the
Minibar by `minibar-s2-front/left/right.jpg`, all 1523 × 757. The `-TOOSMALL` renders remain
only as variant-identification references. **Do not re-run this search** - the ceiling is
proven at the site level.

---

## 8. Recommended scope if a change pass follows

Ordered by risk, highest first. Nothing below has been applied.

1. **SC15 capacity 10 L → 15 L** and **power 65 W → 40-45 W** (§4.3). Straight factual
   corrections against a single authoritative table.
2. **Decide what the SC15 actually is** (§4.3). Either reword the name/copy to "SC15
   Electronic Refrigerator / beverage cooler" and drop the milk-freshness claims, or replace
   the SKU with the SC08/SC10 milk cooler that Dr.Coffee actually pairs with these machines.
   This is a copy decision with a food-safety edge, not a data fix - needs a human call.
3. **F11 numeric dimensions 520/620/680 → 410/500/580** (§4.1). Currently the carton.
4. **Minibar and SC15 `width`/`height` exchange** (§3).
5. **Minibar powder hopper 1.5 kg → 2.5 L** (§4.2).
6. **F11 power "1500–1700 W" → 1500 W**, display 7.1" → 7.0" (§4.1).
7. **Soften the two overstated feature bullets**: the F11's self-cleaning claim (contradicted
   by the official feature matrix, §4.1) and the Minibar's "automatic milk frothing" /
   "dual boiler for simultaneous brewing and frothing" (§4.2).
8. **Optional adds** from the official sheets: grounds box 700 g (both machines), F11 hourly
   output 70 cups, Minibar 21 g brew chamber and vertical display, 16 g F11 brew chamber,
   ceramic flat burrs / 9 grind sizes / 60-70 °C frothing on both.
9. **Accessory wiring** (§4.3): IMG/COF/00097 is linked only from the Kalerm FAO 30, not from
   either Dr.Coffee machine.

Not recommended: changing `model_number` on any of the three. F11 BIG and SC15 are exact
manufacturer codes; MINIBAR is a family name whose correct resolution (S / S1 / S2) depends
on what the supplier ships, which is a sourcing question rather than a research one.
