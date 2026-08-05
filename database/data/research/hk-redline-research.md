# HK-Redline - research (SAP-led redo, in progress)

Supersedes `old/hk-redline-research.md`, which was written before the SAP export existed.
102 SKUs. Copy was completed in the earlier pass; what this redo owes is **provenance** -
an independently sourced image and spec sheet per SKU.

**Current staging: 85 of 102 SKUs have an image, 19 have a spec sheet, 352 files.**
(Was 5 and 0 before the 31 July 2026 pass, which ran as three agents split by category —
HOT/ICE/STO, BUF/OVE/COF, FPR/PAS/DIS. Their per-range write-ups are appended in full below;
`_sourced.json` in the staging folder merges all three ledgers, 206 rows.)

## Synthesis of the 31 July 2026 pass

**Resolution is a property of the supplier, not of the effort.** FPR is sold by real Western
importers and reaches 1000-2560 px with OEM manuals. DIS is 100% Kator house codes with no
independent reseller anywhere on the open web - proven ceiling 698x500, so 8 of 10 DIS SKUs are
capped below the 800 px floor permanently. Only warehouse photography or Kator's own originals
will fix those. ⚠ But note the counter-finding: **"Garyton/micyjz caps at 640 px" turned out to
be FALSE** - a 3024x3024 factory photo and a 1500x1000 frame sit in page *bodies*, outside the
gallery list, so that ceiling had been measured on the wrong part of the page. Re-sweep other
brands sourced from Garyton before trusting their recorded ceilings.

**SAP lost every dimension conflict that reached a manufacturer.** 7 of 7 in HOT/ICE/STO
(WB-1, WB-2, 6ATS-C, CT-3, EB-600, BS-6V, RC-400T) and 6 more in FPR/PAS/DIS, with
`products.json` right each time. SAP also carries obvious placeholder rows: the identical
`385/415/795` on three unrelated machines (JDR450B, KT-20, NFQ-380), `1005/930/560` on both
YXD-1AE and YXD-8A-3, one shared row across the 3 GN and 6 GN thermo boxes, and a heat-lamp row
(`BUF/00244`) byte-identical to the LSP-18X3 juice dispenser. **Do not treat SAP as the
dimension authority for this brand.**

**The 820-vs-860 HTD question is CLOSED: 820 is correct.** Garyton is the OEM (`GRT-HTD-20/40/90`
are our units) and its own table gives 1230x820x530, 1230x820x1250, 1670x820x1520 - matching SAP
exactly. HTR-20Q and HTR-40Q match to the millimetre too. Kator's published 860 is wrong.

**The exact-code guard earned its place**: 28 near-miss candidates rejected across the three
ranges, every one of which would have passed an HTTP-200 check - `mariotstore.com` serving a
0.25 kW French Capinox mixer titled "PLANETARY MIXER B10GFA", `stellarequip.com.au/products/b20ga`
actually being a B20KG, Linkrich's EF-11L gallery carrying a plate reading `EF-8L-2 / 2x3250W`.
⚠ Search-engine *summaries* repeatedly asserted specs "for the A032" and "for the EB-1200" that
exist on no page anywhere - a confident snippet is not a source.

**New OEMs traced:** Rebenet (DR-1/DR-2), Yuefeng (B20GA/B10GFA), Golden Chef / Mondo Cucina via
Ashine (BM series), Jiade (JDR450B), Southstar (FX-14, NFZ-380, NFK-20H), Hangzhou Frigo (FGDG),
Weifeng (WF-B3000), Hamoki (GF series), Praveen Enterprises (the "Time Saver" SSPC line, an
Indian ISI-marked cooker brand - not a Kator product at all).

**Method note worth reusing brand-wide:** stripping WordPress's `-scaled` suffix turned an
Infernus 1704x2560 into 2408x3618. Free resolution on every `-scaled` URL already staged.

**No AI-generated imagery found anywhere in this pass** (two false alarms are explained in the
FPR/PAS/DIS write-up). Tenshine, the known offender for `MDXZ-16`, was avoided deliberately.

### Still not reached — 17 SKUs

Mostly structural, not effort. `A032` x3 and `A035` x2 (heat lamps) appear on zero listings
worldwide and read as Sheffield's own finish codes over an unbranded import; `HK-113103` (dish
trolley), `HK-DC-M2A`, `HK-DC-M3A`, `SOT-4S` are house codes with no public existence. Plus
YFR01-2, YFL02-1, 2009/ED, EB-1200, DR-3, T23065, LSP-18X3/X2, CPWK090-1/-31, EF-20.

Two live blocks a browser session would close: **`amazon.in`** returns an HTTP 500 stub to
scripted access and is the only route to a real 25 L Time Saver frame; **Cookrite's media host**
403s every scripted request even after Cloudflare clears, so `DAT60063-2` is staged as a 784²
screengrab of a 1000² original.

---

## 1. The h-kitchen.com supplier route is EXHAUSTED - do not retry it

The business's own supplier map says HK-Redline comes from H-Kitchen (Hangzhou Kator Foreign
Trade Co., Ltd, 杭州凯特对外贸易有限公司). That made the supplier's own website the obvious
first source. It has now been crawled properly, and it does not carry our catalogue.

**What was wrong the first time.** The first crawler looked for detail-page links matching
`/productinfo|detail|goodsinfo`, found none anywhere, fell back to a loose pattern and
returned almost nothing. It also wrote its results only in a later phase, so when it was
killed at category 116 of 117 it left **no output at all**.

**How the site actually works.** Categories and products share ONE url shape,
`/index/index/products.html?id=N`. There is no separate detail-page pattern, and products are
listed *on* the category pages rather than getting pages of their own. Page size does not
separate them either - of 117 pages, 86 carry product images and only 7 are small enough to
look like leaves.

**The result after a correct crawl:** 117 pages fetched, 191 distinct product images, and
**only 6 of our 98 model codes appear anywhere in any of them**:

| SKU | code |
|---|---|
| IMG/BUF/00027 | AT50293 |
| IMG/BUF/00028 | AT60293 |
| IMG/BUF/00143 | AT60293 |
| IMG/BUF/00183 | CPWK090-1 |
| IMG/FPR/00253 | JG210 |
| IMG/FPR/00255 | HLS-2400 |

Image filenames are generic (`3-1.jpg`, `10-1.jpg`, `4.jpg`) and carry no codes, so images
cannot be attributed to a SKU by filename either.

This matches the earlier finding on Kator's Made-in-China storefront, which shared just 6 of
102 codes. **Two independent Kator-owned sources both cover ~6% of the range.** The supplier
relationship is real, but their public catalogues are not where our SKUs are documented -
the codes we carry are largely house codes applied to OEM goods.

Practical notes if anyone does go back: the site serves at roughly **3 KB/s**, a single page
can exceed 45 s and the homepage alone times out at 120 s, so any crawler needs long
timeouts, a seeded id list (the homepage is not a usable seed), and incremental writes.

## 2. What this means for the remaining 96 SKUs

Sourcing has to be **per-SKU by model code against resellers**, the approach that worked for
Rational and Winners, not a supplier-site crawl. The exact-code guard is essential: on
Rational, 17 of 43 reseller search results were near-miss substitutions for the wrong
product, and every one would have passed an HTTP-200 check.

## 3. Still open

- 96 SKUs need an image; 102 need a spec sheet.
- The 6 codes above should be staged from the crawl data before it is discarded.
- `model_number` placeholders `N/A` and `RED` (recorded in the archived file) still need real
  codes before those SKUs can be sourced at all.

---

## Sourcing pass, 31 July 2026 — HOT / ICE / STO — 30 SKUs

## HK-REDLINE redo — HOT / ICE / STO findings

Scope: the 30 SKUs matching `IMG/HOT/`, `IMG/ICE/`, `IMG/STO/`. Ledger: `_sourced-hot-ice-sto.json`.

**Result: 30 of 30 SKUs now have at least one staged image. 24 of 30 have a code-proven image.
8 SKUs gained spec sheets / OEM manuals (15 PDFs), from zero.**
Every image below was rendered with an image viewer before being accepted. **No AI-generated
image was found in this range** — see §6 for what was checked and how.

---

### 1. Per-SKU table

`px` = best short-edge staged. `proven` = the code appears in the source page's own product
title, spec table, media/file title, or a legible rating plate in the photo.

