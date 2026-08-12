# G.Paniz Product Research

Research notes behind a G PANIZ enrichment/audit pass on `products.json` (July 2026).
Covers the brand's single SKU in the catalogue: **IMG/OVE/00213 — "Gas Convection Oven
FTG 480"**, category `Ovens`, `status: published`.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same as the Brema/Santos passes. That deliberately includes the name/`model_number`
mismatch, which is a `model_number` correction and therefore needs approval before it is
applied (see `feedback_model_number_unique_id`).

**Headline finding:** the record is an amalgam of two different ovens. The `name` says
**FTG 480** (gas), the `model_number` says **FTE 480** (electric), and the entire
`description` body is copied from the **FTE-480 380 V three-phase electric** datasheet.
The correct code is **FTG 480**, and fixing the code alone is not enough — the electrical
specs have to be replaced too. Details in §3 and §4.

---

## 1. Brand identification

**G.Paniz** = **G.Paniz Ind. de Equip. p/ Alim. LTDA**, a Brazilian manufacturer of bakery,
confectionery, butchery and foodservice equipment. The company runs two brands off one
site — **G.Paniz** (premium line) and **Gastromaq** (value line) — both catalogued under
`gpaniz.com.br/produtos/`. Brazilian freephone support 0800-704-2366.

`brands.json` currently has:

```
slug: g-paniz | name: "G Paniz" | website_url: https://www.gpaniz.com.br
```

The `www.` host **301-redirects** to `https://gpaniz.com.br/` — it is a working URL, not a
broken one, same situation as Brema's `bremaice.it`. **No `brands.json` change needed.**

Product pages live at `https://gpaniz.com.br/produto/<model-slug>/`, e.g.
https://gpaniz.com.br/produto/ftg-480/

### Where to look

| Resource | URL | Value |
|---|---|---|
| Official product page (gas) | https://gpaniz.com.br/produto/ftg-480/ | Marketing spec block — 11 labelled icon fields |
| Official product page (electric, 380 V) | https://gpaniz.com.br/produto/fte-480-380v-trifasico/ | Needed to prove where our description came from |
| Official product page (electric, 220 V) | https://gpaniz.com.br/produto/fte-480-220v-trifasico/ | Sibling variant |
| Gas range index | https://gpaniz.com.br/produtos/gpaniz/panificacao/forno-turbo-a-gas/ | Confirms the full FTG family |
| Electric range index | https://gpaniz.com.br/produtos/gpaniz/panificacao/forno-turbo-eletrico/ | Confirms the full FTE family |
| Launch announcement (both models, 29 Jul 2019) | https://gpaniz.com.br/blog/2019/07/29/lancamento-g-paniz-forno-turbo-fte-480-ftg-480/ | States plainly that FTE = electric, FTG = gas, same body |
| **Official instruction manual, FTG-480, rev. R.3/2026 (gold standard)** | https://gpaniz.com.br/download/manuais/?Arquivo=087e3cbfabdb3e43faca7533b7695a59%2Epdf | 24 pages. **Labelled** technical-data table on p.10 — the only source that names each dimension axis. Also the sole source for gas type, gas pressure, breaker and cable sizing |

### Traps

1. **The manual PDF is served from an ASP query-string endpoint**, not a static `.pdf`
   path — `?Arquivo=<hash>%2Epdf`. It downloads fine via `curl` with a referer, and the
   hashes are only discoverable in the page HTML (they sit behind a Bootstrap modal, so
   `WebFetch` never surfaces them). Four revisions are listed (R.0/2019 → R.3/2026);
   R.3/2026 is current.
2. **The website's dimension strings are unlabelled** (`2.200x1.125x1.560mm`). Only the
   manual names the axes. See §5 — do not guess the order.
3. **G.Paniz's own gas product page shows the *electric* oven's photos.** This is the
   likely root cause of our data bug. See §3.
4. **The website spec block and the manual's spec table disagree** on two figures
   (gas consumption, electrical power). See §4.

---

## 2. Both codes are real — FTG and FTE are a matched pair, not a typo of each other

There is no ambiguity about whether "FTG 480" or "FTE 480" exists: **both do**, they were
launched together on 29 July 2019, and they are the gas and electric versions of the same
oven body.

| Code | Expansion | Heat source | Official page |
|---|---|---|---|
| **FTG-480** | **F**orno **T**urbo a **G**ás | Gas burner (GLP or GN) | https://gpaniz.com.br/produto/ftg-480/ |
| **FTE-480** | **F**orno **T**urbo **E**létrico | Electric elements | https://gpaniz.com.br/produto/fte-480-380v-trifasico/ and https://gpaniz.com.br/produto/fte-480-220v-trifasico/ |

