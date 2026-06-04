<?php

use App\Imports\ProductsImport;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Maatwebsite\Excel\Facades\Excel;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('updates an existing product matched by sku', function () {
    Product::factory()->create(['name' => 'Old Name', 'sku' => 'SKU-001']);

    $import = new ProductsImport;

    $import->model([
        'name' => 'New Name',
        'sku' => 'SKU-001',
        'brand' => '',
        'primary_category' => '',
        'type' => 'simple',
        'status' => 'draft',
        'price_kes' => '1500',
        'sale_price_kes' => '',
        'cost_price_kes' => '',
        'stock_status' => 'in_stock',
        'stock_quantity' => '10',
        'visibility' => 'visible',
        'weight' => '',
        'is_taxable' => 'yes',
        'requires_shipping' => 'yes',
        'short_description' => '',
        'meta_title' => '',
        'meta_description' => '',
    ])?->save();

    expect($import->updatedCount)->toBe(1)
        ->and($import->importedCount)->toBe(0)
        ->and(Product::where('sku', 'SKU-001')->value('name'))->toBe('New Name')
        ->and(Product::where('sku', 'SKU-001')->value('price'))->toBe(150000);
});

it('creates a new product when sku does not exist', function () {
    $import = new ProductsImport;

    $import->model([
        'name' => 'Brand New Product',
        'sku' => 'SKU-NEW-999',
        'brand' => '',
        'primary_category' => '',
        'type' => 'simple',
        'status' => 'draft',
        'price_kes' => '500',
        'sale_price_kes' => '',
        'cost_price_kes' => '',
        'stock_status' => 'in_stock',
        'stock_quantity' => '',
        'visibility' => 'visible',
        'weight' => '',
        'is_taxable' => 'yes',
        'requires_shipping' => 'yes',
        'short_description' => '',
        'meta_title' => '',
        'meta_description' => '',
    ])?->save();

    expect($import->importedCount)->toBe(1)
        ->and(Product::where('sku', 'SKU-NEW-999')->exists())->toBeTrue();
});

it('resolves brand by name during import', function () {
    $brand = Brand::create(['name' => 'Acme Corp', 'slug' => 'acme-corp']);
    Product::factory()->create(['sku' => 'SKU-BRAND-01', 'brand_id' => null]);

    $import = new ProductsImport;

    $import->model([
        'name' => 'Some Product',
        'sku' => 'SKU-BRAND-01',
        'brand' => 'Acme Corp',
        'primary_category' => '',
        'type' => 'simple',
        'status' => 'draft',
        'price_kes' => '',
        'sale_price_kes' => '',
        'cost_price_kes' => '',
        'stock_status' => 'in_stock',
        'stock_quantity' => '',
        'visibility' => 'visible',
        'weight' => '',
        'is_taxable' => 'yes',
        'requires_shipping' => 'yes',
        'short_description' => '',
        'meta_title' => '',
        'meta_description' => '',
    ])?->save();

    expect(Product::where('sku', 'SKU-BRAND-01')->value('brand_id'))->toBe($brand->id);
});

it('shows import results after upload', function () {
    Excel::fake();

    $file = UploadedFile::fake()->create('products.xlsx', 1, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    Excel::shouldReceive('import')->once()->andReturnUsing(function (ProductsImport $import) {
        $import->importedCount = 5;
        $import->updatedCount = 2;
    });

    Livewire::test('pages::admin.products.index')
        ->set('importFile', $file)
        ->call('importProducts')
        ->assertSet('importResults.created', 5)
        ->assertSet('importResults.updated', 2)
        ->assertSet('importFile', null);
});

it('closes import modal and resets state', function () {
    Livewire::test('pages::admin.products.index')
        ->set('showImportModal', true)
        ->call('closeImportModal')
        ->assertSet('showImportModal', false)
        ->assertSet('importResults', null);
});
