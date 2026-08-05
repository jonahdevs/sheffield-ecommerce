# Sunnylux + Tecnoroast + Tungsten Product Research

Research notes behind a SUNNYLUX / TECNOROAST / TUNGSTEN enrichment/audit pass on
`products.json` (July 2026). Covers all 4 SKUs across these three small brands: one
Tungsten pastry display, one Sunnylux food waste disposer, and two Tecnoroast charcoal
skewer grills.

**No `products.json` or `brands.json` changes have been applied** — this file is
findings only, same starting point as the Brema/Blueline/Santos passes before a scope
decision. **No images were copied into the project** — candidates are staged in
`Downloads/sunnylux-tecnoroast-tungsten-images/` for manual review.

---

## TUNGSTEN — IMG/DIS/00059 (Pastry Display Table Top 160L XCW-160L)

### 1. Private-label investigation — same red flag as Blueline, weaker evidence trail

`brands.json`'s `tungsten` entry:

```
website_url: https://sheffieldafrica.com/brands/tungsten
description: "Tungsten offers premium food processing equipment: commercial blenders,
  potato peelers, meat slicers, and hot dog stuffers. Our stainless steel machines
  deliver reliable performance for commercial kitchens, restaurants, and food
  manufacturers."
```

That URL resolves (no 404), but unlike Blueline's `/brands/blueline` page — which at
least described Sheffield's own manufacturing capability in prose — **this page contains
no mention of "Tungsten" anywhere at all**. It's generic Sheffield boilerplate with the
brand slug in the URL and nothing else tying it to the name. This is a *weaker* signal
than Blueline's, not a stronger one — there's no live page to confirm the private-label
read against, only the absence of any independent manufacturer.

**Second, and more telling, red flag: the brand description doesn't match the product.**
`brands.json` describes Tungsten as a **food processing** equipment brand — blenders,
potato peelers, meat slicers, hot dog stuffers. The only product actually carrying the
`TUNGSTEN` brand string in the whole catalogue (`IMG/DIS/00059`) is a **refrigerated
pastry display case** — a completely different equipment category (cold-chain retail
display, not food prep/processing). This reads like boilerplate copy-pasted from a
different brand's description template and never customized for what Sheffield actually
stocks under this name — the same "one import, one source document, wrong label"
pattern the Blueline pass found with duplicated feature-list text (§1.2 of that file).

Confirmed via a full-catalogue search: **`IMG/DIS/00059` is the only product in
`products.json` that mentions "Tungsten" anywhere** (brand field or free text). No
blenders/peelers/slicers/stuffers under this or any other brand string carry Tungsten
branding, so there's no orphaned sibling data to cross-check the description against —
it appears to be simply wrong for this catalogue as it stands today.

**No independent commercial-refrigeration or food-equipment manufacturer called
"Tungsten" exists.** Web searches return only unrelated hits: tungsten-*carbide/steel*
tooling suppliers, an unrelated Jumia/Whizz product listing for "Tungsten Desire" (a
different consumer-goods brand entirely), and generic metal-trading directories — nothing
resembling a kitchen-equipment OEM.
https://shopit.co.ke/tungsten/
https://www.jumia.co.ke/slp/tungsten-steel
https://www.whizz.co.ke/brand/tungsten-desire/

**Sheffield's own live site does not currently show a Tungsten-branded product at all.**
The live Pastry Displays category lists 18 products across three brand chips —
`SV-BLUELINE`, `HK-REDLINE`, `TECNODOM` — with no Tungsten entry:
https://sheffieldafrica.com/commercial-kitchen/35/pastry-displays

**Conclusion: treat Tungsten the same way as Blueline — a Sheffield-side label with no
independent manufacturer behind it — but do not go hunting for a "Tungsten" factory.**
Trace the model code instead (§2).

### 2. Tracing the OEM via the model code — XCW-160L is a shared Chinese refrigeration-display code

`XCW-` is exactly the kind of generic Chinese refrigerated-display code prefix the brief
flagged. Searching `XCW-160L` directly (not "Tungsten") surfaces the same unit sold under
at least four different brand names by four different resellers:

