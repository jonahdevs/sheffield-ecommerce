# Brema Product Research

Research notes behind a BREMA enrichment/audit pass on `products.json` (July 2026).
Covers all 5 BREMA SKUs, all ice cube machines: CB 249A HC, CB 416A HC, CB 640A HC,
CB 955A HC, and CB 1565A HC — a single product line at five capacity tiers.

**No `products.json` changes have been applied yet** — this file is findings only, same
starting point as the other brand-research files before a scope decision.

---

## 1. Brand identification

**Brema** = **Brema Group S.p.A.**, an Italian ice-machine manufacturer. `brands.json`
already has the correct entry (`slug: brema`, `website_url: https://www.bremaice.it`) —
that URL is real but **redirects** (301) to the current corporate domain:
**`https://www.bremagroup.it/brema/`**. Not a broken link, just an old domain kept alive
as a redirect; no `brands.json` change needed.

Product pages live under `https://www.bremagroup.it/prodotti_brema/<model-slug>/`, e.g.
`.../cb-640a-hc-b-qube-2-0-wi/`. The English CB1565 page uses a different URL shape:
`https://www.bremagroup.it/en/brema_products/cb1565/`.

---

## 2. The "2.0 Wi" generation trap

Brema's current site lineup is the **"2.0 Wi"** generation (built-in Wi-Fi / Brema
Connect app, "AWS 2.0" automatic washing). Some of our catalogue's model codes match
this generation exactly; at least one does not:

| Our model_number | Current-site match | Match quality |
|---|---|---|
| CB 416A HC | `cb-416a-hc-b-qube-2-0-wi` | **Exact code match** |
| CB 640A HC | `cb-640a-hc-b-qube-2-0-wi` | **Exact code match** |
| CB 955A HC | `cb-955a-hc-b-qube-2-0-wi` | **Exact code match** |
| CB 1565A HC | `en/brema_products/cb1565/` (page itself titled "CB1565A HC") | **Exact code match** |
| CB 249A HC | **not on current site** — closest is `CB246A HC 2.0 Wi` | **No current-gen match — see §3.1** |

CB 249A HC is a **legacy/prior-generation code**, still sold and documented by
independent resellers (all agreeing with each other), but superseded on Brema's own
current site by CB246A HC 2.0 — a *different, smaller-capacity* machine, not just a
rename. Do not substitute 246A's specs for 249A's.

---

## 3. Per-SKU findings

### 3.1 CB 249A HC (IMG/REF/00081) — record has no description/spec at all; legacy code, sourced from resellers

This record currently has **only** a `short_description` — no `description`,
`technical_specification`, or dimension fields exist. Two conflicting spec sets were
found and had to be disambiguated:

- **EU/non-AWS listing** (barstuff.com, matches our bare "CB 249A HC" — no "AWS" suffix):
  387 × 470 × 687 mm, 32 kg, 270 W, R290, **29 kg/24h**, **9 kg storage bin**, ice cone
  ≈18g. <https://www.barstuff.com/brema-ice-cube-maker-cb-series-249a-hc-ice-cone-29-kg-13558>
