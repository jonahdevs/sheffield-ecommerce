# Pasmo Product Research

Supersedes the archived research below (July 2026), which predates the SAP export. Covers all 3
PASMO SKUs - commercial soft-serve ice cream machines.

Staging folder: `Desktop\ecommerce\products resorce final\pasmo\`
Nothing in `products.json`, `brands.json` or `storage/` was changed by this pass.

---

## 1. Brand

**Taizhou Pasmo Food Technology Co., Ltd.**, Huangyan, Taizhou, Zhejiang, China. PASMO is the
manufacturer's own brand. **PASMO America** is the US arm and publishes the better-structured
per-model datasheets.

https://www.pasmochina.com
https://pasmousa.com

---

## 2. Body styles - verified by eye, all three correct

| SKU | Code | Photograph shows | Verdict |
|---|---|---|---|
| IMG/ICE/00017 | S110F | one hopper lid, ONE dispensing handle, compact cabinet on short feet | **table top** |
| IMG/ICE/00029 | S230F | TWO hopper lids, THREE handles (2 + twist), counter cabinet on short feet, drip tray | **table top** |
| IMG/ICE/00018 | S520F | full-height cabinet, separate lower machine compartment, FOUR CASTORS | **free standing** |

Corroborated in writing by Pasmo's own US datasheets, which title themselves "S110F Table Top
Soft Serve Freezer", "S230F Table Top Soft Serve Freezer" and "S520F **Floor Standing** Soft
Serve Freezer".

⚠ **Pasmo's own Chinese-site S520F datasheet contradicts this** - see section 5.

---

## 3. SAP dimensions: the column order is `depth, width, height`

Established from SAP's own rows against the manufacturer's dimensioned elevations:

| SKU | SAP length/width/height | Manufacturer width/depth/height | Verdict |
|---|---|---|---|
| IMG/ICE/00017 S110F | 785 / 385 / 730 | 385 / **720** / 731 | order right, depth value 65 mm too large |
| IMG/ICE/00029 S230F | 770 / 520 / 969 | 520 / 770 / 969 | **exact** |
| IMG/ICE/00018 S520F | 855 / 636 / 1517 | 636 / 855 / 1517 | **exact** |

Proof for S520F is the manufacturer's own drawing, which labels 636 across the front elevation,
855 down the side elevation and 1462 mm body height (1517 including castors):
https://www.pasmochina.com/uploads/image/20220416/11/f116edd375c177ba426d099a028926b6.png

Proof for S110F is the US datasheet's `Specifications 15.16" | 28.35" | 28.80"` =
385 | 720 | 731 mm, which is explicitly width | depth | height.

⚠⚠ **This order is the REVERSE of BREMA's**, which was verified in the same session as
`width, depth, height` against Brema's own datasheets. The per-brand column-order variation is
real. Reading Pasmo with Brema's order would make the S230F 770 mm wide and 520 mm deep - a
250 mm error in both directions on a machine sold on fitting a countertop.

### 3.1 One bad SAP value

S110F depth: SAP 785, manufacturer 720. Width and height match to the millimetre, so this is a
single wrong value rather than a transposition, and it matches no carton figure either.
**`products.json` already carries 720, so our stored record is right and SAP is wrong here.**

### 3.2 ⚠ Our stored length/width are transposed against the catalogue convention

The catalogue convention is `length` = width, `width` = depth (confirmed on Brema in the same
session). All three Pasmo records instead mirror SAP's depth-first order:

| SKU | stored length / width | per convention |
|---|---|---|
| S110F | 720 / 385 | 385 / 720 |
| S230F | 770 / 520 | 520 / 770 |
| S520F | 855 / 636 | 636 / 855 |

Values are right; the two fields are swapped. Flagged, not applied.

---

## 4. SAP remark errors

