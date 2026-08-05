# Mercatus Product Research

Supersedes `old/mercatus-research.md`. Sourcing/verification pass, August 2026, run against
the SAP dossier. Covers all 3 MERCATUS SKUs - three sizes of one infrared grill:
STAN MC167 (`IMG/HOT/00154`), XXL MC167 (`IMG/HOT/00155`), XL MC167 (`IMG/HOT/00156`).

**No `products.json` or `brands.json` change has been applied.** Findings only.

---

## 1. Brand identity - the stored URL is wrong, confirmed again

`brands.json` stores https://www.mercatus.pt . That is a live Portuguese company in
**refrigerated foodservice, scientific/medical refrigeration and UV-C disinfection**. It
makes no grills and uses no `MC1xx` codes. It is not our supplier.

**The correct site is https://bbq-fireplace.de** - the product site of
**MERCATUS Rickers & Timmermann GmbH**, Rahlstedter Bahnhofstr. 17, 22143 Hamburg,
Germany. Tel +49-40-675688-0, info@mercatus.de. Trade-only; buyers are directed to
dealers.

The corporate domain https://www.mercatus.de is a **6 KB stub** - every path
(`/downloads/`, `/katalog/`, anything) 302s back to `index.html`. It holds no product
content, so it is not usable as the brand URL; `bbq-fireplace.de` is.

Three independent confirmations:

- The `description` stored on all 3 SKUs is verbatim the copy at
  https://bbq-fireplace.de/power-grill/ (fetched live this pass).
- The photographed unit carries a badge stamped **POWER GRILL - MERCATUS(R) Germany -
  1500 F / 800 C**. Our SAP remark carries the same 1500F/800C figure.
- The line is named "Power Grill", "an ultra high temperature infra red grill" - exactly
  what our 3 SKUs are.

`brands.json`'s Mercatus *description* ("commercial refrigeration equipment... innovative
cooling solutions") also describes the Portuguese company. URL and description are wrong
together and should be corrected together.

## 2. Where to look

| Resource | URL |
|---|---|
| Product page (only one on the whole site) | https://bbq-fireplace.de/power-grill/ |
| WP page list - proves the site's full extent | https://bbq-fireplace.de/wp-json/wp/v2/pages?per_page=100 |
| WP media collection - proves the image ceiling | https://bbq-fireplace.de/wp-json/wp/v2/media?per_page=100&page=1 |
| Parent corporate stub | https://www.mercatus.de |
| Ruled out - wrong company | https://www.mercatus.pt |

### Traps

1. Searching the brand name alone surfaces the Portuguese refrigeration company; searching
   the model code `MC167` surfaces only our own Sheffield listings. Neither route reaches a
   third-party spec source, because none exists.
2. `bbq-fireplace.de` is a **brochure, not a catalogue**. 25 pages total, one product page,
   93 media items, **zero PDFs**. `/downloads/`, `/download/`, `/katalog/` all 404.
3. Do not conclude an image ceiling from `/wp-json/wp/v2/media/<id>` on the IDs the page
   embeds - the page embeds deliberately downsized `-600` copies that are *separate
   attachments* from the full-size originals. Page the **collection** endpoint to
   exhaustion instead. Done this pass: 93 items, ceiling confirmed at 1225 x 968.
4. Mercatus runs one sequential `MC1xx` pool across its whole outdoor range (MC166 = the
   BBQ Fireplace charcoal unit, MC167 = the Power Grill), so an `MC167` search also returns
   fireplace hits.

## 3. What separates STAN / XL / XXL

**Cooking-grid area, and nothing else. All three are the same design, same 800 C ceramic
infrared burner, same `MC167` line code; the prefix is the size tier (STAN = Standard).**

Mercatus publishes **no** size names, dimensions, grid sizes, wattages or variant
photography - the entire Power Grill line is presented as one undifferentiated product.
So the only size-differentiating data in existence is our own SAP grid figures, and they
are internally coherent:

| | Cooking grid (mm) | Grid area (mm2) |
|---|---|---|
| STAN | 285 x 155 | 44,175 |
| XL | 340 x 225 | 76,500 |
| XXL | 325 x 285 | 92,625 |

Monotone in the size names. This is **not** the "one value pasted across three siblings"
failure mode - all three are genuinely distinct.

## 4. SAP's dimension column order for MERCATUS is Depth / Width / Height

Established from SAP alone, by testing each row's dimension fields against that same row's
`Item Remarks` grid size - the grid slides in through the front, so grid width must be
less than cabinet width:

| SKU | SAP dims as labelled W/D/H | own remark's grid | consistent? |
|---|---|---|---|
| IMG/HOT/00154 STAN | 255 / 420 / 365 | 285 x 155 | **no** - 285 mm grid, 255 mm cabinet |
| IMG/HOT/00155 XXL | 320 / 425 / 365 | 325 x 285 | **no** - 325 mm grid, 320 mm cabinet |
| IMG/HOT/00156 XL | 420 / 510 / 365 | 340 x 225 | works either way |

