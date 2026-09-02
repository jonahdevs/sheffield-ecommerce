<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

// ProductSeeder reads products.json by exact key name, so a row that misspells one
// persists null without anything failing - the product just goes live missing that
// field. Fourteen rows once stored the product code under "model" instead of
// "model_number" and seeded no code at all. These checks are pure JSON validation,
// so they need no seeding.

/** @return array<int, array<string, mixed>> */
function catalogueRows(): array
{
    return json_decode(File::get(database_path('data/products.json')), true);
}

it('stores every product code under model_number', function () {
    // "model" is the specific misspelling that caused the silent data loss, so it is
    // called out separately from the allowlist below to keep the failure readable.
    $strays = collect(catalogueRows())
        ->filter(fn ($row) => array_key_exists('model', $row))
        ->map(fn ($row) => $row['sku'].' → '.$row['model'])
        ->values()
        ->all();

    expect($strays)->toBe([]);
});

it('gives every product a model_number', function () {
    $missing = collect(catalogueRows())
        ->reject(fn ($row) => array_key_exists('model_number', $row))
        ->pluck('sku')
        ->all();

    expect($missing)->toBe([]);
});

it('keeps market framing out of short_description', function () {
    // The PDP renders short_description as customer-facing rich text under the title,
    // while meta_description feeds the <meta> tag. The catalogue was originally seeded
    // with SEO copy in short_description, so shoppers were shown search-engine text.
    // This once only checked enriched rows, and 63 unenriched ones kept their SEO copy
    // for months as a result. It now covers every row: short_description is a scan
    // line for the product, and market framing belongs in meta_description.
    $leaks = collect(catalogueRows())
        ->filter(fn ($row) => preg_match('/\b(Kenya|Kenyan|Nairobi|East Africa|Mombasa|Africa)\b/i', $row['short_description'] ?? ''))
        ->pluck('sku')
        ->all();

    expect($leaks)->toBe([]);
});

it('keeps market framing out of variant descriptions too', function () {
    // A variant's description is not a long description - product.blade.php renders it in
    // the SAME slot as the parent's short_description, as the @if branch that precedes it.
    // So it is customer-facing copy under the title and market framing leaks there exactly
    // as it would above. Unconditional rather than scoped to enriched rows, because a
    // variant description is only ever written as part of the copy pass.
    $leaks = collect(catalogueRows())
        ->flatMap(fn ($row) => collect($row['variants'] ?? [])
            ->filter(fn ($variant) => preg_match('/\b(Kenya|Kenyan|Nairobi|East Africa|Mombasa|Africa)\b/i', $variant['description'] ?? ''))
            ->pluck('sku'))
        ->values()
        ->all();

    expect($leaks)->toBe([]);
});

it('never publishes a product without a price to sell it at', function () {
    // A published row with no price shows "Request quote" on the card and, when it is
    // also flagged quote-only, an add-to-cart the PDP cannot honour. Five SV-Blueline
    // counter units and two Santos juice dispensers shipped in that state; they are
    // drafts now, and stay drafts until the price list carries them. Mirrors
    // ProductSeeder::hasSellablePrice() - variants and grouped/bundle children count.
    $unpriced = collect(catalogueRows())
        ->filter(fn ($row) => ($row['status'] ?? null) === 'published')
        ->reject(fn ($row) => (float) ($row['price'] ?? 0) > 0)
        ->reject(fn ($row) => collect($row['variants'] ?? [])->contains(fn ($variant) => (float) ($variant['price'] ?? 0) > 0))
        ->reject(fn ($row) => ($row['grouped_children'] ?? []) !== [] || ($row['bundle_children'] ?? []) !== [])
        ->pluck('sku')
        ->all();

    expect($unpriced)->toBe([]);
});

it('gives every enriched product a meta_description to draw SEO copy from', function () {
    $missing = collect(catalogueRows())
        ->filter(fn ($row) => str_contains($row['description'] ?? '', '<h3>')
            && str_starts_with($row['technical_specification'] ?? '', '<table'))
        ->reject(fn ($row) => filled($row['meta_description'] ?? null))
        ->pluck('sku')
        ->all();

    expect($missing)->toBe([]);
});

it('gives every product an item code', function () {
    // ProductSeeder reads $data['sku'] unguarded and uses it as the join key for
    // accessories, spare parts and grouped/bundle children. A null or missing code
    // therefore breaks seeding, and two of them would collide on the same key.
    $missing = collect(catalogueRows())
        ->reject(fn ($row) => filled($row['sku'] ?? null))
        ->pluck('name')
        ->all();

    expect($missing)->toBe([]);
});

it('formats every item code as SOURCE/GROUP/00000', function () {
    // Item codes are SOURCE (IMG imported goods, IMS imported spares, FAB locally
    // fabricated) / three-letter product group / five-digit sequence. One row once
    // read IMG/HOT/OO438 with letter-O for zero, which no length or prefix check
    // would have caught.
    // Parents are included: their key used to be an exempt "GROUP/..." string, and is
    // now a real item code, so every row in the file must satisfy the format.
    $malformed = collect(catalogueRows())
        ->pluck('sku')
        ->filter()
        ->reject(fn (string $sku) => preg_match('#^(IMG|IMS|FAB)/[A-Z]{3}/\d{5}$#', $sku) === 1)
        ->values()
        ->all();

    expect($malformed)->toBe([]);
});

