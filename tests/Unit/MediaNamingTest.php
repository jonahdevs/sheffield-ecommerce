<?php

use App\Support\MediaNaming;

test('product name uses name and sku slugs', function () {
    expect(MediaNaming::product('Manual Vegetable Slicer', 'IMG/FPR/00130', 'JPG'))
        ->toBe('manual-vegetable-slicer-imgfpr00130.jpg');
});

test('product falls back when name or sku is blank', function () {
    expect(MediaNaming::product('', null, 'png'))->toBe('product-no-sku.png');
});

test('product gallery appends index', function () {
    expect(MediaNaming::productGallery('Oven', 'SKU1', 2, 'webp'))
        ->toBe('oven-sku1-2.webp');
});

test('product variant appends variant index', function () {
    expect(MediaNaming::productVariant('Oven', 'SKU1', 3, 'jpeg'))
        ->toBe('oven-sku1-variant-3.jpeg');
});

test('category maps collection to suffix', function () {
    expect(MediaNaming::category('Vegetable Processors', 'square', 'webp'))->toBe('vegetable-processors.webp');
    expect(MediaNaming::category('Vegetable Processors', 'icon', 'png'))->toBe('vegetable-processors-icon.png');
    expect(MediaNaming::category('Vegetable Processors', 'banner', 'jpg'))->toBe('vegetable-processors-banner.jpg');
});

test('brand uses slug', function () {
    expect(MediaNaming::brand('DR. COFFEE', 'jpg'))->toBe('dr-coffee.jpg');
});

test('avatar combines name and id', function () {
    expect(MediaNaming::avatar('Jane Doe', 42, 'png'))->toBe('jane-doe-42.png');
});

test('extension is normalised and defaults to jpg', function () {
    expect(MediaNaming::brand('acme', '.PNG'))->toBe('acme.png');
    expect(MediaNaming::brand('acme', ''))->toBe('acme.jpg');
});
