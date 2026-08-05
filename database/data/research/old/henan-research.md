# Henan Product Research

Research notes behind a HENAN enrichment/audit pass on `products.json` (July 2026).
Covers the single HENAN SKU: `IMG/FPR/00212` Root Vegetable Cutting Machine, model
`KL-100-6`, category Vegetable Processors, `status: published`.

**No `products.json` or `brands.json` changes have been applied** - this file is findings
only, same starting point as the Brema/Diqian/Santos/Empero files before a scope decision.

This was expected to be the lowest-yield pass yet, and it was. Unlike Diqian - where the
brand was a dead end but the *model code* cracked the case open - here **both** are dead
ends. `KL-100-6` returns nothing anywhere on the searchable web. What could be established
is the **machine family**, which is a heavily-cloned Chinese commodity design documented by
half a dozen factories, and that family corroborates every number in our record except one.

---

## 1. Brand identification - "Henan" is a Chinese province, not a manufacturer

**There is no "Henan" brand and there never was one.** Henan (河南) is a landlocked
province in central China whose capital, Zhengzhou, is one of the country's largest food-
machinery manufacturing clusters. Effectively every Alibaba / Made-in-China supplier in
that cluster trades as "Henan *Something* Machinery Co., Ltd" or "Zhengzhou *Something*".
The brand row in `brands.json` is a supplier's **address** that got promoted to a brand
name during the original catalogue import.

`brands.json` currently has:

```
slug: henan
name: Henan
description: "HENAN"
logo: brands/henan.png
website_url: null
```

Three independent things confirm this is a placeholder rather than a real principal:

1. **The `description` is literally the brand name shouted back** - `"HENAN"`. It was never
   written. (10 other `brands.json` rows share this all-caps-echo pattern, so this is a
   known class of unfinished import rows, not a one-off.)
2. **`website_url` is `null`** and no candidate exists. There is no company, trademark or
   product line called "Henan" in catering equipment - only companies *located in* Henan.
3. **The "logo" is not a logo.** `storage/app/public/brands/henan.png`
   is a **marketing photo of the machine itself** (14.7 KB, 385x385) - a stainless root-vegetable cutter on a
   splayed leg stand with a wheeled axle, above a three-up panel captioned "Slice blade /
   Stick blade / Cube blade" and a row of slice/stick/cube result photos. It is a cropped
   Alibaba listing image, not a wordmark. Nobody ever had a Henan logo to upload.

### 1.1 What "Henan" searches actually return

Nothing usable, and nothing that could ever become a `website_url`:

- Province-level supplier directories, e.g.
  https://henan.made-in-china.com/suppliers/cutting-machine-892.html - a *geographic filter*
  page listing every cutting-machine supplier in the province.
- Individual Henan-registered factories that happen to sell this class of machine:
  https://www.huafoodmachine.com (Zhengzhou, Henan), https://wmmachinery.com (Zhengzhou
  Wenming Machinery, Henan), https://www.hnunmachinery.com, https://hnlqjx.en.alibaba.com,
  https://henangelgoog.goldsupplier.com. Each is a *different* company. None is "Henan".
- No trademark, no corporate site, no distributor, no datasheet.

**Recommended `brands.json` handling: leave `website_url` as `null`** - there is no correct
value. See §7.1 for the brand-name recommendation itself.

---

## 2. The model code `KL-100-6` - unindexed anywhere on the web

Searching the code was the productive move on the Diqian pass. Here it produced **zero
food-machinery hits on any engine, in English or Chinese.**

Exact-quoted `"KL-100-6"` returns only unrelated products, consistently across engines:
Casio KL-100 label printers, Tach-It / QuickPak KL-100 label dispensers, Knecht/Mahle
KL-100-1 fuel filters, a KUKA KL-100 linear robot axis, a Kirby Lester KL100 pill counter,
a Killion KL-100 extruder. Representative hit set:
https://www.casio.com/us/label-writer/options/option.KL-100/ ,
https://tach-it.com/product/label-dispenser-machine-kl-100/ ,
https://www.kuka.com/en-us/products/robotics-systems/robot-periphery/linear-units/kl-100

