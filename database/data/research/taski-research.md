# TASKI Product Research

**This file supersedes `old/taski-research.md`.** The archived file remains the fuller
reference for naming traps, compatibility charts and machine specs, and its factual content was
verified rather than discarded. This file records the **August 2026 gap-fill sourcing pass** and
the corrections it forces on the archived version.

TASKI is Diversey's professional cleaning machine brand. Solenis acquired Diversey in 2023.
Catalogue size: 52 SKUs.

> ⚠ **We store Diversey ARTICLE NUMBERS in `model_number`; SAP stores MODEL NAMES.** That
> difference is known, intentional and correct in both systems. Nothing in this pass changed
> `model_number`, and nothing here should be read as a proposal to align it to SAP.

Staging folder for this pass:
`C:\Users\jonah.wakahiu\Desktop\ecommerce\products resorce final\taski\`
Ledger: `_sourced-gapfill.json` · Write-up: `_FINDINGS-gapfill.md`

---

## 1. Scope and result

The pass owned the **25 SKUs that had no staged files at all**: `IMG/HYS/` `00106` `00124`
`00133` `00134` `00135` `00141` `00142` `00143` `00148` `00152` `00160` `00226` `00229` `00249`
`00250` `00251` `00252` `00253` `00254` `00255` `00256` `00257` `00258` `00259` `00260`.

**25 of 25 now have at least one staged image. 20 of 25 are article-number proven.**
14 clear the 800 px short-edge floor; 10 sit below it against a proven ceiling; 1 (`00255`) is
carried by representative in-situ photography only.

---

## 2. An AI-generated product photo was caught - and it was article-number keyed

This is the most important finding of the pass and it changes how the article-number heuristic
should be trusted.

`IMG/HYS/00255` **Center Broom B3300 (7524909)** is the SKU that three prior passes abstained
on. The only isolated photograph of it on the open web is:

https://www.szerek.hu/img/46010/HT7524909/HT7524909.webp

It passes every automated test. The filename carries our exact article number (`HT7524909`).
The page carries `MPN : 7524909` and `EAN : 7615400227310`, both correct. It is 1000x1000, above
the floor. The thumbnail shows a plausible cylindrical roller broom - the right shape.

**It is AI-generated**, on two independent grounds:

1. The retailer discloses it in its own spec table:
   *"Tájékoztatás : A kép a valóságtól eltérhet és AI által generált tartalmat is tartalmazhat."*
   ("The image may differ from reality and may contain AI-generated content.")
2. Rendered at 100%: bristle tufts merge into amorphous smears instead of resolving into
   filaments, the chevron rows dissolve into painterly blobs at the ends, a nonsensical fuzzy
   mass sits at lower right, and illegible pseudo-text is stamped along the core tube.

Filed at `_ai-generated\IMG-HYS-00255__7524909-szerek-hu-AI-GENERATED.webp`.

**Rule this establishes: an article-keyed filename proves the vendor's intent, not the image's
provenance.** It is the strongest signal this pipeline uses, and it did not survive contact with
a synthetic image. Only rendering caught it.

⚠ The same listing's `_altpic_1` and `_altpic_2` are genuine TASKI press photos. **Vendors mix
real and synthetic within one gallery** - apply the disclosure per-image, never per-listing.

---

## 3. `products.solenis.com` must be reclassified

`old/taski-research.md` §9.3 lists Solenis as "403 to automated access", and §12 records its
pages as an SPA yielding nothing. Both are literally true and together they undersold it.

**In a real browser the pages render a complete spec table.** They carry no images, but for a
brand where SAP holds `0` in every dimension field, Solenis is a first-class *dimensional*
source that had been written off. Its sitemap is fetchable **without** a browser:

- https://products.solenis.com/sitemap-product-1.xml
- https://products.solenis.com/sitemap-product-2.xml

31,706 product URLs, each ending in the Diversey article number. This resolved 24 of the 25
article numbers in this pass to exact product URLs.

Worked example - https://products.solenis.com/product/center-broom-b3300-1pc-7524909

| Field | Value |
|---|---|
| Product Code | 7524909 |
| EAN/UPC | 07615400227310 |
| Material L x W x H | **500 x 200 x 200 mm** |
| Net weight | 1.44 kg |
| Country of origin | DE |

---

## 4. Stored-image errors - all four confirmed by direct comparison

Each stored catalogue file was rendered rather than trusted from the earlier audit.
**Nothing in `products.json`, `brands.json` or `storage/` was edited.**

| SKU | Article | Stored image actually shows | Correct part | Action |
|---|---|---|---|---|
| `00134` | 8504750 | Brush moulded **`TASKI ergodisc 8504.770`** - adjacent grade | Pale full-coverage nylon bristle brush | Replace |
| `00152` | 7510030 | The **7510829 swingo disc** - ribbed face, **plastic** hub | Ribbed disc with **metal centre plate and central bolt** | Replace |
| `00254` | 7520152 | **Five-battery range graphic** (GF 6 180 V, GF 6 240 V, GF 12 105 V, GF 12 70 V, GF 12 50 V) | Single grey Exide/Sonnenschein gel block | Replace |
| `00255` | 7524909 | A flat disc-shaped **side broom** | 500 mm cylindrical roller | Replace; see §5 |

Two long-standing ambiguities closed in the process:

- **`00152` vs `00160`.** The article-keyed Carel Lurvink file for 7510829 matches the *stored
  00152 artwork*. So 00160 is correct and 00152 was carrying a duplicate of it. These are the
  ergodisc and swingo 43 cm discs - the pair the archive flagged as the highest wrong-part risk
  in the brand, and the error had landed on the image rather than the text.
- **`00255` vs `00256`.** Altruan's Shopify JSON returns the file
  `Seitenbesen-Balimat3300...jpg` for **both** its "Main brush" and "Side broom" listings,
  differing only by a cache suffix. Its *records* are right (`DI-7524909` / `DI-7524910`, EANs
  `7615400227310` / `7615400227327`); its *centre-broom image* is the side broom. This is where
  the catalogue error came from.

⚠ The `00254` range graphic contains **GF 6 180 V**, which is `00251`'s battery (7514962), and
none of its five blocks is labelled 76 or 81 Ah. It is wrong for that page in more ways than one.

---

## 5. `00255` Center Broom - proven by dimension, not by photograph

No genuine isolated photograph of 7524909 exists anywhere reachable. Rather than stage
something plausible, the identity was proven another way:

- Solenis gives 7524909 as **500 x 200 x 200 mm, 1.44 kg** - a cylindrical roller, not a disc.
- USA-Clean's *Main-Broom Assembly* exploded diagram
  (https://dotnet.usaclean.com/ol-cat-master/ol-catimg/hr/192-4060.gif, 1600x1626) shows the
  centre broom as a chevron-bristled roller on a horizontal axle.
- TASKI's own hopper-open press photos show the roller fitted in the machine.

The in-situ photos and the diagram are staged, tokened `REPRESENTATIVE`. **Nothing staged claims
to be an isolated studio shot of 7524909.**

---

## 6. The balimat 3300 is built by Stolzenberg - new OEM finding

Page 9 of the German user manual
(https://taski.com/wp-content/uploads/2025/08/2021_05_11_BA-balimat-3300-DE.pdf) names the
manufacturer outright under *Wichtige Verschleiss- und Ersatzteile*:

**Stolzenberg GmbH & Co. KG**, Hamburger Strasse 15-17, 49124 Georgsmarienhütte, Germany
(https://www.stolzenberg.de).

It also gives the OEM wear-part numbers sitting behind our Diversey codes:

| Part | Diversey article | Stolzenberg article |
|---|---|---|
| Flat filter | - | **100223** |
| Centre broom (*Kehrwalze PA 0,25 V*) | 7524909 | **110970** |
| Side broom (*Seitenbesen PA 0,6*) | 7524910 | **110526** |

Stolzenberg's live range is renamed (VacSweep, CrossSweep, TwinSweep, TwinTop) and carries no
listing keyed to our article numbers, so it yielded no imagery this pass. It is nonetheless a
real second-source channel for balimat 3300 wear parts and worth raising commercially.

---

## 7. Other spec findings

- **TASKI's NX battery platform is a rebadged Numatic NX300.** Both `00259` (7524891) and
  `00260` (7524892) are badged **NX300 / Numatic**, legible at 4160x4160. This also closes the
  archive's §12.5 open question about whether the two NX photos showed the same pack: the
  battery footprint matches the charger recess.
- **Water tank 8504390 is 10 litres** - re-confirmed from the official chart row
  *"8504390 Water tank 10L"*. The archive's §5.4 instruction not to publish a figure stays lifted.
- **`00250` code mismatch is now a specific number.** The archive could read only "75103xx" on
  the 7519395 hub. At 1139x870 it is legible: **`TASKI 7510305`**. Either 7510305 is a
  moulding/production code distinct from the sales SKU, or the distributor serves a neighbouring
  part on the 7519395 path. **Question for the supplier.** Staged with the `CODEMISMATCH` token
  and `code_proven: false`.
- **`00148` ergodisc duo code conflict unresolved, carried forward.** taski.com's own file is
  `8004010_ergodisc-duo.jpg`; our `model_number` is `8003990`; SAP's model field holds the name
  `ERGODISK 165 DUO`. Solenis lists `.../taski-ergodisc-duo-1pc-8003990`, which backs our number.
  Not acted on.
- **SAP dimensions unusable for this group.** All 25 SKUs carry `0` in length/width/height
  except `00252` and `00253`. Solenis supplies real per-part dimensions and should be the fill
  source. Nothing was written to `products.json`.

---

## 8. Source ranking, revised

1. **USA-Clean** (via `https://r.jina.ai/<url>`, then swap the BigCommerce stencil size segment
   for `original`) - 4160x4160 masters, and the page title *and* `MPN:` field both carry the
   TASKI article number, so it is self-proving. Best in the brand when it has the part.
   ⚠ Its `search.php` endpoint remains a trap: HTTP 200 with unrelated recommended products for
   any query. Category and product pages only.
