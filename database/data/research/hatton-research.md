# Hatton Product Research

Supersedes `old/hatton-research.md`.

Covers both HATTON SKUs: `IMG/DWW/00149` (**HT-Z1**, hood type) and `IMG/DWW/00151`
(**HT-T2**, undercounter). Batch-1 copy work has already been applied to this brand, so what
this pass owed was **provenance** — plus one question the earlier file explicitly left open,
which is now settled.

**Nothing has been applied to `products.json` or `brands.json`.** Staged imagery and per-file
ledger: `Desktop\ecommerce\products resorce final\hatton\` (`_sourced.json`, `_FINDINGS.md`).

---

## 1. ⭐ Body style — the defect check PASSES

The risk to check was a hood photo landing on the undercounter SKU. **It has not happened.**
Hatton publishes a separate product page per body style, and all 12 files came from the matching
page. Every image was rendered and classified individually:

| SKU | Body style | Result |
|---|---|---|
| IMG/DWW/00149 HT-Z1 | **hood type** — raised hood, pull-rod lever arm | ✅ **6/6** hood type |
| IMG/DWW/00151 HT-T2 | **undercounter** — square box, front door, no hood | ✅ **6/6** undercounter |

**Zero cross-contamination.** A real improvement on the previous pass, which staged 18 files
against HT-Z1 of which **9 were the wrong machine entirely** (rack-conveyor / flight-type
tunnels harvested from Made-in-China galleries). **None of those 9 has been re-staged.** The MIC
galleries are still contaminated and are used below **for the model codes only, never imagery.**

---

## 2. ⭐⭐ The footprint axis question — SETTLED by a dimensional drawing

The previous file raised this at **"medium confidence only … not worth a blind edit"**. It can
now be answered, because the official hood-type page carries a **dimensioned general-arrangement
drawing**. At 581 × 539 it is below our resolution floor, but rendered at 4× every figure reads:

| View | Figures |
|---|---|
| **Front elevation** | body **653** wide; worktop **850**; **1900** overall with hood raised |
| **Plan** | **690** across |
| **Side elevation** | **780** deep; **1475** high, hood down; **121** |

https://ijrorwxhlqnrln5p-static.micyjz.com/cloud/lqBpqKjrlmSRlkijpilijo/The-Latest-Space-Saving-Effortless-High-Capacity-Cleaning-Hood-Type-Dishwasher5.jpg

So the manufacturer's printed **"690 × 780 × 1475"** decodes as **Width 690 × Depth 780 ×
Height 1475** — the 780 axis is the one the hood lever arm runs along, i.e. the depth.

Our record maps it positionally as `length: 690, width: 780`. In this catalogue `length` means
**depth**, so the two footprint axes **are** transposed. Correct mapping:

> `length` (depth) = **780**, `width` = **690**, `height` = **1475**

The physical argument the earlier file made independently (the 505 mm rack entrance is on the
front face and a 500 × 500 rack travels front-to-back) is now **confirmed rather than inferred**.

### 2.1 ⚠ Two numbers nobody has

- **Hood-raised clearance 1900 mm.** A 1475 mm machine installed under a 1600 mm shelf cannot be
  opened. In **neither** our record nor any spec table on any source.
- **Worktop / loading height 850 mm.**

Also: the drawing's **653 mm** body width vs **690 mm** plan width means 690 is measured over the
hood rails, not the cabinet.

---

## 3. SAP audit — HT-Z1's row fails its own self-check

| SKU | SAP W/D/H fields | SAP's own remark | Manufacturer | Verdict |
|---|---|---|---|---|
| IMG/DWW/00149 HT-Z1 | **780 / 690 / 475** | "L690\*W780\*H**1475**MM" | 690 W × 780 D × 1475 H | ⚠ **self-contradictory** |
| IMG/DWW/00151 HT-T2 | *(blank)* | "L600xW600xH800mm" | 600 × 600 × 800 | ✅ remark right; fields MISSING |

**HT-Z1's SAP row is wrong twice:**
1. ⚠ **The height is truncated — `475` where its own remark says `1475`.** A dropped leading `1`.
   A 475 mm hood-type dishwasher is impossible.
2. The footprint pair is swapped relative to the drawing (780/690 where the drawing gives
   W 690 / D 780).

**SAP's column order could not be established for HATTON from SAP itself** — HT-T2's fields are
blank and HT-Z1's single row contradicts its own remark. Use §2. Per the brief, HT-T2's blank
fields are **MISSING, not zero**; the 600/600/800 in our record comes from the remark and both
manufacturer sources and is correct.

---

## 4. HT-Z1 — full spec, re-verified

690 × 780 × 1475, net **110 kg**, rack 500 × 500 × 100, entrance **505 mm**, max washing height
**420 mm**, **60 racks/hour**, 3 L/rack, wash tank **21.5 L**, booster 8 L, wash 60-65 °C, rinse
82-90 °C, cycles 60/90/120 s, supply pressure 0.25-0.5 MPa, inlet G3/4" (DN20), drain 32 mm,
supply water 10-60 °C, electrical heating, **CE + ISO9001**.

https://www.hatton-tech.com/The-Latest-Space-Saving-Effortless-High-Capacity-Cleaning-Hood-Type-Dishwasher-pd529330178.html

⚠ **The `Capacity: 30L` line in our HT-Z1 record is still wrong**, and its origin is now visible
in one screen: the MIC listing shows a marketplace filter attribute **"Capacity 30L"** sitting
directly above **"Wash Tank Capacity 21.5L"**. 30 L is (a) a marketplace attribute and (b)
HT-T2's real tank figure. **Recommend deleting the line.** Still the only outright error in the pair.

## 5. HT-T2 — the 25 L / 65 kg vs 30 L / 80 kg split is unchanged

| Spec | `hatton-tech.com` (no model row) | MIC listing **naming HT-T2** | our record |
|---|---|---|---|
| Wash tank | **25 L** | **30 L** | 30 L |
| Net weight | **65 kg** | **80 kg** | 80 kg |
| Racks/hour | 50 | 50 | *(absent)* |

Both cosmetic generations are visible in the staged images — blue fascia with rotary controls
(`-1`, `-2`) and black digital panel (`-4`, `-5`, `-6`) — on an identical 600 × 600 × 800
cabinet. Our figures match the listing that **explicitly names HT-T2**, so they stand.
**Still a supplier question; do not overwrite from the official page alone.**

Still missing and worth adding: **50 racks/hour** and **3 L/rack**.

## 6. ⚠ Electrical — genuinely unpublished

Neither machine has a published voltage, frequency or kW **anywhere**. Both official pages and
every MIC listing say only *"the voltage can be based on the requirements of your country"*.
This is the largest real data gap in the pair and **only the supplier can close it.** Recorded as
`NOT PUBLISHED` rather than guessed.

## 7. Provenance — and why it is awkward

⚠ **`hatton-tech.com` never states a model number.** Its pages are titled with marketing strings
and its spec tables have no model row. The codes exist **only** on the Made-in-China storefront.
Both re-fetched this pass, both state `Model NO.` explicitly with spec blocks matching the
official pages:

https://hatton-dishwasher.en.made-in-china.com/product/qTXrLgNGZDcw/China-Efficient-High-Capacity-Commercial-Dishwasher-for-Restaurant-Equipment-Model-No-Ht-Z1.html
https://hatton-dishwasher.en.made-in-china.com/product/rnmpoOZylbcF/China-Mini-High-Performance-Undercounter-Dishwasher-with-Quick-Wash-Cycle.html

Consequently **`code_proven` is `false` on every image** — no image, badge or drawing carries the
model code; the fascia badges read only "HATTON". The codes are established documentarily, not
photographically.

## 8. Resolution ceilings — re-verified

The `micyjz.com` CDN **fits-within and never upscales**: `-800-800`, `-1000-1000` and
`-2000-2000` on an image whose native is 662 × 684 all return 662 × 684. The sub-floor files are
**genuine native ceilings**. Highest available: **1706 × 1706** (HT-T2), **1680 × 2672** (HT-Z1).

## 9. No spec sheets exist

`/download`, `/downloads`, `/documentation`, `/resources`, `/catalogue`, `/catalog`, `/pdf`,
`/manual` all **404** on `hatton-tech.com`, and no `.pdf` link appears in either product page's
markup. **Hatton publishes no downloadable spec sheet or manual.** The component diagram and the
dimensional drawing are the only technical documents, and both are images.

## 10. Product reference

| SKU | Model | Official page | Model-confirming source | Confidence |
|---|---|---|---|---|
| IMG/DWW/00149 | HT-Z1 | https://www.hatton-tech.com/The-Latest-Space-Saving-Effortless-High-Capacity-Cleaning-Hood-Type-Dishwasher-pd529330178.html | MIC listing above | **High** — spec table + drawing agree |
| IMG/DWW/00151 | HT-T2 | https://www.hatton-tech.com/Innovative-Exploring-Modern-Technology-Undercounter-Dishwasher-pd519330178.html | MIC listing above | **High** on dimensions; **Medium** on 30 L / 80 kg (generation split) |

## 11. Recommended actions (nothing applied)

1. 🔴 **HT-Z1: delete the `Capacity: 30L` line** (§4) — the only outright error.
2. 🟠 **HT-Z1: swap the footprint axes** — `length` 780, `width` 690, `height` 1475 (§2). Now
   confirmed by drawing, no longer a medium-confidence guess.
3. 🟠 **HT-Z1: add hood-raised clearance 1900 mm** and worktop height 850 mm (§2.1) — genuinely
   new information, and an installation blocker if omitted.
4. 🟠 **HT-T2: add 50 racks/hour and 3 L/rack** (§5).
5. 🟡 HT-Z1: add net weight 110 kg, booster 8 L, wash/rinse temperatures, cycles, supply
   pressure, rack size (§4).
6. 🟡 Fix the "Hattons" → "Hatton" typo in `IMG/DWW/00151`'s `name` — name only.
7. 🟡 Link the 500 × 500 rack accessories to HT-T2 as well as HT-Z1 (both take the same rack).
8. ⚪ **Ask the supplier for kW / voltage** on both — genuinely unpublished (§6).
9. ⚪ Do **not** change HT-T2's 30 L / 80 kg to the official page's 25 L / 65 kg — generation
   dependent (§5).
10. ⚪ For a future brand pass: `brands.json`'s `http://www.hattonchina.cn/` must **stay
    `http://`** (no working HTTPS exists); https://www.hatton-tech.com/ is the better English
    destination.
