# Santos Product Research

Research notes behind the SANTOS enrichment/audit pass on `products.json` (July 2026).
Covers all 9 SANTOS SKUs, all in the "Juice Processors" category: 2 blenders, 1 cold drink
dispenser, 4 citrus/lever juicers, 1 centrifugal juice extractor, and 1 cold press juicer.

**Every SKU here already had a real description and technical spec before this pass** —
unlike Fagor/Pradeep, this wasn't a build-from-scratch job. Instead this pass is a
**dimension/spec audit against Santos's own official sales leaflets**, and it found a
striking, consistent bug: **on 7 of the 8 SKUs that had dimensions, the stored `width` and
`height` fields were swapped relative to the real appliance** (`length`, i.e. depth, was
always correct). This reads like a systematic data-entry/import bug, not random noise —
worth a wider check across the catalogue beyond just SANTOS (see §5).

---

## 1. Brand identification

**Santos**, founded **1954** by André Fouquet in **Lyon, France**. Started making
professional coffee grinders and cheese graters; today manufactures exclusively
professional juicing, blending and beverage-preparation equipment, still built in its
original Lyon factory ("Handmade in France", "Longtime" durability label). Widely regarded
as the reference brand for professional citrus juicers and juice extractors.

---

## 2. Where to look

| Resource | URL | Value |
|---|---|---|
| Official site | `santos.fr/en/` | Product pages, feature copy |
| Official sales leaflets (PDF, per-model, gold standard) | `santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_{model}_leaflet_EN.pdf` | Full spec table: dimensions, weight, motor, speed, output — **this pass's primary source for every fixed value** |
| Official user manuals | `santos.fr/media/ftp/Users_manuals/EN_English/...` | Confirms model numbers, sometimes bundles two related models in one PDF (e.g. #10 and #70 share a manual) |

**Note on model naming**: none of Santos's own documentation uses an "A" suffix (their
model numbers are plain `10`, `70`, `11`, `33`, `37`, `65`, `68`, `50`, `34-1`) — our
catalogue's `10A`/`70A`/`11A`/`33EA`/`37-A`/`65A`/`68JA`/`50A`/`34-1A` all carry an extra
suffix not present in any official source. This is the same pattern seen with Fagor's "H"
suffix and Sheffield's "PR" codes: likely a reseller/local SKU convention layered on top of
the manufacturer's own code. **Not changed** — flagged only, per
[[feedback_model_number_unique_id]].

### Traps

1. **PDF leaflets don't extract as text via WebFetch** — they come back as raw binary/font
   data. The `Read` tool renders them properly (including the dimension diagrams); use that,
   not WebFetch's text extraction, for every Santos leaflet.
2. **The "#50" model has at least 4 distinct generations** (1991 "the first heavy duty",
   2001 "The Revolution", 2013, and a 2025/2026 redesign "50NEW" — the current leaflet is
   dated 01/2026). Our catalogue's `50A` figures (260×450×470mm, 800W, 100 l/h output)
   don't match the current "50NEW" leaflet (290×530×515mm, 800W, up to 140 l/h) closely
   enough to be confident they're the same generation — power matches, dimensions and
   output don't. **Left unresolved rather than overwritten with the wrong generation's
   numbers** — see §4.7.
3. **Motor wattage sometimes gets cross-contaminated between sibling SKUs**, same as the
   Pradeep milk-boiler bug: the 34-1 (single-bowl) dispenser had the 34-2 (two-bowl)
   motor's wattage, and the 37-A kitchen blender had the unrelated 33 bar-blender's wattage.
   Always check the motor spec against the *specific* variant's own leaflet table, not just
   the general product family.

---

## 3. The width/height swap bug

Comparing every SANTOS SKU's stored `length`/`width`/`height` against its official leaflet
dimensions turned up the same transposition on 7 of 8 dimensioned SKUs: the stored
`width` field actually held the real **height**, and the stored `height` field actually
held the real **depth** (while stored `length`, i.e. depth, actually held the real
**width**). In other words the three axis values were rotated one position. Concretely:

