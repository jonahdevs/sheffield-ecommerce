# Goodwill Product Research

**Supersedes `old/goodwill-research.md`** (July 2026). That pass got the OEM-code mapping and the
US-voltage diagnosis right; this pass **proves** the faucet reading, corrects the dimensions on all
three SKUs from dimensioned drawings, and resolves the two figures it left disputed.

Pass date: August 2026. Covers all 3 GOODWILL SKUs. **Nothing applied to `products.json`.**

---

## 1. Brand

**Guangdong Goodwill Industrial Co., Limited** — Foshan, Guangdong, China; tel +86 757 2290 2562;
info@goodwill-kitchen.com. Supplier of catering and beverage equipment; its coffee brewers are sold
both under its own `GW-` codes and as white-label OEM under `RB-` / `RV-` / `FRP-` codes.

| Resource | URL | Value |
|---|---|---|
| Coffee Brewer category | https://www.goodwill-kitchen.com/pro_25797619_7293628_7711897_1.html | The definitive model list: GW-CMA-180A, GW-CB-02A1, GW-DFRB-286, GW-RP286-BV, GW-386-B, GW-386-AD2 |
| GW-386-B (exact match) | https://www.goodwill-kitchen.com/pro_53731409.html | Official code, power and size |
| GW-386-AD2 (BD2's sibling) | https://www.goodwill-kitchen.com/pro_53731347.html | The BD2 has no page; A/B = plastic vs SS304 basket |
| GW-RP286-BV (FRP's sibling) | https://www.goodwill-kitchen.com/pro_53731426.html | The non-faucet variant — and the visual proof of what the `F` means |
| **2023 catalogue (16 pp)** | https://www.goodwill-kitchen.com/dom/down_doc_pass.php?username=erinyang11&file_id=71204 | ⭐ Page 04-05 is the **only** place the manufacturer publishes `GW-386-BD2`. Text layer intact — no rendering needed |
| **VEVOR, OEM variants** | https://www.vevor.com/electric-coffee-grinder-c_11786/12-cups-commercial-drip-coffee-maker-with-2-glass-carafes-and-2-warmers-office-p_010676617182 · https://www.vevor.com/electric-coffee-grinder-c_11786/12-cups-commercial-drip-coffee-maker-with-thermal-carafe-restaurant-office-cafe-p_010915863780 · https://www.vevor.com/electric-coffee-grinder-c_11786/vevor-commercial-drip-coffee-maker-16-17-cups-machine-with-2-5-l-thermal-carafe-keep-warm-for-4-hours-stainless-steel-brewer-with-auto-water-filling-for-restaurant-office-coffee-shop-home-p_010919733799 | ⭐ Each carries a **dimensioned drawing** — the only labelled-axis dimensions in existence for these machines |

⚠ **WebSearch was exhausted (200/200) before this brand started.** Discovery was limited to the
leads already in `old/goodwill-research.md`. Outage, not a finding.

---

## 2. ⭐ Voltage and frequency — per SKU

**Guangdong Goodwill publishes a dual rating on every brewer, US first**: `120V/1610W; 230V/2020W`.
That is the structural hazard — the US figure sits immediately left of the one we need, in the
manufacturer's own copy.

| SKU | Manufacturer's rating | SAP remark | `products.json` today | US variant in circulation |
|---|---|---|---|---|
| **00139** GW-386-BD2 | 120 V/1610 W ; **230 V/2020 W** | 220-240 V/50 Hz, 2020 W ✔ | 230 V, 2020 W ✔, **no Hz** | VEVOR RB-386-BD2 — US NEMA 5-15 plug in VEVOR's own photo |
| **00140** GW-386-B | 120 V/1450 W ; **230 V/1900 W** | 220-240 V/50 Hz, 1900 W ✔ | 230 V, 1900 W ✔, **no Hz** | VEVOR RV-386-B — US plug |
| **00141** GW-FRP286-BV | RP286-BV family: 120 V/1610 W ; **230 V/2020 W** | 220-240 V/50 Hz, **1900 W** ✗ | 230 V, 2020 W ✔, **no Hz** | VEVOR FRP286-BV — spec image states **1450 W**, US plug in hero shot |

### Verdict

**No US-market voltage or frequency currently sits on any of the three listings.** The one that did —
00141's `1450 W`, flagged in July — has since been corrected to `2020 W`, and that fix is confirmed
correct against Goodwill's own catalogue.

Three live issues remain:

1. **All three omit the frequency.** Goodwill and SAP both say **50 Hz**. An electrician sizes a
   circuit off that, and its absence is exactly the gap a 60 Hz figure walked into last time.
2. **⚠ SAP now carries the wrong wattage on 00141: `1900 W`** — that is the **GW-386-B's** 230 V
   figure, cross-row contamination inside SAP. Goodwill rates the RP286-BV family at **2020 W** at
   230 V. `products.json` is right; **SAP is wrong on this row**. Restoring from SAP would under-rate
   the circuit by 120 W.
3. **Every dimension and weight figure now in these records came from VEVOR (US).** The US listing is
   the de-facto source of record for this brand, and the 120 V column sits one row from every number
   that was taken.

---

## 3. The codes — which is the manufacturer's?

**Both are manufacturer-side; neither is a Sheffield house code.**

- **`GW-…` = Guangdong Goodwill's own catalogue code.**
- **`RB-386` / `RV-386` / `FRP-286BV` = the OEM / white-label export codes** the same factory ships
  under, resolving on VEVOR as `RB-386-BD2`, `RV-386-B`, `FRP286-BV`.

Our parentheticals each **drop or mangle the suffix** — `RB-386` → `RB-386-BD2`, `RV-386` →
`RV-386-B`, `FRP-286BV` → `FRP286-BV`.

| SKU | Goodwill code | Published where | OEM code |
|---|---|---|---|
| 00139 | `GW-386-BD2` | **catalogue p.04-05 only** | `RB-386-BD2` |
| 00140 | `GW-386-B` | website + catalogue | `RV-386-B` |
| 00141 | `GW-FRP286-BV` | **nowhere** — nearest is `GW-RP286-BV` | `FRP286-BV` |

**The `F` is a faucet — now proven visually.** Goodwill's own `GW-RP286-BV` photo shows a control
panel with Power / 2 L / 2.5 L / Boiling / Filling / Push-to-brew and **no faucet**; VEVOR's
`FRP286-BV` photos show the identical panel **plus a red "WARNING HOT WATER" lever** front-left.
Goodwill's `GW-DFRB-286` uses the same `F` and its description says "With water faucet". Confidence
**High** (was Low-Medium).

**A/B on the 386:** `AD2` = plastic filter basket, `BD2` = SS304. Otherwise identical. Our SAP remark
says SS304 — we have the **B**.

---

## 4. ⭐ Dimensions — all three are wrong, and 00141 is wrong outright

VEVOR publishes, for each OEM variant, a **dimensioned drawing with the arrows on the axes**. It is
the only labelled-axis dimension source in this brand, and it lives in an image — invisible to text
scraping.

| SKU | Drawing (front / deep / tall) | Real W × D × H | `products.json` L/W/H | Verdict |
|---|---|---|---|---|
| 00139 | 8.07″ / 15.94″ / 17.91″ | **205 × 405 × 455** | 405 / 205 / 455 | ✗ length↔width swapped |
| 00140 | 7.99″ / 15.94″ / 20.87″ | **203 × 405 × 530** | 405 / 203 / 530 | ✗ length↔width swapped |
| 00141 | 9.25″ / 19.88″ / 27.28″ | **235 × 505 × 693** | 437 / 207 / 620 | ✗ wrong on all three axes |

Under the house convention (`length` = frontal width, `width` = depth) these should read
**205/405/455**, **203/405/530**, **235/505/693**.

**On 00141, VEVOR contradicts itself**: its text spec row says `437 × 207 × 620 mm`, its own drawing
on the same page says `235 × 505 × 693 mm`. Our record took the text row. Believe the drawing — its
693 mm height corroborates Goodwill's own 705 mm for the RP286-BV; 620 corroborates nothing.

⚠ **Goodwill's own `Size:` strings vary in order too.** Testing each against the machine it
describes: GW-CB-02A1 `202x418x420` = W×D×H; GW-DFRB-286 `406x400x510` = W×D×H; GW-RP286-BV
`308x455x705` = W×D×H; but **GW-386-B `203x527x405` = W×H×D** — 527 is the *height*. That is the one
of our three for which Goodwill publishes a size, and a naive read would have put the height at
405 mm instead of 530.

**Unresolved:** Goodwill's `308 × 455 × 705` (RP286-BV) vs VEVOR's `235 × 505 × 693` (FRP286-BV).
Heights agree; width and depth do not. Most likely Goodwill measures the shipped assembly including
the dispenser stand, whose feet splay wider than the brewer body.

---

## 5. Two disputed figures, both resolved

- **Brew time on 00140 → 8 minutes, our record is right.** July left it disputed (VEVOR's banner says
  9 minutes). **Goodwill says 8 minutes** on both its website and in the 2023 catalogue. VEVOR is the
  outlier.
- **Dispenser capacity on 00141 → 2.5 L, our record is right.** VEVOR's spec image says
  `1.2 gal / 4.5 L`; Goodwill says `1x2.5L`. **The photographs settle it** — the black Kinox
  dispenser's printed sight gauge runs 0.5 to **2.5 L** and stops, in Goodwill's *and* VEVOR's own
  photos.

Also worth not over-claiming: VEVOR's banners say "**201** stainless steel body" while Goodwill says
"**304** stainless steel". Our copy claims 304 for the *basket*, which Goodwill supports; the
housing may well be 201.

---

## 6. Imagery

Staged in `products resorce final\goodwill\`. **37 files, every one rendered.**

**Two ceiling corrections, both material:**

1. **VEVOR: 1000×1000 is not the ceiling.** The gallery serves `goods_img_big-v1`/`-v2` at 1000×1000;
   replacing that path segment with **`original_img-v2`** returns **1600×1600** (1600×2000 for tall
   banners). Reusable on any future VEVOR sourcing.
2. **Goodwill's own site is better: 1920×1920.** Images sit on an OSS CDN at
   `https://aimg8.dlssyht.cn/u/2194250/product/<n>/<id>_<ts>.jpg`; strip any
   `?x-oss-process=image/resize,…` query for the original.

**⚠ 12 AI-generated files found**, all VEVOR marketing banners. VEVOR runs one synthetic scene
template across the range with the machine swapped in. Tells: merged fingers where a model grips a
cup, glowing orange liquid rendered inside an **opaque** black vessel, generic AI café backgrounds.
In each case the **machine is a real photograph composited into a synthetic scene**, so they keep
evidentiary value — one is where VEVOR states "2.5L Thermal Carafe", contradicting its own spec
table. Moved to `_ai-generated\`, not deleted.

**Perceptual duplicate sweep** (16×16 ahash → 256×256 greyscale RMS): **no shared photographs**, not
even between the RB-386-BD2 and RV-386-B sets, which share a cabinet.

| SKU | Files | Exact variant | Best | State |
|---|---|---|---|---|
| 00139 | 8 + catalogue | 7 of 8 | 1920×1920 | **sourced** |
| 00140 | 8 | 8 of 8 | 1920×1920 | **sourced** |
| 00141 | 9 | 7 of 9 | 1600×2000 exact / 1920×1920 representative | **sourced** |

**Documents:** the 2023 catalogue only. **No manual or datasheet exists for any of the three** —
Goodwill's `/dom/down_list.php` area holds the catalogue and nothing else.

---

## 7. Recommended changes, in priority order (nothing applied)

1. **Add `220-240 V / 50 Hz` to all three records.** Currently only the voltage is stated and the
   frequency is absent. Cheapest, highest-safety change in the brand.
2. **Fix the dimension fields:**
   - `IMG/COF/00139`: `405 / 205 / 455` → **`205 / 405 / 455`**
   - `IMG/COF/00140`: `405 / 203 / 530` → **`203 / 405 / 530`**
   - `IMG/COF/00141`: `437 / 207 / 620` → **`235 / 505 / 693`** (all three axes wrong)
   Update the `technical_specification` prose to match.
3. **Do NOT restore 00141's power from SAP.** SAP says 1900 W; the correct 230 V figure is
   **2020 W**, which `products.json` already holds.
4. **Do NOT "correct" 00140's brew time to 9 minutes** or 00141's dispenser to 4.5 L. Both VEVOR
   figures are wrong; our records are right.
5. **Consider completing the OEM parentheticals** — `RB-386` → `RB-386-BD2`, `RV-386` → `RV-386-B`,
   `FRP-286BV` → `FRP286-BV`. These sit inside `model_number`, so **approval required**.
6. **Soften the 304-stainless claim on the housing** (Goodwill says 304 for the basket; VEVOR says
   201 for the body).

---

## 8. Sources

https://www.goodwill-kitchen.com/
https://www.goodwill-kitchen.com/pro_25797619_7293628_7711897_1.html
https://www.goodwill-kitchen.com/pro_53731347.html
https://www.goodwill-kitchen.com/pro_53731409.html
https://www.goodwill-kitchen.com/pro_53731426.html
https://www.goodwill-kitchen.com/pro_53731669.html
https://www.goodwill-kitchen.com/dom/down_list.php?username=erinyang11&channel_id=26029976
https://www.vevor.com/electric-coffee-grinder-c_11786/12-cups-commercial-drip-coffee-maker-with-2-glass-carafes-and-2-warmers-office-p_010676617182
https://www.vevor.com/electric-coffee-grinder-c_11786/12-cups-commercial-drip-coffee-maker-with-thermal-carafe-restaurant-office-cafe-p_010915863780
https://www.vevor.com/electric-coffee-grinder-c_11786/vevor-commercial-drip-coffee-maker-16-17-cups-machine-with-2-5-l-thermal-carafe-keep-warm-for-4-hours-stainless-steel-brewer-with-auto-water-filling-for-restaurant-office-coffee-shop-home-p_010919733799
https://bayanuae.com/product/american-coffee-machine-selver-rb-386/
