# Blodgett Product Research

Research notes behind a BLODGETT audit pass on `products.json` (July 2026). Covers the
single BLODGETT SKU in the catalogue: `IMG/OVE/00107`, "Oven Convection Electric Blodgett
CTB SGL", `model_number: CTB SGL`.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema and Santos passes before a scope decision.

One SKU, so this is a deep dive rather than a survey. Headline: the model **is real and
still in Blodgett's current catalogue under essentially the same code** (no Brema-style
naming drift), but the record has **one wrong dimension, a US-only electrical
configuration that cannot be wired in Kenya as written, copy-paste provenance from a US
reseller (typo included), and a 9 KB thumbnail as its product image**.

---

## 1. Brand identification

**Blodgett** = **The Blodgett Oven Company** (Blodgett Corporation), founded **1848** in
Burlington, Vermont by Gardner S. Blodgett. Today headquartered at **42 Allen Martin Drive,
Essex Junction, VT 05452, USA** (the address printed on every current spec sheet) and part
of **The Middleby Corporation** — the Blodgett site footer carries the Middleby, BKI,
Marsal and ART sister-brand logos.

`brands.json` entry is **correct and needs no change**:

- `slug: blodgett` ✓
- `website_url: https://www.blodgett.com` ✓ — **verified live**, resolves HTTP 200, and is
  the site that actually hosts this product's model page and spec sheet. Unlike Brema's
  `bremaice.it` (a redirect to a newer corporate domain), this is the live primary domain.
- `description` says "Founded in 1848" ✓ — matches Blodgett's own history.
- Only optional addition: the record doesn't mention the Middleby ownership. Cosmetic; not
  a correction.

---

## 2. Model identification — confirmed, no naming drift

