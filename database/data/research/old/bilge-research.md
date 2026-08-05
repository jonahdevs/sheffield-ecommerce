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

---

## Image sourcing (July 2026)

The first image pass on BILGE. Staged in
`C:\Users\jonah.wakahiu\Desktop\ecommerce\products resource\bilge-images\`.
**55 files: 27 manufacturer photos, 27 above-floor representative photos, 3 brand-reference
assets (including the catalogue PDF).** Nothing was copied into the project and no `image`
field was touched. Every file below was opened and looked at.

### The two-source split, and why

Two independent photo sets exist for this range, and neither satisfies both tests on its own:

1. **Bilge's own per-depth photography** (`bilgemutfak.com/urunler/gastronom-kuvetler/...`).
   Every solid-GN shot is **captioned with its own GN size and depth** - e.g. "GN 1/1 65 /
   Derinliği 6,5 cm" with 32,5 / 53 / 6,5 cm dimension arrows drawn onto the image. That
   caption is what lifts these above the EN 631 problem: the photo is not merely *a* 1/1
   65 mm pan, it is the manufacturer publishing *its* 1/1 65 mm pan and labelling it as such.
   **All 27 are 420 x 512** - below the 800 px floor.
2. **Bilge-Inox-keyed reseller photography** (galleyz.com, a Shopify store whose `vendor`
   field is literally `Bilge Inox`). **800 x 800**, clears the floor - but the store reuses
   **one photo per GN fraction** across every depth in that fraction, so the photo cannot
   show which depth it is. It is also visibly a different physical product from Bilge's own
   shots (rounded flange corners and a heavy dark outline, versus the pointed flanges in
   Bilge's photography), so it is generic Gastronorm stock imagery attached to a Bilge-keyed
   listing.

So each GN SKU is staged **twice**: the manufacturer's captioned shot marked `-TOOSMALL`, and
the above-floor reseller shot marked `REPRESENTATIVE-`.

### Proof of ceiling for the `-TOOSMALL` files

420 x 512 is the real ceiling for Bilge's own photography, not a thumbnail:

- The series page HTML references **exactly one** image per depth, at the same URL - no
  `_large` / `-big` sibling, no srcset. Verified on
  <https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-1-serisi>
- The 22 MB, 87-page master catalogue was pulled and its **embedded** image objects extracted
  with PyMuPDF (not page rasterisation). The Gastronorm spread (p. 5) holds 107 embedded
  images whose **largest is 395 x 257** - smaller than the web renders.
  <https://www.bilgemutfak.com/urunler/bilge_katalog.pdf>
- Bilgeinox's own product-family images are **200 x 150**.
  <https://www.bilgeinox.com.tr/files/productImg/Standart-GN-Kuvetler.jpg>
- Four Bilge-keyed resellers were checked for a larger copy of the *captioned* photo. None
  hosts it - they all use their own or generic imagery.

### Files - Gastronorm containers

Every `-TOOSMALL` file is **420 x 512**, from
`https://bilgemutfak.com/urunler/gastronom-kuvetler/<name>.jpg` (38-89 KB).
Every `REPRESENTATIVE-` file is **800 x 800** (20-36 KB), the Shopify master (no `_1024x`
suffix) from `https://cdn.shopify.com/s/files/1/0892/6501/3052/files/...-<id>-37-B.jpg` as
linked from its galleyz.com product page.

