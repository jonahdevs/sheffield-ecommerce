<?php

use App\Enums\CategoryStatus;
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
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

new #[Layout('layouts::storefront')] class extends Component
{
    use HasProductFilters, InteractsWithStorefront;

    public Category $category;

    public function mount(Category $category): void
    {
        $this->category = $category;

        $title = $category->meta_title ?: $category->name.'';
        $description = $category->meta_description ?: ($category->description ? Str::limit(strip_tags($category->description), 160) : null) ?: 'Browse '.$category->name.' from authorised distributors. Stock in Nairobi, install & service across East Africa.';

        SEOMeta::setTitle($title)->setDescription($description);
        OpenGraph::setTitle($title)->setDescription($description)->setType('website');
        TwitterCard::setTitle($title)->setDescription($description);

        if ($banner = $category->banner_url) {
            OpenGraph::addImage($banner);
            TwitterCard::setImage($banner);
        }

        if ($category->canonical_url) {
            SEOMeta::setCanonical($category->canonical_url);
        }

        $categoryUrl = route('category.show', $category->slug);

        JsonLdMulti::setType('CollectionPage')->setTitle($title)->setDescription($description)->addValue('url', $categoryUrl);

        JsonLdMulti::newJsonLd()
            ->setType('BreadcrumbList')
            ->addValue('itemListElement', [['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')], ['@type' => 'ListItem', 'position' => 2, 'name' => 'Categories', 'item' => route('categories.index')], ['@type' => 'ListItem', 'position' => 3, 'name' => $category->name, 'item' => $categoryUrl]]);
    }

    public function rendering($view): void
    {
        // Title was set in mount() via SEOMeta; mirror for layouts that read $title.
        $view->title($this->category->meta_title ?: $this->category->name.'');
    }

    public function clearFilters(): void
    {
        $this->resetSharedFilters();
    }

    /**
     * All categories grouped by parent id — loaded once so the subtree walk
     * stays a single query.
     *
     * @return Collection<int|string, Collection<int, Category>>
     */
    #[Computed]
    public function categoriesByParent(): Collection
    {
        return Category::query()
            ->get(['id', 'parent_id'])
            ->groupBy('parent_id');
    }

    /**
     * This category's id plus every descendant id, so listings roll up products
     * from child (and grandchild) categories.
     *
     * @return array<int, int>
     */
    #[Computed]
    public function fullSubtreeIds(): array
    {
        return $this->subtreeIds($this->category->id);
    }

    /**
     * The ids to scope the listing to: the selected child subtrees when the
     * shopper has filtered by category, otherwise the whole subtree.
     *
     * @return array<int, int>
     */
    #[Computed]
    public function scopeCategoryIds(): array
    {
        if (! $this->selectedCategories) {
            return $this->fullSubtreeIds;
        }

        $selected = collect($this->selectedCategories)->flatMap(fn ($id) => $this->subtreeIds((int) $id))->unique()->values()->all();

        // Guard against ids outside this category (e.g. a tampered URL).
        return array_values(array_intersect($selected, $this->fullSubtreeIds));
    }

    /**
     * Immediate child categories, for the "Category" filter facet.
     *
     * @return Collection<int, Category>
     */
    #[Computed]
    public function childCategories(): Collection
    {
        // Hide children whose whole subtree holds no catalog items — ticking
        // such a checkbox could only ever produce an empty listing.
        return Category::query()
            ->where('parent_id', $this->category->id)
            ->where('status', CategoryStatus::ACTIVE)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->filter(fn (Category $child) => Product::query()
                ->published()
                ->visibleInCatalog()
                ->where(function ($q) use ($child) {
                    $ids = $this->subtreeIds((int) $child->id);
                    $q->whereIn('primary_category_id', $ids)->orWhereHas('categories', fn ($q2) => $q2->whereIn('categories.id', $ids));
                })
                ->exists())
            ->values();
    }

    /**
     * Walk the category tree from $id, returning $id and all descendant ids.
     *
     * @return array<int, int>
     */
    private function subtreeIds(int $id): array
    {
        $byParent = $this->categoriesByParent;
        $ids = [];
        $stack = [$id];

        while ($stack !== []) {
            $current = array_pop($stack);
            $ids[] = $current;

            foreach ($byParent->get($current, collect()) as $child) {
                $stack[] = (int) $child->id;
            }
        }

        return $ids;
    }

    #[Computed]
    public function products(): LengthAwarePaginator
    {
        $query = Product::query()
            ->with(['brand:id,name', 'taxClass:id,rate,is_inclusive', 'media'])
            ->visibleInCatalog()
            ->published()
            ->honorStockVisibility()
            ->where(function ($q) {
                $ids = $this->scopeCategoryIds;
                $q->whereIn('primary_category_id', $ids)->orWhereHas('categories', fn ($q2) => $q2->whereIn('categories.id', $ids));
            });

        $this->applySharedFilters($query);
        $this->applySort($query);

        return $query->paginate($this->perPage);
    }

    #[Computed]
    public function brandsList(): Collection
    {
        // Only brands that have products in this category
        return Brand::query()
            ->where('is_active', true)
            ->whereHas('products', function ($q) {
                $q->published()->visibleInCatalog()->where(function ($q2) {
                    $ids = $this->fullSubtreeIds;
                    $q2->whereIn('primary_category_id', $ids)->orWhereHas('categories', fn ($q3) => $q3->whereIn('categories.id', $ids));
                });
            })
            ->orderBy('name')
            ->get();
    }

    public function hasActiveFilters(): bool
    {
        return ! empty($this->selectedCategories) || $this->hasSharedActiveFilters();
    }
}; ?>


