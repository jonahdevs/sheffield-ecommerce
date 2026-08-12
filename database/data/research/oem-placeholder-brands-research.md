# OEM / Placeholder Brands Research

Research notes behind an audit pass over **14 brands / 19 SKUs** in `products.json`
(July 2026): OUCBOLL, WANHUI, SKYMSEN (DISCOVERY), HY, GRACHOO, FOSHAN,
GUANGDONG PERFECT, JANGMEN, NINGBO, MAYSIN, SHINEHO, ANDYMAN, KINGMA, SDX.

**No `products.json` or `brands.json` changes have been applied** - this file is findings
only, same starting point as the Henan, Kitchenware, Brema, Santos and Diqian passes.

This was scoped as a low-yield pass and the individual *specs* mostly were. The
**structural** result was not: eleven of these fourteen "brands" turned out to be either a
Chinese place name, a model-code prefix, or a manufacturer's product-line name, and in
**five separate cases the same goods are already correctly filed elsewhere in this
catalogue under a different brand**. Those five are consolidation fixes, not research gaps,
and they are the reason to read this file. They are in §1.

Read §1 first. §2 onward is per-brand and can be skimmed.

---

# 1. Structural findings - read these first

## 1.1 Twelve of the fourteen brands have no `brands.json` row at all ⚠

Only **NINGBO** and **SDX** exist in `brands.json`. The other twelve are used as `brand`
values by `products.json` but have no brand record:

```
ANDYMAN · FOSHAN · GRACHOO · GUANGDONG PERFECT · HY · JANGMEN · KINGMA
MAYSIN · OUCBOLL · SHINEHO · SKYMSEN (DISCOVERY) · WANHUI
```

This is not cosmetic. `ProductSeeder` resolves the brand by lowercased exact name:

```php
$brandId = $this->brandIdByName[mb_strtolower(trim($data['brand']))] ?? null;
```

`database/seeders/ProductSeeder.php:184`

So every one of those twelve resolves to **`brand_id = null`**. Eight of the nineteen SKUs
in this pass are `published` or `draft` and are therefore live (or nearly live) with no
brand link at all: `IMG/DIS/00144`, `IMG/DIS/00145`, `IMG/OVE/00214`, `IMG/OVE/00215`,
`IMG/HYS/00283`, `IMG/HYS/00284`, `IMG/HYS/00190`, `IMG/HYS/00032`, `IMG/TCW/00363`,
`IMG/TCW/00366`.

The full dangling list across the whole catalogue is **20 brand values / 25 products**, so
this pass covers 12 of the 20. The others are ANDYMAN-adjacent one-offs plus some real
brands that simply were never added: BRAVILOR, FIMAR GROUP, GENEVA, KAYALAR (6 products),
LINCAT, NISBET, SHEFFIELD REDLINE (3 products), ZUMMO INNOCACIONES.

⚠ **`SKYMSEN (DISCOVERY)` is the worst case of the twelve**, because a perfectly good
`skymsen` row *does* exist - the parenthesis is the only thing breaking the match. Two
published ovens worth KES 1,155,000 and KES 451,750 currently carry no brand.

## 1.2 SKYMSEN (DISCOVERY) is a data-entry artefact - **proven**, not inferred ✅

`Skymsen` is Metalúrgica Siemsen of Brusque, Brazil - already researched in
`database/data/research/skymsen-research.md`, already present in `brands.json` with a real logo and
`https://www.skymsen.com`. "Discovery" and "Maxiconv" are **Skymsen product-line names**
that were pasted into the brand field in parentheses.

This was settled with first-party evidence rather than a reseller listing. Skymsen's own
print-ready spec sheets were downloaded and their embedded PDF metadata reads:

| File | XMP `dc:title` | Created |
|---|---|---|
| `609781_eng.pdf` | **`DISCOVERY 10`** | 2025-09-19 |
| `661805.pdf` | **`MAXICONV`** | 2025-02-06 |

https://www.skymsen.com/uploads/produtos/folders/609781_eng.pdf
https://www.skymsen.com/uploads/produtos/folders/661805.pdf

Both are PDF/X print files authored by Skymsen (Adobe XMP, FOGRA39 output intent), dated
within the last 18 months, so these are *current* Skymsen models and not a discontinued
sub-brand. The official product page corroborates every stored figure:

| Field | Stored (`IMG/OVE/00214`) | Skymsen official | Verdict |
|---|---|---|---|
| Dimensions | 1590 x 1070 x 1900 mm (L x W x H) | 1900 x 1070 x 1590 (H x W x L) | **exact match** ✔ |
| Power | 20,000 W | 20,000 W | ✔ |
| Weight | 326 kg net / 425 kg gross | 326 / 425 kg | ✔ |
| Trays | 10 at 60 x 70 cm (60 x 80 option) | 10 at 60x70 or 60x80 cm | ✔ |

https://www.skymsen.com/en/index.php/produtos/detalhe/609781

Note the stored record already had the axes reordered correctly out of Skymsen's H x W x L
convention into the catalogue's L / W / H - that work was done in the earlier Skymsen pass
and has not regressed.

**Recommendation: change `brand` on `IMG/OVE/00214` and `IMG/OVE/00215` from
`SKYMSEN (DISCOVERY)` to `SKYMSEN`.** Nothing else on either record needs to move; the
`model_number` values `DISCOVERY 10` and `MAXICONV` are correct as Skymsen model names and
must stay (`[[feedback_model_number_unique_id]]`). No new `brands.json` row is needed. This
is the single highest-value change in this file.

## 1.3 Five SKUs are already filed under another brand elsewhere in this catalogue ⚠

The same pattern recurs five times: an importer recorded the **supplier's city** or the
**model-code prefix** in the brand field for one line item, while the identical goods sit
correctly under `OEM SHEFFIELD` for every other line item in the same family.

`brands.json`'s own `oem-sheffield` row gives the game away - its description opens:

> "**Guangzhou** produces commercial kitchen equipment and appliances..."

...which is a *city*, not a company, in exactly the way the `kitchenware` row's description
is about *Wanhui*. Whoever wrote these rows was recording the real Chinese source inside
the description of a house-label brand. And **Foshan, Jiangmen and Guangdong are the same
place as Guangzhou**: Guangzhou is the capital of Guangdong province, and Foshan and
Jiangmen are prefecture-level cities in that same province, all inside the Pearl River
Delta manufacturing cluster.

| SKU | Current brand | Belongs with | Evidence |
|---|---|---|---|
| `IMG/DWW/00150` | GUANGDONG PERFECT | **OEM SHEFFIELD** | 13 other `JW-` racks; §1.4 |
| `IMG/COF/00098` | JANGMEN | **OEM SHEFFIELD** | `WBB20L` is the 20 L sibling; §7 |
| `IMG/BUF/00145` | HY | **OEM SHEFFIELD** | duplicate `model_number`; §1.5 |
| `IMG/BUF/00146` | HY | **OEM SHEFFIELD** | `HY-834`/`HY-501-2` siblings; §1.5 |
| `IMS/MEC/01890` | NINGBO | accessory of `IMG/FPR/00093` | §1.6 |

## 1.4 `JW-49` completes a 13-SKU family - and its missing price is derivable ✅

`IMG/DWW/00150` (GUANGDONG PERFECT, `JW-49`, price `null`, image `""`,
`short_description` `""`) is the only `JW-` coded product in the catalogue **not** filed
under `OEM SHEFFIELD`. The other thirteen:

| Model | Product | Price (KES) | Brand |
|---|---|---|---|
| `JW-16` | Glass Rack 16 Compartment | 8,280 | OEM SHEFFIELD |
| `JW-25` | Glass Rack 25 Compartment | 9,660 | OEM SHEFFIELD |
| `JW-36` | Glass Rack 36 Compartment | 11,040 | OEM SHEFFIELD |
| **`JW-49`** | **Glass Rack 49 Compartment** | **`null`** | **GUANGDONG PERFECT** |
| `JW-25B` | Plate Rack 25 Compartment | 9,660 | OEM SHEFFIELD |
| `JW-64B` | Plate Rack 64 Compartment | 11,730 | OEM SHEFFIELD |
| `JW-162` | Glass Rack Extender 16 | 5,520 | OEM SHEFFIELD |
| `JW-253` | Glass Rack Extender 25 | 5,520 | OEM SHEFFIELD |
| `JW-S` | Open Rack | 10,350 | OEM SHEFFIELD (x2, see §12) |
| `JW-C` | Cutlery Rack | 6,900 | OEM SHEFFIELD |
| `JW-25P` | Open Plate & Tray Rack | `null` | OEM SHEFFIELD |
| `JW-DC48` | Mobile Plate Rack | `null` | OEM SHEFFIELD |
| `JW-N4821`, `JW-P3621`, `JW-P4221`, `JW-P4821` | shelving | 27,600-59,150 | OEM SHEFFIELD |

