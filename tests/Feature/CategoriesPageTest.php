<?php

use App\Models\Category;
use Livewire\Livewire;

it('renders the categories page', function () {
    Category::factory()->count(3)->create();

    $response = $this->get(route('categories.index'));

    $response->assertOk();
    $response->assertSee('All Categories');
});

it('shows no Load more button when every category fits on the first page', function () {
    Category::factory()->count(5)->create();

    Livewire::test('pages::storefront.categories')
        ->assertSee('All Categories')
        ->assertDontSee('Load more');
});

it('shows a Load more button once there are more categories than the page size', function () {
    Category::factory()->count(30)->create();

    $component = Livewire::test('pages::storefront.categories')->assertSee('Load more');

    expect($component->instance()->categories)->toHaveCount(24);
});

it('reveals more categories each time Load more is clicked', function () {
    Category::factory()->count(30)->create();

    $component = Livewire::test('pages::storefront.categories');

    expect($component->instance()->categories)->toHaveCount(24);

    $component->call('loadMore')->assertDontSee('Load more');

    expect($component->instance()->categories)->toHaveCount(30);
});
