<?php

use App\Enums\AttributeType;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Flux\Flux;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts::app')] #[Title('Attributes — Admin')] class extends Component {
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public int $perPage = 10;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    // ─── Attribute modal ───────────────────────────────────────────────────────
    public bool $showModal = false;

    public ?int $editingId = null;

    public string $name = '';
    public string $slug = '';
    public string $type = 'select';
    public bool $is_active = true;
    public int $sort_order = 0;

    private bool $slugManuallyEdited = false;

    // ─── Values panel ──────────────────────────────────────────────────────────
    public ?int $managingValuesForId = null;

    public string $valueLabel = '';
    public string $valueValue = '';
    public string $valueColorCode = '';
    public int $valueSortOrder = 0;

    #[Computed]
    public function attributeList()
    {
        return Attribute::withCount('values')->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))->orderBy('sort_order')->orderBy('name')->paginate($this->perPage);
    }

    #[Computed]
    public function managingAttribute(): ?Attribute
    {
        return $this->managingValuesForId ? Attribute::with(['values' => fn($q) => $q->orderBy('sort_order')->orderBy('label')])->find($this->managingValuesForId) : null;
    }

    // ─── Attribute CRUD ────────────────────────────────────────────────────────

    public function updatedName(): void
    {
        if (!$this->slugManuallyEdited) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function updatedSlug(): void
    {
        $this->slugManuallyEdited = true;
        $this->slug = Str::slug($this->slug);
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'slug']);
        $this->type = 'select';
        $this->is_active = true;
        $this->sort_order = 0;
        $this->slugManuallyEdited = false;
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $attr = Attribute::findOrFail($id);
        $this->editingId = $id;
        $this->name = $attr->name;
        $this->slug = $attr->slug;
        $this->type = $attr->type->value;
        $this->is_active = (bool) $attr->is_active;
        $this->sort_order = (int) $attr->sort_order;
        $this->slugManuallyEdited = true;
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('attributes', 'slug')->ignore($this->editingId)],
            'type' => ['required', Rule::in(array_column(AttributeType::cases(), 'value'))],
            'sort_order' => ['integer', 'min:0'],
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'type' => $this->type,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->editingId) {
            Attribute::findOrFail($this->editingId)->update($data);
            Flux::toast(heading: 'Attribute updated', text: $this->name . ' has been saved.', variant: 'success');
        } else {
            $attr = Attribute::create($data);
            $this->managingValuesForId = $attr->id;
        }

        $this->showModal = false;
        unset($this->attributeList);
    }

    public function deleteAttribute(int $id): void
    {
        Attribute::findOrFail($id)->delete();

        if ($this->managingValuesForId === $id) {
            $this->managingValuesForId = null;
        }

        unset($this->attributeList);
        Flux::toast(heading: 'Attribute deleted', variant: 'success');
    }

    // ─── Value management ──────────────────────────────────────────────────────

    public function openValues(int $id): void
    {
        $this->managingValuesForId = $this->managingValuesForId === $id ? null : $id;
        $this->resetValueForm();
        unset($this->managingAttribute);
    }

    private function resetValueForm(): void
    {
        $this->reset(['valueLabel', 'valueValue', 'valueColorCode']);
        $this->valueSortOrder = 0;
        $this->resetValidation(['valueLabel', 'valueValue', 'valueColorCode']);
    }

    public function addValue(): void
    {
        $this->validate([
            'valueLabel' => ['required', 'string', 'max:100'],
            'valueValue' => ['required', 'string', 'max:100'],
            'valueColorCode' => ['nullable', 'regex:/^#[0-9A-Fa-f]{3,6}$/'],
        ]);

        AttributeValue::create([
            'attribute_id' => $this->managingValuesForId,
            'label' => $this->valueLabel,
            'value' => $this->valueValue,
            'slug' => Str::slug($this->valueValue),
            'color_code' => $this->valueColorCode ?: null,
            'sort_order' => $this->valueSortOrder,
            'is_active' => true,
        ]);

        $this->resetValueForm();
        unset($this->managingAttribute, $this->attributeList);
    }

    public function deleteValue(int $valueId): void
    {
        AttributeValue::findOrFail($valueId)->delete();
        unset($this->managingAttribute, $this->attributeList);
    }
}; ?>

