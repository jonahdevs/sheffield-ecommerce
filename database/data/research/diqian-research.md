# Diqian Product Research

Supersedes `old/diqian-research.md`. Sourcing/verification pass, August 2026, run against the
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
