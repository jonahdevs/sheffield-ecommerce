# Tefcold + Waring Product Research

Research notes behind a TEFCOLD + WARING audit pass on `products.json` (July 2026).
Covers 2 TEFCOLD SKUs (BC 60 and BC 85-1 bottle coolers, both Cold Displays) and 2 WARING
SKUs (WDM120K milkshake mixer, Juice Processors; WCT805K 4-slot toaster, Fast Food).

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema and Roller Grill passes before a scope decision.

---

# PART 1 — TEFCOLD

## 1. Brand identification — confirmed, live, correct

**Tefcold** = **Tefcold A/S**, Industrivej 25, DK-8800 Viborg, Denmark — a genuine Danish
commercial refrigeration manufacturer ("Experts in Commercial Refrigeration for Over 30
Years", matching `brands.json`'s existing description).

`brands.json` already has `slug: tefcold`, `website_url: https://www.tefcold.com/`.
**Verified live**: HTTP 200, loads Tefcold's own homepage (Display Coolers / Storage
Coolers / Freezers / Ice Cream Freezers / Cold Rooms / Gastro / Spare Parts categories).
**No `brands.json` change needed.**

Tefcold runs a headless commerce site (`headlessapi.tefcold.com` serves all product images,
resized on the fly via URL params). No PDF datasheets are published — every spec lives
directly on the product page as structured HTML, which is what this pass sourced from.

Site sitemap used to locate the two products:
https://www.tefcold.com/sitemap/products

## 2. BC 60 (IMG/DIS/00042) — record is essentially empty; built out from the live official page

Stored record has **only** a `short_description`. `description` is `null`, and there are no
`length`/`width`/`height`/`technical_specification` fields at all — this SKU needs building
from scratch, same situation as several empty Brema records.

Official product page (item no. 16071, matches our bare "BC 60" model code exactly):
https://www.tefcold.com/bc60-16071

Confirmed specification:

- **Model name:** BC60, **Item no.** 16071, **EAN/GTIN** 5708181501235
- **External (W×D×H):** 432 × 496 × 668 mm
- **Internal (W×D×H):** 356 × 311 × 557 mm
- **Packed (W×D×H):** 480 × 550 × 700 mm
- **Weight:** 32 kg gross / 29 kg net
- **Capacity:** 40× 330 ml bottles, 70× 330 ml cans, or 55× 500 ml cans; 67 L gross / 58 L
  net volume
- **Cooling:** fan-assisted; **temperature range** +2 to +10 °C; **climate class 4**
- **Refrigerant:** R600a, 24 g charge; automatic defrost
- **Shelving:** 3 black wire shelves, 340 × 270/205 mm, max load 196 kg/m²
- **Door:** 1 hinged, self-closing glass door, with lock; LED interior light
- **Electrical: 220-240 V / 50 Hz, 70 W input** — **confirmed correct for Kenya (240 V/50 Hz)**
- **Energy:** class C, 0.56 kWh/24h, 204 kWh/year, EEI 22%
- **Noise:** 44 dB(A)

A photo of the shipping carton (downloaded, see §5) independently corroborates the model
and voltage: printed label reads "TEFCOLD — MODEL: BC60 — BOTTLE COOLER — 220-240V/50Hz —
SCHUKO — COLOR: BLACK — STACKING: 3", with its own EAN barcode.
⚠ **Minor discrepancy**: the carton's printed EAN reads `5708181500245`, one digit-group off
from the product page's stated `5708181501235`. Likely a packaging-run/regional-SKU variant
of the same physical unit — not a different product (model, voltage, colour and dimensions
all agree) — but flagged rather than silently reconciled.

**Axis note:** since no numeric dimension fields exist yet, there is nothing to "swap" —
just populate using the catalogue's established convention (`length` = width, `width` =
depth, `height` = height): **length 432, width 496, height 668.**

## 3. BC 85-1 (IMG/DIS/00060) — confirmed correct on nearly every field already, but width/height are swapped

