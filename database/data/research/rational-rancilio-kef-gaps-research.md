# RATIONAL / RANCILIO / KEF - gap-fill research

Research notes behind a **targeted gap-fill pass** on `products.json` (July 2026). This is
not a brand audit: RATIONAL (30 of 32), RANCILIO (13 of 15) and KEF (5 of 6) have already
been enriched. This file covers only the **5 SKUs those passes left behind**.

**No `products.json` or `brands.json` changes have been applied** - findings only, same
starting point as the Brema and Comenda passes.

Headline results:

- **2 of 5 resolved to an exact manufacturer article with image-level proof.** The
  "Connection Kit" is **RATIONAL 60.70.464 Unit connection kit** (§2.2) - identified from
  the record's own stored photo, then confirmed component-for-component against Rational's
  published parts list and Rational's own product page. The Rocky Doser Nero is a genuine,
  correctly-named **Rancilio Rocky doser variant in black** (§3.1).
- **`56.00.22` is not a real RATIONAL article number** (§2.1). The product itself is
  certain - it is the red **Cleaner Tab** bucket - but the stored code does not exist in
  Rational's numbering, and two real candidates exist depending on packaging generation.
- **The Egro "milk fridge" copy IS supportable** (§3.2), unlike the Dr.Coffee SC15 case:
  Egro's fridges are compressor units purpose-built for fresh milk, NSF-certified, and
  Egro's own MK4 product render shows a **5.0 setpoint** on the display. What cannot be
  supported is a *numeric* temperature claim - Egro publishes none.
- **`MAEA03` could not be verified as anything** (§3.2). Low confidence.
- **The KEF "Double Cater" cannot be identified** (§4.1). KEF's published range contains no
  two-thermos brewer, and `kef-factory.com` - the URL in `brands.json` - **sells no coffee
  equipment at all** (§4.2).
- **None of the 5 records carries dimension fields**, so the recurring width/height axis
  swap cannot be present on any of them. It *is* present on the Rocky's published sibling
  (§3.1) - which matters, because that record is the obvious place someone would copy
  dimensions from.

---

## 1. Where the five sit

| SKU | Name | Brand | model_number | Status | Price (KES) | Content it has |
|---|---|---|---|---|---|---|
| IMG/HYS/00207 | Rational Cleaner Tablets 56.00.22 | RATIONAL | `56.00.22` | published | 25,600 | short_description + image only |
| IMG/OVE/00027 | Connection Kit | RATIONAL | *(null)* | published | 19,827 | short_description + image only |
| IMG/COF/00128 | Rancilio Rocky Doser Nero Black | RANCILIO | `ROCKY` | draft | 118,750 | short_description + meta only, `image: ""` |
| IMG/COF/00047 | Milk Fridge Egro Zero MAEA03 | RANCILIO | `MAEA03` | draft | 190,075 | short_description + meta only, `image: ""` |
| IMG/COF/00138 | Coffee Brewer with Double Cater (Thermos) | KEF | *(null)* | draft | 771,250 | short_description only, `image: null`, qty 0 |

All five lack `description` and `technical_specification`. Two of them (00207, 00027) are
**published and priced with no body copy at all**.

---

## 2. RATIONAL

Brand entry verified: `https://www.rational-online.com` returns 200 and is the live
corporate site. No `brands.json` change needed.

### 2.1 IMG/HYS/00207 - `56.00.22` is not a RATIONAL article number

**The product is certain. The code is not.**

The record's stored image (`storage/app/public/products/rational-cleaner-tablets-560022-imghys00207.jpg`)
shows a **white round bucket with a metal bail handle, a dark-red/maroon label band, and
individually foil-wrapped red sachets**. In Rational's colour system that is unambiguous:

- **red = Cleaner tab** (Reiniger-Tab)
- blue = Care tab
- green/white = Active Green

So the record is the **red Cleaner Tab bucket** - and the catalogue's Rational Tablets
family confirms it by shape. The family is `{Cleaner, Care, Active Green} x {bucket, loose}`
and exactly one cell is otherwise empty:

| Product | Bucket SKU | Loose SKU |
|---|---|---|
| Cleaner tab | **this record (00207)** | 00038 (`56.00.210`) |
| Care tab | 00034 (`56.00.562`) | 00035 (`56.00.562`) |
| Active Green cleaner | 00085 (`56.01.628`) | 00096 (`56.01.535`) |

Note 00038 - "Rational Cleaner Tabs Loose" - already carries the **real** cleaner-tab
article `56.00.210`. 00207 is its bucket.

**Search for `56.00.22` returned nothing** across Rational's own site and every major
parts/catering distributor. Variants `56.00.220`, `56.00.222` and `56.00.022` were also
searched and do not exist either. Every genuine Rational care article in this series has a
**three-digit** final group. `56.00.22` reads as a truncated or mistyped entry, not a code.

**The two real candidates**, in order of likelihood:

1. **`56.00.210` / `56.00.210A`** - Cleaner tab, **bucket of 100**, phosphate- and
   phosphorus-free, for all SelfCookingCenter units (from 2004) and CombiMaster Plus.
   Sold in the older **round bucket** - which is what the record's own photo shows.
   `https://www.partstown.co.uk/rational/rat56-00-210`
   `https://www.webstaurantstore.com/rational-56-00-210a-cleaner-tabs-for-selfcookingcenter-combi-ovens-case/6455600210.html`
   `https://chefstoys.com/products/rational-56-00-210-cleaning-tablets-for-selfcookingcenter-units-bucket-of-100-4596`
2. **`56.02.315E`** (EU) / **`56.02.315U`** (US) - the **current** article that has
   superseded it: "Cleaner tab P-free", **130 pcs**, same compatibility, now in a
   **rectangular tub**. This is what Rational's own live page sells today:
   `https://www.rational-online.com/en_gb/accessories/cleaning-and-care-products/cleaningtab_scc_cmp.php`
   `https://www.rational-online.com/en_us/accessories/cleaner-and-care-products/cleaningtab_scc_cmp.php`

**Price corroborates the 100-count reading.** 25,600 KES / 100 tabs = **256 KES per tab**,
against the catalogue's own loose Active Green tab at 251.38 KES (00096). At 130 tabs it
would be 197 KES/tab, which sits oddly low against the loose price. Weak evidence, but it
points at `56.00.210`.

**Ruled out** (all already used by other SKUs, and all the wrong colour/function):
`56.00.211` rinse-aid (00040), `56.00.562` Care (00034/00035), `56.01.535`/`56.01.628`
Active Green (00096/00085).

**Compatibility** (confirmed, applies to both candidates): all **SelfCookingCenter** units
manufactured from 2004 onward, **CombiMaster Plus** with automatic cleaning, and
**iCombi Pro / iCombi Classic** with Efficient CareControl. The tabs go into the automatic
cleaning programme - loose into the drawer behind the door on SelfCookingCenter, into the
chamber on iCombi.

**What could NOT be confirmed - Low confidence, flagged rather than guessed:**

- **Per-cycle dosing.** Rational's oven prompts for the tab count as part of the selected
  cleaning level; no published fixed "N tabs per clean" figure was found for this article.
  Do not put a number in the spec table.
- **GHS / hazard classification.** Distributors note "professional and industrial use only,
  not suitable for domestic use" and that hazmat surcharges can apply, but the actual
  H-statements need the SDS. Rational's SDS download portal
  (`https://www.rational-online.com/en_gb/customer-care/downloads/documents/`) 404s on the
  guessed path; the sibling record 00085 shows the house style for a composition block once
  an SDS is in hand. Get the SDS for whichever article is confirmed.

**Dimensions:** none stored, none needed. This is a consumable - pack size and
compatibility are what matter, exactly as the brief anticipated.

### 2.2 IMG/OVE/00027 "Connection Kit" = RATIONAL **60.70.464 Unit connection kit** - HIGH confidence

This was the vaguest record in the set and the one the brief expected to come back
unresolved. It resolved cleanly, because **the record already has a photograph** and nobody
had looked at it.

`storage/app/public/products/connection-kit-imgove00027.jpg` shows, laid out flat:

- 4 x straight grey HT/PP drain pipes with printed markings
- 3 x shallow (45 degree) elbows
- 5 x right-angle (87 degree) bends
- 1 x T-branch
- 1 x straight double sleeve
- 1 x black rubber seal ring
- 1 x braided water-inlet hose with brass/white screw fittings

Rational's published contents for **60.70.464** are:

> water inflow hose (2 m), 1/2" with 3/4" screw connection; unit drain set DN 50 consisting
> of 5x HT bend 87 degree, 3x HT bend 45 degree, 4x HT pipe 500 mm, 1x HT branch 50/87
> degree, 1x drain seal, 1x double sleeve.

**Component-for-component identical.** This is not an inference - the photo is a parts
count match.

Confirmed on Rational's own site, which gives the article number, the name and the
compatibility list:
`https://www.rational-online.com/en_xx/accessories/exhaust-hood-and-installation-solutions/unitconnectionkit.php`

| Field | Value |
|---|---|
| Official name | **Unit connection kit** |
| Article number | **60.70.464** |
| Type | Water-supply + waste-water installation kit (NOT a stacking kit) |
| Water inflow hose | 2 m, 1/2" hose with 3/4" screw connection |
| Drain | DN 50 unit drain set (DN 40-to-DN 50 adapters included for the XS 6-2/3) |
| Contents | 5x HT bend 87 deg, 3x HT bend 45 deg, 4x HT pipe 500 mm, 1x HT branch 50/87 deg, 1x drain seal, 1x double sleeve, 1x inlet hose |
| Compatible types | XS 6-2/3, 6-1/1, 10-1/1, 6-2/1, 10-2/1, 20-1/1, 20-2/1 |
| Applies to | iCombi Pro, iCombi Classic and iVario cooking systems |

Independent distributor confirmations:
`https://www.industrykitchens.com.au/rational-6070464-unit-connection-kit-water-inlet-hose-and-waste-water-pipes-dn50`
`https://www.cs-catering-equipment.co.uk/rational-60-70-464-applicance-connection-kit`
`https://www.chefsupplies.ca/products/rational-appliance-connection-kit-60-70-464`
`https://www.buzzcateringsupplies.com/rational-installation-connection-kit.html`
`https://www.partstown.com/rational/ratl60-70-464`

**The stacking-kit reading is wrong and should be killed.** The record's current
`short_description` says "official linking accessory for **stacking or connecting** RATIONAL
combi ovens". Rational's stacking kits are a completely different family of parts
(60.73.991, 60.75.751, 60.75.752, 60.75.756, 60.76.708 - steel frames and rails, US retail
$400-$1,000). The stored photo contains no stacking hardware whatsoever. Selling this
19,827 KES plumbing kit as a stacking solution will produce returns.

**Price sanity:** 19,827 KES is roughly USD 153, which lands squarely on 60.70.464's
international retail band and nowhere near a stacking kit. (Caveat: Sheffield appears to use
banded pricing - 19,827 is also the exact price of IMG/OVE/00036 and GROUP/MULTIBAKER - so
treat price here as corroboration, not proof. The photo is the proof.)

---

## 3. RANCILIO

Brand entry verified: `https://www.ranciliogroup.com` is live and correct in `brands.json`.
Two structural facts worth recording, both discovered from Rancilio Group's own sitemaps:

- **The Rocky is no longer in Rancilio's official range.** `rancilio_product-sitemap.xml`
  lists every current Rancilio product in every locale and contains **no Rocky page**. The
  current grinder line is MD 40 ST, Kryo 65 (ST/AT/OD/Elite), Bond, and Stile SD; the
  home line is Silvia, Silvia Pro X, Stile, Barista Kit. The Rocky is discontinued -
  still widely stocked and supported, but there is no live official page to cite.
- **Egro has moved off ranciliogroup.com entirely.** `egro_product-sitemap.xml` retains a
  single stub which 301s to `https://egrocoffee.com/`. Egro's live catalogue is now at
  `https://egrocoffee.com/`, and **Egro Zero is not in it** - it too is discontinued.

### 3.1 IMG/COF/00128 Rancilio Rocky Doser Nero Black - variant confirmed, specs assembled

"Doser" and "black" are both real, correctly-used variant descriptors. The Rocky ships as:

- **Rocky (doser)** - manual dosing chamber with a pull lever and portafilter fork
- **Rocky SD / doserless** - grinds direct into the basket
- finishes: **brushed stainless** and **black**

`Nero` is simply Italian for black, so the catalogue name "Rocky Doser Nero Black" is
redundant but not wrong. A retailer listing for exactly this variant:
`https://clumsygoat.co.uk/products/rancilio-rocky-doser-home-coffee-grinder-50mm-black`

**Assembled specification** (sources agree except where noted):

| Field | Value | Note |
|---|---|---|
| Type | Dosing espresso grinder (manual doser + lever) | |
| Burrs | **50 mm flat, hardened tempered steel** | Same burr set as Rancilio's commercial MD 40 |
| Grind adjustment | Stepped collar ring | **Sources disagree: 40 vs 50 vs 55 steps - see below** |
| Motor | **140 W** (230 V markets) / 166 W quoted on some US listings | |
| Motor speed | **1,350 rpm @ 50 Hz** ; 1,725 rpm @ 60 Hz | Not a contradiction - mains frequency |
| Hopper | **300 g** (10.5 oz) | |
| Output rate | 0.69-0.97 g/s espresso; ~2.5-3.5 kg/h | |
| Dose per pull | ~7 g | |
| Dimensions (W x D x H) | **~115-120 x 245 x 350 mm** | see swap note below |
| Weight | **7 kg** (doser, EU listing) / 8.16 kg (18 lb, US listing) | mild disagreement |
| Voltage | 220-240 V / 50 Hz | |
| Body | Stainless steel / ABS | |
| Noise | ~77 dB while grinding | single source |
| Protection | High-temperature motor overload switch | |

Sources:
`https://clumsygoat.co.uk/products/rancilio-rocky-doser-home-coffee-grinder-50mm-black`
`https://www.wholelattelove.com/products/rancilio-rocky-coffee-grinder`
`https://www.espressoelements.com.au/product/rancilio-rocky-doserless-grinder/`
`https://www.1stincoffee.com/rancilio-rocky-doserless-grinder.htm`

**Grind-setting count is genuinely contested** and there is no live official page to settle
it: one retailer says "up to 50 adjustable settings", another says "40 stepped adjustments",
and the commonly-repeated enthusiast figure is 55 clicks. **Recommend writing "stepped
collar adjustment across the full espresso-to-French-press range" and not committing to a
number** until a Rocky can be counted by hand or a Rancilio manual is obtained.

