<?php

use App\Enums\ProductType;
use App\Models\Product;
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

it('links the image and the product name, but not the SKU or price', function () {
    $product = Product::factory()->create(['price' => 150000, 'requires_quotation' => false]);

    $html = (string) renderCard($product);
    $href = preg_quote(route('product.show', $product), '/');

    // Image area: a full-bleed anchor over the square.
    expect($html)->toMatch('/<a href="'.$href.'"[^>]*class="absolute inset-0"/');

    // Product name is its own anchor...
    expect($html)->toMatch('/<a href="'.$href.'"[^>]*>\s*'.preg_quote($product->name, '/').'\s*<\/a>/');

    // ...and the info block that holds the SKU and price is not a link.
    $info = str($html)->after($product->name)->after('</a>')->toString();
    expect($info)->toContain($product->sku)
        ->and(str($info)->before($product->sku)->toString())->not->toContain('<a ');
});

it('routes variable and grouped products to the product page to choose options', function (ProductType $type) {
    $product = Product::factory()->create(['type' => $type, 'price' => 150000]);

    renderCard($product)
        ->assertSee('Select options')
        ->assertDontSee("addToCart('{$product->slug}')", false);
})->with([
    'variable' => ProductType::VARIABLE,
    'grouped' => ProductType::GROUPED,
]);
