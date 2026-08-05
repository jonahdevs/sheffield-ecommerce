# OEM Sheffield Product Research

Research behind the OEM SHEFFIELD pass (35 SKUs), 2026-07-30. This brand had **no research file**
before now. **APPLIED — all 35 are house-format complete (was 6).**

## 1. ⭐ The "Guangdong" supplier identified: Guangdong Perfect Co., Ltd, brand JIWINS

The business named OEM Sheffield's suppliers as **Elaboratex + Wanhui + "Guangdong"**. The third
is now settled.

**Twelve of the 35 SKUs carry `JW-` codes, and SAP's own `Item Remarks` name the maker outright** —
*"JIWINS PLATE AND TRAY RACK"*, *"CUTERY RACK -JIWINS"*. That was the thread worth pulling.

**JIWINS is the brand of GUANGDONG PERFECT CO., LTD.** — founded 2003, 30,000 m², 157 staff,
metal and plastic products for restaurants and commercial kitchens.

- Official catalogue: http://www.jiwins.cn/en/ — per-model pages with a full `Art.No.` table
- Company: https://jiwins.en.alibaba.com/ (registered as Guangdong Perfect Co., Ltd.)
- Distributors: https://www.brightwaycatering.com/en/jiwins ·
  https://tomkin.com.au/collections/jiwins · https://chefcoca.com/collections/jiwins ·
  https://hospeco.ph/product/jiwins-25-comparment-glass-rack/

⚠ **This corrects `oem-placeholder-brands-research.md` §1.8**, which wrote `GUANGDONG PERFECT` off
as "province + supplier trade name". It is a real manufacturer. The asset path on jiwins.cn is
literally `/gdpfjd…/` — **gdpf = GuangDong PerFect**.

Two clues were already in our own data: `IMG/STO/00009` is named *"PVC Shelves Vented 910
**Perfect**"*, and `brands.json` has carried an orphan **`Perfect`** row all along.

⚠ **Scraping note:** on jiwins.cn, page 1 of a category is `list_lcid_N.html` with **no**
`_page_` suffix; only later pages use `_page_M`. A loop that starts at `_page_1` gets nothing and
exits before reaching the real listing.

## 2. Jiwins `Art.No.` data — 28 codes recovered

Each product page carries `Art.No. | Name | Overall Size | Comp.Size | Colour | Material |
PCS/CTN`. Recovered verbatim (all racks are 500 × 500 × 100 mm unless noted):

| Code | Overall | Compartment | Name |
|---|---|---|---|
| `JW-9` / `JW-92` | 500×500×100 / ×45 | 150×150×82 / ×40 | 9-Compartment Glass Rack / Extender |
| `JW-16` / `JW-162` | 500×500×100 / ×45 | 112×112×82 / ×40 | 16-Compartment Glass Rack / Extender |
| `JW-25` / `JW-252` | 500×500×100 / ×45 | 88×88×82 / ×40 | 25-Compartment Glass Rack / Extender |
| `JW-36` / `JW-362` | 500×500×100 / ×45 | 73×73×82 / ×40 | 36-Compartment Glass Rack / Extender |
| `JW-49` / `JW-492` | 500×500×100 / ×45 | 62×62×82 / ×40 | 49-Compartment Glass Rack / Extender |
| `JW-25B` | 500×500×100 | 65×65×66 | 25-Compartment Plate & Tray Rack |
| `JW-25P` | 500×500×100 | 65×65×66 | 25-Compartment Open Plate & Tray Rack |
| `JW-64B` | 500×500×100 | 45×45×72 | 64-Compartment Plate & Tray Rack |
| `JW-64I` | 470×470×74 | 55×55×74 | 64-Compartment Insert Rack |
| `JW-C` | 500×500×100 | 10×10 | Cutlery Rack |
| `JW-4C` | 520×290×100 | 240×110×75 | 4-Compartment Cutlery Box |
| `JW-8B` / `JW-8BH` | 427×208×151 | 90×90×110 | 8-Compartment Cutlery Basket, without / with handle |

## 3. ⚠ What the manufacturer data caught

### 3.1 Our compartment sizes describe the EXTENDER, not the rack

A systematic mix-up across the glass racks:

| SKU | Our stored compartment | Jiwins rack | Jiwins **extender** |
|---|---|---|---|
| `JW-16` | 115 × 115 × 45 | 112 × 112 × **82** | 112 × 112 × **40** |
| `JW-25` | 90 × 90 × 45 | 88 × 88 × **82** | 88 × 88 × **40** |

Our figure is close to the *extender* in both cases — the shallow 40-45 mm depth gives it away.
`JW-64B` is the exception: our 45 × 45 × 72 matches Jiwins exactly.

### 3.2 `JW-253` does not exist — Jiwins lists `JW-252`
`IMG/DWW/00043` "Glass Rack Extender 25 Compartment" carries `JW-253`. The 25-compartment
extender is **`JW-252`**. ⚠ **Flagged, not changed** — `model_number` is the unique ID.

### 3.3 `JW-36`'s SAP remark is wrong
`IMG/DWW/00098` is named "Glass Rack 36 Compartment" but its remark reads *"Glass Rack - **25**
Compartment"* — copy-pasted from JW-25. Jiwins confirms `JW-36` really is 36-compartment
(73 × 73 × 82). **The name is right and the remark is wrong** — worth correcting in SAP.

### 3.4 `JW-S` is on two SKUs
`IMG/DWW/00110` ("Open Rack Jw-Ss") and `IMG/DWW/00143` ("Open Rack JW-S") share the code.

### 3.5 `JW-DC48` stores 24 × 126 × 60 mm
A mobile plate rack for 48 plates cannot be 24 mm on any axis. Not in the Jiwins catalogue pages
scraped (a different category). Needs sourcing.

## 4. APPLIED

**10 dimension corrections** from the Jiwins `Art.No.` table:

| SKU | Model | Was | Now |
|---|---|---|---|
| IMG/DWW/00101 | `JW-16` | 500 / **100** / **500** | 500 / 500 / 100 |
| IMG/DWW/00104 | `JW-25` | 500 / **100** / **500** | 500 / 500 / 100 |
| IMG/DWW/00103 | `JW-25B` | 500 / **100** / **500** | 500 / 500 / 100 |
| IMG/DWW/00142 | `JW-25P` | 500 / **100** / **500** | 500 / 500 / 100 |
| IMG/DWW/00097 | `JW-64B` | 500 / **100** / **500** | 500 / 500 / 100 |
| IMG/DWW/00040 | `JW-162` | 500 / 500 / **100** | 500 / 500 / **45** (extender is shallower) |
| IMG/DWW/00098, 00110, 00143, 00144 | `JW-36`, `JW-S` ×2, `JW-C` | *(blank)* | 500 / 500 / 100 |

