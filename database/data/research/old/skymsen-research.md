# Skymsen Product Research

Research notes behind the Skymsen enrichment pass on `products.json` (July 2026). Data was
sourced from Skymsen's official export site and cross-checked against resellers.

Covers 20 machine SKUs. Seven further Skymsen entries are archived spare discs and blades
(`IMS/MEC/*`) which were left untouched - they are line items rather than catalogue products.

---

## 1. Brand structure

The same machines are sold under four names. Always match on **model code**, not brand name:

| Brand | Market | Site |
|---|---|---|
| **Siemsen** (Metalúrgica Siemsen Ltda, Brusque, Santa Catarina) | Brazil domestic | siemsen.com.br |
| **Skymsen** | Export / international | skymsen.com |
| **Skyfood** (sometimes Fleetwood) | USA | skyfood.us |
| **Skymsen Europa** | Europe, 230 V / 50 Hz | skymseneuropa.com |

US model codes differ: `DB-10` is sold as `EL-10`, `CSE` as `CSE1`, `BMS-N` as `BMS`.
Useful as extra photo sources, but **never quote their specs** - they are 110–120 V / 60 Hz.

---

## 2. Cross-cutting rules

### Voltage and frequency (the big one)

Kenya is 240 V / 50 Hz. Skymsen sells a **separate SKU per voltage/frequency combination**,
and the specs genuinely differ between them:

- **LAR blender line**: 60 Hz units run **3,500 rpm**; 50 Hz units run **3,000 rpm**.
  Most reseller pages quote 3,500 rpm because they are US/Brazil listings.
- **ESB SUPER-N juicer**: 1,750 rpm at 60 Hz, **1,500 rpm at 50 Hz**.
- Motor power, dimensions and capacity are unchanged across variants; only speed and
  electrical supply move.

Publishing a 60 Hz rpm figure against a 50 Hz machine is a false spec. All entries in
`products.json` now carry 50 Hz figures.

### Dimension ordering

Skymsen publishes dimensions as **H × W × L**, not W × D × H. Most existing catalogue
entries had the right numbers in the wrong fields. All Skymsen SKUs have been reordered to
the catalogue's `length` / `width` / `height` convention.

### Not published - do not invent

- No **kg/h throughput** figure exists for the CSE juicer (only rpm).
- No **noise level** is published for any LAR blender or the BM2.
- No **IP rating** is published for any model.
- Cup capacities are quoted as a single maximum figure; there is no separate
  "useful vs total" volume.

---

## 3. Corrections applied

| SKU | Product | Was | Now |
|---|---|---|---|
| IMG/FPR/00048 | Potato Peeler 25KG | 110 V / 60 Hz with 45 kg net | 220 V / 50 Hz - 45 kg is the **220 V** figure; the 110 V unit is 48 kg. The record mixed two variants. |
| IMG/FPR/00033–38 | LAR blenders (5 SKUs) | 3,500 rpm | 3,000 rpm at 50 Hz |
| IMG/FPR/00169 | Blender Bar 2 Litres | implied stainless cup | Cup is **Tritan polymer**; only the base is metal |
| IMG/FPR/00214 | Juice Extractor ESB Super N | "entry-level", "affordable" | It is the **uprated 0.5 HP** model. `ESB-N` is the entry model (0.25 HP) |
| IMG/FPR/00042 | Vegetable Processor PA7 | 0.25 HP, 300–400 kg/h, 6 discs | 0.5 HP, ~250 kg/h, **7 discs** |
| All Skymsen | - | dimensions in wrong axes | reordered from H×W×L |
| IMG/FPR/00048, 00246, 00050, 00105 | peelers + chipper | short description read *"SYSTEMATIC JSPCC-08 commercial potato chipper"* | Rewritten - copy-paste bug from an unrelated product |

---

## 4. Open questions for the supplier

These were **not** changed in `products.json`, because they need confirmation against
purchase paperwork.

### 4.1 DAK is a different manufacturer

`IMG/FPR/00050` (Potato Smasher on Stand) and the two chipper blades `IMS/MEC/00309` /
`IMS/MEC/00312` are filed under brand **SKYMSEN**, but **DAK is Metalúrgica DAK of Canoas,
Rio Grande do Sul** - an unrelated Brazilian manufacturer. Searching skymsen.com,
skyfood.us and skymseneuropa.com returns zero results for a model "DAK".

There is no manufacturer spec sheet, manual, EAN or HS data for DAK in English; all
sources are Brazilian retail listings.

Two further points on this SKU:

- The name says **"Potato Smasher"** but the 10 mm blades describe a **chipper**. DAK makes
  both a masher (*amassador*) and a chip cutter (*cortador de legumes*) - unrelated products
  sharing a brand. The description now written assumes the chipper.
- Sizing is inconsistent across resellers ("médio", "grande", "tripé industrial"). Ref. 109
  measures 121 × 53 × 48 cm at 4.6 kg. Confirm which size before publishing dimensions.

### 4.2 Model numbers carry a suffix that does not exist on export units

| In catalogue | Actual export code |
|---|---|
| LAR-03MB-N | LAR-03MB |
| LAR-04MB-N | LAR-04MB |
| LAR-08MB-N | LAR-08MB |
| LAR-10MB-N | LAR-10MB |
| LAR 25MB | **does not exist** - see below |

The `-N` suffix belongs to Skymsen's *Brazilian domestic* lines (`LS-xxMB-N`, `TA-xxMB-N`),
which are **different machines** - `LS` is explicitly a low-rotation blender for pastier
products. If supplier paperwork genuinely says `LS-04MB-N`, the specs written do not apply.

### 4.3 The 25 litre blender needs a model decision

There is no `LAR-25MB`. The 25 L machines are:

- **LAR-25LMB** - tilting, **with** stainless steel floor stand
- **LAR-25PMB** - tilting, seamless cup, **without** stand
- **LAR-25LMB-HD** - heavy-duty stand version

`products.json` was written for **LAR-25LMB** as the most likely match. Net weight is
inconsistent on Skymsen's own site (20.5 kg on the 50 Hz SKU vs 25.5 kg on the 60 Hz SKU for
identical dimensions) - the 20.5 kg looks like a data-entry error, so ~25.5 kg is published.

### 4.4 PA-7 vs PA-7 PRO

Current production is **PA-7 PRO**, which superseded the PA-7. The PRO adds cube-cutting
disc combinations, a teflonised disc finish and a redesigned feed assembly. Net weight
differs (27.8 kg PRO vs ~25.7 kg legacy). Catalogued as PA-7; switch if the supplier ships
the PRO.

### 4.5 MAXICONV is two SKUs

- **MAXICONV SV** - *sem vapor*, no steam
- **MAXICONV VP** - manual steam injection via a panel button

The catalogue entry is generic "MAXICONV". The VP is the more widely listed of the two.
Note max temperature is **210 °C** - do not copy generic "up to 300 °C" convection claims.

