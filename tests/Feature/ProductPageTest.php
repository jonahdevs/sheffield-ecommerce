<?php

use App\Enums\CategoryStatus;
use App\Enums\ProductLinkType;
use App\Enums\ProductStatus;
use App\Enums\ProductVisibility;
use App\Enums\StockStatus;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\BundleItem;
use App\Models\Category;
use App\Models\GroupedProductItem;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductLink;
use App\Models\ProductVariant;
use App\Settings\QuotationSettings;
use App\Support\StorefrontSession;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;

beforeEach(function () {
    $this->brand = Brand::create(['name' => 'TestBrand', 'slug' => 'test-brand', 'is_active' => true, 'sort_order' => 1]);
    $this->cat = Category::create(['name' => 'TestCat', 'slug' => 'test-cat', 'status' => CategoryStatus::ACTIVE, 'sort_order' => 1]);
});

function makeProduct(array $attrs = []): Product
{
    return Product::create(array_merge([
        'name' => 'Wok Range', 'slug' => 'wok-range', 'sku' => 'WK-'.fake()->unique()->numberBetween(1, 99999),
        'brand_id' => test()->brand->id, 'primary_category_id' => test()->cat->id,
        'type' => 'simple', 'price' => 150000, 'stock_status' => StockStatus::IN_STOCK->value,
        'visibility' => ProductVisibility::VISIBLE->value,
    ], $attrs));
}

it('adds a simple product straight to the cart without a modal', function () {
    $product = makeProduct(['slug' => 'simple-wok']);

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('addThisToCart')
        ->assertSet('showBundleModal', false);

    expect(StorefrontSession::cart())->toBe(['simple-wok' => 1]);
});

it('opens a modal listing real bundle components and adds the bundle as one SKU', function () {
    $component = makeProduct(['name' => 'Stainless Stand', 'slug' => 'stainless-stand', 'price' => 40000]);
    $bundle = makeProduct(['name' => 'Wok Station Bundle', 'slug' => 'wok-bundle', 'type' => 'bundled', 'price' => 200000]);

    BundleItem::create([
        'bundle_product_id' => $bundle->id,
        'product_id' => $component->id,
        'quantity' => 2,
        'is_optional' => false,
        'sort_order' => 0,
    ]);

    Livewire::test('pages::storefront.product', ['product' => $bundle])
        ->assertSee('Stainless Stand')          // component rendered in the modal markup
        ->call('addThisToCart')
        ->assertSet('showBundleModal', true)     // bundle intercepts add-to-cart
        ->call('addBundleToCart')
        ->assertSet('showBundleModal', false);

    expect(StorefrontSession::cart())->toBe(['wok-bundle' => 1]);
});

it('only ever lists published, catalog-visible accessories — including after a Livewire update', function () {
    $product = makeProduct(['slug' => 'oven-with-trays']);

    $visibleAccessory = makeProduct([
        'name' => 'Baking Tray', 'slug' => 'baking-tray', 'price' => 5000,
        'status' => ProductStatus::PUBLISHED->value,
    ]);
    $hiddenAccessory = makeProduct([
        'name' => 'Draft Tray', 'slug' => 'draft-tray', 'price' => 5000,
        'status' => ProductStatus::DRAFT->value,
    ]);

    foreach ([$visibleAccessory, $hiddenAccessory] as $accessory) {
        ProductLink::create([
            'product_id' => $product->id,
            'linked_product_id' => $accessory->id,
            'type' => ProductLinkType::ACCESSORY,
            'sort_order' => 0,
        ]);
    }

    $component = Livewire::test('pages::storefront.product', ['product' => $product]);

    $idsNow = fn () => $component->instance()->filteredAccessories->pluck('id')->all();

    // Initial render: the draft accessory is filtered out.
    expect($idsNow())->toBe([$visibleAccessory->id]);

    // After a Livewire round-trip (e.g. clicking a tab) the model is re-fetched —
    // the unpublished accessory must STILL be excluded, not surface unfiltered.
    $component->set('activeTab', 'specs');
    expect($idsNow())->toBe([$visibleAccessory->id]);
});

