<?php

use App\Enums\CategoryStatus;
use App\Models\Category;
use Database\Seeders\CategoryReferenceResolver;

/**
 * products.json addresses categories by name, which stops being unique as soon as two
 * branches reuse a child name ("Automatic" under both Coffee Machines and Dishwashers).
 * The resolver takes a full path for those, and refuses to guess.
 */
function makeCategory(string $name, ?Category $parent = null, ?string $slug = null): Category
{
    return Category::create([
        'name' => $name,
        'slug' => $slug ?? Str::slug(($parent?->name ?? '').' '.$name),
        'parent_id' => $parent?->id,
        'status' => CategoryStatus::ACTIVE,
        'sort_order' => 1,
    ]);
}

it('resolves a child by its full path', function () {
    $coffee = makeCategory('Coffee Machines', slug: 'coffee-machines');
    $automatic = makeCategory('Automatic', $coffee);
    $accessories = makeCategory('Automatic Accessories', $automatic);

    $resolver = new CategoryReferenceResolver;

    expect($resolver->idFor('Coffee Machines > Automatic'))->toBe($automatic->id)
        // Three levels deep, and tolerant of casing and separator spacing.
        ->and($resolver->idFor('coffee machines>automatic>automatic accessories'))->toBe($accessories->id);
});

it('still accepts a bare name while it is unique', function () {
    $coffee = makeCategory('Coffee Machines', slug: 'coffee-machines');
    $grinders = makeCategory('Coffee Grinders', $coffee);

    $resolver = new CategoryReferenceResolver;

    expect($resolver->idFor('Coffee Machines'))->toBe($coffee->id)
        ->and($resolver->idFor('Coffee Grinders'))->toBe($grinders->id);
});

it('refuses to guess when a bare name is reused across branches', function () {
    $coffee = makeCategory('Coffee Machines', slug: 'coffee-machines');
    $dishwashers = makeCategory('Dishwashers', slug: 'dishwashers');
    $coffeeAuto = makeCategory('Automatic', $coffee);
    $dishAuto = makeCategory('Automatic', $dishwashers);

    $resolver = new CategoryReferenceResolver;

    // The bare name is ambiguous...
    expect(fn () => $resolver->idFor('Automatic'))
        ->toThrow(RuntimeException::class, 'is ambiguous');

    // ...but each path still resolves to its own branch.
    expect($resolver->idFor('Coffee Machines > Automatic'))->toBe($coffeeAuto->id)
        ->and($resolver->idFor('Dishwashers > Automatic'))->toBe($dishAuto->id);
});

it('throws rather than seeding a null category for an unknown reference', function () {
    makeCategory('Coffee Machines', slug: 'coffee-machines');

    $resolver = new CategoryReferenceResolver;

    // A silent null here would drop the product off every category page.
    expect(fn () => $resolver->idFor('Espresso Machines'))
        ->toThrow(RuntimeException::class, 'Unknown category "Espresso Machines"')
        ->and(fn () => $resolver->idFor('Coffee Machines > Nonexistent'))
        ->toThrow(RuntimeException::class, 'Unknown category path');
});
