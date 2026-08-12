# Steelology Product Research

**Supersedes `research/the archived research below** (July 2026, pre-SAP). That file remains
useful for its internal-consistency work; where the two disagree, this one wins, and each
disagreement is called out below. Nothing in `products.json`, `brands.json` or `storage/` has
been changed. Sourced files live in
`Desktop\ecommerce\products resorce final\steelology\`; the ledger is `_sourced.json` and the
full working notes are `_FINDINGS.md` in that folder.

10 SKUs, all matched in SAP. **1 sourced (partial), 9 not reachable.**

---

## 0. ⚠ Session caveat — general web search was out

`WebSearch` was exhausted before the first query of this session (200/200). Substitutes were
tried in order and all failed or degraded: DuckDuckGo-lite (worked ~6 queries, then anomaly
page), Brave (one query, then HTTP 429 + CAPTCHA), Mojeek (empty), Ecosia (403), Startpage
(303), three SearXNG instances (429), Bing RSS (answers, but silently drops phrase operators),
Yahoo (unparseable). Made-in-China **search** pages are fetchable; its **product detail** pages
hard-404 to non-browser clients. Browser automation exists on this machine but its protocol
requires a user browser-selection step a subagent cannot perform, so `amazon.in` is again a
**documented block**.

Everything below was obtained through direct `WebFetch`/`curl` on named URLs, IndiaMART's
`export.indiamart.com` search, IndiaMART product pages, Made-in-China search listings,
truercatering.com and the imimg CDN. **"Not reachable" here means not reachable through the
channels that survived — it is not evidence that a product does not exist.**

---

## 1. SAP dimension column order — settled from SAP alone

Only two of the ten rows carry dimension values; the other eight are blank (MISSING, not zero).

`IMG/BUF/00235`'s SAP `description` embeds the literal string `(960x460x45)` while its
dimension fields read **length 920 / width 460 / height 45**. Width and height land correctly
against its own prose, so the order for STEELOLOGY is **length / width / height** — established
without spending a fetch, per the brief.

⚠ **The same row that proves the order disproves its value.** Description says 960, field says
920, `products.json` says 915. Two heights as well: SAP 45, ours 60. And 915 × 457 is exactly
36″ × 18″, the shape of a converted figure rather than a measured one. No carton-vs-product
contamination could be demonstrated because no external dimension source for this SKU was
reachable; the contradiction is purely internal, and is recorded as such.

`IMG/BUF/00241` (580/423/202) carries no in-row prose to check against. `products.json`
reproduces it exactly.

---

## 2. ⚠⚠ The `SSPC` line — maker traced, capacity ladder matches 4-for-4

### 2.1 JKS Kitchen Ware publishes exactly our four capacities

**JKS Kitchen Ware**, New Delhi — IndiaMART seller `65801768`, proprietorship established 1985,
proprietor M Azam — sells the **Time Saver** *Commercial Hard Anodized Aluminum Outer Lid Handi
Pressure Cooker* range at **16 / 25 / 40 / 60 / 80 / 110 L**.

| JKS capacity | Our SKU | Our catalogue brand |
|---|---|---|
| **16 L** (₹4,990) | IMG/HOT/00167 `SSPC-16` | **STEELOLOGY** |
| **25 L** (₹6,293) | IMG/HOT/00168 `SSPC-25` | **HK-REDLINE** |
| **40 L** (₹14,280) | IMG/HOT/00169 `SSPC-40` | **GENEVA** |
| **60 L** | IMG/HOT/00170 `SSPC-60` | **GENEVA** |

Four of our four are four of one seller's six. Time Saver is JKS's full house brand — it also
covers fry pans, kadai, tawa, cutlery sets and measuring cups, plus a separate 12/15 L
*inner-lid* cooker line.

https://www.indiamart.com/jkskitchen-ware/
https://www.indiamart.com/proddetail/16-litre-commercial-hard-anodized-aluminum-outer-lid-handi-pressure-cooker-2850558786662.html
https://www.indiamart.com/proddetail/25-litre-commercial-hard-anodized-aluminum-outer-lid-handi-pressure-cooker-2850565518330.html
https://www.indiamart.com/proddetail/40-litre-commercial-hard-anodized-aluminum-outer-lid-handi-pressure-cooker-2850565458288.html
https://www.indiamart.com/proddetail/60-litre-commercial-hard-anodized-aluminum-outer-lid-handi-pressure-cooker-2850565491555.html
https://www.indiamart.com/proddetail/15-litre-time-saver-aluminium-pressure-cooker-2850570900388.html

SAP's `Item Remarks` for `SSPC-16` is near-verbatim Time Saver retail copy, so SAP and the
sourced page agree on brand, capacity, material and lid type.

### 2.2 Praveen Enterprises — still one source, and not this one

**JKS never names a manufacturer.** The Praveen Enterprises attribution rests solely on Sri
Vadiraja's listing, and for a **30 L** unit — a capacity JKS does not list:
https://vadiraja.com/product/time-saver-isi-mark-commercial-hard-anodized-aluminum-handi-pressure-cooker-silver-30l/

So the honest position: **"Time Saver" as the brand is now firmly corroborated by a second,
independent route that publishes our exact capacity ladder. "Praveen Enterprises" as the maker
is still a single-source claim** and should not be hardened into a fact yet. Asking JKS who
manufactures for them would settle it in one answer.

### 2.3 ⚠⚠ Our catalogue's single SSPC photograph is JKS's **40 Litre** frame

Established with perceptual hashing (16 × 16 ahash shortlist → per-pixel RMS on 256 × 256
autocontrasted greyscale), **normalised to the content bounding box first** — the raw files pad
differently, and a naive RMS scores them as unrelated:

| Pair | RMS | Verdict |
|---|---|---|
| stored `SSPC-16` ↔ stored `SSPC-25` | **0.00** | identical |
| stored `SSPC-40` ↔ stored `SSPC-60` | **0.00** | identical |
| stored `SSPC-40` ↔ **JKS 40 L web frame** | **4.42** (1.90 at 32 px) | **same photograph** |
| stored `SSPC-16` ↔ JKS 40 L web frame | 15.65 → 4.37 at 32 px | same photograph, heavier downscale |
| stored `SSPC-16` ↔ **JKS 16 L web frame** | **54** | different product |

⚠ **This corrects the archived research below §10A.1**, which concluded "four SKUs, **two**
photographs". It is **one** photograph. The 16/25 files (600 × 600) are the 40/60 file
(1512 × 1512) downscaled into a larger white margin — gauge right, lever pin left, valve centre,
`Time Saver™` at the same body position, same twin reflection stripes. The old file's MD5-based
method could not see through the re-encode and padding; perceptual hashing can, which is
exactly why the brief mandates it.

**Consequence: the `SSPC-16` record currently shows a 40 L cooker.** The genuine 16 L has a
different lid — flat, bolted, two hex nuts, small central valve, **no gauge and no lever**. The
gauge-and-lever lid is what JKS puts on the 40 L page.

### 2.4 The two "Time Saver" lockups are one brand — §10A.2 closed

The old file left two readings open: one brand with two logo generations, or two unrelated
proprietors of a generic name. **One seller publishes both**, so it is the first:

- **red type on a blue diamond, ™** → commercial outer-lid handi range (16/25/40/60 L). This is
  the lockup on our stored photo.
- **white type on a red oval with a yellow diamond** → domestic inner-lid range (12/15 L).

### 2.5 ⚠ The sourced 16 L frame is itself a range photo

Rendered side by side against JKS's own 25 L frame at matched scale, the two are the **same
photograph** — identical lid, hex-nut positions, cast-handle hammer texture, reflection stripe,
logo size and placement. Only crop and burned-in caption differ. Filed as
`IMG-HOT-00167__SSPC-16-REPRESENTATIVE-RANGE-TimeSaver-16L-captioned-jkskitchenware-1.png`,
`code_proven: false`. The 16 L capacity rests on the seller's page title and caption, not on the
image.

Both staged frames were rendered and inspected: genuine photography (correct specular behaviour
on cast aluminium, real engraved `PRESSURE COOKER` lettering in the detail crops). **No
AI-generated imagery encountered anywhere in this brand.**

### 2.6 Resolution ceilings differ per asset

`imimg.com` serves size-suffixed derivatives; stripping `-500x500`/`-1000x1000` returns the
original. There is **no single brand ceiling**: 16 L → **778 × 1000** (22 px under the short-edge
floor, and this *is* the original); 40 L → **1271 × 1280**; 25 L gallery → **1500 × 1500**;
15 L → **1280 × 1280**.

### 2.7 ⚠ Hand-off to HK-REDLINE — the 25 L page beats that pass's 30 L stand-in

The 25 L listing carries a six-image gallery, a **dimensioned engineering figure** and a weight
that neither the 16 L nor the 40 L page has:

> `25 ltr. (weight 6.700 kg)` — **390 mm** overall height, **300 mm** body diameter, **320 mm**
> body height, **330 mm** lid diameter, **75 mm** lid depth, **4.06 mm** lid gauge, **6.40 mm**
> rim gauge. Callouts: fusible safety valve, lead-free safety valve, sturdy aluminium handles.

Staged in `steelology\_brand-reference\` as
`TimeSaver-25L-dimensioned-figure-jkskitchenware-FOR-HK-REDLINE-SSPC-25.jpg` (1500 × 1500) and
`TimeSaver-25L-feature-callouts-jkskitchenware.jpg`. **`hk-redline-research.md` §4 recorded that
only a 30 L frame could be reached; this supersedes it and the files should move to the
hk-redline folder.**

### 2.8 No brand change proposed

The `SSPC` attribution is a pending user decision. Evidence recorded, not acted on.

---

## 3. The nine documented abstentions — all nine upheld, two materially advanced

### 3.1 `IMG/BUF/00235` `SUNK IN` — upheld, but the product class is now identified

This is a **drop-in tempered-glass buffet warming board**, and our own catalogue already
carries the class under a different house label: **WINNERS `EMBEDDED-900/-1200/-1500`,
"45-BUILT-IN Warmer Stove"** — traced by the Winners pass to **Truer Catering `BWB-QRSK`**,
published at 45/60/90/120 cm, the 90 cm unit being **910 × 460 × 105 mm / 1050 W**.
https://www.truercatering.com/products/large-built-in-food-warmer-tray/

Our **460 mm width matches Truer's exactly**, and 910 mm brackets our 915/920/960 spread.

**Abstention upheld** because two specs contradict: Truer's control is touch + remote, ours (per
the stored photo) is a **rotary knob box on a flexible conduit**; Truer's 90 cm is 1050 W, ours
is 600 W. Attaching a Truer/Winners frame would assert a supplier identity the specs deny.

Useful residue: Truer's **105 mm** depth makes our 45/60 mm look like a glass-panel thickness or
a recess lip rather than the unit depth. ⚠ Also note SAP's remark calls this a "COMMERCIAL
INDUCTION COOKER" while giving 600 W and a 0–80 °C range — those are warmer figures, not
induction figures. The parenthetical in our product name inherits that error.

### 3.2 `IMG/HYS/00281` / `00282` "Spider Type" — upheld, and independently re-corroborated

Re-probed by two routes different from the old file's:

- A fresh IndiaMART flying-insect-killer sweep returned **32 listings** across nine sellers
  (Orchids International, Airex, Moski-Kill/Divam Udyog, Techwin, MNC Engineering, Harrisons
  Pharma, Cecon Pollutech, Energy Solutions, Hi Bro). Model names in use: *Classic*, *Smart*,
  *Galaxy*, *Sleek*, *Lalten*, `OR/FK/02`, `MKZ001F`/`MKZ002F`/`MKZ125F`, `AE-256`, `MT400-10W`.
  **Not one uses "spider".**
- Brave's index for the exact phrase `"spider type" insect killer` returns **spider pesticide
  sprays** (Miss Muffet's Revenge, Ortho BugClear, Spectracide, Bonide) — the same category
  confusion the old file hit on Made-in-China, reproduced on a completely different index.

**"Spider Type" has no supplier vocabulary anywhere reachable.** Two independent routes, one
answer. This is now an evidenced abstention rather than a search failure.

⚠ One near-miss deliberately **not** taken: Orchids International's *ABS White Fly Catcher
Scorpion Glue pad Machine* is **45 W (3 × 15 W)** with an **ABS plastic body**, matching both our
45 W and SAP's `PLASTIC FIBER BODY`. It is still a named brand's glue-pad catcher and not a
"spider" anything — it would have passed an HTTP-200 check and failed the exact-code guard.

### 3.3 `IMG/BUF/00241` `RH002` — upheld, plus one new negative and one live conflict

`RH001`/`RH002` return nothing on IndiaMART, nothing on Made-in-China, nothing on any reachable
index; the sole carrier is sheffieldafrica.com (circular, inadmissible). The best lead —
**Guangdong Shunde Heavybao**, already proven by `oem-sheffield-research.md` §6.1 to make the
sibling `431001`/`432102` chafers, and who list a *"Digital Temperature Controlled Rectangle
Chafing Dish"* — could not be opened, because MIC detail pages 404 to non-browser clients.
**Highest-value browser retry in the brand.**

⚠ Independent of sourcing, and confirming `sap-reconciliation-research.md`'s open item:
**SAP's Model is `RH001`, our `model_number` is `RH002`.** Flagged only — `model_number` is the
unique ID and is never changed inline.

### 3.4 `IMG/BUF/00277` — upheld after actively testing and rejecting two candidates

Truer Catering's two nearest items were opened, downloaded and rendered: `BWL-DLS` (rose-gold
lamp set, **no induction base**) and `Z001/Z002/Z003` (a **single** marble-top induction warmer,
**no lamps**). Neither is our two-zone / two-lamp station. Rejected rather than stretched.

### 3.5 `IMG/HYS/00266`–`00269` — upheld, and structurally unsourceable

No model number, no capacity, no price, no SAP dimensions (the two numbers exist only inside the
product name), all four archived, all four carrying the same placeholder stock of 99. Any
commodity stainless vessel at that size would "match", which is not sourcing. The old file's
exclusion of the hospital dressing-drum hypothesis (published ladders are diameter ≥ height and
start at 150 mm; ours are height > diameter and start at 100 mm) stands — nothing found against
it, and its miscategorisation flag under "Hygiene" therefore also stands.

---

## 4. Brand verdict — unchanged, and now slightly better supported

`house-brand-suppliers-research.md` §7.2 marked Steelology **NOT FOUND** and read the business's
statement as pointing to a supplier trading under that name with no web footprint. Nothing this
pass contradicts that. What this pass adds is that **the one STEELOLOGY SKU whose real origin
could be traced turns out to come from an Indian seller (JKS Kitchen Ware) whose own brand is
"Time Saver"** — i.e. at least one STEELOLOGY item is not a Steelology product at all. That
sharpens rather than resolves §7.2's open question: if Steelology is a real distinct supplier,
the cross-label `SSPC` overlap still needs explaining. `website_url` should stay null.

---

## 5. Per-SKU reference

| SKU | Code | Result | px | code proven | agrees with SAP |
|---|---|---|---|---|---|
| IMG/HOT/00167 | `SSPC-16` | **partial** — 1 range frame + 1 REF | 778 × 1000 / 1271 × 1280 | ✗ (in-house recode) | ✓ brand/capacity/material; SAP has no dims |
| IMG/BUF/00241 | `RH002` | not reachable | — | ✗ | n/a — ⚠ SAP says `RH001` |
| IMG/BUF/00235 | `SUNK IN` | not reachable (class identified) | — | ✗ (not a code) | ✗ — SAP self-contradicts, 960 vs 920 |
| IMG/BUF/00277 | *(none)* | not reachable | — | n/a | n/a |
| IMG/HYS/00266 | *(none)* | not reachable | — | n/a | n/a — dims blank |
| IMG/HYS/00267 | *(none)* | not reachable | — | n/a | n/a — dims blank |
| IMG/HYS/00268 | *(none)* | not reachable | — | n/a | n/a — dims blank |
| IMG/HYS/00269 | *(none)* | not reachable | — | n/a | n/a — dims blank |
| IMG/HYS/00281 | `30W` | not reachable | — | ✗ (= wattage) | n/a — dims blank |
| IMG/HYS/00282 | `45W` | not reachable | — | ✗ (= wattage) | n/a — dims blank |

## 6. Open questions for the business

1. **Who manufactures Time Saver?** One question to JKS Kitchen Ware confirms or kills Praveen
   Enterprises (§2.2).
2. **Decide the `SSPC` brand attribution** — one Indian product line currently wearing three
   Sheffield house labels, now with an external seller and a matching capacity ladder (§2.1).
3. **`SSPC-16`'s photo shows a 40 L cooker** and the real 16 L has a different lid (§2.3).
4. **`RH001` vs `RH002`** — SAP and `products.json` disagree on this SKU's model number (§3.3).
5. **`IMG/BUF/00235`'s length**: 915, 920 or 960 mm? And its depth: 45, 60 or ~105 mm (§1, §3.1)?
6. **Is `IMG/BUF/00235` a warmer or an induction cooker?** 600 W and 0–80 °C say warmer; the name
   and SAP remark say induction cooker (§3.1).
7. **Shape/material of the four containers**, and their "Hygiene" categorisation (§3.5).
8. **Spec sheets for both insect killers** — coverage, tube type, mounting, and what "Spider
   Type" is supposed to mean. Both are `draft` and should stay there (§3.2).

---

## Archived brand research

> Merged in from the former `research/old/` folder on 2026-08-12, when the two folders were
> consolidated. This is the earlier **specs and codes** pass; everything above it
> is the later **sourcing and provenance** pass. The text is unchanged apart from
> heading levels, which were demoted one step to keep a single outline.

## Steelology Product Research

Research notes behind a STEELOLOGY enrichment/audit pass on `products.json` (July 2026).
Covers all 10 STEELOLOGY SKUs: 1 digital rectangular chafing dish, 1 sunk-in glass-top dish
warmer, 1 double-bulb induction chafer set, 4 bare stainless containers, 2 "spider type"
insect killers, and 1 pressure cooker.

**No `products.json` or `brands.json` changes have been applied** — this file is findings
only, same starting point as the Brema and Kitchenware passes before a scope decision.

**Session note:** general web search (Google, Bing, DuckDuckGo, Ecosia, Marginalia, Mojeek)
was almost entirely unusable this pass — blocked, CAPTCHA-walled, or returning irrelevant/
localised filler regardless of query. Direct fetches to specific domains (sheffieldafrica.com,
indiamart.com, made-in-china.com, trademo.com) worked fine throughout, so this file leans
harder on those plus internal cross-catalogue evidence than a normal pass would. Anywhere a
claim rests on internal evidence rather than a third-party source, it says so.

---

### 1. Brand identification — real company exists, but almost certainly not this one

`brands.json` entry:

```
slug: steelology  |  name: Steelology  |  website_url: null
logo: brands/steelology.png
description: "Steelology specializes in stainless steel kitchen equipment and custom
              fabrication. They provide high-quality stainless steel solutions for
              commercial kitchens."
