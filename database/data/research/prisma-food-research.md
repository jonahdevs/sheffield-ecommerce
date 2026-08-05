# Prisma Food — SAP-led research pass (July 2026)

**Supersedes `database/data/research/old/prisma-food-research.md`.** That file was written before
the SAP export existed and before any image was opened and looked at; its model-code map and its
list of CDN URLs turned out to be broadly right, but several of its specific claims are wrong and
are corrected below (see §7). Treat the old file as a lead list only.

Scope: all **9 PRISMA FOOD SKUs** — 4 pizza ovens + the 5 `IBT` spiral dough mixers. The 5 mixers
exist only as children of a variable parent in `products.json`, so they were invisible to every
earlier pass; `IMG/PAS/00012` (IBT 20) had **no model_number and no dimensions at all**.

Nothing in `products.json` or any other repo data file was modified. Research only.

---

## 1. Sources used

Everything below comes from Prismafood's own current publications, cross-checked between two
independent documents (the live website and the printed 2026 catalogue), plus third-party
distributors where a disagreement needed a tiebreak.

- https://www.prismafood.com/en
- https://www.prismafood.com/en/download-area
- https://www.prismafood.com/writable/download/attachments/prismafood_catalogo2026.pdf — **216-page
  2026 catalogue, the single most authoritative artefact found.** Every spec table has an explicit
  W / D / H icon column, so the axis order is not a matter of inference.
- https://www.prismafood.com/writable/download/attachments/folder_tunnel_250930_C.pdf — Tunnel
  range brochure (Sept 2025)
- https://www.prismafood.com/en/ovens/electric-ovens/small-basic-series/basic-150
- https://www.prismafood.com/en/ovens/electric-ovens/basic-series/basic-44
- https://www.prismafood.com/en/ovens/gas-ovens/gas-4
- https://www.prismafood.com/en/conveyor-ovens/electric-conveyor-ovens/tunnel-c50
- https://www.prismafood.com/en/mixers/spiral-mixer/ibt-series/ibt-20
- https://www.prismafood.com/en/mixers/spiral-mixer/ibt-series/ibt-30
- https://www.prismafood.com/en/mixers/spiral-mixer/ibt-series/ibt-40
- https://www.prismafood.com/en/mixers/spiral-mixer/ibt-series/ibt-50
- https://www.prismafood.com/en/mixers/spiral-mixer/ibt-series/ibt-60
- https://ahlia.store/products/pris-gas-4-pf-pizza-oven-gas-one-deck-1-262-g-30-31-kg-h
- https://ahlia.store/products/pris-ibt50-2v-spiral-mixer-2-speed-48-lt
- https://ahlia.store/products/pris-ibm50-spiral-mixer-48-lt
- https://www.fornoverde.co.uk/products/prisma-single-deck-gas-pizza-oven-4-x-12-pizzas-gas4
- https://www.empiresuppliesonline.co.uk/products/prisma-single-deck-gas-pizza-oven-4-x-12-pizzas-gas4
- https://grydle-sync.com/product/prismafood-extractable-bowl-spiral-mixer-imr-20/

Prismafood S.r.l., Via Tabina 18, 33098 Valvasone (PN), Italy. The site is fully fetch-friendly
and the Download Area needs no login.

---

## 2. THE IBT DIMENSION CONFLICT — settled: **SAP is wrong, our records are right**

### Manufacturer figures (identical in the website spec tables and in the 2026 catalogue, p.184–186)

Prisma prints machine size as **W × D × H in cm**, with an explicit icon per axis.

