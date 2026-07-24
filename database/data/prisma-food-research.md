# Prisma Food Product Research

Research notes behind the PRISMA FOOD enrichment/audit pass on `products.json` (July 2026).
Covers all 9 PRISMA FOOD SKUs — 4 pizza ovens (electric single/double deck, a single gas
deck, a conveyor/tunnel oven) and 5 spiral dough mixers (IBT20/30/40/50/60). Specs were
sourced from Prisma's own fetch-friendly site (prismafood.com) and cross-checked against
resellers.

**This pass found substantial errors on every SKU** — scrambled dimensions on 8 of 9, a
whole gas oven mis-described as electric, a conveyor with wrong-source throughput, a mixer
with no specs at all, and mixer motor-power inconsistencies. All corrected. **No
`model_number` was changed** (all 9 codes verified genuine); image sourcing (§6) is presented
as links for manual review.

---

## 1. Brand identification

**Prisma Food** = **Prismafood S.r.l.**, an independent Italian manufacturer at Via Tabina 18,
**33098 Valvasone (PN)**, Friuli, Italy. **Founded 2006**; everything is made in-house.
Product scope: electric and gas pizza deck ovens, conveyor/tunnel ovens, spiral mixers, fork
mixers, planetary machines and dough sheeters, dough dividers/rounders, pizza presses, plus a
sushi-equipment line. Tagline "Made in Italy – Think Quality."

Official site **www.prismafood.com** (English at `/en`) is **fully automated-fetch friendly**
and has a no-login **Download Area** with per-line spec-sheet PDFs and hi-res JPEGs — the best
single source for both data and images.

---

## 2. Where to look — and the traps

| Resource                                      | URL                                                                             |
| --------------------------------------------- | ------------------------------------------------------------------------------- |
| Official site                                 | <https://www.prismafood.com/en>                                                 |
| Download Area (PDFs + hi-res JPEGs, no login) | prismafood.com/en/download-area                                                 |
| Product image CDN                             | `prismafood.com/writable/product/{gallery,images}/...`                          |
| Catalogue PDF                                 | prismafood.com/writable/download/attachments/prismafood_catalogo2025_250317.pdf |
| Manuals (3rd-party)                           | manualslib.com (40+ Prismafood manuals)                                         |

### Model-naming map (all 9 of our codes are real)

- **Deck ovens — "BASIC"**: single deck = pizza count (`BASIC 4/6/9`); double deck = doubled
  digits (`BASIC 44/66/99` = 4+4 …). The compact "SMALL BASIC" uses `X/YY` (`BASIC 1/50` =
  1-pizza small deck). Keep the slash — it distinguishes small-deck models.
- **Gas ovens — "GAS"**: `GAS 4/6/9` = pizza count, gas-fired.
- **Conveyor — "TUNNEL C"**: the number = **belt/chamber width in cm** (`C50` = 50 cm belt).
- **Spiral mixers — "IBT"**: the number = **bowl litres**. `IBM` = single-phase line, `IBT` =
  three-phase line, same body per size; `IBV` variable speed, `IBT H2O`/`EVO` water-dosed —
  different families, do not confuse.

### Traps

1. **Deck-oven voltage is a _configurable range_, not two requirements.** Prisma prints
   "230–400 V" with "standard 400 V three-phase + neutral" and "special voltages on request".
   The practical rule is size/kW-driven: **small single decks run 230 V single-phase; doubles
   / larger decks default to 400 V three-phase** (a 9.4 kW BASIC 44 on single-phase would pull
   ~41 A). Pick one per model — don't print both.
2. **Gas ≠ electric.** On a GAS oven the headline kW is **gas thermal input**, not electric
   load; the only electrical spec is a **230 V single-phase** feed for controls/ignition/lamp.
   Never copy "motor power / sheathed heating elements / 400 V three-phase" onto a gas oven.
3. **Mixers are three-phase by default.** All IBT are **400 V three-phase standard** (230 V
   single-phase available up to ~50 L). Do **not** default a mixer to 230 V single-phase.
4. **Generic reseller copy.** Reseller blurbs blanket a whole family with one voltage/kW or
   invented throughput ("130 pizzas/hour") — verify each model against Prisma's own page.
5. **Line confusion.** IBT vs IBM vs IBT H2O; TUNNEL electric vs "…GAS" share the C-number.

---

## 3. Product reference

