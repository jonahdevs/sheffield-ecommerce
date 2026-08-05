# Carpigiani Product Research

Supersedes `old/carpigiani-research.md` (July 2026), which predates the SAP export. Covers all
3 CARPIGIANI SKUs.

Staging folder: `Desktop\ecommerce\products resorce final\carpigiani\`
Nothing in `products.json`, `brands.json` or `storage/` was changed by this pass. ⚠ The last
Carpigiani image pass wrote straight into `storage/` and skipped staging entirely - that did
not happen here, everything is in the staging folder.

---

## 1. Brand

**Carpigiani**, founded 1946, Anzola dell'Emilia (Bologna), Italy. Part of **Ali Group** since
1989. Gelato/ice-cream batch freezers, soft-serve machines, pasteurisers, blenders.

https://www.carpigiani.com
Image CDN: `https://dbe.carpigiani.com/sites/default/files/...`

**Sibling-brand trap still applies**: Coldelite is not a Carpigiani sub-brand - it is part of
Iceteam 1927, the other Ali Group gelato marque. Filter Iceteam machines out of parts matches.

---

## 2. ⚠ Two of the three official product pages are now dead

| SKU | URL | Status |
|---|---|---|
| IMG/ICE/00026 Turbomix | https://www.carpigiani.com/en/product/turbomix | 200 |
| IMG/ICE/00027 MAESTRO 2 HCD | https://carpigiani.com/us/product/maestro-hcd | **404** |
| IMG/ICE/00028 PASTOMASTER 60 RTX | https://carpigiani.com/us/product/pastomaster-60-rtx | **404** |

Carpigiani publishes **no reachable sitemap** (`/sitemap.xml`, `/sitemap_index.xml`,
`/en/sitemap.xml`, `/us/sitemap.xml` all 404), so slugs cannot be enumerated. Search engines
still index `/en/product/batch_freezer/maestro-1star-hcd`-style URLs but those 404 as well - the
site was restructured and the HCD/RTX generations dropped for the current HE range.

**What worked: listing the image CDN in the Internet Archive.**

https://web.archive.org/cdx/search/cdx?url=dbe.carpigiani.com%2Fsites%2Fdefault%2Ffiles%2F*&output=text&fl=original&collapse=urlkey&limit=3000

~3,000 asset paths came back, including `2019-05/Maestro-HCD_intera-laterale.jpg` - a 1920x1920
render of the **actual HCD generation**, still live on the CDN with no page linking it. Guessing
filenames had already failed; listing them worked. Worth reusing on any manufacturer whose
product pages have been restructured.

---

## 3. ⚠ HCD is not HE - and it is visible

The old research proposed falling back on the current **Maestro HE** renders because the body is
"near-identical". It is not close enough. The HCD has a **dark grey side panel and the older
blue control head**; the HE has a light silver panel and a different control layout. Per-pixel
RMS on 256x256 greyscale between the two official side views is **51.1** - clearly different
machines, not a rounding difference.

The HE renders are staged in `_brand-reference/` under names that state they are NOT our model.

---

## 4. Specification (from Carpigiani's own spec sheets)

SAP records **no dimensions for any Carpigiani SKU** (all three blank - MISSING, not zero), so
there is no SAP column order to establish on this brand.

### 4.1 Turbomix (IMG/ICE/00026) - vertical blender, not a freezer

| | |
|---|---|
| Motor | 3,000 - 12,000 rpm |
| Rotor speed | approx 22 m/s |
| Batch | 3 - 15 L per cycle |
| Dimensions | W 440 x D 500 x H 760-1140 mm (column height adjustable) |
| Weight | net 65 kg, crated 75 kg |
| **Electrical** | **230 V, 50-60 Hz, SINGLE phase, 10 A** |
| Safety | runs only with both hands on the handle |
| Heads | interchangeable cutter / creams / fruit emulsifiers |

**SAP's remark for this SKU is fully corroborated** - every figure matches the spec sheet. The
only oddity is "Condenser - Water", which is meaningless on a blender with no refrigeration
circuit. This is the single most reliable SAP remark across all four brands in this pass.

https://www.webstaurantstore.com/documents/specsheets/turbomix_05-2021_usa_lr_1_.pdf

### 4.2 Maestro 2 HCD (IMG/ICE/00027) - Hot-Cold-Dynamic batch freezer

