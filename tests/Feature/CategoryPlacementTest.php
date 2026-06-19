<?php

use App\Enums\CategorySection;
use App\Enums\CategoryStatus;
use App\Models\Category;
use App\Models\CategoryPlacement;
use Database\Seeders\PermissionSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    actingAsAdmin();
});

// ── Index ─────────────────────────────────────────────────────────────────────

it('shows all three sections on the index', function () {
    Livewire::test('pages::admin.placements.index')
        ->assertSee(CategorySection::NAVBAR->label())
        ->assertSee(CategorySection::HOME_PAGE_FEATURED->label())
        ->assertSee(CategorySection::FOOTER->label());
});

it('shows the category count per section on the index', function () {
    $cat = Category::factory()->create();
    CategoryPlacement::create([
        'category_id' => $cat->id,
        'location' => CategorySection::NAVBAR->value,
        'status' => CategoryStatus::ACTIVE->value,
        'sort_order' => 0,
    ]);

    $component = Livewire::test('pages::admin.placements.index');

    $navbar = $component->instance()->sections
        ->first(fn ($s) => $s['section'] === CategorySection::NAVBAR);

    expect($navbar['total'])->toBe(1);
});

// ── Section management (edit) ─────────────────────────────────────────────────

it('shows categories in the correct section', function () {
    $cat = Category::factory()->create(['name' => 'Cold Room']);
    CategoryPlacement::create([
        'category_id' => $cat->id,
        'location' => CategorySection::HOME_PAGE_FEATURED->value,
        'status' => CategoryStatus::ACTIVE->value,
        'sort_order' => 0,
    ]);

    Livewire::test('pages::admin.placements.edit', ['section' => CategorySection::HOME_PAGE_FEATURED])
        ->assertSee('Cold Room');
});

it('adds a category to the section via the modal', function () {
    $cat = Category::factory()->create();

    Livewire::test('pages::admin.placements.edit', ['section' => CategorySection::NAVBAR])
        ->set('addCategoryId', $cat->id)
        ->set('addStatus', 'active')
        ->call('addCategory');

    expect(CategoryPlacement::where('category_id', $cat->id)
        ->where('location', CategorySection::NAVBAR->value)
        ->exists()
    )->toBeTrue();
});

it('assigns the next sort order when adding a category', function () {
    $existing = Category::factory()->create();
    CategoryPlacement::create(['category_id' => $existing->id, 'location' => CategorySection::FOOTER->value, 'status' => CategoryStatus::ACTIVE->value, 'sort_order' => 5]);

    $new = Category::factory()->create();

    Livewire::test('pages::admin.placements.edit', ['section' => CategorySection::FOOTER])
        ->set('addCategoryId', $new->id)
        ->call('addCategory');

    expect(CategoryPlacement::where('category_id', $new->id)->value('sort_order'))->toBe(6);
});

it('excludes already-placed categories from the add modal options', function () {
    $placed = Category::factory()->create(['name' => 'Already In']);
    $available = Category::factory()->create(['name' => 'Available']);

    CategoryPlacement::create(['category_id' => $placed->id, 'location' => CategorySection::NAVBAR->value, 'status' => CategoryStatus::ACTIVE->value, 'sort_order' => 0]);

    $component = Livewire::test('pages::admin.placements.edit', ['section' => CategorySection::NAVBAR]);

    $ids = $component->instance()->availableCategories->pluck('id');

    expect($ids)->toContain($available->id)
        ->not->toContain($placed->id);
});

it('can toggle a placement status', function () {
    $cat = Category::factory()->create();
    $placement = CategoryPlacement::create([
        'category_id' => $cat->id,
        'location' => CategorySection::HOME_PAGE_FEATURED->value,
        'status' => CategoryStatus::ACTIVE->value,
        'sort_order' => 0,
    ]);

    Livewire::test('pages::admin.placements.edit', ['section' => CategorySection::HOME_PAGE_FEATURED])
        ->call('toggleStatus', $placement->id);

    expect($placement->fresh()->status)->toBe(CategoryStatus::INACTIVE);
});

it('can remove a category from the section', function () {
    $cat = Category::factory()->create();
    $placement = CategoryPlacement::create([
        'category_id' => $cat->id,
        'location' => CategorySection::FOOTER->value,
        'status' => CategoryStatus::ACTIVE->value,
        'sort_order' => 0,
    ]);

    Livewire::test('pages::admin.placements.edit', ['section' => CategorySection::FOOTER])
        ->call('remove', $placement->id);

    expect(CategoryPlacement::find($placement->id))->toBeNull();
});

it('reorders placements via the sort handler', function () {
    $catA = Category::factory()->create();
    $catB = Category::factory()->create();
    $catC = Category::factory()->create();

    $pA = CategoryPlacement::create(['category_id' => $catA->id, 'location' => CategorySection::HOME_PAGE_FEATURED->value, 'status' => CategoryStatus::ACTIVE->value, 'sort_order' => 0]);
    $pB = CategoryPlacement::create(['category_id' => $catB->id, 'location' => CategorySection::HOME_PAGE_FEATURED->value, 'status' => CategoryStatus::ACTIVE->value, 'sort_order' => 1]);
    $pC = CategoryPlacement::create(['category_id' => $catC->id, 'location' => CategorySection::HOME_PAGE_FEATURED->value, 'status' => CategoryStatus::ACTIVE->value, 'sort_order' => 2]);

    // Move pA (position 0) to position 2
    Livewire::test('pages::admin.placements.edit', ['section' => CategorySection::HOME_PAGE_FEATURED])
        ->call('handleSort', $pA->id, 2);

    expect($pA->fresh()->sort_order)->toBe(2)
        ->and($pB->fresh()->sort_order)->toBe(0)
        ->and($pC->fresh()->sort_order)->toBe(1);
});
