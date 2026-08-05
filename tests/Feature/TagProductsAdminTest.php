<?php

use App\Models\Product;
use App\Models\TagProduct;
use Livewire\Livewire;
use Spatie\Tags\Tag;

beforeEach(function () {
    actingAsAdmin();
});

it('loads the tag products admin page', function () {
    $tag = Tag::findOrCreate('Featured', 'feature');

    $this->get(route('admin.tags.products', $tag))->assertOk();
});

it('shows products already tagged, ordered by sort_order', function () {
    $tag = Tag::findOrCreate('Featured', 'feature');
    $productA = Product::factory()->published()->create(['name' => 'Product A']);
    $productB = Product::factory()->published()->create(['name' => 'Product B']);

    $productA->attachTag($tag);
    $productB->attachTag($tag);
    TagProduct::where('taggable_id', $productA->id)->update(['sort_order' => 1]);
    TagProduct::where('taggable_id', $productB->id)->update(['sort_order' => 0]);

    $component = Livewire::test('pages::admin.tags.products', ['tag' => $tag]);

    expect($component->instance()->items->pluck('taggable_id')->all())
        ->toBe([$productB->id, $productA->id]);
});

it('excludes products already tagged from the add search', function () {
    $tag = Tag::findOrCreate('Featured', 'feature');
    $tagged = Product::factory()->published()->create(['name' => 'Already Tagged']);
    $untagged = Product::factory()->published()->create(['name' => 'Not Tagged']);

    $tagged->attachTag($tag);

    $ids = Livewire::test('pages::admin.tags.products', ['tag' => $tag])
        ->set('addSearch', 'Tagged')
        ->instance()->searchResults->pluck('id');

    expect($ids)->toContain($untagged->id)
        ->not->toContain($tagged->id);
});

it('adds a product to the tag with the next sort order', function () {
    $tag = Tag::findOrCreate('Featured', 'feature');
    $existing = Product::factory()->published()->create();
    $existing->attachTag($tag);
    TagProduct::where('taggable_id', $existing->id)->update(['sort_order' => 5]);

    $new = Product::factory()->published()->create();

    Livewire::test('pages::admin.tags.products', ['tag' => $tag])
        ->call('addProduct', $new->id);

    expect($new->fresh()->hasTag('Featured'))->toBeTrue()
        ->and(TagProduct::where('taggable_id', $new->id)->value('sort_order'))->toBe(6);
});

it('removes a product from the tag', function () {
    $tag = Tag::findOrCreate('Featured', 'feature');
    $product = Product::factory()->published()->create();
    $product->attachTag($tag);

    Livewire::test('pages::admin.tags.products', ['tag' => $tag])
        ->call('remove', $product->id);

    expect($product->fresh()->hasTag('Featured'))->toBeFalse();
});

it('reorders tagged products via the sort handler', function () {
    $tag = Tag::findOrCreate('Featured', 'feature');
    $productA = Product::factory()->published()->create();
    $productB = Product::factory()->published()->create();
    $productC = Product::factory()->published()->create();

    foreach ([$productA, $productB, $productC] as $product) {
        $product->attachTag($tag);
    }
    TagProduct::where('taggable_id', $productA->id)->update(['sort_order' => 0]);
    TagProduct::where('taggable_id', $productB->id)->update(['sort_order' => 1]);
    TagProduct::where('taggable_id', $productC->id)->update(['sort_order' => 2]);

    // Move productA (position 0) to position 2.
    Livewire::test('pages::admin.tags.products', ['tag' => $tag])
        ->call('handleSort', $productA->id, 2);

    expect(TagProduct::where('taggable_id', $productA->id)->value('sort_order'))->toBe(2)
        ->and(TagProduct::where('taggable_id', $productB->id)->value('sort_order'))->toBe(0)
        ->and(TagProduct::where('taggable_id', $productC->id)->value('sort_order'))->toBe(1);
});
