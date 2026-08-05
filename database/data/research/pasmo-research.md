# Pasmo Product Research

Supersedes `old/pasmo-research.md` (July 2026), which predates the SAP export. Covers all 3
PASMO SKUs - commercial soft-serve ice cream machines.

Staging folder: `Desktop\ecommerce\products resorce final\pasmo\`
Nothing in `products.json`, `brands.json` or `storage/` was changed by this pass.

---

## 1. Brand

**Taizhou Pasmo Food Technology Co., Ltd.**, Huangyan, Taizhou, Zhejiang, China. PASMO is the
manufacturer's own brand. **PASMO America** is the US arm and publishes the better-structured
per-model datasheets.

https://www.pasmochina.com
https://pasmousa.com

---

## 2. Body styles - verified by eye, all three correct

| SKU | Code | Photograph shows | Verdict |
|---|---|---|---|
| IMG/ICE/00017 | S110F | one hopper lid, ONE dispensing handle, compact cabinet on short feet | **table top** |
| IMG/ICE/00029 | S230F | TWO hopper lids, THREE handles (2 + twist), counter cabinet on short feet, drip tray | **table top** |
| IMG/ICE/00018 | S520F | full-height cabinet, separate lower machine compartment, FOUR CASTORS | **free standing** |

Corroborated in writing by Pasmo's own US datasheets, which title themselves "S110F Table Top
Soft Serve Freezer", "S230F Table Top Soft Serve Freezer" and "S520F **Floor Standing** Soft
Serve Freezer".

⚠ **Pasmo's own Chinese-site S520F datasheet contradicts this** - see section 5.

---

## 3. SAP dimensions: the column order is `depth, width, height`

Established from SAP's own rows against the manufacturer's dimensioned elevations:

| SKU | SAP length/width/height | Manufacturer width/depth/height | Verdict |
|---|---|---|---|
| IMG/ICE/00017 S110F | 785 / 385 / 730 | 385 / **720** / 731 | order right, depth value 65 mm too large |
| IMG/ICE/00029 S230F | 770 / 520 / 969 | 520 / 770 / 969 | **exact** |
| IMG/ICE/00018 S520F | 855 / 636 / 1517 | 636 / 855 / 1517 | **exact** |

Proof for S520F is the manufacturer's own drawing, which labels 636 across the front elevation,
855 down the side elevation and 1462 mm body height (1517 including castors):
https://www.pasmochina.com/uploads/image/20220416/11/f116edd375c177ba426d099a028926b6.png

Proof for S110F is the US datasheet's `Specifications 15.16" | 28.35" | 28.80"` =
385 | 720 | 731 mm, which is explicitly width | depth | height.

⚠⚠ **This order is the REVERSE of BREMA's**, which was verified in the same session as
`width, depth, height` against Brema's own datasheets. The per-brand column-order variation is
real. Reading Pasmo with Brema's order would make the S230F 770 mm wide and 520 mm deep - a
250 mm error in both directions on a machine sold on fitting a countertop.

### 3.1 One bad SAP value

S110F depth: SAP 785, manufacturer 720. Width and height match to the millimetre, so this is a
single wrong value rather than a transposition, and it matches no carton figure either.
**`products.json` already carries 720, so our stored record is right and SAP is wrong here.**

### 3.2 ⚠ Our stored length/width are transposed against the catalogue convention

The catalogue convention is `length` = width, `width` = depth (confirmed on Brema in the same
session). All three Pasmo records instead mirror SAP's depth-first order:

| SKU | stored length / width | per convention |
|---|---|---|
| S110F | 720 / 385 | 385 / 720 |
| S230F | 770 / 520 | 520 / 770 |
| S520F | 855 / 636 | 636 / 855 |

Values are right; the two fields are swapped. Flagged, not applied.

---

## 4. SAP remark errors

| SKU | SAP remark | Manufacturer |
|---|---|---|
| S110F | "No. of hoppers: 1 - Hopper Capacity: **6.5 Litres x 2**" | **9.5 L x 1** |
| S110F | "Power: **20V**/50Hz" | 220 V / 50 Hz (typo) |
| S230F | Compressor "**EMBRACO/TECUMSEH**" | **Aspera** |
| S520F | Compressor "**EMBRACO/TECUMSEH**" | **Aspera** |
| S520F | Motor "**550 W x2**" | **750 W x2** |
| S520F | Production "**50** litres/hr" | **55 L/h** |
| S520F | "N.W. 226 / G.W. 241 kg" | **230 / 250 kg** |

