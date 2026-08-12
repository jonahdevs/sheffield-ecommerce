# Mercatus Product Research

Supersedes the archived research below. Sourcing/verification pass, August 2026, run against
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

---

## Archived brand research

> Merged in from the former `research/old/` folder on 2026-08-12, when the two folders were
> consolidated. This is the earlier **specs and codes** pass; everything above it
> is the later **sourcing and provenance** pass. The text is unchanged apart from
> heading levels, which were demoted one step to keep a single outline.

## Mercatus Product Research

Research notes behind a MERCATUS audit pass on `products.json` (July 2026). Covers all 3
MERCATUS SKUs, all infrared grills sold as three sizes of the same `MC167` model:
STAN MC167 (`IMG/HOT/00154`), XXL MC167 (`IMG/HOT/00155`), XL MC167 (`IMG/HOT/00156`), all
in the `Fast Food` category.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema/Baron/Santos passes before a scope decision.

---

### 1. Brand identification — `mercatus.pt` is WRONG, real company found

#### 1.1 `mercatus.pt` verdict: wrong company, unrelated industry

`brands.json` currently has `website_url: https://www.mercatus.pt`. This is a **real,
live company** — but it is **not** a commercial-grill manufacturer:

- **Mercatus (`.pt`)** is a Portuguese company in **refrigerated foodservice equipment,
  scientific/medical refrigeration, and UV-C disinfection** (brands Sense, Teknae, Fresh,
  Acura, Exige, WonderX). https://www.mercatus.pt
- Nothing on that site mentions grills, infrared cooking, or the MC167 code.
- **Confirmed wrong.** It appears to have been picked because it shares the name
  "Mercatus" and nothing more — see §1.4 for how this likely happened.

#### 1.2 Real manufacturer found: Mercatus Rickers & Timmermann GmbH (Hamburg, Germany)

Searching the model code `MC167` directly (rather than the brand name) surfaced our own
Sheffield Africa product pages and, from there, a distinct German company:

- **Legal entity:** **MERCATUS Rickers & Timmermann GmbH**, Hamburg, Germany. Founders
  **Jörn Timmermann** and **Hagen Rickers**. https://www.mercatus.de
- **Core business is furniture** (sofas, beds, office/contract furniture — brands
  Furninova, IQ Sofa, Finkeldei), sold to hospitality/retail/government projects across
  five continents. The infrared grill is a **secondary product line**, marketed through a
  dedicated microsite rather than the main corporate site.
- **Grill/BBQ product microsite:** https://bbq-fireplace.de — "BBQ Fireplaces from
  Mercatus Germany," Rahlstedter Bahnhofstr. 17, 22143 Hamburg, Germany. Self-described as
  "the worldwide market leader for barbecue-grills with sales across 5 continents." Sells
  **trade/wholesale only** — the site directs buyers to authorised dealers, no public
  price list or checkout.
- The product line matching our catalogue is called **"Power Grill"**:
  https://bbq-fireplace.de/power-grill/

#### 1.3 Verbatim marketing-copy match — decisive confirmation

The stored `description` on all 3 records is a near-verbatim copy of the official Power
Grill page copy, down to identical phrasing and list order:

> "The Mercatus® Power Grill is an ultra high temperature infra red grill that enables you
> to make restaurant quality steaks with an amazing caramelized crust at home... German
> engineered and crafted in form and function... Premium steakhouse quality at home with
> an unctuous caramelized crust... Healthy ceramic infra-red high temperature grilling
> (heat from above)... 1500°F (800°C) high temperature grilling with propane or electric
> power... Cooks a 1 inch steak to medium-rare perfection in 60 seconds per side...
> Restaurant quality dishes - creates a pure flavour explosion... Grills meat, fish,
> chicken, shrimps - even desserts... Easy to clean - removable parts are dishwasher safe."

This is word-for-word (bar minor reordering) the copy fetched live from
https://bbq-fireplace.de/power-grill/ — see the raw page content at
https://bbq-fireplace.de/wp-json/wp/v2/pages/10372 . There is no ambiguity: this is the
correct manufacturer.

