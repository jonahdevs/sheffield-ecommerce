# Hatton Product Research

Research notes behind a HATTON audit pass on `products.json` (July 2026). Covers both
HATTON SKUs, both commercial dishwashers: **HT-T2** (under-counter) and **HT-Z1**
(hood type).

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema and Santos files before a scope decision.

Both records already carry a real description, a spec list and dimensions, so this is an
**audit**, not a build-from-scratch job. The headline results: the stored dimensions are
**correct on both SKUs** (no width/height swap — see §4), but HT-Z1 carries a contradictory
"Capacity: 30L" line that is actually HT-T2's figure, both records are missing the single
most commercially useful number (racks/hour and net weight respectively), and the brand's
own `website_url` **cannot be upgraded to HTTPS** (§1).

---

## 1. Brand identification — and the `website_url` verdict

**Hatton** = **Zhejiang Hatton Cleaning Technology Co., Ltd.**, a commercial-dishwashing
manufacturer in Yunlong Town, Yinzhou District, **Ningbo, Zhejiang, China**. Its
made-in-china.com profile gives established **19 June 2019**, 72 employees,
Manufacturer/Factory + Trading Company, TÜV Rheinland audited supplier, MIC Gold Member
since 2023 — while the company's own English copy claims "nearly 20 years" in commercial
dishwashers and 18 branch offices / 75 after-sales offices in China. Read that as a
long-running domestic operation whose *export entity* was registered in 2019. Marketing
line: "Singapore technology and management, combined with China's intelligent
manufacturing".

### The "Hendt" vs "Hatton" name

`brands.json` describes the company as **"Zhejiang Hendt Cleaning Technology Co., Ltd."**
That isn't wrong so much as it's the *other* romanisation: the `hattonchina.cn` page title
is **浙江亨德清洗科技** — 亨德 (hēng dé) → "Hendt". Every English-language export channel
(the company's own English site, the MIC storefront, the machines' own badges) uses
**HATTON**. Flagged only; `brands.json` is out of scope for this pass.

### `website_url`: keep HTTP, do **not** upgrade to HTTPS

Stored value: `http://www.hattonchina.cn/`. Tested:

| URL | Result |
|---|---|
| `http://www.hattonchina.cn/` | **200** (but returned **429** on the first, default-UA request — the host rate-limits; a browser User-Agent got through) |
| `https://www.hattonchina.cn/` | **fails** — TLS handshake aborted (curl error 35, `SEC_E_ILLEGAL_MESSAGE`) |
| `https://hattonchina.cn/` | **fails** — same TLS error |
| `http://hattonchina.cn/` | 200 |

**There is no working HTTPS on this domain.** Upgrading the scheme would turn a working
link into a dead one. Leave it at `http://`.

Separately, the site itself is close to worthless as a source: a 642-byte JS-bootstrapped
shell served off Alibaba's `wanwang.xin` site-builder CDN, Chinese-only, no readable
product content, no spec sheets, no model codes.

**The useful official English site is elsewhere:**

https://www.hatton-tech.com/

That one is HTTPS-clean, English, and carries the actual product catalogue (6 categories:
undercounter / hood type / rack conveyor / flight type / box type / food waste disposer).
Worth considering as the `website_url` on a future brand pass.

---

## 2. Where to look

| Resource | URL | Value |
|---|---|---|
| Official English site | https://www.hatton-tech.com/ | Product pages with full spec tables — but **no model numbers** |
| Official CN site | http://www.hattonchina.cn/ | Nothing usable (§1) |
| Made-in-China storefront | https://hatton-dishwasher.en.made-in-china.com/ | **The only place the model codes HT-T2 / HT-Z1 appear**, plus company profile |
| Client's own legacy site | `sheffieldafrica.com/kitchen/product/1186` and `/1187` | Appears in search results — **not an independent source**, it is where our current copy came from |

### Traps

