# Iberna Product Research

Research notes behind an IBERNA enrichment/audit pass on `products.json` (July 2026).
Covers all 6 IBERNA SKUs, all in the "Ice Cube Machines" category: ZBJ-40P, ZBJ-60P,
ZBJ-80P, ZBJ-100L, ZBJ-150P and ZBJ-250P — nominally one range at six ascending
capacities.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema, Comenda and Santos passes before a scope decision.

Headline results:

- **A real manufacturer exists and was found: Iberna Ice Machine Co., Ltd (Shangqiu /
  Henan, China).** Iberna is *not* a rebadge — it is the factory. `brands.json` has an
  empty `website_url`; the real site is **http://www.ibernaice.com/** (see §1 for an
  important HTTPS caveat).
- **`ZBJ` is not a generic Chinese code family in this case.** It is Iberna's own house
  prefix across its entire cube-ice range, and the full official model list was recovered
  (§2). Every real Iberna code carries a **trailing series letter** — `PA`, `PB`, `PC`,
  `PE`, `LA`, `LC`, `LD` — or is a bare `L`. **None of our six `model_number`s exist
  verbatim in Iberna's catalogue.**
- **Two of our six models do not exist at all as written.** There is no `ZBJ-150P` and no
  `ZBJ-250P` — Iberna's spray ("P") range **stops at 100 kg**. Both are almost certainly
  `ZBJ-150L` and `ZBJ-250L`, which are **flow-type split machines**, and their stored
  dimensions match that reading exactly (§4.5, §4.6).
- **Sibling copy-paste is confirmed and material**, but not where it first appears — see
  §5. The genuinely damaging paste is the **power rating (450 W on both the 40 kg and the
  60 kg, wrong for both)**, the **32×32×32 mm cube size pasted onto two 22 mm flow
  machines**, the **"spray water system" copy pasted onto two non-spray machines**, and
  the **R290 refrigerant claim on all five populated records**.
- **The width/height axis-swap bug is ABSENT here.** Only one SKU (00209) stores numeric
  dimension fields at all, and they are correct. The real dimension problem is that
  **five of six SKUs store no numeric dimensions whatsoever**.
- **One record (IMG/REF/00020, ZBJ-100L) is completely empty** — no description, no spec,
  no dimensions — yet is `published` at KES 373,750.

---

## 1. Brand identification

**Iberna** = **Iberna Ice Machine Co., Ltd**, also trading as **Henan Iberna Ice Maker
Co., Ltd** and **Shangqiu Iberna Refrigerate Equipment Co., Ltd**. Address given on the
site: No.666 Bayi Rd, Lianyuan District, Shangqiu City, Henan Province, China.

- Official site: http://www.ibernaice.com/
- Official B2B storefront: https://icemachineproduce.en.made-in-china.com/
- About page: http://www.ibernaice.com/?ABOUT-US/

The company's own About text states: *"Iberna company established in 1992's as a Joint
venture corporation with Italy Iberna company. We have around 20 years of history in the
field of Ice Maker and Transport Refrigerate production."* Its Made-in-China storefront
gives the registered establishment year as 2006.

**On the Italian-heritage claim — treat with caution but do not dismiss.** "Iberna" was a
genuine European refrigeration appliance brand that the Italian **Candy Group acquired in
1993** (Candy's own corporate history lists Iberna as a refrigeration specialist acquired
that year, alongside Zerowatt in 1985 and Hoover Europe in 1995):
https://corporate.haier-europe.com/our-brands/candy/ and
https://www.candy-home.com/en_overseas/about-us/

So a 1992 joint venture with an Italian Iberna is chronologically plausible, but **no
independent source was found confirming the JV itself**, and the Candy sources make no
mention of a Chinese partner. What is certain is that the entity manufacturing our six
machines today is the Chinese company, not an Italian one. Copy should not imply Italian
manufacture.

**"SnowMate" is Iberna's registered export sub-brand.** It appears as `SnowMate®` on every
marketing hero image alongside the `iberna` logo, and export crates carry `SM-` model
prefixes (a crate photographed on the 150 kg listing reads `MODEL: SM-150`). If a supplier
quotes an `SM-` code, it is the same machine under the export label.

### `brands.json` — `website_url` is empty and should be filled, with a caveat

The stored `website_url` is `null`. The real site is **http://www.ibernaice.com/** and it
returns HTTP 200.

⚠ **Use `http://`, not `https://`.** `https://www.ibernaice.com/` fails TLS verification —
the certificate presented is for `in6.wang` / `www.in6.wang`, not for `ibernaice.com`. Any
code (or user browser) that upgrades the link to HTTPS will show a certificate error. If
the storefront requires an `https://` brand link, the safe alternative is the
manufacturer's own Made-in-China storefront, which is valid over HTTPS:
https://icemachineproduce.en.made-in-china.com/

---

## 2. Where to look + traps

| Resource | URL | Value |
|---|---|---|
| Cube-ice range index | http://www.ibernaice.com/?list_33/ | Entry point; splits into the four sub-types below |
| **Spray type** | http://www.ibernaice.com/?list_45/ | All `PA` / `PC` codes — **the source for our 40P/60P/80P** |
| **Flow type** | http://www.ibernaice.com/?list_46/ | All `L` codes — **the source for our 100L/150P/250P** |
| Bullet ice | http://www.ibernaice.com/?list_47/ | `PB` codes — not ours |
| Self-feed type | http://www.ibernaice.com/?list_48/ | `PE` codes — not ours |
| Company profile | http://www.ibernaice.com/?ABOUT-US/ | The 1992 JV claim (§1) |
| B2B storefront | https://icemachineproduce.en.made-in-china.com/ | Multi-model comparison tables, R290 option, and **much better photography** |

### The complete official cube-ice model list (recovered July 2026)

This is the whole range, so it can be stated definitively which of our codes exist:

- **Spray type**: ZBJ-20PC, ZBJ-30PC, ZBJ-40PA, ZBJ-40PC, ZBJ-50PA, ZBJ-50PC, ZBJ-60PA,
  ZBJ-60PC, ZBJ-80PA, ZBJ-80PC, ZBJ-100PA, ZBJ-100PC
- **Flow type**: ZBJ-25LC, ZBJ-25LD, ZBJ-45LC, ZBJ-45LD, ZBJ-60LC, ZBJ-60LD, ZBJ-100LA,
  ZBJ-150LA, ZBJ-200LA, ZBJ-150L, ZBJ-200L, ZBJ-250L, ZBJ-300L, ZBJ-450L, ZBJ-500L,
  ZBJ-700L, ZBJ-1000L (storefront adds ZBJ-100LC, ZBJ-120LC, ZBJ-150LC, ZBJ-800L)
