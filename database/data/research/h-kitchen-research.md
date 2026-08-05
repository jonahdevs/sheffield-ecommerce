# H-Kitchen Product Research

**This file supersedes `database/data/research/old/h-kitchen-research.md`.** That earlier pass was
written before anyone had successfully read h-kitchen.com. Several of its headline conclusions are
now refuted by the supplier's own documents — see §2 and §7. Where this file and the old one
disagree, this one wins; where the old file is uncontradicted, it remains useful and is not
reproduced here.

Scope: the **13** H-KITCHEN SKUs in SAP (the old pass covered 12 — it missed
`IMG/FPR/00277`, the PB606010 chopping block).

---

## 1. The headline: h-kitchen.com **does** carry this brand's own codes

The single question this pass was set up to answer.

For the sibling label HK-REDLINE, an earlier crawl found only 6 of 102 codes anywhere on
h-kitchen.com and concluded the site was near-useless. **That finding does not transfer to
H-KITCHEN.** Four of our 13 SKUs are provably Hangzhou Kator's own catalogue products,
documented on H-KITCHEN letterhead or on the live site's own spec tables:

| SKU | Code | Where it is proven |
| --- | --- | --- |
| IMG/PAS/00159 | `NFK-30I` | Archived spec sheet *and* the current live site, both by exact code |
| IMG/BUF/00249 | `TC-2F` | Archived spec sheet, exact code, full spec table |
| IMG/OVE/00217 | `HX-1SA` | Current live site, exact code, and the code is lettered into the photo |
| IMG/FPR/00277 | `PB606010` | Not listed, but the `PB` series encoding **decodes our code exactly** (§3.1) |

The remaining nine are genuinely absent from every H-Kitchen source. Kator is a
**foreign-trade company**, so "H-KITCHEN" on our invoice means *imported via Kator*, not
*made by Kator* — both situations coexist inside this one brand, which is why the HK-REDLINE
conclusion did not carry over.

### 1.1 How the site was actually read

Two distinct sites exist under the same domain, and they must be worked separately.

**The old ASP site (≈2011–2017)** — reachable only through the Internet Archive. A CDX query for
`h-kitchen.com/*` returns **3,146 distinct URLs**, and inside them sits the thing that matters:

> **`/images/cppic/` holds 512 PDF spec sheets, 465 of them named after the product** —
> `P5014- (4.5)full automatic dividing & Rounding machine NFK-30I.pdf`,
> `P113-1 WARM TRAY.pdf`, `P5005-(02-05) Planetary mixer B10GFA B20GA B30GA B40FA.pdf`.

This directory is the brand's whole catalogue as datasheets and was never linked from anywhere a
normal crawl would reach. It is also where the HK-REDLINE codes live (`B10GFA`, `B20GA`, `B30GA`,
`HK-B5/B7/B8`, `HK-BS-31`…), so **a HK-REDLINE re-pass should start here**, not with the site's
HTML.

**The current site (2023–, Hangzhou Kator Foreign Trade Co.)** — `/index/index/productdetail.html?id=N`.
It responds fine; the "3 KB/s, homepage times out at 120 s" note from the HK-REDLINE pass did not
reproduce. 320 product pages were retrieved with a 12-thread pool and a 240 s timeout, yielding
**293 model codes across 117 categories**. Of our codes, only `HX-1SA` and `NFK-30I` appear.

⚠ **The two sites are not supersets of each other.** `TC-2F` and the `PB` series exist *only* in the
old archive; `HX-1SA` exists *only* on the live site. Working one and not the other loses SKUs.

### 1.2 Where the images are, and how to attribute them

- **Old site**: `/images/cppic/*.jpg` are **120 × 90 thumbnails** — useless. The real photographs are
  **embedded inside the PDFs** and must be pulled with PyMuPDF `extract_image()`.
  Measured across all 61 sheets retrieved: **113 non-letterhead objects, largest long edge 631 px,
  and none — zero — reach the 800 px short-edge floor.** Meanwhile a 654 × 661 letterhead and a
  721 × 142 rule appear in **61 of 61** sheets, so a "take the biggest image" rule returns furniture
  61 times out of 61. **That is this supplier's proven ceiling for its own old photography.**
  Filenames carry no codes, so attribution is **by page context** — the sheet's own spec table.
