# ASTAR — product research (2026-07-31 redo)

**This file supersedes `old/astar-research.md`.** The archived file predates the SAP export and
several of its conclusions are wrong — in particular its `FG-1200LS → AL-1200A` match (wrong glass
shape) and its "GH-538 is not a real code" conclusion (it is; see §4). Nothing in `old/` should be
treated as verified any more; where the two disagree, this file is the current position.

Scope: all **10 ASTAR SKUs**. Every image staged in
`Desktop\ecommerce\products resorce final\astar\` was **downloaded and visually rendered** before
being accepted. **No AI-generated imagery was found this pass** — no `_ai-generated\` folder exists.
No `model_number` is proposed for change inline; code recommendations are in §7 awaiting approval.

---

## 1. Sources actually used

- Astar's own catalogue: https://www.astarkitchen.com — a Chinese SaaS storefront. Full sitemap at
  https://www.astarkitchen.com/sitemap.xml lists **1,004 product pages**, which is the fastest way
  to resolve a code (far better than the site's own search, which silently returns nothing).
- Guangzhou Jieguan (real manufacturer of the GH-538): https://gzjieguan.en.made-in-china.com
- Guangdong Maxbaker / Foshan **Libaoda** (real manufacturer of the SXW meatball series):
  https://maxbaker.en.made-in-china.com
- Vietnamese distributors, which carry the only usable SXW-280 photography:
  https://dienmaybigstar.com/san-pham/may-tao-vien-thit-ca-sxw-280/
  https://sieuthihaiminh.vn/may-tao-vien-thit-ca-sxw-280.html
  https://maylambanhmi.info/san-pham/may-tao-vien-thit-ca-sxw-280/
- https://albaitalhalabi.com — Inofrigo FCS cake-showcase range (spec twin of FG-1200LS, §5)

### Tooling notes worth keeping
- **Astar CDN full-resolution trick**: page images are served as
  `…/cloud/<folderid>/<name>-800-800.jpg`. **Strip the `-WWW-HHH` suffix** and you get the
  uploaded original: `TD-800-800.jpg` (800px) → `TD.jpg` (**2836×2832**). Same trick took the
  ASY-130 shot to **6836×4010**. Not every asset has a bigger original — several genuinely *are*
  800×800 or 750×750, and that is the proven ceiling, not a fetch failure.
- The Astar HTML is brotli-compressed; `curl` needs `--compressed` or you get binary garbage.
- Astar product pages carry **one** gallery image each (two on the cake cabinets). There is no
  downloads/spec-sheet section — https://www.astarkitchen.com/download.html is empty.
  **No spec-sheet PDF exists for any ASTAR SKU.** Specs below are transcribed from on-page tables.
- `lite.duckduckgo.com` CAPTCHA'd this session. Made-in-China's `/productSearch?word=` endpoint
  404s; the working keyword search is
  `https://www.made-in-china.com/products-search/hot-china-products/<CODE_with_underscores>.html`.
- Made-in-China thumbnail → original: rewrite the `NNNf0j00…` token to `2f0j00…`.
- WordPress `/wp-json/wp/v2/media?per_page=100&search=…` was the single most efficient way to find
  the best resolution on the Vietnamese and UAE dealer sites.

---

## 2. Result summary

| SKU | Catalogue model | Sourced as | Status | Best px (short edge) | Agrees with SAP |
|---|---|---|---|---|---|
| IMG/FPR/00164 | TK-22 | TK-22 (exact) | sourced | 2836×2832 (2832) | partial |
| IMG/FPR/00178 | TC-42 | TC-42A (NEARMATCH) | sourced | 800×800 (800) | values yes, code no |
| IMG/FPR/00177 | S-QC205 | QC205A + QC205B (NEARMATCH) | sourced | 800×800 (800) | **no** |
| IMG/FPR/00184 | 130 | ASY-130 (NEARMATCH) | sourced | 6836×4010 (4010) | partial |
| IMG/FPR/00180 | TB-10L | EV-10L (CODEMISMATCH) | sourced | 1500×1500 (1500) | **no** |
| IMG/FPR/00181 | SXW-280 | SXW-280 (exact, via Libaoda/VN dealers) | sourced | 900×1355 (900) | **no** (see §3) |
| IMG/HOT/00304 | GH-538 | GH-538 (exact, Jieguan) | sourced | 1851×1389 (1389) | **yes** |
| IMG/DIS/00090 | FG-1200LS | AL-1200B + FCS120R3M (CODEMISMATCH) | partial | 1079×1102 (1079) | partial |
| IMG/FPR/00183 | ASKL-650 | — | **not reachable** | — | — |
| IMG/HOT/00196 | BC-135L | — | **not reachable** | — | — |