**The number in the code is the compartment count, and it is always a perfect square** -
16 (4x4), 25 (5x5), 36 (6x6), **49 (7x7)**, 64 (8x8). This is the industry-standard
500 x 500 x 100 mm dishwasher rack, confirmed independently by two suppliers who publish
exactly those dimensions for a 49-compartment rack:

https://cateringeagle.en.made-in-china.com/product/RsExrimysMVL/China-Rack-Base-of-Dishwasher-with-49-Compartments.html
https://bestwins.en.made-in-china.com/product/AXjmhzkEZZrF/China-49-Compartment-Commercial-Plastic-Dishwashing-Rack-Glass-Storage-Holder.html

**The `null` price is recoverable from the catalogue's own arithmetic.** Every `JW-` rack
price is an exact multiple of **690**, and the glass-rack ladder is perfectly linear:

```
JW-16  8,280 = 690 x 12
JW-25  9,660 = 690 x 14      (+1,380)
JW-36 11,040 = 690 x 16      (+1,380)
JW-49      ? = 690 x 18  =  12,420   (+1,380)
```

Cross-checks on the same grid: `JW-S` 10,350 = 690 x 15, `JW-C` 6,900 = 690 x 10,
`JW-64B` 11,730 = 690 x 17, the extenders 5,520 = 690 x 8. **Every** `JW-` price is an
integer multiple of 690, with no exceptions. **KES 12,420 is the predicted price** - offer
it as a proposal, not a fact, but it is a very strong prediction.

⚠ Note there is competing stock: KAYALAR `153114033` and `KAY 37` are also 49-compartment
glass racks (both archived, KES 9,430). If `JW-49` is revived, decide which line is stocked.

## 1.5 `HY` is a model-code prefix, not a brand - and `HY-902` is a hard duplicate ⚠

The catalogue contains seven `HY`-prefixed model numbers. **Five are filed under
`OEM SHEFFIELD` and only the two archived ones are filed under a brand called `HY`:**

| SKU | Brand | Model | Name | Status |
|---|---|---|---|---|
| `IMG/BUF/00035` | OEM SHEFFIELD | `HY-834` | Chafing Dish Rectangular | published |
| `IMG/BUF/00037` | **OEM SHEFFIELD** | **`HY-902`** | Chafing Dish Drop in | **published** |
| `IMG/BUF/00056` | OEM SHEFFIELD | `HY 501-2` | Chafing Dish Oblong | draft |
| `IMG/BUF/00043` | OEM SHEFFIELD | `HY-605-1` | Juice Dispenser Clear Jug | published |
| `IMG/BUF/00145` | **HY** | **`HY-902`** | Chafing Dish Drop in HY-902 | **archived** |
| `IMG/BUF/00146` | HY | `HY-836` | Chafing Dish Oval HY-836 | archived |

⚠ **`IMG/BUF/00037` and `IMG/BUF/00145` carry the identical `model_number` `HY-902` and the
identical product name** ("Chafing Dish Drop in"). This is a genuine duplicate record, and
`model_number` is supposed to be the unique identity
(`[[feedback_model_number_unique_id]]`). A catalogue-wide scan found only 14 duplicated
`model_number` values in 683 products, and most of the others are legitimate colour/finish
variants (`WINNERS 3602` rose gold vs stainless, `RANCILIO CLASS 5S GR2` black vs white).
**`HY-902` is not one of those** - nothing in either record distinguishes them.

Both stored photos were opened and both show a **round drop-in roll-top chafing dish**
with a mounting flange and fuel-holder bracket - the same product. The archived `HY` copy
(600x600, sharp) is a visibly **better photograph** than the published `OEM SHEFFIELD` one
(600x600 but soft/blurred, with gold trim accents). If the duplicate is resolved by
retiring the `HY` record, **move its image to `IMG/BUF/00037` first**.

`HY-836` (oval, archived) has no `OEM SHEFFIELD` counterpart - it is a genuine gap in the
`HY-8xx` ladder next to `HY-834` (rectangular). Its stored photo shows a standard oval
chafer with a lift-off dome lid on a stand with twin fuel holders, consistent with the name.

**Verdict: `HY` is not a brand.** It is the model prefix of the OEM buffet range that this
catalogue already files under `OEM SHEFFIELD`. Both SKUs should move there, and the
`HY-902` duplicate resolved.

## 1.6 The NINGBO "Complete Jug Set" belongs to the SHEFFIELD `SHG902` ✅

`IMS/MEC/01890` - "Complete Jug Set for Brushless Blender", `model_number: "-"`,
KES 12,000, qty 11, archived, no image, no description.

**There is exactly one brushless blender in the entire 683-product catalogue:**

> `IMG/FPR/00093` · **SHEFFIELD** · `SHG902` · **"Brushless Commercial Blender"** ·
> KES 89,050 · qty 49 · **published**

Its own description reads: *"high power 1.5L top-quality PC cup with top food adding gob
and non-ship handle"*, 800 W, with a soundproof enclosure. A "complete jug set" for it
would be the PC cup + blade assembly + lid, which is exactly what a KES 12,000 accessory at
13.5 % of the machine price would be.

No other candidate is close. The Skymsen `LAR` blenders, Santos `33EA`/`37-A`,
Robot Coupe `CMP` sticks and the Carpigiani Turbomix are all brushed-motor or immersion
machines, and none is described as brushless anywhere in the catalogue.

**Recommendations:**
- Link `IMS/MEC/01890` to `IMG/FPR/00093` as an accessory (the catalogue already has an
  `accessories` array mechanism - the Skymsen PA-7 uses it for its 7 discs).
- Its `model_number` is literally `"-"`. Leave it (`[[feedback_model_number_unique_id]]`),
  but note that the correct spare-part code should come from the supplier; `SHG902` itself
  is the machine, not the jug.
- ⚠ `IMG/FPR/00093` has the **width/height transposition bug**: numeric
  `length 247 / width 441 / height 201` against a prose spec of L 247 / W 201 / H 441. A
  1.5 L bar blender in a sound enclosure is ~247 wide x 201 deep x **441 tall**. **The
  prose is right; swap the numeric `width` and `height`.** Not one of this pass's 19 SKUs,
  but it is the parent record of one of them.

## 1.7 The WANHUI / KITCHENWARE duplicate - **confirmed as unresolved, image evidence is void** ⚠

`kitchenware-research.md` §4.1 flagged `IMG/TCW/00363` (WANHUI, `SDI2525`, 12 L,
KES 6,000, qty 15) and `IMG/TCW/00386` (KITCHENWARE, `CSP 2525`, 12 L, KES 6,900, qty 2) as
the same 25 x 25 cm pot listed twice. **That flag stands. The geometry re-check confirms it
and the photographs cannot settle it.**

Geometry, recomputed independently (V = pi(d/2)^2 h):

| SKU | Code | d x h | Brim-full | Stated | Delta |
|---|---|---|---|---|---|
| `IMG/TCW/00363` | `SDI2525` | 25 x 25 cm | 12.27 L | 12 L | -2.2 % |
| `IMG/TCW/00386` | `CSP 2525` | 25 x 25 cm | 12.27 L | 12 L | -2.2 % |
| `IMG/TCW/00366` | `SDI3624` | 36 x 24 cm | 24.43 L | 24 L | -1.8 % |

Identical inputs, identical outputs. Nothing in either record distinguishes them.

**The images looked like they might settle it, and then didn't.** The two stored photos
*are* different pots - `00363` shows flat riveted strap handles, `00386` shows round
tubular handles. But an MD5 scan of the cookware images shows `00386`'s photo is
**byte-identical** to three other KITCHENWARE stock pots at completely different sizes:

```
44BE39C9DB8C  stock-pot-12-litres-csp-2525-imgtcw00386.jpg   (12 L)
44BE39C9DB8C  stock-pot-17-litres-ei2828-imgtcw00355.jpg     (17 L)
44BE39C9DB8C  stock-pot-36-litres-ei3636-imgtcw00368.jpg     (36 L)
44BE39C9DB8C  stock-pot-71-litres-csp-4545-imgtcw00388.jpg   (71 L)
```

One generic file doing duty for four pots spanning 12-71 litres. It carries **zero
evidential weight** about what `CSP 2525` actually looks like. The WANHUI records
`00363` and `00366` each have their own unique photo.

**Verdict: still a probable duplicate; the image evidence is void; needs the supplier.**

**Useful side result - the WANHUI photos independently confirm the cm x cm code grammar.**
`SDI2525` (25 x 25) photographs as a pot roughly as tall as it is wide; `SDI3624`
(36 x 24) photographs as a distinctly **wide, low** pot at about a 1.5:1 ratio. The record
named "Stock Pot" is visibly tall and the one named "Casserole" is visibly squat, exactly
as their codes predict. That is a visual confirmation of `kitchenware-research.md` §2 that
did not exist before.

