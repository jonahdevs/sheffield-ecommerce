# Brema Product Research

Supersedes the archived research below (July 2026), which predates the SAP export and reached
several conclusions this pass reverses. Covers all 5 BREMA SKUs.

Staging folder: `Desktop\ecommerce\products resorce final\brema\`
Nothing in `products.json`, `brands.json` or `storage/` was changed by this pass.

---

## 1. Brand

**Brema Group S.p.A.**, Villa Cortese (MI), Italy. `brands.json`'s stored
`https://www.bremaice.it` still 301-redirects correctly to the live corporate site, so no
`brands.json` change is needed.

Live product pages: https://www.bremagroup.it/prodotti_brema/
Documentation index: https://www.bremagroup.it/en/documentation/

---

## 2. The `HC` suffix = R290 - confirmed on all five models

Our five model numbers all end `HC`. The catalogue has a documented history of asserting
R290 where it was only an option, so this was checked rather than assumed. **It holds, and
the evidence is strong.**

Brema publishes a **separate page per model for the HC and non-HC variants**, and they differ
on exactly refrigerant and power:

| Model | non-HC page | HC page |
|---|---|---|
| CB 249 | R452A, 430 W | **R290, 270 W** |
| CB 416 | R452A, 455 W | **R290, 450 W** |
| CB 640 | R452A, 710 W | **R290, 590 W** |
| CB 955 | R452A, 980 W | **R290, 870 W** |
| CB 1565 | R452A, 1400 W | **R290, 1150 W** |

https://www.bremagroup.it/prodotti_brema/cb249-hc/
https://www.bremagroup.it/prodotti_brema/cb416-hc/
https://www.bremagroup.it/prodotti_brema/cb640-hc/
https://www.bremagroup.it/prodotti_brema/cb955-hc/
https://www.bremagroup.it/prodotti_brema/cb1565-hc/

Reinforced by two further layers:

- The official per-model datasheet PDFs are **named** `CB <n> HC R290 ENG.pdf` and print
  `Refrigerant R290` in the technical table. All five are staged.
- The 2026 catalogue lists the whole ice-cube range as HC only (CB184 HC through CB1565 HC),
  every entry `Refrigerant R290`. There is no non-HC ice cube machine left in the 2026 range.
  https://www.bremagroup.it/wp-content/uploads/2026/05/CATALOGO-BREMA-2026_ENG.pdf
- Brema publishes a dedicated R290 conversion flyer:
  https://www.bremagroup.it/wp-content/uploads/2025/02/FLYER-R290-2025-ENG.pdf

**Recommendation: state R290 (propane, hydrocarbon) on all five.** R290 is flammable, so this
is a real servicing/safety fact, not a cosmetic spec.

### 2.1 SAP's refrigerant remarks are stale on four of five

| SKU | SAP remark | Brema HC datasheet | |
|---|---|---|---|
| IMG/REF/00081 CB 249A HC | R404A, 370 W | R290, 270 W | SAP wrong |
| IMG/REF/00082 CB 416A HC | R404A, 450 W | R290, 450 W | gas wrong, power right |
| IMG/REF/00154 CB 640A HC | R452A, 650 W | R290, 590 W | SAP wrong |
| IMG/REF/00181 CB 955A HC | R290, 870 W | R290, 870 W | **SAP correct** |
| IMG/REF/00076 CB 1565A HC | R404A, 1400 W | R290, 1280 W | SAP wrong |

The remarks were pasted from pre-HC datasheets (R404A era, later R452A) and only CB 955A HC
was ever refreshed. The R404A remarks are older than the R452A one, so these strings were not
even captured on a single date.

⚠ The old research file recommended R290/1050 W for CB 1565A HC on reseller consensus, and
flagged R452A as a possibility. The reseller instinct was right on the gas; the power figure
(1050 W) matches nothing Brema publishes today - the current datasheet says **1280 W**.

---

## 3. SAP dimensions - correct, stable order, two rows exact

| SKU | SAP length/width/height | Official datasheet L-P-H | Verdict |
|---|---|---|---|
| IMG/REF/00081 | 390 / 460 / 690 | 387 - 470 - 687 | order right, rounded to 10 mm |
| IMG/REF/00082 | 500 / 580 / 690 | 497 - 592 - 687 | order right, rounded to 10 mm |
| IMG/REF/00154 | 735 / 603 / 850 | 735 - 603 - 850 | **exact** |
| IMG/REF/00181 | blank | 735 - 603 - 1010 | SAP MISSING |
| IMG/REF/00076 | 840 / 740 / 1075 | 840 - 740 - 1075 | **exact** |