1. **The official site never states a model number.** `hatton-tech.com` product pages are
   titled with marketing strings ("Innovative Exploring Modern Technology Undercounter
   Dishwasher", "The Latest Space-Saving Effortless High-Capacity Cleaning Hood Type
   Dishwasher") and the spec tables have no model row. Model codes only exist on the MIC
   storefront. So every model-code→spec link in this pass runs through MIC.
2. **MIC's "Capacity: 30L" is a marketplace filter attribute, not the machine's tank.**
   It appears as "30L" on *both* SKUs' listings, sitting directly above a "Wash Tank
   Capacity" row that says 30L on HT-T2 and **21.5L** on HT-Z1. Our HT-Z1 record copied
   the filter value, so it now contradicts itself — see §3.2.
3. **MIC gallery photos routinely do not match the listing.** Three separate MIC listings
   carry the identical HT-Z1 *hood-type* spec block, yet most of their gallery images are
   rack-conveyor / flight-type machines. Every image in §6 was opened and visually
   classified before being labelled. Do not trust filenames or listing titles.
4. **The same machine is listed under two model codes.** The MIC listing "Versatile Hood
   Type Commercial Dishwasher for Industry and Restaurant Needs" carries a spec block
   *byte-identical* to HT-Z1's (690×780×1475 / 110 kg / 505 / 420 / 60 racks / 3 L / 21.5 L
   / 8 L) but names the model **HT-C2X1H**. Either a newer internal code for the same
   cabinet or a listing error. Our `model_number` HT-Z1 is confirmed by three other
   listings, so it stands — this is noted so nobody "corrects" it later.
5. **No electrical rating is published anywhere.** Not on the official site, not on any MIC
   listing. Every source says only *"the voltage can be based on the requirements of your
   country"*. One HT-T2 shop-floor photo has a paper note reading "380V" — suggestive of a
   3-phase variant, nowhere near enough to publish. **kW and voltage need a supplier
   datasheet.**
6. **`hatton-tech.com` pages are client-rendered.** A plain `curl` returns a shell with no
   product links or images; the page has to be fetched through a renderer. Same shape as
   the Brema lazy-load trap, different mechanism.

---

## 3. Per-SKU findings

### 3.1 HT-T2 — Under Counter Dishwasher (IMG/DWW/00151) — dimensions confirmed, two gaps, one generation split

| Field | Stored | MIC (model stated **HT-T2**) | Official `hatton-tech.com` undercounter page (no model row) |
|---|---|---|---|
| Dimensions | 600 × 600 × 800 | 600 × 600 × 800 | 600 × 600 × 800 |
| Max washing height | 320 mm | 320 mm | 320 mm |
| Booster capacity | 8 L | 8 L | 8 L |
| Water supply pressure | 0.25–0.5 MPa | 0.25–0.5 MPa | 0.25–0.5 MPa |
| Wash cycles | 60/90/120 s | 60/90/120 s | 60/90/120 s |
| **Wash tank capacity** | 30 L | **30 L** | **25 L** ⚠ |
| **Net weight** | 80 kg | **80 kg** | **65 kg** ⚠ |
| Washing capacity | *(absent)* | **50 rack/hour** | 50 rack/hour |
| Water consumption | *(absent)* | — | 3 L/rack |
| Rack size | *(absent)* | — | 500 × 500 × 100 mm |
| Wash / rinse temperature | *(absent)* | — | 50–55 °C / 80–85 °C |
| Inlet / drain pipe | *(absent)* | — | G3/4" (DN20) / 20 mm |
| Heating mode | *(absent)* | — | Electrical |
| Power / voltage | *(absent)* | not published | not published |

**Dimensions confirmed, no axis bug** (§4). Every figure the record already carries is
correct against at least one source.

**Two real gaps.** The record has **no racks/hour and no water consumption** — for a
commercial dishwasher, "50 racks/hour" is the single number a buyer compares on, and it's
missing while much less useful details (water supply pressure, booster capacity) are
present. Add **50 rack/hour** and **3 L/rack**.

**The 25 L / 65 kg vs 30 L / 80 kg split.** The two sources disagree on tank and weight only.
The likeliest explanation is two cosmetic generations of the same cabinet, both visible in
the images (§6): the official render has a **blue "HATTON" fascia with rotary knobs**, while
the MIC shop-floor photos show a **black digital touch panel** on an otherwise identical
600×600×800 box. Our stored figures match the **MIC listing that explicitly names HT-T2**,
so they should stand — but which is physically true for our stock depends on which
generation the supplier ships. Same shape as the Brema CB-1565A refrigerant-generation
question; do not overwrite on the strength of the official page alone.

**Cosmetic copy issue.** The stored spec says `Type: Single Door Disinfection Cabinet` —
that's another MIC marketplace category value, not a manufacturer descriptor, and it reads
oddly on a storefront selling a dishwasher. Same string appears on HT-Z1.