| SKU | Manufacturer file (420x512) | Source | What was visually confirmed |
|---|---|---|---|
| IMG/TCW/00106 | `IMG-TCW-00106__gn-1-1-65-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-11-065.jpg> | Captioned "GN 1/1 65 / Derinliği 6,5 cm", arrows 32,5 / 53 / 6,5 cm - matches record 530x325x65 |
| IMG/TCW/00112 | `IMG-TCW-00112__gn-1-1-100-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-11-100.jpg> | Captioned "GN 1/1 100", 32,5 / 53 / 10 cm - matches record |
| IMG/TCW/00118 | `IMG-TCW-00118__gn-1-1-150-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-11-150.jpg> | Captioned "GN 1/1 150", 32,5 / 53 / 15 cm - matches record |
| IMG/TCW/00124 | `IMG-TCW-00124__gn-1-1-200-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-11-200.jpg> | Captioned "GN 1/1 200", 32,5 / 53 / 20 cm - visibly a deep pan; confirms 200 mm is a real Bilge depth |
| IMG/TCW/00107 | `IMG-TCW-00107__gn-1-2-65-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-12-065.jpg> | Captioned "GN 1/2 65", 32,5 / 26,5 / 6,5 cm - matches record 325x265x65 |
| IMG/TCW/00113 | `IMG-TCW-00113__gn-1-2-100-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-12-100.jpg> | Captioned "GN 1/2 100", 32,5 / 26,5 / 10 cm - matches record |
| IMG/TCW/00119 | `IMG-TCW-00119__gn-1-2-150-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-12-150.jpg> | Captioned "GN 1/2 150", 32,5 / 26,5 / 15 cm - matches record |
| IMG/TCW/00108 | `IMG-TCW-00108__gn-1-3-65-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-13-065.jpg> | Captioned "GN 1/3 65", 17,6 / 32,5 / 6,5 cm - matches record 325x176x65 |
| IMG/TCW/00114 | `IMG-TCW-00114__gn-1-3-100-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-13-100.jpg> | Captioned "GN 1/3 100", 17,6 / 32,5 / 10 cm - matches record |
| IMG/TCW/00120 | `IMG-TCW-00120__gn-1-3-150-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-13-150.jpg> | Captioned "GN 1/3 150", 17,6 / 32,5 / 15 cm - matches record |
| IMG/TCW/00115 | `IMG-TCW-00115__gn-1-4-100-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-14-100.jpg> | Captioned "GN 1/4 100", 16,2 / 26,5 / 10 cm - matches record 265x162x100 |
| IMG/TCW/00121 | `IMG-TCW-00121__gn-1-4-150-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-14-150.jpg> | Captioned "GN 1/4 150", 16,2 / 26,5 / 15 cm - matches record |
| IMG/TCW/00110 | `IMG-TCW-00110__gn-1-6-65-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-16-065.jpg> | Captioned "GN 1/6 65", 17,6 / 16,2 / 6,5 cm - matches record 176x162x65 |
| IMG/TCW/00116 | `IMG-TCW-00116__gn-1-6-100-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-16-100.jpg> | Captioned "GN 1/6 100", 17,6 / 16,2 / 10 cm - matches record |
| IMG/TCW/00122 | `IMG-TCW-00122__gn-1-6-150-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-16-150.jpg> | Captioned "GN 1/6 150", 17,6 / 16,2 / 15 cm - matches record |
| IMG/TCW/00111 | `IMG-TCW-00111__gn-1-9-65-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-19-065.jpg> | Captioned "GN 1/9 65", 10,8 / 17,6 / 6,5 cm - matches record 176x108x65 |
| IMG/TCW/00117 | `IMG-TCW-00117__gn-1-9-100-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-19-100.jpg> | Captioned "GN 1/9 100", 10,8 / 17,6 / 10 cm - matches record |
| IMG/TCW/00103 | `IMG-TCW-00103__perforated-gn-1-1-65-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/delikli-gn-11-065.jpg> | Uncaptioned. 1/1 proportions, shallow; perforation **in the base only** |
| IMG/TCW/00104 | `IMG-TCW-00104__perforated-gn-1-1-100-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/delikli-gn-11-100.jpg> | Uncaptioned. 1/1 proportions, deeper; perforation in base **and sides** |
| IMG/TCW/00105 | `IMG-TCW-00105__perforated-gn-1-2-100-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/delikli-gn-12-100.jpg> | Uncaptioned. Half-size proportions, base and side perforation |

