# Santos research (SAP-led redo, July 2026)

**This file supersedes `database/data/research/old/santos-research.md`.** The old file was
written before the SAP export existed and before the "open every image" rule; its image
list was verified only by HTTP status, several of its conclusions are wrong (see §8), and
its §5/§8 URLs are kept here only as leads that have now been re-checked independently.

Scope: the 11 SANTOS SKUs in `products.json`. Nothing in `products.json` was changed by
this pass - research only.

Staging folder (images + PDFs, not in the repo):
`C:\Users\jonah.wakahiu\Desktop\ecommerce\products resorce final\santos\`

---

## 1. Brand and how its identity keys work

Santos, founded 1954, Vaulx-en-Velin (Lyon), France - address confirmed on every leaflet:
140-150 avenue Roger Salengro, 69120 Vaulx-en-Velin.

Santos identifies products by a **model number**, not a name: #10, #11, #33, #34, #37,
#50, #65, #68, #70. Suffix letters are real, orderable variants, not decoration:

| Suffix | Meaning | Evidence |
|---|---|---|
| `C` | Chrome finish | colour swatch `title="Chrome"` on the #10 / #11 / #33 pages |
| `G` | Grey finish | swatch `title="Grey"` |
| `P` | Pink finish | swatch `title="Pink"` (#11 only) |
| `E` | "Evolution" - adds bowl detection that stops the motor when the jar is lifted | #33 page description; the #33 leaflet exploded view has separate part groups `33 200` and `33 200E` |
| `J` | "Juice bar version" - shipped with a pulp **tube** through the counter instead of the pulp bin | #68 leaflet, panel "Juice bar version #68J" |
| `2I / 2P / 4I / 4P` | #37 jar: 2 L or 4 L, `I` = inox (stainless), `P` = plastic | #37 leaflet exploded view legend |

Our catalogue's trailing `A` (`10A`, `70A`, `11A`, `65A`, `50A`, `34-1A`) is **not** a
Santos code - it is a Sheffield/reseller suffix, same pattern as the Fagor "H" suffix.
But two of our codes are **not** just `A` noise and were misread by the old pass:

- `33EA` = Santos **33E** (Evolution, bowl detection) + our `A`.
- `68JA` = Santos **68J** (juice-bar version with pulp tube) + our `A`.

`model_number` left untouched, per the model-number rule - but the mapping above is what
they mean.

### Axis convention for this brand (established, not assumed)

Santos publishes **D / W / H** with a labelled diagram on every leaflet and on every
product page. Cross-checking those against `products.json` for the six SKUs that already
agreed (10A, 11A, 33EA, 34-1A, 37-A, 70A) shows our schema is:

> **`length` = Santos D (depth) · `width` = Santos W (front width) · `height` = H**

That was then verified *physically*, not just by label matching. Santos names its studio
shots `_A_` (lifestyle), `_D_` and `_G_` (three-quarter), `_F_` (**face** = straight-on
front elevation). Measuring the product bounding box of every `_F_` image and comparing
its aspect ratio to W/H versus D/H picks W/H on 9 of 10 products (the exception is #33,
whose jar handle sticks out sideways). So the front-elevation photos independently confirm
which published number is the width. This is the test that settles §3.2 below.

---

## 2. Sources

Official (primary):

- https://www.santos.fr/en/products/fresh-drinks/juicers/a-levier/10/
- https://www.santos.fr/en/products/fresh-drinks/juicers/classic-citrus-juicer/11/
- https://www.santos.fr/en/products/bar/blenders/bar-blender/33/
- https://www.santos.fr/en/products/bar/others/distributeur/34/
- https://www.santos.fr/en/products/food-preparation/restauration-et-collectivites/blender-de-cuisine/37/
- https://www.santos.fr/en/products/fresh-drinks/juice-extractors/santos-juicer/50/
- https://www.santos.fr/en/products/fresh-drinks/coldpressjuicer/coldpressjuicer/65/
- https://www.santos.fr/en/products/fresh-drinks/juice-extractors/miracle-edition/68/
- https://www.santos.fr/en/products/fresh-drinks/juicers/a-levier/70/

Sales leaflets (per-model PDF, the fullest spec tables):

- https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_10_leaflet_EN.pdf
- https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_11_leaflet_EN.pdf
- https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_33_leaflet_EN.pdf
- https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_34_leaflet_EN.pdf
- https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_37_leaflet_EN.pdf
- https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_50_leaflet_EN.pdf
- https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_65_leaflet_EN.pdf
- https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_68_leaflet_EN.pdf
- https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_70_leaflet_EN.pdf

Also staged: English user manuals (`/media-file/ftp/Users_manuals/EN_English/…`), service
exploded views (`/media-file/ftp/Exploded_views/<model>/…`) and the 2026 general
catalogue - https://www.santos.fr/media/ftp/documents/SANTOS_GENERAL_CATALOGUE_A4_2026.pdf
The full downloads index that lists all of these is
https://www.santos.fr/en/downloads/?zone=general_catalogue

Independent distributors used for corroboration (exact model code appears in the URL or
page body in each case):

- https://www.barstuff.com/slow-juicer-santos-65.html - #65, gives H 64.2 / W 23.6 / D 41.2 cm
- https://extremewellnesssupply.com/products/santos-50-centrifugal-juice-extractor - previous-generation #50, W260 / D470 / H450, 14 kg, 100 l/h, 7.5 L bin, spout 200 mm
- https://www.plantbasedpros.com/product/santos-68j-miracle-edition-juice-extractor-bar-version/ - #68J, confirms the pulp-tube definition
- https://fnbequipment.com.my/santos-68j-centrifugal-juice-extractor-with-pulp-tube-ez-clean-system - #68J

---

## 3. What Santos actually publishes (the numbers to trust)

All in mm, Santos's own D/W/H. `length` in our schema = the D column.

| SKU | Santos model | W | D | H | net kg | motor | headline |
|---|---|---|---|---|---|---|---|
| IMG/FPR/00021 | 10 | 200 | 300 | 380 | 9.2 | 230 W (230 V) / 260 W (115 V) | 30 l/h, spout 135 mm, 1500/1800 rpm |
| IMG/FPR/00230 | 11 | 230 | 300 | 350 | 5.0 | 130 W / 155 W | 30 l/h, spout 125 mm, 3 squeezers |
| IMG/FPR/00022 | 33E | 180 | 180 | 420 | 3.0 | 600 W | 1.25 L jar, 13 000 + 16 000 rpm |
| IMG/BUF/00131 | 34-1 | 190 | 430 | 545 | 15.6 | 160 W (1/5 HP) | 1 x 12 L |
| IMG/BUF/00151 | 34-2 | 380 | 430 | 545 | 23.5 | 260 W (1/3 HP) | 2 x 12 L |
| IMG/BUF/00152 | 34-3 | 570 | 430 | 545 | 30.5 | 330 W (3/7 HP) | 3 x 12 L |
| IMG/FPR/00023 | 37 | 210 | 310 | 560 | 8.96 | 1550 W | 0-15 000 rpm, pulse 18 000 |
| IMG/FPR/00027 | 68J | 320 | 480 | 580 | 26.0 | 1300 W | 180 l/h, spout 228 mm, chute 79.5 mm |
| IMG/FPR/00032 | 70 | 240 | 400 | 490 | 13.4 | 300 W / 350 W | 50 l/h, spout 220 mm |
| IMG/FPR/00229 | 65 | **236** | **412** | 642 | 28.6 | 400 W | 5-80 rpm, 60 l/h, spout 210 mm, 4 L pulp bin |
| IMG/FPR/00174 | 50 (2025 gen) | 290 | 530 | 515 | 15.1 | 800 W | up to 140 l/h, spout 210 mm, 10 L bin |
| IMG/FPR/00174 | 50 (previous gen) | 260 | 470 | 450 | 14.0 | 800 W | 100 l/h, spout 200 mm, 7.5 L bin |

### 3.1 New this pass: the 34-2 and 34-3 finally have dimensions

The old file said the #34 leaflet "only covers the 34-1 column" and left `IMG/BUF/00151`
and `IMG/BUF/00152` with **no dimensions and no wattage**. That is wrong. The current #34
leaflet carries a full three-column table - appliance, shipping box, net weight, packed
weight and motor rating for all three bowl counts - and the product page repeats it. The
numbers are in the table above. Refrigerant is R123yf (charge 60 / 139 / 200 g).

### 3.2 The #65 leaflet transposes W and D - our stored value follows the error

Santos contradicts itself on the Nutrisantos 65:

- Leaflet PDF: `W: 412 mm   D: 236 mm   H: 642 mm`
- Product page: `D: 412 mm   W: 236 mm   H: 642 mm`

The **product page is right, the leaflet is wrong**. Three independent checks:

1. The straight-on front photo (`SANTOS_65_V2_Cold PressJuicer_F_300DPI_LW.jpg`, staged as
   `IMG-FPR-00229__65-santosfr-6.jpg`) measures 197 x 587 px on the product, ratio 0.336.
   236/642 = 0.368; 412/642 = 0.642. The front face is the 236 mm one.
2. barstuff.com, an unrelated German distributor, lists Width 23.6 cm / Depth 41.2 cm.
3. The leaflet's own dimension diagram is drawn from the *side*, so whoever labelled it
   called that view's horizontal extent "W" when it is the depth - which is exactly the
   axis error this catalogue keeps hitting, only this time the manufacturer made it.

`products.json` currently has `length 236 / width 412` for `IMG/FPR/00229`, i.e. it copied
the leaflet's mislabelled table. Correct values would be **length (D) 412 / width 236 /
height 642**. Not applied - dimension edits are a separate approval.

This is the only Santos leaflet where W/D disagree with the product page; #34, #37, #50,
#68 and #70 all match between the two.

### 3.3 Other places Santos contradicts itself (do not treat any single Santos figure as final)

| Model | Field | Leaflet | Product page | Which is right |
|---|---|---|---|---|
| 33E | jar speeds | 13 000 / 16 000 rpm | 12 000 / 16 000 rpm | 13 000 - the page's own description text also says 13 000 |
| 37 | speed | spec box says "1 500 rpm (50Hz) / 1 800 rpm (60 Hz)" | "from 0 to 18 000 rpm" | Neither box is trustworthy. The leaflet's own feature list and its speed chart both say **variable 0-15 000 rpm with an 18 000 rpm pulse**. The "1500/1800 rpm" in the leaflet spec box is a copy-paste from a citrus juicer - #10, #11 and #70 all have exactly that pair. |
| 50 | net weight | 15.1 kg | 14.5 kg | unresolved, 0.6 kg apart |
| 65 | speed | 5-80 rpm | 5-70 rpm | leaflet (5-80) is repeated by every distributor |
| 11 | net weight | 5.0 kg | 4.9 kg | trivial |
| 37 | shipping box | D400 W280 H650 | D390 W275 H650 | trivial |
| 68 | #28 launch year | "1986" on the #68 leaflet | "1991" on the #50 leaflet | marketing copy, ignore |

---

## 4. The #50 problem: our photo and our specs are different machines

`IMG/FPR/00174` is the one genuinely broken SKU.

The #50 has had exactly two generations, per the timeline printed on the #50 leaflet
itself (2001 "The Revolution", 2025 "The Exclusive Edition" - the intermediate entries on
that timeline are the #28 and #68, not #50s; the old research's claim of "at least 4
generations of #50" is a misreading of that graphic).

- `products.json` stores 260 / 450 / 470 and 100 l/h. Those belong to the **previous**
  generation (published as W260 / D470 / H450, 14 kg, 100 l/h, 7.5 L pulp bin, spout
  200 mm) - and even then the three values sit in the wrong fields (see §5).
- `storage/app/public/products/juice-extractor-santos-50a-imgfpr00174.jpg` - the image the
  site actually shows - is unmistakably the **2025 "Exclusive Edition"**: white faceted
  body, black snap-on lid, fold-down drip tray, side-hung 10 L bin. Opened and compared
  against both generations' photos.

So the product page currently pairs a current-generation photo with previous-generation
specs. Someone has to decide which machine Sheffield actually stocks before either the
numbers or the picture can be corrected. Both generations' image sets are staged
(`IMG-FPR-00174__50NEW-santosfr-1..4.jpg` are the current one; the previous generation's
photos are no longer on santos.fr at all - see §7).

---

## 5. Disagreements with SAP

SAP has 68 SANTOS rows; 24 are finished appliances, the rest are spare parts and jar
accessories. Only 11 of those map to our SKUs. Findings:

**5.1 SAP dimensions for SANTOS are mostly unusable.**

| SKU | SAP L/W/H | Santos D/W/H | verdict |
|---|---|---|---|
| 00022 (33E) | 180 / 180 / 420 | 180 / 180 / 420 | agrees (square footprint, so it cannot disagree) |
| 00023 (37) | 303 / 220 / 566 | 310 / 210 / 560 | off by 7 / 10 / 6 mm - right shape, wrong source |
| 00027 (68J) | 580 / 320 / 480 | 480 / 320 / 580 | **L and H swapped** |
| 00174 (50A) | 500 / 315 / 570 | 530 / 290 / 515 (new) or 470 / 260 / 450 (old) | matches neither appliance; it is within ~3% of the *new* #50's **shipping carton** (D484 / W324 / H580), i.e. a carton figure |
| 00229 (65) | 350 / 500 / 30 | 412 / 236 / 642 | **garbage** |
| 00230 (11) | 350 / 500 / 30 | 300 / 230 / 350 | **garbage** |
| 00021, 00032, 00131, 00151, 00152 | 0 / 0 / 0 | - | absent |

`(350, 500, 30)` is boilerplate: 4 rows across the whole SAP export carry that identical
triple, and a 30 mm-tall countertop juicer does not exist. Never let it near
`products.json`.

`IMG/FPR/00031` (model `50CA`, the chrome #50) carries the **identical** 500/315/570 triple
as `IMG/FPR/00174` - the whole-row copy-paste failure mode, and further reason to treat
that number as a carton, not a measurement.

**5.2 SAP contains three duplicate #34 dispenser rows.**

`IMG/BUF/00084` (34-2A), `IMG/BUF/00085` (34-3A) and `IMG/BUF/00086` (34-1A) are older
codes for the same three dispensers as `IMG/BUF/00131` / `00151` / `00152`. Worse,
**00085's Model says `34-3A` but its own Description says "JUICE DISPENSER 2 TANK"** - the
model-contradicts-description failure mode, in SAP, on a row nobody has looked at. Only
the 001xx codes are in `products.json`; the 000xx trio should be checked before anyone
imports SAP rows wholesale.

**5.3 SAP's Model field beats its Description on 00027.**

Description says "JUICE EXTRACTOR CENTRIFUGAL SANTOS 68", Model says `68JA`. The leaflet
proves 68J is a distinct SKU (pulp tube instead of pulp bin), so the Model is the accurate
field and the Description is the lossy one. Our `products.json` name copied the
Description - "Juice Extractor Centrifugal Santos 68" - and the stored photo shows the
plain #68 **with the pulp bin**, not the 68J tube. Either the name/photo or the
model_number is wrong; a supplier can settle it in one question.

**5.4 SAP remarks are reseller marketing copy, not an independent source.**

The 65A remark says "650w" and "5 to 80rpm". Santos says 400 W on both the leaflet and the
product page. 650 W is repeated by several distributors (Zanduco, barstuff) - it is a
propagated reseller error, and SAP inherited it. Same remark also matches
`products.json`'s wording almost verbatim, so SAP and `products.json` agreeing here is
shared lineage, not corroboration.

**5.5 Where SAP is fine.** Stock quantities match `products.json` on all 11 SKUs. The 34-2
and 34-3 remarks quote the correct 23.5 kg / 30.5 kg net weights from the leaflet.

---

## 6. Disagreements with `products.json` (nothing changed - list for a later approval pass)

1. **`IMG/FPR/00027` (68J) dimensions are rotated.** Stored 580 / 320 / 480; should be
   **480 / 320 / 580**. The old research file claims it fixed exactly this in a previous
   pass - it did not land, or it was later overwritten from SAP, which carries the same
   wrong triple.
2. **`IMG/FPR/00229` (65) length and width are swapped.** Stored 236 / 412 / 642; should be
   **412 / 236 / 642**. Caused by trusting the leaflet (§3.2).
3. **`IMG/FPR/00174` (50A) is wrong under either generation** - see §4. If it is the
   previous generation, the fields should be 470 / 260 / 450, not 260 / 450 / 470.
4. **`IMG/BUF/00151` and `IMG/BUF/00152` have no dimensions at all** and can now be filled
   from §3 (380 and 570 mm wide, both 430 deep x 545 high), plus 260 W / 330 W motors and
   23.5 / 30.5 kg.
5. **`IMG/FPR/00023` name** - "Blender Kitchen 2+4 Litres Santos 37A". Santos does not sell
   a 2+4 machine; the #37 base takes *either* a 2 L or a 4 L jar, in stainless or plastic
   (37-2I / 37-2P / 37-4I / 37-4P). Which jar ships with our unit is unknown. Related: SAP
   rows `IMG/FPR/00024`, `00025`, `00165`, `00168` are the loose 2 L and 4 L stainless
   bowls - obvious companion-accessory links for this SKU if they ever enter the catalogue.
6. Finish is undecided on the multi-colour products: #11 exists in green / grey / chrome /
   pink and #33 in green / grey / chrome, and our stored photos do not obviously pin one.
   All finishes are staged so the right one can be picked once stock is known.

---

## 7. Dead ends - do not retry these

- **Higher-resolution images do not exist on santos.fr.** Everything is served through
  `/media/cache/<hash>/<file>`. The `<a href>` in the gallery is the *large* derivative and
  the `<img src>` inside it is the thumbnail; the large one caps at **600 px wide** for
  every single product. The originals are not reachable - `/media/ftp/produits/`,
  `/media/ftp/photos_produits/`, `/media/ftp/images/`, `/media/ftp/Photos/`,
  `/media/ftp/product_images/` and `/media-file/ftp/produits/` all 302 away. 600 px is the
  ceiling; the old research's URL list was the *thumbnail* hashes, which is why it looked
  worse than it is.
- **`/robots.txt` 302s to an empty body.** `/sitemap.xml` works and is complete.
- **`/en/products/3d-view/<n>/` is a dead Flash `.swf`** (`Pictures_360/…/FOBAZoom.swf`).
  No frames to harvest.
- **The `50NEW` product URL from the old file 404s.** The live path is
  `/en/products/fresh-drinks/juice-extractors/santos-juicer/50/`.
- **Previous-generation #50 photos are gone from santos.fr entirely.** If that generation
  turns out to be what we stock, the picture has to come from a distributor.
- **prestigeproducts.com.au lists the #65 as "W: 200 x D: 300 x H: 650mm"** - fabricated
  round numbers, contradicted by Santos and by barstuff. Ignore that page for specs.
- **Reading leaflet PDFs with a page range fails** in this environment (`pdftoppm` missing);
  read the whole PDF with no `pages` argument and it renders fine. `WebFetch` returns
  binary garbage for these PDFs either way.
- **santos.fr renders the COLORS block's labels server-side but the swatch text is empty** -
  the finish names live in the `title=` attribute of `a.color[rel=color_N]`, and the gallery
  `<li rel="color_N">` groups tell you which photos belong to which finish.

---

## 8. What the old research file got wrong

Kept here so nobody re-derives it.

1. It called `10A`, `70A`, `11A`, `33EA`, `37-A`, `65A`, `68JA`, `50A`, `34-1A` all
   "an extra suffix not present in any official source". **33E and 68J are official Santos
   variants**, and getting that wrong is why the 68J's pulp-tube identity was never noticed.
2. It says the #34 leaflet only covers the 1-bowl version, and left the 34-2 / 34-3 SKUs
   with no dimensions and no wattage on that basis. The leaflet covers all three (§3.1).
3. It records the #65 as "D236 x W412 x H642", copying the leaflet's transposed labels
   (§3.2), and that is how `products.json` came to hold the swapped pair.
4. It claims it fixed the 68JA rotation to 480/320/580. `products.json` still holds
   580/320/480.
5. It says the #50 has "at least 4 generations". The leaflet timeline it was reading lists
   #28 (1991) -> #50 (2001) -> #68 (2013) -> #50 (2025); only two of those are #50s.
6. Its §8 image list is the thumbnail derivatives, and none of the images were ever opened -
   "verified HTTP 200" was the whole check.

---

## 9. What is staged

`…\products resorce final\santos\` - 82 images + 29 PDFs, plus `_dossier.json` /
`_DOSSIER.md`.

| SKU | model | images | notes |
|---|---|---|---|
| IMG/BUF/00131 | 34-1 | 4 | 3 studio + 1 lifestyle; **one bowl visible in every shot** |
| IMG/BUF/00151 | 34-2 | 3 | **two bowls** in every shot |
| IMG/BUF/00152 | 34-3 | 2 | **three bowls** in every shot |
| IMG/FPR/00021 | 10 + 10C | 8 | grey base and chrome variant, 4 each |
| IMG/FPR/00022 | 33 / 33G / 33GE / 33C | 13 | green, grey, grey-Evolution, chrome |
| IMG/FPR/00023 | 37 + 37-2I/2P/4I/4P | 16 | 4 lifestyle + 3 per jar variant |
| IMG/FPR/00027 | 68 + 68J | 7 | 68J shots do not show the pulp tube - the photo cannot distinguish 68 from 68J |
| IMG/FPR/00032 | 70 | 4 | |
| IMG/FPR/00174 | 50NEW | 4 | current generation only - see §4 |
| IMG/FPR/00229 | 65 | 6 | includes the front elevation used in §3.2 |
| IMG/FPR/00230 | 11 / 11G / 11C / 11P | 15 | green, grey, chrome, pink |

Filenames are `IMG-XXX-NNNNN__<santos model code>-santosfr-N.jpg`, so the variant code is
in the filename and cannot be lost.

PDFs: `…__<code>-spec.pdf` (sales leaflet), `-manual.pdf` (English user manual),
`-explodedview.pdf` (service parts diagram, where Santos publishes one), plus
`_SANTOS-general-catalogue-2026.pdf` at brand level. The #34 leaflet is one document
covering all three bowl counts, so it is staged three times, once per SKU.

**Verification actually performed on the images**: all 82 were downloaded, MD5-hashed
(82 unique - no placeholder-CDN duplication), measured, tiled into labelled contact sheets
and looked at. Every dispenser's bowl count was counted against its SKU. Nothing was
deleted; no wrong-product images were found on the official galleries, which is expected
since all of them came off the matched model's own page.

---

## 10. Still open

- **Which #50 generation do we stock** (§4). Blocks both the dimensions and the photo.
- **Is `IMG/FPR/00027` a #68 or a #68J** (§5.3). The model_number says 68J, the name and
  the photo say plain 68.
- **Which #37 jar ships** (2 L or 4 L, stainless or plastic) and whether the loose bowls
  should become linked accessories (§6.5).
- **Which finish** the #11 and #33 units are (§6.6).
- **#65 motor: 400 W or 650 W** (§5.4). Santos says 400 W twice; the trade says 650 W.
  Leaning 400 W but worth one supplier question, since it is on the product page.
- **Prices for `IMG/BUF/00151` and `IMG/BUF/00152`** are still `null`. No distributor price
  was found for the 2-bowl or 3-bowl #34.
- The three duplicate SAP dispenser rows `IMG/BUF/00084` / `00085` / `00086` (§5.2) - not
  our SKUs, but they will bite whoever imports SAP next.
