{{-- ==========================================================================
     Product Filters Partial
     Included by: products page (desktop sidebar + mobile drawer)
     All old tokens replaced with brand-* tokens.
     ========================================================================== --}}

{{-- Category filter — only rendered if the component has a selectedCategory property --}}
@if (isset($this->selectedCategory))
    <div class="p-4">
        <h3 class="font-medium mb-3">Category</h3>
        <div class="max-h-64 overflow-y-auto">
            @if ($this->selectedCategory)
                <div class="font-medium text-sm text-brand-secondary bg-brand-secondary/10 p-2 rounded mb-3">
                    {{ $this->selectedCategory->name }}
                </div>
                @if ($this->categories->isNotEmpty())
                    <div class="text-xs text-zinc-500 px-2 mb-2 font-medium">Subcategories:</div>
                    @foreach ($this->categories as $category)
                        <button type="button"
                            class="flex items-center gap-2 cursor-pointer hover:bg-zinc-50 p-2 rounded w-full text-left"
                            wire:click="selectCategory('{{ $category->slug }}')">
                            <flux:icon.chevron-right variant="micro" />
                            <span class="text-sm text-zinc-700">{{ $category->name }}</span>
                        </button>
                    @endforeach
                @endif
            @else
                @foreach ($this->categories as $category)
                    <button type="button"
                        class="text-sm capitalize px-2 py-2 hover:bg-zinc-100 rounded block w-full text-left"
                        wire:click="selectCategory('{{ $category->slug }}')">
                        {{ $category->name }}
                    </button>
                @endforeach
            @endif
        </div>
    </div>
@endif

