<?php

use App\Enums\CategoryStatus;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public string $query = '';

    public bool $mobileOpen = false;

    /**
     * Trending search terms: the most-viewed products of the last 30 days,
     * topped up with the newest arrivals when view data is thin.
     *
     * @return Collection<int, string>
     */
    #[Computed]
    public function trending(): Collection
    {
        $terms = Cache::remember('storefront.trending-searches', now()->addHour(), function (): array {
            $terms = Product::query()
                ->published()
                ->visibleInSearch()
                ->whereHas('views', fn ($q) => $q->where('viewed_at', '>=', now()->subDays(30)))
                ->withCount(['views as recent_views_count' => fn ($q) => $q->where('viewed_at', '>=', now()->subDays(30))])
                ->orderByDesc('recent_views_count')
                ->take(6)
                ->pluck('name');

            if ($terms->count() < 6) {
                $terms = $terms->concat(
                    Product::query()
                        ->published()
                        ->visibleInSearch()
                        ->whereNotIn('name', $terms)
                        ->latest()
                        ->take(6 - $terms->count())
                        ->pluck('name')
                );
            }

            return $terms->values()->all();
        });

        return collect($terms);
    }

    #[Computed]
    public function products(): Collection
    {
        if (strlen(trim($this->query)) < 2) {
            return collect();
        }

        return Product::query()
            ->with(['brand:id,name', 'media'])
            ->visibleInSearch()
            ->published()
            ->where(function ($q) {
                $q->where('name', 'like', "%{$this->query}%")
                    ->orWhere('sku', 'like', "%{$this->query}%")
                    ->orWhere('model_number', 'like', "%{$this->query}%")
                    ->orWhereHas('brand', fn ($q2) => $q2->where('name', 'like', "%{$this->query}%"));
            })
            ->take(5)
            ->get();
    }

    #[Computed]
    public function categories(): Collection
    {
        if (strlen(trim($this->query)) < 2) {
            return collect();
        }

        return Category::query()
            ->where('status', CategoryStatus::ACTIVE)
            ->withCount('products')
            ->where('name', 'like', "%{$this->query}%")
            ->take(3)
            ->get();
    }

    #[Computed]
    public function brands(): Collection
    {
        if (strlen(trim($this->query)) < 2) {
            return collect();
        }

        return Brand::query()
            ->where('is_active', true)
            ->where('name', 'like', "%{$this->query}%")
            ->take(3)
            ->get();
    }

    public function hasResults(): bool
    {
        return $this->products->isNotEmpty() || $this->categories->isNotEmpty() || $this->brands->isNotEmpty();
    }

    public function openMobile(): void
    {
        $this->mobileOpen = true;
    }

    public function closeMobile(): void
    {
        $this->mobileOpen = false;
        $this->query = '';
        unset($this->products, $this->categories, $this->brands);
    }
}; ?>