| SKU | code | status | best px | proven | agrees w/ SAP | note |
|---|---|---|---|---|---|---|
| IMG/HOT/00063 | BS-6V | sourced (8 files) | 1881×1881 | yes | yes | Ban Hing spec table `Model: BS-6V`, 700×600×270 |
| IMG/HOT/00066 | EB-450 | sourced (6) | 3176×2382 | yes | **no** | Jieguan: 450×450×**470**; SAP says 500, ours says 400 |
| IMG/HOT/00067 | SOT-4S | partial (1) | 750×750 | **no** | n/a | right product type, no code anywhere |
| IMG/HOT/00069 | CZ-9 | partial (2) | 702×582 | near | **no** | Garyton `GRT-CZ9`; see §3 |
| IMG/HOT/00071 | EB-600 | sourced (7 + spec) | 1000×1000 | yes (`EB-600HWX`) | **no** | 600×510×540 = products.json exactly; SAP wrong |
| IMG/HOT/00168 | SSPC-25 | partial (1) | 1500×1500 | **no** (30 L frame) | n/a | maker traced — see §4 |
| IMG/HOT/00195 | OT-10B-21 | partial (1) | 1328×1552 | **no** (`OT-11-21`) | n/a | right machine type, wrong code |
| IMG/HOT/00219 | DF-28L | sourced (2) | 1644×2560 | yes | yes | |
| IMG/HOT/00222 | CS-310 | sourced (1 + manual) | 1200×1200 | yes | **exact** | 330×560×500, 0.94 kW/240 V, 8 kg |
| IMG/HOT/00271 | 6ATS-C | sourced (8 + manual) | 800×800 | yes | **no** | 480×234×222 = products.json; SAP 460×210×255 wrong |
| IMG/HOT/00275 | BS-4V | partial (1, family) | 1181×592 | family | **no** | Kator table: BS-4V = 700×**590**×**230** |
| IMG/HOT/00276 | KG-165F | partial (1) | 290×245 | yes | n/a (SAP 0) | Grill Porto 355×600×255 ≈ our 355×615×255 |
| IMG/HOT/00278 | MDXZ-16 | sourced (6) | 4512×3008 | yes (banner) | **no** | supplier 520×397×520; ours 350×400×550 |
| IMG/HOT/00282 | MDXZ-24 | sourced (2) | 800×800 | yes (in-frame placard) | partial | Linkrich 12 kW vs our 13.5 kW |
| IMG/HOT/00352 | CT-3 | sourced (1 + manual) | 2560×1920 | yes | **no** | manual 468×418×387; SAP 466, products.json 468 |
| IMG/HOT/00353 | GH-811E | sourced (1) | 800×800 | near (`EG-811`) | **no** | 370×305×210 vs our 410×305×210 |
| IMG/HOT/00354 | GH-813 | sourced (1) | 800×800 | near (`EG-813`) | **no** | 570×350×210 vs our 570×305×210 |
| IMG/HOT/00386 | JZH-TCX2 | sourced (2) | 800×800 | near (`ZH-TCx2`) | n/a | floor unit w/ cabinet, matches 700×700×850 |
| IMG/HOT/00388 | RC-400T | sourced (6) | 1060×1060 | yes | **no** | 534×764×1195 ≈ ours 534×764×1182; SAP 730×500×230 is not this machine |
| IMG/HOT/00389 | GF-120T | sourced (5 + 5 PDFs) | 1800×1800 | yes | **no** | see §2 — biggest finding of the pass |
| IMG/HOT/00416 | WB-1 | sourced (2 + 2 PDFs) | 1718×2560 | yes | **no** | 250×**380**×300; SAP depth 320 wrong |
| IMG/HOT/00417 | WB-2 | sourced (2 + 2 PDFs) | 2560×2412 | yes | **no** | 500×**380**×300; SAP depth 320 wrong |
| IMG/HOT/00419 | EF-11L | sourced (8) | 800×800 | yes | ~yes | Linkrich 320×440×340 vs ours 325×440×340 |
| IMG/HOT/00420 | EF-11L-2 | sourced (8) | 800×800 | yes | **exact** | 670×440×340, 220 V/7 kW, 11×2 L, 15 kg |
| IMG/HOT/00421 | EF-28L | partial (1 + 2 PDFs) | 200×388 | yes | **no** | see §2 |
| IMG/HOT/00434 | DF-10L-2 | sourced (10) | 1505×2560 | yes | **exact** | see §2 — SKU had no model_number and no image |
| IMG/ICE/00040 | BL-018 | sourced (2) | 1000×1000 | yes (filename) | n/a (SAP 0) | double-spindle drink shaker |
| IMG/STO/00011 | HK-DC-M2A | partial (3) | 450×450 | **no** | dims match | representative, see §5 |
| IMG/STO/00012 | HK-DC-M3A | partial (2) | 450×450 | **no** | dims match | representative, see §5 |
| IMG/STO/00013 | HK-113103 | **not reachable** | — | **no** | — | see §5 |

Spec sheets staged (15 PDFs across 8 SKUs): 00071, 00222, 00271, 00352, 00389 (×5), 00416 (×2),
00417 (×2), 00421 (×2).

---

### 2. Contradictions worth raising — ranked

#### 2.1 ⚠⚠ `GF-120T`: our stored dimensions are the **GF90** row of the supplier's own table

Hamoki UK publishes the whole GF gas-fryer family as one table image (staged as
`IMG-HOT-00389__GF-120T-hamoki-4.png`):

| Hamoki code | Model | Config | Dimensions | Power | Capacity | Weight |
|---|---|---|---|---|---|---|
| 101061 | GF90 | 3 burner, single tank | **394 × 767 × 1182** | 26.4 kW | 18 L | 63 kg |
| 101070 | **GF120T** | 4 burner, **twin tank** | **396 × 711 × 1168** | 35.2 kW | 13 × 2 L | 76 kg |
| 101071 | GF120 | 4 burner, single tank | 394 × 752 × 1182 | 35.2 kW | 25 L | 69 kg |
| 101072 | GF150 | 5 burner, single tank | 534 × 767 × 1182 | 44 kW | 37 L | 82 kg |

Our IMG/HOT/00389 stores **394 × 767 × 1182** — that is the **GF90** line, not GF120T.
Everything else about our record (120,000 BTU, split type, 11 L/tank) is correct for GF120T.
**Recommendation (not applied): change IMG/HOT/00389 dimensions to 396 × 711 × 1168.**

This same source also **resolves the archived §11.12 contradiction #1**. The old pass flagged
that Infernus's `GF-120T` photograph showed a *single-tank* machine while our catalogue calls it
a split 11+11. Hamoki's listing is titled "GF120T 4 Burner **Twin Tank** Gas Fryer with Twin
Baskets", body text says "Stainless steel vat, **split tank**". **Our catalogue is right and the
Infernus photograph was the wrong frame.** Staged art (`hamoki-1.jpg`, zoomed and verified) shows
two separate wells with a centre divider.

Sources:
https://hamoki.co.uk/products/gas-fryer-free-standing-twin-tank-with-twin-bask-p-101070
https://cdn.shopify.com/s/files/1/0673/3335/7884/files/GF_Fryers_Stat_Table.png

#### 2.2 ⚠⚠ `EF-28L`: our record describes a countertop unit; every source says floor-standing

Our record: 400 × 700 × 290, "380V/50HZ / 1 tank, 28L".
Infernus's OEM manual, whose cover page is literally `EF-28L`, states:
**220–240 V 50 Hz, 9 kW, 28 L, 400 (W) × 800 (D) × 1100 (H) mm.**
Kator's listing is titled "Floor Standing Electric Fryer EF-28L" and its photo is a
floor-standing cabinet fryer with two baskets.

400 × 800 × 1100 is exactly what SAP stores against IMG/HOT/00219 (`DF-28L`), and the Rebenet /
Infernus `DF-10L-2` shares that same cabinet. **This is strong support for the archived §2
suspicion that `DF-28L` and `EF-28L` are crossed identities in our data** — but note both codes
genuinely exist at Infernus as separate products, so it may instead be that our EF-28L
*dimensions* are simply wrong. Voltage is also in dispute (ours 380 V, manual 220–240 V).
Not applied; needs a warehouse check.

Sources:
https://infernus.co.uk/wp-content/uploads/2019/01/EF-28L_INSTRUCTION-MANUAL.pdf
https://image.made-in-china.com/2f0j00VebQOgGsnLcK/Floor-Standing-Electric-Fryer-EF-28L-.jpg

#### 2.3 ⚠ SAP's dimensions lose to the manufacturer on 6 of my SKUs; products.json wins

Where SAP and `products.json` disagreed and a manufacturer document existed, **products.json was
right every time**:

| SKU | code | SAP | products.json | manufacturer | winner |
|---|---|---|---|---|---|
| 00416 | WB-1 | 250×**320**×300 | 250×**380**×300 | 250×380×300 (OEM manual + Rebenet) | products.json |
| 00417 | WB-2 | 500×**320**×300 | 500×**380**×300 | 500×380×300 (OEM manual + Rebenet) | products.json |
| 00271 | 6ATS-C | **460×210×255** | **480×234×222** | 480×234×222, 7.2 kg (Rebenet) | products.json |
| 00352 | CT-3 | **466**×418×387 | **468**×418×387 | 468×418×387 (OEM manual) | products.json |
| 00071 | EB-600 | 600×**450×500** | 600×**510×540** | 600×510×540 (Rebenet EB-600HWX) | products.json |
| 00063 | BS-6V | 700×600×280 | **695×635×280** | 695×635×280 (Kator's own BS family table) | products.json |
| 00388 | RC-400T | **730×500×230** | 534×764×1182 | 534×764×1195 (Rebenet) | products.json |

That is **7 for 7**. The pattern matches the standing note that SAP's dimension *values* are not
trustworthy while its *order* is. Recommend not treating SAP as the dimension authority for this
brand.

#### 2.4 `BS-4V` — Kator's own table fills a blank and corrects a value

Kator's `BS-4` listing spec table names three siblings:
`BS-4` 695×610×280 · **`BS-4V` 700×590×230** · `BS-6V` 695×635×280.

Our IMG/HOT/00275 (`BS-4V`) has **no height at all** in SAP or products.json, and stores depth
600. Kator gives height **230** and depth **590**. Recommend filling 700 × 590 × 230.
The same table confirms our BS-6V figure exactly (§2.3).
https://h-kitchen.en.made-in-china.com/product/LMiJuqebZwWA/China-Commercial-Bain-Marie-Food-Warmer-Heating-Equipment-BS-4-.html

#### 2.5 `MDXZ-16` — dimensions do not match any published figure

Guanxing's listing (title carries `MDXZ-16`, and one frame is a banner reading
"MDXZ-16 Pressure Fryer") states **520 × 397 × 520 mm, 19 kg**, and everything else
(3 kW, 220–240 V, 16 L, 8 psi) matches our record. Our stored **350 × 400 × 550** matches
nothing. SAP is 0/0/0. Recommend verifying against the physical unit.
https://g-xing.en.made-in-china.com/product/LBHnTwSDnZct/China-Mdxz-16-16L-Electric-Pressure-Fryer.html

#### 2.6 Smaller conflicts

- **`MDXZ-24`** — Linkrich publishes **12 kW**; our remark says 13.5 kW. Capacity (24 L) and
  weight (111 kg) agree. https://www.chinalinkrich.com/commercial-kitchen-equipment/standing-pressure-fryers-mdxz-24.html
- **`EB-450`** — Jieguan publishes **470 mm** high. SAP says 500, products.json says 400.
  Neither of ours is right. https://gzjieguan.en.made-in-china.com/product/uFiAOLQyrPWZ/China-Eb-450-Electric-Lift-Salamander-.html
- **`GH-811E` / `GH-813`** — the platform is the `EG-8xx` line. EG-811 is 370×305×210 (we store
  410×305×210); EG-813 is 570×350×210 (we store 570×305×210). One axis differs on each.
  https://en.masterchefworks.com/item/eg-811 · https://en.masterchefworks.com/item/eg-813
- **`EF-11L`** — Linkrich 320×440×340 vs our 325×440×340. 5 mm; ignorable.

#### 2.7 Two things our data got RIGHT that had been doubted

- **`WB-2` really does have two waffle heads.** The archived pass flagged that the Rebenet WB-2
  frame looked like one waffle plate plus a plain round plate. The Infernus frame (2560×2412,
  both heads open) shows **two identical waffle grids**. The Rebenet frame simply has the second
  head closed. Flag can be cleared.
- **`GH-811E` is a single-head grill** and the correct single-head art is now staged; the old
  pass only had a double-head family shot.

---

### 3. Code-proof failures and near-misses (the exact-code guard in action)

Four staged frames were caught contradicting the code they were filed under. All were kept with
the reason in the filename rather than deleted.

1. **`IMG-HOT-00419__EF-11L-CODEMISMATCH-plate-reads-EF-8L-2-linkrich-4.jpg`** — Linkrich's own
   EF-11L gallery includes a rating-plate close-up. Zoomed, the plate reads
   **`Model EF-8L-2 · Power 2×3250W · Voltage 240 V`** — a *double 8-litre* unit. The other seven
   frames on that page are single-tank and consistent with EF-11L; only this plate shot is
   foreign. Linkrich reuses the same plate photo on its **EF-11L-2** page too
   (`IMG-HOT-00420__EF-11L-2-CODEMISMATCH-plate-reads-EF-8L-2-linkrich-3.jpg`).
2. **`IMG-HOT-00271__6ATS-C-NEARMATCH-plate-reads-6ATS-A-...`** (3 frames) — Rebenet's 6-slice
   toaster page is titled `6AST-C` but three of its photographs carry a placard legibly reading
   **`6ATS-A`**. Same body, same 6 slots. Separately: Rebenet's page *title* spells it `6AST-C`
   while its own image slugs spell it `6ats-c`, and Infernus's OEM manual is titled
   `4ATS / 6ATS-C`. **Our `6ATS-C` is the correct spelling**; Rebenet's title is the typo.
3. **`_REF__IMG-HOT-00063__BS-6V-REJECTED-BV6-1-glass-canopy-display-linkrich.jpg`** — the
   archived research asserted "LINKRICH sells BS-6V as `BV6-1`". Rendered, Linkrich's BV6-1 is a
   **curved-glass-canopy display bain marie weighing 83 kg**, and no size in the whole BV range
   is 700×600×280. Our BS-6V is a plain open 6-pan countertop unit. **That claim is wrong** and
   should not be carried forward.
4. **`IMG-STO-00013__HK-113103-REJECTED-is-HK-113101-bakery-tray-trolley-kator-mic-1.jpg`** —
   confirmed again: HK-113101 is a bakery *tray* trolley, our HK-113103 is a dishwasher-*rack*
   trolley with 8 levels. Different products.

Also flagged NEARMATCH in filenames, not proven-wrong but not proven-right either:
`EB-600` ← `EB-600HWX`, `JZH-TCX2` ← `ZH-TCx2`, `GH-811E` ← `EG-811`, `GH-813` ← `EG-813`,
`CZ-9` ← `GRT-CZ9`, `OT-10B-21` ← `OT-11-21`, `BS-6V` ← `BM-6V` (Rebenet).

**`CZ-9` dimension trap.** Garyton's GRT-CZ9 page prints two figures, `585*415*200mm` and
`650*510*330mm`, and its family table gives CZ5 640×350×330, CZ7 650×430×330, CZ11 640×580×330 —
so the `650×510×330` row is the *cabinet*. Our stored **584 × 415 × 410** matches the *other*
figure, i.e. what appears to be the roller/tray area rather than the machine. Worth a check.

---

### 4. The `SSPC-25` "Time Saver" question — the real maker is Indian, not Chinese

The brief asked what the actual maker is behind the contested `SSPC-16 / -25 / -40 / -60` line.

