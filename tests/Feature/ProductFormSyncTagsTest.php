<?php

use App\Livewire\Forms\Admin\ProductForm;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('syncTags method exists in ProductForm', function () {
    $reflection = new ReflectionClass(ProductForm::class);

    expect($reflection->hasMethod('syncTags'))->toBeTrue();

    $method = $reflection->getMethod('syncTags');
    expect($method->isProtected())->toBeTrue();
});

test('syncRelationships calls syncTags', function () {
    $reflection = new ReflectionClass(ProductForm::class);
    $method = $reflection->getMethod('syncRelationships');
    $method->setAccessible(true);

    // Get the method source code
    $filename = $reflection->getFileName();
    $startLine = $method->getStartLine();
    $endLine = $method->getEndLine();
    $length = $endLine - $startLine;

    $source = file($filename);
    $body = implode('', array_slice($source, $startLine, $length));

    // Verify syncTags is called
    expect($body)->toContain('$this->syncTags($product)');
});

test('syncTags separates positive and negative tag IDs', function () {
    // Create a product
    $product = Product::factory()->create();

    // Create a real tag
    $tag = Tag::findOrCreate('TestTag');

    // Use reflection to test the protected method
    $component = Mockery::mock('Livewire\Component');
    $form = new ProductForm($component, 'form');
    $form->tag_ids = [$tag->id, -1, -2];

    $reflection = new ReflectionClass($form);
    $method = $reflection->getMethod('syncTags');
    $method->setAccessible(true);

    // Call the method
    $method->invoke($form, $product);

    // Refresh and verify only positive ID was synced
    $product->refresh();
    expect($product->tags()->count())->toBe(1)
        ->and($product->tags->first()->id)->toBe($tag->id);
});

test('syncTags handles empty tag_ids array', function () {
    // Create a product with a tag
    $product = Product::factory()->create();
    $tag = Tag::findOrCreate('InitialTag');
    $product->attachTag($tag);

    // Use reflection to test the protected method
    $component = Mockery::mock('Livewire\Component');
    $form = new ProductForm($component, 'form');
    $form->tag_ids = [];

    $reflection = new ReflectionClass($form);
    $method = $reflection->getMethod('syncTags');
    $method->setAccessible(true);

    // Call the method
    $method->invoke($form, $product);

    // Refresh and verify all tags were removed
    $product->refresh();
    expect($product->tags()->count())->toBe(0);
});
