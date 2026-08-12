# Robot Coupe / Sammic / Zummo Product Research

Research notes behind a three-brand audit pass on `products.json` (July 2026). Six SKUs:

- **ROBOT COUPE** (French) — 4 SKUs: `IMG/FPR/00018`, `IMG/FPR/00227`, `IMG/FPR/00228`, `IMG/FPR/00250`
- **SAMMIC** (Spanish) — 1 SKU: `IMG/FPR/00105`
- **ZUMMO** (Spanish) — 1 SKU: `IMG/FPR/00079`

**No `products.json` or `brands.json` changes have been applied** — this file is findings only,
same as the Baron, Brema, Santos and Tefcold/Waring passes.

All three are well-documented European manufacturers with public PDF datasheets, so verification
was clean: every one of the six SKUs was taken to a manufacturer-published document (spec sheet,
brochure spec table, user's guide rating plate, or the manufacturer's own export product page).

Headline results:

1. `IMG/FPR/00250`'s `model_number` **`2006` is not a Robot Coupe reference at all** — Robot Coupe
   has no 4-digit part numbers. §3.4.
2. `IMG/FPR/00105`'s name says **"P120"; `PI-20` is right** and "P120" is a typing mangle of it.
   Sammic has never made a P-120. §4.3.
3. **"ZUMMO INNOCACIONES" is a mangling of Zummo — Innovaciones Mecánicas, S.A.**, and it is not
   cosmetic: it breaks the seeder's brand lookup, so the only Zummo product in the catalogue has a
   **null `brand_id`**. §5.2. This is the most consequential finding in the pass.
4. **Axis swap present on exactly one of the six SKUs** — `IMG/FPR/00079` (Zummo) has `width` and
   `height` transposed. The other five are clean. Prose was correct again. §5.4.
5. **Kenya electrical: all six records are on 230 V / 50 Hz builds. No US figure is stored.** §6.

---

## 1. Product reference table

| SKU | Name in catalogue | `model_number` | Brand string | Status | Verdict on identity |
|---|---|---|---|---|---|
| `IMG/FPR/00018` | Combination Processor R301 | `R301` | ROBOT COUPE | published | **Correct.** Robot Coupe R 301, export order code 18274 |
| `IMG/FPR/00227` | Immersion Blender CMP 400 VV | `CMP 400 V.V` | ROBOT COUPE | published | **Correct.** Robot Coupe CMP 400 V.V. |
| `IMG/FPR/00228` | Immersion Blender CMP 300 VV | `CMP 300 V.V` | ROBOT COUPE | published | **Correct.** Robot Coupe CMP 300 V.V. |
| `IMG/FPR/00250` | Assorted Blade 3PACK R301UD | `2006` | ROBOT COUPE | archived | **`2006` is not a Robot Coupe reference.** Real codes 18565 / 18566 (§3.4) |
| `IMG/FPR/00105` | Potato Peeler 20KG P120 Sammic | `PI-20` | SAMMIC | archived | **`PI-20` correct; the name's "P120" is wrong** (§4.3) |
| `IMG/FPR/00079` | Orange Juicer Z06A-N | `Z06A-N` | ZUMMO INNOCACIONES | published | **`Z06A-N` correct and genuine; brand string mangled** (§5.2) |

---

## 2. Brand identification and `brands.json`

### 2.1 Robot Coupe — confirmed, `brands.json` correct

**Robot-Coupe s.n.c.**, France. Every brochure footer carries "Made in France" and the head
office contact `international@robot-coupe.com`, tel +33 1 43 98 88 33.

`brands.json` has `slug: robot-coupe`, `name: Robot Coupe`, `website_url:
https://www.robot-coupe.com`. **Correct, no change needed.** The apex resolves; note that
`https://www.robot-coupe.com/en` is a 404 — the site is split into per-market roots
(`/export/en/…`, `/usa/en_US/…`, `/hk/en_HK/…`), which matters for sourcing (§3.1).

Products.json brand string is `ROBOT COUPE` → lowercases to `robot coupe` → matches
`Robot Coupe` lowercased. **Links fine.**

Sources:
- https://www.robot-coupe.com
- https://www.robot-coupe.com/export/en/p/food-processors-r-301/18274

### 2.2 Sammic — confirmed, `brands.json` correct

**Sammic S.L.**, Polígono Basarte 1, 20720 **Azkoitia**, Gipuzkoa, **Spain**; tel +34 943 15 72 36;
`sales@sammic.com`. Printed verbatim on the footer of the PI-20 product sheet (updated
09/01/2025) and on the declaration of conformity. AENOR / ISO 9001 registered, CE marked.

`brands.json` has `slug: sammic`, `name: Sammic`, `website_url: https://www.sammic.com`.
**Correct, no change needed.**

Products.json brand string is `SAMMIC` → matches. **Links fine.**

Sources:
- https://www.sammic.com
- https://www.sammic.com/en/product/pi-20

### 2.3 Zummo — brand record correct, **product's brand string is not**

**Zummo — Innovaciones Mecánicas, S.A.**, C/ Cádiz 4, 46113 **Moncada, Valencia, Spain**;
tel +34 961 301 246; `zummo@zummo.es`. Legal name printed in full on the cover of the Z06 user's
guide and on the guarantee page. Two live hosts: the legacy **www.zummo.es** and the current
corporate/catalogue site **www.zummocorp.com** (the one printed on all current documents).

`brands.json` has `slug: zummo`, `name: Zummo`, `logo: brands/zummo.svg`,
`website_url: https://www.zummocorp.com`. **Correct, no change needed.**

The problem is entirely on the product side — see §5.2.

Sources:
- https://www.zummocorp.com
- https://www.zummocorp.com/en/commercial-juicer-machines/z06

---

## 3. ROBOT COUPE

### 3.1 Where to look, and the traps

