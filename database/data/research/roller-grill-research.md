# Roller Grill Product Research

Supersedes `old/roller-grill-research.md`. Sourcing/verification pass, August 2026, run
against the SAP dossier. Covers both ROLLER GRILL SKUs: the **GR 80 E** electric
gyros/shawarma grill (`IMG/HOT/00099`) and the **RFG 12** gas fryer (`IMG/HOT/00098`).

**No `products.json` or `brands.json` change has been applied.** Findings only.

Both SKUs were taken all the way to the manufacturer's own technical sheet **and** its
installation/user manual, and both model codes are proven on the assets themselves.

---

## 1. Brand identity - confirmed, no change needed

**ROLLER GRILL INTERNATIONAL S.A.S**, 16 rue Saint-Gilles, **28800 Bonneval, France**
(Eure-et-Loir). Tel +33 (0)2 37 44 67 67. French manufacturer of professional kitchen
equipment since 1947; 100% French production, 350+ products, sold in 100+ countries.

`brands.json` stores https://www.rollergrill-international.com/en/ - **correct and live**
(HTTP 200). The bare apex redirects to `/fr/`, so keeping the explicit `/en/` is the better
choice. No change required.

## 2. Where to look

| Resource | URL |
|---|---|
| GR 80 E product page | https://www.rollergrill-international.com/en/professional-range/163/16/cooking/gyros-grills/gyros-grills/electric-gyros-grill-800-mm-high-spit-40-kg-of-meat-detail |
| RFG 12 product page | https://www.rollergrill-international.com/en/professional-range/170/12/cooking/professional-fryers/professional-fryers/professional-gas-fryer-1-tank-of-12-l-detail |
| GR 80 E technical sheet DT128 | https://www.rollergrill-international.com/images/stories/virtuemart/product/Technical-sheet-kebab-electric-grill-GR80E-DT128-Ind-A.pdf |
| GR 40/60/80 E manual | https://www.rollergrill-international.com/images/stories/virtuemart/product/Manual-electric-gyros-grills-GR-G03115.pdf |
| RFG 12 B technical sheet DT110 | https://www.rollergrill-international.com/images/stories/virtuemart/product/Technical-sheet-gas-fryer-RFG12B-DT110-Ind-B.pdf |
| RFG 8 + RFG 12 B manual | https://www.rollergrill-international.com/images/stories/virtuemart/product/Manual-gas-fryers-RFG12B-RFG8-G033635.pdf |
| Legal notice / registered address | https://www.rollergrill-international.com/fr/mentions-legales.html |

### Traps

1. **The technical-sheet download link is login-gated, but the file is public.** The page
   renders it as an inert `<span href="#">` with a `downloadlocked` icon. The `title`
   attribute carries the exact filename stem - append `.pdf` under
   `/images/stories/virtuemart/product/` and it fetches anonymously. **Still working
   August 2026.** Reuse for any future Roller Grill SKU.
2. **The technical sheet is a drawing pack, not a spec table.** DT128/DT110 give a 3D view,
   exploded view, parts list, wiring diagram and dimensioned drawing - but **no voltage**.
   Voltage only appears in the *manual*'s technical-characteristics table. Pull both.
3. **Product images are lazy-loaded** and the site now serves `.webp`; the `.jpg` twin still
   exists at the same stem.
4. **"Pick the biggest file" is wrong on this brand** - see section 5.
5. Some UK reseller spec tables drift from Roller Grill's own numbers (height 1045 vs 1035,
   "40-50 kg" vs 40 kg, "17.3 A" which is just 7200/415 arithmetic rather than a per-phase
   current). Prefer the manufacturer.
6. `cateringhygiene.co.uk` and `ekuep.com` now return **403** to automated fetches; the
   1100 x 1100 GR 80 E copy an earlier pass found on cateringhygiene is **gone** (that URL
   now serves a 116 x 130 placeholder).

## 3. IMG/HOT/00099 - GR 80 E

Roller Grill's own spec table (catalogue page, and manual page 9 FR / page 17 EN):