The FTG family runs FTG-100 / 150 / 240 / 300 / 480 / 1500 / 2400 / 3000; the FTE family
mirrors it. So the suffix convention the task assumed is correct and is confirmed by
G.Paniz's own naming — **G = gás, E = elétrico** — and the FTG-480 manual's own title page
reads *"Manual de Instrução — Forno Turbo a Gás FTG-480"*.

---

## 3. The mismatch on IMG/OVE/00213 — resolved in favour of FTG 480 ⚠

### 3.1 What the record currently holds

| Field | Stored value | Which oven does it point to? |
|---|---|---|
| `name` | "Gas Convection Oven FTG 480" | **Gas** |
| `model_number` | "FTE 480" | **Electric** |
| `category` | Ovens | neutral |
| `image` | `products/gas-convection-oven-ftg-480-imgove00213.jpeg` | **Gas** (by filename) |
| `short_description` | "Industrial **gas** convection oven by Gpaniz…" | **Gas** |
| `description` — "Required power: 32.1 kW \| Consumption: 22.5 kWh" | | **Electric only** |
| `description` — "Power supply: 380V 3-phase" | | **Electric, 380 V variant only** |
| `description` — everything else (250 °C, 95 mm tray pitch, cart sizes, 150 mm rock wool, dual turbines, silicone-on-glass seal, epoxy/brushed-stainless finish, 2 × 3/4 motors, 480 × 50 g breads) | | **Neutral** — identical on both pages |

The two electrical bullets are not approximately electric, they are a **verbatim match for
the FTE-480 380 V trifásico page**: 32,1 Kw / 22,5 Kwh / T380V (trifásica). Nothing on the
FTG-480 page resembles them — the gas oven draws **1.5–2.0 kW single-phase at 127/220 V**.

### 3.2 Verdict: `model_number` should be **FTG 480**

Four of the five identifying signals (name, image filename, short_description, category
intent, and the KES 1,900,000 price point) say gas; only `model_number` says electric, and
the description body was pulled from the wrong datasheet. Recommendation:

- **`model_number`: `FTE 480` → `FTG 480`** (needs approval — `model_number` is the unique ID).
- **`name`**: already correct, leave as "Gas Convection Oven FTG 480".
- **`description`**: the two electrical bullets must be **replaced**, not kept. Correcting
  the code while leaving "32.1 kW / 380 V 3-phase" in the body would produce a listing that
  is *more* wrong than today — a Kenyan buyer would size a 3-phase supply for an appliance
  that only needs a 20 A single-phase socket. See §4 for the replacement figures.

**Counter-case, for completeness:** if the supplier is in fact importing the electric oven,
the correct fix is the mirror image — rename to "Electric Convection Oven FTE 480", drop
"gas" from `short_description`, and keep the existing electrical bullets (they are already
right for the 380 V variant). That would mean the name, image filename and short_description
are all wrong and only `model_number` is right, which is the less likely of the two. **Worth
one confirmation with whoever sourced the unit before applying either change**, because the
two ovens are not interchangeable on site: the gas model needs a gas line and a 20 A
single-phase socket, the electric model needs a 380 V three-phase feed at ~48 A.

### 3.3 Root cause — G.Paniz's own gas page carries FTE-badged photos

This is almost certainly how the bad code got in. Both product photos on
https://gpaniz.com.br/produto/ftg-480/ are the **electric** oven's renders: the red
*testeira* (header panel) above the door reads **"Forno Turbo — FTE 480"**. The gas and
electric pages serve near-identical image files (same renders, differing by a few bytes).

Resellers propagate it unchanged — https://www.lojasebem.com.br/forno-de-padaria-turbo-a-gas-16-esteiras-gpaniz-ftg-480/
lists the gas oven under an FTE-480-badged photo too. **No FTG-badged photograph of this
oven appears to exist in circulation.**

Our own stored `gas-convection-oven-ftg-480-imgove00213.jpeg` is that same render (a 16 KB,
~207 × 233 px crop of it). So whoever built this record was looking at a photo with
"FTE 480" printed on it while typing the `model_number` field. The mismatch is inherited
from the manufacturer's own content error, not invented locally.

Practical consequence: **any product photo we publish for this SKU will visibly say
"FTE 480" on the oven**, which is awkward given we are recommending the code be changed to
FTG 480. The two ovens are cosmetically identical apart from the badge, so there is no
better image available. Flagging it rather than solving it.

---

## 4. Confirmed FTG-480 specification

Two official sources; where they disagree both are given.

