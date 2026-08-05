# HDS (Heavy Duty Systems) — research redo, 2026-07-30

SAP-led pass over all 19 HDS SKUs. Every image below was **opened and looked at**, not just
HTTP-checked. Staged assets live in
`Desktop\ecommerce\products resorce final\hds\` (79 files: images + spec PDFs).
The previous pass is archived at `database/data/research/old/hds-research.md`; several of its
conclusions are **overturned** here — see §5.

Nothing in `products.json` was changed by this pass.

---

## 1. Who "HDS" actually is — settled

The old file left this open ("HDS" = H.D. Sheldon & Co. vs Heavy Duty Systems). It is settled:

- All 16 `HDS*`-model SKUs are **Heavy Duty Systems** (heavydutysystems.com). Proof: a
  distributor-hosted, HDS-letterheaded "Gas Equipment" spec sheet for `HDSGCO-1` carrying the
  Heavy Duty Systems logo and `sales@heavydutysys.com`:
  https://www.foodmach.com.ph/wp-content/uploads/2020/10/hd-sheldon-gas-convection-oven-HDSGCO-1-foodmach.pdf
  (Foodmach files that page under "H.D. Sheldon" — **their page title is wrong**, the PDF itself
  is Heavy Duty Systems. Don't be misled by it:
  https://www.foodmach.com.ph/hd-sheldon-gas-convection-oven-hdsgco-1/ )
- The 3 pressure fryers are genuine **Broaster Company** units (Beloit, WI). SAP marks them
  Make `HDS`; that reflects the H.D. Sheldon export channel, not the manufacturer.

### New: the OEM behind the HDS gas fryers is **Hamoki**

`HDSFGH-90/-120/-150/-120S/-150S` are rebadged **Hamoki GF90 / GF120 / GF150 / GF120T**.
Independently proven by matching factory part codes (see §4) and by matching burner counts and
oil capacities in Hamoki's own manual:
https://cdn.shopify.com/s/files/1/0673/3335/7884/files/101061_101070_101071.pdf
Hamoki's UK arm: https://hamoki.co.uk/collections/fryers

Similarly the electric convection ovens (`HDSECO-3A/4A/8A`) are **Eagle Foodservice Equipment**
product — Eagle's own page names our exact model:
https://eagle-kitchen.com/product/convection-oven/ ("Manual steaming function is available for
HDSECO-4A", cavity 62 L / 460×375×360 mm, 4 trays 325×450 mm).

---

## 2. Sources used

Manufacturer / OEM
- https://heavydutysystems.com/products/
- https://heavydutysystems.com/product/gas-fryer/
- https://heavydutysystems.com/product/gas-split-tank-fryer/
- https://heavydutysystems.com/product/electric-fryer-split-tank/
- https://heavydutysystems.com/product/gas-burners-with-oven/
- https://heavydutysystems.com/product/gas-burners-with-oven-and-24-griddle-salamander/
- https://heavydutysystems.com/product/gas-convection-oven/
- https://heavydutysystems.com/product/electric-convection-oven/
- https://heavydutysystems.com/product/electric-convection-oven-with-top-grill/
- https://heavydutysystems.com/product/hot-display-case/
- https://heavydutysystems.com/wp-content/uploads/2024/07/HDS-Gas-HDSFGH-Gas-Fryer.pdf
- https://heavydutysystems.com/wp-content/uploads/2024/07/HDS-Gas-HDSFGH-S-Gas-Split-Tank-Fryer.pdf
- https://heavydutysystems.com/wp-content/uploads/2024/07/HDSEFF-10LS-Electric-Fryer-Split-Tank.pdf
- https://heavydutysystems.com/wp-content/uploads/2024/07/HDS-Gas-HDSGR-Gas-Burners-with-Oven.pdf
- https://heavydutysystems.com/wp-content/uploads/2024/07/HDS-Gas-HDSGR-GS24-Gas-Burners-with-Oven-and-24-Griddle-Salamander.pdf
- https://heavydutysystems.com/wp-content/uploads/2024/07/HDS-Gas-HDSGCO-1-Gas-Convection-Oven.pdf
- https://heavydutysystems.com/wp-content/uploads/2024/07/HDSECO-8A-8AS-Electric-Convection-Oven.pdf
- https://heavydutysystems.com/wp-content/uploads/2024/07/HDSECO-3A-4A-Electric-Convection-Oven-with-Top-Grill.pdf
- https://heavydutysystems.com/wp-content/uploads/2024/07/HDSHD-Hot-Display-Case.pdf
- https://broaster.com/equipment/broaster-1800/
- https://broaster.com/equipment/broaster-pressure-fryer-1600/
- https://broaster.com/wp-content/uploads/Broaster1600_SpecSheet8_2024.pdf
- https://broaster.com/wp-content/uploads/Broaster1800_SpecSheet8_2024.pdf
- https://broaster.com/wp-content/uploads/17271-0-1600_1800-ST-Parts-Manual-rev-06-26-1.pdf
- https://eagle-kitchen.com/product/convection-oven/

Distributors (independent corroboration)
- https://benitezcommercial.com/products/heavy-duty-systems-hdsgco-1
- https://benitezcommercial.com/products/heavy-duty-systems-model-hdsfgh-90
- https://benitezcommercial.com/products/heavy-duty-systems-model-hdsfgh-120
- https://benitezcommercial.com/products/heavy-duty-systems-model-hdsfgh-150
- https://benitezcommercial.com/products/heavy-duty-sytems-model-hdsgr-36
- https://benitezcommercial.com/products/heavy-duty-systems-model-hdsgr60-gs24
- https://benitezcommercial.com/products/heavy-duty-systems-model-hdshd-27 (this is the HDSHD-**26** listing; the handle says 27)
- https://benitezcommercial.com/products/heavy-duty-systems-model-hdshd-36
- https://benitezcommercial.com/products.json (full catalogue dump — Shopify, works)
- https://www.foodmach.com.ph/wp-content/uploads/2022/07/HDS-Heavy-Duty-Systems-Gas-Fryer-HDSFGH-90%E2%80%8B.pdf
- https://www.foodmach.com.ph/wp-content/uploads/2022/07/Foodmach-HDS-Heavy-Duty-Systems-Gas-Split-Tank-Fryer-HDSFGH-120S%E2%80%8B.pdf
- https://www.foodmach.com.ph/wp-content/uploads/2022/07/Foodmach-HDS-Heavy-Duty-Systems-Gas-Burner-with-Oven-HDSGR-36.pdf
- https://www.foodmach.com.ph/wp-content/uploads/2025/10/HDS-Floor-Standing-Deep-Fat-Fryer-Model-HDSFGH-90-Foodmach.pdf (3-page HDS gas brochure; page 2 carries HDSGR60-GS24)
- https://lowtempcorp.com.ph/wp-content/uploads/2023/07/Heavy-Duty-Systems.pdf (5-page HDS gas catalogue)

OEM parts documents (the basket findings rest on these)
- https://cdn.shopify.com/s/files/1/0673/3335/7884/files/Hamoki_GF120_Exploded_viewing_Parts_list_2.pdf
- https://cdn.shopify.com/s/files/1/0673/3335/7884/files/GF120T_Exploded_Viewing_Parts_List_1.pdf
- https://cdn.shopify.com/s/files/1/0673/3335/7884/files/GF150_Exploded_Viewing_Parts_list_2.pdf
- https://hamoki.co.uk/products/basket-for-gf90-fryer-p-sp10005
- https://hamoki.co.uk/products/sp10440-fryer-basket-for-gf150
- https://hamoki.co.uk/products/sp10439-gf120t-gas-fryer-basket

---

## 3. Verified spec table (manufacturer W × D × H, mm)

| SKU | Model | Verified W×D×H | Verified other | vs SAP |
|---|---|---|---|---|
| IMG/DIS/00138 | HDSHD-26 | 660 × 437 × 655 | 110 L, 1840 W, 35 kg | SAP 660/431/660 — agrees |
| IMG/DIS/00139 | HDSHD-36 | 900 × 480 × 590 | 150 L, 1840 W, 50 kg | SAP 889/482.6/584 — agrees (identical in inches: 35×19×23) |
| IMG/HOT/00332 | BROASTER 1600 | 406 × 737 × 1088 | 21 lb oil, 6 kW, NW 195 lb / ship 216 lb | SAP 406/737/1088 — **exact** |
| IMG/HOT/00333 | BROASTER 1800GH (gas) | 457 × 908 × 1152 | 42 lb oil, 65,000 BTU, NW 256 lb (116 kg) | SAP 457/**1488**/1152 — middle value wrong |
| IMG/HOT/00390 | BROASTER 1800E (electric) | 457 × 908 × 1152 | 42 lb oil, 9.9 kW, NW 219 lb (99 kg) | same problem |
| IMG/HOT/00344 | HDSFGH-120 | 394 × 767 × 1182 | 120,000 BTU, NW 71 / GW 82 kg, 45-50 lb oil | SAP dims exact; SAP weight 0 |
| IMG/HOT/00345 | HDSFGH-150 | 534 × 767 × 1182 | 150,000 BTU, NW 78 / GW 83 kg, 65-70 lb oil | SAP dims exact; SAP weight 83 = **gross**, net is 78 |
| IMG/HOT/00347 | HDSFGH-150S | 534 × 764 × **1195** | 120,000 BTU, NW 71 / GW 83 kg, 25+25 lb | SAP L/W/H correct, SAP **remark text** says 1182 |
| IMG/HOT/00406 | HDSFGH-90 | 394 × 767 × 1182 | 90,000 BTU, NW 65 / GW 71 kg, 35-40 lb oil | SAP exact |
| IMG/HOT/00407 | (basket) | — | see §4 | part number wrong |
| IMG/HOT/00424 | (basket) | — | see §4 | part number correct |
| IMG/HOT/00425 | (basket) | — | see §4 | part number correct |
| IMG/HOT/00436 | HDSEFF-10LS | 400 × 800 × 1100 | 6+6 kW, 2 × 10 L, 56 kg | SAP exact |
| IMG/HOT/00437 | HDSGR-36 | 915 × 829 × 1520 | 211,000 BTU, NW 167 / GW 207 kg | SAP has 0/0/0 — **fillable** |
| IMG/HOT/00438 | HDSGR60-GS24 | 1523 × 774 × 1532 | 278,000 BTU, NW 330 / GW 390 kg | SAP has 0/0/0 — **fillable** |
| IMG/OVE/00201 | HDSGCO-1 | 967 × 1099 × 1384 (2020 sheet) / 969 × 1033 × 1456 (2024 sheet) | 54,000 BTU, 120VAC 9.3A, NW 185 / GW 275 kg | SAP matches the 2020 sheet exactly; `products.json` is badly wrong — §5.1 |
| IMG/OVE/00223 | HDSECO-4A | 595 × 580 × 570 (cavity 460×375×360, 62 L) | 4 trays 450×325, 2670/2000 W, 39 kg | SAP 584/584/558 — ~1 cm off, fine |
| IMG/OVE/00224 | HDSECO-8A | 834 × **796** × 572 (cavity 700×460×360) | 4 trays 400×600, 6400 W, 73 kg | SAP 838/**685**/584 — depth off by 111 mm |
| GROUP/FRYER-SINGLE-GAS-HDS | — | (grouping parent for 00344 + 00345) | — | no SAP row, none expected |

Axis note: HDS, Hamoki, Broaster and Eagle all publish **W × D × H**. Our `length` field holds the
manufacturer's **width** and our `width` field holds the manufacturer's **depth** across every one
of these SKUs — consistent with the catalogue-wide pattern. Values are right; field names are not.

---

## 4. The fryer-basket part numbers — SOLVED (old §4.2 was left open)

The Hamoki factory part codes appear verbatim in the exploded-view parts lists:

| Part code | What it is | Source |
|---|---|---|
| `70201104400` | **Basket, item 3, Hamoki GF120 parts list.** GF90 and GF120 share one basket (Hamoki sells a single SKU "SP10005 – Fryer Basket for GF90/120") | Hamoki_GF120_Exploded_viewing_Parts_list_2.pdf |
| `70201104419` | **Basket, Hamoki GF150 parts list** (= HDSFGH-150) | GF150_Exploded_Viewing_Parts_list_2.pdf |
| `70201105746` | **Basket, item 28, Hamoki GF120T (twin/split tank) parts list** | GF120T_Exploded_Viewing_Parts_List_1.pdf |

Mapping HDS ↔ Hamoki (burner count + width + oil capacity all match):
HDSFGH-90 = GF90 (3 burners, 15.5"), HDSFGH-120 = GF120 (4 burners, 15.5"),
HDSFGH-150 = GF150 (5 burners, 21"), **HDSFGH-150S = GF120T (4 burners, 21", 25+25 lb)**.

Consequences for our three basket SKUs:

- **IMG/HOT/00424** "Fryer Baskets for HDSFGH-90S" / `70201104400` — the *part number is correct*
  for a 90/120 single-tank basket. The trailing **"S" in the title is spurious**; there is no
  HDSFGH-90S in any HDS or Hamoki document. SAP itself contradicts this row: its Description says
  "BASKETS FOR HDSFGH-90S" while its Remark says "BASKETS FOR HDSFGH-150S".
- **IMG/HOT/00425** "Fryer Baskets for HDSFGH-120S LP" / `70201105746` — **correct**. This is
  genuinely the split-tank basket. (The "LP" suffix remains unattested, but it is only a fuel-type
  tag; the part number itself checks out.)
- **IMG/HOT/00407** "Fryer Baskets for HDSFGH-150S" / `70201104400` — **wrong part number.**
  HDSFGH-150S is the split-tank (GF120T) machine, whose basket is `70201105746`; `70201104400`
  is the GF90/GF120 single-tank basket. Either the part number was copy-pasted from 00424, or the
  SKU is really a 90/120 basket and the title is wrong. Both 00407 and 00425 cannot be different
  products if both are 150S/120S split-tank baskets. **Needs a business decision — do not
  silently change `model_number` (it is our unique ID).**

Basket photo caveat: Hamoki uses one watermarked photo for the GF90/120, GF150 *and* GF120T
baskets, so no photo can distinguish them. Note that every HDS and Hamoki fryer photo shows
**red**-handled baskets; the three basket images currently live on our storefront show a
**blue**-handled generic basket — almost certainly a stock photo, not the supplied part.

---

## 5. Disagreements and live defects found

### 5.1 IMG/OVE/00201 HDSGCO-1 — the previous pass wrote the *cavity* size into the product dims

`products.json` currently carries `737 × 660 × 508` for the gas convection oven. That number came
from the old §4.4, which read Benitez's copy as an exterior size. Benitez's sentence actually
reads: *"Convection Oven, gas, 29" W x 26" D x 20" H **porcelain enamel interior**…"* — it is the
**interior cavity**. The real product dimensions, from two HDS-issued sheets:

- 2020 HDS sheet (via Foodmach): **967 × 1099 × 1384 mm**, NW 185 kg / GW 275 kg — *identical to SAP*
- 2024 HDS sheet (heavydutysystems.com): **969 × 1033 × 1456 mm**, same weights, same 54,000 BTU

A 508 mm-tall floor-standing convection oven on 25" legs is physically impossible. **This is the
most important correction in this pass: revert `products.json` to SAP's 967 × 1099 × 1384** (and
keep 737 × 660 × 508 as the cavity, in the spec table, correctly labelled). The two HDS revisions
differ on depth and height; SAP agrees with the older one, so prefer SAP.

### 5.2 IMG/HOT/00347 HDSFGH-150S — height 1182 should be 1195

`products.json` has 1182 mm. Three sources say **1195**: the HDS split-tank sheet, the Foodmach
HDSFGH-120S sheet, and the Lowtemp Corp catalogue. SAP's *stored* height is already 1195; only
SAP's free-text Remark says "534X764X1182 MM". SAP contradicts itself here — trust the number
field, not the remark.

### 5.3 IMG/HOT/00333 + IMG/HOT/00390 Broaster 1800 — SAP's middle value is a clearance figure

SAP records `457 / 1488 / 1152`. Broaster's 2024 spec sheet gives overall **W 18" (457) × D 35-3/4"
(908) × H 45-3/8" (1152)**. The 1488 is SAP mis-picking the **58-7/8" (1485 mm) cover-open
clearance** from the drawing. Separately, `products.json` stores `457 / 1152 / 908` — i.e. it has
**depth and height transposed**: it claims the machine is 908 mm tall, which is below counter
height, when 908 is the depth.
Weights also differ by fuel: 1800E net 219 lb (99 kg), 1800GH net 256 lb (116 kg). SAP's remark
"Net weight 116kg" is on the *gas* SKU, which is right; the electric SKU (00390) inherits the
gas copy verbatim and should not.

### 5.4 IMG/HOT/00332 Broaster 1600 — SAP remark says "Net weight 8kg"

Broaster's sheet: net 195 lb (88.5 kg), ship 216 lb. "8kg" is a truncation of 88 kg. The
*dimensions* in SAP (406/737/1088) are exact, so only the weight sentence is bad. The same remark
also claims "120 pieces per hour"; the current sheet says 20 pieces/load, 40 lb/hour.

### 5.5 IMG/OVE/00224 HDSECO-8A — depth is 796 mm, not 685 mm

HDS's own CAD elevations in the 8A sheet read 834 wide / 796 deep / 572 high. SAP's 838/685/584
comes from the Benitez wording "33" W x 27" D x 23" H" — the 27" (685) depth is the odd one out;
HDS says 31.3" (796). Staged drawings: `IMG-OVE-00224__HDSECO-8A-heavydutysystems-specpdf-3/4/5.png`.

### 5.6 Heated displays — the "N" in HDSHDN-26 / HDSHDN-36 is Sheffield-only, and now much weaker

The manufacturer and **three** independent distributors all spell it `HDSHD-26` / `HDSHD-36` /
`HDSHD-48`. A targeted search for the literal string "HDSHDN-36" returns exactly one page on the
open web — sheffieldafrica.com, i.e. our own data. The extra N has no external support at all.
Still flagged rather than changed, because `model_number` is our unique ID.

Also note: SAP's remark text for both display SKUs is **verbatim Benitez Commercial copy**
(down to "adjustable thermostat with internal humidifier"). SAP's remarks for HDSGR-36,
HDSGR60-GS24 and HDSGCO-1 are likewise Benitez copy. **SAP's remark field is not an independent
source for these SKUs** — it is a distributor listing that was pasted in.

### 5.7 Storefront image defects (the big cluster)

Verified by opening the files and by pixel-diffing them:

| SKU | Problem |
|---|---|
| IMG/HOT/00347, IMG/HOT/00436, IMG/HOT/00406 | **All three use the byte-identical same photo** (mean pixel diff 0.00). The photo is HDS's *gas split-tank* family shot (confirmed labelled `HDSFGH-150S` on the Foodmach sheet). So it is right for 00347, but 00436 is an **electric** split-tank fryer (control panel, no gas cabinet — see `IMG-HOT-00436__HDSEFF-10LS-heavydutysystems-1.jpg`) and 00406 is a **single-well** fryer. Two wrong images. |
| IMG/DIS/00138 + IMG/DIS/00139 | Identical file. It is the HDSHD-**26** (700 mm) unit; the 900 mm SKU needs its own shot. Staged: `IMG-DIS-00139__HDSHD-36-benitezcommercial-1.jpg` (model code printed on the image). |
| IMG/HOT/00333 + IMG/HOT/00390 | Identical file, and the data plate visible in the photo reads **"MODEL 1800GH"** — the gas model. So the *electric* SKU 00390 is showing a gas machine's nameplate. Four alternative Broaster 1800 shots staged. |
| IMG/HOT/00437 | SKU is the **6-burner 36"** HDSGR-36; the photo is a **4-burner 24"** range (HDSGR-24). Correct 6-burner shots staged from the HDS sheet and from Benitez (code printed on image). |
| IMG/HOT/00438 | SKU is HDSGR60-GS24 — **60" wide, 6 burners, 24" griddle, 17" salamander, two ovens**. The photo shows a ~36" range with **2 burners, a griddle, one oven and no salamander**. Wrong machine. Correct shots staged from three sources. |
| IMG/HOT/00407, 00424, 00425 | All three identical, and it is a blue-handled generic basket (§4). |
| IMG/HOT/00345 | Image is only **360 × 360 px** — far below the rest of the catalogue. A 1280 px Benitez shot with `HDSFGH-150` printed on it is staged. |

Correct images (00201 HDSGCO-1, 00223 HDSECO-4A, 00224 HDSECO-8A, 00332 Broaster 1600, 00333
Broaster 1800GH) were confirmed against the manufacturer's own photo.

### 5.8 Not a defect: the "model differs" flags on 00437 / 00438

The dossier flagged `HDSGR-36` vs SAP `HDSGR‐36` and `HDSGR60-GS24` vs SAP `HDSGR60‐GS24`. SAP's
strings use **U+2010 HYPHEN** where ours use ASCII hyphen-minus. Pure Excel-export artifact — the
model numbers are the same. Do not "fix" them.

### 5.9 Smaller conflicts, noted only

- HDSGR-36 oven thermostat: HDS's own sheet says **250–550 °F**; SAP's (Benitez-derived) remark
  says 212–608 °F.
- HDSECO-4A thermostat: Eagle and HDS say **50–300 °C (122–572 °F)**; SAP remark says 86–572 °F.
- HDSFGH-90 and HDSFGH-120 are **externally identical** (same 394×767×1182 cabinet, same packing).
  They differ only in burner count (3 vs 4), BTU and net weight. HDS's own spec sheet reuses one
  battery-of-three photo for the -90, -120 and -150 alike, so a photo can never prove which is
  which — only the printed-code distributor shots can.
- HDSGCO-1's HDS product photo and the storefront photo are the same shot; fine.

---

## 6. Dead ends — don't retry

- `advancecommercialtt.com/product/hdshd-36-maj/` — returns HTTP **521** (origin down).
- `tomadostore.com` — returns HTTP **403** to any non-browser fetch. Its listings appear in search
  results but the pages cannot be retrieved this way.
- `heavydutysystems.com` publishes **one photo and one PDF per product family**, never per model.
  There is no per-SKU page. Don't go looking for `…/product/hdsfgh-150/`.
- `foodmach.com.ph/hds-heavy-duty-systems/` is a JS-rendered index; the per-model PDFs are only
  discoverable through search, not by crawling that page.
- No parts list, exploded view or dimensioned drawing exists anywhere for the **HDSHD** hot
  display cases beyond the one-page family sheet.
- `HDSFGH-90S` and `HDSFGH-120S LP` — still zero external attestation for either suffix, after a
  second full pass. `HDSFGH-120S` (no LP) is real; `HDSFGH-90S` is not.
- Searching the bare part number `70201105746` on the open web returns nothing useful; it is only
  findable inside the Hamoki GF120T parts PDF.

---

## 7. Still open

1. **IMG/HOT/00407 basket part number** — needs a business call (§4). Ask the supplier which
   physical basket ships against this SKU.
2. **HDSGCO-1: which HDS revision?** 967×1099×1384 (2020, = SAP) or 969×1033×1456 (2024). SAP
   agrees with the older sheet; recommend SAP.
3. **The "N" in HDSHDN-26/-36** (§5.6) — everything external says `HDSHD-`; awaiting approval
   before touching `model_number`.
4. **BROASTER 1600E / 1800G suffixes** — Broaster's current sheets use plain `1600`, and `1800E` /
   `1800GH`. Our `1600E` and `1800G` are close but not exact; `1800G` in particular should probably
   be `1800GH` (that is what the nameplate in the photo says).
5. Whether IMG/HOT/00436 (`HDSEFF-10LS`, archived) and IMG/HOT/00437/00438 (archived) should be
   republished — all three are real, current, fully documented HDS products with stock in SAP
   (5, 5 and 2 units respectively).

---

## 8. Out of scope, but checked because it was flagged: IMG/HOT/00304 (GH-538)

Not an HDS SKU — SAP Make is **ASTAR**, and `products.json` has it under ASTAR. Reported here only
because the question was raised. **SAP is right and the storefront image is wrong.**
`GH-538` is a **countertop** 6-basket gas noodle/pasta cooker made by Guangzhou Jieguan,
specification **400 × 650 × 480 mm** — exactly SAP's figure, and the ~17.5 kg weight fits.
The current storefront photo shows a floor-standing twin-well cabinet cooker, which is a different
machine. Verified against the manufacturer's own listing (photo shows the countertop unit with six
wooden-handled baskets and a single gas control knob):
https://gzjieguan.en.made-in-china.com/product/AZkGdaucXEhj/China-Counter-Top-Gas-Noodle-Cooking-Machine-Pasta-Cooker-6-Baskets-Gh-538.html
Also listed by https://www.erzoda.com/products/stainless-steel-gasasta-cooker-gh-538-gh-588-37
No images were staged for it — that belongs to the ASTAR pass.
