# Cancan Product Research

Research notes behind a CANCAN enrichment/audit pass on `products.json` (July 2026).
Covers the single CANCAN SKU in the catalogue: `IMG/FPR/00123` "Automatic Orange Juicer
Cancan 38", `model_number: CANCAN 38`, category Juice Processors, `status: published`.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema and Santos passes before a scope decision.

Headline result: the product **is** a real Cancan machine and every stored number that
could be checked is correct — but the record is stored under a **family name, not a model
number**, and it carries the same **width/height axis swap** already documented for
Santos, Empero and Brema.

---

## 1. Brand identification

**Cancan** = **Cancan Meyve Presleri San. Tic. Ltd. Şti.** ("Cancan Fruit Presses"), a
Turkish manufacturer of citrus juicing and kitchen-prep equipment.

- Founded **1958 in Ankara** by the late Salih Özüuğurlu, originally repairing kitchen
  appliances and building orange-squeezing machines.
- Second generation (Tunç Özüuğurlu) took over in **1984** and still runs it; trademark
  registered 1989/1994.
- Production moved from Ankara to **Sakarya in 2000**; today a **6,500 m²** plant at
  Yeşiltepe Mah., Erenler / Sakarya, doing its own CNC turning and milling in house.
- **Automatic** orange juicers (our product's line) only entered production in **2007** —
  before that the range was manual presses.
- Current range: manual and automatic orange/pomegranate/grapefruit/lemon presses, can
  openers, pineapple peelers, cutters/slicers, pre-rinse faucet equipment, pot washing.

Sources:
https://cancan.com.tr/en/about-us/
https://cancan.com.tr/en/

### `brands.json` check

`website_url` is **https://cancan.com.tr/en/** — **verified correct**, returns HTTP 200
directly with no redirect. The English site is a full mirror of the Turkish one, not a
stub. No change needed.

The stored `description` — *"CanCan specializes in food processing and preparation
equipment. They provide solutions for commercial food processing operations."* — is
technically true but generic, and it misses the thing the brand is actually known for:
**citrus juicers are its flagship and founding product line** (65+ years). Worth
broadening if brand copy is ever revisited; not a data error, so not flagged as a fix.

---

## 2. Where to look

| Resource | URL | Value |
|---|---|---|
| Official EN product pages | `https://cancan.com.tr/en/all-products/<slug>/` | Full "Additional Information" spec table — **the primary source for this pass** |
| Official TR product pages | `https://cancan.com.tr/tum-urunler/<slug>/` | Same tables in Turkish; used to cross-check and to reach models with no EN page |
| Product sitemap | https://cancan.com.tr/product-sitemap.xml | The only reliable way to enumerate the 38-series — the category pages don't list them |
| US distributor (Tribest Professional) | `https://tribest.com/products/cancan-38-*` | English marketing copy + a clean 2048×2048 studio shot (watermarked) |

### Traps

1. **The category pages are useless for discovery.** Both
   `.../product-category/juicing-equipments/` and `.../all-products/` render their
   product grid client-side, so a plain fetch returns only the "New Products" strip and
   two featured manual juicers — no 38-series at all. Use the **product sitemap** instead.
2. **Duplicate/empty product slugs exist.** The sitemap lists `38-bardakli-2`,
   `38-depolu-2`, `38-fresh-2` and `38-fresh-cift-posa-kovali` alongside the real pages;
   all four return a page with **no spec table** (unpublished duplicates). Only the
   un-suffixed slugs carry data.
3. **Tribest's dimension figures are broken.** Their 0203 page states "2.6 × 2 × 1.1 ft"
   (≈79 × 61 × 34 cm) — the height is obviously wrong for a 98 cm machine. Their weight
   (167.5 lb = 76 kg) and electricals *do* match the factory. **Use cancan.com.tr for any
   dimension, never Tribest.**
4. **Reseller listings silently quote the trolley variant.** mutbex.com's "Cancan 38 with
   Storage" page gives 64.5 × 71 × 208.5 cm / 117.6 kg — that's the `0204+1101`
   tank-plus-mobile-cart bundle, not a bare 38. Several Turkish resellers do the same.

---

## 3. "CANCAN 38" is a family, not a model number ⚠

This is the single biggest finding of the pass.

**"38" is the throughput rating — 38 fruits per minute — not a model code.** Cancan's
actual model numbers are 4-digit product codes. At least **four distinct machines**
currently ship under the "38" name, all sharing the identical motor (0.37 kW), identical
15 kg basket and identical 38 pcs/min capacity, but with completely different cabinets,
footprints and weights:

| Cancan code | Product name | W × D × H (mm) | Weight | Official page |
|---|---|---|---|---|
| **0203** | 38 with Glass (*38 Bardaklı*) | **750 × 580 × 980** | **76 kg** | https://cancan.com.tr/en/all-products/38-with-glass/ |
| 0204 | 38 with Tank (*38 Depolu*) | 690 × 700 × 980 | 77 kg | https://cancan.com.tr/en/all-products/38-with-tank/ |
| 0205 | 38 Fresh | 690 × 980 × 980 | 77 kg | https://cancan.com.tr/en/all-products/38-fresh/ |
| 0208 | 38 with Cooler (*38 Soğutmalı*, on trolley) | 850 × 820 × 1810 | 149 kg | https://cancan.com.tr/tum-urunler/38-sogutmali/ |

(A fifth, `0206` "28 Café Type", is the smaller 28 pcs/min sibling — different family.)

### Which one is ours: **0203, "38 with Glass"** — confirmed two independent ways

1. **Dimensions match exactly and uniquely.** Our record's own prose spec says
   `LENGTH 750 / WIDTH 580 / HEIGHT 980` — that is 0203's 750 × 580 × 980 to the
   millimetre, and it matches **no other** member of the family.
2. **The stored product photo is 0203.** `products/automatic-orange-juicer-cancan-38-imgfpr00123.jpeg`
   shows the bench-top machine with the amber polycarbonate cover, a glass on the drip
   tray under the spout, and **two white peel bins flanking the base** — the exact
   configuration of the official 0203 render at
   https://cancan.com.tr/wp-content/uploads/2023/09/0203.jpg. The 0204 has a closed juice
   tank, the 0205 a self-service tap, the 0208 a full trolley cabinet; none look like our
   photo.

**Recommendation (not applied):** the `model_number` is functionally ambiguous — "CANCAN 38"
matches four sellable machines with a 2:1 spread in footprint and price. The correct
manufacturer code is **`0203`**. Per [[feedback_model_number_unique_id]] this is recorded
here rather than changed; it needs an explicit approval since `model_number` is the
catalogue's unique ID.

---

## 4. Per-SKU findings — IMG/FPR/00123

### 4.1 The width/height axis swap ⚠ (confirmed, same bug as Brema/Santos/Empero)

Stored numeric fields and the stored prose spec **contradict each other**, exactly the
pattern documented for Brema CB-416A and CB-640A:

| | length | width | height |
|---|---|---|---|
| Stored numeric fields | 750 | **980** | **580** |
| Stored prose `technical_specification` | 750 | **580** | **980** |
| Official (0203, W × D × H) | 750 (width) | 580 (depth) | 980 (height) |

The **prose is right; the numeric fields are wrong.** The numeric `width` (980) is really
the **height**, and the numeric `height` (580) is really the **depth**. `length` (750) is
correct under this catalogue's convention of storing the front-facing width there.

Fix would be: `length: 750, width: 580, height: 980`.

Note this is the *simple two-field swap* (Brema shape), not the three-axis rotation seen on
most Santos SKUs.

### 4.2 Specs that are already correct

Verified against the official 0203 "Additional Information" table:

- **Power 370 W** — official `0,37 kW`. ✅
- **Fruit storage 15 kg** — official `Orange Basket 15 kg`. ✅ (28 kg hopper is an
  official option; not currently mentioned in our record.)
- **Stainless steel body / stainless fruit basket** — official. ✅
- **Automatic feeder** — official ("rotating disc", automatic feed-cut-squeeze). ✅
- The "38" in the product name genuinely is the capacity. ✅

### 4.3 Specs that are wrong or missing

| Field | Stored | Official 0203 | Note |
|---|---|---|---|
| Voltage | `220 V` | **220-240 V** | Under-stated, not wrong; 240 V is the practical Kenyan figure |
| Frequency | *(absent)* | **50-60 Hz** | Missing |
| Nominal current | *(absent)* | **2.5 A** | Missing |
| Weight | *(absent)* | **76 kg** | Missing — significant for a bench-top unit; needs a reinforced counter |
| Squeezing capacity | *(absent from spec table)* | **38 pcs/min** | Missing from the spec table even though it's in the product name |
| Fruit diameter | *(absent)* | **Ø 60-80 mm** | Missing — important, undersized/oversized fruit won't feed |
| Optional hopper | *(absent)* | **28 kg optional** | Missing |
| Dimensions | see §4.1 | 750 × 580 × 980 mm | Numeric fields swapped |

### 4.4 Output rate — no litres/hour figure exists ⚠

Unlike the Santos pass (where every leaflet gives l/h), **Cancan publishes no litres/hour
figure for any machine in the 38 family** — the factory rates them purely in *fruits per
minute*. 38 pcs/min is ~2,280 fruits/hour, but converting that to litres would require
assuming a juice yield per orange, which is fruit- and season-dependent.

**Do not invent an l/h figure for this record.** Quote `38 fruits/minute` as the capacity,
the same way the manufacturer does.

### 4.5 Do NOT import the "5 litre juice tank" spec ⚠

Reseller and Tribest copy for the 38 family repeatedly mentions a **5 L juice collection
tank** and a **70 kg peel-waste container**. Both belong to the **0204 / 0205 / 0208**
variants. The **0203 has neither** — it dispenses straight into a glass on the drip tray,
and peel drops into the two open side bins visible in the photo. The official 0203 spec
table lists no tank and no waste capacity.

This is exactly the cross-contamination-between-siblings failure mode logged in the Santos
pass (§2 trap 3) and the Pradeep milk-boiler bug, and it is the most likely way a future
enrichment pass would corrupt this record.

### 4.6 Description content available but unused

The official 0203 page carries feature copy our record doesn't have, all worth adding:

- Juice and peel never touch, so peel acids don't enter the juice — flavour preservation.
- One-button fully automatic feed → cut → squeeze → pulp/juice separation.
- Rotating disc feeds oranges into the chute one at a time.
- Large side feeding wire, Ø ~100 mm, loads several oranges at once.
- **Removable components are dishwasher safe.**
- **Safety switch on the front cover** stops the machine when the cover is opened.
- **Cleaning/drain pipe** for discharging pulp and liquid residue.
- Self-cleaning system; hands-free (hygienic) operation.
- **Optional lemon kit** for lemon juicing.
- Target use: hotels, restaurants, cafés, kiosks, supermarkets, schools/universities,
  hospitals, dormitories, production facilities.

Source: https://cancan.com.tr/en/all-products/38-with-glass/

---

## 5. Product reference

| SKU | Catalogue name | Stored model | Real Cancan code | Official page | Cross-check | Confidence |
|---|---|---|---|---|---|---|
| IMG/FPR/00123 | Automatic Orange Juicer Cancan 38 | CANCAN 38 (family name, §3) | **0203** | https://cancan.com.tr/en/all-products/38-with-glass/ | https://cancan.com.tr/tum-urunler/38-bardakli/ and https://tribest.com/products/cancan-38-with-glass-automatic-orange-juicer-203 | **High** — official EN+TR spec tables agree exactly, dimensions and photo both pin it to 0203 |

Full official 0203 spec table, verbatim:

| | |
|---|---|
| Product Code | 0203 |
| Product Name | 38 with Glass Automatic Orange Juicer |
| Weight | 76 kg |
| Width | 75 cm |
| Depth | 58 cm |
| Height | 98 cm |
| Frequency | 50-60 Hz |
| Voltage | 220-240 V |
| Nominal Current | 2,5 A |
| Power | 0,37 kW |
| Orange Basket | 15 kg |
| Orange Diameter | Ø 6-8 cm |
| Orange Squeezing Capacity | 38 Pcs/min. |

---

## 6. Red flags / open questions

1. **`model_number: "CANCAN 38"` is not unique** (§3). Four current machines answer to it.
   Needs approval before any change; the correct code is `0203`.
2. **Numeric dimension fields are swapped** (§4.1) — the storefront currently renders this
   980 mm-tall machine as 980 mm *wide* and 580 mm *tall*.
3. **No l/h output exists** (§4.4) — resist the temptation to fabricate one for
   consistency with the Santos juicers in the same category.
4. **The 5 L tank / 70 kg waste specs belong to sibling variants** (§4.5).
5. **Which variant does the supplier actually ship?** Everything here assumes the 0203,
   which is what the current photo and dimensions say. If Sheffield actually stocks the
   0204 (tank) or 0208 (cooled trolley), the dimensions, weight and price would all be
   different and the record would need rebuilding rather than correcting.
6. **Price sanity** — the record's KES 321,250 sits between Tribest's US list of
   $5,725 (0203) and $10,550 (0208). Consistent with a 0203 at Kenyan landed cost;
   nothing anomalous, noted only as a soft confirmation of the variant call.

---

## 7. Image sourcing (July 2026) — downloaded to `Downloads/cancan-images/`

Cancan's product pages hold their image URLs as ordinary `<img>`/srcset entries under
`cancan.com.tr/wp-content/uploads/2023/09/`, so no DOM extraction trick was needed (unlike
Brema's lazy-load `data-src`). Pulled straight via `curl`; no auth or referer required.

**9 files.** The catch: apart from the single 0203 hero render, **the "38" product pages
all share one common set of close-up detail shots**, and those detail files are named
`0204-1101.*` — they were shot on the 0204-with-trolley unit. The parts photographed
(basket, rotating disc, front cover, drain pipe) are **identical across the whole 38
family**, so they're valid, but they are not 0203-specific and none of them is a second
full-body angle.

| File | What it is | Source |
|---|---|---|
| `IMG-FPR-00123__Cancan-0203-38-with-glass-official.jpg` | **Primary candidate.** Full-body 0203 render, 675×828, clean white background, matches the stored catalogue photo exactly | https://cancan.com.tr/wp-content/uploads/2023/09/0203.jpg |
| `IMG-FPR-00123__Cancan-0203-38-with-glass-render.jpg` | 1710×994 hero crop — **top half of the machine only** (basket + chute), not a full product shot | https://cancan.com.tr/wp-content/uploads/2023/09/203-png-1-e1773296611321.jpg |
| `IMG-FPR-00123__Cancan-0203-tribest.jpg` | 2048×2048, by far the highest-res full-body 0203 shot — but **carries a "Tribest Professional" watermark**, so unusable as-is | https://tribest.com/cdn/shop/files/0203_2e683389-7b6b-475f-97f8-325402713a6d.jpg |
| `IMG-FPR-00123__Cancan-38-detail-fruit-basket.jpg` | 2048×1133 close-up of the stainless top basket and feed chute | https://cancan.com.tr/wp-content/uploads/2023/09/0204-1101.5-scaled-e1696832074975-2048x1133.jpg |
| `IMG-FPR-00123__Cancan-38-detail-rotating-disc.jpg` | 2048×1598 top-down of the yellow rotating feed disc inside the hopper | https://cancan.com.tr/wp-content/uploads/2023/09/0204-1101.11-scaled-e1696832179564-2048x1598.jpg |
| `IMG-FPR-00123__Cancan-38-detail-front-cover.jpg` | 1706×1429 of the amber polycarbonate front cover, removed | https://cancan.com.tr/wp-content/uploads/2023/09/0204-1101.13-scaled-e1696832237213.jpg |
| `IMG-FPR-00123__Cancan-38-detail-drain-pipe.jpg` | 1429×1284 close-up of the stainless cleaning/drain pipe | https://cancan.com.tr/wp-content/uploads/2023/09/0204-1101.7-scaled-e1696832330268.jpg |
| `IMG-FPR-00123__VARIANT-REF-Cancan-0204-38-with-tank.jpg` | **Reference only — different machine.** 0204 with juice tank | https://cancan.com.tr/wp-content/uploads/2023/09/0204.jpg |
| `IMG-FPR-00123__VARIANT-REF-Cancan-0205-38-fresh.jpg` | **Reference only — different machine.** 0205 Fresh with self-service tap | https://cancan.com.tr/wp-content/uploads/2023/09/0205.jpg |

Notes for whoever adopts these:

- The two `VARIANT-REF-` files are **deliberately not** candidates for this SKU — they are
  there so the §3 variant call can be re-checked by eye against the supplier's actual unit.
- The existing stored image (`automatic-orange-juicer-cancan-38-imgfpr00123.jpeg`) is only
  **7 KB** and visibly low resolution. Replacing it with the official 675×828 render is a
  straight upgrade even though it's the same artwork.
- **Not yet copied into `storage/app/public/products/` or referenced in `products.json`** —
  staged in Downloads for review first, same workflow as the Brema and Santos passes.

---

## 8. Nothing applied

Per the brief this was a findings-only pass. `products.json` and `brands.json` are
untouched. The changes this pass *would* recommend, in priority order:

1. Fix the numeric dimension swap → `length: 750, width: 580, height: 980` (§4.1).
2. Add the missing verified specs: 76 kg, 38 pcs/min, Ø 60-80 mm fruit, 220-240 V,
   50-60 Hz, 2.5 A, optional 28 kg hopper (§4.3).
3. Rebuild `description` + `technical_specification` to the Skymsen prose + `<h3>Key
   Features</h3>` + `<table>` pattern using the §4.6 copy, and add a `meta_description`
   (the record currently has none).
4. Upgrade the product image (§7).
5. **Separately, with approval:** decide whether `model_number` becomes `0203` (§3, §6.1).
