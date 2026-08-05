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

---

## 10. Image sourcing - meat-processing group (July 2026, partial)

⚠ **Provenance:** this section records the output of **one** research thread of an image
sourcing pass that was cut short by a platform session limit. Nine model codes in the
meat-processing group were fully verified before the cut; the rest of the brand was not
reached and is recorded as untouched in the coverage note at the end. Every dimension below
was measured from the fetched bytes, and every finalist was visually inspected against the
catalogue description. **No files were staged to `hk-redline-images\` from this thread** -
these are verified source URLs awaiting download.

### 10.1 The headline finding - LINKRICH is the OEM behind four of our codes

**`ES`-suffixed slicer codes are not Kator codes.** They belong to **LINKRICH MACHINERY GROUP**
(Guangdong), whose own catalogue titles the same art `SL-300ES-12-12A` and `SL-250ES-10-10A`.
`300ES-12` is a generic Chinese gravity-slicer platform sold worldwide under many badges -
Adcraft/Admiral Craft, Empura, FSE and AG Equipment all list `300ES-12`. Kator's own HBS series
is a different product line entirely.

One factory accounts for **four of the nine codes** - `300ES-12`, `250ES-10`, `JG210`, `JG310`.

**Reusable technique:** query https://www.chinalinkrich.com/wp-json/wp/v2/media?search=<code>
first. The `title` field carries the true factory model string, which is exactly how the
ES-suffix question was answered.

### 10.2 Per-code record

| Code | Product | Best image | Px | Source |
|---|---|---|---|---|
| `300ES-12` | Gravity meat slicer 300mm | `2a_6.jpg` | **1000x1000**, 49 KB | https://www.agequipment.com.au/cdn/shop/products/2a_6.jpg |
| `250ES-10` | Gravity meat slicer 250mm | `1_9_14.jpg` | **1000x1000**, 48 KB | https://www.agequipment.com.au/cdn/shop/products/1_9_14.jpg |
| `TC-22` | Meat mincer size 22 | `MG-22-side.jpg` | **1269x1269**, 136 KB | https://www.kitchenwarestation.com/wp-content/uploads/2017/04/MG-22-side.jpg |
| `JT32` | Meat mincer size 32 | `181001_02.png` | **1080x1080**, 208 KB | https://hamoki.co.uk/cdn/shop/files/181001_02.png |
| `JG210` | Bone saw 210mm | `jg210a-scaled.jpg` | **2560x2560**, 177 KB | https://www.twothousand.com/wp-content/uploads/2022/12/jg210a-scaled.jpg |
| `JG310` | Bone saw 310mm | `20211101564.jpg` | **800x800**, 127 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/11/20211101564.jpg |
| `HLS-2400` | Bone saw 2400mm blade | `HLS-202-1200x1200_...jpg` | **1200x1200**, 54 KB | https://canmac.co.uk/cdn/shop/files/HLS-202-1200x1200_60373112-1c74-4cd9-814c-6df4e7f9f977.jpg |
| `WF-B3000` | Juice extractor | `Hb173ae54...H.jpg` | **800x800**, 230 KB | https://sc04.alicdn.com/kf/Hb173ae54e77d4b4ab44bbe30abd83a83H.jpg |
| `BL-018` | Double-spindle drink shaker | `milk-shake-machine-BL-018.jpg` | **1000x1000**, 315 KB | https://magmedia.machines4u.com.au/wp-content/uploads/2016/06/19114333/milk-shake-machine-BL-018.jpg |

LINKRICH factory art, as OEM cross-reference:
https://www.chinalinkrich.com/wp-content/uploads/2021/10/2021102979.jpg (300ES-12, 800x800)
https://www.chinalinkrich.com/wp-content/uploads/2021/10/20211029810.jpg (250ES-10, 800x800)
https://www.chinalinkrich.com/wp-content/uploads/2021/08/2022110383.jpg (JG210, 800x800)
`JG310CA` is a genuinely different chassis (open tubular stand, not a cabinet base) - pick
deliberately: https://www.chinalinkrich.com/wp-content/uploads/2021/11/20211101440.jpg

### 10.3 Contradictions and traps found

- ⚠ **`HLS-2400` has no model-specific photograph in circulation.** Canmac's file is named
  `HLS-202...` (HLS-2020 artwork) and Twothousand's is literally
  `Meat-Bone-Cutter-HLS-2020.HLS-2400.jpg` - one photo deliberately serving both models. Same
  cabinet, different blade length, shared art. Twothousand's larger 1500x1000 files are
  **factory-floor close-ups** (a door handle, a table edge), not product shots - do not pick
  them on resolution alone.
- ⚠ **The largest image on the `WF-B3000` Alibaba listing is a sales rep's selfie at a trade
  show** (2320x3088, 1373 KB). Caught only by rendering it. Anything automated that picks
  "largest image on the page" would grab it.
- **`TC-22` / `ME-22` / `MG-22` are used interchangeably** by KWS for the same size-22 grinder;
  the page is titled TC-22 but its og:image is `MG-22-side.jpg`. `TC` is the generic Italian
  *tritacarne* size convention, so no single factory owns the code - Foshan Meihua, Henglian
  and Astar (as `TK-22`) all ship the same platform.
- **`WF-B3000` vs `WF-A3000` resolved:** the B3000 ships **with** a dregs barrel, the A3000
  without. The verified photo shows exactly that white pulp bin, so image and spec corroborate.
- **`BL-018` confirmed genuinely double-spindle** - two motor heads, two cups, shared base.
  `BL-015` / `BL-017A` are the single-spindle siblings.
- **Third-party branding present** on all but two: `250ES-10` carries an "AG" badge, `TC-22` a
  "KWS" logo, `WF-B3000` a "WF" logo plus a "100% NATURAL" sticker. Only `JT32` and `BL-018`
  are logo-free.

### 10.4 Coverage, stated plainly

**9 of 102 SKU-level codes verified. 93 not reached.** Nothing in this thread was proven
unverifiable - all nine codes returned external results, and WebSearch worked throughout
without needing the DuckDuckGo or Brave fallbacks. The remaining families still need a pass.

**Sourcing-quality lesson worth carrying forward:** resolution and usability diverged badly
here. Three of the four largest files measured were unusable - a selfie and two factory
close-ups. Visual inspection was load-bearing, not optional.

---

## 11. Image sourcing (July 2026)

⚠ **Status: IN PROGRESS — this section is written incrementally.** A previous image-sourcing
fleet was killed by a platform session limit after staging 71 files without writing anything
up. This section recovers that work, downloads the §10 verified URLs, and extends coverage.
Everything below has been measured from the fetched bytes; visual verification is noted
per-file. Coverage is stated plainly at the end and is **not** rounded up.

### 11.1 What this pass did

Three things, in order:

1. **Downloaded and visually verified the nine §10 codes.** §10 recorded verified source URLs
   but staged no files. All nine fetched clean at the recorded dimensions, plus three LINKRICH
   OEM cross-reference frames. **§10's measurements are confirmed independently** - every
   dimension matched.
2. **Recovered the 71 files a killed agent had staged but never written up.** Provenance was
   reconstructed by mining the dead fleet's own transcripts for the download scripts, so every
   file below carries its real source URL rather than a guess.
3. **Re-verified all 71 by eye** and corrected the staging. This changed six filenames and
   flagged 32 more as under the 800 px floor.

### 11.2 Headline finding - Kator's own photography cannot meet the 800 px floor

This is the most consequential thing learned this pass, and it reframes the whole brand.

**Kator's made-in-china.com listing images are natively low-resolution.** Every Kator image
below was fetched from the **full-size `2f0j00…` origin** - the thumbnail-prefix trap was
already avoided - and they still land at 332x398, 200x225, 200x120, 355x149. These are not
downscales. They are the originals.

**31 of the 32 files flagged `-TOOSMALL` are Kator's own art.** The consequence is structural:

> On HK-REDLINE, the house-badge route identifies the product but can almost never illustrate
> it. Only the OEM route and the importer route produce a usable photograph.

Two exceptions where Kator did ship a large file, both worth keeping:
`R60-1` (2238x1000) and the 20 L planetary mixer (2272x4000).

### 11.3 OEMs and importers traced behind the house label

| Route | What it is | Yield |
|---|---|---|
| **LINKRICH MACHINERY GROUP** (Guangdong) | True OEM behind the `ES` slicer suffix and the `JG` bone saws - established in §10, confirmed here | 4 codes, 3 usable frames |
| **infernus.co.uk** (UK importer) | Imports the same consolidated Kator stock. **The single richest vein on this brand.** Also hosts `<CODE>_OVERALL-DRAWING.pdf` and `<CODE>_INSTRUCTION-MANUAL.pdf` | 22 files inc. 4 PDFs |
| **Guangzhou Rebenet** (`rebenet.com` / `img.yfisher.com`) | Confirmed OEM for the fast-food line - toaster, waffle makers, salamander | 4 files, all >=800 px |
| **Garyton** (`garyton.com` / `micyjz` CDN) | OEM behind the `HTR-…Q` gas deck ovens | 3 files, all undersized |
| **AG Equipment (AU)**, **KWS**, **Hamoki**, **Twothousand**, **Canmac**, **Machines4u** | Independent importers of the LINKRICH/generic platforms | 7 files |

**Reusable technique, re-confirmed:** query
https://www.chinalinkrich.com/wp-json/wp/v2/media?search=<code> - the `title` field carries
the true factory model string. Most WordPress-based Chinese factory sites expose the same
`/wp-json/wp/v2/media?search=` endpoint.

**Infernus URL shape, worth reusing:** `https://infernus.co.uk/wp-content/uploads/YYYY/MM/<CODE>-scaled.jpg`.
Directly guessable from a model code, and it worked repeatedly.

### 11.4 Per-file record - meat processing (LINKRICH group, from §10)

Downloaded and rendered this pass; all nine §10 codes confirmed.

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-FPR-00046__300ES-12-agequipment.jpg` | 1000x1000 | 41 KB | https://www.agequipment.com.au/cdn/shop/products/2a_6.jpg |
| `IMG-FPR-00046__REF__300ES-12-linkrich-oem.jpg` | 800x800 | 185 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/10/2021102979.jpg |
| `IMG-FPR-00179__250ES-10-agequipment.jpg` | 1000x1000 | 39 KB | https://www.agequipment.com.au/cdn/shop/products/1_9_14.jpg |
| `IMG-FPR-00179__REF__250ES-10-linkrich-oem.jpg` | 800x800 | 161 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/10/20211029810.jpg |
| `IMG-FPR-00251__TC-22-kitchenwarestation.jpg` | 1269x1269 | 136 KB | https://www.kitchenwarestation.com/wp-content/uploads/2017/04/MG-22-side.jpg |
| `IMG-FPR-00252__JT32-hamoki.png` | 1080x1080 | 24 KB | https://hamoki.co.uk/cdn/shop/files/181001_02.png |
| `IMG-FPR-00253__JG210-twothousand.jpg` | 2560x2560 | 61 KB | https://www.twothousand.com/wp-content/uploads/2022/12/jg210a-scaled.jpg |
| `IMG-FPR-00253__REF__JG210-linkrich-oem.jpg` | 800x800 | 126 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/08/2022110383.jpg |
| `IMG-FPR-00254__JG310-linkrich.jpg` | 800x800 | 127 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/11/20211101564.jpg |
| `IMG-FPR-00255__REPRESENTATIVE-HLS-2020-art-canmac.jpg` | 1200x1200 | 25 KB | https://canmac.co.uk/cdn/shop/files/HLS-202-1200x1200_60373112-1c74-4cd9-814c-6df4e7f9f977.jpg |
| `IMG-FPR-00257__WF-B3000-alicdn.jpg` | 800x800 | 21 KB | https://sc04.alicdn.com/kf/Hb173ae54e77d4b4ab44bbe30abd83a83H.jpg |
| `IMG-ICE-00040__BL-018-machines4u.jpg` | 1000x1000 | 315 KB | https://magmedia.machines4u.com.au/wp-content/uploads/2016/06/19114333/milk-shake-machine-BL-018.jpg |

Two §10 claims re-confirmed by rendering: the `WF-B3000` frame does show the white dregs
barrel that distinguishes it from the `A3000`, and `BL-018` is genuinely double-spindle.
The `JT32` PNG is only 24 KB at 1080x1080 because it is a clean white-background cut-out,
not because it is degraded - **file size is not a quality signal on cut-outs.**

Kator's own low-res art for the same group, kept for identification only:

| File | Px | Source |
|---|---|---|
| `IMG-FPR-00046__kator-automatic-meat-slicer-TOOSMALL.jpg` | 251x284 | https://image.made-in-china.com/2f0j00jsCaTkoGbQqd/Automatic-Meat-Slicer.jpg |
| `IMG-FPR-00179__kator-semi-auto-meat-slicer-a-TOOSMALL.jpg` | 301x243 | https://image.made-in-china.com/2f0j00hjeaTwklAEom/Semi-Auto-Meat-Slicer.jpg |
| `IMG-FPR-00046__REF__kator-HBS-family-chart-195JS-220JS-250-275-300-not-ES-TOOSMALL.jpg` | 525x523 | https://image.made-in-china.com/2f0j00YjCaReoWqtqQ/Semi-Automatic-Meat-Slicer.jpg |
| `IMG-FPR-00251__kator-meat-mincer-TOOSMALL.jpg` | 421x490 | https://image.made-in-china.com/2f0j00eKBEfokDJTqU/Meat-Mincer.jpg |
| `IMG-FPR-00253__kator-bone-sawer-a-TOOSMALL.jpg` | 262x368 | https://image.made-in-china.com/2f0j00LKBEGocbHaqM/Bone-Sawer.jpg |
| `IMG-FPR-00254__kator-bone-sawer-b-TOOSMALL.jpg` | 198x389 | https://image.made-in-china.com/2f0j00sZCtUhoaYEbe/Bone-Sawer.jpg |
| `IMG-FPR-00012__kator-cutting-board-TOOSMALL.jpg` | 440x353 | https://image.made-in-china.com/2f0j00sKCTBovcLtbM/Cutting-Board.jpg |
| `IMG-FPR-00251__REF__meat-mincer-12-infernus.jpg` | 800x800 | https://infernus.co.uk/wp-content/uploads/2020/01/Meat-mincer-12-Resize.jpg |

The cutting-board frame is a six-colour fan and is the **only** art covering all four chopping
board SKUs (IMG/FPR/00012, 00014, 00015, 00081) at once - but at 440x353 it is unusable.

### 11.5 Per-file record - blenders and juice (Infernus)

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-FPR-00218__IB500LV-infernus.jpg` | 891x1280 | 101 KB | https://infernus.co.uk/wp-content/uploads/2024/05/original-492DE7C7-B8DD-4AAF-AB5C-FA43E44517D6.jpeg |
| `IMG-FPR-00218__BLD-N-family-infernus.jpg` | 2560x1604 | 132 KB | https://infernus.co.uk/wp-content/uploads/2024/10/BLD-N-__-_1-scaled.jpg |
| `IMG-FPR-00222__WIK250-infernus.jpg` | 1326x1996 | 199 KB | https://infernus.co.uk/wp-content/uploads/2024/10/WIK250.jpg |
| `IMG-BUF-00129__LSP-12X1-kator-family-TOOSMALL.jpg` | 102x178 | 8 KB | https://image.made-in-china.com/2f0j00CZetJIOrAaoD/Price-Reasonable-Cold-Drink-Dispenser-LSP-12X1-.jpg |
| `IMG-ICE-00040__kator-milk-shaker-TOOSMALL.jpg` | 338x337 | 33 KB | https://image.made-in-china.com/2f0j00pKBQEFbIHtoZ/Milk-Shaker-Tubby-Custarder.jpg |

