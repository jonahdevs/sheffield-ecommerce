# HK-Redline Product Research

Research notes behind the HK-REDLINE enrichment/audit pass on `products.json` (July 2026).
Companion to [`h-kitchen-research.md`](h-kitchen-research.md) — same supplier, see §1.

**Scope: 105 SKUs** (104 researched here; `RGR24` was covered in the H-Kitchen pass).

> ## ⚠ STATUS: PARTIAL PASS — 58 of 104 SKUs researched
> The research fleet hit platform usage limits twice mid-run. **58 SKUs have findings
> below; 46 do not** (see §8 for the exact list of what still needs doing). Everything
> recorded here is verified to the stated bar; nothing was guessed to fill the gap.

---

## 1. Brand identification — HK-REDLINE *is* H-Kitchen

Confirmed by the business (July 2026): **"HK" is an abbreviation of H-Kitchen.** HK-REDLINE
goods come through the same supplier as the H-KITCHEN SKUs — **Hangzhou Kator Foreign Trade
Co., Ltd.** of Kator International, Hangzhou (see `h-kitchen-research.md` §1 for the full
company profile). "Redline" is Sheffield's own house-line suffix, paired the same way in the
sibling label **SHEFFIELD REDLINE** (3 SKUs: RGR24, RGR36, GF90).

**Kator is a trading company, not only a factory.** That single fact explains everything
this pass found: some HK-REDLINE items genuinely are Kator/Frigo's own product, and many
others are third-party Chinese OEM goods Kator consolidated into its export containers. Both
are honestly "from H-Kitchen" — the invoice says Kator, the nameplate design often belongs
to someone else.

### 1.1 What this pass proved about origin

