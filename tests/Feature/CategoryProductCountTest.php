<?php

use App\Enums\CategorySection;
use App\Enums\CategoryStatus;
use App\Enums\ProductVisibility;
use App\Models\Category;
use App\Models\CategoryPlacement;
use App\Models\Product;
use Livewire\Livewire;

it('counts products filed under child categories against the parent', function () {
    $parent = Category::factory()->create();
    $child = Category::factory()->create(['parent_id' => $parent->id]);

    Product::factory()->published()->count(3)->create(['primary_category_id' => $child->id]);

    Category::hydrateCatalogProductCounts([$parent, $child]);

    expect($parent->catalog_products_count)->toBe(3)
        ->and($child->catalog_products_count)->toBe(3);
});

it('descends the whole tree, not just direct children', function () {
    $parent = Category::factory()->create();
    $child = Category::factory()->create(['parent_id' => $parent->id]);
    $grandchild = Category::factory()->create(['parent_id' => $child->id]);

    Product::factory()->published()->create(['primary_category_id' => $grandchild->id]);
    Product::factory()->published()->create(['primary_category_id' => $child->id]);

    Category::hydrateCatalogProductCounts([$parent]);

    expect($parent->catalog_products_count)->toBe(2);
});

it('counts a product once when it sits in both a parent and its child', function () {
    $parent = Category::factory()->create();
    $child = Category::factory()->create(['parent_id' => $parent->id]);

    $product = Product::factory()->published()->create(['primary_category_id' => $child->id]);
    $product->categories()->syncWithoutDetaching([$parent->id]);

    Category::hydrateCatalogProductCounts([$parent]);

    expect($parent->catalog_products_count)->toBe(1);
});

it('excludes products the storefront does not list', function () {
    $parent = Category::factory()->create();
    $child = Category::factory()->create(['parent_id' => $parent->id]);

    Product::factory()->published()->create(['primary_category_id' => $child->id]);
    Product::factory()->create(['primary_category_id' => $child->id]); // draft
    Product::factory()->published()->create([
        'primary_category_id' => $child->id,
        'visibility' => ProductVisibility::HIDDEN->value,
    ]);

    Category::hydrateCatalogProductCounts([$parent]);

    expect($parent->catalog_products_count)->toBe(1);
});

it('leaves categories with nothing beneath them at zero', function () {
    $empty = Category::factory()->create();

    Category::hydrateCatalogProductCounts([$empty]);

    expect($empty->catalog_products_count)->toBe(0);
});

it('shows the descendant count on a featured home page category', function () {
    $parent = Category::factory()->create(['status' => CategoryStatus::ACTIVE->value]);
    $child = Category::factory()->create([
        'parent_id' => $parent->id,
        'status' => CategoryStatus::ACTIVE->value,
    ]);

    Product::factory()->published()->count(2)->create(['primary_category_id' => $child->id]);

    CategoryPlacement::create([
        'category_id' => $parent->id,
        'location' => CategorySection::HOME_PAGE_FEATURED->value,
        'status' => CategoryStatus::ACTIVE->value,
        'sort_order' => 0,
    ]);

    $featured = Livewire::test('pages::storefront.home')->instance()->featuredCategories;

    expect($featured->first()->catalog_products_count)->toBe(2);
});