---

## 3. The highest-value findings

### 3.1 SAP's contaminated pair: the bad half is **00180**, not both
The dossier flags `IMG/FPR/00180` (TB-10L stuffer) and `IMG/FPR/00181` (SXW-280 meatball machine)
as both carrying an identical, known-bad `370/490/1200`. Independent sourcing now shows the pair is
**not symmetrically wrong**:

- **IMG/FPR/00181 SXW-280** — dealer photography shows a **tall floor-standing** machine (motor
  head on a column, hopper cone, discharge chute, castors at floor level). Vietnamese dealers quote
  **760×355×1220 mm** (https://sieuthihaiminh.vn/may-tao-vien-thit-ca-sxw-280.html) and
  **620×370×1250 mm**. SAP's `370/490/1200` has the width (**370**) and the height (**1200**)
  right. So the disputed figure is **plausibly the SXW-280's own** and only the depth is doubtful.
  Our `products.json` value of **325/450/215** cannot be right for this machine at all — a 215 mm
  tall object is a bread bin, not this. **`products.json` is the wrong record here, not SAP.**
- **IMG/FPR/00180 TB-10L** — Astar's 10 L vertical electric stuffer is **635×500×380 mm**, which is
  exactly our `products.json` value (500/380/635, reordered). SAP's `370/490/1200` is simply the
  neighbouring row's data, and SAP's own *remark* for this SKU (690×440×340, 11 L) matches neither.
  **Three different sizes for one machine; the products.json one is the one with corroboration.**

### 3.2 FG-1200LS is a **square** cabinet — the archived AL-1200A match was wrong
`old/astar-research.md` matched FG-1200LS to Astar's **AL-1200A**. Rendering that image shows it is
a **curved-glass** cabinet. SAP calls this SKU `PASTRY SHOWCASE SQUARE` and its remark says
"Right angle". Astar's square/right-angle equivalent is **AL-1200B**
(https://www.astarkitchen.com/Astar-Bakery-AL-1200B-Cake-Display-Cabinet-pd569218068.html),
1200×680×1200 mm. The curved AL-1200A images were **deleted** rather than staged, per the
"door-type contradiction" rule. §7 of the archived file worried that "the real photo shows curved
glass while the name says Square" — that worry came from matching the wrong Astar model.

### 3.3 GH-538 is a real code and SAP's remark is a verbatim copy of the manufacturer's spec
`old/astar-research.md` §7 concluded GH-538 was a distributor-assigned code and that the Jieguan
countertop numbers should not be applied. That is now refuted:
https://gzjieguan.en.made-in-china.com/product/AZkGdaucXEhj/China-Counter-Top-Gas-Noodle-Cooking-Machine-Pasta-Cooker-6-Baskets-Gh-538.html
gives **Model GH-538, Jieguan, 400×650×480 mm, 19,000 BTU, 17.5 kg, stainless 201, 1 burner,
6 baskets** — every one of those numbers appears verbatim in SAP's remark. SAP's remark was
transcribed from Jieguan. The archived file's **ASGH-988** lead (800×900×940 mm, 42,309 BTU, 82 kg,
floor-standing cabinet) is a **completely different machine class** and its image has been deleted
from the staging folder so it cannot mislead.
**Unresolved**: the archived file says a user-confirmed photo of the shipped Sheffield unit showed
a large floor-standing cabinet unit. If that recollection is right, the shipped unit is not a
GH-538 at all, and SAP's remark is a paper spec that never matched the goods. That needs a physical
check; the exact-code evidence is much stronger than the recollection, so GH-538/Jieguan is staged.

### 3.4 S-QC205: SAP's dimensions are wrong and our own record is right
Astar's QC205A page states machine size **590×265×540 mm**
(https://www.astarkitchen.com/Astar-Vegetable-Preparation-Machines-QC205A-pd547958638.html).
Our `products.json` holds 265/590/540 — the same three numbers. SAP's L/W/H field says
**580/470/370** and SAP's remark says **535×270×525** — a third, different set. This is a fifth
instance of the pattern already recorded in the dossier: *taken to the manufacturer, our data was
right and SAP was wrong.*

### 3.5 SXW's real manufacturer is Libaoda, not Maxbaker
The rating plate visible in the Maxbaker listing photo reads **LIBAODA / 利宝达厨具机械** and
**SXW-200**. Maxbaker (Guangdong Maxbaker Bakery Equipment Tech) is a trading house reselling
Foshan Libaoda's machine. Every English-language SXW listing traces to one of the two.
The series is **SXW-200 (vertical) / SXW-280 (horizontal)** per Maxbaker's own copy — but every
SXW-280 photograph found is of a tall, upright, floor-standing machine, so "horizontal" in that
copy is unreliable. Treat the vertical/horizontal distinction as unverified.

---

## 4. Per-SKU detail

### IMG/FPR/00164 — TK-22 · Meat Grinder 22 · EXACT CODE
Page: https://www.astarkitchen.com/Astar-Commerical-Meat-grinder-TK-22-pd598068638.html
Image: `IMG-FPR-00164__TK-22-astarkitchen-1.jpg` — **2836×2832**, CMYK JPEG, watermark-free studio
shot; bench-top #22 grinder, OFF/OVER-TURN rotary selector plus red/green pushbuttons, plastic
pusher, hex-plate head.
Astar's on-page table is labelled **TD-12 / TD-22 / TD-32** (their own template quirk); the TD-22
column is this machine: **1,100 W · 110 V/60 Hz or 230 V/50 Hz · 220 kg/h · N.W. 18.6 kg /
G.W. 20.0 kg · packing 605×265×455 mm**.
⚠ **Conflict with SAP**: SAP's remark says **250 kg/h and 0.85 kW**; Astar says **220 kg/h and
1,100 W**. 0.85 kW is Astar's **TD-12** figure — SAP looks to have taken the wrong column.
⚠ SAP L/W/H is `0/0/0` (missing) and Astar publishes only a **packing** size, so **no machine
dimension exists for this SKU from any source.**

### IMG/FPR/00178 — TC-42 · Meat Grinder 42 · NEARMATCH (TC-42A)
Page: https://www.astarkitchen.com/Astar-Standing-Electric-Meat-Grinder-TC-42A-pd518068638.html
Image: `IMG-FPR-00178__TC-42A-NEARMATCH-astarkitchen-1.png` — **800×800** (proven ceiling; the
unsuffixed CDN original is the same 800px asset). Genuine: floor-standing body on castors, large
meat pan, 4-button panel in a red-outlined plate.
Astar: **42# head, 6 & 8 mm plates, 650 kg/h, 380 V 50/60 Hz three-phase, 4,000 W, N.W. 107 kg /
G.W. 203 kg, machine size 1095×535×930 mm, packing 1020×530×950 mm.**
SAP remark says **1100×440×970**; our record says **535/930/1095** = Astar's three numbers
reordered. SAP L/W/H is `0/0/0`. Astar's 650 kg/h and 4 kW agree with SAP's remark exactly.

### IMG/FPR/00177 — S-QC205 · Vegetable Processor · NEARMATCH (QC205A / QC205B)
Pages: https://www.astarkitchen.com/Astar-Vegetable-Preparation-Machines-QC205A-pd547958638.html
and https://www.astarkitchen.com/Astar-Vegetable-Preparation-Machines-QC205B-pd537958638.html
Images: `…__QC205A-NEARMATCH-astarkitchen-1.png` and `…__QC205B-NEARMATCH-astarkitchen-2.png`,
both **800×800** (ceiling). **Both variants staged deliberately** — the two are visually different
(A has a short open chute, B a taller chute with a longer pusher arm) and nothing in our record
says which one we sell. Do not collapse them to one image without deciding.
Astar (both): **329 r/min · >180 kg/h · 5 knives · ⌀205 mm blade · 220 V · 1.0 kW ·
packing 580×385×550 mm · N.W. 28 kg (A) / 27 kg (B)**. QC205A machine size **590×265×540 mm**;
the QC205B page prints "630*2665*530mm", an obvious typo (266.5?).
⚠ SAP's remark (350 W, 19 kg) disagrees with Astar's 1.0 kW / 28 kg. See §3.4 for dimensions.

### IMG/FPR/00184 — `130` · Manual Hamburger Press · NEARMATCH (ASY-130)
Page: https://www.astarkitchen.com/Astar-Burger-Patty-Machine-ASY-130-pd574858638.html
Image: `IMG-FPR-00184__ASY-130-NEARMATCH-astarkitchen-1.png` — **6836×4010**, by far the highest
resolution obtained this pass. Genuine: anodised aluminium body, two stainless bowls, black lever
handle, non-skid feet, detachable paper holder.
Astar: series **ASY-100 / ASY-130 / ASY-150 / ASY-3IN1**, the number is the **patty diameter in mm**.
ASY-130: **⌀130 mm, patty height 25 mm, N.W. 4.8 kg, package 285×315×255 mm.** Manual, no motor.
⚠ SAP L/W/H `0/0/0`; our record says 450/350/370, which matches neither the machine nor Astar's
carton. Unexplained — flag for a physical measure.

### IMG/FPR/00180 — TB-10L · Electric Sausage Stuffer · CODEMISMATCH (EV-10L)
Page: https://www.astarkitchen.com/Astar-Electric-Sausage-Stuffer-EV-10L-pd544068638.html
Image: `IMG-FPR-00180__EV-10L-CODEMISMATCH-astarkitchen-1.jpg` — **1500×1500**. Genuine: the
WARNING decal on the cylinder is legible, the control plate has a 2-digit display, six buttons and
a red mushroom e-stop, and a foot pedal trails to the right.
Astar: **EV-10L / EV-12L / EV-15L**; EV-10L = **10 L · 1,350 r/min · 220 V · 0.12 kW · N.W. 24.8 kg
· 635×500×380 mm.**
**No `TB-10L` exists at any manufacturer** — the only web hits for the code are our own
sheffieldafrica.com listings, which are not admissible as a source. TB-10L is a house/distributor
code. See §3.1 for the dimension conflict.

### IMG/FPR/00181 — SXW-280 · Meatball Making Machine · EXACT CODE, non-Astar
Manufacturer: **Foshan Libaoda** (利宝达厨具机械), traded by Guangdong Maxbaker. **Not an Astar
product** — Astar's catalogue has no meatball former under any search term.
Series copy: https://maxbaker.en.made-in-china.com/product/QFTfqYsyEvUN/China-Meat-Product-Making-Machine-280-Pieces-Per-Minute-Chicken-Ball-Making-Machine-for-Sale.html
(that listing is the **SXW-200**: 220 V 50 Hz, 1.1 kW, 240 r/min, 200 pcs/min, ball ⌀ 21/22/24/27 mm,
710×355×820 mm, N.W./G.W. 72/85 kg.)
SXW-280 figures from dealers: **220 V, 1,100 W, ~200–280 pcs/min (200–300 kg/h),
ball ⌀ 18/22/26 mm, 760×355×1220 mm, 72 kg.**
Images staged (7): five from Dién Máy Bigstar (**900×1355, 900×1197, 900×675 ×2, 900×654** — dealer
photos, carry a `dienmaybigstar.com` watermark) and two clean unwatermarked shots from Siêu Thị Hải
Minh (**600×600 each — below the 800 px floor, and 600 is that host's proven ceiling**). All seven
rendered; all genuine, several taken in a shop yard rather than a studio.
⚠ **No studio/white-background photography of the SXW-280 exists anywhere I could reach.** If a
clean cutout is needed the practical route is a supplier request, not the web.
⚠ SAP's 1.1 kW / 220 V / 250–280 r/min agree with the family. SAP's remark dimension
**750×540×820** is closer to the *SXW-200's* 710×355×820 than to the SXW-280's ~1220 mm height —
another sign the two SXW rows have been mixed up somewhere upstream.

### IMG/HOT/00304 — GH-538 · Gas Pasta Cooker · EXACT CODE, non-Astar
Manufacturer: **Guangzhou Jieguan Western Kitchen Equipment Mfg Co., Ltd** (est. 2003, Huadu,
Guangzhou). See §3.3.
Pages: https://gzjieguan.en.made-in-china.com/product/AZkGdaucXEhj/China-Counter-Top-Gas-Noodle-Cooking-Machine-Pasta-Cooker-6-Baskets-Gh-538.html
and https://www.erzoda.com/products/stainless-steel-gasasta-cooker-gh-538-gh-588-37
Images staged: `IMG-HOT-00304__GH-538-jieguan-1.jpg` (**800×800** studio shot, single tank, 6
wooden-handled baskets, one red control knob + piezo igniter + drain tap, Jieguan logo) and
`IMG-HOT-00304__GH-538-jieguan-baskets-detail-2.jpg` (**1851×1389** in-situ top-down of the well
with all six baskets — 2 across × 3 deep, which is exactly what a 400 mm × 650 mm well allows).
Spec: **GH-538 · 400×650×480 mm · LPG · 19,000 BTU · 17.5 kg · stainless 201 · 1 burner.**
Sibling for disambiguation, deliberately **not** staged: **GH-588 = 600×650×480 mm, 34,000 BTU,
25 kg, two tanks.** The two-tank photo on the GH-538 listing is the GH-588 and was rejected.
⚠ SAP L/W/H is `0/0/0`; the real dimensions live only in the remark. They are correct.

### IMG/DIS/00090 — FG-1200LS · Pastry Showcase Square 1200 · PARTIAL
No manufacturer anywhere publishes an `FG-1200LS`. Two independent shape/spec analogues staged:
1. **Astar AL-1200B** — square/right-angle glass, 2 shelves, LED, castors, 1200×680×1200 mm,
   220 V/50 Hz, 350 W, 4–8 °C, fan cooling, R134a.
   `IMG-DIS-00090__AL-1200B-CODEMISMATCH-astarkitchen-1.jpg` (**1079×1102**, clean studio) and
   `…-family-AL-1200B-1500B-1800B-astarkitchen-2.jpg` (**472×449** — a **family** photo serving
   1200B/1500B/1800B, kept only for the dressed/merchandised view; 472×449 is that asset's ceiling).
2. **Inofrigo FCS1200R3M**, sold through UAE dealers — this is the closer **spec** twin:
   **1200×700×1300 mm, 3 shelves, Secop compressor, Dixell controller** — i.e. *every* distinctive
   phrase in SAP's remark ("3 shelves … Secop compressor … Dixell thermostat … 1200*700*1300mm").
   Staged: `IMG-DIS-00090__FCS120R3M-CODEMISMATCH-albaitalhalabi-3.jpg` (**500×500**, below the
   floor; that dealer's media library holds nothing larger). Square glass, 3 shelves, black frame,
   stainless base — visually consistent.
   Source: https://albaitalhalabi.com/product/cake-showcase-fcs1000r3m-gold/ (range page; the
   FCS1200R3M product page at https://mariotstore.com/shop/refrigeration-line/display-chiller/cake-showcase-fcs1200r3m/
   is behind a JS anti-bot challenge and could not be fetched).
**Reading of the dimensions**: SAP's remark **1200×700×1300** = the unit; SAP's L/W/H field
**1200/740/1360** and our record's 1200/740/1360 = the **carton**. Those are consistent, not
conflicting — this is one of the few SKUs where SAP's field and remark can both be right.
⚠ SAP says temp **2–8 °C** and a **heated front glass**; Astar's AL-1200B says 4–8 °C and says
nothing about a heater. Do not copy AL-1200B's electrical spec onto this SKU.

### IMG/FPR/00183 — ASKL-650 · Cutter Mixer · **NOT REACHABLE**
Searched and found nothing under `ASKL-650`, `ASKL 650`, `ASKL`, `KL-650`, "cutter mixer 650 kg/h",
and the SAP remark's own dimensions (600×650×800 mm, 1 kW, 220 V single phase, max 650 kg/h) on
Astar's site (sitemap + product search + the Food Chopper and Food Cutter categories),
Made-in-China's keyword index, and general web search.
Ruled out explicitly:
- **Astar AQ-650 Commercial Food Chopper**
  (https://www.astarkitchen.com/Astar-Commercial-Food-Chopper-AQ-650-pd591958638.html) is a
  tempting code match and is **not** it: 50 L bowl, **1,000 kg/h, 380 V, 2.2 kW, 360 kg**, packing
  1000×795×1085 mm. In the AQ-6xx series the trailing number is the bowl litreage, not throughput.
- **Astar AW-6L/9L/15L Bowl Food Cutter** — litre-coded, largest is 1.8 kW / 550×390×470 mm.
Neither can be reconciled with a 1 kW, 220 V single-phase, 650 kg/h machine at 600×650×800 mm.
**Zero images. This needs supplier paperwork or a photo of the unit on the floor.**

### IMG/HOT/00196 — BC-135L · Tumble Marinator · **NOT REACHABLE**
Searched `BC-135L`, `BC-135`, "tumble marinator 135L", "滚揉机/腌制机 BC-135", Made-in-China's
keyword index (which returns only 135-litre *refrigerators* for that token), and Astar's own
Meat-Salting-Machine category — which is **empty**; Astar's only meat-salting products are the
MS737 / ES737 tenderisers, a different machine type.
SAP's own two statements also disagree with each other: the description field says
**TUMBLE MARINATOR** with L/W/H **953/860/914**, while the remark says **-140L** and the model
says **135L**. 953×860×914 mm is an oddly imperial-looking footprint (≈37.5″×33.9″×36″), which
hints at a US-market machine (AyrKing and Lance Industries both build tumble marinators in that
size class) rather than a Chinese one — but nothing was confirmed and no image was found.
**Zero images.**

---

## 5. Where our data beats SAP, and where SAP beats ours

| SKU | Field | products.json | SAP L/W/H | SAP remark | Manufacturer | Verdict |
|---|---|---|---|---|---|---|
| IMG/FPR/00177 | dims | 265/590/540 | 580/470/370 | 535×270×525 | **590×265×540** | **ours right** |
| IMG/FPR/00180 | dims | 500/380/635 | 370/490/1200 | 690×440×340 | **635×500×380** | **ours right** |
| IMG/FPR/00178 | dims | 535/930/1095 | 0/0/0 | 1100×440×970 | **1095×535×930** | **ours right** |
| IMG/FPR/00181 | dims | 325/450/215 | 370/490/1200 | 750×540×820 | ~760×355×1220 | **SAP field closer** |
| IMG/HOT/00304 | dims | none | 0/0/0 | 400×650×480 | **400×650×480** | **SAP remark right** |
| IMG/DIS/00090 | dims | 1200/740/1360 | 1200/740/1360 | 1200×700×1300 | 1200×700×1300 | both right (carton vs unit) |
| IMG/FPR/00164 | output/power | — | — | 250 kg/h, 0.85 kW | **220 kg/h, 1.1 kW** | **SAP remark wrong** (TD-12 row) |
| IMG/FPR/00177 | power/weight | — | — | 350 W, 19 kg | **1.0 kW, 28 kg** | **SAP remark wrong** |

Four of the five dimension disputes with a manufacturer answer land on our side — consistent with
the dossier's existing "4 of 4" note, now 7 of 8 overall. **Treat SAP's dimension VALUES as the
weakest field in the export.** Its dimension *order* (W, D, H) continues to hold.

---

## 6. Image inventory (all staged in `…\products resorce final\astar\`)

All 15 files below were rendered before acceptance. **None synthetic.**

| File | px | Short edge | ≥800? |
|---|---|---|---|
| IMG-FPR-00164__TK-22-astarkitchen-1.jpg | 2836×2832 | 2832 | yes |
| IMG-FPR-00178__TC-42A-NEARMATCH-astarkitchen-1.png | 800×800 | 800 | at floor (ceiling) |
| IMG-FPR-00177__QC205A-NEARMATCH-astarkitchen-1.png | 800×800 | 800 | at floor (ceiling) |
| IMG-FPR-00177__QC205B-NEARMATCH-astarkitchen-2.png | 800×800 | 800 | at floor (ceiling) |
| IMG-FPR-00184__ASY-130-NEARMATCH-astarkitchen-1.png | 6836×4010 | 4010 | yes |
| IMG-FPR-00180__EV-10L-CODEMISMATCH-astarkitchen-1.jpg | 1500×1500 | 1500 | yes |
| IMG-FPR-00181__SXW-280-dienmaybigstar-1.jpg | 900×1355 | 900 | yes (watermarked) |
| IMG-FPR-00181__SXW-280-maylambanhmi-2.jpg | 900×1197 | 900 | yes (watermarked) |
| IMG-FPR-00181__SXW-280-maylambanhmi-3.jpg | 900×654 | 654 | no (detail shot) |
| IMG-FPR-00181__SXW-280-maylambanhmi-4.jpg | 900×675 | 675 | no (detail shot) |
| IMG-FPR-00181__SXW-280-maylambanhmi-5.jpg | 900×675 | 675 | no (detail shot) |
| IMG-FPR-00181__SXW-280-sieuthihaiminh-6.png | 600×600 | 600 | no (ceiling; unwatermarked) |
| IMG-FPR-00181__SXW-280-sieuthihaiminh-7.png | 600×600 | 600 | no (ceiling; unwatermarked) |
| IMG-HOT-00304__GH-538-jieguan-1.jpg | 800×800 | 800 | at floor (ceiling) |
| IMG-HOT-00304__GH-538-jieguan-baskets-detail-2.jpg | 1851×1389 | 1389 | yes |
| IMG-DIS-00090__AL-1200B-CODEMISMATCH-astarkitchen-1.jpg | 1079×1102 | 1079 | yes |
| IMG-DIS-00090__AL-1200B-CODEMISMATCH-family-AL-1200B-1500B-1800B-astarkitchen-2.jpg | 472×449 | 449 | no (ceiling; FAMILY) |
| IMG-DIS-00090__FCS120R3M-CODEMISMATCH-albaitalhalabi-3.jpg | 500×500 | 500 | no (ceiling) |

**Deleted rather than staged** (contradict the SKU, per the door-type/series rule):
- Astar **AL-1200A** curved-glass cabinet ×2 — the SKU is explicitly square/right-angle.
- Astar **ASGH-988** floor-standing gas pasta cooker with cabinet — a different machine class
  from the exact-code GH-538 countertop unit.
- Jieguan **GH-588** two-tank pasta cooker — sibling model, wrong tank count.
- Libaoda **SXW-200** vertical meatball machine — wrong variant of the right series.

**No spec sheets, manuals or datasheet PDFs exist for any of the 10 SKUs.** Astar publishes none;
Jieguan and Libaoda publish none. Specs above are transcribed from HTML tables.

---

## 7. Model-code recommendations — RECORDED, NOT APPLIED

`model_number` is the tracking ID and is never changed without sign-off.

| SKU | Current | Manufacturer's real code | Confidence |
|---|---|---|---|
| IMG/FPR/00177 | `S-QC205` | **QC205A** or **QC205B** (Astar) | high — variant undecided |
| IMG/FPR/00178 | `TC-42` | **TC-42A** (Astar) | high |
| IMG/FPR/00184 | `130` | **ASY-130** (Astar); "130" = patty ⌀ mm | high |
| IMG/FPR/00180 | `TB-10L` | **EV-10L** (Astar) | high |
| IMG/FPR/00164 | `TK-22` | `TK-22` — already correct | confirmed |
| IMG/FPR/00181 | `SXW-280` | `SXW-280` — correct, but the **brand is Libaoda, not Astar** | confirmed |
| IMG/HOT/00304 | `GH-538` | `GH-538` — correct, but the **brand is Jieguan, not Astar** | confirmed |
| IMG/DIS/00090 | `FG-1200LS` | unresolved; Astar analogue **AL-1200B**, spec twin **Inofrigo FCS1200R3M** | low |
| IMG/FPR/00183 | `ASKL-650` | unresolved | — |
| IMG/HOT/00196 | `BC-135L` | unresolved | — |

**Brand attribution is the bigger issue than the codes.** Two of the ten SKUs filed under ASTAR are
demonstrably other manufacturers' products (Libaoda SXW-280, Jieguan GH-538), which fits the
existing "house-brand label over an OEM machine" pattern.

---

## 8. Open items

- **ASKL-650** and **BC-135L**: genuinely unreachable on the open web. Needs supplier paperwork,
  a rating-plate photo, or the original purchase documentation.
- **IMG/FPR/00177**: decide whether we stock QC205A or QC205B before picking a single image.
- **IMG/HOT/00304**: reconcile the exact-code Jieguan countertop unit against the archived note
  that the shipped unit looks floor-standing. One of the two is wrong and only a site visit settles it.
- **IMG/FPR/00181**: `products.json`'s 325/450/215 should not survive contact with the photographs.
- **IMG/FPR/00184**: our 450/350/370 matches neither machine nor carton — measure it.
- **IMG/FPR/00164**: SAP's 250 kg/h + 0.85 kW is the TD-12 row, not the TD-22/TK-22 row.