{{-- Price filter --}}
<div class="p-4" x-data="{
    localMin: {{ $minPrice ?? ($this->priceRange->min_price ?? 0) }},
    localMax: {{ $maxPrice ?? ($this->priceRange->max_price ?? 1000000) }},
    absoluteMin: {{ $this->priceRange->min_price ?? 0 }},
    absoluteMax: {{ $this->priceRange->max_price ?? 1000000 }},
    updateMin() {
        this.localMin = parseFloat(this.localMin);
        if (this.localMin > this.localMax) this.localMin = this.localMax;
        if (this.localMin < this.absoluteMin) this.localMin = this.absoluteMin;
    },
    updateMax() {
        this.localMax = parseFloat(this.localMax);
        if (this.localMax < this.localMin) this.localMax = this.localMin;
        if (this.localMax > this.absoluteMax) this.localMax = this.absoluteMax;
    },
    apply() {
        $wire.minPrice = this.localMin;
        $wire.maxPrice = this.localMax;
        $wire.applyPriceFilter();
    },
    reset() {
        this.localMin = this.absoluteMin;
        this.localMax = this.absoluteMax;
        $wire.clearPriceFilter();
    }
}">
    <div class="flex items-center justify-between mb-3">
        <h3 class="font-medium">Price (KES)</h3>
        <div class="flex items-center gap-2">
            <button @click="reset" x-show="localMin != absoluteMin || localMax != absoluteMax" x-transition
                class="text-zinc-500 text-xs hover:text-zinc-700 cursor-pointer font-medium" type="button">
                Reset
            </button>
            <button @click="apply" class="text-brand-secondary text-sm hover:underline cursor-pointer font-medium"
                type="button">
                Apply
            </button>
        </div>
    </div>
    <div class="space-y-4">
        <div class="flex items-center justify-between text-sm">
            <span class="text-zinc-600">KES <span x-text="Math.round(localMin).toLocaleString()"></span></span>
            <span class="text-zinc-600">KES <span x-text="Math.round(localMax).toLocaleString()"></span></span>
        </div>
        <div class="relative">
            <div class="relative w-full h-2 bg-zinc-200 rounded pointer-events-none">
                <div class="absolute h-2 bg-brand-secondary rounded"
                    :style="`left: ${((localMin - absoluteMin) / (absoluteMax - absoluteMin)) * 100}%; right: ${100 - ((localMax - absoluteMin) / (absoluteMax - absoluteMin)) * 100}%`">
                </div>
            </div>
            <input type="range" x-model.number="localMax" @input="updateMax" :min="absoluteMin"
                :max="absoluteMax" step="1000"
                class="absolute inset-0 top-1/2 -translate-y-1/2 w-full h-2 bg-transparent appearance-none cursor-pointer
                    [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4
                    [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:cursor-pointer
                    [&::-webkit-slider-thumb]:shadow-md [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-white"
                style="z-index: 1; --tw-thumb-bg: var(--brand-secondary);">
            <input type="range" x-model.number="localMin" @input="updateMin" :min="absoluteMin"
                :max="absoluteMax" step="1000"
                class="absolute inset-0 top-1/2 -translate-y-1/2 w-full h-2 bg-transparent appearance-none cursor-pointer
                    [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4
                    [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:cursor-pointer
                    [&::-webkit-slider-thumb]:shadow-md [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-white"
                style="z-index: 2; pointer-events: none;">
        </div>
        <div class="flex items-center gap-2 text-sm">
            <input type="number" x-model.number="localMin" @blur="updateMin" :min="absoluteMin"
                :max="absoluteMax" step="1000"
                class="w-full px-2 py-1.5 border border-zinc-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary/50"
                placeholder="Min">
            <span class="text-zinc-400 shrink-0">—</span>
            <input type="number" x-model.number="localMax" @blur="updateMax" :min="absoluteMin"
                :max="absoluteMax" step="1000"
                class="w-full px-2 py-1.5 border border-zinc-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-brand-secondary/50"
                placeholder="Max">
        </div>
    </div>
</div>

{{-- Slider thumb color — inline style since Tailwind can't generate arbitrary CSS var values --}}
<style>
    input[type="range"]::-webkit-slider-thumb {
        background-color: var(--brand-secondary) !important;
    }

    input[type="range"]::-moz-range-thumb {
        background-color: var(--brand-secondary) !important;
    }
</style>

{{-- Rating filter --}}
<div class="p-4">
    <h3 class="font-medium mb-3">Rating</h3>
    <div class="space-y-2">
        <flux:radio.group wire:model.live="minRating">
            @for ($rating = 4; $rating >= 1; $rating--)
                <flux:field class="flex! items-center!">
                    <flux:radio value="{{ $rating }}" />
                    <flux:label>
                        @for ($i = 1; $i <= 5; $i++)
                            <flux:icon.star class="w-4 h-4 {{ $i <= $rating ? 'text-yellow-400' : 'text-zinc-300' }}"
                                variant="solid" />
                        @endfor
                        <span class="ms-1 font-normal">& above</span>
                    </flux:label>
                </flux:field>
            @endfor
        </flux:radio.group>
    </div>
</div>

{{-- Brand filter --}}
<div class="p-4">
    <h3 class="font-medium mb-3">Brand</h3>
    <div class="mb-3">
        <flux:input icon="magnifying-glass" placeholder="Search brands..." size="sm"
            wire:model.live.debounce.300ms="brandSearch" clearable />
    </div>
    <div class="max-h-64 overflow-y-auto">
        @forelse ($this->filteredBrands as $brand)
            <flux:field class="text-sm font-medium px-2 py-2 flex! items-center!">
                <flux:checkbox wire:key="brand-{{ $brand->slug }}" value="{{ $brand->slug }}"
                    :checked="in_array($brand->slug, $selectedBrands)"
                    wire:click="toggleBrand('{{ $brand->slug }}')" />
                <flux:label class="font-normal cursor-pointer">{{ $brand->name }}</flux:label>
            </flux:field>
        @empty
            <p class="text-sm text-zinc-500 px-2 py-2">No brands found</p>
        @endforelse
    </div>
</div>

{{-- More filters --}}
<div class="p-4">
    <h3 class="font-medium mb-3">More Filters</h3>
    <div class="space-y-2">
        <flux:field class="flex! items-center!">
            <flux:checkbox wire:model.live="inStock" />
            <flux:label class="ms-2 font-normal">In Stock</flux:label>
        </flux:field>
        {{-- Featured filter — only rendered if the component has a featured property --}}
        @if (isset($this->featured))
            <flux:field class="flex! items-center! mt-2">
                <flux:checkbox wire:model.live="featured" />
                <flux:label class="ms-2 font-normal">Featured Products</flux:label>
            </flux:field>
        @endif
        <flux:field class="flex! items-center! mt-2">
            <flux:checkbox wire:model.live="onSale" />
            <flux:label class="ms-2 font-normal">On Sale</flux:label>
        </flux:field>
    </div>
</div>