**Image match is equally decisive** (see §5): the exact same photo file
(`power-grill2-600.jpg`) that is hosted on `bbq-fireplace.de/wp-content/uploads/2018/05/`
is reused (re-uploaded under our own storage paths) across all 4 of our site's MC167-badged
listings, including the retired "Prom MC167" (`IMG/HOT/00153`, no longer in
`products.json`). The photo itself is stamped **"POWER GRILL — MERCATUS® Germany —
1500°F/800°C"** in its own branding, so the badge on the physical unit confirms the brand
independently of any text match.

#### 1.4 How the wrong URL likely got in: MC167 numbering also explains a red herring

A second, unrelated Mercatus product was found on our own (live, but no-longer-in-
`products.json`) catalogue: `IMG/HOT/00158`, "BBQ Fireplace MC167" (slug), whose actual
page content reads **model MC166**, `model_number: 18928`, a charcoal/wood fireplace-grill
— not an infrared electric grill. This confirms Mercatus (Germany) runs a single
sequential **MC1xx model-numbering pool across its whole grill/fireplace range** (MC166 =
BBQ Fireplace, MC167 = Power Grill), which is normal and expected, not a data error on our
side. It does mean a bare "MC167" web search returns both grill and fireplace hits, and a
careless search for "Mercatus" alone will surface the Portuguese refrigeration company
long before the small German furniture-and-grills firm — a plausible explanation for how
`mercatus.pt` ended up in `brands.json`.

#### 1.5 `brands.json` description is also wrong, and traces to the same mix-up

Current `brands.json` description: *"Mercatus is a manufacturer of commercial
refrigeration equipment. They provide innovative cooling solutions for professional
kitchens and food service operations."* This describes the **Portuguese** Mercatus
(§1.1), not the German one that actually supplies these 3 grills. Both the URL and the
description need correcting together, not just the URL.

**Recommended `website_url`:** `https://bbq-fireplace.de/` (the product-line site that
matches what we sell) with `https://www.mercatus.de` noted as the parent corporate entity
— same two-tier pattern as the Baron/Ali Group pass.

---

### 2. Where to look

| Resource | URL | Value |
|---|---|---|
| Grill product microsite | https://bbq-fireplace.de/power-grill/ | Marketing copy (verbatim match, §1.3), category photos |
| Parent corporate site | https://www.mercatus.de | Confirms legal entity, Hamburg, furniture-led business |
| WP REST content (raw, undecorated) | https://bbq-fireplace.de/wp-json/wp/v2/pages/10372 | Cleanest text extraction of the Power Grill page |
| WP REST media (exact resolutions) | https://bbq-fireplace.de/wp-json/wp/v2/media/10395 and /10391 | Confirms true max resolution per image (§5) |
| Our own live catalogue (for cross-check only) | https://www.sheffieldafrica.com/commercial-kitchen/product/{1161,1162,1163,1164} | Shows all 4 MC167-badged listings share one photo |

#### Traps

1. **General web search on "Mercatus" is dominated by the unrelated Portuguese company**
   (§1.1) — the brand name alone is not a safe search term for this catalogue's product.
   Searching the **model code (`MC167`)** instead is what actually worked.
2. **General-purpose search engines (Google/Bing/DuckDuckGo/Yandex/Ecosia/Mojeek) mostly
   blocked automated fetches** with CAPTCHA or 403 pages during this pass; only
   **Brave Search** (`search.brave.com`) returned usable result snippets via `WebFetch`.
   If repeating this kind of search-by-model-code exercise, try Brave first.
3. **The official site is a brochure, not a catalogue.** `bbq-fireplace.de` sells
   trade-only (no direct checkout, no size-by-size spec sheet, no dimensions, no voltage
   figures anywhere on the public site) — there is exactly **one generic product photo**
   and **zero size-specific documentation** for the whole Power Grill line. This is a real
   ceiling, not a fetching failure — confirmed via the WordPress REST media endpoint
   (§5), which lists the true registered image sizes.
