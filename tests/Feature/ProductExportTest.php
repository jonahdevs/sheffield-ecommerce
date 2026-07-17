<?php

use App\Enums\ProductStatus;
use App\Exports\ProductsExport;
use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;

beforeEach(function () {
    actingAsAdmin();
});

it('downloads an xlsx export of products', function () {
    Excel::fake();

    Product::factory()->count(3)->create();

    $this->get(route('admin.products.export'))->assertOk();

    Excel::assertDownloaded('products.xlsx', function (ProductsExport $export) {
        return $export->query()->count() === 3;
    });
});

it('downloads a csv export of products', function () {
    Excel::fake();

    Product::factory()->count(2)->create();

    $this->get(route('admin.products.export', ['format' => 'csv']))->assertOk();

    Excel::assertDownloaded('products.csv');
});

it('applies status filter to export', function () {
    Excel::fake();

    Product::factory()->count(2)->create(['status' => ProductStatus::PUBLISHED]);
    Product::factory()->create(['status' => ProductStatus::DRAFT]);

    $this->get(route('admin.products.export', ['status' => ProductStatus::PUBLISHED->value]))->assertOk();

    Excel::assertDownloaded('products.xlsx', function (ProductsExport $export) {
        return $export->query()->count() === 2;
    });
});

it('applies category filter to export, including child categories', function () {
    Excel::fake();

    $machines = Category::factory()->create(['name' => 'Coffee Machines']);
    $automatic = Category::factory()->create(['name' => 'Automatic', 'parent_id' => $machines->id]);

    Product::factory()->create(['primary_category_id' => $machines->id]);
    Product::factory()->create(['primary_category_id' => $automatic->id]);
    Product::factory()->create(['primary_category_id' => Category::factory()->create()->id]);

    $this->get(route('admin.products.export', ['category' => $machines->id]))->assertOk();

    Excel::assertDownloaded('products.xlsx', function (ProductsExport $export) {
        return $export->query()->count() === 2;
    });
});

it('exports correct headings', function () {
    $export = new ProductsExport;

    expect($export->headings())->toContain('Name', 'SKU', 'Brand', 'Price (KES)', 'Stock Status');
});

it('maps price from cents to kes', function () {
    $product = Product::factory()->create(['price' => 150000, 'sale_price' => 120000]);
    $product->load(['brand', 'primaryCategory']);

    $export = new ProductsExport;
    $row = $export->map($product);

    // Price (KES) is index 7, Sale Price (KES) is index 8
    expect($row[7])->toBe(1500.00)
        ->and($row[8])->toBe(1200.00);
});

it('returns the pdf product catalog', function () {
    Product::factory()->count(5)->create();

    $this->get(route('admin.products.pdf'))->assertOk();
})->skip('Requires Browsershot / Chrome configured in the test environment.');