Stored record already carries a fairly complete `technical_specification`. The current
official product is listed under a slightly different name — **"BC85 w/Fan"** (item no.
34024) — explicitly noted on the page as **"substitution for 15884 BC85"** (i.e. Tefcold's
older plain-BC85 SKU was superseded by this fan-assisted version, same way Brema's "2.0 Wi"
generation superseded older codes). Our model_number "BC 85-1" doesn't literally match either
"BC85" or "BC85 w/Fan" — but the match is confirmed **beyond doubt by the EAN**, which is
identical to what's already stored:

Official product page:
https://www.tefcold.com/bc85-w-fan-34024

- **EAN/GTIN 5708181994624** — matches our stored `technical_specification` exactly.
- A photo of the unit's internal rating plate (downloaded, see §5) reads **"MODEL: BC85[I]
  w/Fan"** (the digit after "BC85" is stylised and reads as either "I" or "1" depending on
  font rendering — most likely this **is** "BC85-1" run together without the dash, which
  would directly explain our stored "BC 85-1" model_number). **Medium-High confidence** on
  that reading specifically, **High confidence** on the product match overall (EAN is exact).

Field-by-field comparison:

| Field | Stored | Official | Verdict |
|---|---|---|---|
| External dims | `length:503, width:775, height:567`; prose "503 x 567 x 775mm" | 503 × 567 × 775 mm (W×D×H) | **Numeric width/height swapped** — see §3.1 |
| Internal dims | 410 x 415 x 630mm | 410 × 415 × 630 mm | Exact match |
| Voltage/Freq | 220-240/50 V/Hz | 220-240V / 50Hz | Exact match — **confirmed correct for Kenya** |
| Input power | 165W | 165 W | Exact match |
| Energy class | C | C | Exact match |
| Daily consumption | 1.06 kWh/24h | 1.06 kWh/24h | Exact match |
| Annual consumption | 387 kWh/year | 387 kWh/year | Exact match |
| Noise | 45 dB(A) | 45 dB(A) | Exact match |
| Temp range | +2 to +10°C | +2 to +10°C | Exact match |
| GTIN/EAN | 5708181994624 | 5708181994624 | Exact match |
| Weight | *not stored* | 38 kg gross / 33 kg net | **Missing — add** |
| Capacity | *not stored* | 43 bottles (330/500ml PET); 93× 330ml cans or 68× 500ml cans; 92L/85L gross/net volume | **Missing — add** |
| Refrigerant | *not stored* (only "fan assisted cooling" in bullets) | R600a, 28g charge | **Missing — add** |
| Shelves | "Adjustable shelves" (generic) | 3 wire shelves, white, 406 × 355 mm | Could be more specific |
| Climate class / EEI / EPREL | *not stored* | Class 4 / EEI 31% / EPREL No. 442292 | **Missing — add** |
| 40ft container load 228 pcs | stored, unconfirmed | not shown on official page | Leave as-is, unverified (not contradicted either) |

This is the most accurate pre-existing record found across every brand pass so far — nearly
every field that *is* populated matches the manufacturer's own current listing exactly,
strongly suggesting whoever entered this record copied directly from tefcold.com originally.

### 3.1 The swap, spelled out

Stored numeric fields: `length: 503, width: 775, height: 567`.
The stored **prose** `technical_specification` independently says *"External Dimension 503 x
567 x 775mm"* — three numbers in a different order than the numeric fields carry, and that
prose order matches the official **W × D × H = 503 × 567 × 775 mm** exactly. So, same pattern
as every brand audited so far: **the prose is right, the numeric `width`/`height` fields are
transposed.** Corrected numeric values: **length 503, width 567, height 775.**

## 4. Cross-cutting TEFCOLD notes

- **Both SKUs' electrical specs are already 220-240V/50Hz** — genuinely no US/wrong-market
  risk found on this brand; Tefcold is a European (Danish) manufacturer that doesn't sell a
  110/120V line at all, unlike Waring below.
- **Colour check performed against current storage images**: BC 60's stored product photo
  (`bottle-cooler-table-top-tefcold-bc-60-imgdis00042.jpg`) is the **black** cabinet, matching
  Tefcold's own BC60 renders (black is the only colour Tefcold shows for this model). BC 85-1's
  stored photo (`...bc-85-1-imgdis00060.png`) is **white**, matching the official BC85 w/Fan
  renders exactly (white is the only colour shown). No colour-variant mismatch on either SKU.