| Reseller / brand | Model string used | Country |
|---|---|---|
| VEVOR | `XCW-160LS` | US (re-importer) |
| Omaj (via ekuep.com, mkayn.com) | `XCW-160L` | Turkey |
| Jiagle | `XCW-100L` (sibling size) | — |
| **Sankool** (factory's own site/blog) | `XCW-160L` | **China (factory)** |

The chain terminates at **Ningbo XiangChi Electrical Co., Ltd.**, trading as **Sankool**,
based in the East Zone, Guanhaiwei Industrial Park, Cixi City, Ningbo, Zhejiang, China —
a 40,000 m² commercial-refrigeration factory. Two independent Sankool-hosted blog
articles (different URLs, written at different times, consistent figures) describe the
XCW-160L directly:
https://blog.sankool.com/li-mei-commercial-refrigeration-sales-specialist/the-xcw160l-countertop-display-cooler-redefining-compact-commercial-refrigeration-excellence.html
https://blog.sankool.com/li-mei-commercial-refrigeration-sales-specialist/revolutionizing-countertop-display-solutions-the-xcw160l-cooler-s-edge-in-commercial-refrigeration-257.html
Company site: https://www.sankool.com/
Sankool's own product page also lists XCW-160L among a sibling family (100L/120L/120F/120LS/120Z/160L/160LS/160Z):
https://www.sankool.com/product/countertop-display-cooler/commercial-countertop-refrigerator-bakery-dairy-display-cooler-case.html

This is the same shape of finding as Blueline's Firscool trace (§2 of the Blueline pass):
**Chinese OEM factory → multiple national relabellers (Omaj/Turkey, Vevor/US, Sheffield's
"Tungsten"/Kenya) → no single owner of the code**, so the "official" spec is the factory's
own, but confidence on which exact sub-variant (LS glass style, refrigerant charge, etc.)
Sheffield's actual unit matches is inherently capped.

### 3. IMG/DIS/00059 (XCW-160L) findings

**Current record has almost no content to audit against** — only a `short_description`
exists; `description`, `technical_specification`, and all dimension/weight/power fields
are empty or `null`. This is a from-scratch build situation, same as Brema's CB1565A/
CB249A records.

Recovered spec (Sankool, two agreeing sources):

- External dimensions: **888 (W) × 568 (D) × 686 (H) mm**
- Package dimensions: 951 × 627 × 735 mm
- Net weight **66 kg** / gross weight **70 kg**
- Capacity: **160 L**
- Temperature range: **2–10 °C**
- Input power: **240 W**
- Refrigerant: **R134a/R600a**
- Climate class **4** (rated to 43 °C ambient)
- Front curved tempered glass (5× impact strength of standard glass per source),
  rear sliding tempered-glass doors, adjustable chromed shelves, integrated LED top
  light (5 W, 50,000 h rated life), auto-defrost with self-evaporating water tank,
  built-in thermometer, rated noise 42 dB

**Kenya electrical note:** the sources give wattage (240 W) but not voltage explicitly.
Countertop display units in this class are universally single-phase 220–240 V/50–60 Hz —
consistent with, but not independently confirmed at, Kenya's 240 V/50 Hz mains. No
three-phase concern for a unit this size. Flag voltage as inferred, not sourced verbatim.

**Confidence: Medium** — dimensions/capacity/refrigerant/materials are corroborated by
two independent pages on the OEM's own domain, but the record is being built from
nothing, and the code is confirmed shared across multiple rebranders (§2), so it isn't
possible to be certain Sheffield's specific unit is identical to Sankool's rather than a
near-identical sibling sold under a different reseller's badge (e.g. Omaj's).

---

## SUNNYLUX — IMG/HYS/00274 (Food Sink Shredder Disposer ED1100)

### 1. Brand identification — genuine Chinese manufacturer, confirmed

Unlike Tungsten, **Sunnylux is a real company**, not a Sheffield private label:

- **Sunnylux Electric Co., Ltd.** / **Ningbo Sunnylux Import & Export Co., Ltd.**,
  Tianlong Technology Park, Kangqiao South Road, Jiangbei District, Ningbo, Zhejiang,
  China. Made-in-China "Diamond Member" since 2013, audited supplier with verified
  business licenses.
  https://www.sunnyluxcn.com/en/index.php
  https://www.sunnyluxcn.com/en/products.php
  https://sunnylux.en.made-in-china.com/