- **Bullet ice**: ZBJ-40PB, ZBJ-50PB, ZBJ-100PB
- **Self-feed**: ZBJ-20PE, ZBJ-30PE, ZBJ-40PE, ZBJ-50PE, ZBJ-60PE

### Traps

1. **The `P` / `L` letter is the ice-forming principle, and it drives the cube size.**
   Every `P` (spray) model in the range makes a **32 × 32 × 32 mm** cube. Every `L` (flow /
   water-flowing) model makes a **22 × 22 × 22 mm** cube (the split `L` machines also offer
   28 × 28 × 22 mm). This single rule invalidates the cube figure on two of our records
   (§4.5, §4.6) and is the most consequential finding in this pass. **Never carry a cube
   size across a `P` → `L` boundary.**
2. **Iberna's own site reuses one photo across a whole series.** The same render appears on
   the 40PA, 60PA, 80PA, 100PA *and* 100LA pages, and a second render appears on all five
   `PC` pages. The photography is series-level, not model-level, so an image alone can
   never confirm a model. See §7.
3. **Two sources give slightly different dimensions.** `ibernaice.com` gives 507×585×750
   for the 40 kg; the storefront gives 510×585×750. Likewise 677 vs 680 for the larger
   cabinet. These are rounding, not disagreement — pick one convention.
4. **The storefront lists a second refrigerant.** `ibernaice.com` lists only R134a/R404a;
   the storefront lists **"R134a/R290"** and **"R404a/R290"**. R290 is therefore a genuine
   *selectable option*, not a fabrication — but it is not the standard fill. See §5.
5. **Rating conditions differ by source.** `ibernaice.com` states standard conditions of
   **air +21 °C / water +15 °C**. An export crate photographed on the storefront states
   **water 15 °C / ambient 20 °C**. Our records state two *other* things again (§5).
   Ice-output figures are only comparable at a stated condition, so this matters
   commercially.
6. **`ZBJ-80PC` is listed at 550 W on `ibernaice.com`** — identical to the 60PC above it
   and lower than the 80PA's 650 W. That looks like an error on Iberna's own page, not a
   real variant. Use the 80PA figure.

---

## 3. The width/height axis swap — ABSENT on this brand

Documented in the Santos, Empero, Brema and Comenda passes; **checked per SKU here and not
present**.

| SKU | Model | Stored numeric L / W / H | Official W × D × H | Verdict |
|---|---|---|---|---|
| IMG/REF/00209 | ZBJ-80P | 677 / 585 / 895 | 677 × 585 × 895 | **Correct** — `length` holds W, `width` holds D, `height` holds H. No swap. |
| IMG/REF/00022 | ZBJ-40P | *(none stored)* | 507–510 × 585 × 750 | Cannot swap — no numeric fields. Prose height is wrong regardless (§4.1) |
| IMG/REF/00021 | ZBJ-60P | *(none stored)* | 677–680 × 585 × 895 | Cannot swap — no numeric fields |
| IMG/REF/00020 | ZBJ-100L | *(none stored)* | 677 × 575 × 895 | Cannot swap — record is empty |
| IMG/REF/00019 | ZBJ-150P | *(none stored)* | 765 × 780 × 1500 | Cannot swap — no numeric fields |
| IMG/REF/00210 | ZBJ-250P | *(none stored)* | 765 × 780 × 1500 | Cannot swap — no numeric fields |

**The real dimension problem on this brand is absence, not transposition.** Five of six
published, priced SKUs carry no `length`/`width`/`height` at all — they cannot be used for
site planning, freight quoting or the storefront's dimension display. Where prose
dimensions do exist they are mostly right; the one exception is the 40P's height (§4.1).

---

## 4. Per-SKU findings

### 4.1 Ice Cube Machine ZBJ-40P Iberna (IMG/REF/00022) — height wrong by 200 mm, power wrong, no numeric dims

Official sources: http://www.ibernaice.com/?list_45/343.html (ZBJ-40PA) and
http://www.ibernaice.com/?list_45/349.html (ZBJ-40PC); storefront comparison table at
https://icemachineproduce.en.made-in-china.com/product/uXPmNMrcClUC/China-40kgs-Self-Contained-Ice-Cube-Maker-for-Food-Service-Use.html

| Field | Official (ZBJ-40PA / 40PC) | Our stored value | Match? |
|---|---|---|---|
| Ice making type | Spray | "water Spraying technology" | **yes** |
| Ice capacity | 40 kg/24 h | 40 kg/24 h | **yes** |
| Ice cube size | 32 × 32 × 32 mm | 32 × 32 × 32 mm | **yes** |
| Voltage | 220–240 V / 50,60 Hz (or 115 V/60 Hz) | 220 V/50 Hz/1P | **yes** (understates the dual-frequency range) |
| Cooling type | Air **or water** cooling | "Air cooling system" | partial — water-cooled option not mentioned |
| **Refrigerant** | **R134a** standard (R290 optional) | "R290 refrigerant" | **no — see §5** |
| **Power** | **440 W** | 450 W | **no** — and identical to the 60P record |
| **Dimensions (W×D×H)** | **507 × 585 × 750 mm** (site) / 510 × 585 × 750 (storefront) | 500 × 580 × **950** mm | **no — height is 200 mm too tall** |
| Ice bin capacity | **15 kg** | *(absent)* | missing |
| Net / gross weight | **42 / 49 kg** | *(absent)* | missing |
| Numeric length/width/height | — | *(absent)* | missing |

The 950 mm height matches **no model anywhere in Iberna's range** (the nearest figures are
750 mm for the 40 kg and 895 mm for the 50–100 kg cabinets). This is the single clearest
factual error in the brand.

The record's `technical_specification` also states *"Standard Working Condition /
Environment temp.: 15 ºC / Water temp.: 10 ºC"* — Iberna's own standard conditions are
**air +21 °C, water +15 °C**. Ours appears to be a garbled transcription; it understates
both temperatures, which would flatter the quoted output.

### 4.2 Ice Cube Machine ZBJ-60P Iberna (IMG/REF/00021) — dimensions correct, power copy-pasted and wrong

Official sources: http://www.ibernaice.com/?list_45/352.html (ZBJ-60PA) and
http://www.ibernaice.com/?list_45/353.html (ZBJ-60PC); storefront table at
https://icemachineproduce.en.made-in-china.com/product/tSJxiYaTFFrp/China-60kgs-Commercial-Cube-Ice-Maker-for-Beverage-and-Food-Fast-Cooling.html

