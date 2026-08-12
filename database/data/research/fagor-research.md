# Fagor Product Research

Supersedes the archived research below. Sourcing/verification pass, August 2026, run against the
SAP dossier. Covers both FAGOR SKUs: **CG7-40** (`IMG/HOT/00048`) and **CG6-40**
(`IMG/HOT/00049`), both stored as "4 Burner Table Top".

**No `products.json` or `brands.json` change has been applied.** Findings only. **No
`model_number` change is proposed.**

The previous pass had to work from reseller mirrors for the CG7-40. This pass reached
**Fagor's own 600 and 700 Series brochures and its installation manual U-916501**, which
changes several conclusions.

---

## 1. Brand

**Fagor Industrial**, Spanish manufacturer of commercial kitchen, laundry and refrigeration
equipment, part of **ONNERA Group** within **Mondragón Corporation**. **Renamed "Fagor
Professional" in October 2021** - same company, new domain (`fagorprofessional.com`,
formerly `fagorindustrial.com`).

The current generation is **Kore** (Kore 700 / Kore 900). Our two SKUs belong to the earlier
named **600 Range** and **700 Range** cooking lines. See section 5 - the Kore successor of
the CG7-40 is a **different size** and is already being mis-sold under the old code.

## 2. What separates CG7-40 from CG6-40

They are **two different equipment lines**, not two versions of one machine. From Fagor's own
tables (600 Series brochure p6, 700 Series brochure p6, manual U-916501 Table 1 and the
dimensioned drawing on manual page 2):

| | **CG6-40** (600 Range) | **CG7-40** (700 Range) |
|---|---|---|
| Width | **600 mm** | **700 mm** |
| **Depth** | **650 mm** | **775 mm** |
| Height | 290 mm | 290 mm |
| Burners | 4 x 3 kW | **3 x 5.25 kW + 1 x 6.9 kW** |
| Total gas power | **12.00 kW** | **22.65 kW** |
| Grid | double grid **286 x 534 mm** | **347 x 310 mm** per position |
| Net weight | ~34 kg | **40 kg** |
| Combustion air | - | 22 Nm3/h |
| Consumption | LPG ~0.999 kg/h | G-30 1.89 kg/h, G-31 1.86 kg/h, G-20 2.40 m3/h |
| Ignition | piezoelectric | permanent pilot |

**The depth difference is real - 650 vs 775 mm - but it is not the only difference.** Width
also differs (600 vs 700) and gas power nearly doubles. The 600 Range targets bars,
cafeterias and small establishments; the 700 Range is the full commercial line. Their module
systems, stands (MB6-xx vs MB7-xx) and accessories are not interchangeable, so the two ranges
must never have specs averaged or cross-applied.

**Neither SKU has any electrical connection.** Both are gas-only with mechanical ignition,
so there is no voltage or frequency to reconcile against Kenya's 240 V / 50 Hz. This is a
genuine "not applicable", not a missing figure.

## 3. Our CG7-40 record carries the CG7-40 **H**'s specification

SAP's remark for `IMG/HOT/00048` reads *"Burners: 4 x 6.9 kW ... Total power: 27.6 kW"*.
That is **exactly** the CG7-40 **H**:

| Model | Burners | Total |
|---|---|---|
| **CG7-40** | 3 x 5.25 kW + 1 x 6.9 kW | **22.65 kW** |
| **CG7-40 H** | 4 x 6.9 kW | **27.60 kW** |

Fagor's own installation drawing (manual page 2, staged as
`IMG-HOT-00048__CG7-40-fagor-3.png`) is headed **`CG7-40`** and labels the top view
**one 7000 kcal/h burner + three 5000 kcal/h**. The H has four 7000s. Everything else -
cabinet, fascia, knobs, cast-iron grates, 700 x 775 x 290, 40 kg - is identical.

This also finally explains the "32.6 kW" figure earlier passes found on Australian resellers
and could not make arithmetic sense of. It is the **older kcal-based export price list's**
figure for the H:

| | old EX price list | 2019 brochure / manual |
|---|---|---|
| CG7-40 | 22,000 kcal/h = "25.58 kW" | 22.65 kW |
| CG7-40 H | 28,000 kcal/h = "32.56 kW" | 27.60 kW |

Two catalogue generations using different kcal-to-kW conversions, hence three numbers in
circulation for two machines.

**For decision, not applied:** either correct the record's power to the plain CG7-40's
22.65 kW, or confirm with the business that we actually stock the H. **`model_number` stays
`CG7-40` either way.**

## 4. Our CG6-40 record blends two catalogue generations

SAP's remark says *"Burners: 4 x 3500 kcal/h ... Total power: 14.000 Kcal/h. (16.28 kW)"*
**and** *"Dimensions of the double grill: 285 x 535 mm"*. Those belong to different
generations:

| Source | Burners | Total | Grid |
|---|---|---|---|
| Older EX price list | **4 x 3,500 kcal/h** | **14,000 kcal/h = 16.28 kW** | 400 x 275 mm |
| 2019 brochure + FR catalogue | 4 x 3 kW | **12.00 kW** | double grid **286 x 534 mm** |

SAP carries the **old** power figure alongside the **new** grid figure. Neither is invented -
both are genuine Fagor numbers - but they are not from the same generation. **The current
published power is 12.00 kW.** Dimensions (600 x 650 x 290) are unchanged across both
generations and are safe.

## 5. SAP's dimension column order for FAGOR is Depth / Width / Height

| SKU | SAP dims as labelled W/D/H | Fagor's W x D x H | Verdict |
|---|---|---|---|
| IMG/HOT/00048 CG7-40 | 775 / 700 / 290 | **700 x 775 x 290** | first two transposed |
| IMG/HOT/00049 CG6-40 | 675 / 600 / 290 | **600 x 650 x 290** | transposed, and the depth **value** is wrong by 25 mm |

⚠ **Our two stored records are not consistent with each other.** `CG7-40` is stored
700/775/290, matching Fagor's width-first order exactly. `CG6-40` is stored 650/600/290,
which is the **transpose** of Fagor's 600 x 650 x 290. The CG6-40 record is the axis-swapped
one.

The manual's Table 1 shows CG7-40 height as **300** where both the brochure and the
dimensioned drawing say **290**. The drawing is dimensioned art and wins; 300 is a rounded
nominal. Our stored 290 is right.

## 6. ⚠ Trap: the Kore successor `C-G740` is a different size and is sold under the old name

The Spanish reseller `equipamientostapia.es` publishes a page titled "Cocina sobremesa
**CG7-40** FAGOR" but attaches Fagor's own spec sheet for **C-G740** - the Kore-generation
successor at **800 x 729.5 x 299 mm**, not 700 x 775 x 290 - and a render of a visibly
different machine (one-piece top, black knob surrounds).

Both files are staged in `_brand-reference/` with `NOT-CG7-40` in the filename. **Do not
import C-G740 dimensions or imagery into `IMG/HOT/00048`.**

## 7. Where to look

| Resource | URL |
|---|---|
| 600 Series brochure EN (live) | https://www.fagorprofessional.com/documents/20127/759111/12158849-2019-1_600+SERIES+BROCHURE_EN.pdf/828c043c-7d96-6fb8-1e42-6d6ef79d7cc3 |
| 700 Series brochure EN (Internet Archive only) | https://web.archive.org/web/2020id_/http://www.fagorindustrial.com/uploads/productos/archivos/gamas/en/12158837-2019-1_700_SERIES_BROCHURE_EN.pdf |
| Installation manual U-916501 (CG7 / CGE7, 5 languages) | https://www.cateringinventar.com/?file-download=User-Manual-CG_CGE_700.pdf |
| French 600 catalogue with Fagor article codes | https://www.multidis-sn.com/IMG/pdf/fagor_600_compressed.pdf |
| Spanish 600 catalogue 2019 | https://www.garcia-mh.com/uploads/fagor_gama600_19.pdf |
| Legacy EX price catalogue, both ranges, kcal-based | http://www.brillcatering.com/download/Fagor.pdf |
| 2023 Fagor catalogue EN (Kore era - contains no CG6/CG7 codes) | https://www.fagorprofessional.com/documents/20127/545378/12158716_2023_FAGOR_CATALOGUE_EN.pdf/4ff698e6-40c0-b095-81a3-678c7f4cb7d5 |