This was the main thing to check (the Brema pass found `CB 249A HC` had fallen off the
manufacturer's current site entirely). **That did not happen here.** `CTB SGL` is current.

| Our value | Blodgett's own value | Verdict |
|---|---|---|
| `model_number: CTB SGL` | **`CTB-SGL`** | **Exact match**, hyphen only |
| Name "Oven Convection Electric Blodgett CTB SGL" | "CTB Single Half Size Premium Electric Convection Oven" | Same product |

Blodgett's own site states verbatim: *"CTB-SGL is a single oven and includes 4" stainless
steel legs"*, on
https://www.blodgett.com/model/blodgett-ctb-single-half-size-premium-electric-convection-oven/

The series is still listed and actively marketed as **CTB/CTBR**:
https://www.blodgett.com/product/ctb-ctbr-series/

### 2.1 CTBR is a sibling, not a successor

Worth stating plainly because it's the kind of thing that gets substituted by mistake. The
official spec sheet says:

> *"CTBR model follows same specifications as CTB, only with door opening on the right side
> and controls on left side."*

So **CTBR = right-hand-hinged door**, mechanically identical otherwise. It is **not** a
newer generation and **not** a rename of CTB. Our record explicitly says *"Hinged on left"*,
which is the CTB — correct as stored. (This matters for images too — see §8.)

### 2.2 "CTB SGL" alone is under-specified

Blodgett does **not** treat "CTB-SGL" as one SKU — it is a family of at least eight
purchasable configurations differing by kW and electrical supply, each with its own model
page. Examples found on blodgett.com:

- https://www.blodgett.com/model/blodgett-ctb-single-half-size-premium-electric-convection-oven/ — 5.6 kW, 208 V, 1 PH
- https://www.blodgett.com/model/ctb-single-half-size-premium-electric-convection-oven-5-6kw-208v-3ph/ — 5.6 kW, 208 V, 3 PH
- https://www.blodgett.com/model/ctb-single-half-size-premium-electric-convection-oven-5-6kw-220-240v-1ph/ — 5.6 kW, 220/240 V, 1 PH
- https://www.blodgett.com/model/ctb-single-half-size-premium-electric-convection-oven-8kw-208v-1ph/ — 8 kW, 208 V, 1 PH

Plus separate "CTB BASE" (oven section only, no legs — the bottom half of a stacked pair)
and "CTB Additional Section" model pages, e.g.
https://www.blodgett.com/model/ctb-additional-section-half-size-premium-electric-convection-oven-8kw-220-240-3ph/

Our record's stored electrical string (`208v/60/1-ph, 5.6 kW, 27.0 amps`) pins it to the
**first** of those — which is the problem described in §5.

---

## 3. Where to look

| Resource | URL | Value |
|---|---|---|
| Official spec sheet (PDF, gold standard) | https://www.blodgett.com/custom/PDF/specs/CTB-spec.pdf | Dimensions, interior size, full power-supply table, weight, crate size, construction, options. P/N 35020 Rev T (6/22). **Primary source for every number in this file.** |
| Official model page (our exact config) | https://www.blodgett.com/model/blodgett-ctb-single-half-size-premium-electric-convection-oven/ | Confirms `CTB-SGL` code and that 4" legs are included |
| Official series page | https://www.blodgett.com/product/ctb-ctbr-series/ | Feature copy, ENERGY STAR, control options, steam-pan capacity |
| Reseller our record was copied from | https://www.ckitchen.com/p/blodgett-ctb-sgl-convection-oven-3.html | See §4 — provenance, and the source of the one wrong dimension |
| Independent cross-check A | https://www.webstaurantstore.com/blodgett-ctb-premium-series-single-deck-half-size-electric-convection-oven-with-left-hinged-door-220-240v-3-phase-5-6-kw/195CTB1E.html | Overall height incl. legs |
| Independent cross-check B | https://www.katom.com/015-CTBSINGLE2083.html | Cabinet height excl. legs, depth incl. handle, product photos |

### Traps

1. **The spec PDF does not extract via `WebFetch`** — same trap as the Santos leaflets. The
   `Read` tool renders it correctly, including the dimension elevations on page 2. Use that.
2. **`blodgett.com/product/ctb-ctbr-series/` loads its model/spec/manual table client-side.**
   Curling the HTML gives you the feature copy and images but an empty models table; the
   per-config model pages have to be found via search instead.
3. **Several resellers 403 on `WebFetch`** (katom, burkett, gofoodservice, culinarydepot).
   `curl` with a normal browser User-Agent works for katom and ckitchen; burkett and
   culinarydepot 403 even then.
4. **Resellers disagree about which axis is which** — and one of them is simply wrong. See §4.

---

## 4. The dimensions — one field is wrong, and we can name the exact source of the error

### 4.1 What the official spec sheet actually says

From https://www.blodgett.com/custom/PDF/specs/CTB-spec.pdf :

- **Floor space: 30-1/4" (768 mm) W × 25-1/8" (638 mm) D** — that is the *only* explicit
  W/D statement on the sheet.
- **Interior: 15-1/4" (387 mm) W × 20" (508 mm) H × 21" (533 mm) D**
- Approx. weight, single: **295 lb (134 kg)**
- Crate: 36" (914 mm) L × 32" (813 mm) W × 35" (889 mm) H
- Minimum entry clearance: uncrated 25-1/16" (636 mm), crated 30-1/4" (775 mm)

The sheet gives **no overall height figure in text** — height has to be read off the page-2
elevation drawings. Working it out from the drawings:

- **Double** unit: stand top at 19" (483 mm), overall top at 69-1/8" (1756 mm) →
  (1756 − 483) / 2 = **636 mm per oven section**.
- **Single** unit: oven bottom at 25-1/8" (638 mm), overall top at 50-3/16" (1275 mm) →
  1275 − 638 = **637 mm** for the one section. Same answer.
- The "minimum entry clearance, uncrated **25-1/16" (636 mm)**" line independently confirms
  the same figure — that's the cabinet passing through a doorway on its shortest axis.

So:

- **Oven cabinet height, no legs: 636–638 mm (25-1/16" – 25-1/8")**
- **Overall height on the standard 4" (102 mm) legs the CTB-SGL ships with: ≈ 738 mm (29-1/16")**
- **Overall depth including the door handle: ≈ 733 mm (28-7/8")** — the top view shows the
  handle projecting 3-1/4" (83 mm) beyond the 638 mm body.

Independent confirmation of both readings:

- WebstaurantStore lists **30-1/4" W × 25-1/8" D × 29-1/16" H** (body depth, height *with*
  legs): https://www.webstaurantstore.com/blodgett-ctb-premium-series-single-deck-half-size-electric-convection-oven-with-left-hinged-door-220-240v-3-phase-5-6-kw/195CTB1E.html
- KaTom lists **30-1/4" W × 28-7/8" D × 25-1/16" H** (depth *with* handle, height *without*
  legs): https://www.katom.com/015-CTBSINGLE2083.html