- It's a diversified manufacturer (LED lighting, excavator rubber tracks, DC geared
  motors, safety equipment, kitchen appliances) rather than a disposer specialist, but
  food waste disposers are a genuine, substantial catalogued product line for them — a
  made-in-china product-group page lists **49 separate food-waste-disposer listings**
  under this supplier:
  https://sunnylux.en.made-in-china.com/product-group/bqVmatxKVprk/FOOD-WASTE-DISPOSER-catalog-1.html
- `brands.json`'s `sunnylux` entry currently has a bare placeholder description
  (`"SUNNYLUX"`) and `website_url: null` — both fillable with the above.

### 2. IMG/HYS/00274 (ED1100) findings

**The exact model number "ED1100" could not be verified against any Sunnylux/Sunnylux
Electric source.** It does not appear in the title text of any of the 49 listings on
their made-in-china disposer catalog page, on `sunnyluxcn.com`'s own product listing, or
in any web search combining "Sunnylux" + "ED1100" — every other hit for the bare string
`ED1100` is an unrelated product (On-Shore Technology's ED1100 wire connector,
TownSteel's ED1100 exit device, a near-surface pipeline marker, a medical device) that
happens to share the code by coincidence. This isn't necessarily suspicious on its own —
Sunnylux's B2B listing titles are generic marketing strings ("Kitchen Sink Intelligent
Food Waste Garbage Disposer 110V with UL Ce CB") that routinely omit model numbers
entirely — but it means the specific "ED1100" designation is **unconfirmed from public
sources**, possibly a Sheffield-side model tag rather than one Sunnylux publishes.

**The stored spec is plausible and internally consistent, and matches the general shape
of Sunnylux's broader disposer range**, even though it can't be pinned to one listing:

- Stored: 1.5HP/1100W permanent-magnet DC motor, 3200 r/min, Cyclone™ Ultrafine Grinding
  System, stainless-steel grinding components, permanent antibacterial protection, manual
  reset overload/thermal protector, AC220–240V 50/60Hz.
- Comparable catalogued siblings found in the same 49-listing group: an "Electrical
  Household Kitchen Sink Food Waste Disposer 1.25HP with UL CE CB RoHS" (DC motor, SUS304,
  110/220V 50/60Hz) and a "Kitchen Sink Intelligent Food Waste Garbage Disposer 110V"
  (SLED1000/SLED400 model tags, 800–1000W, DC motor, SUS304, 40–70dB, UL/CE/CB/RoHS,
  5-year warranty) — same certification set, same motor type, same voltage range, power
  figures in the same 400–1250W band as our stored 1100W.
  https://sunnylux.en.made-in-china.com/product/EvYxqihMherX/China-Electrical-Household-Kitchen-Sink-Food-Waste-Disposer-1-25HP-with-UL-Ce-CB-RoHS.html
  https://sunnylux.en.made-in-china.com/product/eKUJqchCfMrb/China-Kitchen-Sink-Intelligent-Food-Waste-Garbage-Disposer-110V-with-UL-Ce-CB.html
- No source contradicts any stored figure. Nothing here needs correcting — but nothing
  is independently confirmed for the exact ED1100 designation either.

**Kenya electrical / phase check:** AC220–240V, 50/60Hz — matches Kenya's 240V/50Hz mains
directly. **Single-phase**, consistent with every other Sunnylux disposer variant found in
the 49-listing catalog (this whole product class is single-phase; none of the comparable
units found require three-phase power). No phase concern.

