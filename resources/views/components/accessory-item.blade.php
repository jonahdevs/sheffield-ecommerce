<?php

use App\Services\CartService;
use App\Services\WishlistService;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Product;

new class extends Component {
    public Product $product;
    public int $recommendedQuantity = 1;

    public bool $wishlisted = false;
    public int $cartQuantity = 1;

    public function mount(WishlistService $wishlist): void
    {
        $this->cartQuantity = $this->recommendedQuantity;
        $this->wishlisted = $wishlist->has($this->product->id);
    }

    public function increaseQuantity(): void
    {
        $this->cartQuantity++;
    }

    public function decreaseQuantity(): void
    {
        if ($this->cartQuantity > 1) {
            $this->cartQuantity--;
        }
    }

    public function addToCart(CartService $cartService): void
    {
        try {
            $cartService->addItem($this->product->id, $this->cartQuantity);

            $this->dispatch('cart-updated');
            $this->dispatch('notify', variant: 'success', message: 'Added to cart successfully');
        } catch (\Throwable $th) {
            $this->dispatch('notify', variant: 'danger', message: $th->getMessage() ?: 'Unable to add to cart');
        }
    }

    public function toggleWishlist(WishlistService $wishlistService): void
    {
        try {
            $added = $wishlistService->toggle($this->product->id);
            $this->wishlisted = $added;

            $this->dispatch('wishlist-updated');
            $this->dispatch('notify', variant: 'success', message: $added ? 'Added to wishlist' : 'Removed from wishlist');
        } catch (\Throwable $th) {
            $this->dispatch('notify', variant: 'danger', message: $th->getMessage() ?: 'Unable to update wishlist');
        }
    }
};
?>

<div class="bg-white border border-zinc-200 rounded-lg overflow-hidden">

    {{-- Image + details row --}}
    <div class="grid grid-cols-[100px_1fr]">

        {{-- Image --}}
        <a wire:navigate href="{{ route('products.show', $product) }}" target="_blank"
            class="bg-zinc-50 aspect-square flex items-center justify-center overflow-hidden">
            @if ($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" loading="lazy" />
            @else
                <flux:icon.photo class="w-10 h-10 text-zinc-300 stroke-1" />
            @endif
        </a>

        {{-- Details --}}
        <div class="p-3 flex flex-col gap-1.5">

            {{-- Name + SKU --}}
            <div class="flex items-start justify-between gap-2">
                <a wire:navigate href="{{ route('products.show', $product) }}" target="_blank"
                    class="text-sm font-medium text-zinc-800 leading-snug line-clamp-2 hover:text-brand-secondary transition-colors">
                    {{ $product->name }}
                </a>
                <span
                    class="text-[11px] text-zinc-500 bg-zinc-100 border border-zinc-200 rounded px-1.5 py-0.5 whitespace-nowrap shrink-0">
                    {{ $product->sku }}
                </span>
            </div>

            {{-- Price --}}
            <div class="flex items-baseline gap-2">
                <span class="text-base font-semibold text-brand-secondary">
                    {{ $product->formatted_final_price }}
                </span>
                @if ($product->hasDiscount())
                    <span class="text-xs text-zinc-400 line-through">
                        {{ $product->formatted_price }}
                    </span>
                @endif
            </div>

            {{-- Recommended qty badge — only shown when qty > 1 --}}
            @if ($recommendedQuantity > 1)
                <div
                    class="inline-flex items-center gap-1 bg-amber-50 border border-amber-200 rounded px-2 py-0.5 w-fit">
                    <flux:icon.information-circle class="w-3 h-3 text-amber-700 shrink-0" />
                    <span class="text-[11px] text-amber-800 font-medium">
                        Recommended qty: {{ $recommendedQuantity }} for this product
                    </span>
                </div>
            @endif

        </div>
    </div>

    {{-- Actions bar --}}
    <div class="border-t border-zinc-200 px-3 py-2 flex items-center gap-2">

        {{-- Qty stepper --}}
        <div class="flex items-center border border-zinc-300 rounded-md overflow-hidden">
            <button wire:click="decreaseQuantity"
                class="w-7.5 h-7.5 flex items-center justify-center text-zinc-500 hover:bg-zinc-100 transition-colors text-base leading-none cursor-pointer"
                aria-label="Decrease quantity">−</button>

            <span class="w-8 text-center text-sm font-medium text-zinc-800">
                {{ $cartQuantity }}
            </span>

            <button wire:click="increaseQuantity"
                class="w-7.5 h-7.5 flex items-center justify-center text-zinc-500 hover:bg-zinc-100 transition-colors text-base leading-none cursor-pointer"
                aria-label="Increase quantity">+</button>
        </div>

        {{-- Add to cart --}}
        <button wire:click="addToCart" wire:loading.attr="disabled" wire:target="addToCart"
            class="flex-1 h-7.5 bg-brand-secondary hover:bg-brand-secondary/90 text-white text-xs font-medium rounded-md flex items-center justify-center gap-1.5 transition-colors disabled:opacity-60 cursor-pointer">
            <flux:icon.shopping-cart class="w-3.5 h-3.5" wire:loading.remove wire:target="addToCart" />
            <flux:icon.loading class="w-3.5 h-3.5" wire:loading wire:target="addToCart" />
            <span wire:loading.remove wire:target="addToCart">Add to cart</span>
            <span wire:loading wire:target="addToCart">Adding...</span>
        </button>

        {{-- Quick view / go to product --}}
        <a wire:navigate href="{{ route('products.show', $product) }}" target="_blank"
            class="w-7.5 h-7.5 flex items-center justify-center border border-zinc-300 rounded-md hover:bg-zinc-100 transition-colors"
            title="View product">
            <flux:icon.arrow-top-right-on-square class="w-3.5 h-3.5 text-zinc-500" />
        </a>

        {{-- Wishlist --}}
        <button wire:click.stop="toggleWishlist" title="{{ $wishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}"
            @class([
                'w-[30px] h-7.5 flex items-center justify-center border rounded-md transition-colors cursor-pointer',
                'border-red-400 hover:bg-red-50' => $wishlisted,
                'border-zinc-300 hover:bg-zinc-100' => !$wishlisted,
            ])>
            @if ($wishlisted)
                <flux:icon.heart class="w-3.5 h-3.5 text-red-500" variant="solid" />
            @else
                <flux:icon.heart class="w-3.5 h-3.5 text-zinc-500" />
            @endif
        </button>

    </div>
</div>