it('opens a modal for grouped products and adds the chosen children', function () {
    $childA = makeProduct(['name' => 'Burner A', 'slug' => 'burner-a', 'price' => 30000]);
    $childB = makeProduct(['name' => 'Burner B', 'slug' => 'burner-b', 'price' => 50000]);
    $group = makeProduct(['name' => 'Burner Set', 'slug' => 'burner-set', 'type' => 'grouped', 'price' => null]);

    GroupedProductItem::create(['group_product_id' => $group->id, 'child_product_id' => $childA->id, 'sort_order' => 0]);
    GroupedProductItem::create(['group_product_id' => $group->id, 'child_product_id' => $childB->id, 'sort_order' => 1]);

    Livewire::test('pages::storefront.product', ['product' => $group])
        ->call('addThisToCart')
        ->assertSet('showBundleModal', true)
        ->set('groupedQty.burner-a', 2)
        ->set('groupedQty.burner-b', 1)
        ->call('addGroupedToCart')
        ->assertHasNoErrors()
        ->assertSet('showBundleModal', false);

    expect(StorefrontSession::cart())->toBe(['burner-a' => 2, 'burner-b' => 1]);
});

it('errors when a grouped selection is empty', function () {
    $child = makeProduct(['name' => 'Burner A', 'slug' => 'burner-a', 'price' => 30000]);
    $group = makeProduct(['name' => 'Burner Set', 'slug' => 'burner-set', 'type' => 'grouped', 'price' => null]);
    GroupedProductItem::create(['group_product_id' => $group->id, 'child_product_id' => $child->id, 'sort_order' => 0]);

    Livewire::test('pages::storefront.product', ['product' => $group])
        ->call('addGroupedToCart')
        ->assertHasErrors('groupedQty');

    expect(StorefrontSession::cart())->toBe([]);
});

it('shows a request-a-quote link and no add-to-cart for quote-only products', function () {
    app(QuotationSettings::class)->fill(['quotes_enabled' => true])->save();

    $product = makeProduct(['slug' => 'quote-only', 'requires_quotation' => true, 'price' => null]);

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->assertSee(route('quote.request', ['product' => 'quote-only']))
        ->assertSee('Request a quote')
        ->assertDontSee('Add to cart');
});

it('renders the product page for each product type', function () {
    $product = makeProduct(['slug' => 'smoke-test']);

    $this->get(route('product.show', $product))->assertOk()->assertSee('Wok Range');
});

/**
 * Variable apron: Red (in stock), Blue (on sale, in stock), Green (out of stock).
 *
 * @return array{product: Product, red: ProductVariant, blue: ProductVariant, green: ProductVariant}
 */
function makeVariableProduct(): array
{
    $attr = Attribute::create(['name' => 'Color', 'slug' => 'color', 'type' => 'color', 'is_active' => true, 'sort_order' => 1]);
    $red = AttributeValue::create(['attribute_id' => $attr->id, 'value' => 'Red', 'label' => 'Red', 'slug' => 'red', 'color_code' => '#ef4444', 'sort_order' => 1, 'is_active' => true]);
    $blue = AttributeValue::create(['attribute_id' => $attr->id, 'value' => 'Blue', 'label' => 'Blue', 'slug' => 'blue', 'color_code' => '#3b82f6', 'sort_order' => 2, 'is_active' => true]);
    $green = AttributeValue::create(['attribute_id' => $attr->id, 'value' => 'Green', 'label' => 'Green', 'slug' => 'green', 'color_code' => '#22c55e', 'sort_order' => 3, 'is_active' => true]);

    $product = makeProduct(['name' => 'Chef Apron', 'slug' => 'apron', 'type' => 'variable', 'price' => 150000]);
    ProductAttribute::create([
        'product_id' => $product->id, 'attribute_id' => $attr->id,
        'values' => ['red', 'blue', 'green'], 'is_variation_attribute' => true, 'is_visible' => true, 'sort_order' => 1,
    ]);

    $vRed = ProductVariant::create(['product_id' => $product->id, 'sku' => 'APR-RED', 'price' => 150000, 'stock_status' => StockStatus::IN_STOCK->value, 'stock_quantity' => 5, 'is_active' => true, 'sort_order' => 1]);
    $vRed->attributeValues()->attach($red->id);
    $vBlue = ProductVariant::create(['product_id' => $product->id, 'sku' => 'APR-BLUE', 'price' => 150000, 'compare_at_price' => 129900, 'stock_status' => StockStatus::IN_STOCK->value, 'stock_quantity' => 3, 'is_active' => true, 'sort_order' => 2]);
    $vBlue->attributeValues()->attach($blue->id);
    $vGreen = ProductVariant::create(['product_id' => $product->id, 'sku' => 'APR-GREEN', 'price' => 150000, 'stock_status' => StockStatus::OUT_OF_STOCK->value, 'stock_quantity' => 0, 'is_active' => true, 'sort_order' => 3]);
    $vGreen->attributeValues()->attach($green->id);

    return ['product' => $product->fresh(), 'red' => $vRed, 'blue' => $vBlue, 'green' => $vGreen];
}

