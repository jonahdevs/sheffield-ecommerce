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

---

## Image sourcing (July 2026)

First image-sourcing pass ever run on this brand. All 12 SKUs were worked; every file below
was opened and visually verified before being kept. Staged in
`Desktop\ecommerce\products resource\h-kitchen-images\` (never copied into the project).
Resolution floor 800 px on the long edge; files below it are kept only where the ceiling was
proven and are suffixed `-TOOSMALL`.

Nothing was sourced from `sheffieldafrica.com`. §6's YC-53 and KD-20SL entries both pointed
at Sheffield's own uploads — both have now been replaced with genuinely independent sources.

### Applied to the project — 29 July 2026

Seven of these SKUs were re-fetched at a uniform 1512x1512 canvas and wired into
`products.json` and `storage/app/public/products/`. What changed:

| SKU | Cover | Gallery |
|---|---|---|
| IMG/DIS/00142 | replaced — was a 613 px **CM-badged** unit (finding 3); now the Yehos black-front shot | stainless 3/4 view, stainless front elevation |
| IMG/DIS/00143 | replaced — was 225 px | — |
| IMG/FPR/00274 | replaced — was 393 px | — |
| IMG/OVE/00217 | replaced — was 800x521 | — |
| IMG/PAS/00159 | replaced — was 615 px, same semi-automatic machine | — |
| IMG/HOT/00267 | **first image ever** — record had an empty `image` field | — |
| IMG/BUF/00249 | **kept** the existing 800 px iMettos shot — see caveat below | two Hamoki-source views |

Initially held back, then wired later the same day on explicit instruction:

- `IMG/HOT/00272` — the `REPRESENTATIVE-` stove photo is now this record's cover. It does **not**
  settle §5.6: the record is still a "Bain Marie" whose photograph is a 4-burner stove, and the
  business decision on what the SOT-4 actually is remains open. `model_number` untouched.
- `IMG/PAS/00159` now carries **two gallery images that are not the NFK-30** — the enclosed-head
  variant and the fully-automatic divider that finding 4 keeps as a counter-example. The browser
  had collapsed three different downloads onto one filename, stripping their `REF__` markers, so
  the filenames claim a machine they do not show. The cover is correct; the gallery is not.
  Worth revisiting if the PDP ever implies the gallery shows the same unit as the cover.

Two caveats on the 1512 px files:

1. They are **upscales**, not better sources. The YC-53 set is 800 px at origin and the Hamoki
   TC-2F files are 750 px; resampling to 1512 adds no detail. Where the stored cover was already
   at or above the source resolution — `IMG/BUF/00249`, whose 800 px iMettos shot beats a 750 px
   upscale — the original was kept.
2. The `-TOOSMALL` suffix on the TC-2F files is now misleading on disk: the pixel count clears the
   800 px floor while the real detail does not. The suffix reflects the source, and is correct.

Superseded covers were backed up before replacement, not overwritten in place.

### Per-file record

| File | px | size | Source URL | Visually confirmed |
|---|---|---|---|---|
| `IMG-FPR-00217__ib350cv-twothousand.jpg` | 1500x1500 | 25,908 B | https://www.twothousand.com/wp-content/uploads/2022/12/ib350cv-a___1-1.jpg | Teal IB350CV motor body with tube and 3-leg blade bell fitted. Two-hand trigger, vent slots, "IMMERSION BLENDER" nameplate. Faint TWOTHOUSAND.COM watermark across centre. |
| `IMG-FPR-00220__bld300-300mm-labelled-ggmgastro.jpg` | 850x850 | 40,009 B | https://image.made-in-china.com/2f0j00KoDvzMHBlJkp/Commercial-Immersion-Blenders-Tube-300-400-500mm-Hand-Hold-Blender-Stick.jpg | **Bare tube, no motor** — exactly the product class this SKU actually is. Explicit "300mm" dimension arrow beside it. ggmgastro logo top-left. Black knurled bayonet collar and 3-leg bell match the BLD-N design. |
| `IMG-FPR-00220__REPRESENTATIVE-bld-tube-short-mic.jpg` | 850x850 | 28,806 B | https://image.made-in-china.com/2f0j00NkLvrgDtbdqz/Commercial-Immersion-Blenders-Tube-300-400-500mm-Hand-Hold-Blender-Stick.jpg | Same tube family, shorter length, clean white background, unlabelled — length not provable, hence `REPRESENTATIVE-`. |
| `IMG-FPR-00220__bld-tube-family-4-lengths-garyton-TOOSMALL.jpg` | 640x640 | 11,604 B | https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/lpBpiKqkliSRpipipllpiq/TUBES.jpg | Four BLD tube lengths side by side, GRT (Garyton) watermark. **Ceiling proven**: the `TUBES-800-800.jpg` variant on the same CDN also returns 640x640. |
| `IMG-FPR-00221__REPRESENTATIVE-bld-tube-long-mic.jpg` | 850x850 | 32,336 B | https://image.made-in-china.com/2f0j00NcIBzEHsEmqu/Commercial-Immersion-Blenders-Tube-300-400-500mm-Hand-Hold-Blender-Stick.jpg | Bare long tube, white background. Right class and family; the listing covers 300/400/500 mm so 400 mm is not individually provable. |
| `IMG-FPR-00221__bld-tube-pair-garyton-TOOSMALL.jpg` | 640x640 | 8,356 B | https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/lqBpiKqkliSRpipiplkpiq/TUBES.jpg | Two tube lengths side by side, GRT watermark. Same proven 640 px ceiling. |
| `IMG-FPR-00274__blender-8002-canmac.jpg` | 1200x1200 | 52,668 B | https://canmac.co.uk/cdn/shop/files/8002H-1200x1200.jpg | Sound-enclosure blender, hood raised, PC jar with lid plug and handle. Base panel reads "High Quality Commercial Quite Blender" with timer dial (30-240 s), speed switch and timer switch. Matches the 8002 exactly. Shopify `_700x700` suffix stripped for the master. |
| `IMG-DIS-00142__yc-53-yehos-black-front.jpg` | 800x800 | 83,006 B | https://omo-oss-image.thefastimg.com/portal-saas/pg2025071414171175375/cms/image/d8989981-e3da-4602-b1b4-ca4f89c4a05c.jpg | Black-glass wide built-in wine cabinet, touch panel across the top, three wood shelf fronts. Yehos factory photography, no watermark. |
| `IMG-DIS-00142__yc-53-yehos-stainless-3q.jpg` | 800x800 | 83,823 B | https://omo-oss-image.thefastimg.com/portal-saas/pg2025071414171175375/cms/image/142807f5-a4db-47b6-a9ee-bd946608e5f1.jpg | Same cabinet, stainless-framed door, 3/4 view showing the shallow 450 mm-high oven-style body. |
| `IMG-DIS-00142__yc-53-yehos-stainless-front.jpg` | 800x800 | 91,835 B | https://omo-oss-image.thefastimg.com/portal-saas/pg2025071414171175375/cms/image/ee3be31c-5be0-4516-a12a-0ea16dc78dc0.jpg | Stainless front elevation, bar handle, digital display. |
| `IMG-DIS-00142__yc-53-yehos-door-open.jpg` | 800x800 | 141,099 B | https://omo-oss-image.thefastimg.com/portal-saas/pg2025071414171175375/cms/image/bbcd50bc-7a6a-4009-b2c1-5b13ace67a5f.jpg | Drop-down door open, bottles loaded on wood racks — proves the **drop-front, niche-mounted** design. |
| `IMG-DIS-00142__yc-53-yehos-dimension-drawing.jpg` | 1587x1132 | 104,810 B | https://omo-oss-image.thefastimg.com/portal-saas/pg2025071414171175375/cms/image/fe752d33-cccb-448f-b6b7-2f9fd76afcc2.jpg | **Factory dimension drawing.** Front view 592 wide x 450 high (453 aperture); side view 604 overall / 563 body / 520 carcass, 450 high. Shelf pitch marked 6/6/6/6/24. |
| `IMG-DIS-00142__yc-53-yehos-installation-drawing.jpg` | 1587x1132 | 116,173 B | https://omo-oss-image.thefastimg.com/portal-saas/pg2025071414171175375/cms/image/c9673ae1-3c61-4ad5-8f2a-670060f0c7cb.jpg | Cabinet-niche installation diagram with ventilation clearance — confirms built-in intent. |
| `IMG-DIS-00143__yc-120-2d-aobosi.jpg` | 1500x1500 | 197,886 B | https://www.iaobosi.com/cdn/shop/files/AOBOSI-wine-andbeverage-cooler-120_1800x1800.jpg | Twin-door dual-zone unit: left beverage compartment (cans on 4 levels), right wine compartment on wood racks, separate digital displays per zone, blue interior LED, kick-plate vent. AOBOSI badge on both doors (other-label build of the same cabinet). |
| `IMG-OVE-00217__hx-1sa-bakermax-fed-1100.jpg` | 1100x1100 | 77,374 B | https://www.foodequipment.com.au/media/catalog/product/e/l/electric-conveyor-pizza-oven-hx-series.jpg | Cleanest shot obtained of our exact body: stainless tunnel oven, mesh belt with both end trays fitted, blue/red control decals, twin knobs and fan grille, four adjustable legs. Magento `/cache/<hash>/` stripped for the original. |
| `IMG-OVE-00217__hx-1sa-cecatering-TOOSMALL.jpg` | 790x790 | 25,232 B | https://www.cecateringequipment.com.au/cdn/shop/files/electric-conveyor-pizza-oven-hx-series_1.jpg | Same oven, "Image is for illustrative purposes only F.E.D." footer. **Ceiling proven**: this is the Shopify master with the `_335x` suffix already stripped. |
| `IMG-OVE-00217__REF__conveyor-oven-justa-badge-mic.jpg` | 800x800 | 155,129 B | https://image.made-in-china.com/2f0j00FelCwLhPQmkD/Easy-to-Clean-and-Maintain-Heated-Pipe-Conveyor-Pizza-Oven.jpg | Same OEM tunnel oven but badged **JUSTA**, with a "Maximum size for the pizza: 14-inch" caption and control/belt detail insets. Kept as `REF__` — right design, different badge. |
| `IMG-PAS-00159__nfk-30-southstar-semiauto-3q.jpg` | 800x800 | 108,627 B | https://omo-oss-image.thefastimg.com/portal-saas/pg2025050909393709765/cms/image/28984403-5b5e-4ed7-9b54-0f9492ea79e1.jpg | Southstar factory shot of the **semi-automatic** divider-rounder: long manual press lever, yellow/black divider ring, cast pedestal base, green/red buttons and red-on-yellow isolator. Matches our stored photo. |
| `IMG-PAS-00159__nfk-30-kitchenarena-TOOSMALL.jpg` | 600x600 | 11,808 B | https://www.kitchen-arena.com.my/media/catalog/product/cache/f603baa9e6784a7839c7e4f32d8fcf28/n/f/nfk-30_nfk-36.jpg | Same machine, reseller listing explicitly captioned NFK-30/NFK-36. Kept below floor because it is the only source that names the model code against the picture. |
| `IMG-PAS-00159__REF__southstar-fully-automatic-divider-NOT-NFK-30.jpg` | 800x800 | 112,917 B | https://omo-oss-image.thefastimg.com/portal-saas/pg2025050909393709765/cms/image/bbbca007-908a-4d84-87a7-187d605a57d0.jpg | Southstar's **fully-automatic** divider: enclosed dome head, stainless cabinet on castors, spec plate. Kept deliberately as the visual counter-example to the dimensions currently stored on our record (see finding 4 below). |
| `IMG-PAS-00159__REF__southstar-enclosed-head-variant.jpg` | 800x800 | 117,165 B | https://omo-oss-image.thefastimg.com/portal-saas/pg2025050909393709765/cms/image/75db9063-10d4-4b1f-9a41-28cca0c83660.jpg | Third Southstar divider variant, enclosed head and no press lever. Range context only. |
| `IMG-BUF-00249__tc-2f-rebenet-800.jpg` | 800x800 | 74,264 B | https://image.made-in-china.com/2f0j00KvBVuFQcSekO/Tc-2f-Electric-Food-Warmer-Platter-Serving-Tray-Buffet-Hot-Plate-with-Top-Heating-Lamp-and-Protective-Cover.jpg | OEM (Rebenet) shot of the exact TC-2F: two-zone black heated glass base, stainless gantry, two IR lamps under a stainless canopy, tinted glass sneeze guards both sides, two control knobs. Rebenet logo watermark top-left. |
| `IMG-BUF-00249__tc-2f-rebenet-800-alt.jpg` | 800x800 | 72,217 B | https://image.made-in-china.com/2f0j00qQKMlBurCibc/Commercial-Electric-Food-Warmer-1000-W-Buffet-Hot-Plate-with-Top-Heating-Lamp-and-Protective-Cover-Tc-2f.jpg | Same unit, alternate angle; listing title carries the 1000 W total rating, corroborating §4.8. Rebenet watermark. |
| `IMG-BUF-00249__tc-2f-hamoki-TOOSMALL.jpg` | 750x750 | 22,408 B | https://hamoki.co.uk/cdn/shop/products/101045-3.jpg | UK-label (Hamoki 101045) shot of the identical unit. **Ceiling proven**: Shopify master with no size suffix. |
| `IMG-HOT-00272__REPRESENTATIVE-sot-4-countertop-4-burner-gas-stove-mic.jpg` | 800x800 | 159,962 B | https://image.made-in-china.com/2f0j00pnMCBvmPGkbo/Counter-Top-Gas-Stove-4-Burner.jpg | Countertop 4-burner gas stove with rear splash-back, cast grates, four red-marked knobs, adjustable feet; CE/CSA marks. Tieguan badge. **Not an SOT-coded unit** — see finding 5. |
| `IMG-HOT-00272__REPRESENTATIVE-sot-4-dimension-drawings-mic.jpg` | 800x800 | 198,485 B | https://image.made-in-china.com/2f0j00PyCeMEdJpkqc/Counter-Top-Gas-Stove-4-Burner.jpg | Four-view dimensioned drawing of the same class of countertop 4-burner stove. Reference for the class, not for our code. |
| `IMG-HYS-00196__kd-20sl-kangda-full.jpg` | 800x800 | 219,769 B | https://27254387.s21i.faiusr.com/2/ABUIABACGAAg45DnkAYogNq96QMwoAY4oAY.jpg | White single-door hot/cold towel cabinet, side vent grille, drain spigot bottom-right, "COOL HOT" decal. Seeway logo plus a Chinese supply-chain watermark. **Control-panel nameplate is legible** — see finding 2. Obtained by dropping the `!400x400` resize directive from §6's URL, which quadrupled the pixel count. |
| `IMG-HOT-00267__ehp-4s-rebenet.webp` | 800x800 | 87,778 B | https://img.yfisher.com/m5461/1720161153248-1/jpg100-t3-scale100.webp | Rebenet EHP-4S: four octagonal cast-iron open burners with lift-off heads, four square cast grates, stainless front with four knobs, galvanized sides, pull-out crumb tray, four adjustable legs. Matches §4.11 point for point. |
| `_brand-reference\oem-immersion-blender-IB270-350-500-BLD-N-family-manual.pdf` | - | 1,888,211 B | https://infernus.co.uk/wp-content/uploads/2024/05/2023-10-19%E6%96%B0-%E4%B8%80%E4%BB%A3270-350-500BLD-N-%E7%94%B5%E5%8A%A8%E6%90%85%E6%8B%8C%E6%9C%BA%E8%8B%B1%E6%96%87%E8%AF%B4%E6%98%8E%E4%B9%A6.pdf | The OEM family manual named in §2 trap 6, now archived locally. Multi-model, so exempt from the SKU-first filename rule. |
| `_brand-reference\bld-tube-length-comparison-garyton-TOOSMALL.jpg` | 576x390 | 7,146 B | https://iqrorwxhpjnjlm5p-static.micyjz.com/cloud/lnBpiKqkliSRpipirnppiq/duibitu.jpg | Garyton length-comparison diagram for the BLD tube range. Reference art, not a product photo. |

### Rejected during verification

- https://image.made-in-china.com/202f0j00ZjvEyMbBLtoL/Dough-Divider-Dough-Rounder.webp — §6's H-Kitchen
  Made-in-China listing for the NFK-30. The `2f0j00` full-size rewrite returns **196x369**, i.e. the
  thumbnail *is* the original; there is no large version. Deleted.
- https://albaitalhalabi.com/wp-content/uploads/2023/10/350W-IMMERSION-HAND-BLENDER-IB350CVBLD300.jpg
  — correct IB350CV+BLD300 unit but only 600x600 and wholly superseded by the 1500 px twothousand shot.
- https://www.cafesupply.co.nz/cdn/shop/products/hx-1sa3n-pizza-conveyor-oven-with-3-phase-power-246984.jpg
  — §6's HX-1SA link. Only 500x500, and it is the **3-phase HX-1SA/3N** listing, not our single-phase build.
- Two Made-in-China blender-tube lifestyle shots (tube in a pot of soup, and a kitchen collage) and a
  GGM Gastro EU type-examination certificate scan — filler, deleted.
- Made-in-China conveyor-oven trade-show and crated-packing photos — filler, deleted.
- https://image.made-in-china.com/2f0j00ZvLhfdMtEskp/Tc-2f-Electric-Food-Warmer-Platter-Serving-Tray-Buffet-Hot-Plate-with-Top-Heating-Lamp-and-Protective-Cover.jpg
  and https://image.made-in-china.com/2f0j00qMDWBkbKpjom/Tc-2f-Electric-Food-Warmer-Platter-Serving-Tray-Buffet-Hot-Plate-with-Top-Heating-Lamp-and-Protective-Cover.jpg
  — returned under the TC-2F search but show **round bain-marie soup wells**, a different Rebenet
  product sold under the same listing. Not staged.

### Coverage

12 SKUs in scope. Stated exactly, not rounded up:

| Bucket | Count | SKUs |
|---|---|---|
| Exact model, verified | 10 | IMG/FPR/00217, IMG/FPR/00220, IMG/FPR/00274, IMG/DIS/00142, IMG/DIS/00143, IMG/OVE/00217, IMG/PAS/00159, IMG/BUF/00249, IMG/HYS/00196, IMG/HOT/00267 |
| Representative only | 2 | IMG/FPR/00221 (BLD400 — correct tube family, 400 mm length not individually provable), IMG/HOT/00272 (SOT-4 — correct appliance class, no SOT-coded photo exists) |
| Nothing | 0 | — |

Of the 10 exact-model SKUs, all meet the 800 px floor. IMG/FPR/00220's exact-model file is 850 px;
the 640 px Garyton files kept alongside it are supplementary and marked.

The two `REPRESENTATIVE-` SKUs are deliberate abstentions from claiming more than the evidence
supports. For IMG/HOT/00272 in particular, attaching a photo of an unrelated 4-burner stove and
calling it an SOT-4 would have manufactured a fact; the record needs the §5.6 business decision
first, not a photograph.

### Findings

1. **Three SKUs share one byte-identical stored photo — and for two of them it is the wrong product
   class.** `IMG/FPR/00217` (IB350CV blender), `IMG/FPR/00220` (BLD300 tube) and `IMG/FPR/00221`
   (BLD400 tube) all resolve to files with md5 `830117bb53858a1c16a98361f080838d`. The image is a
   complete motorised hand blender. The two tube SKUs are unpowered stainless attachments, so the
   stored photo advertises a whole machine on records that sell a spare part, and the 300 mm and
   400 mm tubes are visually indistinguishable from one another in the catalogue. This is the visual
   counterpart of §5.2 and is arguably worse than the text problem it mirrors. **Not changed** — the
   staged `bld300-300mm-labelled-ggmgastro.jpg` is the fix candidate for 00220.
2. **The "-FL" suffix is genuine, and §4.10 is wrong about it.** §4.10 records that "-FL appears
   nowhere outside Sheffield — likely an internal variant tag". The 800 px Kangda photo shows the
   factory control-panel nameplate at readable resolution, and it reads **`KD-20 FL/SL`** beside the
   KD (Kangda) roundel, over a second line reading "KANGDA COLD & HOT TOWEL", with a `C` / `H`
   rocker either side. So our `KD 20SL-FL` is a scrambled but faithful rendering of the factory
   badge, not a Sheffield invention. Whether the catalogue should read `KD-20 FL/SL` is a call for
   the model-code owner; the code has **not** been touched.
3. **YC-53 is confirmed a built-in drop-front unit, not an under-counter one, and the numbers check
   out exactly.** The Yehos factory drawing gives 592 wide x 450 high, 563 deep body (604 with the
   handle, 520 carcass) — matching §4.4's `592 x 563 x 450` to the millimetre. The door-open shot
   shows a drop-down front, and the second drawing is a cabinet-niche installation diagram. The
   catalogue name "Wine Cooler **Under Counter** YC-53" therefore describes the wrong installation
   type. Separately, our own stored photo for this SKU is the same body **badged "CM"**, a third
   manufacturer's label — worth knowing before it is used as a reference for anything.
4. **The bun-divider photo and the bun-divider dimensions describe different machines.** Our stored
   photo, the Southstar factory shot and the Kitchen-Arena listing all show the *semi-automatic*
   lever-operated machine. The dimensions in the record (640 x 540 x 2,100 mm, 485 kg) belong to the
   *fully-automatic* NFK-30Q, which is staged here as
   `IMG-PAS-00159__REF__southstar-fully-automatic-divider-NOT-NFK-30.jpg` — an enclosed dome-head
   cabinet on castors that looks nothing like the photo we ship. §5.8 called this from the text
   alone; the images now confirm it from both sides.
5. **No SOT-coded product photograph exists anywhere.** Searched Made-in-China across the countertop
   gas-stove category and found no listing carrying an SOT code. This is a genuine negative, not a
   tooling failure — the same searches in the same session returned exact code matches for `TC-2F`
   and for the BLD tube family, so the search path was demonstrably working. It supports §5.6:
   `SOT-4` behaves like an internal Sheffield/Kator code, and the only defensible image for the SKU
   is a representative countertop 4-burner gas stove.
6. **OEM traces confirmed or extended by this pass** (first-class findings in their own right, per §1.2):
   - **Rebenet** — confirmed twice over, on the TC-2F (a Made-in-China listing carrying the exact code
     *and* the 1000 W rating in its title) and on the EHP-4S.
   - **Yehos** — confirmed for YC-53 with factory drawings, and for YC-120-2D via the AOBOSI build.
   - **Southstar** — confirmed for the semi-automatic NFK-30 from the factory's own photography.
   - **KANGDA** — confirmed for the towel cabinet, now down to the nameplate.
   - **Garyton (GRT)** and **GGM Gastro** — two further badges on the BLD tube family, on top of the
     Hamoki / Adexa / Infernus / VEVOR set already in §1.2. GGM Gastro is the useful one: it is the
     only source found that photographs a bare tube *with its length dimensioned*.
   - **JUSTA** (Guangzhou) — a further badge on the HX-1SA conveyor-oven design.
   - **F.E.D. / Baker Max** — the distributor named in §1.2 now sells this body as **`HX-1E`**
     (3-phase: `HX-1/3NE`). If stock is ever re-sourced through F.E.D., that is the code to quote.
7. **Model codes flagged in §8 are still unapplied in `products.json`.** `TYC-120-2D` (§5.3) and
   `NFK-30I` (§5.8) both still stand as recorded. Noted only; nothing edited.

### Tooling notes for the next pass

- The `!400x400` suffix on `s21i.faiusr.com` (Chinese "faisco" site builder) is a **resize
  directive, not part of the filename**. Dropping it returned a 4x-larger original and made an
  unreadable nameplate readable. Worth trying on any faiusr URL.
- `omo-oss-image.thefastimg.com` (the CDN behind both Yehos and Southstar) **403s without a
  `Referer` header** matching the site. With the header it serves 800 px originals freely.
- Made-in-China's `2f0j00` full-size rewrite is not universal — where the listing's original is
  genuinely small (the H-Kitchen NFK-30 listing), the rewrite returns the same small image rather
  than failing. Always check the returned pixel size, never assume the rewrite worked.
- Magento `/media/catalog/product/cache/<hash>/a/b/name.jpg` → drop `cache/<hash>/` for the
  un-resized original. This took the F.E.D. conveyor oven from 265 px to 1100 px.

---

## APPLIED 2026-07-30 — 13/13 house-format complete

Copy generated from SAP `Item Remarks`, which are unusually rich for this brand — voltage, power,
capacity, temperature bands, bottle/can counts and shelf make-up:

- `TYC-120-2D` — *230V/50Hz, 120 L, left 2-10 °C / right 5-18 °C, 57 cans + 18 bottles,
  3 metal shelves + 5+1 beech wooden shelves*
- `YC-53` — *230V/50Hz, 53 L, 5-19 °C, 24 bottles, 3 beech wood shelves*
- `KD 20SL-FL` — *230V/50Hz, 300 W, 15 L (40 towels), cold 10 °C / hot 70±10 °C, side open door*
- `NFK-30I` — *400V/50Hz, 0.75 kW, dough 30-100 g/pc, 30 pieces per cycle*

### ⚠ These remarks lost their line breaks in the export

The fields run together with no separator — *"5-18℃capacity: left 57 cans + right 18
bottlesshelves: 3 metal shelves"*. Splitting on `;`, `*` or ` - ` (which works for SV-Blueline
and OEM Sheffield respectively) returns **nothing** here. They have to be **mined by pattern**
instead — voltage, wattage, litres, °C ranges, bottle/can counts, BTU.

That makes three different remark punctuation styles across three brands. **Budget a parser pass
per brand; do not assume the previous brand's splitter transfers.**

A guard was added so a squashed spec dump is never published verbatim as a "Key Feature" bullet.

⚠ `IMG/OVE/00217`'s SAP `Make` is **`HKITCHEN`** (no hyphen) where every other row says
`H-KITCHEN`. Left alone — our `H-KITCHEN` is the value `brands.json` carries, and adopting SAP's
spelling would null `brand_id` at seed time.
