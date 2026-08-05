# Skymsen - SAP-led research redo (July 2026)

Full re-do of the Skymsen pass. The earlier notes are archived at
`database/data/research/old/skymsen-research.md`; several of their conclusions are
**wrong** and are corrected below. Nothing in `products.json` was changed.

Scope: all **28** SKYMSEN-branded SKUs, including the 4 variant children that exist only
inside the `GROUP/BLENDER-KITCHEN-SS` parent. Every SKU is covered.

Staging folder: `Desktop\ecommerce\products resorce final\skymsen\`
198 product images + 26 spec-sheet PDFs, plus three quarantine sub-folders
(`_wrong-model\`, `_ai-generated\`, `_brand-reference\`) whose contents are deliberately
**not** product photography.

---

## 1. Sources used

Manufacturer:

- https://www.skymsen.com/sitemap.xml
- https://www.skymsen.com/robots.txt
- https://www.skymsen.com/en/index.php/produtos
- https://www.skymsen.com/en/index.php/componentes
- https://www.skymsen.com/en/index.php/produtos/detalhe/710040
- https://www.skymsen.com/en/index.php/produtos/detalhe/472719
- https://www.skymsen.com/en/index.php/produtos/detalhe/472778
- https://www.skymsen.com/en/index.php/produtos/detalhe/472808
- https://www.skymsen.com/en/index.php/produtos/detalhe/411663
- https://www.skymsen.com/en/index.php/produtos/detalhe/422207
- https://www.skymsen.com/en/index.php/produtos/detalhe/589942
- https://www.skymsen.com/index.php/produto/centrifuca-de-sucos-cse-skymsen-220v
- https://www.skymsen.com/en/index.php/produtos/detalhe/704288
- https://www.skymsen.com/en/index.php/produtos/detalhe/352268
- https://www.skymsen.com/en/index.php/produtos/detalhe/041173
- https://www.skymsen.com/en/index.php/produtos/detalhe/623946
- https://www.skymsen.com/en/index.php/produtos/detalhe/658812
- https://www.skymsen.com/en/index.php/produtos/detalhe/461644
- https://www.skymsen.com/en/index.php/produtos/detalhe/324760
- https://www.skymsen.com/index.php/produtos/detalhe/452009
- https://www.skymsen.com/en/index.php/produtos/detalhe/610909
- https://www.skymsen.com/en/index.php/produtos/detalhe/094340
- https://www.skymsen.com/en/index.php/produtos/detalhe/096130
- https://www.skymsen.com/en/index.php/produtos/detalhe/096121
- https://www.skymsen.com/en/index.php/produtos/detalhe/096059
- https://www.skymsen.com/en/index.php/produtos/detalhe/676470
- https://www.skymsen.com/uploads/produtos/folders/710040_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/411663_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/422207_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/589942_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/582344.pdf
- https://www.skymsen.com/uploads/produtos/folders/704288_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/352268_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/041173_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/623946_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/658812_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/461644_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/324760_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/452009.pdf
- https://www.skymsen.com/uploads/produtos/folders/610909_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/496049_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/685291_eng.pdf
- https://www.skymsen.com/uploads/produtos/folders/661805.pdf

Export brand (Skyfood, USA - same factory):

- https://www.skyfood.us/products.php?familia=5
- https://www.skyfood.us/photos/PC0720.JPG
- https://www.skyfood.us/photos/PC0721.JPG
- https://www.skyfood.us/photos/PC0725.JPG
- https://www.skyfood.us/photos/PC0730.JPG
- https://www.skyfood.us/photos/PC0709.JPG
- https://www.skyfood.us/photos/PC0727.JPG
- https://www.skyfood.us/photos/PC0714.JPG

Distributors / resellers:

- https://www.kitchenall.com/skyfood-w4-scallop-cut-5-32-4-mm.html
- https://www.kitchenall.com/skyfood-gc16-dicing-disc-5-8-16-mm.html
- https://www.kitchenall.com/skyfood-si-282hde-2-heavy-duty-meat-and-bone-saw-111-blade-2-hp-220v-60hz-3-phase.html
- https://www.katom.com/248-SI282HDE1.html
- https://res.katom.com/products/248/248-SI282HDE1/248-SI282HDE1.pdf
- https://salvadorcomercial.com.br/products/forno-turbo-eletrico-compacto-digital-220v-com-vapor-4-assadeiras-conveccao-maxiconv-vp-skymsen

Third-party manufacturer for the three `DAK` rows:

- http://www.dak.com.br/index.php/produtos/1/cortadores-de-legumes
- http://www.dak.com.br/index.php/detalhe-produto/4/cortador-de-legumes-medio
- http://www.dak.com.br/index.php/detalhe-produto/5/cortador-de-legumes-grande
- http://www.dak.com.br/index.php/detalhe-produto/10/cortadores-de-legumes-medio-grande-parede-
- http://www.dak.com.br/index.php/detalhe-produto/13/espremedores-de-pure-grande

---

## 2. Method, and how images were actually verified

The whole `produtos` tree was enumerated (232 live detail pages across all `linhas`/`familia`
combinations), then each page parsed for its model code, its Technical-characteristics block,
its image list and its folder PDF. Discontinued models (LAR-08MB, LAR-10MB, DB-25HD, BMS-3-N)
are no longer linked from any listing but their detail pages still resolve, so they were
probed by id directly.

**No image was accepted on an HTTP 200.** Every candidate was opened and looked at. The
decisive test on this brand is the cup/body decal, which Skymsen prints with the model code
on it - `SEAMLESS CUP / VASO MONOBLOQUE / NO WELDING / SIN SOLDADURAS / LAR-xxMB / PATENTED`
on the blenders, `SUPER 0,5 CV HP` on the uprated juicer, `MAXI BLENDER` vs `SUPREME BLENDER`
on the 2 L blenders, spindle count on the milkshake mixers. Every accepted file was matched
that way or extracted from the model's own spec sheet.

Spec-sheet renders were recovered with PyMuPDF embedded-object extraction (`page.get_images()`
+ `doc.extract_image()`), recompositing each object against its soft mask; this returns the
artwork at native size, 2-3x what the website serves.

---

## 3. Image-sourcing defects found on skymsen.com (this is the important part)

### 3.1 The product-page gallery is family-wide, not per-model

`/photos/FOTOxxxx.JPG` files are shared across every member of a family. `FOTO1542`
(LAR-03MB), `FOTO1532` (LAR-04MB), `FOTO1533` (LAR-06MB), `FOTO1534` (LAR-08MB), `FOTO1538`
(LAR-10MB) and `FOTO1531` (LAR-02MB) all appear together on **every** LAR page. Same on the
peelers: `FOTO1571`/`FOTO1570` sit on the DB-10 and DB-25HD pages but are DB-06/DA-06/DAL-06S
machines. Same on the band saws (one gallery shared by SF-218 / SF-282 / SF-295 / SFL-282HD)
and the juicers (ES / ESB-N / ESB SUPER-N / ESL / EX / EX SUPER).

Scraping a page and attributing its gallery to that page's model is therefore **guaranteed**
to mis-attribute. Each file had to be identified by decal and re-filed. 25 wrong-model files
are staged in `_wrong-model\` with names that say what they actually are.

### 3.2 The `uploads/produtos/fotos/<MODEL>-*.png` filenames also lie

The LAR-10MB page serves five component renders named `lar-08mb-5.png` ... `lar-08mb-9.png`.
They are byte-identical (MD5) to the LAR-04MB page's `lar-04mb-1.png` ... `lar-04mb-5.png`.
Five generic LAR component views are reused across the whole line under whatever filename the
page editor happened to type. A model code in a filename is not evidence.

### 3.3 AI-generated imagery is still live on skymsen.com

Nine files are generated, not photographed. Four are self-identifying - the filename is the
literal image prompt, e.g.
`potato-peeler-as-the-central-focus-on-a-gleaming-s-1762190654607.png`,
`a-professional-juice-extractor-440-mm-in-height-1762191866861.png`,
`an-artful-representation-of-an-industrial-band-saw-1761825821867.png`,
`use-the-image-of-the-blender-exactly-as-it-is-wit-1758562337865.png`.
Two more (`cse.png`, `db-25hd.png`) are 600x600 at 716 KB and 792 KB - three to six times the
file size of a genuine 600x600 studio render from the same site, which remains a reliable
tell. The `cse.png` scene does not even show a centrifugal extractor; it shows a citrus press.
All nine are in `_ai-generated\`.

**Correction to the old research:** the 800x533 `lar-03mb.jpg` / `lar04.jpg` / `lar08.jpg` /
`lar10.jpg` kitchen scenes were previously condemned as AI. They are not. The cup decal reads
`LAR-03MB` etc. crisply at full resolution, the Skymsen wordmark is undeformed, and the
background is a coherent shallow-depth-of-field kitchen. They are studio renders composited
into a photographed kitchen. They are staged as normal lifestyle images.

### 3.4 A reseller stock-photo contamination

`https://www.kitchenall.com/media/catalog/product/b/o/bone_saw_new_pic_2.jpg` is served on the
Skyfood SI-282HDE-2 page but is a generic unbranded Chinese benchtop bone saw - wrong form
factor, wrong brand, not a floor model at all. Filed in `_wrong-model\`.

### 3.5 A wrong-product citation in the previous research

The old notes give `skymsen.com/.../096091` as the W4 page. `09609.1` is **V - fine grater
disc**. The real W4 code is `09616.4` (`*SCALLOP CUT DISC - 4 mm`, spare-parts-only, no detail
page).

---

## 4. Dimensions - SAP is wrong on 16 of 17 machine SKUs; `products.json` is right on all 17

Skymsen publishes dimensions as **H x W x L** in English and **A x L x P** (altura x largura x
profundidade) in Portuguese. The two agree, which proves the English "L" is the **depth**.
Our `length` / `width` / `height` triple is the exact reverse of Skymsen's HxWxL string, and
`width` genuinely holds the width. **The usual catalogue-wide width/depth swap does not affect
Skymsen** - checked on all 17.

| SKU | model | SAP L/W/H | ours L/W/H | manufacturer H x W x L | verdict |
|---|---|---|---|---|---|
| IMG/FPR/00033 | LAR-03MB | 660/240/255 | 260/275/630 | 630 x 275 x 260 | ours right, SAP wrong |
| IMG/FPR/00034 | LAR-04MB | 630/275/260 | 260/275/630 | 630 x 275 x 260 | ours right; SAP has the right numbers in H/W/L order, i.e. reversed |
| IMG/FPR/00036 | LAR-08MB | 600/290/280 | 320/330/750 | 750 x 330 x 320 | ours right, SAP wrong |
| IMG/FPR/00037 | LAR-10MB | 600/290/280 | 330/340/780 | 780 x 340 x 330 | ours right, SAP wrong (identical row to 00036) |
| IMG/FPR/00038 | LAR-25LMB | 601/350/1200 | 525/410/1180 | 1180 x 410 x 525 | ours right, SAP wrong |
| IMG/FPR/00040 | CSE | 350/600/570 | 280/480/680 | 680 x 480 x 280 | ours right, SAP wrong |
| IMG/FPR/00042 | PA7 PRO | 450/320/610 | 520/325/590 | 590 x 325 x 520 | ours right, SAP wrong |
| IMG/FPR/00048 | DB-25HD | 1135/650/825 | 670/550/1155 | 1155 x 550 x 670 | ours right, SAP wrong |
| IMG/FPR/00051 | SI-282HD | 800/820/1730 | 980/900/1900 | SFL-282HD 1900 x 900 x 980; Skyfood SI-282HDE-1 1873 x 921 x 971 | ours right, SAP wrong |
| IMG/FPR/00169 | BM2 | 0/0/0 | 230/205/505 | 505 x 205 x 230 | ours right, SAP empty |
| IMG/FPR/00214 | ESB SUPER-N | 270/360/440 | 270/360/440 | 440 x 360 x 270 | **both right** - the only such row |
| IMG/FPR/00215 | CFI-300L-N | 570/560/540 | 570/560/440 | 440 x 560 x 570 | ours right; SAP height 540 should be 440 |
| IMG/FPR/00246 | DB-10 | 500/350/40 | 580/475/720 | 720 x 475 x 580 | ours right; SAP height "40" is nonsense |
| IMG/ICE/00019 | BMS-N | 180/160/490 | 150/210/470 | 470 x 210 x 150 | ours right, SAP wrong |
| IMG/ICE/00020 | BMS-3-N | 260/470/490 | 260/460/470 | 470 x 460 x 260 | ours right, SAP wrong |
| IMG/OVE/00214 | DISCOVERY 10 | 1490/1070/1900 | 1590/1070/1900 | 1900 x 1070 x 1590 | ours right; SAP depth 1490 wrong |
| IMG/OVE/00215 | MAXICONV | 680/600/430 | 700/590/435 | 435 x 590 x 700 | ours right, SAP wrong |

**Do not bulk-apply SAP dimensions to Skymsen.** They would corrupt 16 correct records.

The four `IMS/MEC/*` disc SKUs and the DAK rows carry 0/0/0 in both SAP and `products.json`.
The disc diameter for the PA7 PRO family is **203 mm** (per the PA7 PRO folder and the H3 part
page); no thickness figure is published.

### Weights

SAP stores a weight on only four rows and gets three of them wrong:

- IMG/FPR/00214 ESB SUPER-N: SAP 11.4 kg. Manufacturer net 7.90 / gross 9.10 kg. Neither.
- IMG/FPR/00215 CFI-300L-N: SAP 40.0 kg = the **gross** weight; net is 27.00 kg.
- IMG/OVE/00214 DISCOVERY 10: SAP 250 kg. Manufacturer net 326 / gross 425 kg.
- IMG/OVE/00215 MAXICONV: SAP 35 kg. Manufacturer net 29.00 / gross 32.00 (SV) or 34.20 (VP).

---

## 5. SAP remark-text defects

The SAP `Remarks` field is the only prose source for these SKUs and it carries several
copy-paste failures. Verified against the manufacturer figures.

- **IMG/ICE/00020 BMS-3-N** - the remark ends with *"Disc diameter 273 mm ... Disc Speed 438
  rpm - Output 250 kg/hr - Power Rating 0.5 CV ... Net Weight 22 kg"*. A three-spindle
  milkshake mixer has no disc and no kg/h output; those are **food-processor** specs. Actual:
  3 x 500 W motors, 200 W rated each, 15,000 rpm, 0.8 L per cup (x3), net 9.30 / gross 11.00 kg.
- **IMG/ICE/00019 BMS-N** - remark says gross 16 kg / net 14.3 kg, 1500 W, 1.50 kW/h. Actual:
  net 3.95-4.10 kg, gross 4.55-4.70 kg, motor 500 W, rated 200 W, 0.2 kW.h, 15,000 rpm.
- **IMG/FPR/00042 PA-7** - remark says 6 discs, 0.25 HP, 438 rpm, 300-400 kg/h, net 24.5 kg.
  Current PA7 PRO: **7 discs of 203 mm**, 0.5 HP, 370 rpm at 50 Hz (440 rpm at 60 Hz),
  250 kg/h, net 27.90 / gross 31.90 kg.
- **IMG/FPR/00040 CSE** - remark opens *"Powerful commercial centrifugal juice extractor with
  1 HP motor"* and then states *"Power Rating 0.5 HP"* two lines later. It is 0.5 HP / 368 W.
  The remark's net 13.5 / gross 15.3 kg is also low: actual net 15.50 / gross 19.20 kg.
- **IMG/FPR/00051 SI-282HD** - remark says *"Anodized aluminium supporting structure of
  casing"*. Both Skymsen and Skyfood describe this machine as **entirely stainless steel**.
  "Anodized" belongs to the CFI slicer family (`INCLINED PLATE SLICER ANODIZED` in the
  spare-parts registry) - it looks like copy bleed from a slicer record.
- **IMG/FPR/00048 DB-25HD** - remark contains *"25V operator interface"*, which is garbled.
  Power 1 CV is right; consumption is 0.73 kW.h, not "820W".
- **Rotation across the blender line** - remarks say 3,500 rpm. That is the 60 Hz figure. The
  50 Hz SKUs we sell run **3,000 rpm**; the LAR-25 folder prints all three columns
  (3,500 / 3,000 / 3,500) so this is unambiguous.
- **IMG/FPR/00033 LAR-03MB** - remark says *"Capacity of the Glass: 3.6 litres"*, 3500 rpm,
  net 9.60 kg, 60 Hz. Actual 50 Hz unit: max cup volume **3 L**, 3,000 rpm, net 9.70 kg.
- **IMG/FPR/00038 LAR-25** - remark says net 39 kg and 240 V. Actual: 220 V, net 20.50 kg
  (LAR-25LMB) or 25.80 kg (LAR-25PMB) - see the open question in section 7.
- **IMG/OVE/00214 DISCOVERY 10** - remark says 300 breads per cycle (50 g); manufacturer says
  **360**. 20 kW, 230 degC, three-phase are all correct.

Remarks that check out clean: IMG/FPR/00246 (DB-10 - 0.5 hp, 0.37 kW, 200 kg/h, 10 kg per
cycle all correct), IMG/OVE/00215 (MAXICONV - 3 kW, 0.75 kW/h, 75 mm between trays, 210 degC,
48 breads all correct; it just omits that the 4 trays are **35 x 35 cm**), and IMG/FPR/00215
(CFI-300L-N - 0.33 hp, 300 mm disc, 0-15 mm slice, 160 x 160 mm cutting area all correct).

---

## 6. Model-number findings (recorded, not applied)

`model_number` is the unique ID and was not touched. For a later decision:

| SKU | stored | finding |
|---|---|---|
| IMG/FPR/00033-37 | `LAR-03MB-N`, `LAR-04MB-N`, `LAR-08MB-N`, `LAR-10MB-N` | the `-N` suffix does not exist. Skymsen's codes are `LAR-03MB` (71004.0), `LAR-04MB` (47271.9), `LAR-08MB` (47277.8), `LAR-10MB` (47280.8) - all confirmed on their own pages and on the range folder |
| IMG/FPR/00038 | `LAR 25MB` | no such model. Real: `LAR-25LMB` (41166.3) or `LAR-25PMB` (42220.7) - see 7.1 |
| IMG/FPR/00042 | `PA-7` | current production is `PA7 PRO` (70428.8). All staged imagery is PRO |
| IMG/FPR/00051 | `SI-282HD` | **genuine.** See 6.1 - the previous research's "should be SFL-282HD" is wrong |
| IMS/MEC/00274 | `H3/EH3` | **two different parts.** See 6.2 |
| IMS/MEC/02131 | `E3` | correct (`09605.9`). SAP's Model field is empty for this row |
| IMS/MEC/02319 | `14MM` | manufacturer code is `E14` (`67647.0`). SAP's Model field is empty |
| IMS/MEC/00273 | `W4` | real, `09616.4`, but spare-parts-only and **not** in the PA7 PRO range |
| IMS/MEC/00270 | `GC16` | real, `13719.7` (also `GC16-S`, `39325.8`), but **not** in the PA7 PRO range |
| IMG/FPR/00050, IMS/MEC/00309, IMS/MEC/00312 | `DAK` | not a Skymsen product at all - brand attribution is wrong |

### 6.1 SI-282HD is a real Skymsen model - the old research was wrong

Skymsen's spare-parts registry (`skymsen.com/en/index.php/componentes?modelo=SI-282`) returns
five SI-282HD entries: `28143.3`, `30184.1`, `30185.0` (220/380 V, **50 Hz**), `30923.0`,
`30934.6`, described as *"BAND SAW, STAINLESS STEEL, WITH PUSHER, COMPLETE CUT REGULATOR,
BLADE 2.820 mm / 111", HEAVY DUTY"*, 2 CV. Skyfood still sells it in the USA as
**SI-282HDE-1** (single-phase) and **SI-282HDE-2** (three-phase).

`SFL-282` / `SFL-282HD` is a **different, later model** - the registry describes it as *"WITH
MOVABLE TABLE, CUT REGULATOR"* under its own codes (`54640.2`, `54641.0`, `54642.9`,
`62394.6`...). Keep `SI-282HD`.

Consequence for the images: skymsen.com no longer publishes an SI-282HD page, so the ten
`SFL-282HD-successor-*` files staged under IMG/FPR/00051 show the **successor** machine and
are named to say so. The only images of the actual SI-282HD are the two Skyfood/KaTom ones
plus the Skyfood spec-sheet PDF.

### 6.2 H3 and EH3 are not the same disc

- `09434.0` - **H3** - `*JULIENNE - 3x3 mm (1/8")` - has a live product page and a labelled
  studio render.
- `19563.4` - **EH3** - `*SERRATED SLICER DISC - 3 mm` - spare-parts only, no page, no image.

Our `H3/EH3` conflates them. SAP's description (`DISC H3`) and remark (`Disc 3mm`) fit either.
The old research's explanation - "the casting is embossed H3-EH3, blanks are shared across
sizes" - does not hold: they have separate article numbers and separate descriptions. (The
shared-blank effect is real for W3/W4 though - see 7.3.)

### 6.3 GC16 and W4 belong to a different machine

The PA7 PRO folder, page 2, prints the complete disc list for the machine: graters V / Z3 /
Z5 / Z8; scallop **W3** only; julienne H1.5 / H3 / H7 / H10; slicers E1 / E2 / E3 / E5 / E8 /
E10 / E14; dicing grids **GC8 PRO / GC10 PRO / GC14 PRO / GC20 PRO**. Neither GC16 nor W4 is
in it, and skyfood.us's PA7 PRO accessory family lists the same set.

Every independent source ties both codes to the **MASTER SKY / MASTER SS** processors instead
(Kitchenall, JES, RestaurantStock, Culinary Depot). So the PA-7's `accessories` array, which
links IMS/MEC/00270 (GC16) and IMS/MEC/00273 (W4), is probably wrong - or these two are
legacy PA-7 (pre-PRO) parts that the current range dropped. Flagged, not changed.

---

## 7. Open questions

### 7.1 LAR-25: which stand?

`LAR-25LMB` and `LAR-25PMB` are dimensionally identical (1180 x 410 x 525 mm, 25 L nominal,
1.5 CV, 3,000 rpm at 50 Hz). They differ only in the stand: **LMB = stainless steel stand**,
**PMB = painted carbon steel stand**. SAP's remark says *"Stainless steel body container and
blade"* and *"Floor style"* but does not name the stand material.

Weight would settle it, except Skymsen's own figure for the LMB looks like a data-entry error:
LAR-15LMB 24.50 kg, LAR-15PMB 25.20 kg, LAR-25PMB 25.80 kg, but **LAR-25LMB 20.50 kg** - the
largest machine in the family lighter than the 19 L one. Staged imagery is LAR-25LMB (the
decal in `IMG-FPR-00038__LAR-25LMB-specsheet-render-2.png` is legible at 972x1458 and reads
`LAR-25LMB`), but the supplier should confirm which stand we actually sell.

Also worth knowing: the folder is titled *"19 / 25 LITERS"* - the LAR-15LMB is a **19 L**
nominal machine, not 15 L.

### 7.2 LAR-03MB is missing from its own spec sheet

Folder `710040_eng.pdf` is titled `LAR-02MB / LAR-03MB / LAR-04MB / LAR-06MB / LAR-08MB /
LAR-10MB` but the table has only five columns - 02, 04, 06, 08, 10. LAR-03MB has no column.
The web page for LAR-03MB quotes exactly the LAR-04MB figures (630 x 275 x 260, same package
size). Either the 3 L and 4 L genuinely share a body, or the 3 L page was cloned from the 4 L.
Its net weight does differ (9.70 vs 9.60 kg), which mildly favours "genuinely shares a body".
Unresolved.

### 7.3 W4 photo shows a shared casting

The only W4 photo available (Kitchenall, 1000x1000) shows a disc whose casting is embossed
**`W3 - W4`**. The blank is shared between the 3 mm and 4 mm scallop discs, so the photograph
cannot prove which size is fitted. Accepted with that caveat; there is no better source.
Same limitation on GC16: the grid photo cannot be measured.

### 7.4 IMG/FPR/00050 - masher or chipper? (the previous verdict is now reversed)

DAK makes both an *espremedor de pure* (masher/ricer) and a *cortador de legumes* (chipper),
and **both sit on the same black tripod stand**, which is why the name alone was thought
insufficient. New evidence:

- DAK's *Espremedor de Pure | Grande* is a tall tripod with a **perforated round stainless
  basket** and a lever - i.e. literally "Potato Smasher on Stand", which is our product name.
- DAK's *Cortador de Legumes | Medio / Grande* has a **square cutting grid** and interchangeable
  blades in 6, 8, 10 and 12 mm.

The old research argued for the chipper because the two blade SKUs are 10 mm. But those blades
are separate line items and can equally serve `IMG/FPR/00127` (Potato Chipper on Stand). Given
the product name says smasher and DAK sells exactly that machine on exactly that stand, the
**masher is now the better reading**. Both candidates are staged as `REF__` so the supplier can
point at one. Nothing attached.

### 7.5 MAXICONV SV or VP?

The oven exists as **MAXICONV SV** (no steam, `68528.3` at 220 V/50 Hz) and **MAXICONV VP**
(manual steam injection, `68529.1` at 220 V/50 Hz). They are visually identical apart from the
steam button. Our record is generic "MAXICONV". The reseller images staged are of the VP.
Trays are 4 x **35 x 35 cm** perforated aluminium - our copy does not state the tray size.

### 7.6 DISCOVERY 10 tray size

The spec sheet offers trays of **60x70 cm or 60x80 cm**. Depth changes with the choice
(1,590 mm published against 60x70). SAP's 1,490 mm may be the other variant, or may just be
wrong. At 20 kW, three-phase is mandatory; the 380 V / 50 Hz order code is **61090.9**.

---

## 8. Dead ends - do not retry these

- `skymsen.com/en/index.php/produtos/detalhe/496049` (CFI-300L-N) and
  `.../685291`, `.../674834`, `.../674826`, `.../674842`, `.../661805`, `.../661813` (MAXICONV)
  all 404 in EN, PT and ES. The **folder PDFs still work**: `496049_eng.pdf` and
  `685291_eng.pdf` (identical to `674834_eng.pdf` / `674842_eng.pdf` / `685283_eng.pdf`), plus
  the Portuguese `661805.pdf`. When a product page 404s, go straight to the folder path.
- The friendly-URL form `skymsen.com/index.php/produto/<slug>` exists but is sparse -
  `maxiconvvp` and `maxiconvsv` both 404. It did surface one page the numeric route missed:
  `produto/centrifuca-de-sucos-cse-skymsen-220v` (Brazilian CSE, code 58234.4) with a
  completely different image set (`CSE MI (n).png` vs the export `CSE ME (n).png`).
- Spare-parts-only article numbers have **no** detail page. `096164` (W4), `137197` (GC16),
  `393258` (GC16-S), `195634` (EH3), `631760`, `671673` all return nothing. Use the
  `componentes?modelo=` search instead, which lists them with descriptions.
- Folder PDFs do not exist for spare-parts codes either: `301850`, `281433`, `309230`,
  `687596`, `496057` all 404 in both `_eng` and bare form.
- `www.refrisol.com.br/api/catalog_system/pub/products/search/...` returns 401.
- `www.lojadeequipamentos.com.br` times out to automated fetching.
- `www.kitchenall.com` product pages fetch fine with a browser UA but their content is behind
  enough JS that a markdown-converting fetcher returns only the nav. Pull the raw HTML and
  grep for `media/catalog/product/...` instead.
- `robots.txt` disallows `/manuais/`, `/manuais_visualizacao/`, `/componentes/desenhos/`,
  `/componentes/desenhoprint/` and `/uploads/produtos/catalogo/`. Those paths were **not**
  fetched. The dimension drawings behind "See drawings" would be the best possible source for
  the width/depth question, but they are off limits to automation - a human in a browser can
  get them.

---

## 9. Coverage

All 28 SKUs have at least one image whose model was positively identified (decal, spindle
count, feature count, or extraction from that model's own spec sheet). 26 spec-sheet PDFs are
staged. Two SKUs have no spec sheet in existence: `IMS/MEC/00270` (GC16) and `IMS/MEC/00273`
(W4) are spare-parts-only codes that no longer appear in any current folder; the three DAK
rows have none because DAK publishes no datasheets at all.

| SKU | model shown | images | spec PDF | note |
|---|---|---|---|---|
| GROUP/BLENDER-KITCHEN-SS | LAR-03/04/08/10MB | 5 | yes | parent - one decal render per child plus the range sheet rasterised at 200 dpi |
| IMG/FPR/00033 | LAR-03MB | 4 | yes | 800x533 lifestyle + 600x600 decal render |
| IMG/FPR/00034 | LAR-04MB | 8 | yes | |
| IMG/FPR/00036 | LAR-08MB | 8 | yes | |
| IMG/FPR/00037 | LAR-10MB | 8 | yes | |
| IMG/FPR/00038 | LAR-25LMB | 6 | yes | decal legible at 972x1458 |
| IMG/FPR/00040 | CSE | 20 | 2 | both the export (`CSE ME`) and Brazilian (`CSE MI`) galleries; ceiling 600 px |
| IMG/FPR/00042 | PA7 PRO | 28 | yes | 1497x1497 sheet render + 800x800 web lead |
| IMG/FPR/00048 | DB-25HD | 4 | yes | |
| IMG/FPR/00050 | DAK (unresolved) | 8 | none | masher and chipper both staged as REF |
| IMG/FPR/00051 | SI-282HD / SFL-282HD | 13 | 2 | Skyfood SI-282HDE images + KaTom spec sheet; SFL files labelled "successor" |
| IMG/FPR/00169 | BM2 | 10 | yes | |
| IMG/FPR/00214 | ESB SUPER-N | 5 | yes | SUPER decal legible on two |
| IMG/FPR/00215 | CFI-300L-N | 2 | yes | 1269x1267 sheet render; no live page exists |
| IMG/FPR/00246 | DB-10 | 4 | yes | 1849x1849 sheet render |
| IMG/ICE/00019 | BMS-N | 4 | yes | |
| IMG/ICE/00020 | BMS-3-N | 17 | yes | full Brazilian gallery |
| IMG/OVE/00214 | DISCOVERY 10 | 14 | yes | 2000x2000 sheet render |
| IMG/OVE/00215 | MAXICONV | 11 | 2 | reseller gallery at 1200x1200 incl. the 35x35 trays |
| IMS/MEC/00270 | GC16 | 2 | none | Kitchenall 1000x1000 + GC14 PRO as REF |
| IMS/MEC/00271 | Z8 | 2 | yes | labelled "RALADOR Z8 (8mm)" |
| IMS/MEC/00272 | Z5 | 2 | yes | labelled "RALADOR Z5 (5mm)" |
| IMS/MEC/00273 | W4 | 2 | none | casting reads `W3 - W4`; W3 staged as REF |
| IMS/MEC/00274 | H3 | 2 | yes | labelled "JULIENNE H3 (3x3mm)" |
| IMS/MEC/00309 | DAK macho 10 mm | 4 | none | DAK labels each size - the 10 mm frame is exact |
| IMS/MEC/00312 | DAK navalha 10 mm | 1 | none | same labelled 10 mm frame |
| IMS/MEC/02131 | E3 | 2 | yes | labelled "FATIADOR E3 (3mm)" |
| IMS/MEC/02319 | E14 | 2 | yes | labelled "FATIADOR E14 (14mm)" |

The disc `-spec.pdf` files are all the same document: the PA7 PRO folder, whose page 2 is the
disc/grid range chart and whose page 3 is the slicer-vs-grid combination table (including the
rule *"do not use a slicer disc larger than a dicing grid"*).

The three quarantine folders hold 26 wrong-model or ambiguous files, 9 AI-generated scenes and
11 non-photographic references (dimension drawing, exploded view, disc chart, food shots).
They are staged rather than deleted so the mis-attributions stay on the record.

---

## 10. Range gaps

Models found while enumerating the site that are not in our catalogue, if the range is worth
filling: `LAR-02MB`, `LAR-06MB`, `LAR-15LMB` / `LAR-15PMB` (19 L), `LAR-25PMB`, `DB-06`,
`DA-06`, `DAL-06S`, `L2` / `L3` / `L4` / `L10` (a newer commercial blender line), `LI1.5` /
`LI2` (stainless-cup bar blenders - the BM2's metal-jug alternative), `BS2` (pre-programmed
2 L), `BMS-P` (wall-mounted milkshake mixer), `ESB-N` (0.25 HP citrus juicer), `EX` /
`EX SUPER`, `ES` / `ESL`, `PA-14-N`, `CR-4LR` / `CR-8LR` (vertical cutters), `SF-218` /
`SF-282` / `SF-295` and `SFL-282HD` / `SFL-295HD` / `SFL-315HD` (band saws), `FA-300L` and
`CLM-300L` / `CLM-400` (slicers), `PROLAV 505` (dishwasher), `MW1000` / `MW1800D`.
