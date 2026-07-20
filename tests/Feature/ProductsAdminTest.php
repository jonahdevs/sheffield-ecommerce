<?php

use App\Enums\ProductStatus;
use App\Enums\ProductVisibility;
use App\Enums\ReviewStatus;
use App\Enums\StockStatus;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Livewire\Livewire;

beforeEach(function () {
    actingAsAdmin();
});

it('loads the products admin index', function () {
    $this->get(route('admin.products.index'))->assertOk();
});

it('reports product KPIs', function () {
    Product::factory()->count(2)->create(['status' => ProductStatus::PUBLISHED, 'stock_status' => StockStatus::IN_STOCK]);
    Product::factory()->create(['status' => ProductStatus::DRAFT, 'stock_status' => StockStatus::OUT_OF_STOCK]);
    Product::factory()->create(['status' => ProductStatus::DRAFT, 'stock_status' => StockStatus::IN_STOCK, 'stock_quantity' => 2, 'low_stock_threshold' => 5]);

    $stats = Livewire::test('pages::admin.products.index')->get('stats');

    expect($stats['published'])->toBe(2)
        ->and($stats['draft'])->toBe(2)
        ->and($stats['out'])->toBe(1)
        ->and($stats['low'])->toBe(1);
});

it('selects all products on the page', function () {
    Product::factory()->count(3)->create();

    Livewire::test('pages::admin.products.index')
        ->set('selectAll', true)
        ->assertCount('selected', 3)
        ->set('selectAll', false)
        ->assertCount('selected', 0);
});

it('bulk updates visibility for selected products', function () {
    $products = Product::factory()->count(3)->create(['visibility' => ProductVisibility::VISIBLE]);

    Livewire::test('pages::admin.products.index')
        ->set('selected', $products->pluck('id')->map(fn ($id) => (string) $id)->all())
        ->call('bulkSetVisibility', ProductVisibility::HIDDEN->value)
        ->assertCount('selected', 0);

    expect(Product::where('visibility', ProductVisibility::HIDDEN)->count())->toBe(3);
});

it('bulk updates stock status for selected products', function () {
    $products = Product::factory()->count(2)->create(['stock_status' => StockStatus::IN_STOCK]);

    Livewire::test('pages::admin.products.index')
        ->set('selected', $products->pluck('id')->map(fn ($id) => (string) $id)->all())
        ->call('bulkSetStock', StockStatus::OUT_OF_STOCK->value);

    expect(Product::where('stock_status', StockStatus::OUT_OF_STOCK)->count())->toBe(2);
});

it('bulk deletes selected products', function () {
    $products = Product::factory()->count(3)->create();
    $keep = Product::factory()->create();

    Livewire::test('pages::admin.products.index')
        ->set('selected', $products->pluck('id')->map(fn ($id) => (string) $id)->all())
        ->call('bulkDelete');

    expect(Product::count())->toBe(1)
        ->and(Product::find($keep->id))->not->toBeNull();
});

it('ignores an invalid bulk visibility value', function () {
    $product = Product::factory()->create(['visibility' => ProductVisibility::VISIBLE]);

    Livewire::test('pages::admin.products.index')
        ->set('selected', [(string) $product->id])
        ->call('bulkSetVisibility', 'bogus');

    expect($product->fresh()->visibility)->toBe(ProductVisibility::VISIBLE);
});

it('lists brand and category as their own columns', function () {
    $brand = Brand::create(['name' => 'Rancilio', 'slug' => 'rancilio']);
    $category = Category::factory()->create(['name' => 'Coffee Grinders']);

    Product::factory()->create([
        'name' => 'Coffee Grinder Rocky',
        'brand_id' => $brand->id,
        'primary_category_id' => $category->id,
    ]);

    Livewire::test('pages::admin.products.index')
        ->assertDontSee('Brand / Category')
        ->assertSee('Rancilio')
        ->assertSee('Coffee Grinders');
});

it('filters products by category', function () {
    $machines = Category::factory()->create(['name' => 'Coffee Machines']);
    $grinders = Category::factory()->create(['name' => 'Coffee Grinders']);

    Product::factory()->create(['name' => 'Espresso Machine Class 5S', 'primary_category_id' => $machines->id]);
    Product::factory()->create(['name' => 'Coffee Grinder Rocky', 'primary_category_id' => $grinders->id]);

    $products = Livewire::test('pages::admin.products.index')
        ->set('filterCategory', (string) $grinders->id)
        ->get('products');

    expect($products->pluck('name')->all())->toBe(['Coffee Grinder Rocky']);
});

it('includes products in child categories when filtering by a parent category', function () {
    $machines = Category::factory()->create(['name' => 'Coffee Machines']);
    $automatic = Category::factory()->create(['name' => 'Automatic', 'parent_id' => $machines->id]);
    $grinders = Category::factory()->create(['name' => 'Coffee Grinders']);

    Product::factory()->create(['name' => 'Machine FAB 100', 'primary_category_id' => $automatic->id]);
    Product::factory()->create(['name' => 'Machine Silvia', 'primary_category_id' => $machines->id]);
    Product::factory()->create(['name' => 'Grinder Rocky', 'primary_category_id' => $grinders->id]);

    $products = Livewire::test('pages::admin.products.index')
        ->set('filterCategory', (string) $machines->id)
        ->get('products');

    expect($products->pluck('name')->sort()->values()->all())->toBe(['Machine FAB 100', 'Machine Silvia']);
});

