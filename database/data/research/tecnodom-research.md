# Tecnodom - research (SAP-led redo)

Supersedes `old/tecnodom-research.md`, which was written before the SAP export existed.
Nothing from the old file was carried over without re-verification.

Scope: 20 SKUs. Every one now has at least one manufacturer or reseller spec sheet staged in
`Desktop\ecommerce\products resorce final\tecnodom\`.

---

## 1. Sources used, and why

Tecnodom's own site never exposes a model code in a URL, so matching our codes against the
sitemap scored **0 / 20**. The codes live inside the family datasheet PDFs instead, and
matching on PDF page text scored **13 / 20**.

- https://www.tecnodomspa.com/sitemap.xml - 333 URLs, product FAMILIES only (`tavolo-60`,
  `mr-95`, `kibuk`). Useless for code matching, useful for finding the family pages.
- 23 family datasheet PDFs under https://www.tecnodomspa.com/files/34/schede-pdf/ - these
  carry the per-model code tables and the length tables. This is the primary source.
- Family product pages (Joomla + Droppics galleries at `/images/gallery/NN/large/`) - product
  photography, 800x800 gallery art and 1800x800 page headers.
- https://www.chefline.it/catalogo/files/ - per-code *schede tecniche* PDFs. Used for the five
  upright cabinets, which have **no public Tecnodom datasheet** (the ARMADI and EVOK sheets sit
  behind the customer-area login at https://www.tecnodomspa.com/en/support/manuals.html).

Dead ends, recorded so they are not retried: technochef.eu search is JS-driven and returns an
identical 370 KB page for every query; the Dropfiles directory listing at `/files/34/` returns
the site's 404 page; product pages link only the company profile PDF.

---

## 2. SAP was wrong twice here

Both caught by the manufacturer datasheet, both resolving in favour of **our** stored value.

**`IMG/OVE/00076` - SAP model `FED03NE02V` is wrong; correct is `FEM03NE02V` (ours).**
`Schedeforni.pdf` page 1 lists exactly one code, `FEM03NE02V`, described as
"Elettrico - Meccanico / Electric - Mechanical". SAP's own Item Remark for this SKU says
"lateral mechanical control", contradicting SAP's own Model field. The staged photo shows two
rotary knobs on the right-hand side panel. FED = digitale, FEM = meccanico; three independent
signals all say FEM.

**`IMG/REF/00049` - SAP model `AFO7EKOMTNPV` carries a letter O where the digit 0 belongs.**
Correct is `AF07EKOMTNPV` (ours). AF07 = the 700-class cabinet.

---

## 3. The finding that matters: the width column holds the DEPTH

This is not a scattering of individual errors. Across three unrelated Tecnodom product
families, our stored `width` reproducibly equals the manufacturer's **depth**, and the real
width is absent. Heights are correct throughout.

Proven against manufacturer or distributor data for 13 of the 20 SKUs:

| SKU | model | ours W | true W | true D | true H | source |
|---|---|---|---|---|---|---|
| IMG/DIS/00093 | V6060SL | 600 | **680** | ~600 | 1984 | Schedevulcano p4 |
| IMG/DIS/00106 | V6080SLINOX | 600 | **880** | ~600 | 1984 | Schedevulcano p4 |
| IMG/DIS/00096 | V60187SL | 600 | **1955** | ~600 | 1984 | Schedevulcano p4 |
| IMG/DIS/00100 | VS60150SLINOX | 650 | **1600** | ~650 | 1980 | Schedevulcano p48 |
| IMG/DIS/00095 | VB80250SL | 765 | **2580** | ~800 | 2030 | Schedevulcano p10 |
| IMG/REF/00211 | TF02MIDBT | 715 | **1420** | 700 | 840/910 | SchedetavoloGN p5 |
| IMG/REF/00212 | TF03MIDBT | 715 | **1870** | 700 | 840/910 | SchedetavoloGN p11 |
| IMG/REF/00062 | AF07PKMTN | 800 | **710** | 800 | 2030 | chefline |
| IMG/REF/00061 | AF07PKMBT | 800 | **710** | 800 | 2030 | chefline |
| IMG/REF/00060 | AF14PKMTN | 800 | **1420** | 800 | 2030 | chefline |
| IMG/REF/00063 | AF14PKMBT | 800 | **1420** | 800 | 2030 | chefline |
| IMG/REF/00049 | AF07EKOMTNPV | 800 | **710** | 790 | 2030 | chefline |
| IMG/DIS/00037 | EVOK150V | 763 | **1500** | 785 | 1400 | ahlia.store |

The cabinets are the clearest proof, and they show **SAP shares the error**: SAP and our
catalogue both record 800 mm width for the 700 L single-door cabinet *and* for the 1400 L
twin-door cabinet. Those cannot both be 800 mm wide. 800 is the depth of the whole Perfekt
range; chefline gives 710 for the single and 1420 for the double.

### How the Vulcano codes decode

`V6060SL`: the first 60 is the **depth class**, the second number is the **length**, in cm.
The published length includes the two 40 mm side walls, so length = suffix x 10 + 80.

Vulcano 60 (Schedevulcano.pdf p4, "LUNGHEZZE / LENGTHS"):

| suffix | 60 | 80 | 100 | 125 | 140 | 150 | 187 |
|---|---|---|---|---|---|---|---|
| mm | 680 | 880 | 1080 | 1330 | 1480 | 1580 | 1955 |

Vulcano VS 60 (p48): 125 -> 1350, 150 -> **1600**, 187 -> 1975.
Vulcano 80 (p10): 100 -> 1080 ... 187 -> 1955, 200 -> 2080, 250 -> **2580**, 300 -> 3080.

Heights, from the drawing pages: Vulcano 60 = 1984 mm on feet / 2080 on wheels (p3);
VS 60 = 1980 / 2080 (p47); VB 80 = 2030 / 2130 (p35). All three match what we already store.

Trap avoided: page 59 of Schedevulcano.pdf lists `DIMENSIONI 780x710x2210` and similar next to
the `GABBIAV6060` codes. Those are **wooden crate** sizes, not cabinet sizes - the 2210 height
gives it away against the real 1984. Do not read that table as product dimensions.

---

## 4. Ovens - the same pattern, plus a chamber/exterior trap

`Schedeforni.pdf` prints three dimension triplets per model, in this order: cooking chamber,
external, packaging. Only the middle one is the product dimension.

| SKU | model | ours W/H | chamber | **external** | packing |
|---|---|---|---|---|---|
| IMG/OVE/00076 | FEM03NE02V | 520 / 390 | 390x370x250 | **600x530x400** | 700x570x560 |
| IMG/OVE/00078 | FEMG04NE595V | 660 / 580 | 464x420x370 | **589x680x580** | 625x720x750 |
| IMG/OVE/00079 | FEM06NEMIDVH2O | 910 / 830 | 680x480x520 | **840x920x835** | 880x955x980 |
| IMG/OVE/00089 | FEDL10NEMIDVH2O | 910 / 1150 | 680x480x840 | **840x920x1155** | 880x955x1300 |
| IMG/OVE/00128 | FEM04NEPSV | 720 / 560 | 650x459x350 | **775x720x560** | 800x750x730 |

Our heights are right (within 5 mm). Our widths are again the manufacturer's depth: 520~530,
660~680, 910~920, 910~920, 720=720.

`IMG/OVE/00089` is the trap: **SAP records 480 x 840, which is the cooking chamber**, not the
oven. The real appliance is 840 x 920 x 1155 mm. Our stored 910/1150 is much closer to correct
than SAP's figure. This is a second, independent case of SAP being the weaker source.

`IMG/REF/00057` ATT-05 is the one clean match: manufacturer 750x750x890/910, ours 750/-/890.

---

## 5. Images staged - 109 files, 20 SKUs

Per the standing rule, every distinct image on a matched page was kept, not just the lead shot.

- **5 oven SKUs** have genuine embedded manufacturer photography pulled out of
  `Schedeforni.pdf` at 1323-2326 px. These are the best assets in the set.
- **15 SKUs** have site gallery art (800x800) or page headers (1800x800).
- 22 per-SKU spec-sheet PDFs extracted from the Tecnodom datasheets, plus 5 chefline sheets.
- 15 spec pages rendered to PNG at 200 DPI for the Vulcano and GN-counter families, whose
  datasheet art is vector line drawing (their embedded rasters are 43 px icons, unusable).

Verified by eye, against the code, not just the filename:

- `FEM03NE02V` - NERINO, 3-tray countertop, mechanical knobs on the side panel. Correct.
- `FEMG04NE595V` - control plate reads **NERONE 595-4**. Correct off the badge itself.
- `FEM04NEPSV` - plate reads **NERONE 600**, the 600x400 pastry format = PS pasticceria.
- `FEDL10NEMIDVH2O` - NERONE, 10 racks, twin fans, digital LED panel. Correct.
- `AF07PKMTN` / `AF14PKMTN` - the cabinet banner is branded **PERFEKT**, which decodes the
  `PK` in the code. The 700/1400 pages state "Perfekt 700 litres" / "Perfekt 1400 litres".

**One image deleted.** `IMG-REF-00049__AF07EKOMTNPV-tecnodom-armadi-700-1.jpg` was staged from
the Perfekt 700 page, but that SKU is the **EKO** series, and its `PV` suffix reads as *porta
vetro* (glass door) while the photo shows a solid door. Two mismatches in one file, so it was
removed rather than left to mislead. `IMG/REF/00049` currently has a spec sheet but **no image**.

Caution for whoever assigns these: Tecnodom photographs the **family**, not the length variant.
The same Vulcano gallery serves V6060SL, V60187SL and V6080SLINOX - machines 680, 1955 and
880 mm wide. The image can never settle which variant a SKU is; only the length table can.
Filenames therefore carry the family name so the ambiguity stays visible.

---

## 6. The last three gaps - now closed

**`IMG/REF/00193` P-ATT10EA was in the manufacturer datasheet all along.**
`SchedeABBATTITORI.pdf` page 5 carries `ATT10`: **750 x 750 x 1310/1330 mm**, 10 trays,
chamber 610 x 430 x 760, packing 750 x 750 x 1360. The original matcher missed it because our
code normalises to `PATT10EA`, which is not a substring of `ATT10` - the `P-` prefix and the
`EA` suffix both defeat containment matching. **Lesson: normalised-substring matching fails on
codes that carry distributor prefixes/suffixes; match on the embedded core token too.**
Our stored 756 / 1312 is correct here, and it is the one SKU where the width/depth swap is
harmless because the cabinet is square (750 x 750).

**`IMG/DIS/00037` EVOK150V - 1500 x 785 x 1400 mm**, 134 W, 2.34 m2 display surface, 3 height-
adjustable glass shelves, rear sliding glass doors. Source
https://ahlia.store/products/dom-evok150v-stright-glass-ventilated-display-case-150-cm
(Shopify, vendor field "Tecnodom", variant SKU `DOM-EVOK150V`). The 150 in the model is the
length in cm, consistent with the Vulcano naming convention. Our 763 is the depth (785) again.

**`IMG/REF/00049` AF07EKOMTNPV - image sourced.** Three photos from the Tecnodom distributor
https://tcserbia.com/en/cooling-technology/glass-door-coolers/af07ekomtnpv-glass-door-cooler/
with the code in the filename. Verified by eye: single **glass** door, EKO styling with a plain
digital panel, clearly a different series from the orange-badged PERFEKT. Confirms the earlier
deletion was correct. Best full-unit shot is only 405x755, below the preferred 800 px floor;
the 601x800 file is an interior detail, not a full unit.

## 7. Still open

- The 13 width corrections in section 3 and the 5 oven widths in section 4 are **researched, not
  applied**. products.json is untouched by this pass.
- `IMG/REF/00049`'s best image is under the 800 px floor. Worth a second pass if a larger EKO
  glass-door shot turns up.
