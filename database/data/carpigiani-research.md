# Carpigiani Product Research

Research notes behind the CARPIGIANI enrichment/audit pass on `products.json` (July 2026).
Covers all 3 CARPIGIANI SKUs: a vertical blender (Turbomix), a Hot & Cold Dynamic batch
freezer (Maestro 2 HCD) and a batch pasteuriser (Pastomaster 60 RTX). Specs were sourced
from Carpigiani's own product pages and official spec sheets mirrored by resellers, and
cross-checked against used-equipment marketplaces.

**This pass corrected scrambled dimensions on two of the three SKUs, tightened all three
model codes, and added the missing specs, spec tables and meta descriptions.** No image
field was changed — image sourcing (§6) is presented as links for manual review first.

---

## 1. Brand identification

**Carpigiani**, founded **1946**, HQ in **Anzola dell'Emilia (Bologna), Italy**. The world's
leading maker of gelato / ice-cream / soft-serve machines (~35% global share). Product scope:
artisan batch freezers, soft-serve machines, pasteurisers, whipped-cream machines,
blenders/homogenisers, display and dispensing equipment, plus parts and accessories.

**Part of Ali Group since 1989** (Ali Holding — the world's #2 professional foodservice
equipment group). Also runs the **Carpigiani Gelato University** (founded 2003, Anzola
dell'Emilia).

**Sibling-brand trap — Coldelite is NOT a Carpigiani sub-brand.** The other main Ali Group
gelato brand is **Iceteam 1927** (a 2010 unification of **Cattabriga, Coldelite, Promag and
Ott Freezer**). Legacy "Carpigiani-Coldelite" parts references exist because the brands were
historically bundled, so parts/model matches can pull in Iceteam 1927 machines that are **not
Carpigiani**. Filter those out.

---

## 2. Where to look — and the traps

| Resource | URL |
|---|---|
| Official site | <https://carpigiani.com> (path prefixes `/en/`, `/us/`, `/uk/`; also carpigiani.co.uk) |
| Official CDN (images) | `dbe.carpigiani.com/sites/default/files/...` |
| Parts store | shop.carpigiani.com |
| Refurbished portal | carpigiani.com/en/page/refurbished |
| Parts / manuals (3rd-party) | partstown.com/b/carpigiani |

Product URL pattern is `carpigiani.com/{lang}/product/{slug}`. **Product pages are usually
automated-fetch friendly** (server-rendered HTML with full copy) — but some `/us/` slugs are
SPA/JS pages that 404 to a fetcher even though the product exists.

**There are no directly linkable spec-sheet PDFs on the official site** — downloads are gated
behind a "Download Catalogue" contact-form modal. Get the official datasheets from resellers
who mirror them (e.g. `webstaurantstore.com/documents/specsheets/*.pdf`, PartsTown). They are
image-heavy PDFs: the artwork lifts cleanly, the text does not extract.

### Traps

1. **"Stelle" = "stars" = the size/capacity tier, not a separate brand.** "2 Stelle",
   "Due Stelle", "2 Star" and the badge "Maestro ✱✱" are all the **same** two-star size class.
   Do not treat them as different products, and do not strip the star token from a model name —
   it is the size. (1 Stella = smaller, 3 Stelle = larger.)
2. **HCD vs HE vs XPL are feature/generation suffixes on the same family**, but they carry
   **different specs** — never merge their datasheets. **HCD-A vs HCD-W = Air- vs Water-cooled**;
   treat as distinct SKUs (different plumbing, sometimes different electrical).
3. **Voltage variants — do not copy US spec sheets.** Kenya is **50 Hz, three-phase**
   (400–415 V). US listings for the "same" machine are **208–230 V / 60 Hz**. Grab the
   EU / 3-phase / 50 Hz column. (The Turbomix is the exception — it is single-phase 230 V,
   which suits Kenyan mains.)
4. **Slug instability.** Official product slugs vary by market and generation and some 404 to
   a fetcher — always resolve via search, never guess the URL.
5. **Discontinued vs current.** Many Stelle/HCD units on used marketplaces are older
   generations; the current official range leans **HE**. Our machines match the still-catalogued
   HCD / RTX generations, but confirm before treating any spec sheet as current.
6. **"Turbomix" is a *vertical blender*, not an "immersion blender".** Searching "immersion
   blender" can miss the official product; search "Turbomix" / "vertical blender".

---

## 3. Product reference

| SKU | Catalogue name (now) | Model (now) | What it is | Official page | Spec source |
|---|---|---|---|---|---|
| IMG/ICE/00026 | Turbomix Vertical Blender | Turbomix | Vertical blender / emulsifier (prep, not a freezer) | [turbomix](https://carpigiani.com/us/product/turbomix) | Official spec sheet PDF (05/2021) |
| IMG/ICE/00027 | Ice Cream Machine Maestro 2 HCD | MAESTRO 2 HCD | Hot & Cold Dynamic batch freezer, 14 L | [maestro-hcd](https://carpigiani.com/us/product/maestro-hcd) | applanat + WebstaurantStore (agree) |
| IMG/ICE/00028 | Pastomaster 60 RTX Batch Pasteuriser | PASTOMASTER 60 RTX | Batch pasteuriser / ageing machine, 60 L | [pastomaster-60-rtx](https://carpigiani.com/us/product/pastomaster-60-rtx) | Official RTX spec sheet PDF (11/2020) |

### Model resolutions

- **Turbomix** (was "TURBO MIX" / "Ice Cream Machine Turbo Mix"): the model is **"Turbomix"**
  (one word). US reseller SKU `439TURMIXAW`. An older "Turbomix 10" exists on the legacy
  `dbe.carpigiani.com` host, but the current catalogue model carries no numeric suffix. It is
  a blender/emulsifier — the old "Ice Cream Machine" name was misleading.
- **Maestro 2 HCD** (was "MAESTRO-2STELLE HCD"): decodes to the **two-star (✱✱) Maestro with
  Hot & Cold Dynamic**, the **14 L** cylinder / **3 HP** beater variant — which matches our
  record's 14 L + 3 HP exactly. "2STELLE" was a legitimate size token, just mangled; kept as
  "2". On US listings the identical machine is "Maestro ✱✱ HCD".
- **Pastomaster 60 RTX** (was "PASTO MASTER"): the **60 L** size of the **RTX** ("classic heat
  treatment") series. Pinned to RTX (not RTL/HE/XPL) by our own description text — the
  "16 programs for base mixtures, syrups and other liquid pastry products", the exchange pump,
  the transparent lid openable during production, and the built-in faucet are all verbatim RTX
  spec-sheet copy.

---

## 4. Data audit — errors found and corrected

### 4.1 Scrambled dimension fields on two SKUs ⚠

Both the Maestro and the Pastomaster had `length` / `width` / `height` numeric fields that did
**not** match their own on-record spec tables — the width and height were transposed.

| SKU | Stored L×W×H (wrong) | On-record spec table | Corrected to (W×D×H) |
|---|---|---|---|
| IMG/ICE/00027 Maestro | 930 × 1400 × 500 | W 500 / D 930 / H 1400 | **500 × 960 × 1400 mm** |
| IMG/ICE/00028 Pastomaster | 1370 × 1080 × 390 | W 390 / D 1370 / H 1080 | **350 × 860 × 1030 mm** |

- **Maestro depth** also corrected **930 → 960 mm** (EU 96 cm and US 960 mm agree; 930 was
  wrong). Stored now as length/depth 960, width 500, height 1400.
- **Pastomaster** — the old spec-table numbers (390 / 1370 / 1080) were the **US datasheet's
  overall/crated** figures, not the machine body. Replaced with the **EU body footprint
  350 × 860 × 1030 mm** for a 50 Hz-market listing. Stored now as length/depth 860, width 350,
  height 1030.

### 4.2 Turbomix dimensions were wrong *and* mis-axed ⚠

Stored `length 500 / width 760 / height 440` were three unrelated drawing numbers on the wrong
axes. Correct envelope: **W 440 × D 500 × H 760–1140 mm** (the column height is adjustable —
the arm raises and lowers). Stored now as length/depth 500, width 440, height 760 (min), with
the adjustable range stated in the spec table.

### 4.3 Voltage — confirmed, do NOT "fix" to 240 V

- **Maestro 2 HCD** and **Pastomaster 60 RTX** are genuinely **380–415 V / 50 Hz / 3-phase**
  (Pastomaster nominal 400 V). The existing "380V/50H" label was essentially correct — these
  are three-phase machines and need a three-phase supply, not single-phase 240 V mains.
  Labels tidied to explicit "380–415 V / 50 Hz / 3 phase" and "400 V / 50 Hz / 3 phase".
- **Turbomix** is **single-phase 230 V** (50–60 Hz) — it *does* suit standard Kenyan mains.
  Recorded as such and flagged as a selling point.

### 4.4 Specs built out / model codes tightened

- **Model codes**: `TURBO MIX` → **Turbomix**; `MAESTRO-2STELLE HCD` → **MAESTRO 2 HCD**;
  `PASTO MASTER` → **PASTOMASTER 60 RTX**.
- **Names**: Turbomix renamed off the misleading "Ice Cream Machine" prefix to
  "Turbomix Vertical Blender".
- **Spec tables** rebuilt from bare `<ul>` stubs into full HTML `<table>` blocks matching the
  catalogue pattern; **added** motor/rpm/capacity/weight/voltage (Turbomix), production rate /
  compressor / cooling / weight / power (Maestro), batch range / programs / pasteurisation
  temp / power / weight (Pastomaster).
- **Descriptions** rewritten from raw bullet lists into the catalogue prose + `Key Features`
  pattern. **`meta_description` added to all three** (all were missing).
- **Dropped** the low-confidence "Volume 1.053 m³" line from the Maestro spec — the figure is
  a packaging/crate volume, not the machine envelope, and is not published by Carpigiani.

---

## 5. Not published — left blank rather than invented

- **Turbomix**: motor **HP** and exact **kW rating** (only ~2.3 kW electrical load is inferable
  from 230 V × 10 A), and cutter-blade dimensions.
- **Maestro 2 HCD**: **hopper capacity**, hourly production **in litres** (only kg/h is given),
  and whether our specific unit is the **air- or water-cooled** build. Weight recorded as
  ~280 kg (EU); the US listing's 773 lb ≈ 351 kg is a heavier/crated build.
- **Pastomaster 60 RTX**: explicit **cooling set-point** (~4 °C ageing is Carpigiani-standard
  but not printed on the sheet) and **holding time**.

---

## 6. Image sourcing — for manual review

No image field was changed this pass. Best sources for clean Carpigiani product imagery,
ranked: (1) **official product pages / the `dbe.carpigiani.com` CDN** — on-white studio
renders, watermark-free; (2) **reseller-mirrored official spec-sheet PDFs** (webstaurantstore,
partstown) — high-res renders + dimension drawings; (3) **clean dealer catalog photos**
(webstaurantstore, carpigiani.co.uk) — studio shots, minimal/no watermark; (4) **used-machine
marketplaces** (applanat, machineryworld, exapro, wotol) — huge coverage incl. discontinued
Stelle variants and real rating-plate photos, but often **watermarked / shot in situ** — use
for verification, not hero images. All URLs below returned **HTTP 200 at time of writing**.

### 6.1 Turbomix — IMG/ICE/00026

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| official CDN | [turbomix](https://carpigiani.com/us/product/turbomix) | <https://dbe.carpigiani.com/sites/default/files/2019-05/Turbomix_intera-laterale.jpg> | 200, jpeg, 355 KB | **Best** — full side view on stand, clean studio, no watermark, exact model. |
| official CDN | (same) | <https://dbe.carpigiani.com/sites/default/files/2019-05/Turbomix_sostituzione-emulsionatori.jpg> | 200, jpeg, 1.21 MB | Detail: swapping emulsifier blades. |
| official CDN | (same) | <https://dbe.carpigiani.com/sites/default/files/2019-05/Turbomix_comando-a-due-mani.jpg> | 200, jpeg, 864 KB | Detail: two-hand safety control in use. |
| WebstaurantStore | [439TURMIXAW](https://www.webstaurantstore.com/carpigiani-turbomix-vertical-blender/439TURMIXAW.html) | <https://cdnimg.webstaurantstore.com/images/products/large/608509/2195396.jpg> | 200, jpeg, 17 KB | Low-res thumbnail — fallback only. |

**Best pick:** `Turbomix_intera-laterale.jpg` (official, high-res, watermark-free hero).
**Dead/blocked:** none.

### 6.2 Maestro 2 HCD — IMG/ICE/00027

Carpigiani's official site now hosts only the current **HE** generation (guessed "Maestro
HCD" CDN filenames 404); the HE body is near-identical to our HCD. The exact two-star **HCD**
studio shot survives on WebstaurantStore. All URLs below re-verified loading (July 2026).

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| WebstaurantStore | [439MAESTROWW](https://www.webstaurantstore.com/carpigiani-maestro-hcd-w-15-qt-water-cooled-gelato-pastry-chocolate-batch-freezer-with-hot-cold-dynamic-208-230v-3-phase/439MAESTROWW.html) | <https://cdnimg.webstaurantstore.com/images/products/large/608407/2177644.jpg> | 200, jpeg, 33 KB | **Exact two-star ✱✱ HCD-W**, clean white bg, no watermark. Best exact-model match (low-res). |
| official CDN (HE gen) | [maestro-2-star-HE](https://carpigiani.com/en/product/maestro-2-star-HE) | <https://dbe.carpigiani.com/sites/default/files/2020-11/Maestro%20HE_intera-laterale.jpg> | 200, jpeg, 687 KB | Official, watermark-free, hi-res **side** view. HE generation (current) — near-identical body to HCD. |
| official CDN (HE gen) | (same) | <https://dbe.carpigiani.com/sites/default/files/2020-11/Maestro%20HE_intera-frontale.jpg> | 200, jpeg, 553 KB | Official hi-res **front** view, HE generation. |
| GTI Designs (mirror) | [maestro-hcd](https://gtidesigns.com/gtiproduct/maestro-hcd/) | <https://gtidesigns.com/wp-content/uploads/2022/01/Maestro-HCD-3_intera-laterale_USA_1920x1920px_3to2pt25.jpg> | 200, jpeg, 124 KB | HCD badge, but the **three-star** body; hi-res 1920px, clean white. |
| applanat (used unit) | <https://www.applanat.com/turbine-glace-patisserie-14-litres--maestro-2-hcd--carpigiani--occasion,6969,256.html> | <https://www.applanat.com/photodynp2020/538/538/non/oui/vyb9pm2v-Turbine_Carpigiani_Maestro_2_HCD_occasion.jpg> | 200, jpeg, 66 KB | Real photo of an actual 2 HCD unit, no watermark. Used listing — page may expire once sold. |

**Best pick:** WebstaurantStore `2177644.jpg` for the exact two-star model; for a large, crisp
hero use official `Maestro HE_intera-laterale.jpg` (687 KB) — note it is the HE generation, not
the HCD badge.
**Dead / wrong-model:** guessed official `Maestro HCD` CDN filenames 404 (site keeps only HE);
`baluna.com/.../carpigiani-master-hcd/` 404s; machineryworld's `...Maestro-1-Stella-HCD...8.jpg`
is the **one-star** model. Note: the earlier applanat *page* URL contains commas that break some
markdown previewers — the direct image URL beside it loads fine.

### 6.3 Pastomaster 60 RTX — IMG/ICE/00028

| Source | Page URL | Direct image URL | Verified | Notes |
|---|---|---|---|---|
| official CDN | [pastomaster-60-rtx](https://carpigiani.com/us/product/pastomaster-60-rtx) | <https://dbe.carpigiani.com/sites/default/files/2020-01/Pastomaster-60-RTX_intera-laterale_01-2020-USA_0.jpg> | 200, jpeg, 23 KB | **Best** — official render, exact RTX model, clean, no watermark (low-res ~510px). |
| WebstaurantStore | [PKT60 RTX](https://www.webstaurantstore.com/) | <https://cdnimg.webstaurantstore.com/images/products/large/608343/2178304.jpg> | 200, jpeg, 24 KB | Exact RTX on white, no visible watermark (US 208–230 V variant; body identical). |
| Carpigiani UK | [60 XPL P](https://www.carpigiani.co.uk/product/pastomaster-60-xpl-p-pasteuriser/) | <https://www.carpigiani.co.uk/hubfs/Coperchio-aperto_2-w510.jpg> | 200, jpeg, 21 KB | Detail: open transparent lid (illustrates the description); generic to the 60 L series. |
| A.F. System | [60 RTL](https://afsystem.biz/en/featured-products/23-pastomaster-60-rtl.html) | <https://www.afsystem.biz/1373-large_default/pastomaster-60-rtl.jpg> | 200, jpeg, 14 KB | Real photo of a used **RTL** (older series, not RTX) — reference only. |

**Best pick:** official `Pastomaster-60-RTX_intera-laterale...jpg`; pair with WebstaurantStore
`2178304.jpg` for a second angle. Both low-res (~23 KB) — request higher res from a distributor
if a large hero is needed.
**Dead/blocked:** none. Note the `carpigiani.co.uk` shot is the **XPL P** (touch-panel) variant,
not RTX — same 60 L body, different control panel.

---

## 7. Summary of `products.json` changes this pass

All 3 SKUs enriched. Before this pass: all 3 had no `meta_description`; the Turbomix had no
`technical_specification` and no image; both the Maestro and Pastomaster had scrambled
dimension fields and bare `<ul>` spec stubs.

- **Corrections**: dimension fields de-scrambled and corrected (Maestro → 500×960×1400;
  Pastomaster → 350×860×1030; Turbomix → 440×500×760 min); model codes tightened
  (`Turbomix`, `MAESTRO 2 HCD`, `PASTOMASTER 60 RTX`); Turbomix renamed off the misleading
  "Ice Cream Machine" prefix; low-confidence Maestro "Volume" line dropped.
- **Built out**: full HTML spec tables replacing bullet stubs; prose + `Key Features`
  descriptions; `meta_description` on all 3; recovered specs (Turbomix motor/rpm/capacity/
  weight/voltage; Maestro production/compressor/cooling/weight/power; Pastomaster batch range/
  programs/pasteurisation temp/power/weight).
- **No image field changed** — §6 links presented for manual review first. Turbomix remains
  `draft` (no image yet); Maestro and Pastomaster remain `published`.
