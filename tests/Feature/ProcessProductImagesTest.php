<?php

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('media');
});

/**
 * Attach a fake image to a product's `images` collection.
 *
 * @param  array<string, mixed>  $properties
 */
function attachProductImage(Product $product, array $properties = []): void
{
    $file = UploadedFile::fake()->image('sample.jpg', 300, 300);

    $product->addMedia($file->getRealPath())
        ->usingFileName('sample.jpg')
        ->withCustomProperties($properties)
        ->toMediaCollection('images');
}

it('considers every image in folder mode regardless of bg_processed', function () {
    $product = Product::factory()->create();
    attachProductImage($product, ['bg_processed' => true]);
    attachProductImage($product);

    $this->artisan('products:process-images', ['--dry-run' => true])
        ->expectsOutputToContain('Processing up to 2 image(s) [folder, dry run].')
        ->assertSuccessful();
});

it('skips already-adopted images in --replace mode', function () {
    $product = Product::factory()->create();
    attachProductImage($product, ['bg_processed' => true]);
    attachProductImage($product); // not yet adopted

    $this->artisan('products:process-images', ['--replace' => true, '--dry-run' => true])
        ->expectsOutputToContain('Processing up to 1 image(s) [replace, dry run].')
        ->assertSuccessful();
});

it('reprocesses adopted images with --fresh in --replace mode', function () {
    $product = Product::factory()->create();
    attachProductImage($product, ['bg_processed' => true]);
    attachProductImage($product);

    $this->artisan('products:process-images', ['--replace' => true, '--fresh' => true, '--dry-run' => true])
        ->expectsOutputToContain('Processing up to 2 image(s) [replace, dry run].')
        ->assertSuccessful();
});

it('limits to a single product with --sku', function () {
    $target = Product::factory()->create(['sku' => 'TARGET-001']);
    $other = Product::factory()->create(['sku' => 'OTHER-002']);
    attachProductImage($target);
    attachProductImage($other);

    $this->artisan('products:process-images', ['--sku' => 'TARGET-001', '--dry-run' => true])
        ->expectsOutputToContain('Processing up to 1 image(s) [folder, dry run].')
        ->assertSuccessful();
});

it('fails when the SKU does not exist', function () {
    $this->artisan('products:process-images', ['--sku' => 'DOES-NOT-EXIST'])
        ->expectsOutputToContain('No product found with SKU: DOES-NOT-EXIST')
        ->assertFailed();
});

it('reports nothing to process when the product has no images', function () {
    Product::factory()->create();

    $this->artisan('products:process-images', ['--dry-run' => true])
        ->expectsOutputToContain('No images to process.')
        ->assertSuccessful();
});

it('requires a Gemini API key for --ai mode', function () {
    config(['services.gemini.key' => '']);

    $product = Product::factory()->create();
    attachProductImage($product);

    $this->artisan('products:process-images', ['--ai' => true, '--dry-run' => true])
        ->expectsOutputToContain('--ai requires GEMINI_API_KEY')
        ->assertFailed();
});
