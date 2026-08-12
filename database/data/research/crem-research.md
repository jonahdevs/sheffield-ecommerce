# CREM / Coffee Queen - product research

> **This file supersedes the archived research below.**
> The archived file's §8.6 concluded that no usable product photography could be sourced for this
> brand. **That conclusion is overturned.** Eight of the nine CREM SKUs now have verified,
> article-proven photography, four of them at 2000 x 2000 px. Its §5.5 ("article `1103256`
> UNRESOLVED, not found on any Crem/Coffee Queen source") is also overturned - the article resolves on
> CREM's own site under a name slug rather than an article-number URL.
> The archived file's warning that **crem.coffee's brewer marketing pages show different machines**
> remains correct and was respected.

Covers the **9 CREM SKUs** in the catalogue: two filter brewers and seven servery items.
Staged imagery, spec sheets and the sourcing ledger live in
`Desktop\ecommerce\products resorce final\crem\` (`_sourced.json`, `_FINDINGS.md`, `_brand-reference\`).

---

## 1. Brand structure

**CREM International** (Ali Group / Welbilt, HQ Barcelona, heritage in Sweden) owns the old
**Coffee Queen** filter-coffee and servery range and now markets it as **Crem**. The machines are
unchanged; only the badge moved. Three liveries appear on genuine product photography, all of the
same parts:

| Livery | Where it appears |
|---|---|
| **COFFEE QUEEN of Sweden** (gold oval, black) | oldest - Cater/Tower manuals, serving stations |
| **COFFEE QUEEN ORIGINAL** (gold oval) | the M2, the 1.8 L decanter, the V-2 warming plate |
| **CREM** (white wordmark) | current - same decanter, same 5 L serving station |

**Always match on the article number, never the badge.** CREM articles are 7 digits (`1xxxxxx`);
cremtechnical prefixes them with `Q`.

### Where the data lives

| Site | What it gives | URL |
|---|---|---|
| cremtechnical.co.uk | per-article pages, manuals, brochures, the "Equipment Photos" gallery | https://www.cremtechnical.co.uk/ |
| partstown.co.uk | per-article pages with weights/volumetrics, **2000 px images** | https://www.partstown.co.uk/manufacturers/coffee-queen |
| firstchoice-cs.co.uk | Parts Town UK under a different skin (same media host) | https://www.firstchoice-cs.co.uk/ |
| kaffe-rep.se | Swedish Crem specialist; **filenames carry the article number**, exploded parts drawings | https://kaffe-rep.se/ |
| crem.coffee | current marketing; accessory product pages are usable, **brewer pages are not** | https://www.crem.coffee/ |

**Finding pages on cremtechnical: use the sitemap, not the search box.** The on-site search returns
nothing. https://www.cremtechnical.co.uk/sitemap.xml lists 3,127 URLs. Note that **not every product
lives at `/Q<article>.html`** - several use a name slug (`thermos-19l.html`, `m2.html`,
`mega-gold-m.html`), which is exactly why an article-number URL probe declared `1103256` unresolvable
in the previous pass. Also mind rate limiting: about a dozen concurrent requests earns a blanket
403 for several minutes. Fetch serially.

---

## 2. Product reference

| SKU | Catalogue name | Catalogue `model_number` | Verified identity | CREM article |
|---|---|---|---|---|
| IMG/COF/00004 | Coffee Brewer Single Cater | `1008620` | Coffee Queen **SINGLE CATER** | **1008620** confirmed |
| IMG/COF/00006 | Coffee Brewer with 2 Decanter | `CQM2` | Coffee Queen Original **M-2** | **1002310** |
| IMG/COF/00007 | Cup Dispenser | *(none)* | not a CREM product - see §6 | none exists |
| IMG/COF/00008 | Decanter 1.8 Litres CREM | `110001` | Crem / Coffee Queen 1.8 L glass decanter | **110001** confirmed |
| IMG/COF/00009 | Serving Station 2.5 Litres | `1103303` | Serving Station 2.5 L | **1103303** confirmed |
| IMG/COF/00010 | Serving Station 5 Litres | `1103302` | Serving Station 5 L | **1103302** confirmed |
| IMG/COF/00011 | Air Pot with Sight Gauge | `113184` | Thermos Airpot 2.2 L stainless | **1103184** (ours is truncated) |
| IMG/COF/00012 | Thermos Percolator SS | `1103256` | **Thermos jug 1.9 L stainless** - not a percolator | **1103256** confirmed |
| IMG/COF/00013 | Warming Plate Double | `CQ V-2 1001120` | Coffee Queen **V-2** double warming plate | **1001120** confirmed |

### The servery ecosystem

CREM's own compatibility statements, quoted:

* 1.8 L glass decanter `110001` - *"Filter machines, **M2**"* (https://www.cremtechnical.co.uk/Q110001.html)
* Serving station 2.5 L `1103303` - *"for use on Coffee Queen brewers including the **Mega Gold and
  Cater** machines"* (https://www.cremtechnical.co.uk/Q1103303.html)
* Serving station 5 L `1103302` - *"for use on Coffee Queen bulk brewer **single and double Tower**
  machines"* (https://www.cremtechnical.co.uk/Q1103302.html)
* Airpot 2.2 L `1103184` - *"for use on the **Thermos** filter brew machine"*, fits Thermos M / Thermos A
  (https://www.cremtechnical.co.uk/Q1103184.html)
* Thermos jug 1.9 L `1103256` - the vessel the **Thermos Office** (`1002190`) brews into
* V-2 warming plate `1001120` - takes two 1.8 L decanters, i.e. the M2's consumables

So `IMG/COF/00006` (M2), `IMG/COF/00008` (decanter) and `IMG/COF/00013` (V-2) are one family, and
`IMG/COF/00004` (Cater) pairs with `IMG/COF/00009` (2.5 L station).

---

## 3. Verified specifications

### 3.1 IMG/COF/00004 - SINGLE CATER, article `1008620`

Source: CREM CATER user manual, part no. **1704173-02**, pp. 5 and 20 -
https://www.cremtechnical.co.uk/user/NEW_cater_user_manual_en_MM_18.pdf

| | SINGLE CATER | CATER (twin, not ours) |
|---|---|---|
| Height | **690 mm** | 690 mm |
| Width | **205 mm** | 410 mm |
| Depth | **450 mm** | 450 mm |
| Tank volume | **2.5 L** | 2 x 2.5 L |
| Power | **230 V 1N / 2200 W** | 400 V 2N / 4400 W |
| Capacity | **17 cups / 6 min**; hot water 20 L/h | 34 cups / 6 min |
| Serving station | **1 x 2.5 L**, removable | 2 x 2.5 L |
| Weight | **15 kg** | 24 kg |
| Brew options | 2 (full / half) | 2 |
| Water | automatic fill, cold-water connection | same |

Manual p20 also gives tap height 105 mm and serving-station clearance 436 mm. Manual p6 labels the
serving station's level indicator as the **"Level Tube"**, which is what our SAP remark's "level
indicator" refers to.

**Corrections this implies (not applied):** SAP/our record's **2500 W is wrong - it is 2200 W**, and
"brewing time only **45 minutes**" is a mangled **4.5-6 minutes**. Depth 450, not 420; height 690, not 675.

This is emphatically **not** the current 400 V 3N 9000 W **Single Tower** (934 x 610 x 500 mm, 41 kg,
5 L station) - a separate, still-current machine. The archived research reached the same conclusion
and it stands.

### 3.2 IMG/COF/00006 - M-2, article `1002310`, dealer code `CQM2`

Two CREM documents, both staged:

* **M2 Double Hot Plate Brewer product sheet** (Coffee Queen Original livery) -
  https://www.moorcoffee.co.uk/wp-content/uploads/2019/07/CQ-M2PDF.jpg
  W **205** / H **430** / D **360** mm - 230 V 1P+N / **2390 W** - **15 L/h** - approx 6 min brew -
  2 x 85 W Teflon-coated hot plates - full stainless construction, stainless boiler with overheat
  protection, brewing lamp, stainless filter basket - manual water filling.
  Supplied with: 1 filter basket, **2 x 1.8 L glass decanters**, 1 mains lead, 25 filter papers.
* **Original Line M user manual**, part no. **1764022_01** -
  https://www.cremtechnical.co.uk/user/1764022_01_Original_Line_M_User_EN.pdf
  M-2 row: 428 H x 205 W x 410 D mm, 1.8 L, 220-230 V 1N ~ **2390 W** 50-60 Hz, **12 cups** per brew,
  **15 L/h**, 6 min, **2 hot plates**, **9 kg**. Its p23 dimension sketch gives A 595 / B 205 /
  C 410 / D 428 / E 578 / **F 360** mm - so CREM quotes the depth as both 410 (overall) and 360
  (body), which is where our record's 360 comes from.

**CREM contradicts itself on power and weight.** The 2018-era marketing spec sheet cited in the
archived research said 2200 W / 7 kg. The two documents that name the **M-2 specifically** both say
**2390 W** and (the manual) **9 kg**. An independent Crem dealer says 2400 W / 8.5 kg
(https://equipmentcafe.co.za/product/coffee-queen-m2-filter-machine/). Recommend 2390 W, ~9 kg.

Our SAP remark's "14.8 litres per hour" and "12 cups per load" match CREM's 15 L/h and 12 cups.

### 3.3 IMG/COF/00013 - V-2 double warming plate, article `1001120`

https://kaffe-rep.se/produkt/coffee-queen-varmehall-v-2/ - **Artikelnr 1001120**, 240 V, **190 W**,
capacity 2 x 1.8 L decanters, **W 360 x H 60 x D 190 mm**. Stainless plinth, two independently
switched Teflon plates. Confirmed by CREM's own product page,
https://www.crem.coffee/product/fam_elxxii .

Every figure in our record checks out. Note the coincidence that the SAP remark's wattage (190 W) and
the real depth (190 mm) are the same number.

### 3.4 The servery items

| SKU | Article | CREM / distributor figures | Weight |
|---|---|---|---|
| IMG/COF/00008 | `110001` | Parts Town 210 x 150 x 160 mm; kaffe-rep H ~165, widest ~145, base ~100 | **405-450 g** |
| IMG/COF/00009 | `1103303` | Parts Town 220 x 220 x 440; CREM product sheet 436 x 206 x 274; CREM UK brochure H 430 / D 360 / W 205 | **2.5 kg** (cremtechnical) / 1 kg (Parts Town) / 3-3.1 kg (CREM sheets) |
| IMG/COF/00010 | `1103302` | Parts Town 280 x 280 x 470; CREM product sheet 483 x 325 x 373; CREM UK brochure H 545 / D 460 / W 280 | **5 kg** (cremtechnical + Parts Town) |
| IMG/COF/00011 | `1103184` | Parts Town 140 x 140 x 400; kaffe-rep 160 W x 412 H x 200 D | **1.8 kg** (Parts Town) / 2.04 kg (cremtechnical) |
| IMG/COF/00012 | `1103256` | not published | **382 g** (cremtechnical) |

The serving-station dimension disagreement is **CREM against CREM** and is not resolvable from public
data - see `_FINDINGS.md` §7. The current record holds the product-sheet figures, which is the
defensible choice; the UK brochure's 2.5 L "depth 360 mm" is identical to the Grinder Original's in
the adjacent column and looks like a copy-down error in CREM's own table.

---

## 4. `model_number` flags - recommendations only, nothing changed

### 4.1 IMG/COF/00011 - `113184` should be `1103184`

`113184` (six digits) does not exist. The Coffee Queen 2.2 L stainless airpot is CREM article
**`1103184`** (seven digits), attested three ways:

* https://www.cremtechnical.co.uk/Q1103184.html - "Part Number: 1103184"
* https://www.partstown.co.uk/coffee-queen/cemq1103184 - "Mfr Part Number Q1103184"
* https://kaffe-rep.se/produkt/coffee-queen-pumptermos-2-2l/ - "Artikelnr: 1103184"

**`113184 -> 1103184`. ✅ APPLIED 2026-08-05**, approved by the user. `products.json` now carries
the seven-digit article number; nothing else on the record was touched.

*Note on `1103183`:* CREM's own Q1103184 page serves an image file named `1103183_thermos_2_2l.jpg`.
This is asset naming, not a different product - `1103183` has no page of its own and does not exist at
Parts Town, and the independently named kaffe-rep file `1103184_Thermos_2.2L.jpg` shows the same
airpot.

### 4.2 IMG/COF/00011 - **the "Sight Gauge" in the name is not real**

Three independent photographs covering roughly 270 degrees of the body (Parts Town 2000 px, kaffe-rep
800 px, cremtechnical 500 px) show an **unbroken brushed-stainless shell with no sight glass, window
or level scale**. Parts Town and kaffe-rep describe no level feature at all; only CREM's own
one-liner says "with level indicator", which most plausibly means the graduated dial on the lid cap.

Meanwhile CREM *does* say "complete with **sight gauge** and tap" for the two serving stations, and
the Cater manual labels their part the **"Level Tube"**. The claim has drifted across families.

**Recommend removing "with Sight Gauge" from the `IMG/COF/00011` name and description**; keep it on
`IMG/COF/00009` and `IMG/COF/00010`. Not applied.

### 4.3 IMG/COF/00012 - the article is right, the **name** is wrong

`1103256` is a genuine CREM article and should not be touched. But it is **"Thermos 1.9L Stainless"**
(CREM), **"1.9l Stainless Steel Thermos Jug"** (Parts Town), **"Termoskanna 1,9 l"** (two Swedish
dealers) - a passive double-walled vacuum serving jug weighing **382 g**. It is not a percolator and
has no electrics. The archived research already spotted that the record's description had been
copy-pasted from the decanter; the *name* is the remaining error.

**Recommend renaming to "Thermos Jug 1.9 L Stainless Steel"** (or "Thermal Server 1.9 L").
Not applied.

### 4.4 IMG/COF/00006 - `CQM2` is fine, keep it

`CQM2` is not a corrupted article number. An independent Crem dealer in South Africa sells the M2
under literally `SKU: CQM2` with dimensions 205 x 360 x 430 mm - the same code and the same numbers
our SAP row carries (https://equipmentcafe.co.za/product/coffee-queen-m2-filter-machine/). It is a
regional dealer code. The CREM article behind it is **`1002310`**; record that in the description or a
spec row rather than replacing `CQM2`.

### 4.5 IMG/COF/00013 - `CQ V-2 1001120`

Combines the model (`V-2`) and the article (`1001120`). Both are correct. Optionally split, but there
is nothing wrong with it.

### 4.6 IMG/COF/00007 - **do not invent a code**

SAP: Make `CREM`, Model `-`, description `CUP DISPENSER:`, remark `Cup Dispenser:`, stock 1, no
dimensions, no weight. Our record is archived with `model_number: null`. CREM/Coffee Queen have never
published a cup dispenser: zero matches for "dispens" across all 3,127 cremtechnical sitemap URLs and
none on either page of its Accessories listing. Almost certainly a local-purchase generic that
inherited the CREM make code. **Left untouched.**

---

## 5. SAP notes for this brand

**SAP's dimension ORDER is not stable within CREM.** Its nine rows use at least three different
orders, established by matching each row's own remark against its own dimension fields:

| SKU | SAP triple | Manufacturer | Order actually used |
|---|---|---|---|
| 00004 `1008620` | 420 / 205 / 675 | W 205, D 450, H 690 | **D, W, H** |
| 00006 `CQM2` | 360 / 205 / 430 | W 205, D 360, H 430 | **D, W, H** (exact) |
| 00008 `110001` | 170 / 160 / - | H ~165, W ~145 | **H, W** |
| 00009 `1103303` | 440 / 220 / - | 220 x 220 x 440 | **H, W** |
| 00010 `1103302` | 500 / 300 / - | 280 x 280 x 470 | **H, W** |
| 00011 `113184` | 150 / 400 / - | dia 140, H 400 | **W, H** (reversed vs 00009) |
| 00013 `CQ V-2` | 60 / 360 / 190 | W 360, H 60, D 190 | **H, W, D** |
| 00012 `1103256` | 190 / 170 / - | not published | undeterminable |

The tell in each case is internal to SAP: `00009`'s remark says the vessel holds 2.5 L, so it cannot
be 440 mm across and 220 tall - 440 is the height. `00011`'s remark says 2.2 L airpot, so it cannot be
150 tall and 400 across - 400 is the height. **Opposite orders, adjacent rows, same brand.**

SAP's *values* are mostly within 10-30 mm of the manufacturer's, but in several rows
`products.json` is already **closer to the manufacturer than SAP is** (`00011` 140/140/400,
`00006` 205/410/428, `00009` 206/274/436) - the residue of the earlier enrichment pass. A bulk
"SAP overwrites products.json" run would degrade those rows.

Other SAP errors caught: `00004`'s **2500 W** (real: 2200 W) and **"45 minutes"** (real: 4.5-6 min).

---

## 6. Imagery sourced

Full ledger in `_sourced.json`; the whole discussion, including the resolution ceilings and the one
mislabelled image that was caught and rejected, is in `_FINDINGS.md`.

Headline: **2000 x 2000 px masters** for the decanter, both serving stations and the airpot (Parts
Town, via the uncached Magento media path); **800 x 800** for the M2 (five angles, two dealers), the
V-2 (two angles) and the decanter in current CREM livery; **768** for the 1.9 L thermos jug.

Two items cannot be had above the floor anywhere on the open web: the **Cater** (best isolated
official photo 250 x 547; the 1691 x 1670 manual cover shows both CATER and SINGLE CATER together) and
the **1.9 L thermos jug** (768 x 768 master at kaffe-rep). Parts diagrams, the Cater component/dimension
views and the CREM range brochures are filed under `_brand-reference\`.

**Do not use caterkwik's `Q1103256` image** - that page is titled "1.9 Litre Stainless Steel Thermos
Jug" but serves a photograph of the **Thermos Office machine** (proven by perceptual hash against
CREM's own `1002190_thermos_office.jpg`: Hamming 1 / RMS 5.2).

**Do not use crem.coffee's brewer marketing photography** - its "M2" image is `m2_1,8l_tk_r.jpg`, the
**TK-Series** M2, a different machine from our Original Line M-2. Its *accessory* pages (V-2, serving
station) are fine and were used.

---

## 7. CREM <-> KEF overlap - flagged, not resolved

Two KEF SKUs are reported to carry Coffee Queen / Crem product, and KEF `IMG/COF/00101` is a
"Decanter 1.8 Litres" with `model_number` `CMP-2`, uncomfortably close to our `CQM2`.

What CREM actually publishes:

* **`CQM2`** - a regional dealer code for the **M-2 brewer**, CREM article **`1002310`** (9 kg,
  2390 W, two hot plates). Not a decanter.
* **The 1.8 L glass decanter** - CREM article **`110001`**, sold as `Q110001` (Crem livery, current)
  and `Q110001-CQ` (Coffee Queen livery, superseded into Q110001). CREM states it fits *"Filter
  machines, M2"*.
* **`CMP-2`** - **does not exist in CREM's catalogue.** No match across all 3,127 cremtechnical
  sitemap URLs, Parts Town's Coffee Queen catalogue, or any dealer checked.

So the `CQM2` / `CMP-2` resemblance is superficial: one is a whole machine, the other a decanter.
If KEF `IMG/COF/00101` really is a Coffee Queen 1.8 L decanter, the code it should carry is `110001` -
which is what CREM `IMG/COF/00008` already carries, raising the possibility that the two records are
**the same physical product listed twice under two house brands**. That is a duplicate-SKU question
for the business.

**No brand change is proposed and no `model_number` change is proposed.** The decanter is staged here
in both liveries at 800-2000 px so a visual comparison against the KEF photos is easy to run.

---

## Archived brand research

> Merged in from the former `research/old/` folder on 2026-08-12, when the two folders were
> consolidated. This is the earlier **specs and codes** pass; everything above it
> is the later **sourcing and provenance** pass. The text is unchanged apart from
> heading levels, which were demoted one step to keep a single outline.

## CREM / Coffee Queen Product Research

Research notes behind the CREM enrichment pass on `products.json` (July 2026). Covers the
**9 CREM SKUs** in the catalogue - all filter-coffee brewers and serving/servery equipment.
Data was sourced from CREM's official sites (crem.coffee, cremtechnical.co.uk), Parts Town,
and cross-checked against European resellers.

---

### 1. Brand structure

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

### 2. Cross-cutting notes

#### The servery ecosystem
Several of these SKUs are **accessories that pair with the brewers**, not standalone
machines:
- Brewers (Single Cater `1008620`, M2 `CQM2`) brew **into** a serving vessel.
- Serving stations (`1103303` 2.5 L, `1103302` 5 L) and airpots (`1103184` 2.2 L) are the
  vessels; the brew-through lid lets coffee brew straight into them.
- The V-2 warming plate (`1001120`) and glass decanter (`110001`) support the decanter-style
  brewers.
- The 2.5 L / 5 L serving stations are listed as compatible with the **Mega Gold and Cater**
  brewers (cremtechnical Q1103303).

#### Voltage
Kenya is 230-240 V / 50 Hz. The decanter brewers and servery items are single-phase 230 V.
The one caution is the **Single Cater** (see §5.1) - a "single tower/cater" name is used for
both a single-phase ~2.5 kW unit and a 3-phase 9 kW bulk tower; they are different machines.

#### Not published - do not invent
- No independent spec sheet was found tying article **1103256** (00012) to a product.
- No weight is published for the 2.5 L serving station on the official page (~3 kg is an estimate).
- The 5 L serving-station dimensions disagree between sources (see §6).

---

### 3. Corrections applied to `products.json`

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

### 4. Product reference

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

### 5. Model-number flags (NOT changed - awaiting approval)

Per catalogue policy, `model_number` is the product's tracking ID and is not altered without
sign-off. The following are researched recommendations only:

#### 5.1 IMG/COF/00004 - `1008620` (Single Cater)
Two different machines are marketed under a "single tower/cater" name:
- a **single-phase ~2,500 W** unit that brews into a removable serving station (matches this
  record's own description), and
- a **3-phase 9,000 W** bulk tower (200 cups/hr, 5 L station, ~551 x 500 x 950 mm - coffeeworks).

The enrichment used the **single-phase reading**, because the record's description states
"AC 1-phase: 2500 W", 220 V, 4.5 min, full/half brew - internally consistent. The old spec
table (380 V / 0.75 kW / 350 cups) was discarded as corrupted. **Confirm against supplier
paperwork** whether the shipped machine is the single-phase Cater or the 3-phase tower; the
specs differ entirely.

#### 5.2 IMG/COF/00011 - `113184` should be `1103184`
`113184` is a **truncated typo**. The Coffee Queen 2.2 L airpot with sight gauge is article
**`1103184`** (Q1103184 on Parts Town and cremtechnical). Recommend correcting `113184 -> 1103184`.

#### 5.3 IMG/COF/00006 - `CQM2`
`CQM2` is a distributor-style code, not a Crem article number. The machine is the **M2**
(Coffee Queen M-2). Keep `CQM2` as an internal tracking code, or replace with the supplier's
M2 article number if provided.

#### 5.4 IMG/COF/00013 - `CQ V-2 1001120`
Combines model (`V-2`) and article (`1001120`) in one field. Accurate; optionally split into
model `V-2` with a note that the article is `1001120`.

#### 5.5 IMG/COF/00012 - `1103256` UNRESOLVED
Article `1103256` returns nothing on crem.coffee, cremtechnical.co.uk, Parts Town, or any
reseller. The original record was also internally inconsistent (named "Thermos Percolator SS"
but described as a glass decanter copied from IMG/COF/00008). **Confirm the real article
number and the actual product** (stainless thermos server vs glass pot). Nearby real codes:
`1002190` (1.9 L Office Thermos), `1103184` (2.2 L airpot).

---

### 6. Open questions / conflicts

- **5 L serving station (00010) dimensions.** `products.json` carries 205 x 460 x 545 mm /
  ~4 kg; Parts Town lists **280 x 280 x 470 mm / 5 kg** for Q1103302. The catalogue figures
  were kept; confirm against the physical unit.
- **2.5 L serving station (00009) weight** is an estimate (~3 kg) - not published officially.
- **Cup Dispenser (00007)** has no model and is archived at price 0; likely not a genuine
  Coffee Queen product. Left untouched.

---

### 7. Image sourcing

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

### 8. Official crem.coffee verification (July 2026)

Browsed crem.coffee's live catalogue and Document Finder directly and pulled the official
Welbilt/CREM spec-sheet PDFs (`assets.welbilt.com`). This resolves several of the open
questions above with primary-source data and **has been applied to `products.json`**.

#### 8.1 What's actually still sold today

The current **Filter Manual** range on crem.coffee has exactly three product lines:
**Tower / Single Tower**, **Mega Gold** (M/A + TK-Series), and **Thermos / Thermos Office**
(M/A + TK-Series). Searching the site (Products and Downloads tabs) for `M2` and for the
unresolved article `1103256` returned **zero results** in both cases - neither is a current,
independently-listed product on the marketing site.

However, the **Document Finder** (`/Resources#Document-Finder`) lists a wider legacy product
list than the marketing pages show, including **M-1 1.8L** and **M-2 1.8L TK**, each with a
downloadable spec sheet. So M2 (our `CQM2`, IMG/COF/00006) is a real, documented CREM model -
just not actively marketed as its own product page anymore. Confirms §5.3's read.

#### 8.2 Official spec sheets pulled (source of the corrections below)

| Product | Spec sheet | PDF asset |
|---|---|---|
| M1 / M2 / A2 / DM4 / DA4 ("1.8l Brewers") | `1-8l-Brewers-Sheet-EN.pdf` | assets.welbilt.com/asset/2209dbeb-.../1-8l-Brewers-Sheet-EN.pdf |
| Mega Gold | `Mega-Gold-Sheet-EN.pdf` | assets.welbilt.com/asset/4cb7ea46-.../Mega-Gold-Sheet-EN.pdf |
| Serving Station (2.5L & 5L) | `Serving-Station-Product-Sheet-EN.pdf` | assets.welbilt.com/asset/1acd5b2e-.../Serving-Station-Product-Sheet-EN.pdf |
| Tower & Single Tower | `Tower-Product-Sheet-EN.pdf` | assets.welbilt.com/asset/e4a8d219-.../Tower-Product-Sheet-EN.pdf |
| Thermos & Thermos Office | `Thermos-Product-Sheet-EN.pdf` | assets.welbilt.com/asset/7aa69fc2-.../Thermos-Product-Sheet-EN.pdf |

#### 8.3 Corrections applied to `products.json` (this pass)

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

#### 8.4 §5.1 (Single Cater / IMG/COF/00004) - now resolved, not just flagged

The official **Single Tower** spec (400V 3-phase, 9,000 W, 175 cups/h, 41 kg, brews into a 5L
serving station) is confirmed as a real, current, high-capacity catering machine - completely
different from IMG/COF/00004's own single-phase 2,500 W / 4.5-minute description. This confirms
the enrichment's original call was right: **IMG/COF/00004 is not the current Single Tower**, and
it isn't the current Mega Gold either (Mega Gold is 2,200 W / <8 min into a 2.5L station, still
not a match). IMG/COF/00004 remains a smaller, likely-discontinued "Cater Single" model that
CREM no longer lists - its own record stays the best available source for its specs.

#### 8.5 §5.5 (1103256 / IMG/COF/00012) - still unresolved

Confirmed via direct site search: crem.coffee's Products and Downloads search both return zero
results for `1103256`. Accessories/parts by article number simply aren't indexed on the
marketing site (only whole machines get product pages + spec sheets) - `cremtechnical.co.uk`
remains the only lead for this article number, and it was already exhausted in the original
pass. No new information; still needs supplier paperwork to resolve.

#### 8.6 Images

No usable new product photography came out of this pass for the catalogue's actual SKUs: the
official product photos found (Mega Gold, Tower, Single Tower, Thermos brewers) belong to
machines that are confirmed **not** the same models as IMG/COF/00004 or IMG/COF/00006 (see
§8.4), so applying them would mislabel the product. The one photo that would have applied -
a standalone Serving Station product shot - only exists embedded inside the PDF spec sheet, not
as a linkable web image. Existing SKU photography is left untouched.
