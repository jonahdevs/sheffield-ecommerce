<?php

use App\Models\Address;
use App\Models\Cart;
use App\Services\CartService;
use App\Services\OrderSummaryService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function summary()
    {
        return app(OrderSummaryService::class)->summary();
    }
};

?>

<div class="border bg-white rounded-sm">
    <div class="px-3 py-2 border-b">
        <flux:heading>Order Summary</flux:heading>
    </div>
    <div class="p-5">
        <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <flux:text>Subtotal</flux:text>
                <flux:heading>{{ $this->summary['subtotal'] }}</flux:heading>
            </div>

            <div class="flex items-center justify-between">
                <flux:text>Discount</flux:text>
                <flux:heading>{{ $this->summary['discount'] }}</flux:heading>
            </div>

            <div class="flex items-center justify-between">
                <flux:text>Shipping</flux:text>
                <flux:heading>{{ $this->summary['shipping_cost'] }}</flux:heading>
            </div>

            <div class="flex items-center justify-between">
                <flux:text>Total</flux:text>
                <flux:heading>{{ $this->summary['total'] }}</flux:heading>
            </div>
        </div>

    </div>
</div>