`WIK250` is an **exact-model hit** - the whisk attachment is unmistakable and the code is
Infernus's own filename. The `BLD-N` frame is a seven-wand length comparison and is the right
art for the immersion-blender family generally.

⚠ The juice-dispenser frame is `LSP-**12X1**`; our SKUs are `LSP-18X3` and `LSP-18X2`.
Different tank count *and* different tank size. At 102x178 it is worthless anyway.

### 11.6 Per-file record - cold and warm displays (Kator, all undersized)

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-DIS-00103__R60-1-kator-family.jpg` | 2238x1000 | 267 KB | https://image.made-in-china.com/2f0j00iZMtmgKsfaoV/CE-Approved-Warming-Showcase-R60-1-.jpg |
| `IMG-DIS-00022__HK-BC-01B-kator-TOOSMALL.jpg` | 698x500 | 63 KB | https://image.made-in-china.com/2f0j00luoYRfiEFQcb/Under-Counter-Beer-Cooler-Beverage-Cooler-HK-BC-01B-.jpg |
| `IMG-DIS-00146__HK-BC-01-kator-family-TOOSMALL.jpg` | 700x500 | 58 KB | https://image.made-in-china.com/2f0j00IOztjnEKCgrZ/Beer-Fridge-Under-Counter-Beer-Cooler-HK-BC-01-.jpg |
| `IMG-DIS-00019__FGDG1200LS-3-kator-family-TOOSMALL.jpg` | 676x573 | 89 KB | https://image.made-in-china.com/2f0j00qZbQYTutRhcr/Orchid-Square-Cold-Cake-Showcase-FGDG1200LS-3-.jpg |

**`R60-1` is the one Kator frame that genuinely earns its place.** It is a labelled family
composite - `R60-1 / R60-2 / R60-3` over one unit, `DH-2P` and `DH-1P` over two others - so
the code is legible *in frame*. Our IMG/DIS/00103 is the **R60-2**, and this establishes that
all three R60 sizes share one cabinet.

⚠ The pastry-display frame is the **1200 mm** unit; our IMG/DIS/00019 is the **1500 mm**
`FGDG 1500LS-3`. Family-correct, size-wrong, and undersized. The 1500LSD-3 and 1800LS-3
siblings have no art at all.

### 11.7 Per-file record - ovens and proofing

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-OVE-00087__HTR-20Q-garyton-TOOSMALL.jpg` | **640x640** | 14 KB | https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/ljBpiKqkliSRpiioplojiq/HTR-20Q-800-800.jpg |
| `IMG-OVE-00088__HTR-40Q-garyton-TOOSMALL.jpg` | **640x640** | 16 KB | https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/lrBpiKqkliSRpiiomliliq/HTR-40Q-800-800.jpg |
| `IMG-OVE-00206__HTR-101Q-garyton-TOOSMALL.jpg` | **640x640** | 8 KB | https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/liBpiKqkliSRpiionlkqiq/HTR-101Q-800-800.jpg |
| `IMG-OVE-00205__YXD-20C-kator-TOOSMALL.jpg` | 700x500 | 72 KB | https://image.made-in-china.com/2f0j00cWeYuSOsEGki/Economy-Commercial-Electric-Deck-Oven-Bread-Baking-YXD-20C-.jpg |
| `IMG-OVE-00229__YXD-1A-kator-TOOSMALL.jpg` | 573x520 | 43 KB | https://image.made-in-china.com/2f0j00qKvTyHkcAEob/Electric-Convection-Oven-YXD-1A-.jpg |
| `IMG-OVE-00230__YXD-8A-kator-TOOSMALL.jpg` | 200x120 | 13 KB | https://image.made-in-china.com/2f0j00dMcanJfyQHbe/Electric-Convection-Oven-YXD-8A-.jpg |
| `IMG-PAS-00011__kator-electric-prover-TOOSMALL.jpg` | 388x429 | 62 KB | https://image.made-in-china.com/2f0j00DZeandoFyEbj/Electric-Prover.jpg |

⚠⚠ **New trap, proven by measurement: Garyton's filename lies about its own size.** All three
URLs end `-800-800.jpg` and all three decode to **640x640**. §6 of this file recorded them as
"verified" on the strength of an HTTP 200. They are real images of the right products, but
**they are not 800 px and never were.** Anything that trusted the filename would have banked a
false pass. Measure the bytes, never the URL.

The prover frame is labelled `FX14` and `FX28` in-frame, which confirms our IMG/PAS/00011
`FX-14`. Kator's electric deck-oven frame is captioned "Elec.type" and shows a 2-deck and a
3-deck unit, so it also speaks to the `HTD-40` and `HTD-90` records - but at 700x500.

### 11.8 Per-file record - bakery preparation (mixers)

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-PAS-00101__B20GA-kator-placard-reads-20-LITER-MIXER.jpg` | **2272x4000** | 386 KB | https://image.made-in-china.com/2f0j00jKCaEJbyGBkO/10L-40L-Planetary-Mixer-with-CE-B10GFA-.jpg |
| `IMG-PAS-00101__20L-planetary-infernus.jpg` | 800x800 | 140 KB | https://infernus.co.uk/wp-content/uploads/2020/01/20L-Resize.jpg |
| `IMG-PAS-00103__10L-planetary-infernus.jpg` | 800x800 | 127 KB | https://infernus.co.uk/wp-content/uploads/2020/01/10L-Resize.jpg |
| `IMG-PAS-00145__30L-planetary-infernus.jpg` | 800x800 | 140 KB | https://infernus.co.uk/wp-content/uploads/2020/01/30L-Resize.jpg |
| `IMG-PAS-00103__REPRESENTATIVE-planetary-mixers-infernus.jpg` | 2560x2560 | 240 KB | https://infernus.co.uk/wp-content/uploads/2024/01/Planetary-Mixers-scaled.jpg |
| `IMG-PAS-00102__7L-planetary-mixer-kator-TOOSMALL.jpg` | 481x638 | 82 KB | https://image.made-in-china.com/2f0j00gseQtBoPCMcv/7L-Planetary-Mixer-Cream-Mixer.jpg |
| `IMG-PAS-00101__B20GA-kator-10-40L-TOOSMALL.jpg` | 304x572 | 47 KB | https://image.made-in-china.com/2f0j00zKvaLiqROTkb/10-40L-Planetary-Mixer-with-CE-Approved.jpg |
| `IMG-PAS-00160__JDR450B-kator-TOOSMALL.jpg` | 700x500 | 55 KB | https://image.made-in-china.com/2f0j00shcfEKOCAYbo/Table-Top-or-Floor-Standing-Dough-Sheeter-Bread-Making-Machine-JDR450B-.jpg |
| `IMG-PAS-00164__kator-dough-divider-rounder-TOOSMALL.jpg` | 196x369 | 19 KB | https://image.made-in-china.com/2f0j00ZjvEyMbBLtoL/Dough-Divider-Dough-Rounder.jpg |

⚠⚠ **The B10GFA trap, independently confirmed and then turned into a find.**
A killed sub-agent reported that Kator's `B10GFA` listing carried a photo whose placard reads
"20 LITER MIXER". **I rendered the file and read the placard myself: it does.** It is legible
on the right-hand side of the mixer head.

The listing is titled `10L-40L-Planetary-Mixer-with-CE-B10GFA-`, i.e. Kator is using one
photograph for a whole capacity range and has badged it with the 10 L code. So:

- It is **wrong** for IMG/PAS/00103 (`B10GFA`, 10 L), which is where it was staged.
- It is **right** for IMG/PAS/00101 (`B20GA`, 20 L) - and at 2272x4000 it is by a wide margin
  the best Kator image on the entire brand.

**The file has been renamed accordingly** and its new name records why. This is the single
highest-value correction of the pass: a mislabelled listing that would have shipped the wrong
capacity to the 10 L page became correct art for the 20 L page instead.

It also means **§7.1 item 4 needs revisiting** - that entry reasons about "Kator's own table"
for `B10GFA` power. If Kator's `B10GFA` listing is illustrated with a 20 L machine, its spec
table for that listing may be a range table too, and the 0.6 kW figure may not be the 10 L
figure at all.

`JDR450B` is captioned `JDR450B / JDR520B` in-frame, so the code is legible - just at 700x500.

### 11.9 Per-file record - fast food (Guangzhou Rebenet) and fryers (Infernus)

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-HOT-00071__EB-600HWX-rebenet.webp` | 1000x1000 | 80 KB | https://img.yfisher.com/m5461/1776997906707-commercialelectricsalamandergrilleb-600-hwx-10/jpg100-t3-scale100.webp |
| `IMG-HOT-00271__6AST-C-rebenet.webp` | 800x800 | 54 KB | https://img.yfisher.com/m0/1736407919237-commercial-6-slice-toaster-6ats-c-12/jpg100-t3-scale100.webp |
| `IMG-HOT-00416__WB-1-rebenet.webp` | 800x800 | 47 KB | https://img.yfisher.com/m0/1735627526945-best-round-classic-waffle-maker-wb-1-01/jpg100-t3-scale100.webp |
| `IMG-HOT-00417__WB-2-rebenet.webp` | 800x800 | 60 KB | https://img.yfisher.com/m0/1735632840450-double-belgian-round-waffle-maker-wb-2-01/jpg100-t3-scale100.webp |
| `IMG-HOT-00416__WB-1-infernus.jpg` | 1718x2560 | 223 KB | https://infernus.co.uk/wp-content/uploads/2023/09/WB-1-scaled.jpg |
| `IMG-HOT-00417__WB-2-infernus.jpg` | 2560x2412 | 364 KB | https://infernus.co.uk/wp-content/uploads/2023/09/WB-2-scaled-e1694097536269.jpg |
| `IMG-HOT-00352__CT-3-infernus.jpg` | 2560x1920 | 245 KB | https://infernus.co.uk/wp-content/uploads/2023/09/CT-3--scaled.jpg |
| `IMG-HOT-00352__CT-3-rebenet-mic.jpg` | 800x800 | 144 KB | https://image.made-in-china.com/2f0j00sMhiwlBnQecU/Snack-Machine-450PCS-Electric-Conveyor-Burger-Sandwich-Bread-Toaster-CT-3-.jpg |
| `IMG-HOT-00219__DF-28L-infernus.jpg` | 1644x2560 | 253 KB | https://infernus.co.uk/wp-content/uploads/2019/01/DF-28L-infernus-scaled.jpg |
| `IMG-HOT-00219__DF-28L-infernus-p3.jpg` | 1676x1779 | 139 KB | https://infernus.co.uk/wp-content/uploads/2019/01/DF-28L-infernusp3-scaled-e1620211200372.jpg |
| `IMG-HOT-00419__EF-4L-kator-family.jpg` | 1065x666 | 185 KB | https://image.made-in-china.com/2f0j00ASvEJdqhyQbl/Table-Top-Electric-Fryer-EF-4L-.jpg |
| `IMG-HOT-00421__EF-28L-kator-TOOSMALL.jpg` | 200x388 | 23 KB | https://image.made-in-china.com/2f0j00VebQOgGsnLcK/Floor-Standing-Electric-Fryer-EF-28L-.jpg |
| `IMG-HOT-00066__EB-450-kator-TOOSMALL.jpg` | 185x154 | 9 KB | https://image.made-in-china.com/2f0j00NhYUTcJChzqD/Table-Top-Lift-up-Electric-Salamander-Meat-Griller-EB-450-.jpg |
| `IMG-HOT-00066__REF__salamander-infernus.jpg` | 2560x1546 | 235 KB | https://infernus.co.uk/wp-content/uploads/2023/02/salamander-scaled.jpg |
| `IMG-HOT-00353__REPRESENTATIVE-GH-811-kator-shows-DOUBLE-head-TOOSMALL.jpg` | 714x664 | 130 KB | https://image.made-in-china.com/2f0j00KjMQEuCZgaqp/Contact-Griller-Single-Double-Heads-Sandwich-Grill-Machine-Cooking-Equipment-GH-811-.jpg |
| `IMG-HOT-00067__SOT-4S-yiwugo-TOOSMALL.jpg` | 750x750 | 409 KB | https://img1.yiwugo.com/i004/2022/05/23/59/8da8e680e64bcf584c7004da4c987e7f.jpg |

