<?php

use App\Support\MediaNaming;
use Illuminate\Support\Facades\File;

// products.json points at image files by path, but nothing fails loudly when one is
// missing — the seeder just skips it and the product goes live with no photo. These
// checks are pure file/JSON validation, so they need no seeding.

/** @return array<int, array<string, mixed>> */
function catalogue(): array
{
    return json_decode(File::get(database_path('data/products.json')), true);
}

function publicPath(string $path): string
{
    return storage_path('app/public/'.$path);
}

it('has every image declared in products.json present on disk', function () {
    $missing = [];

    foreach (catalogue() as $product) {
        foreach ([$product['image'] ?? null, ...($product['gallery'] ?? [])] as $path) {
            if (! empty($path) && ! File::exists(publicPath($path))) {
                $missing[] = $product['sku'].' → '.$path;
            }
        }

        foreach ($product['variants'] ?? [] as $variant) {
            if (! empty($variant['image']) && ! File::exists(publicPath($variant['image']))) {
                $missing[] = $variant['sku'].' (variant) → '.$variant['image'];
            }
        }
    }

    expect($missing)->toBe([]);
});

it('names gallery images after the primary image, numbered from one', function () {
    $wrong = [];

    foreach (catalogue() as $product) {
        // Gallery files sit alongside the primary image under the same base name.
        // Keying off `image` rather than the product name covers grouped products
        // too: a parent owns no photo of its own, so its `image` — and therefore
        // its gallery — carries the default variant's file name.
        $base = pathinfo($product['image'] ?? '', PATHINFO_FILENAME);

        foreach ($product['gallery'] ?? [] as $i => $path) {
            $expected = 'products/gallery/'.$base.'-'.($i + 1).'.'.pathinfo($path, PATHINFO_EXTENSION);

            if ($path !== $expected) {
                $wrong[] = $product['sku'].' → '.$path.' (expected '.$expected.')';
            }
        }
    }

    expect($wrong)->toBe([]);
});

it('gives the Skymsen PA-7 its full set of product shots', function () {
    $pa7 = collect(catalogue())->firstWhere('sku', 'IMG/FPR/00042');

    expect($pa7['image'])->toBe('products/'.MediaNaming::product($pa7['name'], $pa7['sku'], 'jpg'))
        ->and($pa7['gallery'])->toHaveCount(4);
});
