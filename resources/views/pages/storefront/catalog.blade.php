<?php

use App\Enums\CategoryStatus;
use App\Enums\StockStatus;
use App\Livewire\Concerns\HasProductFilters;
use App\Livewire\Concerns\InteractsWithStorefront;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

new #[Layout('layouts::storefront')] #[Title('Shop')] class extends Component
{
    use HasProductFilters, InteractsWithStorefront;

    public function mount(): void
    {
        $description = 'Browse Sheffield\'s full commercial kitchen catalog — ovens, refrigeration, preparation, warewashing, beverage and more. Filter by brand, price, stock and category.';

        SEOMeta::setDescription($description);
        OpenGraph::setDescription($description)->setType('website');
        TwitterCard::setDescription($description);

        JsonLdMulti::setType('CollectionPage')->setTitle('Shop — Sheffield Commercial Kitchen Equipment')->setDescription($description)->addValue('url', route('catalog'));
    }

    #[Url(as: 'tag', history: true)]
    public string $selectedTag = '';

    #[Url(as: 'arrivals', history: true)]
    public bool $newArrivalsOnly = false;

    /** Free-text search term handed off from the nav search ("?q="). */
    #[Url(history: true)]
    public string $q = '';

    public function clearFilters(): void
    {
        $this->reset(['selectedTag', 'newArrivalsOnly', 'q']);
        $this->resetSharedFilters();
    }

    public function removeCategory(string $slug): void
    {
        $this->selectedCategories = array_values(array_filter($this->selectedCategories, fn ($s) => $s !== $slug));
    }

    #[Computed]
    public function products(): LengthAwarePaginator
    {
        $query = Product::query()
            ->with(['brand:id,name', 'taxClass:id,rate,is_inclusive', 'media'])
            ->visibleInCatalog()
            ->published()
            ->honorStockVisibility();

        if (trim($this->q) !== '') {
            $term = trim($this->q);
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('sku', 'like', "%{$term}%")
                    ->orWhere('model_number', 'like', "%{$term}%")
                    ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', "%{$term}%"));
            });
        }

        if ($this->selectedCategories) {
            $catIds = Category::whereIn('slug', $this->selectedCategories)->pluck('id');
            $query->where(function ($q) use ($catIds) {
                $q->whereIn('primary_category_id', $catIds)->orWhereHas('categories', fn ($q2) => $q2->whereIn('categories.id', $catIds));
            });
        }

        if ($this->selectedBrands) {
            $query->whereIn('brand_id', $this->selectedBrands);
        }

        if ($this->selectedTag !== '') {
            $query->whereHas('tags', fn ($t) => $t->where('name->'.config('app.locale', 'en'), $this->selectedTag));
        }

        if ($this->newArrivalsOnly) {
            $query->where('stock_status', StockStatus::IN_STOCK)->whereNotNull('price')->where('price', '>', 0)->where(fn ($q) => $q->where('published_at', '>=', now()->subDays(60))->orWhereHas('tags', fn ($t) => $t->where('name->'.config('app.locale', 'en'), 'New Arrival')));
        }

        $this->applySharedFilters($query);
        $this->applySort($query);

        return $query->paginate($this->perPage);
    }

    #[Computed]
    public function categoriesList(): Collection
    {
        // Only categories that actually hold catalog items (as primary category
        // or via the pivot) — an empty checkbox would filter to zero results.
        return Category::query()
            ->where('status', CategoryStatus::ACTIVE)
            ->withCount(['products' => fn ($q) => $q->published()->visibleInCatalog()])
            ->where(function ($q) {
                $q->whereHas('primaryProducts', fn ($p) => $p->published()->visibleInCatalog())
                    ->orWhereHas('products', fn ($p) => $p->published()->visibleInCatalog());
            })
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);
    }

    #[Computed]
    public function brandsList(): Collection
    {
        // Only brands with at least one catalog item — same reasoning as the
        // category facet: an empty checkbox would filter to zero results.
        return Brand::query()
            ->where('is_active', true)
            ->whereHas('products', fn ($p) => $p->published()->visibleInCatalog())
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function hasActiveFilters(): bool
    {
        return ! empty($this->selectedCategories) || $this->selectedTag !== '' || $this->newArrivalsOnly || trim($this->q) !== '' || $this->hasSharedActiveFilters();
    }
}; ?>

