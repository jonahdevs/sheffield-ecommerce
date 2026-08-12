# BILGE — SAP-led research pass (2026-07-31)

Redo of the BILGE pass under the current standard: SAP is the spec of record, every image was
opened and looked at before being trusted, and everything is staged in
`Desktop\ecommerce\products resorce final\bilge\`. **Nothing in the repo was modified.**

Scope: **29 dossier SKUs** — 26 EN 631 Gastronorm items (20 containers, 6 lids), one
knee-operated hand wash basin, one bain-marie sauce bin, plus the variable parent
`GROUP/GN-LIDS-BILGE` (no code of its own; it is the six lids 00125-00130).

The previous write-up is the archived research below. Where
this pass contradicts it, this file wins — see §8.

---

## 1. Sources actually used

| Source | What it is | What it gave |
|---|---|---|
| https://www.bilgemutfak.com | Bilge's own sales site | Per-depth captioned product photos + a spec table per series (code, internal dim, external dim, capacity) |
| https://www.bilgeinox.com.tr/tr/kategori/paslanmaz-mutfak-aksesuarlari | Manufacturing arm, category page | The richest single Bilge spec source: a PHP `print_r` dump of the full product table — code, description, **external dim, carton dim, pack quantity** — in plain text in the HTML |
| https://www.bilgeinox.com.tr/tr/kategori/bulasikhane | Same, dishwashing | The hand-wash basin row (code 6005202) |
| https://www.emutfak.com.tr | Turkish reseller, OpenCart | **Best reseller source.** Carries all 26 GN SKUs with the exact 6005xxx code, its own photography, per-SKU stock codes, a fourth Bilge code scheme, and lid thickness + lid weights |
| https://galleyz.com | Shopify store, `vendor: "Bilge Inox"` | 800x800 stock photos, one per GN fraction; `/products.json` exposes 296 Bilge items with En/Boy/Derinlik |
| https://www.celikayonline.com | Turkish reseller | Exact-code confirmation for 6005637 / 6005517 / 6005518 / 6005512; its images are Bilge's own files |
| https://www.chefmarket.com.tr/marka/bilgeinox | Turkish reseller | 16 Bilge items with exact codes; images turned out to be the galleyz stock pool re-encoded |
| https://www.cafemarkt.com/empero-el-yikama-evyesi-dizden-kumandali-40x40x22-cm | Turkish reseller | The hand-wash basin as an **Empero** product, at 800 px |
| https://web.archive.org/web/20250320134213id_/https://rs-horeca.az/Bilge-inox-bain-marie-sauce-bin-en | Wayback snapshot of an Azerbaijani distributor | **Broke the bain-marie deadlock** — see §5 |
| https://web.archive.org/web/20241101185449id_/https://rs-horeca.az/lid-for-bain-marie-sauce-bin | Same, the matching lid | Ø240 mm — proves the bin is round |
| https://www.bilgemutfak.com/urunler/bilge_katalog.pdf | 87-page master catalogue, 21.8 MB | Staged as brand reference; contains **no** sauce-bin entry |

Full manufacturer series pages used for the spec tables:

- https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-1-serisi
- https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-2-serisi
- https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-3-serisi
- https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-4-serisi
- https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-6-serisi
- https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/standart-gastronom-kuvet/standart-gastronom-kuvet-gn-1-9-serisi
- https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/delikli-gastronom-kuvet/delikli-gastronom-kuvet-gn-1-1-serisi
- https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/delikli-gastronom-kuvet/delikli-gastronom-kuvet-gn-1-2-serisi
- https://www.bilgemutfak.com/mutfak-urunleri/gastronom-kuvetler/gastronom-kapak/standart-gastronom-kapak
- https://www.bilgemutfak.com/mutfak-urunleri/bulasikhane-ekipmanlari/yikama-aksesuarlari/dizden-kumandali-evye
- https://www.bilgemutfak.com/mutfak-urunleri/tasima-ekipmanlari/tasima-kaplari/yemek-tasima-kabi

The full site map is at https://www.bilgemutfak.com/urun-haritasi (634 product pages) — use it,
the two URL traps from the old pass are still live (`www.` required, and an extra
product-family path segment).

---

## 2. The disagreements with SAP

### 2a. IMG/TCW/00105 — SAP's plan dimensions are the wrong pan

**SAP says 530 x 325 x 100 for `GN CONTAINER PERFORATED 1/2 100 BILGE`.** That is the GN **1/1**
footprint. A GN 1/2 is 325 x 265.

Three independent confirmations that it is 325 x 265 x 100:

- Bilge's own delikli 1/2 series table: `6005580 | Delikli Gastronom Küvet GN 1/2-100 | int 300x240xh:100 | ext 325x265xh:100`
- Bilgeinox's category dump: `["6005580","1/2-100 P","325x265x100","540X360X240","–","15"]`
- Both photos I opened (Bilge's own and emutfak's) show an unmistakably **half-size** pan.

`products.json` already has 325/265/100 and is right. **SAP is wrong here** — the classic
"copied the row above" failure. Do not let a bulk SAP-dimension apply overwrite this SKU.

### 2b. SAP has no plan dimensions at all for 16 SKUs

SAP carries `length=0, width=0` (depth only) for 00107, 00108, 00110, 00111, 00113, 00114,
00115, 00116, 00117, 00119, 00120, 00121, 00122, and `0/0/0` for lids 00126-00130. Only the
five GN 1/1 rows and 00105 (wrongly) got plan figures. `products.json` has the correct EN 631
values for every one of them — **verified against Bilge's own tables and against the GN size
chart Bilge's reseller publishes** (staged as `_brand-reference/gn-size-chart-emutfak.webp`):

| Fraction | Ext. (mm) | Internal (mm) — Bilge |
|---|---|---|
| 1/1 | 530 x 325 | 505 x 300 |
| 1/2 | 325 x 265 | 300 x 240 |
| 1/3 | 325 x 176 | 300 x 151 |
| 1/4 | 265 x 162 | 240 x 137 |
| 1/6 | 176 x 162 | 151 x 137 |
| 1/9 | 176 x 108 | 151 x 83 |

**The `width` field is NOT holding the depth on this brand.** The catalogue-wide axis-swap does
not apply to BILGE: every `length`/`width` pair in `products.json` is (long side, short side)
and matches EN 631. This one is clean.

### 2c. IMG/HYS/00001 — SAP height is 0, and Bilge contradicts itself on the real value

SAP: `400 / 400 / 0`. `products.json`: `400 / 400 / 220`.

- bilgemutfak.com model table: 6005202 = "Dizden Kumandalı El Yıkama Evyesi 40x40" at **40x40x22 cm**
- cafemarkt (as Empero): **400 x 400 x 220 mm**
- bilgeinox.com.tr dump: `["6005202","MOON Tek Giriş / Single Inlet MOON","400x400x260","410X420X280","–","1"]` → **260**

Two sources say 220, one says 260. The carton is 410 x 420 x **280**, which fits a 260 mm unit
comfortably and a 220 mm unit with a lot of air. **Unresolved**, but 220 is the safer figure and
is what the record already holds. Flagging rather than changing.

### 2d. IMG/HOT/00112 — SAP's `240 x 210` describes a rectangle. The product is round.

See §5. Both SAP's `240/210/0` and the `model_number` `240*120` are contradicted.

### 2e. Everything else agrees

For the other 24 GN SKUs, SAP's depth, `products.json`'s plan dimensions, Bilge's own series
tables and Bilgeinox's dump all agree. SAP's `Model` field matches `model_number` on all 29 —
the dossier flagged zero model conflicts and I found none.

---

## 3. Bilge's four parallel code schemes

Anyone chasing a Bilge part number will meet all four. None of them is our `model_number`.

| Scheme | Example (GN 1/9 lid) | Where |
|---|---|---|
| `6005xxx` web-shop code | `6005607` | bilgemutfak.com, bilgeinox.com.tr, and every reseller that bothers |
| `6GN000xx` | `6GN00151` | emutfak.com.tr product prose |
| `10.10.003.<fraction>.<depth>` | `10.10.003.11.065` (1/1-65) | the master catalogue PDF |
| Reseller stock codes | `GNCK19MS` (emutfak), `BILGE101` (celikay) | reseller-internal, worthless outside |

Our `model_number` (`"1/1*65 -P"`, `"1/2 - C"`, `BLGNL1/9`) is Sheffield's own distributor
shorthand. **It is the unique ID — leave it alone.** The 6005xxx codes below are the real
manufacturer article numbers and belong in a spec field, not in `model_number`.

| SKU | Bilge code | Model | Ext. dim | Capacity | Carton (mm) | Pack |
|---|---|---|---|---|---|---|
| IMG/TCW/00103 | 6005649 | 1/1-65 P | 530x325x65 | not published | 540x360x240 | 20 |
| IMG/TCW/00104 | 6005576 | 1/1-100 P | 530x325x100 | not published | 540x360x360 | 15 |
| IMG/TCW/00105 | 6005580 | 1/2-100 P | 325x265x100 | not published | 540x360x240 | 15 |
| IMG/TCW/00106 | 6005637 | 1/1-65 | 530x325x65 | 9 L | 540x360x240 | 20 |
| IMG/TCW/00107 | 6005517 | 1/2-65 | 325x265x65 | 4 L | 540x360x180 | 20 |
| IMG/TCW/00108 | 6005523 | 1/3-65 | 325x176x65 | 2.5 L | 540x360x180 | 20 |
| IMG/TCW/00110 | 6005658 | 1/6-65 | 176x162x65 | 1 L | 540x360x120 | 25 |
| IMG/TCW/00111 | 6005534 | 1/9-65 | 176x108x65 | 0.6 L | 540x360x120 | 25 |
| IMG/TCW/00112 | 6005657 | 1/1-100 | 530x325x100 | 14 L | 540x360x355 | 15 |
| IMG/TCW/00113 | 6005518 | 1/2-100 | 325x265x100 | 6.5 L | 540x360x240 | 15 |
| IMG/TCW/00114 | 6005524 | 1/3-100 | 325x176x100 | 4 L | 540x360x290 | 25 |
| IMG/TCW/00115 | 6005529 | 1/4-100 | 265x162x100 | 2.8 L | 540x360x240 | 25 |
| IMG/TCW/00116 | 6005532 | 1/6-100 | 176x162x100 | 1.6 L | 540x360x180 | 25 |
| IMG/TCW/00117 | 6005641 | 1/9-100 | 176x108x100 | 1 L | 540x360x120 | — |
| IMG/TCW/00118 | 6005638 | 1/1-150 | 530x325x150 | 21 L | 540x360x420 | 15 |
| IMG/TCW/00119 | 6005519 | 1/2-150 | 325x265x150 | 9.5 L | 540x360x420 | 20 |
| IMG/TCW/00120 | 6005525 | 1/3-150 | 325x176x150 | 5.7 L | 540x360x420 | 20 |
| IMG/TCW/00121 | 6005530 | 1/4-150 | 265x162x150 | 4 L | 540x360x320 | 20 |
| IMG/TCW/00122 | 6005533 | 1/6-150 | 176x162x150 | 2.4 L | 540x360x180 | 25 |
| IMG/TCW/00124 | 6005512 | 1/1-200 | 530x325x200 | 28 L | 540x360x420 | 9 |
| IMG/TCW/00125 | 6005669 | 1/1 L | 530x325x10 | — | 540x360x420 | 20 |
| IMG/TCW/00126 | 6005604 | 1/2 L | 325x265x10 | — | 540x360x240 | 20 |
| IMG/TCW/00127 | 6005605 | 1/3 L | 325x176x10 | — | 540x360x180 | 20 |
| IMG/TCW/00128 | 6005651 | 1/4 L | 265x162x10 | — | 540x360x180 | 20 |
| IMG/TCW/00129 | 6005606 | 1/6 L | 176x162x10 | — | 540x360x120 | 20 |
| IMG/TCW/00130 | 6005607 | 1/9 L | 176x108x10 | — | 540x360x120 | 20 |
| IMG/HYS/00001 | 6005202 | MOON Tek Giriş | 400x400x220 (260?) | — | 410x420x280 | 1 |

New this pass, from emutfak: **lid thickness is 10 mm**, and lid unit weights are
1/1 0.95 kg · 1/2 0.59 · 1/3 0.50 · 1/4 0.22 · 1/6 0.20 · 1/9 0.15 kg. Every `weight` in SAP is
`0.0`, so these are the only per-SKU weights anyone has.

Confirmed again: **Bilge publishes no litre figure for the perforated range**, so the 9.0 /
14.0 / 6.5 L on 00103 / 00104 / 00105 are still inferred from the solid pan of the same
footprint, not manufacturer data.

---

## 4. What was checked in the images, and the image defects found

**78 files staged for 28 of the 29 SKUs** (the 29th is the variable parent, covered by its
00125 child) plus 9 brand-reference files. Every file below was opened with the image reader.

### 4a. Bilge's own captioned photography — the strongest evidence, and it is small

`bilgemutfak.com/urunler/gastronom-kuvetler/*.jpg`, all **420 x 512**, one per depth, staged as
`<SKU>__<code>-bilgemutfak-1.jpg`. The 17 solid-container shots carry their own printed caption
and dimension arrows — e.g. `IMG-TCW-00106` reads "GN 1/1 65 / Derinliği 6,5 cm" with 32,5 /
53 / 6,5 cm drawn on it. I opened all 17 and **every caption matches SAP and `products.json`
exactly**. That is what makes these exact-model rather than merely plausible.

420 x 512 remains the ceiling for Bilge's own photography — the series pages carry exactly one
`<img class="item">` per depth with no srcset and no `_large` sibling.

### 4b. celikayonline.com serves Bilge's own file, and then upscales it

`celikayonline.com/image/catalog/BILGE101.jpg` is **byte-identical** (md5 `0ef34c57c6…`,
73 091 bytes) to `bilgemutfak.com/urunler/gastronom-kuvetler/gn-11-065.jpg`. Its OpenCart cache
then offers `BILGE101-1500x1500w.jpg` and `-3000x3000w.jpg` — **pure upscales of a 420 x 512
original**. Do not mistake those for high-resolution sources. Celikay is still useful as
exact-code corroboration (the 6005xxx number is in the product URL), just not for pixels.

### 4c. chefmarket.com.tr and galleyz.com share one stock-photo pool — they do not corroborate each other

I staged both, then compared. All six overlapping images are the same photograph with different
JPEG re-encoding (mean per-pixel difference 0.21-0.32 on a 0-255 scale, max 8-19). **The
chefmarket copies were deleted as redundant.** Two resellers agreeing on a photo is not two
independent sightings when they are reselling the same supplier feed.

### 4d. The galleyz lid photos are a single GN 1/2 lid sold as six sizes — five deleted

galleyz's lid images are flat-on, so the outline aspect ratio is directly measurable. All six
measure **1.23**, which is the GN 1/2 ratio (325/265). Expected ratios are 1/1 1.63, 1/2 1.23,
1/3 1.85, 1/4 1.64, 1/6 1.09, 1/9 1.63. Four of the six files are byte-identical
(md5 `e56f283453…`) and the other two are crops of the same shot.

**Deleted:** the galleyz representatives for 00125, 00127, 00128, 00129, 00130. Kept 00126,
where the photo genuinely is a 1/2 lid.

This is the concrete instance of the general rule — HTTP 200 and a correct-looking product
family are not verification. Nothing about these files looks wrong until you measure them.

### 4e. emutfak.com.tr — the only source whose lid photos track the actual size

1000 x 1000, distinct per SKU, staged as `<SKU>__<code>-emutfak-N.webp`. Opened all of them.
The lid shots are angled so ratios cannot be measured, but visually the 1/6 lid is near-square,
1/3 and 1/9 are clearly elongated, 1/1 is long and thin — consistent with 1.09 / 1.85 / 1.63 /
1.63. This is the first source found where lid size is visible in the photograph rather than
asserted by the URL.

Two shared assets were pulled out of the per-SKU set and filed under `_brand-reference/`:

- `gn-size-chart-emutfak.webp` — the GN dimension diagram emutfak attaches to 13 container
  listings. It independently confirms 650x530 / 530x325 / 354x325 / 325x265 / 325x176 /
  265x162 / 176x162 / 176x108.
- `generic-gn-lid-stock-photo-emutfak.webp` — a generic lid photo emutfak reuses across all
  six lid listings. Its handle is an oval recessed pull, **not** Bilge's bar-in-a-dish, so it
  is not a Bilge product at all. Removed from the per-SKU set.

### 4f. Perforation pattern differs by depth — confirmed twice

On 00103 (1/1 x 65) the perforation is **in the base only**; on 00104 (1/1 x 100) and 00105
(1/2 x 100) it is **base and sides**. Visible in Bilge's own shots *and* independently in
emutfak's, which are different photographs. No catalogue copy claims either way, so nothing is
wrong — but a buyer picking the 65 mm specifically to drain will care.

### 4g. Lid design, re-confirmed

Flat, solid, small circular recessed pull-dish with a short bar across it. **No spoon notch, no
steam vent, no gasket.** Bilge's `sızdırmaz contalı` (gasketed, 6005612-6005625 family) and
`kepçe delikli` (ladle-notch) lids are separate product lines with their own codes; ours are the
plain `standart` lid.

---

## 5. IMG/HOT/00112 Bain Marie Sauce Bin — solved on shape and size, still no photograph

The old pass gave up on this one. The Wayback Machine has the Cloudflare-gated Azerbaijani
distributor page, and it carries a full spec table.

https://web.archive.org/web/20250320134213id_/https://rs-horeca.az/Bilge-inox-bain-marie-sauce-bin-en

> Bilge İnox Bain Marie Sauce Bin · Product Code 6BS00003/24X21
> dimensions **Ø240 x 280 mm** · Material **Stainless Steel** · Capacity **12,6 l**

And the matching lid, sold separately, is **Ø240 mm**:

https://web.archive.org/web/20241101185449id_/https://rs-horeca.az/lid-for-bain-marie-sauce-bin

**The product is a round pot, not a rectangular tray.** Four things line up:

1. The stated Ø240 x 280 gives π·0.12²·0.28 = **12.67 L**, against the published 12.6 L. The
   geometry and the capacity check each other.
2. The lid is circular, Ø240.
3. Bilge's own catalogue contains exactly one 240 x 280 item — Bilgeinox code **6005104**,
   "Yemek Taşıma / Carrying Container 240×280". The same family's Ø300 x 280 is published at
   20 L, and π·0.15²·0.28 = 19.8 L, so the family's Ø x H convention is confirmed.
4. **The image already in `products.json` for this SKU is a round lidded bain-marie pot.** It
   agrees with the distributor and disagrees with the record's own `240 x 210` field.

So: `length 240 / width 210` is not a length and a width. `240` is a **diameter**; `210` is
unsourced and appears nowhere outside SAP's description string. The `model_number` `240*120`
is a third number and matches nothing. Ø240 x 280 mm, 12.6 L is the defensible reading.

Caveats, stated plainly: `6005104` is Bilge's code for a *carrying container*, and the
distributor's own code fragment `24X21` disagrees with its own spec table's `280`. I have not
found a page that says "6005104" and "bain marie sauce bin" in the same breath. Treat the
identification as strong, not proven.

**No photograph could be obtained.** rs-horeca.az returns Cloudflare 403 to every automated
method including its image paths (403 with `text/html`, not a JPEG), no browser was available
this session, the images.weserv.nl proxy is refused the same way, and the Wayback Machine
archived the page but none of its images (checked the full `rs-horeca.az` image CDX — 305
archived JPEGs, none matching). Staged instead as
`IMG-HOT-00112__6005104-CANDIDATE-bilgemutfak-family-1.jpg`: Bilge's own photo of the
carrying-container family, **explicitly a candidate, explicitly not proof**. It shows a clamped
lid with side handles, which the plain sauce-bin probably does not have.

---

## 6. IMG/HYS/00001 is an Empero product — re-confirmed independently

I opened the photo Bilge serves on its own product page
(`bilgemutfak.com/urunler/bulasikhane-ekipmanlari/dizden-kumandali-evye.jpg`) and there is an
**EMPERO** badge on the front apron. Empero is a different Turkish manufacturer. Cafemarkt sells
the identical unit as "Empero El Yıkama Evyesi, Dizden Kumandalı, 40x40x22 cm", and Bilge's
bullet copy is Empero's copy verbatim ("15 saniye boyunca su akıtma özelliği", "Duvara monte
edilebilir", "Paslanmaz çelik gövde"). Our `brand: BILGE` is a distributor attribution, not a
manufacturer fact. Worth a business decision.

At 800 px the unit resolves clearly and two catalogue claims are contradicted:

- **"Hot and cold water connection" is wrong.** There is **one** swan-neck spout. Bilgeinox's
  own table lists 6005202 as "MOON Tek Giriş / **Single Inlet**", with a separate part number
  (6005186) for the double-inlet version of the same shell. Neither Bilge nor Empero mentions
  hot/cold anywhere.
- **The actuator is a small knee pad on the right-hand side panel, not a front push panel.**
  Our copy says "a knee press against the operating pedal", which reads as foot-operated.
  Bilge's genuinely foot-operated line ("Ayaktan Kumandalı", 6005203 / 6005192 / 6005214 /
  6005215) is a different floor-standing 500x450x850 unit.

---

## 7. Dead ends — do not spend time on these again

- **rs-horeca.az images.** Cloudflare 403 on HTML *and* on `/image/cache/...` paths, to curl
  with full browser headers, to WebFetch, and through images.weserv.nl. Not in the Wayback
  image archive either. Needs a real browser session.
- **celikayonline.com enumeration.** Category pages ignore `?limit=`, `route=product/search`
  renders results client-side, and `route=extension/feed/google_sitemap` 404s. Nine Bilge
  products are reachable, no more. Not worth another attempt — its images are Bilge's own file
  anyway (§4b).
- **chefmarket.com.tr pagination.** `?sayfa=N` returns the identical 567 KB page for every N.
  The brand page holds 16 products and that is all of them.
- **The master catalogue PDF as a spec source.** 87 pages, but the text layer emits table
  headers and codes as detached streams with no row association — unusable without heavy
  spatial reconstruction. It contains no `240x280`, no `240x210`, and no sauce-bin entry; its
  four "Bain" hits are all *hot bain-marie service units* (15.05.08.x etc.), a different
  product. Staged for reference only.
- **www.bilgemutfak.com/sitemap.xml** 404s. Use `/urun-haritasi` instead.
- **Bilgeinox family images** (`files/productImg/*.jpg`) are 200 x 150. Only the slider shot
  `03_Gastronom-Grubu_DeMain_0001.jpg` is worth having (1726 x 1207, staged).
- **teknikmutfak.com** now resolves (the old TLS failure is gone) but renders products in JS —
  the raw HTML has no product images.

---

## 8. Corrections to the archived research file

The archived research below is wrong or stale on four points:

1. **"IMG/TCW/00105 … not listed"** — the delikli GN 1/2 series *is* published, and 00105 is
   code **6005580** at 325x265x100. It was found on the manufacturer's own 1/2 perforated page
   and in Bilgeinox's dump.
2. **"IMG/TCW/00125's stored image shows a line-up of four different-sized lids"** — no longer
   true. The image currently in `storage/app/public/products/gn-lids-11-bilge-imgtcw00125.jpg`
   is a single lid. That flag can be retired.
3. **"the apparent aspect ratio of the lid outline does not track the stated GN size"** — that
   conclusion came from measuring Bilge's angled shots, where perspective swamps the shape. On
   emutfak's set the size *is* visually distinguishable (§4e), and on galleyz's flat-on set the
   ratio is measurable and reveals a real defect (§4d). The measurement was the problem, not the
   photographs.
4. **"IMG/HOT/00112 … resolved to 240x210 by analogy"** — superseded. It is round: Ø240 x 280,
   12.6 L (§5).

---

## 9. Still open

- **A photograph of the bain marie sauce bin.** Needs a browser against rs-horeca.az, or the
  supplier.
- **Whether IMG/HOT/00112 is Bilge 6005104.** Strong circumstantial case, no page states it.
- **Hand wash basin height: 220 or 260 mm.** Bilge's group contradicts itself.
- **Whether IMG/HYS/00001 should stay branded BILGE** when Bilge neither makes nor photographs
  it. Business decision.
- **No per-model spec sheet PDF exists for any BILGE SKU.** Bilge publishes one master
  catalogue and puts specs in HTML tables on the series pages. Zero `-spec.pdf` files could
  honestly be produced; the closest equivalents staged are the master catalogue and the
  Bilgeinox table dumps.
- **Above-800 px exact-model imagery for the GN range** still does not exist. The captioned
  420 x 512 shots are the only photographs that prove *which* pan it is; everything larger is
  reseller stock reused across depths.

---

## 10. Staged files

`Desktop\ecommerce\products resorce final\bilge\` — 78 per-SKU files + 9 brand-reference.

| Suffix | Source | Count | Grade |
|---|---|---|---|
| `-bilgemutfak-1.jpg` | Bilge's own, 420 x 512 | 27 | Exact model. 17 carry a printed caption with their own size and depth; the 3 perforated, 6 lids and the basin rest on URL/page mapping |
| `-emutfak-N.webp` | emutfak.com.tr, 1000 x 1000 | 27 | Exact code in the listing, independent photography; depth is not reliably visible |
| `-galleyz-1.jpg` | galleyz.com, 800 x 800 | 21 | Representative — one photo per GN fraction, reused across depths |
| `-EMPERO-cafemarkt-N.jpg` | cafemarkt.com, 800/400 | 2 | Exact model, competitor-branded (§6) |
| `-CANDIDATE-...family-1.jpg` | bilgemutfak.com | 1 | Candidate only (§5) |

`_brand-reference/`: master catalogue PDF (87 pp, 21.8 MB), Bilgeinox range line-up
(1726 x 1207), four Bilgeinox family thumbnails (200 x 150), the Bilge logo, the GN size chart,
and the generic lid stock photo pulled out of the per-SKU set.

Deleted during the pass: 6 chefmarket duplicates (§4c), 5 galleyz lid images that showed the
wrong GN size (§4d), 17 shared emutfak assets folded into `_brand-reference/` (§4e).

---

# 11. Spec-sheet sweep (2026-07-31, second pass)

The image pass above was complete; the spec-sheet phase had never run. It has now.
**29 / 29 SKUs carry a spec document.** Full detail is in
`Desktop\ecommerce\products resorce final\bilge\_FINDINGS-specs.md`, the per-SKU ledger is
`_specs-sourced.json` in the same folder. Nothing in the repo was modified.

## 11.1 §9 is superseded: a second manufacturer catalogue exists

§9 recorded *"No per-model spec sheet PDF exists for any BILGE SKU … Zero `-spec.pdf` files
could honestly be produced."* The first half stands. The second does not — a **second**
manufacturer catalogue was found, and it is materially better than the Bilge Mutfak one:

https://www.bilgeinox.com.tr/files/Fiyatsiz%20Katalog.pdf

*Bilgeinox Ürün Kataloğu / Product Catalogue*, 61 pp, 5.99 MB, linked only from
https://www.bilgeinox.com.tr/tr/katalog — not from any sitemap (both sites 404 theirs) and
not from the main nav. Staged as `_brand-reference/bilgeinox-product-catalogue.pdf`.

It is keyed on the **6005xxx article numbers** (the scheme §3 identified and the one our
staged image filenames already use), its tables render cleanly, and **all 28 of our codes
appear in it**, including `6005202` and `6005104`, which the Bilge Mutfak catalogue does not
carry at all.

| Bilgeinox p. | Table | SKUs |
|---|---|---|
| 25 | GN Containers - Standard | 17 |
| 27 | GN Containers - Perforated | 3 |
| 28 | Standard GN Lids | 6 + the variable parent |
| 30 | Carrying Containers | IMG/HOT/00112 |
| 54 | Handwash Basins | IMG/HYS/00001 |

Every per-SKU file is a 2-page PDF: Bilgeinox page (code, model, external dim, litres, box
qty) + the matching Bilge Mutfak spread (the `10.10.00x` code and the *internal* dims). The
basin and the sauce bin are single-page — Bilge Mutfak has no entry for either.

Tier achieved: **manufacturer catalogue page**, all 29, with the code proven inside the
document in every case. Bilge publishes no per-model datasheet; that ceiling is real
(`/katalog`, `/kataloglar`, `/dokumanlar`, `/urunler/`, `robots.txt` on bilgemutfak.com and
both `sitemap.xml`/`robots.txt` on bilgeinox.com.tr are all 404, and the two live
`bilgeinox.com.tr/tr/katalog` + `/tr/dokumanlar` pages link exactly four PDFs: this catalogue
and three GDPR/corporate documents).

## 11.2 §3 correction — the perforated range DOES publish litres

§3 said, twice, that "Bilge publishes no litre figure for the perforated range", so the
9.0 / 14.0 / 6.5 L on 00103 / 00104 / 00105 were inferred from the solid pan of the same
footprint. **Bilgeinox p27 prints a LİTRE column for the whole perforated table**, and the
values are exactly 9.00 / 14.00 / 6.50. The inference was right and is now sourced.

## 11.3 §2a strengthened — IMG/TCW/00105

Bilgeinox p27: `6005580 · 1/2-100 P · 32,5x26,5x10`. Fourth independent confirmation that
SAP's `530 / 325 / 100` is the wrong footprint. `products.json` (325/265/100) is correct.

## 11.4 §2c refined — the 220 vs 260 mm basin split

The printed Bilgeinox catalogue (p54) lists `6005202 · MOON · Tek Giriş / Single Inlet ·
40x40x26`. So the tally is now:

- **260 mm** — Bilgeinox printed catalogue + Bilgeinox HTML category dump (*one lineage*)
- **220 mm** — bilgemutfak.com's own model table, `products.json`, and the entire Empero
  reseller chain

New this pass: the Empero part number is **EMP.DKE.002**, and the reseller spec table
transcribes as *400 x 400 x 220 mm, 6 kg, 0.04 m³*. The **6 kg** is the only weight anyone
publishes for this SKU (SAP holds 0.0). Sources:

- https://www.cafemarkt.com/empero-el-yikama-evyesi-dizden-kumandali-40x40x22-cm
- https://www.kolgu.com.tr/urun/empero-emp-dke-002-el-yikama-evyesi-dizden-kumandali-40x40x22-cm
- https://www.mutbex.com/empero-knee-controlled-hand-wash-sink-40x40x22-cm
- https://www.joyhoreca.com.tr/dizden-kumandali-el-yikama-evyesi-400x400x220-mm

**Still unresolved**, and a possibility worth putting on the record: Bilgeinox's
`MOON 40x40x26` may be Bilge's own basin and simply not the Empero unit our photographs
show — in which case 6005202 is a cross-reference and the 26 cm does not describe our goods.
Empero itself publishes no datasheet reachable by any method tried (its site is JS-rendered,
its `sitemap.xml` is stale on the dead `urun*.php?lang=` scheme, `/tr/katalog` links no PDF,
and four Empero resellers carry a spec table but not one PDF between them).

The page also re-confirms **Tek Giriş / Single Inlet, no soap dispenser** for 6005202, against
our "hot and cold water connection" copy — §6's finding, from a printed manufacturer document
this time. The double-inlet MOON is a different code, 6005186.

## 11.5 §5 — the sauce bin gets a manufacturer document, and the same caveat

Bilgeinox p30 lists `6005104 · 24x28` under **YEMEK TAŞIMA KAPLARI / CARRYING CONTAINERS WITH
5/5 HANDLE**, AISI 304. The series (24x28, 30x32, 36x36, 40x40, 50x50) is diameter x height,
so 6005104 = **Ø240 x 280 mm** — matching the rs-horeca.az spec (Ø240 x 280, 12.6 L) exactly
and contradicting both SAP's `240 x 210` and the `model_number` `240*120`.

The caveat is unchanged and should not be allowed to erode: no page anywhere states
"6005104" and "bain marie sauce bin" together, and this catalogue has **no sauce-bin product
at all** — its only `Sos B.M. / Sauce B.M.` rows (pp46-48) are 40x57 cm cooker-top bain-marie
modules. Strong, not proven.

## 11.6 Smaller notes

- **The Bilgeinox catalogue is fallible too.** On p27, codes `6005595` and `6005596` are each
  printed twice — as `2/1-20 P` / `2/1-65 P` on the left and as `1/6-150 P` / `1/6-200 P` on
  the right. None of our SKUs is affected, but do not treat this document as an oracle either.
- **No image upgrade.** Every embedded object on the five pages used was extracted and
  measured (PyMuPDF `extract_image`); the largest is 357 x 243. The 420 x 512 Bilge Mutfak
  photography is still the exact-model ceiling for this brand. Nothing was re-staged.
- **Lid thickness remains unpublished by the manufacturer** — neither catalogue prints it, so
  the 10 mm in §3 is still emutfak's figure alone.
- The two catalogues use non-overlapping code schemes for identical goods (`6005xxx` vs
  `10.10.00x.xx.xxx`), which is why both pages are bound into each per-SKU spec file.

---

## Archived brand research

> Merged in from the former `research/old/` folder on 2026-08-12, when the two folders were
> consolidated. This is the earlier **specs and codes** pass; everything above it
> is the later **sourcing and provenance** pass. The text is unchanged apart from
> heading levels, which were demoted one step to keep a single outline.

## Bilge Product Research

Research notes behind the BILGE enrichment/audit pass on `products.json` (July 2026). Covers
all 28 BILGE-branded SKUs: 26 EN 631 Gastronorm containers and lids, one buffet sauce bin,
and one knee-operated hand wash basin. Every page and image URL below was verified live.

---

### 1. Brand identification

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

### 2. Where to look - and the two URL traps

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

### 3. Product reference

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

### 4. Image sourcing

**Bilge's own product photography covers every SKU except the Bain Marie sauce bin** - no
generic EN 631 fallback was needed anywhere. Images were verified live (HTTP 200, real JPEG,
50–82 KB, all distinct files) but **deliberately not downloaded or wired into
`products.json`** - they are listed here for manual review first.

Filename pattern: `bilgemutfak.com/urunler/gastronom-kuvetler/gn-<fraction><depth>.jpg`,
prefixed `delikli-` for perforated, suffixed `-kapak` for lids.

#### Missing from the catalogue (14 SKUs)

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

#### Already in the catalogue - Bilge equivalent, for comparison (12 SKUs)

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

### 5. Full Bilge series tables

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

### 6. Data audit - errors found and corrected

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

### 7. Bain Marie Sauce Bin (IMG/HOT/00112) - unresolved, needs the supplier

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

### 8. Range gaps

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

### 9. Summary of `products.json` changes this pass

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

### Image sourcing (July 2026)

The first image pass on BILGE. Staged in
`C:\Users\jonah.wakahiu\Desktop\ecommerce\products resource\bilge-images\`.
**55 files: 27 manufacturer photos, 27 above-floor representative photos, 3 brand-reference
assets (including the catalogue PDF).** Nothing was copied into the project and no `image`
field was touched. Every file below was opened and looked at.

#### The two-source split, and why

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

#### Proof of ceiling for the `-TOOSMALL` files

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

#### Files - Gastronorm containers

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

#### Files - lids

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

#### Files - hand wash basin (IMG/HYS/00001)

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-HYS-00001__knee-basin-EMPERO-BADGED-photo-on-bilge-page-TOOSMALL.jpg` | 420x512 | 30.8 KB | <https://bilgemutfak.com/urunler/bulasikhane-ekipmanlari/dizden-kumandali-evye.jpg> |
| `IMG-HYS-00001__knee-basin-EMPERO-BRANDED-40x40x22-800.jpg` | 800x800 | 31.5 KB | <https://witcdn.cafemarkt.com/empero-el-yikama-evyesi-dizden-kumandali-40x40x22-cm-evyeler-empero-43041-25-B.jpg> |

Both show the same unit. Confirmed visually at 800 px: square deck-mounted stainless basin,
oval bowl, centre waste, **single swan-neck spout**, and the actuator is a **small dark knee
pad projecting from the right-hand side panel - NOT a full-width front knee-push panel**. Both
photos carry an **EMPERO** badge on the front apron. See findings 1-5.

#### Brand reference

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

#### Coverage - stated plainly

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

#### Findings and contradictions - reported, not fixed

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

#### Note on the lid grouping

The lids are no longer six standalone records - `products.json` now carries them as one
variable product `GROUP/GN-LIDS-BILGE` with six variants (IMG/TCW/00125-00130), each keeping
its own `image` path. Images were therefore staged per **variant SKU**, so they map straight
onto the variant `image` fields, and 00125's file doubles as the parent image.

#### Sourcing notes for the next pass

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
