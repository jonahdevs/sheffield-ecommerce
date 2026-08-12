# Kusina Product Research

Research notes behind a KUSINA enrichment/audit pass on `products.json` (July 2026).
Covers the single KUSINA SKU: `IMG/HOT/00120` — 4 Burner Gas Range + Electric Oven,
`model_number` **G7K210G-E**.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema/Diqian/Santos files before a scope decision.

**Headline result: the brand is real and the product is fully verified from the
manufacturer's own spec sheet and catalogue.** This pass was expected to be a Diqian-style
house-brand dead end. It was not. "Kusina" is an Italian trade brand with a live website,
a downloadable 48-page catalogue and a per-model PDF *scheda tecnica* for our exact code.

**Correction to the brief:** the record was described as already having "a description and
spec, so this is an audit". It does **not**. `IMG/HOT/00120` currently has an empty
`short_description` and **no `description`, no `technical_specification`, no
`meta_description`, and no `length`/`width`/`height` fields at all** (see §5). This is a
build-from-scratch, not an audit. One consequence: the width/height axis-swap bug cannot be
present here, because there are no numeric dimension fields to swap.

---

## 1. Brand identification — KUSINA is real, and it is Italian

**Kusina is the professional catering-equipment brand of Giavazzi Srl**, Italy.

- **Giavazzi Srl**, via della Liberazione 71, 20068 Peschiera Borromeo (MI), Italy.
  P.IVA 00705470151. Tel +39 02 55305417. Email giavazzi@giavazzi.it.
- Brand site: https://www.kusina.it
- Parent/company site (catering division): https://www.giavazzi.it
- Official product page for our model:
  https://www.giavazzi.it/dispositivi-medici/cucina-a-gas-con-forno-g7k210ge/
  (the `dispositivi-medici` path segment is a CMS taxonomy artefact — Giavazzi also has a
  medical division — not an indication that this is medical equipment)
- Official per-model spec sheet PDF:
  https://www.giavazzi.it/wp-content/uploads/2025/02/G7K210GE.pdf
- Official 48-page KUSINA catalogue PDF:
  https://www.giavazzi.it/wp-content/uploads/2022/05/Giavazzi-catalogo-KUSINA.pdf

The KUSINA range is organised by depth series — **Serie 575, 600, 700 and 900**. Our unit is
**Serie 700** (730 mm deep). Retailers sell it under the marketing label **"ECO LINE –
Kusina by Giavazzi"**.

### 1.1 Is Giavazzi the manufacturer, or a rebadger?

