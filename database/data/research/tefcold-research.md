# Tefcold Product Research

Covers the 2 TEFCOLD SKUs (BC 60 and BC 85-1 bottle coolers, both Cold Displays).

Partly supersedes `old/tefcold-waring-research.md`, which combined Tefcold with Waring and
predates the SAP export. **The Waring half of that file is not superseded** - this pass covered
Tefcold only, so `old/tefcold-waring-research.md` remains the reference for WDM120K and WCT805K.

Staging folder: `Desktop\ecommerce\products resorce final\tefcold\`
Nothing in `products.json`, `brands.json` or `storage/` was changed by this pass.

---

## 1. Brand

**Tefcold A/S**, 1 Industrivej, DK-8800 Viborg, Denmark - confirmed from the company's own EU
regulatory filings, not just its marketing site. `brands.json` already has
`website_url: https://www.tefcold.com/`, which is live and correct. **No `brands.json` change.**

Tefcold runs a headless commerce site; `headlessapi.tefcold.com` serves all imagery, resized on
the fly from a base64-encoded source path.

Product pages:
https://www.tefcold.com/bc60-16071
https://www.tefcold.com/bc85-w-fan-34024
https://www.tefcold.com/sitemap/products

---

## 2. Body/model verification - the two coolers are easy to tell apart

| | BC 60 (IMG/DIS/00042) | BC 85-1 (IMG/DIS/00060) |
|---|---|---|
| Exterior | **black** | **white** |
| Door | 1 hinged self-closing **flat** glass door | 1 hinged **curved** glass door, reversible |
| Thermometer | **no** | **yes** - digital display in the fascia |
| Shelves | 3 black wire, 340 x 270/205 mm | 3 white wire, 406 x 355 mm |
| Volume gross / net | 67 / 58 L | 92 / 85 L |
| Capacity | 40 bottles / 70 cans 330 ml | 43 bottles / 93 cans 330 ml |
| External W x D x H | 432 x 496 x 668 | 503 x 567 x 775 |

**Both are single-door**, so door count is not the discriminator - colour, the digital display
and size are. All three are visible in the sourced photographs and the two sets were compared
side by side before anything was accepted.

The BC 60 set includes a **shipping-carton photograph** whose printed label reads
`MODEL: BC60 / BOTTLE COOLER / 220-240V/50Hz / SCHUKO / COLOR: BLACK / STACKING: 3` -
independent confirmation of model, colour and 50 Hz supply.

---

## 3. ⚠ SAP's BC 60 remark is contaminated - and gets the refrigerant wrong

### BC 60 (IMG/DIS/00042)

| Field | SAP remark | Tefcold's page | |
|---|---|---|---|
| **Refrigerant** | **R134a** | **R600a** | ⚠ **SAP WRONG** |
| **Charge** | **50 g** | **24 g** | ⚠ wrong |
| **Input power** | **100 W** | **70 W** | ⚠ wrong |
| **Energy** | **0.83 kWh/24h** | **0.56 kWh/24h** | ⚠ wrong |
| **Gross / net weight** | **36 / 33 kg** | **32 / 29 kg** | ⚠ wrong |
| External / internal dims, volumes, noise, temp range, climate class, voltage | | | all exact |

### BC 85-1 (IMG/DIS/00060)

| Field | SAP remark | Tefcold's page | |
|---|---|---|---|
| **Input power** | **100 W** | **165 W** | ⚠ **SAP wrong** |
| **Gross weight** | **36 kg** | **38 kg** | ⚠ wrong |
| Refrigerant R600a 28 g, dims, volumes, energy, net weight | | | all exact |

### 3.1 The contamination, spelled out

**SAP gives BOTH rows the identical `Gross Weight kg. 36. Net. Weight kg. 33` and the identical
`Rated Input Power W. 100`.**

- 33 kg net is right for the **BC 85-1** and wrong for the BC 60 (29 kg) - the BC 60 row
  inherited the BC 85-1 row's weight pair.
- 100 W is right for **neither** (70 W and 165 W) - it is foreign to both rows, imported from
  some third model.

Cross-row contamination, exactly as the general SAP guidance predicts. Note that the
**dimension fields are the ones SAP got perfectly right** on both rows; it is the remark prose
that is contaminated.

### 3.2 🔴 The refrigerant error matters

SAP says the BC 60 runs **R134a**. Tefcold says **R600a** (isobutane - a flammable hydrocarbon,
24 g charge), and the spare-parts list on the same page corroborates it independently: part 23
is `Thermostat R600`. A servicing engineer told R134a would bring the wrong gas and the wrong
safety procedure.

---

## 4. SAP column order: width, depth, height