| Model  | Capacity | Dough | Bowl Ø | Machine W × D × H (mm) | Packing W × D × H (mm) | Net / Gross kg |
| ------ | -------- | ----- | ------ | ---------------------- | ---------------------- | -------------- |
| IBT 20 | 22 L     | 16 kg | 36 cm  | **385 × 670 × 725**    | 450 × 760 × 800        | 69 / 75        |
| IBT 30 | 32 L     | 24 kg | 40 cm  | **435 × 750 × 810**    | 495 × 775 × 860        | 78 / 85        |
| IBT 40 | 41 L     | 32 kg | 45 cm  | **480 × 820 × 850**    | 550 × 840 × 900        | 92 / 103       |
| IBT 50 | 48 L     | 40 kg | 45 cm  | **480 × 805 × 850**    | 550 × 840 × 900        | 94 / 105       |
| IBT 60 | 60 L     | 48 kg | 50 cm  | **535 × 960 × 915**    | 615 × 1035 × 970       | 147 / 161      |

### Verdict

**SAP's mixer dimensions are unusable and must not be applied. `products.json` already carries the
correct manufacturer values** (once the axis mapping in §3 is applied); `IMG/PAS/00012` is simply
missing them.

What SAP actually contains:

| SKU           | SAP L / W / H   | Correct W × D × H | Diagnosis                                                            |
| ------------- | --------------- | ----------------- | -------------------------------------------------------------------- |
| IMG/PAS/00012 | 385 / 415 / 795 | 385 / 670 / 725   | W right; **D and H are from nothing recognisable** — 795 ≈ the 800 mm packing height, 415 unexplained |
| IMG/PAS/00013 | 424 / 735 / 805 | 435 / 750 / 810   | all three low by 10–15 mm — a near-miss transcription, not the spec   |
| IMG/PAS/00014 | 480 / 805 / 828 | 480 / 820 / 850   | **IBT 50's row copy-pasted onto the 40**                             |
| IMG/PAS/00015 | 480 / 805 / 828 | 480 / 805 / 850   | W and D right, **H 828 is wrong** (850)                              |
| IMG/PAS/00016 | 480 / 805 / 828 | 535 / 960 / 915   | **IBT 50's row copy-pasted onto the 60** — 55/155/65 mm out          |

The 805 × 828 that repeats across the 20/30/40 L range in SAP is **not** a carton or pallet figure —
the real cartons are 550 × 840 × 900 and 615 × 1035 × 970. It is IBT 50's machine footprint with a
corrupted height, stamped onto the two neighbouring models. This is the "whole rows copy-pasted
across products" SAP failure mode, and it is provably that: the distributor Sheffield appears to buy
from, Al Ahlia (see §4), publishes the **correct** 480 × 805 × **850** for the IBT 50, so the 828 was
introduced downstream of the supplier, inside our own data.

Third-party corroboration for the two SAP rows that are most wrong:
IBT 60 at 535 × 960 × 915 is quoted independently at
https://grydle-sync.com/product/prismafood-extractable-bowl-spiral-mixer-imr-20/ and IBT 50 at
480 × 805 × 850 at https://ahlia.store/products/pris-ibt50-2v-spiral-mixer-2-speed-48-lt .

Note the sizes are genuinely close between the 40 and the 50 — **same width, same height, 15 mm
apart in depth** (they share a body shell and a 45 cm bowl; the 50 just holds more dough). That
similarity is what makes the copy-paste plausible to a human eye, and it is also why a photograph
can never settle which of the two you are looking at. Only the spec table can.

---

## 3. Axis order for this brand — established, not assumed

Prisma prints **W × D × H** everywhere. Our two internal stores map onto it like this:

| Store            | field 1                | field 2               | field 3  |
| ---------------- | ---------------------- | --------------------- | -------- |
| Prismafood       | W (left-right)         | D (front-back)        | H        |
| SAP `L / W / H`  | **holds the WIDTH**    | **holds the DEPTH**   | H        |
| `products.json`  | `length` = **DEPTH**   | `width` = **WIDTH**   | `height` |

So SAP's *length* and *width* are transposed relative to `products.json`, and SAP's "width" column
is really depth. Proof on three unrelated products where SAP and the manufacturer agree on the
numbers themselves:

- TUNNEL C50 — SAP 1860 / 1210 / 500, Prisma 1860 W × 1210 D × 500 H
- BASIC 1/50 — SAP 915 / 690 / 355, Prisma 915 W × 690 D × 360 H
- IBT 50 — SAP 480 / 805 / 828, Prisma 480 W × 805 D × 850 H

**Never bulk-copy SAP's L into `length`.** It belongs in `width`.

---

## 4. Who SAP is quoting

SAP's model string for the gas oven is `GAS 4 PF PROPANO`. Prisma has no such code — its code is
plain `GAS 4`. But **Al Ahlia Hotel Supplies (Jordan) sells it under item code `PRIS-GAS 4 PF`**, and
its mixers as `PRIS-IBT50 2V`, `PRIS-IBM30`, etc. — the exact "PF" tag and the exact shape of our
model strings. https://ahlia.store/products/pris-gas-4-pf-pizza-oven-gas-one-deck-1-262-g-30-31-kg-h

That is almost certainly the channel our catalogue was built from, and it explains a lot: Ahlia
publishes the GAS 4 as 1000 × 1062 × **560** where Prisma publishes 1000 × 1060 × **540**, and our
GAS 4 height is 560. **SAP's "remarks" on these SKUs are reseller marketing copy, not manufacturer
data**, which is exactly why they contain a motor on a gas oven and 130 pizzas an hour on a conveyor.

---

## 5. Verified specs, per SKU

All figures below are Prisma's, agreeing across the website spec table and 2026 catalogue unless
flagged. Dimensions are **W × D × H in mm**.

### IMG/OVE/00017 — `BASIC 1/50 LAMP` → Prisma **BASIC 1/50 2T** (SMALL BASIC series)
External **915 × 690 × 360** · chamber 620 × 500 × 120 · packing 970 × 770 × 480 · net 48 kg / gross 56 kg
1 chamber · 50–450 °C · 4.0 kW (top 2000 W ×1, bottom 2000 W ×1) · 230–400 V (17.4 A single-phase /
8.7 A three-phase) · holds **1 × Ø45 cm pizza or one 40 × 60 cm tray**, not 4 pizzas.
"LAMP" is not a Prisma code: the page reads *"On request supplied with 12V transformer and lamp
holder"*. It is the internal-light option. Real code is `BASIC 1/50 2T` ("2T" = two thermostats,
visible as the two knobs in the staged front image).

### IMG/OVE/00018 — `BASIC 44` → Prisma **BASIC 44**
External **975 × 925 × 745** · chamber 660 × 660 × 140 per deck · packing 1020 × 1020 × 900 ·
net 122 kg / gross 136 kg · 2 chambers · 50–450 °C · 9.4 kW (top 2350 W ×2, bottom 2350 W ×2) ·
230–400 V (40.9 A single-phase / 20.4 A three-phase) · 4 + 4 × Ø32 cm.
**Watch out for `BASIC 44 MEDIUM`**, a distinct catalogue model with the same 9.4 kW and the same
chamber but a smaller body: **900 × 870 × 745**. SAP's 900 / 760 / 745 has the MEDIUM's 900 in it,
which is probably where the wrong row came from.

### IMG/OVE/00019 — `GAS 4 PF PROPANO` → Prisma **GAS 4**
External **1000 × 1060 × 540** *including the chimney*; body alone is 1000 × 890, the chimney adds
170 mm of depth (catalogue drawing p.65: B = 100, C = 89, A = 106) · chamber **610 × 600 × 150** ·
packing 1040 × 940 × 600 · net 96 kg / gross 108 kg · 1 chamber · 0–450 °C · **16.1 kW gas thermal
input** = 55,000 BTU/h = 13,800 kcal/h · gas 1.262 kg/h (G30/G31 LPG) or 1.693 m³/h (G20/G25) ·
**electrical feed is 230 V only**, for controls/ignition/lamp · 4 × Ø30 cm pizzas.
"PROPANO" is a build option, not a code — Prisma requires the gas type to be stated at order
(methane or LPG butane/propane).

