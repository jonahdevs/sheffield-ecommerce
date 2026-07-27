# Eurotec Riga Product Research

Research notes behind a EUROTEC RIGA verification pass on `products.json` (July 2026).
Covers the single EUROTEC RIGA SKU in the catalogue: `IMG/BUF/00012`, the
"Induction Cooker Drop in Riga Rib 3520 EB".

This brand was flagged going in as a possible low-verification house/OEM name — the
suspicion being either a Latvian ("Riga") connection or a white-label Chinese induction
OEM. **Both suspicions are wrong.** Eurotec Riga is a real, named, 45-year-old Italian
manufacturer, and RIB-3520EB is a real model out of its own printed catalogue. This one
verified about as well as a brand can.

**No `products.json` or `brands.json` changes have been applied** — findings only, same
starting point as the Brema and Santos passes before a scope decision.

---

## 1. Brand identification — resolved, and it is not what the slug suggests

**Eurotec Riga International srl** — an **Italian** manufacturer/distributor of
professional **microwave ovens and induction cooking hobs** for the HORECA and marine
sectors. Nothing to do with Latvia; "Riga" is the company's own long-running brand mark
(`riga international`), used alongside the "Eurotec Riga — Food Service Technology" logo.

| Field | Value |
|---|---|
| Legal name | Eurotec Riga International srl |
| VAT | IT00387400211 |
| Address | Binderweg — Via Bottai 9/1, LANACENTER/Lana Sud, 39011 **Lana (BZ), Italy** (South Tyrol) |
| Phone / fax | +39 0473 56 27 52 / +39 0473 56 24 84 |
| Email | info@eurotecriga.com |
| Age | Company logo carried a "40" laurel on 2018 datasheets and a "45" laurel on 2025 datasheets — i.e. founded ~1978-1980 |

**Official website (currently missing from `brands.json`):**
https://www.eurotecriga.com

Two sibling domains are also live and carry the same catalogue, both self-referenced in
the footer of the official datasheets:
https://www.rigainternational.com
https://www.rigainternational.eu

**Recommended `brands.json` change (not applied):** set
`website_url` to `https://www.eurotecriga.com`.

### 1.1 The stored brand description is also wrong ⚠

`brands.json` currently says:

> "Eurotec Riga specializes in **commercial refrigeration** and kitchen equipment. They
> provide comprehensive solutions for professional kitchen **cooling and storage** needs."

Eurotec Riga makes **no refrigeration products at all**. Their entire catalogue is
microwave ovens (MW\* codes), accelerated-cooking ovens, and induction hobs (RIA/RIB
codes) — light duty, medium duty, heavy duty and marine ranges. This description looks
auto-generated/placeholder and should be rewritten if the record is ever touched.

---

## 2. Where to look

| Resource | URL | Value |
|---|---|---|
| Official site (current) | https://www.eurotecriga.com/en/ | Current lineup only — RIB codes have been retired |
| Official technical datasheets index | https://www.eurotecriga.com/en/technical-datasheets/ | Per-model "CIRCOLARE" PDFs, the gold standard for specs |
| Official induction category | https://www.eurotecriga.com/en/product-category/professional-induction-range/ | Current RIA-series models |
| **Archived official product page for our exact model** | https://web.archive.org/web/20211209072017/http://eurotecriga.com/it/prodotti-it/22-piastre-ad-induzione/38-rib-3520eb | **Primary feature source for RIB-3520EB** |
| Archived official page, English | https://web.archive.org/web/20211209073350/http://eurotecriga.com/en/products/23-induction-cooker | English wording of the same feature list |
| **Official Eurotec Riga price list PDF (2018/01) covering RIB-3520EB** | https://web.archive.org/web/20211209083707id_/http://eurotecriga.com/attachments/article/38/LISTINO%20PREZZI%20RIB-3535ET_RIB-3520EB-KIT-1801.pdf | **Primary dimension/weight source** |
| Official datasheet, sibling model RIB-3535ET | https://web.archive.org/web/20211209073512id_/http://eurotecriga.com/attachments/article/37/CIRCOLARE%20RIB-3535ET-IT.pdf | Disambiguates the two models (see §5) |
| Official datasheet, successor model RIA-3521EB | https://www.eurotecriga.com/wp-content/uploads/2025/06/CIRCOLARE-RIA-3521EB-ITA.pdf | Current-generation replacement |
| Official product page, successor RIA-3521EB | https://www.eurotecriga.com/prodotti/1558/ | Current-generation replacement, with renders |

