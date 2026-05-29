<?php

use Flux\Flux;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

new #[Layout('layouts::app')] #[Title('Role — Admin')] class extends Component {
    /** Roles that cannot be renamed/deleted to avoid locking admins out. */
    private const PROTECTED_ROLES = ['admin', 'super-admin'];

    public ?int $roleId = null;
    public string $name = '';

    /** @var array<int, string> */
    public array $selectedPermissions = [];

    public function mount(?Role $role = null): void
    {
        if ($role?->exists) {
            $this->roleId = $role->id;
            $this->name = $role->name;
            $this->selectedPermissions = $role->permissions->pluck('name')->all();
        }
    }

    /** @return Collection<string, \Illuminate\Support\Collection<int, Permission>> */
    #[Computed]
    public function groupedPermissions(): Collection
    {
        return Permission::orderBy('name')->get()->groupBy(fn (Permission $p) => Str::before($p->name, '.'));
    }

    public function isProtected(): bool
    {
        return $this->roleId !== null && in_array($this->name, self::PROTECTED_ROLES, true);
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9 _-]+$/i', Rule::unique('roles', 'name')->ignore($this->roleId)],
            'selectedPermissions' => ['array'],
            'selectedPermissions.*' => [Rule::exists('permissions', 'name')],
        ], [
            'name.regex' => 'The role name may only contain letters, numbers, spaces, dashes and underscores.',
        ]);

        if ($this->roleId) {
            $role = Role::findOrFail($this->roleId);
            if (! $this->isProtected()) {
                $role->name = $this->name;
                $role->save();
            }
            $role->syncPermissions($this->selectedPermissions);
            Flux::toast(heading: 'Role updated', text: $role->name.' has been saved.', variant: 'success');
        } else {
            $role = Role::create(['name' => $this->name, 'guard_name' => 'web']);
            $role->syncPermissions($this->selectedPermissions);
            Flux::toast(heading: 'Role created', text: $this->name.' has been added.', variant: 'success');
        }

        $this->redirectRoute('admin.roles.index', navigate: true);
    }

    public function selectGroup(string $group, bool $checked): void
    {
        $names = $this->groupedPermissions->get($group)?->pluck('name')->all() ?? [];

        $this->selectedPermissions = $checked
            ? array_values(array_unique([...$this->selectedPermissions, ...$names]))
            : array_values(array_diff($this->selectedPermissions, $names));
    }
}; ?>

<div>
    @push('breadcrumbs')
<flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('dashboard')" wire:navigate>Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.roles.index')" wire:navigate>Roles</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $roleId ? 'Edit' : 'New' }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
@endpush

    <form wire:submit="save">
        <div class="mt-2 flex flex-wrap items-center justify-between gap-4">
            <div>
                <flux:heading size="xl">{{ $roleId ? 'Edit role' : 'New role' }}</flux:heading>
                <flux:subheading>Choose what this role can access in the admin panel.</flux:subheading>
            </div>
            <div class="flex items-center gap-3">
                <flux:button variant="ghost" :href="route('admin.roles.index')" wire:navigate>Cancel</flux:button>
                <flux:button type="submit" variant="primary" icon="check">{{ $roleId ? 'Save changes' : 'Create role' }}</flux:button>
            </div>
        </div>

        <div class="mt-6 max-w-2xl space-y-6">
            <flux:card>
                <flux:input
                    wire:model="name"
                    label="Role name"
                    placeholder="e.g. fulfilment"
                    :disabled="$this->isProtected()"
                    required
                    autofocus />
                @if ($this->isProtected())
                    <flux:text size="sm" class="mt-2 text-zinc-500">This is a protected role — its name can't be changed.</flux:text>
                @endif
            </flux:card>

            <flux:card class="space-y-4">
                <flux:heading size="lg">Permissions</flux:heading>
                @foreach ($this->groupedPermissions as $group => $permissions)
                    @php $groupNames = $permissions->pluck('name')->all(); @endphp
                    <div class="rounded-md border border-zinc-200 p-4 dark:border-zinc-700">
                        <label class="flex items-center justify-between">
                            <span class="text-sm font-semibold uppercase tracking-wide text-zinc-500">{{ Str::headline($group) }}</span>
                            <flux:checkbox
                                :checked="count(array_intersect($groupNames, $selectedPermissions)) === count($groupNames)"
                                wire:click="selectGroup('{{ $group }}', $event.target.checked)" />
                        </label>
                        <flux:separator class="my-3" />
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                            @foreach ($permissions as $permission)
                                <flux:checkbox
                                    wire:model="selectedPermissions"
                                    value="{{ $permission->name }}"
                                    label="{{ Str::headline(Str::after($permission->name, '.')) }}" />
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </flux:card>
        </div>
    </form>
</div>
