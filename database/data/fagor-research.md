# Fagor Product Research

Research notes behind the FAGOR enrichment pass on `products.json` (July 2026). Covers
both FAGOR SKUs in the catalogue: two 4-burner table-top gas ranges from two different
Fagor "Range" size families — **CG6-40** (600 Range) and **CG7-40** (700 Range). Specs
were sourced from Fagor Industrial's own 600 Range brochure PDF and cross-checked against
multiple independent commercial-kitchen resellers (Australia/Malaysia/Spain) who mirror
Fagor's official spec sheets.

**This pass is a full build-out, not a correction** — both SKUs went into this pass with
only a `name` / `model_number` / `price` / `image`, no dimensions, no specs, no
descriptions. No `model_number` was changed (see [[feedback_model_number_unique_id]]) and
no image field was changed — image sourcing (§5) is presented as links for manual review.

---

## 1. Brand identification

**Fagor Industrial**, a Spanish manufacturer of commercial kitchen, laundry and
refrigeration equipment, founded as part of the **Fagor Group** (brand born 1959, group
founded 1964 in the Debagoiena/Mondragón region of the Basque Country). Fagor Industrial
is part of **ONNERA Group**, which bundles seven catering/laundry/refrigeration brands
(Fagor, Asber, Edesa, Efficold, Danube, Domus, Primer) under **Mondragón Corporation**,
Spain's largest industrial cooperative group.

**In October 2021 "Fagor Industrial" was rebranded "Fagor Professional"** — same company,
same product lines, new name/domain (`fagorprofessional.com`, formerly
`fagorindustrial.com`). Both names appear across the web depending on document age; not a
different brand.

**Current generation is "Kore" (Kore 700 / Kore 900), which supersedes the older named
"600/700/900 Range" cooking lines our two SKUs belong to.** The Kore microsite has no
CG6-40/CG7-40 listings — those model codes belong to the prior generation, still
documented in Fagor's own 600 Range brochure and mirrored verbatim by resellers, so they
are legacy-but-current-catalogue models, not house/OEM codes.

---

## 2. Where to look — and the traps

| Resource | URL |
|---|---|
| Official site (current) | fagorprofessional.com (rebrand of fagorindustrial.com, Oct 2021) |
| Official 600 Range brochure (PDF, has full spec table) | `fagorprofessional.com/documents/20127/759111/12158849-2019-1_600+SERIES+BROCHURE_EN.pdf` |
| Kore microsite (current gen, no CG6/CG7 codes) | `fagorprofessional.com/en/kitchen-appliances/commercial-kitchen/kore` |
| Spec mirrors (700 Range, Australia — one shared distributor feed) | foodequipment.com.au, restaurantequipment.com.au, commercialkitchenappliances.com.au, veysel.com.au, leadingcatering.com.au, nationalkitchenequipment.com.au, kwcommercial.com.au — **all return byte-identical copy**, treat as one source, not independent confirmation |
| CG6-40 (Malaysia / Spain resellers) | kitchen-arena.com.my, tientien.com.my, pulidohosteleria.com, provihostel.com |
| Manufacturer catalogs (image + PDF host) | archiexpo.com / pdf.archiexpo.com (blocks automated fetches with 403 — use only via search-engine synthesis, not direct fetch) |

### Traps

1. **"H" suffix on 700 Range codes is a distributor artefact, not a Fagor model
   designator.** Every Australian reseller lists the 4-burner 700 unit as **CG7-40H**, but
   Fagor's own **CG6-40** (600 Range, confirmed in the official brochure) has **no** H
   variant anywhere, and our catalogue's own `model_number` for both SKUs omits it. Keep
   the catalogue's plain **CG7-40** — do not add "H" to `model_number` without approval
   (only note it here per [[feedback_model_number_unique_id]]).
2. **archiexpo.com and pdf.archiexpo.com block automated fetches (403)** even though they
   rank first in search results for Fagor spec sheets. Their catalog PDFs could not be
   retrieved directly this pass; where used, the data came from Google's synthesis of the
   indexed page text, which is lower-confidence than a directly-read source. The one PDF
   read directly and fully (the official 600 Range brochure) is the highest-confidence
   source in this file.
