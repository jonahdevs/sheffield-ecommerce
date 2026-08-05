# Broaster / Geneva / Rimpar Product Research

Research notes behind a combined **BROASTER (3 SKUs) + GENEVA (2 SKUs) + RIMPAR (4 SKUs)**
audit pass on `products.json` (July 2026).

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema, Santos, Steelology and Baron passes before a scope
decision.

**Session note:** the `WebSearch` budget for this session was already exhausted (200/200)
before this pass started, so **not a single general web search was available**. Everything
below was obtained by direct `curl`/`WebFetch` against named hosts, by the WordPress REST
API on `broaster.com`, by reading manufacturer PDFs with the `Read` tool, and — where the
web gave nothing — by internal cross-catalogue evidence and pixel-level comparison of the
images already in `storage/`. Anywhere a claim rests on internal evidence rather than a
third-party source, it says so. Broaster came out extremely well despite this (its own
manuals answered every question); Rimpar came out thin, as the brief expected.

Per the brief, **`sheffieldafrica.com` was not used as a source for any spec or image.**

---
---

# PART 1 — BROASTER

## 1.1 Brand identification — confirmed, unambiguous

**Broaster Company**, 2855 Cranston Road, **Beloit, WI 53511-3991, USA** — the address
printed on the footer of every page of both official spec sheets and both manuals. Broaster
is the originator of the pressure-frying process and the `Broaster®` / `Broasted®` /
`Genuine Broaster Chicken®` trademark programme.

- https://broaster.com/
- https://broaster.com/equipment-categories/pressure-fryers/
- https://broaster.com/equipment/broaster-pressure-fryer-1600/
- https://broaster.com/equipment/broaster-1800/