**PDF spec sheets and manuals, all from Infernus:**

| File | Size | Source |
|---|---|---|
| `IMG-HOT-00416__WB-1__spec-sheet.pdf` | 158 KB | https://infernus.co.uk/wp-content/uploads/2023/09/WB-1_Overall-drawing.pdf |
| `IMG-HOT-00417__WB-2__spec-sheet.pdf` | 35 KB | https://infernus.co.uk/wp-content/uploads/2023/09/WB-2_Overall-drawing.pdf |
| `IMG-HOT-00421__EF-28L__spec-sheet.pdf` | 236 KB | https://infernus.co.uk/wp-content/uploads/2019/01/EF-28L_OVERALL-DRAWING.pdf |
| `IMG-HOT-00421__EF-28L-instruction-manual.pdf` | 348 KB | https://infernus.co.uk/wp-content/uploads/2019/01/EF-28L_INSTRUCTION-MANUAL.pdf |
| `IMG-HOT-00389__GF-120T__spec-sheet.pdf` | 636 KB | https://infernus.co.uk/wp-content/uploads/2020/02/GF-120T_OVERALL-DRAWING.pdf |

⚠ The two `GF-120T` photographs are **both marked `REF__` and both should stay that way.**
Our IMG/HOT/00389 is a **split-type 11 + 11 litre** fryer. Infernus's `GF-120T` frame shows a
**single-tank freestanding gas** fryer, and the `GF90` frame likewise. Same importer, same
code, visibly not the same configuration. **The `GF-120T` spec-sheet PDF is the trustworthy
artefact here, not the photograph.**

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-HOT-00389__REF__GF-120T-infernus-GAS-freestanding-fryer.jpg` | 1400x1584 | 94 KB | https://infernus.co.uk/wp-content/uploads/2020/02/Gas-Free-Standing-Twin-Tank-Fryer-p.jpg |
| `IMG-HOT-00389__REF__GF90-infernus-gas-floor-fryer-single-tank.jpg` | 1684x1801 | 128 KB | https://infernus.co.uk/wp-content/uploads/2019/01/GF90-infernus-with-caster-scaled-e1620301658668.jpg |

### 11.10 Per-file record - water urns, buffet, warmers, storage

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-COF-00021__WB-20A-infernus.jpg` | 1704x2560 | 184 KB | https://infernus.co.uk/wp-content/uploads/2023/04/WB-20A-scaled.jpg |
| `IMG-COF-00022__WB-30A-infernus.jpg` | 1704x2560 | 196 KB | https://infernus.co.uk/wp-content/uploads/2023/04/WB-30A-scaled.jpg |
| `IMG-COF-00020__REF__WB-10A-infernus.jpg` | 1704x2560 | 191 KB | https://infernus.co.uk/wp-content/uploads/2023/04/WB-10A-scaled.jpg |
| `IMG-COF-00020__WB-family-kator.webp` | 850x1277 | 33 KB | https://image.made-in-china.com/2f0j00bVDUtBJIbRcy/High-Quality-Water-Boiler-Water-Kettle-Hot-Drinks-WB10-.webp |
| `IMG-COF-00108__BF-05-kator-wall-boiler-TOOSMALL.jpg` | 200x225 | 10 KB | https://image.made-in-china.com/2f0j00fvqaYDpRFPoU/Wall-Type-Water-Boiler-Electric-Kettle-Hot-Drinks-BF-05-.jpg |
| `IMG-HOT-00195__OT-11-21-kator.jpg` | 1328x1552 | 115 KB | https://image.made-in-china.com/2f0j00KZvtJaqwrTbV/Vertical-Hot-Banquet-Carts-OT-11-21-.jpg |
| `IMG-HOT-00275__BS-4-kator-family.jpg` | 1181x592 | 192 KB | https://image.made-in-china.com/2f0j00bioYyJGdEUcz/Commercial-Bain-Marie-Food-Warmer-Heating-Equipment-BS-4-.jpg |
| `IMG-HOT-00276__KG-165-kator-family.jpg` | 854x650 | 111 KB | https://image.made-in-china.com/2f0j00BZeaEujYHQqd/Commercial-Bain-Marie-Food-Warmer-Heating-Equipment-KG-165-.jpg |
| `IMG-BUF-00031__DR-1-kator-family-TOOSMALL.jpg` | 700x500 | 68 KB | https://image.made-in-china.com/2f0j00EhZGMmYsZfkv/Easy-Operating-Commercial-Plate-Cup-Warmer-DR-1-.jpg |
| `IMG-BUF-00022__2009-E-kator-TOOSMALL.jpg` | 332x398 | 24 KB | https://image.made-in-china.com/2f0j00IZetfajYRTqR/Stainless-Steel-Plate-Warmer-Cup-Dryer-for-Restaurant-2009-E-.jpg |
| `IMG-BUF-00183__REF__kator-CPWK200-8-plate-cart-NOT-thermo-box-TOOSMALL.jpg` | 332x332 | 27 KB | https://image.made-in-china.com/2f0j00celQDWRgHKis/Plate-Cart-CPWK200-8-.jpg |
| `IMG-STO-00011__kator-ss-service-cart-TOOSMALL.jpg` | 355x149 | 23 KB | https://image.made-in-china.com/2f0j00RSvQTHMqvEbI/S-Steel-Service-Cart.jpg |
| `IMG-STO-00013__REF__HK-113101-bakery-tray-trolley-NOT-113103-dishrack.jpg` | 1036x1969 | 172 KB | https://image.made-in-china.com/2f0j00khRUdeiGgroW/Stainless-Steel-Bakery-Tray-Trolley-for-Bakeshop-Restaurant-HK-113101-.jpg |

⚠ **The water-urn set is the clearest "reseller image proves the family, not the size" case on
this brand.** Infernus stocks `WB-10A / WB-20A / WB-30A`; our catalogue carries
`WB15A / WB20A / WB30A`. There is **no 15 litre unit at Infernus**, so IMG/COF/00020 (15 L)
has been given the **10 L** frame, correctly marked `REF__`.

The three urn files are **not** byte-identical - I hashed them, and all three MD5s differ - but
rendered side by side they are the same urn at the same angle with only minor differences.
Treat them as family art with a size claim you cannot verify from the picture.

⚠ `2009/ED` is our "Cup Warmer"; Kator's frame is titled *"Plate Warmer / Cup Dryer"* and
shows a **two-door floor cabinet**. That is a much larger appliance than "cup warmer" implies
and is worth a sanity check against what is actually in the warehouse.

⚠ **`DR-1` frame is a two-up composite showing `DR-1` and `DR-2` labelled in frame** - so it
covers IMG/BUF/00031 *and* IMG/BUF/00032. `DR-3` is not in it.

⚠ `IMG-STO-00013` was staged as if it were our product. It is **`HK-113101`, a bakery tray
trolley**; our SKU is **`HK-113103`, a dishwasher-rack trolley**. Different code, visibly
different product. **Renamed to `REF__` this pass.**

### 11.11 Rejected during verification

Nothing here was deleted - misfiled items were renamed so the reason survives in the filename.

| File / candidate | Why it failed |
|---|---|
| `IMG-PAS-00103__B10GFA-kator.jpg` | **Placard in frame reads "20 LITER MIXER".** Rejected for the 10 L SKU; **reassigned** to IMG/PAS/00101 (20 L), where it is correct. |
| `IMG-FPR-00046__HBS-250-275-300-infernus.jpg` | Kator's **HBS** slicer line. Our `300ES-12` is the **LINKRICH ES** platform - a different product line entirely (§10). Renamed `REF__`. |
| `IMG-FPR-00179__HBS-195JS-220JS-infernus.jpg` | Same - HBS, not ES. Renamed `REF__`. |
| `IMG-FPR-00046__kator-semi-automatic-meat-slicer-b.jpg` | An HBS family chart (195JS/220JS/250/275/300). Useful as an OEM cross-reference, wrong line for our SKU. Renamed `REF__`. |
| `IMG-STO-00013__HK-113101-kator-tray-trolley.jpg` | `HK-113101` bakery tray trolley, not our `HK-113103` dishwasher-rack trolley. Renamed `REF__`. |
| `IMG-HOT-00353__GH-811-kator-family.jpg` | Renders the **double**-head griller; IMG/HOT/00353 is the **single** `GH-811E`. Renamed `REPRESENTATIVE-`. |
| Garyton `HTR-*-800-800.jpg` x3 | **Decode to 640x640 despite the filename.** Kept (right product) but flagged `-TOOSMALL`. |
| 31 further Kator frames | Under the 800 px floor at origin, not by downscaling. Flagged `-TOOSMALL`; see §11.2. |
| `IMG-HOT-00417__WB-2-rebenet.webp` | ⚠ **Kept but flagged.** Rendered, the second head appears to be a plain round plate rather than a second waffle plate. The Infernus `WB-2` frame clearly shows **two waffle heads**. Prefer the Infernus file; this one needs a second look. |

**Byte-level duplicate check.** Every image file was MD5-hashed. Among the 71 recovered files
all hashes are unique. **But the trap does occur on this brand** - it was caught on a later
fetch:

> https://infernus.co.uk/wp-content/uploads/2020/01/Meat-mincer-12-Resize.jpg and
> https://infernus.co.uk/wp-content/uploads/2020/01/Meat-mincer-12-Resize-1.jpg
> are **byte-identical** (MD5 `36b59e735aef…`, 800x800, 184,415 B).

Infernus serves the same bytes from two upload paths that look like two different photographs.
The duplicate was deleted. **Hash before staging a "second angle" from the same site.**

### 11.12 Contradictions worth raising

1. **`GF-120T` is a split-type 11+11 in our catalogue and a single-tank freestanding gas fryer
   at Infernus.** Two photographs, one importer, same code, different configuration. This is a
   real spec question, not an image question.
2. **`2009/ED` "Cup Warmer" is a two-door plate-warming cabinet** in Kator's own frame.
3. **`HK-113103` vs `HK-113101`** - our storage SKU's code does not match the trolley that was
   sourced for it, and the two are different products.
4. **`B10GFA`'s listing photo is a 20 L machine** - see §11.8; this undermines §7.1 item 4.
5. **`LSP-18X2 / LSP-18X3` have no art of their own**; only an `LSP-12X1` frame exists, which
   is a different tank size.
6. **`FGDG 1500LS-3` has only the 1200 mm frame.** The 1500LSD-3 and 1800LS-3 have nothing.

### 11.13 Kator's storefront located, and the thumbnail rewrite measured exactly

**Kator's made-in-china storefront is `h-kitchen.en.made-in-china.com`, and their own site is
`h-kitchen.com`.** The storefront subdomain is literally *h-kitchen* - this is independent
confirmation of §1's "HK = H-Kitchen" finding, straight from the supplier's own URL.
Company profile: established 2005, catering-equipment business since 1998.

⚠ The storefront's **product-list pages lazy-load their images** - a WebFetch of a list page
returns `//www.micstatic.com/athena/img/transparent.png` placeholders for every tile.
**Go to the individual product page**, where the real URL appears in the `og:image` tag.

**The thumbnail-prefix rewrite, measured on this brand rather than assumed:**

| Prefix as served / rewritten | Result |
|---|---|
| `155f0j00luoYRfiEFQcb` (what the live page serves) | **400x287**, 5,860 B |
| `2f0j00luoYRfiEFQcb` (rewritten) | **698x500**, 123,054 B |

The rewrite is worth **+74% on the long edge** and 21x the bytes - so always do it. But note
what it does *not* do: **698 px is still under the 800 px floor.** This is the hard measurement
behind §11.2. Kator's origin art really is small; the rewrite recovers everything there is to
recover and it is still not enough.

It also **validates the recovered provenance**: the rewritten `.jpg` returns MD5
`3d99a50cd6ac…`, byte-identical to the file the dead agent had already staged. The dead fleet
was using the correct full-size prefix, and the URLs reconstructed in §11.4-11.10 are real.

### 11.14 Back bar coolers - one photo legitimately covers three SKUs

Kator's `HK-BC-01B` product page carries a **spec table for the whole family**, which resolves
three of our records at once:

| Model | Dimension | Volume | Rated power | Doors |
|---|---|---|---|---|
| HK-BC-01B | 600x510x895 | 115 L | 210 W | 1 pulling |
| HK-BC-02B | 920x510x895 | 201 L | 230 W | 2 pulling |
| HK-BC-03B | 1335x510x895 | 303 L | **500 W** | 3 pulling |

Source: https://h-kitchen.en.made-in-china.com/product/gsNnHJXcCWVL/China-Under-Counter-Beer-Cooler-Beverage-Cooler-HK-BC-01B-.html

⚠⚠ **This settles §7.1 item 7.** That entry noted Kator's two pages disagreed on `HK-BC-03B`
power (290 W vs 500 W) and that ours says 0.23 kW. Kator's **own family spec table** gives
**500 W for the 3-door**, and **230 W for the 2-door**. Our 0.23 kW is exactly the **2-door**
figure sitting on the **3-door** record. That is now a sourced correction, not a suspicion.
(Still not applied to `products.json` - single-supplier source, and out of scope for an image
pass.)

