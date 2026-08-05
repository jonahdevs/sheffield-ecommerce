# Kalerm Product Research

**Supersedes `old/kalerm-research.md`** (July 2026). That file's identification work was mostly
right and is retained as the audit trail, but this pass overturns three of its conclusions - the
K90L width, the KLM1601 height, and the "transcription drift" theory - and closes its biggest open
question. Read this file, not that one.

Pass date: August 2026. Covers all 4 KALERM SKUs. **No `products.json` or `brands.json` change has
been applied.** `model_number` is the catalogue's unique ID and is never edited in a research pass.

---

## 1. Brand

**Kalerm** = **Suzhou Industrial Park Kalerm Electric Appliance Co., Ltd.** (Kalerm Technology
(Suzhou) Co., Ltd.), Building 10C, Suchun Industrial Square, #428 Xinglong Street, SIP, 215021
Suzhou, China - the address printed on its own TUV SUD certificates. Red Dot Design Award winner,
exports to 37+ countries.

- `brands.json` `website_url` is **`null`**. The correct value is https://www.kalerm.com - verified
  live this pass, HTTP 200, 216-URL sitemap. **Recommended change, unapplied.**
- Brand-name casing is already consistent (`brands.json` "Kalerm", `products.json` "KALERM").

### Where the data actually lives

| Resource | URL | Value |
|---|---|---|
| **Kalerm's archived English site** | https://web.archive.org/web/20200331073833/http://www.kalerm.com/en_us/coffee-machines-commercial/k90l.html | ⭐ **The find of this pass.** Full factory spec tables for K90L, K95L, K95 and KLM1601. Missed in July because the search was aimed at the dead `o.kalerm.com`. |
| **Kalerm's archived `/download` directory** | https://web.archive.org/web/20181207192537/http://www.kalerm.com/en_us/download | ⭐ 22 PDFs, incl. **TUV SUD CE Attestations naming model codes**. Fully rasterised - invisible to text search. |
| Kalerm's export storefront | https://kalerm123.en.made-in-china.com/ | 7 listings, each with `Model NO.` and one original render. Still the only place K90L / K95L / K1601L / KLM1601 / KLM1602 / KLM1604 / KLM1601Pro are sold as such. |
| Archived CN K-series pages | https://web.archive.org/web/20190219005417/http://www.kalerm.com/k-series/K1601E.html · https://web.archive.org/web/20191114142148/http://www.kalerm.com/k-series/k1601L.html | The `E` / `L` pairing and the CNY RRPs |
| Live site | https://www.kalerm.com | Current lineup only (E/M/D, X/XS/Y/P/O/Z, A/B). **None of our four are on it.** |
| Distributors used | https://binasaranasejahtera.com/product/kalerm-klm-1601-coffee-machine/ · https://www.cafemutfak.com/en/product/kalerm-k90l-automatic-coffee-machine-288 · https://hitmutfak.com/en/product/kalerm-k95l-fully-automatic-espresso-coffee-machine/ · https://superhouse-cafecorp.com/products/kalerm-k95l/ | All the above-800 px imagery |

**⚠ WebSearch was already exhausted (200/200) when this brand started.** Everything here came from
direct HTTP probing, the Wayback CDX API, and the URL list carried in `old/kalerm-research.md`.
Distributor discovery was therefore bounded by leads already on record. This is an **outage, not a
finding** - there may be Kalerm resellers with better K90L imagery that no search could be run to
find.

---

## 2. What each SKU actually is

| SKU | Catalogue name | Stored `model_number` | **Kalerm's actual model** | Confidence |
|---|---|---|---|---|
| IMG/COF/00071 | Automatic Coffee Machine Fao 30 | `FAO 30` | **KLM1601** | High |
| IMG/COF/00072 | Automatic Coffee Machine FAB50 | `FAB 50` | **K1601E** | **High** (was Low in July) |
| IMG/COF/00073 | Automatic Coffee Machine Fab 100 | `K90L BGS` | **K90L** | High |
| IMG/COF/00074 | Automatic Coffee Machine Fas 100 | `K95L EBGS` | **K95L** | High |

