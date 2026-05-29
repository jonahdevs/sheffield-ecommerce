<?php

use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    $this->actingAs(User::factory()->create());
});

it('loads the permissions admin index', function () {
    $this->get(route('admin.permissions.index'))->assertOk();
});

it('creates a new permission', function () {
    Livewire::test('pages::admin.permissions.index')
        ->call('openCreate')
        ->set('name', 'reports.view')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSet('showModal', false);

    expect(Permission::where('name', 'reports.view')->exists())->toBeTrue();
});

it('rejects a permission name without the group.action format', function () {
    Livewire::test('pages::admin.permissions.index')
        ->call('openCreate')
        ->set('name', 'Reports View')
        ->call('save')
        ->assertHasErrors('name');
});

it('rejects a duplicate permission', function () {
    Livewire::test('pages::admin.permissions.index')
        ->call('openCreate')
        ->set('name', 'orders.view')
        ->call('save')
        ->assertHasErrors('name');
});

it('filters permissions by group', function () {
    Livewire::test('pages::admin.permissions.index')
        ->set('filterGroup', 'orders')
        ->assertSee('orders.view')
        ->assertDontSee('roles.manage');
});

it('deletes a permission and detaches it from roles', function () {
    $permission = Permission::firstWhere('name', 'orders.view');

    Livewire::test('pages::admin.permissions.index')
        ->call('delete', $permission->id);

    expect(Permission::find($permission->id))->toBeNull();
});