| | water-cooled | air-cooled |
|---|---|---|
| Dimensions W x D x H | 500 x 960 x 1400 mm | 500 x 930 x 1400 mm |
| Net weight | 280 kg | 280 kg |
| Crated | 351 kg | 357 kg |
| Beater motor | 3 HP | 3 HP |
| Cylinder | 15 qt / 14 L | 14 L |
| Refrigerant | R404A | R404A |
| **Electrical** | **three-phase** (US 208-230/60/3; EU 400 V/50 Hz/3-ph) | same |

**Our stored 960 / 500 / 1400 matches the water-cooled build exactly**, so our record implicitly
asserts the water-cooled variant. Worth confirming against the actual unit.

https://www.webstaurantstore.com/documents/specsheets/carpigiani_maestro_hcd-w.pdf

### 4.3 Pastomaster 60 RTX (IMG/ICE/00028) - batch pasteuriser

| | |
|---|---|
| Tank | 60 L (63.4 US qt); batch range 15-60 L |
| Cycle | 60 kg per 2 hours (heat + cool, about 1 h) |
| Refrigerant | R404A |
| **Electrical (EU)** | **380 or 220 V, 50 Hz, 3 phase, 6.4 kW** |
| Water consumption | 300 l/h (water-condensed) |
| Net weight | 162 kg (US sheet) |

https://www.webstaurantstore.com/documents/specsheets/pastomaster_60_rtx_11-2020_usa_lr.pdf
https://www.machineryworld.com/wp-content/uploads/2018/10/Carpigiani-Pastomaster-30-60-120-RTX.pdf

⚠ **Dimensions do not converge.** Four figures, no two of which agree:

| Source | W | D | H |
|---|---|---|---|
| EU instruction handbook (50 Hz) | 350 | **915** | **1070** |
| US spec sheet, water-cooled | 350 | 1210 | 1080 |
| US spec sheet, air-cooled | 390 | 1370 | 1080 |
| **our stored record** | 350 | **860** | **1030** |

Width 350 is solid across the water-cooled sources. The US depths plainly include the fold-out
discharge shelf; the EU 915 is the body. **Our 860 x 1030 matches nothing published.** The old
research introduced 350 x 860 x 1030 calling it "the EU body footprint" - the actual EU manual
says 915 x 1070. **Recommend 350 x 915 x 1070 and flag, rather than silently pick.**

Also: the EU handbook's "Net Weight kg" column reads 150 / 300 / 450 for the 30/60/120, exactly
duplicating its water-consumption column - a mis-set printed column. **Use the US sheet's
162 kg**, not 300 kg.

### 4.4 Electrical, the installation-critical fact

- **Turbomix: 230 V, 50-60 Hz, single phase.** Runs on ordinary Kenyan mains.
- **Maestro 2 HCD: three-phase.**
- **Pastomaster 60 RTX: three-phase, 6.4 kW.**

Do not "correct" the two three-phase machines to single-phase 240 V.

---

## 5. ⚠ The EU Pastomaster manual is fully rasterised

`Carpigiani-Pastomaster-30-60-120-RTX.pdf` (41 pages) returns **zero text characters** from
`get_text()` on every page. It is the only 50 Hz document found for this model, and its
technical table only became readable after rendering page 10 at 200 dpi. That render is staged
in `_brand-reference/`.

Related: **carpigiani.com gates every download behind a "Download Catalogue" contact form**, so
all eight spec/manual PDFs here came from a reseller mirror (WebstaurantStore) or a
used-machinery dealer (machineryworld). They are Carpigiani's own documents, just not served by
Carpigiani.

---

## 6. Imagery

| SKU | Files | Best px | Source |
|---|---|---|---|
| IMG/ICE/00026 Turbomix | 7 | 1920x1920 | https://www.carpigiani.com/en/product/turbomix + https://www.webstaurantstore.com/carpigiani-turbomix-vertical-blender/439TURMIXAW.html |
| IMG/ICE/00027 MAESTRO 2 HCD | 2 | **2000x2000** | https://www.webstaurantstore.com/carpigiani-maestro-hcd-w-15-qt-water-cooled-gelato-pastry-chocolate-batch-freezer-with-hot-cold-dynamic-208-230v-3-phase/439MAESTROWW.html + the archived CDN path |
| IMG/ICE/00028 PASTOMASTER 60 RTX | 1 | 1700x1700 | https://www.webstaurantstore.com/carpigiani-pastomaster-pkt60-rtx-63-4-qt-air-cooled-pasteurizer-208-230v/439PMAS60AW.html |