**All 35 SKUs given house-format copy** — facts from SAP `Item Remarks`, with **Jiwins overriding
the remark for the `JW-` racks** (§3.1). `ProductCatalogueKeysTest` 9/9.
Catalogue-wide house-format: **517 → 546 of 683.**

⚠ **OEM Sheffield remarks use different separators from SV-Blueline** — `*` and ` - ` rather than
`;`, and frequently no colon at all (*"Compartment size 115x115x45"*). A parser tuned to one
brand's punctuation silently returns nothing on the other.

## 5. Still open

- **Images: 6 of 35.** The `JW-` racks can be sourced from jiwins.cn product pages (image URLs
  under `/gdpfjd…/uploadfiles/`), which is the obvious next step.
- The `JW-N4821` / `JW-P3621` / `JW-P4221` / `JW-P4821` shelving and `JW-DC48` are in Jiwins
  categories not yet scraped — only the glass-rack category (lcid 39) was walked.
- The 6 ex-Iberna ice machines (`ZBJ-*`) reassigned here by SAP still carry Iberna research;
  see `iberna-research.md`.
- `JW-253` → `JW-252` needs a `model_number` decision.

---

## Sourcing pass, 3 August 2026 - JIWINS racks and shelving - 16 SKUs

## OEM SHEFFIELD - JIWINS half (16 SKUs) - image + spec sourcing

Pass run 2026-08-03. Scope: the 12 `JW-` dishwasher/glass racks under `IMG/DWW/` and the
4 shelving units under `IMG/STO/`. The buffet / fryer / ice-machine SKUs belong to a sibling
agent and were not touched.

**All 16 SKUs sourced.** 39 files staged. `products.json`, `brands.json`, `storage/`,
`_DOSSIER.md`, `_dossier.json` and `oem-sheffield-research.md` were **not** modified.

---

### 1. The supplier route, and how the images were actually reached

SAP names the maker outright (*"JIWINS PLATE AND TRAY RACK"*, *"CUTERY RACK -JIWINS"*), and
JIWINS is the brand of **Guangdong Perfect Co., Ltd**. Two routes were used:

**Route A - jiwins.cn (the manufacturer).** The site is HTTP-only, so `WebFetch` fails outright
(it upgrades to HTTPS and the host refuses :443). It has to be fetched with `curl`/`urllib` over
plain HTTP. It is also extremely slow - roughly **85 KB/min sustained**.

⚠ **The product gallery is not in the HTML.** `<div id="div_pic">` is empty on delivery and is
filled by two POSTs to `/Ajax/AjaxDataEn.aspx`:

- `action=GetColor&id=<itemid>` returns the colour options
- `action=getImgList&id=<colourId>&type=1` returns `ImageUrl2`, a `*`-separated image list

Only the two "Features" diagrams sit in the static HTML. **A scrape that reads the product page
alone gets 2 images and misses the entire product gallery.** Hitting the AJAX endpoint directly
is the way in.

⚠⚠ **The single most valuable find: every JIWINS image URL carries a base64 query string that
decodes to the ORIGINAL filename, and those filenames are article-number-keyed.**
`...20200728122121015.jpg?MjUyLmpwZw==` decodes to `252.jpg`. That is how a shared category page
covering four article numbers was resolved down to one image per code. Worth reusing on any
other site built on this Chinese CMS (the asset path is `/gdpfjd202006198904/`, gdpf = GuangDong
PerFect).

**Route B - Australian distributors on Shopify.** `tomkin.com.au`, `essentialutensil.au`,
`hospitalityconnect.com.au` and `chefcoca.com` all expose `/products.json` (9,750 products each
for the first three - they share a backend). This yielded **1200x1200** code-keyed images where
jiwins.cn caps at 718x506, and it is the only source for `JW-DC48` and the shelving.

- https://www.jiwins.cn/en/ProductCenter/list_lcid_39.html
- https://tomkin.com.au/collections/jiwins
- https://hospeco.ph/product/jw-dc84-jiwins-mobile-plate-rack-for-84-plates/
- https://gzwanyi.en.made-in-china.com/product/CKYxsgJcEhWF/China-Mobile-Plate-Rack-for-48-Plates-JW-DC48-.html

⚠ The mirror `gzwins.com` that appears in search results is **dead** (connection refused).

---

### 2. The three defects I was asked about - explicit answers

#### 2.1 Extender-vs-rack heights: SETTLED, and our record is half right

JIWINS publishes both in one table per product page. The rule is uniform across the whole family:

| | Overall size | Compartment |
|---|---|---|
| **Base glass rack** (`JW-9/16/25/36/49`) | 500 x 500 x **100** mm | ... x ... x **82** mm |
| **Standard extender** (`JW-92/162/252/362/492`) | 500 x 500 x **45** mm | ... x ... x **40** mm |

The `-spec` sheet staged with each rack SKU (*"Glass Rack Sizing Guide Instruction"*, 2576x3089)
states it independently: base rack interior **82 mm**, and **each extender adds ~40 mm**
(82 → 122 → 162 → 202 → 242 mm for 0/1/2/3/4 extenders). Two sources agreeing.

**So:**