3. **CG6 and CG7 are different size families (600mm vs 700mm module width), not versions
   of the same range.** Fagor sells parallel "600 Range" (bars/cafeterias/small
   establishments) and "700 Range" (full commercial kitchens) lines with similar styling
   but different burner power, dimensions and weight — confirmed independently for both in
   §3. Don't average or cross-apply their specs.
4. **Burner-power arithmetic doesn't cleanly divide on the CG7-40.** Reseller copy states
   "4 burners × 6.9 kW = 32.6 kW total", but 4 × 6.9 = 27.6, not 32.6 (a 5 kW gap). The
   same reseller family's CG7-61H listing has an identical mismatch that resolves exactly
   against its stated oven burner (6 × 6.9 = 41.4, + 7.8 oven burner = 49.2 ✓) — but the
   CG7-40 has no oven, so the CG7-40 discrepancy is unexplained. Likely the 4 burners are
   not uniform (e.g. 2 × 6.9 kW + 2 × 9.35 kW, common on professional ranges with
   larger rear burners), but no source gives a per-position breakdown. **Recorded the
   total (32.6 kW) as authoritative since it is repeated consistently, and stated "4
   burners" without asserting all four are 6.9 kW.**
5. **Don't confuse the CG7 series' generic "gas cooktop" archiexpo listing (which spans
   CG7-10 through CG7-61, 350–1050 mm) with a single-model spec sheet** — it gives family
   ranges (e.g. width 775mm, length 350–1050mm) not per-SKU numbers.

---

## 3. Product reference

| SKU | Catalogue name (now) | Model | Range | Official page/source | Confidence |
|---|---|---|---|---|---|
| IMG/HOT/00048 | 4 Burner Table Top Fagor CG7-40 | CG7-40 | 700 Range | Reseller mirrors of Fagor's official 700 Range spec sheet (archiexpo-indexed) | Medium — consistent across ≥7 independent-looking domains, but likely one shared distributor feed; not read from an original Fagor PDF this pass |
| IMG/HOT/00049 | 4 Burner Table Top Fagor CG6-40 | CG6-40 | 600 Range | Official Fagor 600 Range brochure PDF (`fagorprofessional.com`), directly read and cross-checked against 4 independent resellers | **High** — read the primary-source PDF in full |

### Specs found

**CG6-40** (from the official brochure table, "GAS RANGES" section):

| Field | Value |
|---|---|
| Burners | 4 × 3 kW |
| Total power | 12.00 kW |
| Dimensions (W × D × H) | 600 × 650 × 290 mm |
| Net / gross weight | 34 kg / 35 kg *(reseller-sourced, not in the brochure table)* |
| Gas consumption | 0.999 kg/h |
| Gas regulation | LPG G30/G31 at 28–30/37 mbar; NG G20/G25/G25.1 at 20/25/25 mbar |
| Construction | Stainless steel body; open hobs with safety valve + thermocouple per burner; permanent pilot flame ignition; cast-iron gratings and burners; double grill ≈285 × 535 mm; adjustable legs |
| Assembly options | Standard wall block / work-top assembly / top assembly over a support stand (Fagor sells matching `MB6-05`/`MB6-10` stands and `MNB-`/`ANB-` support tables — not our SKU, noted for context only) |

