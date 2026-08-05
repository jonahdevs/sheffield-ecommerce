# House Brand Suppliers Research

Supplier identification behind the Sheffield house labels. The **supplier map itself was
supplied by the business on 2026-07-30** — this file records what independent verification
found for each named supplier, and is the prerequisite for any per-SKU work on the ~268
house-branded SKUs.

Scope: the 9 house labels and their stated sources. This pass verifies **supplier identity
and whether a per-SKU sourceable catalogue exists** — it does not yet source individual SKUs.

Companion files: `blueline-research.md`, `hk-redline-research.md`, `h-kitchen-research.md`,
`kitchenware-research.md`, `steelology-research.md`, `oem-placeholder-brands-research.md`.

---

## 0. The map as stated by the business

| House label | SKUs | Stated source |
|---|---|---|
| HK-REDLINE | 102 | H-Kitchen |
| SHEFFIELD REDLINE | 3 | H-Kitchen |
| SHEFFIELD BLUELINE | 47 | Shandony Vcher — ⚠ **not the only source: `EWB470G` is a Wondereach product**, see `sheffield-blueline-research.md` §5.2 |
| BLUELINE | 5 | Shandony Vcher |
| OEM SHEFFIELD | 29 | Elaboratex + Wanhui + Guangdong |
| SV-BLUELINE | 25 | Snow Village + Iberna + Brema — ⚠ **Snow Village alone covers all 25; see §4** |
| KITCHENWARE | 20 | Osion — ⚠ **contradicted, see §7.1; evidence says Wanhui** |
| SHEFFIELD | 19 | Local purchase |
| STEELOLOGY | 10 | Steelology |

Verification status after this pass: **4 confirmed, 1 previously confirmed, 1 lead only,
1 not found, 1 needs no verification, 1 ambiguous.**

---

## 1. Shandong Vcher → SHEFFIELD BLUELINE + BLUELINE (52 SKUs) ✅ CONFIRMED

**Shandong Vcher Electrical Appliance Co., Ltd.** is real, trading, and has a live catalogue.

- https://vcher.com.cn/
- https://www.vcher.com.cn/about.html
- https://www.zoominfo.com/c/shandong-vcher-electrical-appliance-co-ltd/1340675533
- https://trademarks.justia.com/793/15/vcher-79315834.html
- https://bbs.fobshanghai.com/company/1693t14s2odm109.html

Profile: commercial kitchen refrigeration only (R&D, production, sales, after-sales).
Address **West Shili Pu, Hutouya Industry Zone, Laizhou City, Shandong Province, 261428** —
1.5 h from Qingdao Airport, 2 h from Qingdao Port. 80,000 m², **150,000 sets/yr**, exports to
**36+ countries**. Certifications CE, RoHS, SAA, ITACS, ETL Sanitation, cETL, CCC, ISO9000.
Holds a registered **VCHER** trademark (US serial 79315834).

Catalogue is exactly seven categories, and they map cleanly onto the Sheffield Blueline range:
**Cabinet · Counter · Saladette · ABS · Display · Freezer · Stainless Steel Worktable.**

Category page URL pattern (`_p_1` is page 1; a LOAD MORE control implies more pages):
- Cabinet Range — https://vcher.com.cn/product_2_p_1.html
- Counter Range — https://www.vcher.com.cn/product_3_p_1.html
- ABS Range — https://vcher.com.cn/product_5_p_1.html
- Display Range — https://www.vcher.com.cn/product_6_p_1.html
- Freezer — https://www.vcher.com.cn/product_7_p_1.html

⚠ Chinese legal name is **unresolved**: one directory renders it 山东万成电器有限公司
(Wancheng), the About page suggests 山东威切尔电器有限公司 (a phonetic rendering of "Vcher").
Not load-bearing, but do not cite either as settled.

### 1.1 The model codes match — this is the load-bearing finding

Vcher's own codes and our Blueline codes share a structure, with our prefix letters being the
only difference:

| Vcher's own code | Our catalogue code | Source of the difference |
|---|---|---|
| `GN2100TN`, `U-GN2100TN` | `G-GN2100TN` | prefix letter only |
| `GN4100TN` | `HC-GN4100TN` | prefix letter only |

