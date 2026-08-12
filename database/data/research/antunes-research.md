# Antunes Product Research

Research notes behind an ANTUNES audit pass on `products.json` (July 2026). Covers all 7
ANTUNES SKUs: one vertical contact toaster (VCT-1000), one Gold Standard toaster (GST-1V),
three water-treatment systems (AQ-RO High Capacity, AQ-RO-600, VZN-511V), one hardness
reduction system (HRS-200) and one cup dispenser (DAC-5).

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema, Santos, Hatton and Baron files before a scope
decision.

Headline results:

1. **`GST-1V` is a toaster, not a water treatment system.** It is filed under
   `Hygiene > Water Softeners` with a fabricated water-treatment `short_description`. This
   is the worst single error in the ANTUNES set (§3.2).
2. **All six non-VCT ANTUNES records store their part number under the key `"model"`, not
   `"model_number"` — so the seeder silently drops every one of them** (§5.1). This is a
   catalogue-wide bug affecting 14 records, 6 of them ANTUNES.
3. **IMG/COF/00116's own `name` field claims "BS-1363, 13 Amp" — which matches no Antunes
   VCT-1000 variant, and is below the machine's actual current draw** (§3.1).
4. Every part number that *is* stored is **correct** — 5 of 6 verified against Antunes'
   own documentation, 1 (9710165) unverified (§6).
5. Three records carry dimension strings that contradict the manufacturer: AQ-RO-600 and
   VZN-511V are wrong on two or three axes each (§3.4, §3.6).

---

## 1. Brand identification

**ANTUNES** = **A.J. Antunes & Co.**, a family-owned foodservice-equipment manufacturer in
**Carol Stream, Illinois, USA**, founded **1955** by August J. Antunes. It began as a
manufacturer's rep and pressure-switch maker, entered foodservice the same year with the
circular hot-dog grill it named **Roundup**, and moved to the current Carol Stream plant in
1999. The company later consolidated its sub-brands — **ROUNDUP** and **VISION** were
retired in favour of the single **Antunes** name — which is why older listings, parts
catalogues and used-equipment sites still say "A.J. Antunes – Roundup". Overseas plants in
**Suzhou, China** and **Chennai, India** are printed on every spec sheet.

Product lines relevant to us: contact/conveyor toasters (VCT, GST), steamers, egg stations,
Dial-A-Cup dispensers, and a full commercial water-treatment range (AQ-RO reverse osmosis,
VZN ultrafiltration, HRS hardness reduction).

### `website_url` — currently `null`, should be:

https://antunes.com/

Verified live. **Caveat for whoever applies it:** `antunes.com` sits behind a bot check that
returns a 3.3 KB "Please wait while we verify you're not a bot…" shell to non-browser
clients on most `/water-products/...` and `/water/...` paths. Human browsers are fine, and
`/cooking-products/...` paths and everything under `/wp-content/uploads/` (all the spec
sheets and manuals) serve normally. So the URL is correct and safe to store — it just
resists automated scraping.

---

## 2. Where to look

| Resource | URL | Value |
|---|---|---|
| Manufacturer site | https://antunes.com/ | Correct `website_url`; product pages partly bot-gated |
| Antunes spec sheets & owner's manuals | `https://antunes.com/wp-content/uploads/...` | **The gold source.** Every figure in §3 marked "official" comes from these PDFs — they carry model + Mfg. No. + full dimension/electrical tables |
| Jestic Foodservice (UK distributor) | https://antunes.jestic.co.uk/ | Authorised UK/230 V distributor. Useful independent cross-check on dimensions, and the only good **GST-1V product photography** found |
| Antunes company history | https://antunes.com/about/ | Founding, Roundup/Vision consolidation |
| Resellers (chefsdeal, restaurantsupply, katom, kitchenrestock, chefsupplies.ca, JES) | various | Fallback only; several were caught transposing axes (§4) |

### Traps

1. **`antunes.com` is bot-gated on the water pages** (§1). Everything usable came from the
   PDF library, not the HTML product pages.
2. **Two "AQ-RO-600" products exist with different bodies.** Antunes' own AQ-RO spec sheet
   describes a 472 × 305 × 610 mm wall-mounted panel; US resellers sell an
   "AQ-RO-600 **USRO**" at 470 × 300 × 422 mm. Our record's spec text is a *mixture* of the
   two (§3.4).
3. **Antunes documents mfg numbers, not "model numbers".** Every spec sheet column is
   headed "Model & Mfg. No." — the 7-digit code (e.g. `9211002`) is the manufacturing
   number, the short code (`GST-1V`) is the model. Our catalogue stores the mfg number and
   uses the model code as the product `name`. That's internally consistent; just don't
   "correct" one into the other.
4. **Antunes spec sheets are occasionally self-inconsistent.** The HRS-200 sheet states a
   *shipping* weight (6.9 kg) lower than its own *dry* weight (7.5 kg) — see §3.5.
5. **Reseller spec tables transpose depth and height.** chefsdeal's AQ-RO-600 USRO table
   reads "Width 18.5, Depth 16.6, Height 11.8" directly beneath a manufacturer blurb saying
   `18.5"W x 11.8"D x 16.6"H`. Same axis bug as the Brema/Santos passes, this time in the
   *source*, not our data (§4).

---

## 3. Per-SKU findings

### 3.1 VCT-1000 — Vertical Bun Toaster (IMG/COF/00116) — dimensions perfect, electrical claim wrong

`model_number: 9210710` — **confirmed exactly** on the official Antunes VCT spec sheet
(P/N 1020230). 9210710 is the **10-second pass-through, "with belt wraps"** variant.

| Field | Stored | Official Antunes VCT spec sheet | Verdict |
|---|---|---|---|
| Dimensions | `length 540, width 387, height 616`; prose "540x387x616mm" | 540 (W) × 387 (D) × 616 (H) mm | ✅ **exact, and no axis swap** (§4) |
| Voltage | "230V" (in `name` + spec) | 208–240 V | ✅ 230 V is inside range |
| Frequency | 50/60 Hz | 50/60 Hz | ✅ |
| **Plug** | **"BS-1363"** | **IEC-309 16 A, 250 V pin & sleeve** | ❌ **wrong** |
| **Current** | **"13 AMP"** | **12.5–14.4 A** | ❌ **wrong and unsafe as written** |
| Power | *(absent)* | 2600–3455 W | ❌ missing |
| Pass-through time | *(absent)* | 10 sec | ❌ missing |
| Weight | *(absent)* | 38 kg (81 lb) shipping | ❌ missing |
| Material | *(absent)* | Stainless steel | ❌ missing |
| Belt wraps | *(absent)* | Yes — that's what distinguishes 9210710 | ❌ missing |
| Certifications | *(absent)* | ETL Listed + ETL Sanitation (Intertek), US/Canada | ❌ missing |

**The "BS-1363, 13 Amp" claim in the product `name` is the significant finding.** Scanning
the full VCT-1000 variant table, *no* mfg number ships with a BS-1363 (UK 13 A) plug:

