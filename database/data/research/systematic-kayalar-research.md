# Systematic & Kayalar Product Research

Research notes behind a combined **SYSTEMATIC** (7 SKUs) and **KAYALAR** (6 SKUs) audit pass on
`products.json` (July 2026). Two unrelated brands, kept in one file because they were scoped
together; findings are fully separated below.

**No `products.json` or `brands.json` changes have been applied** - this file is findings only,
same starting point as the Cambro, Brema and Santos passes before a scope decision.

Headline, in one line each:

- **KAYALAR is a real, fully identified manufacturer** - Kayaplas Kayalar Plastik (Istanbul), whose
  `EURORACKS` dishwasher-rack line matches our five rack SKUs exactly, right down to compartment
  counts, cell sizes and extender heights. Its official catalogue was recovered and is the source
  for everything in Part A. But **our stored `model_number` values are not Kayaplas codes** - they
  do not fit the published grammar and return zero hits anywhere on the web.
- **SYSTEMATIC is not a manufacturer at all.** No such company exists in foodservice equipment, the
  `JS` codes return zero external hits, and at least three of the seven descriptions are lifted
  near-verbatim from **Nemco** (US) product copy for *different machines than the names claim*.
- **One record, `IMG/FPR/00110`, is wholly corrupted** - a "Potato Chipper Table Top" carrying a
  **Waring spice-grinder image and a Waring spice-grinder description**. This is the worst
  single-record contamination found in any pass so far.

---
---

# PART A - KAYALAR

## A1. Brand identification

**KAYALAR = Kayaplas Kayalar Plastik San. ve Tic. A.Ş.**, an industrial plastics manufacturer in
Türkoba Mah., Kayalar Cad., Büyükçekmece, Istanbul, Turkey. Its foodservice warewashing line is
branded **EURORACKS** ("Hygiene Dishwasher Racks / Hijyen Bulaşık Basketleri"), moulded into the
rack bodies themselves.

Primary sources:

https://www.kayalarplastik.com
https://www.kayalarplastik.com/en/kataloglar
https://kayalarfile.oss-eu-central-1.aliyuncs.com/catalog/20260324/pdf/Bulasik_Basket_Katalog_C5.pdf

That last URL is the **official "Bulaşık Sepetleri / Dishwasher Racks" catalogue (section C5)**,
18 pages, and is the authority for every dimension, code and cell size quoted below. A copy is
staged at `kayalar-images/_brand-reference/kayaplas-dishwasher-racks-catalogue-C5.pdf`.

Third-party confirmation that Kayaplas is the maker of the glass-rack range and that its codes are
carried through unchanged by Turkish distributors:

https://www.bayraktarmutfak.com.tr/kayalar-49-bolmeli-bardak-yukseltici-50x50x45-cm-kahverengi-152088248
https://www.bayraktarmutfak.com.tr/arama?q=bardak+yukseltici

### ⚠ Four different Turkish "Kayalar" companies - do not confuse them

This is the main trap in this brand. Searching "Kayalar" plus kitchen terms returns four unrelated
firms, three of which are wrong for us:

| Company | Site | What they make | Ours? |
|---|---|---|---|
| **Kayaplas Kayalar Plastik** | https://www.kayalarplastik.com | Injection-moulded PP dishwasher racks (`EURORACKS`), pallets, containers | ✅ **YES** |
| Kayalar Endüstriyel Mutfak | https://www.kayalarmutfak.com.tr | Stainless dishwashers, ovens; resells racks under 11-digit `990800101xx` codes | ✗ |
| KM Kayalar | https://www.kayalarmutfak.com | Industrial dishwashers; rack codes like `294.KBB16K` | ✗ |
| Kayalar Plast (Adana) | https://www.kayalarplast.com | Plastic packaging, Adana | ✗ |

Kayalar Endüstriyel's own extender page is nonetheless a useful independent cross-check of the
family geometry (500 × 500 mm, 3×3 / 4×4 / 5×5 / 6×6 / 7×7):

https://www.kayalarmutfak.com.tr/TR/basket-yukseltici

### ⚠ `brands.json` has **no KAYALAR row at all**

Confirmed: `database/data/brands.json` contains 105 brands and **none of them is Kayalar**. Six
products (`IMG/FPR/00110`, `IMG/DWW/00071`-`00075`) point at a brand that does not exist. This is a
dangling brand link and will break any brand-page or brand-filter route that assumes the row is
present. Recommended row is in §A6.

---

## A2. Decoding the real Kayaplas code grammar

Kayaplas numbers are **9 digits and fully systematic**. Every code in the warewashing section is:

```
152 0 8 [7|8] [family] [n] 8
 |        |       |      |
 |        |       |      +-- compartment index: 0=9, 1=16, 2=25, 3=36, 4=49
 |        |       +--------- sub-family within racks / extenders
 |        +----------------- 7 = rack (basket), 8 = extender (yükseltici)
 +-------------------------- 152 08 = warewashing product group
```

### A2.1 Glass racks - "Bölümleyicili Bardak Basketi / Glass Rack N Compartment"

All 50,1 × 50,1 × 10,1 cm, 6 per box.

| Code | Compartments | Layout | Catalogue page |
|---|---|---|---|
| `152087508` | - (open base rack, "Temel Basket") | - | 3 |
| `152087528` | - (plate rack, "Tabak Basketi") | - | 3 |
| `152087608` | 9 | 3×3 | 80 |
| **`152087618`** | **16** | **4×4** | **80** |
| `152087628` | 25 | 5×5 | 82 |
| **`152087638`** | **36** | **6×6** | **82** |
| **`152087648`** | **49** | **7×7** | **84** |

### A2.2 Extenders with divider - "Bölümleyici Yükselticiler / Extenders with Divider"

All **8,25 cm high**, 12 per box. This is the height that each extender adds to a stack.

| Code | Compartments | Layout | Cell size (cm) | Height (cm) |
|---|---|---|---|---|
| `152088108` | 9 | 3×3 | 15 × 15 | 8,25 |
| **`152088118`** | **16** | **4×4** | **11,2 × 11,2** | **8,25** |
| `152088128` | 25 | 5×5 | 8,9 × 8,9 | 8,25 |
| **`152088138`** | **36** | **6×6** | **7,4 × 7,4** | **8,25** |
| **`152088148`** | **49** | **7×7** | **6,2 × 6,2** | **8,25** |

