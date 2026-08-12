# Blueline Product Research

Research notes behind a BLUELINE enrichment/audit pass on `products.json` (July 2026).
Covers all 5 SKUs whose `brand` string is exactly `BLUELINE`: three SNACK-series counter
chillers and two VRX-series refrigerated pizza/topping displays.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema/Santos passes before a scope decision.

This pass is unusual in two ways compared with Brema/Santos:

1. **Blueline is not an independent manufacturer.** It is a Sheffield private label. There
   is no "Blueline" factory, no official Blueline spec sheet, and no official Blueline
   product page to audit against. Specs had to be recovered by matching the *model codes*
   against the European trading houses that sell the identical units (§2).
2. **The catalogue carries three separate brand strings for what is one line** — `BLUELINE`,
   `SHEFFIELD BLUELINE` and `SV-BLUELINE` — and Sheffield's own live website proves at
   least two of them are the same brand (§1). That data-quality finding is arguably worth
   more than the spec corrections.

---

## 1. Brand naming ambiguity — BLUELINE vs SHEFFIELD BLUELINE vs SV-BLUELINE

### 1.1 What's in the catalogue today

| `brand` string | Products | `brands.json` entry | `website_url` |
|---|---|---|---|
| `BLUELINE` | 5 | slug `blueline`, name "Blueline" | `https://sheffieldafrica.com/brands/blueline` — points at **Sheffield's own site** |
| `SHEFFIELD BLUELINE` | 47 | **none** (no matching slug in `brands.json`) | n/a |
| `SV-BLUELINE` | 25 | slug `sv-blueline`, name "SV-Blueline" | `null` |

Only 2 of the 3 strings have a `brands.json` row at all. `SHEFFIELD BLUELINE` — the largest
of the three by product count — has no brand record; the closest slugs present are
`sheffield`, `sheffield-fabrications`, `oem-sheffield` and `redline`/`hk-redline`.

### 1.2 BLUELINE and SHEFFIELD BLUELINE are the same brand — confirmed against Sheffield's live site

Sheffield's own live counter-chillers listing shows a **single** brand label, `BLUELINE`,
covering products that our catalogue splits across *both* strings:

https://sheffieldafrica.com/kitchen/24/counter-chillers

Products shown there under one `BLUELINE` label include `GN1100TN`, `GN2100TN`,
`GN2100TN-1200`, `GN2100TN-1500`, `GN3100TN`, `GN4100TN`, `GN1100BT`, `GN2100BT-1200`,
`GN2100BT-1500`, `SNACK2100BT`, `SNACK3100BT` (all of which our catalogue stores as
**`SHEFFIELD BLUELINE`**) *alongside* `SNACK2100TN-1200` and `SNACK4100TN` (which our
catalogue stores as **`BLUELINE`**). Same page, same brand label, split two ways in our data.

Three further independent confirmations from inside `products.json` itself:

- **The SNACK series is split mid-family.** `SNACK2100TN-1200`, `SNACK2100TN-1500` and
  `SNACK4100TN` are `BLUELINE`; their direct siblings `SNACK1100TN`, `SNACK3100TN`,
  `SNACK2100BT-1200`, `SNACK2100BT-1500`, `SNACK3100BT`, `SNACK2100TNG`, `SNACK3100TNG`,
  `SNACK4100TNG` are `SHEFFIELD BLUELINE`. The 2-door chiller at 1200 mm is `BLUELINE`;
  the 2-door **freezer** at the same 1200 mm is `SHEFFIELD BLUELINE`. No product logic
  explains that boundary.
- **The boilerplate description text is byte-identical across the split.** `IMG/REF/00194`,
  `00195`, `00196` (`BLUELINE`) and `IMG/REF/00126` (`SHEFFIELD BLUELINE`) all carry the same
  verbatim feature list: *"Foaming Agent Cyclopentane / Digital thermostat - Dixell /
  Removable Gasket / Automatic compressor cycle defrost / Door with self closing (Not
  reversable) / N.4 S/S Adjustable feet …"*. One import, one source document, two brand
  strings.
