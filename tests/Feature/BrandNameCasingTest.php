<?php

use App\Models\Brand;
use Database\Seeders\BrandSeeder;
use Illuminate\Support\Facades\File;

// Brand names are rendered raw into sentence-like copy — the "More from <brand>"
// carousel heading, the "Authorised distributor" panel, the home page brand cards.
// Stored in the supplier's shouty casing they read as SHOUTING there, so the
// display casing lives in brands.json rather than being patched per view. The
// eyebrow labels that genuinely want caps get them from an `uppercase` CSS class.

/** Brands whose real styling is an initialism or acronym, so caps are correct. */
const CAPITALISED_BRANDS = ['TASKI', 'SDX', 'ICOS', 'HDS', 'PSV', 'KEF'];

it('stores brand names in display casing rather than all caps', function () {
    $this->seed(BrandSeeder::class);

    $shouting = Brand::pluck('name')
        ->reject(fn (string $name) => in_array($name, CAPITALISED_BRANDS, true))
        // A name is shouting when it has letters but not one lowercase among them.
        ->filter(fn (string $name) => preg_match('/\p{L}/u', $name) && ! preg_match('/\p{Ll}/u', $name))
        ->values();

    expect($shouting->all())->toBe([]);
});

it('keeps brand names unique once lowercased', function () {
    $this->seed(BrandSeeder::class);

    // ProductSeeder and the spreadsheet import both resolve a brand by its
    // lowercased name, because products.json keeps the supplier's casing
    // ("RATIONAL") while brands.json holds the display casing ("Rational").
    // Two brands differing only in case would make that lookup ambiguous.
    $lowercased = Brand::pluck('name')->map(fn (string $name) => mb_strtolower($name));

    expect($lowercased->duplicates()->values()->all())->toBe([]);
});

it('still matches products.json brand references that differ only in casing', function () {
    $this->seed(BrandSeeder::class);

    $referenced = collect(json_decode(File::get(database_path('data/products.json')), true))
        ->pluck('brand')
        ->filter()
        ->unique();

    $exact = Brand::pluck('name');
    $lowercased = $exact->map(fn (string $name) => mb_strtolower($name));

    // The recasing means these no longer match on the nose — which is exactly the
    // drift that would zero out brand_id if the seeder compared names verbatim.
    $driftedOnCase = $referenced
        ->reject(fn (string $brand) => $exact->contains(trim($brand)))
        ->filter(fn (string $brand) => $lowercased->contains(mb_strtolower(trim($brand))));

    expect($driftedOnCase)->not->toBeEmpty()
        ->and($driftedOnCase)->toContain('RATIONAL');
});