Giavazzi is a long-established Italian catering-equipment company, and KUSINA is *its own*
brand — not a label applied to somebody else's goods by an importer, which is what "Diqian"
turned out to be. The one independent retailer that publishes a provenance field states
**"Fabbricazione: Europea"** (European manufacture) for this exact model
(https://www.ristoforniture.com/piani-di-cottura-fornelli/2455-cucina-4-fuochi-a-gas-con-forno-elettrico-kusina-g9k210ge-1.html).

Two caveats worth recording rather than over-claiming:

- Whether Giavazzi *fabricates* the 700-series ranges in-house or has them built to its
  specification by an Italian/European contract manufacturer is **not published anywhere**.
  It does not matter for the catalogue: the goods genuinely carry the KUSINA brand, so
  `website_url` can honestly point at the brand's own site.
- A German supplier, GGM Gastro, uses near-identical model codes for similar 600/700-series
  ranges (e.g. `G6K100G`, per https://manuals.plus/ggm-gastro/g6k100g-oven-4-burners-gas-stove-static-electric-oven-manual).
  That is suggestive of a shared platform or a shared code convention across the European
  700-series trade, but **it was not chased down and no shared-OEM claim should be made**.

### 1.2 `brands.json` verdict

Current entry (`slug: kusina`) has `website_url: null` and a generic filler description
("Kusina specializes in commercial kitchen equipment and supplies…") that matches nothing.

- **`website_url` should be set to `https://www.kusina.it`.** This is the brand's own site,
  not an OEM's — the Diqian objection does not apply here.
- The description can honestly be rewritten as: Kusina is the professional catering
  equipment brand of **Giavazzi Srl** of Peschiera Borromeo, Milan, Italy, covering modular
  cooking ranges in 575/600/700/900 mm series plus refrigeration, warewashing and ovens.

---

## 2. Model code decoded — and why `G7K210G-E` is the right spelling to keep

The code is systematic across the whole KUSINA line:

| Segment | Meaning |
|---|---|
| `G` | Giavazzi |
| `7` | **Serie 700** (730 mm deep, 900 mm high) |
| `K` | *Cucina* — cooking range |
| `2` | 800 mm width class (`1` = 400 mm, `2` = 800 mm, `01`/`11` = 1200 mm, `03`/`13` = 1600 mm) |
| `10` | with oven (`00` = open base with hinged door, `10` = with oven) |
| `G` | **G**as hob |
| `-E` / `E` | oven is **E**lectric (bare `G` = gas oven) |

**Giavazzi itself spells the model both ways.** Page 20 of the official KUSINA catalogue
prints the model-photo caption as **`G7K210G-E`** — our exact stored string — while the spec
table on the same page reads `G7K210GE`. The per-model PDF and the website both use
`G7K210GE`.

Per [[feedback_model_number_unique_id]], **leave `model_number` as `G7K210G-E`.** It is a
legitimate manufacturer spelling, it is the identity of the record, and it costs nothing.

### 2.1 The sibling family (context for §4 sanity checks)

| Model | Hob | Oven | Total kW | Weight | Dimensions W×D×H (mm) |
|---|---|---|---|---|---|
| G7K100G | 2 × 6.5 kW gas | none (open base) | 13 | 53 kg | 400 × 730 × 900 |
| G7K200G | 4 × 6.5 kW gas | none (open base) | 26 | 92 kg | 800 × 730 × 900 |
| **G7K210G-E (ours)** | **4 × 6.5 kW gas** | **6 kW electric** | **26 + 6** | **130 kg** | **800 × 730 × 900** |
| G7K210G | 4 × 6.5 kW gas | 6 kW **gas** | 32 | 143 kg | 800 × 730 × 900 |
| G7K210E | 4 hotplates (2×1.85 + 2×2.25 kW) | 6 kW electric | 14.2 | 126 kg | 800 × 730 × 900 |
| G7K211G | 6 × 6.5 kW gas | 6 kW gas | 45 | 203 kg | 1200 × 730 × 900 |
| G9K210GE | 4 × 8.5 kW gas | 6 kW electric | 34 + 6 | 144 kg | 800 × 900 × 900 (Serie 900) |

Source: KUSINA catalogue pp. 19–21, plus the per-model PDFs
https://www.giavazzi.it/wp-content/uploads/2025/02/G7K210G.pdf,
https://www.giavazzi.it/wp-content/uploads/2025/02/G7K210E.pdf,
https://www.giavazzi.it/wp-content/uploads/2025/02/G9K210GE.pdf

The family table is internally coherent and our model sits exactly where it should: same
cabinet as the gas-oven G7K210G, **13 kg lighter** (130 vs 143 kg) because the gas oven
burner/valve assembly is replaced by electric elements.

---

## 3. Confirmed specification for G7K210G-E

Everything below is from the manufacturer unless marked otherwise. Two sources agree
throughout: the official scheda tecnica PDF and the official catalogue (p. 20), with the
Ristoforniture retail spec table adding the detail Giavazzi omits.

| Field | Value | Source |
|---|---|---|
| Type | Freestanding gas range, 4 open burners, with **electric** oven under the hob | official |
| Series | KUSINA Serie 700 | official |
| **Burners** | **4 × 6.5 kW**, double-crown, nickel-plated cast iron | official PDF + catalogue + retailer |
| **Total gas rating** | **26 kW** (4 × 6.5) ≈ 88,700 BTU/hr | derived from official burner ratings |
| **Oven** | **6 kW electric**, GN 2/1, armoured stainless steel elements | official PDF + catalogue + retailer |
| "Potenza totale" as printed | **32 kW**, printed by Giavazzi as **"26+6"** | official — see §4.1 warning |
| **Gas supplied for** | **Natural gas (metano) injectors fitted from the factory** | retailer spec table |
| **LPG** | **LPG (GPL) nozzle-conversion kit supplied in the box** | retailer "Accessori in dotazione" |
| Gas connection | **R ½"** | official PDF + catalogue |
| Electrical supply | **not stated by Giavazzi for this model** — see §4.2 | — |
| Dimensions (W × D × H) | **800 × 730 × 900 mm** | official PDF + catalogue + retailer |
| Cooking-top surface | 800 × 630 mm | retailer |
| Oven capacity | **3 × GN 2/1 trays (650 × 530 mm)**, 3 rack levels | retailer |
| Net weight | **130 kg** | official PDF + catalogue + retailer |
| Packed volume | 0.84 m³ | official PDF + catalogue |
| Body | AISI 304 18/10 stainless worktop, control panel and visible exterior; AISI 430 elsewhere incl. combustion chambers and internal flues | official + retailer |
| Hob grates | Vitrified cast iron, scratch- and corrosion-resistant | official |
| Spill trays | Removable pressed stainless trays, 65 mm deep, dishwasher-safe | official + retailer |
| Ignition | **Manual**, with protected pilot flame | official + retailer |
| Oven chamber | Aluminium-lined, heavy-gauge enamelled steel base | official |
| Oven door | Double-wall stainless steel with stainless inner counter-door | official |
| Oven control | Thermostatic, with ON/OFF and at-temperature indicator lamps | official + retailer |
| Controls | Electromechanical | retailer |
| Legs | AISI 304 stainless, height-adjustable | official |
| Accessories in box | LPG nozzle kit, 1 oven grid, 3-level tray-support kit | retailer |
| Approvals | CE, EU compliant | retailer |

**Not published anywhere, do not invent:**

- **Oven thermostat temperature range.** The catalogue gives explicit ranges for other
  product families (90–190 °C for bains-marie, 100–300 °C for fry-tops) but gives **no
  range at all** for the 700-series range ovens — only "regolazione termostatica". Leave it
  out rather than borrowing a plausible number.
- **Gas consumption in kg/h or m³/h.** Not published. (Arithmetic only, **not a source, do
  not store in `products.json`:** 26 kW on G30/G31 LPG is roughly 2.0 kg/h.)
- **Gas supply pressure / gas category.** Not published for this model.
- **Oven internal chamber dimensions.** Only the GN 2/1 × 3-tray capacity is given.

---

## 4. The two things that actually matter for a Kenyan installation

### 4.1 ⚠ The "32 kW total" figure adds gas and electricity together — never quote it as a gas rating

Giavazzi's own catalogue prints our model's total as **"26+6"** and the per-model PDF prints
**"Potenza totale [kW] 32"**. Those 26 kW are **gas**; those 6 kW are **electric**. The
gas-oven sibling G7K210G *also* totals 32 kW, but in its case all 32 kW is gas.

Two identical-looking "32 kW" numbers, two completely different meanings. If the record ever
carries a bare "32 kW" against this SKU, an installer sizing a gas line or an LPG regulator
will over-size by 23%. **Store the two separately: gas 26 kW (4 × 6.5 kW), electric 6 kW.**

At least one retailer has already tripped on this. METRO and negoziobusiness both title the
listing **"Pot. 26+9 kW"** — a straight typo; every manufacturer source says 26+6.
(https://www.metro.it/marketplace/product/7ff8a12c-a2fa-459a-ab44-23754933f0b7,
https://www.negoziobusiness.com/product/cucina-a-gas-con-forno-elettrico-eco-line-kusina-by-giavazzi-g7k210ge-serie-700-4-fuochi-pot-26-9-kw-dim-80x73x90-cm-112467/)

**Physical plausibility check (the brief's §5 ask):** 6.5 kW per burner ≈ 22,200 BTU/hr,
26 kW ≈ 88,700 BTU/hr for the hob. That is squarely normal for a European 700-series
commercial range, and consistent with the neighbouring SKU in our own Burners category
(SHEFFIELD REDLINE RGR24, 30,000 BTU/hr per burner). A 6 kW element load for a 3-tray
GN 2/1 chamber is likewise normal. **No dropped-digit or implausible figure found anywhere
in this pass** — unlike the Diqian 800 W / 350 °C case.

### 4.2 ⚠ The unit is shipped set up for NATURAL GAS. Kenya runs LPG.

This is the single most consequential finding and it comes from the retailer spec table, not
from Giavazzi:

> **Caratteristica:** 4 fuochi su forno elettrico – **Allestimento kit ugelli per metano**
> **Alimentazione:** Gas Metano – GPL
> **Accessori in dotazione:** **Kit ugelli per GPL** – 1 griglia forno – Kit portateglie a 3 livelli

Translated: the range **leaves the factory with natural-gas (methane) injectors fitted**, and
an **LPG (GPL) injector kit is supplied loose in the carton**. Kenyan installations are
essentially always LPG, so **the injectors must be swapped and the burners re-regulated by a
competent gas fitter before commissioning.** A unit installed on LPG with the methane
injectors still fitted will run badly and unsafely.

Per the brief: **no LPG↔NG conversion has been applied to any figure here.** The 6.5 kW
nominal burner rating is the manufacturer's figure and is quoted as-is. Giavazzi does not
publish a separate LPG rating, injector sizes, or supply pressures, so none are stated.

This belongs in the customer-facing copy, not just in this file — it is a real installation
cost and a real safety point.

### 4.3 ⚠ Both a gas AND an electrical supply are required — and the electrical figure is the gap

The brief's §3 concern is correct and it is worse than expected: **Giavazzi's own scheda
tecnica for G7K210GE has no electrical row at all.** It lists `Ingresso gas R ½"` and stops.
The catalogue's gas-range tables likewise carry only an `alim. gas` column. The retailer
table lists `Alimentazione: Gas Metano - GPL` and no electrical entry either.

So for our exact model the supply voltage is **genuinely unpublished**. What *is* published:

- The **sibling G7K210E**, same 800 × 730 × 900 cabinet with the **same 6 kW GN 2/1 electric
  oven**, states **`Alimentazione elettrica 400 V 3N PE`** on both its scheda tecnica
  (https://www.giavazzi.it/wp-content/uploads/2025/02/G7K210E.pdf) and in the catalogue.
- **Every** electric model in the catalogue's Serie 700 table (G7K100E through G7K212E) is
  `400 V 3N PE`.

**Best available reading: the oven is a 400 V 3N~ 50 Hz appliance, requiring a three-phase
supply with neutral and earth.** Stated as a *strong inference from the family*, not as a
verified figure for this model. The alternative — 230 V single phase at ~26 A — cannot be
ruled out from published data.

**Kenya compatibility:** Kenya's mains is **240 V single phase / 415 V three phase, 50 Hz**.
A 400 V 3N~ 50 Hz European appliance is within tolerance on a Kenyan 415/240 V supply and
frequency matches, so no transformer is needed. But either way a 6 kW oven is **not a
13 A socket job** — it needs a dedicated circuit (≈26 A at 240 V single phase, or ≈9 A per
phase on three phase). Say so in the copy.

**This is question #1 for the supplier** (§8). Do not write a voltage into
`products.json` until it is confirmed against the unit's own rating plate.

---

## 5. What the record currently contains — and what it is missing

```json
{
  "sku": "IMG/HOT/00120",
  "name": "4 Burner Gas Range + Electric Oven Kusina",
  "brand": "KUSINA",
  "model_number": "G7K210G-E",
  "category": "Burners",
  "price": 461175,
  "quantity": 1,
  "image": "products/4-burner-gas-range-electric-oven-kusina-imghot00120.jpg",
  "short_description": "",
  "status": "published"
}
```

That is the entire record. It is **`status: published` with a completely empty content
payload** — empty `short_description`, no `description`, no `technical_specification`, no
`meta_description`, no dimensions. A live storefront page with nothing on it.

**No axis-swap bug is possible here** (the brief's §6 check): there are no `length`/`width`/
`height` fields at all. But the *convention* matters for filling them in — see §6.

### 5.1 The stored product image is not this product

`storage/app/public/products/4-burner-gas-range-electric-oven-kusina-imghot00120.jpg`
(27 KB, 600 × 600) shows a 4-burner range with an under-hob oven — right configuration — but
it is **not the Giavazzi unit**. Its hob is an open worktop with individual round pan
supports; the KUSINA 700 has full-width square vitrified cast-iron grate plates covering the
whole top, a visibly different front-panel and door pressing, and a different knob layout.
It reads as a generic stock render of some other manufacturer's 700-series range.

It is also low-resolution. Both problems are fixed by the verified 1000 px images in §7.

---

## 6. Which numeric field is which — resolved from the codebase, not assumed

Worth recording because the two prior passes disagreed. The storefront is unambiguous:

- `resources/views/pages/storefront/product.blade.php` (~line 818) builds the dimension
  string as **`width × length × height`**.
- `resources/views/pages/storefront/compare.blade.php` (~line 85) labels the row
  **"Dimensions (W × D × H)"** and fills it from `[$product->width, $product->depth ?? $product->length, $product->height]`.

Therefore: **`width` = front width (W), `length` = depth (D), `height` = height (H).**

For this SKU that means **`width: 800, length: 730, height: 900`**.

Cross-check against a sibling in the same category: the FAGOR CG6-40 record
(`IMG/HOT/00049`) stores `length: 650, width: 600, height: 290` for a unit that is
600 W × 650 D × 290 H — **correct** under this convention. (Note that the Brema pass
recorded the opposite reading; the code above is the authority, and the Brema records may
warrant re-checking on that basis. Out of scope for this pass.)

Regardless, the `technical_specification` table should spell the axes out in prose —
"Dimensions (W × D × H) | 800 × 730 × 900 mm" — the way the Fagor record already does, so
the meaning survives independently of the numeric fields.

---

## 7. Product reference

| SKU | Catalogue name | Model | Manufacturer page | Spec sheet | Independent source | Confidence |
|---|---|---|---|---|---|---|
| IMG/HOT/00120 | 4 Burner Gas Range + Electric Oven Kusina | G7K210G-E | https://www.giavazzi.it/dispositivi-medici/cucina-a-gas-con-forno-g7k210ge/ | https://www.giavazzi.it/wp-content/uploads/2025/02/G7K210GE.pdf | https://www.ristoforniture.com/piani-di-cottura-fornelli/2455-cucina-4-fuochi-a-gas-con-forno-elettrico-kusina-g9k210ge-1.html | **High** on dimensions, weight, burners, oven power, materials, gas type — official PDF + official catalogue + retailer all agree. **Medium/unresolved on electrical supply voltage only** (§4.3) |

Additional sources used:

- Official KUSINA catalogue (pp. 19–21 carry the Serie 700 range tables):
  https://www.giavazzi.it/wp-content/uploads/2022/05/Giavazzi-catalogo-KUSINA.pdf
- Brand site: https://www.kusina.it
- Sibling spec sheets used for the electrical inference and family cross-check:
  https://www.giavazzi.it/wp-content/uploads/2025/02/G7K210E.pdf
  https://www.giavazzi.it/wp-content/uploads/2025/02/G7K210G.pdf
  https://www.giavazzi.it/wp-content/uploads/2025/02/G9K210GE.pdf
- Retail listings (used for price calibration and the "26+9" typo note):
  https://www.metro.it/marketplace/product/7ff8a12c-a2fa-459a-ab44-23754933f0b7
  https://www.negoziobusiness.com/product/cucina-a-gas-con-forno-elettrico-eco-line-kusina-by-giavazzi-g7k210ge-serie-700-4-fuochi-pot-26-9-kw-dim-80x73x90-cm-112467/
  https://www.gastrocentrale.it/cucina-gas-giavazzi-g7k210g-.html

**Price context** (calibration only, not a recommendation): Ristoforniture lists our exact
model at **€2,479 excl. VAT**; the gas-oven sibling G7K210G is €2,275 excl. VAT at
Gastrocentrale. Our stored price is **KES 461,175** — roughly €3,000 at a ~150 KES/EUR rate,
i.e. about 1.2× Italian trade ex-VAT before freight, duty and margin. Nothing anomalous.

### 7.1 One retailer/catalogue contradiction, on a sibling not on us

Page 19 of the official catalogue lists the **gas-oven** G7K210G as `800x830x900` —
830 mm deep, against 730 mm for every other Serie 700 model and against the model's own 2025
scheda tecnica, which says 730. Gastrocentrale repeats the 830 figure ("Dim. 80x83x90 cm").
It is a catalogue typo propagated to a retailer.

**Our model is unaffected** — the catalogue, the scheda tecnica and the retailer all
independently say **730** for G7K210G-E. Recorded only as a reminder that the retailer
dimension strings for this brand are copied from the catalogue and inherit its errors.

---

## 8. Recommended changes to `products.json` — priority order

All field-level, for `IMG/HOT/00120`. Nothing below has been applied.

**P1 — the record is published and empty. Fill it.**

1. **`short_description`** — currently `""`. Add, e.g.: *"KUSINA G7K210G-E dual-fuel
   commercial range from Giavazzi's Serie 700 — four 6.5 kW double-crown cast-iron gas
   burners (26 kW total) over a 6 kW electric GN 2/1 oven, in AISI 304 stainless steel.
   Supplied with an LPG conversion kit."*
2. **`description`** — currently absent. Build to the Skymsen/Brema house pattern (prose +
   `<h3>Key Features</h3>` + narrative), from §3.
3. **`technical_specification`** — currently absent. Build the HTML `<table>` from the §3
   table, matching the Fagor CG6-40 sibling's structure.
4. **`meta_description`** — currently absent.

**P2 — the two specs that are installation-critical (§4).**

5. **Store gas and electric ratings separately, never as a combined "32 kW".**
   Gas: `4 × 6.5 kW burners, 26 kW total`. Oven: `6 kW electric`. If a combined figure is
   shown at all, label it explicitly as *"26 kW gas + 6 kW electric"*.
6. **State the gas type explicitly**: *"Factory-fitted with natural-gas injectors; LPG
   (G30/G31) conversion nozzle kit supplied. Must be converted to LPG by a competent gas
   fitter before use in Kenya."* Do **not** publish a converted LPG kW figure or a kg/h
   consumption — neither is sourced.
7. **State that an electrical supply is required** — a gas-badged product with a 6 kW
   electric oven needs its own circuit. Recommended wording until §8/Q1 is answered:
   *"Electric oven requires a dedicated supply; confirm voltage against the unit's rating
   plate at installation."* **Do not write a specific voltage into the record yet** (§4.3).

**P3 — dimensions and weight.**

8. Add **`width: 800`, `length: 730`, `height: 900`** (W/D/H per §6 — `width` is the front
   width, `length` is the depth).
9. Add **net weight 130 kg** and, optionally, packed volume 0.84 m³ — this is a two-person
   /trolley delivery item and the figure is useful to logistics.
10. Add oven capacity **3 × GN 2/1 (650 × 530 mm), 3 rack levels** and cooking-top surface
    **800 × 630 mm**.

**P4 — image.**

11. **Replace the stored image.** The current file is a 600 px generic render of a different
    manufacturer's range (§5.1). Use `IMG-HOT-00120__G7K210GE-hero-1000.jpg` from §9 —
    1000 × 1000, the manufacturer's own render. Optionally add the drawing and the two
    detail shots as a gallery.

**Explicitly do NOT change:**

- **`model_number`** — `G7K210G-E` is Giavazzi's own catalogue spelling (§2) and is the
  record's identity per [[feedback_model_number_unique_id]].
- **`name`**, **`price`**, **`status`**, **`category`**, **`brand`**.

**`brands.json` (separate file, also not applied):**

12. Set **`website_url`** for `slug: kusina` to **`https://www.kusina.it`** — this is the
    brand's own site (§1.2), not an OEM's, so the Diqian objection does not apply.
13. Optionally replace the generic filler `description` with the sourced one in §1.2.

---

## 9. Image sourcing (July 2026) — downloaded to `Downloads/kusina-images/`

**6 files, all visually opened and verified as the correct 4-burner-plus-electric-oven unit.**

Giavazzi's own website images are genuinely tiny — the WordPress media API
(`/wp-json/wp/v2/media?search=G7K210`) shows the largest asset it holds for this model is
**290 × 290 px**, and every sibling tops out at 400–520 px. Stripping the `-e1738509001379`
WordPress edit suffix gave the same 290 px file. So the usable imagery came from two places:
**images embedded inside the official spec-sheet PDF** (extracted with pypdf), and the
**Ristoforniture PrestaShop `thickbox_default` renditions at 1000 × 1000**.

| File | Pixels | Size | What it is | Source |
|---|---|---|---|---|
| `IMG-HOT-00120__G7K210GE-hero-1000.jpg` | 1000 × 1000 | 136 KB | **Primary candidate.** 3/4 hero render — 4 burners, square vitrified grates, oven door with tubular handle, 4 hob knobs + 2 oven knobs on the right panel. Byte-for-byte the same render Giavazzi uses, at 1000 px instead of 290 px | https://www.ristoforniture.com/15367-thickbox_default/cucina-4-fuochi-a-gas-con-forno-elettrico-kusina-g9k210ge.jpg |
| `IMG-HOT-00120__G7K210GE-drawing-all-views-1000.jpg` | 1000 × 1000 | 129 KB | Full dimensional drawing — front, side, plan and 3/4, annotated **800 / 730 / 900** and `ATTACCO GAS`. Spec reference, not a storefront photo | https://www.ristoforniture.com/15368-thickbox_default/cucina-4-fuochi-a-gas-con-forno-elettrico-kusina-g9k210ge.jpg |
| `IMG-HOT-00120__G7K210GE-drawing-front-side.jpg` | 1352 × 598 | 59 KB | Front + side elevations, annotated 900 H and 730 D. Higher effective resolution than the combined sheet above | extracted from https://www.giavazzi.it/wp-content/uploads/2025/02/G7K210GE.pdf |
| `IMG-HOT-00120__G7K210GE-drawing-plan-3d.jpg` | 1352 × 598 | 112 KB | Plan view (annotated 800) + 3/4 line drawing with W/D/H callouts | extracted from the same official PDF |
| `IMG-HOT-00120__G7K210GE-detail-grates-1000.jpg` | 1000 × 1000 | 93 KB | Close-up of the vitrified cast-iron grate plates. Letterboxed — the subject occupies a horizontal band, so it needs cropping before use | https://www.ristoforniture.com/15364-thickbox_default/... |
| `IMG-HOT-00120__G7K210GE-detail-spilltray-burner-1000.jpg` | 1000 × 1000 | 114 KB | Two-panel detail: removable spill tray lifted out, and a double-crown burner head close-up. Also needs cropping | https://www.ristoforniture.com/15366-thickbox_default/... |

**Nothing below 800 px was kept.** Downloaded and then deleted as superseded: Giavazzi's
290 × 290 official square PNG (both the `-e1738509001379` and bare `_square` variants —
identical), the 765 × 764 hero extracted from the PDF (the 1000 px Ristoforniture file is the
same render, larger), the 455 px `large_default` and 709 px unsuffixed PrestaShop
renditions, and two extracted Giavazzi logo bitmaps.

Notes for whoever adopts these:

- **The Ristoforniture filenames say `g9k210ge`** (the Serie 900 model) but the page title,
  body copy and spec table all say **G7K210GE**, and the drawing in `15368` is annotated
  **730 mm deep** — which is Serie 700, not the 900 mm of Serie 900. The filename is a
  retailer slug typo; the images are our model. Verified visually, not assumed.
- The hero render matches the official Giavazzi PDF render exactly (same lighting, same
  angle, same knob positions), which is what confirms provenance.
- **Not copied into `storage/app/public/products/`** and **not referenced in
  `products.json`** — staged in Downloads for review, same as the Brema/Diqian passes.
- Per [[feedback_downloads_cleanup]], delete the source files from Downloads once whichever
  ones get adopted are copied into `storage/products`.

---

## 10. Open questions for the supplier

1. **What is the electric oven's supply voltage?** 400 V 3N~ (three phase, as every other
   Giavazzi Serie 700 electric model) or 230 V single phase at ~26 A? Giavazzi does not
   publish it for this model. **Read it off the unit's rating plate.** This decides whether
   the customer needs a three-phase supply, and it is the only material gap in an otherwise
   fully verified spec. (§4.3)
2. **Has the LPG injector kit been fitted, or is it still loose in the carton?** The unit
   ships set up for natural gas. Who converts it, and is that priced in? (§4.2)
3. **Oven thermostat range** — unpublished by Giavazzi. Available from the rating plate or
   the installation manual shipped with the unit; worth capturing while the unit is in the
   warehouse.
4. **Confirm the stocked unit is the electric-oven variant**, not the gas-oven G7K210G. The
   two are visually near-identical apart from the two oven knobs on the right-hand panel;
   the current stored photo is a generic render of neither (§5.1). The 13 kg weight
   difference (130 vs 143 kg) is the quickest non-visual discriminator.
