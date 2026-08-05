# Baron Product Research

Supersedes `old/baron-research.md`. Sourcing/verification pass, August 2026, run against the
SAP dossier. Covers both BARON SKUs: the **SE40/0CB** electric salamander (`IMG/HOT/00186`)
and the **DI7FRE415** 15 L drop-in electric fryer (`IMG/HOT/00189`).

**No `products.json` or `brands.json` change has been applied.** Findings only. **No
`model_number` change is proposed** - including the `O` vs `0` question in section 2.

---

## 1. Brand

**Baron professional - Ali Group srl**, Via del Boscon 424, 32100 Belluno, Italy.
Tel +39 0437 855411, info@baronprofessional.com. Part of **Ali Group**.

- Corporate: https://baronprofessional.com
- Webshop (PrestaShop, where the model data and datasheets live):
  https://baronprofessional.com/online/en/

⚠ The webshop's front page still carries **PrestaShop demo placeholder copy** ("Welcome to
Stark Store... Another one. A major key, never panic..."). That is template filler, not Baron
content - ignore it when scraping.

## 2. `SE40/OCB` vs `SE40/0CB` - Baron publishes the DIGIT ZERO

**Our stored `SE40/OCB` (capital letter O) is a transcription error.** Baron prints the code
eleven separate ways and every one is a zero:

| Where | Value |
|---|---|
| Webshop `Modello` | `SE40/0CB` |
| Webshop `Codice` | `SE40/0CB` |
| Webshop `CODE` spec row | `SE40/0CB` |
| Webshop `Model` spec row | `SE40/0CB` |
| Webshop `mpn` | `SE40/0CB` |
| Datasheet `CODICE`, all 4 pages | `SE40/0CB` |
| Datasheet `MODELLO`, all 4 pages | `SE40/0CB` |
| Datasheet filenames, 6 languages | `SE40-0CB_it.pdf` / `_en` / `_de` / `_es` / `_fr` / `_pl` |
| 3D CAD file | `SE40-0CB.dwg` |
| Press image | `SE40-0CB.jpg` |
| Australian distributor sheet | `SE40/0` |

The `/0` is Baron's **series suffix meaning "bench-top, no base"** - it carries meaning, so
it is a digit by construction. The siblings are `SE60/0CB` and `SE80/0`, and the shared
drawing labels them `SE40_`, `SE60_`, `SE80_`.