2. **`nam.taski.com` accessory list**
   (https://nam.taski.com/wp-content/uploads/2023/05/Accessory-list.pdf) - nine 709x709 embedded
   studio thumbnails, each on a row printing the article number. Official literature, so it can
   adjudicate part identity. Map images to rows by **bounding box**
   (`get_image_rects` against `get_text("blocks")` y-coordinates), never by reading order.
3. **Carel Lurvink** -
   `https://www.carellurvink.nl/cdn-cgi/imagedelivery/X8zbrVPx1obdJ5NOL9jYkg/product/<part>.jpg/h=2000`
   is keyed to the TASKI part number, up to 1920 px. 8 hits from 21 probes this pass; productive
   but not universal.
4. **`voussert.com/Asset/PHOTOS2000/<article>_N<n>.jpg`** - **new pattern, not in any prior
   write-up.** N1-N4, 2000 px, article-keyed. Beat taski.com by ~2.5x on the balimat 3300.
   Worth probing across the brand.
5. **taski.com** - manufacturer assets; strip a `-scaled` suffix for the original
   (`TASKI_go_Staubsauger_001w-scaled.jpg` at 2560 px becomes **5500x3667**).
6. **Astral Hygiene** - largest machine art for the single discs (ergodisc duo 1900x2850).
7. **Altruan Shopify JSON** (`<handle>.json`) - reports true master dimensions and the variant
   SKU/barcode. ⚠ `?width=1946` does **not** upscale, and see §4 on its centre-broom image.

**Dead or degraded this pass:** `eshop.diversey.be` and the other `eshop.diversey.*` hosts now
301 to `products.solenis.com` - every `eshop.diversey.*` URL in `old/taski-research.md` is dead.
`lite.duckduckgo.com` returned HTTP 202 with zero results for every query.

**Bing image search survives where the others do not**, and its results carry a JSON `m`
attribute on `a.iusc` holding the full-resolution source URL plus the host page. That is how both
the szerek.hu file and Voussert's 2000 px assets were found.

---

## 9. Open questions for the supplier

1. **`00250` / 7519395** - is `7510305` a moulding code, a superseded number, or a different part?
2. **`00148` / ergodisc duo** - `8003990` or `8004010`?
3. **`00254` / 7520152** - the 76 Ah vs 81 Ah dispute in TASKI's own charts is still open; the
   sweeper chart says 81 Ah, the scrubber-drier charts say 76 Ah. Published wording remains
   "76-81 Ah - confirm with distributor".
4. **balimat 3300 wear parts** - is Stolzenberg (§6) an approved alternative supply channel?
5. Lifecycle questions from `old/taski-research.md` §5.1 remain unanswered.
