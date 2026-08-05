# Tecnodom Product Research

Research notes behind the Tecnodom enrichment pass on `products.json` (July 2026). Data was
sourced from Tecnodom's official site and cross-checked against European distributors.

Covers all 20 Tecnodom SKUs: 9 refrigeration, 5 cold displays, 1 pastry display, 5 ovens.

**The official site is `tecnodomspa.com`** - not tecnodom.it. Manufacturer is Tecnodom S.p.A.,
Italy. Unlike Skymsen, the site was stable throughout research: no 404s or hangs.

---

## 1. Model-code decoding

This took real work to establish and is not obvious from the catalogue. Getting it right is
what determines whether a spec is correct.

### Upright cabinets

| Token | Meaning |
|---|---|
| `AF` | *armadio frigorifero* - refrigerated cabinet |
| `07` / `14` | 700 L single-door class / 1400 L two-door class |
| `TN` | *temperatura normale* - chiller, 0/+10 °C |
| `BT` | *bassa temperatura* - freezer, −18/−22 °C |
| `M` | *monoblocco* - integrated monobloc unit, ventilated cooling |
| `PK` | **Perfekt** line |
| `EKO` | **Eko** economy line |
| `PV` | *porta vetro* - glass door |

### Blast chillers

| Token | Meaning |
|---|---|
| `ATT` | Blast chiller (*abbattitore*) |
| `EA` | **ALADINO** line digital controller |
| `TH` | **ATTILA Touch** line - a *higher* tier than ALADINO |
| `P-` | **R290 (propane) refrigerant variant** - not "plus" or "professional" |

### Refrigerated counters

| Token | Meaning |
|---|---|
| `TF` | *tavolo frigorifero* - refrigerated counter. **Not freezer-specific** |
| `02` / `03` / `04` | Door count → 1420 / 1870 / 2320 mm |
| `MID` | MID Line range |
| `BT` | Freezer, −18/−22 °C |
| `GN` | **The chiller sibling.** `TF02MIDGN` is the +2/+8 °C version |
| `AL` / `SK` | Splashback variant / raised snack countertop variant |
| `SG` | Remote condensing unit - **different lengths** (TF02 = 1200, TF03 = 1650 mm) |

There is **no `TF02MIDTN`**. The suffix opposition is GN vs BT, not TN vs BT.

### Display cabinets

| Token | Meaning |
|---|---|
| `V` | **VULCANO** open-front multideck (no doors) |
| `VB` | *porte a battente* - **hinged glass doors** |
| `VS` | *porte scorrevoli* - **sliding glass doors** |
| `60` / `80` | Depth class → 600 mm (open front), 650 mm (VS), 765 mm (80-class) |
| `SL` | **NOT self-service.** *Salumi e Latticini* - **cold cuts & dairy** config, +3/+5 °C |
| `FV` | *Frutta e Verdura* - fruit & veg, +6/+8 °C, inclined shelves |
| `C` / `CA` | *Carne preconfezionata* - pre-packed meat, 0/+2 °C, pink LED |
| `INOX` | Stainless steel version |
| `CG` / `SG` | Built-in condensing unit / pre-arranged for remote unit |

**Length codes → actual external length:**

| Code | 60 | 80 | 100 | 125 | 140 | 150 | 187 | 250 |
|---|---|---|---|---|---|---|---|---|
| mm | 680 | 880 | 1080 | 1330 | 1480 | 1580 | 1955 | 2580 |

Note the VS line is the exception: at length code 150 it is **1600 mm**, not 1580 mm, because
of its 50 mm blind side walls and door tracks.

### Pastry displays

| Token | Meaning |
|---|---|
| `EVOK` | Semimural showcase, **straight** tempered glass |
| `EVO` | Same cabinet with **curved** glass |
| `V` (suffix) | *Ventilata* - ventilated refrigeration |
| `N` | Neutral / unrefrigerated |
| `HOT` | Heated version |

The `V` here is a refrigeration-type **suffix**, unrelated to the `V` that opens VULCANO codes.

### Ovens

Structure: `FE` + `[D|M]` + `[G]` + `NN` + `NE` + *chassis* + `V` + `[H2O]`

| Token | Meaning |
|---|---|
| `FE` | *Forno elettrico* - electric oven |
| `D` / `M` | **D**igitale / **M**eccanico - control type, **not** a size code |
| `G` | **G**rill function (extra top element) |
| `DL` | Prefix used exclusively on **NERONE MID digital** SKUs |
| `NN` | Tray count |
| `NE` | NERONE / NERINO oven family |
| `02` | **Nerino** ultra-compact chassis - GN 2/3 trays (354 × 325 mm) |
| `595` | NERONE EKO 595 chassis - 435 × 350 mm trays |
| `PS` | *Pasticceria* - 600 × 400 mm pastry trays |
| `GN` | Same chassis, GN 1/1 trays |
| `MID` | NERONE MID line (840 mm wide) |
| `V` | *Ventilato* - convection. **Not** *vapore* |
| `H2O` | Direct steam/water injection + chamber drain |

---

## 2. Cross-cutting rules

### Dimension ordering - the biggest single error source

The catalogue stored dimensions inconsistently and **almost every record was wrong**:

- **Ovens** stored the height value in the `width` field (order was W × H × D)
- **Upright cabinets** stored depth in `length`, height in `width`, width in `height`

All 20 SKUs have been normalised to **width × depth × height** in the
`length` / `width` / `height` fields.

Also note cabinet heights are quoted **feet-retracted**; adjustable feet add 70–100 mm.
2030 mm becomes 2100–2105 mm fully extended. Publish the low figure, footnote the range.

### Temperature boilerplate

`+2 ~ +8 °C` appeared on three display coolers. This is **catalogue boilerplate, not
Tecnodom data** - the VULCANO SL configuration runs **+3/+5 °C**.

Telling detail: the two records that had genuine data (`VS60150SLINOX` at +3/+5 and
`EVOK150V` at +2/+4) were already correct. So +2/+8 was auto-filled wherever real data
was missing. Worth checking for the same pattern on other brands.

### Litres vs display surface

Every litre figure on the display coolers (300 / 1000 / 800 / 400 L) was **third-party
estimate, not Tecnodom**. Tecnodom specs open and glass-door multidecks by **display
surface in m²**, because they are open-front:

| Model | Display surface |
|---|---|
| V6060SL | 0.85 m² |
| V6080SLINOX | 1.14 m² |
| VS60150SLINOX | 2.16 m² |
| EVOK150V | 2.34 m² |
| V60187SL | 2.66 m² |
| VB80250SL | 5.06 m² |

### Not published - do not invent

- **Net weight for all five VULCANO models.** Tecnodom's datasheet omits weight entirely.
- **Climate class for EVOK150V.**
- **Standard refrigerant gas for EVOK** - only "R290 on request" is stated.
- Temperature ranges for FEM03NE02V, FEMG04NE595V, FEM04NEPSV and FEM06NEMIDVH2O are
  dealer-sourced only; one dealer self-flags its figure as inferred.

---

## 3. Corrections applied