Two of three rows contradict themselves under W/D/H; both resolve under **D/W/H**. Our
`products.json` values are the transpose of SAP's and are therefore already the correct,
width-first orientation.

## 5. Open issue - XL and XXL cabinet dimensions look swapped

| | Cabinet W x D (mm) | Footprint (mm2) |
|---|---|---|
| STAN | 420 x 255 | 107,100 |
| XL | 510 x 420 | 214,200 |
| XXL | 425 x 320 | 136,000 |

XL is the physically largest cabinet and XXL the second-smallest - inverted against both
the names and the grid-area ordering in section 3. Swapping the XL and XXL cabinet figures
restores both orderings (107,100 < 136,000 < 214,200).

**Not verifiable against the manufacturer** - Mercatus publishes no dimensions for any
size. Recorded as an internal-consistency finding for review, not a confirmed correction.

## 6. Electrical - undocumented, and the photography is of the GAS unit

There is nothing to reconcile against Kenyan 240 V / 50 Hz: **no voltage, frequency or
wattage figure exists** in our records, on the manufacturer site, or on any reachable third
party. SAP says only "propane or electric power" as alternative fuels.

The side-detail photo (925 x 886) shows a **brass propane inlet and a gas control knob** -
the unit Mercatus photographs is the propane version. If we sell the electric version, the
only available photography does not depict it.

This is a **content gap, not a wrong-market figure**: no US 110 V / 60 Hz value is present
because no value is present at all. Needs a direct supplier request.

## 7. Images staged

Folder: `Desktop\ecommerce\products resorce final\mercatus\`. 12 product files (4 photos x
3 SKUs) plus 2 in `_brand-reference\`. All 12 clear the 800 px short-edge floor.

| File suffix | Source URL | Px |
|---|---|---|
| `-1` hero 3/4 front, drawer + pan + grid out | https://bbq-fireplace.de/wp-content/uploads/2018/05/power-grill2.jpg | 1225 x 968 |
| `-2` grid holder / rack rails detail | https://bbq-fireplace.de/wp-content/uploads/2018/05/power-grill3.jpg | 1030 x 1068 |
| `-3` side: brass gas fitting + control knob | https://bbq-fireplace.de/wp-content/uploads/2018/05/power-grill-side.jpg | 925 x 886 |
| `-4` front/top badge close-up | https://bbq-fireplace.de/wp-content/uploads/2018/05/power-grill-top.jpg | 910 x 869 |

`power-grill.jpg` (757 x 648) is below the floor and was not taken.
`power_grill_banner.jpg` (1920 x 800) is a marketing banner - `_brand-reference\`.

**Ceiling 1225 x 968, proven** by paging the media collection to exhaustion (93 items).

**All four rendered before acceptance.** All four are genuine studio product photography of
one physical unit on white; badge text is legible and correctly kerned across three
separate frames; sheet-metal geometry, brass fitting and knob are physically coherent. No
AI-generated asset was found.

**Perceptual hashing** (16x16 ahash shortlist, then per-pixel RMS on 256x256 greyscale)
returns hamming 0 / RMS 0.00 for every cross-SKU pair - the three SKUs deliberately share
one photo set, because only one exists. Every file therefore carries the
`REPRESENTATIVE-RANGE` token and `code_proven: false`; no filename asserts a size it
cannot support.

## 8. Spec sheets - none exist

No datasheet, manual or catalogue is published for the Power Grill in any size. Verified
by full page enumeration (25 pages), full media enumeration (93 items, zero PDFs), direct
probing of `/downloads/`, `/download/`, `/katalog/` (404), and `wp-sitemap.xml`. This is a
real ceiling, not a fetch failure.

## 9. Product reference

| SKU | Model | Source | Confidence |
|---|---|---|---|
| IMG/HOT/00154 | STAN MC167 | https://bbq-fireplace.de/power-grill/ | **High** brand, **none** size-specific (nothing published) |
| IMG/HOT/00155 | XXL MC167 | https://bbq-fireplace.de/power-grill/ | **High** brand, **low** dims (section 5) |
| IMG/HOT/00156 | XL MC167 | https://bbq-fireplace.de/power-grill/ | **High** brand, **low** dims (section 5) |

Sources used:

- https://bbq-fireplace.de/power-grill/
- https://bbq-fireplace.de/wp-json/wp/v2/pages?per_page=100
- https://bbq-fireplace.de/wp-json/wp/v2/media?per_page=100&page=1
- https://bbq-fireplace.de/wp-content/uploads/2018/05/power-grill2.jpg
- https://bbq-fireplace.de/wp-content/uploads/2018/05/power-grill3.jpg
- https://bbq-fireplace.de/wp-content/uploads/2018/05/power-grill-side.jpg
- https://bbq-fireplace.de/wp-content/uploads/2018/05/power-grill-top.jpg
- https://www.mercatus.de
- https://www.mercatus.pt (ruled out)