| Field | Official (ZBJ-60PA / 60PC) | Our stored value | Match? |
|---|---|---|---|
| Ice making type | Spray | "Spray water system" | **yes** |
| Ice capacity | 60 kg/24 h | 60 kg/24 h | **yes** |
| Ice cube size | 32 × 32 × 32 mm | 32 × 32 × 32 mm | **yes** |
| **Dimensions (W×D×H)** | 677 × 585 × 895 mm (site) / **680 × 585 × 895** (storefront) | **680 × 585 × 895 mm** | **yes — exact storefront match** |
| Voltage | 220–240 V / 50,60 Hz | 220 V/50 Hz/1P | yes |
| **Refrigerant** | **R404a** standard (R290 optional) | "R290 refrigerant" | **no — see §5** |
| **Power** | **550 W** | 450 W | **no — 100 W low, pasted from the 40P record** |
| Ice bin capacity | **30 kg** | *(absent)* | missing |
| Net / gross weight | **58 / 65 kg** | *(absent)* | missing |
| Numeric length/width/height | — | *(absent)* | missing |

The prose dimensions here are **exactly right**, which is worth noting: whoever populated
this record clearly had the storefront table in front of them, and still got the power
figure wrong by copying the sibling.

### 4.3 Ice Cube Machine ZBJ-80P Iberna (IMG/REF/00209) — the best record in the brand, but its description contradicts its own spec ⚠

Official source: http://www.ibernaice.com/?list_45/345.html (ZBJ-80PA).

This record's `technical_specification` is a **verbatim transcription of Iberna's official
ZBJ-80PA table**, right down to the "Model No. ZBJ-80PA" line — which is itself the
strongest single piece of evidence that our bare `ZBJ-80P` means `ZBJ-80PA`. Independent
physical confirmation was also found: a photographed export carton on the storefront reads
`ICE MAKER / MODEL: ZBJ-80PA` under the `iberna` logo, with `GROSS/NET WEIGHT: 65/58 KGS`
(saved as `IMG-REF-00209__ZBJ-80PA-carton-label-model-evidence-1000px.jpg`, §7).

| Field | Official (ZBJ-80PA) | Our `technical_specification` | Match? |
|---|---|---|---|
| Model | ZBJ-80PA | "ZBJ-80PA" | **yes** |
| Ice making type | Spray | Spray | **yes** |
| Cooling type | Air / water cooling | Air Cooling/Water Cooling | **yes** |
| Refrigerant | R404a | R404a | **yes** |
| Voltage | 220–240 V/50,60 Hz; 115 V/60 Hz | same | **yes** |
| Power | 650 W | 650 W | **yes** |
| Capacity | 80 kg/24 h | 80 kg/24 h | **yes** |
| Ice bin | 30 kg | 30 kg | **yes** |
| Cube size | 32 × 32 × 32 mm | 32 × 32 × 32 mm | **yes** |
| Net size W×D×H | 677 × 585 × 895 mm | 677 × 585 × 895 mm | **yes** |
| Numeric fields | — | 677 / 585 / 895 | **yes — correct axes, no swap** |
| Net/gross weight | 58 / 65 kg | *(absent)* | missing |

⚠ **The `description` on this same record contradicts the spec table below it.** The
description says *"R290 refrigerant"* and *"Air cooling system"*; the spec says **R404a**
and **Air Cooling/Water Cooling**. Unlike the Brema and Comenda passes — where the prose
was right and the numeric fields wrong — **here the authoritative half is the spec table**,
because it is a direct copy of the manufacturer's own datasheet. The description is the
copy-pasted sibling text (§5).

Minor: the storefront comparison table quotes **665 W** rather than 650 W for the 80PA.
A 15 W difference between two of the manufacturer's own publications; not worth chasing.

### 4.4 Ice Cube Machine ZBJ-100L Iberna (IMG/REF/00020) — completely empty record ⚠

Official source: http://www.ibernaice.com/?list_46/355.html (ZBJ-100LA); storefront
variant at
https://icemachineproduce.en.made-in-china.com/product/GXAxncSbTQRU/China-100kgs-Commercial-Cube-Ice-Machine-for-Food-Service.html
(listed as **ZBJ-100LC**).

**Currently `published` at KES 373,750 with no `description`, no
`technical_specification`, and no dimensions.** Everything below has to be built from
scratch:

| Field | Official (ZBJ-100LA) |
|---|---|
| Ice making type | **Flow** (water-flowing / waterfall) — **not spray** |
| Cooling type | Air cooling / water cooling |
| Refrigerant | R404a |
| Voltage / frequency | 220–240 V / 50,60 Hz, or 115 V / 60 Hz |
| Power | 850 W |
| Ice making capacity | 100 kg / 24 h |
| Ice bin capacity | 30 kg |
| Ice cube shape | Square |
| **Ice cube size** | **22 × 22 × 22 mm** (not 32 mm — this is an `L` model, §2 trap 1) |
| Net size (W×D×H) | 677 × 575 × 895 mm |
| Net / gross weight | 58 / 65 kg |
| Approval | CE, CB |
| Installation | Indoor, air +10/+43 °C, water +3/+32 °C, inlet 1–6 bar |

The storefront's `ZBJ-100LC` is the same 100 kg flow machine described as **"Unit
Structure: Integral"**, air cooled, stainless steel exterior with **white ABS liner**,
certified RoHS / CE / CCC / ISO / UR, cube 22 × 22 × 22 mm. `LA` and `LC` appear to be
generational or trim variants of one machine; the shared figures (100 kg, 22 mm cube,
integral, air-cooled) are safe either way.

**This is the one model in our six whose cube size genuinely differs from its siblings**,
and because the record is empty there is nothing to correct — only to add. Take care not
to "helpfully" fill it in from the 80P record, which would import the wrong cube size,
wrong refrigerant behaviour and wrong ice-forming principle.

### 4.5 Ice Cube Machine ZBJ-150P Iberna (IMG/REF/00019) — the model code does not exist; it is a flow-type split machine ⚠

**There is no `ZBJ-150P`.** Iberna's spray range ends at 100 kg (§2). A direct search for
the string `ZBJ-150P` returned nothing anywhere.

Two candidate real models exist at 150 kg, and our own description disambiguates them:

- **`ZBJ-150LA`** — *self-contained* flow machine, 677 × 650 × 1215 mm, 60 kg bin, 950 W,
  65/78 kg. http://www.ibernaice.com/?list_46/356.html
