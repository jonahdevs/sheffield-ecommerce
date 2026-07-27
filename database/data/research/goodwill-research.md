# Goodwill Product Research

Research notes behind a GOODWILL audit pass on `products.json` (July 2026). Covers all 3
GOODWILL SKUs, all commercial filter/pour-over coffee brewers in
`Coffee Machines > Coffee Brewers`: GW-386-BD2, GW-386-B and GW-FRP286-BV.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema and Santos passes before a scope decision.

Headline result: the brand is real and identified, an **official manufacturer site plus a
downloadable official catalogue PDF were found**, and — unlike most brand passes so far —
**the three SKUs' specs are genuinely distinct, not copy-pasted across siblings**. What is
wrong is narrower and more specific: one axis-swap, one set of missing dimension fields, a
missing/US-market power rating on all three, and one model code that does not exist in the
manufacturer's own catalogue.

---

## 1. Brand identification — official site found

**Goodwill** = **Guangdong Goodwill Industrial Co., Ltd.**, Foshan (Shunde District),
Guangdong, China. ~20 years of OEM/ODM manufacturing of beverage and cooking equipment;
product lines are commercial coffee brewers, espresso machines, capsule machines, drip
coffee makers, coffee percolators/urns, water boilers and commercial induction cookers.
CE / CB / ETL / GS / FDA / RoHS / LFGB certified, sold worldwide, export-oriented (their
own spec sheets quote container loading quantities rather than retail prices).

**Official website: https://www.goodwill-kitchen.com/**

