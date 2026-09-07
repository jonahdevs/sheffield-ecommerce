# Product copy standard — research and house rules

Researched 2026-08-11. Sets the shape **and the length** of the four copy fields in
`products.json`. Supersedes the informal "2-3 paragraphs" rule, which had no ceiling and no
evidence behind it.

Measured against the catalogue as it stood on 2026-08-11: 605 structurally-complete
top-level rows, median description 111 words, p90 206, max 382.

---

## 1. Why length needs a rule at all

Both ends are a real failure mode, and the catalogue currently has both.

**Too long — users skip it, then reject the product.** Baymard's testing found users skipped
long, "uninviting" descriptions, and that skipping often led to rejecting the product itself.
Bullet-and-text blocks become "feature dumps" where users miss the very features that would
have sold them.
https://baymard.com/blog/product-descriptions
https://baymard.com/blog/structure-descriptions-by-highlights

**Too short — users assume the site is not legit.** Brief descriptions make users "quickly move
on", force unnecessary assumptions, and cost them 1-3 minutes hunting the rest of the page.
Where several thin descriptions appear, users generalise it to the whole site. 90% of the top 60
e-commerce sites maintain detailed descriptions, so it is the expected baseline.
https://baymard.com/blog/product-descriptions

**Users do not read; they scan.** 79% of test users scanned every new page and only 16% read
word-by-word. Users have time to read at most **28% of the words** on an average page view.
Rewriting for concision measured **58% better usability**, for scannability **47% better**, and
combining the improvements **124% better**.
https://www.nngroup.com/articles/how-users-read-on-the-web/
https://www.nngroup.com/articles/be-succinct-writing-for-the-web/
https://www.nngroup.com/articles/concise-scannable-and-objective-how-to-write-for-the-web/

⚠ **Ignore the "1,000-1,200 words for B2B" advice** that SEO content sites repeat. It comes from
content-marketing blogs, not usability testing, and the same sources concede that adding copy to
raise word count hurts conversion. It also assumes the description is the *only* copy surface,
which on our PDP it is not — see §2.

---

## 2. The rule depends on our own page layout

`resources/views/pages/storefront/product.blade.php` renders **three separate copy surfaces**:

| Surface | Field | Where |
|---|---|---|
| Under the product title, above the fold | `short_description` (or `variants[].description`) | `:1214-1216` |
| Overview tab | `description` | Overview tab |
| Specification section | `technical_specification` | `:1800`, gated on `filled()` |

**This is the whole argument for a tight description.** The buyer already has the headline in
`short_description` and every number in the spec table. A description that restates specs is
paying for words the reader will not spend. Its job is the part neither of the other two can
do: what the machine is for, who it suits, and *why* the headline numbers matter.

---

## 3. The standard

### `description` — target **120-180 words**, hard ceiling **220**

- **2-3 `<p>` paragraphs, 40-60 words each** (~90-140 words of prose), then `<h3>` + `<ul>`.
- The `<h3>` may be `Key Features`, `Key Details`, `Compatibility` — whatever fits. Do not
  force the literal words "Key Features".
- **4-6 bullets. Hard ceiling 6.** Baymard's "feature dump" failure is exactly a long bullet
  run. Catalogue as measured: 221 descriptions carry 7+ bullets and 64 carry 10+ — that tail is
  the trim list.
- **One line per bullet, ≤ 12 words.** A bullet that wraps is a sentence in disguise.
- **Never restate a spec-table row as a bullet** unless the number is a genuine selling point
  the prose already leans on. Capacity, throughput and power usually qualify; voltage, net
  weight and carton dimensions never do.
- **Floor: 90 words.** Below that the row reads as insufficient. If there is not 90 words of
  honest material, the gap is source data, not writing — say so rather than padding.

### `short_description` — **a scan line, 8-30 words**

> ⚠ **2026-09-04 — this figure is not the one in force, and needs a decision.**
> `publish-readiness.csv` was scored at **18-38 words**, and the catalogue was written to it:
> median 25, 75% of rows between 18 and 38, only 21% inside 8-30. `App\Support\CopyStandard`
> enforces 18-38 because that reproduces the existing scoreboard exactly; adopting 8-30 instead
> would fail 173 rows rather than 166. The same split affects the bullet rule above — ≤ 12 words
> as written, ≤ 14 as scored, a 90-row versus 15-row difference.
> To settle it: change the constants in `CopyStandard`, rerun `php artisan catalogue:readiness
> --write`, and correct these two lines.

What the item is, its headline specs and its model code. Distilled from that product's own
`description`. It answers *what is this* at a glance, above the fold.

**It is not a marketing surface.** No market framing ("in Kenya", "across East Africa") and no
sales adjectives ("premium", "elegant", "advanced", "professional-grade solution"). Where the
row has no spec table, "Commercial induction hob, Lincat DK977." is a complete and correct
short description — brevity beats padding.

⚠ Guarded by `ProductCatalogueKeysTest`, which now checks **every** row. It previously checked
only *enriched* rows, and 63 unenriched ones shipped SEO copy to shoppers as a result.

### `meta_description` — **140-160 characters**

Brand + model, use case, audience, market framing. Market framing belongs *here*. Written to
length deliberately: `applySeo()` uses it verbatim and does **not** truncate it, whereas the
`short_description`/`description` fallback is stripped and capped at 160.
⚠ 82 rows currently exceed 160 characters (max 284) and will be cut off in search results.

### `technical_specification` — `<table>`, Brand then Model first

- **Group into sub-sections above 20 rows.** Baymard: spec sheets past ~20 specs need titled
  sub-sections to stay scannable; 23% of sites fail this.
  https://baymard.com/blog/spec-sheet-scannability
- Catalogue as measured: median 9 rows, p90 16, **max 25 — 10 tables exceed 20** and are the
  grouping candidates.
- **Single column.** Multi-column spec sheets get misread as comparison charts (20% of sites
  get this wrong).
- Omit any value the research records as *disputed* rather than publishing it.

---

## 4. Ordering within the description

Users scan a heading, and only read the paragraph beneath it if the heading confirmed what the
scan suggested. So front-load: the first sentence must say what the product *is* in plain words.
Do not open with a brand story, a market claim, or a subordinate clause.

High-converting descriptions answer three questions in order — what problem it solves, what
exactly you get, and why you should trust it. Our spec table answers the second; the prose
should carry the first and third.

---

## 5. What this does NOT license

- **Do not pad a thin row to hit 120 words.** The 206 rows under 90 words are thin because
  their source data is thin (SAP Remarks on the house brands), not because the writing was
  lazy. Padding invents facts.
- **Do not cut a long row by deleting information.** Trim by moving spec restatements out of
  the bullets and into the spec table where they already belong, and by cutting sentences that
  assert rather than inform.

---

## 6. Sources

https://baymard.com/blog/product-descriptions
https://baymard.com/blog/structure-descriptions-by-highlights
https://baymard.com/blog/spec-sheet-scannability
https://baymard.com/research/product-page
https://www.nngroup.com/articles/how-users-read-on-the-web/
https://www.nngroup.com/articles/be-succinct-writing-for-the-web/
https://www.nngroup.com/articles/concise-scannable-and-objective-how-to-write-for-the-web/