## 1.8 Geography - which "brands" are places

| Brand string | What it actually is |
|---|---|
| **FOSHAN** | Foshan, prefecture-level city, **Guangdong** province |
| **JANGMEN** | misspelling of **Jiangmen**, prefecture-level city, **Guangdong** |
| **GUANGDONG PERFECT** | **Guangdong** province + a supplier trade name, "Perfect" |
| **NINGBO** | Ningbo, city in **Zhejiang** province (not Guangdong) |

The first three are all in the Pearl River Delta, the same cluster the `oem-sheffield`
`brands.json` description names as "Guangzhou". **"Perfect" is not pure address** - unlike
the other three it contains a real trade name, and that name already appears inside three
`OEM SHEFFIELD` *product names* in this catalogue ("PVC Shelves Vented 1060 **Perfect**",
`JW-P4221`; and the 1220 and 910 variants). So `GUANGDONG PERFECT` decodes as
"Perfect, of Guangdong" - supplier name plus address.

---

# 2. Per-brand findings

Confidence key: **Verified** = exact code confirmed on an independent third-party source.
**Derived** = established from catalogue-internal grammar/geometry without a source.
**Unverified** = no external source found.

## 2.1 OUCBOLL - 2 SKUs, published ❌ brand unidentifiable, ⚠ records internally contradictory

`"OUCBOLL"` returns nothing. Brave autocorrects it to "OUC bill" (Orlando Utilities
Commission) and returns ten pages about paying an electricity bill in Florida. There is no
company, trademark, product line or supplier of that name in refrigeration or anywhere
else. `LK-1.6BY` and `LK-1.2DD` are equally unindexed - a combined DuckDuckGo query for
`"OUCBOLL" OR "LK-1.6BY" OR "LK-1.2DD"` returns an **empty result set**, and Brave,
Made-in-China product search and Marginalia all return nothing.

**But the two records contradict each other and themselves, and that is findable without a
source.** Both are `published` at KES 411,250 and KES 321,250.

| Field | `IMG/DIS/00144` `LK-1.6BY` | `IMG/DIS/00145` `LK-1.2DD` |
|---|---|---|
| Effective capacity | **256 L** | **256 L** ⚠ |
| GN 1/4 containers | **18** | **12** |
| Temperature range | **-2 °C to 20 °C** ⚠ | **-2 °C to 20 °C** ⚠ |
| Power | 565 W | 265 W |
| Dimensions | **1390** x 816 x 900 mm ⚠ | 1170 x 670 x 995 mm |
| Refrigerant | R290 (235 g) | R290 |

**Three defects:**

1. ⚠ **Both claim 256 L, which is impossible.** One holds 18 pans and the other 12. A 50 %
   larger pan count cannot fit the same 256 litres. This is textbook sibling contamination -
   one record's capacity was copy-pasted onto the other. Which one is genuine cannot be
   decided from the record; a rough well-volume estimate slightly favours the larger
   cabinet, but not decisively. **Ask the supplier.**

2. ⚠ **"-2 °C to 20 °C" is not an ice-cream temperature range on either record.** Ice cream
   must be held around -12 to -20 °C; a positive-going range to +20 °C is a pastry/chiller
   spec. **The overwhelmingly likely reading is that a minus sign was dropped and the true
   range is "-2 °C to -20 °C"**, which is exactly a gelato cabinet's range and is a very
   common way for these cabinets to be specified. This is a two-character fix on two
   published products that currently advertise an ice-cream freezer as a chiller.

3. ⚠ **`LK-1.6BY`'s stored length of 1390 mm contradicts its own model number.** The
   sibling establishes the grammar: `LK-1.2DD` is 1170 mm, i.e. the number is the cabinet
   length in metres (1170 mm ~ 1.2 m). On the same grammar `LK-1.6` should be ~1560-1600 mm,
   not 1390 mm. **Two independent signals agree against the dimension:** the model code says
   1.6 m, and 18 x GN 1/4 pans (265 x 162 mm each, laid 9 across in 2 rows) need ~1458 mm of
   internal width, which does not fit a 1390 mm external cabinet but fits a 1600 mm one
   comfortably. The stored `length` looks like it came from a 1.4 m model.
   **Do not change `model_number`; flag the dimension.**

**Independent support for the 18-pan figure:** the stored photo for `00144` is a top-down
shot of a curved-glass cabinet with the lid open, and the pans are countable - roughly two
rows of nine. The pan count is the field to trust here, not the length.

⚠ Both stored images carry the **SHEFFIELD logo watermark**, so they are the client's own
assets rather than manufacturer photography, and they are small (501x501 and 694x694).
`00145`'s photo shows a front-window chest cabinet with plain interior dividers and **no GN
pans visible**, so its "12 x 1/4 GN" claim is not visually corroborated the way `00144`'s
18 is.

**Verdict: brand unidentifiable, product identifiable as a generic curved-glass-top gelato
chest cabinet. The two records need supplier confirmation on capacity, temperature range and
the 1.6 m dimension before they should stay published as written.**

## 2.2 WANHUI - 2 SKUs, published ⚠ dangling brand row, real-but-tiny supplier

No `brands.json` row (§1.1). `kitchenware-research.md` §4.1 concluded that `WANHUI` is
*probably* a real if very small Chinese supplier, on the strength of a single Alibaba
listing for "Wanhui BC001 stainless steel kitchen supplies, optional induction burner &
chafing dish", which lines up with exactly these product types:
https://www.alibaba.com/product-introduction/Stainless-steel-kitchen-supplies-industrial-kitchen_1600071196986.html

⚠ **This pass weakens that conclusion.** Two independent searches for "Wanhui" as a
cookware/kitchenware manufacturer returned **nothing at all** - DuckDuckGo returns zero
results for the phrase, and Made-in-China has no supplier, brand or company trading as
Wanhui anywhere in its cookware index. So the entire case for WANHUI being a real company
rests on **one Alibaba listing and one sentence in our own `brands.json`**. That is thin.
Treat WANHUI as *unconfirmed* rather than "probably real" - it may equally be another
transcription of a supplier contact name.

⚠ **What the Made-in-China search did turn up is a better lead than the brand name.** The
suppliers who dominate the stainless stock-pot results are **Jiangmen Changshi Industry**
and **Jiangmen Ruida Houseware** - i.e. **Jiangmen**, which is the same Guangdong city that
appears misspelt as the "JANGMEN" brand on `IMG/COF/00098` (§2.8, §1.8). Jiangmen is one of
China's principal stainless-cookware and vacuum-vessel manufacturing centres. That makes a
coherent story - the WANHUI cookware and the JANGMEN water urn plausibly come from the same
city, and both were recorded under different placeholder strings.

**The strongest evidence about WANHUI is inside our own data**: the `kitchenware`
`brands.json` row's description is *about Wanhui* -

> "**Wanhui** manufactures commercial kitchen equipment and appliances..."

...on a row named "Kitchenware". So the catalogue already treats KITCHENWARE and WANHUI as
the same source, exactly as the `oem-sheffield` row treats itself as Guangzhou (§1.3).

Both WANHUI SKUs reconcile on geometry (§1.7) and both have their own unique photo.
Neither has a `description` or `technical_specification` at all - only a `short_description`
ending "...across Kenya", i.e. SEO copy in the neutral-summary field
(`[[project_description_field_split]]` not applied).

**Recommendations:** add the missing `brands.json` row *or* fold WANHUI into KITCHENWARE
(the row already describes Wanhui); resolve the `SDI2525`/`CSP 2525` duplicate (§1.7);
populate dimensions from the code as `kitchenware-research.md` §4.3 proposes
(Ø250 x 250 mm and Ø360 x 240 mm, in mm).

## 2.3 SKYMSEN (DISCOVERY) - 2 SKUs, published ✅ **real brand, wrong string**

Fully covered in §1.2. **Verified** against Skymsen's own spec sheets and product page.
Both records' content is already accurate and in the house pattern; only the `brand` field
is wrong. This is a brand-consolidation fix.

## 2.4 HY - 2 SKUs, archived ❌ not a brand

Fully covered in §1.5. `HY` is the model prefix of the OEM buffet range. `HY-902` is a hard
duplicate of a published `OEM SHEFFIELD` record.

## 2.5 GRACHOO - 2 SKUs (1 published, 1 draft) ❌ unverifiable

`"Grachoo"` returns nothing commercial anywhere. A clean DuckDuckGo search for the bare word
returns **only personal social-media handles** - a Facebook profile, an Instagram account, a
GitHub user, a TikTok tag, a Toyhouse profile. There is no company, trademark or supplier of
that name in any industry, let alone catering. `HSWM-001` and `HSWM-006` are unindexed on
DuckDuckGo, Made-in-China, Brave and Marginalia alike.