**Feed type / plumbing not confirmed.** Our stored description doesn't state whether this
is a continuous-feed or batch-feed unit. The wider Sunnylux catalog includes explicit
"Continuous Feed" branded units as a distinct sub-line
(https://sunnylux.en.made-in-china.com/product/NXpQbLhjfqRM/), which means feed type is a
meaningful spec differentiator for this manufacturer's range that ED1100's feed type
cannot be assumed from — needs supplier confirmation, not web research.

**Confidence: Medium** on the manufacturer and general spec plausibility · **Low** on the
exact "ED1100" designation and feed type, since no public source independently documents
that exact model string.

### 3. Image — no replacement found meeting the resolution floor

Sheffield's own live listing photo exists
(`https://sheffieldafrica.com/storage/uploads/1759154383_WhatsApp Image 2025-09-29 at 16.17.00_a1181613.jpg`)
but is only **263 × 263 px / 7.1 KB** — a WhatsApp-compressed thumbnail, well under the
800 px floor. It was downloaded, measured, and **discarded** rather than kept in the
deliverable folder. No alternate photo bearing the exact "ED1100" designation was found
anywhere else online, and — per the brief — a differently-modeled Sunnylux disposer's
stock photo was deliberately **not** substituted in its place, since that would
misrepresent which unit is actually pictured. **No image for this SKU is included in the
download folder.**

---

## TECNOROAST — IMG/HOT/00382 (TRS-60) and IMG/HOT/00384 (TRS-20)

### 1. Brand identification — genuine Italian manufacturer, confirmed

**Tecnoroast is a real, live Italian brand**, not a private label and not Turkish/Chinese
styling as the brief speculated might be the case — it's manufactured by **TECNOSTAF
S.r.l.** (Italian VAT: PI 02276110695), and both SKUs' exact model codes are live,
current products on the manufacturer's own site:
https://www.tecnoroast.com/
https://www.tecnoroast.com/en/product/tecnoroast-60-single-trs-60/
https://www.tecnoroast.com/en/product/tecnoroast-20-single-trs-20/

`brands.json`'s `tecnoroast` entry currently has a bare placeholder description
(`"TECNOROAST"`) and `website_url: null` — both fillable from the above; this is a
straightforward case, unlike Tungsten/Blueline.

### 2. TRS-60 (IMG/HOT/00382) findings — confirmed almost exactly, one materials discrepancy

Official page confirms the stored record essentially field-for-field:

| Field | Stored | Official (tecnoroast.com) | Match |
|---|---|---|---|
| Dimensions | 1750 × 250 × 1000 mm | 175 × 25 × 100 cm | ✓ exact |
| Weight | 35 kg | 35 kg | ✓ exact |
| Power | 220V – 3.5W | 220V – 3.5W (also offered: 110V–5W, battery 3.5V–5W) | ✓ exact (alt. power options not in our record) |
| Skewer capacity | 60 | 60 | ✓ exact |
| Origin | Made in Italy | Confirmed — Tecnostaf S.r.l., Italy | ✓ |

Reseller Sborgia corroborates and adds detail: cooking channel and support legs in
**AISI 316** stainless steel, price €759.90, legs detach in ~15 seconds for transport.
https://www.sborgia.com/en/kitchen/barbecue/Tecnoroast_Charcoal_barbecue_for_arrosticini_trs_60.html

⚠ **Materials discrepancy:** our stored record says **"430 Stainless steel"**; the only
source that states a grade at all (Sborgia) says **316**. Neither is Tecnoroast's own
spec sheet (a PDF link exists on the official page but wasn't independently fetchable) —
flagging, not resolving.

No rotation-speed/RPM or charcoal-consumption figures are published anywhere found for
this model — genuinely unavailable, not omitted by oversight.

**Confidence: High** on dimensions, weight, power, skewer count, Italian origin ·
**Low** on stainless grade (one source only, conflicts with stored value).

### 3. TRS-20 (IMG/HOT/00384) findings — width discrepancy baked into the product name itself

| Field | Stored | Official (tecnoroast.com) | Match |
|---|---|---|---|
| Dimensions | **W850** × D250 × H1000 mm | **80** × 25 × 100 cm (**800mm** wide) | ⚠ **50mm off** |
| Weight | 10 kg | 10 kg | ✓ exact |
| Power | 220V – 3.5W | 220V – 3.5W (also 110V–5W, battery) | ✓ exact |
| Skewer capacity | 20 | 20 | ✓ exact |

⚠ **The stored width (850mm) doesn't match the official figure (800mm) — and this isn't
just a spec-field slip, it's baked into the catalogue product's own name**
("Charcoal Grill Automatic **850MM** 20 Skewers TRS-20"). Both Tecnoroast's own site and
independent reseller Sborgia agree on 800mm:
https://www.sborgia.com/en/kitchen/barbecue/Tecnoroast_Rotisserie_26_arrosticini_barbecue_20_tecnoroast.html
(also confirms 10kg, same 220V-3.5W spec, price €359.90 discounted from €389.90).
Flagging only — fixing this touches the product `name`, not just a numeric field, which
raises the bar beyond a normal spec correction.

⚠ **Two claims in the stored `description` are unverified and possibly already
inaccurate**: "**Evenly cooks 20 skewers rotating at 2 RPM**" and "**Powerful battery
operated mechanism**." Neither source describes an RPM figure, and both describe 220V
mains power as the *primary* spec (battery is listed only as one of three alternate power
options, not the standard configuration) — these two claims predate this research pass
and could not be corroborated against either source found.

**Confidence: High** on weight, power, skewer count · **High confidence the stored width
is wrong** (800mm confirmed by two independent sources) · **Low** on the RPM and
"battery operated" framing already present in the record.

### 4. Sibling-contamination check — TRS-60 and TRS-20 are correctly differentiated

The brief flagged this as a pattern that's recurred in nearly every batch so far
(ascending-capacity siblings sharing a pasted spec block). **That did not happen here.**
Both models' dimensions (1750mm vs 800mm), weights (35kg vs 10kg), and skewer counts
(60 vs 20) were independently confirmed against Tecnoroast's own site *and* a second
reseller (Sborgia) for *both* models, and all four figures land distinctly and
correctly on each SKU — no cross-contamination. Pricing is also sane: TRS-60 (KES
296,700) costs roughly 2.5× TRS-20 (KES 117,443.75), consistent with 3× the skewer
capacity and 3.5× the weight — no pricing anomaly like the one found in the Blueline
pass.

**Kenya electrical / phase check (both models):** 220V–3.5W is a trivially light load
(the charcoal does the cooking; electricity only drives a slow rotation motor) — fully
compatible with 240V/50Hz single-phase Kenyan mains, no three-phase concern for either
grill size.

---

## Product reference

| SKU | Catalogue name | Model | Real manufacturer / OEM | Primary source | Confidence |
|---|---|---|---|---|---|
| IMG/DIS/00059 | Pastry Display Table Top 160L XCW-160L | XCW-160L | **Private label** — no independent "Tungsten" exists; traces to Ningbo XiangChi Electrical Co. ("Sankool"), China | https://blog.sankool.com/li-mei-commercial-refrigeration-sales-specialist/revolutionizing-countertop-display-solutions-the-xcw160l-cooler-s-edge-in-commercial-refrigeration-257.html | **Medium** — built from nothing, code shared across ≥4 rebranders |
| IMG/HYS/00274 | Food Sink Shredder Disposer ED1100 | ED1100 | Sunnylux Electric Co., Ltd. / Ningbo Sunnylux Import & Export Co., Ltd., Zhejiang, China — genuine manufacturer, exact model unconfirmed | https://sunnylux.en.made-in-china.com/product-group/bqVmatxKVprk/FOOD-WASTE-DISPOSER-catalog-1.html | **Medium** manufacturer · **Low** exact model |
| IMG/HOT/00382 | Charcoal Grill Automatic 1750MM 60 Skewers TRS-60 | TRS-60 | TECNOSTAF S.r.l. ("Tecnoroast"), Italy — genuine manufacturer, exact model confirmed | https://www.tecnoroast.com/en/product/tecnoroast-60-single-trs-60/ | **High** |
| IMG/HOT/00384 | Charcoal Grill Automatic 850MM 20 Skewers TRS-20 | TRS-20 | TECNOSTAF S.r.l. ("Tecnoroast"), Italy — genuine manufacturer, exact model confirmed, **stored width wrong** | https://www.tecnoroast.com/en/product/tecnoroast-20-single-trs-20/ | **High** |

All URLs verified reachable at time of writing via WebFetch, except `cdn.ekuep.com` and
`www.ekuep.com`/`mkayn.com` (all returned HTTP 403 — Turkish reseller sites blocking the
fetch client) and `cdn.ekuep.com/.../25128.pdf` (self-signed certificate) — none of these
were load-bearing since the Sankool-hosted sources gave a fuller, cross-corroborated spec
for XCW-160L anyway.

---

## Image sourcing (July 2026) — downloaded to `Downloads/sunnylux-tecnoroast-tungsten-images/`

**13 files kept**, all opened and visually verified against their product description.
No thumbnails under 800px on the long edge were kept (one candidate — Sheffield's own
ED1100 photo — was downloaded, measured at 263×263px, and discarded; see §Sunnylux
above). No synthetic upscales encountered; all files are natively-sized studio renders or
manufacturer dimension drawings.

| SKU | File | Resolution | Size | Source |
|---|---|---|---|---|
| IMG/DIS/00059 | `IMG-DIS-00059__sankool-xcw-160l.jpg` | 800×1000 | 177.4 KB | https://www.sankool.com/sankool/2021/06/29/xcw-160l.jpg |
| IMG/HOT/00382 | `IMG-HOT-00382__1-3.jpg` (dimension drawing, confirms 175/12.5/150/100cm) | 1024×578 | 118.2 KB | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2016/03/1-3.jpg |
| IMG/HOT/00382 | `IMG-HOT-00382__2-2.jpg` | 1024×578 | 139.3 KB | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2016/03/2-2.jpg |
| IMG/HOT/00382 | `IMG-HOT-00382__2-3.jpg` (close-up of grill/skewers) | 1024×578 | 270.3 KB | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2016/03/2-3.jpg |
| IMG/HOT/00382 | `IMG-HOT-00382__TRS-60.1.jpg` (full unit, angled) | 1024×693 | 76.6 KB | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2016/03/TRS-60.1.jpg |
| IMG/HOT/00382 | `IMG-HOT-00382__TRS-60.2.jpg` | 1024×483 | 137.3 KB | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2016/03/TRS-60.2.jpg |
| IMG/HOT/00382 | `IMG-HOT-00382__TRS-60.3.jpg` | 617×1024 | 79.6 KB | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2016/03/TRS-60.3.jpg |
| IMG/HOT/00384 | `IMG-HOT-00384__1-7.jpg` (dimension drawing, confirms 80/12.5/50/100cm) | 1024×726 | 247.8 KB | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2019/11/1-7.jpg |
| IMG/HOT/00384 | `IMG-HOT-00384__2-7.jpg` (close-up grill/skewers) | 1024×578 | 219.5 KB | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2019/11/2-7.jpg |
| IMG/HOT/00384 | `IMG-HOT-00384__3-2.jpg` | 1006×768 | 274.6 KB | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2019/11/3-2.jpg |
| IMG/HOT/00384 | `IMG-HOT-00384__TRS-20.1.jpg` (full unit, angled — high-res) | 2345×2992 | 672.1 KB | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2016/03/TRS-20.1.jpg |
| IMG/HOT/00384 | `IMG-HOT-00384__TRS-20.2.jpg` | 2177×1541 | 678.4 KB | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2016/03/TRS-20.2.jpg |
| IMG/HOT/00384 | `IMG-HOT-00384__TRS-20.3.jpg` | 1685×3052 | 575.8 KB | https://www.tecnoroast.com/en/wp-content/uploads/sites/3/2016/03/TRS-20.3.jpg |

Notes for whoever adopts these:

- **Tecnoroast images are the manufacturer's own official product photography** (not a
  reseller carousel) — highest-confidence source available for either grill, and the
  TRS-20 set in particular is unusually high resolution (up to 2992px on the long edge).
  Both models' dimension-drawing images (`1-3.jpg` for TRS-60, `1-7.jpg` for TRS-20) were
  opened and independently re-confirm the "175/100cm" vs "80/100cm" dimensions used in
  §2/§3 above, including the discrepancy on TRS-20's width.
- **XCW-160L's single kept image is from Sankool** (the OEM factory's own blog CDN), not
  from a Kenyan or Turkish reseller — visually a clean studio render of a curved-glass
  countertop pastry/cake display matching the stored short_description. It sits exactly
  at the 800px floor on the short edge (800×1000) — kept, but there is no larger source
  found; the Omaj/ekuep/mkayn reseller pages that might have carried alternate angles all
  returned HTTP 403 to the fetch client.