| Resource | URL | Value |
|---|---|---|
| **Export (230 V) product pages — gold standard for our market** | `https://www.robot-coupe.com/export/en/p/<slug>/<code>` | Full spec block + accessory order codes, all in 230 V terms |
| USA product pages | `https://www.robot-coupe.com/usa/en_US/p/<slug>/<code>` | **120 V figures** — useful only as a contrast (§6) |
| R 301 / R 301 Ultra leaflet (Réf. 450 534 - 03/2026 - EN) | downloaded as `IMG-FPR-00018__R301-brochure.pdf` | Function/blade/disc content — **no spec table** |
| Immersion Blenders brochure (Ref 451 543 - 03/2023) | downloaded as `robot-coupe-CMP-immersion-blenders-brochure.pdf` | **Full CMP spec table on p.12** — decisive for both blender SKUs |
| 2025 Discs Collection (Ref 451 928) | downloaded as `robot-coupe-disc-collection-catalogue.pdf` | Every disc reference + which machines take ESSENTIAL Ø175 |

**Traps found:**

1. **The R 301 leaflet has no technical table.** Unlike the immersion-blender brochure, the 5-page
   R 301 / R 301 Ultra leaflet is pure marketing — dimensions, weight and electrical data appear
   only on the website product page. Do not assume a Robot Coupe leaflet carries a spec table.
2. **The USA site will hand you 120 V / 1725 rpm for the same order code 18274.** Same product
   number, different machine. Always use `/export/en/`.
3. **Robot Coupe uses two parallel numbering systems.** Machine/accessory *order codes* are 5-digit
   `18xxx` (R 301 = 18274; coarse serrated blade = 18565). Disc and spare-part *references* are
   5-digit `27xxx / 28xxx / 29xxx / 49xxx`. Nothing in either system is 4 digits. This is what
   settles §3.4.
4. Robot Coupe's own p.12 table lists the CMP 400 V.V. gross weight as **4.3 kg**, below the
   CMP 350 V.V.'s 5.0 kg — an internal inconsistency in the manufacturer's document. Do not
   propagate Robot Coupe gross weights.

### 3.2 `IMG/FPR/00018` — Combination Processor R301 — **record is excellent**

Manufacturer figures (export, 230 V):

| Field | Robot Coupe | Stored | Match |
|---|---|---|---|
| Power | 650 W | 650 W | ✓ |
| Electrical | Single phase (export = 230 V / 50 Hz) | 230 V / 50 Hz / single phase | ✓ |
| Speed | 1,500 rpm, induction motor, pulse | 1,500 rpm, single speed with pulse | ✓ |
| Cutter bowl | 3.7 L composite bowl with handle | 3.7 L composite bowl with handle | ✓ |
| Large hopper | 104 cm², 1.6 L half-moon | 1.6 L half-moon (104 cm²) | ✓ |
| Cylindrical hopper | Ø 58 mm | Ø 58 mm | ✓ |
| Dimensions | 355 × 305 × 570 mm (L × W × H) | length 355, width 305, height 570 | ✓ **no axis swap** |
| Net weight | 14 kg | 14 kg | ✓ |
| Gross weight | 17 kg | not stored | — |
| Order code | 18274 | not stored | — |

This is the cleanest record of the six. **No changes required.**

Two soft points, neither wrong enough to change:

- Stored `Throughput: Up to ~250 kg/h vegetable prep`. Robot Coupe does not publish an hourly
  figure for the R 301; the leaflet gives per-disc batch rates — slicers 6 kg/2 min (180 kg/h),
  graters 3 kg/1 min (180 kg/h), ripple 8 kg/4 min (120 kg/h), julienne 6 kg/3 min (120 kg/h) —
  plus the headline "up to 4 kg of grated carrots in 1 minute" (240 kg/h). So ~250 kg/h is at the
  very top of the range and only reachable on the grating disc. Defensible, but "up to 240 kg/h"
  would be exactly Robot Coupe's own claim.
- Stored `Range of 24 optional precision stainless steel discs`. The R 301 leaflet says **24**;
  the 2025 Discs Collection says **29** for the whole ESSENTIAL Ø175 mm family. Both are Robot
  Coupe's own numbers from different documents. 24 is the model-specific one — keep it.

**Which R 301?** The stored hero image shows the `R301` badge with the **grey composite** bowl.
The R 301 **Ultra** is the same machine with a **stainless steel** 3.7 L bowl (identical
650 W / 1,500 rpm / 355 × 305 × 570 / 14 kg). The stored image is therefore the plain R 301 and
matches the record. Verified against the official Robot Coupe render.

Sources:
- https://www.robot-coupe.com/export/en/p/food-processors-r-301/18274
- https://www.robot-coupe.com/export/en/p/food-processors-r-301-ultra/18332

### 3.3 `IMG/FPR/00227` + `IMG/FPR/00228` — CMP 400 V.V. and CMP 300 V.V.

From the Immersion Blenders brochure p.12 spec table (Ref 451 543 - 03/2023). Column key from the
diagram: **A** = motor-body diameter, **B** = total length, **C** = bell diameter, **D** = tube length.

| | CMP 300 V.V. | CMP 400 V.V. |
|---|---|---|
| Variable speed | 2,300 – 9,600 rpm | 2,300 – 9,600 rpm |
| Power | 350 W | 420 W |
| Voltage | 230 V / 50 Hz – 1.6 A | 230 V / 50 Hz – 1.9 A |
| A (body Ø) | 94 mm | 94 mm |
| **B (total length)** | **669 mm** | **786 mm** |
| C (bell Ø) | 95 mm | 90 mm |
| D (tube) | 305 mm | 413 mm |
| Net / gross weight | 3.1 / 4.8 kg | 3.8 / 4.3 kg |
| Max batch (brochure p.2) | 30 litres | 73 litres |

Against the stored records:

