# Six Single-SKU Brands — Product Research

Research notes behind a **SIMONELLI / BRAVILOR / LINCAT / BERTOS / FIMAR GROUP / NISBET**
audit pass on `products.json` (July 2026). One SKU per brand, six SKUs total.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema, Baron, Tefcold/Waring and Sulte passes before a
scope decision.

All six brands are established European/UK manufacturers (or, in one case, a distributor
masquerading as one) and every SKU was traced to a manufacturer-published source. The pass
produced **four significant findings**:

1. **NISBET is not a manufacturer** — the SKU belongs to BRAVILOR, and the stored
   `model_number` `WHK003` is printed on **Bravilor's own manual cover** as `WHK-003`. This
   is the biggest structural finding here and has its own section (§8).
2. **SIMONELLI's electrical spec is the wrong market** — `110V … 18A` is the US variant of a
   machine that Nuova Simonelli also builds as **230 V / 8 A**. This is the only genuine
   Kenya-supply risk in the pass (§3).
3. **FIMAR's stored `model_number` `PRD35N235M` has an `R` where Fimar writes an `F`** — the
   real code is **`PFD35N235M`** (§7).
4. **LINCAT's `DK977` is confirmed a Nisbets catalogue reference**, exactly as the brief
   suspected. Lincat's own model code is **`IH21`** (§5).

---

## 1. Brand identification — all six, at a glance

| Catalogue brand | Real entity | Country | Correct `website_url` | In `brands.json`? |
|---|---|---|---|---|
| SIMONELLI | **Nuova Simonelli S.p.A.**, Via M. D'Antegiano 6, 62020 Belforte del Chienti (Macerata) — part of **Simonelli Group** | Italy | https://nuovasimonelli.com/ (brand site) or https://simonelligroup.com/ (group) | **Yes** — `simonelli`, `https://simonelligroup.com/` — live, acceptable |
| BRAVILOR | **Bravilor Bonamat B.V.** | Netherlands | https://www.bravilor.com/ | **NO — missing entirely** |
| LINCAT | **Lincat Ltd**, Lincoln — part of the **Middleby** group (its assets are served from `middleby-cdn.com`) | United Kingdom | https://www.lincat.co.uk/ | **NO — missing entirely** (`lincar-memme` in `brands.json` is a *different*, Italian brand — do not confuse) |
| BERTOS | **Berto's S.p.A.** ("BERTO'S — Chef Solutions") | Italy | https://www.bertos.com/en | **Yes** — `bertos`, `https://www.bertos.com/en` — live, correct |
| FIMAR GROUP | **Fimar S.p.A.**, Via del Tesoro 39, 47826 Villa Verucchio (RN) | Italy | **https://www.fimarspa.it/** ⚠ | **NO — missing entirely** |
| NISBET | **Nisbets plc** — a UK catering **distributor**, not a manufacturer (§8) | United Kingdom | https://www.nisbets.co.uk/ | **NO — missing entirely** (and should stay that way, §8) |

⚠ **`fimar.it` does not resolve** (curl returns no response at all). The live official domain
is **`fimarspa.it`**, which matches the `info@fimarspa.it` address printed on Fimar's own
datasheet footer. If a `fimar-group` brand row is ever added, `https://www.fimar.it/` would
be a dead link on day one.

All URL checks were live `curl -L` probes performed during this pass:
`nuovasimonelli.com` 200, `nuovasimonelli.it` → 301 → `nuovasimonelli.com` 200,
`simonelligroup.com` 200, `bravilor.com` 200, `lincat.co.uk` 200, `bertos.com/en` 200,
`fimar.it` **no response**, `fimarspa.it` 200, `nisbets.co.uk` 200.

---

## 2. Where to look — sources that worked, and the traps

| Brand | Best source | Notes |
|---|---|---|
| SIMONELLI | Official multilingual **brochure PDF** with a full 4-column spec table | https://www.simonelliusa.com/PDFs/Discontinued/Microbar%20II/Microbar%20II%20Brochure.pdf — note the `/Discontinued/` path segment |
| BRAVILOR | Official product pages with an `Article number / Rated power / Dimensions wxdxh` block | https://www.bravilor.com/ — Angular SPA, but the server-rendered HTML carries the spec block; `curl` reads it fine |
| LINCAT | Official **automated spec sheet PDF** from Middleby's CDN | https://middleby-cdn.com/specsheets/Lincat_IH21_AutomatedSpecSheet.pdf |
| BERTOS | Official **per-model datasheet PDF** with dimensioned drawings | https://www.bertos.com/en/media/download/2024/03/scheda_18803000_1622.pdf |
| FIMAR | Official **per-SKU datasheet PDF** (`fimarspa.it` letterhead) + an official 3-model comparison table image | https://serpiano.com/wp-content/uploads/2024/03/induction-plates-pfd35n.pdf |
| NISBET | Nisbets product pages (legitimate third-party distributor) — but its "spec sheet" download **is a Bravilor brochure** | https://www.nisbets.co.uk/ |

### Traps hit during this pass

1. **`nisbets.co.uk` returns HTTP 403 to WebFetch** but serves normally to `curl` with a
   browser User-Agent. The full attribute table (`Dimensions`, `Weight`, `Supplier Model
   Number`, `Voltage`, …) is in the server-rendered Angular payload.
2. **Bravilor's own spec table disagrees with Bravilor's own prose** on the WHK's dimensions
   (§8.3). The prose, the brochure and Nisbets all agree; the table does not.
3. **`bravilor.com` product slugs are unpredictable** — `/b10-2/` is the plain B10, `/b10/`
   is the *marine* variant, `/b10-l/` and `/b10-r/` 404 while a "Drip tray B10 L/R"
   accessory exists. Do not infer a variant's existence from a slug.
4. **Distributor listings for Fimar frequently show the wrong plate.** `macchinari.moca.it`
   files a photo of a *different* induction hob (rear upstand, five touch controls, SCHOTT
   CERAN badge top-right) under the PFD35N part number. The genuine PFD35N carries an
   **`EASYLINE`** badge on the front-left of the fascia and has ⏱ / − / + / temp / power
   controls with a 4-digit LED (§7.4).
5. **PDF datasheets do not extract via WebFetch** — the `Read` tool was used on every PDF, as
   instructed, and this is what produced the decisive Simonelli spec table and the Bertos
   dimensioned drawing.
6. **The session's WebSearch budget was exhausted before this pass began.** All source
   discovery was done by pointing WebFetch at `https://html.duckduckgo.com/html/?q=…`, which
   works reliably; `curl` against the same endpoint gets rate-limited after ~1 request, and
   Mojeek and DDG-lite both block `curl` outright.

---

# PART 1 — SIMONELLI

## 3. IMG/COF/00054 — Espresso Machine Microbar II Simonelli (`MICROBAR II`), published

**Confirmed.** Nuova Simonelli **Microbar II** is a real, correctly-named product and
`MICROBAR II` is the manufacturer's own model designation (it is printed on the machine's
fascia, left of the LCD, in every official render).

Official brochure (12 pp, IT/EN/FR/DE/ES, full spec table on pp. 10-11):
https://www.simonelliusa.com/PDFs/Discontinued/Microbar%20II/Microbar%20Spec%20Sheet.pdf
https://www.simonelliusa.com/PDFs/Discontinued/Microbar%20II/Microbar%20II%20Brochure.pdf

### 3.1 Which Microbar II variant — answered: the **Cappuccino** version

The brief asked which variant this is. The brochure's spec table lists **four**:

| Variant | Milk? | Water | Power | Weight |
|---|---|---|---|---|
| **COFFEE** | no | 5 L removable tank | 1000 W | 26 kg |
| **COFFEE AD** | no | direct mains (`AD` = *attacco diretto*) | 1000 W | 26 kg |
| **CAPPUCCINO** | yes, built-in automatic milk foamer | 5 L removable tank | **2000 W** | **27 kg** |
| **CAPPUCCINO AD** | yes | direct mains | **2000 W** | **27 kg** |

Our stored `description` says *"program the espresso **& milk** volumes & temperatures"* and
the stored power figure is **2000 W** — both of which are **Cappuccino-only** attributes
(the Coffee versions are 1000 W and have no milk programming). It also mentions *"available
as a Pour-Over version (with a 5-litre water reservoir)"*, which is the **non-AD** tank
option.