| SKU | Representative file (800x800) | galleyz.com image id |
|---|---|---|
| IMG/TCW/00106 | `IMG-TCW-00106__REPRESENTATIVE-gn-1-1-family-galleyz-800.jpg` | 69352 |
| IMG/TCW/00112 | `IMG-TCW-00112__REPRESENTATIVE-gn-1-1-family-galleyz-800.jpg` | 69368 |
| IMG/TCW/00118 | `IMG-TCW-00118__REPRESENTATIVE-gn-1-1-family-galleyz-800.jpg` | 69353 |
| IMG/TCW/00124 | `IMG-TCW-00124__REPRESENTATIVE-gn-1-1-family-galleyz-800.jpg` | 69255 |
| IMG/TCW/00107 | `IMG-TCW-00107__REPRESENTATIVE-gn-1-2-family-galleyz-800.jpg` | 69258 |
| IMG/TCW/00113 | `IMG-TCW-00113__REPRESENTATIVE-gn-1-2-family-galleyz-800.jpg` | 69259 (byte-identical to 00107) |
| IMG/TCW/00119 | `IMG-TCW-00119__REPRESENTATIVE-gn-1-2-family-galleyz-800.jpg` | 69260 (byte-identical to 00107) |
| IMG/TCW/00108 | `IMG-TCW-00108__REPRESENTATIVE-gn-1-3-family-galleyz-800.jpg` | 69263 |
| IMG/TCW/00114 | `IMG-TCW-00114__REPRESENTATIVE-gn-1-3-family-galleyz-800.jpg` | 69264 (byte-identical to 00108) |
| IMG/TCW/00120 | `IMG-TCW-00120__REPRESENTATIVE-gn-1-3-family-galleyz-800.jpg` | 69265 (byte-identical to 00108) |
| IMG/TCW/00115 | `IMG-TCW-00115__REPRESENTATIVE-gn-1-4-family-galleyz-800.jpg` | 69269 |
| IMG/TCW/00121 | `IMG-TCW-00121__REPRESENTATIVE-gn-1-4-family-galleyz-800.jpg` | 69270 (byte-identical to 00115) |
| IMG/TCW/00110 | `IMG-TCW-00110__REPRESENTATIVE-gn-1-6-family-galleyz-800.jpg` | 69369 |
| IMG/TCW/00116 | `IMG-TCW-00116__REPRESENTATIVE-gn-1-6-family-galleyz-800.jpg` | 69272 (byte-identical to 00110) |
| IMG/TCW/00122 | `IMG-TCW-00122__REPRESENTATIVE-gn-1-6-family-galleyz-800.jpg` | 69273 (byte-identical to 00110) |
| IMG/TCW/00111 | `IMG-TCW-00111__REPRESENTATIVE-gn-1-9-family-galleyz-800.jpg` | 69274 |
| IMG/TCW/00117 | `IMG-TCW-00117__REPRESENTATIVE-gn-1-9-family-galleyz-800.jpg` | 69356 (byte-identical to 00111) |
| IMG/TCW/00103 | `IMG-TCW-00103__REPRESENTATIVE-perforated-gn-1-1-family-galleyz-800.jpg` | 69363 |
| IMG/TCW/00104 | `IMG-TCW-00104__REPRESENTATIVE-perforated-gn-1-1-family-galleyz-800.jpg` | 69309 |
| IMG/TCW/00105 | `IMG-TCW-00105__REPRESENTATIVE-perforated-gn-1-2-family-galleyz-800.jpg` | 69312 |

The galleyz.com product pages follow the pattern
<https://galleyz.com/products/bilge-inox-gn-1-1-65-mm-paslanmaz-celik-standart-gastronorm-kuvet>
(swap the fraction and depth; `delikli` in place of `standart` for perforated). Appending
`.json` to any of them returns the master image URL and its dimensions. The store's full
Bilge-Inox listing - 296 products - was enumerated from <https://galleyz.com/sitemap.xml>.

### Files - lids