### 3.2 HT-Z1 — Hood Type Dishwasher (IMG/DWW/00149) — every stored figure confirmed, one self-contradiction, weight missing

Three independent MIC listings agree **exactly**, with no drift on any value:

| Spec | Value | Stored? |
|---|---|---|
| Appearance dimensions | 690 × 780 × 1475 mm | ✅ correct |
| Entrance width | 505 mm | ✅ correct |
| Max washing height | 420 mm | ✅ correct |
| Washing capacity | 60 rack/hour | ✅ correct |
| Water consumption | 3 L/rack | ✅ correct |
| Wash tank capacity | 21.5 L | ✅ correct |
| **Net weight** | **110 kg** | ❌ absent |
| Booster capacity | 8 L | ❌ absent |
| Wash / rinse temperature | 60–65 °C / 82–90 °C | ❌ absent |
| Wash cycle | 60/90/120 s | ❌ absent |
| Water supply pressure | 0.25–0.5 MPa | ❌ absent |
| Supply water temperature | 10–60 °C | ❌ absent |
| Washing rack size | 500 × 500 × 100 mm | ❌ absent |
| Inlet / drain pipe | G3/4" (DN20) / 32 mm | ❌ absent |
| Heating mode | Electrical | ❌ absent |
| Certifications | CE, ISO9001 | in prose only, not in the spec list |
| Power / voltage | not published anywhere | — |

**The one actual error: `Capacity: 30L`.** The stored spec list opens with "Capacity: 30L"
and then two rows later says "Water Tank Capacity: 21.5L" — the record contradicts itself.
30 L is (a) MIC's filter attribute (§2 trap 2) and (b) **HT-T2's** real tank figure, so this
reads as a straight copy-down from the sibling SKU. The `21.5L` line is the correct one.
Recommend deleting the "Capacity: 30L" line rather than reconciling it.

Everything else in the record is either right or simply absent. Net weight (110 kg) is the
most worth adding — it's a floor-load/delivery question for a 1.475 m machine.

---

## 4. The width/height axis-swap check — **negative on both SKUs**

The transposition documented in the Santos, Empero and Brema passes (stored `width` really
holding the height) **is not present here**:

| SKU | Stored L/W/H | Source figure | Verdict |
|---|---|---|---|
| IMG/DWW/00151 (HT-T2) | 600 / 600 / 800 | 600 × 600 × 800 | ✅ no swap — and L = W, so the footprint axes are unambiguous anyway |
| IMG/DWW/00149 (HT-Z1) | 690 / 780 / 1475 | 690 × 780 × 1475 | ✅ **height is in `height`** — no W↔H swap |

That's the fourth brand where the swap had to be checked per-SKU rather than assumed, and
the second where it turned out clean. Consistent with §3 of the Santos file: never apply
the rotation blind.

**One lower-confidence footprint note on HT-Z1.** The manufacturer prints "690×780×1475"
and our record maps that positionally to `length: 690, width: 780`. But this catalogue's
`length` means **depth** (per the Santos pass), and Chinese dishwasher spec sheets in this
family print **W × D × H**. On that reading the correct mapping would be
`length` (depth) **780**, `width` **690** — i.e. the two footprint axes are transposed.
Physical reasoning supports it: the 505 mm rack entrance is on the front face and a
500 × 500 rack travels front-to-back, so the deeper axis (780) should be the depth, not the
width. **Medium confidence only** — no dimensional drawing was found to settle it, and it
has no effect on shipping volume or on whether the machine fits. Worth a supplier
confirmation before touching, not worth a blind edit.

---

## 5. Cross-cutting notes

- **"Hattons" vs "Hatton".** `IMG/DWW/00151`'s `name` is "Under Counter Dishwasher
  **Hattons**" while `brand` is "Hatton" and the machine's own fascia badge (visible in
  `IMG-DWW-00151__HT-T2-official-01.jpg`) reads **HATTON**. It's a copy typo, carried over
  from the client's legacy site, which lists it the same way. A name-only fix; nothing to do
  with `model_number`.
- **Both records are full of Quill-editor junk.** Every paragraph is wrapped in
  `<h3><span style="color: rgb(136, 136, 136);">` (prose marked up as headings, hardcoded
  grey), the spec is a bare `<ul>` rather than a table, and HT-Z1's second paragraph
  contains a stray **U+FEFF BOM** character mid-string. Both need the same prose +
  `<h3>Key Features</h3>` + `<table>` restructure applied in the Skymsen/HDS/Astar passes.
