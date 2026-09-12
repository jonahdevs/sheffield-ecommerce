# Meta descriptions: what buyers actually search for

Research date 2026-09-09. Method: Google SERPs run with `gl=ke` (Kenyan results) for four
representative categories, reading the "People also search for" block, the ranking competitors'
own meta descriptions, and how Google currently renders our pages. Plus an audit of the 644 meta
descriptions we have already authored in `products.json`.

Written **before** filling the 867 empty `meta_description` fields on the live site, because the
template we already use turns out to be only half right.

---

## 1. What we currently do

644 of our 683 products carry an authored meta.

| | |
|---|---|
| Length | median 137, p90 155, max 160 chars; 594 sit in the 110-160 band |
| Names a place | 96% (611 "Kenya", 10 "East Africa", **0 "Nairobi"**) |
| Opens with the brand | 546 of 644 |
| Uses a commercial verb | 11 of 644 (`supplied` 6, `stocked` 2, `available` 2) |

Typical: *"Skymsen E3 3mm slicing disc for the PA-7 vegetable processor, producing thin even
vegetable and cold-cut slices. Commercial kitchen accessory in Kenya."*

---

## 2. What the SERP evidence says

### 2.1 The query pattern is noun + place + **price**

"People also search for" was dominated by the same modifiers in every category tested:

| Category searched | Modifiers Google reports |
|---|---|
| commercial deep fryer kenya | used, small, **price**, best, electric, jumia |
| bain marie kenya | **prices**, **price list**, prices in kenya |
| silicone baking mould kenya | wholesale, **price list**, **price**, nairobi, jumia |
| scrubber dryer kenya | used, **price**, small, industrial, best, electric |

**Price appears in every single one.** Capacity/size, power source (electric vs gas) and
new-vs-used are the next most common. Our metas use none of these words.

### 2.2 Brand-first is right for only half the catalogue

Two distinct buyer behaviours showed up:

* **Commodity kitchen equipment** — fryers, bain maries, tables, sinks, racks. Buyers search the
  **generic noun**, not the brand. Nobody searches "HY-836"; they search "bain marie kenya price".
  A brand-first meta on these wastes the opening words on a term nobody types.
* **Professional branded lines** — Rational, Taski, Silikomart, and anything competing with
  Kärcher. Here brand and model genuinely are the query. Google's own AI overview for scrubber
  dryers names *"TASKI: Available through suppliers like Sheffield"*, and lists competitor models
  by code (BD 50/50 C, BR 30/4 C). Brand-first is correct here.

⭐ So the template must **branch on whether the brand is a search term**, not be applied uniformly.

### 2.3 We already rank — and the snippet is the problem, not the position

`sheffieldafrica.com` ranked **first or second organically** for "bain marie kenya", "commercial
deep fryer kenya" and "silicone baking mould kenya". Position is not the issue.

But our **product** pages with no meta get a snippet auto-built from the description, and before
the restructuring pass that description was a bullet dump. Google rendered:

> **Bain marie with hot cupboard 3 containers - Nairobi**
> Stainless steel Bain Marie with: · Double sliding doors · Hot cupboard · Water well with wet
> element of 2.5 kW · Drainage with ball valve · 1shelf · Double pannel for ...

Fragmented, and it publishes our typos (`1shelf`, `pannel`). Compare the competitors who author
theirs:

* Nairobi Kitchen Care — *"Keep food at the perfect temperature with our commercial Bain Maries.
  Ideal for buffets and restaurants in Kenya."*
* Techwin — *"Space-saving drop-in bain marie for hotels, restaurants & catering. Stainless steel
  hot food display with GN pans & energy-efficie…"*
* Shine Kitchenware — *"Buy Bain Marie in Kenya from Shine Kitchenware. Durable, efficient, and
  perfect for restaurants, hotels, and catering."*

All three lead with the **generic noun**, name the **audience**, and place it in **Kenya**.

### 2.4 The audience nouns are consistent and worth carrying

Across competitor metas and our own category pages: **restaurants, hotels, cafes, buffets,
catering, canteens, bakeries**. Google's AI overview reaches for the same set. These are cheap to
include and match how buyers describe themselves.

### 2.5 "Nairobi" is missing from our metas entirely

611 metas say "Kenya", none say "Nairobi" — yet our own **page titles already append "- Nairobi"**,
competitors put Nairobi in their metas, and the local pack is Nairobi-based. Worth using Nairobi
where the phrase allows, since it is the higher-intent term for a buyer who wants to collect.

### 2.6 A live defect found while looking

Our **Floor Cleaning category** meta renders as:

> *"Buy Floor Cleaning in Kenya from Sheffield Africa. SCRUBBER DRYERS 15 VACUUMS"*

The category template did not fill properly and has leaked nav text into the description. Category
metas are outside this product pass but this one should be fixed.

---

## 3. Recommended template

Two variants, chosen by whether the brand is a search term.

**A. Commodity — lead with the generic noun** (bain maries, fryers, tables, sinks, racks,
trolleys, cooking ranges, grills, shelves)

> `<Generic noun>, <headline spec>. <Model>. For <audience> in Kenya. Buy online from Sheffield Africa.`

*Oval chafing dish, 5.5 litres in stainless steel. Model HY-836. For hotels, caterers and buffets
in Kenya. Buy online from Sheffield Africa.* (146 chars)

**B. Branded professional — lead with brand and model** (Rational, Taski, Silikomart, Cambro,
Brema, Rancilio, Skymsen)

> `<Brand> <Model> <generic noun>, <headline spec>. For <audience> in Kenya.`

Unchanged from what we already do, because the evidence supports it for these brands only.

**Rules for both**
* 110-160 characters. Our existing distribution already respects this.
* The **generic noun must appear**, whichever variant is used.
* Include one **headline number** (litres, mm, kW, pan count) — it is what distinguishes the
  product from the 92 competing listings on Jiji.
* Name the **audience** from the standard set.
* End with **Kenya**, or **Nairobi** where it reads naturally.
* ⚠ Do **not** write a price into the meta. Prices change, the field is not maintained per-price,
  and Google already pulls price from structured data. Including the *word* "price" is not worth
  a false promise.
* ⚠ Do not invent specs. Where the record has no number, drop the spec clause rather than pad it.

---

## 4. What this does not settle

* **Whether writing metas is "adding facts".** Under the standing no-invention rule these metas
  must be assembled from the product's own name, brand, model and existing specs. The audience
  phrase and "Buy online from Sheffield Africa" are boilerplate, not claims about the product.
  That needs the user's sign-off before any write.
* **The 142 products with no item code** cannot be written at all regardless of copy.
* No keyword-volume data was available. This is SERP-pattern evidence, not search-volume evidence;
  Search Console would settle relative demand if access exists.

Sources: Google SERPs (gl=ke) for the four queries above; competitor metas from nkc.co.ke,
techwin.co.ke, shinekitchenware.co.ke, karcherstore-eastafrica.com; our own
`sheffieldafrica.com` category and product listings.