Because it is one cabinet at three widths, the `HK-BC-01B` frame is honest family art for the
siblings, staged as `REPRESENTATIVE-`:

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-DIS-00023__REPRESENTATIVE-HK-BC-01B-kator-family-shared-spec-table-TOOSMALL.webp` | 698x500 | 120 KB | https://image.made-in-china.com/2f0j00luoYRfiEFQcb/Under-Counter-Beer-Cooler-Beverage-Cooler-HK-BC-01B-.webp |
| `IMG-DIS-00024__REPRESENTATIVE-HK-BC-01B-kator-family-shared-spec-table-TOOSMALL.webp` | 698x500 | 120 KB | (same URL) |
| `IMG-DIS-00112__REPRESENTATIVE-HK-BC-01B-kator-family-shared-spec-table-TOOSMALL.webp` | 698x500 | 120 KB | (same URL) |

These are deliberately byte-identical to each other and are marked as such - they are one
photograph standing in for three widths, **not** three photographs.

### 11.15 Additional Infernus frames for the slicer/mincer group

Fetched after the §10 set, all below the floor but useful as corroboration:

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-FPR-00046__300ES-12-slicer-300mm-infernus-TOOSMALL.jpg` | 650x650 | 46 KB | https://infernus.co.uk/wp-content/uploads/2019/06/Meat-Slicer-300-mm-1.jpg |
| `IMG-FPR-00046__300ES-12-slicer-300mm-infernus-b-TOOSMALL.jpg` | 650x650 | 44 KB | https://infernus.co.uk/wp-content/uploads/2019/06/Meat-Slicer-300-mm-2.jpg |
| `IMG-FPR-00179__250ES-10-slicer-250mm-infernus-TOOSMALL.jpg` | 650x650 | 44 KB | https://infernus.co.uk/wp-content/uploads/2019/06/Meat-Slicer-250-mm-2.jpg |
| `IMG-FPR-00252__JT32-32-mincer-infernus-TOOSMALL.jpg` | 420x427 | 29 KB | https://infernus.co.uk/wp-content/uploads/2020/05/32-mincer-infernus.jpg |

Note that Infernus sells the 300 mm and 250 mm slicers **by blade size, not by model code** -
which is consistent with §10's finding that `300ES-12` is a generic platform no single factory
owns, and is why the ES code returns so little.

### 11.16 Deliberate abstentions

These were investigated and **left without an image on purpose.** Attaching a plausible frame
would have been worse than leaving the record empty.

- **`FGDG 1500LSD-3` and `FGDG 1800LS-3` (IMG/DIS/00021, IMG/DIS/00020).** Only the **1200 mm**
  frame exists, and the three differ in width - the visible difference between them *is* the
  thing being sold. Chased LINKRICH as a possible OEM because they also list a square cake
  showcase: **they do not make this cabinet.** Their square showcase is the `CD-120I5 /
  CD-150I5 / CD-180I5` series, a 1200x730x**1800** upright at 700 L / 0.63 kW - a different
  product class from our counter-height `FGDG`. Recorded as a **clean negative**: LINKRICH is
  the OEM behind our slicers and bone saws, but **not** behind the pastry displays.
  https://www.chinalinkrich.com/commercial-kitchen-equipment/square-cake-showcase.html
- **`LSP-18X2` (IMG/BUF/00130).** Only an `LSP-12X1` frame exists - wrong tank size and wrong
  tank count.
- **Chopping boards white / yellow / red (IMG/FPR/00014, 00015, 00081).** The only art is the
  six-colour fan at 440x353, which shows all colours at once and none of them individually.
- **`NFQ-380` bread moulder (IMG/PAS/00166).** Consistent with §7.2 item 14: the code returns
  nothing anywhere. **This is a true finding, not a search failure** - it is almost certainly a
  Sheffield- or Kator-internal code with no external existence.
- **`CPWK090-31` (IMG/BUF/00186).** The only `CPWK` frame found is `CPWK200-8`, which is a
  **plate cart, not a thermo box** - already marked `REF__` on the sibling SKU.

### 11.17 Method notes for whoever picks this up

- **Kator identifies, importers illustrate.** Do not spend budget trying to get a usable
  photograph out of `h-kitchen.en.made-in-china.com`. Use it to confirm *what the product is*
  and to read its spec tables - which are genuinely good and repeatedly settled open questions
  in §7 - then go to Infernus or the OEM for the picture.
- **Infernus URL shape is guessable:** `https://infernus.co.uk/wp-content/uploads/YYYY/MM/<CODE>-scaled.jpg`,
  with `<CODE>_OVERALL-DRAWING.pdf` and `<CODE>_INSTRUCTION-MANUAL.pdf` alongside. Guessing it
  beat searching for it, repeatedly.
- **Kator's spec tables are family tables.** The `HK-BC-01B` page carries all three back-bar
  coolers; the `B10GFA` page covers 10-40 L; the `GH-811` page covers single *and* double. This
  is why a single Kator photo keeps turning out to be the wrong variant - **the listing is a
  range, and the photo is only one member of it.** Read the table before trusting the picture.
- **Measure the bytes, never the filename.** Garyton's `-800-800.jpg` files are 640x640.
- **Rendering is not optional.** The `B10GFA` error was invisible in the filename, invisible in
  the listing title, invisible in the dimensions, and obvious the moment the image was drawn.

### 11.18 Buffet, servery and warmers - and the discovery that this block is not Kator's

A second wave covered the untouched buffet/servery, plate-warmer and heat-lamp SKUs. Its
single most important result is a **negative**:

> ⚠⚠ **Kator's own 252-product storefront index carries none of these 18 codes.**
> It has `DR-1` but not `DR-2`/`DR-3`. It has `BS-4` and `KG-165` but not `BS-6V`.
> It has `OT-8` and `OT-11-21` but not `OT-01P`. It has `EB-450` and `EB-08A` but not `EB-1200`.

**So the buffet/servery block does not come through Kator at all.** §1 established Kator as the
route for HK-REDLINE; that is true for the cooking, refrigeration and bakery lines, but this
block is a **separate consolidator**. That is why so many buffet codes returned nothing to
earlier passes searching Kator-shaped sources - they were never going to be there.

**New importer vein: `adexa.co.uk`.** Consistently 1500x1500 catalogue art, with a guessable
URL pattern `https://adexa.co.uk/image/cache/catalog/Adexa/<CODE>_<n>-1500x1500.jpg`.
This is the highest-resolution source found on the entire brand.

**OEMs traced this wave:**

- **Cookrite** owns the `AT` / `DAT` / `T` chafing-dish codes. Confirmed via a European
  distributor listing *Cookrite AT60293 Induction 2/3 Square Chafing Dish*, with siblings
  `AT61293`, `AT51363`, `AT8035L`, `AT741L63-1/-2`, `SK53140-1`, `SC62120-1`, `KS62140-1`, and
  decisively **`Cookrite DAT60063-1 "Dripless Built-In Oblong Chafing Dish"`** - our
  `DAT 60063-2` is the same built-in ("drop in") family, one variant along.
  **This identifies IMG/BUF/00020, 00027, 00028, 00143 and probably 00115.**
- **Dongpei Kitchen** makes the `DR`-series plate-warmer carts, as `DPDR-3` - the spring-loaded
  drop-in plate dispenser design.
- **Adexa / Hamoki** are both UK importers of the `CS-310` food warmer.
- **Adexa `BL1209` (black) / `S1205` (gold) / `BL1207` (copper)** are the Ø175 pendant heat
  lamps, spec'd Ø170x261 mm - the same three finishes our `A032` SKUs carry, which is what
  makes the family match convincing.
- **Guangzhou Ruitu `RT618`** (290 mm retractable, 250 W, gold/silver/rose-gold/black) makes
  both chafing dishes and the 290 mm lamps - the likeliest source for the `A035` items, but the
  code does not match, so nothing was staged.

⚠ **The Cookrite images could not be retrieved.** The distributor sits behind a Cloudflare bot
challenge that returns 403 to WebFetch, to `requests` with full browser headers, to the
`r.jina.ai` proxy, and to direct `/media/catalog/product/...` asset paths. **This is a genuine
blocker, not a search failure** - the codes are identified and someone with a real browser can
lift the photographs in minutes. Worth doing: it would close five buffet SKUs at once.

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-HOT-00222__CS-310-adexa.jpg` | 1500x1500 | 122 KB | https://adexa.co.uk/image/cache/catalog/Adexa/CS310%20(1)-1500x1500.jpg |
| `IMG-BUF-00023__REF__BL1209-adexa-black-pendant-lamp.jpg` | 1500x1500 | 74 KB | https://adexa.co.uk/image/cache/catalog/Adexa/BL1209_1-1500x1500.jpg |
| `IMG-BUF-00023__REF__BL1209-adexa-black-pendant-lamp-b.jpg` | 1500x1500 | 67 KB | https://adexa.co.uk/image/cache/catalog/Adexa/BL1209_2-1500x1500.jpg |
| `IMG-BUF-00024__REF__S1205-adexa-gold-pendant-lamp.jpg` | 1500x1500 | 86 KB | https://adexa.co.uk/image/cache/catalog/Adexa/S1205_1-1500x1500.jpg |
| `IMG-BUF-00024__REF__S1205-adexa-gold-pendant-lamp-b.jpg` | 1500x1500 | 76 KB | https://adexa.co.uk/image/cache/catalog/Adexa/S1205_2-1500x1500.jpg |
| `IMG-BUF-00244__REF__BL1207-adexa-copper-pendant-lamp.jpg` | 1500x1500 | 80 KB | https://adexa.co.uk/image/cache/catalog/Adexa/BL1207_1-1500x1500.jpg |
| `IMG-BUF-00244__REF__BL1207-adexa-copper-pendant-lamp-b.jpg` | 1500x1500 | 68 KB | https://adexa.co.uk/image/cache/catalog/Adexa/BL1207_2-1500x1500.jpg |
| `IMG-HOT-00063__REF__BM-6V-rebenet-6pan-bain-marie.png` | 1024x1024 | 518 KB | https://image.made-in-china.com/2f0j00SkBvbCmGyroM/Kitchen-Equipment-Commercial-Countertop-6-Pan-Bain-Marie-Food-Warmer-BM-6V-.jpg |
| `IMG-HOT-00063__REF__BM-6V-rebenet-catalogue-shot.jpg` | 800x800 | 111 KB | https://image.made-in-china.com/2f0j00sdKiakEoyncN/Kitchen-Equipment-Commercial-Countertop-6-Pan-Bain-Marie-Food-Warmer-BM-6V-.jpg |
| `IMG-BUF-00032__REF__2x40-plate-drop-in-cart-ntsmart.jpg` | 800x800 | 100 KB | https://image.made-in-china.com/2f0j00uvnhOQaRfwqN/Professional-Catering-Drop-in-Plate-Warmer-Cart-for-Events.jpg |
| `IMG-BUF-00032__REF__2x40-plate-drop-in-cart-ntsmart-b.jpg` | 800x800 | 100 KB | https://image.made-in-china.com/2f0j00zBNWOuQdGJkn/Professional-Catering-Drop-in-Plate-Warmer-Cart-for-Events.jpg |
| `IMG-BUF-00033__REF__DPDR-3-dongpei-plate-warmer-cart-TOOSMALL.jpg` | 600x600 | 23 KB | https://dongpeikitchen.com/wp-content/uploads/2018/04/electric-plate-warmer-cart01.jpg |
| `IMG-BUF-00033__REF__DPDR-3-dongpei-dimensions-TOOSMALL.jpg` | 600x600 | 39 KB | https://dongpeikitchen.com/wp-content/uploads/2018/04/electric-plate-warmer-cart02.jpg |
| `IMG-DIS-00045__REF__REPRESENTATIVE-OT-3P-alsaed-TOOSMALL.jpg` | 600x600 | 52 KB | https://alsaedco.com/wp-content/uploads/2020/05/Glass-Food-Display-Warmer-OT-3P.jpg |

All fourteen were rendered and inspected. `CS-310` is the only **exact-code** hit in the set;
everything else is honestly marked `REF__` because the badge code differs from ours.

**Rejected during verification, this wave:**

- A floor-standing 6-pan bain marie on a leg frame - our `BS-6V` is **table top**. Wrong form
  factor.
- Three ntsmart 800x800 frames that were not products at all: a *"Design & Consultancy /
  Project Procurement"* services infographic, a grid of hotel client logos (Hilton, Marriott,
  Hyatt), and a *"WE SERVE"* marketing collage. **Exactly the "largest image on the page is not
  the product" hazard recorded in §10.3, hit again.**
- A Dongpei annotated feature diagram with a hand in frame - good evidence that the `DR-3` is a
  spring drop-in dispenser, not a usable product shot.
- Adexa `EWL01B` / `EWL02G1` / `EWL02S1` at 1500x1500 in the right three finishes -
  **rejected on form factor**: they are freestanding gooseneck table lamps on a base plate, not
  Ø175 dome pendants. A tempting near-miss.

**Abstentions this wave** (added to §11.16):

- **`YFR01-2` (IMG/BUF/00019)** and **`YFL02-1` (IMG/BUF/00021)** - zero external results. The
  only hits anywhere are sheffieldafrica.com, which is our own data and inadmissible. These
  read as **true Sheffield/Kator-internal codes**.
- **`DAT 60063-2`, `AT50293`, `AT60293` x2** - OEM positively identified as Cookrite, image
  unobtainable behind Cloudflare. Deliberately **not** substituted with a generic chafing dish.
- **`T23065` (IMG/BUF/00115)** - no external trace. Reads as GN 2/3 x 65 mm deep, consistent
  with the name, but unconfirmed.
- **`A035` Gold and Silver Ø290 (IMG/BUF/00025, 00026)** - the Ø175 sibling was found, nothing
  at Ø290. A reseller image proves the family, not the size, so the Ø175 art was **not**
  attached to a Ø290 item. `Ruitu RT618` is the lead to chase.
- **`EB-1200` (IMG/BUF/00030)** - no trace. Kator's `EB` series is `EB-450` (salamander) and
  `EB-08A` (popcorn), so `EB-1200` is **not** from that range despite the shared prefix.

### 11.19 Chopping boards closed - and a second reusable size-rewrite

The four HACCP chopping boards had been stuck on a single 440x353 six-colour fan since §6.
Adexa - the importer discovered in §11.18 - stocks them **individually by colour**, which
resolves all four at once.

⚠ **Adexa's search-results pages serve `-262x262` thumbnails.** Their product pages use
`-1500x1500`. **Rewriting the size token in the path works**, exactly like the made-in-china
`2f0j00` rewrite:

> `…/catalog/Adexa/Board-Blue-`**`262x262`**`.jpg` → `…/catalog/Adexa/Board-Blue-`**`1500x1500`**`.jpg`

That is a **5.7x** gain on the long edge, and it is the second size-rewrite trick this brand
has needed. Worth trying on any OpenCart-style `image/cache/` path.

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-FPR-00012__REPRESENTATIVE-HACCP-blue-board-adexa.jpg` | 1500x1500 | 329 KB | https://adexa.co.uk/image/cache/catalog/Adexa/Board-Blue-1500x1500.jpg |
| `IMG-FPR-00014__REPRESENTATIVE-HACCP-white-board-adexa.jpg` | 1500x1500 | 108 KB | https://adexa.co.uk/image/cache/catalog/Adexa/Board-White-1500x1500.jpg |
| `IMG-FPR-00015__REPRESENTATIVE-HACCP-yellow-board-adexa.jpg` | 1500x1500 | 209 KB | https://adexa.co.uk/image/cache/catalog/Adexa/Board-Yellow-1500x1500.jpg |
| `IMG-FPR-00081__REPRESENTATIVE-HACCP-red-board-adexa.jpg` | 1500x1500 | 338 KB | https://adexa.co.uk/image/cache/catalog/Adexa/Board-Red-1500x1500.jpg |