| SKU | Manufacturer file (420x512) | Source | Representative file (800x800) |
|---|---|---|---|
| IMG/TCW/00125 | `IMG-TCW-00125__gn-lid-1-1-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-11-kapak.jpg> | `IMG-TCW-00125__REPRESENTATIVE-gn-lid-generic-galleyz-800.jpg` (id 69380) |
| IMG/TCW/00126 | `IMG-TCW-00126__gn-lid-1-2-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-12-kapak.jpg> | `IMG-TCW-00126__REPRESENTATIVE-gn-lid-1-2-galleyz-800.jpg` (id 69334) |
| IMG/TCW/00127 | `IMG-TCW-00127__gn-lid-1-3-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-13-kapak.jpg> | `IMG-TCW-00127__REPRESENTATIVE-gn-lid-1-3-galleyz-800.jpg` (id 69335) |
| IMG/TCW/00128 | `IMG-TCW-00128__gn-lid-1-4-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-14-kapak.jpg> | `IMG-TCW-00128__REPRESENTATIVE-gn-lid-generic-galleyz-800.jpg` (id 69364) |
| IMG/TCW/00129 | `IMG-TCW-00129__gn-lid-1-6-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-16-kapak.jpg> | `IMG-TCW-00129__REPRESENTATIVE-gn-lid-generic-galleyz-800.jpg` (id 69336) |
| IMG/TCW/00130 | `IMG-TCW-00130__gn-lid-1-9-bilge-TOOSMALL.jpg` | <https://bilgemutfak.com/urunler/gastronom-kuvetler/gn-19-kapak.jpg> | `IMG-TCW-00130__REPRESENTATIVE-gn-lid-generic-galleyz-800.jpg` (id 69337) |

**Lid design re-confirmed** across both photo sets: flat, solid, with a small recessed
circular pull dish and a short bar - **no spoon notch, no steam vent, no gasket**. Bilge's
separate `sızdırmaz contalı` (sealed/gasketed) and `kepçe delikli` (ladle-notch) lid lines are
different products; our SKUs are the plain `standart` lid.

⚠ **The six lid photos cannot be told apart by eye.** They sit on per-size URLs on Bilge's own
site, and the galleyz store reuses **one lid photo across 1/1, 1/4, 1/6 and 1/9** (byte
identical), giving only 1/2 and 1/3 their own. On the manufacturer's set the apparent aspect
ratio of the lid outline **does not track the stated GN size** - measured bounding boxes give
1/1 1.57, 1/2 1.76, 1/3 1.39, 1/4 1.43, 1/6 1.69, 1/9 1.40, against expected 1.63 / 1.23 /
1.85 / 1.64 / 1.09 / 1.63. The shots are taken at varying angles, so perspective swamps the
shape. **Size attribution for the lids rests on the URL and page mapping, not on the
photograph.**

⚠ **IMG/TCW/00125** - the replacement flagged in §4 is now staged. The stored catalogue image
shows a **line-up of four different-sized lids**; the newly sourced `gn-11-kapak.jpg` shows a
**single lid**, which is what a single variant listing needs.

### Files - hand wash basin (IMG/HYS/00001)

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-HYS-00001__knee-basin-EMPERO-BADGED-photo-on-bilge-page-TOOSMALL.jpg` | 420x512 | 30.8 KB | <https://bilgemutfak.com/urunler/bulasikhane-ekipmanlari/dizden-kumandali-evye.jpg> |
| `IMG-HYS-00001__knee-basin-EMPERO-BRANDED-40x40x22-800.jpg` | 800x800 | 31.5 KB | <https://witcdn.cafemarkt.com/empero-el-yikama-evyesi-dizden-kumandali-40x40x22-cm-evyeler-empero-43041-25-B.jpg> |

Both show the same unit. Confirmed visually at 800 px: square deck-mounted stainless basin,
oval bowl, centre waste, **single swan-neck spout**, and the actuator is a **small dark knee
pad projecting from the right-hand side panel - NOT a full-width front knee-push panel**. Both
photos carry an **EMPERO** badge on the front apron. See findings 1-5.

### Brand reference

| File | Px / pages | Size | Source |
|---|---|---|---|
| `_brand-reference/bilgeinox-gastronorm-range-lineup.jpg` | 1726x1207 | 515 KB | <https://www.bilgeinox.com.tr/files/slider/03_Gastronom-Grubu_DeMain_0001.jpg> |
| `_brand-reference/bilge-mutfak-full-catalogue.pdf` | 87 pp | 21.8 MB | <https://www.bilgemutfak.com/urunler/bilge_katalog.pdf> |
| `_brand-reference/bilge-logo.png` | 290x84 | 10.4 KB | <https://www.bilgemutfak.com/img/logo/logo-bilge.png> |

The line-up shot is Bilgeinox's own studio photography of the whole Gastronorm range nested
together on a dark set - the best single view of the actual hardware found anywhere, including
a perforated pan, and the clearest evidence of the real flange profile. It is a range shot,
not a SKU shot, so it lives in `_brand-reference/`.

**There is still no per-model spec sheet PDF.** The §2 finding stands: the master catalogue is
the only PDF Bilge publishes, so nothing could be named `<SKU>__spec-sheet.pdf`.

### Coverage - stated plainly

