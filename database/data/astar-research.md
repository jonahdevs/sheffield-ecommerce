# Astar Product Research

Research notes behind the ASTAR enrichment/audit pass on `products.json` (July 2026).
Covers all **10 ASTAR SKUs** — 6 meat processors, 2 vegetable processors, 1 pastry display,
1 gas pasta cooker. Specs sourced from Astar's own site (astarkitchen.com) and cross-checked.
**No `model_number` was changed** this pass; researched codes and near-matches are recorded
here in §5 for review. Image sourcing (§6) is presented as links for manual review.

---

## 1. Brand identification

**Astar** = **Guangzhou Astar Kitchen Equipment Co., Ltd.** (also trades as "Astar Kitchen" /
"Astar Bakery"), founded 2008, Baiyun District, Guangzhou, China. It is a broad-line Chinese
manufacturer/trading brand covering baking ovens, mixers, food-prep machines, refrigeration,
display cabinets and catering equipment across 180+ countries. This is a **house/OEM-style
brand**: the same machine bodies are sold under many suffix-coded model numbers, and our
catalogue's codes frequently use a **different prefix** than Astar's own current site codes
(e.g. our `TB-10L` sausage stuffer ↔ Astar's `EV-10L`; our `TC-42` ↔ Astar's `TC-42A`).
**Match on product type + capacity, not the code.**

Official sites:
- **www.astarkitchen.com** — main catalogue, fetch-friendly. Search URL:
  `https://www.astarkitchen.com/phoenix/admin/prod/search?searchValue=TERM`
- **www.astarbakery.com** — bakery-focused sister site (ovens/mixers/proofers).
- Product page URLs: `.../Astar-<Name>-<model>-pd<digits>.html`
- Product images sit on a CDN: `inrorwxhmqjnli5p-static.micyjz.com/cloud/...`

### The house-brand reality (why hit rate is ~50%)
Of the 10 catalogue SKUs, **6 resolve** to a real Astar page (exact or near-code), and **4 are
not on the site under any search term** (ASKL-650, SXW-280, BC-135L, GH-538). This mirrors the
[[project_web_enrichment_pilot]] finding: house-brand codes often don't resolve, and the real
payoff of the pass is **catching catalogue errors** on the ones that do.

---

## 2. Product reference

