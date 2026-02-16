<?php

use Livewire\Component;
use Livewire\Attributes\{Layout, Computed};
use App\Models\User;

new #[Layout('layouts.customer')] class extends Component {
    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    #[Computed]
    public function favoriteProductsCount()
    {
        return $this->user->wishlistProducts()->count();
    }

    #[Computed]
    public function totalOrders()
    {
        return $this->user->orders()->count();
    }

    #[Computed]
    public function totalReviews()
    {
        return $this->user->reviews()->count();
    }

    #[Computed]
    public function productReturns()
    {
        return $this->user->orders()->where('status', 'returned')->count();
    }
};
?>

<div class="space-y-5">
    <flux:card class="grid grid-cols-2 md:grid-cols-4 gap-6">
        {{-- Favorite Products --}}
        <div class="flex items-center gap-4 group">
            <div
                class="shrink-0 p-3 rounded-xl bg-rose-100 text-rose-600 
                    group-hover:scale-105 transition">
                <flux:icon.heart class="w-5 h-5" />
            </div>
            <div>
                <flux:text class="text-zinc-500" size="sm">Favorite Products</flux:text>
                <flux:heading class="text-xl font-semibold">
                    {{ $this->favoriteProductsCount }}
                </flux:heading>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="flex items-center gap-4 group">
            <div
                class="shrink-0 p-3 rounded-xl bg-blue-100 text-blue-600 
                    group-hover:scale-105 transition">
                <flux:icon.package class="w-5 h-5" />
            </div>
            <div>
                <flux:text class="text-zinc-500" size="sm">Total Orders</flux:text>
                <flux:heading class="text-xl font-semibold">
                    {{ $this->totalOrders }}
                </flux:heading>
            </div>
        </div>

        {{-- Total Reviews --}}
        <div class="flex items-center gap-4 group">
            <div
                class="shrink-0 p-3 rounded-xl bg-amber-100 text-amber-600 
                    group-hover:scale-105 transition">
                <flux:icon.star class="w-5 h-5" />
            </div>
            <div>
                <flux:text class="text-zinc-500" size="sm">Total Reviews</flux:text>
                <flux:heading class="text-xl font-semibold">
                    {{ $this->totalReviews }}
                </flux:heading>
            </div>
        </div>

        {{-- Product Returns --}}
        <div class="flex items-center gap-4 group">
            <div
                class="shrink-0 p-3 rounded-xl bg-zinc-100 text-zinc-600 
                    group-hover:scale-105 transition">
                <flux:icon.arrow-path-rounded-square class="w-5 h-5" />
            </div>
            <div>
                <flux:text class="text-zinc-500" size="sm">Product Returns</flux:text>
                <flux:heading class="text-xl font-semibold">
                    {{ $this->productReturns }}
                </flux:heading>
            </div>
        </div>

    </flux:card>

    <flux:card class="p-0">
        <div class="border-b px-3 py-2">
            <flux:heading>Account Overview</flux:heading>
        </div>
        <div class="p-5 grid grid-cols-2 gap-5">
            <div class="border rounded-md">
                <div class="px-4 py-2 border-b">
                    <h3 class="font-medium text-sm text-zinc-600">Account Details</h3>
                </div>
                <div class="p-4 text-sm space-y-1">
                    <p>{{ $this->user->name }}</p>
                    <p>{{ $this->user->email }}</p>
                    <p>{{ $this->user->phone_number }}</p>
                </div>
            </div>

            <div class="border rounded-md">
                <div class="px-4 py-2 border-b flex justify-between items-center">
                    <h3 class="font-medium text-sm text-zinc-600">Address Book</h3>

                    <flux:button icon="pencil" size="xs" class="cursor-pointer" href="#">
                    </flux:button>
                </div>
                <div class="p-4 text-sm space-y-1">
                    @if ($user->defaultAddress)
                        <p class="text-zinc-800">Default Shipping Address</p>

                        <div class="text-zinc-500 text-sm mt-2">
                            <p>{{ $this->user->defaultAddress->first_name . ' ' . $this->user->defaultAddress->last_name }}
                            </p>

                            <p>{{ $this->user->defaultAddress->address }}</p>

                            <p>{{ $this->user->defaultAddress->city . ', ' . $this->user->defaultAddress->region }}</p>
                            <p>{{ implode(' / ', array_filter([$this->user->defaultAddress->phone, $this->user->defaultAddress->additional_phone])) }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="border rounded-md">
                <div class="px-4 py-2 border-b">
                    <h3 class="font-medium text-sm text-zinc-600">Newsletter preference</h3>
                </div>

                <div class="p-4 text-sm ">
                    <p class="mb-3">Manage your email communications to stay updated with the latest news and offers.
                    </p>

                    <a href="#" wire:navigate class="text-sheffield-blue hover:underline">Edit newsletter
                        preference</a>
                </div>
            </div>
        </div>
    </flux:card>
</div>