Codes read verbatim off Vcher's Cabinet range: `GN1200TN`, `GN1200BT`, `GN1200TNV`,
`GN1200BTV`, `GN1200TNM`, `GN1200BTM`, `GN1200TNMV`, `GN1200BTMV`. Off the Counter range:
`GN2200TN`, `GNH2100TN`, `GN1100TN`, `U-GN2100TN`, `GN2100BT`, `GN1100BT`, `GN3100TN`,
`GN4100TN`.

Decoded: `GN` + capacity + **TN** (chill, ~+2/+8 °C) or **BT** (freeze, ~−18/−22 °C), then
optional **V** (ventilated) and/or **M** (static/mixed). Vcher's own pages state the temperature
band per code, so **the TN/BT half of every Blueline code is independently verifiable.**

**This supersedes — but does not delete — `blueline-research.md` §2's Firscool trace.** That
file terminated the chain at Shandong Hongtai Electrical Appliance (brand FIRSCOOL), **also of
Laizhou, Shandong** — the same city as Vcher. Laizhou is a commercial-refrigeration cluster, so
the two are neighbours at minimum. Whether Vcher and Firscool are corporately related is
**open, and the business does not know** (stated 2026-07-30). It does not block anything: Vcher
is the supplier of record, and its site is the per-SKU source to use.

### 1.2 ⚠ CORRECTED — `SNACK` and `VRX` are Vcher's own codes too

An earlier version of this section claimed `SNACK…` and `VRX…` do not appear on Vcher and must be
sourced via Forcar/Forcold. **That was wrong.** It rested on checking a single category page.

A full sweep of Vcher's catalogue (2026-07-30) found `SNACK` models throughout the **Counter
range (CAT 3)** and as uprights in **CAT 2**, and the entire `VRX` pizza-display family in
**CAT 6** — including `VRX1500/380FG` and `VRX1800/380FG`, both of ours. The `DR`/`DF` "S/S"
units are Vcher's **ABS Range (CAT 5)**.

**Vcher covers essentially the whole Blueline catalogue: 43 of 52 SKUs matched.** There is no need
for a second sourcing route. Full per-SKU results, the code decoding, and the errors found are in
**`sheffield-blueline-research.md`**.

---

## 2. Guangzhou Elaboratex → OEM SHEFFIELD (part of 29 SKUs) ✅ CONFIRMED

**Guangzhou Elaboratex Western Kitchen Equipment Co., Ltd.**, also trading as **Guangzhou
Hengxing Mechanical & Electro Device Factory**.

- https://www.made-in-china.com/showroom/elaboratex/
- https://www.made-in-china.com/showroom/mermaid78
- https://andyliang888.en.ec21.com/
- https://www.ttnet.net/show_html.jsp/profile/SS/infohtm/Y/cono/pp6wnqutjl6wjqa/type1/
- https://www.facebook.com/p/Guangzhou-Elaboratex-Western-Kitchen-Equipment-CoLtd-100054310609095/

Address **13 Dongjing Road, Donghua Industrial Park, Renhe Town, Baiyun District, Guangzhou,
Guangdong, 510470**. Business type manufacturer/factory. ISO 20000.
⚠ Year established is reported as **2015 on one showroom and 2016 on the other** — unresolved.

Product range (western kitchen equipment + snack machinery): combination ovens, fryers,
griddles, bain marie, pasta cookers, popcorn machines, food warmer displays, ice makers, juicer
dispensers, cake showcases, spiral mixers, gas soup kettles, gas lava rock grills, plate
electric cookers. One model code surfaced: `HEF-4L` (electric fryer).

⚠ **Only two showrooms, both thin** — one visible product on the `elaboratex` showroom, no codes
at all on `mermaid78`. There is **no own-domain catalogue found**. Per-SKU sourcing here will be
harder than Vcher's, and may need supplier documents rather than the web.
Also note **Elaboratex is itself in Guangdong**, so "Elaboratex + Guangdong" as two separate
sources needs clarifying — see §7.