The code is self-consistent though: **`HSWM` reads as Hand Sink / Wall Mounted**, with
`-001` and `-006` as variants. That is confirmed by the two names - `HSWM-006` is literally
named "Wall Mounted" and `HSWM-001` "Knee Operated" - so both are wall-mounted units and
the suffix distinguishes the valve actuation, not the mounting.

The stored photo for `IMG/HYS/00283` was opened and **matches its name**: a wall-mounted
stainless basin with an integral splashback, gooseneck spout and a prominent grey
**knee-push pad** on the front apron. Correct product, correct configuration.

Three siblings exist in the catalogue and give the price context:

| SKU | Brand | Model | Product | Price |
|---|---|---|---|---|
| `IMG/HYS/00001` | BILGE | `BLGHWBK` | Hand Wash Basin Knee Operated | 41,400 |
| `IMG/HYS/00220` | SHEFFIELD | `YLS42` | Hand Wash Basin Knee Operated | 32,200 |
| `IMG/HYS/00221` | SHEFFIELD | `YLS44B` | Hand Wash Basin 400x400 | 25,300 |
| `IMG/HYS/00283` | GRACHOO | `HSWM-001` | Knee Operated | **0** ⚠ |
| `IMG/HYS/00284` | GRACHOO | `HSWM-006` | Wall Mounted | **0** ⚠ |

⚠ **Both GRACHOO records are priced 0 with quantity 0, and `HSWM-001` is `published`.** A
published product at KES 0 is a storefront defect independent of any research. Comparable
FOB for this class is **US$28-85** across seven suppliers (Ancheng US$28.15, Binzhou
Hikitchen US$63-69, DeRich US$69, Heavybao US$79-85), against KES 25,300-41,400 for the
three catalogue siblings above.

⚠ **One design difference worth recording before any photo is adopted.** Our stored
`HSWM-001` photo shows a **small rounded knee pad mounted on the side of the cabinet**.
Every comparable found on Made-in-China instead uses a **full-width hinged front push
panel** - you press the whole apron with your thigh. Both are legitimate knee-operated
designs and both are sold as such, but they are visibly different products, so none of the
sourced photos can stand in for ours. See §4.

**Useful comparable spec** (DeRich, 304/201 stainless, 1.0-1.2 mm gauge):
**400 x 340 x (200 + 384) mm** - i.e. a 400 x 340 mm bowl unit 200 mm deep with a 384 mm
splashback. Both GRACHOO records have **no dimensions at all**, and this is the right
ballpark to sanity-check against whatever the supplier quotes.

`IMG/HYS/00284` has no image, no description and no price and is correctly left `draft`.

**Verdict: brand unverifiable; product type confirmed by photo; the KES 0 published price
is the actionable item.**

## 2.6 FOSHAN - 1 SKU, published ❌ placeholder (Guangdong city), specs plausible

Foshan is a city (§1.8). `SM5L` is unindexed. The code is self-consistent - **`SM` + `5L`
= 5 litres** - and matches the stated tank capacity.

**The machine family is well documented and every stored figure is plausible for it.**
Stored: 5 L tank, 1000 W, AC 220 V / 50 Hz with a UK plug, 5 m cord, 3.5 kg net. Published
comparables for 5 L electric ULV cold foggers:

| Supplier | Tank | Power | FOB |
|---|---|---|---|
| Guangzhou Sailwin | 5 L | 1200 W | US$45-50 |
| Taizhou Yiding | 5 L | - | US$45-79 |
| Zhengzhou Use Well | 5 L | - | US$65 |
| CHINA GTL TOOLS | 4.5-6 L | 1400 W | US$62-69 |
| **Ours** | **5 L** | **1000 W** | - |

https://sailwinlight.en.made-in-china.com/product/NBsneIUbSKYO/
https://cnyiding.en.made-in-china.com/product/FwnxWHJlJuhG/China-5L-Ulv-Fogger-Portable-Ulv-Cold-Nebulizer-Handheld-Disinfection-Sprayer-Fogging-Sprayer-Disinfection-Aerosol-Sprayer-Ulv-Cold-Fogger-Sprayer-Electric-Sprayer.html
https://zzusewellmachine.en.made-in-china.com/product/wGtpOruTqzRg/China-Office-Factory-Disinfect-Sprayer-5L-Tank-Cold-Power-Electric-Ulv-Fogging-Sprayer.html

1000 W is at the low end of the 1000-1400 W band but well inside it. **No correction is
warranted.** The UK (Type G) plug note is unusually good practice for this catalogue and
should be kept.

⚠ **Price context, not a recommendation:** stored KES 65,866 is roughly US$510 against a
US$45-79 FOB band for the class. That is a wide spread even allowing for freight, duty, VAT
and margin, and it is worth a deliberate look rather than an assumption.

⚠ **The stored image is 217 x 217** - by a wide margin the smallest product image in this
pass and unusable at storefront size. It does show the right thing (a blue-tanked portable
ULV fogger with a flexible corrugated hose and cone nozzle). **No larger copy of that exact
configuration was found** - the Made-in-China 5 L foggers found are all either rigid-barrel
or 3-nozzle round-tank types, i.e. the same category but a different build. See §11.

## 2.7 GUANGDONG PERFECT - 1 SKU, archived ❌ placeholder; **but the SKU is fully recoverable**

Covered in §1.4. Brand is province + supplier trade name. The product itself is one of the
best-characterised in this pass despite having a `null` price, an empty `image` and an empty
`short_description`: it is a standard 500 x 500 x 100 mm 7x7 moulded-plastic glass rack, it
has 13 siblings in the catalogue, and its price is predictable at **KES 12,420**.

## 2.8 JANGMEN - 1 SKU, archived ❌ placeholder (misspelt Jiangmen); **sibling exists**

"Jangmen" is a misspelling of **Jiangmen**, Guangdong (§1.8). `WBB40L` is unindexed -
DuckDuckGo returns zero results for the code.

⚠ **Jiangmen is not a random city to find on a stainless water urn.** It is one of China's
principal manufacturing centres for stainless cookware and vacuum-insulated vessels, and it
dominates the Made-in-China results for exactly the goods in this pass - Jiangmen Changshi
Industry and Jiangmen Ruida Houseware for stock pots (§2.2), Jiangmen Goodman Cleaning
Supplies for glass racks (§1.4). So the placeholder is at least an *accurate* address, and
it points at the right industry. It is still an address, not a brand.

**The code family is already in the catalogue under `OEM SHEFFIELD`:**

> `IMG/COF/00027` · OEM SHEFFIELD · **`WBB20L`** · "Water Boiler Insulated 20 Litres SS" ·
> KES 25,760 · published

`WBB` + capacity + `L`. `WBB40L` is the 40 L member of the same range and belongs under the
same brand.

⚠ **A naming inconsistency worth resolving:** `WBB20L` is called a "Water Boiler Insulated"
while `WBB40L` is called a "Heated Insulated Water Urn". The stored photo for `WBB40L` shows
a stainless insulated barrel with twin side handles, a domed lid, a **power cord and a
switch** - so "heated" is correct for it. Whether the 20 L unit is also heated is not stated
on its record. ⚠ Also, **no tap or spigot is visible** in the `WBB40L` photo, which is
unusual for something sold as a "water urn"; the catering-urn siblings (`HK-REDLINE WB15A`/
`WB20A`/`WB30A`, `PRADEEP 9G`) all have taps. Worth checking whether this is a *transport*
urn rather than a *dispensing* urn - it changes the description substantially.

Price is `0` and status `archived`.

## 2.9 NINGBO - 1 SKU, archived ⚠ **the one brand row where the logo is genuine and the *name* is wrong**

This is the most interesting `brands.json` row in the pass, and it is the opposite of the
Henan finding.

```
slug: ningbo | name: Ningbo
description: "Ningbo produces commercial kitchen equipment and supplies..."
logo: brands/ningbo.png | website_url: https://www.nbhaichu.com/
```

- `storage/app/public/brands/ningbo.png` (800x765, 34 KB) is **a real, professional
  wordmark**: a white stylised loop-and-circle device beside the word **"Ouli"** on a red
  field. It is not a cropped product photo - it is a genuine logo.
- It is the logo of the site in `website_url`. Downloading
  `https://www.nbhaichu.com/template/en/images/logo.png` returns **the identical "Ouli"
  mark**. Whoever built this row did real work: they found the supplier's site and lifted
  its actual logo.
- The company is **"Ningbo Kitchen Appliance Co., Ltd."**, established 1996, ~15,000 m²,
  trading as **Ouli**. https://www.nbhaichu.com/

**So the row is internally coherent and the `name` field is the only thing wrong: the brand
is "Ouli", not "Ningbo" (which is just the city).** Recommend renaming the row `Ouli`
rather than nulling the logo. ⚠ Renaming changes the storefront URL `/brands/ningbo`, so a
redirect may be needed; and per `[[project_brand_name_casing]]` the display casing belongs
in `brands.json`, which is exactly where this fix goes.

