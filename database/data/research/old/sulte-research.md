# Sulte Product Research

Research notes behind a SULTE enrichment/audit pass on `products.json` (July 2026).
Covers all 12 SULTE SKUs: 9 induction cookers/fryers/griddles (IMG/BUF/00226-00234,
00282) and 2 microwave ovens (IMG/HOT/00402-00403).

**No `products.json` or `brands.json` changes have been applied** — this file is
findings only, same starting point as the Brema and Iberna passes before a scope
decision.

Headline results:

- **The 9 induction SKUs are a real, single manufacturer: Foshan Shunde Sulte
  Electronics Co., Ltd.**, Shunde District, Guangdong, China. "Sulte" is not a
  placeholder or a house name invented for our catalogue — it is the company's own
  name, confirmed by an official South African appliance-safety registration filing
  that names the model, the electrical rating, **and** the manufacturer in one
  document (§1). This is a genuine finding *against* the catch-all hypothesis for
  this half of the brand.
- **The 2 microwave SKUs are not Sulte-made at all.** They trace to a Midea-designed
  commercial microwave OEM platform sold worldwide under at least four other badges
  (Fimar, Easyline, Solwave, and — critically — **our own catalogue's own former
  "EASYLINE" listing**, §2). Sulte's own storefront and website advertise only
  induction cookers, griddles and fryers; microwaves appear nowhere in their range.
  **This is the catch-all bug the brief predicted, but it is scoped to exactly 2 of
  the 12 SKUs, not the whole brand.**
- **A new dimension-mislabelling bug, distinct from the width/height axis-swap found
  in every prior brand pass, was found on both microwaves**: the field our records
  call `"Internal Dimensions"` is actually the unit's real external footprint, and
  the field called `"External Dimensions"` is an inflated figure closer to a packing
  crate than the appliance itself (§2, confirmed against an official Fimar spec
  sheet). One of the two SKUs also has its numeric `length`/`width`/`height` fields
  tracking the wrong (inflated) figure while its sibling tracks the right one —
  the same "per-SKU, not brand-wide" inconsistency documented in the Brema pass.
- **Sibling-contamination risk on the SL-C351 two-/four-zone family is real but
  unresolved**, not cleanly proven either way (§3.2-§3.3): the "Side by Side"
  two-zone unit's stored footprint is narrower and deeper than the plain "Table Top"
  two-zone unit's — backwards from what the names imply — and a third-party
  Azerbaijani listing attributes our four-zone model's exact code a footprint that
  matches our own *two-zone* record instead. Neither conflict could be resolved
  against a manufacturer photo or spec sheet; both are flagged for supplier
  verification rather than corrected.
- **A power-copy-paste at the product-name level**: GRT24B and GRT36B (24" and 36"
  induction griddles) are both named "Induction Griddle 6KW" in our catalogue, but a
  36" griddle drawing the same power as a 24" one is physically implausible (§3.4).
- ~~No manufacturer-sourced image could be found for 5 of the 9 induction SKUs~~
  **SUPERSEDED (July 2026 image pass, §6).** `sulteer.com`'s JS-rendered pages were
  cracked by fetching the CDN JavaScript bundle that carries the real markup (§6.1),
  which exposed Sulte's entire product catalogue with studio renders at **9450×9450 px**.
  Both griddles now have exact-model manufacturer photography, and the two-zone /
  four-zone / fryer SKUs have platform-level sibling photography. The image pass also
  **found a wrong-model photo staged for 00226** (§6.2), **corroborated the §3.4 GRT36B
  power flag from the hardware** (§6.3), and **partially resolved the §3.2/§3.3 two-zone
  layout question** (§6.4).

---

## 1. Brand identification

**Sulte = Foshan Shunde Sulte Electronics Co., Ltd.** (佛山市顺德区速尔特电器有限公司,
approximate), based in Shunde District, Foshan, Guangdong — the same district that is
home to Midea's headquarters and one of China's largest concentrations of small-appliance
manufacturers. Company records (cnverify.com) give a founding date of **20 May 2014** and
name the founder as **Su Zhonghong**.

- Alibaba supplier storefront: https://sulte.en.alibaba.com/
- Mobile storefront: https://sulte.m.en.alibaba.com/
- Company's own website (small factory CMS, hosted on hkwezhan.cn): https://www.sulteer.com/
- Profile pages found on: https://www.ampliz.com/company/foshan-shunde-sulte-electronics-co-ltd/100042871 , https://www.exporthub.com/foshan-shunde-sulte-electronics-co-ltd/ , https://www.cnverify.com/company/Foshan-Shunde-Sulte-Electronics-Co-Ltd , https://www.diytrade.com/china/manufacturer/2387836/main/Foshan_Shunde_Sulte_Electronics_Co_Ltd.html , https://www.signalhire.com/companies/foshan-shunde-sulte-electronics-co-ltd

**The strongest single piece of evidence** is an official South African appliance
safety/registration filing that names the model, the electrical rating and the
manufacturer together in one government-facing document:

> "Induction cooker Model: SL-C351-KPP2 220-240V~, 50/60Hz, 3500Wx2 Foshan Shunde Sulte
> Electronics Co., Ltd."

https://www.applianceregistrationdatabase.org.za/sites/default/files/safety_fu_9_other_1/60436730%20001%20TR_final%20%281%29.pdf

This confirms two things at once: the manufacturer identity, and that our
`SL-C351-KPP2` model code is genuine (not a locally-invented SKU string) — it is the
same code Sulte itself files with regulators.

**Sulte's own catalogue scope is narrow and matches our 9 induction SKUs, not the 2
microwaves.** Alibaba lists the storefront as "Experts in Manufacturing and Exporting
**Commercial Induction Cooker, Induction Griddle** and 774 more Products"
(https://sulte.en.alibaba.com/index.html?from=detail&productId=60607868925), and the
company's own website's product categories are: Induction Fryer, Flat Induction
Cooktop, Wok Induction Cooktop, Built-In Induction Hob, Multi Burner, Induction
Griddle, Spare Parts (https://www.sulteer.com/ProductInfoCategory). Microwave ovens
are not a Sulte product category anywhere this research found.

Sulte's own "About Us" banner image (recovered via a third-party B2B directory,
saved as `REF__Sulte-company-profile-factory-photos-Foshan-Shunde-bestsuppliers-672x807.png`)
states the company "has its own patents, and has obtained GS, CE, CB, EMC
certifications. Factory covers more than 4000 square meter, with 2 production lines
over 40 thousand sets each year." Source:
https://cdn.bestsuppliers.com/seo_products_img/sulte/ea5338091e903f7ca79e110a985befb4.png

### `brands.json`

The current entry (`slug: sulte`, `website_url: null`) already carries a broadly
accurate generic description. Recommend filling `website_url` with
**https://sulte.en.alibaba.com/** (the more complete and more stable of the two
company-controlled pages — `sulteer.com` is a thin, JS-rendered site whose product
pages could not be read by an automated fetch at all, see §5). Note that unlike the
Iberna and Brema passes, there is **no proper corporate website** to link here — this
is a small factory-direct exporter, and that itself is worth knowing when setting
expectations for future spec-sheet lookups.

---

## 2. The microwave pair — confirmed catch-all, not Sulte-made

### 2.1 Real manufacturer: Midea, sold worldwide under at least 5 badges

