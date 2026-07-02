<?php

use App\Enums\CategoryStatus;
use App\Models\Category;
use Database\Seeders\PermissionSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    actingAsAdmin();
});

it('sets a category status from the actions dropdown', function () {
    $category = Category::factory()->create(['status' => CategoryStatus::DRAFT]);

    Livewire::test('pages::admin.categories.index')
        ->call('quickSetStatus', $category->id, CategoryStatus::ARCHIVED->value);

    expect($category->refresh()->status)->toBe(CategoryStatus::ARCHIVED);
});

it('ignores an unknown status value', function () {
    $category = Category::factory()->create(['status' => CategoryStatus::ACTIVE]);

    Livewire::test('pages::admin.categories.index')
        ->call('quickSetStatus', $category->id, 'not-a-status');

    expect($category->refresh()->status)->toBe(CategoryStatus::ACTIVE);
});