`brands.json` currently has `"website_url": null` for slug `goodwill`. That URL is real,
live, and clearly the right company — every one of our three model codes traces back to
its beverage-equipment catalogue. The existing `brands.json` description ("Goodwill
manufactures commercial catering and beverage equipment, including filter coffee brewers
built for high-volume foodservice operations") is accurate and needs no change.

Contact on the site: info@goodwill-kitchen.com, +86 757 22902562, No.1 Fengyu Road,
Ronggui, Shunde District, Foshan City, Guangdong.

---

## 2. Where to look

| Resource | URL | Value |
|---|---|---|
| Official site (home) | https://www.goodwill-kitchen.com/ | Company profile, two top-level categories only |
| Beverage Equipment category (6 pages) | https://www.goodwill-kitchen.com/products/25797619_7293628_0_1.html | 54 products; this is where all four "386"/"286" brewers live |
| **Official catalogue PDF (2023) — the gold standard** | https://www.goodwill-kitchen.com/dom/down_doc_pass.php?username=erinyang11&file_id=71204 | 16-page "Goodwill Catalog", dated 2023-08-01. Page 4 is the whole Commercial Coffee Brewer range with full spec bullets |
| Downloads index (where the PDF is linked) | https://www.goodwill-kitchen.com/dom/down_list.php?username=erinyang11&channel_id=26029976 | Only one file offered |
| GW-386-AD2 product page | https://www.goodwill-kitchen.com/pro_53731347.html | Sibling of our BD2 — see §3 |
| GW-386-B product page | https://www.goodwill-kitchen.com/pro_53731409.html | Exact match for IMG/COF/00140 |
| GW-RP286-BV product page | https://www.goodwill-kitchen.com/pro_53731426.html | Near-match for IMG/COF/00141 — see §4.3 |
| GW-DFRB-286 product page | https://www.goodwill-kitchen.com/pro_53731669.html | Not ours, but decodes the "F"/"D" prefixes — see §4.3 |

### The OEM/export-code layer

Goodwill is an OEM/ODM house: the same machines are sold worldwide under buyers' own
brands with the buyer's own model codes. The parenthetical codes in our `model_number`
fields (`RB-386`, `RV-386`, `FRP-286BV`) are **that export/OEM layer**, and they resolve
cleanly on VEVOR, which sells all three machines and — usefully — publishes a proper
spec table with dimensions and weights that Goodwill's own catalogue mostly omits:

| Our parenthetical | Real OEM code | VEVOR listing |
|---|---|---|
| RB-386 | **RB-386-BD2** | https://www.vevor.com/electric-coffee-grinder-c_11786/12-cups-commercial-drip-coffee-maker-with-2-glass-carafes-and-2-warmers-office-p_010676617182 |
| RV-386 | **RV-386-B** | https://www.vevor.com/electric-coffee-grinder-c_11786/12-cups-commercial-drip-coffee-maker-with-thermal-carafe-restaurant-office-cafe-p_010915863780 |
| FRP-286BV | **FRP286-BV** | https://www.vevor.com/electric-coffee-grinder-c_11786/vevor-commercial-drip-coffee-maker-16-17-cups-machine-with-2-5-l-thermal-carafe-keep-warm-for-4-hours-stainless-steel-brewer-with-auto-water-filling-for-restaurant-office-coffee-shop-home-p_010919733799 |

Our stored aliases each drop or mangle the real suffix (`RB-386` vs `RB-386-BD2`,
`RV-386` vs `RV-386-B`, `FRP-286BV` vs `FRP286-BV`). Cosmetic, and per
[[feedback_model_number_unique_id]] **not changed** — flagged only.

The same machines also appear under NUPANT (https://www.nupantcatering.com/), Mecale
(sold at Lowe's), Albayan (https://bayanuae.com/product/american-coffee-machine-selver-rb-386/)
and others. Those are re-badges of the same Goodwill hardware and are useful for
cross-checking, not as primary sources.

### Traps

1. **VEVOR's marketing copy contradicts VEVOR's own spec table.** The FRP286-BV page is
   *titled* "16 to 17 Cups, **2.5L**" and its URL slug says `2-5-l-thermal-carafe`, while
   its spec table says **1.2 gal / 4.5 L**. 16–17 cups × 5 oz ≈ 2.4 L of *coffee*, so the
   2.5 L figure is probably the brew volume and 4.5 L the vessel's gross capacity — or
   one of the two is simply wrong. See §4.3.
2. **Nobody states dimension axis order.** Goodwill's catalogue writes a bare
   `Size:203x527x405mm`; VEVOR writes a bare `437 x 207 x 620 mm` — and VEVOR uses a
   *different* order on two listings for the same machine body. Every axis assignment in
   this file was resolved against the product photos, not taken on trust. See §5.
3. **Goodwill's site pagination hides products.** The beverage category renders 9 items
   per page across 6 pages; the coffee brewers are not on page 1, so a casual look at the
   site suggests they don't make these at all. The catalogue PDF is the fast path.
4. **The catalogue PDF's embedded images are tiny** (max ~179 × 268 px). Use the website
   product pages for artwork, not the PDF.

---

## 3. Model-code reconciliation

| Our `model_number` | In Goodwill's official catalogue? | Notes |
|---|---|---|
| `GW-386-BD2 (RB-386)` | **Yes — exact** (catalogue p.4) | The *website* only lists the sibling `GW-386-AD2`; the catalogue PDF lists `GW-386-BD2`. A/B = **plastic vs SS304 filter basket**, everything else identical (same 6–7 min, same 1610/2020 W, same container quantities) |
| `GW-386-B (RV-386)` | **Yes — exact** (catalogue p.4 + website) | Only one of the three with an official published size |
| `GW-FRP286-BV (FRP-286BV)` | **No** | Closest official model is `GW-RP286-BV`, which is a **materially different machine** — see §4.3 |

Decoding Goodwill's own suffixes, from the four "286"/"386" models seen side by side:

- `A` / `B` before `D2` = plastic / SS304 filter basket
- `D2` = 2 glass decanters, `D` prefix on `DFRB-286` = double (twin brewer, 6 decanters)
- `BV` = insulated vacuum ("bucket, vacuum") shuttle server instead of a glass decanter
- `F` = **water faucet / hot-water tap**. `GW-DFRB-286` is the only official model whose
  bullet list says "With water faucet", and it is the only one carrying an `F`.

That last point is the strongest available evidence that `GW-FRP286-BV` = the
faucet-equipped variant of `GW-RP286-BV` — which is exactly what our 00141 record
describes (it claims a dedicated hot water tap). Reasoned inference, not a confirmed
listing.

---

## 4. Per-SKU findings

### 4.1 GW-386-BD2 / RB-386-BD2 (IMG/COF/00139) — content confirmed; dimensions axis-swapped; no power stored

Official catalogue bullets for **GW-386-BD2**: commercial coffee brewer with SS304 filter
basket, 2 × 1.8 L glass decanters, On/Off switch with automatic brewing, brewing time
**6–7 minutes**, dry-run protection, 304 stainless steel, **120 V/1610 W; 230 V/2020 W**.
No size published (neither the catalogue nor the website gives one for this model).

Everything our record says about features is **confirmed correct**: 2 × 1.8 L glass
decanters ✓, dual warming plates ✓, 6–7 minutes ✓, stainless housing ✓, removable
stainless filter basket ✓ (this is precisely what distinguishes BD2 from AD2), dry-run
protection ✓, On/Off with automatic brewing ✓. The 2.8 L water tank comes from VEVOR
(Goodwill doesn't publish it) and is consistent with the sibling.

Two problems:

- **⚠ Dimensions are axis-swapped.** Stored `length: 205, width: 405, height: 455` and
  the spec-table prose says "Dimensions (L × W × H) 205 × 405 × 455 mm". The machine is a
  Bunn-VPR-shaped brewer: **narrow at the front, deep front-to-back**. Its real footprint
  is **205 mm wide × 405 mm deep × 455 mm high** (VEVOR: 8.07 × 15.94 × 17.91 in). This
  app treats `length` as **depth** (`compare.blade.php` reads
  `$product->depth ?? $product->length`, and the product page renders `width × length ×
  height`), so the correct values are **`length: 405`, `width: 205`, `height: 455`** —
  i.e. `length` and `width` are transposed today. Its own sibling 00140 already stores
  the same body the other way round (§4.2), which is what exposed the bug.
- **Power is not stored at all.** Add **230 V / 2020 W** (the 230 V figure, since Kenya is
  a 230 V market; 120 V/1610 W is the US variant).

Worth adding while there: net weight **6.4 kg** (VEVOR) and cup rating **12–13 cups**.

### 4.2 GW-386-B / RV-386-B (IMG/COF/00140) — dimensions correct; brewing time disputed; no power stored

Official catalogue bullets for **GW-386-B**: SS304 filter basket, **1 × 2.0 L SS coffee
pot**, On/Off switch with warming function, brewing time **8 minutes**, dry-run
protection, 304 stainless steel, **120 V/1450 W; 230 V/1900 W**, **Size: 203 × 527 ×
405 mm**.

- **Dimensions are correct as stored.** `length: 405, width: 203, height: 530` reads as
  depth 405 / width 203 / height 530, which matches both the official 203 × 527 × 405 mm
  (written width × height × depth) and VEVOR's 405 × 203 × 530 mm. The 527 vs 530 gap is
  rounding between the two sources. **No swap here** — same lesson as the Brema and
  Santos passes: the swap has to be checked per-SKU, never assumed.
- **⚠ Brewing time disagrees.** Stored "approximately 9 minutes" (VEVOR's figure);
  Goodwill's own catalogue and product page both say **8 minutes**. Recommend the
  manufacturer's 8 minutes, or hedge to "8–9 minutes".
- **Power is not stored at all.** Add **230 V / 1900 W**.
- **Carafe wording.** Our record says "2.0 L insulated thermal carafe"; Goodwill says
  "1 pc 2.0 L SS coffee pot" and its own photo shows a stainless vacuum airpot — so
  "insulated thermal carafe" is accurate, just worth saying **stainless steel** since the
  sibling 00141's vessel is a plastic-bodied shuttle.
- Net weight 6.4 kg is already stored. Note VEVOR quotes the *same* 6.4 kg for the BD2,
  which is likely VEVOR's own copy-paste (the BD2 carries an extra warmer plate and a
  second decanter) — treat 6.4 kg on the BD2 as approximate.

### 4.3 GW-FRP286-BV / FRP286-BV (IMG/COF/00141) — ⚠ model not in Goodwill's catalogue; numeric dimensions missing; 1450 W is a US-market figure

This is the weakest of the three. Our stored content is internally coherent and matches
the VEVOR/Mecale **FRP286-BV** listing line for line — 16–17 cups, ~9 minutes, 4.5 L
insulated thermal dispenser, hot for up to 4 hours, automatic water filling, dedicated hot
water tap, 304 stainless funnel, 1450 W, 437 × 207 × 620 mm, 10.4 kg. The VEVOR photos
confirm the physical machine: a tall stainless head with a **red hot-water tap lever on
the front**, a black insulated shuttle server underneath, and a water-line inlet at the
rear. So the description describes a machine that genuinely exists and matches the code.

What doesn't line up:

- **`GW-FRP286-BV` is not in Goodwill's 2023 catalogue or on their website.** The closest
  official model, **`GW-RP286-BV`**, is a *different* machine: 1 × **2.5 L** vacuum
  insulated bucket, rocker switch + auto fill, no faucet mentioned, 6–7 minutes,
  **230 V/2020 W**, **308 × 455 × 705 mm**. Its official photo shows a Kinox 2.5 L shuttle
  and a control panel with "2 L / 2.5 L" brew-volume switches and **no hot-water tap**.
  Per §3, the `F` almost certainly denotes the faucet variant, so `GW-FRP286-BV` is very
  likely a real Goodwill model simply not published on their (2023-vintage) catalogue —
  but that is an inference. **Confidence: Medium.**
- **⚠ Numeric `length` / `width` / `height` are all `null`** even though the spec-table
  prose already carries "437 × 207 × 620 mm". Same body geometry as the 386 family
  (narrow front, deep), so under this app's convention that is **`length: 437`,
  `width: 207`, `height: 620`**. Pure omission — the numbers are already in the record,
  just not in the fields the storefront and compare table read.
- **⚠ The stored 1450 W is the 120 V US rating.** Every Goodwill "286" machine is quoted
  as *120 V/1610 W; 230 V/2020 W* (or 2080 W ×2 for the twin). A 230 V machine drawing
  1450 W would be an outlier in this family. For a Kenyan 230 V listing, the honest figure
  is **~2020 W at 230 V**, and 1450 W should not be published as-is — it understates the
  circuit requirement. **Recommend removing or correcting rather than leaving.**
- **⚠ 4.5 L vs 2.5 L dispenser.** VEVOR's own page title says 2.5 L while its spec table
  says 1.2 gal / 4.5 L, and Goodwill's nearest official model says 2.5 L. 16–17 cups at
  5 oz ≈ 2.4 L of coffee, which fits 2.5 L as the *brew* volume and 4.5 L as the vessel's
  gross size. **Unresolved** — do not assert 4.5 L of coffee per brew without checking the
  actual server the supplier ships. Safest published wording: "brews 16–17 cups (≈2.5 L)
  into an insulated thermal dispenser".
- "Keeps coffee hot for up to 4 hours" is VEVOR marketing copy, not a manufacturer claim.
  Harmless, but it is not manufacturer-backed.

---

## 5. Cross-cutting notes

### 5.1 The copy-paste-across-siblings bug: **not present here**

The specific failure found on other brands (one model's numbers pasted onto all its
siblings) **did not happen on GOODWILL**. All three records carry genuinely distinct,
model-correct figures:

| Field | 00139 (BD2) | 00140 (B) | 00141 (FRP286-BV) | Distinct? |
|---|---|---|---|---|
| Vessel | 2 × 1.8 L glass decanters | 1 × 2.0 L thermal carafe | 1 × 4.5 L thermal dispenser | ✓ |
| Warming plates | 2 | none (insulated) | none (insulated) | ✓ |
| Brew time | 6–7 min ✓official | 9 min (official says 8) | ~9 min | ✓ |
| Water tank | 2.8 L | 2.8 L | not stated | shared — genuinely the same body |
| Dimensions | 205 × 405 × 455 | 405 × 203 × 530 | 437 × 207 × 620 (prose only) | ✓ |
| Weight | not stored | 6.4 kg | 10.4 kg | ✓ |
| Power | not stored | not stored | 1450 W | ⚠ two missing, one wrong-market |

The two shared figures (2.8 L tank on both 386s; 6.4 kg on both 386s at VEVOR) are shared
because the two machines really are the same cabinet — that's the manufacturer's doing,
not a data-entry error on our side.

### 5.2 The axis-order problem is upstream, not ours

Both of our sources publish dimensions **without axis labels and in inconsistent order**.
VEVOR lists the RB-386-BD2 as `205 × 405 × 455` and the RV-386-B as `405 × 203 × 530` —
the same cabinet, first two axes flipped between listings. Our catalogue copied each
verbatim, which is how 00139 and 00140 ended up describing one physical body two
different ways. The physical truth, resolved from the product photos (all three are
narrow-fronted, deep, Bunn-VPR-shaped units):

| SKU | Width (front) | Depth | Height |
|---|---|---|---|
| 00139 GW-386-BD2 | 205 | 405 | 455 |
| 00140 GW-386-B | 203 | 405 | 530 (official 527) |
| 00141 GW-FRP286-BV | 207 | 437 | 620 |

App convention (from `resources/views/pages/storefront/compare.blade.php` and
`.../product.blade.php`): **`length` = depth**, rendered as `width × length × height`.
So only 00139 needs correcting; 00140 is already right; 00141 needs the numbers moved out
of prose and into the fields.

### 5.3 Power ratings are the biggest real-world risk

Two of three records publish no wattage at all and the third publishes the US 120 V
figure. For commercial kitchen equipment sold in Kenya this is the spec a buyer actually
needs for the circuit. Manufacturer 230 V figures, from the official catalogue:

- GW-386-BD2 → **2020 W** @ 230 V (1610 W @ 120 V)
- GW-386-B → **1900 W** @ 230 V (1450 W @ 120 V)
- GW-RP286-BV family (incl. FRP286-BV) → **2020 W** @ 230 V (1610 W @ 120 V)

Note the coincidence that our 00141's stored "1450 W" is exactly the **GW-386-B**'s 120 V
rating — so it may be a mis-transcription rather than a US-spec carry-over. Either way it
is not the right number for a 230 V 286-series machine.

---

## 6. Product reference

| SKU | Catalogue name | Our model | Official Goodwill source | OEM/reseller source | Confidence |
|---|---|---|---|---|---|
| IMG/COF/00139 | Commercial Coffee Brewer GW-386-BD2 (RB-386) Goodwill | GW-386-BD2 | Catalogue p.4 (exact code); sibling page https://www.goodwill-kitchen.com/pro_53731347.html | https://www.vevor.com/electric-coffee-grinder-c_11786/12-cups-commercial-drip-coffee-maker-with-2-glass-carafes-and-2-warmers-office-p_010676617182 | **High** — official code match, features all confirmed; dimensions from OEM listing only (Goodwill publishes none) |
| IMG/COF/00140 | Commercial Coffee Brewer GW-386-B (RV-386) Goodwill | GW-386-B | https://www.goodwill-kitchen.com/pro_53731409.html + catalogue p.4 | https://www.vevor.com/electric-coffee-grinder-c_11786/12-cups-commercial-drip-coffee-maker-with-thermal-carafe-restaurant-office-cafe-p_010915863780 | **High** — official code, official dimensions, official power; only brew time disputed |
| IMG/COF/00141 | Commercial Coffee Brewer GW-FRP286-BV (FRP-286BV) Goodwill | GW-FRP286-BV | **No official page** — nearest is https://www.goodwill-kitchen.com/pro_53731426.html (GW-RP286-BV, different spec) | https://www.vevor.com/electric-coffee-grinder-c_11786/vevor-commercial-drip-coffee-maker-16-17-cups-machine-with-2-5-l-thermal-carafe-keep-warm-for-4-hours-stainless-steel-brewer-with-auto-water-filling-for-restaurant-office-coffee-shop-home-p_010919733799 | **Low–Medium** — machine and code verified at the OEM reseller, but unconfirmed at the manufacturer; dispenser capacity and wattage both unresolved |

Supporting sources consulted:
https://www.goodwill-kitchen.com/pro_53731669.html (GW-DFRB-286, used to decode the "F"
faucet suffix), https://www.nupantcatering.com/ (re-badge of the same hardware),
https://bayanuae.com/product/american-coffee-machine-selver-rb-386/ (RB-386 re-badge,
quotes 230 V / 2020 W — independently corroborating Goodwill's 230 V figure),
https://www.amazon.com/NUPANT-Commercial-Insulated-Stainless-Restaurant/dp/B0D3XNLSLW

---

## 7. Image sourcing (July 2026) — downloaded to `Downloads/goodwill-images/`

**26 files.** Two distinct sources per SKU where available:

1. **Official Goodwill studio renders** (1800 px PNG/JPG) pulled from the product-page
   DOM under `aimg8.dlssyht.cn/u/2194250/product/...`. Clean white-background product
   shots — the best storefront candidates.
2. **VEVOR gallery images** (`img.vevorstatic.com`) — lifestyle/feature panels (`f1`–`f6`,
   which carry burnt-in marketing text and the VEVOR logo) plus plain studio shots
   (`m9`–`m12`, several of which are clean multi-angle renders usable as-is).

| SKU | Files | Notes |
|---|---|---|
| IMG/COF/00139 | `IMG-COF-00139__GW-386-AD2-official.png` + `IMG-COF-00139__RB-386-BD2-vevor-f1`…`f6` + `-m9`…`m12` | ⚠ The official render is of the **AD2** (plastic-basket sibling) because Goodwill's website has no BD2 page — **the cabinet is identical**, only the internal filter basket differs, so it is a valid visual reference. `-m12` is the cleanest plain studio angle |
| IMG/COF/00140 | `IMG-COF-00140__GW-386-B-official.png` + `IMG-COF-00140__RV-386-B-vevor-f1`…`f6` + `-m9`…`m12` | Official render is exact-model and shows the stainless 2.0 L airpot in place — best primary candidate |
| IMG/COF/00141 | `IMG-COF-00141__GW-RP286-BV-official-a.jpg`, `-official-b.jpg` + `IMG-COF-00141__FRP286-BV-vevor-f1`…`f6` + `-m9`…`m12` | ⚠ **Do not use the two `GW-RP286-BV-official` files as the product photo.** They are the *non-faucet* 2.5 L sibling (§4.3) — visibly no hot-water tap, different control panel. They are here as reference for the model-code question only. Use the VEVOR `FRP286-BV` images, which do show the red hot-water tap lever |

Notes for whoever adopts these:

- **VEVOR `f1`–`f6` files carry burnt-in English marketing text and the VEVOR logo** —
  not usable as storefront product photos without cropping. The `m9`–`m12` files are the
  plain renders.
- The official Goodwill PNGs are large (1–2 MB) and un-optimised; they'll want the usual
  resize/WebP treatment before going into `storage/app/public/products/`.
- **Not yet copied into `storage/app/public/products/` or referenced in `products.json`**
  — staged in Downloads for review first, same as the Brema and Santos sets. All three
  SKUs already have images in `products.json`, so this is a possible upgrade, not a gap.

---

## 8. Recommended changes (none applied)

Ordered by how load-bearing they are:

1. **`brands.json`** — set `website_url` to `https://www.goodwill-kitchen.com/` (currently
   `null`). Verified live, correct company. *(Not applied — findings-only pass.)*
2. **00141 dimensions** — move `437 / 207 / 620` out of the prose and into
   `length: 437, width: 207, height: 620`. The storefront and compare table currently show
   nothing for this product.
3. **00139 dimension swap** — `length: 205, width: 405` → `length: 405, width: 205`
   (height 455 unchanged), and fix the matching prose string.
4. **Power ratings** — add `230 V / 2020 W` to 00139 and `230 V / 1900 W` to 00140; review
   00141's `1450 W`, which is a 120 V-market figure (see §5.3).
5. **00140 brewing time** — 9 min → 8 min (manufacturer's own figure), or "8–9 minutes".
6. **00141 dispenser capacity** — soften "4.5 L" pending confirmation (§4.3).
7. Optional: net weight 6.4 kg + "12–13 cups" on 00139; "stainless steel" on 00140's
   carafe.

## 9. Left unresolved

- **Whether `GW-FRP286-BV` is a genuine Goodwill model code.** The machine exists and
  carries that code at the OEM reseller, and the `F`-for-faucet reading is well supported
  by `GW-DFRB-286`, but Goodwill's own 2023 catalogue and current website list only
  `GW-RP286-BV`. Resolving this needs the supplier or a newer Goodwill catalogue.
- **00141's true dispenser capacity** (2.5 L vs 4.5 L) and **true 230 V wattage** — both
  hinge on the same question above.
- **No official dimensions exist for GW-386-BD2.** Neither the catalogue nor the website
  publishes a size for it; the 205 × 405 × 455 mm figures are the OEM reseller's, verified
  only against photographs.
- **Price sanity was not checked** — out of scope for this pass.