- **No image is included for Sunnylux ED1100** — see §Sunnylux/3 above. Whoever needs a
  photo for this SKU should request one from the supplier directly; do not substitute a
  different Sunnylux disposer model's stock photo without disclosing the substitution.
- None of these images carry storefront-ready backgrounds/retouching guarantees beyond
  what's visible — Tecnoroast's are clean white-background studio shots; the Sankool one
  likewise. No competitor-branding overlay issues were spotted on any kept file (unlike
  the Forcold/Forcar branding problem noted in the Blueline pass).

---

## Recommended changes (per brand, findings only — nothing applied)

### Tungsten
1. **`brands.json` description is actively misleading** — it describes food *processing*
   equipment (blenders, peelers, slicers, stuffers) while the only catalogued Tungsten
   product is a refrigerated *display* case. Recommend rewriting to match what's actually
   stocked, or removing the category-specific claims entirely if Tungsten is meant to
   cover multiple equipment types in future.
2. **`website_url`** (`https://sheffieldafrica.com/brands/tungsten`) resolves but has zero
   content about Tungsten — worse than a 404 in terms of information value. Either correct
   it to a real page, or — following the Blueline precedent — reword `brands.json` to
   plainly frame Tungsten as a Sheffield house label rather than implying an independent
   manufacturer.
