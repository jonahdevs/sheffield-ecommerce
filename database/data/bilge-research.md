# Bilge Product Research

Research notes behind the BILGE enrichment/audit pass on `products.json` (July 2026). Covers
all 28 BILGE-branded SKUs: 26 EN 631 Gastronorm containers and lids, one buffet sauce bin,
and one knee-operated hand wash basin. Every page and image URL below was verified live.

---

## 1. Brand identification

**Bilge Endüstriyel Mutfak Ekipmanları** - a Turkish commercial-kitchen-equipment group
founded 1957, one of Turkey's first stainless-steel kitchenware makers. Two related entities:

| Entity | Role | Site |
|---|---|---|
| Bilge Endüstriyel Mutfak Ekipmanları | Sales-facing brand - cooking, prep, storage, refrigeration, dishwashing, sinks | [bilgemutfak.com](https://www.bilgemutfak.com) |
| Bilgeinox | Manufacturing arm - deep-drawn stainless steel, ~5,000 t/year, 52% exported | bilgeinox.com.tr |

Sold by quote request rather than checkout, through a global distributor network - no
Kenya/Africa presence of their own.

The GN range is the universal **EN 631 Gastronorm standard** - plan dimensions are identical
across every compliant manufacturer. Bilge's naming ("Standart Gastronom Küvet" = solid,
"Delikli Gastronom Küvet" = perforated, "Kapak" = lid) is standard industry terminology, not
a proprietary design.

---

## 2. Where to look - and the two URL traps

**The site is reliably fetchable, but the obvious URL guesses 404.**

1. **Product pages need an extra product-family path segment:**

   ```
   404:  /mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet-gn-1-1-serisi
   200:  /mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-1-serisi
   ```

2. **Product pages need the `www.` host** - the bare apex 404s on these paths. Image files
   serve fine from either host.

| Resource | URL |
|---|---|
| Official site | <https://www.bilgemutfak.com> |
| Full PDF catalog (3.5 MB) | <https://www.bilgemutfak.com/urunler/bilge_katalog.pdf> |
| Manufacturing arm | <https://bilgeinox.com.tr> |

**There are no per-product spec sheet PDFs.** Unlike manufacturers who publish one datasheet
per model, Bilge puts the specification *on the product page itself*: each series page
carries a table of every depth with its capacity, internal/external dimensions and product
code. The only PDF is the single master catalog above. So in §3 the spec-source column
points at the series page's own table.

**One series page covers every depth of a fraction**, so a single page is the spec source for
several of our SKUs. All six lid sizes share one page.

**Watch for parallel product families** at sibling URLs: `polikarbon` (polycarbonate),
`thermoplus` / `thermoset`, `saplı` (handled), `sızdırmaz kapak` (sealed lids). Every code in
this document is from the 304-stainless `standart` / `delikli` lines.

---

## 3. Product reference

Official page and spec source per catalogue SKU. **Model** is Bilge's real manufacturer code
- note this differs from the catalogue's `model_number` field, which holds distributor
shorthand (see §6).