| Bucket | Count | SKUs |
|---|---|---|
| Exact-model manufacturer photo, **captioned with its own size and depth** (below 800 px floor) | 17 | 00106, 00107, 00108, 00110, 00111, 00112, 00113, 00114, 00115, 00116, 00117, 00118, 00119, 00120, 00121, 00122, 00124 |
| Exact-model by URL/page mapping only, **uncaptioned** (below floor) | 9 | 00103, 00104, 00105 (perforated); 00125, 00126, 00127, 00128, 00129, 00130 (lids) |
| Exact model, above floor, but **competitor-branded** | 1 | IMG/HYS/00001 |
| Representative only, above floor - staged *in addition to* the above, never instead of it | 26 | every GN SKU |
| **Nothing found** | 1 | IMG/HOT/00112 (Bain Marie Sauce Bin) |

**Not one GN SKU has an image that is both exact-model and above 800 px.** That is the honest
answer for this brand, and it follows directly from the EN 631 problem: the only photography
that proves *which* pan it is comes from Bilge itself, and Bilge publishes at 420 x 512.

Where the line was drawn: a GN photo was called exact-model **only** where it comes from
Bilge/Bilgeinox's own published material. Within that, the 17 captioned solid-container shots
are a genuinely strong claim, because the image carries its own printed size and depth. The 3
perforated pans and 6 lids are uncaptioned, so their claim rests on the URL mapping alone -
weaker, and weaker still for the lids. Everything from a reseller was called
`REPRESENTATIVE-`, however clearly the listing said "Bilge Inox", because the photography is
generic and reused across depths. Widening the source pool raised resolution; it did **not**
raise the exact-model count for the GN range.

### Findings and contradictions - reported, not fixed

Nothing below was changed in `products.json`.

**1. IMG/HYS/00001 is an Empero product, not a Bilge one.** ⚠ The most consequential finding
of this pass. Bilge's own product page serves a photo with an **EMPERO** logo stamped on the
front apron. Empero is a separate Turkish commercial-kitchen manufacturer. Cafemarkt sells the
identical unit as **"Empero El Yıkama Evyesi, Dizden Kumandalı, 40x40x22 cm"**, and Bilge's
copy is Empero's copy line for line:

| | Bilge page | Empero listing |
|---|---|---|
| Flow | "15 saniye boyunca su akıtma özelliği." | "15 saniye boyunca su akıtma özelliği." |
| Mounting | "Duvara monte edilebilir." | "Duvara monte edilebilir." |
| Body | "Paslanmaz çelik gövde." | "Paslanmaz çelik gövde." |
| Dimensions | 40x40x22 cm | 400x400x220 mm |

<https://www.bilgemutfak.com/mutfak-urunleri/bulasikhane-ekipmanlari/yikama-aksesuarlari/dizden-kumandali-evye>
<https://www.cafemarkt.com/empero-el-yikama-evyesi-dizden-kumandali-40x40x22-cm>

Bilge lists this basin under its own code 6005202 but neither manufactures nor photographs it.
Our record's `brand: BILGE` is a distributor attribution. Worth a decision.

**2. "Hot and cold water connection" looks wrong.** The record's description and spec table
both claim hot and cold supply. **Neither source says so.** Bilge's own bullet list is only
the three lines above. Empero's listing adds only weight (6 kg) and pack volume (0.04 m³).
And Bilgeinox's own hand-wash table lists code **6005202 as "MOON Tek Giriş / Single Inlet"**,
with a *separate* part number (6005186) for the double-inlet version of the same shell. The
800 px photo shows **one** swan-neck spout. Cafemarkt does flag hot/cold when a basin has it
(e.g. its "Öztiryakiler Oval Tip Mekanizmalı El Yıkama Evyesi, **Sıcak/Soğuk**") and does not
flag it here. <https://www.bilgeinox.com.tr/tr/kategori/bulasikhane>

