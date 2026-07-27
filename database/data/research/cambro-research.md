# Cambro Product Research

Research notes behind a CAMBRO audit pass on `products.json` (July 2026). Covers both
CAMBRO SKUs: one Camshelving polymer shelving unit (`IMG/STO/00001`, published) and one
Camrack warewashing rack (`IMG/DWW/00107`, archived).

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema and Santos passes before a scope decision.

Headline: this is the **cleanest brand match found so far**. Both stored `model_number`
values decode cleanly against Cambro's real, published part-number grammar, and one of
them (`PR59314151`) is an **exact, current, verbatim Cambro catalogue number confirmed on
cambro.com itself** — the first SKU in any of these passes where the stored code needed no
interpretation at all. The other is off by a **single character**. The problems here are in
the *names, dimensions and descriptions*, not the codes.

---

## 1. Brand identification

**Cambro** = **Cambro Manufacturing Company**, a US foodservice-products manufacturer based
in Huntington Beach, California. Best known for insulated food-transport carriers, polymer
food-storage containers, `Camshelving®` polymer shelving and `Camrack®` warewashing racks —
the last two being exactly the two categories our catalogue carries.

`brands.json` entry is **correct and needs no change**:

- `slug: cambro`, `website_url: https://www.cambro.com` — **verified live**, serves product
  pages directly, no redirect, no domain migration. Unlike the Brema case (`bremaice.it` →
  `bremagroup.it`) there is nothing to flag here.

Official product pages used in this pass:

https://www.cambro.com/Products/shelving/camshelving-basics-plus-series/
https://www.cambro.com/Products/shelving/camshelving-basics-plus-series/basics-plus-stationary-starter-units-vented-shelves/
https://www.cambro.com/Products/shelving/camshelving-basics-plus-series/basics-plus-add-on-units-vented-shelves/
https://www.cambro.com/Products/warewashing/camrack-peg-and-tray-racks/

---

## 2. Decoding Cambro's part-number grammar

Cambro's part numbers are **fully systematic and dimension-derived**, which is what makes
this brand auditable in a way the house-brand SKUs are not. Two separate grammars apply.

### 2.1 Camshelving Basics Plus

```
CB  +  U|A  +  DD  +  LL  +  HH  +  V|S|VS  +  n  +  CCC
```

| Segment | Meaning | Our value |
|---|---|---|
| `CB` | Cam**b**ro **B**asics Plus series | `CB` |
| `U` / `A` | **U** = stationary starter **U**nit (4 posts), **A** = **A**dd-on unit (2 posts) | **`4`** ⚠ |
| `DD` | Depth, inches | `21` |
| `LL` | Length, inches | `36` |
| `HH` | Height, inches | `72` |
| `V`/`S`/`VS` | **V**ented / **S**olid / 3 vented + 1 solid | `V` |
| `n` | Number of shelves | `4` |
| `CCC` | Cambro colour code — `580` = Brushed Graphite, `480` = Speckled Gray | `580` |

Worked confirmations of the grammar on real parts:

- `CBU213672V4580` — starter, 21 × 36 × 72, vented, 4 shelves, Brushed Graphite:
  https://www.webstaurantstore.com/cambro-cbu213672v4580-camshelving-basics-plus-vented-4-shelf-stationary-starter-unit-21-x-36-x-72/214BSM3672V4.html
- `CBA183672V4580` — the same thing as an **add-on** at 18" depth:
  https://www.webstaurantstore.com/cambro-cba183672v4580-camshelving-basics-plus-vented-4-shelf-add-on-unit-18-x-36-x-72/214BAS3672V4.html
- `CBA213672V4` appears **by name in Cambro's own add-on spec table** (21" × 34 1/4" ×
  72", 4V, 39.8 lb):
  https://www.cambro.com/Products/shelving/camshelving-basics-plus-series/basics-plus-add-on-units-vented-shelves/

### 2.2 Camrack peg racks

```
PR  +  [59]  +  height  +  CCC
```

| Segment | Meaning | Our value |
|---|---|---|
| `PR` | **P**eg **R**ack | `PR` |
| `59` | 5-row × 9-row peg layout (omitted entirely on the 9×9 racks) | `59` |
| `314` / `500` | Inside height: `314` = 3 1/4" (no extender), `500` = 4 7/8" (with extender) | `314` |
| `CCC` | Colour code — `151` = **Soft Gray** | `151` |