**Width/height axis swap - not present here, but present on the sibling.** 00128 stores no
dimensions, so it is clean. But its published sibling **IMG/COF/00044 "Coffee Grinder Rocky"**
(same `model_number: ROCKY`) stores `length: 120, width: 350, height: 250` while its own
prose says "250 x 120 x 350 mm". Against the manufacturer figures (~115-120 W x 245 D x
350 H):

- numeric `width: 350` is really the **height**
- numeric `height: 250` is really the **depth**
- the prose, as in every previous brand pass, is the correct one

**Do not copy 00044's numeric fields into 00128.** Use W 120 x D 245 x H 350 mm.

**Also worth noting:** 00044 (published, 98,162.50 KES) and 00128 (draft, 118,750 KES) are
the *same grinder* in two finishes at a 21% price gap, and 00044's copy does not mention
that it is the stainless one. If 00128 is published, the pair needs to read as
finish-variants, ideally as a variable product rather than two flat SKUs.

### 3.2 IMG/COF/00047 Milk Fridge Egro Zero MAEA03

**Verdict up front: yes, "milk fridge" copy is supportable here. `MAEA03` is not verifiable.**

**What the product is.** Egro Zero / Zero+ is Rancilio Group's entry-level Egro
superautomatic. In the **Quick Milk** configuration its fridge is a **mandatory accessory**,
listed in Rancilio Group North America's own Egro price list as "Quick Milk Fridge incl." -
i.e. bundled with the machine, not optional:
`https://www.ranciliogroupna.com/wp-content/uploads/2022/09/PRICING-EGRO-NA-List-Price-09-22.pdf`

Egro's own current description of the Quick Milk fridge:

> Compact 4-L fridge with removable milk container. It is easy to install and is designed
> for locations with little free counter space and a low consumption of drinks made with
> fresh milk. The fridge temperature can be adjusted using the knob on the back.

`https://egrocoffee.com/en/products/accessories/fridges/quick-milk/`

| Field | Value | Confidence |
|---|---|---|
| Capacity | **4 litres** (US listings say "1 gallon") | High |
| Milk container | Removable | High |
| Cooling | Compressor refrigeration (not thermoelectric) | High |
| Temperature control | Adjustable via knob on the rear of the cabinet | High |
| Certification | **NSF certified** (US distribution) | Medium - distributor claim |
| Finish | Brushed stainless (US) / black with EGRO logo (current EU render) | High |
| Width | ~9 in (~230 mm) countertop unit | Medium - single source |
| Purpose | Milk is **siphoned directly from the container inside the fridge** into the machine | High |
| Temperature **range** | **Not published by Egro** | - |

**The milk-chilling question, answered directly.** The brief flagged the Dr.Coffee SC15
precedent, where a "milk fridge" turned out to be an **8-18 degC thermoelectric beverage
cabinet** - above the dairy cold chain, so the milk copy was unsupportable. This is a
**different situation**:

1. It is a **compressor** fridge, not a thermoelectric cabinet.
2. It exists **only** to hold fresh milk for an automatic coffee machine - the milk line
   siphons out of the container inside it. It has no other function.
3. Egro's own copy for the whole fridge range (Quick Milk, MK4, MK6, FUM) frames them
   exclusively around **fresh milk**.
4. US distribution lists it as **NSF certified**, and NSF/ANSI food-equipment certification
   requires cold holding at or below 5 degC / 41 degF.
5. **Direct visual evidence:** Egro's own product render for the sibling **MK4** fridge -
   the one with a front display instead of a rear knob - shows the display reading
   **`5.0`**. That is the setpoint, and it is squarely inside the dairy cold chain.
   (File `IMG-COF-00047__REF__EGRO-MK4-fridge-front-official.png`, §6.)

**So: write the milk-chilling copy. Do not write a number.** Egro publishes no temperature
range for the Quick Milk fridge, so a spec-table row of "2-8 degC" or similar would be
invented. Say "adjustable via the rear thermostat knob, set for fresh-milk holding" and
leave the numeric row out, or get the figure off the unit's rating plate.

**`MAEA03` - Low confidence, unresolved.** What was tried:
- Rancilio Group's site, sitemaps and the Egro product sitemap - no such code
- `egrocoffee.com` product pages for all four current fridges (MK6, MK4, Quick Milk, FUM) -
  no article codes published at all
- The Rancilio Group NA Egro price list PDF (14 pages, text-extracted) - fridge options are
  listed by *name* (Quick Milk Fridge, Top Milk Fridge, Next Fridge) with prices, **no part
  numbers anywhere in the document**
- Direct web search for the literal string `MAEA03` - no result on any parts, distributor
  or manufacturer site

`MAEA03` is most likely a **Rancilio Group internal/commercial order code** off a supplier
quotation rather than a public article number, in the same shape as the house codes already
documented for Comenda's `PR` and `CB-12/18`. Per `[[feedback_model_number_unique_id]]` it
should be left exactly as it is.

**Red flag - wrong accessory pairing.** IMG/COF/00047 is currently listed as an
`accessories` entry on **IMG/COF/00071, the KALERM FAO 30**. An Egro Quick Milk fridge is a
proprietary Egro component: the machine drives the milk pump and the milk line is plumbed
into the Egro's milk system. It will not work with a Kalerm FAO 30. The Dr.Coffee SC15
(00097, the other accessory on that machine) is a generic counter cabinet and is at least
physically plausible; the Egro fridge is not. Remove 00047 from the FAO 30's accessory list.

**Naming note:** the record's category is "Coffee Machines > Automatic > Automatic
Accessories" and the name says "Egro Zero". Egro Zero is discontinued and absent from
`egrocoffee.com`; the surviving equivalents are MK4 (4.5 L, front display) and FUM (4 L,
under-machine). If the supplier is still shipping stock, the name is fine; if they are
re-ordering, they will be quoted an MK4 or FUM, which are **different units**.

---

## 4. KEF

### 4.1 IMG/COF/00138 "Coffee Brewer with Double Cater (Thermos)" - NOT IDENTIFIED, Low confidence

**"Cater" decodes, the model does not.**

The catalogue's own KEF naming makes "Cater" legible. Sheffield's KEF brewers are named by
what they pour into:

- glass-decanter models -> "**Decanter**": IMG/COF/00103 "1 Decanter FTL120", IMG/COF/00104
  "2 Decanter FTL120-2"
- thermos/airpot models -> "**Cater**": IMG/COF/00105 "**Single Cater** FLC 250" (a 2.5 L
  insulated thermal server)

So "Double Cater (Thermos)" means a brewer with **two thermal servers** - the thermos
analogue of the FTL120-2. That much is solid.

**KEF publishes no such machine.** Their complete filter-coffee range, taken off their own
category page, is:

| Series | Models |
|---|---|
| Filtro (FLT) | FLT120, **FLT120-2** (2 glass pots), FLT120-T (thermos), FLT120-AP (airpot), FLT250 (2.5 L thermos) |
| Filtronic (FLC) | FLC120, FLC120-2 (2 glass pots), FLC120-T, FLC120-AP, **FLC/Filtronic 250** (2.5 L thermos) |
| Filtronist (FLS) | FLS 2,5 (2.5/3.8 L container, 4.3" touch), FLS-3.8, **FLS 5,7** (5.7/7.6 L container, 7" touch), FLS-250 |

`https://www.kef.com.tr/en/filter-coffee-machines`

The "-2" (double) suffix exists **only in the 120 glass-pot line**. There is no FLT250-2 and
no Filtronic 250-2: those URLs were probed directly on kef.com.tr and return 404, while the
single-server FLT250 page returns 200.

**Price does not help.** 771,250 KES is **4.5x** the catalogue's own FLC 250 (172,750 KES) -
far more than a second thermal server would cost. And KES-to-TRY ratios across the existing
KEF records are wildly inconsistent (FLT120 5.7x, FLT120-2 6.2x, FLC250 3.5x against
current Turkish retail), so price cannot be used to place this SKU on the ladder at all.

**Candidates, none confirmed:**

1. **A discontinued or bespoke two-thermos 250-series** (an "FLC 250-2"). Fits the name
   perfectly, but no evidence it was ever a catalogue item.
2. **KEF Filtronist FLS 5,7** - the top of the range: 7" touchscreen, 4 programmes, 18 L
   insulated tank, 40 L/h, supplied with a **5.7 or 7.6 L** thermal container, pulse
   brewing, pre-infusion, drip delay, eco mode. This is the only KEF brewer expensive
   enough to plausibly justify 771,250 KES, and "double" could have been a supplier's
   shorthand for the two container sizes. **But its product render shows one brew head and
   one container**, so the name does not really fit.
3. **KEF FLS-250** - 4.3" touchscreen, 12 L tank, 30 L/h, 2.5 L thermal container, 3 kW,
   220 x 477 x 793 mm, 18 kg. Right family, wrong "double".

**Recommendation: leave this one `draft` and ask the supplier for the model code.** It has
`quantity: 0`, `image: null` and no body copy - there is nothing to lose by holding it, and
publishing a 771,250 KES machine on a guessed identity is the worst outcome available.

### 4.2 `brands.json` KEF URL points at a site with no coffee equipment

`brands.json` has KEF at `https://kef-factory.com/`. That site is live, but its **entire**
category list is: Hood, Tables & Cabinet, Sink tables, Shelving, Trolleys, Hotline, Oven,
Ranges, Cold Line. **No beverage or coffee category exists**, and no FLT/FLC/FLS model
appears anywhere on it.

Every KEF coffee brewer in our catalogue - FLC 250, FTL120, FTL120-2, the CMP-2 decanter,
the FK925 filter papers - comes from **`https://www.kef.com.tr`** (KEF Endustriyel, Turkey),
which carries the full Filtro / Filtronic / Filtronist range with specs and images.

Both appear to be KEF Turkey properties (kef-factory.com reads as a narrower stainless-steel
fabrication export site), but for this catalogue's purposes `kef-factory.com` is the wrong
destination: a customer following the brand link finds no coffee machines. **Flagged, not
changed.**

---

## 5. Cross-cutting notes

- **Look at the stored image before declaring a record unidentifiable.** The Connection Kit
  (§2.2) was the single vaguest record in this set - no model number, no description, a
  four-word name - and it resolved to an exact article number in one step because the photo
  was a parts-count match. Worth adding to the standard opening move on thin records.
- **Two of the five have a wrong or non-existent `model_number`** (`56.00.22`, and `MAEA03`
  unverifiable), and two have **none at all**. Per
  `[[feedback_model_number_unique_id]]` none were changed here; the researched codes are in
  this file for a separate approval decision.
- **The axis swap could not appear on any of these five** (no dimension fields), but it *is*
  live on the Rocky's published sibling IMG/COF/00044 (§3.1) - the fourth brand family in a
  row to carry it, and again with the prose correct and the numeric fields wrong.
- **Three of the five are `draft` with `image: ""` or `null`.** Two of the three (Rocky
  Doser, Egro fridge) now have verified 2000 px images staged (§6) and enough spec to
  publish. The third (KEF) should stay draft.
- **Two are `published` with no `description` and no `technical_specification`** -
  IMG/HYS/00207 at 25,600 KES and IMG/OVE/00027 at 19,827 KES. Same failure mode the Comenda
  pass found on EC44/EF36M/EB28. The Connection Kit is the more urgent of the two because
  its existing one-line description is actively **wrong**, not merely absent.
- **Discontinuation is a live theme in this set.** Rocky, Egro Zero and (probably) the
  KEF Double Cater are all off their makers' current catalogues. That does not make them
  unsellable - it makes re-order codes and spec drift the thing to confirm with the supplier.

---

## 6. Product reference

