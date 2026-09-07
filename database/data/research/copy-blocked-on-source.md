# Product copy blocked on source data — superseded 2026-09-04

This was a hand-built snapshot of the rows whose copy could not be written because the record
held no specification. It is **superseded by a generated equivalent**, for the same reason
`publish-readiness.csv` was: a hand-built list is stale the moment any data arrives, and reads
as current anyway.

> **Use [`supplier-requests.md`](supplier-requests.md) instead**, and regenerate it with
> `php artisan catalogue:supplier-requests --write` after any harvest.

The generated version is also a wider and more accurate cut. This file counted only rows with a
*copy-shaped* failure; the command counts every published row failing the copy standard on any
structural ground while holding fewer than four informative specification rows — which is the
real population needing a supplier. That is **76 rows across 18 brands, 37 holding no
specification at all**, against the 82 recorded here.

It further produces one sendable sheet per brand under `supplier-requests/`, listing per SKU
exactly which figures are missing and, deliberately, not asking for the ones already on file.

The reasoning this file recorded still stands and is worth keeping:

> Do not pad a thin row to hit 120 words. The rows under 90 words are thin because their source
> data is thin, not because the writing was lazy. **Padding invents facts.**

Where a row's bullets are marketing assertions ("Industrial Capacity", "HK-Redline Reliability",
"Durable Construction"), that is the symptom — there was nothing factual to put there. Section V
of `catalogue-open-issues.md` establishes the other half: the live site cannot close this gap,
because 70 of these rows do not exist there in any addressable form.