| Mfg. No. | Volts | Watts | Amps | Plug |
|---|---|---|---|---|
| 9210700 | 120 | 1800 | 15 | NEMA 5-15P |
| 9210702 | 208–240 | 2600–3455 | 12.5–14.4 | NEMA 6-20P |
| 9210704 | 208–240 | 2600–3455 | 12.5–14.4 | IEC-309 16 A |
| 9210707 | 208–240 | 2550–3394 | 12.3–17.8 | IEC-309 16 A |
| 9210709 | 208–240 | 2600–3455 | 12.5–14.4 | NEMA 6-20P |
| 9210712 | 220–240 | 1775–2125 | 8.07–8.85 | CEE 7/7 16 A (Schuko) |
| **9210710** | **208–240** | **2600–3455** | **12.5–14.4** | **IEC-309 16 A pin & sleeve** |
| 9210714 | 208–240 | 2600–3455 | 12.5–14.4 | NEMA 6-20P |
| 9210719 | 208–240 | 2600–3455 | 12.5–14.4 | NEMA 6-20P |

At Kenya's 240 V the machine draws up to **14.4 A** — *above* a BS-1363 plug's 13 A fuse
rating. So "BS-1363, 13 Amp" is not merely a cosmetic error: sold as written it implies a
13 A plug top that would nuisance-trip or overheat. Either the supplier ships the IEC-309
unit (in which case the name must be corrected) or they ship a re-plugged local variant
(in which case the *amps* still need correcting). **Confirm with the supplier before
changing the `name`, but do not leave "13 Amp" in the spec.**

The UK distributor independently lists the VCT-1000 as **15 A**, which agrees with Antunes
and disagrees with our record:
https://antunes.jestic.co.uk/product/vct-1000-vertical-contact-toaster/

Other correct details in the record: "dial thermostat", "preset toast times 10 to 28
seconds" — both verbatim-accurate against the official sheet.

**Optional accessories worth listing** (all official P/Ns): bun feeder 7000236, butter wheel
7000238, low-profile bun feeder 7000292, angled bun feeder 7001523. Bun spec: feeder opening
38 mm; crowns and heels 13–22 mm.

### 3.2 GST-1V (IMG/COF/00127) — **MISCATEGORIZED: this is a toaster filed under Water Softeners**

Re-verified from scratch, not taken on trust. `model: 9211002` appears on the official
**Gold Standard Toaster GST-1V** sales sheet, in the row headed `GST-1V / 9211002`. There is
no ambiguity: it is a **3-lane, dual-belt, two-sided vertical contact toaster**.

| Field | Stored | Official Antunes GST-1V sales sheet |
|---|---|---|
| Category | **`Hygiene > Water Softeners`** ❌ | commercial toaster — belongs with IMG/COF/00116 in `Fast Food` |
| `short_description` | "Antunes GST-1V **water treatment system** — engineered to protect and optimise the performance of professional coffee and beverage equipment" ❌ | pure fabrication; describes a product that does not exist |
| Dimensions | *(absent)* | **579.9 (W) × 235.7 (D) × 574.1 (H) mm** |
| Shipping weight | *(absent)* | 39 kg (86 lb) |
| Volts / Watts / Hz | *(absent)* | 220–240 V / 3900 W / 50–60 Hz |
| Plug | *(absent)* | IEC-309 |
| Lanes | *(absent)* | 3, vertical orientation |
| Two-sided toasting | *(absent)* | Yes |
| Motor | *(absent)* | Variable speed, programmable |
| Description/spec | *(absent entirely)* | dual-belt technology; programmable platen temperature + motor speed; adjustable compression; energy-efficient design keeps outer surface cool; continuously moving belts allow immediate feeding |

Jestic UK independently confirms **580 × 236 × 574 mm** and **39 kg** — agreement to within
a millimetre:
https://antunes.jestic.co.uk/product/gst-1v-gold-standard-toaster/

**One unresolved electrical conflict.** Antunes states 220–240 V / 3900 W with an IEC-309
plug; Jestic UK's web page states **"32 Amp 3ph"** — while hosting the very Antunes spec
sheet that says 220–240 V / 3900 W / IEC-309. 3900 W at 230 V single-phase is ~17 A, which
an IEC-309 **16 A** connector would not carry, so the UK unit being 3-phase is plausible —
but 32 A is a big installed supply, and the conflict sits inside one distributor's own
materials. **Flag for supplier confirmation; do not publish an amperage.**

The record is `draft` with `image: ""`, so nothing wrong is currently live — but the
`short_description` and category are both wrong and must be rewritten, not patched.

### 3.3 AQ-HC-RO (IMG/COF/00125) — empty draft; product identified, part number unverified

The record has **no description, no spec, no dimensions, no image** — build-from-scratch.

**Name decode:** the real Antunes designation is **"AQ-RO High Capacity"**; distributors
shorten it to **AQ-RO-HC**. Our `name` "Aq-Hc-Ro" is a letter-order scramble of that. The
product itself is unambiguous.

Official figures (Antunes AQ-RO High Capacity Reverse Osmosis System sales sheet,
`WTR_AQ-RO High Capacity...03272023`):