4. **The WordPress content API (`/wp-json/wp/v2/pages/<id>` and `/wp-json/wp/v2/media/<id>`)
   was more reliable than `WebFetch`-rendered HTML** for this particular site — it returns
   clean, undecorated JSON (with the copy still base64/URL-encoded inside a
   `[vc_raw_html]` shortcode, but decodable) and exact image dimensions per registered
   WordPress size, sidestepping both the CSS-bloat problem and any doubt about which
   image is truly "full size."

---

### 3. Per-SKU findings

All three stored records are internally structured the same way: `length`/`width`/`height`
numeric fields, a two-line prose `technical_specification` (cooking grid size + overall
dimensions), and a `description` that is the shared Power Grill marketing copy plus a
size-specific cooking-grid line. None currently store voltage, wattage, weight, or
material.

#### 3.1 STAN MC167 (`IMG/HOT/00154`)

- Stored dims: `length 420, width 255, height 365`; prose `"420X255X365mm"` — **numeric
  fields and prose agree**, no axis-swap on this SKU.
- Cooking grid: **285 × 155 mm** (stored in both `description` and
  `technical_specification`, consistent).
- Live-site image: `power-grill2-600.jpg` — the single official Mercatus Power Grill
  render, badge confirms brand (§1.3).

#### 3.2 XXL MC167 (`IMG/HOT/00155`)

- Stored dims: `length 420, width 320, height 365`; prose `"420X320X365mm"` — **agree**,
  no axis-swap.
- Cooking grid: **325 × 285 mm** — the largest grid area of the three (92,625 mm²).
- Same shared product photo as the other two SKUs.

#### 3.3 XL MC167 (`IMG/HOT/00156`)

- Stored numeric dims: `length 510, width 420, height 365`.
- Stored prose: `"510x410x365mm"` — **numeric `width` (420) disagrees with the record's
  own prose (410)**. Following this catalogue's established pattern (Brema/Baron/Santos
  passes: "where prose and numeric fields disagree, the prose has been correct every
  time"), **410 is the more likely correct value** — this at minimum needs the numeric
  `width` field reconciled with its own prose, independent of §4 below.
- Cooking grid: **340 × 225 mm** (76,500 mm²) — sits between STAN and XXL by area, which
  is the expected ordering for a mid-sized "XL" tier.
- Same shared product photo as the other two SKUs.

---

### 4. Cross-cutting notes — the size progression is NOT internally consistent

**Task-specific check requested: do the three sizes have genuinely distinct specs, or was
one size's numbers pasted across all three?** Answer: **not pasted** — all three cooking
grids and all three external dimension sets are numerically distinct, so this is not the
"single value copied 3×" failure mode seen elsewhere in the catalogue. But there **is** a
real internal-consistency problem, a different flavour of the same underlying
sibling-contamination issue documented across the Brema/Baron/Santos/Pradeep passes:

| | Cooking grid (mm) | Grid area (mm²) | External L×W×H (mm) | External footprint L×W (mm²) |
|---|---|---|---|---|
| STAN | 285 × 155 | 44,175 | 420 × 255 × 365 | 107,100 |
| XL | 340 × 225 | 76,500 | 510 × 410(or 420) × 365 | **209,100 (or 214,200)** |
| XXL | 325 × 285 | 92,625 | 420 × 320 × 365 | **134,400** |

- **Cooking-grid area increases sensibly with size name**: STAN (44,175) < XL (76,500) <
  XXL (92,625). This part of the data is coherent and plausible as-is.
- **External footprint does not**: XL's stored footprint (209,100–214,200 mm²) is
  **larger** than XXL's (134,400 mm²) — i.e. the record named "XL" is currently the
  *physically biggest cabinet* of the three, while "XXL" (which should be the biggest) has
  the *smallest* footprint after STAN. That inverts the naming.