- **US "AWS" variant** (nellaonline, zanduco, russellhendrix, etc. — all say "CB249A HC
  AWS"): different physical size, 79 lb/24h (~36 kg), 20 lb (~9 kg) bin, 82 lb machine
  weight. This is the Automatic-Washing-System sub-variant, a distinct SKU from plain
  "CB 249A HC" — **not used**, since our model_number carries no AWS suffix.
- Current-site CB246A HC 2.0 (successor model): 387×476×606mm, 21 kg/24h, 6 kg bin,
  270W, R290 — lower capacity than the legacy 249A on every ice-output figure. **Not
  used** — different model, not a rename (§2).

**Recommended source: the plain EU barstuff.com figures** (387×470×687mm / 32kg / 270W
/ R290 / 29kg per 24h / 9kg bin / ice cone ~18g), since it's the only one that matches
our exact model code without an AWS suffix.

### 3.2 CB 416A HC (IMG/REF/00082) — confirmed correct, but width/height axes are swapped

Official page confirms our stored description/spec content is accurate (compact & crystal
cube, removable air filter, air cooled, HCFC-free, RoHS, WRAS, AISI 304 Scotch Brite,
43°C max ambient, 230V/50Hz, 44kg/24h, 16kg bin) — **but the dimensions are wrong**:

- Stored: `length: 497, width: 687, height: 592` (and the prose technical_specification
  independently says "Length 497mm, Width 592mm, Height 687mm" — the **prose and the
  numeric fields disagree with each other**, not just with the manufacturer).
- Official (`cb-416a-hc-b-qube-2-0-wi`): **497 × 598 (depth) × 686 mm (height)**.
- The **numeric `width` field (687) is actually the height**; the **numeric `height`
  field (592) is actually the depth/width** (598, within rounding). Same axis-swap
  pattern already documented in the Santos and Empero passes — this is a recurring
  cross-brand import bug, not Brema-specific.
- Add: net/gross weight 43/51 kg, cube size 23g (B-Qube type, supersedes the stored
  "13g/18g/33g/42g" range — see §4 note on cube-type naming), power 450W (not currently
  stored), refrigerant R290.

### 3.3 CB 640A HC (IMG/REF/00154) — same width/height swap, otherwise confirmed

- Stored: `length: 735, width: 850, height: 603`; prose says "Length 735, Width 603,
  Height 850" — again internally contradictory.
- Official (`cb-640a-hc-b-qube-2-0-wi`): **735 × 610 (depth) × 849 mm (height)**. Same
  swap as CB-416A: stored `width` (850) is really the height; stored `height` (603) is
  really the depth (610, within rounding).
- Add: net/gross weight 67/79 kg, cube size 23g, power 590W, refrigerant R290,
  60kg/24h→ actually official states 72kg/24h (stored "67 kg/24h" close but not exact -
  see §4), 40kg bin (stored figure already correct).

### 3.4 CB 955A HC (IMG/REF/00181) — dimensions NOT swapped this time; description already good

Unlike 416A/640A, this SKU's stored dimensions are **already correct**:

- Stored: `length: 735, width: 603, height: 1010`.
- Official (`cb-955a-hc-b-qube-2-0-wi`): **735 × 610 (depth) × 1009 mm (height)** — matches
  the stored fields directly (735→735, 603≈610 depth, 1010≈1009 height). **No swap bug
  here** — confirms (same as the Empero/Santos passes) that the swap has to be checked
  per-SKU, not assumed.
- Existing description/spec (air/water cooling, R290, 870W, 220-240V, AISI 304 Scotch
  Brite, disappearing door) already matches the official page closely. Add: cube size
  23g (B-Qube — stored says "18g", see §4), storage bin 55kg (not currently stored), net/
  gross weight 74/86kg, "not suitable for under-counter installation" (this is the
  full-size floor unit, unlike the smaller under-counter siblings).

### 3.5 CB 1565A HC (IMG/REF/00076) — draft, empty image, no content at all; two generations found

This record is `status: draft`, `image: ""`, and has no description/spec/dimension
fields whatsoever — needs building from scratch.

Two spec sets exist and disagree on power/refrigerant only (dimensions and capacity
agree exactly):

- **Official current site** (`en/brema_products/cb1565/`): 840×740×1075mm, 118/138kg net/
  gross, **1400W**, 16A fuse, **R452A**, 155kg/24h, 65kg storage bin, cube sizes
  13/18/33/42/60g, air or water condensation.
- **Multiple independent resellers** (ipckitchens, mkayn, ekuep, sydneyicemachines, shub.coffee
  — all agreeing with each other): same 840×740×1075mm, 155kg/24h, 65kg bin, but
  **1050W, R290**, single-phase 230V.

This reads as the same physical dimensions/capacity across a **refrigerant-generation
change** (R290 → R452A), similar in shape to the Santos #50/#50NEW situation: resellers
are quoting an older refrigerant/compressor spec still valid for units already in the
field, while Brema's own current site reflects what's shipping today. **Recommend using
the official current-site figures** (1400W, R452A) as the primary spec, since that's the
authoritative living source — but flag both, since which one is physically true for
*our* stock depends on which generation the supplier actually ships.

---

## 4. Cross-cutting notes

- **Cube-size field looks copy-pasted across all three "confirmed" SKUs** (416A, 640A,
  955A): the stored `technical_specification` on all three lists the identical string
  "Ice cube size 13g, 18g, 33g, 42g" — but each model's *actual* current-generation cube
  is a single **23g "B-Qube"** size, not a range. The "13/18/33/42g" range appears to be
  Brema's *general* catalogue-wide list of all cube sizes across their whole range (also
  seen verbatim on the CB1565 page), not this specific model's cube. Recommend replacing
  with each model's actual single cube weight where confirmed (23g for 416A/640A/955A),
  and leaving 1565A at its confirmed 13/18/33/42/60g range since that page genuinely
  lists multiple sizes as options.