### A2.3 A second, lower extender family (4,5 cm) exists

Distributor listings show `1520882n8` codes at **50 × 50 × 4,5 cm** - a shallower extender than the
8,25 cm catalogue range, same compartment-index digit:

| Code | Compartments | Dimensions | Source |
|---|---|---|---|
| `152088228` | 25 | 50 × 50 × 4,5 cm | https://www.bayraktarmutfak.com.tr/arama?q=bardak+yukseltici |
| `152088248` | 49 | 50 × 50 × 4,5 cm | https://www.bayraktarmutfak.com.tr/kayalar-49-bolmeli-bardak-yukseltici-50x50x45-cm-kahverengi-152088248 |

The compartment-index digit (`2`→25, `4`→49) holds across both families, which is what confirms the
grammar rather than just fitting one table.

### ⚠ Kayaplas's own catalogue contains copy-paste errors in the English column

Worth recording, because anyone reading only the English product name will be misled:

- Page 82, `152087628`: Turkish reads "25 Böl.Bardak Basketi", English reads "Glass Rack **36**
  Comp." - wrong.
- Page 84, `152087648`: Turkish reads "49 Böl.Bardak Basketi", English reads "Glass Rack **36**
  Comp." - wrong.

The **Turkish** column and the section headings (`25 BÖLÜMLEYİCİLİ`, `49 BÖLÜMLEYİCİLİ`) are correct.
This is the same failure mode as our own sibling contamination, occurring inside the manufacturer's
source document.

### Common features (all racks and extenders)

From catalogue pages 84-85 and the certification strip on every product table:

- Material: **PP** (polypropylene), with HDPE marked alongside; food-contact certified
  (glass-and-fork symbol), CE, ISO, "Made in Türkiye", recyclable
- Colours: **RAL 7000** (squirrel grey), **RAL 3000** (flame red), **RAL 1018** (zinc yellow),
  **RAL 6020** (chrome green), **RAL 5022** (night blue); custom colours to order
- Inclined bottom hole windows so water and waste drain out rather than pooling
- Enlarged elliptical water channels for full wash coverage
- Increased edge angle so racks and extenders stack and interlock cleanly
- Logo printing available on high-volume orders
- Racks: 6 per box, 3000 per truck, 2574 per 40 HC
- Extenders: 12 per box, 6000 per truck, 5148 per 40 HC

---

## A3. ⚠ Our stored `model_number` values are **not** Kayaplas codes

This is the central negative finding for this brand.

| SKU | Stored `model_number` | Fits Kayaplas grammar? | Web hits |
|---|---|---|---|
| IMG/DWW/00071 | `153114021` | ✗ | 0 |
| IMG/DWW/00073 | `153114022` | ✗ | 0 |
| IMG/DWW/00072 | `153114030` | ✗ | 0 |
| IMG/DWW/00074 | `153114033` | ✗ | 0 |
| IMG/DWW/00075 | `KAY 37` | ✗ | 0 |
| IMG/FPR/00110 | `153155040` | ✗ | 0 |

They are the right *shape* - 9 digits, `15` prefix - but the wrong *stem*. Every real Kayaplas
warewashing code begins `15208`; ours begin `15311`/`15315`. Searches on the bare literals return
nothing on Turkish distributors, on Kayaplas's own site, or on general web search:

https://www.bayraktarmutfak.com.tr/arama?q=153114021
https://search.brave.com/search?q=%22Kayalar%22+patates+dilimleme+makinesi+tezgah+%C3%BCst%C3%BC+153155040

**Verdict: these are Sheffield-internal or middleman-distributor item numbers, not manufacturer
part numbers.** They cannot be validated against anything and should not be presented to customers
as manufacturer codes.

### A3.1 What the last three digits appear to mean - and where the pattern breaks

Sorted by code against the stored names:

| Code | Last 3 | Stored name |
|---|---|---|
| `153114021` | 0-2-1 | 16 compartments, **1** extender |
| `153114022` | 0-2-2 | 16 compartments, **2** extenders |
| `153114030` | 0-3-0 | **36** compartments, 2 extenders |
| `153114033` | 0-3-3 | **49** compartments, 1 extender |

Read as `0 - [tier] - [extender count]`:

- `021` and `022` are **perfectly consistent**: tier `2` = 16 compartments, final digit = extender
  count 1 and 2. Both names match.
- `030` and `033` **break**. They share tier `3`, so they should be the *same compartment count* -
  but the stored names give one as 36 and the other as 49. And their final digits (0 and 3) do not
  match the stored extender counts (2 and 1).

**Conclusion: at most one of `IMG/DWW/00072` and `IMG/DWW/00074` can carry the right compartment
count, and neither carries an extender count consistent with its code.** Under the tier reading,
`153114030` = tier-3 rack with **0** extenders and `153114033` = tier-3 rack with **3** extenders -
which would mean the catalogue is missing a 36/49 distinction entirely and two of these five SKUs
are misnamed. This is a hypothesis, not a proof: without the source price list the codes are
unverifiable, which is itself the recommendation (§A6).

### A3.2 ⚠ `KAY 37` verdict (`IMG/DWW/00075`)

`KAY 37` is **not a model number**. Five siblings in the same family carry 9-digit numerics; this
one carries a 3-letter-plus-2-digit token that matches no grammar in the family, no Kayaplas code,
and returns nothing on the web. `KAY` is simply an abbreviation of the brand name.

Given the `0-[tier]-[extender]` reading, the natural sibling code for "49 compartments, 2 extenders"
would be a `1531140xx` value - most likely the one immediately adjacent to whichever of `030`/`033`
is genuinely the 49-compartment line. **Do not guess it into the field.** Per the standing rule that
`model_number` is the unique ID, leave `KAY 37` in place, record here that it is bogus, and only
replace it when the source list is available.

The strongest defensible replacement, if the decision is to switch to real manufacturer codes
entirely, is Kayaplas's own pairing (see §A6): rack `152087648` + 2 × extender `152088148`.

### A3.3 Price evidence contradicts the extender counts

| SKU | Name | Price (KES) |
|---|---|---|
| IMG/DWW/00071 | 16 comp, **1** extender | 7,590 |
| IMG/DWW/00073 | 16 comp, **2** extenders | **7,590** |
| IMG/DWW/00072 | 36 comp, 2 extenders | 9,430 |
| IMG/DWW/00074 | 49 comp, 1 extender | **9,430** |
| IMG/DWW/00075 | 49 comp, 2 extenders | **9,430** |