| SKU | Field | Robot Coupe | Stored | Verdict |
|---|---|---|---|---|
| 00228 | length | 669 mm | **660** | **wrong by 9 mm** |
| 00228 | width / height | 94 / 94 (body Ø) | 94 / 94 | ✓ no axis swap |
| 00228 | power | 350 W | 350 W | ✓ |
| 00228 | electrical | 230 V / 50 Hz | 230 V / 50 Hz / single phase | ✓ |
| 00228 | speed | 2,300–9,600 rpm | 2,300–9,600 rpm | ✓ |
| 00228 | batch | 30 L | 30 L | ✓ |
| 00228 | net weight | 3.1 kg | 3 kg | rounded, acceptable |
| 00227 | length | 786 mm | **763** | **wrong by 23 mm** |
| 00227 | width / height | 94 / 94 (body Ø) | 94 / 94 | ✓ no axis swap |
| 00227 | power | 420 W | 420 W | ✓ |
| 00227 | electrical | 230 V / 50 Hz | 220–240 V / 50 Hz / single phase | ✓ (see below) |
| 00227 | speed | 2,300–9,600 rpm | 2,300–9,600 rpm | ✓ |
| 00227 | batch | 73 L | 73 L | ✓ |
| 00227 | net weight | 3.8 kg | 4 kg | rounded up; 3.8 is Robot Coupe's figure |

Both total lengths are stale — 660/763 look like an earlier brochure revision. The current
(03/2023) figures are 669 and 786.

Note on tube length: the model names use the **nominal** tube length (300 mm / 400 mm), which is
what the stored prose says. The measured **D** dimension is 305 / 413 mm. Both are correct in
context; the prose statement "400 mm tube" is fine.

The two records also disagree with each other on how the same supply is written — 00228 says
`230 V / 50 Hz`, 00227 says `220–240 V / 50 Hz`. Robot Coupe writes both as `230 V / 50 Hz`.
Worth harmonising.

Everything else in both records — the patented removable bell/blade, the EasyPlug detachable cord
with illuminated indicator, the pan-rim rest lug, the stainless wall support, "Made in France" —
is confirmed verbatim by brochure pp. 6–7 and p. 11.

The stored hero images were verified against Robot Coupe's official renders: both show the correct
badge (`CMP 400 V.V.` / `CMP 300 V.V.`). **No image mismatch.**

### 3.4 `IMG/FPR/00250` — "Assorted Blade 3PACK R301UD", `model_number` **`2006`** — ⚠ verdict

**`2006` is not a Robot Coupe reference.**

Evidence:

1. **Robot Coupe has no 4-digit numbering.** Its two systems are 5-digit throughout:
   - order codes `18xxx` — R 301 = **18274**, R 301 Ultra = **18332**, coarse serrated blade =
     **18565**, fine serrated blade = **18566**, coulis kit = **18570**, citrus press = **18572**
   - part/disc references `27xxx / 28xxx / 29xxx / 49xxx` — e.g. slicer 1 mm = 27051, grater 6 mm =
     27046, EasyLoader = 49323, D-Clean Kit = 29246
2. `2006` appears **nowhere** in the 2025 Discs Collection (Ref 451 928), the R 301 leaflet
   (Réf. 450 534 - 03/2026) or the Immersion Blenders brochure (Ref 451 543 - 03/2023).
3. A direct search for a Robot Coupe part "2006" returns only a document revision date
   (`Maj : 10/2006` on a legacy US parts manual) — no such part.
4. It is not a truncation either: there is no `2006x` in any of the live ranges above.

**Conclusion:** `2006` is a Sheffield/supplier line number that ended up in the `model_number`
field. Per the model_number rule it is recorded here and **not changed**.

**The genuine references**, depending on which part is actually stocked:

| Blade | Export / EU order code | US "D-spindle" part ref |
|---|---|---|
| Smooth (bowl-base twin blade) | ships with the machine as standard | 27286 |
| Coarse serrated (grinding, kneading) | **18565** | 27288 |
| Fine serrated (herbs, spices) | **18566** | 27287 |

**"3PACK":** Robot Coupe sells these blades individually; there is **no catalogued 3-blade pack**.
The R 301 leaflet's headline is "**3 blade assemblies available**" — one supplied as standard plus
two optional extras. That is almost certainly where "3PACK" came from, and it means the SKU as
described (a pack of three) does not correspond to a purchasable Robot Coupe item.

**"R301UD" and the R 301 vs R 301 Ultra question — answered:**

- `R301UD` is **not** a Robot Coupe designation. The R 301 family is **R 301**, **R 301 Ultra**,
  **R 301 D** (Dice, US market) and **R 301 B Ultra**. "UD" reads as a run-together of
  "**U**ltra" / "**D**ice".
- **For the EU codes the question is moot:** 18565 and 18566 are listed as accessories on *both*
  the R 301 and the R 301 Ultra export pages, and both machines take the same bowl-base twin-blade
  assembly and the same ESSENTIAL Ø175 mm discs. **One blade fits both.**
- **The US references are not interchangeable.** 27286 / 27287 / 27288 are described as the
  **R301 D / R3D** (D-shaped spindle) blades. If the stocked item is actually a US-sourced
  27xxx blade, it will **not** be the right part for a plain export R 301 sold in Kenya.

This is the one place in the pass where a wrong purchase is genuinely possible. The SKU is
archived; it should **stay archived** until the client confirms which physical part is on the
shelf.

Sources:
- https://www.robot-coupe.com/export/en/p/food-processors-r-301/18274
- https://www.robot-coupe.com/export/en/p/food-processors-r-301-ultra/18332
- https://www.robotcoupe-parts.com/images/part-manual/r2n-us.pdf

### 3.5 Recommended changes — ROBOT COUPE

