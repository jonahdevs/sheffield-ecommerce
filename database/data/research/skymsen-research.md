# Skymsen - SAP-led research redo (July 2026)

Full re-do of the Skymsen pass. The earlier notes are archived at
The archived research below; several of their conclusions are
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

---

## Archived brand research

> Merged in from the former `research/old/` folder on 2026-08-12, when the two folders were
> consolidated. This is the earlier **specs and codes** pass; everything above it
> is the later **sourcing and provenance** pass. The text is unchanged apart from
> heading levels, which were demoted one step to keep a single outline.

## Skymsen Product Research

Research notes behind the Skymsen enrichment pass on `products.json` (July 2026). Data was
sourced from Skymsen's official export site and cross-checked against resellers.

Covers 20 machine SKUs. Seven further Skymsen entries are archived spare discs and blades
(`IMS/MEC/*`) which were left untouched - they are line items rather than catalogue products.

---

### 1. Brand structure

The same machines are sold under four names. Always match on **model code**, not brand name:

| Brand | Market | Site |
|---|---|---|
| **Siemsen** (Metalúrgica Siemsen Ltda, Brusque, Santa Catarina) | Brazil domestic | siemsen.com.br |
| **Skymsen** | Export / international | skymsen.com |
| **Skyfood** (sometimes Fleetwood) | USA | skyfood.us |
| **Skymsen Europa** | Europe, 230 V / 50 Hz | skymseneuropa.com |

US model codes differ: `DB-10` is sold as `EL-10`, `CSE` as `CSE1`, `BMS-N` as `BMS`.
Useful as extra photo sources, but **never quote their specs** - they are 110–120 V / 60 Hz.

---

### 2. Cross-cutting rules

#### Voltage and frequency (the big one)

Kenya is 240 V / 50 Hz. Skymsen sells a **separate SKU per voltage/frequency combination**,
and the specs genuinely differ between them:

- **LAR blender line**: 60 Hz units run **3,500 rpm**; 50 Hz units run **3,000 rpm**.
  Most reseller pages quote 3,500 rpm because they are US/Brazil listings.
- **ESB SUPER-N juicer**: 1,750 rpm at 60 Hz, **1,500 rpm at 50 Hz**.
- Motor power, dimensions and capacity are unchanged across variants; only speed and
  electrical supply move.

Publishing a 60 Hz rpm figure against a 50 Hz machine is a false spec. All entries in
`products.json` now carry 50 Hz figures.

#### Dimension ordering

Skymsen publishes dimensions as **H × W × L**, not W × D × H. Most existing catalogue
entries had the right numbers in the wrong fields. All Skymsen SKUs have been reordered to
the catalogue's `length` / `width` / `height` convention.

#### Not published - do not invent

- No **kg/h throughput** figure exists for the CSE juicer (only rpm).
- No **noise level** is published for any LAR blender or the BM2.
- No **IP rating** is published for any model.
- Cup capacities are quoted as a single maximum figure; there is no separate
  "useful vs total" volume.

---

### 3. Corrections applied

| SKU | Product | Was | Now |
|---|---|---|---|
| IMG/FPR/00048 | Potato Peeler 25KG | 110 V / 60 Hz with 45 kg net | 220 V / 50 Hz - 45 kg is the **220 V** figure; the 110 V unit is 48 kg. The record mixed two variants. |
| IMG/FPR/00033–38 | LAR blenders (5 SKUs) | 3,500 rpm | 3,000 rpm at 50 Hz |
| IMG/FPR/00169 | Blender Bar 2 Litres | implied stainless cup | Cup is **Tritan polymer**; only the base is metal |
| IMG/FPR/00214 | Juice Extractor ESB Super N | "entry-level", "affordable" | It is the **uprated 0.5 HP** model. `ESB-N` is the entry model (0.25 HP) |
| IMG/FPR/00042 | Vegetable Processor PA7 | 0.25 HP, 300–400 kg/h, 6 discs | 0.5 HP, ~250 kg/h, **7 discs** |
| All Skymsen | - | dimensions in wrong axes | reordered from H×W×L |
| IMG/FPR/00048, 00246, 00050, 00105 | peelers + chipper | short description read *"SYSTEMATIC JSPCC-08 commercial potato chipper"* | Rewritten - copy-paste bug from an unrelated product |

---

### 4. Open questions for the supplier

These were **not** changed in `products.json`, because they need confirmation against
purchase paperwork.

#### 4.1 DAK is a different manufacturer

`IMG/FPR/00050` (Potato Smasher on Stand) and the two chipper blades `IMS/MEC/00309` /
`IMS/MEC/00312` are filed under brand **SKYMSEN**, but **DAK is Metalúrgica DAK of Canoas,
Rio Grande do Sul** - an unrelated Brazilian manufacturer. Searching skymsen.com,
skyfood.us and skymseneuropa.com returns zero results for a model "DAK".

There is no manufacturer spec sheet, manual, EAN or HS data for DAK in English; all
sources are Brazilian retail listings.

Two further points on this SKU:

- The name says **"Potato Smasher"** but the 10 mm blades describe a **chipper**. DAK makes
  both a masher (*amassador*) and a chip cutter (*cortador de legumes*) - unrelated products
  sharing a brand. The description now written assumes the chipper.
- Sizing is inconsistent across resellers ("médio", "grande", "tripé industrial"). Ref. 109
  measures 121 × 53 × 48 cm at 4.6 kg. Confirm which size before publishing dimensions.

#### 4.2 Model numbers carry a suffix that does not exist on export units

| In catalogue | Actual export code |
|---|---|
| LAR-03MB-N | LAR-03MB |
| LAR-04MB-N | LAR-04MB |
| LAR-08MB-N | LAR-08MB |
| LAR-10MB-N | LAR-10MB |
| LAR 25MB | **does not exist** - see below |

The `-N` suffix belongs to Skymsen's *Brazilian domestic* lines (`LS-xxMB-N`, `TA-xxMB-N`),
which are **different machines** - `LS` is explicitly a low-rotation blender for pastier
products. If supplier paperwork genuinely says `LS-04MB-N`, the specs written do not apply.

#### 4.3 The 25 litre blender needs a model decision

There is no `LAR-25MB`. The 25 L machines are:

- **LAR-25LMB** - tilting, **with** stainless steel floor stand
- **LAR-25PMB** - tilting, seamless cup, **without** stand
- **LAR-25LMB-HD** - heavy-duty stand version

