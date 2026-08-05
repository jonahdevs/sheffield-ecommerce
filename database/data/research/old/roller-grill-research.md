# Roller Grill Product Research

Research notes behind a ROLLER GRILL audit pass on `products.json` (July 2026).
Covers both ROLLER GRILL SKUs: the GR 80 E electric gyros/shawarma grill (`IMG/HOT/00099`,
Fast Food) and the RFG 12 fryer (`IMG/HOT/00098`, Fryers).

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema, Baron, Santos and Empero passes before a scope
decision.

Only 2 SKUs, so both were taken all the way to the manufacturer's own PDF datasheet **and**
its installation/user manual. Both are genuine, current, in-catalogue Roller Grill products.
One record has a wrong dimension and an under-specified electrical supply; the other
**describes a gas appliance as electric**.

---

## 1. Brand identification — confirmed, with a correction to the brief

**Roller Grill** = **ROLLER GRILL INTERNATIONAL S.A.S**, 16 rue Saint-Gilles, **28800
Bonneval, France** (Eure-et-Loir) — the legal entity named in the site's *mentions légales*.
Tel +33 (0)2 37 44 67 67. Site tagline: *"French manufacturer of professional kitchen
equipment **since 1947**"*; the company claims 100% French production, 350+ products in
range, and presence in 100+ countries.

- Legal notice / address: https://www.rollergrill-international.com/fr/mentions-legales.html
- Company/range home: https://www.rollergrill-international.com/en/

⚠ The task brief said Maurepas. **The registered address is Bonneval, not Maurepas** — the
`+33 (0)2 37` dialling code is Eure-et-Loir, which corroborates Bonneval. Worth correcting
wherever that came from.

`brands.json` already has `slug: roller-grill`, `name: Roller Grill`,
`website_url: https://www.rollergrill-international.com/en/`.

**The URL is correct and live** — HTTP 200, no redirect (the bare apex redirects to `/fr/`,
so keeping the explicit `/en/` in `brands.json` is actually the better choice).
**No `brands.json` URL change needed.**