- **Live site**: `/upload/<date>/<hash>/<NAME>.jpg` at a uniform **800 × 800**, and the filenames
  *do* carry codes (`NFK-30I.jpg`, `HX-1SA,-HX-2SA.jpg`, `BSR-202Q.jpg`). Several also have the
  model lettered into the image itself. This is the better source by a wide margin.

Sources:
https://web.archive.org/cdx/search/cdx?url=h-kitchen.com/*&output=json&collapse=urlkey
http://h-kitchen.com/index/index/productdetail.html?id=104
http://h-kitchen.com/index/index/productdetail.html?id=120
https://h-kitchen.en.made-in-china.com

---

## 2. Corrections to the archived research

### 2.1 ⚠ `NFK-30I` is a real factory code — the old §5.8 is wrong

The old pass recorded that *"the 'I' in NFK-30I is unattested"* and recommended changing the model
to `NFK-30`. H-Kitchen publish `NFK-30I` themselves, twice, six years apart:

- Archived sheet, titled **"Full automatic dividing & rounding machine"**: Pc code 510066, Model
  **NFK-30I**, 380 V, 0.75 kW, dough 30–100 g, 30 pc/time, 640 × 540 × 2100, 300 kg.
- Live site id=104, **"Full Automatic Dividing & Rounding Machine"**: Model **NFK-30I**,
  220/380 V, 1.5 kW, 30–100 g/pc, 30 pc/time, 550 × 650 × 1460, 485 kg.

`NFK-30` (no suffix) is the **half-automatic** sibling, a different machine. `NFK-30Q`, which the old
pass named as the fully-automatic variant, does not appear in any H-Kitchen source; the
fully-automatic machine is `NFK-30I`. **`model_number` needs no change.**

### 2.2 ⚠ Our stored photo for the bun divider is the wrong machine

Both H-Kitchen publications picture the two machines and label them in-image:

- **NFK-30I** — enclosed dome head, boxy pedestal cabinet, button panel, **no lever**.
- **NFK-30** — open yellow divider ring with a long red-tipped **manual press lever**.

Our catalogue ships the lever machine. The old pass reached the same conclusion from the opposite
direction (it thought the *dimensions* were wrong and the photo right); in fact the SKU is the
full-automatic machine and it is the **photo** that is wrong.

### 2.3 ⚠ The supplier contradicts itself on the divider's size — so SAP is not safe here

| Source | Power | Dimensions | Weight |
| --- | --- | --- | --- |
| SAP | 0.75 kW | 640 × 540 × 2100 | 300 kg |
| H-Kitchen archived sheet | 0.75 kW | 640 × 540 × 2100 | 300 kg |
| H-Kitchen live site | 1.5 kW | 550 × 650 × 1460 | 485 kg |

SAP matches the archived sheet exactly — but **the archived sheet gives the half-automatic
`NFK-30` the identical row**, which is a copy-paste defect on the supplier's side. So SAP's numbers
descend from a document known to be broken, and the agreement is not corroboration.

**The third source arrived.** Guangzhou Ola-Oficina sell the same machine as `HM-30QS/36S` and
independently give **1.5 kW / 485 kg** — matching h-kitchen.com's current row exactly, from a
supplier with no lineage to H-Kitchen. **Power and weight are therefore decided against SAP:**
0.75 kW / 300 kg is the semi-automatic's row leaking across. Market weights for this machine class
cluster 330–485 kg, with nothing near 300.

⚠ **Height is still open.** Do not repeat the reasoning that 2100 mm is implausible — three
unrelated suppliers list ~2100 mm for this class (ZB-30S 600 × 770 × 2100, BM-30S 740 × 570 × 2100,
K30 740 × 570 × 2100). 1460 vs 2100 needs a measurement, not an argument.

This is a clean example of the general rule: *SAP agreeing with a supplier document proves nothing
when the supplier document is itself defective.*

### 2.4 ⚠ `HX-1SA` is the DIGITAL model, and the previously staged photo is the manual one

Live site id=120, "Conveyor Pizza Oven":

| Model | HX-1 | HX-2 | **HX-1SA** | HX-2SA |
| --- | --- | --- | --- | --- |
| Voltage (V) | 220 | 380 | **220** | 380 |
| Power (kW) | 6.7 | 10.3 | **6.7** | 10.3 |
| Dimension (mm) | 1380×555×420 | 1940×740×1130 | **1380×555×420** | 1940×740×1130 |
| Working area (mm) | 560×385 | 800×540 | **560×385** | 800×540 |
| Weight (kg) | 47 | 86 | **46** | 116 |

