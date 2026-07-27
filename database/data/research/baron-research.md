# Baron Product Research

Research notes behind a BARON audit pass on `products.json` (July 2026).
Covers both BARON SKUs: the SE40/0CB electric salamander (`IMG/HOT/00186`, Fast Food) and
the DI7FRE415 15 L drop-in electric fryer (`IMG/HOT/00189`, Fryers).

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema, Santos and Empero passes before a scope decision.

Only 2 SKUs, so both were taken all the way to the manufacturer's own PDF datasheet. Both
are genuine, current, in-catalogue Baron products. Both records nevertheless carry at least
one wrong dimension, and both carry a naming/labelling problem.

---

## 1. Brand identification — confirmed

**Baron** = **Baron professional**, trading as **Ali Group srl**, Via del Boscon 424,
32100 **Belluno, Italy** — the legal entity printed on the footer of every official Baron
datasheet. Baron is a professional-cooking-equipment brand within the **Ali Group**, the
Italian foodservice-equipment conglomerate.

- Company page: https://baronprofessional.com/en/company/
- Ali Group brand page: https://www.aligroup.com/brand/baron/

`brands.json` already has `slug: baron`, `website_url: https://www.baronprofessional.com`.
**This is correct.** The `www.` host resolves HTTP 200 and redirects to the apex
`https://baronprofessional.com/`. No `brands.json` URL change needed.

The existing `brands.json` description ("premium manufacturer of professional cooking
equipment … cooking ranges, ovens, and kitchen systems") is accurate but generic — it omits
that Baron is **Italian (Belluno)** and part of the **Ali Group**, both of which are the
kind of provenance detail the other brand entries carry.

**Both catalogue SKUs were located in Baron's own live product catalogue**, so the brand
attribution on both records is correct:

- SE40/0CB — Baron webshop lists `Modello: SE40/0CB`, `Codice: SE40/0CB`, series **SERIE 600**
- DI7FRE415 — Baron webshop lists `Modello: DI7FRE415`, `Codice: CR1207639`, series **DROP-IN 7**

---

## 2. Where to look

| Resource | URL | Value |
|---|---|---|
| Corporate site | https://baronprofessional.com/en/ | Company/brand copy |
| Online catalogue (PrestaShop) | https://baronprofessional.com/online/en/ | Per-model feature tables, product renders, datasheet links |
| **Official per-model datasheet PDFs (gold standard)** | `https://storage.onpage.it/<hash>/<CODE>_en.pdf` | Full spec table, installation drawings, accessory list. Linked from each product page in IT/EN/DE/ES/FR/PL |
| Scots Ice Australia (Baron distributor) | https://www.scotsice.com.au/ | Own re-issued datasheet PDFs — useful, **not authoritative** (see §4.2) |

### Traps

1. **Baron's catalogue URLs are unstable and WebFetch will silently serve the wrong
   product.** Fetching the salamander URL that a web search returned
   (`.../2961-salamandra-elettrica-ultrarapida-a-piano-mobile-monofase-2-kw.html`) came back
   as **"HYPER TECH WASH PLUS — BPHTW3SPLUS", a dishwasher** — a completely different
   machine, with a full and entirely plausible spec table. Numeric product IDs get recycled.
   **Do not trust a Baron product page fetched by URL alone; verify the `Modello`/`Codice`
   fields on the page match the model you asked for.** The reliable route is the site search
   (`/online/en/search?controller=search&s=<MODEL>`) via `curl`, then read the embedded
   PrestaShop JSON, which carries a clean `features` array and the datasheet links.
2. **PDF datasheets don't extract via WebFetch** — same trap as the Santos pass. The `Read`
   tool renders them properly, including the dimensioned installation drawings, which turned
   out to be decisive for resolving both dimension conflicts below.
3. **Distributor datasheets are re-typeset and can drift from Baron's own numbers.** The
   Scots Ice sheet for DI7FRE415 disagrees with Baron on height by 158 mm (§4.2), and the
   Scots Ice sheet for SE40/0CB is not a Baron document at all (§3.3).
4. **`scotsice.com.au` product pages 404 to both WebFetch and `curl`** (their PDFs under
   `/wp-content/uploads/` are fine). Spec text from that site had to be taken from search
   snippets rather than the live page.

---

## 3. SE40/0CB — Salamander Electric (IMG/HOT/00186)

Official Baron datasheet (dated 17/5/2026, i.e. current):
https://storage.onpage.it/4c45b5575c7c6bc3e3cb6eb06db3b1f965dcde25/SE40-0CB_en.pdf
Official catalogue page:
https://baronprofessional.com/online/en/cottura-salamandre-elettriche-basculanti/4762-17141-electric-salamander-with-movable-radiant-plate-single-phase-2-kw.html

### 3.1 `model_number` carries a letter **O** where Baron uses a **zero** ⚠

Stored `model_number` is **`SE40/OCB`** (capital letter O). Baron's own `Modello` and
`Codice` fields, its datasheet header, and every reseller listing found all use
**`SE40/0CB`** — digit **zero**. The `/0` is Baron's series suffix meaning "no base / bench
top" (the siblings are `SE60/0CB` and `SE80/0`), so the zero is meaningful, not cosmetic.
The product `name` carries the same typo ("Baron SE40/OCB").

**Flagged, not changed**, per the standing rule that `model_number` is the unique ID and
must not be edited casually. This one is a genuine transcription error rather than a
reseller convention, so it is a real candidate for correction on approval — but it will
need a matching `name` edit and a check that nothing else keys off the current string.

### 3.2 All three dimension fields are wrong ⚠⚠

| | Length | Width | Height |
|---|---|---|---|
| Stored numeric fields | **600** | **500** | **450** |
| Stored prose `technical_specification` | 400 | 450 | 500 |
| **Official Baron datasheet** | **400** (width) | **450** (depth) | **500** (height) |

The record's own prose spec is **correct**; the three numeric fields are not. Two separate
faults are stacked:

- **`width` and `height` are transposed** (500/450 stored vs 450/500 real) — the same
  recurring cross-brand import bug already documented in the Brema, Santos and Empero passes.
- **`length` is 600, not 400.** 600 mm is the frontage of the **SE60/0CB**, the next model
  up in the same Baron series. This looks like a sibling-SKU value bleeding across, the same
  shape of error as the Santos 34-1/34-2 wattage swap and the Pradeep milk-boiler bug.

Using this catalogue's own axis convention (`length` = frontage width, `width` = depth,
`height` = height — the convention the DI7FRE415 record follows correctly), the corrected
values would be **`length: 400`, `width: 450`, `height: 500`**.

