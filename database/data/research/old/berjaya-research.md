# Berjaya Product Research

Research notes behind the BERJAYA enrichment/audit pass on `products.json` (July 2026).
Covers all 15 BERJAYA SKUs: 10 Gastronorm pans and covers, 2 water urns, a four-glass
display chiller, a 20 L planetary mixer, and an insect killer. Every page and image URL
below was verified live.

**This pass found four real data errors, one of them serious** - see §5.

---

## 1. Brand identification

**Berjaya Steel Product Sdn Bhd**, Malaysia - founded **1980**, HQ in Cheras, Klang Valley,
12 branches, ISO 9001:2015 / SIRIM certified, exports to 60+ countries. Ranges cover
commercial refrigeration, electric and gas cooking, foodservice equipment, bakery machinery
and stainless fabrication.

**Renamed in 2024 to Berjaya CKE International Sdn Bhd**, trading as **"Berjaya CKE"**,
following a partnership with AIGF Singapore (a Mitsubishi-sponsored PE firm). The old
`berjayasteel.com` domain now redirects to `berjayacke.com`.

**Not related to Berjaya Corporation Berhad**, the large Malaysian hotels/retail
conglomerate. Shared name only, no ownership link found - do not cite conglomerate sources
when researching this brand.

---

## 2. Where to look - and the traps

| Resource | URL |
|---|---|
| Official site | <https://berjayacke.com> |
| Old domain (redirects) | berjayasteel.com |
| Service manual portal (login-gated, dead end) | servicemanual.berjayacke.com |

**There are no per-product spec sheet PDFs, and no master catalogue PDF.** Specs live in
HTML `<table>` blocks on each product page. The upside is that those tables are complete -
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
   URL from a model code - search instead. Best method:
   `site:berjayacke.com <descriptive product name>`, *not* the model code (codes rarely
   appear in slugs or page titles).
2. **The old domain breaks automated fetching.** `berjayasteel.com` 301-redirects
   cross-host, which makes WebFetch return a redirect notice instead of content. Always
   target `berjayacke.com` directly.
3. **Slug collisions with `-2` suffixes** and near-duplicate names (`water-boiler/` vs
   `water-boiler-2/`). Verify by page content, not by slug.
4. **Berjaya's own typo is load-bearing.** The insect killer page is titled *"Insert
   Killer"* and its slug is `/insert-killer/`. Correcting the spelling 404s the fetch.