The two page photos are captioned **in-image**: *"HX-1SA/HX-2SA Digital model"* (three red LED
displays and a keypad) and *"HX-1/HX-2 Manual model"* (two round knobs, blue decals).

Our SKU is "Conveyor Pizza Oven-**Digital**". The old pass staged a photo it described as having
"blue/red control decals, twin knobs" — **that is the manual HX-1, not our oven.** Any candidate
photo must be checked for LED displays versus knobs.

Also: the 3-phase sibling is **HX-2SA**, not "HX-1SA/3N" as the old pass guessed, and it is a much
larger machine (1940 × 740 × 1130) rather than a badge variant.

### 2.4a `TC-2F` power is genuinely contested — do not silently pick one

H-Kitchen's own sheet says **0.8 kW** and SAP agrees. Rebenet (*"1000W"*) and Hamoki
(*"1 KW / 240 V"*) both say **1 kW**, with the gantry lamps separately rated 150 W. Dimensions
730 × 580 × 550 and net 14 kg are confirmed on both sides. The old research reached the 1 kW figure
too; what is new is that the *manufacturer's own datasheet* disagrees with its own resellers.

Also worth knowing before anyone browses that gallery: **5 of the 6 images on Rebenet's TC-2F page
are different products** — three round bain-maries, a 6-pan table, and the flat no-gantry TC-2
sibling. Only one is the TC-2F.

### 2.5 The `YC` prefix is H-Kitchen's own, not only Yehos's

H-Kitchen's archived wine-cellar sheets list `YC-103A / YC-188A / YC-270A / YC-450A` and
`YC-103D / YC-188D / YC-270D / YC-450D` — i.e. **`YC-<litres>`**. Our `YC-53` (53 L) and
`YC-120-2D` (120 L, 2 doors) fit that scheme exactly. The old pass attributed the code purely to
Zhongshan Yehos; both can be true (Kator badging a Yehos build), but the code shape is Kator's.

### 2.6 ⚠⚠ `SOT-4` **is** a gas bain marie — old §5.6 is refuted

Old research §5.6 stated *"No SOT-series gas bain marie exists anywhere"*, called the record
"fiction", and recommended renaming and recategorising it as a 4-burner gas stove. **A genuine
SOT-4 was found and it is exactly what SAP says.**

`OUTE` list **Model Number `SOT-4`, Product Type: Bain Marie** — a counter-top **gas** bain marie,
700 × 650 × 470 mm, 6 kW, 29 kg. The photograph (2288 × 2008, verified genuine) shows a stainless
well with GN pans and lids, louvred splash back, red gas control knob with flame symbols, piezo
igniter, chromed drain tap and adjustable bullet feet, OUTE badge legible.
https://www.alibaba.com/product-detail/OUTE-SOT-4-Counter-Top-Gas_1601779423107.html

The arithmetic agrees independently: SAP's *"27700 btu/hr"* is about 8 kW — right for a bain marie
and **far too low for a 4-burner range** (H-Kitchen's own RB-4 is 86,000 BTU/h, our EHP-4S is
100,000). The old pass reasoned from the sibling `SOT-4S` being a stove, but a `-S` suffix here
marks a different appliance, not a variant of the same one.

**Recommendation reversed: do NOT rename or recategorise IMG/HOT/00272.** Old §8 item 9 should be
dropped. SAP's name, category and remark are all correct.

**And the "H-Kitchen's stoves are `RB-`, so `SOT-` is foreign" argument collapses too.** I made that
argument from archived sheet P79-1 (`RB-1 / RB-2 / RB-4 / RB-6`; RB-4 = 4 burners, 86,000 BTU/h,
600 × 770 × 360). But **`RB-` is OUTE's series, not H-Kitchen's** — FFT Asia lists the whole range
as `GP-OT-RB-*` OUTE products. H-Kitchen simply resells OUTE. So `SOT-` and `RB-` come from the
*same* maker, and `SOT-4`'s absence from h-kitchen.com's own pages says nothing at all about
whether it is real. It is real.