### Traps

1. **`CIRCOLARE RIB-3520EB-IT.pdf` / `_EN.pdf` are linked from the archived page but were
   never themselves captured by the Wayback Machine** (both 404). The 2018 price-list PDF
   was captured, and it is what carries the dimensions and weight. There is currently no
   way to reach the full RIB-3520EB datasheet.
2. **PDFs must be opened with the `Read` tool, not WebFetch** — same as the Santos pass.
   WebFetch returns binary/font noise.
3. **Search engines conflate RIB-3520EB with RIB-3535ET.** A "420 x 330 x 100 mm"
   dimension set is widely echoed against the 3520EB in search summaries. It is **not this
   model** — see §5.
4. **Search engines also conflate RIB 3520 EB with RIB 3521 EB.** Polish reseller
   sprzetgastronomiczny.com lists a product *titled* "RIB 3520 EB" whose own
   "Kod producenta" field reads **"RIB 3521 EB"** — the two codes are muddled across the
   whole Czech/Polish reseller layer.

---

## 3. Model verification: RIB-3520EB is genuine, and it is Eurotec Riga's own code

The archived official Italian product page (December 2021 capture) carries the model
under `PIASTRE AD INDUZIONE` with this feature list, reproduced verbatim:

> RIB-3520EB — Piastra di cottura ad induzione professionale ad incasso.
> Pannello comandi "TOUCH + MANUALE" - Struttura in acciaio inossidabile - Livelli di
> potenza resa: 1/ 2/ 3/ 4/ 5/ 6/ 7/ 8/ 9/ 10 - Livelli di temperatura regolabile da
> 60 / 80 / 100 / 120 / 140 / 160 / 180 / 200 / 240 °C - Timer 0 ~ 180 minuti - Diametro
> pentola: min.12cm~max 26cm - Dispositivo autoprotezione - Riconoscimento materiale -
> Autospegnimento.

The English capture of the same catalogue page says the same thing:

> COMMERCIAL INDUCTION COOKING HOBS. Control Panel "Touch control + manual" - Stainless
> steel body - Power Levels output setting: 1/ 2/ 3/ 4/ 5/ 6/ 7/ 8/ 9/ 10 - Temperature
> levels settings: 60 / 80 / 100 / 120 / 140 / 160 / 180 / 200 / 240 °C - Timer 0 ~ 180
> minuti - Pans diameter: min.12cm~max 26cm - Multiple self-protection - Multiple auto
> detections - Auto switch off.

Our stored `description` is an almost word-for-word English rendering of this — so the
catalogue copy came from a genuine Eurotec Riga source originally. Two independent
confirmations that the code is live in the trade:

- **Alrazana (Dubai distributor)** carries "Commercial Induction Cooking Hobs
  (RIB-3520EB)" with the same feature copy and the same product photography:
  https://alrazanaonline.com/product/commercial-induction-cooking-hobs-rib-3520eb/
- **RM Gastro / RedFox (Czech Republic)** sell the identical unit rebadged as
  "RIB 3520 EB", manufacturer code **00025504** — see §6.

### 3.1 `model_number` is correct — do not "fix" it back ⚠

The client's own legacy site records this exact SKU with a **different** model number:

> Item No: IMG/BUF/00012 · Model No: **RIB-350 EB** · Brand: EUROTEC RIGA
> https://www.sheffieldafrica.com/kitchen/product/439/induction-cooker-drop-in-riga-rib-350-eb

(its image file is even named `RIB35EB.jpg`). **"RIB-350 EB" is not a real Eurotec Riga
code** — it does not appear in any Eurotec Riga catalogue, price list or datasheet, and
returns nothing anywhere else. `products.json`'s current **`RIB 3520 EB` is the correct
manufacturer code** and someone has already fixed this. Per
[[feedback_model_number_unique_id]] it should be left exactly as it is.

---

## 4. Per-SKU findings — IMG/BUF/00012

### 4.1 Confirmed correct in the current record

