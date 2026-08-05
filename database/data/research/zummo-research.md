# Zummo Product Research

**No `old/zummo-research.md` exists to supersede.** The July 2026 Zummo material lives inside
`old/robot-coupe-sammic-zummo-research.md`, §5 and §7.3 — this file supersedes that section only,
and is the first standalone Zummo research file.

Pass date: August 2026. Covers the catalogue's single ZUMMO SKU, `IMG/FPR/00079`. **Nothing applied
to `products.json` or `brands.json`.**

---

## 1. ⭐ The company name — explicit answer

**Legal name:**

> **ZUMMO-INNOVACIONES MECÁNICAS, S.A.**
> C/ Cádiz 4, 46113 **Moncada (Valencia), España**
> Tel +34 961 301 246 · Fax +34 961 301 250 · zummo@zummo.es
> Quality system certificate no. 44 100 11 0904

Printed verbatim on the cover of Zummo's own Z06 user's guide (staged in the sourcing folder).

**Trading identity today:** the company trades simply as **Zummo**. Its current corporate and
catalogue site is https://www.zummocorp.com; the legacy https://www.zummo.es now serves the same
site. Its own footer lists **Groupe SEB** under "Discover Zummo" — Zummo is now part of the Groupe
SEB portfolio. All current product documents are branded `zummocorp.com`.

**The malformed brand string is already fixed.** `products.json` now reads `"brand": "ZUMMO"` for
`IMG/FPR/00079`. The `"ZUMMO INNOCACIONES"` value — `INNOVACIONES` with the **v** typed as a **c**,
and `MECÁNICAS, S.A.` dropped — is gone, and with it the silent `brand_id: null` it caused (the
seeder lowercases and matches against `brands.json`'s `"Zummo"`; `"zummo innocaciones"` matched
nothing). `brands.json` already carries a correct, active record: `slug: zummo`, `name: Zummo`,
`logo: brands/zummo.svg`, `website_url: https://www.zummocorp.com`. **No further action needed on
the brand link.**

The full legal name belongs in the brand *description*, not in a product's `brand` field.

---

## 2. ⭐ `Z06A-N` decoded — it is a correctly formed Zummo reference

Zummo publishes Z06 references as a **template with the version letter as a literal `x`**. Its
technical sheet **M0408ENEN/23-1** prints on page 1:

> **`Ref: Z06x-N`**

and the product page lists the colour set:

| REF | Colour |
|---|---|
| `Z06x-NGP` | Graphite |
| `Z06x-NBR` | Brown |
| `Z06x-NOR` | **Orange** |
| `Z06x-NBE` | Beige |
| `ZI06x-N` | Stainless steel (`I` = Inox) |

Parsing:

- **`Z06`** — the model
- **`x`** — the **version letter**; ours is **`A`**
- **`-N`** — **Nature**, the product line. Zummo's own headline is *"The **Z06 Nature** is Zummo's
  most versatile juicer"*, and the Food Service range "incorporates the **Nature** juicer models".
  The colour code attaches *after* the `N` (`-NGP`, `-NBR`, …), which is what proves `N` is the line
  and not a colour.

> **`Z06A-N` = Zummo Z06, version A, Nature line, colour unspecified.** Genuine and correctly formed.
> **No `model_number` change is needed or recommended.**

The only thing it omits is the colour. Our record and imagery are the **orange** machine, so the
fully-qualified supplier part number is **`Z06A-NOR`** — worth capturing somewhere, but not by
editing the unique ID.

---

## 3. Dimensions — order is right, values are 1-6 mm high

SAP has **no** dimension values for this SKU (all three fields blank) and its Item Remark is just
`ORANGE JUICER`, so there is no SAP column order to establish and no SAP value to arbitrate.

Zummo publishes the figure twice and the two agree:

- Technical sheet M0408ENEN/23-1: **`542 (x) × 810 (y) × 427 (z) mm`**
- A **dimensioned render**, arrows on the axes: **542 mm / 21.3″ front · 427 mm / 16.8″ deep ·
  810 mm / 31.9″ tall**

| | `products.json` | Zummo | Delta |
|---|---|---|---|
| `length` (frontal width) | 548 | **542** | +6 |
| `width` (depth) | 431 | **427** | +4 |
| `height` | 811 | **810** | +1 |

**The axis order is correct** — this SKU does *not* have the swap seen across most of the catalogue.
The values are simply a few millimetres high, probably from an older revision or measured over trim.
Low priority.

Weight: the current datasheet says **51 kg**; the older user's guide says 48 kg. Use **51 kg**.

---

## 4. ⚠ The multi-market voltage list is still live, and it names 120 V / 60 Hz

`technical_specification` currently reads:

> `POWER RATING: 230 V – 50 Hz. 220 V – 60 Hz. 120 V – 60 Hz.`

