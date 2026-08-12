# Diqian Product Research

Supersedes the archived research below. Sourcing/verification pass, August 2026, run against the
SAP dossier. Covers both DIQIAN SKUs, both countertop pizza ovens: **CG-P340A**
(`IMG/OVE/00199`) and **CG-P330** (`IMG/OVE/00200`).

**No `products.json` or `brands.json` change has been applied.** Findings only. **No
`model_number` change is proposed.**

---

## 1. Manufacturer

The ovens are made by **Hangzhou Joy Kitchen Equipment ("JOY Equipment")**, No. 616 Gudun
Road, Xihu District, Hangzhou, Zhejiang, China - founded 2000, ISO 9001, own brand JOY,
selling fast-food equipment, sushi machines, bakery and refrigeration.

"Diqian" is the label we buy under; the product data lives on JOY's Made-in-China storefront:
https://joy-equipment.en.made-in-china.com

## 2. The gas/electric split - ANSWERED, our names are correct

JOY's live listings, re-read 4 August 2026, publish **three** models in this body family:

| Model | Power source | Dimensions (mm) | Power | Glass window | Max temp | Factory page |
|---|---|---|---|---|---|---|
| **CG-P340A** | **ELECTRIC** | 425 x 520 x **410** | 2 kW, **220 V / 110 V** | **yes** | 300 C | https://joy-equipment.en.made-in-china.com/product/TGtpHaXBqekA/China-Electric-Stone-Base-Piazz-Oven-Cg-P340A.html |
| **CG-P340** | GAS | 425 x 520 x **410** | 7200 BTU | yes | 350 C | https://joy-equipment.en.made-in-china.com/product/EfaUMuKObbWo/China-Gas-Stone-Base-Piazz-Oven-Cg-P340.html |
| **CG-P330** | **GAS** | 425 x 520 x **290** | 7200 BTU | **NO** | 350 C | https://joy-equipment.en.made-in-china.com/product/UAGRbXBwAokW/China-Gas-Stone-Base-Piazz-Oven-Cg-P330.html |

**Our fuel labelling is right.** `IMG/OVE/00199` CG-P340A is the electric one; `IMG/OVE/00200`
CG-P330 is a gas one. The question flagged as needing supplier confirmation is closed on the
*fuel* axis.

Two confirmations beyond the listing text:

- **The unit's own rating plate**, legible in the staged hero and cropped as file `-7`:
  *Name: Electric Pizza Oven / Model: CG-P340A / Voltage 220 V / Power 2 kW / Frequency 50 Hz
  / Temperature 50-300 C / Size 425 x 520 x 410 mm / CE*.
- **The interior photo** (file `-3`) shows looped **electric heating elements** under the
  shelf, with no burner.

⚠ **But the middle row is the real trap.** `CG-P340` - gas, *with* window, 410 mm high - is a
third model sitting between our two, and it is the one our gas record appears to describe.
See section 4.

## 3. Electrical - 220 V / 50 Hz is correct, but a 110 V build exists under the same code

The factory offers the CG-P340A as **"220V / 110V"**. Our SAP says 220 V, and the physical
rating plate says **220 V, 50 Hz**. The electrical spec we hold is **correct and
Kenya-suitable**.

The exposure is at ordering, not in the record: **the same model number covers a 110 V
build**, and the US Amazon listing for this family is a 110 V product. Any future pass
sourcing this SKU from a US retailer will bring back 110 V / 60 Hz. Specify 220 V / 50 Hz on
the purchase order.

🔴 **SAP's wattage is wrong.** SAP says *"Power : 1800W"*; the factory listing and the unit's
data plate both say **2 kW**. No 1800 W figure exists at source.

The gas models have **no electrical connection** and no voltage to check.

## 4. 🔴 The gas record (IMG/OVE/00200) does not describe the CG-P330

Three things point at the **CG-P340** rather than the CG-P330 whose code we hold:

1. **Dimensions.** Factory CG-P330 is **425 x 520 x 290**. Our record stores 483/400/300 and
   SAP stores 400/483/300. Neither matches the CG-P330, the CG-P340, or any retailer figure.
2. **SAP's remark is a US retail package listing, not a spec.** It reads
   *"Dimensions: 48.3*40*30cm, Package Weight: 12.6kg, Power Source: Gas, Package include:
   1*Pizza oven 1*Pizza Stone **1*Gas hose (US Standard)**"*. A **US-Standard gas hose** does
   not belong on a Kenyan record, and "Package Weight" with a shipping-carton triple is
   **carton data stored as product dimensions**. The Amazon listing this comes from carries
   the part number **`CG-P340`**, not P330.
3. **Our stored product photo** shows a tall body **with a glass window**; the factory is
   explicit that the CG-P330 has **no** window.

The `model_number` and the ~290/300 mm height *do* agree with the CG-P330, so the record is
internally split.