⚠ The S110F hopper line is **self-contradictory within its own row** - one hopper, then a "x 2"
capacity. That is the tell: it is a fragment of a two-hopper row pasted onto the single-hopper
machine. The correct figure is 9.5 L x 1, which also matches the old research's finding that
the stored 6.5 L was wrong.

S110F net/gross (90 / 103 kg) is the one place SAP matches the datasheet exactly.

---

## 5. ⚠ Two defective manufacturer documents

**(a) The S520F datasheet calls itself a "Table Top".** Its title and `TYPE` field both read
table top, on a document whose own photo shows a castored floor machine and whose own drawing
gives 1462 mm of body height. Extracting the PDF's embedded objects with PyMuPDF shows why: the
page is a **blank S230F table-top template layer** with S520F values overprinted, and the
template's own wording was never replaced (its model-number field still reads a bare "S").
Pasmo's US sheet says Floor Standing.

https://www.pasmochina.com/uploads/file/20220416/11/6a921d2212b83dc362048759569924b9.pdf
https://pasmousa.com/wp-content/uploads/S520F_PASMO_Spec_Sheet.pdf

**(b) The S110F "datasheet" link serves a corrupt file.** The PDF linked from the S110F product
page is a 7-page dump of the site CMS's own template-syntax documentation, not a spec sheet.
The US sheet was used instead.

https://www.pasmochina.com/uploads/file/20220330/15/5aedbe82f1549c52ba7062536c9d7c39.pdf

Useful side-effect: that corrupt file documents the CMS image resizer, whose largest allowed
size is **800x800** - which explains why pasmochina.com's galleries are capped so low.

---

## 6. Official specification

| | S110F | S230F | S520F |
|---|---|---|---|
| Type | table top | table top | **floor standing** |
| Production | 20 L/h | 30 L/h | 55 L/h |
| Flavours | 1 | 3 (2 + twist) | 3 (2 + twist) |
| Hoppers | 1 x 9.5 L | 2 x 9.5 L | 2 x 12.5 L |
| Cylinder | 1.6 L | 1.6 L x 2 | 2 L x 2 |
| W x D x H mm | 385 x 720 x 731 | 520 x 770 x 969 | 636 x 855 x 1517 |
| Carton mm | 490 x 830 x 835 | 880 x 650 x 1100 | 760 x 980 x 1640 |
| Net / gross kg | 90 / 103 | 168 / 183 | 230 / 250 |
| Power | 1.5 kW | 3 kW | 3.2 kW |
| Motors | 1 x 550 W | 2 x 550 W | 2 x 750 W |
| Compressors | 1 x Aspera 3753 BTU/h | 2 x Aspera 3753 BTU/h | 2 x Aspera 3753 BTU/h |
| Refrigerant | R404A, 500 g | R404A, 500 g | R404A, 700 g |
| Cooling | air / water | air / water | air / water |
| Beater | 304 stainless | stainless | stainless |
| Electrical (our market) | 220 V 50 Hz 1-ph (S110FA2) | 220 V/50 Hz air: 30 A fuse, 13 A, 3 kW | 220 V/50 Hz: 35 A fuse, 14 A, 3.2 kW; **380 V 3-ph also offered** |

⚠ **The S520F is offered in 220 V single-phase and 380 V three-phase.** Confirm which build is
ordered - the datasheet lists both.

⚠ **All three run R404A**, a high-GWP HFC. No hydrocarbon variant is published for these models.

Sources:

https://www.pasmochina.com/product/473/474/476/
https://www.pasmochina.com/product/473/515/519/
https://www.pasmochina.com/product/473/617/780/
https://pasmousa.com/wp-content/uploads/S110F_PASMO_Spec_Sheet.pdf
https://pasmousa.com/wp-content/uploads/S230F_PASMO_Spec_Sheet.pdf
https://pasmousa.com/wp-content/uploads/S520F_PASMO_Spec_Sheet.pdf
https://www.pasmochina.com/uploads/file/20220416/10/16367f140f5c85bc097d63fc7c72957f.pdf
https://pasmousa.com/wp-content/uploads/Operating-Manual-F-Series-Equipment.pdf
https://preferredsource.com/wp-content/uploads/PASMO-America-Catalog-English-Digital.pdf

---

## 7. Imagery

