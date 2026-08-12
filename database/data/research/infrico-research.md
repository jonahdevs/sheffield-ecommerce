# Infrico Product Research

Research notes behind an INFRICO enrichment/audit pass on `products.json` (July 2026).
Covers the single INFRICO SKU in the catalogue: `IMG/DIS/00062` — "Ice Static Display Case
Infrico VBZ12", `model_number` `VBZ12S`, an Ibiza-series static ice-cream display case.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema/Blueline/Santos passes before a scope decision.

Unlike the Blueline pass, this one verifies cleanly: Infrico is a real, large, well
documented Spanish manufacturer that publishes full PDF datasheets, and the exact model
family was found on their own current site, in their own current general catalogue, and in
their own USA data sheet. The open question is not _what the specs are_ — it is **which of
two real sibling models we are actually selling** (§3).

---

## 1. Brand identification — `website_url` is empty and should be filled

**Infrico** = **Grupo Infrico** (Infrico S.L.), a Spanish commercial-refrigeration
manufacturer based in **Lucena, Córdoba, Spain**. Address and contacts printed on their own
ice-cream brochure back page: _Ctra. de Aguilar a A-318 por Moriles, km 15,5 - A-3132,
CP 14900 LUCENA, Córdoba - España, Tel +34 957 51 30 68, info@infrico.com_.

`brands.json` currently has `slug: infrico`, `name: Infrico`, `description: "INFRICO"`,
`logo: brands/infrico.jpg`, **`website_url: null`**.

**Recommended `website_url`: `https://infrico.com`** (verified HTTP 200; English entry
point `https://infrico.com/en/` also 200).

Other live Infrico properties, for reference only — the global `.com` site is the right one
for a Kenyan catalogue:

https://infrico.com
https://infrico.com/en/
https://infrico.us
https://infrico.mx
https://infricodocuments.com

The `description` field is also just the string `"INFRICO"` (the brand name repeated), which
is the same placeholder pattern seen on several other `brands.json` rows. Worth replacing
with real copy at some point, but out of scope here.

---

## 2. Where this SKU sits in Infrico's range

Infrico's ice-cream (gelato) display cases are three series, all in one brochure:

| Series    | Code  | Glass                            | Cooling        | Note                         |
| --------- | ----- | -------------------------------- | -------------- | ---------------------------- |
| **Coral** | `VCB` | straight, heated, tilting        | **Ventilated** | 5 L trays, 14-20 trays       |
| **Aries** | `VAR` | curved, heated, hinged           | **Ventilated** | 5 L trays, 14-20 trays       |
| **Ibiza** | `VBZ` | **flat tempered heated, hinged** | **Static**     | 7-13 trays on **two levels** |

Our SKU is **Ibiza / VBZ**, and the record's name ("Ice **Static** Display Case") is
**correct** — Ibiza is the only static-cooled series of the three. Cooling type verified.

Official series page and brochure:

https://infrico.com/en/product-category/pastry-display-cases-en/ibiza-en/ice-cream-display-case-en-2-ibiza/
https://infricodocuments.com/infrico/pdf/vitrinas-helados-EN.pdf
https://infricodocuments.com/infrico/catalogue/es/11-VITRINA-PASTELERIA-VBZ-IBIZA.pdf

⚠ **Read Infrico's datasheets with the `Read` tool, not WebFetch.** WebFetch returns "you
must be registered to view the complete documentation" for `infrico.com/en/product/...`
pages and extracts nothing usable from the PDFs. The PDFs themselves are public and
unauthenticated — `curl` them down and `Read` them. Every hard number in this document came
out of the PDFs that way.

---

## 3. ⚠ VBZ12 vs VBZ12S — the headline finding

The record's `name` says **VBZ12**; its `model_number` says **VBZ12S**. **Both are real
Infrico codes for two different, currently-sold machines.** This is not a typo like the
Blueline `VRX1500/80` case — it is a genuine model ambiguity, and it has to be settled by
the supplier, not by the web.

### 3.1 What the `S` suffix actually means

