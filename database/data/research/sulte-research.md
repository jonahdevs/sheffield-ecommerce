# Sulte - product research

**This file supersedes `database/data/research/old/sulte-research.md`** (July 2026 pass).
That file was written before the SAP export was joined to the catalogue and before the
`sulteer.com` image CDN was enumerated properly. Where the two disagree, this one wins.
Three of its conclusions are reversed here and are called out in §7.

Covers all 12 SULTE SKUs: 10 induction cookers / fryers / griddles
(IMG/BUF/00226-00234, IMG/BUF/00282) and 2 microwave ovens (IMG/HOT/00402-00403).

Files, per-SKU ledger and the long-form evidence live in
`Desktop\ecommerce\products resorce final\sulte\` (`_sourced.json`, `_FINDINGS.md`).

**Nothing has been applied.** No `products.json`, `brands.json` or `storage/` change was
made, and no `model_number` change is proposed anywhere in this file.

---

## 1. Headline

- **The 9-10 induction SKUs are genuinely Foshan Shunde Sulte Electronics Co., Ltd.**
  Confirmed this pass from a new and much better document than the old pass had: the
  full **IEC 60335-2-36 CB test report 60436730 001**, Waltek Testing Group (Foshan),
  2021-09-17, 116 pages. Its model table names `SL-C351-KPP2`, `SL-C351-KPP3` and
  `SL-C351-4S13` alongside 35 siblings, with per-model electrical ratings.
  https://www.applianceregistrationdatabase.org.za/sites/default/files/safety_fu_9_other_1/60436730%20001%20TR_final%20%281%29.pdf
- **The 2 microwaves are a Midea OEM platform.** Sulte makes no microwaves - not on its
  site, not in its own company profile, not in the scope of its safety certification.
  The platform is sold under at least five badges. Evidence in §5. **No brand change is
  proposed - that is a user decision.**
- **`SL-C351-KPP3-Y` is not axis-swapped.** The record reads 800 mm wide x 355 mm deep,
  which SAP agrees with and which is a normal side-by-side two-zone footprint. What is
  crossed between 00230 and 00231 is the **product name**, not the dimensions (§3).
- **`GRT36B`'s stored width is wrong and SAP's own Item Remark says so.** GRT24B is
  610 mm wide (24"), GRT36B is 915 mm wide (36"). Both are 750 mm deep. Confirmed
  photogrammetrically from the manufacturer's renders (§4).
- **Two real data bugs on the microwaves**: 00403's stored dimensions are the shipping
  carton, and 00402's length/width are transposed (§5.4).
- **Photography**: 4 SKUs now have exact-code manufacturer imagery at 4901-9450 px, and
  every one of the 12 has at least one image of the right class of machine. The single
  genuine gap is the 23 L fryer (§6).

---

## 2. SAP's dimension field order for SULTE - established, not assumed

SAP's dimension **order** is not universal across brands, so it was derived from SAP
itself. Two rows carry an explicitly axis-labelled Item Remark:

- `IMG/BUF/00233` remark `W400 x D760 xH950mm` - SAP fields 400 / 760 / 950. Exact match.
- `IMG/BUF/00232` remark `D760 X W700 XH260mm` - SAP fields 450 / 700 / 130 (this row's
  fields are contaminated from 00231, see §6).

**SAP's fields for SULTE are (Width, Depth, Height).** Our `products.json` tuple is
**(length = depth, width, height)** - our `length` is SAP's `Depth`. Verified consistent
across 00226, 00227, 00229, 00232, 00233, 00234.

**The trap:** the Item Remark's own free-text order flips *within this one brand* -
`D x W x H` on 00226/00227/00229/00232, `W x D x H` on 00230/00231/00233/00234. Never
infer an axis from an unlabelled SULTE remark.

SAP zeros and blanks are treated as missing: weight is absent on 10 of 12 rows.

---

## 3. IMG/BUF/00230 `SL-C351-KPP3-Y` - the two-zone pair

**Not an axis swap. A name swap.**

Our record 355 / 800 / 113 decodes as **depth 355, width 800, height 113** under §2, and
SAP's own W/D/H fields say `800 / 355 / 113`. The two agree. Two 300 mm glass plates
side by side across 800 mm of width on a 355 mm-deep body is an ordinary commercial
form factor.

| SKU | Model | Our name | Real shape |
|---|---|---|---|
| IMG/BUF/00230 | `SL-C351-KPP3-Y` | "Two Zone **Table Top** 7KW" | 800 W x 355 D = **side by side** |
| IMG/BUF/00231 | `SL-C351-KPP2` | "Two Zone **(Side by Side)** 7KW" | 450 W x 700 D = **tandem, front-to-back** |

The `(Side by Side)` qualifier sits on the wrong SKU. Sulte's own tandem two-zone
renders (`SL-C351-2E3-Y`, `SL-C351-2M1-Y`) show a narrow, deep body matching 00231's
450 x 700 exactly.

The CB test report independently corroborates the pair's *controls*: it gives
`SL-C351-KPP2` a blank control-switch column and `SL-C351-KPP3` a **"Y series"** switch -
i.e. a knob. SAP says KPP2 is "Touch control" and KPP3-Y is "Touch & knob control".
Independent agreement, and it also shows **the trailing `-Y` in our model_number is
Sulte's own series designation**, not a local invention.

**Still unproven:** no photograph of either exact code exists anywhere on the public web.
The side-by-side reading of 00230 rests on its dimensions and its own name, not on a
picture. One supplier photo would close it.

Minor flag: 00230's remark says one `300X300X4mm` glass plate for a two-zone unit where
00231's says `300X300X4mmX2`. Probably a remark typo.

---

## 4. IMG/BUF/00234 `GRT24B` vs IMG/BUF/00282 `GRT36B` - resolved

**GRT24B = W610 x D750 x H402-405. GRT36B = W915 x D750 x H400-450.** Same depth,
different width. The 610 on the GRT36B record is a copy of GRT24B's number.

### SAP contradicts itself, and only one half is reliable

00282's entire dimension block was copied from 00234 - including the `Model Number`
field, which is why it reads `GRT24B` while its own `Item Description` reads `GRT36B`.
**Its Item Remark escaped the copy** and is the one internally consistent field:

| | IMG/BUF/00234 | IMG/BUF/00282 |
|---|---|---|
| SAP Model Number | `GRT24B` | `GRT24B` **(wrong)** |
| SAP Item Description | `...GRT24B` | `...**GRT36B**` |
| SAP W / D / H | 610 / 750 / 402 | 610 / 750 / 402 **(copied)** |
| SAP Remark size | `61X75X40.2cm` | `**D750 x W915 x H(400-450)MM**` |
| SAP Remark surface | `Cooking Surface: 24 inch` | `Cooking Surface: 36 inch` |

`W610` = 24 inch (610 mm) and `W915` = 36 inch (914 mm), both to the millimetre.

### The manufacturer agrees

- https://www.sulteer.com/productinfo/1135662.html - "24inch GRIDDLE GRT24B"
- https://www.sulteer.com/productinfo/1135663.html - "36inch GEIDDLE GRT36B" *(Sulte's
  own typo for GRIDDLE, visible on their live page)*

The 24 inch page also publishes `Temperature range:60-250C` (matching SAP) and
`Timer: 0~23 hours 59 minutes` (which SAP does not carry - worth adding).

### The photographs agree

Both official renders are the same camera angle on the same cabinet family and contain
the **same red rocker switch**, usable as an in-frame ruler. Measured on the native
4901 x 4901 files: the switch is 133 px wide on GRT24B and 97 px on GRT36B, while the
body silhouettes are 3914 px and 3696 px. In switch units the 36 inch body is **1.30x**
wider. Solving the three-quarter projection for a shared 750 mm depth gives a GRT36B
width of **~890 mm** against GRT24B's 610 mm - within 3% of 915 mm, and nowhere near
the 610 the record stores. Had both been 610 mm the ratio would have been 1.00.

### Power - confirmed suspect

GRT24B's render shows **one** control panel. GRT36B's shows **two** independent control
panels, i.e. twin-zone construction. Both records are named "Induction Griddle 6KW", and
SAP's remark carries 6 kW for both - but SAP is not independent of our record here. A
twin-zone 36 inch griddle drawing the same total power as a single-zone 24 inch one is
not credible. Re-source the GRT36B power figure from the supplier before that record is
ever un-archived. (00282 is currently `archived`, price 0, so nothing is customer-facing.)

### What this means for the records

- **00234 (published)**: stored 750 / 610 / 405 is correct on width and depth. SAP's
  remark says 402 where we say 405 - a 3 mm difference, not worth touching.
- **00282 (archived)**: stored width 610 is wrong (should be ~915), and the height is a
  range (400-450 mm) rather than the single 402 both records carry.
- **No `model_number` change is needed.** SAP's `Model Number` field is the wrong one on
  this row; our record already carries `GRT36B`, which its own description, its own
  remark and the manufacturer all confirm.

---

## 5. The two microwaves - IMG/HOT/00402 and IMG/HOT/00403

### 5.1 Sulte does not make microwaves

Sulte's public catalogue is 18 products across 7 categories - Induction Fryer, Flat
Induction Cooktop, Wok Induction Cooktop, Built-In Induction Hob, Multi Burner,
Induction Griddle, Spare Parts. Zero microwaves. Sulte's own company-profile board
(recovered at 2482 x 3308 from their CDN) calls the firm a "leader in the commercial
**induction cooking** industry" with a "specialized **electromagnetic** manufacturing
division". Their safety certification is scoped to IEC 60335-2-36 (cooking ranges, ovens,
hobs) and enumerates 38 induction models; microwave ovens are IEC 60335-2-25 and are
absent.

### 5.2 The platform is Midea

**Guangdong Midea Kitchen Appliances Manufacturing Co., Ltd**, No.6 Yong An Road,
Beijiao, Shunde, Foshan 528311, China.

- Midea-branded manual for the closely related `EM025FJT-S0SA00`, headed COMMERCIAL
  MICROWAVE OVEN: https://manuals.plus/midea/em025fjt-microwave-oven-manual and
  https://www.manualslib.com/manual/3557947/Midea-Em025fjt-S0sa00.html
- Midea sells the 25 L unit as its own commercial product:
  https://fulltechse.com.hk/en/product/midea-commercial-microwave-oven1000w-high-power/
- Registered FCC filer at that address:
  https://fcc.report/company/Guangdong-Midea-Kitchen-Appliances-Manufacturing-Co-Ltd
- The strongest artefact is an FCC **label exhibit** titled, in Chinese, *"Guangdong
  Midea Kitchen Appliances Manufacturing Co.,Ltd 16070000B07548 **美的版铭牌**
  EM025FJT-S0SA00 160X80mm"*. `美的版铭牌` = "**Midea-version nameplate**". A factory
  only labels a nameplate "the Midea version" when it prints other versions of the same
  nameplate for the same model - which is precisely the OEM-platform claim.
  https://device.report/m/d4ee8d2c77a75a5040cddc8123448b4cbad96d869d7293076b25855cd857d9a9
  **Caveat: this URL is behind a Cloudflare interstitial. Only the indexed title was
  obtainable, not the document body.** Strong but second-hand.

### 5.3 The badge is per-distributor, and ours matches ENIGMA

| Badge | Market | Code used | Source |
|---|---|---|---|
| Midea | China / export | `EM025FJT` | https://manuals.plus/midea/em025fjt-microwave-oven-manual |
| EASYLINE (by Fimar) | Italy / EU | `EM025FJT`, `EMA34GTQ` | https://easylinebyfimar.it/en/prodotto/microwave-ema34gtq/ and https://easylinebyfimar.it/prodotto/forno-microonde-emo25fjt/ |
| SOLWAVE | USA | `EM025FJT-S0SA00`, `EMA34GTQ-S00L00` | https://www.webstaurantstore.com/solwave-1000w-stackable-commercial-microwave-with-push-button-controls-120v/180MW1000SS.html |
| **ENIGMA** | Russia | **`EM025FJT-S0SF00`, `EMA34GTQ-S00E00`** | https://www.refro.ru/product/mikrovolnovaya-pech-enigma-em025fjt-s0sf00/ and https://entero.ru/item/294098 |
| Infrico | Spain | `HM1802P / EMA34GTQ` | https://spareparts.infrico.com/library/15.%20MICROWAVE/NEW%20EQUIPMENT%202022/HM1802P/USER%20MANUAL/HM1802P.pdf |

**This is the correction to the old pass.** Our full factory codes, suffix and all -
`EM025FJTS0SF00` and `EMA34GTQS00E00` - resolve to the **ENIGMA** badge, not EASYLINE.
Fimar quotes only the unsuffixed base codes; Solwave uses `-S0SA00` / `-S00L00`. The
suffix encodes the market/control/nameplate build, and ours is the 230V 50Hz digital
build that Enigma sells.

Two exact-code user manuals were recovered as a result, and they are the only documents
found anywhere carrying our complete suffix:

- 19-page manual for `EM025FJT-S0SF00`:
  https://www.refro.ru/upload/iblock/d91/v1xglrc98an36c2x4ykms37mqh0oasml.pdf
- 22-page manual for `EMA34GTQ-S00E00`:
  https://www.refro.ru/upload/iblock/01a/yllu51215184pb0g9jg1v4duvkm391zj.pdf

Both are entirely unbranded inside - white-label documentation, itself consistent with an
OEM platform.

### 5.4 Data bugs found

**(a) IMG/HOT/00403's stored dimensions are the shipping carton.** Our record 650 / 610 /
480 is SAP's own `G.W.: 38.3KG 65X61X48 cm`. The same remark separately gives the
appliance as `57.4X52.8X36.8cm`. Corroborated three ways: Fimar 574x528x367, Solwave
22 5/8 x 20 5/8 x 14 1/2 in = 575x524x368, and the exact-code Enigma manual 574x528x368.

**(b) IMG/HOT/00402's length and width are transposed.** Our record reads 511 mm deep and
432 mm wide. Every source has it the other way: **510-511 mm wide**, 432-440 mm deep.
Fimar 510x440x310; Enigma manual 511x364x311 (a body depth excluding the handle);
Solwave 20 x 18.5 in = 508 x 470. SAP's own fields for this row (540/620/410) are the
carton again, matching its remark's `62X54X41 cm`.

**(c) A correction in our favour - do not "fix" 00403's power.** The old pass flagged our
3000W input as 7% above Fimar's 2.8 kW. The exact-code Enigma manual for
`EMA34GTQ-S00E00` states **input 3000W / output 1800W**. Our figure is right; Fimar's
2.8 kW is the outlier.

**(d) Missing entirely on both:** the internal cavity size. 25 L = 327 x 346 x 200 mm,
34 L = 360 x 409 x 225 mm (Fimar official datasheets, and the multilingual catalogue page
staged at 1833 x 1833).

### 5.5 What this does and does not settle

The platform is Midea with high confidence, and Sulte-as-manufacturer is effectively
ruled out. What the **correct brand string** should be is not settled: EASYLINE is the
legacy-site precedent and a real badge for this hardware, but our suffixed codes point at
the ENIGMA build, and the badge actually screen-printed on the units in the warehouse can
only be settled by looking at one. **Reported as evidence; no change proposed.**

---

## 6. Remaining conflicts, per SKU

- **IMG/BUF/00227 - 3 kW or 3.5 kW?** SAP says `DROP IN 3KW` and `3000W`. Sulte's own
  page for the same code is titled `3500W SL-30C-XP3`. Direct manufacturer-vs-SAP
  conflict. Not resolvable photographically.
  https://www.sulteer.com/productinfo/1135624.html
- **IMG/BUF/00228 - SAP's own numbers are broken on this row.** SAP W/D/H = 285 / 484 /
  40 against a remark of `48.4x40x24.5cm`. The 285 is a glass-plate figure leaking from
  the 00226 row and the 40 is `x40x` misread as millimetres. Our stored 484 / 400 / 245
  follows the remark correctly. Treat SAP's W and H here as junk.
- **IMG/BUF/00229 - a 40 mm width gap remains open.** The exact-code Alibaba listing
  quoted `53*40*26 cm` against our 52.5 / 44.0 / 26.5. That listing is no longer
  reachable (§8).
- **IMG/BUF/00232 - SAP's W/D/H are 00231's.** Both rows read 450 / 700 / 130; 00232's
  own remark says `D760 X W700 XH260mm`, which our record follows. Four 300 x 300 zones
  cannot fit in 450 x 700 but fit comfortably in 760 x 700. Our figure is right, SAP's
  field is contaminated, and the old pass's Azerbaijani-listing conflict is explained -
  that reseller had copied a two-zone unit's dimensions.
- **IMG/BUF/00233 - zero corroboration, still.** No source anywhere for `SL-FR1C23A`.
  Sulte publishes exactly two fryer pages: an 8 L (`SL-FRT1CO8B` - its page carries no
  image at all) and an 8 L + 8 L twin-tank. The only Sulte fryer photograph in existence
  is the twin-tank, and it **contradicts the capacity in our own product name**. Staged
  as CODEMISMATCH; do not publish it. The spec is internally coherent (23 L, 8 kW on
  415V three-phase, 30-210 C, 950 mm tall) but rests on SAP alone.
- **IMG/BUF/00227 remark oddity** and **IMG/BUF/00230's single-vs-double glass plate**
  are noted in `_FINDINGS.md`.

---

## 7. Where this file reverses the old research

1. **The 00226 "CONTRADICTS" photo was not a foreign machine.** Perceptual hashing
   (16x16 ahash, then per-pixel RMS on 256x256 greyscale) matches the old pass's staged
   2560 px file to Sulte's own CDN asset `8566905` at **RMS = 0.016** - the same
   photograph, at 9450 x 9450. It is genuine Sulte studio photography of a model Sulte
   does not publish a page for. The operative conclusion is unchanged (do not use it for
   00226, because its `Lock` / `Function` control board is not SL-G35-TP3's), but "a
   different machine that isn't Sulte's" was the wrong framing. It is now filed in
   `_brand-reference/`.
2. **00230's 800 x 355 is not anomalous.** The old §6.4 said it "matches nothing Sulte
   publishes" and left it unresolved. It matches nothing Sulte *photographs* - Sulte
   publishes no KPP page at all - but it is a coherent side-by-side footprint that SAP
   independently agrees with. The defect is the name, not the number (§3).
3. **00403's 3000W input is correct.** The old §2.3 recommended correcting it to 2800W on
   Fimar's authority. The exact-code manufacturer manual says 3000W (§5.4c).
4. **The microwave badge is not settled as EASYLINE.** The old §6.5 treated EASYLINE as
   proven from the base code. Our suffixed codes are ENIGMA's (§5.3).

---

## 8. Tooling notes worth keeping

- **`sulteer.com` / any `hkwezhan.cn` / `website.xin` factory CMS:** the 952-byte stub
  carries a `<script src=...Body.js>` whose bundle contains the whole server-rendered
  page. Fetch it, unescape `<` / `>` / `\/`, and parse normally.
- **Then enumerate the image CDN ids either side of the ones the pages link to.** On
  `https://img.website.xin/contents/sitefiles3607/18039808/images/<id>.jpg` a scan of
  8566700-8567900 turned up **15 full-resolution renders that no product page links to** -
  the rest of Sulte's range plus the company-profile boards. This step is new and it is
  where most of the extra material came from.