### 3.3 A depth conflict that resolves cleanly: 450 vs 548 mm

Two figures are in circulation:

- **450 mm** — Baron's own datasheet and catalogue feature table.
- **548 mm** — the Tecnoinox-branded datasheet Scots Ice serves for this model, and
  Tecnoinox's own product data.

These are **not** contradictory. The Baron datasheet's installation drawing (page 3) labels
**548** as the overall depth *including the front handle*, with the cabinet body itself at
450. **Use 450**; 548 is the clearance figure. The same drawing labels the height **496**,
corroborating the rounded 500 mm spec figure.

### 3.4 Ali Group sibling-brand overlap: this model is also a Tecnoinox ⚠

Scots Ice publishes the SE40/0CB datasheet under its **Baron** listing, but the PDF is on
**TECNOINOX SRL** letterhead (Via Torricelli 1, 33080 Porcia (PN), Italy), item number
**216041**, headed "SE CLASSIC SALAMANDER WITH MOVABLE RADIANT PLATE":
https://www.scotsice.com.au/wp-content/uploads/2025/10/SE40-0CB.pdf

Tecnoinox is another Italian professional-kitchen manufacturer, and the identical model code
appears in its own catalogue:
https://www.tecnoinox.it/en/product/salamanders/classic-en/se-en/classic-electric-salamander-with-movable-top-se-4/