### IMG/OVE/00020 — `TUNNEL C/50` → Prisma **TUNNEL C50** ⚠ *two live manufacturer answers*
Chamber (belt) **500 × 750 × 100** · 0–350 °C · 14.2 kW = 48,500 BTU/h · top 2800 W ×2, bottom
4100 W ×2 · 230–400 V (**61.7 A single-phase / 20.6 A three-phase** — single-phase is legal but
brutal) · net 255 kg / gross 318 kg · packing 2035 × 1435 × 760 (catalogue) / ×790 (website) ·
stainless belt, ventilated chamber, stand standard, stackable.

Throughput depends on pizza size and Prisma publishes both: **43 pizzas/hour at Ø32 cm** (the
headline in the spec table) and **86/hour at Ø25**, 29/hour at Ø40, 26/hour at Ø45 (catalogue p.97),
measured at 3:30 bake, 320 °C, fresh dough. The old research file's bare "86 pizzas/hour" is the
Ø25 number quoted without its condition.

**External dimensions disagree between Prisma's own two publications:**

| Source                             | External       | With stand      |
| ---------------------------------- | -------------- | --------------- |
| Website product page (July 2026)   | 1860 × 1210 × 500  | 1860 × 1210 × 1030 |
| 2026 catalogue p.94                | **1900 × 1220 × 515** | **1900 × 1220 × 1050** |

SAP and `products.json` both carry the website's 1860 / 1210 / 500. I would take the catalogue as
current (it is the newer document and it agrees with the current 7" touch-panel machine shown in
both the Download Area hi-res and the page's own carousel), but this is **not resolved** — see §8.

### IMG/PAS/00012–00016 — `IBT 20 / 30 / 40 / 50 / 60`
Dimensions and weights in the §2 table. Common to all five: three-phase `IBT` line (single-phase
equivalents are the `IBM` line, a different code); fixed head and fixed bowl; stainless bowl,
spiral, central column and protection grid; oil-bath gearmotor; dough-breaker; **timer and castors
standard**; two-speed motor and the digital control head are **optional**; 60 Hz motors on request.

| Model  | Speed-1 kW | Speed-2 kW  | Supply        |
| ------ | ---------- | ----------- | ------------- |
| IBT 20 | 0.75       | 0.75 – 1.10 | 230 – 400 V   |
| IBT 30 | 1.10       | 1.30 – 1.70 | 230 – 400 V   |
| IBT 40 | 1.10       | 1.30 – 1.70 | 230 – 400 V   |
| IBT 50 | 1.50       | 1.50 – 2.20 | 230 – 400 V   |
| IBT 60 | **1.80**   | 1.50 – 2.20 | **400 V only** |

The IBT 60 has **no 230 V option and no IBM 60 single-phase sibling** — the catalogue's single-phase
row is a dash. Do not sell it as 230 V. (The old research file suspected this; it is now confirmed
from the catalogue.)

Nominal name ≠ actual bowl: 20→22 L, 30→32 L, 40→41 L, 50→48 L, 60→60 L.

---

## 6. SAP defects found — full list

Every one of the 9 SAP remarks is reseller copy and every one contains at least one error.

**Dimensions** — all 5 mixers wrong (§2). BASIC 44 wrong (900 / 760 vs 975 / 925). GAS 4 depth wrong
(930 vs 1060 with chimney / 890 without) and height 20 mm over. BASIC 1/50 height 355 vs 360.
TUNNEL C50 matches the website but not the 2026 catalogue.

**IMG/OVE/00019 (GAS 4) — a gas oven described as an electric oven.** SAP says "Motor power (Kw)
16.1" (it is gas thermal input; there is no motor), "Sheathed heating elements" (it has atmospheric
gas burners — see the staged burner photo), "Standard power supply is 400 Volt three-phases +
neutral" (it is 230 V single-phase for controls only), and gives the internal chamber as
620 × 620 × **560** — 560 is the external height leaking into the chamber field; the chamber is
610 × 600 × **150**.