Variants tried and equally empty: `KL-100`, `KL100-6`, `"KL-100-6" 切菜机` (vegetable
cutter), `"KL-100" vegetable cutting machine`, `henan "KL-100" vegetable cutting machine`,
`科力 KL-100 多功能切菜机` (guessing 科力/"Keli" as the most likely Chinese source of a
"KL" prefix). Made-in-China's own site search for `KL-100-6` returns nothing.

**Search engines used and their state:** Google-backed WebSearch (worked, budget exhausted
mid-pass), Brave (worked well, then 429/captcha), Made-in-China product + search pages
(fetch fine via WebFetch, 429 via raw curl), Bing web + images (200 OK but JS-only shell,
zero parseable results), DuckDuckGo HTML *and* lite endpoints (silently return an empty
result set - verified with a known-good control query, so treat DDG as blocked, not as
evidence of absence), Mojeek 403, Ecosia 403, Startpage 303, Baidu 302, Alibaba
unreachable.

**Reading:** `KL-100-6` is almost certainly **not a factory model code**. It reads like an
importer's or Sheffield's own internal code - the pattern (`KL` + capacity + variant digit)
is what a trading company invents, and there is no "KL" series anywhere in this machine
class. Per [[feedback_model_number_unique_id]] it is still the record's identity and must
not be changed; it just cannot be used as a research key.

---

## 3. The machine family - this *is* identifiable, and it corroborates the record

Both stored images and the entire stored spec block place this SKU squarely in the
ubiquitous Chinese **single-head root/bulb vegetable cutter** (多功能切菜机 / 球茎类切菜机):
a horizontal cylindrical cutting chamber with a funnel/bowl feed hopper at one end and a
hinged round disc-cover at the other, on a stand, driven by a 1 hp motor, with
interchangeable slice / shred / dice discs.

The clincher is the **stored `description` text**, which is a near-verbatim match for the
standard English translation used across this family:

> "...potatoes, radishes, sweet potatoes, melons, bamboo shoots, onions, eggplants, etc.
> into oblique slices, corrugated slices, silk (strips), diced, shredded, suitable for
> catering enterprises or food processing plants"

That exact sentence, dice sizes and all, appears on the DSS DQC-611 listing:
https://dss-kitchen-machine.en.made-in-china.com/product/MnfrKVRoqUWJ/China-Bulb-Like-Vegetable-Cutter-Potato-Cutting-Machine-Shred-Carrots-Cucumber-Oblique-Slicer.html
and on the Huafood HQC-611 page: https://www.huafoodmachine.com/product/bulb-vegetable-dicing-machine

### 3.1 Six documented siblings vs our record

| Model | Factory / location | Dimensions (mm) | Power | Voltage | Capacity | Weight |
|---|---|---|---|---|---|---|
| **`KL-100-6` (ours)** | unknown | **600 x 500 x 900** | **0.75 kW** | **220 V** | **500-800 kg/h** | **70 kg** |
| FC-312 | Zhaoqing Fengxiang, Guangdong | **600 x 500 x 900** | **0.75 kW (1 hp)** | 220 V | 300-600 kg/h | **70 kg** |
| FC-312A | Zhaoqing Fengxiang, Guangdong | 600 x 500 x 900 | 1 hp | 220 V | 300-600 kg/h | 70 kg |
| HQC-611 | Huafood, **Zhengzhou, Henan** | 750 x 480 x 890 | 0.75 kW | 220 V 1-ph | 300-500 kg/h | 80 kg |
| DQC-611 | Suzhou De Sai Si (DSS), Jiangsu | 750 x 450 x 860 | 0.75 kW | 220 V / 50 Hz 1-ph | 300-500 kg/h | 80 kg |
| SH-100 | Guangdong Shenghui | 760 x 550 x 930 | 0.75 kW | 220 V 1-ph | 300-1000 kg/h | 60 kg |
| YD-G500 | Zhaoqing Yedda, Guangdong | 650 x 490 x 850 | 0.75 kW | 220 V / 380 V | **500-800 kg/h** | 100 kg |

