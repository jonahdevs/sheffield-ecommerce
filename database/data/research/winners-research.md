# WINNERS - product research (SAP-led pass)

**This file supersedes `database/data/research/old/winners-research.md`.** That file predates the
SAP export. Its §1 ("Winners is an unfindable house label") is wrong, its §5.3 was already
self-corrected, and several of its §8 conclusions are overturned below - most importantly its
finding that D7016T "may not be a lamp at all". Where the old file and this one disagree, this
one wins; where the old file made a claim I could not re-verify, I say so.

Covers all **18 WINNERS SKUs** (Buffet & Servery). Nothing in `products.json`, `brands.json` or any
other repo data file was changed - research only. Images staged in
`Desktop\ecommerce\products resorce final\winners\`.

---

## 1. Sources used

Manufacturer (identity now proven, not inferred):

- https://gdwinners.en.alibaba.com/
- https://www.alibaba.com/product-detail/new-stainless-steel-electric-chaffing-dishes_1601159713898.html
- https://www.alibaba.com/product-detail/WINNERS-Rose-Gold-Food-Heating-Lamp_1601386662613.html
- https://www.alibaba.com/product-detail/WINNERS-Elegant-Retractable-Food-Lamp-Warmer_1601387741454.html
- https://www.alibaba.com/product-detail/WINNERS-Stainless-Steel-Rose-Gold-Buffet_1601451571107.html
- https://www.alibaba.com/product-detail/WINNERS-Commercial-Food-Heat-Lamp-Electric_1601379547131.html
- https://www.alibaba.com/product-detail/WINNERS-S-s-304-Hydraulic-Chafer_1601471482029.html
- https://www.alibaba.com/product-detail/WINNERS-9l-Automatic-Induction-Buffet-Stove_1601380309092.html
- https://www.alibaba.com/product-detail/Chafing-Dish-Buffet-Set-Stainless-Steel_1600911240610.html
- https://www.alibaba.com/product-detail/WINNERS-Wedding-Catering-Sensor-Induction-Automatic_1601609907852.html

Authorised export reseller republishing Winners' own factory photography:

- https://www.truercatering.com/products/electric-chafing-dish-buffet-eg2016x/
- https://www.truercatering.com/products/hotel-electric-chafing-dish-eg2017x/
- https://www.truercatering.com/products/chafer-dish-wholesale-ec2016/
- https://www.truercatering.com/products/hydraulic-chafing-dish-for-hotel-6016h/
- https://www.truercatering.com/products/elegant-food-warmer-for-hotel-6018h/
- https://www.truercatering.com/products/chaffing-dish-catering-equipment-qr016/
- https://www.truercatering.com/products/catering-food-display-warmer-lamps/
- https://www.truercatering.com/products/food-warmer-lamp-zt001-003/
- https://www.truercatering.com/products/luxury-buffet-heat-lamp-d001-011/
- https://www.truercatering.com/products/buffet-heat-lamps-dl201-203/
- https://www.truercatering.com/products/large-built-in-food-warmer-tray/
- https://www.truercatering.com/products/round-chafing-dish-2018h/
- https://www.truercatering.com/products/buffet-set-chafing-dish-7016t/

Nothing was taken from sheffieldafrica.com.

### 1.1 WINNERS is Guangdong Winners Stainless Steel Industry Co., Ltd. - now proven, not inferred

Chaozhou, Guangdong. 11 years on Alibaba as a verified custom manufacturer; its Alibaba storefront
lists **Kenya among its five main export markets**, which is consistent with Sheffield buying direct.
Its Alibaba listings carry `brand name: WINNERS` in the Key-attributes table, and its own model
grammar (EG20xxX, EC20xx, 60xxH/Q, 80xxM, D0xx, DL1xx, ZT00x, 301/302/303) is exactly the grammar
in our catalogue. The old file's §1 read that grammar spread as evidence of a *purchasing bucket*;
it is in fact one factory's sub-series naming.

Two independent images staged in this pass carry the manufacturer's **伟纳斯 WINNERS®** logo
watermark burned into the frame:

- `IMG-BUF-00258__QR016-truer-6.jpg` (on truercatering.com - i.e. Truer is reselling Winners' photos)
- `IMG-BUF-00269__D002-alibaba-winners-d001-011-1.jpg` and
  `IMG-BUF-00272__ZT001-alibaba-winners-1.jpg` (on Winners' own Alibaba listings)

**Truer Catering is a rebrand, not the maker.** Every Truer page states `Brand Name: Truer Catering`
while displaying photography that Winners publishes under its own watermark. Truer is still a
legitimate corroborating source - it exposes per-model dimensions and wattages that Alibaba hides -
but its brand field must not be believed, and it is *not* an independent second opinion: it is the
same photo library.

---

## 2. The single biggest defect: SAP's dimension columns are a constant for this whole make

Every one of the 18 WINNERS rows in the SAP export carries **L/W/H = 560 / 440 / 180**. Identical for
a 6 L round chafer, a 1500 mm built-in warmer board and a ceiling-hung pendant lamp. It is not a
measurement of anything; it is one value carried down the whole make.

Worse, an earlier step of this same enrichment effort **bulk-applied that constant into
`products.json`** for the 12 WINNERS SKUs whose dimensions were previously `null` (it is recorded in
`sap_dim_patch.json` with `"was": {length: null, width: null, height: null}`). Those 12 SKUs now
publish 560 x 440 x 180 mm as product dimensions on the storefront:

`IMG/BUF/00253, 00254, 00256, 00257, 00258, 00259, 00266, 00269, 00270, 00271, 00272, 00274`

**Recommendation: revert all 12 to null.** No manufacturer figure anywhere supports 560/440/180 for
any WINNERS product. This is the highest-value fix in the brand and needs no further sourcing.

### 2.1 The dimensions that *do* appear in SAP remarks are carton sizes, not product sizes

Where a SAP remark quotes a "Dimensions" line, it matches the manufacturer's **single package size**,
not the product:

| SKU | SAP remark "Dimensions" | Manufacturer packing size | Manufacturer product size |
|---|---|---|---|
| IMG/BUF/00252 EG2016X | 590 x 480 x 300 mm | 59 x 48 x 27 cm (Truer) | not published |
| IMG/BUF/00253 EG2017X | 480 x 410 x 300 mm | 48 x 41 x 28 cm (Truer) | not published |
| IMG/BUF/00267 EMBEDDED-1200 | carton `135*54*21cm`, unit `121*46*6.5cm` | - | 1200 x 450 mm plate |

`IMG/BUF/00252` is the one SKU whose stored dimensions were *not* overwritten by the constant - and
its stored 590 x 480 x 300 is the carton. So the two dimension figures currently in the WINNERS set
are "a constant that means nothing" and "a shipping carton". Treat the whole dimension field for this
brand as unusable until re-sourced.

---

## 3. Per-SKU findings

Verification standard: a find counts as verified only where the exact model code appears in the
product URL, the page `<h1>`/`No.` line, or the Key-attributes table - **and** I opened the staged
image and looked at it. HTTP 200 was never treated as verification.

### IMG/BUF/00252 - EG2016X (1 image)
Exact code in URL, page title, `NO.EG2016X` heading and Key-attributes. Photo: **rectangular**
twin-pan electric chafer with a **rose gold** frame and digital touch panel.
- Capacity 9 L - **agrees with SAP.**
- Shape: SAP/our record say nothing; the old file guessed "implicitly round" - it is rectangular.
- **Disagreement with SAP wording:** SAP calls it "GOLDEN FRAME". Both Winners and Truer call the
  finish **Rose Gold**, and the photo is unambiguously rose gold/copper. "Golden frame" is wrong.
- **Wattage conflict between the two sources:** Truer's EG2016X page states **500 W**; Winners' own
  Alibaba listing for the whole EG series states **800 W**. Unresolved - do not publish either
  without asking the supplier.
- Truer's body copy on this page calls it a "Square Chafing Dish" - a Truer-side copy error, the
  photo and the 590 x 480 footprint are both rectangular. Ignore it.

### IMG/BUF/00253 - EG2017X (1 image)
Exact code in URL, `NO.EG2017X` heading and Key-attributes. Photo: **square**, single 1/1 GN pan,
rose gold frame. Truer states **Capacity 6 Liters**, packing 48 x 41 x 28 cm.
- **SAP is right and `products.json` is wrong.** SAP's description reads "...SQUARE **6L**"; our
  product *name* reads "Electric Chafing Dish Golden Frame Square **9L**". The manufacturer says 6 L.
  The 9 L looks inherited from its EG2016X sibling. (The old file reported this as
  "stored 9 L vs manufacturer 6 L" without noticing that SAP itself already says 6 L.)
- Same 500 W / 800 W conflict as above.

### IMG/BUF/00254 - EC2016 (7 images)
Exact code in URL, `NO.EC2016` heading and Key-attributes. Hammered ("hammer point") 304 stainless
electric chafer with hydraulic damping lid, touch panel and remote.
- Truer's EC2016 page is a **family page** covering five bodies, with per-shape sizes:
  Rectangle 57.5 x 43 x 24.5 cm; Square 39.5 x 42.5 x 24.5; Round 43 x 48.5 x 24.5;
  Small rectangle 32 x 44.5 x 25; Soup stove 44.5 x 41.5 x 34.5. Capacity "11 L / 9 L / 6 L".
  Power **500 W**, 220-240 V. Packing 60 x 45 x 49 cm.
- The seven staged images are the whole family, not seven views of one unit: images 1, 2, 3, 5, 6 are
  rectangular bodies, image 4 is the round body, image 7 is the round soup stove. Kept together
  because the page is the SKU's match, but only the rectangular ones are EC2016 itself.
- **Dimension disagreement:** SAP remark 570 x 475 x 250 mm vs Truer's rectangle 575 x 430 x 245 mm.
  Length and height agree within 5 mm; the **width is 45 mm apart** (475 vs 430). Given the known
  catalogue-wide width/depth confusion, the SAP 475 is the figure I would distrust.
- **Remote control confirmed, not templated copy:** a physical handset is visible in
  `IMG-BUF-00254__EC2016-truer-2.jpg`, and both Truer and Winners list remote control in text.

### IMG/BUF/00255 - EC2018 (1 image, code NOT confirmed)
**No source anywhere states "EC2018".** Not on truercatering.com (all 225 product pages fetched and
full-text searched), not in Winners' 224-listing Alibaba catalogue, no web hit.
- Strong structural inference, but inference only: Winners' own Alibaba listing enumerates the
  sibling EG family as **EG2015X / EG2016X / EG2017X / EG2018X / EG2019X** mapped to
  *small rectangular / rectangular / square / round / soup pot*. On that mapping `...18` = **round**,
  which is exactly what SAP says for EC2018 ("6 LITRES ROUND"). So EC2018 = round 6 L hammered chafer
  is very likely right - but it is not proven.
- The staged image is the round body from the EC2016 family page. Its filename carries
  `UNCONFIRMEDCODE` on purpose. **Do not treat it as a verified EC2018 photo.** The old research
  staged this same shot as a plain "EC2018" photo on a shape match; that overstated it.
- **Dimension disagreement:** SAP 510 x 430 x 250 mm vs Truer's round body 430 x 485 x 245 mm. Height
  agrees; the two footprint numbers do not line up on either axis order.

### IMG/BUF/00256 - 6016H (5 images)
Page title and `No.` line read "Hydraulic Chafing Dish for Hotel **6016H**" with the sub-line
**6016H/6017H/6018H/6019H**.
- **Caution - the source contradicts itself:** the same page's Key-attributes table says
  `Model Number: 6016M/6017M/6018M/6019M`. Winners' own Alibaba catalogue proves H, Q and M are three
  *different* sub-series (there is a separate `6016Q/6017Q/6018Q` hydraulic chafer listing and a
  separate `8016M/8017M/8018M` induction buffet stove listing). So Truer's spec table is wrong on
  this page. I accepted the page because the exact code is in the URL, title and H1; the images are
  the H-series family shot (large rectangular, small rectangular, round, square, plain polished).
- Unresolved: SAP's remark gives the same 620 x 405 x 240 mm for both "Chafing Dish Stove Size" and
  "Chafing Dish Stand Size". No manufacturer figure was found for either, so the old file's
  duplicate-field flag stands, unresolved.

### IMG/BUF/00257 - 6018H (4 images)
Exact code in URL, `No. 6018H` heading **and** Key-attributes (`Model Number: 6018H`) - the cleanest
match in the set.
- **Finish disagreement with our record:** the manufacturer's 6018H is a **round, gloss-white-coated**
  body with gold legs and gold handles. Our record ("Chafing Dish with Fuel Holder 6018H") states no
  colour and no shape. Worth confirming which finish Sheffield actually purchased before publishing.
- **This resolves the old file's "the litres may be transposed" worry.** 6018H is the round/smaller
  body and 6016H the rectangular/larger one, matching SAP's 6 L / 9 L assignment. No transposition.
- Truer describes the heat source as a "heat pad", consistent with SAP's non-electric fuel holder.

### IMG/BUF/00258 - QR016 (6 images)
Exact code in URL, title and Key-attributes (`Model Number: QR016`). Drop-in / built-in electric
chafer, twin GN pans, side-mounted touch panel with digital display, and a **perforated dry-heat
plate** visible in image 4 - which independently corroborates SAP's "wet and dry" claim (water pan
plus dry plate). Image 6 carries the 伟纳斯 WINNERS® watermark.
- Still no dimensions and no wattage from any source. The old file's "emptiest record in the set"
  verdict stands for the numeric fields, but the product itself is now well documented visually.

### IMG/BUF/00259 - D7016T (4 images) - old research overturned
Winners/Truer page "Catering Food Display Warmer Lamps", Key-attributes
`Model Number: D7016T/D7017T/D7018T/D7019T`.
- **It is a warmer lamp.** SAP's "WARMER LAMP D7016T" is correct. The old file (§8.5) concluded
  D7016T was unsourceable, that Truer only had a `7016T` chafing dish, and that our SKU might be a
  chafer mislabelled as a lamp. That is wrong - `D7016T` exists as its own product: a gooseneck arm
  carrying a polished dome lamp over a ceramic-plate warming base, in three body shapes (round deep
  pot, rectangular tray, round shallow tray).
- Truer's Key-attributes calls the `Product name` "Chafing Dish Buffet Set" - a Truer-side copy
  error, contradicted by its own page title and by the photographs.
- Which of D7016T/17T/18T/19T is which shape is **not stated**; the four codes are sold as one page.
- The old file's "205 mm overall height paradox" is best explained as a carton figure: SAP's
  `80.5*45.5*20.5cm` is a flat-packed box, not a standing height. Not proven, but the geometry of the
  photographed product (a ~60-80 cm tall gooseneck) rules out a 205 mm overall height outright.

### IMG/BUF/00260 and IMG/BUF/00261 - 3602 (no images - dead end, see §5)
Independent of sourcing, two defects are provable from our own data:
- Both records carry `model_number: 3602`, violating the unique-ID rule.
- Both describe the same 36 cm diameter, but 00260 stores `length: 360` (mm) and 00261 stores
  `length: 36` (cm). One of the two is wrong whatever else is decided.

### IMG/BUF/00266 / 00267 / 00268 - EMBEDDED-900 / -1200 / -1500 (5 images each, family shot)
Product type confirmed: a **drop-in tempered-glass warming board** with a stainless surround, touch
control and remote, sold in multiple lengths. Truer sells it as `BWB-QRSK`; Winners lists it on
Alibaba as "WINNERS Various Sizes **Embedded** Stainless Steel..." (see §5 - I could not open that
listing).
- **`EMBEDDED-900/-1200/-1500` is a Sheffield house code, not a manufacturer part number.** No
  supplier stamps "EMBEDDED" on anything. That one conclusion of the old file survives.
- The staged image set is the correct product from the correct maker but **cannot distinguish
  900 from 1200 from 1500 mm**. Filenames for 00267/00268 say `familyimage` for that reason.
- **SAP contradicts our stored wattage.** Our three records all carry 220 V / **900 W**. SAP's own
  remark on EMBEDDED-1200 reads `220V/1350W, 121*46*6.5cm ... Dim. 1200 x 450`. So even inside our
  own data the 1200 mm unit is 1350 W, not 900 W. The shared 900 W across all three sizes remains
  unverified and is now positively contradicted for one of them.

### IMG/BUF/00269 / 00270 / 00271 - D002 / D005 / D011 (11 images each)
Winners' own Alibaba listing "Elegant Retractable Food Lamp Warmer", Key-attributes
`model number: D001-D011`, `brand name: WINNERS`, 110/220 V.
- **These are ceiling-suspended retractable pendant lamps**, not free-standing lamps: a spiral cord
  that stretches roughly **60-250 cm**, a 14 cm x 10 cm ceiling canopy, one-key gear switch, standard
  bulb holder. Our records describe them only as "Rose Gold Heat Lamp" with no mounting type.
- Truer's D001-011 page carries **two labelled factory size charts** (staged as `...truer-4.jpg` and
  `...truer-5.jpg`) giving shade width x height in cm for the whole family:

  | D001 | D002 | D003 | D004 | D005 | D006 | D007 | D008 | D009 | D010 | D011 |
  |---|---|---|---|---|---|---|---|---|---|---|
  | 19x17 | **17x17** | 25x28 | 30x16 | **29x28** | 24x30 | 20x40 | 28x30 | 20x16 | 20x16 | **20x16** |

- **All three of our records are wrong.** They store an identical `355 x 355 x 440 mm`, identical
  150 W, identical price and identical quantity. The manufacturer's own charts prove D002, D005 and
  D011 are three physically different lamps with three different shade profiles, and **none of the
  three is 355 mm**. This is the highest-value per-SKU data fix in the brand.
- On the old file: its D002/D005/D011 chart figures were correct, and its staging the *same* chart
  file for both D005 and D011 was legitimate (both models appear on chart 1). I re-derived all
  eleven figures from the charts myself rather than trusting it.
- Wattage: no per-model figure is published for the D series anywhere. The stored 150 W stays
  unverified. (The sibling DL series is 270 W - see below - which makes 150 W look low but proves
  nothing.)

### IMG/BUF/00272 - ZT001 (12 images)
Two independent exact-code sources.
- Winners' own Alibaba listing "Rose Gold Food Heating Lamp": `model number ZT001/ZT002/ZT003`,
  `brand name Winners`, 220-240 V, **Power 450 W, 275 W**.
- Truer's ZT001-003 page: `Model Number ZT001-003`, **Power 670 W**, 220 V/50 Hz, rose gold hammered
  surface, microcrystalline insulation panel, two-way heating, touch screen + remote.
- **Shape confirmed:** `IMG-BUF-00272__ZT001-truer-4.jpg` is a labelled range chart showing Z001/Z002/
  Z003 (tray only) and ZT001/ZT002/ZT003 (tray + gooseneck lamp), with **ZT001 the rectangular one**.
  SAP's "WARMER LAMP RECTANGLE ZT001" is correct. Winners' own listing likewise offers
  "Round type / Square type / Rectangle type".
- **Three-way wattage disagreement:** SAP says lamp 270 W + tray 400 W (= 670 W); Truer says 670 W
  total, agreeing with SAP; Winners' own Alibaba says 450 W and 275 W (= 725 W). Two of three agree
  on 670 W, so 670 W is the better bet, but the manufacturer's own page is the outlier - flag rather
  than publish.
- The old file called ZT001's spec block a copy-paste of DL206's. The *model name* in that block is
  indeed wrong, but the **numbers are right for ZT001** - Truer independently gives the same 670 W.

### IMG/BUF/00274 - DL206 (5 images, reference only)
**No source anywhere states "DL206".** Winners' Alibaba carries `DL101/DL102/DL103/DL104` (270 W
infrared "FOOD WARMER LAMP") and `DL108/DL109/DL110`. Truer carries DL101, DL108 and DL201/202/203.
No DL204/205/206 on either.
- The DL family being **270 W infrared** does corroborate SAP's "Lamp: 270 W" for DL206.
- The five staged images are Truer's DL201-203, which is **round on an arched frame**; our DL206 is
  explicitly "Rectangle". They are filed with `REFONLY` in the filename and are **not** this SKU's
  photograph. They are kept only because they corroborate the unusual dual-element design
  (lamp + heated plate with digital display) that SAP describes.

---

## 4. Spec sheets: none exist on any reachable source

Zero. `truercatering.com` has no PDF anywhere - every product page, the `/catalog/` page and the
homepage were scanned for `.pdf` hrefs and returned nothing. Winners' Alibaba listings carry no
downloadable datasheet; their "specification" is the Key-attributes table, which I transcribed above.
**0 spec sheets staged.** Do not spend another pass looking for a Winners PDF on these two domains.

---

## 5. Dead ends - do not retry these

1. **`3602` (both hot pots, IMG/BUF/00260 and 00261).** Not in truercatering.com's 225 products, not
   in Winners' 224-listing Alibaba catalogue, no web hit. Truer/Winners hot-pot codes are
   diameter-pair four-digit codes (`1516` = "15cm-16cm", also `0616`, `0816`, `0920`, `1219`, `1328`,
   `1418`) - `3602` does not fit that grammar at all, so it is probably not a Winners hot-pot code.
   **No image staged for either SKU on purpose**, since the two differ only by finish and attaching an
   unverified photo to either would be exactly the mix-up worth avoiding.
2. **`EC2018` and `DL206`** - searched by exact code on the web, across the full Truer catalogue and
   across the full Winners Alibaba catalogue. Neither string exists on either. See the per-SKU notes
   for what can be inferred instead.
3. **`https://www.made-in-china.com/showroom/guangdongwinners/`** - fetches 200 but is a generic
   "related products" page (water bottles, soup kettles from unrelated suppliers). Not Winners'
   catalogue. The old file's citation of it as a Winners showroom is misleading.