The `EM025FJT` / `EMA34GTQ` platform (our SKUs carry the fuller factory codes
`EM025FJTS0SF00` and `EMA34GTQS00E00`) is a genuine **Midea** commercial-microwave
OEM design. A Midea-branded instruction manual for the closely related SKU
`EM025FJT-S0SA00` is indexed at:

- https://www.manualslib.com/manual/3557947/Midea-Em025fjt-S0sa00.html — *"View and
  Download Midea EM025FJT-S0SA00 instruction manual online. COMMERCIAL MICROWAVE OVEN."*
- https://manuals.plus/midea/em025fjt-microwave-oven-manual

The same physical unit is resold under at least four badges beyond Midea's own name:

| Badge | Market | Source |
|---|---|---|
| **Fimar** | Italy (wholesale) | https://www.gastronorm.it/en/EMO25FJT-Professional-microwave-oven-with-digital-controls , https://www.gastronorm.it/en/EMA34GTQ-Professional-microwave-oven-with-digital-controls , https://www.bianchipro.it/it/microonde-professionale/10902-forno-microonde-professionale-fimar-em025fjt-ELFOEM025FJT2.html |
| **Easyline** | Italy / EU export | https://iprocure.ai/product/easyline-microwave-oven-ema34gtq , https://tirol.bg/en/profesionalna-mikrovalnova-furna-easyline-ema34gtq-34l.html , https://gs24.lv/en/microwaves-ovens-gn2-3-ema34gtq , https://www.attrezzatureprofessionali.com/en/microonde-domandi-digitali-capacita-25.html |
| **Solwave** | United States | https://www.webstaurantstore.com/documents/specsheets/solwave_em025fjt-s0sa00.pdf , https://www.webstaurantstore.com/documents/specsheets/solwave_ema34gtq-s00l00.pdf |
| **EASYLINE** (our own catalogue, historical) | Kenya | see §2.2 |
| **SULTE** (our own catalogue, current) | Kenya | IMG/HOT/00402, IMG/HOT/00403 |

### 2.2 Our own catalogue already shows the same unit under a different brand

Sheffield Africa's live legacy site (the pre-rebuild site this new catalogue is
migrating from) has — or had — a **separate SKU for the identical physical product
under a different brand name**:

> Product Name: Easyline Microwave Oven 25 Litres · Brand: **EASYLINE** · Model:
> **EM025FJT** · Item/SKU: **IMG/HOT/00398** · Capacity 25L (GN 2/3) · Power 1.55kW ·
> 220-240V/1N/50Hz

https://sheffieldafrica.com/commercial-kitchen/product/1036/easyline-microwave-oven-25-litres-em025fjt

The corresponding 34L unit also exists on the legacy site as "Easyline Microwave Oven
34 Litres - EASYLINE EMA34GTQ" (https://sheffieldafrica.com/commercial-kitchen/product/1035/easyline-microwave-oven-34-litres-ema34gtq).