| SKU | Product | Was | Now |
|---|---|---|---|
| All 20 | - | dimensions in wrong axes | normalised to W × D × H |
| IMG/DIS/00093 | V6060SL | **named "Vegetable Processor PA7"** | Multi Deck Display Cooler V6060SL DGD |
| IMG/DIS/00106 | V6080SLINOX | 740 mm deep × 1300 mm tall - impossible | 600 × 1984 mm. The old figures were the **EVOK record's depth and height copied across** |
| IMG/OVE/00076 | 3-tray oven | model `FED03NE02V` | `FEM03NE02V` - **no digital Nerino exists**, mechanical only |
| IMG/OVE/00078 | 4-tray oven | name said `FEDG04NE595V` | `FEMG04NE595V` - the model field was right, the name wrong |
| IMG/REF/00049 | Glass door chiller | `AFO7EKOMTNPV` | `AF07EKOMTNPV` - letter O where a zero belongs |
| IMG/DIS/00093, 00096, 00106 | Display coolers | +2/+8 °C | **+3/+5 °C** |
| IMG/REF/00057, 00193 | Blast chillers | chill setpoint +2 °C | **+3 °C**; added kg capacity, which was missing entirely |
| IMG/OVE/00079 | 6-tray oven | claimed 9 programmes + core probe | Removed - those belong to the **digital** `FEDL06` sibling. `FEM` is mechanical |
| IMG/DIS/00100 | VS60150SLINOX | 1580 × 1958 mm | 1600 × 1980 mm |
| IMG/REF/00193 | P-ATT10EA | 1260 mm tall | **1312 mm** - 1260 is body height, 1312 includes feet. A 52 mm error matters under a hood |

### Four SKUs had no data at all and are now fully populated

`AF07PKMBT` · `TF02MIDBT` · `TF03MIDBT` · `VB80250SL`

---

## 4. Open questions for the supplier

Deliberately **not** changed in `products.json` - these need confirmation.

### 4.1 The 5-tray blast chiller's model code is ambiguous

Catalogue says `ATT-05`. Tecnodom sells two builds:

- **`ATT05EA`** - R455A refrigerant
- **`P-ATT05EA`** - R290 propane

Since the sibling SKU is `P-ATT10EA`, yours is probably the R290 line - but **R290 is
flammable and carries charge-size and siting rules** that matter for a Kenyan install. Model
code left unchanged; refrigerant and wattage omitted from the spec table pending confirmation.

### 4.2 Refrigerant is unresolved across the range

Three gases circulate for the same model codes depending on production year:

- **R404A / R507** - legacy stock (GWP 3922, under aggressive phase-down)
- **R452A** - transitional, dominant in current distributor datasheets
- **R290** - what Tecnodom's official site states today, with R455A on request

Refrigerant is omitted from the upright cabinets and both freezer counters. Confirm build
year before publishing any gas.

### 4.3 Power draw is genuinely contested

| Model | Figures found | Better-sourced |
|---|---|---|
| AF07PKMTN | 385 W vs 650 W | 385 W (matches R404A-era build and the EKO sibling) |
| AF07PKMBT | 690 W vs 420 W | 690 W (Italian source; matches a BT cabinet with door heater) |
| AF14PKMBT | 760 W vs 885 W | 760 W (tied to a specific EU datasheet) |

Voltage published, wattage omitted on these three.

### 4.4 Other unconfirmed points

- **FEM04NEPSV door type** - dealers disagree between *porta a bandiera* (side-hinged) and
  *porta a ribalta* (drop-down flap). A `-PLUS` variant is separately listed as drop-down.
- **Shelf counts** differ between Italian and Gulf listings on the upright cabinets
  (3 GN 2/1 vs 4 wire shelves) - likely a regional kit difference.
- **Castors and door locks**: all sources show adjustable feet, not castors, and no source
  mentions a door lock. Do not claim either.
- **MAXICONV/Discovery-style "up to 300 °C" claims** do not apply - the EKO 595 chassis is
  documented at 280 °C max.

---

## 5. Product reference

### Refrigeration - upright cabinets

