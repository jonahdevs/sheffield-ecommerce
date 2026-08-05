# Variant-child SKUs - a blind spot across the whole enrichment effort

Found 2026-07-30 while building the RATIONAL dossier.

## What it is

16 products in products.json have `"type": "variable"` and a `variants` array. Those arrays
reference **49 child SKUs that have no top-level record of their own**. They exist only as
objects nested inside their parent.

Every tool built for this effort - the dossier builder, the SAP reconciliation, the stock
applier, the dimension appliers, the coverage audit - iterates **top-level records**. So all
49 children have been invisible to all of it, from the beginning.

The real sellable SKU count is **683 top-level + 49 children = 732**, not 683.

## Distribution

| brand | hidden children | SAP rows |
|---|---|---|
| RATIONAL | 20 | 20 |
| PRADEEP | 10 | 10 |
| BILGE | 6 | 6 |
| PRISMA FOOD | 5 | 5 |
| SKYMSEN | 4 | 4 |
| HDS | 2 | 2 |
| BERJAYA | 2 | 2 |

**All 49 join to SAP on `Item No.` = `sku`.** Nothing about them is unverifiable; they were
simply never looked at. Note that PRADEEP, SKYMSEN, BILGE, PRISMA FOOD, HDS and BERJAYA are all
brands whose passes were previously called finished - those passes were incomplete.

## What is actually wrong in them

The children carry their own `width`, `height`, `length`, `stock_quantity`, `price`,
`model_number` and `image`, so they can hold every defect a top-level row can.

- **Stock is stale on 27 of the 49.** The 325-SKU SAP stock update never reached them.
  `IMG/TCW/00127` shows 2 against SAP's 133. `IMG/TCW/00128` shows 26 against SAP's 181.
  `IMG/TCW/00126` shows 121 against SAP's 66. These are large, customer-visible errors.
- **At least one clean axis swap.** `IMG/HOT/00344` (HDS) stores 1182 x 767 where SAP has
  767 x 1182 - exactly the transposition class already fixed for 34 top-level SKUs.
- **Dimension disagreements.** e.g. `IMG/FPR/00033` (Skymsen 3 L blender) stores 275 x 630
  against SAP's 240 x 255; the 5 Prisma Food mixers all disagree substantially.

## Applied 2026-07-30

Root fix first: `dossier.py` now flattens `variants` into its row set, carrying the parent's
brand and category down onto the child (the child object has neither). RATIONAL went from 32
SKUs to 52 as a result. It also now scans `research/old/` for pointers, which it had stopped
doing when the pre-SAP files were archived.

Then, scoped exactly as the top-level pass was:

- **27 stock corrections** taken from SAP, which is authoritative for stock. Largest:
  `IMG/TCW/00127` 2 -> 133, `IMG/TCW/00128` 26 -> 181, `IMG/TCW/00126` 121 -> 66,
  `IMG/OVE/00058` 80 -> 28, `IMG/OVE/00031` 39 -> 5.
  Two SKUs dropped to zero: `IMG/OVE/00029` (was showing 32) and `IMG/COF/00114` (was 7).
- **4 dimension transpositions** reordered - same two values, wrong order, so no value is
  invented. `IMG/HOT/00344` and `IMG/HOT/00345` (HDS gas fryers) 1182x767 -> 767x1182: a
  1182 mm-wide fryer only 767 mm tall is impossible against a standard worktop height.
  `IMG/OVE/00032` and `IMG/OVE/00035` (Rational granite-enamelled GN pans) 60x325 -> 325x60:
  the model names literally read "1/1 60 mm" and "2/3GN 60mm", and GN 1/1 is 530 x 325, so
  60 is the pan depth.

Verified after write: 683 top-level records intact, all 49 children reconciled, 0 stock still
differing, 0 swaps out of order, CRLF and no-trailing-newline preserved.
`ProductCatalogueKeysTest` 9/9 green. Backup at `products.json.bak-variantfix-20260730163233`.

## Deliberately NOT applied - 9 dimension value conflicts

Per the standing rule (SAP's dimension *order* is trustworthy, its *values* are not), these
were left alone rather than overwritten:

| SKU | brand | ours W x H | SAP W x H |
|---|---|---|---|
| IMG/FPR/00033 | SKYMSEN | 275 x 630 | 240 x 255 |
| IMG/FPR/00034 | SKYMSEN | 275 x 630 | 275 x 260 |
| IMG/FPR/00036 | SKYMSEN | 330 x 750 | 290 x 280 |
| IMG/FPR/00037 | SKYMSEN | 340 x 780 | 290 x 280 |
| IMG/PAS/00012 | PRISMA FOOD | 385 x 725 | 415 x 795 |
| IMG/PAS/00013 | PRISMA FOOD | 435 x 810 | 735 x 805 |
| IMG/PAS/00014 | PRISMA FOOD | 480 x 850 | 805 x 828 |
| IMG/PAS/00015 | PRISMA FOOD | 480 x 850 | 805 x 828 |
| IMG/PAS/00016 | PRISMA FOOD | 535 x 915 | 805 x 828 |

Two reasons for caution beyond the standing rule. SAP gives **the same 805 x 828 for three
different Prisma Food mixer sizes** (20/30/40 L), which reads like a carton or pallet figure
rather than a machine. And SAP's 255 mm height for a 3 L Skymsen bar blender is too short for
an upright blender with its jar fitted - our 630 is the more plausible figure. Both need a
manufacturer source to settle; neither should be taken from SAP.

## Still to do

The six brands whose children this touched - RATIONAL, PRADEEP, BILGE, PRISMA FOOD, SKYMSEN,
HDS, BERJAYA - still need their children covered by the *sourcing* pass (images, spec sheets,
copy). Stock and axis order are now correct; provenance is not yet.
