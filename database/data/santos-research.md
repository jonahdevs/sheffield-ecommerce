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