<div class="relative w-full" x-data="{
    show: false,
    recent: JSON.parse(localStorage.getItem('sheffield-recent') || '[]'),
    saveRecent(term) {
        this.recent = [term, ...this.recent.filter(r => r !== term)].slice(0, 6);
        localStorage.setItem('sheffield-recent', JSON.stringify(this.recent));
    },
    clearRecent() {
        this.recent = [];
        localStorage.removeItem('sheffield-recent');
    },
}" x-on:keydown.escape.window="show = false"
    x-on:mousedown.outside="show = false"
    x-effect="document.body.style.overflow = show ? 'hidden' : ''"
    x-on:open-mobile-search.window="$wire.openMobile()">

    {{-- Backdrop: dims + locks the rest of the page while searching (modal-style).
         Lives inside the search component's stacking context so it covers the whole
         header too, leaving only the input (z-10) and dropdown (z-50) lifted above it. --}}
    <div x-show="show" x-cloak x-transition.opacity.duration.200ms @click="show = false"
        class="fixed inset-0 z-0 hidden bg-black/40 lg:block"></div>

    {{-- Desktop input --}}
    <div class="relative z-10">
        <flux:input wire:model.live.debounce.200ms="query" @focus="show = true"
            @keydown.enter.prevent="
                if ($wire.query.trim()) {
                    saveRecent($wire.query.trim());
                    window.location = '{{ route('catalog') }}?q=' + encodeURIComponent($wire.query.trim());
                }
            "
            autocomplete="off" spellcheck="false" icon="magnifying-glass" clearable kbd="⌘K"
            placeholder="Search ovens, refrigeration, brands, SKU..." />
    </div>

    {{-- Desktop dropdown panel --}}
    <div x-show="show" x-cloak x-transition:enter="transition duration-150 ease-out"
        x-transition:enter-start="opacity-0 -translate-y-1.5" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition duration-100 ease-in" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="scrollbar-thin absolute top-[calc(100%+8px)] left-0 right-0 z-50 max-h-[calc(100vh-120px)] overflow-y-auto rounded-md border border-zinc-200 bg-white shadow-xl">

        @if (strlen(trim($query)) < 2)
            {{-- Empty state: recent + trending --}}
            <div x-show="recent.length > 0">
                <div class="flex items-center justify-between px-4 py-2.5">
                    <span class="text-xs font-bold tracking-widest text-ink-4 uppercase">Recent</span>
                    <button type="button" @click="clearRecent()"
                        class="cursor-pointer text-xs text-ink-4 underline underline-offset-2 hover:text-ink">Clear</button>
                </div>
                <template x-for="term in recent" :key="term">
                    <button type="button" @click="$wire.set('query', term)"
                        class="flex w-full cursor-pointer items-center gap-3 px-4 py-2.5 text-left text-sm text-ink-2 hover:bg-surface-sunken">
                        <flux:icon.clock variant="micro" class="size-3.5 shrink-0 text-ink-4" />
                        <span x-text="term"></span>
                    </button>
                </template>
            </div>

            @if ($this->trending->isNotEmpty())
                <div class="border-t border-zinc-100 px-4 pb-4 pt-3">
                    <div class="mb-2.5 text-xs font-bold tracking-widest text-ink-4 uppercase">Trending</div>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach ($this->trending as $term)
                            <button type="button" wire:click="$set('query', '{{ addslashes($term) }}')"
                                class="inline-flex h-7 cursor-pointer items-center rounded-full bg-surface-sunken px-3 text-xs font-medium text-ink-2 transition hover:bg-zinc-200">
                                {{ $term }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            @if ($this->hasResults())
                @if ($this->products->isNotEmpty())
                    <div class="border-t border-zinc-100 pt-1">
                        @foreach ($this->products as $product)
                            <a href="{{ route('product.show', $product) }}" wire:navigate
                                @click="saveRecent('{{ addslashes($product->name) }}')"
                                class="grid cursor-pointer grid-cols-[36px_1fr_auto] items-center gap-3 px-4 py-1.5 hover:bg-surface-sunken">
                                @if ($product->cover_url)
                                    <img src="{{ $product->cover_url }}" alt=""
                                        class="size-9 rounded object-contain" loading="lazy" />
                                @else
                                    <div class="flex size-9 items-center justify-center rounded border border-zinc-100 bg-surface-sunken">
                                        <flux:icon.photo class="size-4 text-ink-4" />
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <div class="line-clamp-2 text-sm leading-snug text-ink">{{ $product->name }}</div>
                                </div>
                                <flux:icon.chevron-right variant="micro" class="size-3.5 text-ink-4" />
                            </a>
                        @endforeach
                    </div>
                @endif

                @if ($this->categories->isNotEmpty())
                    <div class="border-t border-zinc-100">
                        <div class="px-4 py-2 text-xs font-bold tracking-widest text-ink-4 uppercase">Categories</div>
                        @foreach ($this->categories as $category)
                            <a href="{{ route('category.show', $category) }}" wire:navigate
                                @click="saveRecent('{{ addslashes($category->name) }}')"
                                class="grid cursor-pointer grid-cols-[20px_1fr_auto] items-center gap-3 px-4 py-2.5 hover:bg-surface-sunken">
                                <flux:icon.squares-2x2 variant="micro" class="size-3.5 text-ink-4" />
                                <span class="text-sm text-ink">{{ $category->name }}</span>
                                <span class="text-xs text-ink-4 tabular-nums">{{ $category->products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif

                @if ($this->brands->isNotEmpty())
                    <div class="border-t border-zinc-100">
                        <div class="px-4 py-2 text-xs font-bold tracking-widest text-ink-4 uppercase">Brands</div>
                        @foreach ($this->brands as $brand)
                            <a href="{{ route('catalog') }}?brand={{ $brand->id }}" wire:navigate
                                @click="saveRecent('{{ addslashes($brand->name) }}')"
                                class="grid cursor-pointer grid-cols-[20px_1fr_auto] items-center gap-3 px-4 py-2.5 hover:bg-surface-sunken">
                                <span class="inline-flex size-4 items-center justify-center rounded bg-surface-sunken text-xs font-bold text-ink-3 border border-zinc-200">
                                    {{ strtoupper($brand->name[0]) }}
                                </span>
                                <span class="text-sm text-ink">{{ $brand->name }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="border-t border-zinc-100 px-4 py-8 text-center">
                    <div class="text-sm font-medium text-ink-2">No matches for "{{ $query }}"</div>
                    <div class="mt-1 text-xs text-ink-4">Try a brand, category or SKU</div>
                </div>
            @endif
        @endif

        {{-- Keyboard hint footer --}}
        <div class="hidden items-center justify-end gap-2 border-t border-zinc-100 px-4 py-2 text-xs text-ink-4 lg:flex">
            <kbd class="inline-flex h-4.5 items-center rounded border border-zinc-200 bg-zinc-50 px-1"><flux:icon.arrow-up variant="micro" class="size-3" /></kbd>
            <kbd class="inline-flex h-4.5 items-center rounded border border-zinc-200 bg-zinc-50 px-1"><flux:icon.arrow-down variant="micro" class="size-3" /></kbd>
            <span class="mr-2">navigate</span>
            <kbd class="inline-flex h-4.5 items-center rounded border border-zinc-200 bg-zinc-50 px-1">esc</kbd>
            <span>close</span>
        </div>
    </div>

    {{-- Mobile full-screen search overlay --}}
    <template x-teleport="body">
        <div x-show="$wire.mobileOpen"
            x-effect="if ($wire.mobileOpen) $nextTick(() => $el.querySelector('input')?.focus())"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="fixed inset-0 z-[200] flex flex-col bg-white lg:hidden"
            @keydown.escape.window="$wire.closeMobile()">

            {{-- Header: back button + search input --}}
            <div class="flex shrink-0 items-center gap-2 border-b border-zinc-200 px-2 py-2.5">
                <button type="button" @click="$wire.closeMobile()"
                    class="inline-flex size-10 shrink-0 items-center justify-center rounded-md text-ink-2 transition hover:bg-surface-sunken"
                    aria-label="Close search">
                    <flux:icon.arrow-left variant="outline" class="size-5" />
                </button>
                <div class="flex-1">
                    <flux:input wire:model.live.debounce.200ms="query" type="search"
                        @keydown.enter.prevent="
                            if ($wire.query.trim()) {
                                saveRecent($wire.query.trim());
                                window.location = '{{ route('catalog') }}?q=' + encodeURIComponent($wire.query.trim());
                                $wire.closeMobile();
                            }
                        "
                        autocomplete="off" spellcheck="false" icon="magnifying-glass" clearable
                        placeholder="Search products, brands, SKU..." />
                </div>
            </div>

            {{-- Scrollable results --}}
            <div class="scrollbar-thin flex-1 overflow-y-auto">

                @if (strlen(trim($query)) < 2)
                    {{-- Recent searches --}}
                    <div x-show="recent.length > 0">
                        <div class="flex items-center justify-between px-4 py-2.5">
                            <span class="text-xs font-bold tracking-widest text-ink-4 uppercase">Recent</span>
                            <button type="button" @click="clearRecent()"
                                class="cursor-pointer text-xs text-ink-4 underline underline-offset-2 hover:text-ink">Clear</button>
                        </div>
                        <template x-for="term in recent" :key="term">
                            <button type="button" @click="$wire.set('query', term)"
                                class="flex w-full cursor-pointer items-center gap-3 px-4 py-3 text-left text-sm text-ink-2 hover:bg-surface-sunken">
                                <flux:icon.clock variant="micro" class="size-3.5 shrink-0 text-ink-4" />
                                <span x-text="term"></span>
                            </button>
                        </template>
                    </div>

                    {{-- Trending --}}
                    @if ($this->trending->isNotEmpty())
                        <div class="border-t border-zinc-100 px-4 pb-5 pt-4">
                            <div class="mb-3 text-xs font-bold tracking-widest text-ink-4 uppercase">Trending</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($this->trending as $term)
                                    <button type="button" wire:click="$set('query', '{{ addslashes($term) }}')"
                                        class="inline-flex h-8 cursor-pointer items-center rounded-full bg-surface-sunken px-3.5 text-sm font-medium text-ink-2 transition hover:bg-zinc-200">
                                        {{ $term }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Empty state hint --}}
                    <div class="flex flex-col items-center px-6 py-12 text-center">
                        <flux:icon.magnifying-glass class="mb-3 size-10 text-zinc-200" />
                        <p class="text-sm text-ink-4">Type at least 2 characters to search</p>
                    </div>
                @else
                    {{-- "Search for X" link --}}
                    <a href="{{ route('catalog') }}?q={{ urlencode($query) }}" wire:navigate
                        @click="saveRecent('{{ addslashes($query) }}'); $wire.closeMobile()"
                        class="flex items-center gap-3 px-4 py-3.5 text-sm text-ink-2 hover:bg-surface-sunken">
                        <flux:icon.magnifying-glass variant="micro" class="size-4 shrink-0 text-ink-4" />
                        <span>Search for <strong class="text-ink">"{{ $query }}"</strong></span>
                        <flux:icon.arrow-right variant="micro" class="ml-auto size-4 text-ink-4" />
                    </a>

                    @if ($this->hasResults())
                        @if ($this->products->isNotEmpty())
                            <div class="border-t border-zinc-100 pt-1">
                                @foreach ($this->products as $product)
                                    <a href="{{ route('product.show', $product) }}" wire:navigate
                                        @click="saveRecent('{{ addslashes($product->name) }}'); $wire.closeMobile()"
                                        class="grid cursor-pointer grid-cols-[40px_1fr_auto] items-center gap-3 px-4 py-2 hover:bg-surface-sunken">
                                        @if ($product->cover_url)
                                            <img src="{{ $product->cover_url }}" alt=""
                                                class="size-10 rounded object-contain" loading="lazy" />
                                        @else
                                            <div class="flex size-10 items-center justify-center rounded border border-zinc-100 bg-surface-sunken">
                                                <flux:icon.photo class="size-5 text-ink-4" />
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="line-clamp-2 text-sm leading-snug text-ink">{{ $product->name }}</div>
                                        </div>
                                        <flux:icon.chevron-right variant="micro" class="size-4 text-ink-4" />
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        @if ($this->categories->isNotEmpty())
                            <div class="border-t border-zinc-100">
                                <div class="px-4 py-2.5 text-xs font-bold uppercase tracking-widest text-ink-4">Categories</div>
                                @foreach ($this->categories as $category)
                                    <a href="{{ route('category.show', $category) }}" wire:navigate
                                        @click="saveRecent('{{ addslashes($category->name) }}'); $wire.closeMobile()"
                                        class="grid cursor-pointer grid-cols-[20px_1fr_auto] items-center gap-3 px-4 py-3 hover:bg-surface-sunken">
                                        <flux:icon.squares-2x2 variant="micro" class="size-3.5 text-ink-4" />
                                        <span class="text-sm text-ink">{{ $category->name }}</span>
                                        <span class="tabular-nums text-xs text-ink-4">{{ $category->products_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        @if ($this->brands->isNotEmpty())
                            <div class="border-t border-zinc-100">
                                <div class="px-4 py-2.5 text-xs font-bold uppercase tracking-widest text-ink-4">Brands</div>
                                @foreach ($this->brands as $brand)
                                    <a href="{{ route('catalog') }}?brand={{ $brand->id }}" wire:navigate
                                        @click="saveRecent('{{ addslashes($brand->name) }}'); $wire.closeMobile()"
                                        class="grid cursor-pointer grid-cols-[20px_1fr_auto] items-center gap-3 px-4 py-3 hover:bg-surface-sunken">
                                        <span class="inline-flex size-4 items-center justify-center rounded border border-zinc-200 bg-surface-sunken text-xs font-bold text-ink-3">
                                            {{ strtoupper($brand->name[0]) }}
                                        </span>
                                        <span class="text-sm text-ink">{{ $brand->name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="px-4 py-10 text-center">
                            <div class="text-sm font-medium text-ink-2">No matches for "{{ $query }}"</div>
                            <div class="mt-1 text-xs text-ink-4">Try a brand, category or SKU</div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </template>
</div>
