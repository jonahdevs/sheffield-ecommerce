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