| SKU | Model | Stored | Correct | Verdict |
|---|---|---|---|---|
| `IMG/DWW/00040` | `JW-162` (extender) | 500/500/**45** | 500/500/45 | ✅ **already right** |
| `IMG/DWW/00043` | `JW-253` (extender) | 500/500/**100** | 500/500/**45** | ❌ **wrong - it carries the rack's height** |
| all other racks | | 500/500/100 | 500/500/100 | ✅ right |

⚠ The prior pass called `00040`'s 45 mm suspicious. It is not - **45 is correct and 00043 is the
one that is wrong.** SAP is wrong on both (it says 100 for both extenders).

The compartment-size leak the prior pass found is confirmed and slightly wider than recorded:

| Model | Our stored comp. | JIWINS rack | JIWINS extender |
|---|---|---|---|
| `JW-16` | 115x115x45 | 112x112x**82** | 112x112x**40** |
| `JW-25` | 90x90x45 | 88x88x**82** | 88x88x**40** |
| `JW-64B` | 45x45x72 | 45x45x72 | - |

**Not applied.** Reported only.

#### 2.2 The duplicate `JW-S`: JIWINS publishes exactly ONE

Product page 672 (*"Open Rack, Cutlery Rack"*) lists precisely two article numbers:

| Art.No. | Name | Overall | Comp. |
|---|---|---|---|
| `JW-S` | Open Rack | 500x500x100 mm | 36x36 mm |
| `JW-C` | Cutlery Rack | 500x500x100 mm | 10x10 mm |

**There is no `JW-Ss`.** I searched the full 137-product JIWINS catalogue and four distributor
catalogues; the string does not exist. So `IMG/DWW/00110` ("Open Rack Jw-Ss") and
`IMG/DWW/00143` ("Open Rack JW-S") are **two SKUs for one product**, and the "Ss" is a typo,
not a second article number.

**Recommendation only, not applied:** treat `00143` (stock 66, SAP remark *"OPEN RACK BLUE
-JIWINS"*) as the live record and `00110` (stock 2, bare remark *"Open Rack"*) as the duplicate
to retire. Both are stored at 500/500/100, which JIWINS confirms - so no dimension change is
needed either way. `model_number` untouched on both.

One candidate for a genuine second product exists if the business insists the two SKUs are
distinct goods: `JW-P` **Open Extender**, 500x500x**45** mm (page 681). It is the open-profile
counterpart to `JW-S`, and its shallower height would explain a separate line. Unverified guess -
flagged, not acted on.

#### 2.3 `JW-DC48` at `24/126/60`: the units are the problem

JIWINS product page 769 publishes the whole mobile-plate-rack family:

| Art.No. | Name | Size | Axis width | Max width |
|---|---|---|---|---|
| `JW-DC12B` | Plate Rack for 12 plates | 350x350x460 mm | 245 mm | 350 mm |
| `JW-DC48B` | Plate Rack for 48 plates | 545x545x1080 mm | 245 mm | 560 mm |
| **`JW-DC48`** | **Mobile Plate Rack for 48 plates** | **730x730x1260 mm** | 245 mm | 600 mm |
| `JW-DC84` | Mobile Plate Rack for 84 plates | 730x730x1910 mm | 245 mm | 675 mm |

Our stored `24/126/60` is centimetres-and-garbled: **126 is the height in cm (1260 mm)** and
**60 is the max width in cm (600 mm)**, both of which appear verbatim in the JIWINS table. The
`24` has no counterpart. So it is a unit error compounded by a field error, not a transposition.

⚠ **Two different footprints are in circulation and the business should pick one.** JIWINS and
Tomkin's *product title* both say **730x730**; Tomkin's own *image filename* and two other
Australian distributors say **650x590**. Same height (1260) everywhere.
730x730 is very likely the splayed caster footprint and 650x590 the frame - but that is
inference, so **1260 mm height is the only figure I would call settled**.

- https://tomkin.com.au/products/jiwins-mobile-plate-rack-to-hold-48-plates
- https://www.ahwarehouse.com.au/mobile-plate-rack-to-hold-48-plates
- https://hospitalityconnect.com.au/products/jiwins-mobile-plate-rack-for-48-plates-s-s-650x590x1260mm

Note also `JW-DC48B` exists - a **non-mobile** 48-plate rack at 545x545x1080. Our SKU name says
"Mobile", so `JW-DC48` is the right match, but the pair is worth knowing about.

---

### 3. New findings this pass did not go looking for

#### 3.1 ⚠⚠ JIWINS serves a 25-compartment photo on its own 16-compartment product page

Product page 669 (`JW-16` / `JW-162`) carries three images. Decoded filenames `16.jpg`,
`162.jpg` and `161.jpg`. The first two are correct. **`161.jpg` shows a 5x5 = 25-compartment
rack**, counted twice at two crop levels against a known-good `JW-25` shot.

By the naming convention used across the family (`251.jpg` and `361.jpg` are both "rack with one
extender fitted"), `161.jpg` should have been a 16-compartment rack with an extender. It is not.

**It was rejected, not used**, and kept as evidence at
`_brand-reference/JIWINS-DEFECT__jiwins-page-JW-16-carries-a-25-compartment-photo-161.jpg`.
This is exactly why compartments get counted by eye: the file is on the right product page, has
the right code-shaped filename, is the right size, and is the wrong product.

#### 3.2 ⚠⚠ `JW-C` has no photograph of its own - the file is byte-identical to `JW-S`

`JW-C.jpg` and `S.jpg` are served under two distinct, article-number-keyed filenames from the
manufacturer's own gallery, and they are **the same file**: identical MD5, RMS 0.00 at 256x256.
Rendering confirms it - both show the open-lattice `JW-S` rack, not a 10x10 mm cutlery grid.

This is the "code-keyed filename proves intent, not provenance" failure in its purest form, and
it came from the **manufacturer**, not a reseller. `IMG/DWW/00144` is tagged
`REPRESENTATIVE-RANGE` with `code_proven: false`. **No true `JW-C` photograph exists on the open
web** - not on jiwins.cn, not at any of four distributor catalogues.

#### 3.3 SAP transposes width and depth on all four shelving SKUs

The shelving codes are self-documenting once decoded, and they settle the axis order without
needing to trust SAP:

**`JW-P` / `JW-N` + WW + DD = width in inches + depth in inches.** JIWINS' own full code adds
the height: `PSU` + WW + DD + HH.

| Our code | JIWINS code | JIWINS size | SAP W/D/H | Verdict |
|---|---|---|---|---|
| `JW-P3621` | `PSU362172` | 910 x 530 x 1800 | 530/910/1800 | SAP **transposed** |
| `JW-P4221` | `PSU422172` | 1060 x 530 x 1800 | 530/1060/1800 | SAP **transposed** |
| `JW-P4821` | `PSU482172` | 1220 x 530 x 1800 | 530/1220/1800 | SAP **transposed** |
| `JW-N4821` | `JW-CN4821..` | 1220 x 530 x 1800 | 530/1220/1800 | SAP **transposed** |

36 in = 910 mm, 42 in = 1060, 48 in = 1220, 21 in = 530. Four for four. **Our `products.json`
already stores width-first and is correct on width and height** - but stores **depth 500 where
JIWINS says 530** on all three PVC SKUs. Small, but wrong, and worth a correction.

This is the third house brand in this effort where SAP's dimension ORDER, not just its values,
has failed. Treat SAP's axis order as unproven per brand.

⚠ `PSU` = **vented** starter unit, `PSS` = **solid**. Our SKUs say "Vented", so `PSU` is right.

#### 3.4 The chrome wire shelving is not on jiwins.cn at all

`JW-N4821` has no product page on the current JIWINS site - the shelf category (lcid 36, 11
products) has the polymer Winshelvings (`PSU`/`PSS`), aluminium composite, epoxy wire (`EN`) and
dunnage racks, but no chrome wire. Tomkin stocks it as the `JW-CN` family, which is where the
image came from. The SAP remark for `00005` also mentions *"the Clarke boltless shelving unit"* -
**"Clarke" is a UK tool brand and is almost certainly copy pasted in from an unrelated listing.**
Worth removing from the description whenever that field is next touched.

---

### 4. Shared-image audit - the honest count

Detection was **16x16 average hash first, then a 256x256 greyscale RMS confirmation**. The ahash
alone was useless here: every rack is the same blue object on white at the same angle, so it
produced ~45 false pairs at Hamming distance 4-12. **RMS < 12 separated true duplicates cleanly.**
Recording that because ahash-only would have mislabelled half this range.

**5 of my 16 SKUs carry an image that is shared with another product. All 5 are tagged.**

| SKU | Model | Tag | Shared with |
|---|---|---|---|
| `IMG/DWW/00110` | `JW-S` | `REPRESENTATIVE-RANGE` | `JW-C`, and SKU 00143 |
| `IMG/DWW/00143` | `JW-S` | `REPRESENTATIVE-RANGE` | `JW-C`, and SKU 00110 |
| `IMG/DWW/00144` | `JW-C` | `REPRESENTATIVE-RANGE` | byte-identical to `JW-S` |
| `IMG/STO/00005` | `JW-N4821` | `REPRESENTATIVE-RANGE` | one photo covers all four `JW-CN` sizes |
| `IMG/STO/00008` | `JW-P4821` | `NEARMATCH` | byte-identical to `JW-PSU482472` |

`IMG/STO/00007` and `IMG/STO/00009` are tagged `NEARMATCH` (right width and height, 455 mm depth
instead of 530 mm) but their photographs are genuinely distinct from each other and from 00008.

`IMG/DWW/00043` is tagged `CODEMISMATCH` - correct product, article number JIWINS does not
publish.

The remaining **9 SKUs carry a unique, article-number-keyed image with a verified compartment
count**, and none of them is a range shot.

---

### 5. AI-generated check

**Nothing synthetic found. `_ai-generated\` was not created.**

All 45 candidate images were opened and viewed, not merely hashed. The rack images are studio
product renders - consistent camera angle, consistent NSF badge placement, correct and countable
divider geometry, physically coherent lattice shadows. The shelving images are conventional
white-background product photography. The two 2576 px "features" assets are typeset technical
diagrams with legible English annotation and internally consistent numbers (the 82/122/162/202/242
extender ladder matches the Art.No. table computed independently). No AI tells.

---

### 6. Resolution: the 800 px floor is not reachable from JIWINS

| Source | Ceiling | Notes |
|---|---|---|
| jiwins.cn product gallery | **718 x 506** | short edge **506 px - below the 800 px floor** |
| jiwins.cn "Features" assets | **2576 x 3089** | far above the floor; these are the spec sheets |
| Tomkin Shopify CDN | **1200 x 1200** | above the floor; used for all 4 shelving SKUs and `JW-DC48` |

**The 506 px ceiling on the JIWINS gallery is proven, not assumed.** Every gallery image in the
catalogue is exactly 718x506; there is no `-scaled`/`-800-800` suffix to strip, no larger variant
behind the base64 query string, and the listing thumbnails resolve to the same files. Tomkin does
not stock the glass racks, so 1200 px could not be had for them.

10 of the 12 rack SKUs are therefore staged at 718x506 (short edge 506). This is the best that
exists for these products, and each is paired with a 2576 px spec sheet that carries the
dimensions.

---

### 7. What I could not reach

- **The 105 MB 2025 JIWINS catalogue PDF** at
  https://www.jiwins.cn/uploadfiles/2025/04/20250421092556103.pdf
  is the one asset that would likely beat 506 px on the racks. At the server's sustained
  ~85 KB/min it needs roughly **10 hours**; a resumed download reached ~3 MB of 105 MB.
  Two smaller catalogues (30 MB and 32 MB, from 2024 and 2023) are the same problem at
  ~6 hours each. **All three are resumable with `curl -C -` and the URLs are recorded below -
  this is a time limit, not a dead end, and it is the single highest-value follow-up.**
  - https://www.jiwins.cn/uploadfiles/2025/04/20250421092556103.pdf
  - https://www.jiwins.cn/uploadfiles/2024/05/20240506094254604.pdf
  - https://www.jiwins.cn/uploadfiles/2023/04/20230420172633939.pdf
  - Index page: https://www.jiwins.cn/en/DirectoryDownload/list.html
- **A genuine `JW-C` cutlery rack photograph.** Does not appear to exist publicly. §3.2.
- **The exact `JW-N4821` and `JW-P*2172` (21 in / 530 mm depth) codes at a distributor.** Only
  the 14 in / 18 in / 24 in depths are stocked, hence the `NEARMATCH` tags.
- `ahwarehouse.com.au` returns **403** to non-browser clients; its listings were read through
  search results only.

No search outage occurred - WebSearch and all four distributor catalogues responded throughout.
Where I report something as absent (notably `JW-Ss` and a real `JW-C` photo) that is a searched
negative across five catalogues, not a failed lookup.

---

### 8. Recommended corrections - reported, NOT applied

None of these were written to `products.json`. `model_number` is untouched everywhere.

1. `IMG/DWW/00043` `JW-253`: height **100 → 45** mm (it is an extender).
2. `IMG/STO/00007` / `00008` / `00009`: depth **500 → 530** mm.
3. `IMG/DWW/00105` `JW-DC48`: **24/126/60 → 730/730/1260** (or 650/590/1260 - see §2.3; the
   business should pick a footprint convention).
4. Compartment sizes on `JW-16` and `JW-25` currently describe the extender - see §2.1.
5. `IMG/DWW/00110` vs `00143`: duplicate SKU for one product - a business decision, §2.2.
6. `JW-253` → `JW-252` remains an open `model_number` decision from the prior pass. Confirmed
   again here: JIWINS publishes `JW-252` and nothing named `JW-253`.
7. SAP data errors worth pushing back upstream: `JW-36`'s remark says "25 Compartment";
   `JW-162`/`JW-253` heights; the width/depth transposition on all four shelving SKUs.
8. `IMG/STO/00005` description mentions a "Clarke boltless shelving unit" - foreign copy, §3.4.


---

## Sourcing pass, 3 August 2026 - Buffet, fryers, vacuum packers and ZBJ ice machines - 19 SKUs

## OEM SHEFFIELD - buffet + ice provenance pass

19 SKUs (the buffet/catering items and the six ex-IBERNA `ZBJ-` ice machines).
The sibling `JW-` rack/shelving set is not covered here.

Ledger: `_sourced-buffet-ice.json`. Files: this folder, `_brand-reference\`, `_ai-generated\`.
Nothing in `products.json`, `brands.json` or `storage/` was touched, and no `model_number`
was changed or proposed for change.

---

### 1. ⚠⚠ THE R290 CLAIM IS WRONG ON EVERY MACHINE IT APPEARS ON

**R290 does not appear anywhere in Iberna's own published specification tables.**
All 29 `ZBJ-` cube-ice models were scraped directly from the manufacturer. Every one lists
**R134a or R404a** and nothing else.

R290 exists only on Iberna's Made-in-China storefront comparison tables, and there it is
written as **"R134a/R290"** and **"R404a/R290"** — an *alternative fill the factory will
build*, quoted alongside the standard one. It is never the standard.

#### Per machine — the actual refrigerant

| SKU | Our model | Manufacturer's stated refrigerant | Our record says | Verdict |
|---|---|---|---|---|
| `IMG/REF/00022` | `ZBJ-40P` → 40PA / 40PC | **R134a** | R290 | ⚠ **WRONG** |
| `IMG/REF/00021` | `ZBJ-60P` → 60PA / 60PC | **R404a** | R290 | ⚠ **WRONG** |
| `IMG/REF/00209` | `ZBJ-80PA` | **R404a** | R290 in the description, R404a in its own spec table | ⚠ **WRONG and self-contradictory** |
| `IMG/REF/00020` | `ZBJ-100L` → **100LC** | **R404a** | R404a | ✅ correct |
| `IMG/REF/00019` | `ZBJ-150L` | **R404a** | R404a | ✅ correct |
| `IMG/REF/00210` | `ZBJ-250L` | **R404a** | R404a | ✅ correct |

So the defect is on **three** machines, not five: `00022`, `00021`, `00209`. The two split
machines and the 100 kg were already right.

**Physical corroboration was found, not just documentation.** Two photographed export cartons
print the refrigerant on the crate:

- `IMG-REF-00019__ZBJ-150L-CARTON-LABEL-R404A-evidence-3.jpg` — reads `REFRIGERANT:R404A`
- `IMG-REF-00210__ZBJ-250L-CARTON-LABEL-R404A-evidence-3.jpg` — the same crate stencil

That is a shipped unit, in a warehouse, labelled R404a. **Nothing anywhere shows a shipped
R290 unit.**

⚠ **Why this matters beyond a spec typo:** R290 is propane, a flammable A3 hydrocarbon with
its own charge limits, siting rules and servicing regime. A buyer specifying an installation
off "R290 refrigerant" would be planning for a machine we do not appear to sell. Not applied,
per instruction — but this is the highest-priority item in the pass.

Sources:
http://www.ibernaice.com/?list_45/343.html ·
http://www.ibernaice.com/?list_45/352.html ·
http://www.ibernaice.com/?list_45/345.html ·
http://www.ibernaice.com/?list_46/364.html ·
http://www.ibernaice.com/?list_46/366.html ·
https://icemachineproduce.en.made-in-china.com/

---

### 2. The `A` / `C` variant letters — the standing hypothesis is DISPROVED

The open question was whether `A` and `C` mean **air-cooled vs water-cooled**. They do not.

**Iberna's own spec table lists `Cooling Type: Air Cooling/Water Cooling` for BOTH letters**,
at every capacity where both exist:

| Model | Cooling | Refrigerant | Power | Net size (W×D×H) | Bin |
|---|---|---|---|---|---|
| `ZBJ-40PA` | Air **/ Water** | R134a | 440 W | 507×585×750 | 15 kg |
| `ZBJ-40PC` | Air **/ Water** | R134a | 440 W | 507×585×750 | 15 kg |
| `ZBJ-60PA` | Air **/ Water** | R404a | 550 W | 677×585×895 | 30 kg |
| `ZBJ-60PC` | Air **/ Water** | R404a | 550 W | 677×585×895 | 30 kg |