| SKU | SAP length / width / height | Tefcold External (W x D x H) | |
|---|---|---|---|
| IMG/DIS/00042 | 432 / 496 / 668 | 432 x 496 x 668 | **exact** |
| IMG/DIS/00060 | 503 / 567 / 775 | 503 x 567 x 775 | **exact** |

**SAP's order for TEFCOLD is `width, depth, height`** - same as BREMA, and the **opposite of
PASMO** (depth-first), both of which were verified against manufacturer documents in the same
session. Two rows, both exact to the millimetre. This is the cleanest dimension data of the four
brands in this pass.

Our `products.json` values match SAP and the manufacturer on both SKUs. **Nothing to fix** - and
in particular the width/height transposition the old research reported on BC 85-1 has already
been applied and is now correct.

---

## 5. Tefcold publishes no datasheet PDF - the EU register does

The product pages carry a "Product Sheet" tab but no PDF URL exists anywhere in the
server-rendered HTML, and no `/files`, `/download` or `/documents` path could be found. Every
spec lives as structured HTML.

**The substitute is the EU EPREL register.** Both pages publish an EPREL number (BC 60: 442284;
BC 85-1: 442292), and EPREL serves the manufacturer's own legally-filed Product Information
Sheet plus the official energy label:

https://eprel.ec.europa.eu/api/products/refrigeratingappliancesdirectsalesfunction/442284/fiches?language=EN
https://eprel.ec.europa.eu/api/products/refrigeratingappliancesdirectsalesfunction/442284/labels?language=EN
https://eprel.ec.europa.eu/api/products/refrigeratingappliancesdirectsalesfunction/442292/fiches?language=EN
https://eprel.ec.europa.eu/api/products/refrigeratingappliancesdirectsalesfunction/442292/labels?language=EN

⚠ Mechanics worth reusing on any EU appliance brand: `/api/products/<id>/fiches` **without** the
product-group segment 404s, and the correct path returns a **301 that curl will not follow
without `-L`** - so a naive fetch looks like a dead end. The `labels` endpoint returns a **ZIP**
(SVG + PNG + PDF + thumbnail).

Both fiches are filed by **Tefcold A/S, 1 Industrivej, DK-8800 Viborg** - the manufacturer
itself.

### 5.1 EPREL settles the "BC 85-1" model-number question

EPREL records Tefcold's own registered model identifiers:

- BC 60 -> **`BC60-I`**
- BC 85-1 -> **`BC85I W F`**

The old research read the rating plate as "BC85[I] w/Fan" and guessed the stylised character was
an "I" that our catalogue had transcribed as "1". **EPREL confirms it**: Tefcold's own registered
string is `BC85I W F`. Our `BC 85-1` is a faithful transcription of a real Tefcold identifier,
not a data-entry error.

**No `model_number` change proposed** - this is evidence the existing one is right.

### 5.2 One unreconciled conflict

EPREL gives the BC 85-1's annual energy consumption as **306 kWh/a**; tefcold.com says
**387 kWh/year**. Both are Tefcold's own numbers. Recorded, not silently resolved.

---

## 6. Full specification (from tefcold.com, corroborated by the EPREL fiches)

| | BC 60 | BC 85-1 (BC85 w/Fan) |
|---|---|---|
| Item no. | 16071 | 34024 (substitution for 15884 BC85) |
| EAN | 5708181501235 | 5708181994624 |
| EPREL | 442284 | 442292 |
| External W x D x H mm | 432 x 496 x 668 | 503 x 567 x 775 |
| Internal W x D x H mm | 356 x 311 x 557 | 410 x 415 x 630 |
| Packed W x D x H mm | 480 x 550 x 700 | 570 x 610 x 810 |
| Gross / net weight | 32 / 29 kg | 38 / 33 kg |
| Gross / net volume | 67 / 58 L | 92 / 85 L |
| Display area | 0.187 m² | 0.263 m² |
| Capacity | 40 bottles 330 ml; 70 cans 330 ml; 55 cans 500 ml | 43 bottles 330/500 ml PET; 93 cans 330 ml; 68 cans 500 ml |
| Temperature range | +2 to +10 °C | +2 to +10 °C |
| Climate class | 4 | 4 |
| Max ambient | +30 °C, 55% RH | +30 °C, 55% RH |
| Exterior / interior | black / coated aluminium black | white / white ABS |
| Door | 1 hinged self-closing glass, not reversible | 1 hinged curved glass, reversible |
| Shelves | 3 black wire, 340 x 270/205 mm | 3 white wire, 406 x 355 mm |
| Max shelf load | 196 kg/m² | 196 kg/m² |
| Feet | 4 adjustable | 4 adjustable |
| Lock | yes | yes |
| Interior light | LED | LED |
| Cooling / defrost / control | fan assisted / automatic / mechanical | fan assisted / automatic / mechanical |
| Thermometer | no | yes |
| **Refrigerant** | **R600a, 24 g** | **R600a, 28 g** |
| Energy class / EEI | C / 22 % | C / 31 % |
| Energy consumption | 0.56 kWh/24h, 204 kWh/year | 1.06 kWh/24h, 387 kWh/year (EPREL: 306) |
| Input power | **70 W** | **165 W** |
| Voltage / frequency | 220-240 V / 50 Hz | 220-240 V / 50 Hz |
| Noise | 44 dB(A) | 45 dB(A) |
| 40 ft container load | 288 pcs | 228 pcs |