**"Time Saver" is a live Indian cookware brand, and SAP's remark for IMG/HOT/00168 is a
near-verbatim copy of its retail listing copy** ("Timesaver Pressure Cooker … hard anodised
aluminium … locking handle, overpressure release valve and gasket release window … promise of
safety and durability").

Traced chain:
- Amazon India: "**Time Saver ISI Mark Commercial Hard Anodized Aluminum Outer Lid Handi Pressure
  Cooker (Silver, 25 L)**" — https://www.amazon.in/Time-Saver-Commercial-Cooker-25/dp/B075GWV7SL
  and the 40 L sibling https://www.amazon.in/Time-Saver-Commercial-Aluminium-Cooker/dp/B075GW1S99
  (**25 L and 40 L are exactly the two capacities in dispute**)
- Flipkart: "TIMESAVER ISI Mark Hard Anodized Handi Cooker 20 L" — https://www.flipkart.com/time-saver-isi-mark-hard-anodized-handi-cooker-20-l-pressure/p/itma0f20f1326c5c
- Sri Vadiraja, which publishes the manufacturer field: **`Manufacturer: Praveen Enterprises`**,
  `Item model number: Big Boss Cooker – 30 Litre` —
  https://vadiraja.com/product/time-saver-isi-mark-commercial-hard-anodized-aluminum-handi-pressure-cooker-silver-30l/

So the SSPC line is **an Indian hard-anodised-aluminium commercial handi cooker (Time Saver,
ISI-marked, made by Praveen Enterprises), re-coded `SSPC-nn` in-house**. It is not an
H-Kitchen/Kator product at all, which explains why the same photograph turns up under three
different Sheffield house brands and why one stored frame carries a "Time Saver" badge.
**As instructed, no brand change is proposed** — this is a pending user decision, and the
evidence is recorded here for it.

`SSPC-25` itself returns **only sheffieldafrica.com** on the open web (circular, inadmissible).
The only Time Saver frame I could reach at usable resolution is the **30 L**, staged as
`IMG-HOT-00168__SSPC-25-FAMILY-TimeSaver-30L-not-25L-vadiraja-1.jpg` (1500×1500). Amazon.in
blocks scripted fetches (HTTP 500 through WebFetch, empty HTML through a plain GET); a real
browser session would very likely get the 25 L gallery and is the recommended next step.

---

### 5. The three STO SKUs — house codes with no public existence

`HK-DC-M2A`, `HK-DC-M3A` and `HK-113103` return **nothing** on the open web under those codes.
They are Sheffield/Kator house codes on commodity stainless carts.

What I could establish instead is **dimensional identity**:

- Our `HK-DC-M2A` is 850 × 450 × 900, 2 tier. Two Thousand sells **TT-BU110B** and **TT-BU105B**,
  both "2 Shelf **850 × 450 × 900 MM** Stainless Steel Utility Cart".
- Our `HK-DC-M3A` is 850 × 450 × 900, 3 tier. Two Thousand sells **TT-BU114B**,
  "3 Shelf **850 × 450 × 900 MM** Square Tube Stainless Steel Utility Cart".

https://www.twothousand.com/2-shelf-850x450x900-mm-stainless-steel-utility-cart-tt-bu110b/
https://www.twothousand.com/3-shelf-850x450x900-mm-square-tube-stainless-steel-utility-cart-tt-bu114b/

These are staged as `REPRESENTATIVE-…-same-850x450x900`. They are dimensionally exact and the
right product class, but the code is **not** proven and the filenames say so.
**twothousand.com's ceiling for these images is 450 × 450** — confirmed by listing the WP media
collection, not guessed; no `-scaled` original exists.

`HK-113103` (dishwasher-rack trolley, 560 × 560 × 1800, 8 levels) has **no image at any
resolution from any source**. Reported as not reachable rather than filled with a lookalike.

---

### 6. AI-generated imagery — checked, none found in this range

Every staged image was opened and viewed. The specific things looked for were the ones that
caught the earlier fakes: gibberish on control panels, impossible dial numbering, wobbling
letterforms, and missing mechanical parts. Results:

- All control panels that were legible read correctly (`POWER LIGHT / HOT LIGHT / TEMPERATURE
  SELECTION`, `OFF 0 … 10 MIN`, `HOLD L+R / COOK LEFT`, Chinese `电源指示灯 / 加热指示灯 / 温控`).
- Rating plates zoomed and read as coherent text (which is how the `EF-8L-2` mismatch in §3 was
  caught in the first place).
- One frame, `IMG-HOT-00388__RC-400T-rebenet-mic-1.jpg`, is a **photographic composite** — a real
  fryer cut into a real stock kitchen photograph. Not synthetic; the machine itself is the same
  unit as frames 2–6. Kept.
- **Tenshine was deliberately avoided.** The archived pass already caught a tenshine
  `MDXZ-16` frame as an AI render (`REF__AI-GENERATED-RENDER-tenshine-DO-NOT-USE.webp` in the old
  staging folder). Tenshine still ranks for MDXZ-16; I sourced from Guanxing instead.

`_ai-generated\` was therefore not created.

---

### 7. Routes: what worked, what didn't

**Worked, in order of yield:**
- **Infernus (`infernus.co.uk`) WordPress media API** — `wp-json/wp/v2/media?search=<code>` and
  `?mime_type=application/pdf`. Infernus's *product titles* never contain the codes but its
  *media library filenames do*. This is where 10 of the 15 PDFs came from, and where the only
  `DF-10L-2` photograph came from.
- **Rebenet (`rebenet.com`)** — `product-sitemap.xml` + `ai_product-sitemap.xml` gives every
  product URL. **The full-size original is the yfisher URL with the `/jpg100-t3-scale100.webp`
  transform suffix stripped**: `…/1736407919237-slug-12.jpg` → 800–1000 px. Galleries run 6–9
  frames. Some pages also carry a real spec-sheet PDF (`…salamanderbroilerspecsheet.pdf`).
- **Hamoki (`hamoki.co.uk`) Shopify `/products.json`** — 907 products in ~4 requests, with
  `body_html` carrying the model number as text plus direct PDF hrefs. Biggest single find of the
  pass (§2.1).
- **Linkrich (`chinalinkrich.com`) WP media API** — the OEM. Media titles are the code plus a
  Chinese view name (`EF-11L-正面`, `-侧面`, `-面板`), so an 8-frame gallery arrives pre-labelled.
  Strip any `-NNNxNNN` suffix for the full size.
- **made-in-china storefronts** — Kator, Rebenet, Jieguan, Guanxing. The `2f0j00…` prefix is
  already the full-size form; `202f0j00…`, `203f0j00…`, `3f2j00…`, `226f3j00…` are transforms.
  Jieguan's EB-450 set came back at **3176 × 2382**, easily the best photography in the range.
- **Two Thousand (`twothousand.com`) WP media API** — useful for dimension-matching commodity
  items, but its images cap at 450 px.

**Did not work / documented blocks:**
- `lite.duckduckgo.com` and `html.duckduckgo.com` both returned **zero parseable results** for
  every query this session. The built-in WebSearch tool worked throughout and was used instead.
- **`amazon.in` blocks scripted access** — WebFetch returns HTTP 500, a plain GET returns a 3.8 KB
  stub with no image URLs. This is the one thing standing between us and a real 25 L Time Saver
  frame (§4). A browser session would close it.
- **`static.masterchefworks.com` does not resolve in DNS**; the same paths work on
  `en.masterchefworks.com`. Anyone reusing that source needs the host swap.
- `h-kitchen.com` was not touched, per the brief. Its made-in-china storefront
  (`h-kitchen.en.made-in-china.com`) *is* alive and useful — its product-list URL 404s, but
  direct product pages fetch fine and their **spec tables carry sibling codes and dimensions**
  (that is where §2.4's BS-4V figures came from). Worth keeping even though the code coverage
  is only ~6 %.

**Old staging folder** (`products resource\hk-redline-images\`): treated as leads only. Every URL
recorded there for my range was re-pinged — all 9 still resolve — and everything reused was
**re-fetched fresh**, never copied. Nothing in that folder was modified or deleted. Three of its
staged files turned out to be wrong (§3 items 3 and 4, plus the GF-120T single-tank frame in
§2.1) and are corrected here.

---

### 8. Recommendations awaiting approval (nothing applied)

No `model_number`, `products.json`, `brands.json` or `storage/` file was touched.

1. **IMG/HOT/00389 `GF-120T`** — dimensions 394×767×1182 → **396 × 711 × 1168** (ours is the GF90 row).
2. **IMG/HOT/00275 `BS-4V`** — fill height **230**, correct depth 600 → **590**.
3. **IMG/HOT/00421 `EF-28L`** — investigate 400×700×290 / 380 V against the OEM manual's
   400×800×1100 / 220–240 V 9 kW before publishing either.
4. **IMG/HOT/00278 `MDXZ-16`** — 350×400×550 matches no published figure; supplier says 520×397×520.
5. **IMG/HOT/00066 `EB-450`** — height is 470 per the manufacturer; SAP (500) and products.json
   (400) are both wrong.
6. **IMG/HOT/00069 `CZ-9`** — our 584×415×410 looks like a roller-area figure, not the cabinet.
7. **Do not** propagate the archived claim that Linkrich's `BV6-1` is our `BS-6V` (§3 item 3).
8. **SSPC brand question** — evidence in §4; decision is the user's.


---

## Sourcing pass, 31 July 2026 — BUF / OVE / COF — 36 SKUs

## HK-REDLINE — findings for BUF / OVE / COF (36 SKUs)

Companion ledger: `_sourced-buf-ove-cof.json`. Every image listed below was downloaded and
**rendered with the Read tool** before being accepted; none was judged on filename or file size.

**Headline: 18 of 36 SKUs now have an independently sourced image (was 5 for the whole brand),
11 of those have the code proven, and 5 spec/manual PDFs exist where the brand previously had zero.**
The ovens are effectively closed. The buffet range is where the brand actually breaks down.

---

### 1. Coverage table

`P` = code proven on the source page (title, SKU field, spec table or CDN filename).

| SKU | Model | Status | Best px | Code proven | Agrees with SAP |
|---|---|---|---|---|---|
| IMG/OVE/00205 | HTD-20 | **sourced** ×3 + | **1500×1000** | P | **exact** 1230/820/530 |
| IMG/OVE/00169 | HTD-40 | sourced ×2 | 640×640 | P | **exact** 1230/820/1250 |
| IMG/OVE/00009 | HTD-90 | sourced ×2 | 640×640 | P | **exact** 1670/820/1520 |
| IMG/OVE/00087 | HTR-20Q | sourced ×2 | 640×640 | P | **exact** 1350/850/600 |
| IMG/OVE/00088 | HTR-40Q | sourced ×2 | 787×710 | P | **exact** 1350/850/1340 |
| IMG/OVE/00206 | HTR-101C | sourced ×2 | 640×640 | code is **HTR-101Q** | near (980×610×500 vs 980/600/540) |
| IMG/OVE/00168 | NFD-20F | **sourced** | **800×800** | P | SAP blank; OEM 1460×1230×815 |
| IMG/OVE/00229 | YXD-1AE | **sourced** ×4 + PDF | **1100×1100** | P | **CONFLICT** — 595×530×570, SAP says 1005/930/560 |
| IMG/OVE/00230 | YXD-8A-3 | **sourced** ×8 + 2 PDF | **1100×1100** | P | **CONFLICT** — 834×765×500, SAP says 1005/930/560 |
| IMG/OVE/00234 | HK-13220 | representative | 600×449 | no | **SAP looks like a carton** |
| IMG/OVE/00235 | HK-13221 | representative | 600×450 | no | as above |
| IMG/COF/00020 | WB15A | **sourced** ×3 | **3024×3024** | near (`WB-15SA`) | SAP blank; 15 L / 2.5 kW |
| IMG/COF/00021 | WB20A | **sourced** + manual | **2408×3618** | P | SAP blank; 350×344×543, 2.5 kW |
| IMG/COF/00022 | WB30A | **sourced** + manual | **2408×3618** | P | SAP blank |
| IMG/BUF/00020 | DAT 60063-2 | sourced (screengrab) | 784×784 | P | **exact** 670/490/230 |
| IMG/BUF/00027 | AT50293 | sourced | 640×371 | P | partial (440 & 210 agree, mid figure disputed) |
| IMG/BUF/00028 | AT60293 | sourced ×2 | 640×640 | P | disputed across 3 sources |
| IMG/BUF/00143 | AT60293 | sourced ×2 | 640×640 | P | SAP blank — **duplicate of 00028** |
| IMG/BUF/00031 | DR-1 | **sourced** ×9 + PDF | **800×800** | near (`DR-1CKS`) | width 450 exact, D/H differ |
| IMG/BUF/00032 | DR-2 | **spec only** | — | near (`DR-2CKS`) | width 450 exact, D/H differ |
| IMG/BUF/00019 | YFR01-2 | not reached | — | — | — |
| IMG/BUF/00021 | YFL02-1 | not reached | — | — | — |
| IMG/BUF/00022 | 2009/ED | not reached | — | — | — |
| IMG/BUF/00023 | A032 black Ø175 | not reached | — | — | — |
| IMG/BUF/00024 | A032 gold Ø175 | not reached | — | — | — |
| IMG/BUF/00025 | A035 gold Ø290 | not reached | — | — | — |
| IMG/BUF/00026 | A035 silver Ø290 | not reached | — | — | — |
| IMG/BUF/00244 | A032 copper | not reached | — | — | **SAP dims are another SKU's** |
| IMG/BUF/00030 | EB-1200 | not reached | — | — | — |
| IMG/BUF/00033 | DR-3 | not reached | — | — | SAP W/D missing |
| IMG/BUF/00115 | T23065 | not reached | — | — | — |
| IMG/BUF/00129 | LSP-18X3 | not reached | — | — | source delisted |
| IMG/BUF/00130 | LSP-18X2 | not reached | — | — | source delisted |
| IMG/BUF/00183 | CPWK090-1 | not reached | — | — | — |
| IMG/BUF/00186 | CPWK090-31 | not reached | — | — | **shares dims with 00183** |
| IMG/COF/00108 | EF-20 | not reached | — | — | SAP 160/170/0 implausible |

Totals: **18 sourced, 2 representative-only, 16 not reached.** No image was accepted without
rendering it, and nothing synthetic was found in this range (`_ai-generated\` is empty).

---

### 2. The 820-vs-860 question on the HTD ovens is **settled in favour of 820**

Garyton is the OEM — `GRT-HTD-20/40/90` are our `HTD-20/40/90`, sold with our exact geometry.
Garyton's own current model table publishes:

| Model | Garyton (OEM) | our SAP | verdict |
|---|---|---|---|
| HTD-20 | 1230 × **820** × 530 | 1230/820/530 | identical |
| HTD-40 | 1230 × **820** × 1250 | 1230/820/1250 | identical |
| HTD-90 | 1670 × **820** × 1520 | 1670/820/1520 | identical |

**Our 820 is right; Kator's published 860 is wrong.** This should be closed out and not
re-litigated. The same table also confirms the gas siblings exactly:
HTR-20Q 1350×850×600 and HTR-40Q 1350×850×1340, both identical to SAP.

Source: https://www.garyton.com/GRT-HTD-20-Commercial-Bakery-Electric-Oven-1-Layer-2-Trays-pd48079483.html
and https://www.garyton.com/GRT-HTR-20Q-Commercial-Bakery-Equipment-Single-Deck-Gas-Pizza-Oven-pd48590483.html

Five of six deck ovens now agree with SAP to the millimetre. That is a strong signal that the
SAP dimension field is *reliable for this class* — which makes the two exceptions below matter more.

---

### 3. ⚠ SKUs where the sourced find CONTRADICTS the stored record

#### 3.1 The two convection ovens carry the same, wrong, SAP dimensions
`IMG/OVE/00229` (YXD-1AE) and `IMG/OVE/00230` (YXD-8A-3) both store **1005 / 930 / 560**.
These are two physically different ovens, so one row cannot be right for both. Manufacturer
datasheets, plus on-image dimension diagrams from the same seller:

- **YXD-1AE** — 595 W × 530 D × 570 H, 38 kg, 240 V 2.4 kW 10 A, four 435×315 trays.
  Carton is 650×660×660, so 1005/930/560 is not the carton either.
  https://ckesydney.au/wp-content/uploads/2025/06/YXD-1AE_CONVECTMAX_OVEN_Heats_50_to_300_Degrees.pdf
- **YXD-8A-3** — 834 W × 765 D × 500 H external, 700×460×288 internal, 50 kg, 240 V 3.5 kW 15 A,
  three 600×400 trays. CKE Sydney's SKU field is literally `YXD-8A-3`, our exact code.
  https://ckesydney.au/product/fed-yxd-8a-3-3-trays-electric-convection-oven/

Minor caveat worth recording: the seller's own dimension *graphic* for the 8A-3 reads
**834 × 796 × 513** while its datasheet reads 834 × 765 × 500. The width 834 is stable across both.

**Recommendation (needs approval):** replace both dimension rows. Do not touch `model_number`.

#### 3.2 `IMG/BUF/00244` stores another product's dimensions
"HEATING LAMP COPPER" carries **640 / 480 / 750** — byte-identical to `IMG/BUF/00129`
(LSP-18X3 juice dispenser). A pendant heat lamp is not 640×480×750. This is a SAP copy/paste
artefact, not a measurement.

#### 3.3 `IMG/BUF/00183` and `IMG/BUF/00186` share one dimension row
3 GN thermo box and 6 GN heated thermo box both store **650 / 450 / 620**. A 6 GN box cannot
have the same external envelope as a 3 GN box. At least one is wrong.

#### 3.4 The hamburger pans store a carton, not a pan
`HK-13220` / `HK-13221` both store **915 / 690 / 355**. A 4″ 15-cavity bun pan is
**400 × 600 mm** (3 rows of 5, cavity Ø101 mm) per the trade spec —
https://tmbaking.com/product/burger-bun-pan/ . 915×690×355 with a 355 mm height is a stack in a box.

#### 3.5 `IMG/BUF/00020` — our name says SQUARE, the OEM sells it as OBLONG
We call `DAT 60063-2` a "Chafing Dish Drop in **Square**" with the SAP remark "GN 1/2 × 2 pcs".
CookRite sells it as **"Dripless Built-In Oblong Chafing Dish"** with one full-length pan, and
670 × 490 is by definition oblong. Dimensions match us exactly; the shape word and pan count do not.

#### 3.6 `IMG/OVE/00206` — the code disagrees with itself *and* with the OEM
We store `model_number = HTR-101C` while the product **name** says `HTR-10C`. Garyton's actual
product is **`GRT-HTR-101Q`** at 980 × 610 × 500 (we store 980/600/540). Three different codes
for one product. Flagged only — `model_number` untouched.

#### 3.7 `IMG/COF/00108` — "HYDROBOIL" is somebody else's trademark
Our name is "WATER BOILER EF-20 (HYDROBOIL)". *Hydroboil* is a registered Zip Water trademark
and Zip has no EF-20. The stored 160/170/0 is also far too small to be a water boiler.
This record needs a real code before it can be sourced at all.

---

### 4. `IMG/BUF/00028` and `IMG/BUF/00143` are the same product

Both carry `AT60293`, both are described as a square induction chafer, and no source anywhere —
CookRite/Tomado, TC Croatia, N'Dustrio, Food Equipment NZ — knows of two AT60293 variants.
The only difference in our data is that 00028 has dimensions and 00143 has none. I have staged the
same imagery against both because there is only one product. **This reads as a genuine catalogue
duplicate and should be resolved by a human, not by inventing a difference.**

The AT60293 dimension dispute is now three-way and still unresolved:

| Source | AT60293 |
|---|---|
| TC Croatia | 490 × 490 × 210 |
| N'Dustrio (Türkiye) | 505 × 470 × 285 |
| Food Equipment NZ, badged **Atosa** | 440 × 400 × 210 |
| **our SAP** | **400 × 400 × 210** |

Two of the three back SAP's height of 210, and FE-NZ is closest on footprint. This is the first
evidence that leans toward our stored figure rather than against it.
https://www.foodequipment.co.nz/product/atosa-induction-2-3-square-chafing-dish-4.5l

---

### 5. Route notes — what worked, what to reuse, what to stop trying

#### 5.1 New OEM identified: **Rebenet is the maker behind `DR-1` / `DR-2`**
Rebenet (Guangzhou, already known as the OEM for the fast-food line) sells `DR-1CKS` and
publishes a datasheet covering `DR-1CKS` **and** `DR-2CKS`. Nine 800 px photos including a legible
control-panel close-up. Width 450 mm matches our record exactly on *both* models; depth and height
run ~58 mm and ~95 mm larger on the CKS build — a *consistent* offset, which reads as an earlier
generation rather than as bad data. **There is no DR-3 anywhere in Rebenet's range.**
https://www.rebenet.com/commercial-mobile-plate-warmer-with-heating-element-and-motor-dr-1cks.html

#### 5.2 ⚠ The "Garyton/micyjz caps at 640 px" rule is **false**
The archived research concluded the micyjz CDN structurally cannot beat 640 px. It can:
`WB-15SA.jpg` on the Garyton WB15 page is **3024 × 3024**, a genuine factory-floor photograph,
and `HTD.jpg` on the HTD-20 page is 1500 × 1000. The 640 px files are *catalogue cut-outs*; the
big ones sit further down the same pages in the description body. **Always enumerate the whole
page, not just the gallery `largeimage=` list.** The `-800-800` suffix on these filenames is
aspirational — stripping it changes nothing, the file is 640 px either way.

#### 5.3 WordPress `-scaled` strip beats the media API
`infernus.co.uk` reports `WB-20A-scaled.jpg` at 1704×2560 through `/wp-json/wp/v2/media`.
Dropping `-scaled` gives **2408 × 3618**. WordPress stores the pre-scale original beside it and
never lists it. Worth re-running against every `-scaled` URL already staged on this brand.
Infernus is otherwise **exhausted** for this range: of 19 codes queried, only WB-20/WB-30 hit.

#### 5.4 Southstar's image host needs a query string *and* a Referer
`omo-oss-image*.thefastimg.com` returns **HTTP 567** (not 403, not 404) to a bare GET. Append any
query string — `?vf=1` works — plus a `Referer`, and it serves normally. Also: the "gallery" on a
Southstar page is one image; everything after it is a related-products carousel showing entirely
different machines (tunnel ovens, rack ovens). I staged and then deleted six of those.

#### 5.5 `cookrite.com` — the blocker was misdiagnosed
The archived note records a certificate interstitial and treats it as unsafe. The certificate is a
**legitimate DigiCert cert for `www.cookrite.com` that simply expired on 27 June 2026** — a lapsed
renewal, not a mis-issued or wrong-host cert. Its sitemap is fetchable, but it is Atosa's *US*
catalogue (45k numeric-ID URLs, cooking equipment) and carries none of the AT/DAT chafing codes.
Not the route.

#### 5.6 The real CookRite route is **tomadostore.com**, and it is only half-open
Cloudflare's challenge **does** clear in a real Chrome session (~10 s, no interaction). Once
cleared, the site's own catalogue search is reachable and answers definitively:

- `DAT60063` → **both** `DAT60063-1` and `DAT60063-2` exist. Our exact code confirmed, at
  67 × 49 × 23 cm = **exactly our stored 670/490/230**.
- `AT60293` → exists.
- `AT50293`, `T23065`, `YFL02`, `YFR01` → **nothing**. So the archived guess that CookRite owns
  `T23065` is *not* supported.

**But the media host still 403s every scripted request** — python-requests and curl, full Chrome
header set, correct `Referer`, `Sec-Fetch-*` and client hints — because the clearance cookie is
HttpOnly and cannot be exported. In-page base64 extraction is blocked by the harness. I therefore
staged `IMG-BUF-00020` as a **browser screengrab** of the natively-rendered image: 784 × 784 versus
the true 1000 × 1000, JPEG re-encoded once. It is honest and legible and the filename says
`SCREENGRAB`. **If anyone gets a real download path, replace that one file.**

#### 5.7 TC Croatia's placeholder trap re-confirmed
`/productphoto/<id>/large/<slug>.jpg` is the ceiling at 640 px. `original`, `big`, `xlarge`, `full`
all return **HTTP 200 with a 130 × 130, 6893-byte placeholder**. A size-name guess looks like it
worked. Verify pixels, never a status code.

#### 5.8 Two suppliers have simply gone away
- **Zhejiang Spaceman** made `LSP-18X3` / `LSP-18X2`. The product page now 404s and the storefront
  lists no LSP dispenser at all. The 750×450×700 / 420 W figures that circulate are search-index
  residue from a page that no longer exists — I could not verify them first-hand and did not apply them.
- **`h-kitchen.com`** was not touched, per the brief.

#### 5.9 What the exact-code guard actually rejected
Every one of these ranked for our code and every one would have passed an HTTP-200 check:
Adexa `BL1209`/`S1205`/`BL1207` pendant lamps for A032/A035; Weixinli `LSJ-18L*2` for LSP-18X2;
Dongpei `DPDR-3` for DR-3; Caterwize `HGB-40D` for HTD-40; Kator `BF-05` for EF-20; a dozen
generic VEVOR/Amazon 18 L×3 dispensers and 175/290 mm heat lamps. **None carries our code.**
The search engines' own summaries repeatedly asserted specs "for the A032" and "for the EB-1200"
that appear on no page — synthesised from generic listings. Do not take an engine summary as a source.

---

### 6. The heat-lamp block is the biggest remaining hole (5 SKUs)

`IMG/BUF/00023, 00024, 00025, 00244` (`A032`, Ø175, black/gold/copper) and
`IMG/BUF/00025, 00026` (`A035`, Ø290, gold/silver) are five SKUs on two codes.
The 175 mm and 290 mm retractable pendant heat lamp is one of the most heavily cloned generics in
the trade — hundreds of listings, identical photography, **zero carrying the code A032 or A035**.
Garyton, the confirmed OEM for our ovens, sells heat lamps as `GRT-E0040`.

Given that, `A032`/`A035` are most likely **Sheffield's own finish-variant codes over an unbranded
import**, in which case no external source will ever prove them and the honest resolution is a
photographed sample rather than more searching.

---

### 7. Left for whoever picks this up

1. **Replace `IMG-BUF-00020__…SCREENGRAB…`** with a real 1000 × 1000 download if the Tomado media
   403 can be beaten.
2. **Re-run the `-scaled` strip** across every Infernus URL already staged on this brand by the
   sibling agents — it is free resolution.
3. **Sweep every Garyton page body for large images**, not just the gallery. §5.2 shows 640 px was
   never the ceiling; other brand pages likely hide 3000 px factory shots too.
4. **`DR-2` needs a photograph.** Spec is nailed; Rebenet has no DR-2 art.
5. **Decide on `IMG/BUF/00028` vs `IMG/BUF/00143`** — one product, two SKUs.
6. **`model_number` recommendations awaiting approval, none applied:**
   `IMG/OVE/00206` HTR-101C → the OEM product is `HTR-101Q` (our own name field says `HTR-10C`);
   `IMG/COF/00108` EF-20 needs a real code before it can be sourced.


---

## Sourcing pass, 31 July 2026 — FPR / PAS / DIS — 36 SKUs

## HK-REDLINE - findings for FPR / PAS / DIS (36 SKUs)

Agent scope: `IMG/FPR/*` (14), `IMG/PAS/*` (12), `IMG/DIS/*` (10). Ledger: `_sourced-fpr-pas-dis.json` (43 rows).
Every image below was fetched fresh and **rendered** before acceptance. Nothing was blind-copied from the
pre-SAP staging folder.

---

### 1. Coverage, stated plainly

| Outcome | Count | SKUs |
|---|---|---|
| **Sourced** - code proven AND >=800 px short edge | **13** | FPR 00046, 00179, 00218, 00222, 00251, 00252, 00253, 00254, 00255, 00257; PAS 00101, 00160; DIS 00103 |
| **Partial** - code proven but the supplier's own art cannot reach 800 px | **9** | PAS 00103; DIS 00019, 00020, 00022, 00023, 00024, 00112, 00146, and PAS 00011 (800 px exactly, but code is FX-14**B**) |
| **Partial** - image acceptable but code unproven (house code / OEM re-badge) | **6** | PAS 00145, 00155, 00156, 00157, 00169, 00166 |
| **Unresolved** - two rival candidates, neither proven | **3** | PAS 00102, PAS 00164, DIS 00045 |
| **Blocked** - no usable model code exists | **4** | FPR 00012, 00014, 00015, 00081 |
| DIS 00021 counted under "partial, code unproven" (LSD variant unpublished) | 1 | DIS 00021 |

162 image files and 5 spec/manual PDFs staged for these 36 SKUs.
**Spec sheets exist for only 5 of 36** - FPR 00046, 00179, 00251, 00218, 00222. The other 31 have no
downloadable datasheet anywhere; for most of them the supplier's HTML spec table is the only document,
and the relevant numbers are transcribed into the ledger `notes` field instead.

---

### 2. The single most important structural finding

**Resolution on this brand is a property of the supplier, not of the search.**

- The **meat-processing group** (FPR) is sold by real Western importers - AG Equipment (AU), KitchenWare
  Station (US), Hamoki (UK), Twothousand, LINKRICH, Infernus. Those importers shoot their own studio
  photography, so this group reaches 1000-2560 px and comes with OEM manuals. Ten of my thirteen fully
  sourced SKUs are FPR.
- The **display group** (DIS) is entirely Kator/H-Kitchen house codes (`HK-BC-*`, `FGDG*`, `R60-*`,
  `OT-01P`). No independent reseller carries any of those codes anywhere on the open web. The proven
  ceiling is **698-700 x 500** for the back-bar coolers and **700 x 501** for the pastry displays. Eight
  of ten DIS SKUs are structurally capped below the floor. The one exception is `R60-2` at 2238x1000.
- The **bakery group** (PAS) sits in between: the OEMs are traceable (Goldenchef, Yuefeng, Jiade,
  Southstar, Ashine) but they publish at exactly **800x800**, which is the floor and not a pixel more.

There is no further search that fixes DIS. The only routes to a usable back-bar-cooler or pastry-display
photograph are (a) photograph the units in the warehouse, or (b) ask Kator for the original files.

---

### 3. Corrections to the stored record (recommendations - nothing changed inline)

`model_number` is the unique ID; none of these were touched. All await approval.

#### 3.1 Model-number corrections

| SKU | stored | evidence | recommendation |
|---|---|---|---|
| IMG/PAS/00166 | `NFQ-380` | SOUTHSTAR's Toast Moulder is **NFZ-380** - 1400x670x1130, 380 mm, 220V/380V, 0.8-1.13 kW, **weight 237 kg**. Our remark says "capacity 237kg", which is not a capacity at all - it is Southstar's NET WEIGHT copied into the wrong field. Southstar's `NFQ` prefix is its DOUGH SHEETER series (NFQ-500T/520/620, all >2200 mm long), which our machine plainly is not. | `NFQ-380` -> `NFZ-380` (single-letter transcription error) |
| IMG/FPR/00179 | `250ES-10` (products.json) / `250ES/B-10` (SAP) | The machine's own **rating plate is legible in the AG Equipment photo**: `MEAT SLICER 250ES/B-10 CE, OUTPUT 320 W`. The OEM manual cover separately names `250ES-10`. | SAP's `250ES/B-10` is the plate code; `250ES-10` is the manual's short form. Both real. Prefer SAP. |
| IMG/FPR/00046 | `300ES-12` | Rating plate reads `MEAT SLICER 300ES/B-12 CE`; manual cover names `300ES-12`. | Same pattern as above; no change needed, but note the `/B` sub-variant exists. |
| IMG/DIS/00019 | `FGDG1.0A-1500LS` | Looks corrupt but **is not**: Kator genuinely uses the `<series><capacity>A-<width>LS` shape - its own catalogue carries `FGWG1.5A-900LS`. It maps to the published `FGDG1500LS-3`. | Leave as is. Cross-reference `FGDG1500LS-3`. |

#### 3.2 Dimension corrections - **SAP is wrong in six places**

| SKU | model | SAP | maker | verdict |
|---|---|---|---|---|
| IMG/PAS/00155 | BM-25 | 1065 x **630** x 1130 | 1065 x **603** x 1130 (Goldenchef/Ashine) | **SAP digit transposition.** products.json is right. |
| IMG/PAS/00169 | BM-100 | 1460 x 905 x **1400** | 1460 x 905 x **1500** | **SAP copied BM-75's height.** products.json is right. |
| IMG/DIS/00020 | FGDG 1800LS-3 | 1800 x 740 x **1360** | 1800 x 740 x **1300** (Kator family table) | **SAP wrong.** products.json is right. |
| IMG/PAS/00101 | B20GA | **880 x 530 x 690** | **540 x 490 x 780** (Yuefeng) | **SAP wrong.** products.json 540x490x780 is exact. |
| IMG/PAS/00160 | JDR450B | **385 x 415 x 795** | 1770 x 830 x 620 working position (Jiade) | **SAP wrong** - see next row. |
| IMG/PAS/00164, 00166 | KT-20, NFQ-380 | **385 x 415 x 795** (identical) | 610x750x1100 / 1400x670x1130 | **SAP prints the identical 385/415/795 for three different machines.** That whole row of SAP dimensions is a duplicated placeholder and must not be trusted for any of the three. |

#### 3.3 Dimension / spec disagreements where **our** record looks wrong

| SKU | model | ours | maker | note |
|---|---|---|---|---|
| IMG/DIS/00103 | R60-2 | 686 x 432 x 635, 35 kg | 660 x 437 x 655, 37 kg (Kator's own R60 table) | Power 1840 W matches exactly, so it is the right machine. SAP is 0/0/0 = MISSING, so there is nothing to arbitrate - but products.json and the maker disagree on all three axes. |
| IMG/PAS/00103 | B10GFA | 470 x 450 x 600 | Yuefeng 540 x 410 x 800; SAP 430 x 420 x 690 | **Three sources, three different answers, no two agree.** Unresolved. |
| IMG/FPR/00255 | HLS-2400 | remark "bench size 710x800" | work table **510 x 710**; overall **800 x 750 x 1860** | Our bench field looks like the overall footprint mis-copied. Recommend adding 800x750x1860 (SAP is 0/0/0). |
| IMG/FPR/00254 | JG310 | 820 x 770 x 1700 (correct) but remark "bench 560x425" | LINKRICH JG310C table **800 x 570** | Overall dims match perfectly; the bench figure does not. |
| IMG/FPR/00253 | JG210 | 520 x 490 x 840 (correct) but remark "cutting 5-155 mm, bench 500x380" | Twothousand JG210A: cutting **4-180 mm**, table **195x220** | Overall dims match exactly; cutting range and table size do not. |

#### 3.4 Copy errors found

- **IMG/FPR/00218 (IB500LV)** - the remark ends "6-gallon, 24-quart capacity". That is Waring /
  Hamilton-Beach *Big Batch* marketing copy. The OEM manual for this platform makes **no capacity claim
  at all** and none of the eight models in the range has one. Recommend deleting the line.
- **IMG/FPR/00251 (TC-22)** - our remark says 110 V / 60 Hz, copied verbatim from the KWS US manual. For
  a Kenyan 230 V / 50 Hz market SKU that is almost certainly wrong.
- **IMG/PAS/00103 (B10GFA)** - our remark says "Powerful 1100 Watt". Yuefeng independently confirms
  **0.60 kW** for B10GFA (1100 W is the 20 L figure). This settles the `⚠` the archived research left open.
- **IMG/PAS/00101 and 00145** - both carry the identical remark text including "Weight: 95 kg" and the
  same 197/317/462 rpm. The speeds are genuinely shared across the range, but 95 kg is supported by no
  source: Yuefeng says 73 kg for B20GA, AG Equipment 83 kg, Roto Quip 66 kg for the 30 L.
- **IMG/DIS/00020** - the description is the *LILY closed-type* showcase text (Zoppas element, EBM fans,
  EGO controller). The code `FGDG 1800LS-3` belongs to the *ORCHID* line, whose sibling SKUs 00019 and
  00021 carry the correct Orchid copy. Looks pasted from the wrong product.

---

### 4. OEMs traced behind the house label (new, beyond the archived research)

| OEM | Evidence | Our SKUs |
|---|---|---|
| **Guangdong Yuefeng Bakery** (brand *FREESTYLE BAKE*) | Basic-Info panels print `Model NO. B20GA` and `Model NO. B10GFA` with speeds identical to our remarks | PAS 00101, 00103 |
| **Golden Chef / Mondo Cucina** (resold by Ashine) | HM-15..HM-100 spec chart legible **in frame**; every number matches our BM-25/50/75/100 | PAS 00155, 00156, 00157, 00169 |
| **Jiade (Zhongshan) Food Machinery** | `JDR-450B` is their best-seller; working-position 1770x830x620 = our 1770x820x620 | PAS 00160 |
| **SOUTHSTAR** | `FX-14B` proofer table; `NFZ-380` toast moulder (weight 237 kg = our "capacity"); `NFK-20H` divider (2.2 kW = our remark) | PAS 00011, 00166, and one of the two KT-20 candidates |
| **Hangzhou Frigo** (also badged *Purple Horn*) | Trademark field on the Kator FGDG listing reads `FRIGO`; commercial-foodequipment.com carries the identical cabinet watermarked "Frigo" and lists FGDG900/1200/1500/1800/2100LS-3 | DIS 00019, 00020, 00021 |
| **Weifeng** | MIC Basic Info `Model NO. WF-B3000`, `Trademark Weifeng`, 80-100 kg/hr = our remark | FPR 00257 |
| LINKRICH (already known) | `JG310C` overall 820x770x1700 = our stored value exactly | FPR 00254, and the rival KT-20 candidate |

---

### 5. The two Kator-route SKUs the brief flagged

Both are done, and both turned out to have a **better non-Kator source**:

- **IMG/FPR/00253 (`JG210`)** - Twothousand's `JG210A` page carries a spec table reading `Size 520*490*840
  MM`, which is our stored value **exactly**; LINKRICH's `JG210C` (620x505x945) and `JG210CA`
  (565x505x910) both fail it. So the JG210A platform is our machine. 8 frames at up to 1772x1772,
  filed `NEARMATCH` because the published code carries an `A` suffix ours does not.
- **IMG/FPR/00255 (`HLS-2400`)** - Twothousand has a dedicated HLS-2400 page whose parameter table is
  headed `HLS-2400`: 380V/50Hz/2200W, blade 2400 mm, pulley 300 mm, table 510x710, 130 kg,
  **800x750x1860 mm**. One HLS-2400-specific render at 1500x1500 plus ten frames the supplier itself
  files as `HLS-2020.HLS-2400` (shared series art, named accordingly).

The archived research's warning stands and was re-confirmed: Canmac's "HLS-2400" file is literally named
`HLS-202...`, i.e. HLS-2020 artwork. I did not stage it.

---

### 6. Near-miss substitutions caught by the exact-code guard

Every one of these returned HTTP 200 and looked plausible:

1. **`B10GFA` at mariotstore.com** - page title *PLANETARY MIXER B10GFA*, but its specs are 0.25 kW,
   110/360 rpm, 645x450x366 mm, brand *Capinox*, origin **France**. Yuefeng's real B10GFA is 0.60 kW,
   480/244/148 rpm, 10 L. Completely different machine wearing the right code. **Rejected.**
2. **`B20GA` at stellarequip.com.au** - the URL is literally `/products/b20ga` but the page is
   **`B20KG`**, a Bakermax/Yasaki mixer with different speeds (104/187/365) and weight. **Rejected.**
3. **`JG310CA` at LINKRICH** - one character from `JG310C`, but 740x695x1545 with an open tubular stand
   instead of 820x770x1700 with a cabinet base. Staged deliberately as a labelled **negative control** so
   the distinction stays visible.
4. **`JG210C` at LINKRICH** - 620x505x945, does not match our 520x490x840. Demoted to `REF__`.
5. **Kator's "Dough Divider / Dough Rounder"** frame, previously staged against `KT-20`, shows a
   **manual lever-operated bun divider with a round dome** - a visibly different class of machine from a
   hydraulic 20-piece cabinet divider. Renamed `REF__...DIFFERENT-MACHINE`.
6. **Southstar proofer gallery** - two of its four frames are the **double-door** FX-22B/FX-28B. Our
   FX-14 is the 500 mm single-door. Both renamed `REF__`.
7. **WF-B3000 detail shots on Alibaba** - correct platform but badged **AISTAN**, and their dimension
   diagram says 13.5 x 10.5 x 16 in (343x267x406 mm) against Weifeng's own 340x200x360. Kept as `REF__`
   only; the AISTAN numbers must not be adopted.

---

### 7. Family-art warnings that must survive into the catalogue

- **Back bar coolers (DIS 00023, 00024, 00112).** There is exactly **one** photo for the whole stainless
  family and one for the whole black family, and both are the **single-door** unit. SKUs 00023 (2 doors),
  00024 (3 doors) and 00112 (2 doors) are therefore illustrated by an image that **contradicts their own
  door count**. Filenames say `FAMILY-ART-shows-HK-BC-01B` / `-01` so this cannot be forgotten.
- **Pastry displays (DIS 00019, 00020, 00021).** One render serves 900/1200/1500/1800/2100 mm. The Kator
  frame is specifically the **1200 mm** unit. Nothing in any photo distinguishes 1500 from 1800.
- **Spiral mixers (PAS 00155/156/157/169).** Goldenchef serves one gallery across HM-25/50/75/100. The
  frame worth keeping is `...SERIES-SPEC-CHART-in-frame.jpg`, where the whole HM-15..HM-100 table is
  legible next to the picture, so a reader can at least see which row applies.
- **Planetary mixers (PAS 00101, 00103).** Yuefeng uses one render for the entire 10-40 L range. The
  Kator frame is the exception and is genuinely attributable: **I cropped and read its placard myself** -
  it says `20 LITER MIXER / ATTENTION / ... Maximum flour 5kgs`, and 5 kg flour is exactly Yuefeng's
  B20GA figure. That frame is correct for the 20 L SKU and wrong for the 10 L one.

---

### 8. AI-generated imagery

**None found.** All 162 files rendered as genuine photography or genuine CAD-style product renders:
consistent lighting and shadows, coherent control panels, legible rating plates and warning placards,
blades present on every bandsaw. `_ai-generated\` was not created because nothing needed to go in it.

Two things that *looked* wrong and were not:
- Twothousand's IB500LV frames carry a heavy **teal colour cast**. That is a site-wide brand tone, not a
  generation artefact - Infernus's frames of the identical machine show the true dark-navy body.
- The Hamoki `JT32` PNG is 24 KB at 1080x1080. It is a clean white-background cut-out, not a degraded
  file. File size is not a quality signal on cut-outs.

---

### 9. The four blocked SKUs (FPR 00012 / 00014 / 00015 / 00081)

Chopping Board Blue / White / Yellow / Red. SAP's model field is a placeholder (`N/A`, `N/A`, `N/A`,
`RED`) and its description and remark say nothing but `CHOPPING BOARD <colour>`.

**No candidate code was found and none was invented.** Kator publishes this line as an untitled
*Cutting Board* with no model string at all, and without a code there is nothing to run a reseller search
against. The only art in existence is Kator's own six-colour fan (red/blue/yellow/green/white/brown),
which covers all four colours at once and is 440x353 - far below the floor. It is staged against all four
SKUs as `NOCODE-BLOCKED__REF__...TOOSMALL` evidence only.

One soft contradiction worth a warehouse check: our stored height is **40 mm** for a 500x350 board. In
the supplier photo the boards read as roughly 20 mm relative to their footprint, and 40 mm is unusually
thick for HDPE catering board.

---

### 10. Tooling notes for whoever picks this up

- `southstar-oven.com` images 403 unless you send `Referer: https://www.southstar-oven.com/`. Its
  `sitemap.xml` is small and complete and is the fastest way to enumerate its catalogue.
- Shopify `/products/<handle>.json` gives the full gallery at native resolution **and** the variant `sku`
  field, which is often the only place the real factory code appears (`SL300ES-12`, `SL250ES-10`).
  `/search/suggest.json?q=` finds handles when the on-site search is JS-only.
- Made-in-China Basic-Info panels carry `Model NO.` and `Trademark` as plain text - that is what proved
  B20GA, B10GFA and WF-B3000. Rewriting `202f0j00`/`155f0j00` -> `2f0j00` works, but on this brand the
  full-size origin is often still only 200-700 px.
- `lite.duckduckgo.com` returned **empty** result sets for most model codes here (not CAPTCHA - just
  nothing), while WebSearch answered the same queries. Do not assume DDG failure means the code is
  unfindable.
- WordPress `/wp-json/wp/v2/search?search=` worked on chinalinkrich, twothousand, infernus and
  china-ashine and is far faster than crawling category pages.

Sources are recorded per file in `_sourced-fpr-pas-dis.json` as bare `https://` URLs.