### 2.1 The K1601E proof - July's biggest open question, closed

July concluded the base 1.8 L variant's Kalerm code "could not be established… `K1601` is the
obvious inference by symmetry, but it is unconfirmed - **Low** confidence, and it should not be
written into `model_number` on that basis." A later addendum raised it to High on the strength of
the archived CN pages. This pass adds an **independent second source** and settles it:

**TUV SUD Attestation of Conformity No. E8A 17 09 86017 033**, holder *Suzhou Industrial Park
Kalerm Electric Appliance Co., Ltd*, "Electric coffee makers / Fully automatic coffee machine",
**Models: `K1601E, K1601L, K2601E, K2601L`**, rated AC 220-240 V, 50/60 Hz, **1400 W**, protection
class I, dated 2017-09-26.

The certificate is Kalerm's own paperwork, it names `K1601E` as a real product, and its 1400 W is
exactly what the FAB 50 record stores. Combined with the archived CN product pages -

| | **K1601E** | **K1601L** |
|---|---|---|
| Water tank | **1.8 L** | 6 L |
| Bean hopper | 1000 g | 1000 g |
| RRP (CN) | CNY 13,860 | CNY 14,998 |

- and our record's `1.8 L / water barrel` + `1000 g` + `1400 W`, **IMG/COF/00072 is a Kalerm
`K1601E`**.

The document is fully rasterised. `page.get_text()` returns an empty string; it only yields to a
render. Anyone re-checking this must render it.

### 2.2 The other three

