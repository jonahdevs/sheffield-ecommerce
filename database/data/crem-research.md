# CREM / Coffee Queen Product Research

Research notes behind the CREM enrichment pass on `products.json` (July 2026). Covers the
**9 CREM SKUs** in the catalogue - all filter-coffee brewers and serving/servery equipment.
Data was sourced from CREM's official sites (crem.coffee, cremtechnical.co.uk), Parts Town,
and cross-checked against European resellers.

---

## 1. Brand structure

**CREM International** (an Ali Group company, HQ Barcelona; heritage in Sweden) owns several
coffee brands. The line in this catalogue is the old **Coffee Queen** filter-coffee and
servery range, which CREM now markets simply as **"Crem"** (crem.coffee). The machines are
unchanged; only the badge and, increasingly, the marketing photography have moved from
"Coffee Queen" to "Crem" livery.

| Name | What it is | Site |
|---|---|---|
| **CREM International / Crem** | Parent brand, current | crem.coffee, creminternational.com |
| **Coffee Queen** | Legacy brand for these filter/servery products | (folded into Crem) |
| **cremtechnical.co.uk** | UK technical/spares site - per-article pages, manuals, PDFs | cremtechnical.co.uk |

Always match on **article number** (the 7-digit `1xxxxxx` codes) or model, not the badge.
Model names were renamed in the rebrand (e.g. **Coffee Queen M-2 -> Crem M2**).

---

## 2. Cross-cutting notes

### The servery ecosystem
Several of these SKUs are **accessories that pair with the brewers**, not standalone
machines:
- Brewers (Single Cater `1008620`, M2 `CQM2`) brew **into** a serving vessel.
- Serving stations (`1103303` 2.5 L, `1103302` 5 L) and airpots (`1103184` 2.2 L) are the
  vessels; the brew-through lid lets coffee brew straight into them.
- The V-2 warming plate (`1001120`) and glass decanter (`110001`) support the decanter-style
  brewers.
- The 2.5 L / 5 L serving stations are listed as compatible with the **Mega Gold and Cater**
  brewers (cremtechnical Q1103303).

### Voltage
Kenya is 230-240 V / 50 Hz. The decanter brewers and servery items are single-phase 230 V.
The one caution is the **Single Cater** (see §5.1) - a "single tower/cater" name is used for
both a single-phase ~2.5 kW unit and a 3-phase 9 kW bulk tower; they are different machines.

### Not published - do not invent
- No independent spec sheet was found tying article **1103256** (00012) to a product.
- No weight is published for the 2.5 L serving station on the official page (~3 kg is an estimate).
- The 5 L serving-station dimensions disagree between sources (see §6).

---

## 3. Corrections applied to `products.json`

| SKU | Field | Was | Now |
|---|---|---|---|
| IMG/COF/00004 | tech spec + dims | `380 V 3-ph, 0.75 kW, 2x5 L, 350 cups/hr` - internally impossible (0.75 kW cannot brew 350 cups/hr) and it **contradicted the record's own description** | Rebuilt from the record's own description: **2,500 W, 220-240 V single phase**, ~4.5 min full/half brew, brews into a removable vacuum serving station. Width/height fields were swapped - corrected to 205 x 420 x 675 mm |
| IMG/COF/00006 | description + tech spec | marketing prose, no specs, no spec table | Verified **M2** specs: 2 x 1.8 L glass decanters, twin individually-switched warming plates, 2,400 W / 230 V, ~6 min/batch (~17 L/h), ~8.5 kg, 205 x 360 x 430 mm. Added spec table, meta, dimensions |
| IMG/COF/00011 | dims + tech spec | width=400/height=150 (swapped), spec was a broken `<ul>` with an empty LENGTH | 140 x 140 x 400 mm (dia x H), 1.8 kg; proper spec table (2.2 L vacuum airpot, pump lid, sight gauge, stainless) |
| IMG/COF/00012 | description | **copy-pasted from the decanter** (IMG/COF/00008): "DECANTER 110001; 1.8 litres; Glass Decanter..." | Replaced with a stainless-steel thermal-server description; no invented specs. Article 1103256 flagged unresolved (§5.5) |
| IMG/COF/00013 | description + tech spec | both `null` (empty) | Full description + spec table: **V-2** double warming plate, 2 plates, stainless, 190 W, 230 V, 360 x 190 x 60 mm |
| IMG/COF/00009, 00010 | copy | "compatible with CREM Mega Gold brewers" | "Mega Gold **and Cater** brewers" (per cremtechnical Q1103303) |