Both are **220-240 V / 50 Hz single phase** - correct for Kenya, no US-voltage risk on this
brand at all.

---

## 7. Imagery

| SKU | Files | Best px | Source |
|---|---|---|---|
| IMG/DIS/00042 BC 60 | 5 | 3000x3000 | https://www.tefcold.com/bc60-16071 |
| IMG/DIS/00060 BC 85-1 | 5 | **4134x5600** | https://www.tefcold.com/bc85-w-fan-34024 |

Plus 2 EU energy labels (PDF + 1134x2268 PNG) and 2 EU product information sheets.

### 7.1 ⚠ The recorded ceiling was wrong by a factor of three

The old research recorded Tefcold's ceiling as **1600x1600**, obtained by substituting `1600`
into the CDN's size parameters. The CDN actually **clamps to the native asset size**, so
requesting an absurd size returns the original:

| Asset | request 1600 | request 4000 | request 6000 | request 9000 |
|---|---|---|---|---|
| BC 60 hero | 693x1600 | **1083x2500** | 1083x2500 | - |
| BC 60 interior | 1600x1600 | **3000x3000** | 3000x3000 | - |
| BC 85-1 hero (TIFF source) | 1600x1600 | 2953x4000 | **4134x5600** | 4134x5600 |

**Proven ceiling: 4134x5600.** Requesting 9000 returns the same, which is what proves it is
native rather than another cap.

Two mechanics worth reusing:

- The base64 segment in the URL **includes the file extension** (`...LnBuZw==` = `.png`).
  Truncating it before the padding returns a **500**, which reads like a block rather than a
  malformed request.
- **Decoding the base64 reveals the source file type.** The BC 85-1 gallery decodes to `.tif`
  paths - which is the signal those assets would go far beyond 1600 px, and why they were
  re-fetched at 6000.

⚠ Do not read the tall BC 60 canvases as high detail: `-1` and `-2` are 1083x2500 but the cooler
occupies only the lower ~55% of the frame, so effective product detail is nearer 1083x1400.

### 7.2 Nothing AI-generated

`_ai-generated/` is empty. These are real photographs - the carton shot is on an actual
warehouse floor with real cast shadows, the stocked shots contain real branded cans and produce,
and the interior shots show physically consistent LED spill and fan grilles. Every image was
opened.

`_brand-reference/` is also empty: everything found for this brand belongs to a specific SKU.

---

## 8. Product reference

| SKU | model_number | EPREL identifier | Official page | Confidence |
|---|---|---|---|---|
| IMG/DIS/00042 | BC 60 | `BC60-I` | https://www.tefcold.com/bc60-16071 | **High** - exact code, EAN and EPREL all match |
| IMG/DIS/00060 | BC 85-1 | `BC85I W F` | https://www.tefcold.com/bc85-w-fan-34024 | **High** - EAN identical to the stored record, EPREL identifier explains the "-1" |

---

## 9. Recommended changes (nothing applied)

1. 🔴 **BC 60 refrigerant: R600a, 24 g** - not SAP's R134a/50 g. Safety-relevant - section 3.2.
2. 🔴 **Input power**: BC 60 **70 W**, BC 85-1 **165 W**. SAP's 100 W belongs to neither - §3.1.
3. 🟠 **BC 60 weights**: gross 32 / net 29 kg, not SAP's 36/33 (which are the BC 85-1's) - §3.1.
   **BC 85-1 gross**: 38 kg, not 36.
4. 🟠 **BC 60 energy**: 0.56 kWh/24h and 204 kWh/year, not SAP's 0.83.
5. 🟡 Add the fields neither source currently stores: EPREL numbers (442284 / 442292), EEI
   (22% / 31%), display area, max ambient +30 °C 55% RH, packed dimensions, max shelf load
   196 kg/m², and shelf dimensions/colour.
6. 🟡 **BC 85-1 annual energy**: 387 kWh/year (tefcold.com) vs 306 kWh/a (EPREL). Needs a
   decision, not a blind edit - section 5.2.
7. ⚪ **No dimension change on either SKU** - both already match the manufacturer exactly - §4.
8. ⚪ **No `model_number` change.** EPREL's `BC85I W F` confirms `BC 85-1` is a faithful
   transcription - section 5.1.
9. ⚪ No `brands.json` change.
