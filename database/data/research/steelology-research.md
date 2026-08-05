# Steelology Product Research

**Supersedes `research/old/steelology-research.md`** (July 2026, pre-SAP). That file remains
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

⚠ **This corrects `old/steelology-research.md` §10A.1**, which concluded "four SKUs, **two**
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
