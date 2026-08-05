<?php

use Illuminate\Support\Facades\File;

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

it('keeps market framing out of short_description on enriched products', function () {
    // The PDP renders short_description as customer-facing rich text under the title,
    // while meta_description feeds the <meta> tag. The catalogue was originally seeded
    // with SEO copy in short_description, so shoppers were shown search-engine text.
    // Scoped to rows already enriched (structured description + spec table) so the
    // products still awaiting a rewrite don't fail this.
    $leaks = collect(catalogueRows())
        ->filter(fn ($row) => str_contains($row['description'] ?? '', '<h3>')
            && str_starts_with($row['technical_specification'] ?? '', '<table'))
        ->filter(fn ($row) => preg_match('/\b(Kenya|Kenyan|Nairobi|East Africa|Mombasa|Africa)\b/i', $row['short_description'] ?? ''))
        ->pluck('sku')
        ->all();

    expect($leaks)->toBe([]);
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

it('uses only keys the seeder recognises', function () {
    // Derived from the catalogue as it stands. A key outside this set is either a
    // typo the seeder will silently drop, or a genuinely new field - in which case
    // add it here once ProductSeeder actually reads it.
    $recognised = [
        'accessories', 'attributes', 'brand', 'category', 'description', 'gallery',
        'height', 'image', 'length', 'meta_description', 'model_number', 'name',
        'price', 'quantity', 'requires_quotation', 'short_description', 'sku',
        'sort_order', 'status', 'technical_specification', 'type', 'variants', 'width',
    ];

    $unknown = [];

    foreach (catalogueRows() as $row) {
        foreach (array_diff(array_keys($row), $recognised) as $key) {
            $unknown[] = ($row['sku'] ?? $row['name'] ?? '?').' → "'.$key.'"';
        }
    }

    expect($unknown)->toBe([]);
});