3. If an OEM attribution is wanted instead of private-label framing: **Ningbo XiangChi
   Electrical Co., Ltd. ("Sankool")** is the most likely factory for this specific unit,
   but — as with Blueline's Firscool trace — the `XCW-160L` code is shared across at least
   four rebranders (Omaj/Turkey, VEVOR/US, Sankool/China direct, and Sheffield/Kenya), so
   it can't be stated with certainty which one Sheffield's actual supplier sources from.
4. The record's `description`/`technical_specification`/dimension fields are entirely
   empty and could be built out from the Sankool-sourced spec (§Tungsten/3) — a content
   decision, not applied here.

### Sunnylux
1. `brands.json`'s placeholder description (`"SUNNYLUX"`) and `null` `website_url` could
   be filled in with the real company details — Ningbo Sunnylux Import & Export Co./
   Sunnylux Electric Co., Ltd., Zhejiang, China; https://www.sunnyluxcn.com/en/index.php.
2. No spec corrections are recommended — the stored ED1100 spec is plausible, internally
   consistent, and uncontradicted by any source found, even though it can't be
   independently confirmed under that exact model string.
3. Flag for supplier follow-up rather than more web research: exact "ED1100" designation,
   feed type (continuous vs batch), dimensions, and mounting/plumbing requirements are all
   unconfirmed and unlikely to be findable online given the pattern of generic B2B listing
   titles seen across this manufacturer's 49-listing disposer catalog.