| Spec | Value |
|---|---|
| Dimensions (W × D × H) | **838 × 203 × 1194 mm** (33" × 8" × 47") |
| Production capacity | 2500 GPD (9464 LPD) |
| TDS reduction | 98% |
| System recovery | 50% |
| Flow rate capacity | 1.74 gpm (6.6 lpm) |
| **Voltage** | **120 V** ⚠ (see below) |
| Inlet connection | 1/2" push-to-connect |
| Permeate connection | 3/8" push-to-connect |
| Drain connection | 3/8" push-to-connect |
| Max feed hardness | 1 grain/gallon |
| Max operating temperature | 45 °C (113 °F) |
| Max pressure drop | 10 psi (0.7 bar) |
| Max feed water SDI | 5 (15 min) |
| Max feed turbidity | 1 NTU |
| Operating pH range | 3–10 |
| Included | feed pump, blend valve, product TDS monitor, feed pressure gauge, feed & concentrate throttle valves, inlet low-pressure switch, tank high-pressure switch |
| Design | compact, wall-mounted, three-stage treatment |

Reseller cross-check agrees on 33 × 8 × 47", 2500 GPD and 98% TDS:
https://www.chefsupplies.ca/products/antunes-33-x-8-x-47-reverse-osmosis-system-aq-ro-hc

**Two cautions:**

- **`model: 9710165` could not be verified.** It does not appear in any Antunes PDF or
  distributor listing found. It is plausible (it sits in the 97101xx water-products block
  alongside the confirmed 9710122 / 9710141-2 / 9710161-4) but it is currently an
  **unsourced** number. Do not treat it as confirmed. Ask the supplier.
- **The published voltage is 120 V.** Kenya is 240 V. Antunes' sheet lists no 220–240 V
  variant of the High Capacity system, unlike the AQ-RO-600 which is explicitly 220 VAC.
  Either a 230 V export variant exists that isn't on this sheet, or a transformer is
  required. **This must be settled with the supplier before publishing** — it is the single
  most commercially important unknown in the ANTUNES set.

### 3.4 AQ-RO-600 Watermark (IMG/COF/00130) — dimensions wrong, permeate line wrong, motor spec unsupported

`model: 9710162` — **confirmed** in Antunes' own RO owner's manual (P/N 1011965 Rev A
08/22), which covers models AQ-RO-400 / -400-NT / -600 / -600-NT under mfg numbers
9710161–9710164. Its parts list settles which is which: RO cartridge **7002304 is fitted to
"9710162 & 9710164 ONLY"**, and the spec table assigns 7002304 to the **600 GPD** models.
So **9710162 = AQ-RO-600**. ✅

**"Watermark" in the product name is real and meaningful** — it is not a typo. That manual
carries a dedicated **Water Mark Listing** section, notes that "the system provides
WaterMark certified DuCV & PRV with water inlet connection size GB1/2", and its parts list
includes P/N `0015600 WATERMARK CERTIFIED DuCV & PRV`. WaterMark is the Australian
plumbing-products certification. Worth keeping in the name and explaining in the copy.

| Field | Stored | Official Antunes | Verdict |
|---|---|---|---|
| Dimensions | "470X230X422mm" | **472 × 305 × 610 mm** (unit, AQ-RO sales sheet) | ❌ **depth and height both wrong** |
| — install envelope | — | 690 × 330 × 800 mm (owner's manual, incl. 200 mm tubing clearance) | ❌ missing |
| Operating weight | *(absent)* | 30 kg (65 lb) | ❌ missing |
| Voltage / power | *(absent)* | **220 VAC (range 120–240 V), 50 Hz, 110 W, 0.5 A** | ❌ missing — the record never says the unit needs a power supply at all |
| Production capacity | 600 GPD (2271 LPD) | 600 GPD (2270 LPD) | ✅ |
| TDS reduction | 96% | 96% (DOW TAPTECT TT-3012-400 membrane) | ✅ |
| Inlet | 3/8" (9.53 mm) tube | 3/8" (9.53 mm) tube | ✅ |
| **Permeate/outlet** | **3/8" (9.53 mm) tube** | **1/4" (6.35 mm) tube** | ❌ **wrong — only the inlet is 3/8"** |
| Drain | 1/4" (6.35 mm) tube | 1/4" (6.35 mm) tube | ✅ |
| **Motor** | **"1/3 HP (0.25 kW)"** | not published; whole system is **110 W** | ❌ **unsupported — 250 W contradicts the 110 W system rating** |
| Tank | *(absent)* | 60 L (15.9 gal) nominal, 1" NPT water connection | ❌ missing |
| Membrane life | *(absent)* | 24 months; PP prefilter 10 µm / carbon 5 µm, both 6 months | ❌ missing |
| Operating window | *(absent)* | 10–100 psi; 4–38 °C; pH 4–10; max TDS 1000 ppm; max hardness 60 gpg; SDI < 5 | ❌ missing |
| Digital display | *(absent)* | colour panel showing status + inlet and product TDS | ❌ missing |

**Where the wrong dimensions came from.** "470 × ? × 422" is the **US "AQ-RO-600 USRO"**
variant sold by American resellers as `18.5"W × 11.8"D × 16.6"H` (= 470 × 300 × 422 mm) —
a physically different box from the 9710162 WaterMark unit. Somebody merged the two spec
sets. And even against *that* variant the stored depth is wrong: 11.8" is **300 mm**, not
230 mm. So the stored triple matches no product at all. The "1/3 HP motor" almost certainly
rode in from the same US source.

Note also the reconciliation between Antunes' own two documents, so nobody "fixes" it later:
the **sales sheet's 472 × 305 × 610 mm is the unit**; the **manual's 690 × 330 × 800 mm is
the installation envelope**, which is the unit plus the manual's own stated "Reserve 200 mm
for tubing connect (100 mm each side)". They are not in conflict.

Existing prose ("three-stage treatment", "adjustable blend valve", "fast flash feature",
"long-lasting pre-filter cartridges") is all accurate — "fast fla**s**h" is a typo for the
official **fast flush** feature.

### 3.5 HRS Hardness Reduction System (IMG/COF/00132) — the cleanest record; real model is HRS-200

`model: 9700562` — **confirmed** on the official Antunes **HRS-200** sales sheet
(P/N 1020442 10/19). Our `name` is the generic "Hrs Hardness Reduction System"; the actual
model designation is **HRS-200** and should appear in the name/spec.

Everything already stored is correct:

| Stored | Official | |
|---|---|---|
| 29–116 psi (2–8 bar) | 29–116 psi (2–8 bar) working pressure | ✅ |
| 39–86 °F operating temperature | 39–86 °F (4–30 °C) water temperature | ✅ |
| 4528 gallon capacity | 4,528 US gal (17,140 L) *with steam generation* | ✅ |
| 0.5 gpm | 0.5 gpm (1.89 lpm) max flow | ✅ |
| 5-step process to remove scale-forming ions | 5-step de-carbonization | ✅ |
| Includes flush valve, carbonate hardness kit, fittings for 1/2" ID hose / 3/8" OD tubing | same, plus cartridge, cartridge head and bracket | ✅ (slightly incomplete) |

Missing and worth adding:

- **Dimensions 185 × 185 × 600 mm** (7¼" × 7¼" × 23⅝") — the record has none.
- **Weight dry 7.5 kg / wet 11 kg**; shipping dims 321 × 632 × 321 mm.
- **Inlet and outlet 3/8" BSP male.**
- **Ambient temperature 38–100 °F (4–40 °C)** — distinct from the water temperature already
  stored.
- **The other three capacity ratings**: 5,434 gal (20,570 L) without steam generation;
  3,434 gal (13,000 L) for combi-steamer/oven; 9,510 gal (36,000 L) for chlorine/taste/odour
  reduction. The stored 4,528 figure is the *steam-generation* case only — quoting it
  unqualified understates the system for non-steam applications.
- **NSF/ANSI Standard 42 certified** (nominal particulate reduction Class I, chlorine, taste
  and odour). Not currently claimed anywhere in the record.
- **Can be installed and operated horizontally or vertically.**
- Consumables: replacement cartridge **7000967**, water meter monitor kit **7000976**,
  carbonate hardness test **7000974**.
- Antunes recommends installing the HRS-200 **after an ultrafiltration system** — which is a
  natural cross-sell to IMG/COF/00131 (VZN-511V).

⚠ **Source inconsistency, do not propagate:** the sheet's shipping weight (15.23 lb /
6.9 kg) is *lower* than its own dry weight (16.53 lb / 7.5 kg), which is impossible. Use the
dry/wet figures; treat the shipping weight as an Antunes typo.

**Category verdict: correct.** A hardness-reduction system genuinely belongs in
`Hygiene > Water Softeners` — this is the only one of the four water SKUs that does.

### 3.6 Ultrafiltration System VZN-511V (IMG/COF/00131) — dimensions wrong on all three axes

`model: 9710122` — **confirmed twice**: on the VZN-511V owner's manual cover
(P/N 1012047 Rev D 06/20) and in the official VZN 500-series sales sheet spec table.

| Field | Stored (prose only — record has no numeric dimension fields) | Official Antunes | Verdict |
|---|---|---|---|
| Dimensions | "622 mm W × 254 mm D × 610 mm H" | **635 (W) × 230 (D) × 690 (H) mm** (25" × 9" × 27") | ❌ **wrong on all three axes** |
| Operating weight | *(absent)* | 25.8 kg (57 lb) | ❌ missing |
| Shipping weight | *(absent)* | 18.1 kg (40 lb) | ❌ missing |
| Flow | "Processes 5.2 GPM" | 5.2 gpm (19 lpm), NSF-certified at that rate | ✅ |
| Micron rating | "0.015-micron particles are removed" | 0.015 µm nominal pore size; MWCO 100 kD | ✅ |
| Self-cleaning / vertical / 1-yr carbon | as stored | vertical system, one carbon cartridge, 1-year carbon life, UF length 10" (25 cm) | ✅ |
| **Electrical** | *(absent — record implies a passive filter)* | **100–240 V, 50/60 Hz, 10 W, 0.08 A**, DC power supply kit 0012146 **with a UK BS 1363 adaptor in the box** | ❌ missing |
| Connections | *(absent)* | inlet / outlet / drain **3/4" FNPT**; rinse **3/4" GHT**; drain must accommodate 5 gpm | ❌ missing |
| Operating limits | *(absent)* | max 100 psig (690 kPa); 4–40 °C; max trans-membrane pressure 45 psi (3.1 bar) | ❌ missing |
| Certifications | *(absent)* | **NSF/ANSI 42** (particulate Class I) **and 53** (cyst 99.95%, turbidity 99.1%) | ❌ missing — a strong selling point currently unstated |
| Consumables | *(absent)* | ultrafilter **7001915 (L-410)**, carbon **7001908** | ❌ missing |

The stored 622 × 254 × 610 corresponds to no Antunes figure and appears to be a rounded-off
invention. Note this is **not** the width/height swap seen on Brema — swapping our stored
numbers still does not produce 635/230/690.

⚠ One genuine conflict *within* Antunes' own documents: the **owner's manual** gives
**pH 3–10**, the **500-series sales sheet** gives **pH 6.5–8.5**. The sales sheet is newer
(04/2024) and narrower; prefer it, or state both.

**Description/spec duplication:** this record's `description` and `technical_specification`
contain the **identical seven-bullet list**, with the `description` simply carrying an intro
paragraph in front of it. Whatever else happens, the spec block should be replaced with real
tabular specs rather than a copy of the marketing bullets.

### 3.7 Cup Dispenser DAC-05 (IMG/COF/00133) — fully resolved; real model is DAC-5

`model: 9900305` — **confirmed** on the official Antunes Dial-A-Cup sales sheet
(P/N 1020220 01/17). The model is **DAC-5** (no zero padding); our name says "DAC-05".

Record is `draft` with `image: ""` and **no description, spec or dimensions at all**.
Everything below is available and sourced:

| Spec | Official value |
|---|---|
| Product | Dial-A-Cup individual tubular cup dispenser, single self-elevating tube |
| Collar diameter | 185 mm (7¼") |
| Tube diameter | 140 mm (5 9/16") |
| Tube length | 578 mm (22¾") |
| Cup rim diameter accepted | 70–108 mm (2¾"–4¼") |
| Cup size range | 8 oz to 32 oz |
| Cup materials | paper, plastic and paper-foam |
| Shipping weight | 3 kg (5 lb) |
| Construction | Stainless steel |
| Mounting | vertical, horizontal or overhead; countertop versions available |
| Warranty | 90 days (all DAC/LS products) |
| Sibling | **9900319** — same DAC-5 but with metal clips that don't mark paper-foam cups |

Independent distributor agreement (both list the same 9900305 figures):
https://www.jesrestaurantequipment.com/antunes-dac-5-9900305.html
https://antunes.jestic.co.uk/product/dac-dial-a-cup/

⚠ Two small source conflicts, resolved in favour of Antunes' own sheet: resellers quote
tube diameter **5 7/8"** vs Antunes' **5 9/16"**; and the DAC sheet's *body copy* says the
family collar fits "8 oz. to 64 oz." while its *DAC-5 table row* says **8–32 oz**. The row
is model-specific and wins.

**Category verdict: acceptable.** `Coffee Machines > Coffee Servery` is a reasonable home
for a beverage-station cup dispenser, though it is an accessory rather than a coffee machine.

---

## 4. The width/height axis-swap check — **negative on both SKUs that carry numeric dimensions**

Only two ANTUNES records have numeric `length`/`width`/`height` fields at all:

| SKU | Stored L/W/H | Source (W × D × H) | Verdict |
|---|---|---|---|
| IMG/COF/00116 (VCT-1000) | 540 / 387 / 616 | 540 × 387 × 616 | ✅ **no swap** — matches positionally and matches its own prose |
| — | — | — | (the other 6 have no dimension fields at all) |

That makes ANTUNES the third brand where the swap had to be checked per-SKU and came back
clean, consistent with §3 of the Santos file: never apply the rotation blind.

**The swap does exist in this pass — but in a *source*, not in our data.** chefsdeal's
AQ-RO-600 USRO spec table lists "Width 18.5″ / Depth 16.6″ / Height 11.8″" immediately below
a manufacturer blurb reading `18.5"W x 11.8"D x 16.6"H`. Anyone rebuilding this record from
a reseller page rather than the Antunes PDF will import a transposed pair. Noted so it isn't
repeated.

Confirmed axis convention for this catalogue while checking: the CREM sibling record
directly above IMG/COF/00133 stores "Dimensions (W × D × H) 325 × 373 × 483" as
`length: 325, width: 373, height: 483` — i.e. `length` holds the **width**, `width` holds the
**depth**. VCT-1000 follows the same mapping.

---

## 5. Cross-cutting notes

### 5.1 Six of the seven ANTUNES part numbers are silently dropped at seed time

`IMG/COF/00125`, `00127`, `00130`, `00131`, `00132` and `00133` store their code under the
key **`"model"`**. `ProductSeeder.php` line 198 reads:

```php
'model_number' => $data['model_number'] ?? null,
```

There is no `model` fallback anywhere in the seeders. **Every one of these six records seeds
with `model_number = null`** — which is exactly why the task brief listed them as having no
model number. The data is present in the JSON and correct; the key is simply wrong.

This is not an ANTUNES-only problem. **14 records catalogue-wide** use `model` without
`model_number`:

| SKU | Brand | `model` value |
|---|---|---|
| IMG/COF/00070 | SHEFFIELD | HLT.12 |
| IMG/COF/00125 | ANTUNES | 9710165 |
| IMG/COF/00130 | ANTUNES | 9710162 |
| IMG/COF/00127 | ANTUNES | 9211002 |
| IMG/COF/00132 | ANTUNES | 9700562 |
| IMG/COF/00131 | ANTUNES | 9710122 |
| IMG/COF/00133 | ANTUNES | 9900305 |
| IMG/COF/00128 | RANCILIO | ROCKY |
| IMG/COF/00054 | SIMONELLI | MICROBAR II |
| IMG/COF/00073 | KALERM | K90L BGS |
| IMG/COF/00074 | KALERM | K905 EBGS |
| IMG/COF/00072 | KALERM | FAB 50 |
| IMG/COF/00071 | KALERM | FAO 30 |
| IMG/COF/00047 | RANCILIO | MAEA03 |

Given the standing rule that `model_number` is the unique ID and must never be changed
casually, the correct fix is a **rename of the key only** (`model` → `model_number`), values
untouched. That is a mechanical, value-preserving edit — but it is catalogue-wide and
touches other brands, so it belongs in its own pass, not this one.

### 5.2 `Hygiene > Water Softeners` is being used as a generic water bucket

Four ANTUNES SKUs sit in it, and only one belongs:

| SKU | Product | Actually is | Category verdict |
|---|---|---|---|
| IMG/COF/00127 | GST-1V | **a 3900 W bun toaster** | ❌ **badly wrong** — move to `Fast Food` with IMG/COF/00116 |
| IMG/COF/00125 | AQ-RO High Capacity | reverse osmosis | ⚠ not a softener |
| IMG/COF/00130 | AQ-RO-600 | reverse osmosis | ⚠ not a softener |
| IMG/COF/00131 | VZN-511V | ultrafiltration (particulate/cyst) | ⚠ not a softener; reduces nothing about hardness |
| IMG/COF/00132 | HRS-200 | hardness reduction | ✅ correct |

The GST-1V one is a hard error and must be fixed. The other three are a taxonomy question:
either rename the node to something like "Water Treatment" with softening as a child, or add
sibling nodes for RO and filtration. Worth noting that the archived Sheffield HLT.12
(IMG/COF/00070) is also in this node, and *is* a genuine softener.

### 5.3 Quill-editor junk and duplicated blocks

- `IMG/COF/00116` and `IMG/COF/00130` are both wrapped in
  `<span style="color: rgb(35, 31, 32);">` — the same Quill artefact stripped in the
  Hatton/Skymsen passes.
- `IMG/COF/00131`'s `description` and `technical_specification` share an identical bullet
  list (§3.6).
- None of the seven follows the prose + `<h3>Key Features</h3>` + `<table>` pattern adopted
  in the Skymsen/HDS/Astar restructures.
- Only IMG/COF/00133 has a `meta_description`; the other six have none.

### 5.4 Electrical data is the systematic gap

Five of the seven records state **no voltage or wattage at all** (GST-1V, AQ-HC-RO,
AQ-RO-600, VZN-511V, DAC-5 — the last legitimately, being unpowered). Both RO systems and
the ultrafiltration unit are **mains-powered** and the records give a buyer no way to know
that. All the figures exist in the manufacturer PDFs and are listed in §3.

Two live electrical questions the supplier must answer:

1. **AQ-RO High Capacity is documented as 120 V only** (§3.3) — no 230 V variant published.
2. **GST-1V**: Antunes says 220–240 V / 3900 W / IEC-309; Jestic UK says 32 A 3-phase
   (§3.2).

And one that affects an already-published record: **VCT-1000's "13 Amp"** vs the machine's
actual 12.5–14.4 A draw (§3.1).

### 5.5 Names carry model codes with drift

| SKU | Stored name | Manufacturer designation |
|---|---|---|
| IMG/COF/00125 | "Aq-Hc-Ro" | **AQ-RO High Capacity** / AQ-RO-HC (letters reordered) |
| IMG/COF/00132 | "Hrs Hardness Reduction System" | **HRS-200** (the "-200" is missing) |
| IMG/COF/00133 | "Cup Dispenser DAC-05" | **DAC-5** (no zero padding) |
| IMG/COF/00130 | "AQ-RO-600 Watermark" | ✅ correct — WaterMark is a real certification (§3.4) |
| IMG/COF/00127 | "GST-1V" | ✅ correct |

None of these affect `model_number`; they are `name`-field cosmetics.

---

## 6. Product reference

| SKU | Catalogue name | Model | Mfg. No. | Official source | Independent source | Confidence |
|---|---|---|---|---|---|---|
| IMG/COF/00116 | Vertical Bun Toaster VCT-1000 230V 50/60HZ BS-1363, 13 Amp | VCT-1000 | 9210710 ✅ | https://antunes.com/wp-content/uploads/2019/03/VCT-1000-Spec-Sheet-Antunes-1020230.pdf | https://antunes.jestic.co.uk/product/vct-1000-vertical-contact-toaster/ | **High** on dimensions, power, plug; the record's own "BS-1363 / 13 A" is **contradicted** (§3.1) |
| IMG/COF/00127 | GST-1V | GST-1V | 9211002 ✅ | https://antunes.jestic.co.uk/wp-content/uploads/sites/33/2024/06/GST-1V-Spec-Sheet-UK.pdf (Antunes' own UK spec sheet; no antunes.com-hosted copy found — see note below) | https://antunes.jestic.co.uk/product/gst-1v-gold-standard-toaster/ | **High** on identity + dimensions + weight; **Low** on amperage (§3.2) |
| IMG/COF/00125 | Aq-Hc-Ro | AQ-RO High Capacity (AQ-RO-HC) | 9710165 ⚠ **unverified** | https://antunes.com/wp-content/uploads/2023/06/WTR_AQ-RO-High-Capacity-Reverse-Osmosis-System_03292023.pdf | https://www.chefsupplies.ca/products/antunes-33-x-8-x-47-reverse-osmosis-system-aq-ro-hc | **High** on specs; **Low** on the part number and on 230 V availability (§3.3) |
| IMG/COF/00130 | AQ-RO-600 Watermark | AQ-RO-600 | 9710162 ✅ | https://antunes.com/wp-content/uploads/2022/09/1011965-Rev-A.pdf and https://antunes.com/wp-content/uploads/2022/11/WTR_AQ-RO_AQ-Reverse-Osmosis-System-_02012022-1.pdf | https://www.chefsdeal.com/antunes-aq-ro-600-usro-for-multiple-applications-water-filtration-system.html (US variant — do not mix, §3.4) | **High** — mfg no. pinned by the manual's cartridge cross-reference |
| IMG/COF/00132 | Hrs Hardness Reduction System | HRS-200 | 9700562 ✅ | https://antunes.com/wp-content/uploads/2021/05/HRS-200-Hardness-Reduction-System-Spec-Sheet.pdf | https://antunes.com/water-products/commercial/hardness-reduction-system/ | **High** — every stored figure confirmed |
| IMG/COF/00131 | Ultrafiltration System VZN-511V | VZN-511V | 9710122 ✅ | https://antunes.com/wp-content/uploads/2024/04/WTR_VZN-541_500-Series-Sales-Sheet_04092024.pdf and https://antunes.com/wp-content/uploads/2020/09/VZN-Ultrafiltration-System-VZN-511V-Owners-Manual.pdf | https://www.kitchenrestock.com/antunes-vzn-511v-vizion-water-filtration-system-vertical-5-2-gallons-19-liters-per-minute.html | **High** — two official documents agree on 635×230×690 and 5.2 gpm |
| IMG/COF/00133 | Cup Dispenser DAC-05 | DAC-5 | 9900305 ✅ | https://antunes.jestic.co.uk/wp-content/uploads/sites/33/2021/06/5e46cdcc99d45.pdf (Antunes DAC sales sheet P/N 1020220, hosted by the UK distributor) | https://www.jesrestaurantequipment.com/antunes-dac-5-9900305.html | **High** — official model-specific table row |

Supporting documents used for triangulation:

https://antunes.com/wp-content/uploads/2021/05/AQ-RO-400-Owners-Manual.pdf

https://antunes.com/about/

https://antunes.jestic.co.uk/

https://antunes.com/wp-content/uploads/2021/05/HRS-200-Hardness-Reduction-System-Owners-Manual-9700562.pdf

**Note on the GST-1V source.** Every URL in the table above was re-tested and returns HTTP
200. The one worth explaining is GST-1V: **no antunes.com-hosted GST-1V spec sheet could be
found** — the corporate site publishes GST-1H / GST-2H / GST-2V / GST-3V / GST-5V sheets but
not 1V. The document cited is Antunes' own artwork (same layout, same "Gold Standard Toaster
| GST-1V" running head, same `Model & Mfg. No. / GST-1V / 9211002` table) hosted on the UK
distributor's server as `GST-1V-Spec-Sheet-UK.pdf`. It is a manufacturer document, not a
reseller rewrite — but it is a **UK-market** edition, which is worth remembering when
reading its 220–240 V rating. It is also the reason the GST-1V amperage question in §3.2 is
awkward: Jestic's own web page says "32 Amp 3ph" while the Antunes spec sheet Jestic itself
hosts says 220–240 V / 3900 W / IEC-309. The conflict is internal to a single distributor's
own materials.

---

## 7. Image sourcing (July 2026) — downloaded to `Downloads/antunes-images/`

**21 files.** Three source types, all pulled with `curl`:

1. **Official Antunes renders extracted from the spec-sheet PDFs.** Antunes embeds
   full-resolution product photography in its sales sheets (700–950 px, transparent/black
   backgrounds). These were extracted losslessly from the downloaded PDFs and converted to
   PNG. This is the highest-quality source available, since antunes.com's HTML product pages
   are bot-gated (§1).
2. **Jestic (UK distributor) product photography**, fetched directly from
   `antunes.jestic.co.uk/wp-content/uploads/sites/33/...` with a browser User-Agent and
   matching Referer. This is the **only** source of real GST-1V photography.
3. **WebstaurantStore `xxl` renditions** (added in the July 2026 re-sourcing pass) — see the
   note on that path below. Only one Antunes SKU has a US listing at all.

**Every file was opened and visually classified.** Three stock-photo banners that Antunes
embeds in its own sales sheets (a plate of wraps on the GST-1V sheet, iced drinks on the
AQ-RO-HC sheet, a glass of water on the AQ-RO sheet) were downloaded, identified as
marketing filler rather than product shots, and **deleted**. Two further images are the
wrong Dial-A-Cup model and were kept but renamed to say so.

| SKU | File | px | Size | Source | Content |
|---|---|---|---|---|---|
| IMG/COF/00116 | `IMG-COF-00116__VCT-1000-official-front.png` | 788 × 903 | 878 KB | Antunes VCT spec sheet | ✅ VCT-1000, plain, **dial thermostat** visible. Best storefront candidate |
| IMG/COF/00116 | `IMG-COF-00116__VCT-1000-official-butterwheel-bunfeeder.png` | 765 × 1123 | 868 KB | Antunes VCT spec sheet | ✅ VCT-1000 fitted with motorised butter wheel + angled bun feeder (accessories, not standard) |
| IMG/COF/00116 | `IMG-COF-00116__VCT-1000-jestic-TOOSMALL.jpg` | 500 × 500 | 34 KB | Jestic | ✅ VCT-1000, dial thermostat, buns loaded. **Proven capped — see §7.1** |
| IMG/COF/00127 | `IMG-COF-00127__GST-1V-official-front.png` | 799 × 897 | 344 KB | Antunes GST-1V sales sheet | ✅ GST-1V, 3-lane top hopper, blue rotary control |
| IMG/COF/00127 | `IMG-COF-00127__GST-1V-left-jestic.jpg` | 1420 × 1504 | 213 KB | Jestic | ✅ GST-1V left three-quarter, blue rotary control |
| IMG/COF/00127 | `IMG-COF-00127__GST-1V-right-jestic.png` | 1486 × 1504 | 1.6 MB | Jestic | ✅ GST-1V right three-quarter — **digital control panel** version (see note below). Highest-resolution image in the set |
| IMG/COF/00127 | `IMG-COF-00127__GST-1V-official-belt-detail.png` | 857 × 725 | 301 KB | Antunes GST-1V sales sheet | ✅ GST-1V with front panel removed, blue dual belts exposed. **Not a dimension drawing** despite looking technical — it's a photo |
| IMG/COF/00125 | `IMG-COF-00125__AQ-RO-HC-official-front.png` | 730 × 924 | 362 KB | Antunes AQ-RO HC sales sheet | ✅ AQ-RO High Capacity — membrane vessel, feed pump, gauge, two prefilter bowls on a wall panel. Only product shot found |
| IMG/COF/00130 | `IMG-COF-00130__AQ-RO-600-official-front.png` | 932 × 1067 | 528 KB | Antunes AQ-RO sales sheet | ✅ AQ-RO with digital colour display + pressure gauge + two prefilters |
| IMG/COF/00131 | `IMG-COF-00131__VZN-500-series-official-vertical.png` | 386 × 826 | 163 KB | Antunes VZN 500-series sales sheet | ⚠ VZN vertical system — the 500-series sheet does not label which model each render is, so this is **series-representative, not confirmed 511V**. Narrow (386 px wide) but 826 px on the long edge |
| IMG/COF/00131 | `IMG-COF-00131__VZN-511V-reseller.jpg` | 1000 × 1000 | 47 KB | kitchenrestock CDN | ✅ VZN-511V listing photo — vertical UF vessel, blue tank, single white carbon cartridge. Matches the official "vertical system with one carbon cartridge" description. Largest available but only 47 KB |
| IMG/COF/00132 | `IMG-COF-00132__HRS-200-official-cartridge.png` | 695 × 1866 | 776 KB | Antunes HRS-200 sales sheet | ✅ HRS-200 cartridge with blue head. Tall aspect ratio (1:2.7) — will need padding for a square product tile |
| IMG/COF/00133 | `IMG-COF-00133__DAC-5-9900305-webstaurant.jpg` | **1500 × 1500** | 80 KB | WebstaurantStore `xxl` | 🆕 ✅ **New best DAC-5 storefront candidate.** Listed against the exact part **9900305**: single tube, black self-elevating collar, mounting hardware laid out beside it, clean white background |
| IMG/COF/00133 | `IMG-COF-00133__DAC-5-official-collar-topview.png` | **1591 × 865** | 1.5 MB | Antunes DAC Sales Sheet 1050034 | 🆕 ✅ Tube dispensing a printed cup **plus** a separate top-down view of the collar showing the internal gripper fingers. Transparent background |
| IMG/COF/00133 | `IMG-COF-00133__DAC-5-official-dispensing-cup.png` | **985 × 864** | 770 KB | Antunes DAC Sales Sheet 1050034 | 🆕 ✅ Tube + black collar mid-dispense with a red cup emerging. Transparent background |
| IMG/COF/00133 | `IMG-COF-00133__DAC-5-official-tube-collar.png` | **933 × 667** | 627 KB | Antunes DAC Sales Sheet 1050034 | 🆕 ✅ Tube + black collar, empty, horizontal. Cleanest official DAC render above the bar |
| IMG/COF/00133 | `IMG-COF-00133__DAC-5-official-collar-detail-TOOSMALL.png` | 779 × 590 | 321 KB | Antunes DAC Spec Sheet 1020220 | ✅ Close-up of the self-elevating collar mechanism. **Proven capped — see §7.1** |
| IMG/COF/00133 | `IMG-COF-00133__DAC-5-official-tube-TOOSMALL.png` | 326 × 585 | 137 KB | Antunes DAC Spec Sheet 1020220 | ✅ Single DAC tube with black collar + a loose collar alongside. **Proven capped — see §7.1** |
| IMG/COF/00133 | `IMG-COF-00133__DAC-5-jestic-single-tube-TOOSMALL.jpg` | 500 × 500 | 9.7 KB | Jestic | ✅ Single tube, **stainless** collar, cup loaded. **Proven capped — see §7.1** |
| IMG/COF/00133 | `IMG-COF-00133__DACS-30-official-cabinet-NOT-DAC-5.png` | 340 × 727 | 326 KB | Antunes DAC sales sheet | ❌ **wrong model** — this is the DACS-30 three-tube stainless cabinet |
| IMG/COF/00133 | `IMG-COF-00133__LS-series-cabinet-NOT-DAC-5.jpg` | 500 × 500 | 29 KB | Jestic | ❌ **wrong model** — LS-series cabinet with lid and straw compartments |

### 7.1 Re-sourcing pass (July 2026) — minimum resolution 800 px on the long edge

Four files were staged before the resolution rule existed. **All four turned out to be
genuinely capped**, so all four were kept and suffixed `-TOOSMALL` rather than deleted.
Nothing was deleted from the Antunes set. Four new files above the bar were added instead,
all of them official Antunes or exact-part-number material. The `NOT-DAC-5` labelling on the
two wrong-model Dial-A-Cup images is untouched.

**Where the higher-resolution DAC-5 material came from.** The 2019 **DAC Sales Sheet
P/N 1050034** (https://antunes.com/wp-content/uploads/2019/03/DAC-Sales-Sheet-Antunes-1050034.pdf,
9.2 MB) is a different and much older photo set than the DAC Spec Sheet 1020220 the first
pass used, and it embeds print-resolution objects up to 1591 × 865. Extraction detail that
matters: these objects carry **soft masks**, and `doc.extract_image(xref)` returns the colour
plane *without* the mask, which renders as heavy black speckle over the background. The
correct call is `fitz.Pixmap(fitz.Pixmap(doc, xref), fitz.Pixmap(doc, smask))`, taking the
smask xref from `page.get_images(full=True)[n][1]`. Every image object is lossless out of the
PDF, so there is no upscale risk on this route.

**WebstaurantStore `xxl`.** The path segment is a size name, and `xxl` is an undocumented
rendition above `extra_large` that is **native-capped, never upscaled**. Antunes 9900305
returns 1000 × 1000 from `extra_large` and 1500 × 1500 from `xxl`; an FFT radial-energy check
against a Lanczos 1000→1500 control confirmed genuine detail (0.041 relative energy in the
top band vs 0.022 for the synthetic upscale). Only one Antunes SKU has a WebstaurantStore
listing — searches for `vct-1000` and `9210710` return nothing.

Source URLs for the four new files:

https://cdnimg.webstaurantstore.com/images/products/xxl/508881/1886439.jpg
https://www.webstaurantstore.com/a-j-antunes-9900305-cup-dispenser/HP9900305.html
https://antunes.com/wp-content/uploads/2019/03/DAC-Sales-Sheet-Antunes-1050034.pdf

Other Dial-A-Cup PDFs downloaded and exhausted while proving the caps:

https://antunes.com/wp-content/uploads/2019/03/DAC-Spec-Sheet-Antunes-1020220.pdf
https://antunes.com/wp-content/uploads/2021/12/PDR_DAC_Dial-A-Cup-Dispenser-Sales-Sheet_09302021.pdf
https://antunes.com/wp-content/uploads/2023/05/PDR_DAC_Dial-A-Cup-Dispenser-Sales-Sheet_05012023.pdf
https://antunes.com/wp-content/uploads/2025/10/PDR_DAC_Dial-A-Cup-Dispenser-Sales-Sheet_10132025.pdf
https://antunes.com/wp-content/uploads/VCT-Sales-Sheet-Antunes-1050030.pdf
https://antunes.com/wp-content/uploads/2024/04/PDR_VCT-1000_Vertical-Contact-Toaster-Sales-Sheet_04102024.pdf
https://antunes.com/wp-content/uploads/2023/05/PDR_VCT-1000_Vertical-Contact-Toaster-Sales-Sheet_05012023.pdf

The Dial-A-Cup PDF list was enumerated from the Wayback CDX index
(`http://web.archive.org/cdx/search/cdx?url=antunes.com/wp-content/uploads/*&fl=original&collapse=urlkey`),
which is the practical way around the bot gate — antunes.com returns the same 3.3 KB
"verify you're not a bot" shell for `/?s=`, `/product-sitemap.xml` and `/sitemap_index.xml`
alike, so the PDF library cannot be discovered from the site itself, only fetched from it.

**Proof of cap, file by file:**

| File | Cap | What was probed |
|---|---|---|
| `IMG-COF-00116__VCT-1000-jestic-TOOSMALL.jpg` | 500 × 500 | The Jestic **original** is itself 500 × 500 — `.../sites/33/2021/06/vertical-5.jpg` is the unsized upload, and `-scaled`, `-1024x1024`, `-1536x1536`, `-2048x2048` all 404. Antunes' own VCT-1000 sales sheets from 2023-05 and 2024-04 carry the equivalent render at only 629 × 881. `VCT-Sales-Sheet-Antunes-1050030` does hold an 810 × 948 render, but it is the **digital-panel** generation, not the dial thermostat this record needs — see the panel-mismatch note in the audit below, so it is **not** a substitute. No US reseller stocks the VCT-1000: WebstaurantStore search returns nothing for `vct-1000` or `9210710`, KaTom `193-9210710` and `193-VCT1000` both 404, jesrestaurantequipment search 404s |
| `IMG-COF-00133__DAC-5-official-tube-TOOSMALL.png` | 326 × 585 | Native embedded size in DAC Spec Sheet 1020220, confirmed lossless with no soft mask. The **same photograph** appears in the 2021-09, 2023-05 and 2025-10 Dial-A-Cup sales sheets at 345 × 541 — i.e. smaller. 585 px is the ceiling for this shot |
| `IMG-COF-00133__DAC-5-official-collar-detail-TOOSMALL.png` | 779 × 590 | Native embedded size in DAC Spec Sheet 1020220, lossless, no soft mask. It appears in **no other** Antunes PDF — all five Dial-A-Cup PDFs on antunes.com plus the Jestic-hosted copy were downloaded and fully extracted. The Jestic copy of the spec sheet is a byte-identical file |
| `IMG-COF-00133__DAC-5-jestic-single-tube-TOOSMALL.jpg` | 500 × 500 | The Jestic original `.../sites/33/2021/06/cup-1.jpg` is itself 500 × 500 with no WordPress size variants. jesrestaurantequipment serves the same subject at only 400 × 400 (`assets/images/products/antu/...`; `large/` and `zoom/` variants 404) |

Note that the new `DAC-5-9900305-webstaurant.jpg` shows a **black** collar while the retained
Jestic shot shows a **stainless** one. The WebstaurantStore listing is against part 9900305,
the code stored on this record, so the black collar is the finish to expect — a small extra
reason to prefer the new file on the storefront.

### Two generations of GST-1V control panel

`GST-1V-left-jestic.jpg` and the official front render show a **blue rotary control**;
`GST-1V-right-jestic.png` shows a **digital display panel** on the same cabinet. Both are
genuine GST-1V units — the sales sheet advertises "programmable controls … platen heater
temperature and motor speed", which fits the digital panel. Same trap shape as Brema's
"2.0 Wi" cosmetic generations: pick whichever matches what the supplier actually ships.

### Audit of the four images already in the catalogue

| SKU | Existing file | Size | Verdict |
|---|---|---|---|
| IMG/COF/00116 | `vertical-bun-toaster-...-imgcof00116.png` | 28 KB | ⚠ **control-panel mismatch.** Correct VCT body, but the photo shows a **digital blue panel**, while mfg 9210710 and the record's own description specify a **dial thermostat**. Replace with `...official-front.png` |
| IMG/COF/00130 | `aq-ro-600-watermark-imgcof00130.png` | 20 KB | ⚠ Right product, but an **older cosmetic generation** (horizontal membrane vessel above the panel) *and* it has the caption **"AQ-RO-600 System" burned into the image**. Baked-in text is bad for a storefront tile. Replace |
| IMG/COF/00132 | `hrs-hardness-reduction-system-imgcof00132.jpg` | 9.9 KB | ✅ Correct HRS-200 cartridge — note the head is **BWT**-branded, confirming Antunes OEMs this cartridge from BWT. Very low resolution; the official render is 80× larger |
| IMG/COF/00131 | `ultrafiltration-system-vzn-511v-imgcof00131.jpg` | 34 KB | ❌ **Worst of the four.** It is a **cropped marketing infographic**, not a product photo — call-out labels run off the right edge mid-word ("EFFICIENT OPERA…", "MICROBIOLOGICA…", "…small as 0.015 micro…"). Must be replaced |

**Not copied into `storage/app/public/products/` and not referenced in `products.json`** —
staged in `Downloads/antunes-images/` for review, same as the Brema, Santos and Hatton sets.

---

## 8. Recommended actions (nothing applied)

Ordered by value, all deliberately left unapplied:

1. **Fix IMG/COF/00127 (GST-1V).** Move out of `Hygiene > Water Softeners` into `Fast Food`;
   delete the fabricated water-treatment `short_description` and write toaster copy; add the
   official specs from §3.2. This is the only outright *category* error in the set.
2. **Fix IMG/COF/00116's electrical claim.** "BS-1363, 13 Amp" appears in the product `name`
   of a **published** record and understates a 14.4 A machine (§3.1). Confirm the supplied
   plug type with the supplier, then correct both the `name` and the spec.
3. **Correct IMG/COF/00130's dimensions** from `470X230X422mm` to **472 × 305 × 610 mm**,
   correct the permeate line from 3/8" to **1/4"**, and drop the unsupported "1/3 HP
   (0.25 kW)" motor line in favour of the real **220 VAC / 50 Hz / 110 W / 0.5 A** rating
   (§3.4).
4. **Correct IMG/COF/00131's dimensions** from `622 × 254 × 610` to **635 × 230 × 690 mm**,
   add the 100–240 V / 10 W supply, 3/4" FNPT connections, 25.8 kg operating weight and the
   NSF/ANSI 42 + 53 certifications, and stop duplicating the marketing bullets into
   `technical_specification` (§3.6).
5. **Build out the three empty drafts** — IMG/COF/00125 (AQ-RO-HC), IMG/COF/00127 (GST-1V)
   and IMG/COF/00133 (DAC-5) have no description, spec or dimensions at all. All the data is
   in §3.3, §3.2 and §3.7 respectively.
6. **Add HRS-200's missing dimensions, weights, connections, NSF/ANSI 42 claim and the three
   additional capacity ratings** (§3.5), and qualify the stored 4,528 gal figure as the
   *with-steam-generation* case.
7. **Replace the IMG/COF/00131 product image** — it is a cropped infographic with text
   running off the edge (§7). Then IMG/COF/00116 and IMG/COF/00130.
8. **Set `brands.json` `website_url` to https://antunes.com/** — currently `null` (§1).
9. **Ask the supplier three questions:** (a) does a 230 V AQ-RO High Capacity exist, or is
   the 120 V rating final; (b) is the GST-1V supplied single-phase 16 A or 3-phase 32 A;
   (c) which plug ships on the VCT-1000. All three are electrical and none is answerable
   from published data (§5.4).
10. **Restructure all seven** to the prose + `<h3>Key Features</h3>` + `<table>` pattern,
    strip the `rgb(35, 31, 32)` Quill spans, and add `short_description` +
    `meta_description` where absent (§5.3).

Separate, larger-scope and deliberately out of this pass:

- **The `model` → `model_number` key rename** (§5.1). It silently nulls 6 of 7 ANTUNES part
  numbers plus 8 records from four other brands. Mechanical and value-preserving, but
  catalogue-wide.
- **Rethinking the `Hygiene > Water Softeners` node** (§5.2), which currently holds two RO
  systems and an ultrafilter alongside two genuine softeners.

Deliberately **not** recommended: changing any `model_number`/`model` **value** (all six
verified codes are correct, and 9710165 is unverified rather than wrong — §3.3); and
adopting the US "AQ-RO-600 USRO" figures for IMG/COF/00130, which describe a different
physical unit (§3.4).
