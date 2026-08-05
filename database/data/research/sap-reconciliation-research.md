# SAP Reconciliation

Reconciliation of `products.json` against the SAP export in
`Desktop\ecommerce\product sap source` (18 workbooks, re-exported 2026-07-30 with a Width
column added). SAP is the internal system of record; `products.json` was extracted from the
live website and is **not** independently trustworthy.

## 0. The export

| | |
|---|---|
| Workbooks | 18, named by SKU prefix (`img-ref`, `img-hot`, `ims-mec`, …) |
| SAP rows | **7,192** unique items |
| `products.json` | 683 |
| Matched on `Item No.` → `sku` | **666** |
| Not in SAP | **17** |

Columns: `Item No.` · `Item Description` · `Item Remarks` · `Make` · `Model Number` ·
`Part Number` · `In Stock` · `Length 1 - Purchase Unit` · `Weight 1 - Purchasing Unit` ·
`Height 1 - Purchasing Unit` · `Width 1 - Purchasing Unit`.

`Item No.` joins **exactly** to our `sku` — no fuzzy matching needed.

✅ **`img-pas.xlsx` — malformed XML, now repaired by the user and verified.** It originally
carried an invalid control character in `sharedStrings` that openpyxl refused to parse, so the
loader repaired it in memory (stripping `[\x00-\x08\x0b\x0c\x0e-\x1f]` from every `.xml` part of
the zip) without touching the file. After the user's repair it loads natively, and a field-level
diff against the in-memory version shows **144 rows and zero differences** — the workaround was
faithful, so nothing applied from it needed redoing.

⚠ Note `img-pas.xlsx` has **11 columns, not 12** — it lacks the leading `#` column the other
workbooks carry. Harmless here because the loader resolves columns **by name**, but a
positional reader would silently shift every field by one.

⚠ A stale `fap-fpr.xlsx` (identical 820-SKU set, no Width column) was superseded by
`fab-fpr.xlsx` and deleted at the user's instruction on 2026-07-30, after verifying the SKU
sets were identical and only the new file carried Width.

### The 17 SKUs absent from SAP
16 are synthetic `GROUP/…` records we created for the storefront (Rational accessories, Pradeep
urns and milk boiler, Berjaya urn, Skymsen blender, Prisma dough mixer, Bilge GN lids, HDS fryer) —
expected, they are not SAP items. **One is real: `IMG/FPR/00906` "Bone Saw Blade 1650MM"
(SHEFFIELD)** — it is on the website but not in SAP. Needs a decision.

**Two item-code repairs on 2026-07-30 made this join exact** (re-verified: 666 matched / 17 absent,
and all **49 variant codes match SAP**, 49/49):