---

## 3. Wanhui → OEM SHEFFIELD (part of 29 SKUs) ✅ CONFIRMED — and it closes two old puzzles

**Wanhui Industrial (China) Limited** / **Jiangmen Wanhui Manufacturing Company Limited**.

- http://www.whkitchenware.com/
- https://www.tradewheel.com/co/jiangmen-wanhui-manufacturing-company-li-1051002/

Address **Fenghua Industrial Park, Pengjiang District, Jiangmen City, Guangdong Province**.
Products: chafing dishes, gastronorm (GN) pans, commercial cookware, service trolleys, juice
dispensers, buffet equipment. Self-describes as one of the largest food & beverage service
product makers/exporters in China.

**Two prior findings are now resolved, not merely explained:**

1. `oem-placeholder-brands-research.md` §2.2 **downgraded WANHUI to "unconfirmed"** — zero
   results on DuckDuckGo and Made-in-China, the whole case resting on a single Alibaba listing.
   That was wrong: Wanhui has its own domain and a trade-directory presence. **Re-instate WANHUI
   as a real, verified supplier.** (This is the failure mode
   `project_catalogue_enrichment_status` warns about — a negative finding produced by a search
   that simply did not reach the right index.)
2. `JANGMEN` (1 SKU) was filed as "a city, misspelt (Jiangmen, Guangdong), though an accurate
   address for the goods." **Wanhui is in Jiangmen.** The `JANGMEN` brand string is almost
   certainly Wanhui goods entered by origin city. Same likely applies to `FOSHAN` /
   `GUANGDONG PERFECT` — verify individually, do not bulk-reassign.

⚠ **The domain is `whkitchenware.com` — "WH" (Wanhui) + "kitchenware".** And `brands.json`'s
`kitchenware` row description reads *"Wanhui manufactures commercial kitchen equipment…"*.
Wanhui's product range (chafing dishes, GN pans, cookware, trolleys) is a **strong match for
the KITCHENWARE label's 20 SKUs**, which the business attributes to Osion instead. This is a
genuine conflict — see §7.

---

## 4. SV-BLUELINE (25 SKUs) — researched 2026-07-30 ✅ SNOW VILLAGE ACCOUNTS FOR ALL 25

`blueline-research.md` §1.3 had already decoded **"SV" = Snow Village** and identified the
`PLR-`/`CFR-`/`CFD-` codes as Snow Village's own. This pass verified the supplier properly and
tested the other two named sources against the actual SKU list.

### 4.1 Snow Village = Zhejiang Xuecun Refrigeration Equipment Co., Ltd. ✅ CONFIRMED

- https://zjxczl.en.made-in-china.com/
- https://www.snowvillagefreezer.com/ (⚠ **TLS certificate expired** — fetch fails; use the
  Made-in-China storefront or a regional distributor instead)
- http://www.chinasnowvillage.com/
- https://www.snowvillage-refrigerator.com/commercial-refrigeration-equipment/supermarket-refrigeration-series/
- https://www.ecombri.com/shop/zhejiang-xuecun-refrigeration-equipment-coltd

**The legal name is Zhejiang Xuecun Refrigeration Equipment Co., Ltd.** — 雪村 *Xuecun* is
literally "Snow Village", and its Made-in-China profile states it **operates under both the
"XUECUN" and "SNOWVILLAGE" brands**. This is a new identification: no prior research file has
the legal name.

Address **Huibu Industrial Zone, Changshan County, Quzhou, Zhejiang**. Established **2003**.
**120,000 m²** construction area, **8 production lines, 700+ employees, 500,000+ commercial
units/yr**, exports to **40 countries**, **10 branches/offices across Asia**. ISO9001, ISO14001,
CCC, CE. Far larger than the earlier record implied.

### 4.2 Snow Village's categories cover every SV-BLUELINE code family