it('preselects an in-stock variant', function () {
    ['product' => $product] = makeVariableProduct();

    // Red is first and in stock; green is out of stock and must not be chosen.
    Livewire::test('pages::storefront.product', ['product' => $product])
        ->assertSet('selectedOptions', ['color' => 'red']);
});

it('titles the selector section once instead of naming each attribute', function () {
    ['product' => $product] = makeVariableProduct();

    $html = Livewire::test('pages::storefront.product', ['product' => $product])->html();

    // One section title covers the single-axis selector...
    expect($html)->toContain('Variations available')
        // ...so the attribute's own name is not repeated as a heading,
        ->and($html)->not->toContain('>Color</div>')
        // ...and the old selected-variant summary bar stays gone.
        ->and($html)->not->toContain('Selected:');
});

it('shows the selected variant description in place of the product summary', function () {
    ['product' => $product, 'blue' => $blue] = makeVariableProduct();
    $product->update(['short_description' => 'A sturdy apron']);
    $blue->update(['description' => 'Blue apron, 2/3 GN, 325 x 354 mm.']);

    $component = Livewire::test('pages::storefront.product', ['product' => $product->fresh()]);

    // Red is preselected and has no description, so the product summary stands.
    // (The summary also appears in the share-button JS, so assert on the block
    // itself rather than the bare string.)
    expect($component->html())->toContain('pdp-rich-text mt-3');

    $component->call('selectOption', 'color', 'blue')
        ->assertSee('Blue apron, 2/3 GN, 325 x 354 mm.');

    expect($component->html())->not->toContain('pdp-rich-text mt-3');
});

it('makes a variant image the active gallery slide when its option is picked', function () {
    ['product' => $product, 'blue' => $blue] = makeVariableProduct();

    // Held in a variable: the fake upload's temp file is removed once it is collected.
    $upload = UploadedFile::fake()->image('blue.jpg', 800, 800);
    $blue->addMedia($upload->getRealPath())
        ->usingFileName('blue.jpg')
        ->toMediaCollection('image');

    $component = Livewire::test('pages::storefront.product', ['product' => $product->fresh()])
        ->assertSet('galleryIdx', 0);

    // The variant image is appended to the product's own images...
    $gallery = $component->instance()->galleryMedia;
    expect($gallery->last()->file_name)->toBe('blue.jpg');

    // ...and selecting that variant jumps the gallery to it.
    $component->call('selectOption', 'color', 'blue')
        ->assertSet('galleryIdx', $gallery->count() - 1);
});

it('renders the seeded specification as a single table', function () {
    ['product' => $product] = makeVariableProduct();
    // Available sizes are seeded into this table (see ProductSeeder data), not
    // rendered as a second table beside it.
    $product->update(['technical_specification' => '<table><tbody>'
        .'<tr><td><strong>Material</strong></td><td>Cotton</td></tr>'
        .'<tr><td><strong>Color</strong></td><td>Red, Blue, Green</td></tr>'
        .'</tbody></table>']);

    $html = Livewire::test('pages::storefront.product', ['product' => $product->fresh()])
        ->set('activeTab', 'specs')
        ->html();

    expect($html)->toContain('Cotton')
        ->and($html)->toContain('Red, Blue, Green')
        // One table in the specs pane, not two.
        ->and(substr_count($html, '<table>'))->toBe(1);
});

it('leaves the gallery alone for a variant with no image', function () {
    ['product' => $product] = makeVariableProduct();

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('selectOption', 'color', 'blue')
        ->assertSet('galleryIdx', 0);
});

it('headlines a variable product with the price range across its variants', function () {
    ['product' => $product, 'red' => $red] = makeVariableProduct();

    // Red 1,500.00 · Blue 1,299.00 (sale) · Green 1,500.00 → 1,299.00 to 1,500.00.
    $range = Livewire::test('pages::storefront.product', ['product' => $product])
        ->instance()->variantPriceRange;

    expect($range)->toBe(['min' => 129900, 'max' => 150000]);

    // Both ends of the range are rendered, not just the preselected variant's price.
    $html = Livewire::test('pages::storefront.product', ['product' => $product])->html();
    expect($html)->toContain(strip_tags(money(129900)))
        ->and($html)->toContain(strip_tags(money(150000)));

    // A single distinct price collapses to one figure rather than "X – X".
    $red->update(['price' => 129900]);
    $product->variants()->where('id', '!=', $red->id)->update(['price' => 129900, 'compare_at_price' => null]);

    $range = Livewire::test('pages::storefront.product', ['product' => $product->fresh()])
        ->instance()->variantPriceRange;

    expect($range)->toBe(['min' => 129900, 'max' => 129900]);
});