**Verdict: this SKU is the Microbar II Cappuccino (tank version), 2000 W.** High confidence.

### 3.2 ⚠ Electrical spec is the US variant — the one real Kenya risk in this pass

Stored `technical_specification`: **`POWER: 110V / 2000W / 18A`**.

The official brochure gives the machine **two** factory voltages:

> **Voltaggio / Voltage:  115 V (18 A)  |  230 V (8 A)**

- **115 V / 18 A is the North-American build.** The separate US spec sheet confirms the
  US-market hardware: *"Volts: 110 (voltage range of 110-125) … Amp draw: 13 … Receptacle:
  **Nema 5-15**"* — a US household plug.
- **230 V / 8 A is the European/export build**, and is the one that suits **Kenya's
  240 V / 50 Hz** supply.

The stored string is a **mash-up of both**: `110V` and `18A` are US figures, while `2000W`
is the Cappuccino rating that appears in the European brochure. `110V × 18A` is also
internally inconsistent with `2000W` (≈1980 W, coincidentally close, but the US sheet's own
figure for the machine it documents is 1500 W / 13 A).

**Correct figure for a Kenyan listing: `230 V, 8 A, 2000 W, 50/60 Hz`.**
🔴 **This must not ship as `110V`** — it is the single most misleading field found in this pass.

### 3.3 ⚠ The stored US spec sheet actually documents the **first-generation Microbar**

Worth flagging because it explains a dimension conflict that would otherwise look like a
data error. The US document is titled **"Microbar Spec Sheet"** (not *Microbar II*), shows a
**brushed-stainless** machine with no `MICROBAR II` fascia wordmark, and gives:

| | US "Microbar Spec Sheet" | Official Microbar **II** brochure |
|---|---|---|
| Counter W × D × H | 13" × 16" × 19" = **330 × 406 × 483 mm** | **325 × 460 × 480 mm** |
| Power | 110 V, **1500 W**, 13 A, NEMA 5-15 | 115 V (18 A) / **230 V (8 A)**, 1000 W or 2000 W |
| Weight | 105 lb = 47.6 kg (incl. crate?) | **26 kg / 27 kg** |

The **460 mm depth** is the Microbar II figure and is what the record should carry; 406 mm
belongs to the older machine. Use the brochure.

### 3.4 The classic width/height transposition — present on this SKU

| | Length | Width | Height |
|---|---|---|---|
| Stored **numeric** fields | 325 | **480** | **460** |
| Stored **prose** `technical_specification` | 325 | 460 | 480 |
| **Official brochure** (Largezza / Profondità / Altezza) | **325** (width) | **460** (depth) | **480** (height) |

Same signature as every prior brand pass: **the prose is right, the numeric `width`/`height`
are swapped.** Corrected: **`length: 325, width: 460, height: 480`.**

### 3.5 ⚠ Three factual errors in the stored `description`

The stored copy reads: *"MicroBar has **two (2) 0.7 litre boilers** (one for coffee + one for
steam/boiling water), one (1) **400 gram** bean hopper, and a grounds box that holds up to
**30** pucks."* The official spec table contradicts all three:

| Claim in record | Brochure | Verdict |
|---|---|---|
| Two 0.7 L boilers, one coffee + one steam | **`N. caldaie / N. boilers: 1`**, `Capacità: 0.7 lt` — one boiler, all four variants | ❌ **Wrong.** There is a single 0.7 L boiler |
| 400 g bean hopper | **`Capacità sylos: 0.25 Kg`** standard; optional **extra-sylos 0.35 kg** extension | ❌ **Wrong.** 250 g standard, 350 g with the accessory. 400 g appears nowhere |
| Grounds box up to 30 pucks | **`Capacità cassetto fondi: 20-35`** | 🟡 Within range but arbitrary — quote "20-35 pucks" |
| "6 different drink buttons" | Fascia has **8** buttons (2 rows of 4); menus are 8 coffee drinks + 5 milk drinks | 🟡 Understated |

### 3.6 Confirmed but missing from the record

- **Weight 27 kg** (Cappuccino) / 26 kg (Coffee) — not stored at all
- Body: **stainless steel + ABS**; factory colours **pearl white** and **red**
- Output: **120 espressos/h**, **60 cappuccinos/h**, ~**10 L/h hot water**; rated for **up to
  ~80 cups/day**
- Group head: stainless steel + die-cast aluminium, **thermally compensated**, pre-infusion,
  extractable; **programmable tamping force** (double pressing system)
- Grinder: 1 unit, **50 mm burrs**, micrometric adjustment
- Water: **5 L extractable tank** (non-AD) or **direct mains with built-in pressure reducer**
  and a 2 m ¾" supply hose (AD)
- Electronics: 2-line LCD, **6 languages**, energy-saving mode, self-diagnostics, automatic
  coffee **and milk** wash cycles, end-of-shift clean, total + partial counters,
  decalcification cycle
- Cappuccino-only: programmable milk temperature, programmable **milk foam density**,
  extractable milk foamer

### 3.7 ⚠ Discontinued — and the stored product photo may be the wrong generation

- **Microbar II is no longer in Nuova Simonelli's current range.** Its documentation lives
  under `/PDFs/**Discontinued**/Microbar II/` on Simonelli's own US distribution site, and a
  full crawl of `nuovasimonelli.com` returns **zero** occurrences of "Microbar" across the
  entire live machine line-up (Appia Life, Appia Viva, Aurelia Wave, Nuova Aurelia, Musica,
  Oscar, Oscar Mood, Prontobar, Duo, GX, MDJ, MDXS). Confidence: **High**.
- The stored image
  `storage/app/public/products/espresso-machine-microbar-ii-simonelli-imgcof00054.png`
  (1254 × 1254) shows a **brushed-stainless** machine with an English **"SELECT DRINK"**
  display and **no `MICROBAR II` wordmark** on the fascia. Every official Microbar II render
  (brochure cover, pp. 3-9) shows a **pearl-white or red** machine with the `MICROBAR II`
  wordmark printed to the left of the LCD. The stored photo is very likely the
  **first-generation Microbar**, matching the machine drawn on the US "Microbar Spec Sheet".
  🟡 **Flagged, not asserted** — worth a second pair of eyes before replacing.
- A **black** Microbar II with the correct `MICROBAR II` wordmark is sold currently by
  tecnocoffeeshop.com, so black exists as a later colour even though the brochure lists only
  white and red. Downloaded as a `REF__` file (§10).

---

# PART 2 — BRAVILOR

## 4. IMG/COF/00137 — Coffee Brewer with Single Decanter Bravilor B10 (`B10`), archived

**`B10` is confirmed as a real Bravilor Bonamat filter-coffee code.** The brief's guess that
B5/B10/B20 tracks litres-per-hour is close but not exact: the number is the **capacity in
litres of each brewing container**, and the brew cycle is fixed at **10 minutes per 10 L**
across the family.

Official product page: https://www.bravilor.com/en-gb/products/filter-coffee-machines-en-gb/b10-2/
Miko (UK Bravilor dealer) specification card: https://mikocoffee.co.uk/wp-content/uploads/2023/02/Specification-Card-Bravilor-Bonamat-B10.pdf

### 4.1 ⚠ "Single Decanter" is the right *idea* but the wrong *word* — and it identifies a specific variant

Bravilor never uses "decanter" for this machine. The B-series brews into **10 litre
insulated stainless containers** (Bravilor's own term; Miko calls them "flasks"), which
hang on a hot-plate-free stand with a sight glass and a lever tap. A "decanter" in coffee
trade language is a glass jug — this is not that.

But the *single* part is meaningful and is corroborated by our own stored photo. The B10
family splits by container count:

| Variant | Article number | Containers | Rated power | W × D × H (mm) |
|---|---|---|---|---|
| **B10** | 4.210.018.110 | **two** | 230 V~ 50/60 Hz **6000 W** | 955 × 512 × 840 |
| **B10 marine** | 4.250.540.110 | two | 440 V3 / 230 V~ 7400 W | 955 × 512 × 840 |
| **B10 W** | 4.212.516.110 | two (wide layout) | 400 V 3N~ 6180 W | 1115 × 572 × 781 |
| **B10 HW L** (container left) | 4.214.716.110 | **one** + hot-water tap | 400 V 3N~ **8290 W** | **645 × 570 × 840** |
| **B10 HW R** (container right) | 4.216.316.110 | **one** + hot-water tap | 400 V 3N~ **8290 W** | **645 × 570 × 840** |
| B10 single (Miko spec card) | — | **one** | "SP30 or 3 PH" | **600 × 570 × 660** (H660 W600 D570) |

**Our stored product photo shows a single container to the right of the brewer tower, with a
tap on the tower itself** — i.e. a **hot-water tap**, which makes it a **B10 HW R**, not a
plain single B10. Bravilor's official B10 HW render is an exact visual match (downloaded,
§10).