### 4.6 Discovery 10 tray size changes the dimensions

The 60 × 80 cm tray option changes depth (1,590 → 1,490 mm) and weight (326 → 250 kg).
Published figures assume 60 × 70 cm trays. At 20 kW, three-phase is mandatory.

---

## 5. Product reference

Official page and spec sheet per catalogue SKU. **The `folders/*.pdf` spec sheets are the
best image source** - print-quality Adobe Illustrator files with clean white-background
studio renders.

| SKU | Catalogue name | Model | Official page | Spec sheet PDF |
|---|---|---|---|---|
| IMG/FPR/00042 | Vegetable Processor PA7 | PA-7 | [704270](https://www.skymsen.com/en/index.php/produtos/detalhe/704270) | [704270_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/704270_eng.pdf) |
| IMG/FPR/00246 | Potato Peeler with Door 10KG | DB-10 | [041173](https://www.skymsen.com/en/index.php/produtos/detalhe/041173) | [704903_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/704903_eng.pdf) |
| IMG/FPR/00048 | Potato Peeler 25KG | DB-25HD | [352268](https://www.skymsen.com/en/index.php/produtos/detalhe/352268) | [352268_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/352268_eng.pdf) |
| IMG/FPR/00033 | Blender Kitchen 3 Litres SS | LAR-03MB | [710024](https://www.skymsen.com/en/index.php/produtos/detalhe/710024) | [710024_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/710024_eng.pdf) |
| IMG/FPR/00034 | Blender Kitchen 4 Litres SS | LAR-04MB | [472727](https://www.skymsen.com/en/index.php/produtos/detalhe/472727) | [472727_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/472727_eng.pdf) |
| IMG/FPR/00036 | Blender Kitchen 8 Litres SS | LAR-08MB | [472778](https://www.skymsen.com/en/index.php/produtos/detalhe/472778) | [472778_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/472778_eng.pdf) |
| IMG/FPR/00037 | Blender Kitchen 10 Litres SS | LAR-10MB | [472808](https://www.skymsen.com/en/index.php/produtos/detalhe/472808) | [472808_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/472808_eng.pdf) |
| IMG/FPR/00038 | Blender Kitchen 25 Litres SS | LAR-25LMB | [411663](https://www.skymsen.com/en/index.php/produtos/detalhe/411663) | [411655_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/411655_eng.pdf) |
| IMG/FPR/00169 | Blender Bar 2 Litres | BM2 | [649287](https://www.skymsen.com/index.php/produtos/detalhe/649287) | [649287.pdf](https://www.skymsen.com/uploads/produtos/folders/649287.pdf) |
| IMG/FPR/00040 | Juice Extractor Centrifugal CSE | CSE | [589942](https://www.skymsen.com/en/index.php/produtos/detalhe/589942) | [589942_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/589942_eng.pdf) |
| IMG/FPR/00214 | Juice Extractor ESB Super N | ESB SUPER-N | [461652](https://www.skymsen.com/en/index.php/produtos/detalhe/461652) | [461652_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/461652_eng.pdf) |
| IMG/ICE/00019 | Milk Shake Mixer Single | BMS-N | [324752](https://www.skymsen.com/en/index.php/produtos/detalhe/324752) | [324752_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/324752_eng.pdf) |
| IMG/ICE/00020 | Milk Shake Mixer Triple | BMS-3-N | [451991](https://www.skymsen.com/index.php/produtos/detalhe/451991) | [451991.pdf](https://www.skymsen.com/uploads/produtos/folders/451991.pdf) |
| IMG/FPR/00215 | Meat Slicer 300 | CFI-300L-N | ⚠ 404 - see §6 | [496049_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/496049_eng.pdf) |
| IMG/FPR/00051 | Bone Saw Free Standing | SI-282HD | [624063](https://www.skymsen.com/en/index.php/produtos/detalhe/624063) | [624063_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/624063_eng.pdf) |
| IMG/OVE/00215 | Oven Convection 4 Tray Maxiconv | MAXICONV | ⚠ 404 - see §6 | [661805.pdf](https://www.skymsen.com/uploads/produtos/folders/661805.pdf) |
| IMG/OVE/00214 | Oven Convection 10 Trays Discovery 10 | DISCOVERY 10 | [609781](https://www.skymsen.com/en/index.php/produtos/detalhe/609781) | [609781_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/609781_eng.pdf) |
| IMG/FPR/00050 | Potato Smasher on Stand | DAK | none - not a Skymsen product | none |

The numbers in those URLs are Skymsen's internal product codes for a **specific voltage
variant**. Where a choice existed, the 220 V / 50 Hz page is linked.

### Order codes for Kenya (220 V / 50 Hz)

| Model | Code |
|---|---|
| DB-10 | 04117.3 |
| DB-25HD | 35226.8 |
| CSE | 58994.2 |
| BMS-3-N | 45200.9 |
| CFI-300L-N | 49604.9 |
| MAXICONV VP | 68529.1 |
| DISCOVERY 10 | 610909 (380 V / 50 Hz / 3ph) |

---

## 6. Image sourcing

### Site reliability

skymsen.com is **unreliable to automated access** - pages 404 or hang intermittently,
including URLs that worked earlier in the same session. A browser is more likely to succeed.
The `uploads/produtos/folders/*.pdf` paths are consistently reliable; if a product page will
not open, go straight to the PDF.

Confirmed dead at time of writing (both 404, in EN and ES):

- CFI-300L-N: `/en/index.php/produtos/detalhe/496049`
- MAXICONV: `/en/index.php/produtos/detalhe/685291` and `/es/.../674834`

**Verified working reseller fallbacks for those two:**

- Slicer → [evandroshop.com.br](https://www.evandroshop.com.br/portateis-industriais/fatiador-de-frios/fatiador-de-frios-300mm-400w-semi-automatico-inox-cfi-300l-n-220v-skymsen) - two studio shots, white background
- Maxiconv → [igorsolucoes.com](https://www.igorsolucoes.com/forno-eletrico-turbo-maxiconv-sem-vapor-skymsen) - four angles including a **background-removed cutout**, open-door and tray detail

### Best sources, ranked

1. **Official spec-sheet PDFs** (`folders/*.pdf`) - print-quality renders on white/light grey.
   Image-based, so text will not extract, but the artwork lifts cleanly.
2. **Official product detail pages** - 710024 and 472727 carry 7+ clean white-background
   images each; 704270 (PA-7) has 20+; 609781 (Discovery 10) has 16.
3. **US Skyfood resellers** - katom.com, kitchenall.com. Same machines, good photography,
   but **check for visible Skyfood branding** in frame before use.

### Extras

- Full English export catalogue (5.8 MB, all products):
  <https://www.skymsen.com/uploads/produtos/catalogo/catalogo-arquivo_en.pdf>
- Discovery 10 interactive 3D model - screenshot from any angle:
  <https://app.vectary.com/p/3hwWNee1LluLzDhGjCXKOK>
- LAR family manual (covers 2–10 L): <https://www.skymsen.com/manuais/414484.pdf>
- CMP-range slicer manual: <https://www.skymsen.com/manuais_visualizacao/574074.pdf>
- BMS-3-N product video: <https://www.youtube.com/watch?v=y8pKtbLrd_c>

### Known blocks

403 to automated fetching but fine in a browser: `loja.skymsen.com`, `katom.com`,
`kitchenall.com`, `magazineluiza.com.br`, `restaurantsupply.com`.
`skymseneuropa.com` returned empty responses on every attempt.

---

## 7. Accessory disc images - PA-7 cutting discs (July 2026)

The 7 archived `IMS/MEC/*` discs/blades noted in §"Covers" above as line items were
subsequently researched for images. **They are not on the current PA-7 PRO product page**
(704270) - that page lists a different/updated accessory set (KC5V, GC10 PRO, W3, KC8),
so these 7 codes likely belong to an older PA-7 generation or a standalone accessory
catalogue. The authoritative source turned out to be **skyfood.us** (Skymsen's US export
brand, same manufacturer photography) - `skyfood.us/products.php?familia=5` lists all
seven.

**Correction:** H3/EH3 is a **julienne** disc (3×3 mm strips), not a grater as the code
naming suggests.

| SKU | Catalogue name | Code | Identification | Product page(s) | Image URL |
|---|---|---|---|---|---|
| IMS/MEC/00270 | Disc Cube | GC16 | Dicing disc, 16 mm cube grid | [Restaurant Stock](https://restaurantstock.com/products/skyfood-gc16-5-8-16-mm-dicing), [Kitchenall](https://www.kitchenall.com/skyfood-gc16-dicing-disc-5-8-16-mm.html), [JES](https://www.jesrestaurantequipment.com/Skyfood-GC16--Dicing-Disc-1116in-for-Skymsen-MASTER-models_p_53075.html) | <https://restaurantstock.com/cdn/shop/products/0_252F4_252F7_252F2_252F04726f437e0c20a7bbe098319208d30160f62ccc_GC16_1024x.jpg> |
| IMS/MEC/00271 | Disc Z8 | Z8 | Grater/shredding disc, 8 mm | [skyfood.us](https://www.skyfood.us/products.php?familia=5), [Kitchenall](https://www.kitchenall.com/skyfood-z8-shredding-disc-5-16-8-mm.html) | <https://www.skyfood.us/photos/PC0720.JPG> |
| IMS/MEC/00272 | Disc Z5 | Z5 | Grater/shredding disc, 5 mm | [skyfood.us](https://www.skyfood.us/products.php?familia=5), [Kitchenall](https://www.kitchenall.com/skyfood-z5-shredding-disc-3-16-5-mm.html) | <https://www.skyfood.us/photos/PC0721.JPG> |
| IMS/MEC/00273 | Disc W4 | W4 | Wave/scallop-cut slicing disc, 4 mm | [Restaurant Stock](https://restaurantstock.com/products/skyfood-w4-5-32-4-mm-scallop-cut), [Kitchenall](https://www.kitchenall.com/skyfood-w4-scallop-cut-5-32-4-mm.html), [Culinary Depot](https://www.culinarydepotinc.com/skyfood-w4-0-16-scallop-cut-for-use-with-master-sky/) | <https://restaurantstock.com/cdn/shop/products/6_252Ff_252F8_252Fd_252F6f8d4511a85fbca2218ef8b989527e08df301938_W4_616d89a3-782a-4a63-a6a0-25fc2858e08f_1024x.jpg> |
| IMS/MEC/00274 | Disc H3 | H3/EH3 | **Julienne** disc, 3×3 mm (not a grater) | [skyfood.us](https://www.skyfood.us/products.php?familia=5), [KaTom](https://www.katom.com/248-H3.html) | <https://www.skyfood.us/photos/PC0725.JPG> |
| IMS/MEC/02131 | Disc -E3 | E3 | Slicing disc, 3 mm | [skyfood.us](https://www.skyfood.us/products.php?familia=5), [KaTom](https://www.katom.com/248-E3.html), [JES](https://www.jesrestaurantequipment.com/skyfood-e3.html) | <https://www.skyfood.us/photos/PC0730.JPG> |
| IMS/MEC/02319 | Slicer Disc - 14MM | 14MM (mfr code **E14**) | Slicer disc, 14 mm | [skyfood.us](https://www.skyfood.us/products.php?familia=5), [GoFoodservice](https://www.gofoodservice.com/p/skyfood-e14) | <https://www.skyfood.us/photos/PC0709.JPG> |

Notes: the `skyfood.us/photos/PC0xxx.JPG` files are manufacturer studio photos, white
background, verified live. GC16 and W4 aren't hosted on skyfood.us directly - their
images come from Restaurant Stock's Shopify CDN (`_1024x.jpg` variants available),
same product, but check for reseller branding/watermarks before use. Several reseller
product-detail pages (katom.com, jesrestaurantequipment.com, gofoodservice.com individual
listings) 403 to automated fetching - fine in a browser if higher-res or alternate angles
are needed.

### 7.1 Full descriptions and technical specs (July 2026)

Following the image pass, all 7 discs were researched to the same depth as the machine
records - description, meta_description and technical_specification - and written into
`products.json`, matching the catalogue's established content pattern (prose + `Key
Features` list + HTML spec table).

Confirmed/sourced per disc:

| SKU | Code | Cut type & size | Disc diameter | Weight | Compatible machines (as sourced) |
|---|---|---|---|---|---|
| IMS/MEC/00270 | GC16 | Cube dicing grid, 16×16 mm | - | ~0.51 kg | **Unresolved - see caveat below** |
| IMS/MEC/00271 | Z8 | Grating, 8 mm | ~204 mm | 0.70 kg net / 0.80 kg gross | Skymsen PA-7 / PA7 PRO |
| IMS/MEC/00272 | Z5 | Grating, 5 mm | ~205 mm | 0.68 kg net / 0.75 kg gross | Skymsen PA-7 / PA7 PRO |
| IMS/MEC/00273 | W4 | Scallop (wave) slicing, 4 mm | ~205 mm | 0.86 kg net / 0.93 kg gross | PA-7, PA-7SE-N, PA-7LE-N, PAIE-N, PAIE-S-N |
| IMS/MEC/00274 | H3/EH3 | Julienne, 3×3 mm | 203 mm | 0.85 kg net / 0.95 kg gross | Skymsen PA-7 / PA7 PRO |
| IMS/MEC/02131 | E3 | Slicing, 3 mm, non-stick coated | ~204 mm | 0.80 kg net / 0.90 kg gross | Skymsen PA-7 / PA7 PRO |
| IMS/MEC/02319 | 14MM (mfr code **E14**) | Slicing, 14 mm; pairs with a 14×14mm cube grid | ~203–205 mm | ~0.89–0.90 kg (sources disagree slightly) | PA-7, PA-7 PRO, PAIE-N, PAIE-S-N |

Sources for the spec pass, beyond the image sources above: `skymsen.com` official part
pages (094340 for H3 - directly fetched, confirms "DIÂMETRO 203mm" and "Corte Julienne de
3mm"; 096130 for Z8; others via search-engine cache when direct fetch was blocked -
096121 Z5, 096091 W4, `loja.skymsen.com/produto/096059` E3, `loja.skymsen.com/produto/676470`
E14), `maquinbal.com.br` (E14 material + compatibility).

**Open flag - GC16 (IMS/MEC/00270):** every independent English-language source found
(Kitchenall, JES Restaurant Equipment, RestaurantStock) ties the code "GC16" to the
Skymsen/Skyfood **MASTER series**, not the PA-7 - no source names GC16 and PA-7 together.
The nearest official match on skymsen.com is "GC16-S," tied to the **PAIE-S-N** machine,
and even that listing disagrees with a reseller on cube size (16 mm vs 12×12 mm). The
description written avoids naming a specific machine to not overstate confidence. **This
SKU may be miscoded in the catalogue** - worth a second look, since the PA-7's own record
lists IMS/MEC/00270 in its `accessories` array.

**Open flag - PA-7's own copy vs. its actual disc set:** the PA-7 record's existing
description/technical_specification (written earlier, unrelated to this pass) says the
included set is "slicers 1 and 3 mm, graters 3, 5 and 8 mm, fine grater, 7×7 mm julienne."
The 7 SKUs actually linked in its `accessories` array are GC16 (16 mm cube), Z8 (8 mm
grate), Z5 (5 mm grate), W4 (4 mm scallop-slice), H3 (3×3 mm julienne), E3 (3 mm slice),
and 14MM/E14 (14 mm slice) - a different set (no 1 mm slicer, no 7×7 julienne, has a cube
grid and a 4 mm scallop disc instead). Not corrected here since it touches the PA-7's own
record, not just the discs - flagging for a decision on which description is accurate.

---

## 8. Range gaps

Models found during research that are not currently in the catalogue, if the range is
worth filling:

- **DB-06** - 6 kg potato peeler, below the DB-10
- **LAR-06MB** - 6 L blender, between the 4 L and 8 L
- **LAR-15LMB / LAR-15PMB** - 15 L tilting blenders, below the 25 L
- **LI2** - 2 L bar blender with a genuine **stainless steel** cup (the BM2 alternative)
- **BMS-P** - wall-mounted single-spindle milkshake mixer
- **ESB-N** - 0.25 HP entry-level citrus juicer, below the ESB SUPER-N
- **LAR-xx-HD** - heavy-duty variants across the blender line, for thick/pasty products

---

## Image sourcing completion (July 2026)

Second pass. Goal was to close the remaining image gaps and replace the sub-standard
600x600 web renders with print-quality art extracted from Skymsen's own folder PDFs.

**Method that produced almost everything below:** Skymsen's `uploads/produtos/folders/*.pdf`
files are print-ready Illustrator documents. The studio renders are embedded as full-resolution
objects, so PyMuPDF embedded-object extraction (`page.get_images()` + `doc.extract_image()`)
recovers them at native size - between 2x and 3x the resolution of the same render served on
the website. Every render carrying transparency had to be recomposited against its soft mask
(the `smask` xref) before saving; extracting without the mask produces black speckle.

Resolution floor is 800 px on the long edge. Files below it are suffixed `-TOOSMALL` and kept
only where the ceiling is proven; those cases are stated explicitly.

### Sources used

- https://www.skymsen.com/uploads/produtos/folders/585033.pdf
- https://www.skymsen.com/uploads/produtos/folders/661805.pdf
- https://www.skymsen.com/index.php/produtos/detalhe/585033
- https://www.kitchenall.com/media/sitemap/sitemap_products_product.xml
- https://www.kitchenall.com/skyfood-e14-14mm-slicing-disc-for-use-with-master-sky-pa-7-pa-7-pro-models.html
- https://www.kitchenall.com/media/catalog/product/s/k/skyfood-e14_xlarge_n6lhknf7ftbkfrbs.jpg
- https://www.evandroshop.com.br/portateis-industriais/fatiador-de-frios/fatiador-de-frios-300mm-400w-semi-automatico-inox-cfi-300l-n-220v-skymsen
- https://www.refrisol.com.br/centrifuga-de-sucos-cse-220v-skymsen/p
- http://www.dak.com.br/index.php/produtos/1/cortadores-de-legumes
- http://www.dak.com.br/index.php/produtos/9/navalhas-e-machos
- http://www.dak.com.br/index.php/produtos/8/espremedores-de-pure
- http://www.dak.com.br/index.php/detalhe-produto/5/cortador-de-legumes-grande

### What PDF extraction gained over the web renders

| SKU | Model | Web render was | PDF render is | Gain |
|---|---|---|---|---|
| IMG/FPR/00246 | DB-10 | *(none - only an AI scene)* | 1849x1849 | new |
| IMG/FPR/00051 | SFL-282HD | 600x600 | 1659x1659 | 2.8x |
| IMG/FPR/00042 | PA7 PRO | 600x600 | 1497x1497 | 2.5x |
| IMG/FPR/00215 | CFI-300L-N | *(page 404)* | 1269x1267 | new |
| IMG/OVE/00214 | DISCOVERY 10 | 600x600 | 1205x1636 | 2.7x |
| IMG/OVE/00215 | MAXICONV | *(page 404)* | 1174x1174 | new |
| IMG/ICE/00020 | BMS-3-N | *(page 404)* | 1048x1069 | new |
| IMG/FPR/00038 | LAR-25LMB | *(nothing usable)* | 972x1458 | new |
| IMG/FPR/00169 | BM2 | *(page 404)* | 524x1270 | new |
| IMG/ICE/00019 | BMS-N | *(zero candidates)* | 485x894 | new |
| IMG/FPR/00048 | DB-25HD | *(only an AI scene)* | 517x815 | new |
| IMG/FPR/00214 | ESB SUPER-N | *(only an AI scene)* | 667x909 | new |

### Per-file record

All PDF-render files below were extracted from the manufacturer folder PDF already staged
alongside them as `<SKU>__spec-sheet.pdf`; the two new spec sheets are cited individually.

**IMG/FPR/00042 - PA7 PRO (catalogue model_number `PA-7`)**
- `IMG-FPR-00042__PA7-PRO__pdf-render-front-right.png` - 1497x1497, 628 KB - from
  `IMG-FPR-00042__spec-sheet.pdf`. Confirmed: front-right studio render on white, Skymsen
  branding on both the body and the discharge chute, rocker + reset switches, cast feet.
  **This is the PA7 PRO, not the legacy PA-7** - the PDF's own model column reads `PA7 PRO`
  and its disc pages are headed "available for the PA7 PRO".
- `IMG-FPR-00042__PA7-PRO__left-three-quarter-web-TOOSMALL.png` - 600x600, 144 KB - from
  https://www.skymsen.com . Left three-quarter view. Ceiling for skymsen.com web renders is
  600x600; the PDF supplies only the front-right angle, so this is kept for the second angle.
- `IMG-FPR-00042__PA7-PRO__feed-hopper-assembly-web-TOOSMALL.png` - 600x600, 142 KB - feed
  hopper and lid assembly, detached. Component view, no PDF equivalent.
- `IMG-FPR-00042__PA7-PRO__round-hopper-lid-web-TOOSMALL.png` - 600x600, 204 KB - round
  hopper/lid fitted to the machine.

**IMG/FPR/00051 - SFL-282HD (catalogue model_number `SI-282HD`)**
- `IMG-FPR-00051__SFL-282HD__pdf-render-front-right.png` - 1659x1659, 408 KB. Confirmed:
  full band saw on splayed stainless legs, control box with e-stop top left, blade visible,
  movable table with fence, Skymsen logo on the upper wheel housing.
- Nine 600x600 web renders retained with `-TOOSMALL` (front, front-right, left and right
  three-quarter, and five detail crops: table + fence, height-adjust knob, table lock,
  pusher open x2, blade). All from https://www.skymsen.com , ceiling 600x600. Retained
  because the PDF supplies only one angle and no detail crops.
- **Naming note:** Skymsen calls this machine **SFL-282HD** throughout its own spec sheet
  (`SFL-282HD / SFL-295HD / SFL-315HD`) and its web render filenames. Our stored
  model_number is `SI-282HD`. Not changed - flagging for a decision.

**IMG/FPR/00246 - DB-10**
- `IMG-FPR-00246__DB-10__pdf-render-front.png` - 1849x1849, 334 KB. Confirmed: stainless
  drum peeler, hinged top band, discharge chute right, numbered 0-7 timer dial, two cast
  feet. Matches the PDF's own "POTATO PEELER, WITH DOOR AND TIMER, STAINLESS STEEL, 10 kg".
- `IMG-FPR-00246__DB-10__pdf-render-door-open-with-chute.png` - 879x879, 183 KB. Second
  angle, door open, chute extended.

**IMG/FPR/00048 - DB-25HD**
- `IMG-FPR-00048__DB-25HD__pdf-render-front-right-with-abrasive-disc.png` - 517x815, 193 KB.
  Long edge 815 px, above the floor. Confirmed: taller three-leg drum, black lid, hinged
  door with warning plate and tap, abrasive disc leaning against the base.
- `IMG-FPR-00048__DB-25HD__detail-abrasive-disc__pdf-render-TOOSMALL.png` - 610x343, 151 KB.
  The carborundum abrasive disc alone. Component detail; nothing larger exists in the PDF.

**IMG/FPR/00038 - LAR-25LMB (catalogue model_number `LAR 25MB`)**
- `IMG-FPR-00038__LAR-25LMB__pdf-render-front-decal-legible.png` - 972x1458, 453 KB.
  **Decisive on the model question.** The decal on the cup is legible at this resolution and
  reads `SEAMLESS CUP / VASO MONOBLOQUE / NO WELDING / SIN SOLDADURAS / LAR-25LMB / PATENTED`.
  So LAR-25LMB is the machine with the tilting seamless cup **and** the stainless floor stand
  - it has both, not one or the other.
- `IMG-FPR-00038__REF__LAR-15LMB-NOT-LAR-25LMB__pdf-render.png` - 746x1119, 227 KB. Same
  render family, decal reads `LAR-15LMB`. Kept as documented near-miss, not for use.
- **Confirms the standing caveat: there is no `LAR-25MB`.** Our stored model_number
  `LAR 25MB` does not exist in Skymsen's range. Not changed here.

**IMG/FPR/00169 - BM2**
- `IMG-FPR-00169__BM2__pdf-render-maxi-blender-front.png` - 524x1270, 413 KB. Long edge
  1270 px. Confirmed: black base badged `MAXI BLENDER` with a `3 HP MOTOR` roundel, Tritan
  jug marked to 2 L, BPA FREE plate, rotary speed dial + two rockers. The PDF's own text
  block ties `BM2` to "LIQUIDIFICADOR MAXI BLENDER, COPO TRITAN".
- `IMG-FPR-00169__REF__BS2-supreme-blender-NOT-BM2__pdf-render.png` - 576x1397, 468 KB.
  Red base badged `SUPREME BLENDER` with pre-programmed LOW/MED/HIGH and 35"/60"/90" pads -
  that is the **BS2**, the sibling on the same sheet. Kept as a documented near-miss.

**IMG/FPR/00214 - ESB SUPER-N**
- `IMG-FPR-00214__ESB-SUPER-N__pdf-render-with-cones-decal-legible.png` - 667x909, 416 KB.
  Long edge 909 px. Confirmed: stainless body, twin black clamp bands, black spout, black
  base, supplied with strainer cup and two reaming cones. Decal reads `SUPER 0,5 CV HP`.
- `IMG-FPR-00214__REF__ESB-N-NOT-SUPER__pdf-render.png` - 667x909, 394 KB. Identical body
  **without** the SUPER decal - the 0.25 HP `ESB-N`. Documented near-miss.

**IMG/FPR/00215 - CFI-300L-N**
- `IMG-FPR-00215__CFI-300L-N__pdf-render-front-right.png` - 1269x1267, 493 KB. Confirmed:
  300 mm blade, metal blade cover, thickness dial, manual carriage with foam handle, rocker
  switch, Skymsen on the plinth twice.
- `IMG-FPR-00215__CFI-300L-N__evandroshop-alt-build-with-estop.jpg` - 1200x1200, 77 KB -
  https://www.evandroshop.com.br/portateis-industriais/fatiador-de-frios/fatiador-de-frios-300mm-400w-semi-automatico-inox-cfi-300l-n-220v-skymsen
  **Different build of the same model.** This photo has a red mushroom e-stop, red/green
  pushbuttons and a transparent plastic blade guard, where the PDF render has a plain rocker
  and a metal guard. Verified as the same model anyway: the companion dimension drawing on
  that listing reads 44 cm / 56 cm / 57 cm, which is an exact match for the spec sheet's
  `440 x 560 x 570 mm`. Treat as an alternate/older production build, not a different machine.

**IMG/ICE/00019 - BMS-N**
- `IMG-ICE-00019__BMS-N__pdf-render-front.png` - 485x894, 208 KB. Long edge 894 px.
  Confirmed: single spindle, spherical grey motor housing with black equator band, stainless
  cup in a wire yoke, tapered column on a textured splash base. Countertop, not wall.
- `IMG-ICE-00019__BMS-N__pdf-render-side.png` - 485x894, 194 KB. Side elevation of the same.
- `IMG-ICE-00019__REF__BMS-P-WALL-MOUNTED-NOT-BMS-N__pdf-render.png` - 730x1117, 143 KB.
  Same head on a **wall bracket** - that is the `BMS-P`. Documented near-miss.

**IMG/ICE/00020 - BMS-3-N**
- `IMG-ICE-00020__BMS-3-N__pdf-render-front-three-spindle.png` - 1048x1069, 398 KB.
  Confirmed: three spherical heads, three stainless cups, clover-shaped splash base. The
  three-spindle count is what distinguishes BMS-3-N from BMS-N.

**IMG/OVE/00215 - MAXICONV**
- `IMG-OVE-00215__spec-sheet.pdf` - 1707 KB -
  https://www.skymsen.com/uploads/produtos/folders/661805.pdf (covers `MAXICONV SV` and
  `MAXICONV VP`). Newly located; the official product page still 404s.
- `IMG-OVE-00215__MAXICONV__pdf-render-door-open.png` - 1174x1174, 383 KB. Confirmed:
  4-rack compact convection oven, glass door open, control column badged `MAXI CONV` with
  Skymsen logo, temperature 180 and timer 20 on the displays.
- `IMG-OVE-00215__MAXICONV__pdf-render-door-open-and-removable-rack.png` - 1096x531, 211 KB.
  Oven plus the removable rack shown separately.
- **The igorsolucoes images were rejected.** Its 1000x1000 files are OpenCart upscales, not
  masters: the source at
  https://www.igorsolucoes.com/image/Produtos/Forno%20Turbo/forno%20maxiconv.JPG is only
  433x357, and the Laplacian variance of the 1000x1000 cache is 164 against 926 for the
  433 px master - the signature of interpolation. Ceiling for that site is 433 px, so it is
  beaten outright by the 1174 px PDF render.
- **SV vs VP:** the spec sheet covers both; they are visually identical and differ only by
  the steam function. The reseller listing our catalogue was built from is the *sem vapor*
  version, i.e. **MAXICONV SV**. Worth confirming with the supplier which we sell.

**IMG/OVE/00214 - DISCOVERY 10** (not previously in the gap list, was uncovered)
- `IMG-OVE-00214__spec-sheet.pdf` - 1605 KB -
  https://www.skymsen.com/uploads/produtos/folders/585033.pdf
- `IMG-OVE-00214__DISCOVERY-10__pdf-render-loaded-badge-legible.png` - 1205x1636, 591 KB.
  Confirmed: full-height 10-tray bakery convection oven on castors, control column badged
  `DISCOVERY 10`, glass door showing ten loaded trays.
- **Housekeeping:** the sibling staging folder `skymsen-discovery-images\` (left untouched,
  as instructed) already holds `IMG-OVE-00214__discovery-10-front.png` and
  `-angle.png` at 600x600 plus the same two spec sheets. The 1205x1636 render staged here
  supersedes both at 2.7x. Worth consolidating the two folders when the images are placed.

**IMG/FPR/00040 - CSE**
- `IMG-FPR-00040__CSE__refrisol-front-with-juice-cup-and-pulp-bin.png` - 1000x1000, 714 KB -
  https://www.refrisol.com.br/centrifuga-de-sucos-cse-220v-skymsen/p . Confirmed: white
  cast-aluminium centrifugal extractor, feed tube, curved pulp chute, stainless drum with
  Skymsen decal, red/green buttons, supplied with juice cup and stainless pulp bin. Clean
  white background, no watermark on this frame. Cross-checked against the manufacturer PDF
  render - identical geometry.
- `IMG-FPR-00040__CSE__refrisol-close-up-WATERMARKED.png` - 1000x1000, 904 KB. Same product
  closer. **Carries a faint REFRISOL watermark and a Portuguese caption strip.**
- `IMG-FPR-00040__CSE__pdf-render-front-TOOSMALL.png` - 352x493, 68 KB. Manufacturer render,
  well below the floor; kept only as the branding-neutral cross-check that validated the
  reseller photo. The CSE folder PDF contains nothing larger.

**IMS/MEC/02319 - E14 (catalogue model_number `14MM`)**
- `IMS-MEC-02319__E14-slicing-disc-kitchenall.jpg` - 1000x1000, 152 KB -
  https://www.kitchenall.com/media/catalog/product/s/k/skyfood-e14_xlarge_n6lhknf7ftbkfrbs.jpg
  Confirmed: identical framing to the 350x350 skyfood.us thumbnail it replaces - same blade
  angle, same two screw positions, same hub. Superseded file deleted.
- **The earlier "E14 is absent from kitchenall" conclusion was wrong,** and the reason is
  worth recording: kitchenall runs **two parallel url-key families** for these discs. The
  bare-code family (`skyfood-e10-slicing-disc-3-8-10-mm`) really does stop at E10, but a
  second descriptive family carries the rest -
  `skyfood-e14-14mm-slicing-disc-for-use-with-master-sky-pa-7-pa-7-pro-models`. Guessing
  url-keys will never find these; enumerate
  https://www.kitchenall.com/media/sitemap/sitemap_products_product.xml instead (declared in
  robots.txt, ~6 MB). Note also that the Magento image filename does **not** match the
  url-key for this family - it is `skyfood-e14_xlarge_<hash>.jpg`, so the product page has to
  be read to recover it.
- E14 is confirmed current: page 2 of the PA7 PRO folder lists `E14 - 14 mm` in the slicer
  range and pairs it with the GC14 PRO and GC20 PRO dicing grids.

**GROUP/BLENDER-KITCHEN-SS - LAR-03MB**
- `GROUP-BLENDER-KITCHEN-SS__LAR-03MB__front-web-TOOSMALL.png` - 600x600, 120 KB -
  https://www.skymsen.com . Genuine LAR-03MB, decal legible enough to read `LAR-03MB`.
- `GROUP-BLENDER-KITCHEN-SS__LAR-03MB__pdf-render-decal-legible-TOOSMALL.png` - 281x691,
  92 KB. Decal reads `SEAMLESS CUP / VASO MONOBLOQUE / LAR-03MB / PATENTED` crisply. The
  group sheet renders all six machines (LAR-02/03/04/06/08/10MB) side by side, so each is
  small; 281 px is the ceiling inside that PDF.
- `GROUP-BLENDER-KITCHEN-SS__REF__LAR-10MB-NOT-LAR-03MB__pdf-render-TOOSMALL.png` -
  368x794. The largest render on the sheet, decal reads `LAR-10MB`. Documented near-miss.
- **Five staged files were the wrong product.** `0002`, `0007`, `0008`, `0010` and `0011`
  (600x600, from skymsen.com) are not blenders at all - they show a cylindrical drum machine
  with a black clamp band and a black side spout, i.e. the ESB juicer body, photographed from
  five angles. Renamed `REF__NOT-LAR-03MB-drum-machine-*` rather than deleted so the
  mis-attachment stays on the record.
- **Ceiling for LAR-03MB is 600 px and I could not beat it.** The best reseller candidate,
  https://www.narcel.com.br/liquidificador-comercial-skymsen-03l-ls03mb-n-inox/p , serves a
  2000x2000 VTEX file that is an upscale of a 223x413 master, and its decal reads `LS3`
  anyway - the Brazilian domestic `LS-03MB-N`, which per the standing `-N` caveat is a
  different machine from the export LAR-03MB. Rejected on both counts.

**IMG/FPR/00050, IMS/MEC/00309, IMS/MEC/00312 - the DAK trio**

DAK is Metalurgica DAK of Canoas, Rio Grande do Sul, unrelated to Skymsen. Its own site is
http://www.dak.com.br (plain HTTP only - the certificate on the HTTPS port belongs to the
hosting provider, so HTTPS fails). Full-resolution images come from its resize endpoint,
which caps rather than upscales: `_files/view.php/resize/2000x2000/produto/<hash>.png`.

- `IMG-FPR-00050__REF__DAK-cortador-de-legumes-grande-chipper-on-tripod.png` - 928x2000,
  889 KB - http://www.dak.com.br/index.php/detalhe-produto/5/cortador-de-legumes-grande
  Confirmed: lever-operated chipper on a black hammertone tripod, white nylon pusher block
  above a square steel cutting grid.
- `IMG-FPR-00050__REF__DAK-cortador-de-legumes-grande-with-output.png` - 827x1417, 625 KB.
  Same machine with dishes of cut output.
- `IMG-FPR-00050__REF__DAK-espremedor-de-pure-grande-masher-on-tripod.png` - 866x2000,
  725 KB - http://www.dak.com.br/index.php/produtos/8/espremedores-de-pure
  The competing candidate: same tripod and lever, but a **perforated round stainless basket**
  instead of a cutting grid - a masher/ricer, not a chipper.
- `IMS-MEC-00309__REF__DAK-macho-male-block-left-and-navalha-right.png` and
  `IMS-MEC-00312__REF__DAK-navalha-female-grid-right-and-macho-left.png` - both 1299x827,
  861 KB - http://www.dak.com.br/index.php/produtos/9/navalhas-e-machos
  One image showing both parts: on the left the white nylon **macho** (male pusher block with
  raised squares), on the right the steel **navalha** (female knife grid in a cast frame).
  Staged under both SKUs because a single frame documents both. DAK sells this set for the
  Medio/Grande/Parede cutters.

**The masher-vs-chipper question is now sharper, and still open.** DAK genuinely makes both
an *espremedor de pure* (masher) and a *cortador de legumes* (chipper), and **both sit on the
same tripod stand**, which is why the catalogue name alone cannot settle it. The evidence
points to the chipper:

1. DAK's own copy for the Grande cutter reads "Modelo que conta com pratico tripe e utiliza
   navalhas cambiaveis nos cortes de 6, 8, 10 e 12mm" - tripod stand, interchangeable blades
   in **6, 8, 10 and 12 mm**. Our `10MM` is one of exactly those four sizes.
2. The other two DAK SKUs are a 10 mm **macho** and a 10 mm **navalha** - the two consumable
   parts of the cutter. A masher has neither. The three SKUs form one coherent set:
   machine + its two replacement blades.
3. A masher has no "blades" and no millimetre cut size at all.

So `IMG/FPR/00050` is most likely the **DAK Cortador de Legumes Grande**, and "Potato Smasher
on Stand" is a naming error. Both candidates are staged as `REF__` so the supplier can point
at the right one. **Do not attach either to the live record until confirmed** - the two
machines look near-identical at thumbnail size, which is exactly how this error would have
been made in the first place.

### AI-generated imagery on skymsen.com - confirmed, and wider than reported

Three files were flagged for having filenames that are literal image-generation prompts. I
opened all three and judge them **generated, not photographic**, and therefore useless as
verification instruments. I then found **three more of the same family** that were not
flagged, plus one on the LAR group.

The decisive tell in every case is **corrupted text and branding** - the one thing a real
photograph never gets wrong - together with incoherent background objects and lighting that
does not correspond to the shadows.

All seven moved to `_brand-reference\` with an `-AI-GENERATED` suffix:

| File | Px | Judgement |
|---|---|---|
| `IMG-FPR-00051__SI-282HD__butchery-scene-AI-GENERATED.png` | 314x600 | Machine has **no blade**, no control-box detail, and a featureless slab body that does not match the SFL-282HD's tall wheel housing, fence or splayed legs. Hanging carcasses are anatomical mush; shelf stock is undifferentiated blobs. |
| `IMG-FPR-00051__SI-282HD__butchery-scene-2-AI-GENERATED.png` | 314x600 | Same scene, second sample. Same faults. |
| `IMG-FPR-00214__ESB-SUPER-N__counter-scene-AI-GENERATED.png` | 800x584 | Closest to plausible - the body was clearly conditioned on the real ESB SUPER - but the **Skymsen wordmark is deformed** and the SUPER decal is warped. Bottle labels are illegible, the strainer cup melts into the counter, fruit shadows do not match the fruit. |
| `IMG-FPR-00246__DB-10__kitchen-scene-AI-GENERATED.png` | 800x457 | Both chefs have blurred faces and one a malformed hand; tub lettering reads `OTTAGES`; peel waste is visibly cloned; the discharge chute geometry is wrong. |
| `IMG-FPR-00040__CSE__kitchen-scene-AI-GENERATED.png` | 600x600 | **Newly identified.** Generated kitchen - shelf items are blobs, the knife block is incoherent, the extractor's own geometry is soft and its decal unreadable. |
| `IMG-FPR-00048__DB-25HD__kitchen-scene-AI-GENERATED.png` | 600x600 | **Newly identified.** Generated kitchen - garbled packaging text on the shelves, cloned potatoes, unresolved control dial and door on the machine. |
| `GROUP-BLENDER-KITCHEN-SS__LAR-03MB__kitchen-scene-AI-GENERATED.jpg` | 800x533 | **Newly identified.** Generated depth-of-field kitchen, illegible background signage, the cup decal is a smudge. |

A useful secondary signal: these files are anomalously heavy for their pixel count - 716 KB
and 792 KB at 600x600, against 114-204 KB for genuine 600x600 renders from the same site.
Generative noise does not compress like a clean studio render. **Treat any skymsen.com image
whose file size is wildly out of line with its dimensions as suspect.**

Consequence: `IMG/FPR/00214`, `IMG/FPR/00246`, `IMG/FPR/00048` and `IMG/FPR/00040` had an
AI scene as their *only* staged image and were effectively uncovered. All four are now
covered from the folder PDFs (and, for the CSE, from Refrisol).

### Naming and model notes recorded, not applied

Per the standing rule, `model_number` was not touched. Recording for a later decision:

- `IMG/FPR/00038` stores `LAR 25MB`. **No such model exists.** The badge in the manufacturer
  render reads `LAR-25LMB`.
- `IMG/FPR/00051` stores `SI-282HD`. Skymsen's own spec sheet and asset filenames say
  `SFL-282HD`.
- `IMS/MEC/02319` stores `14MM`. The manufacturer/vendor code is `E14`.
- `IMG/FPR/00042` stores `PA-7`. Current production is `PA7 PRO`; all staged imagery is PRO.
  The PRO differs in disc combinations, teflonised disc finish, feed assembly and weight
  (27.9 kg per this sheet). PRO-only files are named `PA7-PRO` so nothing gets attached to a
  legacy PA-7 listing unexamined.
- Disc naming across vendors, unresolved: skyfood.us calls Z8/Z5/Z3 **grater** and W3/W4
  **ripple cut slicer**; restaurantstock.com calls the same parts "shredding" and "scallop
  cut"; the PA7 PRO folder itself labels Z as `GRATER`, W as `SCALLOP CUT` and H as
  `JULIENNE`. The H3 casting is embossed `H3-EH3` and the W4 casting `W3 - W4`, i.e. blanks
  are shared across sizes - consistent with our stored `H3/EH3`.

### Coverage across all 24 SKYMSEN-branded SKUs

Stated plainly. "Exact model" means an image where the specific model was positively
identified - by a legible badge or decal, by a distinguishing feature count, or by the
manufacturer spec sheet the render was extracted from.

**Exact-model image at or above the 800 px floor - 14**

| SKU | Model | Best file | Px |
|---|---|---|---|
| IMG/FPR/00042 | PA7 PRO | pdf-render-front-right | 1497x1497 |
| IMG/FPR/00051 | SFL-282HD | pdf-render-front-right | 1659x1659 |
| IMG/FPR/00246 | DB-10 | pdf-render-front | 1849x1849 |
| IMG/FPR/00048 | DB-25HD | pdf-render-front-right | 517x815 |
| IMG/FPR/00038 | LAR-25LMB | pdf-render-front (decal legible) | 972x1458 |
| IMG/FPR/00214 | ESB SUPER-N | pdf-render-with-cones (decal legible) | 667x909 |
| IMG/FPR/00215 | CFI-300L-N | pdf-render-front-right | 1269x1267 |
| IMG/FPR/00040 | CSE | refrisol-front-with-accessories | 1000x1000 |
| IMG/ICE/00019 | BMS-N | pdf-render-front | 485x894 |
| IMG/ICE/00020 | BMS-3-N | pdf-render-front-three-spindle | 1048x1069 |
| IMG/OVE/00215 | MAXICONV | pdf-render-door-open | 1174x1174 |
| IMG/OVE/00214 | DISCOVERY 10 | pdf-render-loaded (badge legible) | 1205x1636 |
| IMS/MEC/02319 | E14 | kitchenall | 1000x1000 |
| IMG/FPR/00169 | BM2 | pdf-render-maxi-blender-front | 524x1270 |

Three of these are portrait crops that clear the floor on the long edge but not on both axes
- BM2 at 524x1270, BMS-N at 485x894 and DB-25HD at 517x815. They pass the rule as written
(800 px on the long edge) and are the manufacturer's own full-height renders, so there is no
larger framing to recover.

**Exact-model image, already done in the first pass - 6**

IMS/MEC/00270 (GC16), IMS/MEC/00271 (Z8), IMS/MEC/00272 (Z5), IMS/MEC/00273 (W4),
IMS/MEC/00274 (H3), IMS/MEC/02131 (E3) - all 1000x1000 from kitchenall. Untouched.

**Exact-model image but below the floor, ceiling proven - 1**

- GROUP/BLENDER-KITCHEN-SS - **LAR-03MB** - 600x600 web / 281x691 PDF. Genuinely capped.
  Ceiling proven twice: skymsen.com serves 600x600, and the group spec sheet renders six
  machines side by side so no single one exceeds 368 px. The one reseller alternative is an
  upscale of a 223 px master and is the wrong (domestic `LS3`) variant.

**Representative / REF only, no confirmed image of our exact unit - 3**

- IMG/FPR/00050 - **DAK** - two candidate machines staged, both `REF__`, both above the
  floor. Blocked on the masher-vs-chipper supplier question above.
- IMS/MEC/00309 - **DAK male blade 10 mm** - `REF__` at 1299x827. The frame shows DAK's macho
  and navalha for the Medio/Grande/Parede range; it is not proven to be the 10 mm size
  specifically, since DAK photographs the set rather than each size.
- IMS/MEC/00312 - **DAK female blade 10 mm** - same frame, same caveat.

**Nothing at all - 0**

Every SKU now has at least one visually verified image staged.

Two deliberate abstentions are worth stating as *outcomes, not gaps*: the three DAK SKUs are
marked `REF__` rather than being given a confident image, and seven AI-generated scenes were
demoted to `_brand-reference` rather than being left in place as product photography. In both
cases attaching the available picture would have been worse than attaching nothing - the DAK
masher and chipper are indistinguishable at thumbnail size, and the AI scenes are exactly the
kind of asset that would have silently propagated a wrong product into the catalogue.

### _brand-reference contents

Non-product and non-photographic material, kept for reference and deliberately out of the
product-image pool: the seven AI scenes above; the PA-7 dimension drawing and both exploded
views (web 600x600 and PDF 1011x1011); the PA7 PRO disc/grid range chart and dice-kit
combination chart, rasterised at 200 dpi from pages 2-3 of the folder PDF (1654x2339 each -
these are the reference for which discs and grids pair legally, including the "do not use a
slicer disc larger than a dicing grid" rule); the CFI-300L-N dimension drawing from
evandroshop; the CSE dimension/spec and annotated-feature graphics from Refrisol (both
watermarked); the MAXICONV perforated baking-tray accessory; and the LAR-range seamless-cup
component render.

### Site notes for the next pass

- **kitchenall.com** exposes `https://www.kitchenall.com/media/sitemap/sitemap_products_product.xml`
  (declared in robots.txt). Enumerate it rather than guessing url-keys - that is what found
  E14 after eleven guesses all 404'd. Product-page HTML fetches fine with a browser UA.
- **Check for upscaling before trusting a large file.** Both igorsolucoes (OpenCart) and
  narcel (VTEX) serve arbitrarily large derivatives of small masters. Laplacian variance
  against the declared master is a quick, reliable test; a 5x drop means interpolation.
- **loja.skymsen.com** still 403s to automated fetching, but
  `https://www.skymsen.com/index.php/produtos/detalhe/<id>` works and exposes the folder PDF
  path directly - the reliable way in when a product's friendly URL 404s.
- **dak.com.br** is HTTP-only (HTTPS presents the host's certificate). Its
  `_files/view.php/resize/<w>x<h>/produto/<hash>.png` endpoint caps at the master rather than
  upscaling, so requesting 2000x2000 safely returns native size.