That is Zummo's **global build list**. The machine is built to order per market and the real rating
is on the unit's identification plate — the user's guide, §3 Installation, says so explicitly:
*"Ensure that the machine's voltage and frequency match the values of your electrical installation.
See the identification plate."*

Presented as a flat list on a Kenyan storefront it invites the same mistake being chased elsewhere in
this catalogue: a buyer's electrician reading **120 V – 60 Hz** off a product page for a machine that
will arrive as a **230 V / 50 Hz** unit. **Recommend cutting it to `230 V – 50 Hz`** and, if the
range must be shown, saying explicitly that other market voltages are built to order.

### Fields Zummo publishes that we do not carry

| Field | Zummo (M0408ENEN/23-1) |
|---|---|
| Feeder capacity | 1.5 kg |
| Bin capacity | 22 L (2 × 11 L) |
| Filling height | 178 mm |
| Consumption | 0.007 kWh for 10 L/day |
| Squeezing kits | M (55-75 mm), L (70-90 mm); optional S (45-60 mm) |
| Weight | 51 kg |
| Safety | Blocking sensors |
| Filter | Automatic (belt-driven, sweeps seeds and pulp) |

Fruits per minute (10) and basket capacity (6 kg) already match.

---

## 5. Imagery

Staged in `products resorce final\zummo\`; ledger in `_sourced.json`, notes in `_FINDINGS.md`.

**13 files. Every one rendered. No synthetic imagery** — all Zummo's own CAD renders and studio
photography.

**⭐ The ceiling was broken by PDF extraction, not by the website.**

- **zummocorp.com's gallery is capped at 650 × 720** for every Z06 asset. Probed this pass: `?w=2000`
  is ignored; the root path (without `/products/`), `.png` and `-original.webp` all **403**; the
  `-product.webp` suffix returns a *smaller* 350 × 380. Two in-situ shots reach **748 × 776**, the
  largest the site serves — still 24 px under the floor.
- **PyMuPDF `extract_image()` on Zummo's own datasheets returns 1375 × 1232** (orange) and
  **1306 × 1232** (inox): clean, transparent-background CAD renders that appear nowhere on the
  website. This is the only route past the ceiling in this brand.

**Perceptual duplicate sweep** (16×16 ahash → 256×256 greyscale RMS): **no shared photographs**,
including across the four colourways.

| Role | Files | Best |
|---|---|---|
| Our exact variant (orange Z06 Nature) | 6 | **1375 × 1232** datasheet extract |
| Representative (inox) | 2 + datasheet | 1306 × 1232 |
| Spec / diagram | 2 | dimensioned render, squeezing-kit chart |
| Documents | 4 PDFs | datasheet ×2, maintenance instructions, user's guide |
| `_brand-reference` | 3 colourways | — |

**Documents are this brand's strength.** Unlike Kalerm, Dr.Coffee and Goodwill, Zummo publishes
proper technical sheets **with an intact text layer** — no rendering needed to read them.

⚠ **WebSearch was exhausted (200/200) before this brand started**, so distributor sourcing was not
attempted. Given the quality of Zummo's own material that is not a meaningful gap here.

---

## 6. Recommended changes, in priority order (nothing applied)

1. **Cut `POWER RATING` to `230 V – 50 Hz`** and drop `120 V – 60 Hz` / `220 V – 60 Hz` from the
   customer-facing spec, or label them explicitly as build-to-order market variants.
2. **Add the missing datasheet fields** (§4) — feeder 1.5 kg, bin 22 L (2 × 11 L), filling height
   178 mm, squeezing kits, weight 51 kg, blocking sensors, automatic filter.
3. **Adjust the dimensions** to Zummo's own `542 / 427 / 810`. Order is already right.
4. **Replace the product image.** The stored image is 225 × 225; the staged 1375 × 1232 datasheet
   extract is the same machine and colourway.
5. **No `model_number` change.** `Z06A-N` is correct. Optionally record `Z06A-NOR` as the
   fully-qualified supplier reference for the orange colourway.
6. **No `brands.json` change.** The record is correct and the product's brand string is already
   `ZUMMO`.

---

## 7. Sources

https://www.zummocorp.com
https://www.zummocorp.com/en/commercial-juicer-machines/z06
https://www.zummocorp.com/us/commercial-juicer-machines/z06-nature
https://www.zummo.es
https://media.zummocorp.com/m0408enen-23-1-ficha-tecnica-z06-23-en-1697024862q9Fmj.pdf
https://media.zummocorp.com/m0409enen-23-1-ficha-tecnica-z06-inox-23-en-1697024866JMQt4.pdf
https://media.zummocorp.com/instrucciones-mantenimiento/manual-z06-eng-1784875352YaWMH.pdf