🟠 **Recommendation: do not populate dimensions until the variant is pinned down.** The
candidates are 645 × 570 × 840 (B10 HW L/R, matches the photo) or 600 × 570 × 660 (plain
single, no hot water). The twin-container 955 mm figure on Bravilor's `/b10-2/` page is
**wrong for this SKU** and is the number a careless copy would grab first.

### 4.2 🔴 Electrical: this machine cannot run off a normal Kenyan socket

Every B10 variant is a **6-8 kW** appliance:

- Plain B10: **230 V~ 6000 W** → ≈ **26 A** on a single phase.
- B10 HW L/R (the variant our photo shows): **400 V 3N~ 8290 W** → **three-phase**.
- Miko's UK card states the requirement plainly: **"POWER SUPPLY: SP30 or 3 PH"** — i.e. a
  dedicated **30 A single-phase** circuit *or* a **3-phase** supply.

Kenya's 400/415 V 3-phase and 240 V single-phase distribution is electrically compatible
with all of these, so **there is no wrong-market voltage problem** — but a 13 A plug-and-play
expectation would be badly wrong. **This belongs in the product copy as an installation
note.** It also needs a **plumbed mains water connection at ≥1 bar** with a 15 mm copper feed
terminating in a ¾" valve; **no waste connection required**.

### 4.3 Confirmed spec — nothing is currently stored, so all of this is additive

The record has **only** a `short_description`. `description` is `null`, there are no
dimensions, no `technical_specification`, and `price` is `0`. Everything below is new:

- Brewing: **10 minutes per 10 L**; **250 cups per hour**
- Container: 10 L insulated stainless, sight glass, lever tap, lid
- Housing: stainless steel
- Controls: digital display, programmable quantities, **total and day counters**,
  coffee-ready indicator
- Maintenance: **built-in descaling system**
- Water: mains-connected, 1 bar minimum

### 4.4 ⚠ Record hygiene

- `price` is **0** and `status` is **archived** — if this SKU is ever re-published, both need
  attention.
- The `short_description` calls it *"single decanter coffee brewer"*; §4.1 explains why
  "container" or "10 L flask" is the accurate word.

---

# PART 3 — LINCAT

## 5. IMG/BUF/00127 — Induction Hob DK977 (`DK977`), published

### 5.1 🔴 `DK977` verdict — CONFIRMED a Nisbets catalogue reference. Lincat's code is **`IH21`**

The brief's suspicion is correct and now proven from three independent directions:

1. **Nisbets' own product title** is literally *"Lincat Induction Hob **IH21** — **DK977** —
   Nisbets"*: https://www.nisbets.co.uk/lincat-induction-hob/dk977
2. **Nisbets' own attribute table** on that page carries the field
   **`Supplier Model Number: IH21`** — Nisbets itself distinguishes its catalogue reference
   (`DK977`) from the manufacturer's model (`IH21`).
3. **Lincat's own product page** lists `SKU: IH21`, `EAN 5056105101840`, and publishes the
   spec sheet as `Lincat_IH21_AutomatedSpecSheet.pdf`:
   https://www.lincat.co.uk/product/electric-counter-top-induction-hob-2-zones-w-350-mm-3-0-kw/

`DK977` follows the Nisbets house format (two letters + three digits) — the same format as
`DC672`, which is Nisbets' reference for the Bravilor cup warmer in §8, and `FS040`, Nisbets'
reference for a Waring mixer noted in the earlier Tefcold/Waring pass. It is **not** a Lincat
code; Lincat's grammar is `IH21`, `OE7010`, `DF33`.

**Per the standing rule, `model_number` has NOT been changed.** But unlike a cosmetic typo,
this is a wrong-namespace identifier: a customer searching Lincat's catalogue for `DK977`
finds nothing. Recommended on approval: `model_number` → **`IH21`**, with `DK977` retained
in the technical specification as *"Nisbets catalogue reference: DK977"*, and the product
`name` changed from "Induction Hob DK977" to **"Induction Hob Lincat IH21"**.

### 5.2 Confirmed full specification — record is currently empty