Every published figure is identical across the pair. A single machine offered air *or* water
cooled cannot also be split into an "air" model and a "water" model.

**What the letters actually track is the cabinet body**, which the photography shows plainly:

- **`PA`** — wide squat cabinet, full-width black top-hinged lid, condenser grille across the
  bottom front, unbadged.
- **`PC`** — narrow tall upright, badged **`iberna`** + **`SnowMate®`**, small top door with a
  red orientation sticker, LCD panel, grille lower-right.

⚠ But this cannot be stated as fact either, because **Iberna publishes the same dimensions for
both bodies**, which is impossible. The honest position: the letter is a cabinet/trim/generation
variant that Iberna does not document, and **the supplier must be asked**. What *is* now settled
is that it is not the cooling method.

#### `ZBJ-100L` → the `A`/`C` question IS resolved, by our own SAP data

SAP's remark for `IMG/REF/00020` states **"Total power output 1100 W"**.

| Model | Power | Bin | Net size |
|---|---|---|---|
| `ZBJ-100LA` | 850 W | 30 kg | 677×575×895 |
| **`ZBJ-100LC`** | **1100 W** | **35 kg** | **680×585×895** |

**1100 W is `ZBJ-100LC` exactly.** Our own SAP remark was transcribed from the LC datasheet.
The prior research rated this "Medium confidence on which of LA/LC ships"; it is now high.
`IMG/REF/00020` is a **`ZBJ-100LC`**. Recommendation only — no `model_number` change proposed.

