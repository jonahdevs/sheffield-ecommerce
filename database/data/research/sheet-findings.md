# Per-sheet findings — for review before anything is written into the workbook

Every one of the 732 rows in `Ecommerce Listing- All Categories.xlsx` carries one of five
statuses, shown in column M of its sheet. This file is the audit trail: **change any verdict
here and the workbook figures change with it.**

716 distinct items. The other 16 rows are duplicate group-header rows (RATIONAL and seven
other families list a parent row above its variants) and are excluded from every count so
they cannot inflate a total.

## How each status is decided

| Status | Rule | Evidence |
|---|---|---|
| **Sources disagree** | two sources contradict each other and nobody has settled it | `catalogue-open-issues.md` plus contradictions read individually in the per-SKU sourcing records |
| **No supplier data** | searched, and the supplier publishes nothing for this code | sourcing records |
| **Data on file, not yet listed** | a supplier document is on file but the listing text has not been written from it | staged spec sheets |
| **Our records only** | no manufacturer or supplier publishes anything for this item | no sourcing record and no staged source file |
| **Complete** | traced to a published source AND the listing actually carries its data | sourcing records + the information measure |

⚠ **What the automatic rules could not decide, I decided by hand.** 268 items carried a
machine signal suggesting a problem. 221 of those were `code_proven: false`, which records
only that the model code was not legible in the photograph — an image judgement, not a data
disagreement — so they do not touch the Mismatch count. The remaining 145 I read one by one;
57 were real contradictions and 88 turned out to be settled. The most common settled case is
**SAP being wrong where our listing already follows the manufacturer** — worth knowing, but
not something anyone needs to decide.

## Counts as they would appear on each sheet

| Sheet | Items | Complete | Sources disagree | No supplier data | Data on file | Our records only |
|---|---:|---:|---:|---:|---:|---:|
| BAKERY PREPARATION | 22 | 19 | 3 | 0 | 0 | 0 |
| BEVERAGE MACHINES | 27 | 24 | 0 | 3 | 0 | 0 |
| BUFFET & SERVERY | 61 | 42 | 13 | 4 | 1 | 1 |
| COFFEE MACHINES | 45 | 33 | 11 | 1 | 0 | 0 |
| COOKING EQUIPMENT | 77 | 50 | 20 | 4 | 0 | 3 |
| DISHWASHERS | 30 | 23 | 6 | 1 | 0 | 0 |
| DISPLAYS | 30 | 24 | 1 | 1 | 0 | 4 |
| FLOOR CARE & CLEANING | 56 | 50 | 0 | 1 | 1 | 4 |
| FOOD PREPARATION | 57 | 39 | 11 | 1 | 0 | 6 |
| HYGIENE | 25 | 10 | 2 | 12 | 0 | 1 |
| ICE & ICE CREAM MACHINES | 17 | 15 | 2 | 0 | 0 | 0 |
| JUICE PROCESSORS | 36 | 31 | 2 | 2 | 0 | 1 |
| KITCHEN SMALLS | 55 | 50 | 2 | 3 | 0 | 0 |
| OVENS | 34 | 26 | 6 | 2 | 0 | 0 |
| RATIONAL COMBI STEAMERS | 44 | 41 | 2 | 0 | 1 | 0 |
| REFRIGERATION | 86 | 79 | 7 | 0 | 0 | 0 |
| STORAGE & FOOD TRANSPORT | 14 | 13 | 0 | 1 | 0 | 0 |
| **Whole catalogue** | **716** | **569** | **88** | **36** | **3** | **20** |

## ⭐⭐ Why some rows moved out of Resolved

A first pass measured description length and spec-table row count. That measures **volume,
not information**, and it was wrong. `IMG/BUF/00092` (Juice Dispenser 1 Bowl) passed it with
33 words and 4 spec rows, yet the record holds exactly **one fact** - its 10 litre capacity,
which is already in its own name. Its other three spec rows are Brand, Model and Type, which
are identity fields rather than specifications, one of its two bullets repeats the other, and
one of its two sentences is filler.

Every row is now scored on **facts**: spec-table rows that are not identity fields, plus
bullets that add something the spec table does not already say.

- **3 rows moved from Resolved to Not yet written up** - they carry 2 or fewer facts
  while similar items on the same sheet carry 5 or more, so the data plainly exists. The worst
  are an espresso machine with 2 facts against a category median of 16 and a display cabinet
  with 1 against 18.
