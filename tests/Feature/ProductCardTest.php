<?php

use App\Enums\ProductType;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestView;

function renderCard(Product $product): TestView
{
    return test()->blade('<x-storefront.product-card :product="$product" />', ['product' => $product]);
}

it('renders the quick-add control for a priced simple product', function () {
    $product = Product::factory()->create(['price' => 150000, 'requires_quotation' => false]);

    renderCard($product)
        ->assertSee("addToCart('{$product->slug}')", false)
        ->assertDontSee('Request a quote');
});

it('routes quote-only products to the product page instead of quick-adding', function () {
    $product = Product::factory()->create(['requires_quotation' => true, 'price' => null]);

    renderCard($product)
        ->assertSee(route('product.show', $product), false)
        ->assertSee('Request a quote')
        ->assertDontSee("addToCart('{$product->slug}')", false);
});

it('routes unpriced products to the product page instead of quick-adding', function () {
    $product = Product::factory()->create(['requires_quotation' => false, 'price' => null]);

    renderCard($product)
        ->assertSee('Request a quote')
        ->assertDontSee("addToCart('{$product->slug}')", false);
});

it('links the image and the product name, and nothing else', function () {
    $product = Product::factory()->create(['price' => 150000, 'requires_quotation' => false]);

    $html = (string) renderCard($product);
    $href = preg_quote(route('product.show', $product), '/');

    // Image area: a full-bleed anchor over the square.
    expect($html)->toMatch('/<a href="'.$href.'"[^>]*class="absolute inset-0"/');

    // Product name is its own anchor...
    expect($html)->toMatch('/<a href="'.$href.'"[^>]*>\s*'.preg_quote($product->name, '/').'\s*<\/a>/');

    // ...and those are the only two links: the brand and price stay plain text.
    expect(substr_count($html, '<a '))->toBe(2);
});

it('does not show the SKU', function () {
    $product = Product::factory()->create(['sku' => 'SKU-VISIBLE-CHECK', 'price' => 150000]);

    renderCard($product)->assertDontSee('SKU-VISIBLE-CHECK');
});

it('shows a variable product as a price range across its variants', function () {
    $product = Product::factory()->create(['type' => ProductType::VARIABLE, 'price' => 150000]);

    ProductVariant::factory()->for($product)->create(['price' => 120000, 'compare_at_price' => null]);
    ProductVariant::factory()->for($product)->create(['price' => 180000, 'compare_at_price' => null]);
    ProductVariant::factory()->for($product)->create(['price' => 150000, 'compare_at_price' => null]);

    $html = (string) renderCard($product->fresh());

    // The span across variants, not the parent's own 150000.
    expect($html)->toContain(strip_tags(money(120000)).' – '.strip_tags(money(180000)));
});

it('collapses to a single figure when every variant costs the same', function () {
    $product = Product::factory()->create(['type' => ProductType::VARIABLE, 'price' => 150000]);

    ProductVariant::factory()->for($product)->create(['price' => 120000, 'compare_at_price' => null]);
    ProductVariant::factory()->for($product)->create(['price' => 120000, 'compare_at_price' => null]);

    expect((string) renderCard($product->fresh()))
        ->toContain(strip_tags(money(120000)))
        ->not->toContain('–');
});

it('ignores inactive variants when pricing the card', function () {
    $product = Product::factory()->create(['type' => ProductType::VARIABLE, 'price' => 150000]);

    ProductVariant::factory()->for($product)->create(['price' => 120000, 'compare_at_price' => null]);
    ProductVariant::factory()->for($product)->create(['price' => 900000, 'compare_at_price' => null, 'is_active' => false]);

    // forCard() only loads active variants, so the retired one must not widen the range.
    $product = Product::query()->forCard()->find($product->id);

    expect((string) renderCard($product))->not->toContain(strip_tags(money(900000)));
});

it('falls back to the parent price when a variable product has no variants', function () {
    $product = Product::factory()->create(['type' => ProductType::VARIABLE, 'price' => 150000]);

    expect((string) renderCard($product->fresh()))->toContain(strip_tags(money(150000)));
});

it('loads card data for a whole listing in a fixed number of queries', function () {
    Product::factory()->count(5)->create(['type' => ProductType::VARIABLE, 'price' => 150000])
        ->each(fn ($p) => ProductVariant::factory()->count(2)->for($p)->create());

    $products = Product::query()->forCard()->get();

    // The first render warms the settings cache; after that a card must not touch
    // the database at all, so adding products cannot add queries.
    renderCard($products->first());

    DB::enableQueryLog();
    DB::flushQueryLog();

    foreach ($products as $product) {
        renderCard($product);
    }

    expect(DB::getQueryLog())->toBeEmpty();
});

it('opens the variation picker from the card instead of linking to the product page', function () {
    $product = Product::factory()->create(['type' => ProductType::VARIABLE, 'price' => 150000]);
    ProductVariant::factory()->for($product)->create(['price' => 120000]);

    renderCard($product->fresh())
        ->assertSee("openVariationModal('{$product->slug}')", false)
        ->assertDontSee('Select options');
});

it('still routes grouped products to the product page', function () {
    $product = Product::factory()->create(['type' => ProductType::GROUPED, 'price' => 150000]);

    renderCard($product)
        ->assertSee('Select options')
        ->assertDontSee('openVariationModal', false);
});