4. **`https://gdwinners.goldsupplier.com/`** - its sitemap has only five category pages, all water
   urns / insulation barrels / thermal pots. No chafing dishes, no lamps.
5. **`https://lite.duckduckgo.com/lite/?q=`** - the trick the old file relied on now returns
   **HTTP 202 with an empty search shell** to a GET. It would need a POST.
6. **`https://www.truercatering.com/product-sitemap.xml`** - **403** to any User-Agent. Use the WP
   REST API instead (see §6).
7. **Most Alibaba `product-detail` pages render client-side.** Of the 224 Winners listings, only
   ~17 returned a server-rendered Key-attributes table; the rest return an ~90 KB empty shell, and
   after ~180 requests the whole domain throttles. `m.alibaba.com`, `gdwinners.m.en.alibaba.com`,
   `/pdp/{id}.html` and the `WebFetch` tool all return the same empty shell. **A real browser session
   is the only way to open the rest** - see §7 for the three listings worth opening.

---

## 6. Tooling notes worth keeping

- **truercatering.com blocks its sitemap but leaves its WordPress REST API open.**
  `https://www.truercatering.com/wp-json/wp/v2/products?per_page=100&page=N` enumerated all 225
  products cleanly. `wp/v2/media` is also open but only returns ~390 recent items, so it is not a
  complete index - use the per-page galleries.