Cambro's own published family table (all four codes confirmed on cambro.com):

| Part | Configuration | Inside height |
|---|---|---|
| `OETR314` | Open End Tray Rack | 3 1/4" |
| `PR314` | 9 × 9 rows, no extender | 3 1/4" |
| `PR500` | 9 × 9 rows, with extender | 4 7/8" |
| **`PR59314`** | **5 × 9 rows, no extender** | **3 1/4"** |
| `PR59500` | 5 × 9 rows, with extender | 4 7/8" |

---

## 3. Per-SKU findings

### 3.1 IMG/STO/00001 — "PVC Shelves 910 Cambro", `CB4213672V4580` ⚠ one-character error

**Verdict: the code is real Cambro, off by exactly one character.** `CB4213672V4580` is
`CB` + **`4`** + `213672V4580`. The `4` sits in precisely the position that Cambro's grammar
reserves for the unit-type letter `U` or `A`. There is **no `CB4` prefix anywhere in
Cambro's scheme**, and no search on the literal string returns a single hit; `CBU213672V4580`
and `CBA213672V4580` both return real products at those exact dimensions.

**Which letter?** The record's own stored `description` settles it:

> "Designed to share posts, simplifying assembly and maximizing storage space.
>  **Includes 2 posts**, post connectors, traverses and vented shelf plates."

That is Cambro's **add-on** copy, near-verbatim. Cambro's starter units ship **4 posts**;
add-on units ship **2** and borrow the neighbouring unit's posts. WebstaurantStore states it
explicitly for the add-on ("4 shelves, **2 posts** with pre-installed post connectors and
wedges, matching dovetails, and 8 traverses") and for the starter ("**4 posts**,
pre-installed post connectors and wedges, 32 dovetails, 4 vented shelves, and 8 traverses").

→ **Closest real Cambro equivalent: `CBA213672V4580`** — Camshelving Basics Plus Vented
4-Shelf Add-On Unit, 21" × 36" × 72", Brushed Graphite. `A` → `4` is a plain transcription
slip (visually adjacent in many sans-serif and OCR contexts). **Not applied** — per
[[feedback_model_number_unique_id]], `model_number` is the unique ID and stays untouched
until approved.

**But this needs a commercial decision before any code is written in, because add-on ≠
starter.** An add-on unit **cannot stand alone** — it is not a sellable freestanding
shelving unit. If what Sheffield actually stocks is a complete freestanding bay, the correct
code is `CBU213672V4580` and the *description* is the thing that's wrong (it should say 4
posts). If it really is an add-on bay, the code is `CBA213672V4580` and the *product name
and dimensions* are wrong. One of those two is true; the record as it stands is internally
consistent with neither.

**Dimensions — the width/height transposition bug, again.**

Real size, 21" D × 36" L × 72" H = **533 × 914 × 1829 mm**.

| Field | Stored | Actually is | Correct value |
|---|---|---|---|
| `length` | 540 | depth, 21" | 533 ✔ (rounded, fine) |
| `width` | **1830** | the **height**, 72" | should be **914** |
| `height` | **910** | the **length/width**, 36" | should be **1829** |

Same `width`↔`height` swap already documented in the Santos, Empero and Brema passes. The
`technical_specification` field currently contains nothing but these same three transposed
numbers as a bare `<ul>`.

⚠ **Add-on footprint caveat:** if this is confirmed as an add-on (`CBA`), its own catalogued
length is **34 1/4" (870 mm)**, not 36" — because it shares posts with the unit it bolts
onto, so it only *adds* 34.25" to a run. Cambro's own add-on spec table lists it that way.
The starter (`CBU`) is a true 36" (914 mm). Whichever way the code decision goes, the length
figure follows it.

**Other findings:**

- **It is not PVC.** Cambro Camshelving shelf plates are **polypropylene**; the weight-
  bearing posts and traverses are **steel-cored, encapsulated in thick polypropylene** —
  weldless, no exposed metal, which is the whole basis of the rust-free claim. The stored
  description already says "smooth polypropylene" and "solid steel cores", so the
  description contradicts the product *name*. "PVC Shelves" is a Sheffield house convention
  (see the sibling `IMG/STO/00007` "PVC Shelves Vented 1060 Perfect"), not a Cambro term.