- **Neither record has a `short_description` or a `meta_description`** — both fields are
  empty/absent, so these two SKUs are invisible to the short-description work tracked in
  the description-field-split effort.
- **Accessory linkage is lopsided.** HT-Z1 carries 23 linked accessories (racks, cutlery
  racks, extenders); HT-T2 carries **none**. Both machines take the same
  **500 × 500 × 100 mm** rack, so most of HT-Z1's rack accessories should apply to HT-T2 too.
- **No electrical spec on either SKU**, and none published by the manufacturer (§2 trap 5).
  This is the biggest genuine data gap in the pair and only the supplier can close it.
- **Certifications:** HT-Z1 = CE + ISO9001 (stated on all three MIC listings). HT-T2 = ISO9001
  only on its MIC listing; no CE claim found for the undercounter. Our HT-T2 description
  claims ISO9001 only, which is correct — do not "upgrade" it to CE.

---

## 6. Product reference

| SKU | Catalogue name | Model | Official page (no model row) | Model-confirming source | Confidence |
|---|---|---|---|---|---|
| IMG/DWW/00151 | Under Counter Dishwasher Hattons | HT-T2 | https://www.hatton-tech.com/Undercounter-dishwasher-pl49586257.html | https://hatton-dishwasher.en.made-in-china.com/product/rnmpoOZylbcF/China-Mini-High-Performance-Undercounter-Dishwasher-with-Quick-Wash-Cycle.html | **High** on dimensions/washing height/booster/pressure/cycles; **Medium** on 30 L tank & 80 kg (generation split, §3.1) |
| IMG/DWW/00149 | Hood Type Dishwasher | HT-Z1 | https://www.hatton-tech.com/Hood-type-dishwasher-pl40586257.html | https://hatton-dishwasher.en.made-in-china.com/product/qTXrLgNGZDcw/China-Efficient-High-Capacity-Commercial-Dishwasher-for-Restaurant-Equipment-Model-No-Ht-Z1.html | **High** — three independent listings agree exactly on every value |

Supporting HT-Z1 listings (same spec block, used for triangulation):

https://hatton-dishwasher.en.made-in-china.com/product/zdYtqvhGbVab/China-Industrial-Grade-Advanced-Reliable-and-Efficient-Commercial-Dishwasher.html

https://hatton-dishwasher.en.made-in-china.com/product/sALYojlzfckN/China-Premium-Quality-Hood-Type-Commercial-Dishwasher-for-Heavy-Duty-Use.html

Same spec block under the **HT-C2X1H** code (§2 trap 4):

https://hatton-dishwasher.en.made-in-china.com/product/gTBrnSNMgHkx/China-Versatile-Hood-Type-Commercial-Dishwasher-for-Industry-and-Restaurant-Needs.html

Company profile / registration details:

https://hatton-dishwasher.en.made-in-china.com/

Detail product page behind the official undercounter listing:

https://www.hatton-tech.com/Innovative-Exploring-Modern-Technology-Undercounter-Dishwasher-pd519330178.html

---

## 7. Image sourcing (July 2026) — staged in `Downloads/hatton-images/`

**24 files**, all re-sourced at native resolution in a second pass (below). Two sources: the
official `hatton-tech.com` galleries (served from `ijrorwxhlqnrln5p-static.micyjz.com`, clean
studio renders) and the MIC storefront (`image.made-in-china.com`, shop-floor and
installed-site photos). Pulled via `curl`/`urllib` with a browser User-Agent and a matching
`Referer`; no auth needed.

**Every file was opened and visually classified**, because §2 trap 3 turned out to be real:
more than half the "HT-Z1" gallery images are actually rack-conveyor / flight-type machines
that have nothing to do with a hood dishwasher. **The re-sourcing pass re-verified every
replacement against the file it superseded — no wrong-model image changed classification.**

### 7.1 The resolution rules that were proven here

The first pass collected whatever the product page happened to serve. That turned out to be a
downscaled rendition on every MIC file. Three rules came out of re-probing:

**MIC serves renditions by URL size-prefix, and `2f0j00…` is the original.** Proven on a single
image key by fetching the same key under three prefixes:

| URL prefix | Result for key `…FTfeGjlMCoqI` (HT-Z1 `alt-04`) |
|---|---|
| `155f0j00…` | 330 × 400, 22 KB |
| `202f0j00…` | 453 × 550, 34 KB — **this is what the first pass captured** |
| `2f0j00…` | **473 × 574, 174 KB — the original** |
| `250f0j00…` | 302 redirect loop (not a valid rendition) |

Every `mic-*` and `alt-*` file was re-pulled through the `2f0j00…` prefix. **Nine of the twelve
HT-Z1 files gained pixels**; the other three were already the original.

**The `hatton-tech.com` CDN fits-within and never upscales.** Requesting a larger size suffix
than the native image returns the native pixels unchanged — proven against `official-03`, whose
native is 662 × 684:

| URL | Returned |
|---|---|
| `…Undercounter-Dishwasher3.jpg` | 662 × 684 |
| `…Undercounter-Dishwasher3-800-800.jpg` | 662 × 684 |
| `…Undercounter-Dishwasher3-1000-1000.jpg` | 662 × 684 |
| `…Undercounter-Dishwasher3-2000-2000.jpg` | 662 × 684 |

So **no file in this set is a synthetic upscale**, and the suffix trick cannot rescue a small
native. (The `-800-800` rendition is a higher-quality re-encode of the *same* pixels, not more
of them.)

**The HT-T2 `mic-*` files were duplicates, not a second source.** The MIC HT-T2 listing gallery
and the official undercounter page gallery are **the same six images** — confirmed by identical
dimension sequences (996×1010, 1068×1010, 662×684, 1000×1000, 1706×1706, 1706×1706) and by
perceptual matching (distance 0.10–0.27 on a 0–255 scale, versus ≥20 for any genuinely
different image). The six 550 px `mic-*` webp files were therefore deleted: their full-size
twins were already in the folder as `official-01..06.jpg`.

### 7.2 IMG/DWW/00151 — HT-T2 under-counter (6 files, was 12)

| File | Final size | Bytes | Content |
|---|---|---|---|
| `IMG-DWW-00151__HT-T2-official-01.jpg` | **996 × 1010** | 91 KB | Hero shot — blue-fascia / rotary-knob generation, door open, rack of plates, "HATTON / UNDER COUNTER" badge legible. **Best storefront candidate of the whole set.** |
| `IMG-DWW-00151__HT-T2-official-02.jpg` | **1068 × 1010** | 104 KB | Same generation, drawer-style basket pulled out with cups loaded |
| `IMG-DWW-00151__HT-T2-official-03-TOOSMALL.jpg` | 662 × 684 | 44 KB | Closed three-quarter render. **Proven capped** — see 7.4 |
| `IMG-DWW-00151__HT-T2-official-04.jpg` | **1000 × 1000** | 21 KB | Render of the **black digital-touch-panel** generation, doors closed |
| `IMG-DWW-00151__HT-T2-official-05.jpg` | **1706 × 1706** | 240 KB | Shop-floor photo, black-panel generation, door open on the wash chamber; shop note reading "380V" |
| `IMG-DWW-00151__HT-T2-official-06.jpg` | **1706 × 1706** | 265 KB | Same machine, closer on the open chamber and accessory pack |

`-01`/`-02` document the blue-fascia generation and `-04`/`-05`/`-06` the black-panel one —
together they are the visual evidence for the 25 L/65 kg vs 30 L/80 kg split in §3.1.

**Deleted:** `IMG-DWW-00151__HT-T2-mic-01..06.webp` (542×550 → 550×550, 4–25 KB) — proven
pixel-identical duplicates of `official-01..06` above.

### 7.3 IMG/DWW/00149 — HT-Z1 hood type (18 files, was 12) ⚠ 9 still the wrong machine

**New in this pass:** the official `hatton-tech.com` **hood-type product page** was located and
harvested. The first pass only ever pulled the *undercounter* page, which is why it concluded
Hatton publishes no studio render for the hood machine. **That was wrong** — there is a full
gallery, and it is the best HT-Z1 imagery available anywhere:

https://www.hatton-tech.com/The-Latest-Space-Saving-Effortless-High-Capacity-Cleaning-Hood-Type-Dishwasher-pd529330178.html