### Traps

1. **The 600 brochure's bare `.pdf` path 404s.** The full path including the UUID suffix is
   required. Same for the 2023 catalogue.
2. **The 700 Series EN brochure is no longer published** anywhere on `fagorprofessional.com`.
   Only the Internet Archive has it, and only under the *old* `fagorindustrial.com` host - so
   run Wayback CDX against **both** domains.
3. **The installation manual is not on Fagor's site at all.** It was found on a Latvian
   distributor behind a `?file-download=` query string. It is the only document giving
   per-model burner counts, gas consumption and combustion-air figures.
4. **`gastroparts.com` returns 403** to both a plain fetcher and WebFetch, on the page and on
   the PDF. It holds CG6-40 and CG7-40 technical drawings that could not be retrieved.
   `archiexpo.com` and `pdf.archiexpo.com` also 403.
5. **The "H" suffix is a real Fagor model designator, not a distributor artefact.** The
   earlier pass concluded the opposite. Fagor's own tables list CG7-20/20 H, CG7-40/40 H,
   CG7-41/41 H, CG7-60/60 H, CG7-61/61 H, CGE7-41/41 H - the H is the all-large-burner
   variant. The **600 Range has no H variants**, which is why the earlier pass saw none for
   CG6-40 and generalised wrongly.
6. **Padded canvases inflate apparent resolution.** pulidohosteleria serves the CG6-40 as an
   800 x 800 `thickbox_default` that would pass a naive short-edge check; it is a 735 x 590
   original letterboxed onto white. Measure the content bounding box, not the canvas.

## 8. Images