### 6.1 ⚠ The recorded ceiling was wrong - an unlinked `xxl` path

WebstaurantStore's markup exposes `large` and `extra_large`; `extra_large` is 1000x1000, and the
old research recorded these SKUs as 17-33 KB thumbnails on that basis. There is an **unlinked
`xxl` path** on the same CDN:

| SKU | linked `extra_large` | unlinked `xxl` |
|---|---|---|
| Maestro ** HCD-W | 1000x1000 | **2000x2000** |
| Turbomix | 1000x1000 | **1800x1800** |
| Pastomaster 60 RTX | 1000x1000 | **1700x1700** |

`xxl` appears in the page source only for the Maestro; for the other two it had to be probed
directly. `original` and `huge` both 404, so `xxl` is the true ceiling.

Full ceilings: Carpigiani's own CDN **1920x1920**; WebstaurantStore `xxl` **1700-2000**;
spec-sheet PDF embedded objects only 533-1442 px (the artwork is placed small, so PDF extraction
did **not** beat the web on this brand).

### 6.2 Nothing AI-generated

`_ai-generated/` is empty. Every accepted file is Carpigiani's own studio photography - real
reflections in brushed stainless, physically consistent castors and hinges, legible CARPIGIANI
and TURBOMIX nameplates. Every image was opened.

---

## 7. Product reference

| SKU | model_number | Spec sheet | Confidence |
|---|---|---|---|
| IMG/ICE/00026 | Turbomix | https://www.webstaurantstore.com/documents/specsheets/turbomix_05-2021_usa_lr_1_.pdf | **High** - official sheet, exact model, SAP corroborates |
| IMG/ICE/00027 | MAESTRO 2 HCD | https://www.webstaurantstore.com/documents/specsheets/carpigiani_maestro_hcd-w.pdf | **High** - sheet titled "Maestro** HCD", exact two-star model |
| IMG/ICE/00028 | PASTOMASTER 60 RTX | https://www.webstaurantstore.com/documents/specsheets/pastomaster_60_rtx_11-2020_usa_lr.pdf | **High** on identity and electrical, **Low** on dimensions (section 4.3) |

Supporting sources:

https://www.carpigiani.com/en/product/turbomix
https://dbe.carpigiani.com/sites/default/files/2019-05/Maestro-HCD_intera-laterale.jpg
https://www.webstaurantstore.com/documents/pdf/maestro_operations_manual.pdf
https://www.webstaurantstore.com/documents/pdf/pk60120rtxopsmanual.pdf
https://www.webstaurantstore.com/documents/pdf/carpigiani_maestro_and_ready_catalog.pdf
https://www.webstaurantstore.com/documents/pdf/brochure/turbomix_catalog_11-2020_usa_lr.pdf
https://www.machineryworld.com/product/carpigiani-pastomaster-rtx-ice-cream-batch-pasteuriser/

---

## 8. Recommended changes (nothing applied)

1. 🟠 **Pastomaster 60 RTX dimensions**: our 350 x 860 x 1030 matches no published figure.
   Recommend the EU handbook's **350 x 915 x 1070** - but this needs a decision, not a blind
   edit, because the US sheet says 1210 mm deep (including the fold-out shelf) - section 4.3.
2. 🟠 **Pastomaster weight**: add **162 kg net**. Ignore the EU handbook's 300 kg, which is a
   mis-set column - section 4.3.
3. 🟡 **Turbomix height** is stored as 760 mm, which is the **minimum** of an adjustable
   760-1140 mm range. State the range.
4. 🟡 **Maestro 2 HCD**: our stored 960 mm depth implicitly asserts the **water-cooled** build
   (air-cooled is 930). Confirm which is actually stocked - section 4.2.
5. 🟡 Add refrigerant **R404A** to the Maestro and Pastomaster (the Turbomix has no refrigeration
   circuit at all and should not carry one).
6. ⚪ **Do not** change the three-phase electrical labels on the Maestro or Pastomaster.
7. ⚪ No `model_number` change proposed. No `brands.json` change needed.