| | Roller Grill | Our record | SAP |
|---|---|---|---|
| Outside dimensions | **580 x 660 x 1035 mm** | 580 / 660 / 1035 | blank |
| Capacity | 40 kg | 40 kg | 40 kg |
| Power | 7.2 kW (7250 W) | 7.2 kW | 7.2 kW |
| Weight | 35 kg | 35 kg | 35 kg |
| Spit height | 800 mm | 800 mm | 800 mm |
| Elements | 5 x Incoloy 1450 W / 230 V | 5 | 5 |
| Current | 6.3 A / phase | - | - |
| Voltage | **380-415 V 3 N ~** | "380 v" | "380 v" |

**Our stored dimensions now match Roller Grill exactly.** SAP records no dimensions for this
SKU at all (blank, i.e. missing - not zero). The DT128 dimensioned drawing's 566 x 636 x 1016
is the bare cabinet excluding roof lip and knobs; not a contradiction.

Sibling figures from the same manual table, useful if the range is extended:
GR 40 E 580 x 660 x 690, 3 elements, 15 kg, 3600 W, 16 A, **220-240 V ~**;
GR 60 E 580 x 660 x 860, 4 elements, 25 kg, 5800 W, 6.3 A/phase, 380-415 V 3N~.

### 3.1 Electrical - three-phase, and the record does not say so

**380-415 V 3N~, approximately 6.3 A per phase, 7250 W.** Corroborated by the DT128 wiring
diagram: a five-terminal domino fed by three phases + neutral + earth, cable **H07 RN-F
5G1.5**, five 1450 W / 230 V elements grouped 2+2+1 across the three phases via three
commutators.

- **No frequency figure is printed** in either Roller Grill document. The appliance conforms
  to IEC/EN 60335-1 and -2-48; the elements are resistive and frequency-indifferent, only the
  spit motor is sensitive, and the machine is sold into 50 Hz Europe. Treat as **50/60 Hz**,
  but note the figure is genuinely absent from the manufacturer's paperwork rather than
  omitted by us.
- **Kenya: compatible.** 415 V 3-phase / 240 V phase-neutral at 50 Hz is inside the stated
  380-415 V 3N~ band, and each 230 V element simply runs about 9% hotter on 240 V.
- ⚠ **The record hides a real installation requirement.** It says only "Volts : 380 v", which
  reads like a plug-in appliance. It is not: the manual requires a means of disconnection in
  the fixed wiring for the GR 60 E and GR 80 E - i.e. **hardwired to a three-phase board by a
  qualified electrician**.
- ⚠ **A wrong-market variant exists.** Equipex/Spring USA sell the same machine in the USA as
  the "Everest Gyro Grill GR80E" at **208/240 V three phase** -
  https://springusa.com/shop/gr80e-everest-gyro-grill.html . Any future pass sourcing this SKU
  from a US site will find that figure. Our stored 380 V is on the correct European side.

### 3.2 Code form

Roller Grill writes **`GR 80 E`** with spaces on the product page, in the quote link and in
both PDFs' title blocks; **`GR80E`** closed up in its own filenames, which is also what every
distributor uses. Spacing convention, not a transcription error. **No `model_number` change
proposed** - `model_number` is the unique ID.

## 4. IMG/HOT/00098 - RFG 12

Roller Grill's own spec table (catalogue page) and manual:

| | Roller Grill | Our record | SAP remark |
|---|---|---|---|
| Outside dimensions | **400 x 700 x 325 mm** (+180 mm flue) | 400 / 700 / 325 | 400 (W) x 700 (D) x 325 (H) |
| Basket | 250 x 270 x 110 mm | - | 250 x 270 x 110 mm |
| Power | **8 kW** (G30/G31 and G20/G25) | - | ⚠ "8 kW to 9 kW" |
| Weight | 34 kg | - | 34 kg |
| Tank | 12 L | - | 12 L |

- 🔴 **SAP's "8 kW to 9 kW" is wrong.** Roller Grill states a flat **8 kW** on every gas type,
  in both language halves of the manual (pages 9 and 19). No 9 kW figure exists anywhere.
- 🔴 **SAP's description calls this a "PASTA FRYER"** ("PASTA FRYER ROLLER GRILL"; the remark
  opens "Pasta Fryer Capacity"). It is a **deep fat fryer** - Roller Grill's own designation
  is "Professional gas fryer - 1 tank of 12 L". The remark's uniform `~` hedging ("~12
  litres", "~8 kW to 9 kW", "Up to ~190 C") reads like generated filler, not a transcribed
  datasheet. Treat the whole remark as low-confidence.
