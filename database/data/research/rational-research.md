# Rational - research (SAP-led redo)

52 SKUs: 8 `GROUP/` variable parents + 44 real sellable items. **20 of the 44 were invisible
to every earlier pass** - see `variant-children-gap-research.md`. This is the first Rational
pass that covers them.

Almost none of this brand is combi ovens. It is Rational **original accessories** (GN trays,
grids, containers, spikes, multibakers) and **care chemicals** (care/cleaner/rinse tabs,
cartridges). That matters for sourcing: every item is identified by a Rational article number,
in one of two formats - `6013.1103` or `60.73.671`.

---

## 1. Sources

- Six official Rational catalogues, 28 MB, 159 pages, primarily
  https://www.rational-online.com/media/downloads/en-us/prospects/21-677-unit-and-accessories-catalog-en-us.pdf
  These carry the authoritative article-number-to-size mapping.
- https://www.webstaurantstore.com for product photography, matched on exact article number.

Dead end: **Partstown's CDN is a trap.** `partstown.sirv.com/products/RATL/RATL<code>.view` is
a derivable URL that returns HTTP 200 and a valid 1500x1500 JPEG for *any* code - but it is a
placeholder. 28 codes returned **byte-identical** files (one MD5 across all 28). `.jpg`, `.png`
and `?format=jpg` variants all return the same placeholder. Never accept these.

---

## 2. All four model_number disagreements resolve in OUR favour

**Three are Excel numeric coercion in the SAP export, not data errors.** The article number was
read as a number and its trailing zeros discarded:

| SKU | ours | SAP | |
|---|---|---|---|
| IMG/OVE/00022 | 6035.1010 | 6035.101 | trailing 0 lost |
| IMG/OVE/00024 | 6019.1150 | 6019.115 | trailing 0 lost |
| IMG/OVE/00050 | 6015.1000 | 6015.1 | trailing 000 lost |

This is a **new class of SAP defect** - a spreadsheet artifact affecting any numeric-looking
code. Worth checking on other brands whose article numbers end in zero.

**The fourth is SAP contradicting itself, exactly as at Tecnodom.** `IMG/OVE/00059`: SAP's
Model field says `6013.1003`, but SAP's own Description says "ROASTING AND BAKING TRAY BAKING
**2/1GN**". Both codes are real Rational parts, but they are different products:

- `6013.2103` = 2/1 GN (650 x 530 mm)  <- ours
- `6013.1003` = Bakery standard (400 x 600 mm)
- `6013.1103` = 1/1 GN (325 x 530 mm)  <- our IMG/OVE/00058

Our stored 650 x 530 matches 2/1 GN exactly, and the SKU's own attribute reads `21-gn`. Four
signals agree against SAP's Model field. **No model_number changes are needed for Rational.**

---

## 3. Catalogue layout trap - orientation differs per catalogue

The catalogues do not agree on layout. The US catalogue prints `<code> <label>`; the GB/EU ones
print `<label> N°: <code>`. Reading "the label after the code" is therefore correct in one and
**off by one product** in the other - the first extraction run had `6013.1103` (1/1 GN) coming
back as 2/1 GN, because it had picked up the next entry's label.

The parser now detects orientation **per file** against anchors established independently
(`6013.1103`=1/1, `6013.2103`=2/1, `60.73.671`=2/3), then applies that orientation to the whole
file. 5 of 6 catalogues resolve; `KA_V002_en_Spare_parts_of_accessories.pdf` demonstrates
neither orientation and is skipped rather than guessed at. All three anchors verify after the
change. 35 of 46 codes resolved.

---

## 4. Dimensions checked against the official GN standard

Rational sizes are GN, so the official label implies exact millimetres:
1/1 = 530x325, 2/3 = 354x325, 1/2 = 325x265, 1/3 = 325x176, 2/1 = 650x530,
Bakery standard = 600x400.

**18 SKUs verified correct** against their official GN footprint.

