# Product image assignments — running log

Every image assigned from a link supplied by the user is recorded here: what was assigned,
to which SKU, from where, and what it replaced. Newest entries at the bottom.

## Conventions

- **Main image** → file written to `storage/app/public/products/`, `image` field set to
  `products/<slug>-<sku-lowercased-no-slashes>.<ext>`
- **Gallery** → `storage/app/public/products/gallery/`, `gallery[]` entries
  `products/gallery/<slug>-<sku>-N.<ext>`
- `public/storage` is a symlink to `storage/app/public`, so no copy step is needed.
- `<slug>` follows the existing pattern: kebab-cased product name, then the SKU with slashes
  stripped and lowercased — e.g. `IMG/DIS/00090` → `…-imgdis00090.jpg`.

## Rules applied to every incoming image

1. **Rendered and viewed before assignment.** Two suppliers in this catalogue have served
   AI-generated product photos that passed every automated heuristic, and one was the
   highest-resolution asset on its page. Nothing is assigned unseen.
2. **Checked against the record** — right model, right door/zone/compartment count, right
   finish, right capacity. Mismatches are reported, not assigned.
3. **The replaced file is kept on disk**, never deleted, and named in the log below so any
   assignment can be reversed.
4. **`model_number`, `name` and `status` are never touched** by an image assignment.
   Renaming a product changes its URL (`ProductSeeder.php` builds the slug from name + SKU).

## Log

| date | SKU | model | source | file written | replaced | notes |
|---|---|---|---|---|---|---|
| 2026-08-04 | IMG/FPR/00164 | TK-22 | `IMG-FPR-00164__TK-22-astarkitchen-1.jpg` | `products/meat-grinder-22-model-tk-22-imgfpr00164.jpg` | `…-imgfpr00164.webp` (kept) | 1200², benchtop #22 grinder, on/off+reverse — matches record |
| 2026-08-04 | IMG/FPR/00177 | S-QC205 | `IMG-FPR-00177__QC205A-NEARMATCH-astarkitchen-1.jpg` | `products/vegetable-processor-s-qc205-imgfpr00177.jpg` | `…-superseded-20260804.jpg` | 1200². ⚠ NEARMATCH: code `QC205A` vs our `S-QC205`; also filed under KITCHENWARE as `IMG/FPR/00239` |
| 2026-08-04 | IMG/FPR/00178 | TC-42 | `IMG-FPR-00178__TC-42A-NEARMATCH-astarkitchen-1.jpg` | `products/meat-grinder-42-model-tc-42-imgfpr00178.jpg` | `…-imgfpr00178.webp` (kept) | 1200², floor grinder on castors — matches. ⚠ NEARMATCH `TC-42A` vs `TC-42` |
| 2026-08-04 | IMG/FPR/00180 | TB-10L | `IMG-FPR-00180__EV-10L-CODEMISMATCH-astarkitchen-1.jpg` | `products/electric-sausage-stuffer-imgfpr00180.jpg` | `…-superseded-20260804.jpg` | 1200², vertical stuffer + foot pedal. ⚠ CODEMISMATCH: Astar publishes `EV-10L`, we store `TB-10L` |
| 2026-08-04 | IMG/FPR/00181 | SXW-280 | `IMG-FPR-00181__SXW-280-sieuthihaiminh-7.jpg` | `products/meatball-making-machine-imgfpr00181.jpg` | `…-imgfpr00181.webp` (kept) | 1200², meatball former — matches. Rating plate reads Foshan Libaoda, not Astar |
| 2026-08-04 | IMG/FPR/00184 | 130 | `IMG-FPR-00184__ASY-130-NEARMATCH-astarkitchen-1.jpg` | `products/manual-hamburger-press-130-imgfpr00184.jpg` | `…-imgfpr00184.jpeg` (kept) | 1200², manual patty press — matches. ⚠ NEARMATCH `ASY-130` vs bare `130` |

| 2026-08-04 | IMG/DIS/00090 | FG-1200LS | `IMG-DIS-00090__AL-1200B-CODEMISMATCH-astarkitchen-1.jpg` | `products/pastry-showcase-square-1200-fg-1200ls-imgdis00090.jpg` | old .jpg **deleted** | 1200², white **square-glass** cabinet, 2 shelves + deck. ⚠ CODEMISMATCH `AL-1200B` vs `FG-1200LS` |
| 2026-08-04 | IMG/DIS/00090 | FG-1200LS | `…astarkitchen-1 (1).jpg` | `products/gallery/…-imgdis00090-1.jpg` | old gallery img **deleted** | styled twin of the hero. ⚠ the replaced gallery image was **curved glass** (AL-1200A shape) — wrong for a "Right angle" record |
| 2026-08-04 | IMG/HOT/00304 | GH-538 | `IMG-HOT-00304__GH-538-jieguan-1.jpg` (2nd version) | `products/pasta-cooker-gas-gh-538-imghot00304.jpg` | 1st version **overwritten** | 1200², **table-top** single-well gas cooker, 6 baskets, Jieguan logo on fascia — matches the 400×650×480 / 17.5 kg record. The first file supplied was a floor-standing 2-well cabinet and was rejected |

### Not assigned — kept as evidence

- **`IMG/DIS/00090`** third candidate `…astarkitchen-1 (2).jpg` — a **black cabinet with
  3 shelves + deck and narrower proportions**, i.e. a different model. Copied to
  `products resorce final\astar\_brand-reference\IMG-DIS-00090__REJECTED-black-3shelf-different-model.jpg`.

| 2026-08-04 | IMG/FPR/00184 | 130 | `…ASY-130-NEARMATCH-astarkitchen-1 (1).jpg` | `products/manual-hamburger-press-130-imgfpr00184.jpg` | previous .jpg **overwritten** | 1200², 2nd version of the patty press. User directed this to the **primary**, overriding the `(n)`=gallery rule |
| 2026-08-04 | IMG/HOT/00186 | SE40/OCB | `IMG-HOT-00186__SE40-OCB-baron-1.jpg` | `products/salamander-electric-baron-se40ocb-imghot00186.jpg` | previous .jpg **overwritten** | 1200², electric salamander — rise/fall element housing, ribbed grate, single knob. ⚠ Baron publishes the code with a **digit zero** (`SE40/0CB`), proven 11 ways; our record and name both carry the letter O |
| 2026-08-04 | IMG/HOT/00304 | GH-538 | `IMG-HOT-00304__GH-538-jieguan-1.jpg` (3rd version) | `products/pasta-cooker-gas-gh-538-imghot00304.jpg` | 2nd version **overwritten** | 1200², same table-top Jieguan machine, cleaner render (86.9 KB vs 65.6 KB) |

| 2026-08-04 | IMG/HOT/00189 | DI7FRE415 | `IMG-HOT-00189__DI7FRE415-baron-1.jpg` | `products/single-well-electric-fryer-15-ltr-table-top-baron-di7fre415-imghot00189.jpg` | previous .jpg **overwritten** | 1200², single-well electric fryer, 1 basket, chrome knob, drain tap. ⚠ It is a **DROP-IN** unit (mounting flange, recessed body) while our name says **"Table Top"** — see note below |

| 2026-08-04 | IMG/COF/00001 | (variable parent) | `IMG-COF-00001__WU-CH-20L-berjayacke-REF-3.jpg` | `products/heated-water-urn-with-concealed-element-berjaya-imgcof00001.jpg` | both variant images **deleted** | 1200², genuine BERJAYA-badged concealed-element urn. Set on the **parent**; `image` key removed from both children per instruction |