| SKU | Field | From | To | Confidence |
|---|---|---|---|---|
| `IMG/FPR/00018` | — | — | **no change** | high |
| `IMG/FPR/00018` | `technical_specification` throughput | `Up to ~250 kg/h vegetable prep` | `Up to 240 kg/h (4 kg grated carrot per minute)` | medium — optional tightening |
| `IMG/FPR/00227` | `length` | `763` | `786` | high |
| `IMG/FPR/00227` | tech-spec Total Length | `763 mm` | `786 mm` | high |
| `IMG/FPR/00227` | tech-spec Net Weight | `4 kg` | `3.8 kg` | high |
| `IMG/FPR/00227` | tech-spec Electrical | `220–240 V / 50 Hz / single phase` | `230 V / 50 Hz / single phase (1.9 A)` | high |
| `IMG/FPR/00228` | `length` | `660` | `669` | high |
| `IMG/FPR/00228` | tech-spec Total Length | `660 mm` | `669 mm` | high |
| `IMG/FPR/00228` | tech-spec Net Weight | `3 kg` | `3.1 kg` | high |
| `IMG/FPR/00228` | tech-spec Electrical | `230 V / 50 Hz / single phase` | add `(1.6 A)` | medium |
| `IMG/FPR/00250` | `model_number` | `2006` | **leave as-is**; record 18565 / 18566 here | — |
| `IMG/FPR/00250` | status | `archived` | **keep archived** pending client confirmation of the actual part | high |

---

## 4. SAMMIC

### 4.1 `IMG/FPR/00105` — the record as it stands

The record is **skeletal**: `image: null`, `description: null`, no `length`/`width`/`height`, no
`technical_specification`, `status: archived`. Only `name`, `model_number`, `short_description`
and price are populated. There is therefore nothing to axis-swap and no electrical figure to be
wrong — but equally nothing to tell a Kenyan buyer which of five voltage variants they get.

### 4.2 Manufacturer specification — Sammic PI-20 (product sheet updated 09/01/2025)

| Field | Value |
|---|---|
| Capacity per load | **20 kg / 44 lb** |
| Hourly production | 400 kg / 480 kg |
| Timer | 0' – 6', plus continuous operation |
| Total loading | **550 W** |
| External dimensions (W × D × H) | **433 × 635 × 786 mm** |
| External dimensions with stand | 433 × 638 × **1,155 mm** |
| Net weight | 38 / 36 kg |
| Noise level (1 m) | 70 dB(A); background 32 dB(A) |
| Water intake | 12 mm |
| Drain diameter | 80 mm |
| Crated dimensions | 670 × 470 × 930 mm |
| Construction | Stainless steel body; lateral stirrers + aluminium base plate lined with **NSF-approved silicon carbide abrasive**; base plate removable for cleaning |
| Safety / hygiene | Auto-drag of waste to drain; BPA-free liftable transparent cover with locking + safety device; aluminium door with hermetic seal + safety device; **IP65 waterproof control board**; water inlet with non-return air break; auxiliary contact for external electric valve |
| Optional | Stainless steel floor stand with no-foam filter |

**Available models (order codes):**

| Order code | Model | Electrical |
|---|---|---|
| 1000618 | Potato peeler PI-20 | **120 / 60 / 1** ← US, wrong for Kenya |
| 1000660 | Potato peeler PI-20 | 230-400 / 50 / 3N |
| **1000661** | **Potato peeler PI-20** | **230 / 50 / 1** ← **the Kenyan single-phase unit** |
| 1000662 | Potato peeler PI-20 | 220-380 / 60 / 3N |
| 1000663 | Potato peeler PI-20 | 220 / 60 / 1 |

### 4.3 "P120" vs `PI-20` — ⚠ verdict: **`PI-20` is right, the name is wrong**

1. Sammic's live stainless potato-peeler line is **PI-10 / PI-20 / PI-30** (plus the M- and PES-
   lines). The number is the **kg load per cycle** — PI-20 = 20 kg, exactly matching the "20KG" in
   our own product name.
2. **Sammic has never made a P-120 or P120.** A search for a Sammic P-120 returns exactly one hit,
   and it is a **Food Warming Equipment (FWE) P-120** — a different manufacturer, unrelated product.
3. The mangling is mechanical and obvious: `PI-20` → hyphen dropped → `PI20` → the capital **I**
   read/typed as the digit **1** → **`P120`**.

**Conclusion: `model_number` `PI-20` is correct and must not be touched. The product *name* is
what needs fixing** — `Potato Peeler 20KG P120 Sammic` → `Potato Peeler 20KG PI-20 Sammic`.

### 4.4 Dimension-entry warning if the record is ever populated

**Sammic quotes W × D × H; this catalogue stores L × W × H where L is the deeper dimension**
(compare the sibling Skymsen barrel peeler `IMG/FPR/00246`, stored 670 × 550 × 1,155). The Sammic
numbers must therefore be **transposed on entry**, not copied in order:

- Bench unit: `length 635`, `width 433`, `height 786`
- On the optional stand: `length 638`, `width 433`, `height 1155`

Copying Sammic's own order (433 / 635 / 786) straight in would create precisely the width/height
class of error this audit keeps finding.

### 4.5 Recommended changes — SAMMIC

| SKU | Field | From | To | Confidence |
|---|---|---|---|---|
| `IMG/FPR/00105` | `name` | `Potato Peeler 20KG P120 Sammic` | `Potato Peeler 20KG PI-20 Sammic` | high |
| `IMG/FPR/00105` | `model_number` | `PI-20` | **leave as-is — it is correct** | high |
| `IMG/FPR/00105` | `length` / `width` / `height` | null | `635` / `433` / `786` (bench) — see §4.4 | high |
| `IMG/FPR/00105` | `technical_specification` | null | populate from §4.2, stating **230 V / 50 Hz / single phase (order code 1000661)** | high |
| `IMG/FPR/00105` | `description` | null | write from §4.2 | high |
| `IMG/FPR/00105` | `image` | null | `IMG-FPR-00105__PI-20-official-front-on-stand.jpg` (2244 × 2244) | high |