`brands.json` has `slug: broaster`, `website_url: https://www.broaster.com`. **This is
correct and live** (`www.` 200s and redirects to the apex `https://broaster.com/`). No
`brands.json` URL change needed. The existing description ("leading manufacturer of pressure
fryers and foodservice equipment… innovative cooking systems and food programs") is accurate
— it could optionally gain "**American (Beloit, Wisconsin)**", which is the provenance
detail other brand entries carry.

All three catalogue SKUs were located in Broaster's own live equipment catalogue and matched
to Broaster's own current spec sheets (both **Rev 8/24**), so the brand attribution on all
three records is correct.

### Traps found on `broaster.com`

1. **Cloudflare rate-limits `curl` aggressively.** The first fetch of each equipment page
   succeeded; repeat fetches within a minute returned a 5,493-byte "Attention Required!"
   Cloudflare interstitial that *looks like a page* and silently contains no product data.
   `WebFetch` was unaffected and is the reliable route for HTML.
2. **The PDFs are not behind Cloudflare** — `wp-content/uploads/*.pdf` fetched cleanly with
   `curl` every time.
3. **The WordPress REST API is open** and is the only reliable way to enumerate assets:
   `https://broaster.com/wp-json/wp/v2/media?search=<term>&per_page=60`. It exposes the full
   manual/spec-sheet library (installation, operator, service and parts manuals, several
   revisions deep) that is not linked from the product pages.
4. **PDF datasheets do not extract via `WebFetch`** — same trap as the Santos and Baron
   passes. The `Read` tool renders them correctly, including the dimensioned drawings, which
   were decisive here.
5. `https://broaster.com/equipment/pressure-fryers` 404s; the working category path is
   `/equipment-categories/pressure-fryers/`.

### Official documents obtained

| Document | URL |
|---|---|
| 1600 spec sheet (96896 RevH 8/24) | https://broaster.com/wp-content/uploads/Broaster1600_SpecSheet8_2024.pdf |
| 1800 spec sheet (8/24) | https://broaster.com/wp-content/uploads/Broaster1800_SpecSheet8_2024.pdf |
| **Installation manual #17268 (rev 11/22)** — the export-electrical source | https://broaster.com/wp-content/uploads/17268-0-1600_1800-ST-Install-Man-rev-11-22.pdf |
| Parts manual #17271 (rev 06/26) | https://broaster.com/wp-content/uploads/17271-0-1600_1800-ST-Parts-Manual-rev-06-26-1.pdf |
| Operator manual #17269 (rev 04/25) | https://broaster.com/wp-content/uploads/17269-0-1600_1800-ST-Oper-Man-rev-04-25-1.pdf |
| Service manual #17270 (rev 05/25) | https://broaster.com/wp-content/uploads/17270-0-1600_1800-ST-Serv-Manual-rev-05-25-1.pdf |

---

## 1.2 ⚠ THE HEADLINE FINDING — the US-vs-export electrical verdict

**Yes, a genuine export variant exists, it is a separately-designated model, and it is
documented at exactly the voltages Kenya uses. The catalogue is currently silent on it for
two SKUs and carries a bare US figure on the third.**

### 1.2.1 Broaster publishes three distinct **export** model designations

Buried in the installation manual's table of contents and its wiring-diagram sections
(never on the spec sheets, never on the website) is a dedicated **EXPORT** block:

| Manual section | Export model | Wiring-diagram caption |
|---|---|---|
| 3-5 | **`1600XP`** Smart Touch | "1600XP 208 or 240VAC" |
| 3-6 | **`1800EXP`** Smart Touch | "1800EXP 208 or 240VAC" |
| 4-3 | **`1800GHXP`** | "1800GHXP Wiring Diagram" |

`1800GHXP` additionally has **its own parts section (7-4) in the parts manual** — it is a
separately stocked build, not a field-modified US unit.

So the three catalogue SKUs, if actually supplied into Kenya, are **`1600XP`**,
**`1800EXP`** and **`1800GHXP`** — not `1600E`, `1800E`, `1800G`.

### 1.2.2 The electric models were already 50 Hz-territory capable — and the spec sheet hides it

The **spec sheets** list 60 Hz only, because they are US sales documents:

> **1600** — 6 kW rated heating elements: 1 ph 208 V 60 Hz 29 A · 1 ph 240 V 60 Hz 25 A ·
> 3 ph 208 V 60 Hz 17 A · 3 ph 240 V 60 Hz 15 A
> **1800E** — 9.9 kW rated heating elements: 1 ph 208 V 60 Hz 48 A · 1 ph 240 V 60 Hz 45 A ·
> 3 ph 208 V 60 Hz 28 A · 3 ph 240 V 60 Hz 26 A

The **installation manual** (§3-1) tells the fuller story — *"These models are available for
either 208, 240 or 480 applied voltage, 60 Hz, 3 phase electrical connection in the USA
**and several voltages for export applications**"* — and its Suggested Wiring Capacity
tables carry rows the spec sheet omits entirely:

| | 1600 (6 kW) | 1800E (9.9 kW) |
|---|---|---|
| 1 ph 220 V | 28 A, #8, 40 A breaker | 50 A, #8, 60 A |
| 1 ph 230 V | 26 A, #8, 40 A | 43 A, #8, 60 A |
| **1 ph 240 V** | **25 A**, #8, 40 A | **45 A**, #8, 60 A |
| 3 ph 220/380 V | 10.2 A, #10, 15 A | 16.8 A, #10, 20 A |
| 3 ph 230/400 V | 8.7 A, #10, 15 A | 14.3 A, #10, 20 A |
| **3 ph 240/415 V** | **9.1 A**, #10, 15 A | **15 A**, #10, 20 A |

**`240 V single-phase` and `240/415 V three-phase` are precisely the Kenyan supply.** The
elements are resistive, so 50 Hz vs 60 Hz is electrically irrelevant to them; the frequency
question only bites on motors and controls, which is the next point.

### 1.2.3 ⚠ The gas unit's stored `120 V / 60 Hz` **is** a US-only figure

`IMG/HOT/00333`'s `technical_specification` stores:

> **Ignition/Control Voltage** — `120 V / 60 Hz`

That is lifted straight from the US spec sheet ("1800GH — 65,000 BTU Rated Burner Assembly;
1 phase, **120 volt, 60 hz**, Pump Motor Assembly; attached 6 ft. cord with plug"). The
installation manual §4-2 gives the export figure:

> "The Model 1800GH is available for **120 VAC applied voltage, 15 amp, 60 Hz, 1 phase**
> electrical connection **in the USA** and **120 VAC or 220 VAC applied voltage, 15 amp,
> 50/60 Hz, 1 phase** electrical connection **for export applications**."

This is the **same class of error** as Blodgett's stored 208 V/60 Hz single-phase, Goodwill's
120 V/1450 W and Antunes' 13 A, and it is worse here because it is load-bearing: the 120 V
circuit drives the **filtration pump motor** and the ignition/control system, i.e. the one
part of the gas fryer that genuinely cares about both voltage and frequency. A Kenyan buyer
reading `120 V / 60 Hz` would budget for a step-down transformer that the correct
`1800GHXP` build does not need.

**Recommended stored value: `220 VAC, 15 A, 50/60 Hz, 1 phase (export build)`**, with the
US 120 V figure either dropped or explicitly labelled "US domestic".

### 1.2.4 The gas side has a documented EU/export configuration too

Installation manual §4-4 splits gas ratings by market — the first hard confirmation that
Broaster builds a non-US variant of this machine at all:

| | US & Canada | **EU / export** |
|---|---|---|
| Rating | Natural Gas 65,000 BTU · Propane 65,000 BTU | **G20 19.2 kW gross · G31 19.2 kW gross** |
| Max supply pressure | — | Natural (G20) 7″ wc (**20 mbar**) · Propane (G31) 14″ wc (**37 mbar**) |
| Test-fitting pressure | — | G20 3.5″ wc (8.7 mbar) · G31 10.0″ wc (25 mbar) |
| Main burner orifice | #24 drill / #41 drill | **3.9 mm (G20) / 2.4 mm (G31)** |
| Pilot orifice | 0.018″ / 0.011″ | **0.46 mm / 0.27 mm** |
| Gas conversion | via Broaster rep | **"Units manufactured for use in the EU are not convertible from one type of gas to another."** |

**Plausibility check:** 65,000 BTU/hr = 19.05 kW, against the EU-stated 19.2 kW gross. The
two figures agree to within 1% — this is one rating expressed twice, not a dropped digit.
(Contrast the 350 °C oven stored at 800 W from an earlier pass.) The stored `65,000 BTU` is
sound; for a Kenyan listing the **19.2 kW** figure is more useful and the 20/37 mbar
pressures and mm orifices are the ones an installer here will actually be handed.

Both spec sheets also carry a **CE mark** alongside the UL/NSF marks — independent
corroboration that a European-conformity build exists.

### 1.2.5 Verdict, stated plainly

| Question from the brief | Answer |
|---|---|
| Are these US 208-240 V / 60 Hz machines? | The **US builds** are, yes. |
| Does an export/50 Hz variant exist? | **Yes** — `1600XP`, `1800EXP`, `1800GHXP`, each with its own wiring diagram, and `1800GHXP` with its own parts list. |
| At Kenyan voltages? | **Yes** — 240 V 1 ph and 240/415 V 3 ph are tabulated for both electric models; 220 VAC 50/60 Hz for the gas model's controls. |
| Does the stored record contain a US figure? | **Yes, once** — `IMG/HOT/00333`'s `120 V / 60 Hz`. The two electric SKUs store **no** voltage at all (so no wrong figure, but also no usable one). |

---

## 1.3 ⚠ All three Broaster records have `width` and `height` transposed

Checked **per SKU**, as instructed, against the official dimension tables — and in all three
cases the record's own **prose** `technical_specification` is correct while the **numeric**
fields are not. This is the fourth-plus brand showing the same recurring import bug (Brema,
Santos, Empero, Baron), and once again *the prose has been right every time*.

| SKU | Stored `length` | Stored `width` | Stored `height` | Stored prose | **Official Broaster (W × D × H)** | Verdict |
|---|---|---|---|---|---|---|
| IMG/HOT/00332 (1600) | 406 | **1088** | **737** | "406 × 737 × 1088 mm (L × W × H)" | 16″ **406** × 29″ **737** × 42-3/4″ **1088** | `width`/`height` **swapped** |
| IMG/HOT/00390 (1800E) | 457 | **1152** | **908** | "457 × 908 × 1152 mm (L × W × H)" | 18″ **457** × 35-3/4″ **908** × 45-3/8″ **1152** | `width`/`height` **swapped** |
| IMG/HOT/00333 (1800G) | 457 | **1152** | **908** | "457 × 908 × 1152 mm (L × W × H)" | as above (one shared row) | `width`/`height` **swapped** |

Using this catalogue's convention (`length` = frontage width, `width` = depth,
`height` = height), the corrected numerics are:

- **IMG/HOT/00332** → `length: 406`, `width: 737`, `height: 1088`
- **IMG/HOT/00390** and **IMG/HOT/00333** → `length: 457`, `width: 908`, `height: 1152`

**Independent sanity check that settles it without the spec sheet.** Broaster's own 1600
page advertises *"only **3.2 square feet** of floorspace under the hood."* 406 mm × 737 mm =
0.299 m² = **3.22 sq ft** — exact. 406 × 1088 (the stored `length` × `width`) would be
0.442 m² = 4.75 sq ft, which contradicts Broaster's own marketing claim. The stored `width:
1088` is also physically absurd as a *depth* for a machine whose own drawing gives a 1254 mm
top-view envelope including the filter pan. The prose is right; the numerics are wrong.

---

## 1.4 IMG/HOT/00332 — Pressure Fryer Electric Broaster 1600

Official spec sheet: https://broaster.com/wp-content/uploads/Broaster1600_SpecSheet8_2024.pdf
Official page: https://broaster.com/equipment/broaster-pressure-fryer-1600/

### 1.4.1 What checks out

Confirmed correct against the official spec sheet — no change needed:

- **21 lb cooking-oil capacity** ✓ · **12-14 PSI** operating pressure ✓ · **6 kW** ✓
- **7 lbs/load, 40 lbs/hour** fresh chicken ✓
- Round, **fully welded 300 Series stainless steel** cooking well ✓
- Built-in filtration: **1/3 HP motor, 5 GPM rotary gear displacement oil pump**, no heated
  fittings to disconnect ✓
- SmartTouch touch-screen controller, Auto-Comp, automatic cook-cycle counter ✓
- Triple-redundant safety system; pressure-activated single-action cam-lock cover ✓
- Warranty **1 yr parts & labour / +1 yr controller / 10 yr cooking well** ✓

### 1.4.2 ⚠ `model_number` — Broaster does not use "1600E"

The record stores `BROASTER 1600E`. Across the spec sheet's Model column, the Energy
Requirements block, the drawing legend ("MODEL 1600"), and both manuals, Broaster's
designation is simply **`1600`** — a regex sweep of the installation and parts manuals found
**19 + 69 occurrences of `1600` and zero occurrences of `1600E`**. The 1600 is
**electric-only** (the manual's section 3 is titled "1600/1800E INSTALLATION"; section 4,
the gas section, covers the 1800GH alone), so there is no gas sibling for an "E" suffix to
disambiguate from. The only suffixed 1600 that exists is the export **`1600XP`**.

**Flagged, not changed**, per [[feedback_model_number_unique_id]]. If Sheffield's own stock
code is `BROASTER 1600E`, leave it — but be aware it will not match anything Broaster or a
Broaster distributor recognises. `1600` or `1600XP` are the traceable codes.

### 1.4.3 ⚠ Broaster contradicts itself on chicken pieces — and the record picked the right one

| Source | Pieces per load |
|---|---|
| Broaster **web page** for the 1600 | "cooks up to **16 pieces** of fresh bone-in chicken per load in as little as 10 minutes" |
| Broaster **spec sheet** (96896 RevH 8/24), Standard Features | "cooks up to **20 pieces** of fresh bone-in chicken per load in as little as 10 minutes" |
| **Our record** (`description` + `meta_description`) | **16 pieces** |

Two first-party Broaster sources disagree. **The record's 16 is the better-supported figure**
and should be left alone: the spec sheet's own Dimensions table gives the 1600 as
**7 lbs/load**, and 16 pieces at ~0.44 lb/piece = 7.0 lbs, whereas 20 pieces would be
~8.8 lbs and overshoot Broaster's own load rating. (The same arithmetic validates the 1800:
40 pieces × ~0.35 lb = 14 lbs/load ✓.) So the *spec sheet* is the outlier here, not us —
the same shape of "own-source is wrong, record is right" resolution the Steelology pass
reached on `RH002`. Worth recording precisely because it's the exception.

### 1.4.4 ⚠ One description claim not supported by the SmartTouch spec

The `description` says the controller *"stores up to 10 pre-programmed cook cycles"*, and
`technical_specification` repeats "up to 10 programmable cook cycles". Broaster's SmartTouch
copy says only *"a large 7″ VGA full colour touch screen… a library of various menu items"*
and *"a programmable library with preloaded menu items"* — **no count of 10 anywhere**.

The "10" almost certainly traces to the **older, non-SmartTouch control panel** whose legend
appears in the drawing block of the same spec sheet: *"Press desired number **0 thru 9**
twice to select preset cycle"* — a 10-preset keypad control. It is a plausible number for a
different controller, not a documented SmartTouch figure. Recommend softening to "programmable
menu library" and adding the **7″ VGA full-colour touch screen** detail, which *is*
documented and is currently missing.

### 1.4.5 Confirmed by the spec sheet but **absent from the record**

- **Cooking well diameter: 10 inches** (this is the real 1600-vs-1800 differentiator — the
  1800's well is 12″)
- **Maximum temperature 375 °F (191 °C)**
- **Counter height 35-7/8″ (914 mm)**; drawing gives 35-7/8″ [910 mm]
- **Net / ship weight 195 / 216 lbs (88.5 / 98 kg)**; cubes 16.53
- Clearance envelope from the drawing: **overall depth with cover open 42-5/8″ [1083 mm]**,
  side-view 30″ [762 mm] body, **top-view 49-3/8″ [1254 mm] including the filter pan**,
  filter pan 19-3/8″ [490 mm]
- Powder-coated welded tubular steel frame; stainless top and side panels
- **Chrome-plated front levelling feet; rear legs on casters** (electric build)
- Stainless basket with **ratchet-style removable handle**
- Certifications: **CE**, cULus listed, **tested to ANSI/NSF 4** and ANSI/UL 197 10th Ed. /
  C22.2 No. 109-M1981
- "No cord/plug provided" — hard-wired
- Accessory: **Basic Accessory Kit**
- Electrical: see §1.2.2 — nothing at all is currently stored

---

## 1.5 IMG/HOT/00390 — Pressure Fryer Electric Broaster 1800

Official spec sheet: https://broaster.com/wp-content/uploads/Broaster1800_SpecSheet8_2024.pdf
Official page: https://broaster.com/equipment/broaster-1800/

### 1.5.1 The brief's cross-contamination question — answered per field

The 1800E and 1800GH **are the same body in electric vs gas**, and Broaster's spec sheet
puts them on **one shared row** of the Dimensions table. So most identical values in our two
records are *correct*, not copy-paste damage:

| Field | 1800E stored | 1800G stored | Broaster | Verdict |
|---|---|---|---|---|
| Dimensions | 457 × 908 × 1152 | 457 × 908 × 1152 | one shared row | **Correctly shared** (but both axis-swapped in the numerics — §1.3) |
| Oil capacity | 42 lbs | 42 lbs | 42 lbs, shared | **Correctly shared** |
| Operating pressure | 12-14 PSI | 12-14 PSI | shared | **Correctly shared** |
| Chicken capacity | 14 lbs/load, 80 lbs/hr | 14 lbs/load, 80 lbs/hr | shared | **Correctly shared** |
| Well material / filtration / controller | identical | identical | shared | **Correctly shared** |
| Energy | **9.9 kW electric** | **65,000 BTU gas + 120 V control** | genuinely different | **Correctly distinct** ✓ |
| **Net / ship weight** | *(absent)* | *(absent)* | **1800E 219/254 lb · 1800GH 256/291 lb** | **The one genuinely distinct spec Broaster publishes — and neither record carries it** |
| **Rear support** | *(absent)* | *(absent)* | **"WHEEL on 1800E · GLIDE on 1800GH"** (drawing note) | Missing from both |
| **Product image** | ← same file → | ← same file → | — | ⚠ **Genuinely cross-contaminated — see §1.5.2** |

So: the *text* is clean and the shared values are legitimately shared. The *image* is not.

### 1.5.2 ⚠⚠ The 1800E record shows a **gas** machine

`storage/app/public/products/pressure-fryer-electric-broaster-1800-imghot00390.jpg` and
`pressure-fryer-gas-broaster-1800-imghot00333.jpg` are **byte-identical**
(md5 `7e4826229de250a3525ac7a36e5dba92`, both 1512 × 1512, 98,935 bytes) — one file serving
two SKUs.

Zooming the data plate on that shared image resolves which unit it actually is: it reads
**`MODEL 1800GH`**, and the panel below it carries a **"MANUAL SHUTOFF VALVE LOCATED BEHIND
THIS PANEL"** sticker. Both are gas-only features. The same photograph appears on the cover
of Broaster's own parts manual and inside the 1800 spec sheet, in both cases showing the same
`MODEL 1800GH` plate.

**The electric SKU `IMG/HOT/00390` is currently illustrated with the gas 1800GH.** Correct
for `IMG/HOT/00333`; wrong for `IMG/HOT/00390`.

**And it cannot easily be fixed with a better download**, because — checked exhaustively —
**Broaster does not publish a photograph of the 1800E anywhere**. Every 1800 image on
`broaster.com`, in the spec sheet, in the parts manual, in the operator manual and in the
service manual is the same 1800GH unit. The honest options are: (a) accept the shared image
with a note, (b) crop out the data plate, or (c) request an 1800E photo from the distributor.
Flagged, not resolved.

### 1.5.3 Confirmed but absent from the record

Everything in §1.4.5 that is shared across the range, plus 1800-specific:

- **Cooking well diameter: 12 inches**
- **Net / ship weight 219 / 254 lbs (99.3 / 115.2 kg)**; cubes 20.6
- Counter height — see the typo note in §1.5.4
- Clearance envelope: **side view 47-1/2″ [1207 mm]** overall with cover swung,
  **11-7/8″ [300 mm]** cover-open projection, **top view 58-7/8″ [1485 mm]** including the
  filter pan, filter pan 23-1/8″ [585 mm], **33″ [838 mm]** across
- **Rear legs fitted with casters** (the 1800E's "WHEEL"); chrome-plated front levelling feet
- **7″ VGA full-colour touch screen**; max temperature **375 °F (191 °C)**
- **CE**, cULus, ANSI/NSF 4, ANSI/UL 197 10th Ed. **& ANSI/UL 1889**
- Export designation **`1800EXP`**; electrical per §1.2.2 (nothing currently stored)

### 1.5.4 A typo in Broaster's own spec sheet, noted so nobody copies it

The 1800 Dimensions table gives **Counter Height "37-5/8″ (910 mm)"**. Those two figures do
not agree — 37-5/8″ is 955 mm, and 35-7/8″ is 911 mm. Broaster's **own drawing on the same
page** labels the counter height **35-7/8″ [910 mm]**, and the 1600 sheet's equivalent row
reads 35-7/8″. **The inch figure is the typo; use 35-7/8″ / 910 mm.** Not our error, but it
would become ours the moment it is transcribed.

---

## 1.6 IMG/HOT/00333 — Pressure Fryer Gas Broaster 1800

Same spec sheet and page as §1.5.

### 1.6.1 ⚠ `model_number` — Broaster's designation is `1800GH`, not `1800G`

The record stores `BROASTER 1800G`. Broaster's marketed and **nameplate** designation is
**`1800GH`** — it appears 23 times in the installation manual, 23 times in the parts manual,
in the spec sheet's Model column, in the Energy Requirements block, on the drawing legend,
and physically stamped on the data plate in the product photo.

`1800G` *does* occur 6 times in the parts manual — but **only inside component descriptions**
("BOX WELD-CONTROL,1800G,2400G", "ORIFICE #24 MAIN 1800G NAT", "WELL WELD- COOKING, 1800G").
It is Broaster's internal parts shorthand for the gas build, not a model a distributor would
quote against. The export designation is **`1800GHXP`**.

**Flagged, not changed**, per [[feedback_model_number_unique_id]]. Unlike Baron's `SE40/OCB`
letter-O-for-zero, this is not a transcription slip so much as a truncation, but it has the
same consequence: the stored code will not match Broaster's catalogue.

### 1.6.2 What checks out, and what needs the export figure

Correct: 42 lb oil ✓, 12-14 PSI ✓, **65,000 BTU** ✓, 14 lbs/load & 80 lbs/hour ✓, well
material ✓, filtration ✓, controller ✓, warranty ✓, dimensions in prose ✓.

**Wrong for this market: `Ignition/Control Voltage 120 V / 60 Hz`** — see §1.2.3.

Absent: **net / ship weight 256 / 291 lbs (116.1 / 132 kg)** (the heaviest single distinction
from the 1800E); **1/2″ NPT gas connection**; **attached 6 ft cord with plug** (US build only —
the export build's supply is different); main burner orifice **#24 / 3.9 mm (natural)**,
**#41 / 2.4 mm (LP)**; pilot orifice **0.018″ / 0.46 mm** and **0.011″ / 0.27 mm**; EU gas
data per §1.2.4; **rear legs fitted with stainless steel feet ("GLIDE"), not casters**;
high-altitude derate (−4% gas input per 1,000 ft above 2,000 ft — relevant, Nairobi is
~5,900 ft, so this is a real ~15% derate and a real orifice-resize conversation, not a
footnote); *"DO NOT extend the exhaust stack or exhaust flue"*; NFPA 96 hood requirement.

**The altitude point deserves emphasis.** Broaster's instruction is unambiguous —
*"For operation at elevations above 2,000 feet above sea level, gas input must be reduced 4%
for each 1,000 feet. Contact your local Broaster Company representative for correct orifice
sizing."* Nairobi at ~1,795 m (5,889 ft) sits ~3,900 ft above that threshold, i.e. a
**~15.6% derate** and a different orifice. Nothing in the record mentions it, and it materially
changes the effective output a Nairobi customer gets from a 65,000 BTU rating.

### 1.6.3 Price ordering, noted only

`1800G` is priced **above** `1800E` (KSh 3,680,000 vs 3,622,500). Gas builds are usually at or
below the electric equivalent, so this is mildly counter-intuitive — but the 1800GH is
genuinely 37 lbs heavier net and 37 lbs heavier shipped, and freight to Mombasa is priced by
volumetric/actual weight, so the ordering is defensible. Flagged for awareness, **not**
asserted as an error.

---

## 1.7 Broaster — recommended changes (none applied)

**Tier 1 — corrections, evidence is unambiguous**

1. **Fix the `width`/`height` transposition on all three SKUs** (§1.3):
   `00332` → 406 / 737 / 1088; `00390` and `00333` → 457 / 908 / 1152.
2. **Replace `IMG/HOT/00333`'s `120 V / 60 Hz`** with the export figure
   **`220 VAC, 15 A, 50/60 Hz, 1 phase`** (§1.2.3), or label the US figure as US-domestic.
3. **Add electrical data to the two electric SKUs**, which currently carry none:
   1600 → **240 V 1 ph 25 A** or **240/415 V 3 ph 9.1 A**, 6 kW;
   1800E → **240 V 1 ph 45 A** or **240/415 V 3 ph 15 A**, 9.9 kW (§1.2.2).
4. **Add the high-altitude gas derate** to `IMG/HOT/00333` (§1.6.2) — −4% per 1,000 ft above
   2,000 ft, i.e. ~15.6% at Nairobi altitude, orifice resize required.

**Tier 2 — enrichment from the official sheets**

5. Add per §1.4.5 / §1.5.3 / §1.6.2: well diameter (10″ / 12″ / 12″), max temp 375 °F (191 °C),
   counter height 910 mm, net & ship weights (**88.5/98 · 99.3/115.2 · 116.1/132 kg**),
   7″ VGA touch screen, clearance envelopes, CE / cULus / ANSI-NSF 4, hood requirement,
   frame & panel construction, ratchet basket handle, casters vs glides, Basic Accessory Kit.
6. **Soften the "up to 10 programmable cook cycles" claim** (§1.4.4) — undocumented for
   SmartTouch; replace with the documented 7″ VGA programmable menu library.
7. Add `EU gas data` (19.2 kW G20/G31, 20/37 mbar, mm orifices, non-convertible) to
   `IMG/HOT/00333` (§1.2.4).

**Tier 3 — needs a decision or a supplier answer**

8. **`model_number` decisions** (all flagged, none changed):
   `BROASTER 1600E` → Broaster says **`1600`** (or **`1600XP`** export) — §1.4.2;
   `BROASTER 1800G` → Broaster says **`1800GH`** (or **`1800GHXP`** export) — §1.6.1;
   `BROASTER 1800E` is correct as-is (export **`1800EXP`**).
9. **Confirm with the supplier which build was actually imported** — US or XP. Everything in
   Tier 1 items 2-3 depends on the answer, and it is a single question to the distributor.
10. **The 1800E image problem** (§1.5.2) — the electric SKU currently shows a `MODEL 1800GH`
    data plate, and no 1800E photograph exists in any Broaster asset. Needs a distributor
    photo, a crop, or an accepted note.
11. Leave the "16 pieces" figure alone (§1.4.3) — it is better supported than Broaster's own
    spec sheet's "20".

---
---

# PART 2 — GENEVA

## 2.1 ⚠ GENEVA has no `brands.json` entry at all

Checked directly: `brands.json` contains **no `geneva` slug** (and no entry under any casing).
Yet two `published` SKUs carry `brand: "GENEVA"`. This is the missing-brand problem flagged in
[[project_brand_name_casing]] — a live storefront brand string with no brand record behind it,
so no logo, no description and no `website_url`.

No real manufacturer named "Geneva" making commercial pressure cookers was found, and — per
§2.2 — the evidence says none should be looked for, because the physical product is branded
something else entirely.

---

## 2.2 ⚠⚠ CONFIRMED — the Geneva units **are** the same "Time Saver" line, and it is now externally corroborated

The Steelology pass established this from one photo. This pass **confirms it, extends it, and
adds the first external source**.

### 2.2.1 All four SSPC records share **one photograph** — verified pixel-by-pixel

| SKU | Capacity | `model_number` | Catalogue brand | Image file |
|---|---|---|---|---|
| IMG/HOT/00167 | 16 L | `SSPC-16` | **STEELOLOGY** | `pressure-cooker-16-litres-sspc-16-imghot00167.jpg` |
| IMG/HOT/00168 | 25 L | `SSPC-25` | **HK-REDLINE** | `pressure-cooker-25-litres-h-kitchen-sspc-25-imghot00168.jpg` |
| IMG/HOT/00169 | 40 L | `SSPC-40` | **GENEVA** | `pressure-cooker-40-litres-imghot00169.jpg` |
| IMG/HOT/00170 | 60 L | `SSPC-60` | **GENEVA** | `pressure-cooker-60-litres-imghot00170.jpg` |

Results of a pixel comparison of all four (all 600 × 600):

- **16 L and 25 L are byte-for-byte identical** (same md5, same 18,437 bytes).
- **40 L and 60 L are pixel-identical** (`ImageChops.difference` bbox = `None`; 25,557 bytes
  each; md5s differ only by JPEG metadata).
- **The 16/25 pair and the 40/60 pair are the *same photograph at a different scale*.**
  Cropping each to its non-white bounding box (`136,139→441,446` vs `103,104→493,498`),
  resampling both to 400 × 400 and differencing gives a **mean absolute error of 5.6/255
  (2.2%)** — the residual you get from JPEG plus resampling, not from two different pictures.
  The only difference between the two files is how large the pot is drawn on the canvas.

**So four SKUs, three brand strings and four different capacities are all illustrated by a
single photograph of a single physical pot.** No capacity information can be read off any of
these images, and nothing about the 40 L record distinguishes it from the 60 L record.

### 2.2.2 The pot is stamped "Time Saver" — and Time Saver is a real, findable brand

Both Geneva images were opened and inspected. The pot carries a **blue-and-red diamond
"Time Saver™" logo** on the body — the same stamp the Steelology pass found on `SSPC-16`,
which is unsurprising given §2.2.1, but it is now **externally corroborated for the first
time**:

> **Time Saver** — Indian brand of ISI-marked commercial hard-anodised aluminium
> outer-lid "handi" pressure cookers, sold in **exactly the 30 L / 40 L / 60 L ladder**,
> attributed to **Praveen Enterprises**, with a "deluxe pressure dial gauge".
> https://pricehistoryapp.com/product/time-saver-isi-mark-commercial-hard-anodized-aluminum-outer-lid-handi-pressure-cooker-silver-40-liter
> https://www.amazon.in/Time-Saver-Commercial-Aluminium-Cooker/dp/B075GW1S99 (40 L)
> https://www.amazon.in/Time-Saver-Commercial-Aluminium-Cooker/dp/B075GYCDL3 (60 L)
> https://www.flipkart.com/timesaver-isi-mark-commercial-hard-anodized-40-l-pressure-cooker/p/itmccd5defbafecb
> https://vadiraja.com/product/time-saver-isi-mark-commercial-hard-anodized-aluminum-handi-pressure-cooker-silver-30l/

**And the decisive piece:** the Amazon India product image for the **40 litre** Time Saver
unit was downloaded at 1271 × 1280 and opened —
https://m.media-amazon.com/images/I/71GMcTYA24L.jpg — and it is **visually the same product
as the catalogue photo**: identical blue-diamond `Time Saver™` wordmark in the same position
on the body, identical geared pressure gauge, identical cast clamp-and-lug lid ring, identical
loop side handles, identical vertical highlight streak down the polished body.

**This is an independent, non-Sheffield source that (a) confirms the brand stamp, (b) confirms
the 40 L capacity, and (c) confirms the line is sold in the 40 L and 60 L sizes our two Geneva
SKUs claim.** It is the strongest external corroboration any of the four SSPC records has had.

### 2.2.3 The brand-consolidation finding, restated

`SSPC-<litres>` is a **single generic-OEM product line — Time Saver commercial pressure
cookers — sold under three different storefront brand strings** in this catalogue:

- `STEELOLOGY` = the 16 L tier
- `HK-REDLINE` = the 25 L tier (a house label with **102 SKUs** behind it)
- `GENEVA` = the 40 L and 60 L tiers

The literal phrase *"Timesaver Pressure Cooker"* already appears verbatim in the `description`
of `SSPC-25`, `SSPC-40` and `SSPC-60` — the catalogue has effectively been telling us the
real brand all along, in the description field, while showing a different brand in the `brand`
field. Confirming or refuting was this pass's remit: **confirmed.**

**This affects 4 SKUs across 3 brand strings, one of which (`GENEVA`) does not exist in
`brands.json` at all** (§2.1).

---

## 2.3 ⚠ The stored material is probably wrong — aluminium, not stainless steel

Both Geneva `short_description`s open "**GENEVA stainless steel pressure cooker** 40/60
litres". Every external listing for the Time Saver line describes it as **hard-anodised /
heavy-gauge aluminium** ("warp-resistant, heavy-gauge aluminum for fast, even heating"), never
stainless. The 16 L and 25 L siblings carry the same "stainless steel" phrasing.

Two caveats, stated honestly:

1. The photograph shows **bright polished silver metal**, which is what polished aluminium
   looks like — but hard-anodised aluminium is normally dark grey/black, so **the source
   listings are internally inconsistent with their own photo too**. Indian marketplace titles
   routinely stack incompatible material words.
2. `SSPC` most plausibly decodes as "**S**tainless **S**teel **P**ressure **C**ooker", which
   would make the code itself assert stainless. If so, either the code or the product is
   mislabelled — but the code may equally be a Sheffield stock prefix with no such meaning.

**Verdict: the "stainless steel" claim is unverified and more likely wrong than right, but it
is not proven wrong.** This is a one-question call to the supplier ("is the body aluminium or
stainless?") and should not be edited on inference. Flagged across all four SSPC SKUs, not
just Geneva.

---

## 2.4 Geometry — nothing is pasted, because nothing is stored

The brief asks whether the 40 L and 60 L have distinct dimensions or pasted ones. The answer
is neither: **all four SSPC records store `length`, `width` and `height` as `null`**, and none
has a `technical_specification`. There is nothing to swap, nothing to compare and nothing to
sanity-check. The width/height transposition bug **cannot be evaluated** on these SKUs — same
situation as Steelology's `00241`/`00277`.

The only thing that *is* duplicated between the 40 L and the 60 L is the **image** (§2.2.1),
and per §2.2.2 that image is specifically the **40 litre** unit — so `IMG/HOT/00170` (60 L) is
currently illustrated by its smaller sibling.

For reference, plausible brim-full geometry for this pot shape (straight-sided cylinder, no
stated capacity to reconcile against, so this is **exploratory, not sourced**):

| Capacity | Plausible Ø | Implied height |
|---|---|---|
| 40 L | ~400 mm | ~318 mm |
| 60 L | ~450 mm | ~377 mm |

An unrelated Indian 60 L aluminium cooker was found quoted at "Inside Dimensions: 18″ Dia. ×
12″ Height" (≈457 × 305 mm), which computes to ~50 L not 60 L — a reminder that these
marketplace figures are not reliable enough to import. **No dimension should be added to
either record without a supplier spec sheet.**

---

## 2.5 ⚠ The price ladder across the four SSPC sizes is non-monotonic

Worth surfacing because it spans three brand strings and is visible without any external
source:

| SKU | Capacity | Price (KSh) | KSh per litre | Qty | Brand |
|---|---|---|---|---|---|
| IMG/HOT/00167 | 16 L | **58,250** | 3,641 | 10 | STEELOLOGY |
| IMG/HOT/00168 | 25 L | **37,990** | 1,520 | 1 | HK-REDLINE |
| IMG/HOT/00169 | 40 L | 97,750 | 2,444 | 2 | GENEVA |
| IMG/HOT/00170 | 60 L | 155,250 | 2,588 | 1 | GENEVA |

**The 25 L is priced KSh 20,260 *below* the 16 L**, despite being the larger unit in the same
OEM ladder. It is also the only one of the four whose price is not a round multiple of 250,
which is the shape of a figure that came from somewhere else. Either the 25 L is
under-priced or the 16 L is over-priced; the 40 L and 60 L sit on a consistent
KSh ~2,450-2,600/litre line and look right relative to each other.

Same class of flag as the Steelology pass's identical-KSh-208,750 pair — **flagged for
whoever owns pricing, not asserted as wrong.**

---

## 2.6 Geneva — recommended changes (none applied)

**Tier 1 — free, no supplier input needed**

1. **Create a `brands.json` entry for `geneva`** or, better, resolve the brand question first
   (item 4) — two `published` SKUs currently reference a brand that does not exist (§2.1).
   **`website_url` should be `null`** either way; no Geneva manufacturer exists to point at.
2. **Sanity-check the KSh 37,990 price on the 25 L sibling** (§2.5) — it undercuts the 16 L.
3. **Note in the record that `IMG/HOT/00170` (60 L) is illustrated by the 40 L unit** (§2.4),
   or accept it explicitly, since only one photograph of this line exists anywhere.

**Tier 2 — needs a supplier answer first**

4. **Decide what to do about the Time Saver consolidation** (§2.2) — the same fork Kitchenware
   and Steelology faced, but now with external corroboration and a named real brand. The
   options are: keep three house labels, or fold all four SSPC SKUs under a single
   **Time Saver** brand with `SSPC-<litres>` retained as the stock code.
5. **Confirm the body material** — aluminium vs stainless (§2.3). One question; affects the
   `short_description` of all four SSPC SKUs.
6. **Obtain dimensions and weights** (§2.4) — nothing is stored for any of the four and
   nothing reliable was findable.

**Tier 3 — noted, no action proposed**

7. No `model_number` change is proposed anywhere, per [[feedback_model_number_unique_id]].
   `SSPC-40` / `SSPC-60` are at least internally consistent and appear to be genuine Sheffield
   stock codes; they are just not manufacturer part numbers.

---
---

# PART 3 — RIMPAR

All four SKUs are `archived`, all four are priced `0`, all four have `quantity: 1`, none has
an `image`, and none has a `description` — only a generated `short_description`. Treated as
the lowest priority of the three brands, as instructed. That said, **more was findable than
expected**, and one concrete `brands.json` error was caught.

## 3.1 ⚠ Brand identified — and the stored `website_url` is a parked domain for sale

### 3.1.1 `https://www.rimpar.com` is not a company website

`brands.json` stores `website_url: "https://www.rimpar.com"`. Fetching it returns a **307
redirect to a GoDaddy "domain for sale" lander**:

```
https://www.rimpar.com  →  307  →  https://forsale.godaddy.com/forsale/www.rimpar.com?...
```

The raw response body is a 114-byte JavaScript redirect stub. This is not a temporary lapse:
the Wayback Machine's CDX index shows `rimpar.com` serving parked/monetised content back to
**June 2017**, with a spam-subdomain sprawl (`analytics.`, `smtpauth.`, `casper.`, `argo.`,
`random.` …) typical of a resold domain. **It has never been this company's site.**

Same class of error as the `redline` entry pointing at `sheffieldafrica.com/brands/redline` —
a `website_url` that will send a customer somewhere actively wrong. **Recommend replacing or
nulling.**

### 3.1.2 The real Rimpar — carpet/rug-washing plant machinery, European origin

Rimpar is a manufacturer of **industrial carpet and rug cleaning plant machinery**. Its
English-language arm is:

> **Rimpar USA Cleaning Systems** — https://rimparusa.com
> info@rimparusa.com · +1 580-467-5177 / +1 580-467-0759 (Oklahoma area code)
> https://www.facebook.com/Rimpar-USA-107714377593882
> https://www.youtube.com/channel/UCRQ3oz9E4s0CYbRhs6hvqbw

Product line: **Carpet Washing Machines · Carpet Dust Removers · Carpet Spinning Machines ·
Carpet Finishing Machines** — i.e. the four stations of a commercial rug-cleaning plant.

**Origin — the brief asked "Turkish or Italian?" The evidence points firmly to Turkish:**

- The About page states *"With **23 years previous experience in Europe**, dedicated
  exclusively to producing and selling carpet cleaning equipment we come on the American
  market"* — the US entity is the new arm of an older European maker.
  https://rimparusa.com/about-us
- The site is built by a **Turkish** agency, credited in the footer: *"Web Design: Tasarımevi"*
  → http://tasarimevi.com.tr
- Its asset paths are Turkish (`/yukleme/` = "upload", `/_tema/` = "theme").
- Industrial rug-washing machinery is a Turkish specialism.

**No Turkish parent domain could be located** (`rimpar.com.tr`, `rimpar.net`, `rimpar.it`,
`rimparkimya.com` all fail to resolve or have no archive history; `rimpar.de` is the Bavarian
municipality of Rimpar, unrelated). General search was unavailable this session, which is the
most likely reason. **Not Italian** on any evidence found.

### 3.1.3 ✅ Positive identification — the logos match exactly

This is the load-bearing check, and it passes. `storage/app/public/brands/rimpar.webp`
(120 × 149) is a **red square containing a stylised white `R`, with the wordmark `RIMPAR`
below**. The identical mark appears (a) as the `RIMPAR USA` site logo and (b) **physically
painted on the machines themselves** in Rimpar USA's own product photography.

**The catalogue's RIMPAR is this Rimpar.** The `brands.json` description — *"Rimpar offers
design and production solutions in industrial cleaning machines. They specialize in
professional cleaning equipment that meets customer expectations and requirements"* — is
**accurate**, and reads like a translation of the company's own about-copy (which also uses
"We know the expectations of our customers" and "We produce with the global quality
management"). Unusually for this file, this description is *not* boilerplate.

### 3.1.4 Rimpar has a Kenyan presence — and it sells exactly these consumables

> **Rimpar Kenya**, Nairobi — *"Sale and service of professional equipment, accessories and
> **consumables** for carpet washing…"*
> https://www.facebook.com/profile.php?id=100064394130515

"Consumables for carpet washing" is precisely what three of our four SKUs are.

---

## 3.2 ⚠ These are rug-plant consumables, not general janitorial chemicals — and that reframes all four SKUs

The single most useful line found on rimparusa.com is on the **Carpet Finishing Machines**
page:

> *"Optional feature for automatic finishing machine is **perfume application**."*
> https://rimparusa.com/carpet-finishing-machines

That directly explains `IMG/HYS/00238` **"Detergent Parfum"**, which otherwise reads as a
nonsense product name: it is the **fragrance consumable dosed by the finishing machine at the
end of a rug-wash cycle**, not a scented general-purpose detergent. Once that clicks, the
whole set resolves as one coherent consumables kit for a Rimpar rug-washing line:

| SKU | Product | Where it sits in the Rimpar process |
|---|---|---|
| IMG/HYS/00237 | Detergent Spot Remover | **Pre-treatment** — spotting before the wash |
| IMG/HYS/00239 | Carpet Shampoo 20 Lts | **Wash stage** — detergent for the washing machine |
| IMG/HYS/00238 | Detergent Parfum | **Finishing stage** — perfume application |
| IMG/HYS/00271 | Steam Cleaner `ECO 400` | The one machine — spot/steam cleaning |

**This is an inference from Rimpar's own process documentation, not a sourced product sheet**,
but it is coherent, it explains an otherwise-inexplicable product name, and it is corroborated
by Rimpar Kenya's own self-description (§3.1.4).

**Consequence: all four are almost certainly miscategorised.** They sit under `Cleaning
Solutions` in a **commercial-kitchen** catalogue, but they belong to a **carpet/rug-cleaning
plant** product family — the same class of category mismatch the Steelology pass raised for
its four bare containers under `Hygiene`. All four are already `archived`, so this is
academic unless they are ever revived. Flagged only.

---

## 3.3 The four SKUs individually — what is and is not findable

### 3.3.1 Three of the four `model_number`s are not codes

As the brief anticipated:

| SKU | `model_number` | What it actually is |
|---|---|---|
| IMG/HYS/00237 | `FM180-200` | **The only one that looks like a code** — see §3.3.2 |
| IMG/HYS/00238 | `PARFUM` | The product word |
| IMG/HYS/00239 | `SHAMPOO` | The product word |
| IMG/HYS/00271 | `ECO 400` | A plausible machine model — see §3.3.3 |

Same failure mode as Steelology's `SUNK IN` / `30W` / `45W`.

### 3.3.2 `FM180-200` — unresolved, and possibly not a chemical at all

Nothing was found for this code. Worth recording one alternative reading rather than
asserting the obvious one: **`FM` is a common prefix for "Floor Machine"**, and 180 is a
standard single-disc floor-machine RPM. If `FM180-200` is a machine code that has drifted onto
a chemical record, the product name "Detergent Spot Remover" would be the thing that is wrong,
not the code. **This is speculation and is flagged as such** — there is no evidence either way,
and the more ordinary reading (an internal chemical SKU code) is equally consistent.

### 3.3.3 `ECO 400` — a plausible model, no manufacturer match

No Rimpar-branded `ECO 400` steam cleaner was found. Rimpar USA's published range is the four
rug-plant machines only — no steam cleaners, no chemicals — so either the US arm carries a
narrower catalogue than the parent, or this unit is a rebadge. `ECO 400` is a common
model-name pattern across several European professional steam-cleaner makers; without a
working general search engine this could not be narrowed. **Not findable this pass.**

### 3.3.4 The chemical data the brief asked for — none of it exists on these records

The brief correctly notes that for consumables the useful data is different from equipment:
**pack size, dilution ratio, pH, surface compatibility, COSHH/safety classification.**
**None of these five fields exists on any of the four records, and none was findable
externally.** The only pack-size datum in the whole set is in a product *name* —
`Carpet Shampoo **20 Lts**` — and it is not stored as a structured field anywhere.

Stating this plainly rather than papering over it: **for the three chemicals, this pass
produced brand identification and process context, and nothing else.** They cannot leave
`archived` without a supplier data sheet, and a **Safety Data Sheet is a legal requirement**
for selling cleaning chemicals in Kenya, so that is the blocking item regardless of catalogue
work.

---

## 3.4 Rimpar — recommended changes (none applied)

**Tier 1 — a real, evidenced `brands.json` correction**

1. **Fix `website_url`** (§3.1.1). `https://www.rimpar.com` is a **GoDaddy for-sale lander**
   and has been parked since at least 2017. Replace with **`https://rimparusa.com`** (the only
   working Rimpar site found, brand-confirmed by matching logo) or set to **`null`** if a
   USA-arm URL is considered wrong for a Kenyan storefront. **Do not leave it as-is.**
2. Optionally enrich the description with the provenance actually established: European
   (very likely **Turkish**) manufacturer of **industrial carpet/rug washing, dedusting,
   spinning and finishing machinery**, with a US arm in Oklahoma and a **Rimpar Kenya**
   presence in Nairobi.

**Tier 2 — only if these SKUs are ever revived**

3. **Reconsider the category on all four** (§3.2) — `Cleaning Solutions` in a kitchen
   catalogue does not fit a carpet/rug-plant consumables line.
4. **Obtain supplier data sheets** for the three chemicals: pack size, dilution ratio, pH,
   surface compatibility and an **SDS/COSHH classification** (§3.3.4). None of it exists
   today and it is legally required.
5. **Obtain a spec sheet for `ECO 400`** (§3.3.3) — the only machine in the set and the only
   one that could carry a normal equipment spec table.
6. **No `model_number` changes proposed**, per [[feedback_model_number_unique_id]] — but be
   aware `PARFUM` and `SHAMPOO` are not codes and cannot serve as unique keys.

---
---

# PART 4 — CROSS-CUTTING NOTES

- **The width/height transposition bug was checked per SKU, as instructed, and the results
  split three ways.** Present and confirmed on **all three Broaster SKUs** (§1.3);
  **unevaluable** on all four SSPC/Geneva SKUs because no dimensions are stored at all (§2.4);
  **unevaluable** on all four Rimpar SKUs for the same reason. As in every prior pass, **the
  prose was correct and the numerics were wrong** wherever the two could be compared — now
  the sixth brand family to show this. Still no blanket transform is safe.
- **Two brands in this pass carry a `model_number` that the manufacturer does not use.**
  `BROASTER 1600E` (Broaster says `1600`) and `BROASTER 1800G` (Broaster says `1800GH`).
  Both flagged, neither changed. This is now a recurring pattern alongside Baron's
  `SE40/OCB` letter-O-for-zero.
- **Duplicate images are this pass's dominant data-quality smell, and they hid two different
  problems.** The Broaster 1800E/1800G pair share a byte-identical file that shows a **gas**
  data plate on an **electric** SKU (§1.5.2). The four SSPC SKUs share **one photograph across
  four capacities and three brand strings** (§2.2.1). In both cases the image was the evidence
  — the brief's instruction to source an independent photo *even for SKUs that already have
  one* is what surfaced both.
- **Manufacturer *installation* manuals beat spec sheets for export questions.** Every
  Broaster spec sheet says 60 Hz and nothing else; the installation manual documents three
  distinct export model codes, Kenyan-voltage wiring tables and EU gas ratings. Where a
  US-brand SKU raises a voltage/frequency question, **the installation manual is the document
  to pull**, and it is usually only discoverable through the site's media API, not its
  navigation. Worth carrying forward to Blodgett, Goodwill and Antunes, all of which had the
  same class of finding resolved less thoroughly.
- **A manufacturer's own sources can disagree with each other**, and the record is not
  automatically the loser. Broaster's web page says 16 chicken pieces and its spec sheet says
  20 (§1.4.3); Broaster's 1800 spec table says 37-5/8″ and its own drawing on the same page
  says 35-7/8″ (§1.5.4). In both cases arithmetic against a third figure resolved it — and in
  the first case, in our record's favour.
- **`website_url` values in `brands.json` need an audit of their own.** This pass found
  `rimpar` pointing at a **GoDaddy for-sale lander** (§3.1.1); the `redline` entry visible
  alongside it points at `sheffieldafrica.com/brands/redline`, i.e. the client's own
  storefront. Two bad URLs in one incidental glance suggests a systematic sweep would be
  cheap and would find more.
- **`GENEVA` is referenced by two published SKUs and has no `brands.json` row** (§2.1) —
  a concrete instance of the missing-brands gap noted in [[project_brand_name_casing]].
- **Price sanity flags raised, none asserted as errors:** the SSPC ladder is non-monotonic
  (25 L cheaper than 16 L, §2.5); Broaster's gas 1800 is priced above its electric sibling
  (defensible on weight, §1.6.3).
- **Neither Geneva SKU nor any Rimpar SKU has a `meta_description` or a
  `technical_specification`**; the Geneva `description`s are bare single-`<li>` lists. All
  three Broaster records are, by contrast, already well-structured (prose + `<h3>Key
  Features</h3>` + spec table) and need enrichment rather than restructuring.

---

# PART 5 — PRODUCT REFERENCE

| SKU | Catalogue name | Stored model | **Real manufacturer code** | Official source | Confidence |
|---|---|---|---|---|---|
| IMG/HOT/00332 | Pressure Fryer Electric Broaster 1600 | `BROASTER 1600E` | **`1600`** (US) / **`1600XP`** (export) | https://broaster.com/wp-content/uploads/Broaster1600_SpecSheet8_2024.pdf | **High** — official spec sheet + installation manual |
| IMG/HOT/00390 | Pressure Fryer Electric Broaster 1800 | `BROASTER 1800E` | **`1800E`** ✓ / **`1800EXP`** (export) | https://broaster.com/wp-content/uploads/Broaster1800_SpecSheet8_2024.pdf | **High** — official spec sheet + installation manual |
| IMG/HOT/00333 | Pressure Fryer Gas Broaster 1800 | `BROASTER 1800G` | **`1800GH`** (US) / **`1800GHXP`** (export) | https://broaster.com/wp-content/uploads/Broaster1800_SpecSheet8_2024.pdf | **High** — official spec sheet + installation manual + nameplate visible in photo |
| IMG/HOT/00169 | Pressure Cooker 40 Litres | `SSPC-40` | **Time Saver** commercial pressure cooker, 40 L (Praveen Enterprises, India) — no manufacturer part number found | https://www.amazon.in/Time-Saver-Commercial-Aluminium-Cooker/dp/B075GW1S99 | **Medium-High** — brand stamp on the pot, matched to an independent 40 L listing photo |
| IMG/HOT/00170 | Pressure Cooker 60 Litres | `SSPC-60` | **Time Saver** commercial pressure cooker, 60 L — line confirmed, this size not independently photographed | https://www.amazon.in/Time-Saver-Commercial-Aluminium-Cooker/dp/B075GYCDL3 | **Medium** — capacity exists in the line; our image is the 40 L unit |
| IMG/HYS/00237 | Detergent Spot Remover | `FM180-200` | Rimpar rug-plant consumable (pre-treatment). Code unresolved | https://rimparusa.com | **Low** |
| IMG/HYS/00238 | Detergent Parfum | `PARFUM` (not a code) | Rimpar **finishing-machine perfume-application** consumable | https://rimparusa.com/carpet-finishing-machines | **Low-Medium** — process match is specific and explains the name |
| IMG/HYS/00239 | Carpet Shampoo 20 Lts | `SHAMPOO` (not a code) | Rimpar carpet-washing-machine detergent, 20 L | https://rimparusa.com/carpet-washing-machines | **Low** |
| IMG/HYS/00271 | Steam Cleaner | `ECO 400` | Not found. Rimpar USA publishes no steam cleaner | https://rimparusa.com/our-machines | **Very Low** |

Supporting / cross-check sources:

- https://broaster.com/equipment-categories/pressure-fryers/
- https://broaster.com/wp-content/uploads/17268-0-1600_1800-ST-Install-Man-rev-11-22.pdf
- https://broaster.com/wp-content/uploads/17271-0-1600_1800-ST-Parts-Manual-rev-06-26-1.pdf
- https://broaster.com/wp-content/uploads/17269-0-1600_1800-ST-Oper-Man-rev-04-25-1.pdf
- https://broaster.com/wp-content/uploads/17270-0-1600_1800-ST-Serv-Manual-rev-05-25-1.pdf
- https://www.flipkart.com/timesaver-isi-mark-commercial-hard-anodized-40-l-pressure-cooker/p/itmccd5defbafecb
- https://vadiraja.com/product/time-saver-isi-mark-commercial-hard-anodized-aluminum-handi-pressure-cooker-silver-30l/
- https://pricehistoryapp.com/product/time-saver-isi-mark-commercial-hard-anodized-aluminum-outer-lid-handi-pressure-cooker-silver-40-liter
- https://rimparusa.com/about-us
- https://www.facebook.com/profile.php?id=100064394130515

---

# PART 6 — IMAGES AND DOCUMENTS OBTAINED

Downloaded to `C:\Users\jonah.wakahiu\Desktop\ecommerce\products resource\`, **not**
`Downloads`. Every file below was opened and visually verified. **Nothing has been copied
into the project**, and no `products.json` `image` field has been touched.

## 6.1 `broaster-images\` — 13 files

| SKU | File | Px / size | Source | Notes |
|---|---|---|---|---|
| IMG/HOT/00332 | `IMG-HOT-00332__broaster-1600-official-render.png` | **835 × 1422**, 706 KB | https://broaster.com/wp-content/uploads/1600L-1_OL_SmartTouch.png | **Primary candidate.** Official Broaster render, three-quarter view, SmartTouch panel lit, "MADE IN U.S.A." decal, rear caster visible (correct for the electric build). Different angle from the stored catalogue image, so genuinely additive |
| IMG/HOT/00332 | `IMG-HOT-00332__broaster-1600-manual-cover-photo.jpg` | **698 × 1540**, 307 KB | embedded object, parts manual #17271 p1 | Front-on studio shot of the same unit, cleanly cut out. Extracted losslessly with `fitz` |
| IMG/HOT/00332 | `IMG-HOT-00332__REF__dimension-drawing.png` | **1700 × 2200**, 397 KB | spec sheet p2, rendered at 200 dpi | **Reference, not a product photo.** Front/side/top views carrying 406 / 737 / 1088 / 910 / 1254 / 490 mm — the drawing behind §1.3 |
| IMG/HOT/00332 | `IMG-HOT-00332__spec-sheet.pdf` | 787 KB | https://broaster.com/wp-content/uploads/Broaster1600_SpecSheet8_2024.pdf | Official spec sheet, Rev H 8/24 |
| IMG/HOT/00333 | `IMG-HOT-00333__broaster-1800GH-spec-sheet-render.jpg` | **768 × 1354**, 145 KB | embedded object, 1800 spec sheet p1 | **Primary candidate for the gas SKU.** Nameplate legible as `MODEL 1800GH`; "MANUAL SHUTOFF VALVE" sticker visible; SmartTouch screen showing a live cook cycle |
| IMG/HOT/00333 | `IMG-HOT-00333__broaster-1800GH-manual-cover-photo.jpg` | **663 × 1463**, 48 KB | embedded object, parts manual #17271 p1 | Same unit, screen off, `MODEL 1800GH` plate and CSA mark legible |
| IMG/HOT/00333 | `IMG-HOT-00333__REF__dimension-drawing.png` | **1700 × 2200**, 455 KB | 1800 spec sheet p2, 200 dpi | **Reference.** Carries 457 / 908 / 1152 / 910 / 1207 / 1485 / 585 mm and the "GLIDE ON 1800GH / WHEEL ON 1800E" note |
| IMG/HOT/00333 | `IMG-HOT-00333__spec-sheet.pdf` | 766 KB | https://broaster.com/wp-content/uploads/Broaster1800_SpecSheet8_2024.pdf | Official spec sheet 8/24 (shared 1800E/1800GH document) |
| IMG/HOT/00390 | `IMG-HOT-00390__REF__broaster-1800GH-spec-sheet-render.jpg` | **768 × 1354**, 145 KB | as above | ⚠ **`REF__` — wrong variant.** This is the **gas 1800GH**, filed against the **electric** SKU because **Broaster publishes no 1800E photograph anywhere** (§1.5.2). It is the same file the catalogue currently uses on this SKU. Do not treat as correct |
| IMG/HOT/00390 | `IMG-HOT-00390__REF__dimension-drawing.png` | **1700 × 2200**, 455 KB | as above | **Reference.** Dimensions are shared between 1800E and 1800GH, so this drawing is valid for both |
| IMG/HOT/00390 | `IMG-HOT-00390__spec-sheet.pdf` | 766 KB | as above | Official spec sheet 8/24 |
| *(all three)* | `_install-manual-1600-1800-ST.pdf` | 1.9 MB | https://broaster.com/wp-content/uploads/17268-0-1600_1800-ST-Install-Man-rev-11-22.pdf | **The most valuable document in this pass** — the sole source for the export models, the Kenyan-voltage wiring tables and the EU gas data (§1.2) |
| *(all three)* | `_parts-manual-1600-1800-ST.pdf` | 2.6 MB | https://broaster.com/wp-content/uploads/17271-0-1600_1800-ST-Parts-Manual-rev-06-26-1.pdf | Source of the two cover photos; confirms `1800GHXP` is separately stocked |

**Ceiling proved.** Every Broaster image route was probed. The WordPress media library's
1800 assets (`1800_1_lr-384x600-1.png`, `1800_3/5/6_lr-*-600-1.png`) are **pre-resized on
upload at 600 px tall** — un-suffixed originals 404, so **600 px is that host's ceiling for
the 1800**, below the 800 px bar. All four were downloaded, opened, confirmed sub-threshold
and **deleted**. PDF extraction beat the web for the 1800 (1354-1540 px vs 600 px) and lost
narrowly for the 1600 (1422 px web render vs a 350 × 600 spec-sheet thumbnail, so the web
render was kept). The operator and service manuals were also downloaded and their embedded
objects enumerated — their best cover images are **509 × 1187 / 728 × 1239 / 780 × 1237**,
all smaller than the parts manual's, so both were deleted rather than kept.

**No synthetic upscales.** Every file above is either a native web asset or a losslessly
extracted PDF object; nothing was enlarged.

## 6.2 `geneva-images\` — 2 files

| SKU | File | Px / size | Source | Notes |
|---|---|---|---|---|
| IMG/HOT/00169 | `IMG-HOT-00169__time-saver-40L-commercial-pressure-cooker-amazon-in.jpg` | **1271 × 1280**, 131 KB | https://m.media-amazon.com/images/I/71GMcTYA24L.jpg | **The evidence file for §2.2.2.** Independent, non-Sheffield photograph of the **40 litre Time Saver** commercial pressure cooker. The **"Time Saver™" blue-diamond stamp is clearly legible**, as is the geared gauge dial ("DO NOT OPERATE UNTIL YOU HAVE READ INSTRUCTIONS — GEARED GAUGE"). Confirms the cross-brand finding outright |
| IMG/HOT/00170 | `IMG-HOT-00170__REF__time-saver-40L-pressure-cooker-same-photo-as-40L-listing.jpg` | 1271 × 1280, 131 KB | as above | ⚠ **`REF__` — this is the 40 L unit**, kept against the 60 L SKU only because the seller uses one photograph across the whole size ladder, exactly as our own catalogue does. **Not a photograph of a 60 L cooker.** Filed for reference, not for use |

The `.jpg` size-suffix modifiers were stripped from the Amazon CDN URL
(`._AC_UF350,350_QL50_.jpg` → `.jpg`), which lifted it from 350 px to 1271 × 1280.

**No 60 L-specific photograph exists** that could be found — IndiaMART, made-in-china,
Flipkart and Amazon India were all tried; the Indian listings for this line reuse one image
across 30/40/60 L, and made-in-china's 40-60 L results are **electric** pressure cookers, a
different product class that would have been the exact mistake the brief warns against.

## 6.3 `rimpar-images\` — 0 product files; 5 in `_brand-reference\`

**No product image was obtained for any of the four Rimpar SKUs, and this needs saying
plainly rather than papering over.** Three are chemicals with no findable packaging shot, and
the fourth (`ECO 400`) could not be identified at all (§3.3.3). All four remain `image: null`,
consistent with the Kitchenware and Steelology precedent of deliberate abstention over
attaching a misleading photo.

What was kept, in `_brand-reference\` — **brand identification only, none of these is any of
our four products**:

| File | Px / size | Source | Notes |
|---|---|---|---|
| `rimpar-usa-logo.png` | 350 × 78, 23 KB | https://rimparusa.com/yukleme/logo.png | **The §3.1.3 evidence** — matches `brands/rimpar.webp` exactly |
| `rimpar-usa-1-carpet-washing-machines-1.jpg` | **1500 × 703**, 180 KB | https://rimparusa.com/yukleme/product/1-carpet-washing-machines-1.jpg | Red-liveried machine with the `RIMPAR` mark painted on it — the logo match on physical hardware |
| `rimpar-usa-2-carpet-dust-removers-1.jpg` | **1500 × 703**, 118 KB | https://rimparusa.com/yukleme/product/2-carpet-dust-removers-1.jpg | Brand reference |
| `rimpar-usa-3-carpet-spinning-machines-1.jpg` | **1500 × 703**, 78 KB | https://rimparusa.com/yukleme/product/3-carpet-spinning-machines-1.jpg | Brand reference |
| `rimpar-usa-4-carpet-finishing-machines-1.jpg` | **1500 × 703**, 142 KB | https://rimparusa.com/yukleme/product/4-carpet-finishing-machines-1.jpg | The **finishing machine** — the one with the optional perfume application that explains `IMG/HYS/00238` (§3.2) |

**None of these should ever be attached to the four archived Rimpar SKUs** — they are
rug-plant machinery, not chemicals or a steam cleaner.

---

## ⚠ Broaster SKUs reassigned to HDS, 2026-07-30

`IMG/HOT/00332`, `IMG/HOT/00333` and `IMG/HOT/00390` now carry **`brand: HDS`** in
`products.json`, not `BROASTER` — SAP records their `Make` as `HDS` (Heavy Duty Systems).
`hds-research.md` already cites all three, so the trail is intact from both sides.

The Broaster findings in this file remain valid for the equipment itself, including the
wrong-market-electrical flag on `IMG/HOT/00333` (US 120 V / 60 Hz control voltage).
`sku` and `model_number` unchanged. Staged images remain under `broaster-images\`.
See `sap-reconciliation-research.md` §5.3.