Different conventions, but both are internally consistent with the drawing. Neither
supports our stored height.

### 4.2 What we store, and how the storefront renders it

Stored on `IMG/OVE/00107`: `length: 638`, `width: 768`, `height: 720`.

Both storefront views render the three fields in the order **`width`, `length`, `height`**
and label that "Dimensions (W × D × H)":

- `resources/views/pages/storefront/product.blade.php` (~line 818) — `width`, `length`, `height`
- `resources/views/pages/storefront/compare.blade.php` (~line 86) — `width`, `depth ?? length`,
  `height`, labelled `'Dimensions (W × D × H)'` at ~line 221. (There is no `depth` column on
  the `products` table, so the `?? length` fallback always fires.)

So this SKU currently displays as **768 × 638 × 720 mm (W × D × H)**:

| Axis | Displayed | Official | Verdict |
|---|---|---|---|
| Width | 768 | 768 mm (30-1/4") | ✅ correct |
| Depth | 638 | 638 mm (25-1/8") body / 733 mm with handle | ✅ correct (body) |
| Height | 720 | **738 mm** with legs, or **636 mm** cabinet only | ❌ **wrong — matches neither** |

**No width/height axis-swap bug on this SKU** (unlike Brema's CB-416A/CB-640A and six of
the nine Santos SKUs). Only the height value is wrong.

### 4.3 …but there *is* a latent field-convention inconsistency worth flagging

The numeric fields on this record are ordered `length = depth`, `width = width`. That is the
**opposite** of how its sibling Ovens records are populated — e.g. Tecnodom `FEM06NEMIDVH2O`
stores `length: 840, width: 910, height: 830` and its own spec table calls that
"840 × 910 × 830 mm (W × D × H)", i.e. `length = width, width = depth`. HDS `HDSGCO-1` does
the same. The Brema and Santos passes both assumed `length = width` too.

Since the renderer emits `width` first, **the Blodgett record happens to display correctly
while the Tecnodom/HDS records display W and D transposed.** This SKU therefore needs no
axis fix — but the catalogue-wide convention is genuinely ambiguous and is worth settling
separately (it is the same underlying problem the Santos pass logged in its §5).

### 4.4 Where the wrong 720 mm came from

Traceable exactly. https://www.ckitchen.com/p/blodgett-ctb-sgl-convection-oven-3.html
publishes, in its structured product data:

```
Width (in) 30.25    Depth (in) 25.13    Height (in) 28.25    Weight 295 lbs
```

30.25" = 768 mm ✓, 25.13" = 638 mm ✓, **28.25" = 717.6 mm → rounded to 720** in our record.

ckitchen's 28.25" is the outlier — it does not match the manufacturer's drawing under either
convention. The likeliest explanation is a misread of the **28-1/8" (714 mm)** callout on
the single-unit elevation. That callout is not an overall height: on the double-unit drawing
the same feature appears twice at 22" (559 mm) and 47-1/16" (1195 mm), each exactly 76 mm
above its own oven section's bottom edge, so it is a *height-to-a-feature* dimension (bottom
of door / control panel), not a cabinet height.

**Recommendation:** set `height` to **738** (overall, on the 4" legs that ship with the
CTB-SGL) and state both the 636 mm cabinet-only height and the 733 mm handle-inclusive depth
in the spec table so neither reseller convention can mislead a buyer measuring a doorway.

---

## 5. Electrical — the most important finding for a Kenyan catalogue ⚠

Our record stores, in `technical_specification`:

> Blodgett CTB SGL Deck Electric Convection Oven with Contols, **208v/60/1-ph, 5.6 kW, 27.0 amps**, direct

That is a **North American** supply (208 V, 60 Hz, single phase) and it is **exactly right**
for the US model page — the spec sheet's STANDARD table gives 208 / 60 / 1 / 5.6 kW → 27-0-27
amps. So the *number* isn't a data error; it is the **wrong configuration to be selling in
Kenya**, where mains is 240 V / 50 Hz.

The official power-supply table has a separate **EXPORT** block, and every 50 Hz option in it
is **three-phase WYE**:

| Block | VAC | Hz | Phase | kW | Amps (L1-L2-L3-N) |
|---|---|---|---|---|---|
| STANDARD | 208 | 60 | 1 | 5.6 | 27 / 0 / 27 |
| STANDARD | 208 | 60 | 3 | 5.6 | 24 / 12 / 15 |
| STANDARD | 220/240 | 60 | 1 | 5.6 | 24 / 0 / 24 |
| STANDARD | 220/240 | 60 | 3 | 5.6 | 21 / 11 / 14 |
| **EXPORT** | **240/415** | **50** | **3 WYE** | **5.6** | **11 / 0 / 9 / 3** |
| **EXPORT** | **230/400** | **50** | **3 WYE** | **5.6** | **11 / 0 / 10 / 1** |
| EXPORT | 240/415 | 50 | 3 WYE | 8 | 13 / 11 / 11 / 2 |
| EXPORT | 230/400 | 50 | 3 WYE | 8 | 13 / 11 / 11 / 2 |

**There is no 50 Hz single-phase CTB on the spec sheet at all.** A CTB-SGL destined for
Kenya should be the **240/415 V, 50 Hz, 3-phase WYE, 5.6 kW (11/0/9/3 A)** export
configuration.

Two knock-on facts the record also doesn't carry:

- The blower motor speeds are frequency-dependent: **1140 / 1725 rpm at 60 Hz**, but
  **950 / 1425 rpm at 50 Hz**. A 60 Hz-spec unit run on Kenyan 50 Hz mains does not just
  work slower — it is a different factory build.
- The spec sheet's own note: *"For control panels other than standard consult your local
  international distributor for CE approvals."*

**Recommendation:** confirm with the supplier which build is actually being imported before
publishing any electrical figure. Do **not** silently keep "208v/60/1-ph, 27.0 amps" on a
Kenyan storefront — a buyer's electrician would size a 32 A single-phase circuit for a
machine that will arrive wired for three-phase.

---

## 6. Provenance — this record was copy-pasted from ckitchen.com, typo and all

The stored `technical_specification` reads:

> Blodgett CTB SGL Deck Electric Convection Oven with **Contols**, 208v/60/1-ph, 5.6 kW, 27.0 amps, direct

ckitchen.com's product title for this item is, character for character:

> Blodgett CTB SGL Deck Electric Convection Oven with **Contols**, 208v/60/1-ph, 5.6 kW, 27.0 amps, direct

Same misspelling of "Controls", same trailing "direct", same voltage variant string. The
`description` field's bullet list ("Pans per Compartment", "Installation Type",
"Interior Finish", "Control Type") is the same page's spec-attribute list.