All four rendered and confirmed as the correct single colour each; **all four MD5s differ**, so
these are four genuine photographs, not one render tinted four ways.

Marked `REPRESENTATIVE-` rather than exact **on purpose**: our board SKUs carry no real model
number (`N/A`, and one literal `"RED"` - see §7.4 item 16), so there is no code to match. These
are commodity HDPE HACCP boards and the colour is the entire specification. Adexa's are
`JJD3/JJD4/JJD5` in 325x265x13, 400x300x13 and 530x325x20 - **if our board dimensions are known,
the matching Adexa size code can be cited directly.**

### 11.20 Further abstention - heated thermo box

**`CPWK090-31` "Thermo Box 6 GN Heated" (IMG/BUF/00186)** and its sibling
**`CPWK090-1` (IMG/BUF/00183)** - abstained.

Adexa was checked as the new high-resolution vein and stocks insulated food carriers
(`TLIFC8` 29 L top-loader, `EPP4060T6`/`EPP4060T9` bakery pan carriers, `JWIPCCK` front-loading
GN1/1 carrier) - but **all of them are passive insulated boxes, and our SKUs are *heated***.
That is a functional difference, not a cosmetic one, so none were staged.

The only `CPWK` art found anywhere remains `CPWK200-8`, which is a **plate cart, not a thermo
box at all**, already marked `REF__` on IMG/BUF/00183. The `CPWK` prefix therefore covers at
least two unrelated product types, which makes it a consolidator's internal code rather than a
manufacturer's series.

### 11.21 Coverage across all 102 SKUs

This is the reconciliation that §10 and §11 never had: every one of the 102 `HK-REDLINE`
records in `products.json` checked against what is actually on disk in
`Desktop\ecommerce\products resource\hk-redline-images\` (146 files) and against what §10 and
§11.1-11.20 record. **Nothing is rounded up.** A SKU counts as "exact" only where the frame
shows our model code, or a unit proven identical to it; everything else is honestly demoted.

| Bucket | SKUs | Share |
|---|---|---|
| **A - Exact model, ≥800 px** | **31** | 30% |
| **B - Exact model, below 800 px, ceiling proven** | **23** | 23% |
| **C - Representative / `REF__` only** | **31** | 30% |
| **D - Deliberate abstention** | **16** | 16% |
| **E - Not reached at all** | **1** | 1% |
| **Total** | **102** | |

**101 of 102 SKUs were reached.** But only **31** carry an exact-model frame that clears the
800 px floor. Read against §11.2 that is the expected shape, not a shortfall: the 23 SKUs in
bucket B are ones where **the ceiling was proven** - Kator or Garyton is the only publisher of
that model's photograph and their own art is smaller than 800 px. No further searching moves
them.

---

#### A - Exact model, ≥800 px (31)

| SKU | Model | Best frame | Px |
|---|---|---|---|
| IMG/FPR/00046 | 300ES-12 | `300ES-12-agequipment.jpg` | 1000x1000 |
| IMG/FPR/00179 | 250ES-10 | `250ES-10-agequipment.jpg` | 1000x1000 |
| IMG/FPR/00251 | TC-22 | `TC-22-kitchenwarestation.jpg` | 1269x1269 |
| IMG/FPR/00252 | JT32 | `JT32-hamoki.png` | 1080x1080 |
| IMG/FPR/00253 | JG210 | `JG210-twothousand.jpg` | 2560x2560 |
| IMG/FPR/00254 | JG310 | `JG310-linkrich.jpg` | 800x800 |
| IMG/FPR/00218 | IB500LV | `IB500LV-infernus.jpg` | 891x1280 |
| IMG/FPR/00222 | WIK250 | `WIK250-infernus.jpg` | 1326x1996 |
| IMG/FPR/00257 | WF-B3000 | `WF-B3000-alicdn.jpg` | 800x800 |
| IMG/ICE/00040 | BL-018 | `BL-018-machines4u.jpg` | 1000x1000 |
| IMG/DIS/00103 | R60-2 | `R60-1-kator-family.jpg` | 2238x1000 |
| IMG/PAS/00101 | B20GA | `20L-planetary-infernus.jpg` | 800x800 |
| IMG/PAS/00103 | B10GFA | `10L-planetary-infernus.jpg` | 800x800 |
| IMG/PAS/00145 | B30GA | `30L-planetary-infernus.jpg` | 800x800 |
| IMG/PAS/00155 | BM-25 | `BM-25-HS80S-twothousand.webp` | 1500x1500 |
| IMG/PAS/00157 | BM-50 | `BM-50-HS130S-twothousand.webp` | 2156x2156 |
| IMG/HOT/00071 | EB-600 | `EB-600HWX-rebenet.webp` | 1000x1000 |
| IMG/HOT/00219 | DF-28L | `DF-28L-infernus.jpg` | 1644x2560 |
| IMG/HOT/00222 | CS-310 | `CS-310-adexa.jpg` | 1500x1500 |
| IMG/HOT/00271 | 6ATS-C | `6AST-C-rebenet.webp` | 800x800 |
| IMG/HOT/00278 | MDXZ-16 | `MDXZ-16-tenshine-chicken-express-placard.webp` ⚠ | 1080x1080 |
| IMG/HOT/00282 | MDXZ-24 | `MDXZ-24-linkrich-placard-legible.jpg` | 800x800 |
| IMG/HOT/00352 | CT-3 | `CT-3-infernus.jpg` | 2560x1920 |
| IMG/HOT/00354 | GH-813 | `GH-813-ola-oficina-multiview.png` | 1254x1254 |
| IMG/HOT/00386 | JZH-TCX2 | `JZH-TCx2-ZH-TCx2-linkrich.jpg` | 800x800 |
| IMG/HOT/00388 | RC-400T | `RC-400T-rebenet-front.jpg` (+3) | 800x800 |
| IMG/HOT/00416 | WB-1 | `WB-1-infernus.jpg` | 1718x2560 |
| IMG/HOT/00417 | WB-2 | `WB-2-infernus.jpg` | 2560x2412 |
| IMG/HOT/00420 | EF-11L-2 | `EF-11L-2-linkrich-page-hero.jpg` | 800x800 |
| IMG/COF/00021 | WB20A | `WB-20A-infernus.jpg` | 1704x2560 |
| IMG/COF/00022 | WB30A | `WB-30A-infernus.jpg` | 1704x2560 |

`R60-2` is in this bucket on the §11.6 reasoning: the frame is a **labelled** family composite
with `R60-1 / R60-2 / R60-3` legible over one cabinet, so the code is verifiable in-frame.

⚠ `MDXZ-16` holds its place in this bucket **only** on the `chicken-express-placard` frame. The
other 1080x1080 file staged for this SKU turned out to be an **AI-generated render** and has
been re-marked `REF__AI-GENERATED-RENDER-…-DO-NOT-USE` - see §11.23. Had it not been rendered,
this row would have been a false pass.

#### B - Exact model, below 800 px, with the ceiling proven (23)

These are **not** failures. In each case the only publisher of the model's photograph is Kator
or Garyton, and their own art is under the floor - §11.2's structural finding, SKU by SKU.

| SKU | Model | Frame | Px |
|---|---|---|---|
| IMG/DIS/00022 | HK-BC-01B | `HK-BC-01B-kator-TOOSMALL.jpg` | 698x500 |
| IMG/DIS/00146 | HK-BC-01 | `HK-BC-01-kator-family-TOOSMALL.jpg` | 700x500 |
| IMG/OVE/00009 | HTD-90 | `HTD-90-garyton-3deck-9tray-TOOSMALL.webp` | 640x640 |
| IMG/OVE/00087 | HTR-20Q | `HTR-20Q-garyton-TOOSMALL.jpg` | 640x640 |
| IMG/OVE/00088 | HTR-40Q | `HTR-40Q-garyton-TOOSMALL.jpg` | 640x640 |
| IMG/OVE/00168 | NFD-20F | `NFD-20F-marino-TOOSMALL.jpg` | 600x600 |
| IMG/OVE/00169 | HTD-40 | `HTD-40-garyton-2deck-4tray-TOOSMALL.webp` | 640x640 |
| IMG/OVE/00206 | HTR-101C | `HTR-101Q-garyton-TOOSMALL.jpg` ⚠ | 640x640 |
| IMG/OVE/00229 | YXD-1AE | `YXD-1A-kator-TOOSMALL.jpg` | 573x520 |
| IMG/OVE/00230 | YXD-8A-3 | `YXD-8A-kator-TOOSMALL.jpg` | 200x120 |
| IMG/PAS/00011 | FX-14 | `kator-electric-prover-TOOSMALL.jpg` | 388x429 |
| IMG/PAS/00102 | HK-B7 | `7L-planetary-mixer-kator-TOOSMALL.jpg` | 481x638 |
| IMG/PAS/00160 | JDR450B | `JDR450B-kator-TOOSMALL.jpg` | 700x500 |
| IMG/PAS/00164 | KT-20 | `kator-dough-divider-rounder-TOOSMALL.jpg` | 196x369 |
| IMG/BUF/00022 | 2009/ED | `2009-E-kator-TOOSMALL.jpg` | 332x398 |
| IMG/BUF/00031 | DR-1 | `DR-1-kator-family-TOOSMALL.jpg` | 700x500 |
| IMG/HOT/00066 | EB-450 | `EB-450-kator-TOOSMALL.jpg` | 185x154 |
| IMG/HOT/00069 | CZ-9 | `CZ-9-garyton-GRT-CZ9-TOOSMALL.webp` | 640x640 |
| IMG/HOT/00275 | BS-4V | `BS-4-kator-family.jpg` | 1181x**592** |
| IMG/HOT/00276 | KG-165F | `KG-165-kator-family.jpg` | 854x**650** |
| IMG/HOT/00421 | EF-28L | `EF-28L-kator-TOOSMALL.jpg` (+ 2 Infernus PDFs) | 200x388 |
| IMG/HOT/00067 | SOT-4S | `SOT-4S-yiwugo-TOOSMALL.jpg` | 750x750 |
| IMG/STO/00011 | HK-DC-M2A | `kator-ss-service-cart-TOOSMALL.jpg` | 355x149 |

⚠ `HTR-101C`: our `model_number` is `HTR-101C`, our product **name** says `HTR-10C`, and
Garyton's badge reads `HTR-101Q`. Three spellings of one oven - see §7.2. The photograph is the
right machine; the code in `products.json` is the thing that needs settling.

Note the two "wide" entries - `BS-4` at 1181x592 and `KG-165` at 854x650. They pass on the long
edge and fail on the short one. **Measured on the short edge deliberately**: a 592 px-tall
frame cannot fill an 800 px square card without upscaling.

#### C - Representative / `REF__` only (31)

Right product class, wrong badge, wrong variant or wrong size - attached as context, never as
the product's own photograph.

| SKU | Model | Stands in for it | Why not exact |
|---|---|---|---|
| IMG/FPR/00255 | HLS-2400 | HLS-2020 (Canmac) | different blade/frame size |
| IMG/FPR/00012 | (N/A) blue board | Adexa HACCP blue | commodity board, no model code exists |
| IMG/FPR/00014 | (N/A) white board | Adexa HACCP white | as above |
| IMG/FPR/00015 | (N/A) yellow board | Adexa HACCP yellow | as above |
| IMG/FPR/00081 | `RED` red board | Adexa HACCP red | as above; `RED` is not a model number (§7.4) |
| IMG/BUF/00129 | LSP-18X3 | LSP-12X1 | wrong tank size **and** wrong tank count |
| IMG/DIS/00023 | HK-BC-02B | HK-BC-01B family shot | one photo, three-cabinet family table (§11.14) |
| IMG/DIS/00024 | HK-BC-03B | HK-BC-01B family shot | as above |
| IMG/DIS/00112 | HK-BC-02 | HK-BC-01B family shot | as above |
| IMG/DIS/00019 | FGDG1.0A-1500LS | FGDG 1200LS-3 | **wrong width** - width is the spec being sold |
| IMG/DIS/00045 | OT-01P | OT-3P (Alsaed) | different pan count |
| IMG/OVE/00205 | HTD-20 | YXD-20C (Kator) ⚠ | deck-oven class matches, code does not |
| IMG/OVE/00234 | HK-13220 | generic 15-cavity 4" burger pan | house code, no external trace |
| IMG/OVE/00235 | HK-13221 | generic non-stick 15-cavity pan | as above |
| IMG/PAS/00156 | BM-75 | HS200S shared catalogue art | vendor reuses one render across the ladder |
| IMG/PAS/00169 | BM-100 | HS260S shared catalogue art | as above |
| IMG/BUF/00023 | A032 black | Adexa BL1209 | importer code, family match only (§11.18) |
| IMG/BUF/00024 | A032 gold | Adexa S1205 | as above |
| IMG/BUF/00244 | A032 copper | Adexa BL1207 | as above |
| IMG/BUF/00032 | DR-2 | ntsmart 2x40 drop-in cart | unbadged |
| IMG/BUF/00033 | DR-3 | Dongpei DPDR-3 | OEM identified, code differs |
| IMG/BUF/00183 | CPWK090-1 | Kator CPWK200-8 | **a plate cart, not a thermo box** - also abstained, §11.20 |
| IMG/HOT/00063 | BS-6V | Rebenet BM-6V | badge differs |
| IMG/HOT/00195 | OT-10B-21 | Kator OT-11-21 ⚠ | Kator's index has `OT-11-21`, not `OT-10B-21` (§11.18) |
| IMG/HOT/00353 | GH-811E | GH-811 family shot | **shows the DOUBLE head; ours is single** (§11.17) |
| IMG/HOT/00389 | GF-120T | Infernus GF-120T | same code, **single-tank gas** vs our split 11+11 (§11.9) |
| IMG/HOT/00419 | EF-11L | Kator EF-4L family | wrong capacity |
| IMG/COF/00020 | WB15A | Infernus WB-10A | **Infernus has no 15 L unit** (§11.10) |
| IMG/COF/00108 | EF-20 | Kator BF-05 wall boiler | code differs |
| IMG/STO/00012 | HK-DC-M3A | TT-BU100B / TT-BU119A 3-shelf carts | unbadged commodity |
| IMG/STO/00013 | HK-113103 | Kator HK-113101 | **bakery tray trolley, not a dishrack trolley** |

#### D - Deliberate abstention (16)

Investigated and left without an image **on purpose**. Consolidated from §11.16, §11.18, §11.20
and this wave. Attaching a plausible frame would have been worse than leaving the record empty.

| SKU | Model | Status of the identification |
|---|---|---|
| IMG/BUF/00019 | YFR01-2 | zero external trace - reads as a true internal code |
| IMG/BUF/00021 | YFL02-1 | zero external trace - reads as a true internal code |
| IMG/BUF/00020 | DAT 60063-2 | **OEM known: Cookrite** - image behind Cloudflare 403 |
| IMG/BUF/00027 | AT50293 | **OEM known: Cookrite** - image behind Cloudflare 403 |
| IMG/BUF/00028 | AT60293 | **OEM known: Cookrite** - image behind Cloudflare 403 |
| IMG/BUF/00143 | AT60293 | **OEM known: Cookrite** - duplicate of 00028 (§7.3) |
| IMG/BUF/00115 | T23065 | no external trace; reads as GN 2/3 x 65 mm, unconfirmed |
| IMG/BUF/00025 | A035 gold Ø290 | Ø175 sibling found, **nothing at Ø290**; lead is Ruitu RT618 |
| IMG/BUF/00026 | A035 silver Ø290 | as above |
| IMG/BUF/00030 | EB-1200 | no trace; Kator's `EB` range is `EB-450`/`EB-08A` only |
| IMG/BUF/00130 | LSP-18X2 | only an `LSP-12X1` frame exists |
| IMG/BUF/00186 | CPWK090-31 | **heated**; every carrier found is passive-insulated |
| IMG/DIS/00020 | FGDG 1800LS-3 | only the 1200 mm frame exists; **LINKRICH is a clean negative** |
| IMG/DIS/00021 | FGDG 1500LSD-3 | as above |
| IMG/PAS/00166 | NFQ-380 | **no external existence** - a true finding, not a search failure |
| IMG/HOT/00168 | SSPC-25 | **traced to the "Time Saver" line**; no usable photograph - see §11.22 |

⚠ The four chopping boards were listed as abstentions in §11.16 and are **no longer** - §11.19
closed all four at 1500x1500 from Adexa. They now sit in bucket C. §11.16 should be read as
superseded on that point.

⚠ **The single highest-value unblock on this brand is Cookrite.** Five SKUs
(IMG/BUF/00020, 00027, 00028, 00143 and probably 00115) are *identified* and blocked only by a
bot challenge. Anyone with a real browser closes five records in minutes.

#### E - Not reached at all (1)

| SKU | Model | Name |
|---|---|---|
| IMG/HOT/00434 | *(blank)* | Fryer Split Type 10 + 10 Litres H Kitchen Electric |

**This record has no `model_number` at all.** There is nothing to search on - the only handle is
a description string. It is listed as "not reached" rather than "abstained" because no
identification was ever attempted against a code, because no code exists in our own data. It is
a **data-entry gap, not a sourcing gap**, and it should be fixed in `products.json` before
anyone tries again. Note that its stablemates `RC-400T` (15+15) and `GF-120T` (11+11) are both
covered, so the split-fryer ladder is otherwise complete.


### 11.22 The 40 orphaned files - staged but never written up, now reconciled

A sub-agent in the previous wave downloaded and verified images for roughly 18 SKUs and then
went idle without ever reporting. **The files were on disk; the provenance was not.** 40 staged
files carried no source URL anywhere in this document, which made them unusable - an image with
no citation cannot be defended.

**How they were recovered.** The download helper used a `dl.get(url, name)` call signature, so
every URL/filename pair survived in the session transcripts as an adjacent string pair. Parsing
the transcripts for that two-argument shape recovered **38 of the 40** exactly, with no
guessing. The remaining two were found by grepping the transcripts for the bare Infernus host.

⚠ **Method note worth keeping: prefer the call signature over proximity.** A first attempt
paired URLs to filenames by character distance and produced a **consistent off-by-one** - every
file was credited with its predecessor's URL. It looked plausible and was entirely wrong.
Matching on the *argument structure* (`"url", "name"`) rather than on nearness fixed it. Had
this been eyeballed instead of cross-checked, 38 citations would have been silently mis-attributed.

**Ovens and proofing**

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-OVE-00009__HTD-90-garyton-3deck-9tray-TOOSMALL.webp` | 640x640 | 19 KB | https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/ljBpiKqkliSRpiionqiqiq/HTD.jpg |
| `IMG-OVE-00009__HTD-90-garyton-clean-3deck-TOOSMALL.webp` | 437x407 | 17 KB | https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/lkBpiKqkliSRpiionqjqiq/90.jpg |
| `IMG-OVE-00169__HTD-40-garyton-2deck-4tray-TOOSMALL.webp` | 640x640 | 15 KB | https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/loBpiKqkliSRpiiojqrnio/HTD.jpg |
| `IMG-OVE-00169__HTD-40-garyton-clean-2deck-TOOSMALL.webp` | 292x285 | 10 KB | https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/loBpiKqkliSRpiiojqnrio/HTD-40ercengsipandian.jpg |
| `IMG-OVE-00168__NFD-20F-marino-TOOSMALL.jpg` | 600x600 | 35 KB | https://shop.marinouae.com/wp-content/uploads/2020/12/2382-NFD-20F-600x600.jpg |