Sources:
https://999fengxiang.en.made-in-china.com/product/oNhnWbJEhcVk/China-FC-312-Multifunctional-Vegetable-Cutter-Asparagus-Cutting-Machine-Beetroot-Cutting-Machine.html
https://www.huafoodmachine.com/product/bulb-vegetable-dicing-machine
https://dss-kitchen-machine.en.made-in-china.com/product/MnfrKVRoqUWJ/China-Bulb-Like-Vegetable-Cutter-Potato-Cutting-Machine-Shred-Carrots-Cucumber-Oblique-Slicer.html
https://shfoodmachinery.en.made-in-china.com/product/WdTaEKpPqGAM/China-Multifunctional-Fruit-Shred-Slice-Dice-Machine-Sweet-Potato-Chip-Making-Machine-Fruit-Cutter-Root-Vegetable-Cutting-Machine.html
https://yeddafoodmachine.en.made-in-china.com/product/XJdrCikxZPYO/China-Industrial-Vegetable-Cutting-Machine-500-800kg-Hour-Capacity.html

**The FC-312 line matches our record exactly on four of five fields** - 600 x 500 x 900 mm,
0.75 kW, 220 V, 70 kg. That is not coincidence; our spec block was taken from an FC-312-class
listing. The cut-size block (dice 8/10/12/15/20 mm, slice 2-20 mm) was taken from a
DQC-611/HQC-611-class listing. The record is a **stitch of two source listings for the same
commodity machine**, which is exactly why no single URL reproduces it.

**No OEM can be named.** FC-312 belongs to Zhaoqing Fengxiang (Guangdong); HQC-611 belongs
to Huafood (Zhengzhou, **Henan** - the only Henan-registered candidate found, and a
tempting but unproven explanation for the brand name). These are competing clones of a
public design, not licensor and licensee. Nothing ties our unit to any one of them, so -
exactly as the Diqian pass declined to point "Diqian" at joy-equipment.com - **no factory
URL should be entered as this brand's `website_url`.**

---

## 4. Per-SKU findings - IMG/FPR/00212, `KL-100-6`

### 4.1 Power plausibility check - **PASS**, no dropped digit

The Diqian pass found an 800 W / 350 degC oven (physically impossible). The same check here
comes back clean.

Stored **0.75 kW** is corroborated by **all six** documented siblings above, without a single
dissenting figure. Sanity-wise it is also right: this is a slow-turning disc cutter shearing
soft root vegetables, not a mill or a pulveriser. 1 hp is the standard rating for the whole
class; throughput is limited by how fast an operator feeds the hopper, not by the motor.
0.75 kW at 220 V is roughly 3.4 A running - comfortable on a normal 13 A socket.

**No change needed to the power figure.**

### 4.2 The one figure that does not hold up - output capacity

Stored **500-800 kg/h** is the optimistic end of the range and is **not** what the
600 x 500 x 900 / 70 kg body is normally rated at:

- FC-312 / FC-312A (identical body, identical motor, identical weight): **300-600 kg/h**
- HQC-611, DQC-611 (larger 750 mm bodies, same motor): **300-500 kg/h**
- SH-100: 300-1000 kg/h (a marketing range, not a rating)
- YD-G500: 500-800 kg/h - but that is a **100 kg** machine, 30 kg heavier than ours

So 500-800 kg/h is a real published figure for *a* machine in this family, just not for
this body size. It is not fabricated and it is not impossible (peak throughput on a
20 mm dice disc with continuous feeding could touch it), but it is a best-case number.

**Recommendation:** soften to **300-600 kg/h** to match the body that our own dimensions and
weight describe, or - if the current figure is retained - qualify it in the copy as
"up to 800 kg/h depending on the disc fitted and how the machine is fed". Do not present
500-800 kg/h as a flat rating. Confirm with the supplier (§8).

### 4.3 Electrical suitability for Kenya - usable, with two things to confirm

Stored: `Voltage: 220 V`. **No frequency, no phase, no plug type is stated anywhere in the
record.**

- **Frequency: fine.** China and Kenya are both **50 Hz**. Every sibling listing that states
  frequency says 220 V / 50 Hz. This should be *added* to the record, not changed.
- **Phase: confirm.** Every sibling that specifies phase says **single phase**, and the
  Shenghui unit's own control-box decal is photographed reading **单相220V** ("single-phase
  220 V", see `REF__SH-100-shenghui-features.jpg`). But Yedda openly offers this machine as
  **220 V or 380 V**, and the larger machines in the class (QC-805 etc.) are routinely
  supplied 380 V three-phase. If the supplier ships the 380 V build it needs a three-phase
  supply, which most Kenyan restaurant kitchens do not have at a prep bench. **Worth an
  explicit confirmation before sale.**