That explains three separate defects at once:

1. **The wrong height** (§4.4) — inherited from ckitchen's incorrect 28.25".
2. **The `13"" x 18""` doubled quote marks** in the `description` — a CSV/JSON escaping
   artifact from the paste. This renders literally on the storefront today.
3. **Quill editor junk markup** — every paragraph is wrapped in
   `<span style="color: rgb(81, 83, 101);">` (description) / `rgb(51, 51, 51)` (spec),
   the same leftover seen on the Santos 68JA and the Brema records.

Also worth noting from the same page: ckitchen carries this unit at a US list value of
**USD 11,210**. Our stored price is **KES 776,250** (≈ USD 6,000 at ~129 KES/USD). Not a
data error — just context if the margin is ever questioned.

---

## 7. Field-by-field audit vs the official spec sheet

| Field | Stored | Official (CTB-spec.pdf) | Verdict |
|---|---|---|---|
| `model_number` | `CTB SGL` | `CTB-SGL` | ✅ match (hyphen only) |
| `brand` | BLODGETT | Blodgett | ✅ |
| `category` | Ovens | Half-size electric convection oven | ✅ |
| Pan capacity | 5 × 13" × 18" | five 13" × 18" half-size pans, front-to-back | ✅ |
| Steam pans | *(not stored)* | also five 12" × 20" × 2-1/2" steam table pans | ➕ add |
| Decks | 1 | single section | ✅ |
| Power type | Electric | Electric | ✅ |
| Interior finish | Porcelain | double-sided porcelainized liner, **14 gauge** | ✅ (add gauge) |
| Controls | "Solid State – (SSI-M) … with electro-mechanical timer" | "Solid state manual, separate dials for thermostat and time"; **60-minute** timer; Cook/Cool-Down mode selector | ⚠ "SSI-M" is reseller shorthand; Blodgett's own naming is **SSM** (manual) / SSD (digital) / SimpleTouch |
| Fan | 2-speed | 2-speed, **1/4 hp** blower, automatic thermal overload; plus one control-area cooling fan | ✅ (add hp) |
| Door | Single, hinged left, dual-pane thermal glass | ✅ — matches CTB (CTBR is the right-hinge sibling) | ✅ |
| Exterior | "Stainless steel front sides top & back" | + full welded angle-iron frame, tilt-down modular control panel, solid mineral-fibre insulation | ✅ (thin) |
| Installation type | **"Floor Model"** | Ships with **4" (102 mm) stainless legs**; floor/stand mounting needs an *optional* stand (146 / 178 / 406 / 483 / 610 / 838 mm) | ⚠ **misleading** — as supplied it's a countertop unit |
| Dimensions | 638 / 768 / 720 | 768 W × 638 D × **738** H (on legs) | ⚠ height wrong (§4) |
| Interior dims | *(not stored)* | 387 W × 508 H × 533 D mm | ➕ add |
| Weight | *(not stored)* | **295 lb (134 kg)** | ➕ add |
| Electrical | 208 V / 60 Hz / 1 ph / 27 A | correct for the US build, **wrong region** (§5) | ⚠ |
| Power | 5.6 kW | 5.6 kW max input (8 kW option) | ✅ |
| Heaters | *(not stored)* | two tubular heaters | ➕ add |
| Temp range | *(not stored)* | **200–500 °F (93–260 °C)** | ➕ add |
| Racks | *(not stored)* | five chrome-plated racks, **nine positions**, min 1-5/8" (41 mm) spacing | ➕ add |
| Clearance | *(not stored)* | **0" (0 mm)** from combustible and non-combustible construction | ➕ add — a real selling point |
| Certifications | *(not stored)* | cETLus (Intertek), **NSF**, **ENERGY STAR**, **CE** | ➕ add |
| Warranty | *(not stored)* | 3 yr parts / 2 yr labour; 5 yr limited door — *"for all international markets, contact your local distributor"* | ➕ add with the international caveat |
| Crate | *(not stored)* | 914 L × 813 W × 889 H mm | ➕ add (freight-relevant) |
| `meta_description` | **absent** | — | ➕ add (same gap as every other brand pass) |
| `short_description` | generic marketing, no numbers | — | ⚠ rewrite: no pan count, no kW, no dimensions |

