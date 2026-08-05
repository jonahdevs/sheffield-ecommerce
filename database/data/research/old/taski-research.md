# TASKI Product Research

Research notes behind the TASKI enrichment pass on `products.json` (July 2026). Data was
sourced from official TASKI information sheets and accessory charts, cross-checked against
European distributors.

Covers 49 of 52 TASKI SKUs: 17 machines and 32 consumables and spares. Three parts remain
unidentified - see §8.

**TASKI is Diversey's professional cleaning machine brand. Solenis acquired Diversey in 2023.**

---

## 1. Where to look - and where not to

**`taski.com` is the only reliably live official source.**

All `diversey.com` and `eshop.diversey.*` product URLs now 301-redirect to `solenis.com`, then
again to a generic `products.solenis.com` landing page. Per-product Solenis pages return
**HTTP 403** to automated access. Any Diversey URLs already stored in the catalogue are broken.

| Resource | URL |
|---|---|
| Official site | <https://taski.com> |
| Instructions of use (manual index) | <https://taski.com/instructions-use/> |
| Spare parts portal (login) | <https://taskispares.diversey.com> |
| Part-number search | `https://taski.com/?s=<partnumber>` - works for anything in the catalogue |

Note two URL path conventions on taski.com: `/taski-products/…` and `/product/…`. **A model
sitting on the legacy `/product/` path while its category page lists others under
`/taski-products/` is a discontinuation signal** - that is how the balimat 45 was identified
as dead.

---

## 2. Naming traps

### 2.1 The µicro encoding bug - affects two SKUs

TASKI brands its compact machines with a Greek micro sign fused into the word: **µicro**.
When µ fails to encode it degrades in stages:

```
250µicro  →  250uicro  →  250 UCRO
```

The catalogue held **"Swingo 250 UCRO"** and **"Swingo 2100 Micro"** - both are this
corruption, not product codes. Diversey's own UK shop URLs use the broken "uicro" spelling,
which is how it propagates into third-party catalogues.

Renamed to "Swingo 250 Micro" and "Swingo 2100 Micro BMS UK" - readable, and it will not
re-corrupt. **Never strip the µ silently; that is the root cause.**

### 2.2 Ergodisc, not Ergodisk - and there is no "165 Duo"

The catalogue held **"Ergodisk 165 Duo"**, wrong in three ways:

1. Spelling is **ERGODISC** with a C. "Ergodisk" appears in no TASKI literature.
2. There is no "165 Duo" product. The model is **ergodisc duo**; the 165 leaked in from its
   165/330 rpm speed spec.
3. Its description called it "twin-disc". It is a **single disc with a two-speed gearbox**.

### 2.3 Suffix and acronym decoding

| Token | Meaning | Notes |
|---|---|---|
| `T` (vacumat 22T, 44T) | **Trolley** - fixed trolley chassis | **Not** twin-motor. The 44T is twin-motor but so is the base 44; the 22T is single-motor and still carries the T |
| `DUO` (ergodisc) | **Dual-speed** - 165 and 330 rpm | Not twin-tank, not twin-disc |
| `BMS` (swingo 2100) | **Battery Management System** | A configuration option: base 7523409 vs BMS variants 7523419/7523420/7523422 |
| `RTU` (balimat 3300) | **Ready To Use** | Batteries-and-charger-included package; 7524907 is machine-only |
| `E` / `B` (AERO BP) | **E**lectric (corded) / **B**attery | |
| `Plus` (AERO 15) | Adds cable drum, full-bag indicator, Eco mode | Series II also adds HEPA H13 as standard |
| `µicro` (swingo 2100) | TASKI's **micro ride-on** class | Meaningful branding, not a market code |

### 2.4 The AERO 8 is not an 8-litre machine

Its canister is **13 litres**. The "8" is a series designation. The AERO 15 genuinely is 15 L.

---

## 3. Cross-cutting rules

### 3.1 Noise claims - be precise

TASKI's own website prints "Ultra low sound (50dBA)" across the whole AERO range. **That is
accurate for exactly one machine.** Publishing it generally creates a returns exposure.

| Machine | Actual |
|---|---|
| AERO 15 Plus, Eco mode | **50 dB(A)** - the only model that earns the headline |
| AERO 8 / AERO 15 standard | 53 dB(A) |
| AERO BP B Li-Ion | 61 dB |
| balimat 3300 | 62 dB(A) |
| vacumat 22 | 64 dB(A) |
| GO | 64 dB(A) |
| AERO BP E | 66 dB |
| aquamat 20 | 66 dB(A) |
| vacumat 44T | 67 dB(A) |
| swingo 250µicro (Eco) | ≤68.5 dB(A) |
| ergodisc 165 / duo | 57 dB(A) |

### 3.2 Several machines ship unusable without accessories

This is a real customer-expectation problem, and it is worth stating on the product page:

- **aquamat 20** - supplied without accessories. The spray extraction tool set (**8505160**)
  is described by TASKI as *required for operation*.
- **vacumat 44T** - ships **with** the trolley but **without** the fixomat squeegee
  (**8505420**). Its headline 64 cm working width requires that extra purchase.
- **vacumat 12 / 22 / 22T** - supplied without accessories; a wet or dry tool kit is needed.

### 3.3 "UK" spec is the correct choice for Kenya

The "UK" designation in TASKI part numbers denotes a **Type G plug**, which is also Kenya's
standard socket. UK variants are the right choice, not merely an acceptable substitute -
worth stating as a selling point. Avoid NA (110–120 V) codes throughout.

### 3.4 What the accessory-chart symbols mean

- `x` = included in the box
- `(x)` = **needed for machine operation** - a required consumable chosen per configuration,
  not supplied. Where two battery SKUs both show `(x)`, the machine takes one **or** the other.
- `o` = optional

---

## 4. Corrections applied

| SKU | Product | Was | Now |
|---|---|---|---|
| IMG/HYS/00160 | Pad Driver 43CM (7510829) | described as an **Ergodisc** part | **swingo** scrubber-drier part. Same diameter as the ergodisc disc drive 8504410 but **not interchangeable** - highest wrong-part risk in the set |
| IMG/HYS/00148 | Ergodisc Duo | "Ergodisk 165 Duo", "twin-disc" | ergodisc duo; single disc, two-speed gearbox |
| IMG/HYS/00248 | Swingo 250 | "250 UCRO" | Swingo 250 Micro (µicro) |
| IMG/HYS/00261 | Swingo 2100 | "walk-behind scrubber dryer" | micro **ride-on** scrubber dryer, 185 kg net |
| IMG/HYS/00252 | Balimat 45 | "battery-powered floor sweeper" | **manual push sweeper**, unpowered, 13 kg |
| IMG/HYS/00253 | Balimat 3300 | "ride-on sweeper" | **walk-behind** sweeper, 137 kg |
| IMG/HYS/00136 | Ergodisc 165 | "Floor Scrubber" | single-disc rotary machine - no recovery tank, no squeegee |
| IMG/HYS/00098 | AERO 8 | implied 8 litre | **13 litre** canister |
| IMG/HYS/00114 | AERO BP Motor Foam Filter | quantity unstated | **pack of 5** |
| IMG/HYS/00124 | Fixomat | "for Vacumat 44T" only | fits vacumat **22T and 44T** |
| IMG/HYS/00119 | Wet vacuum set premium | tied to vacumat 22 | fits vacumat **12, 22, 22T and 44T** |
| IMG/HYS/00121 | Filter disc set | tied to vacumat 22 | fits vacumat **12, 22 and 22T** |
| IMG/HYS/00254 | Battery 7520152 | "12V 76Ah", machine unstated | balimat 3300 **and** swingo 755B–1255; capacity disputed, see §5.3 |

**Five part numbers recovered** where the catalogue held placeholders:

| Product | Was | Now |
|---|---|---|
| ergodisc 165 | `ERGODISC 165` | **8003820** |
| ergodisc duo | `ERGODISK 165 DUO` | **8003990** |
| vacumat 44T | `VACUMAT 44T UK` | **7518178** |
| water tank | `ERGODISC` | **8504390** |
| aquamat | `AQUAMAT 20` | **8003470** |
| BP15 sprayer | `BP 15 Li-ION` | **7524819** |

---

## 5. Open questions for the supplier

### 5.1 Lifecycle - three machines need checking before stocking

| Machine | Status | Evidence |
|---|---|---|
| **balimat 45** | **Discontinued - confirmed** | On legacy URL path; absent from the live sweeper category; absent from the manuals index. **Replacement: balimat 1600** (`990184` basic / `990185` pro) |
| **swingo 250µicro 7524889** | **Superseded** | TASKI's own eshop and Diversey Swiss now sell **7525464 "Starter Kit 2.0"**, with a separate 2.0 information sheet. Published specs look unchanged; what differs is undetermined |
| **vacumat 44T** | **Possibly discontinued** | Legacy URL path; absent from the live Wet & Dry category, which lists only vacumat 22/22T and 12. No replacement identified |
| **BP15 sprayer** | **Being wound down** | Diversey NL and AT eshops flag "This Product is Discontinued"; Diversey CH still shows in stock. No successor exists |
| **ergodisc range** | **Unresolved** | Both product pages live, but the single-disc category index 404s while a new **ULTIMAXX** range dominates the scrubber listings. Looks like a generational transition mid-flight |

### 5.2 The AERO BP B Li-Ion has a materially better sibling

**7524708 (AERO BP B Li-Ion PLUS)** beats the catalogued 7524498 on nearly every axis:
60 min runtime vs 30, 31 l/s vs 22, 15 kPa vs 10, and *lighter* at 4.9 kg vs 5.3. Neither is
formally discontinued, but a buyer comparing them would almost always choose the PLUS.

### 5.3 Battery 7520152 capacity is disputed between official documents

| Source | Rating |
|---|---|
| Sweeper accessory chart | 12 V **81 Ah** |
| Scrubber-drier accessory charts | 12 V **76 Ah** |

Both are official TASKI charts. Published as "76–81 Ah - confirm with distributor".

### 5.4 Other unconfirmed points

- **Whether battery and charger are included** with AERO BP B Li-Ion 7524498. The datasheet
  says "Battery Lithium: Standard" but lists batteries and chargers as separately-coded items.
  A common source of customer complaints.
- **HEPA class on AERO Plus models** - taski.com claims H14; both official information sheets
  say **H13**. Advertise H13.
- **GO HEPA option** - the official sheet says "HEPA Option: No"; the product page markets one.
- **Water tank 8504390 capacity** - not published in any official document reached. One search
  result claimed 10 litres, untraceable. Do not publish a figure.
- **aquamat 20 pump pressure in bar** - not published in either generation of the info sheet.
- **FG2 weight and dimensions** - not published anywhere accessible.
- **FG2 part number 7523261** - derived from the spare-parts list "used for" column, not
  corroborated against a live listing. Legacy code 8504660 also circulates.

---

## 6. Machine reference