- **Voltage margin: acceptable but at the edge.** Kenya's nominal single-phase supply is
  **240 V**, Chinese motors are nominally **220 V**. A 220 V +/-10% motor tolerates
  198-242 V, so 240 V sits at the top of tolerance; in practice these machines are sold and
  run across the 220-240 V band and Kenyan importers do so routinely. The real risk is a hot
  local supply (245-250 V is not unusual on lightly-loaded feeders), which pushes the motor
  out of tolerance and makes it run hot. Not a blocker - but the record should say
  **"220-240 V / 50 Hz / single phase"** rather than a bare "220 V", which reads to a
  Kenyan buyer like the machine is *not* for their supply.
- **Plug: flag.** Chinese-market units ship with a Type A/I plug. Kenya is **Type G, 13 A**.
  Either the supplier fits a Type G plug or the customer needs one fitted. Nothing in the
  record mentions this.

### 4.4 Dimensions - nothing to swap, because nothing is stored

**There is no width/height axis-swap bug on this record, because the record has no numeric
dimension fields at all.** `length`, `width` and `height` are absent; `600*500*900 (mm)`
exists only inside the prose. Verified by reading the full record, not assumed.

When the numeric fields are populated, the source order is **L x W x H = 600 x 500 x 900**
(consistent across FC-312, HQC-611, DQC-611, SH-100 - all quote the long barrel axis first
and the overall stand height last). The 900 mm height is certain: it is a floor-standing
prep machine on a stand.

⚠ **But this catalogue's own axis convention is not self-consistent**, which is how the swap
bug keeps recurring. Two records in this very category describe the *same* machine
(`QC205A`) with `length` and `width` transposed against each other:

- `IMG/FPR/00177` ASTAR S-QC205: `length: 265, width: 590, height: 540`
- `IMG/FPR/00239` KITCHENWARE QC205A: `length: 590, width: 265, height: 540`

Whichever way 00212 is filled in, **state the axes explicitly in the spec table**
("600 mm (L) x 500 mm (W) x 900 mm (H)") so the next pass does not have to guess. The
ASTAR/KITCHENWARE contradiction above is a separate, real bug worth its own look.

### 4.5 Specs that are corroborated and can stand

Confirmed as normal-and-correct for this family, no change needed:

| Stored | Verdict |
|---|---|
| Dimensions 600 x 500 x 900 mm | **Confirmed** - exact FC-312 match |
| Power 0.75 kW | **Confirmed** - unanimous across 6 siblings |
| Weight 70 kg | **Confirmed** - exact FC-312 match |
| Voltage 220 V | Confirmed, but incomplete - see §4.3 |
| Dice 8 / 10 / 12 / 15 / 20 mm | **Confirmed verbatim** on DQC-611, HQC-611 and SH-100 |
| Slice 2-20 mm (change cutter head) | Confirmed on DQC-611 ("pieces 2-20 mm"); most siblings quote a narrower 2-10 mm |
| Shred 2-10 mm (replace cutter head) | Confirmed on SH-100 (2-10 mm); DQC-611/HQC-611 quote discrete 2/3/4/5/6/8 mm discs |
| Body material 304 stainless | **Confirmed** - stated by every sibling |
| Output 500-800 kg/h | **Optimistic** - see §4.2 |

**Not corroborated anywhere - do not invent, do not delete:**

- **Blade material "molybdenum steel"** and **cutter head "magnesium aluminum alloy"**.
  Neither phrase could be sourced to any listing in this family. The discs are visibly cast
  light alloy with bolted steel blades (`REF__SH-100-shenghui-blades.jpg`,
  `REF__HQC-611-huafood-blade-set.jpg`), so both claims are *consistent with* what the
  photos show - but they are unverified supplier copy. DSS says only "blade original
  imported from Taiwan, all 304 stainless steel", which contradicts "molybdenum steel".
  Leave as-is; do not corroborate.
- **"Sheet thickness 1.5-3 mm"** - no sibling publishes a body gauge. Unverified.
- **Feed-opening size** - not published by any source; our record does not claim one. Do not
  add one.
- **Disc set supplied** - our record does not say how many discs ship with the machine, and
  no sibling listing agrees on this (some ship one disc, some three, most sell discs
  separately). This is a genuine commercial question for the supplier, not a spec to guess.