**SAP's column order for BREMA is `width, depth, height` on every row** - identical to Brema's
own printed `L-P-H`. No per-row variation and no carton figure in a product field. This brand
is a clean case: SAP is right and its order is establishable from SAP itself (each row's
`Item Remarks` dimensions are consistent with its own numeric fields).

**SAP `weight` is GROSS, in grams.** IMG/REF/00154 carries `79000.0` and the datasheet gives
net 67 kg / **gross 79 kg**.

Our `products.json` values sit between the two published generations and are all within a few
millimetres of the datasheet - nothing here needs a correction on its own account.

⚠ Datasheet dimensions are stated **without feet**; adjustable feet add 110-150 mm.

---

## 4. Official specification (from the five model datasheets)

| | CB 249A HC | CB 416A HC | CB 640A HC | CB 955A HC | CB 1565A HC |
|---|---|---|---|---|---|
| Production 24 h | 29 kg | 42 kg | 72 kg | 95 kg | 160 kg |
| Bin capacity | 9 kg | 16 kg | 40 kg | 55 kg | 65 kg |
| Cooling | air or water | air or water | air or water | air or water | air or water |
| Cube sizes | A-18 C-33 D-13 E-42 g | same | same | same | same + B-60 g |
| Refrigerant | R290 | R290 | R290 | R290 | R290 |
| Voltage | 220-240 V ~ 50 Hz | same | same | same | same |
| Avg power | 270 W | 450 W | 590 W | 870 W | 1280 W |
| Fuse | 10 A | 10 A | 10 A | 10 A | 16 A |
| Size L-P-H mm | 387-470-687 | 497-592-687 | 735-603-850 | 735-603-1010 | 840-740-1075 |
| Packed L-P-H mm | 440-520-860 | 550-660-860 | 780-640-1015 | 780-640-1185 | 880-785-1245 |
| Net / gross kg | 32 / 38 | 43 / 51 | 67 / 79 | 74 / 86 | 118 / 138 |
| Water use (air) | 3 l/kg | 3 l/kg | 4 l/kg | 2.3 l/kg | 2 l/kg |
| Finish | AISI 304 scotch brite | same | same | same | same |
| Ambient range | +10 to +43 C | same | same | same | same |
| Datasheet rev | 03, Jan 2025 | 03, Jan 2025 | 03, Jan 2025 | 03, Jan 2025 | 04, Mar 2025 |

Source PDFs (all HTTP 200 live, all staged):

https://www.bremagroup.it/doc-prodotti/schede-tecniche/en/CB%20249%20HC%20R290%20ENG.pdf
https://www.bremagroup.it/doc-prodotti/schede-tecniche/en/CB%20416%20HC%20R290%20ENG.pdf
https://www.bremagroup.it/doc-prodotti/schede-tecniche/en/CB%20640%20HC%20R290%20ENG.pdf
https://www.bremagroup.it/doc-prodotti/schede-tecniche/en/CB%20955%20HC%20R290%20ENG.pdf
https://www.bremagroup.it/doc-prodotti/schede-tecniche/en/CB%201565%20HC%20R290%20ENG.pdf

⚠ **CB 1565A HC conflict:** datasheet Rev.04 says 160 kg/24 h and 1280 W; the website product
page and the 2026 catalogue both still say 152 kg / 1150 W. Rev.04 is the newer document.
Recorded, not silently resolved.

---

## 5. The datasheet links on Brema's own site are broken

Each product page links `https://www.bremagroup.it/doc-prodotti/schede-tecniche/it/CB640_HC_2.0WI-IT.pdf`.
**Every one of those 404s**, as does `/doc-prodotti/` itself. Tested with and without `www`,
http vs https, `.pdf` vs `.PDF`, and with a referer.

The real filenames were recovered from a Wayback CDX listing and then fetched from the **live**
site - see section 4. The same route produced four exploded-view spare-parts manuals under
`/doc-prodotti/schede-ricambi/en/` (249, 416, 640, 955; none found for 1565) and the family
user manual `241647_rev3_CB HC_SL R290_ECP NG.pdf` under `/doc-prodotti/manuali-duso/`.

None of those are linked from anywhere on the site. The page markup's `_2.0WI-` convention is
dead; `<model> HC R290 ENG` is live.

---

