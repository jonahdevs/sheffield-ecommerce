# SV-Blueline Product Research

Research behind the SV-BLUELINE enrichment pass (25 SKUs), started 2026-07-30. This brand had
**no research file at all** before now — it was the largest untouched gap in the catalogue.

**APPLIED 2026-07-30 — all 25 SKUs are now house-format complete (was 0). See §6.**

## 1. Supplier — confirmed twice over

`SV` = **Snow Village**, legal name **Zhejiang Xuecun Refrigeration Equipment Co., Ltd.**
(雪村 *Xuecun* = "Snow Village"), Huibu Industrial Zone, Changshan County, Quzhou, Zhejiang.
Established 2003 · 120,000 m² · 8 production lines · 700+ staff · 500,000+ units/yr ·
40 countries · ISO9001, ISO14001, CCC, CE. Full identification in
`house-brand-suppliers-research.md` §4.

Independent confirmation from the distributor tier: snowvillageau.com carries product handles
prefixed **`xc-`** (e.g. `display-cabinet-for-deli-xc-zsg-20`) — XueCun.

## 2. ⭐ Two usable sources, and they complement each other

### 2.1 SAP `Item Remarks` — full specs on nearly every SKU

SAP carries a populated remark for **all 25** SV-BLUELINE SKUs, and they are unusually complete —
temperature, volume, power, refrigerant and compressor brand:

| SKU | Model | SAP remark (verbatim, cleaned) |
|---|---|---|
| IMG/REF/00183 | `CFD-20N1(HB)` | *upright single door solid freezer; Temperature ≤ −15 °C; Volume 430 L; Power 205 W; Refrigerant R290; Compressor brand **Secop**; copper tube refrigeration* |
| IMG/REF/00186 | `CFR-40N2F(HB)` | *upright double door solid chiller; 0–10 °C; Volume 860 L; Power 205 W; R290; Secop; 1210×805×1950 mm* |
| IMG/DIS/00126 | `DG-900FZ` | *2–8 °C; Volume 250 L; Power 400 W; R290* |
| IMG/DIS/00132 | `LC-298B` | *Rated power 135 W; Volume 298 L; consumption 1.62 kWh/24h; shock class I; **R600a**; Climatic Class N; charge 35 g; 220 V* |

This is the business's own description of the goods it buys, and for a house brand it is the
only internal record that exists. **Note the refrigerant is not uniform** — most are R290 but
`LC-298B` is **R600a**. Do not generalise it across the range.

### 2.2 snowvillageau.com — the distributor with per-model pages

Snow Village's **Australian** distributor is a Shopify store exposing
`https://snowvillageau.com/products.json?limit=250` — **154 products** with `body_html`
descriptions and images. It carries more of our codes than the Bangladesh or Singapore sites.

**15 of our 25 SKUs matched**, with descriptions up to 3,972 characters:

| SKU | Model | AU handle | imgs |
|---|---|---|---|
| IMG/REF/00183 | `CFD-20N1(HB)` | `stainless-steel-single-door-freezerfridge-cfd-20n1f` | 1 |
| IMG/REF/00202 | `CFD-60D3F-K` | `stainless-steel-triple-door-tray-freezerfridge-cfd-60d3f-k` | 2 |
| IMG/DIS/00126 | `DG-900FZ` | `square-glass-chilled-food-display-dg-900fzh4` | 3 |
| IMG/DIS/00127 | `DG-1200FZ` | `double-side-glass-door-chilled-food-display-dg-1200fzk` | 1 |
| IMG/DIS/00128 | `DG-1500FZ` | `double-side-glass-door-chilled-food-display-dg-1500fzk` | 1 |
| IMG/DIS/00130 | `DG-TZ700` | `square-glass-chilled-counter-top-food-display-dg-tz700` | 3 |
| IMG/DIS/00133 | `LC-1200(T)` | `double-glass-door-display-fridge-lc-1200fxc` | 2 |
| IMG/REF/00203 | `LC-1500(T)` | `triple-glass-door-display-fridge-lc-1500fxblack` | 3 |
| IMG/REF/00201, 00232 | `PLD-15N2F(HB)` | `stainless-double-door-workbench-freezer-pld-15n2f-700mm` | 2 |
| IMG/REF/00178 | `PLR-15N2F(HB)` | `stainless-double-door-workbench-fridge-plr-15n2f-700mm` | 1 |
| IMG/REF/00231, 00179 | `PLR-18N2F(HB)` | `plr-18n2f-760mm` | 2 |
| IMG/REF/00198 | `SD/SC-158Y` | `glass-sliding-lids-dual-temperature-chest-freezer-sdsc-158y` | 1 |
| IMG/REF/00200 | `SD/SC-518` | `dual-temperature-supermarket-island-freezer-sdsc-518` | 3 |

**Unmatched (10):** `BD/BC-388` · `CFD-40N2F(HB)` · `CFR-20N1F(HB)` · `CFR-40N2F(HB)` ·
`DG-TY700` · `LC-298B` · `LCD-639` · `LMD-1894QK` · `PLR-12N2F(HB)` · `SD/SC-2000K`.
Some exist in near-variants on the AU site (`cfd-40d4f`, `dg-1200fzh3`) — worth a closer pass.

⚠ **Image ceiling is 530 × 665, proven.** Shopify normally re-serves larger renders, but
`&width=1600`, `&width=2400` and the `_2048x` filename form all return the **identical 530 × 665,
18,219-byte file** — so that is the original upload, not a CDN limit. Below the 800 px floor.

## 3. ⚠ Depth variants collide — the matching is family-level

Several of our SKUs are the *same model code at a different depth*, and the distributor does not
distinguish them:

- `PLR-18N2F(HB)` is on **IMG/REF/00231 (1800×700)** and **IMG/REF/00179 (1800×600)**
- `PLD-15N2F(HB)` is on **IMG/REF/00201 (1500×600)** and **IMG/REF/00232 (1500×700)**

The AU listing titles are internally inconsistent too — `PLR-18N2F` is titled "(600MM)" under the
handle `plr-18n2f-760mm`, and `PLD-15N2F` is titled "(800MM)" under a `-700mm` handle. **Treat the
AU pages as family evidence, not per-depth evidence**, and take the depth from SAP.

## 4. `IMG/REF/00232` PLR → PLD — corrected, and confirmed by the distributor

