@if ($this->accessories->count() > 0)
    <div id="accessories" class="mt-8 scroll-mt-44">

        {{-- ≤3: simple grid --}}
        @if ($this->accessories->count() <= 3)

            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-semibold text-zinc-800">Recommended Accessories</h2>
                    <span class="text-xs text-zinc-500 bg-zinc-100 border border-zinc-200 rounded-full px-2.5 py-0.5">
                        {{ $this->accessories->count() }}
                    </span>
                </div>
                <flux:button wire:click="addAllAccessoriesToCart" wire:loading.attr="disabled"
                    wire:target="addAllAccessoriesToCart" size="sm" variant="filled" icon="shopping-cart"
                    class="cursor-pointer">
                    Add all
                </flux:button>
            </div>

            <div @class([
                'grid gap-4',
                'grid-cols-1' => $this->accessories->count() === 1,
                'grid-cols-1 sm:grid-cols-2' => $this->accessories->count() === 2,
                'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3' =>
                    $this->accessories->count() === 3,
            ])>
                @foreach ($this->accessories as $accessory)
                    <livewire:accessory-item :product="$accessory" :recommended-quantity="$accessory->pivot->quantity ?? 1" :key="'accessory-' . $accessory->id" />
                @endforeach
            </div>

            {{-- >3: Alpine carousel --}}
        @else
            <div x-data="{
                current: 0,
                total: {{ $this->accessories->count() }},
                perPage() {
                    if (window.innerWidth >= 1280) return 4;
                    if (window.innerWidth >= 1024) return 3;
                    if (window.innerWidth >= 640) return 2;
                    return 1;
                },
                get maxIndex() { return Math.max(0, this.total - this.perPage()); },
                get canPrev() { return this.current > 0; },
                get canNext() { return this.current < this.maxIndex; },
                prev() { if (this.canPrev) this.current--; },
                next() { if (this.canNext) this.current++; },
                clamp() { this.current = Math.min(this.current, this.maxIndex); },
            }" x-init="window.addEventListener('resize', () => clamp())">
                {{-- Header --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <h2 class="text-lg font-semibold text-zinc-800">Recommended Accessories</h2>
                        <span
                            class="text-xs text-zinc-500 bg-zinc-100 border border-zinc-200 rounded-full px-2.5 py-0.5">
                            {{ $this->accessories->count() }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- Prev --}}
                        <button @click="prev" :disabled="!canPrev"
                            :class="!canPrev ? 'opacity-30 cursor-not-allowed' : 'hover:bg-zinc-100'"
                            class="w-8 h-8 flex items-center justify-center border border-zinc-300 rounded-md transition-colors cursor-pointer"
                            aria-label="Previous">
                            <flux:icon.chevron-left class="w-4 h-4 text-zinc-600" />
                        </button>

                        {{-- Next --}}
                        <button @click="next" :disabled="!canNext"
                            :class="!canNext ? 'opacity-30 cursor-not-allowed' : 'hover:bg-zinc-100'"
                            class="w-8 h-8 flex items-center justify-center border border-zinc-300 rounded-md transition-colors cursor-pointer"
                            aria-label="Next">
                            <flux:icon.chevron-right class="w-4 h-4 text-zinc-600" />
                        </button>

                        <div class="w-px h-5 bg-zinc-200 mx-1"></div>

                        {{-- Add all --}}
                        <flux:button wire:click="addAllAccessoriesToCart" wire:loading.attr="disabled"
                            wire:target="addAllAccessoriesToCart" size="sm" variant="filled" icon="shopping-cart"
                            class="cursor-pointer">
                            Add all
                        </flux:button>
                    </div>
                </div>

                {{-- Carousel viewport --}}
                <div class="overflow-hidden">
                    <div class="flex gap-4 transition-transform duration-300 ease-in-out"
                        :style="`transform: translateX(calc(-${current} * (100% / ${perPage()} + (16px / ${perPage()}))))`">
                        @foreach ($this->accessories as $accessory)
                            <div class="shrink-0 transition-all duration-300"
                                :style="`width: calc(${100 / perPage()}% - ${16 * (perPage() - 1) / perPage()}px)`">
                                <livewire:accessory-item :product="$accessory" :recommended-quantity="$accessory->pivot->quantity ?? 1" :key="'accessory-' . $accessory->id" />
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Dot indicators --}}
                <div class="flex justify-center gap-1.5 mt-4">
                    @for ($i = 0; $i <= $this->accessories->count() - 1; $i++)
                        <button @click="current = Math.min({{ $i }}, maxIndex)"
                            :class="{{ $i }} === current ? 'bg-brand-secondary w-4' : 'bg-zinc-300 w-1.5'"
                            class="h-1.5 rounded-full transition-all duration-200"
                            aria-label="Go to slide {{ $i + 1 }}"></button>
                    @endfor
                </div>

            </div>
        @endif

    </div>
@endif