| SKU           | Catalogue name                    | Model (unchanged) | Real Prisma model                                                | Official page                                                                                 |
| ------------- | --------------------------------- | ----------------- | ---------------------------------------------------------------- | --------------------------------------------------------------------------------------------- |
| IMG/OVE/00017 | Pizza Oven Electric Single Deck   | BASIC 1/50 LAMP   | **Basic 1/50** (Small Basic; "LAMP" = request-only light option) | [basic-150](https://www.prismafood.com/en/ovens/electric-ovens/small-basic-series/basic-150)  |
| IMG/OVE/00018 | Pizza Oven Electric Double Deck   | BASIC 44          | **Basic 44** (double deck, 4+4)                                  | [basic-44](https://www.prismafood.com/en/ovens/electric-ovens/basic-series/basic-44)          |
| IMG/OVE/00019 | Pizza Oven Single Gas Deck        | GAS 4 PF PROPANO  | **Gas 4** ("PF" = Prismafood house tag, "PROPANO" = LPG config)  | [gas-4](https://www.prismafood.com/en/ovens/gas-ovens/gas-4)                                  |
| IMG/OVE/00020 | Conveyor Pizza Oven Electric C/50 | TUNNEL C/50       | **Tunnel C50** (50 cm belt)                                      | [tunnel-c50](https://www.prismafood.com/en/conveyor-ovens/electric-conveyor-ovens/tunnel-c50) |
| IMG/PAS/00012 | Dough Mixer Spiral 20 L           | IBT20             | **IBT 20** (22 L bowl)                                           | [ibt-20](https://www.prismafood.com/en/mixers/spiral-mixer/ibt-series/ibt-20)                 |
| IMG/PAS/00013 | Dough Mixer Spiral 30 L           | IBT30             | **IBT 30** (32 L bowl)                                           | [ibt-30](https://www.prismafood.com/en/mixers/spiral-mixer/ibt-series/ibt-30)                 |
| IMG/PAS/00014 | Dough Mixer Spiral 40 L           | IBT40             | **IBT 40** (41 L bowl)                                           | [ibt-40](https://www.prismafood.com/en/mixers/spiral-mixer/ibt-series/ibt-40)                 |
| IMG/PAS/00015 | Dough Mixer Spiral 50 L           | IBT50             | **IBT 50** (48 L bowl)                                           | [ibt-50](https://www.prismafood.com/en/mixers/spiral-mixer/ibt-series/ibt-50)                 |
| IMG/PAS/00016 | Dough Mixer Spiral 60 L           | IBT 60            | **IBT 60** (60 L bowl)                                           | [ibt-60](https://www.prismafood.com/en/mixers/spiral-mixer/ibt-series/ibt-60)                 |

**Model-code flags (recorded, not changed):** `BASIC 1/50 LAMP` — "LAMP" is the request-only
internal-light option, not part of Prisma's code (real code `Basic 1/50`). `GAS 4 PF PROPANO`
— Prisma's code is `Gas 4`; "PF"=Prismafood, "PROPANO"=LPG config. `IBT 60` has a space the
other IBT codes lack — Prisma actually writes all of them with a space; the inconsistency is
internal to our records.

---

## 4. Data audit — errors found and corrected

### 4.1 Dimension scrambles (width ↔ height) on 8 of 9 SKUs ⚠

Every SKU except IBT30 (which had _no_ dimensions) had its stored `width`/`height` transposed
relative to reality; several also had a wrong value. Corrected external dimensions
(stored as length = depth, width = left-right span, height = vertical; spec tables label
**W × D × H**):

| SKU                 | Was (L/W/H)       | Corrected (W × D × H mm)         |
| ------------------- | ----------------- | -------------------------------- |
| BASIC 1/50 (00017)  | 915 / 355 / 690   | **915 × 690 × 360**              |
| BASIC 44 (00018)    | 900 / 745 / 760   | **975 × 925 × 745**              |
| GAS 4 (00019)       | 1005 / 560 / 930  | **1005 × 930 × 560**             |
| TUNNEL C/50 (00020) | 1210 / 500 / 1860 | **1860 × 1210 × 500** (no stand) |
| IBT20 (00012)       | 385 / 795 / 415   | **385 × 670 × 725**              |
| IBT30 (00013)       | _(none)_          | **435 × 750 × 810**              |
| IBT40 (00014)       | 480 / 828 / 805   | **480 × 820 × 850**              |
| IBT50 (00015)       | 480 / 850 / 805   | **480 × 805 × 850**              |
| IBT 60 (00016)      | 535 / 915 / 960   | **535 × 960 × 915**              |

### 4.2 The gas oven was described as an electric oven ⚠ serious (00019)

`GAS 4` carried electric-oven wording throughout. Fixed:

- **"Motor power (Kw) 16.1"** → the **16.1 kW is gas thermal input** (~55,000 BTU/h), the heat
  source. A gas oven has no drive motor.
- **"Sheathed heating elements"** → false; it heats via **atmospheric gas burners**.
- **"Standard power supply 400 V three-phase + neutral"** → false; only a **230 V
  single-phase** feed for controls/ignition/lamp.
- **Internal chamber height was wrong** (560 → **150 mm**; correct chamber 610 × 600 × 150).
- Added gas type (LPG/propane G30/G31, convertible to natural gas), consumption (~1.26 kg/h),
  net weight 96 kg.

### 4.3 Conveyor throughput and phase were wrong-source (00020)

- **Throughput "up to 130 × 8-inch / 145 g pizzas an hour"** was generic reseller copy →
  Prisma states **up to 86 pizzas/hour** (pizza diameter not published — dropped the unverified
  8-inch/145 g claim).
- **"Single phase electric"** for a 14.2 kW oven was misleading → offered in **230 V
  single-phase OR 400 V three-phase; three-phase recommended**.
- **Kept (verified correct):** 14.2 kW, element split (top 2 × 2,800 W, bottom 2 × 4,100 W),
  belt 50 cm/20", chamber 50 × 75 × 10 cm, 0–350 °C two-zone.

### 4.4 Electric deck ovens — capacity, temperature and power (00017, 00018)

- **BASIC 1/50**: capacity **"4 pizzas/cycle" was wrong** — the 62 × 50 cm chamber holds
  **1 × ø45 cm or 2 × ø30 cm**. Temperature **500 → 450 °C** (official). Power **5 → 4 kW**
  (top 2,000 + bottom 2,000 W). Dual-rated 230 V single-phase (default) / 400 V three-phase.
- **BASIC 44**: temperature **500 → 450 °C**; voltage set to **400 V three-phase** standard.
  Chamber (660 × 660 × 140 per deck), 4+4 ø32, 9.4 kW all confirmed correct.

### 4.5 Spiral mixers — missing data and motor-power inconsistencies (00012–00016)

- **IBT30 had no dimensions and no spec table** — built from scratch: 32 L, 24 kg/batch,
  88 kg/h, ø40 cm, 1.1 kW, 435 × 750 × 810 mm, 78 kg net.
- **IBT50 and IBT60 motor power** was self-contradictory in the records ("1.5 kW" then
  "1.1 kW"). Resolved from Prisma's range table, which rises with bowl size:
  **0.75 → 1.1 → 1.1 → 1.5 → 1.8 kW** for IBT20/30/40/50/60.
- **Voltage**: records said "230/1/50" / "230|400V". Corrected to **400 V three-phase
  standard, 230 V single-phase available** (see caveat below for IBT60).
- Minor weight corrections (IBT20 net 65 → 69; IBT40 gross 108 → net 92; IBT50 gross 109 →
  net 94). IBT50 bowl is **48 L** actual (nominal "50").

---

## 5. Not published / unverified — left out rather than invented

- **BASIC 1/50 / 44**: power figures vary across resellers (3.75 / 4 / 5 kW for the 1/50) —
  used Prisma's internally consistent 4 kW / 9.4 kW. BASIC 44 depth differs by source
  (925 official vs Hendi's 814) — used official 925.
- **GAS 4**: amperage/wattage of the 230 V control circuit; refractory-floor thickness.
- **TUNNEL C/50**: pizza diameter; stand height (1030 vs 1080 mm across resellers).
- **IBT60 single-phase**: an IBM (single-phase) equivalent of the 60 L was **not found** on
  Prisma — the 60 L may be **three-phase only**. Recorded IBT60 as 400 V three-phase and
  flagged this before selling it as 230 V. Single-phase confirmed for IBT20/30/40/50.

---

## 6. Image sourcing — for manual review

No image field was changed this pass. Best source by far is Prisma's **own CDN**
(`prismafood.com/writable/product/...`) — clean white-background studio shots, **no
watermark**, licensable for resale; the Download Area also offers hi-res JPEGs by line.
Manufacturer pages lazy-load images via JS, so the direct `/writable/product/...` URLs below
were lifted from raw HTML. All returned **HTTP 200 at time of writing**.

### Ovens

| SKU                 | Direct image URL                                                                                | Verified          | Notes                                                                                                               |
| ------------------- | ----------------------------------------------------------------------------------------------- | ----------------- | ------------------------------------------------------------------------------------------------------------------- |
| BASIC 1/50 (00017)  | <https://www.prismafood.com/writable/product/gallery/fornetto_basic_small_1-50-2T_24_front.jpg> | 200, jpeg, 75 KB  | **Best** — exact "1-50-2T" front, clean.                                                                            |
| BASIC 44 (00018)    | <https://www.prismafood.com/writable/product/images/forno_basic-44_24_front.jpg>                | 200, jpeg, 149 KB | **Best** — exact model front, hi-res.                                                                               |
| GAS 4 (00019)       | <https://www.prismafood.com/writable/product/gallery/forno_gas4-6_24.jpg>                       | 200, jpeg, 147 KB | **Best** — shared GAS 4/6 body (exact for GAS 4); `_fianco` side + `_camera` chamber also live.                     |
| TUNNEL C/50 (00020) | <https://www.prismafood.com/writable/product/gallery/tunnel_C50_lato.jpg>                       | 200, jpeg, 142 KB | **Best** — C50-specific side; `tunnel_front.jpg`, `tunnel_zenitale.jpg`, `tunnel_quadro_comandi.jpg` for a gallery. |

#### Full carousel per product page (July 2026)

Same CSS `background-image` pattern as the mixers (§ below) — pulled straight from
`.product__slider .product__slider__slide` on each oven's own page.

**BASIC 1/50** (IMG/OVE/00017) — 6 images listed from the carousel; **6 different close-up shots
supplied by the user and applied** (July 2026) - a compact-oven front panel + 5 detail shots,
sourced outside this scrape (not the 6 URLs below, which remain unverified against what's now
live). Saved to `storage/app/public/products/pizza-oven-electric-single-deck-prisma-food-imgove00017.jpg`
(replacing a mislabelled 20 KB `.png`-named placeholder) plus
`.../products/gallery/...-imgove00017-{1..5}.jpg`; `products.json` `image`/`gallery` updated.
Needs `migrate:fresh --seed` to take effect.

Carousel URLs (unused this pass, kept for reference):
1. <https://www.prismafood.com/writable/product/gallery/fornetto_basic_small_1-50-2T_24_front.jpg>
2. <https://www.prismafood.com/writable/product/gallery/fornetto_basic_small_camera.jpg> (chamber interior)
3. <https://www.prismafood.com/writable/product/gallery/fornetto_basic_small_resistenze.jpg> (heating elements)
4. <https://www.prismafood.com/writable/product/gallery/teglia_in_forno.jpg> (pizza tray in oven)
5. <https://www.prismafood.com/writable/product/gallery/forno_basic_small_apertura_anta.jpg> (door opening)
6. <https://www.prismafood.com/writable/product/gallery/forno_basic_small_maniglia.jpg> (handle detail)

**BASIC 44** (IMG/OVE/00018) — 7 images, **downloaded and applied** (July 2026)
1. <https://www.prismafood.com/writable/product/gallery/forno_basic-44_24_front.jpg> → primary `image`
2. <https://www.prismafood.com/writable/product/gallery/forno_basic_24_camera.jpg> (chamber interior) → gallery-1
3. <https://www.prismafood.com/writable/product/gallery/forno_basic_24_sistema_recupero_calore.jpg> (heat-recovery system) → gallery-2
4. <https://www.prismafood.com/writable/product/gallery/forno_basic_particolare_maniglione.jpg> (handle detail) → gallery-3
5. <https://www.prismafood.com/writable/product/gallery/forno_basic_particolare_apertura_anta.jpg> (door opening) → gallery-4
6. <https://www.prismafood.com/writable/product/gallery/forno_basic-44-cappa-stand_24_fianco.jpg> (with hood+stand, side) → gallery-5
7. <https://www.prismafood.com/writable/product/gallery/forno_basic-44-cappa-stand_24_front.jpg> (with hood+stand, front) → gallery-6

Saved to `storage/app/public/products/pizza-oven-electric-double-deck-prisma-food-imgove00018.jpg`
(replacing a 5.6 KB placeholder) plus `.../products/gallery/...-imgove00018-{1..6}.jpg`;
`products.json` updated with the new `gallery` array. Needs `migrate:fresh --seed` to take effect.

**GAS 4** (IMG/OVE/00019) — 7 images listed from the carousel; **primary image applied** (July
2026) from a user-supplied photo (front view, gas-oven control panel with ignition button and
3 knobs, clearly correct) - not from the URL list below. Overwrote a 7.7 KB placeholder at
`storage/app/public/products/pizza-oven-single-gas-deck-prisma-food-imgove00019.jpg` in place
(same filename, no `products.json` change needed). No gallery supplied yet.

Carousel URLs (unused this pass, kept for reference):
1. <https://www.prismafood.com/writable/product/gallery/forno_gas4-6_24.jpg> (shared GAS 4/6 body)
2. <https://www.prismafood.com/writable/product/gallery/forno_gas4-6_24_fianco.jpg> (side)
3. <https://www.prismafood.com/writable/product/gallery/thumbnailDAVGJIG4.jpg>
4. <https://www.prismafood.com/writable/product/gallery/gas%20pizza%20oven.jpg> (filename has a literal space — URL-encode as `%20`)
5. <https://www.prismafood.com/writable/product/gallery/forno_gas_24_camera.jpg> (chamber interior)
6. <https://www.prismafood.com/writable/product/gallery/forno_gas_24_bruciatori.jpg> (burners)
7. <https://www.prismafood.com/writable/product/gallery/forno_gas-stand_24_fianco.jpg> (with stand, side)

**TUNNEL C/50** (IMG/OVE/00020) — 7 images
1. <https://www.prismafood.com/writable/product/gallery/tunnel_C50_lato.jpg>
2. <https://www.prismafood.com/writable/product/gallery/tunnel_front.jpg>
3. <https://www.prismafood.com/writable/product/gallery/tunnel_zenitale.jpg> (top-down)
4. <https://www.prismafood.com/writable/product/gallery/tunnel_quadro_comandi.jpg> (control panel)
5. <https://www.prismafood.com/writable/product/gallery/tunnel_camera.jpg> (chamber interior)
6. <https://www.prismafood.com/writable/product/gallery/tunnel_nastro-trasportatore-camera.jpg> (conveyor belt in chamber)
7. <https://www.prismafood.com/writable/product/gallery/tunnel_C40_sovrapposti_frontali.jpg> — **caution**: filename says `C40`, likely a generic "stacked tunnel ovens" illustrative shot rather than C50-specific; verify before using as a primary image.

27 images total across the 4 oven pages. TUNNEL C/50's primary image (only) has since been
**applied from a user-supplied photo** (a C50-labelled 3/4 angle shot with the touchscreen
panel and belt visible - clearly correct, not from the URL list above), overwriting a 10 KB
placeholder at `storage/app/public/products/conveyor-pizza-oven-electric-c50-imgove00020.jpg`
in place (same filename, no `products.json` change needed). BASIC 1/50 and BASIC 44 done too
(see their own entries above). GAS 4 still needs downloading.

### Spiral mixers

| SKU            | Direct image URL                                                                   | Verified          | Notes                                                            |
| -------------- | ---------------------------------------------------------------------------------- | ----------------- | ---------------------------------------------------------------- |
| IBT20 (00012)  | <https://www.prismafood.com/writable/product/gallery/IBM-IBT-15-20_24_front.jpg>   | 200, jpeg, 71 KB  | Front family shot (15/20); `..._laterale.jpg` = side.            |
| IBT30 (00013)  | <https://www.prismafood.com/writable/product/images/IBM-IBT-30_24_laterale.jpg>    | 200, jpeg, 143 KB | 30-specific side shot.                                           |
| IBT40 (00014)  | <https://www.prismafood.com/writable/product/images/IBM-IBT-40-50_24_laterale.jpg> | 200, jpeg, 160 KB | Shared 40/50 body.                                               |
| IBT50 (00015)  | <https://www.prismafood.com/writable/product/images/IBM-IBT-40-50_24_laterale.jpg> | 200, jpeg, 160 KB | Same shared 40/50 image.                                         |
| IBT 60 (00016) | <https://www.prismafood.com/writable/product/images/IBM-IBT-60_24_laterale.jpg>    | 200, jpeg, 188 KB | 60-specific side shot.                                           |
| All IBT        | <https://www.prismafood.com/writable/product/gallery/IBT_24_caratteristiche.jpg>   | 200, jpeg, 190 KB | Cutaway features graphic (labels in Italian) — shared secondary. |

#### Full carousel per product page (July 2026)

Each IBT product page (`/en/mixers/spiral-mixer/ibt-series/ibt-XX`) has its own carousel of
5-6 images — 3 model-specific body shots (laterale/fianco/front) plus 2-3 images shared across
the whole IBT range (bowl, tilting grille, cutaway diagram). These render as CSS
`background-image` on `.product__slider .product__slider__slide`, not `<img>` tags, so they're
easy to miss with a plain scrape. Full clickable URLs per page, in carousel order:

**IBT 20** (IMG/PAS/00012) — 6 images
1. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-15-20_24_laterale.jpg>
2. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-15-20_24_fianco.jpg>
3. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-15-20_24_front.jpg>
4. <https://www.prismafood.com/writable/product/gallery/IBM-IBT_24_vasca.jpg> (bowl close-up)
5. <https://www.prismafood.com/writable/product/gallery/IBM-IBT_24_griglia-ribaltabile.jpg> (tilting safety grille)
6. <https://www.prismafood.com/writable/product/gallery/IBT_24_caratteristiche.jpg> (labeled cutaway diagram, Italian)

**IBT 30** (IMG/PAS/00013) — 6 images
1. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-30_24_laterale.jpg>
2. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-30_24_fianco.jpg>
3. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-30_24_front.jpg>
4. <https://www.prismafood.com/writable/product/gallery/IBM-IBT_24_vasca.jpg>
5. <https://www.prismafood.com/writable/product/gallery/IBM-IBT_24_griglia-ribaltabile.jpg>
6. <https://www.prismafood.com/writable/product/gallery/IBT_24_caratteristiche.jpg>

**IBT 40** (IMG/PAS/00014) — 5 images (no grille shot on this page)
1. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-40-50_24_laterale.jpg>
2. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-40-50_24_fianco.jpg>
3. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-40-50_24_front.jpg>
4. <https://www.prismafood.com/writable/product/gallery/IBM-IBT_24_vasca.jpg>
5. <https://www.prismafood.com/writable/product/gallery/IBT_24_caratteristiche.jpg>

**IBT 50** (IMG/PAS/00015) — 6 images (same body shots as IBT 40, plus the grille)
1. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-40-50_24_laterale.jpg>
2. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-40-50_24_fianco.jpg>
3. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-40-50_24_front.jpg>
4. <https://www.prismafood.com/writable/product/gallery/IBM-IBT_24_vasca.jpg>
5. <https://www.prismafood.com/writable/product/gallery/IBM-IBT_24_griglia-ribaltabile.jpg>
6. <https://www.prismafood.com/writable/product/gallery/IBT_24_caratteristiche.jpg>

**IBT 60** (IMG/PAS/00016) — 6 images
1. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-60_24_laterale.jpg>
2. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-60_24_front.jpg>
3. <https://www.prismafood.com/writable/product/gallery/IBM-IBT-60_24_fianco.jpg>
4. <https://www.prismafood.com/writable/product/gallery/IBM-IBT_24_vasca.jpg>
5. <https://www.prismafood.com/writable/product/gallery/IBM-IBT_24_griglia-ribaltabile.jpg>
6. <https://www.prismafood.com/writable/product/gallery/IBT_24_caratteristiche.jpg>

15 unique files total across all 5 pages (3 model-specific shots × 4 body variants, since IBT
40/50 share one, plus 3 shared images). Not yet downloaded — pick per SKU manually and pull the
chosen ones.

**Dead/blocked:** tomadostore.com, archiexpo.com → HTTP 403 to automated fetch; the 2020/21
catalogue PDF exceeds the fetch size limit. Reseller mirrors (cool-expert, empiresupplies,
egytl) carry the same official shots — prefer the Prisma CDN to avoid reseller watermarks.

---

## 7. Summary of `products.json` changes this pass

All 9 SKUs enriched; **no `model_number` changed** (all verified genuine).

- **Corrections**: de-scrambled dimensions on 8 SKUs (built dims for IBT30); gas oven fixed
  from electric-oven copy-paste (gas thermal power, 230 V controls only, chamber height
  560 → 150); conveyor throughput 130 → **86 pizzas/hour** and single-phase → single/three-phase;
  BASIC 1/50 capacity 4 → 1–2 pizzas, temp 500 → 450 °C, power 5 → 4 kW; BASIC 44 temp
  500 → 450 °C, voltage → 400 V 3-ph; mixer motor powers resolved (IBT50 → 1.5 kW, IBT60 →
  1.8 kW); mixer voltage → 400 V 3-ph standard.
- **Built out**: HTML spec tables replacing `<ul>`/`<p>` stubs; prose + `Key Features`
  descriptions; `meta_description` on all 9; IBT30 given a full spec set for the first time.
- **No image field changed** — §6 links presented for manual review. All 9 remain `published`.