| SKU | SAP remark | Manufacturer |
|---|---|---|
| S110F | "No. of hoppers: 1 - Hopper Capacity: **6.5 Litres x 2**" | **9.5 L x 1** |
| S110F | "Power: **20V**/50Hz" | 220 V / 50 Hz (typo) |
| S230F | Compressor "**EMBRACO/TECUMSEH**" | **Aspera** |
| S520F | Compressor "**EMBRACO/TECUMSEH**" | **Aspera** |
| S520F | Motor "**550 W x2**" | **750 W x2** |
| S520F | Production "**50** litres/hr" | **55 L/h** |
| S520F | "N.W. 226 / G.W. 241 kg" | **230 / 250 kg** |

⚠ The S110F hopper line is **self-contradictory within its own row** - one hopper, then a "x 2"
capacity. That is the tell: it is a fragment of a two-hopper row pasted onto the single-hopper
machine. The correct figure is 9.5 L x 1, which also matches the old research's finding that
the stored 6.5 L was wrong.

S110F net/gross (90 / 103 kg) is the one place SAP matches the datasheet exactly.

---

## 5. ⚠ Two defective manufacturer documents

**(a) The S520F datasheet calls itself a "Table Top".** Its title and `TYPE` field both read
table top, on a document whose own photo shows a castored floor machine and whose own drawing
gives 1462 mm of body height. Extracting the PDF's embedded objects with PyMuPDF shows why: the
page is a **blank S230F table-top template layer** with S520F values overprinted, and the
template's own wording was never replaced (its model-number field still reads a bare "S").
Pasmo's US sheet says Floor Standing.

https://www.pasmochina.com/uploads/file/20220416/11/6a921d2212b83dc362048759569924b9.pdf
https://pasmousa.com/wp-content/uploads/S520F_PASMO_Spec_Sheet.pdf

**(b) The S110F "datasheet" link serves a corrupt file.** The PDF linked from the S110F product
page is a 7-page dump of the site CMS's own template-syntax documentation, not a spec sheet.
The US sheet was used instead.

https://www.pasmochina.com/uploads/file/20220330/15/5aedbe82f1549c52ba7062536c9d7c39.pdf

Useful side-effect: that corrupt file documents the CMS image resizer, whose largest allowed
size is **800x800** - which explains why pasmochina.com's galleries are capped so low.

---

## 6. Official specification

| | S110F | S230F | S520F |
|---|---|---|---|
| Type | table top | table top | **floor standing** |
| Production | 20 L/h | 30 L/h | 55 L/h |
| Flavours | 1 | 3 (2 + twist) | 3 (2 + twist) |
| Hoppers | 1 x 9.5 L | 2 x 9.5 L | 2 x 12.5 L |
| Cylinder | 1.6 L | 1.6 L x 2 | 2 L x 2 |
| W x D x H mm | 385 x 720 x 731 | 520 x 770 x 969 | 636 x 855 x 1517 |
| Carton mm | 490 x 830 x 835 | 880 x 650 x 1100 | 760 x 980 x 1640 |
| Net / gross kg | 90 / 103 | 168 / 183 | 230 / 250 |
| Power | 1.5 kW | 3 kW | 3.2 kW |
| Motors | 1 x 550 W | 2 x 550 W | 2 x 750 W |
| Compressors | 1 x Aspera 3753 BTU/h | 2 x Aspera 3753 BTU/h | 2 x Aspera 3753 BTU/h |
| Refrigerant | R404A, 500 g | R404A, 500 g | R404A, 700 g |
| Cooling | air / water | air / water | air / water |
| Beater | 304 stainless | stainless | stainless |
| Electrical (our market) | 220 V 50 Hz 1-ph (S110FA2) | 220 V/50 Hz air: 30 A fuse, 13 A, 3 kW | 220 V/50 Hz: 35 A fuse, 14 A, 3.2 kW; **380 V 3-ph also offered** |

⚠ **The S520F is offered in 220 V single-phase and 380 V three-phase.** Confirm which build is
ordered - the datasheet lists both.

⚠ **All three run R404A**, a high-GWP HFC. No hydrocarbon variant is published for these models.

Sources:

https://www.pasmochina.com/product/473/474/476/
https://www.pasmochina.com/product/473/515/519/
https://www.pasmochina.com/product/473/617/780/
https://pasmousa.com/wp-content/uploads/S110F_PASMO_Spec_Sheet.pdf
https://pasmousa.com/wp-content/uploads/S230F_PASMO_Spec_Sheet.pdf
https://pasmousa.com/wp-content/uploads/S520F_PASMO_Spec_Sheet.pdf
https://www.pasmochina.com/uploads/file/20220416/10/16367f140f5c85bc097d63fc7c72957f.pdf
https://pasmousa.com/wp-content/uploads/Operating-Manual-F-Series-Equipment.pdf
https://preferredsource.com/wp-content/uploads/PASMO-America-Catalog-English-Digital.pdf

---

## 7. Imagery

| SKU | Files >= 800 px | Best px | Source |
|---|---|---|---|
| IMG/ICE/00017 S110F | 4 | 1000x1524 | https://www.pasmochina.com/product/473/474/476/ + https://pasmousa.com/machine/s110f-table-top-soft-serve-freezer/ |
| IMG/ICE/00029 S230F | 2 (one viewpoint) | 1000x1000 | https://kitchenrestock.com/products/pasmo-s230fap2-soft-serve-machine-countertop-pressurized |
| IMG/ICE/00018 S520F | 3 (2 photos + 1 drawing) | 1227x864 drawing, 1000x1000 photos | https://kitchenrestock.com/products/pasmo-s520fa2-soft-serve-machine-floor-model-gravity-fed + https://www.pasmochina.com/product/473/617/780/ |

### 7.1 Proven ceilings

| Source | Ceiling |
|---|---|
| pasmochina.com | ~1000 px long edge; most gallery files 500x500 (CMS resizer tops out at 800x800) |
| pasmousa.com | 1000 px long edge (WordPress originals) |
| kitchenrestock.com | 1000x1000 (Shopify `/products/<handle>.json` reports true source dims) |
| chefsdeal.com | 789x1000 |
| Datasheet PDFs | embedded objects are whole-page 2521x3584 raster layers, not separable photos |

**No manufacturer-hosted image clears the 800 px floor for S230F or S520F.** Both depend on a
US reseller's Shopify assets. Near-misses are staged in `_brand-reference/` rather than
upscaled - pasmousa's S230F is 796x1000, four pixels short.

### 7.2 Shared and duplicated imagery

- **S230F -1 and -2 are the same photograph with different badging** (ahash distance 0, RMS
  4.20): one fascia reads `PASMO`, the other `PASMO AMERICA`. Kept, but -2 is not a second view.
- **S520F -1 and -2 are published identically on both the gravity (S520FA2) and pressurized
  (S520F-AP2) listings** - shared across feed variants of the same base model, so
  `code_proven: false`. The air pump is internal and cannot be seen in a photograph.
- **Rejected:** kitchenrestock's `pasmo-s230f-tla2-...` listing shows a visibly different
  machine (transparent cylinder tubes, wooden-handled taps) and its own title miscalls the
  S230F "Single Flavor". Staged as a `REJECTED-` file in `_brand-reference/`.

### 7.3 Nothing AI-generated

`_ai-generated/` is empty. Accepted files are conventional studio photography - real specular
highlights on brushed stainless, physically consistent louvre slats, correctly-legible fascia
text. Every image was opened.

---

## 8. Product reference

| SKU | model_number | Official page | Datasheet | Confidence |
|---|---|---|---|---|
| IMG/ICE/00017 | S110F | https://www.pasmochina.com/product/473/474/476/ | https://pasmousa.com/wp-content/uploads/S110F_PASMO_Spec_Sheet.pdf | High |
| IMG/ICE/00029 | S230F | https://www.pasmochina.com/product/473/515/519/ | https://www.pasmochina.com/uploads/file/20220416/10/16367f140f5c85bc097d63fc7c72957f.pdf | High |
| IMG/ICE/00018 | S520F | https://www.pasmochina.com/product/473/617/780/ | https://www.pasmochina.com/uploads/file/20220416/11/6a921d2212b83dc362048759569924b9.pdf | High on spec, see section 5 on its "table top" error |