⚠ **However, the SKU's brand attribution is still doubtful.** Ouli/nbhaichu list only
**domestic** appliances - hand blenders, food choppers, multifunctional food processors,
juicers, blenders. They list no commercial equipment and no replacement jugs. Our
`IMS/MEC/01890` is a jug set for an **800 W commercial brushless blender with a sound
enclosure** (§1.6). A Zhejiang domestic-appliance maker is a poor fit. **The stronger
attribution is the one in §1.6: this is the spare jug for the SHEFFIELD `SHG902`, and it
should be linked to that machine rather than left standing alone under a city name.**

## 2.10 MAYSIN - 1 SKU, published ❌ brand unverifiable; ⚠ **dimension bug found, and the photo settles it**

`"Maysin"` and `PJ-FK40` are both unindexed (DuckDuckGo, Brave, Made-in-China, Marginalia -
DuckDuckGo returns an empty result set for the code). `FK40` reads as **Fly Killer 40 W**,
which matches the stated power.

**The useful finding here is a dimension contradiction inside the record, and unlike most
such cases it can be decided from the photograph.**

| Source | Length | Width | Height |
|---|---|---|---|
| numeric fields | 560 | **105** | **320** |
| prose `technical_specification` | 560 | **320** | **105** |

The stored photo shows a landscape wall-mounted grid killer with **two blue UV tubes**
behind an electrified grid, marked "PEST KILLER". Its face is roughly **1.75:1** wide-to-tall.

- The **numeric** reading (560 wide x 105 deep x 320 tall) gives a face of 560:320 =
  **1.75:1**. ✔ matches the photo exactly.
- The **prose** reading (560 wide x 320 deep x 105 tall) gives a face of 560:105 =
  **5.3:1** - a letterbox slot. ✘ nothing like the photo.

⚠ **So on this record the numeric fields are correct and the prose is wrong** - the
*opposite* of the Kitchenware, Santos, Empero, Brema and Cambro findings, where the prose
was the correct orientation and the numeric fields were transposed. **Do not apply the
usual "trust the prose" fix here.** Fix the prose instead: WIDTH 105 mm, HEIGHT 320 mm.

Two UV tubes at 2 x 20 W = the stated 40 W, consistent. The stated 50 m² coverage is a
normal claim for a 40 W unit and nothing contradicts it. Comparable T8 40 W insect-killer
tubes: https://2f83ed327329328f.en.made-in-china.com/product/AFuToKSjfhUI/China-T8-36W-40W-UV-Tube-Blue-Light-Electric-Insect-Mosquito-Killer-Lamp-Tube.html

⚠ Stored image is **365 x 365** - below usable size.

## 2.11 SHINEHO - 1 SKU, archived ❌ **proven unverifiable**

`"Shineho"` is not a supplier on Made-in-China (the site autocorrects the query to
"shinecon"), and DuckDuckGo returns **literally zero results** for
`"Shineho" toaster OR catering OR kitchen equipment` - not a weak match, an empty result
set. `H260D` returns nothing relevant either: Made-in-China's fuzzy matcher offers steel
grades, plasma-cutter shield caps and drilling rigs. Brave returns nothing.

The record has **no image, no description, no technical specification and a price of 0**. A
conveyor toaster's essentials - belt width, throughput in slices/hour, power, whether it is
single or double-sided - are all unknown.

Two conveyor-toaster siblings exist (`HK-REDLINE CT-3`, KES 195,250, published;
`ANTUNES 9210710` VCT-1000, KES 475,000, published), but neither is a safe template: `CT-3`
is a different vendor's model and `VCT-1000` is a *vertical contact* toaster, a different
machine class entirely.

**This SKU cannot be written up from research. It needs the supplier's spec sheet.**

## 2.12 ANDYMAN - 1 SKU, archived ❌ **proven unverifiable**

`"Andyman"` produces no cookware or catering results on DuckDuckGo, Brave or
Made-in-China. The only things trading under the name are **Andyman Dessert & Baking Co.**
(a US bakery, andyman.com) and an Ethereum meme token (andyman.online). There is no
cookware supplier of that name.

`58122` is a **five-digit numeric code, and it is the only one of its kind in the entire
683-product catalogue.** It does not fit the `SDI`/`SD2`/`CSP` cm x cm grammar that governs
every other stainless pot here (`kitchenware-research.md` §2), so the geometry technique
that reconciled all 12 of those capacities cannot be applied to it. Nothing in the record
states diameter, height or capacity either - the name is just "Casserole High Andyman 58122".

⚠ **The price is the one real signal.** KES 34,500 for a casserole, against KES 12,000 for
the WANHUI 24 L `SDI3624` and KES 25,600 for the largest pot in the catalogue (the 71 L
`SDI4545`). Nothing in the Chinese commodity range reaches that price. **A five-digit
article number plus a ~3x price premium is the signature of a European catering-cookware
brand** (Paderno, Pujadas, Bourgeat and Vollrath all number their ranges this way), not of
a Guangdong OEM. That is a hypothesis, not a finding - but it means **do not assume Andyman
is another placeholder Chinese label**, and do not fold it in with the KITCHENWARE/WANHUI
cookware.

No image, no description, no dimensions, no capacity. **Needs the purchase paperwork.**

## 2.13 KINGMA - 1 SKU, archived ✅ **model fully verified**, brand not

The best web result in the pass. **`FY-6` is a real, current, widely-sold model** - a
Hong Kong-style egg-puff / bubble-waffle maker - and a complete manufacturer spec was found:

| Spec | Value |
|---|---|
| Model | **FY-6** |
| Power | **1415 W** |
| Voltage | 220-240 V (110-130 V variant exists) |
| Temperature | 0-250 °C |
| Timer | 0-5 min |
| Plate | 175 x 205 mm, **30 egg holes**, each 25 x 30 x 12 mm |
| Dimensions | 475 x 295 x 305 mm |
| Weight | 7 kg net / 8 kg gross |
| Material | Stainless steel + aluminium plate, 3-layer non-stick |
| Certification | CE |

https://goodloog.en.made-in-china.com/product/twVQmJvruPca/China-2020-Top-Selling-CE-Electric-Egg-Waffle-Making-Machine-110V-220V-Egg-Bubble-Waffle-Maker-Egg-Puff-Machine-Fy-6.html

The supplier is Guangzhou GoodLoog Kitchen Equipment Co., Ltd. A `FY-6G-2` also exists -
the **flip/double** variant, 435 x 350 x 265 mm and 15 kg, same 1415 W:
https://goodloog.en.made-in-china.com/product/hZxJWkmAOYVK/China-Hong-Kong-Commercial-Flip-220V-Machine-Electric-Egg-Puff-Waffle-Maker-Supplier-FY-6G-2-.html

**`FY-6` is a generic OEM designation, not a Kingma model** - GoodLoog and others sell it
unbranded. `"Kingma"` itself returns nothing in catering equipment. So the *product* is
verified and the *brand* is not, exactly as `QC205A` behaved in the Kitchenware pass.

Our record has **no image, no description and no technical specification** - all of which
can now be written from the table above with confidence, once the single/flip question is
settled (our name says just "Egg Waffle Maker", and the stored `model_number` `FY-6` points
to the single).

⚠ **Price flag:** stored KES 95,450 ~ US$740, against a US$50-200 FOB band. That is a wide
spread and worth checking, though the SKU is archived.

## 2.14 SDX - 1 SKU, archived ❌ code unverifiable; ⚠ **the photo does not match the product name**

`brands.json` has an `sdx` row, but it is an empty placeholder: generic boilerplate
description, `logo: null`, `website_url: null`.

`K120RD` and `F120RD` return nothing in catering. Brave's only hits are a William Optics
Fluorostar telescope (`F120RD`) and Getac rugged tablets (`K120`); DuckDuckGo returns an
empty result set for the code; Made-in-China has nothing.

⚠ **The stored photo shows something different from what the record says it is.** The
record is named "SDX **Thermobox** K120RD/F120RD" and filed under category *Food Transport*.
The image is a **large twin-door insulated food-distribution trolley** - blue composite
panels in an aluminium frame, full-height double doors with three hinges each, a stainless
top, and four castors on a welded chassis. That is not a thermobox (a portable insulated
box, like the `HK-REDLINE CPWK090` siblings at 3 GN and 6 GN); it is a European-style
banquet/meal-distribution trolley, the same class as the `EMPERO EMP.BQ1` and
`EMP.MED.S.24-1/3` records already in the catalogue at KES 575,000 and KES 3,041,981.

