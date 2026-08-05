# Tecnoroast Product Research

**New file - no prior research existed for this brand.** Sourcing/verification pass,
August 2026, run against the SAP dossier. Covers both TECNOROAST SKUs: **TRS-60**
(`IMG/HOT/00382`) and **TRS-20** (`IMG/HOT/00384`), automatic charcoal grills for
arrosticini and skewers.

**No `products.json` or `brands.json` change has been applied.** Findings only. **No
`model_number` change is proposed.**

---

## 1. Brand

**TECNOSTAF S.r.l.**, Cda Solagne 2, 66040 Roccascalegna (CH), Abruzzo, Italy.
Tel/Fax +39 0872 987026, info@tecnoroast.com. Brand **TECNOROAST** - "Automatic cooking
arrosticini & skewers". Made in Italy, CE marked.

- https://www.tecnoroast.com (Italian) and https://www.tecnoroast.com/en/ (English)

The product is an Abruzzese **arrosticini** grill: a stainless charcoal channel with a
motorised rail that rotates every skewer simultaneously, so the skewers cook evenly without
being turned by hand. Ranges: **Single** (our two SKUs), Double, Old, plus electric and gas
lines.

## 2. Where to look

| Resource | URL |
|---|---|
| TRS-60 product page | https://www.tecnoroast.com/en/product/tecnoroast-60-single-trs-60/ |
| TRS-20 product page | https://www.tecnoroast.com/en/product/tecnoroast-20-single-trs-20/ |
| **Single-series technical specifications (the key document)** | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2020/10/TECHNICAL-SPECIFICATIONS-SINGLE-SERIES.pdf |
| Single-series user manual, IT/EN | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2020/10/SINGLE-SERIES-USER-INSTRUCTIONS.pdf |
| WP media collection (proves the image ceiling) | https://www.tecnoroast.com/en/wp-json/wp/v2/media?per_page=100&search=TRS |
| Italian distributor with 800 px photos | https://www.agritechstore.com/grill-giraspiedini-arrosticini-tecnoroast-60-pieces-single |

### Traps

1. ⚠⚠ **The technical-specifications PDF is essentially RASTERISED.** `get_text()` returns
   **235 characters** - the title and the address block only. The entire spec table is
   graphics and is invisible to text search. **Render it.** Doing so at 300 dpi is what
   unlocked this brand.
2. **Tecnoroast contradicts itself on the TRS-20's length** - see section 4.
3. **The manufacturer's TRS-60 image uploads are capped at 1024 px on the long edge** and are
   originals, not resizes - confirmed on both the English and Italian WordPress media
   collections. Every manufacturer TRS-60 asset is below an 800 px short-edge floor.
4. **Agritech Store re-hosts Tecnoroast's own TRS-20 drawings at a SMALLER size** than the
   manufacturer serves them. Taking the reseller copy would be a downgrade.

## 3. What Tecnoroast publishes - Single series

Recovered by rendering the specification sheet:

| | TRS-20 | TRS-40 | TRS-40L | **TRS-60** | TRS-80 |
|---|---|---|---|---|---|
| (A) Height (mm) | 1000 | 1000 | 1000 | **1000** | 1000 |
| (B) Grill width (mm) | 115 | 115 | 115 | **115** | 115 |
| **(C) Length (mm)** | **850** | 1250 | 1540 | **1750** | 2250 |
| **(D) Hole spacing (mm)** | **25** | 25 | 35 | **25** | 25 |
| **Skewer capacity (pcs)** | **20** | 40 | 40 | **60** | 80 |
| **Weight (kg)** | **10** | 15 | 25 | **35** | 45 |
| Supply voltage | 220-240 V / 110-120 V (all) |
| **Frequency** | **50/60 Hz** (all) |
| Motor power | 3.5 W (all) |
| Rotation | 2 rpm |
| Battery option | 3 V, 5 W, type D cell, 2 rpm (not TRS-80) |

## 4. Skewer count and length - verified

**By arithmetic on Tecnoroast's own dimensioned drawings**, which give the charcoal-channel
length and the socket pitch. They divide exactly:

| SKU | Channel | Pitch | Positions | Our name says |
|---|---|---|---|---|
| TRS-60 | **150 cm** | **2.5 cm** | **60** ✓ | 60 skewers |
| TRS-20 | **50 cm** | **2.5 cm** | **20** ✓ | 20 skewers |

**By the datasheet**, which states 60 and 20 outright. **And by counting the drawn sockets** -
a column-density count over the socket band of each plan drawing returned 61 and 22 merged
stems, the extras being the two frame uprights and the motor bracket inside the sampled band.

**TRS-60 overall length 1750 mm is confirmed** by both the drawing ("175 Cm") and the
datasheet. Our name's 1750 mm is right.

### ⚠ TRS-20 length: the manufacturer contradicts itself, and our 850 mm is the better figure

| Source | TRS-20 length |
|---|---|
| Tecnoroast **datasheet** table (2020) | **850 mm** |
| Tecnoroast **web page** "Additional information" | 80 x 25 x 100 cm -> 800 mm |
| Tecnoroast **dimensioned drawing** (2016) | "80 Cm" -> 800 mm |
| Our record and SAP | **850 mm** |

The datasheet's 850 sits in a monotone series (850 / 1250 / 1540 / 1750 / 2250) whose steps
track the skewer counts, it is the newest document, and it is the only one that tabulates
every model side by side. The 80 Cm looks like a rounded nominal carried over from the 2016
drawing set.

**Our stored 850 mm agrees with the strongest Tecnoroast source.** Recorded so that a later
pass does not "correct" it to 800 from the web page.

## 5. SAP errors

### 5.1 Cross-row contamination on the TRS-60 weight

| | SAP weight field | SAP's own remark | Tecnoroast |
|---|---|---|---|
| **TRS-60** | **10.0** | *"weight - 35kgs"* | **35 kg** |
| TRS-20 | 10.0 | *"weight - 10kgs"* | 10 kg |

**SAP's TRS-60 weight field carries the TRS-20's figure** and contradicts SAP's own remark on
the same row. Caught by testing the SAP row against itself.

### 5.2 Hole spacing

Both SAP remarks say *"Hole spacing 20 MM"*. **Tecnoroast says 25 mm** - "2.5 Cm" on both
drawings and "25" in the datasheet's (D) row. **SAP is wrong on both rows.** The 25 mm figure
is what makes the arithmetic work; at 20 mm a 150 cm channel would take 75 skewers, not 60.

### 5.3 Typo

SAP's TRS-60 remark reads *"Dimension **175050** X 250 X 1000 MM"* - a mangled 1750. The
dimension fields themselves are fine.

### 5.4 Column order

| SKU | SAP as labelled W/D/H | Tecnoroast L x D x H | Our record |
|---|---|---|---|
| IMG/HOT/00382 TRS-60 | 250 / 1750 / 1000 | **1750 x 250 x 1000** | 1750/250/1000 ✓ |
| IMG/HOT/00384 TRS-20 | 250 / 850 / 1000 | **850 x 250 x 1000** | 850/250/1000 ✓ |

**SAP's first two columns are transposed** (Depth then Length). **Our `products.json` values
are correct on both SKUs.**

Nuance: the 250 mm depth is the **overall** footprint including the skewer-support arms. The
**charcoal channel itself is 115 mm wide** (datasheet row B) - a spec worth carrying, since it
is what determines the skewer length that fits.

## 6. Electrical - correct for Kenya, with a 110 V build in existence

**220-240 V / 110-120 V, 50/60 Hz, 3.5 W.** The datasheet gives both markets on one row and
the manual repeats it: *"Always ensure that the electrical socket being used has the correct
voltage (220 V - EU) - (110 V - US/CA)"*.

- **Kenya: fully compatible.** 240 V / 50 Hz is inside the stated band and the 3.5 W
  synchronous motor is rated for both 50 and 60 Hz.
- SAP's *"Available with 220V - 3.5 Watt - 5 Watt"* conflates two things: **3.5 W is the mains
  motor, 5 W is the battery motor.** It reads as a range when it is two options.