## 6. Ice format: our SKUs are ICE CUBE (cone), not B-Qube

Brema sells each CB machine in two ice trims:

- **ICE CUBE** - truncated-cone cubes, sizes A-18 g / C-33 g / D-13 g / E-42 g (+ B-60 g on 1565)
- **B-QUBE** - a single 23 g true cube

**SAP's remark for every one of our five lists the cone set**, which matches the ICE CUBE
datasheets exactly. So our stock is the ICE CUBE trim.

⚠ The old research file recommended rewriting the cube spec to "a single 23 g B-Qube" for
416A/640A/955A. **That would have been wrong** - it read the current B-Qube marketing pages
rather than the trim we actually buy. Leave the 13/18/33/42 g range in place.

The two trims are **physically identical machines**; the only visible difference is two words
on the fascia badge. Proven directly: barstuff publishes the same CB1565A render twice, once
badged ICE CUBE and once B-QUBE.

---

## 7. Imagery

Two cosmetic generations exist. Brema's current renders show a **mesh-grille** cabinet with no
fascia text; the images already in `storage/app/public/products/` (1512x1512) are the
**previous twin-plastic-grille cabinet with a BREMA | ICE CUBE badge**. The sourced set is the
latter, so it is a like-for-like resolution upgrade rather than a change of appearance.

| SKU | Files | Best px | Source |
|---|---|---|---|
| IMG/REF/00081 CB 249A HC | 4 angles | 1000x1000 | https://www.barstuff.com/brema-ice-cube-maker-cb-series-249a-hc-ice-cone-29-kg-13558 |
| IMG/REF/00082 CB 416A HC | 4 angles | 1000x1000 | https://www.barstuff.com/brema-eiswuerfelbereiter-cb-serie-416-hc-eiskegel-42kg-13564G |
| IMG/REF/00154 CB 640A HC | 5 (hero + 4 angles) | **2048x2048** | https://ahlia.store/products/cb-640-brema + https://www.barstuff.com/brema-ice-cube-maker-cb-series-640a-hc-b-qube-dp-cubes-72-kg-13572 |
| IMG/REF/00181 CB 955A HC | 4 angles | 1000x1000 (1250 on detail) | https://www.barstuff.com/brema-ice-cube-maker-cb-series-955w-hc-ice-cone-95kg-13577 |
| IMG/REF/00076 CB 1565A HC | 1 | 800x800 | https://www.barstuff.com/brema-ice-cube-maker-cb-series-1565-hc-ice-cone-152-kg-13579G |

Caveats recorded per file in `_sourced.json`:

- **CB 640A HC** - barstuff has retired its ice-cone 640 listing, so the four angle shots carry
  the **B-QUBE** badge. The 2048 px hero is correctly ICE CUBE-badged.
- **CB 955A HC** - the ICE CUBE-badged renders are published on barstuff's CB955**W**
  (water-cooled) page; the CB955A page carries the same renders badged B-QUBE. The render shows
  two front condenser grilles, i.e. an air-cooled body, so it is the correct machine for our
  CB 955A. Marked `code_proven: false` for that page/code mismatch.
- **CB 1565A HC** - one image only, exactly at the floor.

### 7.1 Proven resolution ceilings

| Source | Ceiling | Evidence |
|---|---|---|
| bremagroup.it | 750 px | WordPress originals; no `-scaled` to strip |
| 2026 catalogue PDF embedded objects | 830 px | PyMuPDF extraction; print assets are downsampled, the PDF did not beat the web |
| barstuff.com | 1000 px (1250 on detail crops) | `_1600x1600`, `_2000x2000`, `_3000x3000` and bare `.jpg` all 404 |
| ahlia.store | 2048 px (CB640A only) | Shopify `/products.json` reports true source dimensions |

Two mechanics worth reusing:

- barstuff's optimizer host and the plain `www.barstuff.com` host serve the **same pixel count
  at different quality** - 78 681 bytes vs 35 447 for the identical 1000x1000 file. Pull from
  `www.barstuff.com/media/...`.
- `https://ahlia.store/products.json?limit=250&page=N` exposed 1475 products including 18 Brema
  SKUs with true source dimensions - that is how the 2048 px CB640A was located.

### 7.2 Nothing AI-generated

`_ai-generated/` is empty. Every accepted file is a Brema CGI product render with consistent
geometry, correctly-formed fascia lettering and physically coherent grille and foot detail.
Every image was opened and looked at.