<div class="page-fade">
    {{-- Breadcrumb --}}
    <div class="border-b border-zinc-200 bg-surface-sunken">
        <div class="shell py-3">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('home')" wire:navigate>Home</flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('categories.index')" wire:navigate>Categories</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>{{ $category->name }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
    </div>

    {{-- Category hero --}}
    @php
        $banner = $category->banner_url;
        $bannerPlaceholder = $category->banner_placeholder;
    @endphp
    <div
        class="relative overflow-hidden border-b border-zinc-200 py-6 sm:py-10
        {{ $banner ? '' : 'bg-surface-sunken' }}">

        @if ($banner)
            @if ($bannerPlaceholder)
                <img src="{{ $bannerPlaceholder }}" alt="" aria-hidden="true"
                    class="absolute inset-0 size-full scale-110 object-cover blur-xl" />
            @endif
            <picture class="contents">
                @if ($category->banner_webp_url)
                    <source srcset="{{ $category->banner_webp_url }}" type="image/webp" />
                @endif
                <img src="{{ $banner }}" alt="" aria-hidden="true" fetchpriority="high" decoding="async"
                    x-data="{ loaded: false }" x-init="loaded = $el.complete" x-on:load="loaded = true"
                    x-bind:class="loaded ? 'opacity-100' : 'opacity-0'"
                    class="absolute inset-0 size-full object-cover transition-opacity duration-700" />
            </picture>
            <div class="absolute inset-0 bg-zinc-900/60"></div>
        @endif

        <div class="shell relative z-10">
            <h1 class="text-xl font-semibold tracking-tight sm:text-2xl {{ $banner ? 'text-white' : 'text-ink' }}">
                {{ $category->name }}
            </h1>
            @if ($category->description)
                <p class="mt-2 max-w-xl text-[14px] {{ $banner ? 'text-white/75' : 'text-ink-3' }}">
                    {{ $category->description }}
                </p>
            @endif
        </div>
    </div>

    {{-- pb-8 + the newsletter section's mt-12 = a 5rem gap, matching the page rhythm --}}
    <div class="shell pt-4 pb-8">
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
                        @include('partials.storefront.facets.category-tree')
                        @include('partials.storefront.filters-panel')
                    </div>

                    {{-- Drawer footer --}}
                    <div class="sticky bottom-0 border-t border-zinc-200 bg-white px-5 py-3.5">
                        <flux:button variant="customer-primary" size="customer"
                            wire:click="$set('showFilters', false)" class="w-full!">
                            View {{ $this->products->total() }} results
                        </flux:button>
                    </div>
                </div>
            </div>
        </template>

        <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-[260px_1fr]">
            {{-- Filters sidebar (desktop only) --}}
            <aside
                class="scrollbar-hover hidden lg:block lg:sticky lg:top-32 lg:max-h-[calc(100vh-9rem)] lg:self-start lg:overflow-y-auto">
                <div class="divide-y divide-zinc-200 rounded-md border border-zinc-200 bg-white text-sm">
                    @include('partials.storefront.facets.category-tree')
                    @include('partials.storefront.filters-panel')
                </div>
            </aside>

            {{-- Results --}}
            <div class="@container min-w-0">
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

                @if ($this->products->isEmpty())
                    <div class="rounded-md p-16 text-center">
                        <img src="{{ asset('images/empty-states/empty-list.svg') }}" alt=""
                            class="mx-auto mb-6 h-40 w-auto" />
                        <div class="font-serif text-2xl text-ink">No products in this category yet</div>
                        <p class="mt-2 text-ink-3">Try removing filters, or browse the full catalog.</p>
                        <div class="mt-5 flex justify-center gap-2">
                            @if ($this->hasActiveFilters())
                                <flux:button variant="customer-outline" size="customer" wire:click="clearFilters">
                                    Clear
                                    filters</flux:button>
                            @endif
                            <flux:button variant="customer-primary" size="customer" href="{{ route('catalog') }}"
                                wire:navigate>Browse all products</flux:button>
                        </div>
                    </div>
                @else
                    <div
                        class="grid grid-cols-1 gap-3.5 @xs:grid-cols-2 @md:grid-cols-3 @2xl:grid-cols-4 @4xl:grid-cols-5 @7xl:grid-cols-6">
                        @foreach ($this->products as $product)
                            <x-storefront.product-card :product="$product" wire:key="prod-{{ $product->id }}" />
                        @endforeach
                    </div>
                @endif

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