**Recommendation only.** `model_number` is the unique ID and must not be changed inline. If
it is ever corrected, the product `name` carries the same letter-O typo ("Salamander Electric
Baron SE40/OCB") and must move with it.

Staged image filenames deliberately keep the **stored** form `SE40-OCB` so they join to our
record; the correct code is recorded in `_sourced.json` and `_FINDINGS.md`.

## 3. IMG/HOT/00186 - SE40/0CB

| | Baron | Our record | SAP |
|---|---|---|---|
| Width | **400 mm** | 400 | 450 (first column) |
| Depth | **450 mm** | 450 | 400 (second column) |
| Height | **500 mm** | 500 | 500 |
| Power | 2 kW | 2 kW | 2 kW |
| **Voltage / frequency** | **220-240 V 1N, 50-60 Hz** | - | "230-240 V~" |
| Cooking surface | 400 x 350 mm | - | 400 x 350 mm |
| Series | SERIE 600 | - | - |

**Our record matches Baron exactly.** SAP's 450/400/500 is the transpose - for this brand
SAP's first two dimension columns are **Depth / Width**.

**Kenya: compatible, no action needed.** 220-240 V single-phase 50-60 Hz covers 240 V / 50 Hz.
The Australian distributor sheet independently states 230 V / 1N / 50 Hz. **No US 110 V or
60 Hz figure appears anywhere in Baron's material for either SKU.**

Detail available from the drawing but absent from our record: overall depth **548 mm**
including the rear cable box, body height **496 mm**, **grid height adjustable 95-240 mm**,
grid depth 178 mm, wall-bracket drilling pattern 342 x 354 mm, accessory **9003** stainless
wall supports (80 mm deep, sold as a pair).

## 4. IMG/HOT/00189 - DI7FRE415 (Codice CR1207639)

| | Baron | Our record | SAP |
|---|---|---|---|
| Width | **400 mm** | 400 | 400 |
| Depth | **625 mm** | 625 | 625 |
| **Height** | **340 mm** | 340 | 🔴 **498** |
| Power | 12 kW | - | 12 kW |
| **Voltage / frequency** | **380-415 V 3N, 50-60 Hz** | - | not recorded |
| Net / gross weight | 25.2 / 35.2 kg | - | - |
| Capacity | 15 L | 15 L | 15 L |
| Packing | 850 x 440 x 1050 mm, 0.393 m3 | - | - |
| IP rating | IPX4 | - | - |
| Series | **DROP-IN 7** | - | - |

- 🔴 **SAP's height 498 is wrong; Baron says 340.** 498 sits right next to the SE40/0CB's
  **500** - the shape of cross-row contamination between this brand's only two SKUs. Our
  `products.json` value of 340 is correct.
- 🔴 **The record's name says "Table Top"; Baron classes it DROP-IN.** Its internal definition
  string is literally `DI7FRE415 FRIGGITR.EL.15LT DROP-IN`, the `DI7` prefix means Drop-In 7,
  and the official render shows the worktop flange, below-counter body, pull-out control
  drawer and long external drain tap. A table-top fryer sits *on* a bench; this one drops
  *through* one. Needs a name decision.
- ⚠ **Three-phase, and the record never says so.** 380-415 V 3N at 12 kW must be hardwired to
  a three-phase board. Kenya's 415 V 3N 50 Hz is inside the band, so the machine is
  **suitable** - but nothing in our record hints that it is not a plug-in unit.
- Baron's commercial code is `CR1207639`; `DI7FRE415` is the *modello*. Both are Baron's own.

## 5. Where to look

| Resource | URL |
|---|---|
| SE40/0CB product page | https://baronprofessional.com/online/en/cottura-salamandre-elettriche-basculanti/4762-17141-electric-salamander-with-movable-radiant-plate-single-phase-2-kw.html |
| DI7FRE415 product page | https://baronprofessional.com/online/en/cottura-friggitrici/5516-17442-electric-fryer-1-bowl-15-l.html |
| SE40/0CB datasheet EN (17/7/2026) | https://storage.onpage.it/6ec0ac5a6488f836f752661f06c6df0aa72798a3/SE40-0CB_en.pdf |
| DI7FRE415 datasheet EN (3/8/2026) | https://storage.onpage.it/c63445d83f6428174b04ddab12d2f6cd7feaf0b7/CR1207639_en.pdf |
| Australian Baron-branded SE40 sheet | https://s3.amazonaws.com/zcom-media/sites/a0i0L00000VH4TSQA1/media/mediamanager/Baron_SE400CB_Spec_Sheet.pdf |
| Ali Group brand page | https://www.aligroup.com/brand/baron/ |
| Tecnoinox sibling (same chassis, different brand) | https://www.tecnoinox.it/en/product/salamanders/classic-en/se-en/classic-electric-salamander-with-movable-top-se-4/ |

### Traps

1. **Datasheet URLs are content-hashed and rotate.** Every hash recorded by the previous pass
   had changed by this one (the old URLs still resolve, but the current documents live at new
   hashes). Always re-scrape the `href` from the live product page; never reuse a stored
   datasheet URL as canonical.
2. **The advertised "Pictures" download is a decoy.** `SE40-0CB.jpg` and `CR1207639.jpg` on
   `storage.onpage.it` look like the press originals but are **372 x 400** and **394 x 394** -
   far smaller than the shop renditions. See section 6.
3. **`baronprofessional.com` is slow and intermittently times out** on image requests, even
   for 40 KB files. Retry rather than concluding an asset is missing.
4. **The DI7FRE415 datasheet's drawing page is blank.** Page 3 of 4 carries the frame and the
   title block with no drawing in it - Baron ships the template that way for this model.
   There is no fryer dimensioned drawing to find.
5. **Ali Group brand overlap** - see section 7.
6. The webshop front page carries PrestaShop demo filler copy; ignore it.

## 6. Images

Folder: `Desktop\ecommerce\products resorce final\baron\`. 4 images + 3 spec PDFs + 1
reference file.

| SKU | File | Px | Source |
|---|---|---|---|
| 00186 | `-baron-1.jpg` | **1100 x 1422** | https://baronprofessional.com/online/108923-thickbox_default/electric-salamander-with-movable-radiant-plate-single-phase-2-kw.jpg |
| 00186 | `-baron-dimension-drawing-SHARED-DOC-2.png` | 1100 x 777 | embedded in the SE40-0CB EN datasheet, p3, extracted with PyMuPDF |
| 00189 | `-baron-1.jpg` | **1100 x 1422** | https://baronprofessional.com/online/115221-thickbox_default/electric-fryer-1-bowl-15-l.jpg |
| 00189 | `-baron-accessory-CR0599830-2.jpg` | 1100 x 1422 | https://baronprofessional.com/online/95390-thickbox_default/kit-2-1-2-baskets-for-drop-in-fryer-lt-10-15.jpg |

**Ceiling: 1100 x 1422**, probed on the PrestaShop rendition ladder (`thickbox_default`
1100 x 1422 > `large_default` 1000 x 1257 > `home_default` 700 x 880) and cross-checked
against Baron's own press originals, which are smaller (trap 2).

**Baron's pages carry only two images per SKU** - one product render and one accessory
render. No gallery, no in-use shot, no control-panel detail exists.

**All four were rendered before acceptance; none is AI-generated.** The salamander render
shows **one knob**, correct for the single-phase 2 kW SE40 (SE60/SE80 have two). The fryer
render is the "Table Top" evidence in section 4.

The salamander drawing is a **shared family sheet** (5415.693.01, covering
SE40_/SE60_/SE80_/QSE_40/QSE_60) and is tokenised `SHARED-DOC` with `code_proven: false`. Its
short edge is 777 px, just under the 800 px floor - it is a reference drawing, not a hero.

The image-id numbers changed since the previous pass (82702 -> 108923 for the salamander,
88839 -> 115221 for the fryer). Do not hard-code them.

## 7. ⚠ Ali Group brand overlap - the biggest image is the wrong brand

The same chassis is sold by **Tecnoinox** (also Ali Group) as the "Classic electric Salamander
with movable top SE 4". Tecnoinox's own render -
https://www.tecnoinox.it/app/uploads/2024/06/IMG-216041_20240511_181928.jpg - is
**1920 x 1419**, the largest image of this machine anywhere and exactly what a "pick the
biggest" rule would take. Rendered, it is unmistakably a different brand: **black perforated
fascia carrying the TECNOINOX wordmark and a numbered rotary knob**, where Baron's is plain
stainless with a black knob.

It is staged as
`_brand-reference/tecnoinox-SE-4-same-chassis-DIFFERENT-BRAND-not-baron.jpg`. **Do not use it
as a Baron product image.**

Related: Scots Ice Australia publishes an "SE40/0CB" datasheet that is on **Tecnoinox
letterhead**. The Australian sheet staged here
(`...-spec-AU-distributor.pdf`, from `zcom-media`) is genuinely Baron-branded - model code
`SE40/0`, 230 V 1N 50 Hz - and does not have that problem.

## 8. Product reference

| SKU | Stored model | Baron's own code | Datasheet | Confidence |
|---|---|---|---|---|
| IMG/HOT/00186 | `SE40/OCB` (letter O) | **`SE40/0CB`** (zero), SERIE 600 | https://storage.onpage.it/6ec0ac5a6488f836f752661f06c6df0aa72798a3/SE40-0CB_en.pdf | **High** - official dated datasheet, exact match |
| IMG/HOT/00189 | `DI7FRE415` | `DI7FRE415`, Codice **`CR1207639`**, SERIE DROP-IN 7 | https://storage.onpage.it/c63445d83f6428174b04ddab12d2f6cd7feaf0b7/CR1207639_en.pdf | **High** - official dated datasheet, exact match |

Supporting sources:

- https://c5australia.com/product/baron-se40-0cb/
- https://hospitalityequipmentonline.com.au/baron-se40-0cb-adjustable-height-electric-salamander-grill-with-400x350x-cooking-surface
- https://www.scotsice.com.au/equipment/se40-0cb/
- https://ferrettigroup.com.au/product/adjustable-height-electric-salamander-grill-with-400-x-350-mm-cooking-surface/
- https://baronprofessional.com/online/en/34-cottura-salamandre-elettriche-basculanti
