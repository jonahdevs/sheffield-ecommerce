# Waring Product Research

Supersedes the WARING half of `old/tefcold-waring-research.md` (the TEFCOLD half of that file
is untouched and still stands).

Covers both WARING SKUs — `IMG/HOT/00108` (WCT805K 4-slot toaster) and `IMG/ICE/00021`
(WDM120K single-spindle milkshake mixer) — **plus the identification of a live cross-brand
contamination defect on a KAYALAR SKU**, which is the headline result.

**Nothing has been applied to `products.json` or `brands.json`.** Staged imagery and per-file
ledger: `Desktop\ecommerce\products resorce final\waring\` (`_sourced.json`, `_FINDINGS.md`).

⚠ WebSearch quota was exhausted before this brand was reached; `waring.com` is bot-gated
(PerimeterX) and katom/nisbets/kitchenrestock sit behind Cloudflare, so most of this was done
through a real browser.

---

## 1. ⭐⭐ The Kayalar contamination — SOLVED, byte-exact

`IMG/FPR/00110` "Potato Chipper Table Top Kayalar" is **published** carrying a Waring
spice-grinder photograph *and* a ~250-word Waring spice-grinder description.

**The photograph is the Waring `WSG60` — "3-Cup Spice Grinder"** (Waring's own page title:
*3-Cup Wet/Dry Power Grinder*).

Not a resemblance judgement — it is **the same file**:

| | value |
|---|---|
| `storage/app/public/products/potato-chipper-table-top-kayalar-imgfpr00110.jpg` | md5 **`bb396c66361eb414f5d115e47c0e6c80`**, 121,278 B, 2100 × 2100 |
| Waring's current WSG60 main image | md5 **`bb396c66361eb414f5d115e47c0e6c80`**, 121,278 B, 2100 × 2100 |
| 16×16 ahash hamming | **0** |
| per-pixel RMS, 256×256 greyscale | **0.0000** |

https://www.waring.com/3-cup-spice-grinder/WSG60.html

### 1.1 ⚠ The negative control — why ahash alone would have got it wrong

Waring makes **two** commercial spice grinders and both are 2100 × 2100 studio silos on white:

| | WSG30 "1.5-Cup" | **WSG60 "3-Cup"** ← ours |
|---|---|---|
| Chamber | **square**, WARING embossed into the cup | **round**, ribbed stainless cup |
| Collar | none | **"LOCK ←→ UNLOCK"** printed collar |
| Badge | embossed | separate **badge plate** on the base |
| ahash vs the Kayalar file | **10** ⚠ *would have been shortlisted* | **0** |
| RMS vs the Kayalar file | **52.35** — ruled out | **0.0** — confirmed |

A live demonstration of why the shortlist-then-confirm protocol exists: **ahash shortlists the
wrong grinder; only the per-pixel RMS separates them.**

### 1.2 The description text

The stored `description` is generic prose with **no model number, capacity or wattage**, so it
cannot be pinned by its own words. It does say *"Large Capacity: Processes substantial
quantities"*, which fits the 3-cup WSG60 over the 1.5-cup WSG30, and it arrived with the WSG60
photograph. **Attribute the copy to the WSG60 as well.**

### 1.3 ⚠ Extra hazard

**WSG60 is US-only, 120 V / 60 Hz, 750 W, 6.25 A, NEMA 5-15P.** There is no K-suffix export
WSG60. So `IMG/FPR/00110` is not merely carrying the wrong product's photo and copy — the
product it depicts **cannot run on Kenyan 240 V/50 Hz as shown**. Whoever fixes that record
should **delete** the Waring material, not repoint it at a Waring SKU.

**Out of scope to fix here — reported only.**

---

## 2. ⭐ The `K` suffix — CONFIRMED as the 220-240 V export build

**Yes, `K` is Waring's UK/international export electrical variant.**

| SKU | Model | Voltage | Frequency | Power | Plug |
|---|---|---|---|---|---|
| IMG/HOT/00108 | **WCT805K** | **220-240 V** | **50/60 Hz** | ~2015-2400 W, ~10 A | **Type G** (UK) |
| IMG/ICE/00021 | **WDM120K** | **220-240 V** | 50/60 Hz | 1 HP class | fitted UK plug |

Evidence gathered fresh this pass:

1. **Explicit, WCT805K:** *"220-240v/50/60, type G plug, CE, RoHS, UK, FOR INTERNATIONAL USE
   ONLY"* — https://www.globalrestaurantequip.com/product/waring-wct805k-commercial-toaster-heavy-duty-4-1-1-8-slots-4-slice-capacity/
2. **Live UK distributor spec, K-suffix sibling:** Nisbets lists **WDM120TXK** at
   **"Voltage 220-240V"** with a fitted plug —
   https://www.nisbets.co.uk/waring-heavy-duty-single-spindle-drinks-mixer-wdm120txk/fs040
3. **Absence evidence from Waring itself.** Waring's own site search returns **no K-suffix
   product page at all** (only WCT805, WCT805B, WDM120, WDM120T, WDM120TX), and the 47-page
   2026 **US catalogue** lists WCT800/805B/850/855 with US voltages and never a K model.
4. **The US models differ electrically**, which is exactly why this matters:

| Model | Voltage | Watts | Amps | Plug |
|---|---|---|---|---|
| WCT805 (US) | 240 V | 2700 | 12.0 | NEMA 6-15P |
| WCT805B (US) | 208/240 V | 2028/2700 | — | NEMA 6-20P |
| **WCT805K (export)** | **220-240 V** | **2015-2400** | ~10 | **Type G** |
| WDM120 (US) | **120 V** | — | 1.15 | NEMA 5-15P |
| **WDM120K (export)** | **220-240 V** | — | — | UK |

⭐ **Our stored electrical is already correct on both SKUs.** No fix needed — but note the
margin: the base **WDM120 is a 120 V machine**, so "correcting" our mixer from waring.com would
inject the wrong-market defect.

⚠ The footer link **"Waring International" still points to `https://waring.com/waringemea.html`,
which still serves no real page.** There is still no Waring export storefront; `waring.com`
remains the correct and only live corporate site. **No `brands.json` change.**