- **Product names themselves say "Blueline" not "Sheffield Blueline".** Many
  `SHEFFIELD BLUELINE` records are literally named "… Blueline" (e.g. "Counter Chiller 9007
  Blueline", "Barline Chiller 1207 Blueline").

**Conclusion: `BLUELINE` and `SHEFFIELD BLUELINE` are one brand, arbitrarily split by
data entry across imports.** They should be merged onto a single string before the
`SHEFFIELD BLUELINE` 47 can get a working brand page (they currently have no `brands.json`
row at all, so their brand link is dangling).

### 1.3 SV-BLUELINE is a genuinely different sub-line — but still the same house brand

`SV-BLUELINE` is *not* just a third spelling. It is a distinct label on Sheffield's live
site too (the counter-chillers page shows `SV-BLUELINE` as its own brand chip on the
`PLR-12N2F(HB)` / `PLR-15N2F(HB)` / `PLR-18N2F(HB)` "Engineering Version" units), and its
model codes are from a completely different code family:

| Line | Model-code shape | Examples |
|---|---|---|
| BLUELINE / SHEFFIELD BLUELINE | Italian gastronorm codes | `GN2100TN`, `SNACK4100TN`, `VRX1800/380`, `S903`, `DR400 S/S` |
| SV-BLUELINE | Chinese domestic codes | `PLR-15N2F(HB)`, `CFR-20N1F(HB)`, `CFD-60D3F-K`, `SD/SC-518`, `BD/BC-388`, `LC-1500(T)`, `DG-1200FZ` |

**"SV" = Snow Village.** `brands.json`'s own `sv-blueline` description gives it away —
it reads *"Snow Village specializes in ice making and refrigeration equipment"* while the
brand is *named* "SV-Blueline". Snow Village is a real Chinese commercial-refrigeration
manufacturer (founded 2003, Changshan, Quzhou City, Zhejiang), and the `PLR-`/`CFR-`/`CFD-`
codes are its own catalogue codes:

https://www.snowvillagefreezer.com/
http://www.chinasnowvillage.com/
https://www.snowvillage-refrigerator.com/commercial-refrigeration-equipment/supermarket-refrigeration-series/

So `SV-BLUELINE` = "Snow Village units sold under the Blueline label". It is the **same
house brand fed by a different factory**, not a different company. Keeping it as a separate
brand string is defensible (different supplier, different code family, different spec
sheets); merging `BLUELINE` and `SHEFFIELD BLUELINE` is not optional in the same way.

### 1.4 Is Blueline a Sheffield private label? Yes.

- `brands.json`'s `website_url` for Blueline is `https://sheffieldafrica.com/brands/blueline`
  — Sheffield's own domain. That page does not describe a Blueline manufacturer at all; it
  describes Sheffield's *own* capability ("in-house stainless steel and cold room
  manufacturing plant for custom solutions", "partnerships with international suppliers").
- No independent commercial-refrigeration manufacturer called "Blueline" exists. Searches
  return only unrelated businesses: an Indian HVAC trader
  (https://www.indiamart.com/blueline-refrigeration/about-us.html) and a US service company
  (https://blue-line-refrigeration.com/). Neither manufactures anything matching these codes.
- The catalogue's naming is already self-describing: `SHEFFIELD BLUELINE`, `SHEFFIELD
  REDLINE`, `SHEFFIELD`, plus `brands.json` slugs `oem-sheffield` and
  `sheffield-fabrications`. Blueline/Redline read as Sheffield's internal **good/better
  tier labels**, not vendor names.

**Do not go looking for a Blueline manufacturer — there isn't one.** Every spec in this
document was recovered from the *underlying* OEM line instead (§2).

### 1.5 Recommendation (decision needed, not applied here)

1. Merge `SHEFFIELD BLUELINE` → `BLUELINE` (47 products), or the reverse. Either direction
   works; the live site uses plain `BLUELINE`, which is the lighter-touch option and matches
   the product names already stored.
2. Add the missing `brands.json` row if the surviving string is `SHEFFIELD BLUELINE`;
   otherwise no `brands.json` change is needed.
3. Leave `SV-BLUELINE` alone as a real supplier sub-line, but consider filling its null
   `website_url` and correcting its description, which currently describes *Snow Village*
   under the name *SV-Blueline* — confusing to any reader.
4. Blueline's `brands.json` description ("BlueLine produces high-quality commercial
   refrigeration…") implies an independent manufacturer. It is house-brand copy and reads
   as slightly misleading given §1.4.

---

## 2. Who actually makes these units

All 5 SKUs carry **generic European gastronorm model codes** that appear, unchanged, across
a whole tier of relabellers. The codes are not proprietary to anyone in the chain:

| Reseller / label | Code form | Country |
|---|---|---|
| Forcar Refrigeration | `G-SNACK2100TN`, `G-SNACK3100TN`, `G-SNACK4100TN` | Italy |
| Forcold | `G-SNACK4100TN-FC`, `G-VRX1500-380`, `G-VRX1800-380` | Italy |
| Hamoki Limited (Milton Keynes) | `SNACK2100TN`, `SNACK4100TN`, `VRX1500/380`, `VRX1800/380` | UK |
| Saro Gastro-Products | `SNACK 2100 TN`, `VRX 1500/380` | Germany |
| AllForFood / Gastronorm / Attrezzature Professionali | `G-SNACK…` | Italy |
| Firscool (Shandong Hongtai Electrical Appliance) | `G-VRX1500/380`, `G-GN2100TN`, `HC-GN4100TN` | **China (factory)** |
| **Sheffield Blueline** | `SNACK2100TN-1200`, `VRX1800/380 FG` | Kenya (label) |

The chain terminates at **Shandong Hongtai Electrical Appliance Co., Ltd. (brand FIRSCOOL)**,
Laizhou, Shandong — a Chinese OEM that lists the *same* `G-`-prefixed European codes on its
own site, organised into "Standard Line" / "Basic Line" / "EUROPE" ranges, i.e. product
families built specifically for European relabellers:

http://www.firscool.com/
http://www.firscool.com/show_149.html
http://www.firscool.com/product_view_690_182.html
http://www.firscool.com/m/product_view_898_180.html
http://www.firscool.com/product_180_5.html

So the realistic picture is: **Chinese OEM (Firscool/Shandong Hongtai and peers) → Italian
trading houses (Forcar/Forcold) → national relabellers (Hamoki UK, Saro DE, Blueline KE)**.
Sheffield is the last link, not the first. This is exactly the private-label pattern the
brief anticipated.

**Practical consequence for spec confidence:** because no single party owns the codes, the
"official" spec varies slightly by relabeller — same cabinet, different stainless grade
(AISI 304 vs AISI 201 on the `-FC` variants), different compressor, different refrigerant
(R290 / R600a / R134a all appear against the same codes), and therefore different quoted
wattage and capacity. Where sources disagree, both figures are recorded below rather than
one being picked arbitrarily.

### 2.1 Decoding Sheffield's own naming convention

Worth recording, because it explains a lot of the catalogue's names and is confirmed by
Sheffield's live site:

- **`GN` series = 700 mm deep. `SNACK` series = 600 mm deep.** Confirmed by the live-site
  labels: "Counter Chiller 1207 (`GN2100TN-1200`)", "Counter Chiller 1407 (`GN2100TN`)"
  vs "Counter Chiller 9006 (`SNACK1100TN`)", "Barline Chiller 1406 (`SNACK2100TNG`)".
- **The 4-digit number in the product name = width + depth-hundreds.** "9007" = 900 wide ×
  700 deep; "1406" = 1400 wide × 600 deep; "2207" = 2200 × 700.
- **The `-1200` / `-1500` suffix is Sheffield's/the supplier's own length variant**, not
  part of the base European code. The standard Italian `G-SNACK2100TN` is **1360 mm** wide;
  `SNACK2100TN-1200` and `SNACK2100TN-1500` are non-standard 1200 mm and 1500 mm builds of
  the same 2-door 600-deep cabinet. The same suffix appears on the GN line
  (`GN2100TN-1200`, `GN2100BT-1500`) and on Sheffield's live site.
- Suffix letters: `TN` = chiller (normal temp), `BT` = freezer (low temp), `G` = glass door,
  `U-` = drawer version, `FG` = flat glass (on VRX displays).

**This matters for the -1200/-1500 SKUs**: because their lengths are non-standard, the
Italian spec sheets *cannot* be used directly for their capacity or wattage — only for
family-level features. Said plainly rather than guessed at in §3.1/§3.2.

---

## 3. Per-SKU findings

### 3.1 SNACK2100TN-1200 (IMG/REF/00194) — 2-door counter chiller, 1200×600×860 — **Low confidence on volume**

Stored: `1200 × 600 × 860`, `-2 ~ +8°C`, `230V/50Hz`, `Volume 260 L`. Numeric
`length/width/height` fields are correct and consistent with the name.

The nearest documented unit is the **standard 1360 mm `G-SNACK2100TN`**, not a 1200 mm one:

- Forcar `G-SNACK2100TN`: **1360 × 600 × 860 mm**, internal 902 × 430 × 589, **228 L**,
  −2/+8 °C, **260 W**, 220-240V/50Hz, **R290 (85 g)**, ventilated, AISI 304, 60 mm
  insulation, automatic defrost, net/gross **88 / 111 kg**, energy class B.
  https://forcar.it/en/prodotto/refrigerated-counters-snack-line-ventilated-g-snack2100tn/
- EU energy label on that same page: **155 L** net storage volume, 580 kWh/annum, class B,
  climate class 5.
- Saro (`SNACK 2100 TN`): **260 / 155 L gross / net**, 1360 × 600 × 890-950 mm, 0.300 kW,
  R600a, class B.
  https://saro-kitchenequipment.com/product/kuehltisch-2-tueren-modell-snack-2100-tn-59-3722/
- Hamoki (`SNACK2100TN`): 1350 × 600 × 850, **226 L gross**, 210 W, **R290**, 66 kg,
  climate class 5, energy class C.
  https://hamoki.co.uk/products/refrigerated-counter-snack2100tn
- A Kenyan reseller quotes the same code as 600 × 860 × 1360 mm, 81 kg, Embraco compressor,
  **R134a** — a third refrigerant against the same code, illustrating §2's point.
  https://muatikitchen.com/product/led-drl-black-projector-headlighttool-kit/

⚠ **Our stored "260 L" is almost certainly the 1360 mm model's *gross* figure applied to a
1200 mm cabinet.** Saro states 260 L explicitly as gross for the 1360 unit; a 1200 mm
cabinet cannot hold more than the 1360 mm one. Either the volume is wrong, or it is a gross
figure being presented like a usable capacity. **No source was found for a 1200 mm
`SNACK2100TN`, so the correct volume genuinely cannot be established from the web** — this
needs the supplier's own datasheet.

Safely addable (family-level, consistent across sources): AISI 304 stainless, ventilated
(fan) cooling, automatic defrost, electronic/digital thermostat, 60 mm cyclopentane
insulation, self-closing doors, R290 refrigerant, climate class 5, 1 shelf per door.
**Not** safely addable: wattage, weight, capacity, internal dimensions.

**Confidence: Medium** on dimensions and features · **Low** on volume/wattage/weight.

### 3.2 SNACK2100TN-1500 (IMG/REF/00195) — 2-door counter chiller, 1500×600×860 — **Low confidence**

Stored: `1500 × 600 × 860`, `-2 ~ +8°C`, `230V/50Hz`, `Volume 390 L`.

Same situation as §3.1 and worse: **no published `SNACK2100TN` at 1500 mm exists anywhere**.
The documented 2-door is 1360 mm; the next documented size up is the 3-door
`G-SNACK3100TN` at 1795 mm (339 L gross, or 239 L on the AISI 201 `-FC` build):
https://www.allforfood.co.uk/refrigerated-counter-stainless-steel-aisi-304-for-snack-bars-ventilated-cooling-mod-g-snack3100tn-triple-solid-door-capacity-lt-339-temperature-range-2-8-c-dimensions-cm-l179-5-x-d60-x-p84410-l2.html
https://www.gastronorm.it/en/G-SNACK3100TN-FC-Ventilated-Refrigerated-Counter-3-Doors-Temp-2-+-8-C-Capacity-Lt-239

⚠ **The stored 390 L is internally impossible against its own siblings.** A 1500 mm 2-door
cannot hold 390 L when the catalogue's own 2230 mm **4-door** (`SNACK4100TN`, §3.3) is
stored at 386 L and the 1795 mm 3-door (`SNACK3100TN`, `IMG/REF/00126`) is also stored at
386 L. At least one of these three numbers is wrong, and probably two.

**Confidence: Medium** on dimensions (they match the name and Sheffield's own listing) ·
**Low** on everything else. Same family-level additions as §3.1 are safe; nothing else is.

### 3.3 SNACK4100TN (IMG/REF/00196) — 4-door counter chiller, 2230×600×860 — **dimensions confirmed, volume is wrong** ⚠

This is the only SNACK SKU in scope whose code matches a documented unit exactly.

Stored: `2230 × 600 × 860`, `-2 ~ +8°C`, `230V/50Hz`, `Volume 386 L`.

- Forcold `G-SNACK4100TN-FC`: **2230 × 600 × 850 mm**, internal **1772 × 430 × 560 mm**,
  **449 L**, −2/+8 °C (max ambient +35 °C / 50% RH), 230V/50Hz, **398 W**,
  **R290 (120 g)**, ventilated, automatic defrost + automatic condensate evaporation,
  electronic control, supplied with 4 grids 33×43 cm + 4 pairs of slides, energy class C.
  https://www.forcold.it/en/product/gastronomy-refrigerated-counters-ventilated-snack-line-g-snack4100tn-fc/
- AllForFood `FOR/G-SNACK4100TN` (AISI 304): **449 L**, −2/+8 °C, L223 × D60 × H86 cm.
  https://www.allforfood.co.uk/refrigerated-counter-stainless-steel-aisi-304-for-snack-bars-ventilated-cooling-mod-g-snack4100tn-n-4-solid-doors-capacity-lt-449-temperature-range-2-8-c-dimensions-cm-l223-x-d60-x-h8-p84483-l2.html
- Attrezzature Professionali: **449 L**, 4 doors, depth 60 cm, −2/+8 °C.
  https://www.attrezzatureprofessionali.com/en/banco-frigo-ventilato-4-porte-553.html
- Hamoki / CaterX / Alexanders `SNACK4100TN`: **467 L** (a gross figure), 4 doors.
  https://hamoki.co.uk/products/refrigerated-counter-snack4100tn
  https://caterx.co.uk/product/221025-4-door-refrigerated-counter-467l-snack4100tn/
- Forcar EU energy label for `G-SNACK4100TN`: **312 L** net storage volume, 1478 kWh/annum,
  energy class D, climate class 5.

**Dimensions confirmed** — 2230 × 600 matches exactly; the 860 vs 850 height difference is
the standard adjustable-feet range, not an error.

⚠ **Volume 386 L matches no source** (449 gross / 467 gross / 312 net are the three real
figures) **and is byte-identical to the volume stored on `IMG/REF/00126`
(`SNACK3100TN`, the 1795 mm 3-door, `SHEFFIELD BLUELINE`)**. A 3-door and a 4-door of the
same depth and height cannot share a capacity. This is a copy-paste error; the 4-door's real
gross capacity is **449 L**.

Safely addable: 398 W, R290 (120 g), internal 1772 × 430 × 560 mm, ventilated cooling,
energy class D, climate class 5, 4 grids + 4 pairs of slides supplied, AISI 304 (or AISI 201
if the shipped unit is the `-FC` build — worth confirming with the supplier, as it also
changes the quoted litres).

**Confidence: High** on dimensions, power, refrigerant, cooling type · **High** that 386 L
is wrong · **Medium** on which of 449/467 to publish (gross-figure convention differs by
reseller).

### 3.4 VRX1500/380 FG (IMG/DIS/00069) — pizza/topping display — **model_number typo** ⚠

**⚠ `model_number` is stored as `VRX1500/80 FG` while the `name` says `VRX1500/380 FG`.**
Flagging, **not fixing** — `model_number` is the unique ID
([[feedback_model_number_unique_id]]) and must not be changed casually.

Evidence that `/80` is wrong and `/380` is right:

- The VRX series' second number is a **depth/series designator**, and only **two** series
  exist: **`/330`** and **`/380`**. There is no `/80` and no `/800`.
  https://www.forcold.it/en/product/refrigerated-pizza-display-cases-static-g-vrx1500-330/
  https://www.forcold.it/en/product/refrigerated-pizza-display-cases-static-g-vrx1500-380/
  https://www.ristosubito.com/en/refrigerated-pizza-display-case-stainless-steel-aisi-201-model-g-vrx1500-330ss.html
- The exact string **`VRX1500/380 FG`** (with the `FG` = **flat glass** suffix) is a real,
  sold SKU: https://www.empiresuppliesonline.co.uk/collections/vrx-topping-units
- Our own record's `name`, `slug` and `image` filename all already say `1500380` / `1500/380`.

So this reads as a **dropped `3`** during data entry, not a distinct model. It should be
corrected to `VRX1500/380 FG` — but only on explicit approval, and noting that the
`model_number` is the join key.

**Specs.** Two source families, differing slightly:

- Forcold `G-VRX1500-380`: external **1500 × 395 × 230/435(h) mm** (without / with glass),
  internal **1150 × 305 × 150 mm**, **+2/+8 °C** (max +35 °C / 50% RH), 220-240V/50Hz,
  **145 W**, **R600a (35 g)**, **static** cooling, automatic defrost, manual condensate
  drainage, electronic control, 45 mm insulation, stainless steel, glass set included,
  **5 × GN1/3 + 1 × GN1/2**, no interior light.
  https://www.forcold.it/en/product/refrigerated-pizza-display-cases-static-g-vrx1500-380/
- Hamoki `VRX1500/380` (via CaterBay / Phoenix / Canmac): **1500 × 395 × 440-445 mm**,
  **54 L gross / 51 L net**, **6 × GN1/3**, **125 W**, R600a, **45 kg**, climate class 4,
  2–8 °C.
  https://caterbay.co.uk/product/hamoki-vrx1500-380-refrigerated-pizza-display-54l-6-x-gn1-3-221046/
  https://canmac.co.uk/products/refrigerated-pizza-display-1500-x-395-x-440
  https://phoenixcateringequipment.co.uk/product/221046-refrigerated-pizza-display-54l-6-x-gn1-3-vrx1500-380/
- Firscool (the OEM) lists the same unit as `G-VRX1500/380 Standard Line`:
  http://www.firscool.com/product_view_690_182.html
- Saro sells the identical unit as `VRX 1500/380`:
  https://shop.saro-kitchenequipment.com/refrigerated-table-top-displays/refrigerated-table-top-display-1-3gn-vrx-1500-380/125/2193

**Our record's pan layout (`Pans GN1/3x5 + GN1/2x1`) matches Forcold exactly**, and the
Forcold product render (downloaded, §5) visibly shows 5 × GN1/3 + 1 × GN1/2. So our data
came down the Forcold branch, not the Hamoki 6 × GN1/3 branch. Both configurations are real
for this code — **do not "correct" one to the other**; confirm which the supplier ships.

Stored prose spec table (Depth 395 / Height 440 / Width 1500) is **correct**. Two issues:

- ⚠ **Numeric fields are rotated**: `length: 395, width: 440, height: 1500`. The real unit
  is 1500 wide × 395 deep × 440 high. Same axis-rotation import bug documented in the Santos
  (§3) and Brema (§3.2/3.3) passes — it recurs here, cross-brand.
- ⚠ **Inner height 239 mm** conflicts with Forcold's **150 mm**. 1145 vs 1150 inner width and
  305 mm inner depth both agree, so only the height is in dispute — 239 may be measured to
  the glass rather than to the well.

**Confidence: High** on external dimensions, temperature, voltage, refrigerant type, static
cooling and the pan layout · **Medium** on wattage (125 vs 145 W by branch) and litres ·
**High** that the `model_number` is a typo.

### 3.5 VRX1800/380 FG (IMG/DIS/00137) — pizza/topping display — **stored width is wrong** ⚠

Stored numeric: `length: 1800, width: 740, height: 380`.

- Forcold `G-VRX1800-380`: external **1800 × 395 × 230/435(h) mm** (without / with glass),
  internal **1450 × 305 × 150 mm**, +2/+8 °C, 220-240V/50Hz, **145 W**, **R600a (42 g)**,
  static cooling, automatic defrost, electronic control, 45 mm insulation, **8 × GN1/3**,
  glass set included, no interior light.
  https://www.forcold.it/en/product/refrigerated-pizza-display-cases-static-g-vrx1800-380/
- Forcold AISI 201 variant `G-VRX1800-380SS`:
  https://www.forcold.it/en/product/refrigerated-pizza-display-cases-static-g-vrx1800-380ss/
- Hamoki `VRX1800/380` (via Canmac / CaterBay / Equipment4Shop): **1800 × 395 × 440 mm**,
  **68 L gross / 65 L net**, **8 × GN1/3**, **150 W**, **R600a**, **47 kg**, climate class 4,
  2–8 °C, 1-year parts warranty.
  https://canmac.co.uk/products/refrigerated-pizza-display-1800-x-395-x-440
  https://hamoki.co.uk/products/refrigerated-pizza-display-1800-x-395-x-440
  https://caterbay.co.uk/product/hamoki-vrx1800-380-refrigerated-pizza-display-54l-6-x-gn1-3-221048/
  https://www.equipment4shop.co.uk/product/refrigerated-pizza-display-68l-8-x-gn-1-3-vrx1800-380/
- Mondial Carrelli `VRX1800-380-FC` (AISI 201):
  https://www.mondialcarrelli.com/en/VRX1800-380-FC-AISI-201-stainless-steel-refrigerated-display-case-for-basins

⚠ **`width: 740` appears in no source anywhere.** The real unit is **1800 × 395 × 440 mm**.
It looks like the `380` from the *model code* was written into the height field, and 740
came from somewhere else entirely (no VRX variant is 740 mm in any axis). This SKU's
dimension fields are the single worst-quality data in the BLUELINE set.

⚠ **`description` and `technical_specification` are byte-identical duplicates** of the same
paragraph block, and **`short_description` is empty** (the only BLUELINE SKU with an empty
short description).

The stored copy — *"This compact and space-efficient refrigeration unit is specifically
designed to store and display a wide variety of fresh salads, toppings, and ingredients at
the perfect temperature. These innovative counters enhance efficiency and freshness in food
production."* plus *"Supplied with 8 x 1/3 GN Pans"* and *"Input Power: 150 W"* — is
**verbatim Hamoki/Canmac marketing copy**. That independently corroborates §2's supply
chain, and it means the stored 150 W / 8 × GN1/3 / 2–8 °C figures are **correct** (they're
Hamoki's own).

⚠ **Pricing anomaly worth a second look:** `IMG/DIS/00137` (1800 mm, 8 pans) is priced at
**KES 161,950** while the *smaller* `IMG/DIS/00069` (1500 mm, 6 pans) is **KES 172,750**.
The larger unit being cheaper is possible (different build/stainless grade) but unusual
enough to verify.

**Confidence: High** on real dimensions, pan count, power, refrigerant, temperature ·
**High** that stored `width: 740` / `height: 380` are wrong.

---

## 4. Product reference

| SKU | Catalogue name | Model | Stored dims (L/W/H) | Verified real dims (W×D×H) | Primary source | Confidence |
|---|---|---|---|---|---|---|
| IMG/REF/00194 | 2 Door Counter Chiller 1200X600X860 | SNACK2100TN-1200 | 1200 / 600 / 860 | 1200 × 600 × 860 (per Sheffield's own listing; **no independent 1200 mm source**) | https://forcar.it/en/prodotto/refrigerated-counters-snack-line-ventilated-g-snack2100tn/ (1360 mm sibling) | **Medium** dims · **Low** volume/power |
| IMG/REF/00195 | 2 Door Counter Chiller 1500X600X860 | SNACK2100TN-1500 | 1500 / 600 / 860 | 1500 × 600 × 860 (**no independent 1500 mm source at all**) | as above (1360 mm sibling) | **Medium** dims · **Low** everything else |
| IMG/REF/00196 | 4 Door Counter Chiller 2230X600X860 | SNACK4100TN | 2230 / 600 / 860 | **2230 × 600 × 850** ✓ | https://www.forcold.it/en/product/gastronomy-refrigerated-counters-ventilated-snack-line-g-snack4100tn-fc/ | **High** (volume 386 L wrong → 449 L) |
| IMG/DIS/00069 | Refrigerated Pizza Display VRX1500/380 FG | ⚠ `VRX1500/80 FG` (typo) | 395 / 440 / 1500 (rotated) | **1500 × 395 × 435-445** | https://www.forcold.it/en/product/refrigerated-pizza-display-cases-static-g-vrx1500-380/ | **High** dims · **Medium** W/litres |
| IMG/DIS/00137 | Refrigerated Pizza Display VRX1800/380 FG | VRX1800/380 FG | 1800 / **740** / **380** ⚠ | **1800 × 395 × 440** | https://www.forcold.it/en/product/refrigerated-pizza-display-cases-static-g-vrx1800-380/ | **High** (stored W/H both wrong) |

All URLs verified HTTP 200 at time of writing. Firscool's site (`firscool.com`) serves an
incomplete TLS chain — reachable in a browser but `curl`/WebFetch reject the certificate;
use search-engine cache or a browser to read those pages.

---

## 5. Image sourcing (July 2026) — downloaded to `Downloads/blueline-images/`

**12 files.** Because Blueline has no manufacturer site of its own (§1.4), images were pulled
from the **Forcar / Forcold** product pages for the underlying units — these are the cleanest
studio renders in the chain, and Forcold's VRX render visibly matches our stored pan layout
(§3.4). Downloaded via `curl`, no auth or referer needed, named by SKU for manual review,
same workflow as the Brema/Santos passes.

| SKU | Model | File | Source |
|---|---|---|---|
| IMG/REF/00194 | SNACK2100TN-1200 | `IMG-REF-00194__G-SNACK2100TN-forcar-render.jpg` | https://forcar.it/2019/wp-content/uploads/2020/05/G-SNACK2100TN_tavoli_refrigerati_refrigerated_counter_forcar_refrigeration-1.jpg |
| IMG/REF/00194 | SNACK2100TN-1200 | `IMG-REF-00194__G-SNACK2100TN-eu-energy-label.jpg` | https://forcar.it/2019/wp-content/uploads/2020/05/G-SNACK2100TN-pdf.jpg |
| IMG/REF/00195 | SNACK2100TN-1500 | `IMG-REF-00195__G-SNACK2100TN-forcar-render.jpg` | same as 00194 (identical cabinet, different length) |
| IMG/REF/00195 | SNACK2100TN-1500 | `IMG-REF-00195__G-SNACK2100TN-eu-energy-label.jpg` | same as 00194 |
| IMG/REF/00196 | SNACK4100TN | `IMG-REF-00196__G-SNACK4100TN-forcar-render.jpg` | https://forcar.it/2019/wp-content/uploads/2020/05/G-SNACK4100TN_tavoli_refrigerati_refrigerated_counter_forcar_refrigeration-1.jpg |
| IMG/REF/00196 | SNACK4100TN | `IMG-REF-00196__G-SNACK4100TN-eu-energy-label.jpg` | https://forcar.it/2019/wp-content/uploads/2020/05/G-SNACK4100TN-pdf.jpg |
| IMG/REF/00196 | SNACK4100TN-FC | `IMG-REF-00196__G-SNACK4100TN-FC-forcold-render.jpg` | https://www.forcold.it/2019/wp-content/uploads/2020/01/G-SNACK4100TN-FC_tavoli_refrigerati_refrigerated_counter_forcold-1.jpg |
| IMG/REF/00196 | SNACK4100TN-FC | `IMG-REF-00196__G-SNACK4100TN-FC-eu-energy-label.jpg` | https://www.forcold.it/2019/wp-content/uploads/2020/01/G-SNACK4100TN-FC-pdf.jpg |
| IMG/DIS/00069 | VRX1500/380 FG | `IMG-DIS-00069__G-VRX1500-380-forcold-render.jpg` | https://www.forcold.it/2019/wp-content/uploads/2020/01/G-VRX1500-380_vetrine_pizza_pizza_display_cases_forcold.jpg |
| IMG/DIS/00069 | VRX1500/380 | `IMG-DIS-00069__VRX1500-380-hamoki-photo.png` (**1080×1080**, 253 KB — upgraded, §5.1) | https://cdn.shopify.com/s/files/1/0673/3335/7884/files/221043_49-1.png |
| IMG/DIS/00069 | VRX (family) | `IMG-DIS-00069__VRX-hamoki-manual-diagram.jpg` | https://caterbay.co.uk/wp-content/uploads/2023/09/YS15-52_Manual_for_VRX_hamoki_7241b205-206f-4dc7-996b-acb92c6b841a.jpg |
| IMG/DIS/00137 | VRX1800/380 FG | `IMG-DIS-00137__G-VRX1800-380-forcold-render.jpg` | https://www.forcold.it/2019/wp-content/uploads/2020/01/G-VRX1800-380_vetrine_pizza_pizza_display_cases_forcold.jpg |

Notes for whoever adopts these:

- **The `-pdf.jpg` files are EU energy labels, not dimension drawings** — despite the
  filename. They were opened and checked. Useful spec data, useless as product photos:
  - `G-SNACK2100TN`: **155 L** net storage volume, **580 kWh/annum**, class **B**, climate class 5.
  - `G-SNACK4100TN`: **312 L** net storage volume, **1478 kWh/annum**, class **D**, climate class 5.
  These net figures are what §3.1/§3.3 use to argue the stored "volume" fields are gross
  figures (or simply wrong).
- **Renders carry visible competitor branding.** The Forcold VRX renders have a "FORCOLD"
  logo on the control panel; the Forcar counter renders have a small Forcar badge. They must
  be retouched before use on the storefront, or replaced with Sheffield's own photography.
  Blueline-branded photography does not exist online.
- **00194 and 00195 share the same 1360 mm render** — the cabinet is visually identical, only
  the length differs. Fine as a placeholder, wrong if a customer counts doors against a scale.
- **The Hamoki photo (`IMG-DIS-00069__VRX1500-380-hamoki-photo.png`) shows a staggered
  multi-well layout**, whereas the Forcold render shows the **5 × GN1/3 + 1 × GN1/2** layout
  our record describes. Hamoki has since restated this SKU as 5 × GN1/3 + 1 × GN1/2 too
  (§5.1), so the two branches now agree — but the Forcold render remains the closer visual
  match to the stored pan list. **Use the Forcold render** for 00069 unless the supplier
  confirms otherwise (§3.4).
- **No image was found for a 1800 mm VRX from a photo source** — only the Forcold render.
- **Not copied into `storage/app/public/products/` or referenced in `products.json`** —
  staged in Downloads for review first, exactly like the Brema/Santos sets. All 5 SKUs
  already have an `image` value, so these are candidate replacements, not fills.

### 5.1 Re-sourcing pass (July 2026) — the Hamoki photo upgraded 750 → 1080 px

`IMG-DIS-00069__VRX1500-380-hamoki-photo.jpeg` was **750 × 750 / 11 KB**, the only file in
this set under the 800 px minimum-long-edge rule. It is now
`…-hamoki-photo.png` at **1080 × 1080 / 253 KB**.

**Why the old file could not simply be re-fetched larger.** The CaterBay copy and the Canmac
copy are the same Shopify asset (`pizza_5222e79c-…`). Canmac's unsuffixed Shopify master is
**750 × 750**, and requesting `_1200x1200` or `_2048x2048` returns a **byte-identical**
750 × 750 file — Shopify never upscales, so that asset is genuinely capped at 750 px
everywhere it appears. Canmac's master is the same pixels at better JPEG quality (27 KB vs
11 KB) but no more resolution.

**Where the 1080 px came from.** Hamoki's own storefront has since re-shot the range. Its
product JSON for the correct SKU — `W-221046`, titled *"Refrigerated Pizza Display – 51L
5xGN1/3+1xGN1/2 (VRX1500/380)"* — lists **nine 1080 × 1080 PNGs**. Model identity was
verified from the product JSON's `sku` field, not from the filename: the files are named
`221043_49-*`, and **221043 is a different model** (VRX1400/330), so the filename alone would
have mislabelled this. Confirmed natively sharp, not an upscale.

⚠ **Branding caveat still stands.** The standing warning in this section is that every render
for this private-label range carries visible **FORCOLD/FORCAR** branding and needs retouching
before storefront use, and that Blueline-branded photography does not exist online. The new
1080 px Hamoki render is *better* on this point but does not remove the problem: it is
**Hamoki-sourced, not Blueline**, and the superseded 750 px copy carried a **blue branding
sticker on the right-hand lid** that is absent from the 1080 px version. Treat it as
un-retouched third-party imagery like the rest of the set.

**Bonus spec find.** The ninth image on that listing is a Hamoki range table, which resolves
the §3.4 pan-layout ambiguity in favour of our stored record:

| Code | Model | Dimensions | Gas | Volume | Power | Weight |
|---|---|---|---|---|---|---|
| 221043 | VRX1400/330 | 1400 × 335 × 455 | R600a | 37 L / 6 × GN1/4 | 125 W | 38 kg |
| 221044 | VRX1200/380 | 1200 × 395 × 455 | R600a | 38 L / 3 × GN1/3 + 1 × GN1/2 | 125 W | 38 kg |
| 221045 | VRX1400/380 | 1400 × 395 × 455 | R600a | 47 L / 6 × GN1/3 | 125 W | 40 kg |
| **221046** | **VRX1500/380** | **1500 × 395 × 455** | **R600a** | **51 L / 5 × GN1/3 + 1 × GN1/2** | **125 W** | **45 kg** |
| 221047 | VRX1600/380 | 1600 × 395 × 455 | R600a | 56 L / 7 × GN1/3 | 125 W | 46 kg |
| **221048** | **VRX1800/380** | **1800 × 395 × 455** | **R600a** | **65 L / 8 × GN1/3** | **150 W** | **47 kg** |
| 221049 | VRX2000/380 | 2000 × 395 × 455 | R600a | 74 L / 9 × GN1/3 | 150 W | 50 kg |

Two consequences: Hamoki now states **5 × GN1/3 + 1 × GN1/2** for VRX1500/380, matching our
record and the Forcold branch (§3.4 recorded Hamoki as the "6 × GN1/3 branch" — that is now
out of date, and the two sources no longer disagree). And Hamoki's height for the whole range
is **455 mm**, against the 435–445 mm quoted in §3.4/§3.5 — a third figure, so the
"440 mm" stored on 00069 remains within the spread rather than confirmed.

---

## 6. Cross-cutting data-quality flags (findings only, nothing applied)

1. **⚠ `IMG/DIS/00069` `model_number` is `VRX1500/80 FG`; every other field says
   `VRX1500/380 FG`.** Almost certainly a dropped `3` — no `/80` or `/800` VRX series exists,
   only `/330` and `/380` (§3.4). **Not fixed here** — `model_number` is the unique ID.
2. **⚠ Volume figures are unreliable across the whole SNACK family.**
   `SNACK4100TN` (2230 mm, 4-door) and `SNACK3100TN` (1795 mm, 3-door, `IMG/REF/00126`) both
   store **386 L**; `SNACK2100TN-1500` (1500 mm, 2-door) stores **390 L**, more than either.
   The real 4-door figure is 449 L gross / 312 L net. At least two of these three are wrong.
3. **⚠ `IMG/DIS/00137` stores `width: 740, height: 380`** — the real unit is 395 deep ×
   440 high. `380` is the model-code series number, not a measurement.
4. **The axis-rotation import bug recurs.** `IMG/DIS/00069` stores `395 / 440 / 1500` for a
   1500 × 395 × 440 unit; `IMG/REF/00126` (SHEFFIELD BLUELINE) stores `600 / 860 / 1795` for
   a 1795 × 600 × 860 unit. Same pattern as the Santos (§3) and Brema (§3.2/3.3) passes —
   confirms it is a catalogue-wide import artefact, not brand-specific, and confirms it must
   be checked **per SKU** (00194/00195/00196 are all correctly ordered).
5. **`IMG/DIS/00137` has `description` === `technical_specification`** (byte-identical) and an
   **empty `short_description`**.
6. **Refrigerant is genuinely ambiguous for the SNACK counters** — R290 (Forcar, Hamoki),
   R600a (Saro) and R134a (Kenyan reseller) are all quoted against the same code. Do not
   publish a refrigerant for 00194/00195 without supplier confirmation.
7. **AISI 304 vs AISI 201.** The `-FC`/`SS` variants of these codes are AISI 201, the plain
   ones AISI 304, and the quoted litres differ between them (e.g. `G-SNACK3100TN` 339 L vs
   `G-SNACK3100TN-FC` 239 L). Which grade Sheffield ships materially changes both the spec
   sheet and the sales copy.
8. **Pricing anomaly:** the 1800 mm pizza display (KES 161,950) is cheaper than the 1500 mm
   one (KES 172,750) (§3.5).

---

## 7. Not resolved — stated plainly rather than guessed

- **`SNACK2100TN-1200` and `SNACK2100TN-1500` (IMG/REF/00194, 00195): real capacity, wattage,
  weight and internal dimensions could not be found.** The base European code is a **1360 mm**
  unit; 1200 mm and 1500 mm builds of it are not published by Forcar, Forcold, Hamoki, Saro,
  AllForFood, Firscool or any other source located. Sheffield's own site is the *only* place
  these lengths appear. Any numbers beyond the external dimensions would be invention. **These
  need the supplier's datasheet, not more web research.**
- **Which pan layout ships on `VRX1500/380 FG`** — 5 × GN1/3 + 1 × GN1/2 (Forcold) or
  6-7 × GN1/3 (Hamoki/Saro). Both are real for the same code.
- **Which stainless grade / refrigerant Sheffield actually receives** (flags 6 and 7 above).
- **Whether `SNACK4100TN`'s published volume should be 449 L (gross) or 312 L (net)** — both
  are correct, they just answer different questions. A catalogue-wide convention for
  gross-vs-net would settle it for the whole refrigeration category, not just this SKU.
- **The BLUELINE / SHEFFIELD BLUELINE merge (§1.5)** is a product decision, not a research
  finding — 47 records and a missing `brands.json` row hang on it.