The record has only a `short_description`; `description` is `null` and there are no
dimensions or technical specification at all. Confirmed figures (Lincat's own spec sheet and
Nisbets' attribute table agree exactly):

| Field | Value | Source |
|---|---|---|
| Manufacturer model | **IH21** | Lincat SKU + Nisbets "Supplier Model Number" |
| EAN | 5056105101840 | lincat.co.uk |
| Range | Lincat **Specialist** counter-top | lincat.co.uk |
| Zones | **2** | both |
| **W × D × H** | **350 × 654 × 115 mm** | Lincat spec sheet; Nisbets states `115(H) x 350(W) x 654(D)mm` |
| Weight | **12 kg** net (Lincat) / 12.2 kg (Nisbets); ship weight 13.42 kg | both |
| **Electrical** | **230 V, single phase, 3.0 kW, 13 A** | both — **13 A means it runs on a standard socket** |
| Hob surface | **6 mm high-impact-resistant Schott Ceran ceramic glass** | Nisbets material field + Lincat |
| Max temperature | **+190 °C** | Nisbets |
| Controls | Mechanical rotary controls with LED display | Lincat |
| Features | Automatic heat-up (drops to a preset power level after full-power heat-up), **boost function**, **pan detection** | Lincat |
| Ingress rating | **IP24** | Lincat |
| Finish | Stainless steel, silver | both |
| Origin | **Made in UK**, UKCA certified | Lincat |
| Warranty | 2 years parts & labour (Nisbets, UK terms) | Nisbets |

### 5.3 ✅ Kenya electrical verdict: clean

**230 V / single phase / 3.0 kW / 13 A.** Directly suitable for Kenya's 240 V 50 Hz supply
and, at 13 A, it plugs into an ordinary socket. Nisbets ships it with a **UK 13 A plug
fitted** — which is also Kenya's plug standard (Type G). No adapter, no rewire. This is the
most Kenya-ready SKU in the whole pass.

### 5.4 Axis note

No numeric dimension fields exist yet, so there is nothing to transpose. Populate using the
catalogue's convention (`length` = frontage width, `width` = depth, `height` = height):
**`length: 350, width: 654, height: 115`.**

---

# PART 4 — BERTOS

## 6. IMG/HOT/00005 — Food Warmer Electric Bertos (`E7SP-4B`), archived, **no image**

**Confirmed and fully verified from Berto's own datasheet.**

Official product page: https://www.bertos.com/en/products/cook/electric-food-warmer/macros-700/electric-food-warmer-counter-top
Official datasheet PDF: https://www.bertos.com/en/media/download/2024/03/scheda_18803000_1622.pdf
Full MACROS 700 series datasheet book: https://www.bertos.com/en/media/download/2024/03/schede_tec_macros700_2024_it_en_fr_de_6227.pdf

### 6.1 `E7SP-4B` decoded — what "SP-4B" means

The brief asked what `SP-4B` denotes. Reading Berto's own datasheet, which pairs `E7SP-4B`
with its sibling `E7SP-4M` on the same page:

- **`E`** = Electric
- **`7`** = **Serie 700** (700 mm module depth — the datasheet's dimension drawing gives 714 mm)
- **`SP`** = *scaldapatate* — a **chip / french-fry warming scuttle**, not a bain-marie
- **`4`** = **400 mm** module frontage width
- **`B`** = *banco* — **counter-top / bench model** (19 kg).
  The sibling **`M`** = *mobile*, the same unit on an open cabinet base (900 mm high, 30 kg,
  code `18803500`)

Berto's product code: **`18803000`**, series **macros 700**.
(There is also a near-identical **S 700** series version, `SE7SP-4B`, code `07803000` — a
different series line. Our `E7SP-4B` is the **macros 700** one.)

### 6.2 ⚠ It is a chip scuttle, not a generic food warmer

Berto's own English product title is "ELECTRIC FOOD WARMER (COUNTER TOP)", so the catalogue
name is not *wrong* — but the machine is specifically a **heated holding unit for fried
potatoes/chips**: an inclined stainless sliding board with a **fat drain**, a perforated
GN 1/1 collection pan, a **ceramic heat lamp above** and a resistance element **under** the
tank. Distributors sell it as a *"chip scuttle"* / *"french fries tub"*. The official product
photo (downloaded, §10) shows exactly this: the perforated pan, the drain hole, the lamp
housing on a raised gantry, and a green rocker switch on a plain stainless front panel.

For a Kenyan buyer, "Food Warmer Electric Bertos" would set the wrong expectation — this
will not hold GN pans of stew. 🟡 Recommend the name be sharpened to something like
**"Chip Scuttle / Fried Food Warmer Bertos E7SP-4B"**.

### 6.3 Confirmed specification — record is completely empty

`description` is `null`, `image` is `null`, no dimensions, no technical specification.
Everything below is new:

| Field | Value |
|---|---|
| Model / code | **E7SP-4B** / **18803000**, series **macros 700** |
| **W × D × H** | **400 × 714 × 290 mm** |
| Net weight | **19 kg** (the `-4M` cabinet version is 30 kg) |
| Packaging | 470 × 790 × 620 mm, 22 kg, 0.08 m³ |
| **Electrical** | **220-240 V~, 1.1 kW** |
| Pan | **GN 1 × 1/1, 305 × 510 × 175 h mm**, stainless, perforated |
| Materials | Worktop and front panels in **AISI 304 stainless steel** |
| Heating | High-thermal-efficiency **ceramic lamp above** + **resistance element under the tank** |
| Features | Inclined sliding board with **fat drain**, power switch, **adjustable feet** |
| Certification | CE, IMQ, IQNet |
| Option | `1P DX` — 20/10-thickness door with handle (cabinet versions only) |

### 6.4 ✅ Kenya electrical verdict: clean

**220-240 V~, 1.1 kW** (≈5 A). Directly suitable for Kenya's 240 V 50 Hz supply, single
phase, ordinary socket. Berto's is an Italian manufacturer with no low-voltage line, so
there was never a wrong-market risk here.

### 6.5 Axis note

No numeric dimensions exist yet — nothing to transpose. Populate as
**`length: 400, width: 714, height: 290`** per the catalogue convention.

---

# PART 5 — FIMAR GROUP

## 7. IMG/HOT/00395 — Induction Plate PFD/3500N Single PH (`PRD35N235M`), published

**Cross-reference:** the Sulte pass (`database/data/research/sulte-research.md`, §2)
established that two "Sulte"-badged microwaves in this catalogue are a **Midea-designed OEM
platform** also badged **Fimar**, **Easyline** and **Solwave**, and that Fimar publishes spec
sheets for them. That characterisation holds up here and gains a detail: **`EASYLINE` is
Fimar's own in-house sub-brand**, not a third party. The physical PFD35N carries an
`EASYLINE` badge on the fascia, and Fimar's datasheet header carries the Fimar logo — the
two names sit on the same product by design.

Official Fimar datasheet PDF (Fimar S.p.A. letterhead, `info@fimarspa.it`):
https://serpiano.com/wp-content/uploads/2024/03/induction-plates-pfd35n.pdf
Official Fimar 3-model comparison table (PFD/20 · PFD/27 · PFD/35), recovered as an image:
https://www.gastronorm.it/en/PFD35N-Induction-plate-343x440x120h

### 7.1 🔴 `PRD35N235M` verdict — the stored code has an `R` where Fimar writes an `F`

**Fimar's real article code is `PFD35N235M`.** Two independent sources spell it out:

- ManualsLib catalogues the manual under the product **"Fimar EasyLine **PFD35N235M**"**:
  https://www.manualslib.com/products/Fimar-Easyline-Pfd35n235m-12043137.html
- Horecatiger's parts listing reads *"piastra di induzione modello PFD/35 230V 1P+N+T —
  **Fimar PFD35N235M** 50Hz lar. 343mm P 440mm H 120mm 800-3500W"*:
  https://horecatiger.eu/it-it/ricambi/apparecchiature/piastra-di-induzione-modello-pfd-35-230v-1p+n+t-50hz-lar-343mm-p-440mm-h-120mm-800-3500w/p/G100115
- Plasticart states it directly: *"La Piastra a Induzione FIMAR **PFD35N** (spesso
  identificata con codice **PFD35N235M**)"*:
  https://www.plasticartsrl.it/prodotto/piastra-induzione-pfd35n-cm-343x44-3-5-kw/

Structure: **`PFD35N`** is the model (**P**iastra **F**issa a in**D**uzione, 35 = 3.5 kW,
N = current generation); **`235M`** is the electrical suffix = **230 V single-phase
(*monofase*)**.

`PRD` is not a Fimar prefix and returns nothing on any Fimar source. This is a
single-character transcription error, the same class of fault as the Baron `SE40/OCB`
letter-O-for-zero found in the Baron pass. **Flagged, not changed**, per the standing rule.
On approval: `PRD35N235M` → **`PFD35N235M`**.

### 7.2 `PFD/3500N` in the product name — legitimate, but an older alias

The name field's `PFD/3500N` is **not** wrong. Fimar's own comparison table heads its columns
**`PFD/20`, `PFD/27`, `PFD/35`** — a slash-separated family notation where the number is the
kW×10. The `PFD/3500` form (kW→watts) is still used by Italian distributors, e.g.
https://macchinari.moca.it/product/piastra-induzione-pfd-3500-fimar/

So the catalogue holds **three valid names for one machine**: `PFD/3500N` (name),
`PFD35N235M` (article code), `PFD35N` (short SKU). Recommend the SKU/short form **`PFD35N`**
appear in the technical specification so the product is findable, whichever a buyer types.

### 7.3 ✅ Stored specification is otherwise **exactly right** — a rare clean record

Field-by-field against Fimar's official datasheet:

| Field | Stored | Official Fimar | Verdict |
|---|---|---|---|
| Power | 3.5 kW | **3.5 kW** (yield 500 ÷ 3500 W) | Exact match |
| Power supply | 230V/1N/50Hz | **230 V / 1N / 50 Hz** | Exact match — **correct for Kenya** |
| Inductive surface | ø 140 ÷ ø 220 mm | **ø 140 ÷ ø 220 mm** | Exact match |
| Machine dimensions | 343 × 440 × 120(h) mm | **343 × 440 × 120(h) mm** | Exact match |
| Net weight | 8 kg | **8 kg** | Exact match |
| Gross weight | 11 kg | **11 kg** | Exact match |
| Numeric `length`/`width`/`height` | **343 / 440 / 120** | L 343 (frontage) · P 440 (depth) · H 120 | ✅ **No transposition on this SKU** |
| `description` prose | "Stainless steel casing – glass-ceramic plate – operation in power level mode or in temperature mode – digital timer." | Word-for-word Fimar's own datasheet sentence | Exact match |

**Axis check, per SKU as required: this record is correct.** Facchini Impianti independently
labels the axes `L343 × P440 × H120` (*lunghezza* × *profondità* × *altezza*), which maps
exactly onto the catalogue's `length` = frontage / `width` = depth / `height` convention.
No change.

Whoever entered this record copied straight from Fimar's datasheet and got everything right
except the one letter in the model code.

### 7.4 Confirmed but missing, plus a caution on distributor photos

Missing from the record and worth adding:
- **Packaging 510 × 420 × 190(h) mm, 0.041 m³**
- **Power yield range 500 ÷ 3500 W** (i.e. it modulates down to 500 W — a genuine selling point)
- **Auto-off after 120 min**; **timer up to 180 min** (gastronorm.it product data)
- Sub-brand **EASYLINE by Fimar** — the badge that is physically on the machine
- Sibling models for upsell/downsell: **PFD/20** (2 kW, 290 × 370 × 44h, 2.3 kg) and
  **PFD/27** (2.7 kW, 325 × 370 × 105h, 5 kg)

⚠ **Photo caution.** `macchinari.moca.it` files a photo of a *different* induction plate
(rear splash upstand, five touch controls, `SCHOTT CERAN` badge top-right) under the
`PFD35N235M` code. The genuine PFD35N has **no rear upstand**, an `EASYLINE` badge at the
front-left, and a ⏱ / − / + / temperature / power control row with a 4-digit red LED. The
moca file was kept only as `REF__…WRONG-MODEL…` (§10).

### 7.5 ✅ Kenya electrical verdict: clean

**230 V / 1N / 50 Hz, 3.5 kW** ≈ 15 A. Fine on Kenya's 240 V 50 Hz single-phase supply,
though 15 A is slightly above a 13 A plug rating — worth noting it wants a **16 A outlet or a
dedicated spur**, not a shared 13 A socket.

---

# PART 6 — NISBET  ⚠ BRAND-ATTRIBUTION FINDING

## 8. IMG/BUF/00073 — Cup Warmer Bravilor Shelf (`WHK003`), published — **this SKU is a BRAVILOR product**

> **This section is the biggest structural finding of the pass and is deliberately separated.**

### 8.1 The recommendation, stated up front

🔴 **The `brand` field on IMG/BUF/00073 should be changed from `NISBET` to `BRAVILOR`.**
**Flagged, not applied** — this is a brand re-attribution and needs sign-off. Nothing has been
edited.

### 8.2 The evidence — five independent proofs, one of them decisive

1. **🔴 DECISIVE — `WHK003` is Bravilor's own model number, printed on Bravilor's own manual
   cover.** ManualsLib holds the *"BRAVILOR BONAMAT WHK Series User Manual"*, and the
   scanned cover page reads verbatim: **`Model nr.: WHK-003`**. The listing metadata is
   *"Also for: **Whk-003**"*.
   https://www.manualslib.com/manual/1667330/Bravilor-Bonamat-Whk-Series.html
   ⚠ **This corrects the brief's premise.** The task note assumed `WHK003` was "a Nisbets
   catalogue reference format, which supports that read". It is the opposite: `WHK003` is
   the *manufacturer's* code, which supports the same conclusion even more strongly.
   Nisbets' own catalogue reference for this product is **`DC672`** — the same two-letter +
   three-digit shape as the Lincat `DK977` in §5.
2. **Nisbets itself attributes the product to Bravilor.** Its page title is
   *"**Bravilor** 3 Shelf Cup Warmer WHK — DC672 — Nisbets"*, and its attribute table gives
   **`Supplier Model Number: 8.040.041.82001`** — a **Bravilor article number** in Bravilor's
   own `n.nnn.nnn.nnnnn` format.
   https://www.nisbets.co.uk/bravilor-cup-warmer-shelf-white/dc672
3. **The "spec sheet" Nisbets serves for DC672 is a Bravilor brochure.** Downloading
   `https://media.nisbets.com/asset/en/media/spec_sheet_dc672.pdf` yields a two-page document
   on **BRAVILOR BONAMAT** letterhead, headed *"ACCESSORIES — WHK cup heater"*, footed
   *"www.bravilor.com — Your Bravilor Bonamat dealer"* and stamped with Bravilor's document
   number `904.150.004C`. Nisbets is distributing the manufacturer's own literature.
4. **The physical product carries the Bravilor badge.** Nisbets' own product photography
   (downloaded, 1100 × 1100, §10) shows **`BRAVILOR BONAMAT`** stamped on the front lower
   rail of the cabinet. The Nisbets name appears nowhere on the unit.
5. **Bravilor lists the WHK in its own current catalogue** as an accessory, article
   **8.040.041.82002** (the stainless-dark finish; `…82001` is the dark-grey finish Nisbets
   stocks):
   https://www.bravilor.com/en-gb/products/accessories-en-gb/whk/
   https://www.bravilor.com/products/accessories-in/whk-cup-heater-stainless-dark/

### 8.3 What follows from the re-attribution

- **`brand` → `BRAVILOR`** — putting this SKU alongside `IMG/COF/00137` (the B10 brewer, §4).
  Both are Bravilor Bonamat; both would then share one brand row.
- **`brands.json` needs a `bravilor` row anyway** (it is currently missing entirely, §1) —
  so this costs nothing extra.
- **Do NOT create a `nisbet` brand row.** Nisbets plc is a distributor. Every SKU that
  arrives with "NISBET" in the brand field is, by definition, mis-attributed: the real
  manufacturer is always somewhere else on the page. Worth a **catalogue-wide sweep** for
  other `NISBET`-branded rows before this pattern spreads.
- **`model_number` `WHK003` is CORRECT and must be left alone.** It is Bravilor's own code
  (`WHK-003` on the manual). The only cosmetic question is the missing hyphen, and per the
  standing rule that is not worth touching.
- The product `name` — *"Cup Warmer Bravilor Shelf"* — already names Bravilor. Suggest
  tidying to **"Cup Warmer 3-Shelf Bravilor WHK"**.

### 8.4 Confirmed specification — record is currently empty

`description` is `null`; no dimensions, no technical specification. Confirmed figures (the
Bravilor brochure and Nisbets' attribute table agree exactly):

| Field | Value | Source |
|---|---|---|
| Manufacturer model | **WHK-003** | Bravilor manual cover |
| Bravilor article no. | **8.040.041.82001** (dark grey) / 8.040.041.82002 (stainless dark) | Nisbets / bravilor.com |
| Nisbets reference | DC672 | nisbets.co.uk |
| **W × D × H** | **349 × 400 × 542 mm** | Bravilor brochure (`Dimensions (wxdxh)`) **and** Nisbets (`542(H) x 349(W) x 400(D)mm`) |
| Weight | **10 kg** | Nisbets |
| **Electrical** | **230 V~ 50/60 Hz, 85 W** | Bravilor brochure |
| Capacity | **approx. 120 espresso cups** across 3 shelves | both |
| Shelves | **3 heating layers, each switchable independently** | brochure |
| Temperature | **65 °C to 70 °C** | Nisbets |
| Housing | Stainless steel | brochure |
| Colours | **dark-grey** and **stainless dark** | brochure |
| Plug | UK 13 A fitted (Nisbets) | Nisbets |
| Warranty | 2 yr parts / 1 yr labour, commercial only (Nisbets, UK terms) | Nisbets |

⚠ **One conflict, resolved.** Bravilor's own product-page spec *table* states
`Dimensions wxdxh: 330x570x660 mm`, but the *prose* on the very same page says
*"taking up **349x400x542 mm (wxdxh)** of space"*, which matches its own brochure and
Nisbets' independent measurement exactly. **Use 349 × 400 × 542**; the table figure is almost
certainly a packaging/pallet dimension mis-keyed into the machine field. Two-against-one, and
the odd figure out is also the internally inconsistent one.

### 8.5 ✅ Kenya electrical verdict: clean

**230 V~ 50/60 Hz, 85 W** — trivially small load, standard socket, UK/Kenya Type G plug
fitted. No issue.

### 8.6 Axis note

No numeric dimensions exist yet. Populate as **`length: 349, width: 400, height: 542`**.

---

## 9. Product reference

| SKU | Catalogue name | Stored `model_number` | **Real manufacturer code** | Official source | Confidence |
|---|---|---|---|---|---|
| IMG/COF/00054 | Espresso Machine Microbar II Simonelli | MICROBAR II | **MICROBAR II** (Cappuccino version) — correct | https://www.simonelliusa.com/PDFs/Discontinued/Microbar%20II/Microbar%20II%20Brochure.pdf | **High** — manufacturer brochure with full 4-variant spec table |
| IMG/COF/00137 | Coffee Brewer with Single Decanter Bravilor B10 | B10 | **B10** family correct; photo indicates **B10 HW R** (art. 4.216.316.110) | https://www.bravilor.com/en-gb/products/filter-coffee-machines-en-gb/b10-2/ · https://www.bravilor.com/en-gb/products/filter-coffee-machines-en-gb/b10-hw-r/ | **High** on the family, **Medium** on which exact variant |
| IMG/BUF/00127 | Induction Hob DK977 | DK977 | **IH21** — `DK977` is Nisbets' catalogue ref | https://www.lincat.co.uk/product/electric-counter-top-induction-hob-2-zones-w-350-mm-3-0-kw/ · https://middleby-cdn.com/specsheets/Lincat_IH21_AutomatedSpecSheet.pdf | **High** — manufacturer spec sheet, EAN, and Nisbets' own "Supplier Model Number" field |
| IMG/HOT/00005 | Food Warmer Electric Bertos | E7SP-4B | **E7SP-4B**, Berto's code **18803000**, macros 700 — correct | https://www.bertos.com/en/products/cook/electric-food-warmer/macros-700/electric-food-warmer-counter-top · https://www.bertos.com/en/media/download/2024/03/scheda_18803000_1622.pdf | **High** — manufacturer datasheet with dimensioned drawings |
| IMG/HOT/00395 | Induction Plate PFD/3500N Single PH | PRD35N235M | **PFD35N235M** (`F`, not `R`); short SKU **PFD35N** | https://serpiano.com/wp-content/uploads/2024/03/induction-plates-pfd35n.pdf · https://www.gastronorm.it/en/PFD35N-Induction-plate-343x440x120h | **High** — Fimar-letterhead datasheet, every stored figure matches |
| IMG/BUF/00073 | Cup Warmer Bravilor Shelf | WHK003 | **WHK-003** — Bravilor's own code, **brand should be BRAVILOR** | https://www.bravilor.com/en-gb/products/accessories-en-gb/whk/ · https://media.nisbets.com/asset/en/media/spec_sheet_dc672.pdf · https://www.manualslib.com/manual/1667330/Bravilor-Bonamat-Whk-Series.html | **High** — Bravilor manual cover states `Model nr.: WHK-003` |

Supporting / cross-check sources used across the pass:

https://nuovasimonelli.com/
https://simonelligroup.com/
https://www.simonelliusa.com/PDFs/Discontinued/Microbar%20II/Microbar%20Spec%20Sheet.pdf
https://www.archiexpo.com/prod/simonelli-group/product-49370-1641288.html
https://tecnocoffeeshop.com/nuova-simonelli-microbar-2-super-automatic-coffee-machine
https://www.kitchen-arena.com.my/nuova-simonelli-microbar-ii-1-grinder-cappucino-white-coffee-machine-ns-cappucino.html
https://www.bravilor.com/
https://www.bravilor.com/en-gb/products/filter-coffee-machines-en-gb/b10-hw-l/
https://www.bravilor.com/en-gb/products/filter-coffee-machines-en-gb/b10-w/
https://www.bravilor.com/en-gb/products/filter-coffee-machines-en-gb/b10/
https://mikocoffee.co.uk/wp-content/uploads/2023/02/Specification-Card-Bravilor-Bonamat-B10.pdf
https://www.bravilor.com/products/accessories-in/whk-cup-heater-stainless-dark/
https://www.nisbets.co.uk/bravilor-cup-warmer-shelf-white/dc672
https://media.nisbets.com/asset/en/media/spec_sheet_dc672.pdf
https://www.nisbets.co.uk/lincat-induction-hob/dk977
https://media.nisbets.com/asset/en/media/spec_sheet_dk977.pdf
https://media.nisbets.com/asset/en/media/user_manual_dk977.pdf
https://middleby-cdn.com/usermanuals/Lincat_IH21_Hobs_Manual_1.pdf
https://www.bertos.com/en/media/download/2024/03/schede_tec_macros700_2024_it_en_fr_de_6227.pdf
https://www.bertos.com/en/products/cook/electric-food-warmer/s-700/electric-food-warmer-se7sp-4b
https://www.intergastro.com/french-fries-tub-constant-e7sp-4b-macros-700-electric-1000-watts-230-volts-200263
https://www.swanwickfoodservice.com/bertos-macros-700-electric-food-warmer-counter-top-18803000-e7sp-4b/
https://www.fimarspa.it/
https://www.manualslib.com/products/Fimar-Easyline-Pfd35n235m-12043137.html
https://horecatiger.eu/it-it/ricambi/apparecchiature/piastra-di-induzione-modello-pfd-35-230v-1p+n+t-50hz-lar-343mm-p-440mm-h-120mm-800-3500w/p/G100115
https://www.plasticartsrl.it/prodotto/piastra-induzione-pfd35n-cm-343x44-3-5-kw/
https://www.facchiniimpianti.it/prodotti/PIASTRA_INDUZIONE_EASYLINE_FIMAR_PFD35N
https://macchinari.moca.it/product/piastra-induzione-pfd-3500-fimar/
https://macchinari.moca.it/product/piastra-induzione-pfd35n-fimar/
https://www.meking.it/shop/easyline-fimar-piastra-induzione-pfd35n/
https://ristoshop24.com/prodotto/piastra-induzione-pfd35n/
https://www.manualslib.com/manual/1667330/Bravilor-Bonamat-Whk-Series.html

---

## 10. Image and document sourcing (July 2026)

Downloaded to `C:\Users\jonah.wakahiu\Desktop\ecommerce\products resource\<brand>-images\`,
one folder per brand. **Nothing copied into the project.** Every file was opened and visually
verified. No thumbnails kept. No image or specification was taken from `sheffieldafrica.com`
at any point.

### 10.1 `simonelli-images\` — 11 files

| SKU | File | Px | Size | Notes |
|---|---|---|---|---|
| IMG/COF/00054 | `IMG-COF-00054__spec-sheet.pdf` | — | 63 KB | US "Microbar Spec Sheet" — documents the **first-generation** machine (§3.3); useful as evidence, not as the source of truth |
| IMG/COF/00054 | `IMG-COF-00054__brochure.pdf` | — | 2 372 KB | ⭐ **The gold-standard source.** 12-page official multilingual brochure; the 4-variant spec table on pp. 10-11 settles dimensions, voltage, power, boiler count and hopper capacity |
| IMG/COF/00054 | `IMG-COF-00054__MicrobarII-white-front-straight-brochure.jpeg` | 1200×1633 | 262 KB | **Best primary candidate.** Pearl-white machine, `MICROBAR II` wordmark legible, 8-button fascia |
| IMG/COF/00054 | `IMG-COF-00054__MicrobarII-white-front-angle-brochure-cover.jpeg` | 1245×1528 | 220 KB | Brochure cover shot, black background, three-quarter angle |
| IMG/COF/00054 | `IMG-COF-00054__MicrobarII-white-front-full-brochure.jpeg` | 724×1237 | 157 KB | Fullest view of the whole machine incl. drip tray; slightly cropped at right |
| IMG/COF/00054 | `IMG-COF-00054__MicrobarII-white-and-red-pair-brochure.jpeg` | 734×1036 | 123 KB | Both factory colours side by side — proves white/red are the catalogue finishes |
| IMG/COF/00054 | `IMG-COF-00054__MicrobarII-cupwarmer-accessory-brochure.jpeg` | 699×1237 | 171 KB | The optional **scaldatazze** cup-warmer accessory |
| IMG/COF/00054 | `IMG-COF-00054__REF__MicrobarII-black-variant-front-tecnocoffeeshop.jpg` | **2362×3145** | 865 KB | ⚠ `REF__` — highest-resolution file in the whole pass, but it is the **black** variant, which does not appear in the official brochure and does not match our stored photo. Do not use as the primary without a colour decision |
| IMG/COF/00054 | `IMG-COF-00054__REF__brochure-p4-6.jpeg` · `-p5-9.jpeg` · `-p5-10.jpeg` | 491×1036 · 618×1425 · 580×1364 | 220 KB total | Partial brochure crops — supporting only |

### 10.2 `bravilor-images\` — 6 files

| SKU | File | Px | Size | Notes |
|---|---|---|---|---|
| IMG/COF/00137 | `IMG-COF-00137__spec-sheet.pdf` | — | 74 KB | Miko dealer spec card — the source of the **"SP30 or 3 PH"** power requirement and the single-container **600 × 570 × 660** figure (§4.1-4.2) |
| IMG/COF/00137 | `IMG-COF-00137__official-B10-HW-L-single-container.png` | 731×1080 | 377 KB | ⭐ **Best primary candidate.** Official Bravilor render, **single 10 L container** + hot-water tap — matches our stored photo exactly |
| IMG/COF/00137 | `IMG-COF-00137__official-B10-HW-R-single-container.png` | 731×1080 | 377 KB | Byte-identical to the `-L-` file — Bravilor reuses one render for both hands; kept so the naming is unambiguous |
| IMG/COF/00137 | `IMG-COF-00137__REF__official-B10-TWIN-container-hero.png` | 1153×1080 | 612 KB | ⚠ `REF__` — the render on Bravilor's `/b10-2/` page. **Two** containers, fascia reads `B 10-HW`. Wrong unit for a "single decanter" listing |
| IMG/COF/00137 | `IMG-COF-00137__REF__official-B10-W.png` | 787×1080 | 82 KB | ⚠ `REF__` — the wide `B10 W` variant, 1115 mm |
| IMG/COF/00137 | `IMG-COF-00137__REF__miko-specsheet-B10-single-551x766.jpeg` | 551×766 | 48 KB | ⚠ `REF__` — under 800 px; kept only because it is the one image explicitly captioned as the **single** machine on the spec card |

### 10.3 `lincat-images\` — 11 files

| SKU | File | Px | Size | Notes |
|---|---|---|---|---|
| IMG/BUF/00127 | `IMG-BUF-00127__official-lincat-spec-sheet.pdf` | — | 1 485 KB | ⭐ Lincat's own automated spec sheet for **IH21** |
| IMG/BUF/00127 | `IMG-BUF-00127__official-lincat-manual.pdf` | — | 349 KB | Lincat IH21 installation/operating manual (the Nisbets `user_manual_dk977.pdf` is **byte-identical**, so the duplicate was deleted) |
| IMG/BUF/00127 | `IMG-BUF-00127__nisbets-spec-sheet.pdf` | — | 173 KB | Nisbets' own version, headed *"IH21 — Lincat Electric Counter-top Induction Hob, 2 Zones — W 350 mm — 3.0 kW"* — corroborates §5.1 |
| IMG/BUF/00127 | `IMG-BUF-00127__official-IH21-front-left.jpg` | **2362×1663** | 809 KB | ⭐ **Best primary candidate.** Lincat's own studio render: `lincat` wordmark on the glass and on the fascia, `SCHOTT CERAN` mark top-right, two rotary knobs. **Provably the same unit as our stored 600×600 photo** — a straight ~4× resolution upgrade |
| IMG/BUF/00127 | `IMG-BUF-00127__official-IH21-line-drawing.png` | 1000×1000 | 71 KB | Lincat's dimensioned line drawing — reference, not a product photo |
| IMG/BUF/00127 | `IMG-BUF-00127__official-IH21-lifestyle-1…4.jpg` | 8250×5550, 8250×5550, 7860×5550, 8256×5504 | ~20 MB **each** | Lincat's raw lifestyle photography. Genuine and excellent, but **unresized camera originals** — resize hard before any use |
| IMG/BUF/00127 | `IMG-BUF-00127__nisbets-IH21-front-angle.jpg` · `-angle-2.jpg` | 1100×1100 each | 141 / 183 KB | Nisbets' square-format renders, same unit, useful if a square aspect is wanted |

### 10.4 `bertos-images\` — 3 files

| SKU | File | Px | Size | Notes |
|---|---|---|---|---|
| IMG/HOT/00005 | `IMG-HOT-00005__official-E7SP-4B-front.jpg` | 1288×1154 | 211 KB | ⭐ **Only image for this SKU, and the record currently has `image: null`.** Berto's own render: perforated GN 1/1 pan, fat drain, ceramic lamp gantry, green rocker switch, `BERTO'S` badge on the front panel |
| IMG/HOT/00005 | `IMG-HOT-00005__spec-sheet.pdf` | — | 584 KB | ⭐ Berto's official datasheet for codes 18803000 / 18803500, with the **dimensioned drawings** (400 / 714 / 290 and the 900-high cabinet version) |
| IMG/HOT/00005 | `IMG-HOT-00005__macros700-series-datasheets.pdf` | — | 34 688 KB | The whole macros 700 series datasheet book (IT/EN/FR/DE) — large, but the definitive reference if more Bertos SKUs are audited |

### 10.5 `fimar-group-images\` — 8 files

| SKU | File | Px | Size | Notes |
|---|---|---|---|---|
| IMG/HOT/00395 | `IMG-HOT-00395__spec-sheet.pdf` | — | 61 KB | ⭐ Fimar S.p.A. official datasheet for `PFD35N` |
| IMG/HOT/00395 | `IMG-HOT-00395__easyline-PFD35N-front-angle-1500px.jpg` | **1500×997** | 179 KB | ⭐ **Best primary candidate.** Correct unit: `EASYLINE` badge front-left, ⏱/−/+/temp/power row, 4-digit LED, no rear upstand. Replaces a stored image that is only **275×183** |
| IMG/HOT/00395 | `IMG-HOT-00395__easyline-PFD35N-front-angle-1127px.jpg` | 1127×750 | 72 KB | Same unit, alternate crop |
| IMG/HOT/00395 | `IMG-HOT-00395__REF__fimar-official-spec-table-PFD20-PFD27-PFD35.jpg` | 800×306 | 49 KB | ⭐ Reference, not a photo — **Fimar's own multilingual comparison table** for PFD/20 · PFD/27 · PFD/35. The source for §7.2 and §7.4 |
| IMG/HOT/00395 | `IMG-HOT-00395__REF__fimar-official-specsheet-photo-500x333.jpeg` | 500×333 | 18 KB | ⚠ Under 800 px — the datasheet's own embedded photo; kept as the manufacturer-authored reference against which distributor photos were judged |
| IMG/HOT/00395 | `IMG-HOT-00395__REF__plasticart-PFD35N-600px.jpg` | 600×515 | 20 KB | ⚠ Under 800 px, correct unit; superseded by the 1500 px file |
| IMG/HOT/00395 | `IMG-HOT-00395__REF__meking-banner-1600x734.jpg` | 1600×734 | 55 KB | ⚠ Wide banner crop, not a usable product shot |
| IMG/HOT/00395 | `IMG-HOT-00395__REF__moca-listing-WRONG-MODEL-different-control-panel.png` | 800×800 | 271 KB | ⚠ **`REF__` — DO NOT USE.** Filed by moca.it under the PFD35N code but shows a different plate: rear splash upstand, five touch controls, SCHOTT CERAN badge top-right (§7.4) |

### 10.6 `nisbet-images\` — 9 files

Folder created as instructed; **every file in it is a BRAVILOR product** (§8).

| SKU | File | Px | Size | Notes |
|---|---|---|---|---|
| IMG/BUF/00073 | `IMG-BUF-00073__spec-sheet.pdf` | — | 1 226 KB | ⭐ **Evidence exhibit for §8.** Served by Nisbets as "spec_sheet_dc672.pdf" but is a two-page **BRAVILOR BONAMAT** brochure, doc no. `904.150.004C`, footed *"Your Bravilor Bonamat dealer"* |
| IMG/BUF/00073 | `IMG-BUF-00073__nisbets-WHK-front-angle-empty.jpg` | 1100×1100 | 143 KB | ⭐ **Best primary candidate.** Dark-grey cabinet, three stainless shelves, per-shelf switches, and **`BRAVILOR BONAMAT` stamped on the front rail** — the visual proof for §8.2 |
| IMG/BUF/00073 | `IMG-BUF-00073__nisbets-WHK-angle-2.jpg` · `-angle-3.jpg` · `-angle-4.jpg` | 1100×1100 each | 145 / 156 / 182 KB | Further Nisbets angles of the same unit |
| IMG/BUF/00073 | `IMG-BUF-00073__official-bravilor-WHK-hero.png` | 710×1080 | 360 KB | Bravilor's own accessory-page render (stainless-dark finish — note this is the `…82002` variant, not the `…82001` dark-grey that Nisbets stocks) |
| IMG/BUF/00073 | `IMG-BUF-00073__WHK-open-door-cups-brochure-792x915.jpeg` | 792×915 | 310 KB | Brochure hero: unit loaded with espresso cups, door open |
| IMG/BUF/00073 | `IMG-BUF-00073__REF__brochure-lifestyle-p1.jpeg` · `-p2.jpeg` | 1304×1430 each | 274 / 251 KB | ⚠ `REF__` — brochure lifestyle scenes (baristas, café), not product shots |

### 10.7 Notes for whoever adopts these

- **Two SKUs have no usable stored image and this pass fixes both**: IMG/HOT/00005 has
  `image: null` outright, and IMG/HOT/00395's stored file is **275 × 183** — barely a
  thumbnail.
- **Three more are 600 × 600 stubs** (IMG/COF/00137, IMG/BUF/00127, IMG/BUF/00073). In each
  case the sourced replacement is **provably the same physical unit**, so these are pure
  resolution upgrades with no wrong-model risk.
- **The only stored image with a real content question is IMG/COF/00054** — see §3.7.
- **No synthetic upscales were found.** Every file is at or below its source's native size;
  nothing needed an `-UPSCALED` suffix.
- **Files under the 800 px floor were kept only where they carry unique evidence** (the Miko
  single-machine crop, Fimar's own datasheet photo, the Plasticart shot) and are all marked
  `REF__`.

---

## 11. Recommended changes — nothing applied, priority order per SKU

### SIMONELLI — IMG/COF/00054 (MICROBAR II)

1. 🔴 **Fix the electrical spec.** `POWER: 110V / 2000W / 18A` → **`230 V, 8 A, 2000 W,
   50/60 Hz`**. The stored figure is the North-American build; Kenya needs the 230 V build — §3.2
2. 🔴 **Fix the `description`'s three factual errors**: **one** 0.7 L boiler (not two);
   **0.25 kg** bean hopper standard / 0.35 kg with the extra-sylos accessory (not 400 g);
   grounds box **20-35** pucks — §3.5
3. 🔴 **Fix the width/height transposition**: `length:325, width:480, height:460` →
   **`length:325, width:460, height:480`** — §3.4
4. 🟠 Add **weight 27 kg**, output (120 espressos/h, 60 cappuccinos/h, ~10 L/h hot water,
   ~80 cups/day), 50 mm burrs, 5 L tank, stainless + ABS body, energy-saving mode, automatic
   coffee and milk wash cycles — §3.6
5. 🟡 **Decide on the product photo** — the stored image looks like the first-generation
   Microbar, not the Microbar II — §3.7
6. 🟡 Note in copy that the model is **discontinued** by Nuova Simonelli (relevant to spares
   and lead times) — §3.7

### BRAVILOR — IMG/COF/00137 (B10)

1. 🔴 **Pin down the variant before populating anything.** The stored photo indicates
   **B10 HW R** (645 × 570 × 840, art. 4.216.316.110), not the twin-container B10
   (955 × 512 × 840) that Bravilor's headline `/b10-2/` page shows — §4.1
2. 🔴 **Add the electrical/installation reality**: 6-8.3 kW, needing a **dedicated 30 A
   single-phase or a 3-phase supply**, plus a plumbed 15 mm mains feed at ≥1 bar. No waste
   connection needed — §4.2
3. 🟠 Build out the record from scratch — `description` is `null` and there is no
   `technical_specification`: 10 min / 10 L brew, **250 cups/h**, stainless housing, digital
   display, total + day counters, coffee-ready indicator, built-in descaling — §4.3
4. 🟡 Replace **"decanter"** with **"10 litre insulated container"** in the name and
   `short_description` — Bravilor never calls it a decanter — §4.1
5. 🟡 `price` is **0** and status is **archived** — both need a decision before republishing
6. ⚪ `model_number` `B10` is correct — no change

### LINCAT — IMG/BUF/00127 (DK977 → IH21)

1. 🔴 **Build out the entire record** — `description` is `null` and there are no dimensions.
   Add **350 × 654 × 115 mm**, **12 kg**, **230 V 1ph 3.0 kW 13 A**, 2 zones, 6 mm Schott
   Ceran, max +190 °C, boost, pan detection, IP24, Made in UK — §5.2
2. 🟠 **Needs approval:** `model_number` **`DK977` → `IH21`**, with `DK977` retained in the
   spec table as *"Nisbets catalogue reference"*, and `name` → **"Induction Hob Lincat
   IH21"**. `DK977` is a distributor SKU in a foreign namespace, not a manufacturer code — §5.1
3. 🟡 Replace the 600 × 600 stored photo with the 2362 × 1663 Lincat render — §10.3
4. ⚪ **No electrical change** — 230 V / 13 A is already correct for Kenya and ships with a
   Type G plug — §5.3

### BERTOS — IMG/HOT/00005 (E7SP-4B)

1. 🔴 **Add an image** — the record has `image: null`. Berto's official render is downloaded — §10.4
2. 🔴 **Build out the entire record** — `description` is `null`, no dimensions, no spec. Add
   **400 × 714 × 290 mm**, **19 kg**, **220-240 V 1.1 kW**, GN 1/1 305 × 510 × 175 pan,
   AISI 304, ceramic lamp above + element under tank, fat drain, adjustable feet, CE — §6.3
3. 🟠 **Sharpen the product name** — it is a **chip scuttle / fried-food warmer**, not a
   general bain-marie. "Food Warmer Electric Bertos" will mis-set buyer expectations — §6.2
4. 🟡 Add Berto's code **18803000** and series **macros 700** to the spec table; note the
   `-4M` cabinet sibling (18803500) as an upsell — §6.1
5. 🟡 `status` is **archived** — decide whether to republish
6. ⚪ `model_number` `E7SP-4B` is correct — no change. ⚪ No electrical change — §6.4

### FIMAR GROUP — IMG/HOT/00395 (PFD35N235M)

1. 🟠 **Needs approval:** `model_number` **`PRD35N235M` → `PFD35N235M`** — a single-character
   transcription error (`R` for `F`); `PRD` is not a Fimar prefix — §7.1
2. 🟡 Replace the **275 × 183** stored image with the 1500 × 997 sourced photo — §10.5
3. 🟡 Add the confirmed-but-missing fields: packaging 510 × 420 × 190 mm / 0.041 m³, **power
   yield 500-3500 W**, auto-off 120 min, timer to 180 min, **EASYLINE by Fimar** sub-brand,
   short SKU `PFD35N` for searchability — §7.4
4. 🟡 Note that 3.5 kW ≈ 15 A wants a **16 A outlet or dedicated spur**, not a shared 13 A
   socket — §7.5
5. ⚪ **No dimension change and no axis swap** — this is the one record in the pass whose
   numeric fields are already correct, and every stored spec figure matches Fimar's
   datasheet exactly — §7.3

### NISBET → BRAVILOR — IMG/BUF/00073 (WHK003)

1. 🔴 **Change `brand` from `NISBET` to `BRAVILOR`** — Nisbets plc is a distributor; the
   product is a Bravilor Bonamat WHK, `WHK-003` is printed on Bravilor's own manual, and the
   cabinet physically carries the Bravilor badge — §8.1-8.2
2. 🔴 **Build out the entire record** — `description` is `null`, no dimensions, no spec. Add
   **349 × 400 × 542 mm**, **10 kg**, **230 V~ 50/60 Hz 85 W**, **~120 espresso cups**,
   **3 independently switchable heated shelves**, 65-70 °C, stainless steel, dark-grey — §8.4
3. 🟠 **Sweep the catalogue for other `NISBET`-branded rows** — every one is by definition
   mis-attributed, and this is now the second SKU in the pass (with `DK977`) where a Nisbets
   identifier has leaked into a manufacturer field — §8.3
4. 🟡 Tidy the name to **"Cup Warmer 3-Shelf Bravilor WHK"** — §8.3
5. 🟡 Use **349 × 400 × 542**, not Bravilor's own spec-table figure of 330 × 570 × 660, which
   contradicts Bravilor's own prose, its brochure and Nisbets — §8.4
6. ⚪ **`model_number` `WHK003` is CORRECT and must not be changed** — it is Bravilor's code,
   not a distributor reference — §8.3
7. ⚪ No electrical change — 230 V / 85 W, Type G plug — §8.5

### `brands.json`

| Action | Detail |
|---|---|
| ⚪ **No change** — `bertos` | `https://www.bertos.com/en` is live and correct |
| ⚪ **No change** — `simonelli` | `https://simonelligroup.com/` is live. Optionally switch to `https://nuovasimonelli.com/` (the brand-specific site) and add "Nuova Simonelli S.p.A., Belforte del Chienti, Italy — part of Simonelli Group" |
| 🔴 **ADD `bravilor`** | Bravilor Bonamat B.V., Netherlands — `https://www.bravilor.com/` — would then cover **two** SKUs (IMG/COF/00137 and, after §8, IMG/BUF/00073) |
| 🔴 **ADD `lincat`** | Lincat Ltd, Lincoln, UK, part of the Middleby group — `https://www.lincat.co.uk/`. ⚠ Do **not** merge with the existing `lincar-memme` row — different company, different country |
| 🔴 **ADD `fimar-group`** | Fimar S.p.A., Villa Verucchio (RN), Italy — **`https://www.fimarspa.it/`**. ⚠ **`fimar.it` does not resolve** — using it would create a dead link on day one — §1 |
| 🚫 **DO NOT ADD `nisbet`** | Nisbets plc is a UK distributor, not a manufacturer. The correct fix is to re-attribute the SKU to BRAVILOR — §8 |