- **60 rows stay Resolved but now carry a caveat note**, either because their whole
  category is sparse (POTS & PANS averages 1 fact per item, FOOD WARMERS 2) or because they
  are merely thinner than their siblings rather than empty.

⚠ Two whole categories are thin enough to be worth a decision of their own: **POTS & PANS**
and **FOOD WARMERS** carry almost no specifications on any item, so no per-row rule can flag
them - their medians are the problem.

## Every item that is not Complete

Grouped by sheet, in sheet order. These are the rows that would carry a note in column N.

### BAKERY PREPARATION

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/PAS/00145` | Cake Mixer Planetary 30 Litres H-Kitchen | Sources disagree | Our listing says B30GA; both SAP and the Kator catalogue call the 30 litre machine B30GA2. Confirm which code is correct. |
| `IMG/PAS/00159` | Semi Automatic Dividing And Rounding Machine | Sources disagree | height 2100 mm (ours) vs 1460 mm (supplier site) |
| `IMG/PAS/00166` | Bread Moulder | Sources disagree | the capacity field holds the net weight (237 kg) |

### BEVERAGE MACHINES

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/COF/00026` | Water Boiler Insulated 10 Litres | No supplier data | no source located - no description and no specification table |
| `IMG/COF/00098` | Heated Insulated Water Urn 40 Litres | No supplier data | no source located - no description and no specification table |
| `IMG/COF/00108` | Water Boiler Ef-20 (Hydroboil) | No supplier data | EF-20 returns nothing published. The stored 160 x 170 mm footprint is far too small to be the boiler itself. |