<div>
    <div class="flex items-center justify-between">
        <div>
            @push('breadcrumbs')
<flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')" wire:navigate>Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Attributes</flux:breadcrumbs.item>
            </flux:breadcrumbs>
@endpush
            <flux:heading size="xl">Attributes</flux:heading>
            <flux:subheading>Product variation attributes such as colour, material or size.</flux:subheading>
        </div>
        <flux:button variant="primary" icon="plus" wire:click="openCreate">Add attribute</flux:button>
    </div>

    <flux:card class="mt-6 p-0 overflow-hidden">

        {{-- Toolbar --}}
        <div class="flex items-center justify-between gap-4 border-b border-zinc-200 px-6 py-3 dark:border-zinc-700">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search attributes…" icon="magnifying-glass"
                clearable class="max-w-xs" />

            <flux:select wire:model.live="perPage" class="w-28">
                    <flux:select.option value="10">10 / page</flux:select.option>
                    <flux:select.option value="25">25 / page</flux:select.option>
                    <flux:select.option value="50">50 / page</flux:select.option>
                    <flux:select.option value="100">100 / page</flux:select.option>
                    <flux:select.option value="250">250 / page</flux:select.option>
                </flux:select>
        </div>

        <flux:table
            container:class="[&_th:first-child]:pl-6 [&_th:last-child]:pr-6 [&_td:first-child]:pl-6 [&_td:last-child]:pr-6">
            <flux:table.columns class="bg-zinc-50 dark:bg-zinc-800/60">
                <flux:table.column>Attribute</flux:table.column>
                <flux:table.column>Type</flux:table.column>
                <flux:table.column>Values</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column align="end">Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->attributeList as $attribute)
                    <flux:table.row :key="$attribute->id">
                        <flux:table.cell variant="strong">
                            {{ $attribute->name }}
                            <span
                                class="block font-mono text-xs font-normal text-zinc-400">{{ $attribute->slug }}</span>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" color="zinc" inset="top bottom" class="capitalize">
                                {{ $attribute->type->value }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell class="tabular-nums">
                            {{ $attribute->values_count }}
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" inset="top bottom"
                                :color="$attribute->is_active ? 'green' : 'zinc'">
                                {{ $attribute->is_active ? 'Active' : 'Inactive' }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell align="end">
                            <div class="flex items-center justify-end gap-1">
                                <flux:button size="xs" variant="ghost" icon="list-bullet"
                                    wire:click="openValues({{ $attribute->id }})"
                                    :class="$managingValuesForId === $attribute->id ? 'text-brand-500!' : ''" />
                                <flux:button size="xs" variant="ghost" icon="pencil-square"
                                    wire:click="openEdit({{ $attribute->id }})" />
                                <flux:button size="xs" variant="ghost" icon="trash"
                                    wire:click="deleteAttribute({{ $attribute->id }})"
                                    wire:confirm="Delete '{{ addslashes($attribute->name) }}' and all its values?"
                                    class="text-red-500! hover:text-red-600!" />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>

                    {{-- Inline values panel --}}
                    @if ($managingValuesForId === $attribute->id && $this->managingAttribute)
                        <flux:table.row :key="'values-'.$attribute->id">
                            <flux:table.cell colspan="6" class="bg-zinc-50 p-0 dark:bg-zinc-900">
                                <div class="px-6 py-5">
                                    <flux:heading size="sm" class="mb-3">
                                        Values for "{{ $this->managingAttribute->name }}"
                                    </flux:heading>

                                    {{-- Existing values --}}
                                    @if ($this->managingAttribute->values->isNotEmpty())
                                        <div
                                            class="mb-4 overflow-hidden rounded-md border border-zinc-200 dark:border-zinc-700">
                                            <table class="w-full text-sm">
                                                <thead
                                                    class="bg-white text-left text-[11px] font-bold uppercase tracking-wide text-zinc-500 dark:bg-zinc-800">
                                                    <tr>
                                                        <th class="px-3 py-2">Label</th>
                                                        <th class="px-3 py-2">Value</th>
                                                        @if ($attribute->type->value === 'color')
                                                            <th class="px-3 py-2">Colour</th>
                                                        @endif
                                                        <th class="px-3 py-2">Sort</th>
                                                        <th class="px-3 py-2"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                                    @foreach ($this->managingAttribute->values as $value)
                                                        <tr wire:key="val-{{ $value->id }}">
                                                            <td class="px-3 py-2 font-medium">{{ $value->label }}</td>
                                                            <td class="px-3 py-2 font-mono text-xs text-zinc-500">
                                                                {{ $value->value }}</td>
                                                            @if ($attribute->type->value === 'color')
                                                                <td class="px-3 py-2">
                                                                    @if ($value->color_code)
                                                                        <span class="inline-flex items-center gap-1.5">
                                                                            <span
                                                                                class="inline-block size-4 rounded-full border border-zinc-200"
                                                                                style="background:{{ $value->color_code }}"></span>
                                                                            <span
                                                                                class="font-mono text-xs text-zinc-400">{{ $value->color_code }}</span>
                                                                        </span>
                                                                    @else
                                                                        —
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            <td class="px-3 py-2 tabular-nums text-zinc-500">
                                                                {{ $value->sort_order }}</td>
                                                            <td class="px-3 py-2 text-right">
                                                                <flux:button size="xs" variant="ghost"
                                                                    icon="trash"
                                                                    wire:click="deleteValue({{ $value->id }})"
                                                                    wire:confirm="Delete '{{ addslashes($value->label) }}'?"
                                                                    class="text-red-500! hover:text-red-600!" />
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    {{-- Add new value --}}
                                    <form wire:submit="addValue" class="flex flex-wrap items-end gap-3">
                                        <flux:input wire:model="valueLabel" label="Label"
                                            placeholder="e.g. Stainless Steel" class="w-40" />
                                        <flux:input wire:model="valueValue" label="Value"
                                            placeholder="e.g. stainless-steel" class="w-40" />
                                        @if ($attribute->type->value === 'color')
                                            <flux:field>
                                                <flux:label>Hex colour</flux:label>
                                                <div class="flex items-center gap-2">
                                                    <input type="color" wire:model="valueColorCode"
                                                        class="h-9 w-10 cursor-pointer rounded border border-zinc-200 p-0.5" />
                                                    <flux:input wire:model="valueColorCode" placeholder="#000000"
                                                        class="w-28" />
                                                </div>
                                                <flux:error name="valueColorCode" />
                                            </flux:field>
                                        @endif
                                        <flux:input wire:model="valueSortOrder" label="Sort" type="number"
                                            min="0" class="w-20" />
                                        <flux:button type="submit" variant="primary" size="sm" icon="plus">
                                            Add</flux:button>
                                    </form>
                                    @error('valueLabel')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                    @error('valueValue')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endif
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="py-12 text-center text-zinc-400">
                            No attributes yet.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if ($this->attributeList->hasPages())
            <div class="border-t border-zinc-200 px-6 pb-3 dark:border-zinc-700">
                <flux:pagination :paginator="$this->attributeList" />
            </div>
        @endif
    </flux:card>

    {{-- Create / Edit attribute modal --}}
    <flux:modal wire:model.self="showModal" class="md:w-[480px]" :dismissible="false">
        <flux:heading>{{ $editingId ? 'Edit attribute' : 'New attribute' }}</flux:heading>

        <form wire:submit="save" class="mt-5 space-y-4">
            <flux:input wire:model.live.debounce.400ms="name" label="Name" placeholder="e.g. Material" required />
            <flux:input wire:model.blur="slug" label="Slug" description="Auto-generated from name."
                placeholder="material" />

            <div class="grid grid-cols-2 gap-4">
                <flux:select wire:model="type" label="Type">
                    @foreach (AttributeType::cases() as $t)
                        <flux:select.option :value="$t->value" class="capitalize">{{ ucfirst($t->value) }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input wire:model="sort_order" label="Sort order" type="number" min="0" />
            </div>

            <div class="flex items-center justify-between rounded-md bg-zinc-50 px-3 py-2.5 dark:bg-zinc-800">
                <flux:label>Active</flux:label>
                <flux:switch wire:model="is_active" />
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">
                    {{ $editingId ? 'Save changes' : 'Create & add values' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
