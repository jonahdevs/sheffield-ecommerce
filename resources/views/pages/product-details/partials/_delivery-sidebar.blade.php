<div class="lg:col-span-1">
    <flux:card class="sticky top-44 p-0">

        {{-- Header --}}
        <div class="border-b dark:border-zinc-700 px-4 py-3">
            <flux:heading size="sm">Delivery & returns</flux:heading>
        </div>

        {{-- Location selector --}}
        @if (!$product->is_virtual)
            <div class="px-4 py-3 border-b dark:border-zinc-700">
                <p class="text-xs font-medium text-zinc-500 mb-2">Choose your location</p>

                <flux:select class="w-full" wire:model.live.debounce.300ms="selectedCounty" placeholder="Select county...">
                    @foreach ($this->counties as $county)
                        <flux:select.option :value="$county->id">{{ $county->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select class="w-full mt-2" wire:model.live.debounce.300ms="selectedArea"
                    :placeholder="$selectedCounty ? 'Select area' : 'Select a county first'"
                    :disabled="!$selectedCounty">
                    @foreach ($this->areas as $area)
                        <flux:select.option :value="$area->id">{{ $area->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        @endif

        {{-- Shipping information --}}
        @if ($product->shipping_information)
            <div class="flex items-start gap-3 px-4 py-3 border-b dark:border-zinc-700">
                <div class="border dark:border-zinc-700 rounded-md p-1.5 shrink-0 mt-0.5">
                    <flux:icon.truck class="size-5 text-zinc-500" variant="outline" />
                </div>
                <div>
                    <p class="text-sm font-medium text-zinc-800 dark:text-zinc-100">Delivery information</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5 leading-relaxed">
                        {{ $product->shipping_information }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Return policy --}}
        {{-- Shows product-specific override, falls back to global store policy --}}
        <div class="flex items-start gap-3 px-4 py-3 border-b dark:border-zinc-700">
            <div class="border dark:border-zinc-700 rounded-md p-1.5 shrink-0 mt-0.5">
                <flux:icon.arrow-uturn-left class="size-5 text-zinc-500" variant="outline" />
            </div>
            <div>
                <p class="text-sm font-medium text-zinc-800 dark:text-zinc-100">Return policy</p>
                @if ($product->return_policy)
                    <p class="text-xs text-amber-700 dark:text-amber-400 mt-0.5 leading-relaxed">
                        {{ $product->return_policy }}
                    </p>
                @else
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5 leading-relaxed">
                        {{ config('shop.return_policy', 'Easy returns within 30 days of purchase.') }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Warranty --}}
        <div class="flex items-start gap-3 px-4 py-3">
            <div class="border dark:border-zinc-700 rounded-md p-1.5 shrink-0 mt-0.5">
                <flux:icon.shield-check class="size-5 text-zinc-500" variant="outline" />
            </div>
            <div>
                <p class="text-sm font-medium text-zinc-800 dark:text-zinc-100">Warranty</p>
                @if ($product->warranty_information)
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5 leading-relaxed">
                        {{ $product->warranty_information }}
                    </p>
                @else
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5 leading-relaxed">
                        {{ config('shop.warranty_policy', 'Covered against manufacturing defects.') }}
                    </p>
                @endif
            </div>
        </div>

    </flux:card>
</div>
