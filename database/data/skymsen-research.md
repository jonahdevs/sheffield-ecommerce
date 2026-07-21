# Skymsen Product Research

Research notes behind the Skymsen enrichment pass on `products.json` (July 2026). Data was
sourced from Skymsen's official export site and cross-checked against resellers.

Covers 20 machine SKUs. Seven further Skymsen entries are archived spare discs and blades
(`IMS/MEC/*`) which were left untouched — they are line items rather than catalogue products.

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
Useful as extra photo sources, but **never quote their specs** — they are 110–120 V / 60 Hz.

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

### Not published — do not invent

- No **kg/h throughput** figure exists for the CSE juicer (only rpm).
- No **noise level** is published for any LAR blender or the BM2.
- No **IP rating** is published for any model.
- Cup capacities are quoted as a single maximum figure; there is no separate
  "useful vs total" volume.

---

## 3. Corrections applied

| SKU | Product | Was | Now |
|---|---|---|---|
| IMG/FPR/00048 | Potato Peeler 25KG | 110 V / 60 Hz with 45 kg net | 220 V / 50 Hz — 45 kg is the **220 V** figure; the 110 V unit is 48 kg. The record mixed two variants. |
| IMG/FPR/00033–38 | LAR blenders (5 SKUs) | 3,500 rpm | 3,000 rpm at 50 Hz |
| IMG/FPR/00169 | Blender Bar 2 Litres | implied stainless cup | Cup is **Tritan polymer**; only the base is metal |
| IMG/FPR/00214 | Juice Extractor ESB Super N | "entry-level", "affordable" | It is the **uprated 0.5 HP** model. `ESB-N` is the entry model (0.25 HP) |
| IMG/FPR/00042 | Vegetable Processor PA7 | 0.25 HP, 300–400 kg/h, 6 discs | 0.5 HP, ~250 kg/h, **7 discs** |
| All Skymsen | — | dimensions in wrong axes | reordered from H×W×L |
| IMG/FPR/00048, 00246, 00050, 00105 | peelers + chipper | short description read *"SYSTEMATIC JSPCC-08 commercial potato chipper"* | Rewritten — copy-paste bug from an unrelated product |

---

## 4. Open questions for the supplier

These were **not** changed in `products.json`, because they need confirmation against
purchase paperwork.

### 4.1 DAK is a different manufacturer

`IMG/FPR/00050` (Potato Smasher on Stand) and the two chipper blades `IMS/MEC/00309` /
`IMS/MEC/00312` are filed under brand **SKYMSEN**, but **DAK is Metalúrgica DAK of Canoas,
Rio Grande do Sul** — an unrelated Brazilian manufacturer. Searching skymsen.com,
skyfood.us and skymseneuropa.com returns zero results for a model "DAK".

There is no manufacturer spec sheet, manual, EAN or HS data for DAK in English; all
sources are Brazilian retail listings.

Two further points on this SKU:

- The name says **"Potato Smasher"** but the 10 mm blades describe a **chipper**. DAK makes
  both a masher (*amassador*) and a chip cutter (*cortador de legumes*) — unrelated products
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
| LAR 25MB | **does not exist** — see below |

The `-N` suffix belongs to Skymsen's *Brazilian domestic* lines (`LS-xxMB-N`, `TA-xxMB-N`),
which are **different machines** — `LS` is explicitly a low-rotation blender for pastier
products. If supplier paperwork genuinely says `LS-04MB-N`, the specs written do not apply.

### 4.3 The 25 litre blender needs a model decision

There is no `LAR-25MB`. The 25 L machines are:

- **LAR-25LMB** — tilting, **with** stainless steel floor stand
- **LAR-25PMB** — tilting, seamless cup, **without** stand
- **LAR-25LMB-HD** — heavy-duty stand version

`products.json` was written for **LAR-25LMB** as the most likely match. Net weight is
inconsistent on Skymsen's own site (20.5 kg on the 50 Hz SKU vs 25.5 kg on the 60 Hz SKU for
identical dimensions) — the 20.5 kg looks like a data-entry error, so ~25.5 kg is published.

### 4.4 PA-7 vs PA-7 PRO

Current production is **PA-7 PRO**, which superseded the PA-7. The PRO adds cube-cutting
disc combinations, a teflonised disc finish and a redesigned feed assembly. Net weight
differs (27.8 kg PRO vs ~25.7 kg legacy). Catalogued as PA-7; switch if the supplier ships
the PRO.

### 4.5 MAXICONV is two SKUs

- **MAXICONV SV** — *sem vapor*, no steam
- **MAXICONV VP** — manual steam injection via a panel button

The catalogue entry is generic "MAXICONV". The VP is the more widely listed of the two.
Note max temperature is **210 °C** — do not copy generic "up to 300 °C" convection claims.