| Our SV-BLUELINE SKUs | Snow Village category |
|---|---|
| `LMD-1894QK` "Order Dish Multifunctional Cabinet", `LCD-639` "Order Dish Convenience Store Cabinet" | **"order dishes cabinet"** |
| `LC-1500(T)`, `LC-1200(T)`, `LC-298B` Vertical Display Cabinets | display cabinet |
| `SD/SC-518`, `SD/SC-2000K`, `SD/SC-158Y`, `BD/BC-388` island & top freezers | island cabinets / freezers |
| `DG-900FZ`, `DG-1200FZ`, `DG-1500FZ`, `DG-TY700`, `DG-TZ700` | cake cabinet |
| `PLR-*`, `PLD-*`, `CFR-*`, `CFD-*` counter & upright chillers/freezers | kitchen refrigerator / chiller cabinets |

⚠ **"Order dishes cabinet" is the smoking gun.** It is an unusual, distinctly literal
translation, and it appears both as a Snow Village category name and inside two of our product
names. That is not coincidence.

Snow Village also makes seafood display cabinets, cooked-food cabinets, drug coolers,
supermarket air-curtain cabinets, beverage coolers, meat display cabinets — **and ice machines**.

### 4.3 The `DG-` cake-cabinet family is verified as Snow Village's own

Snow Village's **Bangladesh** distributor publishes `DG-` codes:
https://snowvillagebd.com/pastry-chiller/cake-cabinet/ and
https://snowvillagebd.com/cake-display-counter/

Codes listed there: `DG-TZ900`, `DG-900F` / `DG-1200F` / `DG-1500F`, `DG-FYK`, `DG-900FY`.

Against ours: `DG-900FZ` / `DG-1200FZ` / `DG-1500FZ` (same three sizes, suffix **F** vs **FZ**),
`DG-TZ700` (same `TZ` stem, 700 vs 900), `DG-TY700` (`TY` vs their `FY`). **Family confirmed;
exact size/variant suffix must be verified per SKU** — the same discipline as Vcher in §1.1.
Direct searches for `DG-1200FZ`, `DG-TY700`, `LMD-1894QK`, `CFD-60D3F` returned **nothing**, so
these exact strings are not indexed; the distributor route is the way in, not search.

**Regional distributors are the practical per-SKU source** (Snow Village's own site has the
expired certificate):
https://snowvillagebd.com/ (Bangladesh) · https://www.snowvillage.com.sg/ (Singapore) ·
https://snowvillageau.com/ (Australia). Kenya is an analogous market to these.

### 4.4 Iberna and Brema make ice equipment ONLY — neither can account for any SV-BLUELINE SKU

Both were checked directly, and both came back unambiguous.

**Iberna** — https://icemachineproduce.en.made-in-china.com/ (own site
http://www.ibernaice.com/ **fails TLS: serves a certificate for `in6.wang`**, the caveat
`iberna-research.md` §1 flagged). Legal name **HENAN IBERNA ICE MAKER CO., LTD.**, Xingye Rd
East, Development Zone, Minquan City, Shangqiu, Henan. Its own stated range: *"Modular Ice Cube
Maker, Undercounter Ice Maker, Self-Feed Ice Maker, Combined Ice Maker-Chiller Workbench, Flake
Ice Maker, Granular Ice Maker."* **No counter chillers, no upright chillers/freezers, no display
cabinets, no cake cabinets.** The one borderline item is the *ice maker–chiller workbench*
hybrid, which is not a counter chiller.

**Brema** — https://www.bremagroup.it/en/products/ and https://www.bremagroup.it/en/brema-en/ .
**Brema Group S.p.A. is Italian**, and its range is ice only: cube, frozen dice, pebble, nugget,
flake and scale ice; self-contained machines, modular heads, storage bins. No refrigerated
cabinets or chillers found. Note too that SV-BLUELINE's codes are **Chinese domestic** in shape
(`blueline-research.md` §1.3), which an Italian manufacturer would not produce.

### 4.5 Reconciling this with the business's statement

The stated map said **SV-BLUELINE ← Snow Village + Iberna + Brema**. The evidence says Snow
Village alone accounts for all 25 SKUs, and that Iberna and Brema *could not* have supplied any
of them.