4. No usable image exists for this exact model above the 800px floor — needs the supplier,
   not the web.

### Tecnoroast
1. `brands.json`'s placeholder description (`"TECNOROAST"`) and `null` `website_url` are
   the easiest fix in this whole batch — fill with the confirmed real manufacturer,
   TECNOSTAF S.r.l., https://www.tecnoroast.com/.
2. **TRS-20's stored width (850mm) is wrong** — official and independent-reseller sources
   both agree on 800mm. This is flagged as higher-stakes than a normal field fix because
   the wrong figure is embedded in the product `name` itself ("...850MM 20 Skewers..."),
   not just a numeric spec field — correcting it means also touching the name, which
   should get explicit sign-off given [[feedback_model_number_unique_id]]-style caution
   around identity fields, even though `model_number` (`TRS-20`) itself is unaffected.
3. **TRS-60's stainless grade is disputed** (stored: 430, one reseller source: 316) — flag,
   don't resolve; no source found is Tecnoroast's own spec sheet.
4. **TRS-20's "2 RPM" and "battery operated" description claims are unverified** and
   possibly already-inaccurate content that predates this research pass — worth a second
   look before republishing, though not corrected here since no source confirms or denies
   the exact RPM figure.
5. No sibling-contamination fix needed — TRS-60/TRS-20 specs and images are already
   correctly differentiated; this is a rare "nothing to merge/split" result worth noting
   given how often the ascending-capacity pattern has recurred elsewhere.