| SKU (model) | Stored (L/W/H) | Official (D/W/H) | Pattern |
|---|---|---|---|
| 00022 (33EA) | 180 / 420 / 180 | 180 / 180 / 420 | W↔H swapped |
| 00023 (37-A) | 210 / 560 / 310 | 310 / 210 / 560 | rotated |
| 00131 (34-1A) | 190 / 545 / 430 | 430 / 190 / 545 | rotated |
| 00021 (10A) | 200 / 380 / 300 | 300 / 200 / 380 | rotated |
| 00027 (68JA) | 320 / 580 / 480 | 480 / 320 / 580 | rotated |
| 00032 (70A) | 240 / 490 / 400 | 400 / 240 / 490 | rotated |
| 00230 (11A) | 300 / 230 / 350 | 300 / 230 / 350 | **matches, no bug** |
| 00229 (65A) | *(no dimensions stored)* | 236 / 412 / 642 | n/a — added, not fixed |

Six SKUs needed the same rotation correction; one (11A) was already correct, which rules
out a single mechanical "always rotate" transform being safe to apply blind — each value
here was individually confirmed against its own official leaflet before being changed, not
inferred from the pattern.

---

## 4. Per-SKU findings

### 4.1 Blender Bar 33EA (IMG/FPR/00022) — dimension fix

Official (`SANTOS_33` product page): D180×W180×H420mm, 3kg net. Motor 600W, 2-speed
12,000/16,000 rpm — **already correct** in our data. Only the width/height swap needed
fixing; added net weight to the spec table.

### 4.2 Blender Kitchen 37-A (IMG/FPR/00023) — dimension + wattage fix ⚠

Official (`SANTOS_37_leaflet_EN.pdf`): D310×W210×H560mm, 8.96kg net. Motor **1550W**,
single-phase 220-240V, variable speed **0–15,000 rpm** (pulse 18,000 rpm). Our stored spec
had **600W and a flat 1800rpm** — both wrong, and 600W happens to be exactly the *other*
Santos blender's (#33) wattage, suggesting a copy-paste mix-up between the two blender
SKUs. Fixed dimensions, wattage, and speed; added weight.

### 4.3 Juice Dispenser 34-1A (IMG/BUF/00131) — dimension + wattage fix ⚠, duplicate line

Official (`SANTOS_34_leaflet_EN.pdf`, 1-bowl "34-1" column): D430×W190×H545mm, 15.6kg net.
Motor **160W (1/5 HP)**. Our stored spec had **260W — which is the 34-2 (two-bowl)
motor's rating**, not the 34-1's. Also had a literal duplicated line
(`"Power(V/Hz) 230V/50H"` appeared twice). Fixed dimensions, wattage, removed the
duplicate line, added weight; kept capacity at 12L (matches).

### 4.4 Citrus Juicer 10A (IMG/FPR/00021) — dimension fix, added wattage

Official (`SANTOS_10_leaflet_EN.pdf`): D300×W200×H380mm, 9.2kg net. Motor 230W
(220-240V) / 260W (100-120V, NSF/UL variant) — our stored spec had no wattage at all.
Speed 1500rpm(50Hz)/1800rpm(60Hz) and output 30 l/h were already correct. Fixed
dimensions, added wattage and weight.

### 4.5 Juice Extractor Centrifugal 68JA (IMG/FPR/00027) — dimension fix + output error ⚠

Official (`SANTOS_68_leaflet_EN.pdf`, "Miracle Edition"): D480×W320×H580mm, 26kg net.
Motor 1300W, 3000rpm(50Hz) — matched. **Output was stored as 140 l/h; official leaflet
states 180 l/h** (stated twice on the leaflet, "High output 180 l/h" and the headline
figure) — fixed. Fixed dimensions, added weight.

### 4.6 Citrus Juicer 70A (IMG/FPR/00032) — dimension fix

Official (`SANTOS_70_leaflet_EN.pdf`, Lever Juicer "Evolution"): D400×W240×H490mm, 13.4kg
net. Motor 300W (220-240V), speed 1500/1800rpm, output 50 l/h — all already correct.
Fixed dimensions, added weight.

### 4.7 Juice Extractor 50A (IMG/FPR/00174) — NOT fixed, generation mismatch ⚠