- **The "910" in the name is the 36" shelf length** (914 mm), consistent with how the
  sibling OEM shelving SKUs are named ("1060", "1220"). Correct as a naming convention.
- **The stored photo does not match the code.** `products/pvc-shelves-910-cambro-imgsto00001.jpg`
  shows a **5-shelf** unit in **light grey (Speckled Gray, colour 480)**. The code specifies
  **4 shelves** (`V4`) in **Brushed Graphite (580)** — the near-black finish. Two independent
  mismatches in one image; it also appears to be an older-generation Camshelving render.
  Replacement candidates downloaded in §6.
- **Missing from the record entirely:** temperature range **-36 °F to 190 °F (-38 °C to
  88 °C)**, weight (**39.8 lb / 18.1 kg** add-on, **46.3 lb / 21.0 kg** starter — both from
  Cambro's own spec tables), shelf adjustability (4" increments), NSF listing (mentioned in
  the description but not the spec), and the **limited lifetime warranty against rust and
  corrosion**.
- **Load rating is unresolved and should not be published until confirmed.** Resellers state
  **600 lb (272 kg) per shelf**; Cambro's own add-on spec page summarises **300 lb per shelf
  / 1,350 lb per unit**; the starter page summarises **500–700 lb per shelf / 1,800 lb per
  unit**. WebstaurantStore reconciles part of it ("600 lbs per shelf when built in a straight
  line… if configured in an L- or U-shaped design, capacity drops to 300 lbs per shelf"),
  which explains the 600/300 pair but not the 700/1,800 figures. **Recommend quoting no load
  rating rather than guessing** — a wrong shelf load rating is a safety claim, not a
  marketing one. Resolve from the Basics Plus spec sheet PDF or Cambro directly.

### 3.2 IMG/DWW/00107 — "Plate Racks 64 Comp Camrack Grey", `PR59314151` ✅ exact match, wrong name

**Verdict: `PR59314151` is a genuine, current, exact Cambro part number** — confirmed on
Cambro's own site, not just resellers:

https://www.cambro.com/Products/warewashing/camrack-peg-and-tray-racks/

Cambro's own listing gives: 5 × 9 rows, no extender, inside height 3 1/4" (8.3 cm), colour
Soft Gray (151), list price USD 56.90 each, case pack 6, case weight 24.15 lb (10.95 kg).
Every character of our stored code is accounted for. **No change needed to `model_number`.**

**The product *name* is wrong, though, in two separate ways.**

1. **It is a peg rack, not a compartment rack.** Cambro's own product family is "Camrack®
   Peg and Tray Racks" — an open moulded base with upright pegs that plates lean between.
   There are no compartments; resellers list "Compartments: 1". A "Plate Rack — 64
   Compartment" describes a different kind of product entirely (compare the sibling
   `IMG/DWW/00104` "Glass Rack 25 Compartment", which genuinely is a compartment rack).
2. **Cambro does not make a 64-compartment Camrack at all.** Their compartment counts run
   8 / 9 / 10 / 16 / 20 / 25 / 30 / 36 / 49; searching for a `64S…` code returns nothing.
   So "64 Comp" cannot be salvaged by pointing it at a different Cambro part.

**Where "64" probably came from — inference, not a sourced fact.** Counting the moulded peg
array on Cambro's own high-resolution render of the full-size peg-rack base gives an **8 × 8
grid = 64 pegs**. That is almost certainly what someone recorded as "64 Comp". This was
counted off the image
(`https://cambro.widen.net/content/3iajw5cu4p/webp/PR314151_A1C0_0818_s01.webp`, downloaded
in §6) — **no Cambro or reseller document states a peg count anywhere**, so treat this as a
plausible explanation, not a verified spec. **Do not publish "64 pegs" as a spec.** The
defensible rename is something like "Camrack 5 × 9 Peg Rack — Full Size, Soft Gray".

**Full specification (record currently has none of this — it holds only name, sku, brand,
model, category, `price: null`, `quantity: 87`, `image: ""`, `status: archived`):**