**The likely reconciliation is a category difference, not an error:** Iberna and Brema are real
Sheffield suppliers — they are simply sold under **their own brand names**, not house-labelled.
The catalogue has IBERNA (6 ice cube machines, `ZBJ-*`) and BREMA (5 ice cube machines, `CB-*`)
as live own-branded lines. So the natural reading is that Snow Village, Iberna and Brema are all
**refrigeration-division suppliers**, of which only Snow Village feeds the SV-BLUELINE house
label.

⚠ **This also gives Osion a home** (§7.1): Osion is likewise an ice-equipment maker. If the
grouping is "our refrigeration/ice suppliers" rather than "what sits behind SV-BLUELINE", then
Osion belongs alongside Iberna and Brema — which would explain why it appeared in the map with
no house label that fits it. **Needs the business to confirm.**

### 4.6 Correction to record

`iberna-research.md` §1 states plainly: *"`ZBJ` is not a generic Chinese code family in this
case. It is Iberna's own house prefix across its entire cube-ice range"*, with the full official
model list recovered and every genuine code carrying a trailing series letter (`PA`, `PB`, `PC`,
`PE`, `LA`, `LC`, `LD`) or a bare `L`. **An earlier note in this effort dismissed `ZBJ` as
industry-generic pinyin for 制冰机 — that is wrong as applied to Iberna** and should not be
repeated. It remains true that `ZBJ` is a weak *fingerprint* across the wider industry, which is
why the Osion↔Iberna link stays unproven — but the reason is Osion's separate identity, not a
generic prefix.

---

## 5. H-Kitchen → HK-REDLINE + SHEFFIELD REDLINE (105 SKUs) ✅ ALREADY CONFIRMED

Fully documented in `hk-redline-research.md` §1 — "**HK** is an abbreviation of **H-Kitchen**",
confirmed by the business in July 2026, goods arriving through **Hangzhou Kator Foreign Trade
Co., Ltd.** of Kator International, Hangzhou. See `h-kitchen-research.md` §1 for the corporate
structure (Kator Foreign Trade = trading arm; Hangzhou Frigo = the factory).

New from the business: **SHEFFIELD REDLINE (3 SKUs) is the same source.** Consistent with
`RGR24` and `RGR36` having been handled inside the H-Kitchen/HK-Redline passes already.

Key caveat carried over: **Kator is a trading company as well as a factory**, so "from
H-Kitchen" is true at the invoice level while the nameplate may belong to a third-party Chinese
OEM. Both attributions are honest; neither is the whole story.

---

## 6. SHEFFIELD (19 SKUs) → local purchase ✅ NO SUPPLIER TO FIND

The business states these are **locally purchased**. There is no OEM behind them and no
external catalogue to trace. This **closes** the "trace the OEM behind each" instruction for
these 19 SKUs — the correct approach is copy written from the goods themselves plus Sheffield's
own photography, not further web sourcing.

This is a genuine change in plan, not a gap: previously these 19 sat in the same
"needs OEM tracing" bucket as the rest.

---

## 7. Unverified and conflicting — needs the business

### 7.1 Osion ✅ COMPANY CONFIRMED — but it does **not** match KITCHENWARE

The business supplied the domain, which resolved the identity immediately.

- https://osion.com
- https://www.zoominfo.com/c/osion-international-group-co-ltd/348635849
- https://www.linkedin.com/company/osion
- https://panjiva.com/Osion-International-Group-Co-Ltd/45894111
- https://www.trademo.com/companies/osion-international-group-co-limited/4470251
- https://www.ckitchen.com/osion.html
- https://www.chefsdeal.com/b/osion
- https://hotelsmag.com/manufacturer/osion/

**Osion International Group Co., Ltd.** — "OSION ICE MAKERS". Hangzhou, Zhejiang, China
(two addresses on record: 4508 Build-8 Intime Center, Linping District; and 1204 Dong Xin Da Dao,
Binjiang District, 310053). 15–18 years in cooling, **86 countries**, ISO-21001, CE, ETL, SAA,
2-year warranty, "99.9% bacteria-free" system. Contact justin@osion.com, +86-571-88150015.