- **If the XL and XXL external L×W×H values are swapped** (XL → 420×320×365, XXL →
  510×410×365), the footprint ordering becomes STAN (107,100) < XL (134,400) < XXL
  (209,100) — a clean, monotonic progression matching both the size names and the
  grid-area ordering. This is the same shape of bug as Baron's SE40 inheriting the SE60's
  frontage, and Brema/Santos's sibling-value bleed — a plausible transcription error where
  the XL and XXL records' cabinet dimensions were swapped during data entry.
- **This could not be independently confirmed against a manufacturer source**, because
  the official site publishes no size-specific dimensions at all (§2, trap 3) — so this is
  flagged as an **internal-consistency finding, not a manufacturer-verified correction**.
  Recommend treating it as a strong candidate for review/swap rather than an
  auto-apply fix.
- **Width/height axis-swap check (done per-SKU per standing instruction):** not present
  on any of the 3 SKUs — each record's numeric `length`/`width`/`height` already matches
  its own prose in axis order (only the XL width *value* disagrees, §3.3, not the axis
  assignment). This differs from the Brema/Baron pattern where the swap bug shows up on
  some SKUs and not others — here, the swap-shaped bug is between two *sibling records*
  rather than within a single record's own fields.

---

### 5. Electrical spec — cannot verify Kenya-suitability, nothing stored

**Task-specific check requested: verify the electrical spec suits Kenya (240V/50Hz).**
Finding: **there is nothing to verify** — none of the 3 records store a voltage, frequency,
or wattage figure, and the manufacturer's own public marketing page is equally silent on
electrical specs. The only power-related information anywhere (ours or theirs) is
"propane or electric power" as two alternative fuel/energy options — no figure for the
electric variant's voltage, phase, frequency, or power draw was found on
`bbq-fireplace.de`, and no size-specific datasheet exists to check per-SKU. **This is a
real content gap, not a wrong-market figure** — there is nothing stored that could be
"wrong for Kenya" because nothing was ever recorded. Recommend requesting the electric
variant's voltage/frequency/wattage from the supplier directly, since it is undocumented
on every source checked (official site, our own live catalogue, resold listings).

---

### 6. Product reference

| SKU | Name | Model | Official page | Independent source | Confidence |
|---|---|---|---|---|---|
| IMG/HOT/00154 | Infra Red Grill Mercatus Stan MC167 | STAN MC167 | https://bbq-fireplace.de/power-grill/ | https://www.mercatus.de (parent entity) | **High** on brand identity (verbatim copy + badge match); **Medium** on size-specific dims (no manufacturer size sheet exists, §4) |
| IMG/HOT/00155 | Infra Red Grill Mercatus XXL MC167 | XXL MC167 | https://bbq-fireplace.de/power-grill/ | https://www.mercatus.de | **High** brand / **Medium** dims (same caveat) |
| IMG/HOT/00156 | Infra Red Grill Mercatus XL MC167 | XL MC167 | https://bbq-fireplace.de/power-grill/ | https://www.mercatus.de | **High** brand / **Medium** dims (same caveat, plus its own prose/numeric width disagreement, §3.3) |

Supporting sources used:

- https://bbq-fireplace.de/power-grill/
- https://bbq-fireplace.de/wp-json/wp/v2/pages/10372
- https://bbq-fireplace.de/wp-json/wp/v2/media/10395
- https://bbq-fireplace.de/wp-json/wp/v2/media/10391
- https://www.mercatus.de
- https://www.mercatus.pt (ruled out, §1.1)
- https://www.sheffieldafrica.com/commercial-kitchen/product/1161/infra-red-grill-mercatus-prom-mc167-prom-mc167 (our own retired listing, cross-check only)
- https://www.sheffieldafrica.com/commercial-kitchen/product/1221/bbq-fireplace-mc167 (our own retired listing, cross-check only — reveals the MC166/MC167 numbering pool, §1.4)
- https://search.brave.com/search?q=%22Mercatus%22+%22Power+Grill%22+infrared

---

### 7. Image sourcing — staged in `Desktop\ecommerce\products resource\mercatus-images\`

#### 7.1 The "600 px ceiling" was WRONG — it was an incomplete probe (corrected July 2026)