An extender is a separately moulded part with its own catalogue code and its own carton quantity.
A kit with two of them **cannot** cost the same as a kit with one. Prices here vary only with
compartment count, never with extender count. Either the extender counts in the names are wrong, or
the prices are. Independent support for the §A3.1 conclusion.

---

## A4. Per-SKU findings - Kayalar

All five rack SKUs are `archived` and are **empty shells**: `image` is `""`, `short_description` is
`""`, and there is no `description`, no `technical_specification`, no `length`/`width`/`height`, no
material, no colour, no weight. There is therefore **no sibling contamination between them** - there
is nothing there to contaminate. The problem is total absence of content, not cross-pasting.

Derived geometry, computed from the Kayaplas catalogue (rack 10,1 cm + 8,25 cm per extender):

| SKU | Config | Rack code | Extender code | Cell (cm) | Overall stack height |
|---|---|---|---|---|---|
| IMG/DWW/00071 | 16 comp + 1 ext | `152087618` | 1 × `152088118` | 11,2 × 11,2 | 10,1 + 8,25 = **18,35 cm** |
| IMG/DWW/00073 | 16 comp + 2 ext | `152087618` | 2 × `152088118` | 11,2 × 11,2 | 10,1 + 16,5 = **26,6 cm** |
| IMG/DWW/00072 | 36 comp + 2 ext | `152087638` | 2 × `152088138` | 7,4 × 7,4 | **26,6 cm** |
| IMG/DWW/00074 | 49 comp + 1 ext | `152087648` | 1 × `152088148` | 6,2 × 6,2 | **18,35 cm** |
| IMG/DWW/00075 | 49 comp + 2 ext | `152087648` | 2 × `152088148` | 6,2 × 6,2 | **26,6 cm** |

Footprint for all five: **50,1 × 50,1 cm** (the European 500 × 500 warewashing standard).

**Max glass height**: Kayaplas does **not** publish one. The overall stack height above is external;
usable internal height is a few millimetres less. Do not invent a max-glass-height figure - state the
stack height and the cell size, which is what the buyer actually needs.

**Width/height axis-swap check**: not applicable to any of the five - no dimension fields are stored
at all. Nothing to swap, and nothing to verify against prose.

**Electrical / Kenya 240 V 50 Hz**: not applicable. These are unpowered moulded PP inserts for a
dishwasher. No phase considerations.

### A4.1 ⚠⚠ IMG/FPR/00110 - "Potato Chipper Table Top Kayalar", `153155040` - **record is entirely a different product**

This is the most serious finding in the pass. The record is `published`.

| Field | Stored value | Reality |
|---|---|---|
| `name` | Potato Chipper Table Top Kayalar | - |
| `category` | Potato Processors | - |
| `image` | `products/potato-chipper-table-top-kayalar-imgfpr00110.jpg` | **A photograph of a WARING commercial spice grinder** (stainless conical body, clear lid, "WARING" badge, LOCK/UNLOCK collar) |
| `short_description` | "**WARING** commercial spice grinder for efficient spice processing…" | Waring copy |
| `description` | "Professional Commercial Spice Grinder … The **WARING** Commercial Spice Grinder is a powerful kitchen machine…" with bullets for *Powerful Motor*, *Grinds various spices, herbs, and dried ingredients* | Waring copy, ~250 words, none of it about potatoes |

Three of the four content fields describe a Waring WSG-series spice grinder. Only the name, the
model number and the category say "potato chipper".

Compounding problems:

