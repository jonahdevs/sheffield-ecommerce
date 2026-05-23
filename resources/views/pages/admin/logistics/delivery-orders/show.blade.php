<?php

use App\Enums\DeliveryOrderStatus;
use App\Models\DeliveryOrder;
use App\Models\LogisticsProvider;
use App\Settings\RegionalSettings;
use Illuminate\Support\Collection;
use Livewire\Attributes\{Computed, Title};
use Livewire\Component;

new #[Title('Delivery Order')] class extends Component {
    public DeliveryOrder $deliveryOrder;

    public string $newStatus = '';
    public string $statusNote = '';
    public bool $confirmingStatus = false;

    public ?int $selectedProviderId = null;

    public function mount(DeliveryOrder $deliveryOrder): void
    {
        $this->deliveryOrder = $deliveryOrder->load([
            'order.user',
            'order.items',
            'shippingMethod',
            'shippingZone',
            'logisticsProvider',
            'pickupStation',
            'shippingRate',
            'vehicleRate',
        ]);

        $this->selectedProviderId = $this->deliveryOrder->logistics_provider_id;
    }

    // =========================================================================
    //  COMPUTED
    // =========================================================================

    #[Computed]
    public function allowedTransitions(): array
    {
        return match ($this->deliveryOrder->status) {
            DeliveryOrderStatus::PENDING          => [DeliveryOrderStatus::PICKED_UP, DeliveryOrderStatus::CANCELLED],
            DeliveryOrderStatus::PICKED_UP        => [DeliveryOrderStatus::IN_TRANSIT],
            DeliveryOrderStatus::IN_TRANSIT       => [DeliveryOrderStatus::OUT_FOR_DELIVERY, DeliveryOrderStatus::AT_STATION],
            DeliveryOrderStatus::OUT_FOR_DELIVERY => [DeliveryOrderStatus::DELIVERED, DeliveryOrderStatus::FAILED],
            DeliveryOrderStatus::FAILED           => [DeliveryOrderStatus::RETURNING, DeliveryOrderStatus::OUT_FOR_DELIVERY],
            DeliveryOrderStatus::AT_STATION       => [DeliveryOrderStatus::COLLECTED, DeliveryOrderStatus::RETURNING],
            DeliveryOrderStatus::RETURNING        => [DeliveryOrderStatus::RETURNED],
            default                               => [],
        };
    }

    #[Computed]
    public function activeProviders(): Collection
    {
        return LogisticsProvider::active()->orderBy('name')->get(['id', 'name']);
    }

    // =========================================================================
    //  STATUS
    // =========================================================================

    public function prepareStatusUpdate(string $status): void
    {
        $this->newStatus = $status;
        $this->confirmingStatus = true;
    }

    public function cancelStatusUpdate(): void
    {
        $this->newStatus = '';
        $this->statusNote = '';
        $this->confirmingStatus = false;
    }

    public function applyStatusUpdate(): void
    {
        if (! $this->newStatus) {
            return;
        }

        try {
            $updates = ['status' => $this->newStatus];

            if ($this->newStatus === DeliveryOrderStatus::DELIVERED->value) {
                $updates['delivered_at'] = now();
            }

            if ($this->newStatus === DeliveryOrderStatus::COLLECTED->value) {
                $updates['delivered_at'] ??= now();
            }

            $this->deliveryOrder->update($updates);
            $this->deliveryOrder->refresh();

            $this->confirmingStatus = false;
            $this->statusNote = '';
            $this->newStatus = '';
            unset($this->allowedTransitions);

            $this->dispatch('notify', title: 'Status Updated', variant: 'success', message: 'Delivery order status updated.');
        } catch (\Throwable $e) {
            logger()->error('Failed to update delivery order status.', [
                'exception' => $e->getMessage(),
                'id'        => $this->deliveryOrder->id,
            ]);
            $this->dispatch('notify', title: 'Update Failed', variant: 'danger', message: 'Could not update status. Please try again.');
        }
    }

    // =========================================================================
    //  PROVIDER
    // =========================================================================

    public function assignProvider(): void
    {
        $this->validate([
            'selectedProviderId' => ['nullable', 'exists:logistics_providers,id'],
        ]);

        try {
            $this->deliveryOrder->update(['logistics_provider_id' => $this->selectedProviderId]);
            $this->deliveryOrder->refresh()->load('logisticsProvider');

            $this->dispatch('notify', title: 'Provider Assigned', variant: 'success', message: 'Logistics provider updated.');
        } catch (\Throwable $e) {
            $this->dispatch('notify', title: 'Failed', variant: 'danger', message: 'Could not assign provider. Please try again.');
        }
    }
};
?>

