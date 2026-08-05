<?php

use App\Models\Product;
use App\Models\TagProduct;
use Flux\Flux;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Tags\Tag;

new #[Layout('layouts::app')] #[Title('Tag Products | Admin')] class extends Component
{
    #[Locked]
    public Tag $tag;

    public string $addSearch = '';

    public function mount(Tag $tag): void
    {
        $this->tag = $tag;
    }

    /** Rows for this tag, ordered - each row's product carries its own thumbnail. */
    #[Computed]
    public function items(): Collection
    {
        return TagProduct::where('tag_id', $this->tag->id)
            ->with('product.media')
            ->orderBy('sort_order')
            ->get()
            ->filter(fn (TagProduct $item) => $item->product !== null)
            ->values();
    }

    /** Products not yet on this tag, for the add search. */
    #[Computed]
    public function searchResults(): Collection
    {
        if ($this->addSearch === '') {
            return collect();
        }

        $existing = $this->items->pluck('taggable_id');

        return Product::query()
            ->where(fn ($q) => $q->where('name', 'like', '%'.$this->addSearch.'%')
                ->orWhere('sku', 'like', '%'.$this->addSearch.'%'))
            ->whereNotIn('id', $existing)
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'sku']);
    }

    public function handleSort(int $productId, int $position): void
    {
        $items = TagProduct::where('tag_id', $this->tag->id)->orderBy('sort_order')->get();

        $moving = $items->firstWhere('taggable_id', $productId);

        if (! $moving) {
            return;
        }

        $reordered = $items->reject(fn (TagProduct $item) => $item->taggable_id === $productId)->values();
        $reordered->splice($position, 0, [$moving]);

        foreach ($reordered as $index => $item) {
            $item->update(['sort_order' => $index]);
        }

        unset($this->items);
    }

    public function addProduct(int $productId): void
    {
        $product = Product::findOrFail($productId);

        $nextOrder = (TagProduct::where('tag_id', $this->tag->id)->max('sort_order') ?? -1) + 1;

        TagProduct::updateOrCreate(
            ['tag_id' => $this->tag->id, 'taggable_id' => $productId],
            ['sort_order' => $nextOrder],
        );

        $this->addSearch = '';
        unset($this->items, $this->searchResults);

        Flux::modal('add-product')->close();
        Flux::toast(heading: 'Product added', text: $product->name.' has been added to '.$this->tag->name.'.', variant: 'success');
    }

    public function remove(int $productId): void
    {
        $name = Product::find($productId)?->name ?? 'Product';

        TagProduct::where('tag_id', $this->tag->id)->where('taggable_id', $productId)->delete();

        unset($this->items, $this->searchResults);
        Flux::toast(heading: 'Removed', text: $name.' removed from '.$this->tag->name.'.', variant: 'success');
    }
}; ?>