- **truercatering.com serves WebP for `.jpg` URLs.** SiteGround Optimizer content-negotiates on the
  Accept header and *also* ignores `Accept: image/*`. Appending any query string
  (`?nowebp=1`) bypasses it and returns the original JPEG. Without that you silently get a
  30%-smaller WebP inside a file named `.jpg`.
- **Alibaba's CDN does the same.** `sc04.alicdn.com/kf/....jpg` returns WebP unless the Accept header
  is exactly `image/jpeg,image/png`. With it, you get the full-size original (e.g. 248 KB vs 43 KB).
- **Alibaba supplier catalogues are enumerable via the mobile store URL** even though the desktop one
  is JS-only: `https://gdwinners.m.en.alibaba.com/productlist-N.html` yields 16 product IDs per page.
  That is how the 224-listing catalogue above was built.
- **Truer product pages mix family shots into one gallery.** Several pages (EC2016, 6016H, D001-011,
  ZT001-003) are family pages covering 3-11 models. Do not assume every image on a matched page is
  the matched SKU.

---

## 7. Still open

1. **Revert the 12 bulk-applied 560x440x180 dimension rows** (§2). Highest value, no sourcing needed.
2. **Fix the D002/D005/D011 dimensions** from the factory charts (§3), and add "ceiling-suspended
   retractable pendant, cord 60-250 cm" as the mounting type. Second highest value.
