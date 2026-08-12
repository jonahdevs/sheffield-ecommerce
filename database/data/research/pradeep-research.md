# Pradeep - product research (SAP-led pass, July 2026)

**This file supersedes the archived research below.** That file was
written before the SAP export existed, leaned on `sheffieldafrica.com` (our own storefront)
for several claims, and left four questions open. Every claim below was re-derived from
scratch; nothing in the old file was carried forward on trust. Where the old file's
conclusions survive, that is said explicitly; where they do not, the correction is recorded.

Scope: all **13 PRADEEP SKUs** in `products.json`. They sit in three variable-parent groups
plus three standalone products, so **10 of the 13 are variant children** that no earlier
image pass ever touched:

| group / product | parent SKU | children |
|---|---|---|
| Milk Boiler with Indirect Water Heating Jacket | IMG/COF/00023 | 00023, 00024, 00025 |
| Non Heated Insulated Catering Urn/Thermos | IMG/COF/00029 | 00029, 00030, 00031 |
| Electric Catering Urn (Water Boiler) | IMG/COF/00112 | 00112, 00113, 00114, 00115 |
| Heated Insulated Water Urn 36 Litres | IMG/COF/00032 | - |
| Coffee Brewer with Coffee Filter | IMG/COF/00033 | - |
| Coffee Filter with Heater Plate 5 Ltr | IMG/COF/00111 | - |

