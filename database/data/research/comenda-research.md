# Comenda — image + spec sourcing pass (31 July 2026)

**This file supersedes `database/data/research/old/comenda-research.md`.** That file predates the
SAP export and was written as a spec/copy audit; it is a useful map of leads but its conclusions
were re-verified here from scratch, and several of them are corrected below (rack colour, rack
codes, dimension verdicts, and the resolution ceilings).

Scope of this pass: **images for all 9 COMENDA SKUs**, plus resolution of the live
`products.json` vs SAP dimension conflicts using the datasheets already held on disk.
No `products.json`, `brands.json` or `storage/` file was touched. No `model_number` was changed.

Staged output: `Desktop\ecommerce\products resorce final\comenda\` — **44 files** (42 product
images + 2 in `_brand-reference\`), 11 spec PDFs already present. Per-file provenance,
pixel sizes and notes are in `_sourced.json` in that folder; the per-SKU checkboxes in
`_DOSSIER.md` are filled in.

---

## 1. Headline findings

1. **On dimensions, our stored `products.json` values beat SAP on 3 of 3 live conflicts.**
   Comenda's own current datasheets state EC44 = 596 × 740 × 1465, EF36 M = 570 × 610 × 820 and
   EB28 = 460 × 515 × 630 — each **exactly** our stored record, and each contradicting SAP.
   That is now 7 of 7 across the programme.
2. **SAP's PC 07 and EC44 rows carry identical dimensions (632/765/1460).** Neither machine has
   those dimensions. They are a different line, a different cabinet and a different footprint.
   This is a sibling-contamination artefact in SAP, and it is the strongest evidence so far that
   SAP's dimension *values* cannot be trusted even when its dimension *order* can.
3. **Comenda's racks are BLUE, not grey.** The archived research asserted grey and recommended
   grey Sammic baskets on that basis. Comenda's own racks catalogue shows the CB combination rack
   in blue, the P 12/18 plate rack in green, the 400×400 combination rack in white/grey, and the
   cutlery items in orange. The representative rack photos staged here were chosen to match.
4. **`CP 8` is a real Comenda 8-compartment cutlery basket** — an orange 4×2 half-size basket in
   the cestelli catalogue. The archived research concluded "Comenda publishes no 8-compartment
   code". It does. This is the best candidate for what `IMG/DWW/00032` actually is.
5. **kitchenpro.gr upscales.** It serves Comenda Equilybra renders at 972×2000, 1284×1884 and
   1560×2000 that are enlargements of Comenda's own ~600–850 px web renders. Side-by-side control-panel
   crops at native pixels make this unambiguous. Two of the three were rejected outright; the third
   was kept and labelled `UPSCALED` because it is the only ≥800 px EC44 hood front in existence.
6. **No AI-generated imagery was found for this brand.** Every candidate was opened and viewed.
   Nothing went into `_ai-generated\`. Two marketing collages with watermarks and "ORDER NOW"
   overlays were rejected, and one reseller was found serving a wrong-series machine (§6).

---

## 2. Per-SKU result

| SKU | Model | Status | Best pixels (short edge) | Agrees with SAP |
|---|---|---|---|---|
| IMG/DWW/00032 | N/A (Cutlery Rack 8 Compartment) | sourced — **representative of type** | 4000 (Cambro 8FBNH434151) | SAP dims are 0 = missing |
| IMG/DWW/00033 | N/A (Dish Wash Rack 400MM) | sourced — **representative of type** | 1500 (FRIES 400×400 base rack) | SAP 400/400/0 consistent |
| IMG/DWW/00085 | PC-09 | sourced — **family render** | 3048 | yes on dimensions |
| IMG/DWW/00093 | PC 07 | sourced — **family render** | 3048 | **no — SAP wrong** |
| IMG/DWW/00156 | CB-12/18 (CB Combination Rack) | sourced — **representative of type** | 4000 (Cambro BR258186) | SAP dims are 0 = missing |
| IMG/DWW/00157 | PR (Plate Rack) | sourced — **representative of type** | 3000 (Cambro PR314151) | SAP dims are 0 = missing |
| IMG/DWW/00158 | EC44 | sourced — partial (native view capped at 692 px) | 972 (upscaled) / 813 native | **no — SAP wrong** |
| IMG/DWW/00159 | EF36M | sourced | 1864 | **no — SAP wrong** |
| IMG/DWW/00160 | EB28 | sourced — **family render** | 846 | SAP dims are 0 = missing |

"Representative of type" means the photograph is of the correct standard rack format at the correct
standard size — **it is not a photograph of a Comenda part and must never be presented as one.**
See §5.

---

## 3. Dimensions — the SAP conflicts, resolved from the datasheets

Every figure below was read out of a Comenda PDF held in the staging folder or downloaded from
comenda.eu during this pass.

| SKU | Our record | SAP | Comenda datasheet | Verdict |
|---|---|---|---|---|
| IMG/DWW/00085 PC-09 | 624 / 740 / 1460 | 624 / 740 / 1460 | **625 × 740 × 1460** (2023 and 2026 datasheets agree) | both fine, 1 mm apart |
| IMG/DWW/00093 PC 07 | 624 / 740 / 1460 | 632 / 765 / 1460 | **625 × 740 × 1460** (PC07+ 2023), **625 × 740 × 1475** (PC07 2026) | ours right, **SAP wrong** |
| IMG/DWW/00158 EC44 | 596 / 740 / 1465 | 632 / 765 / 1460 | **596 × 740 × 1465** | **ours exactly right, SAP wrong** |
| IMG/DWW/00159 EF36M | 570 / 610 / 820 | 600 / 605 / 820 | **570 × 610 × 820** | **ours exactly right, SAP wrong** |
| IMG/DWW/00160 EB28 | 460 / 515 / 630 | 0 / 0 / 0 | **460 × 515 × 630** | **ours exactly right, SAP missing** |
| IMG/DWW/00032 rack | 500 / 100 / 500 | 0 / 0 / 0 | n/a | 500×500 base, ~100 mm tall; axes transposed |
| IMG/DWW/00033 rack | none | 400 / 400 / 0 | 400×400 h.150 (EB28 kit) | SAP is the better record here |
| IMG/DWW/00156 rack | none | 0 / 0 / 0 | CB = 500×500, h 75 mm | both empty |
| IMG/DWW/00157 rack | none | 0 / 0 / 0 | P 12/18 = 500×500 | both empty |

Sources:
https://comenda.eu/wp-content/uploads/2024/02/Scheda-tecnica-PC09_28.08.23_ENG.pdf
https://comenda.eu/wp-content/uploads/2026/06/Scheda-tecnica_PC07_ENG_29.05.26.pdf
https://comenda.eu/wp-content/uploads/2025/05/Scheda-tecnica_EC44_ENG_20.05.25.pdf
https://comenda.eu/wp-content/uploads/2025/05/Scheda-tecnica_EF36-M_ENG_19.05.25.pdf
https://comenda.eu/wp-content/uploads/2025/05/Scheda-tecnica_EB28_ENG_19.05.25.pdf
https://comenda.eu/wp-content/uploads/2025/05/EQUILYBRA-ENG-19.05.25.pdf
https://comenda.eu/wp-content/uploads/2025/07/Prime-ENG_29.07.25.pdf

### 3.1 Two internal inconsistencies inside Comenda's own documents

- **PC 07 height: 1460 or 1475?** The 2026 PC07 datasheet and the 2025 Prime Line catalogue both
  say **1475 mm**; the 2023 PC07+ datasheet, the 2026 PC07 **RA** datasheet and every PC09 datasheet
  say **1460 mm**. The 1475 figure appears alongside a "GAMMA HI LINE" table fragment in the PC07
  2026 PDF, which suggests the taller figure came in with a table revision rather than a design
  change. Our stored 1460 is defensible; do not "fix" it to 1475 without asking the supplier.
- **625 vs 624.** Comenda's technical drawing dimensions the tank aperture at 624 and the cabinet
  at 625. Our 624 is measuring a real feature, not a typo.

---

## 4. Where the images came from, and why they cap where they do

Comenda has **no per-model product pages with galleries** — only download pages listing PDFs.
Everything therefore comes from three places: the WordPress media library, the PDFs themselves,
and distributors.

### 4.1 The Prime Line (PC) machines — one print master, shared across the family

https://comenda.eu/wp-content/uploads/2024/03/PC07.png is a genuine **3048 × 6158** print master
of the Prime Line pass-through, hood closed. Verified by opening it: the control-panel legend
("COMENDA / Prime Line", ECO, glass/plate/pot icons, START) is razor sharp at native size. It is
mirrored byte-for-byte at https://comenda.co.uk/wp-content/uploads/2024/03/PC07.png.

**This is a FAMILY render.** PC07, PC09 and PC12 share one cabinet and differ only in booster and
panel; Comenda's own datasheets embed the identical 212 × 480 hero in the PC07 and PC09 PDFs.
It is staged against **both** `IMG/DWW/00085` and `IMG/DWW/00093` with `PCfamily` in the filename.
For `IMG/DWW/00093` (PC 07) it is the strongest claim available, since Comenda's own filename is
`PC07.png`. For `IMG/DWW/00085` (PC-09) it is **not proven to be that variant.**

Comenda does distinguish the two by *view*: it publishes the hood-**raised** three-quarter as
`PC09.png` — but only at 591 × 729. The largest copy of that view anywhere is
https://furnibuild.com/image/6950605a36f/uss4ls9zr7f03sk8eaw44ba0.jpg at **574 × 900**, obtained by
stripping the OpenCart cache segment. Below the 800 px floor and staged as such.

A **hood-raised, loaded** straight-on view was recovered from the Prime Line catalogue at
**527 × 1287** (`Prime-ENG_29.07.25.pdf`, page 3, XObject 61, JPEG-2000 with soft mask). Also below
the floor, but this is the largest copy of that view that exists — the datasheets carry it at
212 × 480.

**Proven ceilings for the PC family.** A full sweep of `/wp-json/wp/v2/media` on both comenda.eu
and comenda.co.uk (558 and 422 image assets respectively, paged out in full) returns exactly four
PC assets: `PC07.png` 3048×6158, `PC07-1.png` / `PC07-2.png` / `PC09.png` at 591×729, and
`PC09-edited.png` at 540×666. Nothing else.

### 4.2 The Equilybra (EB / EF / EC) machines — no media-library assets at all

The media API returns **nothing** for `EB28`, `EB25`, `EC44`, `EF36`, `undercounter`, `glasswasher`,
`sottobanco` or `frontale`. The only Equilybra images on the site are the 1134 × 709 line banner
and the 1280 × 600 download-page header. Every product image therefore has to come out of a PDF.

`fitz` (PyMuPDF) `extract_image()` was run across **18 Comenda PDFs**: the 11 already staged, plus
both Equilybra brochure revisions (including the 65 MB print edition), the Italian Equilybra
brochure, the 2025 EB28 / EB25 / EF36-M / EC44 ENG datasheets, the 2026 ITA datasheets, the Italian
racks catalogue and two Prime Line catalogue revisions. Soft masks were recomposited onto white
(dropping them produces black speckle).

What that yielded:

- **EF36 M door open, loaded — 1864 × 1960.** The single best Equilybra product image found.
  It lives on page 2 of the **superseded** 9.4 MB brochure
  https://comenda.eu/wp-content/uploads/2025/05/EQUILYBRA-ENG-19.05.25.pdf as XObject 44,
  a JPEG-2000 with `/SMask`. The *current* 4.4 MB brochure carries the same image at only 895 × 941.
  **Always check superseded revisions.** EF36 M and EF36 C are visually identical, so this is an
  EF36-family view.
- **EB28 front — 846 × 1065**, from the 2025 EB28 datasheet, page 1. The identical XObject also
  appears in the **EB25** datasheet, so it is an EB-family render, not EB28-specific.
- **EC44 with the CRC2 heat-recovery stack — 813 × 1368**, from the 2026 ITA EC44 datasheet.
  Above the floor and a genuinely distinct, saleable view.
- **EC44 hood front — 692 × 1037 native.** Identical XObject in the 2025 ENG, 2026 ENG and 2026 ITA
  datasheets. Proven ceiling.
- **EF36 M front closed — 564 × 710 native.** Identical XObject in EF36-M ENG/ITA and EB28 ITA;
  the brochure range page carries it at 540 × 718. Proven ceiling.
- **Rack-kit items** (insert for cup dishes 639 × 501, round rack 622 × 519, G2 cutlery holder
  360 × 306, P 12/18 plate rack loaded 605 × 460). All proven ceilings.
- The 65 MB print brochure adds **nothing** in product terms — its large assets (4460 × 3517,
  2490 × 3517, 2630 × 1706) are leaf motifs and lifestyle photography. Same for the Prime Line
  catalogue: its 2445 × 2320 and 3008 × 2288 assets are cover art and staff photography, and its
  large machine renders are PF undercounters and PB glasswashers, which are **not our SKUs**.

### 4.3 The upscale trap at kitchenpro.gr

kitchenpro.gr's OpenCart upload directory is directly enumerable — guessing
`/image/data/uploads/202509/comenda_equilybra_<model>.jpg` found three files without any search:

| File | Served | Verdict |
|---|---|---|
| `comenda_equilybra_ec44hood.jpg` | 972 × 2000 | **upscale** of Comenda's 692 × 1037 |
| `comenda_equilybra_eb28.jpg` | 1284 × 1884 | **upscale** of Comenda's 846 × 1065 |
| `comenda_equilybra_ef36m.jpg` / `_1.jpg` | 1560 × 2000 | **upscale**, different crop of the 1864 × 1960 |

Proof, not inference: crop the control panel from each at native pixels and put it next to the same
crop from Comenda's own render at matched physical scale. On the EB28 pair the datasheet's 846 px
copy resolves the seven-segment display ("55 85"), the knob highlights and the leaf graphic; the
1284 px reseller copy renders the same area as mush and its "COMENDA" letterforms are visibly
interpolated. The 1284 px file has 1.5× the pixels and **less** information.

The EC44 file was nevertheless kept, filename-tagged `UPSCALED`, because it is the only ≥800 px
copy of the EC44 hood front that exists and it is a genuine Comenda render underneath. The EB28
and EF36M upscales were **not** staged — Comenda's own native renders are better.

Also confirmed against the archived research: https://www.webstaurantstore.com caps at 1000 × 1000,
https://hbg2000.com serves PC09 at 260 × 260, and
https://commercialkitchenconstruct.co.uk serves `ComendaPC07RA1final.png` at exactly 800 × 800 —
which on inspection is the same PC07.png master downscaled and letterboxed into a square, so it
adds nothing.

---

## 5. The four racks — solved, and labelled honestly

This is the part the previous pass got only half right.

### 5.1 What Comenda actually sells, from its own catalogue

https://comenda.eu/wp-content/uploads/2024/05/13-CESTELLI-eng900902EN-09.2017.pdf (cod. 900902EN)
is the only official source of Comenda rack codes. Reading the pages and mapping each embedded
image to its caption by rectangle position:

| Item | Comenda code | Colour in the catalogue | Size |
|---|---|---|---|
| Combination rack | (unnumbered) | white / light grey | 350×350 and **400×400** |
| Open combination rack | **CB** | **blue** | 500×500, h 75 mm |
| Open racks, taller | CBR 1 / 2 / 3 / 4 | blue | 500×500, h 100/150/200/250 mm |
| Plate rack | **P 12/18** | **green** | 500×500, 12 deep or 18 flat plates |
| Plate rack | P 10 | white / light grey | 400×400 |
| Cutlery basket, 8 compartments | **CP 8** | **orange** | half-size (500×250) |
| Silver container | G | orange | ~90×90×110 mm pot |
| Cutlery, 16 containers | CG 16 | orange pots in a blue rack | 500×500 |

**Correction to the archived research:** it stated "Comenda's racks are grey" and "Comenda publishes
no 8-compartment code". Both are wrong. Its rack livery is blue/green/orange, and `CP 8` is exactly
an 8-compartment cutlery basket.

### 5.2 Resolution ceiling for Comenda-branded rack imagery: ~292 px, proven

Every embedded image in the ENG and ITA racks catalogues was extracted (106 objects). The largest
rack thumbnail is **292 × 205**; the only larger asset in the file is the 829 × 1173 cover shot
(a stylised close-up of a blue rack with a wine glass — staged in `_brand-reference\`).
The Equilybra and Prime brochures contain no rack renders at all beyond the datasheet kit images.
The media API returns nothing for `rack` or `cestell`.

The **one improvement** over the archived research: the P 12/18 plate rack appears in the **EC44
datasheet** at **605 × 460**, three times bigger than the 181 × 146 catalogue thumbnail. Staged
against both `IMG/DWW/00157` and `IMG/DWW/00158`.

### 5.3 The representative photographs — sources, this time recorded

The archived research staged nine generic rack files and then could not recover the URLs they came
from. Every file staged in this pass has a live, verifiable source URL in `_sourced.json`.

Two high-resolution channels did the work:

- **GGM Gastro's Bynder DAM** — product pages expose `https://ggm.bynder.com/asset/<uuid>/JPG/<PARTNO>.jpg`
  at **3000 × 3000**, and the filename is the manufacturer part number.