- **Each sulteer product page carries exactly one product image.** The other two are site
  chrome (`8567737.png` logo, `8567806.jpg` footer). Filter those.
- **Sulte's ceilings**: 9450 x 9450 on cooker renders, 4901 x 4901 on the griddles.
- **webstaurantstore CDN**: swap `/images/products/large/` for `/images/products/xxl/` -
  `large` caps at 600 px, `xxl` returns 2000 x 2000.
- **easylinebyfimar.it**: `wp-json/wp/v2/media?per_page=100&search=<code>` lists assets;
  800 x 800 is the genuine ceiling (`-scaled`, `-1536x1536`, `-2048x2048` all 404).
- **Alibaba is closed.** Every `alibaba.com` product URL returns a 90 KB JS shell to a
  plain fetch (Googlebot UA included) and a slide-to-verify CAPTCHA in a real browser.
  **Not bypassed.** This is why 00228 and 00229 are stuck below 800 px.
- **`applianceregistrationdatabase.org.za`** is a genuinely useful source for Chinese
  kitchen-equipment makers - full IEC/CB test reports with model tables. Its site search
  indexes nothing, so PDFs are reachable only by direct file URL.
- **ahash false-positives badly on same-object-on-white ranges.** On this brand a
  Hamming <= 40 shortlist gave 22 candidate pairs of which only 2 were real. Useful
  threshold: **RMS < 0.05 = same photograph; 0.20-0.35 = different model, same framing.**

