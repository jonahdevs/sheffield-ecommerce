# IceMake Product Research

Research notes behind an ICEMAKE enrichment/audit pass on `products.json` (July 2026).
Covers the single ICEMAKE SKU in the catalogue: **IMG/REF/00136 — Bulk Milk Chiller 500
Litres BMC-500** (`model_number: BMC-500`, category Refrigeration, `published`,
KES 862,500, qty 1).

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema, Comenda and Santos passes before a scope decision.

Headline results:

- **Manufacturer confirmed.** Ice Make Refrigeration Limited, Dantali/Kalol, Gandhinagar,
  Gujarat, India — a real, BSE/NSE-listed refrigeration manufacturer. Official site:
  **https://www.icemakeindia.com** — `brands.json` currently has `website_url: null` (§1).
- **Every stored numeric spec matches Ice Make's own published table exactly** — dimensions,
  power, phase, door/agitator count, body type, pull-down time. This is the most accurate
  record found in any brand pass so far. The problem is not wrong numbers; it is
  **missing context around one number** (§3).
- 🚩 **The pull-down time is 5 hours, and that is below the dairy cold-chain benchmark.**
  ISO 5708-2 II / NDDB require **≤3.0 h from 35 °C to 4 °C**. Ice Make publishes **5 h** for
  this model and does **not** claim an ISO 5708 class anywhere. Meanwhile the record's
  description says the unit is "designed to **quickly** cool large quantities of milk". That
  is the claim-the-spec-cannot-support pattern (§3). This is the single most important
  finding in this pass.
- **Electrical spec is genuinely Kenya-compatible.** 230 V / 50 Hz **single phase**, 2.7 kW —
  confirmed by the manufacturer, not inferred. No three-phase installation problem. But the
  single-phase supply and the slow pull-down are two faces of the *same* design decision
  (§4).
- **No width/height axis swap on this SKU.** Verified against the manufacturer's inch
  figures; numeric fields and prose agree with each other *and* with Ice Make. Fifth brand
  pass, and this is one of the SKUs where the bug is absent (§5).
- **`BMC-500` is a range/marketing name, not Ice Make's engineering code.** Ice Make's own
  spec table calls this model **`MTD-500`**; `BMC-500` is how its dealers and its own image
  filenames label it. Drift noted, `model_number` **not changed** (§6).
- **Images: the record's live photo is 225 × 225 px, and 600 × 600 is the best that exists
  anywhere.** Ice Make's "1024" file is a proven upscale; the catalogue PDF, the dealer CDN
  and TradeIndia are all smaller still. Documented with the evidence in §9.

---

## 1. Brand identification

**ICEMAKE** = **Ice Make Refrigeration Limited**, 226, Dantali Industrial Estate, on
Gota-Vadsar Road, At: Dantali, Ta: Kalol, Dist. Gandhinagar - 382721, Gujarat, India.
Founded 1993 (the site's own "30 years in business" badge dates from 2019 and carries
"1989–2019" on the seal, so the company traces its origins to the late 1980s and the
current entity to 1993). ISO 9001:2015, ISO 14001:2015 and ISO 45001:2018 certified;
1300+ employees; states it exports to 35+ countries. Product verticals: cold rooms and PUF
panels, commercial refrigeration, industrial refrigeration, ammonia refrigeration,
transport refrigeration, and **dairy machinery** (bulk milk chillers, batch pasteurisers,
milk silos, curd incubation, dairy processing plant).

This is unambiguously the right company for a bulk milk chiller — dairy is one of its core
verticals, and its 500 L BMC is a catalogue item, not a special.

- Official site: https://www.icemakeindia.com
- Bulk Milk Chiller product page (the primary source for §2): https://www.icemakeindia.com/bulk-milk-chiller/
- Corporate catalogue 2026 (BMC copy on p.22): https://www.icemakeindia.com/wp-content/uploads/2026/01/Corporate-Catalogue-2026.pdf
- Brochure index: https://www.icemakeindia.com/catalogue/
- Company address / registration footer: https://www.icemakeindia.com/contact_us/

### `brands.json` — needs a real entry ⚠

Current stored row:

```
"slug": "icemake", "name": "Icemake",
"description": "ICEMAKE",          <- placeholder, the brand name repeated
"logo": "brands/icemake.png",
"website_url": null                <- empty, per the task brief
```

**Recommended `website_url`: `https://www.icemakeindia.com`.** Verified live: returns
`200`, and the bare `https://icemakeindia.com` 301s to the `www` host, so either form works
— use the `www` form to match the canonical.

**Do not use `icemakeindia.co.in`.** It appears in search results and carries a usable
dairy-machinery page, but it is an IndiaMART-hosted storefront mirror, and a direct request
returns **HTTP 403** (it only renders through a browser session). It is a valid
cross-reference (cited in §2) but a bad `website_url`.

The `description` also needs replacing — `"ICEMAKE"` is a placeholder, not copy. Suggested
in §8.

### Naming

Ice Make writes its own name as two words — **"Ice Make Refrigeration Limited"** / **"ICE
MAKE"** on the logo and control panel. Our `brands.json` display name is `Icemake` and
`products.json` stores `ICEMAKE`. Cosmetic only, but per [[project_brand_name_casing]] the
display casing lives in `brands.json`, so `"Ice Make"` would be the accurate display name.

---

## 2. The official source

