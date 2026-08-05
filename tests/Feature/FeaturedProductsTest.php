<?php

use App\Models\Product;
use App\Models\TagProduct;
use Livewire\Livewire;
use Spatie\Tags\Tag;

/** Resolve the Featured product IDs the home component would render. */
function featuredIds(): array
{
    return Livewire::test('pages::storefront.home')
        ->instance()
        ->featuredProducts
        ->pluck('id')
        ->all();
}

it('shows products tagged Featured', function () {
    $tagged = Product::factory()->published()->create();
    $tagged->attachTag('Featured', 'feature');
    $untagged = Product::factory()->published()->create();

    $ids = featuredIds();

    expect($ids)->toContain($tagged->id)
        ->and($ids)->not->toContain($untagged->id);
});

it('falls back to other products when nothing is tagged Featured', function () {
    $product = Product::factory()->published()->create();

    expect(featuredIds())->toContain($product->id);
});

it('orders featured products by their position on the tag, not the product\'s own sort_order', function () {
    $tag = Tag::findOrCreate('Featured', 'feature');

    // Deliberately opposite of the desired Featured order, so the test would fail
    // if the query still ordered by products.sort_order instead of the pivot.
    $first = Product::factory()->published()->create(['sort_order' => 99]);
    $second = Product::factory()->published()->create(['sort_order' => 1]);

    $first->attachTag($tag);
    $second->attachTag($tag);
    TagProduct::where('taggable_id', $first->id)->update(['sort_order' => 1]);
    TagProduct::where('taggable_id', $second->id)->update(['sort_order' => 0]);

    expect(featuredIds())->toBe([$second->id, $first->id]);
});