**CG7-40** (reseller mirrors of the 700 Range spec sheet — see trap #2):

| Field | Value |
|---|---|
| Burners | 4 (stated as "6.9 kW each" by resellers, but see trap #4 on the arithmetic) |
| Total power | 32.6 kW (≈117.36 MJ) |
| Dimensions (W × D × H) | 700 × 775–780 × 290 mm (reseller depth varies 775/780; treated as ~777 mm) |
| Net weight | 61 kg |
| Grill/grate dimensions | 347 × 310 mm per burner position |
| Construction | Stainless steel body; open hobs with safety valve + thermocouple per burner; pilot ignition; cast-iron gratings and burners; grease/fat collector tray under the grids |
| Gas | Available in NG and LPG versions (regional SKU split; exact NG/LPG regulation pressures not found for the 700 Range, unlike the 600 Range table) |

---

## 4. Not published — left blank rather than invented

- **CG7-40**: per-burner power breakdown (front vs rear), gas consumption in kg/h, exact
  LPG/NG regulation pressures, gross weight, and packed/carton dimensions.
- **CG6-40**: nothing material missing — the official brochure table plus reseller weight
  figures cover the field set we use.
- Neither SKU's ignition voltage/electrical requirement (if any, e.g. for a spark
  ignition variant) was found — both appear to be pilot-flame ignition with no electrical
  connection required, consistent with "permanent pilot flame" copy in the brochure.

---

## 5. Image sourcing — for manual review

No image field was changed this pass. Both existing catalogue photos are the same
studio-render style (cast-iron burners, recessed control knobs, "FAGOR" badge on the
right end panel) and are visually almost indistinguishable at this crop/angle — plausible
since the 600 and 700 Range share identical design language just at different scale, but
worth a manual side-by-side check against the sources below to confirm neither file is
misassigned to the wrong SKU.

### 5.1 CG6-40 — IMG/HOT/00049

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| Kitchen Arena (Malaysia) | [fagor-gas-range-4-open-burner-cg6-40](https://www.kitchen-arena.com.my/fagor-gas-range-4-open-burner-cg6-40.html) | <https://www.kitchen-arena.com.my/media/catalog/product/cache/f603baa9e6784a7839c7e4f32d8fcf28/f/a/fagor-600-range-gas-ranges-2.jpg> | 200, jpeg, 35 KB | Clean studio shot, exact 600-Range 4-burner model. |
| Official brochure (composite) | [600 Series Brochure PDF](https://www.fagorprofessional.com/documents/20127/759111/12158849-2019-1_600+SERIES+BROCHURE_EN.pdf) p.5 | — (embedded in PDF, not a standalone URL) | Read directly | Shows the CG6-40 as the leftmost unit in a full assembled 600 Range line; good for verifying knob layout/branding, not a standalone product shot. |

### 5.2 CG7-40 — IMG/HOT/00048

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| Leading Catering (Australia) | [cg7-40h benchtop cooktop](https://leadingcatering.com.au/fagor-benchtop-natural-gas-4-burners-gas-cooktop-700mm-width-cg7-40h.html) | <https://leadingcatering.com.au/media/catalog/product/c/g/cg7-40h.jpg?width=600&height=600&store=default&image-type=image> | 200, jpeg | Clean studio shot on white, exact 700-Range 4-burner model. |
| Hospitality Equipment Online (Australia) | [fagor-cg7-40h](https://hospitalityequipmentonline.com.au/fagor-cg7-40h-700-series-natural-gas-4-burner-ss-boiling-top-with-cast-iron-trivets-and-burners-700-x-780-x-290mm) | (page returned 503 this pass — retry) | 503 | Page title alone confirms dimensions 700×780×290mm independently of the other resellers. |

**Dead/blocked:** `manualzz.com` CG7-20 manual (403); `ipelican.com` (domain expired,
redirects to a GoDaddy parking page); `pdf.archiexpo.com` and `archiexpo.com` product
pages (403 to automated fetch); `hospitalityequipmentonline.com.au` (503 this pass, likely
transient).

---

## 6. Summary of `products.json` changes proposed (not yet applied)

Both SKUs currently have no `gallery`, no `description`, no `meta_description`, no
`length`/`width`/`height`, and no `technical_specification`. Proposed build-out per §3/§4
above, once approved:

- **CG6-40**: dimensions 600×650×290mm; spec table with 4×3kW burners/12kW total, gas
  consumption 0.999 kg/h, LPG/NG regulation pressures, ~34kg net weight; prose description
  + Key Features; meta_description.
- **CG7-40**: dimensions 700×777×290mm (mean of reseller-reported depth); spec table with
  4 burners/32.6kW total (per-burner breakdown left blank, see trap #4), 61kg net weight,
  347×310mm grate; prose description + Key Features; meta_description.
- `model_number` left untouched on both (`CG7-40`, `CG6-40`) — no "H" suffix added.
- No image or gallery field changed.
