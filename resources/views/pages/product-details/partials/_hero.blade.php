<flux:card class="lg:col-span-3 rounded-sm grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-10">

    {{-- ── Image Slider ── --}}
    <div class="lg:col-span-2">
        <div wire:ignore class="w-full" x-data="{
            mainSwiper: null,
            thumbSwiper: null,
            activeIndex: 0,
            isBeginning: true,
            isEnd: false,
        
            init() {
                this.thumbSwiper = new Swiper('#thumbSwiper', {
                    spaceBetween: 10,
                    slidesPerView: 4,
                    freeMode: true,
                    watchSlidesProgress: true,
                    loop: true,
                    breakpoints: {
                        640: { slidesPerView: 5 },
                        768: { slidesPerView: 6 },
                    },
                    on: {
                        slideChange: (swiper) => {
                            this.isBeginning = swiper.isBeginning;
                            this.isEnd = swiper.isEnd;
                        },
                    },
                });
        
                this.mainSwiper = new Swiper('#mainSwiper', {
                    spaceBetween: 10,
                    loop: true,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    thumbs: { swiper: this.thumbSwiper },
                    on: {
                        slideChange: (swiper) => {
                            this.activeIndex = swiper.realIndex;
                            this.thumbSwiper.slideTo(swiper.realIndex);
                        },
                    },
                });
        
                this.$nextTick(() => {
                    document.getElementById('thumbSwiper').classList.remove('opacity-0');
                    document.getElementById('mainSwiper').classList.remove('opacity-0');
                    this.isBeginning = this.thumbSwiper.isBeginning;
                    this.isEnd = this.thumbSwiper.isEnd;
                });
            },
        }">
            {{-- Main Slider --}}
            <div class="mb-4">
                <div class="swiper border-2 rounded-sm overflow-hidden px-2 opacity-0 transition-opacity duration-500"
                    id="mainSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($product->images as $image)
                            <div class="swiper-slide">
                                <div class="aspect-square flex items-center justify-center">
                                    <img src="{{ $image->url }}" alt="{{ $image->alt_text ?? $product->name }}"
                                        class="w-full h-full object-contain" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Thumbnail Slider --}}
            <div class="relative" x-show="thumbSwiper" x-cloak>
                <div class="swiper px-12 opacity-0 transition-opacity duration-500" id="thumbSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($product->images as $image)
                            <div class="swiper-slide cursor-pointer">
                                <div class="aspect-square flex items-center justify-center rounded-sm overflow-hidden border-2 transition-all duration-300"
                                    :class="activeIndex === {{ $loop->index }} ?
                                        'border-sheffield-blue' :
                                        'border-zinc-200 hover:border-zinc-300'">
                                    <img src="{{ $image->url }}" alt="{{ $image->alt_text ?? $product->name }}"
                                        class="w-full h-full object-contain" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Product Details ── --}}
    <div class="lg:col-span-3">
        <h1 class="text-3xl font-bold">{{ $product->name }}</h1>

        <div class="flex items-center justify-between flex-wrap gap-3 mt-2">
            <div class="flex items-center gap-3">
                <span class="text-zinc-500 text-sm">Brand:</span>
                <span class="text-sheffield-blue font-semibold text-sm">{{ $product->brand?->name }}</span>
            </div>

            <div class="flex items-center gap-2">
                <div class="flex items-center gap-1">
                    @for ($i = 0; $i < 5; $i++)
                        @if ($product->reviews_avg_rating && $i <= floor($product->reviews_avg_rating))
                            <flux:icon.star variant="solid" class="w-4 h-4 fill-yellow-400 text-yellow-400" />
                        @elseif ($product->reviews_avg_rating && $i - 0.5 <= $product->reviews_avg_rating)
                            <div class="relative w-4 h-4">
                                <flux:icon.star variant="solid" class="w-4 h-4 text-zinc-300" />
                                <div class="absolute inset-0 overflow-hidden" style="width: 50%;">
                                    <flux:icon.star variant="solid" class="w-4 h-4 fill-yellow-400 text-yellow-400" />
                                </div>
                            </div>
                        @else
                            <flux:icon.star variant="solid" class="w-4 h-4 text-zinc-300" />
                        @endif
                    @endfor
                </div>
                <span class="text-sm font-medium text-zinc-600">
                    ({{ number_format($product->reviews_avg_rating, 1) }})
                </span>
                <a href="{{ route('products.reviews', $product) }}" wire:navigate
                    class="text-sm font-medium text-sheffield-blue hover:underline">
                    {{ $this->reviewStats['total'] }} Reviews
                </a>
            </div>
        </div>

        @if ($product->sku)
            <flux:text class="mt-4">
                Item no: <span class="text-zinc-800">{{ $product->sku }}</span>
            </flux:text>
        @endif

        <flux:text class="my-4">{!! $product->short_description !!}</flux:text>

        {{-- Shipping estimate --}}
        <div wire:cloak class="mb-4">
            @if ($this->selectedCounty && $this->estimatedShipping !== null)
                <div class="flex items-center gap-2">
                    <flux:icon name="truck" variant="outline" class="w-4 h-4 text-zinc-400" />
                    @if ($this->estimatedShipping > 0)
                        <flux:text>
                            Estimated shipping:
                            <span wire:loading.remove wire:target="selectedCounty, selectedArea, cartQuantity"
                                class="font-semibold text-zinc-800">
                                {{ format_currency($this->estimatedShipping) }}
                            </span>
                            <x-my-loading wire:loading wire:target="selectedCounty, selectedArea, cartQuantity"
                                class="loading-dots" />
                        </flux:text>
                    @else
                        <flux:text>
                            <span class="font-semibold text-green-600">Free shipping</span> to this location
                        </flux:text>
                    @endif
                </div>
            @elseif (!$this->selectedCounty)
                <flux:text class="text-zinc-400 text-sm">
                    Select a county to see shipping estimate.
                </flux:text>
            @endif
        </div>

        {{-- Price --}}
        <div>
            @if ($product->hasDiscount())
                <div class="flex items-center flex-wrap gap-x-2">
                    <p class="text-lg font-semibold text-sheffield-blue">{{ $product->formatted_final_price }}</p>
                    <p class="text-zinc-500 line-through">{{ $product->formatted_sale_price }}</p>
                    <flux:badge color="amber" size="sm">-{{ $product->discountPercentage() }}</flux:badge>
                </div>
            @else
                <p class="font-semibold text-lg text-sheffield-blue">{{ $product->formatted_final_price }}</p>
            @endif
        </div>

        <flux:separator class="my-5" />

        {{-- Cart Actions --}}
        <div class="flex items-center gap-2 mb-3">
            <flux:button.group>
                <flux:button icon="minus" class="cursor-pointer text-zinc-500!" title="Decrease Quantity"
                    wire:click="decreaseCartQuantity" />

                <flux:input readonly value="{{ $cartQuantity }}"
                    class="max-w-9! outline-none! border-none! ring-0 focus:outline-none! focus:border-none!"
                    style="outline: none; padding-left: 0 !important; padding-right: 0 !important; text-align: center !important;" />

                <flux:button icon="plus" class="cursor-pointer text-zinc-500!" title="Increase Quantity"
                    wire:click="increaseCartQuantity" />

                @if ($inCart)
                    <flux:button icon="trash" icon-variant="outline" class="cursor-pointer text-red-500!"
                        wire:click="removeFromCart" title="Remove from Cart" />
                @endif
            </flux:button.group>

            @if (!$inCart)
                <flux:button wire:click="addToCart" variant="primary" class="uppercase cursor-pointer">
                    Add to Cart
                </flux:button>
            @endif

            <flux:button wire:click.stop="toggleWishlist" icon="heart"
                icon-variant="{{ $wishlisted ? 'solid' : 'outline' }}" title="Wishlist" @class(['cursor-pointer', 'text-red-500!' => $wishlisted]) />

            <flux:button wire:click="toggleCompare" icon="{{ $inCompare ? 'x-mark' : 'scale' }}" icon-variant="outline"
                title="Compare" @class(['cursor-pointer', 'text-red-500!' => $inCompare]) />

            <flux:button icon="share" icon-variant="outline" title="Share" />
        </div>
    </div>

</flux:card>