---

## 9. Product reference

| SKU | Model | Image | px | Code proven | Zones verified |
|---|---|---|---|---|---|
| IMG/BUF/00226 | `SL-G35-TP3` | manufacturer render | 9449x9450 | **yes** | 1 |
| IMG/BUF/00227 | `SL-30C -XP3` | manufacturer render + 2 real photos | 9450x9449 | **yes** | 1 (drop-in) |
| IMG/BUF/00228 | `SL-G50-KP9` | SULTE-badged hero | 750x750 (UNDERFLOOR) | no | 1 |
| IMG/BUF/00229 | `SL-G50-KA12` | SULTE-badged wok hero | 871x750 (UNDERFLOOR) | no | 1 wok well |
| IMG/BUF/00230 | `SL-C351-KPP3-Y` | sibling `2E3-Y` + CB report | 9450x9450 | no (image) / **yes** (doc) | 2 |
| IMG/BUF/00231 | `SL-C351-KPP2` | siblings `2E3-Y`, `2M1-Y` + CB report | 9450x9450 | no (image) / **yes** (doc) | 2 tandem |
| IMG/BUF/00232 | `SL-C351-4S13-Y` | siblings `4E3-Y`, `4E1-Y` + CB report | 9449x9450 | no (image) / **yes** (doc) | 4, 2x2 |
| IMG/BUF/00233 | `SL-FR1C23A` | 8L+8L twin-tank - **wrong capacity** | 2749x2749 | no | 2 tanks (should be 1) |
| IMG/BUF/00234 | `GRT24B` | manufacturer render | 4901x4901 | **yes** | 1 panel |
| IMG/BUF/00282 | `GRT36B` | manufacturer render | 4901x4901 | **yes** | **2 panels** |
| IMG/HOT/00402 | `EM025FJTS0SF00` | Easyline official + 3 Solwave + 4 docs | 800x800 / 2000x2000 | no | n/a |
| IMG/HOT/00403 | `EMA34GTQS00E00` | Easyline official + 3 Solwave + 4 docs | 800x800 / 2000x2000 | no | n/a |

## 10. `brands.json`

`website_url` is still `null`. Sulte's own site is now proven readable and is the
richest image source in the brand, so **https://www.sulteer.com/** is the better value
than the Alibaba storefront the old pass recommended - Alibaba now serves a CAPTCHA and
carries no extractable content at all. Not applied.