it('keys each variant parent on its own default variant', function () {
    // A parent's SKU is an internal join key only - the seeder stores null for it (see
    // ProductSeeder::createProduct) because the variants own the real item codes. It
    // used to be a "GROUP/..." string, which broke the item-code format above. It is
    // now the parent's own default variant's code, so it has to actually be that: a
    // key naming some other product's code would attach variants to the wrong parent.
    $wrong = collect(catalogueRows())
        ->filter(fn ($row) => in_array($row['type'] ?? 'simple', ['variable', 'grouped', 'bundle'], true))
        ->map(function ($row) {
            $variants = collect($row['variants'] ?? []);
            $default = $variants->firstWhere('is_default', true);

            if ($default === null) {
                return "{$row['sku']} has no default variant";
            }

            return $default['sku'] === $row['sku']
                ? null
                : "{$row['sku']} is keyed off {$default['sku']}, which is not its default";
        })
        ->filter()
        ->values()
        ->all();

    expect($wrong)->toBe([]);
});

it('formats every variant item code the same way', function () {
    $malformed = collect(catalogueRows())
        ->flatMap(fn ($row) => collect($row['variants'] ?? [])->pluck('sku'))
        ->reject(fn (?string $sku) => is_string($sku) && preg_match('#^(IMG|IMS|FAB)/[A-Z]{3}/\d{5}$#', $sku) === 1)
        ->values()
        ->all();

    expect($malformed)->toBe([]);
});

it('never lets two products resolve to the same URL', function () {
    // ProductSeeder::buildSlug() honours an explicit "slug" key and otherwise derives
    // one from name + sku. An explicit slug is used to keep a URL stable when a product
    // is renamed, which means it deliberately stops matching its own name - so it can
    // silently collide with another product's derived slug. Whoever wins the collision
    // takes the other's URL.
    $seen = [];
    $collisions = [];

    foreach (catalogueRows() as $row) {
        $sku = $row['sku'] ?? '?';
        $slug = ! empty($row['slug'])
            ? Str::slug($row['slug'])
            : Str::slug(($row['name'] ?? '').' '.$sku);

        if (isset($seen[$slug])) {
            $collisions[] = $slug.' ← '.$seen[$slug].' and '.$sku;
        }

        $seen[$slug] = $sku;
    }

    expect($collisions)->toBe([]);
});

it('keeps every explicit slug well formed', function () {
    $malformed = collect(catalogueRows())
        ->filter(fn ($row) => ! empty($row['slug']))
        ->reject(fn ($row) => preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $row['slug']) === 1)
        ->map(fn ($row) => $row['sku'].' → "'.$row['slug'].'"')
        ->values()
        ->all();

    expect($malformed)->toBe([]);
});

it('uses only keys the seeder recognises', function () {
    // Derived from the catalogue as it stands. A key outside this set is either a
    // typo the seeder will silently drop, or a genuinely new field - in which case
    // add it here once ProductSeeder actually reads it.
    $recognised = [
        'accessories', 'attributes', 'brand', 'category', 'description', 'gallery',
        'height', 'image', 'length', 'meta_description', 'model_number', 'name',
        'price', 'quantity', 'requires_quotation', 'short_description', 'sku',
        'slug', 'sort_order', 'status', 'technical_specification', 'type', 'variants',
        'width',
    ];

    $unknown = [];

    foreach (catalogueRows() as $row) {
        foreach (array_diff(array_keys($row), $recognised) as $key) {
            $unknown[] = ($row['sku'] ?? $row['name'] ?? '?').' → "'.$key.'"';
        }
    }

    expect($unknown)->toBe([]);
});

it('keeps stored dimensions in step with the spec table', function () {
    // length/width/height feed filtering and the shipping estimate, while the spec
    // table's Dimensions row is what the shopper actually reads. Nothing kept the two
    // in step, so a correction applied to one silently left the other wrong. The
    // imports-team workbook proved 16 rows had been carrying a sibling model's size -
    // IMG/HOT/00189 held the 10-litre fryer's dimensions on the 15-litre record.
    $drifted = [];

    foreach (catalogueRows() as $row) {
        $stored = [$row['length'] ?? null, $row['width'] ?? null, $row['height'] ?? null];

        if (in_array(null, $stored, true)) {
            continue;
        }

        $matched = preg_match(
            '/<td><strong>(?:External )?Dimensions[^<]*<\/strong><\/td><td>([\d,]+)\s*&times;\s*([\d,]+)\s*&times;\s*([\d,]+)\s*mm/',
            $row['technical_specification'] ?? '',
            $cells
        );

        if (! $matched) {
            continue;
        }

        $tabled = array_map(fn ($cell) => (int) str_replace(',', '', $cell), array_slice($cells, 1));

        if ($tabled !== $stored) {
            $drifted[] = $row['sku'].' → stored '.implode('×', $stored).', table '.implode('×', $tabled);
        }
    }

    // Pre-existing drift, catalogued 2026-09-02 so that NEW drift fails this test.
    // Most are axis-order permutations of the same three numbers rather than different
    // measurements; see database/data/research/imported-items-crosswalk.md §C.
    $known = [
        'IMG/FPR/00177', 'IMG/FPR/00212', 'IMG/FPR/00008', 'IMG/FPR/00181',
        'IMG/BUF/00129', 'IMG/BUF/00130', 'IMG/FPR/00027', 'IMG/REF/00034',
        'IMG/REF/00035', 'IMG/OVE/00230', 'IMG/OVE/00018', 'IMG/OVE/00017',
        'IMG/PAS/00003', 'IMG/HOT/00063', 'IMG/BUF/00231', 'IMG/HOT/00333',
        'IMG/HOT/00390', 'IMG/BUF/00155', 'IMG/HYS/00003', 'IMG/COF/00071',
        'IMG/ICE/00027', 'IMG/ICE/00028', 'IMG/DWW/00085', 'IMG/DWW/00093',
        'IMG/HOT/00049',
    ];

    $unexpected = array_values(array_filter(
        $drifted,
        fn ($entry) => ! in_array(Str::before($entry, ' →'), $known, true)
    ));

    expect($unexpected)->toBe([]);
});