| 2026-08-04 | IMG/DIS/00001 | BJY-4GDC78L-A | `…berjayacke-2.jpg` | `products/pastry-display-four-glass-berjaya-imgdis00001.jpg` | overwritten | 1200², 4-sided glass display chiller, **BERJAYA** wordmark on the base |
| 2026-08-04 | IMG/HYS/00179 | BJY-IK30A | `…berjayacke-1.jpg` | `products/insect-killer-berjaya-ik30-imghys00179.jpg` | overwritten | 1200², **BERJAYA**-badged insect killer, 2 UV tubes |
| 2026-08-04 | IMG/TCW/00086 | FP 1/3-2.5 | `…gn-1-3-65mm-pan-buphex-1.jpg` | `products/gn-container-13-65-berjaya-imgtcw00086.jpg` | overwritten | elongated 1/3 footprint, shallow (65 mm) — `REPRESENTATIVE` |
| 2026-08-04 | IMG/TCW/00087 | FP 1/4-2.5 | `…gn-1-4-65mm-pan-buphex-1.jpg` | `products/gn-container-14-65-berjaya-imgtcw00087.jpg` | overwritten | shallow 1/4 — `REPRESENTATIVE` |
| 2026-08-04 | IMG/TCW/00089 | FP 1/1-4 | `…gn-1-1-100mm-pan-buphex-1.jpg` | `products/gn-container-11-100-berjaya-imgtcw00089.jpg` | overwritten | large, deep (100 mm) — `REPRESENTATIVE` |
| 2026-08-04 | IMG/TCW/00090 | FP 1/2-4 | `…gn-1-2-100mm-pan-buphex-1.jpg` | `products/gn-container-12-100-berjaya-imgtcw00090.jpg` | overwritten | **squarest of the set (1.23) — 1/2 verified by eye**, deep |
| 2026-08-04 | IMG/TCW/00091 | FP 1/3-4 | `…gn-1-3-100mm-pan-buphex-1.jpg` | `products/gn-container-13-100-berjaya-imgtcw00091.jpg` | overwritten | 1/3 footprint, visibly deeper than 00086 — `REPRESENTATIVE` |
| 2026-08-04 | IMG/TCW/00097 | FP 1/1C | `…gn-1-1-lid-changing-1.jpg` | `products/gn-lids-11-berjaya-imgtcw00097.jpg` | overwritten | GN lid, recessed handle — `REPRESENTATIVE` |
| 2026-08-04 | IMG/TCW/00098 | FP 1/2C | `…gn-1-2-lid-changing-1.jpg` | `products/gn-lids-12-berjaya-imgtcw00098.jpg` | overwritten | **squarest lid — 1/2 verified by eye** |
| 2026-08-04 | IMG/TCW/00099 | FP 1/3C | `…gn-1-3-lid-changing-1.jpg` | `products/gn-lids-13-berjaya-imgtcw00099.jpg` | overwritten | **most elongated lid — 1/3 verified by eye** |
| 2026-08-04 | IMG/TCW/00100 | FP 1/4C | `…gn-1-4-lid-changing-1.jpg` | `products/gn-lids-14-berjaya-imgtcw00100.jpg` | overwritten | GN lid — `REPRESENTATIVE` |
| 2026-08-04 | IMG/TCW/00102 | FP 1/9C | `…gn-1-9-lid-changing-1.jpg` | `products/gn-lids-19-berjaya-imgtcw00102.jpg` | overwritten | GN lid — `REPRESENTATIVE` |

| 2026-08-04 | IMG/HYS/00001 | BLGHWBK | `IMG-HYS-00001__6005202-bilgemutfak-1.jpg` (1st) | `products/hand-wash-basin-knee-operated-bilge-imghys00001.jpg` | overwritten | 1200², knee-operated basin, **EMPERO badge in frame** — superseded below, but kept as evidence |
| 2026-08-04 | IMG/HYS/00001 | BLGHWBK | `IMG-HYS-00001__6005202-bilgemutfak-1.jpg` (2nd) | same path | 1st version overwritten | 1200², knee-operated basin, **grey knee push-pad**, rear upstand, **no badge** — superseded by the 3rd |
| 2026-08-04 | IMG/HYS/00001 | BLGHWBK | `IMG-HYS-00001__6005202-bilgemutfak-1.jpg` (3rd, **current**) | same path | 2nd version overwritten | 1200², same unbadged machine, cleaner render, larger in frame (62.4 KB vs 55.0 KB) |

| 2026-08-04 | IMG/TCW/00103 | 1/1*65 -P | `IMG-TCW-00103__6005649-bilgemutfak-1.jpg` | `products/gn-container-perforated-11-65-bilge-imgtcw00103.jpg` | overwritten | 1200², perforated 1/1, **shallow (65 mm)**, base-only perforation |
| 2026-08-04 | IMG/TCW/00104 | 1/1*100 - P | `IMG-TCW-00104__6005576-bilgemutfak-1.jpg` | `products/gn-container-perforated-11-100-bilge-imgtcw00104.jpg` | overwritten | 1200², perforated 1/1, **deep (100 mm)**, base + extensive wall perforation |
| 2026-08-04 | IMG/TCW/00104 | 1/1*100 - P | `…bilgemutfak-1 (1).jpg` | `products/gallery/gn-container-perforated-11-100-bilge-imgtcw00104-1.jpg` | — (new gallery) | second angle, same pan |
| 2026-08-04 | IMG/TCW/00105 | 1/2*100 -P | `IMG-TCW-00105__6005580-bilgemutfak-1.jpg` | `products/gn-container-perforated-12-100-bilge-imgtcw00105.jpg` | overwritten | 1200², perforated **1/2 — squarest of the set**, deep |
| 2026-08-04 | IMG/TCW/00105 | 1/2*100 -P | `…bilgemutfak-1 (1).jpg` | `products/gallery/gn-container-perforated-12-100-bilge-imgtcw00105-1.jpg` | — (new gallery) | second angle, same pan |

| 2026-08-04 | IMG/TCW/00106 | 1/1*65 | `IMG-TCW-00106__6005637-bilgemutfak-1.jpg` (2 versions; 2nd is current) | `products/gn-container-1-1-65-bilge-imgtcw00106.jpg` | overwritten twice | 1200², **solid** (non-perforated) GN 1/1; 2nd version is larger in frame (77.7 KB vs 67.1 KB). ✅ Both carry burnt-in dimension callouts **53 × 32.5 × 6.5 cm**, matching the record's 530/325/65 **exactly** — the image corroborates the data |

### ✅ Bilge solid GN range — 16 SKUs assigned 2026-08-04, all dimension-verified

`IMG/TCW/` `00107 00108 00110 00111 00112 00113 00114 00115 00116 00117 00118 00119 00120 00121
00122 00124` — the solid (non-perforated) GN range, fractions 1/1 → 1/9 at depths 65/100/150/200.
Sources `IMG-TCW-000NN__<article>-bilgemutfak-1.jpg`, all 1200², all overwriting existing
filenames so `products.json` was unchanged.

⭐ **Every one carries burnt-in dimension callouts, and all 16 match their stored dimensions
exactly.** This is the first batch where the imagery independently *verifies* the data rather
than merely illustrating it — 16 records confirmed in one pass. Two of them (`00111`, `00117`)
additionally carry a legible **`GN 1/9-65`** / **`GN 1/9-100`** stamp on the rim, which is
direct product-code confirmation.

⚠ Perceptual check before assignment found **0 duplicate pairs across all 16** — important on a
range where one photo serving many sizes is the standard failure mode.

⚠ These carry burnt-in callouts while other Bilge SKUs (e.g. the perforated pans) do not — a
presentation inconsistency across the brand, not a correctness problem. Worth a decision if
visual consistency matters.

⚠ **Note on the two Bilge perforated 1/1 pans**: `00103` (65 mm) and `00104` (100 mm) share the
same footprint and differ only in depth — but their perforation patterns differ too (`00103` is
perforated on the base only, `00104` on base *and* side walls), which makes them independently
distinguishable in a photograph. Verified distinct.

New `gallery` keys were inserted **immediately after `image`**, matching the catalogue's existing
key order (see `IMG/FPR/00042`).

### ⚠⚠ `IMG/HYS/00001` — the image proves the brand attribution is wrong

The assigned photo, taken from Bilge's own site under **their** article `6005202`, carries an
**EMPERO** wordmark on the front panel. That is direct visual confirmation of a finding the
research had already reached on documentary grounds: **the knee-operated basin filed under
BILGE is an EMPERO product**, and `brand: BILGE` is a *distributor* attribution, not a
manufacturer one. EMPERO is a separate live brand in this catalogue.

Supporting evidence already on file: the Empero part number is **`EMP.DKE.002`**, 400 × 400 ×
**220** mm, **6 kg** — our stored dimensions are 400/400/220, an exact match. (The Bilgeinox
printed catalogue's 260 mm height stands alone against bilgemutfak *and* the whole Empero
chain at 220.)

**Nothing changed** — `brand` and `model_number` (`BLGHWBK`) are untouched. This is a pending
business decision, and it is now as well-evidenced as it can get without asking the supplier.

⚠ The live image was subsequently replaced with an **unbadged** frame (grey knee push-pad, rear
upstand) at the user's direction. The EMPERO-badged photograph is therefore no longer on the
storefront, but it is preserved as evidence at
`products resorce final\bilge\_brand-reference\IMG-HYS-00001__6005202-EMPERO-BADGE-EVIDENCE-bilgemutfak.jpg`.
**The brand finding stands on that file, not on the live image.**

### ✅ The Berjaya GN duplicate defect is FIXED, 2026-08-04

The ten `IMG/TCW/…` GN pan and lid SKUs previously shared **6 images between them** — the defect
the user spotted. All ten now carry a **distinct per-size photograph**: verified 0 shared photos
by 16×16 ahash + 256×256 RMS, where the same test found 6 clusters before.

**What is and is not verified.** The pans differentiate cleanly by eye — `00090` is the squarest
(1/2), `00086`/`00091` share the elongated 1/3 footprint with `00091` visibly deeper (100 vs
65 mm), `00087` is the shallow 1/4 and `00089` the large deep 1/1. On the lids only **1/2 and
1/3** are decidable, because **EN 631 gives 1/1, 1/4 and 1/9 the same 1.63 aspect ratio** — those
three rest on the source's labelling, which is attestation rather than proof. All are tagged
`REPRESENTATIVE`: correct-size generic GN ware, not Berjaya-badged, which is the honest tier
given Berjaya publishes no per-size GN photography.