- ⚠ **A 110-120 V build of the same model exists.** No wrong-market figure is in our record
  today, but a future pass sourcing from a US or Canadian retailer will find 110 V. Specify
  220-240 V on the PO.
- A **battery version** (3 V, type D cell, 5 W, 2 rpm) is also offered and appears nowhere in
  our record - a real selling point for outdoor and off-grid use.

## 7. Images

Folder: `Desktop\ecommerce\products resorce final\tecnoroast\`. 19 images + 6 documents.
**Every image was rendered before acceptance; none is AI-generated.**

**TRS-60 (`IMG/HOT/00382`)** - 5 distributor photos at exactly **800 x 800** (from
https://www.agritechstore.com/data/prod/img/grill-giraspiedini-arrosticini-tecnoroast-da-60-pezzi-single.jpg
and its `-1` to `-4` siblings), 3 manufacturer dimensioned drawings, 3 manufacturer gallery
photos.

**TRS-20 (`IMG/HOT/00384`)** - 3 manufacturer dimensioned drawings at up to **2345 x 2992**,
2 distributor photos, 3 manufacturer gallery photos.

### 7.1 Ceilings

**TRS-60's photographic ceiling is exactly 800 px, and it is watermarked.** Tecnoroast's own
TRS-60 uploads are capped at 1024 px on the long edge - TRS-60.1 1024 x 693, TRS-60.2
1024 x 483, TRS-60.3 617 x 1024 - confirmed as **originals, not resizes** by querying the
WordPress media collection on both the English and the Italian site. So every manufacturer
TRS-60 asset is below an 800 px short-edge floor. The only files that clear it are Agritech
Store's five 800 x 800 listing photos, all carrying a faint **AGRITECHSTORE watermark**.
Blisshub serves the same files. This is a real ceiling.

**TRS-20 is the opposite** - the manufacturer's own drawings (2345 x 2992 and 2177 x 1541)
are the largest assets, and Agritech Store re-hosts *those same drawings* smaller
(1959 x 2500 / 2177 x 1541), confirmed by perceptual hashing at ahash hamming 0-1 and RMS
**0.68 / 0.57**. The manufacturer's copies were kept.

### 7.2 Tokens

A full pairwise ahash + RMS sweep found **no shared photograph between the two SKUs** and no
duplicate among the gallery photos.

Six manufacturer gallery photos (three per product page) are cropped so that **nothing in
frame identifies the model**; they carry **`REPRESENTATIVE-RANGE`** and `code_proven: false`
even though each came off its own SKU's page. The drawings and distributor listings are
model-specific and are not tokenised.

Both documents are **`SHARED-DOC`** - Tecnoroast publishes one technical sheet and one manual
for the whole Single series (TRS-20 to TRS-80).

## 8. Not published anywhere

Charcoal capacity, cooking output per hour, stainless grade, and the skewer length the
sockets accept. Left blank rather than invented.

## 9. Product reference

| SKU | Model | Confidence |
|---|---|---|
| IMG/HOT/00382 | TRS-60 | **High** - manufacturer page, dimensioned drawings and the model-by-model datasheet all agree on 1750 mm / 60 skewers / 35 kg |
| IMG/HOT/00384 | TRS-20 | **High** on 20 skewers and 10 kg; **Medium** on length, where the manufacturer's own datasheet (850 mm) and drawing (800 mm) disagree - section 4 |

Supporting sources:

- https://www.agritechstore.com/grill-giraspiedini-arrosticini-tecnoroast-20-pieces-single
- https://www.blisshub.it/en/grill-giraspiedini-arrosticini-tecnoroast-60-pieces-single
- https://www.alberoshop.it/en/products/tecnoroast-20-single-charcoal-grill-with-automatic-rotisserie
- https://www.sborgia.com/en/kitchen/barbecue/Tecnoroast_Charcoal_barbecue_for_arrosticini_trs_60.html
- https://us.consiglioskitchenware.com/collections/tecnoroast
- https://www.tecnoroast.com/product/grill-tecnoroast-80-single-trs-80/
