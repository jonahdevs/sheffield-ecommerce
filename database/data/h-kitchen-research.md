# H-Kitchen Product Research

Research notes behind the H-KITCHEN enrichment/audit pass on `products.json` (July 2026).
Covers all 12 H-KITCHEN SKUs: 4 blender items, 2 coolers, a conveyor pizza oven, a bun
divider-rounder, a buffet hot pass, a gas "bain marie" (mislabeled), a hot/cold towel
cabinet, and a 4-burner gas range. Every claim below carries its source URL.

**The headline finding of this pass: "H-KITCHEN" in our catalogue is a supplier
attribution, not a manufacturer attribution.** Of the 12 SKUs, **none could be traced to
the H-Kitchen factory's own product range** — the real makers are five different Chinese
OEMs (§1.2). This is consistent, not contradictory: Hangzhou Kator is a _foreign-trade
company_, so it can consolidate and export other factories' goods under its label
(§1.3). Two records were completely empty, one product is mislabeled as a different
appliance class entirely, and nearly every populated record had at least one spec error —
see §5.

---

## 1. Brand identification

### 1.1 The real H-Kitchen

**H-KITCHEN** is a genuine brand, owned by **Kator International** (est. 2005; in catering
equipment since 1998), Xiaoshan District, Hangzhou, Zhejiang, China. Subsidiaries:

- **Hangzhou Kator Foreign Trade Co., Ltd.** — export/trading arm, runs the storefronts
- **Hangzhou Frigo Catering Equipments Co., Ltd.** — the factory (founded January 2010,
  10,211 m², ~110 staff across three companies, 4 production lines, ~4,000 showcases/yr)
- **Hangzhou Pinke Technology Co., Ltd.**

Brands: **H-KITCHEN, FRIGO, FREGO**. Six ranges: refrigeration, heating, food processing,
baking, stainless steel products, buffet/self-service. ISO 9001:2015; product certs CE,
IEC, GEMS, ETL, ETL-S, DOE, NRCan, CCC. Exports to 40+ countries. Ports: Ningbo/Shanghai.

| Resource                 | URL                                                         |
| ------------------------ | ----------------------------------------------------------- |
| Official site            | <http://h-kitchen.com> (see trap #1 — resets HTTPS fetches) |
| Made-in-China storefront | <https://h-kitchen.en.made-in-china.com>                    |
| Company profile page     | <https://h-kitchen.com/about.asp>                           |

### 1.2 …but our 12 SKUs don't come from them

Kator/Frigo's actual range is refrigeration showcases, ice machines, dough mixers, steel
tables and warming equipment. Their storefront has **no immersion blenders, jar blenders,
wine/beverage coolers, towel cabinets, conveyor ovens, or countertop gas ranges** — i.e.
almost nothing we sell under the label. Verified true origins:

| Our SKUs                         | True origin                                                                                                                          | Evidence                                                                                                                                                                                                                                                                             |
| -------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| IB350CV, BLD300, BLD400          | Unnamed Chinese OEM immersion-blender platform (sold as Hamoki, Adexa/Infernus, KRD, Asaki, Garyton, Twothousand, VEVOR…)            | [OEM factory manual PDF](https://infernus.co.uk/wp-content/uploads/2024/05/2023-10-19新-一代270-350-500BLD-N-电动搅拌机英文说明书.pdf) covering the whole IB/BLD/WIK family                                                                                                          |
| Blender 8002                     | Most likely **Zhongshan Longyue Electrical Appliance Co.** (LY-8002)                                                                 | [longyueblender.com](https://www.longyueblender.com/product-26000-rpm-high-speed-heavy-duty-professional-blender.html) — unique match on the 9850 motor + 2200 W + 4 L PC jar + soundproof cover                                                                                     |
| YC-53, YC-120-2D                 | **Zhongshan Yehos Electrical Appliance Co.** (also behind AOBOSI, BODEGAcooler, Koolatron)                                           | [yehos.com YC-53](https://www.yehos.com/Products_details/31.html), [YH-120-2D](https://www.yehos.com/Products_details/103.html)                                                                                                                                                      |
| NFK-30 bun divider               | **Guangzhou Southstar Machinery Facilities Co.**                                                                                     | [southstar-oven.com](https://www.southstar-oven.com/products_details/Semi-Automatic_Bun_Divider_Rounder.html); H-Kitchen's own MIC listing of the machine has no code/specs                                                                                                          |
| TC-2F hot pass, EHP-4S gas range | **Guangzhou Rebenet Catering Equipment Manufacturing Co.** (also makes our RGR24 "Sheffield Redline" range)                          | [rebenet.com EHP-4S](https://www.rebenet.com/4-burners-gas-countertop-range.html), [Rebenet TC-2F](https://rebenet.en.made-in-china.com/product/zOrGXstDbYcH/China-Tc-2f-Electric-Food-Warmer-Platter-Serving-Tray-Buffet-Hot-Plate-with-Top-Heating-Lamp-and-Protective-Cover.html) |
| HX-1SA conveyor oven             | Widely-cloned Guangzhou design; closest to OEM found: Dongpei Kitchen (DPHX-1SA); biggest distributor F.E.D. Australia ("Baker Max") | [dongpeikitchen.com](https://dongpeikitchen.com/product-item/electric-tunnel-pizza-oven-dphx-1sa/)                                                                                                                                                                                   |
| SOT-4 / KD 20SL-FL               | SOT series: Yiwu-traded countertop gas stove line; towel cabinet: **KANGDA (康达) KD-20SL** hotel-supply cabinet                     | [Yiwugo SOT-4S](https://en.yiwugo.com/product/detail/927709311.html), [Seeway KD-20SL](https://www.seewaymall.com/h-pd-586.html)                                                                                                                                                     |

Sheffield's own live site doesn't even use "H-Kitchen" consistently for these: the blender
family is branded **HK-REDLINE**, the coolers **BLUELINE**, the towel cabinet **PERPETUAL**.

### 1.3 HK-REDLINE is the same supplier — "HK" = H-Kitchen

Confirmed by the business (July 2026): **HK-REDLINE products also come through H-Kitchen**;
the "HK" is simply an abbreviation of H-Kitchen (paired with Sheffield's "Redline" house
line, cf. the sibling label SHEFFIELD REDLINE). The catalogue carries **105 HK-REDLINE
SKUs** vs 12 H-KITCHEN ones — the two labels are one supplier family, split for no
recorded reason.

This also resolves the apparent contradiction in §1.2: **Hangzhou Kator Foreign Trade
Co. is a trading/export company**, so "comes from H-Kitchen" means _imported via Kator_,
not _made by Frigo_. Kator consolidates goods from other Chinese factories (Yehos,
Rebenet, Southstar, Longyue, Kangda…) into its export containers, and Sheffield's label
records the supplier. Both facts are true at once: the invoice says H-Kitchen, the
nameplate design belongs to someone else.

Notably, the HK-REDLINE range fits the _actual_ Kator/Frigo factory catalogue much better
than our 12 H-KITCHEN SKUs do: back bar coolers with genuine Kator-style codes
(`HK-BC-01B/02B/03B`), pastry displays (`FGDG…` — Frigo's showcase line), deck ovens
(HTD/HTR), spiral and planetary mixers (BM-25…BM-100, B10GFA/B20GA/B30GA), plate-warmer
carts, dining carts (`HK-DC-M2A`) — i.e. refrigeration showcases, mixers and warming
equipment, exactly Kator's declared range. A future HK-REDLINE research pass should
therefore check **h-kitchen.com / the Made-in-China storefront first** — unlike this
pass, many of those SKUs likely ARE the factory's own products.

---

## 2. Where to look — and the traps

1. **`h-kitchen.com` resets HTTPS connections** (ECONNRESET on every direct fetch).
   Its content _is_ Google-indexed (`site:h-kitchen.com` works and pages exist under both
   `/about.asp` legacy paths and `/index/index/products.html?id=N`), so search snippets are
   usable, but plan on the **Made-in-China storefront** being the only reliably fetchable
   H-Kitchen source.
2. **Don't research "H-Kitchen" expecting to find our products.** Search the _model code_
   instead — every one of these items is multi-label OEM stock, and the richest spec data
   lives on other resellers' pages (UK/AU/NZ/US labels of the same units).
3. **Model codes come back cloned but consistent.** Cross-checking 3+ labels of the same
   unit (e.g. Hamoki + Twothousand + Al Bait Al Halabi for IB350CV) converged every time.
   Where one source disagreed, it was reliably the _variant_ trap (below).
4. **Variant traps everywhere:**
    - Yehos sells **two different products** as "YC-120-2D" — a wine-only 36-bottle unit and
      the wine+beverage split unit we sell. Match on zone layout, not code.
    - Southstar's NFK-30 (semi-auto) vs **NFK-30Q (fully-automatic)** — different dims,
      weight, and electrics; our record had mixed them (§5.8).
    - IB350 blenders exist as **CV (variable)** and CF (fixed speed); 110 V/60 Hz US builds
      of the coolers have different wattages — don't copy US figures.
5. **`sheffieldafrica.com` is upstream of our bad copy, not independent confirmation.**
   Several errors in `products.json` trace verbatim to Sheffield's live pages (the IB500LV
   spec block pasted into the IB350CV record; the 28.5 kg cooler weight). Use it to see
   what the company _claims_, never as a spec source.
6. **The OEM blender manual is the single best document found** — a factory English manual
   hosted by Infernus UK covering motors IB270/IB350/IB500/IB750 (TF/TV/LF/LV), tubes
   BLD160–BLD550-N and whisks WIK185/250, with full spec + compatibility tables. Bookmark:
   the URL is in §1.2.

---

## 3. Product reference

| SKU           | Catalogue name                                | Model                                          | Status          | Best source                                                                                                                                                                                                                                                        | Confidence                    |
| ------------- | --------------------------------------------- | ---------------------------------------------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ----------------------------- |
| IMG/FPR/00217 | Hand Immersion Blender 350W H-Kitchen         | IB350CV                                        | published       | [OEM manual](https://infernus.co.uk/wp-content/uploads/2024/05/2023-10-19新-一代270-350-500BLD-N-电动搅拌机英文说明书.pdf) + [Twothousand](https://www.twothousand.com/7-kinds-of-shaft-length-variable-speed-350w-commercial-immersion-blender-ib350cv-a-series/) | High                          |
| IMG/FPR/00220 | Immersion Blender Tube 300 Mm                 | BLD300(-N)                                     | published       | OEM manual attachment table                                                                                                                                                                                                                                        | High                          |
| IMG/FPR/00221 | Immersion Blender Tube 400 Mm                 | BLD400(-N)                                     | published       | OEM manual attachment table                                                                                                                                                                                                                                        | High                          |
| IMG/FPR/00274 | Kitchen Blender with Soundproof Cover         | 8002 (LY-8002)                                 | published       | [Longyue](https://www.longyueblender.com/product-26000-rpm-high-speed-heavy-duty-professional-blender.html) + [Adexa manual](https://adexa.co.uk/image/catalog/manuals/HS8003-8002-8001-MANUAL.pdf)                                                                | Med-High                      |
| IMG/DIS/00142 | Wine Cooler Under Counter YC-53               | YC-53                                          | published       | [Yehos](https://www.yehos.com/Products_details/31.html)                                                                                                                                                                                                            | High                          |
| IMG/DIS/00143 | Beverage Cooler YC-120-2D                     | ~~TYC-120-2D~~ → YC-120-2D (factory YH-120-2D) | published       | [Yehos](https://www.yehos.com/Products_details/103.html) + [AOBOSI](https://www.iaobosi.com/products/24-inch-beverage-and-wine-cooler-dual-zone)                                                                                                                   | High                          |
| IMG/OVE/00217 | Conveyor Pizza Oven-Digital                   | HX-1SA                                         | archived        | [Dongpei](https://dongpeikitchen.com/product-item/electric-tunnel-pizza-oven-dphx-1sa/) + [CE Catering](https://www.cecateringequipment.com.au/products/conveyor-pizza-oven-elec-belt-350mmw-6-7kw-415v-3o-8a)                                                     | High (specs) / Med (origin)   |
| IMG/PAS/00159 | Bun Divider                                   | ~~NFK-30I~~ → NFK-30                           | published       | [Southstar](https://www.southstar-oven.com/products_details/Semi-Automatic_Bun_Divider_Rounder.html)                                                                                                                                                               | High                          |
| IMG/BUF/00249 | Buffet Warmer Electric TC-2F                  | TC-2F                                          | published       | [Rebenet](https://rebenet.en.made-in-china.com/product/zOrGXstDbYcH/China-Tc-2f-Electric-Food-Warmer-Platter-Serving-Tray-Buffet-Hot-Plate-with-Top-Heating-Lamp-and-Protective-Cover.html) + [Hamoki](https://hamoki.co.uk/products/heated-lamp-display-p-101045) | High                          |
| IMG/HOT/00272 | Bain Marie Counter Top Gas SOT-4 ⚠ mislabeled | SOT-4                                          | archived, empty | [Yiwugo SOT-4S](https://en.yiwugo.com/product/detail/927709311.html) + our own IMG/HOT/00067 photo                                                                                                                                                                 | Med-High (identity), no specs |
| IMG/HYS/00196 | Towel Cabinet Hot & Cold KD 20SL-FL           | ~~KD 20SL-FL~~ → KD-20SL                       | published       | [Seeway/KANGDA](https://www.seewaymall.com/h-pd-586.html)                                                                                                                                                                                                          | Med                           |
| IMG/HOT/00267 | 4 Burner Gas Range Table Top EHP-4S           | EHP-4S                                         | archived, empty | [Rebenet](https://www.rebenet.com/4-burners-gas-countertop-range.html) + [Chefsrange](https://www.chefsrange.co.uk/shop/product/chefsrange-ehp-4s-4-burner-gas-boiling-top)                                                                                        | High                          |

---

## 4. Verified specifications per product

### 4.1 IB350CV — hand immersion blender (variable speed)

Source: OEM manual spec table; corroborated by Hamoki, Twothousand, Al Bait Al Halabi.

- Power **350 W** (CV = variable speed; CF sibling is fixed-speed)
- Voltage 220–240 V~ 50/60 Hz (dual-market design also built in 100–120 V/60 Hz)
- Speed **4,000–16,000 RPM** variable
- Motor body only: **2.1 kg**, 373 mm long, Ø96 mm (Hamoki quotes 1.8 kg; with 300 mm tube
  ≈ 2.8–3.15 kg total)
- Housing PA66+GF30 % + stainless; aluminium coupling head; screw-nut bayonet coupling
- Two-hand safety switch, overcurrent breaker, thermal cutout; 80–85 dB
- Takes tubes BLD200–BLD400-N and whisk WIK250; rated for containers up to ~40 L
  (Hamoki); must not run dry in air >10 s

### 4.2 BLD300 / BLD400 — blending tube attachments

**Passive, unpowered 304-stainless attachments** — no electrical specs apply. Current OEM
revision is BLD300-N / BLD400-N. From the OEM manual attachment table:

| Model    | Length | Ø     | Net weight | Fits                                        |
| -------- | ------ | ----- | ---------- | ------------------------------------------- |
| BLD300-N | 300 mm | 35 mm | 1.05 kg    | IB350CF/CV, IB500LF/LV — **not** the IB750s |
| BLD400-N | 400 mm | 35 mm | 1.26 kg    | IB350, IB500 **and** IB750 (all)            |

Construction: 304 S/S tube, output axis, bearing + sleeve, oil seals, blade bell,
removable smooth blade, spline sleeve. Not dishwasher safe; never immerse to the coupling.

### 4.3 Blender 8002 — commercial high-speed blender with sound enclosure

Source: Longyue LY-8002 factory page; Adexa HS8002 manual; SKT-8002 listing.

- 2,200 W, 220–240 V 50/60 Hz, motor model **9850** (pure copper) — all confirmed
- Up to **26,000 RPM** (some labels claim 27,000 — quote "up to 26,000" to be safe)
- 4 L PC (polycarbonate) jar confirmed as a factory variant (usable ≈ 3.8 L); 5.2 L exists
- Soundproof cover, S/S blades, variable speed + pulse, overload protection, CE
- Net weight ~8.5–9 kg
- Factory dims for the 4 L/5.2 L covered unit: **325 × 300 × 630 mm** — see §5.4

### 4.4 YC-53 — wine cooler (built-in column, 450 mm high)

Source: Yehos OEM page. All of our published specs check out:

- 53 L, 24 bottles, single zone **5–19 °C**, R600a, 75 W, 3 wood shelves, climate class
  SN/ST/N (≈ ambient 10–38 °C), 220–240 V/50 Hz
- Dims **592 × 563 × 450 mm** (W×D×H) — the "flat" shape is real; this is Yehos's
  **Built-in Column Series**, designed for niche/tall-cabinet integration, so "under
  counter" is a slight mischaracterization but not a different product
- 28.5 kg weight is Sheffield's figure — Yehos doesn't publish weight (unverified)

### 4.5 YC-120-2D — dual-zone wine & beverage cooler

Source: Yehos YH-120-2D page; AOBOSI US retail of the identical unit.

- 120 L total, dual zone: left (beverage) 2–10 °C, **57 cans** of 330 ml, 3 wire shelves;
  right (wine) 5–18 °C, **18 bottles**, 5+1 wood shelves
- R600a, **75 W** (the 115 V/60 Hz US build is 100 W — don't copy), 220–240 V/50 Hz
- 595 × 575 × 870 mm (an 820 mm-high build also exists), blue LED
- Factory code YH-120-2D; trade code YC-120-2D. **Beware**: Yehos also sells a wine-only
  36-bottle unit under "YC-120-2D" — ours is the wine+beverage split

### 4.6 HX-1SA — digital conveyor pizza oven

Source: Dongpei, CE Catering, Cafe Supply, F.E.D. "Baker Max" (our description text is
verbatim F.E.D. datasheet copy).

- 6.7 kW; standard build **220–240 V single-phase, ~28 A** (needs a dedicated circuit);
  separate 415 V 3N~ 8 A variant exists (HX-1SA/3N)
- Belt 350 mm usable width (belt 1,080 × 358 mm), tunnel clearance 60 mm
- Chamber body 560 × 555 × 420 mm; overall ~1,380–1,500 mm wide with belt ends fitted
- Net **49–50 kg** (gross ~57 kg); max 14″ pizza; ~16 × 300 mm pizzas/hr
- Digital speed+temp control, individual top/bottom temp, reversible belt, auto cool-down,
  stackable. **No published max temperature found — don't state one**

### 4.7 NFK-30 — semi-automatic bun divider-rounder

Source: Southstar official page; corroborated by FRESH (MY) and ETON listings.

- 30 portions/cycle, dough **30–100 g**/piece (0.9–3.0 kg per cycle), ~13 s cycle
- 0.75 kW, 220 V~ single-phase (380 V 3N~ also offered)
- Dims **650 × 600 × 1,370 mm**, net **345 kg**
- Variants: NFK-30Q (fully automatic, 640×540×2,100 mm, 485 kg, 3-phase), NFK-30H, and
  10/20/26/36-division builds

### 4.8 TC-2F — buffet hot pass / heated-lamp display

Source: Rebenet OEM page; Hamoki (UK item 101045); Buzz/Hurricane.

- **730 × 580 × 550 mm** (the "29×23×22" in our record was inches)
- Total rating **1 kW**, 220–240 V/50 Hz, 13 A plug; two independent heat zones
- Heated glass base 526 × 324 mm @ 250 W (exactly GN 1/1 footprint), EGO thermostat
  30–85 °C; twin infrared Philips lamps with separate on/off switch
- Capacity **2 × GN 1/1**; net 14 kg (gross 27 kg)
- Per-lamp wattage is inconsistent across sources (Rebenet says 150 W each, which doesn't
  sum to 1 kW; Philips IR lamps are typically 250 W) — **don't publish a per-lamp figure**

### 4.9 SOT-4 — ⚠ not a bain marie (see §5.6)

No verifiable spec set exists. The only external data point (Yiwugo SOT-4S countertop gas
stove): 570 × 630 × 530 mm, 44–50 kg, 4 burners, LPG.

### 4.10 KD-20SL — hot & cold towel cabinet (KANGDA)

Weak public data — Kangda publishes no full spec sheet online. Best picture:

- Single-door, **double-layer** hot/cold towel (sterilization) cabinet
- Dims resolve to **450 × 340 × 330 mm** (W×D×H) — matches the series pattern (sibling
  KD-13SL is 422 × 340 × 280 mm, 180 W, 30 towels)
- Our 230 V/300 W/40-towel figures are plausible for the bigger unit but unverified;
  cold ~10 °C / hot ~70 °C is the generic class spec, plausible
- **Capacity may be 20 L, not 15 L** (the "20" in the model code; unconfirmed)
- The "-FL" suffix appears nowhere outside Sheffield — likely an internal variant tag

### 4.11 EHP-4S — 4-burner countertop gas range (Rebenet)

Source: Rebenet official pages; Chefsrange + Catering Hygiene (UK label of same unit).
Record was completely empty — this is the full import set:

- 4 × octagon cast-iron open burners with lift-off heads, standby pilot per burner
  (Chefsrange build cites piezo + flame-failure device)
- **25,000 BTU/hr per burner, 100,000 BTU/hr total (~29.3 kW)**; NG/LPG convertible,
  ¾″ gas connection, governor required
- 4 × 305 × 305 mm heavy-duty cast-iron grates
- **600 × 690 × 340 mm** (W×D×H); packing 700 × 760 × 500 mm; net 57 kg / gross 70 kg
- Stainless front, galvanized sides/back, pull-out S/S crumb tray, adjustable S/S legs
- ETL listed (CE for EU); 1-yr factory parts warranty
- Same-OEM siblings for range building: EHP-2S (2-burner, 50,000 BTU, 300 × 690 × 340,
  32 kg), EHP-6S (6-burner, 150,000 BTU, 900 × 690 × 340)

---

## 5. Data audit — errors found

### 5.1 IB350CV record is contaminated with IB500LV copy ⚠

The description claims a "500-watt motor" and the spec block lists both
"350 W / 240 V / 50 Hz" _and_ "500W, 220V/50Hz or 110V/60Hz … Net weight: 3.1 kgs". The
500 W lines and the 3.1 kg weight are **Sheffield's IB500LV page text** pasted into the
350 W product. Correct: 350 W, 220–240 V, 2.1 kg motor (≈2.8–3.1 kg with tube).

### 5.2 Both blender tubes carry full-blender specs ⚠

BLD400's description is the _entire_ hand-blender description (500 W motor etc.), and both
tube records quote wattage/voltage/RPM/motor weight. These are **unpowered stainless
attachments** — all electrical specs must be stripped and replaced with the attachment
table in §4.2. Also worth fixing the naming pattern Sheffield uses ("HAND IMMERSION
BLENDER WITH 300MM TUBE" for a bare tube) — it reads as a complete blender.

### 5.3 TYC-120-2D model number is a typo ⚠

"TYC-120-2D" does not exist anywhere on the web. The trade code is **YC-120-2D** (factory
YH-120-2D). Bottle/can counts were also wrong: **18 bottles + 57 cans**, not 20 + 55
(confirmed by both Yehos and AOBOSI/BODEGAcooler listings of the same cabinet).

### 5.4 Blender 8002 dimensions look like a different variant's

Our 255 × 230 × 580 mm is closest to the SKT-8002 **2.8 L-jar** build (245 × 270 × 570).
The 4 L unit with sound enclosure is published at **325 × 300 × 630 mm**. A 4 L jar plus
soundproof cover inside a 255 mm footprint is implausible — measure a warehouse unit or
switch to the factory figure. The "NWB bearing" bullet is possibly a typo for the NMB
brand; the fixing-plate/oil-seal/bearing bullets are supplier claims we could not verify.

### 5.5 TC-2F dimensions were recorded in inches

`29 × 23 × 22` is 29″ × 23″ × 22″ = **730 × 580 × 550 mm**. The record also lacked the
unit's total rating (1 kW — only the 250 W glass element was listed), its 2 × GN 1/1
capacity, and its 14 kg weight. The rest of our copy matches the Rebenet OEM text
nearly verbatim (which itself supports the Rebenet origin).

### 5.6 SOT-4 is not a bain marie ⚠ serious

The record (name, "Buffet & Servery" category, auto-generated short description) calls it
a gas countertop bain marie. **No SOT-series gas bain marie exists anywhere.** Our own
catalogue contains the sibling **SOT-4S** ("4 Burner Table Top H Kitchen", IMG/HOT/00067,
brand HK-REDLINE) whose photo is unambiguously a **4-burner countertop gas stove**, and the
only external hit for the code (Yiwugo) is exactly that. SOT-4 should be renamed and
recategorized under Burners (or merged with/deduplicated against SOT-4S) — both are
archived, so this is low-urgency but the record as it stands is fiction.

### 5.7 HX-1SA electrical spec names a phase that doesn't exist

"230v-50Hz-**2Phase**" — there is no 2-phase build. Standard is 220–240 V **single-phase**
(~28 A, worth flagging as needing a dedicated circuit); a 415 V 3-phase variant exists as
HX-1SA/3N. Net weight 46 kg is understated vs the published 49–50 kg.

### 5.8 Bun divider record mixes two different machines ⚠ serious

Our dims (640 × 540 × 2,100 mm) belong to Southstar's **fully-automatic NFK-30Q**
(485 kg, 3-phase). The semi-automatic machine our description describes is
**650 × 600 × 1,370 mm, 345 kg**. Also, the "I" in "NFK-30I" is unattested — Southstar's
variants are NFK-30 / NFK-30Q / NFK-30H, and resellers worldwide use prefixes
(ET-NFK-30, IK-NFK-30), never an "I" suffix. Recommend model = NFK-30.

### 5.9 Towel cabinet dimension fields contradict each other

The dims columns say 450 × 330 × 340 while the spec text says 450/340/330. Resolves to
**450 W × 340 D × 330 H** (depth 340 matches the Kangda series). Model should read
KD-20SL; the "-FL" suffix is unattested outside Sheffield. Capacity may be 20 L not 15 L.

### 5.10 Two records were completely empty

SOT-4 (also mislabeled, §5.6) and EHP-4S had no description, no specs, no image. EHP-4S
now has a complete OEM spec set ready to import (§4.11); SOT-4 still has none.

### 5.11 Non-errors worth recording

- YC-53's odd "flat" dimensions (450 mm high) are **correct** — it's a built-in column
  unit, not a data error. Only refine 590×560→592×563 and note the series name.
- NFK-30 dough range 30–100 g, 30 portions, 0.75 kW — all confirmed exactly.
- TC-2F's glass-element spec block (526 × 324 mm, 250 W, EGO 30–85 °C) — confirmed exactly.
- 8002's electricals (2,200 W, 230 V, 9850 motor) — confirmed exactly.

---

## 6. Image sourcing

Verified-live image URLs by product (all are other-label photos of the identical OEM unit
unless noted):

| Product   | URL                                                                                                                                                                                                                                            |
| --------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| IB350CV   | <https://www.twothousand.com/wp-content/uploads/2022/12/ib350cv-a___1-1.jpg>; <https://albaitalhalabi.com/wp-content/uploads/2023/10/350W-IMMERSION-HAND-BLENDER-IB350CVBLD300.jpg>                                                            |
| 8002      | <https://canmac.co.uk/cdn/shop/files/8002H-1200x1200_700x700.jpg> (Adexa render)                                                                                                                                                               |
| YC-53     | Sheffield's own: <https://sheffieldafrica.com/storage/uploads/1759146847_Capture.PNG> (Yehos site lazy-loads; images not extractable)                                                                                                          |
| YC-120-2D | AOBOSI (branded but clean): <https://www.iaobosi.com/cdn/shop/files/AOBOSI-wine-andbeverage-cooler-120_1800x1800.jpg?v=1698224565> + interior/control shots on same CDN                                                                        |
| HX-1SA    | <https://www.cafesupply.co.nz/cdn/shop/products/hx-1sa3n-pizza-conveyor-oven-with-3-phase-power-246984.jpg>; <https://www.cecateringequipment.com.au/cdn/shop/files/electric-conveyor-pizza-oven-hx-series_1_335x.jpg>                         |
| NFK-30    | H-Kitchen's own listing: <https://image.made-in-china.com/202f0j00ZjvEyMbBLtoL/Dough-Divider-Dough-Rounder.webp>; FRESH: <https://www.kitchen-arena.com.my/media/catalog/product/cache/f603baa9e6784a7839c7e4f32d8fcf28/n/f/nfk-30_nfk-36.jpg> |
| TC-2F     | <https://hamoki.co.uk/cdn/shop/products/101045-3.jpg>; <https://hamoki.co.uk/cdn/shop/files/101045-4_web.png>                                                                                                                                  |
| EHP-4S    | Rebenet official: <https://img.yfisher.com/m5461/1720161153248-1/jpg100-t3-scale100.webp>                                                                                                                                                      |
| KD-20SL   | Kangda thumbnail (400 px only): `https://27254387.s21i.faiusr.com/2/ABUIABACGAAg45DnkAYogNq96QMwoAY4oAY!400x400.jpg`; Sheffield's own: <https://sheffieldafrica.com/public/storage/uploads/1695158986_KD20SL-FL.jpg>                           |
| SOT-4     | none (use/adapt the local SOT-4S photo `storage/app/public/products/4-burner-table-top-h-kitchen-imghot00067.jpg` if the record is fixed)                                                                                                      |

---

## 7. What could not be verified — left flagged rather than invented

- **IB/BLD OEM factory name** — the manual is anonymous, as is typical.
- **YC-53 weight (28.5 kg)** and glass-door detail — Sheffield-only claims.
- **YC-120-2D net weight** for the 230 V build (AOBOSI's 61.1 kg is the US variant,
  likely gross).
- **KD-20SL wattage, litre capacity, setpoints, weight** — no OEM spec sheet online.
- **TC-2F per-lamp wattage** — sources contradict; only the 1 kW total is safe.
- **HX-1SA max temperature** — no published figure anywhere.
- **SOT-4 specs** — nothing beyond the Yiwugo dims for the sibling SOT-4S.
- **8002 fixing-plate / oil-seal / bearing bullets** — supplier claims, unverifiable.
- Whether stock units are the "-N" revision (tubes) or ETL-vs-CE builds (EHP-4S).

---

## 8. Proposed `products.json` changes (not yet applied)

This pass was research-only. The corrections queued for the edit pass:

1. **IB350CV** — remove all 500 W/IB500LV text; specs per §4.1; weight 2.1 kg motor.
2. **BLD300/BLD400** — strip electrical specs; rewrite as tube attachments per §4.2
   (incl. the IB750-compatibility difference between the two).
3. **8002** — add 26,000 RPM, ~8.5 kg, S/S blade, overload protection; fix dims to
   325 × 300 × 630 mm (or measure stock); keep supplier-only bullets or drop.
4. **YC-53** — dims 592 × 563 × 450; add voltage + climate class; consider renaming
   "built-in/under-counter"; keep 28.5 kg flagged as unverified.
5. **YC-120-2D** — model_number TYC-120-2D → YC-120-2D; 18 bottles / 57 cans; add 75 W,
   R600a.
6. **HX-1SA** — fix electrics to 220–240 V 1-phase ~28 A; net 49–50 kg; add belt/chamber
   detail.
7. **NFK-30** — model NFK-30I → NFK-30; dims 650 × 600 × 1,370; weight 345 kg.
8. **TC-2F** — dims 730 × 580 × 550 mm; add 1 kW total, 2 × GN 1/1, 14 kg.
9. **SOT-4** — rename/recategorize as 4-burner countertop gas stove (or merge with
   SOT-4S); remove the bain-marie short description. Needs a business decision.
10. **EHP-4S** — import the full §4.11 spec set into the empty record.
11. **Brand attribution** — resolved in principle by §1.3: H-KITCHEN and HK-REDLINE are
    one supplier family ("HK" = H-Kitchen), so the split between the two labels (12 vs
    105 SKUs) is arbitrary. Whether to merge them into one brand, and which name wins,
    is a business decision; the display-casing entry lives in `brands.json` either way.