---

### 3. ⚠ The manufacturer contradicts itself on split-machine power — do not publish a figure

The same storefront gives two different power tables for the same six models:

| Model | 150 kg product page | 250 kg product page | ibernaice.com |
|---|---|---|---|
| `ZBJ-150L` | 950 W | **1400 W** | *(not published)* |
| `ZBJ-200L` | 980 W | 1600 W | *(not published)* |
| `ZBJ-250L` | 1200 W | **1800 W** | *(not published)* |

The prior research adopted **1800 W** for `ZBJ-250L`. That figure is real but **uncorroborated** —
the vendor's other page says 1200 W for the same model, and the manufacturer's own website
publishes no power for the split range at all. **No power figure should be published for
`IMG/REF/00019` or `IMG/REF/00210` without supplier confirmation.**

Useful figures that *are* consistent everywhere: `ZBJ-150L` and `ZBJ-250L` share one envelope,
**765×780×1500 mm**, with a **150 kg** ice bin, 22×22×22 mm cube, flow type, R404a. That fills
`IMG/REF/00210`'s empty dimensions.

⚠ Also note `IMG/REF/00019`'s SAP dimensions **600/764/559** are the **head unit alone**
(`764×606×560`), not the machine. The split machine is 1500 mm tall.

---

### 4. ⚠⚠ Perceptual hashing was essential — MD5 would have caught NOTHING