| File | Final size | Bytes | Content | Usable? |
|---|---|---|---|---|
| `IMG-DWW-00149__HT-Z1-official-01.jpg` | **1680 × 2672** | 118 KB | Studio render, three-quarter, hood down, blue HATTON nameplate — **best HT-Z1 image of the whole set** | ✅ hero candidate |
| `IMG-DWW-00149__HT-Z1-official-02.jpg` | **1000 × 1001** | 28 KB | Studio render, front, blue nameplate generation | ✅ |
| `IMG-DWW-00149__HT-Z1-official-03.jpg` | **1000 × 1001** | 28 KB | Same cabinet, **black digital-panel** generation — same two-generation split as HT-T2 (§3.1) | ✅ |
| `IMG-DWW-00149__HT-Z1-official-04.jpg` | **1706 × 1279** | 433 KB | Wash chamber interior, wash/rinse arms visible | ✅ |
| `IMG-DWW-00149__HT-Z1-official-05.jpg` | **800 × 1422** | 132 KB | Installed in situ, hood down, side loading table | ✅ |
| `IMG-DWW-00149__HT-Z1-official-06.jpg` | **825 × 694** | 49 KB | Labelled component diagram — door, window, pull rod, sprayer, basket, filter, control panel (English callouts) | ✅ |
| `IMG-DWW-00149__HT-Z1-alt-04-TOOSMALL.webp` | 473 × 574 | 169 KB | Installed hood-type, embossed HATTON badge, blue nameplate, rack table alongside — the best *photograph*, now superseded as hero by `official-01` | ✅ genuine, capped |
| `IMG-DWW-00149__HT-Z1-alt-06-TOOSMALL.webp` | 336 × 450 | 90 KB | Hood-type still in blue protective film, inlet plumbing visible | ✅ genuine, capped |
| `IMG-DWW-00149__HT-Z1-mic-06-TOOSMALL.webp` | 265 × 461 | 76 KB | Hood-type in service, **hood raised**, blue rack of plates — shows the 505 mm entrance and rack clearance | ✅ genuine, capped |
| `IMG-DWW-00149__HT-Z1-alt-01-TOOSMALL.webp` | 664 × 479 | 162 KB | Flight-type conveyor install | ❌ wrong product |
| `IMG-DWW-00149__HT-Z1-alt-02.webp` | **805 × 386** | 195 KB | Flight-type conveyor, still in factory film | ❌ wrong product |
| `IMG-DWW-00149__HT-Z1-alt-03-TOOSMALL.webp` | 727 × 522 | 222 KB | Rack-conveyor, green curtain strips, rack entry table | ❌ wrong product |
| `IMG-DWW-00149__HT-Z1-alt-05-TOOSMALL.webp` | 456 × 470 | 167 KB | Long flight-type tunnel install | ❌ wrong product |
| `IMG-DWW-00149__HT-Z1-mic-01-TOOSMALL.webp` | 561 × 411 | 104 KB | Rack-conveyor entry section | ❌ wrong product |
| `IMG-DWW-00149__HT-Z1-mic-02-TOOSMALL.webp` | 634 × 420 | 121 KB | Flight-type tunnel, control panel and notice board | ❌ wrong product |
| `IMG-DWW-00149__HT-Z1-mic-03-TOOSMALL.webp` | 746 × 304 | 131 KB | Flight-type tunnel, side elevation | ❌ wrong product |
| `IMG-DWW-00149__HT-Z1-mic-04.webp` | **829 × 502** | 208 KB | Flight-type tunnel with blue racks | ❌ wrong product |
| `IMG-DWW-00149__HT-Z1-mic-05-TOOSMALL.webp` | 688 × 495 | 241 KB | Flight-type tunnel in factory film | ❌ wrong product |

**The wrong-model count is unchanged: still 9.** Every one of them was re-opened after the
re-pull and is the same machine it was before — a bigger original, never a different image.
They are kept so the mismatch stays documented, and they **must not be attached to
`IMG/DWW/00149`**.

Counting only genuine hood-type material, `IMG/DWW/00149` now has **9 usable images**
(6 official + 3 photographs), up from 3, and six of them clear 800 px.

### 7.4 Files proven capped below 800 px (`-TOOSMALL`)

Eleven files carry the `-TOOSMALL` suffix. Each was probed as follows before being accepted as
capped, and none has a larger original anywhere reachable:

1. **MIC size-prefix rewrite** — re-fetched under `2f0j00…` (the original-serving prefix);
   `155f0j00…` / `202f0j00…` / `250f0j00…` all confirmed as smaller renditions or invalid.
2. **Suffix stripping on the official CDN** — `-40-40`, `-100-100`, `-300-300`, `-460-460`,
   `-640-640`, `-800-800` removed; and larger suffixes (`-1000-1000`, `-2000-2000`) requested to
   confirm the CDN never upscales.
