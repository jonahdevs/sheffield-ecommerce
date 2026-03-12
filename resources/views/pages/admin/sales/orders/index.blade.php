<?php

use App\Models\Order;
use App\Enums\OrdersStatus;
use App\Enums\PaymentStatus;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Title, Computed};
use Illuminate\Support\Facades\Response;

new #[Title('Orders')] class extends Component {
    use WithPagination;

    public string $search = '';
    public string $statusFilter = 'all';
    public string $dateFrom = '';
    public string $dateTo = '';
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 25;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }
    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }
    public function updatingDateTo(): void
    {
        $this->resetPage();
    }
    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    // Computed

    #[Computed]
    public function orders()
    {
        return Order::query()
            ->with(['user', 'payment'])
            ->withCount('items')
            ->when($this->search, fn($q) => $q->where('reference', 'like', "%{$this->search}%")->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%")))
            ->when($this->statusFilter !== 'all', fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->dateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    #[Computed]
    public function stats(): array
    {
        $today = now()->toDateString();

        return [
            'total' => Order::count(),
            'revenue' => Order::sum('total_cents') / 100,
            'today' => Order::whereDate('created_at', $today)->count(),
            'pending' => Order::whereIn('status', [OrdersStatus::PENDING->value, OrdersStatus::PROCESSING->value])->count(),
        ];
    }

    #[Computed]
    public function statusOptions(): array
    {
        $options = ['all' => 'All Orders'];
        foreach (OrdersStatus::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }

    #[Computed]
    public function statusCounts(): array
    {
        $counts = Order::query()->selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();

        return array_merge(['all' => array_sum($counts)], $counts);
    }

    // ── Sorting ─

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    //  Bulk Actions

    /**
     * Called from Alpine with selected IDs.
     * Only transitions orders that are allowed to move to the target status.
     * Skips and reports orders that can't transition.
     */
    public function executeBulkAction(string $action, array $ids): void
    {
        if (empty($ids)) {
            return;
        }

        if ($action === 'export') {
            // Handled separately via exportSelected()
            return;
        }

        $targetStatus = OrdersStatus::tryFrom($action);
        if (!$targetStatus) {
            return;
        }

        $orders = Order::whereIn('id', $ids)->get();
        $updated = 0;
        $skipped = 0;

        foreach ($orders as $order) {
            if ($order->status->canTransitionTo($targetStatus)) {
                try {
                    $order->transitionTo($targetStatus, notes: 'Bulk status update by admin', changedByType: 'user');
                    $updated++;
                } catch (\Exception $e) {
                    $skipped++;
                }
            } else {
                $skipped++;
            }
        }

        unset($this->orders, $this->statusCounts, $this->stats);

        $message = "{$updated} order(s) updated to {$targetStatus->label()}.";
        if ($skipped > 0) {
            $message .= " {$skipped} skipped (invalid transition).";
        }

        $this->dispatch('notify', variant: $skipped > 0 ? 'warning' : 'success', message: $message);
    }

    // ── Export ──

    /**
     * Export selected IDs — called from Alpine passing selected array.
     */
    public function exportSelected(array $ids)
    {
        $query = Order::whereIn('id', $ids)
            ->with(['user', 'payment'])
            ->get();
        return $this->buildCsvDownload($query, 'orders-selected-' . now()->format('Y-m-d'));
    }

    /**
     * Export current filter — called when nothing is selected.
     */
    public function exportFiltered()
    {
        $query = Order::query()
            ->with(['user', 'payment'])
            ->when($this->search, fn($q) => $q->where('reference', 'like', "%{$this->search}%")->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%")))
            ->when($this->statusFilter !== 'all', fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->dateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->latest()
            ->get();

        return $this->buildCsvDownload($query, 'orders-' . now()->format('Y-m-d'));
    }

    private function buildCsvDownload($orders, string $filename)
    {
        $rows = [];
        $rows[] = ['Reference', 'Customer', 'Email', 'Status', 'Payment Status', 'Gateway', 'Total', 'Items', 'Date'];

        foreach ($orders as $order) {
            $rows[] = [$order->reference, $order->user->name, $order->user->email, $order->status->label(), $order->payment?->status?->label() ?? 'N/A', ucfirst($order->payment?->gateway ?? 'N/A'), $order->total, $order->items()->count(), $order->created_at->format('Y-m-d H:i')];
        }

        $handle = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return Response::streamDownload(fn() => print $csv, $filename . '.csv', ['Content-Type' => 'text/csv']);
    }

    // ── Misc ────

    public function clearFilters(): void
    {
        $this->search = '';
        $this->statusFilter = 'all';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function rendered(): void
    {
        $this->dispatch('orders-refreshed', ids: $this->orders->pluck('id')->toArray());
    }
};
?>

<div x-data="{
    selected: [],
    allIds: @js($this->orders->pluck('id')->toArray()),

    get allSelected() {
        return this.allIds.length > 0 && this.allIds.every(id => this.selected.includes(id));
    },
    get someSelected() {
        return this.selected.length > 0 && !this.allSelected;
    },
    toggleAll() {
        this.selected = this.allSelected ? [] : [...this.allIds];
    },
    toggle(id) {
        this.selected.includes(id) ?
            this.selected = this.selected.filter(i => i !== id) :
            this.selected.push(id);
    },
    isSelected(id) {
        return this.selected.includes(id);
    },
    clearSelection() {
        this.selected = [];
    },
    runBulkAction(action) {
        if (this.selected.length === 0) return;
        $wire.executeBulkAction(action, this.selected);
        this.clearSelection();
    },
    runExport() {
        if (this.selected.length > 0) {
            $wire.exportSelected(this.selected);
        } else {
            $wire.exportFiltered();
        }
    },

    // Column visibility
    columns: JSON.parse(localStorage.getItem('orders_columns') ?? 'null') ?? {
        customer: true,
        date: true,
        items: true,
        payment: true,
    },
    toggleColumn(col) {
        this.columns[col] = !this.columns[col];
        localStorage.setItem('orders_columns', JSON.stringify(this.columns));
    },
}"
    @orders-refreshed.window="
        allIds = [...$event.detail.ids];
        selected = [];
    ">

    {{-- Breadcrumb --}}
    <flux:breadcrumbs class="mb-2">
        <flux:breadcrumbs.item :href="route('admin.dashboard')" icon="home" icon-variant="outline" wire:navigate />
        <flux:breadcrumbs.item>Orders</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- Page header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" class="mb-1">Orders</flux:heading>
            <flux:subheading>Manage customer orders, track shipments, and process payments.</flux:subheading>
        </div>

        {{-- Export button — smart: exports selected if any, filtered if none --}}
        <flux:button icon="arrow-down-tray" variant="ghost" size="sm" @click="runExport()">
            <span x-text="selected.length > 0 ? 'Export Selected (' + selected.length + ')' : 'Export'"></span>
        </flux:button>
    </div>

    {{-- Stats cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <flux:card class="p-4 border-l-4 border-l-blue-500 rounded-l-none!">
            <div class="flex items-center justify-between">
                <div>
                    <flux:text class="text-xs text-zinc-500 uppercase tracking-wide mb-1">Total Orders</flux:text>
                    <flux:heading size="xl" class="text-2xl! font-bold!">
                        {{ number_format($this->stats['total']) }}
                    </flux:heading>
                    <flux:text class="text-xs text-zinc-400 mt-1">All time</flux:text>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                    <flux:icon.shopping-bag class="size-5 text-blue-500" />
                </div>
            </div>
        </flux:card>

        <flux:card class="p-4 border-l-4 border-l-emerald-500 rounded-l-none!">
            <div class="flex items-center justify-between">
                <div>
                    <flux:text class="text-xs text-zinc-500 uppercase tracking-wide mb-1">Total Revenue</flux:text>
                    <flux:heading size="xl" class="text-2xl! font-bold!">
                        {{ format_currency($this->stats['revenue']) }}
                    </flux:heading>
                    <flux:text class="text-xs text-zinc-400 mt-1">All time</flux:text>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center shrink-0">
                    <flux:icon.banknotes class="size-5 text-emerald-500" />
                </div>
            </div>
        </flux:card>

        <flux:card class="p-4 border-l-4 border-l-violet-500 rounded-l-none!">
            <div class="flex items-center justify-between">
                <div>
                    <flux:text class="text-xs text-zinc-500 uppercase tracking-wide mb-1">Orders Today</flux:text>
                    <flux:heading size="xl" class="text-2xl! font-bold!">
                        {{ number_format($this->stats['today']) }}
                    </flux:heading>
                    <flux:text class="text-xs text-zinc-400 mt-1">{{ now()->format('M j, Y') }}</flux:text>
                </div>
                <div class="w-10 h-10 rounded-full bg-violet-50 flex items-center justify-center shrink-0">
                    <flux:icon.calendar-days class="size-5 text-violet-500" />
                </div>
            </div>
        </flux:card>

        <flux:card class="p-4 border-l-4 border-l-amber-500 rounded-l-none!">
            <div class="flex items-center justify-between">
                <div>
                    <flux:text class="text-xs text-zinc-500 uppercase tracking-wide mb-1">Needs Attention</flux:text>
                    <flux:heading size="xl" class="text-2xl! font-bold!">
                        {{ number_format($this->stats['pending']) }}
                    </flux:heading>
                    <flux:text class="text-xs text-zinc-400 mt-1">Pending / Processing</flux:text>
                </div>
                <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center shrink-0">
                    <flux:icon.clock class="size-5 text-amber-500" />
                </div>
            </div>
        </flux:card>

    </div>

    {{-- Main table card --}}
    <flux:card class="p-0">

        {{-- Toolbar --}}
        <div class="flex flex-wrap items-center gap-3 px-5 py-3 border-b border-zinc-200 dark:border-zinc-700">

            {{-- Search --}}
            <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass"
                placeholder="Search reference, name or email..." class="max-w-xs" clearable />

            {{-- Right side controls --}}
            <div class="flex items-center gap-2 ms-auto flex-wrap">

                {{-- Date range using Mary UI datepicker --}}
                <x-my-datepicker wire:model.live="dateFrom" placeholder="From date" icon="o-calendar"
                    class="max-w-40" />

                <x-my-datepicker wire:model.live="dateTo" placeholder="To date" icon="o-calendar" class="max-w-40" />

                <flux:select wire:model.live="statusFilter" class="w-48">
                    <flux:select.option value="all">All Orders</flux:select.option>
                    @foreach (OrdersStatus::cases() as $s)
                        <flux:select.option value="{{ $s->value }}">
                            {{ $s->label() }} ({{ $this->statusCounts[$s->value] ?? 0 }})
                        </flux:select.option>
                    @endforeach
                </flux:select>

                {{-- Per page --}}
                <flux:select wire:model.live="perPage" class="w-24">
                    <flux:select.option value="10">10</flux:select.option>
                    <flux:select.option value="25">25</flux:select.option>
                    <flux:select.option value="50">50</flux:select.option>
                    <flux:select.option value="100">100</flux:select.option>
                </flux:select>

                {{-- Column visibility --}}
                <flux:dropdown>
                    <flux:button icon="view-columns" variant="ghost" size="sm">
                        Columns
                    </flux:button>
                    <flux:menu>
                        @foreach (['customer' => 'Customer', 'date' => 'Date', 'items' => 'Items', 'payment' => 'Payment'] as $col => $colLabel)
                            <flux:menu.item @click.prevent="toggleColumn('{{ $col }}')">
                                <span class="flex items-center gap-2">
                                    <span x-text="columns.{{ $col }} ? '✓' : ''"
                                        class="w-4 text-green-600 font-bold"></span>
                                    {{ $colLabel }}
                                </span>
                            </flux:menu.item>
                        @endforeach
                    </flux:menu>
                </flux:dropdown>

                {{-- Clear filters --}}
                @if ($search || $dateFrom || $dateTo || $statusFilter !== 'all')
                    <flux:button wire:click="clearFilters" variant="ghost" size="sm" icon="x-mark">
                        Clear
                    </flux:button>
                @endif

            </div>
        </div>

        {{-- Bulk action bar --}}
        <div x-cloak x-show="selected.length > 0" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="flex flex-wrap items-center gap-2 px-5 py-2.5 bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700">
            <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 me-1">
                <span x-text="selected.length"></span> selected
            </span>

            <flux:button size="sm" variant="ghost" icon="check-badge" icon-variant="outline" class="cursor-pointer"
                @click="runBulkAction('{{ OrdersStatus::CONFIRMED->value }}')">
                Confirm
            </flux:button>

            <flux:button size="sm" variant="ghost" icon="arrow-path" icon-variant="outline"
                class="cursor-pointer" @click="runBulkAction('{{ OrdersStatus::PROCESSING->value }}')">
                Mark Processing
            </flux:button>

            <flux:button size="sm" variant="ghost" icon="truck" icon-variant="outline"
                class="cursor-pointer" @click="runBulkAction('{{ OrdersStatus::SHIPPED->value }}')">
                Mark Shipped
            </flux:button>

            <flux:button size="sm" variant="ghost" icon="check-circle" icon-variant="outline"
                class="cursor-pointer" @click="runBulkAction('{{ OrdersStatus::DELIVERED->value }}')">
                Mark Delivered
            </flux:button>

            <flux:button size="sm" variant="ghost" icon="arrow-down-tray" icon-variant="outline"
                class="cursor-pointer" @click="runExport()">
                Export Selected
            </flux:button>

            {{-- Cancel — danger, far right --}}
            <flux:button size="sm" variant="ghost" icon="x-circle" icon-variant="outline"
                class="text-red-500! ms-auto cursor-pointer"
                @click="
                    if (confirm('Cancel ' + selected.length + ' order(s)?')) {
                        runBulkAction('{{ OrdersStatus::CANCELLED->value }}')
                    }
                ">
                Cancel Orders
            </flux:button>

            <flux:button size="sm" variant="ghost" icon="x-mark" icon-variant="outline"
                class="cursor-pointer" @click="clearSelection()">
                Clear
            </flux:button>
        </div>

        {{-- Table --}}
        <flux:table :paginate="$this->orders">
            <flux:table.columns>

                {{-- Select all --}}
                <flux:table.column class="w-10 ps-4!">
                    <flux:checkbox x-ref="selectAll"
                        x-effect="$refs.selectAll.querySelector('input').indeterminate = someSelected"
                        ::checked="allSelected" @change="toggleAll()" />
                </flux:table.column>

                {{-- Order ref --}}
                <flux:table.column sortable :sorted="$this->sortBy === 'reference'" :direction="$this->sortDirection"
                    wire:click="sort('reference')">
                    Order
                </flux:table.column>

                {{-- Customer --}}
                <flux:table.column x-show="columns.customer">Customer</flux:table.column>

                {{-- Date --}}
                <flux:table.column x-show="columns.date" sortable :sorted="$this->sortBy === 'created_at'"
                    :direction="$this->sortDirection" wire:click="sort('created_at')">
                    Date
                </flux:table.column>

                {{-- Items --}}
                <flux:table.column x-show="columns.items">Items</flux:table.column>

                {{-- Total --}}
                <flux:table.column sortable :sorted="$this->sortBy === 'total_cents'" :direction="$this->sortDirection"
                    wire:click="sort('total_cents')">
                    Total
                </flux:table.column>

                {{-- Payment --}}
                <flux:table.column x-show="columns.payment">Payment</flux:table.column>

                {{-- Order Status --}}
                <flux:table.column>Status</flux:table.column>

                {{-- Actions --}}
                <flux:table.column align="end" class="pe-4!">Actions</flux:table.column>

            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->orders as $order)
                    <flux:table.row :key="$order->id"
                        x-bind:class="isSelected({{ $order->id }}) ? 'bg-blue-50 dark:bg-blue-900/20' : ''">

                        {{-- Checkbox --}}
                        <flux:table.cell class="ps-4! w-10">
                            <flux:checkbox ::checked="isSelected({{ $order->id }})"
                                @change="toggle({{ $order->id }})" />
                        </flux:table.cell>

                        {{-- Reference --}}
                        <flux:table.cell>
                            <a href="{{ route('admin.orders.show', $order) }}" wire:navigate
                                class="font-semibold text-zinc-800 dark:text-white hover:text-sheffield-red transition-colors">
                                #{{ $order->reference }}
                            </a>
                        </flux:table.cell>

                        {{-- Customer --}}
                        <flux:table.cell x-show="columns.customer">
                            <div class="font-medium text-zinc-800 dark:text-zinc-200">
                                {{ $order->user->name }}
                            </div>
                            <div class="text-xs text-zinc-400">{{ $order->user->email }}</div>
                        </flux:table.cell>

                        {{-- Date --}}
                        <flux:table.cell x-show="columns.date">
                            <div class="text-sm">{{ $order->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-zinc-400">{{ $order->created_at->format('h:i A') }}</div>
                        </flux:table.cell>

                        {{-- Items --}}
                        <flux:table.cell x-show="columns.items">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $order->items_count }} {{ Str::plural('item', $order->items_count) }}
                            </span>
                        </flux:table.cell>

                        {{-- Total --}}
                        <flux:table.cell>
                            <div class="font-semibold text-sm text-zinc-800 dark:text-zinc-200">
                                {{ format_currency($order->total) }}
                            </div>
                        </flux:table.cell>

                        {{-- Payment --}}
                        <flux:table.cell x-show="columns.payment">
                            @if ($order->payment)
                                <flux:badge size="sm" variant="flat" :color="$order->payment->status->color()">
                                    {{ $order->payment->status?->label() }}
                                </flux:badge>
                            @else
                                <flux:badge size="sm" color="zinc">No Payment</flux:badge>
                            @endif
                        </flux:table.cell>

                        {{-- Order status --}}
                        <flux:table.cell>
                            <flux:badge size="sm" variant="flat" :color="$order->status->color()"
                                :icon="$order->status->icon()">
                                {{ $order->status->label() }}
                            </flux:badge>
                        </flux:table.cell>

                        {{-- Actions --}}
                        <flux:table.cell align="end" class="pe-4!">
                            <flux:dropdown align="end">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"
                                    class="cursor-pointer" />

                                <flux:menu>
                                    {{-- View --}}
                                    <flux:menu.item icon="eye" icon-variant="outline"
                                        :href="route('admin.orders.show', $order)" wire:navigate>
                                        View Order
                                    </flux:menu.item>

                                    <flux:menu.separator />

                                    {{-- Set Status — only shows valid transitions --}}
                                    @if (count($order->status->allowedTransitions()) > 0)
                                        <flux:menu.submenu heading="Set Status">
                                            @foreach ($order->status->allowedTransitions() as $transition)
                                                <flux:menu.item :icon="$transition->icon()" icon-variant="outline"
                                                    wire:click="executeBulkAction('{{ $transition->value }}', [{{ $order->id }}])">
                                                    {{ $transition->label() }}
                                                </flux:menu.item>
                                            @endforeach
                                        </flux:menu.submenu>

                                        <flux:menu.separator />
                                    @endif

                                    {{-- Cancel — only if transition is allowed --}}
                                    @if ($order->status->canTransitionTo(OrdersStatus::CANCELLED))
                                        <flux:menu.item icon="x-circle" variant="danger" icon-variant="outline"
                                            wire:click="executeBulkAction('{{ OrdersStatus::CANCELLED->value }}', [{{ $order->id }}])"
                                            wire:confirm="Cancel order #{{ $order->reference }}?">
                                            Cancel Order
                                        </flux:menu.item>
                                    @endif

                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>

                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="9" class="text-center py-16">
                            <div class="flex flex-col items-center justify-center text-zinc-400">
                                <flux:icon.inbox class="size-12 stroke-1 mb-3" />
                                <flux:text class="font-medium text-zinc-500">No orders found</flux:text>
                                <flux:text class="text-xs mt-1">Try adjusting your filters or search query</flux:text>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

    </flux:card>

</div>

<style>
    [data-flux-pagination] {
        padding-inline: 1rem;
        padding-bottom: 1rem;
    }
</style>