it('has no price range for a simple product', function () {
    $product = makeProduct(['slug' => 'plain', 'price' => 150000]);

    expect(Livewire::test('pages::storefront.product', ['product' => $product])
        ->instance()->variantPriceRange)->toBeNull();
});

it('opens the variation modal instead of adding to the cart', function () {
    ['product' => $product] = makeVariableProduct();

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->assertSet('showVariationModal', false)
        ->call('addThisToCart')
        ->assertSet('showVariationModal', true)
        ->assertHasNoErrors();

    expect(StorefrontSession::cart())->toBe([]);
});

it('lists every variant in the modal with its label, reference, price and a zero counter', function () {
    ['product' => $product] = makeVariableProduct();

    $rows = Livewire::test('pages::storefront.product', ['product' => $product])
        ->instance()->variationRows;

    expect($rows->pluck('label')->all())->toBe(['Red', 'Blue', 'Green'])
        // Blue is the sale variant, priced off compare_at_price like the cart does.
        ->and($rows->firstWhere('label', 'Blue')['price_cents'])->toBe(129900)
        ->and($rows->pluck('in_stock')->all())->toBe([true, true, false])
        // Nothing in the cart yet, so every counter reads zero.
        ->and($rows->pluck('qty')->all())->toBe([0, 0, 0])
        ->and($rows->pluck('stock_quantity')->all())->toBe([5, 3, 0]);
});

it('shows the on-hand stock count per variant, and nothing when stock is untracked', function () {
    ['product' => $product, 'red' => $red] = makeVariableProduct();

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->assertSee('5 in stock')
        ->assertSee('3 in stock');

    // A null quantity means stock isn't tracked, which must not read as "0 in stock".
    $red->update(['stock_quantity' => null]);

    $rows = Livewire::test('pages::storefront.product', ['product' => $product->fresh()])
        ->instance()->variationRows;

    expect($rows->firstWhere('label', 'Red')['stock_quantity'])->toBeNull();
});

it('shows the variant model number rather than the internal SKU', function () {
    ['product' => $product, 'red' => $red] = makeVariableProduct();
    $red->update(['model_number' => 'APR-MODEL-RED']);

    $rows = Livewire::test('pages::storefront.product', ['product' => $product->fresh()])
        ->instance()->variationRows;

    expect($rows->firstWhere('label', 'Red')['reference'])->toBe('APR-MODEL-RED');
});

it('falls back to the parent model number, then the SKU, when a variant has none', function () {
    ['product' => $product] = makeVariableProduct();

    // No model number anywhere: the SKU is the last resort.
    $rows = Livewire::test('pages::storefront.product', ['product' => $product])
        ->instance()->variationRows;
    expect($rows->firstWhere('label', 'Red')['reference'])->toBe('APR-RED');

    // Parent model number stands in for variants that lack their own.
    $product->update(['model_number' => 'APRON-2000']);

    $rows = Livewire::test('pages::storefront.product', ['product' => $product->fresh()])
        ->instance()->variationRows;
    expect($rows->firstWhere('label', 'Red')['reference'])->toBe('APRON-2000');
});

it('adds a variant to the cart straight from the counter', function () {
    ['product' => $product, 'blue' => $blue] = makeVariableProduct();

    $component = Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('incVariationQty', $blue->id)
        ->call('incVariationQty', $blue->id);

    expect(StorefrontSession::cart())->toBe(['apron|'.$blue->id => 2]);

    $line = StorefrontSession::cartLines()->first();
    expect($line['unit_price_cents'])->toBe(129900)
        ->and($line['label'])->toBe('Blue');

    // The counter reads back off the cart.
    expect($component->instance()->variationRows->firstWhere('label', 'Blue')['qty'])->toBe(2);
});

it('toasts the variant that was added', function () {
    ['product' => $product, 'blue' => $blue] = makeVariableProduct();

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('incVariationQty', $blue->id)
        ->assertDispatched('toast-show', fn ($event, $params) => str_contains(json_encode($params), 'Chef Apron Blue'));
});

it('removes a variant from the cart as its counter returns to zero', function () {
    ['product' => $product, 'blue' => $blue] = makeVariableProduct();

    $component = Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('incVariationQty', $blue->id)
        ->call('incVariationQty', $blue->id)
        ->call('decVariationQty', $blue->id);

    expect(StorefrontSession::cart())->toBe(['apron|'.$blue->id => 1]);

    // Stepping off the last one drops the line rather than leaving a zero-qty entry.
    $component->call('decVariationQty', $blue->id);

    expect(StorefrontSession::cart())->toBe([]);
});