| SKU | Catalogue name | Model | Official page | Spec source |
|---|---|---|---|---|
| IMG/TCW/00106 | GN Container 1/1 65 Bilge | 6005637 | [standart GN 1/1](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-1-serisi) | depth table on page - 9 L |
| IMG/TCW/00112 | GN Container 1/1 100 Bilge | 6005657 | [standart GN 1/1](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-1-serisi) | depth table on page - 14 L |
| IMG/TCW/00118 | GN Container 1/1 150 Bilge | 6005638 | [standart GN 1/1](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-1-serisi) | depth table on page - 21 L |
| IMG/TCW/00124 | GN Container 1/1 200 Bilge | 6005512 | [standart GN 1/1](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-1-serisi) | depth table on page - 28 L |
| IMG/TCW/00107 | GN Container 1/2 65 Bilge | 6005517 | [standart GN 1/2](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-2-serisi) | depth table on page - 4 L |
| IMG/TCW/00113 | GN Container 1/2 100 Bilge | 6005518 | [standart GN 1/2](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-2-serisi) | depth table on page - 6.5 L |
| IMG/TCW/00119 | GN Container 1/2 150 Bilge | 6005519 | [standart GN 1/2](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-2-serisi) | depth table on page - 9.5 L |
| IMG/TCW/00108 | GN Container 1/3 65 Bilge | 6005523 | [standart GN 1/3](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-3-serisi) | depth table on page - 2.5 L |
| IMG/TCW/00114 | GN Container 1/3 100 Bilge | 6005524 | [standart GN 1/3](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-3-serisi) | depth table on page - 4 L |
| IMG/TCW/00120 | GN Container 1/3 150 Bilge | 6005525 | [standart GN 1/3](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-3-serisi) | depth table on page - **5.7 L** |
| IMG/TCW/00115 | GN Container 1/4 100 Bilge | 6005529 | [standart GN 1/4](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-4-serisi) | depth table on page - 2.8 L |
| IMG/TCW/00121 | GN Container 1/4 150 Bilge | 6005530 | [standart GN 1/4](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-4-serisi) | depth table on page - 4 L |
| IMG/TCW/00110 | GN Container 1/6 65 Bilge | 6005658 | [standart GN 1/6](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-6-serisi) | depth table on page - 1 L |
| IMG/TCW/00116 | GN Container 1/6 100 Bilge | 6005532 | [standart GN 1/6](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-6-serisi) | depth table on page - 1.6 L |
| IMG/TCW/00122 | GN Container 1/6 150 Bilge | 6005533 | [standart GN 1/6](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-6-serisi) | depth table on page - 2.4 L |
| IMG/TCW/00111 | GN Container 1/9 65 Bilge | 6005534 | [standart GN 1/9](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-9-serisi) | depth table on page - 0.6 L |
| IMG/TCW/00117 | GN Container 1/9 100 Bilge | 6005641 | [standart GN 1/9](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-9-serisi) | depth table on page - **1 L** |
| IMG/TCW/00103 | GN Container Perforated 1/1 65 Bilge | 6005649 | [delikli GN 1/1](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/delikli-gastronom-kuvet/delikli-gastronom-kuvet-gn-1-1-serisi) | depth table on page - no litres published |
| IMG/TCW/00104 | GN Container Perforated 1/1 100 Bilge | 6005576 | [delikli GN 1/1](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/delikli-gastronom-kuvet/delikli-gastronom-kuvet-gn-1-1-serisi) | depth table on page - no litres published |
| IMG/TCW/00105 | GN Container Perforated 1/2 100 Bilge | not listed | [delikli GN 1/2](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/delikli-gastronom-kuvet/delikli-gastronom-kuvet-gn-1-2-serisi) | depth table on page - no litres published |
| IMG/TCW/00125 | GN Lids 1/1 Bilge | 6005669 | [gastronom kapak](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/gastronom-kapak/standart-gastronom-kapak) | size table on page - 530×325 |
| IMG/TCW/00126 | GN Lids 1/2 Bilge | 6005604 | [gastronom kapak](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/gastronom-kapak/standart-gastronom-kapak) | size table on page - 325×265 |
| IMG/TCW/00127 | GN Lids 1/3 Bilge | 6005605 | [gastronom kapak](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/gastronom-kapak/standart-gastronom-kapak) | size table on page - 325×176 |
| IMG/TCW/00128 | GN Lids 1/4 Bilge | 6005651 | [gastronom kapak](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/gastronom-kapak/standart-gastronom-kapak) | size table on page - 265×162 |
| IMG/TCW/00129 | GN Lids 1/6 Bilge | 6005606 | [gastronom kapak](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/gastronom-kapak/standart-gastronom-kapak) | size table on page - 176×162 |
| IMG/TCW/00130 | GN Lids 1/9 Bilge | 6005607 | [gastronom kapak](https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/gastronom-kapak/standart-gastronom-kapak) | size table on page - 176×108 |
| IMG/HYS/00001 | Hand Wash Basin Knee Operated Bilge | 6005202 | [dizden kumandalı evye](https://www.bilgemutfak.com/mutfak-urunleri/bulasikhane-ekipmanlari/yikama-aksesuarlari/dizden-kumandali-evye) | variant table on page - 400×400×220 |
| IMG/HOT/00112 | Bain Marie Sauce Bin 240X210 | unknown | **none exists** - see §7 | none - [distributor listing](https://rs-horeca.az/Bilge-inox-bain-marie-sauce-bin-en) (Cloudflare-gated) |

The catalogue's 1/1 × 200 mm entry is worth noting: 200 mm is a **genuine current Bilge
depth**, offered across the 1/1, 1/2, 1/3, 1/4 series - not an outlier.

---

## 4. Image sourcing

**Bilge's own product photography covers every SKU except the Bain Marie sauce bin** - no
generic EN 631 fallback was needed anywhere. Images were verified live (HTTP 200, real JPEG,
50–82 KB, all distinct files) but **deliberately not downloaded or wired into
`products.json`** - they are listed here for manual review first.

Filename pattern: `bilgemutfak.com/urunler/gastronom-kuvetler/gn-<fraction><depth>.jpg`,
prefixed `delikli-` for perforated, suffixed `-kapak` for lids.

### Missing from the catalogue (14 SKUs)

| SKU | Item | Image URL |
|---|---|---|
| IMG/TCW/00104 | Perforated 1/1 100 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/delikli-gn-11-100.jpg> |
| IMG/TCW/00105 | Perforated 1/2 100 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/delikli-gn-12-100.jpg> |
| IMG/TCW/00106 | Solid 1/1 65 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-11-065.jpg> |
| IMG/TCW/00107 | Solid 1/2 65 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-12-065.jpg> |
| IMG/TCW/00114 | Solid 1/3 100 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-13-100.jpg> |
| IMG/TCW/00117 | Solid 1/9 100 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-19-100.jpg> |
| IMG/TCW/00118 | Solid 1/1 150 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-11-150.jpg> |
| IMG/TCW/00120 | Solid 1/3 150 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-13-150.jpg> |
| IMG/TCW/00124 | Solid 1/1 200 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-11-200.jpg> |
| IMG/TCW/00126 | Lid 1/2 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-12-kapak.jpg> |
| IMG/TCW/00127 | Lid 1/3 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-13-kapak.jpg> |
| IMG/TCW/00128 | Lid 1/4 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-14-kapak.jpg> |
| IMG/TCW/00129 | Lid 1/6 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-16-kapak.jpg> |
| IMG/TCW/00130 | Lid 1/9 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-19-kapak.jpg> |

### Already in the catalogue - Bilge equivalent, for comparison (12 SKUs)

| SKU | Item | Image URL |
|---|---|---|
| IMG/TCW/00103 | Perforated 1/1 65 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/delikli-gn-11-065.jpg> |
| IMG/TCW/00108 | Solid 1/3 65 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-13-065.jpg> |
| IMG/TCW/00110 | Solid 1/6 65 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-16-065.jpg> |
| IMG/TCW/00111 | Solid 1/9 65 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-19-065.jpg> |
| IMG/TCW/00112 | Solid 1/1 100 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-11-100.jpg> |
| IMG/TCW/00113 | Solid 1/2 100 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-12-100.jpg> |
| IMG/TCW/00115 | Solid 1/4 100 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-14-100.jpg> |
| IMG/TCW/00116 | Solid 1/6 100 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-16-100.jpg> |
| IMG/TCW/00119 | Solid 1/2 150 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-12-150.jpg> |
| IMG/TCW/00121 | Solid 1/4 150 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-14-150.jpg> |
| IMG/TCW/00122 | Solid 1/6 150 | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-16-150.jpg> |
| IMG/TCW/00125 | Lid 1/1 ⚠ | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-11-kapak.jpg> |
| IMG/HYS/00001 | Hand wash basin | <https://bilgemutfak.com/urunler/bulasikhane-ekipmanlari/dizden-kumandali-evye.jpg> |

⚠ **IMG/TCW/00125** is the one stored image worth replacing: it shows a **lineup of four
different-sized lids**, not a single 1/1 lid, which reads oddly on a single-SKU listing.

**Lid design confirmed** by direct inspection of the downloaded photos: flat, solid, **no
spoon notch, no steam vent** - just a small recessed centre pull-handle. The catalogue's
existing lid copy makes no false claims here.

**No image exists for the Bain Marie Sauce Bin** anywhere that could be reached - see §7.

---

## 5. Full Bilge series tables

The authoritative capacity/code reference, including depths the catalogue does not stock
(see §8).

| Series | Ext. dims | Depths available (depth mm / capacity / code) |
|---|---|---|
| GN 1/1 solid | 530×325 | 20/2.5L/6005656 · 40/5L/6005510 · 65/9L/6005637 · 100/14L/6005657 · 150/21L/6005638 · 200/28L/6005512 |
| GN 1/2 solid | 325×265 | 20/1.25L/6005514 · 40/2L/6005515 · 65/4L/6005517 · 100/6.5L/6005518 · 150/9.5L/6005519 · 200/12.5L/6005520 |
| GN 1/3 solid | 325×176 | 20/0.75L/6005639 · 40/1.5L/6005521 · 65/2.5L/6005523 · 100/4L/6005524 · 150/5.7L/6005525 · 200/7.8L/6005526 |
| GN 1/4 solid | 265×162 | 20/0.5L/6005527 · 40/1L/6005640 · 65/1.8L/6005528 · 100/2.8L/6005529 · 150/4L/6005530 · 200/5.5L/6005531 |
| GN 1/6 solid | 176×162 | 65/1L/6005658 · 100/1.6L/6005532 · 150/2.4L/6005533 |
| GN 1/9 solid | 176×108 | 65/0.6L/6005534 · 100/1L/6005641 |
| GN 1/1 perforated | 530×325 (int. 505×300) | 20/6005574 · 40/6005575 · 65/6005649 · 100/6005576 · 150/6005577 · 200/6005666 - **no litre figures published** |
| Standard lids | - | 2/1 6005609 · 1/1 6005669 · 2/3 6005652 · 1/2 6005604 · 1/3 6005605 · 1/4 6005651 · 1/6 6005606 · 1/9 6005607 · 2/4 6005611 |

---

## 6. Data audit - errors found and corrected

Every GN capacity in the catalogue was cross-checked against Bilge's published figures.
**Two genuine errors**, both now fixed in `products.json`:

| SKU | Item | Was | Now | Bilge source |
|---|---|---|---|---|
| IMG/TCW/00117 | GN 1/9 × 100 mm | 0.8 L | **1.0 L** | code 6005641 |
| IMG/TCW/00120 | GN 1/3 × 150 mm | 6.0 L | **5.7 L** | code 6005525 |

All 15 other solid-container capacities matched Bilge exactly. All EN 631 plan dimensions
were already correct.

**Flagged, not changed:**

- **Perforated capacities are inferred, not published.** The catalogue states capacities for
  the three perforated pans (00103 9.0 L, 00104 14.0 L, 00105 6.5 L). **Bilge publishes no
  litre figure for the perforated range at all** - these were taken from the same-footprint
  solid pan. That is standard industry convention (Maxima, Hupfer do the same) and is not
  wrong, but it is not a manufacturer-published number either. A perforated pan's usable
  capacity is necessarily lower.
- **Material grade under-specified.** Every record says generic "Stainless steel"; Bilge
  publishes **304-grade** ("304 kalite paslanmaz çelik") throughout. An accuracy/SEO upgrade
  rather than a correction.
- **`model_number` holds distributor shorthand, not Bilge codes.** The catalogue's
  `"1/1*65 -P"` / `"1/2 - C"` format is internal (GN ratio × depth, `-P` perforated,
  `-C` cover). Bilge's real codes are the 6005xxx values in §3 - worth deciding whether
  `model_number` should carry the actual manufacturer code.
- **IMG/TCW/00130** uses `"BLGNL1/9"`, breaking the `"X - C"` pattern of the other five
  lids. Cosmetic only.

---

## 7. Bain Marie Sauce Bin (IMG/HOT/00112) - unresolved, needs the supplier

The one item in the range public sources could not settle. It had **zero content** before
this pass (no image, no description, no spec, `price: 0`).

- **Dimension conflict**: the name says "240X210", the `model_number` says "240*120". No
  Bilge product page for this SKU exists on bilgemutfak.com or bilgeinox.com.tr - every
  plausible category was checked (buffet/servery, bain-marie service units, sauce and
  preserve holders, stainless kitchen accessories, Bilgeinox service lines).
  **Resolved to 240×210 mm** in `products.json`, by analogy: a comparable Intergastro product
  ("13 L stainless bain marie insert, 240×240 mm, H 235 mm") shows a ~240 mm insert with
  200–235 mm height is the normal shape for this category, so a 240×120 mm bin would be
  unusually shallow. Treat `"240*120"` as an unreliable distributor artifact.
- **Brand confirmed, specs not**: an Azerbaijani distributor lists a "**Bilge Inox Bain Marie
  Sauce Bin**" - proof Bilge sells exactly this product - but the page is Cloudflare-gated
  (403 to every automated method tried), so nothing could be extracted:
  <https://rs-horeca.az/Bilge-inox-bain-marie-sauce-bin-en>
- **No image found anywhere.** Written up in `products.json` with only what is defensible
  (stainless steel, bain-marie/buffet sauce insert, 240×210 mm) and **deliberately no
  capacity figure**, since none is sourced.
- **Also**: `price` is `0`, which reads as a data gap rather than a real price. Left alone as
  a business decision, but it needs a real value before this could ever be published.
- **Next step**: open the distributor listing above in a browser (the Cloudflare challenge
  should pass for a human), or get a spec sheet from the supplier.

---

## 8. Range gaps

Sizes Bilge makes in the same 304-stainless lines that the catalogue does not carry, if the
range is worth filling:

- **20 mm and 40 mm depths** across GN 1/1, 1/2, 1/3 and 1/4 - the shallow display/prep pans
- **200 mm depth** in GN 1/2 (12.5 L), 1/3 (7.8 L) and 1/4 (5.5 L) - only 1/1 × 200 is stocked
- **GN 2/1, 2/3 and 2/4 lids** (codes 6005609, 6005652, 6005611) - implying Bilge also makes
  containers in those footprints
- **Perforated 1/1 in 20, 40, 150 and 200 mm**, and perforated fractions beyond 1/1 and 1/2
- **Parallel material lines**: polycarbonate, thermoplus/thermoset, handled (`saplı`) pans,
  sealed lids (`sızdırmaz kapak`)

---

## 9. Summary of `products.json` changes this pass

- **Capacity fixes**: IMG/TCW/00117 (0.8 → 1.0 L), IMG/TCW/00120 (6.0 → 5.7 L)
- **IMG/HYS/00001** (Hand Wash Basin): added `width`, corrected `height` (400 → 220 - the
  true 400×400 footprint had been mis-mapped into length/height with the real height absent);
  full prose description + Key Features; spec table adding the confirmed 15-second knee-press
  flow and hot/cold supply
- **IMG/HOT/00112** (Bain Marie Sauce Bin): cautious description + spec table added,
  dimensions resolved to 240×210 mm, no capacity claimed
- **No `image` field was changed anywhere.** All image sourcing in §4 is presented as
  verified links for manual review first.
