# Dr. Coffee Product Research

**Supersedes `old/dr-coffee-research.md`** (July 2026). That pass correctly diagnosed the F11
carton problem from circumstantial evidence; this pass **proves it from Dr.Coffee's own manual**,
and overturns one of its conclusions (the `1500-1700 W` "fake spec"). Read this file.

Pass date: August 2026. Covers all 3 DR. COFFEE SKUs. **Nothing applied to `products.json` or
`brands.json`.**

---

## 1. Brand

**Suzhou Dr.coffee System Technology Co., Ltd.** — Add. No.3, Building No.55 Tianbei Road, New
District, Suzhou, Jiangsu, China 215101; post code 215101; tel +86 512-6731-7782;
https://www.drcoffee.com (the manual's §2.4 Manufacturer information).

| Resource | URL | Value |
|---|---|---|
| **Press/picture library, per model** | https://www.drcoffee.com/p-ocs/f11.html · https://www.drcoffee.com/p-cvs-ho-re-ca/minibar.html · https://www.drcoffee.com/p-accessories/milk-fridge.html | ⭐ Every image is **manufacturer-labelled**, so model attribution comes from Dr.Coffee, not from us |
| **Series F11 Instructions REV4.0** | https://www.drcoffee.com/data/upload/main/20250814/689d43797e0a8.pdf | ⭐ 31 pp, **fully rasterised**. §4.2.2 settles the F11 Big dimensions |
| Spec pages | https://www.drcoffee.com/specifications/f11.html · https://www.drcoffee.com/specifications/minibar.html | Series tables (note: the *standard* variant's numbers) |
| Accessories | https://www.drcoffee.com/accessories/ | Full SC06/SC08/SC10/SC12/SC15/SC05 spec block |
| Distributors used | https://www.kbean.com.au/coffee-machines/dr-coffee-espresso-coffee-machine · https://www.coffeematicmachine.com/products/dr-coffee-f11-big-plus-fully-automatic-coffee-machine/ · https://dr-coffee.cz/en/dr-coffee-f11/ | Independent axis-labelled dimensions, and the carton-field proof |

⚠ **WebSearch was already exhausted (200/200) when this brand started.** Discovery was limited to
the leads already recorded in `old/dr-coffee-research.md` plus direct probing of drcoffee.com's
sitemap. Report this as an outage, not as "no other distributors exist".

**Two access tricks for drcoffee.com's image library**, both worth reusing:
1. Gallery `<img src>` is `/data/watermark/main/…_.jpg`. Drop the trailing `_` **and** swap
   `watermark` → **`upload`** to get the un-watermarked original at the same pixel size. The page's
   own DownLoad anchor does exactly this.
2. The picture library lives at `/p-<category>/<model>.html`, separate from the marketing pages at
   `/<category>/<model>.html`. It is in the sitemap but not obviously linked.

---

## 2. ⭐ IMG/COF/00099 — the F11 BIG carton bug, proven

**Dr.Coffee, Series F11 Instructions REV4.0, §4.2.2 Technical sheet (printed p. 23), column
`F11 / F11 Big`:**

| Dr.Coffee's own header | Value |
|---|---|
| Coffee machine | 220-240 V~ 50/60 Hz **1500-1700 W** |
| **Coffee machine W\*D\*H** | Small Water Tank **30\*50\*58 cm** / **Big Water Tank 41\*50\*58 cm** |
| **Machine N.W** | Small Water Tank 15.5 kg / **Big Water Tank 17 kg** |

The header is labelled **W\*D\*H**, so there is no axis to arbitrate.

> **The F11 Big machine is 410 × 500 × 580 mm (W × D × H), 17 kg net.**
> **620 × 520 × 680 mm is the shipping carton; 23 kg is the gross weight.**

Corroboration, three ways:

1. On the Chinese exporter listing the string `620*520*680mm` sits in a field headed
   **`Transport Package: Seaworthy Carton Box` → `Specification`** — it is the carton field on that
   page too. Our import read a packing spec as a product spec.
   https://www.coffeematicmachine.com/products/dr-coffee-f11-big-plus-fully-automatic-coffee-machine/
2. **SAP contradicts itself**: the Item Remark says `N.W./G.W. 17/23 kg`, the Weight column says
   `23.0`. SAP kept the **gross**. The 17 kg net is Dr.Coffee's Big figure exactly.
