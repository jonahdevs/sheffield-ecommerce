<?php

use App\Models\Address;
use App\Models\Cart;
use App\Services\CartService;
use App\Services\OrderSummary as OrderSummaryService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public ?int $addressId = null;
    public ?array $selectedShipping = null; // ['method_id' => int, 'rate_id' => int|null]

    protected CartService $cartService;
    protected OrderSummaryService $orderSummaryService;

    public function boot(CartService $cartService, OrderSummaryService $orderSummaryService): void
    {
        $this->cartService = $cartService;
        $this->orderSummaryService = $orderSummaryService;
    }

    public function mount(?int $addressId = null, ?array $selectedShipping = null): void
    {
        $this->addressId = $addressId;
        $this->selectedShipping = $selectedShipping;
    }

    #[Computed]
    public function cart(): Cart
    {
        return $this->cartService->getCart();
    }

    #[Computed]
    public function address(): ?Address
    {
        if (!$this->addressId) {
            return null;
        }

        return Address::with(['county', 'area', 'shippingZone'])->find($this->addressId);
    }

    #[Computed]
    public function summary(): array
    {
        return $this->orderSummaryService->getBreakdown($this->cart, $this->address, $this->selectedShipping);
    }

    #[On('address-selected')]
    public function updateAddress(int $addressId): void
    {
        $this->addressId = $addressId;

        // Reset selected shipping when address changes
        $this->selectedShipping = null;

        // Clear computed properties cache
        unset($this->address, $this->summary);
    }

    #[On('shipping-method-selected')]
    public function updateShipping(int $methodId, ?int $rateId = null): void
    {
        $this->selectedShipping = [
            'method_id' => $methodId,
            'rate_id' => $rateId,
        ];

        // Clear computed properties cache
        unset($this->summary);
    }

    #[On('cart-updated')]
    public function refreshCart(): void
    {
        // Clear all computed properties
        unset($this->cart, $this->summary);
    }
};
?>

<div class="bg-white rounded-sm border sticky top-44">
    <div class="px-3 py-2 border-b">
        <flux:heading level="3">Order Summary</flux:heading>
    </div>

    <div class="p-5">
        @if ($this->summary['success'])
            {{-- Breakdown Items --}}
            <div class="space-y-3 mb-4">
                @foreach ($this->summary['breakdown'] as $item)
                    @if ($item['type'] === 'total')
                        {{-- Total with separator --}}
                        <div class="border-t pt-3 mt-3">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-semibold text-lg">{{ $item['label'] }}</div>
                                </div>
                                <div class="font-bold text-lg">{{ $item['formatted'] }}</div>
                            </div>
                        </div>
                    @elseif($item['type'] === 'shipping' && isset($item['is_free']) && $item['is_free'] && isset($item['original_formatted']))
                        {{-- Free Shipping with crossed out original price --}}
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="font-medium">{{ $item['label'] }}</div>
                                @if ($item['sublabel'])
                                    <div class="text-sm text-gray-500">{{ $item['sublabel'] }}</div>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="text-green-600 font-medium">{{ $item['formatted'] }}</div>
                                <div class="text-sm text-gray-400 line-through">{{ $item['original_formatted'] }}</div>
                            </div>
                        </div>
                    @elseif($item['type'] === 'discount')
                        {{-- Discount (savings) --}}
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="font-medium text-green-600">{{ $item['label'] }}</div>
                                @if ($item['sublabel'])
                                    <div class="text-sm text-gray-500">{{ $item['sublabel'] }}</div>
                                @endif
                            </div>
                            <div class="text-green-600 font-medium">{{ $item['formatted'] }}</div>
                        </div>
                    @elseif(isset($item['not_calculated']) && $item['not_calculated'])
                        {{-- Shipping not yet calculated --}}
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="font-medium">{{ $item['label'] }}</div>
                                @if ($item['sublabel'])
                                    <div class="text-sm text-yellow-600">{{ $item['sublabel'] }}</div>
                                @endif
                            </div>
                            <div class="text-gray-400 font-medium">{{ $item['formatted'] }}</div>
                        </div>
                    @else
                        {{-- Regular line item --}}
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="font-medium">{{ $item['label'] }}</div>
                                @if ($item['sublabel'])
                                    <div class="text-sm text-gray-500">{{ $item['sublabel'] }}</div>
                                @endif
                            </div>
                            <div class="font-medium">{{ $item['formatted'] }}</div>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Shipping Options Info (if available and not selected) --}}
            @if ($this->summary['summary']['shipping']['available'] && !$this->selectedShipping)
                <div class="mt-4 p-3 bg-blue-50 rounded-md border border-blue-200">
                    <div class="text-sm text-blue-800">
                        <div class="font-medium mb-1">Multiple shipping options available</div>
                        <div>Select your preferred shipping method to see accurate costs</div>
                    </div>
                </div>
            @endif

            {{-- Free Shipping Achievement --}}
            @if ($this->summary['summary']['shipping']['selected_option']['free_shipping_rule'] ?? false)
                <div class="mt-4 p-3 bg-green-50 rounded-md border border-green-200">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-green-800">
                            <div class="font-medium">
                                {{ $this->summary['summary']['shipping']['selected_option']['free_shipping_rule']['name'] }}
                            </div>
                            <div>You've qualified for free shipping!</div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Weight Info (optional, can be removed if not needed) --}}
            @if (($this->summary['summary']['shipping']['total_weight'] ?? 0) > 0)
                <div class="mt-4 text-xs text-gray-500 text-center">
                    Total weight: {{ number_format($this->summary['summary']['shipping']['total_weight'], 2) }} kg
                </div>
            @endif
        @else
            {{-- Error State --}}
            <div class="p-4 bg-red-50 rounded-md border border-red-200">
                <div class="text-sm text-red-800">
                    <div class="font-medium mb-1">Unable to calculate summary</div>
                    <div>{{ $this->summary['message'] ?? 'Please try again later' }}</div>
                </div>
            </div>
        @endif

        {{-- Empty Cart State --}}
        @if ($this->cart->items->isEmpty())
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <div class="text-gray-500">Your cart is empty</div>
            </div>
        @endif
    </div>
</div>