- **Axis-swap scorecard for this pass**: BC 60 had no dims to swap (empty); BC 85-1 had the
  swap. Consistent with every prior brand pass's finding that this has to be checked per-SKU.

---

# PART 2 — WARING

## 5. Brand identification — waring.com is real and live, but it's the US-only commercial site; no separate Waring EMEA/export storefront exists

**Waring** = **Waring Commercial**, a Conair Corporation brand (footer link to
`conairhospitality.com` confirms the corporate parent), New Hartford CT, USA.

`brands.json` has `slug: waring`, `website_url: https://www.waring.com/`.
**Verified live**: HTTP 200, loads Waring's real commercial catalogue. However, this is
explicitly a **US-market storefront** — the homepage carries a promotion marked "(available
to US customers only)", and every toaster/mixer model shown in its own navigation uses the
**bare (no-suffix)** US part numbers (e.g. "WCT708", "WCT850").

The task brief asked to check whether Waring maintains a separate international/export site.
**It does not, currently:**

- The site's own footer link labelled "Waring International" points to
  `https://waring.com/waringemea.html` — **this URL 404s on Waring's own site.** Dead link.
- `waringproducts.co.uk` (a plausible-looking UK domain) resolves but is a **blank parked
  page** (a single placeholder image, no real content) — not an active Waring property.
- No `waringcommercial.co.uk`, `waringcommercial.eu`, or similar alternate domain could be
  found live.

**Conclusion: `https://www.waring.com/` is the correct and only live Waring corporate site to
link — no change needed to `brands.json`.** Waring's export/"K"-suffix products exist and are
real, current, in-catalogue products, but they're sold **through third-party international
distributors and resellers** (Nisbets, KitchenRestock, Global Restaurant Equip, etc.), not
through a Waring-branded regional storefront. Worth knowing if `brands.json`'s description is
ever expanded, but not a broken-link fix.

## 6. The "K" suffix — CONFIRMED: it is the export/international 220-240V variant, with direct manufacturer-manual evidence

This is genuinely good news exactly as the brief hoped, and it's now confirmed explicitly
rather than inferred:

- **Direct manual evidence (WCT805 series):** Waring's own manual — covering models WCT805,
  WCT815, WCT805E, WCT815E, WCT805K, WCT815K together — contains a section titled
  **"Important UK Wiring Instructions"** that states: *"If a BS1363 Fused Plug is used, this
  must be fitted with the correct amperage fuse – 13A. **This applies to UK models only.**"*
  The same section's spec table gives the K-suffix models' voltage as **220-240V**. Source
  (paginated manual viewer, UK wiring section on page 4):
  https://www.manualslib.com/manual/2904164/Waring-Wct805-Series.html?page=4
  Manual index page (also shows a dedicated WCT805K product manual entry):
  https://www.manualslib.com/products/Waring-Wct805k-13010956.html
- **Reseller corroboration (WCT805K):** explicitly sold as **"220-240v/50/60"**, **"type G
  plug"** (UK 3-pin), with the note **"FOR INTERNATIONAL USE ONLY"**, CE/RoHS certified:
  https://www.globalrestaurantequip.com/product/waring-wct805k-commercial-toaster-heavy-duty-4-1-1-8-slots-4-slice-capacity/
  https://kitchenrestock.com/products/waring-wct805k-commercial-toaster-heavy-duty-4-1-1-8-slots
- **Bare-model contrast:** the no-suffix **WCT805** (same physical toaster, sold in the US) is
  **240V/50-60Hz, NEMA 6-15P plug** — a US-pattern high-voltage commercial plug, not a
  household plug, but still US-specific hardware, not exportable as-is:
  https://www.katom.com/141-WCT805.html
- **Same pattern on the mixer.** The bare US **WDM120** (now discontinued, replaced in the US
  range by the electronic **WDM120TX**) is **120V/60Hz, 140W, 1.5A**:
  https://www.katom.com/141-WDM120.html
  A **separate manual exists specifically for "Wdm120k"** (in English/Spanish/French), a
  distinct document from the bare WDM120 manual — itself evidence that WDM120K is treated as
  its own export SKU rather than a simple relabel:
  https://www.manualslib.com/manual/2756316/Waring-Wdm120k.html
