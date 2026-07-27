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
