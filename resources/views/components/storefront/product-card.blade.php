@props(['product', 'badge' => null])

@php
    $brandName = $product->brand?->name;
    $tax = app(\App\Support\TaxCalculator::class);
    $price = $product->sale_price ?? $product->price;
    $compareAt = $product->sale_price ? $product->price : null;
    $price = $price !== null ? $tax->displayPriceCents($product, (int) $price) : null;
    $compareAt = $compareAt !== null ? $tax->displayPriceCents($product, (int) $compareAt) : null;
    $priceLabel = $price ? money($price) : 'Request quote';
    $compareLabel = $compareAt ? money($compareAt) : null;
    $isWished = \App\Support\StorefrontSession::isWishlisted($product->slug);
    $isCompared = \App\Support\StorefrontSession::isCompared($product->slug);
    $cartQty = \App\Support\StorefrontSession::cartQuantity($product->slug);
    $discount = $compareAt && $price && $compareAt > $price ? (int) round((1 - $price / $compareAt) * 100) : null;

    // A variable product is priced by its variants, not the parent row: show the
    // span across them so the card doesn't imply a single price, and drop the
    // sale/discount treatment which is meaningless against a range. Mirrors the PDP.
    $isPriceRange = false;
    if ($product->type === \App\Enums\ProductType::VARIABLE) {
        $variantPrices = $product->variants
            ->map(fn($variant) => $variant->compare_at_price ?? $variant->price)
            ->filter()
            ->map(fn($cents) => $tax->displayPriceCents($product, (int) $cents));

        if ($variantPrices->isNotEmpty()) {
            $min = (int) $variantPrices->min();
            $max = (int) $variantPrices->max();
            $isPriceRange = $min !== $max;
            $priceLabel = $isPriceRange ? money($min) . ' – ' . money($max) : money($min);
            $compareLabel = null;
            $discount = null;
        }
    }
    // Variable products pick a variant in a modal opened from the card itself.
    $isVariable = $product->type === \App\Enums\ProductType::VARIABLE;
    // Grouped products still need the product page: their children are configured
    // there, not chosen from a variant list.
    $needsOptions = $product->type === \App\Enums\ProductType::GROUPED;
    // Quote-only and unpriced products can't be quick-added (there's no price to
    // charge); they route to the product page where the quote flow lives.
    $isQuoteOnly = $product->requires_quotation || ($product->sale_price ?? $product->price) === null;
@endphp

