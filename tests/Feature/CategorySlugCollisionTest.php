<?php

use App\Enums\CategoryStatus;
use App\Models\Category;
use Database\Seeders\CategorySeeder;

/**
 * The storefront routes /shop/{category:slug} with no parent segment, so slugs stay
 * globally unique even though child names repeat across branches.
 */
function seedCategory(string $name, string $slug): Category
{
    return Category::create([
        'name' => $name,
        'slug' => $slug,
        'status' => CategoryStatus::ACTIVE,
        'sort_order' => 1,
    ]);
}

it('gives a child the bare slug while it is free', function () {
    seedCategory('Coffee Machines', 'coffee-machines');

    expect(CategorySeeder::deriveSlug('Automatic', 'Coffee Machines'))->toBe('automatic');
});

it('qualifies a colliding child slug with its parent', function () {
    seedCategory('Coffee Machines', 'coffee-machines');
    seedCategory('Dishwashers', 'dishwashers');

    // First one in keeps the bare slug, so URLs never shift underneath existing links.
    $first = CategorySeeder::deriveSlug('Automatic', 'Coffee Machines');
    seedCategory('Automatic', $first);

    expect($first)->toBe('automatic')
        ->and(CategorySeeder::deriveSlug('Automatic', 'Dishwashers'))->toBe('dishwashers-automatic');
});

it('refuses a duplicate top-level category, which has no parent to qualify it', function () {
    seedCategory('Refrigeration', 'refrigeration');

    expect(fn () => CategorySeeder::deriveSlug('Refrigeration', null))
        ->toThrow(RuntimeException::class, 'Duplicate top-level category');
});

it('refuses when even the parent-qualified slug is taken', function () {
    seedCategory('Coffee Machines', 'coffee-machines');
    seedCategory('Automatic', 'automatic');
    seedCategory('Something Else', 'coffee-machines-automatic');

    expect(fn () => CategorySeeder::deriveSlug('Automatic', 'Coffee Machines'))
        ->toThrow(RuntimeException::class, 'is taken too');
});
