# Cambro Product Research

Supersedes `old/cambro-research.md`.

Covers both CAMBRO SKUs: `IMG/STO/00001` (Camshelving Basics Plus, stored code
`CB4213672V4580`) and `IMG/DWW/00107` (`PR59314151` Camrack peg rack).

**Nothing has been applied to `products.json` or `brands.json`.** Staged imagery and per-file
ledger: `Desktop\ecommerce\products resorce final\cambro\` (`_sourced.json`, `_FINDINGS.md`).

⚠ **This file REVERSES the code recommendation made in `old/cambro-research.md`.** The earlier
proposal of `CBA213672V4580` rested on an inference that does not survive checking. See §2.

---

## 1. Brand identification — unchanged

**Cambro Manufacturing Company**, Huntington Beach, California. `brands.json` entry
(`slug: cambro`, `website_url: https://www.cambro.com`) is **correct, live, no change needed.**
No bot-gating; every page and document served cleanly.

Official sources used:

https://www.cambro.com/Products/shelving/camshelving-basics-plus-series/
https://www.cambro.com/Products/shelving/camshelving-basics-plus-series/basics-plus-stationary-starter-units-vented-shelves/
https://www.cambro.com/Products/shelving/camshelving-basics-plus-series/basics-plus-add-on-units-vented-shelves/
https://www.cambro.com/Products/warewashing/camrack-peg-and-tray-racks/
https://cambro.widen.net/content/hayq3fk2gp/pdf/Camshelving-Spec-Book---North-America.pdf

---

## 2. ⭐⭐ `CB4213672V4580` — and the add-on vs starter question

Both were held back previously. Both can now be answered from **Cambro's own 96-page spec book**.

### 2.1 The evidence

Camshelving Spec Book (North America), **page 45** — 72"-height V4 vented tables, Brushed
Graphite (580). Both candidates are listed in adjacent columns:

| Type | 21" depth, 72" height, 4 vented shelves |
|---|---|
| **Starter** | **`CBU213672V4`** — length **36"** (914 mm), **44.49 lb** |
| **Add-On** | **`CBA213672V4`** — length **34¼"** (870 mm), **39.5 lb** |

And Cambro's own "includes" wording — note it counts **post KITS**, not posts:

> "**Starter units include 2 factory assembled post kits**, 8 or 10 traverses, traverse dovetails
> and shelf plates. **Add-On units include 1 factory assembled post kit**, 8 or 10 traverses,
> traverse dovetails and shelf plates. Units ship complete in 1 box."

### 2.2 ⚠ Why the previous recommendation does not hold

`old/cambro-research.md` concluded **add-on** because our record says *"Designed to share posts,
simplifying assembly and maximizing storage space"* and called that "Cambro's add-on copy,
near-verbatim".

**That sentence appears on BOTH the starter page and the add-on page.** It is series-level
marketing copy for Basics Plus as a whole — verified by extracting it from both pages this pass.
It carries **no** information about unit type, and the inference built on it must be discarded.

### 2.3 What the evidence actually says — three pointers, all to STARTER

| Signal | Value | Points to |
|---|---|---|
| Stored numeric length | **910 mm** ≈ **36"** | **CBU** (add-on is 34¼" = 870 mm) |
| Product **name** — "PVC Shelves **910** Cambro" | **910** | **CBU** (an add-on would be "870") |
| Currently-attached storefront photo | 4 vented shelves, **4 full corner posts, freestanding** | **CBU** (add-on has posts at one end only) |
| Description "Includes **2** posts…" | see below | **CBU**, on the better reading |

⚠ **"Includes 2 posts" is best read as a truncation of Cambro's STARTER sentence:**

> Cambro (starter): "include **2** factory assembled post **kits**, 8 or 10 **traverses**, traverse **dovetails** and **shelf plates**"
> our record: "Includes **2** posts, post connectors, **traverses** and **vented shelf plates**"

The structure tracks the starter line — the number **2**, then traverses, then
connectors/dovetails, then shelf plates. Cambro's **add-on** sentence begins "**1** factory
assembled post kit", which would have produced "includes 1 post kit". Dropping "kits" turns the
starter line into "2 posts"; nothing plausible turns the add-on line into it.

### 2.4 ⭐ Recommendation — RECOMMENDATION ONLY, nothing applied

> **`CBU213672V4580`** — Camshelving Basics Plus, Vented, 4-Shelf, **Stationary Starter Unit**,
> 21" × 36" × 72", Brushed Graphite.

`CB` + **`U`** + `213672` + `V4` + `580`. The stored `CB**4**213672V4580` has a **`4`** in exactly
the position Cambro's grammar reserves for the unit-type letter. The decisive point is that **`4`
is not a valid value there at all** — there is no `CB4` prefix anywhere in Cambro's scheme.

⚠ **`model_number` is the unique ID and has NOT been touched, inline or otherwise.** This needs
approval plus ideally one supplier question:

> *"Is what we stock a complete freestanding bay, or an extension that bolts onto an existing one?"*

