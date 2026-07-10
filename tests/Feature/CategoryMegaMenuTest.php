<?php

use App\Enums\CategorySection;
use App\Enums\CategoryStatus;
use App\Models\Category;
use App\Models\CategoryPlacement;

function placeInNavbar(Category $category, int $sort = 0): void
{
    CategoryPlacement::create([
        'category_id' => $category->id,
        'location' => CategorySection::NAVBAR->value,
        'status' => CategoryStatus::ACTIVE->value,
        'sort_order' => $sort,
    ]);
}

it('makes a navbar category with children a mega-menu trigger', function () {
    $parent = Category::factory()->create(['name' => 'Refrigeration']);
    Category::factory()->create(['name' => 'Chest Freezers', 'parent_id' => $parent->id]);
    placeInNavbar($parent);

    $this->get('/')
        ->assertOk()
        ->assertSee('x-data="megaMenu"', false)
        ->assertSee('Refrigeration')
        // Has children, so it fetches a flyout on hover.
        ->assertSee('/menu/'.$parent->slug.'/flyout', false)
        ->assertSee('aria-haspopup', false);
});

it('leaves a childless navbar category as a plain link that dismisses an open panel', function () {
    $category = Category::factory()->create(['name' => 'Fryers']);
    placeInNavbar($category);

    $this->get('/')
        ->assertOk()
        ->assertSee('Fryers')
        // No children → no flyout, no dropdown affordance.
        ->assertDontSee('/menu/'.$category->slug.'/flyout', false)
        ->assertDontSee('aria-haspopup', false)
        // Settling on it closes whatever panel is open — the pointer never leaves the
        // nav, so the nav-level mouseleave can't do it. The close waits for the
        // pointer to settle, so sweeping through on the way down to the panel is safe.
        ->assertSee('@mouseenter="closeIntent($event)"', false)
        ->assertSee('@mouseleave="cancelClose()"', false)
        ->assertSee('@focus="close()"', false);
});

it('treats a category whose children are all inactive as a plain link', function () {
    $parent = Category::factory()->create(['name' => 'Burners']);
    Category::factory()->create([
        'name' => 'Wok Burners',
        'parent_id' => $parent->id,
        'status' => CategoryStatus::INACTIVE,
    ]);
    placeInNavbar($parent);

    $this->get('/')
        ->assertOk()
        ->assertSee('Burners')
        // Nothing shoppable behind it, so it must not become a dropdown trigger.
        ->assertDontSee('/menu/'.$parent->slug.'/flyout', false)
        ->assertDontSee('aria-haspopup', false);
});

it('omits inactive children from a category flyout', function () {
    $parent = Category::factory()->create(['name' => 'Refrigeration']);
    $active = Category::factory()->create(['name' => 'Chest Freezers', 'parent_id' => $parent->id]);
    $hidden = Category::factory()->create([
        'name' => 'Discontinued Chillers',
        'parent_id' => $parent->id,
        'status' => CategoryStatus::INACTIVE,
    ]);

    $this->get(route('menu.flyout', $parent))
        ->assertOk()
        ->assertSee($active->name)
        ->assertDontSee($hidden->name);
});

it('serves a category flyout with its real children as image cards', function () {
    $parent = Category::factory()->create(['name' => 'Refrigeration']);
    $child = Category::factory()->create(['name' => 'Chest Freezers', 'parent_id' => $parent->id]);

    $this->get(route('menu.flyout', $parent))
        ->assertOk()
        ->assertSee($parent->name)
        ->assertSee($child->name);
});
