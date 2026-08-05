# Robot Coupe Product Research

Supersedes the Robot Coupe section of `old/robot-coupe-sammic-zummo-research.md`.

Covers all 4 ROBOT COUPE SKUs: `IMG/FPR/00018` (R301 combination processor),
`IMG/FPR/00227` (CMP 400 V.V immersion blender), `IMG/FPR/00228` (CMP 300 V.V immersion
blender) and `IMG/FPR/00250` (`2006` assorted blade 3-pack for the R301UD).

**Nothing has been applied to `products.json` or `brands.json`.** Findings and staged imagery
only. Images and PDFs are in
`Desktop\ecommerce\products resorce final\robot-coupe\` with the per-file ledger in
`_sourced.json` and the full working notes in `_FINDINGS.md`.

⚠ **WebSearch quota was exhausted at the start of this session** (200/200). Every source below
was reached by direct fetch, navigating from the manufacturer's own `sitemap.xml`.

---

## 1. The headline: use the EXPORT market site, never `/usa/`

Robot Coupe serves a different specification per market from the same product id. For the R 301:

| | USA market | **Export market** |
|---|---|---|
| Power | 1.5 HP | **650 W** |
| Speed | 1725 rpm | **1500 rpm** |
| Voltage | **120 V** | **single phase, 230 V** |
| Dimensions | 23.75" × 16.25" × 20.25" | **355 × 305 × 570 mm** |

SAP's own remark for the R 301 reads *"Power 650 watts … Speed(s) 1500 rpm"* — our record is
**already on the European/export build**, and sourcing from the US page would inject a
wrong-market electrical spec. The correct root is:

https://www.robot-coupe.com/export/en

Found via https://www.robot-coupe.com/sitemap.xml (23 market sitemaps; `export-en.xml` is ours).

Product pages used:

https://www.robot-coupe.com/export/en/p/food-processors-r-301/18274
https://www.robot-coupe.com/export/en/p/power-mixers-cmp-400-v-v/18420
https://www.robot-coupe.com/export/en/p/power-mixers-cmp-300-v-v/18253
https://www.robot-coupe.com/export/en/p/power-mixers-cmp-350-v-v/18254

---

## 2. ⭐ CMP 300 V.V vs CMP 400 V.V — the shaft-length answer

**The number in the model name is the shaft (tube) length in millimetres.** That is the entire
product difference: motor, handle, controls and bell are the same parts.

From the manufacturer's immersion-blender range brochure, page 12:

| Model | Speed (rpm) | Power | Voltage | Ø | Overall | **Tube** | net | gross |
|---|---|---|---|---|---|---|---|---|
| CMP 250 V.V. | 2300–9600 | 310 W | 230 V/50 Hz | 94 | 619 | **255** | 3.0 kg | 4.7 kg |
| **CMP 300 V.V.** | 2300–9600 | **350 W** | **230 V/50 Hz** | 94 | 669 | **305** | 3.1 kg | 4.8 kg |
| CMP 350 V.V. | 2300–9600 | 400 W | 230 V/50 Hz | 94 | 727 | **363** | 3.3 kg | 5.0 kg |
| **CMP 400 V.V.** | 2300–9600 | **420 W** | **230 V/50 Hz** | 94 | 786 | **413** | 3.8 kg | 4.3 kg |

Max batch capacity: **CMP 300 = 30 L, CMP 400 = 73 L** (both agree with SAP).

### 2.1 Confirmed photographically as well

Robot Coupe's three hero masters are shot at one scale, so they can be measured against each
other. Opaque-pixel extent of each PNG's alpha channel:

| Model | Master px | Extent | px/mm (extent ÷ stated overall length) |
|---|---|---|---|
| CMP 300 V.V. | 2997 × 6446 | 5699 | 5699 ÷ 660 = **8.635** |
| CMP 350 V.V. | 2997 × 6850 | 6107 | — |
| CMP 400 V.V. | 2997 × 7323 | 6590 | 6590 ÷ 763 = **8.637** |

The two scales agree to **0.02 %**, and the measured length difference is
891 px ÷ 8.635 = **103.2 mm** against a stated 763 − 660 = **103 mm**.

⚠ **The brochure and the web page disagree on overall length** (brochure 669/786, web page
660/763). The photographs side with the **web page** — on brochure figures the two scales
diverge to 8.519 and 8.384. **Our stored 660 and 763 are the correct pair and need no change.**

---

## 3. ⚠⚠ Wrong-market electrical defect — CMP 400 V.V (`IMG/FPR/00227`)

SAP's remark reads:

> "Power- 420w. **Voltage- 120v 1ph.** **5000 to 10000 rpm** with automatic speed regulation…"

Robot Coupe's export brochure gives **230 V / 50 Hz, 1.9 A** and **2300 to 9600 rpm**. So the
remark carries **two** US-market errors. The sibling CMP 300 remark ("240v/1 ph … 2300 rpm to
9600 rpm") is correct.

**Recommend correcting CMP 400 V.V to 230 V / 50 Hz, 420 W, 2300–9600 rpm.**

⚠ The same remark also says *"16" blade bell and shaft"* (the tube is 400 mm = 15.7") and
*"No removable shafts"* — while asserting two sentences earlier that the bell and blade **are**
removable, which is Robot Coupe's own headline claim for the range. The remark contradicts
itself; treat "no removable shafts" as unverified.

---

## 4. SAP dimension audit — cross-row contamination proven

| SKU | SAP W/D/H | Manufacturer | Verdict |
|---|---|---|---|
| IMG/FPR/00018 R301 | 226 / 304 / 427 | **355 × 305 × 570** | ⚠ values wrong; only 304 ≈ 305 survives |
| IMG/FPR/00227 CMP 400 | **500 / 350 / 30** | 763 overall, Ø 94 | ⚠ contaminated |
| IMG/FPR/00228 CMP 300 | **500 / 350 / 30** | 660 overall, Ø 94 | ⚠ contaminated |
| IMG/FPR/00250 blade 3-pack | 343 / 496 / 454 | a set of 3 blades | ⚠ implausible — likely a carton |

⚠ The CMP 400 and CMP 300 rows carry the **identical triple 500 / 350 / 30** despite being
103 mm different in length, and a 30 mm height is impossible for a 660 mm tool. **Treat all four
Robot Coupe SAP dimension triples as MISSING.**

**SAP's column order could not be established for this brand from SAP itself** — no Robot Coupe
row has a dimensioned remark to self-check against, and the one row with usable values (R301)
disagrees with the manufacturer on two of three axes.

⭐ On both SKUs where an independent figure exists, **`products.json` beats SAP**: R301's stored
355/305/570 matches the export page exactly, and the CMP pair's 660/763 are confirmed twice over
(§2).

---

## 5. `IMG/FPR/00250` — the `2006` blade 3-pack

**Subject confirmed.** The R 301 export brochure, page 2:

> "**3 blade assemblies available**, sharpened to suit every type of task."
> Smooth blade — *supplied as standard*. Coarse serrated blade — *optional*. Fine serrated
> blade — *optional*.

That is "ASSORTED BLADE 3PACK R301UD". Robot Coupe's own blade photography is staged for this
SKU (blades stamped **SABATIER**), and **no machine photography has been attached to it**.

⚠ **`2006` could not be verified as a Robot Coupe reference, and probably is not one.**

- Robot Coupe's published grammar is **5 digits beginning 27xxx** for discs (27051, 27555,
  27588, 27046, 27764 …), all confirmed in the Disc Selection Guide PDF.
- `2006` appears **nowhere** in that 12-page guide.
- It *does* appear twice in the immersion-blender brochure — but only as **EU directive
  numbers** (`2006/42/CE`, `1907/2006/CE`, `EN 60204-1:2006`). Coincidence, not a part number.

`model_number` is the unique ID — **no change proposed**. Recorded so the next pass knows the
code is unverified rather than unchecked. The two optional blades' real references are not
published on the export product pages; they need the spare-parts catalogue or the supplier.

---

## 6. Tooling — the `image-thumb` strip returns the native master

Robot Coupe serves renditions at
`/robot-coupe-global/<path>/image-thumb__<assetid>__<PRESET>/<FILE>.png`.
**Deleting the `image-thumb__…__PRESET/` segment returns the original.**

| Asset | Page rendition | Master |
|---|---|---|
| `CMP_400_VV.png` | 44,617 B | **4,619,974 B (2997 × 7323)** |
| `R 301.png` | 177,098 B | 504,537 B (800 × 921) |

~100× on the CMP hero. Requesting a *larger* preset 404s — the preset list is fixed, so
**stripping is the only route**. Several feature images are genuinely small at the master
(640 × 420, 234 × 240) — those are **native ceilings, not throttled deliveries**.

## 7. Shared assets

- ⚠ **The CMP 300 and CMP 400 pages link the SAME brochure** — asset id `30319`, both downloads
  **md5 `1fbeda0e2b87`, byte-identical**. Filenames carry `-SHARED-DOC`.
- **Every CMP feature image is shared between the two model pages**; only the hero is
  model-specific. All renamed to `CMP-RANGE` so no shared photo sits under a code-asserting name.
- ⚠ **A wrong-model image is published in CMP 400 V.V's own feature strip**:
  `Poignée-ergonomie-cmp-2021-avantage.png` shows a collar badge that reads **"CMP 300 V.V."** at
  5× zoom.
- Robot Coupe encodes fitment in filenames (`…R301 au R402V.V.`,
  `Juice_Extractor_Kit_R301_R301U_R401_R402_R402VV`) — that string is the range evidence.

## 8. Product reference

| SKU | Model | Official page | Voltage / Hz | Confidence |
|---|---|---|---|---|
| IMG/FPR/00018 | R301 | https://www.robot-coupe.com/export/en/p/food-processors-r-301/18274 | 230 V / 50 Hz, 650 W, 1500 rpm | **High** — badge legible in the hero render |
| IMG/FPR/00227 | CMP 400 V.V | https://www.robot-coupe.com/export/en/p/power-mixers-cmp-400-v-v/18420 | **230 V / 50 Hz**, 420 W, 1.9 A | **High** — badge legible; brochure spec table |
| IMG/FPR/00228 | CMP 300 V.V | https://www.robot-coupe.com/export/en/p/power-mixers-cmp-300-v-v/18253 | **230 V / 50 Hz**, 350 W, 1.6 A | **High** — badge legible; brochure spec table |
| IMG/FPR/00250 | `2006` | https://www.robot-coupe.com/export/en/p/food-processors-r-301/18274 | n/a | **High** on subject, **Low** on the code itself |

## 9. Recommended actions (nothing applied)

1. 🔴 **CMP 400 V.V: correct 120 V → 230 V / 50 Hz and 5000–10000 rpm → 2300–9600 rpm** (§3).
2. 🟠 Add the confirmed missing specs: CMP net/gross weights, tube lengths (305 / 413 mm),
   amperage; R301 net weight 14 kg and the 3.7 L bowl / 24-disc range.
3. 🟡 Leave all four SAP dimension triples out; `products.json` is already correct where it
   matters (§4).
4. ⚪ **No `model_number` changes** on any of the four, including `2006` (§5).