Ice Make publishes **one** technical table covering the whole BMC range, on the product page
itself — there is no per-model datasheet PDF, and the dairy brochure
(https://www.icemakeindia.com/wp-content/uploads/2023/03/Dairy-Proccessing-brochure-2023.pdf)
is a **fully image-based PDF with zero extractable text**, covering processing plant rather
than BMCs. The corporate catalogue's BMC page (p.22) is marketing copy with no per-model
numbers. So the product page table below is the authoritative figure set.

Source: https://www.icemakeindia.com/bulk-milk-chiller/

| Description | Unit | MTD-250 | **MTD-500** | MTD-1000 | MTD-1500 | MTD-2000 | MTD-3000 | MTD-5000 | MTD-10000 |
|---|---|---|---|---|---|---|---|---|---|
| Tank Capacity | Ltr. | 250 | **500** | 1000 | 1500 | 2000 | 3000 | 5000 | 10000 |
| Dimension – Length | Inch | 35 | **51** | 97 | 109 | 109 | 110 | 110 | 156 |
| Width | Inch | 28 | **35** | 35 | 58 | 58 | 63 (OD) | 71 (OD) | 91 (OD) |
| Height | Inch | 63 | **63** | 62 | 36 | 46 | 71 | 79 | 98 |
| No. of Door | | 1 | **1** | 2 | 1 | 1 | 1 | 1 | 1 |
| No. of Agitator | | 1 | **1** | 1 | 1 | 2 | 1 | 2 | 2 |
| Body Type | | Horizontal – Rectangular | **Horizontal – Rectangular** | Horizontal – Rectangular | Hemi Spherical | Hemi Spherical | Cylindrical – Closed | Cylindrical – Closed | Cylindrical – Closed |
| Power Input | kW | 1.2 | **2.7** | 4.5 | 5.9 | 6 | 7.8 | 11.8 | 23.6 |
| Power Supply | | 1 Ph | **1 Ph** | 1/3 Ph | 3 Ph | 3 Ph | 3 Ph | 3 Ph | 3 Ph |
| Pull Down Time | Hr | 5 | **5** | 5 | 5 | 6 | 6 | 6 | 6 |

Narrative specifications from the same page (these are range-wide, not model-specific):

| Field | Ice Make's published value |
|---|---|
| Cooling system | **Direct expansion (DX)** — "Faster cooling owing to direct expansion" |
| Evaporator | **Dimple jacket** forming the bottom and sides of the tank |
| Tank material | **AISI 304 stainless steel**, fully welded and polished, sloped to the drain outlet |
| Insulation | **60–75 mm** polyurethane foam (PUF), **CFC free**, density 38 kg/m³ ±2, machine-poured |
| Target temperature | **4 °C** (milk arrives at ~37 °C) |
| Agitator / stirrer | Gear motor, timer auto-control — **runs 1 minute every 15 minutes** |
| Compressor | **Hermetically sealed** |
| Condensing unit | Tank-mounted (no separate shifting cost), grill-protected, designed to work **up to 45 °C ambient**, minimum noise |
| Holding performance | **≤3 °C rise in 12 hours** after switch-off from 2 °C |
| Control panel | Temperature display with control system; MOB for compressor; H.P./L.P. on selected models; SPPR with under-voltage protection and overload relay on selected models. Panel is branded **`IM-BMC`** (visible on the official control-panel photo) |
| Milk volume measurement | **Dip-stick with dip-stick chart** supplied |
| Range | 250 L – 10,000 L |

Refrigerant is **not stated per model** anywhere on `icemakeindia.com`. The IndiaMART mirror
(https://www.icemakeindia.co.in/dairy-machinery.html) lists the company's BMC refrigerant
options as **R-134a, R-404 (CFC free) or R-22**, compressor brands Copeland / Frascold /
Danfoss / Emerson / Tecumseh, and supply as 230 V 1-phase or 440 V 3-phase 50 Hz. Treat that
as **Medium** confidence — right company, unofficial host, and it does not say which
refrigerant ships on MTD-500.

### Dealer cross-check

An Ice Make dealer listing for exactly this item —
https://www.kamlaenterprises.net/products/ice-make-bulk-milk-chiller-500-ltr-bmc/632502000000526020
— independently reproduces **2.7 kW, 1 ph, 5 Hr, Horizontal Rectangular, 1 door,
1 agitator, 500 L** and adds **weight 240 kg** (the one figure in our record that is *not*
on Ice Make's own page). Ex-works India price ₹195,000.

⚠ Two unexplained figures on that same dealer page: a second weight of **142 kg**, and a
dimension string **"54*38*56"** which matches neither the 51×35×63 inch product figures nor
their millimetre equivalents. Probably packing/shipping fields. Our stored 240 kg is the one
that is labelled as the technical spec, so keep it, but it remains **single-source** — Ice
Make itself does not publish a weight.

---

## 3. 🚩 The chilling-performance problem — the headline finding

This is a dairy cold-chain product, so cooling *time* is the spec a buyer compares on, not
litres. Our record stores "Pull down time 5 Hr" with **no temperature basis, no standard,
and no class**, and the description simultaneously promises "**quickly** cool large
quantities of milk".

### What the standard requires

The relevant benchmark for bulk milk coolers is **ISO 5708** (Refrigerated bulk milk tanks,
https://www.iso.org/standard/11819.html), applied in India through NDDB's tender
specification 01.13.001.00 R1:

> "The BMC tank shall meet the requirements of **ISO 5708 – 2 II** (Latest version) for milk
> collection cycle of two times in a day with **not more than 3.0 hours cooling time from 35
> to 4 Deg. C** for all milking and not more than 1.5 hours for second milking i.e. from 10
> to 4 Deg. C."

Source: https://www.nddb.coop/sites/default/files/pdfs/BMCU%20SPECS%201-2%20KL.pdf

The same document sets the refrigeration design point at **46 °C ambient**, 0 °C suction /
60 °C condensing, and an insulation criterion of **≤1 °C mean-temperature rise in 4 hours at
50 °C ambient**.

### What Ice Make actually publishes

| Criterion | ISO 5708-2 II / NDDB | Ice Make MTD-500 | Verdict |
|---|---|---|---|
| Cooling time, first/all milking | ≤ **3.0 h** (35 → 4 °C) | **5 h** | ❌ **Does not meet** |
| Cooling time, second milking | ≤ 1.5 h (10 → 4 °C) | not published | Unknown |
| Holding / insulation | ≤1 °C rise in 4 h @ 50 °C ambient | ≤3 °C rise in 12 h (≈1 °C/4 h) from 2 °C | ✅ **Equivalent** |
| Ambient design | 46 °C | 45 °C | ✅ Effectively equivalent |
| System type | Direct expansion, proven design | Direct expansion, dimple jacket | ✅ Meets |
| ISO 5708 class claimed | — | **none claimed anywhere** | — |

So: the tank, insulation and construction are to standard. **The refrigeration capacity is
not.** Ice Make never claims an ISO 5708 class for the MTD range, and the 5 h figure is its
own published number, not an error on our side.

### Why this matters commercially, and why it is not a scandal

A 5 h pull-down does *not* make the machine useless — it makes it a **farm/collection-centre
milk chilling tank** rather than an **ISO-class bulk milk cooler for two-milking
co-operative collection**. The practical difference for a Kenyan buyer:

- For a **single-farm** user who fills the tank gradually during milking, milk enters warm in
  small increments against a mostly-cold mass, and the effective time-above-10 °C is far
  shorter than the headline figure. Fine.
- For a **milk collection centre** taking a bulk drop of 500 L at 35–37 °C, 5 hours means the
  milk sits in the bacterial growth zone for roughly two hours longer than an ISO-class tank
  would allow. Any buyer procuring against an NDDB-style or co-operative tender spec will
  reject this unit on that line item.

The honest positioning is therefore *"chills 500 L from 37 °C to 4 °C in 5 hours"* — stated,
not hidden — and **not** *"quickly cool large quantities of milk"*. Comparable: a competing
Indian 500 L BMC (https://htindiatech.com/product/bulk-milk-cooler-bmc-500-ltr/) explicitly
advertises "ISO 5708 Class 2A-II, 3.0 hr from 35 to 4 °C". That is the claim Ice Make
declines to make, and a buyer comparing quotes will see the gap.

⚠ Treat that competitor's 3 h claim with some scepticism too: it is quoted alongside a
1.5 kW power draw, and 3 h on 500 L needs roughly 5.6 kW of *cooling* (≈4 kW input) — see
§4. A 3 h claim at 1.5 kW is not physically credible, whereas Ice Make's 5 h at 2.7 kW is.
Ice Make's numbers are conservative and self-consistent; the competitor's are marketing.

**This is the earlier "milk fridge that only reached 8 °C" pattern in a milder form.** The
temperature target here (4 °C) is correct and within the dairy cold chain; it is the *time
to get there* that falls short of the standard. Less severe, still material, and it belongs
in the copy rather than being papered over.

---

## 4. ✅ Electrical verdict for Kenya — single phase, and it checks out

| Field | Value | Source |
|---|---|---|
| Power input | **2.7 kW** | Ice Make product-page table |
| Power supply | **1 Ph (single phase)** | Ice Make product-page table |
| Voltage / frequency | **230 V, 50 Hz** | https://www.icemakeindia.co.in/dairy-machinery.html (range-wide) |

**Verdict: suitable for Kenya as-is, with no phase problem.** India is 230 V / 50 Hz and
Kenya is 240 V / 50 Hz — the same frequency and within the same 220–240 V nominal band, so
no transformer or frequency conversion is needed. The task brief's concern that a 500 L bulk
cooler "is very likely three-phase" is **not** borne out here: Ice Make's own table shows the
MTD range only crosses to 3-phase from **MTD-1000 (1/3 Ph) upward**, and is firmly 3-phase
only from MTD-1500. The 500 L is a genuine single-phase machine.

Running current is roughly **2.7 kW ÷ 240 V ≈ 11–12 A** at unity, call it ~13–14 A allowing
for power factor — a standard single-phase circuit. It should be given its **own dedicated
circuit** with appropriate breaker sizing, because compressor locked-rotor inrush on a
single-phase hermetic of this size is several times running current. Worth saying in the
copy as an installation note; it is a selling point (no 3-phase supply required, which
matters a great deal for rural Kenyan collection centres) rather than a problem.

### The link between the phase and the 5 hours

These two facts are not independent, and this is worth understanding before anyone
"corrects" the pull-down time upward:

- 500 kg of milk, specific heat ≈3.93 kJ/kg·K, cooled 35 → 4 °C = **≈61 MJ ≈ 16.9 kWh** of
  heat to remove.
- Over **5 h** that is ≈**3.4 kW** of average cooling duty — comfortably within what a ~2.4 kW
  compressor delivers at 0 °C suction / 60 °C condensing.
- Over **3 h** (the ISO figure) it would be ≈**5.6 kW** of cooling, needing roughly **4 kW**
  of electrical input — around **17–18 A single phase**, which is why ISO-class tanks of this
  size are usually specified three-phase.

Ice Make has chosen a smaller single-phase compressor and accepted a longer pull-down. That
is a coherent engineering trade, and it means the 5 h figure is **real, not a typo**. Do not
"fix" it.

---

## 5. Dimension / axis-swap check — clean on this SKU

Verified rather than assumed, per the recurring cross-brand import bug documented in the
Santos, Empero, Brema and Comenda passes.

| Axis | Ice Make (inch) | → mm | Stored numeric field | Stored prose (`technical_specification`) | Verdict |
|---|---|---|---|---|---|
| Length | 51 | 1295.4 | `length: 1295` | "Dimension 1295x…" | ✅ match |
| Width | 35 | 889.0 | `width: 889` | "…x889x…" | ✅ match |
| Height | 63 | 1600.2 | `height: 1600` | "…x1600mm" | ✅ match |

**No swap.** The numeric fields, the prose, and the manufacturer all agree, to the
millimetre. Confirms once again that the swap must be checked per-SKU and never applied as a
blanket transform.

The one figure that *looks* wrong at a glance — a "horizontal rectangular" tank that is
1600 mm tall but only 1295 mm long — is explained by the official product photo (§7): the
tank body genuinely is a low horizontal rectangle with a curved shell, but it sits on a
**tall welded stand with the air-cooled condensing unit mounted underneath it**. The 1600 mm
is floor-to-lid-rail overall height, not tank depth. The sibling MTD-250 shares the same
63 inch height on a much smaller tank, which is only possible with a common stand height —
independent confirmation of the same reading.

**Installation note worth adding to the copy:** at 1600 mm overall with lids that hinge
*upward* from the top, the machine needs meaningful headroom clearance above 1600 mm to
open, plus air clearance around the under-slung condenser. Neither is currently mentioned.

---

## 6. Model-code drift: `BMC-500` vs `MTD-500`

- Ice Make's own technical table names this model **`MTD-500`**. Every model in the range
  carries an `MTD-` prefix (`MTD-250` … `MTD-10000`).
- **`BMC-500` is not absent from Ice Make's own material, though** — the official product
  photograph on that very page is served from
  `https://www.icemakeindia.com/wp-content/uploads/2021/03/BMC-500-Ltr.png`, and the
  page's photo captions and dealer listings all use "BMC 500 Ltr". "BMC" is the
  product-*category* abbreviation (Bulk Milk Chiller/Cooler); "MTD" is the engineering
  series code.
- So `BMC-500` is a legitimate trade designation for this exact machine, and unlike the
  Comenda `CB-12/18` or `PR` cases it is **not** a mash-up or a house code — it is just the
  marketing name rather than the series code.

**Per [[feedback_model_number_unique_id]], `model_number` is NOT changed.** Recommendation is
only that the *body copy* mention "Ice Make series code MTD-500" so a buyer or the supplier
can match the quote against Ice Make's table. If the code is ever revisited with approval,
`MTD-500` is the manufacturer-accurate value.

---

## 7. Record audit — field by field

Full current record (`IMG/REF/00136`):

| Field | Stored | Verdict |
|---|---|---|
| `name` | Bulk Milk Chiller 500 Litres BMC-500 | ✅ fine |
| `brand` | ICEMAKE | ✅ correct company (§1) |
| `model_number` | BMC-500 | ⚠ trade name, not the `MTD-500` series code — **not changed** (§6) |
| `category` | Refrigeration | ✅ acceptable (no dairy category exists) |
| `price` | KES 862,500 | ℹ ex-works India ≈₹195,000 (≈KES 290k). ~3× — plausible landed + duty + margin, but flagged for a commercial sanity check, not a research finding |
| `quantity` | 1 | ℹ single unit in stock |
| `image` | `products/bulk-milk-chiller-500-litres-bmc-500-imgref00136.jpeg` | 🚩 present but **only 225 × 225 px / 5.7 KB** — far too small for a storefront hero on a KES 862,500 item. Replacing it is worth doing even though the best available replacement is itself only 600 px (§9) |
| `length` | 1295 | ✅ = 51 in |
| `width` | 889 | ✅ = 35 in |
| `height` | 1600 | ✅ = 63 in |
| `short_description` | "Industrial 500-litre bulk milk chiller by Icemake. Professional dairy cooling equipment for farms and processors in Kenya." | ⚠ carries "in Kenya" — per [[project_description_field_split]] that belongs in `meta_description`, and the split has never been applied to this SKU |
| `meta_description` | **absent** | ⚠ 296 of the catalogue's records have one; this is not among them |
| `description` | 4 paragraphs of Quill-editor marketing prose | ⚠ **zero facts**, `ql-align-justify` junk classes, trailing `<p><br></p>`, and the unsupported "quickly cool" claim (§3) |
| `technical_specification` | 9 `<p>` lines | ⚠ every *value* is right, but the block is broken and thin (below) |
| `status` | published | ✅ |

### The `technical_specification` block is broken mid-label

Stored verbatim:

```html
<p>Body Type&nbsp;Horizontal Rectangular&nbsp;Power </p><p>Input. (kw)2.7</p>
```

The label **"Power"** has been stranded on the end of the *Body Type* line, leaving the next
line reading "Input. (kw)2.7". This is a copy-paste artefact from Ice Make's two-row table
header ("Power Input.(kW)") and it renders as visible nonsense on the product page. Same
block also has no `<table>` — it is a run of bare `<p>` tags, unlike the Skymsen-pattern
records.

### Specs Ice Make publishes that the record is missing entirely

Everything in §2's narrative table: temperature basis of the pull-down (**37 → 4 °C**),
target storage temperature (**4 °C**), voltage/frequency (**230 V / 50 Hz**), cooling system
(**direct expansion**), evaporator (**dimple jacket**), tank material (**AISI 304 SS**),
insulation (**60–75 mm CFC-free PUF, 38 ±2 kg/m³**), agitator duty cycle (**1 min every
15 min, gear motor, timer**), compressor (**hermetically sealed**), max ambient (**45 °C**),
holding performance (**≤3 °C rise in 12 h**), control panel (**IM-BMC**, digital temperature
display, compressor/agitator control, under-voltage + overload protection), **dip-stick with
chart**, condensing unit mounted under the tank behind a protective grill.

---

## 8. Product reference

| SKU | Catalogue name | Our model | Ice Make's own code | Official source | Confidence |
|---|---|---|---|---|---|
| IMG/REF/00136 | Bulk Milk Chiller 500 Litres BMC-500 | BMC-500 | **MTD-500** (photo filename uses "BMC-500-Ltr") | https://www.icemakeindia.com/bulk-milk-chiller/ | **High** on capacity, dimensions, power, phase, door/agitator count, body type, pull-down time — all direct from the manufacturer's table and independently reproduced by an Ice Make dealer |

Per-field confidence:

| Field | Confidence | Basis |
|---|---|---|
| 500 L / 1295×889×1600 mm / 1 door / 1 agitator / horizontal rectangular | **High** | Manufacturer table + dealer + official photo, all agreeing |
| 2.7 kW, 1 phase, 5 h pull-down | **High** | Manufacturer table + dealer |
| 230 V / 50 Hz | **Medium-High** | Range-wide figure on the IndiaMART mirror, consistent with Indian mains and with the 1-Ph rating |
| AISI 304, DX dimple jacket, 60–75 mm PUF, 45 °C ambient, agitator 1 min/15 min, ≤3 °C in 12 h | **High** | Ice Make's own product page (range-wide, explicitly covering the BMC line) |
| Weight 240 kg | **Medium** | Single dealer source only; Ice Make publishes no weight, and the same page also shows a contradictory 142 kg |
| **Refrigerant** | **Low** | Not published per model. Company-wide options are R-134a / R-404 / R-22 on an unofficial mirror. **Do not state a refrigerant in the record** — ask the supplier |
| ISO 5708 class | **N/A — none claimed** | Ice Make publishes no class; the 5 h figure is below ISO 5708-2 II's 3 h (§3) |

### Suggested `brands.json` copy (replacing the `"ICEMAKE"` placeholder)

> Ice Make Refrigeration Limited is an Indian manufacturer of industrial and commercial
> refrigeration equipment, established in 1993 and based in Gandhinagar, Gujarat. Its range
> spans cold rooms and PUF panels, commercial and industrial refrigeration, ammonia and
> transport refrigeration, and dairy machinery including bulk milk chillers, batch
> pasteurisers and milk storage tanks.

---

## 9. Image sourcing (July 2026) — `products resource/icemake-images/`

Ice Make's BMC page carries the product renders inline (no lazy-load placeholder trick
needed, unlike Brema), served from `icemakeindia.com/wp-content/uploads/`. Pulled with
`curl`; **every file was opened and visually inspected**, because bulk milk coolers look
near-identical across capacities and the page mixes several sizes on one screen. Every
pixel dimension and file size below was **measured after download**, not read off a page.

**14 files** (10 originally + 2 added and 2 PDFs added by the 27 July pass, §9.1). Naming
follows the Santos/Brema/Comenda convention
(`<SKU-with-dashes>__<descriptor>.<ext>`); wrong-model files carry the `REF__` prefix instead
of being deleted, and every filename now ends in `-NATIVE` or `-UPSCALED` so nobody adopts a
fake high-res file by accident (see the resolution ceiling below).

| File | Measured size | File size | What it actually shows | Source |
|---|---|---|---|---|
| `IMG-REF-00136__BMC-500-official-white-600-NATIVE.png` | **600×600** | 204 KB | ✅ **The correct machine, and the recommended primary.** Single hinged lid, **one** agitator gear-motor, one control box, tank on a tall stand with the condensing unit underneath behind perforated grilles, outlet valve on the front face. Matches "1 door / 1 agitator" exactly. Filename on Ice Make's server is literally `BMC-500-Ltr.png`, so the model identity is certain | https://www.icemakeindia.com/wp-content/uploads/2021/03/BMC-500-Ltr.png |
| `IMG-REF-00136__BMC-500-official-white-1024-UPSCALED.png` | 1024×1024 | 453 KB | ⚠ Same render, **but it is a synthetic upscale of the 600 px file, not a larger original** — proven below. Bigger on disk, no extra detail | https://www.icemakeindia.com/wp-content/uploads/2021/03/BMC-500-Ltr-1024x1024.png |
| `IMG-REF-00136__BMC-500-brushed-angled-600-NATIVE.png` | **600×600** | 88 KB | ✅ Second angle of the same single-lid / single-agitator machine in brushed steel rather than white, drain valve prominent. Server filename `finalpng-500.png` | https://www.icemakeindia.com/wp-content/uploads/2019/08/finalpng-500.png |
| `IMG-REF-00136__BMC-500-brushed-front-600-NATIVE.jpg` | **600×614** | 150 KB | ✅ Third angle, brushed steel, straight-on front. Same single-lid size class | https://www.icemakeindia.com/wp-content/uploads/2019/07/bmc_3.jpg |
| `IMG-REF-00136__control-panel-IM-BMC-627-NATIVE.jpg` | 627×388 | 105 KB | ✅ Research evidence, **not a storefront image**. The BMC control panel, branded **ICE MAKE**, panel model **`IM-BMC`** — 4-digit red LED display, up/down keys, °C indicator, **AGI** (agitator) and **COMP** (compressor) buttons, SET/ENT | https://www.icemakeindia.com/wp-content/uploads/2019/07/control_panel.jpg |
| `IMG-REF-00136__dimple-jacket-evaporator-627-NATIVE.jpg` | 627×388 | 87 KB | ✅ Research evidence, **not a storefront image**. Close-up of the **dimple-jacket evaporator plate** — confirms the direct-expansion construction described in §2 | https://www.icemakeindia.com/wp-content/uploads/2019/07/dimple_jacket.jpg |
| `REF__BMC-1000-twin-lid-1024-UPSCALED.png` | 1024×1024 | 463 KB | ❌ **Wrong size class** — twin lids, two agitator motors, visibly longer body. The MTD-1000. Also an upscale of a 600 px native | https://www.icemakeindia.com/wp-content/uploads/2021/03/BMC-1000-Ltr.effects-1024x1024.png |
| `REF__BMC-twin-lid-large-capacity-hero-1090-NATIVE.jpg` | 1090×587 | 146 KB | ❌ **Wrong size class** — twin-lid brushed-steel page banner, large-capacity unit. Ironically the highest genuine resolution in the whole set | https://www.icemakeindia.com/wp-content/uploads/2019/07/Bulk-Milk-Chiller.jpg |
| `REF__BMC-large-twin-agitator-775-NATIVE.png` | 775×504 | 146 KB | ❌ **Wrong size class** — large tank with two agitator motors and a separate side-mounted condensing unit | https://www.icemakeindia.com/wp-content/uploads/2019/07/bmc_1.png |
| `REF__BMC-twin-lid-large-capacity-30yr-600-NATIVE.png` | 600×600 | 215 KB | ❌ **Wrong size class** — twin-lid unit with a "30 years in business" badge overlaid | https://www.icemakeindia.com/wp-content/uploads/2020/08/bulk-Milk-Chiller.png |

### 🚩 Resolution ceiling: 600 px is genuinely all that exists for this SKU

**The best real image of the Ice Make BMC-500 anywhere on the public internet is 600 × 600 px.**
That is below the 800 px minimum bar, and it is not for want of trying. What was checked:

1. **Strip the thumbnail suffixes.** `-scaled`, `-1536x1536`, `-2048x2048`, `-1200x1200` all
   return **404** on `BMC-500-Ltr.png`. The un-suffixed original *is* the 600 px file.
2. **WordPress media REST API** (`/wp-json/wp/v2/media?search=BMC-500`) reports the
   attachment's **`full` size as 600 × 600**, with `large` at 1024 × 1024 registered above it —
   which is only possible if the theme force-generated an upscale.
3. **Proved the 1024 is an upscale, not an original.** Alpha-composited both files onto white,
   resampled the 600 up to 1024 with Lanczos and differenced them: **mean absolute difference
   1.35/255**, and edge energy of the real 1024 (8.92) is *lower* than the synthetic upscale
   (8.79 ≈ identical). A genuine 1024 render would carry visibly more high-frequency detail.
   It carries none.
4. **`srcset` fully enumerated** — the only entries above 1024 are `-1140x400`, which is a
   **cropped banner**, not a larger render.
5. **Corporate catalogue PDF** (`Corporate-Catalogue-2026.pdf`) images extracted losslessly with
   `pypdf`, the Comenda trick: the BMC render embedded on p.22 is only **248 × 538**.
6. **Dairy brochure PDF** — all 16 pages are flattened **816 × 1145 full-page rasters** with zero
   extractable text and no isolated per-model render.
7. **Ice Make dealer CDN** (Zoho, `cdn2.zohoecommerce.com`): requesting `2000x2000` returns a
   **500 × 500** file. The dealer's own asset is smaller than Ice Make's.
8. **TradeIndia listings** for Ice Make dairy chillers: **250 × 155 to 500 × 308**. Worse again.

Conclusion: keep the 600 px native, **label it as below the storefront bar**, and treat a
supplier-supplied photo or an in-house shot of the actual unit as the real fix. Worth noting
the record's **current** image is only **225 × 225 / 5.7 KB**, so even a 600 px native is a
~7× pixel-area improvement on what is live today.

### 9.1 Ceiling re-tested 27 July 2026 — **it held, and is now proven exhaustively**

The 600 px cap was re-tested because a peer pass had broken a "proven" WordPress ceiling
elsewhere by listing the media **collection** (`/wp-json/wp/v2/media?per_page=100&search=…`)
instead of querying individual attachment IDs — the full-size originals turned out to be
separate attachments. **That method was applied here and the ceiling still held.**

1. **Collection listing for `BMC`** returns 12 attachments. Every single BMC render is
   **600 × 600**, including `BMC-500-Ltr.png` (id 2976). There is no second, larger
   attachment hiding behind the one the earlier pass queried.
2. **Whole-library enumeration.** Rather than trust a keyword, all **1,087 media items** on
   icemakeindia.com were paged through and filtered for anything ≥1000 px on either edge —
   204 hits. Cross-referenced against `bmc` / `milk` / `chill` / `cool` / `dairy` / `mtd` /
   `tank`, **exactly one** clears 1000 px: `Bulk-Milk-Chiller.jpg` at 1090 × 587, already
   staged and already known to be a **twin-lid, wrong-size-class** banner. The site's genuine
   large assets are evaporator renders (10000 × 5489), anniversary banners and ISO
   certificates. **There is no high-resolution BMC-500 render on Ice Make's server. Full
   stop.**
3. **PDF embedded-object extraction, re-run with `fitz`/PyMuPDF** (not `pypdf`), on both
   staged PDFs:
   - `IMG-REF-00136__spec-sheet-dairy-processing-brochure-2023.pdf` — all 16 pages are
     flattened **816 × 1145 full-page JPEG rasters**. No isolated per-model render exists to
     extract. Confirms the earlier finding.
   - `icemake-full-catalogue-tradeindia.pdf` (32 pp, 5.4 MB) — likewise page-level
     composites, mostly **795 × 1124 JPEG-2000**. Largest object in the whole file is
     1589 × 1123, a page spread. Nothing per-model.
4. **Indian B2B marketplaces re-probed by direct fetch** (search engines were unavailable;
   `dir.indiamart.com/search.mp` responds fine to `curl`). Searches for
   `ice make bulk milk cooler` and `ice make bmc 500 ltr bulk milk cooler` return listings
   from **other** manufacturers — Intec, and a set of unbranded fabricators — at
   `-250x250` thumbnails. **No Ice Make-branded BMC-500 listing was found on IndiaMART,
   TradeIndia or ExportersIndia.**

**One file did clear the 800 px bar**, and it is the only thing that changed:

| File | Pixels | Size | Verdict |
|---|---|---|---|
| `IMG-REF-00136__BMC-single-lid-stand-front-watermarked-806-NATIVE.jpg` | **806 × 806** | 133,340 B | ✅ **Correct machine class** — verified by eye: one agitator gear-motor, one control box, tank on a tall stand with the condensing unit underneath behind perforated grilles, blue-handled outlet valve on the front face. ⚠ But it is **heavily watermarked** with a diagonal repeating "ICE MAKE" wordmark across the whole frame. **Above the bar but not storefront-usable** |
| `IMG-REF-00136__REF__BMC-twin-lid-large-icemake-official-4000x2250-NATIVE.jpg` | 4000 × 2250 | 841,035 B | ❌ **Wrong size class** — twin-lid, large-capacity. Highest-resolution Ice Make asset in the set and still not our machine. Kept as `REF__` only |

**Net verdict, unchanged and now firmer: `IMG/REF/00136` is effectively unsourceable at
publishable quality.** The best *clean* image of an Ice Make BMC-500 anywhere remains
**600 × 600** (`BMC-500-Ltr.png`, filename-confirmed as the 500 L). The only larger correct-
class image is watermarked. On a **KES 862,500** item currently illustrated by a 225 × 225
thumbnail, the right fix is a supplier-supplied photo or an in-house shot — not more
searching.

🚩 **Do not re-adopt `IMG-REF-00136__BMC-500-official-white-1024-UPSCALED.png`.** It remains
a synthetic Lanczos upscale of the 600 px native — the WP REST API reports that attachment's
`full` size as 600 × 600, which is dispositive. The `-UPSCALED` suffix exists to stop exactly
that mistake.

Notes for whoever adopts these:

- **The size class was the whole point of checking.** Four of the ten files are
  larger-capacity units. The discriminator is easy once you know it: the **500 L has one lid
  and one agitator motor; the 1000 L+ units have two lids and two motors**. The
  `REF__`-prefixed files would have been an easy and invisible mistake.
- ⚠ **The two brushed-steel angles cannot be pinned to 500 L by eye.** `MTD-250` and `MTD-500`
  share "1 door / 1 agitator" and the same 63 in stand height, so they are visually
  indistinguishable. `finalpng-500.png` carries "500" in its server filename, which is decent
  but not conclusive; `bmc_3.jpg` carries nothing. Only
  `IMG-REF-00136__BMC-500-official-white-600-NATIVE.png` is filename-confirmed as the 500 L.
  Use that one as primary and the others as secondary gallery shots at your own risk.
- **There is no dimensional line drawing for MTD-250/500.** Ice Make publishes drawings only
  for `MTD-1000`, `MTD-1500/2000` and `MTD-3000/5000/10000`
  (`.../2021/03/MTD-1000.png` etc.). Not downloaded — none of them is our model.
- **Nothing copied into `storage/app/public/products/` and nothing referenced in
  `products.json`** — staged in Downloads for review, same as the Santos, Brema and Comenda
  sets. No logos, sprites, icons or spacers were kept.

---

## 10. Recommended changes — concrete, in priority order

**Nothing below has been applied.** No `products.json`, no `brands.json`, no images copied.

### P1 — 🚩 State the chilling performance honestly (§3)

This is the only change with a real commercial and food-safety consequence.

1. **In `description`, delete "designed to quickly cool large quantities of milk"** and
   replace with the actual, sourced performance:
   *"Chills a full 500-litre batch from milking temperature (≈37 °C) down to 4 °C in
   5 hours, then holds it at 4 °C — with a temperature rise of no more than 3 °C over
   12 hours if power is lost."*
2. **In `technical_specification`, change the bare `Pull down time 5 Hr`** to
   `Pull-down time — 5 hours (≈37 °C to 4 °C, full tank)`. The number stays; the basis gets
   stated. A time figure with no temperature basis is meaningless to a dairy buyer.
3. **Do not add an ISO 5708 class, and do not imply one.** Ice Make claims none, and the
   published 5 h is outside ISO 5708-2 II's 3 h. If a customer asks specifically for an
   ISO-class BMC for two-milking co-operative collection, this model does not qualify and
   sales should know that before quoting.
4. **Consider adding an internal/staff note** that this SKU is positioned for single-farm and
   small collection-point use, not for NDDB-style tender specs.

### P2 — Fix the broken `technical_specification` and build it out (§7)

5. **Repair the stranded "Power" label** — `Body Type Horizontal Rectangular Power` /
   `Input. (kw)2.7` must become two clean rows: `Body type — Horizontal rectangular` and
   `Power input — 2.7 kW`.
6. **Reformat to the Skymsen pattern** used across the rest of the catalogue: prose +
   `<h3>Key Features</h3>` + an HTML `<table>`. Strip the `ql-align-justify` classes and the
   trailing `<p><br></p>`.
7. **Add the manufacturer specs the record is missing** (all from §2, all High confidence):

   | Row | Value |
   |---|---|
   | Tank capacity | 500 litres |
   | Body type | Horizontal rectangular, 1 lid/door |
   | Cooling system | Direct expansion (DX), dimple-jacket evaporator |
   | Storage temperature | 4 °C |
   | Pull-down time | 5 hours (≈37 °C → 4 °C, full tank) |
   | Temperature rise on power loss | ≤3 °C in 12 hours |
   | Tank material | AISI 304 stainless steel, fully welded and polished, sloped drain |
   | Insulation | 60–75 mm CFC-free polyurethane foam, density 38 ±2 kg/m³ |
   | Agitator | 1 × gear motor, timer-controlled — 1 minute every 15 minutes |
   | Compressor | Hermetically sealed, air-cooled condensing unit under the tank |
   | Max ambient | 45 °C |
   | Control panel | Ice Make IM-BMC — digital temperature display, compressor and agitator control, overload and under-voltage protection |
   | Milk measurement | Dip-stick with calibration chart supplied |
   | Power input | 2.7 kW |
   | Power supply | 230 V / 50 Hz, single phase |
   | Dimensions (L×W×H) | 1295 × 889 × 1600 mm |
   | Net weight | 240 kg *(dealer-sourced — see §2)* |

8. **Do NOT add a refrigerant row.** Low confidence (§8); confirm with the supplier first.

### P3 — Brand record (§1)

9. **`brands.json` → set `website_url: "https://www.icemakeindia.com"`** (currently `null`).
   Do not use `icemakeindia.co.in` — it 403s to non-browser clients.
10. **Replace `description: "ICEMAKE"`** with the real copy drafted in §8.
11. *(Optional, cosmetic)* set display `name` to `"Ice Make"` — that is how the manufacturer
    writes it — per [[project_brand_name_casing]].

### P4 — Description-field split and SEO (§7)

12. **Rewrite `short_description`** to a neutral scannable summary with no "in Kenya" and
    with the differentiating spec in it, e.g. *"500-litre direct-expansion bulk milk chiller
    with AISI 304 tank, timer-controlled agitator and single-phase 2.7 kW supply. Chills a
    full batch from 37 °C to 4 °C in 5 hours."*
13. **Add a `meta_description`** carrying the Kenya/SEO framing that currently sits wrongly in
    `short_description`. Per [[project_description_field_split]].

### P4b — Replace the 225 px product image (§7, §9)

The live image is **225 × 225 px / 5.7 KB** on a KES 862,500 item. Swap in
`IMG-REF-00136__BMC-500-official-white-600-NATIVE.png` (600 × 600, filename-confirmed as the
500 L) as an interim ~7× improvement, and treat a supplier-supplied or in-house photo as the
real fix — 600 px is the ceiling of what Ice Make and its dealers publish, and it is still
below the storefront bar.

### P5 — Copy additions worth making (§4, §5)

14. **Lead on single-phase power as a selling point** — "runs on ordinary 240 V single-phase
    mains, no three-phase supply required" is genuinely differentiating for rural Kenyan
    collection points, and is the same commercial angle the Comenda EF36M pass identified.
    Add an installation note that it wants its own dedicated circuit (~13–14 A running, with
    compressor inrush well above that).
15. **Add clearance guidance** — 1600 mm overall height with top-hinged lids means headroom
    above 1600 mm is required to open the tank, plus ventilation clearance around the
    under-slung condenser.
16. **Mention the Ice Make series code `MTD-500`** in the body copy so quotes can be matched
    against the manufacturer's table — without touching `model_number` (§6).

### Explicitly NOT recommended

- ❌ **Do not change `model_number`.** `BMC-500` is a legitimate Ice Make trade name for this
  machine (its own photo filename uses it), and per [[feedback_model_number_unique_id]] it is
  the catalogue's unique ID regardless.
- ❌ **Do not touch `length` / `width` / `height`.** Verified correct to the millimetre; there
  is no axis swap on this SKU (§5).
- ❌ **Do not "correct" the 5-hour pull-down.** It is Ice Make's own published figure and is
  physically consistent with the 2.7 kW single-phase design (§4). It is a real limitation to
  disclose, not a data error to fix.
- ❌ **Do not state a refrigerant** until the supplier confirms it (§8).

---

## 11. Sources

- https://www.icemakeindia.com
- https://www.icemakeindia.com/bulk-milk-chiller/
- https://www.icemakeindia.com/catalogue/
- https://www.icemakeindia.com/wp-content/uploads/2026/01/Corporate-Catalogue-2026.pdf
- https://www.icemakeindia.com/wp-content/uploads/2023/03/Dairy-Proccessing-brochure-2023.pdf
- https://www.icemakeindia.com/contact_us/
- https://www.icemakeindia.co.in/dairy-machinery.html
- https://www.kamlaenterprises.net/products/ice-make-bulk-milk-chiller-500-ltr-bmc/632502000000526020
- https://www.nddb.coop/sites/default/files/pdfs/BMCU%20SPECS%201-2%20KL.pdf
- https://www.iso.org/standard/11819.html
- https://htindiatech.com/product/bulk-milk-cooler-bmc-500-ltr/
- https://www.icemakeindia.com/wp-content/uploads/2021/03/BMC-500-Ltr-1024x1024.png
- https://www.icemakeindia.com/wp-content/uploads/2019/07/control_panel.jpg
- https://www.icemakeindia.com/wp-content/uploads/2019/07/dimple_jacket.jpg