| SKU | Files >= 800 px | Best px | Source |
|---|---|---|---|
| IMG/ICE/00017 S110F | 4 | 1000x1524 | https://www.pasmochina.com/product/473/474/476/ + https://pasmousa.com/machine/s110f-table-top-soft-serve-freezer/ |
| IMG/ICE/00029 S230F | 2 (one viewpoint) | 1000x1000 | https://kitchenrestock.com/products/pasmo-s230fap2-soft-serve-machine-countertop-pressurized |
| IMG/ICE/00018 S520F | 3 (2 photos + 1 drawing) | 1227x864 drawing, 1000x1000 photos | https://kitchenrestock.com/products/pasmo-s520fa2-soft-serve-machine-floor-model-gravity-fed + https://www.pasmochina.com/product/473/617/780/ |

### 7.1 Proven ceilings

| Source | Ceiling |
|---|---|
| pasmochina.com | ~1000 px long edge; most gallery files 500x500 (CMS resizer tops out at 800x800) |
| pasmousa.com | 1000 px long edge (WordPress originals) |
| kitchenrestock.com | 1000x1000 (Shopify `/products/<handle>.json` reports true source dims) |
| chefsdeal.com | 789x1000 |
| Datasheet PDFs | embedded objects are whole-page 2521x3584 raster layers, not separable photos |

**No manufacturer-hosted image clears the 800 px floor for S230F or S520F.** Both depend on a
US reseller's Shopify assets. Near-misses are staged in `_brand-reference/` rather than
upscaled - pasmousa's S230F is 796x1000, four pixels short.

### 7.2 Shared and duplicated imagery

- **S230F -1 and -2 are the same photograph with different badging** (ahash distance 0, RMS
  4.20): one fascia reads `PASMO`, the other `PASMO AMERICA`. Kept, but -2 is not a second view.
- **S520F -1 and -2 are published identically on both the gravity (S520FA2) and pressurized
  (S520F-AP2) listings** - shared across feed variants of the same base model, so
  `code_proven: false`. The air pump is internal and cannot be seen in a photograph.
- **Rejected:** kitchenrestock's `pasmo-s230f-tla2-...` listing shows a visibly different
  machine (transparent cylinder tubes, wooden-handled taps) and its own title miscalls the
  S230F "Single Flavor". Staged as a `REJECTED-` file in `_brand-reference/`.

### 7.3 Nothing AI-generated

`_ai-generated/` is empty. Accepted files are conventional studio photography - real specular
highlights on brushed stainless, physically consistent louvre slats, correctly-legible fascia
text. Every image was opened.

---

## 8. Product reference

| SKU | model_number | Official page | Datasheet | Confidence |
|---|---|---|---|---|
| IMG/ICE/00017 | S110F | https://www.pasmochina.com/product/473/474/476/ | https://pasmousa.com/wp-content/uploads/S110F_PASMO_Spec_Sheet.pdf | High |
| IMG/ICE/00029 | S230F | https://www.pasmochina.com/product/473/515/519/ | https://www.pasmochina.com/uploads/file/20220416/10/16367f140f5c85bc097d63fc7c72957f.pdf | High |
| IMG/ICE/00018 | S520F | https://www.pasmochina.com/product/473/617/780/ | https://www.pasmochina.com/uploads/file/20220416/11/6a921d2212b83dc362048759569924b9.pdf | High on spec, see section 5 on its "table top" error |

All three model codes verified genuine on the manufacturer's own site. No `model_number` change
proposed.

---

## 9. Recommended changes (nothing applied)

1. 🔴 **S110F hopper: 9.5 L x 1**, not SAP's contradictory "6.5 L x 2" - section 4.
2. 🟠 **Compressor brand on S230F and S520F: Aspera**, not "Embraco/Tecumseh" - section 4.
   (Aspera is an Embraco marque, so "Embraco" alone is defensible; "Tecumseh" is not supported.)
3. 🟠 **S520F**: motors 750 W x2 (not 550), production 55 L/h (not 50), net/gross 230/250 kg
   (not 226/241) - section 4.
4. 🟠 **Length/width transposition on all three** against the catalogue convention - section 3.2.
   Needs a decision on whether to normalise Pasmo to the convention or leave it mirroring SAP.
5. 🟡 Add refrigerant charges (500 g / 500 g / 700 g), carton sizes and the S520F's 380 V
   three-phase option.
6. ⚪ No `model_number` change. No `brands.json` change needed.