### 7.1 Two internal inconsistencies in Blodgett's own spec sheet

Flagged so nobody "fixes" them the wrong way later:

- The options list offers **"7.5 Kw elements"**, but the Maximum Input line and the whole
  increased-output power table say **8 kW**. Use **8 kW** (it appears four times in the
  power table vs once in the options list).
- The options list prints **"19" (438mm) stainless steel stand with shelf"** — 19" is
  **483 mm**, and the double-oven elevation on page 2 correctly uses 19" (483 mm). The
  438 mm is a typo on Blodgett's own sheet.

---

## 8. Images — downloaded to `Downloads/blodgett-images/`

**The current catalogue image is the biggest single quality problem on this record.**
`storage/app/public/products/oven-convection-electric-blodgett-ctb-sgl-imgove00107.jpeg`
is a **9 KB, ~250 px web thumbnail** — visibly soft, unusable at PDP size.

Six files downloaded (plus the official spec PDF for reference), all confirmed by eye to be
the correct left-hinged CTB with the solid-state manual dial panel:

| File | Source | Size | Notes |
|---|---|---|---|
| `IMG-OVE-00107__CTB-SGL-front.jpg` | https://www.katom.com/015-CTBSINGLE2083.html | 1600 × 1600 | **Recommended primary.** Clean white-background 3/4 front, on the 4" legs, dial control panel legible. Best available shot of this SKU. |
| `IMG-OVE-00107__CTB-SGL-on-stand-official.jpg` | https://www.blodgett.com/wp-content/uploads/2021/02/CTB.jpg | 400 × 595 | Official Blodgett render — correct CTB (left hinge, controls right), shown on an optional caster stand. Authoritative but small. |
| `IMG-OVE-00107__CTB-SGL-on-stand-alt.webp` | https://www.ckitchen.com/p/blodgett-ctb-sgl-convection-oven-3.html | 600 × 600 | Same on-stand composition, square crop. |
| `IMG-OVE-00107__CTB-SGL-lifestyle-1.jpg` | katom | 1600 × 1600 | Kitchen lifestyle shot. Usable as a gallery image; control-panel legends are illegible. |
| `IMG-OVE-00107__CTB-SGL-lifestyle-2.jpg` | katom | 1600 × 1600 | ⚠ **Looks synthetic/AI-composited** — the BLODGETT badge is distorted and the panel legends are nonsense. Use only if a lifestyle filler is wanted, and preferably not at all. |
| `IMG-OVE-00107__CTBR-on-stand-official.jpg` | https://www.blodgett.com/wp-content/uploads/2024/11/CTBR-onStand.jpg | 2259 × 3503 | ⚠ **WRONG VARIANT — do not publish on this SKU.** Highest-resolution official image on blodgett.com, but it is the **CTBR**: door hinged on the **right**, controls on the **left** — the mirror image of what we sell. Kept only as a construction/detail reference. |
| `IMG-OVE-00107__CTB-CTBR-official-spec-sheet.pdf` | https://www.blodgett.com/custom/PDF/specs/CTB-spec.pdf | 150 KB | Official spec sheet incl. the page-2 dimension elevations used in §4. |

