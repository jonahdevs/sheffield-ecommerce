# Berjaya — research

Brand: BERJAYA (Berjaya CKE International Sdn. Bhd., Malaysia)
Primary source: https://berjayacke.com
Catalogue of record: https://berjayacke.com/wp-content/uploads/ProductBrochure/Berjaya-Quality-Foodservice-Equipment-2024.pdf

---

## GN container / lid family + water urn — duplicate-image fix (2026-08)

Eleven SKUs had been staged with byte-identical images: a family/range photo standing in for every
individual size, under filenames that asserted a specific model code. This section records what was
established while fixing that. Staging folder:
`Desktop\ecommerce\products resorce final\berjaya\` — ledger `_sourced-gnfix.json`,
full write-up `_FINDINGS-gnfix.md`.

### Berjaya publishes no per-size photography for GN pans or lids

Catalogue page 23 (*Stainless Steel Foodpan* / *Stainless Steel Foodpan Cover*) carries exactly one
tray-of-many-pans shot (native 731 × 535) and one tray-of-many-covers shot (native 610 × 515). The
size tables are typeset text with no per-row render. Every embedded image on the page was extracted
with PyMuPDF `extract_image()` to confirm this. Distributors (naritafnbequipment, berjayacke,
singmah, sharaf) all reuse the same two range shots.

**Consequence: a Berjaya-branded per-size pan or lid image does not exist.** Anything per-size for
this family must be a correct-fraction/correct-depth representative from another maker, flagged as
such. Do not spend time re-searching for one.

### Catalogue spec table — page 23 (authoritative footprints)

Food pans, model form `FP <fraction>-<depth code>`, dimension L × W × D (mm):

| fraction | 2.5 (65 mm) | 4 (100 mm) | 6 (150 mm) | 8 (205 mm) | pcs/carton |
|---|---|---|---|---|---|
| Full 1/1 | 530×325×65 | 530×325×100 | 530×325×150 | 530×325×205 | 6 |
| Half 1/2 | 325×265×65 | 325×265×100 | 325×265×150 | 325×265×205 | 12 |
| Third 1/3 | 325×176×65 | 325×176×100 | 325×176×150 | — | 18 |
| Quarter 1/4 | 265×162×65 | 265×162×100 | 265×162×150 | — | 24 |
| Sixth 1/6 | 176×162×65 | 176×162×100 | 176×162×150 | — | 36 |
| Ninth 1/9 | 176×108×65 | 176×108×100 | 176×108×150 | — | 48 |

Food pan covers: `FP11C` Full, `FP12C` Half, `FP13C` Third, `FP14C` Quarter, `FP16C` Sixth,
`FP19C` Ninth (6/12/18/24/36/48 per carton). Note the catalogue prints the cover codes **without**
the slash (`FP11C`); our `model_number` uses `FP 1/1C`.

These are the standard EN 631 footprints, so SAP being blank on length/width for these parts is
expected and is not a conflict.

### ⚠ EN 631 makes three of these fractions visually identical

1/1 (530×325), 1/4 (265×162) and 1/9 (176×108) all have an aspect ratio of **1.63**. On a plain
white studio background with no scale reference, a 1/1 lid and a 1/9 lid cannot be told apart. Only
1/2 (1.23) and 1/3 (1.85) are provable by eye. Any future pass reviewing GN imagery should not
claim to have "verified" a 1/1, 1/4 or 1/9 from the photograph alone — and should prefer photos
where the fraction is **stamped on the part**, which some Chinese makers (Yusheng, Jicheng) do.

Depth is worse: suppliers almost always shoot GN pans from nearly overhead, foreshortening the wall
to nothing. Depth is realistically supplier-attested, not observed.

### Useful representative sources (proven ceilings)

- **Guangdong Buphex** — separate page, model code and photograph for *every fraction × depth*.
  The only source found that resolves depth at all. Ceiling **800 × 800** (`2f0j00…` prefix on
  `image.made-in-china.com`; `?new_width=1600&size=max` still returns 800).
  https://buphex2020.en.made-in-china.com
- **Guangzhou Changing / gnpans.com** — per-fraction stainless lids, 1/1 through 1/9.
  Ceiling **750 × 750**, i.e. 50 px under the usual 800 px short-edge floor. Careful: their
  `Changing Factory Price 1/2 Gn Pan Cover` listing is a **notched** (spoon-recess) lid; the plain
  1/2 is the `Changing Kitchenware Container … 1/2 Size Gastronom Gn Pan Lid` listing.
  https://gdchanging.en.made-in-china.com
- mondialcarrelli / gastronorm.it (open2b platform) — clean per-depth Italian product shots but
  capped at **800 × 589**, under the floor. `-800-` in the path works; `-1000-`/`-1200-` 404.

### Water urn WU-CH range — page 18

Header: **"Stainless Steel Electrical Water Urn (Concealed Element)"**. Polished 304 body,
brass faucet, thermostatic control.

| model | litres | cups | H × Ø (mm) | W | packing (L×W×H) | kg |
|---|---|---|---|---|---|---|
| WU-CH-20L | 20 | 90 | 430 × 275 | 2800 | 330×330×460 | 5.3 |
| WU-CH-30L | 30 | 140 | 450 × 330 | 2800 | 360×360×500 | 5.9 |
| WU-CH-40L | 40 | 190 | 460 × 380 | 2800 | 410×410×510 | 7.0 |
| WU-CH-50L | 50 | 240 | 538 × 380 | 2800 | 410×410×565 | 8.0 |

Berjaya publishes **one photograph for the whole range and captions it `WU-CH-50L`**; berjayacke,
singmah, sharaf and diamondglare all reuse it. The only genuinely per-model assets are the four
front-view line drawings on page 18 (each captioned with its model and annotated with H and Ø) —
native linework only ~280 px, so they will never meet an 800 px floor.

### ⚠ IMG/COF/00002 — SAP says "EXPOSED ELEMENT", Berjaya says concealed. Berjaya is right.

No field changed; recorded for a human decision.

SAP: `HEATED WATER URN WITH EXPOSED ELEMENT 40 LITRES`, model `U 40`.
Ours: `Heated Water Urn with Concealed Element Berjaya (WU-CH-40L)`, 380 × 380 × 460.

1. Catalogue page 18 is headed *(Concealed Element)* and lists WU-CH-40L. There is no
   exposed-element **urn** anywhere in the 25-page Foodservice 2024 brochure.
2. `CH` in `WU-CH` = concealed heater.
3. SAP's own figures identify the concealed unit: SAP remarks say "No. of cups 190" and SAP height
   is 460 — the catalogue's WU-CH-40L row is exactly 190 cups, 460 × 380.
4. Berjaya's exposed-element machines are the separate **"Water Boiler"** range — BJY-WB23/WB40/
   WB60/WB80 (rectangular, 680–940 mm tall) and WB-GA/WBTT-GA/WBTT-EA (80 L). None is 40 L at
   460 mm with 190 cups.
5. diamondglare's WU-CH-40L listing independently says "concealed heating elements", and its
   410 × 410 × 510 figure is the catalogue's packing dimension for WU-CH-40L.

**Our "Concealed Element" naming is correct; the SAP description is wrong for this SKU.**

### SAP `U 40` vs our `WU-CH-40L` — same product, not a conflict

Sharaf Kitchen Equipment lists it as **"S/S electric water urn with heater(U40(WU-CH-40L))"** —
both codes on one product, specs `40 L / 3 kW 220-240 V / 380 × 460 mm / 7 kg / Brand: Berjaya`.
`U 40` is the short legacy code. `model_number` left untouched.

Berjaya's other "U" series (`BJY-U20-B`, `BJY-U30-B`, water boiler with PU insulation) is also
described as *concealed heater*, so a `U` code never implies an exposed element.

WU-CH-30L and WU-CH-40L are genuinely two distinct products — separate catalogue rows, capacities,
cup counts, dimensions, drawings and reseller listings. (History note: they had previously been
merged into one record and one was lost to a null; that merge was wrong.)

### ⚠ Open item — IMG/COF/00001 (WU-CH-30L)

Out of scope for the 2026-08 pass and left untouched, but it carries the identical defect: its four
image files are byte-identical to those staged against IMG/COF/00002 and are the range photo
captioned `WU-CH-50L`, under filenames asserting `WU-CH-30L`. Needs the same `REPRESENTATIVE-RANGE`
flagging plus its own page-18 front-view drawing (450mm(H) × 330mmØ).

### ⚠ Do not trust the older `berjaya-images` generics

In `Desktop\ecommerce\products resource\berjaya-images\` (superseded staging):
`IMG-TCW-00091__REPRESENTATIVE-gn-1-3-100mm-pan-generic.jpg` is a **Heavybao group shot of three
different pans**, and `IMG-TCW-00090__…-gn-1-2-100mm-…` shows a pan far deeper than 100 mm
(wall ≈ 0.6–0.7 of the 265 mm short side; 100 mm would be 0.38) — its depth claim is likely wrong.
Its `00086` (stamped `1/3`) and `00087` (stamped `1/4`) files are good on fraction and much larger
(2873×2158 / 2119×1592) if a stamped photo is ever preferred over a per-depth listing.

---

## Sources

https://berjayacke.com/wp-content/uploads/ProductBrochure/Berjaya-Quality-Foodservice-Equipment-2024.pdf
https://berjayacke.com/our-products/food-service-equipment/water-boiler/
https://berjayacke.com/our-products/food-service-equipment/water-boiler/electrical-water-urn-concealed-element/
https://berjayacke.com/our-products/food-service-equipment/water-boiler/water-boiler/
https://berjayacke.com/our-products/food-service-equipment/water-boiler/water-boiler-2/
https://berjayacke.com/our-products/food-service-equipment/water-boiler/water-boiler-with-pu-insulation-electrical/
https://sharafkitchenequipment.com/products/s-s-electric-water-urn-with-heateru40wu-ch-40l
https://www.diamondglare-store.com/shop/berjaya-1045-water-boiler-berjaya-wu-ch-40l-159902
https://www.naritafnbequipment.com/product/berjaya/stainless-steel-perforated-food-pan
https://buphex2020.en.made-in-china.com/product/dXcxKmZzfvpH/China-Buphex-Stainless-Steel-Gastronorm-Container-1-3-GN-Pan-65mm-Deep-Size-325X176mm.html
https://buphex2020.en.made-in-china.com/product/XvVxCUOHkBpo/China-Buphex-Stainless-Steel-Gastronorm-Container-1-4-GN-Pan-65mm-Deep-Size-265X162mm.html
https://buphex2020.en.made-in-china.com/product/ZKhmrCFTfSpP/China-Buphex-Stainless-Steel-Gastronorm-Container-1-1-GN-Pan-100mm-Deep-Size-530X325mm.html
https://buphex2020.en.made-in-china.com/product/MShmiqFblvpD/China-Buphex-Stainless-Steel-Gastronorm-Container-1-2-GN-Pan-100mm-Deep-Size-325X265mm.html
https://buphex2020.en.made-in-china.com/product/eBWxvoOHyKUX/China-Buphex-Stainless-Steel-Gastronorm-Container-1-3-GN-Pan-100mm-Deep-Size-325X176mm.html
https://gdchanging.en.made-in-china.com/product/bUARurwYghWo/China-Changing-Kitchenware-Container-High-Quality-Stainless-Steel-1-1-Size-Gastronom-Gn-Pan-Lid.html
https://gdchanging.en.made-in-china.com/product/uRYUsexrYkcS/China-Changing-Kitchenware-Container-High-Quality-Stainless-Steel-1-2-Size-Gastronom-Gn-Pan-Lid.html
https://gdchanging.en.made-in-china.com/product/JTgUvjKbZhVW/China-1-3-Gastronorm-Gn-Pan-Lid-Third-Size-Stainless-Steel-Tray-Cover.html
https://gdchanging.en.made-in-china.com/product/cULptgwMJDWE/China-Changing-Kitchenware-Container-High-Quality-Stainless-Steel-1-4-Size-Gastronom-Gn-Pan-Lid.html
https://gdchanging.en.made-in-china.com/product/ipDRjKxrJHkU/China-Changing-Kitchenware-Container-High-Quality-Stainless-Steel-1-9-Size-Gastronom-Gn-Pan-Lid.html
https://www.mondialcarrelli.com/en/Stainless-steel-Gastronorm-pans-GN-1-2
https://www.gastronorm.it/en/Gastronorm-GN-1-9-108x176-mm