**Product range is ice equipment only:** ice makers (commercial and undercounter), ice
dispensers, modular ice makers, ice storage bins, refrigerators, portable fridge freezers.
Model codes seen: `ZBF-20`, `ZB-40`, `ZB-60`, `ID-100`.

**The mismatch, tested against the catalogue:** KITCHENWARE's 20 SKUs contain **no ice equipment
whatsoever**. They are stock pots (`SDI2828`, `SDI3636`, `SDI4040`, `SDI4545`, `CSP 2525`), high
sauce pans (`SD22816`, `SD22414`, `SD22013`, `SDI2518`, `SDI3222`), non-stick GN containers
(`NF811-20`, `NF811-40`), roll-top chafing dishes (`RA2301`, `RA2302`, `RA2301AE`, `ECD09C`), a
juice dispenser (`SJD10A`), an infrared heating lamp (`XD-HHB900`), an induction cooker
(`A6-650N-32`) and a vegetable food processor (`QC205A`).

**So KITCHENWARE ← Wanhui, proven three independent ways:**
1. `IMG/BUF/00090` is **named "Induction Cooker Wanhui"** in `products.json` — the supplier's
   name is already inside a KITCHENWARE product name.
2. Wanhui's stated range matches item-for-item: *chafing dishes, gastronorm pans, commercial
   cookware, service trolleys, juice dispensers, buffet equipment* (§3).
3. Wanhui's own domain is `whkitchenware.com`, and `brands.json`'s `kitchenware` row already
   reads "Wanhui manufactures commercial kitchen equipment…".

**Where Osion actually belongs is unresolved.** It is a real supplier, so it feeds *something*.
The catalogue's only ice-machine SKUs are own-branded, not house-labelled:
**BREMA** (5: `CB 249A HC`, `CB 416A HC`, `CB 640A HC`, `CB 955A HC`, `CB 1565A HC`) and
**IBERNA** (6: `ZBJ-40P`, `ZBJ-60P`, `ZBJ-80PA`, `ZBJ-100L`, `ZBJ-150L`, `ZBJ-250L`).

⚠ **The Osion↔Iberna link is unproven — but not for the reason first written here.** Osion's
`ZB-40`/`ZB-60` and Iberna's `ZBJ-40P`/`ZBJ-60P` share a prefix stem and the 40/60 capacities,
which is tempting. An earlier draft dismissed this as `ZBJ` being generic pinyin for 制冰机
("ice maker") — **that reasoning was wrong**: `iberna-research.md` §1 establishes `ZBJ` as
*Iberna's own house prefix*, with the full official model list recovered (see §4.6). The correct
reason to hold off is simply that **Osion is a separate, independently verified company** in
Hangzhou/Zhejiang, while Iberna is a real factory in Henan whose genuine codes all carry a
trailing series letter (`ZBJ-40PA` etc.). Two ice-machine makers, not one.

Also ruled out: **SV-BLUELINE contains no ice equipment** — its 25 SKUs are counter and upright
chillers/freezers, island freezers, display and cake cabinets. So Snow Village's "ice making"
phrasing in `brands.json` describes the company, not what we buy from it.

**§4.5 now offers the likely home for Osion:** alongside Iberna and Brema as an **own-branded
ice-equipment supplier**, not behind any house label. That reading makes the whole map
self-consistent. Needs the business to confirm.

### 7.2 Steelology → STEELOLOGY (10 SKUs) ⚠ NOT FOUND

