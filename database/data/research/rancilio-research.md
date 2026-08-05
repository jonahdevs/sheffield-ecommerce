# RANCILIO - SAP-led research pass (2026-07-31)

15 SKUs, all 15 covered. 108 images and 15 spec/manual PDFs staged to
`Desktop\ecommerce\products resorce final\rancilio\`.

Rancilio is one of the easiest brands in the catalogue to verify: the manufacturer
publishes a per-variant technical-specification tab on every product page, Rancilio Group
North America publishes a two-page spec sheet PDF per model, and Rancilio Group NA also
publishes the user manuals. That gives **three independent manufacturer channels** for most
SKUs, which is what made the SAP defects below provable rather than merely suspected.

Primary sources used throughout:

https://www.ranciliogroup.com/rancilio/classe-5/classe-5-s/
https://www.ranciliogroup.com/rancilio/classe-7/classe-7-s/
https://www.ranciliogroup.com/rancilio/silvia/silvia/
https://www.ranciliogroup.com/rancilio/silvia-pro-x/silvia-pro-x/
https://www.ranciliogroup.com/rancilio/kryo/kryo-65-st/
https://www.ranciliogroup.com/rancilio/kryo/kryo-65-od/
https://www.ranciliogroupna.com/equipment/rancilio-classe-5/
https://www.ranciliogroupna.com/equipment/rancilio-classe-7/
https://www.ranciliogroupna.com/equipment/rancilio-silvia-pro-x/
https://www.ranciliogroupna.com/equipment/rancilio-kryo-65/
https://www.espressoparts.com/collections/rancilio
https://www.wholelattelove.com/

---

## 1. Axis convention - established, not assumed

Rancilio's own site states Width / Height / Depth explicitly per model. Cross-checked
against SAP and against `products.json` for five machines:

| Model | Rancilio W x D x H (mm) | SAP L / W / H | products.json L / W / H |
|---|---|---|---|
| Classe 5 S 1GR | 410 x 539 x 520 | 410 / 538 / 518 | 410 / 520 / 539 |
| Classe 5 S 2GR | 771 x 539 x 520 | 770 / 540 / 520 | 771 / 520 / 539 |
| Classe 7 S 3GR | 1010 x 540 x 520 | 750 / 495 / 520 | 1010 / 520 / 540 |
| Silvia | 235 x 290 x 340 | 235 / 290 / 340 | 235 / 290 / 340 |
| Kryo 65 ST | 220 x 385 x 575 | 220 / 385 / 575 | 220 / 385 / 575 |

**Conclusion for this brand:**

- **SAP stores (Width, Depth, Height).** Its `W` field is the DEPTH, exactly as the
  catalogue-wide warning predicts. On this brand SAP's axis order is otherwise *correct*.
- **`products.json` stores (Width, Height, Depth) for the espresso machines** - the last
  two fields are transposed relative to reality. On 00035 / 00037 / 00038 / 00039 our stored
  "height" is actually the depth and vice versa. The grinders and Silvia are not affected
  (they happen to match SAP).
- The one exception is **IMG/COF/00135 (Kryo 65 OD)**, where `products.json` holds
  356 / 220 / 575 - that is (Depth, Width, Height), a third ordering. See §4.

Do not bulk-apply SAP dimensions without this mapping.

---

## 2. The headline defect: IMG/COF/00036 is the TANK machine, not a "Tall" machine

SAP model `CLASS 5ST GR 1`, description `ESPRESSO MACHINE CLASS 5ST GR1`.
Earlier (pre-SAP) research in `research/old/rational-rancilio-kef-gaps-research.md` read the
`ST` as **"S Tall"** and staged Classe 5 **S Tall** renders for it. That is wrong.

`ST` = **S Tank**. Four independent proofs:

1. Rancilio's own Classe 5 S page has five variant tabs - `1GR 1GRT 2GR 2GRC 3GR`. The
   `1GRT` tab is identical to `1GR` except its water supply reads
   **"Built-in 2-litre water tank"** instead of "Fixed water connection".
   https://www.ranciliogroup.com/rancilio/classe-5/classe-5-s/
2. Rancilio Group NA publishes a dedicated spec sheet literally titled
   **"C Spec Sheet RANCILIO C5 S 1G TANK"**, whose body says
   *"Tank Version (ST) ... the Classe 5 ST remains surprisingly portable"* and
   *"Pour-over 2L water reservoir and drain basin"*.
   https://www.ranciliogroupna.com/wp-content/uploads/2021/09/C-Spec-Sheet-RANCILIO-C5-S-1G-TANK-08-21.pdf
3. Dealers sell it as "Classe 5 S 1 Group **Tank**" / "Classe 5 **ST**":
   https://www.espressoparts.com/products/rancilio-classe-5-s-1gr-tank-semi-automatic-espresso-machine-anthracite-black
   https://www.wholelattelove.com/products/rancilio-classe-5-st-1-group-espresso-machine
   https://www.allespressoservice.com/products/rancilio-classe-5-1gr-st-black-with-water-tank-110v
4. **SAP's own remark says it**: *"Direct drain connection with 2 litre tank"* - the only
   line that differs from the plain 5S GR1 remark. SAP was right; the earlier research
   misread it.

Rancilio S Tall is a genuinely different variant (it exists at
https://www.ranciliogroup.com/rancilio/classe-5/classe-5-s-tall/ ) - which is exactly why
the mistake was easy to make and worth recording.

Manufacturer order code seen at a dealer for the black 1GR ST: **`C05/21-1-ST-B`**
(https://www.allespressoservice.com/products/rancilio-classe-5-1gr-st-black-with-water-tank-110v).
Not applied - `model_number` untouched.

**Image warning for this SKU.** Espresso Parts' "Tank" product page carries the *same three
photographs* as its non-tank 1 Group page (base filenames `cla5s-1gr-blk_frt / _xbck / _bck`;
the non-tank listing has the same files with a Shopify UUID appended). They are re-encodes,
not different shots - visually identical, and the rear view shows **no reservoir on top**.
So no Espresso Parts photo actually depicts the tank. The only staged asset that does is
`IMG-COF-00036__CLASSE-5-S-1GRT-specsheet-photo-7.png`, extracted from the NA TANK spec-sheet
PDF, where the translucent pour-over reservoir lid is visible on the cup rail.

---

## 3. The second headline defect: IMG/COF/00039 carries Classe 7 **2-group** data

SAP: `CLASS 7S GR 3`, `ESPRESSO MACHINE CLASS 7S GR3`, L/W/H **750 / 495 / 520**,
remark *"...Weight 74 kg. Boiler 16 Litres. Boiler power 6000 W."*

Truth, from two manufacturer channels:

- ranciliogroup.com Classe 7 S: **2GR = 770 x 540 x 520 mm, 74 kg**;
  **3GR = 1010 x 540 x 520 mm, 85 kg**.
- Rancilio Group NA Classe 7 S spec sheet counter requirements:
  2 GROUP 31" x 22" x 21", 124 lb; **3 GROUP 40" x 22" x 21", 157 lb** (= 1016 x 559 x 533 mm).
  https://www.ranciliogroupna.com/wp-content/uploads/2021/05/C-Spec-Sheet-RANCILIO-CLASSE-7-S-v9.pdf

So SAP's 750 mm is not a 3-group width at all, and its 74 kg is the **2-group** weight.
The whole SAP row for 00039 looks populated from the 2-group. `products.json`'s 1010 is
right (its D/H are transposed - see §1). Photographs staged for 00039 were checked by
counting group heads: three groups, `classe 7` script on the cup rail.

---

## 4. Per-SKU findings

### IMG/COF/00035 - CLASSE 5 S 1GR
Verified 1 group by eye on 8 images (official black/white/grey renders, Espresso Parts
black front/3-4 back/back, NA spec-sheet photo). W410 x D539 x H520, 37 kg (site) /
73 lb = 33 kg (NA sheet). SAP 410/538/518 is right to within 2 mm.
https://www.espressoparts.com/products/rancilio-classe-5-s-1gr-espresso-machine-black
https://www.ranciliogroupna.com/wp-content/uploads/2021/09/C-Spec-Sheet-RANCILIO-C5-S-1G-08-21.pdf

### IMG/COF/00036 - CLASSE 5 S 1GRT (Tank)
See §2. Same shell and same 410 x 539 x 520 / 73 lb as the 1GR; the difference is
vibrating pump + 2 L pour-over reservoir instead of volumetric pump + plumbing.

### IMG/COF/00037 - CLASSE 5 S 2GR, Anthracite Black
Two groups confirmed, black side panel confirmed on the 3/4 and side views.
771 x 539 x 520. SAP 770/540/520 correct.
https://www.espressoparts.com/products/rancilio-classe-5-s-2-group-semi-automatic-espresso-machine-anthracite-black

### IMG/COF/00038 - CLASSE 5 S 2GR, Ice White
Same, white panels confirmed on 3/4 and both side views. The Espresso Parts white photos
are the newer body carrying the **SB (Steady Brew)** badge; the black set is the pre-2022
shot. Cosmetic difference only, but the two SKUs will not look like a matched pair if the
front shots are used as-is.
https://www.espressoparts.com/products/rancilio-classe-5-s-2-group-semi-automatic-espresso-machine-ice-white

### IMG/COF/00039 - CLASSE 7 S 3GR
See §3. 13 images staged (official front/iso/side in black + white front, Espresso Parts
front/3-4 L+R/side L+R/back).
https://www.espressoparts.com/products/rancilio-classe-7-s-3-group-semi-automatic-espresso-machine-anthracite-black

### IMG/COF/00041 - SILVIA
Base Silvia confirmed: three rocker switches, one round steam knob, **no display, no
pressure gauge**. 235 x 290 x 340 mm, 14 kg, 0.3 L boiler, 2 L tank - agreed by the product
page and the Home Line booklet. SAP 235/290/340 exactly right.
https://www.ranciliogroup.com/rancilio/silvia/silvia/
https://www.ranciliogroupna.com/wp-content/uploads/2021/05/Homeline_Booklet_ENG_web.pdf

### IMG/COF/00079 - SILVIA PRO (X) - SAP row is the base Silvia's
SAP has **235 / 290 / 340** and a remark that is word-for-word the base Silvia's remark
(0.3 L boiler, 950-1100 W, 14 kg) with a Pro-specific tail appended.
Truth, from three sources that agree exactly:
- ranciliogroup.com: W 250 x H 390 x D 420 mm, 20 kg
- Home Line booklet: 250 x 420 x 390 mm
- NA spec sheet SPEC-HL_SPX: Width 9.8" / Depth 16.5" / Height 15.3" (= 249 x 419 x 389)
https://www.ranciliogroupna.com/wp-content/uploads/2024/09/SPEC-HL_SPX.pdf

`products.json`'s 250/390/420 is the correct machine (with the D/H transposition of §1);
**SAP is wrong here and must not be applied.** It is a dual-boiler machine with a digital
display and a gauge above the drip tray - visually unmistakable against the base Silvia, and
that is how the staged photos were checked.

### IMG/COF/00043 - KRYO 65 ST
Doser chamber with manual lever + portafilter fork confirmed on all images.
Site: 220 x 385 x 575 mm, 13 kg. SAP 220/385/575 correct.

**Known unresolvable: ST and AT share photography.** Verified by hash this pass, not by
assumption - `IMG-COF-00043__KRYO-65-ST-espressoparts-front-4.jpg` and
`IMG-COF-00043__REF__KRYO-65-AT-espressoparts-front-9.jpg` are **byte-identical**
(sha1 25efc4a680535a80) although they come from two different product pages. Rancilio's own
ST page also serves `grinder-kryo-65-AT-white-*.jpg` files. No photograph can separate ST
from AT; only the copy can. Do not re-run this search.
https://www.espressoparts.com/products/rancilio-kryo-65-st-commercial-espresso-grinder
https://www.espressoparts.com/products/rancilio-kryo-65-at-commercial-espresso-grinder

### IMG/COF/00135 - KRYO (EVO) 65 OD - SAP carries the ST's depth
On-demand confirmed: OLED display reading `SINGOLO`, two dose buttons, **no doser chamber**.
- ranciliogroup.com Kryo Evo 65 OD: **220 x 356 x 575 mm, 11.5 kg**
- ranciliogroup.com Kryo 65 ST: 220 x **385** x 575 mm, 13 kg
- SAP for 00135: 220 / **385** / 575 - i.e. the ST's depth pasted onto the OD.
`products.json`'s 356 is the right number, in the wrong slot.
Rancilio have refreshed this model as **Kryo Evo 65 OD**; both the black and the new white
renders are staged.

Complication worth recording: the 2021 **Kryo booklet** prints `220 x 356 x 575 mm, 13 kg`
for *both* ST and OD - the booklet copy-pasted one spec block. The current website
differentiates them. I have taken the website (385 ST / 356 OD, 13 kg / 11.5 kg) as
authoritative; the booklet is staged as evidence of the conflict.
https://www.ranciliogroupna.com/wp-content/uploads/2021/05/RANCILIO_KRYO_BOOKLET_IT_EN.pdf

### IMG/COF/00044 - ROCKY (doser, stainless)
Doser chamber + lever + stainless side panel confirmed. Discontinued from Rancilio's current
range (no Rocky page in `rancilio_product-sitemap.xml`); still stocked by dealers.
- SAP 120 / 250 / 350 matches the **Home Line booklet** exactly (120 x 250 x 350 mm).
- The **Rocky user manual** - Rancilio's own, more precise document - gives
  **116 x 245 x 350 mm and 7 kg**, motor 140 W, hopper ~300 g, doser ~200 g.
  https://www.ranciliogroupna.com/wp-content/uploads/2021/05/MAN-Rocky-SS-SD-2019-12.pdf
- Dealers quote 19.2 lb / 8.7 kg, which is a shipping weight, not the 7 kg net.
SAP's remark otherwise checks out (300 g hopper, 7 g dose, 50 mm burrs, 140 W).

### IMG/COF/00128 - ROCKY DOSER NERO BLACK
Exact variant located and eyeballed: black body, black side panel, doser chamber with lever,
numbered grind collar, portafilter fork.
https://clumsygoat.co.uk/products/rancilio-rocky-doser-home-coffee-grinder-50mm-black
Caveat (rule 5): that file is served at 2000x2000 but is visibly an **upscale** of a much
smaller original - soft edges throughout. It is the only exact-variant photo found. The two
other black Rockys staged are **doserless** and are marked `REF__` accordingly:
https://www.seattlecoffeegear.com/products/rancilio-rocky-black-espresso-grinder-doserless-open-box
https://comisocoffee.com/products/rancilio-rocky-coffee-grinder
SAP has 0/0/0 dimensions for this SKU; it is the same body as 00044, so 116 x 245 x 350 mm.
SAP model `MFR010-00076` is an internal/supplier order code, not a Rancilio model - the
model is `ROCKY`, which is what `products.json` already holds.

### IMG/COF/00047 - EGRO "MAEA03" MILK FRIDGE
The product is real and was identified: the **Egro Quick Milk countertop fridge**, 4 L milk
tank, sold as an accessory to the Egro Zero+ / One Touch Quick Milk machines. Photographs
staged show the Egro red-triangle badge, brushed stainless door and door lock.
https://egrocoffee.com/en/products/accessories/fridges/quick-milk/
https://www.jlhufford.com/products/egro-quick-milk-fridge-1-gallon
https://prestigeproducts.com.au/egro-zero-quick-4l-milk-fridge/

**New this pass - the OEM.** Two dealer part codes point at the same maker:
`rancc-fg10l-vfau` (J.L. Hufford) and `99MILKVITRI-10L VFAU`. The fridge is a rebadged
**Vitrifrigo FG10 / FG10i** milk cooler. Vitrifrigo's own milkcooler catalogue is staged as
the OEM spec sheet.
https://www.vitrifrigo.com/ww/en/fg10i
https://www.vitrifrigo.com/media/contentmanager/content/MILKCOOLERS_CATALOGUE_REV.01_Feb._2024.pdf

Dimension check: Egro distributor Prestige gives **W 230 x D 460 x H 356 mm, 12 kg**.
SAP has 230 / 460 / **340**, 14 kg, 4.5 L. So SAP's W and D are right, its **height is ~16 mm
short** and its weight is ~2 kg over. Capacity is quoted as **4 L** by Egro and by every
dealer; SAP's 4.5 L is unsupported. Power: SAP 0.1 kW agrees with the NA spec sheet's 86 W;
Prestige's "0.8 kW" is a plug rating, not consumption.
https://egrousa.com/wp-content/uploads/2021/05/C-Spec-Sheet-ZERO-Quick-Milk-v1.pdf

**`MAEA03` remains unidentified** - see dead ends.

### IMG/COF/00048 - "IV8" / "WATER SOFTENERS DP2" - not a Rancilio product
Resolved this pass. **`IV8` is DVA's model code**, not Rancilio's. DVA (De Vecchi) make the
`iv` series of manual ion-exchange softeners for espresso machines, dishwashers and steam
ovens. Their own instruction booklet (rif. 214, staged) prints the family table:

| model | h [mm] | weight [kg] | resin [l] | salt/regen [kg] |
|---|---|---|---|---|
| **iv8** | **400** | **8** | **5.6** | **1** |
| iv12 | 500 | 10 | 8.4 | 1.5 |
| iv16 | 600 | 12.5 | 11.2 | 2 |
| iv20 | 900 | 19 | 14 | 2.5 |

plus 1-8 bar, 4-25 degC feed water, and a cylinder diameter of **190 mm**.
https://dvgdevecchi.com/download/allegati/IV_Manuale_di_istruzioni.pdf
https://www.manualslib.com/manual/1228461/Dva-Iv8.html
https://mondo.ge/product/water-softener-dp2/?lang=en
https://www.espressoparts.com/products/8-liter-espresso-machine-water-softener-rechargeable

**Dimension defect:** the true geometry is a cylinder **Ø190 mm x H400 mm**. SAP stores
400 / 170 / 250 - the 400 is the HEIGHT sitting in the length field, and 170 / 250 are
unexplained. `products.json`'s 400 / 250 / 190 is equally scrambled. Neither should be
trusted; use Ø190 x H400, 8 kg.

SAP remark disagreements against the DVA booklet: SAP says 7.5 kg (DVA: 8 kg) and
1000 l/h (DVA booklet: 900 l/h; some DVA datasheets do print 1000 l/h for the iv8, so the
remark is probably an older DVA sheet, not an error).

**Brand attribution is wrong.** The image currently stored in `products.json` for this SKU
is a **BWT bestcup** softener (the label is legible in the stored PNG); the best independent
photo I could stage is a **DVA**-labelled unit. Both are the same OEM bodyshell. Nothing
about this SKU is Rancilio. `DP2` is a softener *size* designation that appears in Rancilio's
Epoca documentation, which is presumably how the SKU ended up filed under RANCILIO, but
Rancilio do not manufacture it.

### IMS/MEC/00303 - COFFEE TAMPER, STAINLESS STEEL
The genuine Rancilio 58 mm tamper is part **`69000449`** - three dealers quote that number
and all three photographs show the **same object: a stainless steel base with a black
contoured handle** carrying the Rancilio double-R.
https://bellabarista.co.uk/products/rancilio-espresso-tamper-58mm
https://www.homecoffeemachines.ie/products/rancilio-tamper
https://www.jlhufford.com/products/rancilio-silvia-tamper-with-wood-handle-58mm

Two things to record:
1. **Dealer copy is wrong on all three sites** - each describes a "wood handle" while its own
   photo shows a black handle. A fourth shop sells a genuinely *wood*-handled Rancilio tamper
   (staged as `REF__`), so the two products exist and the listings are cross-contaminated.
   https://www.primecoffeesuppliers.co.uk/products/rancilio-tamper
2. **Our stored image is neither.** `coffee-tamper-stainless-steel-imsmec00303.png` shows a
   **one-piece, all-stainless** tamper with no Rancilio marking. If the SKU really is the
   Rancilio catalogue tamper, the stored photo is wrong; if the SKU is a generic all-steel
   tamper, then the RANCILIO brand attribution is wrong. Not resolvable from documents -
   needs a physical check of stock.

### IMS/MEC/00469 - COFFEE TAMPER, PVC
Solid result. Rancilio genuine part **`38120005`**, described by a parts specialist as
**"Nylon Coffee Tamper Ø 50/57 mm"**. The staged photograph is an exact match to the stored
catalogue photo: all-black plastic, flat mushroom top, wide flat base, with the part number
embossed on the stem.
https://kaldi.com/products/coffee-tamper
https://www.cafeparts.com/Nylon-Coffee-Tamper-%C3%98-50-57-mm/Product_Manu/9025/Rancilio/38120005
https://www.partstown.com/rancilio/ra38120005
Note that Kaldi's own copy claims a "sturdy stainless steel base" - contradicted by their own
photo. Material is nylon/plastic, so "PVC" in our name is loosely right; **Ø 50/57 mm** is a
real specification we did not have. `model_number` is currently the word `PVC`; `38120005`
is the real code, not applied.

---

## 5. SAP disagreements - summary

| SKU | SAP says | Verified | Verdict |
|---|---|---|---|
| 00036 | model `CLASS 5ST GR 1` | Classe 5 S **1GRT** = tank version | SAP right, old research wrong |
| 00039 | 750 / 495 / 520, 74 kg | 1010 x 540 x 520, 85 kg | **SAP row is the 2-group's** |
| 00079 | 235 / 290 / 340 + base-Silvia remark | 250 x 420 x 390, 20 kg | **SAP row is the base Silvia's** |
| 00135 | 220 / 385 / 575 | 220 x 356 x 575, 11.5 kg | SAP carries the **ST's depth** |
| 00047 | 230 / 460 / 340, 14 kg, 4.5 L | 230 x 460 x 356, 12 kg, 4 L | height short, weight over, capacity over |
| 00048 | 400 / 170 / 250, 7.5 kg | Ø190 x H400, 8 kg | axis scrambled; 400 is the height |
| 00044 | 120 / 250 / 350 | 116 x 245 x 350 (manual) | SAP matches the marketing booklet, not the manual |
| 00037/38 | 55 kg (remark) | NA sheet 122 lb = 55 kg | SAP remark agrees with NA; site says 74 kg (below) |
| 00128 | 0 / 0 / 0, model `MFR010-00076` | same body as Rocky | dims missing; model code is an order code |
| 00303/00469 | model `RANCILIO` | `69000449` / `38120005` | SAP model field is the make, not a model |

**Unresolved manufacturer-vs-manufacturer conflict.** ranciliogroup.com and Rancilio Group
NA disagree on machine weights: 1GR 37 kg vs 73 lb (33 kg); 2GR 74 kg vs 122 lb (55 kg);
2GRC 55 kg vs 106 lb (48 kg); 3GR 85 kg vs 155 lb (70 kg). The NA figures are labelled
"counter requirements" (net) and are the ones SAP's remarks agree with. The .com figures run
15-35% high and are probably packed weights, but nothing on the page says so. Prefer the NA
net weights; flag if a customer-facing weight is ever published.

---

## 6. Dead ends - do not retry

- **`MAEA03`** (IMG/COF/00047). Searched again 2026-07-31 as a bare string: every hit on the
  open web is an unrelated product (an Elecom USB cable, an Agfa DR 800 component, a roof-tile
  clip, a university course code). It appears in no Egro, Rancilio or Vitrifrigo document.
  It is an internal Rancilio Group / Egro order code. The *product* is fully identified
  (Egro Quick Milk fridge = Vitrifrigo FG10) - only the code is unverifiable without a
  supplier price list.
- **Separating Kryo 65 ST from Kryo 65 AT by photograph.** Impossible - proven by hash, see
  §4. Both Rancilio and Espresso Parts serve the same image files on both product pages.
- **Espresso Parts' "Classe 5 S 1 Group Tank" photographs.** They are the plumbed 1GR's
  photos re-uploaded. Do not treat that page as a second sighting of the tank machine.
- **Rancilio-branded IV8/DP2 water softener.** Does not exist. The J.L. Hufford item sold as
  "Rancilio Water Softener" (part `69000313`) is a *drop-in, in-tank* softener for the
  Silvia/Epoca ST, a completely different product from our plumbed 8 L cylinder.
- **Rocky on ranciliogroup.com.** Discontinued; absent from `rancilio_product-sitemap.xml`.
  Dealers and the NA-hosted user manual are the only sources.
- 403-blocking sites that could not be fetched at all (bot protection, tried twice):
  `coffeeitalia.co.uk`, `italiankitchenaids.com`, `elektros.it`, `sevenfive.co.th`.
  The information they hold on the IV8 was obtained from the DVA manual instead.

---

## 7. Still open

1. **IMS/MEC/00303** - is the SKU the Rancilio `69000449` tamper (steel base, black handle)
   or the generic one-piece all-steel tamper in our stored photo? Needs a look at stock.
2. **`products.json` depth/height transposition** on 00035 / 00037 / 00038 / 00039, and the
   third ordering on 00135. Recorded here; **not applied** - no repo data file was modified.
3. **Model codes found but not applied** (per the model_number rule): `C05/21-1-ST-B` (00036),
   `38120005` (IMS/MEC/00469), `69000449` (IMS/MEC/00303), Vitrifrigo `FG10` (00047).
4. **00038 vs 00037 photo mismatch** - the white 2-group dealer set is the newer SB-badged
   body, the black set is the older one. If both SKUs go live with dealer front shots they
   will look like different models.
5. **Kryo 65 ST depth**: website 385 mm vs 2021 booklet 356 mm. Website taken as correct;
   a current Kryo spec sheet would settle it.
6. **IMG/COF/00048 brand** - nothing about this SKU is Rancilio. Its brand attribution should
   probably move to DVA (or to a generic accessories brand) rather than stay under RANCILIO.