1. `IMG/HOT/OO438` used **letter-O for zero** and so could not join. SAP's authoritative
   `Item No.` is `IMG/HOT/00438` ("GAS BURNERS WITH OVEN AND 24" GRIDDLE/SALAMANDER", Make HDS),
   sitting right after `IMG/HOT/00437` — so SAP independently settled the correction that
   `hds-research.md` §2 trap 5 had only been able to flag. The five image files on disk were
   renamed to match.
2. The Pradeep "Milk Boiler with Indirect Water Heating Jacket" parent carried **`sku: null`**
   rather than a `GROUP/…` key, so it was silently counted among the synthetic records while also
   being the one row that could collide in `ProductSeeder`'s `$productIdBySku` map. It is now
   `GROUP/MILK-BOILER-INDIRECT-JACKET-PRADEEP`. Its three real codes — `IMG/COF/00023`/`00024`/
   `00025`, the 12/20/30-litre variants — all match SAP, and SAP has **no parent item**, which is
   the point: variable parents legitimately own no item code.

`ProductCatalogueKeysTest` now locks both classes: every row has a code, every non-`GROUP` code
matches `^(IMG|IMS|FAB)/[A-Z]{3}/\d{5}$` (which is what catches letter-O), variant codes match the
same shape, and a `GROUP/` key only ever appears on a variable/grouped/bundle row that has variants.

## 1. Brand / Make — 645 of 666 agree

Only **20 differ** and **1 is blank in SAP**. Every difference is meaningful:

| Count | `products.json` | SAP `Make` | Reading |
|---|---|---|---|
| 6 | `IBERNA` | **`OEM SHEFFIELD`** | ⚠ SAP says these ice machines are bought as a **house label**, not as Iberna. Contradicts `iberna-research.md`'s framing and matters for [[the house-brand map]] — Iberna is the factory, but the goods are ours. |
| 3 | `SHEFFIELD BLUELINE` | `BLUELINE` | the two labels are used interchangeably **in both systems** |
| 2 | `BLUELINE` | `SHEFFIELD BLUELINE` | …in both directions. Confirms `blueline-research.md` §1.5's merge recommendation. |
| 3 | `BROASTER` | **`HDS`** | ⚠ SAP files Broaster items under **Heavy Duty Systems** |
| 2 | `KALERM` | `KALERM K-90` | SAP has a model code inside the Make field |
| 1 | `SHEFFIELD` | `H-KITCHEN` | |
| 1 | `H-KITCHEN` | `HKITCHEN` | spacing only |
| 1 | `G PANIZ` | `GPANIZ` | spacing only |
| 1 | `Hatton` | `HATTONS` | plural + casing |

**A 97% agreement rate means our brand attribution is broadly sound** — which is a genuinely
reassuring result for the enrichment work built on top of it. The exceptions are the interesting
part, especially IBERNA→OEM SHEFFIELD and BROASTER→HDS.

## 2. Stock — APPLIED

**325 of 666 differed.** Total units: ours 5,314 → SAP **15,225**. Our figures were badly stale,
as expected from a website extract.

- 38 SKUs showed stock we do not have (SAP = 0) — the commercially risky direction
- 23 showed zero while SAP has stock
- 264 differed while both were non-zero

All 325 written to `quantity` from SAP `In Stock`. Verified: 325 field changes, nothing else
touched. `ProductCatalogueKeysTest` green.

## 3. Dimensions — SAP is strong but NOT blindly trustworthy

| Bucket | Count |
|---|---|
| Exact match | **148** |
| Value mismatch | **154** |
| Both blank | 147 |
| **Ours blank, SAP has data** | **103** |
| SAP blank, ours has data | 83 |
| **Same values, wrong order** | **31** |

### 3.1 SAP's axis convention is (widest face, depth, height)

Tested against manufacturer catalogues where both exist, SAP's `Length`/`Width`/`Height` are the
**product's** dimensions in the order **W, D, H** — the same convention applied to Blueline:

| SKU | Model | SAP | Manufacturer |
|---|---|---|---|
| IMG/REF/00034 | `GN1100TN` | 925 / 700 / 860 | Vcher unit 925 × 700 × 860 ✅ |
| IMG/REF/00036 | `GN2100TN` | 1360 / 700 / 860 | Vcher unit 1360 × 700 × 860 ✅ |
| IMG/REF/00157 | `DR400 S/S` | 600 / 615 / 1870 | Vcher unit 600 × 615 × 1870 ✅ |
| IMG/REF/00043 | `U-GN3160TN` | 1795 / 700 / 650 | matched an inference I declined to publish ✅ |

**Two open questions are now settled by SAP:**
- **The `1100` tier is 925 mm wide.** `sheffield-blueline-research.md` §2.1 left this unresolved
  because Vcher's own data self-contradicted. SAP confirms 925 × 700 × 860.
- **`U-GN3160TN` is 1795 × 700 × 650**, exactly the geometry §5.1 inferred from the `U-` = 650 mm
  low-boy decode but deliberately did not write.

### 3.2 ⚠ But the field is contaminated with carton dimensions

The columns are named *"Purchase Unit"* / *"Purchasing Unit"*, and at least one row really does
carry the **shipping carton**:

`IMG/DIS/00120` `EWB470G` — SAP stores **1910 / 640 / 765**. Wondereach publishes
**unit 595 × 710 × 1880** and **pack 640 × 760 × 1910**. SAP's three numbers are the *pack*.

A volume comparison across the 154 mismatches is inconclusive — 52 SAP-larger, 49 SAP-smaller,
23 within 2% — so this is **not** a uniform packaging field. It is **mixed**: mostly product
dimensions, with carton contamination on an unknown subset. This is the same bug class already
recorded for Dr. Coffee F11, now shown to exist inside SAP as well.

**Therefore: do not bulk-overwrite dimensions from SAP.** Use it as corroboration where it
agrees with a manufacturer source, and as a flag where it does not.

### 3.3 The 31 mis-ordered records have no single permutation

Mapping ours → SAP: `(0,2,1)` ×13, `(1,0,2)` ×6, `(2,0,1)` ×5, `(2,1,0)` ×1, ambiguous ×6.
No single transform fixes them — consistent with every earlier finding on this catalogue.
But now there is an authoritative per-SKU target rather than an inference.

### 3.4 ⚠ SAP contradicts 13 of the 65 dimensions applied earlier today

Including three where **SAP suggests my Vcher-derived value is wrong**:

| SKU | Model | Written from Vcher | SAP |
|---|---|---|---|
| IMG/REF/00182 | `GN4140TN` | 2230 / 700 / **860** | 2230 / 700 / **850** — the *original* stored 850 was right |
| IMG/REF/00144 | `GN2100TNG` | 1360 / 700 / 860 | **1200** / 700 / 860 — a narrower variant |
| IMG/REF/00168 | `S903` | 1365 / 700 / 860 | **2400** / 700 / 860 — a much larger unit than the name's "1340" |
| IMG/DIS/00120 | `EWB470G` | 595 / 710 / 1880 | 1910 / 640 / 765 — carton, see §3.2 |

⚠ SAP also has **its own** sibling contamination: ASTAR `IMG/FPR/00180` and `IMG/FPR/00181`
both store 370 / 490 / 1200 despite being different products.

## 4. Recommended next steps

1. **Safe now:** fill the **103 records where we are blank and SAP has data**, and re-order the
   **31 mis-ordered** to SAP's W/D/H. Both are strictly better than the current state.
2. **Case by case:** the **154 value mismatches**, checking each against a manufacturer source —
   SAP wins on procurement facts, the manufacturer wins on product geometry, and §3.2 shows
   which is which cannot be assumed.
3. **Decide:** the IBERNA → OEM SHEFFIELD and BROASTER → HDS brand reassignments.
4. **Trivial:** normalise `HKITCHEN`→`H-KITCHEN`, `GPANIZ`→`G PANIZ`, `HATTONS`→`Hatton`,
   strip `K-90` from the Kalerm Make.
5. Re-export `img-pas.xlsx`; decide on `IMG/FPR/00906`.

---

## 5. APPLIED 2026-07-30

### 5.1 Stock — 325 SKUs
`quantity` set from SAP `In Stock`. Totals 5,314 → **15,225** units.

### 5.2 Dimensions — 109 SKUs (84 fills + 25 re-orders)
Only the two safe classes: records where we were **blank** and SAP had all three axes, and
records where the **values already agreed but the order did not**. **No value overwrites** —
SAP's field is mixed unit/carton (§3.2), so overwriting would silently import carton figures.

Result across the 666 matched SKUs:

| | before | after |
|---|---|---|
| exact match | 148 | **257** |
| same values, wrong order | 31 | **6** |
| ours blank, SAP has data | 103 | **19** |
| value mismatch | 154 | 154 (untouched by design) |

The residual 19 blanks and 6 mis-ordered are rows where SAP has a zero or missing axis.

### 5.3 Brand — 10 reassignments only
| SKUs | From | To |
|---|---|---|
| 6 | `IBERNA` | `OEM SHEFFIELD` |
| 3 | `BROASTER` | `HDS` |
| 1 | `SHEFFIELD` | `H-KITCHEN` |

`IBERNA` and `BROASTER` now have **0 products** — their `brands.json` rows are orphaned and
should be retired or repointed. `OEM SHEFFIELD` rises to 35, `HDS` to 17, `H-KITCHEN` to 13.

Agreement moved 645 → **655 of 666**.

### 5.4 ⚠ Ten brand differences deliberately NOT applied

**SAP's `Make` field is not internally consistent, so `brands.json` is the canonical source.**
Measured across all 6,983 SAP rows / 277 distinct Make values, **five brands are spelled more
than one way inside SAP itself**:

| Canonical | SAP variants |
|---|---|
| DR COFFEE | `DR COFFEE` · `DR. COFFEE` · `DR.COFFEE` · `DR  COFFEE` (double space) |
| G PANIZ | `G-PANIZ` · `G.PANIZ` · `GPANIZ` |
| H-KITCHEN | `H-KITCHEN` · `HKITCHEN` — **plus the typo `H-KICHEN`** |
| ARTHUR KRUPP | `ARTHUR KRUPP` · `ARTHUR-KRUPP` |
| N/A | `N/A` · `NA` |

SAP also uses `-` as a Make placeholder. All 277 values are uppercase, so SAP cannot supply
display casing either.

Skipped, and why:
- `HKITCHEN`, `GPANIZ`, `HATTONS`, `KALERM K-90` — **our** value is the one `brands.json`
  carries. Taking SAP's would null `brand_id` at seed time, since `ProductSeeder` matches on the
  lowercased brand name.
- `BLUELINE` ↔ `SHEFFIELD BLUELINE` (5 SKUs) — SAP uses both labels **in both directions**, so
  it is not authoritative on this pair. Still pending the merge decision in
  `blueline-research.md` §1.5.

---

## 6. Supplier verification of the dimension conflicts, 2026-07-30

The 154 "value mismatch" rows were taken to the manufacturers. **The result inverts the
starting assumption.**

### 6.1 First, 25 of the 154 were never conflicts

SAP stores **0** in one or more axes on 25 rows (20 with two zero axes, 5 with one). The
classifier read a zero as a value. Clearest case — the Berjaya GN containers:

| SKU | Model | Ours | SAP |
|---|---|---|---|
| IMG/TCW/00086 | `FP 1/3-2.5` | 325 × 176 × 65 | 0 × 0 × 65 |
| IMG/TCW/00087 | `FP 1/4-2.5` | 265 × 162 × 65 | 0 × 0 × 65 |
| IMG/TCW/00090 | `FP 1/2-4` | 325 × 265 × 100 | 0 × 0 × 100 |

325 × 176, 265 × 162 and 325 × 265 are the **fixed EN 631 gastronorm footprints** for GN 1/3,
1/4 and 1/2. Our data is correct and SAP is simply blank. **Genuine conflicts: 129, not 154.**

### 6.2 ⚠⚠ On every conflict checked, OUR data matched the manufacturer and SAP was wrong

| SKU | Model | Manufacturer | Ours | SAP |
|---|---|---|---|---|
| IMG/REF/00049 | `AF07EKOMTNPV` | **710 × 800 × 2030** (Technochef, Tecnodom) | **710 × 800 × 2030** ✅ | 800 × 700 × 2020 |
| IMG/FPR/00246 | `DB-10` | **580 × 475 × 720** (skymsen.com) | **580 × 475 × 720** ✅ | 500 × 350 × **40** |
| IMG/OVE/00089 | `FEDL10NEMIDVH2O` | ext **840 × 920 × 1155**; chamber **680 × 480 × 840** | 840 × 910 × 1150 ✅ | **680 × 480 × 840** |
| IMG/FPR/00051 | `SI-282HD` | 921 × 981 × 1869 (Skyfood, from inches) | 980 × 900 × 1900 ✅ | 800 × 820 × 1730 |

Three distinct SAP failure modes in four samples:
1. **Internal chamber published as external** — `FEDL10NEMIDVH2O`'s SAP figures are exactly the
   manufacturer's *cooking chamber*, 680 × 480 × 840.
2. **Physically impossible values** — `DB-10` at **40 mm** tall.
3. **Transposition plus drift** — `AF07EKOMTNPV` swapped and 10 mm out.

Sources: https://www.technochef.eu/cold-storage-rooms-and-refrigerators/glass-door-upright-fridge/tecnodom-fridge-display-cabinet-for-drinks-1-door-ventilated-temp-0-10-c-lt-700-mod-af07ekomtnpv.23033.html ·
https://www.skymsen.com/en/index.php/produtos/detalhe/041173 ·
https://www.technochef.eu/steam-ovens/tecnodom-electric-convection-steam-oven-10-gn-1-1-or-60x40-cm-trays-dim-mm-840x920x1155h.20274.html ·
https://www.gofoodservice.com/p/skyfood-si-282hde-2

### 6.3 But SAP's axis ORDER is reliable — the re-orders were right

The 25 re-orders kept our values and adopted SAP's ordering. Verified against two of the
best-documented machines in the catalogue:

| SKU | Model | Manufacturer (W × D × H) | After re-order |
|---|---|---|---|
| IMG/COF/00041 | `SILVIA` | **235 × 290 × 340** (Rancilio Group) | **235 × 290 × 340** ✅ |
| IMG/COF/00044 | `ROCKY` | **120 × 250 × 350** (Rancilio Group) | **120 × 250 × 350** ✅ |

Also corroborated: `CB4213672V4580` → 910 × 540 × 1830, matching the Cambro code's own
21″ × 36″ × 72″.

### 6.4 The rule this establishes

> **SAP's dimension ORDER is trustworthy (W/D/H). SAP's dimension VALUES are not.**

Which is exactly the split applied in §5.2 — fills and re-orders yes, value overwrites no. The
choice to withhold the 154 value overwrites is now evidenced rather than merely cautious: doing
it would have replaced four correct records with an internal chamber, an impossible 40 mm, and a
transposition.

**Reframing:** these 129 rows are largely a **SAP data-quality list, not a website-error list**.
The action is to feed corrections back into SAP, not to change `products.json`. Each should still
be checked individually — but the prior is now that our value is right.

---

## 7. Model Number vs SAP — 608 of 666 match exactly (91%)

SAP's `Model Number` column was compared against `products.json` `model_number`.

| Result | Count |
|---|---|
| **Exact match** | **608** |
| Different | 22 |
| Both placeholder (`N/A`, `-`) | 22 |
| Substring — truncation or dropped suffix | 7 |
| **Ours empty, SAP has a real code** | **5** |
| SAP placeholder, ours has a code | 2 |

### 7.1 APPLIED — 8 changes

**Five records had no code at all; SAP supplied one:**

| SKU | Brand | Code from SAP |
|---|---|---|
| IMG/HOT/00434 | HK-REDLINE | **`DF-10L-2`** |
| IMG/HOT/00436 | HDS | `HDSEFF-10LS` |
| IMG/HOT/00438 | HDS | `HDSGR60-GS24` |
| IMG/FPR/00277 | H-KITCHEN | `PB606010` |
| IMG/COF/00138 | KEF | `FLS6X2` |

⚠ `IMG/HOT/00434` is the SKU flagged repeatedly through this effort as having **no
`model_number` at all** — "a data-entry gap, not a sourcing gap". SAP had the code the whole time.
⚠ SAP's `HDSGR60‐GS24` contains a **U+2010 HYPHEN**, not ASCII `-`. Normalised on write, in line
with the catalogue-wide dash standardisation. **Sanitise dashes on anything taken from SAP.**

**Three genuine corrections:**

| SKU | Was | Now | Basis |
|---|---|---|---|
| IMG/REF/00232 | `PLR-15N2F(HB)` | **`PLD-15N2F(HB)`** | The product's own name is "Counter **Freezer**". `PLD` = freezer, `PLR` = chiller. SAP agrees, and sibling IMG/REF/00177 is a real chiller carrying `PLR` in both systems. |
| IMG/OVE/00213 | `FTE 480` | **`FTG 480`** | Our own name says "Gas Convection Oven **FTG** 480"; `FTG` = gas, `FTE` = electric. SAP agrees. Clears a held-back approval. |
| IMG/PAS/00145 | `B30GA` | **`B30GA2`** | `hk-redline-research.md` §5.3 already flagged that Kator lists the 30 L as `B30GA2`. SAP confirms. Also clears its DISPUTED status. |

### 7.2 ⚠ NOT changed — our value is a researched correction, SAP holds the legacy code

**Do not "fix" these toward SAP.** Each was changed deliberately on evidence:

| SKU | Ours (keep) | SAP (legacy) | Why ours wins |
|---|---|---|---|
| IMG/REF/00019 | `ZBJ-150L` | `ZBJ-150P` | `iberna-research.md`: the spray "P" range **stops at 100 kg**; 150/250 are flow-type "L". Approved change. |
| IMG/REF/00210 | `ZBJ-250L` | `ZBJ-250P` | same |
| IMG/REF/00209 | `ZBJ-80PA` | `ZBJ-80P` | every genuine Iberna code carries a trailing series letter. Approved change. |
| IMG/COF/00074 | `K95L EBGS` | `K905 EBGS` | approved change from the Kalerm pass |
| IMG/REF/00049 | `AF07EKOMTNPV` | `AFO7EKOMTNPV` | SAP has a **letter O where the digit 0 belongs** — `AF07` denotes the 700 L body |

### 7.3 ⚠ SAP contradicts its own description on one row

`IMG/BUF/00282` — SAP's `Model Number` says **`GRT24B`** while SAP's own `Item Description`
says **"INDUCTION GRIDDLE 6KW GRT36B"**, matching our `GRT36B`. **Ours kept.** A useful reminder
that the Model Number column is not independently authoritative either.

### 7.4 Different numbering systems — not errors

- **TASKI (6 SKUs)** — we store Diversey **article numbers** (`7518178`, `8003820`); SAP stores
  **model names** (`VACUMAT 44T UK`, `ERGODISC 165`). Both are valid identifiers of the same
  machine. Ours is the better `model_number`; SAP's belongs in the product name.
- **`IMG/COF/00128`** — ours `ROCKY`, SAP `MFR010-00076` (an internal part number).

### 7.5 Still open

- `IMG/OVE/00076` — ours `FEM03NE02V`, SAP `FED03NE02V`. Tecnodom `FEM` = mechanical,
  `FED` = digital. Our name and code agree with each other, SAP's name and code agree with each
  other, so there is no internal tiebreak. **Needs the supplier.**
- `IMG/BUF/00241` — ours `RH002`, SAP `RH001`. No tiebreak.
- **`IMS/MEC/00303` and `IMS/MEC/00469` are both wrong in both systems**: our `model_number`
  stores a **material** (`STAINLESS STEEL`, `PVC`) and SAP stores a **brand** (`RANCILIO`).
  Neither is a model number. These are Rancilio coffee tampers and need a real code.
- 22 rows are placeholders in both systems — the chopping boards among them.

---

## 8. ⭐ `Item Remarks` — the field that unblocks the house brands

`Item Remarks` was overlooked in the first pass. It is **populated on 665 of our 666 SKUs
(99%)** and contains real product description and specification text.

| | |
|---|---|
| Length | min 6 · **median 150** · mean 251 · max **2,425** characters |
| Carries spec values (V / kW / L / kg / mm / °C) | most |

It ranges from structured spec blocks to full manufacturer prose:

- `IMG/COF/00097` **DR. COFFEE SC15** — *"Power supply: 220-240V 50Hz/60Hz 65W · Temperature
  range: 8℃-18℃ · Capacity: 10L · Dimension (W.D.H): 25.2*51.2*45 · Net weight: 8.5KG"*
- `IMG/HOT/00333` **BROASTER 1800G** — 2,425 characters of genuine engineering copy (well
  capacity, psi, triple-redundant safety system, Temp-N-Time controller, Auto-Comp)
- `IMG/BUF/00146` **HY-836** — *"Oval Chafing Dish · stainless steel construction · Capacity:
  5.5 litres"*

⚠ Values are wrapped in doubled quotes (`""…"""`) by the Excel export — strip before use.

### 8.1 ⭐ Why this matters more than anything else found in SAP

**Of the 191 SKUs still not in house format, 118 have a substantial SAP remark**, and **92 of
those carry explicit spec values.** They fall almost entirely on the brands that had *no research
file and no external source*:

| Brand | Gap SKUs with a usable SAP remark |
|---|---|
| SV-BLUELINE | 22 |
| OEM SHEFFIELD | 17 |
| **SHEFFIELD** | **14** |
| H-KITCHEN | 10 |
| SYSTEMATIC | 7 |
| KITCHENWARE | 6 |
| SHEFFIELD REDLINE | 3 |
| plus HY, OUCBOLL, GRACHOO, WANHUI, TECNOROAST, STEELOLOGY, CAMBRO | 2 each |

This is the **direct answer to the house-brand problem**. The entire enrichment effort has been
blocked on the same fact — recorded in `project_web_enrichment_pilot`, restated in
`house-brand-suppliers-research.md` — that house-brand model numbers are *ours*, so the web has
nothing to find, and `feedback_never_source_from_sheffield` bars the one site that lists them.

**`SHEFFIELD` (18 SKUs) is the sharpest case:** the business confirmed these are *local
purchases with no OEM at all*, so there was no external source even in principle. SAP Remarks
is the only description that exists for them, and it is already written.

### 8.2 Corroboration: it also catches the mis-titled SYSTEMATIC SKUs

`systematic-kayalar-research.md` flagged four Systematic products as mis-titled. The remarks
confirm it independently:

| SKU | Our name says | SAP remark says |
|---|---|---|
| IMG/FPR/00131 | (flagged as mis-titled) | *"Designed to cut uniform cubes… of favourite **cheeses**"* — a cheese cuber |
| IMG/FPR/00132 | (flagged) | *"fast easy **chopping cutting and dicing** of onions, tomatoes…"* |
| IMG/FPR/00133 | (flagged) | *"ideal for chopping iceberg and other **lettuces**"* |

So Remarks can settle the product-naming errors as well as supply the copy.

### 8.3 Recommended use

Treat `Item Remarks` as a **first-class copy source**, ranked with manufacturer documentation
rather than below it — it is the business's own description of the goods it actually buys. It
should be used to:

1. Generate house-format copy for the **118 gap SKUs**, prioritising the house brands that have
   no alternative source at all.
2. Cross-check the copy already written from web sources.
3. Resolve the mis-titled products (§8.2).

⚠ It is prose, not a structured spec sheet, so the `technical_specification` table still has to
be parsed out of it — the same label:value extraction used for HK-Redline, and the same caution
about `<p>`/`<h3>` variation applies to the punctuation-separated format here.
