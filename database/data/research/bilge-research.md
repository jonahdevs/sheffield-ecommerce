# BILGE — SAP-led research pass (2026-07-31)

Redo of the BILGE pass under the current standard: SAP is the spec of record, every image was
opened and looked at before being trusted, and everything is staged in
`Desktop\ecommerce\products resorce final\bilge\`. **Nothing in the repo was modified.**

Scope: **29 dossier SKUs** — 26 EN 631 Gastronorm items (20 containers, 6 lids), one
knee-operated hand wash basin, one bain-marie sauce bin, plus the variable parent
`GROUP/GN-LIDS-BILGE` (no code of its own; it is the six lids 00125-00130).

The previous write-up is archived at `database/data/research/old/bilge-research.md`. Where
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

The old `old/bilge-research.md` is wrong or stale on four points:

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
