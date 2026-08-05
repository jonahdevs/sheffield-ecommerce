# Lincar Memme Product Research

Research notes behind a **LINCAR MEMME** audit pass on `products.json` (July 2026).
Covers the single SKU carrying this brand: `IMG/HOT/00085` — *Fryer Single 13 Litres Gas
Lincar*, `model_number: G1140VN`, category Fryers, status published.

**No `products.json` or `brands.json` changes have been applied** — findings only, same
starting point as the Brema, Baron, Santos and Empero passes before a scope decision.

Headline: the brand string is **not** two companies mashed together. It is the manufacturer's
own two-part self-description — **"LincarInox by M.Emme Srl"** — collapsed into one field.
The manufacturer is real, Italian, and identified with certainty. The *model* is a harder
case: the company's website died in 2024 and `G1140` itself was never archived, so the model
had to be placed by reconstructing the manufacturer's own code-numbering scheme from the
surviving catalogue pages. That reconstruction is strong, but it is an inference, not a
datasheet.

---

## 1. Brand identification — the Lincar / Memme question (resolved)

**Verdict: one company, not two. Do not split the brand.**

Every Lincarinox datasheet is footed with the line **"Lincarinox by M-EMME"**, and every
catalogue page is footed with **"LincarInox by M.Emme Srl - Viale Bruno Buozzi, 7 – 42046
Reggiolo, RE, Italia - Tel: +39 0522 1495947 - C.F/P.IVA: 02567460353"**. The catalogue's
`LINCAR MEMME` string is that footer with the "Inox" and the "by" dropped.

The company's own "Chi siamo" page gives the full history:
https://web.archive.org/web/20160613215114/http://www.lincarinox.com/azienda-italiana-cucine-industriali-lincarinox/

- **Lincar S.p.A.** — an Italian biomass-heating (wood stoves and wood-fired cookers)
  manufacturer — diversified in **2004** into professional catering kitchens and began
  exporting, reaching "dal medio all'estremo oriente … fino ad arrivare persino in **Africa**".
- The first catering line was **Serie 700**; **Serie 900-800** and **Serie 1100** followed.
- In **2013** the heating and catering divisions were legally split. The catering division
  became **M.EMME Srl**, taken over by **Marco Motta**, son of the Lincar S.p.A. owner.
- M.EMME Srl trades the catering range under the brand **LincarInox** ("LINCARINOX —
  PROFESSIONAL KITCHENS" is the printed logo). Its own new budget line is **Serie Safari**.

So **Lincar** is the heritage/parent name and **M.Emme** is the operating company — the two
halves of one brand identity, exactly as our field has them, just badly punctuated.

### 1.1 Do not confuse it with the still-trading heating company

**Lincar S.p.A. (stoves) is a separate, live business** and is *not* the maker of this fryer:
https://www.lincarstufe.com/en/about-us/ — wood stoves, pellet stoves, wood-fired kitchen
ranges, part of Corisit s.r.l., also Reggiolo (RE). Setting `website_url` to `lincarstufe.com`
would point customers at a domestic wood-stove company. **Don't.**

### 1.2 `website_url` — there is no live official site

- Official domain was **`www.lincarinox.com`** (printed on every datasheet).
- By **September 2024** it was already a GoDaddy "under construction / renew now" parked page:
  https://web.archive.org/web/20240911193408/http://lincarinox.com/
- As of this pass (**July 2026**) `lincarinox.com` **does not resolve at all** (no DNS). Neither
  do `lincarinox.it`, `memme.it`, `m-emme.it`, `memmesrl.it`, `memmesrl.com`.
- The brand still appears as a live entry in professional spare-parts catalogues
  (**LINCAR INOX**), which is how it survives online at all:
  https://nomarsupply.com/brand/633-lincar-inox
  https://www.lfspareparts724.com/en/cooking_professional/cooking_equipment/lincar_inox
  and in a distributor directory that still lists the Reggiolo address and the dead domain:
  https://www.forniturealberghiereonline.it/lincar-inox

**Recommendation:** leave `website_url` **null** rather than inventing one, or — if a value is
wanted — use the last working archived home page:
https://web.archive.org/web/20160614012547/http://www.lincarinox.com/
The company appears to have stopped maintaining a web presence; treat this line as
**legacy/discontinued stock** when deciding whether to keep the SKU published.

### 1.3 `brands.json` logo is wrong

`brands/lincar-memme.png` (736 × 736) is **Sheffield's own red flame logo**, not a Lincarinox
logo — a placeholder that was never replaced. The real **LINCARINOX PROFESSIONAL KITCHENS**
logo (blue/grey wordmark with a tricolour chevron) is embedded losslessly in every archived
datasheet PDF (§8) at 397 × 198 — small, but authentic and extractable.

---

## 2. Where to look, and the traps

| Resource | URL | Value |
|---|---|---|
| Archived catalogue (WooCommerce, 2016) | https://web.archive.org/web/20160614012547/http://www.lincarinox.com/categoria-prodotto/friggitrici-a-gas/ | Model code ↔ series ↔ description map. **The only surviving product index.** |
| Archived per-model datasheet PDFs | `.../wp-content/uploads/2015/12/schede/<CODE>.pdf` | Full bilingual spec table + dimensioned drawings. **Only 3 of ~300 were ever archived** (§2, trap 2). |
| Company history page | https://web.archive.org/web/20160613215114/http://www.lincarinox.com/azienda-italiana-cucine-industriali-lincarinox/ | The Lincar/M.Emme relationship (§1) |
| Catalogue download page | https://web.archive.org/web/20160614010234/http://www.lincarinox.com/scarica-i-nostri-cataloghi/ | Confirms the five series: Safari, 700, 900-800, 900-900, 1100. The five PDFs themselves were **never archived**. |
| Sheffield's own master CSV | `C:\Users\jonah.wakahiu\Desktop\main\products.csv` (row 1147) | The pre-import source of this record — see §4.1 |

### Traps hit in this pass

1. **The manufacturer's website is gone, not just moved.** Unlike the Brema pass (old domain
   301s to a live one), `lincarinox.com` has expired outright. Everything below comes from
   the Wayback Machine.