| SKU | Catalogue name | Model | Official line page | Best image source |
|---|---|---|---|---|
| IMG/REF/00049 | Upright Glass Door Chiller Single 8007 | AF07EKOMTNPV | [ARMADIO 700](https://www.tecnodomspa.com/it/verticale/armadi-refrigerati/700.html) | [soazimaq.pt](https://soazimaq.pt/en/products/armario-refrigerado-tecnodom-eko-700-gn-2-1-conservacao-e-porta-de-vidro-af07ekomtnpv) |
| IMG/REF/00062 | Upright Solid Door Chiller 1 Door | AF07PKMTN | [ARMADIO 700](https://www.tecnodomspa.com/it/verticale/armadi-refrigerati/700.html) | [gastrocentrale.it](https://www.gastrocentrale.it/armadio-frigo-professionale-positivo-tecnodom-perfekt-700.html) |
| IMG/REF/00060 | Upright Solid Door Chiller 2 Door | AF14PKMTN | [ARMADIO 1400](https://www.tecnodomspa.com/it/verticale/armadi-refrigerati/1400.html) | [ristorazione-refrigerazione.it](https://www.ristorazione-refrigerazione.it/it/armadi-frigo-temperatura-positiva/53568-armadio-frigorifero-acciaio-inox-aisi-304-modaf14pkmtn-n-2-porte-temperatura-010c-ventilato-capacita-lt-1400-.html) |
| IMG/REF/00061 | Upright Solid Door Freezer 1 Door | AF07PKMBT | [ARMADIO 700](https://www.tecnodomspa.com/it/verticale/armadi-refrigerati/700.html) | [zanonicookingcenter.com](https://www.zanonicookingcenter.com/catalogo/Armadio-congelatore-Tecnodom-Perfekt-AF07PKMBT) |
| IMG/REF/00063 | Upright Solid Door Freezer 2 Door | AF14PKMBT | [ARMADIO 1400](https://www.tecnodomspa.com/it/verticale/armadi-refrigerati/1400.html) | **[allforfood.com](https://www.allforfood.com/armadio-frigo-congelatore-in-acciaio-inox-gastronorm-allforfood-af14pkmbt-stc-af14pkmbt.html)** - verified white bg |

**No public per-model PDF exists for the upright cabinets** - they sit behind the customer
login at <https://www.tecnodomspa.com/en/authentication/>. The one exception:
[AF14PKMBT EU energy datasheet](https://pim.allforfood.com/documenti/000_000_1461_SCHEDA_UE_AF14PKMBT_IT.pdf).

Recommend requesting the Perfekt and Eko line catalogues directly from Tecnodom.

### Refrigeration - blast chillers and counters

| SKU | Catalogue name | Model | Official page | Spec sheet PDF |
|---|---|---|---|---|
| IMG/REF/00057 | Blast Chiller 5 Trays | ATT-05 → P-ATT05EA | [ALADINO](https://www.tecnodomspa.com/en/verticale/abbattitori-di-temperatura/aladino.html) | **[P-ATT05EA EN](https://www.tecnodomspa.com/files/238/Aladino/363/ALADINOP-ATT05EAR290EN)** |
| IMG/REF/00193 | Blast Chiller 10 Trays | P-ATT10EA | [ALADINO](https://www.tecnodomspa.com/en/verticale/abbattitori-di-temperatura/aladino.html) | **[P-ATT10EA EN](https://www.tecnodomspa.com/files/238/Aladino/365/ALADINOP-ATT10EAR290EN)** |
| IMG/REF/00211 | Freezer Counter 2 Doors | TF02MIDBT | [Tavolo MID TN/BT](https://www.tecnodomspa.com/en/orizzontale/tavoli-refrigerati/tavolo-mid-gastronomia-tn-bt.html) | [SchedetavoloGN](https://www.tecnodomspa.com/files/34/schede-pdf/26/SchedetavoloGN) (21.7 MB) |
| IMG/REF/00212 | Freezer Counter 3 Doors | TF03MIDBT | [Tavolo MID TN/BT](https://www.tecnodomspa.com/en/orizzontale/tavoli-refrigerati/tavolo-mid-gastronomia-tn-bt.html) | [SchedetavoloGN](https://www.tecnodomspa.com/files/34/schede-pdf/26/SchedetavoloGN) (21.7 MB) |

Also: [combined ATTILA/ALADINO R290 catalogue](https://www.tecnodomspa.com/files/238/Aladino/373/AbbattitoreATTILAdigitale-touch-aladinoR29001CEPT).

ALADINO gallery images follow a predictable path -
`tecnodomspa.com/images/gallery/214/large/aladino-01.jpg` through `-03.jpg`, plus
`aladino-1001.jpg` to `-1006.jpg`. **Eyeball before use**: some Tecnodom gallery assets are
deliberately black-background (filenames ending `fondonero`).

Fullest counter specs: [tcbohemia.com TF02MIDBT](https://tcbohemia.com/en/cooling-technology/cooled-inox-worktables/freezer-worktables/tf02midbt-deep-freezer-worktable-gn-1-1/)
and [TF03MIDBT](https://tcbohemia.com/en/cooling-technology/cooled-inox-worktables/freezer-worktables/tf03midbt-deep-freezer-worktable-gn-1-1/).
The 21.7 MB PDF exceeded the fetch limit but is the only authoritative per-model datasheet -
download it manually.

**Dead links, do not use:** `tecnodomspa.com/wp-content/uploads/2019/05/TF02MIDBT.pdf` and
the TF03 equivalent both 404. The site has migrated off that path.

### Cold displays and pastry

| SKU | Catalogue name | Model | Official page | Spec sheet PDF |
|---|---|---|---|---|
| IMG/DIS/00093 | Multi Deck Display Cooler V6060SL | V6060SL | [VULCANO](https://www.tecnodomspa.com/en/verticale/murali-refrigerati/vulcano.html) | **[Schedevulcano](https://www.tecnodomspa.com/files/34/schede-pdf/21/Schedevulcano)** |
| IMG/DIS/00096 | Multi Deck Display Cooler V60187SL | V60187SL | [VULCANO](https://www.tecnodomspa.com/en/verticale/murali-refrigerati/vulcano.html) | **[Schedevulcano](https://www.tecnodomspa.com/files/34/schede-pdf/21/Schedevulcano)** |
| IMG/DIS/00106 | Multi Deck Display Cooler V6080SLINOX | V6080SLINOX | [VULCANO](https://www.tecnodomspa.com/en/verticale/murali-refrigerati/vulcano.html) | **[Schedevulcano](https://www.tecnodomspa.com/files/34/schede-pdf/21/Schedevulcano)** |
| IMG/DIS/00095 | Multi Deck Display Cooler VB80250SL | VB80250SL | [VULCANO VB](https://www.tecnodomspa.com/en/verticale/murali-refrigerati/vulcano-vb.html) | **[Schedevulcano](https://www.tecnodomspa.com/files/34/schede-pdf/21/Schedevulcano)** |
| IMG/DIS/00100 | Multi Deck Display Cooler VS60150SLINOX | VS60150SLINOX | [VULCANO VS](https://www.tecnodomspa.com/en/verticale/murali-refrigerati/vulcano-vs.html) | **[Schedevulcano](https://www.tecnodomspa.com/files/34/schede-pdf/21/Schedevulcano)** |
| IMG/DIS/00037 | Pastry Display Square 1500 Evok | EVOK150V | [EVOK](https://www.tecnodomspa.com/en/verticale/semimurali-refrigerati/evok.html) | none published |

**`Schedevulcano` (9.7 MB) is the single best asset in the whole Tecnodom set** - one PDF
covering five of these six models with white-background renders, dimensioned line drawings and
full code indexes for the painted, INOX and remote-condenser variants.

EVOK has no public PDF; datasheets sit behind the customer login. Best EVOK images:
[ahlia.store](https://ahlia.store/products/dom-evok150v-stright-glass-ventilated-display-case-150-cm)
- confirmed clean white background, **but ignore its spec table** (wrong height, implausible
134 W). Also [attrezzatureprofessionali.com](https://www.attrezzatureprofessionali.com/en/evok150-display-case.html)
for shelf depths and accessory lists.

Also useful: [Aureli V6060SL](https://aurelifoodequipment.com/en/frigoriferi-murali/1698-vertical-multi-deck-display-dairy-products-dim-680wx600dx1984h-mm-temp-35c.html)
- white-background photos plus RAL colour swatches.

**Caution:** Aureli also lists a `V80187SL` - that is the **765 mm-deep** sibling, not the
V60187SL. Do not reuse its photos without checking depth.

### Ovens

| SKU | Catalogue name | Model | Official page |
|---|---|---|---|
| IMG/OVE/00076 | Oven Convection 3 Trays | FEM03NE02V | [Nerino](https://www.tecnodomspa.com/en/prodotto/cooking-systems/nerino/) |
| IMG/OVE/00078 | Oven Convection 4 Trays 435×350 | FEMG04NE595V | [Nerone meccanico](https://www.tecnodomspa.com/en/cottura/nerone/nerone-meccanico.html) |
| IMG/OVE/00128 | Oven Convection 4 Trays 600×400 | FEM04NEPSV | [Nerone meccanico](https://www.tecnodomspa.com/en/cottura/nerone/nerone-meccanico.html) |
| IMG/OVE/00079 | Oven Convection 6 Trays | FEM06NEMIDVH2O | [Nerone MID meccanico](https://www.tecnodomspa.com/en/cottura/nerone-mid/nerone-mid-meccanico.html) |
| IMG/OVE/00089 | Oven Convection 10 Trays | FEDL10NEMIDVH2O | [Nerone MID digital](https://www.tecnodomspa.com/en/prodotto/cooking-systems/nerone-en/nerone-mid-digital/) |

Per-model oven PDFs have CMS-mangled filenames that are impractical to reproduce by hand -
open the line page and click through to the datasheet. Combined bundle:
[Schedeforni.pdf](https://www.tecnodomspa.com/files/34/schede-pdf/128/Schedeforni.pdf)
(exceeded the fetch limit; likely the most useful single download).

Full [MID user manual](https://cdn.abicart.com/shop/ws35/42135/art61/182143661-e19550-2018-03-16_MANUALE_TECNODOM_NERONE_MID_MECCANICI-DIGITALI_IT-EN-FR-DE-AR_LINERMIDT_REV.01-2018.pdf)
covers mechanical and digital in IT/EN/FR/DE/AR.

Dealer sources with good photos: [gastrocentrale.it](https://www.gastrocentrale.it/forno-a-convezione-tecnodom-nerino-fem03ne02v.html)
(Nerino, FEM04NEPSV), [ahlia.store](https://ahlia.store/products/tecnodom-fem06nemidvh2o) (MID models).

### Oven line summary - useful for merchandising

| Model | Line | Trays | Tray size | Phase | Steam | Plumbing |
|---|---|---|---|---|---|---|
| FEM03NE02V | Nerino | 3 | GN 2/3 354×325 | 1Ph 230V | No | No |
| FEMG04NE595V | Nerone EKO 595 Grill | 4 | 435×350 | 1Ph 230V | No | No |
| FEM04NEPSV | Nerone EKO 600 | 4 | 600×400 | 1Ph 230V | No | No |
| FEM06NEMIDVH2O | Nerone MID mech. | 6 | 600×400 / GN 1/1 | **3Ph 400V** | Yes | **Yes** |
| FEDL10NEMIDVH2O | Nerone MID digital | 10 | 600×400 / GN 1/1 | **3Ph 400V** | Yes | **Yes** |

The three-phase-plus-plumbing requirement on the two MID ovens is a significant purchase and
installation constraint - it is stated prominently in both product descriptions.

---

## 6. Image sourcing

**Tecnodom's own line pages carry clean white-background studio renders throughout** - better
than most resellers. Start there rather than with distributors.

Ranked:

1. **`Schedevulcano` PDF** - five display models, renders plus dimensioned drawings
2. **ALADINO per-model datasheet PDFs** - the only true per-model PDFs on the public site
3. **Official line pages** - Nerino, Nerone meccanico, Nerone MID, VULCANO, EVOK
4. **allforfood.com** (AF14PKMBT) - verified white background
5. Distributor pages listed per-SKU above

### Known blocks

403 to automated fetching but browser-accessible: `ekuep.com`, `technochef.eu` (also 301
loops; the `.it` mirror has an **expired TLS certificate** - use `.eu`), `metro.it`,
`restaurantsupply.com`, `magazineluiza.com.br`.

Connection refused: `karelsrl.com`.

---

## 7. Related models not in the catalogue

Surfaced during research, if the range is worth filling:

- **DB-06 equivalents** - smaller upright cabinets below the 700 class
- **TF02MIDGN / TF03MIDGN** - the chiller versions of the freezer counters (+2/+8 °C)
- **TF02MIDGNAL / SK** - splashback and raised snack-countertop variants
- **TF04MID** - 4-door counter, 2320 mm
- **LAR-06MB equivalents** - VULCANO 60 at lengths 100, 125, 140 (1080–1480 mm)
- **V80187SL** - the 765 mm-deep sibling of the V60187SL
- **FEM04NE595V** - non-grill version of the 595 chassis, cheaper alternative
- **FED04NEPSV** - digital version of the 4-tray 600×400
- **FEM04NEPSV-PLUS** - accepts both 600×400 and GN 1/1
- **FEDL04/05/06/07NEMIDVH2O** - digital MID at 4, 5, 6 and 7 trays
- **EVOK at 905 / 1205 / 1805 / 2405 mm**, plus EVOKHOT (heated) and EVOK…N (neutral)
- **EVO series** - the curved-glass equivalent of EVOK

---

## 8. Outstanding cosmetic issue

`IMG/DIS/00093`'s image files are still named after the wrong product on disk:

```
products/vegetable-processor-pa7-imgdis00093.jpg
products/gallery/vegetable-processor-pa7-imgdis00093-1.jpg  (…through -5.jpg)
```

The `products.json` references match the filenames so nothing breaks, but the names carry the
Skymsen PA-7 product name. Renaming requires moving the files and updating the paths together.

---

## Image sourcing — applied to the project, 29 July 2026

19 SKUs wired: cover from the first file, remaining files as gallery. **No `model_number` and no
`name` was touched**, by instruction — several of these photographs are of a neighbouring model
and the codes were left exactly as they stand.

Three records had **no image at all** before this: `IMG/REF/00061`, `IMG/REF/00211`,
`IMG/REF/00212`. Of the rest, most covers were badly undersized — `IMG/REF/00062` was 270 px,
`IMG/REF/00193` 300 px, `IMG/DIS/00100` 324 px, `IMG/DIS/00096` 385 px.

Galleries added on `DIS/00037` (3 files), `REF/00057` (3), `DIS/00095`, `OVE/00128`,
`REF/00060`, `REF/00193`.

Photographs that are **not** the exact catalogued unit, carried anyway as the best available:

| SKU | Record | What the photo shows |
|---|---|---|
| DIS/00093 | `V6060SL` (680 mm) | `TDVC60-CA-100` — **1080 mm**, explicitly not 680 |
| DIS/00095, 00096, 00100, 00106 | VULCANO variants | `CA`-config / reseller shots of neighbouring line members |
| DIS/00037 | Evok pastry display | EVOK straight-glass **line** photo, not the 1500 |
| REF/00049 | `8007` glass-door | `AF07MIDMTNPV` mid-line sibling — **NOT EKO** |
| REF/00211, 00212 | MID-line counters | official **line** photos, not the specific door/drawer build |
| REF/00193 (gallery) | 10-tray blast chiller | generic blue-panel reseller unit |

Two cover choices worth recording, since filename order alone would have picked differently:

- `REF/00060` — the 1512 px `.jpg` was preferred over the 1000 px background-removed `.png`,
  which went to gallery. Alphabetical order would have made the smaller file the cover.
- `REF/00057` — the reseller front-closed shot leads; the two `-TOOSMALL` specsheet extracts
  follow as gallery.

---

## Image sourcing (July 2026)

> **STATUS: COMPLETE.** A first image-sourcing agent was killed by a platform session limit
> mid-run on 2026-07-27 after staging 21 files but writing nothing up; this section is the
> reconstruction plus the finished pass. Anything unrecoverable is flagged explicitly as such
> rather than guessed at. No URL has been invented to fill a gap.

### Provenance and what was lost

Two agents worked this brand:

1. **Agent 1 (2026-07-27, ~23:15-00:08)** staged 21 files - 17 per-SKU assets plus 4 manufacturer
   catalogues in `_brand-reference/` - and was then killed by a platform session limit **before
   writing a single line of notes**. Its last recorded action was probing the manufacturer's
   gallery-ID scheme.
2. **Agent 2 (2026-07-28)** mined agent 1's transcript, recovered its sources and its working
   directory, finished the sourcing pass, and wrote this section.

**Recovered in full:** every source URL agent 1 fetched (426 distinct URLs in the transcript),
its complete download log with pixel dimensions, and - crucially - its scratch working directory,
which still held **51 downloaded images that had never been staged**. Most of the refrigeration
coverage below comes from that rescued directory.

**Lost and not recoverable:** agent 1's reasoning. Its thinking blocks are empty in the transcript
and it emitted only 8 short lines of prose across 222 assistant turns. So its *visual* judgements
survive only where it encoded them in a filename. Specifically:

- The judgement behind `IMG-OVE-00128__REF__NERONE-600-PLUS-3phase-sibling-not-FEM04NEPSV.png`
  is preserved only as that filename. The reasoning that identified it as the 3-phase PLUS
  sibling is gone. The filename is trusted here but has **not** been independently re-verified.
- Source URLs for the five official oven PNGs and the seven spec-sheet PDFs it staged are
  **not individually recoverable** - they were fetched inside a bulk PDF-image-extraction script
  whose per-file mapping was not echoed to stdout. They are attributed below to the catalogue
  or line page they demonstrably came from, and marked accordingly. **No URL has been invented.**

### The manufacturer gallery scheme (recovered - this was the key)

Agent 1's dying words were that it had found `tecnodomspa.com` gallery IDs serving 800x800
per-line photos. The scheme, fully reconstructed:

The site is Joomla running the **Droppics** gallery component. Each product-line page carries a
gallery whose ID is **not** the Joomla article ID and is not guessable - agent 1 burned two
120-second brute-force sweeps (4,277 and ~10,000 probes) and found exactly one hit that way.

The reliable route: the gallery ID leaks in an inline `<style>` block on the line page as
`#droppicsgalleryNN`, and **the full-size image markup is already in the served HTML** - no AJAX
call is needed. Agent 1's extraction regex was scoped to `images/prodotti/` and so missed it.

```
grep -o 'droppicsgallery[0-9]*'                      -> gallery id
grep -o 'images/gallery/[0-9]*/large/[^"]*\.jpg'     -> the actual 800x800 / 1000x1000 files
```

| Line page | Joomla article | Droppics gallery | Images |
|---|---|---|---|
| `armadi-refrigerati/700.html` | 38 | **none** | 0 |
| `armadi-refrigerati/1400.html` | 82 | **none** | 0 |
| `armadi-refrigerati/700-eko.html` | - | **none** | 0 (redirects to Perfekt 700 content) |
| `murali-refrigerati/vulcano.html` | 80 | 66 | 14 |
| `murali-refrigerati/vulcano-vb.html` | 91 | 67 | 3 |
| `murali-refrigerati/vulcano-vs.html` | 92 | 120 | 7 |
| `semimurali-refrigerati/evok.html` | 95 | 70 | 5 |
| `abbattitori-di-temperatura/aladino.html` | 235 | 214 | 9 |
| `tavoli-refrigerati/tavolo-mid-gastronomia-tn-bt.html` | 75 | 95 | 5 |

Filenames inside a gallery are opaque (`vulcanobig-5.jpg`, `vulcano0009tecnodom9092.jpg`,
`tavolo-gn0001Tecnodom1481fondonero.jpg`) - which is why guessing stems failed.

**The upright cabinets have no manufacturer gallery at all.** That is the single structural
reason nine refrigeration SKUs had nothing staged: there was nothing on tecnodomspa.com to take.
All upright-cabinet photography below is distributor-sourced.

### The three distributor routes that actually worked

Resellers out-performed the manufacturer on this brand, exactly as expected.

**1. gastrocentrale.it (Italy) - sitemap harvesting.** Its `sitemap.xml` is 8,304 URLs and
carries `<image:loc>` per product. Filtering for Tecnodom yields **300 product pages**, each
mapping a model to a Storeden gallery ID. The image then comes from a stable pattern:

`https://egress.storeden.net/jpg/{galleryId}/file.jpg` - serves **1000x1000** for cabinets,
800x800 for blast chillers and ovens.

This is the only source found for the four Perfekt upright cabinets, and it distinguishes
TN from BT properly (the BT listings carry a *"TEMPERATURA NEGATIVA"* overlay badge - a reseller
graphic, not part of the machine, but a reliable config marker).

`https://www.gastrocentrale.it/sitemap.xml`

**2. kitchenexpress.com.au and siblings - the Shopify `.json` endpoint.** Three Australian
dealers (`kitchenexpress.com.au`, `commercialkitchenappliances.com.au`,
`commercialfridgesonline.com.au`) resell Tecnodom under FED/"Tecnodom by FHE" branding. Appending
`.json` to any product URL returns image URLs with declared width/height - **1100x1100 fronts and
800x1200 detail shots**, far above the floor. `/collections/all/products.json?limit=250&page=N`
enumerates all 67 Tecnodom SKUs in one sweep.

Caveat carried into the filenames below: this catalogue uses **CA** (pre-packed meat) configs where
ours are **SL** (cold cuts / dairy). Same cabinet, different temperature band and shelf lighting -
the CA renders show the characteristic **pink LED** back panel. Every one is marked `REF__`.

**3. allforfood.co.uk - EU energy labels keyed by exact article number.** The single most valuable
find of this pass. Product photos there are indexed by prose, not model code, so searching
`V6060SL` returns nothing. But the energy-label assets *are* keyed by code:

`https://media.allforfood.co.uk/media/catalog/product/L/a/Label_{CODE}_1.jpg` - **900x1799**

These are official EU labels carrying **TECNODOM** and **the exact article number printed
in-frame**. That makes them the only assets in this pass that are self-proving at the article-number
level, and they turned up several contradictions with the stored records (section below). They are
documents, not photographs - they do not replace a product shot, but they anchor it.

Confirmed present for `V6060SL`, `V60187SL`, `VS60150SL`, `V6080SLINOX`, `VB80250SL`, `V80250SL`.
`VS60150SLINOX` returns the site's 262x262 placeholder - the label exists only under the
non-INOX code.

### Sources tried and rejected

| Source | Outcome |
|---|---|
| `soazimaq.pt` (Portugal) - the only exact `AF07EKOMTNPV` listing found anywhere | 6 photos, but master resolution is **600x574**. Below floor with no larger original. Rejected. |
| `media.allforfood.com` product photos | Almost all return a **262x262 placeholder**. `ARMADIO_PERFEKT_700.jpg` is a 502-byte stub. |
| `zanonicookingcenter.com` | 640x480 max. Below floor. |
| `ahlia.store` (EVOK150V listing) | The only product image is 1500x1500 but is a **Shopify CDN file from a different store's account** - not verifiable as EVOK150V. Downloaded, inspected, deleted as filler. |
| `topfrost.gr` | 403. |
| `horecagrup.md` | 404 (link came from a search result, page gone). |
| `hospitalityequipmentonline.com.au` | 500. |
| `frigotecnicasrl.com` | DNS failure. |
| `tecnodomspa.com` upright-cabinet pages | No gallery exists - see table above. |

The manufacturer site was otherwise **entirely stable across both agents: no 404s on any live
product page, no hangs, no rate limiting**. That reputation from the earlier research pass holds.

### Coverage - all 20 SKUs, stated exactly

**45 files** are now staged (21 before this pass, **28 added**, 4 of the 45 being brand-level
catalogues in `_brand-reference/`). File count is not coverage. The honest breakdown:

| Bucket | Count | SKUs |
|---|---|---|
| **A. Exact model, photographed** | **6** | IMG/OVE/00076, 00078, 00079, 00089, 00128; IMG/REF/00193 |
| **B. Exact model, document only** (energy label or spec sheet carrying the article number, no photo of that exact variant) | **4** | IMG/DIS/00093, 00095, 00096, 00106 |
| **C. Representative only** (`REF__` - correct family, *not* provably the right size/config/line) | **10** | IMG/REF/00049, 00057, 00060, 00061, 00062, 00063, 00211, 00212; IMG/DIS/00037, 00100 |
| **D. Nothing at all** | **0** | - |

Every SKU now has at least one asset. **Only 6 of 20 have a photograph of the exact article
number.** Nine more have the right cabinet in the frame but no proof of length or config.

Bucket-by-bucket detail:

**A - exact model, photographed (6).**
The five ovens carry official Tecnodom front-open PNGs at 1323-2326 px, plus a per-SKU spec sheet
each. `IMG/REF/00193` (P-ATT10EA) has the official front photo lifted from its own R290 spec sheet
at 702x930 - the article number is on the sheet the image came from, so the linkage is sound.

**B - exact model, document only (4).**
The four VULCANO display coolers with `900x1799` EU energy labels bearing their exact article
number. Their accompanying *photographs* are all `REF__`: the correct VULCANO variant in the
correct finish, but at a length or temperature config that is not ours.

**C - representative only (10), and precisely why each falls short:**

| SKU | Model | What is staged | Why it is not exact |
|---|---|---|---|
| IMG/REF/00049 | AF07EKOMTNPV | AF07**MID**MTNPV, 1000x1000 | **MID line, not EKO.** Same 700 L glass-door TN configuration; different build tier. No EKO 700 photo exists above 600 px anywhere found. |
| IMG/REF/00057 | ATT-05 | ATT05 reseller front 800x800; official P-ATT05EA sheet photos at 426x500 and 605x460 | The only *official* photos are below the floor and kept `-TOOSMALL`. The 800x800 reseller shot is the ATT05 family but the R290 vs R455A build is not distinguishable in frame. |
| IMG/REF/00060 | AF14PKMTN | Perfekt 1400 "TEMPERATURA POSITIVA" 1000x1000 | Correct line, door count and temperature class - but the code `AF14PKMTN` is nowhere in frame. |
| IMG/REF/00061 | AF07PKMBT | Perfekt 700 "TEMPERATURA NEGATIVA" 1000x1000 | As above. |
| IMG/REF/00062 | AF07PKMTN | Perfekt 700, no badge 1000x1000 | As above. Also the smallest file of the four (25 KB) - a lower-quality re-encode. |
| IMG/REF/00063 | AF14PKMBT | Perfekt 1400 "TEMPERATURA NEGATIVA" 1000x1000 | As above. |
| IMG/REF/00211 | TF02MIDBT | Official MID-line counter 1000x1000 - **4 doors** | Ours is **2 doors**. Correct line and finish, wrong door count. Its official technical drawing (1654x2339) *is* SKU-exact. |
| IMG/REF/00212 | TF03MIDBT | Official MID-line counter 1000x1000 - 3 doors **plus a 3-drawer bank and splashback** | Ours is 3 plain doors, no drawers, no splashback. Its technical drawing is SKU-exact. |
| IMG/DIS/00037 | EVOK150V | Three official EVOK line photos, 800x800 each | EVOK straight-glass with 3 glass shelves - correct family and glass type. The 1,505 mm length is not provable from any of them. |
| IMG/DIS/00100 | VS60150SLINOX | Stainless sliding-door VULCANO VS, 698x977, plus a `VS60150SL` energy label | The photo is above floor on its long edge only. The label is filed `REF__` because its stated display area is implausible - see contradictions. |

**A note on the two blast chillers.** `IMG/REF/00057` and `IMG/REF/00193` both have their
**official Tecnodom R290 spec sheet PDF** staged (2 pages each), which is stronger evidence than
any photograph. 00193 additionally gets an exact-model photo out of that sheet; 00057's equivalent
photo is only 426x500.

### Per-file record

All in `Desktop\ecommerce\products resource\tecnodom-images\`. Dimensions measured with PIL from
the bytes on disk, not read off filenames. MD5-hashed: **no two staged files are byte-identical**,
so the duplicate-render trap seen on other brands is not present here.

#### Ovens - staged by agent 1, source URLs not recoverable

| File | Px | Size | Source |
|---|---|---|---|
| `IMG-OVE-00076__FEM03NE02V-nerino-front-open-official.png` | 1549x1123 | 336 KB | Official Tecnodom render, extracted from the FORNI catalogue below. Per-image URL not recovered |
| `IMG-OVE-00076__spec-sheet.pdf` | 1 pp | 433 KB | Per-SKU sheet; exact URL not recovered |
| `IMG-OVE-00078__FEMG04NE595V-nerone-595-grill-front-open-official.png` | 1641x1261 | 1044 KB | as above |
| `IMG-OVE-00078__spec-sheet.pdf` | 1 pp | 846 KB | as above |
| `IMG-OVE-00079__FEM06NEMIDVH2O-nerone-mid-6-front-open-official.png` | 2326x1692 | 1452 KB | as above |
| `IMG-OVE-00079__spec-sheet.pdf` | 1 pp | 804 KB | as above |
| `IMG-OVE-00089__FEDL10NEMIDVH2O-nerone-mid-10-digital-front-open-official.png` | 1323x1142 | 671 KB | as above |
| `IMG-OVE-00089__spec-sheet.pdf` | 1 pp | 830 KB | as above |
| `IMG-OVE-00128__FEM04NEPSV-nerone-600-front-open-official.png` | 2091x1584 | 1628 KB | as above |
| `IMG-OVE-00128__REF__NERONE-600-PLUS-3phase-sibling-not-FEM04NEPSV.png` | 1961x1387 | 1393 KB | as above. Agent 1's wrong-model call, preserved but not re-verified |
| `IMG-OVE-00128__spec-sheet.pdf` | 1 pp | 1135 KB | as above |

The parent catalogue these came out of, which **is** recoverable:
`https://www.tecnodomspa.com/files/34/schede-pdf/128/Schedeforni.pdf`

#### Refrigeration

| File | Px | Size | Source URL |
|---|---|---|---|
| `IMG-REF-00049__REF__AF07MIDMTNPV-mid-line-700L-glass-door-sibling-NOT-EKO.jpg` | 1000x1000 | 84 KB | `https://egress.storeden.net/jpg/64e606c15fb8e01d3e8b4581/file.jpg` — listing `https://www.gastrocentrale.it/armadio-refrigerato-tecnodom-af07midmtnpv.html` |
| `IMG-REF-00057__ATT05-front-closed-reseller.jpg` | 800x800 | 79 KB | `https://egress.storeden.net/jpg/64e62eba5fb8e00e3a8b457d/file.jpg` — listing `https://www.gastrocentrale.it/abbattitore-di-temperatura-tecnodom-att05-acciaio-inox-.html` |
| `IMG-REF-00057__P-ATT05EA-official-front-from-specsheet-TOOSMALL.png` | 426x500 | 170 KB | Extracted from `IMG-REF-00057__spec-sheet-P-ATT05EA-R290-EN.pdf` |
| `IMG-REF-00057__P-ATT05EA-official-door-open-from-specsheet-TOOSMALL.png` | 605x460 | 341 KB | Extracted from the same sheet |
| `IMG-REF-00057__spec-sheet-P-ATT05EA-R290-EN.pdf` | 2 pp | 1015 KB | Official Tecnodom sheet, printed 20-05-2025. Exact URL not recovered |
| `IMG-REF-00060__AF14PKMTN-perfekt-1400-TN-two-door.jpg` | 1000x1000 | 87 KB | `https://egress.storeden.net/jpg/61673688be7ea0fb7d8b53b6/file.jpg` — listing `https://www.gastrocentrale.it/armadio-frigo-professionale-tecnodom-perfekt-1400-positivo.html` |
| `IMG-REF-00061__AF07PKMBT-perfekt-700-BT-single-door.jpg` | 1000x1000 | 91 KB | `https://egress.storeden.net/jpg/61675ea3be7ea0fb7d8b6ebb/file.jpg` — listing `https://www.gastrocentrale.it/armadio-frigo-professionale-tecnodom-negativo-perfekt-700-litri.html` |
| `IMG-REF-00062__AF07PKMTN-perfekt-700-TN-single-door.jpg` | 1000x1000 | 25 KB | `https://egress.storeden.net/jpg/67cae0adbe7ea033d93529e2/file.jpg` — listing `https://www.gastrocentrale.it/armadio-frigo-professionale-positivo-tecnodom-perfekt-700.html` |
| `IMG-REF-00063__AF14PKMBT-perfekt-1400-BT-two-door.jpg` | 1000x1000 | 94 KB | `https://egress.storeden.net/jpg/6167369b5fb8e00f598b6d6a/file.jpg` — listing `https://www.gastrocentrale.it/armadio-frigo-professionale-tecnodom-perfekt-negativo-1400-litri.html` |
| `IMG-REF-00193__P-ATT10EA-official-front-from-specsheet.png` | 702x930 | 659 KB | Extracted from `IMG-REF-00193__spec-sheet-P-ATT10EA-R290-EN.pdf` |
| `IMG-REF-00193__REF__blast-chiller-10-tray-door-open-reseller-generic-blue-panel.jpg` | 800x800 | 63 KB | `https://egress.storeden.net/jpg/64e62f065fb8e00e3a8b45a1/file.jpg` |
| `IMG-REF-00193__spec-sheet-P-ATT10EA-R290-EN.pdf` | 2 pp | 1320 KB | Official Tecnodom sheet, printed 02-09-2025. Exact URL not recovered |
| `IMG-REF-00211__REF__MID-line-counter-4-door-official-line-photo.jpg` | 1000x1000 | 48 KB | `https://www.tecnodomspa.com/images/gallery/95/large/6a19a0f7a53c5.jpg` |
| `IMG-REF-00211__technical-drawing-official.png` | 1654x2339 | 430 KB | Rendered from `IMG-REF-00211__spec-sheet.pdf` by agent 1 |
| `IMG-REF-00211__spec-sheet.pdf` | 1 pp | 1213 KB | Official TF02MIDBT sheet. Exact URL not recovered |
| `IMG-REF-00212__REF__MID-line-counter-3-door-3-drawer-splashback-official.jpg` | 1000x1000 | 64 KB | `https://www.tecnodomspa.com/images/gallery/95/large/tavolo-gn0000Tecnodom-04230x40-revisione.jpg` |
| `IMG-REF-00212__technical-drawing-official.png` | 1654x2339 | 443 KB | Rendered from `IMG-REF-00212__spec-sheet.pdf` by agent 1 |
| `IMG-REF-00212__spec-sheet.pdf` | 1 pp | 1217 KB | Official TF03MIDBT sheet. Exact URL not recovered |

#### Cold displays and pastry display

| File | Px | Size | Source URL |
|---|---|---|---|
| `IMG-DIS-00093__V6060SL-eu-energy-label.jpg` | 900x1799 | 38 KB | `https://media.allforfood.co.uk/media/catalog/product/L/a/Label_V6060SL_1.jpg` |
| `IMG-DIS-00093__REF__VULCANO-open-front-white-1080mm-TDVC60-CA-100-not-680mm.jpg` | 1100x1100 | 63 KB | `https://cdn.shopify.com/s/files/1/0738/9826/2835/files/open-chiller-tdvc60-ca-100_f8d7c6e7-bf1e-4f6c-a66c-cef1b462a421.jpg` |
| `IMG-DIS-00095__VB80250SL-eu-energy-label.jpg` | 900x1799 | 38 KB | `https://media.allforfood.co.uk/media/catalog/product/L/a/Label_VB80250SL_1.jpg` |
| `IMG-DIS-00095__REF__TDVB80-CA-250-4-door-2580mm-CA-config-front.jpg` | 1100x1100 | 81 KB | `https://cdn.shopify.com/s/files/1/0738/9826/2835/files/tdvb80-ca-250-vulcano-supermarket-4-door-open-display_62b0a709-8244-427a-8d88-b5f22e3e5b58.jpg` |
| `IMG-DIS-00095__REF__TDVB80-CA-250-4-door-2580mm-CA-config-door-open.jpg` | 1100x1100 | 85 KB | `https://cdn.shopify.com/s/files/1/0738/9826/2835/files/tdvb80-ca-250-vulcano-supermarket-4-door-open-display-door-open_1c63b994-68a2-4842-b9c9-e606cffa01e3.jpg` |
| `IMG-DIS-00095__REF__VULCANO-VB-line-head-official.jpg` | 800x800 | 68 KB | `https://www.tecnodomspa.com/images/prodotti/espositori-refrigerati/Vulcano/VULCANO-big.jpg` |
| `IMG-DIS-00096__V60187SL-eu-energy-label.jpg` | 900x1799 | 39 KB | `https://media.allforfood.co.uk/media/catalog/product/L/a/Label_V60187SL_1.jpg` |
| `IMG-DIS-00096__REF__TDVC60-CA-187-1955mm-CA-config-pink-led.jpg` | 1100x1100 | 73 KB | `https://cdn.shopify.com/s/files/1/0738/9826/2835/files/open-chiller-tdvc60-ca-187_9425570b-3c3c-4fcf-ba37-9913b2b7e749.jpg` |
| `IMG-DIS-00096__REF__TDVC60-CA-187-cad-drawing.jpg` | 1100x1100 | 38 KB | `https://cdn.shopify.com/s/files/1/0738/9826/2835/files/open-chiller-tdvc60-ca-187-cad-drawing_52b5875e-b975-413f-934a-91c7107b4d89.jpg` |
| `IMG-DIS-00100__REF__VS60150SL-eu-energy-label-SUSPECT-4.90m2.jpg` | 900x1799 | 39 KB | `https://media.allforfood.co.uk/media/catalog/product/L/a/Label_VS60150SL_1.jpg` |
| `IMG-DIS-00100__REF__VULCANO-VS-stainless-sliding-door-reseller.jpg` | 698x977 | 48 KB | `https://media.allforfood.co.uk/media/catalog/product/V/U/VULCANO_INOX_80_FV_PSC.jpg` |
| `IMG-DIS-00106__V6080SLINOX-eu-energy-label-issued-as-TRBV6080SLINOX.jpg` | 900x1799 | 39 KB | `https://media.allforfood.co.uk/media/catalog/product/L/a/Label_V6080SLINOX_1.jpg` |
| `IMG-DIS-00106__REF__VULCANO-60-INOX-open-front-stainless-reseller.jpg` | 1086x1448 | 134 KB | `https://media.allforfood.co.uk/media/catalog/product/V/U/VULCANO_60_inox.jpg` |
| `IMG-DIS-00037__REF__EVOK-straight-glass-3-shelf-official-line-angled.jpg` | 800x800 | 40 KB | `https://www.tecnodomspa.com/images/gallery/70/large/evok-big-01.jpg` |
| `IMG-DIS-00037__REF__EVOK-straight-glass-official-line-front.jpg` | 800x800 | 41 KB | `https://www.tecnodomspa.com/images/gallery/70/large/evok-01.jpg` |
| `IMG-DIS-00037__REF__EVOK-straight-glass-official-line-wide-angled.jpg` | 800x800 | 41 KB | `https://www.tecnodomspa.com/images/gallery/70/large/evok-04.jpg` |

#### `_brand-reference/` - manufacturer catalogues, staged by agent 1

| File | Pages | Size | Source URL |
|---|---|---|---|
| `tecnodom-FORNI-oven-catalogue-Schedeforni.pdf` | 37 | 33 MB | `https://www.tecnodomspa.com/files/34/schede-pdf/128/Schedeforni.pdf` |
| `tecnodom-VULCANO-multideck-catalogue-Schedevulcano.pdf` | 64 | 9.2 MB | Exact URL not recovered; same `files/…/schede-pdf/` tree, filename `Schedevulcano.pdf` |
| `tecnodom-ALADINO-ATTILA-R290-blast-chiller-catalogue.pdf` | 84 | 6.3 MB | Exact URL not recovered; same tree |
| `tecnodom-TAVOLI-GN-refrigerated-counter-catalogue-SchedetavoloGN.pdf` | 18 | 21 MB | Exact URL not recovered; same tree, filename `SchedetavoloGN.pdf` |

### Contradictions between sourced material and the stored record

Nothing below has been applied to `products.json`. Each needs a decision.

#### 1. Display surface: every VULCANO figure disagrees with its own EU energy label

The research file's display-surface table (section 2) is contradicted by the official EU energy
labels, which carry TECNODOM plus the exact article number in-frame:

| SKU | Model | Research file says | Energy label says | Delta |
|---|---|---|---|---|
| IMG/DIS/00093 | V6060SL | 0.85 m² | **0,79 m²** | -7 % |
| IMG/DIS/00106 | V6080SLINOX | 1.14 m² | **1,05 m²** | -8 % |
| IMG/DIS/00096 | V60187SL | 2.66 m² | **2,50 m²** | -6 % |
| IMG/DIS/00095 | VB80250SL | 5.06 m² | **4,90 m²** | -3 % |

**This is most likely a definitional difference, not an error.** The EU label reports regulated
*Total Display Area* (TDA) measured to EN/Regulation 2019/2024 method; Tecnodom's marketing
"display surface" is measured differently. The consistent negative direction (label always lower)
supports that reading. **Recommendation: keep the current figures but footnote the TDA value**,
because a Kenyan buyer comparing against a label will otherwise see a mismatch. Do not silently
swap them.

#### 2. The temperature-boilerplate conclusion needs softening

Research section 2 concluded that `+2 ~ +8 °C` on three display coolers was catalogue boilerplate
and replaced it with `+3/+5 °C`. The energy labels show these regulated temperature classes:

| Model | Energy label class |
|---|---|
| V6060SL | **+2 / +10 °C** |
| V60187SL | **0 / +8 °C** |
| VS60150SL | +1 / +7 °C |
| V6080SLINOX | +1 / +7 °C |
| VB80250SL | +1 / +7 °C |

The V6060SL label's `+2/+10` is very close to the rejected `+2/+8`. That does **not** overturn the
`+3/+5` correction - the label class is the M-package test envelope, not the operating setpoint,
and `+3/+5` is what Tecnodom's own VULCANO SL datasheet states. But it does mean the `+2/+8`
figures were probably **derived from energy-label data, not auto-filled boilerplate**. The
"worth checking for the same pattern on other brands" note in section 2 should be read with that
caveat: the pattern may be label-derived, which is a different (and less alarming) failure mode.

Independent corroboration for `+3/+5`: the allforfood.co.uk product title for the VULCANO 60 INOX
reads *"TEMP. RANGE °C +3/+5 - SELF SERVICE APPLICATION"*.

#### 3. V6080SLINOX's energy label is issued under a different article number

The label for our `V6080SLINOX` is headed **`TRBV6080SLINOX`**, vendor "TECNODOM SPA" (the other
four labels say just "TECNODOM"). The `TRB` prefix does not appear anywhere in the decoding table
in section 1 and was not seen on any other Tecnodom asset in this pass. **Unresolved** - it may be
an export/OEM prefix or a label-registration artefact. Flagged, not acted on. The staged filename
records it.

#### 4. The VS60150SL energy label is not trustworthy

`Label_VS60150SL_1.jpg` states **4,90 m²** and +1/+7 °C - byte-for-byte the same figures as the
`VB80250SL` label, which is a 2,580 mm four-door cabinet. A 1,600 mm sliding-door VS unit cannot
have the same display area as a cabinet 60 % longer; the research file puts VS60150SLINOX at
2.16 m². The two label files are **not** byte-identical (39,498 vs 39,036 bytes) so this is not a
straight file mix-up, but the payload is duplicated. Staged with a `SUSPECT` marker.
**Do not use this label as a source for anything.**

This is the same failure class as the byte-identical-renders trap flagged for other brands, here
appearing in a compliance document rather than a photograph.

#### 5. Refrigerated counter capacities disagree with Tecnodom's own sheets

Read directly out of the staged official spec sheets:

| SKU | Model | Stored `short_description` | Official sheet |
|---|---|---|---|
| IMG/REF/00211 | TF02MIDBT | "holding **310** litres" | **302 Lt** gross / **210 Lt** net |
| IMG/REF/00212 | TF03MIDBT | "holding **460** litres" | **455 Lt** gross / **315 Lt** net |

Small but real. A web search during agent 1's run also surfaced **475 L** and **460 L** for
TF03MIDBT from third-party dealers, so three figures circulate. The Tecnodom sheet is the
authority: **302 / 455 L gross**. Note also that the stored figures are gross, not net - if the
listing is meant to help a buyer size a kitchen, the net figure (210 / 315 L) is the useful one.

#### 6. R290 is *on request*, not standard, on the counters

Directly quoted from both staged counter sheets:

> `R452A - R455A - R290 (A richiesta / On request)`

So the standard gas is R452A or R455A; **R290 propane is an option**. Research section 4.2 was
right to omit refrigerant. This is the specific error class flagged before ("one brand asserted
R290 as standard where it is an option") - **it is present in Tecnodom's product line but is
correctly absent from our stored record.** Nothing to fix; recorded so a future pass does not
introduce it.

The blast chillers are the opposite case: both staged sheets are the explicitly R290 builds
(`P-ATT05EA`, `P-ATT10EA`) and state `Gas R290` unconditionally in the feature list. The
`P-` prefix decoding in section 1 is confirmed correct.

Separately, the Perfekt 700 line page states: *"tropicalised refrigeration unit (+30 °C room
temperature and 60 % relative humidity) using R290 gas, on request R455a gas"* - so on the
**upright cabinets** R290 *is* standard today, with R455A the option. That is the reverse of the
counters. Refrigerant genuinely varies by line; section 4.2's caution stands.

#### 7. Electrical - no wrong-market problem found

Both counter sheets read `220 / 240 V - 1P - 50 Hz (60 Hz A richiesta / On request)`. Correct for
a Kenyan 240 V / 50 Hz listing. No US 110/120 V or 60 Hz figures appeared anywhere in this pass.

#### 8. FEM04NEPSV door type - open question 4.4 is now answered

Research section 4.4 recorded that dealers disagreed on the FEM04NEPSV door type. The staged
official spec sheet `IMG-OVE-00128__spec-sheet.pdf` settles it by listing all three variants:

| Code | Door |
|---|---|
| **FEM04NEPSV** | **PORTA A RIBALTA - folding / drop-down door (standard)** |
| FEM04NEPSDX | *porta a bandiera DX* - right-hinged (optional) |
| FEM04NEPSVSX | *porta a bandiera SX* - left-hinged (optional) |

**`FEM04NEPSV` is the drop-down-door build.** The dealers claiming *porta a bandiera* were
describing the DX/SX option codes. Safe to publish.

#### 9. Counter dimensions confirm the section-2 axis normalisation

The official sheets give, in explicit `LxPxH / LxDxH` order:

- **TF02MIDBT**: 1420 x 700 x 840/910 mm (GN worktop build)
- **TF03MIDBT**: 1870 x 700 x 840/910 mm

These match the decoding table's `02 -> 1420 mm` / `03 -> 1870 mm` exactly, and match the
width x depth x height normalisation applied in section 2. **No axis swap on these two SKUs.**
Note the dual height `840/910` - the second figure is feet-extended, the same
retracted/extended convention section 2 records for the upright cabinets.

Both sheets also list four worktop variants at slightly different overall heights (`800/870`,
`830/900`, `940/1010`). If the stored height came from the wrong variant row that would be a
70-100 mm error; worth a spot-check against the stored value.

#### 10. Blast-chiller control panels differ between the two R290 sheets

`P-ATT05EA`'s sheet shows a **red-bordered** control panel; `P-ATT10EA`'s shows a **green-bordered**
one (green being the usual natural-refrigerant marking), and the reseller photo staged for
IMG/REF/00193 shows a **blue** panel again. Three panel colours across what should be one line.
Cosmetic, but it means **panel colour cannot be used to identify build or refrigerant** on this
brand - noted so a future pass does not treat it as evidence. The reseller shot is marked
`generic-blue-panel` for that reason.

### Not resolved by this pass

- **No photograph anywhere of `AF07EKOMTNPV`** above 600 px. The EKO line has no manufacturer
  gallery and the one exact dealer listing (soazimaq.pt) caps at 600x574.
- **No length-matched photo for `V6060SL`** (680 mm). The shortest VULCANO open-front render found
  is the 1,080 mm TDVC60-CA-100.
- **`VS60150SLINOX` has no stainless-specific asset with its code in frame** - the INOX label code
  returns a placeholder and the staged photo is a VS-family stainless unit of unproven length.
- Exact source URLs for 11 of agent 1's staged files (5 oven PNGs, 1 REF oven PNG, 5 spec-sheet
  PDFs) and 3 of the 4 brand catalogues. Recorded above as "not recovered" rather than guessed.
