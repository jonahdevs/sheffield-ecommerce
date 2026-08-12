# Carpigiani Product Research

Supersedes the archived research below (July 2026), which predates the SAP export. Covers all
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

---

## Archived brand research

> Merged in from the former `research/old/` folder on 2026-08-12, when the two folders were
> consolidated. This is the earlier **specs and codes** pass; everything above it
> is the later **sourcing and provenance** pass. The text is unchanged apart from
> heading levels, which were demoted one step to keep a single outline.

## Carpigiani Product Research

Research notes behind the CARPIGIANI enrichment/audit pass on `products.json` (July 2026).
Covers all 3 CARPIGIANI SKUs: a vertical blender (Turbomix), a Hot & Cold Dynamic batch
freezer (Maestro 2 HCD) and a batch pasteuriser (Pastomaster 60 RTX). Specs were sourced
from Carpigiani's own product pages and official spec sheets mirrored by resellers, and
cross-checked against used-equipment marketplaces.

**This pass corrected scrambled dimensions on two of the three SKUs, tightened all three
model codes, and added the missing specs, spec tables and meta descriptions.** No image
field was changed — image sourcing (§6) is presented as links for manual review first.

---

### 1. Brand identification

**Carpigiani**, founded **1946**, HQ in **Anzola dell'Emilia (Bologna), Italy**. The world's
leading maker of gelato / ice-cream / soft-serve machines (~35% global share). Product scope:
artisan batch freezers, soft-serve machines, pasteurisers, whipped-cream machines,
blenders/homogenisers, display and dispensing equipment, plus parts and accessories.