The existing `brands.json` description ("French manufacturer of professional catering
equipment … cooking and warming equipment") is accurate but generic. It omits *since 1947*,
*Bonneval*, and *made in France* — the kind of provenance detail other brand entries carry.

Both catalogue SKUs were located in Roller Grill's own live catalogue, so the brand
attribution on both records is correct.

---

## 2. Where to look

| Resource | URL | Value |
|---|---|---|
| Corporate site (EN) | https://www.rollergrill-international.com/en/ | Company copy, range navigation |
| Gyros grills category | https://www.rollergrill-international.com/en/professional-range/16/cooking/gyros-grills.html | GR 40/60/80 in E and G |
| Professional fryers category | https://www.rollergrill-international.com/en/professional-range/12/cooking/professional-fryers.html | RFG 8 / RFG 12 / RFG 16 + MS cabinets |
| **Official per-model technical sheet PDFs (gold standard)** | `https://www.rollergrill-international.com/images/stories/virtuemart/product/<Title-Case-Name>.pdf` | Dimensioned drawings, exploded views, full parts list, wiring diagram |
| **Official installation/user manuals (also gold standard)** | same `/images/stories/virtuemart/product/` folder | The **only** place the full spec table with voltage/phase appears |

### Traps

1. **The "Technical sheet" download link on each product page is login-gated** — the page
   renders it as an inert `<span href="#">` with a `downloadlocked` icon, so no href exists
   to follow. **But the file itself is public.** The `title` attribute on that span carries
   the exact filename stem, and appending `.pdf` to it under
   `/images/stories/virtuemart/product/` fetches it with a plain `curl`, no auth:
   - `title="Technical-sheet-kebab-electric-grill-GR80E-DT128-Ind-A"` →
     https://www.rollergrill-international.com/images/stories/virtuemart/product/Technical-sheet-kebab-electric-grill-GR80E-DT128-Ind-A.pdf
   - `title="Technical-sheet-gas-fryer-RFG12B-DT110-Ind-B"` →
     https://www.rollergrill-international.com/images/stories/virtuemart/product/Technical-sheet-gas-fryer-RFG12B-DT110-Ind-B.pdf

   Both returned exactly the byte counts the page advertises (700.1 KB / 716.52 KB), so
   they are the genuine gated files. **Reuse this pattern for any future Roller Grill SKU.**
2. **PDFs do not extract via WebFetch** — the same trap flagged in the Santos and Baron
   passes. The `Read` tool renders them properly, including the dimensioned drawings, which
   were decisive here. For the 28-page manuals (over the 10-page `Read` limit) `fitz`/pypdf
   text extraction was used instead.
3. **The technical *sheet* is a drawing pack, not a spec table.** DT128/DT110 give exploded
   views, parts lists, a wiring diagram and a dimensioned drawing — but **no voltage/phase
   figure**. That only appears in the *manual*'s "Caractéristiques techniques" table. If you
   only pull the datasheet you will miss the single most important fact about the GR 80 E
   (§3.3).
4. **Product images are lazy-loaded** — the real file is in `data-src`, not `src` (same as
   the Brema pass). `og:image` also carries it.
5. **UK reseller spec tables drift** from Roller Grill's own numbers on height, capacity and
   burner type — see §3.2 and §5.

---

## 3. GR 80 E — Shawarma Electric Roller Grill (IMG/HOT/00099)

Official catalogue page:
https://www.rollergrill-international.com/en/professional-range/163/16/cooking/gyros-grills/gyros-grills/electric-gyros-grill-800-mm-high-spit-40-kg-of-meat-detail
Official technical sheet (DT128 Ind A, dated 18/01/2016):
https://www.rollergrill-international.com/images/stories/virtuemart/product/Technical-sheet-kebab-electric-grill-GR80E-DT128-Ind-A.pdf
Official manual (GR 40 E / GR 60 E / GR 80 E):
https://www.rollergrill-international.com/images/stories/virtuemart/product/Manual-electric-gyros-grills-GR-G03115.pdf

### 3.1 `model_number` drift — Roller Grill writes **`GR 80 E`** with spaces ⚠

Stored `model_number` is **`GR80E`** (closed up). Roller Grill's own usage is split:

| Where | Form used |
|---|---|
| Product page title & body copy | `GR 80 E` |
| Quotation link on the product page (`/quote.html?reference=GR 80 E`) | `GR 80 E` |
| Technical sheet title block (all 6 pages) | `GR 80 E` |
| Manual spec table | `GR 80 E` |
| Datasheet *filename* | `GR80E` |
| Every reseller found | `GR80E` |

So `GR 80 E` is the manufacturer's catalogue code and `GR80E` is the compressed form Roller
Grill itself uses in filenames and the whole trade uses in listings. This is a **spacing
convention difference, not a transcription error** (unlike the Baron `SE40/OCB` letter-O
bug). **Flagged, not changed** — `model_number` is the unique ID. Low priority; the stored
form is unambiguous and matches trade usage.

### 3.2 The `height` is wrong **and** the width/height numeric fields are swapped ⚠⚠

| | Length | Width | Height |
|---|---|---|---|
| Stored numeric fields | 580 | **1085** | **660** |
| Stored prose `technical_specification` | 580 | 660 | **1085** |
| **Official catalogue page** | **580** | **660** | **1035** |
| **Official manual spec table** | **580** | **660** | **1035** |
| Official technical-sheet drawing (body only, excl. protrusions) | 566 | 636 | 1016 |
| UK resellers (advantage, catering-appliance, cateringhygiene) | 580 | 660 | 1045 |

Two separate faults are stacked, exactly the shape seen on Baron SE40/0CB:

- **`width` and `height` are transposed.** Stored `width: 1085` is really the height and
  stored `height: 660` is really the depth. As in every previous pass, **the prose spec has
  the axes right and the numeric fields do not.**
- **The height *value* itself is wrong.** 1085 mm appears in **no source at all** —
  not Roller Grill, not the drawing, not a single reseller. Roller Grill states **1035**
  in two independent places (catalogue page and manual table). The drawing's 1016 is the
  bare cabinet excluding the roof lip/knobs; the resellers' 1045 is a 10 mm drift of the
  same figure.

Using this catalogue's axis convention (`length` = frontage width, `width` = depth,
`height` = height), the corrected values are **`length: 580`, `width: 660`, `height: 1035`**.

### 3.3 The electrical spec is the biggest gap: this is a **three-phase** machine ⚠⚠⚠

The stored `description` says only *"Volts : 380 v"*. The manual's spec table (page 9 FR /
page 17 EN) is unambiguous:

| Model | Elements | Capacity | Power | Amps | Voltage |
|---|---|---|---|---|---|
| GR 40 E | 3 | 15 kg | 3600 W | 16 A | 220-240 V ~ |
| GR 60 E | 4 | 25 kg | 5800 W | 6.3 A / phase | **380-415 V 3 N ~** |
| **GR 80 E** | **5** | **40 kg** | **7250 W** | **6.3 A / phase** | **380-415 V 3 N ~** |

Corroborated by the wiring diagram in DT128 (page 4): a 5-terminal domino fed by **three
phases + neutral + earth**, cable **H07 RN-F 5G1.5** (5-core), five **1450 W / 230 V**
elements grouped 2+2+1 across the three phases via three commutators.

