# KEF - SAP-led research pass (2026-08-03)

6 SKUs, all 6 covered. 22 images plus a 6-page spec PDF staged to
`Desktop\ecommerce\products resorce final\kef\`.

This supersedes the KEF sections (§4, §6.3, §7) of the archived
`research/old/rational-rancilio-kef-gaps-research.md`. Two of that pass's open items are now
closed and one of its conclusions is overturned - see §7.

The decisive source for this brand is not the website. It is KEF's **195-page e-catalogue**, a
125 MB PDF linked from https://www.kef.com.tr/e-katalog via Google Drive. It carries priced
spec tables for the entire range including accessories, its text layer is intact, and on one SKU
it contradicts KEF's own product page - in SAP's favour. KEF publishes no per-model datasheets;
this catalogue is the only spec document that exists for the brand.

Primary sources used throughout:

https://www.kef.com.tr
https://www.kef.com.tr/filtre-kahve-makineleri
https://www.kef.com.tr/e-katalog
https://drive.google.com/file/d/1vVfBT6MO2i6RL2_EKBjapo2LxULkfAt0/view
https://www.coffeetoys.com.tr/endustriyel-filtre-kahve-makineleri
https://www.rawpluscoffee.com/collections/kef-batch-brewers

---

## 1. Identity, and the `brands.json` URL

KEF is **KEF Endüstriyel**, Istanbul - "Kitchen Equipment Factory", the strapline printed on every
catalogue page. The correct site is **https://www.kef.com.tr** (English mirror at
https://www.kef.com.tr/en).

`brands.json` points KEF at `kef-factory.com`, which sells no coffee equipment. Confirmed wrong
again this pass. Not edited - out of scope.

**https://www.coffeetoys.com.tr is a first-party KEF property, not a reseller.** The COFFEE TOYS
logo is printed in the header of catalogue page 19. It occasionally carries assets kef.com.tr does
not - the only Filtronist FLS-6 page found anywhere is there.

## 2. Code grammar: the line name IS the prefix

Confirmed against KEF's own price tables (catalogue pages 9, 11, 12, 13):

| Line | Prefix | Codes |
|---|---|---|
| Filtro | `FLT` | FLT120, FLT120-2, FLT120-T, FLT120-AP, FLT250, + G1/G2/G3 custom wraps |
| Filtronic | `FLC` | FLC 120, FLC 120-2, FLC 120-T, FLC 120-AP, FLC 250 |
| Filtronist | `FLS` | FLS-2.2, FLS-2.5(+SHORT), FLS-3.8(+SHORT), FLS-5.7(+SHORT), FLS-6(+SHORT), FLS-8x2 |
| Accessories | - | CMP-1, T1-9, T2-2, T2-5, T6-0, T3-8/T5-7/T7-6, TS3-8/TS5-7/TS7-6, S1, S2, FK925, FK1125, FK1133, FK1136 |

**`FTL` appears nowhere** - not in 195 catalogue pages, not on kef.com.tr, not on
coffeetoys.com.tr, not at any of eight Turkish resellers checked.

## 3. Axis convention - established, not assumed

KEF prints its own dimension triple as `BOYUT / dimension` in every price table, so this can be
settled directly rather than inferred.

| SKU | SAP (length/width/height) | KEF catalogue | |
|---|---|---|---|
| IMG/COF/00103 FLT120 | 190 / 370 / 440 | 190×370×440 | exact |
| IMG/COF/00104 FLT120-2 | 190 / 370 / 502 | 190×370×502 (p9) | exact |
| IMG/COF/00105 FLC 250 | 205 / 400 / 720 | 205×400×720 | exact |

**SAP's raw triple reproduces KEF's printed triple verbatim, in order.** KEF's printed order is
**Width × Depth × Height** - confirmable by eye from the photographs, since the FLT120 is a
narrow-fronted, deep countertop machine, ~190 mm across the front and ~370 mm front to back.

**So for this brand SAP's field *labels* are wrong while its values are right: SAP `length` holds
the WIDTH and SAP `width` holds the DEPTH.** Anything that reads `sap.width` as the width - the
dossier's own "W/D/H 370/190/440" header line does - reports the machine width and depth inverted.
`products.json` stores the same raw triple and inherits the same mislabelling.

Three exact matches out of three is unusually good. **On this brand SAP's dimension values are
the most reliable source available** - see §5, where SAP beats KEF's own website.

## 4. The headline defect: `FTL120` is a transposition, and the two records are each half right

### IMG/COF/00103 - stored `FTL120 BLACK`, "Coffee Brewer with 1 Decanter"

Real product: **KEF Filtro `FLT120`, black**. 190×370×440 mm, 5,2 kg, 2,4 kW, 220 V-1N,
144 cups/hour, 1.8 L glass jug, 6-minute brew, 395 EUR.

SAP holds 190/370/440 and 5.2 kg - every field exact. `FTL120` is a straight letter transposition
of `FLT120` and nothing else about the record is wrong.

"1 Decanter" is right, and is KEF's own distinction rather than ours: the chassis carries *two*
warmer plates but ships with *one* glass jug as standard - "Opsiyonel olarak 1 veya 2 cam potlu /
Optional 1 or 2 glass jugs". SAP's remark says the same: "Self regulated 2 hot plates - Standart
one GLASS JUG".

### IMG/COF/00104 - stored `FLT120 INOX`, named "Coffee Brewer with 2 Decanter FTL120-2 Inox"

Real product: **KEF Filtro `FLT120-2`, inox** - a separate catalogue line item at a different price
(420 EUR vs 395 EUR), not a finish variant of the FLT120.

The `model_number` and the product name each preserve half the truth and lose the other half:

| Field | Value | Right | Wrong |
|---|---|---|---|
| `model_number` | `FLT120 INOX` | letters in order | **missing the `-2`** - names the 1-jug machine |
| product name | `FTL120-2 INOX` | has the `-2` | transposed to `FTL` |
| SAP description | `FTL120-2 INOX` | has the `-2` | transposed to `FTL` |

The correct code is **`FLT120-2 INOX`** - the only string consistent with the description, the SAP
remark, the SAP dimensions and the photographs. Three independent confirmations it is the `-2`:

1. SAP's own **remark** says "Weight: **6 kg**", which is FLT120-2's catalogue weight (FLT120 is
   5,2 kg). SAP's numeric weight *field* says 5.2, contradicting its own remark. The remark wins.
2. SAP's **height is 502**. The catalogue prints FLT120-2 as 190×370×**502** and FLT120 as
   190×370×**440**. Only the `-2` is 502 mm.
3. Description and name both say two decanters.

## 5. ⚠ KEF's website contradicts KEF's catalogue, and SAP is the one that is right

https://www.kef.com.tr/kef-filtro-flt120-2-filtre-kahve-makinesi states **190×370×440 mm** for the
FLT120-2 - copy-pasted from the FLT120 page. Catalogue **page 18** repeats the same 440 for the
G1/G2/G3 wrap editions. Only catalogue **page 9** prints 502.

**502 is correct and SAP already holds it.** The FLT120-2 stacks a second warmer plate and jug on
top of the machine, so it is necessarily taller than the FLT120; the two cannot both be 440 mm.

Do not "correct" 502 down to 440 on the strength of the website or of catalogue page 18. This is the
one place in this pass where a web source would have degraded good SAP data.

## 6. Accessories: `CMP-2` and `FK925` settled from catalogue page 19

Catalogue page 19 is the accessories price list. It contains both of our accessory SKUs.

### IMS/FIT/00992 `FK925` - confirmed exactly, no change

> `FK925` — 1000x 90/250 Filtre Kağıdı / **Filter paper** — 60 EUR

Word-for-word match to our "Coffee Filter Papers 90/250", code included. `90/250` is the paper size
in mm; `1000x` is the pack quantity, which explains SAP's stock figure of 10,137. Siblings:
FK1125 (110/250), FK1133 (110/330), FK1136 (110/360).

Caveat is photographic only: KEF has **one** filter-paper stock shot and reuses it across all four
FK codes and all eight machine pages, so no image can distinguish FK925 from its siblings.

### IMG/COF/00101 `CMP-2` - the product is KEF, the code is not

> `CMP-1` — 1,8 lt cam pot / **1,8 lt glass jug** — 40 EUR

That is our record, "Decanter 1.8 Litres KEF", word for word - and matches the SAP remark
("Capacity: 1.8 litres - Glass Decanter"). **`CMP-2` does not exist in KEF's range.** There is
exactly one glass-jug accessory code and it is `CMP-1`.

`CMP` decodes cleanly inside KEF's own vocabulary: **c**a**m** **p**ot is literally the Turkish
term KEF uses. Note that KEF does run `-1`/`-2` pairs on the same page (`S1` = 1 Jug Warmer,
`S2` = 2 Jug Warmer), so `CMP-2` looks plausible - but nothing bears it.

**On the Crem `CQM2` resemblance.** Crem's IMG/COF/00006 `CQM2` is a *coffee brewer with 2
decanters* - a machine. Our IMG/COF/00101 is a *decanter* - a spare part. Different classes of
object, and our description matches KEF `CMP-1` exactly rather than `CQM2`. The evidence points to
a one-character slip from `CMP-1`, not a brand crossover. **No brand change proposed** - this reads
as a KEF accessory and the brand decision is the user's.

## 7. IMG/COF/00138 `FLS6X2` - the `x2` grammar is real (overturns the old research)

The archived pass concluded that "KEF publishes no two-thermos brewer" and left this SKU
unidentified. That conclusion was reached from the website alone. **The catalogue overturns it.**

Catalogue page 13 lists **`FLS-8x2`** — 470×620×940 mm, 45 kg, 3 kW, 6.000 EUR — alongside the
single-tower FLS-8. The 470 mm width is roughly double a single Filtronist's 250 mm, i.e. `x2` is
**two brewing towers side by side**, which is precisely SAP's "COFFEE BREWER WITH DOUBLE
CATER(THERMOSES)". **`FLS-6`** is also a real catalogued code (250×590×991 mm, 24 kg, 3.450 EUR).

So `FLS6X2` is well-formed KEF grammar and a twin-thermos Filtronist certainly exists. What is
**not** established is `FLS-6x2` specifically - only the 8-litre twin is printed in this edition.
The SKU is either a build-to-order twin FLS-6 or a garbling of `FLS-8x2`.

**SAP is actively misleading here.** Its dimensions for this SKU are 190/370/502 with 5.2 kg -
**FLT120-2's numbers, copied verbatim** from IMG/COF/00104, identical in all four fields. No
Filtronist is near that size; the smallest, FLS-2.2, is 220×477×650 at 17 kg. Treat this row's
dimensions and weight as **absent, not merely wrong**.

No photograph of any twin/x2 Filtronist exists on kef.com.tr, coffeetoys.com.tr, or in all 195
catalogue pages. Staged imagery is REPRESENTATIVE-RANGE single-tower Filtronist.

**Keep this SKU `draft`.** Ask the supplier whether it is `FLS-6x2` or `FLS-8x2` - the answer
changes dimensions, weight and price bracket completely.

## 8. IMG/COF/00105 `FLC 250` - code exact, one weight disagreement

Catalogue page 11: FLC 250, 205×400×720 mm, 2,2 kW, 2.5 L thermal container, 8-minute brew,
1.500 EUR. SAP holds 205/400/720 and 2.2 kW, and its remark ("Include one Thermanl Container 2,5 LT
Capacity... Fast Brewing time arround 8 min") matches KEF's spec line exactly.

**Weight disagrees:** SAP says 6.5 kg in both the field and the remark; the catalogue says
**7,5 kg**. 6,5 kg is `FLT250`'s weight - the same cross-row contamination pattern as §9.

## 9. Where SAP fails on this brand - all cross-row contamination

Contrary to the catalogue-wide prior, SAP's *dimension values* are excellent here (three exact
manufacturer matches, and it beat KEF's own website on 00104). Every failure is a neighbouring row's
value pasted into the wrong record, and none of them are in the dimension fields except on 00138:

| SKU | Field | SAP | Truth | Source of SAP's value |
|---|---|---|---|---|
| 00104 | weight | 5.2 kg | 6 kg | FLT120's row (SAP's own remark says 6 kg) |
| 00104 | remark | "Standart one GLASS JUG" | two jugs | FLT120's remark, pasted wholesale |
| 00105 | weight | 6.5 kg | 7,5 kg | FLT250's row |
| 00138 | all dims + weight | 190/370/502, 5.2 kg | unknown | FLT120-2's row, all four fields |

Separately, **`products.json` for IMG/COF/00104 stores 410/420/675**, which matches neither SAP nor
KEF nor any product in the range. SAP should simply replace it.

## 10. Image sourcing

**Proven ceiling: 800 px on the long edge from every KEF-controlled source.** kef.com.tr and
coffeetoys.com.tr run the same `/dsy/` CMS and cap there (`/dsy/t/` is the thumbnail tier).
Reseller mirrors serve byte-identical copies - rawpluscoffee.com's Shopify CDN reproduces
kef.com.tr's 800×800 files under the same filenames.

The 800 px **short**-edge floor is therefore unreachable for any non-square shot; most machine
photos are portrait crops between 225 and 687 px wide, all marked `UNDERFLOOR`. The highest-
resolution KEF asset located anywhere is 1001×1030, a PDF-embedded object on catalogue page 9 -
but it is the FLT120-**T**, none of our SKUs. PyMuPDF extraction beat the web tier only on the
Filtronist (687×1329 vs 225×800).

**Shared-photo detection** (16×16 average hash, Hamming ≤ 12, then per-pixel RMS < 6 on 256×256
greyscale) found 5 clusters across 46 images. KEF reuses three boilerplate shots - power cord,
filter paper, badge/brew-basket macro - under a **different filename on every product page**, so
filename and URL are useless for dedupe on this brand and MD5 would have proven nothing. The
filter-paper boilerplate spans **eight** pages; it is still the correct photograph for FK925, just
not a discriminating one.

**Finish is a real product difference here.** KEF offers the Filtro/Filtronic chassis in white, red,
inox and black (the "Renk Seçenekleri / Color Options" swatch strip, catalogue pages 9 and 11) plus
bespoke wraps, and the wraps are catalogued codes in their own right (FLT120-2 G1/G2/G3, page 18).
Finish had to be read from each photograph rather than inferred from the page it sat on. Staged
files carrying a finish other than the SKU's are named with that finish spelled out
(`-YELLOW-finish`, `-BLACK-finish`, `-CUSTOMWRAP-finish`) so they cannot be picked as a primary by
mistake.

**Authenticity:** every image was rendered before acceptance. All are conventional studio product
photography on white; none showed synthetic-generation artefacts and no `_ai-generated\` folder was
needed. The KEF wordmark plus the line script (`Filtro` / `Filtronic` / `Filtronist`) is legible on
the primary shot for every machine SKU - which is what rules out a repeat of the wrong-maker defect
described below.

### Wrong-product images replaced

Both SKUs the earlier pass flagged as showing a rival maker now have genuine KEF assets:

- **IMG/COF/00104** was showing Coffee Queen / Crem product. Replaced with an inox FLT120-2 side
  elevation carrying two glass jugs (https://www.kef.com.tr/dsy/flt-11908.jpg, 800×800), plus the
  inox front view from the FLT120-2 page itself.
- **IMG/COF/00101** was showing a competitor's decanter. Replaced with KEF's own 1.8 L glass pot
  (https://www.kef.com.tr/dsy/cam-pot-11909.jpg, 800×800).

## 11. Recommendations - none applied

`model_number` is the unique ID. Nothing below was changed inline.

| SKU | Current `model_number` | Recommended | Confidence |
|---|---|---|---|
| IMG/COF/00103 | `FTL120 BLACK` | `FLT120 BLACK` | certain |
| IMG/COF/00104 | `FLT120 INOX` | `FLT120-2 INOX` | certain |
| IMG/COF/00101 | `CMP-2` | `CMP-1` | high - no CMP-2 exists |
| IMG/COF/00138 | `FLS6X2` | ask supplier: `FLS-6x2` or `FLS-8x2` | unresolved |
| IMG/COF/00105 | `FLC 250` | no change | confirmed |
| IMS/FIT/00992 | `FK925` | no change | confirmed |

Also outstanding:

- `brands.json` KEF `website_url` `kef-factory.com` → `https://www.kef.com.tr`
- `products.json` 00104 dimensions 410/420/675 → 190/370/502
- 00104 weight 5.2 → 6 kg; 00105 weight 6.5 → 7,5 kg
- 00138: clear the FLT120-2 dimensions it inherited; keep `draft`