- **`ZBJ-150L`** — ***split*** flow machine: separate ice-making head plus storage bin.
  http://www.ibernaice.com/?list_46/364.html and
  https://icemachineproduce.en.made-in-china.com/product/uXtQqBWrsJRV/China-150kgs-Commercial-Cube-Ice-Machine-for-Food-Processing.html

Our record's own first line reads *"Split Ice Cube Machine with Storage Bin and Production
Machine"* → **`ZBJ-150L`**. This is confirmed by the dimensions:

- Our stored prose: **765 × 780 × 1500 mm**
- Storefront `ZBJ-150L`: **765 × 780 × 1500 mm** — **exact match**
- `ibernaice.com` breaks the same machine into its two parts: head unit 764 × 606 × 560 mm
  + ice bin 764 × 780 × 840 mm (stacked ≈ 1400 mm, plus feet ≈ 1500)

| Field | Official (ZBJ-150L) | Our stored value | Match? |
|---|---|---|---|
| Structure | Split / separated (head + bin) | "Split ... with Storage Bin and Production Machine" | **yes** |
| Capacity | 150 kg/24 h | 150 kg/24 h | **yes** |
| Dimensions | 765 × 780 × 1500 mm | 765 × 780 × 1500 mm | **yes** |
| Voltage | 220–240 V / 50,60 Hz | 220 V/50 Hz | **yes** |
| **Ice making type** | **Flow** | "unique water Spraying technology / Spray water system" | **no — wrong principle** |
| **Ice cube size** | **22 × 22 × 22 mm** (or 28 × 28 × 22 mm) | 32 × 32 × 32 mm | **no — pasted from the spray records** |
| **Refrigerant** | **R404a** | "R290 refrigerant" | **no — see §5** |
| Power | **950 W** | *(absent)* | missing |
| **Ice bin capacity** | **150 kg** | *(absent)* | missing — and it is a major selling point |
| Cooling type | Air / water | "Air cooling system" | partial |
| Ice temperature | −5 °C to −10 °C | *(absent)* | missing |
| Numeric length/width/height | — | *(absent)* | missing |

The record's `technical_specification` states *"Ambient temperature: 25 °C, Water
temperature: 20 °C"* as the standard condition — higher than Iberna's stated +21/+15, and
different again from the crate's 20 °C/15 °C (§2 trap 5).

### 4.6 Ice Cube Machine ZBJ-250P Iberna (IMG/REF/00210) — model code does not exist; identical dimensions to its sibling are *genuinely correct*

**There is no `ZBJ-250P`** either — a targeted search for `"ZBJ-250P"` returned nothing,
while `ZBJ-250L` is a real catalogue model:
http://www.ibernaice.com/?list_46/366.html and
https://icemachineproduce.en.made-in-china.com/product/SKznvxrGTEpR/China-250kgs-Cube-Ice-Maker-for-Food-Service.html

| Field | Official (ZBJ-250L) | Our stored value | Match? |
|---|---|---|---|
| Structure | **Separated type** (split) | "Split ... with Storage Bin and Production Machine" | **yes** |
| Capacity | 250 kg/24 h | 250 kg/24 h | **yes** |
| Dimensions | 765 × 780 × 1500 mm | 765 × 780 × 1500 mm | **yes** |
| Material | Stainless steel | — | — |
| **Power** | **1800 W** | *(absent)* | missing — **this is the only figure that differs from the 150L** |
| **Ice bin capacity** | **150 kg** | *(absent)* | missing |
| **Ice cube size** | **22 × 22 × 22 mm** or 28 × 28 × 22 mm | 32 × 32 × 32 mm | **no** |
| **Refrigerant** | **R404a** | "R290 refrigerant" | **no — see §5** |
| **Ice making type** | **Flow** | "Spray water system" | **no** |
| Cooling type | Air / water | "Air cooling system" | partial |
| Numeric length/width/height | — | *(absent)* | missing |

**Important nuance on the copy-paste question.** The stored dimensions on 00019 and 00210
are byte-identical (765 × 780 × 1500), and the stored `technical_specification` on the two
records is byte-identical too. That *looks* exactly like the Brema-style sibling paste —
but **the dimensions are genuinely correct for both**. Iberna really does build ZBJ-150L,
ZBJ-200L and ZBJ-250L in one common envelope; only ZBJ-300L grows (its head unit is
730 mm tall instead of 560 mm). So the identical figure is a true fact, not a bug.

What *is* a bug is that the two records share everything **including the fields that
should differ** — most importantly the power draw, which nearly doubles from **950 W to
1800 W** between the two machines. A customer sizing a circuit off these records would get
it wrong.

---

## 5. Cross-cutting notes

### 5.1 The R290 refrigerant claim — an option quoted as if it were standard

**All five populated records claim "R290 refrigerant".** Iberna's own product pages list
only **R134a** (40 kg) and **R404a** (everything 50 kg and above). The Made-in-China
storefront comparison table does list **"R134a/R290"** and **"R404a/R290"** — so R290 is a
genuine **selectable option** the factory will build, not an invention.

But three things make the blanket claim risky:

1. Our own **ZBJ-80P record contradicts itself** — its manufacturer-sourced spec table says
   R404a while its description says R290 (§4.3).
2. R290 is **propane** — a flammable A3 hydrocarbon. It carries different charge limits,
   siting rules and servicing requirements from R404a/R134a. Publishing it as fact when
   the shipped unit is R404a is a safety-documentation problem, not just a copy error.
3. R404a and R290 have very different GWP profiles, so the claim also has an
   environmental-marketing dimension.

**Recommendation: state the standard fill (R134a for the 40 kg, R404a for the rest) and
mention R290 as an available option, or confirm the actual fill with the supplier before
publishing either.**

### 5.2 Power ratings — the clearest sibling paste

| SKU | Model | Our stored power | Official | Verdict |
|---|---|---|---|---|
| 00022 | ZBJ-40P | 450 W | **440 W** | wrong |
| 00021 | ZBJ-60P | 450 W | **550 W** | **wrong by 100 W — pasted from 00022** |
| 00209 | ZBJ-80P | 650 W | 650 W | correct |
| 00020 | ZBJ-100L | *(absent)* | 850 W | missing |
| 00019 | ZBJ-150P | *(absent)* | 950 W | missing |
| 00210 | ZBJ-250P | *(absent)* | **1800 W** | missing |

A 40 kg and a 60 kg machine cannot draw the same power. Three of six have no power figure
at all.