It is **not** glass type, **not** static-vs-ventilated cooling, and **not** finish. All four
Ibiza models have the same flat tempered heated hinged glass, all four are static, and the
colour is a free RAL choice on every one of them.

**`S` = the reduced-depth / single-row variant.** Infrico's own general catalogue proves it
in the "tray combinations" row, which names the base codes explicitly:

> `VBZ12 (501X32) x 10 uds.` · `VBZ15 (501X32) x 13 uds.`
> `VBZ12S (501X32) x 7 uds.` · `VBZ15S (501X32) x 9 uds.`

So `VBZ12` holds **10 trays per level**, `VBZ12S` holds **7**. The `U` on the current model
names (`VBZ 12U`, `VBZ 12 SU`) is a generation marker carried by _all four_, so
`VBZ12` → `VBZ12U` and `VBZ12S` → `VBZ12SU`.

Infrico's own Ibiza spec table (general catalogue p.481, and the ice-cream brochure p.12):

|                       | **VBZ 12U** (`VBZ12`) | **VBZ 15U**       | **VBZ 12 SU** (`VBZ12S`) | **VBZ 15 SU**     |
| --------------------- | --------------------- | ----------------- | ------------------------ | ----------------- |
| Measurements (mm)     | **1310 × 920 × 1350** | 1622 × 920 × 1350 | **1310 × 670 × 1350**    | 1622 × 670 × 1350 |
| Capacity (L)          | **289**               | 361               | **210**                  | 263               |
| Display surface (m²)  | **0,94**              | 1,41              | **0,50**                 | 0,63              |
| Compressor (HP)       | **1**                 | 1                 | **3/4**                  | 3/4               |
| Trays                 | **10+10**             | 13+13             | **7+7**                  | 9+9               |
| Power (W)             | **480**               | 484               | **432**                  | 436               |
| Consumption (kWh/24h) | **11,5**              | 13,6              | **9,9**                  | 11,5              |

Everything else is common to all four: −15 °C/−18 °C, climatic class **7 / 35 °C**,
**230V/1ph/50Hz**, digital controller, plasticized galvanised steel exterior with **AISI 304
exposure plane**, 40 kg/m³ CFC-free zero-ODP/GWP insulation, side panels 30+30 mm included,
**static cooling**, **hot-gas defrost**, **ventilated evaporation**, **R-290**, standard
castors.

Visual confirmation from Infrico's own renders (downloaded, §7): the `VBZ12U` render shows a
**deep well with two rows** of trays (front row plus a raised rear grid); the `VBZ12SU`
render shows a **single row of 7 tubs**. The two machines are obviously different depths.

Independent corroboration of the same S = smaller relationship on the US side, where the
previous generation was sold as plain `IDC-VBZ12` / `IDC-VBZ12S`:

- `IDC-VBZ12` — 10 ft³ (≈283 L), **8 × 3-litre tubs**, $7,957
- `IDC-VBZ12S` — 7.41 ft³ (**≈210 L — matches the EU VBZ12SU's 210 L exactly**),
  **4 × 3-litre tubs**, $6,672

https://ices.cool/products/infrico-idc-vbz12-display-case-ice-cream
https://ices.cool/products/infrico-idc-vbz12s-display-case-ice-cream

**One dissenting source.** The Spanish reseller tophosteleria lists a "VBZ12S" with
`1310 × 920 × 1345 mm`, `10+10 cubetas`, `289 L`, `445 W`, `R452` — i.e. the **deep**
machine's figures under the **S** code. That contradicts Infrico's own tray-combination
legend and their own renders, and the same page also calls the 1622 mm deep unit "VBZ15S".
Treat it as a reseller labelling error, but it is worth knowing that the mislabelling exists
in the wild — it is a plausible route by which an `S` got onto our record.
https://www.tophosteleria.com/es/heladeria/1983-8799-vitrina-de-helados-infrico-serie-ibiza-10-o-13-cubetas.html

### 3.2 Which one is our record actually describing? The **non-S**.

Every substantive figure in our own record points at the **deep, 10-tray VBZ12 / VBZ12U**,
not at the `VBZ12S` its `model_number` claims:

| Our stored value    | VBZ12 / VBZ12U                                    | VBZ12S / VBZ12SU |
| ------------------- | ------------------------------------------------- | ---------------- |
| depth **920 mm**    | **920 ✓**                                         | 670 ✗            |
| **"10 x … trays"**  | **10 per level ✓**                                | 7 per level ✗    |
| length 1250 mm      | **1250 ✓** (Infrico USA's own stated width, §4.1) | 1250 (same)      |
| height 1345 mm      | 1350 ≈ ✓                                          | 1350 ≈ ✓         |
| gross volume 260 L  | 289 ✗                                             | 210 ✗            |
| `name` says "VBZ12" | **✓**                                             | ✗                |

Two of the three discriminating fields (depth, tray count) match the non-S unambiguously,
and the third (volume) matches neither.

**Verdict: `VBZ12` (current code `VBZ12U`) is the model our record describes; the `S` in
`model_number` looks wrong.** Sheffield's own live product page is itself undecided — its
URL slug literally carries both codes:
`.../ice-static-display-case-infrico-vbz12-**vbz12s**`.

**Not changed here.** `model_number` is the catalogue's unique ID
([[feedback_model_number_unique_id]]) and this needs explicit approval plus, ideally, one
line of confirmation from the supplier ("is the machine 920 mm or 670 mm deep?" settles it
instantly — that is a 250 mm difference anyone can measure). The two candidate corrections
are `VBZ12S` → `VBZ12` (legacy code, matches the `name`) or → `VBZ12U` (current code).

⚠ **Commercial consequence, not just data hygiene.** The two machines differ by **79 litres
of capacity and 6 trays**, and by roughly $1,300 at US list. Selling one and shipping the
other is a real dispute. This is the single most important thing in this document.

---

## 4. Field-by-field audit of `IMG/DIS/00062`

Comparison is against **VBZ12U** (the model the record describes, §3.2). Where the VBZ12SU
figure differs materially it is given in brackets.

| Field             | Stored                            | Infrico official                                                                               | Verdict                           |
| ----------------- | --------------------------------- | ---------------------------------------------------------------------------------------------- | --------------------------------- |
| `length`          | 1250                              | **1250** (body) / 1310 (with side panels)                                                      | ✓ correct — see §4.1              |
| `width` (= depth) | 920                               | **920** [SU: 670]                                                                              | ✓ correct, and confirms the non-S |
| `height`          | 1345                              | **1350**                                                                                       | ✓ within 5 mm                     |
| Temperature       | **−14 to −16 °C**                 | **−15 °C / −18 °C**                                                                            | ✗ **wrong**                       |
| Climate class     | **4**                             | **7 / 35 °C**                                                                                  | ✗ **wrong**                       |
| Gross volume      | **260 L**                         | **289 L** [SU: 210 L]                                                                          | ✗ matches no Infrico figure       |
| Trays             | "10 x 1/3GN trays"                | **10+10 = 20 trays**, 5 L gelato tubs 360×165×150 mm                                           | ⚠ half-right, see §4.2            |
| Voltage/frequency | 220-240 V / 50 Hz                 | **230V/1ph/50Hz**                                                                              | ✓ correct for Kenya (§5)          |
| Refrigerant       | **R404a**                         | **R-290** (current); R452A (prior gen)                                                         | ⚠ generation-dependent (§4.3)     |
| Cooling system    | "static"                          | **Static**                                                                                     | ✓ correct                         |
| Defrost           | "Type of Defrost static" / "Auto" | **Hot gas, automatic**; final defrost temp control 8 °C                                        | ✗ **wrong** — see §4.4            |
| Glass             | "Tempered glass"                  | Flat **tempered, heated, hinged/tilting** front glass                                          | ✓ but incomplete                  |
| Work surface      | "AISI 304 stainless steel"        | Exposure plane **AISI 304**; worktop white compac quartz; cabinet plasticized galvanised steel | ⚠ partly right, see §4.5          |
| Controller        | "Thermometer"                     | **Digital controller** (Dixell, visible in the official detail render)                         | ⚠ understated                     |
| Power             | _not stored_                      | **480 W** [SU: 432 W]                                                                          | ➕ missing                        |
| Consumption       | _not stored_                      | **11,5 kWh/24h** [SU: 9,9]                                                                     | ➕ missing                        |
| Compressor        | _not stored_                      | **1 HP** [SU: 3/4 HP]                                                                          | ➕ missing                        |
| Weight            | _not stored_                      | **298 lb ≈ 135 kg** [SU: 278 lb ≈ 126 kg]                                                      | ➕ missing                        |
| Display surface   | _not stored_                      | **0,94 m²** [SU: 0,50 m²]                                                                      | ➕ missing                        |
| Insulation        | _not stored_                      | 40 kg/m³, CFC-free, zero ODP-GWP                                                               | ➕ missing                        |
| LED lighting      | _not stored_                      | LED "visera" lighting, 80-90% energy saving vs conventional                                    | ➕ missing                        |
| Castors           | _not stored_                      | **Standard castors** fitted                                                                    | ➕ missing                        |
| Side panels       | _not stored_                      | 30 + 30 mm, **included**                                                                       | ➕ missing                        |
| Night cover       | _not stored_                      | Available (shown in the USA catalogue)                                                         | ➕ optional                       |

### 4.1 The 1250 vs 1310 length — both are right, and our 1250 is defensible

Infrico's EU table says **1310 mm**; Infrico **USA**'s own data sheet and catalogue both say
the length is **49-1/5 in = 1250 mm**. The gap is exactly the two 30 mm side panels
(1250 + 30 + 30 = 1310). So **1250 mm is the cabinet body and 1310 mm is the installed width
with the glass side panels fitted**. (The EU brochure's English column header reads
"MEASUREMENTS WITHOUT SIDES" against the 1310 figure, which cannot be right given the
arithmetic — the Spanish original just says "Medidas". Treat the English header as a
mistranslation.)

Our stored `1250` is therefore _not_ an error, but it is the smaller of the two and a buyer
planning a counter run needs the 1310. Worth stating both in the spec table.

### 4.2 "10 x 1/3GN trays" — two problems

1. **The count understates the machine.** VBZ12U is **10+10 = 20 trays** on two levels
   (front row plus raised rear grid). "10" is the per-level count. Infrico's own reseller
   copy sells it as "20 cubetas".
   https://hosteleria10.com/maquinaria/vitrinas-de-helados/infrico-vitrina-ibiza-vbz.html
2. **They are not GN 1/3 pans.** Infrico's gelato trays are **5-litre tubs, 360 × 165 ×
   150 mm** (Infrico USA states the same pan as 14-1/4 × 6-1/2 in = 362 × 165 mm standard,
   with 14-1/4 × 10 in = 362 × 254 mm optional). A GN 1/3 is 325 × 176 mm — a different pan.
   The "1/3 GN" wording is wrong and would mislead anyone trying to reuse existing pans.

### 4.3 R404a — plausible for an older unit, wrong for anything shipping now

Three refrigerant generations exist against these codes, and they line up with the code
generations:

| Generation  | Codes                                                 | Refrigerant              | Evidence                                                                                                                                                           |
| ----------- | ----------------------------------------------------- | ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Oldest      | `VBZ12` / `VBZ12S`, US `IDC-VBZ12` / `IDC-VBZ12S`     | **R404A**                | ices.cool product pages (both explicitly R404A, 115V/60Hz)                                                                                                         |
| Middle      | `VBZ12S` (as sold in ES)                              | **R452A**, 445 W, 3/8 HP | tophosteleria                                                                                                                                                      |
| **Current** | `VBZ12U` / `VBZ12SU`, US `IDC-VBZ12U` / `IDC-VBZ12SU` | **R-290** (propane)      | Infrico general catalogue p.481, ice-cream brochure p.12, Infrico USA data sheet `DTULN23020` (14/12/2023), Infrico USA Food Service Equipment '24 catalogue p.102 |

Our stored **R404a** is genuinely consistent with the **oldest** generation and with the bare
`VBZ12`/`VBZ12S` code shape we store — so it is not obviously invented. But R404A has a GWP
of 3922 and is being phased down under the EU F-Gas regulation; **nothing Infrico ships
today is R404A**. If the supplier is quoting current stock, the correct figure is **R-290**.
Do not publish R404A without confirming, and note that R290 is a selling point (natural
refrigerant, zero ODP, GWP 3) that the current copy throws away.

### 4.4 The defrost/cooling fields are conflated

The record says _"Type of Defrost static"_ in one place and _"Defrost Type: Auto"_ in
another. Neither is right:

- **Cooling system: static** (correct, and what makes this an Ibiza)
- **Defrost: hot gas**, automatic, with **8 °C final-defrost temperature control**
- **Evaporation: ventilated**
- **Condensation: ventilated**

"Static" describes the _cooling_, not the _defrost_. Three separate specs have been collapsed
into one wrong line.

### 4.5 Materials

The record's "Work surface in AISI 304 stainless steel" is right about the **exposure
plane/display deck** but implies a stainless cabinet. Infrico's own material row reads
_"Acero plastificado / Plastified galvanised steel"_ for the body with _"Plano exposición:
Inox Aisi 304"_ for the display plane, and the Ibiza features page specifies a **white compac
quartz worktop**. The exterior is a lacquered RAL colour of the buyer's choice (18 standard
RAL/design colours listed; white RAL 9016 is the default).

---

## 5. Kenya electrical check — ✓ passes

Stored `220-240 V / 50 Hz` is **correct for Kenya**. Infrico's EU spec is **230V / 1ph /
50 Hz** across the whole Ibiza range, so the stored range covers it.

This is the good case, unlike some brands in this catalogue: **the record does not carry a
foreign-market figure.** It would be easy to get this wrong here, because Infrico USA sells
the identical cabinets at **115V / 1ph / 60 Hz** with a **NEMA 5-20P** plug and quotes
amperage (8.75 A for VBZ12U at 115 V) rather than watts — and the ices.cool listing that
matches our `VBZ12S` string is explicitly a 115 V unit. **Do not let any US figure (115 V,
60 Hz, amps, cu ft, inches, lb, °F) leak into this record**; use the EU brochure numbers,
which are the ones that apply to a machine landed in Nairobi.

Climate class is the other market-fit spec worth publishing: Infrico rates the Ibiza at
**climatic class 7 / 35 °C ambient**, which is comfortably adequate for Kenyan conditions.
The record's stored "Climate Class 4" understates it and is wrong.

---

## 6. Axis / dimension-order check — ✓ no swap on this SKU

Stored `length: 1250, width: 920, height: 1345`. The real machine is
**1250 mm wide × 920 mm deep × 1345-1350 mm high**.

- `length` 1250 = width ✓
- `width` 920 = depth ✓
- `height` 1345 = height ✓

**No axis swap here**, and the prose `technical_specification` ("Dimensions:
1250X920X1345mm") agrees with the numeric fields — the one thing on this record that is
internally consistent. This again confirms (as in the Brema §3.4 and Blueline §6.4 passes)
that the swap bug has to be checked per-SKU rather than assumed.

One thing the numeric fields cannot express: the height varies with the glass. Infrico's
dimensional drawing shows **1350 mm closed** and **1381 mm with the front glass tilted open**
for the SU section, so an installer needs ~1.4 m of clearance. Worth a line in the copy.

---

## 7. Product reference

| SKU           | Catalogue name                        | Stored model                                              | Real Infrico model                                                                                                               | Official source                                                                                                                                                                                     | Confidence                                                                      |
| ------------- | ------------------------------------- | --------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------- |
| IMG/DIS/00062 | Ice Static Display Case Infrico VBZ12 | ⚠ `VBZ12S` (record content describes the **non-S**, §3.2) | **VBZ 12U** (legacy `VBZ12`) — 1310/1250 × 920 × 1350, 289 L, 10+10 trays, 480 W, 1 HP, R290, static, hot-gas defrost, 230V/50Hz | https://infricodocuments.com/infrico/pdf/vitrinas-helados-EN.pdf · https://infricodocuments.com/infrico/catalogue/es/11-VITRINA-PASTELERIA-VBZ-IBIZA.pdf · https://infrico.com/en/product/vbz-12-u/ | **High** on the spec of both candidate models · **Medium** on which one we sell |
| —             | (sibling, if the `S` is right)        | `VBZ12S`                                                  | **VBZ 12 SU** — 1310/1250 × 670 × 1350, 210 L, 7+7 trays, 432 W, 3/4 HP, R290                                                    | https://infrico.com/en/product/vbz-12-su/                                                                                                                                                           | **High**                                                                        |

All sources verified HTTP 200 at time of writing, with one exception:
`sheffieldafrica.com` returns **403 to `curl`** (bot protection) but loads fine in a browser
and via WebFetch — not a dead link.

Primary sources used:

https://infrico.com
https://infrico.com/en/product-category/pastry-display-cases-en/ibiza-en/ice-cream-display-case-en-2-ibiza/
https://infrico.com/en/product/vbz-12-u/
https://infrico.com/en/product/vbz-12-su/
https://infricodocuments.com/infrico/pdf/vitrinas-helados-EN.pdf
https://infricodocuments.com/infrico/catalogue/es/11-VITRINA-PASTELERIA-VBZ-IBIZA.pdf
https://infricodocuments.com/infrico-usa/spec_sheet/VBZ_UL_GI.pdf
https://infricodocuments.com/infrico-usa/catalog/VAR-VCB-VBZ-GELATO-SERIES.pdf
https://infrico.us/product/idc-vbz12su/
https://infrico.us/purchase/pastry-and-gelato-display-cases/gelato-ice-cream/
https://hosteleria10.com/maquinaria/vitrinas-de-helados/infrico-vitrina-ibiza-vbz.html
https://www.coolvi.es/vitrina-frio-estatico-serie-ibiza-helado-vbz-infrico/
https://www.tophosteleria.com/es/heladeria/1983-8799-vitrina-de-helados-infrico-serie-ibiza-10-o-13-cubetas.html
https://ices.cool/products/infrico-idc-vbz12-display-case-ice-cream
https://ices.cool/products/infrico-idc-vbz12s-display-case-ice-cream
https://sheffieldafrica.com/kitchen/product/670/ice-static-display-case-infrico-vbz12-vbz12s

---

## 8. Image sourcing (July 2026) — downloaded to `Downloads/infrico-images/`

**10 files**, all pulled straight from Infrico's own servers (`infrico.com`, `infrico.us`)
via `curl` — no auth or referer needed — plus one losslessly extracted from Infrico's own
brochure PDF with `pypdf`. Full-size originals only; no thumbnail suffixes were accepted.
Every file was opened and visually verified.

| File                                               | Model shown                                                                                        | Pixels    | Size   | Source                                                                               |
| -------------------------------------------------- | -------------------------------------------------------------------------------------------------- | --------- | ------ | ------------------------------------------------------------------------------------ |
| `IMG-DIS-00062__VBZ12U-official-render.jpg`        | **VBZ12U** — deep cabinet, **two rows of trays** visible, white RAL 9016                           | 1500×1500 | 182 KB | https://infrico.com/wp-content/uploads/2023/10/VBZ12U.jpg                            |
| `IMG-DIS-00062__VBZ12SU-official-render.jpg`       | VBZ12SU — shallow, **single row of 7 tubs**, RAL 3020 red                                          | 1500×1500 | 168 KB | https://infrico.com/wp-content/uploads/2026/05/VBZ12SU.jpg                           |
| `IMG-DIS-00062__VBZ12SU-view1.jpg`                 | VBZ12SU straight-on front elevation, RAL 1001 beige, empty well                                    | 1500×1500 | 125 KB | https://infrico.com/wp-content/uploads/2026/07/VBZ12SU-1.jpg                         |
| `IMG-DIS-00062__VBZ12SU-view2.jpg`                 | VBZ12SU **side elevation** — shows the glass-open geometry and castors                             | 1500×1500 | 39 KB  | https://infrico.com/wp-content/uploads/2026/07/VBZ12SU-2.jpg                         |
| `IMG-DIS-00062__VBZ12SU-view3.jpg`                 | VBZ12SU three-quarter, **7 tubs filled with gelato** — best sales shot of the S                    | 1500×1500 | 144 KB | https://infrico.com/wp-content/uploads/2026/07/VBZ12SU-3.jpg                         |
| `IMG-DIS-00062__VBZ12SU-view5.jpg`                 | VBZ12SU rear three-quarter, empty stainless pans + rear grid                                       | 1500×1500 | 151 KB | https://infrico.com/wp-content/uploads/2026/07/VBZ12SU-5.jpg                         |
| `IMG-DIS-00062__VBZ12SU-view6.jpg`                 | **Detail crop of the Dixell digital controller** reading −18 °C                                    | 1500×1500 | 65 KB  | https://infrico.com/wp-content/uploads/2026/07/VBZ12SU-6.jpg                         |
| `REF__VBZ15SU-ral1018-yellow-infrico-official.jpg` | **VBZ15SU**, not our model — 1622 mm, 9 tubs. Family/colour reference only                         | 1200×1200 | 242 KB | https://infrico.com/wp-content/uploads/2023/02/VBZ15-S-Ral-1018-Amarillo-1.jpg       |
| `REF__IDC-VBZ15SU-us-render.jpg`                   | **IDC-VBZ15SU**, not our model — 9 tubs, white. Reference only                                     | 1500×1500 | 326 KB | https://infrico.us/wp-content/uploads/2025/01/IDC-VBZ15SU.jpg                        |
| `REF__VBZ-U-and-SU-dimension-drawings.jpg`         | **Dimension drawings** for VBZ SU and VBZ U cross-sections, extracted from p.13 of the EN brochure | 1240×1754 | 146 KB | https://infricodocuments.com/infrico/pdf/vitrinas-helados-EN.pdf (p.13, via `pypdf`) |

Notes for whoever adopts these:

- **Only one official render of the VBZ12U exists.** Infrico's site carries a single
  1500×1500 render for the deep model (reused on the `vbz-12-u`, `vbz-12-su` and `vbz-15-u`
  pages alike) and the identical file is served from `infrico.us`. The rich multi-angle set
  Infrico published in 2026 is for the **SU** only. If the SKU resolves to the **non-S**
  (§3.2), there is exactly one usable photo and the rest of the gallery would have to come
  from the supplier.
- **The renders are the discriminator.** `VBZ12U-official-render` vs
  `VBZ12SU-official-render` side by side show the two-row deep well against the single-row
  shallow well. Anyone confirming the model with the supplier should just send these two.
- **All Infrico-branded.** Every render carries a small "Infrico" badge on the front panel.
  Since Infrico is the _actual_ manufacturer here (unlike the Blueline pass), that is
  correct branding, not a competitor logo to retouch.
- **`REF__` files are deliberately mismatched models** — 1622 mm 15-series units and a
  drawings page. Kept as references for the dimension drawings and the RAL colour options,
  renamed rather than deleted per the pass convention.
- **The dimension-drawings file is a brochure page, not a product photo.** Useful spec
  reference (it is the only place the 1381 mm glass-open height and the 690/920 depth
  breakdown appear) but not storefront material.
- **Not copied into `storage/app/public/products/` or referenced in `products.json`** —
  staged in `Downloads/infrico-images/` for review, same as the Brema/Blueline/Santos sets.
  `IMG/DIS/00062` already has an `image` value, so these are candidate replacements.

---

## 9. Recommended changes to `IMG/DIS/00062` — in priority order

Nothing below has been applied.

**Priority 1 — needs a decision / approval, not just an edit**

1. **⚠ Resolve `VBZ12S` vs `VBZ12`.** Ask the supplier one question: _is the cabinet 920 mm
   or 670 mm deep?_ 920 → the record's content is right and `model_number` should become
   `VBZ12` (or the current `VBZ12U`). 670 → `model_number` is right and **every content
   field below has to be rebuilt from the SU column** (210 L, 7+7 trays, 432 W, 3/4 HP), and
   the `name`, `slug` and `image` filename all need the `S` too. **Do not edit
   `model_number` without explicit approval** — it is the join key.
2. **Confirm the refrigerant generation.** R404A (what we store) is the oldest generation and
   is being phased out; current production is **R-290**. This changes both the spec table and
   the sales copy.

**Priority 2 — corrections that are wrong today regardless of which model it is**

3. **Temperature `−14 to −16 °C` → `−15 °C / −18 °C`.** Infrico's figure for all four Ibiza
   models.
4. **Climate class `4` → `7 / 35 °C`.** Understated today, and class 7 is a genuine selling
   point in Kenya.
5. **Fix the defrost/cooling conflation** (§4.4): cooling system **static**; defrost
   **hot gas, automatic**, 8 °C final-defrost control; evaporation and condensation
   **ventilated**.
6. **Drop "1/3 GN"** — the pans are **5-litre gelato tubs, 360 × 165 × 150 mm**
   (optional wider 362 × 254 mm). Nothing about this machine takes GN 1/3.
7. **Tray count `10` → `10+10 (20 trays)` on two levels** (or `7+7 (14)` if it turns out to
   be the SU).
8. **Gross volume `260 L`** matches no Infrico figure for either sibling (289 L / 210 L).
   Either correct it to 289 L or remove it pending the supplier's sheet — do not leave an
   unsourced number in the spec table.

**Priority 3 — additions (all sourced, all currently missing)**

9. Power **480 W**; consumption **11,5 kWh/24h**; compressor **1 HP**.
10. Net weight **≈135 kg** (298 lb, Infrico USA data sheet).
11. Display surface **0,94 m²**.
12. Installed width **1310 mm** with the 30+30 mm side panels fitted (body 1250 mm), and
    **1381 mm** clearance needed with the front glass tilted open.
13. Insulation **40 kg/m³, CFC-free, zero ODP/GWP**; **LED lighting** (80-90% saving);
    **castors standard**; **side panels included**; **digital (Dixell) controller** rather
    than "Thermometer"; **18 standard RAL/design exterior colours** to order.
14. Correct the materials line: **exposure plane AISI 304**, worktop white compac quartz,
    cabinet plasticized galvanised steel in a lacquered RAL colour.

**Priority 4 — housekeeping**

15. **`brands.json`: set `website_url` to `https://infrico.com`** (currently `null`).
16. `brands.json` `description` is the placeholder string `"INFRICO"` — replace with real
    copy (Spanish manufacturer, Lucena/Córdoba, Grupo Infrico) whenever the brand-page copy
    pass happens.
17. The record has **no `meta_description`** and its `description`/`technical_specification`
    are unformatted fragments rather than the prose + Key Features + `<table>` pattern used
    on the recently-restructured SKUs. Reformatting is safe and independent of the model
    question — but the _numbers_ inside it are not, so reformat and correct in the same pass,
    not before it.

---

## 10. Not resolved — stated plainly rather than guessed

- **Whether Sheffield sells the 920 mm-deep `VBZ12`/`VBZ12U` or the 670 mm-deep
  `VBZ12S`/`VBZ12SU`.** The record's own content says the former, its `model_number` says the
  latter, and Sheffield's live page URL says both. Only the supplier can settle it.
- **Which refrigerant generation is actually in stock** — R404A (oldest, what we store),
  R452A (middle), or R290 (current production).
- **Where "260 L" came from.** It matches no Infrico figure for any Ibiza model in any
  generation found (289 / 361 / 210 / 263 L). It may be an older-generation gross figure for
  which no datasheet survives online, or it may simply be wrong.
- **Infrico's own depth figures are internally inconsistent for the SU.** The spec table says
  `1310 × 670 × 1350`, but Infrico's own cross-section drawing labelled "VBZ SU" shows
  691 mm body / **920 mm overall** — the same 920 as the U. Resellers all repeat 670, and the
  renders clearly show a shallower cabinet, so 670 is probably the body depth measured
  without the tilted glass. Recorded rather than reconciled, because it does not affect the
  non-S figures our record uses.