The `K` / `F` prefix pair on an otherwise identical `120RD` suffix is consistent with a
Scandinavian or German maker distinguishing a chilled from a frozen build, but **no source
was found and this should not be presented as more than an observation.**

Price 0, archived, no description.

**Verdict: proven unverifiable, and the name/photo mismatch should be resolved before this
SKU is ever revived.**

---

# 3. Product reference

| SKU | Name | Brand as stored | Model | Real identity | Confidence |
|---|---|---|---|---|---|
| `IMG/OVE/00214` | Oven Convection Turbo 10 Trays | SKYMSEN (DISCOVERY) | `DISCOVERY 10` | **Skymsen DISCOVERY 10**, Metalúrgica Siemsen, Brazil | **Verified** - first-party spec sheet + product page |
| `IMG/OVE/00215` | Oven Convection Turbo 4 Tray Maxiconv | SKYMSEN (DISCOVERY) | `MAXICONV` | **Skymsen MAXICONV** | **Verified** - first-party spec sheet |
| `IMG/HOT/00244` | Egg Waffle Maker | KINGMA | `FY-6` | Generic OEM HK-style egg-puff maker, 1415 W | **Verified** - full spec, exact code |
| `IMG/DWW/00150` | Glass Rack 49 Compartment | GUANGDONG PERFECT | `JW-49` | 7x7 500x500x100 mm rack; `OEM SHEFFIELD` `JW-` family | **Derived (high)** - 13 siblings + square-number grammar + 690 price grid |
| `IMG/BUF/00145` | Chafing Dish Drop in | HY | `HY-902` | **Duplicate of `IMG/BUF/00037`** (OEM SHEFFIELD) | **Derived (high)** - identical model_number + name + product type |
| `IMG/BUF/00146` | Chafing Dish Oval | HY | `HY-836` | `OEM SHEFFIELD` `HY-8xx` buffet range | **Derived** - `HY-834` sibling |
| `IMS/MEC/01890` | Complete Jug Set for Brushless Blender | NINGBO | `-` | Spare jug for **SHEFFIELD `SHG902`** | **Derived (high)** - sole brushless blender in catalogue |
| `IMG/COF/00098` | Heated Insulated Water Urn 40 L | JANGMEN | `WBB40L` | `OEM SHEFFIELD` `WBB` range; `WBB20L` sibling | **Derived** |
| `IMG/TCW/00363` | Stock Pot 12 Litres | WANHUI | `SDI2525` | Ø250 x 250 mm, 12.27 L brim-full | **Derived (high)** - geometry -2.2 %; ⚠ duplicate of `IMG/TCW/00386` |
| `IMG/TCW/00366` | Casserole 24 Litres | WANHUI | `SDI3624` | Ø360 x 240 mm, 24.43 L brim-full | **Derived (high)** - geometry -1.8 %, photo proportion confirms |
| `IMG/HYS/00190` | Fogging Machine 5 Litre Electric | FOSHAN | `SM5L` | Generic 5 L electric ULV cold fogger | **Derived** - family documented, code unindexed |
| `IMG/HYS/00032` | Insect Killer | MAYSIN | `PJ-FK40` | 40 W (2 x 20 W) grid fly killer | **Unverified** code; ⚠ prose dimensions wrong (§2.10) |
| `IMG/HYS/00283` | Hand Wash Basin Knee Operated | GRACHOO | `HSWM-001` | Wall-mounted knee-operated stainless basin | **Unverified** code; photo confirms type |
| `IMG/HYS/00284` | Hand Wash Basin Wall Mounted | GRACHOO | `HSWM-006` | - | **Unverified** - empty record |
| `IMG/DIS/00144` | Ice Cream Display | OUCBOLL | `LK-1.6BY` | Curved-glass gelato chest cabinet, 18 x GN 1/4 | **Unverified**; ⚠ 3 internal contradictions (§2.1) |
| `IMG/DIS/00145` | Ice Cream Display | OUCBOLL | `LK-1.2DD` | Curved-glass gelato chest cabinet, 12 x GN 1/4 | **Unverified**; ⚠ capacity + temperature (§2.1) |
| `IMG/BUF/00150` | SDX Thermobox | SDX | `K120RD/F120RD` | - nothing found - | **Unverified**; ⚠ photo is a trolley, not a thermobox |
| `IMG/HOT/00281` | Electric Conveyor Toaster | SHINEHO | `H260D` | - nothing found - | **Unverified** - empty record |
| `IMG/TCW/00006` | Casserole High Andyman | ANDYMAN | `58122` | - nothing found - | **Unverified** - unique code grammar, ~3x price |

## 3.1 Stated plainly: what is unverifiable

**Seven SKUs are proven unverifiable and should be recorded as such rather than researched
again:**

`IMG/BUF/00150` (`K120RD/F120RD`), `IMG/HOT/00281` (`H260D`), `IMG/TCW/00006` (`58122`),
`IMG/HYS/00284` (`HSWM-006`), `IMG/HYS/00283` (`HSWM-001`), `IMG/DIS/00144` (`LK-1.6BY`),
`IMG/DIS/00145` (`LK-1.2DD`).

Six of these seven are also **empty or near-empty records** (no description, no technical
specification, and in four cases no price and no image). Four are archived. For those, the
research gap is not the blocker - the supplier paperwork is.

**Where each of the fourteen brand strings actually stands, after this pass:**

| Brand | Verdict |
|---|---|
| **SKYMSEN (DISCOVERY)** | ✅ **Real brand, malformed string.** The company is Skymsen; "Discovery"/"Maxiconv" are its product lines (§1.2) |
| **NINGBO** | ⚠ **Real company, wrong name.** The company is **Ouli** (nbhaichu.com); "Ningbo" is its city (§2.9) |
| **HY** | ❌ **Not a brand** - it is the model prefix of the `OEM SHEFFIELD` buffet range (§1.5) |
| **FOSHAN** | ❌ **A city** (Guangdong) (§1.8) |
| **JANGMEN** | ❌ **A city, misspelt** (Jiangmen, Guangdong) - though an accurate address for the goods (§2.8) |
| **GUANGDONG PERFECT** | ❌ **Province + supplier trade name**; "Perfect" already appears inside three `OEM SHEFFIELD` product names (§1.8) |
| **OUCBOLL** | ❌ **Proven not a company.** Zero results on DuckDuckGo; Brave autocorrects to "OUC bill" (§2.1) |
| **GRACHOO** | ❌ **Proven not a company.** Only personal social-media handles (§2.5) |
| **ANDYMAN** | ❌ **Proven not a cookware brand.** A US bakery and a crypto token trade under it (§2.12) |
| **SHINEHO** | ❌ **Proven unfindable.** Empty result set on DuckDuckGo; not a Made-in-China supplier (§2.11) |
| **MAYSIN** | ❌ **Unfindable** (§2.10) |
| **SDX** | ❌ **Unfindable** in catering; has an empty `brands.json` row (§2.14) |
| **WANHUI** | ⚠ **Unconfirmed - downgraded by this pass.** Zero results on DuckDuckGo and Made-in-China; the whole case rests on one Alibaba listing (§2.2) |
| **KINGMA** | ⚠ **Brand unfindable, but its *model* `FY-6` is fully verified** with a complete manufacturer spec (§2.13) |

So: **one real brand recorded wrongly** (Skymsen), **one real company recorded by its city**
(Ouli), **four place names or code prefixes** (HY, Foshan, Jangmen, Guangdong Perfect), and
**eight strings with no company behind them at all** - of which two (WANHUI, KINGMA) still
attach to identifiable products.

---

# 4. Image sourcing (July 2026)