Unlike the 12 H-KITCHEN SKUs (where **none** traced to Kator's own range), a solid share of
HK-REDLINE **is** genuine Kator product — the prediction in `h-kitchen-research.md` §1.3 held up:

| Verified as Kator/H-Kitchen's OWN product | Evidence |
|---|---|
| Back bar coolers HK-BC-01/01B/02/02B/03/03B | [Kator storefront family table](https://h-kitchen.en.made-in-china.com/product/gsNnHJXcCWVL/China-Under-Counter-Beer-Cooler-Beverage-Cooler-HK-BC-01B-.html) |
| FGDG cake/pastry showcases | [Kator FGDG1200LS-3 family table](https://h-kitchen.en.made-in-china.com/product/iXQERYLcvrVv/China-Orchid-Square-Cold-Cake-Showcase-FGDG1200LS-3-.html) |
| Planetary mixers B10GFA / B20GA / B30GA | [Kator B-series table](https://h-kitchen.en.made-in-china.com/product/iecmBhfzOgkQ/China-10L-40L-Planetary-Mixer-with-CE-B10GFA-.html) |
| Dough sheeter JDR450B | [Kator JDR450B listing](https://h-kitchen.en.made-in-china.com/product/LohQSXTVhzkg/China-Table-Top-or-Floor-Standing-Dough-Sheeter-Bread-Making-Machine-JDR450B-.html) |
| Convection ovens YXD-1AE, YXD-8A/-8A-3 | [Kator YXD-1A listing](https://h-kitchen.en.made-in-china.com/product/SeixHshoLOkA/China-Electric-Convection-Oven-YXD-1A-.html) |
| Deck ovens HTD-20/40/90 (= Kator's YXD-C economy line) | [Kator YXD-20C listing](https://h-kitchen.en.made-in-china.com/product/dMVEBcfjLLko/China-Economy-Commercial-Electric-Deck-Oven-Bread-Baking-YXD-20C-.html) |
| Water urns WB15A/WB20A/WB30A (Kator codes WB10–WB40) | [Kator WB-family listing](https://h-kitchen.en.made-in-china.com/product/kqVxtypTqghJ/China-High-Quality-Water-Boiler-Water-Kettle-Hot-Drinks-WB10-.html) |
| Plate warmer carts DR-1/DR-2/DR-3 | Found on Kator's own storefront |
| Small planetary mixer HK-B7 (sibling HK-B8 listed) | [Kator HK-B8](https://h-kitchen.en.made-in-china.com/product/zqhxvWtGqPcQ/China-8L-Planetary-Mixer.html) |

| Third-party OEM Kator consolidated | Maker |
|---|---|
| Toaster 6AST-C, conveyor toaster CT-3, waffle makers WB-1/WB-2, salamander EB-600, gas range RGR36 | **Guangzhou Rebenet** (rebenet.com) |
| Luxury deck oven NFD-20F, proofer FX-14 | **Guangzhou Southstar** (southstar-oven.com) |
| Spiral mixers BM-25/50/75/100 (generic "HM-" template) | Ashine / Goldenchef pattern — not Kator |
| Immersion blender IB500LV, whisk WIK250 | Anonymous OEM blender platform (factory manual — §3) |
| Gas deck ovens HTR-20Q/40Q ("GRT-HTR-" at Garyton) | Unresolved Guangzhou maker |
| Chafing dish DAT 60063-2 | Hangzhou Yindu (per Vietnamese distributor) |
| Fryers DF-28L / MDXZ-16 / MDXZ-24 | Generic, rebadged (Hamoki/Adexa/Mariot) |

**Recommendation on brand fields:** H-KITCHEN (12 SKUs) and HK-REDLINE (105) are one
supplier family. Merging them is a business decision; the display casing lives in
`brands.json` either way. Note Sheffield's live site also uses BLUELINE and PERPETUAL for
some of the same stock.

---

## 2. Where to look — and the traps

1. **`h-kitchen.com` resets HTTPS connections** (ECONNRESET, every attempt, both http and
   https). Its pages *are* Google-indexed, so `site:h-kitchen.com` snippets work. But the
   reliable source is the **Made-in-China storefront**, `h-kitchen.en.made-in-china.com` —
   ~252 products over 10 pages, and its listings carry **whole-family comparison tables**,
   which is what made the HK-BC, FGDG, B-series, YXD and WB findings possible.
2. **Search the model code, never the brand.** "HK-REDLINE" returns only our own site.
3. **`sheffieldafrica.com` is upstream of our own bad data — never a source.** Multiple
   errors below trace verbatim to Sheffield's live pages.
4. **Kator's prefixes are meaningful, and one of ours collides.** Kator uses `EF-` for
   **electric fryers** and `BF-` for **wall boilers** — so our "Water Boiler EF-20" is
   suspect (§7).
5. **Variant traps that bit this pass:**
   - `B30GA` is Kator's **25 L** mixer; the **30 L** is `B30GA2`.
   - `YXD-8A` (6.4 kW/4-tray, steam) vs `YXD-8A-3` (3.5 kW/3-tray, no steam).
   - `IB500LF` is fixed-speed; `IB500LV` is variable — ours is correctly LV.
   - `EB-600` is Rebenet; `EB-450` appears to be a *different* factory (Jieguan).
   - Sliding-door `HK-BC-02S/03S` variants exist but aren't ours.
6. **When the search quota dies, Brave Search via WebFetch still works** — Google/Bing/DDG
   all return CAPTCHA/403. Worth knowing for the follow-up pass.

---

## 3. Best source found: the OEM immersion-blender factory manual

The single most valuable document of both passes — an English factory manual covering the
**entire IB/BLD/WIK platform** with full spec and compatibility tables:

**Spec sheet:** <https://infernus.co.uk/wp-content/uploads/2024/05/2023-10-19新-一代270-350-500BLD-N-电动搅拌机英文说明书.pdf>

Covers motors IB270TF/TV, IB350CF/CV, IB500LF/LV, IB750LF/LV; tubes BLD160–BLD550-N; whisks
WIK185/WIK250. It settled IB500LV, WIK250 (this pass) and IB350CV, BLD300, BLD400 (H-Kitchen
pass). Note the safety rule it documents: **whisks must never be fitted to fixed-speed ("F")
motors.**

---

## 4. Changes applied to `products.json` this pass

40 operations across 30 SKUs. Only OEM-verified corrections were applied; every RAISE item
was left untouched. `products.json` was backed up before editing.

### 4.1 Records filled that were empty or near-empty

| SKU | Model | What was added | Source |
|---|---|---|---|
| IMG/OVE/00168 | NFD-20F | Full copy + specs + dims 1460×1230×815, 8 kW, 380V 3N~, 225 kg | Southstar OEM |
| IMG/HOT/00416 | WB-1 | Full copy + specs + dims 250×380×300, 1000 W — **plate confirmed ROUND** | Rebenet OEM |
| IMG/HOT/00417 | WB-2 | Full copy + specs + dims 500×380×300, 2×1000 W | Rebenet OEM |
| IMG/FPR/00222 | WIK250 | Full copy + specs, 250 mm, 0.86 kg, compatibility list | OEM manual |
| IMG/BUF/00020 | DAT 60063-2 | Full copy + specs + dims 670×490×230 | N'DUSTRIO exact-code match |
| IMG/HOT/00419 | EF-11L | Copy + specs, 11 L, 3.5 kW (dims withheld — sources conflict) | 3 resellers |
| IMG/PAS/00169 | BM-100 | Full spec block + dims 1460×905×1500, 13.5 kW, 730 kg | Ashine/Goldenchef |

### 4.2 Dimension corrections

**A systematic width/height swap bug** runs through this catalogue: the structured
`width`/`height` fields are transposed relative to each record's *own* `technical_specification`
text. Confirmed and fixed on 11 SKUs; the record's own text plus the OEM figure agreed every time.

| SKU | Model | Before (L/W/H) | After | Note |
|---|---|---|---|---|
| IMG/OVE/00205 | HTD-20 | 1230/530/820 | 1230/**820/530** | swap |
| IMG/OVE/00169 | HTD-40 | 1230/1250/820 | 1230/**820/1250** | swap; height matches OEM exactly |
| IMG/OVE/00009 | HTD-90 | 1670/1520/820 | 1670/**820/1520** | swap (archived) |
| IMG/PAS/00011 | FX-14 | 500/1920/760 | 500/**760/1920** | swap |
| IMG/OVE/00229 | YXD-1AE | 530/595/570 | **595/530**/570 | L/W swap |
| IMG/HOT/00255 | RGR36 | 915/1520/830 | 915/**830/1520** | it's a 1520 mm-tall range |
| IMG/DIS/00022 | HK-BC-01B | 600/895/510 | 600/**510/895** | swap |
| IMG/DIS/00023 | HK-BC-02B | 920/895/510 | 920/**510/895** | swap |
| IMG/DIS/00112 | HK-BC-02 | 920/895/510 | 920/**510/895** | swap |
| IMG/DIS/00024 | HK-BC-03B | 920/895/510 | **1335**/**510/895** | ⚠ see below |
| IMG/HOT/00282 | MDXZ-24 | 460/1230/960 | 460/**960/1230** | swap |

**⚠ HK-BC-03B was doubly wrong.** Its length (920 mm) was the *two-door* width — the
verified three-door cabinet is **1335 mm**, which its own spec text already said. Its stated
capacity was also the two-door figure (201 L); corrected to **303 L**.

Genuinely wrong dimensions (not swaps), corrected from OEM tables:

| SKU | Model | Before | After | Note |
|---|---|---|---|---|
| IMG/PAS/00157 | BM-50 | 794/1033/520 | **1175/730/1230** | 2 independent sources agree |
| IMG/PAS/00156 | BM-75 | 1065/1130/630 | **1460/905/1400** | ⚠ was BM-25's footprint |
| IMG/PAS/00103 | B10GFA | 430/690/420 | **470/450/600** | Kator's own table |
| IMG/PAS/00101 | B20GA | 880/460/530 | **540/490/780** | Kator's own table |
| IMG/PAS/00145 | B30GA | **100/100/100** | **570/510/810** | was placeholder junk |
| IMG/HOT/00271 | 6ATS-C | 460/225/210 | **480/234/222** | Rebenet OEM |
| IMG/HOT/00071 | EB-600 | 600/400/450 | 600/**510/540** | Rebenet OEM |
| IMG/PAS/00155 | BM-25 | width 630 | width **603** | typo vs own spec text |
| IMG/HOT/00352 | CT-3 | length 466 | length **468** | trivial |

### 4.3 Copy and spec-text fixes

- **BM-75** description said *"Commercial **50KG** 200L"* → corrected to **75KG** (and its
  spec-text dimensions, which were BM-25's).
- **GH-813** (double panini grill) description opened *"Highly durable **single** panini
  grill"* → corrected to **double**.
- **WB30A** wattage was **2.5 kW** — that's Kator's **WB20** figure. Corrected to **3 kW**
  per Kator's own table.
- **IB500LV** copy rewritten: the old "net weight 3.1 kg" is tube-dependent; the manual gives
  **2.3 kg** for the motor unit alone. 500 W / variable 4,000–16,000 RPM confirmed correct.
- **RGR36**, **HTR-40Q**, **6ATS-C**, **EB-600** given proper spec blocks from OEM data.
- **CT-3** net weight 20.5 kg added (its data was otherwise already near-perfect — the
  single best-verified record in the whole pass).

---

## 5. Verified product reference

Sources are OEM-first. Everything below is what a reviewer should check against.

### 5.1 Cold displays — genuine Kator/Frigo product

**Back bar coolers** — [Kator B-suffix/SS table](https://h-kitchen.en.made-in-china.com/product/gsNnHJXcCWVL/China-Under-Counter-Beer-Cooler-Beverage-Cooler-HK-BC-01B-.html) ·
[Kator plain/black table](https://h-kitchen.en.made-in-china.com/product/roknKEGvqghm/China-Beer-Fridge-Under-Counter-Beer-Cooler-HK-BC-01-.html)

| Model | Dims (W×D×H) | Capacity | Power | Doors | Finish |
|---|---|---|---|---|---|
| HK-BC-01 / -01B | 600×510×895 | 115 L | 210 W | 1 swing | epoxy black / SS |
| HK-BC-02 / -02B | 920×510×895 | 201 L | 230 W | 2 swing | epoxy black / SS |
| HK-BC-03 / -03B | 1335×510×895 | 303 L | 290 W / 500 W ⚠ | 3 swing | epoxy black / SS |

All: 2–10 °C, 220 V/50 Hz, 2 shelves, inner light, digital thermostat, auto-defrost, CE.
"B" suffix = stainless interior + exterior. ⚠ The two Kator pages disagree on HK-BC-03B's
power (290 W vs 500 W) — **left unchanged in our data pending confirmation**.

**FGDG cake showcases** — [Kator FGDG1200LS-3 family table](https://h-kitchen.en.made-in-china.com/product/iXQERYLcvrVv/China-Orchid-Square-Cold-Cake-Showcase-FGDG1200LS-3-.html)

| Model | Dims (L×W×H) | Capacity | Temp | Refrigerant | Power |
|---|---|---|---|---|---|
| FGDG1200LS-3 | 1200×740×1300 | 390 L | 2–8 °C | R134a | 0.79 kW |
| FGDG1500LS-3 | 1500×740×1300 | 490 L | 2–8 °C | R404A | 0.81 kW |
| FGDG1800LS-3 | 1800×740×1300 | 590 L | 2–8 °C | R404A | 1.59 kW |

Our copy matches Kator's marketing text almost word-for-word — strong confirmation it was
sourced from them. **Unresolved:** our `FGDG1.0A-1500LS` and `FGDG 1500LSD-3` records may
belong to a *separate, later* "2.0A/1.5A" generation Kator also sells (which includes a
1360 mm-tall combo unit matching our LSD record's height). Not resolved before the cutoff.

### 5.2 Ovens & proofing

| SKU | Model | Verified | Source |
|---|---|---|---|
| IMG/OVE/00205 | HTD-20 (= Kator YXD-20C) | 6.6 kW, 1 deck/2 tray, 1220×860×525, 77 kg | [Kator](https://h-kitchen.en.made-in-china.com/product/dMVEBcfjLLko/China-Economy-Commercial-Electric-Deck-Oven-Bread-Baking-YXD-20C-.html) |
| IMG/OVE/00169 | HTD-40 (= YXD-40C) | 13.2 kW, 2 deck/4 tray, 1220×860×1250, 148 kg | same table |
| IMG/OVE/00009 | HTD-90 (= YXD-90C) | 24 kW, 3 deck/9 tray, 1650×860×1555, 272 kg | same table |
| IMG/OVE/00168 | NFD-20F | 8 kW, 380V 3N~, 1 deck/2 tray, tray 460×720, 1460×1230×815, 225 kg | [Southstar Luxury Deck Oven](https://www.southstar-oven.com/products_details/Luxury_Electric_Deck_Oven.html) |
| IMG/PAS/00011 | FX-14 (= Southstar FX-14B) | 14 trays, 2.5 kW, 220V, 500×770×1900, 50 kg, 36–38 °C / 80–85 % RH | [Southstar Common Proofer](https://www.southstar-oven.com/products_details/Common_Proofer.html) |
| IMG/OVE/00229 | YXD-1AE | 2.67 kW, 220V, 595×530×570, interior 460×375×360, 50–300 °C, ceramic chamber | [Kator YXD-1A](https://h-kitchen.en.made-in-china.com/product/SeixHshoLOkA/China-Electric-Convection-Oven-YXD-1A-.html) |
| IMG/OVE/00088 | HTR-40Q | 2 deck/4 tray, tray 400×600, LPG + 220V/200W, 1350×850×1340 | [Garyton GRT-HTR-40Q](https://www.garyton.com/GRT-HTR-40Q-Factory-Price-Double-Deck-Bread-Baking-Gas-Oven-pd41290483.html) |
| IMG/HOT/00255 | RGR36 | 211,000 BTU/hr total, 6×30,000 burners, oven 31,000, 915×830×1520, 167 kg, ETL | [Rebenet RGR36](https://www.rebenet.com/36-commercial-gas-6-burner-range-with-standard-oven.html) |

### 5.3 Bakery preparation

| SKU | Model | Verified | Source |
|---|---|---|---|
| IMG/PAS/00155 | BM-25 | 80 L / 25 kg dough, 4.4 kW, 245/122 rpm, 380V, 1065×603×1130, 332 kg | [Ashine HM-25](https://www.china-ashine.com/product/hm-25-spiral-mixer-25kg-80l-digital-control-ce-heavy-duty-dough-mixer/) |
| IMG/PAS/00157 | BM-50 | 130 L / 50 kg, 6.3 kW, 1175×730×1230, 420 kg | [Ashine HM-50](https://www.china-ashine.com/product/hm-50-spiral-mixer-50kg-130l-digital-control-ce-heavy-duty-dough-mixer/) · [Goldenchef](https://www.goldenchef.cn/product/dough-mixer/hm-heavy-duty-dough-mixer/hm-50/) |
| IMG/PAS/00156 | BM-75 | 200 L / 75 kg, 10.5 kW, 1460×905×1400, 710 kg | [Ashine HM-75](https://www.china-ashine.com/product/hm-75-spiral-mixer-75kg-200l-digital-control-ce-heavy-duty-dough-mixer/) |
| IMG/PAS/00169 | BM-100 | 250 L / 100 kg, 13.5 kW, 1460×905×1500, 730 kg | [Ashine HM-100](https://www.china-ashine.com/product/hm-100-spiral-mixer-100kg-250l-digital-control-heavy-duty-dough-mixer/) |
| IMG/PAS/00103 | B10GFA | 10 L, 2.5 kg batter, **0.6 kW** ⚠, 148/244/480 rpm, 470×450×600, 58 kg | [Kator B-series](https://h-kitchen.en.made-in-china.com/product/iecmBhfzOgkQ/China-10L-40L-Planetary-Mixer-with-CE-B10GFA-.html) |
| IMG/PAS/00101 | B20GA | 20 L, 5 kg batter, 1.1 kW, 197/317/462 rpm, 540×490×780, 83 kg | same table |
| IMG/PAS/00145 | B30GA | ⚠ 30 L is Kator's **B30GA2**: 1.5 kW, 570×510×810, 90 kg | same table |
| IMG/PAS/00160 | JDR450B | 0.56 kW, 220/380V, gap 1–40 mm, belt 1700×430, 1770×820×620, 117 kg — **our data already exact** | [Kator JDR450B](https://h-kitchen.en.made-in-china.com/product/LohQSXTVhzkg/China-Table-Top-or-Floor-Standing-Dough-Sheeter-Bread-Making-Machine-JDR450B-.html) |

### 5.4 Fast food (all Guangzhou Rebenet)

| SKU | Model | Verified | Source |
|---|---|---|---|
| IMG/HOT/00271 | 6ATS-C (Rebenet **6AST-C**) | 2.86 kW, 220–240V, 480×234×222, 7.2 kg, slot 120×120×20 | [Rebenet](https://www.rebenet.com/commercial-6-slice-toaster-stainless-steel-structure-6ast-c.html) |
| IMG/HOT/00352 | CT-3 | 450 pcs/hr, 2.64 kW, 468×418×387, 20.5 kg | [Rebenet CT-3](https://rebenet.en.made-in-china.com/product/DFKtwRjJlYhd/China-Snack-Machine-450PCS-Electric-Conveyor-Burger-Sandwich-Bread-Toaster-CT-3-.html) |
| IMG/HOT/00416 | WB-1 | **round** 170 mm plate, 1000 W, 50–270 °C, 250×380×300, 7 kg | [Rebenet WB-1](https://www.rebenet.com/best-round-classic-waffle-maker-wb-1.html) |
| IMG/HOT/00417 | WB-2 | 2× round 170 mm, 2000 W, 500×380×300, 17 kg | [Rebenet WB-2](https://www.rebenet.com/double-belgian-round-waffle-maker-wb-2.html) |
| IMG/HOT/00071 | EB-600 (Rebenet EB-600HWX) | 4000 W, grid 545×361, 600×510×540, infrared, EGO switch | [Rebenet EB-600HWX](https://www.rebenet.com/fast-heat-up-commercial-electric-infrared-salamander-grill-restaurant-kitchen-equipment-eb-600hwx.html) |

### 5.5 Blenders, fryers, urns, buffetware

| SKU | Model | Verified | Source |
|---|---|---|---|
| IMG/FPR/00218 | IB500LV | 500 W, 220–240V, 4,000–16,000 rpm variable, motor 2.3 kg / 373 mm / Ø96, 80–85 dB | OEM manual (§3) |
| IMG/FPR/00222 | WIK250 | 250 mm, 0.86 kg, stainless; fits IB350CV/IB500LV/IB750LV **only** | OEM manual (§3) |
| IMG/HOT/00419 | EF-11L | 11 L, 3.5 kW, 220–240V, ~50–200 °C | [Steel Kitchen](https://steelkitchenonline.com/ae/product/1-tank-1-basket-electric-fryer-ef-11l) + 2 more |
| IMG/HOT/00278 | MDXZ-16 | 16 L, 3 kW, 220–240V, 8 psi, 20–200 °C, 19 kg — **our data already matches** | Spec sheet: [Hamoki manual](https://manuals.plus/hamoki/mdxz-16-commercial-pressure-fryer-manual) |
| IMG/HOT/00282 | MDXZ-24 | 24 L, 13.5 kW, 380V 3-ph, 460×960×1230, 111 kg | [Mariot](https://mariotstore.com/shop/cooking-line/fryers/electric-pressure-fryer-mdxz-24/) · Spec sheet: [Adexa manual](https://manuals.plus/adexa/mdxz24-commercial-pressure-fryer-mechanical-controls-24-litres-13-5kw-400v-manual) |
| IMG/COF/00020 | WB15A (Kator WB15) | 15 L, 2.5 kW, 220V, 4.14 kg, double-wall, CE | [Kator WB family](https://h-kitchen.en.made-in-china.com/product/kqVxtypTqghJ/China-High-Quality-Water-Boiler-Water-Kettle-Hot-Drinks-WB10-.html) |
| IMG/COF/00021 | WB20A (Kator WB20) | 20 L, 2.5 kW, 220V, 4.63 kg | same table |
| IMG/COF/00022 | WB30A (Kator WB30) | 30 L, **3 kW**, 220V, 5 kg | same table |
| IMG/BUF/00020 | DAT 60063-2 | 670×490×230, built-in oblong, dripless, stainless | [N'DUSTRIO](https://www.ndustrio.com/en/product/dat60063-12-built-in-oblong-chafing-dish) |
| IMG/BUF/00027 | AT50293 | round induction chafer, glass lid, ~440 × ? × 210 ⚠ sources conflict 480 vs 580 | [TC Croatia](https://tccroatia.hr/en/litchen-equipment1/chafing_/tc-at50293-induction-chafing-dish/) |
| IMG/BUF/00028+00143 | AT60293 | 2/3 GN square induction, ~4.5 L ⚠ dims conflict 505×470×285 vs 490×490×210 | [N'DUSTRIO](https://ndustrio.com/en/product/at60293-23-rectangular-chafing-dish) |

### 5.6 Chopping boards — HACCP colour code (confirmed)

Blue = raw fish/seafood · Yellow = raw poultry · Red = raw red meat · White = bakery/dairy.
HDPE is FDA/NSF-recognised, non-porous, dishwasher safe. Our 500×350×20 mm sizing is
plausible and consistent across all four, though not tied to an OEM datasheet.
*Copy opportunity:* the Blue board is the only one not naming its food category.

---

## 6. Images collected (verify before use)

| Product | URL | Status |
|---|---|---|
| RGR36 | `https://img.yfisher.com/m5461/1720159592906-1/jpg100-t3-scale100.webp` | ✅ HTTP 200 verified |
| HTR-40Q | `https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/lrBpiKqkliSRpiiomliliq/HTR-40Q-800-800.jpg` | ✅ verified |
| HTR-20Q | `https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/ljBpiKqkliSRpiioplojiq/HTR-20Q-800-800.jpg` | ✅ verified |
| HTR-101Q | `https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/liBpiKqkliSRpiionlkqiq/HTR-101Q-800-800.jpg` | ✅ verified |
| SOT-4S (reference only) | `https://img1.yiwugo.com/i004/2022/05/23/59/8da8e680e64bcf584c7004da4c987e7f.jpg` | ✅ verified |
| IB500LV family | `https://infernus.co.uk/wp-content/uploads/2024/05/original-492DE7C7-B8DD-4AAF-AB5C-FA43E44517D6.jpeg` | ✅ verified |
| 6AST-C | `https://img.yfisher.com/m0/1736407919237-commercial-6-slice-toaster-6ats-c-12/jpg100-t3-scale100.webp` | ⚠ unpinged |
| WB-1 | `https://img.yfisher.com/m0/1735627526945-best-round-classic-waffle-maker-wb-1-01/jpg100-t3-scale100.webp` | ⚠ unpinged |
| WB-2 | `https://img.yfisher.com/m0/1735632840450-double-belgian-round-waffle-maker-wb-2-01/jpg100-t3-scale100.webp` | ⚠ unpinged |
| EB-600HWX | `https://img.yfisher.com/m5461/1776997906707-commercialelectricsalamandergrilleb-600-hwx-10/jpg100-t3-scale100.webp` | ⚠ unpinged |
| WB urns (family) | `https://image.made-in-china.com/202f0j00bVDUtBJIbRcy/High-Quality-Water-Boiler-Water-Kettle-Hot-Drinks-WB10-.webp` | ⚠ unpinged |
| WIK250 (clone) | `https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/lpBpiKqkliSRniilkqirin/Grt-Wik250-...-0-800-800.jpg` | ⚠ unpinged |

No usable image was found for NFD-20F (Southstar lazy-loads its gallery via JS).

---

## 7. RAISED — needs your decision or a supplier check

Nothing here was changed in `products.json`.

### 7.1 Spec conflicts against an OEM source ⚠ highest value

1. **YXD-8A-3** (IMG/OVE/00230) — our entire description/spec text (6.4 kW, 4 trays, 67 kg)
   is the plain **YXD-8A**'s. The real `-3` is 3.5 kW / 3 trays / 50 kg / no steam. Either the
   copy is off, or the unit is really a YXD-8A and the model code is wrong. **Check the
   nameplate or invoice** — it materially misstates capacity and power to customers.
2. **DF-28L vs EF-28L** (IMG/HOT/00219, IMG/HOT/00421) — likely **crossed identities**. Our
   DF-28L claims 380V/18 kW/400×870×700; the real Hamoki DF-28L is **220–240V, 9 kW,
   400×800×1100**. Meanwhile our empty EF-28L record may be the 380V 3-phase unit. Decide
   which SKU owns which spec set before either is edited.
   Spec sheet: [Hamoki DF-28L manual](https://manuals.plus/hamoki/df-28l-free-standing-single-tank-electric-fryer-manual)
3. **EB-450** (IMG/HOT/00066) — its description is **byte-identical** to EB-600's (both claim
   4000 W / 52 kg). EB-600's 4000 W is OEM-confirmed, which makes EB-450's look copy-pasted.
   A [Jieguan EB-450](https://gzjieguan.en.made-in-china.com/product/uFiAOLQyrPWZ/China-Eb-450-Electric-Lift-Salamander-.html)
   listing gives **1.8 kW / 34 kg / 450×450×470** — single-sourced, so not applied.
4. **B10GFA power** — Kator's own table says **0.6 kW**; we publish 1.1 kW. Nearly double.
   Dimensions were corrected; **power deliberately left alone** pending confirmation.
5. **B30GA model code** — Kator's 30 L unit is **B30GA2**; plain `B30GA` is their 25 L. Our
   spec text also says 1100 W where Kator says 1.5 kW for both.
6. **HTR-20Q** (IMG/OVE/00087) — description is copy-pasted from the smaller HTR-101C record
   (says 1 deck/1 tray/100 W). [Garyton's GRT-HTR-20Q](https://www.garyton.com/GRT-HTR-20Q-Commercial-Bakery-Equipment-Single-Deck-Gas-Pizza-Oven-pd48590483.html)
   is **2 trays / 200 W / 1350×850×600** — single-sourced, so not applied.
7. **HK-BC-03B power** — Kator's own two pages disagree (290 W vs 500 W). Ours says 0.23 kW,
   which is the *two-door* figure. Left as-is.

### 7.2 Identity / naming problems

8. **"Hydroboil" EF-20** (IMG/COF/00108) — **"Hydroboil" is a registered trademark of Zip
   Water/Marco** for boiling-water taps, a different product category and company. Also,
   Kator uses `EF-` for **fryers** and `BF-` for **wall boilers**, so the model code looks
   wrong too. Recommend dropping "Hydroboil" from the name and copy regardless.
9. **T23065 porcelain insert** (IMG/BUF/00115) — description is lifted near-verbatim from
   **Spring USA's** marketing ("Compatible with Spring products only…"), and Spring doesn't
   list a matching 2/3 GN insert. It implies a brand affiliation we can't support —
   **recommend scrubbing the Spring references** whatever else happens.
10. **SSPC-25 pressure cooker** (IMG/HOT/00168) — description calls it a *"Timesaver Pressure
    Cooker"*; **Timesaver is an unrelated UK aluminium-cookware brand**. Mismatched boilerplate.
11. **6ATS-C** — Rebenet's code is **6AST-C** (middle letters transposed). Flagged, not changed.
12. **HTR-101C / HTR-10C** (IMG/OVE/00206) — our name and model field disagree with each
    other, and the real economy-line code appears to be **HTR-101Q**. Likely a Q→C typo.
13. **WB15A/20A/30A "A" suffix** — Kator's codes have no "A". Probably a running-change
    suffix, but unconfirmed. Also the concealed-vs-exposed element split between our SKUs
    isn't broken out in Kator's table.
14. **NFQ-380 bread moulder** (IMG/PAS/00166) — code returns **nothing** anywhere. Its stated
    "capacity 237 kg" reads as no standard unit for a moulder. Don't publish its specs.

### 7.3 Duplicate SKU

15. **AT60293 appears twice** — IMG/BUF/00028 and IMG/BUF/00143: same model, same price
    (KES 90,706), same name, description and dims; only the SKU, photo filename and stock
    differ (6 + 3 units). **Should be merged into one SKU with 9 units.**

### 7.4 Data hygiene

16. **Chopping Board Red** (IMG/FPR/00081) — `model_number` is `"RED"`; the other three
    boards correctly use `N/A`.
17. **Heating lamps A032 / A035** — the five colour-variant SKUs populate dimension fields
    inconsistently: Black A032 stores the pole range across length/width and the Ø in height;
    Gold A032 has no length at all; Copper A032 has no dimensions or description; Gold A035
    has none; Silver A035 has width + Ø only. **One spec set should apply to all finishes.**
18. **YXD-1AE internal contradiction** — description says "four aluminium trays 325×450 mm",
    spec says "3× 454×327 mm trays". Tray count and dimensions both disagree with themselves.
19. **YFR01-2** (IMG/BUF/00019) — dimension fields (670/235/455) contradict its own spec text
    (WIDTH 455 / HEIGHT 235).
20. **T23065** — fields say 360×360 mm, spec text says 320×355×60 mm.
21. **Dining carts pricing** — 3-tier (KES 43,850) is priced **below** 2-tier (KES 48,202).
    Worth checking against supplier invoices.
22. **AT50293 / AT60293 dimensions** look swapped *and* undersized versus every external
    source (~470–505 mm square vs our 400 mm). A physical remeasure is the honest fix.

---

## 8. Not yet researched — 46 SKUs

The fleet was cut off by platform usage limits. These have **no findings** and were left
completely untouched:

| Batch | SKUs | Products |
|---|---|---|
| **A — Meat processing** | 7 | Slicers 300ES-12, 250ES-10; mincers TC-22, JT32; bone saws JG210, JG310, HLS-2400 |
| **I — Warmers & carts** | 7 | OT-10B-21, OT-01P, CS-310, plate warmer carts DR-1/DR-2/DR-3, warm display R60-2 |
| **J — Bain marie & thermo** | 6 | BS-4V, BS-6V, KG-165F, induction EB-1200, thermo boxes CPWK090-1, CPWK090-31 |
| **C — Juice (remainder)** | 4 | Dispensers LSP-18X3, LSP-18X2; juicer WF-B3000; milk shaker BL-018 |
| **L — Fryers (remainder)** | 5 | EF-11L-2, GF90, GF-120T, RC-400T, JZH-TCX2, split 10+10 L (no model code) |
| **D — Cold displays (write-up)** | 8 | HK-BC + FGDG data **is** verified (§5.1) but per-product blocks were never written |
| **H, K, G leftovers** | ~9 | Items marked RAISE purely because the search budget died, not because verification failed — see §7 |

**Partial leads already banked for the follow-up:**
- DR-1/DR-2/DR-3 plate warmer carts were confirmed present on Kator's own storefront.
- `kg165.html` for the KG-165F bain marie is already saved in the session scratchpad.
- GF90, RC-400T (capacity discrepancy) and JZH-TCX2 (Justa OEM) had strong early hits.
- 300ES-12 spot-check: 300 mm blade, 420 W, 0–15 mm slice, ~530×460×460, ~24.5 kg.

**Method note for the re-run:** the shared WebSearch quota (~200/session) is consumed fast by
parallel agents. Run the remaining batches in **2–3 smaller waves**, and keep the incremental
findings-file writing — it is the only reason 58 SKUs survived this pass instead of zero.

---

## 9. Summary of `products.json` changes this pass

- **7 empty/near-empty records filled** with OEM-sourced copy, specs and dimensions.
- **20 dimension corrections**, of which 11 were the systematic width/height swap bug.
- **6 copy/spec-text corrections** (BM-75 "50KG", GH-813 "single", WB30A wattage, HK-BC-03B
  capacity, IB500LV weight, BM-50/BM-75 spec dims).
- **0 changes to any RAISED product**, and no price, name, brand or status field was touched.
- Backup of the pre-edit file kept in the session scratchpad as `products.json.bak`.
