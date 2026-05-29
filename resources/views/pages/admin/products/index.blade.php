<?php

use App\Enums\ProductVisibility;
use App\Enums\StockStatus;
use App\Models\Product;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts::app')] #[Title('Products — Admin')] class extends Component {
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $filterVisibility = '';

    #[Url]
    public string $filterStock = '';

    #[Url]
    public string $sortBy = 'updated_at';

    #[Url]
    public string $sortDirection = 'desc';

    #[Url]
    public int $perPage = 15;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    public function updatedFilterVisibility(): void
    {
        $this->resetPage();
    }
    public function updatedFilterStock(): void
    {
        $this->resetPage();
    }
    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    #[Computed]
    public function products()
    {
        return Product::query()
            ->with(['brand', 'primaryCategory', 'images' => fn($q) => $q->where('is_cover', true)->limit(1)])
            ->when(
                $this->search,
                fn($q) => $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')->orWhere('sku', 'like', '%' . $this->search . '%');
                }),
            )
            ->when($this->filterVisibility, fn($q) => $q->where('visibility', $this->filterVisibility))
            ->when($this->filterStock, fn($q) => $q->where('stock_status', $this->filterStock))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function deleteProduct(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->delete();
        unset($this->products);

        Flux::toast(heading: 'Product deleted', text: $product->name . ' has been removed.', variant: 'success');
    }
}; ?>

<div>
    <div class="flex items-center justify-between">
        <div>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')" wire:navigate>Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Products</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <flux:heading size="xl" class="mt-2">Products</flux:heading>
        </div>
        <flux:button variant="primary" icon="plus" :href="route('admin.products.create')" wire:navigate>
            Add product
        </flux:button>
    </div>

    {{-- Card: toolbar + table --}}
    <flux:card class="mt-6 p-0 overflow-hidden">

        {{-- Toolbar --}}
        <div class="flex items-center justify-between gap-4 border-b border-zinc-200 px-6 py-3 dark:border-zinc-700">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search name or SKU…" icon="magnifying-glass"
                clearable class="max-w-xs" />

            <div class="flex items-center gap-2">
                <flux:select wire:model.live="filterVisibility" class="w-40">
                    <flux:select.option value="">All visibility</flux:select.option>
                    @foreach (ProductVisibility::cases() as $v)
                        <flux:select.option :value="$v->value">{{ $v->label() }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.live="filterStock" class="w-36">
                    <flux:select.option value="">All stock</flux:select.option>
                    @foreach (StockStatus::cases() as $s)
                        <flux:select.option :value="$s->value">{{ $s->label() }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.live="perPage" class="w-28">
                    <flux:select.option value="15">15 / page</flux:select.option>
                    <flux:select.option value="25">25 / page</flux:select.option>
                    <flux:select.option value="50">50 / page</flux:select.option>
                    <flux:select.option value="100">100 / page</flux:select.option>
                </flux:select>
            </div>
        </div>

        <flux:table
            container:class="[&_th:first-child]:pl-6 [&_th:last-child]:pr-6 [&_td:first-child]:pl-6 [&_td:last-child]:pr-6">
            <flux:table.columns class="bg-zinc-50 dark:bg-zinc-800/60">
                <flux:table.column class="w-14"></flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                    wire:click="sort('name')">Product</flux:table.column>
                <flux:table.column>Brand / Category</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'price'" :direction="$sortDirection"
                    wire:click="sort('price')">Price</flux:table.column>
                <flux:table.column>Stock</flux:table.column>
                <flux:table.column>Visibility</flux:table.column>
                <flux:table.column align="end">Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->products as $product)
                    <flux:table.row :key="$product->id">
                        <flux:table.cell>
                            <div
                                class="size-10 overflow-hidden rounded border border-zinc-200 bg-zinc-50 p-0.5 dark:border-zinc-700 dark:bg-zinc-800">
                                @if ($product->cover_url)
                                    <img src="{{ $product->cover_url }}" alt=""
                                        class="size-full object-contain" />
                                @else
                                    <flux:icon.photo variant="micro" class="m-auto mt-2 size-5 text-zinc-300" />
                                @endif
                            </div>
                        </flux:table.cell>

                        <flux:table.cell variant="strong">
                            <a href="{{ route('admin.products.edit', $product) }}" wire:navigate
                                class="hover:text-brand-500">{{ $product->name }}</a>
                            <span
                                class="block font-mono text-xs font-normal text-zinc-400">{{ $product->sku ?: '—' }}</span>
                        </flux:table.cell>

                        <flux:table.cell>
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $product->brand?->name ?? '—' }}</span>
                            @if ($product->primaryCategory)
                                <span class="block text-xs text-zinc-400">{{ $product->primaryCategory->name }}</span>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell variant="strong" class="tabular-nums">
                            @if ($product->price)
                                KES {{ number_format(intdiv($product->price, 100), 0, '.', ',') }}
                                @if ($product->sale_price)
                                    <span class="block text-xs font-normal text-emerald-600">
                                        Sale KES {{ number_format(intdiv($product->sale_price, 100), 0, '.', ',') }}
                                    </span>
                                @endif
                            @else
                                <span class="font-normal text-zinc-400">—</span>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            @php
                                $stockColor = match ($product->stock_status) {
                                    StockStatus::IN_STOCK => 'green',
                                    StockStatus::OUT_OF_STOCK => 'red',
                                    StockStatus::BACKORDER => 'yellow',
                                };
                            @endphp
                            <flux:badge size="sm" :color="$stockColor" inset="top bottom">
                                {{ $product->stock_status->label() }}
                            </flux:badge>
                            @if ($product->stock_quantity !== null)
                                <span class="ml-1 text-xs text-zinc-400">{{ $product->stock_quantity }}</span>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            @php
                                $visColor = match ($product->visibility) {
                                    ProductVisibility::VISIBLE => 'green',
                                    ProductVisibility::HIDDEN => 'zinc',
                                    default => 'yellow',
                                };
                            @endphp
                            <flux:badge size="sm" :color="$visColor" inset="top bottom">
                                {{ $product->visibility->label() }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell align="end">
                            <div class="flex items-center justify-end gap-1">
                                <flux:button size="xs" variant="ghost" icon="pencil-square"
                                    :href="route('admin.products.edit', $product)" wire:navigate />
                                <flux:button size="xs" variant="ghost" icon="trash"
                                    wire:click="deleteProduct({{ $product->id }})"
                                    wire:confirm="Delete '{{ addslashes($product->name) }}'? This cannot be undone."
                                    class="text-red-500! hover:text-red-600!" />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="7" class="py-16 text-center text-zinc-400">
                            @if ($search || $filterVisibility || $filterStock)
                                No products match your filters.
                            @else
                                No products yet.
                                <a href="{{ route('admin.products.create') }}" wire:navigate
                                    class="ml-1 text-brand-500 hover:underline">Add your first product</a>.
                            @endif
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if ($this->products->hasPages())
            <div class="border-t border-zinc-200 px-6 pb-3 dark:border-zinc-700">
                <flux:pagination :paginator="$this->products" />
            </div>
        @endif
    </flux:card>
</div>