The earlier pass concluded that 600 px was "genuinely the manufacturer's own ceiling,"
based on querying two specific attachment IDs (`/wp-json/wp/v2/media/10395` and `/10391`).
**That conclusion does not hold.** Those two IDs are the deliberately downsized `-600`
copies the page happens to embed; the same WordPress install also hosts the **full-size
originals as separate attachments**, which the earlier probe never saw because it only
asked about the two IDs it already knew.

Listing the whole media library instead of individual IDs —
https://bbq-fireplace.de/wp-json/wp/v2/media?per_page=100&search=grill — immediately
exposed six more Power Grill attachments, four of them above the 800 px bar:

| Attachment | Full size | Note |
|---|---|---|
| `power-grill2.jpg` (id 10384) | **1225 × 968** | full-size original of the `power-grill2-600.jpg` hero — 2× the linear resolution previously reported as the ceiling |
| `power-grill3.jpg` (id 10385) | **1030 × 1068** | grid-rack / drip-tray detail |
| `power-grill-side.jpg` (id 10386) | **925 × 886** | side detail: gas fitting + control knob |
| `power-grill-top.jpg` (id 10382) | **910 × 869** | full-size original of `power-grill-top-600.jpg` |
| `power-grill.jpg` (id 10383) | 757 × 648 | below bar, not used |
| `power_grill_banner.jpg` (id 10377) | 1920 × 800 | marketing banner, not product photography — not downloaded |

**Lesson worth carrying to other brands:** on a WordPress host, never conclude a ceiling
from `/wp-json/wp/v2/media/<id>` on the IDs the page embeds. The embedded image is often a
manually-resized upload with its own attachment ID, and the full-size original is a
*different* attachment. Always list the collection
(`/wp-json/wp/v2/media?per_page=100&search=<term>`) before declaring a ceiling.

#### 7.2 Files staged

**12 files.** All four usable renders now clear the 800 px bar; the hero clears 1000 px.
Because the manufacturer still publishes no size-differentiated photography, each of the
three SKUs gets its own copy of the same four images, and the `GENERIC` suffix is retained.

| SKU | File | Px / size | Source |
|---|---|---|---|
| IMG/HOT/00154 (STAN) | `IMG-HOT-00154__STAN-MC167-official-front-hero-1225x968-GENERIC.jpg` | 1225×968, 120 KB | https://bbq-fireplace.de/wp-content/uploads/2018/05/power-grill2.jpg |
| IMG/HOT/00154 | `IMG-HOT-00154__STAN-MC167-official-front-badge-closeup-910x869-GENERIC.jpg` | 910×869, 101 KB | https://bbq-fireplace.de/wp-content/uploads/2018/05/power-grill-top.jpg |
| IMG/HOT/00154 | `IMG-HOT-00154__STAN-MC167-grid-rack-drip-tray-detail-1030x1068-GENERIC.jpg` | 1030×1068, 167 KB | https://bbq-fireplace.de/wp-content/uploads/2018/05/power-grill3.jpg |
| IMG/HOT/00154 | `IMG-HOT-00154__STAN-MC167-gas-fitting-knob-side-detail-925x886-GENERIC.jpg` | 925×886, 107 KB | https://bbq-fireplace.de/wp-content/uploads/2018/05/power-grill-side.jpg |
| IMG/HOT/00155 (XXL) | same four files, `IMG-HOT-00155__XXL-…` | identical px/size | identical sources |
| IMG/HOT/00156 (XL) | same four files, `IMG-HOT-00156__XL-…` | identical px/size | identical sources |

The six earlier 600 px files were deleted — they are the same photographs at lower
resolution, superseded outright, and keeping both versions of one image is pure noise.

**Visually verified at full resolution.** The hero shows a stainless cabinet badged
**"POWER GRILL"** over a **"◆◆ MERCATUS® Germany — 1500° F / 800° C"** sub-badge, with a
pull-out grid rack, a slide-out drip tray, a separate drip pan and chevron-punched top
ventilation. The badge-closeup crop renders that badge sharply enough to read every word —
independent confirmation of §1.3's brand identification, now at a resolution where it is
legible rather than inferred. Not upscaled (native JPEGs, clean edge detail at 100 %).
No `REF__` renames needed — all four show the genuine correct product.