### BUFFET & SERVERY

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/BUF/00019` | Chafing Dish Drop In Oblong H Kitchen | Sources disagree | C2. IMG/FPR/00110 is still displaying a Waring spice grinder |
| `IMG/BUF/00027` | Chafing Dish Induction Round At50293 H Kitch | Sources disagree | chafer depth 580 (supplier) vs 480 (SAP), unexplained |
| `IMG/BUF/00028` | Chafing Dish Induction Square H-Kitchen | Sources disagree | duplicate of IMG/BUF/00143, and the axes are swapped |
| `IMG/BUF/00031` | Plate Warmer Cart Single | Sources disagree | Rebenet CKS build 450x543x865 vs our 450/485/770 |
| `IMG/BUF/00032` | Plate Warmer Cart Double | Sources disagree | Rebenet DR-2CKS 450x967x865 vs our 450/910/770 |
| `IMG/BUF/00037` | Chafing Dish Drop In | Sources disagree | photo is a free-standing roll-top, record describes a drop-in |
| `IMG/BUF/00143` | Chafing Dish Induction Square At60293 H-Kitc | Sources disagree | duplicate of IMG/BUF/00028, and the axes are swapped |
| `IMG/BUF/00177` | Chafing Dish Roll Top 9 Litres Ra2301 | Sources disagree | stored figures are the carton, not the product |
| `IMG/BUF/00219` | Chaffing Dish 9L Oblong Roll Top Chafer | Sources disagree | Heavybao 635x425x440 vs our 645/455/290 |
| `IMG/BUF/00220` | Chaffing Dish 9L Oblong Roll Top Chafer With | Sources disagree | dimensions copied from 00219, never verified for this code |
| `IMG/BUF/00244` | Heating Lamp Copper | Sources disagree | Stored dimensions 640 x 480 x 750 mm are byte-identical to a juice dispenser record and are impossible for a pendant lamp. |
| `IMG/HOT/00272` | Bain Marie Counter Top Gas Sot-4 | Sources disagree | heat input 27,700 BTU/hr (ours) vs 6 kW (maker) |
| `IMG/HOT/00275` | Bain Marie Table Top H-Kitchen Bs-4 | Sources disagree | depth should be 590 not 600, height 230 missing |
| `IMG/BUF/00022` | Cup Warmer H Kitchen | No supplier data | No reseller carries the Kator 2009/ED code and no specification is published for it. |
| `IMG/BUF/00145` | Chafing Dish Drop In Hy-902 | No supplier data | no source located - no description and no specification table |
| `IMG/BUF/00146` | Chafing Dish Oval Hy-836 | No supplier data | no source located - no description and no specification table |
| `IMG/BUF/00236` | Heating Lamp Infrared 900Mm | No supplier data | XD-HHB900 returns nothing on the open web, on Made-in-China product search, or in the Wanhui catalogue. |
| `IMG/HOT/00005` | Food Warmer Electric Bertos | Data on file, not yet listed | Bertos 700-series datasheets are on file; the listing text has not been written from them yet. |
| `IMG/BUF/00261` | Hot Pot With Warmer Stove 36Cm Stainless Ste | Our records only | searched, nothing published by any manufacturer - written from our own records |

### COFFEE MACHINES

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/COF/00004` | Coffee Brewer Single Cater | Sources disagree | SAP 2500 W and the 45 min brew time both contradicted |
| `IMG/COF/00006` | Coffee Brewer With 2 Decanter | Sources disagree | CREM's own sheets disagree with each other |
| `IMG/COF/00009` | Serving Station 2.5 Litres | Sources disagree | three sources give three different sizes |
| `IMG/COF/00010` | Serving Station 5 Litres | Sources disagree | same conflict as the 2.5 L serving station |
| `IMG/COF/00011` | Air Pot With Sight Gauge | Sources disagree | kaffe-rep 160x412x200 vs Parts Town 140x140x400 |
| `IMG/COF/00012` | Thermos Percolator Ss | Sources disagree | named a percolator, the source resolves it as a vacuum jug |
| `IMG/COF/00097` | Milk Fridge Sc15 | Sources disagree | record carries the SC10 sibling figures (65 W / 10 L) |
| `IMG/COF/00103` | Coffee Brewer With 1 Decanter Flt120 Black | Sources disagree | B7. Two model numbers disagree between the workbook and products.json |
| `IMG/COF/00104` | Coffee Brewer With 2 Decanter Flt120-2 Inox | Sources disagree | B7. Two model numbers disagree between the workbook and products.json |
| `IMG/COF/00138` | Coffee Brewer With Double Cater (Thermos) | Sources disagree | stored dimensions belong to FLT120-2, not to any FLS |
| `IMG/COF/00141` | Commercial Coffee Brewer Gw-Frp286-Bv (Frp-2 | Sources disagree | VEVOR's drawing and its own spec row disagree |
| `IMG/COF/00007` | Cup Dispenser | No supplier data | The record carries no model number, so there is nothing to search a supplier catalogue on. |

### COOKING EQUIPMENT

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/BUF/00030` | Induction Cooker H Kitchen Eb-1200 | Sources disagree | no wattage or voltage on record, height reads 9 mm |
| `IMG/BUF/00227` | Induction Cooker Drop In 3Kw Sl-30C-Xp3 | Sources disagree | SAP says 3 kW, the manufacturer page says 3500 W |
| `IMG/BUF/00229` | Induction Wok 5Kw Table Top Single Sl-G50-Ka | Sources disagree | supplier 530x400x260 vs our 525/440/265, 40 mm on width |
| `IMG/BUF/00230` | Induction Cooker Two Zone Table Top 7Kw | Sources disagree | supplier code is SL-C351-2E3-Y, ours is KPP3-Y |
| `IMG/BUF/00233` | Induction Fryer 23L Sl-Fr1C23A | Sources disagree | the only source contradicts the capacity in the product name |
| `IMG/HOT/00042` | Fryer Double 25 Litres Table Top Electric El | Sources disagree | Flamemax 8.5+8.5 L / 2.8 kW vs our 12+12 L / 4.5 kW |
| `IMG/HOT/00048` | 4 Burner Table Top Fagor Cg7-40 | Sources disagree | our power figures belong to the CG7-40 H, a different model |
| `IMG/HOT/00066` | Salamander Electric Lift Up Eb-450 | Sources disagree | height 500 (SAP) vs 400 (ours) vs 470 (maker), none agree |
| `IMG/HOT/00071` | Salamander Electric Lift Up Eb-600 | Sources disagree | SAP 600x450x500 matches no published figure |
| `IMG/HOT/00098` | Fryer Roller Grill Rfg 12 | Sources disagree | SAP 8-9 kW, Roller Grill publishes 8 kW flat |
| `IMG/HOT/00156` | Infra Red Grill Mercatus Xl Mc167 | Sources disagree | the XL cabinet is larger than the XXL, range naming inverted |
| `IMG/HOT/00333` | Pressure Fryer Gas Broaster 1800 | Sources disagree | no electrical rating - needs the Kenyan-build figure |
| `IMG/HOT/00354` | Panini Grill Double Gh-813 | Sources disagree | depth 350 vs 305 |
| `IMG/HOT/00384` | Charcoal Grill Automatic 850Mm 20 Skewers Tr | Sources disagree | the drawing says 80 cm, the maker spec table says 850 mm |
| `IMG/HOT/00388` | Fryer Split Type 15 + 15 Ltrs H-Kitchen | Sources disagree | SAP 730x500x230 is not this machine |
| `IMG/HOT/00402` | Microwave Oven 25Ltr Em025Fjts0Sf00 | Sources disagree | supplier model code differs from ours |
| `IMG/HOT/00403` | Microwave Oven 34Ltr Ema34Gtqs00E00 | Sources disagree | supplier model code differs from ours |
| `IMG/HOT/00417` | Waffle Maker Double Wb-2 | Sources disagree | SAP 500x320x300 disagrees with the maker |
| `IMG/HOT/00421` | Elec Fryer Ef-28L | Sources disagree | maker figure contradicts our stored 400x700x290 |
| `IMG/HOT/00436` | Fryer Split Type 10 + 10 Litres Hds Electric | Sources disagree | This SKU is the electric split fryer, but the photograph on file is the gas model from the same family. Needs the electric spec and photo. |
| `IMG/BUF/00051` | Induction Cooker Kassidy | No supplier data | The Kassidy code is not published on any reachable supplier or reseller site. |
| `IMG/BUF/00090` | Induction Cooker Wanhui | No supplier data | SAP names Wanhui as the supplier, but the code itself is not published anywhere reachable. |
| `IMG/HOT/00067` | 4 Burner Table Top H Kitchen | No supplier data | No source carries this code. The only image found is an unlabelled marketplace photo, so nothing can be verified against it. |
| `IMG/HOT/00281` | Electric Conveyor Toaster H260D | No supplier data | no source located - no description and no specification table |
| `IMG/HOT/00255` | 6 Burner Gas Range With Gas Oven Rgr36 Redli | Our records only | no external source published - written from our own records |
| `IMG/HOT/00256` | 4 Burner Gas Range With Gas Oven Rgr24 Redli | Our records only | no external source published - written from our own records |
| `IMG/HOT/00257` | Fryer Single 23 Litres Gas Gf90 Redline | Our records only | no external source published - written from our own records |

### DISHWASHERS

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/DWW/00043` | Glass Rack Extender 25 Compartment | Sources disagree | JIWINS gives 500x500x45, we store 500/500/100 |
| `IMG/DWW/00097` | Plate Rack 64 Compartment Jw-64B | Sources disagree | colour: the spec says Blue, the SAP remark said Beige |
| `IMG/DWW/00107` | Plate Racks 64 Comp Camrack Grey | Sources disagree | Listing says 64 compartments; the Cambro part sourced (PR59314) is a 5 x 9 peg rack holding 18 plates. Confirm which product this is. |
| `IMG/DWW/00110` | Open Rack Jw-Ss | Sources disagree | duplicate of IMG/DWW/00143 - merge or keep both |
| `IMG/DWW/00143` | Open Rack Jw-S | Sources disagree | duplicate of IMG/DWW/00110 - merge or keep both |
| `IMG/DWW/00144` | Cutlery Rack Jw-C | Sources disagree | photograph is byte-identical to JW-S, shows the wrong rack |
| `IMG/DWW/00150` | Glass Rack 49 Compartment Jw-49 | No supplier data | No published specification found for JW-49. |

### DISPLAYS

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/DIS/00020` | Pastry Display Square 1800 | Sources disagree | description is the LILY series, the code is an ORCHID |
| `IMG/REF/00203` | Vertical Display Cabinet Triple Door Chiller | No supplier data | No published specification found for this cabinet. |
| `FAB/DIS/00007` | Meat Display Counter 1500 | Our records only | no external source published - written from our own records |
| `FAB/DIS/00010` | Meat Display Counter 2000 | Our records only | no external source published - written from our own records |
| `IMG/DIS/00144` | Ice Cream Display Lk-1.6By | Our records only | no external source published - written from our own records |
| `IMG/DIS/00145` | Ice Cream Display Lk-1.2Dd | Our records only | no external source published - written from our own records |

### FLOOR CARE & CLEANING

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/HYS/00230` | Accessories Set For Aquamat 10.1 | No supplier data | The contents of the Aquamat 10.1 accessory set are not published. |
| `IMG/HYS/00229` | Filter Cloth With Ring For Vacumat 44T | Data on file, not yet listed | The TASKI Vacumat accessory sheet is on file; the listing text has not been written from it yet. |
| `IMG/HYS/00237` | Detergent Spot Remover | Our records only | no external source published - written from our own records |
| `IMG/HYS/00238` | Detergent Parfum | Our records only | no external source published - written from our own records |
| `IMG/HYS/00239` | Carpet Shampoo 20 Lts | Our records only | no external source published - written from our own records |
| `IMG/HYS/00271` | Steam Cleaner | Our records only | no external source published - written from our own records |

### FOOD PREPARATION

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/FPR/00046` | Meat Slicer Ø 300Mm | Sources disagree | no electrical rating - needs the Kenyan-build figure |
| `IMG/FPR/00110` | Potato Chipper Table Top Kayalar | Sources disagree | photograph is a Waring spice grinder, not a potato chipper |
| `IMG/FPR/00164` | Meat Grinder 22 Model Tk -22 | Sources disagree | 0.85 kW is the TD-12 row, the TK-22 is 1100 W |
| `IMG/FPR/00180` | Electric Sausage Stuffer | Sources disagree | dimensions shared with 00181, one of the two is wrong |
| `IMG/FPR/00181` | Meatball Making Machine | Sources disagree | dimensions shared with 00180, one of the two is wrong |
| `IMG/FPR/00231` | Vacuum Packing Machine Dz300 | Sources disagree | ultimate vacuum figure is not credible as stated |
| `IMG/FPR/00232` | Vacuum Packing Machine Dz400 | Sources disagree | stored dimensions are the vacuum chamber, not the machine |
| `IMG/FPR/00239` | Commercial Vegetable Food Processor Qc205A | Sources disagree | SAP 750 W vs 350 W (QC205) and 1000 W (QC205A) |
| `IMG/FPR/00250` | Assorted Blade 3Pack R301Ud | Sources disagree | Part number 2006 is not a Robot Coupe reference. Robot Coupe lists the serrated blades as 18565 and 18566. Confirm the actual part. |
| `IMG/FPR/00253` | Bone Sawer Jg210 | Sources disagree | cutting 4-180 mm / table 195x220 vs our 5-155 / 500x380 |
| `IMG/FPR/00254` | Bone Sawer Jg310 | Sources disagree | bench and cutting figures disagree with the maker |
| `IMG/FPR/00906` | Bone Saw Blade 1650Mm | No supplier data | no source located - no description and no specification table |
| `FAB/FPR/00241` | Potato Peeler 50 Kg Sheffield | Our records only | no external source published - written from our own records |
| `FAB/FPR/00315` | Potato Peeler 25 Kg Sheffield | Our records only | no external source published - written from our own records |
| `FAB/FPR/00372` | Potato Peeler 15 Kg Sheffield | Our records only | no external source published - written from our own records |
| `FAB/FPR/00435` | Potato Peeler 10 Kg Sheffield | Our records only | no external source published - written from our own records |
| `FAB/FPR/00458` | Potato Peeler 30 Kg Sheffield | Our records only | no external source published - written from our own records |
| `IMG/FPR/00080` | Chopping Board Green | Our records only | no external source published - written from our own records |

### HYGIENE

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/HYS/00281` | Insect Killer 30W Spider Type | Sources disagree | The model number recorded (30W) is the wattage, not a part code, and no supplier lists a "Spider Type" killer. Needs the real code. |
| `IMG/HYS/00282` | Insect Killer 45W Spider Type | Sources disagree | The model number recorded (45W) is the wattage, not a part code, and no supplier lists a "Spider Type" killer. Needs the real code. |
| `IMG/COF/00070` | Water Softeners Hlt.12 | No supplier data | no source located - no description and no specification table |
| `IMG/HYS/00014` | Wall Mounted Retractable Hose Reel | No supplier data | no source located - no description and no specification table |
| `IMG/HYS/00032` | Insect Killer Pj-Fk40 | No supplier data | no source located - no description and no specification table |
| `IMG/HYS/00220` | Hand Wash Basin Knee Operated Yls42 | No supplier data | no source located - no description and no specification table |
| `IMG/HYS/00221` | Hand Wash Basin 400X400 Yls44B | No supplier data | no source located - no description and no specification table |
| `IMG/HYS/00266` | Stainless Steel Container 100X100Mm | No supplier data | No model number and nothing published. The only figures are the 100 x 100 mm in the item name. Needs a spec from the supplier. |
| `IMG/HYS/00267` | Stainless Steel Container 125X135Mm | No supplier data | No model number and nothing published. The only figures are the 125 x 135 mm in the item name. Needs a spec from the supplier. |
| `IMG/HYS/00268` | Stainless Steel Container 150X165Mm | No supplier data | No model number and nothing published. The only figures are the 150 x 165 mm in the item name. Needs a spec from the supplier. |
| `IMG/HYS/00269` | Stainless Steel Container 190X200Mm | No supplier data | No model number and nothing published. The only figures are the 190 x 200 mm in the item name. Needs a spec from the supplier. |
| `IMG/HYS/00273` | Insect Killer 2X15 Watts | No supplier data | no source located - no description and no specification table |
| `IMG/HYS/00283` | Hand Wash Basin Knee Operated Hswm-001 | No supplier data | HSWM-001 is not published by any supplier reached. |
| `IMG/HYS/00284` | Hand Wash Basin Wall Mounted Hswm-006 | No supplier data | no source located - no description and no specification table |
| `IMG/HYS/00274` | Food Sink Shredder Disposer Ed1100 | Our records only | no external source published - written from our own records |

### ICE & ICE CREAM MACHINES

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/REF/00019` | Ice Cube Machine Zbj-150P Iberna | Sources disagree | SAP figure is the head unit only, not the split machine |
| `IMG/REF/00022` | Ice Cube Machine Zbj-40P Iberna | Sources disagree | no 895 mm tall 40 kg machine exists, stored height wrong |

### JUICE PROCESSORS

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/FPR/00038` | Blender Kitchen 25 Litres Ss | Sources disagree | model number: workbook LAR 25MB vs record LAR-25LMB |
| `IMG/FPR/00228` | Immersion Blender Cmp 300 Vv | Sources disagree | dimensions identical to the CMP 400 row, contaminated |
| `IMG/FPR/00219` | Immersion Blender Tube 250 Mm | No supplier data | no source located - no description and no specification table |
| `IMS/MEC/01890` | Complete Jug Set For Brushless Blender | No supplier data | no source located - no description and no specification table |
| `IMG/FPR/00093` | Brushless Commercial Blender | Our records only | no external source published - written from our own records |

### KITCHEN SMALLS

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/HOT/00169` | Pressure Cooker 40 Litres | Sources disagree | Our listing says stainless steel; the Time Saver source lists this cooker as aluminium. Confirm the material before quoting. |
| `IMG/HOT/00170` | Pressure Cooker 60 Litres | Sources disagree | Our listing says stainless steel; the Time Saver source lists this cooker as aluminium. It is also illustrated by the 40 litre unit. |
| `IMG/TCW/00006` | Casserole High Andyman 58122 | No supplier data | no source located - no description and no specification table |
| `IMG/TCW/00363` | Stock Pot 12 Litres Ei2525 | No supplier data | no source located - no description and no specification table |
| `IMG/TCW/00366` | Casserole 24 Litres E13624 | No supplier data | no source located - no description and no specification table |

### OVENS

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/OVE/00087` | Gas Deck Oven Single Htr-20Q | Sources disagree | Garyton publishes 1350 x 850 x 600 mm; we store 980 x 540 x 600 mm. The description is also copied from the smaller HTR-101C. |
| `IMG/OVE/00201` | Oven Convection Gas Hds Gco | Sources disagree | no electrical rating - needs the Kenyan-build figure |
| `IMG/OVE/00206` | Deck Oven Gas Single 1 Tray Htr-10C | Sources disagree | Garyton 980x610x500 vs SAP 980/600/540 |
| `IMG/OVE/00229` | Elec. Convection Oven Yxd-1Ae | Sources disagree | spec sheet 595x530x570 vs SAP 1005/930/560 |
| `IMG/OVE/00230` | Elec. Convection Oven Yxd-8A-3 | Sources disagree | spec sheet 834x765x500 vs the same SAP row as 00229 |
| `IMG/OVE/00234` | 4" Hamburger Pan-15 | Sources disagree | SAP 915/690/355 reads as a carton, not a pan |
| `FAB/PSB/00061` | Oven Stand Os85075S 201 Grade Height 670 | No supplier data | no source located - no description and no specification table |
| `IMG/OVE/00130` | Baking Trays | No supplier data | no source located - no description and no specification table |

### RATIONAL COMBI STEAMERS

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/HYS/00265` | Rational Care Cartridge | Sources disagree | weight disagreed 11x between two distributors |
| `IMG/OVE/00027` | Connection Kit | Sources disagree | The only datasheet on file is for RATIONAL part 60.70.464, which is not this connection kit. Needs the datasheet for the part we stock. |
| `IMG/HYS/00207` | Rational Cleaner Tablets 56.00.22 | Data on file, not yet listed | The RATIONAL safety data sheet is on file; the listing text has not been written from it yet. |

### REFRIGERATION

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/DIS/00069` | Refrigerated Pizza Display Vrx1500/380 Fg | Sources disagree | model number: workbook VRX1500/80 vs record VRX1500/380 |
| `IMG/DIS/00137` | Refrigerated Pizza Display Vrx1800/380 Fg | Sources disagree | height 440 vs 455 vs 230/435 across three sources |
| `IMG/REF/00103` | Counter Freezer 1207 Blueline Gn2100Bt-1200 | Sources disagree | supplier sheet prints 860, we and SAP hold 1085 |
| `IMG/REF/00144` | Barline Chiller 1207 Blueline | Sources disagree | our record is 1360 wide, SAP says 1200 |
| `IMG/REF/00159` | Upright Solid 1 Door Freezer 600 Sries Df400 | Sources disagree | 1800 (ours) vs 1870 (web) vs 1850 (catalogue) |
| `IMG/REF/00198` | Arched Glass Door Freezer Sd/Sc-158Y | Sources disagree | SAP height 800 is internal, the external figure is 850 |
| `IMG/REF/00219` | Counter Freezer 9006 Snack1100Bt | Sources disagree | 900 is a transcription error for 925 |

### STORAGE & FOOD TRANSPORT

| Item no. | Name | Status | Finding |
|---|---|---|---|
| `IMG/BUF/00150` | Sdx Thermobox K120Rd/F120Rd | No supplier data | no source located - no description and no specification table |

## 60 items counted as Complete with a thin-listing caveat

The source is confirmed but the listing is thinner than it should be. They stay Resolved
because the data was found; flag any you would rather see moved.

| Item no. | Name | Facts | Sheet |
|---|---|---:|---|
| `IMG/FPR/00132` | Vegetable Chopper And Dicer Systematic Jsec- | 0 | FOOD PREPARATION |
| `IMG/FPR/00131` | Cheese Cuber Systematic Jscc-9 | 0 | FOOD PREPARATION |
| `IMG/FPR/00130` | Manual Vegetable Slicer Systematic Jscv-2200 | 0 | FOOD PREPARATION |
| `IMG/FPR/00133` | Lettuce Cutter Systematic Jsvc2100 | 0 | FOOD PREPARATION |
| `IMG/HOT/00168` | Pressure Cooker 25 Litres H Kitchen Sspc-25 | 0 | KITCHEN SMALLS |
| `IMG/HOT/00276` | Bain Marie H-Kitchen Kg-165 | 1 | BUFFET & SERVERY |
| `IMG/BUF/00060` | Chafing Dish Insert Round Porcelain Pan/Inse | 1 | BUFFET & SERVERY |
| `IMG/HOT/00222` | Food Warmer Electric Redline Cs-310 | 1 | BUFFET & SERVERY |
| `IMG/FPR/00277` | Chopping Block 600X600X100 | 1 | FOOD PREPARATION |
| `IMG/TCW/00354` | High Sauce Pan 10 Litres E22816 | 1 | KITCHEN SMALLS |
| `IMG/TCW/00520` | High Sauce Pan 18 Litres Ss 32X22 | 1 | KITCHEN SMALLS |
| `IMG/TCW/00357` | High Sauce Pan 6.5 Litres E22414 | 1 | KITCHEN SMALLS |
| `IMG/TCW/00519` | High Sauce Pan 8.5 Litres Ss 25X18 | 1 | KITCHEN SMALLS |
| `IMG/TCW/00386` | Stock Pot 12 Litres Csp 2525 | 1 | KITCHEN SMALLS |
| `IMG/TCW/00355` | Stock Pot 17 Litres Ei2828 | 1 | KITCHEN SMALLS |
| `IMG/TCW/00368` | Stock Pot 36 Litres Ei3636 | 1 | KITCHEN SMALLS |
| `IMG/TCW/00389` | Stock Pot 50 Litres Csp 4040 | 1 | KITCHEN SMALLS |
| `IMG/TCW/00388` | Stock Pot 71 Litres Csp 4545 | 1 | KITCHEN SMALLS |
| `IMG/BUF/00183` | Thermo Box 3 Gn H-Kitchen | 1 | STORAGE & FOOD TRANSPORT |
| `IMG/BUF/00179` | Chafing Dish Roll Top Electric Ecd09C | 2 | BUFFET & SERVERY |
| `IMG/HOT/00195` | Electric Food Warmer Cart Ot-10B-21 Redline | 2 | BUFFET & SERVERY |
| `IMG/DIS/00045` | Food Display Warmer H Kitchen Ot-01P | 2 | BUFFET & SERVERY |
| `IMG/HYS/00240` | Set Of Dry Vacuums Taski Vacumat 12 | 2 | FLOOR CARE & CLEANING |
| `IMG/OVE/00235` | 4" Non-Stick Hamburger Pan-15 | 2 | OVENS |
| `IMG/STO/00011` | Dining Carts Ss 2 Tier | 2 | STORAGE & FOOD TRANSPORT |
| `IMG/STO/00012` | Dining Carts Ss 3 Tier | 2 | STORAGE & FOOD TRANSPORT |
| `IMG/STO/00013` | Trolley For Dish Washer Rack H Kitchen | 2 | STORAGE & FOOD TRANSPORT |
| `IMG/HOT/00427` | Hef-904 Fryer Basket | 3 | COOKING EQUIPMENT |
| `IMG/HOT/00069` | Hot Dog Roller Electric | 3 | COOKING EQUIPMENT |
| `IMG/REF/00204` | Order Dish Multifunctional Cabinet (Lmd-1894 | 3 | DISPLAYS |
| `IMG/FPR/00012` | Chopping Board Blue | 3 | FOOD PREPARATION |
| `IMG/FPR/00081` | Chopping Board Red | 3 | FOOD PREPARATION |
| `IMG/FPR/00014` | Chopping Board White | 3 | FOOD PREPARATION |
| `IMG/FPR/00015` | Chopping Board Yellow | 3 | FOOD PREPARATION |
| `IMG/FPR/00217` | Hand Immersion Blender 350W H-Kitchen | 3 | JUICE PROCESSORS |
| `IMG/FPR/00274` | Kitchen Blender With Soundproof Cover | 3 | JUICE PROCESSORS |
| `IMG/TCW/00125` | Gn Lids Bilge | 3 | KITCHEN SMALLS |
| `IMG/TCW/00126` | Gn Lids Bilge | 3 | KITCHEN SMALLS |
| `IMG/TCW/00127` | Gn Lids Bilge | 3 | KITCHEN SMALLS |
| `IMG/TCW/00128` | Gn Lids Bilge | 3 | KITCHEN SMALLS |
| `IMG/TCW/00129` | Gn Lids Bilge | 3 | KITCHEN SMALLS |
| `IMG/TCW/00130` | Gn Lids Bilge | 3 | KITCHEN SMALLS |
| `IMG/REF/00201` | Counter Freezer (Air Cooled Freezing) Pld-15 | 3 | REFRIGERATION |
| `IMG/REF/00202` | Upright Triple Solid Door Freezer (Cfd-60D3F | 3 | REFRIGERATION |
| `IMG/BUF/00259` | Warmer Lamp D7016T | 4 | BUFFET & SERVERY |
| `IMG/OVE/00217` | Conveyor Pizza Oven-Digital | 4 | OVENS |
| `IMG/REF/00177` | Counter Chiller (Engineering Version) 1200*7 | 5 | REFRIGERATION |
| `IMG/REF/00178` | Counter Chiller (Engineering Version) 1500*7 | 5 | REFRIGERATION |
| `IMG/REF/00179` | Counter Chiller (Engineering Version) 1800*6 | 5 | REFRIGERATION |
| `IMG/REF/00231` | Counter Chiller (Engineering Version) 1800*7 | 5 | REFRIGERATION |
| `IMG/REF/00232` | Counter Freezer (Air Cooled Freezing) 1500*7 | 5 | REFRIGERATION |
| `IMG/HOT/00382` | Charcoal Grill Automatic 1750Mm 60 Skewers T | 6 | COOKING EQUIPMENT |
| `IMG/FPR/00127` | Potato Chipper On Stand Systematic Jspcc-08 | 6 | FOOD PREPARATION |
| `IMG/FPR/00140` | Automatic Orange Juicer Systematic Jsjc-12 | 6 | JUICE PROCESSORS |
| `IMG/FPR/00139` | Sugarcane Juicing Machine Systematic | 6 | JUICE PROCESSORS |
| `IMG/REF/00186` | Upright Double Solid Door Chiller Cfr-40N2F( | 6 | REFRIGERATION |
| `IMG/REF/00184` | Upright Single Solid Door Chiller Cfr-20N1F( | 6 | REFRIGERATION |
| `IMG/STO/00001` | Pvc Shelves 910 Cambro | 9 | STORAGE & FOOD TRANSPORT |
| `IMG/OVE/00213` | Gas Convection Oven Ftg 480 | 10 | OVENS |
| `IMG/FPR/00079` | Orange Juicer Z06A-N | 11 | JUICE PROCESSORS |

