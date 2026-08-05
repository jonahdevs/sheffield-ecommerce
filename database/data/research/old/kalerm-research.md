# Kalerm Product Research

Research notes behind a KALERM enrichment/audit pass on `products.json` (July 2026).
Covers all 4 KALERM SKUs, all fully-automatic bean-to-cup coffee machines:
Fab 100, Fas 100, FAB50 and Fao 30.

**No `products.json` or `brands.json` changes have been applied** - this file is findings
only, same starting point as the Brema / Dr. Coffee / Santos passes before a scope decision.

Headline: the four `model_number` values are **two different naming systems mixed in one
brand**. `K90L BGS` and `K905 EBGS` are (near-)manufacturer codes; `FAB 50` and `FAO 30`
are a house/reseller convention that appears in **no** Kalerm document anywhere. All four
records' *descriptions* are verbatim Kalerm catalogue spec blocks, so the underlying data
is genuine - but two of the four SKUs carry the **wrong product photo** (§6), the
dimension-field axis order is wrong on three of the four (§4), and every record's
`model_number`/`name` pairing needs a decision before it can be trusted (§3).

---

## 1. Brand identification

**Kalerm** = **Kalerm Technology (Suzhou) Co., Ltd.** (Chinese legal name 苏州咖乐美咖啡机
科技有限公司; its export arm trades on Made-in-China as **Suzhou Industrial Park Kalerm
Electric Appliances Co., Ltd.**). A real, long-established Chinese designer/manufacturer of
fully-automatic coffee machines, Red Dot Design Award winner, exporting to 45+ countries.

- Address: No. 1908, Diamond Road, Xiangcheng District, Suzhou, Jiangsu Province, China.
  Contact export@kalerm.com / +86 512 68180758.
- **`brands.json` `website_url` is currently `null`. The correct value is:**
  https://www.kalerm.com
  Verified live this pass - HTTP 200, English site, current catalogue, working
  `sitemap.xml` (211 URLs). **Recommended `website_url`: `https://www.kalerm.com`.**
- The company also runs a Chinese-market site and formerly ran an English catalogue at
  `o.kalerm.com`. **`o.kalerm.com` is dead** - the DNS record no longer resolves, and the
  Wayback Machine has no snapshot of its product pages (checked via the
  `archive.org/wayback/available` API: `archived_snapshots: {}`). Search engines still
  index fragments of those pages, which is how some spec ranges below were recovered.
- Brand-name casing: the manufacturer styles itself **KALERM** in its wordmark and
  **Kalerm** in body copy. `brands.json` already has `"name": "Kalerm"`, `products.json`
  uses `"brand": "KALERM"` - consistent with the rest of the catalogue. No change needed.

### Where the usable data actually lives

| Resource | URL | Value |
|---|---|---|
| Official site (current lineup) | https://www.kalerm.com | Company data + **current** models only (D/E/M/K95 Plus, A/B home, X/XS/Y/P/O/Z series). **None of our four machines are on it any more.** |
| Official sitemap | https://www.kalerm.com/sitemap.xml | Fastest way to confirm what is/isn't still in the range |
| **Kalerm's own export storefront (gold standard here)** | https://kalerm123.en.made-in-china.com/ | **7 product pages, each with a full factory spec table** - this is the manufacturer speaking, and it still carries K90L, K95L, K1601L, KLM1601, KLM1601Pro, KLM1602, KLM1604 |
| Legacy English catalogue | `o.kalerm.com` | **Dead** - DNS gone, not archived |

### Traps found in this brand

1. **One spec block covers a whole sub-series, expressed as ranges.** The old K90L page
   quoted `511×303×582mm – 511×390×582mm`, `N.W./G.W. 17KG/21KG – 22KG/23KG` and
   `water tank 1.8L/6L`. Those are **two different machines** (with and without the
   side water-tank module), not a tolerance. Same trap as the Dr. Coffee F11 series table.
2. **The `L` suffix is a body change, not a trim level.** Confirmed visually: `K95`
   (`REF__K95-no-side-tank-1500.png`) has **no** left-hand water-tank module; `K95L`
   (`IMG-COF-00074__K95L-left34-1500.png`) has one. The module is what takes the machine
   from ~303 mm to ~390 mm wide and 1.8 L to 6 L. Any width figure near 303 means a
   no-side-tank body; near 390 means the `L`.
3. **The 1601 family and the 90/95 family share a cabinet but not a face.** KLM1601's
   small-LCD-plus-touch-icons fascia appears on both a compact 370 mm-tall body and a
   581 mm-tall commercial body (K1601L). Judging a photo by the fascia alone will pick the
   wrong machine - which is exactly what happened on IMG/COF/00072 (§6).
4. **Nothing about these four is searchable by our names.** "FAB 100", "FAS 100",
   "FAB 50", "FAO 30" return zero Kalerm results in any language. All identification had
   to be done by matching the spec blocks.

---

## 2. What each SKU actually is