**IMG/OVE/00020 (TUNNEL C50)** — "capable of cooking up to 130 x 8" - 145g pizzas an hour" is
invented; Prisma publishes 43/h at Ø32 and 86/h at Ø25 and does not publish a gram weight.
"Electric 14.2 kW. Single phase electric" — it is 230–400 V, and three-phase is the sane choice at
61.7 A single-phase. Element split (2 × 2800 top, 2 × 4100 bottom) is correct.

**IMG/OVE/00017 (BASIC 1/50)** — temperature "50 - 500" (real 450), "Motor power (Kw) 5" (real
4.0 kW of heating, no motor), "Capacity (Pcs) 4 per cycle" (real 1 × Ø45 or one 40 × 60 tray), and
the self-contradictory "Power Supply (V) 230/1/50 … Standard power supply is 400 Volt three-phases".

**IMG/OVE/00018 (BASIC 44)** — temperature "50 - 500" (real 450); "Motor power (Kw) 9.4" is heating
power. Chamber and 4+4 capacity are correct.

**Mixers** — IBT 20 dough weight 17 kg (real 16) and net weight 65 kg (real 69). IBT 30 dough weight
25 kg (real 24), net weight "86.6 kg" (real net 78, gross 85). IBT 40 gross 108 kg (real 103) and
"Power Supply (V) 230/1/50" for a three-phase machine; "Volume m3 04" is a mangled 0.4. IBT 50 gross
109 kg (real 105) and states 1.5 kW then "Three-phase motor power KW 1.1" in the same remark.
IBT 60 "Motor power (Kw) 1.5" (real 1.8) and "Single-phase motor power KW 1.1" for a model that has
no single-phase version at all.

**Model strings** — `BASIC 1/50 LAMP`, `GAS 4 PF PROPANO` and the inconsistent space in `IBT 60`
are all recorded, none changed. Real codes: `BASIC 1/50 2T`, `GAS 4`, `IBT 20/30/40/50/60`.

---

## 7. Corrections to the old research file

- It claimed the shared `IBT_24_caratteristiche.jpg` feature graphic is **"labels in Italian"**. It
  is not — it is in **English** ("VERSION WITH FIXED HEAD AND BOWL / THREE PHASE / DOUBLE SPEED").
  Whoever wrote that had not opened the file.
- It gave IBT 30 net weight as **78 kg** in one place and the SAP-derived 86.6 elsewhere; 78 net /
  85 gross is correct.
- It listed `IBM-IBT-60_24_front.jpg` as an IBT-60 image. It is **byte-for-byte the IBT 40/50 front
  photo** (see §9). Removed.
- Its per-model dimension table is otherwise correct and is confirmed here from two documents.
- Its GAS 4 external dimensions were left as our stored 1005 × 930 × 560; the manufacturer says
  1000 × 1060 × 540 (chimney included).
- Its TUNNEL C50 throughput "86 pizzas/hour" is the Ø25 figure, not the headline Ø32 figure of 43.

---

## 8. Still open

1. **TUNNEL C50 external size.** 1860 × 1210 × 500 (Prisma website) vs 1900 × 1220 × 515 (Prisma
   2026 catalogue). Both are current Prisma publications for the same machine. No third source found
   that clearly post-dates the touch-panel redesign. Needs a datasheet or a tape measure on the unit.
2. **GAS 4 height.** Prisma says 540; Al Ahlia (probable supplier) says 560, which is what SAP and
   `products.json` carry. Also unresolved whether our stored depth should be the 1060 with-chimney
   figure or the 890 body figure — for a showroom footprint the body figure is the useful one, but
   the chimney is not optional.
3. **Which BASIC 1/50 variant we actually stock.** Prisma lists `BASIC 1/50 2T` and `BASIC 1/50
   GLASS 2T`, and the internal light is an option on one row and a dash on the other. Our "LAMP" tag
   implies the light is fitted; the staged front photo shows a solid (non-glass) door.