it('does not go below zero when decrementing a variant that is not in the cart', function () {
    ['product' => $product, 'red' => $red] = makeVariableProduct();

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('decVariationQty', $red->id)
        ->call('decVariationQty', $red->id);

    expect(StorefrontSession::cart())->toBe([]);
});

it('holds several variants as separate cart lines', function () {
    ['product' => $product, 'red' => $red, 'blue' => $blue] = makeVariableProduct();

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('incVariationQty', $red->id)
        ->call('incVariationQty', $blue->id)
        ->call('incVariationQty', $blue->id);

    expect(StorefrontSession::cart())->toBe([
        'apron|'.$red->id => 1,
        'apron|'.$blue->id => 2,
    ]);
});

it('refuses to add an out-of-stock variant', function () {
    ['product' => $product, 'green' => $green] = makeVariableProduct();

    // Green is out of stock, so it has no stepper: the call can only arrive by a
    // tampered payload, and must not reach the cart.
    Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('incVariationQty', $green->id);

    expect(StorefrontSession::cart())->toBe([]);
});

it('refuses to add a variant belonging to another product', function () {
    ['product' => $product] = makeVariableProduct();
    $foreign = ProductVariant::create(['product_id' => makeProduct(['slug' => 'other'])->id, 'sku' => 'OTHER-1', 'price' => 5000, 'stock_status' => StockStatus::IN_STOCK->value, 'is_active' => true, 'sort_order' => 1]);

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('incVariationQty', $foreign->id);

    expect(StorefrontSession::cart())->toBe([]);
});

it('offers go-to-cart and continue-shopping in the modal footer', function () {
    ['product' => $product] = makeVariableProduct();

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->assertSee('Go to cart')
        ->assertSee('Continue shopping')
        ->assertSee(route('cart'), false);
});

it('keeps the inline option buttons alongside the modal list', function () {
    ['product' => $product] = makeVariableProduct();

    $html = Livewire::test('pages::storefront.product', ['product' => $product])->html();

    // The inline pill/swatch selector stays as the browsing control...
    foreach (['red', 'blue', 'green'] as $slug) {
        expect(substr_count($html, "selectOption('color', '{$slug}')"))->toBe(1);
    }

    // ...and the modal lists the variants with their own steppers.
    expect($html)->toContain('APR-RED')->toContain('APR-BLUE')->toContain('APR-GREEN');
});

it('marks out-of-stock options unavailable and in-stock ones available', function () {
    ['product' => $product] = makeVariableProduct();

    $component = Livewire::test('pages::storefront.product', ['product' => $product]);

    expect($component->instance()->isOptionAvailable('color', 'green'))->toBeFalse()
        ->and($component->instance()->isOptionAvailable('color', 'blue'))->toBeTrue();
});

it('keeps two variants of the same product as separate cart lines', function () {
    ['red' => $red, 'blue' => $blue] = makeVariableProduct();

    StorefrontSession::addToCart('apron', 1, $red->id);
    StorefrontSession::addToCart('apron', 2, $blue->id);

    $lines = StorefrontSession::cartLines();

    expect($lines)->toHaveCount(2)
        ->and($lines->pluck('label')->all())->toEqualCanonicalizing(['Red', 'Blue'])
        ->and($lines->firstWhere('label', 'Blue')['unit_price_cents'])->toBe(129900)
        ->and($lines->firstWhere('label', 'Blue')['qty'])->toBe(2);
});

it('clamps the quantity stepper between 1 and 99', function () {
    $product = makeProduct(['slug' => 'qty-product']);

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->set('qty', 1)->call('decQty')->assertSet('qty', 1)
        ->set('qty', 99)->call('incQty')->assertSet('qty', 99)
        ->set('qty', 5)->call('incQty')->assertSet('qty', 6)->call('decQty')->assertSet('qty', 5);
});

it('picks related products once and keeps them stable across round-trips', function () {
    foreach (range(1, 4) as $i) {
        makeProduct(['name' => "Related {$i}", 'slug' => "related-{$i}"]);
    }
    $product = makeProduct(['slug' => 'main-product']);

    $component = Livewire::test('pages::storefront.product', ['product' => $product]);
    $firstPick = $component->get('relatedIds');

    expect($firstPick)->not->toBeEmpty();

    // A round-trip (qty change) must not reshuffle or re-query the selection.
    $component->call('incQty')->call('decQty');

    expect($component->get('relatedIds'))->toBe($firstPick);
});