`products.json` was written for **LAR-25LMB** as the most likely match. Net weight is
inconsistent on Skymsen's own site (20.5 kg on the 50 Hz SKU vs 25.5 kg on the 60 Hz SKU for
identical dimensions) - the 20.5 kg looks like a data-entry error, so ~25.5 kg is published.

#### 4.4 PA-7 vs PA-7 PRO

Current production is **PA-7 PRO**, which superseded the PA-7. The PRO adds cube-cutting
disc combinations, a teflonised disc finish and a redesigned feed assembly. Net weight
differs (27.8 kg PRO vs ~25.7 kg legacy). Catalogued as PA-7; switch if the supplier ships
the PRO.

#### 4.5 MAXICONV is two SKUs

- **MAXICONV SV** - *sem vapor*, no steam
- **MAXICONV VP** - manual steam injection via a panel button

The catalogue entry is generic "MAXICONV". The VP is the more widely listed of the two.
Note max temperature is **210 °C** - do not copy generic "up to 300 °C" convection claims.

#### 4.6 Discovery 10 tray size changes the dimensions

The 60 × 80 cm tray option changes depth (1,590 → 1,490 mm) and weight (326 → 250 kg).
Published figures assume 60 × 70 cm trays. At 20 kW, three-phase is mandatory.

---

### 5. Product reference