---

## 3. ⭐ SAP is RIGHT and `products.json` is WRONG on both SKUs

The reverse of the usual finding for this catalogue.

**Column order established from SAP itself: `W / D / H`, self-consistent across both rows.**

| SKU | SAP (W/D/H) | Waring's own figures | Verdict |
|---|---|---|---|
| IMG/ICE/00021 WDM120K | **171 / 281 / 525** | W 7" = **178**, D 11" = **279**, H 20" = **508** | ✅ **correct on all three** |
| IMG/HOT/00108 WCT805K | **304 / 267 / 229** | W 11.8" = **300**, D 13" = 330, H 9" = **229** | ✅ correct on **W and H** |

`products.json` holds **438 / 420 / 406** for the toaster (matching **no source anywhere**) and
**281 / 171 / 525** for the mixer (SAP's numbers with the first two transposed).

**Recommend adopting SAP's dimensions on both Waring SKUs.**

### 3.1 ⚠ A carton figure caught in the act

Three toaster depth figures exist; they resolve once you spot that one is a shipping box:

| Source | Figures | Reading |
|---|---|---|
| Waring's own page | W 11.8 × H 9 × **D 13** in = 300 × 229 × 330 mm | product |
| SAP | W 304 × **D 267** × H 229 mm | product, cabinet only |
| GlobalRestaurantEquip (K listing) | H 11.5 × W **14.63** × D **15.63** in = 292 × 371 × 397 | ⚠ **carton** |

The reseller's figures are **larger than the manufacturer's on every axis** — a box, not a
toaster. This is the chafing-dish failure mode again: **a carton figure republished by a reseller
as the product dimension.** The previous pass weighted it equally with the other two candidate
sets; it should be discarded. The same explains the weight gap — 8.48 kg is the bare toaster,
our stored 9.9 kg is plausibly packed.

---

## 4. ⚠⚠ A recorded resolution ceiling that was WRONG

The previous Waring pass staged files recorded as **3200 × 3200** from Katom. **Those were
synthetic upscales.** Katom serves through Cloudinary with the transformation in the URL path,
and it will enlarge past the native without limit:

| Request | Returned |
|---|---|
| `/v1602262185/products/141/141-WDM120/141-wdm120_002.jpg` (no transform) | **1000 × 1000 — native** |
| `…/q_auto,f_auto,w_3200,dpr_2/…` (what the old pass used) | 6400 × 6400 ⚠ upscale |
| `…/w_5000/…` | 5000 × 5000 ⚠ upscale |

**On Katom, "pick the biggest" is guaranteed to produce a fake.** True Katom ceiling for these
assets is **1000 × 1000**.

Everything staged now comes from **Waring's own Demandware CDN**, which fits-within and never
upscales (`?sw=2000`, `?sw=4000`, `?sw=1200&sh=1200` all return identical native bytes).

**Proven ceilings:** Waring silos **2100 × 2100**; Waring product renders **1200 × 1200**, insets
**800 × 800**; Katom 1000 × 1000; GlobalRestaurantEquip 600 × 600 (below floor, not staged).

## 5. Tooling — an unlinked PDF directory on waring.com

`/manuals`, `/downloads`, `/documentation`, `/support`, `/spec-sheets` all 404, but
**`/resources` 302s to `/product-documentation`**, whose markup exposes the asset root:

`https://www.waring.com/on/demandware.static/-/Sites-waring-master/default/pdf/manual/<FILE>.pdf`

That yielded the **2026 US product catalogue — 47 pages, 138 MB, real text layer** (not
rasterised). Only the two relevant pages are staged (p13 drink mixers, p41 toasters).

⚠ **Waring publishes no per-model spec sheet or manual.** Name-probing that directory for
`WCT805.pdf`, `WCT805K.pdf`, `WCT805_Manual.pdf`, `…_IB.pdf`, `…series.pdf`, `…_spec.pdf` and the
WDM120/WSG60 equivalents returned 404 on every combination, and the on-page documentation search
widget does not function for automated access.

## 6. Shared assets

- ⚠ The **highest-resolution toaster image (2100 × 2100) is the 208 V `WCT805B` variant's silo**,
  served on the WCT805 page. Same physical cabinet; confirmed a genuinely different photograph
  from the 1200 px main render (ahash 213, RMS 170.27). Filename says `VARIANT-B`.
- The reseller's K-toaster asset is literally named **`WCT805E_WCT805K.jpg`** — one photograph
  for both the E and K builds. 600 × 600, below floor, not staged, but direct evidence the two
  builds are visually identical.
- No byte-identical duplicates within the staged Waring set.

## 7. Product reference

| SKU | Model | Best source | Voltage / Hz | Confidence |
|---|---|---|---|---|
| IMG/HOT/00108 | WCT805K | https://www.waring.com/heavy-duty-4-slot-toaster---240v-2700w/WCT805.html + https://www.globalrestaurantequip.com/product/waring-wct805k-commercial-toaster-heavy-duty-4-1-1-8-slots-4-slice-capacity/ | **220-240 V / 50-60 Hz, Type G** | **High** on electrical; **High** on dimensions now SAP is corroborated |
| IMG/ICE/00021 | WDM120K | https://www.waring.com/heavy-duty-blenders-single-spindle-drink-mixers/WDM120.html + https://www.nisbets.co.uk/waring-heavy-duty-single-spindle-drinks-mixer-wdm120txk/fs040 | **220-240 V** | **High** on electrical and dimensions |

## 8. Recommended actions (nothing applied)

1. 🔴 **Fix `IMG/FPR/00110` (KAYALAR)** — remove the WSG60 photograph and the Waring spice-grinder
   description outright; that record is a potato chipper (§1).
2. 🟠 **Adopt SAP's dimensions on both Waring SKUs** — toaster 304/267/229, mixer 171/281/525
   (§3). This is the opposite of the standing assumption and is well supported.
3. 🟡 Discard the GlobalRestaurantEquip dimension set as a carton figure (§3.1).
4. ⚪ **No electrical change on either SKU** — both already carry the correct export figures (§2).
5. ⚪ **No `model_number` or `brands.json` changes.**
