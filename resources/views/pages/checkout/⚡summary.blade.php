<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Services\CartService;

new #[Layout('layouts.guest')] class extends Component {
    public function mount()
    {
        $user = auth()->user();
        $cartService = app(CartService::class);

        if (!$cartService->getCart()->items()->exists()) {
            $this->redirectRoute('cart');
        }

        // If no address exists → go to create address
        if ($user->defaultAddress()->doesntExist()) {
            return redirect()->route('checkout.addresses.create');
        }

        // If address exists but no shipping method selected → go to shipping options
        // if (!$user->defaultAddress->hasSelectedShippingMethod()) {
        //     return redirect()->route('checkout.shipping-options');
        // }
    }

    #[Computed]
    public function defaultAddress()
    {
        return auth()->user()->defaultAddress;
    }

    #[Computed]
    public function selectedShippingMethod()
    {
        return $this->defaultAddress?->selectedShippingMethod;
    }

    #[Computed]
    public function selectedShippingRate()
    {
        return $this->defaultAddress?->selectedShippingRate;
    }

    public function changeShippingMethod()
    {
        return redirect()->route('checkout.shipping-options');
    }
};
?>

<div>
    {{-- Breadcrumb --}}
    <div class="bg-zinc-100">
        <flux:breadcrumbs class="container mx-auto py-4 px-4">
            <flux:breadcrumbs.item href="{{ route('home') }}" wire:navigate>
                <flux:icon.home class="w-4 h-4 me-1.5 inline-block" />
                Home
            </flux:breadcrumbs.item>

            <flux:breadcrumbs.item>Checkout</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="mx-auto container px-4 py-4 min-h-[80svh]">
        <!-- Checkout Summary Header -->
        <flux:heading level="1" class="text-2xl! font-bold!">Checkout Summary</flux:heading>

        <div class="mt-4 grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-3 space-y-4">
                <!-- Customer Address Section -->
                <div class="border rounded-sm bg-white">
                    <div class="px-4 py-2 border-b flex items-center justify-between">
                        <div class="flex items-center gap-1">
                            <flux:icon.check-circle variant="solid" @class([
                                'size-5',
                                'text-green-500' => $this->defaultAddress,
                                'text-zinc-500' => !$this->defaultAddress,
                            ]) />
                            <flux:heading level="3" class="font-medium!">Delivery Address</flux:heading>
                        </div>

                        <flux:link :href="route('checkout.addresses')" wire:navigate icon:trailing="chevron-right"
                            class="text-sm! group">Change
                            <flux:icon.chevron-right
                                class="size-4 ms-1 inline-block transition-transform group-hover:translate-x-2" />
                        </flux:link>
                    </div>

                    <div class="px-4 py-5">
                        @if (isset($this->defaultAddress))
                            <flux:heading>{{ $this->defaultAddress->full_name }}
                            </flux:heading>

                            <div class="text-zinc-500 text-sm mt-3 space-y-1">
                                <flux:text>{{ $this->defaultAddress->address }}</flux:text>

                                <flux:text>
                                    {{ implode(
                                        ' | ',
                                        array_filter([
                                            $this->defaultAddress->area?->name . ', ' . $this->defaultAddress->county->name,
                                            $this->defaultAddress->phone_number,
                                        ]),
                                    ) }}
                                </flux:text>
                            </div>
                        @else
                            <p>You have not set a default address</p>
                        @endif
                    </div>
                </div>

                <!-- Delivery Method Section -->
                <div class="bg-white rounded-sm border">
                    <div class="px-4 py-2 border-b flex items-center justify-between">
                        <flux:heading level="3" class="font-medium!">Delivery Details</flux:heading>

                        <flux:link :href="route('checkout.shipping-options')" wire:navigate
                            icon:trailing="chevron-right" class="text-sm! group">Change
                            <flux:icon.chevron-right
                                class="size-4 inline-block ms-1 group-hover:translate-x-2 transition-transform" />
                        </flux:link>
                    </div>

                    <div class="px-4 py-5">
                        @if ($this->selectedShippingMethod && $this->selectedShippingRate)
                            <div class="flex items-start gap-4">
                                <!-- Method Icon -->
                                @if ($this->selectedShippingMethod->icon)
                                    <div class="shrink-0">
                                        <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                                            <flux:icon :name="$this->selectedShippingMethod->icon"
                                                class="size-6 text-sheffield-blue" />
                                        </div>
                                    </div>
                                @endif

                                <!-- Method Details -->
                                <div class="flex-1">
                                    <flux:text class="font-semibold text-lg mb-1">
                                        {{ $this->selectedShippingMethod->name }}
                                    </flux:text>

                                    @if ($this->selectedShippingMethod->description)
                                        <flux:text class="text-zinc-600 text-sm mb-2">
                                            {{ $this->selectedShippingMethod->description }}
                                        </flux:text>
                                    @endif

                                    <div class="flex items-center gap-4 mt-2">
                                        <!-- Delivery Time -->
                                        @if ($this->selectedShippingRate->estimated_delivery)
                                            <div class="flex items-center gap-1 text-sm text-zinc-600">
                                                <flux:icon.clock class="size-4" />
                                                <span>{{ $this->selectedShippingRate->estimated_delivery }}</span>
                                            </div>
                                        @endif

                                        <!-- Weight Range -->
                                        <div class="flex items-center gap-1 text-sm text-zinc-600">
                                            <flux:icon.cube class="size-4" />
                                            <span>{{ $this->selectedShippingRate->min_weight }}-{{ $this->selectedShippingRate->max_weight }}
                                                KG</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="shrink-0 text-right">
                                    <flux:text class="text-sm text-zinc-600 mb-1">Shipping Cost</flux:text>
                                    <flux:text class="text-xl font-bold text-sheffield-blue">
                                        KES {{ number_format($this->selectedShippingRate->price, 2) }}
                                    </flux:text>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <flux:text class="text-zinc-600">No shipping method selected</flux:text>
                                <flux:button size="sm" wire:click="changeShippingMethod" class="mt-3">
                                    Select Shipping Method
                                </flux:button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->

            <div class="col-span-1">
                <livewire:order-summary />
            </div>
        </div>
    </div>
</div>