All three model codes verified genuine on the manufacturer's own site. No `model_number` change
proposed.

---

## 9. Recommended changes (nothing applied)

1. 🔴 **S110F hopper: 9.5 L x 1**, not SAP's contradictory "6.5 L x 2" - section 4.
2. 🟠 **Compressor brand on S230F and S520F: Aspera**, not "Embraco/Tecumseh" - section 4.
   (Aspera is an Embraco marque, so "Embraco" alone is defensible; "Tecumseh" is not supported.)
3. 🟠 **S520F**: motors 750 W x2 (not 550), production 55 L/h (not 50), net/gross 230/250 kg
   (not 226/241) - section 4.
4. 🟠 **Length/width transposition on all three** against the catalogue convention - section 3.2.
   Needs a decision on whether to normalise Pasmo to the convention or leave it mirroring SAP.
5. 🟡 Add refrigerant charges (500 g / 500 g / 700 g), carton sizes and the S520F's 380 V
   three-phase option.
6. ⚪ No `model_number` change. No `brands.json` change needed.

---

## Archived brand research

> Merged in from the former `research/old/` folder on 2026-08-12, when the two folders were
> consolidated. This is the earlier **specs and codes** pass; everything above it
> is the later **sourcing and provenance** pass. The text is unchanged apart from
> heading levels, which were demoted one step to keep a single outline.

## Pasmo Product Research

Research notes behind the PASMO enrichment/audit pass on `products.json` (July 2026).
Covers all 3 PASMO SKUs — all commercial soft-serve ice cream machines: two countertop
(S110F single-flavour, S230F two-flavour) and one freestanding (S520F three-flavour). Specs
were sourced from Pasmo's own sites and cross-checked against resellers.

**All three model codes were confirmed genuine and left unchanged. This pass corrected wrong
dimensions on two SKUs (one also had a wrong hopper capacity), fixed a compressor-brand
error, and rebuilt the descriptions, spec tables and meta descriptions.** No image field was
changed — image sourcing (§6) is presented as links for manual review.

---

### 1. Brand identification

**Pasmo** = **Taizhou Pasmo Food Technology Co., Ltd.**, of **Huangyan, Taizhou, Zhejiang
Province, China** (not Guangdong). PASMO is the manufacturer's **own brand**, not a trading
label. Current entity established **January 2013**, tracing a predecessor lineage to a 1978
mould factory. **PASMO USA** is the US arm (est. 2016).