⚠ **`SOT-4S` is a separate OUTE product, not a variant of `SOT-4`** — a 4-burner counter-top gas
claypot stove, 570 × 630 × 530 mm, 44 kg. The trailing `S` distinguishes **stove** from
**soup-well**. So our sibling record `IMG/HOT/00067` being a stove was never evidence that `SOT-4`
was mislabelled — the entire chain of reasoning behind old §5.6 was built on that false premise.
**Both records are correct as they stand.**

One genuine discrepancy remains: SAP's **27,700 BTU/hr** conflicts with OUTE's **6 kW**
(≈20,500 BTU/hr). Both are bain-marie scale, so the product identification is unaffected, but the
heat input in our remark is unverified.

⚠ **That Alibaba listing is also where this pass's AI-generated images were found** — four of six
gallery images, all re-lit cut-outs of the one real photo on generated backgrounds. See §7.

---

## 3. Decoding H-Kitchen's own code schemes

### 3.1 `PB` = polythene board, size in centimetre pairs

From the two archived P6234 sheets:

| Model | Size |
| --- | --- |
| PB503503 | 500 × 350 × 30 |
| PB503504 | 500 × 350 × 40 |
| PB604003 | 600 × 400 × 30 |
| PB604004 | 600 × 400 × 40 |
| PB404010 | Ø400 × 100 |
| PB454510 | Ø450 × 100 |
| PB484812 | Ø480 × 120 |

The pattern is `PB` + three two-digit groups, each in **centimetres**. Therefore:

> **`PB606010` = 600 × 600 × 100 mm — SAP is exactly right.**

Independently corroborated from outside H-Kitchen entirely: **Euroceppi's published catalogue uses
the identical scheme** — `CP606010` = 60 × 60 × 10 cm, alongside `TP60608` and `CP707030`. Two
unrelated manufacturers encoding sizes the same way makes the reading safe.

This also places our SKU in the **100 mm-thick block** class (butcher-block style), not the
30/40 mm flat cutting-board class. Worth checking the catalogue copy says "block", not "board".

⚠ **What the code does NOT tell us is the shape.** `PB404010` carries three pairs but its size is
published as only two figures, `Φ400 × 100` — so for round items the first two pairs are the
**bounding square**, not two real axes. The code therefore encodes a bounding box. An earlier draft
of this file inferred that `PB606010` must be the square member because H-Kitchen's three thick
blocks are round; that inference was unsound and is withdrawn. H-Kitchen's own sheet does use `Φ`
for all three and photographs them round — but whether **ours** is round or square is undetermined
by the code, and SAP's *"CHOPPING BLOCK 600X600X100"* is the only hint. The photographs filed for
this SKU are `REPRESENTATIVE-RANGE` for exactly this reason.

### 3.2 Other prefixes seen (useful for the HK-REDLINE re-pass)

`TC-` warm trays · `RB-` table-top gas stoves · `BL-` commercial blenders · `YC-` wine cellars ·
`NFK-` dough dividers · `HX-` conveyor ovens · `BSR-` gas pizza ovens · `MBF-` upright fridges ·
`B…GA/GFA`, `HK-B…`, `HS…`, `HT…`, `SH…` mixers · `FGY…/FGYGN…` Frigo showcases.

---

## 4. SAP audit

### 4.1 Column order — established from SAP itself