So the same appliance is sold under **both** brands with the **same model code**. Baron's
own datasheet exists and is the correct source for a Baron-branded listing — but note this
matters for **images** (§7): the Tecnoinox product photo has a visibly **Tecnoinox-branded
black control panel**, whereas the Baron unit has a plain stainless panel. They are not
interchangeable on a Baron product page.

The Tecnoinox sheet is still useful for two figures Baron's own sheet omits:
**net weight 35 kg / gross weight 44 kg**, and **cooking surface 40 × 35 cm**.

### 3.5 Content confirmed and content missing

Stored `description` is a single bullet: *"Lift Electric Salamander with Movable Radiant
Plate. V 230 - kW 2"*. This is a compressed version of Baron's own product title
("ELECTRIC SALAMANDER WITH MOVABLE RADIANT PLATE - SINGLE-PHASE - 2 KW") and is **accurate**
— except "V 230" should be the official **220-240V 1N**.

Confirmed by the official datasheet but **absent from the record**:

- Series **SERIE 600**; CE approved; frequency 50-60 Hz
- **Cooking surface 400 × 350 mm**; grid height **adjustable 96–240 mm** (drawing, page 3)
- AISI 304 18/10 stainless steel, **Scotch Brite satin finish**, rounded edges
- **Incoloy armoured heating elements** housed in the movable upper deck, sliding on guides
- Removable chrome-plated steel grids and sauce/drip trays for cleaning
- Ventilation holes in the upper part for heat and smoke evacuation; rubber feet
- **Wall-mountable** via accessory **9003** (stainless steel supports, 8 cm depth, 1 pair)
- Net 35 kg / gross 44 kg (Tecnoinox source, §3.4)

---

## 4. DI7FRE415 — Single Well Electric Fryer 15 L (IMG/HOT/00189)

Official Baron datasheet (dated 18/5/2026, i.e. current):
https://storage.onpage.it/e53e638a0403228d116b06ae3cdc534edb51e255/CR1207639_en.pdf
Official catalogue page:
https://baronprofessional.com/online/en/cottura-friggitrici/5516-17442-electric-fryer-1-bowl-15-l.html

### 4.1 The product name says "Table Top". It is a **drop-in / inset** unit ⚠

Catalogue name: *"Single Well Electric Fryer 15 Ltr **Table Top** Baron DI7FRE415"*.

Baron classes DI7FRE415 in the **DROP-IN 7** series; the internal definition string is
literally `DI7FRE415 FRIGGITR.EL.15LT DROP-IN`, and the model prefix `DI7` means Drop-In,
700-series. The official product photo shows the flange rim, the below-counter body and the
protruding oil drain tap — a unit built **into** a worktop, not standing on one.

Baron does document a "top-mount installation … the modules simply rest on the worktop"
option, so the unit *can* sit on a bench, but "Table Top" as the headline descriptor is
misleading for a drop-in fryer and would set the wrong expectation for a buyer. Note the
record's own `description` already says "**drop in** model electric deep fryer" — so the
name and the description contradict each other.

For comparison, the neighbouring genuinely-table-top fryers in this catalogue
(`IMG/HOT/00042` HEF-904, `IMG/HOT/00419` EF-11L) are self-contained countertop boxes.

### 4.2 Height: stored 498 mm matches neither Baron figure ⚠

| Source | Width | Depth | Height |
|---|---|---|---|
| Stored (numeric + prose, internally consistent) | 400 | 625 | **498** |
| **Baron official datasheet** | 400 | 625 | **340** |
| **Baron catalogue feature table** | 400 mm | 625 mm | **340 mm** |
| Scots Ice distributor datasheet | 400 | 625 | **498** |

**Width 400 and depth 625 are confirmed correct** and the axis assignment in the numeric
fields is correct (no swap bug on this SKU — same per-SKU-verification lesson as Brema
CB 955A and Santos 11A).

The height is the problem. Two independent Baron sources say **340 mm**; the stored 498 mm
traces to the Scots Ice spec table:
https://www.scotsice.com.au/wp-content/uploads/2025/10/DI7FRE415.pdf