Folder: `Desktop\ecommerce\products resorce final\fagor\`. 6 images + 4 spec PDFs + 3
reference files. **Every image was rendered before acceptance; none is AI-generated.**

| SKU | File | Px | Short edge | Source |
|---|---|---|---|---|
| 00048 | `-fagor-3.png` | 2488 x 1105 | 1105 ✓ | manual U-916501 p2, rendered at 350 dpi and cropped to the CG7-40 block |
| 00048 | `-VARIANT-CG7-40H-1.jpg` | 1100 x 1100 | 1100 ✓ | https://discountfoodequipment.com.au/wp-content/uploads/2026/01/cg7-40h_1.jpg |
| 00048 | `-VARIANT-CG7-40H-2.jpg` | 1100 x 1100 | 1100 ✓ | https://leadingcatering.com.au/media/catalog/product/c/g/cg7-40h.jpg |
| 00049 | `-fagor-1.jpg` | 735 x 590 | **590 ✗** | https://pulidohosteleria.com/tienda/72/cocina-a-gas-fagor-cg6-40.jpg |
| 00049 | `-fagor-2.jpg` | 600 x 511 | **511 ✗** | https://www.kitchen-arena.com.my/media/catalog/product/f/a/fagor-600-range-gas-ranges-2.jpg |
| 00049 | `-fagor-3.jpg` | 512 x 384 | **384 ✗** | https://www.equipamientostapia.es/426/cocina-a-gas-cg6-40-fagor.jpg |

**The CG7-40 photographs are of the CG7-40 H** and are tokenised `VARIANT-CG7-40H` with
`code_proven: false`. Zooming the cooktop shows four identically-sized burner crowns; the
plain CG7-40 would show one larger crown among three smaller. The cabinet is otherwise
identical, so they remain usable - but the filename must not assert the plain code, and the
manufacturer drawing (`-fagor-3.png`) is the asset that actually carries the `CG7-40` label.

**CG6-40 has a genuine image ceiling of 735 x 590 - below our 800 px floor.** Checked and
beaten: pulidohosteleria, kitchen-arena, tientien (same file as kitchen-arena),
equipamientostapia, friomoron (500 x 500), tumaquinariadehosteleria (600 x 600), fnbstores
(no image served), catering-hotelsupplies (JS-rendered), and four Fagor PDFs - inside which
the CG6-40 appears only in a three-model family render measuring about 360 x 210 px at
300 dpi. This is a real ceiling for a legacy model, not a fetching failure.

**Perceptual hashing** (16 x 16 ahash then 256 x 256 greyscale RMS): no two staged files are
the same photo. The two CG7-40 H files are different framings (hamming 42). No
`REPRESENTATIVE-RANGE` file was needed - the `VARIANT-CG7-40H` token is the more precise
statement here, since these are a named sibling model's photos rather than range-generic art.

**`SHARED-DOC`** applies to all four spec PDFs: Fagor publishes range brochures and
multi-model manuals, never single-model datasheets for this generation.

## 9. Product reference

| SKU | Model | Range | Primary source | Confidence |
|---|---|---|---|---|
| IMG/HOT/00048 | CG7-40 | 700 Range | Fagor 700 Series brochure + manual U-916501 + its own dimensioned drawing | **High** on specs; **the stored power figures belong to the H** |
| IMG/HOT/00049 | CG6-40 | 600 Range | Fagor 600 Series brochure + FR 600 catalogue | **High** on specs; **stored power is the superseded generation's** |

Supporting sources:

- https://www.fagorprofessional.com/en/kitchen-appliances/commercial-kitchen/kore
- https://discountfoodequipment.com.au/product/fagor-700-series-natural-gas-4-burner-ss-boiling-top-cg7-40h/
- https://leadingcatering.com.au/fagor-benchtop-natural-gas-4-burners-gas-cooktop-700mm-width-cg7-40h.html
- https://www.foodequipment.com.au/fagor-700-series-natural-gas-4-burner-ss-boiling-top-cg7-40h.html
- https://pulidohosteleria.com/tienda/es/gama-600/49-cocina-a-gas-fagor-cg6-40.html
- https://www.kitchen-arena.com.my/fagor-gas-range-4-open-burner-cg6-40.html
- https://www.tientien.com.my/products/fagor-gas-range-4-open-burner-cg6-40
- https://www.equipamientostapia.es/tienda-online/3164-cocina-a-gas-cg6-40-fagor.html
- https://www.equipamientostapia.es/cocinas-industriales-serie-700/3172-cocina-sobremesa-cg7-40-fagor.html (mislabelled - serves the Kore C-G740, section 6)

---

## Archived brand research

> Merged in from the former `research/old/` folder on 2026-08-12, when the two folders were
> consolidated. This is the earlier **specs and codes** pass; everything above it
> is the later **sourcing and provenance** pass. The text is unchanged apart from
> heading levels, which were demoted one step to keep a single outline.

## Fagor Product Research

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

### 1. Brand identification

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

### 2. Where to look — and the traps

| Resource | URL |
|---|---|
| Official site (current) | fagorprofessional.com (rebrand of fagorindustrial.com, Oct 2021) |
| Official 600 Range brochure (PDF, has full spec table) | `fagorprofessional.com/documents/20127/759111/12158849-2019-1_600+SERIES+BROCHURE_EN.pdf` |
| Kore microsite (current gen, no CG6/CG7 codes) | `fagorprofessional.com/en/kitchen-appliances/commercial-kitchen/kore` |
| Spec mirrors (700 Range, Australia — one shared distributor feed) | foodequipment.com.au, restaurantequipment.com.au, commercialkitchenappliances.com.au, veysel.com.au, leadingcatering.com.au, nationalkitchenequipment.com.au, kwcommercial.com.au — **all return byte-identical copy**, treat as one source, not independent confirmation |
| CG6-40 (Malaysia / Spain resellers) | kitchen-arena.com.my, tientien.com.my, pulidohosteleria.com, provihostel.com |
| Manufacturer catalogs (image + PDF host) | archiexpo.com / pdf.archiexpo.com (blocks automated fetches with 403 — use only via search-engine synthesis, not direct fetch) |

#### Traps

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

### 3. Product reference

| SKU | Catalogue name (now) | Model | Range | Official page/source | Confidence |
|---|---|---|---|---|---|
| IMG/HOT/00048 | 4 Burner Table Top Fagor CG7-40 | CG7-40 | 700 Range | Reseller mirrors of Fagor's official 700 Range spec sheet (archiexpo-indexed) | Medium — consistent across ≥7 independent-looking domains, but likely one shared distributor feed; not read from an original Fagor PDF this pass |
| IMG/HOT/00049 | 4 Burner Table Top Fagor CG6-40 | CG6-40 | 600 Range | Official Fagor 600 Range brochure PDF (`fagorprofessional.com`), directly read and cross-checked against 4 independent resellers | **High** — read the primary-source PDF in full |

#### Specs found

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

### 4. Not published — left blank rather than invented

- **CG7-40**: per-burner power breakdown (front vs rear), gas consumption in kg/h, exact
  LPG/NG regulation pressures, gross weight, and packed/carton dimensions.
- **CG6-40**: nothing material missing — the official brochure table plus reseller weight
  figures cover the field set we use.
- Neither SKU's ignition voltage/electrical requirement (if any, e.g. for a spark
  ignition variant) was found — both appear to be pilot-flame ignition with no electrical
  connection required, consistent with "permanent pilot flame" copy in the brochure.

---

### 5. Image sourcing — for manual review

No image field was changed this pass. Both existing catalogue photos are the same
studio-render style (cast-iron burners, recessed control knobs, "FAGOR" badge on the
right end panel) and are visually almost indistinguishable at this crop/angle — plausible
since the 600 and 700 Range share identical design language just at different scale, but
worth a manual side-by-side check against the sources below to confirm neither file is
misassigned to the wrong SKU.

#### 5.1 CG6-40 — IMG/HOT/00049

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| Kitchen Arena (Malaysia) | [fagor-gas-range-4-open-burner-cg6-40](https://www.kitchen-arena.com.my/fagor-gas-range-4-open-burner-cg6-40.html) | <https://www.kitchen-arena.com.my/media/catalog/product/cache/f603baa9e6784a7839c7e4f32d8fcf28/f/a/fagor-600-range-gas-ranges-2.jpg> | 200, jpeg, 35 KB | Clean studio shot, exact 600-Range 4-burner model. |
| Official brochure (composite) | [600 Series Brochure PDF](https://www.fagorprofessional.com/documents/20127/759111/12158849-2019-1_600+SERIES+BROCHURE_EN.pdf) p.5 | — (embedded in PDF, not a standalone URL) | Read directly | Shows the CG6-40 as the leftmost unit in a full assembled 600 Range line; good for verifying knob layout/branding, not a standalone product shot. |

#### 5.2 CG7-40 — IMG/HOT/00048

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| Leading Catering (Australia) | [cg7-40h benchtop cooktop](https://leadingcatering.com.au/fagor-benchtop-natural-gas-4-burners-gas-cooktop-700mm-width-cg7-40h.html) | <https://leadingcatering.com.au/media/catalog/product/c/g/cg7-40h.jpg?width=600&height=600&store=default&image-type=image> | 200, jpeg | Clean studio shot on white, exact 700-Range 4-burner model. |
| Hospitality Equipment Online (Australia) | [fagor-cg7-40h](https://hospitalityequipmentonline.com.au/fagor-cg7-40h-700-series-natural-gas-4-burner-ss-boiling-top-with-cast-iron-trivets-and-burners-700-x-780-x-290mm) | (page returned 503 this pass — retry) | 503 | Page title alone confirms dimensions 700×780×290mm independently of the other resellers. |

**Dead/blocked:** `manualzz.com` CG7-20 manual (403); `ipelican.com` (domain expired,
redirects to a GoDaddy parking page); `pdf.archiexpo.com` and `archiexpo.com` product
pages (403 to automated fetch); `hospitalityequipmentonline.com.au` (503 this pass, likely
transient).

---

### 6. Summary of `products.json` changes proposed (not yet applied)

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