2. **Only three datasheet PDFs survive** (`G0016`, `G0120`, `G1211`) out of a catalogue of
   several hundred. **`G1140.pdf` was never captured**, and neither were the five series
   catalogue PDFs. Requesting them from the Wayback returns a 142 KB HTML "not archived"
   page that `curl` will happily save with a `.pdf` extension — check `file`, not the size.
3. **Page 2 of `friggitrici-a-gas` was never captured** — and page 2 is exactly where the
   900-800 gas fryers (the G114x block) would have been listed. Every capture of that category
   is page 1 only.
4. **The Joomla-era site (`/it/prodotti/…`, `/en/products/…`) 403s inside the Wayback replay**
   — the archived HTML is the host's own "403 Forbidden" error page, not content.
5. **PDFs read fine with the `Read` tool** (drawings included) and extract losslessly with
   `pypdf` — as in the Baron, Santos and Comenda passes. WebFetch is still useless on them.
6. **General web search was exhausted** partway through this pass, and `curl`/WebFetch against
   DuckDuckGo, Bing, Mojeek and SearX all return CAPTCHA/blocked pages. Anything that needs a
   fresh search engine (e.g. a surviving distributor listing for G1140) is **not** ruled out
   by this pass — it simply could not be attempted.

---

## 3. Decoding `G1140VN`

### 3.1 The base code `G1140` is real Lincarinox syntax — confirmed by pattern, not by sighting

Lincarinox codes are `G` + 4 digits. The last two digits encode **appliance family** and
**series** on a strict `+10 per series` rule, in the order **700 → 900-900 → 900-800**, with
gas and electric interleaved. Reconstructed from the archived category listings:

| Family | 700 gas | 700 elec | 900-900 gas | 900-900 elec | 900-800 gas | 900-800 elec |
|---|---|---|---|---|---|---|
| **Fryers** | G1100-G1104 | G1110-G1113 | G1120-G1122 | G1130-G1132 | **G1140-…** | G1150-… |
| Pasta cookers | G1200-G1201 | G1210-G1211 | G1220-G1221 | G1230-G1231 | G1240-G1241 | G1250-G1251 |
| Bain-maries | — | G1300-G1305 | — | G1310-G1316 | — | G1320-G1326 |

Sources:
https://web.archive.org/web/20160614012547/http://www.lincarinox.com/categoria-prodotto/friggitrici-a-gas/
https://web.archive.org/web/20160614010143/http://www.lincarinox.com/categoria-prodotto/friggitrici-elettriche/
https://web.archive.org/web/20160614005705/http://www.lincarinox.com/categoria-prodotto/cuocipasta-a-gas/
https://web.archive.org/web/20160614012541/http://www.lincarinox.com/categoria-prodotto/cuocipasta-elettrici/
https://web.archive.org/web/20160614010126/http://www.lincarinox.com/categoria-prodotto/bagnomaria/

The **G1150 = "Friggitrice elettrica 1 vasca (17l), serie 900-800"** entry is directly visible
in the archived electric-fryer listing, and it is the anchor: with 900-800 *electric* fryers at
G115x, the only slot left for **900-800 gas fryers is G114x**. Two other appliance families
show the identical offset structure, so this is a consistent scheme rather than a coincidence.

**Conclusion: `G1140` = LincarInox SERIE 900-800, gas deep fryer, single tank.** In the 900-800
series the `x0` slot is always the **½-module (400 mm wide)** variant and `x1` the full
1-module (800 mm) variant — `G1240`/`G1241` and `G1320`/`G1321` both follow that rule — so
G1140 should be the **½-module, 400 × 900 × 850 mm** fryer. That matches the narrow single-well
unit in the stored product photo.

**Confidence: Medium-High on the code being genuine and on the series; Medium on the ½-module
reading; Low on any number derived from it.** No page, PDF or reseller listing showing the
literal string "G1140" was found anywhere.

### 3.2 A second Sheffield SKU corroborates the Lincarinox 900-800 line

Sheffield's master CSV carries a **second** Lincar product that never made it into
`products.json`:

- `IMG/HOT/00087` — *GRIDDLE SMOOTH GAS LINCAR G0910*, "1 MODULE GAS FRY TOP SMOOTH PLATE",
  plate 52.5 dm², burners 2 × 6.9 kW, total 13.8 kW, "Max consumption G20 20mb 1.46 m3/h,
  G30 30mb 1.08 Kg/h, G31 37mb 1.08 Kg/h".

`G0900-G0906` are confirmed as the **900-800 ½-module gas fry tops**
(https://web.archive.org/web/20160614010147/http://www.lincarinox.com/categoria-prodotto/frytop-a-gas/),
so `G0910` sits in the adjacent 1-module block of the same series. Sheffield therefore bought
from the **900-800** line, which independently supports the §3.1 placement of G1140 — *and*
proves Sheffield had the real Lincarinox datasheets in hand at data-entry time, because the
G0910 record reproduces a Lincarinox spec table verbatim, gas-consumption rows and all.

**That makes the fryer record's missing power figures a transcription omission, not a
missing source.** The kW line existed on the sheet the typist was reading.

### 3.3 The `VN` suffix — meaningful, but not decoded

The suffix is **not** part of the base catalogue code. Lincarinox does use single/double-letter
suffixes: the archived listing shows **`G1110M`** and **`G1112M`**, where **M = Serie Navale**
(the marine version of the 700-series electric fryers). So a suffixed code is normal syntax.

Candidate readings for `VN`, best first:

1. **"Vano" / "Vano Neutro"** — the on-cabinet version. Throughout the 900-800 series each
   appliance exists as *"su vano aperto"* (on an open cabinet) and as a plain top unit, with
   Lincarinox normally giving them different numbers (`G0900` vs `G0902`; `G1320` vs `G1325`).
   A `VN` order suffix for the cabinet option is the most natural reading, and the stored
   product photo shows an on-cabinet unit. **Unconfirmed.**
2. An importer/order-entry suffix added by Sheffield or the shipping agent — it is the **only**
   `model_number` in the entire catalogue ending in `VN`, which slightly favours this.
3. A gas-family marker. **Ruled out as unlikely**: Lincarinox marks gas families as
   **G20 / G30 / G31** in its spec tables, never as "VN" (§5).

**Do not change `model_number`.** Flagged only. If it is ever corrected, `G1140` (dropping
`VN`) is the candidate — but `VN` may be load-bearing for reordering, so it should not be
dropped without asking the supplier.

---

## 4. Field-by-field audit of `IMG/HOT/00085`

Stored record in full:

- `name`: "Fryer Single 13 Litres Gas Lincar"
- `brand`: "LINCAR MEMME" · `model_number`: "G1140VN" · `category`: Fryers
- `price`: 308,525 · `quantity`: 1 · `status`: published
- `image`: `products/fryer-single-13-litres-gas-lincar-imghot00085.jpeg`
- `description`: 13 L gas deep fryer, "Power source gas", "Tank capacity 13 Litres",
  "Tank dimensions 240 x 345", "Standard basket 230 x 315 x 120 h"
- `technical_specification`: `"<p>null</p>"` ⚠ — a literal string "null", not empty
- **No `length`, no `width`, no `height`, no `weight`, no `meta_description`.**

### 4.1 The description is a genuine but truncated Lincarinox datasheet transcription

The stored prose maps line-for-line onto the Lincarinox spec-table row labels seen on the
three surviving datasheets:

| Lincarinox row (IT / EN) | Stored line |
|---|---|
| Alimentazione / **Power source** | "Power source gas." |
| Capacità vasca / **Tank capacity** | "Tank capacity 13 Litres." |
| Dimensione vasca / **Tank dimensions** | "Tank dimensions 240 x 345." |
| *(basket line)* | "Standard basket 230 x 315 x 120 h." |
| **Dimensioni esterne / External dimensions (Larghezza / Profondità / Altezza)** | **missing** ⚠ |
| **Potenza / Power (kW)** | **missing** ⚠ |
| **Consumi massimi / Max consumption G20 / G30 / G31** | **missing** ⚠ |
| **Peso / Weight, Volume** | **missing** ⚠ |

Compare the archived G1211 sheet, which has exactly this table:
https://web.archive.org/web/20161130181409/http://www.lincarinox.com/wp-content/uploads/2015/12/schede/G1211.pdf

So the transcription is authentic as far as it goes — it just **stops after four rows**,
dropping every dimension, the gas rating and the weight. The same typist, on the sibling
G0910 griddle, *did* copy the power and consumption rows, which confirms they were on the page.

### 4.2 The 13-litre figure — consistent with the maker, but not verified for this code

Lincarinox demonstrably builds a 13 L fryer tank: **G1100** (700-series gas, 1 tank, **13 l**),
**G1103** (13 + 13 l), **G1110** (700 electric, 13 l), **G1112** (13 + 13 l). So "13 litres" is
a real Lincarinox tank size, not an invention, and it is a single figure in their catalogue —
never quoted as a range like "12-14 L".

The counter-signal: **every 900-series single-tank fryer that *is* visible in the archive is
17 L**, not 13 L (`G1120` 900-900 gas 17 l; `G1130` 900-900 electric 17 l; `G1150` 900-800
electric 17 l). If G1140 follows its own series' pattern rather than the 700-series', it would
be a **17 L** machine and both the product `name` and the description would be wrong.

Two readings, unresolved:
- **(a)** G1140 is the 900-800 **½-module** fryer and carries the smaller 13 L tank precisely
  *because* it is the half-width model (the 17 L siblings are the wider ones). The 240 mm tank
  width fits a 400 mm module; it would be lost inside an 800 mm one.
- **(b)** The typist worked from the wrong sheet — the 700-series **G1100** 13 L sheet — while
  the order code was the 900-800 **G1140**. This is exactly the "sibling-SKU value bleed"
  failure mode already documented for Baron (SE40 carrying the SE60's frontage), Santos and
  Pradeep.

Reading (a) is favoured because the ½-module rule holds across two other 900-800 families, and
because the stored tank/basket numbers are internally coherent (below). **But this is the one
figure in the record a supplier confirmation would be worth getting.**

### 4.3 Plausibility of the stored tank and basket — both check out

- **Tank 240 × 345 mm holding 13 L** ⇒ oil depth **≈ 157 mm**. That is a normal working oil
  depth for a professional fryer. The numbers are mutually consistent; no dropped digit here.
- **Basket 230 × 315 × 120 h mm** is a **real Lincarinox accessory**: the archived accessory
  list contains *"Cesti per friggitrici **23x31.5x12** - Deep fryer baskets"*, alongside the
  half-baskets at 14.6 / 13 / 11.3 × 31.5 × 12 and the double at 30 × 31.5 × 12:
  https://web.archive.org/web/20161115151113/http://www.lincarinox.com/categoria-prodotto/serie-700/page/14/
  A 230 mm basket in a 240 mm tank is the correct single full-width basket. **This is the
  strongest single piece of evidence that the stored figures came off a real Lincarinox sheet.**

### 4.4 Dimensions — nothing stored, so there is no axis-swap to check

`length`, `width` and `height` are **absent entirely** on this SKU, so the recurring
width/height transposition documented in the Brema, Santos, Empero and Baron passes **cannot
be present here**. The verification was done rather than assumed, as required — the fields
simply do not exist. (The record's prose likewise gives no external dimensions, so there is no
prose-vs-numeric conflict either.)

If dimensions are added, the catalogue convention (`length` = frontage width, `width` = depth,
`height` = height) and the §3.1 ½-module reading give **400 × 900 × 850 mm** — but that is
**inferred from the series, not sourced**, and should be labelled as such or left out. Every
archived Lincarinox module is **850 mm** high, and the 900-800 series is **900 mm** deep; only
the frontage (400 vs 800) depends on the ½-module reading.

### 4.5 Specs the record is missing that the manufacturer certainly published

From the three surviving Lincarinox gas/electric datasheets, every model sheet carries:
external dimensions, tank capacity and dimensions, **burner power in kW**, **max consumption
for G20 / G30 / G31**, net weight, packed volume, plus a construction bullet list. For a gas
unit the sheets also specify **gas connection ½" ISO 7-1**, a **pressure test point**, a
**flue/chimney**, **thermocouple safety valve with protected pilot flame**, **piezoelectric
manual pilot ignition**, **AISI 304 Scotch Brite** exterior, **head-to-head junction between
modules**, **height-adjustable stainless feet**, **connection from below**, and **CE marking**.

Fryer-specific features the record does **not** mention and which a fryer buyer expects —
**cool zone, safety/limit thermostat, oil drain tap, thermostat temperature range, tank
material and thickness** — are **not confirmed for this model** by any source found. They
should not be written into the record on the assumption that "all fryers have them"; the
Baron pass showed how easily an invented-sounding line becomes a permanent catalogue fact.

---

## 5. Gas type and rating — the most important gap ⚠

### 5.1 The record has no gas rating at all

There is **no kW, no BTU and no consumption figure** anywhere on `IMG/HOT/00085`. For a gas
appliance sold in Kenya this is the single most consequential omission: it is the number an
installer sizes the regulator, hose and ventilation from.

### 5.2 Lincarinox ships gas equipment set for **natural gas**, with an LPG kit

The G0016 gas datasheet states it explicitly, in both languages:

> *"Predisposizione standard per funzionamento con gas naturale (metano) con ricambio ugelli di
> serie per GPL (a richiesta possono essere fornite già predisposte a GPL)."*
> *"Standard natural gas (methane) setting. The machine comes with replacement nozzles, designed
> to permit the LPG conversion (this article can be supplied already converted to LPG, upon
> request)."*

https://web.archive.org/web/20161130181403/http://www.lincarinox.com/wp-content/uploads/2015/12/schede/G0016.pdf

**Implication for Kenya, which runs on LPG:** a Lincarinox gas fryer arrives configured for
**G20 natural gas** unless it was ordered LPG-converted. It must be run on the **G30/G31
injectors** supplied in the box, fitted by a competent installer. This should be stated on the
product page rather than left for the customer to discover.

### 5.3 What does and does not change between NG and LPG

Lincarinox quotes **one nominal kW rating** and then **three consumption figures**, one per gas
family — e.g. the G0016 solid top: **11 kW total**, and *max consumption* **G20 20 mbar
1.164 m³/h · G30 30 mbar 0.867 kg/h · G31 37 mbar 0.867 kg/h**. The sibling G0910 griddle in
Sheffield's own CSV follows the same shape (13.8 kW; 1.46 m³/h / 1.08 kg/h / 1.08 kg/h).

So: **the kW figure is the same on LPG and on natural gas** — what changes is the injector
size, the supply pressure (20 mbar G20 vs 30/37 mbar G30/G31) and the units the consumption is
expressed in. **No conversion arithmetic should ever be done between the m³/h and the kg/h
figures when populating this record**; they are alternative statements of the same rating.

### 5.4 Sanity band for a 13 L gas fryer — context only, not a spec

The record cannot be given a rating from any source located in this pass. For plausibility
review only, comparable Italian 13 L single-tank gas fryers sit at roughly **10-12 kW**
(≈ 34,000-41,000 BTU/h):

- 13 L, 400 × 700 × 850, **10.2 kW** — https://www.ristotecno.com/friggitrici-a-gas/4025-friggitrice-ad-1-vasca-lt-13-gas-dim-cm-40x70x85h-potenza-termica-102-kw.html
- 13 L on closed cabinet, **11 kW** — https://www.gastrodomus.it/p/2816-friggitrice-gas-1-vasca-capacita-lt-13-armadio-chiuso.html
- 13 L, 700-deep, **12 kW** — https://sagie.it/prodotti/2633-friggitrice-gas-capacita-13-lt-profondita-700-12-kw.html

Anything outside roughly 8-14 kW for this machine should be treated as a transcription error
(the "350 °C oven at 800 W" failure mode). **These are peer products, not this product — they
must not be copied into the record.**

---

## 6. Other observations

- **`technical_specification` is the literal string `"<p>null</p>"`** — not empty, not absent.
  It renders as the word "null" on the storefront. This came straight through from Sheffield's
  master CSV, which stores `"<p>null</p>"` in that column for this row. Worth a catalogue-wide
  grep; this SKU is unlikely to be the only one.
- **The stored product photo is almost certainly not a Lincarinox machine.** Every genuine
  Lincarinox render (§8) has the house livery: **cobalt-blue control knobs, a blue door-handle
  strip and a LINCARINOX badge on the fascia**. The stored 224 × 224 image shows a plain
  stainless unit with a single small knob and no blue anywhere. Sheffield's CSV records its
  source filename as `uploads/1752051206_images.jpeg` — the giveaway filename of a saved
  search-results thumbnail. **Flagged: wrong-brand stock photo, and far below storefront
  quality at 224 px.**
- **Quantity 1, price KSh 308,525, and a manufacturer with no website since 2024** — this reads
  like end-of-line stock. Worth a commercial decision on whether the SKU should stay published,
  independent of the data fixes.
- The record has **no `meta_description`**, unlike the restructured Brema/Santos/Skymsen SKUs.
- Category **Fryers** is correct.

---

## 7. Product reference

| SKU | Catalogue name | Stored model | Manufacturer | Base code reading | Series | Official page | Confidence |
|---|---|---|---|---|---|---|---|
| IMG/HOT/00085 | Fryer Single 13 Litres Gas Lincar | `G1140VN` | **LincarInox by M.Emme Srl**, Viale Bruno Buozzi 7, 42046 Reggiolo (RE), Italy — P.IVA 02567460353 | `G1140` + unexplained `VN` suffix (§3.3) | **SERIE 900-800**, gas fryer, single tank, ½ module (inferred, §3.1) | none — domain dead; index at https://web.archive.org/web/20160614012547/http://www.lincarinox.com/categoria-prodotto/friggitrici-a-gas/ | **Brand: High. Model placement: Medium. Individual specs: Low-Medium** |

Supporting sources:

- https://web.archive.org/web/20160613215114/http://www.lincarinox.com/azienda-italiana-cucine-industriali-lincarinox/
- https://web.archive.org/web/20160614010143/http://www.lincarinox.com/categoria-prodotto/friggitrici-elettriche/
- https://web.archive.org/web/20160614010147/http://www.lincarinox.com/categoria-prodotto/frytop-a-gas/
- https://web.archive.org/web/20160614005705/http://www.lincarinox.com/categoria-prodotto/cuocipasta-a-gas/
- https://web.archive.org/web/20160614012541/http://www.lincarinox.com/categoria-prodotto/cuocipasta-elettrici/
- https://web.archive.org/web/20160614010126/http://www.lincarinox.com/categoria-prodotto/bagnomaria/
- https://web.archive.org/web/20160614010234/http://www.lincarinox.com/scarica-i-nostri-cataloghi/
- https://web.archive.org/web/20161130181403/http://www.lincarinox.com/wp-content/uploads/2015/12/schede/G0016.pdf
- https://web.archive.org/web/20160615153150/http://www.lincarinox.com/wp-content/uploads/2015/12/schede/G0120.pdf
- https://web.archive.org/web/20161130181409/http://www.lincarinox.com/wp-content/uploads/2015/12/schede/G1211.pdf
- https://www.forniturealberghiereonline.it/lincar-inox
- https://nomarsupply.com/brand/633-lincar-inox
- https://www.lincarstufe.com/en/about-us/

**What was tried and failed to produce a G1140 source:** Wayback CDX sweep of the entire
`lincarinox.com` domain (383 distinct captures, every one enumerated); all archived category
pages downloaded and parsed; the three surviving datasheet PDFs read; page 2 of the gas-fryer
category and the five series catalogue PDFs requested at every available timestamp (never
captured); the Joomla-era `/it/prodotti/` and `/en/products/` item pages (all 403); the
successor/parked domain (GoDaddy placeholder); direct DNS probes of six candidate company
domains (none resolve); spare-parts catalogue search on `nomarsupply.com` for "G1140" (no
results); `lfspareparts724.com` (403 to both WebFetch and curl). General web search was
exhausted mid-pass and every alternative engine reachable by `curl`/WebFetch returned CAPTCHA
or empty results, so **a surviving third-party listing for G1140 has not been ruled out**.

---

## 8. Image sourcing (July 2026) — `products resource/lincar-memme-images/`

**No photograph of G1140 exists in any source reachable in this pass.** The Lincarinox
catalogue did carry a render per model (the gas-fryer category page still references
`G1100-1084x550.jpg` … `G1122-1084x550.jpg` in its HTML), but **none of the fryer image files
was ever archived** — every request returns the Wayback "not archived" page. The same is true
of the Safari fryer renders `G0841`-`G0844.jpg`.

> **Extended 27 July 2026.** The folder now holds **9 files**, not 5: two more `REF__`
> chargrill renders, LINCAR's own 76-page fryer manual, and a 2334 × 3306 G1140 dimensional
> drawing rendered from it. The manual carries a **hard contradiction of the stored tank
> size** — read **§8.1** before using anything in this section. §8.2 records where the
> archive was re-probed and what is now formally exhausted.

What follows is therefore a **reference set only** — the original five files carry the `REF__` prefix
because **none of them is this product**. They exist to document the manufacturer's real house
styling, so that whoever sources a photo can tell a genuine Lincarinox unit from a stock image.
Two were pulled from the archived site at full size; three were extracted losslessly from the
datasheet PDFs with `pypdf` (the Comenda technique), which beat every web copy available.

| File | Actual size | Bytes | What it is | Source |
|---|---|---|---|---|
| `IMG-HOT-00085__REF__lincarinox-serie-900-800-G0234-gas-range.jpg` | **1084 × 550** | 39 KB | **SERIE 900-800** 4-burner gas range with oven — the same series as G1140. Shows the blue knobs, blue door-handle strip and LINCARINOX badge. | https://web.archive.org/web/20160614012547/http://www.lincarinox.com/wp-content/uploads/2016/01/G0234-1084x550.jpg |
| `IMG-HOT-00085__REF__lincarinox-serie-700-G1200-gas-pasta-cooker.jpg` | **1084 × 550** | 24 KB | **Closest body analogue found**: a ½-module (400 mm) gas unit on a closed cabinet, single blue knob — structurally what a G1140 fryer looks like, with a pasta tank instead of an oil tank. | https://web.archive.org/web/20160614012547/http://www.lincarinox.com/wp-content/uploads/2016/01/G1200-1084x550.jpg |
| `IMG-HOT-00085__REF__lincarinox-serie-700-G1211-pasta-cooker-render.jpg` | **783 × 810** | 31 KB | Full-module unit on twin cabinets; sharpest view of the fascia, badge and handle detail. | Extracted from https://web.archive.org/web/20161130181409/http://www.lincarinox.com/wp-content/uploads/2015/12/schede/G1211.pdf |
| `IMG-HOT-00085__REF__lincarinox-serie-700-G0120-half-module-on-cabinet.jpg` | 573 × 870 | 23 KB | ½-module (400 mm) unit on an **open** cabinet — useful for the §3.3 "vano" question. Below the 800 px bar on the short edge; reference only. | Extracted from https://web.archive.org/web/20160615153150/http://www.lincarinox.com/wp-content/uploads/2015/12/schede/G0120.pdf |
| `IMG-HOT-00085__REF__lincarinox-serie-700-G0016-solid-top-open-cabinet.jpg` | 744 × 792 | 25 KB | Gas unit on an open cabinet; the sheet this came from is the source of the NG/LPG statement in §5.2. Marginally under 800 px; reference only. | Extracted from https://web.archive.org/web/20161130181403/http://www.lincarinox.com/wp-content/uploads/2015/12/schede/G0016.pdf |

**Every file above was opened and visually verified.** All five show the LINCARINOX badge and
the blue-knob/blue-handle livery, confirming they are genuine brand renders. Gas and electric
variants of these bodies are visually near-identical, which is precisely why none of them may
be substituted for the fryer.

Also available but **deliberately not kept**: the **LINCARINOX PROFESSIONAL KITCHENS** logo,
embedded as `R11.jpg` on page 1 of all three datasheet PDFs at **397 × 198**. It is a logo, so
it does not belong in the product-image folder — but it is the correct replacement for the
Sheffield placeholder currently sitting in `brands/lincar-memme.png` (§1.3), and it can be
re-extracted from any of the three PDFs above in one `pypdf` call.

**Nothing has been copied into `storage/app/public/products/`** and no image field in
`products.json` has been touched.

### 8.1 🚩 The official LINCAR manual was found — and it contradicts the stored tank size

The single most valuable thing to come out of the 27 July 2026 pass is not an image. It is
**LINCAR S.p.A.'s own installation, use and maintenance manual**, staged as
`IMG-HOT-00085__manual-lincar-gas-fryers-G1100-G1142.pdf` (76 pp, 1,140,873 B).

Its cover reads, verbatim:

> *Manuale per l'installazione, l'uso e la manutenzione* — **Friggitrici su mobile a gas per
> uso professionale** — **Serie 700, 900, 900-8** — Mod. **G1100, G1101, G1102, G1103, G1104,
> G1120, G1121, G1122, G1140, G1141, G1142** — LINCAR S.p.A. Reggiolo Italy —
> Cod. 90000310 Rev. 3

This settles several things §3 could only infer:

- **`G1140` is a real, published LINCAR model code** — no longer "confirmed by pattern, not
  by sighting" (§3.1). It is printed on the cover of the manufacturer's own manual.
- **It is a gas fryer on a cabinet** (*friggitrice su mobile a gas*), professional use,
  which is exactly what the record describes.
- **It belongs to Serie 900-8**, not Serie 700 — relevant to §3.2.
- **LINCAR S.p.A. of Reggiolo is the legal entity**, i.e. the same corporate name as the
  still-trading heating company §1.1 warns about. They are the same company, different
  divisions. That does **not** licence using `lincarstufe.com` product imagery — the wood
  stoves are a different product line entirely — but it does explain the name collision.

🚩 **Sourced-vs-stored contradiction — the tank is 17 litres, not 13.**
Page 8 of the manual is the dimensional-drawing sheet for the three 900-8 fryers, and it
labels them unambiguously:

| Manual, p.8 | Model | Tank |
|---|---|---|
| *Friggitrice gas 1 vasca 17 l. Serie 900-8* | **G1140** | **1 × 17 L** |
| *Friggitrice gas 2 vasca 8+8 l. Serie 900-8* | G1141 | 2 × 8 L |
| *Friggitrice gas 2 vasche 17+17 l. Serie 900-8* | G1142 | 2 × 17 L |

**The record stores 13 litres** (§4.2, where it was assessed as "consistent with the maker,
but not verified for this code"). The manufacturer's own manual says **17 L** for `G1140`.
Note also that the sibling `G1141` is the *8+8* model — so **13 L matches no member of this
family**, which makes a transcription error the likeliest explanation rather than a variant.

⚠ Per [[feedback_model_number_unique_id]] and the standing "research, don't apply" rule,
**nothing has been changed in `products.json`.** But this now belongs at the top of §9's
priority list: it is a hard, manufacturer-sourced correction to a published spec, and the
`VN` suffix (§3.3) is the only remaining reason it might not apply.

The manual also fills several §4.5 gaps for `G1140`, straight off the same drawing:
**900 mm deep × 400 mm wide × 870 mm to the worktop** (+188 mm upstand, 720 mm cabinet,
150 mm legs), and **one gas inlet, R1/2" ISO R7 / DIN2999 / ISO R228**. The cover's gas
category marking is **`II2H3+`** for IT/CH — i.e. natural gas H **and** butane/propane,
which corroborates §5.2's NG-with-LPG-kit reading directly rather than by analogy.

### 8.2 Still no photograph of a G1140 — and the archive is now exhausted

The dimensional sheet above was staged as
`IMG-HOT-00085__G1140-official-dimensional-drawing-2334x3306.png` (**2334 × 3306**,
429,153 B), rendered from the manual's vector page art. It is far and away the highest-
resolution asset in this brand's folder — **but it is a line drawing, not a product photo**,
and cannot serve as a storefront image.

Two more brand-styling references were added, both genuine LINCARINOX renders with the blue
knobs and blue handle strip, both `REF__` because neither is a fryer:

| File | Pixels | Size | What it is |
|---|---|---|---|
| `IMG-HOT-00085__REF__lincarinox-GPC03-gas-chargrill-closed-cabinet-1084.jpg` | 1084 × 550 | 32,532 B | Gas chargrill on a **closed** cabinet — best available analogue for the G1140's cabinet, doors and leg detail |
| `IMG-HOT-00085__REF__lincarinox-G0611-gas-chargrill-open-cabinet-1084.jpg` | 1084 × 550 | 40,018 B | Same body on an **open** cabinet |

**The `lincarinox.com` Wayback archive is now formally exhausted.** The full CDX index was
pulled and enumerated — **380 captured URLs in total, 45 of them JPEGs**:

- **Not one URL matches `G11`, `fryer` or `friggi`.** The gas-fryer category page references
  `G1100-1084x550.jpg` … `G1122-1084x550.jpg` in its HTML, but **none of those files was ever
  crawled.** The only product renders that survive are `G0234`, `G0611`, `G1200` and `GPC03`
  — all four already staged.
- **Only three datasheet PDFs were ever archived** — `schede/G0016.pdf`, `schede/G0120.pdf`,
  `schede/G1211.pdf`. All three already mined. There is no `schede/G1140.pdf` capture.

Search engines were unavailable during this pass (WebSearch quota exhausted;
`lite.duckduckgo.com` returned HTTP 202 anti-bot, Mojeek returned nothing, every reachable
public SearxNG instance returned 429 or a browser-verification interstitial, and the Bing RSS
endpoint returned unrelated junk for control queries and so was discarded as unreliable).
**Italian and EU dealer listings therefore remain genuinely un-probed** — this is "not found
by direct-host means", not "proven not to exist". A future pass with working search should
try Italian catering dealers and used-equipment marketplaces (Exapro, Machineseeker, Surplex,
Subito) for `G1140` before concluding anything.

**Current status of `IMG/HOT/00085`: no publishable product photograph.** All seven image
files in the folder are `REF__` brand-styling references; the only non-`REF__` image is a
dimensional drawing. The realistic fix is a supplier photo — but the manual in §8.1 means the
*record* can now be made substantially more accurate regardless.

## 9. Recommended changes — priority order, none applied

### `products.json` — `IMG/HOT/00085`

1. **Add the gas rating.** ⚠ Highest priority, and the one item that needs a **supplier or
   rating-plate check** rather than a web lookup: nominal **kW**, plus max consumption for
   **G20 / G30 / G31**. State the figure once; do not convert between m³/h and kg/h (§5.3).
   Plausible band for review is 10-12 kW (§5.4) — **do not write a peer product's number in**.
2. **State the gas family explicitly in the description.** Lincarinox ships **set for natural
   gas (G20)** with an **LPG nozzle kit in the box**, LPG pre-conversion on request (§5.2).
   For a Kenyan LPG installation this must be said on the page.
3. **Replace `technical_specification`.** It is currently the literal string `"<p>null</p>"`,
   which renders the word "null" to customers. Either drop the field or rebuild it as the
   standard prose + `<h3>Key Features</h3>` + `<table>` pattern used in the Brema/Skymsen passes.
4. **Confirm 13 L vs 17 L before any rewrite** (§4.2). Every *900-series* single-tank Lincarinox
   fryer visible in the archive is 17 L; 13 L is a 700-series size. If the unit in the warehouse
   is 17 L, the `name`, `short_description` and `description` are all wrong. **A tape measure on
   the tank (240 × 345 mm ⇒ 13 L) settles it in one minute.**
5. **Add `length` / `width` / `height`** — but only once measured or confirmed. The series
   reading gives **400 × 900 × 850 mm** (§4.4); label it as inferred or leave the fields empty
   rather than publishing a guess. Note the fields are currently *absent*, so there is no
   axis-swap bug on this SKU (verified, §4.4).
6. **Add** `weight`, series designation **SERIE 900-800**, gas connection **½" ISO 7-1**,
   **CE marking**, AISI 304 Scotch Brite construction, thermocouple safety valve with protected
   pilot, piezoelectric ignition, height-adjustable stainless feet, head-to-head module junction
   — all documented on the Lincarinox gas datasheets (§4.5), **once a G1140 sheet is obtained**.
   Do **not** add cool zone / safety thermostat / drain tap / temperature range on assumption;
   none is confirmed for this model.
7. **Add a `meta_description`**, and update `short_description` if the brand is renamed (it
   currently reads "by Lincar Memme").
8. **Replace the product image.** The stored 224 × 224 file is a search-results thumbnail of a
   unit that does not carry Lincarinox livery (§6). Nothing in §8 may be substituted for it —
   a supplier photo or a photo of the actual unit in the warehouse is the only clean fix.
9. **Do not change `model_number`.** `G1140VN` stays until the `VN` question is answered by the
   supplier (§3.3).

### `brands.json` — `lincar-memme`

1. **`name`: "Lincar Memme" → "Lincarinox"** (the manufacturer's own brand name; "Lincar Inox"
   is the form used by the trade catalogues). Keep the `lincar-memme` slug or add a redirect —
   the slug is referenced by the product's `brand` string `LINCAR MEMME`, so any rename must be
   applied to `products.json` in the same edit.
2. **`description`: "LINCAR MEMME" → real copy**, e.g. *"LincarInox — professional cooking
   equipment by M.Emme Srl of Reggiolo, Reggio Emilia, Italy. The catering division of Italian
   heating manufacturer Lincar S.p.A., established 2004 and spun out as its own company in
   2013, building modular Serie 700, 900-800, 900-900, 1100 and Safari cooking lines."*
3. **`website_url`: leave `null`.** `lincarinox.com` no longer resolves and there is no
   successor site (§1.2). **Do not use `lincarstufe.com`** — that is the separate, still-trading
   wood-stove company (§1.1).
4. **`logo`: replace `brands/lincar-memme.png`** — it is currently Sheffield's own flame logo,
   not a Lincarinox logo (§1.3). The real wordmark is extractable from the archived datasheets
   at 397 × 198.

### Open questions for the supplier

- Is the tank **13 L or 17 L**?
- What does the **`VN`** suffix mean, and is it needed to reorder?
- What is the **burner rating in kW**, and was the unit shipped **NG or LPG-converted**?
- Is **M.Emme Srl still trading**, given the website has been gone since 2024?