it('shows no related products when the product has no primary category', function () {
    makeProduct(['slug' => 'other-product']);
    $product = makeProduct(['slug' => 'uncategorised', 'primary_category_id' => null]);

    $ids = Livewire::test('pages::storefront.product', ['product' => $product])->get('relatedIds');

    expect($ids)->toBeEmpty();
});

it('excludes self, out-of-stock, price-less and hidden products from related', function () {
    $product = makeProduct(['slug' => 'main']);
    $visible = makeProduct(['slug' => 'rel-visible']);
    $outOfStock = makeProduct(['slug' => 'rel-oos', 'stock_status' => StockStatus::OUT_OF_STOCK->value]);
    $priceless = makeProduct(['slug' => 'rel-noprice', 'price' => null]);
    $hidden = makeProduct(['slug' => 'rel-hidden', 'visibility' => ProductVisibility::HIDDEN->value]);

    $ids = Livewire::test('pages::storefront.product', ['product' => $product])->get('relatedIds');

    expect($ids)->toContain($visible->id)
        ->not->toContain($product->id)
        ->not->toContain($outOfStock->id)
        ->not->toContain($priceless->id)
        ->not->toContain($hidden->id);
});

it('uses the parent bundle price when one is set', function () {
    $component = makeProduct(['slug' => 'bundle-comp', 'price' => 40000]);
    $bundle = makeProduct(['slug' => 'bundle-priced', 'type' => 'bundled', 'price' => 200000]);
    BundleItem::create([
        'bundle_product_id' => $bundle->id, 'product_id' => $component->id,
        'quantity' => 2, 'is_optional' => false, 'sort_order' => 0,
    ]);

    $instance = Livewire::test('pages::storefront.product', ['product' => $bundle])->instance();

    expect($instance->bundlePriceCents)->toBe(200000);
});

it('sums required components for a bundle with no parent price and ignores optional items', function () {
    $required = makeProduct(['slug' => 'bundle-req', 'price' => 40000]);
    $optional = makeProduct(['slug' => 'bundle-opt', 'price' => 99900]);
    $bundle = makeProduct(['slug' => 'bundle-summed', 'type' => 'bundled', 'price' => null]);

    BundleItem::create([
        'bundle_product_id' => $bundle->id, 'product_id' => $required->id,
        'quantity' => 2, 'is_optional' => false, 'sort_order' => 0,
    ]);
    BundleItem::create([
        'bundle_product_id' => $bundle->id, 'product_id' => $optional->id,
        'quantity' => 1, 'is_optional' => true, 'sort_order' => 1,
    ]);

    $instance = Livewire::test('pages::storefront.product', ['product' => $bundle])->instance();

    // 40000 × 2 required; the optional 99900 line is excluded.
    expect($instance->bundlePriceCents)->toBe(80000);
});

it('links the brand eyebrow to the brand website in a new tab', function () {
    $this->brand->update(['website_url' => 'https://www.ranciliogroup.com']);
    $product = makeProduct(['slug' => 'branded-wok']);

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->assertSeeHtml('href="https://www.ranciliogroup.com"')
        ->assertSeeHtml('target="_blank"')
        ->assertSeeHtml('rel="noopener noreferrer"')
        ->assertSee('TestBrand');
});

it('leaves the brand eyebrow as plain text when no website is defined', function () {
    $product = makeProduct(['slug' => 'unbranded-wok']);

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->assertSee('TestBrand')
        ->assertDontSeeHtml('rel="noopener noreferrer"');
});

it('refuses to link a brand website that is not http or https', function () {
    // The admin form's `url` rule admits other schemes; this lands in a public href.
    $this->brand->update(['website_url' => 'javascript:alert(1)']);
    $product = makeProduct(['slug' => 'nasty-wok']);

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->assertSee('TestBrand')
        ->assertDontSee('javascript:alert(1)', false)
        ->assertDontSeeHtml('rel="noopener noreferrer"');
});

/**
 * Two-axis variable product: Size (S/L) x Depth (20/60), with the S/60 combination
 * deliberately missing so impossible pairings can be asserted.
 *
 * @return array{product: Product, variants: array<string, ProductVariant>}
 */