3. The carton is a coherent overbox of the machine: +120 mm depth, +110 mm width, +100 mm height.

**`products.json` already stores 410 / 500 / 580 — correct, and now confirmed.** The live risk is
somebody "fixing" it from SAP.

**Correction to the July research:** it listed `1500-1700 W` under "reseller 'ranges' leaking in as
fake specs". It is **Dr.Coffee's own printed figure** in the manual. Our record is right; the
website's flat `1500 W` is the nominal.

Independent, differently-worded confirmation from the Australian distributor, which labels its axes:
*"Dimensions: 410 x 500 x 580mm (w x d x h), Weight: 17 kg"* —
https://www.kbean.com.au/coffee-machines/dr-coffee-espresso-coffee-machine

---

## 3. SAP in this brand: **D/W/H on every row**, Weight contaminated on every row

Order established from SAP alone, before any external source:

- **00097 (SC15)** contradicts itself perfectly: numeric row `512/252/450`, own remark
  `Dimension (W.D.H): 25.2*51.2*45 cm`. Same object, two orders, one record → the row is **D/W/H**.
- **00099 (F11 Big)**: the carton maps as D 620 / W 520 / H 680 — same order.
- **00096 (Minibar)**: `620/520/710`. Its first two values are **identical to 00099's**. The Minibar
  machine is 340 × 545 × 620, so 620 here is not a width — it is 00099's carton depth in the
  Minibar's row. Cross-row contamination.

**Weight reads `23.0` on all three rows** — the F11's gross, copied across. The Minibar's own remark
says 42/47 kg (also wrong, see §5) and the SC15's says 8.5 kg. **SAP's Weight column is unusable for
this brand.**

| SKU | Model | SAP row | What it is | Real machine W×D×H | `products.json` |
|---|---|---|---|---|---|
| 00099 | F11 Big | 620/520/680 · 23 kg | carton + gross weight | **410 × 500 × 580** · 17 kg | 410/500/580 ✔ |
| 00096 | Minibar-S2 | 620/520/710 · 23 kg | 00099's carton D/W + a 710 | **340 × 545 × 620** · 25 kg | 340/545/620 ✔ |
| 00097 | SC15 | 512/252/450 · 23 kg | machine, D/W/H order | **252 × 512 × 450** · 8.5 kg | 252/512/450 ✔ |

All three stored dimension rows are already correct.

---

## 4. IMG/COF/00097 — the SC15 is not a milk fridge, and two of its numbers are the SC10's

Dr.Coffee's own accessories page:

| | **SC15 (ours)** | SC08 | SC10 |
|---|---|---|---|
| Dr.Coffee's name | **electronic refrigerator** | Milk cooler | Milk cooler |
| Power | **40-45 W** | 65 W | 65 W |
| Temperature | **8 °C ~ 18 °C** | 1 °C ~ 5 °C | 1 °C ~ 5 °C |
| Capacity | **15 L** | 8 L | 10 L |
| W×D×H | 25.2 × 51.2 × 45 cm | 24 × 47 × 47.2 cm | 24 × 42 × 61 cm |
| Weight | 8.5 kg | 12 kg | 14 kg |

Our record stores **65 W** and **10 L** — both are the **SC10's**. The SC15 is **40-45 W / 15 L**,
and the model number encodes the 15 L. Every other figure in the record matches Dr.Coffee exactly.

**It also is not a milk fridge.** It holds **8-18 °C**, well above the 1-5 °C its stablemates hold
and above a safe holding temperature for open milk. Dr.Coffee's published accessory schemes are
**F11 + SC08** and **Minibar-S1 + SC10**; the SC15 is in neither. Our catalogue name "Milk Fridge
SC15" is a food-safety claim we should not be making.

---

## 5. IMG/COF/00096 — Minibar-S2, and a 68%-over weight

Confirmed as a **Minibar-S2** visually, not just from SAP's model string: Dr.Coffee's range is
Minibar-S (no wands), Minibar-S1 (hot water wand) and **Minibar-S2 (hot water + steam wand)**, and
only the S2 press shot has two wands on the right cheek.

Against https://www.drcoffee.com/specifications/minibar.html the record is good — 200 cups/day, 4 L,
1500 g hopper, 7" screen, 340 × 545 × 620 all match — with one bad field:

**`42/47 kg` should be `25 kg`.** No machine in the Minibar range is anywhere near 42 kg. This is
the one substantive spec error in the brand.

Also missing: the **2.5 L powder hopper**, which is a real Minibar feature and a genuine
differentiator against the F11.

---

## 6. Imagery

Staged in `products resorce final\dr-coffee\`; ledger in `_sourced.json`, notes in `_FINDINGS.md`.

**Ceiling: 1523 × 757 across the whole Dr.Coffee picture library** — every model, every accessory,
un-watermarked originals included. Short edge **757 px, i.e. 43 under the floor**, and there is
nothing better anywhere: this is the manufacturer's own download size, and every distributor checked
serves smaller. The machine occupies roughly the middle 20-28% of the canvas, so effective subject
height is 520-650 px.

**Every file rendered. No synthetic imagery.**

**Perceptual duplicate sweep** (16×16 ahash → 256×256 greyscale RMS): 18 images, **no shared
photos**. But two pairs shortlisted at Hamming **0** and **2** — the Minibar S / S1 / S2 fronts —
and only the RMS stage (12.60 / 12.58) separated them. **This is the brand where ahash alone would
have produced a false `REPRESENTATIVE-RANGE` tag on three genuinely distinct machine photos.**

| SKU | Files | Of the exact variant | Gap |
|---|---|---|---|
| 00099 F11 Big | 8 + manual | **2** (front, black + silver) | Dr.Coffee publishes **no side or rear view of the Big**; the other 6 are the standard F11, tagged `REPRESENTATIVE` |
| 00096 Minibar-S2 | 5 | **3** (front, left, right) | complete |
| 00097 SC15 | 1 | 1 | only image that exists |

**Documents:** *Series F11 Instructions REV4.0* (31 pp) staged, plus a 230 dpi render of its
technical-sheet page. ⚠ The PDF is **fully rasterised** — `get_text()` returns empty on all 31
pages. There is **no Minibar manual and no SC15 datasheet** anywhere on the site;
`/download-manual/` and `/service-support/` return 11-byte empty bodies.

---

## 7. Recommended changes, in priority order (nothing applied)

1. **`IMG/COF/00096` weight: `42/47 kg` → `25 kg`.** Largest factual error in the brand.
2. **`IMG/COF/00097`: correct `65 W` → `40-45 W` and `10 L` → `15 L`**, and rename
   "Milk Fridge SC15" → **"SC15 Electronic Refrigerator"** (Dr.Coffee's own wording). Keep
   `model_number` `SC15`.
3. **Do NOT overwrite any of the three dimension rows from SAP.** All three are already correct;
   SAP's are the carton (00099), contaminated (00096) and axis-swapped (00097).
4. **Do NOT "correct" `1500-1700 W` on 00099** — it is Dr.Coffee's own figure.
5. **`IMG/COF/00096` `model_number`: `MINIBAR` → `Minibar-S2`** (matches SAP's own model string and
   the photographed two-wand hardware). Unique ID — needs approval.
6. **Add the Minibar's 2.5 L powder hopper** to the copy.
7. **Unhook `IMG/COF/00097` from `IMG/COF/00071`.** A Dr.Coffee 8-18 °C cabinet is parented to a
   *Kalerm* FAO 30. Wrong on both ends — see the Kalerm research.

---

## 8. Sources

https://www.drcoffee.com
https://www.drcoffee.com/sitemap.xml
https://www.drcoffee.com/ocs/f11.html
https://www.drcoffee.com/specifications/f11.html
https://www.drcoffee.com/p-ocs/f11.html
https://www.drcoffee.com/cvs-ho-re-ca/minibar.html
https://www.drcoffee.com/specifications/minibar.html
https://www.drcoffee.com/p-cvs-ho-re-ca/minibar.html
https://www.drcoffee.com/accessories/
https://www.drcoffee.com/p-accessories/milk-fridge.html
https://www.drcoffee.com/data/upload/main/20250814/689d43797e0a8.pdf
https://www.kbean.com.au/coffee-machines/dr-coffee-espresso-coffee-machine
https://www.coffeematicmachine.com/products/dr-coffee-f11-big-plus-fully-automatic-coffee-machine/
https://dr-coffee.cz/en/dr-coffee-f11/