- **24h output figure drift**: CB-640A's stored "67 kg/24 Hours" vs official "72 kg" (at
  the "21A/15W" test condition) — a small but real gap, not just rounding.
- **HC suffix**: "HC" = hydrocarbon refrigerant (R290 propane), standard across the whole
  confirmed-R290 part of this range; only the largest (CB1565A) has moved to R452A on
  the current site, so "HC" may no longer be strictly accurate for that one model if the
  current-gen R452A figure is what's actually being sold.

---

## 5. Product reference

| SKU | Catalogue name | Model | Official page | Independent source | Confidence |
|---|---|---|---|---|---|
| IMG/REF/00081 | Ice Cube Machine CB-249A Brema | CB 249A HC | not on current site (legacy code, §2) | https://www.barstuff.com/brema-ice-cube-maker-cb-series-249a-hc-ice-cone-29-kg-13558 | Medium — independent reseller only, no current official page for this exact code |
| IMG/REF/00082 | Ice Cube Machine CB-416A Brema | CB 416A HC | https://www.bremagroup.it/prodotti_brema/cb-416a-hc-b-qube-2-0-wi/ | same | **High** — official page, exact code match |
| IMG/REF/00154 | Ice Cube Machine CB-640A Brema | CB 640A HC | https://www.bremagroup.it/prodotti_brema/cb-640a-hc-b-qube-2-0-wi/ | same | **High** — official page, exact code match |
| IMG/REF/00181 | Ice Cube Machine CB 955A HC Brema | CB 955A HC | https://www.bremagroup.it/prodotti_brema/cb-955a-hc-b-qube-2-0-wi/ | same | **High** — official page, exact code match |
| IMG/REF/00076 | Ice Cube Machine CB-1565A Brema | CB 1565A HC | https://www.bremagroup.it/en/brema_products/cb1565/ | https://www.ipckitchens.com/product/brema-cb-1565a-ice-cube-maker-prod-cap-155kg-day-storage-65kg-voltage240v-50hz-1ph-dim-840x740x1075/ | **High** on dims/capacity — official + reseller agree; power/refrigerant generation-dependent (§3.5) |

---

## 6. Restructure pass applied (July 2026) — "safe changes only" scope

Applied on the same "safe changes only" basis as the Empero pass: reformat all 5 to the
Skymsen pattern (prose + `<h3>Key Features</h3>` + HTML `<table>`), add/correct
source-verified specs, but no `model_number`/`brand`/`name`/`status`/image changes.

**Applied to `products.json`:**
- **All 5** reformatted to prose + Key Features + table; all now carry a `meta_description`.
  Quill-editor junk markup stripped.
- **CB 249A HC (00081)** — built out from empty (only had a short_description). Added
  description + full spec table + dims (387×470×687, 32kg, 270W, R290, 29kg/24h, 9kg bin,
  ~18g cone) from the plain-EU barstuff figures that match our exact "HC" (non-AWS) code.
- **CB 416A HC (00082)** — fixed the **width/height axis swap** to the official
  497×598×686 mm; corrected cube "13/18/33/42g" → single **23 g**; added power 450W,
  net/gross 43/51 kg, R290.
- **CB 640A HC (00154)** — fixed the **width/height swap** to 735×610×849 mm; corrected
  24h output **67 → 72 kg** (official figure); cube → 23 g; added power 590W, 67/79 kg.
- **CB 955A HC (00181)** — dims were already essentially correct (minor 603→610, 1010→1009);
  added storage bin 55 kg, net/gross 74/86 kg; corrected cube "18g" → 23 g; noted
  floor-standing (not undercounter).
- **CB 1565A HC (00076)** — built out from empty (was a bare draft). Added description +
  spec table + dims (840×740×1075, 155kg/24h, 65kg bin, selectable 13-60g cubes).
  **Power/refrigerant decision:** used **R290 / 1050 W** (reseller consensus) rather than
  the official current-site R452A / 1400W, because our `model_number` explicitly carries
  the **"HC"** (hydrocarbon = R290) designation — see §3.5. If the supplier actually ships
  the current R452A generation, this one figure needs revisiting.