- **00071 / KLM1601** - Kalerm's archived KLM1601 page matches our record on **every** field,
  including the 1.5 m cord that July flagged as wrong (July compared against the storefront, which
  says 1.2 m; Kalerm's own page says 1.5 m, which is what we store). Certificate **E8A 17 09 86017
  032** names `KLM1601, KLM1601X, KLM1601Pro, KLM2601, KLM2601X, KLM2601Pro` at 1400 W.
- **00073 / K90L** - our SAP remark is Kalerm's K90L page verbatim, right down to the 3.5" TFT,
  100~160 mm spout, 1.8 m cord and 18.5/23 kg. Certificate **E8A 18 05 86017 053** names
  `K90, K90L` at 2700 W.
- **00074 / K95L** - every feature is the K95L page verbatim. `K905` still returns nothing anywhere.
  The `K905 EBGS` → `K95L EBGS` correction already applied to `products.json` is **confirmed
  correct; do not revert it.**

`BGS` / `EBGS` remain unexplained after a second pass - no Kalerm document, certificate or
distributor listing in any language uses them. Treat as an order/configuration suffix and preserve.

---

## 3. Dimensions - three corrections, and SAP wins two of the four rows

SAP's column order **varies per row inside this brand**. Establishing it from SAP alone first, with
no external source: 00072 stores a 1.8 L, no-side-tank machine as **506 wide × 303 deep**, while
its 6 L side-tank sibling the K1601L is **403 wide**. A machine cannot lose 4.2 L of tank and gain
103 mm of width. That single self-contradiction identifies 00072 as the odd row.

| SKU | Model | SAP W/D/H | Kalerm's own | Verdict |
|---|---|---|---|---|
| 00071 | KLM1601 | 302 / 370 / **450** | `L*W*H 370*302*450` → D 370, W 302, **H 450** | **SAP correct.** `products.json` 370/302/450 has length/width swapped. |
| 00072 | K1601E | 506 / 303 / 581 | K1601L manual p29 `511 × 403 × 582` (L×W×H); E is the narrow variant | **SAP order is D/W/H here.** True W/D/H ≈ **303 / 506 / 581** = what `products.json` already holds. |
| 00073 | K90L | **403** / 511 / 582 | `D*W*H 511*403*582` → W **403** | **SAP correct.** `products.json` holds 390, which is the **K95L's** width. |
| 00074 | K95L | 403 / 511 / 582 | `511*390*582` → W **390** | Order right; the value **403 is 00073's**. Cross-row contamination. |

**Correction 1 - the K90L is 403 mm wide, not 390.** July asserted Kalerm publishes 390 for both
the K90L and the K95L and that our 403 was a bad transcription. Kalerm publishes **403 for the
K90L** and **390 for the K95L**. They are not the same cabinet. Recommending 390 for 00073 would
have introduced an error.

**Correction 2 - the KLM1601 is 450 mm tall, not 370.** July called `height: 450` "the largest
single error in the brand" and recommended 370. Kalerm's own page and SAP independently agree on
**450**. Acting on July's recommendation would have shortened a real machine by 80 mm in the
catalogue - the exact failure mode the recommendation was meant to prevent.

**Correction 3 - the "transcription drift cluster" is not drift.** July flagged spout `100~160 mm`,
cord `1.8 m` and net weight on 00072/00073/00074 as ours-wrong / Kalerm-right, on the strength of
the export storefront. But **Kalerm's own K1601L operation manual, page 29** publishes spout
`100 - 160 mm` and cord `1.8 m`. Kalerm publishes two different figure sets in two different
documents. Our records agree with the manual. No correction warranted.

### The K1601L manual page 29 spec table (Kalerm's own, CN domestic market)

220 V / 50 Hz · heating 1200 W · grinder 120 W · pump 19 bar · tank 6 L · hopper 1000 g ·
grounds 30-35 pucks · brew dose 7-14 g · spout 100-160 mm · cord 1.8 m · net weight 17.2 kg ·
**volume (L×W×H) 511 × 403 × 582 mm**.

Note the domestic rating (220 V / 50 Hz, 1200 W + 120 W) differs from the export listing
(220-240 V / 50-60 Hz, 1400 W). The CE certificate's 1400 W is the total.

---

## 4. Imagery

Staged in `products resorce final\kalerm\`; ledger in `_sourced.json`, full notes in `_FINDINGS.md`.

Every file was **rendered and inspected**. No synthetic imagery in this brand. A perceptual
duplicate sweep (16×16 average hash to shortlist, per-pixel RMS on 256×256 greyscale to confirm)
over all 16 files returned exactly one hit, and it was real: two of the three K1601L renders
extracted from the manual in July are the same photograph at two scales (Hamming 0, RMS 1.06). The
duplicate was deleted. **No photograph is now shared between SKUs** - the 00071/00072 shared-photo
problem documented in July is resolved.

**A recorded ceiling was wrong again.** July recorded made-in-china as capped at 530×577 "for this
brand". It is per-asset. Re-running the full prefix ladder on every listing:

| Model | Native size |
|---|---|
| K95L | **1080 × 720** |
| KLM1601 | 588 × 595 |
| K1601L | 530 × 577 |
| K90L | **355 × 480** ← the brand's real floor problem |

**"Pick the biggest" fails here too.** The 1500×1200 K95L PNG is the largest file in the brand, but
the machine occupies ~55% of the canvas; effective subject resolution ≈ 700 px, *less* than the
800×800 front shot.

| SKU | ≥800 px | Best | State |
|---|---|---|---|
| 00071 KLM1601 | 4 | 1024×1024 clean front, 3 angles | **sourced** |
| 00072 K1601E | 1 (uncited) + 2 representative | 1000×1000 K1601E render | **partial** |
| 00073 K90L | 1 | 800×800 (meets floor exactly) | **partial** - one image only |
| 00074 K95L | 3 | 1080×720 official | **sourced** |

**Open: the 00072 citation gap.** The 1000×1000 K1601E render carried forward from July has no
recorded source. Re-verified genuine and correct-variant (no side tank) this pass, and re-probed
against made-in-china, live kalerm.com, the K1601L manual and the Wayback CDX for
`kalerm.com/upfiles/201803/*` - it is none of them. Filename carries `UNCITED`.

### Tried and unusable

- `o.kalerm.com` - DNS still gone.
- kalerm.com's **gallery** images (`/upfiles/201909/*`, `/upfiles/201803/1519972747.png`) - linked
  from the archived pages but **not themselves archived**. Only three 228×255 KLM1601 thumbnails
  and a 973×393 banner survive.
- 8 of the 22 archived PDFs come back **truncated at exactly 1,048,576 bytes** and will not open.
  A **K95 / K95L CE certificate** may be among them; it is the one attestation not recovered.
- https://konchero.com - checked because cafemutfak also sells a "Konchero K90L". Konchero is a
  separate Turkish house brand with no 1601/K90/K95 pages. Dead end.
- https://www.kalerm.cn - live, but its 34 `show-59-*` pages are customer case studies, not products.
- https://www.roundtheclockmall.com and https://www.inoksanshop.com.tr - still 403 to every user agent.
- https://kalerm.en.alibaba.com - empty shell.

---

## 5. Recommended changes, in priority order (nothing applied)

1. **`brands.json`: Kalerm `website_url` `null` → `https://www.kalerm.com`.** Lowest risk, highest
   certainty.
2. **`IMG/COF/00072` `model_number`: `FAB 50` → `K1601E`** - now on two independent Kalerm sources.
   Needs explicit approval (unique ID). Keep "FAB 50" as the house name.
3. **`IMG/COF/00071` `model_number`: `FAO 30` → `KLM1601`** - same caveat.
4. **Dimension fields:**
   - `IMG/COF/00071`: `370 / 302 / 450` → **`302 / 370 / 450`** (order only; the height is right).
   - `IMG/COF/00073`: `390 / 511 / 582` → **`403 / 511 / 582`**.
   - `IMG/COF/00074`: leave the width at **390** and do **not** copy 00073's 403 across.
   - `IMG/COF/00072`: leave `303 / 506 / 581`.
5. **Do NOT apply July's §5 "transcription drift" corrections** (spout 105~165 mm, cord 1.5 m).
   Kalerm's own manual backs our figures.
6. **Replace 00073's product photo.** It currently shows a big-touchscreen K95L-class machine; the
   K90L has a 3.5" screen ringed by six physical buttons. `IMG-COF-00073__K90L-front-1.webp` is the
   candidate.
7. **Untangle the accessory graph on `IMG/COF/00071`.** The 13 kg / 250 g / 1.8 L compact is
   currently the parent of a Dr. Coffee SC15 *and* a Rancilio/Egro milk fridge. Kalerm sells its own
   C-series fridges and pairs them with the **K95L**.

---

## 6. Sources

https://web.archive.org/web/20200331073833/http://www.kalerm.com/en_us/coffee-machines-commercial/k90l.html
https://web.archive.org/web/20190922010530/http://www.kalerm.com/en_us/coffee-machines-commercial/k95l.html
https://web.archive.org/web/20200113110548/http://www.kalerm.com/en_us/coffee-machines-commercial/k95.html
https://web.archive.org/web/20220617001002/http://www.kalerm.com/en_us/home-coffee-machines/klm1601.html
https://web.archive.org/web/20181207192537/http://www.kalerm.com/en_us/download
https://web.archive.org/web/20190219005417/http://www.kalerm.com/k-series/K1601E.html
https://web.archive.org/web/20191114142148/http://www.kalerm.com/k-series/k1601L.html
https://kalerm123.en.made-in-china.com/
https://kalerm123.en.made-in-china.com/product/RSLxoOgMgmfe/China-Horeca-Fully-Automatic-Coffee-Machine.html
https://kalerm123.en.made-in-china.com/product/cSGxqXhFkBps/China-Automatic-Coffee-Machine-for-Big-Office.html
https://kalerm123.en.made-in-china.com/product/mvLQeIPrRnto/China-Fully-Automatic-Coffee-Machine-for-Office-Use.html
https://kalerm123.en.made-in-china.com/product/zXnmEyUOsprk/China-Fully-Automatic-One-Touch-Cappuccino-Coffee-Machine.html
https://binasaranasejahtera.com/product/kalerm-klm-1601-coffee-machine/
https://www.cafemutfak.com/en/product/kalerm-k90l-automatic-coffee-machine-288
https://hitmutfak.com/en/product/kalerm-k95l-fully-automatic-espresso-coffee-machine/
https://superhouse-cafecorp.com/products/kalerm-k95l/
https://www.kalerm.com
https://www.kalerm.com/sitemap.xml
https://www.kalerm.cn
