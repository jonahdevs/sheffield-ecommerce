# Berjaya Product Research

Research notes behind the BERJAYA enrichment/audit pass on `products.json` (July 2026).
Covers all 15 BERJAYA SKUs: 10 Gastronorm pans and covers, 2 water urns, a four-glass
display chiller, a 20 L planetary mixer, and an insect killer. Every page and image URL
below was verified live.

**This pass found four real data errors, one of them serious** — see §5.

---

## 1. Brand identification

**Berjaya Steel Product Sdn Bhd**, Malaysia — founded **1980**, HQ in Cheras, Klang Valley,
12 branches, ISO 9001:2015 / SIRIM certified, exports to 60+ countries. Ranges cover
commercial refrigeration, electric and gas cooking, foodservice equipment, bakery machinery
and stainless fabrication.

**Renamed in 2024 to Berjaya CKE International Sdn Bhd**, trading as **"Berjaya CKE"**,
following a partnership with AIGF Singapore (a Mitsubishi-sponsored PE firm). The old
`berjayasteel.com` domain now redirects to `berjayacke.com`.

**Not related to Berjaya Corporation Berhad**, the large Malaysian hotels/retail
conglomerate. Shared name only, no ownership link found — do not cite conglomerate sources
when researching this brand.

---

## 2. Where to look — and the traps

| Resource | URL |
|---|---|
| Official site | <https://berjayacke.com> |
| Old domain (redirects) | berjayasteel.com |
| Service manual portal (login-gated, dead end) | servicemanual.berjayacke.com |

**There are no per-product spec sheet PDFs, and no master catalogue PDF.** Specs live in
HTML `<table>` blocks on each product page. The upside is that those tables are complete —
capacity, external and packing dimensions, wattage, voltage, weight, refrigerant, container
loading counts. So throughout §3 the spec source is the on-page table.

Undocumented brochure PDFs *do* exist at
`berjayacke.com/wp-content/uploads/ProductBrochure/{Category}/{Product}.pdf` (e.g.
`CommercialRefrigerator/Display-Chiller.pdf`) but they are **not linked from any product
page** and none exists for our display chiller or mixers.

### Traps

1. **Product page URLs are never model-code-based.** The pattern is
   `berjayacke.com/our-products/{category}/{subcategory}/{product-slug}/` with
   **descriptive-English slugs** and a **required trailing slash**. You cannot construct a
   URL from a model code — search instead. Best method:
   `site:berjayacke.com <descriptive product name>`, *not* the model code (codes rarely
   appear in slugs or page titles).
2. **The old domain breaks automated fetching.** `berjayasteel.com` 301-redirects
   cross-host, which makes WebFetch return a redirect notice instead of content. Always
   target `berjayacke.com` directly.
3. **Slug collisions with `-2` suffixes** and near-duplicate names (`water-boiler/` vs
   `water-boiler-2/`). Verify by page content, not by slug.
4. **Berjaya's own typo is load-bearing.** The insect killer page is titled *"Insert
   Killer"* and its slug is `/insert-killer/`. Correcting the spelling 404s the fetch.
5. **Image asset paths ARE model-code-based** — `wp-content/uploads/New-{Category}/{SubRange}/{MODELCODE}.jpg`
   — which makes them the best handle available. But this does **not** hold for the
   Gastronorm range, which uses descriptive filenames under a different directory (see §4).
6. **One page often serves many SKUs.** The whole 10-SKU Gastronorm range is a single
   WooCommerce variable product; both water urns share one page; the mixer page carries the
   entire 5.5–38 L range.

### Catalogue codes are stripped variants of Berjaya's

| Our `model_number` | Official Berjaya code | Note |
|---|---|---|
| `BJY-4GDC-78L` | `BJY-4GDC78L-A` | no hyphen before 78L; `-A` is the current orderable code |
| `I/BSP-BM20` | `BJY-BM20` | `I/BSP-` is a house prefix, drop it |
| `IK30` | `BJY-IK30A` | |
| `U 30` / `U 40` | `WU-CH-30L` / `WU-CH-40L` | legacy codes, renamed by Berjaya c. 2022 |
| `FP 1/1-4` etc. | `FP 1/1-4` | **exact match** for pans |
| `FP 1/1C` etc. | `FP11C` … `FP19C` | slashes and spaces removed for covers |