Sources:
- https://www.sammic.com/en/product/pi-20
- https://www.sammic.com/en/products/potato-peelers/stainless-steel-commercial-potato-peelers

---

## 5. ZUMMO

### 5.1 Where to look

| Resource | URL / file | Value |
|---|---|---|
| Z06 product page | https://www.zummocorp.com/en/commercial-juicer-machines/z06 | Current Nature specs + reference structure |
| Z06 Nature datasheet (M0408ENEN/23-1) | `IMG-FPR-00079__spec-sheet.pdf` | **Decisive** — full technical table |
| Z06 Inox datasheet (M0409ENEN/23-1) | `IMG-FPR-00079__REF__spec-sheet-Z06-inox.pdf` | Inox variant + counter-top chutes |
| Z06A user's guide (ref 011211/01) | `IMG-FPR-00079__users-guide.pdf` | **Rating plate photo (Fig. 5)** — the electrical proof |
| Z06 Nature maintenance instructions (D011246-04) | `IMG-FPR-00079__manual.pdf` | Confirms the "Z06 NATURE" family name |
| Dimensioned render | `IMG-FPR-00079__Z06-dimensions-diagram.webp` | **Decisive on the axis swap** |

### 5.2 ⚠ "ZUMMO INNOCACIONES" — mangled, **and it silently breaks the brand link**

The legal name printed on the cover of Zummo's own user's guide, and repeated on the guarantee
page and the machine rating plate, is:

> **ZUMMO-INNOVACIONES MECÁNICAS, S.A.** — C/ Cádiz 4, 46113 Moncada (Valencia), España

Our stored brand string is `"ZUMMO INNOCACIONES"` — "Inno**c**aciones" for "Inno**v**aciones",
with "Mecánicas, S.A." dropped. Confirmed mangling.

**This is not cosmetic.** `ProductSeeder.php:184` resolves the brand with:

```php
$brandId = $this->brandIdByName[mb_strtolower(trim($data['brand']))] ?? null;
```

keyed on the lowercased `brands.json` **name**. `"ZUMMO INNOCACIONES"` lowercases to
`"zummo innocaciones"`, which does not match `"zummo"` — so **`brand_id` is silently `null` for
`IMG/FPR/00079`**, the only Zummo product in the catalogue.

Consequences today: the Zummo brand record (`brands/zummo.svg`, `https://www.zummocorp.com`) is
never linked to the product, the brand logo never renders on the PDP, and the product is invisible
to brand filtering and to any brand-scoped listing.

**Fix: change the product's brand string to `"ZUMMO"`.** No `brands.json` change is needed — the
brand record is already correct. (This is exactly the failure mode the seeder comment at
`ProductSeeder.php:99-101` was written to prevent; it defeats lowercasing because the string has
extra words, not just different casing.)

### 5.3 `Z06A-N` — ⚠ verdict: **genuine, do not change**

Zummo's own datasheets write the family as a template with a version placeholder:

- `Ref: Z06x-N` — plastic front covers (Z06 Nature datasheet)
- `Ref: ZI06x-N` — Inox
- `Ref: ZM06x-N` — Inox, counter-top chute version

The **`-N` suffix is "Nature"** — the current Z06 generation, confirmed by the maintenance manual
whose header reads "**Z06 NATURE**". The **`A`** is the version letter that fills the `x` slot.
Zummo does not publish a legend for the version letters on its public datasheets, but **`Z06A-N`
is a real, marketed reference**: it appears on European second-hand listings (an Italian listing
describes a "Zummo Z06A-N … spremiagrumi professionale automatico … con alimentazione automatica";
a German listing covers a Dec-2021 machine), described as exactly the automatic self-feeding
countertop citrus juicer we sell.

**Do not change `model_number`.** Colour is a *further* suffix, not part of the version letter:
`-NOR` orange, `-NGP` graphite, `-NBR` brown, `-NBE` beige — which is what the stored description's
"Customizable bins: orange, tan, brown, graphite" is describing.

### 5.4 ⚠ Axis swap — **confirmed present on this SKU**

Zummo Z06 Nature dimensions, from the datasheet table **and** the dimensioned render, which label
the axes explicitly:

> **542 (x) × 810 (y) × 427 (z) mm** — render annotations: **542 mm** front width, **427 mm**
> depth, **810 mm** height.

Stored record:

| | Stored prose (`technical_specification`) | Stored numeric field | Zummo |
|---|---|---|---|
| Length | `LENGTH: 548MM` | `length: 548` ✓ | 542 (front width) |
| Width | `WIDTH: 431MM` | `width: 811` ✗ | 427 (depth) |
| Height | `HEIGHT: 811MM` | `height: 431` ✗ | 810 |

**`width` and `height` are transposed.** The prose is correct — as it has been in every brand pass
so far. An 811 mm-wide, 431 mm-tall citrus juicer is physically absurd; the machine is 810 mm tall.

Separately, the stored magnitudes (548 / 431 / 811) are from an **older Nature datasheet revision**
— the current M0408ENEN/23-1 sheet and the render both say 542 / 427 / 810. A ±6 mm drift, worth
refreshing while the swap is being fixed.

### 5.5 Full spec comparison

