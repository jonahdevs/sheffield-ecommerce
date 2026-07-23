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