- **KaTom's Cloudinary** — `https://assets.katomcdn.com/q_auto,f_auto,w_4000/products/144/<PART>/<file>.jpg`
  serves the **4000 × 4000** original, and the version segment in the path is optional. The page
  markup only ever exposes ~700 px derivatives; the width transform is the whole trick.
- **storageboxshop.co.uk** (Shopify, `/products.json`) carries the **FRIES** rack range at 1500 × 1500.
  FRIES is the European 500×500 / 400×400 rack standard-bearer and its shapes and colours are the
  closest visual match to Comenda's own racks.

| SKU | What was staged | Part | Pixels | Relationship to the Comenda item |
|---|---|---|---|---|
| 00032 | 4 views + 1 in-rack view | Cambro **8FBNH434151** / **8FB434151** | 4000 / 3000 | Same format (8-compartment half-size cutlery basket) as Comenda **CP 8**; grey vs Comenda orange. Our record says "beige", which is closer to the Cambro grey than to Comenda's orange — worth noting when deciding what this SKU really is. |
| 00033 | 2 views | **FRIES 400 mm base rack** | 1500 | Same format, size and colour as Comenda's own "Combination rack 400×400 mm". |
| 00156 | 4 views | **FRIES CR500-73** (blue + grey), Cambro **BR258186** (navy), **BR258110** (black) | 1500 / 4000 / 3000 | CR500-73 is the closest: 500×500 open rack, **73 mm** high, **blue** — against Comenda's CB at 500×500, **75 mm**, **blue**. The Cambro parts are US-market 19¾ in (502 mm) and 101 mm high. |
| 00157 | 4 views | Cambro **PR314151** 9×9 peg rack, **FRIES P18** plate racks | 3000 / 1500 | Cambro rates PR314151 for 18 × 25.4 cm plates, matching Comenda's P 12/18 "18 flat plates". Comenda's is green and slotted; the Cambro is grey and pegged. |