| 2026-08-04 | IMG/PAS/00001 | BJY-BM20 | `…BJY-BM10-singmah-REF-3.jpg` (filename typo) | `products/cake-mixer-planetary-20-litres-berjaya-imgpas00001.jpg` | overwritten | 1200², planetary mixer. ⚠ Filename said `BM10`; **user confirmed it is the BM20** — a naming slip, not a wrong image. `REF`/representative, and the badge in frame reads **KALSI**, not Berjaya |

### ✅ `IMG/COF/00001` — variant images consolidated onto the parent, 2026-08-04

`IMG/COF/00001` is a **variable parent** ("Heated Water Urn with Concealed Element Berjaya")
with two children — `IMG/COF/00001` (`WU-CH-30L`, default) and `IMG/COF/00002` (`WU-CH-40L`).
All three carried separate images. Per instruction the image now lives **only on the parent**
and the `image` key was removed from both children.

Safe to do: `ProductSeeder.php` reads `$variantData['image'] ?? null`, and **14 of the 49
variant children in the catalogue already carry no image**.

The parent's image file was renamed to match the parent's own name, which has **no capacity
in it** (`…-30-litres-berjaya-…` → `…-berjaya-…`). Both old per-capacity files were deleted
after confirming nothing else referenced them.

⚠ **The supplied file is named `WU-CH-20L`** yet its sight gauge is graduated to ~35, so it is
probably not a 20 L unit. As a *family* image on a capacity-less parent this does not matter;
it would matter if it were ever pushed down onto a specific variant. Related open finding:
Berjaya publishes **one photo for the whole WU-CH range**, and the frame previously live here
was captioned `WU-CH-50L`.

### ✅ `IMG/HOT/00186` — code corrected 2026-08-04 (approved)

`SE40/OCB` (letter O) → **`SE40/0CB`** (digit zero), on both `model_number` and `name`.
Baron publishes the digit **eleven independent ways** — `Modello`, `Codice`, `CODE`, `Model`,
`mpn`, four datasheet pages, six datasheet filenames, the `.dwg`, the press `.jpg` and the AU
distributor sheet — and it is a digit **by construction**, `/0` being Baron's "bench-top, no
base" series suffix (siblings `SE60/0CB`, `SE80/0`).

⚠ Corroboration found while applying: `description`, `meta_description` and
`technical_specification` **already carried the digit zero**. Only `name` and `model_number`
had been left on the letter O, because they were held pending approval.

⚠ **The product URL changed.** `ProductSeeder.php:371` builds the slug as
`Str::slug($name.' '.$sku)`, so the slug moves from `…-se40-ocb-…` to `…-se40-0cb-…`.
The image file was renamed to match the convention
(`…-se40ocb-…` → `…-se400cb-…`) and the `image` field updated with it.

### ⚠ `IMG/HOT/00189` — the name contradicts the product

The assigned image shows a **drop-in / built-in** fryer designed to be recessed into a
countertop cutout. Our product name says **"Table Top"**. Three things agree with drop-in:

- Baron's `DI` prefix reads as **D**rop-**I**n (cf. the `SE40/**0**CB` suffix, where `/0`
  is Baron's "bench-top, no base" marker — a different series entirely).
- Our stored height is **340 mm**, which suits a recessed unit; a free-standing bench fryer
  is far taller. The earlier Baron pass found **SAP's 498 mm wrong against Baron's 340**.
- The photograph itself has no feet and an exposed underside/frame.

**The image is right; the name looks wrong.**

**DECIDED 2026-08-04: the name stays as "Table Top"; only the image was updated.** Recorded
here so the discrepancy is not rediscovered and "corrected" later. If it is ever revisited,
note that changing the name would move the product URL.

### ✅ Blueline / Forcar-Forcold re-wrap — 5 primaries replaced 2026-08-04

Five images supplied already re-wrapped: **1200 × 1200 RGB, product centred on white with even
padding**. They replace frames that carried the same or a related shot with inconsistent framing.
Every target filename and extension is unchanged, so **`products.json` was not edited** — only the
bytes on disk. Sources deleted from Downloads.

| SKU | model_number | source file | written to | replaced |
|---|---|---|---|---|
| IMG/REF/00194 | SNACK2100TN-1200 | `IMG-REF-00194__SNACK2100TN-1200-NEARMATCH-SNACK2100TN-forcar-1.jpg` | `products/2-door-counter-chiller-1200x600x860-snack2100tn-1200-imgref00194.jpg` | overwritten (was the same Forcar 2-door, 1500², looser crop) |
| IMG/REF/00195 | SNACK2100TN-1500 | `IMG-REF-00195__SNACK2100TN-1500-NEARMATCH-SNACK2100TN-forcar-2.jpg` | `products/2-door-counter-chiller-1500x600x860-snack2100tn-1500-imgref00195.jpg` | overwritten (same as above) |
| IMG/REF/00196 | SNACK4100TN | `IMG-REF-00196__SNACK4100TN-forcar-1.jpg` | `products/4-door-counter-chiller-2230x600x860-snack4100tn-imgref00196.jpg` | overwritten — **the old primary was a Forcold-badged white-door 4-door**; the new one is Forcar-badged, consistent with 00194/00195 |
| IMG/DIS/00069 | VRX1500/80 FG | `IMG-DIS-00069__VRX1500-80-FG-CODEMISMATCH-VRX1500-380FG-forcold-1.jpg` | `products/refrigerated-pizza-display-vrx1500380-fg-imgdis00069.jpg` | overwritten (same Forcold 6-pan topping unit, re-wrapped) |
| IMG/DIS/00137 | VRX1800/380 FG | `IMG-DIS-00137__VRX1800-380-FG-forcold-1.jpg` | `products/refrigerated-pizza-display-vrx1800380-fg-imgdis00137.jpg` | overwritten (same Forcold 8-pan topping unit, re-wrapped) |

Pan counts check out against the codes: `VRX1500` shows **6** GN wells, `VRX1800` shows **8** —
consistent with the 300 mm-per-well step between a 1500 and an 1800 mm topping unit, so these two
are not interchanged. Door counts likewise match the names (2 / 2 / 4).

⚠ **`IMG/REF/00194` and `IMG/REF/00195` carry the same photograph** — 16×16 ahash Hamming distance
**0**, differing only by JPEG re-encode (different MD5, identical 71 632 bytes). This is expected
rather than an error: both filenames are tagged `NEARMATCH-SNACK2100TN`, and Forcar publishes one
photo for the whole SNACK2100TN range; the 1200 and 1500 are the same 2-door cabinet in two
lengths. But it does leave a shared photo under two code-asserting filenames — see
`feedback_one_photo_many_skus`. Nothing in the frame reads as 1200 or 1500, so **neither file can
be used as evidence of that SKU's length.**

⚠ **`IMG/DIS/00069`'s `model_number` is `VRX1500/80 FG` while its `name` says `VRX1500/380 FG`** —
the filename flags it `CODEMISMATCH`. Every sibling uses the `/380` depth suffix (cf.
`IMG/DIS/00137` = `VRX1800/380 FG`), so the `model_number` is missing its `3`. **Not changed** —
`model_number` is the unique ID and needs approval. Left here for that decision.

