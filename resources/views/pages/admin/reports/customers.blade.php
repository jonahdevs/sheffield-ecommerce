<?php

use App\Enums\PaymentStatus;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Livewire\Attributes\{Computed, Title};
use Livewire\Component;

new #[Title('Customer Insights')] class extends Component {

    public string $dateFrom  = '';
    public string $dateTo    = '';
    public int    $atRiskDays = 90;

    public function mount(): void
    {
        $this->dateFrom = now()->startOfYear()->toDateString();
        $this->dateTo   = now()->toDateString();
    }

    public function setDateRange(string $from, string $to): void
    {
        $this->dateFrom = $from;
        $this->dateTo   = $to;
        $this->clearComputedCache();
    }

    public function updatedAtRiskDays(): void
    {
        unset($this->atRiskCustomers, $this->kpiStats);
    }

    private function clearComputedCache(): void
    {
        unset(
            $this->dateRange,
            $this->periodLabel,
            $this->kpiStats,
            $this->acquisitionTrend,
            $this->spendTiers,
            $this->topSpenders,
            $this->atRiskCustomers,
        );
    }

    #[Computed]
    public function dateRange(): array
    {
        return [
            Carbon::parse($this->dateFrom)->startOfDay(),
            Carbon::parse($this->dateTo)->endOfDay(),
        ];
    }

    #[Computed]
    public function periodLabel(): string
    {
        [$from, $to] = $this->dateRange;

        return $from->isSameDay($to)
            ? $from->format('M j, Y')
            : $from->format('M j, Y') . ' – ' . $to->format('M j, Y');
    }

    #[Computed]
    public function kpiStats(): array
    {
        [$from, $to] = $this->dateRange;

        $total = User::customer()->count();

        $newInPeriod = User::customer()
            ->whereBetween('created_at', [$from, $to])
            ->count();

        $returning = User::customer()
            ->has('orders', '>=', 2)
            ->count();

        $atRisk = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('users.is_staff', false)
            ->where('orders.payment_status', PaymentStatus::PAID->value)
            ->groupBy('users.id')
            ->havingRaw('MAX(orders.created_at) < ?', [now()->subDays($this->atRiskDays)])
            ->selectRaw('users.id')
            ->get()
            ->count();

        $avgLifetimeSpend = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('users.is_staff', false)
            ->where('orders.payment_status', PaymentStatus::PAID->value)
            ->groupBy('users.id')
            ->selectRaw('SUM(orders.total_cents) / 100 as spend')
            ->get()
            ->avg('spend');

        return [
            'total'              => $total,
            'new_in_period'      => $newInPeriod,
            'returning'          => $returning,
            'returning_pct'      => $total > 0 ? round(($returning / $total) * 100, 1) : 0,
            'at_risk'            => $atRisk,
            'avg_lifetime_spend' => round((float) $avgLifetimeSpend, 2),
        ];
    }

    #[Computed]
    public function acquisitionTrend(): array
    {
        [$from, $to] = $this->dateRange;

        $rows = User::customer()
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $months = [];
        $cursor = Carbon::parse($from)->startOfMonth();

        while ($cursor->lte($to)) {
            $key      = $cursor->format('Y-m');
            $months[] = [
                'month' => $cursor->format('M Y'),
                'count' => (int) ($rows[$key] ?? 0),
            ];
            $cursor->addMonth();
        }

        return $months;
    }

    #[Computed]
    public function spendTiers(): array
    {
        $tiers = [
            ['label' => 'High Value',  'min' => 50_000,  'max' => null,    'color' => '#10B981'],
            ['label' => 'Regular',     'min' => 10_000,  'max' => 50_000,  'color' => '#3B82F6'],
            ['label' => 'Low Value',   'min' => 1_000,   'max' => 10_000,  'color' => '#F59E0B'],
            ['label' => 'One-time',    'min' => 0,       'max' => 1_000,   'color' => '#A855F7'],
        ];

        // Get lifetime spend per customer (all time, not date-filtered — it's a segmentation)
        $spends = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('users.is_staff', false)
            ->where('orders.payment_status', PaymentStatus::PAID->value)
            ->groupBy('users.id')
            ->selectRaw('users.id, SUM(orders.total_cents) / 100 as lifetime_spend')
            ->pluck('lifetime_spend', 'id');

        // Customers with no paid orders → "one-time" bucket (spend = 0)
        $noSpend = User::customer()
            ->whereDoesntHave('orders', fn($q) => $q->where('payment_status', PaymentStatus::PAID->value))
            ->count();

        $total = $spends->count() + $noSpend;

        $result = [];
        foreach ($tiers as $tier) {
            if ($tier['max'] === null) {
                $count = $spends->filter(fn($s) => $s >= $tier['min'])->count();
            } elseif ($tier['min'] === 0) {
                $count = $spends->filter(fn($s) => $s < $tier['max'])->count() + $noSpend;
            } else {
                $count = $spends->filter(fn($s) => $s >= $tier['min'] && $s < $tier['max'])->count();
            }

            $minLabel = $tier['min'] > 0 ? format_currency($tier['min']) : 'KES 0';
            $maxLabel = $tier['max'] ? 'under ' . format_currency($tier['max']) : '+';

            $result[] = [
                'label'     => $tier['label'],
                'range'     => $tier['min'] === 0
                    ? 'Under ' . format_currency($tier['max'])
                    : format_currency($tier['min']) . ($tier['max'] ? ' – ' . format_currency($tier['max']) : '+'),
                'color'     => $tier['color'],
                'count'     => $count,
                'pct'       => $total > 0 ? round(($count / $total) * 100, 1) : 0,
            ];
        }

        return ['tiers' => $result, 'total' => $total];
    }

    #[Computed]
    public function topSpenders(): array
    {
        return DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('users.is_staff', false)
            ->where('orders.payment_status', PaymentStatus::PAID->value)
            ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
            ->selectRaw('
                users.id,
                users.name,
                users.email,
                users.created_at as joined_at,
                SUM(orders.total_cents) / 100 as total_spend,
                COUNT(orders.id) as order_count,
                SUM(orders.total_cents) / 100 / COUNT(orders.id) as aov,
                MAX(orders.created_at) as last_order_at
            ')
            ->orderByDesc('total_spend')
            ->limit(15)
            ->get()
            ->map(fn($r) => [
                'id'            => $r->id,
                'name'          => $r->name,
                'email'         => $r->email,
                'total_spend'   => round((float) $r->total_spend, 2),
                'order_count'   => (int) $r->order_count,
                'aov'           => round((float) $r->aov, 2),
                'last_order_at' => Carbon::parse($r->last_order_at),
                'joined_at'     => Carbon::parse($r->joined_at),
            ])
            ->toArray();
    }

    #[Computed]
    public function atRiskCustomers(): array
    {
        return DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('users.is_staff', false)
            ->where('orders.payment_status', PaymentStatus::PAID->value)
            ->groupBy('users.id', 'users.name', 'users.email')
            ->selectRaw('
                users.id,
                users.name,
                users.email,
                COUNT(orders.id) as order_count,
                SUM(orders.total_cents) / 100 as total_spend,
                MAX(orders.created_at) as last_order_at
            ')
            ->havingRaw('MAX(orders.created_at) < ?', [now()->subDays($this->atRiskDays)])
            ->orderBy('last_order_at')
            ->limit(10)
            ->get()
            ->map(fn($r) => [
                'id'            => $r->id,
                'name'          => $r->name,
                'email'         => $r->email,
                'order_count'   => (int) $r->order_count,
                'total_spend'   => round((float) $r->total_spend, 2),
                'last_order_at' => Carbon::parse($r->last_order_at),
                'days_inactive' => (int) Carbon::parse($r->last_order_at)->diffInDays(now()),
            ])
            ->toArray();
    }

    public function exportTopSpenders(): mixed
    {
        $rows = [['Name', 'Email', 'Total Spend (KES)', 'Orders', 'AOV (KES)', 'Last Order', 'Joined']];

        foreach ($this->topSpenders as $row) {
            $rows[] = [
                $row['name'],
                $row['email'],
                number_format($row['total_spend'], 2),
                $row['order_count'],
                number_format($row['aov'], 2),
                $row['last_order_at']->format('Y-m-d'),
                $row['joined_at']->format('Y-m-d'),
            ];
        }

        $handle = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return Response::streamDownload(
            fn() => print $csv,
            'top-spenders-' . now()->format('Y-m-d') . '.csv',
            ['Content-Type' => 'text/csv'],
        );
    }
};
?>

<div>
    {{-- Breadcrumb --}}
    <flux:breadcrumbs class="mb-2">
        <flux:breadcrumbs.item :href="route('admin.dashboard')" icon="home" icon-variant="outline" wire:navigate />
        <flux:breadcrumbs.item>Reports</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Customer Insights</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- Page header --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <flux:heading size="xl">Customer Insights</flux:heading>
            <flux:subheading>{{ $this->periodLabel }} · Acquisition, value, and retention analysis.</flux:subheading>
        </div>
        <div class="flex items-center gap-2 flex-wrap justify-end">
            <flux:icon.loading wire:loading wire:target="setDateRange" class="size-3.5 text-zinc-400" />

            <div class="relative" wire:ignore>
                <input type="text" readonly
                    class="customer-insights-date-range w-64 pl-8 pr-3 py-2 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 cursor-pointer focus:outline-none focus:ring-2 focus:ring-zinc-300 hover:border-zinc-400 transition-colors"
                    placeholder="Select period" />
                <flux:icon.calendar-days class="size-4 absolute left-2.5 top-1/2 -translate-y-1/2 text-zinc-400 pointer-events-none" />
            </div>
        </div>
    </div>

    {{-- ================================================================== --}}
    {{-- KPI CARDS                                                            --}}
    {{-- ================================================================== --}}
    @php $kpi = $this->kpiStats; @endphp

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-4">

        <flux:card class="p-4">
            <div class="flex items-start justify-between mb-3">
                <flux:text class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Total Customers</flux:text>
                <div class="w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-950/50 flex items-center justify-center shrink-0">
                    <flux:icon.users class="size-4 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
            <flux:heading size="xl" class="text-2xl! font-bold! mb-1.5"
                x-data="countUp({ to: {{ $kpi['total'] }} })" x-text="display">
            </flux:heading>
            <flux:text class="text-[10px] text-zinc-400">all time</flux:text>
        </flux:card>

        <flux:card class="p-4">
            <div class="flex items-start justify-between mb-3">
                <flux:text class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">New in Period</flux:text>
                <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 flex items-center justify-center shrink-0">
                    <flux:icon.user-plus class="size-4 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
            <flux:heading size="xl" class="text-2xl! font-bold! mb-1.5"
                x-data="countUp({ to: {{ $kpi['new_in_period'] }} })" x-text="display">
            </flux:heading>
            <flux:text class="text-[10px] text-zinc-400">{{ $this->periodLabel }}</flux:text>
        </flux:card>

        <flux:card class="p-4">
            <div class="flex items-start justify-between mb-3">
                <flux:text class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Returning Customers</flux:text>
                <div class="w-9 h-9 rounded-lg bg-violet-50 dark:bg-violet-950/50 flex items-center justify-center shrink-0">
                    <flux:icon.arrow-path class="size-4 text-violet-600 dark:text-violet-400" />
                </div>
            </div>
            <flux:heading size="xl" class="text-2xl! font-bold! mb-1.5"
                x-data="countUp({ to: {{ $kpi['returning'] }} })" x-text="display">
            </flux:heading>
            <flux:text class="text-[10px] text-zinc-400">{{ $kpi['returning_pct'] }}% of base — 2+ orders</flux:text>
        </flux:card>

        <flux:card class="p-4">
            <div class="flex items-start justify-between mb-3">
                <flux:text class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Avg Lifetime Spend</flux:text>
                <div class="w-9 h-9 rounded-lg bg-teal-50 dark:bg-teal-950/50 flex items-center justify-center shrink-0">
                    <flux:icon.banknotes class="size-4 text-teal-600 dark:text-teal-400" />
                </div>
            </div>
            <flux:heading size="xl" class="text-2xl! font-bold! mb-1.5"
                x-data="countUp({ to: {{ $kpi['avg_lifetime_spend'] }}, decimals: 2, prefix: 'KES ' })" x-text="display">
            </flux:heading>
            <flux:text class="text-[10px] text-zinc-400">per paying customer</flux:text>
        </flux:card>

        <flux:card class="p-4 lg:col-span-2">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <flux:text class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest mb-1">At-Risk Customers</flux:text>
                    <flux:text class="text-[10px] text-zinc-400">Ordered before but inactive for:</flux:text>
                </div>
                <div class="flex items-center gap-2">
                    <flux:select wire:model.live="atRiskDays" class="w-32 text-xs">
                        <flux:select.option value="30">30 days</flux:select.option>
                        <flux:select.option value="60">60 days</flux:select.option>
                        <flux:select.option value="90">90 days</flux:select.option>
                        <flux:select.option value="180">180 days</flux:select.option>
                    </flux:select>
                </div>
            </div>
            <flux:heading size="xl" class="text-2xl! font-bold! mb-1.5 text-amber-500!"
                x-data="countUp({ to: {{ $kpi['at_risk'] }} })" x-text="display">
            </flux:heading>
            <flux:text class="text-[10px] text-zinc-400">customers at risk of churning</flux:text>
        </flux:card>

    </div>

    {{-- ================================================================== --}}
    {{-- ACQUISITION TREND + SPEND TIERS                                     --}}
    {{-- ================================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">

        {{-- Acquisition trend chart (2 cols) --}}
        <flux:card class="p-0 lg:col-span-2">
            <div class="px-5 py-3 border-b border-zinc-100 dark:border-zinc-800">
                <flux:heading>New Customer Acquisition</flux:heading>
                <flux:text class="text-[11px] text-zinc-400">New registrations per month in the selected period</flux:text>
            </div>
            <div class="p-5">
                <div id="acquisitionChartBridge"
                    data-labels="{{ json_encode(array_column($this->acquisitionTrend, 'month')) }}"
                    data-counts="{{ json_encode(array_column($this->acquisitionTrend, 'count')) }}">
                </div>
                <div wire:ignore style="position:relative; height:260px;">
                    <canvas id="acquisitionChart"></canvas>
                </div>
            </div>
        </flux:card>

        {{-- Spend tiers --}}
        <flux:card class="p-0">
            <div class="px-5 py-3 border-b border-zinc-100 dark:border-zinc-800">
                <flux:heading size="sm">Customer Value Segments</flux:heading>
                <flux:text class="text-[10px] text-zinc-400">Lifetime spend distribution — all time</flux:text>
            </div>

            @php $tiers = $this->spendTiers; @endphp

            @if ($tiers['total'] > 0)
                <div class="p-5 space-y-4">
                    @foreach ($tiers['tiers'] as $tier)
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <div>
                                    <flux:text class="text-xs font-semibold text-zinc-700 dark:text-zinc-200">
                                        {{ $tier['label'] }}
                                    </flux:text>
                                    <flux:text class="text-[10px] text-zinc-400 block">{{ $tier['range'] }}</flux:text>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <flux:text class="text-xs font-semibold text-zinc-800 dark:text-zinc-200">
                                        {{ number_format($tier['count']) }}
                                    </flux:text>
                                    <span class="text-[10px] text-zinc-400 w-10 text-right">{{ $tier['pct'] }}%</span>
                                </div>
                            </div>
                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-2">
                                <div class="h-2 rounded-full transition-all"
                                    style="width: {{ max($tier['pct'], 0.5) }}%; background-color: {{ $tier['color'] }};"></div>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-2 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                        <flux:text class="text-xs text-zinc-400">Total customers</flux:text>
                        <flux:heading size="sm" class="font-bold!">{{ number_format($tiers['total']) }}</flux:heading>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12">
                    <flux:icon.users class="size-8 stroke-1 mb-2 text-zinc-300" />
                    <flux:text class="text-xs text-zinc-400">No customer data yet</flux:text>
                </div>
            @endif
        </flux:card>

    </div>

    {{-- ================================================================== --}}
    {{-- TOP SPENDERS TABLE                                                   --}}
    {{-- ================================================================== --}}
    <flux:card class="p-0 mb-4">
        <div class="flex items-center justify-between px-5 py-3 border-b border-zinc-100 dark:border-zinc-800">
            <div>
                <flux:heading>Top Spenders</flux:heading>
                <flux:text class="text-[11px] text-zinc-400">Top 15 customers by total lifetime spend</flux:text>
            </div>
            <flux:button wire:click="exportTopSpenders" icon="arrow-down-tray" variant="ghost" size="sm">
                Export CSV
            </flux:button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 dark:border-zinc-800">
                        <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">#</th>
                        <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Customer</th>
                        <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest whitespace-nowrap">Total Spend</th>
                        <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Orders</th>
                        <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">AOV</th>
                        <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest whitespace-nowrap">Last Order</th>
                        <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Joined</th>
                        <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($this->topSpenders as $i => $customer)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
                            <td class="px-5 py-3">
                                <span class="text-xs font-bold {{ $i === 0 ? 'text-amber-500' : ($i === 1 ? 'text-zinc-400' : ($i === 2 ? 'text-orange-400' : 'text-zinc-300 dark:text-zinc-600')) }}">
                                    #{{ $i + 1 }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center text-[10px] font-semibold text-zinc-500 shrink-0">
                                        {{ strtoupper(substr($customer['name'] ?? '?', 0, 2)) }}
                                    </div>
                                    <div>
                                        <flux:text class="text-xs font-medium text-zinc-800 dark:text-zinc-200">
                                            {{ $customer['name'] }}
                                        </flux:text>
                                        <flux:text class="text-[10px] text-zinc-400 block">{{ $customer['email'] }}</flux:text>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-xs font-semibold text-zinc-900 dark:text-zinc-100 whitespace-nowrap">
                                {{ format_currency($customer['total_spend']) }}
                            </td>
                            <td class="px-5 py-3 text-xs text-zinc-600 dark:text-zinc-400">
                                {{ number_format($customer['order_count']) }}
                            </td>
                            <td class="px-5 py-3 text-xs text-zinc-600 dark:text-zinc-400 whitespace-nowrap">
                                {{ format_currency($customer['aov']) }}
                            </td>
                            <td class="px-5 py-3 text-xs text-zinc-600 dark:text-zinc-400 whitespace-nowrap">
                                {{ $customer['last_order_at']->format('M d, Y') }}
                            </td>
                            <td class="px-5 py-3 text-xs text-zinc-400 whitespace-nowrap">
                                {{ $customer['joined_at']->format('M Y') }}
                            </td>
                            <td class="px-5 py-3">
                                <flux:button :href="route('admin.customers.show', $customer['id'])" wire:navigate size="sm" variant="ghost" icon="eye" icon-variant="outline" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-zinc-400 text-sm">
                                No paying customers yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </flux:card>

    {{-- ================================================================== --}}
    {{-- AT-RISK CUSTOMERS TABLE                                              --}}
    {{-- ================================================================== --}}
    <flux:card class="p-0">
        <div class="flex items-center justify-between px-5 py-3 border-b border-zinc-100 dark:border-zinc-800">
            <div>
                <flux:heading>At-Risk Customers</flux:heading>
                <flux:text class="text-[11px] text-zinc-400">
                    Previously active customers with no orders in the last {{ $atRiskDays }} days
                </flux:text>
            </div>
            @if (count($this->atRiskCustomers) > 0)
                <flux:badge color="amber" size="sm">{{ $kpi['at_risk'] }} at risk</flux:badge>
            @endif
        </div>

        @if (count($this->atRiskCustomers) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Customer</th>
                            <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Orders</th>
                            <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest whitespace-nowrap">Total Spend</th>
                            <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest whitespace-nowrap">Last Order</th>
                            <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest whitespace-nowrap">Days Inactive</th>
                            <th class="text-left px-5 py-3 text-[10px] font-semibold text-zinc-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach ($this->atRiskCustomers as $customer)
                            @php
                                $urgency = match(true) {
                                    $customer['days_inactive'] >= 180 => 'text-rose-600 dark:text-rose-400',
                                    $customer['days_inactive'] >= 90  => 'text-amber-600 dark:text-amber-400',
                                    default                            => 'text-zinc-600 dark:text-zinc-400',
                                };
                            @endphp
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center text-[10px] font-semibold text-zinc-500 shrink-0">
                                            {{ strtoupper(substr($customer['name'] ?? '?', 0, 2)) }}
                                        </div>
                                        <div>
                                            <flux:text class="text-xs font-medium text-zinc-800 dark:text-zinc-200">
                                                {{ $customer['name'] }}
                                            </flux:text>
                                            <flux:text class="text-[10px] text-zinc-400 block">{{ $customer['email'] }}</flux:text>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-xs text-zinc-600 dark:text-zinc-400">
                                    {{ number_format($customer['order_count']) }}
                                </td>
                                <td class="px-5 py-3 text-xs font-semibold text-zinc-800 dark:text-zinc-200 whitespace-nowrap">
                                    {{ format_currency($customer['total_spend']) }}
                                </td>
                                <td class="px-5 py-3 text-xs text-zinc-500 whitespace-nowrap">
                                    {{ $customer['last_order_at']->format('M d, Y') }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="text-xs font-semibold {{ $urgency }}">
                                        {{ number_format($customer['days_inactive']) }} days
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <flux:button :href="route('admin.customers.show', $customer['id'])" wire:navigate size="sm" variant="ghost" icon="eye" icon-variant="outline" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($kpi['at_risk'] > 10)
                    <div class="px-5 py-3 border-t border-zinc-100 dark:border-zinc-800 text-center">
                        <flux:text class="text-xs text-zinc-400">
                            Showing 10 of {{ number_format($kpi['at_risk']) }} at-risk customers — oldest inactive shown first
                        </flux:text>
                    </div>
                @endif
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12">
                <flux:icon.check-circle class="size-8 stroke-1 mb-2 text-emerald-400" />
                <flux:heading size="sm" class="font-medium! mb-1">No at-risk customers</flux:heading>
                <flux:text class="text-xs text-zinc-400">All customers have been active in the last {{ $atRiskDays }} days</flux:text>
            </div>
        @endif
    </flux:card>

</div>

@assets
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endassets

@script
<script>
    const chartInstances = {};
    const isDark    = () => document.documentElement.classList.contains('dark');
    const gridColor = () => isDark() ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
    const textColor = () => isDark() ? '#71717a' : '#a1a1aa';

    function destroyChart(id) {
        if (chartInstances[id]) {
            chartInstances[id].destroy();
            delete chartInstances[id];
        }
        const el = document.getElementById(id);
        if (el) {
            el.removeAttribute('style');
            el.removeAttribute('width');
            el.removeAttribute('height');
        }
    }

    // -----------------------------------------------------------------------
    //  Acquisition trend — bar chart, new customers per month
    // -----------------------------------------------------------------------
    function initAcquisitionChart() {
        const bridge = document.getElementById('acquisitionChartBridge');
        const canvas  = document.getElementById('acquisitionChart');
        if (!bridge || !canvas) return;

        destroyChart('acquisitionChart');

        const labels = JSON.parse(bridge.dataset.labels || '[]');
        const counts = JSON.parse(bridge.dataset.counts || '[]');

        chartInstances['acquisitionChart'] = new Chart(canvas, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'New Customers',
                    data: counts,
                    backgroundColor: 'rgba(59,130,246,0.65)',
                    borderColor: '#3B82F6',
                    borderWidth: 1,
                    borderRadius: 4,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.parsed.y} new customers`,
                        },
                    },
                },
                scales: {
                    x: {
                        grid: { color: gridColor() },
                        ticks: { color: textColor(), font: { size: 11 } },
                    },
                    y: {
                        grid: { color: gridColor() },
                        ticks: { color: textColor(), font: { size: 11 }, stepSize: 1 },
                        beginAtZero: true,
                    },
                },
            },
        });
    }

    initAcquisitionChart();

    // -----------------------------------------------------------------------
    //  Date range picker
    // -----------------------------------------------------------------------
    function waitForLibraries(cb) {
        if (typeof jQuery !== 'undefined' && typeof moment !== 'undefined' && typeof jQuery.fn.daterangepicker !== 'undefined') {
            cb();
        } else {
            setTimeout(() => waitForLibraries(cb), 100);
        }
    }

    function initDateRangePicker() {
        const el = $('.customer-insights-date-range').first();
        if (!el.length) return;

        if (el.data('daterangepicker')) {
            el.data('daterangepicker').remove();
        }

        const yr    = moment().year();
        const q     = moment().quarter();
        const prevQ = q > 1 ? q - 1 : 4;
        const prevQYear = q > 1 ? yr : yr - 1;
        const qS    = (n, y) => moment().year(y).quarter(n).startOf('quarter');
        const qE    = (n, y) => moment().year(y).quarter(n).endOf('quarter');

        el.daterangepicker({
            autoUpdateInput: false,
            opens: 'left',
            showDropdowns: true,
            alwaysShowCalendars: false,
            startDate: moment($wire.dateFrom),
            endDate: moment($wire.dateTo),
            ranges: {
                'This Month':               [moment().startOf('month'), moment().endOf('month')],
                'Last Month':               [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                [`Q${q} ${yr}`]:            [qS(q, yr), qE(q, yr)],
                [`Q${prevQ} ${prevQYear}`]: [qS(prevQ, prevQYear), qE(prevQ, prevQYear)],
                [`This Year (${yr})`]:      [moment().startOf('year'), moment()],
                [`Last Year (${yr - 1})`]:  [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            },
            locale: {
                format: 'MMM DD, YYYY',
                separator: ' – ',
                cancelLabel: 'Clear',
            },
        }, function (start, end) {
            $wire.setDateRange(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            el.val(start.format('MMM DD, YYYY') + ' – ' + end.format('MMM DD, YYYY'));
        });

        el.on('cancel.daterangepicker', function () {
            $wire.setDateRange(
                moment().startOf('year').format('YYYY-MM-DD'),
                moment().format('YYYY-MM-DD'),
            );
            el.val('');
        });

        if ($wire.dateFrom && $wire.dateTo) {
            el.val(moment($wire.dateFrom).format('MMM DD, YYYY') + ' – ' + moment($wire.dateTo).format('MMM DD, YYYY'));
        }
    }

    waitForLibraries(() => initDateRangePicker());
</script>
@endscript