**Every one of these carries `REPRESENTATIVE` in its filename.** Two of the Cambro shots show a
moulded Cambro logo at full size. They are honest illustrations of what a 500×500 open rack or an
8-compartment cutlery basket looks like. They are **not** photographs of Comenda parts and must not
be captioned as such.

---

## 6. Wrong-series and rejected imagery

- **steelkitchenonline.com** (`/ae/product/comenda-undercounter-dishwasher`) titles its page
  "RF45-1 – EF36M" and serves a 2000 × 2083 photograph of a **red-panel Comenda** — an older
  RF/LF-generation undercounter, not the green-panel Equilybra EF36 M. Series contradiction; not
  staged. It also serves a 1080 × 1080 "RF45-1 - EF36M.png" which *is* the right machine but is an
  upscale of the 540 × 718 brochure render. Both rejected.
  Worth flagging separately: **our SAP remark for EF36M does not match the EF36 M datasheet.**
  SAP says 21 l tank, 30/20 racks/h, booster 3 kW, tank 2 kW, wash pump 0.45 kW. The datasheet says
  20 l tank, 40 racks/h, booster 2.5 kW, tank 2 kW, wash pump 0.66 kW. Those numbers look like the
  predecessor LF/RF-series machine — the same generation steelkitchenonline is photographing. This
  may mean the unit Sheffield actually stocks is an older model carrying a newer code, and it is
  worth confirming with the supplier before the spec is published.