**`IMG/REF/00196`'s gallery was removed** (user instruction, 2026-08-04). Its single entry,
`products/gallery/…-imgref00196-1.jpg`, held the same Forcar 4-door shot as the new primary in the
older, looser framing — a near-duplicate with nothing extra to show. `"gallery"` is now `null`
(the catalogue's convention for no gallery) and the file was deleted from
`storage/app/public/products/gallery/`. ⚠ That folder is untracked, so the delete is irreversible.
This is the one entry in this batch that **did** edit `products.json`.

### ✅ Brema ice machines — 5 SKUs re-imaged 2026-08-04, and a wrong-product set corrected

Twelve files supplied, all **1200 × 1200 RGB on white with even padding**, covering five Brema
ice cube machines. **The user chose to replace each gallery entirely** rather than merge, so every
pre-existing gallery entry was deleted and the supplied set became the whole gallery.

| SKU | model_number | primary | gallery | replaced |
|---|---|---|---|---|
| IMG/REF/00076 | CB 1565A HC | `…brema-1.jpg` | — | **`image` was empty (`""`)** — this SKU had no imagery at all. `products.json` edited to point at `products/ice-cube-machine-cb-1565a-brema-imgref00076.jpg`. No `gallery` key on this record; left absent |
| IMG/REF/00081 | CB 249A HC | `…brema-2.jpg` | `(1)` → slot 1 | 4 gallery entries → 1; slots 2–4 deleted (old-wrap front view, dimension drawing, badge close-up) |
| IMG/REF/00082 | CB 416A HC | `…brema-1.jpg` | `(1)`, `(2)` → slots 1–2 | 4 gallery entries → 2; slots 3–4 deleted |
| IMG/REF/00154 | CB 640A HC | `…brema-2.jpg` | `(1)`, `(2)` → slots 1–2 | 3 gallery entries → 2; slot 3 deleted |
| IMG/REF/00181 | CB 955A HC | `…brema-3.jpg` | `(1)`, `(2)` → slots 1–2 | **all 5 gallery entries deleted — see below** |

⚠ **`IMG/REF/00181` (CB 955A) had been populated with `IMG/REF/00081`'s (CB 249A) photographs.**
Found by 16×16 ahash before assigning: the two primaries matched at **Hamming 0**, and gallery
slots 1, 2, 4 and 5 matched the 249A's at 0, 0, 1 and 2. The clinching evidence is the drawing that
sat in `00181`'s slot 5: it is dimensioned **387 × 470 × 687 mm**, which is the small 29 kg/24h
249A — not a 95 kg/24h floor-standing machine with a 55 kg bin. The supplied 00181 frames show a
visibly different cabinet (twin condenser grilles, taller body), so this batch **corrects a
wrong-product image set**, it does not merely re-wrap one. Textbook
[[feedback_one_photo_many_skus]] — and it survived undetected because MD5 differed.

**What was checked before assigning.** All 12 new files were cross-hashed: **no photo is shared
between different SKUs** in this batch. Cabinet detail also separates them consistently — 00081 and
00082 have a single condenser grille, 00154 and 00181 twin grilles, and 00076 is the large
blue-flank CB 1565A. Sources deleted from Downloads.

⚠ **`IMG/REF/00154`'s frames are badged `B-QUBE`, not `ICE CUBE`** like every other SKU here. Left
as supplied — Brema does sell the CB 640A under the B-Qube range — but noted in case the product
copy, which calls it an "Ice Cube Machine", is ever reconciled against the badge.

⚠ **Dimension drawings and badge close-ups were deleted** for 00081, 00082 and 00154 as a
consequence of replacing the galleries wholesale (the drawings for those three were their own, not
borrowed). `storage/app/public/products/gallery/` is untracked, so this is irreversible. Decision
taken deliberately by the user 2026-08-04.

### ✅ Cambro + Carpigiani — 4 SKUs, 2026-08-04 (one gallery held)

Same wrap standard as the Brema batch (**1200 × 1200 on white**) and the same
**replace-the-gallery-entirely** policy.

| SKU | model_number | primary | gallery | replaced |
|---|---|---|---|---|
| IMG/STO/00001 | CB4213672V4580 | `…lifestyle.jpg` | `(1)`, `(2)` → slots 1–2 | 5 gallery entries → 2; slots 3–5 deleted |
| IMG/ICE/00026 | Turbomix | `…carpigiani-1.jpg` | `(1)`, `(2)` → slots 1–2 | 5 gallery entries → 2; slots 3–5 deleted |
| IMG/ICE/00027 | MAESTRO 2 HCD | `…carpigiani-1.jpg` | — (`gallery` was already `null`) | overwritten; **same photo, re-wrapped** (ahash Hamming 1 against the frame it replaced) |
| IMG/DWW/00107 | PR59314151 | `…webstaurant.jpg` | ⚠ **left untouched — 4 old entries still live** | primary overwritten only |

`products.json` was edited only for the two shortened gallery arrays. The Turbomix set is coherent
(machine 3/4, head detail, wand detail) and the Maestro frame's badge reads **maestro ★★**, which
corroborates the `2stelle` in its stored filename.

⚠ **`IMG/DWW/00107`'s gallery was deliberately not replaced.** The user supplied a **single base
file** for this SKU, so applying replace-entirely would have deleted 4 gallery images and left the
product with none — a materially different outcome from the multi-file case the policy was chosen
for. The primary was updated; the gallery is **pending a decision**. Its existing entries are
genuine in-use shots of a Cambro peg rack (one has plates loaded), not filler.

⚠ **The new 00107 photo's peg layout differs from the in-use frame already in its gallery** — the
supplied rack has a mixed tall/short peg field, the existing one a denser uniform field. Both are
Cambro Camrack peg racks; whether they are the same part number is **not established**. Worth an
eye before the old frames are dropped.

⚠ **`IMG/STO/00001`'s files are tagged `CB-RANGE` — range imagery, not the specific 910 mm SKU** —
and the frame placed at gallery slot 1 shows an **add-on/extension unit** (two posts, meant to
attach to a starter unit), not a free-standing shelving unit. The lifestyle frame at slot 2 shows
two units loaded with stock. Assigned as supplied, but this SKU is now represented by family
photography rather than its own configuration.

⚠ `IMG/ICE/00027`'s image filename is `…maestro-2stelle-hcd-…` while the product name is now
"Maestro 2 HCD" — the file predates a name shortening. **Left as-is**; the `image` field is read
verbatim by `ProductSeeder.php`, so nothing is broken, and renaming would be churn for no gain.

### ✅ Comenda dishwashing — 9 SKUs, 2026-08-05

All nine are `brand: COMENDA`, all in `Dishwashers`. 16 files supplied, all 1200 × 1200 on white.
Every file was rendered and checked before assignment.

| SKU | model_number | primary | gallery | replaced |
|---|---|---|---|---|
| IMG/DWW/00032 | N/A | `…katom-cambro-4.jpg` | `(1)`, `(2)` → slots 1–2 (**new** array) | primary overwritten; had no gallery |
| IMG/DWW/00033 | N/A | `…storageboxshop-fries-2.jpg` | `(1)` → slot 1 | primary + slot 1 overwritten; array unchanged |
| IMG/DWW/00085 | PC-09 | `…PCfamily-hood-closed-front-comenda-1.jpg` | `(1)` → slot 1 (**new** array) | primary overwritten |
| IMG/DWW/00093 | PC 07 | `…PCfamily-hood-closed-front-comenda-1.jpg` | `(1)` → slot 1 (**new** array) | primary overwritten |
| IMG/DWW/00156 | CB-12/18 | `…katom-cambro-3.jpg` | ⚠ **held — 2 old entries still live** | primary overwritten only |
| IMG/DWW/00157 | PR | `…ggmgastro-cambro-3.jpg` | `(1)` → slot 1; **slot 2 dropped** | 2 gallery entries → 1 |
| IMG/DWW/00158 | EC44 | `…comenda-datasheet-embedded-2.jpg` | — (none before, none now) | primary overwritten |
| IMG/DWW/00159 | EF36M | `…comenda-datasheet-embedded-3.jpg` | `(1)` → slot 1 (**new** array) | primary overwritten |
| IMG/DWW/00160 | EB28 | `…comenda-datasheet-embedded-1.jpg` | — (none before, none now) | primary overwritten |

`products.json` was edited for five `gallery` arrays only (00032, 00085, 00093, 00157, 00159). No
`image` field changed — every new file reuses the existing filename, so only the bytes on disk
moved. Catalogue-wide broken-reference sweep after the write: **0 missing**.

⚠⚠ **`IMG/DWW/00085` and `IMG/DWW/00093` were supplied the SAME TWO FILES — byte-identical, MD5
`c93c24a2…` (primary) and `e0207a0b…` (gallery).** PC-09 and PC-07 are two different machines and
now carry identical photography. The filenames say `PCfamily`, so this is knowingly family
imagery, not a mis-sourcing accident — but neither SKU is now represented by its own unit. The two
frames are also different finishes (primary = white/painted "Prime Line" front, closed hood;
gallery = stainless, hood raised over a green rack), so the pair is not even internally consistent
as one machine. See the standing warning in the memory note on one-photo-many-SKUs.

⚠ **`IMG/DWW/00156` "CB Combination Rack" now shows a plain open base rack.** The supplied navy
Cambro frame is moulded `BR258` — a *base* rack, the part an extender stacks onto — while the
image it replaced showed a rack loaded with cups **and** glasses, which reads closer to
"combination". The file is marked `REPRESENTATIVE` and was assigned as supplied; flagging because
the replaced frame arguably matched the product name better.

⚠ **`IMG/DWW/00157` slot 2 was a 25-compartment glass rack, not a plate rack** — wrong product for
this SKU, which is why the trim to one gallery entry cost nothing. Slot 1 (the frame replaced this
pass) was moulded **`NOBLE`**, a competitor brand; the new frame is Cambro.

⚠ **`IMG/DWW/00032`, `00033`, `00156`, `00157` are all marked `REPRESENTATIVE`** and are Cambro /
generic racks standing in for Comenda parts. Three of the four have `model_number: N/A` or a bare
`PR`, so there is no part number to verify them against.

⚠ **Every replaced file was backed up** to the session scratchpad
(`…\scratchpad\replaced-2026-08-05\`, 11 files) rather than only deleted, so this whole batch is
reversible until that directory is cleared. This is a deviation from rule 4 below, taken because
`storage/app/public/products` is untracked and several of the replaced frames were genuine.

### ✅ Crem / Coffee Queen brewers — 2 SKUs, 2026-08-05

Supplied a few minutes after the Comenda batch. Both base filenames → primary; neither SKU has a
gallery, and none was created. **No `products.json` edit** — both files reuse the existing
filename, so only the bytes on disk changed.

| SKU | model_number | primary | matches the record? |
|---|---|---|---|
| IMG/COF/00004 | 1008620 | `…cremtechnical-1-UNDERFLOOR.jpg` | ✔ single brewer over a removable vacuum serving station with a front tap — exactly the copy |
| IMG/COF/00006 | CQM2 | `…capecoffeebeans-5.jpg` | ✔ two 1.8 L glass decanters on separate warming plates, Coffee Queen badged |

⚠ `IMG/COF/00006`'s filename carries **`1002310`** while `model_number` is **`CQM2`** — that is a
Crem article number from the source page, not a competing model code. **`model_number` untouched.**

⚠ `IMG/COF/00004`'s filename ends `-UNDERFLOOR`, which is **not one of the markers this archive
uses** (`-TOOSMALL`, `-UPSCALED`, `-NATIVE`, `REPRESENTATIVE-`). Read as source-page wording, not a
slot directive; the frame itself is unambiguously the right machine. Both replaced files are in the
same scratchpad backup directory as the Comenda batch.

### ✅ Crem serving kit + Diqian pizza ovens — 7 SKUs, 2026-08-05

11 files. Five Crem/Coffee Queen accessories, then two Diqian countertop pizza ovens.

| SKU | model_number | primary | gallery | note |
|---|---|---|---|---|
| IMG/COF/00008 | 110001 | `…kaffe-rep-cremlivery-3.jpg` | — | **`.png` → `.jpg`** |
| IMG/COF/00009 | 1103303 | `…cremtechnical-3-UNDERFLOOR.jpg` | — | **`.png` → `.jpg`** |
| IMG/COF/00010 | 1103302 | `…crem-servingconcept-4-UNDERFLOOR.jpg` | — | **`.png` → `.jpg`** |
| IMG/COF/00011 | 113184 | `…NEARMATCH.jpg` | `(1)` → slot 1 (**new**) | **`.png` → `.jpg`**; see warning |
| IMG/COF/00013 | CQ V-2 1001120 | `…crem-coffee-3-UNDERFLOOR.jpg` | `(1)`, `(2)` → slots 1–2 (**new**) | same extension |
| IMG/OVE/00199 | CG-P340A | `…diqian-2.jpg` | `(1)` → slot 1 (replaced) | array unchanged |
| IMG/OVE/00200 | CG-P330 | `…diqian-1.jpg` | ⚠ held — 1 old entry still live | single base file supplied |

⚠ **Four `image` fields changed extension, `.png` → `.jpg`** (00008–00011). Unlike every earlier
batch, these are **real `products.json` edits**, not bytes-only swaps — the supplied files are JPEG
and the records pointed at PNGs. **The four orphaned `.png` files were removed** from
`storage/app/public/products` (backed up first). Broken-reference sweep after the write: **0**.

⚠⚠ **`IMG/COF/00011`'s two frames may not be the same airpot.** The primary shows the oval sight
gauge with a `2.2L`/`MIN` scale and a **push-button dome top**; the gallery frame is a plain
brushed cylinder with a **side lever pump** and **no sight gauge visible at all**. Either it is the
same pot rotated so the window faces away, or it is a different model. The sight gauge *is* the
product name, so the gallery frame does not evidence this SKU. The user flagged the pair
`NEARMATCH`, so this is assigned knowingly.

⚠ **`IMG/COF/00011`'s filename says `1103184`, the record's `model_number` says `113184`** — one
digit apart, and the sibling SKUs are `1103302`/`1103303`, so the record is likely missing a `0`.
**`model_number` untouched** — this needs approval, not a silent fix.

⚠ `IMG/COF/00009` (2.5 L) and `IMG/COF/00010` (5 L) are near-identical black serving stations
photographed the same way; they are **different files** and the 5 L body is visibly wider, but the
two are easy to confuse at thumbnail size.

✔ The Diqian pair is cleanly distinguished and needs no caveat: `00199` shows indicator lamps and
a thermostat dial (electric), `00200` a single gas control knob with a visible flame under the
grate and side vents (gas). `00199`'s two frames are the same oven closed and open.

### ✅ Dr. Coffee Minibar + two approved record fixes — 2026-08-05

| SKU | model_number | primary | gallery | replaced |
|---|---|---|---|---|
| IMG/COF/00096 | MINIBAR | `…MINIBAR-S1-REPRESENTATIVE-front-4.jpg` | `(1)`, `(2)` → slots 1–2 | 4 gallery entries → 2; slots 3–4 deleted |

⚠ **The three Minibar frames are not all the same configuration.** The primary and `(2)` show a
**twin steam-wand block** over a two-hopper top (bean + powder, matching the copy); `(1)` shows a
**single wand**. Dr. Coffee's Minibar family (S / S1 / Plus) differs exactly there, and the file is
marked `REPRESENTATIVE`, so this is family imagery — assigned as supplied. The user was shown the
discrepancy and chose to **keep the frame in the gallery**.

**Two approved record edits, both applied 2026-08-05:**

1. **`IMG/COF/00011` `model_number`: `113184` → `1103184`.** The six-digit code does not exist;
   the CREM article for the Coffee Queen 2.2 L stainless airpot is seven digits, attested three
   independent ways (cremtechnical Q1103184, Parts Town Q1103184, kaffe-rep "Artikelnr: 1103184").
   Recorded in `research/crem-research.md` §4.1, which is now marked APPLIED. **Nothing else on
   that record changed** — see [[feedback_model_number_unique_id]] for why this needed approval.
2. **`IMG/COF/00011` gallery kept.** The `NEARMATCH` frame with no visible sight gauge stays at
   slot 1 by the user's decision, despite the sight gauge being the product name.

### ✅ Dr. Coffee SC15 + F11 Big — 2 SKUs, 2026-08-05

| SKU | model_number | primary | gallery | replaced |
|---|---|---|---|---|
| IMG/COF/00097 | SC15 | `…SC15-front-1.jpg` | — (none before, none now) | **`.png` → `.jpg`**; orphan PNG removed |
| IMG/COF/00099 | F11 BIG | `…F11-BIG-front-black-1.jpg` | `(1)` → slot 1 | **7 entries → 1**; slots 2–7 deleted |

⚠ **`IMG/COF/00099`'s old gallery mixed two finishes** — slots 2 and 6 were a **silver** F11, slots
4 and 7 **black**, so the product page was showing the same machine in two colours. The supplied
frames are black. Trimming 7 → 1 was put to the user explicitly (the largest gallery deletion in
this log; a 3-entry black-only option was offered) and **he chose replace-entirely**. All six
deleted frames are in the scratchpad backup.

✔ `IMG/COF/00097`'s frame matches its copy closely: black glass door, touch panel with a
`°C/°F` toggle and up/down temperature keys, consistent with "8 C to 18 C, electronic". This is the
fifth `.png` → `.jpg` field change today (00008–00011, 00097).

### ✅ Empero — 12 SKUs, 2026-08-05

15 files, every one `brand: EMPERO`, sourced from Turkish resellers (cafemarkt, cafemutfak, mariot)
plus one from Empero itself. Largest single-brand drop in this log.

| SKU | model_number | primary | gallery |
|---|---|---|---|
| IMG/BUF/00009 | EMP.BQ1 | `…cafemarkt-1.jpg` | — |
| IMG/BUF/00155 | EMP.MED.S.24-1/3 | `…cafemarkt-1.jpg` | `(1)` → slot 1 (**new**) · **`.jpeg` → `.jpg`** |
| IMG/FPR/00008 | PS.09 | `…cafemutfak-1.jpg` | held (1 old entry) |
| IMG/FPR/00234 | SY.40-09 | `…cafemarkt-1.jpg` | — |
| IMG/HOT/00385 | EMP.6LE010 | `…cafemarkt-1.jpg` | — · see warning |
| IMG/HOT/00400 | EMP.BTG.01 | `…cafemutfak-1.jpg` | — · **`.jpeg` → `.jpg`** |
| IMG/HYS/00003 | EMP.BST.001 | `…cafemarkt-1.jpg` | — |
| IMG/OVE/00219 | EMP.SPO.H-70-W | `…cafemarkt-beyaz-1.jpg` | `(1)`, `(2)` → slots 1–2 (**new**) · see warning |
| IMG/PAS/00002 | EMP.3004 | `…cafemarkt-1.jpg` | — |
| IMG/PAS/00003 | HY 05 | `…mariot-1.jpg` | — · see warning |
| IMG/PAS/00005 | EMP.3005 | `…cafemarkt-1.jpg` | — |
| IMG/PAS/00007 | SH 03 | `…empero-2.jpg` | held (1 old entry) |

⚠⚠ **`IMG/HOT/00385` is named "Steam Cooker Grills Electric" but the photograph is a lava-rock
char grill.** Two control knobs, a ribbed grill bar surface over a lava bed, splash guards — no
steam function anywhere on the unit. `EMP.6LE010` decodes as Empero's 600-series **L**ava
**E**lectric grill, which agrees with the photo, not the name. **The name looks like a catalogue
error**, and renaming changes the product URL (`ProductSeeder.php` slug = name + SKU), so nothing
was touched. Flagged for a decision.

⚠⚠ **`IMG/OVE/00219`'s primary may be the wrong finish.** The model code ends **`-W`** and the
supplied filenames say **`beyaz`** (Turkish: *white*) — but the base file and `(1)` show the
**stainless** dome, and only `(2)` shows the **white** dome on its black stand. If `-W` means the
white variant, then gallery slot 2 is the SKU and the primary is its stainless sibling. Assigned by
the filename rule as supplied; **promoting `(2)` to primary is a one-line change if wanted.**

⚠ **`IMG/PAS/00003` (`HY 05`, "Spiral 50 Litres") photographs as a small open-bowl kneader** —
fixed bowl, no lid, no wheels — while `IMG/PAS/00007` (`SH 03`, 60 L) is a full enclosed spiral
mixer with a clear lid and safety cut-out. The two are a different class of machine despite near-
identical product names. The record also says "50 Litres" in the name and "65-litre bowl" in the
copy; the supplied filename adds a **`K`** suffix (`HY.05.K`) the record does not carry. All three
inconsistencies are pre-existing — **nothing changed**.

⚠ `IMG/FPR/00008` (potato peeler) and `IMG/FPR/00234` (salad spinner) are near-identical Empero
drum machines with the same red waist band. They are distinguishable — the peeler has a discharge
chute, the spinner a drain spout and no chute — but not at thumbnail size.

Two more `.jpeg` → `.jpg` field changes here (00155, 00400) bring the day's extension fixes to
**seven**. Orphaned `.jpeg` files removed, backed up first. Sweep: **0 broken references**.

### ✅ Fagor ranges + Goodwill brewer — 3 SKUs, 2026-08-05

| SKU | model_number | primary | gallery |
|---|---|---|---|
| IMG/HOT/00048 | CG7-40 | `…fagor-VARIANT-CG7-40H-1.jpg` | — · see warning |
| IMG/HOT/00049 | CG6-40 | `…fagor-2.jpg` | — |
| IMG/COF/00139 | GW-386-BD2 (RB-386) | `…vevor-4.jpg` | `(1)`, `(2)` → slots 1–2; 3 entries → 2 · see warning |

✔ The two Fagor ranges are correctly told apart: `00048` (700 series) has heavy full-width
cast-iron pan supports and no back riser; `00049` (600 series) has smaller separate grates and a
back splash. Both carry the Fagor badge.

⚠ **`IMG/HOT/00048`'s file declares itself a different model — `VARIANT-CG7-40H`, not `CG7-40`.**
A new marker in this archive, functionally like `REPRESENTATIVE`/`NEARMATCH`: the frame is the
sibling `H` variant, not the exact SKU. Assigned as supplied and knowingly.

⚠⚠ **`IMG/COF/00139` is a `GOODWILL` product but every supplied frame is badged `VEVOR`** — the
wordmark and the "TOUGH TOOLS, HALF PRICE" strapline are legible on the control panel in all three.
`RB-386` is the OEM code behind several house labels, so this is the usual re-badge situation, not
a wrong product: the machine itself matches the copy exactly (two 1.8 L glass decanters, dual
warming plates, stainless body). **But a competitor's logo will now be visible on the storefront
page.** Worth a decision before this goes live.

### ✅ Goodwill brewers — 2 SKUs, 2026-08-05

| SKU | model_number | primary | gallery | matches the copy? |
|---|---|---|---|---|
| IMG/COF/00140 | GW-386-B (RV-386) | `…goodwill-official-1.jpg` | `(1)`, `(2)` → slots 1–2; 3 → 2 | ✔ 2.0 L stainless thermal carafe, no warming plate |
| IMG/COF/00141 | GW-FRP286-BV (FRP-286BV) | `…vevor-6.jpg` | `(1)`, `(2)` → slots 1–2; 3 → 2 | ✔ thermal dispenser w/ sight gauge, red hot-water tap, "Filling"/"Ready" lamps, mains fill hose |

⚠⚠ **All six frames are badged `VEVOR`, on both SKUs** — the third Goodwill SKU today to arrive
this way (see `IMG/COF/00139` above). `RV-386` / `FRP-286BV` are OEM codes carried by several house
labels, so these are the right machines; but **three Goodwill product pages now show a
competitor's wordmark**, legible on the control panel in every frame. This is now a pattern, not a
one-off, and is worth one decision covering all three.

⚠ **`IMG/COF/00140`'s filename claims `goodwill-official` as the source, yet the machine in it is
VEVOR-badged.** The descriptor and the pixels disagree — worth knowing which source was actually
used before this frame is treated as manufacturer-authoritative.

### ✅ HDS / Hatton / Broaster — 20 SKUs, 2026-08-05 (2 files held back)

24 files, 22 assigned. Mostly `brand: HDS`, plus two Hatton dishwashers. **This batch was checked
with perceptual hashing (16×16 aHash, Hamming over 256 bits), not MD5** — and that is the only
reason the `IMG/DIS` defect below was caught: the two files differ by one byte and have different
MD5s while being pixel-identical. See [[feedback_one_photo_many_skus]].

| SKU | model_number | primary | gallery |
|---|---|---|---|
| IMG/DIS/00138 | HDSHDN-26 | `…heavydutysystems-1.jpg` | — · ⚠⚠ see below |
| IMG/DIS/00139 | HDSHDN-36 | `…benitezcommercial-1.jpg` | — · **`.jpeg` → `.jpg`** · ⚠⚠ |
| IMG/DWW/00149 | HT-Z1 | `…hatton-1.jpg` | — |
| IMG/DWW/00151 | HT-T2 | `…hatton-2.jpg` | `(1)` → slot 1; 3 → 1 |
| IMG/HOT/00332 | BROASTER 1600E | `…broaster-1.jpg` | — · ✔ badge reads **BROASTER 1600** |
| IMG/HOT/00333 | BROASTER 1800G | `…broaster-3.jpg` | ⚠⚠ **2 frames HELD, not assigned** |
| IMG/HOT/00344 | *(null)* | `…benitezcommercial-1.jpg` | — |
| **IMG/HOT/00345** | HDSFGH-150 | `…benitezcommercial-1.jpg` | — · **variant child** |
| IMG/HOT/00347 | HDSFGH-150S | `…familyshot-1.jpg` | — · **`.jpeg` → `.jpg`** |
| IMG/HOT/00390 | BROASTER 1800E | `…broaster-2.jpg` | `(1)` → slot 1 (**new**) · ✔ badge reads **1800** |
| IMG/HOT/00406 | HDSFGH-90 | `…benitezcommercial-3.jpg` | — |
| IMG/HOT/00407 | 70201104400 | `…hamoki-1.jpg` | — |
| IMG/HOT/00424 | 70201104400 | `…hamoki-1.jpg` | — |
| IMG/HOT/00425 | 70201105746 | `…hamoki-1.jpg` | — |
| IMG/HOT/00436 | HDSEFF-10LS | `…heavydutysystems-1.jpg` | — · ✔ genuinely twin-well |
| IMG/HOT/00437 | HDSGR-36 | `…specpdf-2.jpg` | — · ⚠⚠ see below |
| IMG/HOT/00438 | HDSGR60-GS24 | `…heavydutysystems-1.jpg` | held (4 entries) · ✔ exact match |
| IMG/OVE/00201 | HDSGCO-1 | `…foodmach-2.jpg` | — |
| IMG/OVE/00223 | HDSECO-4A | `…familyshot-1.jpg` | — · **`.jpeg` → `.jpg`** |
| IMG/OVE/00224 | HDSECO-8A | `…heavydutysystems-1.jpg` | — |

#### ⛔ Two files were NOT assigned — `IMG/HOT/00333` (Broaster **1800G**)

Both supplied gallery frames carry a **legible badge for a different machine**:

* `…(1).jpg` — front badge reads **`BROASTER 1600`**
* `…(2).jpg` — front badge reads **`BROASTER 9000`**, and its spec plate reads **`MODEL 9000G HE`**

The `REPRESENTATIVE-RANGE-x2` marker covers *generic* range imagery, but a **legibly wrong model
number** on a customer-facing product page is a different thing — a shopper can read `9000` on the
page for an `1800`. Held under standing rule 5 ("report mismatches instead of assigning them").
**The primary was assigned** (no legible badge on it). The two files are parked at
`…\scratchpad\held-mismatched-2026-08-05\` — say the word and they go in.

#### ⚠⚠ `IMG/DIS/00138` and `IMG/DIS/00139` are the SAME PHOTO, and nothing declares it

aHash distance **0** — pixel-identical, despite different MD5s (128,289 vs 128,290 bytes) and
different source sites in the filenames. But `00138` is the **700 mm** display and `00139` the
**900 mm**: a customer comparing the two sizes sees one picture. Neither filename carries
`REPRESENTATIVE`, unlike every other shared photo in this batch — so this looks like an accident,
not a decision. Assigned as supplied; worth re-sourcing one of the two.

#### ⚠⚠ `IMG/HOT/00437` is "6 Burner Gas Range" but the photo shows **4 burners**

Four grates, five knobs, and a narrow body — this is a 24"-class range, while `HDSGR-36` is the
36" six-burner. The file came from a spec PDF (`specpdf-2`), so the wrong page was probably
lifted. Contrast `IMG/HOT/00438`, whose frame is exactly right (6 burners + 24" griddle +
salamander + twin ovens on castors).

#### ✅ First image ever assigned to a **variant child**

`IMG/HOT/00345` (HDSFGH-150) exists only inside `IMG/HOT/00344`'s `variants[]` array — the gap
recorded in [[project_variant_children_gap]]. It **does** carry its own `image` field, so the
assignment worked normally; the sweep now checks variant-child references too. Note the parent
`IMG/HOT/00344` has **`model_number: null`** while the supplied file names it `HDSFGH-120`.
**Not applied** — that needs approval like any `model_number` change.

#### Declared shared photos (all verified by aHash, all fine)

* `00344` = `00345` — distance 0, parent + its own variant child, `RANGE-x2`. Correct.
* `00407` = `00424` = `00425` — distance 0, `RANGE-x3`, all fryer baskets. ⚠ `00425`'s filename
  asserts article `70201105746` while `00407`/`00424` say `70201104400`; same pixels either way.
* `00344`/`00345`/`00347` — distance 4 to each other. ⚠ `00347` is the **split 15+15** model but
  the shared frame is a **single-well** fryer; `00436` (split 10+10) got a correctly twin-well
  photo, so the split range is now inconsistent with itself.

Three more `.jpeg` → `.jpg` field changes (00139, 00347, 00223) take the day's total to **ten**.
Sweep after the write: **0 broken parent references, 0 broken variant-child references.**

### ✅ H-Kitchen — 13 SKUs, 2026-08-05 (1 file held)

23 files, 22 assigned. Every SKU is `brand: H-KITCHEN`. All files 1200 × 1200; no perceptual
duplicates anywhere in the batch (aHash, all pairs ≥ 7 apart).

| SKU | model_number | primary | gallery |
|---|---|---|---|
| IMG/BUF/00249 | TC-2F | `…hamoki-2-TOOSMALL.jpg` | `(1)` → slot 1 |
| IMG/DIS/00142 | YC-53 | `…yehos-4.jpg` | `(1)` → slot 1; 2 → 1 |
| IMG/DIS/00143 | TYC-120-2D | `…yehos-1.jpg` | `(1)` → slot 1 (**new**) · ⚠ code |
| IMG/FPR/00217 | IB350CV | `…twothousand-1.jpg` | — · **`.jpeg` → `.jpg`** · ⚠⚠ badge |
| IMG/FPR/00220 | BLD300 | `…ggmgastro-1.jpg` | — · **`.jpeg` → `.jpg`** · ✔✔ |
| IMG/FPR/00221 | BLD400 | `…ggmgastro-1.jpg` | — · **`.jpeg` → `.jpg`** · ✔✔ |
| IMG/FPR/00274 | 8002 | `…longyue-1.jpg` | `(1)`,`(2)`,`(3)` → slots 1–3 (**new**) |
| IMG/FPR/00277 | PB606010 | `…REPRESENTATIVE-RANGE-…red-2.jpg` | — · **`.png` → `.jpg`** |
| IMG/HOT/00267 | EHP-4S | `…rebenet-mic-4.jpg` | `(1)` → slot 1, **`REF__` file → slot 2** |
| IMG/HOT/00272 | SOT-4 | `…oute-alibaba-1.jpg` | — · ⚠⚠ badge + pan count |
| IMG/HYS/00196 | KD 20SL-FL | `…seewaymall-1.jpg` | — · ✔ badged "COOL & HOT" |
| IMG/OVE/00217 | HX-1SA | `…REPRESENTATIVE-RANGE-…-1.jpg` | held (1 entry) |
| IMG/PAS/00159 | NFK-30I | `…CODE-UNPROVEN-1.jpg` | `(1)` → slot 1; 2 → 1 · ⚠ |

#### ✔✔ Two files corroborate their SKU *in the pixels*

`IMG/FPR/00220` and `00221` are dimensioned product shots with **`300mm`** and **`400mm`** printed
on the image against a measurement arrow — exactly matching `BLD300` / `BLD400` and the product
names ("Tube 300 Mm" / "Tube 400 Mm"). The strongest self-verifying pair in this log.

#### ⛔ One file NOT assigned — `REF__IMG-HOT-00272__sot-4s-fftasia-1-TOOSMALL.jpg`

The user said the `REF__` files could be used as product images, and the `00267` one was
(see below). **This one is a different product category:** `IMG/HOT/00272` is a **gas bain marie**,
but the file is a **4-burner gas cooktop** (Jieguan-badged, red knobs) — not a bain marie at all.
Held at `…\scratchpad\held-mismatched-2026-08-05\`; one word and it goes in.

#### ⚠ The `REF__` prefix breaks the archive's own filename rule

Both files are named `REF__IMG-HOT-00xxx__…`. [[reference_product_resource_layout]] requires the
**SKU first**, markers after (`IMG-OVE-00200__REF__…`). Worth normalising if these are staged.
Also: `REF__IMG-HOT-00267__ehp-6s-sibling-**6-burner**.jpg` shows **4 burners**, not 6 — the
descriptor is wrong, but that makes it *more* correct for `EHP-4S`, so it went in at slot 2.

#### ⚠⚠ Two more competitor badges, same pattern as the Goodwill/VEVOR SKUs

* ~~`IMG/FPR/00217` (H-Kitchen `IB350CV`) — the blender is badged **`WARING COMMERCIAL`**.~~
  **✅ RESOLVED same day** — replaced with `IMG-FPR-00217__ib350cv-twothousand.jpg` (base filename,
  no index, so it superseded the primary in place). The new frame is the **same body tooling in
  teal**, carrying only a generic **`IMMERSION BLENDER`** label plate — **no manufacturer
  wordmark at all**. No `products.json` edit: same filename, same extension, bytes only. The
  Waring frame is kept as `SUPERSEDED-waring-…imgfpr00217.jpg` in the scratchpad backup.
  **This is the pattern that fixes a competitor-badge finding** — swap for an unbranded frame of
  the same OEM body rather than editing the record.
* `IMG/HOT/00272` (H-Kitchen `SOT-4`) — badged **`OUTE`**, legible bottom-left.

That is now **five** SKUs today whose product page will show another manufacturer's wordmark.

#### ⚠ Smaller mismatches, all assigned as supplied

* `IMG/HOT/00272` is named **SOT-4** but the frame shows **2 GN pans**, not 4.
* `IMG/DIS/00143`'s `model_number` is **`TYC-120-2D`** while its name, the filename and the copy
  all say **`YC-120-2D`** — a stray leading `T`, same shape as the `113184` typo fixed earlier
  today. **Not applied**; needs approval.
* `IMG/PAS/00159` — the primary is a **full-auto** hydraulic divider; the `(1)` frame is a small
  **hand-lever** machine badged **`AL-FAISAL Dough Machinery`**. Different automation class and a
  third-party badge. The filename already warns `CODE-UNPROVEN` for `NFK-30I`.
* `IMG/BUF/00249` — the primary shows **one** heat lamp, `(1)` shows **two**; likely the same unit
  at different angles, but `TC-2F` reads as a 2-lamp model, so `(1)` is the safer evidence.

Four more extension changes (00217, 00220, 00221 `.jpeg`; 00277 `.png`) take the day's total to
**fourteen**. Sweep: **0 broken parent refs, 0 broken variant-child refs.**

### ✅ Three approved decisions on the H-Kitchen batch — 2026-08-05

**1. `IMG/DIS/00143` — everything aligned to the `TYC` form.** `model_number` was already
`TYC-120-2D` and stays untouched; the *copy* was the odd one out. Replaced in `name`,
`short_description`, `description`, `technical_specification` and `meta_description` — 9
occurrences, **zero bare `YC-120-2D` left**. Name: `Beverage Cooler YC-120-2D` →
**`Beverage Cooler TYC-120-2D`**.

**2. `IMG/PAS/00159` — the hand-lever machine is now the product.**
* Primary swapped: the **full-auto hydraulic** frame is superseded by the **AL-FAISAL hand-lever**
  machine (previously gallery slot 1).
* `gallery` key removed — its only entry has become the primary.
* Name: `Bun Divider` → **`Semi Automatic Dividing and Rounding Machine`**, and the same phrase
  replaced through the copy so the body no longer says "bun divider".
* **The full-auto frame was then deleted outright** on the user's instruction — it is gone from
  `storage/app/public/products`, from the gallery, and from the scratchpad backup. `IMG/PAS/00159`
  is now represented **only** by the hand-lever machine, which is the correct outcome: the
  full-auto press was a different class of machine from the product this SKU now describes.

**3. `IMG/HOT/00272` — left exactly as it is**, `OUTE` badge and 2-pan frame included. Decision
recorded so it is not re-raised.

⚠⚠ **Both renames change the product URL.** `ProductSeeder.php` builds the slug from *name + SKU*,
so `/beverage-cooler-yc-120-2d-imgdis00143` and `/bun-divider-imgpas00159` become
`/beverage-cooler-tyc-120-2d-imgdis00143` and
`/semi-automatic-dividing-and-rounding-machine-imgpas00159` on the next seed. Any existing links,
adverts or indexed pages pointing at the old URLs will 404 unless redirects are added.

⚠ **Image filenames were deliberately NOT renamed** — the `image` field is read verbatim, so
`…bun-divider-imgpas00159.jpg` still holds the semi-automatic machine and
`…beverage-cooler-yc-120-2d-imgdis00143.jpg` still holds the TYC cooler. Same call as
`IMG/ICE/00027`: nothing is broken, and renaming is churn.

⚠ **Two things `IMG/PAS/00159` still carries from the full-auto machine, not applied:**
`model_number` **`NFK-30I`** (the supplied file was already marked `CODE-UNPROVEN`, and the machine
now shown is AL-FAISAL-badged), and a height of **2100 mm** — plausible for the full-auto press,
not for a bench-height hand-lever divider. Both need approval before touching.

### ✅ HK-Redline — 18 SKUs, 2026-08-05 (1 SKU held)

24 files, 22 assigned. Every SKU `brand: HK-REDLINE`. All 1200 × 1200. This batch carried the
densest set of self-declared caveats in the log — `FAMILY-ART`, `TOOSMALL`, `SCREENGRAB`,
`UNDERFLOOR`, `REPRESENTATIVE-NOCODE`, `LABELLED-FAMILY-COMPOSITE`, `sharedart`, `NEARMATCH`,
`shows-<other model>` — and the filenames were, on the whole, **more pessimistic than the pixels**.

| SKU | model_number | primary | gallery |
|---|---|---|---|
| IMG/BUF/00020 | DAT 60063-2 | `…SCREENGRAB-UNDERFLOOR-1.jpg` | — |
| IMG/DIS/00019 | FGDG1.0A-1500LS | `…frigo-rear-sliding-door-detail.jpg` | `kator` frame → slot 1 (**new**) |
| IMG/DIS/00020 | FGDG 1800LS-3 | `…frigo-factory-floor.jpg` | `kator` frame → slot 1 (**new**) |
| IMG/DIS/00021 | FGDG 1500LSD-3 | `…frigo-rear-sliding-door-detail.jpg` | `kator` frame → slot 1 (**new**) |
| IMG/DIS/00022 | HK-BC-01B | `…kator-TOOSMALL.jpg` | — · ✔ 1 door |
| IMG/DIS/00023 | HK-BC-02B | `…shows-HK-BC-01B-TOOSMALL.jpg` | — · ✔ 2 doors |
| IMG/DIS/00024 | HK-BC-03B | `…shows-HK-BC-01B-TOOSMALL.jpg` | — · ✔ 3 doors |
| IMG/DIS/00103 | R60-2 | `…LABELLED-FAMILY-COMPOSITE-R60-1-2-3.jpg` | — |
| IMG/DIS/00112 | HK-BC-02 | `…shows-HK-BC-01-TOOSMALL.jpg` | — · ✔ 2 doors, black |
| **IMG/DIS/00146** | HK-BC-01 | `…kator-TOOSMALL.jpg` | — · **FIRST IMAGE EVER** · ✔ 1 door, black |
| IMG/OVE/00234 | HK-13220 | `…4inch-burger-pan-400x600…` | — · ✔✔ 15 wells |
| IMG/OVE/00235 | HK-13221 | `…nonstick-burger-bun-pan…` | — · ✔✔ 15 wells |
| IMG/PAS/00011 | FX-14 | `…labelled-FX14-FX28-in-frame-TOOSMALL.jpg` | — |
| IMG/PAS/00102 | HK-B7 | `…7L-planetary-TOOSMALL.jpg` | — |
| IMG/PAS/00160 | JDR450B | `…sharedart-JDR520B-3.jpg` | `(1)` → slot 1 (**new**) |
| IMG/PAS/00164 | KT-20 | `…REF__…DIFFERENT-MACHINE-TOOSMALL.jpg` | — · ⚠ |
| IMG/STO/00011 | HK-DC-M2A | `…REPRESENTATIVE-TT-BU110B…` | — · ✔ 2 tier |
| IMG/STO/00012 | HK-DC-M3A | `…REPRESENTATIVE-TT-BU114B…` | — · ✔ 3 tier |

#### ⛔ `IMG/PAS/00103` held — the spec plate reads **20 LITER / B20** on a 10-litre SKU

Both supplied frames are legibly labelled **`20 LITER MIXER`**, **`MODEL: B20`**, **`POWER: 1.1KW`**
on the machine's own plate. The record is **"Cake Mixer Planetary 10 Litres B10GFA"**. The filename
declares `NEARMATCH`, but as with the Broaster `9000` frames, a **legible wrong capacity and model
number** is not the same as generic family art — a shopper reads "20 LITER" on a 10-litre product
page. Held at `…\scratchpad\held-mismatched-2026-08-05\`.

#### ✅ `IMG/DIS/00146` had **no image at all** — this is its first

`image` was `null`. 50 products in the catalogue are still in that state.

#### ✔✔ Two more self-verifying frames

`IMG/OVE/00234` and `00235` are both named **"PAN-15"** and both frames show exactly **15 round
wells** (5 × 3). Counted, not assumed.

#### ✔ Several `shows-<other model>` warnings turned out to be over-cautious

`IMG/DIS/00023` / `00024` are labelled "shows HK-BC-01B" and `00112` "shows HK-BC-01", but the
frames show **2, 3 and 2 doors** respectively — matching each SKU's own door count, not the
single-door 01B. aHash confirms they are genuinely different images (all pairs ≥ 7 apart). The
caveat appears to describe shared *styling*, not a shared photo.

#### ⚠ `IMG/DIS/00019`, `00020`, `00021` share **both** of their frames

aHash distance **0** across all three for the primary, and **0** again across all three for the
gallery frame. Declared `FAMILY-ART`, so this is intentional — but three differently-sized pastry
displays (1500LS, 1800, 1500LSD) now carry identical photography, and the `kator` frame is
additionally declared to show a **fourth** model (`FGDG1200LS-3`).

⚠ **Their descriptors also disagree with each other and with the pixels**: the same image is called
`rear-sliding-door-detail` on `00019`/`00021` and `factory-floor` on `00020`, while the frame is
actually a plain front three-quarter of a display cabinet — neither a door detail nor a factory
floor.

#### ⚠ `IMG/PAS/00164` — assigned, but its own filename says `DIFFERENT-MACHINE`

`REF__…MANUAL-bun-divider-rounder-DIFFERENT-MACHINE`. It **is** a dough divider (same category, so
unlike the bain-marie/cooktop case held earlier), and it was the only file offered for the SKU, so
it went in under the user's standing "you can use the REF files" instruction. Note this SKU sits
next to `IMG/PAS/00159`, renamed to *Semi Automatic Dividing and Rounding Machine* earlier today —
worth checking the two are not now describing the same machine.

⚠ `IMG/BUF/00020` is named **"Chafing Dish Drop in *Square*"** but the frame is a **rectangular
(GN 1/1) roll-top** chafer. Marked `SCREENGRAB`; assigned as supplied.

Sweep: **0 broken references.**

### Standing rules (set by the user 2026-08-04)

1. **Filename decides the slot.** A **base filename** (no suffix) is the **primary image**;
   filenames ending **`(1)`, `(2)`…** are **gallery** images — unless the user says otherwise
   for a specific file.
2. **Re-posting the same filename REPLACES the current primary** — it is never appended to the
   gallery. Supersede in place; the field does not change when the extension matches.
3. **Delete the source files from Downloads** once copied into the project.
   ⚠ Only ever touch SKU-named files — Downloads also holds receipts, newsletters and logos.
4. **Delete the old assigned images** from `storage/app/public/products` — do not keep
   superseded copies. ⚠ That folder is **gitignored and untracked**, so this is irreversible.
5. **Render and check every image against its record before assigning**; report mismatches
   instead of assigning them.
