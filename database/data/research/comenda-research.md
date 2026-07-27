# Comenda Product Research

Research notes behind a COMENDA enrichment/audit pass on `products.json` (July 2026).
Covers all 9 COMENDA SKUs in the "Dishwashers" category: 3 hood-type/pass-through
machines (PC-09, PC 07, EC44), 1 undercounter dishwasher (EF36M), 1 undercounter
glasswasher (EB28), and 4 wash racks/accessories.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema and Santos passes before a scope decision.

Headline results:

- **All 5 machines resolved to an official Comenda datasheet PDF with an exact model-code
  match.** This is the cleanest brand pass so far — no generation ambiguity like Brema's
  CB1565 or Santos's #50.
- **The width/height axis-swap bug is present again** on both SKUs that store dimensions
  (PC-09 and PC 07), plus on the one rack that stores them (Cutlery Rack, §5.1). Third
  brand pass in a row to hit it.
- **Copy-paste-across-siblings confirmed**: PC-09 and PC 07 carry a **byte-identical
  description** and **identical dimension fields**, and PC-09 has **no
  `technical_specification` at all**. The dimensions happen to be right for both (same
  cabinet), but several description bullets are wrong for PC-09 specifically (§4.1).
- **3 of the 5 machines (EC44, EF36M, EB28) are completely empty records** — no
  description, no spec, no dimensions. They are `published` and priced anyway.

---

## 1. Brand identification