**Across 60 downloaded ice-machine images there was not one byte-identical pair.**
Yet the 16×16 average hash found six groups of images that are the same photograph, re-encoded.

The starkest case: **`ZBJ-150L` and `ZBJ-250L` are served the identical SnowMate hero
photograph** — same pixels, different caption text ("150kgs cube ice" vs "250kgs cube ice").
The caption is far too small to move a perceptual hash, and the re-encode defeats MD5. An
MD5-only check would have passed both as distinct, model-specific photography.

The other groups:

- One pair of cabinet photos (lid closed + lid open) is served on the **40PA, 60PA and 80PA**
  pages. Those cabinets are 507 mm and 677 mm wide — **one photo cannot be all three.**
- One branded upright render is served on **40PC, 60PC and 80PC**.
- A single 32 mm ice-cube macro appears on at least six pages and was initially mistaken for a
  machine photo by the hash alone. **Looking at it was what caught that** — it is in
  `_brand-reference\`, not on any SKU.

**Conclusion: no model-specific photography exists for Iberna's spray range.** Every spray-range
image is tagged `REPRESENTATIVE-RANGE` with `code_proven: false`.

#### The one image that DOES prove a code

`IMG-REF-00209__ZBJ-80PA-CARTON-LABEL-model-evidence-5.jpg` (1000×1215) — a shrink-wrapped
export carton printed `ICE MAKER / MODEL: ZBJ-80PA` under the `iberna` logo. That is the only
`code_proven: true` asset in the whole pass.

---

### 5. ⚠⚠ ONE AI-GENERATED IMAGE FOUND AND QUARANTINED

`_ai-generated\IMG-BUF-00219__431001-heavybao-lifestyle-AI-GENERATED.jpg` (1024×1024) — served
by Guangdong Shunde Heavybao on their Made-in-China listing for model `431001`.

It passed every automated heuristic: correct resolution, correct product type, plausible file
size, served from the vendor's own CDN under a code-keyed listing. **It was only unmistakable
once rendered.** Tells, in order of certainty:

1. The two background chafers are geometrically incoherent — one's lid merges into the counter,
   the other's stand does not resolve into legs.
2. The subject's own frame is impossible: the front-left leg passes in front of a rail that has
   no back half, and the rear-left leg terminates in a stub.
3. The two fuel holders float — the support bar does not attach to anything.
4. Background plates have melted, blobby edges.
5. The counter has a double edge that contradicts its own plank direction.

This is the second confirmed instance of the pattern the brief warned about, and it reinforces
that **a code-keyed filename on a vendor CDN proves the vendor's intent, not the image's
provenance.**

The rest of Heavybao's set is legitimate: clean white-background catalogue renders, real
close-up photographs of the fuel holders and lid hinge, and marketing collages (moved to
`_brand-reference\`).

---

### 6. Who actually makes these — three suppliers identified, one family still open

The business named **Elaboratex + Wanhui + Guangdong Perfect (JIWINS)**. Guangdong Perfect
covers the sibling agent's `JW-` racks. For my 19, the picture is different and **a fourth
supplier is now on the map.**

#### 6.1 ✅ NEW: `431001` / `432102` are **Guangdong Shunde HEAVYBAO Commercial Kitchenware Co., Ltd.**

Not previously in the supplier map. Founded 2006, Junan, Shunde, Foshan, Guangdong;
35,000–40,000 m²; 300+ staff; CE/NSF/FDA/ETL/UL/BSCI/ISO; exports to 60+ countries.

https://www.heavybao.com/ · https://waterboiler.en.made-in-china.com/ ·
https://cnheavybao.en.alibaba.com/

Two independent proofs:

1. **The code family.** A 1,920-page crawl of their storefront recovered **442 bare 6-digit
   model numbers** — `430102`, `430201`, `430301`, `430401`, `431101`, `431103`, `431901` …
   The `43xxxx` block is specifically their chafer/buffet range. `431001` and `432102` sit
   inside it. This is not a coincidence of format; it is their numbering scheme.
2. **The text.** SAP's `Item Remarks` for `IMG/BUF/00219` reads
   *"The base: SS201+SS410,T=1.7mm / The cover: SS201, T=0.65mm / The food pan: SS201, T=0.4mm"*.
   Heavybao's listing carries that string **verbatim, thickness for thickness**.

⚠ **Heavybao is inconsistent about its own code.** Two live listings both declare
`Model NO. 431001`, both quote `635×425×440mm`, but publish **different steel thicknesses**
(T=0.4/0.65/1.7 on one, T=0.55/0.9/2.0 on the other). Ours matches the first. Buy accordingly.

⚠ **`432102` returns nothing anywhere** — not on Heavybao, not on the open web. The window
variant is real and Heavybao sells it, but it appears under the `431001` listing too, so the
window/no-window split that separates `IMG/BUF/00219` from `IMG/BUF/00220` **cannot be proven
from the vendor's own publishing.** Both SKUs are tagged accordingly and neither is code-proven.

⚠ **Dimension conflict:** Heavybao publishes **635×425×440**; we store **645/455/290**.
The 290 looks like the body height with the dome excluded. Worth resolving before publishing.

#### 6.2 ✅ Wanhui confirmed — but it is NOT the source of the `HY-` items

**Wanhui Industrial / Jiangmen Wanhui (万晖实业)**, http://www.whkitchenware.com/
(⚠ plain `http://` only — `https://` serves an `*.fkw.com` certificate and fails TLS).

