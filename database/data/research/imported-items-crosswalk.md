# Imported-Items Crosswalk — supplier records × `products.json`

Source workbook: **`database/data/IMPORTED ITEMS 2019 EARLY DEC REVIEW 2020.xlsx`**
(65.9 MB, supplied by the **imports team**, dated 2019 with a 2020 review pass; moved out of
`Downloads\` on 2026-09-02, where it arrived as `Copy of IMPORTED ITEMS 2019 EARLY DEC REVIEW 2020.xlsx`).

⭐ **The user has confirmed this workbook is FINAL** — it is the imports team's own record of
what Sheffield actually bought, from whom, at what price. Where it disagrees with
`products.json`, treat the workbook as correct unless a manufacturer source says otherwise.
This makes it the second authoritative internal record alongside the SAP export
(see `project_sap_source_of_truth` in memory); unlike SAP, **it names the supplier**.

**Nothing in this file has been applied to `products.json`.** Every table below is a proposal
awaiting approval.

Staged evidence photos: `Desktop\ecommerce\products resource\_imported-items-evidence\`
(228 files + `_manifest.json`). ⚠ See §F — these are **identification evidence, not shippable art**.

---

## 1. What the workbook is

**77 sheets, one per SUPPLIER** — not one per brand. That distinction is the whole value of the
file: `products.json` was scraped from our own website and never recorded who manufactured
anything, so for every Sheffield house label the maker was unknown. Here it is a sheet name.

Every sheet is a Sheffield quotation template with the same columns:

| Column | Meaning |
|---|---|
| Make | supplier's own brand string |
| Model No | **supplier's own article code** |
| Description(Name,Capacity,Rating,Optionals) | spec prose, semicolon-delimited |
| Overall Size(mm) | `W x D x H` as quoted by the supplier |
| Qty / Price Kshs / Amount Kshs | the commercial record |
| Remarks | free text |

Plus **2,201 anchored photographs** (1,257 unique images, 123 MB uncompressed), each pinned to
a product row — so every photo is tied to a specific supplier code.

**1,695 priced line items** carry a model number; **1,526 distinct codes**.

## 2. Method

1. Every sheet parsed by locating its `Make`/`Model No` header row (sheets start at different
   rows; three carry a full quotation letterhead above the table).
2. Codes normalised to `[A-Z0-9]` only, then joined to `products.json` — **including the 49
   child SKUs that live only inside `variants[]`**, which earlier tooling passes skipped
   (see `project_variant_children_gap`).
3. Photos mapped by reading each sheet's drawing part and resolving
   `xdr:from/xdr:row` → `r:embed` → `xl/media/*`. **218 of 222 matched products have a photo
   anchored on their exact row**, so the row→photo tie is reliable.
4. Matches tiered:
   - **Tier A (159)** — exact code match *and* the supplier sheet is consistent with the
     catalogue brand. Trustworthy.
   - **Tier B (55)** — code differs by a suffix or spacing only, sheet still consistent.
     Eyeball the join before acting.
   - **Tier C (8)** — either an exact code on an unexpected sheet (**two of these are findings,
     not errors** — see §A2) or a coincidental short-code collision (**four are false joins**,
     listed in §E3 so nobody re-derives them).

### Coverage

| Measure | Count |
|---|---|
| Catalogue entries (683 products + 49 variant children) | 732 |
| Matched to a supplier line item | **222** (30%) |
| …of which exact code match | 162 |
| …carrying a supplier photograph | 221 |
| Distinct supplier codes with **no** catalogue counterpart | 1,271 |
| Rows on the `CANCELLED IMPORTED ITEMS` sheet | 108 |

Against the All-Categories workbook's own `DATA STATUS` column (the five-bucket classification
in `project_sheet_findings_classification`):

| Bucket | SKUs | Now carrying supplier evidence |
|---|---|---|
| Sources disagree | 88 | **32** |
| No supplier data | 36 | **6** |
| Data on file, not yet listed | 3 | 1 |
| Our records only | 20 | **0** |

### What the workbook actually settles

217 usable matches, sorted by what they change:

| Outcome | SKUs |
|---|---|
| **Previously unresolved, now carrying supplier evidence** | **39** |
| Marked `Complete` and independently corroborated | 93 |
| ⚠ Marked `Complete` but **contradicted** by the imports record | **64** |
| Matched but with no `DATA STATUS` recorded (variant children etc.) | 21 |

⚠ **The workbook creates work as well as closing it.** Of the 64 contradictions, 36 are
dimension disagreements and 45 are `model_number` disagreements (some SKUs are both). These
were all previously believed finished.

Separately, **136 SKUs are unblocked without being matched**: they belong to a brand whose OEM
is now named (HK-REDLINE 56, SHEFFIELD BLUELINE 24, OEM SHEFFIELD 21, KITCHENWARE 16,
H-KITCHEN 10, STEELOLOGY 9), so ordinary web research against the real manufacturer can now
proceed on them. Those six labels cover 230 SKUs in total, 94 of which matched directly.

---

## A. ⭐⭐ Supplier identification — the main result

### A2. The house-brand chain, resolved

These are the joins web research could not make. Each names a real company to search on, which
is what the house-brand SKUs have been blocked on since the enrichment effort began.

| Our label | Real supplier (sheet) | Evidence |
|---|---|---|
| **OEM SHEFFIELD** (`JW-*` codes) | **GUANGZHOU**, make "Perfect" / "Guangzoh" | `JW-16`, `JW-25`, `JW-64B` appear verbatim. Confirms Guangdong Perfect / JIWINS — the `JW-` prefix is theirs (`project_oem_sheffield_jiwins`) |
| **OEM SHEFFIELD** (chafing dishes) | **HY** | `HY 902`, `HY 836`, `HY 834`; catalogue stores these as `HY-902` etc. |
| **OEM SHEFFIELD** (fryers) | **ELABORATEX** | `HEF-904` exact, on `IMG/HOT/00042` *and* `IMG/HOT/00427` |
| **OEM SHEFFIELD** (induction) | **KASSIDY** | `TC1` — ⚠ but Kassidy's own description calls it a **"Heating Pad"**, not an induction cooker |
| **KITCHENWARE** | **WANHUI** | `A6-650N-320` induction cooker |
| **HK-REDLINE** | **H KITCHEN** (majority) and **KASSIDY** | `BS-4V` and `EB-600` are Kassidy's, not H Kitchen's — the label spans two suppliers |
| **STEELOLOGY / GENEVA** `SSPC-*` | **H KITCHEN** | ⭐ resolves the open ⚠⚠ in `project_catalogue_enrichment_status`: all four of `SSPC-16/25/40/60` are H-Kitchen **"Timesaver Pressure Cooker"** units. The "Time Saver" badge on the stored `SSPC-25` photo was correct evidence, and neither STEELOLOGY nor GENEVA is the maker |
| **TUNGSTEN** | **H KITCHEN** | `XCW-160L` counter-top display cooler, exact code |
| **H-KITCHEN** (fryer bowls) | **BRAVO** | `DW938002` ↔ our `8002` |
| **SHEFFIELD BLUELINE** | **BLUELINE** sheet, make "SHEFFIELD BLUELINE" | in-house label confirmed; the sheet is the buying record |

⚠ **The `-G` suffix question is settled by §C and §D.** The Blueline sheet lists `GN1410TN` and
`GN1410TNG` as *separate line items* with the same overall size and the same photo, so `G` marks
the glass door, not a different cabinet. Our catalogue already names them apart; what it gets
wrong is the dimensions (§C1).

### A3. Full catalogue brand → supplier sheet map

| Catalogue brand | Supplier sheet(s) in the import file | SKUs |
|---|---|---|
| HK-REDLINE | **H KITCHEN** (43), **KASSIDYxx** (2) | 45 |
| SHEFFIELD BLUELINE | **BLUELINE** (23) | 23 |
| RATIONAL | **RATIONAL ACCESSORIES** (14), **XS RATIONAL ACCESSORIES** (9) | 23 |
| SKYMSEN | **SKYMSEN** (16) | 16 |
| OEM SHEFFIELD | **GUANGZHOU** (8), **HY** (2), **KASSIDYxx** (2), **ELABORATEXxx** (2) | 14 |
| TECNODOM | **TECNODOM** (8) | 8 |
| CREM | **CREM** (8) | 8 |
| EMPERO | **EMPEROxx** (7) | 7 |
| PRISMA FOOD | **PRISMA** (6) | 6 |
| BILGE | **BILGE** (6) | 6 |
| RANCILIO | **RANCILIO** (6) | 6 |
| BERJAYA | **BERJAYA** (5) | 5 |
| KAYALAR | **KAYALARxx** (4) | 4 |
| KITCHENWARE | **WANHUI** (4) | 4 |
| H-KITCHEN | **H KITCHEN** (2), **BRAVO** (1) | 3 |
| SANTOS | **SANTOS** (3) | 3 |
| BREMA | **BREMA** (3) | 3 |
| PASMO | **PASMO** (3) | 3 |
| ROBOT COUPE | **ROBOT COUPE** (1), **FOOD PROCESSORS** (1) | 2 |
| WARING | **WARING** (2) | 2 |
| HY | **HY** (2) | 2 |
| ROLLER GRILL | **CANCELLED IMPORTED ITEMS** (2) | 2 |
| BARON | **BARON** (2) | 2 |
| GENEVA | **H KITCHEN** (2) | 2 |
| COMENDA | **COMENDA** (2) | 2 |
| FAGOR | **CANCELLED IMPORTED ITEMS** (2) | 2 |
| TEFCOLD | **TEFCOLDxx** (1) | 1 |
| SV-BLUELINE | **COMENDA** (1) | 1 |
| TUNGSTEN | **H KITCHEN** (1) | 1 |
| INFRICO | **INFRICO** (1) | 1 |
| BERTOS | **BERTOSxxx** (1) | 1 |
| EUROTEC RIGA | **RIGA** (1) | 1 |
| LINCAT | **CANCELLED IMPORTED ITEMS** (1) | 1 |
| LINCAR MEMME | **MEMME.xx** (1) | 1 |
| STEELOLOGY | **H KITCHEN** (1) | 1 |
| SIMONELLI | **SIMONELLI** (1) | 1 |
| PRADEEP | **PRADEEP** (1) | 1 |
| CARPIGIANI | **CARPIGIANI** (1) | 1 |
| CAMBRO | **CAMBRO** (1) | 1 |
| KUSINA | **KUSINA** (1) | 1 |

---

## B. The problem-bucket SKUs

These are the SKUs the All-Categories workbook flags as unresolved. Each row below now has a
supplier, a code, a quoted price and a photograph.

### B1. Problem-bucket SKUs now carrying supplier evidence

| SKU | Brand | Catalogue model | Name | Bucket | Supplier sheet | Supplier make / model | Match |
|---|---|---|---|---|---|---|---|
| `IMG/HOT/00005` | BERTOS | `E7SP-4B` | Food Warmer Electric Bertos | Data on file, not yet listed | BERTOSxxx | Bertos `E7SP-4B` | exact |
| `IMG/BUF/00022` | HK-REDLINE | `2009/ED` | Cup Warmer H Kitchen | No supplier data | H KITCHEN | H-KITCHEN `2009/ED` | exact |
| `IMG/BUF/00051` | OEM SHEFFIELD | `TC-1` | Induction Cooker Kassidy | No supplier data | KASSIDYxx |  `TC1` | exact |
| `IMG/BUF/00090` | KITCHENWARE | `A6-650N-32` | Induction Cooker Wanhui | No supplier data | WANHUI | WANHUI `A6-650N-320` | near |
| `IMG/BUF/00145` | HY | `HY-902` | Chafing Dish Drop in HY-902 | No supplier data | HY | HY `HY 902` | exact |
| `IMG/BUF/00146` | HY | `HY-836` | Chafing Dish Oval HY-836 | No supplier data | HY | HY `HY 836` | exact |
| `IMG/HOT/00067` | HK-REDLINE | `SOT-4S` | 4 Burner Table Top H Kitchen | No supplier data | H KITCHEN | H-KITCHEN `SOT--4S` | exact |
| `IMG/BUF/00019` | HK-REDLINE | `YFR01-2` | Chafing Dish Drop in Oblong H Kitchen | Sources disagree | H KITCHEN | H Kitchen `YFR01-2` | exact |
| `IMG/BUF/00027` | HK-REDLINE | `AT50293` | Chafing Dish Induction Round AT50293 H Kitchen | Sources disagree | H KITCHEN | H-Kitchen `AT50293` | exact |
| `IMG/BUF/00028` | HK-REDLINE | `AT60293` | Chafing Dish Induction Square H-Kitchen | Sources disagree | H KITCHEN | H-Kitchen `AT60293` | exact |
| `IMG/BUF/00030` | HK-REDLINE | `EB-1200` | Induction Cooker H Kitchen EB-1200 | Sources disagree | H KITCHEN | H-Kitchen `EB1200` | exact |
| `IMG/BUF/00031` | HK-REDLINE | `DR-1` | Plate Warmer Cart Single | Sources disagree | H KITCHEN | H-Kitchen `DR-1` | exact |
| `IMG/BUF/00032` | HK-REDLINE | `DR-2` | Plate Warmer Cart Double | Sources disagree | H KITCHEN | H-Kitchen `DR-2` | exact |
| `IMG/BUF/00037` | OEM SHEFFIELD | `HY-902` | Chafing Dish Drop in | Sources disagree | HY | HY `HY 902` | exact |
| `IMG/BUF/00143` | HK-REDLINE | `AT60293` | Chafing Dish Induction Square AT60293 H-Kitchen | Sources disagree | H KITCHEN | H-Kitchen `AT60293` | exact |
| `IMG/BUF/00244` | HK-REDLINE | `A032` | Heating Lamp Copper | Sources disagree | H KITCHEN | H-Kitchen `A032B` | near |
| `IMG/COF/00004` | CREM | `1008620` | Coffee Brewer Single Cater | Sources disagree | CREM | CREM `1008620` | exact |
| `IMG/COF/00006` | CREM | `CQM2` | Coffee Brewer with 2 Decanter | Sources disagree | CREM | CREM `CQM2` | exact |
| `IMG/COF/00009` | CREM | `1103303` | Serving Station 2.5 Litres | Sources disagree | CREM | CREM `1103303` | exact |
| `IMG/COF/00010` | CREM | `1103302` | Serving Station 5 Litres | Sources disagree | CREM | CREM `1103302` | exact |
| `IMG/COF/00011` | CREM | `1103184` | Air Pot with Sight Gauge | Sources disagree | CREM | CREM `1103184` | exact |
| `IMG/COF/00012` | CREM | `1103256` | Thermos Percolator SS | Sources disagree | CREM | CREM `1103256` | exact |
| `IMG/DIS/00020` | HK-REDLINE | `FGDG 1800LS-3` | Pastry Display Square 1800 | Sources disagree | H KITCHEN | H Kitchen `FGDG1800LS` | near |
| `IMG/DWW/00043` | OEM SHEFFIELD | `JW-253` | Glass Rack Extender 25 Compartment | Sources disagree | GUANGZHOU | Guangzoh `JW-25` | near |
| `IMG/DWW/00097` | OEM SHEFFIELD | `JW-64B` | Plate Rack 64 Compartment JW-64B | Sources disagree | GUANGZHOU | Guangzoh `JW-64B` | exact |
| `IMG/DWW/00107` | CAMBRO | `PR59314151` | Plate Racks 64 Comp Camrack Grey | Sources disagree | CAMBRO | CAMBRO `PR59314151` | exact |
| `IMG/FPR/00038` | SKYMSEN | `LAR-25LMB` | Blender Kitchen 25 Litres SS | Sources disagree | SKYMSEN | Skymsen `LAR-25-LMB` | exact |
| `IMG/FPR/00110` | KAYALAR | `153155040` | Potato Chipper Table Top Kayalar | Sources disagree | KAYALARxx | Kayalar `153155040` | exact |
| `IMG/HOT/00042` | OEM SHEFFIELD | `HEF-904` | Fryer Double 25 Litres Table Top Electric Elaboratex HEF-904 | Sources disagree | ELABORATEXxx | ELABORATEX `HEF-904` | exact |
| `IMG/HOT/00048` | FAGOR | `CG7-40` | 4 Burner Table Top Fagor CG7-40 | Sources disagree | CANCELLED IMPORTED ITEMS | FAGOR `CG7-40` | exact |
| `IMG/HOT/00066` | HK-REDLINE | `EB-450` | Salamander Electric Lift Up EB-450 | Sources disagree | H KITCHEN | H-Kitchen `EB-450` | exact |
| `IMG/HOT/00071` | HK-REDLINE | `EB-600` | Salamander Electric Lift Up EB-600 | Sources disagree | KASSIDYxx | Kassidy `EB-600` | exact |
| `IMG/HOT/00098` | ROLLER GRILL | `RFG 12` | Fryer Roller Grill RFG 12 | Sources disagree | CANCELLED IMPORTED ITEMS | Roller Grill `RFG 12` | exact |
| `IMG/HOT/00169` | GENEVA | `SSPC-40` | Pressure Cooker 40 Litres | Sources disagree | H KITCHEN | H-KITCHEN `SSPC-40` | exact |
| `IMG/HOT/00170` | GENEVA | `SSPC-60` | Pressure Cooker 60 Litres | Sources disagree | H KITCHEN | H-KITCHEN `SSPC-60` | exact |
| `IMG/HOT/00272` | H-KITCHEN | `SOT-4` | Bain Marie Counter Top Gas SOT-4 | Sources disagree | H KITCHEN | H-KITCHEN `SOT-4` | exact |
| `IMG/HOT/00275` | HK-REDLINE | `BS-4V` | Bain Marie Table Top H-Kitchen BS-4 | Sources disagree | KASSIDYxx | Kassidy `BS-4V` | exact |
| `IMG/OVE/00087` | HK-REDLINE | `HTR-20Q` | Gas Deck Oven Single HTR-20Q | Sources disagree | H KITCHEN | H-KITCHEN `HTR-20Q` | exact |
| `IMG/REF/00144` | SHEFFIELD BLUELINE | `GN2100TNG` | Barline Chiller 1207 Blueline | Sources disagree | BLUELINE | SHEFFIELD  BLUELINE `GN2100TNG` | exact |

---

## C. Dimensions

The import file quotes `Overall Size(mm)` as `W x D x H`. Comparison below is order-insensitive
first, so a pure axis swap is reported separately (§C4) from a genuine value disagreement.
⚠ §H.3 is open: unit versus packed dimensions.

### C1. Dimension conflicts — exact model match (tier A)

⭐⭐ **APPLIED 2026-09-02 — 16 of these are done.** On the user's instruction ("go with what
imports team has given us"), every tier-A conflict on a **published** product was corrected to
the imports-team figure: `length`/`width`/`height`, the spec table's Dimensions row, and each
prose mention of a changed number. Applied **positionally** — the import's triple goes into the
three slots in the order printed, which matches each record's own axis label.

The 16: `IMG/DIS/00095` `IMG/DIS/00106` `IMG/FPR/00040` `IMG/FPR/00048` `IMG/HOT/00108`
`IMG/HOT/00189` `IMG/ICE/00019` `IMG/ICE/00020` `IMG/PAS/00005` `IMG/PAS/00007` `IMG/REF/00043`
`IMG/REF/00060` `IMG/REF/00062` `IMG/REF/00063` `IMG/REF/00095` `IMG/REF/00096`.

⚠ **Two are HELD**: `IMG/HOT/00049` (Fagor `CG6-40`) and `IMG/HOT/00099` (Roller Grill `GR80E`)
match only on the **CANCELLED IMPORTED ITEMS** sheet — see §H.1.

Two corroborations found while applying, both of which raise confidence in the source:

- ⭐ **`IMG/HOT/00189` was carrying its sibling's size.** The Baron sheet lists `DI7FRE410`
  (10 litre) at exactly `400x625x340` — the figure our **15-litre** `DI7FRE415` record held.
  Its own spec table already said "Overall Height with Drain Tap approx. 550 mm", which is
  +52 mm on the corrected 498 and an implausible +210 on the old 340.
- ⭐ **Tecnodom's 600 mm is the family depth**, not a stray: `V6080`, `V60125`, `V60150` and
  `VB80250` all read 600 × 1970 on the sheet, while the EVOK `VS80` rows read 810–850. Our 765
  was the outlier.

Also corrected while in these records: four Skymsen spec tables labelled their axis order
`(L × W × H)` where the values are `W × D × H` like every other record. `IMG/HOT/00108` (Waring)
had **no Dimensions row at all** — one was added.

⚠ **Not touched**: secondary heights in the same cells ("2,130 mm on optional castors",
"up to 2,105 mm with feet extended"). They remain coherent against the new base figures and
inventing adjusted values would not be sourced.

⚠ **A separate defect surfaced**: `IMG/REF/00095` claims 685 L and `IMG/REF/00096` claims
1,476 L, where the Blueline sheet gives **1,173 L for both**. Capacity was out of scope here.

**Regression guard added**: `tests/Feature/ProductCatalogueKeysTest.php` → *"keeps stored
dimensions in step with the spec table"*. It compares `length`/`width`/`height` against the spec
table's Dimensions row catalogue-wide and found **25 further rows already drifted** (listed as a
known-drift allowlist in the test, so new drift fails). Most are axis-order permutations of the
same three numbers — the catalogue-wide axis-swap — but `IMG/FPR/00008` (690×800×1080 vs
552×800×1168) and `IMG/BUF/00130` (510×470×740 vs 440×442×720) are genuine value disagreements.


| SKU | Model | Catalogue L×W×H | Import Overall Size (mm) | Sheet | Status |
|---|---|---|---|---|---|
| `IMG/FPR/00048` | `DB-25HD` | 670×550×1155 | 1135 x 650 x 825 | SKYMSEN | Complete |
| `IMG/FPR/00033` | `LAR-03MB-N` | 260×275×630 | 660 x 240 x 255 | SKYMSEN | — |
| `IMG/FPR/00037` | `LAR-10MB-N` | 330×340×780 | 750x330x320 | SKYMSEN | — |
| `IMG/FPR/00038` | `LAR-25LMB` | 525×410×1180 | 1200x350x601 | SKYMSEN | Sources disagree |
| `IMG/FPR/00040` | `CSE` | 280×480×680 | 350x600x570 | SKYMSEN | Complete |
| `IMG/ICE/00019` | `BMS-N` | 150×210×470 | 180X160X490 | SKYMSEN | Complete |
| `IMG/ICE/00020` | `BMS-3-N` | 260×460×470 | 260x470x490 | SKYMSEN | Complete |
| `IMG/REF/00043` | `U-GN3160TN` | 1800×700×650 | 1795X700X650 | BLUELINE | Complete |
| `IMG/REF/00060` | `AF14PKMTN` | 1420×800×2030 | 1420X790X2020 | TECNODOM | Complete |
| `IMG/REF/00062` | `AF07PKMTN` | 710×800×2030 | 710X790X2020 | TECNODOM | Complete |
| `IMG/REF/00095` | `GN1410TN` | 1480×830×2010 | 1340X810X2000 | BLUELINE | Complete |
| `IMG/REF/00096` | `GN1410BT` | 1480×830×2010 | 1340X810X2000 | BLUELINE | Complete |
| `IMG/REF/00061` | `AF07PKMBT` | 710×800×2030 | 710X790X2020 | TECNODOM | Complete |
| `IMG/REF/00063` | `AF14PKMBT` | 1420×800×2030 | 1420X790X2020 | TECNODOM | Complete |
| `IMG/DIS/00095` | `VB80250SL` | 2580×765×2030 | 2580X600X1970 | TECNODOM | Complete |
| `IMG/DIS/00106` | `V6080SLINOX` | 880×600×1984 | 880X600X1970 | TECNODOM | Complete |
| `IMG/PAS/00007` | `SH 03` | 620×1040×1100 | 635x1050x1105 | EMPEROxx | Complete |
| `IMG/BUF/00037` | `HY-902` | 500×500×450 | 500 x 500 x 280 | HY | Sources disagree |
| `IMG/HOT/00108` | `WCT805K` | 438×420×406 | 267 x 304 x 229 | WARING | Complete |
| `IMG/PAS/00005` | `EMP.3005` | 490×300×245 | 400 X 300 X 245 | EMPEROxx | Complete |
| `IMG/HOT/00099` | `GR80E` | 580×660×1035 | 580 x 660 x 1045 | CANCELLED IMPORTED ITEMS | Complete |
| `IMG/HOT/00071` | `EB-600` | 600×510×540 | 600x450x500 | KASSIDYxx | Sources disagree |
| `IMG/HOT/00098` | `RFG 12` | 400×700×325 | 410X400X270 | CANCELLED IMPORTED ITEMS | Sources disagree |
| `IMG/HOT/00189` | `DI7FRE415` | 400×625×340 | 400x625x498 | BARON | Complete |
| `IMG/COF/00006` | `CQM2` | 205×410×428 | 205X360X430 | CREM | Sources disagree |
| `IMG/HOT/00049` | `CG6-40` | 650×600×290 | 600 x 650 x 440 | CANCELLED IMPORTED ITEMS | Complete |

### C2. Dimension conflicts — near model match (tier B/C, verify the join first)

| SKU | Catalogue model | Import model | Catalogue L×W×H | Import Overall Size (mm) | Sheet |
|---|---|---|---|---|---|
| `IMG/FPR/00051` | `SI-282HD` | `SI-282HD-N` | 980×900×1900 | 800x820x1730 | SKYMSEN |
| `IMG/FPR/00274` | `8002` | `DW938002` | 255×230×580 | 500x600x235 | BRAVO |
| `IMG/REF/00097` | `GN1410TNG` | `GN1410TN` | 1480×830×2010 | 1340X810X2000 | BLUELINE |
| `IMG/REF/00105` | `GN2100TNG-1200` | `GN2100TN` | 1200×700×860 | 1360X700X860 | BLUELINE |
| `IMG/REF/00106` | `GN2100TNG-1500` | `GN2100TN` | 1500×700×860 | 1360X700X860 | BLUELINE |
| `IMG/REF/00098` | `GN1410BTG` | `GN1410BT` | 1480×830×2010 | 1340X810X2000 | BLUELINE |
| `IMG/DIS/00001` | `BJY-4GDC78L-A` | `BJY-4GDC78L` | 452×406×966 | 428x386x960 | BERJAYA |
| `IMG/DIS/00037` | `EVOK150V` | `EVOK150` | 1505×763×1391 | 1500x785x1480 | TECNODOM |
| `IMG/DIS/00062` | `VBZ12S` | `VBZ-12` | 1250×920×1345 | 1250x920x1350 | INFRICO |
| `IMG/PAS/00012` | `IBT20` | `IBT 20 2V` | 670×385×725 | 385x415x795 | PRISMA |
| `IMG/PAS/00013` | `IBT30` | `IBT 30 2V` | 750×435×810 | 424X735X805 | PRISMA |
| `IMG/PAS/00014` | `IBT40` | `IBT 40 2v` | 820×480×850 | 480x805x828 | PRISMA |
| `IMG/PAS/00015` | `IBT50` | `IBT 50 2v` | 805×480×850 | 480x805x828 | PRISMA |
| `IMG/PAS/00016` | `IBT 60` | `IBT 60 2v` | 960×535×915 | 480x805x828 | PRISMA |
| `IMG/PAS/00164` | `KT-20` | `G9KT200G` | 660×700×1060 | 800x900x900 | KUSINA |
| `IMG/TCW/00114` | `1/3*100` | `611013100` | 325×176×100 | 530 x 325 x 150 | BILGE |
| `IMG/TCW/00124` | `1/1*200` | `611011200` | 530×325×200 | 530 x 325 x 150 | BILGE |
| `IMG/COF/00002` | `WU-CH-40L` | `CH-40` | 380×380×460 | 1100x780x615 | FAGOR LAUNDRY |
| `IMG/COF/00079` | `SILVIA PRO` | `Silvia` | 250×390×420 | 235x290x340 | RANCILIO |
| `IMG/COF/00135` | `KRYO 65 OD` | `Kryo 65` | 356×220×575 | 220x385x575 | RANCILIO |
| `IMG/REF/00081` | `CB 249A HC` | `CB 249` | 387×470×687 | 390 x 460 x 690 | BREMA |
| `IMG/REF/00082` | `CB 416A HC` | `CB 416` | 497×598×686 | 500 x 580 x 690 | BREMA |
| `IMG/ICE/00017` | `S110F` | `S110FA1` | 720×385×728 | 785x385x730 | PASMO |
| `IMG/DWW/00040` | `JW-162` | `JW-16` | 500×500×45 | 500x500x100 | GUANGZHOU |

### C3. Catalogue has no dimensions, import does

| SKU | Model | Name | Import Overall Size (mm) | Sheet |
|---|---|---|---|---|
| `IMS/MEC/00270` | `GC16` | Disc Cube | 220x210x12 | SKYMSEN |
| `IMS/MEC/00309` | `DAK` | Male Blade for Chipper 10MM | 1240x470x420 | SKYMSEN |
| `IMS/MEC/00312` | `DAK` | Female Blade for Chipper 10MM | 1240x470x420 | SKYMSEN |
| `IMG/FPR/00050` | `DAK` | Potato Smasher on Stand | 1240x470x420 | SKYMSEN |
| `IMG/BUF/00151` | `34-2A` | Juice Dispenser 2 Tank 34-2A Santos | 380x430x545 | SANTOS |
| `IMG/BUF/00152` | `34-3A` | Juice Dispenser 3 Tank 34-3A Santos | 570x430x545 | SANTOS |
| `IMG/BUF/00145` | `HY-902` | Chafing Dish Drop in HY-902 | 500 x 500 x 280 | HY |
| `IMG/BUF/00146` | `HY-836` | Chafing Dish Oval HY-836 | 550x320x300 | HY |
| `IMG/HOT/00275` | `BS-4V` | Bain Marie Table Top H-Kitchen BS-4 | 700x580x230 | KASSIDYxx |
| `IMG/HOT/00085` | `G1140VN` | Fryer Single 13 Litres Gas Lincar | 400x900x850 | MEMME.xx |
| `IMG/COF/00128` | `ROCKY` | Rancilio Rocky Doser Nero Black | 120x250x350 | RANCILIO |
| `IMG/COF/00101` | `CMP-2` | Decanter 1.8 Litres KEF | 876x791x1782 | RATIONAL CMP |

### C4. Axis order differs, values agree

| SKU | Model | Catalogue | Import |
|---|---|---|---|
| `IMG/FPR/00246` | `DB-10` | 580×475×720 | 720X475X580 |
| `IMG/FPR/00215` | `CFI-300L-N` | 570×560×440 | 440x560x570 |
| `IMG/FPR/00034` | `LAR-04MB-N` | 260×275×630 | 630X275X260 |
| `IMG/FPR/00036` | `LAR-08MB-N` | 320×330×750 | 750x330x320 |
| `IMG/FPR/00021` | `10A` | 300×200×380 | 380x200x300 |
| `IMG/BUF/00127` | `DK977` | 350×654×115 | 115x350x654 |

---

## D. Model numbers

⚠ `model_number` is the catalogue's unique ID (`feedback_model_number_unique_id`). Nothing here
is applied; each row is a proposal.

### D1. `model_number` string differs from the supplier's own code

| SKU | Brand | Catalogue `model_number` | Supplier code | Sheet | Supplier description |
|---|---|---|---|---|---|
| `IMS/MEC/00270` | SKYMSEN | `GC16` | `GC16-S` | SKYMSEN | Grinding Grid DiscDurable and versatile;  Gross Weight17kgNet Weight15kgCapacity |
| `IMG/FPR/00051` | SKYMSEN | `SI-282HD` | `SI-282HD-N` | SKYMSEN | S/S BAND SAW - FREE STANDINGB; movable table. Machine of modern design,safe and  |
| `IMG/FPR/00274` | H-KITCHEN | `8002` | `DW938002` | BRAVO | Fryer Bowl: Double well |
| `IMG/REF/00097` | SHEFFIELD BLUELINE | `GN1410TNG` | `GN1410TN` | BLUELINE | 2 door solid upright chiller; Features: 4 pcs castors, 8 shelves, Dixell thermos |
| `IMG/REF/00102` | SHEFFIELD BLUELINE | `GN4100TN` | `GN4100TNG` | BLUELINE | 4 door barline fridge; Features: 6 pcs castors, 4 shelves, Dixell thermostat, S/ |
| `IMG/REF/00105` | SHEFFIELD BLUELINE | `GN2100TNG-1200` | `GN2100TN` | BLUELINE | 2 door Counter fridge; Features: 4 pcs castors, 2 shelves, Dixell thermostat, S/ |
| `IMG/REF/00106` | SHEFFIELD BLUELINE | `GN2100TNG-1500` | `GN2100TN` | BLUELINE | 2 door Counter fridge; Features: 4 pcs castors, 2 shelves, Dixell thermostat, S/ |
| `IMG/REF/00107` | SHEFFIELD BLUELINE | `GN3100TNG` | `GN3100TN` | BLUELINE | 3 door Counter fridge; Features: 4 pcs castors, 3 shelves, Dixell thermostat, S/ |
| `IMG/REF/00098` | SHEFFIELD BLUELINE | `GN1410BTG` | `GN1410BT` | BLUELINE | 2 door solid upright freezer; Features: 4 pcs castors, 8 shelves, Dixell thermos |
| `IMG/DIS/00146` | HK-REDLINE | `HK-BC-01` | `HK-BC-01B` | H KITCHEN | Under Counter Beer Cooler; 230V/50HZ  1  pulling door. 2-10℃ temperate. 115 L. o |
| `IMG/DIS/00133` | SV-BLUELINE | `LC-1200(T)` | `LC-1200` | COMENDA | Dish Washer MachineAuto tank refill;                     counter balanced hood   |
| `IMG/DIS/00001` | BERJAYA | `BJY-4GDC78L-A` | `BJY-4GDC78L` | BERJAYA | Four Glass Display Chiller; Temperature Range (°C) 0 - 12. Capacity (L) 78. Refr |
| `IMG/DIS/00037` | TECNODOM | `EVOK150V` | `EVOK150` | TECNODOM | EVOK SQUARE COLD DISPLAY SHOWCASE - 950 Litre Italian made cake display showcase |
| `IMG/DIS/00020` | HK-REDLINE | `FGDG 1800LS-3` | `FGDG1800LS` | H KITCHEN | SQUARE COLD "LILY" Showcase-Closed type; S/steel plate, luxuriant appearance. Ef |
| `IMG/DIS/00062` | INFRICO | `VBZ12S` | `VBZ-12` | INFRICO | Ice-Cream display cases; 10 x 1/3GN Ice Cream Pans. Temperature -150C to -180C.  |
| `IMG/OVE/00019` | PRISMA FOOD | `GAS 4 PF PROPANO` | `Gas 4` | PRISMA | 1 deck Gas Pizza Oven;  - Internal  Dimension (mm)   620x620x560 Temperature (ºC |
| `IMG/PAS/00012` | PRISMA FOOD | `IBT20` | `IBT 20 2V` | PRISMA | Spiral Mixer;  Ideal equipment for pizzerias, pastry- shops, bakeries and famili |
| `IMG/PAS/00013` | PRISMA FOOD | `IBT30` | `IBT 30 2V` | PRISMA | 30 Lt Spiral Mixer;  Ideal equipment for pizzerias, pastry- shops, bakeries and  |
| `IMG/PAS/00014` | PRISMA FOOD | `IBT40` | `IBT 40 2v` | PRISMA | 40 Lt Spiral Mixer;   Ideal equipment for pizzerias, pastry- shops, bakeries and |
| `IMG/PAS/00015` | PRISMA FOOD | `IBT50` | `IBT 50 2v` | PRISMA | 50 Lt Spiral Mixer; Ideal equipment for pizzerias, pastry- shops, bakeries and f |
| `IMG/PAS/00016` | PRISMA FOOD | `IBT 60` | `IBT 60 2v` | PRISMA | 60 Lt Spiral Mixer; Ideal equipment for pizzerias, pastry- shops, bakeries and f |
| `IMG/BUF/00023` | HK-REDLINE | `A032` | `A032B` | H KITCHEN | Retractable Heating Lamp; 230V/50hz/250W/dia: 175mm/Black color |
| `IMG/BUF/00024` | HK-REDLINE | `A032` | `A032B` | H KITCHEN | Retractable Heating Lamp; 230V/50hz/250W/dia: 175mm/Black color |
| `IMG/BUF/00025` | HK-REDLINE | `A035` | `A035B` | H KITCHEN | Retractable Heating Lamp; 230V/50hz/250W/dia: 290mm/ Black Colour |
| `IMG/BUF/00026` | HK-REDLINE | `A035` | `A035B` | H KITCHEN | Retractable Heating Lamp; 230V/50hz/250W/dia: 290mm/ Black Colour |
| `IMG/BUF/00244` | HK-REDLINE | `A032` | `A032B` | H KITCHEN | Retractable Heating Lamp; 230V/50hz/250W/dia: 175mm/Black color |
| `IMG/BUF/00090` | KITCHENWARE | `A6-650N-32` | `A6-650N-320` | WANHUI | Induction cooker for chaffer warming |
| `IMG/TCW/00086` | BERJAYA | `FP 1/3-2.5` | `IBSP FP 1/3-2.5` | BERJAYA | Third Size Food PanStainless Steel Food Pan - 65 mm |
| `IMG/TCW/00089` | BERJAYA | `FP 1/1-4` | `IBSP-FP 1/1-4` | BERJAYA | Full Size Food PanStainless Steel Food Pan -        100 mm |
| `IMG/TCW/00090` | BERJAYA | `FP 1/2-4` | `IBSP FP 1/2-4` | BERJAYA | Half Size Food Pan - 100 mm |
| `IMG/TCW/00091` | BERJAYA | `FP 1/3-4` | `IBSP FP 1/3-4` | BERJAYA | Third Size Food PanStainless Steel Food Pan - 100 mm |
| `IMG/TCW/00112` | BILGE | `1/1*100` | `6110111000` | BILGE | Bilge stainless steel GN 1/1-100 container ; Extra stable thanks to the circumfe |
| `IMG/TCW/00114` | BILGE | `1/3*100` | `611013100` | BILGE | Bilge stainless steel GN 1/3-100 container ; Extra stable thanks to the circumfe |
| `IMG/TCW/00115` | BILGE | `1/4*100` | `611410000` | BILGE | Lid for gastronorm container stainless steel GN 1/1; Lid for gastronorm containe |
| `IMG/TCW/00118` | BILGE | `1/1*150` | `6110111500` | BILGE | Bilge stainless steel GN 1/1-150 container ; Extra stable thanks to the circumfe |
| `IMG/TCW/00119` | BILGE | `1/2*150` | `62212150` | BILGE | Bilge sink unit cout drip tray 150x60 |
| `IMG/TCW/00124` | BILGE | `1/1*200` | `611011200` | BILGE | Bilge stainless steel GN 1/1-200 container ; Extra stable thanks to the circumfe |
| `IMG/HOT/00186` | BARON | `SE40/0CB` | `SE40/0` | BARON | Lift Electric Salamander with Movable Radiant Plate. V 230 - kW 2 |
| `IMG/HOT/00427` | OEM SHEFFIELD | `HEF-904 BASKET` | `HEF-904` | ELABORATEXxx | Electric fryer Table Top; Volts:220-240V/50-60HZ  Power:4.5 +4.5 KW. Capacity:25 |
| `IMG/HOT/00085` | LINCAR MEMME | `G1140VN` | `G1140` | MEMME.xx | 1 TANK GAS DEEP FRYER; Gas deep fryer designed for high performance professional |
| `IMG/COF/00013` | CREM | `CQ V-2 1001120` | `CQV-2` | CREM | WARMING PLATE DOUBLE CQ V-2 1001120;        1.8x2 litres    Single phase,190W    |
| `IMG/OVE/00024` | RATIONAL | `6019.1150` | `6019.115` | RATIONAL ACCESSORIES |  |
| `IMG/COF/00079` | RANCILIO | `SILVIA PRO` | `Silvia` | RANCILIO | Coffee machine; Boiler capacity 0.3 liters. Boiler power 950 W - 1100W. Voltage  |
| `IMG/COF/00135` | RANCILIO | `KRYO 65 OD` | `Kryo 65` | RANCILIO | Industrial grinders; Coffee bean container 1.3 kgs. Variable dose 5.5 to 10grams |
| `IMG/COF/00043` | RANCILIO | `KRYO 65 ST` | `Kryo 65` | RANCILIO | Industrial grinders; Coffee bean container 1.3 kgs. Variable dose 5.5 to 10grams |
| `IMG/COF/00054` | SIMONELLI | `MICROBAR II` | `Microbar II (Cappuccino AD)` | SIMONELLI | Super-automatic compact machine with built-in cappuccino maker; Removable metal  |
| `IMG/REF/00081` | BREMA | `CB 249A HC` | `CB 249` | BREMA | 29 KG Self-contained ice maker - Sprayer system; Production in 24h - 29 kg. Bin  |
| `IMG/REF/00082` | BREMA | `CB 416A HC` | `CB 416` | BREMA | 44 KG Self-contained ice maker - Sprayer system; Production in 24h 44 kg. Bin ca |
| `IMG/REF/00076` | BREMA | `CB 1565A HC` | `CB1565` | BREMA | 155 KG Self-contained ice maker - Sprayer system; Production in 24h 155 kg. Bin  |
| `IMG/ICE/00017` | PASMO | `S110F` | `S110FA1` | PASMO | Soft Ice Cream machine Table Top, Cylinder capacity: 1.6L, Production capacity:  |
| `IMG/DWW/00085` | COMENDA | `PC-09` | `LC-900 (PC-09)` | COMENDA | Hood type Dish Washer; Water consumption/cycle: 4litresBooster  Capacity: 8.2lit |
| `IMG/DWW/00093` | COMENDA | `PC 07` | `LC-411 (PC-07)` | COMENDA | Hood type dish washer; Water consumption/cycle: 3.2litres. Booster Capacity: 8.2 |
| `IMG/DWW/00040` | OEM SHEFFIELD | `JW-162` | `JW-16` | GUANGZHOU | Glass Rack Beige - 16 Compt; Compartment size 115x115x45 |
| `IMG/DWW/00043` | OEM SHEFFIELD | `JW-253` | `JW-25` | GUANGZHOU | Glass Rack Beige - 16 Compt; Compartment size 90x90x45 |
| `IMG/HOT/00120` | KUSINA | `G7K210G-E` | `G7K210G` | KUSINA | Kusina cooking gas; • 4 Burners , with oven • Easy to clean and simple maintenan |

---

## E. Defects the join exposed

### E1. One supplier code, several catalogue SKUs (tier A)

| Supplier line item | Catalogue SKUs sharing it | Reading |
|---|---|---|
| `[H KITCHEN] AT60293` Induction Chafer | `IMG/BUF/00028` (archived) · `IMG/BUF/00143` (published) | same product listed twice; one already archived |
| `[HY] HY 902` Built-in Round Chafing | `IMG/BUF/00037` (published, 57,793.25) · `IMG/BUF/00145` (archived, price 0) | duplicate |
| `[RANCILIO] Rocky` grinder | `IMG/COF/00044` (published, 98,162.50) · `IMG/COF/00128` (draft, 118,750) | duplicate at two prices |
| `[RATIONAL ACC] 56.00.562` | `IMG/HYS/00034` (25,600) · `IMG/HYS/00035` (320.75) | **not** a duplicate — box versus single tab; both legitimately share the code |
| `[SKYMSEN] DAK` Potato Chipper On Stand | `IMS/MEC/00309` Male Blade · `IMS/MEC/00312` Female Blade · `IMG/FPR/00050` Potato Smasher | ⚠ **`DAK` is the chipper's own code**; the two blades carry it wrongly, and `IMG/FPR/00050` is named "Potato Smasher" where the supplier says chipper |

### E2. Wrong-product images the photos can adjudicate

Each supplier photo is anchored to the supplier's own code, so it settles "is our stored image
the right product?" for all 222 matched SKUs. Already visible in the manifest: **35 supplier
photos are shared by more than one code** — the supplier's own one-photo-many-SKUs habit
(`feedback_one_photo_many_skus`). All five Prisma `IBT 20/30/40/50/60` spiral mixers share one
image; so do the four Blueline `GN1410*` cabinets. ⚠ **A shared supplier photo is not evidence
that two products are identical** — the dimension columns beside them differ.

### E3. Coincidental code collisions — false joins, do not re-derive

| Catalogue | Matched to | Why it is wrong |
|---|---|---|
| `IMG/COF/00002` BERJAYA `WU-CH-40L` | `[FAGOR LAUNDRY] CH-40` | Fagor's is a laundry trolley with bin |
| `IMG/COF/00101` KEF `CMP-2` | `[RATIONAL CMP] CMP201G` | "CMP" is Rational's sheet name, not a code |
| `IMG/TCW/00107` BILGE `1/2*65` | `[XS RATIONAL ACC] 6015.1265` | digit coincidence |
| `IMG/PAS/00164` HK-REDLINE `KT-20` | `[KUSINA] G9KT200G` | different boiling pans (660×700×1060 vs 800×900×900) |

---

## F. ⚠ The photographs — what they can and cannot do

1,257 unique embedded images. Resolution measured across all of them:

| Short edge | Images |
|---|---|
| ≥ 1000 px | 1 |
| ≥ 800 px (our storefront floor) | 5 |
| ≥ 500 px | 97 |
| ≥ 300 px | 539 |
| median | **275 px** |

**These cannot be shipped as product photography.** What they are good for is the thing the web
sweep kept failing at: proving *which physical product* a code denotes, which is how a wrong
stored image gets caught (`feedback_source_image_for_every_sku`). Use them as evidence, then
source shippable art separately.

Extracted to `Desktop\ecommerce\products resource\_imported-items-evidence\`, named
`<SKU>__<supplier model>__<sheet>.<ext>`, with `_manifest.json` carrying pixel size, MD5, tier
and data-status per file. **Deliberately NOT staged into the per-brand `<brand>-images\`
folders**, so nothing low-resolution leaks into the storefront pipeline.

---

## G. What is in the workbook but not in the catalogue

**1,271 distinct supplier codes have no catalogue counterpart.** Largest concentrations:

| Sheet | Codes not in catalogue |
|---|---|
| BERJAYA | 85 |
| KAYALARxx | 81 |
| FAGOR LAUNDRY | 75 |
| H KITCHEN | 55 |
| KUSINA | 52 |
| BARON | 50 |
| GUANGZHOU | 47 |
| SILIKOMATT | 47 |
| ROBOT COUPE | 40 |
| BERTOSxxx | 38 |
| KASSIDYxx | 38 |
| TECNODOM | 37 |

Eighteen sheets have **no counterpart brand in the catalogue at all** — ALLIANCE, AVATHERM, BCE,
COOLHEAD, DECORATIVE SHEETS, FORMA, HERBISH, ISA, JKE, MACPAN, ORION, PASTOFRIGO, QUALIMARK,
RAJALAKSHMI, ROSSETO, SDX, SILIKOMATT, SIMPLE. Some are OEMs behind house labels not yet traced;
others are ranges we simply never listed.

⚠ **108 rows sit on a `CANCELLED IMPORTED ITEMS` sheet.** Four catalogue SKUs match only there —
`IMG/HOT/00048` (Fagor `CG7-40`), `IMG/HOT/00049` (Fagor `CG6-40`), `IMG/HOT/00098` (Roller Grill
`RFG 12`), `IMG/HOT/00099` (Roller Grill `GR80E`). Being on that sheet may mean the line was
discontinued; confirm before enriching from it.

---

## H. Open questions for the imports team

1. **What does the `xx` suffix on a sheet name mean?** Fifteen sheets carry it — ELABORATEXxx,
   KASSIDYxx, BERTOSxxx, MARENOxx, ISAxx, TEFCOLDxx, COOLHEADxx, EMPEROxx, ORIONxx, MACPANxx,
   HERBISHxx, ROSSETOxx, MEMME.xx, KAYALARxx, BCExx. If it marks a dead supplier, the ELABORATEX
   and KASSIDY identifications in §A2 are historical rather than current.
2. **`TC1` — "Heating Pad" or induction cooker?** Kassidy's description contradicts our name for
   `IMG/BUF/00051`.
3. **Are the `Overall Size(mm)` figures unit or packed dimensions?** The SAP export's dimension
   field is known to mix the two (`project_sap_source_of_truth`), and every §C conflict depends
   on the answer. Evidence so far says **unit**: on 48 SKUs the values track ours to within a few
   millimetres, which packed sizes would not.
4. **The 20 SKUs marked "Our records only" matched nothing here.** That is itself a signal — they
   may never have been imported at all.

---

## I. Suggested order of work

1. §A2 — apply the supplier identifications; they unblock ordinary web research across the rest
   of each house brand.
2. §B1 — the 39 problem-bucket SKUs, each now with a supplier, a code, a price and a photo.
3. §C1 — the 26 tier-A dimension conflicts (imports team is authoritative, so correct the
   catalogue).
4. §D1 — `model_number` corrections. ⚠ `model_number` is the unique ID
   (`feedback_model_number_unique_id`): propose, never bulk-apply.
5. §E1 — resolve the five duplicate / bad-code groups.