3. **Correct `IMG/BUF/00253`'s name from "Square 9L" to "Square 6L"** - SAP and the manufacturer agree
   against our own product name.
4. **Decide the `3602` model_number collision** and the 360-vs-36 unit mismatch on 00260/00261.
5. **Ask the supplier for the EG-series wattage** - 500 W (Truer) vs 800 W (Winners' own Alibaba).
   Same question for ZT001: 670 W (SAP + Truer) vs 725 W (Winners' own Alibaba).
6. **Ask the supplier for per-size wattage on the three EMBEDDED warmer boards**, given SAP's own
   remark already says 1350 W for the 1200 mm unit against our stored 900 W for all three.
7. **Confirm the 6018H finish** - the manufacturer's 6018H is gloss white with gold trim; our record
   implies plain stainless.
8. **Ask which of D7016T/D7017T/D7018T/D7019T we stock** - they are one page with four codes and three
   different body shapes.
9. **Open these three Alibaba listings in a real browser** - they are the best remaining leads and all
   returned empty shells to a plain fetch:
   - https://www.alibaba.com/product-detail/WINNERS-Various-Sizes-Embedded-Stainless-Steel_1601583045665.html (the EMBEDDED warmer boards)
   - https://www.alibaba.com/product-detail/WINNERS-High-Quality-Hammer-Point-304_1601467340111.html (likely the EC hammer-point family, may name EC2018)
   - https://www.alibaba.com/product-detail/WINNERS-Stainless-Steel-Waterless-Dry-Heating_1601467608460.html (likely QR016's wet/dry spec)
10. **`brands.json`**: the WINNERS row still has `description: "WINNERS"` and `website_url: null`.
    Both can now be filled from https://gdwinners.en.alibaba.com/ with a real company description.

---

## 8. Coverage summary

| | count |
|---|---|
| SKUs in the brand | 18 |
| SKUs with an exact-code verified manufacturer/reseller match | **11** - 00252, 00253, 00254, 00256, 00257, 00258, 00259, 00269, 00270, 00271, 00272 |
| SKUs where the code could not be found on any source | **7** - 00255 (EC2018), 00260/00261 (3602), 00266/00267/00268 (EMBEDDED-*), 00274 (DL206) |
| SKUs with images staged | 16 |
| SKUs with **no** image, deliberately | 2 (00260, 00261 - the `3602` pair) |
| SKUs whose staged image is family-level or reference only | 5 (00255 unconfirmed code; 00266/00267/00268 length not distinguishable; 00274 reference only) |
| Images staged | 94 files, 61 distinct (duplicates are family-page shots re-filed under each sibling SKU, and their filenames say so) |
| Spec sheets staged | 0 (none exist - §4) |

---
---

# APPENDIX A - gap-fill pass (2026-08-01): the `3602` pair, and spec sheets for all 18

**This appendix does not replace anything above; it corrects three specific claims and fills the two
gaps the main pass left.** Where it contradicts §4 or §5 above, the appendix wins and says why.
Nothing in `products.json`, `brands.json` or `storage/` was changed. Files staged in
`Desktop\ecommerce\products resorce final\winners\`; per-file ledger in `_sourced-gapfill.json`;
long form in `_FINDINGS-gapfill.md`.

## A.1 §4 is overturned: a spec document exists

§4 said "zero spec sheets, do not spend another pass looking for a Winners PDF on these two domains."
That was reached by scanning `truercatering.com/catalog/` for `.pdf` hrefs. There are none - because
the four catalogue download buttons on that page are **Google Drive share links**:

- https://www.truercatering.com/catalog/
- https://drive.google.com/file/d/1DyzzE__gcZPP_dD3RdSi__fe_KfgYrni/view?usp=sharing (All Products, 70 pp)
- https://drive.google.com/file/d/1ErVaBdAVYOpRLiB5UV4cuyCIv_jftdJ9/view?usp=sharing (Chafing Dishes, 24 pp)
- https://drive.google.com/file/d/1vzzt9bxksYdr0rAbRmQGH_-QgzXICU0T/view?usp=sharing (Beverage & Cereal)
- https://drive.google.com/file/d/1ciHg9xDzfoboUIk6j1VSDa4ZZpuh0J0Z/view?usp=sharing (Milk Tea Equipment)

The 24-page chafing catalogue is a page-for-page subset of the 70-page one (verified by per-page
pixel hashing), so only the 70-page file was staged, as
`_WINNERS-truer-all-products-catalog-70pp-spec.pdf`, plus one extracted per-SKU spec PDF for 17 of
18 SKUs. Every product block carries `Model / Volume / Voltage / Power`; the lamp and warmer-plate
sections also carry dimensions - the only published dimensions this brand has.

It is Winners' line under Truer's cover: products inside it carry the **伟纳斯 WINNERS** badge, e.g.
the rice steamer on printed page 59.

**Trap:** the catalogue's text is drawn as **vector outlines**, not live text. `get_text()` returns
~2 kB across 70 pages and a search for `EG2016X`, `3602` or `36cm` returns nothing. Pages must be
rendered and read visually or you will conclude the file is empty.

## A.2 §6's REST-API note has a hole that invalidated a search

§6 recommends `wp-json/wp/v2/products?per_page=100&page=N` for enumerating truercatering.com. It
enumerates fine, but the REST `content` field **does not contain the Key-attributes table** - every
spec value lives in post meta the API does not expose. §5's "all 225 product pages fetched and
full-text searched" therefore searched pages with the specs stripped out.

Re-fetching the rendered HTML for all 225 slugs (45 MB, about two minutes in six parallel curl
loops) and searching that surfaced two pages the earlier search could not have seen - see A.3.

## A.3 The `3602` pair - IMG/BUF/00260 (rose gold) and IMG/BUF/00261 (stainless)

### The abstention was respected
§5.1's decision to stage no image was a considered one and its substance stands: **nothing is staged
as a proven `3602` photograph.** Every staged frame carries `REPRESENTATIVE` in its filename and
`code_proven: false` in the ledger. What changed is that a *finish-labelled* factory page is now in
hand, which removes the specific hazard the abstention guarded against.

### §5.1's reasoning was wrong on one point
§5.1 argued `3602` "does not fit the grammar" of Winners/Truer hot-pot codes, reading them as
diameter pairs (`1516` = 15cm-16cm). Pulling the published Size off each of those pages:

| code | published Size | | code | published Size |
|---|---|---|---|---|
| 1516 | 15cm-16cm | | 1219 | 19cm-27cm |
| 1418 | 18cm-26cm | | 1117 | 17cm-19cm |
| 1328 | 28cm-32cm | | 0920 | 18cm-26cm |
| 0816 | 18cm-26cm | | 0616 | 16cm-32cm |

`1516` matching its own sizes is a coincidence; every other code disagrees. They are plain series
numbers, so **a four-digit `3602` is entirely consistent with this factory's code space.** The dead
end should read "not found", not "not a Winners code".

### What the manufacturer publishes
- https://www.truercatering.com/products/buffet-food-warmer-32ftcb/ - `No.32FTCB`,
  `Model Number 32FTCB`, `Size 30 cm / 32 cm`, `Power 500 W`, `110V / 220V`. A round hammered pot
  with a hinged domed lid on a separate warmer-stove base with an `INTELLIGENT DIGITAL DISPLAY`
  touch panel; rose-gold exterior, stainless interior. This is the product type SAP describes.
- https://www.truercatering.com/products/induction-chafing-dish-sl32-sg32/ - `No.SL32+SG32`,
  `Capacity 32cm/36cm`, `Power 500 W`. The same pot on a wooden-topped warmer stove. **That single
  line is the only published evidence anywhere that a 36 cm version of this product exists.**
- Catalogue printed page 8 - `MINI CHAFING DISH`, four blocks: `Model: 30cm/Stainless steel`,
  `32cm/Stainless steel`, `30cm/Rose gold`, `32cm/Rose gold`; `110V/220V`, `400W`.

### The answer to the question, and the recommendation
`3602` appears **nowhere**: not in the 70-page catalogue, not on any of the 225 truercatering.com
pages (full rendered HTML searched - zero hits), and not in any web result.

What the manufacturer does publish is its naming convention, and the convention answers the question:
**this factory carries the finish inside the model identity.** `30cm/Stainless steel` vs
`30cm/Rose gold`; `SL32` (silver) vs `SG32` (gold); the page-37 soup warmer as
`Model: Rose gold/Stainless steel`. Under that convention, one shared code across a rose-gold unit
and a stainless unit is not how these products are identified.

**Recommendation only - no code was changed, and `model_number` is the unique ID.** If `3602` came
off a Winners invoice it most likely belongs to **one** of the two finishes and was copied onto the
other. Ask the supplier which finish `3602` denotes and what the sibling code is; do not invent a
second code. §3's separate defect stands unchanged: 00260 stores `length: 360` and 00261 stores
`length: 36` for the same stated 36 cm diameter.

### Honest limits
No 36 cm photograph and no 6 L figure exist on any source. The 12 staged frames are 30/32 cm units of
the identical product: they prove the **type and the two finishes**, never the size. All were
rendered and viewed - genuine photography, with the `SUS 304` crest embossed inside the pan fully
legible at 5669 px, and the rose gold demonstrably photographed rather than colour-swapped (exterior
and bare stainless interior in one frame with correct differential reflection; a stainless and a
rose-gold unit lit identically side by side in the `-bothfinishes` frame). No AI-generated imagery
found. Resolution: six frames at **5669 x 5669** (strip the `-scaled` suffix), five at 800 x 800
(proven ceiling), catalogue page render at 2516 x 2552 (the PDF's embedded images cap at 594 px).

## A.4 What the spec sheets settle for the other 16 SKUs

The catalogue prints **Truer's own model numbers**, one letter or one digit from ours (`E2016X` vs
`EG2016X`, `2016H` vs `6016H`, `Embedded 90` vs `EMBEDDED-900`). Same products, same factory, but the
exact-code guard is **not** satisfied - every spec row is `code_proven: false`.

- **EMBEDDED-1500 (00268) may not be a product.** The factory publishes only **45 / 60 / 90 / 120 cm**
  warmer plates. No 150 cm unit in the catalogue, and no `150cm` or `1500mm` string on any of the 225
  Truer pages. Highest-priority supplier question in the brand.
- **EMBEDDED wattages:** 90 cm = **1050 W** (910 x 460 x 105 mm), 120 cm = **1400 W**
  (1210 x 460 x 105 mm). All three of our records publish 900 W. §3's flag is now positively
  contradicted for two of the three sizes, not one.
- **ZT001 (00272)** - `WARMER LAMP Rectangle/Square/Circular, 270W (Lamp) 400W (Stove), 220V,
  59*45*82cm (Rectangle)`. Reproduces SAP's wattage split **exactly** and settles §3's three-way
  dispute in SAP's favour (670 W, not Winners' Alibaba 725 W). First product dimensions for ZT001:
  **590 x 450 x 820 mm**.
- **D7016T (00259)** - `WARMER LAMP Circular/Square SUS304/Ceramic Container, 270W (Lamp) 400W
  (Stove), 50*38*85 / 45*33*81 / 50*34*89 cm` for its three bodies. First dimensions ever found, and
  they end §3's 205 mm height paradox outright: 205 mm was a carton.
- **EC2018 (00255)** - §3 called this "strong structural inference, but inference only". The
  catalogue now shows the ...18 = round 6 L slot twice (`E1018X 6L` on p.11, `2018X`/`2018H 6L` on
  p.15). Still not code-proven, but much better supported.
- **6018H (00257)** - `2018H 6L` is round; **6016H** `2016H 9L` is rectangular. SAP's litre split is
  confirmed not transposed. The catalogue body is polished stainless, not the gloss-white-with-gold
  of Truer's 6018H page, so §3's finish question stays open.
- **EG-series wattage** - every electric-hydraulic block in the catalogue says **500 W**. Two Truer
  sources against Winners' own Alibaba 800 W. 500 W is now the stronger reading; still worth
  confirming with the supplier.
- **EG2017X (00253)** - `E2017X 6L`: a third independent source for 6 L against our product name's
  "9L".
- **D002 / D005 / D011 (00269-71)** - the D001-D011 **ceiling pendant** is absent from the catalogue
  entirely. Their spec extracts are the whole lamp section, staged as context. The stored 150 W
  remains unverified on every source.
- **DL206 (00274)** - `Single/Double/Triple, 270W (Lamp) + 400W (Stove)` corroborates SAP's split
  from a second document. The string `DL206` still appears nowhere.
- **QR016 (00258)** - **no spec sheet exists.** No built-in wet/dry block anywhere in 70 pages, and
  its exact-code page publishes only `220V/50Hz`. Recorded as unmet rather than filled with a
  near-miss.

## A.5 Blocks encountered - and the correct label for each

**Search engines were not down.** Every general web search returned results throughout this pass.
What is blocked is one domain and one engine:

1. **alibaba.com serves a CAPTCHA.** `gdwinners.m.en.alibaba.com/productlist-N.html` - the mobile
   enumeration trick in §6 - now returns Alibaba's interception page to curl, and the same store in a
   real browser session lands on "Please slide to verify". CAPTCHAs will not be solved, so Winners'
   own Alibaba catalogue was unreachable. This is a domain block, not an outage, and it is not
   evidence about any product. §5.7 and §7.9 remain open, unattempted this pass.
2. **`lite.duckduckgo.com/lite/` now challenges POST as well as GET** ("select all squares containing
   a duck"). §5.5's workaround is fully gone.
3. **Winners' own foreign-trade catalogue existed and has been taken down.**
   https://www.yunzhan365.com/basic/51-100/11538879.html - 外贸画册(伟纳斯)电子刊物, "Foreign trade
   catalogue (WINNERS)" - is still search-indexed, with a snippet describing "electric warmer plates
   with different dimensions and power specifications", i.e. the same warmer-plate block as catalogue
   p.34, which further confirms the Truer catalogue is Winners' own document. The live URL now
   returns HTTP 404 with 您所访问的内容已下架 ("the content you visited has been taken down").
   **Worth one Wayback Machine attempt in a future pass** - archive.org rate-limited me before I
   could check. It would be the first genuinely Winners-branded document.
4. **`bestsuppliers.com` mirrors Winners' Alibaba listings server-side** and is the most promising
   untried route into that data. Verified: https://www.bestsuppliers.com/products/gdqtyfwtf0an/winners-commercial-electric-stainless-steel-pot-food-warmer-electric-soup-rice-warmer-for-hotel
   renders a full Key-attributes table with `Brand Name: WINNERS`, `Model Number: BWFG`. Its
   store/showroom pages are JS-only and its sitemap 500s, so the catalogue could not be enumerated -
   but individual product URLs fetch cleanly with a browser User-Agent (WebFetch gets 403; curl works).
5. **`gdwinners.goldsupplier.com`** - product list is JS-driven with no reachable API. Confirms §5.4.

## A.6 Coverage after this pass

| | count |
|---|---|
| SKUs with images staged | **18 of 18** (was 16) |
| SKUs with a spec sheet staged | **17 of 18** - only QR016 has none |
| Spec files staged | 18 (1 full catalogue + 17 per-SKU page extracts) |
| Images staged this pass | 14 files, 12 distinct (the catalogue finish page is filed under both `3602` SKUs) |
| SKUs whose new material is code-proven | **0** - all `REPRESENTATIVE` or `NEARMATCH` by design |