No company named Steelology exists in foodservice on the open web. The only near-match is
**Steellogy**, a Polish industrial-knife maker ( https://www.steellogy.com/ ) — wood, paper,
tobacco, metal and recycling blades. Clearly unrelated.

This does **not** simply restore `steelology-research.md`'s conclusion (§1.1/§5: "a Sheffield
storefront label for generic/rebadged stainless smallwares, not a manufacturer"). The business
says the goods come *from* Steelology, which most plausibly means a **supplier trading under
that name with no web footprint** — the same shape as §6's local purchases. Needs confirmation.

⚠ Independent of this, the **"Time Saver" pressure-cooker finding still stands**: `SSPC-16`
(STEELOLOGY), `SSPC-25` (HK-REDLINE), `SSPC-40`/`SSPC-60` (GENEVA) are one product line across
three house labels, proven by byte-identical stored photos. If Steelology is a distinct
supplier, that cross-label overlap needs explaining.

### 7.3 ✅ "Guangdong" RESOLVED — it is **Guangdong Perfect Co., Ltd.**, brand **JIWINS**

Settled 2026-07-30 while working OEM SHEFFIELD. Twelve of its 35 SKUs are `JW-` prefixed
dishwasher/glass racks, and **SAP's own `Item Remarks` name the maker outright** — *"JIWINS PLATE
AND TRAY RACK"*, *"CUTERY RACK -JIWINS"*.

**JIWINS is the brand of GUANGDONG PERFECT CO., LTD.** — founded 2003, 30,000 m², 157 staff,
metal and plastic products for restaurants and commercial kitchens.

- Official catalogue: http://www.jiwins.cn/en/ (per-model pages carrying our exact codes)
- Alibaba company page: https://jiwins.en.alibaba.com/ (registered as Guangdong Perfect Co., Ltd.)
- Distributors: https://www.brightwaycatering.com/en/jiwins · https://tomkin.com.au/collections/jiwins · https://chefcoca.com/collections/jiwins

⚠ **This corrects `oem-placeholder-brands-research.md` §1.8**, which dismissed `GUANGDONG PERFECT`
as "province + supplier trade name". It is a real company, and it is the third supplier the
business named for OEM SHEFFIELD. The asset path on jiwins.cn is literally `/gdpfjd…/` —
**gdpf = GuangDong PerFect**.

Two of our own product names already carried the clue: `IMG/STO/00009` is *"PVC Shelves Vented
910 **Perfect**"*, and `brands.json` has had an orphan **`Perfect`** row all along.

### 7.3b Superseded note — the original ambiguity

"Guangdong" is a **province**, and both named OEM Sheffield suppliers are already in it
(Elaboratex in Guangzhou, Wanhui in Jiangmen). So it may mean: `GUANGDONG PERFECT` (an existing
1-SKU brand string, which `oem-placeholder-brands-research.md` §1.8 dismissed as "province +
supplier trade name"), or a third unnamed Guangdong supplier, or simply the origin of the
Elaboratex/Wanhui goods. `brands.json`'s `oem sheffield` row says *"Guangzhou produces…"*,
which points at Elaboratex.

### 7.4 Not covered by the map at all

- **SYSTEMATIC** (7 SKUs) — proven house label (`systematic-kayalar-research.md` §1: `JSPCC-08`
  returns a true external count of zero; `JS` is a Sheffield prefix). No supplier given.
- **TUNGSTEN** (1 SKU) — proven house label, traced to Ningbo XiangChi Electrical ("Sankool").
  No supplier given.
- **KAYALAR** (6 SKUs) — supplier is real (Kayaplas Kayalar Plastik, Istanbul), but our rack
  codes are Sheffield-internal, so it behaves like a house label for sourcing purposes.

---

## 8. What this changes for the enrichment effort

1. **`brands.json` descriptions are evidence, not junk copy.** `hk-redline` says "H-Kitchen
   manufactures…", `sv-blueline` says "Snow Village specializes…", `kitchenware` says "Wanhui
   manufactures…", `oem sheffield` says "Guangzhou produces…". Every one names a real supplier
   now verified or already known. Earlier passes flagged these rows as wrong and slated them for
   rewrite. **They are supplier attributions that leaked into the description field.** Before
   rewriting any of them, mine them — and preserve the supplier name somewhere first.
2. **Sheffield Blueline (52 SKUs) is now the most tractable house-brand target**, not the least:
   a live categorised catalogue with matching codes and stated temperature bands. Start here.
3. **Two negative findings must be reversed** — WANHUI (§3) and, on current evidence, the
   framing of STEELOLOGY as label-only (§7.2). Both are instances of the known "a negative brand
   finding may be an artefact of the search, not the world" bug class.
4. **19 SKUs (SHEFFIELD) leave the tracing queue entirely** (§6).