### 4.6 Discovery 10 tray size changes the dimensions

The 60 × 80 cm tray option changes depth (1,590 → 1,490 mm) and weight (326 → 250 kg).
Published figures assume 60 × 70 cm trays. At 20 kW, three-phase is mandatory.

---

## 5. Product reference

Official page and spec sheet per catalogue SKU. **The `folders/*.pdf` spec sheets are the
best image source** — print-quality Adobe Illustrator files with clean white-background
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
| IMG/FPR/00215 | Meat Slicer 300 | CFI-300L-N | ⚠ 404 — see §6 | [496049_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/496049_eng.pdf) |
| IMG/FPR/00051 | Bone Saw Free Standing | SI-282HD | [624063](https://www.skymsen.com/en/index.php/produtos/detalhe/624063) | [624063_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/624063_eng.pdf) |
| IMG/OVE/00215 | Oven Convection 4 Tray Maxiconv | MAXICONV | ⚠ 404 — see §6 | [661805.pdf](https://www.skymsen.com/uploads/produtos/folders/661805.pdf) |
| IMG/OVE/00214 | Oven Convection 10 Trays Discovery 10 | DISCOVERY 10 | [609781](https://www.skymsen.com/en/index.php/produtos/detalhe/609781) | [609781_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/609781_eng.pdf) |
| IMG/FPR/00050 | Potato Smasher on Stand | DAK | none — not a Skymsen product | none |

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

skymsen.com is **unreliable to automated access** — pages 404 or hang intermittently,
including URLs that worked earlier in the same session. A browser is more likely to succeed.
The `uploads/produtos/folders/*.pdf` paths are consistently reliable; if a product page will
not open, go straight to the PDF.

Confirmed dead at time of writing (both 404, in EN and ES):

- CFI-300L-N: `/en/index.php/produtos/detalhe/496049`
- MAXICONV: `/en/index.php/produtos/detalhe/685291` and `/es/.../674834`

**Verified working reseller fallbacks for those two:**

- Slicer → [evandroshop.com.br](https://www.evandroshop.com.br/portateis-industriais/fatiador-de-frios/fatiador-de-frios-300mm-400w-semi-automatico-inox-cfi-300l-n-220v-skymsen) — two studio shots, white background
- Maxiconv → [igorsolucoes.com](https://www.igorsolucoes.com/forno-eletrico-turbo-maxiconv-sem-vapor-skymsen) — four angles including a **background-removed cutout**, open-door and tray detail

### Best sources, ranked

1. **Official spec-sheet PDFs** (`folders/*.pdf`) — print-quality renders on white/light grey.
   Image-based, so text will not extract, but the artwork lifts cleanly.
2. **Official product detail pages** — 710024 and 472727 carry 7+ clean white-background
   images each; 704270 (PA-7) has 20+; 609781 (Discovery 10) has 16.
3. **US Skyfood resellers** — katom.com, kitchenall.com. Same machines, good photography,
   but **check for visible Skyfood branding** in frame before use.

### Extras

- Full English export catalogue (5.8 MB, all products):
  <https://www.skymsen.com/uploads/produtos/catalogo/catalogo-arquivo_en.pdf>
- Discovery 10 interactive 3D model — screenshot from any angle:
  <https://app.vectary.com/p/3hwWNee1LluLzDhGjCXKOK>
- LAR family manual (covers 2–10 L): <https://www.skymsen.com/manuais/414484.pdf>
- CMP-range slicer manual: <https://www.skymsen.com/manuais_visualizacao/574074.pdf>
- BMS-3-N product video: <https://www.youtube.com/watch?v=y8pKtbLrd_c>

### Known blocks

403 to automated fetching but fine in a browser: `loja.skymsen.com`, `katom.com`,
`kitchenall.com`, `magazineluiza.com.br`, `restaurantsupply.com`.
`skymseneuropa.com` returned empty responses on every attempt.

---

## 7. Accessory disc images — PA-7 cutting discs (July 2026)

The 7 archived `IMS/MEC/*` discs/blades noted in §"Covers" above as line items were
subsequently researched for images. **They are not on the current PA-7 PRO product page**
(704270) — that page lists a different/updated accessory set (KC5V, GC10 PRO, W3, KC8),
so these 7 codes likely belong to an older PA-7 generation or a standalone accessory
catalogue. The authoritative source turned out to be **skyfood.us** (Skymsen's US export
brand, same manufacturer photography) — `skyfood.us/products.php?familia=5` lists all
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
background, verified live. GC16 and W4 aren't hosted on skyfood.us directly — their
images come from Restaurant Stock's Shopify CDN (`_1024x.jpg` variants available),
same product, but check for reseller branding/watermarks before use. Several reseller
product-detail pages (katom.com, jesrestaurantequipment.com, gofoodservice.com individual
listings) 403 to automated fetching — fine in a browser if higher-res or alternate angles
are needed.

### 7.1 Full descriptions and technical specs (July 2026)

Following the image pass, all 7 discs were researched to the same depth as the machine
records — description, meta_description and technical_specification — and written into
`products.json`, matching the catalogue's established content pattern (prose + `Key
Features` list + HTML spec table).

Confirmed/sourced per disc:

| SKU | Code | Cut type & size | Disc diameter | Weight | Compatible machines (as sourced) |
|---|---|---|---|---|---|
| IMS/MEC/00270 | GC16 | Cube dicing grid, 16×16 mm | — | ~0.51 kg | **Unresolved — see caveat below** |
| IMS/MEC/00271 | Z8 | Grating, 8 mm | ~204 mm | 0.70 kg net / 0.80 kg gross | Skymsen PA-7 / PA7 PRO |
| IMS/MEC/00272 | Z5 | Grating, 5 mm | ~205 mm | 0.68 kg net / 0.75 kg gross | Skymsen PA-7 / PA7 PRO |
| IMS/MEC/00273 | W4 | Scallop (wave) slicing, 4 mm | ~205 mm | 0.86 kg net / 0.93 kg gross | PA-7, PA-7SE-N, PA-7LE-N, PAIE-N, PAIE-S-N |
| IMS/MEC/00274 | H3/EH3 | Julienne, 3×3 mm | 203 mm | 0.85 kg net / 0.95 kg gross | Skymsen PA-7 / PA7 PRO |
| IMS/MEC/02131 | E3 | Slicing, 3 mm, non-stick coated | ~204 mm | 0.80 kg net / 0.90 kg gross | Skymsen PA-7 / PA7 PRO |
| IMS/MEC/02319 | 14MM (mfr code **E14**) | Slicing, 14 mm; pairs with a 14×14mm cube grid | ~203–205 mm | ~0.89–0.90 kg (sources disagree slightly) | PA-7, PA-7 PRO, PAIE-N, PAIE-S-N |

Sources for the spec pass, beyond the image sources above: `skymsen.com` official part
pages (094340 for H3 — directly fetched, confirms "DIÂMETRO 203mm" and "Corte Julienne de
3mm"; 096130 for Z8; others via search-engine cache when direct fetch was blocked —
096121 Z5, 096091 W4, `loja.skymsen.com/produto/096059` E3, `loja.skymsen.com/produto/676470`
E14), `maquinbal.com.br` (E14 material + compatibility).

**Open flag — GC16 (IMS/MEC/00270):** every independent English-language source found
(Kitchenall, JES Restaurant Equipment, RestaurantStock) ties the code "GC16" to the
Skymsen/Skyfood **MASTER series**, not the PA-7 — no source names GC16 and PA-7 together.
The nearest official match on skymsen.com is "GC16-S," tied to the **PAIE-S-N** machine,
and even that listing disagrees with a reseller on cube size (16 mm vs 12×12 mm). The
description written avoids naming a specific machine to not overstate confidence. **This
SKU may be miscoded in the catalogue** — worth a second look, since the PA-7's own record
lists IMS/MEC/00270 in its `accessories` array.

**Open flag — PA-7's own copy vs. its actual disc set:** the PA-7 record's existing
description/technical_specification (written earlier, unrelated to this pass) says the
included set is "slicers 1 and 3 mm, graters 3, 5 and 8 mm, fine grater, 7×7 mm julienne."
The 7 SKUs actually linked in its `accessories` array are GC16 (16 mm cube), Z8 (8 mm
grate), Z5 (5 mm grate), W4 (4 mm scallop-slice), H3 (3×3 mm julienne), E3 (3 mm slice),
and 14MM/E14 (14 mm slice) — a different set (no 1 mm slicer, no 7×7 julienne, has a cube
grid and a 4 mm scallop disc instead). Not corrected here since it touches the PA-7's own
record, not just the discs — flagging for a decision on which description is accurate.

---

## 8. Range gaps

Models found during research that are not currently in the catalogue, if the range is
worth filling:

- **DB-06** — 6 kg potato peeler, below the DB-10
- **LAR-06MB** — 6 L blender, between the 4 L and 8 L
- **LAR-15LMB / LAR-15PMB** — 15 L tilting blenders, below the 25 L
- **LI2** — 2 L bar blender with a genuine **stainless steel** cup (the BM2 alternative)
- **BMS-P** — wall-mounted single-spindle milkshake mixer
- **ESB-N** — 0.25 HP entry-level citrus juicer, below the ESB SUPER-N
- **LAR-xx-HD** — heavy-duty variants across the blender line, for thick/pasty products