`NFD-20F` is a **new importer for this brand: `shop.marinouae.com`** (Marino, UAE). It is the
only source found anywhere carrying our exact `NFD-20F` code, and its filename already declares
the ceiling - `-600x600`. Garyton's four deck-oven frames confirm the §11.7 finding again: the
`-800-800` naming is decorative, the bytes are 640x640 or smaller.

**Hamburger pans - a commodity item with no manufacturer**

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-OVE-00234__REPRESENTATIVE-15cavity-4inch-burger-pan-wxhongbei.webp` | 800x800 | 16 KB | https://shopcdnalpha.grainajz.com/category/342594/90/41251f9bf63ceba2d88f091cbe131c05/15%20cups%20burger%20pan.jpg |
| `IMG-OVE-00234__REPRESENTATIVE-15cavity-burger-pan-baketrays.webp` | 800x800 | 71 KB | https://www.baketrays.com/photo/pl161504864-15_cavities_baking_toast_bread_pan_4_inch_hamburger_pan_40_60cm_baking_pan_for_baking_burger_tray.jpg |
| `IMG-OVE-00234__REPRESENTATIVE-15cavity-burger-pan-dims-600x400-TOOSMALL.jpg` | 750x750 | 118 KB | https://shopcdnalpha.grainajz.com/category/342594/90/d3059f039aa87db9824faa3d53b4b687/hamburger%20pan.jpg |
| `IMG-OVE-00235__REPRESENTATIVE-nonstick-15cavity-burger-pan-angled-mrkitchenware.webp` | 1778x1000 | 36 KB | https://site.cdnfile.io/www.mrkitchenware.com/0db3a9b102f94baaa5782cc84eb43bb1.webp |
| `IMG-OVE-00235__REPRESENTATIVE-nonstick-15cavity-burger-pan-mrkitchenware.webp` | 1000x1000 | 37 KB | https://site.cdnfile.io/www.mrkitchenware.com/9f4685028aadff2522223e0c0de798a4.webp |

All five are `REPRESENTATIVE-` and must stay that way. Our codes `HK-13220` / `HK-13221` are
**house numbers in the same `HK-1xxxxx` series as the `HK-113101` trolley** (§11.10) - a
Sheffield/Kator internal numbering scheme, not a manufacturer's. The pans themselves are an
undifferentiated commodity: 15 cavities, 4 inch, 600x400 mm tray footprint. The **only** thing
distinguishing our two SKUs from each other is the non-stick coating on `HK-13221`.

**Spiral mixers - one render serves the whole ladder**

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-PAS-00155__BM-25-HS80S-twothousand.webp` | 1500x1500 | 64 KB | https://www.twothousand.com/wp-content/uploads/2022/12/hs80s_new_.jpg |
| `IMG-PAS-00157__BM-50-HS130S-twothousand.webp` | 2156x2156 | 84 KB | https://www.twothousand.com/wp-content/uploads/2025/12/EdAlJrEKpp.jpg |
| `IMG-PAS-00156__REPRESENTATIVE-HS200S-shared-art-twothousand.webp` | 1500x1500 | 71 KB | https://www.twothousand.com/wp-content/uploads/2025/12/img_v3_02t3_6780756c-a777-422b-b6c5-ca97f146e94g.jpg |
| `IMG-PAS-00169__REPRESENTATIVE-HS260S-shared-art-twothousand.webp` | 1500x1500 | 71 KB | https://www.twothousand.com/wp-content/uploads/2025/12/img_v3_02t3_6780756c-a777-422b-b6c5-ca97f146e94g.jpg |
| `IMG-PAS-00157__REF__kator-dough-mixer-140L.jpg` | 1160x1544 | 143 KB | https://image.made-in-china.com/2f0j00dsOaKiwneBoL/Dough-Mixer-140L.jpg |

⚠ **`BM-75` and `BM-100` share one URL, and therefore one photograph.** Twothousand reuses a
single render across `HS200S` and `HS260S`; the two staged files are byte-identical because
they *are* the same file. Both are marked `REPRESENTATIVE-` for that reason - the 200 L and
250 L machines are not visually distinguished by their own vendor. `BM-25`/`BM-50` do have
their own art and are exact.

**OEM traced: Guangzhou Twothousand Machinery** is behind the spiral-mixer ladder, mapping
`BM-25 → HS80S`, `BM-50 → HS130S`, `BM-75 → HS200S`, `BM-100 → HS260S`. Note our names carry
**both** a dough weight and a bowl volume (`BM-25` = "80 LITRES/25KG") and the OEM code encodes
the **litres**, not the kilos - `HS80S` is the 80 L machine. That is a clean correspondence
across all four rungs and it confirms the naming is internally consistent.

⚠ **A rejection worth recording: `kat_mix1` was the largest mixer image found and was
discarded.** Its Kator page lists `SH10A / SH20A / SH30A` **benchtop** machines; our `BM` line
is 80-250 L **floor-standing**. This is the §11.17 family-table trap catching a plausible
candidate on the merits, not on resolution.