**The Scots Ice sheet contradicts itself.** Its own installation drawing (page 2, dimensions
in cm) breaks the unit down as **5,3 + 33,5 + 16,3 = 55 cm**: 53 mm of above-counter rim,
**335 mm of body**, and 163 mm of drain-tap assembly hanging below. The 335 mm body height
corroborates Baron's 340 mm. **498 appears nowhere in the drawing.**

**Recommendation: 340 mm** (Baron's official body height), with the ~**550 mm overall
including the drain-tap assembly** noted separately in the spec table, since that is the
figure an installer actually needs for under-counter clearance. 498 should be dropped.

### 4.3 Everything else on this record checks out

Confirmed correct against the official datasheet — no change needed:

- **Power 12 kW** — confirmed (`ELECTRICAL POWER 12,000 kW`). The stored "3 phase" is right;
  the precise supply is **380-415V 3N, 50-60 Hz**.
- 15 L single basin; AISI 18/10 stainless steel pan with **cool zone and foam area**
- Oil discharge tap; **safety thermostat 230 °C** against oil overheating

Confirmed but **absent from the record**:

- Baron code **CR1207639**; series **DROP-IN 7**; **IPX4**
- **Net weight 25.2 kg / gross 35.2 kg**; net volume 0.085 m³
- Packaging 850 × 440 × 1050 mm, 0.393 m³
- Two installation modes: **flush** (rim level with the worktop) and **top-mount**
- **Oil drip pan available on request**
- Accessory **CR0599830** — kit of 2 half-baskets for 10/15 L drop-in fryers

### 4.4 Two garbled lines in the stored description ⚠

- *"AISI304 stainless steel construction."* — this is a mangling of the datasheet line
  **"AISI 304 stainless steel armoured heaters positioned in the bowl for heating
  operations; can be rotated more than 90°"**. As stored it drops the most useful feature
  on the unit (heaters that swing clear for cleaning) and replaces it with a generic and
  slightly wrong material claim (the pan is AISI **18/10**, per the line above it).
- *"Oil drain valves."* — redundant with *"Oil discharge tap."* two lines earlier; the
  datasheet lists the tap once.

---

## 5. Cross-cutting notes

- **Axis convention.** This catalogue stores `length` = frontage width, `width` = depth,
  `height` = height. DI7FRE415 follows it correctly; SE40/0CB violates it on all three
  fields (§3.2). As in every previous pass, the swap had to be checked per-SKU — one of
  two SKUs here was clean, so no blanket transform is safe.
- **Sibling-SKU value bleed** (SE40's `length: 600` = the SE60's frontage) is now the fourth
  brand showing this pattern, after Santos (34-1/34-2 wattage, 33/37 blender wattage) and
  Pradeep (milk boilers). Worth treating as a known catalogue-wide failure mode rather than
  a one-off.
- **Distributor spec tables drift from the manufacturer's.** Both dimension problems in this
  pass trace to a distributor sheet rather than to Baron. Where a Baron `storage.onpage.it`
  datasheet exists, it should win.
- **Ali Group brand overlap.** SE40/0CB exists simultaneously as a Baron and a Tecnoinox
  product under the same code (§3.4). If more Baron SKUs get audited, expect the same for
  other salamanders and for anything in the SERIE 600 range — and check which brand's
  photo is being used.
- **Neither record has a `meta_description`**, and both descriptions carry Quill editor
  junk (`<span style="color: rgb(51, 51, 51);">` wrappers on the fryer, bare `<ul>` on the
  salamander) — the same cleanup applied in the Brema/Santos/HDS/Astar restructure passes.
- **Category.** The salamander sits in `Fast Food`. Baron classifies it as a salamander/grill
  in SERIE 600. Not wrong for this catalogue's taxonomy, just noted.

---

## 6. Product reference

| SKU | Catalogue name | Stored model | **Real Baron code** | Official page | Official datasheet PDF | Confidence |
|---|---|---|---|---|---|---|
| IMG/HOT/00186 | Salamander Electric Baron SE40/OCB | SE40/**O**CB | **SE40/0CB** (zero) — Codice SE40/0CB, SERIE 600 | https://baronprofessional.com/online/en/cottura-salamandre-elettriche-basculanti/4762-17141-electric-salamander-with-movable-radiant-plate-single-phase-2-kw.html | https://storage.onpage.it/4c45b5575c7c6bc3e3cb6eb06db3b1f965dcde25/SE40-0CB_en.pdf | **High** — official Baron datasheet, exact code match |
| IMG/HOT/00189 | Single Well Electric Fryer 15 Ltr Table Top Baron DI7FRE415 | DI7FRE415 | DI7FRE415 — Codice **CR1207639**, SERIE DROP-IN 7 | https://baronprofessional.com/online/en/cottura-friggitrici/5516-17442-electric-fryer-1-bowl-15-l.html | https://storage.onpage.it/e53e638a0403228d116b06ae3cdc534edb51e255/CR1207639_en.pdf | **High** — official Baron datasheet, exact code match |

Supporting / cross-check sources:

- https://www.scotsice.com.au/wp-content/uploads/2025/10/DI7FRE415.pdf
- https://www.scotsice.com.au/wp-content/uploads/2025/10/SE40-0CB.pdf (Tecnoinox letterhead — §3.4)
- https://www.tecnoinox.it/en/product/salamanders/classic-en/se-en/classic-electric-salamander-with-movable-top-se-4/
- https://hospitalityequipmentonline.com.au/baron-se40-0cb-adjustable-height-electric-salamander-grill-with-400x350x-cooking-surface
- https://www.sydneycommercialkitchens.com.au/catering-equipment/salamanders/baron-electric-salamander-se400
- https://www.aligroup.com/brand/baron/

Non-English variants of both datasheets exist at the same `storage.onpage.it` host with
`_it` / `_de` / `_es` / `_fr` / `_pl` suffixes; the hashes differ per language and are
listed on each product page.

---

## 7. Image sourcing (July 2026) — downloaded to `Downloads/baron-images/`

Baron's catalogue pages carry **exactly one product render per model** (no carousel, unlike
the Brema/barstuff situation), pulled from the PrestaShop JSON embedded in each page. Both
were downloaded at `thickbox_default` size (**1100 × 1422**) via `curl` — no auth needed,
a Referer header was sent but does not appear to be required.

**7 files total. All are real product photos/renders — no dimension drawings in this set**
(the dimensioned drawings live inside the datasheet PDFs in §6, not as standalone images).

| SKU | File | Source | Notes |
|---|---|---|---|
| IMG/HOT/00186 | `IMG-HOT-00186__SE40-0CB-official-front.jpg` (1100×1422) | https://baronprofessional.com/online/82702-thickbox_default/electric-salamander-with-movable-radiant-plate-single-phase-2-kw.jpg | **Primary candidate.** Official Baron render, plain stainless control panel, single knob (correct for the single-phase 2 kW SE40) |
| IMG/HOT/00186 | `IMG-HOT-00186__SE40-0CB-tecnoinox-216041.jpg` (1920×1419, 300 dpi) | https://www.tecnoinox.it/app/uploads/2024/06/IMG-216041_20240511_181928.jpg | **Do not use as-is.** Highest resolution of the set, but the control panel is a black **Tecnoinox-branded** fascia (§3.4) — visibly a different brand's unit |
| IMG/HOT/00186 | `IMG-HOT-00186__SE40-0CB-reseller-heo.webp` (500×500) | https://hospitalityequipmentonline.com.au/image/cache/catalog/product/SE40-500x500.webp | Reseller thumbnail, low res, backup only |
| IMG/HOT/00186 | `IMG-HOT-00186__SE40-0CB-reseller-sck.jpg` (300×268) | https://uploads.prod01.sydney.platformos.com/instances/647/assets/modules/homepage/images/baron/baronse40x0electricsalamander.jpg | Reseller thumbnail, low res, backup only |
| IMG/HOT/00186 | `IMG-HOT-00186__SE40-0CB-accessory-9003-wall-supports.jpg` (1100×1422) | https://baronprofessional.com/online/95398-thickbox_default/stainless-steel-supports-for-wall-application-depth-8-cm-1-pair.jpg | Accessory **9003** wall-mount supports — a gallery extra, not the product |
| IMG/HOT/00189 | `IMG-HOT-00189__DI7FRE415-official-front.jpg` (1100×1422) | https://baronprofessional.com/online/88839-thickbox_default/electric-fryer-1-bowl-15-l.jpg | **Primary candidate.** Official Baron render; clearly shows the drop-in flange, below-counter body and drain tap (the §4.1 "Table Top" evidence) |
| IMG/HOT/00189 | `IMG-HOT-00189__DI7FRE415-accessory-CR0599830-basket-kit.jpg` (1100×1422) | https://baronprofessional.com/online/95390-thickbox_default/kit-2-1-2-baskets-for-drop-in-fryer-lt-10-15.jpg | Accessory **CR0599830** half-basket kit — gallery extra, not the product |

Notes for whoever adopts these:

- **The two official renders are the same images already in `storage/`, but far larger.**
  The current `products/salamander-electric-baron-se40ocb-imghot00186.jpg` and
  `products/single-well-electric-fryer-15-ltr-table-top-baron-di7fre415-imghot00189.jpg`
  are the identical Baron renders at **450 × 450 / ~17 KB**. The downloads are 1100 × 1422
  and roughly 3-5× the file size — a straight quality upgrade with no risk of showing the
  wrong unit, since it is provably the same source render.
- **No angle variety exists.** Baron publishes one render per model and the resellers all
  reuse it. There is no multi-angle carousel to pull from for either SKU.
- **Only one image in the set is off-brand** — the Tecnoinox render. It is the best-quality
  file here and tempting for that reason; the black `TECNOINOX` fascia rules it out for a
  Baron listing.
- **Not yet copied into `storage/app/public/products/` or referenced in `products.json`** —
  staged in Downloads for review first, same workflow as the Brema and Santos passes.

---

## 8. Summary — what a future write pass would change

Nothing in this pass has been applied. If adopted:

**IMG/HOT/00186 (SE40/0CB)**
1. Fix `length` **600 → 400** (was the SE60 sibling's frontage) — §3.2
2. Fix the `width`/`height` transposition **500/450 → 450/500** — §3.2
3. Correct voltage **"V 230" → 220-240V 1N, 50-60 Hz** — §3.5
4. Add: SERIE 600, cooking surface 400 × 350 mm, adjustable grid height 96–240 mm,
   AISI 304 Scotch Brite, Incoloy elements on guides, removable chrome grids/drip trays,
   rubber feet, wall-mount accessory 9003, net 35 / gross 44 kg, CE — §3.5
5. Add `meta_description`; restructure to the prose + `<h3>Key Features</h3>` + table pattern
6. **Needs approval:** `model_number` `SE40/OCB` → `SE40/0CB` (letter O → zero) and the
   matching `name` fix — §3.1

**IMG/HOT/00189 (DI7FRE415)**
1. Fix `height` **498 → 340** (Baron official); note ~550 mm overall incl. drain tap — §4.2
2. Repair the garbled "AISI304 stainless steel construction" line → AISI 304 armoured
   heaters that rotate more than 90°; drop the duplicated oil-tap line — §4.4
3. Add: code CR1207639, DROP-IN 7 series, 380-415V 3N / 50-60 Hz, IPX4, net 25.2 / gross
   35.2 kg, packaging dims, flush vs top-mount installation, optional drip pan,
   accessory basket kit CR0599830 — §4.3
4. Add `meta_description`; strip the Quill `rgb(51, 51, 51)` spans; restructure to the
   standard pattern
5. **Needs a decision:** the `name` says "Table Top" for a **drop-in** unit, contradicting
   the record's own description — §4.1

**`brands.json`** — no change required; the URL is correct and live. Optionally enrich the
description with "Italian (Belluno), part of the Ali Group".