Official page and spec sheet per catalogue SKU. **The `folders/*.pdf` spec sheets are the
best image source** - print-quality Adobe Illustrator files with clean white-background
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
| IMG/FPR/00215 | Meat Slicer 300 | CFI-300L-N | ⚠ 404 - see §6 | [496049_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/496049_eng.pdf) |
| IMG/FPR/00051 | Bone Saw Free Standing | SI-282HD | [624063](https://www.skymsen.com/en/index.php/produtos/detalhe/624063) | [624063_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/624063_eng.pdf) |
| IMG/OVE/00215 | Oven Convection 4 Tray Maxiconv | MAXICONV | ⚠ 404 - see §6 | [661805.pdf](https://www.skymsen.com/uploads/produtos/folders/661805.pdf) |
| IMG/OVE/00214 | Oven Convection 10 Trays Discovery 10 | DISCOVERY 10 | [609781](https://www.skymsen.com/en/index.php/produtos/detalhe/609781) | [609781_eng.pdf](https://www.skymsen.com/uploads/produtos/folders/609781_eng.pdf) |
| IMG/FPR/00050 | Potato Smasher on Stand | DAK | none - not a Skymsen product | none |

The numbers in those URLs are Skymsen's internal product codes for a **specific voltage
variant**. Where a choice existed, the 220 V / 50 Hz page is linked.

#### Order codes for Kenya (220 V / 50 Hz)

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

### 6. Image sourcing

#### Site reliability

skymsen.com is **unreliable to automated access** - pages 404 or hang intermittently,
including URLs that worked earlier in the same session. A browser is more likely to succeed.
The `uploads/produtos/folders/*.pdf` paths are consistently reliable; if a product page will
not open, go straight to the PDF.

Confirmed dead at time of writing (both 404, in EN and ES):

- CFI-300L-N: `/en/index.php/produtos/detalhe/496049`
- MAXICONV: `/en/index.php/produtos/detalhe/685291` and `/es/.../674834`

**Verified working reseller fallbacks for those two:**

- Slicer → [evandroshop.com.br](https://www.evandroshop.com.br/portateis-industriais/fatiador-de-frios/fatiador-de-frios-300mm-400w-semi-automatico-inox-cfi-300l-n-220v-skymsen) - two studio shots, white background
- Maxiconv → [igorsolucoes.com](https://www.igorsolucoes.com/forno-eletrico-turbo-maxiconv-sem-vapor-skymsen) - four angles including a **background-removed cutout**, open-door and tray detail

#### Best sources, ranked

1. **Official spec-sheet PDFs** (`folders/*.pdf`) - print-quality renders on white/light grey.
   Image-based, so text will not extract, but the artwork lifts cleanly.
2. **Official product detail pages** - 710024 and 472727 carry 7+ clean white-background
   images each; 704270 (PA-7) has 20+; 609781 (Discovery 10) has 16.
3. **US Skyfood resellers** - katom.com, kitchenall.com. Same machines, good photography,
   but **check for visible Skyfood branding** in frame before use.

#### Extras

- Full English export catalogue (5.8 MB, all products):
  <https://www.skymsen.com/uploads/produtos/catalogo/catalogo-arquivo_en.pdf>
- Discovery 10 interactive 3D model - screenshot from any angle:
  <https://app.vectary.com/p/3hwWNee1LluLzDhGjCXKOK>
- LAR family manual (covers 2–10 L): <https://www.skymsen.com/manuais/414484.pdf>
- CMP-range slicer manual: <https://www.skymsen.com/manuais_visualizacao/574074.pdf>
- BMS-3-N product video: <https://www.youtube.com/watch?v=y8pKtbLrd_c>

#### Known blocks

403 to automated fetching but fine in a browser: `loja.skymsen.com`, `katom.com`,
`kitchenall.com`, `magazineluiza.com.br`, `restaurantsupply.com`.
`skymseneuropa.com` returned empty responses on every attempt.

---

### 7. Accessory disc images - PA-7 cutting discs (July 2026)

The 7 archived `IMS/MEC/*` discs/blades noted in §"Covers" above as line items were
subsequently researched for images. **They are not on the current PA-7 PRO product page**
(704270) - that page lists a different/updated accessory set (KC5V, GC10 PRO, W3, KC8),
so these 7 codes likely belong to an older PA-7 generation or a standalone accessory
catalogue. The authoritative source turned out to be **skyfood.us** (Skymsen's US export
brand, same manufacturer photography) - `skyfood.us/products.php?familia=5` lists all
seven.

**Correction:** H3/EH3 is a **julienne** disc (3×3 mm strips), not a grater as the code
naming suggests.

| SKU | Catalogue name | Code | Identification | Product page(s) | Image URL |
|---|---|---|---|---|---|
| IMS/MEC/00270 | Disc Cube | GC16 | Dicing disc, 16 mm cube grid | [Restaurant Stock](https://restaurantstock.com/products/skyfood-gc16-5-8-16-mm-dicing), [Kitchenall](https://www.kitchenall.com/skyfood-gc16-dicing-disc-5-8-16-mm.html), [JES](https://www.jesrestaurantequipment.com/Skyfood-GC16--Dicing-Disc-1116in-for-Skymsen-MASTER-models_p_53075.html) | <https://restaurantstock.com/cdn/shop/products/0_252F4_252F7_252F2_252F04726f437e0c20a7bbe098319208d30160f62ccc_GC16_1024x.jpg> |
| IMS/MEC/00271 | Disc Z8 | Z8 | Grater/shredding disc, 8 mm | [skyfood.us](https://www.skyfood.us/products.php?familia=5), [Kitchenall](https://www.kitchenall.com/skyfood-z8-shredding-disc-5-16-8-mm.html) | <https://www.skyfood.us/photos/PC0720.JPG> |
| IMS/MEC/00272 | Disc Z5 | Z5 | Grater/shredding disc, 5 mm | [skyfood.us](https://www.skyfood.us/products.php?familia=5), [Kitchenall](https://www.kitchenall.com/skyfood-z5-shredding-disc-3-16-5-mm.html) | <https://www.skyfood.us/photos/PC0721.JPG> |
| IMS/MEC/00273 | Disc W4 | W4 | Wave/scallop-cut slicing disc, 4 mm | [Restaurant Stock](https://restaurantstock.com/products/skyfood-w4-5-32-4-mm-scallop-cut), [Kitchenall](https://www.kitchenall.com/skyfood-w4-scallop-cut-5-32-4-mm.html), [Culinary Depot](https://www.culinarydepotinc.com/skyfood-w4-0-16-scallop-cut-for-use-with-master-sky/) | <https://restaurantstock.com/cdn/shop/products/6_252Ff_252F8_252Fd_252F6f8d4511a85fbca2218ef8b989527e08df301938_W4_616d89a3-782a-4a63-a6a0-25fc2858e08f_1024x.jpg> |
| IMS/MEC/00274 | Disc H3 | H3/EH3 | **Julienne** disc, 3×3 mm (not a grater) | [skyfood.us](https://www.skyfood.us/products.php?familia=5), [KaTom](https://www.katom.com/248-H3.html) | <https://www.skyfood.us/photos/PC0725.JPG> |
| IMS/MEC/02131 | Disc -E3 | E3 | Slicing disc, 3 mm | [skyfood.us](https://www.skyfood.us/products.php?familia=5), [KaTom](https://www.katom.com/248-E3.html), [JES](https://www.jesrestaurantequipment.com/skyfood-e3.html) | <https://www.skyfood.us/photos/PC0730.JPG> |
| IMS/MEC/02319 | Slicer Disc - 14MM | 14MM (mfr code **E14**) | Slicer disc, 14 mm | [skyfood.us](https://www.skyfood.us/products.php?familia=5), [GoFoodservice](https://www.gofoodservice.com/p/skyfood-e14) | <https://www.skyfood.us/photos/PC0709.JPG> |

Notes: the `skyfood.us/photos/PC0xxx.JPG` files are manufacturer studio photos, white
background, verified live. GC16 and W4 aren't hosted on skyfood.us directly - their
images come from Restaurant Stock's Shopify CDN (`_1024x.jpg` variants available),
same product, but check for reseller branding/watermarks before use. Several reseller
product-detail pages (katom.com, jesrestaurantequipment.com, gofoodservice.com individual
listings) 403 to automated fetching - fine in a browser if higher-res or alternate angles
are needed.

#### 7.1 Full descriptions and technical specs (July 2026)

Following the image pass, all 7 discs were researched to the same depth as the machine
records - description, meta_description and technical_specification - and written into
`products.json`, matching the catalogue's established content pattern (prose + `Key
Features` list + HTML spec table).

Confirmed/sourced per disc:

| SKU | Code | Cut type & size | Disc diameter | Weight | Compatible machines (as sourced) |
|---|---|---|---|---|---|
| IMS/MEC/00270 | GC16 | Cube dicing grid, 16×16 mm | - | ~0.51 kg | **Unresolved - see caveat below** |
| IMS/MEC/00271 | Z8 | Grating, 8 mm | ~204 mm | 0.70 kg net / 0.80 kg gross | Skymsen PA-7 / PA7 PRO |
| IMS/MEC/00272 | Z5 | Grating, 5 mm | ~205 mm | 0.68 kg net / 0.75 kg gross | Skymsen PA-7 / PA7 PRO |
| IMS/MEC/00273 | W4 | Scallop (wave) slicing, 4 mm | ~205 mm | 0.86 kg net / 0.93 kg gross | PA-7, PA-7SE-N, PA-7LE-N, PAIE-N, PAIE-S-N |
| IMS/MEC/00274 | H3/EH3 | Julienne, 3×3 mm | 203 mm | 0.85 kg net / 0.95 kg gross | Skymsen PA-7 / PA7 PRO |
| IMS/MEC/02131 | E3 | Slicing, 3 mm, non-stick coated | ~204 mm | 0.80 kg net / 0.90 kg gross | Skymsen PA-7 / PA7 PRO |
| IMS/MEC/02319 | 14MM (mfr code **E14**) | Slicing, 14 mm; pairs with a 14×14mm cube grid | ~203–205 mm | ~0.89–0.90 kg (sources disagree slightly) | PA-7, PA-7 PRO, PAIE-N, PAIE-S-N |

Sources for the spec pass, beyond the image sources above: `skymsen.com` official part
pages (094340 for H3 - directly fetched, confirms "DIÂMETRO 203mm" and "Corte Julienne de
3mm"; 096130 for Z8; others via search-engine cache when direct fetch was blocked -
096121 Z5, 096091 W4, `loja.skymsen.com/produto/096059` E3, `loja.skymsen.com/produto/676470`
E14), `maquinbal.com.br` (E14 material + compatibility).

**Open flag - GC16 (IMS/MEC/00270):** every independent English-language source found
(Kitchenall, JES Restaurant Equipment, RestaurantStock) ties the code "GC16" to the
Skymsen/Skyfood **MASTER series**, not the PA-7 - no source names GC16 and PA-7 together.
The nearest official match on skymsen.com is "GC16-S," tied to the **PAIE-S-N** machine,
and even that listing disagrees with a reseller on cube size (16 mm vs 12×12 mm). The
description written avoids naming a specific machine to not overstate confidence. **This
SKU may be miscoded in the catalogue** - worth a second look, since the PA-7's own record
lists IMS/MEC/00270 in its `accessories` array.

**Open flag - PA-7's own copy vs. its actual disc set:** the PA-7 record's existing
description/technical_specification (written earlier, unrelated to this pass) says the
included set is "slicers 1 and 3 mm, graters 3, 5 and 8 mm, fine grater, 7×7 mm julienne."
The 7 SKUs actually linked in its `accessories` array are GC16 (16 mm cube), Z8 (8 mm
grate), Z5 (5 mm grate), W4 (4 mm scallop-slice), H3 (3×3 mm julienne), E3 (3 mm slice),
and 14MM/E14 (14 mm slice) - a different set (no 1 mm slicer, no 7×7 julienne, has a cube
grid and a 4 mm scallop disc instead). Not corrected here since it touches the PA-7's own
record, not just the discs - flagging for a decision on which description is accurate.

---

### 8. Range gaps

Models found during research that are not currently in the catalogue, if the range is
worth filling:

- **DB-06** - 6 kg potato peeler, below the DB-10
- **LAR-06MB** - 6 L blender, between the 4 L and 8 L
- **LAR-15LMB / LAR-15PMB** - 15 L tilting blenders, below the 25 L
- **LI2** - 2 L bar blender with a genuine **stainless steel** cup (the BM2 alternative)
- **BMS-P** - wall-mounted single-spindle milkshake mixer
- **ESB-N** - 0.25 HP entry-level citrus juicer, below the ESB SUPER-N
- **LAR-xx-HD** - heavy-duty variants across the blender line, for thick/pasty products

---

### Image sourcing completion (July 2026)

Second pass. Goal was to close the remaining image gaps and replace the sub-standard
600x600 web renders with print-quality art extracted from Skymsen's own folder PDFs.

**Method that produced almost everything below:** Skymsen's `uploads/produtos/folders/*.pdf`
files are print-ready Illustrator documents. The studio renders are embedded as full-resolution
objects, so PyMuPDF embedded-object extraction (`page.get_images()` + `doc.extract_image()`)
recovers them at native size - between 2x and 3x the resolution of the same render served on
the website. Every render carrying transparency had to be recomposited against its soft mask
(the `smask` xref) before saving; extracting without the mask produces black speckle.

Resolution floor is 800 px on the long edge. Files below it are suffixed `-TOOSMALL` and kept
only where the ceiling is proven; those cases are stated explicitly.

#### Sources used

- https://www.skymsen.com/uploads/produtos/folders/585033.pdf
- https://www.skymsen.com/uploads/produtos/folders/661805.pdf
- https://www.skymsen.com/index.php/produtos/detalhe/585033
- https://www.kitchenall.com/media/sitemap/sitemap_products_product.xml
- https://www.kitchenall.com/skyfood-e14-14mm-slicing-disc-for-use-with-master-sky-pa-7-pa-7-pro-models.html
- https://www.kitchenall.com/media/catalog/product/s/k/skyfood-e14_xlarge_n6lhknf7ftbkfrbs.jpg
- https://www.evandroshop.com.br/portateis-industriais/fatiador-de-frios/fatiador-de-frios-300mm-400w-semi-automatico-inox-cfi-300l-n-220v-skymsen
- https://www.refrisol.com.br/centrifuga-de-sucos-cse-220v-skymsen/p
- http://www.dak.com.br/index.php/produtos/1/cortadores-de-legumes
- http://www.dak.com.br/index.php/produtos/9/navalhas-e-machos
- http://www.dak.com.br/index.php/produtos/8/espremedores-de-pure
- http://www.dak.com.br/index.php/detalhe-produto/5/cortador-de-legumes-grande

#### What PDF extraction gained over the web renders

| SKU | Model | Web render was | PDF render is | Gain |
|---|---|---|---|---|
| IMG/FPR/00246 | DB-10 | *(none - only an AI scene)* | 1849x1849 | new |
| IMG/FPR/00051 | SFL-282HD | 600x600 | 1659x1659 | 2.8x |
| IMG/FPR/00042 | PA7 PRO | 600x600 | 1497x1497 | 2.5x |
| IMG/FPR/00215 | CFI-300L-N | *(page 404)* | 1269x1267 | new |
| IMG/OVE/00214 | DISCOVERY 10 | 600x600 | 1205x1636 | 2.7x |
| IMG/OVE/00215 | MAXICONV | *(page 404)* | 1174x1174 | new |
| IMG/ICE/00020 | BMS-3-N | *(page 404)* | 1048x1069 | new |
| IMG/FPR/00038 | LAR-25LMB | *(nothing usable)* | 972x1458 | new |
| IMG/FPR/00169 | BM2 | *(page 404)* | 524x1270 | new |
| IMG/ICE/00019 | BMS-N | *(zero candidates)* | 485x894 | new |
| IMG/FPR/00048 | DB-25HD | *(only an AI scene)* | 517x815 | new |
| IMG/FPR/00214 | ESB SUPER-N | *(only an AI scene)* | 667x909 | new |

#### Per-file record

All PDF-render files below were extracted from the manufacturer folder PDF already staged
alongside them as `<SKU>__spec-sheet.pdf`; the two new spec sheets are cited individually.

**IMG/FPR/00042 - PA7 PRO (catalogue model_number `PA-7`)**
- `IMG-FPR-00042__PA7-PRO__pdf-render-front-right.png` - 1497x1497, 628 KB - from
  `IMG-FPR-00042__spec-sheet.pdf`. Confirmed: front-right studio render on white, Skymsen
  branding on both the body and the discharge chute, rocker + reset switches, cast feet.
  **This is the PA7 PRO, not the legacy PA-7** - the PDF's own model column reads `PA7 PRO`
  and its disc pages are headed "available for the PA7 PRO".
- `IMG-FPR-00042__PA7-PRO__left-three-quarter-web-TOOSMALL.png` - 600x600, 144 KB - from
  https://www.skymsen.com . Left three-quarter view. Ceiling for skymsen.com web renders is
  600x600; the PDF supplies only the front-right angle, so this is kept for the second angle.
- `IMG-FPR-00042__PA7-PRO__feed-hopper-assembly-web-TOOSMALL.png` - 600x600, 142 KB - feed
  hopper and lid assembly, detached. Component view, no PDF equivalent.
- `IMG-FPR-00042__PA7-PRO__round-hopper-lid-web-TOOSMALL.png` - 600x600, 204 KB - round
  hopper/lid fitted to the machine.

**IMG/FPR/00051 - SFL-282HD (catalogue model_number `SI-282HD`)**
- `IMG-FPR-00051__SFL-282HD__pdf-render-front-right.png` - 1659x1659, 408 KB. Confirmed:
  full band saw on splayed stainless legs, control box with e-stop top left, blade visible,
  movable table with fence, Skymsen logo on the upper wheel housing.
- Nine 600x600 web renders retained with `-TOOSMALL` (front, front-right, left and right
  three-quarter, and five detail crops: table + fence, height-adjust knob, table lock,
  pusher open x2, blade). All from https://www.skymsen.com , ceiling 600x600. Retained
  because the PDF supplies only one angle and no detail crops.
- **Naming note:** Skymsen calls this machine **SFL-282HD** throughout its own spec sheet
  (`SFL-282HD / SFL-295HD / SFL-315HD`) and its web render filenames. Our stored
  model_number is `SI-282HD`. Not changed - flagging for a decision.

**IMG/FPR/00246 - DB-10**
- `IMG-FPR-00246__DB-10__pdf-render-front.png` - 1849x1849, 334 KB. Confirmed: stainless
  drum peeler, hinged top band, discharge chute right, numbered 0-7 timer dial, two cast
  feet. Matches the PDF's own "POTATO PEELER, WITH DOOR AND TIMER, STAINLESS STEEL, 10 kg".
- `IMG-FPR-00246__DB-10__pdf-render-door-open-with-chute.png` - 879x879, 183 KB. Second
  angle, door open, chute extended.

**IMG/FPR/00048 - DB-25HD**
- `IMG-FPR-00048__DB-25HD__pdf-render-front-right-with-abrasive-disc.png` - 517x815, 193 KB.
  Long edge 815 px, above the floor. Confirmed: taller three-leg drum, black lid, hinged
  door with warning plate and tap, abrasive disc leaning against the base.
- `IMG-FPR-00048__DB-25HD__detail-abrasive-disc__pdf-render-TOOSMALL.png` - 610x343, 151 KB.
  The carborundum abrasive disc alone. Component detail; nothing larger exists in the PDF.

**IMG/FPR/00038 - LAR-25LMB (catalogue model_number `LAR 25MB`)**
- `IMG-FPR-00038__LAR-25LMB__pdf-render-front-decal-legible.png` - 972x1458, 453 KB.
  **Decisive on the model question.** The decal on the cup is legible at this resolution and
  reads `SEAMLESS CUP / VASO MONOBLOQUE / NO WELDING / SIN SOLDADURAS / LAR-25LMB / PATENTED`.
  So LAR-25LMB is the machine with the tilting seamless cup **and** the stainless floor stand
  - it has both, not one or the other.
- `IMG-FPR-00038__REF__LAR-15LMB-NOT-LAR-25LMB__pdf-render.png` - 746x1119, 227 KB. Same
  render family, decal reads `LAR-15LMB`. Kept as documented near-miss, not for use.
- **Confirms the standing caveat: there is no `LAR-25MB`.** Our stored model_number
  `LAR 25MB` does not exist in Skymsen's range. Not changed here.

**IMG/FPR/00169 - BM2**
- `IMG-FPR-00169__BM2__pdf-render-maxi-blender-front.png` - 524x1270, 413 KB. Long edge
  1270 px. Confirmed: black base badged `MAXI BLENDER` with a `3 HP MOTOR` roundel, Tritan
  jug marked to 2 L, BPA FREE plate, rotary speed dial + two rockers. The PDF's own text
  block ties `BM2` to "LIQUIDIFICADOR MAXI BLENDER, COPO TRITAN".
- `IMG-FPR-00169__REF__BS2-supreme-blender-NOT-BM2__pdf-render.png` - 576x1397, 468 KB.
  Red base badged `SUPREME BLENDER` with pre-programmed LOW/MED/HIGH and 35"/60"/90" pads -
  that is the **BS2**, the sibling on the same sheet. Kept as a documented near-miss.

**IMG/FPR/00214 - ESB SUPER-N**
- `IMG-FPR-00214__ESB-SUPER-N__pdf-render-with-cones-decal-legible.png` - 667x909, 416 KB.
  Long edge 909 px. Confirmed: stainless body, twin black clamp bands, black spout, black
  base, supplied with strainer cup and two reaming cones. Decal reads `SUPER 0,5 CV HP`.
- `IMG-FPR-00214__REF__ESB-N-NOT-SUPER__pdf-render.png` - 667x909, 394 KB. Identical body
  **without** the SUPER decal - the 0.25 HP `ESB-N`. Documented near-miss.

**IMG/FPR/00215 - CFI-300L-N**
- `IMG-FPR-00215__CFI-300L-N__pdf-render-front-right.png` - 1269x1267, 493 KB. Confirmed:
  300 mm blade, metal blade cover, thickness dial, manual carriage with foam handle, rocker
  switch, Skymsen on the plinth twice.
- `IMG-FPR-00215__CFI-300L-N__evandroshop-alt-build-with-estop.jpg` - 1200x1200, 77 KB -
  https://www.evandroshop.com.br/portateis-industriais/fatiador-de-frios/fatiador-de-frios-300mm-400w-semi-automatico-inox-cfi-300l-n-220v-skymsen
  **Different build of the same model.** This photo has a red mushroom e-stop, red/green
  pushbuttons and a transparent plastic blade guard, where the PDF render has a plain rocker
  and a metal guard. Verified as the same model anyway: the companion dimension drawing on
  that listing reads 44 cm / 56 cm / 57 cm, which is an exact match for the spec sheet's
  `440 x 560 x 570 mm`. Treat as an alternate/older production build, not a different machine.

**IMG/ICE/00019 - BMS-N**
- `IMG-ICE-00019__BMS-N__pdf-render-front.png` - 485x894, 208 KB. Long edge 894 px.
  Confirmed: single spindle, spherical grey motor housing with black equator band, stainless
  cup in a wire yoke, tapered column on a textured splash base. Countertop, not wall.
- `IMG-ICE-00019__BMS-N__pdf-render-side.png` - 485x894, 194 KB. Side elevation of the same.
- `IMG-ICE-00019__REF__BMS-P-WALL-MOUNTED-NOT-BMS-N__pdf-render.png` - 730x1117, 143 KB.
  Same head on a **wall bracket** - that is the `BMS-P`. Documented near-miss.

**IMG/ICE/00020 - BMS-3-N**
- `IMG-ICE-00020__BMS-3-N__pdf-render-front-three-spindle.png` - 1048x1069, 398 KB.
  Confirmed: three spherical heads, three stainless cups, clover-shaped splash base. The
  three-spindle count is what distinguishes BMS-3-N from BMS-N.

**IMG/OVE/00215 - MAXICONV**
- `IMG-OVE-00215__spec-sheet.pdf` - 1707 KB -
  https://www.skymsen.com/uploads/produtos/folders/661805.pdf (covers `MAXICONV SV` and
  `MAXICONV VP`). Newly located; the official product page still 404s.
- `IMG-OVE-00215__MAXICONV__pdf-render-door-open.png` - 1174x1174, 383 KB. Confirmed:
  4-rack compact convection oven, glass door open, control column badged `MAXI CONV` with
  Skymsen logo, temperature 180 and timer 20 on the displays.
- `IMG-OVE-00215__MAXICONV__pdf-render-door-open-and-removable-rack.png` - 1096x531, 211 KB.
  Oven plus the removable rack shown separately.
- **The igorsolucoes images were rejected.** Its 1000x1000 files are OpenCart upscales, not
  masters: the source at
  https://www.igorsolucoes.com/image/Produtos/Forno%20Turbo/forno%20maxiconv.JPG is only
  433x357, and the Laplacian variance of the 1000x1000 cache is 164 against 926 for the
  433 px master - the signature of interpolation. Ceiling for that site is 433 px, so it is
  beaten outright by the 1174 px PDF render.
- **SV vs VP:** the spec sheet covers both; they are visually identical and differ only by
  the steam function. The reseller listing our catalogue was built from is the *sem vapor*
  version, i.e. **MAXICONV SV**. Worth confirming with the supplier which we sell.

**IMG/OVE/00214 - DISCOVERY 10** (not previously in the gap list, was uncovered)
- `IMG-OVE-00214__spec-sheet.pdf` - 1605 KB -
  https://www.skymsen.com/uploads/produtos/folders/585033.pdf
- `IMG-OVE-00214__DISCOVERY-10__pdf-render-loaded-badge-legible.png` - 1205x1636, 591 KB.
  Confirmed: full-height 10-tray bakery convection oven on castors, control column badged
  `DISCOVERY 10`, glass door showing ten loaded trays.
- **Housekeeping:** the sibling staging folder `skymsen-discovery-images\` (left untouched,
  as instructed) already holds `IMG-OVE-00214__discovery-10-front.png` and
  `-angle.png` at 600x600 plus the same two spec sheets. The 1205x1636 render staged here
  supersedes both at 2.7x. Worth consolidating the two folders when the images are placed.

**IMG/FPR/00040 - CSE**
- `IMG-FPR-00040__CSE__refrisol-front-with-juice-cup-and-pulp-bin.png` - 1000x1000, 714 KB -
  https://www.refrisol.com.br/centrifuga-de-sucos-cse-220v-skymsen/p . Confirmed: white
  cast-aluminium centrifugal extractor, feed tube, curved pulp chute, stainless drum with
  Skymsen decal, red/green buttons, supplied with juice cup and stainless pulp bin. Clean
  white background, no watermark on this frame. Cross-checked against the manufacturer PDF
  render - identical geometry.
- `IMG-FPR-00040__CSE__refrisol-close-up-WATERMARKED.png` - 1000x1000, 904 KB. Same product
  closer. **Carries a faint REFRISOL watermark and a Portuguese caption strip.**
- `IMG-FPR-00040__CSE__pdf-render-front-TOOSMALL.png` - 352x493, 68 KB. Manufacturer render,
  well below the floor; kept only as the branding-neutral cross-check that validated the
  reseller photo. The CSE folder PDF contains nothing larger.

**IMS/MEC/02319 - E14 (catalogue model_number `14MM`)**
- `IMS-MEC-02319__E14-slicing-disc-kitchenall.jpg` - 1000x1000, 152 KB -
  https://www.kitchenall.com/media/catalog/product/s/k/skyfood-e14_xlarge_n6lhknf7ftbkfrbs.jpg
  Confirmed: identical framing to the 350x350 skyfood.us thumbnail it replaces - same blade
  angle, same two screw positions, same hub. Superseded file deleted.
- **The earlier "E14 is absent from kitchenall" conclusion was wrong,** and the reason is
  worth recording: kitchenall runs **two parallel url-key families** for these discs. The
  bare-code family (`skyfood-e10-slicing-disc-3-8-10-mm`) really does stop at E10, but a
  second descriptive family carries the rest -
  `skyfood-e14-14mm-slicing-disc-for-use-with-master-sky-pa-7-pa-7-pro-models`. Guessing
  url-keys will never find these; enumerate
  https://www.kitchenall.com/media/sitemap/sitemap_products_product.xml instead (declared in
  robots.txt, ~6 MB). Note also that the Magento image filename does **not** match the
  url-key for this family - it is `skyfood-e14_xlarge_<hash>.jpg`, so the product page has to
  be read to recover it.
- E14 is confirmed current: page 2 of the PA7 PRO folder lists `E14 - 14 mm` in the slicer
  range and pairs it with the GC14 PRO and GC20 PRO dicing grids.

**GROUP/BLENDER-KITCHEN-SS - LAR-03MB**
- `GROUP-BLENDER-KITCHEN-SS__LAR-03MB__front-web-TOOSMALL.png` - 600x600, 120 KB -
  https://www.skymsen.com . Genuine LAR-03MB, decal legible enough to read `LAR-03MB`.
- `GROUP-BLENDER-KITCHEN-SS__LAR-03MB__pdf-render-decal-legible-TOOSMALL.png` - 281x691,
  92 KB. Decal reads `SEAMLESS CUP / VASO MONOBLOQUE / LAR-03MB / PATENTED` crisply. The
  group sheet renders all six machines (LAR-02/03/04/06/08/10MB) side by side, so each is
  small; 281 px is the ceiling inside that PDF.
- `GROUP-BLENDER-KITCHEN-SS__REF__LAR-10MB-NOT-LAR-03MB__pdf-render-TOOSMALL.png` -
  368x794. The largest render on the sheet, decal reads `LAR-10MB`. Documented near-miss.
- **Five staged files were the wrong product.** `0002`, `0007`, `0008`, `0010` and `0011`
  (600x600, from skymsen.com) are not blenders at all - they show a cylindrical drum machine
  with a black clamp band and a black side spout, i.e. the ESB juicer body, photographed from
  five angles. Renamed `REF__NOT-LAR-03MB-drum-machine-*` rather than deleted so the
  mis-attachment stays on the record.
- **Ceiling for LAR-03MB is 600 px and I could not beat it.** The best reseller candidate,
  https://www.narcel.com.br/liquidificador-comercial-skymsen-03l-ls03mb-n-inox/p , serves a
  2000x2000 VTEX file that is an upscale of a 223x413 master, and its decal reads `LS3`
  anyway - the Brazilian domestic `LS-03MB-N`, which per the standing `-N` caveat is a
  different machine from the export LAR-03MB. Rejected on both counts.

**IMG/FPR/00050, IMS/MEC/00309, IMS/MEC/00312 - the DAK trio**

DAK is Metalurgica DAK of Canoas, Rio Grande do Sul, unrelated to Skymsen. Its own site is
http://www.dak.com.br (plain HTTP only - the certificate on the HTTPS port belongs to the
hosting provider, so HTTPS fails). Full-resolution images come from its resize endpoint,
which caps rather than upscales: `_files/view.php/resize/2000x2000/produto/<hash>.png`.

- `IMG-FPR-00050__REF__DAK-cortador-de-legumes-grande-chipper-on-tripod.png` - 928x2000,
  889 KB - http://www.dak.com.br/index.php/detalhe-produto/5/cortador-de-legumes-grande
  Confirmed: lever-operated chipper on a black hammertone tripod, white nylon pusher block
  above a square steel cutting grid.
- `IMG-FPR-00050__REF__DAK-cortador-de-legumes-grande-with-output.png` - 827x1417, 625 KB.
  Same machine with dishes of cut output.
- `IMG-FPR-00050__REF__DAK-espremedor-de-pure-grande-masher-on-tripod.png` - 866x2000,
  725 KB - http://www.dak.com.br/index.php/produtos/8/espremedores-de-pure
  The competing candidate: same tripod and lever, but a **perforated round stainless basket**
  instead of a cutting grid - a masher/ricer, not a chipper.
- `IMS-MEC-00309__REF__DAK-macho-male-block-left-and-navalha-right.png` and
  `IMS-MEC-00312__REF__DAK-navalha-female-grid-right-and-macho-left.png` - both 1299x827,
  861 KB - http://www.dak.com.br/index.php/produtos/9/navalhas-e-machos
  One image showing both parts: on the left the white nylon **macho** (male pusher block with
  raised squares), on the right the steel **navalha** (female knife grid in a cast frame).
  Staged under both SKUs because a single frame documents both. DAK sells this set for the
  Medio/Grande/Parede cutters.

**The masher-vs-chipper question is now sharper, and still open.** DAK genuinely makes both
an *espremedor de pure* (masher) and a *cortador de legumes* (chipper), and **both sit on the
same tripod stand**, which is why the catalogue name alone cannot settle it. The evidence
points to the chipper:

1. DAK's own copy for the Grande cutter reads "Modelo que conta com pratico tripe e utiliza
   navalhas cambiaveis nos cortes de 6, 8, 10 e 12mm" - tripod stand, interchangeable blades
   in **6, 8, 10 and 12 mm**. Our `10MM` is one of exactly those four sizes.
2. The other two DAK SKUs are a 10 mm **macho** and a 10 mm **navalha** - the two consumable
   parts of the cutter. A masher has neither. The three SKUs form one coherent set:
   machine + its two replacement blades.
3. A masher has no "blades" and no millimetre cut size at all.

So `IMG/FPR/00050` is most likely the **DAK Cortador de Legumes Grande**, and "Potato Smasher
on Stand" is a naming error. Both candidates are staged as `REF__` so the supplier can point
at the right one. **Do not attach either to the live record until confirmed** - the two
machines look near-identical at thumbnail size, which is exactly how this error would have
been made in the first place.

#### AI-generated imagery on skymsen.com - confirmed, and wider than reported

Three files were flagged for having filenames that are literal image-generation prompts. I
opened all three and judge them **generated, not photographic**, and therefore useless as
verification instruments. I then found **three more of the same family** that were not
flagged, plus one on the LAR group.

The decisive tell in every case is **corrupted text and branding** - the one thing a real
photograph never gets wrong - together with incoherent background objects and lighting that
does not correspond to the shadows.

All seven moved to `_brand-reference\` with an `-AI-GENERATED` suffix:

| File | Px | Judgement |
|---|---|---|
| `IMG-FPR-00051__SI-282HD__butchery-scene-AI-GENERATED.png` | 314x600 | Machine has **no blade**, no control-box detail, and a featureless slab body that does not match the SFL-282HD's tall wheel housing, fence or splayed legs. Hanging carcasses are anatomical mush; shelf stock is undifferentiated blobs. |
| `IMG-FPR-00051__SI-282HD__butchery-scene-2-AI-GENERATED.png` | 314x600 | Same scene, second sample. Same faults. |
| `IMG-FPR-00214__ESB-SUPER-N__counter-scene-AI-GENERATED.png` | 800x584 | Closest to plausible - the body was clearly conditioned on the real ESB SUPER - but the **Skymsen wordmark is deformed** and the SUPER decal is warped. Bottle labels are illegible, the strainer cup melts into the counter, fruit shadows do not match the fruit. |
| `IMG-FPR-00246__DB-10__kitchen-scene-AI-GENERATED.png` | 800x457 | Both chefs have blurred faces and one a malformed hand; tub lettering reads `OTTAGES`; peel waste is visibly cloned; the discharge chute geometry is wrong. |
| `IMG-FPR-00040__CSE__kitchen-scene-AI-GENERATED.png` | 600x600 | **Newly identified.** Generated kitchen - shelf items are blobs, the knife block is incoherent, the extractor's own geometry is soft and its decal unreadable. |
| `IMG-FPR-00048__DB-25HD__kitchen-scene-AI-GENERATED.png` | 600x600 | **Newly identified.** Generated kitchen - garbled packaging text on the shelves, cloned potatoes, unresolved control dial and door on the machine. |
| `GROUP-BLENDER-KITCHEN-SS__LAR-03MB__kitchen-scene-AI-GENERATED.jpg` | 800x533 | **Newly identified.** Generated depth-of-field kitchen, illegible background signage, the cup decal is a smudge. |

A useful secondary signal: these files are anomalously heavy for their pixel count - 716 KB
and 792 KB at 600x600, against 114-204 KB for genuine 600x600 renders from the same site.
Generative noise does not compress like a clean studio render. **Treat any skymsen.com image
whose file size is wildly out of line with its dimensions as suspect.**

Consequence: `IMG/FPR/00214`, `IMG/FPR/00246`, `IMG/FPR/00048` and `IMG/FPR/00040` had an
AI scene as their *only* staged image and were effectively uncovered. All four are now
covered from the folder PDFs (and, for the CSE, from Refrisol).

#### Naming and model notes recorded, not applied

Per the standing rule, `model_number` was not touched. Recording for a later decision:

- `IMG/FPR/00038` stores `LAR 25MB`. **No such model exists.** The badge in the manufacturer
  render reads `LAR-25LMB`.
- `IMG/FPR/00051` stores `SI-282HD`. Skymsen's own spec sheet and asset filenames say
  `SFL-282HD`.
- `IMS/MEC/02319` stores `14MM`. The manufacturer/vendor code is `E14`.
- `IMG/FPR/00042` stores `PA-7`. Current production is `PA7 PRO`; all staged imagery is PRO.
  The PRO differs in disc combinations, teflonised disc finish, feed assembly and weight
  (27.9 kg per this sheet). PRO-only files are named `PA7-PRO` so nothing gets attached to a
  legacy PA-7 listing unexamined.
- Disc naming across vendors, unresolved: skyfood.us calls Z8/Z5/Z3 **grater** and W3/W4
  **ripple cut slicer**; restaurantstock.com calls the same parts "shredding" and "scallop
  cut"; the PA7 PRO folder itself labels Z as `GRATER`, W as `SCALLOP CUT` and H as
  `JULIENNE`. The H3 casting is embossed `H3-EH3` and the W4 casting `W3 - W4`, i.e. blanks
  are shared across sizes - consistent with our stored `H3/EH3`.

#### Coverage across all 24 SKYMSEN-branded SKUs

Stated plainly. "Exact model" means an image where the specific model was positively
identified - by a legible badge or decal, by a distinguishing feature count, or by the
manufacturer spec sheet the render was extracted from.

**Exact-model image at or above the 800 px floor - 14**

| SKU | Model | Best file | Px |
|---|---|---|---|
| IMG/FPR/00042 | PA7 PRO | pdf-render-front-right | 1497x1497 |
| IMG/FPR/00051 | SFL-282HD | pdf-render-front-right | 1659x1659 |
| IMG/FPR/00246 | DB-10 | pdf-render-front | 1849x1849 |
| IMG/FPR/00048 | DB-25HD | pdf-render-front-right | 517x815 |
| IMG/FPR/00038 | LAR-25LMB | pdf-render-front (decal legible) | 972x1458 |
| IMG/FPR/00214 | ESB SUPER-N | pdf-render-with-cones (decal legible) | 667x909 |
| IMG/FPR/00215 | CFI-300L-N | pdf-render-front-right | 1269x1267 |
| IMG/FPR/00040 | CSE | refrisol-front-with-accessories | 1000x1000 |
| IMG/ICE/00019 | BMS-N | pdf-render-front | 485x894 |
| IMG/ICE/00020 | BMS-3-N | pdf-render-front-three-spindle | 1048x1069 |
| IMG/OVE/00215 | MAXICONV | pdf-render-door-open | 1174x1174 |
| IMG/OVE/00214 | DISCOVERY 10 | pdf-render-loaded (badge legible) | 1205x1636 |
| IMS/MEC/02319 | E14 | kitchenall | 1000x1000 |
| IMG/FPR/00169 | BM2 | pdf-render-maxi-blender-front | 524x1270 |

Three of these are portrait crops that clear the floor on the long edge but not on both axes
- BM2 at 524x1270, BMS-N at 485x894 and DB-25HD at 517x815. They pass the rule as written
(800 px on the long edge) and are the manufacturer's own full-height renders, so there is no
larger framing to recover.

**Exact-model image, already done in the first pass - 6**

IMS/MEC/00270 (GC16), IMS/MEC/00271 (Z8), IMS/MEC/00272 (Z5), IMS/MEC/00273 (W4),
IMS/MEC/00274 (H3), IMS/MEC/02131 (E3) - all 1000x1000 from kitchenall. Untouched.

**Exact-model image but below the floor, ceiling proven - 1**

- GROUP/BLENDER-KITCHEN-SS - **LAR-03MB** - 600x600 web / 281x691 PDF. Genuinely capped.
  Ceiling proven twice: skymsen.com serves 600x600, and the group spec sheet renders six
  machines side by side so no single one exceeds 368 px. The one reseller alternative is an
  upscale of a 223 px master and is the wrong (domestic `LS3`) variant.

**Representative / REF only, no confirmed image of our exact unit - 3**

- IMG/FPR/00050 - **DAK** - two candidate machines staged, both `REF__`, both above the
  floor. Blocked on the masher-vs-chipper supplier question above.
- IMS/MEC/00309 - **DAK male blade 10 mm** - `REF__` at 1299x827. The frame shows DAK's macho
  and navalha for the Medio/Grande/Parede range; it is not proven to be the 10 mm size
  specifically, since DAK photographs the set rather than each size.
- IMS/MEC/00312 - **DAK female blade 10 mm** - same frame, same caveat.

**Nothing at all - 0**

Every SKU now has at least one visually verified image staged.

Two deliberate abstentions are worth stating as *outcomes, not gaps*: the three DAK SKUs are
marked `REF__` rather than being given a confident image, and seven AI-generated scenes were
demoted to `_brand-reference` rather than being left in place as product photography. In both
cases attaching the available picture would have been worse than attaching nothing - the DAK
masher and chipper are indistinguishable at thumbnail size, and the AI scenes are exactly the
kind of asset that would have silently propagated a wrong product into the catalogue.

#### _brand-reference contents

Non-product and non-photographic material, kept for reference and deliberately out of the
product-image pool: the seven AI scenes above; the PA-7 dimension drawing and both exploded
views (web 600x600 and PDF 1011x1011); the PA7 PRO disc/grid range chart and dice-kit
combination chart, rasterised at 200 dpi from pages 2-3 of the folder PDF (1654x2339 each -
these are the reference for which discs and grids pair legally, including the "do not use a
slicer disc larger than a dicing grid" rule); the CFI-300L-N dimension drawing from
evandroshop; the CSE dimension/spec and annotated-feature graphics from Refrisol (both
watermarked); the MAXICONV perforated baking-tray accessory; and the LAR-range seamless-cup
component render.

#### Site notes for the next pass

- **kitchenall.com** exposes `https://www.kitchenall.com/media/sitemap/sitemap_products_product.xml`
  (declared in robots.txt). Enumerate it rather than guessing url-keys - that is what found
  E14 after eleven guesses all 404'd. Product-page HTML fetches fine with a browser UA.
- **Check for upscaling before trusting a large file.** Both igorsolucoes (OpenCart) and
  narcel (VTEX) serve arbitrarily large derivatives of small masters. Laplacian variance
  against the declared master is a quick, reliable test; a 5x drop means interpolation.
- **loja.skymsen.com** still 403s to automated fetching, but
  `https://www.skymsen.com/index.php/produtos/detalhe/<id>` works and exposes the folder PDF
  path directly - the reliable way in when a product's friendly URL 404s.
- **dak.com.br** is HTTP-only (HTTPS presents the host's certificate). Its
  `_files/view.php/resize/<w>x<h>/produto/<hash>.png` endpoint caps at the master rather than
  upscaling, so requesting 2000x2000 safely returns native size.