**3. Code 6005202 carries two different heights inside Bilge's own group.** bilgemutfak.com's
model table gives 6005202 = "Dizden Kumandalı El Yıkama Evyesi 40x40" at **40x40x22 cm**;
bilgeinox.com.tr's table gives 6005202 = "MOON Tek Giriş" at **400x400x260**. Our record uses
220. The 220 figure has two independent sources (Bilge's sales site and Empero) against
Bilgeinox's one, so 220 is probably right - but the group contradicts itself.

**4. Actuation confirmed: side knee pad, not a front push panel.** Checked deliberately. The
800 px photo resolves it: a small dark pad projecting from the **right-hand side panel**, with
a plain flat front apron. Our copy says "a knee press against the operating pedal" - not
wrong, but "pedal" reads as foot-operated. Note also that Bilgeinox's genuinely **foot**-
operated family ("Ayaktan Kumandalı", codes 6005203 / 6005192 / 6005214 / 6005215) is an
entirely different floor-standing 500x450x850 unit; do not conflate the two.

**5. The 50x40 sister variant is 50x45 at Empero.** Our description says "a 500x400x220mm
50x40 variant also exists", taken from Bilge's table (code 6000279, "50x40x22 Cm."). Cafemarkt
sells the Empero sister as **50x45x22 cm**. One of the two is wrong.

**6. The catalogue PDF uses a third code scheme.** §3 records Bilge's 6005xxx web-shop codes.
The master catalogue PDF instead codes GN 1/1-65 as **`10.10.003.11.065`** (pattern
`10.10.003.<fraction>.<depth>`). Both are Bilge's own. Anyone chasing a Bilge code should
expect either form.

**7. Perforation pattern differs by depth, in Bilge's own photos.** 1/1 x 65 perforated
(00103) is photographed with perforations **in the base only**; 1/1 x 100 (00104) and
1/2 x 100 (00105) have **base and side** perforation. No catalogue copy claims either, so
nothing is wrong - but a buyer choosing the 65 mm specifically for draining may care.

**8. Bain Marie Sauce Bin - new negative evidence, still nothing.** Three fresh sources were
checked and none has it:

- Bilgeinox's own **"Benmari Küvetleri / Bain-Marie Units"** table lists only 250x350,
  300x450 and 480x480 footprints (codes 6004003, 6004005, 6004012, 6004006, 6004011, 6004013,
  6004008, plus lid 6004010). **No 240x210, and nothing close to it.**
  <https://www.bilgeinox.com.tr/tr/kategori/paslanmaz-mutfak-aksesuarlari>
- The 87-page master catalogue contains **no 240x210 dimension string anywhere** in its text
  layer.
- The 296-product Bilge-Inox catalogue on galleyz.com has no sauce-bin entry, and
  bilgemutfak's own `sosluk-reçellik-baharatlık` and `bar-konteyner` pages carry only melamine
  and polycarbonate items.
- The Azerbaijani distributor listing is still Cloudflare-gated (403 to WebFetch as well as
  curl): <https://rs-horeca.az/Bilge-inox-bain-marie-sauce-bin-en>

The §7 conclusion stands: this SKU needs the supplier, not the web. It remains `status:
archived` with `price: 0`, which is the right place for it.

### Note on the lid grouping

The lids are no longer six standalone records - `products.json` now carries them as one
variable product `GROUP/GN-LIDS-BILGE` with six variants (IMG/TCW/00125-00130), each keeping
its own `image` path. Images were therefore staged per **variant SKU**, so they map straight
onto the variant `image` fields, and 00125's file doubles as the parent image.

### Sourcing notes for the next pass

- `bilgemutfak.com` serves images fine from the bare apex, but **product pages need `www.`**
  and the extra family path segment (§2). Both traps still live.
- The Bilgeinox category pages embed a **full PHP `print_r` dump** of the product tables in
  the HTML - product codes, descriptions, external dimensions, carton dimensions and pack
  quantities for every family. That dump is the single richest Bilge spec source found, and it
  is plain text in the page. Example:
  <https://www.bilgeinox.com.tr/tr/kategori/paslanmaz-mutfak-aksesuarlari>
- `teknikmutfak.com` has a broken TLS chain (self-signed / untrusted root) - `curl -k` gets a
  503 and WebFetch refuses it. It is a Bilge-keyed reseller and may be worth a browser visit.
- galleyz.com, cafemarkt.com, cafeendustriyel.com, ankarabilluriye.com.tr and mutfakmaster.com
  all carry Bilge Inox lines. cafemarkt image URLs take `-B` / `-O` / `-K` suffixes for
  large / medium / small; `-B` is 800 px and the unsuffixed form 404s.