```

**Important correction to the standard "generic description" test used on Kitchenware:**
this description is *not* uniquely suspicious. A scan of `brands.json` shows the exact same
"[Brand] specializes in / manufactures / is a leading manufacturer of X. They provide/focus
on Y for commercial kitchens" template applied to essentially every row — including
confirmed-real brands like Tecnodom, Santos, Carpigiani and Berjaya. This whole file was
bulk-written with one boilerplate generator; genericness of phrasing alone proves nothing
here. The Steelology verdict has to rest on other evidence, and there's a lot of it (below).

#### 1.1 A real "Steelology" does exist — but it's a tiny, unconnected Delhi trading firm

DuckDuckGo (working before it started CAPTCHA-walling) surfaced a real, currently-active
Indian company:

- **Steelology Private Limited** — CIN `U24319DL2023PTC422917`, incorporated 21 Nov 2023,
  registered office C-56-X-1, Dilshad Garden, East Delhi. GST-registered Dec 2023, **annual
  turnover band ₹0–40 lakh (roughly under USD 48,000)**. Listed activity: "Manufacturing
  (Metals and Chemicals, and products thereof)"; IndiaMART profile describes it as a
  wholesaler/trader in "Cooking Range, Fabricated Equipment & Commercial Stainless Steel
  Equipment."
  https://www.indiamart.com/steelology-private-limited/
  https://buysellprivatelimited.com/company/steelology-private-limited/U24319DL2023PTC422917
  https://www.trademo.com/companies/steelology-pvt-ltd/45586681
- `steelology.com` resolves to a **parked/unrelated domain-registration page** — not this or
  any other kitchen-equipment company.
- An `@steelology` Instagram (53 followers, 12 posts) and a Steelology Etsy shop also exist
  but read as unrelated small craft/lifestyle sellers, not a catering-equipment company.

This is a genuine company, but a two-year-old, sub-$50k-turnover Delhi trading outfit with no
found evidence of exporting to Kenya is not a plausible source for Sheffield Africa's whole
catalogue line, and nothing ties it to these specific SKUs. Treat the name match as
**coincidental** (the word is a generic steel+-ology construction, so an independent small
company landing on the same name isn't surprising) rather than as brand identification.
**Do not add this as `website_url`.**

#### 1.2 The stronger case: none of the 10 model numbers survive scrutiny

This is the real finding, and it needed no web search — it came from reading the other 9
Steelology-adjacent records already in `products.json`:

| SKU | `model_number` | What it actually is |
|---|---|---|
| RH002 (00241) | Looks like a code | **Reused for a different product** — see §2, a second, *6.5-litre* chafer on Sheffield's own live site carries the identical `RH002` |
| SUNK IN (00235) | Not a code at all | It's the **installation type** ("sunk-in" / drop-in mounting), not a manufacturer part number |
| *(empty string)* (00277) | No code | — |
| *(null)* ×4 (containers) | No code | — |
| 30W / 45W (insect killers) | Not a code | The **wattage itself**, reused as the model field |
| SSPC-16 (pressure cooker) | Looks like a code | **Shared grammar with two other "brands"** in this same catalogue — HK-REDLINE's `SSPC-25` and GENEVA's `SSPC-40`/`SSPC-60` are the identical `SSPC-<litres>` pattern (§5), and the physical product is printed with a **different brand entirely** ("Time Saver", §5) |

**Not one of the 10 holds up as an exclusive, traceable Steelology part number.** Combined
with §1.1 and §5, the honest read is: **Steelology is a Sheffield storefront label for
generic/rebadged stainless smallwares, not a manufacturer** — the same conclusion the
Kitchenware pass reached, arrived at by a different (internal, not description-text) route.

---

### 2. IMG/BUF/00241 — Digital SS Rectangular Chaffing Dish 9 Ltrs (RH002)

Stored: price KSh 82,750, dims 580×423×202mm, 600W, 9L, description already reasonably
complete (touch-screen control, tempered-glass window, hydraulic damper).

**Sheffield's own live site independently confirms most of this, but disagrees on the name**
(fetched directly — this domain, unlike general search engines, was reachable all pass):

> **"Digital Ss Square Chafing Dish 9 Litres"** — same `Item Number: IMG/BUF/00241`, brand
> STEELOLOGY, model `RH002`, description matches ours verbatim (touch-screen panel,
> tempered-glass window, hydraulic damper, 600W/9L).
> https://sheffieldafrica.com/commercial-kitchen/product/1038/digital-ss-square-chafing-dish-9-litres-rh002

The live page calls it **"Square"**; our `products.json` name says **"Rectangular."** The
existing local product photo (`storage/app/public/products/digital-ss-rectangular-chaffing-
dish-9-ltrs-imgbuf00241.jpg`) settles it: it's visibly a **rectangular** pan, clearly longer
than it is wide, matching the stored 580×423mm footprint (≈1.37:1, not square). **The stored
name is the geometrically correct one; the live site's own page copy is the one that's
wrong**, same class of self-contradiction as the Kitchenware pass's `ECD09C` naming check,
just resolved in the opposite direction this time (own site wrong, record right).

**The bigger finding: `RH002` is not unique even inside our own catalogue.** The live site
also carries a sibling:

> **"Digital Ss Square Chaffing Dish 6.5 Litres"** — `Item Number: IMG/BUF/00240`, same
> brand STEELOLOGY, **same model `RH002`**, 6.5L instead of 9L.
> https://sheffieldafrica.com/commercial-kitchen/product/1037/digital-ss-square-chaffing-dish-6.5-litres-rh002

`IMG/BUF/00240` does not exist anywhere in this `products.json` export (checked directly),
so it's either been dropped from this snapshot or never made it in — but its existence on
the live site, sharing `RH002` with a *different capacity*, is a direct, first-party
confirmation that this model number is being applied to more than one physical product.
Per [[feedback_model_number_unique_id]] this is exactly the kind of thing that memory note
exists to catch — not a reason to change `model_number` unilaterally, but worth flagging
before anyone relies on it as a unique key.

A generic "square digital chafer" (6–6.5L) is also a common category on IndiaMART with no
`RH002`-coded match found among several sellers — consistent with `RH002` being an internal
Sheffield/Steelology stock code, not a manufacturer part number.
https://export.indiamart.com/search.php?ss=digital%20chafing%20dish%20square%20RH002

**Confidence: existing content is accurate and safe (Medium-High)**; the only actionable
item is the Rectangular/Square naming mismatch against the live site (recommend keeping
"Rectangular" — it's the one supported by both the photo and the dimensions) and awareness
that `RH002` is shared with a 6.5L sibling.

---

### 3. IMG/BUF/00235 — Dish Warmer Glass Top, Sunk-in Model (208750 KSh)

Stored: dims 915×457×60mm, 600W, 220V/50-60Hz, 30-80°C range, model_number literally
`"SUNK IN"` (an installation-type descriptor, not a part code — see §1.2).

**No swap bug on this one** — the numeric fields (915/457/60) match the prose
`technical_specification` ("Size: 915 x 457 x 60 mm") exactly, so this is one of the
per-SKU cases (like Brema's CB-955A) where the width/height transposition bug that recurs
across other brand passes simply isn't present. Worth recording precisely because the
brief calls for checking this per-SKU rather than assuming.

The existing local product photo (`dish-warmer-glass-top-sunk-in-model-commercial-
induction-cooker-imgbuf00235.jpg`) shows a long, low, black-glass drop-in warming surface
with an aluminium frame lip (consistent with "sunk-in"/recessed counter mounting) and a
separate control box with a temperature dial and cable — visually consistent with the
stored description and a plausible match for a 915×457×60mm footprint.

No external source was found for this specific product (general search was non-functional
for this query all session — see the session note up top). **Confidence: Low on external
verification, but internally consistent** (dims agree with prose, photo agrees with the
description) — nothing here contradicts itself, which is the most that could be established
this pass.

⚠ **Price coincidence worth flagging:** this SKU is priced at exactly **KSh 208,750**, the
identical figure to the unrelated §4 double-bulb induction set. Two structurally different
products at an exact match is the same kind of flag the Kitchenware pass raised for its two
identically-priced GN containers — possibly a copied/default price rather than two genuinely
coincidental figures. Worth a sanity check, not asserted as wrong.

---

### 4. IMG/BUF/00277 — Double Bulb Induction with 2 Copper-Coated Hammer-Finish Chafing Dishes (208750 KSh)

Stored: `model_number` is an **empty string** (no code at all), category filed as "Induction
Cookers", no dimensions stored, description already reasonably detailed (double bulb
induction base, 2 copper-coated hammer-finish chafing dishes, corrosion-resistant).

The existing local photo (`double-bulb-induction-with-2-copper-coated-hammer-finish-
chaffing-dishes-imgbuf00277.png`) matches the description well and resolves what could have
read as a contradiction: it shows **two rose-gold/copper hammer-finish pots**, each sitting
on **its own induction zone** on a shared black base (visible per-zone digital displays), with
a **decorative dome lamp on a curved arm over each pot**. Read together with the name, "double
bulb" most plausibly refers to the **two dome lamp heads**, while "induction" describes the
heating base — i.e. this is a combination unit (induction warming + decorative overhead
lamps), not a contradiction between two different heating technologies. This is an inference
from the photo, not a sourced spec sheet, but it's internally coherent and worth recording as
such rather than flagging a false contradiction.

No dimensions are stored and none were found externally (search was non-functional for this
query). No external source matched this exact product — it reads as a decorative buffet-
display set assembled from generic industrial parts (induction module + hammered copper GN-
adjacent pots + lamp arms), which is consistent with the "rebadged smallwares" conclusion in
§1 rather than a traceable single manufacturer product. **Confidence: Low on sourcing, but
photo/description internally consistent.** Same KSh 208,750 price-coincidence flag as §3
applies here too.

---

### 5. IMG/HOT/00167 — Pressure Cooker 16 Litres SSPC-16

Stored: price KSh 58,250, no description, no dimensions, `status: published`.

#### 5.1 The smoking gun: the product photo shows a *different* printed brand

The existing local product photo
(`pressure-cooker-16-litres-sspc-16-imghot00167.jpg`) was inspected and zoomed. The pot is
physically **stamped with a blue-and-red "Time Saver" logo** — not "Steelology," not any
Sheffield-side brand name at all. This is first-party, load-bearing evidence (an actual
photograph of the actual product, not a web claim) that the true manufacturer/brand is
**"Time Saver,"** a separate label from whatever "STEELOLOGY" means in this catalogue.

#### 5.2 The `SSPC-<litres>` code is shared across three different catalogue "brands"

Checking the two neighbouring pressure-cooker records already in `products.json` (no web
search needed — same file):

| SKU | Capacity | `model_number` | Catalogue `brand` | `description` |
|---|---|---|---|---|
| IMG/HOT/00167 | 16 L | `SSPC-16` | **STEELOLOGY** | *(none — this record)* |
| IMG/HOT/00168 | 25 L | `SSPC-25` | **HK-REDLINE** | "Timesaver Pressure Cooker; 25 litres" |
| IMG/HOT/00169 | 40 L | `SSPC-40` | **GENEVA** | "Timesaver Pressure Cooker; 40 litres" |
| IMG/HOT/00170 | 60 L | `SSPC-60` | **GENEVA** | "Timesaver Pressure Cooker; 60 litres" |

**The `SSPC-NN = litres` code grammar, and the literal phrase "Timesaver Pressure Cooker,"
are shared verbatim across three different storefront brand labels.** This is the exact
kind of cross-brand duplication the Kitchenware pass found with `SDI`/`KITCHENWARE`/`WANHUI`
— a single generic-OEM product line ("Time Saver" branded pressure cookers, confirmed by
the photo in §5.1) sold under whichever house label happened to be assigned at import time.
`STEELOLOGY` is simply the label attached to the 16L tier.

**Recommended, if the record is ever completed:** the same "Timesaver Pressure Cooker; 16
litres" formula used by its siblings is the obvious, evidence-backed fill for the empty
`description` field — it isn't a guess, it's the exact pattern this product's own catalogue
siblings already use, now corroborated by the physical photo.

No dimensions are stored on *any* of the four SSPC-family records (16/25/40/60L), so there's
nothing to geometrically cross-check for this one. A general search for the "Time Saver"
brand or `SSPC-16` code did not surface an independent manufacturer page this pass (search
was largely non-functional), so treat the brand identification as **photo-confirmed but not
externally corroborated**.

---

### 6. The 4 "Stainless Steel Container" SKUs — likely round bain-marie/soup-well insert pots, likely miscategorised

| SKU | Name | Status | Price | Qty | Image |
|---|---|---|---|---|---|
| IMG/HYS/00266 | Stainless Steel Container 100X100MM | archived | 0 | 99 | none |
| IMG/HYS/00267 | Stainless Steel Container 125X135MM | archived | 0 | 99 | none |
| IMG/HYS/00268 | Stainless Steel Container 150X165MM | archived | 0 | 99 | none |
| IMG/HYS/00269 | Stainless Steel Container 190X200MM | archived | 0 | 99 | none |

All four: no `model_number`, no `description`, no image, price 0, and an identical,
suspiciously round quantity of 99 across all four — these read as stub/placeholder records
that were never fully populated, which is also consistent with all four already being
`archived`.

#### 6.1 What the two numbers most likely encode

Each name gives **exactly two numbers**, not three. That itself is a clue: a rectangular
box needs three dimensions (L×W×H) to be fully specified; a **round vessel only needs two**
(diameter × height). The fact that these records give only two numbers each fits a round
reading far more naturally than a square-box reading, which would require silently assuming
the unstated third dimension equals the first.

**Reading them as diameter × height (mm), the four sizes — Ø100×100, Ø125×135, Ø150×165,
Ø190×200 — line up closely with a completely standard commercial catering item: round
bain-marie/soup-well insert pots**, which hospitality suppliers commonly sell in a graduated
ladder of round diameters in roughly this range (100mm/125mm/150mm/190-200mm steps) for
carvery and soup-station wells. This is a plausibility/market-convention argument, not a
sourced spec sheet — no capacity is stated on any of the four records to check against, and
no external source was found that names these specific four sizes as a set (search was
non-functional for this query all session), so this should be read as a **medium-confidence
inference**, not a confirmed identification.

**If the diameter × height reading is right, the brim-full volumes work out to:**

| SKU | d × h (mm) | r (cm) | h (cm) | Brim-full V = πr²h |
|---|---|---|---|---|
| IMG/HYS/00266 | 100 × 100 | 5.0 | 10.0 | **0.79 L** |
| IMG/HYS/00267 | 125 × 135 | 6.25 | 13.5 | **1.66 L** |
| IMG/HYS/00268 | 150 × 165 | 7.5 | 16.5 | **2.92 L** |
| IMG/HYS/00269 | 190 × 200 | 9.5 | 20.0 | **5.67 L** |

These are sensible, unremarkable volumes for small-to-medium prep/serving vessels — nothing
here rules the reading out, but nothing confirms it either, since there's no stated capacity
anywhere in the record to reconcile against (unlike the Kitchenware cookware pass, where a
stated litre figure existed to check the geometry against). **Flagged explicitly: this is
exploratory geometry on an unconfirmed shape assumption, not a verified capacity.**

An alternative square-tin reading (V = w²×h, i.e. treating the two numbers as a square
footprint and a height) was also computed for completeness — it gives 1.0L / 2.11L / 3.71L /
7.22L — but is considered the weaker reading precisely because it requires assuming an
unstated third dimension.

#### 6.2 Likely miscategorised — "Hygiene" doesn't fit a bare container

Every other record filed under this catalogue's "Hygiene" category is genuinely about
**sanitation or pest/infection control**: knee-operated hand-wash basins, a UV knife
steriliser, a fogging/disinfection machine, a hot/cold towel cabinet, insect killers. A bare
stainless container — no lid, no dispenser mechanism, no antibacterial claim, nothing in the
name or (empty) description tying it to hygiene — has no functional connection to that
theme. This is the same shape of miscategorisation the brief flags from the Antunes/`GST-1V`
precedent: a plain storage/prep vessel sitting in a category defined by sanitation function.
**If these are in fact bain-marie/soup-well insert pots (§6.1), "Buffet & Servery" — where
this catalogue already keeps its other bain-marie and chafing-dish stock — is the
functionally correct category, not "Hygiene."** Flagged only; not changed, per scope.

#### 6.3 Confidence

**Low.** No external source confirms these four specific sizes as a set, no capacity is
stated to check the geometry against, and the shape (round vs square) is inferred rather
than stated. The category mismatch (§6.2) is the most defensible individual claim here,
independent of which geometric reading is right.

---

### 7. The 2 "Spider Type" Insect Killers

| SKU | Name | `model_number` | Price | Status |
|---|---|---|---|---|
| IMG/HYS/00281 | Insect Killer 30W Spider Type | `30W` | 24,000 | draft |
| IMG/HYS/00282 | Insect Killer 45W Spider Type | `45W` | 28,000 | draft |

Both `model_number` fields are literally the wattage restated (§1.2) — not codes. Neither
has an image or description. "Spider Type" did not resolve to anything meaningful via search
this session (queries returned Spider Solitaire game sites on Bing and unrelated aerosol
"spider killer" spray products on made-in-china — neither is the product category here); it
most plausibly describes a physical shape (a free-standing unit with a splayed/tripod base or
radiating arms, a descriptor pattern seen on some Chinese OEM insect-killer-lamp listings),
but that reading is **unverified** and should not be presented as confirmed.

#### 7.1 Wattage plausibility — checked against catalogue siblings, not external search

Two comparable electric-grid/UV-tube insect killers already exist elsewhere in this same
catalogue, and they're a reasonable plausibility check for wattage without needing an
external source:

| SKU | Brand / Model | Lamp | Total power | Coverage |
|---|---|---|---|---|
| IMG/HYS/00179 | BERJAYA `BJY-IK30A` | 15W UV tube | **40W** | 80 m² |
| IMG/HYS/00032 | MAYSIN `PJ-FK40` | — | **40W** | 50 m² |
| IMG/HYS/00281 | STEELOLOGY (this) | — | **30W** | — |
| IMG/HYS/00282 | STEELOLOGY (this) | — | **45W** | — |

Our two units (30W and 45W) bracket the 40W figure both catalogue comparables converge on —
**both wattages are physically plausible** for this class of commercial flying-insect
control unit; neither reads as implausibly high or low against known-good comparables.

**On the "one copy-pasted onto the other" risk the brief flags:** the two `short_description`
values are not identical — 30W is described as "wide-area flying insect control" while 45W
is described as "maximum-coverage… large commercial kitchens, food processing areas" — a
distinct, scaled-up framing consistent with a genuinely larger unit, not a duplicate. Nothing
else (description, technical_specification, dimensions) exists on either record to compare,
since both are empty beyond the short description.

#### 7.2 Confidence

**Low-Medium.** Wattage plausibility is well-supported by internal comparables; "Spider Type"
as a product-shape descriptor is an educated guess, not a sourced fact. Both records need a
supplier spec sheet (coverage area, tube type, mounting) before they could safely leave
`draft`.

---

### 8. Cross-cutting notes

- **Every one of the 10 Steelology `model_number` values fails to hold up as an exclusive
  manufacturer code** (§1.2) — this is the strongest, most defensible finding in the whole
  pass, and it needed no external search to establish.
- **One SKU's own product photo contradicts its catalogue brand** — the `SSPC-16` pressure
  cooker (§5.1) is physically stamped "Time Saver," not Steelology or anything resembling it.
  This is the single strongest piece of evidence in this file.
- **Two unrelated SKUs share an identical exact price** (KSh 208,750 — §3, §4), worth a
  sanity check.
- **The width/height swap bug that recurs across other brand passes was checked per-SKU as
  instructed, and found absent everywhere it could be checked**: `00235` has numeric fields
  that already match its own prose exactly (§3); `00241` and `00277` don't carry a
  cross-checkable prose dimension string at all, so the swap simply can't be evaluated on
  them. No affirmative swap was found on any Steelology record this pass — different from
  most other brand passes, worth recording precisely because it's the exception.
- **Data-quality smell independent of sourcing:** the 4 containers all carry an identical
  quantity of 99, and both insect killers carry an identical quantity of 50 — round,
  repeated numbers across records that otherwise differ in size/wattage, consistent with
  placeholder stock figures rather than counted inventory. Not investigated further; flagged
  for whoever owns inventory data.

---

### 9. Product reference

| SKU | Catalogue name | Model | Real identity found | Confidence |
|---|---|---|---|---|
| IMG/BUF/00241 | Digital SS Rectangular Chaffing Dish 9 Ltrs | `RH002` | Confirmed by own live site (content matches); **model number reused** for a 6.5L sibling (`IMG/BUF/00240`, live-only); live site's own "Square" title is the outlier, not our record | **Medium-High** |
| IMG/BUF/00235 | Dish Warmer Glass Top - Sunk in Model | `SUNK IN` (descriptor, not code) | Not externally sourced; internally consistent (no dim swap, photo matches description) | **Low** |
| IMG/BUF/00277 | Double Bulb Induction w/ 2 Copper Chafing Dishes | *(empty)* | Not externally sourced; photo resolves the "induction vs bulb" naming as a combo unit, not a contradiction | **Low** |
| IMG/HYS/00266 | SS Container 100X100MM | *(none)* | Probable round bain-marie/soup-well insert pot, Ø100×100mm, ≈0.79L brim-full; **likely miscategorised under Hygiene** | **Low** |
| IMG/HYS/00267 | SS Container 125X135MM | *(none)* | As above, Ø125×135mm, ≈1.66L | **Low** |
| IMG/HYS/00268 | SS Container 150X165MM | *(none)* | As above, Ø150×165mm, ≈2.92L | **Low** |
| IMG/HYS/00269 | SS Container 190X200MM | *(none)* | As above, Ø190×200mm, ≈5.67L | **Low** |
| IMG/HYS/00281 | Insect Killer 30W Spider Type | `30W` (= wattage, not code) | Wattage plausible vs. Berjaya/Maysin comparables (both 40W); "Spider Type" unverified | **Low-Medium** |
| IMG/HYS/00282 | Insect Killer 45W Spider Type | `45W` (= wattage, not code) | As above; distinct (not copy-pasted) framing from the 30W sibling | **Low-Medium** |
| IMG/HOT/00167 | Pressure Cooker 16 Litres SSPC-16 | `SSPC-16` | **Photo shows "Time Saver" branding**; `SSPC-<litres>` grammar and "Timesaver Pressure Cooker" description phrase shared with HK-REDLINE `SSPC-25` and GENEVA `SSPC-40`/`SSPC-60` in this same catalogue | **Medium** (brand ID is photo-confirmed; no external manufacturer page found) |

---

### 10. Image sourcing — `Desktop/ecommerce/products resource/steelology-images/`

**Superseded by the July 2026 image-sourcing pass — see §10A below.** The original note
(0 files kept, general web search non-functional) is retained only as history. The
re-run reached the same abstention conclusion on 9 of 10 SKUs, but by a different and
better-evidenced route, and it produced one file plus several load-bearing findings that
the first attempt missed because it skipped the 4 already-imaged SKUs.

---

### 10A. Image sourcing re-run (July 2026) — all 10 SKUs re-examined, including the 4 with existing images

**1 file kept.** The scope error in the first pass was skipping the 4 SKUs that already had
a catalogue image. Re-opening those four is what produced the strongest evidence in this
whole file (§10A.1). Every file below was opened and visually inspected.

| File | Pixels | Size | Source | Verdict |
|---|---|---|---|---|
| `IMG-HOT-00167__REF__time-saver-brand-12L-aluminium-inner-lid.png` | **1280 × 1280** | 549 KB | https://5.imimg.com/data5/SELLER/Default/2023/3/295194336/CR/IC/QS/65801768/12-litre-aluminium-pressure-cooker.png | **`REF__` — right brand, wrong product.** Verified visually: a genuine **"Time Saver"**-branded commercial pressure cooker (12 L, hard-anodised aluminium, inner lid, bar handle), sold by JKS Kitchen Ware, New Delhi. This is third-party proof that **"Time Saver" is a real trading brand**, which §5.1 could previously assert only from our own photo. It is **not** our unit: ours is 16 L, stainless, clamp-lid with a pressure gauge, and its logo lockup differs (see §10A.2). Kept as brand evidence, not as a product photo. |

Sourcing note: IndiaMART's CDN serves size-suffixed derivatives (`-250x250`, `-500x500`);
**stripping the suffix returns the original** — here 500×500 → 1280×1280. Same class of
trick as the Made-in-China `2f0j00…` rewrite, worth reusing on any `imimg.com` URL.

#### 10A.1 ⚠ The four `SSPC` records share only TWO photographs between them

This is the single most important result of the re-run, and it needed no web source — just
hashing and opening the files the first pass declined to re-check:

| SKU | Capacity | Catalogue brand | Stored file | Bytes | Pixels |
|---|---|---|---|---|---|
| IMG/HOT/00167 | 16 L | **STEELOLOGY** | `pressure-cooker-16-litres-sspc-16-imghot00167.jpg` | **18,437** | 600×600 |
| IMG/HOT/00168 | 25 L | **HK-REDLINE** | `pressure-cooker-25-litres-h-kitchen-sspc-25-imghot00168.jpg` | **18,437** | 600×600 |
| IMG/HOT/00169 | 40 L | GENEVA | `pressure-cooker-40-litres-imghot00169.jpg` | **25,557** | — |
| IMG/HOT/00170 | 60 L | GENEVA | `pressure-cooker-60-litres-imghot00170.jpg` | **25,557** | — |

The 16 L and 25 L files are **byte-for-byte the same size and visually indistinguishable**
(MD5 differs only by a re-encode); the 40 L and 60 L pair likewise. **Four SKUs, two
photographs, three "brands."**

§5.2 argued from code grammar and description text that `SSPC-16`/`-25`/`-40`/`-60` are one
generic product line wearing three different house labels. **The image data now proves it
independently**: whoever built this catalogue had one photo per *pair* of sizes and applied
it across the STEELOLOGY/HK-REDLINE brand boundary without alteration. A genuine
multi-brand sourcing arrangement would not share artwork this way.

It also means **no `SSPC` record has a size-specific photograph.** The 16 L and 25 L images
cannot both be accurate; at most one is, and nothing in the catalogue says which.

#### 10A.2 The "Time Saver" stamp, read properly — and how it compares to the real brand

The `IMG/HOT/00167` logo region was cropped and resampled 7× to read it definitively. It is
**"Time Saver"** in red type over a **blue lens/diamond**, with a **™**. §5.1's reading is
confirmed, not merely plausible.

⚠ **But the sourced Time Saver product carries a different lockup** — white type on a
**red oval with a yellow diamond** (JKS Kitchen Ware's range). Same brand *name* and the
same diamond motif; different execution. Two readings are open, and this pass cannot
choose between them:

1. one brand with more than one logo generation / sub-range, or
2. two unrelated proprietors of a fairly generic name.

Independent corroboration that "Time Saver" is a real commercial-cookware brand (all three
are aluminium ranges, none is our stainless gauge model):
https://www.indiamart.com/proddetail/12-litre-time-saver-aluminium-pressure-cooker-2850570895173.html
https://www.indiamart.com/proddetail/8-litre-time-saver-aluminium-pressure-cooker-2850570877988.html
https://vadiraja.com/product/time-saver-isi-mark-commercial-hard-anodized-aluminum-handi-pressure-cooker-silver-30l/
https://www.amazon.in/Aashreya-Time-Saver-Commercial-Aluminium/dp/B07D5VW6PV

**No source was found anywhere for a Time Saver stainless clamp-lid cooker with a pressure
gauge** — the actual object in our photo. Marketplace results for that description return
industrial jacketed cooking tanks (100–1500 L), a different machine entirely.

#### 10A.3 The other three already-imaged SKUs — checked, no contradiction found

| SKU | Stored image | Pixels | Verdict |
|---|---|---|---|
| IMG/BUF/00241 `RH002` | digital chafer | 526×524 | Shows a **rectangular** pan with a black-framed hinged glass lid and a digital readout. **Confirms §2** — the stored "Rectangular" name is right and the live site's "Square" is the error. No contradiction. |
| IMG/BUF/00235 `SUNK IN` | dish warmer | 800×377 | Long low black-glass drop-in surface, consistent with the record. No contradiction. |
| IMG/BUF/00277 double-bulb | induction set | 462×462 | Two rose-gold **hammered, lidded** pots, each on its own induction zone with a per-zone digital display, each under a **dome lamp on a curved arm**. **Confirms §4's combo-unit reading.** No contradiction. |

All three are **below the 800 px bar** (and 00241/00277 are barely 500 px), so all three
would benefit from a re-shoot even though none is *wrong*. No independent external match
was found for any of them.

#### 10A.4 The 4 containers — the dressing-drum hypothesis was tested and **rejected**

§6 left the shape open (round bain-marie insert vs square tin). The re-run tested a third
reading that fits the "Hygiene" filing far better than either: that these are **hospital
sterilising / dressing drums**, which are cylindrical, sold in a graduated mm ladder, and
would make `IMG/HYS` correct rather than a miscategorisation (§6.2).

**It does not hold.** Published dressing-drum ladders are consistently **diameter ≥ height**
and start at 150 mm:

| Source | Ladder (mm) |
|---|---|
| ASCO Medical (19 sizes, `DD8100`–`DD8118`) | 150×100, 150×150, 200×150, 200×200, 225×112 … 375×300 |
| SMS Industries | 150×150, 180×180, 230×230, 280×240, 380×300 |
| CareInstru (single unit) | 150×100 |
| Golden Star Surgical | 180×105 |
| **Our four records** | **100×100, 125×135, 150×165, 190×200** |

Ours are the opposite proportion — **height slightly exceeds diameter in three of four**
(ratios 1.00, 1.08, 1.10, 1.05) — and the ladder starts 50 mm below where commercial drums
begin. Dressing drums are shallow and wide; these are tall and narrow. **Hypothesis
excluded.**

https://www.ascomedical.com/product/dressing-drums/
https://smsindus.com/product/hollow-wares-stainless-steel/dressing-drums/dressing-drums/
https://www.careinstru.com/product/dressing-drum-26675-150x100mm/
https://goldenstarsurgical.com/product/shallow-sterilizer-dressing-drum-180-mm-x-105-mm/

**Net effect on §6:** the *round* reading survives (a tall round vessel is exactly the
h ≳ d proportion these numbers describe, and still explains why only two numbers are
given); the specific bain-marie-insert identification remains **unconfirmed**; and §6.2's
miscategorisation flag **stands**, because the one product type that would have justified
"Hygiene" has now been ruled out. **No photograph was found for any of the four**, so the
shape question is narrowed but not settled.

#### 10A.5 The 2 insect killers — "Spider Type" re-probed, still meaningless

Re-probed against Made-in-China (`spider type insect killer`) and IndiaMART. Made-in-China
returns **aerosol insecticide sprays and fly swatters**; IndiaMART returns real commercial
UV-tube fly killers (Moski Kill `MKZ015F` 30 W, `MKZ002F` 40 W, Airex 15/25/40 W double-tube)
— the right *category*, but every one is a specific named brand's product and none is
described as "spider type" by anyone. **"Spider Type" returns nothing in any supplier
vocabulary.** Attaching a Moski Kill or Airex photo would assert a brand identity the record
does not have. **Deliberate abstention; both remain without an image.**

#### 10A.6 Scoreboard

| Outcome | SKUs |
|---|---|
| New file sourced | **1** (00167, `REF__` brand evidence only) |
| Existing stored image re-verified, no contradiction | **4** (00241, 00235, 00277, 00167) |
| Proven unsourceable this pass | **9** (00241, 00235, 00277, 00266-269, 00281, 00282 — no independent third-party photo of the actual product exists for any) |
| Load-bearing contradiction found | **1** (00167/00168 share a photograph across two brands — §10A.1) |

Nothing has been copied into `storage/app/public/products/` and neither `products.json` nor
`brands.json` was touched. sheffieldafrica.com was **not** used as an image source anywhere.

---

### 11. Recommended changes (none applied)

Ordered by value. No `model_number` change is proposed anywhere, per
[[feedback_model_number_unique_id]].

**Tier 1 — free wins, no supplier input needed**

1. **Fill `IMG/HOT/00167`'s empty `description`** with "Timesaver Pressure Cooker; 16 litres"
   — the exact formula its own catalogue siblings (`SSPC-25`, `SSPC-40`, `SSPC-60`) already
   use, now corroborated by the product photo itself (§5).
2. **Flag the `RH002` price/name findings** to whoever owns storefront copy: fix the live
   site's "Square" title on `IMG/BUF/00241` (product 1038) to "Rectangular" per the actual
   photo/dimensions, and be aware `RH002` is shared with the 6.5L `IMG/BUF/00240` (§2).
3. **Sanity-check the KSh 208,750 exact-price coincidence** between `IMG/BUF/00235` and
   `IMG/BUF/00277` (§3/§4/§8) — two unrelated products at an identical price.

**Tier 2 — needs a supplier answer first**

4. **Confirm shape/material for the 4 containers** before writing any description or adding
   dimensions as structured fields (§6) — round vs square changes the volume math, and no
   capacity is stated anywhere to check against.
5. **Obtain spec sheets for both insect killers** (§7) — coverage area, tube type, mounting,
   and what "Spider Type" actually refers to are all unknown; both are `draft` and should
   stay that way until sourced.
6. **Obtain dimensions for `IMG/BUF/00277`** (§4) — currently has none stored and none found.

**Tier 3 — data-model / category decisions**

7. **Reconsider the "Hygiene" category on all 4 containers** (§6.2) — nothing about a bare
   stainless container connects to sanitation the way every other Hygiene-filed product does;
   "Buffet & Servery" fits better if the bain-marie-insert reading is right.
8. **Decide what "STEELOLOGY" should mean going forward** (§1) — same fork Kitchenware faced:
   keep it as an explicit, acknowledged house label, or split by real source once known (the
   pressure cooker's real brand is "Time Saver," confirmed by photo). Until then, leave
   `website_url` null — the one real Steelology company found (§1.1) is very likely
   unconnected, small, and not evidenced to trade with Kenya.