<div>

    {{-- ================================================================== --}}
    {{-- PAGE HEADER                                                         --}}
    {{-- ================================================================== --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            @push('breadcrumbs')
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item :href="route('admin.logistics.overview')" wire:navigate>
                        Logistics
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item>{{ $deliveryOrder->order?->reference ?? 'DO-' . $deliveryOrder->id }}</flux:breadcrumbs.item>
                </flux:breadcrumbs>
            @endpush

            <div class="flex items-center gap-3 flex-wrap">
                <flux:heading size="xl" class="font-bold! tracking-tight">
                    {{ $deliveryOrder->order?->reference ?? 'DO-' . $deliveryOrder->id }}
                </flux:heading>
                <flux:badge :color="$deliveryOrder->status->color()" variant="solid" size="sm"
                    class="uppercase text-[10px] tracking-widest font-bold">
                    {{ $deliveryOrder->status->label() }}
                </flux:badge>
                @if ($deliveryOrder->is_return)
                    <flux:badge color="orange" variant="outline" size="sm">Return</flux:badge>
                @endif
                @if ($deliveryOrder->pickupStation)
                    <flux:badge color="blue" variant="outline" size="sm">Pickup Station</flux:badge>
                @endif
            </div>

            <flux:text class="mt-1 flex items-center gap-2">
                <flux:icon name="calendar" class="size-4 text-zinc-400" />
                Created {{ $deliveryOrder->created_at->format('M d, Y') }} at {{ $deliveryOrder->created_at->format('g:i A') }}
                @if ($deliveryOrder->delivered_at)
                    &nbsp;·&nbsp;
                    <flux:icon name="check-circle" class="size-4 text-green-500" />
                    Delivered {{ $deliveryOrder->delivered_at->format('M d, Y') }}
                @endif
            </flux:text>
        </div>

        {{-- Header actions: status transitions --}}
        @if (! $deliveryOrder->isTerminal() && count($this->allowedTransitions))
            <div class="flex items-center gap-2 flex-wrap">
                @foreach ($this->allowedTransitions as $transition)
                    <flux:button
                        variant="{{ in_array($transition, [DeliveryOrderStatus::CANCELLED, DeliveryOrderStatus::FAILED, DeliveryOrderStatus::RETURNING]) ? 'ghost' : 'outline' }}"
                        size="sm"
                        class="{{ in_array($transition, [DeliveryOrderStatus::CANCELLED, DeliveryOrderStatus::FAILED, DeliveryOrderStatus::RETURNING]) ? 'text-red-500!' : '' }} cursor-pointer"
                        wire:click="prepareStatusUpdate('{{ $transition->value }}')">
                        {{ $transition->label() }}
                    </flux:button>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ================================================================== --}}
    {{-- CONFIRM STATUS MODAL                                                --}}
    {{-- ================================================================== --}}
    @if ($confirmingStatus && $newStatus)
        @php $targetStatus = DeliveryOrderStatus::from($newStatus); @endphp
        <flux:callout icon="exclamation-triangle" color="amber" class="mb-5">
            <flux:callout.heading>
                Confirm: Mark as {{ $targetStatus->label() }}?
            </flux:callout.heading>
            <flux:callout.text>
                <div class="mt-2 space-y-3">
                    <flux:textarea wire:model="statusNote" placeholder="Optional internal note..." rows="2" />
                    <div class="flex gap-2">
                        <flux:button variant="ghost" size="sm" wire:click="cancelStatusUpdate" class="cursor-pointer">
                            Cancel
                        </flux:button>
                        <flux:button variant="primary" size="sm" wire:click="applyStatusUpdate" class="cursor-pointer">
                            Confirm
                        </flux:button>
                    </div>
                </div>
            </flux:callout.text>
        </flux:callout>
    @endif

    {{-- ================================================================== --}}
    {{-- MAIN LAYOUT                                                         --}}
    {{-- ================================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">

        {{-- ── Left: Main content (3 cols) ── --}}
        <div class="lg:col-span-3 space-y-5">

            {{-- ============================================================ --}}
            {{-- DELIVERY DETAILS                                              --}}
            {{-- ============================================================ --}}
            <flux:card class="p-0">
                <div class="px-6 py-3 border-b border-zinc-200 dark:border-zinc-600">
                    <flux:heading level="3" class="font-semibold">Delivery Details</flux:heading>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-8 gap-y-5 text-sm">
                        <div>
                            <p class="text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1">Shipping Method</p>
                            <p class="font-medium text-zinc-800 dark:text-zinc-100">
                                {{ $deliveryOrder->shippingMethod?->name ?? '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1">Shipping Zone</p>
                            <p class="font-medium text-zinc-800 dark:text-zinc-100">
                                {{ $deliveryOrder->shippingZone?->name ?? '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1">Shipping Cost</p>
                            <p class="text-lg font-bold text-zinc-800 dark:text-zinc-100">
                                {{ format_currency($deliveryOrder->shipping_cost) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1">Package Weight</p>
                            <p class="font-medium text-zinc-800 dark:text-zinc-100">
                                @php $weightUnit = app(RegionalSettings::class)->weight_unit; @endphp
                                {{ $deliveryOrder->package_weight_kg ? $deliveryOrder->package_weight_kg . ' ' . $weightUnit : '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1">Distance</p>
                            <p class="font-medium text-zinc-800 dark:text-zinc-100">
                                {{ $deliveryOrder->distance_km ? $deliveryOrder->distance_km . ' km' : '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1">Provider Reference</p>
                            <p class="font-mono text-xs font-medium text-zinc-800 dark:text-zinc-100 break-all">
                                {{ $deliveryOrder->provider_reference ?? '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1">Estimated Delivery</p>
                            @if ($deliveryOrder->estimated_delivery_at)
                                <p class="font-medium text-zinc-800 dark:text-zinc-100">
                                    {{ $deliveryOrder->estimated_delivery_at->format('M d, Y') }}
                                </p>
                                @if ($deliveryOrder->estimated_delivery_at->isPast() && $deliveryOrder->status->isActive())
                                    <p class="text-xs text-red-500 mt-0.5">
                                        Overdue by {{ $deliveryOrder->estimated_delivery_at->diffForHumans() }}
                                    </p>
                                @endif
                            @else
                                <p class="font-medium text-zinc-800 dark:text-zinc-100">—</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1">Delivered At</p>
                            @if ($deliveryOrder->delivered_at)
                                <p class="font-medium text-green-600 dark:text-green-400">
                                    {{ $deliveryOrder->delivered_at->format('M d, Y H:i') }}
                                </p>
                            @else
                                <p class="font-medium text-zinc-800 dark:text-zinc-100">—</p>
                            @endif
                        </div>
                    </div>
                </div>
            </flux:card>

            {{-- ============================================================ --}}
            {{-- PIPELINE / TIMELINE                                           --}}
            {{-- ============================================================ --}}
            <flux:card class="p-0">
                <div class="px-6 py-3 border-b border-zinc-200 dark:border-zinc-600 flex items-center justify-between">
                    <flux:heading level="3" class="font-semibold">Delivery Pipeline</flux:heading>
                    <flux:badge :color="$deliveryOrder->status->color()" variant="solid" size="sm">
                        {{ $deliveryOrder->status->label() }}
                    </flux:badge>
                </div>

                <div class="p-5">
                    @php
                        $isPus    = $deliveryOrder->pickupStation !== null;
                        $isReturn = $deliveryOrder->is_return;
                        $current  = $deliveryOrder->status;

                        if ($isReturn) {
                            $stages = [
                                DeliveryOrderStatus::PENDING,
                                DeliveryOrderStatus::PICKED_UP,
                                DeliveryOrderStatus::IN_TRANSIT,
                                DeliveryOrderStatus::RETURNING,
                                DeliveryOrderStatus::RETURNED,
                            ];
                        } elseif ($isPus) {
                            $stages = [
                                DeliveryOrderStatus::PENDING,
                                DeliveryOrderStatus::PICKED_UP,
                                DeliveryOrderStatus::IN_TRANSIT,
                                DeliveryOrderStatus::AT_STATION,
                                DeliveryOrderStatus::COLLECTED,
                            ];
                        } else {
                            $stages = [
                                DeliveryOrderStatus::PENDING,
                                DeliveryOrderStatus::PICKED_UP,
                                DeliveryOrderStatus::IN_TRANSIT,
                                DeliveryOrderStatus::OUT_FOR_DELIVERY,
                                DeliveryOrderStatus::DELIVERED,
                            ];
                        }

                        $stageIcons = [
                            DeliveryOrderStatus::PENDING->value          => 'clock',
                            DeliveryOrderStatus::PICKED_UP->value        => 'arrow-up-tray',
                            DeliveryOrderStatus::IN_TRANSIT->value       => 'truck',
                            DeliveryOrderStatus::OUT_FOR_DELIVERY->value => 'map-pin',
                            DeliveryOrderStatus::DELIVERED->value        => 'check-badge',
                            DeliveryOrderStatus::AT_STATION->value       => 'building-storefront',
                            DeliveryOrderStatus::COLLECTED->value        => 'check-badge',
                            DeliveryOrderStatus::RETURNING->value        => 'arrow-uturn-left',
                            DeliveryOrderStatus::RETURNED->value         => 'archive-box',
                        ];

                        $currentIdx = array_search($current, $stages);
                        $isFailed    = $current === DeliveryOrderStatus::FAILED;
                        $isCancelled = $current === DeliveryOrderStatus::CANCELLED;
                        $isTerminal  = $current->isTerminal();
                    @endphp

                    <div class="relative">
                        @foreach ($stages as $index => $stage)
                            @php
                                $reached  = $currentIdx !== false && $index <= $currentIdx;
                                $isActive = $current === $stage;
                                $isLast   = $index === count($stages) - 1;
                                $nextReached = isset($stages[$index + 1]) && $currentIdx !== false && ($index + 1) <= $currentIdx;
                            @endphp

                            <div class="relative flex gap-4 {{ $isLast ? 'pb-0' : 'pb-6' }}">
                                @if (! $isLast)
                                    <div @class([
                                        'absolute left-4 top-8 bottom-0 w-px z-0',
                                        'bg-green-500' => $nextReached,
                                        'bg-zinc-200 dark:bg-zinc-600' => ! $nextReached,
                                    ])></div>
                                @endif

                                <div @class([
                                    'relative z-10 shrink-0 w-8 h-8 rounded-full flex items-center justify-center transition-colors',
                                    'bg-green-500 text-white ring-4 ring-green-100 dark:ring-green-900' => $isActive && ! $isFailed && ! $isCancelled,
                                    'bg-green-500 text-white' => $reached && ! $isActive,
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-400' => ! $reached,
                                ])>
                                    <flux:icon name="{{ $stageIcons[$stage->value] ?? 'circle-stack' }}" class="size-4" />
                                </div>

                                <div class="flex-1 flex items-start justify-between gap-4 pt-1 min-w-0">
                                    <div>
                                        <flux:text @class([
                                            'text-sm',
                                            'font-semibold text-green-600 dark:text-green-400' => $isActive,
                                            'font-medium text-zinc-900 dark:text-white' => $reached && ! $isActive,
                                            'text-zinc-400' => ! $reached,
                                        ])>
                                            {{ $stage->label() }}
                                        </flux:text>

                                        @if ($stage === DeliveryOrderStatus::PENDING && $isActive)
                                            <flux:text class="text-xs text-zinc-400 mt-0.5">
                                                Awaiting provider assignment and pickup
                                            </flux:text>
                                        @endif

                                        @if ($stage === DeliveryOrderStatus::PENDING && $reached && ! $isActive)
                                            <flux:text class="text-xs text-zinc-400 mt-0.5">
                                                {{ $deliveryOrder->created_at->format('M d, Y · g:i A') }}
                                            </flux:text>
                                        @endif

                                        @if ($stage === DeliveryOrderStatus::OUT_FOR_DELIVERY && $deliveryOrder->estimated_delivery_at && $reached)
                                            <flux:text class="{{ $deliveryOrder->estimated_delivery_at->isPast() && ! $isTerminal ? 'text-xs text-red-500' : 'text-xs text-zinc-400' }} mt-0.5">
                                                Est. {{ $deliveryOrder->estimated_delivery_at->format('M d, Y') }}
                                                @if ($deliveryOrder->estimated_delivery_at->isPast() && ! $isTerminal)
                                                    · Overdue
                                                @endif
                                            </flux:text>
                                        @endif

                                        @if ($stage === DeliveryOrderStatus::DELIVERED && $deliveryOrder->delivered_at)
                                            <flux:text class="text-xs text-zinc-400 mt-0.5">
                                                {{ $deliveryOrder->delivered_at->format('M d, Y · g:i A') }}
                                            </flux:text>
                                        @endif

                                        @if ($stage === DeliveryOrderStatus::COLLECTED && $deliveryOrder->delivered_at)
                                            <flux:text class="text-xs text-zinc-400 mt-0.5">
                                                {{ $deliveryOrder->delivered_at->format('M d, Y · g:i A') }}
                                            </flux:text>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Failed branch --}}
                        @if ($isFailed || $isCancelled)
                            <div class="relative flex gap-4 pt-6">
                                <div class="absolute left-4 top-0 h-6 w-px bg-zinc-300 z-0"></div>
                                <div class="relative z-10 shrink-0 w-8 h-8 rounded-full flex items-center justify-center bg-red-500 text-white">
                                    <flux:icon name="x-circle" class="size-4" />
                                </div>
                                <div class="flex-1 pt-1">
                                    <flux:text class="text-sm font-semibold text-red-600">
                                        {{ $current->label() }}
                                    </flux:text>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </flux:card>

            {{-- ============================================================ --}}
            {{-- PICKUP STATION (conditional)                                  --}}
            {{-- ============================================================ --}}
            @if ($deliveryOrder->pickupStation)
                <flux:card class="p-0">
                    <div class="px-6 py-3 border-b border-zinc-200 dark:border-zinc-600 flex items-center justify-between">
                        <flux:heading level="3" class="font-semibold">Pickup Station</flux:heading>
                        @if ($deliveryOrder->isOverdueCollection())
                            <flux:badge color="red" variant="solid" size="sm">Collection Overdue</flux:badge>
                        @elseif ($deliveryOrder->status === DeliveryOrderStatus::COLLECTED)
                            <flux:badge color="green" variant="solid" size="sm">Collected</flux:badge>
                        @elseif ($deliveryOrder->status === DeliveryOrderStatus::AT_STATION)
                            <flux:badge color="orange" variant="solid" size="sm">Awaiting Collection</flux:badge>
                        @endif
                    </div>
                    <div class="p-6 grid grid-cols-2 sm:grid-cols-3 gap-x-8 gap-y-5 text-sm">
                        <div>
                            <p class="text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1">Station Name</p>
                            <p class="font-medium text-zinc-800 dark:text-zinc-100">
                                {{ $deliveryOrder->pickupStation->name }}
                            </p>
                        </div>
                        @if ($deliveryOrder->pickupStation->location ?? null)
                            <div>
                                <p class="text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1">Location</p>
                                <p class="font-medium text-zinc-800 dark:text-zinc-100">
                                    {{ $deliveryOrder->pickupStation->location }}
                                </p>
                            </div>
                        @endif
                        @if ($deliveryOrder->collection_deadline_at)
                            <div>
                                <p class="text-xs font-medium text-zinc-400 uppercase tracking-wider mb-1">Collection Deadline</p>
                                <p class="font-medium {{ $deliveryOrder->collection_deadline_at->isPast() ? 'text-red-500' : 'text-zinc-800 dark:text-zinc-100' }}">
                                    {{ $deliveryOrder->collection_deadline_at->format('M d, Y') }}
                                </p>
                                <p class="text-xs text-zinc-400 mt-0.5">
                                    {{ $deliveryOrder->collection_deadline_at->diffForHumans() }}
                                </p>
                            </div>
                        @endif
                    </div>
                </flux:card>
            @endif

            {{-- ============================================================ --}}
            {{-- COST BREAKDOWN (conditional)                                  --}}
            {{-- ============================================================ --}}
            @if (! empty($deliveryOrder->cost_breakdown))
                @php $breakdown = $deliveryOrder->cost_breakdown; @endphp
                <flux:card class="p-0">
                    <div class="px-6 py-3 border-b border-zinc-200 dark:border-zinc-600">
                        <flux:heading level="3" class="font-semibold">Cost Breakdown</flux:heading>
                    </div>
                    <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach ($breakdown as $key => $value)
                            @if (! in_array($key, ['model', 'total']))
                                <div class="flex justify-between px-6 py-3 text-sm">
                                    <flux:text class="text-zinc-500 capitalize">{{ str_replace('_', ' ', $key) }}</flux:text>
                                    <flux:text class="font-medium">
                                        {{ is_numeric($value) ? format_currency($value) : $value }}
                                    </flux:text>
                                </div>
                            @endif
                        @endforeach
                        <div class="flex justify-between px-6 py-3 text-sm font-semibold bg-zinc-50 dark:bg-zinc-800/30">
                            <span>Total</span>
                            <span>{{ format_currency($breakdown['total'] ?? $deliveryOrder->shipping_cost) }}</span>
                        </div>
                    </div>
                </flux:card>
            @endif

        </div>

        {{-- ── Right: Sidebar ── --}}
        <div class="space-y-5">

            {{-- ============================================================ --}}
            {{-- LINKED ORDER                                                   --}}
            {{-- ============================================================ --}}
            @if ($deliveryOrder->order)
                <flux:card class="p-0">
                    <div class="px-5 py-3 border-b border-zinc-200 dark:border-zinc-600">
                        <flux:heading>Linked Order</flux:heading>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="shrink-0 w-10 h-10 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                <flux:icon.shopping-bag class="size-5 text-zinc-400" />
                            </div>
                            <div>
                                <flux:text class="font-semibold text-sm">{{ $deliveryOrder->order->reference }}</flux:text>
                                <flux:text class="text-xs text-zinc-400">
                                    {{ $deliveryOrder->order->user?->name ?? 'Guest' }}
                                </flux:text>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <flux:text class="text-zinc-400">Order status</flux:text>
                            <flux:badge size="sm" color="zinc" variant="flat">
                                {{ $deliveryOrder->order->status->label() }}
                            </flux:badge>
                        </div>
                        <flux:button variant="ghost" size="sm" icon="arrow-top-right-on-square"
                            :href="route('admin.orders.show', $deliveryOrder->order)" wire:navigate class="w-full">
                            View Order
                        </flux:button>
                    </div>
                </flux:card>
            @endif

            {{-- ============================================================ --}}
            {{-- ASSIGN LOGISTICS PROVIDER                                      --}}
            {{-- ============================================================ --}}
            <flux:card class="p-0">
                <div class="px-5 py-3 border-b border-zinc-200 dark:border-zinc-600 flex items-center justify-between">
                    <flux:heading>Logistics Provider</flux:heading>
                    @if ($deliveryOrder->logisticsProvider)
                        <flux:badge size="sm" color="green" variant="flat">Assigned</flux:badge>
                    @else
                        <flux:badge size="sm" color="zinc" variant="flat">Unassigned</flux:badge>
                    @endif
                </div>
                <div class="p-5 space-y-4">
                    @if ($deliveryOrder->logisticsProvider && ! $deliveryOrder->isTerminal())
                        <div class="flex items-center gap-2 text-sm">
                            <flux:icon.truck class="size-4 text-zinc-400 shrink-0" />
                            <flux:text class="font-medium">{{ $deliveryOrder->logisticsProvider->name }}</flux:text>
                        </div>
                        <flux:separator />
                    @elseif ($deliveryOrder->logisticsProvider && $deliveryOrder->isTerminal())
                        <div class="flex items-center gap-2 text-sm">
                            <flux:icon.truck class="size-4 text-zinc-400 shrink-0" />
                            <flux:text class="font-medium">{{ $deliveryOrder->logisticsProvider->name }}</flux:text>
                        </div>
                    @endif

                    @if (! $deliveryOrder->isTerminal())
                        <flux:field>
                            <flux:label>{{ $deliveryOrder->logisticsProvider ? 'Change Provider' : 'Select Provider' }}</flux:label>
                            <flux:select wire:model="selectedProviderId" class="w-full">
                                <flux:select.option :value="null">— None —</flux:select.option>
                                @foreach ($this->activeProviders as $provider)
                                    <flux:select.option :value="$provider->id">{{ $provider->name }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field>
                        <flux:button variant="primary" size="sm" wire:click="assignProvider" class="w-full cursor-pointer">
                            {{ $deliveryOrder->logisticsProvider ? 'Update Provider' : 'Assign Provider' }}
                        </flux:button>
                    @endif
                </div>
            </flux:card>

            {{-- ============================================================ --}}
            {{-- CUSTOMER INFO                                                  --}}
            {{-- ============================================================ --}}
            @if ($deliveryOrder->order?->user)
                <flux:card class="p-0">
                    <div class="px-5 py-3 border-b border-zinc-200 dark:border-zinc-600">
                        <flux:heading>Customer</flux:heading>
                    </div>
                    <div class="p-5 space-y-3 text-sm">
                        <div class="flex items-center gap-3">
                            <div class="shrink-0 w-9 h-9 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                <flux:icon.user class="size-4 text-zinc-400" />
                            </div>
                            <div>
                                <flux:text class="font-medium">{{ $deliveryOrder->order->user->name }}</flux:text>
                                <flux:text class="text-xs text-zinc-400">{{ $deliveryOrder->order->user->email }}</flux:text>
                            </div>
                        </div>
                        @if ($deliveryOrder->order->shipping_address)
                            <div class="flex items-start gap-2 text-xs text-zinc-500 pt-1">
                                <flux:icon.map-pin class="size-3.5 shrink-0 mt-0.5 text-zinc-400" />
                                <span>
                                    {{ $deliveryOrder->order->shipping_address['address'] ?? '' }},
                                    {{ implode(', ', array_filter([
                                        $deliveryOrder->order->shipping_address['area'] ?? null,
                                        $deliveryOrder->order->shipping_address['county'] ?? null,
                                    ])) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </flux:card>
            @endif

        </div>

    </div>
</div>