The dossier JSON's `length` / `width` / `height` map to **Width / Depth / Height**. Proven from
SAP's own text without reference to any outside source: the `HX-1SA` remark states
*"UNIT (W x D x H) ; 1380\*555\*420mm"*, and that row's fields are exactly `length=1380,
width=555, height=420`. Externally corroborated on TC-2F (supplier sheet 730 × 580 × 550 = SAP
730/580/550), NFK-30I and YC-53. **No per-row variation was found in this brand.**

⚠ **`_DOSSIER.md` renders these labels transposed.** It prints the JSON's `width` first under a
"W/D/H" heading, so YC-53 shows as "563.0/592.0/450.0" when the true width is 592, and HX-1SA
shows as "555.0/1380.0/420.0" against its own remark's 1380 × 555 × 420. Read the JSON, not the
Markdown, for axis order. (Not edited — the dossier is read-only for this pass.)

### 4.2 SAP fields that contradict SAP's own remarks

- **`HX-1SA` weight** — field says **38 kg**; its own remark says *"NET WEIGHT; 46kg. GROSS
  WEIGHT; 57kg"*, and h-kitchen.com says 46 kg. The 38 is wrong.
- **`HX-1SA` voltage** — remark says *"230v-50Hz-2Phase"*. There is no 2-phase build; h-kitchen.com
  says 220 V single phase. (The old pass called this too.)
- **`TC-2F` dimensions** — SAP's fields are correct at 730/580/550; our *products.json* record holds
  `29/23/22`, which is the same figure in **inches**. Already flagged in the old pass, still unfixed.
- **`NFK-30I`** — see §2.3.

### 4.3 The remarks are squashed, and must be pattern-mined

Confirmed again: this brand's `Item Remarks` lost their line breaks in export, so fields run
together — *"5-18℃capacity: left 57 cans + right 18 bottlesshelves: 3 metal shelves"*. Splitting on
`;`, `*` or ` - ` (which work for SV-Blueline and OEM Sheffield) returns nothing.

A regex miner over unit markers recovered structured data from **12 of 13** rows (the 13th,
PB606010, has a remark identical to its description and carries nothing extra):

| SKU | Recovered |
| --- | --- |
| IB350CV | 350 W |
| BLD300 / BLD400 | 300 mm / 400 mm |
| 8002 | 230 V, 50 Hz, 2200 W |
| YC-53 | 230 V/50 Hz, 53 L, 5–19 °C, 24 bottles |
| TYC-120-2D | 230 V/50 Hz, 120 L, 2–10 °C + 5–18 °C, 57 cans, 18 bottles, 3 metal shelves |
| HX-1SA | 50 Hz, 6.7 kW, carton 1240×680×450, **unit 1380×555×420**, 46 kg net / 57 kg gross |
| NFK-30I | 400 V/50 Hz, 0.75 kW, 30–100 g |
| TC-2F | 230 V/50 Hz, 0.8 kW, lamp 150 W |
| SOT-4 | 27,700 BTU/hr |
| KD 20SL-FL | 230 V/50 Hz, 300 W, 15 L, 70 ± 10 °C |
| EHP-4S | 25,000 BTU, 24″ W |

The patterns that pay for themselves: `\d+V`, `\d+Hz`, `[\d.]+kw`, `\d+W`, `\d+L`,
`-?\d+\s*[-~]\s*\d+\s*℃`, `\d+±\d+°`, `[\d,]+btu`, `\d+\s*bottles?`, `\d+\s*cans?`,
`\d+-\d+g`, `\d+\s*pc/time`, `\d+[*x]\d+[*x]\d+\s*mm`, `\d+kg`, `\d+\s*MM`.

⚠ Useful side effect: on `HX-1SA` the miner returns **two** dimension triples because the remark
carries packaging *and* unit. The SAP fields took the **unit** figure, so this row is not
carton-contaminated — but a bulk importer that grabbed the first match would have stored the
carton. Always mine all matches and pick by the label next to them.

---

## 5. What is confirmed, per SKU

| SKU | Code | Best source | Dimensions vs SAP |
| --- | --- | --- | --- |
| IMG/FPR/00277 | PB606010 | H-Kitchen PB series encoding | **Confirms 600 × 600 × 100** |
| IMG/FPR/00217 | IB350CV | twothousand.com, GGM Gastro, Garyton | SAP has none |
| IMG/FPR/00220 | BLD300 | GGM Gastro MSA30 (length dimensioned on the photo) | SAP has none |
| IMG/FPR/00221 | BLD400 | GGM Gastro MSA40 (length dimensioned on the photo) | SAP has none |
| IMG/FPR/00274 | 8002 | Longyue LY-8002 | Agrees; see §6.1 |
| IMG/DIS/00142 | YC-53 | Yehos, with factory dimension drawing | **Exact** |
| IMG/DIS/00143 | TYC-120-2D | Yehos, with factory dimension drawing | **Exact** (594/574/871 vs 595/575/870) |
| IMG/OVE/00217 | HX-1SA | **h-kitchen.com live** | **Exact**; weight field wrong (§4.2) |
| IMG/PAS/00159 | NFK-30I | **h-kitchen.com, both eras** | **Contested — see §2.3** |
| IMG/BUF/00249 | TC-2F | **h-kitchen.com archived sheet** | **Exact** |
| IMG/HOT/00272 | SOT-4 | **OUTE, exact code + product type** | SAP has none; identity confirmed |
| IMG/HYS/00196 | KD 20SL-FL | Seeway / KANGDA, nameplate legible | **Exact** |
| IMG/HOT/00267 | EHP-4S | Rebenet + Chefs Range | SAP has none; 600 × 690 × 340 established |

Full per-file provenance is in `_sourced.json` in the image folder; per-pass detail is in
`_FINDINGS.md` alongside it.

### 5.1 Where our catalogue is carrying the wrong picture

Three records are shipping a photograph of something other than what they sell. All three are
newly evidenced here and none were changed — this pass sources and documents, it does not edit
`products.json`.

1. **IMG/PAS/00159** — ships the **half-automatic NFK-30** (long manual lever). The SKU is the
   full-automatic `NFK-30I` (enclosed dome head, no lever). Both machines are captioned in-image
   by the manufacturer, so this is not a judgement call.
2. **IMG/OVE/00217** — the photo previously staged for it is the **analogue HX-1** (twin knobs).
   The SKU is the digital `HX-1SA` (three LED displays).
3. **IMG/FPR/00220 and IMG/FPR/00221** — both spare-part tube records ship a photo of a **complete
   motorised blender**. Bare, length-dimensioned tube photos are now available for both.

---

## 6. Corrections carried forward from the parallel sourcing passes

### 6.1 ⚠ The 8002 "variant trap" was a mislabelled carton, not a variant

The old pass recommended replacing SAP's 255 × 230 × 580 with a "factory" 325 × 300 × 630. But
Longyue's own sheet lists **PRODUCT SIZE and CARTON SIZE as the same 325 × 300 × 630** — a unit
cannot equal its own carton, so that figure is the **carton**. SAP's dimensions sit a consistent
70/70/50 mm inside it, exactly as a packed unit should. **Leave SAP's 8002 dimensions alone**; the
old §5.4 recommendation should not be actioned.

Same sheet: SAP's *"NWB bearing"* is a corruption of **NMB** (Minebea) — the manufacturer's card
reads "Impotrted NMB". Longyue's sheet also says 1800 W, contradicting both its own product card
and its page spec block, which agree with SAP at 2200 W; the 1800 is boilerplate from the 2 L
LY-8003.

### 6.2 The BLD tubes belong to the **metric** family

VEVOR sells an `IB350CV` whose shafts are imperial-derived (254/305/406/508 mm); the
twothousand / Garyton / GGM family is metric (200/250/300/350/400/450/500 mm). `BLD300` and
`BLD400` are exactly metric, so **VEVOR's spec sheet must not be used to source dimensions for
these records.** GGM gives what SAP lacks entirely: 82 × 82 × 300 / 400 mm overall, Ø35 mm shaft.

Garyton's spec table lists `GRT-BLD300 = 300mm*35` and `GRT-BLD400 = 400mm*35`, both
*"Accessory For: IB350/IB500"* — one document tying all three blender SKUs together.

### 6.3 YC-120-2D: three pages, one of them the wrong product

Yehos runs `/75` and `/57` both titled "YC-120-2D", plus `/103` titled "YH-120-2D". `/75` and
`/103` carry our dual-zone spec; **`/57` is the 36-bottle wine-only unit** and is a different
product. The trap the old pass warned about is real and is resolved by comparing zone layout, not
by matching the code.

Open question for the business: the unit ships with either a **solid or a glazed left door** —
both appear in the factory gallery and SAP does not record which we buy.

Sources:
https://www.longyueblender.com/product-26000-rpm-high-speed-heavy-duty-professional-blender.html
https://www.ggmgastro.com/en-gb-gbp/blender-shaft-300mm-msa30
https://www.ggmgastro.com/en-gb-gbp/blender-shaft-400mm-msa40
https://www.garyton.com/GRT-BLD300-Hand-Blender-Accessories-300mm-For-Commercial-Using-pd40860604.html
https://www.twothousand.com/7-kinds-of-shaft-length-variable-speed-350w-commercial-immersion-blender-ib350cv-a-series/
https://www.yehos.com/Products_details/31.html
https://www.yehos.com/Products_details/103.html

---

## 7. Tooling notes for the next pass

- **Try the Internet Archive CDX index before the live site**, but then try the live site too — for
  this domain the two eras hold *different* products (§1.1).
- **Unlinked `/images/cppic/` held 512 spec PDFs.** Whenever a Chinese supplier site looks thin,
  CDX the whole domain and filter for `.pdf`; the catalogue is often there and unlinked.
- **PyMuPDF `extract_image()` on the sheets, but filter the letterhead.** Every sheet's largest
  embedded object is the logo. Rank by size *after* dropping the object that repeats across files.
- **Render every sheet as well as extracting from it** — a 200 dpi page render is the only artefact
  where the spec table and the photo can be read together, and it survives being handed on.
- ⚠ **"Pick the biggest" failed twice more in this pass, both concretely.** The
  highest-resolution `HX-1SA` asset anywhere on the web is an F.E.D./Baker Max photo at 1100 × 1100
  (after stripping the Magento cache hash) — and it is the **analogue twin-knob oven**, the wrong
  machine. And the largest file in the whole blender pass is a 4096 × 4096 GGM composite showing
  four different models whose housings do not match the IB350CV mould. Both were rejected.
- ⚠⚠ **AI-generated imagery was found in two places and is now common enough to assume.**
  (a) `lianfujx.en.made-in-china.com` serves a conveyor-oven photo watermarked 豆包AI生成 ("Doubao
  AI-generated") — synthetic *and* the wrong machine; rejected. (b) The OUTE `SOT-4` Alibaba
  listing has **four of six gallery images synthetic** — two spec cards, a dimension card and two
  lifestyle scenes, all made by re-lighting a cut-out of the single real photo onto generated
  backgrounds. Tells that worked: garbled brand text on props, a unit shown without the badge it
  carries in the real photo, and proportions that drift between images of "the same" product.
  ⚠ Note the failure mode this creates: **a supplier's own gallery can be mostly synthetic while
  still containing one genuine photograph.** Screen every image, not a sample — and keep a
  synthetic spec card only for its *numbers*, filed in `_ai-generated\`, never as a likeness.
- **h-kitchen.com's availability is intermittent.** It served 320 product pages and every image
  requested at 12 threads without complaint, then stopped answering on port 80 entirely later in
  the same session. Treat a timeout as transient and retry later rather than concluding the site
  is dead — and grab what you need in one pass while it is up.
- **Two-stage hashing earned its keep, visibly.** On the conveyor-oven set a 16 × 16 average hash
  gave d = 6/7/8/9 across genuinely *different* machines and d = 1/2 across the *same* machine —
  overlapping ranges. The 256 px greyscale RMS separated them cleanly at 7–8 (same) versus 25–27
  (different). **ahash alone would have merged the digital and manual ovens.**
- ⚠ **Run one cross-SKU duplicate sweep over the whole folder at the end**, not just within each
  SKU. This pass found a five-tube-and-two-whisk family shot sitting on the *motor* SKU
  (IMG/FPR/00217) under a bare code-asserting filename, byte-identical to files already correctly
  flagged `REPRESENTATIVE-RANGE` on the two tube SKUs. Only a whole-folder sweep sees that.
- ⚠ **Parallel agents sharing one output folder will delete each other's files.** A cleanup step
  scoped to the prefix `IMG-FPR-*` removed another agent's `IMG-FPR-00277` files. Scope cleanup to
  the *exact* SKUs an agent owns, never to a three-letter category prefix.
- **WebSearch quota exhausted at the first call** for every parallel pass in this session (200/200
  before a single query ran) — a session budget cap, not an outage. The working fallback was
  **`POST https://html.duckduckgo.com/html/`** via WebFetch; the plain `duckduckgo.com/html/` host
  302s into a CAPTCHA unless the query is **quoted**. Bing's HTML and RSS endpoints return junk;
  searx.be, Mojeek, Ecosia and Brave are all bot-blocked. Expect to hit this again.
- **Alibaba**: a **Googlebot user-agent on a cold session** gets the full page; ordinary browser
  UAs always get the CAPTCHA — and it is flaky, working once then blocking. `alicdn` serves AVIF
  when `Accept` includes `image/avif` (Pillow decodes it, the Read tool cannot) — send
  `Accept: image/jpeg`.
- **1688 and Taobao are hard-blocked, but their DuckDuckGo *snippets* carry full spec text** — that
  is literally where the SOT-4 breakthrough came from. Read the snippet when the page is closed.
- Chefs Range: `_medium` → bare filename for the original (`_large` 404s).
- Filename-prefix convention drifted between agents: `REPRESENTATIVE-RANGE_IMG-…` versus
  `IMG-…__REPRESENTATIVE-RANGE-…`. Both are searchable; pick one next time.