### 5.3 Cube size — correct on the spray models, pasted onto the flow models

`32 × 32 × 32 mm` appears on four records (40P, 60P, 80P, 150P, 250P). It is **correct on
the three spray machines** and **wrong on the two flow machines**, which make
**22 × 22 × 22 mm** cubes (with 28 × 28 × 22 mm optional on the splits). The empty 100L
record would also need 22 mm.

This is the same shape of error the Brema pass found with its cube-size string, but with a
sharper consequence: cube size is a purchasing criterion for bars and hotels, and 22 mm vs
32 mm is a visibly different product.

### 5.4 "Spray water system" pasted onto non-spray machines

The phrases *"Ice forming by unique water Spraying technology"* and *"Spray water system"*
appear on the 150P and 250P records. Both machines are **flow type** — Iberna files them
under a separate FLOW TYPE category from the spray range. The marketing copy is describing
the wrong machine.

### 5.5 Standard rating conditions — three different figures in play

Ice output is only meaningful against a stated air/water temperature. Currently:

| Source | Air / ambient | Water |
|---|---|---|
| `ibernaice.com` "STANDARD CONDITIONS" | +21 °C | +15 °C |
| Iberna export crate (photographed, §7) | 20 °C | 15 °C |
| **Our 40P & 60P records** | **15 °C** | **10 °C** |
| **Our 150P & 250P records** | **25 °C** | **20 °C** |