Their catalogue is exactly our product classes — *9L Full Size Roll Top Chafer, 6L Round Roll
Top Chafer, 9L Half Roll Top Chafer, Juice Dispenser, Coffee Urn, GN pans, trolleys.* But
**their codes are `SJD08` / `SJD03`, not `HY-`.** `SJD` matches the KITCHENWARE house label's
`SJD10A`, which independently reinforces `KITCHENWARE ← Wanhui` (`house-brand-suppliers-research.md` §7.1).

So Wanhui makes *this kind of goods* and is a legitimate visual near-match source, but it does
not account for the `HY-` codes.

#### 6.3 ❌ The `HY-` family is still unattributed — and the prefix is a dead end for search

`HY-834`, `HY-902`, `HY-605-1`, `HY 501-2` (plus the archived `HY-836`, `HY-902` duplicate)
return **zero external hits** in any form. `oem-placeholder-brands-research.md` §1.5 already
established `HY` is a model prefix rather than a brand; this pass adds that it is also
**not Heavybao's, not Wanhui's, and not Elaboratex's** numbering.

Best remaining hypothesis: a Wanhui-class Guangdong buffetware factory whose export codes were
never published. **This needs the business or a supplier invoice, not more web searching.**

#### 6.4 ⚠ `HEF-904` is a shared industry code, not an Elaboratex model