| Field | Zummo (Z06 Nature, M0408ENEN/23-1) | Stored | Verdict |
|---|---|---|---|
| Fruits per minute | 10 | `10 FRUITS` | ✓ |
| Power consumption | 275 W (rating plate) | `275W` | ✓ |
| Electrical | 230 V ~ 50 Hz, 1.3 A (rating plate) | `230 V – 50 Hz. 220 V – 60 Hz. 120 V – 60 Hz.` | ✓ but see §6 |
| Motor | 0.33 CV single phase | `Single-phase 0,33 CV` | ✓ |
| Dimensions | 542 × 810 × 427 mm (x/y/z) | 548 / 431 / 811 + **swap** | ✗ §5.4 |
| Weight | **51 kg** (Inox 54 kg; legacy Z06A 48 kg) | not stored | missing |
| Bin capacity | **22 L (2 × 11 L)** | not stored | missing |
| Basket capacity | 6 kg | `6 KG` | ✓ |
| Feeder capacity | 1.5 kg | not stored | missing |
| Filling height | 178 mm | not stored | missing |
| Squeezing kits | M 55–75 mm, L 70–90 mm standard; **S 45–60 mm optional** | not stored | missing |
| Safety | Blocking sensors | `Standard contact sensors` | partial — contact sensor is the *auto-start* feature, blocking sensors are the *safety* feature; both real, different things |
| Programmer | Yes | `Digital control plate with bin counter, acoustic warnings, standby` | ✓ |
| Automatic filter | Yes (belt-driven) | `Automatic filter` | ✓ |
| Extraction system | EVS® Advanced (vertical) | `EVS Advanced juice extraction system` | ✓ |

Additional stored-copy issues:

- `Produces up to 7.5 Gal of juice/hour` — **US units, and not a Zummo figure.** Zummo rates the
  machine at 10 fruits/minute; 7.5 gal/h ≈ 28 L/h is a US-distributor derivation. Should be metric
  or replaced with the manufacturer's own "10 fruits per minute".
- `Can squeeze oranges, lemons, limes, tangerines, smaller grapefruits, pomegranates` — confirmed;
  Zummo's own line is "extracts juice from all kinds of citrus fruit, as well as from pomegranates".
- `Smokey gray front cover` and `High quality injected plastic nuts` — consistent with the Nature
  front protector, but not Zummo phrasing.
- `No oils, acidity or pesticides in the juice` — this is the marketing claim for the EVS vertical
  system (peel never contacts the juice). Genuine Zummo positioning, though the flat assertion is
  stronger than Zummo's own wording.

### 5.6 ⚠ Stored image is 225 × 225 px

`products/orange-juicer-z06a-n-imgfpr00079.jpeg` is **225 × 225 px / 7 KB** — by an order of
magnitude the smallest hero image of the six SKUs (the Robot Coupe heroes are all 1512 × 1512).

The **machine is correct** — it is a Z06 Nature with orange side bins, the wire top basket, the
contact-sensor ramp and the smoked front protector, matching Zummo's own catalogue render. So this
is not a wrong-machine finding like the Kalerm/Kusina/Sulte/Broaster cases. But it is unusable at
PDP size and should be replaced from
`IMG-FPR-00079__Z06-orange-specsheet-hero.png` (1375 × 1232) or
`IMG-FPR-00079__Z06-orange-catalogue-hero.png` (1109 × 835).

The record also has **no `gallery`** — the only one of the four published SKUs in this pass without
one.

### 5.7 Recommended changes — ZUMMO

| SKU | Field | From | To | Confidence |
|---|---|---|---|---|
| `IMG/FPR/00079` | `brand` | `ZUMMO INNOCACIONES` | **`ZUMMO`** — fixes the null `brand_id` | **high, highest priority** |
| `IMG/FPR/00079` | `width` | `811` | `427` | high |
| `IMG/FPR/00079` | `height` | `431` | `810` | high |
| `IMG/FPR/00079` | `length` | `548` | `542` | high |
| `IMG/FPR/00079` | tech-spec dimensions | `548 / 431 / 811` | `542 / 427 / 810` | high |
| `IMG/FPR/00079` | tech-spec power rating | `230 V – 50 Hz. 220 V – 60 Hz. 120 V – 60 Hz.` | `230 V / 50 Hz / single phase, 1.3 A` | high |
| `IMG/FPR/00079` | `description` | `up to 7.5 Gal of juice/hour` | `10 fruits per minute` | high |
| `IMG/FPR/00079` | tech-spec | — | add weight 51 kg, bin capacity 22 L (2 × 11 L), feeder capacity 1.5 kg, filling height 178 mm, squeezing kits M/L standard + S optional | high |
| `IMG/FPR/00079` | `model_number` | `Z06A-N` | **leave as-is — genuine** | high |
| `IMG/FPR/00079` | `image` | 225 × 225 px file | replace from `zummo-images` (1375 × 1232) | high |
| `IMG/FPR/00079` | `meta_description` | absent | write one (record has `description` but no `meta_description`) | medium |

Sources:
- https://www.zummocorp.com/en/commercial-juicer-machines/z06
- https://www.zummocorp.com

---

## 6. Kenya electrical verdict (240 V / 50 Hz) — all six SKUs clear

The brief flagged this as live risk, and it was: **both Robot Coupe and Sammic sell 120 V / 60 Hz
US variants of these exact machines.**

- **Robot Coupe R 301, USA page, same order code 18274:** *120 V single phase, 1.5 HP, 1,725 rpm* —
  a genuinely different machine from the 650 W / 1,500 rpm export unit.
- **Sammic PI-20, order code 1000618:** *120 / 60 / 1*, sitting in the same five-model list as the
  Kenyan 1000661 (230 / 50 / 1).

**Nothing US made it into our records.** Result per SKU:

| SKU | Stored electrical | Correct for Kenya? |
|---|---|---|
| `IMG/FPR/00018` R301 | 230 V / 50 Hz / single phase, 650 W | ✓ — the export build |
| `IMG/FPR/00227` CMP 400 V.V. | 220–240 V / 50 Hz / single phase, 420 W | ✓ (Robot Coupe writes 230 V / 50 Hz, 1.9 A) |
| `IMG/FPR/00228` CMP 300 V.V. | 230 V / 50 Hz / single phase, 350 W | ✓ (1.6 A) |
| `IMG/FPR/00250` blades | n/a — passive part | n/a |
| `IMG/FPR/00105` PI-20 | **nothing stored** | ⚠ not wrong, but silent — should state 230 / 50 / 1 (code 1000661) |
| `IMG/FPR/00079` Z06A-N | `230 V – 50 Hz. 220 V – 60 Hz. 120 V – 60 Hz.` | ✓ — 230 V / 50 Hz leads; rating plate reads `230V ~ 50Hz 1,3A 275W` |