⚠ **Perceptual hashing missed the badge difference.** `cb955aws-brema-cube-1` vs
`cb955aws-brema-b-qube-1` scored 16x16 ahash distance 0 and 256x256 greyscale RMS 0.68 -
"identical scene" - yet one reads ICE CUBE and the other B-QUBE. Hashing shortlists; only
opening the file adjudicates.

---

## 8. Product reference

| SKU | model_number | Official page | Datasheet | Confidence |
|---|---|---|---|---|
| IMG/REF/00081 | CB 249A HC | https://www.bremagroup.it/prodotti_brema/cb249-hc/ | https://www.bremagroup.it/doc-prodotti/schede-tecniche/en/CB%20249%20HC%20R290%20ENG.pdf | High |
| IMG/REF/00082 | CB 416A HC | https://www.bremagroup.it/prodotti_brema/cb416-hc/ | https://www.bremagroup.it/doc-prodotti/schede-tecniche/en/CB%20416%20HC%20R290%20ENG.pdf | High |
| IMG/REF/00154 | CB 640A HC | https://www.bremagroup.it/prodotti_brema/cb640-hc/ | https://www.bremagroup.it/doc-prodotti/schede-tecniche/en/CB%20640%20HC%20R290%20ENG.pdf | High |
| IMG/REF/00181 | CB 955A HC | https://www.bremagroup.it/prodotti_brema/cb955-hc/ | https://www.bremagroup.it/doc-prodotti/schede-tecniche/en/CB%20955%20HC%20R290%20ENG.pdf | High |
| IMG/REF/00076 | CB 1565A HC | https://www.bremagroup.it/prodotti_brema/cb1565-hc/ | https://www.bremagroup.it/doc-prodotti/schede-tecniche/en/CB%201565%20HC%20R290%20ENG.pdf | High |

⚠ The old research file stated CB 249A HC is "not on the current site". **That is wrong** -
https://www.bremagroup.it/prodotti_brema/cb249-hc/ is live and returns a full spec table.
CB246 HC is a separate, smaller machine, not a successor rename.

Supporting sources:

https://www.bremagroup.it/prodotti_brema-sitemap.xml
https://www.bremagroup.it/prodotti_brema-sitemap2.xml
https://www.bremagroup.it/documentazione/
https://www.bremagroup.it/en/documentation/
https://www.bremagroup.it/wp-content/uploads/2026/05/CATALOGO-BREMA-2026_ENG.pdf
https://www.bremagroup.it/wp-content/uploads/2024/10/LEAFLET-ICE-CUBE-2025_ITA-ENG.pdf
https://www.bremagroup.it/wp-content/uploads/2025/02/FLYER-R290-2025-ENG.pdf
https://www.bremagroup.it/doc-prodotti/manuali-duso/241647_rev3_CB%20HC_SL%20R290_ECP%20NG.pdf
https://www.barstuff.com/brema-ice-maker/
https://ahlia.store/products/cb-640-brema

---

## 9. Recommended changes (nothing applied)

1. 🔴 **Refrigerant: set R290 on all five.** Any copy repeating SAP's R404A/R452A is wrong,
   and this one matters for safety and servicing - section 2.
2. 🔴 **CB 1565A HC (IMG/REF/00076)** is still `status: draft` with `image: ""`. It now has an
   800 px image and a full official datasheet, so it is ready to publish if the business wants
   it live.
3. 🟠 **Do not rewrite the cube spec to "23 g B-Qube"** as the old research proposed - our SKUs
   are the ICE CUBE cone trim per SAP - section 6.
4. 🟠 **Power figures**: 249A 270 W, 416A 450 W, 640A 590 W, 955A 870 W, 1565A 1280 W.
5. 🟡 Add net/gross weights, packed dimensions and bin capacities - all now available.
6. 🟡 **CB 1565A HC production**: datasheet Rev.04 says 160 kg/24 h, website says 152 kg.
   Needs a decision, not a blind edit.
7. ⚪ No `model_number` change proposed on any SKU. No `brands.json` change needed.

---

## Archived brand research

> Merged in from the former `research/old/` folder on 2026-08-12, when the two folders were
> consolidated. This is the earlier **specs and codes** pass; everything above it
> is the later **sourcing and provenance** pass. The text is unchanged apart from
> heading levels, which were demoted one step to keep a single outline.

## Brema Product Research