| Spec | Official product page | Official manual R.3/2026, p.10 | Notes |
|---|---|---|---|
| Tray capacity | 16 esteiras | 16 | Up to **26** with the optional Kit Biscoito (gas version only) |
| Bread output | 480 pães 50 g | — | ~480 × 50 g French rolls per bake |
| Max temperature | 250 °C | — | Electronically limited; recommended bread bake **160–180 °C** (manual p.9/p.14) |
| Tray pitch | 95 mm between tray holders | — | |
| **Gas consumption** | **2,0 kg/h** | **1,8 kg/h** | ⚠ sources disagree — see below |
| Gas type | (not stated) | **GLP (LPG)**, GN (natural gas) variant available | Manual p.7–8 |
| GLP pressure at appliance | — | **13,2 kPa** | |
| Gas supply requirement | — | 1,0–1,5 kgf/cm² first stage, 5 kg/h flow (NBR 15526) | 2 × P13 cylinders used **simultaneously**, or P45 with specialist install |
| **Electrical power** | **1,5 kW/h** | **2,0 kW/h** | ⚠ sources disagree |
| Voltage | 127 **or** 220 V, **single-phase** | 127/220 V, monofásico | On-unit voltage selector switch (manual p.13, step 2) |
| Frequency | — | 50/60 Hz | |
| Nominal current | — | **10 A** | |
| Breaker / socket / cord | — | **C20** breaker, 20 A socket (NBR 6147), 3 × 2,5 mm² cord | |
| Motors | 2 × 3/4 Cv | — | Two turbines |
| **External dimensions** | 2.200 × 1.125 × 1.560 mm | **Altura 2200 / Largura 1126 / Profundidade 1555 mm** | Manual labels the axes — see §5 |
| **Internal chamber** | 1.680 × 725 × 1.060 mm | — | H × W × D, confirmed by volume arithmetic — see §5 |
| Chamber volume | 1.251 L | — | |
| **Weight** | **360 kg** | — | Electric FTE-480 is 350 kg |
| Insulation | Compacted rock wool **150 mm** | — | Page copy says it "demands lower **gas** consumption" (the FTE page says "lower **energy** consumption") — a small but genuine gas/electric tell |
| Cart sizes available | 60×80, 58×70, 45×65, 40×60 cm | 40×60, 45×65, 58×70, 60×80 cm | One mobile cart per oven, ordered in a chosen size |

### The two disagreements

- **Gas consumption 2,0 vs 1,8 kg/h** and **electrical power 1,5 vs 2,0 kW.** The manual
  (R.3/2026) is the newer and more formal document and is the one that carries a full
  labelled table; the website spec block reads like older marketing copy. **Recommend the
  manual's figures (1,8 kg/h gas, 2,0 kW electric)** and cite both if precision matters.
  Neither difference is material to a buyer.

### No BTU/kcal rating is published

G.Paniz publishes gas **consumption**, not burner **thermal output**. Any BTU figure is a
derivation, not a manufacturer number:

- at 1,8 kg/h LPG ≈ 23 kW ≈ **~78,600 BTU/h**
- at 2,0 kg/h LPG ≈ 25.6 kW ≈ **~87,400 BTU/h**

(using ~12.8 kWh per kg LPG). **Do not publish these as if they were manufacturer specs** —
if a BTU figure is needed for the storefront, mark it as approximate.

### Materials of construction (manual p.9, "Características Técnicas")

Door and frame **stainless steel**; sides **steel with white epoxy paint**; roof and rear
**galvanised sheet**; internal chamber **1020 steel with high-temperature coating**; tray
supports **stainless**. The manual states explicitly: *"O equipamento é produzido
parcialmente em aço inoxidável"* — **partially** stainless.

⚠ Our stored description currently claims *"External finish: epoxy paint with brushed
stainless steel **or full stainless steel front**"*. The "full stainless" option is not
offered on the 480 in any official source and contradicts the manual's "partially
stainless" statement. **Recommend dropping that clause.**

### Compliance and installation requirements — all missing from our record

- **IEC 60335-1** and **IEC 60335-2-42** (mechanical and electrical safety).
- **Requires a water connection** for the steam system — 8 to 20 mca, fed from a tank not
  directly off the mains (pressure must be constant). Not mentioned anywhere in our listing.
- **Requires an extraction hood** rated ≥ 36 m³/h (NBR 13103/1994).
- Install on a level surface, **≥ 50 cm clearance all round**, ambient **5–25 °C**,
  well-ventilated area, earthed supply mandatory.

### Kenya relevance