**Part of Ali Group since 1989** (Ali Holding — the world's #2 professional foodservice
equipment group). Also runs the **Carpigiani Gelato University** (founded 2003, Anzola
dell'Emilia).

**Sibling-brand trap — Coldelite is NOT a Carpigiani sub-brand.** The other main Ali Group
gelato brand is **Iceteam 1927** (a 2010 unification of **Cattabriga, Coldelite, Promag and
Ott Freezer**). Legacy "Carpigiani-Coldelite" parts references exist because the brands were
historically bundled, so parts/model matches can pull in Iceteam 1927 machines that are **not
Carpigiani**. Filter those out.

---

### 2. Where to look — and the traps

| Resource | URL |
|---|---|
| Official site | <https://carpigiani.com> (path prefixes `/en/`, `/us/`, `/uk/`; also carpigiani.co.uk) |
| Official CDN (images) | `dbe.carpigiani.com/sites/default/files/...` |
| Parts store | shop.carpigiani.com |
| Refurbished portal | carpigiani.com/en/page/refurbished |
| Parts / manuals (3rd-party) | partstown.com/b/carpigiani |

Product URL pattern is `carpigiani.com/{lang}/product/{slug}`. **Product pages are usually
automated-fetch friendly** (server-rendered HTML with full copy) — but some `/us/` slugs are
SPA/JS pages that 404 to a fetcher even though the product exists.

**There are no directly linkable spec-sheet PDFs on the official site** — downloads are gated
behind a "Download Catalogue" contact-form modal. Get the official datasheets from resellers
who mirror them (e.g. `webstaurantstore.com/documents/specsheets/*.pdf`, PartsTown). They are
image-heavy PDFs: the artwork lifts cleanly, the text does not extract.

#### Traps

1. **"Stelle" = "stars" = the size/capacity tier, not a separate brand.** "2 Stelle",
   "Due Stelle", "2 Star" and the badge "Maestro ✱✱" are all the **same** two-star size class.
   Do not treat them as different products, and do not strip the star token from a model name —
   it is the size. (1 Stella = smaller, 3 Stelle = larger.)
2. **HCD vs HE vs XPL are feature/generation suffixes on the same family**, but they carry
   **different specs** — never merge their datasheets. **HCD-A vs HCD-W = Air- vs Water-cooled**;
   treat as distinct SKUs (different plumbing, sometimes different electrical).
3. **Voltage variants — do not copy US spec sheets.** Kenya is **50 Hz, three-phase**
   (400–415 V). US listings for the "same" machine are **208–230 V / 60 Hz**. Grab the
   EU / 3-phase / 50 Hz column. (The Turbomix is the exception — it is single-phase 230 V,
   which suits Kenyan mains.)
4. **Slug instability.** Official product slugs vary by market and generation and some 404 to
   a fetcher — always resolve via search, never guess the URL.
5. **Discontinued vs current.** Many Stelle/HCD units on used marketplaces are older
   generations; the current official range leans **HE**. Our machines match the still-catalogued
   HCD / RTX generations, but confirm before treating any spec sheet as current.
6. **"Turbomix" is a *vertical blender*, not an "immersion blender".** Searching "immersion
   blender" can miss the official product; search "Turbomix" / "vertical blender".

---

### 3. Product reference

| SKU | Catalogue name (now) | Model (now) | What it is | Official page | Spec source |
|---|---|---|---|---|---|
| IMG/ICE/00026 | Turbomix Vertical Blender | Turbomix | Vertical blender / emulsifier (prep, not a freezer) | [turbomix](https://carpigiani.com/us/product/turbomix) | Official spec sheet PDF (05/2021) |
| IMG/ICE/00027 | Ice Cream Machine Maestro 2 HCD | MAESTRO 2 HCD | Hot & Cold Dynamic batch freezer, 14 L | [maestro-hcd](https://carpigiani.com/us/product/maestro-hcd) | applanat + WebstaurantStore (agree) |
| IMG/ICE/00028 | Pastomaster 60 RTX Batch Pasteuriser | PASTOMASTER 60 RTX | Batch pasteuriser / ageing machine, 60 L | [pastomaster-60-rtx](https://carpigiani.com/us/product/pastomaster-60-rtx) | Official RTX spec sheet PDF (11/2020) |

#### Model resolutions

- **Turbomix** (was "TURBO MIX" / "Ice Cream Machine Turbo Mix"): the model is **"Turbomix"**
  (one word). US reseller SKU `439TURMIXAW`. An older "Turbomix 10" exists on the legacy
  `dbe.carpigiani.com` host, but the current catalogue model carries no numeric suffix. It is
  a blender/emulsifier — the old "Ice Cream Machine" name was misleading.
- **Maestro 2 HCD** (was "MAESTRO-2STELLE HCD"): decodes to the **two-star (✱✱) Maestro with
  Hot & Cold Dynamic**, the **14 L** cylinder / **3 HP** beater variant — which matches our
  record's 14 L + 3 HP exactly. "2STELLE" was a legitimate size token, just mangled; kept as
  "2". On US listings the identical machine is "Maestro ✱✱ HCD".
- **Pastomaster 60 RTX** (was "PASTO MASTER"): the **60 L** size of the **RTX** ("classic heat
  treatment") series. Pinned to RTX (not RTL/HE/XPL) by our own description text — the
  "16 programs for base mixtures, syrups and other liquid pastry products", the exchange pump,
  the transparent lid openable during production, and the built-in faucet are all verbatim RTX
  spec-sheet copy.

---

### 4. Data audit — errors found and corrected

#### 4.1 Scrambled dimension fields on two SKUs ⚠

Both the Maestro and the Pastomaster had `length` / `width` / `height` numeric fields that did
**not** match their own on-record spec tables — the width and height were transposed.

| SKU | Stored L×W×H (wrong) | On-record spec table | Corrected to (W×D×H) |
|---|---|---|---|
| IMG/ICE/00027 Maestro | 930 × 1400 × 500 | W 500 / D 930 / H 1400 | **500 × 960 × 1400 mm** |
| IMG/ICE/00028 Pastomaster | 1370 × 1080 × 390 | W 390 / D 1370 / H 1080 | **350 × 860 × 1030 mm** |

- **Maestro depth** also corrected **930 → 960 mm** (EU 96 cm and US 960 mm agree; 930 was
  wrong). Stored now as length/depth 960, width 500, height 1400.
- **Pastomaster** — the old spec-table numbers (390 / 1370 / 1080) were the **US datasheet's
  overall/crated** figures, not the machine body. Replaced with the **EU body footprint
  350 × 860 × 1030 mm** for a 50 Hz-market listing. Stored now as length/depth 860, width 350,
  height 1030.

#### 4.2 Turbomix dimensions were wrong *and* mis-axed ⚠

Stored `length 500 / width 760 / height 440` were three unrelated drawing numbers on the wrong
axes. Correct envelope: **W 440 × D 500 × H 760–1140 mm** (the column height is adjustable —
the arm raises and lowers). Stored now as length/depth 500, width 440, height 760 (min), with
the adjustable range stated in the spec table.

#### 4.3 Voltage — confirmed, do NOT "fix" to 240 V

- **Maestro 2 HCD** and **Pastomaster 60 RTX** are genuinely **380–415 V / 50 Hz / 3-phase**
  (Pastomaster nominal 400 V). The existing "380V/50H" label was essentially correct — these
  are three-phase machines and need a three-phase supply, not single-phase 240 V mains.
  Labels tidied to explicit "380–415 V / 50 Hz / 3 phase" and "400 V / 50 Hz / 3 phase".
- **Turbomix** is **single-phase 230 V** (50–60 Hz) — it *does* suit standard Kenyan mains.
  Recorded as such and flagged as a selling point.

#### 4.4 Specs built out / model codes tightened

- **Model codes**: `TURBO MIX` → **Turbomix**; `MAESTRO-2STELLE HCD` → **MAESTRO 2 HCD**;
  `PASTO MASTER` → **PASTOMASTER 60 RTX**.
- **Names**: Turbomix renamed off the misleading "Ice Cream Machine" prefix to
  "Turbomix Vertical Blender".
- **Spec tables** rebuilt from bare `<ul>` stubs into full HTML `<table>` blocks matching the
  catalogue pattern; **added** motor/rpm/capacity/weight/voltage (Turbomix), production rate /
  compressor / cooling / weight / power (Maestro), batch range / programs / pasteurisation
  temp / power / weight (Pastomaster).
- **Descriptions** rewritten from raw bullet lists into the catalogue prose + `Key Features`
  pattern. **`meta_description` added to all three** (all were missing).
- **Dropped** the low-confidence "Volume 1.053 m³" line from the Maestro spec — the figure is
  a packaging/crate volume, not the machine envelope, and is not published by Carpigiani.

---

### 5. Not published — left blank rather than invented

- **Turbomix**: motor **HP** and exact **kW rating** (only ~2.3 kW electrical load is inferable
  from 230 V × 10 A), and cutter-blade dimensions.
- **Maestro 2 HCD**: **hopper capacity**, hourly production **in litres** (only kg/h is given),
  and whether our specific unit is the **air- or water-cooled** build. Weight recorded as
  ~280 kg (EU); the US listing's 773 lb ≈ 351 kg is a heavier/crated build.
- **Pastomaster 60 RTX**: explicit **cooling set-point** (~4 °C ageing is Carpigiani-standard
  but not printed on the sheet) and **holding time**.

---

### 6. Image sourcing — for manual review

No image field was changed this pass. Best sources for clean Carpigiani product imagery,
ranked: (1) **official product pages / the `dbe.carpigiani.com` CDN** — on-white studio
renders, watermark-free; (2) **reseller-mirrored official spec-sheet PDFs** (webstaurantstore,
partstown) — high-res renders + dimension drawings; (3) **clean dealer catalog photos**
(webstaurantstore, carpigiani.co.uk) — studio shots, minimal/no watermark; (4) **used-machine
marketplaces** (applanat, machineryworld, exapro, wotol) — huge coverage incl. discontinued
Stelle variants and real rating-plate photos, but often **watermarked / shot in situ** — use
for verification, not hero images. All URLs below returned **HTTP 200 at time of writing**.

#### 6.1 Turbomix — IMG/ICE/00026

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| official CDN | [turbomix](https://carpigiani.com/us/product/turbomix) | <https://dbe.carpigiani.com/sites/default/files/2019-05/Turbomix_intera-laterale.jpg> | 200, jpeg, 355 KB | **Best** — full side view on stand, clean studio, no watermark, exact model. |
| official CDN | (same) | <https://dbe.carpigiani.com/sites/default/files/2019-05/Turbomix_sostituzione-emulsionatori.jpg> | 200, jpeg, 1.21 MB | Detail: swapping emulsifier blades. |
| official CDN | (same) | <https://dbe.carpigiani.com/sites/default/files/2019-05/Turbomix_comando-a-due-mani.jpg> | 200, jpeg, 864 KB | Detail: two-hand safety control in use. |
| WebstaurantStore | [439TURMIXAW](https://www.webstaurantstore.com/carpigiani-turbomix-vertical-blender/439TURMIXAW.html) | <https://cdnimg.webstaurantstore.com/images/products/large/608509/2195396.jpg> | 200, jpeg, 17 KB | Low-res thumbnail — fallback only. |

**Best pick:** `Turbomix_intera-laterale.jpg` (official, high-res, watermark-free hero).
**Dead/blocked:** none.

#### 6.2 Maestro 2 HCD — IMG/ICE/00027

Carpigiani's official site now hosts only the current **HE** generation (guessed "Maestro
HCD" CDN filenames 404); the HE body is near-identical to our HCD. The exact two-star **HCD**
studio shot survives on WebstaurantStore. All URLs below re-verified loading (July 2026).

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| WebstaurantStore | [439MAESTROWW](https://www.webstaurantstore.com/carpigiani-maestro-hcd-w-15-qt-water-cooled-gelato-pastry-chocolate-batch-freezer-with-hot-cold-dynamic-208-230v-3-phase/439MAESTROWW.html) | <https://cdnimg.webstaurantstore.com/images/products/large/608407/2177644.jpg> | 200, jpeg, 33 KB | **Exact two-star ✱✱ HCD-W**, clean white bg, no watermark. Best exact-model match (low-res). |
| official CDN (HE gen) | [maestro-2-star-HE](https://carpigiani.com/en/product/maestro-2-star-HE) | <https://dbe.carpigiani.com/sites/default/files/2020-11/Maestro%20HE_intera-laterale.jpg> | 200, jpeg, 687 KB | Official, watermark-free, hi-res **side** view. HE generation (current) — near-identical body to HCD. |
| official CDN (HE gen) | (same) | <https://dbe.carpigiani.com/sites/default/files/2020-11/Maestro%20HE_intera-frontale.jpg> | 200, jpeg, 553 KB | Official hi-res **front** view, HE generation. |
| GTI Designs (mirror) | [maestro-hcd](https://gtidesigns.com/gtiproduct/maestro-hcd/) | <https://gtidesigns.com/wp-content/uploads/2022/01/Maestro-HCD-3_intera-laterale_USA_1920x1920px_3to2pt25.jpg> | 200, jpeg, 124 KB | HCD badge, but the **three-star** body; hi-res 1920px, clean white. |
| applanat (used unit) | <https://www.applanat.com/turbine-glace-patisserie-14-litres--maestro-2-hcd--carpigiani--occasion,6969,256.html> | <https://www.applanat.com/photodynp2020/538/538/non/oui/vyb9pm2v-Turbine_Carpigiani_Maestro_2_HCD_occasion.jpg> | 200, jpeg, 66 KB | Real photo of an actual 2 HCD unit, no watermark. Used listing — page may expire once sold. |

**Best pick:** WebstaurantStore `2177644.jpg` for the exact two-star model; for a large, crisp
hero use official `Maestro HE_intera-laterale.jpg` (687 KB) — note it is the HE generation, not
the HCD badge.
**Dead / wrong-model:** guessed official `Maestro HCD` CDN filenames 404 (site keeps only HE);
`baluna.com/.../carpigiani-master-hcd/` 404s; machineryworld's `...Maestro-1-Stella-HCD...8.jpg`
is the **one-star** model. Note: the earlier applanat *page* URL contains commas that break some
markdown previewers — the direct image URL beside it loads fine.

#### 6.3 Pastomaster 60 RTX — IMG/ICE/00028

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| official CDN | [pastomaster-60-rtx](https://carpigiani.com/us/product/pastomaster-60-rtx) | <https://dbe.carpigiani.com/sites/default/files/2020-01/Pastomaster-60-RTX_intera-laterale_01-2020-USA_0.jpg> | 200, jpeg, 23 KB | **Best** — official render, exact RTX model, clean, no watermark (low-res ~510px). |
| WebstaurantStore | [PKT60 RTX](https://www.webstaurantstore.com/) | <https://cdnimg.webstaurantstore.com/images/products/large/608343/2178304.jpg> | 200, jpeg, 24 KB | Exact RTX on white, no visible watermark (US 208–230 V variant; body identical). |
| Carpigiani UK | [60 XPL P](https://www.carpigiani.co.uk/product/pastomaster-60-xpl-p-pasteuriser/) | <https://www.carpigiani.co.uk/hubfs/Coperchio-aperto_2-w510.jpg> | 200, jpeg, 21 KB | Detail: open transparent lid (illustrates the description); generic to the 60 L series. |
| A.F. System | [60 RTL](https://afsystem.biz/en/featured-products/23-pastomaster-60-rtl.html) | <https://www.afsystem.biz/1373-large_default/pastomaster-60-rtl.jpg> | 200, jpeg, 14 KB | Real photo of a used **RTL** (older series, not RTX) — reference only. |

**Best pick:** official `Pastomaster-60-RTX_intera-laterale...jpg`; pair with WebstaurantStore
`2178304.jpg` for a second angle. Both low-res (~23 KB) — request higher res from a distributor
if a large hero is needed.
**Dead/blocked:** none. Note the `carpigiani.co.uk` shot is the **XPL P** (touch-panel) variant,
not RTX — same 60 L body, different control panel.

---

### 7. Summary of `products.json` changes this pass

All 3 SKUs enriched. Before this pass: all 3 had no `meta_description`; the Turbomix had no
`technical_specification` and no image; both the Maestro and Pastomaster had scrambled
dimension fields and bare `<ul>` spec stubs.

- **Corrections**: dimension fields de-scrambled and corrected (Maestro → 500×960×1400;
  Pastomaster → 350×860×1030; Turbomix → 440×500×760 min); model codes tightened
  (`Turbomix`, `MAESTRO 2 HCD`, `PASTOMASTER 60 RTX`); Turbomix renamed off the misleading
  "Ice Cream Machine" prefix; low-confidence Maestro "Volume" line dropped.
- **Built out**: full HTML spec tables replacing bullet stubs; prose + `Key Features`
  descriptions; `meta_description` on all 3; recovered specs (Turbomix motor/rpm/capacity/
  weight/voltage; Maestro production/compressor/cooling/weight/power; Pastomaster batch range/
  programs/pasteurisation temp/power/weight).
- **No image field changed** — §6 links presented for manual review first. Turbomix remains
  `draft` (no image yet); Maestro and Pastomaster remain `published`.