Two residual actions, both minor: give the Sammic record an explicit 230 / 50 / 1 line, and trim
the Zummo record's multi-market voltage list so a Kenyan customer cannot read `120 V – 60 Hz` off
the PDP and order the wrong build.

---

## 7. Images and documents

Destination folders — nothing was copied into the project.

### 7.1 `products resource\robot-coupe-images\`

| File | Pixels | Size | SKU | Notes |
|---|---|---|---|---|
| `IMG-FPR-00018__R301-official-front.png` | 800 × 921 | 493 KB | 00018 | Official Robot Coupe render, `R301` badge + grey composite bowl — matches stored hero |
| `IMG-FPR-00018__R301-brochure.pdf` | — | 1,602 KB | 00018 | R 301 / R 301 Ultra leaflet, Réf. 450 534 - 03/2026 - EN (**no spec table**) |
| `IMG-FPR-00018__veg-prep-attachment-head.jpg` | 1000 × 1000 | 23 KB | 00018 | Vegetable-prep attachment head *(renamed this pass from `tmpk.jpg`)* |
| `IMG-FPR-00018__cutter-bowl-3-7L-with-lid.jpg` | 1000 × 1000 | 19 KB | 00018 | 3.7 L bowl + lid *(renamed from `tmpk_003.jpg`)* |
| `IMG-FPR-00018__large-hopper-in-use-cabbage.jpg` | 1000 × 1000 | 49 KB | 00018 | Half-moon hopper loaded with a cabbage *(renamed from `tmpk_005.jpg`)* |
| `IMG-FPR-00018__included-slicing-and-grating-discs.jpg` | 1000 × 1000 | 26 KB | 00018 | The two supplied discs *(renamed from `tmpk_006.jpg`)* |
| `IMG-FPR-00227__CMP400VV-official.png` | 2997 × 7323 | 4,512 KB | 00227 | Official render, `CMP 400 V.V.` badge legible — verified |
| `IMG-FPR-00228__CMP300VV-official.png` | 2997 × 6446 | 4,139 KB | 00228 | Official render, `CMP 300 V.V.` badge |
| `IMG-FPR-00250__smooth-blade-27286.jpg` | 2000 × 2000 | 97 KB | 00250 | Smooth "S" blade pair |
| `IMG-FPR-00250__fine-serrated-blade-27287.png` | 2132 × 1740 | 954 KB | 00250 | Fine serrated pair |
| `IMG-FPR-00250__coarse-serrated-blade-27288.jpg` | 1000 × 1000 | 22 KB | 00250 | Coarse serrated pair |
| `IMG-FPR-00250__serrated-blade-pair.jpg` | 1000 × 1000 | 26 KB | 00250 | Second serrated view *(renamed from `tmpk_004.jpg`)* |
| `IMG-FPR-00250__three-blade-range-brochure-page.png` | 1819 × 2573 | 1,344 KB | 00250 | Leaflet p.2 — the "3 blade assemblies" page that explains "3PACK" |
| `robot-coupe-CMP-immersion-blenders-brochure.pdf` | — | 3,407 KB | 00227 + 00228 | **Ref 451 543 - 03/2023 — full CMP spec table on p.12.** Brand-level, covers both SKUs |
| `robot-coupe-disc-collection-catalogue.pdf` | — | 2,346 KB | 00018 + 00250 | 2025 Discs Collection, Ref 451 928 — every ESSENTIAL Ø175 disc reference |
| `_brand-reference\R301-Dice-us-market-variant.jpg` | 1000 × 1000 | 24 KB | — | **`R 301 Dice`** badge — a *different, US-market* model. Moved out of the SKU set this pass |
| `_brand-reference\R301-fine-serrated-blade-pair-600px.png` | 600 × 600 | 74 KB | — | Below the 800 px floor *(was `p4.png`)* |
| `_brand-reference\R301-dealer-thumbnail-strip-composite.png` | 1980 × 330 | 231 KB | — | Six-thumbnail dealer strip, not a product shot *(was `contact.png`)* |