Staged material lives in `Desktop\ecommerce\products resorce final\pradeep\`
(58 per-SKU image files = 23 distinct photographs, 5 spec/catalogue PDFs, 5 rendered
catalogue/brochure spec pages). `_staged.json` in that folder maps every file to its URL
and md5. **No repo data file was modified by this pass.**

---

## 1. The single most important find: an official Pradeep catalogue PDF

Pradeep's own IndiaMart storefront attaches a "Product Brochure" to most listings. Every
one of those buttons serves one of only **two** documents (proved by md5 - eight different
listings, one file). Both were downloaded and read page by page:

- **Pradeep Stainless India master catalogue, 24 pp** -
  https://5.imimg.com/data5/SELLER/Doc/2024/12/476263524/UX/ZB/AI/4776252/tea-and-coffee-can.pdf
  (staged as `_PRADEEP-master-catalogue-spec.pdf`)
- **Pradeep iBrew combo brochure, 8 pp** -
  https://5.imimg.com/data5/SELLER/Doc/2024/12/476243439/IY/QH/IZ/4776252/pradeep-insulated-milk-boiler.pdf
  (staged as `_PRADEEP-ibrew-combo-brochure-spec.pdf`)

Four catalogue pages and one brochure page carry item-number/capacity tables for our exact
products; they are staged as PNG renders (`_PRADEEP-catalogue-p18/p19/p20/p21…`,
`_PRADEEP-ibrew-brochure-p2…`). These are the strongest sources in this pass - manufacturer
tables with item numbers, capacities, carton CBM and electrical specs on one page.

Catalogue p19 (BEVERAGE EQUIPMENT - Water Boiler / Insulated Water Boiler) is decisive
because it prints a **gallon column next to the litre column**:

| Water Boiler (non-insulated) | gal | L | | Insulated Water Boiler | gal | L |
|---|---|---|---|---|---|---|
| 111101 | 1 | 4.50 | | 111201 | 1 | 4.50 |
| 111102 | 2 | 9.00 | | 111202 | 2 | 9.00 |
| 111104 | 4 | 18.00 | | 111204 | 4 | 18.00 |
| 111106 | 6 | 27.00 | | 111206 | 6 | 27.00 |
| 111109 | 9 | **40.00** | | 111209 | 9 | **40.00** |

Both families: 220-240 V AC, 15 A single phase, **3000 W**, manual fill.

---

## 2. What was verified, per SKU

Every staged image was opened and looked at, not just fetched. Every accepted image shows
either the PRADEEP embossed logo or the iBrew watermark, and the feature set (number of
taps, presence/absence of thermostat and indicator lamps, insulated vs plain body) was
checked against the SKU's own description before keeping it.

| SKU | SAP model | verdict | evidence |
|---|---|---|---|
| IMG/COF/00023 | 9228/12 | family + capacity confirmed; **code partly disputed inside SAP** | §3.1 |
| IMG/COF/00024 | 7228/20 | **SAP model wrong** - should be 9228/20 | §3.1 |
| IMG/COF/00025 | 7228/30 | **SAP model wrong** - should be 9228/30 | §3.1 |
| IMG/COF/00029 | 7217/16 | confirmed exactly, 3 independent sources | §3.2 |
| IMG/COF/00030 | 7217/20 | confirmed exactly | §3.2 |
| IMG/COF/00031 | 7217/30 | confirmed exactly | §3.2 |
| IMG/COF/00032 | 111200/9G | model family confirmed = 111209; **SAP capacity wrong (36 L -> 40 L)** | §3.3 |
| IMG/COF/00033 | 9230 | **wrong product entirely** - 9230 is a non-electric milk boiler; this SKU is 111503 | §3.4 |
| IMG/COF/00111 | 111504 | confirmed exactly (3 sources) | §3.5 |
| IMG/COF/00112 | 111100/2G | = 111102, 9 L, 3000 W; **SAP wattage wrong** | §3.6 |
| IMG/COF/00113 | 111100/4G | = 111104, 18 L, 3000 W; **SAP wattage wrong** | §3.6 |
| IMG/COF/00114 | 111100/6G | = 111106, 27 L, 3000 W; **SAP wattage wrong** | §3.6 |
| IMG/COF/00115 | 111100/9G | = 111109, 40 L, 3000 W; **SAP wattage wrong** | §3.6 |

---

## 3. Findings and SAP disagreements

### 3.1 The 9228 vs 7228 milk-boiler prefix - the old pass changed it the wrong way

SAP is **internally inconsistent inside one family**: `IMG/COF/00023` carries `9228/12`
while `IMG/COF/00024` and `IMG/COF/00025` carry `7228/20` and `7228/30`. `products.json`
currently holds `7228/12`, `7228/20`, `7228/30` on the three variants - the old research
file (§8.1/§8.4) records that the business decided to renumber the family from `92xx` to
`72xx` because 72xx "matched the prefix already used by 7217 and 7229".

That reasoning does not hold. Pradeep genuinely uses **both** prefixes in the same
catalogue: `7217` (catering urn) and `7229x` (cookware) alongside `9227C` (cold dispenser),
`9227HC` (beverage dispenser), `9227M` (milk can), `9230` (non-electric boiler) and `9232`
(insulated food container) - see
https://pradeepstainless.com/horeca-buffet-chafing-dish/milk-can/ and
https://pradeepstainless.com/horeca-buffet-chafing-dish/beverage-dispenser/ .
A `72xx`-style code is not more "correct" for a milk boiler than a `92xx` one.

An independent Chennai Pradeep distributor (R. R. Agencies, no relationship to Sheffield)
publishes the family table under **9228**, with our exact capacities:

https://www.rragencies.co.in/pradeep-milk-boiler.html

    ITEM No.  Capacity (Lt)  Pcs/Ctn  CBM
    9228/5      5.00           1      0.054
    9228/12    12.00           1      0.083
    9228/20    20.00           1      0.106
    9228/30    30.00           1      0.131

`7228` appears **nowhere** outside our own records. So: SAP's `9228/12` is right, SAP's
`7228/20` and `7228/30` are wrong, and the `products.json` values (`7228/12/20/30`) are all
wrong. **Recommended (not applied): 9228/12, 9228/20, 9228/30.**

Bonus from the same table: those CBM figures are identical to the master catalogue's
**non-insulated** Milk Boiler line (111300 = 0.054, 111312 = 0.083, 111320 = 0.107,
111330 = 0.131) and clearly different from the **insulated** line (111600 = 0.062,
111612 = 0.091, 111620 = 0.113, 111630 = 0.139) - see catalogue p20. So `9228/xx` is the
legacy code for the plain water-jacketed Milk Boiler, not the PUF-insulated one. Our copy
("indirect water heating jacket", "double layered", "double taps", "fixed element") fits
that: the jacket is the double wall, and both taps (hot milk + hot water) are visible on
every accepted photo. **Open point:** the R. R. Agencies blurb around the table calls it
an "Insulated Hot Liquid Dispenser", contradicting its own CBM figures - so insulated vs
non-insulated is corroborated only by the CBM arithmetic, not stated anywhere in words.

### 3.2 7217 catering urn - clean, three-way confirmation

The only completely undisputed SKUs in the brand. Item numbers and capacities match
exactly across three sources with different lineages:

- manufacturer web catalogue: https://pradeepstainless.com/stainless-steel-food-storage-drums/catering-urn/
- manufacturer IndiaMart storefront ("Tea And Coffee Can"): https://www.indiamart.com/pradeep-stainless-india/tea-and-coffee-brewer.html
- master catalogue p18 (BUFFET WARE, "Tea/Coffee URN"), staged as `_PRADEEP-catalogue-p18-tea-coffee-urn-7217.png`
- an independent distributor price list: https://www.indiamart.com/graceinc/pradeep-water-boiler.html (PDF, "GINC/7217/16 TEA & COFFEE URN 16 L" etc.)

7217/16 = 16 L, 7217/20 = 20 L, 7217/30 = 30 L. Catalogue wording is
"Wide open mouth - easy to clean / **PUF insulation for longer heat retention** / heavy duty
tap for drip-free dispensing", with **no electrical spec at all** - which vindicates the old
file's §4.3 fix (the phantom 2800-3000 W row on these three non-heated urns was indeed wrong).

### 3.3 IMG/COF/00032 - SAP's 36 L is wrong; it is 40 L. The three-year-old open question is closed.

SAP model `111200/9G`, description "HEATED INSULATED WATER URN 9GALLON - 36 LITRES".

`111200/xG` is Sheffield's own hybrid notation; the real item numbers are 111201/111202/
111204/111206/**111209**. Three independent sources all map 9 gallon to **40 L** in this family:

- master catalogue p19 (gallon column printed next to litre column): 111209 = 9 gal = 40.00 L
- https://www.indiamart.com/pradeep-stainless-india/hot-water-boiler.html - "Insulated Hot Water Boiler ... 111209 / 40"
- Grace Inc price list PDF: "GINC/111209 HOT LIQUIDS BOILERS 9 GALLON - INSULATED 40 L"

SAP itself agrees when you read its other row: `IMG/COF/00115` is `111100/9G`,
"ELECTRIC CATERING URN 9 GALLON **40 LTR**". Same 9G suffix, same manufacturer family
structure, different litre figure - SAP contradicts itself, and 40 L wins 3-1.
There is no 36 L size anywhere in Pradeep's range, current or legacy.

**Recommended (not applied):** model `9G` -> `111209` (or keep SAP's `111200/9G` notation),
capacity 36 L -> 40 L, and rename "Heated Insulated Water Urn 36 Litres" accordingly. The
old file's §8.3 lead (`7227/9G` = 40 L) is still unsubstantiated and should be dropped -
but its *conclusion* (40 L, not 36) turns out to have been right for the wrong reason.

Also worth knowing: SAP contains three more rows of this same family -
`IMG/COF/00143` = 111200/2G, `IMG/COF/00144` = 111200/4G, `IMG/COF/00145` = 111200/6G -
that have **no record in `products.json` at all**. So the 9 L / 18 L / 27 L insulated urns
are stocked but not catalogued.

### 3.4 IMG/COF/00033 - the model number belongs to a different product

SAP: model `9230`, "COFFEE BREWER WITH COFFEE FILTER PRADEEP", remark
"Insulated Coffee Brewer with coffee filter plus heater: Capacity 3 litres. Heating power 800 W."

**`9230` is not a coffee brewer.** Three independent sources agree it is a non-electric
milk/liquid boiler in 5 L and 10 L only:

- manufacturer's own IndiaMart storefront, product "Pradeep Milk Boiler (Non Electric)",
  Machine Type Manual: `9230/5` = 5 L, `9230/10` = 10 L -
  https://www.indiamart.com/pradeep-stainless-india/milk-boiler-machine.html
- https://www.rragencies.co.in/pradeep-milk-boiler.html - same table, same two sizes
- Grace Inc price list: "GINC/9230/5 INDUCTION & GAS BOILER 5 L", "GINC/9230/10 ... 10 L"

The staged photos `IMG-COF-00033__9230-source-1/2.jpg` show exactly that: a two-tap
stainless boiler with **no thermostat, no indicator lamps and no cord**.

Meanwhile the product SAP actually describes - a 3 litre insulated coffee brewer with a
filter and an **800 W** heater - is Pradeep's **`111503` Coffee Filter with Warmer Plate**:

- master catalogue p21: "Coffee Filter with Warmer Plate - 111503 = 3.00 L, 111504 = 5.00 L,
  Electrical Specification: 220-240v AC, 15A (Single phase), **800W**"
- Grace Inc datasheet "Commercial Coffee Maker - Pradeep & iBrew Brand":
  111503 = 3 Litres, 111504 = 5 Litres, Power Consumption **800 Watts**, 230 V AC 50 Hz, 15 A -
  https://5.imimg.com/data5/SELLER/Doc/2025/10/554581392/OY/SV/HQ/87759684/south-indian-filter-coffee-maker.pdf
- https://www.indiamart.com/proddetail/south-indian-filter-coffee-maker-21436365588.html -
  "Model Name/Number 111503, Capacity 3" plus the 111503/111504 table

The 800 W in SAP's remark is exact and is not something anyone would invent - it is the
manufacturer's published figure for 111503. **Recommended (not applied): `9230` -> `111503`**
(a `model_number` change needs approval per the model-number rule). Photos of the real
111503 are staged as `IMG-COF-00033__111503-source-3/4/5`; the `9230` photos are kept
alongside, clearly named, as the evidence for the swap - **do not use them as the product
image.**

Note the old file's §8.2 reached the same "9230 is probably 111503" conclusion from two
IndiaMart listings. Both of those URLs are now **404** (see §5), so the finding has been
re-established from live sources.

### 3.5 IMG/COF/00111 - correct, and now fully sourced

`111504` = Coffee Filter with Warmer Plate, **5 L storage**, 400 gm coffee / 2 L water per
brew, manual fill, black coffee (decoction), 220-240 V, 800 W. Confirmed on master
catalogue p21, the iBrew brochure p2, and the Grace Inc datasheet above. SAP's description
"COFFEE FILTER WITH HEATER PLATE 5 LTR" is accurate. This SKU is still `draft` in
`products.json`; there is now enough to publish it.

Structural cross-check that makes the code safe: the tea equivalents are `111505` (3 L) and
`111506` (5 L), printed side by side with the coffee pair on the same catalogue page.

### 3.6 IMG/COF/00112-00115 - capacities right, wattage wrong

SAP's models `111100/2G,4G,6G,9G` map cleanly onto `111102`/`111104`/`111106`/`111109` and
SAP's litre figures (9 / 18 / 27 / 40) match the catalogue exactly. `products.json` already
holds the right item numbers.

**But every one of the four SAP remarks says "Power input: 1500-2500 W".** The manufacturer
publishes **3000 W** for the whole family, in four places:
master catalogue p19; https://pradeepibrew.com/products/electric-hot-water-machine/ ;
https://www.indiamart.com/pradeep-stainless-india/beverage-equipment.html ("Non Insulated
Water Boiler ... Power 3000W"); and the Grace Inc "Hot Water Boiler" datasheet
(https://5.imimg.com/data5/SELLER/Doc/2024/10/457788819/ZA/GQ/CO/87759684/pradeep-water-boiler.pdf -
"Power Consumption 3000 W, 220-240V AC, 15Hz, 15A, auto cut-off, reset thermostat").

The whole `111100/xG` range is **out of stock in SAP** (0.0 on all four), which is expected
and not an error.

---

## 4. Brand-level rules learned (use these on any future Pradeep work)

1. **Axis order is W x H x D.** The master catalogue labels every dimension triple
   `WxHxD(mm)`, and so does Pradeep's IndiaMart storefront. `pradeepibrew.com` labels the
   *same numbers* `LxWxH` - e.g. model 111556 is `450x605x435` on both, called WxHxD on one
   site and LxWxH on the other. 605 is obviously the height, so **WxHxD is the true order
   and pradeepibrew's label is wrong.** Never copy an axis label from pradeepibrew.
2. **Two-number dimensions are Height x Diameter.** The iBrew brochure prints the insulated
   milk boiler as `Height/Dia(mm)`: 111600 = 470x280, 111612 = 580x320, 111620 = 550x380,
   111630 = 670x390. (Yes, the 20 L is *shorter and wider* than the 12 L - that is what the
   manufacturer publishes.)
3. **Pradeep contradicts itself on wattage.** Coffee Filter with Warmer Plate is **800 W** in
   the master catalogue and in the Grace Inc datasheet, but **2.4 kW** on the iBrew brochure
   page for the same 111503/111504. Two-to-one for 800 W. Similarly the Tea Brewer 111513 is
   `260x500x430` on IndiaMart and `260x300x450` in the brochure. Treat any single Pradeep
   dimension or wattage as one vote, not a fact.
4. **Legacy vs current numbering.** Old stainless-catalogue codes (`7217`, `9227x`, `9228`,
   `9230`, `9232`, `7229x`) coexist with the new six-digit iBrew-era codes (`1113xx`,
   `1115xx`, `1116xx`, `1111xx`, `1112xx`). Distributors quote whichever they were given.
   Matching by **capacity + carton CBM** is far more reliable than matching by code.
5. **SAP's `NNNN00/xG` notation is Sheffield-local.** `111100/2G` and `111200/9G` are not
   manufacturer part numbers; they encode family + gallon size. The real item numbers are
   `111102`, `111209`, etc.

---

## 5. Dead ends - do not retry these

- https://www.indiamart.com/proddetail/pradeep-filter-coffee-machine-3-liter-21746553033.html - **404**
- https://www.indiamart.com/proddetail/pradeep-coffee-filter-machine-21601575991.html - **404**
  (both were the old file's §8.2 evidence for 111503 = 800 W; that claim has been
  re-sourced from live pages, see §3.4)
- https://www.pradeepibrew.com/product/stainless-steel-insulated-hot-water-dispensers/ - 404 (unchanged since the old pass)
- https://velanstore.com/product/pradeep-insulated-hot-water-dispenser/ - 404 (unchanged)
- Searching for the literal string `7228` returns nothing anywhere on the web. It is our own invention.
- Searching for `9228` returns exactly two kinds of hit: R. R. Agencies (§3.1) and
  `sheffieldafrica.com` - which is our own storefront and never counts as a source.
- `pradeepibrew.com` has **no** page for the insulated hot-water dispenser (111200) and no
  spec table for the milk boilers beyond the model list; its product sitemap has 26 URLs and
  two of them (`premium-coffee-brewer-filter-coffee-maker-2` / `-3`) return empty bodies.
- IndiaMart "Product Brochure" buttons on Pradeep's own storefront are **not** per-product
  datasheets - all eight resolve to one of the two catalogue PDFs in §1 (verified by md5).
  Only third-party sellers (Grace Inc) attach genuine per-product sheets.

## 6. Images: what was rejected and why

Fetching succeeded on more images than were kept. Rejected after visual inspection:

| rejected | reason |
|---|---|
| `data5/EY/YR/MY-31444973/pradeep-milk-boiler-500x500.jpg` | lead photo on the 9228 listing, but it is an **unbranded single-tap water urn** - our SKU is a double-tap jacketed milk boiler |
| `data5/SELLER/Default/2023/2/IN/QA/PX/4776252/tea-and-coffee-can-500x500.jpg` | **byte-identical** to the other "tea-and-coffee-can" file on the same page - one sighting, not two |
| `pradeepibrew.com/.../Picture1__1_-removebg-preview.png` | an automatic filter-coffee vending machine (111570 class), not the manual 111504 |
| `data5/XI/HK/RU/SELLER-4776252/tea-brewer-with-warmer-plate-500x500.jpg` (+ its 2026 re-shoot) | the **TEA** Filter with Warmer Plate (111505/111506) - four handles and two indicator lamps, visibly not the coffee model |
| `pradeepibrew.com/.../coffee-filter-machine-500x500-1.webp` | an unidentifiable iBrew pot; no warmer plate, tap or model visible |
| `pradeepibrew.com/.../Pradeep-Image-Hot-Water-Dispenser-product.png` | a black countertop automatic dispenser (111550 class), not the 111100 catering urn - it was on the 111100 page anyway |
| `data5/XZ/KI/TF/SELLER-87759684/pradeep-water-boiler-1000x1000.jpg` | Grace Inc sells both insulated and non-insulated under one listing; this shot is the *insulated* body, so it cannot be pinned to 00113 |

Also noted: `non-insulated-water-boiler-500x500.jpg` (2026/4/599954741 and .../599954746) are
two renders of the **same** photograph, and the 500x500 -> 1000x1000 upgrade on imimg.com is a
real re-render for `data5/SELLER/Default/...` paths but a no-op for older `data5/XX/YY/ZZ/SELLER-…`
paths. 58 staged files reduce to **23 distinct photographs**; that is by design (each family
photo is staged once per SKU in the group), not accidental duplication.

---

## 7. Still open

1. **`9228` vs `7228`** - `9228` has one genuinely independent attestation (R. R. Agencies)
   plus SAP's own 12 L row. That is enough to say `7228` is wrong, not quite enough to call
   `9228` proven. A supplier invoice or Pradeep's own reply would settle it.
2. **Insulated or not?** The 9228 family's CBM figures match the *non*-insulated 111300 line,
   but our copy says "double layered" and one distributor calls it insulated. Deciding this
   changes which current model (111312/111320/111330 vs 111612/111620/111630) our stock maps to.
3. **Dimensions** - SAP holds 0/0/0 for all 13 SKUs and `products.json` holds null. The only
   published dimensions for anything in our set are the insulated milk boiler's
   Height x Diameter pairs (§4.2), which apply only if question 2 resolves to "insulated".
   Nothing was invented; all 13 remain dimensionless.
4. **Eight PRADEEP rows in SAP have no catalogue record**: `IMG/COF/00143`, `IMG/COF/00144`,
   `IMG/COF/00145` (insulated water urns 2G/4G/6G), `IMG/HOT/00423` (corn steamer 4 L,
   model 220305 - confirmed as "GINC/220305 ELECTRICAL STEAMER 4 L" on the Grace Inc price
   list), and `IMG/TCW/00026`, `IMG/TCW/00038`, `IMG/TCW/00040`, `IMG/TCW/00948` (7229M
   casseroles and a 7232 frypan). Worth deciding whether to add them.
5. **A SAP defect outside our 13, spotted in passing**: `IMG/TCW/00026` (`7229M/93`) and
   `IMG/TCW/00040` (`7229M/50`) both carry the description "D 50 X H 27 CM" but 93.0 L vs
   53.0 L. Pradeep's own 7229M range is sized by diameter (20-60 cm), so at least one of
   those two rows is a copy-paste.

---

## 8. Source index (all bare URLs, all opened this pass)

Manufacturer:
- https://pradeepstainless.com/stainless-steel-food-storage-drums/catering-urn/
- https://pradeepstainless.com/horeca-buffet-chafing-dish/milk-can/
- https://pradeepstainless.com/horeca-buffet-chafing-dish/beverage-dispenser/
- https://pradeepstainless.com/horeca-buffet-chafing-dish/cold-dispenser/
- https://pradeepstainless.com/stainless-steel-food-storage-drums/insulated-carrying-pot/
- https://pradeepibrew.com/products/electric-hot-water-machine/
- https://pradeepibrew.com/products/insulated-milk-boiler-machines/
- https://pradeepibrew.com/products/non-insulated-pradeep-milk-boiler/
- https://pradeepibrew.com/products/coffee-fiter-with-warmer-plate/
- https://pradeepibrew.com/products/premium-coffee-brewer-filter-coffee-maker/

Manufacturer's own IndiaMart storefront (seller 4776252):
- https://www.indiamart.com/pradeep-stainless-india/
- https://www.indiamart.com/pradeep-stainless-india/beverage-equipment.html
- https://www.indiamart.com/pradeep-stainless-india/hot-water-boiler.html
- https://www.indiamart.com/pradeep-stainless-india/milk-boiler-machine.html
- https://www.indiamart.com/pradeep-stainless-india/tea-and-coffee-brewer.html

Independent distributors:
- https://www.rragencies.co.in/pradeep-milk-boiler.html
- https://www.indiamart.com/graceinc/pradeep-water-boiler.html
- https://www.indiamart.com/graceinc/coffee-machine.html
- https://www.indiamart.com/proddetail/south-indian-filter-coffee-maker-21436365588.html
- https://www.dineshindustriess.com/milk-boilers.html

Spec PDFs staged in the brand folder:
- https://5.imimg.com/data5/SELLER/Doc/2024/12/476263524/UX/ZB/AI/4776252/tea-and-coffee-can.pdf
- https://5.imimg.com/data5/SELLER/Doc/2024/12/476243439/IY/QH/IZ/4776252/pradeep-insulated-milk-boiler.pdf
- https://5.imimg.com/data5/SELLER/Doc/2025/10/554581392/OY/SV/HQ/87759684/south-indian-filter-coffee-maker.pdf
- https://5.imimg.com/data5/SELLER/Doc/2024/10/457788819/ZA/GQ/CO/87759684/pradeep-water-boiler.pdf
- https://5.imimg.com/data5/SELLER/Doc/2023/1/EA/YW/PI/87759684/pradeep-brand-18-liter-hot-water-dispenser.pdf

Not a source, by policy: `sheffieldafrica.com` - our own storefront.

---

# 9. Spec-sheet sweep (2026-08-01, second pass)

The image pass above was complete and three per-SKU spec PDFs existed; the spec-sheet phase
proper had never run. It has now. **13 / 13 SKUs carry a spec document, 10 of them for the
first time.** Full detail is in
`Desktop\ecommerce\products resorce final\pradeep\_FINDINGS-specs.md`; the ledger is
`_specs-sourced.json` in the same folder. Nothing in the repo was modified and no previously
staged file was overwritten.

## 9.1 A datasheet for the milk boilers — the family's first ever

https://5.imimg.com/data5/SELLER/Doc/2023/2/SW/KE/GQ/87759684/pradeep-brand-electrical-milk-boiler-capacity-5-12-20-30-liters-.pdf

Grace Inc / Pradeep, *"Electrical Milk Boiler (Capacity 5, 12, 20, 30 Liters)"*, 7 pp — a full
per-size technical table for **both** lines. Staged as
`_PRADEEP-graceinc-milk-boiler-datasheet-spec.pdf` with its two spec pages rendered as PNG.
This lands on 00023 / 00024 / 00025, which had nothing.

| | 5 L | 12 L | 20 L | 30 L |
|---|---|---|---|---|
| Non-insulated | 111300 | 111312 | 111320 | 111330 |
| Insulated | 111600 | 111612 | 111620 | 111630 |
| Power | **2400 W** | **3000 W** | **3000 W** | **3000 W** |

220-240 V AC, 15 Hz, 15 A single phase · manual fill and cleaning · **2 output options** ·
thermostat · **auto cut-off at 90 °C** · power, boiling and water-level indicators · hot water.
Insulated line adds *"inner container with an active temperature control, insulated with CFC-
and HCFC-free Polyurethane Foam (PUF)"*.

Consequences for §3.1 and §7.2:

- **SAP's "2800 - 3000W" is right** for our three sizes. New contradiction found in the
  opposite direction: R. R. Agencies and Mahesh Kitchen Equipment both say "Power Consumption
  2400 Watts" in prose — that is the **5 L** figure quoted across the whole range.
- **§7.2 (insulated or not) is still open.** The datasheet covers both lines with identical
  feature tables, so it cannot discriminate. The CBM arithmetic in §3.1 remains the only
  evidence, and it still points at the non-insulated 111300 line.
- **§7.1 (`9228` vs `7228`) does not move.** `7228` still returns nothing anywhere. `9228`
  still has only the R. R. Agencies table — and a second storefront was found publishing it,
  https://www.maheshkitchenequipment.com/pradeep-ibrew-milk-boiler-liquid-machine.html
  (Bengaluru), but with **identical rows and identical CBM figures**, so it is one manufacturer
  price list surfacing twice, not a second independent attestation. Still "enough to say 7228
  is wrong, not enough to call 9228 proven".

## 9.2 Correction: the master-catalogue page numbers in §1 and §3 are printed pages, not PDF pages

The rendered PNGs are named by printed page number and this file cites those. Opening
`_PRADEEP-master-catalogue-spec.pdf`, everything is **one page higher**:

| Content | printed p. (as cited above) | **PDF page** |
|---|---|---|
| Tea/Coffee URN — 7217 | 18 | **19** |
| Water Boiler / Insulated Water Boiler | 19 | **20** |
| Milk Boiler / Insulated Milk Boiler | 20 | **21** |
| Tea / Coffee Filter with Warmer Plate | 21 | **22** |

PDF p18 is Food Warmer / Conveyor Toaster — a different product, so this off-by-one would have
attached the wrong page to three SKUs. The new ledger uses PDF page numbers throughout.

Also worth recording: the master catalogue and the iBrew brochure are **image-only PDFs with no
text layer**. No code in them can be grep-proven; every row cited was read by rendering the page.

## 9.3 §3.4 strengthened — the 800 W now has a structural explanation

§4.3 recorded that the iBrew brochure gives 2.4 kW for 111503/111504 against 800 W in the
master catalogue. Catalogue p22 (PDF) prints **both** figures on one page: **800 W under
"Coffee Filter with Warmer Plate" (111503/111504)** and **2400 W under "Tea Filter with Warmer
Plate" (111505/111506)**. The brochure looks to have attached the tea figure to the coffee
model. 800 W stands, and it is the figure in SAP's own remark for IMG/COF/00033.

The spec file built for 00033 carries the 111503 datasheet *and*, on the Grace Inc price-list
page bound into it, the rows `GINC/9230/5 INDUCTION & GAS BOILER 5 L` / `GINC/9230/10 … 10 L` —
so a single PDF supplies the right spec sheet and documents the model-number mismatch.
`code_proven` is recorded false for that SKU on purpose.

## 9.4 §3.3 confirmed from the document, not just the reading

Catalogue p20 (PDF), Insulated Water Boiler table: `111209 · 9 gallon · **40.00 Lt** · CBM
0.129 · 1 pc/ctn`, with `220-240 v AC, 15A (Single phase), 3000W` in the page footer. The Grace
Inc price list agrees: `GINC/111209 HOT LIQUIDS BOILERS 9 GALLON - INSULATED 40 L`. **SAP's
36 L is wrong**, as §3.3 concluded. Not applied.

## 9.5 §3.6 confirmed on all four

Catalogue p20 and the Grace Inc "Hot Water Boiler" datasheet both publish **3000 W** for the
whole 111100 family, against SAP's `1500-2500 W` on 00112, 00113, 00114 and 00115. Not applied.

## 9.6 §3.2 gets its positive proof

Catalogue p19 (PDF) carries the 7217 table (16.00 / 20.00 / 30.00 Lt, CBM 0.053 / 0.063 / 0.085)
and — importantly — **no electrical specification anywhere on the page**, unlike every other
BEVERAGE EQUIPMENT page in the catalogue, which prints a wattage bar. That absence is the
positive evidence that these three urns are genuinely non-heated, and it retroactively
vindicates deleting the phantom 2800-3000 W row.

## 9.7 Two of the three pre-existing spec files are weaker than their filenames suggest

Left untouched as instructed, but flagged in the ledger:

- `IMG-COF-00112__111100-2G-spec.pdf` — the Grace Inc "Hot Water Boiler" 2-pager names **no
  item number at all**; it only says "Litres 4.5, 9, 18, 27, 40". It could not prove a code by
  itself. A composite file that binds catalogue p20 in was added alongside it.
- `IMG-COF-00113__111100-4G-spec.pdf` — despite its name and its source URL
  (`pradeep-brand-18-liter-hot-water-dispenser.pdf`), this is **not a datasheet**: it is the
  3-page **Grace Inc Pradeep price list**, a model/description/price index covering
  111300-111630, 9230/5-10, 111503/111504, 111101-111209 and 7217/6-7217/35. As a
  cross-reference it is excellent — it is bound into most of the new spec files, and it is
  where §3.4's `9230 = induction/gas boiler` and §3.2's `GINC/7217/16` rows actually live — but
  it is not a spec sheet for anything.
- `IMG-COF-00111__111504-spec.pdf` is genuinely good: it prints its own item number and gives
  the **only published dimensions for any SKU in this brand** — 111503 = 40 x 25 x 25 cm /
  4.5 kg, 111504 = 45 x 28 x 28 cm / 6 kg. §7.3 ("all 13 remain dimensionless") should be
  narrowed to eleven.

## 9.8 New dead end

IndiaMart's on-demand brochure generator `pdf.indiamart.com/impdf/<id>/<seller>/<slug>.pdf`
is **gated**: four different URLs, browser user-agent and correct referer, all return a ~7 KB
HTML shell instead of a PDF. So the distributor listings that carry the `9228` table cannot be
captured as documents at all — which is why that table is transcribed into
`_FINDINGS-specs.md` rather than attached. No search outage occurred during this pass; the
four unproven codes are unproven because the documents do not exist.

---

## Archived brand research

> Merged in from the former `research/old/` folder on 2026-08-12, when the two folders were
> consolidated. This is the earlier **specs and codes** pass; everything above it
> is the later **sourcing and provenance** pass. The text is unchanged apart from
> heading levels, which were demoted one step to keep a single outline.

## Pradeep Product Research

Research notes behind the PRADEEP enrichment pass on `products.json` (July 2026). Covers
all 13 PRADEEP SKUs: 3 indirect-jacket milk boilers (9228 series), 3 non-heated insulated
catering urns/thermoses (7217 series), 4 electric hot-water catering urns (111100 series),
1 heated insulated water urn (7227/9G), and 1 filter-coffee brewer (9230).

**Caution: `sheffieldafrica.com` is NOT an independent source for this brand — it is
Sheffield Africa's own live storefront**, the same Kenyan business this catalogue belongs
to (see [[reference_sheffield_africa_company]]), and very likely the original source of
the erroneous `products.json` data this whole research effort exists to correct. 10 of the
13 SKUs are still listed there today under sequential product IDs 354&ndash;361, and early
in this pass they were used as a "confirmation" source — that was circular for anything
beyond a plain internal-consistency check, since it just re-confirms whatever Sheffield
already has (bugs included). **Corrected after review**: two pieces of data that had *no*
source except Sheffield's own site (`model_number` "7227/9G" for the 36L heated urn, and an
800W rating for the 9230 brewer) were reverted since they could not be independently
verified — see §4.4/§4.5. Everything else in this file is corroborated by a genuinely
external source: `pradeepibrew.com`/`pradeepstainless.com` (official manufacturer sites),
independent Indian distributors (velanstore.com, indiamart.com), or is a self-evident
internal-consistency fix that needed no external source at all (a product's own
description contradicting its own name/model).

**This pass found and fixed three copy-paste data bugs** (wrong capacity/model text and a
phantom power rating bleeding from one SKU's fields into another's) and filled in missing
description/spec/meta content across most SKUs. **`model_number` was changed on one SKU**
(filling a previously-`null` field, confirmed independently) — see
[[feedback_model_number_unique_id]] and §4.4.

---

### 1. Brand identification

**Pradeep** (Pradeep Stainless India), a Chennai-based manufacturer with **35+ years** in
catering/HORECA equipment, exporting kitchenware to 10+ countries. Its beverage-equipment
line trades under the sub-brand **"iBrew" / "Pradeep iBrew"** (`pradeepibrew.com`) —
milk boilers, hot water boilers/urns, filter-coffee and Indian chai brewing equipment —
separate from the main `pradeepstainless.com` site, which covers hotpots, cookware,
buffet ware and stainless food-storage drums.

---

### 2. Where to look — and the traps

| Resource | URL | Value |
|---|---|---|
| Official beverage-equipment site | `pradeepibrew.com` (product-category pages: `milk-boiler-warmer`, `hot-water-dispensers`, `filter-coffee-machines`) | **Best independent source** — official model tables, no images/dimensions |
| Official manufacturer site (non-beverage lines + one matching table) | `pradeepstainless.com` | Confirmed the 7217 series table exactly |
| Distributor mirrors (India) | velanstore.com, indiamart.com listings | Independent — useful for gap-filling model numbers not on either official site |
| Sheffield Africa's own live catalogue | `sheffieldafrica.com/kitchen/product/{354–361}/...` | **Not independent** — this is the business's own storefront and likely the origin of the errors this pass is meant to catch. Do not use it to "confirm" a fix; only useful as a plain reference for what's currently live |

#### Traps

1. **Two separate, similarly-numbered "urn" product families — don't conflate them.**
   - **7217 series** = non-heated, vacuum/PUF-insulated **thermos** urns (no element, no
     plug) — our 16L/20L/30L SKUs. Confirmed verbatim on `pradeepstainless.com`'s own
     catalogue table (7217/6 through 7217/35).
   - **111100 series** = **electric** hot-water boilers with a heating element — our 9L/
     18L/27L/40L SKUs (`111102`/`111104`/`111106`/`111109`). Confirmed on `pradeepibrew.com`.
   Similar "catering urn" / "water boiler" naming in casual copy makes it easy to cross a
   heated model's spec into a non-heated listing or vice versa — check the model prefix
   before reusing any spec text.
2. **9228 series (indirect water-jacket milk boilers) uses the same 2800–3000W /
   230–240V spec text for every size** (12L/20L/30L) — the wattage doesn't scale with
   capacity in the sourced copy. This was true across all three sizes on Sheffield
   Africa's own site too, so it's the manufacturer's own generic spec sheet repeated per
   size, not a data-entry error to "fix."
3. **The 40L electric urn's model number is `111109`, not `111108`** — official
   `pradeepibrew.com` table skips straight from `111106` (27L) to `111109` (40L); no
   `111108`/`111107` exists.
4. **The 36L heated urn (IMG/COF/00032, `model_number: "9G"`) does not exist anywhere in
   Pradeep's *current* official catalogue.** `pradeepibrew.com`'s insulated-dispenser line
   runs `111201`(4.5L)/`111202`(9L)/`111204`(18L)/`111206`(27L)/`111209`(40L) — no 36L size,
   no `72xx` numbering at all. Sheffield Africa's own live page states a fuller code
   (`7227/9G`) and confirms 36L, but since that page isn't independent (see §2), **this is
   either a genuine older/discontinued Pradeep code or an error on Sheffield's own
   listing — left unresolved, not applied**. See §4.4/§4.5.
5. **Coffee brewer 9230 and milk boilers 9228 share the "92xx" prefix but are unrelated
   product lines** (brewer vs boiler) — don't assume adjacency implies a shared spec sheet.

---

### 3. Product reference

| SKU | Catalogue name | Model | Independent source | Confidence |
|---|---|---|---|---|
| IMG/COF/00023 | Milk Boiler ... 12 Litres | 9228/12 | none found independently — see §7 correction | **Low — unresolved** |
| IMG/COF/00024 | Milk Boiler ... 20 Litres | 9228/20 | none found independently — see §7 correction | **Low — unresolved** |
| IMG/COF/00025 | Milk Boiler ... 30 Litres | 9228/30 | none found independently — see §7 correction | **Low — unresolved** |
| IMG/COF/00112 | Electric Catering Urn 9 Ltr | 111102 | `pradeepibrew.com` official table — see §7 | **High** |
| IMG/COF/00113 | Electric Catering Urn 18 Ltr | 111104 | same | **High** |
| IMG/COF/00114 | Electric Catering Urn 27 Ltr | 111106 | same | **High** |
| IMG/COF/00115 | Electric Catering Urn 40 Ltr | 111109 | same (40L is the only gap after 111106) | **High** |
| IMG/COF/00111 | Coffee Filter with Heater Plate 5 Ltr | 111504 | IndiaMart distributor listing — see §7 | Medium |
| IMG/COF/00032 | Heated Insulated Water Urn 36 Litres | `9G` (unresolved — see §2 trap 4) | none found independently | **Low — unresolved** |
| IMG/COF/00029 | Non Heated Insulated Catering Urn/Thermos 16 Litres | 7217/16 | `pradeepstainless.com` official table (exact match) — see §7 | **High** |
| IMG/COF/00030 | Non Heated Insulated Catering Urn/Thermos 20 Litres | 7217/20 | same | **High** |
| IMG/COF/00031 | Non Heated Insulated Catering Urn/Thermos 30 Litres | 7217/30 | same | **High** |
| IMG/COF/00033 | Coffee Brewer with Coffee Filter (3L) | 9230 | none found independently (model/capacity plausible, unconfirmed) | Low |

---

### 4. Data audit — errors found and fixed

#### 4.1 Copy-paste bug — 20L milk boiler had the 30L boiler's fields ⚠ (fixed)

`IMG/COF/00024` (Milk Boiler ... **20** Litres, model `9228/20`) had:
- `description`: *"Milk boiler **36** liters..."* — wrong capacity, and belongs to neither
  this product (20L) nor its own model family (36L is the unrelated, unresolved
  `9G`/heated-urn SKU).
- `technical_specification`: listed **`Model: 9228/30`, `Capacity: 30 LITRES`** — this is
  verbatim the next SKU's (`IMG/COF/00025`, the 30L boiler) spec block.

This is a self-evident internal-consistency bug — the product's own name/`model_number`
say 20L, its own description/spec said 36L and 30L respectively — detectable from
`products.json` alone, no external source needed. Both fields corrected to 20L.

#### 4.2 Copy-paste bug — 30L milk boiler also had "36 liters" in its description ⚠ (fixed)

`IMG/COF/00025` (Milk Boiler ... **30** Litres, model `9228/30`) had the same
*"Milk boiler 36 liters"* description text (same internal-consistency logic as §4.1), and
had **no `technical_specification` at all**. Description corrected to 30L; a spec table
was added using the 9228 family's generic wattage/voltage text (§2 trap 2).

#### 4.3 Copy-paste bug — all three 7217-series thermos urns had a phantom wattage rating ⚠ (fixed)

`IMG/COF/00029`/`00030`/`00031` (16L/20L/30L non-heated insulated urns) each had a
`technical_specification` with a **"Voltage/Frequency: 50/60 HZ, 230-240V" and "Wattage:
2800-3000W"** line — but these are **non-heated, unplugged thermos urns** (that's the
whole point of the product name), confirmed by `pradeepstainless.com`'s own 7217-series
table (independent, official), which lists no power spec at all for this line. The
voltage/wattage lines were carried over from the electric 9228 milk-boiler template.
Replaced with a "Power source: None" line; also normalised each `Model:` line inside the
spec text to match the catalogue's own `model_number` field (`7217/16`/`7217/20`/`7217/30`)
— an internal-consistency fix inside free-text spec HTML, not a change to the
`model_number` field itself.

#### 4.4 `model_number` filled in, with approval and independent confirmation

`IMG/COF/00115` (40L electric urn) had `model_number: null`. Filled in as **`111109`**,
confirmed on `pradeepibrew.com`'s own official spec table (the only gap in the sequence
`111102`/`111104`/`111106`/`111109` for 9/18/27/40L) — independent of Sheffield Africa.
Approved by the user before applying, per [[feedback_model_number_unique_id]].

#### 4.5 Reverted — two fields whose only source was Sheffield Africa's own site ⚠

Two changes made earlier in this pass were **reverted** after review, because the only
source for them was `sheffieldafrica.com` itself (see the caution at the top of this file
and §2's trap 4):

- `IMG/COF/00032` `model_number`: attempted `9G` → `7227/9G`, **reverted back to `9G`**.
  Pradeep's current official catalogue has no 36L / `72xx` product at all (§2 trap 4), so
  the fuller code could not be independently confirmed either way.
- `IMG/COF/00033` (9230 brewer) `technical_specification`: an added **800W** wattage/
  voltage row was **removed** — no independent source states a wattage for this model.

Neither field was left worse than it started (both are back to their pre-pass values);
this file records the attempt and the reason it didn't stick, so it isn't silently
re-attempted later.

---

### 5. Not published — left blank rather than invented

- **111102 / 111104 / 111106 / 111109** (electric urns): no dimensions found on either
  Pradeep site; wattage/voltage is uniform across the family (3000W, 220&ndash;240V/50Hz/
  15A single-phase) per the official table, so recorded as such.
- **111504** (coffee filter 5L): wattage not confirmed anywhere (distributor pages give
  fill/dispense mechanics — manual fill, 2L max water input, 5.5L max brew-storage level
  &mdash; but no power rating); left blank rather than assumed from the family.
- **9230** (coffee brewer): wattage NOT added — see §4.5. Existing spec table left as
  found (no power rating).
- **`9G`/36L heated urn**: fuller model code and dimensions NOT added — see §4.5/§2 trap 4.
  This SKU may be worth a closer look independent of this research pass (e.g. checking
  whether it's actually a discontinued product, or a data-entry error inherited from
  wherever the original catalogue was built).

---

### 6. Summary of `products.json` changes this pass

- **Fixed** the three copy-paste bugs in §4.1/§4.2/§4.3 (20L and 30L milk boilers' wrong
  capacity/spec text; all three 7217-series thermos urns' phantom wattage rating) — all
  detectable from internal inconsistency or confirmed via official manufacturer pages,
  independent of Sheffield Africa.
- **Added** `technical_specification` to the 30L milk boiler (was missing).
- **Added** `meta_description` across all 12 SKUs that lacked one.
- **Built out** `short_description` / `description` / `meta_description` /
  `technical_specification` from scratch for the four 111100-series electric urns
  (00112/00113/00114/00115) and the 111504 coffee filter (00111) — all five had no
  content beyond a name and (mostly) a price before this pass. Sourced from official
  `pradeepibrew.com` tables and independent distributor listings.
- **`model_number` filled in on 1 SKU** (§4.4): `IMG/COF/00115` `null` → `111109`,
  independently confirmed and user-approved.
- **Reverted 2 changes** (§4.5) whose only source was Sheffield Africa's own site: the
  `9G` → `7227/9G` model-number change, and an 800W spec added to the 9230 brewer.
- **No image fields changed.**

---

### 7. Source links (verification pass, July 2026)

Direct links behind the confidence claims in §3 — added after review flagged that this file,
unlike `skymsen-research.md`, had no clickable references.

| SKU | Model | Link | Confirms |
|---|---|---|---|
| IMG/COF/00029 | 7217/16 | https://pradeepstainless.com/stainless-steel-food-storage-drums/catering-urn/ | Official table lists `7217/16`, 16.00 L, exactly |
| IMG/COF/00030 | 7217/20 | same | `7217/20`, 20.00 L |
| IMG/COF/00031 | 7217/30 | same | `7217/30`, 30.00 L |
| IMG/COF/00112 | 111102 | https://pradeepibrew.com/products/electric-hot-water-machine/ | Official spec table: `111102`/9 L, 3000 W |
| IMG/COF/00113 | 111104 | same | `111104`/18 L, 3000 W |
| IMG/COF/00114 | 111106 | same | `111106`/27 L, 3000 W |
| IMG/COF/00115 | 111109 | same | `111109`/40 L, 3000 W — the gap-fill from §4.4 |
| IMG/COF/00111 | 111504 | https://www.indiamart.com/proddetail/south-indian-filter-coffee-maker-21436365588.html | Independent distributor listing: "Model Number: 111503, 111504", 2 L max fill / 5.5 L max brew storage — matches |
| IMG/COF/00023 | 9228/12 | none found | see correction below |
| IMG/COF/00024 | 9228/20 | none found | see correction below |
| IMG/COF/00025 | 9228/30 | none found | see correction below |
| IMG/COF/00032 | `9G` | none found | unresolved, see §4.5/§2 trap 4 |
| IMG/COF/00033 | 9230 | none independent — only https://www.sheffieldafrica.com/kitchen/product/358/coffee-brewer-with-coffee-filter-3.0ltr-9230 | not independent, unchanged from §4.5 |

#### Correction: the "IndiaMart confirms 9228" claim in §3 did not hold up on re-check

§3 previously credited an "IndiaMart listing" with confirming the 9228 milk-boiler family at
Medium confidence. Re-checked July 2026, and **no independent source uses the model number
"9228" at all**:

- `pradeepibrew.com`'s three milk-boiler pages (`milk-boiler-machine`,
  `insulated-milk-boiler-machines`, `non-insulated-pradeep-milk-boiler`) do cover 5/12/20/30 L
  capacities, but under entirely different model codes — `111300`/`111312`/`111320`/`111330`
  (non-insulated) and `111600`/`111612`/`111620`/`111630` (insulated).
- Every IndiaMart listing checked (the `graceinc` storefront and two `proddetail` pages
  advertising "Capacity 5, 12, 20, 30 Liters") uses those same `1113xx`/`1116xx` codes — none
  mention "9228" anywhere.
- The **only** place `9228/12` / `9228/20` / `9228/30` appears is Sheffield Africa's own live
  catalogue (`sheffieldafrica.com/.../milk-boiler-XX-litres-9228-XX`, product IDs 354–356) —
  the same non-independent source flagged at the top of this file.

The 5/12/20/30 L capacity range is a genuine Pradeep product family (confirmed
independently). What's unconfirmed is the specific `9228` model code attached to it in
`products.json` — that traces only back to Sheffield's own site. **§3's confidence for the
three 9228 SKUs has been downgraded from Medium to Low/unresolved**, the same tier as the `9G`
urn and the 9230 brewer. No `products.json` fields were changed by this finding — the
`model_number` values were left as-is (changing them would need a *better* source, not just a
downgrade), but they should now be read as unconfirmed rather than confirmed.

---

### 8. Second follow-up pass (July 2026) — chasing the last 5 low-confidence SKUs further

The business flagged that `sheffieldafrica.com` should never have been leaned on at all (it's
our own storefront, not a supplier — see the caution at the top of this file) and asked for
another independent pass specifically on the SKUs still resting on it. Findings below are all
from sources with no relationship to Sheffield Africa (pradeepibrew.com's own pages, IndiaMart
listings unconnected to the `graceinc`/Sheffield-linked ones already cited).

#### 8.1 9228/12, 9228/20, 9228/30 — family confirmed independently, legacy code still isn't

`pradeepibrew.com/products/insulated-milk-boiler-machines/` (official, independent) gives a
clean model/capacity/dimension table for the **current** "double-layered"/jacketed milk-boiler
line:

| Model | Capacity | Dimensions (L×W×H mm) |
|---|---|---|
| 111600 | 5 L | 470×280 |
| 111612 | 12 L | 580×320 |
| 111620 | 20 L | 550×380 |
| 111630 | 30 L | 670×390 |

All four share "220–240V AC, 15Hz, 15A" and manual fill, dispensing hot milk/hot water at
7–8 cups/min — no per-size wattage is published (unlike the non-insulated 111300 line, which
is a flat 3000 W across all sizes). Our three SKUs' "double layered"/"indirect water heating
jacket" description matches this **insulated** family, not the non-insulated 111300 one, on
design grounds (indirect jacket = double wall), and the capacities (12/20/30 L) line up exactly
with `111612`/`111620`/`111630`.

This still does **not** confirm the `9228` code itself — no independent source anywhere uses
that number, only Sheffield's site does. What it does establish is that the product *family*
matches a genuine, currently-sold Pradeep line, so this reads as an old/legacy Pradeep code for
the same physical product rather than an invented one (parallel to the `9230`→`111503` finding
in §8.2 and the `111108`→`111109` gap already documented in §2 trap 3).

**Applied (user decision, July 2026):** rather than adopt `111612`/`111620`/`111630`, the
business chose to keep the existing `92xx`-style numbering but correct the leading digit —
`9228/12`/`9228/20`/`9228/30` → **`7228/12`/`7228/20`/`7228/30`** (matching the `72xx` prefix
already used by the 7217 (thermos urn) and 7227 (heated urn) families) — approved and applied
directly, no further confirmation attempted on `7228` itself. At the same time the three
separate SKUs (`IMG/COF/00023`/`00024`/`00025`) were **merged into one variable-type parent
product** ("Milk Boiler with Indirect Water Heating Jacket" (`sku: null` — variant-group parents carry no SKU of their own, per the seeder's existing rule; the three original SKUs live on the variants)), following the same pattern already
used for `GROUP/ELECTRIC-CATERING-URN-PRADEEP` and `GROUP/INSULATED-CATERING-URN-PRADEEP` —
one shared parent image (the three variants look visually identical, so no per-variant images
were added, same as the insulated-urn group), one `volume` variation attribute
(12/20/30 litres), and the three original SKUs preserved as variants. The three old per-SKU
stock photos (which turned out to be generic — 12L and 20L were literally the same file) were
deleted from `storage/app/public/products/` and replaced with a single new photo
(`milk-boiler-with-indirect-water-heating-jacket-pradeep.jpg`).

#### 8.2 9230 (3L coffee brewer) — found a genuinely independent 800W confirmation, under a different code

Two separate IndiaMart listings (unconnected to Sheffield or to the `graceinc`/`velanstore`
sources already cited), both for a **Pradeep 111503, 3-litre filter coffee machine**:

- "111503 800" PRADEEP Filter Coffee Machine 3 Liter — ₹6,396/unit, Tiruvallur:
  https://www.indiamart.com/proddetail/pradeep-filter-coffee-machine-3-liter-21746553033.html
- Stainless Steel 111503 PRADEEP Coffee Filter Machine — same model/price, Tiruvallur:
  https://www.indiamart.com/proddetail/pradeep-coffee-filter-machine-21601575991.html

Both independently agree: **model 111503, 3000 ml max storage, 800 W, 220–240V AC, 15Hz, 5A,
single phase, manual fill/dispense, stainless steel tap.** This is the same "111503" model
number already cited in §3/§7 for the *5-litre* SKU (`IMG/COF/00111`, catalogued there as
`111504`) — IndiaMart's own "South Indian Filter Coffee Maker" listing gives "Model Number:
111503, 111504" for the 3 L/5 L pair, which matches this new 3 L-specific listing cleanly.

This directly bears on the §4.5 revert: an 800 W spec was pulled from `IMG/COF/00033` (the 9230
brewer) because at the time its *only* source was Sheffield. There is now a genuinely
independent 800 W source for the 3-litre Pradeep filter coffee machine — but it's attached to
model `111503`, not `9230`. Read together with §7's Indian rebrand pattern, `9230` is very
likely an old/legacy code for the same 3 L product now sold as `111503`, the same relationship
as the 9228 family above. **Proposed, not applied:** re-adding an 800 W / 220–240V / manual-fill
spec line to `IMG/COF/00033`, and optionally updating `model_number` from `9230` to `111503` —
both need approval before touching `products.json` (spec-content changes are lower-stakes, but
the model number itself is a unique ID per [[feedback_model_number_unique_id]]).

#### 8.3 9G / 36L heated urn — still unresolved; one lead checked out and didn't hold up

A search summary surfaced a claim that the `7227` series maps `7227/9G` to "9 gallons / 40
litres" (alongside `7227/1G`=4.5L, `7227/2G`=9L, `7227/4G`=18L, `7227/6G`=27L). This looked
promising — it would mean our 36 L figure is simply wrong and the real capacity is 40 L,
matching the already-confirmed `111209` (40 L) in the current catalogue. **This could not be
substantiated on follow-up**: the two pages that would carry it both 404 —
https://www.pradeepibrew.com/product/stainless-steel-insulated-hot-water-dispensers/ and
https://velanstore.com/product/pradeep-insulated-hot-water-dispenser/ — a direct search for
the exact string `"7227/9G"` returned nothing, and the one `pradeepibrew.com` product page that
did load for this line (https://pradeepibrew.com/product/insulated-hot-water-dispenser/) was
just a product photo with no spec table. Treating the "40 L" claim as unverified rather than
acting on it — **no change proposed**. The `9G`/36L urn remains exactly where §4.5/§2 trap 4
left it: no independent source, nothing changed.

#### 8.4 Net effect of this pass

- **9228/12, 9228/20, 9228/30 — applied.** `model_number` changed to `7228/12`/`7228/20`/
  `7228/30` (business decision, keeping the `92xx`→`72xx` family style rather than adopting
  `111612`/`111620`/`111630`), and the three SKUs merged into one variant-group product
  ("Milk Boiler with Indirect Water Heating Jacket" (`sku: null` — variant-group parents carry no SKU of their own, per the seeder's existing rule; the three original SKUs live on the variants)) with a single shared image, replacing the
  three old per-SKU photos (two of which were duplicates of each other). See §8.1.
- **9230**: independent 800 W/220–240V spec found, but under code `111503`. Still a proposal —
  restoring an 800 W spec line, and considering `model_number` → `111503`, both need approval.
- **9G/36L urn**: no progress — a promising lead (7227/9G = 40 L) didn't survive verification
  and was discarded rather than used.