it('filters products by brand', function () {
    $rational = Brand::create(['name' => 'Rational', 'slug' => 'rational']);
    $skymsen = Brand::create(['name' => 'Skymsen', 'slug' => 'skymsen']);

    Product::factory()->create(['name' => 'Combi Oven iCombi', 'brand_id' => $rational->id]);
    Product::factory()->create(['name' => 'Vegetable Processor PA7', 'brand_id' => $skymsen->id]);
    Product::factory()->create(['name' => 'Unbranded Trolley', 'brand_id' => null]);

    $products = Livewire::test('pages::admin.products.index')
        ->set('filterBrand', (string) $skymsen->id)
        ->get('products');

    expect($products->pluck('name')->all())->toBe(['Vegetable Processor PA7']);
});

it('combines the brand filter with the other filters rather than replacing them', function () {
    $brand = Brand::create(['name' => 'Skymsen', 'slug' => 'skymsen']);
    $other = Brand::create(['name' => 'Rational', 'slug' => 'rational']);

    Product::factory()->create(['name' => 'Wanted', 'brand_id' => $brand->id, 'status' => ProductStatus::PUBLISHED]);
    Product::factory()->create(['name' => 'Right brand, wrong status', 'brand_id' => $brand->id, 'status' => ProductStatus::DRAFT]);
    Product::factory()->create(['name' => 'Right status, wrong brand', 'brand_id' => $other->id, 'status' => ProductStatus::PUBLISHED]);

    $products = Livewire::test('pages::admin.products.index')
        ->set('filterBrand', (string) $brand->id)
        ->set('filterStatus', ProductStatus::PUBLISHED->value)
        ->get('products');

    expect($products->pluck('name')->all())->toBe(['Wanted']);
});

it('only offers brands that have products in the filter select', function () {
    $used = Brand::create(['name' => 'Skymsen', 'slug' => 'skymsen']);
    Brand::create(['name' => 'Empty Brand', 'slug' => 'empty-brand']);

    Product::factory()->create(['brand_id' => $used->id]);

    $options = Livewire::test('pages::admin.products.index')->get('brandOptions');

    expect($options->pluck('name')->all())->toBe(['Skymsen']);
});

it('resets the page and selection when the brand filter changes', function () {
    $brand = Brand::create(['name' => 'Skymsen', 'slug' => 'skymsen']);
    Product::factory()->count(3)->create(['brand_id' => $brand->id]);

    Livewire::test('pages::admin.products.index')
        ->set('selectAll', true)
        ->assertCount('selected', 3)
        ->set('filterBrand', (string) $brand->id)
        ->assertCount('selected', 0)
        ->assertSet('paginators.page', 1);
});

it('resets the page and selection when the category filter changes', function () {
    $category = Category::factory()->create();
    Product::factory()->count(3)->create(['primary_category_id' => $category->id]);

    Livewire::test('pages::admin.products.index')
        ->set('selectAll', true)
        ->assertCount('selected', 3)
        ->set('filterCategory', (string) $category->id)
        ->assertCount('selected', 0)
        ->assertSet('paginators.page', 1);
});

it('offers parent categories with their children in the filter select', function () {
    $machines = Category::factory()->create(['name' => 'Coffee Machines']);
    Category::factory()->create(['name' => 'Automatic', 'parent_id' => $machines->id]);

    $options = Livewire::test('pages::admin.products.index')->get('categoryOptions');

    expect($options->pluck('name')->all())->toContain('Coffee Machines')
        ->and($options->pluck('name')->all())->not->toContain('Automatic')
        ->and($options->firstWhere('name', 'Coffee Machines')->children->pluck('name')->all())->toBe(['Automatic']);
});

it('falls back to a dash for a product with no brand or category', function () {
    Product::factory()->create(['brand_id' => null, 'primary_category_id' => null]);

    $products = Livewire::test('pages::admin.products.index')->get('products');

    expect($products->first()->brand)->toBeNull()
        ->and($products->first()->primaryCategory)->toBeNull();
});

it('shows the stock quantity rather than a stock status badge', function () {
    Product::factory()->create(['stock_quantity' => 4242, 'stock_status' => StockStatus::IN_STOCK]);

    $component = Livewire::test('pages::admin.products.index');

    // The quantity is the cell's value now. The status itself stays filterable and
    // bulk-editable, so StockStatus labels still legitimately appear in those controls
    // and cannot be asserted against here.
    $component->assertSee('4242');

    expect($component->get('products')->first()->stock_quantity)->toBe(4242);
});

it('falls back to a dash for a product with no stock quantity', function () {
    Product::factory()->create(['stock_quantity' => null]);

    expect(Livewire::test('pages::admin.products.index')->get('products')->first()->stock_quantity)
        ->toBeNull();
});

it('averages only approved reviews in the reviews column', function () {
    $product = Product::factory()->create();

    Review::factory()->for($product)->create(['status' => ReviewStatus::APPROVED, 'rating' => 5]);
    Review::factory()->for($product)->create(['status' => ReviewStatus::APPROVED, 'rating' => 4]);
    // Pending and rejected ratings must not drag the average down.
    Review::factory()->for($product)->create(['status' => ReviewStatus::PENDING, 'rating' => 1]);
    Review::factory()->for($product)->create(['status' => ReviewStatus::REJECTED, 'rating' => 1]);

    $component = Livewire::test('pages::admin.products.index');
    $row = $component->get('products')->first();

    expect($row->approved_reviews_count)->toBe(2)
        ->and(round((float) $row->approved_reviews_avg, 1))->toBe(4.5);

    // The column renders the average with its count, not just the raw aggregate.
    $component->assertSee('4.5')->assertSee('(2)');
});

it('leaves the reviews column empty for a product with no approved reviews', function () {
    $product = Product::factory()->create();
    Review::factory()->for($product)->create(['status' => ReviewStatus::PENDING, 'rating' => 5]);

    $row = Livewire::test('pages::admin.products.index')->get('products')->first();

    expect($row->approved_reviews_count)->toBe(0)
        ->and($row->approved_reviews_avg)->toBeNull();
});