| SKU | Catalogue name | Our model | Real identity | Primary source | Confidence |
|---|---|---|---|---|---|
| IMG/HYS/00207 | Rational Cleaner Tablets 56.00.22 | `56.00.22` (**not a real article**) | RATIONAL **Cleaner tab P-free** bucket - `56.00.210`/`56.00.210A` (100 pcs, legacy round bucket, matches stored photo) or `56.02.315E` (130 pcs, current tub) | https://www.rational-online.com/en_gb/accessories/cleaning-and-care-products/cleaningtab_scc_cmp.php | **High** on the product; **model_number is invalid**; Medium on which article |
| IMG/OVE/00027 | Connection Kit | *(null)* | RATIONAL **60.70.464 Unit connection kit** (water inlet hose 2 m + DN 50 drain set) | https://www.rational-online.com/en_xx/accessories/exhaust-hood-and-installation-solutions/unitconnectionkit.php | **High** - stored photo matches the published parts list component-for-component |
| IMG/COF/00128 | Rancilio Rocky Doser Nero Black | `ROCKY` | Rancilio **Rocky**, doser variant, black finish (discontinued from Rancilio's range) | https://clumsygoat.co.uk/products/rancilio-rocky-doser-home-coffee-grinder-50mm-black | **High** on identity; Medium on grind-step count and weight |
| IMG/COF/00047 | Milk Fridge Egro Zero MAEA03 | `MAEA03` (unverifiable) | Egro **Quick Milk fridge** - 4 L compressor milk fridge, removable container, rear thermostat knob | https://egrocoffee.com/en/products/accessories/fridges/quick-milk/ | **High** on product type and milk-chilling duty; **Low** on `MAEA03`; no published temperature range |
| IMG/COF/00138 | Coffee Brewer with Double Cater (Thermos) | *(null)* | **Unidentified.** KEF publishes no two-thermos brewer | https://www.kef.com.tr/en/filter-coffee-machines | **Low** - candidates only (FLS 5,7 / FLS-250 / a bespoke 250-2) |

Supporting sources pulled while researching:

- Rational accessories brochure (iCombi + iVario, US): https://hcms.rational-online.com/hcms/v1.7/entity/brochure/200140/storage/MDIwMDE0MC8wL3BkZi1wcmV2aWV3LTE1MHBwaS1wcmludHNoZWV0Ly8vMTA1MjY0MDA1/download/brochure_accessories_icombi_ivario_-_english_us.pdf
- Rational stacking kits (the family this is NOT): https://www.restaurantsupply.com/products/rational-60-75-751-stacking-kit-for-combi-duo-6-half-size-gas-or-electric
- Rational 56.00.210 cleaner tab: https://www.partstown.co.uk/rational/rat56-00-210
- Rational 56.00.562 Care tab (colour-code cross-check): https://www.webstaurantstore.com/rational-56-00-562-care-tabs-for-selfcookingcenter-combi-ovens-with-care-controls-case/6455600562.html
- Rancilio Group product sitemap (proves Rocky is discontinued): https://www.ranciliogroup.com/rancilio_product-sitemap.xml
- Egro NA price list 09-2022 (Zero+ Quick Milk configuration): https://www.ranciliogroupna.com/wp-content/uploads/2022/09/PRICING-EGRO-NA-List-Price-09-22.pdf
- Egro fridge range: https://egrocoffee.com/en/products/accessories/fridges/mk4/ · https://egrocoffee.com/en/products/accessories/fridges/mk6/ · https://egrocoffee.com/en/products/accessories/fridges/fum/
- Egro Quick Milk fridge, US distribution (NSF, 1 gallon): https://www.jlhufford.com/products/egro-quick-milk-fridge-1-gallon
- Egro Zero Quick Milk machine listing: https://www.thecoffeebrewers.com/egzequmi.html
- KEF Filtronic 250 (our "Single Cater" sibling): https://www.kef.com.tr/en/kef-filtronic-250-en
- KEF Filtro FLT250: https://www.kef.com.tr/en/kef-filtro-flt250-filtre-kahve-makinesi-en
- KEF Filtronist FLS 5,7: https://www.kef.com.tr/en/kef-filtronist-fls-5-7-en
- KEF Filtronist FLS 2,5: https://www.kef.com.tr/en/kef-filtronist-fls-2-5-en
- KEF FLS-250 full specs: https://www.cafemutfak.com/en/product/kef-fls-250-filter-coffee-machine-touchscreen-programmable-30-lt-hour-capacity-561
- KEF range with current TRY pricing: https://www.cafemutfak.com/en/brand/kef-71

---

## 7. Image sourcing (July 2026) - downloaded to `Downloads/rational-rancilio-kef-images/`

**8 files.** Naming follows the Santos/Brema/Comenda convention,
`<SKU-with-dashes>__<descriptor>.<ext>`, with a `REF__` prefix on anything that is a
reference rather than the confirmed product. Every file below was opened and visually
checked; pixel dimensions and file sizes are recorded so the best candidate is obvious.
Nothing has been copied into `storage/app/public/products/` and nothing is referenced in
`products.json`.

| SKU | File | Pixels | Size | Source | Verified as |
|---|---|---|---|---|---|
| IMG/OVE/00027 | `IMG-OVE-00027__RATIONAL-60-70-464-unit-connection-kit-official.jpg` | **2880x1920** | 1057 KB | official Rational media (`/media/images/accessories/icombi-pro-accessories-unit-connection-rational-63913.jpg`) | **Exact product.** 4 pipes, 3x 45 deg, 5x 87 deg, T-branch, double sleeve, black drain seal, braided inlet hose - matches the published contents list and the record's own stored photo |
| IMG/COF/00128 | `IMG-COF-00128__Rancilio-Rocky-Doser-black.jpg` | **2000x2000** | 90 KB | https://clumsygoat.co.uk/products/rancilio-rocky-doser-home-coffee-grinder-50mm-black | **Exact variant.** Black body, doser chamber with RANCILIO logo, numbered grind collar, portafilter fork, drip tray |
| IMG/COF/00047 | `IMG-COF-00047__EGRO-Quick-Milk-Fridge-front-official.png` | **2000x2000** | 249 KB | official Egro media (`/wp-content/uploads/EGRO_QMF_CLOSE_FRONT_LR.png`) | **Exact product.** Black EGRO-branded compact fridge, front thermostat knob, levelling feet |
| IMG/COF/00047 | `IMG-COF-00047__REF__EGRO-MK4-fridge-front-official.png` | **2000x2000** | 376 KB | official Egro media (`/wp-content/uploads/2023/10/EGRO_MK4_CLOSE_FRONT_LR.png`) | **Reference only** - this is the MK4, the Quick Milk's current successor. Kept because its display reads **`5.0`**, the evidence cited in §3.2 for the milk cold-chain claim |
| IMG/HYS/00207 | `IMG-HYS-00207__REF__RATIONAL-cleaner-tab-P-free-56-02-315-tub-official.jpg` | **1280x854** | 68 KB | official Rational media (`/media/images/accessories/cleaning/56-02-315-...-1702717.jpg`) | **Reference - wrong packaging generation.** This is the current rectangular 130-count tub (`56.02.315`); the record's stored photo is the legacy round 100-count bucket (`56.00.210`). Same red P-free cleaner tab, different pack |
| IMG/COF/00138 | `IMG-COF-00138__REF__KEF-Filtronic-250-FLC250-official.jpg` | 532x800 | 33 KB | https://www.kef.com.tr/dsy/kef-filtronic-250-979440.jpg | **Reference.** The single-thermos FLC/Filtronic 250 - our "Single Cater" sibling, not the Double |
| IMG/COF/00138 | `IMG-COF-00138__REF__KEF-Filtronist-FLS-2-5-official.jpg` | 533x800 | 35 KB | https://www.kef.com.tr/dsy/fls2-5-12090.jpg | **Reference.** FLS 2,5 - one brew head, one thermal server |
| IMG/COF/00138 | `IMG-COF-00138__REF__KEF-Filtronist-FLS-5-7-official.jpg` | 225x800 | 31 KB | https://www.kef.com.tr/dsy/kef-filtronist-fls-5-7-12110.jpg | **Reference.** FLS 5,7 - the top-of-range candidate. Narrow crop |

Notes for whoever adopts these:

- **The Rational connection-kit render (2880x1920) is the best asset in the set** and is
  strictly better than the 32 KB file currently in `storage/app/public/products/`. It is
  also the only one that is a Rational original rather than a page rendition - the page
  serves a `-fix725x370` crop; dropping that suffix returns the 1 MB original. Same trick
  as the Dr.Coffee case.
- **The Egro renders are heavily letterboxed.** Both are 2000x2000 canvases with the
  cabinet occupying roughly the middle fifth (effective subject ~400x600 px). They are the
  official assets and there is no larger version, but they will need cropping before use.
- **The three KEF files sit exactly on the 800 px minimum** and are references for an
  unidentified SKU, not product photos for it. `kef.com.tr` stores one rendition per
  product and blocks direct scraping (403 on curl for HTML, though the `/dsy/` image paths
  serve fine), so there is no larger original to fetch. The FLS 5,7 file at 225x800 is a
  tall narrow crop - usable for identification, not for a product card.
- **Nothing was found for IMG/COF/00138 itself**, because the product was not identified
  (§4.1). Its `image: null` should stay null.
- No wrong-variant files needed deleting; the four reference files are prefixed `REF__` and
  explained above.

---

## 8. Recommended changes, in priority order

Ordered by commercial risk, not effort. Nothing below has been applied.

### P1 - Actively wrong copy on a published, priced SKU

1. **IMG/OVE/00027 - rewrite the `short_description` and add a `description` +
   `technical_specification`.** The current line calls it a stacking accessory; it is a
   **water-supply and waste-water installation kit**. Concrete fields:
   - `short_description` -> a Unit connection kit that plumbs a RATIONAL combi in: 2 m water
     inflow hose plus a complete DN 50 waste-drain set
   - `description` -> prose + `<h3>Key Features</h3>` + the contents list, in the Skymsen
     pattern used across the rest of the catalogue
   - `technical_specification` -> table with Brand / Article Number **60.70.464** / Type /
     Water inflow hose 2 m, 1/2" with 3/4" screw connection / Drain DN 50 (DN 40-DN 50
     adapters for XS 6-2/3) / full contents / Compatible types XS 6-2/3, 6-1/1, 10-1/1,
     6-2/1, 10-2/1, 20-1/1, 20-2/1
   - `meta_description` -> new
   - **`model_number`: propose `60.70.464`** (currently `null`, so this is a fill rather
     than an overwrite - but still needs approval per `[[feedback_model_number_unique_id]]`)
   - **Do not** describe it as a stacking or Combi-Duo kit anywhere.

### P2 - Invalid model number on a published SKU

2. **IMG/HYS/00207 - resolve `56.00.22` with the supplier.** It matches no Rational article.
   Confirm which is actually in stock:
   - `56.00.210` / `56.00.210A` - 100-count round bucket (**what the stored photo shows**)
   - `56.02.315E` - 130-count rectangular tub (**what Rational sells today**)

   Then set `model_number` accordingly. **Do not change it on the strength of this research
   alone** - it is the catalogue's unique ID.
3. **IMG/HYS/00207 - add `description` + `technical_specification`** once the article is
   confirmed. Rows: Brand / Article Number / Product Type (phosphate- and phosphorus-free
   alkaline cleaner tablet, individually foil-wrapped) / Pack Quantity (100 or 130) /
   Compatible Units (all SelfCookingCenter from 2004, CombiMaster Plus with automatic
   cleaning, iCombi Pro and iCombi Classic with Efficient CareControl) / Composition and
   hazard statements **once the SDS is obtained**. Leave dosing out - no published figure
   (§2.1).

### P3 - Draft records that are ready to publish

4. **IMG/COF/00128 - build out and publish.** Add `description`, `technical_specification`
   and dimensions from §3.1. Dimensions **W 120 x D 245 x H 350 mm** - do not copy
   IMG/COF/00044's numeric fields, which carry the axis swap. Write the grind adjustment
   without a step count. Set the image from
   `IMG-COF-00128__Rancilio-Rocky-Doser-black.jpg`.
5. **IMG/COF/00128 + IMG/COF/00044 - reconcile the pair.** Same grinder, two finishes,
   21% apart in price, and neither record says which finish it is. Either make the finish
   explicit in both, or convert to a variable product with a finish attribute (the
   `GROUP/...` pattern already used for the RATIONAL grills).
6. **IMG/COF/00047 - build out and publish.** Add `description` +
   `technical_specification` from §3.2: 4 L capacity, removable milk container, compressor
   cooling, rear thermostat knob, milk siphoned directly from the container into the
   machine, designed for sites with low fresh-milk drink volume.
   **Write the milk-chilling copy - it is supportable.** **Do not write a temperature
   range** - Egro publishes none. Set the image from
   `IMG-COF-00047__EGRO-Quick-Milk-Fridge-front-official.png` (crop first).
7. **IMG/COF/00047 - remove it from IMG/COF/00071's `accessories` array.** An Egro-proprietary
   milk fridge cannot serve a KALERM FAO 30 (§3.2). This is a live mis-sell on a published
   product page.

### P4 - Leave alone / confirm with supplier

8. **IMG/COF/00138 - keep `draft`, keep `image: null`, keep `model_number: null`.** Ask the
   supplier for the KEF model code before anything else. It has zero stock, so there is no
   cost to waiting, and 771,250 KES is too much to publish on a guess (§4.1).
9. **`brands.json` KEF `website_url`** points at `kef-factory.com`, which sells no coffee
   equipment; the brewers all come from `kef.com.tr` (§4.2). Worth a decision, but it is a
   brand-level change and outside this pass's scope.
10. **`MAEA03`** - leave exactly as stored. Unverifiable, most likely a Rancilio Group
    internal order code (§3.2).
11. **Confirm discontinuation status with the supplier** for the Rocky and the Egro Zero
    fridge. Both are off their manufacturers' current catalogues; a re-order will be quoted
    against a successor (Kryo/Stile SD for the grinder; MK4 or FUM for the fridge) whose
    specs differ.

---

## Image sourcing - RANCILIO + KEF (July 2026)

An image-only pass over the 13 RANCILIO and 5 KEF SKUs that were text-enriched earlier but
never had an image pass. Every SKU already carried a catalogue image; the point of this pass
was to source an **independent** photo for each and compare it against the stored one. Four
stored images turned out to show a different machine, and two of those show a **different
manufacturer's** machine.

Staging: `Desktop\ecommerce\products resource\rancilio-images\` and `...\kef-images\`.
Nothing was copied into the project and no `products.json` / `brands.json` field was touched.

### 6.1 Coverage - stated plainly

**RANCILIO - 13 SKUs**

| Bucket | Count | SKUs |
|---|---|---|
| Exact model, verified | 10 | IMG/COF/00035, 00036, 00037, 00038, 00039, 00041, 00079, 00044, 00135, IMS/MEC/00469 |
| Exact family, cannot be narrowed further by photograph | 1 | IMG/COF/00043 (Kryo 65 ST - see 6.5) |
| Representative / reference only | 2 | IMG/COF/00048 (`REPRESENTATIVE-DVA-IV12`), IMS/MEC/00303 (`REPRESENTATIVE-` + `REF__`) |
| Nothing | 0 | - |

**KEF - 5 SKUs**

| Bucket | Count | SKUs |
|---|---|---|
| Exact model, verified | 5 | IMG/COF/00101, 00103, 00104, 00105, IMS/FIT/00992 |
| Representative / reference only | 0 | - |
| Nothing | 0 | - |

**18 of 18 SKUs got at least one image. 15 of 18 are exact-model.** The three that are not
exact are stated as such and are marked in the filename rather than passed off:

- **IMS/MEC/00303 "Coffee Tamper Stainless Steel"** - `model_number` is the literal phrase
  `STAINLESS STEEL`, which is not a model code. Rancilio's own catalogue tamper is a
  **black handle on a steel base**, not the one-piece all-steel tamper in our stored photo.
  Two files staged - the genuine Rancilio 58 mm tamper as `REF__`, and a one-piece polished
  stainless tamper as `REPRESENTATIVE-`. **Deliberate abstention on an exact match:** the
  stored photo is a generic unbranded item and no manufacturer can be identified from it.
- **IMG/COF/00048 "Water Softeners DP2" / `IV8`** - the IV series is real (6.6) but DVA
  publish `a_iv12` and `a_iv16` renders and no `a_iv8`. The IV12 render is staged as
  `REPRESENTATIVE-`; the units are identical apart from height.
- **IMG/COF/00043 "Kryo 65 ST"** - see 6.5. Every source, **including Rancilio's own site**,
  serves the same photograph for the ST and the AT. No image anywhere can discriminate them.

### 6.2 Contradictions found between a sourced image and the stored record

Reported, not fixed. Nothing in `products.json` was changed.

1. **IMG/COF/00079 "Cappuccino Machine Silvia Pro" - stored image is the wrong machine.**
   The stored `cappuccino-machine-silvia-pro-imgcof00079.png` is a **plain single-boiler
   Silvia** - three rocker switches, one steam knob, no display, no gauge. It is very nearly
   the same render as the stored image on IMG/COF/00041 (the base Silvia), so the two SKUs
   currently show the same machine. The real Silvia Pro / Pro X is a **dual-boiler** machine
   with a **digital PID display on the top panel** and a **pressure gauge above the drip
   tray** - visible in every file staged under `IMG-COF-00079__*`. The stored copy on 00079
   correctly describes dual boilers, PID and a shot-timer display, so the **copy is right and
   the picture is wrong**.
2. **IMG/COF/00104 "Coffee Brewer with 2 Decanter FTL120-2 Inox" - stored image is a
   competitor's machine.** The stored render is a **Coffee Queen / Crem International "XBP"**
   twin-decanter brewer - the Coffee Queen device and the marking `XBP` are legible on the
   control panel. It is not a KEF. The genuine KEF FLT120-2 has the same two-tier layout,
   which is presumably how the substitution went unnoticed.
3. **IMG/COF/00101 "Decanter 1.8 Litres KEF" - stored image is a competitor's decanter.**
   The glass carries a printed **"COFFEE QUEEN ORIGINAL"** roundel. Again Coffee Queen, not
   KEF. KEF's own 1.8 L glass pot is staged.
4. **IMG/COF/00103 "Coffee Brewer with 1 Decanter FTL120 Black" - stored image is the wrong
   KEF line.** The stored render is a **KEF Filtronic FLC 120**: four capacitive touch keys
   (Warm / Brew / Power / Select), a `Filtronic` script on the fascia, and a stainless brew
   funnel over the decanter. The **Filtro FLT120** that the `model_number` names is a
   different machine - two rocker switches, a `Filtro` script, no touch panel. Both are
   staged: the FLT120 as the primary, the FLC120 as `REF__NOT-FLT120__` so the mismatch stays
   on record.
5. **IMG/COF/00048 "Water Softeners DP2" - stored image is BWT-branded.** Zooming the stored
   render reads a legible label - `PULIZIA CARTUCCIA - VEDI MANUALE / CLEANING CARTRIDGE -
   SEE MANUAL / ...` over the wordmark **`BWT bestcup`**. So a SKU filed under brand RANCILIO
   with `model_number: IV8` (a **DVA** code, 6.6) is illustrated with a **BWT** unit. Three
   different makers implicated by one record. The *form factor* is right - stainless
   cylinder, black T-handle regeneration valve, side bypass block, black base - it is the
   badge that disagrees.
6. **IMG/COF/00044 "Coffee Grinder Rocky" - stored image cannot confirm the variant.** The
   stored render shows the Rocky's stainless body and hopper from an angle where the grind
   chute, doser and portafilter fork are all out of frame, so it cannot be used to decide
   doser vs doserless. The staged file is the **doserless (SD)**. Note the sibling SKU
   IMG/COF/00128 is the **doser** variant in black, already staged in an earlier pass.
7. **IMG/COF/00041 - no contradiction.** Rancilio's official render and the stored image
   agree: base Silvia, manual thermostat, no PID. Recorded because a dealer photo initially
   suggested otherwise - see the `REF__` note in 6.4.
8. **IMG/COF/00037 vs 00038 - no mix-up. The stored images are correct.** Verified against
   both Rancilio's own renders and dealer photography: the stored 00037 shows **anthracite
   black** side panels and the stored 00038 shows **ice white** side panels, matching their
   names. Worth recording *how* this was checked, because it is easy to get wrong: on a
   Classe 5 the colour lives **only on the side panels**, so a straight-on front shot of the
   black and the white machine are near-identical. Only a 3/4 view settles it, which is why a
   3/4 view is staged for each. A third factory colour, **Stone Grey**, also exists and is
   another way this pair can be mis-picked.

### 6.3 KEF - who actually makes these brewers (settles 4.2)

**KEF is genuinely KEF Endustriyel, Turkey - `kef.com.tr` - and every one of our five KEF
SKUs maps onto a current, published KEF product.** The earlier doubt is resolved:

- `brands.json` points KEF at `https://kef-factory.com/`, which sells no coffee equipment.
  That remains true and remains wrong, but it does not mean the brewers are not KEF's.
- KEF's filter-coffee range is three lines, and **the line prefix is the model code prefix**:
  - **Filtro = `FLT`** - mechanical, rocker switches, glass decanter. FLT120, FLT120-2,
    FLT120-T, FLT120-AP, FLT250.
  - **Filtronic = `FLC`** - programmable, capacitive touch panel. FLC120, FLC120-T,
    FLC120-AP, FLC 250.
  - **Filtronist = `FLS`** - touchscreen. FLS 2,5 / FLS 5,7 / FLS-250.
- That resolves the internal `FTL120` vs `FLT120` disagreement flagged for this pass: **`FLT`
  is correct** and IMG/COF/00103's `FTL120 BLACK` is a **transposition**. IMG/COF/00104's
  `FLT120 INOX` has the letters in the right order but its product *name* says `FTL120-2`.
- It also confirms the catalogue's own naming logic is sound: our "**Cater**" SKUs are the
  thermos models and our "**Decanter**" SKUs are the glass-pot models, exactly as section 4
  argued. IMG/COF/00105 "Single Cater FLC 250" is **KEF Filtronic 250**, whose own product
  page gives its model code as **`FLC 250`** verbatim.
- KEF sell the FLT120-2 as **"Gri" (grey)** rather than "inox"; the panels are brushed
  stainless, so 00104's `INOX` is a defensible description of the same finish.
- Also observed: KEF sell the FLT120 in **graffiti / decor-print special editions**, and in
  **sage green and yellow**. Not relevant to us, but it explains why a colour search on this
  model returns confusing results.

Category and model pages used:
https://www.kef.com.tr/filtre-kahve-makineleri
https://www.kef.com.tr/kef-filtro-flt120-filtre-kahve-makinesi
https://www.kef.com.tr/kef-filtro-flt120-2-filtre-kahve-makinesi
https://www.kef.com.tr/kef-filtronic-120
https://www.kef.com.tr/kef-filtronic-250

**Coffee Queen (Crem International, Sweden) is the source of two of our stored KEF images**
(6.2 items 2 and 3). This is worth putting to the supplier: either the Kenyan supplier
actually ships Coffee Queen units under a KEF listing, or whoever built the catalogue pulled
stock photography off the wrong brand.

**No new information on IMG/COF/00138 (the unidentified "Double Cater").** Nothing in KEF's
published range corresponds to a two-thermos brewer, consistent with 4.1. The three `REF__`
candidate images staged in the earlier pass are unchanged.

### 6.4 Files staged - RANCILIO

All under `Desktop\ecommerce\products resource\rancilio-images\`. IMG/COF/00047 and
IMG/COF/00128 were staged in the earlier pass and are unchanged.

| SKU | File | Pixels | Size | Source | Visually confirmed |
|---|---|---|---|---|---|
| IMG/COF/00035 | `IMG-COF-00035__Classe-5-S-1GR-black-front-official.png` | 1024x1024 | 99 KB | https://www.ranciliogroup.com/app/uploads/2019/10/C5S_1GR_BLACK_CLEVER_FRONT-2.png | Classe 5 S, **one** group, anthracite black side panels, RANCILIO badge on the drip-tray fascia, `classe 5` script on the cup rail |
| IMG/COF/00035 | `IMG-COF-00035__Classe-5-S-1GR-black-front.jpg` | 864x864 | 39 KB | https://www.espressoparts.com/products/rancilio-classe-5-s-1gr-espresso-machine-black | Same machine, dealer photography. Black side panel visible at both edges |
| IMG/COF/00035 | `IMG-COF-00035__spec-sheet-Classe-5-S-1-group.pdf` | 2 pp | 674 KB | https://www.ranciliogroupna.com/wp-content/uploads/2021/09/C-Spec-Sheet-RANCILIO-C5-S-1G-08-21.pdf | Rancilio Group NA spec sheet, Classe 5 S 1 Group, 73 lb / 1600 W / 110-120 V |
| IMG/COF/00036 | `IMG-COF-00036__Classe-5-S-TALL-1GR-black-front-official.png` | 1080x1080 | 36 KB | https://www.ranciliogroup.com/app/uploads/2020/09/C5S_TALL_1GR_BLACK_CLEVER_FRONT-3.png | Classe 5 **S Tall**, one group, black. Taller working area / deeper drip tray than the 00035 render |
| IMG/COF/00036 | `IMG-COF-00036__Classe-5-S-TALL-1GR-white-front-official.png` | 1080x1080 | 36 KB | https://www.ranciliogroup.com/app/uploads/2020/09/C5S_TALL_1GR_WHITE_CLEVER_FRONT-2.png | Same in ice white. Staged because our record does **not** state a colour for 00036 |
| IMG/COF/00036 | `IMG-COF-00036__spec-sheet-Classe-5-S-1-group.pdf` | 2 pp | 674 KB | https://www.ranciliogroupna.com/wp-content/uploads/2021/09/C-Spec-Sheet-RANCILIO-C5-S-1G-08-21.pdf | Same 1-group spec sheet; Rancilio Group NA publish no separate S-Tall sheet |
| IMG/COF/00037 | `IMG-COF-00037__Classe-5-S-2GR-black-front-official.png` | 1024x1024 | 221 KB | https://www.ranciliogroup.com/app/uploads/2019/10/C5S_2GR_BLACK_CLEVER_FRONT.png | Classe 5 S, **two** groups, black side panels |
| IMG/COF/00037 | `IMG-COF-00037__Classe-5-S-2GR-anthracite-black-front.jpg` | 1152x1152 | 63 KB | https://www.espressoparts.com/products/rancilio-classe-5-s-2-group-semi-automatic-espresso-machine-anthracite-black | Same, dealer front view |
| IMG/COF/00037 | `IMG-COF-00037__Classe-5-S-2GR-anthracite-black-3q.jpg` | 1152x1152 | 67 KB | https://www.espressoparts.com/products/rancilio-classe-5-s-2-group-semi-automatic-espresso-machine-anthracite-black | **The colour-discriminating shot.** 3/4 view, full black side panel in frame |
| IMG/COF/00037 | `IMG-COF-00037__spec-sheet-Classe-5-S-multi-group.pdf` | 2 pp | 727 KB | https://www.ranciliogroupna.com/wp-content/uploads/2021/06/C-Spec-Sheet-RAN-C5-S-12-20.pdf | 2GRC / 2GR / 3GR spec sheet; 2 Group = 122 lb / 4300 W |
| IMG/COF/00038 | `IMG-COF-00038__Classe-5-S-2GR-white-front-official.png` | 1024x1024 | 220 KB | https://www.ranciliogroup.com/app/uploads/2019/10/C5S_2GR_WHITE_CLEVER_FRONT.png | Classe 5 S, two groups, **ice white** side panels |
| IMG/COF/00038 | `IMG-COF-00038__Classe-5-S-2GR-ice-white-front.jpg` | 1152x1152 | 62 KB | https://www.espressoparts.com/products/rancilio-classe-5-s-2-group-semi-automatic-espresso-machine-ice-white | Same, dealer front view |
| IMG/COF/00038 | `IMG-COF-00038__Classe-5-S-2GR-ice-white-3q-left.jpg` | 1224x1224 | 68 KB | https://www.espressoparts.com/products/rancilio-classe-5-s-2-group-semi-automatic-espresso-machine-ice-white | **The colour-discriminating shot.** 3/4 view, full white side panel in frame |
| IMG/COF/00038 | `IMG-COF-00038__spec-sheet-Classe-5-S-multi-group.pdf` | 2 pp | 727 KB | https://www.ranciliogroupna.com/wp-content/uploads/2021/06/C-Spec-Sheet-RAN-C5-S-12-20.pdf | Same multi-group sheet as 00037 - the colours share one spec sheet |
| IMG/COF/00039 | `IMG-COF-00039__Classe-7-S-3GR-anthracite-black-front.jpg` | 1008x1008 | 38 KB | https://www.espressoparts.com/products/rancilio-classe-7-s-3-group-semi-automatic-espresso-machine-anthracite-black | Classe **7** S, **three** groups, black. `classe 7` script on the cup rail distinguishes it from the Classe 5 |
| IMG/COF/00039 | `IMG-COF-00039__Classe-7-S-3GR-anthracite-black-3q-left.jpg` | 1152x1152 | 51 KB | https://www.espressoparts.com/products/rancilio-classe-7-s-3-group-semi-automatic-espresso-machine-anthracite-black | 3/4 view, black side panel |
| IMG/COF/00039 | `IMG-COF-00039__spec-sheet-Classe-7-S.pdf` | 2 pp | 277 KB | https://www.ranciliogroupna.com/wp-content/uploads/2021/05/C-Spec-Sheet-RANCILIO-CLASSE-7-S-v9.pdf | Rancilio Group NA Classe 7 S spec sheet |
| IMG/COF/00041 | `IMG-COF-00041__Silvia-inox-front-official.png` | 1024x1024 | 78 KB | https://www.ranciliogroup.com/app/uploads/2019/10/SILVIA_SILVER_FRONT.png | Base Silvia in inox. Three rockers, one round steam knob, **no display, no gauge** |
| IMG/COF/00041 | `IMG-COF-00041__Silvia-inox-3q-left-official.png` | 1024x1024 | 95 KB | https://www.ranciliogroup.com/app/uploads/2019/10/SILVIA_SILVER_ISO-FRONT-SX.png | Same, 3/4 left |
| IMG/COF/00041 | `IMG-COF-00041__REF__Silvia-with-added-PID-display-WholeLatteLove.jpg` | 2000x2000 | 87 KB | https://www.wholelattelove.com/products/rancilio-silvia-espresso-machine | Kept as `REF__` **because it disagrees with the factory render**: this dealer shoots the Silvia with a **PID readout fitted below the group**. Rancilio's own spec for the Silvia says manual thermostat, no PID. Do not use as the catalogue image |
| IMG/COF/00079 | `IMG-COF-00079__Silvia-Pro-X-inox-front-official.png` | 1024x1024 | 85 KB | https://www.ranciliogroup.com/app/uploads/2021/10/inox1.png | Silvia Pro X, inox. **Digital display on the top panel**, three rockers, steam knob |
| IMG/COF/00079 | `IMG-COF-00079__Silvia-Pro-X-inox-3q-official.png` | 1024x1024 | 118 KB | https://www.ranciliogroup.com/app/uploads/2021/10/inox2.png | 3/4 view; **pressure gauge above the drip tray** clearly in frame |
| IMG/COF/00079 | `IMG-COF-00079__Silvia-Pro-X-front-stainless.jpg` | 1600x1600 | 91 KB | https://www.wholelattelove.com/products/rancilio-silvia-pro-x-dual-boiler-espresso-machine | Dealer front view; display reads `19.9`, gauge visible |
| IMG/COF/00079 | `IMG-COF-00079__Silvia-Pro-X-front-detail.jpg` | 3456x3456 | 378 KB | https://www.wholelattelove.com/products/rancilio-silvia-pro-x-dual-boiler-espresso-machine | Highest-resolution file in the whole pass. 3/4 studio shot, display + gauge + steam knob all legible |
| IMG/COF/00043 | `IMG-COF-00043__Kryo-65-ST-front-dealer-shared-with-AT.jpg` | 2200x2200 | 54 KB | https://www.espressoparts.com/products/rancilio-kryo-65-st-commercial-espresso-grinder | Kryo 65, black, **doser chamber with lever + portafilter fork**. Filename records that this asset is shared with the AT - see 6.5 |
| IMG/COF/00135 | `IMG-COF-00135__Kryo-65-OD-front-official.jpg` | 1080x1080 | 11 KB | https://www.ranciliogroup.com/app/uploads/2019/09/grinder-kryo-65-OD-front.jpg | Kryo 65 **OD**: no doser, on-demand display and buttons, portafilter fork under the chute |
| IMG/COF/00135 | `IMG-COF-00135__Kryo-65-OD-side-official.jpg` | 1080x1080 | 14 KB | https://www.ranciliogroup.com/app/uploads/2019/09/grinder-kryo-65-OD-side.jpg | Same, side |
| IMG/COF/00135 | `IMG-COF-00135__Kryo-65-OD-back.jpg` | 2200x2200 | 51 KB | https://www.espressoparts.com/products/rancilio-kryo-evo-65-od-commercial-espresso-grinder | Rear view - smooth conical body, no controls. Useful for confirming the OD's bodyshell |
| IMG/COF/00044 | `IMG-COF-00044__Rocky-doserless-front.jpg` | 1000x1000 | 36 KB | https://www.wholelattelove.com/products/rancilio-rocky-doserless-coffee-grinder | Rocky **SD (doserless)**: numbered grind collar, translucent grind chute, wire portafilter support, RANCILIO badge |
| IMG/COF/00048 | `IMG-COF-00048__REPRESENTATIVE-DVA-IV12__IV-series-manual-softener-official.png` | 1080x1080 | 165 KB | https://www.devecchigaetano.com/dva/wp-content/uploads/2023/09/a_iv12-with-background.png | DVA **IV12** manual softener. Same body as our stored photo - stainless cylinder, black T-handle regeneration valve, side bypass block, black base. **Marked representative: DVA publish no IV8 render, only IV12 and IV16.** Note the file has a decorative blue background element that will need cropping |
| IMS/MEC/00303 | `IMS-MEC-00303__REPRESENTATIVE-one-piece-polished-stainless-tamper-58mm.jpg` | 1512x1512 | 20 KB | https://www.espressoparts.com/products/barista-basics-ghost-polish-tamper-58mm-flat-stainless-steel | One-piece polished stainless tamper, 58 mm, waisted barrel and wide flat base - the shape in our stored photo. **Carries a reseller mark (`58 MM` plus a small skull device) on the base fillet**; it is a Barista Basics own-brand item, not Rancilio |
| IMS/MEC/00303 | `IMS-MEC-00303__REF__Rancilio-58mm-tamper-steel-base-black-handle.jpg` | 800x800 | 184 KB | https://www.espressocoffeeshop.com/en/accessories/323-0-rancilio-tamper.html | The **genuine Rancilio** 58 mm tamper - black contoured handle on a brushed steel base with the Rancilio double-R stamped in it. Kept as `REF__` because it is **not** the all-steel tamper our record describes |
| IMS/MEC/00469 | `IMS-MEC-00469__Rancilio-OEM-PVC-tamper-38120005.jpg` | 1200x1200 | 14 KB | https://kaldi.com/products/coffee-tamper | **Exact match to the stored photo.** Black plastic tamper, flat mushroom top, wide flat base. Sold as Rancilio OEM part **`38120005`** - a real part number for a `model_number` currently recorded only as the word `PVC` |
| (multi-model) | `Rancilio-Classe-5-S-parts-catalog-2021.pdf` | 35 pp | 6.4 MB | https://www.ranciliogroupna.com/wp-content/uploads/2021/06/Classe5S_PartsCatalog-05-2021.pdf | Exploded parts catalogue, Classe 5 S. Exempt from the SKU-first rule |
| (multi-model) | `Rancilio-Classe-5-user-manual-2022.pdf` | 72 pp | 9.3 MB | https://www.ranciliogroupna.com/wp-content/uploads/2022/06/46900307_UM_Classe5_-_2022-04.pdf | Classe 5 user manual, April 2022. Exempt from the SKU-first rule |

### 6.5 The Kryo 65 ST / AT problem - no photograph can separate them

Worth recording so nobody re-runs this search. Rancilio's Kryo 65 comes in **ST** (doser),
**AT** (doser plus automatic timer) and **OD** (on-demand). The ST and AT are **visually
identical** - they differ in dosing electronics behind an identical fascia. Evidence:

- Espresso Parts serves the byte-identical photo `kryo-65-grinder_frt.jpg` on **both** its
  Kryo 65 ST and Kryo 65 AT product pages (the ST copy simply carries a Shopify UUID suffix):
  https://www.espressoparts.com/products/rancilio-kryo-65-st-commercial-espresso-grinder
  https://www.espressoparts.com/products/rancilio-kryo-65-at-commercial-espresso-grinder
- **Rancilio's own site does the same.** The Kryo 65 ST page and the Kryo 65 AT page both
  serve `grinder-kryo-65-AT-white-front.jpg`, `...-right-side.jpg` and `...-back.jpg`, and
  the ST page carries **no ST-specific render at all**:
  https://www.ranciliogroup.com/rancilio/kryo/kryo-65-st/
  https://www.ranciliogroup.com/rancilio/kryo/kryo-65-at/

So IMG/COF/00043's staged image is correct at the family level (Kryo 65, doser variant, black)
and cannot be pushed further. The stored catalogue image has the same limitation and is not
wrong. **This is a photograph-cannot-help case, not a data error.** The OD (IMG/COF/00135) is
a different matter - it is trivially distinguishable and both stored and sourced images agree.

Also noted: Rancilio have refreshed the range as **Kryo Evo 65 OD** and now shoot it in
**white**; the black renders in this pass are the outgoing finish, which matches our stored
photography.

### 6.6 `IV8` vs `DP2` - both codes are real, and neither is Rancilio's

IMG/COF/00048 was flagged as a name/code disagreement ("Water Softeners DP2" carrying
`model_number: IV8`). Both halves resolve, and the answer is that **neither code is a Rancilio
code**:

- **`IV8` is a DVA code.** DVA = **De Vecchi Gaetano**, Italy. Their **IV series** of manual
  ion-exchange water softeners runs **IV8 / IV12 / IV16 / IV20**, the number being resin
  litres. The IV8 is an 8 L stainless unit, 190 mm diameter x 400 mm high, 7.5 kg, 3/8" G
  connections, 1-8 bar, about 900 l/h, about 1 kg of salt per regeneration. Instruction
  manuals are published under both "DVA IV8" and "DE VECCHI IV8":
  https://www.manualslib.com/manual/1228461/Dva-Iv8.html
  https://www.manualslib.com/manual/1270248/De-Vecchi-Iv8.html
  DVA's own product index, and the source of the staged render:
  https://www.devecchigaetano.com/dva/prodotti/
- **`DP2` appears in Rancilio's own documentation as a softener size.** The Rancilio Epoca
  instruction manual refers to a "Softener DP2 - DP4" and gives a regeneration schedule
  against daily coffee volume. So "DP2" is plausibly how the size was written on a Rancilio
  order form and became the product name.
- **The stored photo is neither** - it is a **BWT bestcup** (6.2 item 5).

For the record: this SKU is a **bought-in Italian manual water softener**, not a
Rancilio-manufactured product, and the brand attribution in `products.json` should be put to
the supplier before the `model_number` is touched. Per the standing rule, `IV8` was **not**
changed.

Other sources used for this section:
https://www.torocaffe.com/it/addolcitore-manuale-dva-8-lt
https://www.elektros.it/it/it/equipaggiamento/addolcitore-di-acqua-manuale-8-litri-iv8.html
https://www.boisecoffeesupply.com/products/manual-water-softener-dva-lt8-8l-stainless-steel

### 6.7 Files staged - KEF

All under `Desktop\ecommerce\products resource\kef-images\`. The three `IMG-COF-00138__REF__`
files are from the earlier pass and are unchanged.

**Resolution note:** every KEF image found, across the manufacturer's own site and three
Turkish distributors, tops out at **800 px on the long edge**. That is exactly the floor, not
below it, so nothing here needed a `-TOOSMALL` marker - but there is no headroom.
`witcdn.cafemarkt.com` serves `-B` (800 px), `-K` (500 px) and `-O` (800 px) variants of the
same shot and there is no larger master behind them.

| SKU | File | Pixels | Size | Source | Visually confirmed |
|---|---|---|---|---|---|
| IMG/COF/00101 | `IMG-COF-00101__KEF-glass-decanter-cam-pot-18L-official.jpg` | 800x800 | 31 KB | https://www.kef.com.tr/dsy/cam-pot-11909.jpg | KEF's own 1.8 L glass pot: tapered heat-resistant glass body, black hinged lid, black moulded handle. **No Coffee Queen roundel** - contrast with the stored image |
| IMG/COF/00103 | `IMG-COF-00103__KEF-Filtro-FLT120-black-3q-cafemarkt.jpg` | 800x800 | 69 KB | https://www.cafemarkt.com/kef-filtro-flt120-filtre-kahve-makinesi-siyah | **Best FLT120 shot found.** Black Filtro FLT120, 3/4 view: `KEF` wordmark and `Filtro` script on the fascia, **two rocker switches**, swing-out brew basket, one glass decanter on the base warming plate |
| IMG/COF/00103 | `IMG-COF-00103__KEF-Filtro-FLT120-black-front-official.jpg` | 800x800 | 27 KB | https://www.kef.com.tr/dsy/flt-11907.jpg | Same machine, factory front elevation |
| IMG/COF/00103 | `IMG-COF-00103__KEF-Filtro-FLT120-black-3q-official.jpg` | 633x800 | 53 KB | https://www.kef.com.tr/dsy/flt-11903.jpg | Same machine, factory 3/4 |
| IMG/COF/00103 | `IMG-COF-00103__REF__KEF-Filtro-FLT120-inox-single-decanter-official.jpg` | 271x800 | 27 KB | https://www.kef.com.tr/dsy/flt-11886.jpg | `REF__`: the **inox/grey** FLT120. Our 00103 is the black one; staged so the finish options are on record. Narrow crop |
| IMG/COF/00103 | `IMG-COF-00103__REF__NOT-FLT120__KEF-Filtronic-FLC120-touchpanel-black.jpg` | 570x800 | 33 KB | https://www.kef.com.tr/dsy/flc120-11871.jpg | `REF__NOT-FLT120__`: the **Filtronic FLC 120** - four touch keys, `Filtronic` script, stainless brew funnel. **This is what the stored 00103 image actually shows** |
| IMG/COF/00103 | `IMG-COF-00103__REF__NOT-FLT120__KEF-Filtronic-FLC120-touchpanel-grey.jpg` | 800x800 | 49 KB | https://www.cafemarkt.com/kef-filtronic-flc-120-programlanabilir-filtre-kahve-makinesi-gri | Same FLC 120 in grey, larger and sharper - the shot that made the `Filtronic` fascia script legible and confirmed the identification |
| IMG/COF/00104 | `IMG-COF-00104__KEF-Filtro-FLT120-2-grey-inox-two-decanters-cafemarkt.jpg` | 800x800 | 50 KB | https://www.cafemarkt.com/kef-filtro-flt120-2-cift-potlu-filtre-kahve-makinesi-gri | **Best FLT120-2 shot found.** Brushed-steel body, `KEF` wordmark, **two** glass decanters - one on the upper warming plate, one under the brew basket. Structurally identical to the Coffee Queen XBP in the stored image, which is exactly why the substitution was not caught |
| IMG/COF/00104 | `IMG-COF-00104__KEF-Filtro-FLT120-2-grey-inox-alt-cafemarkt.jpg` | 800x800 | 34 KB | https://www.cafemarkt.com/kef-filtro-flt120-2-cift-potlu-filtre-kahve-makinesi-gri | Second angle of the same unit |
| IMG/COF/00104 | `IMG-COF-00104__KEF-Filtro-FLT120-2-inox-two-decanters-official.jpg` | 800x800 | 41 KB | https://www.kef.com.tr/dsy/flt-11908.jpg | Factory shot of the inox FLT120-2, two decanters, brew funnel in the middle tier |
| IMG/COF/00104 | `IMG-COF-00104__KEF-Filtro-FLT120-2-black-two-decanters-official.jpg` | 311x800 | 35 KB | https://www.kef.com.tr/dsy/flt-11887.jpg | The **black** FLT120-2. Staged for contrast since our record says INOX. Narrow crop |
| IMG/COF/00105 | `IMG-COF-00105__KEF-Filtronic-250-FLC250-3q-official.jpg` | 532x800 | 36 KB | https://www.kef.com.tr/dsy/kef-filtronic-250-489440.jpg | KEF Filtronic 250, model code `FLC 250`: stainless side panel, touch fascia, **black 2.5 L thermal container** in place of a glass decanter |
| IMG/COF/00105 | `IMG-COF-00105__KEF-Filtronic-250-FLC250-side-official.jpg` | 532x800 | 33 KB | https://www.kef.com.tr/dsy/kef-filtronic-250-579440.jpg | Side elevation. **This is the same view as the stored catalogue image - 00105's stored photo is correct** |
| IMG/COF/00105 | `IMG-COF-00105__KEF-Filtronic-250-FLC250-front-official.jpg` | 532x800 | 33 KB | https://www.kef.com.tr/dsy/kef-filtronic-250-979440.jpg | Front elevation |
| IMS/FIT/00992 | `IMS-FIT-00992__KEF-basket-filter-papers-official.jpg` | 800x800 | 32 KB | https://www.kef.com.tr/dsy/filters-11873.jpg | KEF's own basket filter papers, shown as the in-box accessory on the Filtronic 120 page: fluted white paper basket, straight sidewall. Matches the stored image. **Does not confirm the `90/250` size or the `FK925` code** - KEF publish neither |

### 6.8 Open questions for the supplier

1. **IMG/COF/00104 and IMG/COF/00101 - is the shipped product KEF or Coffee Queen?** Two
   stored images are Coffee Queen (Crem International) products under KEF listings. Either
   the images are wrong or the brand attribution is. This needs answering before either
   record is edited, because the fix differs completely in the two cases.
2. **IMG/COF/00103 - is the shipped machine a Filtro FLT120 or a Filtronic FLC 120?** The
   `model_number` says one and the stored image shows the other. They are different machines
   at different price points - mechanical rocker switches versus a programmable touch panel.
3. **IMG/COF/00048 - is this a DVA IV8, or the BWT bestcup in the photo?** And should it be
   filed under RANCILIO at all? See 6.6.
4. **IMS/MEC/00303 - who makes it?** `model_number: STAINLESS STEEL` is not a code and the
   stored photo is an unbranded generic. Cannot be resolved without the supplier.
5. **IMG/COF/00043 - ST or AT?** Not answerable from any photograph (6.5); only the
   supplier's order code or the machine's own rating plate will settle it.
6. **IMG/COF/00101 - what is `CMP-2`?** No decanter model code `CMP-2` could be traced to KEF
   or to any other brewer manufacturer. KEF list their glass pot only as a spare, without a
   code. Left untouched.

---

## 9. Image sourcing - RATIONAL (July 2026)

> **Provenance - read before trusting this section.** This write-up was reconstructed after
> two agent crashes. The pass itself (sourcing, downloading, opening and visually checking
> every file) was completed once and never lost - the files have been sitting on disk since
> 27 July. What was lost twice was the prose. The full draft was eventually recovered intact
> from the first agent's final `Write` payload, so the text below is the original author's,
> not a paraphrase. **Every numeric claim in §9.1 - pixel dimensions, file sizes, page counts
> - was then independently re-measured from the bytes on disk with PIL/PyMuPDF, and all 59
> rows matched with no corrections needed.** The MD5 claims in §9.3 finding 4 were also
> re-checked and both duplicate pairs confirmed. **Source URLs were recovered for all 59
> staged files; none is missing and none has been invented.** The one thing that cannot be
> re-verified mechanically is the "Verified as" column - those are the original agent's
> visual judgements, carried over as written.

**59 files staged in `Desktop\ecommerce\products resource\rational-images\`** (55 images +
4 PDFs; 3 of those files sit in `_brand-reference\`). Covers the 30 RATIONAL SKUs that were
enriched text-only and never had an image pass. Naming follows the house convention,
`<SKU-with-dashes>__<descriptor>.<ext>`, with markers **after** the SKU. Every file below
was opened and visually checked. **Nothing was copied into the Laravel project and nothing
in `products.json` or `brands.json` was touched.**

The folder holds **61** files in total. The two not listed below -
`IMG-HYS-00207__REF__RATIONAL-cleaner-tab-P-free-56-02-315-tub-official.jpg` (1280x854) and
`IMG-OVE-00027__RATIONAL-60-70-464-unit-connection-kit-official.jpg` (2880x1920) - were
staged by the earlier §7 pass, not this one. That is also why the scope here is 30 SKUs and
not 32: `products.json` carries **32** rows with `brand == "RATIONAL"`, and IMG/HYS/00207 and
IMG/OVE/00027 were already handled in §7. The remaining 30 split exactly **10 care/cleaning
consumables (`IMG/HYS/*`) + 20 oven accessories (12 `IMG/OVE/*` + 8 `GROUP/*` parents)**.

Sources used, in order of yield:

- https://www.rational-online.com/en_xx/accessories/ - the accessory index embeds a
  JS array (`accessory.allData`) listing all 87 accessory pages with their hero images. The
  page markup serves a `-fix725x370` crop; **dropping that suffix returns the 1920x1280 or
  2000x1415 original**. Same trick as the Dr.Coffee and connection-kit cases in §7.
- https://www.webstaurantstore.com - product pages expose an `xxl` rendition at
  **2000x2000**, which beats RATIONAL's own site on most single-article shots. Highest-yield
  source in this pass, but see finding 4 below before trusting it blind.
- https://www.catering-appliance.com - assets under
  `assets.catering-appliance.com/media/inside-sqr-2048/...` reach ~2040 px and carry article
  numbers RATIONAL's current pages have dropped.
- https://kitchenrestock.com - Shopify, 1000x1000 originals. The only source holding the
  legacy SCC/CMP-generation articles (`60.22.086`, `60.61.047`), and the only one with a
  correctly-photographed `6035.1015`.
- https://www.goforgreenuk.com - 1100x1100, used for the 2/3 GN grid.

### 9.1 Files staged

| SKU | File | Pixels | Size | Source | Verified as |
|---|---|---|---|---|---|
| IMG/HYS/00033 | `IMG-HYS-00033__9006.0137-rinse-aid-10-litre-blue-canister.jpg` | **2000x2000** | 286 KB | https://www.webstaurantstore.com/rational-9006-0137-liquid-rinser-agent-10l-blue/HP90060137.html | **Exact.** Blue jerrycan; label reads "Klarspuler / Rinse aid", "Art.-No. 9006.0137", "10 Ltr / 2.64 US Gal." Confirms both the article number and the record's "10-litre blue container" |
| IMG/HYS/00034 | `IMG-HYS-00034__56.00.562-care-tab-bucket-100-plus-50.jpg` | **2000x2000** | 356 KB | https://www.webstaurantstore.com/rational-56-00-562-care-tabs-for-selfcookingcenter-combi-ovens-with-care-controls-case/6455600562.html | **Exact.** White RATIONAL bucket, blue "Tab 100 + 50" panel, "Art.-Nr. 56.00.562". Confirms the record's "150 per bucket" |
| IMG/HYS/00034 | `IMG-HYS-00034__56.00.562-care-tab-bucket-with-sachets.jpg` | 1920x1280 | 188 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-reiniger-care-tab-rational-106768.jpg | **Exact.** Same bucket with three dark-blue Care-Tab sachets in front |
| IMG/HYS/00034 | `IMG-HYS-00034__spec-sheet-care-tabs-safety-data-sheet.pdf` | 19 pp | 162 KB | https://hcms.rational-online.com/hcms/v1.7/entity/documents/44519/storage/MDA0NDUxOS8wL21hc3Rlci8vLzk4NTM2MDIz/download/sds_rational_care-tab-en_uk_pdf.pdf | RATIONAL SDS v9.1 (2024-11-22). Section 1.1 lists **Article No. 56.00.562; 56.01.527; 56.01.529** - independent confirmation the stored code is genuine |
| IMG/HYS/00035 | `IMG-HYS-00035__56.00.562-care-tab-single-sachet.jpg` | **2000x2000** | 497 KB | https://www.webstaurantstore.com/rational-56-00-562-care-tabs-for-selfcookingcenter-combi-ovens-with-care-controls-case/6455600562.html | **Exact for a loose tab.** One dark-blue foil sachet, "+care" roundel, "Care-Tab", tear notches top and bottom |
| IMG/HYS/00035 | `IMG-HYS-00035__56.00.562-care-tab-loaded-into-oven.jpg` | **2000x2000** | 445 KB | https://www.webstaurantstore.com/rational-56-00-562-care-tabs-for-selfcookingcenter-combi-ovens-with-care-controls-case/6455600562.html | In-use shot: gloved hand holding an opened Care-Tab sachet with two white tablets visible, at the oven's care drawer |
| IMG/HYS/00038 | `IMG-HYS-00038__56.00.210-cleaner-tab-single-sachet-loading.jpg` | **2000x2000** | 574 KB | https://www.webstaurantstore.com/rational-56-00-210a-cleaner-tabs-for-selfcookingcenter-combi-ovens-case/6455600210.html | **Exact for a loose tab.** Gloved hand, red/silver "Reiniger - Cleaner" sachet, white tablet half out, at the cleaner drawer behind the fan wheel |
| IMG/HYS/00038 | `IMG-HYS-00038__56.00.210-cleaner-tab-round-bucket.jpg` | 1543x1300 | 90 KB | https://assets.catering-appliance.com/media/inside-sqr-2048/a6/88/rational-5600210_img183595.jpg | **Exact pack.** The legacy **round** salmon-labelled RATIONAL "Reiniger-Tab / Cleaner tab" bucket with two sachets |
| IMG/HYS/00038 | `IMG-HYS-00038__REF__56.02.315-cleaner-tab-p-free-successor-bucket.jpg` | 1280x854 | 68 KB | https://www.rational-online.com/media/images/accessories/cleaning/56-02-315-cleaner-tabs-p-free-selfcookingcenter-combimaster-plus-persp-1702717.jpg | **Reference, successor generation.** Rectangular "Reiniger-Tab P-frei / Cleaner tab P-free" bucket, article `56.02.315` - what RATIONAL's current page serves in place of `56.00.210`. Same file already noted in §7 against IMG/HYS/00207 |
| IMG/HYS/00039 | `IMG-HYS-00039__6006.0110-descaler-10-litre-canister.jpg` | 850x850 | 89 KB | https://www.webstaurantstore.com/rational-6006-0110us-1-gallon-descaling-agent-case/64560060110.html | **Exact.** Natural HDPE jerrycan, yellow corrosive label reading "Entkalker / Decalcifyer, **Art.-No. 6006.0110**". Smallest file in the set but over the 800 px bar; RATIONAL's own page serves this shot only at 725x370 |
| IMG/HYS/00040 | `IMG-HYS-00040__56.00.211-rinse-aid-tab-bucket-50-tabs.jpg` | **2000x2000** | 395 KB | https://www.webstaurantstore.com/rational-56-00-211-rinsing-tabs-for-selfcookingcenter-combi-ovens-without-care-control-case/6455600211.html | **Exact.** Handled bucket, "Klarspuler - Rinse Agent", "6.6 lbs / 3 kg, **50 Tabs**", "Art.-Nr. 56.00.211". Confirms the record's "50 per bucket" |
| IMG/HYS/00040 | `IMG-HYS-00040__56.00.211-rinse-aid-tab-single-sachet.jpg` | **2000x2000** | 655 KB | https://www.webstaurantstore.com/rational-56-00-211-rinsing-tabs-for-selfcookingcenter-combi-ovens-without-care-control-case/6455600211.html | Single blue/silver "Klarspuler - Rinse agent" sachet |
| IMG/HYS/00040 | `IMG-HYS-00040__56.00.211-rinse-aid-tab-bucket-with-sachets.jpg` | 1920x1280 | 266 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-rinse-aid-tabs-bucket-packed-rational-65433.jpg | RATIONAL's own studio shot, bucket plus two sachets |
| IMG/HYS/00040 | `IMG-HYS-00040__spec-sheet-rinse-aid-tab-safety-data-sheet.pdf` | 13 pp | 156 KB | https://hcms.rational-online.com/hcms/v1.7/entity/documents/1039382/storage/MDAxMDM5MzgyLzAvbWFzdGVyLy8vMTAwODc5MTA5/download/sds_rational_rinseaid-tab-en_ghs_pdf.pdf | RATIONAL SDS v8.0. Section 1.1: **Article No. 56.00.211; 56.01.904** |
| IMG/HYS/00085 | `IMG-HYS-00085__REPRESENTATIVE-56.01.535-active-green-cleaner-tab-bucket.jpg` | **2000x2000** | 391 KB | https://www.webstaurantstore.com/rational-56-01-535-active-green-cleaner-tabs-for-icombi-pro-and-icombi-classic-combi-ovens-case/6455601535.html | **Representative.** Bucket labelled "Reiniger-Tab / Cleaner Tab Active Green", "11.57 lbs / 5.25 kg / 150 Tabs". Right product, but the pack shown is `56.01.535`, not the record's `56.01.628` - see §9.4 |
| IMG/HYS/00085 | `IMG-HYS-00085__REPRESENTATIVE-active-green-cleaner-tab-bucket-with-sachets.jpg` | 1920x1280 | 199 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-reiniger-tab-active-green-rational-106770.jpg | Same product, RATIONAL studio shot with green sachets |
| IMG/HYS/00085 | `IMG-HYS-00085__spec-sheet-active-green-cleaner-tab-safety-data-sheet.pdf` | 18 pp | 159 KB | https://hcms.rational-online.com/hcms/v1.7/entity/documents/745622/storage/NzQ1NjIyLzAvbWFzdGVyLy8vMTExMzQyNTIy/download/sds_rational_cleaner-tab_activegreen-en_uk_pdf.pdf | RATIONAL SDS v5.1 (2024-11-25). Section 1.1: **Article No. 56.01.535; 56.01.628; 56.01.527**. This is the document that proves `56.01.628` is genuine |
| IMG/HYS/00096 | `IMG-HYS-00096__56.01.535-active-green-cleaner-tab-single-sachet.jpg` | **2000x2000** | 530 KB | https://www.webstaurantstore.com/rational-56-01-535-active-green-cleaner-tabs-for-icombi-pro-and-icombi-classic-combi-ovens-case/6455601535.html | **Exact for a loose tab.** Single green/silver "Reiniger - Cleaner ... Active Green" sachet |
| IMG/HYS/00096 | `IMG-HYS-00096__56.01.535-active-green-cleaner-tab-bucket.jpg` | 1300x835 | 54 KB | https://assets.catering-appliance.com/media/inside-sqr-2048/31/eb/rational-5601535_img183598.jpg | **Exact pack** for `56.01.535`, bucket plus sachets |
| IMG/HYS/00264 | `IMG-HYS-00264__56.01.912-active-green-cleaner-cartridge-and-case.jpg` | 1131x800 | 43 KB | https://assets.catering-appliance.com/media/inside-sqr-2048/5b/ac/rational-5601912_img183392.jpg | **Exact.** Green outer carton with carry handle, "Reiniger Kartusche Active Green / Active Green cleaner cartridge", plus the green cartridge bottle. RATIONAL's own page serves this only at 725x370; WebstaurantStore only at 600x600 |
| IMG/HYS/00265 | `IMG-HYS-00265__56.01.914-care-cartridge-and-case.jpg` | 1131x800 | 47 KB | https://assets.catering-appliance.com/media/inside-sqr-2048/91/30/rational-5601914_img183396.jpg | **Exact.** Blue carton "Care Kartusche / Care cartridge" plus the blue cartridge bottle |
| GROUP/CHICKEN-SUPER-SPIKE | `GROUP-CHICKEN-SUPER-SPIKE__chicken-superspike-8-bird-1-1gn.jpg` | 1920x1358 | 140 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-superspike-chicken-h8-1-1-rational-123844.jpg | **Group hero.** 1/1 GN wire base carrying 8 upright chicken cradles |
| GROUP/CHICKEN-SUPER-SPIKE | `GROUP-CHICKEN-SUPER-SPIKE__6035.1010-chicken-superspike-10-bird-1-1gn.jpg` | **2000x2000** | 258 KB | https://www.webstaurantstore.com/rational-6035-1010-2-lb-chicken-and-duck-super-spike-10-bird-capacity/64560351010.html | **Exact** 10-bird 1/1 GN variant - the group's other member |
| GROUP/CHICKEN-SUPER-SPIKE | `GROUP-CHICKEN-SUPER-SPIKE__REF__duck-superspike-1-1gn.jpg` | 1920x1600 | 105 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-superspike-1-1-duck-rational-123842.jpg | **Reference only** - the duck Superspike (taller cradles, fewer of them), not the chicken rack |
| IMG/OVE/00023 | `IMG-OVE-00023__6035.1015-chicken-superspike-4-bird-1-2gn.jpg` | 1000x1000 | 33 KB | https://kitchenrestock.com/products/rational-6035-1015-chicken-superspike-1-2-size-12-x-10 | **Exact.** Near-square 1/2 GN base with **4** cradles, matching "4 whole birds, 1/2 GN". The only correctly-photographed `6035.1015` found anywhere |
| IMG/OVE/00023 | `IMG-OVE-00023__REF__6035.1006-8-bird-1-1gn-mislabelled-as-6035.1015.jpg` | **2000x2000** | 188 KB | https://www.webstaurantstore.com/rational-6035-1015-2-9-lb-chicken-and-duck-super-spike-4-bird-capacity/64560351015.html | **Reference, wrong variant, kept as evidence.** Served under `6035.1015` but byte-identical to the same site's `6035.1006` file and showing the **8-bird 1/1 GN** rack. See §9.3 finding 4 |
| GROUP/COMBI-FRY | `GROUP-COMBI-FRY__combifry-1-1gn.jpg` | **2000x1415** | 66 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-combifry-1-1-rational-63572.jpg | **Group hero.** Fine-mesh perforated basket, 1/1 GN, cross-braced base |
| GROUP/COMBI-FRY | `GROUP-COMBI-FRY__6019.1150-combifry-1-1gn-in-oven-with-fries.jpg` | **2000x2000** | 920 KB | https://www.webstaurantstore.com/rational-6019-1150-combifry-12-x-20-french-fry-tray/64560191150.html | In-use shot, CombiFry basket of chips drawn from a RATIONAL oven. RATIONAL branding on the oven, no reseller watermark |
| IMG/OVE/00026 | `IMG-OVE-00026__6035.1017-combigrill-1-1gn-trilax.jpg` | **2000x2000** | 231 KB | https://www.webstaurantstore.com/rational-6035-1017-combigrill-12-x-20-grill-tray/64560351017.html | **Exact.** Black ribbed 1/1 GN tray; the cast markings **"6035.1017"** and **"TriLax"** are legible in the corner, confirming both the article number and the TriLax claim |
| IMG/OVE/00026 | `IMG-OVE-00026__REF__combigrill-1-1gn-with-separate-loading-aid.jpg` | 1920x1280 | 147 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-combigrill-loading-aid-1-1-gn-rational-64560.jpg | **Reference.** Same tray shown with the wire **loading aid** (separate article `60.73.848`) under it - which is what the record's stored photo shows. See §9.3 finding 7 |
| GROUP/CROSS-N-STRIPE-GRILL | `GROUP-CROSS-N-STRIPE-GRILL__cross-and-stripe-grill-grate-1-1gn-both-patterns.jpg` | 1920x1280 | 200 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-cross-and-stripe-grill-grate-1-1-gn-rational-63242.jpg | **Group hero.** Two 1/1 GN grates side by side, one diamond pattern, one cross/stripe - exactly the "reversible, two patterns" claim |
| GROUP/GRANITE-ENAMELED | `GROUP-GRANITE-ENAMELED__REPRESENTATIVE-granite-enamelled-container-1-1gn-40mm.jpg` | 1920x1280 | 35 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-granite-enamelled-1-1-gn-40-mm-rational-99034.jpg | **Representative.** Grey speckled granite-enamel container with contoured corners. RATIONAL's hero is the **40 mm** variant; the group sells 20 mm and 60 mm |
| IMG/OVE/00033 | `IMG-OVE-00033__REPRESENTATIVE-6014.2106-granite-enamel-container-shared-render.jpg` | **2000x2000** | 217 KB | https://www.webstaurantstore.com/rational-6014-2106-granite-enamel-roasting-pan-25-1-2-x-21-x-2-1-2/64560142106.html | **Representative, deliberately not called exact.** Correct product family, but byte-identical to the same site's `6014.1106` (1/1 GN) image, so it cannot evidence the 2/1 GN size. Also renders near-black where RATIONAL's own granite enamel renders mid-grey. See §9.3 finding 4 |
| IMG/OVE/00036 | `IMG-OVE-00036__60.72.224-tandoori-skewer-frame-1-1gn.jpg` | **2000x2000** | 107 KB | https://www.webstaurantstore.com/rational-60-72-224-20-7-8-x-12-13-16-grill-and-tandoori-skewer-frame/6456072224.html | **Exact.** Bare stainless 1/1 GN frame with castellated skewer rails and two hanging clips. **No skewers in frame** - confirming `60.72.224` is the frame alone |
| IMG/OVE/00036 | `IMG-OVE-00036__60.72.224-tandoori-skewer-frame-rail-detail.jpg` | **2000x2000** | 199 KB | https://www.webstaurantstore.com/rational-60-72-224-20-7-8-x-12-13-16-grill-and-tandoori-skewer-frame/6456072224.html | Close crop of the castellated rail and hinge clip - lets the skewer positions be counted |
| IMG/OVE/00036 | `IMG-OVE-00036__REF__tandoori-set-frame-plus-skewers-1-1gn.jpg` | 1920x1358 | 140 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-tandoori-set-1-1-rational-117749.jpg | **Reference.** The frame **with skewers loaded** - the tandoori set, not the bare frame. Shows more than three skewers, see §9.3 finding 6 |
| GROUP/GRILLING-PIZZA-TRAY | `GROUP-GRILLING-PIZZA-TRAY__grill-and-pizza-tray-1-1gn-both-sides.jpg` | 1920x1280 | 76 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-pro-grill-and-pizza-tray-1-1-gn-rational-100914.jpg | **Group hero.** Two 1/1 GN trays, one showing the fine ribbed grill face, one the flat pizza face |
| IMG/OVE/00040 | `IMG-OVE-00040__60.71.617-grilling-roasting-platter-1-1gn-flat-side.jpg` | **2000x2000** | 181 KB | https://www.webstaurantstore.com/rational-60-71-617-12-x-20-dual-grilling-and-roasting-platter/6456071617.html | **Exact.** Single 1/1 GN platter, flat roasting face up, raised surrounding edge |
| IMG/OVE/00040 | `IMG-OVE-00040__60.71.617-grilling-roasting-plate-1-1gn-both-sides.jpg` | 1920x1280 | 160 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-grill-and-roasting-plate-1-1-gn-rational-64253.jpg | **Exact, better view.** Both faces - coarse ribbed grill side and flat roasting side with its rim |
| IMG/OVE/00041 | `IMG-OVE-00041__6010.2301-high-grade-grid-2-3gn.jpg` | 1100x1100 | 25 KB | https://cdn.ecommercedns.uk/files/4/228484/3/48260863/hc147-fray.jpg | **Exact.** Stainless wire grid in the near-square 2/3 GN proportion (325 x 354 mm), two cross-bars. Listed by the reseller under its own code `HC147` alongside `6010.2301`; no watermark. Product page: https://www.goforgreenuk.com/rational-grid-23gn-hc147 |
| IMG/OVE/00041 | `IMG-OVE-00041__6010.2301-high-grade-grid-2-3gn-alt.jpg` | 1000x1000 | 60 KB | https://kitchenrestock.com/products/rational-6010-2301-gastronorm-grid-shelf-2-3-size-12-3-4-x-13-15-16 | **Exact**, second angle, grey studio background |
| IMG/OVE/00042 | `IMG-OVE-00042__60.22.086-mobile-oven-rack-with-integrated-transport-cart.jpg` | 1000x1000 | 30 KB | https://kitchenrestock.com/products/rational-60-22-086-oven-rack-mobile-integrated-with-transport-cart | **Exact.** Stainless rack of pan runners standing on a wheeled base with a push handle - the "rack integrated with its own transport cart" the record describes. First image this SKU has ever had |
| IMG/OVE/00043 | `IMG-OVE-00043__60.61.047-mobile-plate-rack.jpg` | 1000x1000 | 58 KB | https://kitchenrestock.com/products/rational-60-61-047-mobile-plate-rack-holds-up-to-20-12-1-4-size-plates-for-scc-61-cmp-61-series | **Exact.** Wire cage with stacked circular plate cradles on a castored base. First image this SKU has ever had |
| GROUP/MULTIBAKER | `GROUP-MULTIBAKER__multibaker-1-1gn-8-moulds.jpg` | 1920x1347 | 80 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-multibaker1-1-gn-8-rational-99017.jpg | **Group hero.** 1/1 GN tray with **8** round moulds - independently confirms the "1/1 holds 8 moulds" figure |
| GROUP/PERFORATED-BAKING-TRAY | `GROUP-PERFORATED-BAKING-TRAY__6015.1103-perforated-baking-tray-1-1gn.jpg` | 1100x1100 | 110 KB | https://www.webstaurantstore.com/rational-6015-1103-12-x-20-perforated-baking-tray/64560151103.html | **Exact 1/1 GN member.** Black tray, dense fine perforation across the whole face |
| GROUP/PERFORATED-BAKING-TRAY | `GROUP-PERFORATED-BAKING-TRAY__perforated-baking-tray-bakery-standard.jpg` | 1920x1280 | 80 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-baking-tray-perforated-bakery-standard-rational-102545.jpg | **Exact Bakery-standard member** - the group's other size |
| IMG/OVE/00054 | `IMG-OVE-00054__6035.1019-potato-baker-1-1gn-28-spikes.jpg` | **2000x2000** | 213 KB | https://www.webstaurantstore.com/rational-6035-1019-12-x-20-potato-baker-with-28-spikes/64560351019.html | **Exact.** 1/1 GN wire base, spikes laid out 7 x 4 = **28**, confirming the record's spike count |
| IMG/OVE/00054 | `IMG-OVE-00054__6035.1019-potato-baker-1-1gn-alt.jpg` | 1920x1358 | 162 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-potatobaker-1-1-rational-123843.jpg | **Exact**, RATIONAL's own render, second angle |
| IMG/OVE/00055 | `IMG-OVE-00055__6035.1018-rib-grid-1-1gn.jpg` | **2000x2000** | 425 KB | https://www.webstaurantstore.com/rational-6035-1018-12-x-20-spare-rib-grill/64560351018.html | **Exact.** 1/1 GN base with dense rows of V-section wire dividers holding ribs upright |
| IMG/OVE/00055 | `IMG-OVE-00055__6035.1018-rib-grid-1-1gn-alt.jpg` | 1920x1358 | 189 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-combi-rib-grilling-grid-rational-117735.jpg | **Exact**, RATIONAL's own render |
| GROUP/ROASTING-BAKING-TRAY | `GROUP-ROASTING-BAKING-TRAY__roasting-and-baking-tray-1-1gn.jpg` | 1920x1280 | 26 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-roasting-and-baking-tray-1-1-gn-rational-99036.jpg | **Group hero.** Flat unperforated black 1/1 GN tray with the characteristic rolled front lip |
| IMG/OVE/00064 | `IMG-OVE-00064__6010.1101-ss-grid-1-1gn.jpg` | **2000x2000** | 107 KB | https://www.webstaurantstore.com/rational-6010-1101-12-x-20-stainless-steel-oven-grid-rack/64560101101.html | **Exact.** Stainless wire grid in the elongated 1/1 GN proportion (325 x 530 mm) |
| IMG/OVE/00064 | `IMG-OVE-00064__6010.1101-ss-grid-1-1gn-alt.jpg` | **2007x1548** | 35 KB | https://assets.catering-appliance.com/media/inside-sqr-2048/f2/cf/rational-60101101_img191546.jpg | **Exact**, second angle |
| IMG/OVE/00064 | `IMG-OVE-00064__REF__grid-stainless-steel-bakery-standard-not-1-1gn.jpg` | 1920x1280 | 141 KB | https://www.rational-online.com/media/images/accessories/icombi-pro-accessories-grid-stainless-steel-bakery-standard-rational-66441.jpg | **Reference, wrong size.** RATIONAL's own grid page leads with the **Bakery-standard** grid (600 x 400 mm, article `6010.0103`), not the 1/1 GN. Kept so nobody mistakes it for `6010.1101` |
| IMG/OVE/00108 | `IMG-OVE-00108__6015.1165-perforated-container-1-1gn-55mm.jpg` | **2037x1554** | 63 KB | https://assets.catering-appliance.com/media/inside-sqr-2048/e6/81/rational-60151165_img191604.jpg | **Exact.** Shallow stainless 1/1 GN container, perforated base and walls, rolled rim. Product page: https://www.catering-appliance.com/1-1-gn-perforated-stainless-steel-container-55mm-deep-6015-1165 |
| IMG/OVE/00108 | `IMG-OVE-00108__6015.1165-perforated-container-1-1gn-55mm-alt.jpg` | 1000x1000 | 72 KB | https://kitchenrestock.com/products/rational-6015-1165-gastronorm-perforated-steam-pan-1-1-size-12-3-4-x-20-7-8 | **Exact**, second angle |
| - | `_brand-reference/Rational-Accessories-Catalogue-USA-2017.pdf` | 19 pp | 1793 KB | https://res.katom.com/products/703/703-6031018/703-6031018_catalog.pdf | RATIONAL USA "RATIONAL accessories. Discover new possibilities." (doc code 10.881 - V-02 - 03/17). Multi-model, so exempt from the SKU-first rule. Its GN tables (p.19) and care-products page (p.30-31) are the source of most confirmations in §9.2. All embedded images are under 500 px, so it is a data source, not an image source |
| - | `_brand-reference/rational-6010.2101-grid-2-1gn-range-sibling.jpg` | **2000x2000** | 284 KB | https://www.webstaurantstore.com/rational-6010-2101-rack-grid-20-3-4-x-25-1-2/64560102101.html | 2/1 GN grid - the third member of the grid family, kept so the 2/3 vs 1/1 vs 2/1 proportions are comparable at a glance |
| - | `_brand-reference/rational-6014.1106-granite-enamel-1-1gn-identical-render-to-6014.2106.jpg` | **2000x2000** | 217 KB | https://www.webstaurantstore.com/rational-6014-1106-granite-enamel-roasting-pan-21-x-12-x-2-1-2/64560141106.html | Kept purely as the evidence file for the duplicate-render finding in §9.3 |

Nothing was deleted. Six files carry a marker: three `REF__`, three `REPRESENTATIVE-`. **No
file needed the `-TOOSMALL` marker** - every image staged is at or above 850 px on its long
edge, and 42 of the 55 are 1920 px or larger.

### 9.2 Article numbers confirmed

Checked against RATIONAL's own accessory pages, its USA accessories catalogue and its
safety data sheets.

| SKU | Stored `model_number` | Verdict |
|---|---|---|
| IMG/HYS/00033 | `9006.0137` | **Correct.** Catalogue p.31 and the canister label both read `9006.0137` = rinse aid, 10 L |
| IMG/HYS/00034, 00035 | `56.00.562` | **Correct.** Catalogue p.31 + SDS section 1.1 + pack photo |
| IMG/HYS/00040 | `56.00.211` | **Correct.** Catalogue p.31 + SDS section 1.1 + pack photo |
| IMG/HYS/00085 | `56.01.628` | **Correct**, though obscure. Appears in no reseller catalogue anywhere; proven only by the Active Green cleaner-tab SDS section 1.1, which lists `56.01.535; 56.01.628; 56.01.527` |
| IMG/HYS/00096 | `56.01.535` | **Correct.** RATIONAL's Active Green page + SDS |
| IMG/HYS/00264 | `56.01.912` | **Correct.** RATIONAL AutoDose cleaner-cartridge page |
| IMG/HYS/00265 | `56.01.914` | **Correct.** RATIONAL AutoDose care-cartridge page |
| IMG/OVE/00023 | `6035.1015` | **Correct** - chicken/duck Superspike, 4 birds, 1/2 GN |
| IMG/OVE/00026 | `6035.1017` | **Correct** - cast into the tray itself in the sourced photo |
| IMG/OVE/00033 | `6014.2106` | **Correct** - listed on RATIONAL's granite-enamelled page |
| IMG/OVE/00036 | `60.72.224` | **Correct** - grill and tandoori skewer **frame** |
| IMG/OVE/00040 | `60.71.617` | **Correct** |
| IMG/OVE/00041 | `6010.2301` | **Correct** - catalogue p.19, grid 2/3 GN |
| IMG/OVE/00042 | `60.22.086` | **Correct but legacy.** Absent from RATIONAL's current transport-trolley page (which lists `60.73.309`, `60.73.999`, `60.74.000`, `60.75.387/388`, `60.75.605/606`); still catalogued by parts distributors as the SCC/CMP-generation mobile oven rack with cart |
| IMG/OVE/00043 | `60.61.047` | **Correct but legacy.** Same situation - absent from RATIONAL's current mobile-plate-rack page, live at parts distributors as the SCC 61 / CMP 61 rack |
| IMG/OVE/00054 | `6035.1019` | **Correct** |
| IMG/OVE/00055 | `6035.1018` | **Correct** |
| IMG/OVE/00064 | `6010.1101` | **Correct** - catalogue p.19, grid 1/1 GN |
| IMG/OVE/00108 | `6015.1165` | **Correct.** Catalogue p.19 places `6015.1165` at 1/1 GN, 2 1/8 in deep = 55 mm, matching the record exactly |

One code failed: see finding 5 below.

### 9.3 Contradictions found - reported, not fixed

Nothing below has been changed. All of it needs a decision.

1. **IMG/HYS/00034 - the stored photo is not a RATIONAL product at all.**
   `storage/app/public/products/rational-care-tablets-5600562-imghys00034.jpg` (1512x1512)
   shows a white bucket whose label reads **"Professional"**, **"9 kg / 100 x"**,
   **"Detergent tablets for ovens, hobs, pots, pans and dishwashers"**, order no. **674391**,
   EAN **5706353674391**, and at the foot **"ABENA - Egelund 35, DK-6200 Aabenraa -
   www.abena.com"**. ABENA is a Danish hygiene-supplies distributor. This is a
   **third-party own-brand product carrying another company's branding on a published
   RATIONAL product page**, and it also contradicts the record's own "150 per bucket" - the
   pack shown is 100. The genuine RATIONAL `56.00.562` pack is the "Tab 100 + 50" bucket
   now staged. **Highest-priority image replacement in this pass.**

2. **IMG/OVE/00108 - the stored photo is a whole combi oven, not the accessory.**
   `perforated-container-11-gn-55mm-imgove00108.jpg` shows a complete **RATIONAL iCombi Pro
   unit with the door open and pans loaded**, not a 1/1 GN perforated container. Wrong
   product class entirely, on a published SKU. Two exact replacements are staged.

3. **IMG/OVE/00023 - the stored photo is the wrong variant.**
   `chicken-super-spike-4-bird-gn-imgove00023.jpg` shows an **elongated 1/1 GN base with 8
   cradles**. The record is the **4-bird, 1/2 GN** unit (`6035.1015`), whose base is nearly
   square. The staged kitchenrestock file shows the correct 4-cradle unit.

4. **WebstaurantStore reuses one render across different sizes - verify before trusting it.**
   Two byte-identical pairs turned up in this pass:
   - `6035.1015` (4-bird, 1/2 GN) and `6035.1006` (8-bird, 1/1 GN) both serve
     MD5 `657981a850ef61b891de274a32403ad4`. The shared image is the 8-bird unit, so their
     `6035.1015` listing is illustrated with the wrong product - the same error as finding 3.
   - `6014.1106` (granite enamel 1/1 GN) and `6014.2106` (granite enamel 2/1 GN) both serve
     MD5 `7b8fe0b25340deb2b92ebac9e651a340`.
   Both pairs are kept as evidence. **Consequence for future passes: a WebstaurantStore
   image proves the product family, not the size, unless the article number is legible
   in-frame** (as it happily is on `6035.1017`).

5. **IMG/HYS/00039 - the stored `model_number` is truncated.** The record carries
   **`6006.011`**. RATIONAL's catalogue (p.31), its descaler page, and the label
   photographed on the canister itself all read **`6006.0110`**. Every other RATIONAL code
   in this family is 4+4 digits; `6006.011` is 4+3 and resolves nowhere. Recommend
   `6006.0110`. The product is otherwise right - the stored photo of the white 10 L
   "Entkalker / Decalcifyer" jerrycan matches RATIONAL's own image.

6. **IMG/OVE/00036 - "three skewers" looks wrong.** The record's `short_description` says
   the frame holds "three skewers up to 20 3/4 in long". The record's **own stored photo
   shows four skewers fitted**, RATIONAL's tandoori-set render shows four to five, and the
   castellated rails on the bare-frame photo carry far more than three positions.
   Separately, `60.72.224` is sold as the **frame only** - the skewers are separate articles
   (`60.72.414`, `60.72.416`-`60.72.420`, `60.75.782`-`60.75.785` all appear on the same
   RATIONAL page). Both the count and the "holding three skewers" framing need a supplier
   check before the copy is trusted.

7. **IMG/OVE/00026 - the stored photo bundles a separate article.** The stored image shows
   the CombiGrill tray **with the wire loading aid underneath**. The loading aid is
   `60.73.848`, a separate purchase; `6035.1017` is the tray alone. The staged
   WebstaurantStore photo shows the tray on its own with `6035.1017` cast into it. Low
   commercial risk, but as it stands the photo over-states what the customer receives.

8. **IMG/HYS/00033 - stored photo has a foreign badge burned into it.** The stored
   `rational-care-rinse-detergent-imghys00033.jpg` is the correct blue `9006.0137` canister,
   but an **orange "A1" sticker graphic** has been composited onto the top-left of the
   container - somebody else's catalogue index marker, not part of the product. The staged
   2000x2000 replacement is clean.

9. **IMG/HYS/00033 - the product name drifts from the manufacturer's.** Ours is "Rational
   Care Rinse Detergent". RATIONAL calls `9006.0137` **"Rinse aid" / "Klarspuler"**, and the
   catalogue groups it with the liquid cleaner, not with the Care range. Not wrong enough to
   be a defect, but "Care" implies the CareControl descaling line, which this is not.

10. **IMG/HYS/00038 - `56.00.210` is end-of-life.** The article is genuine (catalogue p.30
    lists `56.00.210A` for the 100x bucket) but RATIONAL's current cleaning-tab page has
    replaced it with the phosphate-free **`56.02.315`**. Same finding already recorded in §7
    against IMG/HYS/00207; it applies to this SKU too. Worth confirming with the supplier
    which pack is actually being delivered.

11. **Minor, RATIONAL's own inconsistency, no action for us.** Article `56.01.527` is listed
    in **both** the Care-tab SDS (section 1.1: `56.00.562; 56.01.527; 56.01.529`) and the
    Active Green cleaner-tab SDS (section 1.1: `56.01.535; 56.01.628; 56.01.527`). One of
    the two is a typo at RATIONAL. Recorded only so a future pass does not read it as our
    error.

Everything else checked out. The stored photos for IMG/HYS/00035, IMG/HYS/00038,
IMG/HYS/00039, IMG/HYS/00040, IMG/HYS/00085, IMG/OVE/00033, IMG/OVE/00040, IMG/OVE/00041,
IMG/OVE/00054, IMG/OVE/00055, IMG/OVE/00064 and all eight `GROUP/*` parents show the right
product.

### 9.4 Coverage - stated plainly

30 SKUs in scope: 22 individual SKUs + 8 group parents.

**Exact-model image sourced - 27** (20 individual + 7 group parents)

IMG/HYS/00033, IMG/HYS/00034, IMG/HYS/00035, IMG/HYS/00038, IMG/HYS/00039, IMG/HYS/00040,
IMG/HYS/00096, IMG/HYS/00264, IMG/HYS/00265, IMG/OVE/00023, IMG/OVE/00026, IMG/OVE/00036,
IMG/OVE/00040, IMG/OVE/00041, IMG/OVE/00042, IMG/OVE/00043, IMG/OVE/00054, IMG/OVE/00055,
IMG/OVE/00064, IMG/OVE/00108, GROUP/CHICKEN-SUPER-SPIKE, GROUP/COMBI-FRY,
GROUP/CROSS-N-STRIPE-GRILL, GROUP/GRILLING-PIZZA-TRAY, GROUP/MULTIBAKER,
GROUP/PERFORATED-BAKING-TRAY, GROUP/ROASTING-BAKING-TRAY.

For a group parent, "exact" means a clean studio shot of a real member of that group, which
is what the `GROUP/*` pattern calls for.

**Representative / `REF__` only - 3**

- **IMG/HYS/00085** (`56.01.628`) - the Active Green cleaner tab is photographed everywhere
  as pack `56.01.535`. No image of `56.01.628` exists anywhere that could be found; it is a
  pack variant proven only by the SDS. Marked `REPRESENTATIVE-`.
- **IMG/OVE/00033** (`6014.2106`, granite enamelled 2/1 GN 60 mm) - the only image found
  under that article number is byte-identical to the 1/1 GN render, so it evidences the
  family and not the size. Marked `REPRESENTATIVE-` rather than passed off as exact.
- **GROUP/GRANITE-ENAMELED** - RATIONAL's hero for the granite-enamelled range is the
  **40 mm** container; the group sells 20 mm and 60 mm. Right product, wrong depth. Marked
  `REPRESENTATIVE-`.

**Nothing sourced - 0.** Every one of the 30 SKUs has at least one staged file.

**Deliberate abstention, stated explicitly.** The three above could each have been handed a
confident-looking "exact" label and were not. The `6014.2106` case is the instructive one:
there **is** a 2000x2000 image sitting on a reseller page under exactly that article number,
and it would have passed unexamined. Only the hash match against the same reseller's 1/1 GN
image shows it cannot carry the size claim. The marker stays until a size-specific photo
turns up.

### 9.5 Open questions for the supplier

- **IMG/OVE/00036** - how many skewers ship with the frame, if any? RATIONAL sells
  `60.72.224` as the frame alone. Our copy says three; our own stored photo shows four.
- **IMG/HYS/00038** - is the delivered pack the legacy round `56.00.210` bucket or the
  current rectangular phosphate-free `56.02.315`? Affects both the photo and the copy.
- **IMG/HYS/00085 vs IMG/HYS/00096** - `56.01.628` and `56.01.535` are the same Active Green
  cleaner tab in different packs. Which is actually stocked? One record is published and the
  other archived, with no stated difference between them.
- **IMG/OVE/00042 and IMG/OVE/00043** - both are SCC/CMP-generation articles RATIONAL no
  longer lists. Confirm they are still orderable before either draft is published.

### 9.6 Disk re-verification (added during reconstruction)

Every row of §9.1 was re-measured from the bytes on disk. **All 59 rows matched - no
dimension, file size or page count in the table needed correcting.** Three additional facts
came out of the re-measurement that the original draft did not record:

1. **Both duplicate-render pairs in §9.3 finding 4 are confirmed byte-identical**, not merely
   similar. `IMG-OVE-00023__REF__6035.1006-8-bird-1-1gn-mislabelled-as-6035.1015.jpg` hashes
   to `657981a850...`, and
   `IMG-OVE-00033__REPRESENTATIVE-6014.2106-granite-enamel-container-shared-render.jpg` and
   `_brand-reference/rational-6014.1106-granite-enamel-1-1gn-identical-render-to-6014.2106.jpg`
   both hash to `7b8fe0b253...`. The evidence for that finding stands.

2. **`IMG-HYS-00038__REF__56.02.315-cleaner-tab-p-free-successor-bucket.jpg` is byte-identical
   to the §7 file `IMG-HYS-00207__REF__RATIONAL-cleaner-tab-P-free-56-02-315-tub-official.jpg`**
   (both `f37a2218d4...`, 1280x854, 68 KB). Two passes independently landed on the same
   RATIONAL asset for `56.02.315` from different starting SKUs - which is corroboration that
   `56.00.210` and the never-resolvable `56.00.22` both point at the same successor article.

3. **Five of the 30 SKUs in scope have no stored image in `products.json` at all** - not a
   wrong image, no image: **IMG/HYS/00096, IMG/HYS/00264, IMG/HYS/00265, IMG/OVE/00042,
   IMG/OVE/00043**. All five now have an exact-model file staged, so this pass takes RATIONAL
   from 25/30 to 30/30 on image coverage. The draft noted this in passing for 00042 and 00043
   ("first image this SKU has ever had"); it is true of the other three as well.

For reference, the 25 stored images this pass is measured against: **14 are 1512x1512**
(IMG/HYS/00034, IMG/HYS/00085, IMG/OVE/00026, 00033, 00036, 00040, 00064, and seven of the
eight `GROUP/*` parents); **2 are 800x533** (IMG/HYS/00039, IMG/HYS/00040); **9 are 600x600**
(IMG/HYS/00033, 00035, 00038, IMG/OVE/00023, 00041, 00054, 00055, 00108, and
GROUP/ROASTING-BAKING-TRAY - the one group parent that is not 1512x1512). Every staged
replacement is larger than the record it would replace.

Three original-draft miscounts were corrected during this re-verification, all of them in
the file-inventory prose and none of them affecting a per-file row or a finding: the split
of the 59 files is 55 images + 4 PDFs (not 56 + 3); 42 of the 55 images are 1920 px or
larger (not 24); and GROUP/ROASTING-BAKING-TRAY's stored image is 600x600, so it is not one
of the 1512x1512 group parents.