### 4.6 Content and formatting gaps (independent of any research)

- `description` and `technical_specification` are **byte-for-byte duplicates** of the same
  spec paragraph list - the description carries no actual prose about the machine.
- The description opens with a typo: **"vegatable"**.
- Not in the house **Skymsen pattern** (prose + `<h3>Key Features</h3>` + HTML `<table>`)
  used by every other record in this category; it is a wall of `<p>` lines.
- **No `meta_description`.**
- **No numeric `length`/`width`/`height`** (§4.4).
- `short_description` is generic filler ("Industrial root vegetable cutting machine for
  high-volume processing. Heavy-duty commercial equipment for food processing in Kenya.")
  that names no capacity, no power and no cut types.
- Content that is confirmed and missing: 50 Hz single-phase supply, interchangeable
  slice/shred/dice discs as the core selling point, hinged disc cover with a **safety
  cut-out that stops the machine when the lid is opened** (photographed on the Shenghui
  unit), toolless quick-release latches, wheeled/portable stand.

### 4.7 The two stored images show two different sub-variants ⚠

Worth flagging before anyone treats the brand logo as interchangeable with the product photo:

- `products/root-vegetable-cutting-machine-imgfpr00212.jpg` (600x600) - the machine on a
  **closed rectangular cabinet base** with levelling feet, bowl hopper at the left, orange
  T-handle, round disc cover at the right.
- `brands/henan.png` (385x385) - the same machine on **splayed open legs with a wheeled
  axle** (the FC-312 / HQC-611 / SH-100 configuration), plus a blade panel.

Same machine, two different stands. Neither is wrong, but they are not photos of one unit,
and the brand file is a product photo doing duty as a logo (§1).

---

## 5. Product reference

| SKU | Catalogue name | Model | Manufacturer page | Closest documented sibling | Confidence |
|---|---|---|---|---|---|
| IMG/FPR/00212 | Root Vegetable Cutting Machine | KL-100-6 | **none - code unindexed anywhere (§2)** | FC-312, https://999fengxiang.en.made-in-china.com/product/oNhnWbJEhcVk/China-FC-312-Multifunctional-Vegetable-Cutter-Asparagus-Cutting-Machine-Beetroot-Cutting-Machine.html (exact match on dims/power/weight/voltage) | **Low on the SKU identity; Medium-High on the specs** - the model code and brand are unverifiable, but 5 of 6 stored numbers are independently corroborated by multiple factories building the identical machine |

Family references used (none is our SKU):
https://www.huafoodmachine.com/product/bulb-vegetable-dicing-machine (HQC-611, Zhengzhou Henan)
https://dss-kitchen-machine.en.made-in-china.com/product/MnfrKVRoqUWJ/China-Bulb-Like-Vegetable-Cutter-Potato-Cutting-Machine-Shred-Carrots-Cucumber-Oblique-Slicer.html (DQC-611)
https://shfoodmachinery.en.made-in-china.com/product/WdTaEKpPqGAM/China-Multifunctional-Fruit-Shred-Slice-Dice-Machine-Sweet-Potato-Chip-Making-Machine-Fruit-Cutter-Root-Vegetable-Cutting-Machine.html (SH-100)
https://yeddafoodmachine.en.made-in-china.com/product/XJdrCikxZPYO/China-Industrial-Vegetable-Cutting-Machine-500-800kg-Hour-Capacity.html (YD-G500)
https://vegetable-machine.com/vegetable-cutting-machine/multi-function-vegetable-cutting-machine (QC-801/805/806, larger siblings)
https://wmmachinery.com/products/multifunction-commerical-vegetable-cutting-machine (Zhengzhou Wenming, Henan - belt-fed siblings)

**Price context** (calibration only, not a recommendation): the only published price for this
machine class found in this pass is Zhaoqing Yedda's **US$1,150-1,700** FOB for the
YD-G500 - a slightly larger 100 kg unit at the same 0.75 kW. Our stored price is
**KES 517,500 (~US$4,000)**.

---

## 6. Image sourcing (July 2026) - `products resource/henan-images/`

**14 files, every one prefixed `REF__`.** That prefix is deliberate and applies to the whole
set: because `KL-100-6` cannot be verified as any factory's model, **not one of these images
can be certified as our SKU**. They are all photographs of documented sibling models of the
same commodity design. None should be attached to `IMG/FPR/00212` without a supplier
confirming which sub-variant Sheffield actually stocks (§4.7).

All files were pulled at full size - Made-in-China gallery URLs were upgraded from the
`155f0j00…` / `202f0j00…` thumbnail prefixes to the `2f0j00…` original prefix (400 px ->
1000-1500 px), and the Huafood WordPress files had their `-600x600` suffixes stripped
(600 px -> 790 px). Every file below was opened and visually verified.

| File | Pixels | Size | What it is | Source |
|---|---|---|---|---|
| `REF__DQC-611-dss-render.jpg` | 1500x1500 | 108 KB | **Best storefront-quality candidate.** Clean white-background 3/4 render, no watermark, only a small DSS nameplate decal. Leg-stand variant | https://image.made-in-china.com/2f0j00gpobcukRVaqz/Bulb-Like-Vegetable-Cutter-Potato-Cutting-Machine-Shred-Carrots-Cucumber-Oblique-Slicer.jpg |
| `REF__FC-312-fengxiang-render.jpg` | 800x800 | 134 KB | White-background render of the **exact spec twin** (600x500x900 / 0.75 kW / 70 kg). Heavily FENGXIANG-watermarked - reference only | https://image.made-in-china.com/2f0j00cqQvPlGsCobk/Multifunctional-Potato-Cutter-Cucumber-Cutting-Machine-Beetroot-Cutting-Machine.jpg |
| `REF__SH-100-shenghui-hero.jpg` | 1000x1000 | 101 KB | Marketing hero with cut-result insets, watermarked | https://image.made-in-china.com/2f0j00uhiloZbMCKUf/Multifunctional-Fruit-Shred-Slice-Dice-Machine-Sweet-Potato-Chip-Making-Machine-Fruit-Cutter-Root-Vegetable-Cutting-Machine.jpg |
| `REF__SH-100-shenghui-photo1.jpg` | 1000x1000 | 163 KB | Real outdoor photo of a physical unit, watermarked | https://image.made-in-china.com/2f0j00uWhVqAcLbjfU/Multifunctional-Fruit-Shred-Slice-Dice-Machine-Sweet-Potato-Chip-Making-Machine-Fruit-Cutter-Root-Vegetable-Cutting-Machine.jpg |
| `REF__SH-100-shenghui-photo-4up.jpg` | 1000x1000 | 164 KB | Four angles incl. **disc cover open** showing the cutting chamber | https://image.made-in-china.com/2f0j00HilVqYocasGR/Multifunctional-Fruit-Shred-Slice-Dice-Machine-Sweet-Potato-Chip-Making-Machine-Fruit-Cutter-Root-Vegetable-Cutting-Machine.jpg |
| `REF__SH-100-shenghui-features.jpg` | 1000x1000 | 111 KB | **§4.3 evidence** - close-up of the control box decal reading 单相220V (single-phase 220 V), plus the lid-open safety cut-out | https://image.made-in-china.com/2f0j00DhVWoHkjhKGR/Multifunctional-Fruit-Shred-Slice-Dice-Machine-Sweet-Potato-Chip-Making-Machine-Fruit-Cutter-Root-Vegetable-Cutting-Machine.jpg |
| `REF__SH-100-shenghui-cut-results.jpg` | 1000x1000 | 162 KB | 9-up of slice/shred/dice output, watermarked | https://image.made-in-china.com/2f0j00PVhWkbcIgZRY/Multifunctional-Fruit-Shred-Slice-Dice-Machine-Sweet-Potato-Chip-Making-Machine-Fruit-Cutter-Root-Vegetable-Cutting-Machine.jpg |
| `REF__SH-100-shenghui-blades.jpg` | 1000x1000 | 142 KB | Slicing / shredding / dicing discs paired with their output | https://image.made-in-china.com/2f0j00PViWkKbGgSYR/Multifunctional-Fruit-Shred-Slice-Dice-Machine-Sweet-Potato-Chip-Making-Machine-Fruit-Cutter-Root-Vegetable-Cutting-Machine.jpg |
| `REF__HQC-611-huafood-hero.jpg` | 600x600 | 219 KB | ⚠ **Below the 800 px bar** - kept only as evidence: this is the closest published match to `brands/henan.png`, from the one **Henan-registered** factory found. Watermarked. No larger original exists (verified - `3-1.jpg` at that path is a different machine) | https://www.huafoodmachine.com/wp-content/uploads/2019/03/3-1-600x600-7.jpg |
| `REF__HQC-611-huafood-blade-set.jpg` | 790x638 | 225 KB | Shredding / slicing / cubing knives labelled - matches the blade panel in `brands/henan.png` | https://www.huafoodmachine.com/wp-content/uploads/2019/03/5-5.jpg |
| `REF__HQC-611-huafood-blades.jpg` | 790x476 | 234 KB | Cube and slice discs, close-up | https://www.huafoodmachine.com/wp-content/uploads/2019/03/1-13.jpg |
| `REF__HQC-611-huafood-legs.jpg` | 790x473 | 293 KB | Leg stand and wheeled axle detail | https://www.huafoodmachine.com/wp-content/uploads/2019/03/2-17.jpg |
| `REF__HQC-611-huafood-latch.jpg` | 790x480 | 292 KB | Quick-release latch and hinge detail | https://www.huafoodmachine.com/wp-content/uploads/2019/03/3-14.jpg |
| `REF__HQC-611-huafood-switch.jpg` | 790x483 | 253 KB | Illuminated start/stop switch and bilingual warning plate | https://www.huafoodmachine.com/wp-content/uploads/2019/03/4-9.jpg |

Notes for whoever adopts these:

- **Nothing here is publish-ready except possibly `REF__DQC-611-dss-render.jpg`**, and even
  that pictures the **leg-stand** variant while our stored product photo shows the
  **cabinet-base** variant (§4.7). Attaching it would be a quiet model substitution.
- **The current stored image is small but honest.** `root-vegetable-cutting-machine-imgfpr00212.jpg`
  is only 600x600, which is below what the other reworked categories now carry - but it is
  clean, unwatermarked and shows the cabinet-base unit. No larger copy of that specific
  render was found. Upgrading it needs a photo from the actual supplier, not a swap to a
  sibling model.
- No high-resolution, unwatermarked image of the **cabinet-base** sub-variant was found on
  Made-in-China, Huafood, Fengxiang, Shenghui or DSS. Bing Images and DuckDuckGo were
  blocked, and Alibaba was unreachable, so this is "not found", not "does not exist".
- **Not copied into `storage/app/public/products/`** and **not referenced in
  `products.json`** - staged for review, same as the Brema, Santos and Diqian passes.

### 6.1 Re-examined 27 July 2026 - **no change, and the `REF__` labelling is correct**

This brand was re-opened on 27 July 2026 to check whether the blanket `REF__` prefix had been
applied too cautiously. **It had not. All 14 files keep it, and no file was added.**

The reasoning is unchanged and still holds:

1. **`KL-100-6` remains unindexed** (§2). Nothing can be certified as this SKU's machine
   because no factory publishes the code, so no image can lose the `REF__` prefix without
   inventing an identification.
2. **The blocking problem is §4.7, and it is not a resolution problem.** The two stored
   catalogue images show **two different sub-variants** - one on a **cabinet base**, one on
   **wheeled legs**. Until the supplier says which one Sheffield actually stocks, attaching
   *any* sourced photo is a coin-flip, and a wrong stand is exactly the kind of quiet model
   substitution the Kalerm, Kusina, Sulte and Broaster passes were caught out by. **A
   higher-resolution photo of the wrong stand is worse than no photo**, because it looks
   authoritative.
3. **Resolution is not the bottleneck anyway.** Six of the 14 files are already
   1000 × 1000 or larger, including `REF__DQC-611-dss-render.jpg` at 1500 × 1500 - clean,
   white-background, effectively unwatermarked. If §4.7 were settled tomorrow in favour of
   the leg-stand variant, this brand would be publish-ready that same day with no further
   sourcing.

**Verdict: not "unsourceable" - blocked on a supplier question, not on the web.** The one
concrete gap that a future pass could still close is a high-resolution, unwatermarked photo
of the **cabinet-base** sub-variant, which was not found on Made-in-China, Huafood,
Fengxiang, Shenghui or DSS in either pass. Note that search engines were unavailable on
27 July (WebSearch quota exhausted, and DuckDuckGo / Mojeek / SearxNG / Bing RSS all blocked
or unreliable), so that remains "not found", not "does not exist".

---

## 7. Recommended changes

Nothing below has been applied. Ordered safest-first.

### 7.1 `brands.json` - the brand name itself ⚠ flagged suggestion, not an applied change

**"Henan" should not remain as a customer-facing brand.** It is a Chinese province promoted
to a brand name by a bad import (§1). Showing customers a brand page headed "Henan" with the
body copy "HENAN" and a machine photo for a logo is worse than showing no brand at all.

Three options, in order of preference:

1. **Fold this SKU into the existing `KITCHENWARE` house label** (20 SKUs, already the
   catalogue's de-facto unbranded/house-label bucket - its `brands.json` blurb already
   concedes a Chinese principal, "Wanhui"), and retire the `henan` row. This is the honest
   representation of an unbranded commodity machine and costs one `brand` field change.
   ⚠ Requires approval: it changes a published product's brand, and `brands.json` slugs are
   referenced by storefront URLs (`/brands/henan`), so a redirect may be needed.
2. **Rename to a neutral house label** (e.g. "Sheffield" or "Unbranded") if the goods carry
   no maker's plate at all - which the stored photo suggests, since the only marking visible
   is a generic yellow warning diamond.
3. **Keep `henan` but stop presenting it as a manufacturer** - rewrite `description` to
   something truthful ("Commercial food-preparation machinery sourced from manufacturers in
   Henan province, China"), replace the machine-photo `logo` with `null`, and leave
   `website_url` as `null`. Lowest-risk option; keeps the URL alive.

In **all three** cases: `website_url` stays `null` (§1), and the machine photo must stop
being used as a logo.

### 7.2 `products.json` - IMG/FPR/00212, safe changes

| Field | Now | Recommended | Basis |
|---|---|---|---|
| `length` / `width` / `height` | **absent** | 600 / 500 / 900, axes labelled explicitly in the table | §4.4 |
| Voltage in copy | "220 V" | **"220-240 V / 50 Hz / single phase"** | §4.3 |
| Output | "500-800 kg/h" | **"300-600 kg/h"**, or keep 800 only as a qualified "up to" | §4.2 |
| `meta_description` | **absent** | add | §4.6 |
| `description` | duplicate of spec block, typo "vegatable" | rewrite to the Skymsen pattern: prose + `<h3>Key Features</h3>` + HTML `<table>` | §4.6 |
| `short_description` | generic filler | rewrite naming capacity, cut types, 1 hp / 220-240 V | §4.6 |
| Add to copy | - | interchangeable slice/shred/dice discs; lid-open safety cut-out; toolless latches; 304 stainless body; portable stand; Type G plug note | §4.3, §4.6 |
| `model_number` | `KL-100-6` | **leave exactly as-is** | [[feedback_model_number_unique_id]] |
| `image` | current 600x600 | **leave as-is** - no verified better file exists | §6 |
| `status` | `published` | leave as-is | - |

**Do not touch:** blade material, cutter head material, sheet thickness, weight, or the
dice/slice/shred size lists - all either confirmed or genuinely unverifiable (§4.5).

### 7.3 Separate bug spotted while here

`IMG/FPR/00177` (ASTAR S-QC205) and `IMG/FPR/00239` (KITCHENWARE QC205A) are the same
machine with `length` and `width` transposed against each other (§4.4). Not part of this
pass; worth its own look.

---

## 8. Open questions for the supplier

1. **Who actually makes it?** The unit carries no brand we can find, and `KL-100-6` is not
   any factory's model code (§2). Which factory, and is there a maker's plate on the machine?
2. **Single phase or three phase?** Is the stocked unit the 220-240 V single-phase build or
   the 380 V three-phase one? This decides whether a normal Kenyan prep kitchen can run it
   (§4.3).
3. **Which stand?** Cabinet base (as our product photo) or splayed legs with wheels (as our
   brand "logo")? This decides which photography is usable (§4.7).
4. **What is the real throughput?** Every published figure for a 600x500x900 / 70 kg body in
   this family is 300-600 kg/h, not the 500-800 kg/h we advertise (§4.2).
5. **How many discs ship with the machine?** The record says the cut sizes are achieved by
   "changing the cutter head" but never says which heads are in the box. Discs are usually a
   paid extra in this class.
6. **Does it ship with a Kenyan Type G plug**, or does one need fitting (§4.3)?