3. **Whole-site sweep as an alternate-host check** — all **30** `hatton-tech.com` product pages
   were fetched and all **447** distinct full-size CDN images harvested, then perceptually
   matched against every capped file. No capped image appears anywhere on the official site at a
   larger size (nearest non-identical match scored ≥20 on a 0–255 distance, i.e. a different
   photograph).
4. **Alternate MIC listings** — all five HT-Z1/HT-T2-bearing listings in §6 were harvested at
   `2f0j00…` and cross-matched; the same photo never appears larger on a sibling listing.
5. **`hattonchina.cn` was not usable** — no working HTTPS (§1) and no product imagery on the
   Chinese shell site. No WordPress REST API exists on either host; both are Made-in-China
   site-builder properties (`micyjz.com`), not WordPress, so there is no `full`-size media
   endpoint to interrogate.

The ceiling is a genuine one: these are small source photographs, not throttled deliveries.

### 7.5 A dimensional drawing worth knowing about (not downloaded)

The official hood-type page also carries a dimensioned general-arrangement drawing showing
**1475 mm** height (1900 mm with the hood raised), **690 mm** across the front and **780 mm**
deep. That is independent support for the lower-confidence footprint note in §4 — that
`length` (depth) should be **780** and `width` **690**, i.e. the two footprint axes in the
record are transposed. It was **not** staged as a file because at 581 × 539 it is well below the
resolution bar; it is recorded here as a source for whoever settles §4:

https://ijrorwxhlqnrln5p-static.micyjz.com/cloud/lqBpqKjrlmSRlkijpilijo/The-Latest-Space-Saving-Effortless-High-Capacity-Cleaning-Hood-Type-Dishwasher5.jpg

### 7.6 Why this matters for the existing images

Both SKUs already have images in `storage/app/public/products/`, but they are tiny:
`hood-type-dishwasher-imgdww00149.png` is **13 KB** and
`under-counter-dishwasher-hattons-imgdww00151.png` is **24 KB**. Both are now comfortably
beaten: 00151 by the 996 × 1010 and 1706 × 1706 official renders, and 00149 — which the first
pass could only offer a 453 × 550 photograph for — by a **1680 × 2672** studio render.

**Not copied into `storage/app/public/products/` and not referenced in `products.json`** —
staged in Downloads for review, same as the Brema and Santos sets.

---

## 8. Recommended actions (nothing applied)

Ordered by value, all deliberately left unapplied:

1. **HT-Z1: delete the `Capacity: 30L` line** — it contradicts the record's own 21.5 L tank
   figure and is HT-T2's number (§3.2). The only outright *error* found in this pass.
2. **HT-T2: add washing capacity 50 rack/hour and water consumption 3 L/rack** — the missing
   headline commercial figures (§3.1).
3. **HT-Z1: add net weight 110 kg**, plus booster 8 L, wash/rinse temperatures, wash cycles,
   supply pressure and rack size (§3.2).
4. **Restructure both** to the prose + Key Features + `<table>` pattern; strip the Quill
   `rgb(136,136,136)` spans, the prose-as-`<h3>` markup and HT-Z1's stray BOM; add
   `short_description` and `meta_description` to both (§5).
5. **Upgrade both SKUs' product images** — 00151 to the official 996 × 1010 hero render, and
   00149 to the newly-found official hood-type gallery, best of which is 1680 × 2672 (§7.2,
   §7.3). Attach only the ✅ rows; the 9 ❌ flight-type images must not be linked to 00149.
6. **Fix the "Hattons" → "Hatton" typo** in 00151's `name` — name only, `model_number`
   untouched (§5).
7. **Link the 500 × 500 rack accessories to HT-T2** as well as HT-Z1 (§5).
8. **Ask the supplier for kW / voltage** on both — genuinely unpublished, not findable
   (§2 trap 5).
9. **Leave `brands.json` alone for now**, but note for a future brand pass: the `website_url`
   must stay `http://` (no HTTPS exists), and https://www.hatton-tech.com/ is the far better
   English destination (§1).

Deliberately **not** recommended: changing HT-T2's 30 L / 80 kg to the official page's
25 L / 65 kg (generation-dependent, §3.1), and swapping HT-Z1's `length`/`width` footprint
axes (medium confidence only, §4).