## Sources

https://www.kef.com.tr
https://www.kef.com.tr/filtre-kahve-makineleri
https://www.kef.com.tr/kef-filtro-flt120-filtre-kahve-makinesi
https://www.kef.com.tr/kef-filtro-flt120-2-filtre-kahve-makinesi
https://www.kef.com.tr/kef-filtro-flt120-t-filtre-kahve-makinesi
https://www.kef.com.tr/kef-filtronic-250
https://www.kef.com.tr/kef-filtronic-120
https://www.kef.com.tr/kef-filtronic-120-t
https://www.kef.com.tr/kef-filtronist-fls-5-7
https://www.kef.com.tr/kef-filtronist-fls-2-5
https://www.kef.com.tr/e-katalog
https://drive.google.com/file/d/1vVfBT6MO2i6RL2_EKBjapo2LxULkfAt0/view
https://www.coffeetoys.com.tr/endustriyel-filtre-kahve-makineleri
https://www.coffeetoys.com.tr/kef-filtronist-fls-6-lt-endustriyel-filtre-kahve-makinesi
https://www.coffeetoys.com.tr/kef-filtronist-fls-8-lt-endustriyel-filtre-kahve-makinesi
https://www.coffeetoys.com.tr/kef-filtro-flt120-18-lt-profesyonel-filtre-kahve-makinesi
https://www.rawpluscoffee.com/collections/kef-batch-brewers
https://www.globalmutfak.com/kef-filtre-kahve-makinesi-cift-potlu-siyah-flt120-2-s-pmu2899
https://pluskahve.com/kef-filtro-flt120-2-filtre-kahve-makinesi
https://www.ciceksepeti.com/kef-filtre-kahve-makinesi-flt120-kc4807387