SAP names Elaboratex in the description, and Elaboratex is real (Guangzhou, ISO 20000,
https://www.made-in-china.com/showroom/elaboratex/). But their only published code is `HEF-4L`,
and `HEF-9xx`/`HEF-8xx` fryers are sold by **Flamemax (Foshan Nanhai), 2C Group and Adexa (UK)**
as well. `HEF` is a shared Chinese fryer code family, exactly like `DZ` (§6.5).

⚠ **And the one surviving spec contradicts SAP.** Flamemax's now-de-indexed `HEF-904` page gave
**600×600×430 mm, 8.5+8.5 L, 2.8+2.8 kW**. SAP says **12×2 L, 4.5+4.5 kW** and the product name
says 25 litres. The *dimensions* corroborate (SAP 590/610/440); the *capacity and power do not*.
Either two different machines share the code, or one of the two records is wrong. **Do not
publish either capacity as settled.**

#### 6.5 `DZ300` / `DZ400` are generic industry codes — no manufacturer is assignable

`DZ-300` and `DZ-400` are the standard Chinese designations for single-chamber vacuum packers,
sold under that code by Hualian, Huaqiao, Kunba, King Pack, Fer-plast, Trufrost and dozens more.

The *specs* corroborate ours precisely, though: the industry `DZ-300` has a chamber of
**390×325×55 mm** with a **300×10 mm** seal bar; SAP says **390×320×60** and **300×10**.
That is the same machine.

Body style separates our two SKUs and is visible: `DZ300` is the **table-top** unit, `DZ400`
the **floor-standing vertical** on castors (SAP's remark literally says *"Vertical DZ400"*).
Images are split on that basis.

---

### 7. ⚠ `HEF-904 BASKET` — the real dimensions were in SAP all along

`IMG/HOT/00427` is stored at **400 / 700 / 900 mm**, which is larger than the `HEF-904` fryer
itself (655/595/480). A basket cannot exceed its fryer.

**SAP's `Item Remarks` field gives the answer directly: `HEF-904 basket 280*200*155mm`.**

That is a wholly plausible basket for a ~600 mm-wide twin-tank fryer (each tank ≈ 280 mm), and
it is corroborated in shape by comparable commercial baskets — e.g. the Lincat BA92 at
280×200×100 mm. **The stored 400/700/900 is not a transposition of anything real; it is junk.
The remark is the recoverable value.** Not applied.

This is the clearest example in the pass of the standing rule: **SAP's `Item Remarks` are
strong and its dimension *fields* are suspect.**

---

### 8. SAP dimension ORDER on this brand — re-established, and it is NOT uniform

The brief asked whether this brand shares the width/depth transposition proven on another house
label. Checked per SKU:

| SKU | SAP W/D/H | Manufacturer W×D×H | Order verdict |
|---|---|---|---|
| `IMG/REF/00209` | 780/765/1670 | 677–680 × 585 × 895 | ⚠ **wrong machine entirely** — 765×780×1670 is the `ZBJ-300L` envelope |
| `IMG/REF/00020` | 585/677/895 | 680 × 585 × 895 (`100LC`) | ⚠ **W and D transposed** |
| `IMG/REF/00022` | 585/510/895 | 507–510 × 585 × **750** | ⚠ transposed **and** the height is wrong (no 895-tall 40 kg exists) |
| `IMG/REF/00019` | 600/764/559 | 764 × 606 × 560 (head unit) | ⚠ transposed, **and** it describes only the head, not the machine |
| `IMG/FPR/00231` | 365/475/360 | 475 × 365 × 360 (SAP's own remark) | ⚠ **W and D transposed** — SAP contradicts its own remark |
| `IMG/FPR/00232` | 540/540/950 | 540 × 540 × 950 | ✅ correct (square footprint, so untestable) |
| `IMG/HOT/00042` | 590/610/440 | 600 × 600 × 430 | ✅ plausible |
| `IMG/HOT/00427` | 700/400/900 | 280 × 200 × 155 | ⚠ **not dimensions at all** |

**Verdict: SAP's dimension order is NOT trustworthy on this brand either.** Where a manufacturer
figure exists and the footprint is non-square, SAP transposes width and depth in **4 of 5**
testable cases. It should be treated as unordered until checked per SKU. Note our stored
`products.json` values are frequently *more* correct than SAP's fields — `00209` stores the
right 677/585/895 while SAP stores a different machine's envelope.

---

### 9. Per-SKU result

| SKU | Code | Status | Best px | Code proven | Notes |
|---|---|---|---|---|---|
| `IMG/REF/00022` | ZBJ-40P | sourced | 1813×2212 | ✗ | 5 files; all range-shared, tagged |
| `IMG/REF/00021` | ZBJ-60P | sourced | 1813×2212 | ✗ | 5 files; 2 real factory photos |
| `IMG/REF/00209` | ZBJ-80PA | **sourced** | 1813×2212 | **✓** | carton prints `MODEL: ZBJ-80PA` |
| `IMG/REF/00020` | ZBJ-100L → **100LC** | sourced | 1500×1125 | ✗ | best flow-evaporator shot in the set |
| `IMG/REF/00019` | ZBJ-150L | sourced | 1429×1072 | ✗ | carton proves R404a; hero shared with 00210 |
| `IMG/REF/00210` | ZBJ-250L | sourced | 1250×938 | ✗ | hero is 00019's photo, recaptioned |
| `IMG/BUF/00219` | 431001 | sourced | 2000×2000 | ✗ | Heavybao confirmed; 1 AI image quarantined |
| `IMG/BUF/00220` | 432102 | partial | 2000×2000 | ✗ | code returns zero hits anywhere |
| `IMG/COF/00027` | WBB20L | partial | 1500×1500 | ✗ | **+ 3-page PDF manual** (Adexa VICWBB20) |
| `IMG/BUF/00043` | HY-605-1 | partial | 1807×1774 | ✗ | Wanhui `SJD08`/`SJD03`, right body class |
| `IMG/BUF/00056` | HY 501-2 | partial | 1500×1500 | ✗ | Wanhui 9L full-size roll top |
| `IMG/FPR/00231` | DZ300 | partial | 1500×1500 | ✗ | table-top body confirmed |
| `IMG/FPR/00232` | DZ400 | partial | 1500×1500 | ✗ | floor-standing vertical confirmed |
| `IMG/BUF/00037` | HY-902 | **rejected** | 1500×1500 | ✗ | ⚠ source is free-standing, **not a drop-in** — do not publish |
| `IMG/BUF/00035` | HY-834 | **not reached** | — | ✗ | zero external hits |
| `IMG/BUF/00060` | D10 | **not reached** | — | ✗ | code too generic |
| `IMG/BUF/00051` | TC-1 | **not reached** | — | ✗ | code collides with unrelated products |
| `IMG/HOT/00042` | HEF-904 | **not reached** | — | ✗ | only source is a de-indexed page that contradicts SAP |
| `IMG/HOT/00427` | HEF-904 BASKET | **not reached** | — | ✗ | but real size recovered from SAP: 280×200×155 |

**Sourced 7 · partial 6 · rejected on body style 1 · not reached 5.**

#### Shared imagery

**7 of the 19 carry at least one shared photo, and every one is tagged.** `00022`, `00021`,
`00209` (spray-range renders); `00019`, `00210` (the recaptioned hero); `00219`, `00220` (the
Heavybao detail shots). No shared photo is left under a bare code-asserting filename.

---

### 10. Resolution ceilings proven

- **`ibernaice.com` = 940 × 584.** Genuinely the original; the short edge is **584 px**, below
  the 800 px floor. Every product render on the manufacturer's own site fails the bar.
- **Made-in-China = 900 × 900 to 1813 × 2212** once `202f0j00…` is rewritten to `2f0j00…`.
  Confirmed again: `202f0j00` → 550 px, `203f0j00` → 900 px, **`2f0j00` → 900 px original**,
  `3f2j00` → 100 px thumbnail. **The good ice-machine imagery is only on the storefront, never
  on the manufacturer's website.**
- **Heavybao = 2000 × 2000** on some assets, 800 × 800 on others (same product).
- **Wanhui = up to 1807 × 1774.**
- **Adexa = 1500 × 1500** (`-1500x1500` is the largest cached variant; no larger original).

Files below the floor were deleted rather than kept, except two range-lineup shots at 642×397
retained in `_brand-reference\` with `BELOW-FLOOR` in the filename.

---

### 11. No spec sheet exists for Iberna

`ibernaice.com` publishes **no PDF at all** — checked the homepage, the About page and
`sitemap.xml`. There is no downloads or catalogue page. The specification tables are HTML only.
They were scraped in full for all 29 `ZBJ-` models and the figures are quoted throughout this
file; that is the closest thing to a datasheet that exists.

**The only spec sheet recovered in this pass** is
`IMG-COF-00027__WBB20L-adexa-VICWBB20-spec.pdf` — a genuine 3-page user manual (text-extractable,
imported by Adexa Direct Ltd, Rugby UK).

---

### 12. Recommended follow-ups (nothing applied)

1. **Correct the refrigerant on `00022`, `00021`, `00209`** — R134a / R404a / R404a, with R290
   noted as an option. Safety-relevant. (§1)
2. **Ask the supplier what `A` vs `C` means**, and confirm which body ships. (§2)
3. **Adopt `280 × 200 × 155 mm` for `IMG/HOT/00427`** from SAP's own remark. (§7)
4. **Do not publish a power figure for `00019`/`00210`** until the supplier confirms. (§3)
5. **`IMG/REF/00020` is a `ZBJ-100LC`** — 1100 W, 35 kg bin, 680×585×895. (§2)
6. **Fill `00210`'s empty dimensions**: 765 × 780 × 1500. (§3)
7. **Resolve the `431001` dimension conflict** (635×425×440 vs our 645/455/290). (§6.1)
8. **Get the `HY-` supplier from the business.** Four live SKUs have no traceable maker. (§6.3)
9. **Reconcile `HEF-904`'s capacity** — 12×2 L / 4.5+4.5 kW (SAP) vs 8.5+8.5 L / 2.8+2.8 kW
   (Flamemax). (§6.4)
10. **`IMG/BUF/00037` still has no usable image.** The only candidate found is the wrong body
    style and must not be published. (§9)
11. **Add HEAVYBAO to the supplier map** in `house-brand-suppliers-research.md`. (§6.1)

⚠ Held, not fixed, per instruction: the six ice-machine **product names still contain the old
codes** ("Ice Cube Machine ZBJ-150P Iberna") while `model_number` has been corrected to
`ZBJ-150L`. Renaming changes the product URL, so this is reported only.