**Comenda** = **Comenda Ali S.p.A. / Comenda Ali Group srl**, Via Galileo Galilei 8,
20051 Cassina de' Pecchi (Milano), Italy. Founded **1963** by Luciano Berti; it is the
original "spring board company" of the **Ali Group**, which the brochure states in its own
words ("As the spring board company of Ali Group, Comenda offers professional washing
machines rigorously 'Made in Italy'"). Product range runs from small bar glasswashers up
to flight-type and rack-conveyor systems.

- https://comenda.eu/
- https://www.aligroup.com/brand/comenda/

**`brands.json` entry verified — no change needed.** The stored
`website_url: https://www.comenda.eu` is correct: `www.comenda.eu` returns a 301 to
`https://comenda.eu/`, which returns 200. Not a broken link, just a canonical-host
redirect (same situation as Brema's `bremaice.it`). The stored brand description's
"Since 1963" is also **confirmed correct**.

---

## 2. Where to look

| Resource | URL | Value |
|---|---|---|
| Product-range overview | https://comenda.eu/product/2023/ | Which line each model belongs to (Infinity / Hi Line / Prime Line / Equilybra) |
| Download hub | https://comenda.eu/download/ | Entry point to every line's spec sheets, DWG and BIM files |
| Equilybra downloads (EB/EF/EC models) | https://comenda.eu/download/equilybra/ | Per-model spec-sheet PDFs — **the primary source for EC44, EF36M, EB28** |
| Equilybra brochure | https://comenda.eu/wp-content/uploads/2026/06/EQULYBRA-ENG_29.05.26-1.pdf | Cross-check spec table for the whole EB/EF/EC family in one place |
| Racks & inserts catalogue | https://comenda.eu/wp-content/uploads/2024/04/13-CESTELLI-eng900902EN-09.2017.pdf | **The only official source of Comenda rack codes** — used for §5 |
| Prime Line catalogue (UK) | https://comenda.co.uk/wp-content/uploads/2024/04/Prime-ENG_2024_CAT5.pdf | Prime Line (PC/PF) marketing copy |

**Model-code → line mapping** (useful because our catalogue mixes two generations):

- `PC**` = **Prime Line** pass-through/hood units. Our PC-09 and PC 07 are here.
- `EB / EF / EC**` = **Equilybra** line (glasswasher / undercounter "frontale" / hood
  "cappotta"). Our EB28, EF36M, EC44 are here. This is Comenda's current entry range.

### Traps

1. **PDF spec sheets do not extract via `WebFetch`** — same as the Santos leaflets. Use the
   `Read` tool (or `pypdf`) on the downloaded file. Every number in §4 came out of a
   `Read`-rendered datasheet page, not a web scrape.
2. **Resellers mix up EC44 and RC07.** https://www.kitchenpro.gr/en/commercial-hood-type-dishwasher-50x50-cm-3-phase-400v-rc-07-comenda-italy
   has an `rc-07` slug but an EC44 page title and an `ec44hood` image filename. RC07 is a
   *different* (Hi Line) hood machine. Trust the datasheet, not the reseller slug.
3. **PC07 has four sibling codes** — `PC07+`, `PC07 R`, `PC07 RA`, `PC07-RA`. They share
   an identical cabinet, load, tank and weight; only the built-in dosing/drain pump fit
   differs (and PC07 RA's cold-water output figure). See §4.2 — this means our bare
   "PC 07" spec is safe regardless of which variant ships.
4. **A "double-walled" claim in our copy is wrong for the Prime hoods.** Both PC07+ and
   PC09 are **single skin in AISI 304** as standard; "double skin insulated hood" is an
   explicitly listed *optional* extra on both datasheets. Only the Equilybra undercounter
   models (EF36 M, EB28) have a genuinely double-walled door as standard.

---

## 3. The width/height swap bug — present again

Same transposition documented in the Santos, Empero and Brema passes. Both dimensioned
machine SKUs are affected, and the PC 07 record even **contradicts itself**: its prose
`technical_specification` gives the axes correctly while its numeric fields do not.

| SKU (model) | Stored numeric L/W/H | Stored prose | Official (W × D × H) | Verdict |
|---|---|---|---|---|
| 00093 (PC 07) | 624 / **1460** / **740** | "Length 624, Width 740, Height 1460" — correct | 625 × 740 × 1460 | numeric `width` holds the **height**, numeric `height` holds the **depth** |
| 00085 (PC-09) | 624 / **1460** / **740** | *(no spec block at all)* | 625 × 740 × 1460 | same swap, copied wholesale from 00093 |
| 00032 (Cutlery Rack) | 500 / **100** / **500** | n/a | 500 × 500 base, ~100 mm tall | same shape of error — see §5.1 |

Also note the stored **624** vs official **625**: Comenda's own technical drawing carries
both figures (the tank aperture is dimensioned 624, the cabinet 625), so 624 is not wrong
so much as measuring a different feature. Not worth "fixing" on its own.

The three SKUs with no dimensions at all (EC44, EF36M, EB28) cannot have the bug — but
they also cannot be shipped/quoted on, which is the bigger problem.

---

## 4. Per-SKU findings — the 5 machines

### 4.1 Dish Washer Hood PC-09 (IMG/DWW/00085) — swap bug, no spec block, description copied from PC 07 ⚠

Official datasheet: https://comenda.eu/wp-content/uploads/2024/02/Scheda-tecnica-PC09_28.08.23_ENG.pdf
("PASS-THROUGH UNIT / PRIME LINE / PC09", dated 28.08.23).

Full official technical data:

| Field | Official value |
|---|---|
| External size (W×D×H) | 625 × 740 × 1460 mm |
| External size with CRC2 heat-recovery | 625 × 740 × 1894 mm |
| Overall size (hood raised) | 1960 mm |
| Clearance (loading height) | 440 mm |
| Rack size | 500 × 500 mm |
| Electrical supply | 230V/3/50Hz; 400V/3N/50Hz |
| Wash program length | 75 / 90 / 120 / 240 sec |
| Max output (warm water, 55 °C) | 48 / 40 / 30 / 15 racks/h |
| Max output (cold water, 15 °C) | 41 / 40 / 30 / 15 racks/h |
| Rinse water consumption | 2.8 l/rack |
| Tank heater element | 3 kW |
| Booster heater element | 9 kW (14 kW optional) |
| Tank size | 42 l |
| Wash pump | 1.1 kW |
| Installed load | 10.1 kW |
| Noise | 65–67 dB(A) |
| Weight | 108 kg |

**Problems with the current record:**

1. **No `technical_specification` field exists** — this SKU is priced at KES 950,000 and
   published with nothing but a bullet list.
2. **The `description` is byte-identical to PC 07's** (§4.2). Several of its bullets are
   wrong for PC09 specifically:
   - *"Electromechanical control"* — **wrong**. PC09's panel is electronic: display with
     temperature indicators, 4 selectable programs (Eco fast / Glasses / Dishes /
     Intensive), alphanumeric alarm codes, cycle countdown, cycle counter, electronic
     temperature probes. ("Electromechanical" is accurate for **EC44/EF36M/EB28**, not for
     the Prime hoods.)
   - *"Soft start and stand by mode"* — **not listed for PC09**. Soft Start is a documented
     PC07+ feature only.
   - *"Double-walled insulated front door"* — **wrong**, see §2 trap 4. PC09 is single skin
     AISI 304; double-skin hood is an option.
   - *"Thermostat controlled heater"* — imprecise; PC09 uses electronic probes plus an
     adjustable Thermostop.
   - Accurate bullets that survive: pass-through unit, deep-drawn (single-piece) tank,
     rotating upper and lower wash and rinse arms, tool-free arm removal (the datasheet's
     "multiple filtration system: 4 removable stainless steel surface filters"), rinse
     control (Thermostop).
3. **Dimensions carry the §3 swap.**
4. **Facts worth adding that the record has none of:** 48 racks/h (≈864 plates/h), 42 l
   tank, 10.1 kW / 400V 3N, 2.8 l per rack, 108 kg, 440 mm clearance, AISI 304 single skin,
   built-in rinse-aid dosing pump, self-cleaning cycle at switch-off, magnetic microswitch
   door stop.

⚠ **One reseller disagrees on power**: a distributor listing quotes PC09 at **14.6 kW**
with "230V 3-phase convertible to 400V 3-phase". That is the machine fitted with the
**optional 14 kW booster** (10.1 kW standard + the 5 kW booster delta ≈ 14.6 kW with the
larger element). Use the official **10.1 kW** as the base figure and treat 14.6 kW as the
upgraded-booster configuration, not a contradiction.

### 4.2 Dish Washer Hood Type PC 07 (IMG/DWW/00093) — specs confirmed correct, only the axis swap is wrong

Official datasheet: https://comenda.eu/wp-content/uploads/2024/02/Scheda-tecnica-PC07-_09.08.23_ENG.pdf
("PC07+ / PRIME LINE / PASS-THROUGH UNIT", dated 09.08.23).

Sibling variants, all verified as sharing the same envelope and electricals:
- PC07 R — https://comenda.eu/wp-content/uploads/2024/02/Scheda-tecnica-PC07-R_09.08.23_ENG.pdf
- PC07 RA — https://comenda.eu/wp-content/uploads/2024/02/Scheda-tecnica-PC07-RA_09.08.23_ENG.pdf

| Field | Official (PC07+) | Our stored value | Match? |
|---|---|---|---|
| Output | 40/40/30/15 racks/h warm (32/32/30/15 cold) | "40 rack/h" | **yes** |
| Rack size | 500 × 500 mm | 500 × 500 mm | **yes** |
| Wash program | 90 / 90 / 120 / 240 sec | "90/120 sec" | yes (partial list) |
| External size | 625 × 740 × 1460 mm | prose correct, numeric swapped | **prose yes, fields no** |
| Rinse water | 2.5 l/rack | "2.5 litres" | **yes** |
| Tank size | 42 l | 42 l | **yes** |
| Installed load | 7.7 kW | 7.7 kW | **yes** |
| Supply | 230V/50Hz; 230V/3/50Hz; 400V/3N/50Hz (Multipower) | "400 v - 50 hz (3 phase)" | yes, but understates the Multipower flexibility |

This is the **only COMENDA SKU whose stored numbers are all correct**. Missing/addable:
tank heater 2.2 kW, booster 7 kW (9 kW optional), wash pump 0.7 kW, weight 108 kg,
clearance 440 mm, overall height with hood raised 1960 mm, noise 65–67 dB(A),
**WRIS®2+ Wash and Rinse Integrated System** (Comenda quotes a 25% rinse-water reduction,
27,302 l/unit/year saved), Soft Start, built-in detergent + rinse-aid dosing pumps and
drain pump as standard.

Same "double-walled front door" copy error as §4.1 — PC07+ is single skin AISI 304 with an
optional double-skin insulated hood.

**Naming note:** Comenda's own documentation writes `PC07+` / `PC07 R` / `PC07 RA` — never a
bare `PC 07` with a space. Likewise `PC09`, not `PC-09`. Same reseller/local-SKU suffix
pattern seen with Santos's "A" codes and Fagor's "H". **Not changed** — flagged only, per
[[feedback_model_number_unique_id]].

### 4.3 Dish Washer Hood Type EC44 (IMG/DWW/00158) — completely empty record ⚠

Official datasheet: https://comenda.eu/wp-content/uploads/2025/05/Scheda-tecnica_EC44_ENG_20.05.25.pdf
Cross-checked against the Equilybra brochure spec table (page 12).

**Currently `published` at KES 790,000 with no description, no spec, and no dimensions.**
Everything below has to be built from scratch:

| Field | Official value |
|---|---|
| External size (A×B×C) | 596 × 740 × 1465 mm |
| External size with CRC2 | 596 × 740 × 1899 mm |
| Overall size (D, hood raised) | 1965 mm |
| Clearance (E, without rack) | 440 mm |
| Rack size | 500 × 500 mm |
| Electrical supply | 380–415V 3N~ 50Hz |
| Wash program length | 90 / 120 sec |
| Max output | 40 racks/h (same warm **and** cold water) |
| Rinse water consumption | 2.6 l/rack |
| Tank heater element | 2 kW |
| Booster heater element | 5 kW |
| Tank size | 32 l |
| Wash pump | 0.66 kW |
| Installed load | 7.66 kW |
| Noise | 61 dB(A) |
| Weight | 108 kg |

Feature copy from the datasheet: AISI 304 stainless steel washing chamber, fully enclosed
back, **electromechanical** control panel with two cycles (short/intensive), digital
thermometer display for HACCP, cycle countdown + alarm codes, WRIS®2+, single-piece
deep-drawn tank with rounded corners, built-in peristaltic detergent **and** rinse-aid
dosing pumps, triple filtration system, removable rack support, **Hydramaster system**,
new guide sliding system, automatic stop on accidental door opening, Thermostop as
standard. Options: drain-pump kit or built-in drain pump, CRC2 heat recovery, special
voltages, external water softener, entry/exit tables. A 4-cycle **EC44 UP** version exists
(same envelope) if the supplier ever ships that variant.

⚠ **Note this contradicts the earlier web summary of "45/30 baskets per hour, 2000/5000 W,
2.6 l"** floating around resellers — the official figure is a flat **40 racks/h**; the
2000/5000 W does match (tank/booster elements) and 2.6 l is correct.

### 4.4 Dish Washer Undercounter EF36M (IMG/DWW/00159) — completely empty record ⚠

Official datasheet: https://comenda.eu/wp-content/uploads/2025/05/Scheda-tecnica_EF36-M_ENG_19.05.25.pdf

**Currently `published` at KES 450,000 with no description, spec or dimensions.**

| Field | Official value |
|---|---|
| External size (A×B×C) | 570 × 610 × 820 mm |
| Overall size (D, door open) | 1022 mm |
| Clearance (E) | 360 mm |
| Rack size | 500 × 500 mm |
| Electrical supply | 220–240V 1~ 50Hz (**single phase**) |
| Wash program length | 90 / 180 sec |
| Max output | 40 racks/h |
| Rinse water consumption | 2.6 l/rack |
| Tank heater element | 2 kW |
| Booster heater element | 2.5 kW |
| Tank size | 20 l |
| Wash pump | 0.66 kW |
| Installed load | 3.16 kW |
| Noise | 61 dB(A) |
| Weight | 58 kg |

Feature copy: AISI 304 washing chamber, **double-walled AISI 304 door** (genuinely standard
here, unlike the Prime hoods), rear panelling, ergonomic polypropylene handle,
electromechanical panel with two cycles, digital thermometer display, cycle countdown +
alarm codes, WRIS®2+, single-piece deep-drawn tank with rounded corners, built-in
peristaltic detergent and rinse-aid dosing pumps, double filtration system, flat rack
guides, Hydramaster, auto-stop on door opening, Thermostop. Options: drain-pump kit or
built-in drain pump, **base stand h. 450 mm**, special voltages, external softener, or the
**EF36 M A** model with an integrated softener.

**Selling point worth capturing:** it is a 500×500-rack dishwasher that runs on **ordinary
single-phase 220–240V at 3.16 kW** — a real differentiator against three-phase-only
competitors in the Kenyan market. Siblings that are *not* ours: EF36 C (three-phase,
same envelope) and EF36 T UP (three-phase, 4 cycles). Don't cross-contaminate their
electricals into the M record — this is exactly the failure mode the Santos and Pradeep
passes found.

### 4.5 Glass Washer Undercounter EB28 (IMG/DWW/00160) — completely empty record ⚠

Official datasheet: https://comenda.eu/wp-content/uploads/2025/05/Scheda-tecnica_EB28_ENG_19.05.25.pdf

**Currently `published` at KES 375,000 with no description, spec or dimensions.**

| Field | Official value |
|---|---|
| External size (A×B×C) | 460 × 515 × 630 mm |
| Overall size (D, door open) | 830 mm |
| Clearance (E) | 280 mm |
| Rack size | **400 × 400 mm** |
| Electrical supply | 220–240V 1~ 50Hz (single phase) |
| Wash program length | 90 / 120 sec |
| Max output | 40 racks/h |
| Rinse water consumption | 2.6 l/rack |
| Tank heater element | 2 kW |
| Booster heater element | 2.5 kW |
| Tank size | 10.5 l |
| Wash pump | 0.26 kW |
| Installed load | 2.76 kW |
| Noise | 61 dB(A) |
| Weight | 40 kg |

Standard rack kit: **1 combination rack 400 × 400 mm h.150**, **G2 two-place cutlery
holder**, **insert for cup dishes**. Optional kit swaps the combination rack for a **round
rack**. Options: drain-pump kit / built-in drain pump, special voltages, external softener,
or the **EB28 A** model with integrated softener.

Feature set is the same Equilybra package as EF36M (§4.4) — double-walled AISI 304 door,
electromechanical two-cycle panel, digital thermometer, WRIS®2+, Hydramaster, Thermostop.

**Do not copy EF36M's numbers into this record**: they share cycle counts, rinse
consumption, noise and heater ratings but differ on **every** size, tank, pump, load and
weight figure, and on rack size (400×400 vs 500×500). Siblings: **EB25** (350×350 rack,
425×515×600, 9.5 l tank) and **EB28 UP** (4 cycles, 60 racks/h, same envelope).

---

## 5. Per-SKU findings — the 4 racks

Verdict up front: **these are generic warewashing accessories, not identifiable Comenda
part numbers**, with two partial exceptions. Comenda's official rack catalogue
(https://comenda.eu/wp-content/uploads/2024/04/13-CESTELLI-eng900902EN-09.2017.pdf, cod.
900902EN/09-17) publishes its complete code list, and Comenda racks are made in
international standard sizes — **500×500, 400×400 and 350×350 mm** — meaning any
manufacturer's rack in those sizes fits. The catalogue's published codes are:

- **Plates**: `P 12/18` (12 deep or 18 flat plates, 500×500), `P 10` (400×400), `P 14`
  (pizza plates ø320)
- **Open racks**: `CB` combination rack (h 75 mm), `CBR 1/2/3/4` (up to 100/150/200/250 mm)
- **Cutlery**: `CP 60/80 pieces`, `CP 8`, `CG`, `CG 16` (240 pieces), `G` silver container,
  `G2` small cutlery holder, `CP 2` (500×250)
- **Base**: `CB 2` base rack (500×250)
- **Cups**: `CG 16`, `CT 20`, `CT 36`
- **Glasses (500×500)**: `B 116/216/316/416`, `B 125/225/325/425`, `B 136/236/336/436`
- **400×400**: combination rack, `LBi 20` glasses rack, `LB 16/25/36`, `LBi 216`
- **Trays**: `CPV 7`, `CVA 10`, `CVT 5`, `CVI 7`, `CVXL 12`; **XL (500×600)**: `XLB`,
  `XLP`, `XLT`; **trolleys**: `CAR 1`, `CAR 2`

Note **none of our four rack `model_number`s appear in that list as written**.

### 5.1 Cutlery Rack 8 Compartment (IMG/DWW/00032, `archived`, model N/A) — generic, and internally inconsistent ⚠

Stored: `500 / 100 / 500`, description "Cutlery Rack Beige - 8 Compt; Compartment size
90x90x110".

- **No Comenda match.** The closest official items are `CP 8` (a cutlery rack) and the `G`
  silver container (a single ~90×90×110 basket that drops into an open rack) / `CG 16`
  (16 containers). Comenda publishes no 8-compartment code, and its containers are **orange
  or yellow**, not **beige** — so the stored colour actively argues against this being a
  Comenda part. Reads as a third-party 500×500 open rack fitted with 8 cutlery pots.
- **Internal contradiction**: the rack is stored 100 mm tall but the compartments are
  described as 110 mm tall. Physically the compartments stand *above* an open rack — so
  either the rack height or the compartment height is being described loosely.
- **Same axis pattern as §3**: `width: 100` is really the **height**, `height: 500` is
  really the depth. A 500 × 500 mm rack, ~100 mm tall.
- Currently `archived`, `image: ""`.

### 5.2 Dish Wash Rack 400MM (IMG/DWW/00033, `published`, model N/A) — best generic match is the 400×400 combination rack

- Stored: name only. **No description, spec, or dimensions at all**, but it is `published`
  at KES 12,000 and has an image.
- "400MM" almost certainly means the **400 × 400 mm** international rack size. Comenda's
  own 400×400 offerings are the **combination rack 400×400** (this is the rack shipped as
  standard with our **EB28**, quoted as "1 Combination rack 400 x 400 mm, h. 150"), plus
  `P 10`, `LBi 20`, `LB 16/25/36` and `LBi 216`.
- **Recommendation:** describe it as a 400 × 400 mm open/combination wash rack compatible
  with the EB28 glasswasher rather than assigning a Comenda code. If the intent is
  specifically the EB28's standard rack, the honest description is "combination rack
  400 × 400 mm, h. 150 mm". Without a physical unit to inspect, forcing `P 10` or
  `LBi 216` onto it would be a guess.
- This is also a **cross-sell opportunity worth noting**: it is the consumable that pairs
  with IMG/DWW/00160 (EB28).

### 5.3 CB Combination Rack (IMG/DWW/00156, `archived`, model `CB-12/18`) — real Comenda concept, but the model number is a mash-up of two different codes ⚠

- **`CB-12/18` is not a Comenda code.** The catalogue and every machine datasheet list
  **`CB`** and **`P 12/18`** as two *separate* items in the same standard rack kit:
  > "P12/18 - 2 dish racks P12/18 / CB - 1 combination rack CB h 75 mm / G - 1 cutlery holder"
  Someone has concatenated the combination rack's code with the plate rack's code. The
  correct code for this product is simply **`CB`** (combination rack, 500 × 500 mm,
  h 75 mm) — confirmed on the PC09, PC07+, EC44 and EF36M datasheets and in the racks
  catalogue.
- Also beware `CB 2`, a *different* item (a 500 × 250 mm base rack).
- Record is `archived` with `image: ""` and no content whatsoever. Real product, but the
  `model_number` should not be treated as authoritative.

### 5.4 Plate Rack (IMG/DWW/00157, `archived`, model `PR`) — real Comenda item, wrong code

- **`PR` is not a Comenda code.** Comenda's plate rack is **`P 12/18`** — "1 rack for 12
  deep dishes or 18 dishes in polypropylene", 500 × 500 mm, supplied as standard (×2) with
  PC09 and PC07+, and (×1) with EC44 and EF36M. The 400 × 400 equivalent is `P 10`; the
  pizza version is `P 14`.
- `PR` looks like the same house-code convention already documented for Sheffield's other
  in-house SKUs.
- Record is `archived`, `image: ""`, no content.

**Overall rack verdict:** 00156 and 00157 map cleanly onto real Comenda items (`CB` and
`P 12/18`) whose codes our records get wrong; 00032 and 00033 are best described as
**generic standard-size warewashing racks** and should be sold as such, since Comenda
itself sells into an open standard (500×500 / 400×400 / 350×350) rather than a proprietary
fitment. Per [[feedback_model_number_unique_id]], none of these `model_number`s were
changed.

---

## 6. Product reference

| SKU | Catalogue name | Our model | Comenda's own code | Official source | Confidence |
|---|---|---|---|---|---|
| IMG/DWW/00085 | Dish Washer Hood PC-09 | PC-09 | **PC09** (Prime Line) | https://comenda.eu/wp-content/uploads/2024/02/Scheda-tecnica-PC09_28.08.23_ENG.pdf | **High** — official datasheet, exact model match |
| IMG/DWW/00093 | Dish Washer Hood Type PC 07 | PC 07 | **PC07+** (also PC07 R / PC07 RA) | https://comenda.eu/wp-content/uploads/2024/02/Scheda-tecnica-PC07-_09.08.23_ENG.pdf | **High** — all three variants share the envelope/load |
| IMG/DWW/00158 | Dish Washer Hood Type EC44 | EC44 | **EC44** (Equilybra) | https://comenda.eu/wp-content/uploads/2025/05/Scheda-tecnica_EC44_ENG_20.05.25.pdf | **High** — official datasheet + brochure agree |
| IMG/DWW/00159 | Dish Washer Undercounter EF36M | EF36M | **EF36 M** (Equilybra) | https://comenda.eu/wp-content/uploads/2025/05/Scheda-tecnica_EF36-M_ENG_19.05.25.pdf | **High** — official datasheet + brochure agree |
| IMG/DWW/00160 | Glass Washer Undercounter EB28 | EB28 | **EB28** (Equilybra) | https://comenda.eu/wp-content/uploads/2025/05/Scheda-tecnica_EB28_ENG_19.05.25.pdf | **High** — official datasheet + brochure agree |
| IMG/DWW/00032 | Cutlery Rack 8 Compartment | N/A | *no match* | https://comenda.eu/wp-content/uploads/2024/04/13-CESTELLI-eng900902EN-09.2017.pdf | **Low** — generic third-party rack (§5.1) |
| IMG/DWW/00033 | Dish Wash Rack 400MM | N/A | combination rack 400×400 h.150 (probable) | https://comenda.eu/wp-content/uploads/2025/05/Scheda-tecnica_EB28_ENG_19.05.25.pdf | **Medium** — size class certain, exact item inferred |
| IMG/DWW/00156 | CB Combination Rack | CB-12/18 | **CB** (h 75 mm) | https://comenda.eu/wp-content/uploads/2024/04/13-CESTELLI-eng900902EN-09.2017.pdf | **High** on the item, model_number is a mash-up |
| IMG/DWW/00157 | Plate Rack | PR | **P 12/18** | https://comenda.eu/wp-content/uploads/2024/04/13-CESTELLI-eng900902EN-09.2017.pdf | **High** on the item, model_number is a house code |

Related official documents pulled while researching (useful if the range is ever widened):

- Equilybra brochure: https://comenda.eu/wp-content/uploads/2026/06/EQULYBRA-ENG_29.05.26-1.pdf
- Equilybra downloads (DWG 2D/3D + BIM `.rfa` for every model): https://comenda.eu/download/equilybra/
- EB28 UP: https://comenda.eu/wp-content/uploads/2026/06/Scheda-tecnica_EB28-UP_ENG_17.06.26.pdf
- EF36 C: https://comenda.eu/wp-content/uploads/2025/05/Scheda-tecnica_EF36-C_ENG_20.05.25.pdf
- EF36 T UP: https://comenda.eu/wp-content/uploads/2026/06/Scheda-tecnica_EF36-T-UP_ENG_17.06.26.pdf
- EC44 UP: https://comenda.eu/wp-content/uploads/2026/06/Scheda-tecnica_EC44-UP_ENG_17.06.26.pdf
- EB25: https://comenda.eu/wp-content/uploads/2025/05/Scheda-tecnica_EB25_ENG_19.05.25.pdf
- PC07 R: https://comenda.eu/wp-content/uploads/2024/02/Scheda-tecnica-PC07-R_09.08.23_ENG.pdf
- PC07 RA: https://comenda.eu/wp-content/uploads/2024/02/Scheda-tecnica-PC07-RA_09.08.23_ENG.pdf
- Prime Line catalogue: https://comenda.co.uk/wp-content/uploads/2024/04/Prime-ENG_2024_CAT5.pdf
- Racks & inserts catalogue: https://comenda.eu/wp-content/uploads/2024/04/13-CESTELLI-eng900902EN-09.2017.pdf

---

## 7. Cross-cutting notes

- **Two product generations sit side by side in our catalogue.** PC-09/PC 07 are Prime Line
  (electronic panel, 4 programs, Multipower); EC44/EF36M/EB28 are the newer Equilybra entry
  line (electromechanical two-cycle panel, Hydramaster, WRIS®2+). Marketing copy should not
  be shared between them — the Prime hoods' selling point is programmability and throughput,
  Equilybra's is simplicity, low water use and (for EB28/EF36M) single-phase power.
- **EC44 and PC 07 look like the same machine on a spec sheet but are not.** Both are
  500×500 hoods rated 40 racks/h at 7.6–7.7 kW, ~108 kg. They differ on cabinet width (596
  vs 625), tank (32 vs 42 l), rinse water (2.6 vs 2.5 l), booster (5 vs 7 kW), noise (61 vs
  65–67 dB) and control philosophy. Our catalogue prices them **identically at KES 790,000**
  — worth a commercial sanity check, since they are different machines from different lines.
- **`Thermostop` and `WRIS®2+` are trademarked feature names** worth using verbatim in copy;
  `Hydramaster` and `CRC2` (heat-recovery, cold-water connection, ventless) likewise.
- **Every Equilybra model has an `A` softener variant and an `UP` 4-cycle variant.** If the
  supplier ships `EB28 A` or `EC44 UP`, the specs above change (notably `UP` output: 60
  racks/h on EB28 UP / EF36 T UP). Confirm the exact suffix on the next order.
- **Rack sizes are the real compatibility axis for the accessory SKUs**: 500×500 fits
  PC-09, PC 07, EC44 and EF36M; 400×400 fits EB28. That relationship is a natural fit for
  the existing companion-accessory mechanism ([[project_companion_accessories]]).

---

## 8. Image sourcing (July 2026) — downloaded to `Downloads/comenda-images/`

Comenda's website has **no per-model product pages with galleries** — only download pages
listing PDFs. So the primary image source here is the **datasheet PDFs themselves**: each
carries a clean product render on page 1, its rack kit on page 2, and dimensional drawings
on the last page. These were extracted losslessly (`pypdf`) rather than screenshotted.
Reseller photos were pulled with `curl` where the embedded render was too small.

**22 files.** Naming follows the Santos/Brema convention: `<SKU-with-dashes>__<descriptor>.<ext>`.

| SKU | Model | File(s) | Source |
|---|---|---|---|
| IMG/DWW/00085 | PC09 | `PC09-hood-front-official.png` (212×480), `PC09-front-reseller.png` (260×260), `PC09-technical-drawing-1.jpg` + `-2.jpg` (2105×1495 each) | official datasheet (§6) + https://hbg2000.com/wp-content/uploads/2017/03/PC09.png |
| IMG/DWW/00093 | PC07+ | `PC07R-front-reseller.png` (**800×800, best of the two hoods**), `PC07-hood-front-official.png` (212×480), `PC07-technical-drawing-1.jpg` + `-2.jpg` | https://commercialkitchenconstruct.co.uk/cdn/shop/files/PC07R-1_1200x1200.png + official datasheet |
| IMG/DWW/00158 | EC44 | `EC44-hood-front-official.png` (692×1037), `EC44-hood-reseller-1300.jpg` (1300×1300, **watermarked**), `EC44-technical-drawing.png` (1304×1395) | official datasheet + https://www.kitchenpro.gr/image/cache/data/uploads/202509/comenda_equilybra_ec44hood-1300x1300.jpg |
| IMG/DWW/00159 | EF36 M | `EF36M-undercounter-front-official.png` (564×710), `EF36M-technical-drawing.png` (1624×730) | official datasheet |
| IMG/DWW/00160 | EB28 | `EB28-glasswasher-front-official.png` (846×1065), `EB28-technical-drawing.png` (1336×562), plus its rack kit: `EB28-rack-G2-cutlery-holder-official.png`, `EB28-insert-for-cup-dishes-official.png`, `EB28-round-rack-official.png` | official datasheet |
| IMG/DWW/00032 | (generic) | `G-silver-cutlery-container-official.png` (366×251) | official EC44 datasheet p.2 — **the Comenda `G` container, not our 8-compartment beige rack**; reference only (§5.1) |
| IMG/DWW/00033 | (generic) | `combination-rack-400x400-h150-official.jpg` (446×289) | official EB28 datasheet p.2 — the 400×400 h.150 combination rack (§5.2) |
| IMG/DWW/00156 | CB | `CB-combination-rack-official.jpg` (446×289) | official EC44 datasheet p.2 |
| IMG/DWW/00157 | P 12/18 | `P12-18-plate-rack-official.png` (605×460) | official EC44 datasheet p.2 |

Notes for whoever adopts these:

- **PC09 and PC07+ share a byte-identical hero render in Comenda's own datasheets** — the
  same 212×480 PNG appears in both PDFs. That is Comenda's doing, not a mistake on our
  side: the two machines use the same cabinet and differ only in control panel and booster.
  The 800×800 `PC07R-front-reseller.png` is therefore a valid visual for **both** SKUs; the
  visible control-panel graphic is the only thing that differs.
- **Only the technical drawings are print-resolution.** The PC09/PC07 line drawings
  (2105×1495) are the highest-resolution assets in the set, but they are **dimensional
  drawings, not product photos** — useful as spec references (they independently confirm
  the 625/740/1460/1960 figures in §4.1) and not as storefront images.
- **The EC44 reseller image is watermarked** with `kitchenpro.gr` tiled across it. Use the
  official 692×1037 render for the storefront and keep the 1300px one only as a reference.
- **The rack images are catalogue thumbnails** (250–600 px) — adequate for identification,
  marginal as product photos. Comenda's standalone racks catalogue is worse still (its
  images are all ~200 px), so there is no better official source; a real rack photo would
  have to come from stock on hand.
- **Nothing copied into `storage/app/public/products/` and nothing referenced in
  `products.json`** — staged in Downloads for review, same as the Santos and Brema sets.
  Note that 00032, 00156 and 00157 currently have `image: ""` **and** `status: archived`, so
  their photos only matter if those records are revived.

---

## 9. Suggested scope if an enrichment pass follows

Ordered by commercial risk, not by effort:

1. **Build out EC44, EF36M and EB28 from scratch** (§4.3–4.5). Three published, priced SKUs
   with literally no content is the largest gap in this brand.
2. **Give PC-09 a `technical_specification`** and rewrite its description so it stops
   describing PC 07 (§4.1) — particularly the "electromechanical control", "soft start" and
   "double-walled front door" bullets, all of which are wrong for PC09.
3. **Fix the width/height swap** on 00085 and 00093 to 625 × 740 × 1460 mm, and on 00032 to
   500 × 500 × ~100 mm — individually verified, not applied as a blanket transform (the
   Brema pass showed per-SKU checking is mandatory).
4. **Correct the "double-walled" claim** wherever it appears on the Prime hoods; keep it on
   EF36M/EB28 where it is genuinely standard.
5. **Review the identical KES 790,000 pricing** on PC 07 and EC44 (§7) — different lines,
   different machines.
6. **Decide the racks' story** (§5): describe 00032/00033 as generic standard-size racks,
   and if 00156/00157 are ever un-archived, note that `CB-12/18` and `PR` are not Comenda
   codes (`CB` and `P 12/18` are) without editing `model_number`.
7. **Confirm suffixes with the supplier** — `A` (integrated softener) and `UP` (4 cycles)
   variants change the specs above materially (§7).