| SKU | Catalogue name | Our model | Astar match | Match quality | Official page |
|---|---|---|---|---|---|
| IMG/FPR/00177 | Vegetable Processor S-QC205 | S-QC205 | **QC205A / QC205B** (Vegetable Preparation Machine) | near (prefix differs) | [QC205A](https://www.astarkitchen.com/Astar-Vegetable-Preparation-Machines-QC205A-pd547958638.html), [QC205B](https://www.astarkitchen.com/Astar-Vegetable-Preparation-Machines-QC205B-pd537958638.html) |
| IMG/FPR/00183 | Cutter Mixer ASKL-650 | ASKL-650 | **NONE** | not found | — |
| IMG/FPR/00164 | Meat Grinder 22 TK-22 | TK-22 | **TK-22** (Commercial Meat Grinder) | exact | [TK-22](https://www.astarkitchen.com/Astar-Commerical-Meat-grinder-TK-22-pd598068638.html) |
| IMG/FPR/00178 | Meat Grinder 42 TC-42 | TC-42 | **TC-42A** (Standing Electric Meat Grinder) | near (drops "A") | [TC-42A](https://www.astarkitchen.com/Astar-Standing-Electric-Meat-Grinder-TC-42A-pd518068638.html) |
| IMG/FPR/00181 | Meatball Making Machine | SXW-280 | **NONE** | not found | — |
| IMG/FPR/00184 | Manual Hamburger Press 130 | 130 | **ASY-130** (Burger Patty Machine) | strong (130 = patty ⌀) | [ASY-130](https://www.astarkitchen.com/Astar-Burger-Patty-Machine-ASY-130-pd574858638.html) |
| IMG/FPR/00180 | Electric Sausage Stuffer | TB-10L | **EV-10L** (Electric Sausage Stuffer) | near (prefix differs) | [EV-10L](https://www.astarkitchen.com/Astar-Electric-Sausage-Stuffer-EV-10L-pd544068638.html) |
| IMG/HOT/00196 | Tumble Marinator | BC-135L | **NONE** | not found | — |
| IMG/DIS/00090 | Pastry Showcase Square 1200 | FG-1200LS | **AL-1200A** (Cake Display Cabinet) | weak (size only, code differs) | [AL-1200A](https://www.astarkitchen.com/Astar-Bakery-AL-1200A-Cake-Display-Cabinet-pd559218068.html) |
| IMG/HOT/00304 | Pasta Cooker Gas GH-538 | GH-538 | **ASGH-988 / ASGH-788** (Gas Pasta Cooker w/ Cabinet) | category only, code differs | [ASGH-988](https://www.astarkitchen.com/Astar-Gas-Pasta-Cooker-with-Cabinet-ASGH-988-pd514858638.html) |

---

## 3. Verified official specs (from Astar product pages)

### 3.1 TK-22 Commercial Meat Grinder (IMG/FPR/00164) — exact match ✅
Power **1,100 W** · **110 V/60 Hz or 230 V/50 Hz** · output **220 kg/h** · net weight **18.6 kg**,
gross **20.0 kg** · packing size **605 × 265 × 455 mm** · No. 22 grinding head · stainless steel.
(Note: Astar's on-page spec table labels the rows "TD-12/22/32" — a template-label quirk on
their own site; the TD-22 row is the TK-22.)

### 3.2 TC-42A Standing Electric Meat Grinder (IMG/FPR/00178) — near match ✅
42# grinder head, 6 mm & 8 mm plates · Power **4,000 W** · **380 V, 50/60 Hz (three-phase)** ·
capacity **650 kg/h** · machine size **1,095 × 535 × 930 mm** · packing 1,020 × 530 × 950 mm ·
net weight **107 kg**, gross 203 kg · stainless steel housing/head/knives.
⚠ This is a **large 3-phase industrial unit** — a very different tier from the 1.1 kW TK-22.
Our catalogue price (KES 411,970 vs TK-22's 184,000) is consistent with the industrial tier.

### 3.3 QC205A / QC205B Vegetable Preparation Machine (IMG/FPR/00177) — near match ✅
Power **1,000 W (1.0 kW)** · **220 V** · blade speed **329 rpm** · blade ⌀ **205 mm** · **5 knives** ·
output **>180 kg/h** · machine size ≈ **590 × 265 × 540 mm** · packing 580 × 385 × 550 mm ·
net weight **28 kg (QC205A) / 27 kg (QC205B)**. (A and B differ only in weight/minor size.)

### 3.4 ASY-130 Burger Patty Machine (IMG/FPR/00184) — strong match ✅
Manual (non-electric) · patty diameter **130 mm** · patty height **25 mm** · net weight **4.8 kg** ·
package size **285 × 315 × 255 mm** · anodized-aluminium base + stainless steel bowls · single-lever
press, non-skid feet, detachable paper holder.

### 3.5 EV-10L Electric Sausage Stuffer (IMG/FPR/00180) — near match ✅
Capacity **10 L** · Power **120 W (0.12 kW)** · **220 V** · motor speed 1,350 rpm · net weight
**24.8 kg** · dimensions **635 × 500 × 380 mm** · two-speed enclosed gearing, pressure-release
valve, vertical space-saving design.

### 3.6 AL-1200A Cake Display Cabinet (IMG/DIS/00090) — weak/size-only match ⚠
Dimensions **1,200 × 700 × 1,200 mm** · **220 V / 50 Hz** · input power **350 W** · temperature
**4–8 °C** · fan cooling · refrigerant **R134a** · microcomputer temp control, imported compressor,
double-layer insulating glass, LED lighting, plastic shelves. **Code differs entirely** (FG-1200LS
vs AL-1200A) and the glass-shape (square/flat vs curved) is not confirmed on the page — size match
only. Sanity-check against a photo before treating these numbers as authoritative.

### 3.7 ASGH-988 / ASGH-788 Gas Pasta Cooker with Cabinet (IMG/HOT/00304) — category match only ⚠
ASGH-988: 800 × 900 × 940 mm, gas, **42,309 BTU (~12.4 kW)**, net 82 kg. ASGH-788: 800 × 730 × 940 mm,
same BTU, net 63 kg. Flame-sense safety, explosion-proof ignition, flame-out protection, temp control.
**No "GH-538" / "538" product exists on the site** — this is the right *category* but not the code;
basket count / tank capacity aren't published. Do not apply these numbers as GH-538 specs.

---

## 4. Not found on the official site (leave unverified — do not invent)

- **ASKL-650 Cutter Mixer** (IMG/FPR/00183): no hit under "ASKL-650", "cutter mixer", "bowl cutter",
  "650". Astar's closest bowl-cutter line is "Bowl Food Cutter" AW-6L/9L/15L (litre-coded, largest
  1.8 kW / 550 × 390 × 470 mm) — a different naming class, **not a confident match**. Leave as-is.
- **SXW-280 Meatball Making Machine** (IMG/FPR/00181): no meatball-forming product found under any
  term. ⚠ Our current DB description is **copy-pasted Tumble-Marinator text** (wrong) — see §4.1.
- **BC-135L Tumble Marinator** (IMG/HOT/00196): no tumble/vacuum marinator on the site (their
  "meat tenderizer" MS737/ES737 is a different product type). Leave unverified.
- **GH-538 Pasta Cooker** (IMG/HOT/00304): only same-category near-matches (ASGH-988/788). Leave
  the code and specs unverified.

### 4.1 SXW-280 description is wrong (copy-paste error) — recommended fix
IMG/FPR/00181's `description` is verbatim Tumble-Marinator copy ("The Tumble Marinator reduces the
time needed to marinate proteins…"), which has nothing to do with a meatball machine. Since no
verified meatball-machine copy is available from the official site, the recommendation is to
**blank the wrong description** rather than leave misleading text — pending approval, not applied.

---

## 5. Data errors found (corrections in §3 applied to `products.json` where confident)

| SKU | Field | Was | Now (official) |
|---|---|---|---|
| IMG/FPR/00177 (S-QC205) | power | 350 W (desc) / 1,047 W (spec table) — self-contradictory | **1,000 W** (official) |
| IMG/FPR/00177 | output | 400 kg/h | **>180 kg/h** (official; 400 was inflated) |
| IMG/FPR/00177 | rpm | 510 rpm | **329 rpm** |
| IMG/FPR/00177 | net weight | 19 kg | **28 kg** |
| IMG/FPR/00164 (TK-22) | full spec | none | added full official spec table |
| IMG/FPR/00178 (TC-42) | full spec | none | added TC-42A official spec table |
| IMG/FPR/00180 (TB-10L) | voltage | 120 V / 110 V | **220 V** (confirmed wrong for Kenya market) |
| IMG/FPR/00180 | full spec | prose only | added EV-10L-equivalent spec table |
| IMG/FPR/00184 (press 130) | materials/patty | minimal | added ASY-130 patty size + materials |

### Model-code flags (recorded, NOT changed — awaiting approval)
Per catalogue policy `model_number` is the tracking ID and is not altered without sign-off
(see [[feedback_model_number_unique_id]]). Researched code relationships:
- `S-QC205` → Astar's current codes are **QC205A / QC205B** (the "S-" prefix is a distributor tag).
- `TC-42` → Astar's code is **TC-42A** (we drop the "A"). It's the 380 V industrial standing grinder.
- `TB-10L` → Astar's current code is **EV-10L** (same 10 L class, different prefix).
- `130` → Astar's code is **ASY-130** ("130" = the 130 mm patty diameter; accurate as-is).
- `FG-1200LS` → nearest is **AL-1200A** (size match only; keep FG-1200LS until confirmed).
- `GH-538` → no Astar code match; nearest category is **ASGH-988 / ASGH-788**.

### Open reconciliations (not changed)
- **ASY-130 dimensions**: our DB has 450 × 370 × 350 mm; official *package* size is 285 × 315 × 255 mm.
  Unclear whether the DB figure is assembled footprint vs carton — left as-is, flag for a physical check.
- **TC-42 tier**: confirm the shipped unit is the 380 V 3-phase 4 kW TC-42A (not a smaller 42# unit).

---

## 6. Image sourcing — for manual review

Astar product images live on the `inrorwxhmqjnli5p-static.micyjz.com/cloud/...` CDN (studio shots,
white background). Prepend `https:` to the `//`-relative URLs. **Verify each is watermark-free and
that it shows the exact unit before use** — house-brand CDNs reuse shots across near-models.

| SKU | Model | Image URL(s) |
|---|---|---|
| IMG/FPR/00164 | TK-22 | `https://inrorwxhmqjnli5p-static.micyjz.com/cloud/lpBpmKpilmSRklqikppjjp/TD-800-800.jpg` |
| IMG/FPR/00178 | TC-42A | `https://inrorwxhmqjnli5p-static.micyjz.com/cloud/liBpmKpilmSRklnoikqrjp/kanglaidakuan-daxing-800-800.png` |
| IMG/FPR/00177 | QC205A | `https://inrorwxhmqjnli5p-static.micyjz.com/cloud/lqBpmKpilmSRklkoknrijq/WED-QC205A-800-800.png` |
| IMG/FPR/00184 | ASY-130 | `https://inrorwxhmqjnli5p-static.micyjz.com/cloud/lrBpmKpilmSRklmjkiinjp/SY-800-800.png` |
| IMG/FPR/00180 | EV-10L | `https://inrorwxhmqjnli5p-static.micyjz.com/cloud/lpBpmKpilmSRklijlkjqjq/EV-10L-800-800.jpg` |
| IMG/DIS/00090 | AL-1200A | `https://inrorwxhmqjnli5p-static.micyjz.com/cloud/lnBpmKpilmSRojplimmljm/XL-1200A-1500A-1800A-1500-800.jpg` |
| IMG/HOT/00304 | ASGH-988 | `https://inrorwxhmqjnli5p-static.micyjz.com/cloud/ljBpmKpilmSRklmjninijp/ASGH-988-GH-800-800.png` |

No images for ASKL-650, SXW-280, BC-135L (not on site). AL-1200A / ASGH-988 images are for the
near-match models, not confirmed identical to our units — treat as candidates only.