Official current leaflet ("50NEW", dated 01/2026): W290×D530×H515mm, 15.1kg, 800W,
3000/3600rpm, **up to 140 l/h**. Our stored data: 260×450×470mm, 800W, 3000rpm, **100 l/h**.
Motor wattage and rpm agree, but dimensions and output don't match closely enough to be
confident this is the same generation — Santos's own marketing history shows at least 4
different "#50" generations since 1991 (see §2 trap 2). **Left as-is.** If this needs
resolving later, it would require either a period-correct spec sheet for an older #50
generation, or confirming with the supplier which generation is actually being sold.

### 4.8 Cold Press Juicer Nutrisantos 65A (IMG/FPR/00229) — dimensions added, wattage fixed ⚠

Official (`SANTOS_65_leaflet_EN.pdf`, "Nutrisantos"): D236×W412×H642mm, 28.6kg net. Motor
**400W** (220-240V or 100-120V), variable speed **5–80 rpm**, output 60 l/h. Our stored
spec had **no dimensions at all** and stated **650W**, which is wrong — added dimensions,
corrected wattage to 400W, added speed and output.

### 4.9 Classic Citrus Juicer 11A (IMG/FPR/00230) — no fix needed

Official (`SANTOS_11_leaflet_EN.pdf`): D300×W230×H350mm, 5kg net, motor 130W
(220-240V), 1500/1800rpm, output 30 l/h, spout height 125mm. **Every stored field already
matched** — the only SANTOS SKU with no swap bug and no wrong values. Only needed a
`meta_description`.

---

## 5. Product reference

Official page and leaflet PDF per catalogue SKU, same format as
[[project_sibling_template_repo]]'s Skymsen pass. All leaflets are the primary source used
in §4; none of these product-page URLs use an "A" suffix on the model (see §2).