**Not changed (per scope):**
- **CB 1565A `status`** left as **`draft`** and `image` left empty — publishing and image
  sourcing are separate decisions; content was built out so it's ready when those happen.
- No `model_number`, `brand`, `name`, or image field changed on any of the 5.
- `brands.json` URL not touched — `bremaice.it` correctly redirects to the live site (§1),
  so it isn't broken.

---

## 7. Image sourcing (July 2026) — downloaded to `Downloads/brema-images/`

Pulled the real product-image URLs out of each official Brema product page's DOM (they're
lazy-loaded, so the visible `<img>` starts as an SVG placeholder — the real file sits in
`data-src` under `bremagroup.it/wp-content/uploads/...`). Downloaded straight via `curl`
(no auth/referer needed), named by SKU for manual review, same workflow as the Santos pass.

**22 files total.** The official Brema product pages carry only **one** product render each
(the rest of each page is HQ/lifestyle/cube-graphic filler). The **multi-angle carousels
live on the reseller barstuff.com**, so the full angle sets were pulled from there and the
single clean official render was kept alongside as each SKU's primary candidate.

| SKU | Model | File(s) | Sources |
|---|---|---|---|
| IMG/REF/00081 | CB 249A HC | `IMG-REF-00081__CB-249A-` front / left / right / detail / view2 (1000×1000 ×5) | barstuff CB 249A carousel (legacy model, not on Brema's current site, §2) |
| IMG/REF/00082 | CB 416A HC | `IMG-REF-00082__CB-416A.jpg` (official 700×700) + `-front/left/right/detail/view2` (barstuff 1000×1000 ×5) | official `.../2026/04/CB316-416-A-HC-2.0-Wi.jpg` + barstuff CB 416A carousel |
| IMG/REF/00154 | CB 640A HC | `IMG-REF-00154__CB-640A.jpg` (official) + `-view1/2/3` (barstuff) + `-view4` (**dimension drawing**) | official `.../2026/04/CB640A-HC-2.0-Wi.jpg` + barstuff CB 640A carousel |
| IMG/REF/00181 | CB 955A HC | `IMG-REF-00181__CB-955A.jpg` (official) + `-view1/2/3/4` (barstuff) | official `.../2026/04/CB955A-HC-2.0-Wi.jpg` + barstuff CB 955W carousel (same cabinet; W = water-cooled internally) |
| IMG/REF/00076 | CB 1565A HC | `IMG-REF-00076__CB-1565A.jpg` (750×750, single) | official `.../2024/10/cb-1565.jpg` — barstuff does not carry this large model, so no carousel |

Notes for whoever adopts these:
- **Two cosmetic generations exist.** The official renders are the current **"2.0 Wi" /
  B-Qube** generation; the barstuff carousel angles are the older **"ice-cone" (A HC)**
  generation, which actually matches our bare `model_number` (`CB 416A HC` etc., no
  "B-QUBE"/"2.0" suffix) more literally. Front-panel vent layout differs slightly between
  the two. Pick whichever matches the unit the supplier actually ships.
- **Line-drawings, not photos:** `IMG-REF-00154__CB-640A-view4.jpg` (and the discarded
  2025/02 version of the 1565A file) are dimensional drawings. Useful as spec references
  (the 640A one confirms 735×603×850 mm) but not storefront product photos.
- barstuff filenames carry "aws" and (for 955) "955w" — these are the auto-wash / water-
  cooled internal sub-variants; the **external cabinet is identical** to our air-cooled
  non-AWS codes, so the images are valid references.
- **Not yet copied into `storage/app/public/products/` or referenced in `products.json`** —
  staged in Downloads for review first, exactly like the Santos set. CB 1565A (00076) still
  has `image: ""` and `status: draft`, so its photo is ready whenever that record is published.

### Bonus data fix while on the pages
The 955A official page (seen directly while extracting images) shows **95 kg / 24 h** ice
output — a figure the record previously lacked. Added to CB 955A HC's short description,
Key Features and spec table (the 640A page likewise re-confirmed its 72 kg, already applied
in §6).
