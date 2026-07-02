<?php

use App\Models\Product;
use App\Models\ProductView;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

beforeEach(function () {
    Cache::forget('storefront.trending-searches');
});

it('shows the most viewed products as trending searches', function () {
    $popular = Product::factory()->published()->create(['name' => 'Combi Oven 10 Grid']);
    $quiet = Product::factory()->published()->create(['name' => 'Dough Sheeter']);

    foreach (range(1, 3) as $i) {
        ProductView::create(['product_id' => $popular->id, 'session_id' => "s{$i}", 'viewed_at' => now()]);
    }

    $component = Livewire::test('storefront.search-dropdown');

    expect($component->instance()->trending->first())->toBe('Combi Oven 10 Grid');
    $component->assertSee('Combi Oven 10 Grid');
});

it('ignores views older than 30 days when ranking trending', function () {
    $stale = Product::factory()->published()->create(['name' => 'Old Freezer']);
    $fresh = Product::factory()->published()->create(['name' => 'New Blast Chiller']);

    foreach (range(1, 5) as $i) {
        ProductView::create(['product_id' => $stale->id, 'session_id' => "old{$i}", 'viewed_at' => now()->subDays(45)]);
    }
    ProductView::create(['product_id' => $fresh->id, 'session_id' => 'new1', 'viewed_at' => now()]);

    $trending = Livewire::test('storefront.search-dropdown')->instance()->trending;

    expect($trending->first())->toBe('New Blast Chiller');
});

it('tops up trending with the newest products when view data is thin', function () {
    $viewed = Product::factory()->published()->create(['name' => 'Espresso Machine']);
    ProductView::create(['product_id' => $viewed->id, 'session_id' => 's1', 'viewed_at' => now()]);

    Product::factory()->published()->count(3)->create();

    $trending = Livewire::test('storefront.search-dropdown')->instance()->trending;

    expect($trending->first())->toBe('Espresso Machine')
        ->and($trending)->toHaveCount(4)
        ->and($trending->unique())->toHaveCount(4);
});

it('hides the trending section when the catalog is empty', function () {
    Livewire::test('storefront.search-dropdown')
        ->assertDontSee('Trending');
});
