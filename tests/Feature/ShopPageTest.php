<?php

use App\Enums\CategoryStatus;
use App\Enums\ProductStatus;
use App\Enums\ProductVisibility;
use App\Enums\StockStatus;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Livewire\Livewire;

it('renders the shop page', function () {
    $response = $this->get(route('catalog'));

    $response->assertOk();
    $response->assertSee('Catalog');
    $response->assertSee('Most popular');
    $response->assertSee('In stock', escape: false);
});

it('filters by selected brand', function () {
    $brandA = Brand::create(['name' => 'BrandA', 'slug' => 'brand-a', 'is_active' => true, 'sort_order' => 1]);
    $brandB = Brand::create(['name' => 'BrandB', 'slug' => 'brand-b', 'is_active' => true, 'sort_order' => 2]);
    $cat = Category::create(['name' => 'TestCat', 'slug' => 'test-cat', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);

    Product::create([
        'name' => 'Apples', 'slug' => 'apples', 'sku' => 'AP-1',
        'brand_id' => $brandA->id, 'primary_category_id' => $cat->id,
        'type' => 'simple', 'price' => 10000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value,
        'status' => ProductStatus::PUBLISHED->value,
    ]);
    Product::create([
        'name' => 'Bananas', 'slug' => 'bananas', 'sku' => 'BN-1',
        'brand_id' => $brandB->id, 'primary_category_id' => $cat->id,
        'type' => 'simple', 'price' => 20000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value,
        'status' => ProductStatus::PUBLISHED->value,
    ]);

    Livewire::test('pages::storefront.catalog')
        ->assertSee('Apples')
        ->assertSee('Bananas')
        ->set('selectedBrands', [$brandA->id])
        ->assertSee('Apples')
        ->assertDontSee('Bananas');
});

it('filters the catalog by the nav search handoff (?q=)', function () {
    $brandA = Brand::create(['name' => 'Rational', 'slug' => 'rational', 'is_active' => true, 'sort_order' => 1]);
    $brandB = Brand::create(['name' => 'Electrolux', 'slug' => 'electrolux', 'is_active' => true, 'sort_order' => 2]);
    $cat = Category::create(['name' => 'Cooking', 'slug' => 'cooking', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);

    Product::create([
        'name' => 'Combi Oven', 'slug' => 'combi-oven', 'sku' => 'CO-100', 'model_number' => 'ICP-61',
        'brand_id' => $brandA->id, 'primary_category_id' => $cat->id,
        'type' => 'simple', 'price' => 10000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value, 'status' => ProductStatus::PUBLISHED->value,
    ]);
    Product::create([
        'name' => 'Dough Mixer', 'slug' => 'dough-mixer', 'sku' => 'DM-200', 'model_number' => 'MX-500',
        'brand_id' => $brandB->id, 'primary_category_id' => $cat->id,
        'type' => 'simple', 'price' => 20000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value, 'status' => ProductStatus::PUBLISHED->value,
    ]);

    // The nav search hands off via /catalog?q=… — the page must pick it up from the URL.
    Livewire::withQueryParams(['q' => 'Combi'])
        ->test('pages::storefront.catalog')
        ->assertSet('q', 'Combi')
        ->assertSee('Combi Oven')
        ->assertDontSee('Dough Mixer');

    // SKU, model number and brand name all match too.
    Livewire::test('pages::storefront.catalog')
        ->set('q', 'DM-200')->assertSee('Dough Mixer')->assertDontSee('Combi Oven')
        ->set('q', 'ICP-61')->assertSee('Combi Oven')->assertDontSee('Dough Mixer')
        ->set('q', 'Electrolux')->assertSee('Dough Mixer')->assertDontSee('Combi Oven')
        ->set('q', '')->assertSee('Combi Oven')->assertSee('Dough Mixer');
});

it('filters by price min and max bounds', function () {
    $brand = Brand::create(['name' => 'PriceBrand', 'slug' => 'price-brand', 'is_active' => true, 'sort_order' => 1]);
    $cat = Category::create(['name' => 'PriceCat', 'slug' => 'price-cat', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);

    // Prices stored in cents: 1k, 100k, 500k KES.
    $cheap = Product::create([
        'name' => 'Cheap Whisk', 'slug' => 'cheap-whisk', 'sku' => 'CW-1',
        'brand_id' => $brand->id, 'primary_category_id' => $cat->id,
        'type' => 'simple', 'price' => 100_000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value, 'status' => ProductStatus::PUBLISHED->value,
    ]);
    $mid = Product::create([
        'name' => 'Mid Whisk', 'slug' => 'mid-whisk', 'sku' => 'MW-1',
        'brand_id' => $brand->id, 'primary_category_id' => $cat->id,
        'type' => 'simple', 'price' => 10_000_000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value, 'status' => ProductStatus::PUBLISHED->value,
    ]);
    $pricey = Product::create([
        'name' => 'Pricey Whisk', 'slug' => 'pricey-whisk', 'sku' => 'PW-1',
        'brand_id' => $brand->id, 'primary_category_id' => $cat->id,
        'type' => 'simple', 'price' => 50_000_000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value, 'status' => ProductStatus::PUBLISHED->value,
    ]);

    // Window 50k–200k KES keeps only the mid product (100k KES).
    Livewire::test('pages::storefront.catalog')
        ->set('priceMin', 50_000)
        ->set('priceMax', 200_000)
        ->assertDontSee('Cheap Whisk')
        ->assertSee('Mid Whisk')
        ->assertDontSee('Pricey Whisk');
});

it('filters by minimum review rating', function () {
    $brand = Brand::create(['name' => 'BrandA', 'slug' => 'brand-a', 'is_active' => true, 'sort_order' => 1]);
    $cat = Category::create(['name' => 'TestCat', 'slug' => 'test-cat', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);

    $highlyRated = Product::create([
        'name' => 'Highly Rated Mixer', 'slug' => 'highly-rated-mixer', 'sku' => 'HR-1',
        'brand_id' => $brand->id, 'primary_category_id' => $cat->id,
        'type' => 'simple', 'price' => 10000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value,
        'status' => ProductStatus::PUBLISHED->value,
    ]);
    $poorlyRated = Product::create([
        'name' => 'Poorly Rated Mixer', 'slug' => 'poorly-rated-mixer', 'sku' => 'PR-1',
        'brand_id' => $brand->id, 'primary_category_id' => $cat->id,
        'type' => 'simple', 'price' => 20000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value,
        'status' => ProductStatus::PUBLISHED->value,
    ]);

    Review::factory()->approved()->create(['product_id' => $highlyRated->id, 'rating' => 5]);
    Review::factory()->approved()->create(['product_id' => $poorlyRated->id, 'rating' => 2]);

    Livewire::test('pages::storefront.catalog')
        ->assertSee('Highly Rated Mixer')
        ->assertSee('Poorly Rated Mixer')
        ->set('minRating', 4)
        ->assertSee('Highly Rated Mixer')
        ->assertDontSee('Poorly Rated Mixer');
});

it('excludes products with only pending reviews from the rating filter', function () {
    $brand = Brand::create(['name' => 'BrandB', 'slug' => 'brand-b', 'is_active' => true, 'sort_order' => 1]);
    $cat = Category::create(['name' => 'TestCat2', 'slug' => 'test-cat-2', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);

    $product = Product::create([
        'name' => 'Pending Review Mixer', 'slug' => 'pending-review-mixer', 'sku' => 'PE-1',
        'brand_id' => $brand->id, 'primary_category_id' => $cat->id,
        'type' => 'simple', 'price' => 10000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value,
        'status' => ProductStatus::PUBLISHED->value,
    ]);

    // A 5-star review that is NOT approved must not count toward the filter.
    Review::factory()->create(['product_id' => $product->id, 'rating' => 5]);

    Livewire::test('pages::storefront.catalog')
        ->set('minRating', 4)
        ->assertDontSee('Pending Review Mixer');
});

it('lists only active categories with products in the catalog filter facet', function () {
    $visible = Category::create(['name' => 'Visible Range', 'slug' => 'visible-range', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);
    Category::create(['name' => 'Hidden Draft Cat', 'slug' => 'hidden-draft-cat', 'status' => CategoryStatus::DRAFT, 'sort_order' => 2]);
    Category::create(['name' => 'Hidden Inactive Cat', 'slug' => 'hidden-inactive-cat', 'status' => CategoryStatus::INACTIVE, 'sort_order' => 3]);
    Category::create(['name' => 'Empty Range', 'slug' => 'empty-range', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 4]);

    Product::create([
        'name' => 'Range Cooker', 'slug' => 'range-cooker', 'sku' => 'RC-1',
        'primary_category_id' => $visible->id, 'type' => 'simple', 'price' => 100000,
        'stock_status' => StockStatus::IN_STOCK->value, 'visibility' => ProductVisibility::VISIBLE->value,
        'status' => ProductStatus::PUBLISHED->value,
    ]);

    Livewire::test('pages::storefront.catalog')
        ->assertSee('Visible Range')
        ->assertDontSee('Hidden Draft Cat')
        ->assertDontSee('Hidden Inactive Cat')
        ->assertDontSee('Empty Range');
});

it('shows only active categories in search results', function () {
    Category::create(['name' => 'Searchable Fridge', 'slug' => 'searchable-fridge', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);
    Category::create(['name' => 'Searchable Ghost', 'slug' => 'searchable-ghost', 'status' => CategoryStatus::ARCHIVED, 'sort_order' => 2]);

    Livewire::test('storefront.search-dropdown')
        ->set('query', 'Searchable')
        ->assertSee('Searchable Fridge')
        ->assertDontSee('Searchable Ghost');
});

it('routes /shop/{category} to the category page', function () {
    $cat = Category::create(['name' => 'Ranges', 'slug' => 'ranges', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);

    $response = $this->get(route('category.show', $cat));

    $response->assertOk();
    $response->assertSee('Ranges');
});

it('rolls up products from child categories on a parent category page', function () {
    $parent = Category::create(['name' => 'Cold Room', 'slug' => 'cold-room', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);
    $child = Category::create(['name' => 'Mini Cold Rooms', 'slug' => 'mini-cold-rooms', 'parent_id' => $parent->id, 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);

    Product::create([
        'name' => 'Direct Chiller', 'slug' => 'direct-chiller', 'sku' => 'CR-DIRECT',
        'primary_category_id' => $parent->id, 'type' => 'simple', 'price' => 100000,
        'stock_status' => StockStatus::IN_STOCK->value, 'visibility' => ProductVisibility::VISIBLE->value,
        'status' => ProductStatus::PUBLISHED->value,
    ]);
    Product::create([
        'name' => 'Child Chiller', 'slug' => 'child-chiller', 'sku' => 'CR-CHILD',
        'primary_category_id' => $child->id, 'type' => 'simple', 'price' => 200000,
        'stock_status' => StockStatus::IN_STOCK->value, 'visibility' => ProductVisibility::VISIBLE->value,
        'status' => ProductStatus::PUBLISHED->value,
    ]);

    Livewire::test('pages::storefront.category', ['category' => $parent])
        ->assertSee('Direct Chiller')
        ->assertSee('Child Chiller');
});

it('hides brands without products from the catalog filter facet', function () {
    $stocked = Brand::create(['name' => 'Stocked Brand', 'slug' => 'stocked-brand', 'is_active' => true, 'sort_order' => 1]);
    Brand::create(['name' => 'Empty Brand', 'slug' => 'empty-brand', 'is_active' => true, 'sort_order' => 2]);
    $cat = Category::create(['name' => 'FacetCat', 'slug' => 'facet-cat', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);

    Product::create([
        'name' => 'Facet Fryer', 'slug' => 'facet-fryer', 'sku' => 'FF-1',
        'brand_id' => $stocked->id, 'primary_category_id' => $cat->id,
        'type' => 'simple', 'price' => 100000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value, 'status' => ProductStatus::PUBLISHED->value,
    ]);

    Livewire::test('pages::storefront.catalog')
        ->assertSee('Stocked Brand')
        ->assertDontSee('Empty Brand');
});

it('hides empty child categories from the category-page filter facet', function () {
    $parent = Category::create(['name' => 'Healthcare', 'slug' => 'healthcare', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);
    $stocked = Category::create(['name' => 'Sluice Room', 'slug' => 'sluice-room', 'parent_id' => $parent->id, 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);
    Category::create(['name' => 'Empty Ward', 'slug' => 'empty-ward', 'parent_id' => $parent->id, 'status' => CategoryStatus::ACTIVE, 'sort_order' => 2]);

    // A grandchild's product must keep its (directly empty) parent visible.
    $deep = Category::create(['name' => 'Deep Section', 'slug' => 'deep-section', 'parent_id' => $parent->id, 'status' => CategoryStatus::ACTIVE, 'sort_order' => 3]);
    $grandchild = Category::create(['name' => 'Deep Leaf', 'slug' => 'deep-leaf', 'parent_id' => $deep->id, 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);

    Product::create([
        'name' => 'Bedpan Washer', 'slug' => 'bedpan-washer', 'sku' => 'HC-1',
        'primary_category_id' => $stocked->id, 'type' => 'simple', 'price' => 100000,
        'stock_status' => StockStatus::IN_STOCK->value, 'visibility' => ProductVisibility::VISIBLE->value,
        'status' => ProductStatus::PUBLISHED->value,
    ]);
    Product::create([
        'name' => 'Deep Autoclave', 'slug' => 'deep-autoclave', 'sku' => 'HC-2',
        'primary_category_id' => $grandchild->id, 'type' => 'simple', 'price' => 100000,
        'stock_status' => StockStatus::IN_STOCK->value, 'visibility' => ProductVisibility::VISIBLE->value,
        'status' => ProductStatus::PUBLISHED->value,
    ]);

    Livewire::test('pages::storefront.category', ['category' => $parent])
        ->assertSee('Sluice Room')
        ->assertSee('Deep Section')
        ->assertDontSee('Empty Ward');
});

it('narrows the listing by a child-category filter', function () {
    $parent = Category::create(['name' => 'Laundry', 'slug' => 'laundry', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);
    $washers = Category::create(['name' => 'Washers', 'slug' => 'washers', 'parent_id' => $parent->id, 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);
    $dryers = Category::create(['name' => 'Dryers', 'slug' => 'dryers', 'parent_id' => $parent->id, 'status' => CategoryStatus::ACTIVE, 'sort_order' => 2]);

    Product::create([
        'name' => 'Test Washer', 'slug' => 'test-washer', 'sku' => 'LA-WASH',
        'primary_category_id' => $washers->id, 'type' => 'simple', 'price' => 100000,
        'stock_status' => StockStatus::IN_STOCK->value, 'visibility' => ProductVisibility::VISIBLE->value,
        'status' => ProductStatus::PUBLISHED->value,
    ]);
    Product::create([
        'name' => 'Test Dryer', 'slug' => 'test-dryer', 'sku' => 'LA-DRY',
        'primary_category_id' => $dryers->id, 'type' => 'simple', 'price' => 100000,
        'stock_status' => StockStatus::IN_STOCK->value, 'visibility' => ProductVisibility::VISIBLE->value,
        'status' => ProductStatus::PUBLISHED->value,
    ]);

    Livewire::test('pages::storefront.category', ['category' => $parent])
        ->assertSee('Category')           // the child-category filter facet renders
        ->assertSee('Test Washer')
        ->assertSee('Test Dryer')
        ->set('selectedCategories', [$washers->id])
        ->assertSee('Test Washer')
        ->assertDontSee('Test Dryer');
});