**Model numbers were NOT changed** in this pass - see §5.

---

## 4. Product reference

| SKU | Catalogue name | Catalogue model | Verified identity | Best source |
|---|---|---|---|---|
| IMG/COF/00004 | Coffee Brewer Single Cater | `1008620` | Coffee Queen **Cater Single** automatic filter brewer (brews into a removable vacuum serving station) | record's own description (internally consistent); [coffeeworks single tower](https://www.coffeeworks.co.th/product/crem-single-tower-brewer/); [manualzz cater single](https://manualzz.com/doc/54073124/coffee-queen-cater-single-manual-de-usuario) |
| IMG/COF/00006 | Coffee Brewer with 2 Decanter | `CQM2` | **Crem M2** (formerly Coffee Queen M-2) | [Moor Coffee](https://www.moorcoffee.co.uk/product/coffee-queen-m2-filter-coffee-machine/), [Fridgeland](https://fridgeland.co.uk/crem-coffee-queen-m2), [Kaffegrossisten M2 TK](https://www.kaffegrossisten.com/coffe-brewers/crem/crem-m2-tk) |
| IMG/COF/00007 | Cup Dispenser | (none) | Generic cup dispenser - not a Coffee Queen catalogue item; archived, price 0 | none |
| IMG/COF/00008 | Decanter 1.8 Litres CREM | `110001` | Crem 1.8 L glass decanter (genuine replacement) | existing record (consistent) |
| IMG/COF/00009 | Serving Station 2.5 Litres | `1103303` | Coffee Queen serving station 2.5 L (Q1103303) | [cremtechnical Q1103303](https://www.cremtechnical.co.uk/Q1103303.html), [Monteriva](https://www.monteriva.com/serving-station-2-5-liters-1103303) |
| IMG/COF/00010 | Serving Station 5 Litres | `1103302` | Coffee Queen serving station 5 L (Q1103302) | [Parts Town Q1103302](https://www.partstown.co.uk/coffee-queen/cemq1103302) |
| IMG/COF/00011 | Air Pot with Sight Gauge | `113184` | Coffee Queen 2.2 L airpot with sight gauge (**Q1103184**) | [Parts Town Q1103184](https://www.partstown.co.uk/coffee-queen/cemq1103184), [cremtechnical Q1103184](https://www.cremtechnical.co.uk/Q1103184.html) |
| IMG/COF/00012 | Thermos Percolator SS | `1103256` | **UNRESOLVED** - article 1103256 not found on any Crem/Coffee Queen source | none |
| IMG/COF/00013 | Warming Plate Double | `CQ V-2 1001120` | Coffee Queen/Crem **V-2** double warming plate | [crem.coffee V-2](https://www.crem.coffee/product/fam_elxxii), [exflo CQ V2](https://www.exflo.com.au/product/75664-cq-v2-warming-plate-2-plate-) |

---

## 5. Model-number flags (NOT changed - awaiting approval)

Per catalogue policy, `model_number` is the product's tracking ID and is not altered without
sign-off. The following are researched recommendations only:

### 5.1 IMG/COF/00004 - `1008620` (Single Cater)
Two different machines are marketed under a "single tower/cater" name:
- a **single-phase ~2,500 W** unit that brews into a removable serving station (matches this
  record's own description), and
- a **3-phase 9,000 W** bulk tower (200 cups/hr, 5 L station, ~551 x 500 x 950 mm - coffeeworks).

The enrichment used the **single-phase reading**, because the record's description states
"AC 1-phase: 2500 W", 220 V, 4.5 min, full/half brew - internally consistent. The old spec
table (380 V / 0.75 kW / 350 cups) was discarded as corrupted. **Confirm against supplier
paperwork** whether the shipped machine is the single-phase Cater or the 3-phase tower; the
specs differ entirely.

### 5.2 IMG/COF/00011 - `113184` should be `1103184`
`113184` is a **truncated typo**. The Coffee Queen 2.2 L airpot with sight gauge is article
**`1103184`** (Q1103184 on Parts Town and cremtechnical). Recommend correcting `113184 -> 1103184`.

### 5.3 IMG/COF/00006 - `CQM2`
`CQM2` is a distributor-style code, not a Crem article number. The machine is the **M2**
(Coffee Queen M-2). Keep `CQM2` as an internal tracking code, or replace with the supplier's
M2 article number if provided.

### 5.4 IMG/COF/00013 - `CQ V-2 1001120`
Combines model (`V-2`) and article (`1001120`) in one field. Accurate; optionally split into
model `V-2` with a note that the article is `1001120`.

### 5.5 IMG/COF/00012 - `1103256` UNRESOLVED
Article `1103256` returns nothing on crem.coffee, cremtechnical.co.uk, Parts Town, or any
reseller. The original record was also internally inconsistent (named "Thermos Percolator SS"
but described as a glass decanter copied from IMG/COF/00008). **Confirm the real article
number and the actual product** (stainless thermos server vs glass pot). Nearby real codes:
`1002190` (1.9 L Office Thermos), `1103184` (2.2 L airpot).

---

## 6. Open questions / conflicts

- **5 L serving station (00010) dimensions.** `products.json` carries 205 x 460 x 545 mm /
  ~4 kg; Parts Town lists **280 x 280 x 470 mm / 5 kg** for Q1103302. The catalogue figures
  were kept; confirm against the physical unit.
- **2.5 L serving station (00009) weight** is an estimate (~3 kg) - not published officially.
- **Cup Dispenser (00007)** has no model and is archived at price 0; likely not a genuine
  Coffee Queen product. Left untouched.

---

## 7. Image sourcing

Ranked by reliability:

1. **crem.coffee** - official, current Crem branding. Product pages for M2, Mega Gold, V-2
   warming plate, serving stations.
2. **cremtechnical.co.uk** - per-article pages (`Q1103303`, `Q1103184`, ...), spec-sheet PDFs,
   and full manuals under `/user/MANUALS/` (e.g. the TK-Series filter-brewer manual,
   `1964230_02_...pdf`). Consistently reachable.
3. **partstown.co.uk** - per-article pages that carry dimensions/weight (`Q1103302`, `Q1103184`).
4. **Resellers** - barista-shop.gr, moorcoffee.co.uk, caterkwik.co.uk, fridgeland.co.uk,
   equipmentcafe.co.za. Good photography; **check for reseller branding** before use.

Note: much Coffee Queen photography has been re-shot in **Crem** livery - the machine is
identical, so either badge is fine as a source.

---

## 8. Official crem.coffee verification (July 2026)

Browsed crem.coffee's live catalogue and Document Finder directly and pulled the official
Welbilt/CREM spec-sheet PDFs (`assets.welbilt.com`). This resolves several of the open
questions above with primary-source data and **has been applied to `products.json`**.

### 8.1 What's actually still sold today

The current **Filter Manual** range on crem.coffee has exactly three product lines:
**Tower / Single Tower**, **Mega Gold** (M/A + TK-Series), and **Thermos / Thermos Office**
(M/A + TK-Series). Searching the site (Products and Downloads tabs) for `M2` and for the
unresolved article `1103256` returned **zero results** in both cases - neither is a current,
independently-listed product on the marketing site.

However, the **Document Finder** (`/Resources#Document-Finder`) lists a wider legacy product
list than the marketing pages show, including **M-1 1.8L** and **M-2 1.8L TK**, each with a
downloadable spec sheet. So M2 (our `CQM2`, IMG/COF/00006) is a real, documented CREM model -
just not actively marketed as its own product page anymore. Confirms §5.3's read.

### 8.2 Official spec sheets pulled (source of the corrections below)

| Product | Spec sheet | PDF asset |
|---|---|---|
| M1 / M2 / A2 / DM4 / DA4 ("1.8l Brewers") | `1-8l-Brewers-Sheet-EN.pdf` | assets.welbilt.com/asset/2209dbeb-.../1-8l-Brewers-Sheet-EN.pdf |
| Mega Gold | `Mega-Gold-Sheet-EN.pdf` | assets.welbilt.com/asset/4cb7ea46-.../Mega-Gold-Sheet-EN.pdf |
| Serving Station (2.5L & 5L) | `Serving-Station-Product-Sheet-EN.pdf` | assets.welbilt.com/asset/1acd5b2e-.../Serving-Station-Product-Sheet-EN.pdf |
| Tower & Single Tower | `Tower-Product-Sheet-EN.pdf` | assets.welbilt.com/asset/e4a8d219-.../Tower-Product-Sheet-EN.pdf |
| Thermos & Thermos Office | `Thermos-Product-Sheet-EN.pdf` | assets.welbilt.com/asset/7aa69fc2-.../Thermos-Product-Sheet-EN.pdf |

### 8.3 Corrections applied to `products.json` (this pass)

| SKU | Field | Was | Now (official) |
|---|---|---|---|
| IMG/COF/00006 (M2) | power / output | 2,400 W, ~17 L/h | **2,200 W, 15 L/h** (official M2 row: 220-230V, 2200W, 50-60Hz, 15 l/h) |
| IMG/COF/00006 (M2) | weight | ~8.5 kg | **7 kg** |
| IMG/COF/00006 (M2) | dimensions | 205 × 360 × 430 mm | **205 × 410 × 428 mm** (W×D×H per official sheet) |
| IMG/COF/00009 (Serving Station 2.5L) | dimensions | 205 × 360 × 430 mm - this was a **copy-paste of the M2's dims**, not the serving station's own | **206 × 274 × 436 mm** (W×D×H) |
| IMG/COF/00009 (Serving Station 2.5L) | weight | ~3 kg (estimate, flagged unpublished) | **3.10 kg** (now officially published) |
| IMG/COF/00010 (Serving Station 5L) | dimensions | 205 × 460 × 545 mm (products.json) vs 280 × 280 × 470 mm (Parts Town) - conflicting, neither official | **325 × 373 × 483 mm** (W×D×H, official CREM sheet - supersedes both prior figures) |
| IMG/COF/00010 (Serving Station 5L) | weight | ~4 kg | **5.10 kg** |

Full official spec tables, for reference:

**M2 (Original Line, non-TK):** 220-230V, 2200W, 50-60Hz · manual water refill · 2 hot plates ·
2 × 1.8L decanter · 15 L/h · <6 min brew · not ECBC approved (only the TK-Series is) ·
428×205×410mm (H×W×D) · 7 kg.

**Mega Gold M / A** (brews into the 2.5L serving station - *not* the same machine as our
IMG/COF/00004, see §8.4): 655×205×410mm (H×W×D) · M: 9.6 kg, A: 10.2 kg · 220-230V, 2200W,
50-60Hz · 19 L/h · <8 min · M is manual-refill only, A adds automatic refill + cold-water
connection.

**Tower / Single Tower:** 400V 3N~ 9000W 50/60Hz, automatic refill, cold-water connected.
Tower: 934×928×500mm, 53 kg, 2×5L serving stations, 350 cups/h. Single Tower: 934×610×500mm,
41 kg, 1×5L serving station, 175 cups/h. Both <7 min brew, ECBC approved.

**Thermos Office / M / A:** all 220-230V, 2200W, 50-60Hz, 15 L/h. Office: 428×205×410mm, 6.4 kg,
brews into a 1.9L thermos, <6 min. M: 557×205×410mm, 7.9 kg, 2.2L pump thermos, <8 min,
manual refill. A: same dims, 8.5 kg, manual/automatic refill + cold-water connection.

**Serving Station 2.5L / 5L:** 2.5L is 436×206×274mm (H×W×D), 3.10 kg. 5L is 483×325×373mm
(H×W×D), 5.10 kg. Both stainless-steel-lined, tap + level-indicator tube, optional lid cover.

### 8.4 §5.1 (Single Cater / IMG/COF/00004) - now resolved, not just flagged

The official **Single Tower** spec (400V 3-phase, 9,000 W, 175 cups/h, 41 kg, brews into a 5L
serving station) is confirmed as a real, current, high-capacity catering machine - completely
different from IMG/COF/00004's own single-phase 2,500 W / 4.5-minute description. This confirms
the enrichment's original call was right: **IMG/COF/00004 is not the current Single Tower**, and
it isn't the current Mega Gold either (Mega Gold is 2,200 W / <8 min into a 2.5L station, still
not a match). IMG/COF/00004 remains a smaller, likely-discontinued "Cater Single" model that
CREM no longer lists - its own record stays the best available source for its specs.

### 8.5 §5.5 (1103256 / IMG/COF/00012) - still unresolved

Confirmed via direct site search: crem.coffee's Products and Downloads search both return zero
results for `1103256`. Accessories/parts by article number simply aren't indexed on the
marketing site (only whole machines get product pages + spec sheets) - `cremtechnical.co.uk`
remains the only lead for this article number, and it was already exhausted in the original
pass. No new information; still needs supplier paperwork to resolve.

### 8.6 Images

No usable new product photography came out of this pass for the catalogue's actual SKUs: the
official product photos found (Mega Gold, Tower, Single Tower, Thermos brewers) belong to
machines that are confirmed **not** the same models as IMG/COF/00004 or IMG/COF/00006 (see
§8.4), so applying them would mislabel the product. The one photo that would have applied -
a standalone Serving Station product shot - only exists embedded inside the PDF spec sheet, not
as a linkable web image. Existing SKU photography is left untouched.