`IMG/REF/00232` stored `PLR-15N2F(HB)` while its own name reads "Counter **Freezer** (Air Cooled
Freezing) 1500*700". `PLR` = chiller, `PLD` = freezer. Changed to `PLD-15N2F(HB)` on SAP's
authority, then independently confirmed: snowvillageau sells
**`stainless-double-door-workbench-freezer-pld-15n2f-700mm`** — the freezer, at 700 mm, exactly
this SKU.

Supporting evidence from the temperatures SAP records: every `PLR` unit is **0–10 °C**, while
this one is **−2 to −8 °C** — the only counter in the cluster that goes below zero.
⚠ SAP writes it as `-2-8`, which is ambiguously punctuated; read as −2 to −8 °C.

## 5. Next steps

1. Generate house-format copy for all 25 from **SAP Remarks** (complete) cross-checked against
   the **AU distributor** body copy (15 SKUs, richer prose).
2. Stage the AU images for the 15 matched SKUs — flagged **UNDERFLOOR (530 px)** with the ceiling
   proven above, since nothing better exists at the distributor tier.
3. Chase the 10 unmatched codes on the Bangladesh and Singapore sites, and on the Xuecun
   Made-in-China storefront (which lists by marketing title, not model code — search by product
   type instead).

---

## 6. APPLIED 2026-07-30 — all 25 SKUs

Copy generated for **all 25** and applied: `description`, `short_description`,
`meta_description`, `technical_specification`. **SV-BLUELINE is now 25/25 house-format
complete**, up from 0. `ProductCatalogueKeysTest` 9/9.

**Facts came from SAP `Item Remarks` plus the stored dimensions — not from the distributor.**
The AU body copy is the manufacturer's marketing prose and is copyrighted, so it was used only
to corroborate. Nothing was lifted from it.

Two remark formats had to be handled:
- **label:value** (19 SKUs) — *"Temperature(deg C) 2-8; Volume(L)- 300; Power(W)- 430;
  Refrigerant - R290"* → parsed directly into the spec table.
- **prose** (2 SKUs, `BD/BC-388` and `LCD-639`) — facts embedded in sentences, extracted with
  targeted patterns for temperature, refrigerant and capacity.
- **dimensions only** (4 SKUs: `CFD-60D3F-K`, `LMD-1894QK`, `PLD-15N2F(HB)` 00201,
  `LC-1500(T)`) — the remark is just `1820*805*1950`. Their tables carry Brand / Model / Type /
  Dimensions and nothing invented.

### 6.1 Images — 15 of 25 staged

