# CREM / Coffee Queen - product research

> **This file supersedes `database/data/research/old/crem-research.md`.**
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
