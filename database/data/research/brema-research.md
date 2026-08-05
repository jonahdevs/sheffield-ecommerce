# Brema Product Research

Supersedes `old/brema-research.md` (July 2026), which predates the SAP export and reached
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