To `Desktop\ecommerce\products resource\sv-blueline-images\` with a `_MANIFEST.md`.
**8 unique + 7 shared across variants = 11 distinct images.**

✅ **The Snow Village logo is visible on the front panel of the counter units** — independent
visual corroboration of the supplier attribution.

⚠ All are **530 × 665, below the 800 px floor, and that is the proven ceiling** (§2.2).
⚠ The `PLR` chiller and `PLD` freezer share one photo — same chassis, different refrigeration.
Family evidence, not per-SKU proof.

**10 SKUs still have no image:** `BD/BC-388` · `CFD-40N2F(HB)` · `CFR-20N1F(HB)` ·
`CFR-40N2F(HB)` · `DG-TY700` · `LC-298B` · `LCD-639` · `LMD-1894QK` · `PLR-12N2F(HB)` ·
`SD/SC-2000K`.

---

## Sourcing pass, 3 August 2026 - Cake, display and order-dish cabinets - 12 SKUs

## SV-BLUELINE — cabinets pass (12 SKUs) — FINDINGS

Cake/display cabinets + vertical & order-dish cabinets. Sibling owns counters, uprights and island
freezers; nothing of theirs was touched.

**Result: 12/12 sourced. 43 image files + 8 spec assets. 10 of 12 clear the 800 px floor.**

---

### 1. ⚠ The 530 px ceiling is DISPROVEN

The prior pass proved a 530 × 665 ceiling and it is real — but it is a property of the **Australian
distributor's Shopify uploads only**, not of Snow Village's assets. Re-confirmed here: `?width=1600`,
`?width=2400` and `?width=4000` all return the **byte-identical 530 × 665 file** (md5 `d9c97fa866…`).

Three sources sit far above it:

| Source | Ceiling found |
|---|---|
| snowvillageau.com (AU) | 530 × 665 — hard, confirmed |
| snowvillage.com.sg (SG) | 1500 × 1500, some 2048 |
| www.snow-village.com (US) | 1500 × 1500 up to **5472 × 3648** |
| **www.snowvillagefreezer.com (manufacturer)** | up to **7418 × 7418** and **5445 × 8164** |

The manufacturer's own site was never reached in the prior pass. It has an **expired TLS certificate**,
so `WebFetch` refuses it — it must be fetched with certificate verification disabled. That single
obstacle is why the best imagery for this brand had been invisible.

1:1 crops of the 5445 × 8164 files show real brushed-metal grain, dust specks and glass-edge seams —
genuine photography at native resolution, not upscaled.

---

### 2. ⚠⚠ The distributor is publishing AI-generated product photography

**Eight `Gemini_Generated_Image_*.png` files are live on snowvillage.com.sg**, and on their pages they
are the *highest-resolution* asset — precisely the trap that resolution-first selection walks into.

One of them sits on the page that serves our `SD/SC-2000K`. Rendered, it is an obviously synthetic
supermarket interior with warped background shelving and a Gemini sparkle glyph. Quarantined to
`_ai-generated\`, not used.

A second file on the same page (`6_fd91f8dc….jpg`, a three-panel café collage) is unnamed but shows
the same signature — nonsense signage text, inconsistent perspective. Filed as **suspected** AI.

⚠ **For the sibling:** the other six Gemini files are on the **chest-freezer and island-freezer**
series pages — the families behind `BD/BC-388`, `SD/SC-518` and `SD/SC-718`. Full list:

```
Gemini_Generated_Image_fx312fx312fx312f.png   Island SD/SC Standard, Two Sliding Doors
Gemini_Generated_Image_z8b4g8z8b4g8z8b4.png   Island SD/SC Static, Three Sliding (Flat)   <- ours
Gemini_Generated_Image_1223d01223d01223.png   Island SD/SC Static, Two Sliding Doors
Gemini_Generated_Image_vy66uwvy66uwvy66.png   Chest BCD, Dual Temperature
Gemini_Generated_Image_uqofhluqofhluqof.png   Chest BD/BC, Single Temp (Dual Hard Top)
Gemini_Generated_Image_lkbuthlkbuthlkbu.png   Chest BC/BD, Single Temp (Single Hard Top)
Gemini_Generated_Image_kcvn4ikcvn4ikcvn.png   Chest BC/BD, Single Temp (Single Hard Top)
Gemini_Generated_Image_yxhc1hyxhc1hyxhc.png   Chest BD/BC, Single Temp (Triple Hard Top)
```

---

### 3. ⚠⚠ SAP's dimension ORDER for this brand is DEPTH / WIDTH / HEIGHT

The dossier instructs "trust its ORDER (width, depth, height)". **That is wrong for SV-BLUELINE.**
Checked against manufacturer figures on all twelve SKUs, SAP transposes the first two fields on
**12 of 12**:

| SKU | SAP W/D/H | Manufacturer W × D × H | Order |
|---|---|---|---|
| 00126 DG-900FZ | 650/900/1200 | 900 × 650 × 1225 | transposed |
| 00127 DG-1200FZ | 650/1200/1200 | 1200 × 650 × 1225 | transposed |
| 00128 DG-1500FZ | 650/1500/1200 | 1500 × 650 × 1225 | transposed |
| 00129 DG-TY700 | 500/700/730 | 700 × 500 × 730 | transposed, values exact |
| 00130 DG-TZ700 | 500/700/730 | 700 × 500 × 730 | transposed, values exact |
| 00131 SD/SC-2000K | 1035/2000/880 | 2000 × 1035 × 880 | transposed, values exact |
| 00132 LC-298B | 515/548/1995 | 548 × 515 × 1995 | transposed, values exact |
| 00133 LC-1200(T) | 685/1200/2000 | 1200 × 705 × 2005 | transposed |
| 00203 LC-1500(T) | 685/1500/2000 | 1500 × 705 × 2005 | transposed |
| 00204 LMD-1894QK | 800/1894/1980 | 1894 × 800 × 1980 | transposed, values exact |
| 00205 LCD-639 | 790/639/1980 | 639 × 789 × 1980 | transposed, values exact |
| 00198 SD/SC-158Y | 700/600/800 | 606 × 700 × 850 | transposed |

Two things follow. First, SAP's dimension **values** are largely *right* for this brand — it is only
the field labelling that misleads. Second, `products.json` already stores these the correct way round
(e.g. DG-900FZ as 900/650/1200), so **no storefront data is wrong**; it is the dossier's stated
convention that needs correcting before anyone bulk-applies SAP dimensions to this brand.

---

### 4. Per-SKU result

`code proven` = the image is tied to this exact model, not merely to its family.

| SKU | Model | Status | Best px | Imgs | Code proven | Door / glass verified | Agrees with SAP |
|---|---|---|---|---|---|---|---|
| IMG/DIS/00126 | DG-900FZ | sourced | 1500×1500 | 4 | no | open front, 2 shelves | order yes, values no |
| IMG/DIS/00127 | DG-1200FZ | sourced | 1500×1500 | 4 | no | open front, 2 shelves | order yes, values no |
| IMG/DIS/00128 | DG-1500FZ | sourced | 1500×1500 | 4 | no | open front, 2 shelves | order yes, values no |
| IMG/DIS/00129 | DG-TY700 | sourced | **5445×8164** | 5 | no | **CURVED — verified** | yes, exact |
| IMG/DIS/00130 | DG-TZ700 | sourced | **5394×8087** | 5 | no | **SQUARE — verified** | yes, exact |
| IMG/DIS/00131 | SD/SC-2000K | sourced | 1500×1500 | 1 | no (`NEARMATCH`) | 3 sliding lids | yes, exact |
| IMG/DIS/00132 | LC-298B | sourced | 1500×1500 | 1 | no | **1 door — verified** | yes, exact |
| IMG/DIS/00133 | LC-1200(T) | sourced | **3648×5472** | 6 | no (`NEARMATCH`) | **2 doors — verified** | order yes, values partly |
| IMG/REF/00203 | LC-1500(T) | sourced | 1696×2560 | 6 | no (`NEARMATCH`) | **3 doors — verified** | order yes, height off |
| IMG/REF/00204 | LMD-1894QK | sourced | 1500×1500 | 1 | no | 3 upper doors | yes, exact |
| IMG/REF/00205 | LCD-639 | sourced | 1500×1500 | 3 | **yes** | **1 door — verified** | dims yes, temp no |
| IMG/REF/00198 | SD/SC-158Y | sourced | 1500×1500 | 3 | **yes** | **arched lid — verified** | mostly |

Nothing was unreachable. The three previously image-less SKUs — `LC-298B`, `LMD-1894QK`, `LCD-639` —
all resolved on the Singapore store, which the prior pass had not found.

---

### 5. DG-TY700 (curved) vs DG-TZ700 (square) — YES, fully distinguishable

Identical on every number (700 × 500 × 730, 270 W, 65 kg), so the glass profile is the only
discriminator — and it is unambiguous in the images:

- **DG-TY700** — front glass sweeps in a continuous arc from the top down to the base, on a black
  curved side frame.
- **DG-TZ700** — flat vertical front glass meeting the top at a right angle, silver frame.

Confirmed **three independent ways**: exact-code product photos on the US distributor; the AU
end-view line drawings (TY's end view is a curve, TZ's a rectangle); and the manufacturer's own
category split, `COUNTERTOP-CURVED` vs `COUNTERTOP-ANGLE`, at 5445 × 8164 and 5394 × 8087.

A fourth, independent corroboration: SAP's own volumes — 72 L for TY, 96 L for TZ — match the
manufacturer exactly, and the curved unit losing 24 L of usable space at identical external
dimensions is exactly what the geometry predicts.

---

### 6. Shared images — 3 of my 12 share, all tagged

Detected with a 16×16 average hash, not MD5 alone.

**`DG-900FZ` / `DG-1200FZ` / `DG-1500FZ` share their entire photo set** — all four images each,
across *two independent distributors* (AU md5 `d9c97fa866`, US md5 `9bb69373`). The AU line drawing
is explicitly labelled `900/1200/1500/1800`, so the manufacturer itself treats one drawing as
covering the range. These three cabinets differ only in width and no photograph distinguishes them.
All twelve files carry `REPRESENTATIVE-RANGE` and `code_proven: false`.

Also range-shared, though not with another of my twelve:

- `DG-TY700` ← shared with DG-TY900/TY1200 (even on the exact-code US page).
- `DG-TZ700` ← shared with DG-TZ900.
- `SD/SC-2000K`, `LC-298B`, `LMD-1894QK`, `LCD-639` ← family range shots.

Only **`SD/SC-158Y`** has a genuinely per-model image (`SD-SC-158Y_main.jpg`, single-model page).

---

### 7. Contradictions found — reported, NOT applied

1. **The three DG-\*FZ cake cabinets disagree with SAP substantially.**

   | Model | SAP L / W / H(mm) | Manufacturer |
   |---|---|---|
   | DG-900FZ | 250 L, 400 W, h1200 | 290 L, 430 W, h1225 |
   | DG-1200FZ | 300 L, 430 W, 130 kg | 400 L, 440 W, 115 kg |
   | DG-1500FZ | 350 L, 450 W, 140 kg | 507 L, 600 W, 130 kg |

   Note SAP's weights look shifted by one model (SAP's 1200FZ weight 130 kg equals the
   manufacturer's 1500FZ weight). Not applied.

2. **`LCD-639` temperature.** SAP describes a single-temperature freezer at ≤ −18 °C. The
   manufacturer's own spec sheet says **dual temperature, 0 ~ 10 °C / ≤ −22 °C**, "C-Store" family.
   Our stored copy follows SAP and is likely wrong.

3. **`LC-298B` internal SAP conflict.** SAP's remark carries both "Rated power input: 135 W" and
   "Power(W)- 162". The manufacturer says **162 W**; the 135 W figure is the bad one.

4. **`SD/SC-2000K` is the manufacturer's `SD/SC-2000KQ`.** Dimensions, volume (748 L) and power
   (480 W) all match exactly. The similarly-named `SD/SC-2000RS` is a different unit (822 deep,
   286 W) and was rejected after initially looking plausible. Flagging only — `model_number` is the
   unique ID and is not proposed for change here.

5. **`LC-1200(T)` / `LC-1500(T)`.** The "(T)" suffix appears on no distributor or manufacturer page
   anywhere. Nearest are `LC-1200FS/FX/FXC` and `LC-1500FS/FX`. SAP's `LC-1200(T)` is 820 L / 328.5 W
   / h2000 against the manufacturer's 875 L / 363 W / h2005 (FS) or h2025 (FX). The gap is wide
   enough that "(T)" is plausibly a real sub-variant rather than a typo. Tagged `NEARMATCH`.

6. **`SD/SC-158Y` height.** SAP says 800 mm — but SAP's own remark labels that figure "*Inner*
   dimensions", and the manufacturer's external height is 850 mm. Probably not a true conflict.

7. **Supplier's own data error.** The manufacturer's LCD and WSC spec tables list refrigerants as
   "R290 / R291 / R292 / R293" down the row. R291–R293 do not exist; every unit is R290. The value
   was clearly drag-filled. Treat any single refrigerant cell from those tables with suspicion.

---

### 8. ⚠ Two distributor cataloguing errors caught by looking

- **The US store's `LC-1500FS` page serves a 2-door photograph** — byte-identical (md5 `022d7e83`)
  to the image on its own `LC-1200FX` page. Had door count not been checked by eye, a 2-door
  cabinet would have been filed against our 3-door `LC-1500(T)`. Rejected.
- **The manufacturer's "ISLAND FREEZER — STATIC COOLING — PLAT FREEZER" page is the `WSC` series**,
  not the SD/SC flat range: its spec table lists WSC-1.0Q…WSC-2.4KQ at **450 mm** high, against our
  880 mm island. Its 5472 × 3648 photo was tempting on resolution alone and was discarded.

Both were caught only by rendering and reading, never by filename or metadata.

---

### 9. Spec sheets

**No PDF exists anywhere.** Checked for a downloads/catalogue page and for `.pdf` links across the
manufacturer site, all four distributor stores and every product body — zero hits. Nothing to
rasterise. What was obtained instead:

- **`IMG-REF-00205__LCD-639-3-spec.png`** — the manufacturer's own LCD spec table, fully legible:
  LCD-639 = 0~10 °C/≤−22 °C, 372 L, 340 W, 80 kg, R290, 639×789×1980, static cooling.
- **Seven dimensioned line drawings** (`…-spec.jpg`) from the AU store covering 00126–00130, 00133
  and 00203 — front/end/vertical elevations with millimetre callouts.
- The manufacturer's DG-TY, DG-TZ and SD/SC-158Y tables were downloaded and level-stretched, but
  **their value cells are genuinely blank** in the source — the tables ship empty. Not staged.
- Full specification tables for every family were recovered as **text** from distributor body copy
  (transcribed in the ledger notes, not into `products.json`).

---

### 10. Sources

https://www.snowvillagefreezer.com/list_1.html
https://www.snow-village.com/products.json?limit=250
https://snowvillage.com.sg/products.json?limit=250
https://snowvillageau.com/products.json?limit=250
https://www.snowvillagefreezer.com/show_83.html
https://www.snowvillagefreezer.com/show_123.html
https://www.snowvillagefreezer.com/show_136.html
https://www.snowvillagefreezer.com/show_139.html

⚠ The manufacturer host serves an **expired certificate** — fetching it requires disabling
certificate verification. It is otherwise the single best source for this brand.

Never sourced from sheffieldafrica.com.

---

### 11. Method notes worth keeping

- **`/products.json` on Shopify remains the highest-yield move**, and it is worth running against
  *every* regional distributor, not just the first one found. Four stores existed; they had
  different catalogues, different resolutions and different coverage. The AU store had 15/25 SKUs at
  530 px; the SG store carried the three SKUs nobody else had; the US store had the best photography.
- **A "proven ceiling" is only ever proven for one host.** Re-test on each new source.
- **A code-keyed filename proves vendor intent, not per-model provenance.** `LMD-1262-1663-1894-2218
  -1262-QK-SK-main.jpg` names our model — and serves five.
- Perceptual hashing earned its keep twice: it grouped the DG-\*FZ trio across two distributors with
  different MD5s, and it flagged the US LC-1200/LC-1500 collision.
- Do not trust a series page's title to describe its contents — "PLAT FREEZER" held the WSC range,
  and "static cooling upright" held only 2/3-door cabinets when a 1-door was needed.


---

## Sourcing pass, 3 August 2026 - Counters, uprights and island freezers - 13 SKUs

## SV-BLUELINE — counters, uprights, island/chest (13 SKUs)

Provenance pass, 2026-08-03. Covers `IMG/REF/` 00177 · 00178 · 00179 · 00183 · 00184 · 00185 ·
00186 · 00197 · 00200 · 00201 · 00202 · 00231 · 00232. The cake/display and order-dish cabinets
belong to the sibling pass and are untouched here.

**Nothing in `products.json`, `brands.json`, `storage/`, `_DOSSIER.md`, `_dossier.json` or
`sv-blueline-research.md` was edited.** All output is this file, `_sourced-counters.json`, and
78 staged images.

---

### 0. The one thing that changes this brand: a second, better distributor

The prior pass used the Australian distributor and concluded a **530 × 665 image ceiling**.
That ceiling is **REFUTED**. Snow Village's **Singapore** distributor is also a Shopify store,
also exposes `/products.json`, and serves the manufacturer's own studio renders at
**1500 × 1500 up to 3856 × 2160** — comfortably above the 800 px floor.

- https://www.snowvillage.com.sg/products.json?limit=250 — 113 products
- https://snowvillageau.com/products.json?limit=250 — 154 products

The 530 px ceiling is real **but it is the Australian distributor's ceiling only**, not the
supplier's. This is the same failure mode the effort keeps hitting: a "proven" ceiling that was
really one host's upload size.

The two sites are organised differently and that is why SG was missed:
**AU lists per model** (`CFD-20N1F`), **SG lists per series** (`Kitchen Refrigerator CFD/CFS
Premium Ventilated Cooling Series — 2/4/6 Doors`). Searching for a model code finds AU and
misses SG entirely; SG has to be found by product *type*. SG's per-series `body_html` carries
**the manufacturer's full spec table**, which is what resolves everything below.

Also reachable, despite `sv-blueline-research.md` §4.1 recording it as dead:
**https://www.snowvillagefreezer.com/** responds normally when TLS verification is disabled
(certificate expired, host fine). It has no downloads/catalogue page and no PDF — I looked
specifically, per the rasterised-catalogue lesson. **No spec sheet, catalogue or manual exists
for this brand on any of the four sites.** That gap is unchanged.

---

### 1. ⭐ THE SHARED-CODE PAIRS — RESOLVED. Neither pair is a duplicate record.

**Snow Village publishes every undercounter model in THREE depths — 600, 700 and 800 mm — under
ONE model code.** The code encodes length only. This is the manufacturer's own specification
table, reproduced verbatim on five separate distributor pages:

| Model | Capacity (L) 600 / 700 / 800 | Power (W) | Net weight (kg) 600 / 700 / 800 | Dimensions |
|---|---|---|---|---|
| `PLR-12N2F (HB)` | 171 / **212** / 255 | 275 | 67 / **73** / 78 | 1200×600/700/800×800 |
| `PLR-15N2F (HB)` | 240 / **299** / 358 | 315 | 79 / **84** / 89 | 1500×600/700/800×800 |
| `PLR-18N2F (HB)` | **310** / **385** / 462 | 335 | **85** / **90** / 95 | 1800×600/700/800×800 |
| `PLD-12N2F (HB)` | 171 / 212 / 255 | 337 | 67 / 73 / 78 | 1200×600/700/800×800 |
| `PLD-15N2F (HB)` | **240** / **299** / 358 | 398 | **79** / **84** / 89 | 1500×600/700/800×800 |
| `PLD-18N2F (HB)` | 310 / 385 / 462 | 335 | 85 / 90 / 95 | 1800×600/700/800×800 |

Source (ventilated `F(HB)` series, our exact codes):
https://www.snowvillage.com.sg/products/undercounter-refrigerator-plr-pld-pls-hb-premium-ventilated-cooling-series-two-doors-copy

Corroborated by the static (non-`F`) series and by the AU pages:
https://www.snowvillage.com.sg/products/undercounter-refrigerator-plr-pld-pls-hb-premium-series-two-doors
https://snowvillageau.com/products/stainless-double-door-workbench-fridge-plr-18n2f-700mm

**Answer to the question asked:**

> **`IMG/REF/00179` (1800×600) and `IMG/REF/00231` (1800×700) are two different products that
> the manufacturer genuinely sells under the single code `PLR-18N2F(HB)`. Likewise
> `IMG/REF/00201` (1500×600) and `IMG/REF/00232` (1500×700) under `PLD-15N2F(HB)`. Neither
> pair is a duplicate record. The manufacturer does not publish a depth suffix.**

The AU distributor hit exactly this problem and solved it in the product *title* — it sells
`PLR-18N2F` three times, titled "(600MM)", "(700MM)" and "(800MM)", and `PLD-15N2F` twice,
"(700MM)" and "(800MM)". Its handles disagree with its own titles (`plr-18n2f-760mm` is titled
"600MM"), so **the titles are the reliable half and the handles are not** — the opposite of what
the prior pass assumed. `model_number` is the unique ID and is not proposed for change; the
depth is already correctly carried in each record's own dimensions.

#### 1.1 The same table exposes six SAP errors, and they fall in a revealing pattern

SAP is exactly right wherever a record was entered on its own, and wrong wherever a record was
cloned from its neighbour.

| SKU | Code · depth | SAP volume | SAP power | SAP weight | Manufacturer | Verdict |
|---|---|---|---|---|---|---|
| 00177 | `PLR-12N2F(HB)` 700 | 212 L | 275 W | 73 kg | 212 / 275 / 73 | ✅ all three exact |
| 00178 | `PLR-15N2F(HB)` 700 | 299 L | 315 W | 84 kg | 299 / 315 / 84 | ✅ all three exact |
| 00231 | `PLR-18N2F(HB)` 700 | 385 L | 335 W | 73 kg | 385 / 335 / **90** | ✗ weight |
| 00179 | `PLR-18N2F(HB)` **600** | 385 L | 335 W | 73 kg | **310** / 335 / **85** | ✗ carries 00231's volume |
| 00201 | `PLD-15N2F(HB)` **600** | — | — | 84 kg | 240 / 398 / **79** | ✗ weight; no specs recorded |
| 00232 | `PLD-15N2F(HB)` 700 | 299 L | **315 W** | 84 kg | 299 / **398** / 84 | ✗ power is the *chiller's* |

Two further defects on **`IMG/REF/00232`**, both consistent with the record having been cloned
from the `PLR-15N2F` chiller before the PLR→PLD correction that `sv-blueline-research.md` §4
already made:

- SAP temperature reads `-2-8`; the manufacturer's freezer spec is **≤ −18 °C**. The prior
  pass read the ambiguous punctuation as "−2 to −8 °C" — the manufacturer says neither.
- SAP power 315 W is verbatim the `PLR-15N2F` chiller figure. The freezer draws 398 W.

**Report only — nothing applied.** The PLD/PLR convention itself is confirmed sound: every `PLR`
in the manufacturer's table is 0 ~ 10 °C and every `PLD` is ≤ −18 °C, with no exceptions. No
`PLR`-named-Freezer or `PLD`-named-Chiller defect remains in my 13.

---

### 2. ⭐ `CFD-20N1(HB)` is NOT truncated — and the whole upright ladder decodes

The concern was that `IMG/REF/00183`'s `CFD-20N1(HB)` had lost a trailing `F` that its siblings
carry. It has not. Two independent letters are involved and both are correct as stored.

**The digit after `N`/`D` counts DOORS ON THE CABINET, and both a full-door and a half-door
ladder exist.** Verified by counting doors in rendered photographs, not by inference:

| Code | Bays | Doors seen in photo | Evidence |
|---|---|---|---|
| `CFD-20N1(F)` | 1 | **1 full-height door** | AU photo, rendered |
| `CFD-20N2` | 1 | **2 half doors** | SG render `CFD-20N2_main.jpg`, rendered |
| `CFD-40N2(F)` | 2 | **2 full-height doors** | SG render `CFD-40D2F-K_main.jpg`, rendered |
| `CFD-40N4` | 2 | **4 half doors** | SG render `CFS-CFD-40N4_main.jpg`, rendered |
| `CFD-60D3F-K` | 3 | **3 full-height doors** | AU photo, rendered |
| `CFD-60N6` | 3 | **6 half doors** | SG render `CFR-40D4F-60D6F_HB__main.jpg`, rendered |

So `20N1 → 40N2 → 60D3` is the **full-door ladder** and `20N2 → 40N4 → 60N6` the **half-door
ladder**. Our five uprights all sit on the full-door ladder, consistently, and their names
("Single / Double / Triple Solid Door") match the doors in the photographs. **The catalogue's
door-count naming is correct on all five.**

**The trailing `F` means fan-cooled (ventilated), not a door count.** Proven by the manufacturer
running the same codes with and without it: `PLR-12N2F(HB)` on the *Premium Ventilated* series
against `PLR-12N2(HB)` on the *Premium Static* series, and `CFD-40D4F(HB)` (ventilated) against
`CFD-40N4(HB)` (static). On that reading `CFD-20N1(HB)` with **no `F`** is a **static-cooled**
unit — and SAP's own numbers agree: 430 L / 205 W / 64 kg, which are exactly the manufacturer's
**static** `CFD-20N2` figures (430 L / 205 W / 64 kg), not the ventilated `CFD-20N2 (HB)`
figures (378 L / 310 W / 85 kg).

> **`CFD-20N1(HB)` should be left exactly as it is.** The missing `F` is meaningful and correct.
> If anything the anomaly is on its chiller twin `IMG/REF/00184 CFR-20N1F(HB)`, which *carries*
> the `F` while SAP gives it the static numbers (430 L / 205 W). That one is worth a look.

Sources:
https://www.snowvillage.com.sg/products/kitchen-refrigerator-cfd-cfs-cfr-standard-static-cooling-series-two-four-doors
https://www.snowvillage.com.sg/products/kitchen-refrigerator-cfd-cfs-premium-ventilated-cooling-series-2-4-6-doors
https://www.snowvillage.com.sg/products/kitchen-refrigerator-cfs-cfr-cfd-premium-static-cooling-series-4-6-doors
https://snowvillageau.com/products/stainless-steel-single-door-freezerfridge-cfd-20n1f

#### 2.1 One unresolved wrinkle, stated honestly

AU's `CFD-20N1F` carries specs **identical to the digit** of SG's `CFD-20N2 (HB)` — 378 L,
310 W, 85 kg, 610×805×1950 — yet AU's photo shows one full door and SG's render shows two half
doors. Either AU relabels the half-door unit as `N1`, or Snow Village builds one cabinet both
ways and shares a spec line. I could not settle it. Both images are staged against 00183 so the
next pass can see the conflict rather than inherit a choice.

#### 2.2 `CFD-40N2F(HB)` / `CFR-40N2F(HB)` — SAP looks arithmetic, not measured

SAP gives both 00185 and 00186 **860 L and 205 W**. 860 is exactly 2 × the 430 L it gives the
single-bay 00183/00184, and 205 W is *identical* to the single-bay figure — a two-bay cabinet
cannot draw the same power as a one-bay cabinet. The manufacturer's nearest published two-bay
units are 800–963 L at 295–470 W. **These two SAP rows read as doubled arithmetic rather than
recorded specification.** Reported, not applied.

The exact strings `CFR-20N1F`, `CFD-40N2F` and `CFR-40N2F` appear **nowhere** in either
distributor catalogue or on the factory site. They are Sheffield-side full-door renderings of
codes the manufacturer publishes on the half-door ladder.

---

### 3. ⚠ SAP's dimension ORDER is Depth / Width / Height on this brand — and SAP contradicts itself

`_DOSSIER.md` states "trust its ORDER (width, depth, height)". **For SV-BLUELINE that is wrong.**
The cleanest proof needs no external source at all — four rows where SAP's own `Item Remarks`
disagree with SAP's own dimension fields, in order:

| SKU | SAP W/D/H fields | SAP's own remark | Reading |
|---|---|---|---|
| 00186 `CFR-40N2F(HB)` | 805 / 1210 / 1950 | `1210X805X1950mm` | fields are **D/W/H** |
| 00202 `CFD-60D3F-K` | 805 / 1820 / 1950 | `1820*805*1950` | fields are **D/W/H** |
| 00201 `PLD-15N2F(HB)` | 600 / 1500 / 800 | `1500*600*800` | fields are **D/W/H** |
| 00200 `SD/SC-518` | 750 / 1475 / 880 | `1475*750*880` | fields are **D/W/H** |

Confirmed externally: the manufacturer writes every dimension **W × D × H**
(`1200*700*800`, `610*700*1950`, `1475*757*860`), which matches the second field of SAP, not
the first. **This holds on all 13 of my SKUs with no exception.**

Good news: **`products.json` already stores these correctly as W/D/H** — the transposition was
absorbed during the earlier enrichment pass. The correction needed is to the *dossier's stated
rule*, so the next pass on this brand does not re-transpose them.

#### 3.1 SAP weight `84.0` is a placeholder

`84.0` appears on **10 of the 25** SV-BLUELINE SKUs, spanning a chest freezer, an island
freezer, a counter, a triple-door upright and three display cabinets — products whose real
weights range from 60 to 200 kg. It is a default value. (It happens to be *correct* for 00178,
which is coincidence.) Treat SAP weight on this brand as unrecorded unless corroborated.

#### 3.2 Other SAP contradictions found

- **00197 `BD/BC-388`** — SAP describes it "SINGLE TEMPERATURE DOUBLE TOP FREEZER" and its
  remark is a near-verbatim copy of the manufacturer's page text. The manufacturer publishes
  **two** `BD/BC-388` builds: a single-temperature one (388 L, 150 W, 60 kg, 1400×675×910,
  0 ~ 10 **or** ≤ −18 °C) and a dual-temperature one it brands **`BCD-388`** (388 L, 380 W,
  95 kg, 1400×675×910, R600a). SAP's temperature wording ("0 to +10 °C **or** ≤ −18 °C") matches
  the **single-temperature** row, so the SKU is correctly identified — but SAP's stored
  dimensions (1440×695×900) differ from the manufacturer's (1400×675×910) on all three axes.
  Sources: https://www.snowvillage.com.sg/products/chest-freezer-series-single-temperature and
  https://snowvillageau.com/products/dual-temperature-chest-freezer-bcd-388
- **00200 `SD/SC-518`** — manufacturer says 518 L, 297 W, 75 kg, **1475×757×860**. Our
  `products.json` already stores 1475/757/860 **exactly**; SAP's 750/1475/880 is wrong on depth
  and height. products.json wins here.
  https://www.snowvillage.com.sg/products/island-freezer-sd-sc-series-static-cooling-curved
- **00202 `CFD-60D3F-K`** — 1395 L, 1033 W, 200 kg, 1820×805×1950, −23 ~ −18 °C. Matches SAP's
  dimensions exactly (once transposed) and matches the manufacturer's `CFS-60N6F` 3-door tray
  freezer figure-for-figure. This is my **only code-exact, spec-exact, door-count-verified SKU**.
  https://snowvillageau.com/products/stainless-steel-triple-door-tray-freezerfridge-cfd-60d3f-k

---

### 4. ⚠⚠ AI-generated imagery on the supplier's own distributor — 3 caught

Staged to `_ai-generated\`, not deleted. **None of them is used for any SKU.**

| File | px | Why | Would have served |
|---|---|---|---|
| `Gemini_Generated_Image_vy66uwvy66uwvy66.png` | 1728×2444 | Self-declaring filename; **Gemini sparkle watermark bottom-right**; duplicated/blurred chef figures; a nonsense "Explore Our Curated Collection" card standing *inside* the open freezer; garbled tub labels | 00197 `BD/BC-388` |
| `Static-Cooling-760-11.jpg` | 2160×2160 | **No filename tell.** Melting wall-cabinet geometry, incoherent counter joinery, the "Snow Village" wordmark rendered smeared and *twice* on one unit, diffusion sheen | 00183 `CFD-20N1(HB)` |
| `Ventilated-Tray-Freezer-Series-1.jpg` | 2160×2160 | **No filename tell.** Same signature: warped upper cabinetry, illegible duplicated wordmark, generic bottles, impossible drawer/door structure | 00202 `CFD-60D3F-K` |

The last two are the dangerous ones and the exact case the standard warns about: **clean
product-family filenames, plausible 2160 px resolution, correct door count, sitting in the
official gallery — and unmistakable only once viewed.** They passed every heuristic I had.
Two of the three were the *highest-resolution* asset on their page, so a "pick the biggest"
rule would have shipped both.

Genuine assets are easy to tell apart once you know: real Snow Village renders are on plain
white, carry a crisp legible **Snow Village** wordmark, and are named for the model
(`CFD-20N2_main.jpg`, `SD-SC-518-618_main.jpg`, `PLR-PLD-12-15-18-N2F_HB__main.jpg`).

**Every one of the 78 staged images was opened and viewed.** No synthetic image is staged
against a SKU.

---

### 5. ⚠ Shared photographs — 12 of my 13 SKUs share at least one image

Detected with a 16×16 average perceptual hash, which is what caught it: the AU distributor's
duplicates are **re-encoded, so their MD5s all differ**.

The worst case, and it is exactly the predicted chiller/freezer confusion:

> One single photograph serves **four** AU listings at once — `PLR-18N2F (700MM)`,
> `PLR-15N2F (800MM)`, `PLD-12N2F (600MM)` and `PLD-15N2F (800MM)`. That is **two chillers and
> two freezers at three different depths and two different lengths** behind one image, with four
> distinct MD5s.

Also identical-by-pixel: `plr-18n2f-760mm` ("600MM") vs `plr-18n2hb` ("800MM"), both images.
And on SG, the ventilated and static undercounter series share 8 of their 9 photos — meaning
**the manufacturer itself illustrates fan-cooled and static units with the same pictures.**

**Consequence: `code_proven` is `false` for 12 of 13.** Only `IMG/REF/00202 CFD-60D3F-K` has an
image on a page carrying its exact code with matching specs and a verified door count.

Every shared file is tagged `REPRESENTATIVE-RANGE` in its filename and in the ledger.
**No shared photograph is stored under a bare code-asserting filename.**

---

### 6. Per-SKU result

`code_proven` = the image sits on a page bearing this exact model code.
`door_count_verified` = doors were counted in a rendered photograph and match the product name.

| SKU | Code | Status | Best px | code_proven | doors verified | agrees with SAP |
|---|---|---|---|---|---|---|
| IMG/REF/00177 | `PLR-12N2F(HB)` | sourced | 1500×1500 | no (range) | ✅ 2 | ✅ vol+power+weight exact |
| IMG/REF/00178 | `PLR-15N2F(HB)` | sourced | 1500×1500 | no (range) | ✅ 2 | ✅ vol+power+weight exact |
| IMG/REF/00179 | `PLR-18N2F(HB)` 600 | sourced | 1500×1500 | no (range) | ✅ 2 | ✗ volume + weight |
| IMG/REF/00231 | `PLR-18N2F(HB)` 700 | sourced | 1500×1500 | no (range) | ✅ 2 | ✗ weight only |
| IMG/REF/00201 | `PLD-15N2F(HB)` 600 | sourced | 1500×1500 | no (range) | ✅ 2 | ✗ weight; SAP has no specs |
| IMG/REF/00232 | `PLD-15N2F(HB)` 700 | sourced | 1500×1500 | no (range) | ✅ 2 | ✗ power + temperature |
| IMG/REF/00183 | `CFD-20N1(HB)` | sourced | 1500×1500 | no (near) | ✅ 1 / 2 — see §2.1 | ✗ depth 760 vs 700 |
| IMG/REF/00184 | `CFR-20N1F(HB)` | partial | 1500×1500 | no (representative) | ✅ 1 | ✗ code unpublished |
| IMG/REF/00185 | `CFD-40N2F(HB)` | sourced | 1500×1500 | no (near) | ✅ 2 | ✗ volume/power look doubled |
| IMG/REF/00186 | `CFR-40N2F(HB)` | partial | 1500×1500 | no (representative) | ✅ 2 | ✗ volume/power look doubled |
| IMG/REF/00202 | `CFD-60D3F-K` | sourced | 530×665 | ✅ **yes** | ✅ 3 | ✅ dimensions exact |
| IMG/REF/00197 | `BD/BC-388` | sourced | 1500×1500 | no (range) | ✅ 2 top lids | ✗ all three dimensions |
| IMG/REF/00200 | `SD/SC-518` | sourced | 1500×1500 | no (range) | ✅ 2 sliding lids | ✗ SAP depth+height; products.json correct |

**13 of 13 have imagery. 11 sourced, 2 partial** (00184 and 00186 are chillers illustrated by
their freezer twin — the chassis is identical and the difference is not photographable).

**Resolution:** 10 of 13 have a primary asset at **1500 × 1500**, above the 800 px floor.
`IMG/REF/00202` is the exception at 530 × 665 — its only code-exact page is the AU one, and I
chose the code-exact 530 px image over a larger but AI-generated alternative. Files below the
floor carry `UNDERFLOOR` in the filename.

**Spec sheets / catalogues / manuals: none found, and none exists.** Checked all four Snow
Village sites including a crawl of the factory's own `snowvillagefreezer.com` product listings.
Nothing to render.

---

### 7. Independent corroboration of the supplier attribution

The **Snow Village** wordmark is legible on the front panel, canopy or control fascia of
rendered photographs for the counters, all five uprights, the chest freezer and the island
freezer — **every one of my 13 product families**. Combined with SG's `xc-` handles (XueCun)
noted in the prior pass, the SV = Snow Village = Zhejiang Xuecun attribution is now visually
confirmed across the whole of my range, not just the counters.

Compressor brands, from the manufacturer's tables: **Donper / Wanbao** on the counters and
uprights, **Huayi** on the island freezers, **Secop** on the ventilated tray freezers. SAP names
Secop on 00183/00184/00185/00186 — the uprights — where the manufacturer names Donper/Wanbao;
Secop appears on the tray-freezer line instead. Another SAP/manufacturer disagreement, reported
only. A `_brand-reference\snowvillage-compressor-brands.jpg` plate is staged.

---

### 8. Sources

https://www.snowvillage.com.sg/products.json?limit=250
https://snowvillageau.com/products.json?limit=250
https://www.snowvillagefreezer.com/
https://www.snowvillage.com.sg/products/undercounter-refrigerator-plr-pld-pls-hb-premium-ventilated-cooling-series-two-doors-copy
https://www.snowvillage.com.sg/products/undercounter-refrigerator-plr-pld-pls-hb-premium-series-two-doors
https://www.snowvillage.com.sg/products/kitchen-refrigerator-cfd-cfs-cfr-standard-static-cooling-series-two-four-doors
https://www.snowvillage.com.sg/products/kitchen-refrigerator-cfd-cfs-premium-ventilated-cooling-series-2-4-6-doors
https://www.snowvillage.com.sg/products/kitchen-refrigerator-cfs-cfr-cfd-premium-static-cooling-series-4-6-doors
https://www.snowvillage.com.sg/products/kitchen-refrigerator-cfd-ventilated-single-temperature-series-2-3-doors
https://www.snowvillage.com.sg/products/chest-freezer-series-single-temperature
https://www.snowvillage.com.sg/products/chest-freezer-series-dual-temperature-dual-hard-top
https://www.snowvillage.com.sg/products/island-freezer-sd-sc-series-static-cooling-curved
https://snowvillageau.com/products/stainless-steel-single-door-freezerfridge-cfd-20n1f
https://snowvillageau.com/products/stainless-steel-triple-door-tray-freezerfridge-cfd-60d3f-k
https://snowvillageau.com/products/stainless-steel-double-door-tray-freezerfridge-cfd-40d2f-k
https://snowvillageau.com/products/stainless-double-door-workbench-fridge-plr-18n2f-700mm
https://snowvillageau.com/products/plr-18n2f-760mm
https://snowvillageau.com/products/plr-18n2hb
https://snowvillageau.com/products/stainless-double-door-workbench-freezer-pld-15n2-700mm
https://snowvillageau.com/products/dual-temperature-chest-freezer-bcd-388
https://snowvillageau.com/products/dual-temperature-supermarket-island-freezer-sdsc-518

Not used as a source: sheffieldafrica.com (our own data, circular).

---

### 9. For the next pass

1. **Re-run the Singapore catalogue against the other 12 SV-BLUELINE SKUs.** The sibling's
   cake/display and order-dish cabinets are all there as series pages with 2048–3856 px assets
   (`cake-showcase-dg-tz-countertop-series-*`, `combination-freezer-lmd-*`,
   `upright-glass-door-showcase-lc-*`). The prior pass's "10 SKUs have no image" is very likely
   solvable now.
2. **Correct `_DOSSIER.md`'s dimension-order rule for this brand** to Depth/Width/Height (§3).
3. **Decide the six SAP counter corrections in §1.1** — volumes, powers and weights, all
   evidenced against the manufacturer's own table.
4. Do not touch `model_number` on either shared-code pair. The ambiguity is the manufacturer's,
   and both records are legitimate.