<article
    {{ $attributes->merge(['class' => 'group flex flex-col overflow-hidden rounded border border-zinc-200 bg-white transition hover:shadow-md']) }}>

    {{-- Image area --}}
    <div class="relative aspect-square w-full overflow-hidden bg-white">

        {{-- Clickable image link fills the entire area --}}
        <a href="{{ route('product.show', $product) }}" wire:navigate class="absolute inset-0">
            @if ($product->cover_url)
                @if ($placeholder = $product->cover_placeholder)
                    <img src="{{ $placeholder }}" alt="" aria-hidden="true"
                        class="absolute inset-0 size-full scale-110 object-contain blur-xl" />
                @endif
                <picture class="contents">
                    @if ($product->cover_webp_url)
                        <source srcset="{{ $product->cover_webp_url }}" type="image/webp" />
                    @endif
                    <img src="{{ $product->cover_url }}" alt="{{ $product->name }}" loading="lazy"
                        x-data="{ loaded: false }" x-init="loaded = $el.complete" x-on:load="loaded = true"
                        x-bind:class="loaded ? 'opacity-100' : 'opacity-0'"
                        @class([
                            'relative size-full object-contain object-center transition duration-500',
                            'group-hover:opacity-0' => $product->secondary_url,
                        ]) />
                </picture>

                {{-- Second gallery image, crossfaded in on hover as a quick alternate-angle preview --}}
                @if ($product->secondary_url)
                    <picture class="contents">
                        @if ($product->secondary_webp_url)
                            <source srcset="{{ $product->secondary_webp_url }}" type="image/webp" />
                        @endif
                        <img src="{{ $product->secondary_url }}" alt="" aria-hidden="true" loading="lazy"
                            class="absolute inset-0 size-full object-contain object-center opacity-0 transition duration-500 group-hover:opacity-100" />
                    </picture>
                @endif
            @else
                <div class="flex size-full items-center justify-center text-ink-4">
                    <flux:icon.photo class="size-12" />
                </div>
            @endif
        </a>

        {{-- Discount badge --}}
        @if ($discount)
            <span
                class="absolute top-2.5 left-0 z-10 inline-flex h-5 items-center rounded-r bg-brand-500 px-2 text-xs font-bold tracking-wider text-white">
                −{{ $discount }}%
            </span>
        @endif

        {{-- Optional caller badge (e.g. required-accessory quantity) - sits below the discount badge if both show --}}
        @if ($badge)
            <span @class([
                'absolute left-0 z-10 inline-flex h-5 items-center rounded-r bg-rose-500 px-2 text-xs font-bold tracking-wide text-white',
                'top-9' => $discount,
                'top-2.5' => !$discount,
            ])>
                {{ $badge }}
            </span>
        @endif

        {{-- Wishlist + compare - top right, hover-reveal --}}
        {{-- Alpine holds each button's state locally so the colour flips instantly,
             even inside a wire:ignore carousel where Livewire can't re-render the card.
             It seeds from the server value and re-syncs from the slug-tagged events. --}}
        <div class="absolute top-2.5 right-2.5 z-10 flex flex-col gap-1.5 opacity-0 transition group-hover:opacity-100 group-focus-within:opacity-100">
            <flux:tooltip :content="$isWished ? 'Remove from wishlist' : 'Save to wishlist'" position="left">
                <button type="button" wire:click="toggleWishlist('{{ $product->slug }}')"
                    x-data="{ wished: @js($isWished) }"
                    @wishlist-updated.window="if ($event.detail?.slug === '{{ $product->slug }}') wished = $event.detail.wished"
                    @click="wished = !wished"
                    :aria-label="wished ? 'Remove from wishlist' : 'Save to wishlist'"
                    class="inline-flex size-8 cursor-pointer items-center justify-center rounded-full border shadow-sm transition"
                    :class="wished
                        ? 'border-brand-500 bg-brand-500 text-white'
                        : 'border-zinc-200 bg-white/95 text-ink hover:bg-white'">
                    <flux:icon.heart variant="micro" class="size-4" />
                </button>
            </flux:tooltip>

            <flux:tooltip :content="$isCompared ? 'Remove from compare' : 'Add to compare'" position="left">
                <button type="button" wire:click="toggleCompare('{{ $product->slug }}')"
                    x-data="{ compared: @js($isCompared) }"
                    @compare-updated.window="if ($event.detail?.slug === '{{ $product->slug }}') compared = $event.detail.compared"
                    @click="compared = !compared"
                    :aria-label="compared ? 'Remove from compare' : 'Add to compare'"
                    class="inline-flex size-8 cursor-pointer items-center justify-center rounded-full border shadow-sm transition"
                    :class="compared
                        ? 'border-brand-blue-500 bg-brand-blue-500 text-white'
                        : 'border-zinc-200 bg-white/95 text-ink hover:bg-white'">
                    <flux:icon.scale variant="micro" class="size-4" />
                </button>
            </flux:tooltip>
        </div>

        {{-- Variable: same round cart button as a simple product, but it opens the
             variation picker instead of adding the parent, which has no price. --}}
        @if ($isVariable)
            <button type="button" wire:click="openVariationModal('{{ $product->slug }}')"
                aria-label="Choose a variation of {{ $product->name }}"
                class="absolute right-2.5 bottom-2.5 z-10 inline-flex size-9 cursor-pointer items-center justify-center rounded-full bg-brand-500 text-white shadow-md transition hover:bg-brand-600">
                <flux:icon.shopping-cart variant="micro" class="size-3.5" />
            </button>
            {{-- Grouped: route to the product page to configure the set --}}
        @elseif ($needsOptions)
            <a href="{{ route('product.show', $product) }}" wire:navigate aria-label="Select options"
                class="absolute right-2.5 bottom-2.5 z-10 inline-flex h-9 items-center gap-1.5 rounded-full bg-brand-500 px-3.5 text-xs font-semibold text-white shadow-md transition hover:bg-brand-600">
                <flux:icon.adjustments-horizontal variant="micro" class="size-3.5" />
                Options
            </a>
            {{-- Quote-only / unpriced: no quick-add - route to the product page --}}
        @elseif ($isQuoteOnly)
            <a href="{{ route('product.show', $product) }}" wire:navigate aria-label="Request a quote"
                class="absolute right-2.5 bottom-2.5 z-10 inline-flex h-9 items-center gap-1.5 rounded-full bg-brand-500 px-3.5 text-xs font-semibold text-white shadow-md transition hover:bg-brand-600">
                <flux:icon.document-text variant="micro" class="size-3.5" />
                Quote
            </a>
        @else
            {{-- Add to cart stepper - single expanding pill, no element swapping --}}
            <div wire:key="cart-{{ $product->slug }}" x-data="{
                qty: 0,
                expanded: false,
                _timer: null,
                init() {
                    this.qty = Number(this.$el.dataset.qty);
                    this.$watch('qty', v => { if (v > 0) this.expand(); });
                },
                expand() {
                    this.expanded = true;
                    clearTimeout(this._timer);
                    this._timer = setTimeout(() => this.expanded = false, 3000);
                },
                addOne() {
                    if (!this.expanded && this.qty > 0) { this.expand(); return; }
                    this.qty++;
                    this.$wire.addToCart('{{ $product->slug }}');
                    this.expand();
                },
                removeOne() {
                    this.qty > 1 ? this.qty-- : this.qty = 0;
                    this.$wire.decrementCart('{{ $product->slug }}');
                    if (this.qty > 0) this.expand();
                }
            }" data-qty="{{ $cartQty }}"
                @cart-qty-changed.window="if ($event.detail.slug === '{{ $product->slug }}') qty = $event.detail.qty"
                class="absolute right-2.5 bottom-2.5 z-10">

                {{-- Badge visible when collapsed + in cart --}}
                <span x-show="qty > 0 && !expanded" x-cloak x-text="qty"
                    class="absolute -top-1 -right-1 z-10 flex size-4 items-center justify-center rounded-full bg-white text-xs font-bold text-brand-500 shadow-sm">
                </span>

                {{-- Single pill - right edge is fixed, expands leftward --}}
                <div class="relative h-9 overflow-hidden rounded-full bg-brand-500 text-white shadow-md transition-[width] duration-200"
                    :class="expanded ? 'w-25' : 'w-9'">

                    {{-- Left zone: decrement + count - hidden until pill expands --}}
                    <div class="absolute inset-y-0 left-0 right-9 flex items-center transition-opacity duration-150"
                        :class="expanded ? 'opacity-100' : 'opacity-0 pointer-events-none'">
                        <button type="button" aria-label="Remove one" @click="removeOne()"
                            class="flex size-9 shrink-0 cursor-pointer items-center justify-center transition hover:bg-brand-600">
                            <flux:icon.trash-2 variant="micro" class="size-3.5" x-show="qty <= 1" />
                            <flux:icon.minus variant="micro" class="size-3.5" x-show="qty > 1" x-cloak />
                        </button>
                        <span x-text="qty" class="flex-1 text-center text-sm font-bold tabular-nums"></span>
                    </div>

                    {{-- Right zone: cart icon or plus - always pinned to right edge --}}
                    <button type="button" aria-label="Add to cart" @click="addOne()"
                        class="absolute right-0 flex size-9 cursor-pointer items-center justify-center rounded-full transition hover:bg-brand-600">
                        <flux:icon.shopping-cart variant="micro" class="size-3.5" x-show="!expanded" />
                        <flux:icon.plus variant="micro" class="size-3.5" x-show="expanded" x-cloak />
                    </button>
                </div>
            </div>
        @endif
    </div>

    {{-- Info - only the product name links out; brand and price are plain text --}}
    <div class="flex flex-1 flex-col px-3 py-3 sm:px-4 sm:py-3.5">
        @if ($brandName)
            <div class="text-xs font-bold tracking-widest text-brand-blue-600 uppercase">{{ $brandName }}
            </div>
        @endif
        <a href="{{ route('product.show', $product) }}" wire:navigate
            class="mt-1 line-clamp-2 min-h-9.5 text-sm font-medium leading-snug text-ink hover:text-brand-600">
            {{ $product->name }}
        </a>

        <div class="mt-3">
            @if ($compareLabel)
                <div class="text-xs text-ink-4 line-through">{!! $compareLabel !!}</div>
            @endif
            {{-- A range is roughly twice as wide as a single figure, so it wraps
                 rather than overflowing the card. --}}
            <div @class([
                'font-bold text-ink tabular-nums',
                'text-base whitespace-nowrap' => !$isPriceRange,
                'text-sm leading-snug' => $isPriceRange,
            ])>{!! $priceLabel !!}</div>
        </div>
    </div>

</article>