Product scope: soft-serve ice cream machines (core line), plus hard/gelato machines,
cream-whipping, milkshake, smoothie and slush machines, and accessories. Named export markets
include US military bases in Japan/Korea, Malaysia (McDonald's, 7-Eleven), Thailand (Lawson).

---

### 2. Where to look — and the traps

| Resource | URL |
|---|---|
| Official site (global) | <https://www.pasmochina.com> (fetch-friendly) |
| US arm | <https://pasmousa.com> (per-model pages, US 110 V framing) |
| Alibaba storefront | pasmo.en.alibaba.com (JS/login-gated — needs a browser) |
| Made-in-China storefront | tzsumstar.en.made-in-china.com (galleries, often watermarked) |

`pasmochina.com` is the best structured source and is automated-fetch friendly. It has a
"Download Center" under Support, but no direct spec-sheet PDF links were exposed in page
bodies. Reseller catalogues (FroCup, Frozen Yogurt Parts, Total Food Machines, ChefsDeal,
Amazon) carry clean spec tables and usually un-watermarked studio photos.

#### Model-range map (S-series soft serve)

Pattern is loose: `S` + digits + **`F`** (the `F` denotes the **gravity-fed freezer**
family; pump-fed variants are labelled "with Air Pump"). The first digit only **loosely**
tracks flavour tier (S1xx single, S2xx two-flavour, S5xx three-flavour freestanding) — it is
**not** a reliable "digit = flavour count" code (e.g. S930F is a single-flavour high-volume
countertop). **Verify each model; do not infer specs from the code.**

#### Traps

1. **OEM / rebadging.** Chinese soft-serve machines commonly share a chassis across many
   brand names. Spaceman and Goshen are Zhejiang peers with visually near-identical machines.
   No source confirms Pasmo *specifically* rebadges the same chassis — treat "same machine,
   different badge" as a risk, not a fact. **Match by Pasmo's own model code and badge, not by
   shape.**
2. **Model-code collisions.** The same "S110F"-style code appears on third-party OEM listings
   with contradictory specs (e.g. ottmachine.com lists a "Pasmo S110F 4-flavor", contradicting
   the genuine 1-flavour S110F). Trust only official Pasmo / US-arm sources for canonical data.
3. **US-market SKUs and voltages.** US listings append config/voltage suffixes (`A2`, `-TLA2`
   gravity, `-TLAP2`/`W2` air-pump) and are **110 V / 60 Hz** — do not copy their electrical
   data. Kenya wants the **220–230 V / 50 Hz single-phase** international build.
4. **Three-phase option on the S520F.** The freestanding S520F is offered in **220 V
   single-phase or 380 V three-phase** — confirm the single-phase build is what's ordered.
5. **Watermarked marketplace photos and spec inflation** on Alibaba/Made-in-China/DHgate —
   cross-check capacity against pasmochina.com figures (S110F 20 L/h, S230F 30 L/h, S520F 50 L/h).

---

### 3. Product reference

| SKU | Catalogue name (now) | Model | What it is | Official page |
|---|---|---|---|---|
| IMG/ICE/00017 | Ice Cream Machine Table Top S110F | S110F | Countertop, single-flavour, gravity-fed | [S110F](https://www.pasmochina.com/product/473/474/476/) |
| IMG/ICE/00029 | Ice Cream Machine Table Top S230F | S230F | Countertop, 2 flavours + twist | [S230F Gravity](https://www.pasmochina.com/product/473/515/519/) |
| IMG/ICE/00018 | Ice Cream Machine Free Standing S520F | S520F | Freestanding, 3 flavours (2 + twist) | [S520F Gravity](https://www.pasmochina.com/product/473/617/780/) |

All three model codes were **verified genuine on Pasmo's own sites** and **left unchanged**.
`S230F` / `S520F` / `S110F` are the correct base designations; US suffixes like `A2` /
`-TLA2` denote voltage/feed variants of the same base model.

---

### 4. Data audit — errors found and corrected

#### 4.1 S110F (IMG/ICE/00017) — wrong hopper capacity + wrong/scrambled dimensions ⚠

- **Hopper capacity was wrong**: record said **6.5 L**; every manufacturer/reseller source says
  **9.5 L**. Corrected.
- **Dimensions were both scrambled and wrong**: stored `length 785 / width 730 / height 385`.
  Width/height were transposed (a countertop unit is narrow and tall), **and** the depth was
  wrong (785 ≠ verified 720). Corrected to **L 720 × W 385 × H 728 mm**.
- **Added** (were absent): cylinder 1.6 L, total power 1.5 kW, Aspera compressor 3,753 BTU/h,
  R404A, net weight 90 kg.

#### 4.2 S520F (IMG/ICE/00018) — wrong/scrambled dimensions + understated hopper ⚠

- **Dimensions were scrambled and wrong**: stored `length 785 / width 1539 / height 820`
  (reads a floor machine as short-and-wide, impossible). Even the unscrambled on-record spec
  didn't match. Corrected to **L 855 × W 636 × H 1517 mm** (manufacturer's own page states a
  940 mm length — resellers agree on ~851–855, so 855 used; flagged here as the one figure
  Pasmo doesn't reconcile).
- **Hopper capacity understated**: record said 12.5 L; it is **2 × 12.5 L (25 L total)**.
  Added cylinder **2 × 2.0 L**.
- **Added**: 2 compressors (3,753 BTU/h each, Embraco/Tecumseh), R404A, air/water cooling,
  2 × 550 W drive motors, total power 3.2 kW, net weight 226 kg, and the 380 V 3-phase note.
- Name given the model suffix ("…Free Standing **S520F**") for identifiability.

#### 4.3 S230F (IMG/ICE/00029) — dimensions correct; compressor brand fixed; specs reformatted

- **Dimensions confirmed correct** (770 × 520 × 969 mm, axes right) — no change. Net/gross
  weights (168 / 183 kg) confirmed.
- **Compressor brand corrected**: record said "Embraco/Tecumseh". Pasmo states **Aspera** (an
  Embraco marque, so "Embraco" is defensible); **"Tecumseh" is unsupported and was dropped**.
- **Cylinder capacity kept at 1.6 L × 2** (weight of sources: US resellers + Amazon), though
  **Pasmo's own China page says 2 L × 2** — an unresolved manufacturer-vs-reseller conflict,
  recorded here.
- The crammed run-on `<p>` description and identical spec blob were rebuilt into a clean
  prose + `Key Features` description and an HTML spec table.
- Name normalised ("…Table Top S230F", dropping the redundant "Pasmo" the siblings don't carry).

#### 4.4 Applied to all three

`meta_description` added to all three (all were missing); bare `<ul>`/`<p>` spec stubs
replaced with HTML `<table>` blocks matching the catalogue pattern; descriptions rewritten
into prose + `Key Features`.

---

### 5. Not published / unverified — left out rather than invented

- **S110F**: refrigerant charge for the 230 V build (only the US 110 V page gives ~500 g R404A);
  carton dimensions in mm (only imperial published). Beater-motor power stated 0.37–0.55 kW
  (sources disagree) — omitted from the customer spec.
- **S520F**: amperage for a 50 Hz build; noise level (marketed "quietest", no dB figure); the
  manufacturer's own 940 mm length vs resellers' ~855 mm is unreconciled.
- **S230F**: explicit **SS304** grade and "self-check" agitator wording are manufacturer-typical
  but not published for this model — the spec says "stainless steel" without asserting the grade;
  second compressor brand ("Tecumseh") is unsupported.

---

### 6. Image sourcing — for manual review

No image field was changed this pass. Best sources, ranked: (1) **official `pasmochina.com`
product pages** — clean, brand-consistent studio renders on `pasmochina.com/uploads/image/...`,
fetch-friendly, watermark-free; (2) **`pasmousa.com` model pages** — clean US studio shots;
(3) **reseller catalogues** (FroCup, ChefsDeal, Total Food Machines, RestaurantSupply) —
white-background, generally un-watermarked; (4) **Made-in-China / Alibaba storefronts** — deep
galleries but often watermarked and JS-gated. All URLs below returned **HTTP 200 at time of
writing**. Watch for OEM-rebadged look-alikes — confirm a Pasmo badge before using.

#### 6.1 S110F — IMG/ICE/00017

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| Pasmo (mfr) | [S110F](https://www.pasmochina.com/product/473/474/476/) | <https://www.pasmochina.com/uploads/image/20220401/15/03f5a9a523ba18140f5d4323f2aac466.jpg> | 200, jpeg, 84 KB | **Best** — main product photo, exact model, clean, no watermark. |
| Pasmo (mfr) | (same) | <https://www.pasmochina.com/uploads/image/20220401/15/d5cafe4ca92b396795cec99f7834a574.jpg> | 200, jpeg, 58 KB | Alt angle. |
| Pasmo (mfr) | (same) | <https://www.pasmochina.com/uploads/image/20220401/15/7c468ab866bade5b0d37acaf608c8367.jpg> | 200, jpeg, 51 KB | Alt angle. |
| Pasmo USA | [S110F](https://pasmousa.com/machine/s110f-table-top-soft-serve-freezer/) | <https://pasmousa.com/wp-content/uploads/S110F.webp> | 200, webp, 105 KB | Clean studio shot; US-market unit, same machine. |

**Best pick:** `03f5a9a5…jpg` (mfr, exact model, largest clean JPEG). **Dead/blocked:** DS
Refrigeration UK page → HTTP 429 (rate-limited).

#### 6.2 S230F — IMG/ICE/00029

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| Pasmo (mfr) | [S230F](https://www.pasmochina.com/product/473/515/519/) | <https://www.pasmochina.com/uploads/image/20220416/10/49edb6b40e8f1964b22bb76e65f614fa.jpg> | 200, jpeg, 101 KB | **Best** — alt "Soft serve machine S230F", exact model, no watermark. |
| Pasmo (mfr) | (same) | <https://www.pasmochina.com/uploads/image/20220416/10/4ba429e177e4e30bb96976f5bee6d8b3.jpg> | 200, jpeg, 76 KB | Angle/detail shot. |
| Pasmo (mfr) | (same) | <https://www.pasmochina.com/uploads/image/20220416/10/d9b793a8fdc66b8e0f78c5a0f3e948f3.png> | 200, png, 85 KB | PNG (possible transparent background). |
| ChefsDeal | [S230FA2](https://www.chefsdeal.com/) | <https://media.chefsdeal.com/pub/media/catalog/product/p/a/pas-s230fa2-pas-s230fa2.jpg> | 200, jpeg, 57 KB | S230FA2 gravity variant, Pasmo badge, clean studio. |

**Best pick:** `49edb6b4…jpg` (mfr, largest, exact S230F). Alternate: ChefsDeal `pas-s230fa2.jpg`.
**Dead/blocked:** foodserviceequipmentdepot.com, restaurantsupply.com → HTTP 403 (fetch); a
`…8a5fb2ea….png` mfr file loads but is a ~3 KB feature icon, excluded.

#### 6.3 S520F — IMG/ICE/00018

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| Pasmo (mfr) | [S520F](https://www.pasmochina.com/product/473/617/780/) | <https://www.pasmochina.com/uploads/image/20220416/11/afa72722935d81d3e67244a8c016473b.jpg> | 200, jpeg, 84 KB | **Best** — main photo, exact model, clean, no watermark. |
| Pasmo (mfr) | (same) | <https://www.pasmochina.com/uploads/image/20220416/11/eb870df9300a35797d9ea27d6002f9f7.jpg> | 200, jpeg, 101 KB | Gallery angle. |
| Pasmo (mfr) | (same) | <https://www.pasmochina.com/uploads/image/20220416/11/78ebb9c8a6e7641efb32c40acd244d05.jpg> | 200, jpeg, 86 KB | Gallery angle. |
| FroCup | [S520F bundle](https://frocup.com/product/soft-serve-machine-pasmo-s520f-value-bundle/) | <https://frocup.com/wp-content/uploads/2016/11/Pasmo-S520F-Inside-500x500.jpg> | 200, jpeg, 44 KB | Interior/mechanism (500×500, low-res). |

**Best pick:** `afa72722…jpg` (mfr, hi-res, watermark-free) as primary, plus `eb870df9…` /
`78ebb9c8…` for angles. **Dead/blocked:** frozenyogurtparts.com → 403; pasmousa Twin-Twist
page → 404.

---

### 7. Summary of `products.json` changes this pass

All 3 SKUs enriched; **no `model_number` changed** (all verified genuine).

- **Corrections**: S110F hopper 6.5 → **9.5 L** and dimensions → **720 × 385 × 728**; S520F
  dimensions → **855 × 636 × 1517** and hopper → **2 × 12.5 L**; S230F compressor brand
  Embraco/**Tecumseh** → Aspera/Embraco (Tecumseh dropped). S230F dimensions confirmed correct.
- **Built out**: HTML spec tables replacing `<ul>`/`<p>` stubs; prose + `Key Features`
  descriptions; `meta_description` on all 3; recovered specs (cylinder capacities, compressors,
  motor/total power, weights).
- **Names**: S520F given its model suffix; S230F normalised (dropped redundant "Pasmo").
- **No image field changed** — §6 links presented for manual review. All 3 remain `published`.
