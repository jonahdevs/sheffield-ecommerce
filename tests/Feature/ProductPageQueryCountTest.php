<?php

use App\Enums\CategoryStatus;
use App\Enums\ProductLinkType;
use App\Enums\ProductStatus;
use App\Enums\ProductVisibility;
use App\Enums\ReviewStatus;
use App\Enums\StockStatus;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductLink;
use App\Models\Review;
use App\Models\TaxClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;

/**
 * The product page renders the product, its accessories and spare parts, its
 * reviews, and four carousels. An N+1 shows up as a query count that grows with
 * the number of rows, so each case renders the page twice — once with a small
 * collection, once with a large one — and asserts the counts match.
 */
beforeEach(function () {
    $this->taxClass = TaxClass::create(['name' => 'Standard', 'slug' => 'standard', 'rate' => 16, 'is_active' => true]);
    $this->brand = Brand::create(['name' => 'Rancilio', 'slug' => 'rancilio', 'is_active' => true, 'sort_order' => 1]);
    $this->cat = Category::create(['name' => 'Coffee', 'slug' => 'coffee', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);
});

/**
 * Every product carries a brand and a tax class on purpose: both are relations a
 * product card reads, and a null foreign key resolves without a query, which
 * would hide the very N+1 these tests exist to catch.
 */
function pageProduct(array $attrs = []): Product
{
    return Product::create(array_merge([
        'name' => 'Espresso Machine',
        'slug' => 'espresso-'.fake()->unique()->numberBetween(1, 999999),
        'sku' => 'ESP-'.fake()->unique()->numberBetween(1, 999999),
        'brand_id' => test()->brand->id,
        'primary_category_id' => test()->cat->id,
        'tax_class_id' => test()->taxClass->id,
        'type' => 'simple',
        'price' => 150000,
        'is_taxable' => true,
        'status' => ProductStatus::PUBLISHED,
        'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value,
    ], $attrs));
}

function renderPage(Product $product): void
{
    Livewire::test('pages::storefront.product', ['product' => $product])->assertOk();
}

/**
 * Count the queries one render issues. The page is rendered once beforehand and
 * discarded: the first render of the process pays for the settings tables, which
 * are then cached, and that one-off cost would otherwise masquerade as an N+1.
 */
function queriesToRender(Product $product): int
{
    renderPage($product);

    DB::flushQueryLog();
    DB::enableQueryLog();

    renderPage($product);

    $count = count(DB::getQueryLog());
    DB::disableQueryLog();

    return $count;
}

function linkProducts(Product $parent, int $count, ProductLinkType $type): void
{
    foreach (range(1, $count) as $i) {
        ProductLink::create([
            'product_id' => $parent->id,
            'linked_product_id' => pageProduct()->id,
            'type' => $type,
            'sort_order' => $i,
        ]);
    }
}

function addReviews(Product $product, int $count): void
{
    foreach (range(1, $count) as $i) {
        Review::create([
            'product_id' => $product->id,
            'author_name' => "Reviewer {$i}",
            'rating' => 5,
            'body' => 'Excellent machine.',
            'status' => ReviewStatus::APPROVED,
            'approved_at' => now(),
        ]);
    }
}

it('does not issue more queries as accessories are added', function () {
    $few = pageProduct(['slug' => 'few-accessories']);
    linkProducts($few, 1, ProductLinkType::ACCESSORY);

    $many = pageProduct(['slug' => 'many-accessories']);
    linkProducts($many, 8, ProductLinkType::ACCESSORY);

    expect(queriesToRender($many))->toBe(queriesToRender($few));
});

it('does not issue more queries as spare parts are added', function () {
    $few = pageProduct(['slug' => 'few-spares']);
    linkProducts($few, 1, ProductLinkType::SPARE_PART);

    $many = pageProduct(['slug' => 'many-spares']);
    linkProducts($many, 8, ProductLinkType::SPARE_PART);

    expect(queriesToRender($many))->toBe(queriesToRender($few));
});

it('does not issue more queries as reviews are added', function () {
    $few = pageProduct(['slug' => 'few-reviews']);
    addReviews($few, 1);

    $many = pageProduct(['slug' => 'many-reviews']);
    addReviews($many, 10);

    expect(queriesToRender($many))->toBe(queriesToRender($few));
});

it('does not issue more queries as the related and same-brand carousels fill up', function () {
    // Both products already have a populated carousel, so this measures growth of
    // the carousels rather than their appearance.
    $subject = pageProduct(['slug' => 'subject']);
    foreach (range(1, 2) as $i) {
        pageProduct(['slug' => "sibling-{$i}"]);
    }

    $baseline = queriesToRender($subject);

    foreach (range(3, 12) as $i) {
        pageProduct(['slug' => "sibling-{$i}"]);
    }

    expect(queriesToRender($subject))->toBe($baseline);
});

/**
 * Guards the `taxClass:id,rate` style eager loads. Column-constrained eager loads
 * name columns as strings, so a typo is invisible until runtime — and invisible
 * even then on SQLite, which quietly reads an unknown double-quoted identifier as
 * a string literal. MySQL throws. This asserts every named column really exists.
 */
it('only names real columns in constrained eager loads', function () {
    $files = collect(File::allFiles(resource_path('views')))
        ->filter(fn ($f) => str_ends_with($f->getFilename(), '.blade.php'));

    $problems = [];

    foreach ($files as $file) {
        preg_match_all("/'(\w+):([\w,]+)'/", File::get($file->getPathname()), $matches, PREG_SET_ORDER);

        foreach ($matches as [$whole, $relation, $columns]) {
            $table = match ($relation) {
                'taxClass' => 'tax_classes',
                'brand' => 'brands',
                'primaryCategory' => 'categories',
                default => null,
            };

            if ($table === null) {
                continue;
            }

            foreach (explode(',', $columns) as $column) {
                if (! Schema::hasColumn($table, $column)) {
                    $problems[] = "{$file->getFilename()}: {$whole} — {$table}.{$column} does not exist";
                }
            }
        }
    }

    expect($problems)->toBe([]);
});