**Work done this pass:** eight files left unnamed by the interrupted run (`tmpk.jpg`,
`tmpk_002`–`tmpk_006`, `p4.png`, `contact.png`) were opened, identified, renamed to the SKU
convention, and the three non-product/wrong-model files moved to `_brand-reference\`. The
`R 301 Dice` shot in particular was sitting loose in the folder and would have been easy to
mistake for the R 301.

### 7.2 `products resource\sammic-images\` — complete, nothing added

| File | Pixels | Size | Notes |
|---|---|---|---|
| `IMG-FPR-00105__PI-20-official-front-on-stand.jpg` | 2244 × 2244 | 305 KB | Official Sammic render, `sammic` badge, on the optional stand — **use as hero** |
| `IMG-FPR-00105__spec-sheet.pdf` | — | 380 KB | **Product sheet updated 09/01/2025 — the decisive document** (specs + the five order codes) |
| `IMG-FPR-00105__manual-EN-FR-DE-AR.pdf` | — | 4,415 KB | Multilingual instruction manual |
| `IMG-FPR-00105__declaration-of-conformity.pdf` | — | 131 KB | CE DoC |
| `IMG-FPR-00105__dimension-drawing.png` | 1654 × 2339 | 188 KB | Dimensioned drawing (also spec-sheet p.2) |
| `IMG-FPR-00105__accessory-peeler-stand.jpg` | 2244 × 2244 | 313 KB | Optional stainless floor stand |
| `IMG-FPR-00105__accessory-filter-kit.jpg` | 2244 × 2244 | 1,399 KB | No-foam filter |
| `IMG-FPR-00105__REF__PI-10-sibling-model.jpg` | 2244 × 2244 | 307 KB | Sibling, for the PI-nn = kg argument |
| `IMG-FPR-00105__REF__PI-30-sibling-model.jpg` | 2244 × 2244 | 313 KB | Sibling |
| `sammic-potato-peelers-stainless-M-PI-PES-brochure.pdf` | — | 1,447 KB | Brand-level range brochure |

### 7.3 `products resource\zummo-images\` — complete, nothing added

| File | Pixels | Size | Notes |
|---|---|---|---|
| `IMG-FPR-00079__Z06-orange-specsheet-hero.png` | 1375 × 1232 | 665 KB | Official Z06 Nature render, orange bins — **best hero replacement** |
| `IMG-FPR-00079__Z06-orange-catalogue-hero.png` | 1109 × 835 | 1,809 KB | Lifestyle café render |
| `IMG-FPR-00079__Z06-dimensions-diagram.webp` | 650 × 704 | 88 KB | **Decisive on the axis swap** — 542 mm width / 427 mm depth / 810 mm height, annotated |
| `IMG-FPR-00079__spec-sheet.pdf` | — | 425 KB | **Z06 Nature datasheet M0408ENEN/23-1 — the primary source** |
| `IMG-FPR-00079__users-guide.pdf` | — | 1,164 KB | Z06A user's guide, ref 011211/01 — **rating plate `230V ~ 50Hz 1,3A 275W`**, legal name, full parts list |
| `IMG-FPR-00079__manual.pdf` | — | 443 KB | Z06 Nature maintenance instructions (D011246-04) |
| `IMG-FPR-00079__REF__spec-sheet-Z06-inox.pdf` | — | 681 KB | Z06 Inox datasheet M0409ENEN/23-1 — gives `ZI06x-N` / `ZM06x-N` reference structure |
| `IMG-FPR-00079__REF__Z06-inox-specsheet-hero.png` | 1306 × 1232 | 630 KB | Inox variant render |

### 7.4 Independent-image cross-check against stored catalogue images

| SKU | Stored hero | Independent source | Verdict |
|---|---|---|---|
| `IMG/FPR/00018` | 1512 × 1512, `R301` badge, grey composite bowl | Robot Coupe official render | **Match** |
| `IMG/FPR/00227` | 1512 × 1512, `CMP 400 V.V.` badge | Robot Coupe official render | **Match** |
| `IMG/FPR/00228` | 1512 × 1512, `CMP 300 V.V.` badge | Robot Coupe official render | **Match** |
| `IMG/FPR/00250` | `null` | Four sourced blade images | No stored image to contradict |
| `IMG/FPR/00105` | `null` | Sammic official render | No stored image to contradict |
| `IMG/FPR/00079` | **225 × 225**, Z06 Nature orange | Zummo official renders | **Right machine, unusable resolution** (§5.6) |

No wrong-machine finding in this pass — unlike Kalerm, Kusina, Sulte and Broaster. The Robot Coupe
records in particular are the best-photographed set audited so far.

---

## 8. Consolidated red flags

1. **`IMG/FPR/00079` has a null `brand_id`.** `"ZUMMO INNOCACIONES"` cannot resolve against
   `brands.json`'s `"Zummo"`. Silent, seeder-level, affects the only Zummo product in the
   catalogue. **Highest-priority fix in this pass.** §5.2
2. **`IMG/FPR/00250`'s `model_number` `2006` is fictional** as a Robot Coupe reference, and the
   "3PACK" it describes is not a purchasable Robot Coupe item. Worse, if the stocked part is a US
   `27xxx` blade it will not fit the export R 301 we sell. Keep archived. §3.4
3. **`IMG/FPR/00079` width/height transposed** — an 811 mm-wide, 431 mm-tall juicer. §5.4
4. **`IMG/FPR/00105`'s name says "P120"**, a model that has never existed at Sammic. §4.3
5. **Two stale Robot Coupe total lengths** (763 → 786, 660 → 669) from an older brochure revision. §3.3
6. **`IMG/FPR/00079`'s hero image is 225 × 225 px**, ~1/45 the pixel area of the Robot Coupe heroes. §5.6
7. **`IMG/FPR/00105` is a near-empty record** — no description, no dimensions, no technical
   specification, no image, despite Sammic publishing a complete public spec sheet. §4.1
8. **Zummo record quotes US units** ("7.5 Gal of juice/hour") that Zummo itself does not publish. §5.5
9. **`IMG/FPR/00079` lists `120 V – 60 Hz`** as a selectable option on a Kenyan storefront. Not
   wrong, but an ordering trap. §6
10. **Robot Coupe's own CMP brochure is internally inconsistent** on gross weights (CMP 400 V.V.
    listed at 4.3 kg, below the CMP 350 V.V.'s 5.0 kg). Do not import Robot Coupe gross weights. §3.1

---

## 9. Sources

Robot Coupe:
- https://www.robot-coupe.com
- https://www.robot-coupe.com/export/en/p/food-processors-r-301/18274
- https://www.robot-coupe.com/export/en/p/food-processors-r-301-ultra/18332
- https://www.robot-coupe.com/usa/en_US/p/combination-processors-r-301/18274
- https://www.robot-coupe.com/usa/en_US/p/combination-processors-r-301-dice/67831
- https://www.robotcoupe-parts.com/images/part-manual/r2n-us.pdf

Sammic:
- https://www.sammic.com
- https://www.sammic.com/en/product/pi-20
- https://www.sammic.com/en/products/potato-peelers/stainless-steel-commercial-potato-peelers
- https://www.sammic.com/en/product/pes-20

Zummo:
- https://www.zummocorp.com
- https://www.zummocorp.com/en/commercial-juicer-machines/z06
- https://www.zummocorp.com/us/commercial-juicer-machines/z06-nature
- https://www.zummo.es

Not used as a source at any point: sheffieldafrica.com (the client's own storefront — circular).
It was the top search hit for `"Z06A-N"` and was deliberately skipped.