4. **Which BASIC 44 body we stock** — standard (975 × 925) or MEDIUM (900 × 870). SAP's stray 900
   makes this worth a purchase-order check rather than a guess.
5. No per-model spiral-mixer photograph exists anywhere, from any source. IBT 40 and IBT 50 share
   one manufacturer render; IBT 20 shares one with IBT 15. Any mixer image is a body-shell image, so
   litre capacity must be carried in copy, never inferred from the picture.

---

## 9. Images and spec sheets staged

Staged to `Desktop\ecommerce\products resorce final\prisma-food\`. **64 images + 9 spec PDFs + 1
brochure**, covering **9 of 9 SKUs**. Every file was opened and looked at, not merely HTTP-200'd.

- `*-prismafood-N.jpg` — the product page's own carousel, 1066 × 735, clean white background, no
  watermark, straight from https://www.prismafood.com/writable/product/gallery/...
- `*-prismafood-hr-N.jpg` — Download Area masters, **2000–7000 px** on the long edge. Genuinely
  higher resolution, not upscales: fine detail (screw heads, refractory grain, knob printing) is
  resolved that is absent from the 1066 px versions.
- `*-prismafood-spec.pdf` — the exact catalogue pages for that model, cut from
  `prismafood_catalogo2026.pdf`. The mixer sheets carry the W/D/H icon table that settles §2.
- `_brand-reference/` — full 216-page 2026 catalogue, plus the two `mixer-ibm-ibt` studio shots that
  are **not attributable to any single litre size** and so were deliberately kept out of the SKU
  filenames.

### What was checked and what was thrown out

- **Hashed everything.** No placeholder-CDN behaviour: 41 distinct images. The repeats are Prisma's
  own shared detail shots (bowl close-up on all 5 mixer pages, tilting-grille on 4 of 5, the feature
  graphic on all 5) and are staged per SKU deliberately.
- **Deleted: `IBM-IBT-60_24_front.jpg`.** Prisma serves it under an IBT-60 filename, but a pixel diff
  against `IBM-IBT-40-50_24_front.jpg` returns an **empty bounding box — the two files are the same
  image**. It depicts a 40/50 machine. The IBT 60 is 55 mm wider with a 50 cm bowl, so this is a
  misattribution at the manufacturer's own CDN, not just a family shot.
- **Rejected before staging: `tunnel23_01_h`, `tunnel23_03_h`, `tunnel23_03el_h`.** All three are
  badged **C65** / **C65 gas** on the control tower, not C50. They sit in the same Download Area
  folder as the C50 file and are easy to grab by accident; the badge is only legible if you crop and
  enlarge the panel. `tunnel23_C50_h` is the one that reads "C50 conveyor oven".
- **Rejected: `basic-04_h`** (a *single*-deck Basic — contradicts the two-chamber BASIC 44) and
  `basic-07_h` (a deck oven stacked on a prover cabinet, i.e. extra equipment in frame).
- **Unavoidable family shots, flagged not deleted:** `forno_gas4-6_24.jpg` is the shared GAS 4/6
  front — the two models are the same 1000 mm width and differ only in depth, so their front
  elevations are identical by construction. `basic-44-66_h` likewise for BASIC 44/66.
- **Photographic confirmation of spec claims:** the GAS 4 burner shot shows atmospheric gas burners
  under the refractory floor, independently killing SAP's "sheathed heating elements"; the BASIC 44
  front shows two chambers and two control panels; the BASIC 1/50 front shows exactly two
  thermostats, confirming the `2T` code; the C50 shots show the current 7" touch panel.

Dead ends: no per-model PDF datasheets exist — Prisma publishes only the omnibus catalogue and
range brochures, so the "spec sheet" for each SKU is a catalogue extract. tomadostore.com and
archiexpo.com still 403 automated fetch.