Downloaded to `C:\Users\jonah.wakahiu\Desktop\ecommerce\products resource\<brand>-images\`.
Every file below was **opened and visually verified**. `REF__` after the SKU marks a file
that is *not* our exact unit.

| File | Pixels | Size | What it is | Source |
|---|---|---|---|---|
| `skymsen-discovery-images\IMG-OVE-00214__spec-sheet.pdf` | - | 3,913 KB | **Skymsen's own print-ready PDF/X spec sheet**, XMP title `DISCOVERY 10`. The §1.2 evidence | https://www.skymsen.com/uploads/produtos/folders/609781_eng.pdf |
| `skymsen-discovery-images\IMG-OVE-00215__spec-sheet.pdf` | - | 1,707 KB | Same, XMP title `MAXICONV` | https://www.skymsen.com/uploads/produtos/folders/661805.pdf |
| `skymsen-discovery-images\IMG-OVE-00214__discovery-10-front.png` | 600x600 | 208 KB | ⚠ below the 800 px bar. Manufacturer render, door open showing 10 tray rails, **Skymsen logo visible** on the top panel. Kept as brand evidence | https://www.skymsen.com/uploads/produtos/fotos/Discovery%2010-%20ME%20(1).png |
| `skymsen-discovery-images\IMG-OVE-00214__discovery-10-angle.png` | 600x600 | 147 KB | ⚠ below bar. Three-quarter render, closed | https://www.skymsen.com/uploads/produtos/fotos/Discovery%2010-%20ME%20(4).png |
| `kingma-images\IMG-HOT-00244__REF__FY-6-goodloog-egg-waffle-maker.jpg` | 750x750 | 105 KB | ⚠ marginally below bar (no larger original exists). Verified: stainless egg-puff maker, hinged twin plates, dial controls. **Exact model `FY-6`** | https://image.made-in-china.com/2f0j00lvKfqYBslbcS/2020-Top-Selling-CE-Electric-Egg-Waffle-Making-Machine-110V-220V-Egg-Bubble-Waffle-Maker-Egg-Puff-Machine-Fy-6.jpg |
| `guangdong-perfect-images\IMG-DWW-00150__REF__49-compartment-rack-bestwin.jpg` | 800x800 | 101 KB | Verified: grey moulded 7x7 = **49-compartment** glass rack, open lattice sides. Correct product; BESTWIN watermark, so reference only | https://image.made-in-china.com/2f0j00BuURJsgyCPrb/49-Compartment-Commercial-Plastic-Dishwashing-Rack-Glass-Storage-Holder.jpg |
| `guangdong-perfect-images\IMG-DWW-00150__REF__49-compartment-rack-eagle.jpg` | 800x800 | 88 KB | Verified: same 7x7 rack, three-quarter view. Faint EAGLE watermark. The 500x500x100 mm source | https://image.made-in-china.com/2f0j00lrIfpJEWOYkZ/Rack-Base-of-Dishwasher-with-49-Compartments.jpg |
| `foshan-images\IMG-HYS-00190__REF__5L-ulv-fogger-yiding-DIFFERENT-CONFIG.jpg` | 1500x1500 | 167 KB | ⚠ **Right category, wrong build.** Verified: 5 L electric ULV cold fogger - but a **rigid grey barrel on a white boat-shaped tank**, where ours is a blue tank with a flexible corrugated hose. Kept only to document the class and the FOB band. Heavily YIDING-watermarked | https://image.made-in-china.com/2f0j00cekRfsQqazoL/5L-Ulv-Fogger-Portable-Ulv-Cold-Nebulizer-Handheld-Disinfection-Sprayer-Fogging-Sprayer-Disinfection-Aerosol-Sprayer-Ulv-Cold-Fogger-Sprayer-Electric-Sprayer.jpg |
| `grachoo-images\IMG-HYS-00283__REF__knee-operated-basin-hikitchen.jpg` | 850x850 | 117 KB | Verified: wall-mounted stainless basin, high splashback, gooseneck spout, soap dispenser, **full-width front knee-push panel**. ⚠ Ours has a **side knee pad** instead - right category, different actuation (§2.5) | https://image.made-in-china.com/2f0j00gkdhZpHWHECU/Commercial-Knee-Pedal-Wall-Mounted-Stainless-Steel-Hand-Wash-Basin.jpg |
| `grachoo-images\IMG-HYS-00283__REF__knee-operated-basin-derich.jpg` | 800x800 | 78 KB | Verified: same type, clean render. Kept mainly because the frame carries the **comparable spec** `400x340x(200+384) mm, SS304/201, 1.0-1.2 mm` (§2.5). DeRich watermark | https://image.made-in-china.com/2f0j00znckHyKrSSpN/Derich-Commercial-Kitchen-Wall-Mounted-Single-Bowl-Hand-Wash-Basin-304-Stainless-Steel-High-Back-One-Hole-Knee-Operated.jpg |
| `ningbo-images\_brand-reference\nbhaichu-site-logo.png` | 160x153 | 6 KB | **Not a product shot** - the "Ouli" wordmark from nbhaichu.com, downloaded to prove it is the same file as `brands/ningbo.png` (§2.9) | https://www.nbhaichu.com/template/en/images/logo.png |

The Made-in-China thumbnail trap was hit and defeated as documented: search results served
`3f2j00…` and `155f0j00…` prefixes at 400-800 px; rewriting to **`2f0j00…`** returned the
originals (the fogger went 800 -> **1500 px** this way).

### Rejected during visual verification - recorded so the mistake is not repeated

- **A third "49-compartment glass rack" file was downloaded and then deleted.** Its
  Made-in-China listing was titled "49 Compartment Glass Rack Extender…" (Jiangmen Goodman)
  and the search result read as a match, but on inspection the photograph shows **three
  green open-frame rack *extenders*** - shallow rings with a handful of large cells - not a
  49-compartment base rack at all. The title was right and the image was not. Exactly the
  failure mode the Kitchenware pass hit with its mason-jar "juice dispenser".
  https://image.made-in-china.com/2f0j00NknvhLbJGTqF/49-Compartment-Glass-Rack-Extender-Glass-Rack-Storage-Glass-Rack-Storage-Dishwashe.jpg
- Two further 5 L ULV fogger files (a second Yiding angle and a Zhengzhou Use Well
  three-nozzle round-tank unit at 800 px) - same category, wrong build, redundant against
  the one kept.
- A Heavybao knee-operated basin file (800 px) - a **marketing collage** with a lifestyle
  inset, Chinese text overlay and a "No touching" strapline rather than product
  photography. Same rejection reason as the ROVSUN banners in the Kitchenware pass.
- A Skymsen `FOTO1361.JPG` at **350 x 350** - far below the usable bar.

## 4.1 Coverage - 5 of 19 SKUs got an image, 6 got usable content

Stated plainly rather than rounded up:

| Outcome | Count | SKUs |
|---|---|---|
| Independent image sourced and verified | **4** | `IMG/OVE/00214`, `IMG/HOT/00244`, `IMG/DWW/00150`, `IMG/HYS/00283` |
| Image sourced but **wrong build** | **1** | `IMG/HYS/00190` (right category, different fogger configuration) |
| Manufacturer **spec sheet** sourced, no separate image | **1** | `IMG/OVE/00215` (the MAXICONV PDF, which contains print-quality renders) |
| **Nothing sourced** | **13** | `IMG/DIS/00144`, `IMG/DIS/00145`, `IMG/TCW/00363`, `IMG/TCW/00366`, `IMG/BUF/00145`, `IMG/BUF/00146`, `IMG/HYS/00284`, `IMG/HYS/00032`, `IMG/COF/00098`, `IMS/MEC/01890`, `IMG/HOT/00281`, `IMG/TCW/00006`, `IMG/BUF/00150` |

Empty brand folders, left in place for the next pass: `oucboll-images`, `wanhui-images`,
`hy-images`, `jangmen-images`, `maysin-images`, `shineho-images`, `andyman-images`,
`sdx-images`. `ningbo-images` contains only a brand-reference logo, not a product shot.

For `IMG/HYS/00032` (MAYSIN) the only Made-in-China matches were **replacement UV tubes**,
not complete fixtures - useful for confirming that 40 W means 2 x 20 W T8, useless as
product photography.

For most of these that is a **deliberate abstention rather than a failure**. Generic
stainless cookware, oval chafing dishes and wall-mounted hand basins are visually
interchangeable across dozens of factories - the Kitchenware pass proved how easily a
wrong file gets attached (it downloaded a "juice dispenser" that turned out to be a
domestic mason-jar drinks dispenser). Attaching a representative photo to `SDI2525` or
`HSWM-001` would look like verification without being it.

For SHINEHO, ANDYMAN and SDX there is nothing to search for at all (§3.1).

**Search-engine state during this pass** - recorded so the next pass does not re-derive it.
Google-backed `WebSearch` **budget was exhausted before this pass began** (200/200), so
everything here ran on `WebFetch`.

| Endpoint | State | Notes |
|---|---|---|
| `html.duckduckgo.com/html/?q=` | ✅ **best general engine available** | Worked reliably for a run of ~6 queries, then served a CAPTCHA. Pace it. Honest about zero-result sets, which is what made the "proven unverifiable" calls in §3.1 possible |
| `made-in-china.com/multi-search/…` | ✅ **the workhorse** | Never blocked. The correct index for this class of goods anyway. ⚠ Fuzzy-matches aggressively - it will happily return steel grades for `H260D`, so read the titles, don't trust the hit count |
| `search.brave.com/search?q=` | ⚠ works, throttles hard | Roughly one query per several minutes before HTTP 429 |
| `marginalia-search.com` | ✅ works | Tiny index, but honest about zero hits |
| `skymsen.com`, `nbhaichu.com`, `image.made-in-china.com` | ✅ direct fetches fine | Including the `folders/*.pdf` spec sheets |
| Bing RSS (`bing.com/search?…&format=rss`) | ❌ **actively misleading** | Returns HTTP 200 and a well-formed feed while **ignoring the query** - `"PJ-FK40"` returned ten Italian articles about Quebec tourism, `"K120RD" thermobox` returned Google Maps pages. It looks like it is working and is not. **Do not trust it.** |
| DuckDuckGo *lite* endpoint | ❌ CAPTCHA | The `/html/` endpoint above works where `/lite/` does not |
| Ecosia, Mojeek, baresearch | ❌ 403 | |
| Yandex | ❌ CAPTCHA | |
| Startpage | ❌ 303 redirect | |
| Global Sources | ❌ empty JS shell | |
| ~6 SearXNG instances | ❌ 429 / 403 / dead / parked domain | searx.be, searxng.site, search.inetol.net, priv.au, paulgo.io, northboot.xyz, searx.work |
| Chrome browser tools | ❌ extension not connected | |

## 4.2 Stored image quality - a separate, catalogue-level problem

Every stored image in this pass is well below current storefront standard, and two are
unusable:

| SKU | Stored image | Pixels |
|---|---|---|
| `IMG/HYS/00190` | fogging machine | **217 x 217** ⚠ |
| `IMG/HYS/00032` | insect killer | **365 x 365** ⚠ |
| `IMG/DIS/00144` | ice cream display | 501 x 501 |
| `IMG/DIS/00145` | ice cream display | 694 x 694 |
| `IMG/BUF/00145`, `00146`, `00150`, `IMG/COF/00098`, `IMG/HYS/00283`, `IMG/TCW/00363`, `00366` | all | 600 x 600 |
| `IMG/DWW/00150`, `IMG/HOT/00281`, `IMG/HOT/00244`, `IMG/TCW/00006`, `IMG/HYS/00284`, `IMS/MEC/01890` | **none** | - |

`IMG/HYS/00190` and `IMG/HYS/00032` are **published** at 217 px and 365 px.

Nothing has been copied into `storage/app/public/products/` and nothing is referenced in
`products.json`. Per `[[feedback_downloads_cleanup]]`, delete source files from the staging
folder once any are adopted.

---

# 5. Recommended changes

Nothing below has been applied. Ordered by value. Per `[[feedback_model_number_unique_id]]`
**no `model_number` change is proposed anywhere in this file.**

## Tier 1 - free wins, no supplier input needed

1. **Reassign `IMG/OVE/00214` and `IMG/OVE/00215` from `SKYMSEN (DISCOVERY)` to `SKYMSEN`**
   (§1.2). Two published products worth KES 1.6 M currently have `brand_id = null`. Proven
   with first-party evidence. Highest value in this file.
2. **Fix the `MAYSIN PJ-FK40` prose dimensions** (§2.10) - the prose says WIDTH 320 /
   HEIGHT 105 and the photograph proves it is WIDTH 105 / HEIGHT 320. ⚠ The numeric fields
   are already correct here; **do not apply the usual swap-the-numerics fix**.
3. **Correct the OUCBOLL temperature range on both published SKUs** (§2.1) - "-2 °C to
   20 °C" should almost certainly be "-2 °C to **-20** °C". Two ice-cream freezers are
   currently advertised as chillers. Confirm with the supplier, but this is close to
   self-evident.
4. **Reassign `IMG/DWW/00150` (`JW-49`) to `OEM SHEFFIELD`** and populate it from its 13
   siblings (§1.4): price **KES 12,420** (690 x 18, on the family's own arithmetic grid),
   dimensions 500 x 500 x 100 mm, plus the missing `image` and `short_description`.
5. **Reassign `IMG/COF/00098` (`WBB40L`) to `OEM SHEFFIELD`** (§2.8), alongside `WBB20L`.
6. **Reassign `IMG/BUF/00145` and `IMG/BUF/00146` to `OEM SHEFFIELD`** (§1.5), alongside
   `HY-834`, `HY-605-1` and `HY 501-2`.
7. **Link `IMS/MEC/01890` to `IMG/FPR/00093` (`SHG902`) as an accessory** (§1.6), and stop
   presenting it as a standalone product under a city name.
8. **Write up `IMG/HOT/00244` (`FY-6`) from the verified spec table** in §2.13 - the record
   currently has no description and no technical specification, and every figure is now
   sourced.
9. **Fix `IMG/FPR/00093`'s numeric width/height transposition** (§1.6) - prose is correct,
   swap the numerics. Not one of the 19, but it is the parent of `IMS/MEC/01890`.
10. **Rename the `ningbo` `brands.json` row to `Ouli`** (§2.9) - the logo and website are
    genuine and already correct; only the name is the city instead of the company.
    ⚠ Changes `/brands/ningbo`, so plan a redirect.

## Tier 2 - data defects to fix regardless of research

11. ⚠ **`IMG/HYS/00283` (`HSWM-001`) is `published` with `price: 0` and `quantity: 0`**
    (§2.5). A published product at KES 0 is a storefront defect.
12. **Resolve the `HY-902` duplicate** (§1.5) - `IMG/BUF/00037` and `IMG/BUF/00145` share a
    `model_number`. If the `HY` record is retired, move its **better photograph** to the
    surviving record first.
13. **Resolve the `SDI2525` / `CSP 2525` duplicate** (§1.7) - carried over from
    `kitchenware-research.md`; the geometry confirms it and the images cannot settle it.
14. **Add the missing `brands.json` rows** for the twelve dangling brands, or - better for
    most of them - reassign the products per Tier 1 so the rows are never needed (§1.1).
    Only WANHUI, GRACHOO, MAYSIN, KINGMA, SHINEHO, ANDYMAN, OUCBOLL and SDX would remain.
15. **Populate WANHUI dimensions from the model codes** (§2.2) - Ø250 x 250 mm and
    Ø360 x 240 mm, in mm, as `kitchenware-research.md` §4.3 proposes for the rest of the
    family.
16. **Apply the `short_description` / `meta_description` split** to these 19 - only the two
    Skymsen ovens have a `meta_description`, and most `short_description` values still end
    "...in Kenya" / "across Kenya" (`[[project_description_field_split]]`).
17. **Re-shoot or re-source `IMG/HYS/00190` (217 px) and `IMG/HYS/00032` (365 px)** (§4.2).
    Both are published.

## Tier 3 - brand-model decisions, need approval

18. **Decide what the placeholder brand names mean going forward.** Five are proven not to
    be manufacturers (OUCBOLL, HY, FOSHAN, GUANGDONG PERFECT, JANGMEN). For FOSHAN,
    GUANGDONG PERFECT and JANGMEN the honest answer is `OEM SHEFFIELD`, whose own
    `brands.json` description already names Guangzhou as the source (§1.3). ⚠ Any brand
    rename or slug change affects storefront URLs.
19. **Do not fold ANDYMAN in with the Chinese cookware** (§2.12). Its five-digit code and
    ~3x price premium point elsewhere. Get the purchase paperwork.
20. **Resolve the `SDX` name/photo mismatch** (§2.14) before that SKU is revived - it is
    named a thermobox and photographed as a distribution trolley.

---

# 6. Open questions for the supplier

1. **OUCBOLL - which cabinet is 256 litres?** Both `LK-1.6BY` (18 pans) and `LK-1.2DD`
   (12 pans) claim it and both cannot be right (§2.1).
2. **OUCBOLL - is the temperature range -2 to -20 °C?** As stored ("-2 to 20 °C") these are
   specified as chillers, not ice-cream cabinets (§2.1).
3. **OUCBOLL - is `LK-1.6BY` a 1.6 m cabinet?** Its model code and its 18-pan capacity both
   say yes; its stored 1390 mm length says 1.4 m (§2.1).
4. **`WBB40L` - is it a dispensing urn or a transport urn?** No tap is visible in the photo,
   unlike every other urn in the catalogue (§2.8).
5. **`HY-902` - are `IMG/BUF/00037` and `IMG/BUF/00145` one product or two?** Nothing in the
   records distinguishes them (§1.5).
6. **`SDI2525` vs `CSP 2525` - one pot or two?** Same diameter, height, capacity and
   category; 15 % apart in price (§1.7).
7. **`SDX K120RD/F120RD` - who makes it, and is it a box or a trolley?** The name and the
   photograph disagree (§2.14).
8. **`ANDYMAN 58122` - what is it, and who made it?** Diameter, height and capacity are all
   absent, and the code fits no grammar in this catalogue (§2.12).
9. **`SHINEHO H260D` - spec sheet needed.** Belt width, throughput, power and single- vs
   double-sided are all unknown (§2.11).
10. **`GRACHOO HSWM-001`/`-006` - prices.** Both are KES 0; one is published (§2.5).
11. **`FY-6` - single or flip?** `FY-6` is the single-plate machine, `FY-6G-2` the flip
    (§2.13).
12. **Price bands** - `FY-6` (KES 95,450 vs US$50-200 FOB) and `SM5L` (KES 65,866 vs
    US$45-79 FOB) are both wide enough to be worth a deliberate look (§2.6, §2.13).