**This needs a one-line supplier question, not more web research:** *is the gas oven we stock
the one with the glass window (CG-P340) or without (CG-P330)?* Until answered, do not attach
CG-P340 photography to `IMG/OVE/00200`. The CG-P340 factory render is staged in
`_brand-reference/` under an explicit `NOT-our-CG-P330` filename.

## 5. SAP dimension check

| SKU | SAP as labelled W/D/H | SAP's own remark | Factory | Our record |
|---|---|---|---|---|
| IMG/OVE/00199 CG-P340A | 475 / 400 / 425 | "40*47.5*42.5cm" | **425 x 520 x 410** | **425/520/410** ✓ |
| IMG/OVE/00200 CG-P330 | 400 / 483 / 300 | "48.3*40*30cm" | **425 x 520 x 290** | 483/400/300 |

**Our `products.json` value for the electric SKU matches the factory and the physical rating
plate exactly.** SAP's 475/400/425 matches nothing, and it is not even a transposition of
SAP's own remark (400/475/425) - the third figure differs too.

**SAP's column order cannot be established for this brand.** The usual
self-contradiction test fails because both rows look transcribed from retail *package*
listings rather than spec sheets, so there is no internally consistent product triple to
test against. Treat both rows' dimension values as **unreliable**, not merely mis-ordered.

## 6. Where to look

| Resource | URL |
|---|---|
| CG-P340A factory listing | https://joy-equipment.en.made-in-china.com/product/TGtpHaXBqekA/China-Electric-Stone-Base-Piazz-Oven-Cg-P340A.html |
| CG-P330 factory listing | https://joy-equipment.en.made-in-china.com/product/UAGRbXBwAokW/China-Gas-Stone-Base-Piazz-Oven-Cg-P330.html |
| CG-P340 factory listing (the sibling, not ours) | https://joy-equipment.en.made-in-china.com/product/EfaUMuKObbWo/China-Gas-Stone-Base-Piazz-Oven-Cg-P340.html |
| UK reseller with the good electric photography | https://elyacatering.co.uk/product/commercial-countertop-electric-pizza-oven/ |
| Same photos, same barcode - NOT independent | https://hmgastrocateringequipmentlimited.co.uk/product/commercial-countertop-electric-pizza-oven/ |
| Amazon US, electric | https://www.amazon.com/dp/B09FSRWHYD |
| Amazon US, gas - part number field reads `CG-P340` | https://www.amazon.com/dp/B09FSH2Q1D |
| JOY corporate | https://joy-equipment.com |

### Traps