| Spec | Value |
|---|---|
| Type | Camrack® Peg Rack, full size, 5 × 9 rows, no extender |
| Overall size | 19 3/4" × 19 3/4" × 4" (**502 × 502 × 102 mm**) |
| Inside / usable height | 3 1/4" (83 mm) |
| Material | Polypropylene |
| Colour | Soft Gray (Cambro colour 151) |
| Heat resistance | Up to 200 °F (93.3 °C) |
| Weight | ~4.0 lb (1.8 kg) each — derived from case weight 24.15 lb ÷ 6; a reseller lists 3.58 lb shipping weight |
| Certification | NSF listed; dishwasher safe |
| Features | Stackable (smooth top rim), ergonomic moulded handles, smooth sides, rounded corners |
| Origin | Made in USA |
| Case pack | 6 |

**Capacity** (the two peg spacings are the point of the 5 × 9 layout — one half coarse for
deep items, one half fine for flat plates):

- 5-row spacing: up to **ten 10" bowls**, deep plates, platters or plate covers
- 9-row spacing: up to **eighteen 10" plates**, twelve 12" plates, twenty-seven 7 1/2"
  plates, or nine 14" × 18" trays

**Related parts** worth knowing if a taller rack is ever needed: `PR59500151` (same 5 × 9
layout with extender, 4 7/8" inside height) and `PR59314L40151` (with a 4" extender);
`PR314151` is the 9 × 9 version, `OETR314151` the open-end tray rack.

**Pricing:** record has `price: null`. Cambro list is USD 56.90; street pricing at US
resellers ranges roughly USD 22–40. Landed Kenyan pricing is a supplier question, but there
is a real list price to anchor against, which is more than most SKUs in this catalogue have.

Sources:
https://www.cambro.com/Products/warewashing/camrack-peg-and-tray-racks/
https://www.webstaurantstore.com/cambro-pr59314l40151-soft-gray-5-x-9-camrack-peg-rack/214PR59314GY.html
https://www.ckitchen.com/p/cambro-pr59314151-camrack-5-x-9-peg-rack.html
https://www.katom.com/144-PR59314.html
https://www.dbmark.com/en/products2/washing-transporting-and-storing-crockery/universal-camracks/camrack-r-5x9-peg-rack-pr59314

---

## 4. Cross-cutting notes

- **Colour codes are meaningful and both of ours are self-consistent.** `580` = Brushed
  Graphite, `480` = Speckled Gray, `151` = Soft Gray, `184` = Beige, `119` = Sherwood Green.
  The Camrack SKU's name says "Grey" and its code ends `151` (Soft Gray) — agreement. The
  shelving SKU's code ends `580` (Brushed Graphite) but its **photo shows `480` Speckled
  Gray** — disagreement (§3.1).
- **The width/height transposition bug appears again** on the one dimensioned SKU here
  (§3.1). That is now Santos, Empero, Brema and Cambro. It is a catalogue-wide import
  problem, and every remaining dimensioned SKU should be assumed suspect until individually
  checked — never mechanically rotated, since the Santos pass proved some records are
  already correct.
- **Model-code quality is unusually high for this catalogue.** Across two SKUs the total
  divergence from Cambro's real numbering is **one character**. Contrast Santos (an invented
  "A" suffix on all 9 codes) and the house `JW-`/`PR` codes. Where a brand publishes a
  systematic dimension-derived grammar like Cambro's, the stored codes can be *validated*
  rather than merely looked up.
- **Both records under-describe a well-documented brand.** The peg rack is completely empty
  and archived despite 87 units in stock and a published US list price; the shelving unit
  has a description that contradicts its own product name (polypropylene vs "PVC") and its
  own image (4-shelf graphite vs 5-shelf speckled grey).

---

## 5. Product reference