If the answer is "extension", the code is `CBA213672V4580` **and the length must change to
870 mm**, because an add-on only adds 34¼" to a run. **Both candidate images are staged**, so
either answer is ready.

### 2.5 Cambro's part-number grammar (confirmed against the spec book)

```
CB  +  U|A  +  DD  +  LL  +  HH  +  V|S|VS  +  n  +  CCC
```

`U` = stationary starter, `A` = add-on · `DD` depth (18/21/24) · `LL` length · `HH` height
(64/72/84) · `V`/`S`/`VS` vented/solid/mixed · `n` shelf count · `CCC` colour
(`580` Brushed Graphite, `480` Speckled Gray, `151` Soft Gray).

---

## 3. `PR59314151` — exact, unchanged, and now visually verified

**A genuine, current, exact Cambro part number, confirmed on cambro.com. No `model_number`
change.** Grammar: `PR` (peg rack) + `59` (5 × 9 rows) + `314` (3¼" inside height, no extender)
+ `151` (Soft Gray).

⚠ **The 5 × 9 vs 9 × 9 distinction was verified by eye this pass, not assumed.** Rendered side by
side the two mouldings are unmistakable:

- **`PR59314151` (ours)** — pegs in **two different spacings**, a coarse half and a fine half.
- **`PR314151`** — a **uniformly dense** peg grid across the whole base, many more pegs.

All four staged `IMG-DWW-00107__*` files are the 5 × 9. The two `PR314151` files are quarantined
in `_brand-reference/` and **must not be attached to the SKU**.

**Full specification** (the record currently holds almost none of this): Camrack peg rack, full
size, 5 × 9, no extender · overall 19¾" × 19¾" × 4" (**502 × 502 × 102 mm**) · inside height 3¼"
(83 mm) · polypropylene · Soft Gray (151) · heat resistant to 200 °F (93.3 °C) · ~4.0 lb
(1.8 kg) · NSF listed, dishwasher safe · stackable, moulded handles · Made in USA · case pack 6.

**Capacity** — the two spacings are the point of the 5 × 9 layout: the 5-row half takes up to ten
10" bowls, deep plates or platters; the 9-row half up to eighteen 10" plates, twelve 12" plates,
twenty-seven 7½" plates, or nine 14" × 18" trays.

⚠ **"64 Comp" in the product name is wrong and must not be published as a spec.** It is a peg
rack, not a compartment rack (resellers list "Compartments: 1"), and Cambro makes no
64-compartment Camrack. The earlier theory — that someone counted an 8 × 8 = 64 peg array — was
counted off **`PR314151`, the wrong rack**, which weakens it further. **No Cambro or reseller
document states a peg count anywhere.** Recommended rename: *"Camrack 5 × 9 Peg Rack — Full Size,
Soft Gray"*.

⚠ Zoomed 6× into the rack rim: the moulded text reads only **"CAMBRO"**, not a part number. So
`code_proven` on the two official files rests on **Cambro's own DAM filenames**
(`PR59314151_A1LL_0119_S04`) — strong provenance, but not proof off the product itself.

---

## 4. SAP audit

| SKU | SAP W/D/H | Remark | Verdict |
|---|---|---|---|
| IMG/STO/00001 | **540 / 910 / 1830** | "…Includes 2 posts…" (no dimensions) | ✅ **SAP correct, W/D/H order** — 540 = 21" depth, 910 = 36" length, 1830 = 72" height |
| IMG/DWW/00107 | *(blank)* | "Compartment size 45X45X72" | ⚠ fields MISSING; remark garbled |

**Column order established from SAP itself: `W / D / H`** — and unusually **SAP's values are
right.** It is `products.json` that is wrong: it stores `910 / 540 / 1830` as length/width/height,
i.e. **width 1830 (really the height) and height 910 (really the length)** — the familiar
transposition. Correct: `length` 533–540, `width` 914, `height` 1829.

⚠ SAP's Camrack remark **"Compartment size 45X45X72"** is not a compartment size — the rack is
502 × 502 × 102 mm with an 83 mm inside height. Treat the string as unreliable, and the blank
dimension fields as **MISSING, not zero**.

---

## 5. Resolution — ceilings tested, not assumed

**WebstaurantStore's undocumented `xxl` rendition is genuine**, re-verified this pass because a
sibling brand in the same batch (Waring/Katom) turned out to be serving pure upscales:

| Rendition | Returns |
|---|---|
| `large` | 600 × 600 |
| `extra_large` | 1000 × 1000 |
| **`xxl`** | **2000 × 2000** |
| `original`, `zoom`, `huge`, `xl` | 404 |

High-frequency (Laplacian) energy check: `xxl` at 2000 px scores **4.02**, versus **1.99** for
`extra_large` upscaled to 2000 px — roughly **twice** the real detail, so it is a true master.
It is also **native-capped, not padded**: `…/3002600.jpg` returns 1050 × 1050 from `xxl` while
its siblings return 2000.

**Cambro's own Widen DAM:** swap the format segment for **`original`** —
`cambro.widen.net/content/<hash>/original/<FILE>.webp` — and the DAM 303-redirects to a signed
`cf-store.widencdn.net` URL with the native master. The sized `webp`/`jpeg`/`png` renditions cap
at 2048 regardless of any `?w=`. This produced the **4104 × 2988** Camrack hero, the largest file
in this four-brand pass.

⚠ **The same trick applies to documents.** The spec book's on-page link
(`/view/pdf/hayq3fk2gp/…?t.download=true`) returns a **24 KB HTML viewer**, not the PDF.
`/content/hayq3fk2gp/pdf/…` returns the real **13.7 MB** file (96 pages, full text layer);
`/content/hayq3fk2gp/original/…` returns 36.5 MB. Anyone taking the on-page link at face value
would stage an HTML file with a `.pdf` extension.

## 6. Shared-photo check — negative, which is the point

Plastic dish racks are the textbook shared-photo case, so the full protocol was run over all 11
staged files **plus both currently-attached storefront images**: MD5 grouping → 16×16 ahash
shortlist at ≤40 bits → per-pixel RMS on 256×256 greyscale.

- **No MD5 duplicates.**
- **No pair scored below RMS 41** (closest 41.49 and 42.56 — similar compositions of genuinely
  different objects). **Nothing is a shared photo.**
- Specifically, **`CBU213672V4580` and `CBA183672V4580` are different photographs** (ahash 23,
  RMS 41.49) — WebstaurantStore serves distinct renders for starter and add-on, so the
  "byte-identical under two part-number filenames" trap **is not present here**.

⚠ The three official Cambro Camshelving renders **are** range assets — all of `CBA183064V4580`,
the 18 × 30 × 64 unit — and are named `CB-RANGE-` accordingly. A sweep of all three Basics Plus
pages confirms **no `CBU213672` or `CBA213672` render exists anywhere on cambro.com**; Cambro
publishes one representative render per series, not per size. The size-accurate options are the
two WebstaurantStore files, which are also the highest-resolution ones — no trade-off to make.

## 7. Two open items

- ⚠ **Colour disagreement.** The code ends `580` = **Brushed Graphite** (near-black), but the
  attached storefront image shows a **light/mid grey** unit (Speckled Gray, 480). Shelf count (4
  vented) and configuration (freestanding, 4 posts) are right; the finish is not. Either the
  colour digits or the photo is wrong. Worth a supplier question alongside §2.4.
- ⚠ **Load rating — still do not publish.** The 300 / 600 / 700 lb-per-shelf conflict is
  unresolved, and the live starter page adds a fourth framing (*"…700 lbs (317.5 kg) per shelf up
  to 48" (1220 mm)"*), i.e. the rating depends on **shelf length** as well as on whether the run
  is straight or L/U-shaped. A wrong shelf load rating is a safety claim, not a marketing one.

⚠ Also unchanged: **it is not PVC.** Camshelving shelf plates are **polypropylene** over
steel-cored, encapsulated posts and traverses. "PVC Shelves" is a Sheffield house naming
convention, and the record's own description already says "polypropylene" — so the name
contradicts the description.

## 8. Product reference

| SKU | Stored model | Real Cambro part | Official page | Confidence |
|---|---|---|---|---|
| IMG/STO/00001 | `CB4213672V4580` | **`CBU213672V4580`** (starter) — or `CBA213672V4580` if the supplier confirms an add-on, in which case the length becomes 870 mm | https://www.cambro.com/Products/shelving/camshelving-basics-plus-series/basics-plus-stationary-starter-units-vented-shelves/ | **High** on size/series/colour; **Medium-High** on starter vs add-on |
| IMG/DWW/00107 | `PR59314151` | **`PR59314151`** — exact, unchanged | https://www.cambro.com/Products/warewashing/camrack-peg-and-tray-racks/ | **Very high** |

## 9. Recommended actions (nothing applied)

1. 🔴 **Settle starter vs add-on with the supplier**, then apply the code from §2.4. Every other
   fix on `IMG/STO/00001` hangs off it.
2. 🟠 **Fix the width/height transposition** — `width: 1830` / `height: 910` → `width: 914` /
   `height: 1829` (or 870 if add-on). Safe and independent of #1 for the height.
3. 🟠 **Build out `IMG/DWW/00107` from scratch** using §3 — it has 82 units in stock, an exact
   verified part number and a full public spec. Drop the false "64 Comp" and "Plate Rack" framing.
4. 🟡 Replace the shelving photo if the colour question resolves against it (§7).
5. 🟡 Rewrite both descriptions to the house prose + `<h3>Key Features</h3>` + `<table>` pattern;
   add `meta_description` to both; correct "PVC" in the shelving name.
6. ⚪ **Publish no load rating** until it is read off the spec book for the exact part (§7).
7. ⚪ **No `model_number` change on `IMG/DWW/00107`** — it is already exactly right.
