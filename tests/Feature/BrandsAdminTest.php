<?php

use App\Models\Brand;
use App\Models\Product;
use Livewire\Livewire;

beforeEach(function () {
    actingAsAdmin();
});

it('sorts brands by name and toggles direction on repeat clicks', function () {
    Brand::create(['name' => 'Zebra Appliances', 'slug' => 'zebra-appliances']);
    Brand::create(['name' => 'Alpha Kitchen', 'slug' => 'alpha-kitchen']);

    $component = Livewire::test('pages::admin.brands.index')->call('sort', 'name');

    expect($component->get('sortBy'))->toBe('name')
        ->and($component->get('sortDirection'))->toBe('asc')
        ->and($component->get('brands')->pluck('name')->all())
        ->toBe(['Alpha Kitchen', 'Zebra Appliances']);

    // Clicking the same column again flips the direction.
    $component->call('sort', 'name');

    expect($component->get('sortDirection'))->toBe('desc')
        ->and($component->get('brands')->pluck('name')->all())
        ->toBe(['Zebra Appliances', 'Alpha Kitchen']);
});

it('sorts brands by attached product count', function () {
    $few = Brand::create(['name' => 'Few Products', 'slug' => 'few-products']);
    $many = Brand::create(['name' => 'Many Products', 'slug' => 'many-products']);

    Product::factory()->create(['brand_id' => $few->id]);
    Product::factory()->count(3)->create(['brand_id' => $many->id]);

    // First click sorts ascending, so the brand with the fewest products leads.
    $brands = Livewire::test('pages::admin.brands.index')
        ->call('sort', 'products_count')
        ->get('brands');

    expect($brands->pluck('name')->all())->toBe(['Few Products', 'Many Products'])
        ->and($brands->firstWhere('name', 'Many Products')->products_count)->toBe(3);
});