**`GENERIC` suffix is still intentional and still important**: these photos **cannot**
distinguish STAN from XL from XXL. That limitation is unchanged by the resolution fix.

**New detail the higher-res files add**: `power-grill-side.jpg` clearly shows a **brass
gas inlet fitting and a 5-position control knob**, i.e. this render is of the **propane**
variant. That is a useful caveat given §5 — the electric variant's voltage/wattage is
still entirely undocumented, and the only photography the manufacturer publishes is
apparently of the gas unit. Worth flagging before this render is used to illustrate an
"electric" listing.

#### 7.3 No spec sheet exists

Probed https://bbq-fireplace.de/wp-json/wp/v2/media?per_page=100&media_type=application —
the media library contains **exactly one non-image attachment, a `.zip` of action shots**
(`bbq-in-action-shots.zip`, id 10330). **There is no datasheet, manual, or catalogue PDF
anywhere on the manufacturer's site.** This independently confirms §5: the missing
electrical spec is not hiding in a document we failed to find, it is genuinely
unpublished, and can only come from the supplier.

No filler/stock images were downloaded — the feature-icon graphics on the marketing page
(propane / German-engineered / dishwasher-safe / 800 °C icons, food-category thumbnails)
and the 1920×800 banner are marketing furniture, not product photography.

---

### 8. Summary — what a future write pass would consider

Nothing in this pass has been applied to `products.json` or `brands.json`.

**`brands.json`**
1. `website_url`: **`https://www.mercatus.pt` → `https://bbq-fireplace.de/`** (product-line
   site) — current value points to an unrelated Portuguese refrigeration/medical company,
   §1.1–1.3. Optionally note `https://www.mercatus.de` as the parent corporate entity
   (MERCATUS Rickers & Timmermann GmbH, Hamburg — a furniture distributor for whom grills
   are a secondary line).
2. `description`: rewrite — the current text ("manufacturer of commercial refrigeration
   equipment... cooling solutions") describes the wrong company entirely (§1.5) and should
   instead describe a German (Hamburg) manufacturer of BBQ fireplaces and the "Power Grill"
   ultra-high-temperature infrared grill line.

**All 3 SKUs (`IMG/HOT/00154`/`00155`/`00156`)**
1. **Needs a decision, not a mechanical fix:** the XL/XXL external-dimension swap
   candidate in §4 — recommend swapping XL's `length/width/height` with XXL's
   (420×320×365 ↔ 510×410×365) to restore a monotonic STAN<XL<XXL size progression
   consistent with the cooking-grid data, but this is an internal-consistency inference,
   not a manufacturer-confirmed correction — no official per-size spec sheet exists to
   check against.
2. **XL (`00156`) only:** reconcile numeric `width` (420) with its own prose (410) — this
   is a plain self-contradiction independent of the swap question in #1.
3. Electrical spec (voltage/frequency/wattage) is **entirely unstored and unverifiable**
   against any source found — recommend requesting it from the supplier rather than
   inferring or fabricating a figure (§5).
4. Images: 12 files staged in `Desktop\ecommerce\products resource\mercatus-images\`, all
   confirmed-genuine Mercatus Power Grill renders. **The previously-reported 600 px
   ceiling was an incomplete probe and is now corrected** — the manufacturer's own
   WordPress install hosts full-size originals up to **1225×968** as separate attachments
   (§7.1). All four adopted renders clear the 800 px bar. Not yet copied into `storage/`
   or referenced in `products.json`.
5. No manufacturer datasheet/manual PDF exists for the Power Grill line — confirmed by
   querying the site's entire non-image media library, which holds one `.zip` and nothing
   else (§7.3). Reinforces that the electrical spec (#3) must come from the supplier.
6. The only published photography appears to be of the **propane** variant (visible brass
   gas inlet and gas control knob, §7.2) — a caveat if these renders are used to
   illustrate an electric unit.
