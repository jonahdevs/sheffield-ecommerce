# Fagor Product Research

Supersedes `old/fagor-research.md`. Sourcing/verification pass, August 2026, run against the
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
