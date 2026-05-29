<?php

use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

new #[Layout('layouts::app')] #[Title('Permissions — Admin')] class extends Component {
    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $filterGroup = '';

    public bool $showModal = false;
    public string $name = '';

    public function updatedSearch(): void {}

    /** @return \Illuminate\Support\Collection<int, Permission> */
    #[Computed]
    public function permissions(): \Illuminate\Support\Collection
    {
        return Permission::query()
            ->withCount('roles')
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->when($this->filterGroup, fn ($q) => $q->where('name', 'like', $this->filterGroup.'.%'))
            ->orderBy('name')
            ->get();
    }

    /** @return \Illuminate\Support\Collection<int, string> */
    #[Computed]
    public function groups(): \Illuminate\Support\Collection
    {
        return Permission::orderBy('name')->pluck('name')
            ->map(fn ($name) => Str::before($name, '.'))
            ->unique()
            ->values();
    }

    public function openCreate(): void
    {
        $this->reset(['name']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_-]+\.[a-z0-9_-]+$/', 'unique:permissions,name'],
        ], [
            'name.regex' => 'Use the format group.action, e.g. reports.view (lowercase).',
        ]);

        Permission::create(['name' => $this->name, 'guard_name' => 'web']);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->showModal = false;
        unset($this->permissions, $this->groups);
        Flux::toast(heading: 'Permission created', text: $this->name.' has been added.', variant: 'success');
    }

    public function delete(int $id): void
    {
        $permission = Permission::findOrFail($id);
        $name = $permission->name;
        $permission->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        unset($this->permissions, $this->groups);
        Flux::toast(heading: 'Permission deleted', text: $name.' has been removed from all roles.', variant: 'success');
    }
}; ?>

<div>
    <div class="flex items-center justify-between">
        <div>
            @push('breadcrumbs')
<flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')" wire:navigate>Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Permissions</flux:breadcrumbs.item>
            </flux:breadcrumbs>
@endpush
            <flux:heading size="xl">Permissions</flux:heading>
            <flux:subheading>The capabilities you can grant to roles.</flux:subheading>
        </div>
        <flux:button variant="primary" icon="plus" wire:click="openCreate">New permission</flux:button>
    </div>

    <flux:card class="mt-6 p-0 overflow-hidden">
        {{-- Toolbar --}}
        <div class="flex items-center justify-between gap-4 border-b border-zinc-200 px-6 py-3 dark:border-zinc-700">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search permissions…" icon="magnifying-glass"
                clearable class="max-w-xs" />

            <flux:select wire:model.live="filterGroup" class="w-44">
                <flux:select.option value="">All groups</flux:select.option>
                @foreach ($this->groups as $group)
                    <flux:select.option value="{{ $group }}">{{ Str::headline($group) }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <flux:table
            container:class="[&_th:first-child]:pl-6 [&_th:last-child]:pr-6 [&_td:first-child]:pl-6 [&_td:last-child]:pr-6">
            <flux:table.columns class="bg-zinc-50 dark:bg-zinc-800/60">
                <flux:table.column>Permission</flux:table.column>
                <flux:table.column>Group</flux:table.column>
                <flux:table.column align="end">Roles</flux:table.column>
                <flux:table.column align="end">Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->permissions as $permission)
                    <flux:table.row :key="$permission->id">
                        <flux:table.cell variant="strong">
                            {{ Str::headline(Str::after($permission->name, '.')) }}
                            <span class="block font-mono text-xs font-normal text-zinc-400">{{ $permission->name }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" inset="top bottom" color="zinc">{{ Str::headline(Str::before($permission->name, '.')) }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell align="end" class="tabular-nums text-zinc-500">{{ $permission->roles_count }}</flux:table.cell>
                        <flux:table.cell align="end">
                            <flux:button size="xs" variant="ghost" icon="trash"
                                wire:click="delete({{ $permission->id }})"
                                wire:confirm="Delete '{{ $permission->name }}'? It will be removed from all roles."
                                class="text-red-500! hover:text-red-600!" />
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4" class="py-12 text-center text-zinc-400">No permissions found.</flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    {{-- Modal --}}
    <flux:modal wire:model.self="showModal" class="md:w-[440px]" :dismissible="false">
        <flux:heading>New permission</flux:heading>
        <flux:subheading>Define a capability that roles can be granted.</flux:subheading>

        <form wire:submit="save" class="mt-5 space-y-4">
            <flux:input wire:model="name" label="Name" placeholder="e.g. reports.view" required autofocus
                description="Use the format group.action in lowercase." />

            <div class="flex justify-end gap-3 pt-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">Create permission</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
