<?php

use App\Services\{CompareService, WishlistService, CartService};
use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\QuoteBasketService;

new class extends Component {
    public int $cartCount = 0;
    public int $compareCount = 0;
    public int $wishlistCount = 0;
    public int $quoteCount = 0;

    public function mount(WishlistService $wishlist, CompareService $compareService, CartService $cartService)
    {
        $this->cartCount = (int) session('cart_count', 0);
        $this->wishlistCount = (int) session('wishlist_count', 0);
        $this->compareCount = (int) session('compare_count', 0);
        $this->quoteCount = (int) session('quote_count', 0);
    }

    #[On('cart-updated')]
    public function refreshCartCount(CartService $cartService)
    {
        $this->cartCount = $cartService->getCount();
    }

    #[On('wishlist-updated')]
    public function updateWishlistCount(WishlistService $wishlistService): void
    {
        $this->wishlistCount = $wishlistService->getCount();
    }

    #[On('compare-updated')]
    public function updateCompareCount(CompareService $compareService): void
    {
        $this->compareCount = $compareService->getCount();
    }

    #[On('quote-basket-updated')]
    public function refreshQuoteCount(): void
    {
        $this->quoteCount = app(QuoteBasketService::class)->count();
    }
};
?>

<nav class="w-full bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('images/stainless_steel.jpg') }}')">
    <section class="container mx-auto px-4 py-3 lg:py-4">
        <div class="flex items-center justify-between gap-3 sm:gap-4">

            {{-- Logo --}}
            <a href="{{ route('home') }}" wire:navigate class="flex items-center shrink-0">
                <img src="{{ asset('logo.png') }}" alt="{{ config('site.site.name') }} Logo"
                    class="h-8 sm:h-10 lg:h-12 w-auto transition-transform duration-300 hover:scale-105" />
            </a>

            {{-- Search — takes up available space on desktop, hidden on mobile --}}
            <div class="hidden lg:flex flex-1 min-w-0 px-6 xl:px-10">
                @if (!($isErrorPage ?? false))
                    <livewire:search-bar />
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2 sm:gap-3 lg:gap-5">

                {{-- Mobile: search icon --}}
                <div class="lg:hidden">
                    @if (!($isErrorPage ?? false))
                        <livewire:search-bar />
                    @endif
                </div>

                {{-- Wishlist — desktop only --}}
                <a href="{{ route('wishlist') }}" wire:navigate class="hidden lg:flex items-center gap-2 group">
                    <div class="relative">
                        <flux:icon.heart
                            class="size-5 lg:size-6 text-zinc-800 group-hover:text-primary transition-colors" />
                        @if ($wishlistCount > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-primary text-on-primary text-[10px] sm:text-xs rounded-full w-4 h-4 sm:w-5 sm:h-5 flex items-center justify-center font-medium">
                                {{ $wishlistCount }}
                            </span>
                        @endif
                    </div>
                    <span class="text-xs lg:text-sm font-medium text-zinc-800">Wishlist</span>
                </a>

                {{-- Compare — desktop only --}}
                <a href="{{ route('products.compare') }}" wire:navigate class="hidden lg:flex items-center gap-2 group">
                    <div class="relative">
                        <x-icon.compare
                            class="size-5 lg:size-6 text-zinc-800 group-hover:text-primary transition-colors" />
                        @if ($compareCount > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-primary text-on-primary text-[10px] sm:text-xs font-medium rounded-full h-4 w-4 sm:h-5 sm:w-5 flex items-center justify-center">
                                {{ $compareCount }}
                            </span>
                        @endif
                    </div>
                    <span class="text-xs lg:text-sm font-medium text-zinc-800">Compare</span>
                </a>

                {{-- Cart — always visible --}}
                <a href="{{ route('cart') }}" wire:navigate class="flex items-center gap-2 group">
                    <div class="relative">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-zinc-800 group-hover:text-primary transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if ($cartCount > 0)
                            <span
                                class="absolute -top-2 -right-2 bg-primary text-on-primary text-[10px] sm:text-xs font-medium rounded-full w-4 h-4 sm:w-5 sm:h-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </div>
                    <span class="hidden lg:inline text-xs lg:text-sm font-medium text-zinc-800">Cart</span>
                </a>

                {{-- Account Dropdown --}}
                <flux:dropdown position="bottom" align="end" hover class="ms-2">
                    @auth
                        <button type="button" class="flex items-center gap-2 cursor-pointer">
                            @if (auth()->user()->avatar)
                                <flux:avatar circle size="sm" src="{{ auth()->user()->avatar }}" />
                            @else
                                <flux:avatar circle size="sm" name="{{ auth()->user()->name }}" />
                            @endif
                            <span class="hidden md:block text-xs lg:text-sm font-medium text-zinc-800">
                                {{ auth()->user()->name }}
                            </span>
                            <svg class="hidden md:block w-4 h-4 text-zinc-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    @else
                        <button type="button" class="flex items-center gap-2 hover:text-secondary transition-colors">
                            <flux:icon.user class="w-5 h-5 sm:w-6 sm:h-6 text-zinc-800" variant="outline" />
                            <div class="hidden lg:block">
                                <div class="text-xs lg:text-sm font-medium text-zinc-800">Account</div>
                            </div>
                            <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 hidden lg:block text-zinc-600" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endauth

                    <flux:navmenu class="rounded-sm! shadow-2xl! min-w-56!">

                        @auth
                            {{-- User identity header --}}
                            <div class="px-3 py-3 border-b border-zinc-100 dark:border-zinc-700 flex items-center gap-3">
                                @if (auth()->user()->avatar)
                                    <flux:avatar circle size="sm" src="{{ auth()->user()->avatar }}" />
                                @else
                                    <flux:avatar circle size="sm" name="{{ auth()->user()->name }}" />
                                @endif
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                        {{ auth()->user()->name }}</p>
                                    <p class="text-xs text-zinc-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                            </div>

                            {{-- Auth-only links --}}
                            <flux:navmenu.item :href="route('customer.account')" wire:navigate icon="user"
                                icon-variant="outline">
                                Account
                            </flux:navmenu.item>
                            <flux:navmenu.item :href="route('customer.orders.index')" wire:navigate icon="package"
                                icon-variant="outline">
                                Orders
                            </flux:navmenu.item>
                        @else
                            {{-- Guest links --}}
                            <flux:navmenu.item href="{{ route('login') }}" wire:navigate
                                icon="arrow-left-start-on-rectangle" class="cursor-pointer">
                                Log in
                            </flux:navmenu.item>
                            <flux:navmenu.item href="{{ route('register') }}" wire:navigate icon="user-plus"
                                icon-variant="outline" class="cursor-pointer">
                                Create Account
                            </flux:navmenu.item>
                        @endauth

                        {{-- Available to all users --}}
                        <flux:navmenu.item :href="route('quote')" wire:navigate icon="document-text"
                            icon-variant="outline">
                            <span class="flex items-center gap-2 w-full">
                                Quote Basket
                                @if ($quoteCount > 0)
                                    <span
                                        class="ms-auto bg-amber-500 text-white text-xs font-medium rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ $quoteCount }}
                                    </span>
                                @endif
                            </span>
                        </flux:navmenu.item>

                        {{-- Mobile-only: Wishlist & Compare are visible on desktop app-bar --}}
                        <div class="lg:hidden">
                            <flux:navmenu.item :href="route('wishlist')" wire:navigate icon="heart"
                                icon-variant="outline">
                                <span class="flex items-center gap-2 w-full">
                                    Wishlist
                                    @if ($wishlistCount > 0)
                                        <span
                                            class="ms-auto bg-primary text-on-primary text-xs font-medium rounded-full h-5 w-5 flex items-center justify-center">
                                            {{ $wishlistCount }}
                                        </span>
                                    @endif
                                </span>
                            </flux:navmenu.item>
                            <flux:navmenu.item :href="route('products.compare')" wire:navigate>
                                <x-slot name="icon"><x-icon.compare class="size-4" /></x-slot>
                                <span class="flex items-center gap-2 w-full">
                                    Compare
                                    @if ($compareCount > 0)
                                        <span
                                            class="ms-auto bg-primary text-on-primary text-xs font-medium rounded-full h-5 w-5 flex items-center justify-center">
                                            {{ $compareCount }}
                                        </span>
                                    @endif
                                </span>
                            </flux:navmenu.item>
                        </div>

                        @auth
                            <flux:menu.separator />
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <flux:navmenu.item type="submit" icon="arrow-right-start-on-rectangle" variant="danger"
                                    class="cursor-pointer">
                                    Logout
                                </flux:navmenu.item>
                            </form>
                        @endauth

                    </flux:navmenu>
                </flux:dropdown>

            </div>
        </div>
    </section>
</nav>