Every one of the four `description` fields is a **verbatim Kalerm catalogue spec block**
(same field order, same phrasing: "Capacity of coffee grounds ... portions", "Height of
coffee spout 100~160mm", "Length of power cord", "N.W./G.W."). Matching those blocks
line-by-line against Kalerm's own storefront gives a clean identification:

| SKU | Catalogue name | Stored model_number | **Kalerm's actual model** | Basis |
|---|---|---|---|---|
| IMG/COF/00073 | Automatic Coffee Machine Fab 100 | `K90L BGS` | **K90L** | 2700 W + 6 L + 1000 g + **3.5" colour TFT** - the 3.5" screen is unique to the K90L |
| IMG/COF/00074 | Automatic Coffee Machine Fas 100 | `K905 EBGS` | **K95L** | Same chassis as K90L but **7" touchscreen + Android + 20+ programmable beverages + on-screen advertising**. That is the K95L, exactly |
| IMG/COF/00072 | Automatic Coffee Machine FAB50 | `FAB 50` | **K1601-family, no-side-tank (1.8 L) variant** - the small-tank sibling of the **K1601L** | 1400 W + 19 Bar + 1000 g + 35 portions + 581 mm tall + "integrated housing with big base" |
| IMG/COF/00071 | Automatic Coffee Machine Fao 30 | `FAO 30` | **KLM1601** | Line-for-line match: 1400 W, **19 Bar (two boiler)**, 1.8 L, 250 g, 15 portions, spout **80~140 mm**, 13/15 kg |

The numeric part of the house names tracks **advised cups per day**, which is why the
mapping is so tidy: FAO **30** = the 250 g compact; FAB **50** = the 1400 W commercial;
FAB/FAS **100** = the two 2700 W machines Kalerm rates at 80-100 and 100-120 cups/day.
"FA" almost certainly expands to "Fully Automatic". This is a **local sales-tier naming
scheme**, not a Kalerm one.

### KLM1601 vs its siblings - the discriminator that settles IMG/COF/00071

Kalerm sells three compact machines in the *same 450×302×370 mm shell*. They are separated
by pump pressure and spout travel, and our record matches exactly one of them:

| Model | Pump | Spout height | N.W./G.W. | Cord | Our FAO 30 record |
|---|---|---|---|---|---|
| KLM1601 | **19 Bar (two boiler)** | **80~140 mm** | **13 / 15 kg** | 1.2 m | **19 Bar (two heating systems), 80~140 mm, 13/15 kg** ✔ |
| KLM1602 | 19 bar | 80~115 mm | 15 kg | - | ✗ |
| KLM1604 | **15 Bar** | 80~115 mm (coffee) / 132 mm (milk) | 13 / 15 kg | 1.2 m | ✗ (pressure and spout both wrong) |
| KLM1601Pro | 19 Bar (two boiler) | 80~140 mm | 14 / 17 kg | 1.5 m | ✗ (750 g hopper, 35 portions, barrel-fed) |

This is the same "read the row, not the table" discipline the Dr. Coffee SC15 failed.
**IMG/COF/00071 is a KLM1601** - High confidence.

---

## 3. The name-vs-model_number verdict (per SKU)

Nothing below has been changed. `model_number` is the catalogue's unique ID and is not
touched in a research pass.

### 3.1 IMG/COF/00073 - "Fab 100" vs `K90L BGS` → **`K90L` is the real code; "Fab 100" is local**

`K90L` is a genuine, documented Kalerm model code - it appears on Kalerm's own export
storefront, on the Turkish, Indian, Chilean, Cambodian and Filipino distributor sites, and
in Chinese dealer copy (`咖乐美K90L加大版`, "K90L enlarged version"). "Fab 100" appears
nowhere outside our own catalogue.

**`BGS` could not be resolved.** No Kalerm document, distributor listing or Chinese-market
page uses a `BGS` / `EBGS` suffix. Given that `B`/`G`/`S` sit in the same position on both
of our 2700 W SKUs and only the leading `E` differs, the most economical reading is an
**order-option code** appended by whoever raised the purchase order (bean hopper / grounds
/ steam-milk, with `E` marking the electronic-Android front end on the K95L). **Low
confidence - flagged, not asserted.** The safe interpretation is: the model is the
**K90L**, and `BGS` is a configuration suffix that should be preserved rather than
explained.

### 3.2 IMG/COF/00074 - "Fas 100" vs `K905 EBGS` → **the machine is a `K95L`; `K905` is not a Kalerm code**

This is the clearest problem of the four. **There is no Kalerm model "K905"** - not on
kalerm.com, not on Kalerm's export storefront, not in any distributor catalogue in any
language. Every feature in the record - 7" LCD Android touchscreen, 20+ programmable
beverages, programmable promotional video, 1000 g hopper, tap-water connection with
optional 6 L tank, 2700 W, 19 Bar - is the **K95L** feature list, verbatim, and the
catalogue photo is unmistakably a K95L (§6).

`K905` reads as a transcription slip for `K95L` (the `L` becoming a `5`, or a digit
transposed). **Recommendation: `model_number` should read `K95L EBGS` (or plain `K95L`),
pending confirmation from the supplier's own paperwork.** Do not apply without approval -
this is a change to the unique ID.

### 3.3 IMG/COF/00072 - "FAB50" vs `FAB 50` → **self-consistent, but neither is a Kalerm code**

The record is internally consistent (name and model_number agree), and that consistency is
the problem: **`FAB 50` is the house name, stored as if it were the manufacturer's part
number.** Kalerm has no FAB series. The machine is the 1.8 L / no-side-tank member of the
**K1601L** family - see §5.3 for why the exact Kalerm code could not be pinned down.

### 3.4 IMG/COF/00071 - "Fao 30" vs `FAO 30` → **same situation; the machine is a `KLM1601`**

Self-consistent, and again both values are the house name. The machine is a **KLM1601**
(§2). Of the four, this is the one where the correct manufacturer code is known with
**High confidence** and could be applied cleanly if the decision is made to switch to
manufacturer codes.

### Summary

| SKU | Name says | model_number says | Which is Kalerm's? | Verdict |
|---|---|---|---|---|
| 00073 | Fab 100 | K90L BGS | **model_number** (`K90L`) | Name is the local sales tier (100 cups/day). Code is right. |
| 00074 | Fas 100 | K905 EBGS | **neither, exactly** - machine is `K95L` | `K905` is a corrupted `K95L`. Highest-priority flag. |
| 00072 | FAB50 | FAB 50 | **neither** - K1601-family, 1.8 L variant | House name in the model_number field |
| 00071 | Fao 30 | FAO 30 | **neither** - machine is `KLM1601` | House name in the model_number field |

So the two "disagreeing" SKUs are actually the *better-documented* pair: their
`model_number` carries real Kalerm codes and only the `name` is local. The two
"self-consistent" SKUs are self-consistently **wrong** - both fields hold the house name
and the manufacturer code is absent from the record entirely.

---

## 4. Dimensions - the axis check, per SKU

The convention used elsewhere in this catalogue (established in the Brema pass, and
re-confirmed by the Nuova Simonelli Microbar II record that sits directly above the Kalerm
block in `products.json`) is:

> `length` = frontal **width** · `width` = **depth** · `height` = **height**

Kalerm publishes its own figures as **L × W × H meaning depth × width × height** - the
opposite leading axis. Note the difference from Santos/Brema/Dr. Coffee: here the
`technical_specification` prose is **not** an independently-transcribed labelled table, it
is the same bare `NNNxNNNxNNN` string as the numeric fields, so **there is no
prose-vs-numeric contradiction to arbitrate.** The manufacturer's own figures are the only
arbiter.

| SKU | Stored `length`/`width`/`height` | Prose string | Real machine (W × D × H) | Verdict |
|---|---|---|---|---|
| 00073 (K90L) | 511 / **403** / 582 | `511X403X582mm` | **390 × 511 × 582** | ✗ **`length` and `width` swapped**; middle figure also 13 mm off (403 vs 390) |
| 00074 (K95L) | 511 / **403** / 582 | `511X403X582mm` | **390 × 511 × 582** | ✗ same swap, same 403 |
| 00072 (FAB 50) | 303 / 506 / 581 | `303X506X581mm` | **303 × 506 × 581** | ✔ **no swap** - this one is already in W × D × H order |
| 00071 (KLM1601) | **370** / 302 / **450** | `370X302X450mm` | **302 × 450 × 370** | ✗ **string is fully reversed**: `length` holds the height, `height` holds the depth |

Two things worth calling out:

- **The swap is present on three of four and absent on one** - the same per-SKU
  inconsistency documented on Santos (7 of 8), Brema (2 of 5) and Empero. It has to be
  checked record by record; it cannot be assumed.
- **IMG/COF/00071 is the worst of the four.** Its stored `height: 450` implies a
  450 mm-tall machine; the KLM1601 is **370 mm** tall. Anyone sizing a counter or a
  cabinet from that field would be 80 mm out.
- **The `403` on both 2700 W SKUs is unexplained.** Kalerm's own figure for both the K90L
  and the K95L is **390**. 403 is not the K90 non-L width (303) either. It may be a
  measurement over the drip-tray trim, or simply a bad transcription. Flagged as Medium
  confidence; recommend 390 (manufacturer's own number).

---

## 5. Per-SKU spec comparison

All "Kalerm" columns below are from the manufacturer's own export storefront pages, which
are the only surviving primary source for these models.

### 5.1 IMG/COF/00073 - Fab 100 / K90L BGS

Source: https://kalerm123.en.made-in-china.com/product/RSLxoOgMgmfe/China-Horeca-Fully-Automatic-Coffee-Machine.html

| Field | Stored | Kalerm K90L | Verdict |
|---|---|---|---|
| Voltage / frequency | 220-240 V / 50-60 Hz | 220-240 V / 50-60 Hz | ✔ |
| Heating power | 2700 W | 2700 W | ✔ |
| Pump pressure | 19 Bar | 19 Bar | ✔ |
| Water tank | 6 L / tap water | 6 L, tap-water connection available | ✔ |
| Bean container | 1000 g | 1000 g | ✔ |
| Grounds container | 30-35 portions | 35 portions | ≈ (state 35) |
| Waste-water tray | 2 L | 2 L | ✔ |
| Coffee spout height | 100~160 mm | **105~165 mm** | ✗ |
| Power cord | 1.8 m | **1.5 m** | ✗ |
| Net / gross weight | 18.5 / 23 kg | **19 / 23 kg** | ✗ (minor) |
| Dimensions | 511 × 403 × 582 | **511 × 390 × 582** (Kalerm's L×W×H) | ✗ (§4) |
| Display | 3.5" colour TFT touch screen | 3.5" colour TFT **with touch buttons** | ⚠ see below |
| Advised output | *absent* | **80-100 cups/day** | add |
| Milk system | double coffee + milk outlets, one-touch two lattes | removable milk-foam unit, two-cup | ✔ |
| Brew chamber | *absent* | variable 8-14 g (Medium confidence - from the indexed remains of the dead `o.kalerm.com` K90L page, not re-verifiable) | optional add |

⚠ **"3.5" Color TFT touch screen" overstates the interface.** Kalerm's own wording is a
3.5" colour TFT display *surrounded by touch buttons*, and the product photography
confirms it: a small central screen with six drink icons and two hard keys either side
(`IMG-COF-00073__K90L-front-800.jpg`). It is not a touchscreen menu like the K95L's. Worth
rewording, because it is also the single feature that distinguishes this SKU from
IMG/COF/00074 - which currently costs KES 84k more for what the copy implies is the same
interface.

### 5.2 IMG/COF/00074 - Fas 100 / K905 EBGS

Source: https://kalerm123.en.made-in-china.com/product/cSGxqXhFkBps/China-Automatic-Coffee-Machine-for-Big-Office.html

| Field | Stored | Kalerm K95L | Verdict |
|---|---|---|---|
| Voltage / frequency | 220-240 V / 50-60 Hz | 220-240 V / 50-60 Hz | ✔ |
| Heating power | 2700 W | 2700 W | ✔ |
| Pump pressure | 19 Bar | 19 Bar (two boilers) | ✔ |
| Water tank | 6 L / tap water | 6 L + tap-water connection | ✔ |
| Bean container | 1000 g | 1000 g | ✔ |
| Grounds container | 30-35 portions | 35 portions | ≈ |
| Waste-water tray | 2 L | 2 L | ✔ |
| Coffee spout height | 100~160 mm | **105~165 mm** | ✗ |
| Power cord | 1.8 m | **1.5 m** | ✗ |
| Net / gross weight | 18.5 / 23 kg | **19 / 23 kg** | ✗ (minor) |
| Dimensions | 511 × 403 × 582 | **511 × 390 × 582** | ✗ (§4) |
| Display | 7" LCD touch screen, Android | 7" colour touchscreen, Android | ✔ |
| Beverages | 20+ programmable, customisable | "up to 20 tasty coffee variations", customisable strength | ✔ |
| Promotional video | programmable video for brand promotion | (Android front end; MDB payment port optional) | ✔ plausible, Medium confidence |
| Advised output | *absent* | **100-120 cups/day** | add |
| Milk system | coffee + milk/foam simultaneously | detachable dual-spout milk frother | ✔ |

**On the "specs copy-pasted across siblings" bug:** 00073 and 00074 do carry byte-identical
dimensions, weights, cord length and spout range. Normally that is the signature of the
bug - but here **Kalerm's own figures for the K90L and K95L are also identical** (same
cabinet, same 19/23 kg, same 511×390×582). So this is a genuine shared chassis, *not*
contamination. What it does prove is that both records came from **one source, and that
source was wrong in the same four places on both** - so the 403 / 18.5 kg / 1.8 m /
100-160 mm cluster is a single bad transcription, not four independent measurement errors.

### 5.3 IMG/COF/00072 - FAB50

Closest documented sibling: **K1601L**, https://kalerm123.en.made-in-china.com/product/mvLQeIPrRnto/China-Fully-Automatic-Coffee-Machine-for-Office-Use.html

| Field | Stored (FAB 50) | Kalerm K1601L | Reading |
|---|---|---|---|
| Voltage / frequency | 220-240 V / 50-60 Hz | 220-240 V / 50-60 Hz | ✔ |
| Heating power | 1400 W | 1400 W | ✔ |
| Pump pressure | 19 Bar (two heating systems) | 19 Bar | ✔ |
| **Water tank** | **1.8 L / water barrel** | **6 L / water barrel** | the variant difference |
| Bean container | 1000 g | 1000 g | ✔ |
| Grounds container | 35 portions | 30 portions | minor |
| Waste-water tray | 2 L | 2 L | ✔ |
| Coffee spout height | 100~160 mm | 105~165 mm | ✗ (same drift as §5.1/5.2) |
| Power cord | 1.8 m | 1.5 m | ✗ (same drift) |
| Net / gross weight | **15.5 / 20 kg** | **17 / 22 kg** | the variant difference |
| **Dimensions** | **303 × 506 × 581** | **506 × 391 × 581** (Kalerm's L×W×H → 391 W × 506 D × 581 H) | the variant difference |
| Advised output | *absent* | 60-80 cups/day | (K1601L figure; our variant will be lower) |
| Milk system | new milk-foam unit, double milk spouts | removable milk frother unit | ✔ |
| Housing | integrated housing with big base | integrated basement with large grounds tank | ✔ |

**Reading:** every difference between our record and the K1601L is the *same* difference -
smaller tank, narrower body, lighter. That is precisely the `L` / non-`L` split proven
visually in §1 trap 2 and quantified on the old K90L page (`1.8L/6L`,
`511×303×582 – 511×390×582`, `17/21 – 22/23 kg`). **Our FAB 50 is the base, no-side-tank
member of that family and the K1601L is the large-tank one.** The record took the low end
of every range; Kalerm's storefront quotes the high end.

**The exact Kalerm code for the base variant could not be established.** Kalerm's export
storefront carries only 7 products and lists only the `K1601L`; kalerm.com has retired the
whole 1601 line; `o.kalerm.com` is dead and unarchived; Kaapi Machines' Kalerm pages
(`/kalerm-1601-pro/`, `/kalerm-1604/`, `/kalerm-2601-pro/`) all 404; Alibaba and
`roundtheclockmall` returned 403 to every user-agent tried. **`K1601` is the obvious
inference by symmetry with `K90` / `K90L` and `K95` / `K95L`, but it is unconfirmed -
Low confidence, and it should not be written into `model_number` on that basis.**

### 5.4 IMG/COF/00071 - Fao 30

Source: https://kalerm123.en.made-in-china.com/product/zXnmEyUOsprk/China-Fully-Automatic-One-Touch-Cappuccino-Coffee-Machine.html

| Field | Stored | Kalerm KLM1601 | Verdict |
|---|---|---|---|
| Voltage / frequency | 220-240 V / 50-60 Hz | 220-240 V / 50-60 Hz | ✔ |
| Heating power | 1400 W | 1400 W | ✔ |
| Pump pressure | 19 Bar (two heating systems) | 19 Bar (two boiler) | ✔ |
| Water tank | 1.8 L | 1.8 L | ✔ |
| Bean container | 250 g | 250 g | ✔ |
| Grounds container | 15 portions | 15 portions | ✔ |
| Coffee spout height | 80~140 mm | 80~140 mm | ✔ |
| Power cord | 1.5 m | **1.2 m** | ✗ |
| Net / gross weight | 13 / 15 kg | 13 / 15 kg | ✔ |
| Dimensions | 370 × 302 × 450 | **450 × 302 × 370** (Kalerm's L×W×H → 302 W × 450 D × **370 H**) | ✗ reversed (§4) |
| Waste-water tray | *absent* | not published for this model | - |
| Mains water | *correctly absent* | tank only - no tap connection | ✔ (good: the record does **not** claim mains water, unlike the three bigger SKUs) |
| Drinks | one-touch espresso / cappuccino, no cup moving | 6 one-touch drinks incl. milk coffees; professional steam device | could be enriched |

This is the **best-matching record of the four** - nine fields correct character-for-
character. Only the cord length and the dimension ordering are wrong.

---

## 6. Product photography - two of four SKUs show the wrong machine

Checked every stored catalogue image against Kalerm's own renders.

| SKU | Stored image | What it actually depicts | Verdict |
|---|---|---|---|
| 00073 (K90L) | `automatic-coffee-machine-fab-100-imgcof00073.png` | A machine with a **large landscape touchscreen** and a left-hand water-tank module | ✗ **Wrong.** The K90L has a small 3.5" screen ringed by six physical drink buttons (see `IMG-COF-00073__K90L-front-800.jpg` and Kalerm's own render). The stored photo is a **K95L-class** machine |
| 00074 (K95L) | `automatic-coffee-machine-fas-100-imgcof00074.png` | 7" touchscreen, top bean hopper, left side-tank module | ✔ **Correct** - same machine as Kalerm's own K95L render, different angle |
| 00072 (FAB 50) | `automatic-coffee-machine-fab50-imgcof00072.jpg` | The **compact KLM1601** (small LCD + 6 touch icons + chrome spout with red ring), 370 mm tall | ✗ **Wrong.** FAB 50 is a **581 mm-tall** commercial body with a 1000 g hopper. The photo is its 250 g little brother |
| 00071 (FAO 30) | `automatic-coffee-machine-fao-30-imgcof00071.jpg` | The compact KLM1601 - **the same photograph as 00072, cropped** | ✔ **Correct for this SKU** (and it is 00072 that borrowed it) |

So 00071 and 00072 share one photo of the small machine, and 00073 and 00074 show
near-identical big-screen machines. **Currently no customer can tell the four apart from
the imagery, and two of the four listings show a machine of a different size class.**

✅ **The 00072 half of that problem is now fixable.** §10.1 stages a 1000×1000 official
Kalerm render of the correct 581 mm `K1601E` body — silver flanks, external 1000 g hopper,
deep pedestal base — which is unmistakably a different, larger machine than the compact
all-black KLM1601 currently shown. Swapping it in also un-shares the photograph from 00071,
which is the single highest-impact imagery fix available in this brand.

---

## 7. Cross-brand accessory wiring on IMG/COF/00071

`IMG/COF/00071` (FAO 30 / KLM1601) is currently the parent of **two** accessories, both
from other brands:

- `IMG/COF/00097` - **Dr. Coffee SC15** (flagged as probably wrong in the Dr. Coffee pass)
- `IMG/COF/00047` - **Rancilio / Egro Zero MAEA03 milk fridge**

The research here strengthens the case that the SC15 link is wrong, on three counts:

1. **Kalerm sells its own cold units.** The C-series (C2S, C4, C5, C22D, C100) and KCB10H
   milk fridges are Kalerm accessories sold alongside these machines, and Kalerm's own
   distributor photography pairs the K95L with one directly
   (`REF__K95L-with-milk-fridge-600.png`). If a fridge belongs anywhere in this brand, it
   is a Kalerm C-series unit paired with the **K95L (00074)**, not a Dr. Coffee unit
   paired with the smallest machine.
2. **The FAO 30 is the wrong machine to hang a fridge off.** It is the 250 g, 1.8 L,
   13 kg compact office model - the *least* likely of the four to be sold with a
   counter-side milk refrigerator. The 1000 g / mains-water K95L is the natural host.
3. **The SC15 isn't a milk fridge at all** (Dr. Coffee's own taxonomy calls it an
   "electronic refrigerator", 8-18 °C), so the pairing is wrong on both ends.

Nothing changed - noted for whoever untangles the accessory graph.

---

## 8. Cross-cutting notes

- **Two naming systems in one brand.** Two SKUs carry Kalerm codes in `model_number`, two
  carry house names. Until that is normalised, `model_number` cannot be relied on as a
  supplier-facing part number for this brand.
- **A single bad transcription behind all four records.** The same four fields drift the
  same way on every SKU that has a Kalerm counterpart: spout height 5 mm low at both ends,
  cord length +0.3 m, net weight rounded down, and (on the two big machines) width 403 vs
  390. That is one source document, transcribed once, not four independent errors. It
  also means the *rest* of the figures - which match Kalerm exactly - can be trusted.
- **The house numbers are cups/day tiers, and they're roughly right.** FAO 30 ≈ the 250 g
  compact; FAB 50 ≈ the 1400 W commercial; FAB/FAS 100 ≈ Kalerm's 80-100 and 100-120
  cups/day machines. Whoever created the scheme understood the range.
- **No mains-water claim on the small machine** - unlike several other brands in this
  catalogue, the FAO 30 record correctly omits a tap-water connection the machine does not
  have. Worth noting as a thing that is *right*.
- **All four are still in service but off Kalerm's current catalogue.** kalerm.com now
  sells the E/M/D, X/XS/Y/P and A/B ranges; K90L, K95L, K1601L and KLM1601 survive only on
  the export storefront and in distributor stock. Expect sourcing questions, and expect
  the successor (`K95 Plus`, `K95LT Plus`) to be what a supplier actually ships.

---

## 9. Product reference

| SKU | Catalogue name | Stored model | **Real model** | Primary source | Confidence |
|---|---|---|---|---|---|
| IMG/COF/00073 | Automatic Coffee Machine Fab 100 | K90L BGS | **K90L** | https://kalerm123.en.made-in-china.com/product/RSLxoOgMgmfe/China-Horeca-Fully-Automatic-Coffee-Machine.html | **High** on identity and specs; `BGS` suffix unexplained (Low) |
| IMG/COF/00074 | Automatic Coffee Machine Fas 100 | K905 EBGS | **K95L** | https://kalerm123.en.made-in-china.com/product/cSGxqXhFkBps/China-Automatic-Coffee-Machine-for-Big-Office.html | **High** on identity and specs; `K905` confirmed non-existent |
| IMG/COF/00072 | Automatic Coffee Machine FAB50 | FAB 50 | **K1601-family, 1.8 L / no-side-tank variant** | https://kalerm123.en.made-in-china.com/product/mvLQeIPrRnto/China-Fully-Automatic-Coffee-Machine-for-Office-Use.html (K1601L, the large-tank sibling) | **Medium** on family; **Low** on the exact code |
| IMG/COF/00071 | Automatic Coffee Machine Fao 30 | FAO 30 | **KLM1601** | https://kalerm123.en.made-in-china.com/product/zXnmEyUOsprk/China-Fully-Automatic-One-Touch-Cappuccino-Coffee-Machine.html | **High** - nine fields match exactly, and the pump/spout pair rules out KLM1602/1604/1601Pro |

Supporting sources used:

https://www.kalerm.com
https://www.kalerm.com/sitemap.xml
https://www.kalerm.com/About-Kalerm/
https://kalerm123.en.made-in-china.com/
https://kalerm123.en.made-in-china.com/product/VKJmtlpAorYU/China-Office-Use-Bean-to-Cup-Automatic-Coffee-Machine.html
https://kalerm123.en.made-in-china.com/product/LXQxGqUuTRrc/China-Economical-One-Touch-Cappuccino-Coffee-Machine.html
https://kalerm123.en.made-in-china.com/product/HBJnThREFUpq/China-Americano-and-Espresso-Coffee-Machine.html
https://superhouse-cafecorp.com/products/kalerm-k95l/
https://www.cafemutfak.com/en/product/kalerm-k90l-automatic-coffee-machine-288
https://hitmutfak.com/en/product/kalerm-k95l-fully-automatic-espresso-coffee-machine/
https://www.gbs.com.kh/product/k95lt/
https://kaapimachines.com/brands/kalerm-coffee-machines/
https://binasaranasejahtera.com/product/kalerm-klm-1601-coffee-machine/
https://www.kafeige.com/product/kalerm-k90l-kafeiji
https://www.kafeige.com/product/kalerm-k95l-kafeiji
https://www.caferica.com.cn/DeviceDetail33.html
https://sphere-resources.com/product/kalerm-k95-commercial-auto-coffee-machine/
https://vinbarista.com/en/kalerm.html

Tried and unusable:
`o.kalerm.com` - DNS no longer resolves; `archive.org/wayback/available` returns no
snapshots for its K90L or K95L pages.
https://www.kalermaustralia.com.au/ - DNS no longer resolves.
https://www.inoksanshop.com.tr/ and https://www.roundtheclockmall.com/ - HTTP 403 to every
user-agent tried.
https://kaapimachines.com/kalerm-1601-pro/, `/kalerm-1604/`, `/kalerm-2601-pro/` - 404.
https://kalerm.en.alibaba.com/ - returns an empty shell.

---

## 10. Image sourcing (July 2026) - `products resource/kalerm-images/`

**22 files.** Nothing copied into `storage/app/public/products/` and nothing referenced in
`products.json` - staged for review only, same as the Brema / Dr. Coffee sets.

> **⚠ Superseded in part.** The table below was written when **00072 had no usable image at
> all**. A follow-up pass (27 July 2026) broke that ceiling and, in the process, settled the
> §5.3 open question about the base variant's real Kalerm code. **Read §10.1 before using
> anything in this table for 00072.**

Because `o.kalerm.com` is dead and kalerm.com has retired all four models, there is **no
manufacturer photo library** for this brand the way there is for Dr. Coffee. Kalerm's
export storefront carries exactly **one** original render per model (verified: the
`2f0j00…` path is the largest served - the `2f1j00`, `3f2j00` and `43f34j00` variants come
back at 118×160, 74×100 and 222×300). The large clean shots therefore had to come from
distributors. Every file below was opened and visually verified; measured pixel size and
file size are recorded so the best candidate is obvious.

| SKU / role | File | Pixels | Size | What it is |
|---|---|---|---|---|
| **00071** KLM1601 | `IMG-COF-00071__KLM1601-front-1024.jpg` | 1024×1024 | 60 KB | **Best front shot.** White background, matches the stored catalogue image |
| 00071 | `IMG-COF-00071__KLM1601-left34-1024.jpg` | 1024×1024 | 58 KB | Left three-quarter |
| 00071 | `IMG-COF-00071__KLM1601-right34-1024.jpg` | 1024×1024 | 61 KB | Right three-quarter, side water-level window visible |
| 00071 ref | `REF__KLM1601-kalerm-official-watermarked-588.jpg` | 588×595 | 65 KB | Kalerm's **own** render - but carries KALERM/Trade-Assurance/certification watermarks. Reference only, **not storefront-usable** |
| **00072** | `IMG-COF-00072__K1601L-kalerm-official-530-TOOSMALL.jpg` | 530×577 | 50 KB | ⚠ **Below the 800 px bar and the only image of this body that exists.** Kalerm's own K1601L render - the tall commercial cabinet with side tank. Retried at every made-in-china size variant; 530×577 is the original. **Not usable as a storefront hero** - a real photo of this machine still has to be sourced from the supplier |
| 00072 ref | `REF__K95-no-side-tank-1500.png` | 1500×1200 | 100 KB | The **K95** (no side tank). Kept because it shows the ~303 mm-wide body silhouette that FAB 50's dimensions describe; the fascia is wrong (7" screen instead of the 1601 panel) |
| **00073** K90L | `IMG-COF-00073__K90L-front-800.jpg` | 800×800 | 35 KB | **Best K90L shot** - meets the bar exactly. Clearly shows the 3.5" screen + six physical buttons that identify this model |
| 00073 ref | `REF__K90L-kalerm-official-silver-355-TOOSMALL.jpg` | 355×480 | 32 KB | ⚠ Kalerm's own K90L render, **silver/black colourway**. Well below the bar (largest the storefront serves) - kept only as proof of the fascia and of the silver variant's existence |
| **00074** K95L | `IMG-COF-00074__K95L-left34-1500.png` | 1500×1200 | 317 KB | **Best overall image in the set.** Left three-quarter, transparent-ish white background |
| 00074 | `IMG-COF-00074__K95L-left34-1080.png` | 1080×1080 | 219 KB | Square left three-quarter - better crop for a product grid |
| 00074 | `IMG-COF-00074__K95L-right34-1080.png` | 1080×1080 | 237 KB | Square right three-quarter |
| 00074 | `IMG-COF-00074__K95L-kalerm-official-1080.jpg` | 1080×720 | 73 KB | Kalerm's **own** render, un-watermarked. Right three-quarter |
| 00074 | `IMG-COF-00074__K95L-front-800.jpg` | 800×800 | 51 KB | Straight-on front |
| 00074 ref | `REF__K95L-with-milk-fridge-600.png` | 600×600 | 98 KB | ⚠ Below the bar. K95L **paired with its milk fridge** - kept because it documents the correct accessory pairing (§7) |
| sibling ref | `REF__KLM1601Pro-kalerm-official-599.jpg` | 599×594 | 65 KB | Kalerm's KLM1601Pro (750 g, barrel-fed) - ruled out for 00071 |
| sibling ref | `REF__KLM1602-kalerm-official-588.jpg` | 588×594 | 61 KB | Kalerm's KLM1602 - ruled out for 00071 |
| sibling ref | `REF__KLM1604-kalerm-official-595.jpg` | 595×593 | 61 KB | Kalerm's KLM1604 (15 Bar) - ruled out for 00071 |

Deleted during the pass: a 500×500 duplicate of the KLM1601 front (superseded by the
1024 px version), a redundant 600×600 K95L, and a Sphere Resources OEM marketing banner
(text-and-logo filler, not a product shot).

Notes for whoever adopts these:

- **Only 00071 and 00074 are properly covered.** 00073 has exactly one usable image at the
  minimum size; **00072 has none** that meets the bar. *(Superseded — see §10.1.)*
- **Two colourways exist** for the K90L/K95L cabinet (black and silver/black). Everything
  usable that was found is black, which matches the stored catalogue images.
- Two files are deliberately kept below the 800 px bar and are named `TOOSMALL` so they
  cannot be adopted by accident.

### 10.1 🚩 00072 / FAB 50 solved — the machine is a **`K1601E`**, and it now has a 1000 px render

Two things came out of the 27 July 2026 pass, and the second is the more valuable.

**(a) The ceiling broke.** 00072 now has a clean, unwatermarked, transparent-background
**1000×1000** official Kalerm render of the correct body.

| File | Pixels | Size | What it is |
|---|---|---|---|
| `IMG-COF-00072__K1601-kalerm-official-front-1000.png` | **1000×1000** | 1,887,685 B | ✅ **The new primary.** Straight-on front. External bean hopper, silver flanks, 1601 fascia (mono display, six icon buttons, KALERM/咖乐美 badge), deep pedestal base with integrated grounds drawer. **No side tank** — this is the base variant, i.e. our machine |
| `IMG-COF-00072__REF__K1601L-side-tank-front-993x1810.jpg` | 993×1810 | 531,364 B | ⚠ K1601**L** — same fascia, **plus the black side tank on the left**. Not our variant |
| `IMG-COF-00072__REF__K1601L-side-tank-right34-988x1508.jpg` | 988×1508 | 516,780 B | ⚠ K1601L, right three-quarter |
| `IMG-COF-00072__REF__K1601L-side-tank-left34-889x1369.jpg` | 889×1369 | 459,775 B | ⚠ K1601L, left three-quarter |
| `IMG-COF-00072__manual-K1601L-kalerm-official.pdf` | 32 pp | 5,634,488 B | Kalerm's own **K1601L 全自动咖啡机使用说明书**. PDF title `K1601说明书LS`, Illustrator CC 2017, created 2018-03-16 |
| `IMG-COF-00072__REF__K1601L-kalerm-official-530-TOOSMALL.jpg` | 530×577 | 52,080 B | the old cap, kept as the audit trail |

The three `REF__` side-tank JPEGs are **native image XObjects extracted from that manual**
with `fitz`/PyMuPDF (pages 1–3), not page rasters — which is why they are 1810 px tall off a
32-page A4 booklet. They keep `REF__` deliberately: the manual is the **K1601L**'s, so those
three picture the 6 L side-tank machine, **not** our 1.8 L one.

**(b) The §5.3 open question is answered: the base variant's Kalerm code is `K1601E`.**
§5.3 concluded "the exact Kalerm code for the base variant could not be established…
`K1601` is the obvious inference by symmetry… but it is unconfirmed - Low confidence".
It can now be confirmed from Kalerm's **own site**, via the Wayback Machine — kalerm.com
retired the 1601 line, but its `k-series` product pages are archived, and they are paired
`E` / `L` throughout (`K1601E`/`K1601L`, `K1602E`/`K1602L`, `K1604E`/`K1604L`,
`K1605E`/`K1605L`):

| | **K1601E** | **K1601L** |
|---|---|---|
| Water tank | **1.8 L** (1.8L商用超大水箱) | **6 L** (6L商用超大水箱) |
| Bean hopper | 1000 g | 1000 g |
| RRP (CN) | ¥13,860 | ¥14,998 |
| Source | https://web.archive.org/web/20190219005417/http://www.kalerm.com/k-series/K1601E.html | https://web.archive.org/web/20191114142148/http://www.kalerm.com/k-series/k1601L.html |

**`1.8 L` + `1000 g` is exactly what the FAB 50 record stores** (§5.3), and 6 L + 1000 g is
exactly the K1601L. Every other difference §5.3 tabulated — narrower body, lighter net
weight — is the same E-vs-L split. **`IMG/COF/00072` is a Kalerm `K1601E`**, confidence now
**High**, up from Low. That raises it to the same footing as the §3.2 `K95L` correction and
should be added to the §11 recommendation list.

**Ceilings probed and confirmed still shut:**

- **made-in-china is genuinely capped at 530×577.** The full size-prefix ladder was re-run on
  the K1601L listing (https://kalerm123.en.made-in-china.com/product/mvLQeIPrRnto/China-Fully-Automatic-Coffee-Machine-for-Office-Use.html);
  the page serves only `155f0j00…` (webp), `2f1j00…` and `43f34j00…` derivatives above the
  `2f0j00…` original, and the original is the 530×577 file already staged.
- **kalerm.com has no 1601 pages left.** Its live sitemap (216 URLs) lists the X / XS / P / A /
  B / Y / OCS / HORECA series only; `/K1601/` and `/K1601L/` both 404.
- **The archived product images are not recoverable.** kalerm.com served them through an
  obfuscated base64-ish watermarking path (`/upfiles/201803/bSs6O2RjPmZ…png`); the Wayback
  captures of those exact filenames return the "not archived" page, and live kalerm.com 404s
  the whole `/upfiles/` tree. Only a 973×393 page banner survives.

**Source-URL gap.** As with the Comenda generics, the staging run did not record where the
1000×1000 `K1601-kalerm-official-front-1000.png` was pulled from, and it is not the MIC
listing, not live kalerm.com and not the K1601L manual (all three re-checked above). The
Chinese-language UI text on its display ("咖啡机准备就绪") points to a CN-market listing.
The file itself is verified genuine and correct-model; only its citation is missing.

---

## 11. Recommended changes, in priority order

Nothing below has been applied.

1. **`brands.json`: set Kalerm `website_url` to `https://www.kalerm.com`** (§1). Currently
   `null`; the URL is verified live. Lowest-risk, highest-certainty change in the pass.
2. **IMG/COF/00074 `model_number`: `K905 EBGS` → `K95L EBGS`** (§3.2). `K905` matches no
   Kalerm product; every feature in the record is the K95L's. This is a change to the
   unique ID, so it needs explicit approval and ideally a look at the supplier invoice
   first.
2b. **IMG/COF/00072 `model_number`: `FAB 50` → `K1601E`** (§10.1). **New, and now High
   confidence.** Kalerm's own archived product pages pair `K1601E` (1.8 L tank, ¥13,860)
   against `K1601L` (6 L, ¥14,998), and the stored record's 1.8 L + 1000 g is the `K1601E`
   exactly. §5.3 previously rated this Low confidence and explicitly said it should not be
   written into `model_number`; that objection is now answered. Same caveat as item 2 —
   this is the unique ID, so it needs explicit approval per
   [[feedback_model_number_unique_id]], and "FAB 50" should be kept somewhere as the house
   name.
3. **Fix the dimension fields** (§4) - these are the figures a customer measures a counter
   with:
   - `IMG/COF/00071`: `length 370 / width 302 / height 450` → **`302 / 450 / 370`**
     (the machine is 370 mm tall, not 450 - the largest single error in the brand).
   - `IMG/COF/00073`: `511 / 403 / 582` → **`390 / 511 / 582`**.
   - `IMG/COF/00074`: `511 / 403 / 582` → **`390 / 511 / 582`**.
   - `IMG/COF/00072`: **leave as `303 / 506 / 581`** - already correct.
   Update the `technical_specification` prose strings to match the same order so the two
   halves of each record agree.
4. **Replace the wrong product photos** (§6):
   - `IMG/COF/00073` currently shows a big-touchscreen K95L-class machine; it must show
     the 3.5"-screen K90L (`IMG-COF-00073__K90L-front-800.jpg` is the candidate).
   - `IMG/COF/00072` currently shows the compact KLM1601 - a 370 mm machine standing in
     for a 581 mm one. **No adequate replacement was found**; request a photo from the
     supplier.
5. **Correct the transcription-drift cluster on 00072/00073/00074** (§8): spout height
   `100~160 mm` → **`105~165 mm`**, power cord `1.8 m` → **`1.5 m`**, net weight
   `18.5 kg` → **`19 kg`** (00073/00074 only), grounds `30-35 portions` → **`35
   portions`**. On `IMG/COF/00071`, cord `1.5 m` → **`1.2 m`**.
6. **Reword the K90L display claim** (§5.1): "3.5" Color TFT touch screen" → a 3.5" colour
   TFT display with touch buttons. As written it erases the one feature that justifies the
   price gap to the K95L.
7. **Add the missing advised-output figures**: `IMG/COF/00073` **80-100 cups/day**,
   `IMG/COF/00074` **100-120 cups/day**, and (if the FAB 50 identification is accepted)
   a figure below the K1601L's 60-80.
8. **Decide what to do with the two house-named `model_number`s** (§3.3, §3.4).
   `IMG/COF/00071` can be moved to the real Kalerm code **`KLM1601`** with High confidence.
   `IMG/COF/00072` should **not** be renumbered - the family is identified but the exact
   code is not (§5.3). Both are unique-ID changes requiring approval.
9. **Re-point the accessory wiring on `IMG/COF/00071`** (§7). The Dr. Coffee SC15 and the
   Rancilio Egro milk fridge are both hung off the smallest Kalerm machine. If a fridge
   belongs in this brand at all it is a Kalerm C-series unit against the **K95L
   (00074)**.
10. **Optional enrichment** from Kalerm's own copy: KLM1601's six one-touch drinks and
    professional steam device; the K95L's detachable dual-spout milk frother and optional
    MDB payment port; the K90L's removable milk-foam unit and two-cup operation; the
    K1601L family's "integrated basement with large grounds tank".

Not recommended: changing `name` on any of the four. "Fab 100 / Fas 100 / FAB50 / Fao 30"
is a coherent internal cups-per-day tiering that the sales side evidently uses; the fix is
to put the manufacturer's code in `model_number`, not to rename the products.