- The DT110 dimensioned drawing gives **400 x 697 x 500 overall**, which reconciles with the
  catalogue's 325 body + 180 flue (505). Not a contradiction. The gas inlet sits 267 mm from
  the left, the drain tap centre at 191 mm.
- **Electrical: none.** Pure gas appliance, piezo ignition, no mains connection. Nothing to
  check against Kenyan supply.
- Gas detail worth carrying into the record: **G30/G31 LPG or G20/G25 natural gas**; ships
  LPG-jetted (injector Ø110) with the natural-gas jets (Ø155) supplied loose in the box;
  consumption 630 g/h G30, 621 g/h G31, 846 l/h G20, 983 l/h G25; combustion air **16.3 m3/h**;
  **10 cm** minimum wall clearance; max gas bottle 143 x 30 cm (35 kg), used vertically;
  thermostat positions 1-8; safety drain tap; optional **MS-RFG 12** stainless cabinet with
  150 mm feet.
- Engineering documents call it **`RFG 12 B`**; the commercial catalogue calls it `RFG 12`.
  `B` is a production index for the same machine. **No `model_number` change proposed.**

## 5. Images - "pick the biggest" is wrong here, and it was measured

Roller Grill shoots exactly **one studio render per model** and the whole trade reuses it -
checked across six distributors. There is no second photograph anywhere on the open web.

The largest *file* for the GR 80 E is a distributor's 1080 x 1080 square. The best *image* is
the raster embedded in Roller Grill's own manual. Measured by product content bounding box
(near-white background thresholded out):

| Asset | Canvas | Actual product content |
|---|---|---|
| https://mariotstore.com/wp-content/uploads/2024/10/GR-80-E.jpg | 1080 x 1080 | **508 x 799** |
| https://www.paramountme.com/uploads/products/gallery/RGSMGR80EFR.jpg | 700 x 800 | 468 x 738 |
| **Manual `G03115.pdf` p1, extracted with PyMuPDF** | 841 x 1168 | **737 x 1092** |
| Roller Grill's own web render | 401 x 600 | 351 x 554 |

The "smaller" file carries **1.45x the linear detail** of the "bigger" one. Same story on the
RFG 12: manual extract 826 x 919 of content against 561 x 624 for the official web render.

**The PDFs supply the only genuinely new angles.** Both technical sheets are vector (not
rasterised - `get_text()` returns 5057 and 4299 characters), so their drawings only become
images by rendering the page at high dpi:

- **`Vue 3D`, page 1** - an official CAD 3/4 view with the model code stamped in the title
  block. Different angle *and* self-labelling, so it proves the code without relying on a
  filename.
- **`Mise en plan`, page 5 (GR 80 E) / page 4 (RFG 12)** - dimensioned orthographic drawings.

### 5.1 Files staged