| SKU | Catalogue name | Stored model | Real Cambro part | Official page | Confidence |
|---|---|---|---|---|---|
| IMG/STO/00001 | PVC Shelves 910 Cambro | `CB4213672V4580` | **`CBA213672V4580`** (add-on, per the record's own "2 posts" copy) — or `CBU213672V4580` if it is really a freestanding starter | https://www.cambro.com/Products/shelving/camshelving-basics-plus-series/basics-plus-add-on-units-vented-shelves/ | **High** on the size/series/colour (21×36×72 vented 4-shelf Brushed Graphite is unambiguous); **Medium** on add-on vs starter — needs a supplier answer |
| IMG/DWW/00107 | Plate Racks 64 Comp Camrack Grey | `PR59314151` | **`PR59314151`** — exact, unchanged | https://www.cambro.com/Products/warewashing/camrack-peg-and-tray-racks/ | **Very high** — verbatim match on Cambro's own site; only the catalogue *name* is wrong |

Supporting reseller sources:
https://www.webstaurantstore.com/cambro-cbu213672v4580-camshelving-basics-plus-vented-4-shelf-stationary-starter-unit-21-x-36-x-72/214BSM3672V4.html
https://www.webstaurantstore.com/cambro-cba183672v4580-camshelving-basics-plus-vented-4-shelf-add-on-unit-18-x-36-x-72/214BAS3672V4.html
https://www.katom.com/144-CBU183672580.html
https://www.restaurantsupply.com/cambro-cbu213672v4580-brushed-graphite-basic-72-inch-x-18-inch-x-60-inch-plastic-vented-stationary-shelving-unit

---

## 6. Image sourcing (July 2026) — downloaded to `Downloads/cambro-images/`

**15 files** (7 shelving, 8 rack). Cambro serves its product renders from a Widen DAM
(`cambro.widen.net/content/<hash>/webp/<PARTNUMBER>_<viewcode>.webp`) — the filenames carry
the part number, which makes it easy to tell which size/variant a render actually depicts.
Downloaded straight via `curl`, no auth or referer needed. Naming follows the Brema/Santos
convention (`<SKU-with-dashes>__<descriptor>.<ext>`).

### IMG/STO/00001 — Camshelving Basics Plus

| File | Source | Note |
|---|---|---|
| `IMG-STO-00001__CBU213672V4580-webstaurant.jpg` | https://cdnimg.webstaurantstore.com/images/products/large/378104/3027656.jpg | **Best candidate.** The only render found of the **exact** 21 × 36 × 72 vented 4-shelf Brushed Graphite unit. Clean white background. |
| `IMG-STO-00001__CBA183672V4580-addon-webstaurant.jpg` | https://cdnimg.webstaurantstore.com/images/products/large/378064/3019652.jpg | The **add-on** equivalent — use this one instead if §3.1 resolves to `CBA` |
| `IMG-STO-00001__CBU-basics-plus-starter-render.webp` | https://cambro.widen.net/content/ugkb8vixxz/webp/CBU183064V4580_A1R0_0117_s02.webp | Official Cambro render, but of `CBU183064` (18 × 30 × 64) — same series/finish, **different size** |
| `IMG-STO-00001__CBU-basics-plus-starter-render2.webp` | https://cambro.widen.net/content/mpafeknh5o/webp/CBU183064V4580_A1R0_0918_S01.webp | as above |
| `IMG-STO-00001__CBA-basics-plus-addon-render.webp` | https://cambro.widen.net/content/gchlzsxil2/webp/CBA183064V4580_A1R0_0918_S01.webp | Official add-on render, `CBA183064` |
| `IMG-STO-00001__CBA-basics-plus-addon-lifestyle.webp` | https://cambro.widen.net/content/fmrcbid1lz/webp/CBA183064V4580_A1LK_0616_s02.webp | In-kitchen lifestyle shot |
| `IMG-STO-00001__CBA-basics-plus-addon-detail.webp` | https://cambro.widen.net/content/e4duvs5cdx/webp/CBA183064V4580_B1RK_1013_s05.webp | Detail/loaded shot |

⚠ The official `cambro.widen.net` renders on the Basics Plus category pages are all of the
**18 × 30 × 64** unit — Cambro uses one representative render per series rather than one per
size. They are correct for *series and finish* (Brushed Graphite, vented shelves) but not
for our size or shelf count. The two WebstaurantStore files are the size-accurate ones.

⚠ The **currently attached** storefront image
(`storage/app/public/products/pvc-shelves-910-cambro-imgsto00001.jpg`) is wrong on two
counts — 5 shelves instead of 4, and Speckled Gray (480) instead of Brushed Graphite (580).
Replacing it is the single highest-value change available on this SKU.

### IMG/DWW/00107 — Camrack 5 × 9 Peg Rack

| File | Source | Note |
|---|---|---|
| `IMG-DWW-00107__PR59314151-ckitchen-1.webp` | https://cdn.ckitchen.com/pmidimages/cambro-pr59314151-camrack-5-x-9-peg-rack-20221214152256266.webp | **Correct part**, but small (≈11 KB) |
| `IMG-DWW-00107__PR59314151-ckitchen-2.webp` | https://cdn.ckitchen.com/pmidimages/cambro-pr59314151-camrack-5-x-9-peg-rack-20250621050851199.webp | **Correct part**, 3/4 view, still small (≈16 KB) |
| `IMG-DWW-00107__PR59314-webstaurant-1.jpg` | https://cdnimg.webstaurantstore.com/images/products/large/59571/2672179.jpg | **Best storefront candidate** — in-use shot, plates being loaded, 600 × 600 |
| `IMG-DWW-00107__PR59314-webstaurant-2.jpg` | https://cdnimg.webstaurantstore.com/images/products/large/59571/3002600.jpg | Second in-use angle |
| `IMG-DWW-00107__PR314151-official-front.webp` | https://cambro.widen.net/content/ancrloehtx/webp/PR314151_A1R0_0818_S03.webp | Official Cambro, but the **9 × 9** `PR314` — see caution below |
| `IMG-DWW-00107__PR314151-official-closeup.webp` | https://cambro.widen.net/content/3iajw5cu4p/webp/PR314151_A1C0_0818_s01.webp | Official, high-res 1200px; this is the image the 8 × 8 peg count in §3.2 was read off |
| `IMG-DWW-00107__PR314151-official-loaded.webp` | https://cambro.widen.net/content/n0gtizj8gw/webp/PR314151_A1RL_1016_S02.webp | Official, loaded with plates |
| `IMG-DWW-00107__PR314151-official-lifestyle.webp` | https://cambro.widen.net/content/fmonxrqjvq/webp/PR314151_A1LK_0818_s04.webp | Official lifestyle |

⚠ **Peg-layout caution:** Cambro's own Peg and Tray Racks page only carries renders of
`PR314151`, the **9 × 9** rack — our SKU is the **5 × 9** `PR59314151`. The two are the same
moulding family, same tray, same colour, but the peg spacing visibly differs on one half.
The two ckitchen files and the two WebstaurantStore files are the ones actually showing
`PR59314`; the four official Cambro files are the higher-resolution but **wrong-configuration**
option. Prefer the WebstaurantStore in-use shots for the storefront.

Nothing has been copied into `storage/app/public/products/` or referenced in
`products.json` — staged in Downloads for review, same as the Brema and Santos sets. Note
`IMG/DWW/00107` currently has `image: ""` and `status: archived`, so its photo is ready
whenever that record is published.

---

## 7. Recommended next steps (none applied)

Ordered by value, all requiring approval:

1. **Answer the add-on-vs-starter question with the supplier** for `IMG/STO/00001`. Every
   other fix on that SKU (code, length, post count, price sanity) hangs off it.
2. **Fix the width/height transposition** — `width: 1830` / `height: 910` → `width: 914` /
   `height: 1829` (or 870 if add-on). Safe and independent of #1's outcome for the height.
3. **Replace the shelving photo** — the attached image is the wrong shelf count *and* the
   wrong colour (§6).
4. **Build out `IMG/DWW/00107` from scratch** — it is completely empty despite 87 units in
   stock, an exact verified part number, a full public spec, and a USD list price. Rename to
   drop the false "64 Comp" and the false "Plate Rack" framing.
5. **Rewrite both descriptions to the Skymsen prose + `<h3>Key Features</h3>` + `<table>`
   pattern**, add `meta_description` to both (neither has one), and split
   `short_description` per [[project_description_field_split]].
6. **Leave the load rating out** until the 300 / 600 / 700 lb conflict is resolved from
   Cambro's Basics Plus spec sheet (§3.1).
7. **Do not change `model_number` on `IMG/DWW/00107`** — it is already exactly right.