The CTB/CTBR hinge trap is easy to fall into precisely because the sharpest official asset
Blodgett publishes is of the *other* variant. Anyone adopting these should sanity-check hinge
side on every image before it goes on the PDP.

Not yet copied into `storage/app/public/products/` and not referenced in `products.json` —
staged in Downloads for review, same workflow as the Brema and Santos passes.

---

## 9. Product reference

| SKU | Catalogue name | Model | Official model page | Official spec sheet | Confidence |
|---|---|---|---|---|---|
| IMG/OVE/00107 | Oven Convection Electric Blodgett CTB SGL | CTB SGL (= Blodgett `CTB-SGL`) | https://www.blodgett.com/model/blodgett-ctb-single-half-size-premium-electric-convection-oven/ | https://www.blodgett.com/custom/PDF/specs/CTB-spec.pdf | **High** — exact code match, official manufacturer spec sheet, two independent reseller cross-checks agreeing with the drawing |

Spec confidence by field: **very high** on capacity, construction, controls, interior
dimensions, weight, W and D. **High** on overall height (derived from the official elevation
and confirmed twice independently, but not stated in text on Blodgett's sheet). **Unresolved**
on which electrical build is actually imported (§5) — that is a supplier question, not a
research question.

---

## 10. Recommended changes (none applied)

Ordered by impact:

1. **Replace the product image** — the current file is a 9 KB thumbnail. Use
   `IMG-OVE-00107__CTB-SGL-front.jpg`. Never the CTBR file (§8).
2. **Resolve the electrical configuration with the supplier** (§5), then correct the spec.
   Kenya needs the 240/415 V 50 Hz 3-phase WYE export build (11/0/9/3 A), not the stored
   208 V 60 Hz single-phase US build.
3. **Fix `height`: 720 → 738 mm** (§4). Leave `length` and `width` alone — they already
   render correctly.
4. **Rewrite `description`** to the Skymsen pattern (prose + `<h3>Key Features</h3>` + HTML
   `<table>`), which removes the Quill colour spans and the literal `13"" x 18""` artifact
   at the same time.
5. **Fix "Installation Type: Floor Model"** — it ships as a countertop unit on 4" legs;
   stands are a paid option.
6. **Add the missing specs** listed in §7: weight 134 kg, interior 387 × 508 × 533 mm,
   200–500 °F, five racks / nine positions, 1/4 hp two-speed blower, 0 mm clearance,
   ENERGY STAR / NSF / cETLus / CE, warranty (with the international-distributor caveat),
   crate size.
7. **Add a `meta_description`** — the record has none.
8. **Do not change `model_number`** — `CTB SGL` matches Blodgett's `CTB-SGL` and is the
   record's unique ID.
9. **`brands.json` needs no change** (§1).

### Left for a wider pass, not this SKU

- The **`length` vs `width` field-convention inconsistency** (§4.3). This record is
  populated `length = depth`; Tecnodom, HDS and the Brema/Santos passes assume
  `length = width`. Both storefront views render `width` first, so half the catalogue's
  dimensioned products are currently displaying W and D transposed. That is a
  catalogue-wide decision, not a Blodgett fix.
- The admin form labels the same three fields **"Dimensions – L × W × H"**
  (`resources/views/pages/admin/products/form/form.blade.php`, ~line 732) while the compare
  page labels them **"Dimensions (W × D × H)"** — the label mismatch is what lets the
  convention drift in the first place.