function makeTwoAxisProduct(): array
{
    $sizeAttr = Attribute::create(['name' => 'GN Size', 'slug' => 'gn-size', 'type' => 'select', 'is_active' => true, 'sort_order' => 1]);
    $depthAttr = Attribute::create(['name' => 'Depth', 'slug' => 'depth', 'type' => 'select', 'is_active' => true, 'sort_order' => 2]);

    $values = [
        'small' => AttributeValue::create(['attribute_id' => $sizeAttr->id, 'value' => '2/3 GN', 'label' => '2/3 GN', 'slug' => '23-gn', 'sort_order' => 1, 'is_active' => true]),
        'large' => AttributeValue::create(['attribute_id' => $sizeAttr->id, 'value' => '1/1 GN', 'label' => '1/1 GN', 'slug' => '11-gn', 'sort_order' => 2, 'is_active' => true]),
        'shallow' => AttributeValue::create(['attribute_id' => $depthAttr->id, 'value' => '20 mm', 'label' => '20 mm', 'slug' => '20-mm', 'sort_order' => 1, 'is_active' => true]),
        'deep' => AttributeValue::create(['attribute_id' => $depthAttr->id, 'value' => '60 mm', 'label' => '60 mm', 'slug' => '60-mm', 'sort_order' => 2, 'is_active' => true]),
    ];

    $product = makeProduct(['name' => 'Granite Pan', 'slug' => 'granite-pan', 'type' => 'variable', 'price' => 150000]);

    ProductAttribute::create(['product_id' => $product->id, 'attribute_id' => $sizeAttr->id, 'values' => ['23-gn', '11-gn'], 'is_variation_attribute' => true, 'is_visible' => true, 'sort_order' => 1]);
    ProductAttribute::create(['product_id' => $product->id, 'attribute_id' => $depthAttr->id, 'values' => ['20-mm', '60-mm'], 'is_variation_attribute' => true, 'is_visible' => true, 'sort_order' => 2]);

    $make = function (string $sku, int $price, array $valueKeys) use ($product, $values) {
        $variant = ProductVariant::create([
            'product_id' => $product->id, 'sku' => $sku, 'price' => $price,
            'stock_status' => StockStatus::IN_STOCK->value, 'is_active' => true, 'sort_order' => 1,
        ]);
        $variant->attributeValues()->attach(collect($valueKeys)->map(fn ($k) => $values[$k]->id)->all());

        return $variant;
    };

    return ['product' => $product->fresh(), 'variants' => [
        'small-shallow' => $make('GP-23-20', 100000, ['small', 'shallow']),
        'large-shallow' => $make('GP-11-20', 130000, ['large', 'shallow']),
        'large-deep' => $make('GP-11-60', 160000, ['large', 'deep']),
        // No small/deep variant exists.
    ]];
}

it('labels each axis when a product varies on more than one', function () {
    ['product' => $product] = makeTwoAxisProduct();

    $html = Livewire::test('pages::storefront.product', ['product' => $product])->html();

    // The single section title stays, but with two axes each row needs its own name.
    expect($html)->toContain('Variations available')
        ->and($html)->toContain('GN Size')
        ->and($html)->toContain('Depth');
});

it('resolves a variant only once both axes are chosen', function () {
    ['product' => $product, 'variants' => $variants] = makeTwoAxisProduct();

    $component = Livewire::test('pages::storefront.product', ['product' => $product])
        ->set('selectedOptions', []);

    // One axis chosen is not enough to identify a variant.
    $component->call('selectOption', 'gn-size', '11-gn');
    expect($component->instance()->selectedVariant)->toBeNull();

    $component->call('selectOption', 'depth', '60-mm');
    expect($component->instance()->selectedVariant?->id)->toBe($variants['large-deep']->id);
});

it('disables an option no variant can satisfy alongside the current selection', function () {
    ['product' => $product] = makeTwoAxisProduct();

    $component = Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('selectOption', 'gn-size', '23-gn');

    // 2/3 GN only exists shallow, so 60 mm must be unselectable while it is chosen.
    expect($component->instance()->isOptionAvailable('depth', '20-mm'))->toBeTrue()
        ->and($component->instance()->isOptionAvailable('depth', '60-mm'))->toBeFalse();

    // Switching to 1/1 GN, which exists in both depths, re-enables it.
    $component->call('selectOption', 'gn-size', '11-gn');

    expect($component->instance()->isOptionAvailable('depth', '60-mm'))->toBeTrue();
});

it('spans the price range across every combination', function () {
    ['product' => $product] = makeTwoAxisProduct();

    expect(Livewire::test('pages::storefront.product', ['product' => $product])->instance()->variantPriceRange)
        ->toBe(['min' => 100000, 'max' => 160000]);
});

it('shows the add-to-cart button while a product is not yet in the cart', function () {
    $product = makeProduct(['slug' => 'not-in-cart']);

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->assertSet('cartQty', 0)
        ->assertSee('Add to cart')
        // The pre-add stepper drives $qty, not the cart.
        ->assertSee('wire:click="decQty"', false)
        ->assertDontSee('In your cart');
});