- **LPG is the standard commercial gas in Kenya**, so the GLP variant is the right one —
  worth stating on the listing which gas the imported unit is configured for, since GLP and
  GN units differ in injectors.
- The gas model runs on **single-phase 220 V / 20 A**, well within a normal Kenyan 240 V
  50 Hz supply and selectable on the unit. This is a real commercial advantage over the
  electric FTE-480, which needs a **380 V three-phase feed at 47.8 A** — and is exactly the
  claim our current (wrong) description is making. Another reason the electrical bullets
  must not survive the code fix.

---

## 5. Dimension axis order — resolved, and no swap bug here

The catalogue has a documented recurring bug where stored `width`/`height` are transposed
(see the Santos and Brema passes). **This SKU cannot have that bug, because it stores no
dimension fields at all** — the record has only `sku`, `name`, `brand`, `model_number`,
`category`, `price`, `quantity`, `image`, `short_description`, `description`, `status`. No
`length`/`width`/`height`, no weight, no `technical_specification`, no `meta_description`.

So the dimensions are an *addition*, and the axis order needed pinning down. The website
prints an unlabelled `2.200x1.125x1.560mm`; the manual's p.10 table labels each row:

```
Altura        2200mm     → height
Largura       1126mm     → width
Profundidade  1555mm     → depth
```

**The website string is Height × Width × Depth.** Mapping to our schema (`length` = depth):

| Our field | Value |
|---|---|
| `length` (depth) | **1555 mm** |
| `width` | **1126 mm** |
| `height` | **2200 mm** |

The same H × W × D order applies to the internal-chamber string `1.680 × 725 × 1.060`, and
this is **independently confirmed by arithmetic**: 1.680 × 0.725 × 1.060 m = 1.291 m³ =
1291 L against the published chamber volume of **1.251 L** — a ~3 % match. No other axis
permutation is needed to make that work, and a 60 × 80 cm tray (600 mm across × 800 mm deep)
fits a 725 mm-wide × 1060 mm-deep chamber correctly. So: chamber **H 1680 × W 725 × D 1060 mm**.

For contrast, the electric FTE-480 has the **same external envelope** (2200 × 1125 × 1560)
but a **smaller chamber** (1.650 × 680 × 900 mm ≈ 1010 L) and weighs 350 kg vs the gas
model's 360 kg. Chamber size and weight are therefore the only *physical* discriminators
between the two — useful if the unit can be measured on site to settle §3.2 definitively.

---

## 6. Content gaps in the current record

Beyond the model-code issue, IMG/OVE/00213 is thin. Missing entirely:

- All three dimension fields, and weight (§5 supplies them).
- `technical_specification` and `meta_description` — every restructured brand in this
  catalogue now carries both (Skymsen pattern: prose + `<h3>Key Features</h3>` + HTML table).
- **Optional Kit Biscoito** — gas-version-only accessory that raises capacity from 16 to
  **26 trays** and adds turbine speed control for lighter biscuits. A genuine selling point,
  and a gas-exclusive one.
- Digital controller with programmable temperature, bake timer, **programmable steam
  injection**, audible end-of-bake alarm, recipe memory, and gas-failure / thermocouple /
  flame-sensor alarms.
- Flame supervision (flame sensor + spark igniter, 3-attempt ignition lockout).
- Front-access burner drawer for servicing — a stated FTG-only maintenance feature.
- Castors plus levelling feet; roller-bearing handle; interlocked door that stops the
  turbine when opened.
- Water connection and extraction-hood requirements (§4) — buyers need these before install.

---

## 7. Product reference

| SKU | Catalogue name | Stored model | **Correct model** | Official page | Manual | Confidence |
|---|---|---|---|---|---|---|
| IMG/OVE/00213 | Gas Convection Oven FTG 480 | `FTE 480` ⚠ | **FTG 480** | https://gpaniz.com.br/produto/ftg-480/ | https://gpaniz.com.br/download/manuais/?Arquivo=087e3cbfabdb3e43faca7533b7695a59%2Epdf | **High** — official page + official manual agree on identity; two minor numeric disagreements between them (§4) |

Independent corroboration of the FTG-480 gas specs:
https://www.lojasebem.com.br/forno-de-padaria-turbo-a-gas-16-esteiras-gpaniz-ftg-480/
https://www.ultrafeu.com.br/forno-turbo-gas-ftg-480-g-paniz-16-esteiras-carrinho-60x80/p
https://www.atau.com.br/forno-turbo-a-gas-ftg480-220-gpaniz/p

FTE-480 (electric) pages, cited as the *source* of our contaminated description, not as
specs to use:
https://gpaniz.com.br/produto/fte-480-380v-trifasico/
https://gpaniz.com.br/produto/fte-480-220v-trifasico/