- **Waring is a separate live brand in this catalogue** (`brands.json` slug `waring`,
  https://www.waring.com/). So this is not a naming quirk - a Waring product's content has been
  pasted onto a Kayalar record.
- A table-top potato chipper is **manual**. The stored description promises a "Powerful Motor" and
  "High-performance motor", which is factually wrong for the named product either way.
- **Kayaplas does not make potato chippers at all.** Their catalogue set is dishwasher racks, garden
  furniture, waste containers, sunbeds, pallets and crates. There is no plausible route by which a
  potato chipper is a Kayalar product.

**This SKU has no usable content and, on the evidence, the wrong brand.** See §A6.

---

## A5. Images and documents obtained - Kayalar

Destination: `C:\Users\jonah.wakahiu\Desktop\ecommerce\products resource\kayalar-images\`

### A5.1 ⚠ Audit of the 11 files staged by the interrupted previous run

Every staged file was opened and its configuration counted before being trusted. All ten `TMP_*`
images were genuine 500 × 500 rack-family photographs, but **four were not usable for any SKU we
carry**, and the peer's flag was correct.

| Staged file | What it actually shows | Verdict |
|---|---|---|
| `TMP_div9.jpg` | 3×3 = **9-compartment rack**, beige | Correct config, but **no 9-comp SKU exists** → moved to `_brand-reference/` |
| `TMP_div16.jpg` | 4×4 = **16-compartment rack**, grey | ✅ correct → `IMG/DWW/00071`, `IMG/DWW/00073` |
| `TMP_div25.jpg` | 5×5 = **25-compartment rack**, blue | Correct config, **no 25-comp SKU** → `_brand-reference/` |
| `TMP_div36.jpg` | 6×6 = **36-compartment rack**, green | ✅ correct → `IMG/DWW/00072` |
| `TMP_div49.jpg` | 7×7 = **49-compartment rack**, red | ✅ correct → `IMG/DWW/00074`, `IMG/DWW/00075` |
| **`TMP_extender-racks-1.jpg`** | **A 16-compartment EXTENDER** (4×4 shallow divider ring), grey - **not a rack, and not 49-compartment** | ⚠ **This is the file the peer flagged.** Confirmed: it is an extender, and a 4×4 one. Re-filed as the *extender component* of the 16-comp SKUs, which is what it legitimately is |
| `TMP_extender-racks-2.jpg` | A **25-compartment extender** (5×5), blue | Wrong for every SKU we carry → `_brand-reference/` |
| `TMP_base-rack.jpg` | Open, undivided base rack, blue | Not a glass rack → `_brand-reference/` |
| `TMP_empty-extender.jpg` | Undivided extender ring, blue | Not a glass rack → `_brand-reference/` |
| **`TMP_glass-rack-350.jpg`** | ⚠ **A plate/peg rack with a cylindrical cutlery basket** - not a glass rack in any configuration | Mislabelled by the previous run → `_brand-reference/MISLABELLED-plate-peg-rack-not-a-glass-rack.jpg` |

So: **two of the eleven staged files were materially wrong** (the 49-comp mislabelling the peer
caught, and a plate rack filed as a glass rack), and **three more were correct photographs of
configurations we do not sell**.

### A5.2 Final per-SKU files

| File | Pixels | Size | What it shows |
|---|---|---|---|
| `IMG-DWW-00071__glass-rack-16-compartment-4x4.jpg` | 800 × 511 | 71.8 KB | 4×4 = 16-comp rack, grey |
| `IMG-DWW-00071__extender-16-compartment-4x4.jpg` | 700 × 700 | 62.3 KB | 4×4 = 16-comp extender ⚠ under 800 px |
| `IMG-DWW-00071__kayaplas-catalogue-rack-16comp-152087618.jpg` | 717 × 717 | 16.8 KB | Official Kayaplas render, `152087618` ⚠ under 800 px |
| `IMG-DWW-00071__spec-sheet.pdf` | - | 567 KB | Catalogue pp. 80-81 (16-comp rack + 16-comp extender) |
| `IMG-DWW-00073__glass-rack-16-compartment-4x4.jpg` | 800 × 511 | 71.8 KB | as above |
| `IMG-DWW-00073__extender-16-compartment-4x4.jpg` | 700 × 700 | 62.3 KB | as above ⚠ under 800 px |
| `IMG-DWW-00073__kayaplas-catalogue-rack-16comp-152087618.jpg` | 717 × 717 | 16.8 KB | ⚠ under 800 px |
| `IMG-DWW-00073__spec-sheet.pdf` | - | 567 KB | Catalogue pp. 80-81 |
| `IMG-DWW-00072__glass-rack-36-compartment-6x6.jpg` | 800 × 504 | 105 KB | 6×6 = 36-comp rack, green |
| `IMG-DWW-00072__kayaplas-catalogue-rack-36comp-152087638.jpg` | 723 × 723 | 19.2 KB | Official render, `152087638` ⚠ under 800 px |
| `IMG-DWW-00072__spec-sheet.pdf` | - | 582 KB | Catalogue pp. 82-83 (25 + 36 racks, 25 + 36 extenders) |
| `IMG-DWW-00074__glass-rack-49-compartment-7x7.jpg` | 800 × 496 | 88.3 KB | 7×7 = 49-comp rack, red |
| `IMG-DWW-00074__kayaplas-catalogue-rack-49comp-152087648.jpg` | 619 × 413 | 22.3 KB | Official render, `152087648` ⚠ under 800 px |
| `IMG-DWW-00074__spec-sheet.pdf` | - | 480 KB | Catalogue pp. 84-85 (49 rack, 49 extender, common features) |
| `IMG-DWW-00075__glass-rack-49-compartment-7x7.jpg` | 800 × 496 | 88.3 KB | as `00074` |
| `IMG-DWW-00075__kayaplas-catalogue-rack-49comp-152087648.jpg` | 619 × 413 | 22.3 KB | ⚠ under 800 px |
| `IMG-DWW-00075__spec-sheet.pdf` | - | 480 KB | Catalogue pp. 84-85 |
| `IMG-FPR-00110__equivalent-bench-mount-cast-iron-potato-chipper.jpg` | 2000 × 2000 | 188 KB | A real bench-mounted cast-iron potato chipper - **what this SKU should look like**, as opposed to the Waring spice grinder currently stored |

`_brand-reference/`:

| File | Pixels | Notes |
|---|---|---|
| `kayaplas-dishwasher-racks-catalogue-C5.pdf` | 18 pp. | The full official catalogue |
| `kayaplas-glass-rack-selection-wizard-p79.png` | 1240 × 1754 | Kayaplas's "Glass Rack Selecting Wizard" - place the glass on the printed circles, the colour tells you 9/16/25/36/49 and how many extenders (1/2/3). Excellent PDP content |
| `rack-9-compartment-3x3.jpg` | 800 × 500 | No SKU |
| `rack-25-compartment-5x5.jpg` | 800 × 502 | No SKU |
| `extender-25-compartment-5x5.jpg` | 700 × 700 | No SKU |
| `base-rack-open-undivided.jpg` | 800 × 495 | Not a glass rack |
| `extender-undivided-no-dividers.jpg` | 800 × 447 | Not a glass rack |
| `MISLABELLED-plate-peg-rack-not-a-glass-rack.jpg` | 800 × 584 | Plate/peg rack + cutlery basket, mislabelled by previous run |

**Resolution caveat, stated plainly:** the highest-resolution product renders Kayaplas publishes
anywhere are the ones embedded in its own catalogue PDF, and those top out at **723 × 723 px**. They
are below the 800 px bar and cannot be raised without fake upscaling. They are staged as-is and
marked above. The 800 px staged photographs meet the bar; the 700 px extender shots do not.
Nothing was sourced from sheffieldafrica.com.

---

## A6. Recommended changes - KAYALAR

Ordered by severity. Nothing below has been applied.

### 1. ⚠⚠ Rebuild or retire `IMG/FPR/00110` entirely - it is a Waring spice grinder

Currently `published`. Every content field except the name is another product's. Options:

- **(a)** If Sheffield really stocks a table-top potato chipper: purge the Waring image, short
  description and description; write potato-chipper content; move the brand off KAYALAR (Kayaplas
  makes no such machine); source a real image (a correct-type reference is staged).
- **(b)** If the record only ever existed to hold the Waring content: archive it and let the Waring
  spice-grinder SKU own that content.

Do **not** leave it published as-is. A customer clicking "Potato Chipper" and getting a spice
grinder is a live commercial defect.

### 2. Add the missing `brands.json` row

Six products reference a brand that does not exist. Proposed row, following existing conventions:

```json
{
  "slug": "kayalar",
  "name": "Kayalar",
  "description": "Kayaplas Kayalar Plastik is a Turkish industrial plastics manufacturer based in Istanbul. Its EURORACKS line covers dishwasher racks, glass baskets and compartment extenders in the European 500 x 500 mm warewashing standard.",
  "logo": null,
  "website_url": "https://www.kayalarplastik.com",
  "is_active": true
}
```

`website_url` **verified live** and serving product and catalogue pages, no redirect, no domain
migration.

### 3. Do not touch the `model_number` values yet - but record that they are unverifiable

None of `153114021`, `153114022`, `153114030`, `153114033`, `KAY 37`, `153155040` exists outside our
own data. Per the standing rule, preserve them and hold the researched Kayaplas equivalents here:

| SKU | Stored | Kayaplas rack | Kayaplas extender |
|---|---|---|---|
| IMG/DWW/00071 | `153114021` | `152087618` | 1 × `152088118` |
| IMG/DWW/00073 | `153114022` | `152087618` | 2 × `152088118` |
| IMG/DWW/00072 | `153114030` | `152087638` | 2 × `152088138` |
| IMG/DWW/00074 | `153114033` | `152087648` | 1 × `152088148` |
| IMG/DWW/00075 | `KAY 37` | `152087648` | 2 × `152088148` |

### 4. ⚠ Resolve the 36-vs-49 conflict before un-archiving anything

`153114030` and `153114033` share a tier digit but are named with different compartment counts, and
the identical pricing across 1-extender and 2-extender variants says the extender counts are
unreliable too. **Confirm against the physical stock or the supplier price list** which of these five
SKUs is which. Un-archiving them with the current names risks shipping a 36-compartment rack against
a 49-compartment order.

### 5. Fill the empty content - all five racks have nothing

Every rack SKU needs `short_description`, `description`, `technical_specification`, `image`, and the
dimension fields. Verified content available from §A2/§A4:

- Footprint 50,1 × 50,1 cm; rack body 10,1 cm; each extender adds 8,25 cm
- Cell sizes 11,2 / 7,4 / 6,2 cm for 16 / 36 / 49
- Material PP, food-contact certified, CE, ISO, recyclable, made in Türkiye
- Colours RAL 7000 / 3000 / 1018 / 6020 / 5022
- Inclined drain windows, enlarged elliptical water channels, interlocking stacking edges

When writing `length`/`width`/`height`, note the axis-swap trap that bit the Systematic records
(§B4): for these, length = width = 501 mm and height = stack height (183,5 mm or 266 mm).

### 6. Category is arguable

All five sit in `Dishwashers`. They are accessories for a dishwasher, not dishwashers. If a
warewashing-accessories category exists or is cheap to add, they belong there - a customer browsing
`Dishwashers` for a machine will not want five archived plastic baskets in the grid.

### 7. Consider stocking the gaps

Kayaplas makes 9- and 25-compartment racks and matching extenders, plus a plate rack (`152087528`),
an open base rack (`152087508`) and cutlery/tray baskets. We carry only 16/36/49. Reference photos
for 9- and 25-compartment are already staged in `_brand-reference/`.

---
---

# PART B - SYSTEMATIC

## B1. ⚠ Brand identification - there is no such manufacturer

**No foodservice-equipment manufacturer named "Systematic" exists.** This was tested three ways and
failed all three:

1. **Brand search** returns only generic vegetable-slicer retailers plus real brands (Nemco,
   Vollrath, Sammic, Kronitek, Hobart). Brave's own summary: "Too few matches were found."
   https://search.brave.com/search?q=%22Systematic%22+brand+commercial+kitchen+equipment+vegetable+slicer+manufacturer
2. **Model-code search** on every stored code returns zero relevant hits. `JSCV-2200` returns only
   Proto `JSCV-20S` wrench sets; `JSESCJ-300` / `JSJC-12` return Star Citizen, Jet guitars and JCB
   excavators.
   https://search.brave.com/search?q=%22JSCV-2200%22
   https://search.brave.com/search?q=%22JSESCJ-300%22+OR+%22JSJC-12%22
3. **The decisive one.** `JSPCC-08` returns exactly **two** results on the entire web, and **both are
   sheffieldafrica.com** - our own client's storefront. Per the standing rule that Sheffield's own
   site is circular and does not count, the true external hit count is **zero**.
   https://search.brave.com/search?q=%22JSPCC-08%22

**Verdict: SYSTEMATIC is a Sheffield house label applied to unbranded Chinese/Turkish OEM equipment.**
This matches the pattern already recorded for the ~262 house-brand items with a ~0 % external hit
rate. The `JS` prefix is a Sheffield convention, not a manufacturer's.

### `brands.json` row exists but its description is wrong

```json
{"slug": "systematic", "name": "Systematic",
 "description": "Systematic provides commercial kitchen organization and storage solutions. They specialize in shelving systems and kitchen storage equipment for professional environments.",
 "logo": null, "website_url": null, "is_active": true}
```

All seven SYSTEMATIC products are **vegetable-prep and juicing machines**. Not one is shelving or
storage. `website_url` is `null`, correctly - there is no site to point at.

---

## B2. The `JS` code scheme, decoded as far as it goes

The prefix expands consistently as a **function abbreviation**, which is why it looks systematic:

| Code | Reading | Product |
|---|---|---|
| `JSCV-2200` | JS + **C**utter **V**egetable | Rotary vegetable slicer |
| `JSCC-9` | JS + **C**heese **C**utter | Cheese cuber (see §B3.2) |
| `JSEC-08` | JS + **E**asy **C**hopper | Chopper/dicer |
| `JSVC2100` | JS + **V**egetable **C**utter | Lettuce cutter (see §B3.4) |
| `JSPCC-08` | JS + **P**otato **C**hips **C**utter | Potato chipper on stand |
| `JSJC-12` | JS + **J**uicer **C**itrus | Automatic orange juicer |
| `JSESCJ-300` | JS + **E**lectric **S**ugar **C**ane **J**uicer | Sugarcane juicer |

The scheme is a **mnemonic, not a parametric grammar**. Nothing in it encodes capacity, size or
power, and the trailing numbers are inconsistent in meaning (`2200`, `9`, `08`, `2100`, `08`, `12`,
`300`). Because the codes have no external existence, none of this can be validated.

### ⚠ `JSVC2100` - the missing hyphen

`JSVC2100` is the only code in the family without a separator; its six siblings all use one
(`JSCV-2200`, `JSCC-9`, `JSEC-08`, `JSPCC-08`, `JSJC-12`, `JSESCJ-300`). The product name in
`products.json` also carries it without a hyphen ("Manual Vegetable Slicer Systematic JSVC2100"),
and so does the image filename, so the inconsistency is at least *internally* consistent.

**Verdict: a typo, not a real difference.** There is no manufacturer grammar in which the hyphen
carries meaning, since there is no manufacturer. But because `model_number` is the unique ID, do
**not** silently normalise it to `JSVC-2100` - that would break the identity of the record. Flag it,
and change it only as a deliberate, approved edit that also updates the name and the image filename.

---

## B3. ⚠ The descriptions are lifted from **Nemco** - and describe different machines than the names

The four "slicer" SKUs each have a distinct description, so at first glance there is no sibling
contamination. The reason they are distinct is worse: **each was lifted from a different Nemco
product**, and in three of four cases the machine described is not what the SKU is named.

### B3.1 IMG/FPR/00130 - "Manual Vegetable Slicer JSCV-2200" ✅ name is correct

Stored: *"Designed for slicing of fresh vegetables and fruits for salad bars sandwiches pizza
toppings and more. Thickness of the machine can be adjustable from 0.5mm to 8mm. The blade is easy
to disassemble and clean."*

The stored image is a **bench-clamp rotary slicer** - circular blade housing, hand crank, adjustable
thickness gate, screw clamp to a table edge. This genuinely is a manual vegetable slicer and the
name is right. Equivalent commercial machine confirmed and staged (Winco/KATTEX FVS-1 class).

Real spec to verify: the 0,5-8 mm range is plausible for this class but unverifiable against any
source. No dimensions, weight or blade-set data are stored.

### B3.2 ⚠ IMG/FPR/00131 - "Manual Vegetable Slicer JSCC-9" is a **CHEESE CUBER**

Stored: *"Designed to cut uniform cubes sticks squares and rectangles of favourite cheeses. Slicing
arms are interchangeable and easy to switch. Stainless steel cutting wires are replaceable."*

**Confirmed near-verbatim from Nemco's Easy Cheeser (55300A) copy:**

> "These rugged, all metal units cut uniform **cubes, sticks, squares and rectangles** of everybody's
> favorite **cheeses**"

https://www.acitydiscount.com/Nemco-55300A-1-Easy-Cheeser-Cuber-Slicer-W-3-8-Inch-Slicing-Arm.0.15826.1.1.htm
https://www.amazon.com/Nemco-N55300A-1-Cheese-Slicer-Thickness/dp/B00DG9HNSY
https://russellhendrix.com/products/nemco-easy-cheeser-cheese-cutter-3-8-stainless-steel

The stored image confirms it independently: a horizontal wire-grid cutter with a hinged swing arm
over a flat base plate - the Easy Cheeser form factor, not a vegetable slicer.

**So: the name says "Manual Vegetable Slicer", the category says "Vegetable Processors", and the
product is a cheese cuber.** Both are wrong.

### B3.3 IMG/FPR/00132 - "Gravity Vegetable Slicer JSEC-08" is a **chopper/dicer**, `draft`, and has **no image**

Stored: *"The cutter id designed to be used for fast easy chopping, cutting and dicing of onions,
tomatoes, potatoes, celery, peppers and other vegetables."* (typo `id` for `is` in the live data.)

That is Nemco **Easy Chopper** copy - a spring-loaded pusher-block-through-blade-grid dicer, which
is what "JSEC" abbreviates. It is **not** a gravity slicer; a gravity/gravity-feed slicer is a
motorised machine where product falls onto a rotating disc. Two different machines.

- `image` is **`null`** - the only SKU in either brand with no stored image at all.
- Status `draft`, which is at least consistent with it being incomplete.

### B3.4 ⚠ IMG/FPR/00133 - "Manual Vegetable Slicer JSVC2100" is a **LETTUCE CUTTER**

Stored: *"Its ideal for chopping iceberg and othe lettuces as well as slicing melons for fruit
trays. Can also slice lettuce for tacos and cooked chicken for wraps and salads."* (typo `othe` for
`other` in the live data.)

That is Nemco Easy LettuceKutter / Vollrath Lettuce King category copy. The stored image confirms
it: a four-legged cast-aluminium frame with a pull-down blade grid sized for a whole lettuce head.
Exact-phrase confirmation was not obtainable (search access degraded mid-pass), so this is a strong
match on copy style plus a conclusive match on the photograph, not a verbatim citation.

Name and category are both wrong: this is a lettuce/produce cutter, not a "manual vegetable slicer".

### B3.5 IMG/FPR/00127 - "Potato Chipper on Stand JSPCC-08" ✅

Stored description is generic and self-consistent (stainless construction, removable stainless grid,
painted cast-iron structure, blade sizes 6/8/10/12 mm). The stored image matches: a vertical
lever-press chipper head on a tall tripod stand. **No Nemco copy involved.** This record is the
healthiest of the seven.

Two accessories are linked (`IMS/MEC/00309`, `IMS/MEC/00312`) - presumably spare blade grids; not
verified in this pass.

### B3.6 IMG/FPR/00140 - "Automatic Orange Juicer JSJC-12"

See §B5 for the Cancan cross-reference. Description is generic OEM copy, not Nemco.

### B3.7 IMG/FPR/00139 - "Sugarcane Juicing Machine", `JSESCJ-300`

Generic copy, no Nemco involvement. The stored image is a vertical stainless cabinet-style cane
crusher on castors with twin adjusting handwheels - the standard Chinese three-roller design. A
close-matching current production unit was found and staged.

---

## B4. ⚠ Width/height axis swap - checked per SKU

Three SYSTEMATIC records store both numeric dimension fields **and** a prose
`technical_specification` listing the same axes. In **both** cases where they can be compared, the
numeric fields disagree with the prose - and the prose is right, exactly as in every previous pass.

| SKU | JSON `length` / `width` / `height` | Prose says | Verdict |
|---|---|---|---|
| **IMG/FPR/00127** | 420 / **1240** / **470** | LENGTH 420, **WIDTH 470**, **HEIGHT 1240** | ⚠ **`width` and `height` are swapped.** Prose is right - a chipper *on a stand* is 1240 mm tall, not 1240 mm wide. |
| **IMG/FPR/00139** | 480 / **930** / **420** | LENGTH 480, **WIDTH 420**, **HEIGHT 930** | ⚠ **`width` and `height` are swapped.** Prose is right - the stored image is a floor-standing cabinet on castors, clearly taller than it is wide. |
| IMG/FPR/00140 | 400 / 450 / 900 | *(no dimensions in prose)* | Cannot cross-check. 900 mm height is plausible for this juicer class; the shape is internally sensible (taller than wide). Leave, but mark unverified. |
| IMG/FPR/00130, 00131, 00132, 00133 | *(none stored)* | *(none)* | No dimensions at all |

So the swap is **real and confirmed on 2 of 2 checkable SKUs**, and must not be assumed on
`IMG/FPR/00140`, where there is nothing to check against.

---

## B5. ⚠ Cross-reference: is the Systematic juicer a Cancan rebadge?

**No.** They are different machines from different OEM families.

| | IMG/FPR/00140 Systematic `JSJC-12` | IMG/FPR/00123 Cancan 38 |
|---|---|---|
| Capacity | 20 oranges/min | 38 oranges/min |
| Fruit diameter | 40-90 mm | 60-80 mm |
| Dimensions (mm) | 400 × 450 × 900 | 750 × 580 × 980 |
| Weight | 55 kg | 76 kg |
| Power | "220/120 W" + "Engine 0.37 kw" ⚠ | 370 W |
| Basket | not stated | 15 kg stainless (28 kg option) |
| Price (KES) | 130,963 | 321,250 |

The stored images settle it. The Systematic unit is the ubiquitous **Chinese `XC-2000E`-family**
automatic citrus juicer - stainless body, full-width clear polycarbonate front cover, chromed wire
top basket over an inclined feed ramp, twin peel bins at the base. The Cancan 38 is a Turkish machine
with a completely different cabinet, a deep enclosed basket and side peel bins. A photograph of a
current `XC-2000E`-family unit is staged for comparison.

The `XC-2000E` family independently confirms the 20 oranges/min figure:

https://search.brave.com/search?q=%22XC-2000E%22+orange+juicer+specifications+20+oranges+per+minute

**Conclusion: a genuinely different machine at roughly 40 % of the Cancan price, correctly listed as
a lower-capacity alternative.** No rebadge, and no cross-contamination between the two records.

---

## B6. ⚠ Electrical - Kenya 240 V / 50 Hz

Five of the seven SYSTEMATIC items are **hand-operated** (`JSCV-2200`, `JSCC-9`, `JSEC-08`,
`JSVC2100`, `JSPCC-08`) - no electrical requirement, no phase question, no compliance risk. Good.

The two powered items both have problems:

### IMG/FPR/00140 `JSJC-12` - internally contradictory

Stored `technical_specification`:

> Power **220/120 W** · Speed **50/60Hz** · Engine **0.37 kw**

- **"Power 220/120 W" is ambiguous** and almost certainly means 220 V / 120 W. Written as-is a reader
  sees two wattages.
- **"120 W" and "0.37 kW" (370 W) cannot both be true.** The `XC-2000E` family is a 120 W machine, so
  120 W is the likelier real figure - and `0.37 kW` is exactly the Cancan 38's motor rating, which
  raises the possibility that this line was pasted in from the Cancan record.
- **"Speed 50/60Hz"** mislabels supply frequency as speed.
- **Kenya suitability:** 220-240 V, 50 Hz, single phase → **fine for Kenya**, no phase issue, subject
  to the wattage being resolved.

### IMG/FPR/00139 `JSESCJ-300` - no electrical data at all

An electric sugarcane crusher with **no voltage, no frequency, no wattage, no phase** anywhere in the
record. Machines in this class run roughly 0,75-1,5 kW. Whether this particular unit is single- or
three-phase is precisely the thing a Kenyan buyer needs to know before ordering, and it is absent.
**Must be obtained from the supplier before this SKU is quoted for installation.**

---

## B7. Sibling-contamination check - SYSTEMATIC

Deliberate check, since this has recurred in nearly every batch.

- **Between the four "slicer" siblings: no contamination.** Each has genuinely distinct description
  text. But that is because each was lifted from a *different* source machine (§B3), so three of four
  are attached to the wrong product name and the wrong category.
- **Between the two juicers: no contamination**, with one suspicious exception - the `0.37 kw` engine
  figure on `JSJC-12` matching the Cancan 38's motor exactly (§B6).
- **Across brands: one severe case** - `IMG/FPR/00110` (Kayalar) carrying Waring spice-grinder image
  and copy (§A4.1).
- **Category contamination:** all four "slicer" SKUs are filed under `Vegetable Processors`, but one
  is a cheese cuber and one is a lettuce cutter.

---

## B8. Images obtained - SYSTEMATIC

Destination: `C:\Users\jonah.wakahiu\Desktop\ecommerce\products resource\systematic-images\`
(the folder was empty at the start of this pass - the previous run staged nothing here).

Because SYSTEMATIC is a house label on unbranded OEM equipment, there is no manufacturer site to
source from. What is staged is an **independently sourced photograph of the same class of machine**
for every SKU, which is the strongest evidence obtainable and is enough to prove or disprove what
each stored record actually depicts. Filenames use `equivalent-` rather than `REF__` because none of
these is a wrong-configuration file - each is a correct-type reference for a house-brand product.

| File | Pixels | Size | Purpose |
|---|---|---|---|
| `IMG-FPR-00130__equivalent-bench-clamp-rotary-vegetable-slicer.jpg` | 2000 × 2000 | 160 KB | Confirms the stored image is a genuine manual rotary vegetable slicer ✅ |
| `IMG-FPR-00131__equivalent-nemco-easy-cheeser-cheese-cuber.jpg` | 500 × 500 | 26 KB | ⚠ under 800 px - best available. **Proves the SKU is a cheese cuber, not a vegetable slicer** |
| `IMG-FPR-00132__equivalent-vegetable-chopper-dicer.jpg` | 2000 × 2000 | 219 KB | The chopper/dicer this SKU actually is; the SKU currently has **no image at all** |
| `IMG-FPR-00133__equivalent-manual-lettuce-cutter.jpg` | 2000 × 2000 | 367 KB | **Proves the SKU is a lettuce cutter, not a vegetable slicer** |
| `IMG-FPR-00127__equivalent-vertical-press-fry-cutter-head.jpg` | 2000 × 2000 | 305 KB | The press head used on the on-stand chipper; confirms the stored image ✅ |
| `IMG-FPR-00139__equivalent-vertical-sugarcane-juicer.jpg` | 800 × 800 | 102 KB | Very close match to the stored image (cabinet on castors, angled top hopper, twin juice trays) ✅ |
| `IMG-FPR-00140__equivalent-xc-2000e-automatic-orange-juicer.jpg` | 800 × 800 | 146 KB | Same `XC-2000E` family as the stored image; settles the Cancan question ✅ |

**Spec sheets: none exist.** There is no manufacturer, so there is no spec sheet to download for any
of the seven. This is a hard limit, not an omission.

Two sourced images carry supplier watermarks (`Skycity` on the cane juicer, a supplier mark on the
orange juicer) and are reference-only - they are **not** suitable for the storefront.

Nothing was sourced from sheffieldafrica.com. Nothing was copied into the project.

---

## B9. Recommended changes - SYSTEMATIC

Nothing below has been applied.

### 1. ⚠ Fix the two mis-named products

| SKU | Current name / category | Should be |
|---|---|---|
| IMG/FPR/00131 | "Manual Vegetable Slicer Systematic JSCC-9" / Vegetable Processors | **Cheese Cuber / Cheese Cutter**; category should reflect cheese or general food prep, not vegetables |
| IMG/FPR/00133 | "Manual Vegetable Slicer Systematic JSVC2100" / Vegetable Processors | **Lettuce Cutter**; the description already says lettuce, tacos, wraps and melon |

Both are `published` and both are actively misdescribed to customers.

### 2. ⚠ Fix `IMG/FPR/00132` - "Gravity Vegetable Slicer" is a chopper/dicer

It is a manual chopper, not a gravity-fed slicer, and its `image` is `null`. It is `draft`, so it can
be corrected before it goes live. Rename, describe correctly, add an image.

### 3. ⚠ Correct the two axis swaps (§B4)

| SKU | Current | Corrected |
|---|---|---|
| IMG/FPR/00127 | L 420 / W 1240 / H 470 | **L 420 / W 470 / H 1240** |
| IMG/FPR/00139 | L 480 / W 930 / H 420 | **L 480 / W 420 / H 930** |

The prose `technical_specification` already carries the right values in both records; only the
numeric fields are wrong.

### 4. ⚠ Resolve the `JSJC-12` power contradiction

`120 W` versus `0.37 kW` cannot both stand. Confirm with the supplier; the `XC-2000E` family points
to 120 W, and `0.37 kW` is suspiciously identical to the Cancan 38's rating. Also rewrite
"Power 220/120 W" as separate voltage and wattage rows, and relabel "Speed 50/60Hz" as frequency.

### 5. ⚠ Obtain electrical data for `JSESCJ-300`

Voltage, frequency, wattage and **phase** are all missing from an electric machine. Required before
the SKU is quoted for a Kenyan installation.

### 6. Fix the two live typos

- `IMG/FPR/00132`: "The cutter **id** designed" → "is designed"
- `IMG/FPR/00133`: "iceberg and **othe** lettuces" → "other lettuces"

### 7. Rewrite the `SYSTEMATIC` brand description

The stored row describes "shelving systems and kitchen storage equipment". All seven products are
vegetable-prep and juicing machines. Since SYSTEMATIC is a house label, the honest description is
about the range, not about a company - and `website_url` should stay `null`.

### 8. Leave `JSVC2100` alone for now

The missing hyphen is a typo, but `model_number` is the unique ID. If it is normalised to
`JSVC-2100`, the product name and the stored image filename
(`manual-vegetable-slicer-systematic-jsvc2100-imgfpr00133.jpg`) must be updated in the same change.
Best done together with the rename in item 1.

### 9. Missing content across the board

Four of seven SKUs (`00130`, `00131`, `00132`, `00133`) have **no dimensions, no weight, no
materials and no blade/disc data**. `00130`'s only technical claim is the 0,5-8 mm thickness range.
For a house-brand line the only route to this data is the supplier - there is no catalogue to consult.

---
---

# Cross-brand summary of red flags

| # | Severity | SKU | Issue |
|---|---|---|---|
| 1 | ⚠⚠ Critical | IMG/FPR/00110 | Published record carrying a **Waring spice-grinder image and description** under the name "Potato Chipper Table Top Kayalar" |
| 2 | ⚠⚠ Critical | All 6 Kayalar SKUs | **No `brands.json` row for KAYALAR** - dangling brand link |
| 3 | ⚠ High | IMG/FPR/00131 | Published as "Manual Vegetable Slicer"; is a **cheese cuber** (Nemco Easy Cheeser copy, confirmed verbatim) |
| 4 | ⚠ High | IMG/FPR/00133 | Published as "Manual Vegetable Slicer"; is a **lettuce cutter** |
| 5 | ⚠ High | IMG/DWW/00072, 00074 | Codes `153114030` / `153114033` share a tier digit but are named 36- and 49-compartment; **at most one can be right** |
| 6 | ⚠ High | IMG/DWW/00071-00075 | Identical prices for 1-extender and 2-extender variants - **extender counts or prices are wrong** |
| 7 | ⚠ Medium | IMG/FPR/00127, 00139 | `width`/`height` **swapped** relative to their own prose (2 of 2 checkable) |
| 8 | ⚠ Medium | IMG/FPR/00140 | `120 W` vs `0.37 kW` contradiction; `0.37 kW` matches the Cancan 38 exactly |
| 9 | ⚠ Medium | IMG/FPR/00139 | Electric machine with **no voltage, frequency, wattage or phase** |
| 10 | ⚠ Medium | IMG/DWW/00075 | `model_number` `KAY 37` is **not a model number** and matches nothing |
| 11 | ⚠ Medium | All 6 Kayalar model numbers | 9-digit codes with **zero external existence**; do not fit the real Kayaplas grammar |
| 12 | ⚠ Low | IMG/DWW/00071-00075 | Five archived records with **completely empty** image, description and dimension fields |
| 13 | ⚠ Low | IMG/FPR/00132 | `image` is `null`; named "Gravity Vegetable Slicer" but is a manual chopper/dicer |
| 14 | ⚠ Low | SYSTEMATIC brand row | Description says shelving and storage; all 7 products are prep machines |
| 15 | ⚠ Low | IMG/FPR/00132, 00133 | Live typos: "cutter **id** designed", "**othe** lettuces" |
| 16 | ℹ Note | - | Kayaplas's **own catalogue** mislabels its 25- and 49-compartment racks as "36 Comp." in the English column |