it('replaces the add-to-cart button with a cart counter once the product is in the cart', function () {
    $product = makeProduct(['slug' => 'in-cart']);
    StorefrontSession::addToCart('in-cart', 2);

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->assertSet('cartQty', 2)
        ->assertSee('In your cart')
        // The cart counter is the only way to change quantity now: no add button,
        // and no second stepper driving $qty.
        ->assertDontSee('Add to cart')
        ->assertDontSee('wire:click="decQty"', false)
        ->assertSee('wire:click="decCartQty"', false)
        ->assertDontSee('Go to cart');
});

it('swaps the button for the counter in the same request, without a page refresh', function () {
    $product = makeProduct(['slug' => 'swap-now']);

    // addToCart() normally skipRender()s so listings do not tear down their JS; the
    // product page must opt out, or the swap would only appear on the next load.
    Livewire::test('pages::storefront.product', ['product' => $product])
        ->assertSee('Add to cart')
        ->call('addThisToCart')
        ->assertSee('In your cart')
        ->assertDontSee('Add to cart');
});

it('edits the cart straight from the product page counter', function () {
    $product = makeProduct(['slug' => 'counter-product']);
    StorefrontSession::addToCart('counter-product', 1);

    $component = Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('incCartQty')
        ->assertSet('cartQty', 2);

    expect(StorefrontSession::cart())->toBe(['counter-product' => 2]);

    $component->call('decCartQty')->assertSet('cartQty', 1);
    expect(StorefrontSession::cart())->toBe(['counter-product' => 1]);

    // Stepping off the last one empties the line and brings the button back.
    $component->call('decCartQty')
        ->assertSet('cartQty', 0)
        ->assertSee('Add to cart');

    expect(StorefrontSession::cart())->toBe([]);
});

it('does not re-prompt for accessories when bumping a product already in the cart', function () {
    $product = makeProduct(['slug' => 'oven-again']);
    $accessory = makeProduct(['name' => 'Tray', 'slug' => 'tray', 'price' => 5000, 'status' => ProductStatus::PUBLISHED->value]);
    ProductLink::create([
        'product_id' => $product->id, 'linked_product_id' => $accessory->id,
        'type' => ProductLinkType::ACCESSORY, 'sort_order' => 0,
    ]);

    // The first add prompts...
    $component = Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('addThisToCart')
        ->assertSet('showAccessoryModal', true);

    $component->call('closeAccessoryModal');

    // ...but the counter must not ask again on every increment.
    $component->call('incCartQty')->assertSet('showAccessoryModal', false);
});

it('keeps the add-to-cart button for a variable product whose variant is in the cart', function () {
    ['product' => $product, 'blue' => $blue] = makeVariableProduct();
    StorefrontSession::addToCart('apron', 1, $blue->id);

    // Variable products count per variant in the modal, so the page-level counter
    // must stay out of it and the button must remain.
    Livewire::test('pages::storefront.product', ['product' => $product])
        ->assertSet('cartQty', 0)
        ->assertSee('Add to cart')
        ->assertDontSee('In your cart');
});

it('toasts when the product page counter removes the last one from the cart', function () {
    $product = makeProduct(['name' => 'Wok Range', 'slug' => 'toast-remove']);
    StorefrontSession::addToCart('toast-remove', 1);

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('decCartQty')
        ->assertDispatched('toast-show', fn ($event, $params) => str_contains(json_encode($params), 'Item removed'));

    expect(StorefrontSession::cart())->toBe([]);
});

it('toasts a reduced quantity rather than a removal when some remain', function () {
    $product = makeProduct(['name' => 'Wok Range', 'slug' => 'toast-reduce']);
    StorefrontSession::addToCart('toast-reduce', 3);

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('decCartQty')
        ->assertDispatched('toast-show', function ($event, $params) {
            $json = json_encode($params);

            return str_contains($json, 'Cart updated') && str_contains($json, 'reduced to 2');
        });
});

it('toasts when a variation counter removes the last one from the cart', function () {
    ['product' => $product, 'blue' => $blue] = makeVariableProduct();
    StorefrontSession::addToCart('apron', 1, $blue->id);

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('decVariationQty', $blue->id)
        ->assertDispatched('toast-show', function ($event, $params) {
            $json = json_encode($params);

            return str_contains($json, 'Item removed') && str_contains($json, 'Chef Apron Blue');
        });

    expect(StorefrontSession::cart())->toBe([]);
});

it('stays silent when a variation counter is clicked with nothing in the cart', function () {
    ['product' => $product, 'blue' => $blue] = makeVariableProduct();

    Livewire::test('pages::storefront.product', ['product' => $product])
        ->call('decVariationQty', $blue->id)
        ->assertNotDispatched('toast-show');
});