1. **Searching the brand name is useless.** "Diqian" surfaces a garment company
   (https://www.tradewheel.com/co/shishi-diqian-garment-13087/) and our own storefront.
   Quoting the exact model string `"CG-P340A"` / `"CG-P330"` is what works.
2. **`elyacatering.co.uk` and `hmgastrocateringequipmentlimited.co.uk` are one source** - same
   photographs, same barcode 5061075450140. Do not count them as two.
3. **There is no spec sheet, manual or catalogue for either SKU.** JOY publishes a six-line
   "Product Description" on Made-in-China and nothing else - no download area, no PDF, and
   no manual on any retailer.
4. **The image CDN ceiling was proven exhaustively on an earlier pass and is settled** -
   see section 7. Do not spend another pass on it.

## 7. Images

Folder: `Desktop\ecommerce\products resorce final\diqian\`. 9 images + 1 reference file.

| SKU | File | Px | Source |
|---|---|---|---|
| 00199 | `-diqian-1.jpg` hero 3/4, rating plate visible | 1500 x 1000 | https://elyacatering.co.uk/wp-content/uploads/IMG_0735.jpg |
| 00199 | `-diqian-2.jpg` door open with pizza | 1500 x 1000 | https://elyacatering.co.uk/wp-content/uploads/IMG_0739.jpg |
| 00199 | `-diqian-3.jpg` interior, electric elements visible | 1500 x 1000 | https://elyacatering.co.uk/wp-content/uploads/IMG_0741.jpg |
| 00199 | `-diqian-4.jpg` lid thermometer | 1500 x 1000 | https://elyacatering.co.uk/wp-content/uploads/IMG_0745.jpg |
| 00199 | `-diqian-5.jpg` stone measured, 30 cm | 1500 x 1000 | https://elyacatering.co.uk/wp-content/uploads/IMG_0746.jpg |
| 00199 | `-diqian-6.jpg` 1:1 recrop of -2 | 1000 x 1000 | https://elyacatering.co.uk/wp-content/uploads/IMG_0739-1x1-2.jpg |
| 00199 | `-diqian-ratingplate-7.png` | 1200 x 800 derived | crop of `-1` |
| 00199 | `-diqian-factory-render-8.jpg` | 357 x 286 (below floor) | https://image.made-in-china.com/2f0j00qRJBcwmtSibV/Electric-Stone-Base-Piazz-Oven-Cg-P340A.jpg |
| 00200 | `-diqian-1.jpg` | 377 x 569 (below floor) | https://image.made-in-china.com/2f0j00DRBvIpgHHWon/Gas-Stone-Base-Piazz-Oven-Cg-P330.jpg |

**All nine were rendered before acceptance. No AI-generated product photo was found.**

⚠ One caveat: file `-2` (and its recrop `-6`) is a **partial composite** - the oven is a
genuine photograph but **the pizza on the stone is a pasted-in graphic** (flat lighting, no
contact shadow, faint edge halo). Ordinary retail compositing, not synthetic product
photography; the appliance itself is untouched. Recorded so it is not later mistaken for a
shot of the oven in use.

**Ceilings were not re-probed** - the `image.made-in-china.com` CDN was settled on an earlier
pass and is taken as final: CG-P330 **377 x 569**, CG-P340A 357 x 286, CG-P340 382 x 451.
Effort went into the retail set instead, which is where the resolution actually is.

**`IMG/OVE/00200` remains blocked on imagery.** The 377 x 569 factory render is the only
picture of the real CG-P330 in existence, and it is below our floor. No retailer of the gas
CG-P330 was found in any market, on this pass or the last. The good gas photography that does
exist is of the **CG-P340** - which may or may not be what we stock (section 4).

## 8. Product reference

| SKU | Model | Fuel | Primary source | Confidence |
|---|---|---|---|---|
| IMG/OVE/00199 | CG-P340A | Electric, 220 V 50 Hz, 2 kW | factory listing + retail photography + the unit's own data plate | **High** - three independent sources agree |
| IMG/OVE/00200 | CG-P330 | Gas, 7200 BTU | factory listing only | **Medium** - model verified at the factory, but our stored photo, copy and dimensions all point at the CG-P340 sibling (section 4) |

Not published anywhere, and therefore left blank rather than invented: gas type (LPG vs
natural gas), gas consumption kg/h, inlet pressure, and any weight for the gas model.

---

## Archived brand research

> Merged in from the former `research/old/` folder on 2026-08-12, when the two folders were
> consolidated. This is the earlier **specs and codes** pass; everything above it
> is the later **sourcing and provenance** pass. The text is unchanged apart from
> heading levels, which were demoted one step to keep a single outline.

## Diqian Product Research

Research notes behind a DIQIAN enrichment/audit pass on `products.json` (July 2026).
Covers both DIQIAN SKUs, both countertop pizza ovens: `CG-P340A` (electric) and
`CG-P330` (gas).

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema/Santos/Empero files before a scope decision.

This was expected to be a low-yield pass: "Diqian" is a house/OEM-shaped label, and
[[project_web_enrichment_pilot]] recorded ~0% verification on house-brand items. That
expectation was **half right**. The *brand* could not be verified at all — but the
*model codes* could, and led straight to the real factory and a full spec sheet, plus
a photograph of a unit's own rating plate. See §2 and §4.

---

### 1. Brand identification — "Diqian" is not a manufacturer we can find

**No official Diqian website exists that we could locate.** `brands.json` currently has
`website_url: null` for `slug: diqian`; **that is the correct value and should stay null**
until a supplier can name a real principal.

What "Diqian" searches actually return:

- **Our own site.** Every "Diqian pizza oven" / "Diqian commercial equipment" hit resolves
  to Sheffield's own storefront — `https://sheffieldafrica.com/kitchen/product/1093/portable-electric-single-deck-pizza-oven-cg-p340a`
  and `https://sheffieldafrica.com/brands/diqian`. **These are circular and prove nothing.**
- **An empty B2B shell.** `https://www.globalsources.com/diqian-co.,ltd/showroom_6008851541832.htm`
  — a "Diqian Co., Ltd" profile with **Total Products: 0**, no address, no website, and
  GlobalSources' own "this company does not currently advertise comprehensive company &
  product information" banner. Unusable as a source; also no evidence it is even in
  catering equipment.
- **A different company entirely.** `https://www.tradewheel.com/co/shishi-diqian-garment-13087/`
  — Shishi Diqian Garment Co., Ltd, a clothing manufacturer. Unrelated.

The brand description currently in `brands.json` ("Diqian produces commercial kitchen
equipment and supplies…") is generic filler that could not be sourced to anything.

#### 1.1 The real manufacturer: Hangzhou Joy Kitchen Equipment Co., Ltd (brand "JOY")

Searching the **model codes** instead of the brand name resolved it immediately. Both SKUs
are catalogue items of:

- **Hangzhou Joy Kitchen Equipment Co., Ltd**, No. 616 Gudun Road, Xihu District,
  Hangzhou, Zhejiang, China. Founded 2000, ISO 9001, Manufacturer/Factory + Trading
  Company, own brand **"JOY"**, main lines fast-food equipment / bakery machines /
  sushi machines.
- Official site: https://joy-equipment.com
- B2B storefront carrying these two products: https://joy-equipment.en.made-in-china.com

Note the factory's own 2025 price catalogue (`https://joy-equipment.com/product/stone_base_pizza_oven`
links a "Catalog With Prices - JOY 2025.pdf" at
https://dedjh0j7jhutx.cloudfront.net/1698801942274285568%2Fa3fbbe8f64c5f2dd84012b01fb25d94e.pdf)
was downloaded and read page by page — it covers conveyor pizza ovens (JB098–JB103) but
**not** the CG-P3xx countertop line, which now only lives on the made-in-china storefront.
So the storefront listings are the best available manufacturer source, not a PDF spec sheet.

#### 1.2 The same units under other labels

This is a white-label product sold under whatever name the importer prefers — which is
exactly what "Diqian" is:

| Label | Market | Source |
|---|---|---|
| **JOY** (factory's own) | China / export | https://joy-equipment.en.made-in-china.com/product/TGtpHaXBqekA/China-Electric-Stone-Base-Piazz-Oven-Cg-P340A.html |
| **Grace** | UAE (Dragon Mart) | listed as "Grace Electric Pizza Oven, CG-P340A", AED 880 — https://www.dragonmart.ae/grace-electric-pizza-oven-cgp340a/pdp (page 404s to us; also https://www.emiratesoutlet.com/grace-electric-pizza-oven-cg-p340a/ which is now a parked domain) |
| **BNDHKR** | Amazon US | https://www.amazon.com/dp/B09FSRWHYD (electric) and https://www.amazon.com/dp/B09FSH2Q1D (gas — **Amazon's own "Part Number" field literally reads `CG-P340`**) |
| *unbranded* | UK | https://elyacatering.co.uk/product/commercial-countertop-electric-pizza-oven/ and https://hmgastrocateringequipmentlimited.co.uk/product/commercial-countertop-electric-pizza-oven/ (same photos, same barcode 5061075450140 — one source, not two) |
| **DIQIAN** | Kenya | us |

The Amazon `CG-P340` part number is the single most useful independent datapoint: it
proves the `CG-P` codes are the **factory's own**, not something a local reseller invented.

**Recommended `brands.json` handling:** leave `website_url` as `null`. Do **not** set it to
`joy-equipment.com` — that is the OEM, not the brand printed on our goods, and pointing a
"Diqian" brand page at a Chinese factory's site would be misleading to customers. If the
brand blurb is ever rewritten, the honest version is "supplied to Sheffield by Hangzhou Joy
Kitchen Equipment", not an invented corporate history.

---

### 2. The CG-P3xx "Stone Base Piazz Oven" family

Three siblings share one body. Understanding the family is what exposes the problem in §4.2:

| Model | Fuel | Dimensions (mm) | Power | Max temp | Glass window | Factory FOB (1–4 pc) |
|---|---|---|---|---|---|---|
| **CG-P330** | Gas | 425 × 520 × **290** | 7200 BTU | 350 °C | **No** | US$120 |
| **CG-P340** | Gas | 425 × 520 × **410** | 7200 BTU | 350 °C | **Yes** | US$140 |
| **CG-P340A** | **Electric** | 425 × 520 × **410** | 2 kW, 220 V / 110 V | 300 °C (see §4.1) | **Yes** | US$140 |

Sources:
https://joy-equipment.en.made-in-china.com/product/UAGRbXBwAokW/China-Gas-Stone-Base-Piazz-Oven-Cg-P330.html
https://joy-equipment.en.made-in-china.com/product/EfaUMuKObbWo/China-Gas-Stone-Base-Piazz-Oven-Cg-P340.html
https://joy-equipment.en.made-in-china.com/product/TGtpHaXBqekA/China-Electric-Stone-Base-Piazz-Oven-Cg-P340A.html

All three take a **12 inch (30 cm) round stone**, all are countertop/portable, all share the
same 425 × 520 mm footprint. The only real differences are fuel, height, and whether the
drop-down door has a viewing window.

Common features confirmed from photography of real units (not marketing copy):
stainless body, domed top with an **analogue dial thermometer** (°F 100–700 scale),
drop-down front door with insulated tubular handle, removable **drip pan**, wire shelf +
round stone included, four anti-slip feet, CE mark.

---

### 3. What "Diqian" gets us that generic listings don't — nothing

Worth stating plainly for the next pass: **searching "Diqian" is a dead end**; searching
`"CG-P340A"` / `"CG-P330"` as exact-quoted strings is what worked. The same is likely true
of the other house-brand labels in `brands.json`. If a brand has no independent web
presence, go straight to the model code.

Search engines used: WebSearch, DuckDuckGo HTML endpoint, Bing, Mojeek. Alibaba search,
Bing and (eventually) DuckDuckGo all served CAPTCHA/`202` bot-blocks; made-in-china product
pages and Amazon detail pages fetched fine via `curl` with a browser user-agent.

---

### 4. Per-SKU findings

#### 4.1 CG-P340A Electric (IMG/OVE/00199) — **High confidence**; stored wattage is wrong by 2.5×

This one is unusually well verified for a house-brand item: the factory listing, two
retail spec tables, and **the appliance's own rating plate** all agree.

The rating plate is legible in a retailer product photo
(https://elyacatering.co.uk/wp-content/uploads/IMG_0739.jpg, saved as
`IMG-OVE-00199__CG-P340A-elya-view3.jpg`; a rotated/upscaled crop is saved as
`IMG-OVE-00199__CG-P340A-ratingplate-crop.png`). It reads:

```
Name:        Electric Pizza Oven   Model:        CG-P340A
Voltage:     230V                  Temperature:  50-350°C
Power:       2KW                   Frequency:    50HZ
Size:        4?5*520*410mm         Date:         30/03/20..
CE
```

**Confirmed corrections needed:**

| Field | Stored now | Should be | Evidence |
|---|---|---|---|
| **Power** | **800 W** ❌ | **2 kW** | rating plate "2KW"; factory listing "Power :2KW"; UK retailer "2 kW"; Amazon sibling "Wattage 1.8 KW" |
| Voltage | 220 V | 230 V / 50 Hz (factory offers 220 V or 110 V) | rating plate |
| Temperature | *(absent)* | **50–350 °C** | rating plate; UK retailer; Amazon sibling bullet "50℃-350℃/122℉-662℉" |
| Stone | "12 inch" | 12 in / **30 cm** round stone | photo `…elya-view6.jpg` shows a tape measure across the stone captioned "STONE SIZE: 30 CM" |
| Dimensions | 400 × 475 × 425 | **425 × 520 × 410** (see caveat below) | factory listing + rating plate |

⚠ **The 800 W figure is the single worst error in the record.** A 12-inch deck oven that
reaches 350 °C cannot run on 800 W; that is toaster territory. Nothing anywhere quotes
800 W. Best guess at the origin is a dropped digit from **1800 W** (the Amazon sibling's
1.8 kW rating) — but the plate and the factory both say 2 kW, so 2 kW is what to use.

**Dimension caveat.** Two figure sets exist and they are not reconcilable by an axis swap:

- **425 × 520 × 410 mm** — factory listing **and the rating plate on a physical unit**.
- **425 × 475 × 400 mm** — Elya/HM Gastro UK ("42.5 × 47.5 × 40 cm") and Amazon BNDHKR
  ("Size: 16.73 × 18.7 × 15.75 inches"). Amazon *also* contradicts itself, giving
  `15.75"D × 18.7"W × 15.75"H` in a different field.
- **Our stored `400 / 475 / 425`** matches the *retailer* value set, just permuted.

**Recommend the manufacturer/rating-plate 425 × 520 × 410 mm**, since a photographed
data plate outranks retailer copy. Note the shared 425 mm across every source — the
disagreement is only on depth (475 vs 520) and height (400 vs 410), which is consistent
with retailers measuring the cabinet and the factory measuring including the door/handle.
Under this reading **425 = width, 520 = depth, 410 = height**, matching the family table
in §2 where the gas siblings share 425 × 520 and differ only in height.

**Weight — leave alone.** Stored says "Package Weight: 14.1 kg"; UK retailers say "net
weight 8 kg". Those are not in conflict (gross vs net) but neither is corroborated, so
don't overwrite one with the other.

**Content the record is missing** (all confirmed, safe to add): top-mounted analogue
thermometer, glass viewing window in the door, removable drip pan, wire shelf + stone
supplied, thermostat knob with power/heating indicator lamps, four anti-slip feet, CE mark.

#### 4.2 CG-P330 Gas (IMG/OVE/00200) — **Medium confidence**, and the record contradicts itself ⚠

The model itself **is** verified — the factory lists it:
https://joy-equipment.en.made-in-china.com/product/UAGRbXBwAokW/China-Gas-Stone-Base-Piazz-Oven-Cg-P330.html
→ 425 × 520 × 290 mm, 12 inch max pizza, **7200 BTU**, 350 °C, **glass window: NO**,
gas, with timing device, HS code 841981, FOB US$120.

But **three things in our record point at the CG-P340 (the gas sibling with the window),
not at the CG-P330**:

1. **The product photo.** `products/pizza-oven-gas-single-deck-cg-p330-imgove00200.jpg`
   shows a tall unit with a **glass viewing window** in the drop-down door plus two wire
   racks and a stone. The factory is explicit that CG-P330 has **no** glass window; the
   CG-P330 render (`IMG-OVE-00200__CG-P330-joy-official.jpg`) is a squat 290 mm-high
   clamshell with a solid front. The photo we're using looks like **CG-P340**.
2. **The description copy.** "Stainless Steel Double Layer" and the two-rack accessory set
   are the CG-P340/CG-P340A configuration (the Amazon gas listing for that body says
   "equipped with 2 grill nets and 1pc 12-inch pizza stone" — and Amazon's part number for
   it is literally `CG-P340`).
3. **The dimensions.** Stored `483 × 400 × 300`. Only the height (~300 vs 290) is close to
   CG-P330; 483 and 400 match neither CG-P330 nor CG-P340 nor any retailer figure found.

Meanwhile the **model_number and the ~290/300 mm height do agree with CG-P330**. So the
record is internally inconsistent: code says P330, photo and copy say P340.

**Do not silently "fix" this either way.** Per [[feedback_model_number_unique_id]] the
`model_number` is the identity, so the safest reading is that **the photo is wrong**, not
the code — but the physically stocked unit is the only thing that settles it. Flag for the
supplier: *"is the gas oven we stock the one with the glass window or without?"*

**Unverified / not to be invented:**
- **Stored weight 12.6 kg** — no source found anywhere. Neither the factory nor any
  retailer publishes a weight for the gas model. Leave as-is, don't corroborate, don't
  delete.
- **Gas type / regulator / consumption** — the factory gives only "7200 BTU" (≈2.1 kW).
  No LPG-vs-natural-gas designation, no kg/h, no inlet pressure is published anywhere.
  Do not fill these in from a generic Chinese pizza-oven listing.
- **Dimensions** — 425 × 520 × 290 is the factory figure and is what to use *if* the
  P330 identity is confirmed; if the stocked unit turns out to be the P340, it's
  425 × 520 × 410 instead. Left unresolved rather than guessed, same as Santos #50A.

**Safe to add now:** 7200 BTU rating and 350 °C max temperature (identical on both gas
siblings, so this is true whichever unit we actually stock).

---

### 5. Product reference

| SKU | Catalogue name | Model | Manufacturer page | Independent source | Confidence |
|---|---|---|---|---|---|
| IMG/OVE/00199 | Pizza Oven Electric Single Deck CG-P340A | CG-P340A | https://joy-equipment.en.made-in-china.com/product/TGtpHaXBqekA/China-Electric-Stone-Base-Piazz-Oven-Cg-P340A.html | https://elyacatering.co.uk/product/commercial-countertop-electric-pizza-oven/ + rating-plate photo + https://www.amazon.com/dp/B09FSRWHYD | **High** — factory listing, retail spec table and the unit's own data plate all agree |
| IMG/OVE/00200 | Pizza Oven Gas Single Deck CG-P330 | CG-P330 | https://joy-equipment.en.made-in-china.com/product/UAGRbXBwAokW/China-Gas-Stone-Base-Piazz-Oven-Cg-P330.html | none — no independent retailer of the gas model found | **Medium** — model verified at the factory, but our stored photo/copy/dimensions point at the CG-P340 sibling (§4.2) |

Sibling used only as a comparison reference (not one of our SKUs):
https://joy-equipment.en.made-in-china.com/product/EfaUMuKObbWo/China-Gas-Stone-Base-Piazz-Oven-Cg-P340.html
https://www.amazon.com/dp/B09FSH2Q1D

**Price context** (not a recommendation, just calibration): factory FOB US$140 / US$120,
UK retail £289 for the electric, Dragon Mart AED 880 (≈US$240) for the electric. Our
stored prices are KES 50,715 (≈US$390) electric and KES 40,365 (≈US$310) gas.

---

### 6. Image sourcing (July 2026) — `products resource/diqian-images/`

**21 files** (was 23 — see §6.1). The factory renders are small (the made-in-china CDN only
serves ~360-570 px for these listings — every larger path variant 404s), so the usable
storefront photography came from resellers of the identical unit.

| File prefix | Count | What it is | Source |
|---|---|---|---|
| `IMG-OVE-00199__CG-P340A-joy-official-TOOSMALL.jpg` | 1 | factory render, **357×286, 19 KB** — proven CDN ceiling (§6.1), **too small for storefront use**, reference only | https://image.made-in-china.com/2f0j00qRJBcwmtSibV/Electric-Stone-Base-Piazz-Oven-Cg-P340A.jpg |
| `IMG-OVE-00199__CG-P340A-elya-view1…6.jpg` | 6 | **best set** — 1500×1000 studio photos of the identical unit: 3/4 hero, door-open with pizza, interior racks, thermometer close-up, stone-size close-up (30 cm) | https://elyacatering.co.uk/wp-content/uploads/IMG_0735.jpg (and IMG_0739 / IMG_0739-1x1-2 / IMG_0741 / IMG_0745 / IMG_0746) |
| `IMG-OVE-00199__CG-P340A-ratingplate-crop.png` | 1 | rotated/upscaled crop of the data plate in `elya-view3` — the §4.1 evidence, **not a storefront image** | derived |
| `IMG-OVE-00199__CG-P340A-bndhkr-view1…5.jpg` | 5 | 1500 px Amazon listing images of the same electric unit, incl. annotated feature panels | https://m.media-amazon.com/images/I/61KQ36mJ3QL._AC_SL1500_.jpg etc. |
| `IMG-OVE-00200__CG-P330-joy-official-TOOSMALL.jpg` | 1 | **the only image of the real CG-P330 found anywhere** — **377×569, 44 KB**, factory render, proven CDN ceiling (§6.1). Squat body, solid front, no window | https://image.made-in-china.com/2f0j00DRBvIpgHHWon/Gas-Stone-Base-Piazz-Oven-Cg-P330.jpg |
| `REF__CG-P340-gas-sibling-joy-TOOSMALL.jpg`, `REF__CG-P340-gas-bndhkr-view1…6.jpg` | 7 | **the gas sibling, NOT our SKU** — kept because they match what our 00200 record currently pictures (§4.2). Do not attach to 00200 without resolving the P330/P340 question first. The factory render was **upgraded 136×160 → 382×451 (44 KB)** by the prefix rewrite in §6.1; the six Amazon shots are 1301-1500 px | https://image.made-in-china.com/2f0j00fGCvhiprOlkI/Gas-Stone-Base-Piazz-Oven-Cg-P340.jpg + https://m.media-amazon.com/images/I/617yZFykKlL._AC_SL1500_.jpg etc. |

Notes for whoever adopts these:

- **The electric SKU (00199) can be upgraded today.** Its current stored image
  (`products/pizza-oven-electric-single-deck-cg-p340a-imgove00199.jpeg`, 13 KB, ~225 px,
  a scraped marketplace thumbnail) is far worse than the six 1500×1000 Elya photos, which
  show unmistakably the same appliance as the factory render.
- **The gas SKU (00200) is blocked**, not just short of photos. The only genuine CG-P330
  images in existence (as far as this pass could find) are 377×569 factory renders — too
  small to publish. The good gas photography available is of the **CG-P340**, which may or
  may not be what we sell. Resolve §4.2 with the supplier before attaching anything.
- **Not copied into `storage/app/public/products/`** and **not referenced in
  `products.json`** — staged in Downloads for review, same as the Brema and Santos passes.
- Per [[feedback_downloads_cleanup]], delete the source files from Downloads once whichever
  ones get adopted are copied into `storage/products`.

#### 6.1 Re-sourcing pass (July 2026) — the MIC size-prefix trick, and where its ceiling is

A minimum-resolution rule (**800 px long edge, 1000 px+ preferred**) was introduced after
this brand's original image pass. Four `joy-*` files were below it. The made-in-china CDN
serves the same asset under a size-prefix ladder, and **`2f0j00…` is the full-size original**:

| Prefix | CG-P340A result |
|---|---|
| `3f0j00…` | 100 × 80 |
| `2f1j00…` | 160 × 128 |
| `43f34j00…` | 300 × 240 |
| **`2f0j00…`** | **357 × 286 — the original** |
| `2f2j00…` / `2f3j00…` / `2f0j10…` / `2f0j01…` | 357 × 286 (aliases of the original) |
| `4f0j00…`, `5f0j00…`, `100f0j00…`, `300f0j00…`, `600f0j00…`, `800f0j00…` | 301 → `pic.made-in-china.com`, then 404 |
| `1000f0j00…`, `2000f0j00…`, `f0j00…`, `2j00…`, `2f0…` | 404 |

**The trick works, and it is genuinely capped here.** Proof it is not the technique failing:
the same rewrite applied to the neighbouring listings on the *same* Joy storefront
(`Stone-Base-Electric-Pizza-Oven-Eb-1/-2`, `Stone-Base-Gas-Pizza-Oven-GB-1/-2`) returns
**4000 × 3000 / 783 KB** factory-floor photographs — of large twin-deck ovens, a different
product line, so not usable here. The CG-P3xx masters Hangzhou Joy actually uploaded are
small.

What was probed to prove the ceiling:

- every prefix in the table above, in **both `.jpg` and `.webp`** (the webp is the same
  357 × 286, 23 KB — no larger variant hides behind the format)
- both CDN hosts, `image.made-in-china.com` **and** `pic.made-in-china.com`
- the storefront product-list page (`/product-list-1.html`) — one image per product, same
  three hashes, no gallery
- each product page's JSON-LD `Product.image` array — a single URL, already the `2f0j00`
  original
- the factory's own site, https://joy-equipment.com — `/product/category/pizza-oven`,
  `/products` and `/product/stone_base_pizza_oven` carry **no CG-P3xx listing at all**; the
  largest asset there (CloudFront, 800 × 800) is an unrelated twin-deck EB-2 oven

**Actions taken:**

| File | Outcome |
|---|---|
| `IMG-OVE-00199__CG-P340A-joy-large.jpg` (300 × 240, 8 KB) | **deleted** — superseded by the `2f0j00` original below |
| `IMG-OVE-00200__CG-P330-joy-large.jpg` (199 × 300, 7 KB) | **deleted** — superseded by the `2f0j00` original below |
| `IMG-OVE-00199__CG-P340A-joy-official.jpg` | → `…-joy-official-TOOSMALL.jpg`, **357 × 286, 19 KB**, proven cap |
| `IMG-OVE-00200__CG-P330-joy-official.jpg` | → `…-joy-official-TOOSMALL.jpg`, **377 × 569, 44 KB**, proven cap |
| `REF__CG-P340-gas-sibling-joy.jpg` (136 × 160, 4 KB) | **upgraded** to the `2f0j00` original, **382 × 451, 44 KB** → `REF__CG-P340-gas-sibling-joy-TOOSMALL.jpg`. `REF__` labelling preserved — this is still the CG-P340 sibling, not our SKU |

Net: 23 files → **21**. Three files remain below the bar and are now suffixed `-TOOSMALL`;
all three are the manufacturer's own renders and no larger copy exists anywhere reachable.

#### 6.2 ✅ CG-P330 re-probed 27 July 2026 — **the ceiling held. Treat this as settled.**

The 377×569 cap on `IMG/OVE/00200` was re-tested from scratch on 27 July 2026, on the
suspicion that it had been declared prematurely. **It had not.** Do not repeat this search.

What was re-run, and what came back:

| Probe | Result |
|---|---|
| `2f0j00…` original, `.jpg` **and** `.webp` | **377 × 569** both — 45,704 B / 83,074 B. The webp is the same pixels, just a fatter file |
| `2f0j10…` alias | 377 × 569, byte-identical to `2f0j00` |
| `800f0j00…`, `1000f0j00…`, `2000f0j00…`, `4000f0j00…`, `660f0j00…`, in both formats | **404** — all ten return the 1,038-byte 300×300 placeholder |
| Hangzhou Joy's own site, https://joy-equipment.com | Sitemap re-read; `/product/stone_base_pizza_oven` fetched in full. **Zero occurrences of `CG-P330` or `CG-P340` anywhere on the page.** Its CloudFront assets are all other product lines |
| Joy's alternate MIC storefront slugs (`joykitchen`, `hzjoy`) | 404 — the `kalerm123`-style storefront alias does not exist for this factory |

The peer-pass trick that broke other brands' ceilings — listing a WordPress media
**collection** rather than querying attachments — does not apply here: neither the MIC CDN
nor joy-equipment.com is WordPress.

**Verdict: `IMG/OVE/00200` (CG-P330 gas) is PROVEN UNSOURCEABLE.** The only genuine
photograph of this exact model that exists on the reachable internet is the 377 × 569
factory render already staged. It cannot be published at that size, and no amount of further
searching will change that. The gas SKU needs a photograph **taken locally or supplied by the
importer**.

⚠ **Do not substitute the CG-P340 files.** The seven `REF__CG-P340-gas-*` files in the folder
are 1301–1500 px and look tempting. They are the **sibling**, and §4.2's discriminator is
visible in every one of them: **the P340 has a glass window in the door; the P330 does not.**
Attaching them would be a silent model substitution, exactly the failure mode the Kalerm,
Kusina, Sulte and Broaster passes caught. Resolve §4.2 with the supplier first.

**Consequence for the catalogue: unchanged from the original pass, and now firmer.** SKU
00199 (electric) is fine — the six 1500 × 1000 Elya photos and five 1500 px Amazon photos
carry it. **SKU 00200 (gas) has no publishable image**: the only genuine CG-P330 photograph
in existence tops out at 377 × 569. Whatever settles §4.2 with the supplier, the gas SKU
needs a photograph taken locally or supplied by the importer — it cannot be sourced online.

---

### 7. Open questions for the supplier

1. **Gas oven: CG-P330 or CG-P340?** Does the unit we stock have a glass window in the
   door? (§4.2 — this decides dimensions, photo and description.)
2. **Gas type** for the gas oven — LPG or natural gas, and what regulator ships with it?
   Nothing published; the record currently claims only "Gas hose" in the box.
3. **Gas oven net weight** — is 12.6 kg from the carton or the appliance? Unsourced.
4. **Who is "Diqian"?** The goods are made by Hangzhou Joy Kitchen Equipment. If Diqian is
   an intermediary trading company rather than a brand, the `brands.json` entry may be
   better folded into a supplier field than presented to customers as a manufacturer.