Neither of our two variants matches the manufacturer, and they disagree with each other.
Iberna's genuinely useful and quotable figure — **the machines are rated to operate up to
+43 °C ambient** — is present on our 150P/250P records and is **correct** (it matches
`ibernaice.com`'s installation limits). That is the number worth keeping for the Kenyan
market; the "standard condition" line should be corrected to +21 °C / +15 °C or dropped.

### 5.6 Model numbers — flagged, not changed

Per [[feedback_model_number_unique_id]], **no `model_number` was changed.** For the record:

| Our `model_number` | Exists in Iberna's catalogue? | Iberna's actual code |
|---|---|---|
| ZBJ-40P | no | `ZBJ-40PA` (or `ZBJ-40PC`) |
| ZBJ-60P | no | `ZBJ-60PA` (or `ZBJ-60PC`) |
| ZBJ-80P | no | **`ZBJ-80PA`** — confirmed by our own spec table *and* a photographed carton |
| ZBJ-100L | no | `ZBJ-100LA` (storefront: `ZBJ-100LC`) |
| **ZBJ-150P** | **no — and no 150 kg spray model exists at all** | **`ZBJ-150L`** (split) |
| **ZBJ-250P** | **no — and no 250 kg spray model exists at all** | **`ZBJ-250L`** (split) |

The bare-suffix pattern (`ZBJ-80P` for `ZBJ-80PA`) is the same reseller/local-SKU
shortening already documented for Comenda's `PC 07` → `PC07+` and Santos's "A" codes. The
150P/250P cases are different and more serious: the letter has been changed from `L` to
`P`, which inverts the machine's ice-forming principle and cube size.

---

## 6. Product reference

| SKU | Catalogue name | Our model | Iberna's code | Official page | Independent / second source | Confidence |
|---|---|---|---|---|---|---|
| IMG/REF/00022 | Ice Cube Machine ZBJ-40P Iberna | ZBJ-40P | **ZBJ-40PA / 40PC** | http://www.ibernaice.com/?list_45/343.html | https://icemachineproduce.en.made-in-china.com/product/uXPmNMrcClUC/China-40kgs-Self-Contained-Ice-Cube-Maker-for-Food-Service-Use.html | **High** — two manufacturer sources agree on every figure |
| IMG/REF/00021 | Ice Cube Machine ZBJ-60P Iberna | ZBJ-60P | **ZBJ-60PA / 60PC** | http://www.ibernaice.com/?list_45/352.html | https://icemachineproduce.en.made-in-china.com/product/tSJxiYaTFFrp/China-60kgs-Commercial-Cube-Ice-Maker-for-Beverage-and-Food-Fast-Cooling.html | **High** |
| IMG/REF/00209 | Ice Cube Machine ZBJ-80P Iberna | ZBJ-80P | **ZBJ-80PA** | http://www.ibernaice.com/?list_45/345.html | https://icemachineproduce.en.made-in-china.com/product/YvcndtRCbyUr/China-80kgs-Commercial-Cube-Ice-Maker-for-Food-Processing.html | **Highest in the brand** — official page + our own transcribed table + photographed carton all agree |
| IMG/REF/00020 | Ice Cube Machine ZBJ-100L Iberna | ZBJ-100L | **ZBJ-100LA** (also `ZBJ-100LC`) | http://www.ibernaice.com/?list_46/355.html | https://icemachineproduce.en.made-in-china.com/product/GXAxncSbTQRU/China-100kgs-Commercial-Cube-Ice-Machine-for-Food-Service.html | **High** on specs; **Medium** on which of LA/LC ships |
| IMG/REF/00019 | Ice Cube Machine ZBJ-150P Iberna | ZBJ-150P | **ZBJ-150L** (split); `ZBJ-150LA` if self-contained | http://www.ibernaice.com/?list_46/364.html | https://icemachineproduce.en.made-in-china.com/product/uXtQqBWrsJRV/China-150kgs-Commercial-Cube-Ice-Machine-for-Food-Processing.html | **High** — "split" wording + exact 765×780×1500 match pin it to `150L` |
| IMG/REF/00210 | Ice Cube Machine ZBJ-250P Iberna | ZBJ-250P | **ZBJ-250L** (split) | http://www.ibernaice.com/?list_46/366.html | https://icemachineproduce.en.made-in-china.com/product/SKznvxrGTEpR/China-250kgs-Cube-Ice-Maker-for-Food-Service.html | **High** — only 250 kg model in the range; dimensions match |

Related official pages pulled while researching (useful if the range is ever widened):

- ZBJ-50PA: http://www.ibernaice.com/?list_45/344.html
- ZBJ-100PA: http://www.ibernaice.com/?list_45/346.html
- ZBJ-100PC: http://www.ibernaice.com/?list_45/354.html
- ZBJ-150LA (self-contained 150 kg): http://www.ibernaice.com/?list_46/356.html
- ZBJ-200LA: http://www.ibernaice.com/?list_46/357.html
- ZBJ-200L (split): http://www.ibernaice.com/?list_46/365.html
- ZBJ-300L (split, taller head): http://www.ibernaice.com/?list_46/367.html
- Granular ice range: http://www.ibernaice.com/?list_40/
- Flake ice range: http://www.ibernaice.com/?list_41/
- Snow ice range: http://www.ibernaice.com/?list_42/

---

## 6A. Applied to the project — 29 July 2026

`IMG/REF/00209` cover replaced: was a **398 px** `.png`, now the `ZBJ-80PA` closed-cabinet
official render at 1512 px. Same cabinet either way — §8 already noted the stored file
"correctly shows the PA-series cabinet" — so this is a resolution fix, not a correction.

Deliberately **not** the file §7 marks ★ primary (`ZBJ-80-cabinet-open-spray-evaporator`).
That one is a real photograph rather than a render, but it is the plain **`ZBJ-80`**, and this
record's verified model is **`ZBJ-80PA`**. A PA-badged render beats a better photo of a
different variant. The open-lid shot remains staged and is the obvious gallery candidate if
this SKU ever gets one.

## 7. Image sourcing (July 2026) — downloaded to `Downloads/iberna-images/`

**40 files**, all sourced from the manufacturer (`ibernaice.com` product pages and Iberna's
own Made-in-China storefront). Naming follows the Santos/Brema/Comenda convention:
`<SKU-with-dashes>__<descriptor>-<longest-edge>.jpg`, with `REF__` for range-level or
component assets that belong to no single SKU.

**Thumbnail trap found and defeated.** Made-in-China serves a **550 px** variant under the
`202f0j00…` path prefix. Swapping that prefix for **`2f0j00…`** returns the original —
e.g. 58 KB / 550 px → **330 KB / 900 px**, and in the best case **272 KB / 1813 × 2212**.
Every storefront image below was re-pulled at the original size after this was discovered.
The `ibernaice.com` assets were probed for larger variants (`-lp`, `_big`, `allimg/`,
`1-` prefixes) and **940 × 584 is genuinely the original** there.

**All 40 files were opened and visually inspected.** Two 310 px component thumbnails, one
270 px sprite, one 381 px filler and six cross-SKU duplicates were deleted.

### Per-SKU candidates

| SKU | Model | File | Pixels | Size | Notes |
|---|---|---|---|---|---|
| **00022** | ZBJ-40 | `IMG-REF-00022__ZBJ-40kgs-SnowMate-hero-900px.jpg` | 900×900 | 346 KB | ★ **primary** — official SnowMate/iberna hero captioned "40kgs cube ice" |
| 00022 | ZBJ-40 | `IMG-REF-00022__ZBJ-40-white-bg-render-800px.jpg` | 800×800 | 129 KB | clean white-background render, lid open; watermarked |
| 00022 | ZBJ-40PC | `IMG-REF-00022__ZBJ-40PC-branded-upright-official-940px.jpg` | 940×584 | 70 KB | narrow `iberna`+`SnowMate` badged upright |
| **00021** | ZBJ-60 | `IMG-REF-00021__ZBJ-60-cabinet-front-closed-1080px.jpg` | 1080×1080 | 136 KB | ★ **primary** — real factory photo, front, lid closed |
| 00021 | ZBJ-60 | `IMG-REF-00021__ZBJ-60-cabinet-open-spray-evaporator-1080px.jpg` | 1080×1080 | 161 KB | lid open showing the **spray evaporator fingers** — good proof-of-type shot |
| 00021 | ZBJ-60PA | `IMG-REF-00021__ZBJ-60PA-cabinet-closed-official-940px.jpg` | 940×584 | 64 KB | official render |
| 00021 | ZBJ-60PA | `IMG-REF-00021__ZBJ-60PA-cabinet-open-official-940px.jpg` | 940×584 | 71 KB | official render, lid open |
| 00021 | ZBJ-60PC | `IMG-REF-00021__ZBJ-60PC-branded-upright-official-940px.jpg` | 940×584 | 54 KB | `PC` variant render |
| **00209** | ZBJ-80PA | `IMG-REF-00209__ZBJ-80PA-carton-label-model-evidence-1000px.jpg` | 1000×1215 | 192 KB | ★ **evidence, not a storefront photo** — carton printed `MODEL: ZBJ-80PA`, `iberna` logo, `65/58 KGS`, rating condition `15 °C water / 20 °C ambient` |
| 00209 | ZBJ-80 | `IMG-REF-00209__ZBJ-80-cabinet-open-spray-evaporator-1080px.jpg` | 1080×1080 | 160 KB | ★ **primary** — real photo, lid open |
| 00209 | ZBJ-80PA | `IMG-REF-00209__ZBJ-80PA-cabinet-closed-official-940px.jpg` | 940×584 | 70 KB | official render |
| 00209 | ZBJ-80PA | `IMG-REF-00209__ZBJ-80PA-cabinet-open-official-940px.jpg` | 940×584 | 63 KB | official render, lid open |
| 00209 | ZBJ-80PC | `IMG-REF-00209__ZBJ-80PC-branded-upright-official-940px.jpg` | 940×584 | 71 KB | `PC` variant render |
| **00020** | ZBJ-100LA | `IMG-REF-00020__ZBJ-100LA-factory-photo-flow-evaporator-1080px.jpg` | 1080×1440 | 166 KB | ★ **primary and the best asset in the set** — real factory photo, lid open, **flow-type evaporator grid clearly visible** |
| 00020 | ZBJ-100LC | `IMG-REF-00020__ZBJ-100LC-cabinet-photo-1263px.jpg` | 1263×1511 | 230 KB | real photo, front three-quarter |
| 00020 | ZBJ-100 | `IMG-REF-00020__ZBJ-100-ice-slabs-detail-1500px.jpg` | 1500×1125 | 168 KB | harvested ice slabs in the bin — good detail shot |
| 00020 | ZBJ-100LC | `IMG-REF-00020__ZBJ-100LC-white-bg-render-800px.jpg` | 800×800 | 154 KB | clean white-bg render |
| 00020 | ZBJ-100LC | `IMG-REF-00020__ZBJ-100LC-white-bg-render-alt-800px.jpg` | 800×800 | 133 KB | second white-bg angle |
| 00020 | ZBJ-100LA | `IMG-REF-00020__ZBJ-100LA-cabinet-render-official-940px.jpg` | 940×584 | 55 KB | official render (shared with the PA series — see below) |
| **00019** | ZBJ-150L | `IMG-REF-00019__ZBJ-150L-SnowMate-hero-900px.jpg` | 900×900 | 329 KB | ★ **primary** — official hero captioned "150kgs cube ice", **shows the split head-on-bin configuration** |
| 00019 | ZBJ-150L | `IMG-REF-00019__ZBJ-150L-head-unit-factory-1220px.jpg` | 1220×1047 | 117 KB | real photo of the modular head unit with `iberna` badge, on a pallet |
| 00019 | ZBJ-150LA | `IMG-REF-00019__ZBJ-150LA-selfcontained-closed-official-940px.jpg` | 940×584 | 44 KB | the **self-contained** 150 kg — different machine, keep only if the supplier ships `150LA` |
| 00019 | ZBJ-150LA | `IMG-REF-00019__ZBJ-150LA-selfcontained-open-official-940px.jpg` | 940×584 | 48 KB | as above, lid open |
| **00210** | ZBJ-250L | `IMG-REF-00210__ZBJ-250L-SnowMate-hero-900px.jpg` | 900×900 | 329 KB | ★ **primary** — official hero captioned "250kgs cube ice" |

### Shared / reference assets (belong to no single SKU)

| File | Pixels | Size | What it is |
|---|---|---|---|
| `REF__iberna-cube-macro-32mm-1813px.jpg` | 1813×2212 | 272 KB | Highest-resolution asset in the set — macro of the **32 mm spray cube**. Valid for 00022/00021/00209 only |
| `REF__iberna-hollow-cube-macro-1000px.jpg` | 1000×1000 | 111 KB | Macro of a **hollow/tube-shaped** cube from the 150 kg listing. Note it contradicts the crate's own "ICE SHAPE: SOLID AND QUADRATE" claim |
| `REF__iberna-export-crate-label-SM-150-1000px.jpg` | 1000×831 | 292 KB | Export crate reading `MODEL: SM-150`, R404A, 220–240 V, `840×680×650 mm`. Source of the `SM-` sub-brand finding (§1) and the 20 °C/15 °C rating condition (§5.5) |
| `REF__ZBJ-PA-series-generic-cabinet-closed-940px.jpg` | 940×584 | 65 KB | ⚠ See caveat below |
| `REF__ZBJ-PA-series-generic-cabinet-open-940px.jpg` | 940×584 | 71 KB | ⚠ See caveat below |
| `REF__ZBJ-PC-series-plain-undercounter-open-940px.jpg` | 940×584 | 69 KB | Unbranded render shared across all five `PC` pages |
| `REF__iberna-factory-modular-heads-1429px.jpg` | 1429×1072 | 298 KB | Factory floor, modular flow heads wrapped for shipping |
| `REF__iberna-factory-condenser-frames-1250px.jpg` | 1250×938 | 236 KB | Condenser/evaporator frames on the assembly line |
| `REF__iberna-modular-head-cabinets-1000px.jpg` | 1000×787 | 210 KB | Bare modular head cabinets |
| `REF__iberna-factory-row-squat-cabinets-1440px.jpg` | 1440×1080 | 183 KB | Production row, wide squat cabinets |
| `REF__iberna-factory-row-uprights-1440px.jpg` | 1440×1080 | 223 KB | Production row, narrow uprights |
| `REF__iberna-factory-row-wrapped-units-1500px.jpg` | 1500×843 | 243 KB | Finished units wrapped on pallets |
| `REF__iberna-production-line-1280px.jpg` | 1280×720 | 275 KB | Wide shot of the assembly line |
| `REF__iberna-warehouse-cartons-1440px.jpg` | 1440×1080 | 218 KB | Palletised `ICE MAKER` cartons |
| `REF__iberna-container-load-ZBJ-25PA-crates-1000px.jpg` | 1000×1211 | 244 KB | Container load — crates read `ZBJ-25PA`, **a model we do not stock**; context only |
| `REF__iberna-cube-range-lineup-642px-TOO-SMALL.jpg` | 642×397 | 41 KB | ⚠ **Below the 800 px bar.** Kept only because it is the sole image showing the whole range side by side (undercounter / self-contained / split). No larger original exists — the `2f0j00` original *is* 642 px. **Not usable on the storefront** |

### Notes for whoever adopts these

- ⚠ **`REF__ZBJ-PA-series-generic-cabinet-*` is Iberna's own generic render, and it cannot
  be trusted per model.** The identical image appears on the ZBJ-40PA, 60PA, 80PA, 100PA
  **and** 100LA pages — machines whose cabinets are 507 mm wide (40 kg) and 677 mm wide
  (60–100 kg). At most one of those widths is what is pictured. It was originally filed
  under a `NOT-40PA__` prefix, but that overstates the case: since Iberna itself publishes
  it for the 40 kg (including on the branded "40kgs cube ice" hero), it is not
  demonstrably wrong, only **not model-specific**. Prefer the real factory photos.
- **Model-specific photography does not exist for the spray range.** Iberna publishes
  exactly three distinct renders across all twelve spray models. The genuinely
  model-distinguishing assets in this set are the **factory photographs** and the
  **carton label**, not the renders.
- **The 150 kg and 250 kg heroes are the same photograph with different caption text.**
  That is Iberna's doing and it is *defensible* here — the two machines share one envelope
  (§4.6). But the storefront will show identical images on two SKUs at very different
  prices, which is worth a deliberate decision.
- **Watermarks.** Most storefront images carry a tiled `HENAN IBERNA ICE MAKER CO., LTD.`
  or `icemachineproduce.en.made-in-china.com` watermark. The two SnowMate heroes and the
  white-background renders are the cleanest; the `800px` white-bg renders have the lightest
  watermarking and are the best candidates if watermarks are a concern.
- **Current catalogue images are materially worse than everything here**, and two pairs are
  byte-identical to each other:
  - `ice-cube-machine-zbj-40p-iberna-imgref00022.jpg` and `...zbj-60p-...00021.jpg` are the
    **same 6 KB / ~150 px file** — a tiny generic undercounter machine
  - `ice-cube-machine-zbj-150p-iberna-imgref00019.jpg` and `...zbj-250p-...00210.jpg` are
    the **same 11.6 KB file** — a modular head-on-bin split unit. The architecture is
    right, but it is not an Iberna machine and it is far too small
  - `...zbj-80p-...00209.png` correctly shows the PA-series cabinet
  - `...zbj-100l-...00020.jpg` shows the **narrow `iberna`-branded upright**, whereas
    Iberna's own 100LA photography shows the wide squat cabinet — likely the wrong cabinet
- **Nothing copied into `storage/app/public/products/` and nothing referenced in
  `products.json`** — staged in Downloads for review, same as the Santos, Brema and Comenda
  sets.

---

## 8. Recommended changes

Ordered by commercial and safety risk, not by effort. **None of this has been applied.**

### Priority 1 — factually wrong data on published, priced SKUs

1. **IMG/REF/00021 (ZBJ-60P): power 450 W → 550 W.** Pasted from the 40 kg record; wrong by
   100 W on a published product. (§5.2)
2. **IMG/REF/00022 (ZBJ-40P): height 950 mm → 750 mm.** Full corrected prose dimensions
   **507 × 585 × 750 mm** (or 510 × 585 × 750 to follow the storefront convention). The
   950 mm figure matches no machine in Iberna's range. (§4.1)
3. **IMG/REF/00022 (ZBJ-40P): power 450 W → 440 W.** (§5.2)
4. **IMG/REF/00019 and 00210: cube size 32 × 32 × 32 mm → 22 × 22 × 22 mm** (optionally
   "22 × 22 × 22 mm or 28 × 28 × 22 mm"). These are flow machines. (§5.3)
5. **IMG/REF/00019 and 00210: remove "spray water system" / "unique water Spraying
   technology"** and replace with flow / water-flowing (waterfall) ice formation. (§5.4)
6. **Resolve the R290 claim on all five populated records.** Either state R134a (00022) /
   R404a (all others) as standard with R290 noted as an option, or confirm the shipped fill
   with the supplier first. Note this is a flammable-refrigerant claim, not just a spec
   detail. (§5.1)
7. **IMG/REF/00209: fix the internal contradiction** — its description says R290 + air-only
   while its own manufacturer-sourced spec table says R404a + air/water. The spec table is
   the authoritative half here. (§4.3)

### Priority 2 — a published, priced SKU with no content at all

8. **Build out IMG/REF/00020 (ZBJ-100L) from scratch.** Published at KES 373,750 with no
   description, spec or dimensions. Source figures (ZBJ-100LA): flow type, R404a, 850 W,
   220–240 V/50–60 Hz, 100 kg/24 h, **30 kg bin**, **22 × 22 × 22 mm cube**,
   677 × 575 × 895 mm, 58/65 kg net/gross, air or water cooled, CE/CB, indoor
   +10/+43 °C. **Do not populate this from the 80P record** — it would import the wrong
   cube size and the wrong ice-forming principle. (§4.4)

### Priority 3 — missing fields across the range

9. **Add numeric `length` / `width` / `height` to the five SKUs that lack them**, using the
   confirmed W × D × H mapping already correct on 00209 (`length` = width, `width` = depth,
   `height` = height — **no axis swap on this brand**):
   - 00022 → 507 / 585 / 750
   - 00021 → 677 / 585 / 895 (or 680 to match the stored prose)
   - 00020 → 677 / 575 / 895
   - 00019 → 765 / 780 / 1500
   - 00210 → 765 / 780 / 1500
10. **Add ice bin capacity everywhere** — it is absent on all six and is a primary
    purchasing criterion: 15 kg (00022), 30 kg (00021), 30 kg (00209), 30 kg (00020),
    **150 kg** (00019), **150 kg** (00210).
11. **Add power to 00019 (950 W) and 00210 (1800 W).** The near-doubling between the two
    is the main spec difference between these otherwise identical-looking siblings, and it
    matters for electrical installation. (§4.6)
12. **Add net/gross weights**: 42/49 kg (00022), 58/65 kg (00021, 00209, 00020),
    65/78 kg if the 150 kg turns out to be the self-contained `150LA`.
13. **Add the water-cooled option** to the cooling-type text — every model in the range is
    available air *or* water cooled, and our copy says air only.
14. **Correct or drop the "standard working condition" lines.** Iberna's stated standard is
    **air +21 °C / water +15 °C**; our two variants (15/10 and 25/20) are both wrong and
    disagree with each other. **Keep** the "can operate up to 43 °C ambient" claim — it is
    correct, and it is the most saleable fact in the set for the Kenyan market. (§5.5)

### Priority 4 — brand record and commercial follow-ups

15. **Fill `brands.json` `website_url`** with **http://www.ibernaice.com/** — but see the
    HTTPS certificate caveat in §1. If an `https://` URL is required, use
    https://icemachineproduce.en.made-in-china.com/ instead.
16. **Consider a `brands.json` description update.** The current description is the bare
    string `"IBERNA"`. A factual replacement: Chinese ice-machine manufacturer based in
    Shangqiu, Henan, trading since the 1990s, exporting under the SnowMate brand, with a
    range spanning cube, flake, granular and snow ice. Avoid implying Italian manufacture
    (§1).
17. **Confirm the actual model codes with the supplier**, especially for 00019 and 00210.
    `ZBJ-150P` and `ZBJ-250P` do not exist; the machines are almost certainly `ZBJ-150L`
    and `ZBJ-250L`, but `ZBJ-150LA` (self-contained, 60 kg bin, 677 × 650 × 1215) is a
    different machine that would change several figures. `model_number` was **not** changed
    per [[feedback_model_number_unique_id]]. (§5.6)
18. **Replace the catalogue images.** Two SKU pairs currently share byte-identical files
    and the 40P/60P image is ~150 px. Candidates are staged in `Downloads/iberna-images/`
    (§7).
19. **Consider surfacing the split architecture** on 00019/00210. "Split — separate
    ice-making head plus 150 kg storage bin" is a genuine differentiator against the
    self-contained models below them, and the bin is 5× the capacity of the 100 kg
    machine's.

---

## ⚠ Brand reassigned 2026-07-30 — this research still applies

All 6 SKUs covered here (`ZBJ-40P`, `ZBJ-60P`, `ZBJ-80PA`, `ZBJ-100L`, `ZBJ-150L`, `ZBJ-250L`)
now carry **`brand: OEM SHEFFIELD`** in `products.json`, not `IBERNA`. SAP records their `Make`
as `OEM SHEFFIELD` — i.e. we buy them as a **house label**.

**Nothing in this file is invalidated.** Iberna Ice Machine Co., Ltd of Shangqiu/Henan is still
the manufacturer; the `ZBJ` prefix is still Iberna's own house prefix; every spec and source URL
here still stands. The two facts coexist: the research documents *who makes it*, SAP documents
*what we buy it as*.

`sku` and `model_number` are unchanged, so this file still joins correctly.
⚠ Staged images remain in `Desktop\ecommerce\products resource\iberna-images\` even though
the brand is now OEM SHEFFIELD. Filed by the old brand, still correct by SKU.
See `sap-reconciliation-research.md` §5.3.