| Stored | Verdict |
|---|---|
| 3500 Watt | ✅ official — `POTENZA 3500 WATT` |
| 220 V ~ 240 V — 50/60 Hz | ✅ official, verbatim |
| Touch control panel | ✅ official — "Touch control + manual" (our copy drops the "+ manual") |
| Stainless steel structure | ✅ official |
| 9 levels of adjustable temperature 60-240 °C | ✅ official — 60/80/100/120/140/160/180/200/240 °C, nine steps |
| Timer 0-180 minutes | ✅ official |
| Self-protection device | ✅ official |
| Material recognition | ✅ official |
| Drop-in / built-in ("ad incasso") | ✅ official |

### 4.2 "12 levels of power output" is wrong — it is the sibling model's spec ⚠

Our description says **"12 levels of power output"**. The official RIB-3520EB page says
**10** (`1/ 2/ 3/ 4/ 5/ 6/ 7/ 8/ 9/ 10`).

Where the "12" comes from is now provable: the **RIB-3535ET** — Eurotec Riga's *other*
induction hob on the very same catalogue page — lists **twelve** power steps, expressed as
wattages: `500 / 700 / 900 / 1200 / 1500 / 1800 / 2000 / 2300 / 2700 / 3000 / 3300 / 3500
Watt`. Count them: 12.

This is the same **cross-SKU spec contamination** documented in the Santos pass (the
34-1's wattage taken from the 34-2, the 37-A's from the 33) and the Pradeep milk-boiler
bug. Recommended correction: **12 → 10 power levels**.

### 4.3 Dimensions — genuine unresolved conflict, do not overwrite blind ⚠

Three dimension sets exist for this model and they do not reconcile.

| Source | W × D × H (mm) | Weight |
|---|---|---|
| **Eurotec Riga's own 2018 price list** (manufacturer, primary) | **335 × 356 × 125** | **7 / 7.5 kg** net/gross |
| RedFox/RM Gastro reseller data (careho.pl, code 00025504) | 360 × 380 × 120 | 4.5 kg |
| **Our `products.json` / legacy Sheffield site** | 360 × 382 × 120 | *(none stored)* |

Our stored figures track the **RedFox rebadge** listing, not the Italian manufacturer's
own price list. The 2 mm difference (382 vs 380) is noise; the shape of the disagreement
is real: the manufacturer's own sheet is ~25 mm narrower, ~25 mm shallower and 5 mm
taller, at **more than half again the weight** (7 kg vs 4.5 kg).

Two plausible readings, neither confirmable without the missing
`CIRCOLARE RIB-3520EB-IT.pdf` (§2 trap 1):

- The RedFox 4.5 kg figure may simply be **the successor RIB 3521 EB's weight bleeding
  across** — RedFox listings demonstrably mix the two codes (§2 trap 4), and the current
  RIA-3521EB is 4.4 kg net. On that reading the manufacturer's 335 × 356 × 125 / 7 kg is
  correct for our model and our stored numbers are the contaminated ones.
- Or the 2018 price-list figures cover the **hob body only** while the reseller figure
  includes the separate remote control pod (this unit has a detached knob/LED panel on a
  lead — visible in every photo).

**Recommendation: leave the dimensions unresolved rather than guess**, exactly as the
Santos pass left the #50A. If a decision is forced, the manufacturer's own price list
(335 × 356 × 125 mm, 7 / 7.5 kg) is the higher-authority source. Either way the numbers
should be confirmed against the unit the supplier actually ships before publishing.

### 4.4 The numeric dimension fields are axis-swapped — fixable regardless of §4.3 ⚠

Independent of *which* dimension set is right, the three numbers already in the record are
stored in the wrong fields:

- Stored: `length: 360, width: 120, height: 382`
- Stored prose: "LENGTH: 360MM / WIDTH: 382MM / HEIGHT: 120MM" — **the prose and the
  numeric fields disagree with each other**, same as Brema's CB-416A and CB-640A.
- Physically the unit is 360 wide × 380 deep × **120 high** (a drop-in hob is ~120 mm
  tall, obviously not 382 mm).
- So the numeric **`width` field (120) is actually the height**, and the numeric
  **`height` field (382) is actually the depth**.

Using this catalogue's convention (`length` = width, `width` = depth, `height` = height,
as established in the Brema pass), the correct fields for the currently-stored figures
would be `length: 360, width: 380, height: 120`.

