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

## 7. Range gaps

Models found during research that are not currently in the catalogue, if the range is
worth filling:

- **DB-06** — 6 kg potato peeler, below the DB-10
- **LAR-06MB** — 6 L blender, between the 4 L and 8 L
- **LAR-15LMB / LAR-15PMB** — 15 L tilting blenders, below the 25 L
- **LI2** — 2 L bar blender with a genuine **stainless steel** cup (the BM2 alternative)
- **BMS-P** — wall-mounted single-spindle milkshake mixer
- **ESB-N** — 0.25 HP entry-level citrus juicer, below the ESB SUPER-N
- **LAR-xx-HD** — heavy-duty variants across the blender line, for thick/pasty products