| SKU | Catalogue name | Model | Official page | Spec leaflet PDF |
|---|---|---|---|---|
| IMG/FPR/00022 | Blender Bar 1.25 Litres Santos 33E | 33 | [bar-blender/33](https://www.santos.fr/en/products/bar/blenders/bar-blender/33/) | [SANTOS_33_leaflet_EN.pdf](https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_33_leaflet_EN.pdf) |
| IMG/FPR/00023 | Blender Kitchen 2+4 Litres Santos 37A | 37 | [blender-de-cuisine/37](https://www.santos.fr/en/products/food-preparation/restauration-et-collectivites/blender-de-cuisine/37/) | [SANTOS_37_leaflet_EN.pdf](https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_37_leaflet_EN.pdf) |
| IMG/BUF/00131 | Juice Dispenser 1 Tank 34-1A Santos | 34-1 | [distributeur/34](https://www.santos.fr/en/products/bar/others/distributeur/34/) | [SANTOS_34_leaflet_EN.pdf](https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_34_leaflet_EN.pdf) |
| IMG/FPR/00021 | Citrus Juicer Santos 10A | 10 | [a-levier/10](https://www.santos.fr/en/products/fresh-drinks/juicers/a-levier/10/) | [SANTOS_10_leaflet_EN.pdf](https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_10_leaflet_EN.pdf) |
| IMG/FPR/00027 | Juice Extractor Centrifugal Santos 68 | 68 | [miracle-edition/68](https://www.santos.fr/en/products/fresh-drinks/juice-extractors/miracle-edition/68/) | [SANTOS_68_leaflet_EN.pdf](https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_68_leaflet_EN.pdf) |
| IMG/FPR/00032 | Citrus Juicer Santos 70A | 70 | [a-levier/70](https://www.santos.fr/en/products/fresh-drinks/juicers/a-levier/70/) | [SANTOS_70_leaflet_EN.pdf](https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_70_leaflet_EN.pdf) |
| IMG/FPR/00174 | Juice Extractor Santos 50A | 50 (⚠ leaflet is "50NEW", generation uncertain - see §4.7) | [santos-juicer/50NEW](https://www.santos.fr/en/products/fresh-drinks/juice-extractors/santos-juicer/50NEW/) | [SANTOS_50_leaflet_EN.pdf](https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_50_leaflet_EN.pdf) |
| IMG/FPR/00229 | Cold Press Juicer Nutrisantos 65 | 65 | [coldpressjuicer/65](https://www.santos.fr/en/products/fresh-drinks/coldpressjuicer/coldpressjuicer/65/) | [SANTOS_65_leaflet_EN.pdf](https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_65_leaflet_EN.pdf) |
| IMG/FPR/00230 | Classic Citrus Juicer 11 | 11 | [classic-citrus-juicer/11](https://www.santos.fr/en/products/fresh-drinks/juicers/classic-citrus-juicer/11/) | [SANTOS_11_leaflet_EN.pdf](https://www.santos.fr/media/ftp/sales_leaflets/EN_english/SANTOS_11_leaflet_EN.pdf) |

All leaflet URLs verified HTTP 200 at time of writing. Product pages were fetched
server-rendered (unlike the PDFs, which need the `Read` tool rather than `WebFetch` - see
§2 trap 1).

---

## 6. Not published / left for a future pass

- **50A's real dimensions/output** — see §4.7, genuinely unresolved rather than guessed.
- **The width/height swap pattern (§3) may exist elsewhere in `products.json`** beyond
  SANTOS — this pass only audited SANTOS's 9 SKUs. Worth a targeted check on other brands
  with dimensioned products if this becomes a recurring theme.
- Weights were added to spec tables where the leaflet gave them, but no `weight` field
  exists in the product schema separate from `technical_specification` — recorded in the
  free-text spec only, consistent with how other brands in this catalogue handle weight.

---

## 7. Summary of `products.json` changes this pass

- **Fixed width/height transposition** on 6 SKUs (00022, 00023, 00131, 00021, 00027, 00032)
  — confirmed individually against each SKU's own official Santos leaflet, not applied as a
  blanket rule (00230 needed no such fix, ruling out blind automation).
- **Fixed wrong motor wattage** on 3 SKUs: 37-A (600W→1550W, was the #33 blender's spec),
  34-1A (260W→160W, was the 34-2's spec), Nutrisantos 65A (650W→400W).
- **Fixed wrong output figure** on 68JA (140 l/h → 180 l/h).
- **Added missing dimensions** to Nutrisantos 65A (had none stored).
- **Removed a duplicated spec line** on 34-1A.
- **Added weight** to every SKU's spec table where the leaflet gave one.
- **Added `meta_description`** to all 9 SKUs (none had one).
- **Left 50A's dimensions/output unresolved** (§4.7) rather than overwrite with an
  unconfirmed generation's numbers.
- **No `model_number` or image fields changed.**

---

## 8. Image sourcing — direct carousel URLs (July 2026)

The product pages in §5 render their gallery/carousel client-side, which made the images hard
to save by hand. Fetched each page and pulled the actual image URLs out of the carousel markup
(all served from `santos.fr/media/cache/<hash>/<filename>`). Several pages carry multiple
product **variants** in one gallery (different jar sizes, bowl counts, or finishes) - noted
below wherever that applies so the wrong variant isn't picked by mistake.

**33EA Blender Bar (IMG/FPR/00022)** - base "33" images only; the page also carries 33C/33G/33GE
variant shots (skip those):
https://www.santos.fr/media/cache/67f33eee613e45d3e2cdf03e3f553b83/SANTOS_33_Mixer_A_low.jpg
https://www.santos.fr/media/cache/b7d2254fc68f82147e18a87a0380be67/SANTOS_33_Mixer_D_hd.jpg
https://www.santos.fr/media/cache/b88edebc8eb9a36ac2137d3f7e5f6a2f/SANTOS_33_Mixer_F_hd.jpg
https://www.santos.fr/media/cache/46fb704ea09b8c26529c9e2b27adce87/SANTOS_33_Mixer_G_hd.jpg

**37-A Blender Kitchen (IMG/FPR/00023)** - page lists 4 jar/finish variants (37-4I, 37-4P, 37-2I,
37-2P); catalogue name says "2+4 Litres" so more than one variant may be relevant:
https://www.santos.fr/media/cache/a641b067a8afb21d0fa66699d3108fbf/SANTOS_37_Blender_A2_hd.jpg
https://www.santos.fr/media/cache/5bbf30fded2f218d7d45cd6ac09ba1d6/SANTOS_37-4I_Blender_D_hd.jpg
https://www.santos.fr/media/cache/e697c7012875b654ccc86a9701af8d3b/SANTOS_37-4I_Blender_F_hd.jpg
https://www.santos.fr/media/cache/2961d81b5e615676e0f69c28af6887b3/SANTOS_37-4I_Blender_G_hd.jpg
https://www.santos.fr/media/cache/3184e748effe22e5619d48b30a3b93b5/SANTOS_37-4P_Blender_D_hd.jpg
https://www.santos.fr/media/cache/247d076c9099cf2e76c388f2a99edf53/SANTOS_37-2I_Blender_D_hd.jpg
https://www.santos.fr/media/cache/3184e748effe22e5619d48b30a3b93b5/SANTOS_37-2P_Blender_D_hd.jpg

**34-1A Juice Dispenser (IMG/BUF/00131)** - 1-tank variant only; page also has 34-2/34-3 (skip):
https://www.santos.fr/media/cache/3b258e490188b5f3b93cbf2b8b86c9f8/SANTOS_34-1_Dispenser_D_hd.jpg
https://www.santos.fr/media/cache/fa710691d9fe024f95de969ac1613076/SANTOS_34-1_Dispenser_F_hd.jpg
https://www.santos.fr/media/cache/01d021350afb8d2a1be6c076c094a395/SANTOS_34-1_Dispenser_G_hd.jpg

**10A Citrus Juicer (IMG/FPR/00021)** - base "10" images; page also has a 10C Compact variant
(skip):
https://www.santos.fr/media/cache/5eef9219aedc98bfae0e66ffc4f008f7/SANTOS_10_Juicer_A3_hd.jpg
https://www.santos.fr/media/cache/aa7990fdde51bed900c41bcd58c0691d/SANTOS_10_Juicer_D_hd.jpg
https://www.santos.fr/media/cache/d6947532e96ac68014996eef6d7da2ac/SANTOS_10_Juicer_F_hd.jpg
https://www.santos.fr/media/cache/0acad75ab07acf53f04404641a447270/SANTOS_10_Juicer_G_hd.jpg

**68JA Centrifugal Extractor (IMG/FPR/00027)**:
https://www.santos.fr/media/cache/262ce82f9f890c1c7cfd576ed6ad319f/SANTOS_68_Juice%20Extractor_A2_hd.jpg
https://www.santos.fr/media/cache/323866e829fda8269de6430563be1b28/SANTOS_68_Juice%20Extractor_D_hd.jpg
https://www.santos.fr/media/cache/01d113a485a7638fcf60fc37de02d36d/SANTOS_68_Juice%20Extractor_F_hd.jpg
https://www.santos.fr/media/cache/022edb99b82dec3d832615ba568be867/SANTOS_68_Juice%20Extractor_G_hd.jpg

**70A Citrus Juicer (IMG/FPR/00032)** - no variant ambiguity on this page:
https://www.santos.fr/media/cache/823d26cfb9b0ff3d28ad4401655f214d/SANTOS_70_JuicerNew_D_low.jpg
https://www.santos.fr/media/cache/7a326ba150f4bc7205d34aaf1dc610ab/SANTOS_70_JuicerNew_F_low.jpg
https://www.santos.fr/media/cache/dfef53f7a3dbbf753a4f26643b624288/SANTOS_70_JuicerNew_G_low.jpg

**50A Juice Extractor (IMG/FPR/00174)** - the §5 product-page URL (`.../santos-juicer/50NEW/`)
now 404s; the working URL is `.../santos-juicer/50/` (same 50NEW-generation photos). Same §4.7
caution applies: these are current-generation photos, and the generation match against our
stored specs is still unconfirmed.
https://www.santos.fr/media/cache/1ba833e495f9ee1be1b4aec3dc617d7d/SANTOS_50NEW_Juicer_A1_LDD.jpg
https://www.santos.fr/media/cache/bfac37a77e63f1fde67d46b7324993d0/SANTOS_50NEW_Juicer_D_LW.jpg
https://www.santos.fr/media/cache/1c99f51911b1f06292b130a57ad758ea/SANTOS_50NEW_Juicer_F_LW.jpg
https://www.santos.fr/media/cache/7c2fdfe47149c04ce72ebd966a8e4bc2/SANTOS_50NEW_Juicer_G_LW.jpg

**65A Cold Press Juicer (IMG/FPR/00229)** - includes a lifestyle/ambiance shot:
https://www.santos.fr/media/cache/05ec5aaad622de523d1b6951683e335f/SANTOS_65_ColdPressJuicer_A8_LDD.jpg
https://www.santos.fr/media/cache/5a244daf39a4fc825dae3601e0e53d6b/SANTOS_65_V2_Cold%20PressJuicer_D_300DPI_LW.jpg
https://www.santos.fr/media/cache/657896fa6ab796fee5c142d6f5062f1e/SANTOS_65_V2_Cold%20PressJuicer_G_300DPI_LW.jpg
https://www.santos.fr/media/cache/2f9f40ca534d820387b0584912c998b6/SANTOS_65_V2_Cold%20PressJuicer_F_300DPI_LW.jpg
https://www.santos.fr/media/cache/e56bc6a7c181ddadfc8cecc26c56826e/SANTOS_65_V2_Cold%20PressJuicer_ambiance_300DPI_LW.jpg

**11A Classic Citrus Juicer (IMG/FPR/00230)** - page carries 4 finishes (plain/G/C/P); pick
whichever matches actual stock:
https://www.santos.fr/media/cache/9cba1c00f9d8b866056dae765a9edb17/SANTOS_11_Juicer_D_low.jpg
https://www.santos.fr/media/cache/d3af5f8c84a56feeb408fec488df6f40/SANTOS_11_Juicer_F_low.jpg
https://www.santos.fr/media/cache/61a097512d8704b16200c29bdf360454/SANTOS_11_Juicer_G_low.jpg

Not yet downloaded/attached to `products.json` - links only, pending a decision on which
variant/finish matches actual stock for the multi-variant pages (37-A, 34-1A, 11A).

---

## 9. New SKUs added: 34-2A and 34-3A dispensers (July 2026)

The 34-1A (`IMG/BUF/00131`, 1 bowl) was already in the catalogue. Added two siblings as separate
single products (not variants of 00131): `IMG/BUF/00151` (34-2A, 2 bowls) and `IMG/BUF/00152`
(34-3A, 3 bowls), matching the `SANTOS_34-2_Dispenser` / `SANTOS_34-3_Dispenser` images already
identified in §8. All three (00131/00151/00152) set to `quantity: 0`.

**Not fabricated for the two new SKUs:**
- **Price** - left `null`. No leaflet or reseller price found for the 2-bowl/3-bowl versions;
  00131's own price (102,713 KES) is the 1-bowl figure and doesn't scale to guess from.
- **Dimensions and wattage** - the §4.3 leaflet only covers the 34-1 column. Only the confirmed
  family-wide feature copy (stainless steel, stirring paddle per bowl, tropical-rated compressor)
  and the 12 L per-bowl capacity (consistent across the 34 family) were carried over.

Needs a price from the supplier before these are ready to sell - currently just catalogue
placeholders with real photos.

---

## 10. Description/spec restructure pass (July 2026) — applied to `products.json`

Reformatted every SANTOS product's `description`/`technical_specification` to match the Skymsen
pattern (prose paragraphs + `<h3>Key Features</h3>` list + HTML `<table>` spec), same as the
HDS and Astar passes. **No data changed in this pass** - §4's leaflet-sourced numbers were
already correct in `products.json` from the original audit; this was purely a format cleanup
(bare `<ul>` specs → tables, bullet-only descriptions → prose + Key Features).

- **33EA, 37-A, 34-1A, 10A, 70A, 11A** - straightforward reformat, all confirmed §4 numbers
  carried over unchanged.
- **68JA** - description also had leftover Quill editor markup (`class="ql-align-justify"`,
  inline `style="color: rgb(68,68,68)"` spans) from a copy-paste; stripped during the rewrite.
- **65A** - already had decent prose; added the `<h3>Key Features</h3>` list and converted the
  mixed `<p>`/`<ul>` spec block into a single table.
- **50A** - reformatted **without** switching to the "50NEW" leaflet's numbers. §4.7's
  generation-mismatch flag still stands; the table keeps our existing stored figures
  (260×450×470mm, 800W, 100 l/h) rather than the unconfirmed newer generation's.
- **34-2A / 34-3A** (new SKUs from §9) - reformatted into the same prose + Key Features shape;
  the spec table still only carries the one confirmed fact (12 L per bowl) - no invented
  dimensions or wattage.