- The Nisbets (UK) catalogue's Waring range is **wall-to-wall "K"-suffixed model numbers**
  (WW200K waffle maker, WSB35K stick blender, WKS800K knife sharpener, TBB145K blender,
  WDM120TXK mixer) — i.e. "K" is Waring's **standard UK/export suffix across their entire
  commercial range**, not something specific to these two SKUs:
  https://www.nisbets.co.uk/waring-heavy-duty-single-spindle-drinks-mixer-wdm120txk/fs040

**Verdict: "K" = Waring's UK/European-export electrical variant (220-240V, 50/60Hz, UK-style
plug/fusing), as distinct from the US no-suffix model. High confidence, multiple independent
sources including the manufacturer's own manual.**

## 7. WDM120K — Milk Shake Mixer Single Waring (IMG/ICE/00021)

No official Waring product page could be reached directly for the K-suffix SKU specifically
(waring.com's own site search and quick-view endpoints returned redirects/blocked responses
to automated fetches), but the **bare WDM120's full spec + the K-specific manual's existence**
together give strong indirect confirmation, and — importantly — **our stored record's own
numbers already look correctly sourced from the K/export spec, not the US spec**:

| Field | Stored | Bare US WDM120 (Katom) | Verdict |
|---|---|---|---|
| Voltage | "220-240 V/ 50 HZ" | 120V/60Hz/1ph | **Stored already uses the correct export figure, not the US one** — good news, nothing to fix |
| Power | "1 HP" | 1 HP, 140W, 1.5A | Matches |
| RPM | "16000 - 25000 RPM" | 16,000 / 22,000 / 25,000 RPM (3 speeds) | Matches (missing the middle 22,000 step, minor) |
| Capacity | "0.95 L" | *(bare model page doesn't state cup capacity)* | Unverified independently, plausible for a single-spindle stainless cup, Medium confidence |
| Dimensions (numeric) | `length:171, width:525, height:281` | ~7"W × 11.5"D × 21.5"H = 178 × 292 × 546 mm | **Numeric width/height swapped** — see below |
| Dimensions (prose) | "LENGTH: 171 MM / WIDTH: 281 MM / HEIGHT: 525 MM" | (W,D,H) = (178, 292, 546) | Prose lines up with official (171≈178, 281≈292, 525≈546) |

**Axis swap, same pattern as every other brand audited:** stored `width` (525) is really the
height; stored `height` (281) is really the depth. Prose is correct. Corrected: **length 171,
width 281, height 525.**

Sources:
https://www.katom.com/141-WDM120.html (bare US model, discontinued, replaced by WDM120TX)
https://www.katom.com/141-WDM120TX.html (current US electronic successor, for context only — different control panel, not our SKU)
https://www.manualslib.com/manual/2756316/Waring-Wdm120k.html (WDM120K-specific manual, confirms the SKU exists as its own document but page excerpt didn't yield a full spec table)

**Electrical spec confidence: High** — 220-240V/50Hz is explicitly already what's stored, and
is corroborated by the entire "K = export" pattern found across Waring's range (§6). This is
**directly suitable for Kenya's 240V/50Hz supply**, no change needed on voltage.
**Dimension confidence: Medium** — the bare-model physical shell is almost certainly identical
between WDM120 and WDM120K (Waring's own practice, evidenced by WCT805/WCT805K sharing the
identical 18.7 lb weight in §8), but no K-specific dimension source could be independently
found to triple-confirm against.

## 8. WCT805K — Toaster 4 Slots Waring (IMG/HOT/00108)

| Field | Stored | Official/reseller WCT805K | Bare US WCT805 (Katom) | Verdict |
|---|---|---|---|---|
| Voltage | "230V" (bullet); "230V/50HZ" (spec list) | **220-240V/50/60Hz**, Type G (UK) plug, "FOR INTERNATIONAL USE ONLY" | 240V/50-60Hz, NEMA 6-15P (US plug) | Stored is **already correct** for the export/K variant — good news |
| Power | "2.015-2.4kW, 9A" | Manual spec table (K row): **Amps 10, Watts 2015-2400**, Freq 50/60 | 2700W, 11.25A (bare) | Stored **matches the K-variant manual figures almost exactly** (9A vs ~10A is a rounding-level gap) — high confidence this is already sourced correctly |
| Slots | 4× 28mm slots, up to 380 slices/hr | (4) 1-1/8" slots, up to 380 slices/hr | (4) 1-1/8" slots, up to 380 slices/hr | Matches |
| Weight | "9.9kg" | 18.7 lbs = **8.48 kg** | 18.70 lbs = 8.48 kg | Close (9.9 vs 8.48kg, ~1.4kg gap — Low-Medium confidence, flag but don't blindly overwrite) |
| Dimensions (numeric) | `length:438, width:420, height:406` | 11.5"H × 14.63"W × 15.63"D = 292×372×397mm (reseller-stated for WCT805K) | 11-7/8"×10-1/2"×9" = 302×267×229mm (W×D×H, bare) | **None of the three sets agree with each other** — see below |
| Dimensions (prose) | "LENGTH 483MM / WIDTH 406MM / HEIGHT 420MM" | — | — | Also doesn't match either external source |

### 8.1 Dimensions are a genuine unresolved discrepancy — flag, don't blind-fix

Unlike every other SKU in this pass (and most of the Brema/Roller Grill passes), the
dimension figures here **do not converge**. Three independent figures, all different:

1. **Stored (numeric):** 438 × 420 × 406 mm — and the **stored prose disagrees with the
   stored numeric fields too** (483/406/420), which is itself the familiar swap signature,
   but neither version matches any external source.
2. **Katom's bare-model WCT805** (US, NEMA plug): 302 × 267 × 229 mm — a plausible size for a
   compact countertop 4-slot toaster, and consistent with the "Four 1-1/8" slots" product
   photography (see §9).
3. **GlobalRestaurantEquip/KitchenRestock's WCT805K listing:** 292 × 372 × 397 mm — explicitly
   labelled for the K model, but the H/W/D figures look implausible for this style of toaster
   (a 397mm depth is unusually deep for a unit this compact) and may itself be a reseller
   data-entry error, the same kind of drift seen on multiple resellers in the Roller Grill and
   Brema passes.

**Recommendation:** do not overwrite the stored dimensions from either external source without
a physical measurement or the manufacturer's own dimensioned drawing (which could not be
located for this SKU — Waring doesn't publish a technical/dimension-drawing PDF the way Roller
Grill does). **Confidence: Low on all three candidate sets.** This is the one open question in
an otherwise well-confirmed pass — worth a tape-measure check against the actual unit in stock
before touching this field.

Sources:
https://www.katom.com/141-WCT805.html
https://www.globalrestaurantequip.com/product/waring-wct805k-commercial-toaster-heavy-duty-4-1-1-8-slots-4-slice-capacity/
https://kitchenrestock.com/products/waring-wct805k-commercial-toaster-heavy-duty-4-1-1-8-slots
https://www.manualslib.com/manual/2904164/Waring-Wct805-Series.html?page=4

## 9. Cross-cutting WARING notes

- **Electrical is the headline finding for both SKUs, and it's a clean bill of health**: both
  WDM120K and WCT805K already carry 220-240V/50Hz in the stored record, which is the correct
  export spec, not a US 120V figure slipping in. Given the brief's warning that this is the
  most common failure mode on Western brands, it's worth stating plainly: **no fix needed on
  electrical spec for either Waring SKU** — someone sourced this correctly the first time.
- **Axis-swap scorecard**: WDM120K has the classic width/height numeric-vs-prose swap
  (consistent with every brand passed so far). WCT805K's numeric/prose don't even agree with
  each other, let alone an external source — a different, worse failure mode than a clean
  swap.
- **No PDF datasheets exist for either Waring SKU** in the way Roller Grill or Brema publish
  them — Waring's own site doesn't expose a downloadable spec sheet, and the only PDF-adjacent
  source found was the multi-model instruction **manual** (via manualslib, itself served as a
  page-image viewer rather than a direct PDF link, so it was read via page-by-page text
  extraction rather than the `Read` tool on a downloaded file).
- **Search engines were heavily bot-gated during this pass** (Google, Bing, DuckDuckGo's main
  and lite endpoints, Startpage all blocked or CAPTCHA'd automated `curl`/fetch traffic).
  `html.duckduckgo.com/html/` was the one endpoint that worked reliably with a browser-like
  User-Agent header and was used for the majority of source discovery in Part 2.

---

## 10. Product reference

| SKU | Catalogue name | model_number | Official/best source | Confidence |
|---|---|---|---|---|
| IMG/DIS/00042 | Bottle Cooler Table Top Tefcold BC 60 | BC 60 | https://www.tefcold.com/bc60-16071 | **High** — official page, exact code match, EAN present |
| IMG/DIS/00060 | Bottle Cooler Table Top Tefcold BC 85-1 | BC 85-1 | https://www.tefcold.com/bc85-w-fan-34024 | **High** — EAN identical to stored record |
| IMG/ICE/00021 | Milk Shake Mixer Single Waring | WDM120K | https://www.katom.com/141-WDM120.html (bare-model proxy) + https://www.manualslib.com/manual/2756316/Waring-Wdm120k.html (K-specific manual exists) | **Medium-High** on electrical/dims (indirect, via bare-model + manual-existence evidence), no direct K-variant spec page found |
| IMG/HOT/00108 | Toaster 4 Slots Waring | WCT805K | https://www.globalrestaurantequip.com/product/waring-wct805k-commercial-toaster-heavy-duty-4-1-1-8-slots-4-slice-capacity/ + https://www.manualslib.com/manual/2904164/Waring-Wct805-Series.html?page=4 | **High** on electrical (manual + reseller agree, matches stored figures), **Low** on dimensions (three disagreeing sources) |

Supporting / cross-check sources used across both brands:

https://www.tefcold.com/
https://www.tefcold.com/sitemap/products
https://www.waring.com/
https://www.waring.com/waringemea.html (dead link, §5)
https://www.nisbets.co.uk/waring-heavy-duty-single-spindle-drinks-mixer-wdm120txk/fs040
https://www.katom.com/141-WCT805.html
https://www.katom.com/141-WDM120.html
https://www.katom.com/141-WDM120TX.html
https://www.manualslib.com/products/Waring-Wct805k-13010956.html
https://www.manualslib.com/manual/2904164/Waring-Wct805-Series.html
https://www.manualslib.com/manual/2756316/Waring-Wdm120k.html
https://www.globalrestaurantequip.com/product/waring-wct805k-commercial-toaster-heavy-duty-4-1-1-8-slots-4-slice-capacity/
https://kitchenrestock.com/products/waring-wct805k-commercial-toaster-heavy-duty-4-1-1-8-slots

---

## 11. Image sourcing (July 2026) — downloaded to `Downloads/tefcold-waring-images/`

**20 files total, all opened and visually verified.** No thumbnails kept — everything is
≥800px on the long edge, most are 1000-3200px.

### Tefcold — pulled directly from `headlessapi.tefcold.com` (Tefcold's own CDN), requested at 1600×1600 via URL param substitution

| SKU | File | Pixels | Notes |
|---|---|---|---|
| IMG/DIS/00042 | `IMG-DIS-00042__BC60-front-angle-stocked.jpg` | 695×1600 | Black cabinet, stocked with Budweiser/Stella bottles — official Tefcold render |
| IMG/DIS/00042 | `IMG-DIS-00042__BC60-front-angle-empty.jpg` | 693×1600 | Same unit, empty, clean angle — **best primary candidate** |
| IMG/DIS/00042 | `IMG-DIS-00042__BC60-interior-cans-detail.jpg` | 1600×1600 | Close-up, "TEFCOLD" branding visible on interior header strip |
| IMG/DIS/00042 | `IMG-DIS-00042__BC60-hinge-foot-detail.jpg` | 1600×1600 | Bottom hinge/foot detail shot — secondary/supporting only |
| IMG/DIS/00042 | `IMG-DIS-00042__BC60-packaging-box.jpg` | 1600×1600 | Shipping carton, label confirms MODEL:BC60, 220-240V/50Hz (see §2) |
| IMG/DIS/00060 | `IMG-DIS-00060__BC85-front-angle-stocked.jpg` | 1181×1600 | White cabinet, stocked with water/produce — official render |
| IMG/DIS/00060 | `IMG-DIS-00060__BC85-front-angle-door-open.jpg` | 1181×1600 | Door open, empty, shows shelving — **matches current stored image exactly, higher-res replacement** |
| IMG/DIS/00060 | `IMG-DIS-00060__BC85-front-angle-empty.jpg` | 1600×1600 | Door closed, empty, clean angle — **best primary candidate** |
| IMG/DIS/00060 | `IMG-DIS-00060__BC85-fan-detail.jpg` | 1600×1600 | Interior fan/LED strip close-up |
| IMG/DIS/00060 | `IMG-DIS-00060__BC85-rating-plate-detail.jpg` | 1600×1600 | Rating plate photo — confirms MODEL/voltage/EAN (see §3) |

Source pages: https://www.tefcold.com/bc60-16071 and https://www.tefcold.com/bc85-w-fan-34024

**Colour check**: confirmed against the currently-stored storage images
(`storage/app/public/products/bottle-cooler-table-top-tefcold-bc-60-imgdis00042.jpg` = black;
`...bc-85-1-imgdis00060.png` = white) — both match the newly-downloaded official renders
exactly, so these are straight resolution upgrades, not colour-variant risks.

### Waring — sourced from Katom (US reseller, official Waring studio renders, requested at their largest Cloudinary size) + one KitchenRestock listing explicitly labelled for the K SKU

| SKU | File | Pixels | Source | Notes |
|---|---|---|---|---|
| IMG/ICE/00021 | `IMG-ICE-00021__WDM120K-front-angle.jpg` | 3200×3200 | katom.com/141-WDM120 | Bare-shell studio render (same physical cabinet as K variant) — **primary candidate** |
| IMG/ICE/00021 | `IMG-ICE-00021__WDM120K-front-straight.jpg` | 3200×3200 | katom.com/141-WDM120 | Straight-on angle |
| IMG/ICE/00021 | `IMG-ICE-00021__WDM120K-speed-switch-detail.jpg` | 3200×3200 | katom.com/141-WDM120 | LO/MED/HI + pulse switch close-up, no electrical fittings visible |
| IMG/ICE/00021 | `IMG-ICE-00021__WDM120K-spindle-detail.jpg` | 3200×3200 | katom.com/141-WDM120 | Spindle/agitator close-up |
| IMG/ICE/00021 | `IMG-ICE-00021__WDM120K-lifestyle-with-shake.jpg` | 3200×3200 | katom.com/141-WDM120 | Studio shot with a styled milkshake for scale/context |
| IMG/ICE/00021 | `IMG-ICE-00021__REF__WDM120K-rear-US-plug-do-not-use.jpg` | 3200×3200 | katom.com/141-WDM120 | ⚠ **`REF__` — do not use.** Rear view visibly shows the **US 2-pin NEMA power cord/plug**, which is wrong for the K/export electrical variant this SKU actually is (§6). Kept only as a reference of the rear panel layout |
| IMG/HOT/00108 | `IMG-HOT-00108__WCT805K-hero-with-toast.jpg` | 3200×3200 | katom.com/141-WCT805 | Toasted bread in all 4 slots — **primary candidate** |
| IMG/HOT/00108 | `IMG-HOT-00108__WCT805K-lifestyle-breakfast1.jpg` | 3200×3200 | katom.com/141-WCT805 | Styled breakfast scene (crumpets, fruit, salmon bagel) |
| IMG/HOT/00108 | `IMG-HOT-00108__WCT805K-lifestyle-breakfast2.jpg` | 3200×3200 | katom.com/141-WCT805 | Second styled breakfast scene (juice, toast rack) |
| IMG/HOT/00108 | `IMG-HOT-00108__WCT805K-slots-detail.jpg` | 3200×3200 | katom.com/141-WCT805 | Top-down close-up, captioned "Four 1-1/8" Regular Toast Slots" |
| IMG/HOT/00108 | `IMG-HOT-00108__WCT805K-kitchenrestock-labeled.jpg` | 1000×1000 | kitchenrestock.com, MPN explicitly listed as WCT805K | Same render as the Katom set, confirms it's genuinely sold under the K part number |

Notes for whoever adopts these:

- **Katom's studio renders are Waring's own official photography** (same "Heavy Duty
  Toaster"/mixer product shots reused across the whole trade, including kitchenrestock and
  globalrestaurantequip's WCT805K-labelled listing) — not reseller-specific photos, so there
  is no cabinet/design mismatch risk between the bare and K-suffix electrical variants; only
  the **power cord and internal motor/element winding differ**, which is why the one rear-view
  shot showing the US plug was excluded rather than kept as a candidate.
  - `IMG-ICE-00021__WDM120K-front-angle.jpg` and `-front-straight.jpg` are both good hero
  candidates for the mixer; neither shows the power cord.
- The current stored images
  (`storage/app/public/products/milk-shake-mixer-single-waring-imgice00021.jpg` and
  `.../toaster-4-slots-waring-imghot00108.jpg`) were not re-examined pixel-for-pixel, but the
  newly-downloaded files are Waring's own studio renders at far higher resolution, so this is
  a straightforward quality upgrade regardless.
- **Not copied into `storage/app/public/products/` or referenced in `products.json`** — staged
  in `Downloads/tefcold-waring-images/` for manual review, same workflow as every prior brand
  pass.

---

## 12. Recommended changes — nothing applied, priority order per brand

### TEFCOLD — BC 60 (IMG/DIS/00042)

1. 🔴 **Build out the entire record** — currently only has a `short_description`. Add
   `description`, dimensions (`length:432, width:496, height:668`), and a full
   `technical_specification` table using the confirmed figures in §2 — §2
2. 🟡 Add `meta_description` and restructure to the prose + `<h3>Key Features</h3>` +
   `<table>` pattern used elsewhere in the catalogue — §2

### TEFCOLD — BC 85-1 (IMG/DIS/00060)

1. 🔴 Fix the **width/height transposition**: `length:503, width:775, height:567` →
   **`length:503, width:567, height:775`** — §3.1
2. 🟠 Add the fields confirmed-but-missing: **weight 38kg/33kg gross/net**, **capacity 43
   bottles / 93×330ml or 68×500ml cans, 92L/85L**, **refrigerant R600a 28g**, **climate class
   4**, **EEI 31%**, **EPREL No. 442292** — §3
3. 🟡 Optionally specify shelf material/size (white wire, 406×355mm) instead of the generic
   "Adjustable shelves" bullet — §3
4. ⚪ No change to `model_number` — "BC 85-1" is plausibly Tefcold's own rating-plate string
   read literally, and the EAN match makes the product identity certain regardless — §3

### WARING — WDM120K (IMG/ICE/00021)

1. 🔴 Fix the **width/height transposition**: `length:171, width:525, height:281` →
   **`length:171, width:281, height:525`** — §7
2. ⚪ **No electrical change needed** — "220-240 V/50 HZ" is already stored and is the
   confirmed-correct export figure, not a US spec slip — §6, §7
3. 🟡 Optionally add the middle RPM step (22,000) to the "16000-25000 RPM" range for
   completeness — §7

### WARING — WCT805K (IMG/HOT/00108)

1. ⚪ **No electrical change needed** — "230V"/"2.015-2.4kW, 9A" already closely matches the
   K-variant's own manual spec table (10A/2015-2400W) — §6, §8
2. 🟡 **Needs a decision, not a blind edit**: dimensions disagree across all three sources
   found (stored numeric 438×420×406, stored prose 483×406×420, bare-model 302×267×229,
   reseller K-listing 292×372×397). Recommend a physical tape-measure check against actual
   stock rather than picking one of these — §8.1
3. 🟡 Minor weight gap (9.9kg stored vs 8.48kg from two independent US sources) — worth a
   quick check, Low priority — §8

### `brands.json`

No change to either `tefcold` or `waring` `website_url` — both are correct and live. Note for
awareness only: Waring has no working international/EMEA site of its own (`waringemea.html`
404s, `waringproducts.co.uk` is a parked page) — the K-suffix export range is sold entirely
through third-party distributors, not a Waring-branded regional storefront — §5.