5. **Image asset paths ARE model-code-based** - `wp-content/uploads/New-{Category}/{SubRange}/{MODELCODE}.jpg`
   - which makes them the best handle available. But this does **not** hold for the
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
| IMG/TCW/00086 | GN Container 1/3 65 Berjaya | FP 1/3-2.5 | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page table - 325×176×65 |
| IMG/TCW/00087 | GN Container 1/4 65 Berjaya | FP 1/4-2.5 | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page table - 265×162×65 |
| IMG/TCW/00089 | GN Container 1/1 100 Berjaya | FP 1/1-4 | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page table - 530×325×100 |
| IMG/TCW/00090 | GN Container 1/2 100 Berjaya | FP 1/2-4 | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page table - 325×265×100 |
| IMG/TCW/00091 | GN Container 1/3 100 Berjaya | FP 1/3-4 | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page table - 325×176×100 |
| IMG/TCW/00097 | GN Lids 1/1 Berjaya | FP11C | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page cover table - code + carton only |
| IMG/TCW/00098 | GN Lids 1/2 Berjaya | FP12C | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page cover table - code + carton only |
| IMG/TCW/00099 | GN Lids 1/3 Berjaya | FP13C | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page cover table - code + carton only |
| IMG/TCW/00100 | GN Lids 1/4 Berjaya | FP14C | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page cover table - code + carton only |
| IMG/TCW/00102 | GN Lids 1/9 Berjaya | FP19C | [foodpan](https://berjayacke.com/our-products/food-service-equipment/catering-equipment/foodpan/) | on-page cover table - code + carton only |
| IMG/COF/00001 | Heated Water Urn 30 Litres Berjaya | WU-CH-30L | [electrical water urn concealed element](https://berjayacke.com/our-products/food-service-equipment/water-boiler/electrical-water-urn-concealed-element/) | on-page table - 4-model shared |
| IMG/COF/00002 | Heated Water Urn 40 Litres Berjaya | WU-CH-40L | [electrical water urn concealed element](https://berjayacke.com/our-products/food-service-equipment/water-boiler/electrical-water-urn-concealed-element/) | on-page table - 4-model shared |
| IMG/DIS/00001 | Pastry Display Four Glass Berjaya | BJY-4GDC78L-A | [four glass display chiller](https://berjayacke.com/our-products/commercial-refrigerator/display-range/display-chiller-blank/) | on-page table - 3-model shared |
| IMG/PAS/00001 | Cake Mixer Planetary 20 Litres Berjaya | BJY-BM20 | [bakery mixer without netting](https://berjayacke.com/our-products/bakery-machinery/mixer/bakery-mixer-without-netting/) | on-page table - 6-model shared, 50/60 Hz variants |
| IMG/HYS/00179 | Insect Killer Berjaya IK30 | BJY-IK30A | [insert killer](https://berjayacke.com/our-products/food-service-equipment/insect-killer/insert-killer/) | on-page table - 2-model shared |

Note the mixer page carries **both a 50 Hz and a 60 Hz table**. Kenya is 240 V / 50 Hz, so
`BJY-BM20` (50 Hz) is the correct SKU, not `BJY-BM20-60`.

Also note `BJY-BM20` is the **without-netting** variant. `BJY-BM20N` is a genuinely
different SKU with a wire bowl guard, on a different page.

---

## 4. Image sourcing

Berjaya's photography is thinner than their spec data. **Only 4 distinct images cover all
15 SKUs** on Berjaya's own site, because most ranges use one shared family photo rather than
per-model shots. The URLs below were verified live and are kept as the record.

**Update - July 2026 redo pass: all 15 SKUs now have images wired in `products.json`.**
A re-scrape of every live supplier page (and the resellers that carry the line - Narita,
Kitchen-Arena, Fully Kitchen) confirmed there is **no per-fraction Berjaya photo anywhere**;
these are commodity EN 631 items shot once per range. So rather than downgrade to Berjaya's
400×400 shared thumbnails, the redo kept the higher-quality existing catalogue images
already on disk and only filled genuine gaps:

- **8 SKUs kept their existing catalogue images** (chiller, mixer, GN pans 00086/87/89/90/91,
  lid 00097, both urns) - all good-quality, correct, better than the official 400×400.
- **3 GN pans (00086/87/89)** carry distinct manual per-SKU photos supplied by the client;
  00089 also has a gallery image.
- **4 null lids (00098/99/100/102)** filled by reusing the existing lid-set photo from 00097.
- **Insect killer (00179)** wired to the official `BJY-IK40A-1.jpg` (shared IK30/IK40 hero).
- **Both urn image files renamed** `…exposed-element…` → `…concealed-element…` to match the
  §5.1 name correction; `products.json` image paths updated to match.

| Image URL | Covers | Verified |
|---|---|---|
| <https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/ChafingCateringEquipment/food-pan.jpg> | all 5 GN pans (00086, 00087, 00089, 00090, 00091) | 200, image/jpeg, 19,745 B, 400×400 |
| <https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/ChafingCateringEquipment/food-pan-cover.jpg> | all 5 GN covers (00097, 00098, 00099, 00100, 00102) | 200, image/jpeg, 21,473 B, 400×400 |
| <https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/BeverageEquipment/Water-Urn.jpg> | both urns (00001, 00002) | 200, image/jpeg, 14,455 B |
| <https://berjayacke.com/wp-content/uploads/New-CommercialRefrigerator/DisplayRange/BJY-4GDC78L.jpg> | display chiller (IMG/DIS/00001) | 200, image/jpeg, 50,345 B |
| <https://berjayacke.com/wp-content/uploads/New-BakeryMachinery/BJY-BM10.png> | mixer (IMG/PAS/00001) ⚠ | 200, image/png, 63,651 B |
| <https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/DWasher_InsertK_AirCooler/BJY-IK40A-1.jpg> | insect killer (IMG/HYS/00179) ⚠ | 200, image/jpeg, 12,265 B |

**Caveats to check before using:**

- ⚠ **Mixer** - the file is named `BJY-BM10.png` but is the shared gallery image captioned
  "Bakery Mixer Without Netting (10L / 20L / 30L)". It is the correct body style for the
  BM20, but there is no BM20-specific asset (`BJY-BM20.png` etc. all 404).
- ⚠ **Insect killer** - the only live image on the page is `BJY-IK40A-1.jpg`, i.e. the
  **40 A** photograph. The page uses a model dropdown with one shared hero image, so it is
  legitimate for the IK30A, but it is not a photo of our exact model. `BJY-IK30A.jpg` and
  `BJY-IK30A-1.jpg` both 404.
- **GN images are only 400×400** with no larger original (only `-150x150` thumbs exist
  besides). Fine as a card thumbnail, likely too small for a product-page hero.
- **The model-code image pattern does not apply to the Gastronorm range** - it uses
  descriptive filenames under `Foodservice_Equipment/ChafingCateringEquipment/`.
- `BJY-4GDC78L-A.jpg` 404s; the `-A` code has no separate asset, use `BJY-4GDC78L.jpg`.

Alternative smaller urn asset also verified live:
`.../BeverageEquipment/Water-Urn-300x300.jpg` (200, 7,647 B).

---

## 5. Data audit - errors found and corrected

### 5.1 Both water urns were described as the wrong product type ⚠ serious

Both SKUs were named **"Heated Water Urn with Exposed Element"**. **Berjaya has never
published an exposed-element water urn.** This is a factual misdescription of a functional
characteristic - a concealed element is the premium arrangement (the element never contacts
the water, so descaling and cleaning are far easier), and selling it as "exposed" both
understates the product and misinforms the buyer.

Evidence, which is unusually strong:

1. A Wayback CDX sweep of the **entire** `berjayasteel.com` domain (all `/product/` and
   `/products/` URLs, 2015→2023) returns exactly **two** urn products ever - both
   concealed. No `WU-EH` code, no "exposed" page, no third urn family.
2. **The decisive link:** the 2015–2019 legacy page `berjayasteel.com/product/water-urn/`
   uses the image file **`U20-U30-U40-U50-280x320.jpg`**, proving the legacy `U 20/30/40/50`
   codes are the same single family Berjaya later renamed to `WU-CH-20L…50L`. A 2022
   capture confirms the rename against an identical spec table.
3. Distributor corroboration: sharafkitchenequipment.com lists the product literally as
   `U40(WU-CH-40L)`.
4. Visual check of the archived legacy images against the current `Water-Urn.jpg` - same
   squat all-welded lidded urn with side spigot and thermostat knob in every generation, no
   exposed element anywhere.

**Corrected**: both renamed to "Concealed Element", `model_number` updated to `WU-CH-30L` /
`WU-CH-40L`, and the concealed element written into the description and spec table. Neither
is discontinued - both are current products.

### 5.2 The 30 L urn's dimensions belonged to a different product ⚠ serious

The catalogue held **310 × 640 mm** for the 30 L urn. That is not `WU-CH-30L`. It is
exactly the machine dimension of **`BJY-U30-B`** - a *different* Berjaya urn family,
"Electrical Water Urn (Concealed **Heater**)", Ø310 × H640, 2600 W, 3.92 kg, at
[water-boiler-with-pu-insulation-electrical](https://berjayacke.com/our-products/food-service-equipment/water-boiler/water-boiler-with-pu-insulation-electrical/).

Whoever populated the row matched on "30 L" and took the figures from the wrong page.
**This is why the 30 L appeared wider than the 40 L** - the two rows came from two
different product families.

Correct `WU-CH-30L` figures: **H 450 × Ø 330 mm, 2,800 W, 5.9 kg, ~140 cups**. Applied.

(The alternative reading - that the SKU really is a `BJY-U30-B` - fails because that family
only exists in 20 L and 30 L, so it cannot be the source of the `U 40` sibling. The legacy
`U20-U30-U40-U50` image filename settles it.)

### 5.3 The 40 L urn's dimensions were in the wrong fields

`460 × 380` is correct for `WU-CH-40L` - but it is **H 460 × Ø 380**, and had been stored as
`length: 460, width: 380` with no height. Remapped to `length: 380, width: 380, height: 460`
(a circular footprint bounding box), with the diameter stated explicitly in the spec table.

### 5.4 The display chiller's dimensions match no published source

The catalogue held **426 × 380 × 955**. Berjaya currently publishes **452 × 406 × 966**.

The `-A` revision theory turned out to be wrong: raw HTML shows `BJY-4GDC78L` and
`BJY-4GDC78L-A` are two codes stacked in one merged table column **sharing a single spec
set**. Three figures circulate in the wild but all share identical packing dimensions
(475×432×1038), weight (34 kg), wattage (164 W), shelf count (3) and container loading - so
this is one physical product whose published external-dimension figure was restated over
time, not multiple revisions:

| Figure | Source | Status |
|---|---|---|
| 452 × 406 × 966 | berjayacke.com, current | **current official - now applied** |
| 428 × 386 × 960 | restaurantsupplies.com.np, mirroring an older Berjaya catalogue | superseded |
| 426 × 380 × 955 | **our catalogue, before this pass** | matches nothing exactly; closest to the superseded figure, off by 2/6/5 mm |

Our figure was a stale third-hand value. Corrected to the current official one, and
`model_number` set to `BJY-4GDC78L-A` since Berjaya's order dropdown now only offers `-A`
codes.

### 5.5 Wattage drift among distributors - do not trust resellers on this

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

## 6. What Berjaya does not publish - left blank rather than invented

- **GN capacity in litres.** Not published for any pan. Left null. If a figure is ever
  required, standard GN nominal is 1/1-100 ≈ 13.5 L, 1/2-100 ≈ 6.5 L, 1/3-100 ≈ 4.0 L,
  1/3-65 ≈ 2.5 L, 1/4-65 ≈ 1.7 L - and it must be marked as derived, because raw geometric
  L×W×D overstates by ~25% (it ignores corner radii and wall taper; FP 1/1-4 computes to
  17.2 L but holds ~13.5 L).
- **GN cover dimensions.** Berjaya's cover table publishes only model code, size class and
  carton quantity. Our cover records carry the matching pan's EN 631 opening as the
  footprint - defensible, since a lid must match its pan - with no height.
- **GN steel grade, gauge, NSF rating, dishwasher/bain-marie statements, lid style** (flat
  vs notched vs sealed). The entire published feature list is three bullets: stainless steel
  material, available in multiple sizes, suitable for restaurant/hotel/catering. Verified as
  a house pattern, not a one-page gap - the sibling Perforated Food Pan and Vegetable Pan
  pages are equally sparse. Covers **are** confirmed stainless (table headed "STAINLESS
  STEEL FOODPAN COVER"), so not polycarbonate.
- **Display chiller**: compressor make/model, defrost type (implied automatic by the "frost
  free" claim), gross weight.
- **Mixer attachments**: the spec table gives separate whisk/beater/hook RPMs, so all three
  tools are part of the machine spec, but there is no official "accessories included" row.
  Distributor copy (Qualipro, aajjo) itemises SS bowl + spiral hook + beater + balloon
  whisk - treated as *medium* confidence and not asserted as fact.
- **Insect killer**: construction material and mounting method. The 105 mm depth and slab
  form factor imply wall or chain/ceiling mounting, but Berjaya doesn't state it. Notably
  their spec table omits material here, unlike the urns where 304 stainless is explicit -
  so do not assume stainless.

Conflicting distributor data deliberately ignored: Qualipro lists the BM20 as
530 × 460 × 880 mm / **95 kg**; Berjaya's official 430 × 530 × 880 / 68 kg supersedes it
(95 kg is likely gross/crated weight).

---

## 7. Open item for you

**IMG/HYS/00179 (Insect Killer) is `archived` but is a current Berjaya product.**
`BJY-IK30A` is live on berjayacke.com alongside the IK40A. Left archived because that is a
stocking decision, not a data correction - but worth revisiting now that it has full specs.

---

## 8. Range gaps

Berjaya makes these in the same lines, if the range is worth filling:

- **Gastronorm**: full 1/6 and 1/9 **pan** ranges, the 150 mm and 205 mm depths across all
  fractions, and the `FP16C` sixth-size cover. Note we currently stock a **1/9 cover
  (00102) with no matching 1/9 pan**.
- **Planetary mixers**: BM5-B (5.5 L), BM7-B (7.5 L), BM10 (10 L), BM30 (28 L), BM40 (38 L),
  plus a full mirrored `N` netted range including BM60N (60 L, three-phase). BM30 is nearly
  free to add - same footprint class and speeds as our BM20, just 1500 W. Digital-control
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
- **No `image` field was changed in this first pass.** All image sourcing in §4 was
  presented as verified links for manual review first. **(Superseded by the July 2026 redo
  pass - see §4 update: all 15 SKUs now have images wired.)**

---

## 10. July 2026 redo pass - verification + images

Full re-verification of all 15 SKUs against live supplier pages plus reseller cross-check.

- **Data**: every field (name, model code, dimensions, spec table, meta) still matches the
  current live Berjaya pages exactly. **No data corrections were required** - the original
  enrichment pass holds up.
- **Images**: all 15 SKUs now carry a wired image (was 5 null: lids 00098/99/100/102 and
  insect killer 00179). Approach and per-SKU detail recorded in the §4 update above.
- **Statuses left unchanged** (a stocking decision, not a data one): 00086 and lids
  00098/99/100/102 are still `draft`; chiller, mixer and insect killer still `archived`.
  Now that images are in place these are candidates to publish - flagged, not flipped.

---

## 11. Reseller image sourcing - for manual review (July 2026)

§4 recorded only Berjaya's **own** photography - 4 shared shots for 15 SKUs. This pass went
looking specifically for **per-SKU reseller/distributor photos to eyeball and pick from**,
because most of §4's images are shared family shots and several are the wrong model
(the mixer's file is named `BM10`, the insect killer's is the `IK40A`). Every URL below
returned **HTTP 200 at time of writing** unless flagged. As §4 warned, Berjaya shoots most
ranges once, so the GN pans/lids and the two urns still can't be told apart by photo - the
real upgrades are the **mixer, chiller, urns and insect killer**.

Ranking used throughout: (1) exact-model, clean white background, no watermark; (2) exact
model with watermark or greyer background; (3) sibling/shared body; (4) generic reference.

### 11.1 Best pick per SKU - quick reference

| SKU | Product | Best image URL | Upgrade over §4? | Note |
|---|---|---|---|---|
| IMG/DIS/00001 | Display Chiller | `berjayacke.com/.../DisplayRange/BJY-4GDC78L.jpg` | = (already best) | exact model, no watermark; official is already the cleanest |
| IMG/PAS/00001 | Planetary Mixer 20L | `cosmic.vn/.../z4258277161836_...768x770.jpg` | **yes** | first true BM20-specific set (multi-angle) vs §4's BM10-named shot |
| IMG/COF/00001 | Water Urn 30L | Sharaf 800×800 (shared family) | quality only | no 30L-specific photo exists anywhere |
| IMG/COF/00002 | Water Urn 40L | `sharafkitchenequipment.com` 800×800 PNG | **yes** | sharp 800px vs §4's 14 KB thumbnail |
| IMG/HYS/00179 | Insect Killer IK30 | Polar Bear `...861654f4cdf227b6e4982751b9b17a00.jpg` | **yes (model)** | compact casing reads as IK30A, not §4's IK40A - but watermarked |
| IMG/TCW/00086–91 | GN pans (×5) | Fully Kitchen IM00419/420/421 (Berjaya) + Maxima per-fraction (generic) | quality only | no per-fraction Berjaya photo exists |
| IMG/TCW/00097–00102 | GN covers (×5) | Maxima per-fraction lids (generic) | quality only | no per-fraction Berjaya cover photo exists |

### 11.2 Display Chiller - BJY-4GDC78L(-A)

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| official | [page](https://berjayacke.com/our-products/commercial-refrigerator/display-range/display-chiller-blank/) | <https://berjayacke.com/wp-content/uploads/New-CommercialRefrigerator/DisplayRange/BJY-4GDC78L.jpg> | 200, jpeg, 49 KB | Exact model. White bg, ~500px, 3/4 angle, "BERJAYA" on plinth. Best asset. |
| reseller (RestaurantSupplies.com.np) | [page](https://restaurantsupplies.com.np/product/four-glass-display-chiller-bjy-4gdc78l/) | <https://restaurantsupplies.com.np/wp-content/uploads/2019/04/four-glass-display-chiller-78.jpg> | 200, jpeg, 26 KB | Exact model, same angle, greyer bg, lower res, no watermark. Clean alternate. |
| official brochure PDF | - | <https://berjayacke.com/wp-content/uploads/ProductBrochure/CommercialRefrigerator/Display-Chiller.pdf> | 200, pdf, 757 KB | Embedded images, not extractable as direct URLs. |

**Best pick:** official `BJY-4GDC78L.jpg`; backup RestaurantSupplies `-78.jpg`. No genuinely
different-angle 78L shot exists on any reseller - both are essentially the same photo.
`BJY-4GDC78L-A.jpg` has no separate asset. Siblings `BJY-4GDC98L.jpg` / `BJY-4GDC235CD.jpg`
load on the same directory but are the 98L / 235CD - do not use for the 78L.

### 11.3 Planetary Mixer 20L - BJY-BM20

The single best find of this pass: **cosmic.vn** is the only page that is specifically the
20L *without-netting* BM20 **and** carries a full multi-angle set on clean backgrounds.

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| cosmic.vn | [page](https://cosmic.vn/en/product/20-liter-bakery-mixer/) | <https://cosmic.vn/wp-content/uploads/2019/12/z4258277161836_128486ba1e97068520a8fb3389a1f19f-1-768x770.jpg> | 200, jpeg, 83 KB | Cleanest hero, exact BM20 20L. |
| cosmic.vn | (same) | <https://cosmic.vn/wp-content/uploads/2019/12/z4258708086571_b01685a2c45b00e88c85a0404c551012-1.jpg> | 200, jpeg, 83 KB | Full-size second shot. |
| cosmic.vn | (same) | <https://cosmic.vn/wp-content/uploads/2019/12/z4271054519451_1c12664abdb6137ad09e92b91095a395-1-768x683.jpg> | 200, jpeg, 49 KB | Main product shot. |
| cosmic.vn | (same) | - | 200 | **~7 further angles/detail banners on the same page** (filenames `z4258277*`). |
| Qualipro (IN) | [page](https://www.qualipro.in/berjaya-planetary-mixer-model-bjy-bm20-capacity-20-ltrs-9684517.html) | <https://cpimg.tistatic.com/09684517/b/4/Berjaya-Planetary-Mixer-Model-BJY-BM20-Capacity-20-Ltrs..jpg> | 200, jpeg, 86 KB | Labelled BM20 20L, single clean photo. Strong second source. |
| Fully Kitchen (MY) | [page](https://www.fullykitchen.com.my/product/berjaya/bakery-mixer-without-netting) | <https://www.fullykitchen.com.my/files/product_img/IM00075.jpeg> | 200, jpeg, 64 KB | "Without netting" range gallery (5/7/10/20/30L body); IM00076–078 are more angles. |
| official | [page](https://berjayacke.com/our-products/bakery-machinery/mixer/bakery-mixer-without-netting/) | <https://berjayacke.com/wp-content/uploads/New-BakeryMachinery/BJY-BM10.png> | 200, png, 64 KB | §4's shot - filename BM10, shared 10/20/30L. Manufacturer-branded fallback only. |

**Best pick:** cosmic.vn `z4258277161836_...768x770.jpg` (+ its sibling shots for a gallery);
Qualipro `tistatic` image as a clean labelled second.
**Avoid:** ekuep `43528-*` (`cdn.ekuep.com`) is the **BM20N-60** - netted, 60 Hz variant,
wrong SKU (same body, but not ours); official `BM40.jpg` and `Bakery-Mixer-5-7-*.png` are the
40L and 5/7L bodies.

### 11.4 Water Urns - WU-CH-30L / WU-CH-40L

| Source | Page URL | Direct image URL | For | Verified | Notes |
|---|---|---|---|---|---|
| Sharaf Kitchen | [page](https://sharafkitchenequipment.com/products/s-s-electric-water-urn-with-heateru40wu-ch-40l) | <https://sharafkitchenequipment.com/cdn/shop/files/Untitled_800x800px_-2025-08-14T015018.017_9acbbbfa-afac-4002-b613-afdf2deaefee.png?v=1755162815&width=1445> | both | 200, png, 189 KB | **Best quality** - 800×800 clean white bg. Listed as `U40(WU-CH-40L)`. |
| ekuep | [page](https://www.ekuep.com/en/berjaya-wu-ch-20l-hot-beverage-dispenser-20l) | <https://cdn.ekuep.com/v4ekuep/img/p/4/0/1/6/5/40165-large_default.jpg> | both | 200, jpeg, 25 KB | Correct family, clean bg (from the 20L listing, same body). |
| official | [page](https://berjayacke.com/our-products/food-service-equipment/water-boiler/electrical-water-urn-concealed-element/) | <https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/BeverageEquipment/Water-Urn.jpg> | both | 200, jpeg, 15 KB | §4's shared family shot. Correct but small. |
| DiamondGlare | [40L](https://www.diamondglare-store.com/shop/berjaya-1045-water-boiler-berjaya-wu-ch-40l-159902) | <https://www.diamondglare-store.com/web/image/product.template/159902/image_1920> | 40L | 200, jpeg, 14 KB | Correct family, low-res (~410px). 30L page serves a byte-identical file. |

**Best pick:** Sharaf 800×800 PNG for **both** sizes (higher res than official).
**No reseller distinguishes 30L from 40L** - DiamondGlare's 30L and 40L pages serve identical
bytes. **Wrong family - do NOT use:** `fullykitchen.com.my/.../IM00390.jpeg` & `IM00391.jpeg`
and `sheffieldafrica.com/storage/uploads/1724235530_BJY-U30-B-800x600.jpg` all load but show
the **BJY-U30-B concealed-*heater*** (taller body, vertical sight-glass, domed lid) - the
wrong family despite pages titling them U40/WU-CH.

### 11.5 Insect Killer - BJY-IK30A (IK30)

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| Polar Bear Engineering (MY) | [page](https://www.polarbearengineering.com.my/index.php?ws=showproducts&products_id=3610265) | <https://cdn1.npcdn.net/image/1625470377861654f4cdf227b6e4982751b9b17a00.jpg?md5id=66afde749f0cf270c25dfad35df0554b&new_width=1200&new_height=1200&size=max> | 200, jpeg, 72 KB | Berjaya-branded, angled 3/4, **compact casing → most likely the real IK30A**. White bg but corner watermark. |
| Fully Kitchen (MY) | [page](https://www.fullykitchen.com.my/product/berjaya/insect-killer) | <https://www.fullykitchen.com.my/files/product_img/IM00117.jpeg> | 200, jpeg, 77 KB | Cleanest (no watermark) but **wide proportions read as IK40A**; page covers both. |
| official | [page](https://berjayacke.com/our-products/food-service-equipment/insect-killer/insert-killer/) | <https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/DWasher_InsertK_AirCooler/BJY-IK40A-1.jpg> | 200, jpeg, 12 KB | §4's shot - confirmed **IK40A**, low-res. Baseline only. |

**Best pick:** Polar Bear `...861654f4...jpg` if you want a genuine **IK30A** shot (accept the
watermark); Fully Kitchen `IM00117.jpeg` if a clean/watermark-free image matters more than
exact model. **Discard:** peststore.co.za `IK30-High-Voltage-Unit.jpg` - a *different maker's*
grey "IK30", not Berjaya. (Recall §7: this SKU is wrongly `archived` but is a current product.)

### 11.6 GN Pans - Berjaya FP series (00086, 00087, 00089, 00090, 00091)

No per-fraction Berjaya photo exists - the whole range shares one shot. Use a Berjaya-branded
pan+cover shot for brand accuracy, or a Maxima per-fraction generic to show the actual size.

| For | Source | Direct image URL | Berjaya/generic | Verified | Notes |
|---|---|---|---|---|---|
| Whole range | Fully Kitchen | <https://www.fullykitchen.com.my/files/product_img/IM00419.jpeg> | Berjaya | 200, 53 KB | Berjaya solid pan + cover, 3 angles (IM00419/420/421). |
| Whole range | Singmah Steel | <https://singmahsteel.com/wp-content/uploads/2024/03/Food-pan-800x600-1.jpg> | Berjaya-group | 200, 64 KB | 800×600 (Singmah is a Berjaya-group brand). |
| 1/1 (00089) | Maxima | <https://maxima.com/en/steel-gastronorm-container-1-1gn-40mm-530x325.html> | GENERIC | 200 | 700×700 white bg (page has other depths). |
| 1/2 (00090) | Maxima | <https://maxima.com/en/steel-gastronorm-container-1-2gn-20mm-325x265.html> | GENERIC | 200 | 325×265 footprint. |
| 1/3 (00086/00091) | Maxima | <https://maxima.com/en/steel-gastronorm-container-1-3gn-150mm-325x176.html> | GENERIC | 200 | 325×176; also 65/100mm variants on site. |
| 1/4 (00087) | Maxima | <https://maxima.com/en/steel-gastronorm-container-1-4gn-65mm-265x162.html> | GENERIC | 200 | Matches FP 1/4-2.5 depth. |

*(Maxima serves obfuscated CDN image URLs; open the page and lift the main image, or use the
page as the reference.) Berjaya perforated-pan variant also exists at Narita `IM00422.jpeg`.*

### 11.7 GN Covers/Lids - Berjaya FPxxC series (00097, 00098, 00099, 00100, 00102)

| For | Source | Direct image URL | Berjaya/generic | Verified |
|---|---|---|---|---|
| Any cover | Singmah Steel | <https://singmahsteel.com/wp-content/uploads/2024/03/Food-pan-with-cover-800x600-1.jpg> | Berjaya-group | 200, 74 KB |
| 1/1 (00097) | Maxima | <https://maxima.com/en/stainless-steel-gastronorm-lid-1-1gn.html> | GENERIC | 200 |
| 1/2 (00098) | Maxima | <https://maxima.com/en/stainless-steel-gastronorm-lid-1-2gn.html> | GENERIC | 200 |
| 1/3 (00099) | Maxima | <https://maxima.com/en/stainless-steel-gastronorm-lid-1-3gn.html> | GENERIC | 200 |
| 1/4 (00100) | Maxima | <https://maxima.com/en/stainless-steel-gastronorm-lid-1-4gn.html> | GENERIC | 200 |
| 1/9 (00102) | Maxima | <https://maxima.com/en/stainless-steel-gastronorm-lid-1-9gn.html> | GENERIC | 200 |

### 11.8 Dead / blocked / wrong-model (compiled)

- **404 / dead:** all `BJY-IK30A*.jpg` and `BJY-IK40A.jpg`/`-2.jpg` (only `BJY-IK40A-1.jpg`
  lives); `BJY-4GDC78L-A.jpg`; singmahsteel.com/products_uri/.../berjaya-display-chiller;
  narita `bakery-mixer-without-netting` (only a spiral-mixer page); mfk.co.id IK30A (placeholder).
- **Blocked to automated fetch (try a browser):** ckeholdings.com (403), buzzcateringsupplies.com
  (Cloudflare 403), shopython.com.my (403), sevenfive.co.th (403), ipckitchen.com (500);
  Shopee/TikTok Shop (JS-gated). `berjayasteel.com` old domain still breaks fetch - avoid.
- **Unreachable DNS:** kitchen-arena.com, shop.sprinteriors.com, berjayasteel.com.vn.
- **Wrong model/family (loads but do not use):** ekuep `43528-*` = BM20N-60 (netted/60 Hz);
  fullykitchen `IM00390/391` + sheffieldafrica `BJY-U30-B-800x600.jpg` = BJY-U30-B heater urn;
  peststore.co.za `IK30-High-Voltage-Unit.jpg` = non-Berjaya IK30; Creative Kitchens 1500mm
  floor pastry chiller; Berjaya door-type / mini display chillers (Fully Kitchen, Narita).


---

## Image sourcing (July 2026)

First pass in which images were actually **downloaded, opened and verified** rather than listed as
URLs. §4 and §11 recorded candidate links; this pass tested them, found several of §11's rankings
wrong, and found a materially better source that neither earlier pass identified.

Staged in `Desktop\ecommerce\products resource\berjaya-images\` (never copied into the project).
Resolution floor 800 px on the long edge; files below it are kept only where the ceiling was proven
and are suffixed `-TOOSMALL`.

**Scope note before anything else:** §3 and §9 describe **15** BERJAYA SKUs. `products.json` now
carries **14** — the two urn SKUs `IMG/COF/00001` and `IMG/COF/00002` have been collapsed into a
single grouped record, `GROUP/WATER-URN-CONCEALED-BERJAYA`, whose `model_number` is now `null`
(it was `WU-CH-30L` / `WU-CH-40L`). Urn images below are therefore filed under the group SKU.

### The find of this pass: Singmah Steel

`singmahsteel.com` is a **Berjaya-group brand** and publishes the same product photography at
**800x600**, where berjayacke.com caps at 400-500 px. It carries an exact `four-glass-78L` shot,
the insect killer, the water urn, and the food pan and cover ranges. It was cited once in §11.6/§11.7
for the pan and cover family shots but was never mined; its media library is the better source for
four of our SKUs. Reachable through the WordPress media collection endpoint:
`https://singmahsteel.com/wp-json/wp/v2/media?per_page=60&search=<term>`

The same endpoint on Berjaya's own site settles the resolution question for good:

- https://berjayacke.com/wp-json/wp/v2/media?per_page=50&search=4GDC78L returns exactly two assets,
  both **500x500**.
- `search=IK40` returns one asset, **400x400**. `search=IK30` returns **zero** — confirming §4's
  note that no IK30A asset exists, from the media library rather than by probing URLs.
- `search=BM20` returns **zero** — confirming §11.3's finding that there is no BM20-specific
  official asset.
- `search=food-pan` returns exactly **three** assets, all 400x400 — confirming §6 and §11.6 that
  there is no per-fraction Berjaya pan photography, from the library index rather than by inference.

So 400-500 px is a **proven manufacturer ceiling**, not a search failure.

### Per-file record

| File | px | size | Source URL | Visually confirmed |
|---|---|---|---|---|
| `IMG-DIS-00001__bjy-4gdc78l-singmah-800.jpg` | 800x600 | 35,030 B | https://singmahsteel.com/wp-content/uploads/2024/03/four-glass-78L-800x600-1.jpg | **Best chiller asset found.** Four-sided glass countertop chiller, silver frame, hinged door with bar handle and top lock, three white wire shelves, spec label on the rear glass, BERJAYA badge on the plinth, condenser grille at the base. Clean, no watermark. |
| `IMG-DIS-00001__bjy-4gdc78l-official-TOOSMALL.jpg` | 500x500 | 50,345 B | https://berjayacke.com/wp-content/uploads/New-CommercialRefrigerator/DisplayRange/BJY-4GDC78L.jpg | §4's asset. Same unit, same angle, tighter crop. **Ceiling proven** via the media endpoint above. |
| `IMG-DIS-00001__bjy-4gdc78l-restaurantsupplies-TOOSMALL.jpg` | 660x500 | 26,246 B | https://restaurantsupplies.com.np/wp-content/uploads/2019/04/four-glass-display-chiller-78.jpg | Same unit, greyer background, no watermark. Kept as the independent (non-Berjaya) confirmation. |
| `IMG-PAS-00001__bjy-bm20-cosmic-bowl-raised.jpg` | 900x800 | 83,083 B | https://cosmic.vn/wp-content/uploads/2019/12/z4258708086571_b01685a2c45b00e88c85a0404c551012-1.jpg | BERJAYA planetary mixer, **bowl guard absent** — the correct without-netting BM20 configuration. Cast pedestal base, handwheel bowl lift, BERJAYA roundel on the head, warning decal and "Please stop machine before change speed" plate. Green wheat-motif background, COSMIC watermark bottom-left. |
| `IMG-PAS-00001__bjy-bm20-cosmic-bowl-lowered.jpg` | 900x800 | 76,474 B | https://cosmic.vn/wp-content/uploads/2019/12/z4271054519451_1c12664abdb6137ad09e92b91095a395-1.jpg | Same machine, bowl lowered, beater fitted. Same background and watermark. |
| `IMG-PAS-00001__REPRESENTATIVE-bm-range-fullykitchen-TOOSMALL.jpeg` | 500x500 | 64,164 B | https://www.fullykitchen.com.my/files/product_img/IM00075.jpeg | Clean white-background shot of the without-netting body, but the page covers the whole 5/7/10/20/30 L range so the capacity is not provable from the image. |
| `IMG-PAS-00001__REF__bm-netted-guard-singmah.jpg` | 800x600 | 46,094 B | https://singmahsteel.com/wp-content/uploads/2024/03/MIXER.jpg | Same body but **with the wire bowl guard fitted** — that is the `N` (netted) variant, a different SKU per §3. Kept as `REF__`. |
| `IMG-PAS-00001__REF__bm20-netted-guard-qualipro-TOOSMALL.jpg` | 500x500 | 85,749 B | https://cpimg.tistatic.com/09684517/b/4/Berjaya-Planetary-Mixer-Model-BJY-BM20-Capacity-20-Ltrs..jpg | Also shows a **fitted bowl guard**, on a factory floor with pallets and a trailing lead. See finding 3. |
| `IMG-PAS-00001__REF__bm10-named-official-shared-TOOSMALL.png` | 500x500 | 63,651 B | https://berjayacke.com/wp-content/uploads/New-BakeryMachinery/BJY-BM10.png | §4's asset, filename says BM10, shared across 10/20/30 L. Correct body style, correct configuration, wrong capacity in the filename. |
| `GROUP-...__wu-ch-sharaf.png` | 800x800 | 18,330 B | https://sharafkitchenequipment.com/cdn/shop/files/Untitled_800x800px_-2025-08-14T015018.017_9acbbbfa-afac-4002-b613-afdf2deaefee.png | Squat cylindrical urn, lidded with a black knob, two side carry handles, **MAX level sight strip**, black lever tap on a chrome spout, red pilot lamp and thermostat knob on the base band, BERJAYA wordmark. Matches §5.1's description of the concealed-element family exactly. No watermark. |
| `GROUP-...__wu-ch-singmah-800.jpg` | 800x600 | 34,933 B | https://singmahsteel.com/wp-content/uploads/2024/03/water-urn-800x600-1.jpg | Same urn, slight 3/4 angle, Berjaya-group source. Second independent confirmation. |
| `GROUP-...__wu-ch-official-TOOSMALL.jpg` | 500x500 | 14,455 B | https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/BeverageEquipment/Water-Urn.jpg | §4's shared family shot. Ceiling proven. |
| `GROUP-...__REF__wu-ch-20l-official-TOOSMALL.png` | 500x500 | 26,040 B | https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/WaterBoiler/Water-Urn-WU-CH-20L.png | **A WU-CH asset not recorded in §4 or §11.** Same family, but the filename pins it to the **20 L**, which we do not stock — hence `REF__`. Useful because it is the only Berjaya file that names a WU-CH capacity at all. |
| `IMG-HYS-00179__insect-killer-singmah-800.jpg` | 800x600 | 54,552 B | https://singmahsteel.com/wp-content/uploads/2024/03/insect-killer-800x600-1.jpg | Front elevation, white/silver extruded frame with dark end caps, **two horizontal UV tubes** behind a full-width electric grid, catch tray along the bottom, red pilot lamp top-left, BERJAYA wordmark top-right. Clean, no watermark. Wide proportions — see finding 4. |
| `IMG-HYS-00179__bjy-ik30a-polarbear-TOOSMALL.jpg` | 500x500 | 71,625 B | https://cdn1.npcdn.net/image/1625470377861654f4cdf227b6e4982751b9b17a00.jpg | 3/4 angle, more compact casing, CE label on the front panel, two tubes. §11.5's candidate for the genuine IK30A. Watermark across the lower half. **Ceiling proven**: requesting `new_width=1200&new_height=1200&size=max` still returns 500x500. |
| `IMG-HYS-00179__insect-killer-fullykitchen-TOOSMALL.jpeg` | 500x500 | 76,708 B | https://www.fullykitchen.com.my/files/product_img/IM00117.jpeg | Watermark-free front elevation, wide body, two tubes. |
| `IMG-HYS-00179__REF__bjy-ik40a-official-TOOSMALL.jpg` | 400x400 | 12,265 B | https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/DWasher_InsertK_AirCooler/BJY-IK40A-1.jpg | Berjaya's own asset, filename says **IK40A**. Kept as `REF__`, as §4 already flagged. |
| `IMG-TCW-00086__REPRESENTATIVE-berjaya-foodpan-range-singmah.jpg` | 800x600 | 64,009 B | https://singmahsteel.com/wp-content/uploads/2024/03/Food-pan-800x600-1.jpg | Berjaya-group photo of the pan range laid out — roughly 20 pans across many fractions and depths, overhead, white background. Correct brand, correct product, **not fraction-specific**. |
| `IMG-TCW-00086__REPRESENTATIVE-gn-1-3-65mm-pan-generic.jpg` | 2873x2158 | 391,660 B | https://image.made-in-china.com/2f0j00sKjWSwMZMYRT/Food-Container-1-3-65mm-European-Stainless-Steel-Gastronorm-Pan.jpg | Shallow 1/3 pan with its cover propped behind, **"1/3" embossed on the pan face**, radiused corners, rolled rim. Generic (non-Berjaya) EN 631 pan. |
| `IMG-TCW-00087__REPRESENTATIVE-gn-1-4-65mm-pan-generic.jpg` | 2119x1592 | 254,039 B | https://image.made-in-china.com/2f0j00ysSiZYCJLGfz/High-Standard-1-4-65mm-European-Stainless-Steel-Gastronorm-Pan-China.jpg | 1/4 pan tipped on its side over a matching notched cover, **"1/4" visible on the pan**. Generic EN 631. |
| `IMG-TCW-00089__REPRESENTATIVE-gn-1-1-100mm-pan-generic.jpg` | 1000x1000 | 38,119 B | https://image.made-in-china.com/2f0j00CaceKzERIGpL/1-1-100mm-Deep-Stainless-Steel-European-Gn-Rectangle-Food-Pan-Gn-Container.jpg | Single full-size 1/1 pan, deep profile, clean white background, no watermark. Generic EN 631. |
| `IMG-TCW-00090__REPRESENTATIVE-gn-1-2-100mm-pan-generic.jpg` | 1500x1500 | 161,872 B | https://image.made-in-china.com/2f0j00wKUhvsSFkpGH/Food-Box-Stainless-Steel-Gn-Pan-0-7mm-1-2-100mm-European-Gastronorm-Pan.jpg | Deep 1/2 pan with cover, **"1/2" on the pan face**. Yucheng watermark. Generic EN 631. |
| `IMG-TCW-00091__REPRESENTATIVE-gn-1-3-100mm-pan-generic.jpg` | 800x800 | 250,175 B | https://image.made-in-china.com/2f0j00IPJCHeicfZqa/Heavybao-Standard-Size-Stainless-Steel-Gastronorm-Food-Container-Gn-1-3-100mm-Pan.jpg | Three deep GN pans on a dark wood surface, Heavybao banner. Shows the 100 mm depth clearly. Generic EN 631. |
| `IMG-TCW-00097__REPRESENTATIVE-berjaya-foodpan-cover-singmah.jpg` | 800x600 | 74,026 B | https://singmahsteel.com/wp-content/uploads/2024/03/Food-pan-with-cover-800x600-1.jpg | Berjaya-group photo of the **cover** range laid out across many fractions, overhead, white background. Correct brand, correct product, not fraction-specific. |
| `IMG-TCW-00097__REPRESENTATIVE-gn-lid-set-generic.jpg` | 1000x1000 | 46,366 B | https://image.made-in-china.com/2f0j00TEFCScMbApun/1-1-Stainless-Steel-Gn-Container-Lid-with-Notched-Gastronorm-Food-Pan-Cover.jpg | Set of notched GN covers of descending fraction, arranged flat, white background. Generic. |
| `IMG-TCW-00098__REPRESENTATIVE-gn-lid-set-generic.jpg` | 800x800 | 74,015 B | https://image.made-in-china.com/2f0j00KtjBesIRLoqM/Changing-Customized-Serving-Pots-Notched-Lid-1-6-Gn-Pans-Cover-201-Steel.jpg | Similar flat-laid cover set, CHANGING watermark. Generic. |
| `IMG-TCW-00099__REPRESENTATIVE-gn-lid-single-generic.jpg` | 800x800 | 57,264 B | https://image.made-in-china.com/2f0j00ZqFBunYIkicC/Changing-Customized-Serving-Pots-Notched-Lid-1-6-Gn-Pans-Cover-201-Steel.jpg | Single GN cover, recessed oval grip, spoon notch on one edge. CHANGING watermark. Generic. |
| `IMG-TCW-00100__REPRESENTATIVE-gn-lid-on-pan-generic.jpg` | 800x800 | 74,644 B | https://image.made-in-china.com/2f0j00dlueVAIhrqkU/Changing-Customized-Serving-Pots-Notched-Lid-1-6-Gn-Pans-Cover-201-Steel.jpg | Cover with a bar handle shown seated on its pan plus a second cover alongside — shows how the lid mates. CHANGING watermark. Generic. |
| `IMG-TCW-00102__REPRESENTATIVE-gn-lid-small-fractions-generic.jpg` | 800x800 | 96,793 B | https://image.made-in-china.com/2f0j00sTKMeAHcwbqB/Changing-Customized-Serving-Pots-Notched-Lid-1-6-Gn-Pans-Cover-201-Steel.jpg | Four **small-fraction** pans with covers grouped together — the closest available illustration of the 1/9 size class. CHANGING watermark. Generic. |
| `_brand-reference\berjaya-group-singmah-foodpan-800x600.jpg` | 800x600 | 64,009 B | https://singmahsteel.com/wp-content/uploads/2024/03/Food-pan-800x600-1.jpg | Master copy of the Berjaya-group pan range shot. |
| `_brand-reference\berjaya-group-singmah-foodpan-cover-800x600.jpg` | 800x600 | 74,026 B | https://singmahsteel.com/wp-content/uploads/2024/03/Food-pan-with-cover-800x600-1.jpg | Master copy of the Berjaya-group cover range shot. |
| `_brand-reference\berjaya-official-food-pan-shared-TOOSMALL.jpg` | 400x400 | 19,745 B | https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/ChafingCateringEquipment/food-pan.jpg | §4's shared pan photo. Ceiling proven. |
| `_brand-reference\berjaya-official-food-pan-cover-shared-TOOSMALL.jpg` | 400x400 | 21,473 B | https://berjayacke.com/wp-content/uploads/Foodservice_Equipment/ChafingCateringEquipment/food-pan-cover.jpg | §4's shared cover photo. Ceiling proven. |
| `_brand-reference\berjaya-foodpan-range-fullykitchen-1/2/3-TOOSMALL.jpeg` | 500x500 | 53-64 KB | https://www.fullykitchen.com.my/files/product_img/IM00419.jpeg , https://www.fullykitchen.com.my/files/product_img/IM00420.jpeg , https://www.fullykitchen.com.my/files/product_img/IM00421.jpeg | §11.6's three Berjaya pan-and-cover angles. Correct brand, all 500 px. |
| `_brand-reference\gn-fraction-size-chart-generic.jpg` | 1000x1052 | 112,200 B | https://image.made-in-china.com/2f0j00UtNCKYvmEgrO/1-1-Stainless-Steel-Gn-Container-Lid-with-Notched-Gastronorm-Food-Pan-Cover.jpg | Generic "Complete specifications" chart illustrating the 2/1, 1/1, 2/4, 2/3, 1/2, 1/3, 1/4, 1/6 and 1/9 footprints side by side. Handy for sizing conversations; not Berjaya. |
| `_brand-reference\REF__berjaya-four-glass-98L-singmah.jpg` | 800x600 | 31,605 B | https://singmahsteel.com/wp-content/uploads/2024/03/four-glass-98L-800x600-1.jpg | The **98 L** sibling from §8's range-gaps list, at 800 px. Explicitly not our 78 L. |
| `_brand-reference\REF__berjaya-display-chiller-1D-2D-3D-DC-SM-brochure.pdf` | - | 775,332 B | https://berjayacke.com/wp-content/uploads/ProductBrochure/CommercialRefrigerator/Display-Chiller.pdf | See finding 2 — **wrong product**, kept as reference only. |

### Rejected during verification

- https://cosmic.vn/wp-content/uploads/2019/12/z4258277161836_128486ba1e97068520a8fb3389a1f19f-1.jpg
  — §11.1 and §11.3 both name this "the cleanest hero" and "the single best find of this pass". It
  is not a hero at all: it is a **black-and-white macro close-up of the balloon whisk inside the
  bowl**, with the COSMIC logo occupying roughly a quarter of the frame. Downloaded, viewed,
  discarded. The two green-background full-machine shots on the same page are the usable ones and
  are staged above.
- https://cdn.ekuep.com/v4ekuep/img/p/4/0/1/6/5/40165-large_default.jpg — §11.4's ekuep urn link.
  Returns **HTTP 403** to any automated fetch. Not obtainable.
- https://maxima.com/en/... — every Maxima per-fraction GN page cited in §11.6 and §11.7 returns
  **HTTP 403**. §11.6's own parenthetical warned the CDN URLs are obfuscated; the pages themselves
  are now closed too. The generic per-fraction images above came from Made-in-China instead.
- https://www.nisbets.co.uk/... — tried as a Maxima substitute for per-fraction Vogue GN images.
  Also **403**.

### Coverage

14 SKUs in scope (the catalogue's current BERJAYA count, not §3's 15). Stated exactly:

| Bucket | Count | SKUs |
|---|---|---|
| Exact model, verified | 4 | IMG/DIS/00001 (chiller), IMG/PAS/00001 (BM20 mixer — confirmed as the correct without-netting configuration), GROUP/WATER-URN-CONCEALED-BERJAYA (urn family; see the caveat below), IMG/HYS/00179 (insect killer; see finding 4) |
| Representative only | 10 | All ten Gastronorm SKUs: IMG/TCW/00086, 00087, 00089, 00090, 00091 (pans) and IMG/TCW/00097, 00098, 00099, 00100, 00102 (covers) |
| Nothing | 0 | — |

Three honest caveats on that table, because the buckets flatter the result slightly:

1. **The urn group cannot be resolved to a size by any photograph.** §11.4 already established that
   no reseller distinguishes the 30 L from the 40 L. That is now doubly moot: the two SKUs have been
   merged into one grouped record covering both sizes, so a single family photo is arguably the
   *correct* asset rather than a compromise.
2. **The insect killer is exact-model only in the weak sense** that it is a Berjaya-branded photo
   from a Berjaya-group site. Berjaya shoots this range once; see finding 4.
3. **All ten Gastronorm SKUs are representative and will stay that way.** This is the third
   independent confirmation across three passes that no per-fraction Berjaya pan or cover photo
   exists — and this time it comes from Berjaya's own media index (three pan assets, all 400x400)
   rather than from failing to find one. Each GN SKU now carries a per-fraction *generic* image so
   the actual size class is visible, and the pan and cover SKUs additionally carry the
   Berjaya-branded range shot. Attaching a generic photo and calling it a Berjaya product photo
   would be the wrong trade; the `REPRESENTATIVE-` prefix is doing real work on these ten files.

### Findings

1. **The catalogue no longer matches this research file's SKU count.** §3 and §9 enumerate 15 SKUs
   including `IMG/COF/00001` (30 L urn) and `IMG/COF/00002` (40 L urn). `products.json` now holds
   14 BERJAYA records, with both urns merged into `GROUP/WATER-URN-CONCEALED-BERJAYA` and
   `model_number` set to `null` — so the `WU-CH-30L` / `WU-CH-40L` codes that §5.1 worked hard to
   establish are no longer stored on any record. Both sizes are still named in the grouped record's
   description. Flagging only; nothing edited.
2. **The one Berjaya brochure PDF that exists for this category is not our product.** §2 records
   that undocumented brochures live at
   `berjayacke.com/wp-content/uploads/ProductBrochure/{Category}/{Product}.pdf` and gives
   `CommercialRefrigerator/Display-Chiller.pdf` as the worked example, and §11.2 lists it under the
   display chiller with the note "embedded images, not extractable as direct URLs". It downloads
   fine (775 KB) and the images extract fine with PyMuPDF — but they are all under 450 px, and the
   text is the spec table for **`1D/DC-SM`, `2D/DC-SM` and `3D/DC-SM`**: upright glass-door chillers
   of 400 / 876 / 1,351 L, 2,060 mm tall, R134a, +1 to +6 degC. That is a completely different range
   from our 78 L four-sided countertop unit. §4's statement that "none exists for our display
   chiller" is the correct one; §11.2's listing of it under the chiller is misleading. Renamed with
   a `REF__` marker and moved to `_brand-reference\`.
3. **§11.1 recommends a wrong-variant photo as a "strong second source" for the mixer.** The
   Qualipro/tistatic image is ranked in §11.3 as "labelled BM20 20L, single clean photo". It is
   neither clean nor the right variant: it is a factory-floor snapshot with pallets, a bare concrete
   surface and a trailing power lead, and the machine in it has **the wire bowl guard fitted**. Per
   §3, `BJY-BM20` is the *without-netting* SKU and `BJY-BM20N` is a genuinely different product. The
   Singmah shared mixer photo has the same problem. Both are now marked `REF__`. The cosmic.vn pair
   are the only verified images of the correct configuration.
4. **The insect-killer photos all show two UV tubes; the record says one.** The stored
   `short_description` for `IMG/HYS/00179` reads "using a **15 W UV tube**" (singular). Every
   Berjaya photograph obtained — Singmah, Polar Bear, Fully Kitchen and Berjaya's own IK40A file —
   shows **two horizontal tubes** behind the grid. The `30` in `IK30A` is consistent with 2 x 15 W
   rather than one, and §8 records the IK40A as an "18 W lamp, 40/43 W" unit, which is also a
   two-lamp arithmetic. Recommend re-reading Berjaya's spec table before this copy is published.
   Separately, the model ambiguity §11.5 raised is not resolvable from photographs: the wide-bodied
   Singmah and Fully Kitchen shots and the more compact Polar Bear shot are plausibly the IK40A and
   IK30A respectively, but no source states the code against the image. All three are staged so the
   comparison can be made by eye.
5. **The 400-500 px ceiling on Berjaya's own photography is now proven, not assumed.** §4 inferred
   it by probing URLs; the WordPress media collection endpoint confirms it directly, and also
   confirms the three absences (`IK30`, `BM20`, per-fraction pans) that earlier passes established
   by 404-hunting. Any future pass should start there rather than guessing filenames.
6. **Singmah Steel should be the default first stop for Berjaya images**, ahead of berjayacke.com.
   Same group, same photography, consistently 800x600, no watermarks, and its media endpoint is
   open. It supplied the best available asset for the chiller, the urn and the insect killer, and
   the only Berjaya-branded pan and cover range shots above 500 px.

### Cross-check against the stored records

No contradiction was found between any sourced image and the stored data for the chiller, the mixer
or the urn — the corrections applied in §5 hold up visually. Specifically:

- The chiller photo shows **three** shelves, matching the record and §5.4.
- The urn photo shows a lidded, all-welded body with a side spigot and a base-mounted thermostat and
  no exposed element anywhere, corroborating §5.1's correction from "Exposed" to "Concealed".
- The mixer photo shows the handwheel-lift, three-tool planetary head described in §6.

The only image-versus-record contradiction is the insect killer's tube count (finding 4).

### Independent re-verification of every source URL

Because this section was reconstructed rather than written live (see the provenance note below),
every claim in the per-file table above was re-tested rather than trusted. All 39 staged files were
re-fetched from the URLs recorded and compared byte-for-byte by MD5.

**37 of 39 are byte-identical to the URL given.** The two that are not are both explained and
neither is a wrong asset:

- `GROUP-...__wu-ch-sharaf.png` — the Sharaf CDN serves this at 800x800 / 189,330 B; the staged copy
  is 800x800 / 18,330 B. Same image, same pixel dimensions, recompressed on the way in. The Shopify
  CDN ignores `width=`/size suffixes on this file and always returns the same 800x800 master, so
  800 px is the true ceiling either way.
- `IMG-TCW-00087__REPRESENTATIVE-gn-1-4-65mm-pan-generic.jpg` — the URL now returns 2117x1590 /
  238,238 B against the staged 2119x1592 / 254,039 B. Made-in-China re-renders its CDN copies
  periodically; it is the same photograph two pixels smaller. Both are far above the floor.

Two further things fell out of the re-check and are worth recording:

- **`singmahsteel.com/.../MIXER.jpg` and `singmahsteel.com/.../BJY-BM10N-800x600-1.jpg` are
  byte-identical.** Singmah serves the same file under both names. That pins the netted `REF__`
  mixer shot to the **BM10N** — the 10 litre netted body — rather than a BM20N. It strengthens
  finding 3: neither of the two "bowl guard fitted" images is our SKU, and one of them is not even
  our capacity.
- Berjaya's media endpoint was re-run and `search=Water-Urn` returns exactly **two** assets, both
  **500x500** — `Water-Urn.jpg` and `Water-Urn-WU-CH-20L.png`. That independently corroborates both
  the proven 500 px ceiling and the existence of the previously unrecorded WU-CH-20L file.

Four images were re-opened and eyeballed against their descriptions in the table above — the Singmah
chiller, the cosmic.vn bowl-raised mixer, the Sharaf urn and the Singmah insect killer. All four
match their descriptions in every detail, including the two points the descriptions turn on: the
mixer has **no bowl guard fitted** (correct without-netting BM20 configuration) and the insect killer
plainly shows **two** UV tubes behind the grid, which is finding 4.

### Provenance of this section

**This section was reconstructed after the agent that did the work was killed by a session limit
partway through writing it up.** The images had all been downloaded, opened and verified, and the
write-up had been fully drafted, but it was never appended to this file.

What was recovered, and how:

- The complete draft was found intact in the dead agent's transcript as a single file write, and the
  same file also survived on disk in that session's scratchpad. The two copies are identical, so the
  per-file table, the coverage table and all six findings above are the original author's work as
  written, not a paraphrase.
- Every source URL in it was then independently re-verified by MD5 as described above, so nothing in
  the table rests on the recovered text alone.

**Nothing is known to be unrecoverable.** All 39 staged files are accounted for, all 14 catalogue
SKUs are covered, and every source URL resolves. The one thing that cannot be reconstructed is the
author's intermediate reasoning — the candidate URLs tried and abandoned that never made it into the
"Rejected during verification" list. If a future pass finds an obvious source that appears to have
been skipped here, assume it was missed rather than deliberately rejected.