Folder: `Desktop\ecommerce\products resorce final\roller-grill\`. 9 images + 4 PDFs.

| SKU | File | Px | Source |
|---|---|---|---|
| 00099 | `...GR80E-roller-grill-1.png` | 841 x 1168 | manual PDF p1, PyMuPDF extract |
| 00099 | `...GR80E-roller-grill-2.jpg` | 1413 x 2000 | DT128 p1 `Vue 3D` @ 400 dpi |
| 00099 | `...GR80E-roller-grill-3.jpg` | 1413 x 2000 | DT128 p5 `Mise en plan` @ 400 dpi |
| 00099 | `...GR80E-roller-grill-4.jpg` | 1080 x 1080 | https://mariotstore.com/wp-content/uploads/2024/10/GR-80-E.jpg |
| 00098 | `...RFG-12-roller-grill-1.png` | 935 x 958 | manual PDF p7, PyMuPDF extract |
| 00098 | `...RFG-12-roller-grill-2.jpg` | 1413 x 2000 | DT110 p1 `Vue 3D` @ 400 dpi |
| 00098 | `...RFG-12-roller-grill-3.jpg` | 1413 x 2000 | DT110 p4 `Mise en plan` @ 400 dpi |
| 00098 | `...RFG-12-roller-grill-4-detail.png` | 1012 x 519 | manual PDF p1 - below the 800 px floor, detail only |
| 00098 | `...RFG-12-roller-grill-5.jpg` | 800 x 595 | https://assets.catering-appliance.com/media/inside-sqr-2048/18/0e/roller-grill-rfg12_img24517.jpg - below floor, but the only shot with the lid off and laid beside |

PDFs staged: DT128, DT110, and both manuals. The manuals are tokenised **`SHARED-DOC`** -
`G03115` covers GR 40/60/80 E, `G033635` covers RFG 8 + RFG 12 B. The two DT sheets are
single-model and are not shared.

### 5.2 Verification

**Every image was rendered before acceptance. None is AI-generated**; no `_ai-generated/`
folder was needed. Files `-1` are manufacturer studio photography pulled losslessly from
Roller Grill's own print files; `-2`/`-3` are CAD output signed by named draughtsmen (R.L.,
R. Schoenberger, S. Grenon, J. Godere) and dated.

**Model identity proven, not assumed.** The GR 80 E is distinguished from its siblings by
control-knob count - GR 60 E has 2 commutators on a shorter cabinet, GR 80 E has **3** on the
tall one. Every GR 80 E file kept shows 3 knobs and the tall cabinet, and the CAD views carry
the code in the title block.

**Perceptual hashing** (16 x 16 ahash shortlist, then per-pixel RMS on 256 x 256 greyscale):

- fryer manual p7 vs p17: ham 0, RMS **0.59** -> same asset, only the larger kept
- gyros manual p1 vs p7: ham 1, RMS **0.80** -> same asset, larger kept
- official RFG 12 web render vs manual extract: ham 12, RMS **11.4** -> same render, different
  crop. **This is what proves the manual image is the RFG 12 and not the RFG 8** that shares
  the same manual.
- official GR 80 E web render vs manual extract: ham 2, RMS **5.1** -> same render

No cross-SKU photo sharing exists in this brand - the two SKUs are different machines with
different photography, so no `REPRESENTATIVE-RANGE` file was needed.

### 5.3 Ceilings

**GR 80 E: 841 px short edge** (real detail 737 x 1092). **RFG 12: 935 px short edge.**
Distributors checked and beaten: mariotstore, paramountme, advantage-catering (Shopify
`/products.json`, 1000 x 750 max), vitrumgroup (Shopify, 694 x 635 regardless of `?width=`),
caterkwik (717 x 567), catering-appliance (800 x 595 - its `inside-sqr-2048` path token is
misleading, larger tokens 404).

## 6. Product reference

| SKU | Model | Roller Grill's code | Confidence |
|---|---|---|---|
| IMG/HOT/00099 | GR80E | **GR 80 E** (DT128) | **High** - official page + technical sheet + manual, code stamped on the CAD asset |
| IMG/HOT/00098 | RFG 12 | **RFG 12** commercial / **RFG 12 B** engineering (DT110) | **High** - same |

Supporting sources:

- https://www.rollergrill-international.com/en/professional-range/16/cooking/gyros-grills.html
- https://www.rollergrill-international.com/en/professional-range/12/cooking/professional-fryers.html
- https://mariotstore.com/shop/cooking-line/shawarma-machines/electric-gyros-grill-gr-80-e/
- https://www.paramountme.com/shop-product/roller-grill-gr-80-e-electric-shawarma-machine-table-top-40-kg-of-meat-rgsmgr80efr
- https://www.advantage-catering-equipment.co.uk/products/roller-grill-gr-80-e-electric-kebab-grill
- https://www.catering-appliance.com/roller-grill-rfg12-12-ltr-propane-gas-countertop-single-tank-fryer-1-x-basket
- https://www.caterkwik.co.uk/cgi-bin/trolleyed_public.cgi?action=showprod_RFG12
- https://shop.vitrumgroup.org/products/roller-grill-rfg-12
- https://springusa.com/shop/gr80e-everest-gyro-grill.html (US 208/240 V variant - do not use)

Sibling models on the same pages: **GR 40 E / GR 60 E / GR 80 G** (gyros grills),
**RFG 8 / RFG 16 / MS-RFG 12 / CW 12** (fryers and accessories).