Research notes behind a BREMA enrichment/audit pass on `products.json` (July 2026).
Covers all 5 BREMA SKUs, all ice cube machines: CB 249A HC, CB 416A HC, CB 640A HC,
CB 955A HC, and CB 1565A HC — a single product line at five capacity tiers.

**No `products.json` changes have been applied yet** — this file is findings only, same
starting point as the other brand-research files before a scope decision.

---

### 1. Brand identification

**Brema** = **Brema Group S.p.A.**, an Italian ice-machine manufacturer. `brands.json`
already has the correct entry (`slug: brema`, `website_url: https://www.bremaice.it`) —
that URL is real but **redirects** (301) to the current corporate domain:
**`https://www.bremagroup.it/brema/`**. Not a broken link, just an old domain kept alive
as a redirect; no `brands.json` change needed.

Product pages live under `https://www.bremagroup.it/prodotti_brema/<model-slug>/`, e.g.
`.../cb-640a-hc-b-qube-2-0-wi/`. The English CB1565 page uses a different URL shape:
`https://www.bremagroup.it/en/brema_products/cb1565/`.

---

### 2. The "2.0 Wi" generation trap

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

### 3. Per-SKU findings

#### 3.1 CB 249A HC (IMG/REF/00081) — record has no description/spec at all; legacy code, sourced from resellers

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

#### 3.2 CB 416A HC (IMG/REF/00082) — confirmed correct, but width/height axes are swapped

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

#### 3.3 CB 640A HC (IMG/REF/00154) — same width/height swap, otherwise confirmed

- Stored: `length: 735, width: 850, height: 603`; prose says "Length 735, Width 603,
  Height 850" — again internally contradictory.
- Official (`cb-640a-hc-b-qube-2-0-wi`): **735 × 610 (depth) × 849 mm (height)**. Same
  swap as CB-416A: stored `width` (850) is really the height; stored `height` (603) is
  really the depth (610, within rounding).
- Add: net/gross weight 67/79 kg, cube size 23g, power 590W, refrigerant R290,
  60kg/24h→ actually official states 72kg/24h (stored "67 kg/24h" close but not exact -
  see §4), 40kg bin (stored figure already correct).

#### 3.4 CB 955A HC (IMG/REF/00181) — dimensions NOT swapped this time; description already good

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

#### 3.5 CB 1565A HC (IMG/REF/00076) — draft, empty image, no content at all; two generations found

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

### 4. Cross-cutting notes

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

### 5. Product reference

| SKU | Catalogue name | Model | Official page | Independent source | Confidence |
|---|---|---|---|---|---|
| IMG/REF/00081 | Ice Cube Machine CB-249A Brema | CB 249A HC | not on current site (legacy code, §2) | https://www.barstuff.com/brema-ice-cube-maker-cb-series-249a-hc-ice-cone-29-kg-13558 | Medium — independent reseller only, no current official page for this exact code |
| IMG/REF/00082 | Ice Cube Machine CB-416A Brema | CB 416A HC | https://www.bremagroup.it/prodotti_brema/cb-416a-hc-b-qube-2-0-wi/ | same | **High** — official page, exact code match |
| IMG/REF/00154 | Ice Cube Machine CB-640A Brema | CB 640A HC | https://www.bremagroup.it/prodotti_brema/cb-640a-hc-b-qube-2-0-wi/ | same | **High** — official page, exact code match |
| IMG/REF/00181 | Ice Cube Machine CB 955A HC Brema | CB 955A HC | https://www.bremagroup.it/prodotti_brema/cb-955a-hc-b-qube-2-0-wi/ | same | **High** — official page, exact code match |
| IMG/REF/00076 | Ice Cube Machine CB-1565A Brema | CB 1565A HC | https://www.bremagroup.it/en/brema_products/cb1565/ | https://www.ipckitchens.com/product/brema-cb-1565a-ice-cube-maker-prod-cap-155kg-day-storage-65kg-voltage240v-50hz-1ph-dim-840x740x1075/ | **High** on dims/capacity — official + reseller agree; power/refrigerant generation-dependent (§3.5) |

---

### 6. Restructure pass applied (July 2026) — "safe changes only" scope

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

### 7. Image sourcing (July 2026) — downloaded to `Downloads/brema-images/`

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

#### Bonus data fix while on the pages
The 955A official page (seen directly while extracting images) shows **95 kg / 24 h** ice
output — a figure the record previously lacked. Added to CB 955A HC's short description,
Key Features and spec table (the 640A page likewise re-confirmed its 72 kg, already applied
in §6).