<div>
    @push('breadcrumbs')
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')" wire:navigate>Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('admin.tags.index')" wire:navigate>Tags</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $tag->name }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    @endpush

    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <flux:heading size="xl">{{ $tag->name }}</flux:heading>
            <flux:subheading>Order the products tagged "{{ $tag->name }}" - this is the order they render in wherever the tag drives a storefront list.</flux:subheading>
        </div>
        <flux:modal.trigger name="add-product">
            <flux:button variant="primary" icon="plus">Add product</flux:button>
        </flux:modal.trigger>
    </div>

    {{-- Sortable product list --}}
    <flux:card class="mt-6 overflow-hidden p-0">

        @if ($this->items->isEmpty())
            <div class="flex flex-col items-center gap-3 py-16 text-center">
                <flux:icon.squares-plus variant="outline" class="size-10 text-zinc-300" />
                <div class="text-sm text-zinc-400">No products tagged "{{ $tag->name }}" yet.</div>
                <flux:modal.trigger name="add-product">
                    <flux:button size="sm" variant="ghost" icon="plus">Add the first one</flux:button>
                </flux:modal.trigger>
            </div>
        @else
            {{-- Table header --}}
            <div class="grid grid-cols-[auto_1fr_auto_auto] items-center gap-4 border-b border-zinc-200 bg-zinc-50 px-6 py-2.5 text-xs font-medium tracking-wider text-zinc-500 uppercase dark:border-zinc-700 dark:bg-zinc-800/60">
                <div class="w-4"></div>
                <div>Product</div>
                <div class="w-20 text-center">Order</div>
                <div class="w-16"></div>
            </div>

            <div wire:sort="handleSort">
                @foreach ($this->items as $item)
                    <div wire:key="{{ $item->taggable_id }}"
                        wire:sort:item="{{ $item->taggable_id }}"
                        class="grid grid-cols-[auto_1fr_auto_auto] items-center gap-4 border-b border-zinc-100 px-6 py-3 last:border-b-0 hover:bg-zinc-50 dark:border-zinc-800 dark:hover:bg-zinc-800/40">

                        {{-- Drag handle --}}
                        <div wire:sort:handle
                            class="w-4 cursor-grab text-zinc-300 active:cursor-grabbing dark:text-zinc-600">
                            <flux:icon.bars-2 variant="micro" class="size-4" />
                        </div>

                        {{-- Product --}}
                        <div class="flex min-w-0 items-center gap-3">
                            @if ($item->product->thumb_url)
                                <img src="{{ $item->product->thumb_url }}" alt=""
                                    class="size-9 shrink-0 rounded object-cover" />
                            @else
                                <div class="flex size-9 shrink-0 items-center justify-center rounded bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon.photo variant="micro" class="size-4 text-zinc-400" />
                                </div>
                            @endif
                            <div class="min-w-0">
                                <div class="truncate text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ $item->product->name }}
                                </div>
                                <div class="truncate font-mono text-xs text-zinc-400">{{ $item->product->sku }}</div>
                            </div>
                        </div>

                        {{-- Sort order --}}
                        <div class="w-20 text-center text-sm tabular-nums text-zinc-400">
                            {{ $item->sort_order }}
                        </div>

                        {{-- Remove --}}
                        <div class="w-16 text-right" wire:sort:ignore>
                            <flux:button size="xs" variant="ghost" icon="trash-2" inset="right"
                                wire:click="remove({{ $item->taggable_id }})"
                                wire:confirm="Remove {{ $item->product->name }} from {{ addslashes($tag->name) }}?"
                                class="text-red-400 hover:text-red-600" />
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="border-t border-zinc-100 px-6 py-3 dark:border-zinc-800">
                <flux:text size="sm" class="text-zinc-400">
                    {{ $this->items->count() }} {{ str('product')->plural($this->items->count()) }} · Drag rows to reorder
                </flux:text>
            </div>
        @endif

    </flux:card>

    {{-- Add product modal --}}
    <flux:modal name="add-product" class="w-full max-w-md" @close="$set('addSearch', '')">
        <flux:heading class="uppercase tracking-wide">Add product</flux:heading>
        <flux:subheading class="mt-1">Add a product to "{{ $tag->name }}".</flux:subheading>

        <div class="mt-5 space-y-3">
            <flux:input wire:model.live.debounce.300ms="addSearch" placeholder="Search by name or SKU…"
                icon="magnifying-glass" clearable autofocus />

            @if ($addSearch !== '')
                <div class="scrollbar-thin max-h-72 divide-y divide-zinc-100 overflow-y-auto rounded-md border border-zinc-200 dark:divide-zinc-800 dark:border-zinc-700">
                    @forelse ($this->searchResults as $product)
                        <button type="button" wire:click="addProduct({{ $product->id }})"
                            class="flex w-full items-center justify-between gap-3 px-4 py-2.5 text-left text-sm hover:bg-zinc-50 dark:hover:bg-zinc-800/60">
                            <span class="truncate font-medium text-zinc-800 dark:text-zinc-200">{{ $product->name }}</span>
                            <span class="shrink-0 font-mono text-xs text-zinc-400">{{ $product->sku }}</span>
                        </button>
                    @empty
                        <div class="px-4 py-6 text-center text-sm text-zinc-400">No matching products.</div>
                    @endforelse
                </div>
            @endif
        </div>

        <div class="mt-6 flex justify-end">
            <flux:modal.close>
                <flux:button variant="ghost">Close</flux:button>
            </flux:modal.close>
        </div>
    </flux:modal>

</div>