`model_number` fields have been updated to the official codes for the urns, insect killer,
display chiller and mixer. The GN pans already matched; GN cover codes are recorded in the
spec tables.

---

## 3. Product reference

| SKU | Catalogue name | Model | Official page | Spec source |
|---|---|---|---|---|
| IMG/TCW/00086 | GN Container 1/3 65 Berjaya | FP 1/3-2.5 | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page table — 325×176×65 |
| IMG/TCW/00087 | GN Container 1/4 65 Berjaya | FP 1/4-2.5 | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page table — 265×162×65 |
| IMG/TCW/00089 | GN Container 1/1 100 Berjaya | FP 1/1-4 | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page table — 530×325×100 |
| IMG/TCW/00090 | GN Container 1/2 100 Berjaya | FP 1/2-4 | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page table — 325×265×100 |
| IMG/TCW/00091 | GN Container 1/3 100 Berjaya | FP 1/3-4 | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page table — 325×176×100 |
| IMG/TCW/00097 | GN Lids 1/1 Berjaya | FP11C | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page cover table — code + carton only |
| IMG/TCW/00098 | GN Lids 1/2 Berjaya | FP12C | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page cover table — code + carton only |
| IMG/TCW/00099 | GN Lids 1/3 Berjaya | FP13C | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page cover table — code + carton only |
| IMG/TCW/00100 | GN Lids 1/4 Berjaya | FP14C | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page cover table — code + carton only |
| IMG/TCW/00102 | GN Lids 1/9 Berjaya | FP19C | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page cover table — code + carton only |
| IMG/COF/00001 | Heated Water Urn 30 Litres Berjaya | WU-CH-30L | [electrical water urn concealed element](https://berjayacke.com/our-products/food-service-equipment/water-boiler/electrical-water-urn-concealed-element/) | on-page table — 4-model shared |
| IMG/COF/00002 | Heated Water Urn 40 Litres Berjaya | WU-CH-40L | [electrical water urn concealed element](https://berjayacke.com/our-products/food-service-equipment/water-boiler/electrical-water-urn-concealed-element/) | on-page table — 4-model shared |
| IMG/DIS/00001 | Pastry Display Four Glass Berjaya | BJY-4GDC78L-A | [four glass display chiller](https://berjayacke.com/our-products/commercial-refrigerator/display-range/display-chiller-blank/) | on-page table — 3-model shared |
| IMG/PAS/00001 | Cake Mixer Planetary 20 Litres Berjaya | BJY-BM20 | [bakery mixer without netting](https://berjayacke.com/our-products/bakery-machinery/mixer/bakery-mixer-without-netting/) | on-page table — 6-model shared, 50/60 Hz variants |
| IMG/HYS/00179 | Insect Killer Berjaya IK30 | BJY-IK30A | [insert killer](https://berjayacke.com/our-products/food-service-equipment/insect-killer/insert-killer/) | on-page table — 2-model shared |

Note the mixer page carries **both a 50 Hz and a 60 Hz table**. Kenya is 240 V / 50 Hz, so
`BJY-BM20` (50 Hz) is the correct SKU, not `BJY-BM20-60`.

Also note `BJY-BM20` is the **without-netting** variant. `BJY-BM20N` is a genuinely
different SKU with a wire bowl guard, on a different page.

---

## 4. Image sourcing

Berjaya's photography is thinner than their spec data. **Only 4 distinct images cover all
15 SKUs**, because most ranges use one shared family photo rather than per-model shots.
Images were verified live but **deliberately not downloaded or wired into `products.json`**
— listed here for manual review first.

| Image URL | Covers | Verified |
|---|---|---|
| <https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/ChafingCateringEquipment/food-pan.jpg> | all 5 GN pans (00086, 00087, 00089, 00090, 00091) | 200, image/jpeg, 19,745 B, 400×400 |
| <https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/ChafingCateringEquipment/food-pan-cover.jpg> | all 5 GN covers (00097, 00098, 00099, 00100, 00102) | 200, image/jpeg, 21,473 B, 400×400 |
| <https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/BeverageEquipment/Water-Urn.jpg> | both urns (00001, 00002) | 200, image/jpeg, 14,455 B |
| <https://berjayacke.com/wp-content/uploads/New-CommercialRefrigerator/DisplayRange/BJY-4GDC78L.jpg> | display chiller (IMG/DIS/00001) | 200, image/jpeg, 50,345 B |
| <https://berjayacke.com/wp-content/uploads/New-BakeryMachinery/BJY-BM10.png> | mixer (IMG/PAS/00001) ⚠ | 200, image/png, 63,651 B |
| <https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/DWasher_InsertK_AirCooler/BJY-IK40A-1.jpg> | insect killer (IMG/HYS/00179) ⚠ | 200, image/jpeg, 12,265 B |

**Caveats to check before using:**

- ⚠ **Mixer** — the file is named `BJY-BM10.png` but is the shared gallery image captioned
  "Bakery Mixer Without Netting (10L / 20L / 30L)". It is the correct body style for the
  BM20, but there is no BM20-specific asset (`BJY-BM20.png` etc. all 404).
- ⚠ **Insect killer** — the only live image on the page is `BJY-IK40A-1.jpg`, i.e. the
  **40 A** photograph. The page uses a model dropdown with one shared hero image, so it is
  legitimate for the IK30A, but it is not a photo of our exact model. `BJY-IK30A.jpg` and
  `BJY-IK30A-1.jpg` both 404.
- **GN images are only 400×400** with no larger original (only `-150x150` thumbs exist
  besides). Fine as a card thumbnail, likely too small for a product-page hero.
- **The model-code image pattern does not apply to the Gastronorm range** — it uses
  descriptive filenames under `Foodservice_Equipment/ChafingCateringEquipment/`.
- `BJY-4GDC78L-A.jpg` 404s; the `-A` code has no separate asset, use `BJY-4GDC78L.jpg`.

Alternative smaller urn asset also verified live:
`.../BeverageEquipment/Water-Urn-300x300.jpg` (200, 7,647 B).

---

## 5. Data audit — errors found and corrected

### 5.1 Both water urns were described as the wrong product type ⚠ serious

Both SKUs were named **"Heated Water Urn with Exposed Element"**. **Berjaya has never
published an exposed-element water urn.** This is a factual misdescription of a functional
characteristic — a concealed element is the premium arrangement (the element never contacts
the water, so descaling and cleaning are far easier), and selling it as "exposed" both
understates the product and misinforms the buyer.

Evidence, which is unusually strong:

1. A Wayback CDX sweep of the **entire** `berjayasteel.com` domain (all `/product/` and
   `/products/` URLs, 2015→2023) returns exactly **two** urn products ever — both
   concealed. No `WU-EH` code, no "exposed" page, no third urn family.
2. **The decisive link:** the 2015–2019 legacy page `berjayasteel.com/product/water-urn/`
   uses the image file **`U20-U30-U40-U50-280x320.jpg`**, proving the legacy `U 20/30/40/50`
   codes are the same single family Berjaya later renamed to `WU-CH-20L…50L`. A 2022
   capture confirms the rename against an identical spec table.
3. Distributor corroboration: sharafkitchenequipment.com lists the product literally as
   `U40(WU-CH-40L)`.
4. Visual check of the archived legacy images against the current `Water-Urn.jpg` — same
   squat all-welded lidded urn with side spigot and thermostat knob in every generation, no
   exposed element anywhere.

**Corrected**: both renamed to "Concealed Element", `model_number` updated to `WU-CH-30L` /
`WU-CH-40L`, and the concealed element written into the description and spec table. Neither
is discontinued — both are current products.

### 5.2 The 30 L urn's dimensions belonged to a different product ⚠ serious

The catalogue held **310 × 640 mm** for the 30 L urn. That is not `WU-CH-30L`. It is
exactly the machine dimension of **`BJY-U30-B`** — a *different* Berjaya urn family,
"Electrical Water Urn (Concealed **Heater**)", Ø310 × H640, 2600 W, 3.92 kg, at
[water-boiler-with-pu-insulation-electrical](https://berjayacke.com/our-products/food-service-equipment/water-boiler/water-boiler-with-pu-insulation-electrical/).

Whoever populated the row matched on "30 L" and took the figures from the wrong page.
**This is why the 30 L appeared wider than the 40 L** — the two rows came from two
different product families.

Correct `WU-CH-30L` figures: **H 450 × Ø 330 mm, 2,800 W, 5.9 kg, ~140 cups**. Applied.

(The alternative reading — that the SKU really is a `BJY-U30-B` — fails because that family
only exists in 20 L and 30 L, so it cannot be the source of the `U 40` sibling. The legacy
`U20-U30-U40-U50` image filename settles it.)

### 5.3 The 40 L urn's dimensions were in the wrong fields

`460 × 380` is correct for `WU-CH-40L` — but it is **H 460 × Ø 380**, and had been stored as
`length: 460, width: 380` with no height. Remapped to `length: 380, width: 380, height: 460`
(a circular footprint bounding box), with the diameter stated explicitly in the spec table.

### 5.4 The display chiller's dimensions match no published source

The catalogue held **426 × 380 × 955**. Berjaya currently publishes **452 × 406 × 966**.

The `-A` revision theory turned out to be wrong: raw HTML shows `BJY-4GDC78L` and
`BJY-4GDC78L-A` are two codes stacked in one merged table column **sharing a single spec
set**. Three figures circulate in the wild but all share identical packing dimensions
(475×432×1038), weight (34 kg), wattage (164 W), shelf count (3) and container loading — so
this is one physical product whose published external-dimension figure was restated over
time, not multiple revisions:

| Figure | Source | Status |
|---|---|---|
| 452 × 406 × 966 | berjayacke.com, current | **current official — now applied** |
| 428 × 386 × 960 | restaurantsupplies.com.np, mirroring an older Berjaya catalogue | superseded |
| 426 × 380 × 955 | **our catalogue, before this pass** | matches nothing exactly; closest to the superseded figure, off by 2/6/5 mm |

Our figure was a stale third-hand value. Corrected to the current official one, and
`model_number` set to `BJY-4GDC78L-A` since Berjaya's order dropdown now only offers `-A`
codes.

### 5.5 Wattage drift among distributors — do not trust resellers on this

Several distributors (sharafkitchenequipment.com, sevenfive.co.th) quote **3 kW / 3000 W**
for the U30/U40 urns. Berjaya's own table says **2,800 W**. Likewise fullykitchen.com.my
mis-states `BJY-U30-B` as 3600 W against Berjaya's 2600 W. We use Berjaya's figures.

There is also a **live typo on berjayacke.com itself**: `WU-CH-50L` "No. of Cups" reads
`1240` where the 2022 archive says `240`. Doesn't affect our two SKUs, but don't scrape cup
counts blindly.

### 5.6 Non-errors worth recording

- **The GN "65" / "100" depth labels are correct.** Berjaya publishes depth in mm and their
  figures are exactly 65 and 100. The inch suffixes in the model codes (`-2.5`, `-4`) are
  **nominal series labels, not conversions**, and they don't round consistently: `-2.5`→65
  (63.5 up), `-4`→100 (101.6 down), `-6`→150, `-8`→**205** (203.2 up). Never compute mm
  from the suffix; read the table.
- **All five GN pan footprints match EN 631 exactly**, so these are true Gastronorm and
  interchangeable with any standard GN rail or bain marie.

---

## 6. What Berjaya does not publish — left blank rather than invented

- **GN capacity in litres.** Not published for any pan. Left null. If a figure is ever
  required, standard GN nominal is 1/1-100 ≈ 13.5 L, 1/2-100 ≈ 6.5 L, 1/3-100 ≈ 4.0 L,
  1/3-65 ≈ 2.5 L, 1/4-65 ≈ 1.7 L — and it must be marked as derived, because raw geometric
  L×W×D overstates by ~25% (it ignores corner radii and wall taper; FP 1/1-4 computes to
  17.2 L but holds ~13.5 L).
- **GN cover dimensions.** Berjaya's cover table publishes only model code, size class and
  carton quantity. Our cover records carry the matching pan's EN 631 opening as the
  footprint — defensible, since a lid must match its pan — with no height.
- **GN steel grade, gauge, NSF rating, dishwasher/bain-marie statements, lid style** (flat
  vs notched vs sealed). The entire published feature list is three bullets: stainless steel
  material, available in multiple sizes, suitable for restaurant/hotel/catering. Verified as
  a house pattern, not a one-page gap — the sibling Perforated Food Pan and Vegetable Pan
  pages are equally sparse. Covers **are** confirmed stainless (table headed "STAINLESS
  STEEL FOODPAN COVER"), so not polycarbonate.
- **Display chiller**: compressor make/model, defrost type (implied automatic by the "frost
  free" claim), gross weight.
- **Mixer attachments**: the spec table gives separate whisk/beater/hook RPMs, so all three
  tools are part of the machine spec, but there is no official "accessories included" row.
  Distributor copy (Qualipro, aajjo) itemises SS bowl + spiral hook + beater + balloon
  whisk — treated as *medium* confidence and not asserted as fact.
- **Insect killer**: construction material and mounting method. The 105 mm depth and slab
  form factor imply wall or chain/ceiling mounting, but Berjaya doesn't state it. Notably
  their spec table omits material here, unlike the urns where 304 stainless is explicit —
  so do not assume stainless.

Conflicting distributor data deliberately ignored: Qualipro lists the BM20 as
530 × 460 × 880 mm / **95 kg**; Berjaya's official 430 × 530 × 880 / 68 kg supersedes it
(95 kg is likely gross/crated weight).

---

## 7. Open item for you

**IMG/HYS/00179 (Insect Killer) is `archived` but is a current Berjaya product.**
`BJY-IK30A` is live on berjayacke.com alongside the IK40A. Left archived because that is a
stocking decision, not a data correction — but worth revisiting now that it has full specs.

---

## 8. Range gaps

Berjaya makes these in the same lines, if the range is worth filling:

- **Gastronorm**: full 1/6 and 1/9 **pan** ranges, the 150 mm and 205 mm depths across all
  fractions, and the `FP16C` sixth-size cover. Note we currently stock a **1/9 cover
  (00102) with no matching 1/9 pan**.
- **Planetary mixers**: BM5-B (5.5 L), BM7-B (7.5 L), BM10 (10 L), BM30 (28 L), BM40 (38 L),
  plus a full mirrored `N` netted range including BM60N (60 L, three-phase). BM30 is nearly
  free to add — same footprint class and speeds as our BM20, just 1500 W. Digital-control
  and timer variants also exist.
- **Display chillers**: BJY-4GDC98L (98 L, 4 shelves) and BJY-4GDC235CD (235 L floor
  model) sit directly above our 78 L on the same page.
- **Water urns**: the WU-CH range runs 20 L, 30 L, 40 L, 50 L; we stock the middle two.
  The separate `BJY-U*-B` "concealed heater" PU-insulated family is a different product line
  again.
- **Insect killer**: BJY-IK40A (larger, 18 W lamp, 40/43 W).

---

## 9. Summary of `products.json` changes this pass

All 15 SKUs enriched. Before this pass: 7 had no description, 11 had no
`technical_specification`, **all 15** had no `meta_description`, and 11 had no dimensions.

- **Corrections**: urn names Exposed → **Concealed** Element (×2); 30 L urn dimensions
  replaced entirely (were a different product's); 40 L urn dimensions remapped into the
  right fields; display chiller dimensions 426×380×955 → **452×406×966**
- **Model codes** updated to official Berjaya codes: `WU-CH-30L`, `WU-CH-40L`,
  `BJY-4GDC78L-A`, `BJY-BM20`, `BJY-IK30A`
- **Built from scratch**: full description + spec table for the mixer and insect killer
  (both had nothing); prose descriptions and HTML spec tables replacing bullet-list stubs
  across the GN range; one empty placeholder spec table (`LENGTH:` / `WIDTH:` / `HEIGHT:`
  with no values, on IMG/TCW/00090) replaced with real data
- **Dimensions filled** for all 10 GN SKUs, the mixer and the insect killer
- **`meta_description` added** to all 15
- **No `image` field was changed anywhere.** All image sourcing in §4 is presented as
  verified links for manual review first.