**Kenya verdict: compatible, but the record hides a real installation requirement.**
Kenya's LV distribution is 415 V 3-phase / 240 V phase-neutral at 50 Hz, which sits inside
Roller Grill's stated **380-415 V 3N~** band, and each 230 V element will simply run ~9%
hotter on 240 V. So this is **not** a wrong-market spec. But:

- The record never says **three-phase**. A Kenyan buyer reading "380 v" could reasonably
  assume a normal socket. It is not: the manual (page 7) requires *"a means of disconnection
  in the fixed wiring"* for GR 60 E and GR 80 E — i.e. **hardwired to a 3-phase board by an
  electrician**, exactly as the UK resellers state ("3 Phase Hardwired - to be installed by
  a qualified electrician").
- **A wrong-market variant does exist and must not be used.** Equipex/Spring USA sell the
  same model in the USA as the "Everest Gyro Grill GR80E" at **208/240 V three phase** —
  https://springusa.com/shop/gr80e-everest-gyro-grill.html — which would be wrong for Kenya.
  If a future pass sources data for this SKU from a US site, that figure will be the one it
  finds. Our stored 380 V is at least on the correct (European) side.
- Reseller "415V, 7.2kW, **17.3A**" (catering-appliance) is just 7200 ÷ 415 arithmetic, not a
  per-phase current. Prefer Roller Grill's **6.3 A / phase**. **Low confidence** on 17.3 A.

Recommended wording: **380-415 V 3N~, 50/60 Hz, approx. 6.3 A per phase — requires a
three-phase supply and fixed wiring.**

### 3.4 Everything else on this record checks out

Confirmed correct against the official sources — no change needed:

- **7.2 kW** (Roller Grill's rounding of 7250 W) — correct
- **40 kg** meat capacity — correct (resellers' "40 to 50 kg" is optimistic; Roller Grill
  says 40)
- **35 kg** unit weight — correct
- 5 heating elements with independent full/half-power regulation — correct
- Firestones behind the elements to accumulate and return heat — correct
- Fully hermetic bottom plate protecting the motor from fat/juice infiltration — correct
- Mounted on ball bearings; large stamped juice collector with removable drip tray — correct

Confirmed by the official sources but **absent from the record**:

- **Elements are Incoloy**, 5 × **1450 W / 230 V**
- **Spit height 800 mm** (this is what the "80" in GR 80 E means; the GR 60 E is 600 mm and
  the GR 40 E 400 mm) — spit part is stainless, length 842 mm
- The **whole element carriage slides front-to-back** on two side screws and locks at any
  position, to set the distance from the meat
- A **beta pin can be removed to rotate the spit by hand** if the motor fails
- The unit has a **built-in mains socket for an electric carving knife**
- **10 cm minimum clearance** from any wall or partition
- Conformity: **IEC/EN 60335-1, IEC/EN 60335-2-48, EN 55014-1/-2, EN 61000-3-3**, RoHS
  2002/95/CE, WEEE 2002/96/CE; site footer also carries CE / NSF / UL / GS marks
- Options (all separate SKUs): stainless **splash bib**, stainless **side reflectors**,
  **panoramic glass doors**, **knife holder**, **electric knife**, **BG 1** set of 4
  rotisserie spits, **BG 4** set of 12 barbecue skewers, **meat shovel/pan**
- Made in France

### 3.5 Naming note

The record's `name` is *"Shawarma Electric Roller Grill"*. Roller Grill calls it a **gyros
grill** / kebab grill; "shawarma" is the same machine under the Levantine name and is the
right word for the Kenyan market. Not wrong — but the description would carry better search
value if it said **gyros / kebab / doner / shawarma** rather than only one of the four.

Also: the stored `image` for this SKU is a **`.jfif`** file
(`products/shawarma-electric-roller-grill-imghot00099.jfif`) — the only `.jfif` seen in this
brand. Browsers render it, but it is an odd format to keep; worth normalising to `.jpg` when
the image is refreshed (§6).

---

## 4. RFG 12 — Fryer Roller Grill RFG 12 (IMG/HOT/00098)

Official catalogue page:
https://www.rollergrill-international.com/en/professional-range/170/12/cooking/professional-fryers/professional-fryers/professional-gas-fryer-1-tank-of-12-l-detail
Official technical sheet (DT110 Ind B, dated 14/03/2017):
https://www.rollergrill-international.com/images/stories/virtuemart/product/Technical-sheet-gas-fryer-RFG12B-DT110-Ind-B.pdf
Official manual (RFG 8 / RFG 12 B, July 2017):
https://www.rollergrill-international.com/images/stories/virtuemart/product/Manual-gas-fryers-RFG12B-RFG8-G033635.pdf

### 4.1 The `short_description` calls a **gas** fryer **electric** ⚠⚠⚠ — the headline finding

Stored `short_description`:

> "Roller Grill RFG 12 commercial **electric** fryer delivering professional high-volume
> frying performance…"

**The RFG 12 has no heating element and no mains connection whatsoever.** It is a
**bottled-gas / natural-gas** fryer:

- Roller Grill's page title is literally *"**Professional gas fryer** - 1 tank of 12 L"*
- The manual is titled *"**FRITEUSES GAZ** RFG 8 / RFG 12 B — **GAS FRYERS**"*
- The datasheet parts list is all gas hardware: 2 × burner (E01021), thermocouple, pilot
  light, piezo, thermostatic gas tap, injectors, 1/2" gas fittings
- The record's own `description` says gas seven times ("professional **gas** fryer",
  "**Piezo** ignition", "2 very powerful **burners**", "the **gas** is evacuated by the back
  pipe")

So the record **contradicts itself**, exactly like the Baron DI7FRE415 "Table Top" vs
"drop-in" problem. For a fryer this is worse than a naming slip: a buyer shopping the
"Fryers" category on the strength of the short description would order a machine that needs
an LPG cylinder and a gas-safe installation. **This is the single highest-priority fix in
the whole pass.**

The `name` — *"Fryer Roller Grill RFG 12"* — states no fuel at all, which is how the error
survived. Recommend the name carry **Gas** (e.g. *"Gas Fryer 12 L Roller Grill RFG 12"*),
subject to the usual name-change approval.

**Kenya note (positive):** the fryer ships from the factory jetted for **butane/propane
(LPG)** with Ø1.10 injectors fitted and natural-gas Ø1.55 injectors supplied loose in the
box. LPG is the dominant bottled fuel in Kenya, so **the factory configuration is the right
one for this market** — no conversion needed, and the NG jets are a bonus. Worth saying so
explicitly in the copy.

### 4.2 `model_number`: `RFG 12` matches, but current production is indexed **`RFG 12 B`**

| Where | Form used |
|---|---|
| Catalogue page title & body | `RFG 12` |
| Quotation link (`/quote.html?reference=RFG 12`) | `RFG 12` |
| **Technical sheet title block** | **`FRITEUSE RFG 12 B`** |
| **Manual cover & spec table** | **`RFG 12 B`** |
| Parts list (every part) | `… RFG 12 B` |
| Resellers | `RFG12` / `RFG 12` |

Our stored **`RFG 12` matches Roller Grill's own commercial reference exactly** — no drift
on the field as stored. The **`B`** is a production index (DT110 *Ind B*, drawing revised
14/03/2017) that Roller Grill uses on engineering documents but not in the shop-facing
catalogue. **Flagged for awareness only; no change recommended.** If the supplier's invoice
ever says "RFG 12 B", that is the same machine.

### 4.3 Dimensions: the numeric fields are **correct** — but they are the body only ⚠

| Source | Width | Depth | Height |
|---|---|---|---|
| Stored (numeric + prose, internally consistent) | **400** | **700** | **325** |
| **Official catalogue page** | **400** | **700** | **325** *(+ 180 mm exit pipe)* |
| Official technical-sheet drawing | 400 | **697** | **500** |
| **Official manual spec table (FR and EN)** | 400 | 700 | **565** |
| Reseller (catering-appliance) | 400 | 700 | **565** |
| Reseller (Nisbets) | 400 | **600** | 505 |

**No axis-swap bug on this SKU** — `length: 400` (frontage), `width: 700` (depth),
`height: 325` all sit on the right axes, and they match Roller Grill's own catalogue
figures exactly. Same per-SKU lesson as Brema CB 955A, Santos 11A and Baron DI7FRE415: the
swap has to be checked one SKU at a time; here one of the two was clean.

The problem is that **325 mm is the tank/body height only**. Behind the tank sits a
**180 mm flue** (`cheminée`, parts 69077SE/69078) that is not optional and cannot be
removed. Three "overall" figures are in circulation and they reconcile like this:

- **325** — body, no flue. Roller Grill's catalogue headline figure.
- **~505** (325 + 180) — body + flue. Matches the drawing's **500** and Nisbets' **505**.
- **565** — the figure in Roller Grill's **own manual** and on catering-appliance. The most
  likely reading is 500 as drawn **plus the four adjustable feet** (part A13006), which the
  front elevation appears to measure from above. **Medium confidence** on that explanation;
  the 565 figure itself is High confidence since it is the manufacturer's own manual.

**Recommendation: keep `height: 325`** (it is Roller Grill's catalogue figure and matches
the catalogue's axis convention), and add an explicit **"overall height including flue and
feet: 565 mm"** row to the spec table — that is the number an installer needs for shelf and
extraction clearance. Nisbets' 600 mm depth is an outlier against four other sources; use
**700**.

### 4.4 Everything else on this record checks out

Confirmed correct against the official sources — no change needed:

- **8 kW** — confirmed (`débit calorifique 8 kW au G30/G31 and 8 kW au G20/G25`)
- Outside dimensions **400 × 700 × 325 mm** — confirmed (§4.3)
- Basket **250 × 270 × 110 mm** — confirmed
- Filtering basket-holder in the tank floor; double ramp of radiants under the stainless
  tank; piezo ignition; pilot light + thermocouple; back exit pipe; stainless drain tap;
  adjustable feet; stainless lid; mountable on the **MS-RFG 12** cabinet — all confirmed
  verbatim from Roller Grill's own page

Confirmed by the official sources but **absent from the record**:

- **Tank capacity 12 litres** — currently nowhere in the record at all, despite being in the
  model name on Roller Grill's page ("1 tank of 12 L")
- **Weight 34 kg**; **2 burners**
- **Temperature range 100 °C – 190 °C**, thermostat positions 1-8 =
  100 / 113 / 126 / 139 / 152 / 165 / 178 / 190 °C
- **Maximum food load 2 kg** per batch (the RFG 8 is 1 kg)
- **Gases: butane G30, propane G31, natural gas G20/G25.** Delivered with butane/propane
  injectors (Ø1.10) fitted, category **II2E+3+**; natural-gas injectors (Ø1.55) supplied in
  a bag for conversion. **Gas connection: 1/2" thread.**
- **Combustion-air requirement 16.3 m³/h**; **10 cm minimum clearance** from wall/partition;
  max gas bottle 143 × 30 cm (35 kg)
- **Safety thermostat** (part A06001) in addition to the thermostatic tap
- **In the box:** fryer, 1 basket, lid + handle, 4 feet, drain tube + seal, manual.
  ⚠ The **piezo needs an AA battery which is *not* supplied** (manual, p7) — a genuinely
  useful thing to tell a buyer.
- **Output 18 kg/h**; **packaged 600 (H) × 445 (W) × 755 (D) mm, 38 kg** *(reseller figures,
  Medium confidence — not in any Roller Grill document)*
- Optional **MS-RFG 12** stainless cabinet stand: door and counter-door with magnetic
  closure, 150 mm feet, floor-fixable per CE/UL/NSF
- Made in France; 2-year manufacturer warranty per UK distributors

### 4.5 A manufacturer error worth knowing about

The manual's gas-consumption block (p9) prints the **same figures for both models**:
846 l/h G20, 983 l/h G25, 630 g/h G30, 621 g/h G31. That cannot be right — RFG 8 is 4 kW and
RFG 12 B is 8 kW. Checked against calorific values: 8 kW ÷ 9.45 kWh/m³ (G20) = **846 l/h**,
and 8 kW ÷ 12.68 kWh/kg (G30) = **630 g/h**. **The printed figures are the RFG 12 B's**, and
Roller Grill has copy-pasted them onto the RFG 8 row. So the consumption numbers are safe to
quote **for our SKU** (High confidence), just not for the RFG 8.

---

## 5. Cross-cutting notes

- **Axis convention.** This catalogue stores `length` = frontage width, `width` = depth,
  `height` = height. RFG 12 follows it correctly; GR 80 E transposes `width`/`height`. One
  of two SKUs clean again — no blanket transform is ever safe.
- **The prose spec was right and the numeric fields were wrong**, for the fourth brand
  running (Brema, Santos, Empero, Baron). On GR 80 E the prose had the *axes* right but the
  *height value* wrong as well, which is a new twist: the prose is a better guide to layout
  than to values.
- **Reseller spec tables drift** from Roller Grill's on height (1045 vs 1035), capacity
  (40-50 kg vs 40 kg), current (17.3 A vs 6.3 A/phase) and even burner type — catering-
  appliance's GR 80 E bullet list says *"3 ceramic burners"*, which is the **gas GR 80 G**'s
  hardware pasted onto the electric model. Where a Roller Grill document exists, it wins.
- **Fuel-type errors are the theme of this pass.** RFG 12's short description says electric
  for a gas machine; a reseller's GR 80 E page says burners for an electric machine. Both
  directions of the same mistake, in the same brand.
- **Both records lack a `meta_description`**, and both carry Quill editor junk — the fryer's
  description is wall-to-wall `<p class="ql-align-justify">`, the grill's is a bare `<ul>`
  with `&nbsp;` padding. Same cleanup as the Brema/Santos/Baron restructure passes: prose +
  `<h3>Key Features</h3>` + HTML `<table>`.
- **Both descriptions are near-verbatim copies of Roller Grill's own English page copy**,
  including its slightly awkward translated English ("makes it possible to control the
  arrival of the gas"). Accurate, but not written for a Kenyan buyer and not scannable.
- **Categories are fine.** GR 80 E in `Fast Food`, RFG 12 in `Fryers` — both match how
  Roller Grill classifies them (gyros grills under cooking; professional fryers).

---

## 6. Product reference

| SKU | Catalogue name | Stored model | Roller Grill's own code | Official page | Official technical sheet PDF | Official manual PDF | Confidence |
|---|---|---|---|---|---|---|---|
| IMG/HOT/00099 | Shawarma Electric Roller Grill | GR80E | **GR 80 E** (spaced; DT128) | https://www.rollergrill-international.com/en/professional-range/163/16/cooking/gyros-grills/gyros-grills/electric-gyros-grill-800-mm-high-spit-40-kg-of-meat-detail | https://www.rollergrill-international.com/images/stories/virtuemart/product/Technical-sheet-kebab-electric-grill-GR80E-DT128-Ind-A.pdf | https://www.rollergrill-international.com/images/stories/virtuemart/product/Manual-electric-gyros-grills-GR-G03115.pdf | **High** — official page + datasheet + manual, exact model match |
| IMG/HOT/00098 | Fryer Roller Grill RFG 12 | RFG 12 | **RFG 12** (catalogue) / **RFG 12 B** (DT110 Ind B) | https://www.rollergrill-international.com/en/professional-range/170/12/cooking/professional-fryers/professional-fryers/professional-gas-fryer-1-tank-of-12-l-detail | https://www.rollergrill-international.com/images/stories/virtuemart/product/Technical-sheet-gas-fryer-RFG12B-DT110-Ind-B.pdf | https://www.rollergrill-international.com/images/stories/virtuemart/product/Manual-gas-fryers-RFG12B-RFG8-G033635.pdf | **High** — official page + datasheet + manual, exact model match |

Supporting / cross-check sources:

- https://www.advantage-catering-equipment.co.uk/products/roller-grill-gr-80-e-electric-kebab-grill
- https://www.catering-appliance.com/roller-grill-gr80e-kebab-machine
- https://www.cateringhygiene.co.uk/shop/roller-grill-gr80e-electric-modular-gyros-kebab-grill-800mm-spit-40kg.html
- https://ceonline.co.uk/roller-grill-gr80e-800mm-electric-kebab-grill.html
- https://springusa.com/shop/gr80e-everest-gyro-grill.html *(US 208/240 V variant — do not use, §3.3)*
- https://www.catering-appliance.com/roller-grill-rfg-12-ltr-propane-gas-countertop-single-tank-fryer-1-x-basket
- https://www.nisbets.co.uk/roller-grill-single-tank-countertop-fryer/gp318-p
- https://www.angliacateringequipment.com/product/roller-grill-rfg-12-countertop-single-tank-modular-gas-fryer-1-basket-12l/
- https://www.directequip.com/acatalog/Roller-Grill-Single-Tank-Gas-Fryer-RFG12.html
- https://www.rollergrill-international.com/fr/mentions-legales.html

Sibling models confirmed on the same pages, useful if the range is ever extended:
**GR 40 E / GR 60 E / GR 80 G** (gyros grills), **RFG 8 / RFG 16 / MS-RFG 12** (fryers).

---

## 7. Image sourcing (July 2026) — downloaded to `Downloads/roller-grill-images/`

Roller Grill's own site carries **exactly one product render per model**, and it is small —
401 × 600 for the GR 80 E and 635 × 650 for the RFG 12. Both are below a usable storefront
size and both were **discarded** once better copies were found. The two good sources were:

1. **The manuals' embedded raster images**, extracted losslessly with `fitz`. These are the
   *same* studio renders as the website, but at the print resolution the PDF was built from
   — 841 × 1168 and 935 × 958, roughly 20× the file size of the web copies. Same trick as
   the Comenda pass.
2. **UK reseller CDNs**, which host larger JPEG/WebP copies of the same render — the best
   being cateringhygiene's 1100 × 1100.

Nothing genuinely new-angle exists: Roller Grill shoots one render per model and the whole
trade reuses it. **No dimension drawings are in this set** — the dimensioned drawings live
inside the datasheet PDFs (§6) as vector art, not as standalone images.

**8 files kept. All are real product photos/renders.**

| SKU | File | Pixels | Size | Source | Notes |
|---|---|---|---|---|---|
| IMG/HOT/00099 | `IMG-HOT-00099__GR80E-reseller-ch-1100.jpg` | **1100 × 1100** | 112 KB | https://www.cateringhygiene.co.uk/shop/media/iopt/catalog/product/cache/34127873b120fb52d2996e712f52a5bb/r/o/roller_grill_gr80e_modular_kebab_grill_jpg_8.webp | **Primary candidate.** Largest square copy of the official render, clean white background. Converted WebP → JPEG q92 |
| IMG/HOT/00099 | `IMG-HOT-00099__GR80E-manual-cover-hires.png` | **841 × 1168** | 758 KB | Extracted from `Manual-electric-gyros-grills-GR-G03115.pdf`, p1 | Highest-fidelity copy (lossless PNG straight out of the manufacturer's own PDF). Portrait crop suits a tall product |
| IMG/HOT/00099 | `IMG-HOT-00099__GR80E-manual-body-hires.png` | 655 × 909 | 466 KB | Same manual, p7 | Slightly tighter crop of the same render. Long edge 909 px |
| IMG/HOT/00099 | `IMG-HOT-00099__GR80E-reseller-advantage-1024.jpg` | 1000 × 750 | 41 KB | https://www.advantage-catering-equipment.co.uk/cdn/shop/products/Roller_Grill_GR80E_Electric_Kebab_Grill.jpg | Landscape framing of the same render — useful if a wide card crop is needed. Fetched by stripping the `_1000x`/`_1024x1024` suffix from the URL |
| IMG/HOT/00098 | `IMG-HOT-00098__RFG12-manual-hires.png` | **935 × 958** | 740 KB | Extracted from `Manual-gas-fryers-RFG12B-RFG8-G033635.pdf`, p7 | **Primary candidate.** Lossless, manufacturer-source, shows the flue, basket, drain tap and gas control panel |
| IMG/HOT/00098 | `IMG-HOT-00098__RFG12-control-panel-hires.png` | 1012 × 518 | 373 KB | Same manual, p1 | Close-up of the yellow-bordered gas fascia: thermostat knob 1-8, piezo button, drain tap. Good detail shot, not a hero image |
| IMG/HOT/00098 | `IMG-HOT-00098__RFG12-reseller-cas-front.jpg` | 800 × 595 | 40 KB | https://assets.catering-appliance.com/media/inside-sqr-2048/18/0e/roller-grill-rfg12_img24517.jpg | Genuinely different composition — the **only** shot showing the stainless lid, laid beside the unit. At the 800 px minimum |
| IMG/HOT/00098 | `IMG-HOT-00098__REF__MS-RFG12-cabinet-accessory.jpg` | 433 × 650 | 30 KB | https://www.rollergrill-international.com/images/stories/virtuemart/product/meuble-friteuse-pro-inox-msrfg12.jpg | ⚠ **`REF__` — do not use as a product image.** Two reasons: it shows the optional **MS-RFG 12 cabinet**, not the fryer; and the fryer sitting on it is a *different* (electric-fascia) Roller Grill model, not our gas RFG 12. **Also below the 800 px bar** — it is the only image of this accessory that exists, kept purely as a reference for what the optional stand looks like |

**Model verification performed, not assumed.** Every kept file was opened and inspected.
The GR 80 E is distinguishable from its siblings by **control-knob count**: GR 40 E and
GR 60 E have fewer commutators and a visibly shorter body. The sibling renders were pulled
for direct comparison —
`.../machine-kebab-professionnelle-electrique-gr40e.jpg` (550 × 648) and
`.../grill-viande-vertical-electrique-broche-kebab-pro-gr60e8.jpg` (550 × 681) — and the
GR 60 E has **2 knobs** against the GR 80 E's **3**, on a shorter cabinet. **Every GR 80 E
file kept here shows 3 knobs and the tall cabinet: correct model, High confidence.**

**Discarded during verification:**

- Roller Grill's own `machine-kebab-electrique-pro-gr80e.jpg` (401 × 600) and
  `friteuse-professionnelle-gaz-12-litres-rfg12.jpg` (635 × 650) — correct model, but the
  manual extractions are the same renders at far higher resolution.
- catering-appliance's 534 × 800 GR 80 E and ceonline's 660 × 660 — redundant, lower quality.
- directequip's RFG12.jpg (760 × 640) and angliacateringequipment's (397 × 397) — below bar,
  same render.
- **Five "accessory" images from catering-appliance** (splashback, glass doors, spit set,
  drainer, deflector) — every one turned out to be the **Roller Grill logo** on white, a
  placeholder rather than a photo. **Deleted.**

Notes for whoever adopts these:

- **The current stored images are the same renders, much smaller.** `IMG/HOT/00099`'s
  `products/shawarma-electric-roller-grill-imghot00099.jfif` and `IMG/HOT/00098`'s
  `products/fryer-roller-grill-rfg-12-imghot00098.jpg` are the identical Roller Grill
  studio shots. Swapping in the files above is a straight quality upgrade with no risk of
  showing the wrong unit — and would also let `.jfif` be normalised to `.jpg` (§3.5).
- The PNG files are lossless and large; convert to WebP/JPEG at adoption time.
- **Not yet copied into `storage/app/public/products/` or referenced in `products.json`** —
  staged in Downloads for review first, same workflow as the Brema, Santos and Baron passes.

---

## 8. Summary — what a future write pass would change

Nothing in this pass has been applied. In priority order:

**IMG/HOT/00098 (RFG 12) — do this one first**

1. 🔴 **Fix the `short_description`: "electric fryer" → gas fryer.** The machine has no
   electrical connection at all; the record's own description already says gas seven times.
   This is the only change in the pass that could cause a wrong purchase — §4.1
2. 🔴 Add **12 litres** capacity — the defining spec of the model, currently absent from the
   record entirely (name, description and spec table) — §4.4
3. 🟠 Add the gas detail a Kenyan buyer needs: **butane G30 / propane G31 / natural gas
   G20-G25; ships LPG-jetted (Ø1.10) with NG jets (Ø1.55) in the box; 1/2" connection;
   16.3 m³/h combustion air; 10 cm wall clearance** — §4.1, §4.4
4. 🟠 Add **overall height 565 mm including flue and feet** to the spec table, keeping
   `height: 325` (body) in the numeric field — §4.3
5. 🟡 Add: 34 kg, 2 burners, temperature range **100-190 °C** (positions 1-8), max **2 kg**
   food load, safety thermostat, box contents (**piezo AA battery not supplied**), 18 kg/h
   output, packaging 600 × 445 × 755 mm / 38 kg, optional **MS-RFG 12** stand — §4.4
6. 🟡 Add `meta_description`; strip the `ql-align-justify` Quill markup; restructure to the
   prose + `<h3>Key Features</h3>` + `<table>` pattern — §5
7. ⚪ **Needs a decision:** the `name` "Fryer Roller Grill RFG 12" states no fuel, which is
   how the "electric" error survived. Suggest **"Gas Fryer 12 Ltr Roller Grill RFG 12"** — §4.1
8. ⚪ **No `model_number` change.** `RFG 12` matches Roller Grill's commercial reference; the
   `RFG 12 B` seen on engineering documents is a production index for the same machine — §4.2

**IMG/HOT/00099 (GR 80 E)**

1. 🔴 Fix the `width`/`height` transposition **and** the wrong height value:
   `length: 580, width: 1085, height: 660` → **`length: 580, width: 660, height: 1035`**.
   1085 mm appears in no source anywhere — §3.2
2. 🔴 Replace **"Volts : 380 v"** with **380-415 V 3N~, 50/60 Hz, ~6.3 A per phase**, and
   state plainly that the machine **requires a three-phase supply and fixed wiring by a
   qualified electrician**. Kenya's 415 V 3N 50 Hz is inside the manufacturer's band, so the
   machine is suitable — but the record currently gives no hint that it is three-phase — §3.3
3. 🟠 Add: **spit height 800 mm**, 5 × **Incoloy 1450 W / 230 V** elements, sliding lockable
   element carriage, manual spit rotation via removable pin, **built-in socket for an
   electric carving knife**, 10 cm wall clearance, CE / IEC 60335-2-48 conformity — §3.4
4. 🟡 Add the accessory list (splash bib, side reflectors, panoramic glass doors, knife
   holder, electric knife, **BG 1** 4-spit set, **BG 4** 12-skewer set, meat shovel) — §3.4
5. 🟡 Move weight 35 kg / capacity 40 kg out of the description bullets into a proper spec
   table; add `meta_description`; restructure to the standard pattern — §5
6. 🟡 Broaden the copy to cover **gyros / kebab / doner** as well as shawarma — §3.5
7. ⚪ Normalise the `.jfif` image to `.jpg` when the higher-resolution file is adopted — §3.5
8. ⚪ **No `model_number` change.** `GR80E` is the closed-up form Roller Grill itself uses in
   filenames and the whole trade uses in listings; `GR 80 E` is the spaced catalogue form.
   Convention difference, not an error — §3.1

**`brands.json`** — no change required; `https://www.rollergrill-international.com/en/`
returns HTTP 200 and is the correct language root. Optionally enrich the description with
**"family-run French manufacturer since 1947, based in Bonneval (Eure-et-Loir), 100% French
production, 350+ products, sold in over 100 countries"** — §1.