<div class="page-fade">
    {{-- Breadcrumb --}}
    <div class="border-b border-zinc-200 bg-surface-sunken">
        <div class="shell py-3">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('home')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Shop</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
    </div>

    {{-- pb-8 + the newsletter section's mt-12 = a 5rem gap, matching the page rhythm --}}
    <div class="shell pb-8">
        {{-- Mobile filter drawer (teleported to body) --}}
        <template x-teleport="body">
            <div x-show="$wire.showFilters" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex lg:hidden"
                @keydown.escape.window="$wire.showFilters = false" x-cloak>

                {{-- Backdrop --}}
                <div class="absolute inset-0 bg-black/40" @click="$wire.showFilters = false"></div>

                {{-- Drawer panel --}}
                <div x-show="$wire.showFilters" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    class="relative flex h-full w-72 max-w-[85vw] flex-col overflow-y-auto bg-white shadow-xl">

                    {{-- Drawer header --}}
                    <div
                        class="sticky top-0 z-10 flex items-center justify-between border-b border-zinc-200 bg-white px-5 py-3.5">
                        <span class="text-[13px] font-bold uppercase tracking-[0.08em] text-ink">Filters</span>
                        <div class="flex items-center gap-3">
                            @if ($this->hasActiveFilters())
                                <button type="button" wire:click="clearFilters"
                                    class="cursor-pointer text-[12px] font-medium text-brand-500 hover:underline">
                                    Clear all
                                </button>
                            @endif
                            <button type="button" wire:click="$set('showFilters', false)"
                                class="cursor-pointer text-ink-3 transition hover:text-ink">
                                <flux:icon.x-mark variant="micro" class="size-5" />
                            </button>
                        </div>
                    </div>

                    {{-- Filter sections --}}
                    <div class="flex-1 divide-y divide-zinc-200 text-sm">
                        @include('partials.storefront.facets.category-catalog')
                        @include('partials.storefront.filters-panel')
                    </div>

                    {{-- Drawer footer --}}
                    <div class="sticky bottom-0 border-t border-zinc-200 bg-white px-5 py-3.5">
                        <flux:button variant="customer-primary" size="customer" wire:click="$set('showFilters', false)"
                            class="w-full!">
                            View {{ $this->products->total() }} results
                        </flux:button>
                    </div>
                </div>
            </div>
        </template>

        <div class="mt-8 grid grid-cols-1 gap-4 lg:grid-cols-[260px_1fr]">
            {{-- Filters sidebar (desktop only) --}}
            <aside
                class="hidden lg:block lg:sticky lg:top-32 lg:self-start lg:max-h-[calc(100vh-9rem)] lg:overflow-y-auto scrollbar-hover">
                <div class="divide-y divide-zinc-200 rounded-md border border-zinc-200 bg-white text-sm">
                    @include('partials.storefront.facets.category-catalog')
                    @include('partials.storefront.filters-panel')
                </div>
            </aside>

            {{-- Results --}}
            <div class="@container min-w-0">
                {{-- Toolbar --}}
                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        {{-- Mobile: open filter drawer --}}
                        <flux:button size="sm" icon="funnel" icon:variant="outline" wire:click="$set('showFilters', true)"
                            class="lg:hidden">
                            Filters
                            @if ($this->hasActiveFilters())
                                <span class="size-2 rounded-full bg-brand-500"></span>
                            @endif
                        </flux:button>

                        <div class="text-[13.5px] text-ink-3">
                            Showing <span class="font-semibold text-ink">{{ $this->products->total() }}</span>
                            {{ \Illuminate\Support\Str::plural('product', $this->products->total()) }}
                            @if ($this->hasActiveFilters())
                                <button type="button" wire:click="clearFilters"
                                    class="ml-2.5 cursor-pointer text-[13px] text-brand-500 underline-offset-2 hover:underline">
                                    Clear filters
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <select wire:model.live="sort"
                            class="h-9 rounded border border-zinc-200 bg-white px-2.5 text-[13px] focus:border-brand-500 focus:ring-0 focus:outline-none">
                            <option value="popularity">Most popular</option>
                            <option value="newest">Newest</option>
                            <option value="name-asc">Name (A–Z)</option>
                            <option value="price-asc">Price — low to high</option>
                            <option value="price-desc">Price — high to low</option>
                        </select>
                    </div>
                </div>

                {{-- Active filter chips --}}
                @if ($this->hasActiveFilters())
                    <div class="mb-5 flex flex-wrap gap-2">
                        @if (trim($q) !== '')
                            <button type="button" wire:click="$set('q', '')"
                                class="inline-flex h-7 cursor-pointer items-center gap-1.5 rounded-full bg-surface-sunken px-3 text-[12.5px] font-medium text-ink-2 hover:bg-zinc-200">
                                <flux:icon.magnifying-glass variant="micro" class="size-3 text-ink-3" />
                                "{{ $q }}"
                                <flux:icon.x variant="micro" class="size-3 text-ink-3" />
                            </button>
                        @endif
                        @if ($selectedTag !== '')
                            <button type="button" wire:click="$set('selectedTag', '')"
                                class="inline-flex h-7 cursor-pointer items-center gap-1.5 rounded-full bg-surface-sunken px-3 text-[12.5px] font-medium text-ink-2 hover:bg-zinc-200">
                                {{ $selectedTag }}
                                <flux:icon.x variant="micro" class="size-3 text-ink-3" />
                            </button>
                        @endif
                        @if ($newArrivalsOnly)
                            <button type="button" wire:click="$set('newArrivalsOnly', false)"
                                class="inline-flex h-7 cursor-pointer items-center gap-1.5 rounded-full bg-surface-sunken px-3 text-[12.5px] font-medium text-ink-2 hover:bg-zinc-200">
                                New Arrivals
                                <flux:icon.x variant="micro" class="size-3 text-ink-3" />
                            </button>
                        @endif
                        @foreach ($selectedCategories as $slug)
                            @php $cat = $this->categoriesList->firstWhere('slug', $slug); @endphp
                            @if ($cat)
                                <button type="button" wire:click="removeCategory('{{ $slug }}')"
                                    class="inline-flex h-7 cursor-pointer items-center gap-1.5 rounded-full bg-surface-sunken px-3 text-[12.5px] font-medium text-ink-2 hover:bg-zinc-200">
                                    {{ $cat->name }}
                                    <flux:icon.x variant="micro" class="size-3 text-ink-3" />
                                </button>
                            @endif
                        @endforeach
                        @foreach ($selectedBrands as $id)
                            @php $br = $this->brandsList->firstWhere('id', $id); @endphp
                            @if ($br)
                                <button type="button" wire:click="removeBrand({{ $id }})"
                                    class="inline-flex h-7 cursor-pointer items-center gap-1.5 rounded-full bg-surface-sunken px-3 text-[12.5px] font-medium text-ink-2 hover:bg-zinc-200">
                                    {{ $br->name }}
                                    <flux:icon.x variant="micro" class="size-3 text-ink-3" />
                                </button>
                            @endif
                        @endforeach
                        @if ($inStockOnly)
                            <button type="button" wire:click="$toggle('inStockOnly')"
                                class="inline-flex h-7 cursor-pointer items-center gap-1.5 rounded-full bg-surface-sunken px-3 text-[12.5px] font-medium text-ink-2 hover:bg-zinc-200">
                                In stock only
                                <flux:icon.x variant="micro" class="size-3 text-ink-3" />
                            </button>
                        @endif
                        @if ($priceMin > 0 || $priceMax < 6000000)
                            <button type="button" wire:click="$set('priceMin', 0); $set('priceMax', 6000000)"
                                class="inline-flex h-7 cursor-pointer items-center gap-1.5 rounded-full bg-surface-sunken px-3 text-[12.5px] font-medium text-ink-2 hover:bg-zinc-200">
                                @if ($priceMin > 0 && $priceMax < 6000000)
                                    {{ money($priceMin * 100) }} – {{ money($priceMax * 100) }}
                                @elseif ($priceMin > 0)
                                    From {{ money($priceMin * 100) }}
                                @else
                                    Up to {{ money($priceMax * 100) }}
                                @endif
                                <flux:icon.x variant="micro" class="size-3 text-ink-3" />
                            </button>
                        @endif
                        @if ($minRating > 0)
                            <button type="button" wire:click="$set('minRating', 0)"
                                class="inline-flex h-7 cursor-pointer items-center gap-1.5 rounded-full bg-surface-sunken px-3 text-[12.5px] font-medium text-ink-2 hover:bg-zinc-200">
                                <span class="inline-flex items-center gap-0.5">{{ $minRating }}
                                    <flux:icon.star variant="micro" class="size-3 text-amber-500" /> &amp; up
                                </span>
                                <flux:icon.x variant="micro" class="size-3 text-ink-3" />
                            </button>
                        @endif
                    </div>
                @endif

                {{-- Results body --}}
                @if ($this->products->isEmpty())
                    <div class="rounded-md p-16 text-center">
                        <img src="{{ asset('images/empty-states/empty-list.svg') }}" alt=""
                            class="mx-auto mb-6 h-40 w-auto" />
                        <div class="font-serif text-2xl text-ink">No products match these filters</div>
                        <p class="mt-2 text-ink-3">Try widening your price range, or removing brand/category
                            constraints.</p>
                        <flux:button variant="customer-primary" size="customer" wire:click="clearFilters"
                            class="mt-5">
                            Clear all filters</flux:button>
                    </div>
                @else
                    <div
                        class="grid grid-cols-1 gap-3.5 @xs:grid-cols-2 @md:grid-cols-3 @2xl:grid-cols-4 @4xl:grid-cols-5 @7xl:grid-cols-6">
                        @foreach ($this->products as $product)
                            <x-storefront.product-card :product="$product" wire:key="prod-{{ $product->id }}" />
                        @endforeach
                    </div>
                @endif

                {{-- Infinite scroll sentinel --}}
                @if ($this->products->hasMorePages())
                    <div wire:intersect.margin.200px="loadMore" class="mt-10 flex justify-center py-6">
                        <flux:icon.loading class="size-6 text-ink-4" />
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('partials.storefront.accessory-modal')
</div>