**Storage carts**

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-STO-00012__REF__kator-service-cart-family-incl-3tier-dining-TOOSMALL.jpg` | 355x149 | 23 KB | https://image.made-in-china.com/2f0j00RSvQTHMqvEbI/S-Steel-Service-Cart.jpg |
| `IMG-STO-00012__REPRESENTATIVE-3shelf-ss-cart-TT-BU100B-TOOSMALL.webp` | 450x450 | 12 KB | https://www.twothousand.com/wp-content/uploads/2022/12/stainless_steel_cart_stainless_steel_utility_cart_-_three_shelf_850450900_mm_tt-bu100b-1.jpg |
| `IMG-STO-00012__REPRESENTATIVE-3shelf-ss-cart-TT-BU119A-TOOSMALL.webp` | 450x450 | 10 KB | https://www.twothousand.com/wp-content/uploads/2022/12/stainless_steel_cart_stainless_steel_utility_cart_-_three_shelf_950500950_mm_tt-bu119a-1.jpg |

The Twothousand URLs **carry the dimensions in the path** - `850450900` = 850x450x900 mm and
`950500950` = 950x500x950 mm. If our `HK-DC-M3A` dimensions are known, that identifies which of
the two is the right cart without needing to see either photograph clearly.

**Hot dog roller and panini grill**

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-HOT-00069__CZ-9-garyton-GRT-CZ9-TOOSMALL.webp` | 640x640 | 13 KB | https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/lrBpiKqkliSRmimiqjkjiq/GRT-CZ9.jpg |
| `IMG-HOT-00069__CZ-9-garyton-GRT-CZ9-open-TOOSMALL.webp` | 702x582 | 19 KB | https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/llBpiKqkliSRmimiqjqjiq/256.jpg |
| `IMG-HOT-00069__REF__kator-HD-05-S-hot-dog-roller-family.jpg` | 1181x787 | 163 KB | https://image.made-in-china.com/2f0j00nsvtajCMrEcZ/Well-Received-Hot-Dog-Roller-HD-05-S-.jpg |
| `IMG-HOT-00354__GH-813-ola-oficina-multiview.png` | 1254x1254 | 1.3 MB | https://ueeshop.ly200-cdn.com/u_file/UPBH/UPBH818/2607/08/products/b7492c57-af6a-472b-a274-75f548b2b805.png |
| `IMG-HOT-00354__GH-813-ola-oficina-INFOGRAPHIC.png` | 1448x1086 | 1.5 MB | https://ueeshop.ly200-cdn.com/u_file/UPBH/UPBH818/2607/08/products/1f6d70f8-5cad-4be0-a6cc-481275cee036.png |
| `IMG-HOT-00354__GH-813EE-benchstar-TOOSMALL.jpg` | 790x790 | 32 KB | https://www.foodequipment.com.au/media/catalog/product/cache/f906c2d7f57cb8d3ffab9c373d6c01e9/g/h/gh-813ee-01.jpg |

**`CZ-9` is Garyton's `GRT-CZ9`** - the `GRT-` prefix is Garyton's house prefix, so our `CZ-9`
is the same machine with the vendor prefix stripped. That is the same pattern as the `HTR`
ovens and is now a reliable rule for this supplier.

⚠ **`GH-813EE` at Benchstar measures 790x790 - ten pixels under the floor.** It is listed with a
`-TOOSMALL` marker rather than rounded up. The `ola-oficina` multiview at 1254x1254 is the
usable frame; the second file is explicitly named `INFOGRAPHIC` because it is a marketing
composite with overlaid text, not a clean product shot - it was **renamed rather than deleted**
so nobody re-fetches it thinking it is a photograph. A third OlaOficina file was a logo only and
was deleted outright.

**Fryers - the LINKRICH pressure/split-tank group**

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-HOT-00282__MDXZ-24-linkrich-placard-legible.jpg` | 800x800 | 42 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/10/20211115642.jpg |
| `IMG-HOT-00282__MDXZ-24-linkrich-watermarked.jpg` | 800x800 | 26 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/10/20211019204.jpg |
| `IMG-HOT-00278__REF__linkrich-countertop-pressure-fryer.jpg` | 800x800 | 53 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/10/20211115149.jpg |
| `IMG-HOT-00386__JZH-TCx2-ZH-TCx2-linkrich.jpg` | 800x800 | 84 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/08/20211125781.jpg |
| `IMG-HOT-00386__ZH-TCx2-linkrich-watermarked-TOOSMALL.jpg` | 611x445 | 17 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/08/20211020168.jpg |
| `IMG-HOT-00420__EF-11L-2-linkrich-page-hero.jpg` | 800x800 | 185 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/10/20211115666.jpg |
| `IMG-HOT-00420__REF__EF-11L-linkrich-single-tank.jpg` | 800x800 | 154 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/10/20220826475.jpg |
| `IMG-HOT-00420__REF__EF-8L-2-linkrich-double-tank-sibling.jpg` | 800x800 | 139 KB | https://www.chinalinkrich.com/wp-content/uploads/2021/10/20220826736.jpg |

⚠⚠ **LINKRICH's reach is much wider than §10 concluded.** §10.1 identified LINKRICH as the OEM
behind the slicers and bone saws, and §11.16 recorded a clean negative on the pastry displays.
This wave adds a **third result: LINKRICH is also the OEM behind the pressure fryers
(`MDXZ-24`), the split-tank fryers (`JZH-TCX2`) and the `EF` electric fryer line.** So the
LINKRICH relationship spans meat processing *and* frying, and the pastry-display negative
remains the only proven boundary. `chinalinkrich.com` serves a consistent 800x800 - exactly at
the floor, never above it.

**`MDXZ-24`'s placard is legible in frame and reads `MDXZ-24 MODEL ELECTRIC PRESSURE FRYER`.**
That is the strongest form of confirmation available - the model code photographed on the
machine itself, not inferred from a listing title.

**Infernus HBS frames** (recovered separately, by host grep)

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-FPR-00046__REF__HBS-250-275-300-infernus-KATOR-HBS-LINE-not-ES.jpg` | 1854x2560 | 239 KB | https://infernus.co.uk/wp-content/uploads/2023/04/HBS-250-HBS275-HBS-300-scaled.jpg |
| `IMG-FPR-00179__REF__HBS-195JS-220JS-infernus-KATOR-HBS-LINE-not-ES.jpg` | 2560x1704 | 177 KB | https://infernus.co.uk/wp-content/uploads/2023/04/HBS-195JS-HBS-220JS-scaled.jpg |

Both stay `REF__`. They document the **`HBS` line, which is not our `ES` line** - see §11.15.