**This is the fifth brand in a row showing the same width/height transposition** (Santos
6 of 8 SKUs, Empero, Brema 2 of 4 dimensioned SKUs, now Eurotec Riga 1 of 1). It is
clearly a systematic import bug and is worth a catalogue-wide sweep rather than another
brand-by-brand fix.

### 4.5 Missing from the record

Facts on the official sources that our record does not carry:

- **Pan/cookware diameter: min 12 cm — max 26 cm** (official, and a genuinely useful
  buying spec)
- **Auto switch-off** (official; our copy has "self-protection device" and "material
  recognition" but drops this third safety feature)
- **Multiple auto-detections** (the English page's wording; ours renders only "material
  recognition")
- **"+ manual"** on the control panel — the unit is touch **and** knob, via a detached
  control pod; our copy says only "Touch control panel"
- **Single cooking zone** (1 zone — confirmed by RedFox's data and by every photo)
- **Net / gross weight** — 7 / 7.5 kg per the manufacturer price list (subject to §4.3)
- **Approvals: GS / CE / EMC / RoHS** (from the successor's datasheet; the RIB-3535ET
  sibling sheet adds LVD)

### 4.6 Encoding bug in the stored description ⚠

The `description` field contains `60-240 � C` — a broken degree symbol (mojibake, a
failed `°` round-trip). Cosmetic but it renders on the storefront. Same class of
copy-paste debris as the Quill markup stripped in the Brema and Santos passes.

### 4.7 Price note (no action)

Eurotec Riga's 2018 list price for RIB-3520EB was **€395** ex works (vs €315 for the
RIB-3535ET). Our stored price is KES 130,000. Recorded for context only — pricing is a
business decision, not a research finding.

---

## 5. The RIB-3535ET trap — "420 × 330 × 100 mm" is a different product

Search results and at least one reseller title propagate **420 × 330 × 100 mm / 4.5 kg**
against "RIB 3520". That figure belongs to the **RIB-3535ET**, the *freestanding
countertop* sibling, confirmed from its own official datasheet:

| | RIB-3520EB (ours) | RIB-3535ET (not ours) |
|---|---|---|
| Type | Drop-in / built-in (*ad incasso*) | Freestanding countertop |
| Dimensions (W × L × H) | 335 × 356 × 125 mm | **330 × 420 × 100 mm** |
| Weight net/gross | 7 / 7.5 kg | 4.30 / 5.50 kg |
| Control | Touch **+ manual**, on a detached remote pod | Touch only, front panel on the body |
| Power levels | 10 (numbered 1-10) | **12 (wattage steps 500-3500 W)** |
| Ventilation | not stated | **2 fans** ("ventilazione potenziata") |
| Power / voltage | 3500 W, 220-240 V 50/60 Hz | 3500 W, 220-240 V 50/60 Hz |
| 2018 list price | €395 | €315 |

Source for the 3535ET column:
https://web.archive.org/web/20211209073512id_/http://eurotecriga.com/attachments/article/37/CIRCOLARE%20RIB-3535ET-IT.pdf

The reseller **tomadostore.com** sells the 3535ET under the title
"Eurotec Riga RIB-3535ET - Induction Cooker - **33x42x10 cm**" — which is exactly where
the stray 420 × 330 × 100 figure enters the search index and gets misattributed. Both the
"12 power levels" error in our record (§4.2) and this dimension myth trace back to the
same sibling model.

---

## 6. RedFox / RM Gastro is the same machine rebadged — and it proves the OEM chain

RM Gastro (Czech Republic) sells this unit under its **RedFox** brand:

- RedFox **RIB 3520 EB**, manufacturer code **00025504** —
  https://careho.pl/pl/product/kuchenka-indukcyjna-drop-in-redfox-rib-3520-eb
  (360 × 380 × 120 mm, 4.5 kg, 230 V 50 Hz 1N, 3.5 kW, 1 heating zone, LED display,
  two fans, 10 power levels, 9 temperature levels 60-240 °C, timer 0-180 min,
  "przeznaczenie do wbudowania w blat" = for building into a countertop)
- RedFox **RIB 3521 EB**, manufacturer code **00038288** (the successor) —
  https://b2b.rmgastro.com/Product/redfox-rib-3521-eb-00038288
  (350 × 350 × 110 mm, net 4.40 kg / gross 5.30 kg, 3.5 kW, 230 V/1N 50 Hz, 9 power
  levels, digital control, stainless steel, glass 300 × 300 mm)

**RM Gastro's RIB 3521 EB figures match Eurotec Riga's own RIA-3521EB datasheet exactly**
(350 × 350 × 110 mm, 4.4 kg net / 5.3 kg gross, 3500 W, 220-240 V 50/60 Hz). That is the
proof that **Eurotec Riga is the manufacturer and RedFox/RM Gastro is a rebadging
distributor**, not the other way round — so keeping `brand: "EUROTEC RIGA"` on this SKU is
correct even though the model code is easier to find under the RedFox name.

Direction of the naming, for the record:

```
Eurotec Riga RIB-3520EB  (2018 catalogue, discontinued)
        ↓ superseded by
Eurotec Riga RIA-3521EB  (current catalogue)
        ↕ rebadged as
RM Gastro RedFox RIB 3520 EB (00025504) → RIB 3521 EB (00038288)
```

---

## 7. The successor model: RIA-3521EB

Our model is discontinued — it is absent from Eurotec Riga's current site and sitemap,
which lists only `RIA-3536ET`, `RIA-3536WOK`, `RIA-3521EB` and `RIA-7002-ET` in the
professional induction range. **RIA-3521EB is the direct replacement** for RIB-3520EB
(same drop-in format, same detached touch+knob control pod, same 3500 W).

Official datasheet figures
(https://www.eurotecriga.com/wp-content/uploads/2025/06/CIRCOLARE-RIA-3521EB-ITA.pdf):

| Spec | Value |
|---|---|
| Power | 3500 W (± 5%) |
| Voltage | 220 V ~ 240 V — 50/60 Hz |
| Net / gross weight | 4.4 kg / 5.3 kg |
| Width × Length × Height | 350 × 350 × 110 mm |
| Control | "Touch Control" + manual |
| Body | Stainless steel |
| Power levels | 10 (1-10) |
| Temperature levels | 60 / 80 / 100 / 120 / 140 / 160 / 180 / 200 / 240 °C |
| Timer | 0 - 180 minutes |
| Pan diameter | min 12 cm ~ max 26 cm |
| Safety | Multiple self-protection, multiple auto-detection, auto switch-off |
| Approvals | GS / CE / EMC / RoHS |

**Not recommended as a spec substitute for our SKU** — same trap as Brema's CB 249A vs
CB246A. Different dimensions, different weight, different code; it is a successor, not a
rename. But it is the right target if the supplier has moved on and this record ever needs
re-modelling.

---

## 8. Product reference

| SKU | Catalogue name | Model | Official source | Independent source | Confidence |
|---|---|---|---|---|---|
| IMG/BUF/00012 | Induction Cooker Drop in Riga Rib 3520 EB | RIB 3520 EB | https://web.archive.org/web/20211209072017/http://eurotecriga.com/it/prodotti-it/22-piastre-ad-induzione/38-rib-3520eb (archived — not on current site) | https://alrazanaonline.com/product/commercial-induction-cooking-hobs-rib-3520eb/ and https://careho.pl/pl/product/kuchenka-indukcyjna-drop-in-redfox-rib-3520-eb | **High** on brand, model code, power, voltage, controls, temperature levels, timer, pan diameter. **Medium-Low** on dimensions/weight (§4.3, three conflicting sets, manufacturer datasheet PDF never archived) |

Confidence breakdown:

- **Brand exists and is correctly named — High.** Named Italian company, VAT number,
  address, phone, live website, 45-year history, official PDFs.
- **Model code is genuine and belongs to this brand — High.** Appears in Eurotec Riga's
  own archived catalogue page *and* its own price list PDF, plus two independent
  distributors on two continents.
- **Feature set (controls, 10 power levels, 9 temperature steps, timer, pan diameter,
  safety) — High.** Straight off the manufacturer's own page, corroborated by the
  successor model's current datasheet.
- **Dimensions and weight — Medium-Low.** Genuine unresolved three-way conflict; the one
  document that would settle it (`CIRCOLARE RIB-3520EB-IT.pdf`) was never archived.

---

## 9. Recommended changes (NOT applied — findings-only pass)

**`brands.json` (`eurotec-riga`):**
1. Set `website_url` → `https://www.eurotecriga.com` (currently `null`).
2. Rewrite `description` — the stored text calls Eurotec Riga a refrigeration company,
   which is flatly wrong (§1.1). They make professional microwave ovens, accelerated
   cooking ovens and induction hobs, Italian-made in Lana (BZ) since ~1978.

**`products.json` (`IMG/BUF/00012`):**
3. `description`: **"12 levels of power output" → "10 levels of power output"** (§4.2).
4. `description`: fix the `�` mojibake in "60-240 � C" → "60-240 °C" (§4.6).
5. Numeric dimension fields: fix the width/height transposition (§4.4).
6. Add the missing confirmed specs: pan diameter 12-26 cm, single cooking zone,
   auto switch-off, "touch **+ manual**" control, GS/CE/EMC/RoHS (§4.5).
7. Reformat `description`/`technical_specification` to the Skymsen prose + Key Features +
   `<table>` pattern used across the other brand passes; add a `meta_description`
   (this SKU has none).
8. **Do not change `model_number`** — `RIB 3520 EB` is right, the legacy site's
   "RIB-350 EB" was not (§3.1).
9. **Do not overwrite the dimension values** without a supplier confirmation (§4.3).

---

## 10. Image sourcing (July 2026) — downloaded to `Downloads/eurotec-riga-images/`

Eurotec Riga's own product image for this model
(`http://eurotecriga.com/images/prodotti/piastre-ad-induzione/RIB-3520EB.jpg`) was
referenced by the archived page but **never captured by the Wayback Machine**, so the
usable photography comes from the distributor layer plus one small official slider asset.
**7 files**, named by SKU for manual review, same workflow as the Brema/Santos passes.

| File | Source | Notes |
|---|---|---|
| `IMG-BUF-00012__alrazana-RIB-3520EB-1.jpg` | https://razana-media-992382793141.s3.ap-south-1.amazonaws.com/uploads/2024/01/RIB-3520EB.jpg | **Best candidate.** 1000×1000 white-background 3/4 render showing hob + detached control pod + lead |
| `IMG-BUF-00012__alrazana-RIB-3520EB-2.jpg` | https://razana-media-992382793141.s3.ap-south-1.amazonaws.com/uploads/2024/01/RIB-3520EB-2.jpg | 1000×1000, second angle, hob body only (no control pod visible) |
| `IMG-BUF-00012__official-rigainternational-slider.webp` | https://web.archive.org/web/20240609185926id_/https://rigainternational.com/images/slider-home/rib-3520eb.webp | **Only official-domain asset found.** Correct product, but a 300 px homepage slider thumbnail — too small for a PDP |
| `IMG-BUF-00012__legacy-sheffieldafrica-RIB35EB.jpg` | https://sheffieldafrica.com/public/storage/uploads/1694505494_RIB35EB.jpg | The client's own legacy-site image — same product, same angle as the Alrazana shot, lower resolution and letterboxed |
| `IMG-BUF-00012__redfox-careho-00025504.png` | https://careho.pl/pubimg/careho-00025504.png | ⚠ **Heavily watermarked** ("careho.pl" tiled across it) — reference only, unusable on the storefront |
| `IMG-BUF-00012__successor-official-RIA-3521EB.png` | https://www.eurotecriga.com/wp-content/uploads/2025/07/RIA-3521EB.png | ⚠ **Successor model, not ours** (§7). High-res official render; cosmetically near-identical. Use only if the supplier has switched to the RIA generation |
| `IMG-BUF-00012__successor-official-RIA-3521EB-2.png` | https://www.eurotecriga.com/wp-content/uploads/2025/06/RIA-3521EB-2.png | ⚠ Successor model, second official render |

Notes for whoever adopts these:

- The Alrazana pair are almost certainly **the manufacturer's own product photography**
  redistributed by a distributor — they match the RIB-3520EB thumbnail in Eurotec Riga's
  2018 price list and the rigainternational.com slider frame exactly.
- The existing storefront image
  (`products/induction-cooker-drop-in-riga-rib-3520-eb-imgbuf00012.jpg`) appears to be the
  legacy Sheffield file; the Alrazana version is the same shot at higher resolution.
- One Polish reseller image (`sprzetgastronomiczny.com`) was identified but the host
  blocks direct fetches — skipped, and it was watermarked anyway.
- **Not copied into `storage/app/public/products/` or referenced in `products.json`** —
  staged in Downloads for review first, same as the Brema and Santos sets.
