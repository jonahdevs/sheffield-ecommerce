{{-- Variation picker. Rendered inside any Livewire page that uses the
     InteractsWithStorefront trait; opened from a variable product's card or from
     the product page's Add to cart button.

     The per-row steppers edit the cart directly, so there is nothing to confirm -
     the footer just offers a way onward.

     Only rendered when there is something to show: a listing page has no variable
     product in mind until a card opens one, and a simple product never will, so
     otherwise every storefront page would carry a hidden, empty modal. --}}
@if ($showVariationModal || $this->variationRows->isNotEmpty())
    <flux:modal wire:model.self="showVariationModal" class="md:w-140">
        <flux:heading class="uppercase">Please select a variation</flux:heading>

        <div class="mt-5">
            @foreach ($this->variationRows as $row)
                <div class="flex items-center gap-3 py-3" wire:key="var-{{ $row['id'] }}">
                    @if ($row['image'])
                        <img src="{{ $row['image'] }}" alt="" class="size-12 shrink-0 object-contain" loading="lazy" />
                    @else
                        <div
                            class="grid size-12 shrink-0 place-items-center overflow-hidden rounded border border-zinc-100 bg-surface-sunken text-ink-4">
                            <flux:icon.cube variant="micro" class="size-4" />
                        </div>
                    @endif

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-baseline gap-x-2 text-sm">
                            <span class="font-semibold text-ink">{{ $row['label'] }}</span>
                            <span class="font-mono text-xs text-ink-4">{{ $row['reference'] }}</span>
                        </div>
                        <div class="mt-0.5 flex flex-wrap items-center gap-2 text-xs text-ink-3">
                            <span class="tabular-nums">{!! $row['price_cents'] ? money($row['price_cents']) : 'POA' !!}</span>
                            @if ($row['backorder'])
                                <flux:badge size="sm" color="amber" inset="top bottom">On backorder</flux:badge>
                            @elseif (!$row['in_stock'])
                                <flux:badge size="sm" color="zinc" inset="top bottom">Out of stock</flux:badge>
                            @endif
                        </div>
                        @if ($row['stock_quantity'] !== null)
                            <div class="mt-0.5 text-xs text-ink-4 tabular-nums">{{ $row['stock_quantity'] }} in stock</div>
                        @endif
                    </div>

                    @if ($row['in_stock'])
                        <div
                            class="inline-flex h-9 shrink-0 items-stretch overflow-hidden rounded border border-zinc-200">
                            <button type="button" wire:click="decVariationQty({{ $row['id'] }})"
                                aria-label="Decrease quantity of {{ $row['label'] }}" @disabled($row['qty'] === 0)
                                @class([
                                    'grid w-8 place-items-center text-ink-2 transition',
                                    'cursor-pointer hover:bg-surface-sunken' => $row['qty'] > 0,
                                    'cursor-not-allowed opacity-40' => $row['qty'] === 0,
                                ])>
                                <flux:icon.minus variant="micro" class="size-3.5" />
                            </button>
                            <div
                                class="grid w-9 place-items-center border-x border-zinc-200 text-sm font-semibold tabular-nums">
                                {{ $row['qty'] }}
                            </div>
                            <button type="button" wire:click="incVariationQty({{ $row['id'] }})"
                                aria-label="Increase quantity of {{ $row['label'] }}"
                                class="grid w-8 cursor-pointer place-items-center text-ink-2 transition hover:bg-surface-sunken">
                                <flux:icon.plus variant="micro" class="size-3.5" />
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-5 grid grid-cols-2 gap-2 border-t border-zinc-200 pt-4">
            <flux:modal.close class="block w-full">
                <flux:button class="w-full">Continue shopping</flux:button>
            </flux:modal.close>
            <flux:button variant="primary" :href="route('cart')" wire:navigate class="w-full">
                Go to cart
            </flux:button>
        </div>
    </flux:modal>
@endif