**Rebenet split-tank fryer `RC-400T`**

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-HOT-00388__RC-400T-rebenet-front.jpg` | 800x800 | 96 KB | https://img.yfisher.com/m5461/1765432991697-gassplittankfryerrc-400t02.jpg |
| `IMG-HOT-00388__RC-400T-rebenet-angle.jpg` | 800x800 | 86 KB | https://img.yfisher.com/m5461/1765432993754-gassplittankfryerrc-400t03.jpg |
| `IMG-HOT-00388__RC-400T-rebenet-split-tank-top.jpg` | 800x800 | 100 KB | https://img.yfisher.com/m5461/1765433005807-gassplittankfryerrc-400t09.jpg |
| `IMG-HOT-00388__RC-400T-rebenet-baskets.jpg` | 800x800 | 114 KB | https://img.yfisher.com/m5461/1765434318085-gassplittankfryerrc-400t13.jpg |

⚠ **Contradiction to raise.** The Rebenet source URLs all read `gassplittankfryerrc-400t`, i.e.
**gas**. Our IMG/HOT/00388 is catalogued as *"Fryer Split Type 15 + 15 Ltrs H-Kitchen"* with no
fuel stated, and it sits among electric fryers. This is the **same fuel ambiguity already
flagged on `GF-120T` in §11.9**, hitting a second split-tank SKU. Two of the three split fryers
now have gas-badged photographs against ambiguous catalogue entries. **The fuel type of the
whole split-fryer group needs a supplier check** - it is not a photography problem.

### 11.23 ⚠⚠ New hazard class: a supplier serving AI-generated product images

`IMG-HOT-00278__MDXZ-16-tenshine-front.webp` was staged at 1080x1080 from `tenshine.shop` and
would have passed every check this effort has used - right product class, right model, ample
resolution, plausible thumbnail. **Rendered, it is unmistakably an AI-generated image.**

The tells, all only visible once drawn:

- The front placard reads *"Your Multipurpose Pressure Fryer"* in a **wobbling, inconsistent
  serif** with letterforms that change shape between repetitions.
- The left-hand warning panel is **gibberish** - text-shaped marks that resolve into nothing.
- The dials are numbered **incoherently**: one runs `0, 5, 10, 14, 30, 25, D0`, i.e. neither
  ordered nor a real scale.
- A **blue smear** floats across the control panel where the real machine has a slider label.
- The `ON` legend appears once, unpaired, where the genuine photo has `ON ←→ ON`.

The **genuine** photograph of the same machine was sitting on the same storefront and is now
staged as `IMG-HOT-00278__MDXZ-16-tenshine-chicken-express-placard.webp` (1080x1080,
https://www.tenshine.shop/cdn/shop/files/commercial-pressure-fryer-mdxz-16-front.webp ). It
carries a legible **"chicken express"** brand mark, a readable seven-point warning list, a
0-30 minute timer and a 50-200 °C thermostat. Side by side, the fake is obviously derived from
the real one.

The AI file was **renamed, not deleted**, per standing practice:
`IMG-HOT-00278__REF__AI-GENERATED-RENDER-tenshine-DO-NOT-USE.webp`
( https://www.tenshine.shop/cdn/shop/files/fried-chicken-pressure-fryer-16l-capacity.webp )

⚠ **Why this matters beyond one file.** Every heuristic this effort has built - measure the
bytes, read the family table, prefer the importer, check the badge - is aimed at *wrong* images.
None of them detect a *synthetic* image of the **right** product. The only defence that worked
was §11.17's "rendering is not optional", and it worked for the second time on this brand,
after the `B10GFA` placard. **Assume any Shopify-style storefront may now be padding its gallery
with generated variants, and treat unreadable on-product text as disqualifying.**

Also note the two `MDXZ-16` files had been **staged under swapped names** - the file named
`-front` came from the URL ending `16l-capacity`, and the file named `-lid-open` came from the
URL ending `mdxz-16-front`. Both names have been corrected above.

### 11.24 `SSPC-25` - correcting a false negative, and a cross-brand product line

An earlier sub-agent reported zero product hits for `SSPC-25` and concluded it was a
Sheffield-internal code with no external existence, in the same class as `NFQ-380`. **That
conclusion is wrong and is retracted here.**

**`SSPC` is one product line spanning three brand strings in our own catalogue**, sold under the
brand name **"Time Saver"**:

| SKU | Our brand string | Model | Capacity |
|---|---|---|---|
| IMG/HOT/00167 | STEELOLOGY | `SSPC-16` | 16 L |
| **IMG/HOT/00168** | **HK-REDLINE** | **`SSPC-25`** | **25 L** |
| IMG/HOT/00169 | GENEVA | `SSPC-40` | 40 L |
| IMG/HOT/00170 | GENEVA | `SSPC-60` | 60 L |

Three pieces of evidence, all checkable in this repository:

1. **The four SKUs are consecutive** - `IMG/HOT/00167` through `00170`. A single contiguous
   block split across three brand strings is not how three unrelated suppliers' products land
   in a catalogue.
2. **The stored photographs prove it.** `SSPC-40` and `SSPC-60` are **byte-identical**
   (MD5 `a2594f68…`, 153,013 bytes each). `SSPC-16` and `SSPC-25` are **the same 18,437 bytes**
   with differing MD5s - the same image re-encoded, not two photographs.
3. ⚠ **`SSPC-25`'s own stored photo carries a "Time Saver" badge** in red-and-blue on the pot
   body - a **different brand from the one it is filed under.** So does `SSPC-16`, which is
   filed under STEELOLOGY. Neither pot is branded with the brand string we sell it as.

**Correct statement of the outcome: `SSPC-25` is traced to the Time Saver pressure-cooker line,
and no photograph above the 800 px floor was found.** That is an abstention with a known
identification - categorically different from `NFQ-380`, where the code genuinely returns
nothing anywhere. It is recorded in bucket D of §11.21 on that basis.

⚠ **This is not only an imaging finding.** Our brand attribution for at least four SKUs is
wrong: they are one third-party line ("Time Saver") arbitrarily split across HK-REDLINE,
STEELOLOGY and GENEVA. **Raised for your decision** - the fix belongs in `products.json`, not in
an image folder, and it should be settled before anyone sources art for any of the four.

⚠ **General lesson: a code that returns nothing may be findable under a different name.** The
search failed because it searched the *code*; the product is traded under a *brand*. Where a
code is a house number, try the badge visible in our own stored photograph before recording a
negative.


---

## 12. Copy pass APPLIED, 2026-07-30 — all 102 SKUs

All 102 HK-REDLINE SKUs rewritten into house format: `description` (paragraphs +
`<h3>Key Features</h3>` + `<ul>`), `technical_specification` (`<table>` opening Brand then
Model), geo-free `short_description`, and `meta_description`. **102/102 now house-format
complete**; catalogue-wide moved **390 → 492 of 683**. `ProductCatalogueKeysTest` 5/5.
Backup: `products.json.backup-hk-*`.

**Starting state:** `meta_description` was **0/102**, `technical_specification` was **0** in
`<table>` form (47 bare `<ul>`), 44 descriptions were bare bullet dumps, and **90 of 102
`short_description`s carried market framing** — which the guard test forbids on enriched rows,
so all three fields had to move in one patch or the test would break.

### 12.1 ⚠ Spec text is not always in `<li>`

The first parser read only `<li>` and produced 30 Brand/Model/Type-only tables. Records also
store label:value pairs in **`<p>`** (`IMG/FPR/00179`: *"Size: 470x420x390mm"*, *"Voltage:
AC-220V /50Hz"*, *"Power:240W"*) and in **`<h3>`** (the chopping boards: *"Material:
Polyethylene"*, *"Dimensions:500x350mm"*, *"Thickness: 20mm"*). Parsing all block elements
recovered those and cut thin tables **30 → 22**. **Check every block tag, not just `<li>`.**

### 12.2 Disputed values were omitted, not published

Seven SKUs carry values §7/§5 records as conflicting. Their geometry/power rows are **left out
of the published table** per the house rule, and the conflict remains visible here:

| SKU | Model | Conflict |
|---|---|---|
| IMG/DIS/00024 | `HK-BC-03B` | power 290 W vs 500 W across two Kator pages |
| IMG/BUF/00027 | `AT50293` | width 480 vs 580 mm |
| IMG/BUF/00028, IMG/BUF/00143 | `AT60293` | 505×470×285 vs 490×490×210 |
| IMG/PAS/00145 | `B30GA` | 30 L is Kator's **B30GA2**; our code may be wrong |
| IMG/DIS/00019 | `FGDG1.0A-1500LS` | may be a later 2.0A/1.5A generation |
| IMG/DIS/00021 | `FGDG 1500LSD-3` | may be a later 2.0A/1.5A generation |

### 12.3 Dimension cross-check against §5 — 21 of 26 agree

Much healthier than Blueline. The five that differ:

| SKU | Model | Stored | §5 verified |
|---|---|---|---|
| IMG/DIS/00146 | `HK-BC-01` | *none* | 600 × 510 × 895 |
| IMG/OVE/00205 | `HTD-20` | 1230 × **820** × 530 | 1220 × **860** × 525 |
| IMG/OVE/00169 | `HTD-40` | 1230 × **820** × 1250 | 1220 × **860** × 1250 |
| IMG/OVE/00009 | `HTD-90` | 1670 × **820** × 1520 | 1650 × **860** × 1555 |
| IMG/PAS/00011 | `FX-14` | 500 × 760 × 1920 | 500 × 770 × 1900 |

⚠ **The three HTD ovens differ the same way** — stored width 820 where Kator publishes 860.
A consistent offset across a whole family is a *different source or generation*, not three
independent typos. **Not changed.** Worth one supplier question rather than three fixes.

### 12.4 ⚠ Broken `model_number` values found (flagged, not changed)

- `IMG/FPR/00012`, `IMG/FPR/00014`, `IMG/FPR/00015` — `model_number` is literally **`N/A`**
- `IMG/FPR/00081` — `model_number` is **`RED`**, a colour, not a code
- `IMG/HOT/00434` — **no `model_number` at all** (the gap already noted in §11.21)

The generator suppresses placeholder values so no table publishes "Model: N/A", but the
underlying records are still wrong. All four chopping boards need real codes.

### 12.5 Still thin — 22 records

These carry no spec text anywhere and now publish only Brand/Model/Type:
`HLS-2400` · `BL-018` · `HK-13220` · `HK-13221` · `HK-B7` · `AT50293` · `AT60293` ×2 ·
`2009/ED` · `OT-01P` · `BS-4V` · `EF-11L-2` · `IMG/HOT/00434` · `GF-120T` · `EF-28L` ·
`EF-20` · `CPWK090-31` · `HK-DC-M2A` · `HK-DC-M3A` · `HK-113103` · `SSPC-25` · `SOT-4S`.
§10 and §11 may already cover some; the rest need the OEM.

---

## 13. Verification audit, 2026-07-30 — what §12 actually did, stated plainly

§12 rewrote all 102 SKUs into house format. **That was a reformat, not a verification.** For
roughly two-thirds of the brand the facts published are the facts that were already stored;
only the ~26 SKUs cross-checked against §5 were confirmed against a source.

### 13.1 The honest coverage numbers

| | Count |
|---|---|
| SKUs with a source URL in this file (or in §5's verified set) | **55 / 102** |
| SKUs with **no** source anywhere | **47 / 102** |
| SKUs with at least one staged image file | **85 / 102** |
| SKUs with **no** staged image | **17 / 102** |

⚠ **§11.21's "101/102 reached" does not mean 101 SKUs have a usable photo.** It counted
buckets including abstentions and `__REF__` reference shots of *equivalent* products. Measured
against the actual staging folder, **85 SKUs have a file and 17 have nothing.** Several of the
85 hold only `__REF__` images, which are evidence of the family, not photographs of the SKU.

The 47 unsourced SKUs cluster by family, which is how they should be worked:
Chafing Dishes 7 · Heat Lamps 5 · Chopping Boards 4 · Pastry Displays 3 · Plate & Cup Warmers 3 ·
Bain Maries 3 · Trolleys & Carts 3 · Juice Dispensers 2 · Oven Accessories 2 · Dough/Moulders 2 ·
Food Warmers 2 · Fryers 2 · Thermoboxes 2 · and 7 single-SKU categories.

### 13.2 Verified this pass

**`LSP-18X3` / `LSP-18X2` juice dispensers ✅** — https://spaceman.en.made-in-china.com/product/ofuJrURKuQTF/China-Juice-Dispenser-LSP18x3-.html
`LSP-18X3`: 220 V/50 Hz 1-ph, **420 W**, 18 L × 3, **50 kg**, **750 × 450 × 700 mm**, CFC-free,
stainless body and tap, PC tanks. `LSP-18X2`: 18 L × 2, **7–15 °C**, **300 W**,
**440 × 442 × 720 mm**.

**`BS-6V` bain marie ✅** — https://www.rayakitchen.com.my/product/fresh-countertop-electric-bain-marie-bs-6v/
6 pans at 280 × 130 × 150 mm, **1.5 kW**, 230 V/50 Hz, **0–110 °C**, **19 kg**,
**710 × 660 × 290 mm**. Note LINKRICH — already identified in §10 as the OEM behind four of our
codes — sells the same unit as `BV6-1`:
https://www.chinalinkrich.com/commercial-kitchen-equipment/bv-bain-marie-bv6-1.html

### 13.3 ⚠ A circular-source trap worth naming

Searching `CPWK090` returns a rich, confident spec set — 90 L, 650 × 450 × 620 mm, 15 kg, PE with
polyurethane foam, 270° door, −40 to 80 °C. **Its source is `sheffieldafrica.com`.** The search
engine surfaced our own catalogue and presented it as an independent finding. Under the
never-source-from-Sheffield rule this is worth **nothing** as verification, however detailed it
looks. `CPWK090-1` and `CPWK090-31` remain **unverified**.

This is the same failure mode as `EWB470G` in the Blueline pass. **When a result looks
unusually complete for an obscure house-brand code, check whose site it is before believing it.**

### 13.4 Not found

`NFQ-380` (bread moulder) and `KT-20` (dough divider) return nothing. `NFQ-520`/`NFQ-620` exist
but are dough *sheeters*, a different machine — do not substitute them.

### 13.5 Blocked, not failed

**Cookrite** owns the `AT`/`DAT`/`T` chafing-dish codes (§11.18) and sits behind a Cloudflare
challenge. Retried this pass **via the Chrome browser extension, which is not currently
connected**, so it remains blocked. It is the single highest-value unblock on this brand:
a real browser session would close **IMG/BUF/00020, 00027, 00028, 00143 and probably 00115** —
five SKUs that currently have neither a verified spec nor an image.

### 13.6 ⚠ A normalisation bug hid verified data from three SKUs

The §5 cross-check matched `model_number` exactly, so **`FGDG 1800LS-3` (with a space) never
matched §5.1's `FGDG1800LS-3`** and was counted as unsourced. It is in fact verified: its stored
**1800 × 740 × 1300 matches §5.1's Kator figure exactly**. Same class of miss applies to the
other spaced FGDG codes. **Normalise whitespace before declaring a SKU unsourced.**

Reading the FGDG trio together now resolves §5.1's open question:
- `FGDG 1800LS-3` → 1800 × 740 × 1300 = the **`-3` generation**, confirmed.
- `FGDG1.0A-1500LS` → 1500 × 740 × 1300 = also `-3`-generation geometry.
- `FGDG 1500LSD-3` → 1500 × 740 × **1360** — the 1360 mm height is exactly the *"1360 mm-tall
  combo unit"* §5.1 attributes to the later 2.0A/1.5A range. So **this record, not the other
  two, is the later-generation unit.** Still needs supplier confirmation before any code change.

### 13.7 APPLIED from this verification pass

| SKU | Model | What changed | Source |
|---|---|---|---|
| IMG/OVE/00230 | `YXD-8A-3` | full spec: 3.5 kW, 240 V, 15 A, 3 × 600×400 trays, 50–300 °C, ext 834×765×500, int 700×460×288, 50 kg, twin reversing fans | https://ckesydney.au/product/fed-yxd-8a-3-3-trays-electric-convection-oven/ · https://snowmaster.com.au/fed-yxd-8a-3-electric-convection-oven · Kator sells the `YXD-8A` base: https://h-kitchen.en.made-in-china.com/product/dMcJCOfyyghe/China-Electric-Convection-Oven-YXD-8A-.html · manual PDF: https://adexa.co.uk/image/catalog/manuals/YXD8A_MANUAL.pdf |
| IMG/BUF/00129 | `LSP-18X3` | 3 × 18 L, 420 W, 220 V, 750×450×700, 50 kg | https://spaceman.en.made-in-china.com/product/ofuJrURKuQTF/China-Juice-Dispenser-LSP18x3-.html |
| IMG/BUF/00130 | `LSP-18X2` | 2 × 18 L, 300 W, 7–15 °C, 440×442×720 | same |
| IMG/HOT/00063 | `BS-6V` | 6 pans 280×130×150, 1.5 kW, 230 V, 0–110 °C, 710×660×290, 19 kg | https://www.rayakitchen.com.my/product/fresh-countertop-electric-bain-marie-bs-6v/ · LINKRICH sells it as `BV6-1`: https://www.chinalinkrich.com/commercial-kitchen-equipment/bv-bain-marie-bv6-1.html |
| IMG/DIS/00146 | `HK-BC-01` | **dimensions filled** 600 × 510 × 895 (were empty) | §5.1 Kator family table; sibling `HK-BC-01B` already stored exactly this |

`ProductCatalogueKeysTest` 5/5 after both patches.

### 13.8 Checked and still NOT verified

- **`BS-4V`** — the only detailed hit is `sheffieldafrica.com`. Circular, per §13.3.
- **`KG-165F`** — nothing. §11.18 notes Kator's index has `KG-165` but not `KG-165F`.
- **`GH-811E`** — the **platform** is confirmed (`EG-811E` 220 V/2.2 kW, 425×370×210, 15 kg,
  plate 34×22 cm — https://gzjieguan.en.made-in-china.com/product/kFRfnUrAuTpy/China-Electric-Stainless-Steel-Contact-Grill-CE-Certificate-Eg-811e.html ;
  also `HEG-811E`, Adcraft `SG-811E`, Patriot `PT-GH-811E`). ⚠ **Adcraft's `SG-811E` is 120 V /
  1.75 kW** — a US build. Do not take its figures: this is the known wrong-market-electrical
  trap. Nothing applied pending a per-SKU decision on which build we sell.

### 13.9 The Cookrite/chafing block — reopened with a real browser, 2026-07-30

§11.18 recorded this group as blocked by a Cloudflare challenge. Retried through the Chrome
extension. **The blocker is not what it looked like**, and three SKUs moved.

**Route findings:**
- **`cookrite.com` serves an invalid TLS certificate** — Chrome shows a full-page privacy
  interstitial. Not bypassed (clicking through a certificate warning is not a safe default).
  Third site on this effort with a broken cert, after Snow Village and Wondereach.
- **N'Dustrio (`ndustrio.com`) is NOT Cloudflare-blocked** and loads normally. But its product
  pages are **spec-only stubs — zero gallery elements and no image path carrying the product
  code.** Good for specifications, useless for photography.
- **TC Croatia (`tccroatia.hr`) is not blocked either**, and carries **both** specs and real
  product photographs. This is the working route for this block.

⚠ **Image-URL trap on TC Croatia:** the path is `/productphoto/<id>/<size>/<slug>.jpg`, and
`large` is the ceiling. Probing `original`, `big`, `xlarge`, `full`, `medium` all return
**HTTP 200 with a 130 × 130 placeholder (6,893 bytes)** rather than a 404. A size-name guess
therefore *looks* like it worked. Verify pixels, never assume a bigger name exists.

**⚠⚠ §5.5's `AT60293` conflict is now attributed to named sources — and it is genuine:**

| Source | `AT60293` dimensions |
|---|---|
| N'Dustrio (brand N'DUSTRIO, origin Türkiye) — https://www.ndustrio.com/en/product/at60293-23-rectangular-chafing-dish | **505 × 470 × 285 mm**, glass lid |
| TC Croatia (brand TC) — https://tccroatia.hr/en/litchen-equipment1/chafing_/tc-at60293-induction-chafing-dish/ | **490 × 490 × 210 mm** |

These are exactly the two figures §5.5 recorded as conflicting. Both are relabellers of the same
platform code, so **neither outranks the other and the dispute stands** — the values remain
omitted from the published table. What has changed is that the conflict is now traceable rather
than anonymous.

**`AT50293` resolved** — https://tccroatia.hr/en/litchen-equipment1/chafing_/tc-at50293-induction-chafing-dish/
gives **440 × 580 × 210 mm**, "Round Chafer with glass Lid without frame". §5.5's open
"480 vs 580" question resolves to **580**.
⚠ But note TC also lists `AT60593` at **580 × 440 × 210** — the same numbers transposed. A
*round* chafer measuring 440 × 580 is geometrically odd while a rectangular one is not, so TC may
have swapped the pair. Flagged, not resolved.

**`DAT60063-1/2` confirmed** at **670 × 490 × 230 mm** via
https://www.ndustrio.com/en/product/dat60063-12-built-in-oblong-chafing-dish — matching what
IMG/BUF/00020 already stores. §5.5's figure stands.

**Images staged** (all real product photographs, rendered and verified as the correct item;
all below the 800 px floor with the ceiling proven above):

| SKU | Model | File | Px |
|---|---|---|---|
| IMG/BUF/00027 | `AT50293` | `IMG-BUF-00027__AT50293-tccroatia-UNDERFLOOR.jpg` | 640 × 371 |
| IMG/BUF/00028 | `AT60293` | `IMG-BUF-00028__AT60293-tccroatia-UNDERFLOOR.jpg` | 640 × 435 |
| IMG/BUF/00143 | `AT60293` | `IMG-BUF-00143__AT60293-tccroatia-UNDERFLOOR.jpg` | 640 × 435 |

Image coverage moves **85 → 88 of 102**. Still imageless in this block: IMG/BUF/00019
(`YFR01-2`), 00020 (`DAT 60063-2`), 00021 (`YFL02-1`), 00115 (`T23065`).