**`IMG/HOT/00398` does not exist anywhere in the current `database/data/products.json`**,
and no product in the current catalogue carries `"brand": "EASYLINE"` at all — it was
either dropped or renumbered/rebranded during the rebuild. The current SKUs
`IMG/HOT/00402` and `IMG/HOT/00403` are, on every spec checked, the same physical
20-30L-class Midea-platform microwaves, just carrying the fuller factory codes
(`EM025FJTS0SF00` vs the legacy listing's shortened `EM025FJT`) and a different brand
string (`SULTE` instead of `EASYLINE`).

This is internal, first-party evidence — not just circumstantial OEM-matching — that
these two SKUs' `"brand": "SULTE"` value is very likely a data-entry substitution for
what should be `EASYLINE` (or whatever brand string is chosen going forward), not a
reflection of Sulte actually manufacturing them.

### 2.3 The internal/external dimension mislabel (new bug pattern)

An official Fimar comparison spec-sheet image, showing both models side by side, was
recovered from gastronorm.it and saved as
`REF__Fimar-official-spec-sheet-EMA34GTQ-vs-EM025FJT-comparison-536x644.jpg`:

| Field | EMA34GTQ (official) | EM025FJT (official) |
|---|---|---|
| Power | 2.8 kW | 1.55 kW |
| Voltage | 220-240V/1N/50Hz | 220-240V/1N/50Hz |
| Capacity | 34L, GN2/3 | 25L, GN2/3 |
| **Internal cavity (W×D×H)** | **360 × 409 × 225 mm** | **327 × 346 × 200 mm** |
| **External size (W×D×H)** | **574 × 528 × 367 mm** | **510 × 440 × 310 mm** |
| Net / gross weight | 32.2 / 34.3 kg | 15 / 17 kg |
| Packing (W×D×H) | 641 × 559 × 451 mm | 580 × 470 × 380 mm |

Source: https://www.gastronorm.it/en/EMA34GTQ-Professional-microwave-oven-with-digital-controls
and https://www.gastronorm.it/en/EMO25FJT-Professional-microwave-oven-with-digital-controls

Comparing against our stored `technical_specification` prose:

**IMG/HOT/00402 (25L):**
- Our prose: *"Internal Dimensions 511X432X311mm"* / *"External Dimensions
  620X540X410mm"*
- Reality: the **real external size is 510×440×310mm** — almost an exact match to
  what our record calls "Internal Dimensions." The real internal cavity is
  327×346×200mm — nothing in our record matches this at all. Our "External
  Dimensions" figure (620×540×410) doesn't match the real external size, and is even
  somewhat larger than the official **packing carton** (580×470×380).
- The numeric `length`/`width`/`height` fields (511, 432, 311) **do** track the
  correct (real external) figure, just under the wrong prose label.
- Power: our *"1550/1000W"* matches the official 1.55kW input / 1kW output exactly.

**IMG/HOT/00403 (34L):**
- Our prose: *"Internal Dimensions 574X528X368mm"* / *"External Dimensions
  650X610X480mm"*
- Reality: the **real external size is 574×528×367mm** — an almost exact match to
  what our record calls "Internal Dimensions," same pattern as the 25L unit. The
  real internal cavity is 360×409×225mm — again nothing in our record matches it.
- Unlike the 25L SKU, **the numeric `length`/`width`/`height` fields here (650, 610,
  480) track the *wrong*, inflated "External Dimensions" figure** — the opposite of
  how the 25L sibling's numeric fields behave. This is the same "identical bug,
  handled inconsistently between siblings" shape documented across the Brema and
  Iberna passes, just with a different bug (internal/external mislabel instead of a
  width/height swap).
- Power: our *"3000/1800W"* — output (1800W) matches the official 1.8kW exactly;
  input (3000W) is 200W (7%) higher than the official 2.8kW. Minor but real.

**Recommendation:** relabel the prose so the true external size (511×432×311 / 574×528×368,
already close to correct in our data) is called "External Dimensions," add the real
internal cavity size as a new fact (327×346×200 / 360×409×225), and either correct or
drop the current "External Dimensions" line, which does not match any real
manufacturer figure for either unit.

---

## 3. Induction cooker findings (the 9 genuinely-Sulte SKUs)

### 3.1 Single-zone units — no contamination found, independent confirmation on one

**IMG/BUF/00226 — SL-G35-TP3 (3.5kW single zone tabletop).** Stored: 446×330×124mm,
3500W, 220V/50Hz, glass plate 285×285×4mm. No independent manufacturer spec sheet was
recoverable for this exact code (Sulte's own site pages return only a title via
automated fetch, see §5), but a genuine Sulte-style product photograph was recovered
and matches the description (compact single-zone touch-control tabletop unit).
Medium confidence — image-confirmed, numerically unconfirmed.

**IMG/BUF/00227 — SL-30C-XP3 (3kW drop-in).** Stored: 320×340×100mm, 3000W,
220V/50Hz, glass plate 320×340×4mm (i.e. the glass covers the entire footprint — a
detail consistent with a flush drop-in unit, not a tabletop one). A genuine
SULTE-logo-branded photograph was recovered showing exactly this configuration: a
flush drop-in glass module wired to a separate remote control pod (digital display +
knob), matching our description's *"Touch & knob control."*

One nuance worth flagging: multiple independent listings for this exact code
describe it as a **"built-in induction warmer for buffet"** rather than a general
cooktop, and quote a **60kg loading capacity** (the weight the surface/mounting can
bear) — a buffet-service spec that isn't in our record at all:
https://www.alibaba.com/product-detail/SL-30C-XP3-built-in-hot_500011830424.html
(page metadata attributes this listing to Foshan Shunde Sulte Electronics Co., Ltd
directly). This doesn't contradict our stored spec, but it suggests the product may
be positioned/marketed by Sulte primarily for buffet keep-warm duty rather than
active cooking — worth reflecting in the copy, and worth adding the 60kg loading
figure.

**IMG/BUF/00228 — SL-G50-KP9 (5kW single zone tabletop).** Stored: 484×400×245mm,
5000W, 220V/50Hz, glass 300×300×4mm. A genuine SULTE-logo-branded product photograph
was recovered, showing a knob+touch combo control panel matching our description's
*"Touch & knob control."* Medium confidence — image-confirmed, numerically
unconfirmed independently.

**IMG/BUF/00229 — SL-G50-KA12 (5kW induction wok).** Stored: 525×440×265mm, 5000W,
220V/50Hz. **Highest-confidence SKU in the whole batch.** A live Alibaba listing was
found with an exact model **and** brand match:

> "Model Number SL-G50-KA12, Brand Name SULTE, Power (W) 5000, Voltage (V) 220,
> Dimension 53\*40\*26 cm" — https://www.alibaba.com/product-detail/KA12-Induction-Hob-China-Cooking-Hobs_60555337704.html
> (also listed at https://www.tradewheel.com/p/fry-chinese-food-kitchen-appliances-5kw-330795/,
> attributed to Foshan Shunde Sulte Electronics)

530×400×260mm vs our stored 525×440×265mm: length and height match closely (525≈530,
265≈260); **width is off by 40mm (440 vs 400, a ~9% gap)** — flagged, but a single
independent figure isn't enough to say confidently which is right. A genuine
SULTE-branded photograph (round wok insert, matching control layout) was also
recovered. High confidence overall.

### 3.2 Two-zone units — names and dimensions may be crossed between siblings

**IMG/BUF/00230 — SL-C351-KPP3-Y, "Two Zone Table Top 7KW."** Stored: 800×355×113mm
(wide and shallow), 3500W×2, 220V/50Hz.

**IMG/BUF/00231 — SL-C351-KPP2, "Two Zone (Side by Side) 7KW."** Stored:
450×700×130mm (narrow and deep), 3500W×2, 220V/50Hz.

No manufacturer photo or spec sheet was recoverable for either exact code. But the
**shape of the two footprints looks backwards relative to their own names**: a true
"side by side" two-burner layout needs *more* width (to fit two ~300mm circles next
to each other) and comparatively *less* depth, which is what 00230's 800×355 profile
looks like — even though 00230's own name carries no "side by side" qualifier.
00231, whose name explicitly says "Side by Side," instead has the narrower/deeper
450×700 profile that reads more like a front-to-back (tandem) arrangement. Two
possibilities, neither provable from what could be found:

1. The `length`/`width` figures were swapped between the two records during import
   (a genuine sibling-contamination bug), or
2. `KPP3-Y` and `KPP2` really are two different physical layouts and it's the
   **names**, not the dimensions, that don't match reality.

**Recommendation: do not correct either field without a supplier photo or spec
sheet** — this is exactly the kind of ambiguity where a wrong "fix" would make things
worse. Flagged for manual verification only.

> **UPDATE (§6.4):** manufacturer photography of the C351 two-zone range has since been
> recovered, and it points at possibility **2**. Every two-zone C351 Sulte publishes is a
> **tandem (front-to-back)** unit on a narrow, deep cabinet — matching 00231's stored
> 450×700 footprint. So 00231's *dimensions* now look correct and its *name* ("Side by
> Side") looks wrong. 00230's wide-and-shallow 800×355 still matches nothing Sulte
> publishes and remains unresolved.

### 3.3 Four-zone unit — a third-party listing conflicts with our own dimensions

**IMG/BUF/00232 — SL-C351-4S13-Y, "4 Zone 14KW."** Stored: 760×700×260mm, 3500W×4 =
14,000W, 380V 3-phase/50Hz.

An Azerbaijani classifieds listing (lalafo.az) for this **exact model code** gives:

> "Ölçü [Dimensions]: 450x700x130 mm", "1 plitənin elektrik gücü [power per plate]:
> 3500 W", "Elektrik gərginliyi [voltage]: 3 PRO [3-phase]"
> https://lalafo.az/azerbaijan/elektronika/q-elektirik-peci?page=6

The power-per-plate and three-phase figures **match our record exactly**. The
dimensions (450×700×130) **do not match our record at all — but they are identical
to our own IMG/BUF/00231 (the two-zone "Side by Side" unit, §3.2)**.

This is very unlikely to mean our four-zone record is wrong: a 450×700mm footprint is
too small to physically fit four 300×300mm induction zones (a 2×2 layout needs at
least ~650×650mm for the glass alone, before housing and controls), while our stored
760×700mm easily accommodates it. The more likely explanation is that the Azerbaijani
reseller made their own copy-paste error, reusing a two-zone unit's dimensions on a
four-zone listing. **Recommendation: keep our stored 760×700×260mm** as the
physically sensible figure, but note the third-party conflict rather than silently
discard it — it's a reminder that even the two-zone/four-zone dimension set as a
*whole* carries above-average risk and deserves a supplier re-check alongside §3.2.

> **UPDATE (§6.4):** corroborated. Sulte's own four-zone C351 renders show a **2×2 grid on
> a roughly square cabinet**, consistent with our 760×700 and inconsistent with the
> Azerbaijani 450×700 — which is itself the footprint of Sulte's *two-zone* tandem body.
> Keep our figure; the reseller copy-paste explanation is now the well-supported one.

### 3.4 Fryer and griddles

**IMG/BUF/00233 — SL-FR1C23A, "Induction Fryer 23L."** Stored: 760×400×950mm, 415V
50/60Hz, 8000W, 3-phase, temperature range 30-210°C. No independent source
(manufacturer or reseller) could be found for this exact code despite an extensive
search. The spec is internally coherent — 950mm height is plausible for a
floor-standing fryer with an elevated oil vat and control head, and 8kW on 415V
three-phase is a sensible pairing for Kenyan commercial premises — but this SKU
carries **Low confidence** purely from lack of any corroborating source. No
contamination evidence either way.

**IMG/BUF/00234 — GRT24B, "Induction Griddle 6KW."** Stored: 750×610×405mm, cooking
surface 61cm (~24"), 380V 3-phase/50-60Hz, temperature range 60-250°C. **Confirmed to
exist in Sulte's own official catalogue** —
https://www.sulteer.com/productinfo/1135662.html, titled "24inch GRIDDLE GRT24B,"
whose visible snippet text (*"Real-time temperature... Temperature
range:60-250℃... Timer: 0~23 hours 59 minutes"*) matches our stored temperature range
exactly and adds a timer spec (0-23h59m) that isn't in our record. High confidence on
model identity; full numeric spec sheet could not be extracted because sulteer.com
renders product detail via client-side JavaScript that an automated fetch cannot see
(§5) — only page titles and cached search-snippet text were retrievable.

**IMG/BUF/00282 — GRT36B, "Induction Griddle 6KW" (archived, price 0, no
description/spec at all).** Also confirmed on Sulte's own site —
https://www.sulteer.com/productinfo/1135663.html, titled "36inch GEIDDLE GRT36B" (the
manufacturer's own site has a typo, "GEIDDLE" for "GRIDDLE" — visible even in the
search snippet, an amusing but genuine confirmation this is the real source).

**Power sanity flag:** both our GRT24B and GRT36B are named "Induction Griddle 6KW" —
**the identical power rating on a 24-inch and a 36-inch griddle.** A 36" surface is
roughly 2.25× the area of a 24" one; maintaining comparable heat density across that
much more plate would normally require substantially more power (a 36"-class
induction griddle in this power tier is typically rated in the 10-15kW range, often
built as two or more independently-controlled zones under one continuous top, rather
than a single 6kW element scaled up). This reads as a name-level copy-paste of the
smaller model's power figure onto the larger one, the same shape of error the Iberna
and Brema passes found repeatedly in spec text — except here it has propagated into
the **product name itself**, on both SKUs. GRT36B's record has no populated fields to
independently check, so this can't be confirmed against our own spec text, only
flagged as implausible and needing a supplier-verified power figure before this
record is ever un-archived or repriced.

> **UPDATE (§6.3):** now corroborated from the hardware. Sulte's own renders show
> **GRT36B with two independent digital control panels** against GRT24B's one — i.e. the
> twin-zone construction predicted two paragraphs above. Treat the 6 kW figure as
> confirmed-suspect rather than merely suspected.

---

## 4. Cross-cutting notes

- **Electrical suitability for Kenya**: every single-zone/wok/two-zone unit that
  states a voltage is 220-240V/50Hz single-phase — a standard match for Kenyan
  domestic-style commercial supply. The 4-zone 14kW unit (00232) and the 23L fryer
  (00233) are correctly specified as 380V/415V three-phase, which is appropriate —
  a 14kW load on single-phase 240V would be ~58A, well outside normal single-circuit
  wiring, so three-phase here is the physically necessary choice, not an error. No
  red flags found on this front, but worth a standing purchase-time note that
  3-phase supply must actually be present at the customer's premises for these two
  SKUs specifically.
- ~~**No manufacturer photo exists anywhere for the two-zone/four-zone family, the
  fryer, or either griddle**~~ — **wrong, and the error was a tooling limitation.**
  See §6.1: the photos were on `sulteer.com` the whole time, hidden behind a CMS that
  serves page content from a CDN JavaScript bundle rather than in the HTML. Both
  griddles are now covered at 4901×4901 with exact-model manufacturer renders. The
  two-zone, four-zone and fryer SKUs are covered at platform level (correct zone count
  and body style, different model suffix) at up to 9450×9450. Only the **exact model
  codes** `SL-C351-KPP3-Y` / `-KPP2` / `-4S13-Y` and `SL-FR1C23A` remain unphotographed,
  and those genuinely return zero web hits of any kind (§6.7) — for those, asking the
  supplier directly is still the right call.
- **Width/height axis swap (the Brema/Santos/Empero-style bug) was not confirmed
  anywhere in this brand** — but that's because independent numeric cross-checks
  only existed for one SKU (00229, §3.1), where the stored axis order matched. This
  is an absence-of-evidence result, not a clean "no bug here" like the Iberna pass
  achieved across its whole range.
- ~~**`sulteer.com` could not be read by automated tooling.**~~ **SOLVED — no browser
  needed, see §6.1.** The site's "website acceleration" feature returns a 950-byte HTML
  stub and injects the real page from a CDN-hosted `…Body.js` bundle. Fetch that bundle
  and the complete markup — images and all — comes back in plain text. Product pages are
  also enumerable by numeric id (`/productinfo/<id>.html`, range 1135505–1135664), which
  recovered the full 16-product catalogue. **This technique should be tried first on any
  other `website.xin` / `hkwezhan.cn` factory-CMS site in this catalogue.** Note the site
  still publishes no numeric spec tables — the recovered pages carry a title, one render,
  and a short feature blurb only, so the missing dimensions for the two-zone, four-zone
  and fryer SKUs are still unavailable from this source.

---

## 5. Product reference

| SKU | Catalogue name | Model | Manufacturer | Source | Confidence |
|---|---|---|---|---|---|
| IMG/BUF/00226 | Induction Cooker Single Zone 3.5KW Table Top | SL-G35-TP3 | Sulte | https://www.sulteer.com/productinfo/1135611.html — manufacturer's own SULTE-badged render (§6.1); no numeric spec source found. **The previously-staged photo for this SKU was a different machine — see §6.2** | Medium-High on identity, unconfirmed numerically |
| IMG/BUF/00227 | Induction Cooker Drop in 3KW | SL-30C -XP3 | Sulte | https://www.alibaba.com/product-detail/SL-30C-XP3-built-in-hot_500011830424.html | Medium-High — logo-confirmed photo + matching Alibaba listing text |
| IMG/BUF/00228 | Induction Cooker Single Zone 5KW Table Top | SL-G50-KP9 | Sulte | image-confirmed only; no numeric spec source found | Medium |
| IMG/BUF/00229 | Induction Wok 5KW Table Top Single | SL-G50-KA12 | Sulte | https://www.alibaba.com/product-detail/KA12-Induction-Hob-China-Cooking-Hobs_60555337704.html | **High** — exact model+brand+power Alibaba match, logo-confirmed photo |
| IMG/BUF/00230 | Induction Cooker Two Zone Table Top 7KW | SL-C351-KPP3-Y | Sulte | none found; name/dimension cross-check only, see §3.2 | Low-Medium |
| IMG/BUF/00231 | Induction Cooker Two Zone (Side by Side) 7KW | SL-C351-KPP2 | Sulte | https://www.applianceregistrationdatabase.org.za/... (confirms brand/model/power only, not dimensions) | Medium — manufacturer confirmed, dimensions disputed (§3.2) |
| IMG/BUF/00232 | Induction Cooker 4 Zone 14KW | SL-C351-4S13-Y | Sulte | https://lalafo.az/azerbaijan/elektronika/q-elektirik-peci?page=6 (power/phase agree, dimensions conflict, see §3.3) | Medium |
| IMG/BUF/00233 | Induction Fryer 23L | SL-FR1C23A | Sulte (brand only, unconfirmed per-SKU) | none found | Low |
| IMG/BUF/00234 | Induction Griddle 6KW | GRT24B | Sulte | https://www.sulteer.com/productinfo/1135662.html — manufacturer render recovered at 4901×4901 (§6.1) | High on identity; dims still not independently verifiable (site publishes no spec table) |
| IMG/BUF/00282 | Induction Griddle 6KW | GRT36B | Sulte | https://www.sulteer.com/productinfo/1135663.html — manufacturer render recovered at 4901×4901 | High on identity; **power figure confirmed-suspect — the render shows two control panels vs GRT24B's one**, see §3.4 / §6.3 |
| IMG/HOT/00402 | Microwave Oven 25LTR | EM025FJTS0SF00 | **Midea (OEM)**, not Sulte | https://www.manualslib.com/manual/3557947/Midea-Em025fjt-S0sa00.html , https://www.gastronorm.it/en/EMO25FJT-Professional-microwave-oven-with-digital-controls | High on platform identity; brand field almost certainly wrong (§2) |
| IMG/HOT/00403 | Microwave Oven 34LTR | EMA34GTQS00E00 | **Midea (OEM)**, not Sulte | https://www.gastronorm.it/en/EMA34GTQ-Professional-microwave-oven-with-digital-controls | High on platform identity; brand field almost certainly wrong (§2) |

---

## 6. Image sourcing — staged in `Desktop\ecommerce\products resource\sulte-images\`

### 6.1 `sulteer.com` was cracked — it is the richest image source in the whole catalogue

The earlier pass's blocker (§4: "sulteer.com could not be read by automated tooling…
an automated fetch retrieves only the page `<title>` tag") is **solved, without needing
a browser.** The site runs a Chinese factory CMS (`hkwezhan.cn`) whose "website
acceleration" feature serves a 950-byte HTML stub and injects the entire real page from a
CDN-hosted JavaScript bundle. Fetching that bundle directly returns the complete,
undecorated page markup — images, specs and all.

**The technique, worth reusing on any `website.xin` / `hkwezhan.cn` site:**

1. Fetch the product page (e.g. https://www.sulteer.com/productinfo/1135662.html) and
   read the `<script src=…Body.js?version=…>` URL out of the stub.
2. Fetch that bundle — e.g.
   `https://img.website.xin/pubsf/18039/18039808/cdn-static-pages/productinfo/pc/1135662_zh-cn.html.Body.js`
   — and unescape the `<` / `>` / `\/` sequences inside its `document.write(…)`.
3. Product image URLs appear as
   `//img.website.xin/contents/sitefiles3607/18039808/images/<id>.jpg`, served at **native
   upload resolution with no size suffix and no rewrite trick required**.
4. Product pages are enumerable by numeric id at `/productinfo/<id>.html`; a scan of
   1135200–1135800 recovered the entire catalogue (the site's own `sitemap.xml` is
   useless — it lists six top-level Chinese-slug pages and no products).

The payoff is large: Sulte uploads its studio renders at **9450 × 9450 px** (~2 MB each),
by a wide margin the highest-resolution manufacturer source found in any brand pass so
far. The earlier pass's conclusion that "no manufacturer photo exists anywhere for the
two-zone/four-zone family, the fryer, or either griddle" was a **tooling limitation, not
a real absence**.

**Full sulteer.com catalogue recovered** (16 products, each with exactly one render):

| id | Model | id | Model |
|---|---|---|---|
| 1135505 | 8L SL-FRT1CO8B *(page has no image)* | 1135635 | SL-C351-2E3-Y |
| 1135573 | 8L+8L Induction Fryer | 1135636 | SL-C351-4E3-Y |
| 1135604 | SL-G35-TP2 | 1135637 | SL-C351-6M3-Y |
| 1135608 | SL-G35-KP2 | 1135638 | SL-C351-2M1-Y |
| **1135611** | **SL-G35-TP3** ← 00226 | 1135639 | SL-C351-4E1-Y |
| 1135619 | SL-G35-KA18 | 1135640 | SL-C351-6M1-Y |
| **1135624** | **SL-30C-XP3** ← 00227 | **1135662** | **GRT24B** ← 00234 |
| 1135627 | SL-35C-XP8 | **1135663** | **GRT36B** ← 00282 |
| 1135630 | SL-50C-XA4 | 1135664 | 3500W spare parts |

Note what is **not** there: no `SL-G50-*` (our 00228/00229), no `SL-C351-KPP*` or
`-4S13-*` (our 00230/00231/00232), and no 23 L fryer (our 00233). Sulte's public site
carries a *different* set of suffixes on the same platforms — so exact-code photography
for five of our SKUs still does not exist publicly, even though the platform photography
now does.

### 6.2 CONTRADICTION — the staged 00226 photo is not SL-G35-TP3

**This is the pass's most important finding.** The previously-staged primary image for
IMG/BUF/00226, `…single-zone-tabletop-2560px.webp`, was accepted on the caveat that "no
logo [is] visible in frame, so brand not 100% confirmed by the image alone."

Sulte's own render of SL-G35-TP3 (id 1135611) is now in hand, and **it does carry a SULTE
logo, printed on the control fascia** — so the absence of a logo on the staged file is no
longer a neutral "the photographer cropped it out," it is a positive mismatch. The two
units differ on every distinguishing feature:

| | Sulte's official SL-G35-TP3 | Previously-staged 2560 px file |
|---|---|---|
| Fascia branding | **SULTE logo** printed left of the display | none |
| Control layout | display + `POWER`/`TEMP`/`TIMER` indicator LEDs, round `←`, `+→`, `TIMER`, `TEMP/POWER`, `ON/OFF` keys | square keys labelled `Lock`, `Timer`, `←`, `Temp`, display, `Power`, `+→`, **`Function`**, `On/Off` |
| Feet | small black moulded feet | large chromed adjustable levelling feet |
| Body | chamfered front edge, shallow surround | deep straight-sided stainless surround |

A `Lock` and a `Function` key that Sulte's own unit does not have is not a photographic
variation — it is a different control board. **The staged file has been renamed
`IMG-BUF-00226__REF__CONTRADICTS-sulte-official-TP3-different-fascia-no-logo-2560px.webp`
and must not be used as 00226's storefront photo.** It is retained, not deleted, as the
evidence for this finding. This is the third instance in this catalogue (after Kalerm and
Kusina) of a stored/staged photo showing a machine that is not the SKU it is filed under.

### 6.3 CORROBORATION — GRT36B has two control panels, supporting the §3.4 power flag

§3.4 flagged, on physical-plausibility grounds alone, that GRT24B and GRT36B both being
named "Induction Griddle 6KW" is implausible for a 2.25× larger plate. The manufacturer's
own renders now support that from the hardware side:

- **GRT24B** (4901×4901): one plate, **one** digital control panel + one rocker switch.
- **GRT36B** (4901×4901): a visibly wider plate on the same cabinet family with **two
  independent digital control panels** side by side + one rocker switch.

Two control boards means two independently-controlled heating zones, which is exactly the
construction §3.4 predicted for a 36″ unit ("often built as two or more independently-
controlled zones under one continuous top"). A twin-zone griddle drawing the same 6 kW
total as a single-zone 24″ unit makes no sense. **The GRT36B "6KW" figure should be
treated as confirmed-suspect, not merely suspected**, and re-sourced from the supplier
before that record is ever un-archived.

### 6.4 PARTIAL RESOLUTION — the SL-C351 two-zone layout question (§3.2/§3.3)

§3.2 could not decide between "the dimensions were swapped between the two-zone siblings"
and "the names don't match the physical layouts." Sulte's own C351 renders make the second
reading much more likely.

Every two-zone C351 Sulte publishes (`2E3-Y`, `2M1-Y`) is a **tandem** unit: the two
zones sit **front-to-back**, on a narrow, deep cabinet — not side by side. Every four-zone
C351 (`4E3-Y`, `4E1-Y`) is a **2×2 grid on a roughly square cabinet**. The range is
also split into tabletop (`…E3-Y`) and floor-standing-with-undershelf (`…M1-Y`, `…E1-Y`)
body styles on the same heads.

Consequences:

- Our **00231** (`SL-C351-KPP2`, *"Two Zone (Side by Side)"*, stored 450×700×130) has a
  narrow-and-deep footprint that **matches the real tandem two-zone body**. Its stored
  dimensions now look *right* and its **name looks wrong** — "Side by Side" appears to
  describe a layout Sulte does not build in this series. §3.2's recommendation flips: do
  not swap the dimensions, review the name.
- Our **00232** (4-zone, stored 760×700×260) is corroborated: a roughly square cabinet is
  exactly what Sulte's 2×2 four-zone units are. This **strengthens §3.3's conclusion** to
  keep our figure and treat the Azerbaijani 450×700 listing as that reseller's copy-paste
  of a two-zone unit's dimensions.
- Our **00230** (`SL-C351-KPP3-Y`, *"Two Zone Table Top"*, stored 800×355×113 — wide and
  shallow) still matches **nothing** Sulte publishes. Unresolved; still needs supplier
  verification.

Caveat: these are same-platform siblings, **not** our exact model codes, so every C351
file below is filed `REF__`.

### 6.5 Microwaves — no Fimar-badged photo exists; the badge is EASYLINE

The brief asked for Fimar-badged images of the two microwaves. **They do not exist, and
the reason is itself the answer.** Fimar does not sell this platform under the Fimar name
— it sells it through its own sub-brand **"Easyline by Fimar"**, and the badge moulded
onto the physical fascia reads **EASYLINE** (with a small "by Fimar" beneath the logo).
Confirmed on the brand owner's own site, https://easylinebyfimar.it .

This is worth more than a photo: it means the EASYLINE badge on our previously-staged
verification images is not some downstream reseller's re-badge, it is **the manufacturer's
own branding for this product**. That materially strengthens §2's Priority-1
recommendation to restore `"brand": "EASYLINE"` on 00402/00403 — the physical units in a
Kenyan customer's kitchen will have "EASYLINE" printed on them, not "SULTE" and not
"FIMAR".

Official 800×800 renders were pulled from
https://easylinebyfimar.it/wp-json/wp/v2/media?per_page=100&search=em (ids 7795, 7797) —
a genuine upgrade on the 788×582 / 785×644 gastronorm.it crops staged previously, which
are the host's own ceiling (verified: stripping the `-788` suffix returns the identical
788 px file; `-1200`/`-1500`/`-2000` 404; bianchipro.it's PrestaShop caps at 600). No
`-scaled` variant exists at easylinebyfimar.it, so 800×800 is the true original.

They remain `REF__` **only** because the badge contradicts our stored `brand: SULTE` — as
soon as that field is corrected, `IMG-HOT-00402__REF__EASYLINE-by-Fimar-official-badge-800x800-NOT-SULTE.jpg`
and its 00403 sibling are the correct primary photos.

**Spec sheets downloaded** (new — the earlier pass staged only a 536×644 screenshot of the
comparison table):

- `IMG-HOT-00402__spec-sheet.pdf` (72 KB) — https://www.ristored.it/files/foto/download/4026.pdf
- `IMG-HOT-00403__spec-sheet.pdf` (76 KB) — https://www.ristored.it/files/foto/download/4025.pdf
- `_brand-reference/Easyline-by-Fimar-official-catalogue-p65-EMA34GTQ-vs-EM025FJT-spec-table-1833x1833.jpg`
  (1833×1833, 362 KB) — https://www.teconova.it/public/65_3.jpg — page 65 of Fimar's own
  multilingual catalogue, the **full-resolution original** of the table screenshotted at
  536×644 in §2.3. Legible in six languages and confirms every figure §2.3 relies on:
  EMA34GTQ 2.8 kW / 34 L GN2/3 / cavity 360×409×225 / external 574×528×367 / 32.2 kg;
  EM025FJT 1.55 kW / 25 L GN2/3 / cavity 327×346×200 / external 510×440×310 / 15 kg; both
  220-240V/1N/50Hz. §2.3's recommendations stand unchanged.

### 6.5A Applied to the project — 29 July 2026

Four SULTE SKUs now carry real photographs. Every cover replaced here was tiny — the worst,
GRT24B, was **226×223 px**:

| SKU | Model | Was | Now |
|---|---|---|---|
| IMG/BUF/00227 | SL-30C-XP3 | 599 px | cover (3/4 angle) + gallery: front hero, rear twin-fan detail |
| IMG/BUF/00228 | SL-G50-KP9 | 375×353 | SULTE-badged hero |
| IMG/BUF/00234 | GRT24B | **226×223** | official render, single control panel |
| IMG/BUF/00282 | GRT36B | 600 px | official render, two control panels (archived record) |

**Later the same day the `REF__` set went live too, on explicit instruction** — with the
standing condition that **no `model_number` may be changed**. So these records now show a
photograph of a *neighbouring* model while keeping their own code:

| SKU | Record code | What the photo actually shows |
|---|---|---|
| 00226 | `SL-G35-TP3` | SULTE official TP3 — different fascia, no logo (§6.2 contradiction) |
| 00229 | `SL-G50-KA12` | `SL-G35-KA18` — same body, 3.5 kW sibling |
| 00230 | `SL-C351-KPP3` | `SL-C351-2E3-Y` tandem two-zone |
| 00231 | `SL-C351-KPP2` | `SL-C351-2E3-Y` tandem two-zone |
| 00232 | `SL-C351-4S13` | `SL-C351-4E3-Y` four-zone 2×2 |
| 00233 | `SL-FR1C23A` (23 L) | twin-tank 8 L + 8 L fryer — **not 23 L** |
| 00402 | `EM025FJTS0SF00` | EASYLINE-by-Fimar badge — **not SULTE** |
| 00403 | `EMA34GTQS00E00` | Easyline-badged OEM unit — **not SULTE** |

This is a deliberate trade: a photograph of the right *class* was judged better than no
photograph. It does not resolve §6.2, §6.4 or §6.5 — those questions stand exactly where they
were, and the pictures must not be read as evidence for the codes. **00233 is the sharpest
case**: the image contradicts the capacity in the product's own name.

Two notes:

- §3.4's power flag is now **visible on the storefront side**. 00282's cover shows two control
  panels where 00234's shows one, which is the §6.3 corroboration. The record is archived, so
  nothing customer-facing yet — but the photograph now carries the contradiction the name does.
- The files applied are 1512 px re-fetches, downscaled from the 4901–9450 px masters listed in
  §6.6 rather than upscaled. These are the only genuinely-downscaled applications so far; every
  other brand's re-fetch was an upscale.

### 6.6 Files staged

Naming is SKU-first throughout: `<SKU-with-dashes>__<descriptor>.<ext>`, with the marker
**after** the SKU (`IMG-BUF-00232__REF__…`). Non-product material lives in
`_brand-reference/`.

**★ Primary — exact model match, manufacturer-sourced, visually verified:**

| SKU | Model | File | Pixels | Size |
|---|---|---|---|---|
| **00226** | SL-G35-TP3 | `IMG-BUF-00226__SL-G35-TP3-sulte-official-hero-9449x9450.jpg` | 9449×9450 | 1.9 MB |
| **00227** | SL-30C-XP3 | `IMG-BUF-00227__SL-30C-XP3-sulte-official-dropin-plus-control-pod-9450x9449.jpg` | 9450×9449 | 1.9 MB |
| **00234** | GRT24B | `IMG-BUF-00234__GRT24B-sulte-official-hero-single-control-panel-4901x4901.jpg` | 4901×4901 | 699 KB |
| **00282** | GRT36B | `IMG-BUF-00282__GRT36B-sulte-official-hero-TWO-control-panels-4901x4901.jpg` | 4901×4901 | 631 KB |

Sources: https://www.sulteer.com/productinfo/1135611.html · `/1135624.html` ·
`/1135662.html` · `/1135663.html`, via the CDN bundles described in §6.1; image files at
`https://img.website.xin/contents/sitefiles3607/18039808/images/{8566910,8566993,8567534,8567538}.jpg`

Visually verified: 00226 shows a single-zone tabletop with a **SULTE-logo** fascia;
00227 shows a flush black drop-in glass module wired to a **separate remote control pod**
(display + knob + TIMER), matching the record's "Touch & knob control" exactly; 00234 a
24″ flat griddle with a raised splash surround and one control panel; 00282 the wider 36″
plate with two.

**★ Primary retained from the earlier pass** (SULTE-badged, exact model, but under the
800 px bar — no higher-resolution source exists, `sulteer.com` does not list the G50
series and Alibaba's storefront serves a JS shell with no extractable gallery):

| SKU | Model | File | Pixels |
|---|---|---|---|
| 00228 | SL-G50-KP9 | `IMG-BUF-00228__SL-G50-KP9-branded-hero-750px.webp` | 750×750 |
| 00229 | SL-G50-KA12 | `IMG-BUF-00229__SL-G50-KA12-wok-branded-hero-870px.webp` | 870×749 |
| 00227 | SL-30C-XP3 | `…-drop-in-branded-hero-750px.webp`, `…-angle-vents-639px.webp`, `…-rear-fans-detail-499px.webp` | 750 / 639 / 499 |

**REF — same platform, different model suffix. Correct zone count and body style, wrong
code. Layout evidence only, not storefront photos:**

| SKU | File | Pixels | What it proves |
|---|---|---|---|
| 00229 | `IMG-BUF-00229__REF__SL-G35-KA18-sibling-3.5kW-wok-same-body-9450x9450.jpg` | 9450×9450 | the KA-series wok body at full resolution (3.5 kW sibling of our 5 kW KA12) |
| 00230 | `IMG-BUF-00230__REF__SL-C351-2E3-Y-sibling-two-zone-TANDEM-tabletop-9450x9450.jpg` | 9450×9450 | C351 two-zone is tandem, not side-by-side (§6.4) |
| 00231 | `IMG-BUF-00231__REF__SL-C351-2E3-Y-sibling-two-zone-TANDEM-tabletop-9450x9450.jpg` | 9450×9450 | as above |
| 00231 | `IMG-BUF-00231__REF__SL-C351-2M1-Y-sibling-two-zone-TANDEM-floorstand-9450x9449.jpg` | 9450×9449 | same head on a floor stand with undershelf |
| 00232 | `IMG-BUF-00232__REF__SL-C351-4E3-Y-sibling-four-zone-2x2-tabletop-9449x9450.jpg` | 9449×9450 | four-zone is 2×2 on a square cabinet — corroborates our 760×700 (§3.3) |
| 00232 | `IMG-BUF-00232__REF__SL-C351-4E1-Y-sibling-four-zone-2x2-floorstand-9450x9450.jpg` | 9450×9450 | floor-standing four-zone variant |
| 00233 | `IMG-BUF-00233__REF__sulte-8L-plus-8L-twin-tank-sibling-induction-fryer-NOT-23L-2749x2749.jpg` | 2749×2749 | the only Sulte fryer photo that exists — a **twin-tank 8L+8L countertop** unit, SULTE-watermarked. Our 00233 is a 23 L, 760×400×950 mm floor-standing single. **Different machine; do not use.** |

Sources: `https://img.website.xin/contents/sitefiles3607/18039808/images/{8566907,8567030,8567035,8567032,8567037,8566815}.jpg`

**REF — microwaves (badge contradicts stored brand, see §6.5):**

| SKU | File | Pixels | Badge |
|---|---|---|---|
| 00402 | `IMG-HOT-00402__REF__EASYLINE-by-Fimar-official-badge-800x800-NOT-SULTE.jpg` | 800×800 | **EASYLINE** (by Fimar) — brand owner's own render |
| 00403 | `IMG-HOT-00403__REF__EASYLINE-by-Fimar-official-badge-800x800-NOT-SULTE.jpg` | 800×800 | **EASYLINE** (by Fimar) — brand owner's own render |
| 00402 | `IMG-HOT-00402__REF__Easyline-badged-same-OEM-unit-hero-788x582-VERIFICATION-NOT-SULTE-LOGO.jpg` | 788×582 | EASYLINE — gastronorm.it, host ceiling |
| 00402 | `IMG-HOT-00402__REF__Solwave-badged-same-OEM-unit-lifestyle-1000px-NOT-SULTE-LOGO.jpg` | 1000×1000 | **SOLWAVE** (US badge) |
| 00402 | `IMG-HOT-00402__REF__Solwave-badged-same-OEM-unit-angle-1000px-NOT-SULTE-LOGO.jpg` | 1000×1000 | **SOLWAVE** |
| 00403 | `IMG-HOT-00403__REF__Easyline-badged-same-OEM-unit-hero-785x644-VERIFICATION-NOT-SULTE-LOGO.jpg` | 785×644 | EASYLINE — gastronorm.it, host ceiling |

**REF — contradicted, retained as evidence:**

| SKU | File | Pixels | Why |
|---|---|---|---|
| 00226 | `IMG-BUF-00226__REF__CONTRADICTS-sulte-official-TP3-different-fascia-no-logo-2560px.webp` | 2560×2560 | different control board from Sulte's own TP3 — see §6.2 |

**`_brand-reference/`** — not photographs of a specific product: the Fimar catalogue spec
page (1833×1833, new), the earlier 536×644 crop of the same table, Sulte's factory/company
collage, Sulte's "MORE PRODUCTS" thumbnail grid, and the two unbranded/unverified two-zone
candidates from the earlier pass (now superseded as layout evidence by §6.4's
manufacturer-sourced C351 renders).

### 6.7 Proven unsourceable

Exhaustively probed and genuinely not on the public web, at any resolution:

- **`SL-C351-KPP3-Y`, `SL-C351-KPP2`, `SL-C351-4S13-Y`, `SL-FR1C23A`** — zero hits for any
  of these exact strings. Probed: Brave Search on each code (returns only Leica cameras,
  SEL protection relays and Technics turntables — i.e. no product matches at all);
  `sulteer.com`'s complete enumerated catalogue (§6.1); `sulte.en.alibaba.com/productlist.html`
  (serves a JS shell, no extractable gallery, no model codes in the HTML);
  made-in-china.com (no Sulte supplier page exists); accio.com's Sulte listings (icons
  only). The `2f0j00…` made-in-china rewrite trick is not applicable — Sulte has no
  made-in-china presence. **Platform-level photography now exists for all four (§6.6 REF
  rows); exact-code photography does not, and would have to come from the supplier.**
- **A higher-resolution `SL-G50-KP9` / `SL-G50-KA12`** — the G50 series is absent from
  `sulteer.com` entirely; 750 px / 870 px remain the ceiling.
- **A Fimar-badged microwave photo** — does not exist by construction; the brand's own
  badge for this product is EASYLINE (§6.5).

### 6.8 Scorecard

| | Count |
|---|---|
| Exact-model manufacturer photo ≥ 800 px | **4** (00226, 00227, 00234, 00282) — all ≥ 4901 px |
| Exact-model photo, correct badge, < 800 px | 2 (00228 750 px, 00229 870 px) |
| Official brand-owner photo, badge contradicts stored brand | 2 (00402, 00403 — both 800×800) |
| Platform/sibling reference only, no exact-code photo | 4 (00230, 00231, 00232, 00233) |
| **Usable image of the right machine, all sources** | **8 of 12** |

Net change from the earlier pass: **+4 exact-model photos** where it previously reported
"no image was found at all" (00234, 00282 primary; 00230/00231/00232/00233 platform-level
where there was nothing), **−1** previously-accepted photo reclassified as wrong-model
(00226), and **large resolution gains** on 00226/00227 (2560 → 9450 px).

**Nothing copied into `storage/app/public/products/` and nothing referenced in
`products.json`** — staged for manual review, same workflow as the Brema and Iberna
passes.

---

## 7. Recommended changes

Ordered by risk, not by effort. **None of this has been applied.**

### Priority 1 — brand-identity fix on published, priced SKUs

1. **IMG/HOT/00402 and IMG/HOT/00403: change `"brand": "SULTE"`.** These are
   Midea-OEM microwaves, not Sulte products — Sulte's own catalogue contains no
   microwaves at all. Our own catalogue's legacy `EASYLINE` listings
   (`sheffieldafrica.com/commercial-kitchen/product/1035` and `/1036`) are the exact
   same physical units and are the most defensible brand string to restore, unless
   the supplier confirms a different current source. (§2.1-§2.2)

### Priority 2 — factually wrong or implausible data on published, priced SKUs

2. **IMG/HOT/00402 and IMG/HOT/00403: fix the "Internal Dimensions" /
   "External Dimensions" mislabel.** What our records call "Internal" is the real
   external footprint (already close to correct); what they call "External" doesn't
   match either the real external size or even the real packing carton and should be
   replaced or dropped. Add the real internal cavity size, currently missing
   entirely: 327×346×200mm (25L) / 360×409×225mm (34L). (§2.3)
3. **IMG/HOT/00403: numeric `length`/`width`/`height` fields (650/610/480) should be
   650→574, 610→528, 480→367** to match the confirmed real external size and to be
   internally consistent with how the 25L sibling's numeric fields already behave
   correctly. (§2.3)
4. **IMG/HOT/00403: input power 3000W is 200W (7%) higher than Fimar's official
   2.8kW** — minor, but worth correcting to 2800/1800W if a firm source is wanted.
   (§2.3)
5. **IMG/BUF/00282 (GRT36B): the "6KW" power figure in the product name is very
   likely wrong** — identical to the smaller GRT24B despite a ~2.25× larger cooking
   surface. Lower urgency since this SKU is `archived`/`price: 0`, but should not be
   carried forward unchanged if this record is ever revived. (§3.4)

### Priority 3 — flagged for supplier verification, not corrected here

6. **IMG/BUF/00230 and IMG/BUF/00231: two-zone dimensions may be swapped between
   the "Table Top" and "Side by Side" records**, or the names may not match the
   physical layouts — the stored footprints read backwards relative to what each
   name implies. Needs a supplier photo or spec sheet before touching either field.
   (§3.2)
7. **IMG/BUF/00232: a third-party (Azerbaijani) listing for the identical model code
   gives dimensions that match our own two-zone SKU 00231, not our four-zone
   record.** Our stored 760×700×260mm is very likely the correct one (physically
   necessary for four zones) — recommend keeping it, but the conflict is worth a
   supplier check alongside item 6. (§3.3)
8. **IMG/BUF/00233 (fryer): zero independent corroboration found for any field.**
   Not contradicted by anything either — just unverified. Confirm with supplier
   before treating any figure as authoritative.

### Priority 4 — additions, not corrections

9. **IMG/BUF/00227: add the 60kg surface-loading capacity** found on independent
   listings, and consider whether the copy should describe this SKU primarily as a
   buffet warmer rather than a general cooktop. (§3.1)
10. **IMG/BUF/00234 (GRT24B): add the "0~23 hours 59 minutes" timer spec** confirmed
    on Sulte's own site; the current record has no timer detail. (§3.4)

### Priority 5 — brand record and commercial follow-ups

11. **Fill `brands.json` `website_url`** with **https://sulte.en.alibaba.com/** — the
    more stable of Sulte's two web presences (their own `sulteer.com` is thin and
    largely unreadable by automated tools). (§1)
12. ~~Revisit `sulteer.com` with real browser access~~ — **DONE, §6.1.** The site was
    read without a browser. Its pages carry no numeric spec tables, so the missing
    dimensions for the two-zone, four-zone and fryer SKUs remain a supplier question.
13. **Photography status after the July 2026 image pass (§6.6, §6.8):**
    - **DONE** — 00234 (GRT24B) and 00282 (GRT36B) now have exact-model manufacturer
      renders at 4901×4901; 00226 and 00227 upgraded to 9449/9450 px.
    - **STILL NEEDED from the supplier** — exact-code photography for 00230
      (`SL-C351-KPP3-Y`), 00231 (`SL-C351-KPP2`), 00232 (`SL-C351-4S13-Y`) and 00233
      (`SL-FR1C23A`). Platform-level sibling photos are staged as `REF__` and are good
      enough to reason about layout, **not** good enough to publish. Also worth asking
      for a >800 px `SL-G50-KP9` / `SL-G50-KA12` render, since Sulte does not publish
      the G50 series at all.

### Priority 6 — added by the image pass

14. **IMG/BUF/00226: the staged product photo is not SL-G35-TP3** and must not be
    published. Sulte's own TP3 render carries a SULTE-logo fascia with a different
    control board (no `Lock`/`Function` keys, different feet). Replacement is already
    staged. **Highest-urgency image item — this SKU is published and priced.** (§6.2)
15. **IMG/BUF/00282 (GRT36B): the "6KW" figure is now confirmed-suspect, not merely
    implausible.** Sulte's own render shows GRT36B with **two independent control
    panels** to GRT24B's one — i.e. twin-zone construction, which cannot plausibly draw
    the same total power as the single-zone 24″ unit. Re-source the figure before this
    record is un-archived. (§6.3)
16. **IMG/BUF/00231: reconsider the *name*, not the dimensions.** Sulte builds its C351
    two-zone units in a **tandem (front-to-back)** layout, matching 00231's stored
    narrow-and-deep 450×700 footprint. "Side by Side" appears to describe a layout that
    does not exist in this series. This reverses the §3.2 recommendation for this SKU.
    (§6.4)
17. **IMG/BUF/00232: keep 760×700×260 — now corroborated.** Sulte's four-zone C351 units
    are 2×2 grids on roughly square cabinets, consistent with our figure and inconsistent
    with the Azerbaijani listing's 450×700. (§6.4)
18. **00402/00403: the correct brand string is almost certainly `EASYLINE`.** The badge
    moulded on the physical fascia reads EASYLINE, and that is the *manufacturer's own*
    sub-brand ("Easyline by Fimar"), not a reseller re-badge — so item 1 above is now
    supported by the hardware itself, not just by our legacy listings. Official 800×800
    renders and both spec-sheet PDFs are staged. (§6.5)