| SKU | Catalogue name | Model / part | Official page | Information sheet PDF |
|---|---|---|---|---|
| IMG/HYS/00098 | Taski Aero 8 UK | AERO 8 · 7524255 | [aero-8-15](https://taski.com/product/aero-8-15-8-15-plus/) | [Series II](https://taski.com/wp-content/uploads/2021/08/TASKI-AERO-8-15-Information-Sheet-Series-II.pdf) |
| IMG/HYS/00103 | Taski Aero 15 Plus UK | AERO 15 Plus · 7524258 | [aero-15-15-plus](https://taski.com/product/aero-15-15-plus/) | [Plus Series II](https://taski.com/wp-content/uploads/2021/08/TASKI-AERO-8-15-Plus-Information-Sheet-Series-II.pdf) |
| IMG/HYS/00106 | Taski Go UK | GO · 7524187 | [go](https://taski.com/taski-products/go/) | [Go sheet](https://taski.com/wp-content/uploads/2020/12/Go-Information-Sheet-1.pdf) |
| IMG/HYS/00109 | Taski Aero BP E UK | AERO BP E · 7524495 | [aero-bp](https://taski.com/product/aero-bp/) | [BP sheet](https://taski.com/wp-content/uploads/2020/12/AERO-BP-Information-Sheet.pdf) |
| IMG/HYS/00110 | Taski Aero BP B Li-Ion | AERO BP B · 7524498 | [BP B Li-Ion](https://taski.com/product/7524498-taski-aero-bp-b-li-ion-plus/) | [BP sheet](https://taski.com/wp-content/uploads/2020/12/AERO-BP-Information-Sheet.pdf) |
| IMG/HYS/00118 | Taski Vacumat 22 UK | vacumat 22 · 7517929 | [vacumat-22-22t](https://taski.com/product/vacumat-22-22t/) | [vacumat 22](https://taski.com/wp-content/uploads/2020/12/vacumat-22-Information-Sheet.pdf) |
| IMG/HYS/00127 | Taski Vacumat 44T UK | vacumat 44T · 7518178 | [vacumat-44t](https://taski.com/taski-products/vacumat-44t/) | [vacumat 44T](https://taski.com/wp-content/uploads/2020/12/vacumat-44T_Information-Sheet.pdf) |
| IMG/HYS/00228 | Taski Aquamat 20.01 UK | aquamat 20 · 8003470 | [aquamat-20](https://taski.com/product/aquamat-20/) | [aquamat 20](https://taski.com/wp-content/uploads/2021/05/Aquamat-20_-Information-Sheet.pdf) |
| IMG/HYS/00136 | Ergodisc 165 UK | ergodisc 165 · 8003820 | [ergodisc-165](https://taski.com/taski-products/ergodisc-165/) | [ergodisc 165](https://taski.com/wp-content/uploads/2020/12/ergodisc-165-Information-Sheet.pdf) |
| IMG/HYS/00148 | Taski Ergodisc Duo | ergodisc duo · 8003990 | [ergodisc-duo](https://taski.com/taski-products/ergodisc-duo/) | [ergodisc duo](https://taski.com/wp-content/uploads/2020/12/ergodisc-duo-Information-Sheet.pdf) |
| IMG/HYS/00248 | Taski Swingo 250 Micro | swingo 250µicro · 7524889 | [swingo-250µicro](https://www.taski.com/taski-products/swingo-250%C2%B5icro/) | linked from product page |
| IMG/HYS/00261 | Swingo 2100 Micro BMS UK | swingo 2100µicro · 7523422 | [swingo-2100](https://taski.com/taski-products/swingo-2100/) | [swingo 2100](https://taski.com/wp-content/uploads/2020/12/swingo-2100-Information-Sheet.pdf) |
| IMG/HYS/00252 | Taski Balimat 45 Sweeper | balimat 45 · 8004690 | [balimat-45](https://taski.com/product/balimat-45/) | none exists |
| IMG/HYS/00253 | Balimat 3300 RTU Sweeper | balimat 3300 RTU · 7524906 | [balimat-3300](https://taski.com/taski-products/balimat-3300/) | [balimat 3300](https://taski.com/wp-content/uploads/2021/04/balimat-3300-Information-Sheet-1.pdf) |
| IMG/HYS/00140 | Taski Foam Generator FG2 | FG2 · 7523261 / 8504660 | **none exists** | [spare parts list](https://shop.monsterjanitorial.com/content/Taski/Part%20Manuals/foam%20generator%20FG2.pdf) |
| IMG/HYS/00170 | Taski Sprayer BP 15 Li-Ion | BP15 · 7524819 | [sprayer-bp-15](https://taski.com/product/sprayer-bp-15-li-ion/) | [BP15 sheet](https://m.media-amazon.com/images/I/61VUkovZ8ZL.pdf) |
| IMG/HYS/00135 | Water Tank for Ergodisc | 8504390 | none - accessory only | see single-disc chart |

Note the swingo 2100µicro page **404s** under both `%C2%B5` and `%c2%b5` encodings - use the
plain `swingo-2100/` slug.

---

## 7. Part-number to machine compatibility

**The accessory charts are the authority, not the machine information sheets.** See §9 for why.

| Chart | URL |
|---|---|
| Vacumats | <https://taski.com/wp-content/uploads/2020/12/Accessories-vacumats.pdf> |
| Single discs (ergodisc) | <https://taski.com/wp-content/uploads/2020/12/Accessories-single-discs.pdf> |
| Scrubber driers 150–755 | <https://taski.com/wp-content/uploads/2020/12/Accessories-scrubber-driers-150-755-1.pdf> |
| Scrubber driers 855–1850 | <https://taski.com/wp-content/uploads/2020/12/Accessories-scrubber-driers-855-1850.pdf> |
| Ride-on scrubber driers | <https://taski.com/wp-content/uploads/2026/05/Accessories-Ride-on-Scrubber-driers-V2.pdf> |
| Sweepers | <https://taski.com/wp-content/uploads/2021/04/Accessory-list-Sweepers.pdf> |

### Vacuum bags and filters

| Part | What it is | Fits |
|---|---|---|
| 7524288 | Fleece dust bags, 10 pc | AERO 8, 8 Plus, 15, 15 Plus |
| 7524289 | Paper dust bags, 10 pc | AERO 8, 8 Plus, 15, 15 Plus |
| 7524191 | Paper dust bags, 10 pc | **GO only** |
| 7524500 | Fleece dust bags, 10 pc | **AERO BP** E, B Li-Ion, B Li-Ion PLUS |
| 7524501 | Motor foam filter, **5 pc** | AERO BP E, B Li-Ion, B Li-Ion PLUS |
| 8504940 | Double-layer paper bags, 10 pc | vacumat 22, 22T |
| 4091150 | Filter disc set, 10 parts | vacumat 12, 22, 22T |

### Vacuum accessories

| Part | What it is | Fits |
|---|---|---|
| 7524189 | Standard accessory set, 32 mm | **GO only** |
| 7524295 | Telescopic metal wand, 32 mm | AERO 8, 8 Plus, 15, 15 Plus |
| 7524502 | Suction hose, 1.5 m | AERO BP E, B Li-Ion |
| 8504480 | Wet vacuum kit, premium | vacumat 12, 22, 22T, **44T** |
| 8504930 | Dry vacuum kit | vacumat 22, 22T |
| 8504500 | Dry vacuum kit | vacumat 12 only |
| 8505420 | Fixomat squeegee, 64 cm | vacumat 44T **and 22T** |
| 8505160 | Spray extraction tool set | aquamat 20 (**required**), procarpet 30, 45 |

### Single-disc (ergodisc) tools

| Part | What it is | Fits |
|---|---|---|
| 8504410 | Disc drive 43 cm, standard speed | ergodisc 165, 200, HD, duo |
| 7510030 | Disc drive 43 cm, **high speed** | ergodisc **duo, 400** only |
| 8504750 | Scrubbing brush 43 cm, standard | ergodisc 165, 200, HD, duo **+ swingo 455B, 755B** |
| 8504830 | Dry shampooing brush 43 cm | ergodisc 165, duo |
| 8504860 | Wet shampooing brush 43 cm | ergodisc 165, 200, duo |
| 8505010 | Hand shampooing set (manual) | companion to ergodisc 165, duo |
| 8504390 | Water / solution tank | ergodisc 165, HD, duo (also 175, 200, 400) |

### Scrubber-drier tools

| Part | What it is | Fits |
|---|---|---|
| 7510829 | Pad drive 43 cm | **swingo** 455B, 755B Eco, 755B Power |
| 7510634 | Pad drive 28 cm | swingo 955, 1255, 2100µicro - **2 per machine** |
| 7519395 | Scrubbing brush 28 cm | swingo 955, 1255, 2100µicro - **2 per machine** |
| 7524893 | Scrubbing brushes 225 mm | swingo 250µicro - pair |
| 7524894 | Pad drive discs 225 mm | swingo 250µicro - pair |

### Batteries, chargers and sweeper brooms

| Part | What it is | Fits |
|---|---|---|
| 7524891 | NX lithium battery 37 V 8.1 Ah | swingo 250µicro |
| 7524892 | NX charger 100–240 V | NX batteries / swingo 250µicro |
| 7514962 | Gel traction block 6 V 180 Ah | swingo 1650, 1850, 2100µicro, XP-R (**4 per machine**); balimat 6500 |
| 7520152 | Gel traction block 12 V 76–81 Ah | balimat 3300; swingo 755B, 855B, 955 (2); swingo 1255 (4) |
| 7524909 | Centre broom, 500 mm | balimat 3300 |
| 7524910 | Side broom, 354 mm | balimat 3300 |

### ⚠ The one to be careful with

**8504410 and 7510829 are both 43 cm drive discs for different machine families and are not
interchangeable.** 8504410 is ergodisc; 7510829 is swingo. The catalogue previously described
7510829 as an ergodisc part. Both entries now cross-reference each other.

---

## 8. Unidentified parts

Three catalogue entries have **no part number** (blank or `-`) and were not researched.
Likely matches from adjacent-SKU listings - **all three since confirmed during the July 2026
image-sourcing pass, see §10.1**:

| SKU | Catalogue name | Likely part | Basis |
|---|---|---|---|
| IMG/HYS/00226 | Scrubbing Brush Abrasive 43 | **8504780** | Abrasive-grade sibling of the 8504750 standard brush |
| IMG/HYS/00229 | Filter Cloth with Ring for Vacumat 44T | **8505500** | Exact name match: "Filtercloth with ring for vacumat 44T dry cleaning" |
| IMG/HYS/00230 | Accessories Set for Aquamat 10.1 | **8505140** | Confirmed elsewhere as the required spray-extraction set for aquamat 10/10.1 |

---

## 9. Documented pitfalls

### 9.1 The ergodisc information sheets are typeset wrong

**The accessory tables in the ergodisc information-sheet PDFs have the SKU column offset by
one row against the accessory names.** Reading those PDFs directly pairs every accessory with
the wrong part number - the duo sheet pairs "Water tank" with 8504410 instead of 8504390.

Anyone cross-checking our numbers against those PDFs will hit this and conclude our data is
wrong. **Use the accessory charts in §7, not the machine information sheets.**

### 9.2 Extracting the charts correctly

The charts are compatibility grids. Naive text extraction collapses columns and destroys the
alignment, silently producing wrong compatibility. The reliable method is mapping each mark by
**x-coordinate against the column header positions**. Mark glyphs sit ~3 px right for `o` vs
`(x)`; column pitch is ~50–78 px, so this never becomes ambiguous.

### 9.3 Known blocks and dead links

403 to automated access, fine in a browser: `products.solenis.com`, `eshop.diversey.*`,
`technochef.eu`, `ekuep.com`, `usaclean.com`, `manualzz.com`, `magazineluiza.com.br`.

Dead: `taski.com/gb/downloads/` (404) · the ride-on accessory chart moved from `/2020/12/`
to `/2026/05/` · `ckconsumables.com` product URLs (404) · swingo 2100µicro page under µ-encoded
slugs (404).

The **Instructions of Use index** loads its PDF links behind JavaScript accordions - the page
confirms which manuals exist but does not expose URLs to a fetch. Open it in a browser.

---

## 10. Image sourcing

**The official information-sheet PDFs are the best source.** Page 1 of each carries a large,
clean, white-background studio render in current brand livery. Every sheet linked in §6 was
downloaded and verified during this research.

Ranked:

1. **Official information-sheet PDFs** (§6) - white-background hero renders
2. **taski.com product pages** - gallery images, also white background
3. **Official brochures** - best lifestyle and detail photography. The
   [balimat range brochure](https://taski.com/wp-content/uploads/2021/04/TASKI-Balimat-brochure.pdf)
   (6.8 MB) and the swingo 250µicro brochures are the strongest
4. **astralhygiene.co.uk** - the most spec-accurate distributor found, white-background photos
5. **dobmeierjanitorialsupplies.com** - useful for accessories that have no official page

**Exceptions with no official image:**

- **Water tank 8504390** - no dedicated product page anywhere. Best standalone shot is the
  Dobmeier listing; otherwise use a photo of the tank mounted on an ergodisc.
- **FG2** - no taski.com page at all. The spare-parts list PDF (§6) has an excellent
  white-background photo on page 1.
- **balimat 45** - no information sheet. Use the product page or USA-CLEAN.

Loose product JPGs also sit under `taski.com/wp-content/uploads/2020/12/`, including
`Aero_Group-image-scaled.jpg` and the `TASKI_AERO_BP_E.jpg` series.

### 10.1 Accessory image URLs - verified July 2026

The 35 accessory/consumable SKUs shipped without images. Per-part sources below; every
direct URL returned HTTP 200 when checked.

**Correction to §1:** `taski.com/?s=<partnumber>` does **not** work for most accessories -
site search returns 0 results for them. Only some accessories have `/product/` pages
(found by guessing the slug or via web search). Official imagery for the rest lives on the
regional `eshop.diversey.*` shops, which are 403 to automation but fine in a browser.

**Part numbers confirmed for all three §8 unidentified parts:** 8504780 (abrasive brush,
via Suvacor + Solenis slug + the single-disc accessory chart), 8505500 (44T filter cloth,
via Altruan MPN + Diversey UK slug, EAN 7615400501854), 8505140 (aquamat 10.1 set - official
name is "Spray extraction with hose", required for aquamat 10/10.1).

**Direct downloads - official taski.com** (all white-background studio shots):

| SKU | Part | Image URL |
|---|---|---|
| IMG/HYS/00100 | 7524288 | <https://taski.com/wp-content/uploads/2021/01/AERO-ACC-7524288_WH-1.jpg> |
| IMG/HYS/00101 | 7524289 | <https://taski.com/wp-content/uploads/2021/01/7524289-TASKI-AERO-8_15-filter-paper-bags-10pc.jpg> |
| IMG/HYS/00107 | 7524191 | <https://taski.com/wp-content/uploads/2021/01/7524191_TASKI-go-Papiersack-10-Stuck.jpg> |
| IMG/HYS/00108 | 7524189 | <https://taski.com/wp-content/uploads/2021/01/7524189-TASKI-go-standard-accessory-set-32-mm.jpg> |
| IMG/HYS/00113 | 7524500 | <https://taski.com/wp-content/uploads/2021/01/7524500-TASKI-AERO-BP-Disposable-Fleece-Bags-10pc-CMYK-20x20cm.jpg> |
| IMG/HYS/00119 | 8504480 | <https://taski.com/wp-content/uploads/2021/01/8504480-Set-wet-vacuum-cleaning-Premium.jpg> |
| IMG/HYS/00120 | 8504940 | <https://taski.com/wp-content/uploads/2021/01/8504940-Pa-of-10-double-filter-bags.jpg> |
| IMG/HYS/00121 | 4091150 | <https://taski.com/wp-content/uploads/2021/01/4091150-30014-61-Filter-Disc-Set-10-Parts-1.jpg> |
| IMG/HYS/00172 | 8505160 | <https://taski.com/wp-content/uploads/2021/01/8505160-Accessories-set-aquamat-20.jpg> |
| IMG/HYS/00218 | 8504930 | <https://taski.com/wp-content/uploads/2021/01/8504930-Kit-dry-vacuum-cleaning-vacumat-22.jpg> |
| IMG/HYS/00230 | 8505140 | <https://taski.com/wp-content/uploads/2021/01/8505140-Spray-extraction-with-hose.jpg> |
| IMG/HYS/00240 | 8504500 | <https://taski.com/wp-content/uploads/2021/01/8504500-Kit-dry-vacuum-cleaning-vacumat-12.jpg> |
| IMG/HYS/00254 | 7520152 | <https://taski.com/wp-content/uploads/2021/02/Gel-batteries.png> - generic gel-battery family shot, not block-specific |

**Direct downloads - distributor-hosted** (white background; Dobmeier files are official
Diversey press shots, pattern `dobmeierjanitorialsupplies.com/assets/product-images/Diversey-TASKI-<part>.jpg`):

| SKU | Part | Image URL |
|---|---|---|
| IMG/HYS/00111 | 7524295 | <https://www.galgormgroup.com/images/XL/7524295XLG.jpg> |
| IMG/HYS/00124 | 8505420 | <https://www.dobmeierjanitorialsupplies.com/assets/product-images/Diversey-TASKI-8505420.jpg> |
| IMG/HYS/00133 | 8504410 | <https://suvacor.com/wp-content/uploads/2024/02/8504410.jpg> - Suvacor is a **Kenyan** distributor |
| IMG/HYS/00134 | 8504750 | <https://www.dobmeierjanitorialsupplies.com/assets/product-images/Diversey-TASKI-8504750.jpg> - use this file; the Dobmeier *page* displays neighbouring SKU 8504770's photo |
| IMG/HYS/00141 | 8504830 | <https://www.dobmeierjanitorialsupplies.com/assets/product-images/Diversey-TASKI-8504830.jpg> |
| IMG/HYS/00143 | 8505010 | <https://www.dobmeierjanitorialsupplies.com/assets/product-images/Diversey-TASKI-8505010.jpg> |
| IMG/HYS/00152 | 7510030 | <https://www.dobmeierjanitorialsupplies.com/assets/product-images/Diversey-TASKI-7510030.jpg> |
| IMG/HYS/00160 | 7510829 | <https://www.dobmeierjanitorialsupplies.com/assets/product-images/Diversey-TASKI-7510829.jpg> - filename-verified as the swingo part, not ergodisc 8504410 |
| IMG/HYS/00226 | 8504780 | <https://suvacor.com/wp-content/uploads/2025/06/8504780-1000x1000.jpeg> (alt: Dobmeier `Diversey-TASKI-8504780.jpg`) |
| IMG/HYS/00229 | 8505500 | <https://altruan.com/cdn/shop/files/8505500-Filtertuch-VAC44.jpg?width=1946> |
| IMG/HYS/00249 | 7510634 | <https://www.dobmeierjanitorialsupplies.com/assets/product-images/Diversey-TASKI-7510634.jpg> |
| IMG/HYS/00250 | 7519395 | <https://www.dobmeierjanitorialsupplies.com/assets/product-images/Diversey-TASKI-7519395.jpg> |
| IMG/HYS/00251 | 7514962 | <https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/7514962.jpg/h=420> - raise `h=` for higher res |
| IMG/HYS/00256 | 7524910 | <https://altruan.com/cdn/shop/files/Seitenbesen-Balimat3300_Ersatz-SeitenbesenfuerdenBalimat3300.jpg?width=1946> |
| IMG/HYS/00260 | 7524892 | <https://www.pamark.fi/media/catalog/product/cache/4be342ae2419566741c46cd39a82cceb/8/5/850a9d53510e27703ccc61b65f0687b533c3f1f1_7524892_1.jpg> |

**Needs a human browser** (listings confirmed to exist but 403 to automation, or no clean
photo found - grab from these pages):

| SKU | Part | Where |
|---|---|---|
| IMG/HYS/00112 | 7524502 suction hose | <https://eshop.diversey.co.uk/floor-care-machines/vacuum-cleaners/vacuum-cleaner-accessories/taski-aero-bp-suction-hose-1pc-150-cm-7524502> - do **not** use Dobmeier's image; it is a generic `TASKI-Parts.jpg` placeholder |
| IMG/HYS/00114 | 7524501 motor foam filter | <https://products.solenis.com/de/product/taski-aero-bp-motor-filter-5x-staubfilter-auf-schaumstoffbasis-fur-den-taski-aero-bp-7524501> - same Dobmeier-placeholder warning |
| IMG/HYS/00142 | 8504860 wet shampoo brush | No fetchable distributor photo anywhere. Extract the white-bg thumbnail from page 1 of <https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf>, or browser-grab <https://eshop.diversey.fr/en-GB/product/taski-brush-wet-shampooing-1pc-17-43-cm-8504860> |
| IMG/HYS/00255 | 7524909 centre broom | <https://eshop.diversey.be/fr-BE/product/center-broom-b3300-1pc-7524909> - **Altruan's 7524909 image is wrong** (it reuses the side-broom disc photo; the centre broom is a 500 mm roller) |
| IMG/HYS/00257 | 7524893 brushes 225 mm | <https://shop.usaclean.com/standard-brush-pkg-of-2-292-5807/> or eshop.diversey.swiss |
| IMG/HYS/00258 | 7524894 pad drives 225 mm | <https://shop.usaclean.com/pad-driver-pkg-of-2-292-5809/> |
| IMG/HYS/00259 | 7524891 NX battery | <https://eshop.diversey.co.uk/product/nx-li-ion-battery-37v-8100m-81ah-1pc-7524891> - beware: Pamark's page slugged "…7524891" actually shows the **charger** |

Also surfaced: the NAM accessory-list PDF (<https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf>)
carries white-bg thumbnails + official names for the whole single-disc tool range, and
Astral Hygiene's Balimat 3300 accessory table is off by one row (it pairs 7524910 with
"Center broom" - 7524911 is actually the balimat 6500 machine SKU; trust the Diversey eshops).

### 10.2 Accessory product pages - for manual verification

Same 35 SKUs, as clickable product pages rather than direct image links - for checking specs,
compatibility, and part-name wording against the catalogue by hand, same as the machine
reference in §6. `eshop.diversey.*` and `products.solenis.com` links 403 to automated fetches
but load fine in a browser.

| SKU | Catalogue name | Part | Product page(s) |
|---|---|---|---|
| IMG/HYS/00100 | Taski Aero 8/15 Disp. Fleece Bags 10PC | 7524288 | [taski.com](https://taski.com/product/7524288-taski-aero-8-15-disp-fleece-bags-10pc/) |
| IMG/HYS/00101 | Taski Aero 8/15 Filter Paper Bags 10PC | 7524289 | [taski.com](https://taski.com/product/7524289-taski-aero-8-15-filter-paper-bags-10pc/) |
| IMG/HYS/00107 | Taski Go Filter Paper Bags 10PC | 7524191 | [taski.com](https://taski.com/product/7524191-taski-go-paper-bag-10-pc/) |
| IMG/HYS/00108 | Taski Go Basic Accessory Set 32MM | 7524189 | [taski.com](https://taski.com/product/7524189-taski-go-standard-accessory-set-32-mm/) |
| IMG/HYS/00111 | Taski Aero Telescopic Tube 32MM | 7524295 | not on taski.com - [Galgorm Group](https://www.galgormgroup.com/item/7524295/Taski-Aero-Telescopic-Tube-32mm/FP), [Bunzl CHS](https://www.bunzlchs.com/Cleaning-Machinery/Vacuum-Cleaners-and-Accessories/Vacuum-Cleaner-Accessories/TASKI-AERO-Telescopic-Tube-32MM~p~177012), [Solenis](https://products.solenis.com/product/taski-aero-telescoping-metal-wand-1ea-1ct-D7524295) |
| IMG/HYS/00112 | Taski Aero BP Suction Hose 1.5M | 7524502 | not on taski.com - [Diversey CH](https://eshop.diversey.swiss/en-GB/product/taski-aero-bp-suction-hose-1pc-150-cm-7524502), [Diversey UK](https://eshop.diversey.co.uk/floor-care-machines/vacuum-cleaners/vacuum-cleaner-accessories/taski-aero-bp-suction-hose-1pc-150-cm-7524502) |
| IMG/HYS/00113 | Taski Aero BP Disp. Fleece Bags 10PC | 7524500 | [taski.com](https://taski.com/product/7524500-taski-aero-bp-disposable-fleece-bags-10pc/), [Almec](https://almec.com/taski-aero-bp-dust-bag-TSK0014/) |
| IMG/HYS/00114 | Taski Aero BP Motor Foam Filter | 7524501 | not on taski.com - [Solenis DE](https://products.solenis.com/de/product/taski-aero-bp-motor-filter-5x-staubfilter-auf-schaumstoffbasis-fur-den-taski-aero-bp-7524501) |
| IMG/HYS/00119 | Set Wet Vacuum Cleaning Premium | 8504480 | [taski.com](https://taski.com/product/8504480-set-wet-vacuum-cleaning-premium/) |
| IMG/HYS/00120 | Pa of 10 Double Filter Bags | 8504940 | [taski.com](https://taski.com/product/8504940-pa-of-10-double-filter-bags/) |
| IMG/HYS/00121 | 30014-61 Filter (10 Parts) | 4091150 | [taski.com](https://taski.com/product/4091150-30014-61-filter-disc-set-10-parts-2/) |
| IMG/HYS/00124 | Fixomat for Vacumat 44T | 8505420 | not on taski.com - [Dobmeier](https://www.dobmeierjanitorialsupplies.com/TASKI-Fixomat-Front-Mount-Squeegee-For-vacumat-44T-SKU-TASKI-8505420), [Hill & Markes](https://www.hillnmarkes.com/2415893/product/diversey-div8505420) |
| IMG/HYS/00133 | Driving Disc Ergodisc D43 | 8504410 | not on taski.com - [Suvacor](https://www.suvacor.com/shop/driving-disc-ergodisc-d43/) (Kenyan distributor), [Solenis UK](https://products.solenis.com/en-GB/product/taski-ergodisc-driving-disc-low-speed-1pc-17-43-cm-pad-drive-standard-speed-8504410), [Diversey UK](https://eshop.diversey.co.uk/product/taski-ergodisc-driving-disc-low-speed-1pc-17-43-cm-pad-drive-standard-speed-8504410) |
| IMG/HYS/00134 | Scrubbing Brush Uni 43 | 8504750 | not on taski.com - [Dobmeier](https://www.dobmeierjanitorialsupplies.com/TASKI-17in-Hard-Scrubbing-Brush-SKU-TASKI-8504-750), [Suvacor](https://www.suvacor.com/shop/scrubbing-brush-43/) |
| IMG/HYS/00141 | Shampooing Brush Dry D43 | 8504830 | not on taski.com - [Dobmeier](https://www.dobmeierjanitorialsupplies.com/TASKI-17in-Dry-Shampooing-Brush-SKU-TASKI-8504-830), [Diversey UK](https://eshop.diversey.co.uk/product/taski-brush-dry-shampooing-1pc-17-43-cm-8504830) |
| IMG/HYS/00142 | Shampooing Brush Wet D43 | 8504860 | not on taski.com - [Diversey FR](https://eshop.diversey.fr/en-GB/product/taski-brush-wet-shampooing-1pc-17-43-cm-8504860), [USA-Clean](https://shop.usaclean.com/wet-shampoo-brush-192-9451/), [Southeastern Equipment](https://www.southeasternequipment.net/product-p/tkd8504860.htm), [Suvacor](https://www.suvacor.com/shop/shampooing-brush-wet-d43/) |
| IMG/HYS/00143 | Hand Shampooing Set | 8505010 | not on taski.com - [Dobmeier](https://www.dobmeierjanitorialsupplies.com/TASKI-Hand-Brush-Set-SKU-TASKI-8505-010), [Solenis](https://products.solenis.com/product/taski-carpet-care-hand-shampooing-set-1pc-8505010) |
| IMG/HYS/00152 | High-Speed Driving Disc 43/01 | 7510030 | not on taski.com - [Dobmeier](https://www.dobmeierjanitorialsupplies.com/TASKI-17in-Pad-Driver-Disc-For-ergodisc-200-SKU-TASKI-7510030), [Solenis IE](https://products.solenis.com/en-IE/product/taski-ergodisc-driving-disc-low-speed-1pc-17-43-cm-highspeed-taski-ergodisc-duo-400-7510030) |
| IMG/HYS/00160 | Pad Driver 43CM | 7510829 | not on taski.com - [Dobmeier](https://www.dobmeierjanitorialsupplies.com/TASKI-Pad-Holder-For-750B-%26-750E-SKU-TASKI-7510829) ("fits swingo 750B/750E and swingo 455"), [Diversey UK](https://eshop.diversey.co.uk/product/pad-driver-1pc-17-43-cm-for-taski-swingo-455-755-7510829) - **swingo part, not ergodisc** |
| IMG/HYS/00172 | Accessories Set Aquamat 20/PROCARPET | 8505160 | [taski.com](https://taski.com/product/8505160-accessories-set-aquamat-20/) |
| IMG/HYS/00218 | Kit Dry Vacuum Cleaning Vacuum 22 | 8504930 | [taski.com](https://taski.com/product/8504930-kit-dry-vacuum-cleaning-vacumat-22/) |
| IMG/HYS/00226 | Scrubbing Brush Abrasive 43 | 8504780 *(recovered, see §8)* | not on taski.com - [Suvacor](https://www.suvacor.com/shop/scrubbing-brush-abrasive-43/), [Solenis](https://products.solenis.com/product/taski-scrubbing-brush-abrasive-1pc-1ct-17-43-cm-D8504780) |
| IMG/HYS/00229 | Filter Cloth with Ring for Vacumat 44T | 8505500 *(recovered, see §8)* | not on taski.com - [Altruan](https://altruan.com/products/filter-cloth-with-ring-for-vacumat-44t-to-dry-eyes-with-taski-vacumat-44-t-pack-1-piece) (EAN 7615400501854), [Diversey UK](https://eshop.diversey.co.uk/product/filtercloth-with-ring-for-vacumat-44t-1pc-8505500) |
| IMG/HYS/00230 | Accessories Set for Aquamat 10.1 | 8505140 *(recovered, see §8)* | [taski.com](https://taski.com/product/8505140-spray-extraction-with-hose/) - official name is "Spray extraction with hose" |
| IMG/HYS/00240 | Set of Dry Vacuums Taski Vacumat 12 | 8504500 | [taski.com](https://taski.com/product/8504500-kit-dry-vacuum-cleaning-vacumat-12/) |
| IMG/HYS/00249 | Pad Driver 28CM | 7510634 | not on taski.com - [Dobmeier](https://www.dobmeierjanitorialsupplies.com/TASKI-11in-Pad-Drive-Disc-For-swingo-1255-B-SKU-TASKI-7510634), [Diversey UK](https://eshop.diversey.co.uk/product/pad-driver-1pc-11-28-cm-for-taski-swingo-955-1255-2100-5000-7510634) |
| IMG/HYS/00250 | Scrubbing Brush 28 | 7519395 | not on taski.com - [Dobmeier](https://www.dobmeierjanitorialsupplies.com/TASKI-11in-Hard-Nylon-Scrubbing-Brush-for-swingo-1250-1255-SKU-TASKI-7519395), [Monster Janitorial](https://shop.monsterjanitorial.com/taski-7519395-11-inch-hard-nylon-scrubbing-brush-white-192-9431/), [Diversey DE](https://eshop.diversey.de/en-GB/product/taski-scrubbing-brush-standard-1x1pc-11-28-cm-taski-swingo-955-1255-2100-5000-7519395) |
| IMG/HYS/00251 | BATTERY TRACTION 6V, 180Ah/5 | 7514962 | not on taski.com - [Carel Lurvink](https://www.carellurvink.nl/p/7514962/7514962-taski-batterij-t-b-v-swingo-machines) |
| IMG/HYS/00254 | BATTERY TRACTION BLOCK 12V 76Ah/5 | 7520152 | [taski.com](https://taski.com/product/gelbattery-traction-block-12v-76ah/), [Droppe](https://droppe.com/de-en/product/div-7520152+diversey-traction-battery-block-12v-76ah) |
| IMG/HYS/00255 | Center Broom B3300 | 7524909 | not on taski.com - [Diversey BE](https://eshop.diversey.be/fr-BE/product/center-broom-b3300-1pc-7524909), [Altruan](https://altruan.com/products/main-brush-balimat-3300-substitute-for-the-balimat-3300-pack-1-piece) - **Altruan's photo is wrong, see §10.1** |
| IMG/HYS/00256 | Side Broom B3300 | 7524910 | not on taski.com - [Altruan](https://altruan.com/products/side-broom-balimat-3300-replacement-side-broom-for-the-balimat-3300-pack-1-piece) |
| IMG/HYS/00257 | Brush 225MM 2PC | 7524893 | not on taski.com - [Diversey CH](https://eshop.diversey.swiss/product/scheuerburste-2x1stk-scheuerburste-225mm-fur-taski-swingo-250-7524893), [Solenis DK](https://products.solenis.com/da/product/taski-swingo-250-vaskeborste-2x1stk-7524893), [USA-Clean](https://shop.usaclean.com/standard-brush-pkg-of-2-292-5807/) |
| IMG/HYS/00258 | Disc Drive 225MM 2PC | 7524894 | not on taski.com - [USA-Clean](https://shop.usaclean.com/pad-driver-pkg-of-2-292-5809/) |
| IMG/HYS/00259 | NX LI-ON BATTERY 37V 8100M 8.1 Ah | 7524891 | not on taski.com - [Diversey DE](https://eshop.diversey.de/de-de/nx-li-ion-battery-37v-8100m-8-1ah-1stk-7524891), [Diversey UK](https://eshop.diversey.co.uk/product/nx-li-ion-battery-37v-8100m-81ah-1pc-7524891), [Diversey FI](https://eshop.diversey.fi/en-GB/product/nx-li-ion-battery-37v-8100m-81ah-1pc-7524891), [USA-Clean](https://shop.usaclean.com/nx-battery-292-5805/) |
| IMG/HYS/00260 | NX Charger 100-240V/50/60HZ | 7524892 | not on taski.com - [Pamark](https://www.pamark.fi/siivous/siivouskoneet-ja-vaunut/yhdistelmakoneet/yhdistelmakoneiden-varusteet/taski-nx-latauslaite-li-ion-akulle-7524891) (page slugged "7524891" but content is the charger), [Diversey DE](https://eshop.diversey.de/product/nx-ladegerat-1stk-7524892), [USA-Clean](https://shop.usaclean.com/nx-charger-292-5806/) |

---

## 11. Related models not in the catalogue

Surfaced during research, if the range is worth filling:

- **AERO 8 FLEXX** - cordless AERO, 90 min runtime, HEPA H13 standard
- **AERO 15 Power** - 800 W motor, UK part 7524943, above the Plus
- **AERO BP B Li-Ion PLUS** (7524708) - see §5.2
- **GO2** - newer, smaller companion to the GO (8 L, 700 W, 5.4 kg)
- **vacumat 12** - below the 22 in the wet/dry range
- **aquamat 10.1** (7511181) - 10 L carpet extractor below the aquamat 20
- **procarpet 30 / 45** - newer 2-in-1 extraction and encapsulation range, above the aquamats
- **ergodisc 200, HD, 400, flexx 43** - the rest of the single-disc line
- **balimat 1600** (`990184` / `990185`) - the balimat 45's replacement
- **balimat 2300, 6500, 6500 HD** - the rest of the sweeper range
- **swingo 150B, 455B, 755B, 855B, 955, 1255, 1650, 1850, XP-R** - the scrubber-drier range
- **ULTIMAXX 900 / 1900 / 2900** - TASKI's new generation, each in Single Disc, Double Disc,
  Roller Brush and Orbital deck variants. Worth watching: this range is visibly displacing the
  older swingo and ergodisc naming

---

## 12. Image sourcing (July 2026)

First image pass ever run on TASKI. All 52 SKUs were worked. Files are staged in
`C:\Users\jonah.wakahiu\Desktop\ecommerce\products resource\taski-images\`, with non-product
material in `taski-images\_brand-reference\`. **Nothing was copied into the Laravel project and
`products.json` was not touched.** Every file below was opened and visually checked.

### 12.1 Coverage - stated plainly, not rounded up

**49 of the 52 SKUs got an image of the exact catalogued part. 3 got nothing.**
Of the 49, **30 clear the 800 px floor** and **19 sit below it** and are suffixed `-TOOSMALL`
against a proven ceiling (see §12.2). **No SKU is carried by a merely representative photo** -
where the exact part could not be evidenced, nothing was staged rather than something plausible.
There is no `REPRESENTATIVE-` file in the folder and there was never meant to be one.

The split that matters here is machine vs consumable. The 52 SKUs are **16 machines** and
**36 consumables and spares**. A machine is identifiable on sight; a pad, brush, squeegee blade
or filter is not, so a generic photo on a consumable is the realistic way a wrong part reaches a
product page - and §12.3 shows it has already happened three times in this catalogue. Every
consumable below was therefore tied to its part number by one of three things: a part-number-keyed
distributor file path, a part number moulded or printed on the item in frame, or a row-matched
thumbnail from official TASKI literature. Nothing was accepted on category resemblance alone.

| Bucket | Machines | Consumables / spares | Total |
|---|---|---|---|
| Exact model, at or above the 800 px floor | 11 | 19 | **30** |
| Exact model, below 800 px, ceiling proven | 5 | 14 | **19** |
| Nothing staged | 0 | 3 | **3** |
| **Total** | **16** | **36** | **52** |

**Exact model, at or above the 800 px floor - 30 SKUs**

*Machines (11)* - `IMG/HYS/00098` · `00103` · `00106` · `00109` · `00110` · `00136` · `00148` ·
`00248` · `00252` · `00253` · `00261`

*Consumables and spares (19)* - `IMG/HYS/00100` · `00101` · `00107` · `00108` · `00111` ·
`00113` · `00119` · `00124` · `00134` · `00160` · `00226` · `00230` · `00249` · `00250` ·
`00251` · `00257` · `00258` · `00259` · `00260`

**Exact model, below 800 px, ceiling proven - 19 SKUs**

*Machines (5)* - `IMG/HYS/00118` · `00127` · `00140` · `00170` · `00228`
*Consumables and spares (14)* - the remaining rows of this table.

| SKU | Part | Best available | Ceiling evidence |
|---|---|---|---|
| IMG/HYS/00118 | vacumat 22 | 709x709 | taski.com WP media reports the original attachment as 709x709; no distributor exceeds it |
| IMG/HYS/00120 | 8504940 | 500x500 | taski.com original is 500x500 |
| IMG/HYS/00121 | 4091150 | 500x500 | taski.com original is 500x500 |
| IMG/HYS/00127 | vacumat 44T | 709x709 | taski.com original; Astral, Serfinity and Sweeper Centers all smaller |
| IMG/HYS/00133 | 8504410 | 709x709 | official NAM accessory-list embedded image |
| IMG/HYS/00135 | 8504390 | 709x709 | official NAM accessory-list embedded image |
| IMG/HYS/00140 | FG2 | 709x709 | embedded image on p1 of the FG2 spare-parts list; no other photo exists |
| IMG/HYS/00141 | 8504830 | 709x709 | official NAM accessory-list embedded image |
| IMG/HYS/00142 | 8504860 | 709x709 | official NAM list; USA-Clean BigCommerce `original` returns 500x500 |
| IMG/HYS/00143 | 8505010 | 709x709 | official NAM accessory-list embedded image |
| IMG/HYS/00152 | 7510030 | 709x709 | official NAM accessory-list embedded image |
| IMG/HYS/00170 | BP15 sprayer | 500x750 | taski.com original; product is being wound down, no dealer photography found |
| IMG/HYS/00172 | 8505160 | 500x500 | taski.com original; Carel Lurvink only 387x600 |
| IMG/HYS/00218 | 8504930 | 500x500 | taski.com original is 500x500 |
| IMG/HYS/00228 | aquamat 20 | 709x709 | taski.com original; Astral serves the same 709 file |
| IMG/HYS/00229 | 8505500 | 709x709 | Shopify master on Altruan is 709x709 - see §12.4 |
| IMG/HYS/00240 | 8504500 | 500x500 | taski.com original is 500x500 |
| IMG/HYS/00254 | 7520152 | 432x593 | Carel Lurvink master; taski.com carries only a 258x258 range shot |
| IMG/HYS/00256 | 7524910 | 474x474 | Shopify master on Altruan is 474x474 |

**Nothing staged - 3 SKUs, all three of them consumables. This is deliberate abstention, not an
oversight.**

| SKU | Part | Why nothing was staged |
|---|---|---|
| IMG/HYS/00112 | 7524502 AERO BP suction hose 1.5 m | The only listings are `eshop.diversey.*` and `products.solenis.com`, both HTTP 403 to automation. Dobmeier serves a generic `TASKI-Parts.jpg` placeholder. A generic vacuum hose photo would not be evidence of *this* hose, so none was taken. **Needs a human browser.** |
| IMG/HYS/00114 | 7524501 AERO BP motor foam filter 5pc | Same picture. Also note the conflict in §12.5 over what 7524501 actually is. **Needs a human browser.** |
| IMG/HYS/00255 | 7524909 Center broom B3300 | Every reachable source that claims to show 7524909 actually shows the **side** broom. Staging one would have put a side broom on a centre-broom page - exactly the error already sitting in the catalogue (§12.3). **Needs a human browser.** |

⚠ **Do not confuse this 49-of-52 with the 49-of-52 in the file header.** They are different sets.
The header's three gaps are the *unidentified part numbers* of §8 - `IMG/HYS/00226`, `00229` and
`00230` - and all three of those did get an image in this pass. The three image gaps are
`IMG/HYS/00112`, `00114` and `00255`, whose part numbers are known and correct. The header also
counts §6's 17 rows as "17 machines"; one of those rows, `IMG/HYS/00135`, is the water-tank
accessory, so the true machine count is **16**.

**Per-SKU PDFs staged - 13 files**

| File | Size | Source URL |
|---|---|---|
| `IMG-HYS-00098__spec-sheet.pdf` | 106 KB | https://taski.com/wp-content/uploads/2021/08/TASKI-AERO-8-15-Information-Sheet-Series-II.pdf |
| `IMG-HYS-00103__spec-sheet.pdf` | 113 KB | https://taski.com/wp-content/uploads/2021/08/TASKI-AERO-8-15-Plus-Information-Sheet-Series-II.pdf |
| `IMG-HYS-00106__spec-sheet.pdf` | 751 KB | https://taski.com/wp-content/uploads/2020/12/Go-Information-Sheet-1.pdf |
| `IMG-HYS-00109__spec-sheet.pdf` | 102 KB | https://taski.com/wp-content/uploads/2020/12/AERO-BP-Information-Sheet.pdf - one sheet covers both `00109` (BP E) and `00110` (BP B); only one copy was staged |
| `IMG-HYS-00118__spec-sheet.pdf` | 482 KB | https://taski.com/wp-content/uploads/2020/12/vacumat-22-Information-Sheet.pdf |
| `IMG-HYS-00127__spec-sheet.pdf` | 746 KB | https://taski.com/wp-content/uploads/2020/12/vacumat-44T_Information-Sheet.pdf |
| `IMG-HYS-00136__spec-sheet.pdf` | 145 KB | https://taski.com/wp-content/uploads/2020/12/ergodisc-165-Information-Sheet.pdf |
| `IMG-HYS-00140__spare-parts-list.pdf` | 552 KB | https://shop.monsterjanitorial.com/content/Taski/Part%20Manuals/foam%20generator%20FG2.pdf - no information sheet exists for the FG2 |
| `IMG-HYS-00148__spec-sheet.pdf` | 427 KB | https://taski.com/wp-content/uploads/2020/12/ergodisc-duo-Information-Sheet.pdf |
| `IMG-HYS-00170__spec-sheet.pdf` | 100 KB | https://m.media-amazon.com/images/I/61VUkovZ8ZL.pdf - ⚠ TASKI's own BP15 sheet is served off Amazon's image CDN (as §6 records). Not a stable host; re-host it before linking it from a product page |
| `IMG-HYS-00228__spec-sheet.pdf` | 87 KB | https://taski.com/wp-content/uploads/2021/05/Aquamat-20_-Information-Sheet.pdf |
| `IMG-HYS-00253__spec-sheet.pdf` | 70 KB | https://taski.com/wp-content/uploads/2021/04/balimat-3300-Information-Sheet-1.pdf |
| `IMG-HYS-00261__spec-sheet.pdf` | 88 KB | https://taski.com/wp-content/uploads/2020/12/swingo-2100-Information-Sheet.pdf |

No sheet was staged for `IMG/HYS/00248` (swingo 250µicro) or `IMG/HYS/00252` (balimat 45) -
neither machine has one. §6 records the same.

### 12.2 Files staged

All URLs below are the exact files fetched.

**Machines**

| File | Pixels | Size | Source URL | Visually confirmed |
|---|---|---|---|---|
| `IMG-HYS-00098__aero-8-side-white.jpg` | 5500x3666 | 5441 KB | https://taski.com/wp-content/uploads/2020/12/AERO-8-Image.jpg | Grey/orange tub vacuum, orange cable coiled on top, badge reads **AERO 8**. White background. |
| `IMG-HYS-00098__aero-8-with-hose-and-wand.jpg` | 1000x1000 | 46 KB | https://taski.com/wp-content/uploads/2020/12/AERO-8.jpg | Same machine complete with hose, telescopic wand and floor tool. |
| `IMG-HYS-00103__aero-15-plus-front-quarter.jpg` | 5500x3667 | 660 KB | https://taski.com/wp-content/uploads/2020/12/AERO-15-plu-Image-1.jpg | Badge reads **AERO 15 PLUS**. Cable drum on the lid, which is the Plus differentiator. |
| `IMG-HYS-00103__aero-15-plus-side-new-wheel.jpg` | 5500x3667 | 661 KB | https://taski.com/wp-content/uploads/2022/02/Diversey-Aero-15-Plus_2058-new-wheel.jpg | Same machine, later wheel design. |
| `IMG-HYS-00103__REF__aero-15-standard-body-white.jpg` | 5500x3666 | 998 KB | https://taski.com/wp-content/uploads/2020/12/90099-IMG-TASKI-AERO-15_06_WH.jpg | Badge reads **AERO 15** without PLUS - marked `REF__` because it is the standard 15, not our 15 Plus. |
| `IMG-HYS-00106__go-front-quarter.jpg` | 5500x3667 | 870 KB | https://taski.com/wp-content/uploads/2020/12/TASKI_go_Staubsauger_001w.jpg | Plain black/grey tub vacuum, white clamp band, deliberately simple - matches the GO's recycled-plastic, low-part-count description. |
| `IMG-HYS-00106__go-with-hose-and-wand.jpg` | 1707x2560 | 165 KB | https://taski.com/wp-content/uploads/2020/12/TASKI_go_Staubsauger_034w-scaled.jpg | Same machine with hose and wand fitted. |
| `IMG-HYS-00109__aero-bp-e-front.jpg` | 1280x1920 | 187 KB | https://taski.com/wp-content/uploads/2020/12/TASKI_AERO_BP_E.jpg | Backpack body, **TASKI AERO** badge, harness visible. |
| `IMG-HYS-00109__aero-bp-e-side-harness.jpg` | 1920x1920 | 261 KB | https://suvacor.com/wp-content/uploads/2024/02/7524495-TASKI_AERO_BP_E.jpg | Same shot on a square canvas, filename keyed to **7524495**. Suvacor is a Kenyan TASKI distributor. |
| `IMG-HYS-00110__aero-bp-b-li-ion-front.jpg` | 1280x1920 | 214 KB | https://taski.com/wp-content/uploads/2020/12/TASKI_AERO_BP-B.jpg | Battery variant, three-quarter view showing the shoulder harness. |
| `IMG-HYS-00118__vacumat-22-with-squeegee-wand-TOOSMALL.jpg` | 709x709 | 23 KB | https://taski.com/wp-content/uploads/2020/12/vacumat-22.jpg | Blue drum, yellow lid, chrome push handle, wet squeegee wand. |
| `IMG-HYS-00118__vacumat-22-astral-TOOSMALL.jpg` | 709x709 | 142 KB | https://www.astralhygiene.co.uk/media/4201/vacumat-22.jpg | Same official shot, better-quality encode. |
| `IMG-HYS-00127__vacumat-44t-on-trolley-with-fixomat-TOOSMALL.jpg` | 709x709 | 39 KB | https://taski.com/wp-content/uploads/2020/12/8004700_vacumat-44T.jpg | Stainless drum on chrome trolley, label reads **TASKI vacumat 44T**, wide front squeegee fitted - see §12.5. |
| `IMG-HYS-00228__aquamat-20-with-hand-tool-TOOSMALL.jpg` | 709x709 | 43 KB | https://taski.com/wp-content/uploads/2020/12/8003450_aquamat20.jpg | Orange extractor, label reads **TASKI aquamat 20**, orange hand tool on the hose. |
| `IMG-HYS-00136__ergodisc-165-quarter-view.png` | 4450x3337 | 3425 KB | https://www.astralhygiene.co.uk/media/1564/taski-ergodisc-165-521.png | Orange/grey single-disc machine, brush fitted, no recovery tank or squeegee - consistent with §4. |
| `IMG-HYS-00136__ergodisc-165-side-taski.jpg` | 1707x2560 | 137 KB | https://taski.com/wp-content/uploads/2020/12/ergodisc-165-Image-1-scaled-e1610284777495.jpg | Same machine, side elevation. |
| `IMG-HYS-00136__ergodisc-165-handle-badge-TOOSMALL.jpg` | 709x709 | 32 KB | https://taski.com/wp-content/uploads/2021/01/ergodisc-165-Image-4.jpg | Handle close-up; badge legibly reads **TASKI ergodisc 165**. Kept as model evidence. |
| `IMG-HYS-00148__ergodisc-duo-quarter-view.png` | 1900x2850 | 1591 KB | https://www.astralhygiene.co.uk/media/1390/taski-ergodisc-duo-524.png | Single-disc machine with a two-speed gearbox - confirms §2.2, it is **not** twin-disc. |
| `IMG-HYS-00148__ergodisc-duo-side-taski-TOOSMALL.jpg` | 709x709 | 23 KB | https://taski.com/wp-content/uploads/2020/12/8004010_ergodisc-duo.jpg | Same machine. **Note the taski.com filename carries 8004010, not our 8003990** - see §12.5. |
| `IMG-HYS-00248__swingo-250-micro-front-quarter.jpg` | 2160x2160 | 128 KB | https://taski.com/wp-content/uploads/2021/06/swingo-250-002.jpg | Compact orange upright scrubber dryer, twin 225 mm discs visible. |
| `IMG-HYS-00248__swingo-250-micro-rear.png` | 2362x2362 | 399 KB | https://taski.com/wp-content/uploads/2021/06/TASKI-swingo250_rear_view-20x20cm.png | Rear elevation showing the deck. |
| `IMG-HYS-00248__swingo-250-micro-handle-badge.jpg` | 2160x2160 | 188 KB | https://taski.com/wp-content/uploads/2021/06/TASKI-swingo250_handle_45_degree-20x20cm-1.jpg | Handle close-up: badge reads **swingo 250 µicro** with the Greek µ intact. Direct photographic proof of §2.1. |
| `IMG-HYS-00261__swingo-2100-micro-side.jpg` | 2560x1706 | 204 KB | https://taski.com/wp-content/uploads/2020/12/Swingo_2100_micro_002-scaled.jpg | Orange machine **with seat and steering wheel** - confirms the §4 correction to ride-on. Badge reads **swingo 2100 µicro**. |
| `IMG-HYS-00261__swingo-2100-micro-rear-quarter.jpg` | 2560x1706 | 189 KB | https://taski.com/wp-content/uploads/2020/12/Swingo_2100_micro_019-scaled.jpg | Rear three-quarter, squeegee assembly visible. |
| `IMG-HYS-00252__balimat-45-quarter-view.jpg` | 1000x1000 | 40 KB | https://taski.com/wp-content/uploads/2021/01/balimat-45.jpg | **Push handle, no motor housing, no battery box** - confirms the §4 correction to manual push sweeper. |
| `IMG-HYS-00252__balimat-45-front.jpg` | 840x507 | 33 KB | https://taski.com/wp-content/uploads/2020/12/balimat-45-1.jpg | Front view, twin side discs and orange hopper lid. |
| `IMG-HYS-00253__balimat-3300-side-brooms-detail.jpg` | 800x534 | 48 KB | https://taski.com/wp-content/uploads/2021/04/balimat-3300-side-brooms.jpg | Twin side brooms on the orange machine. Exactly at the 800 px floor. |
| `IMG-HYS-00253__balimat-3300-front.jpg` | 534x800 | 27 KB | https://taski.com/wp-content/uploads/2021/04/balimat-3300-front.jpg | Front elevation, walk-behind handlebar - confirms §4. Long edge exactly 800. |
| `IMG-HYS-00253__balimat-3300-quarter-right-TOOSMALL.jpg` | 775x517 | 25 KB | https://taski.com/wp-content/uploads/2021/04/balimat-3300-quarter-right.jpg | Best full three-quarter view; 25 px under the floor. |
| `IMG-HYS-00140__foam-generator-fg2-TOOSMALL.png` | 709x709 | 291 KB | https://shop.monsterjanitorial.com/content/Taski/Part%20Manuals/foam%20generator%20FG2.pdf (embedded image, page 1) | Orange-and-blue upright unit, two dial knobs on top, TASKI badge. Extracted with PyMuPDF `extract_image`. |
| `IMG-HYS-00170__sprayer-bp-15-li-ion-TOOSMALL.png` | 500x750 | 52 KB | https://taski.com/wp-content/uploads/2021/02/Sprayer-15-image-4.png | White-tank backpack sprayer with lance and harness, on TASKI's teal studio background. |

**Vacuum bags, filters and vacuum accessories**

| File | Pixels | Size | Source URL | Visually confirmed |
|---|---|---|---|---|
| `IMG-HYS-00100__7524288-fleece-bag.jpg` | 1920x1014 | 95 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/7524288.jpg/h=2000 | White fleece bag with brown card collar and blue grommet. |
| `IMG-HYS-00100__7524288-pack-of-10-labelled.jpg` | 2560x1728 | 345 KB | https://suvacor.com/wp-content/uploads/2025/06/7524288-IMG_2100.jpg | Real photograph of the sealed 10-pack; label reads **AERO 8/15 disp. fleece bag 10pc**. |
| `IMG-HYS-00101__7524289-paper-bag.jpg` | 1920x819 | 93 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/7524289.jpg/h=2000 | Beige paper bag, brown card collar. |
| `IMG-HYS-00101__7524289-paper-bag-partmarked-TOOSMALL.jpg` | 500x317 | 20 KB | https://taski.com/wp-content/uploads/2021/01/7524289-TASKI-AERO-8_15-filter-paper-bags-10pc.jpg | Same bag with **7524289 / AERO 8/15 PLUS** printed on it. Kept purely as part-number proof. |
| `IMG-HYS-00107__7524191-go-paper-bag.jpg` | 1506x1050 | 101 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/7524191.jpg/h=2000 | Beige GO paper bag; square card collar, moulding code 07882. Different collar geometry from the AERO bags. |
| `IMG-HYS-00108__7524189-go-accessory-set-32mm.jpg` | 5196x3464 | 865 KB | https://taski.com/wp-content/uploads/2020/12/TASKI_acc_set_7524189.jpg | Hose with bent handle, two chrome tubes, black combination floor nozzle. |
| `IMG-HYS-00111__7524295-telescopic-tube-32mm.jpg` | 1920x1920 | 119 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/7524295.jpg/h=2000 | Single metal telescopic wand with the sliding collar clearly visible. |
| `IMG-HYS-00113__7524500-bp-fleece-bag.jpg` | 1920x1290 | 165 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/7524500.jpg/h=2000 | White fleece bag, rectangular brown collar - the BP pattern, distinct from 7524288. |
| `IMG-HYS-00119__8504480-wet-vacuum-set-premium.jpg` | 1655x1949 | 258 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/8504480.jpg/h=2000 | Black hose, bent grey wand, aluminium floor squeegee with red rubber, plus a small hand tool. |
| `IMG-HYS-00120__8504940-double-filter-bag-partmarked-TOOSMALL.jpg` | 500x500 | 15 KB | https://taski.com/wp-content/uploads/2021/01/8504940-Pa-of-10-double-filter-bags.jpg | Beige double-layer paper bag with **8504.940** printed on the face. |
| `IMG-HYS-00121__4091150-filter-disc-set-10pc-TOOSMALL.jpg` | 500x500 | 19 KB | https://taski.com/wp-content/uploads/2021/01/4091150-30014-61-Filter-Disc-Set-10-Parts-1.jpg | Ten pale-blue circular filter discs in two fanned stacks. Count matches "10 parts". |
| `IMG-HYS-00124__8505420-fixomat-squeegee.jpg` | 1920x1644 | 203 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/8505420.jpg/h=2000 | Mounting bracket, blue clamp block, short corrugated hose and the aluminium squeegee bar. |
| `IMG-HYS-00218__8504930-dry-vacuum-kit-vacumat-22-TOOSMALL.jpg` | 500x500 | 21 KB | https://taski.com/wp-content/uploads/2021/01/8504930-Kit-dry-vacuum-cleaning-vacumat-22.jpg | Cloth filter, blue filter basket, stack of paper bags marked 8504.940, orange floor nozzle. |
| `IMG-HYS-00240__8504500-dry-vacuum-kit-vacumat-12-TOOSMALL.jpg` | 500x500 | 24 KB | https://taski.com/wp-content/uploads/2021/01/8504500-Kit-dry-vacuum-cleaning-vacumat-12.jpg | Same kit family, different bag code and a longer nozzle - visibly the 12 kit, not the 22 kit. |
| `IMG-HYS-00229__8505500-filter-cloth-with-ring-TOOSMALL.webp` | 709x709 | 22 KB | https://cdn.shopify.com/s/files/1/0761/7069/0884/files/8505500-Filtertuch-VAC44.jpg | White cloth filter seated in a black rubber retaining ring. Matches the catalogue name exactly. |
| `IMG-HYS-00172__8505160-aquamat-20-accessory-set-TOOSMALL.jpg` | 500x500 | 13 KB | https://taski.com/wp-content/uploads/2021/01/8505160-Accessories-set-aquamat-20.jpg | Black hose, chrome wand, orange spray-extraction floor tool. |
| `IMG-HYS-00230__8505140-spray-extraction-with-hose.jpg` | 1920x1920 | 167 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/8505140.jpg/h=2000 | Same tool family as 8505160 but a **blue** hose and different wand length. The colour is the only reliable way to tell these two sets apart in a photo - worth knowing before either is put on a page. |

**Single-disc (ergodisc) tools**

| File | Pixels | Size | Source URL | Visually confirmed |
|---|---|---|---|---|
| `IMG-HYS-00133__8504410-pad-drive-harpoon-43cm-official-TOOSMALL.png` | 709x709 | 485 KB | https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf (embedded image, page 1, row "8504410 Pad drive harpoon grip 43 cm") | Black disc densely covered in short harpoon studs, open plastic hub. Row-to-image mapping was done by x/y bounding box, not reading order. |
| `IMG-HYS-00133__8504410-ergodisc-driving-disc-partmarked-TOOSMALL.jpg` | 600x600 | 117 KB | https://www.galgormgroup.com/images/XL/7510829XLG.jpg | Worn disc moulded **TASKI ergodisc 8504.410**. Retrieved from a listing labelled 7510829 - see §12.3. |
| `IMG-HYS-00133__8504410-driving-disc-suvacor-TOOSMALL.jpg` | 500x400 | 77 KB | https://suvacor.com/wp-content/uploads/2024/02/8504410.jpg | Same harpoon-stud disc as the official thumbnail. |
| `IMG-HYS-00134__8504750-scrubbing-brush-uni-43.jpg` | 1024x1024 | 140 KB | https://cdn11.bigcommerce.com/s-hqh63mqxf6/images/stencil/original/products/4006628/7348350/8504750-__19315.1776825116.jpg | Full-coverage pale-blue/white bristle disc brush. CDN filename is keyed to **8504750**. |
| `IMG-HYS-00134__8504750-scrubbing-brush-43cm-official-TOOSMALL.png` | 709x709 | 253 KB | https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf (row "8504750 Scrubbing brush 43cm") | Same brush, official thumbnail. |
| `IMG-HYS-00141__8504830-dry-shampooing-brush-43cm-official-TOOSMALL.png` | 709x709 | 214 KB | https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf (row "8504830 Dry shampooing brush 43 cm") | White bristles in **five wedge segments with wide gaps** - the dry-foam pattern. |
| `IMG-HYS-00141__8504830-dry-shampooing-brush-43-TOOSMALL.jpg` | 500x500 | 28 KB | https://www.dobmeierjanitorialsupplies.com/assets/product-images/Diversey-TASKI-8504830.jpg | Same segmented brush. |
| `IMG-HYS-00142__8504860-wet-shampooing-brush-43cm-official-TOOSMALL.png` | 709x709 | 204 KB | https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf (row "8504860 Wet shampooing brush 43 cm") | White bristles in **concentric spiral rows**, not wedges - visibly different from 8504830. |
| `IMG-HYS-00142__8504860-wet-shampooing-brush-43-partmarked-TOOSMALL.jpg` | 500x500 | 145 KB | https://cdn11.bigcommerce.com/s-qrln235rlo/images/stencil/original/products/472705/10759183/192-9451__68653.1769311565.jpg | Brush shown front and reverse; the reverse is moulded **TASKI ergodisc 8504.860**, read at full crop. |
| `IMG-HYS-00143__8505010-manual-shampooing-set-official-TOOSMALL.png` | 709x709 | 279 KB | https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf (row "8505010 Manual shampooing set for carpets") | Coiled clear hose with brass fitting and a white hand brush. |
| `IMG-HYS-00143__8505010-hand-shampooing-set-TOOSMALL.jpg` | 500x500 | 30 KB | https://www.dobmeierjanitorialsupplies.com/assets/product-images/Diversey-TASKI-8505010.jpg | Same kit. |
| `IMG-HYS-00152__7510030-pad-drive-high-speed-43cm-official-TOOSMALL.png` | 709x709 | 332 KB | https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf (row "7510030 Pad drive harpoon grip high-speed 43cm") | Dark disc with a **metal centre plate and central bolt** - the high-speed hub. |
| `IMG-HYS-00152__7510030-high-speed-driving-disc-astral-TOOSMALL.jpg` | 600x600 | 128 KB | https://www.astralhygiene.co.uk/media/4573/17-high-speed-pad-drive.jpg | Matches the official thumbnail: metal centre plate. |
| `IMG-HYS-00152__7510030-high-speed-driving-disc-galgorm-TOOSMALL.jpg` | 600x600 | 21 KB | https://www.galgormgroup.com/images/XL/7510030XLG.jpg | **Does not match** - a cream disc with an orange hub. Kept as evidence of the disagreement, see §12.3. |
| `IMG-HYS-00226__8504780-scrubbing-brush-abrasive-43.jpg` | 1272x889 | 292 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/8504780.jpg/h=2000 | Coarse green-grey abrasive filament brush - visibly not nylon bristle. |
| `IMG-HYS-00226__8504780-abrasive-brush-suvacor.jpg` | 1024x1024 | 149 KB | https://suvacor.com/wp-content/uploads/2025/06/8504780.jpeg | Same brush. |
| `IMG-HYS-00226__8504780-scrubbing-brush-abrasive-43cm-official-TOOSMALL.png` | 709x709 | 400 KB | https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf (row "8504780 Scrubbing brush, abrasive, 43 cm") | Official thumbnail, same abrasive brush. Independently confirms the §8 recovery of 8504780. |
| `IMG-HYS-00135__8504390-water-tank-10l-official-TOOSMALL.png` | 709x709 | 171 KB | https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf (row "8504390 **Water tank 10L**") | Orange moulded tank with grey filler flap and TASKI badge. See §12.5 - this settles the capacity. |
| `IMG-HYS-00135__8504390-water-tank-TOOSMALL.jpg` | 500x500 | 61 KB | https://cdn11.bigcommerce.com/s-hqh63mqxf6/images/stencil/original/products/4006217/7348498/8504390_tank__16656.1778689276.jpg | Same tank, CDN filename keyed to 8504390. |
| `IMG-HYS-00135__8504390-tank-mounted-on-ergodisc-TOOSMALL.jpg` | 709x709 | 28 KB | https://taski.com/wp-content/uploads/2020/12/ergodisc-165-Image-5.jpg | The tank **fitted to an ergodisc 165**, which shows how it mounts. |

**Scrubber-drier tools, batteries and sweeper brooms**

| File | Pixels | Size | Source URL | Visually confirmed |
|---|---|---|---|---|
| `IMG-HYS-00160__7510829-pad-driver-43cm-swingo.jpg` | 1920x1920 | 421 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/7510829.jpg/h=2000 | Dark green ribbed disc with a moulded plastic hub - the swingo pattern, no metal plate. |
| `IMG-HYS-00249__7510634-pad-driver-28cm.jpg` | 1504x1109 | 235 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/7510634.jpg/h=2000 | Same ribbed pattern, visibly smaller relative to the hub - the 28 cm part. |
| `IMG-HYS-00250__7519395-scrubbing-brush-28-partmark-mismatch.jpg` | 1139x870 | 130 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/7519395.jpg/h=2000 | White bristle brush on a black hub. **The hub is moulded `75103xx`, not 7519395** - see §12.5. Filename carries the caveat. |
| `IMG-HYS-00251__7514962-gel-traction-block-6v-180ah.jpg` | 1920x1920 | 293 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/7514962.jpg/h=2000 | Grey Sonnenschein block labelled **GF 6 180 V, motive power, maintenance free, gel technology**. Reads out as 6 V / 180 Ah, matching the catalogue exactly. |
| `IMG-HYS-00254__7520152-gel-traction-block-12v-TOOSMALL.jpg` | 432x593 | 38 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/7520152.jpg/h=2000 | Single grey gel block, "GEL TECHNOLOGY" legible, capacity plate not readable at this size. |
| `IMG-HYS-00256__7524910-side-broom-b3300-TOOSMALL.jpg` | 474x474 | 16 KB | https://cdn.shopify.com/s/files/1/0761/7069/0884/files/Seitenbesen-Balimat3300_Ersatz-SeitenbesenfuerdenBalimat3300.jpg | Disc-shaped broom with radial black bristles - correct form for a side broom. |
| `IMG-HYS-00257__7524893-scrubbing-brushes-225mm-pair-partmarked.jpg` | 4160x4160 | 4388 KB | https://cdn11.bigcommerce.com/s-qrln235rlo/images/stencil/original/products/687393/10741453/292-5807__48132.1769133411.jpg | **A pair** of 225 mm brushes; the reverse hub is moulded **TASKI 7524893**. Confirms both the part number and the 2PC quantity. |
| `IMG-HYS-00257__7524893-scrubbing-brush-225mm-hub-partmarked.jpg` | 8256x5504 | 14426 KB | https://taski.com/wp-content/uploads/2021/06/sw-250-standard-brush.jpg | Official 8256x5504 master; the black hub reads **TASKI 7524893** at full crop. Highest-resolution asset in the set. |
| `IMG-HYS-00258__7524894-pad-drive-discs-225mm-pair-partmarked.jpg` | 4160x4160 | 3641 KB | https://cdn11.bigcommerce.com/s-qrln235rlo/images/stencil/original/products/687395/10741455/292-5809__65425.1769133412.jpg | **A pair** of 225 mm pad drives, red centre boss, reverse moulded **TASKI 7524894**. |
| `IMG-HYS-00258__7524894-pad-drive-discs-225mm-pair.jpg` | 1920x1920 | 296 KB | https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/7524894.jpg/h=2000 | Same pair, alternate studio shot. |
| `IMG-HYS-00259__7524891-nx-li-ion-battery-37v.jpg` | 4160x4160 | 6770 KB | https://cdn11.bigcommerce.com/s-qrln235rlo/images/stencil/original/products/687391/10741452/292-5805__21766.1769133411.jpg | Black lithium pack with a red **NX 300** badge; its footprint matches the 7524892 charger recess. See §12.5. |
| `IMG-HYS-00260__7524892-nx-charger.jpg` | 4160x4160 | 6505 KB | https://cdn11.bigcommerce.com/s-qrln235rlo/images/stencil/original/products/763454/10741454/292-5806__14269.1769133411.jpg | Charger cradle, badge reads **NX 300 Li-Ion Battery Charger**. |

Three files were discarded as filler and are not staged: taski.com's 258x258 gel-battery range
graphic, Astral Hygiene's 1500x300 TASKI marketing banner, and Pamark's "7524892" image, which
is a plain TASKI logo square rather than the charger (§12.4).

### 12.2b `_brand-reference\` - 19 files, not one of them a product shot for any of the 52 SKUs

Each is evidence about something, but **none of these belongs on a product page.**

| File | Pixels | Size | Source URL | Why it is here and not in the main folder |
|---|---|---|---|---|
| `REF__aero-15-power-badge-closeup-not-in-catalogue.jpg` | 5500x3661 | 6256 KB | https://taski.com/wp-content/uploads/2020/12/90099-IMG-TASKI-AERO-15_15_WH.jpg | Badge reads AERO 15 **Power** - a variant we do not stock. Useful only for telling the AERO 15 variants apart. |
| `REF__vacumat-22t-neighbouring-model.jpg` | 709x709 | 186 KB | https://www.astralhygiene.co.uk/media/1231/taski-vacumat-22t.jpg | vacumat **22T** (trolley chassis), not our 22. Kept so the T-suffix difference of §2.3 can be seen side by side. |
| `REF__swingo-2100-micro-dashboard-detail.jpg` | 2560x1942 | 437 KB | https://taski.com/wp-content/uploads/2021/01/Swingo-2100-image-scaled.jpg | Dashboard and controls close-up. Detail, not a product view. |
| `REF__swingo-250-micro-in-use-atrium.jpg` | 8256x5504 | 25408 KB | https://taski.com/wp-content/uploads/2021/05/swingo-250-009.jpg | Lifestyle frame - machine in an atrium with an operator. Largest file in the pass at 25 MB. |
| `REF__balimat-3300-hopper-open.jpg` | 775x517 | 26 KB | https://taski.com/wp-content/uploads/2021/04/balimat-3300-open-hopper.jpg | Hopper-open detail, and also under the 800 px floor. |
| `REF__8504800-scrubbing-brush-washed-concrete-43cm.png` | 709x709 | 251 KB | https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf (embedded image, row "8504800 Scrubbing brush washed concrete 43 cm") | **Adjacent SKU we do not stock, staged deliberately.** 8504750, 8504770, 8504780 and 8504800 are four 43 cm brushes that look alike in a photo, and §12.3A is that confusion having already reached our catalogue. Keep this to hand when checking brush images. |
| `REF__7525358-taski-foam-generator-36v-new-model.png` | 210x320 | 54 KB | https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf (embedded image, row "7525358 foam generator 36V") | The FG2's successor. Evidence for the §5.1 lifecycle question, not a photo of our FG2. |
| `REF__foam-generator-fg2-exploded-diagram-x58.png` | 1122x1544 | 51 KB | https://shop.monsterjanitorial.com/content/Taski/Part%20Manuals/foam%20generator%20FG2.pdf (embedded image, xref 58) | Exploded parts diagram, not a photograph. |
| `REF__foam-generator-fg2-exploded-diagram-x60.png` | 1122x1565 | 55 KB | https://shop.monsterjanitorial.com/content/Taski/Part%20Manuals/foam%20generator%20FG2.pdf (embedded image, xref 60) | As above. |
| `REF__foam-generator-fg2-exploded-diagram-x62.png` | 1122x1565 | 53 KB | https://shop.monsterjanitorial.com/content/Taski/Part%20Manuals/foam%20generator%20FG2.pdf (embedded image, xref 62) | As above. |
| `REF__foam-generator-fg2-exploded-diagram-x64.png` | 1122x1565 | 22 KB | https://shop.monsterjanitorial.com/content/Taski/Part%20Manuals/foam%20generator%20FG2.pdf (embedded image, xref 64) | As above. |

Plus the **eight shared PDFs** - the six accessory charts of §7, the NAM single-disc accessory
list, and the balimat range brochure:

| File | Size | Source URL |
|---|---|---|
| `TASKI-accessory-chart-vacumats.pdf` | 187 KB | https://taski.com/wp-content/uploads/2020/12/Accessories-vacumats.pdf |
| `TASKI-accessory-chart-single-discs.pdf` | 185 KB | https://taski.com/wp-content/uploads/2020/12/Accessories-single-discs.pdf |
| `TASKI-accessory-chart-scrubber-driers-150-755.pdf` | 190 KB | https://taski.com/wp-content/uploads/2020/12/Accessories-scrubber-driers-150-755-1.pdf |
| `TASKI-accessory-chart-scrubber-driers-855-1850.pdf` | 201 KB | https://taski.com/wp-content/uploads/2020/12/Accessories-scrubber-driers-855-1850.pdf |
| `TASKI-accessory-chart-ride-on-scrubber-driers.pdf` | 651 KB | https://taski.com/wp-content/uploads/2026/05/Accessories-Ride-on-Scrubber-driers-V2.pdf |
| `TASKI-accessory-chart-sweepers.pdf` | 174 KB | https://taski.com/wp-content/uploads/2021/04/Accessory-list-Sweepers.pdf |
| `TASKI-NAM-accessory-list-single-disc-tools.pdf` | 484 KB | https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf |
| `TASKI-balimat-range-brochure.pdf` | 7006 KB | https://taski.com/wp-content/uploads/2021/04/TASKI-Balimat-brochure.pdf |

### 12.3 Contradictions found - reported, not fixed

Nothing in `products.json` or `brands.json` was edited. These need a decision.

**A. `IMG/HYS/00134` Scrubbing Brush Uni 43 - the stored photo is the wrong part.**
The stored image `products/scrubbing-brush-uni-43-imghys00134.jpg` shows a brush from the
reverse, and the hub is moulded **`TASKI ergodisc 8504.770`**. Our `model_number` is **8504750**.
So the stored photo is part **8504770**, an adjacent brush grade. §10.1 already warned that
Dobmeier's *page* for 8504750 displays 8504770's photo; that is evidently where this came from.
The correct 8504750 is a full-coverage pale bristle brush - staged as
`IMG-HYS-00134__8504750-scrubbing-brush-uni-43.jpg` and corroborated by the official NAM
thumbnail. **Recommend replacing the stored image; leave `model_number` alone.**

**B. `IMG/HYS/00152` High-Speed Driving Disc 43/01 - the stored photo is the 7510829 disc.**
The stored images for `IMG/HYS/00152` (7510030) and `IMG/HYS/00160` (7510829) show the same
product: a dark green ribbed disc with a moulded plastic hub. Carel Lurvink's part-keyed 7510829
photo matches that disc, so **00160's image is right and 00152's is a duplicate of it**.
The official NAM thumbnail for 7510030 is a visibly different part - a disc with a **metal centre
plate and central bolt**, which is what you would expect for a high-speed application, and which
Astral Hygiene's photo also shows. This is the exact ergodisc-vs-swingo confusion flagged in §7
as "the one to be careful with", except it has landed on the image rather than the text.
**Recommend replacing 00152's stored image.**

**C. `IMG/HYS/00255` Center Broom B3300 - the stored photo is a side broom.**
The stored image for `IMG/HYS/00255` (7524909, centre broom) is a disc-shaped broom with radial
bristles, essentially identical to the stored image for `IMG/HYS/00256` (7524910, side broom) and
to Altruan's photo. The balimat 3300's centre broom is a **500 mm cylindrical roller** spanning
the 900 mm sweep path - a completely different shape, visible in the machine photos. Altruan was
confirmed to be the origin: its Shopify product JSON returns the **same image file** for its
"Main brush - Balimat 3300" and "Side broom - Balimat 3300" listings, differing only by a
Shopify cache suffix. The §10.1 warning was right and the catalogue has inherited the error.
No replacement could be sourced, hence the abstention. **Recommend sourcing the centre roller by
hand from a Diversey eshop in a browser before this SKU is published.**

**D. `IMG/HYS/00254` - the stored photo is a range shot, not the product.**
`products/battery-traction-block-12v-76ah-5-imghys00254.jpg` shows **five different batteries**
together (GF 6 180 V, GF 6 240 V, GF 12 105 V, GF 12 70 V, GF 12 50 V) - taski.com's generic
gel-battery family graphic. It is not a photo of the 12 V block being sold. Not a wrong-part
error exactly, but it is a range shot on a single-part page. The Carel Lurvink single-block shot
is staged as a replacement candidate, though it is only 432x593.

**E. Distributor listings that serve the wrong photo** - recorded so nobody re-imports them:

| Listing | Serves | Evidence |
|---|---|---|
| https://www.galgormgroup.com/images/XL/7510829XLG.jpg | **8504410**, not 7510829 | Disc is moulded `TASKI ergodisc 8504.410`, read at full crop |
| https://www.galgormgroup.com/images/XL/7524289XLG.jpg | **7524288**, not 7524289 | Bag is printed `7524288 / AERO 8/15 PLUS`; it is the white fleece bag, not the beige paper one |
| https://www.galgormgroup.com/images/XL/8504480XLG.jpg | a **vacumat machine**, not the accessory set | Whole machine in frame |
| https://www.galgormgroup.com/images/XL/7510030XLG.jpg | disputed | Cream disc with orange hub; disagrees with both the official NAM thumbnail and Astral |
| https://altruan.com/products/main-brush-balimat-3300-... | the **side** broom | Shopify JSON returns the same source file as the side-broom listing |
| https://www.pamark.fi/media/catalog/product/.../..._7524892_1.jpg | a **TASKI logo square** | 398x400 orange logo tile, no product. The §10.1 Pamark URL is a dead end |

### 12.4 Corrections to §10 and §10.1

- **`taski.com` originals are much larger than §10 implies.** WordPress stores a `-scaled.jpg`
  derivative at 2560 px and keeps the untouched original at the same path with the suffix
  removed. Stripping `-scaled` yields **5500 px** masters for the AERO and GO ranges and a
  **5196x3464** master for the GO accessory set. Query the media *collection* to confirm the true
  original: `https://taski.com/wp-json/wp/v2/media?per_page=100&page=N` returns
  `media_details.width/height` for every attachment. The full index is 3,501 items over 36 pages.
- **The Altruan `?width=1946` URLs in §10.1 do not return 1946 px.** Shopify will not upscale
  past the master. Both Altruan files are smaller than the parameter suggests: 8505500 is
  **709x709** and 7524910 is **474x474**. The Shopify product JSON
  (`https://altruan.com/products/<handle>.json`) reports the true master dimensions.
- **The Pamark URL in §10.1 for 7524892 is not the charger** - see §12.3E. Use USA-Clean.
- **Carel Lurvink is the single most productive accessory source found, and is not in §10.**
  `https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/<part>.jpg/h=2000`
  is keyed directly to the TASKI part number and returns up to 1920 px. It resolved 17 parts:
  7510634, 7510829, 7514962, 7519395, 7520152, 7524189, 7524191, 7524288, 7524289, 7524295,
  7524500, 7524894, 8504480, 8504780, 8505140, 8505160, 8505420. Requesting `h=2000` gets the
  master; the `h=420` in §10.1 was needlessly small.
- **USA-Clean is reachable through a reader proxy and holds 4160x4160 masters.** Its pages 403 to
  a direct fetch but `https://r.jina.ai/<url>` returns them. Then swap the BigCommerce stencil
  size segment for `original`:
  `https://cdn11.bigcommerce.com/s-qrln235rlo/images/stencil/original/products/<id>/<img>/<file>.jpg`.
  This produced the best images in the whole pass for 7524891, 7524892, 7524893 and 7524894.
  ⚠ **USA-Clean's search endpoint is a trap** - `search.php?search_query=<part>` returns HTTP 200
  with a normal-looking grid of *unrelated recommended products* for any query, including
  nonsense. Identical result sets for different part numbers is the tell. Same failure mode as
  the Bing RSS trap. Only its category and product pages are trustworthy.
- **`nam.taski.com`'s accessory list is better than §10.1 credits.** Its page-1 embedded images
  are 709x709 and each maps to a named part number, so it can adjudicate part identity. Map rows
  to images by **bounding box**, not reading order: `page.get_images()` then
  `page.get_image_rects(xref)`, matched against `page.get_text("blocks")` y-coordinates. The rows
  sit ~45 px apart, so this is unambiguous. It is the same discipline §9.2 prescribes for the
  compatibility grids.
- **`shop.monsterjanitorial.com` carries part-number-keyed files** at
  `https://cdn11.bigcommerce.com/s-hqh63mqxf6/images/stencil/original/products/...`. It was the
  only source with a standalone 8504390 water-tank photo besides Dobmeier.
- **Dobmeier's `assets/product-images/Diversey-TASKI-<part>.jpg` pattern is real but capped at
  500x500**, and has no entry for 8504410 (404).
- **Astral Hygiene has larger machine art than taski.com for the single discs** -
  `https://www.astralhygiene.co.uk/media/1564/taski-ergodisc-165-521.png` is 4450x3337 and
  `https://www.astralhygiene.co.uk/media/1390/taski-ergodisc-duo-524.png` is 1900x2850, against
  709x709 on taski.com.
- **Hosts that were dead ends this pass:** `reinigungsberater.de` (503 / connection timeout),
  `staubsaugerwelt24.de` (1,172-product Shopify feed, zero TASKI machine parts),
  `hillnmarkes.com`, `tenaquip.com`, `factorycleaningequipment.net` (403),
  `taskiprospeed.com` (connection timeout), `hygi.de` (non-standard status 247).
  `r.jina.ai` returned ~250-byte stubs for every `eshop.diversey.*` and `products.solenis.com`
  URL, so the §10.1 "needs a human browser" note stands for those.

### 12.5 Spec observations arising from the images

- **§5.4 open question resolved: the water tank 8504390 is 10 litres.** The NAM accessory list
  names the row **"8504390 Water tank 10L"**. This is official TASKI literature, so the earlier
  instruction not to publish a figure can be lifted. Source:
  https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf
- **§5.3 battery dispute - the sweeper chart says 81 Ah.** Text extracted from
  https://taski.com/wp-content/uploads/2021/04/Accessory-list-Sweepers.pdf reads
  **"Gel-Batterie 12V 81Ah · 7520152"**. Our catalogue name says 76 Ah. The published
  "76-81 Ah - confirm with distributor" wording remains the right call.
- **Broom part numbers confirmed against the official chart.** The same PDF gives
  **"Center broom b3300 · 7524909"** and **"Side broom b3300 · 7524910"**, exactly as the
  catalogue has them. Astral Hygiene's off-by-one table (noted in §10.1) is the wrong one. This
  also means the §12.3C image error is an image error only - the part numbers are right.
- **The official vacumat 44T press photo shows the fixomat fitted.** §3.2 states the 44T ships
  *without* the 8505420 squeegee, yet TASKI's own product shot has it mounted, and Astral's copy
  of the same file does too. That is a returns-expectation risk on the product page - worth an
  explicit line saying the squeegee in the photo is a separate purchase.
- **taski.com's own file for the ergodisc duo is named `8004010_ergodisc-duo.jpg`**, while our
  catalogue holds **8003990** (recovered in §4). Both codes circulate for this machine. Not
  enough to act on, but worth raising with the supplier alongside the §5.1 lifecycle questions.
- **The 7519395 photo carried by both Carel Lurvink and Dobmeier shows a hub moulded `75103xx`.**
  Legible digits are `7`,`5`,`1`,`0`,`3`; the last two are ambiguous at the available resolution.
  It is plainly not 7519395. Most likely a moulding/production code rather than the sales SKU,
  but until that is confirmed the staged file is named `-partmark-mismatch` so nobody treats it
  as positive identification.
- **`IMG/HYS/00259` NX battery - worth a second look, not yet a contradiction.** The stored photo
  shows an NX-badged pack standing on end with a D-shaped carry handle; the USA-Clean photo shows
  a wide, low pack with moulded grips and no D-handle, whose footprint matches the 7524892
  charger recess. These may be the same pack from different angles, or two different packs. Not
  called as an error - it needs someone who can see the physical part.
- **The 8505140 and 8505160 extraction sets are near-identical in photographs**, differing mainly
  in hose colour (blue vs black) and wand length. Given `IMG/HYS/00230` had no stored image at
  all, take care that the right one goes on the right SKU.

### 12.6 Provenance of this section - reconstructed after a crash

**This section was written after the fact, not during the pass.** The run that did the sourcing
was killed by a platform session limit at the moment it finished verifying and began writing up.
Its 112 staged files landed and survived; its write-up did not reach this file. Everything above
was reconstructed from the killed run's own transcript and then re-checked against the files on
disk. No image was re-downloaded and no sourcing decision was re-made.

What was re-verified before this was written:

- **All 112 files are present** - 93 in `taski-images\` (80 images + 13 PDFs) and 19 in
  `_brand-reference\` (11 images + 8 PDFs).
- **Every pixel dimension and file size in the tables above was re-measured from the actual
  bytes** with PIL, not read off a filename or trusted from the transcript. All 99 image rows
  match to the pixel and to the kilobyte; **zero discrepancies**.
- **Every image file on disk appears in a table above.** Nothing staged is undocumented, and
  nothing documented is missing from disk.
- **The 52 TASKI records were re-read from `products.json`** and the per-SKU file counts
  recomputed. The three zero-image SKUs are confirmed as `IMG/HYS/00112`, `00114` and `00255`,
  exactly as §12.1 claims.

**Source URLs: 112 of 112 recovered. None lost.** Every image, every per-SKU PDF and every
shared PDF above carries the exact URL that was fetched, taken from the download scripts in the
transcript rather than reconstructed from memory.

What could **not** be recovered: the killed run's internal reasoning was stored redacted, so the
only visual-verification judgements that survive are the ones it had already written into the
"Visually confirmed" column - which is all 99 images, but in its words at write-up time rather
than a fuller running commentary. Nothing in those columns was invented or padded here; where a
judgement was thin it has been left thin.

Two small things worth recording for the next pass:

- `IMG-HYS-00229__...webp` was fetched from a URL ending `.jpg`
  (https://cdn.shopify.com/s/files/1/0761/7069/0884/files/8505500-Filtertuch-VAC44.jpg).
  Shopify content-negotiates and returned WebP. The extension on disk is correct for the bytes;
  the URL is correct for the request. Not an error, but it will look like one.
- The write-up was originally lost to a **filename collision in a shared scratchpad**: the section
  was written to a generic `append.md` and appended in a second step, and a concurrent run
  overwrote that same `append.md` in between. That is also how an unrelated brand's write-up
  briefly ended up appended to this file (since reverted). Write-ups should go to a
  brand-specific filename, or be appended in a single step.

---

## 8. SAP verification of this file's naming findings, 2026-07-30

The naming traps in §2 were re-checked against the SAP export, which did not exist when they
were written. **Every one is confirmed — and in each case SAP carries the corruption while our
corrected `products.json` value is right.** That is the reverse of the usual direction and worth
stating plainly: for TASKI naming, do NOT "fix" our data toward SAP.

| Finding | SAP holds | Our corrected value | Verdict |
|---|---|---|---|
| §2.1 µicro encoding bug | `TASKI SWINGO 250 **UCRO**` | "Swingo 250 Micro" | ✅ research right, SAP corrupt |
| §2.2 Ergodisc, not Ergodisk | `TASKI **ERGODISK** 165 DUO` | "Taski Ergodisc Duo" | ✅ research right, SAP wrong twice (K spelling + phantom "165") |
| §2.2 not twin-disc | SAP remark: *"twin speed machine… 2in1 machine"* | single disc, two-speed gearbox | ✅ SAP's own remark supports the research |

⚠ **SAP is internally inconsistent on this brand**: `IMG/HYS/00136` carries `ERGODISC 165`
(correct, with a C) while `IMG/HYS/00148` carries `ERGODISK 165 DUO` (with a K). The same field,
the same product family, two spellings.

⚠ **SAP also puts names in the Model field** on the SKUs that have no article number —
`ERGODISC`, `ERGODISC 165`, `ERGODISK 165 DUO`, `VACUMAT 44T UK`, `AQUAMAT 20`, `BP 15 Li-ION`,
`FG2`. Those are the 12 SKUs that cannot be matched on products.solenis.com, whose URLs key on
the numeric article number.

**Conclusion for the re-do:** this file's *analysis* stands and is now independently corroborated.
What it lacked was a spec of record to check individual products against — which SAP now supplies.
Treat §2, §3 and §7 (part-number compatibility) as verified; re-verify §6's per-machine figures
per SKU before publishing them.
