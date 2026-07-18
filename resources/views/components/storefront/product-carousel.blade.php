@props([
    'title',
    'products',
    'viewAllUrl' => null,
])

<div class="mt-16">
    <div class="mb-4 flex items-baseline justify-between">
        <h2 class="text-2xl font-semibold tracking-tight">{{ $title }}</h2>
        @if ($viewAllUrl)
            <a href="{{ $viewAllUrl }}" wire:navigate
                class="text-sm font-medium text-brand-500 underline transition-colors hover:text-brand-600">
                View all
            </a>
        @endif
    </div>

    <div class="relative" x-data="{
        swiper: null,
        init() {
            this.swiper = new Swiper($refs.carousel, {
                spaceBetween: 14,
                speed: 400,
                preventClicks: false,
                preventClicksPropagation: false,
                touchStartPreventDefault: false,
                breakpoints: {
                    0: { slidesPerView: 1.5 },
                    375: { slidesPerView: 2.5 },
                    640: { slidesPerView: 3.5 },
                    1024: { slidesPerView: 4.5 },
                    1280: { slidesPerView: 5.5 },
                    1536: { slidesPerView: 6.5 },
                },
            });
        }
    }">
        <div class="swiper" x-ref="carousel" wire:ignore>
            <div class="swiper-wrapper pb-1">
                @foreach ($products as $item)
                    <div class="swiper-slide h-auto!">
                        <div class="flex h-full flex-col">
                            <x-storefront.product-card :product="$item" class="h-full" />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="button" @click="swiper?.slidePrev()" aria-label="Previous products"
            class="absolute top-1/2 -left-3 z-10 hidden size-8 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border border-zinc-200 bg-white text-zinc-600 shadow-sm transition hover:border-zinc-300 hover:text-zinc-900 md:flex">
            <flux:icon.chevron-left class="size-4" />
        </button>
        <button type="button" @click="swiper?.slideNext()" aria-label="Next products"
            class="absolute top-1/2 -right-3 z-10 hidden size-8 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border border-zinc-200 bg-white text-zinc-600 shadow-sm transition hover:border-zinc-300 hover:text-zinc-900 md:flex">
            <flux:icon.chevron-right class="size-4" />
        </button>
    </div>
</div>