---

## 8. Recommended changes — for approval, none applied

1. **`model_number`: `FTE 480` → `FTG 480`.** Requires approval (unique ID). Ideally
   confirm with the supplier first (§3.2) — the physical discriminators are chamber size
   and weight (§5).
2. **Replace the two electric bullets** in `description`:
   - remove "Required power: 32.1 kW | Consumption: 22.5 kWh"
   - remove "Power supply: 380V 3-phase"
   - add: gas consumption 1,8 kg/h GLP at 13,2 kPa; electrical 2,0 kW, 127/220 V
     single-phase 50/60 Hz, 10 A nominal, 20 A socket / C20 breaker.
3. **Drop the "or full stainless steel front"** claim (§4, materials).
4. **Add** `length` 1555, `width` 1126, `height` 2200 mm; weight 360 kg; chamber
   1680 × 725 × 1060 mm / 1251 L.
5. **Restructure** to the Skymsen pattern and add `meta_description`, per the other brand
   passes.
6. **Add** the missing content from §6 — Kit Biscoito, controller/steam programming, flame
   supervision, water + hood requirements.
7. **`brands.json`: no change.** The `www.gpaniz.com.br` URL 301s correctly to the live site.
8. **Replace the product image** — the stored file is a 16 KB, ~207 × 233 px crop. A
   912 × 1184 official render is staged in Downloads (§9). Note the badge caveat in §3.3.

---

## 9. Image sourcing (July 2026) — downloaded to `Downloads/g-paniz-images/`

Official renders pulled straight from the page HTML (`/_images/uploads/produtos/<hash>.jpg`)
via `curl` with a referer header; reseller angles from lojasebem. **6 files.**

| File | Source | Size | Notes |
|---|---|---|---|
| `IMG-OVE-00213__gpaniz-ftg480-page-loaded-cart.jpg` | https://gpaniz.com.br/_images/uploads/produtos/1e794f71f5e4fbb37a1c51a03b07760d.jpg (from the **gas** page) | 912 × 1184 | **Best candidate.** Door open, loaded cart of rolls. Badge reads "FTE 480" (§3.3) |
| `IMG-OVE-00213__gpaniz-ftg480-page-open-empty.jpg` | https://gpaniz.com.br/_images/uploads/produtos/049df015d381f8a7b4e901ecc357581c.jpg (from the **gas** page) | 720 × 1288 | Door open, empty chamber — shows the twin turbines and tray runners |
| `IMG-OVE-00213__gpaniz-fte480-page-loaded-cart.jpg` | https://gpaniz.com.br/_images/uploads/produtos/5b729fd4f92d5f914913da6d9c869c87.jpg (from the **electric** page) | 912 × 1184 | Near-identical duplicate of the gas-page file (3 bytes apart) — kept purely as evidence for §3.3 |
| `IMG-OVE-00213__gpaniz-fte480-page-open-empty.jpg` | https://gpaniz.com.br/_images/uploads/produtos/278b1cf588dbe788813b42cf68c77ed6.jpg (from the **electric** page) | 720 × 1288 | Same byte length as the gas-page file, different hash — same evidence |
| `IMG-OVE-00213__reseller-lojasebem-loaded-cart-1000.jpg` | https://www.lojasebem.com.br/img/products/forno-de-padaria-turbo-a-gas-16-esteiras-gpaniz-ftg-480_1_1200.jpg | 1000 × 1000 | Square crop, white background — closer to storefront card aspect. Also FTE-badged |
| `IMG-OVE-00213__reseller-lojasebem-open-empty-1000.jpg` | https://www.lojasebem.com.br/img/products/forno-de-padaria-turbo-a-gas-16-esteiras-gpaniz-ftg-480_2_1200.jpg | 1000 × 1000 | Square crop, door open |

Notes for whoever adopts these:

- **Every available image shows "FTE 480" on the oven's header panel.** There is no
  FTG-badged photo anywhere — G.Paniz reuses the electric render on the gas page and the
  resellers copy it (§3.3). Nothing to fix; just be aware before publishing.
- The lojasebem slots 3 and 4 were **"Sem foto" placeholders**, not product photos —
  downloaded, identified, and deleted.
- Not copied into `storage/app/public/products/` and not referenced in `products.json` —
  staged in Downloads for review first, same as the Brema and Santos sets.
- The current live image (`storage/app/public/products/gas-convection-oven-ftg-480-imgove00213.jpeg`,
  16 KB) is a low-resolution crop of the same render; any of the staged files is a
  significant upgrade.