- **alpha-kitchen.com** serves 1200 × 1200 marketing collages with an "ALPHA" watermark across the
  product and an "ORDER NOW" banner; the undercounter one also shows a Prime Line PF, not an EF36.
  Rejected.
- **kitchenpro.gr**'s EB28 and EF36M upscales — rejected, see §4.3.
- **kitchenpro.gr**'s EC44 page slug reads `.../rc-07-comenda-italy` while its title, its asset
  filename (`comenda_equilybra_ec44hood.jpg`) and its content are all EC44. RC07 is a different
  (Hi Line) machine. Trust the datasheet, not the reseller slug — this trap survives from the
  archived research and is still live.
- Nothing was found that appeared AI-generated. `_ai-generated\` was not created.

---

## 7. Model-number observations (recommendations only — nothing changed)

Per the standing rule, `model_number` is the unique ID and was not touched. For the record:

- **`PC-09` vs `PC 07`** differ in punctuation in our own data — hyphen on one, space on the other.
  Comenda writes both without a separator (`PC09`, `PC07`). Flagged, not fixed.
- **`CB-12/18`** (IMG/DWW/00156) concatenates two separate Comenda codes: `CB` (the combination
  rack) and `P 12/18` (the plate rack). They appear side by side in every machine's standard rack
  kit — "2 dish racks P12/18 / 1 combination rack CB h 75 mm / 1 cutlery holder G" — which is
  almost certainly how they got merged. The correct code for this product is **`CB`**.
- **`PR`** (IMG/DWW/00157) is a house code. Comenda's plate rack is **`P 12/18`** (500×500);
  the 400×400 equivalent is `P 10`, the pizza version `P 14`.
- **`N/A`** on IMG/DWW/00032 — the best candidate is **`CP 8`**.
- **`N/A`** on IMG/DWW/00033 — most likely the **combination rack 400 × 400 mm h.150**, which is
  the rack shipped as standard with the EB28 glasswasher. That also makes it a natural cross-sell
  against IMG/DWW/00160.

---

## 8. Tooling notes for the next pass

- **PyMuPDF `extract_image()` beat page rasterisation everywhere**, but only paid off on
  *brochures*, never on datasheets — datasheet XObjects come out at exactly the size the PDF shows.
  The one 1864 × 1960 win came from a superseded brochure revision.
- **Soft masks matter.** Most Comenda product XObjects are JPEG-2000 with a separate `/SMask`.
  `extract_image()` returns the base without the mask, which renders as black speckle around the
  product. Recompositing the mask onto white is required, and the mask sometimes needs resizing.
- **WordPress `/wp-json/wp/v2/media` paged in full** (not `?search=`) is what proves a ceiling.
  A search query would have missed that `PC07.png` is the only large PC asset on the entire site.
- **OpenCart cache-path stripping** still works: `/image/cache/<path>/<name>-1000x1000-...jpg`
  → `/image/<path>/<name>.jpg`. And OpenCart upload directories are often directly guessable
  by model name, which found two of the three kitchenpro files without a single search query.
- **Cloudinary width transforms are the highest-yield trick for US foodservice parts.**
  KaTom exposes ~700 px in markup and 4000 px via `w_4000`; the `/v<timestamp>/` segment is optional.
- **Bynder DAMs name assets by manufacturer part number**, so one product page leaks the part
  numbers and 3000 px masters of every related product on it.
- **Shopify `/products.json?limit=250&page=N`** gave the entire FRIES rack range with native
  dimensions in one request, which is how the 400×400 and CR500-73 matches were found at all.
- **Render everything.** Two of the six highest-resolution candidates in this pass were upscales,
  and neither was detectable from size, byte count or filename.
