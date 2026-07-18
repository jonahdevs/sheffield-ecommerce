<?php

use App\Enums\CategoryStatus;
use App\Enums\ProductVisibility;
use App\Enums\StockStatus;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Support\StorefrontSession;
use Livewire\Livewire;

beforeEach(function () {
    $this->brand = Brand::create(['name' => 'TestBrand', 'slug' => 'test-brand', 'is_active' => true, 'sort_order' => 1]);
    $this->cat = Category::create(['name' => 'TestCat', 'slug' => 'test-cat', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);

    $this->productA = Product::create([
        'name' => 'Wok Range', 'slug' => 'wok-range', 'sku' => 'WK-1',
        'brand_id' => $this->brand->id, 'primary_category_id' => $this->cat->id,
        'type' => 'simple', 'price' => 150000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value,
    ]);
    $this->productB = Product::create([
        'name' => 'Pasta Cooker', 'slug' => 'pasta-cooker', 'sku' => 'PC-1',
        'brand_id' => $this->brand->id, 'primary_category_id' => $this->cat->id,
        'type' => 'simple', 'price' => 95000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value,
    ]);
});

// ==================================================
// CART PAGE
// ==================================================

it('renders the cart page in its empty state', function () {
    $response = $this->get(route('cart'));

    $response->assertOk();
    $response->assertSee('Your cart is empty.');
    $response->assertSee('Shop the catalog');
});

it('renders cart items when products are in session', function () {
    StorefrontSession::addToCart('wok-range', 2);
    StorefrontSession::addToCart('pasta-cooker', 1);

    Livewire::test('pages::storefront.cart')
        ->assertSee('Wok Range')
        ->assertSee('Pasta Cooker')
        ->assertSee('Cart summary');
});

it('increments and decrements cart quantity', function () {
    StorefrontSession::addToCart('wok-range', 1);

    Livewire::test('pages::storefront.cart')
        ->call('increment', 'wok-range')
        ->call('increment', 'wok-range');

    expect(StorefrontSession::cart()['wok-range'])->toBe(3);

    Livewire::test('pages::storefront.cart')
        ->call('decrement', 'wok-range');

    expect(StorefrontSession::cart()['wok-range'])->toBe(2);
});

it('removes an item from the cart', function () {
    StorefrontSession::addToCart('wok-range', 1);
    StorefrontSession::addToCart('pasta-cooker', 1);

    Livewire::test('pages::storefront.cart')
        ->call('remove', 'wok-range');

    expect(StorefrontSession::cart())->toHaveKeys(['pasta-cooker'])
        ->and(StorefrontSession::cart())->not->toHaveKey('wok-range');
});

// ==================================================
// WISHLIST PAGE
// ==================================================

it('renders the wishlist page in its empty state', function () {
    $response = $this->get(route('wishlist'));

    $response->assertOk();
    $response->assertSee('Your wishlist is empty.');
});

// ==================================================
// LIVE WISHLIST/COMPARE STATE
// ==================================================
// toggleWishlist()/toggleCompare() call skipRender() so Livewire morphing can't
// tear down JS-initialised DOM (e.g. the hero Swiper). That means the server
// never re-renders these buttons, so every one of them must carry the Alpine
// wiring that flips its own state from the dispatched event. A button rendered
// purely from the server $isWished/$isCompared value goes stale until reload.

it('does not re-render when toggling the wishlist', function () {
    StorefrontSession::addToCart('wok-range', 1);

    Livewire::test('pages::storefront.cart')
        ->call('toggleWishlist', 'wok-range')
        ->assertDispatched('wishlist-updated', slug: 'wok-range', wished: true);

    expect(StorefrontSession::isWishlisted('wok-range'))->toBeTrue();
});

it('wires the cart save-for-later button to update client-side', function () {
    StorefrontSession::addToCart('wok-range', 1);

    $html = Livewire::test('pages::storefront.cart')->html();

    expect($html)->toContain('x-data="{ wished: false }"')
        ->and($html)->toContain('@wishlist-updated.window')
        ->and($html)->toContain('wished = $event.detail.wished')
        ->and($html)->toContain("wished ? 'Saved' : 'Save for later'");
});

// NOTE: the PDP also renders <x-storefront.product-card> for add-ons, and those
// cards carry their own @wishlist-updated.window wiring. Asserting on that
// attribute alone passes even when the PDP's own button is broken, so these
// assertions target the !-important class strings unique to the PDP buttons.
it('wires the product page wishlist and compare buttons to update client-side', function () {
    $html = $this->get(route('product.show', $this->productA))->getContent();

    expect($html)->toContain("? 'bg-brand-500! border-brand-500! text-white!'")
        ->and($html)->toContain("? 'bg-ink! border-ink! text-white!'");
});

it('toggles a product into and out of the wishlist', function () {
    expect(StorefrontSession::wishlist())->toBeEmpty();

    StorefrontSession::toggleWishlist('wok-range');
    expect(StorefrontSession::wishlist())->toContain('wok-range');

    StorefrontSession::toggleWishlist('wok-range');
    expect(StorefrontSession::wishlist())->not->toContain('wok-range');
});

it('renders wishlist rows and supports add-all-to-cart', function () {
    StorefrontSession::toggleWishlist('wok-range');
    StorefrontSession::toggleWishlist('pasta-cooker');

    Livewire::test('pages::storefront.wishlist')
        ->assertSee('Wok Range')
        ->assertSee('Pasta Cooker')
        ->call('addAllToCart');

    expect(StorefrontSession::cart())->toHaveKeys(['wok-range', 'pasta-cooker']);
});