**1 genuine defect: `IMG/OVE/00049` (Multibaker, 60.73.764).** Stored 325 x 625. It is 1/3 GN,
so it should be **325 x 176**. 625 corresponds to no GN dimension. Four independent
confirmations of 1/3 GN: SAP's description "MULTIBAKER 1/3 GN", the SKU's own `gn-size=13-gn`
attribute, the catalogue's "1/3 GN (12" x 7")", and both siblings following the same convention
(`60.71.157` 1/1 = 530x325 correct, `60.73.646` 2/3 = 354x325 correct). SAP has 0/0/0 here so
it cannot arbitrate, but it does not contradict.

**7 SKUs have no dimensions stored and the catalogue can fill them:**

| SKU | code | official |
|---|---|---|
| IMG/OVE/00025 | 60.73.619 | 2/3 GN, 354 x 325 |
| IMG/OVE/00041 | 6010.2301 | 2/3 GN, 354 x 325 |
| IMG/OVE/00064 | 6010.1101 | 1/1 GN, 530 x 325 |
| IMG/OVE/00108 | 6015.1165 | 1/1 GN, 530 x 325 |
| IMG/OVE/00024 | 6019.1150 | 1/1 GN, 530 x 325 |
| IMG/OVE/00054 | 6035.1019 | 1/1 GN, 530 x 325 |
| IMG/OVE/00055 | 6035.1018 | 1/1 GN, 530 x 325 |

Note on the granite-enamelled containers (`6014.1106`, `6014.2306`): these are **pans with
depth**, so the third dimension is 60 mm and the GN figure is the footprint. Their width/height
were transposed and were corrected in the variant-children pass; they now read
530 x 325 x 60 and 354 x 325 x 60, which is right.

---

## 5. Images - 54 files across 24 SKUs, and 17 rejections that mattered

WebstaurantStore search **substitutes near-miss article numbers**, so a result is accepted only
when the exact code appears in the product URL slug. That guard rejected 17 of 43, and in every
single case the offered product was the wrong one:

| we asked for | search offered | what it actually is |
|---|---|---|
| 60.73.764 | 60-73-768 | stacking kit, not a Multibaker |
| 60.73.798 | 60-73-768 | stacking kit |
| 6014.2306 | 6014-2106 | different GN size |
| 6014.2302 | 6014-2102 | different GN size |
| 6010.2301 | 6010-2101 | different rack grid |
| 6015.1165 | 6015-1103 | different tray |
| 60.73.671 | 60-73-271 | small round roasting pan |
| 60.22.086 | 60-31-086 | different trolley |
| 60.73.646 | 60-71-643 | spatula |
| 60.73.619 | 60-73-612 | pan basket cart |
| 60.61.047 | 60-31-044 | open-back unit |
| 6015.1000 | 6015-1103 | different tray |

Every one would have been a wrong product photo on a live SKU. Ranking alone is not evidence.

Staged: 54 files, mostly 2000x2000, named `<SKU>__<code>-webstaurant-N.jpg`. Verified by eye:
`6013.2103` shows a dark TriLax-coated roasting tray, matching "Roasting/Baking Tray, Coated".

---

## 6. Still open

- **17 SKUs need images** from another source - the rejections above, plus `9006.0137`,
  `6006.011`, `56.01.628`, `56.00.22`, `60.22.086`, `60.61.047`.
- `IMG/HYS/00264` / `IMG/HYS/00265` matched but their pages carry no product image.
- **`IMG/HYS/00034` and `IMG/HYS/00035` share one article number** (`56.00.562`, Care Tabs) and
  differ only as "Tablets" vs "Tabs Loose". Worth confirming with the business whether these
  are genuinely two sellable items or a duplicate.
- `IMG/OVE/00027` (Connection Kit) has no model number at all, in ours or SAP.
- The 1 dimension correction and 7 fills in section 4 are **researched, not applied**.
