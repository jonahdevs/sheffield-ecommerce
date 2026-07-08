@php
    $branding = app(\App\Settings\BrandingSettings::class);
    $storeName = $branding->store_name ?: config('app.name');
    $logoUrl = $branding->logo_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($branding->logo_path)
        : null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm delivery — {{ $order->order_number }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-zinc-50 antialiased">

    {{-- Header --}}
    <div class="border-b border-zinc-200 bg-white px-4 py-4">
        <div class="mx-auto flex max-w-lg items-center gap-3">
            @if ($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $storeName }}" class="h-7 w-auto" />
            @else
                <span class="font-serif text-lg font-black text-zinc-900">{{ $storeName }}</span>
            @endif
        </div>
    </div>

    <div class="mx-auto max-w-lg px-4 py-10 space-y-6">

        {{-- Page heading --}}
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400">Order {{ $order->order_number }}</p>
            <h1 class="mt-1 font-serif text-2xl font-black text-zinc-900">Confirm your delivery</h1>
            <p class="mt-2 text-sm text-zinc-500">
                Please review the items below and confirm you have received your order in good condition.
            </p>
        </div>

        {{-- Items card --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white">
            <div class="border-b border-zinc-100 px-5 py-3">
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Items delivered</p>
            </div>
            <ul class="divide-y divide-zinc-100">
                @foreach ($order->items as $item)
                    @php $name = $item->product_snapshot['name'] ?? $item->product_name ?? '—'; @endphp
                    <li class="flex items-center justify-between gap-4 px-5 py-3">
                        <span class="text-sm font-medium text-zinc-800">{{ $name }}</span>
                        <span class="shrink-0 text-sm text-zinc-400">× {{ $item->quantity }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Delivery driver --}}
        @if ($shipment->hasDriver())
            <div class="flex items-center gap-3 rounded-xl border border-zinc-200 bg-white px-5 py-4">
                <div class="flex size-9 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-zinc-500">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7a4 4 0 108 0 4 4 0 00-8 0zM3 20a7 7 0 0114 0" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Delivered by</p>
                    @if ($shipment->driver_name)
                        <p class="text-sm font-semibold text-zinc-800">{{ $shipment->driver_name }}</p>
                    @endif
                </div>
                @if ($shipment->driver_phone)
                    <a href="tel:{{ $shipment->driver_phone }}"
                        class="shrink-0 text-sm font-semibold text-emerald-600 hover:underline">{{ $shipment->driver_phone }}</a>
                @endif
            </div>
        @endif

        @if ($shipment->customer_disputed_at)
            {{-- Already disputed --}}
            <div class="rounded-xl border border-amber-200 bg-amber-50 px-5 py-4">
                <p class="text-sm font-semibold text-amber-700">You raised a dispute on {{ $shipment->customer_disputed_at->format('d M Y') }}.</p>
                @if ($shipment->customer_notes)
                    <p class="mt-1 text-sm text-amber-600">{{ $shipment->customer_notes }}</p>
                @endif
                <p class="mt-2 text-xs text-amber-500">Our team will be in touch shortly to resolve your issue.</p>
            </div>
        @else
            {{-- Confirm form --}}
            <form method="POST" action="{{ $confirmPostUrl }}">
                @csrf
                <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-4 text-base font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Yes, I received my order
                </button>
            </form>

            {{-- Dispute link --}}
            <div class="text-center">
                <a href="{{ $disputeUrl }}" class="text-sm text-zinc-400 underline underline-offset-2 hover:text-zinc-600">
                    Something wrong? Report an issue
                </a>
            </div>
        @endif

    </div>

</body>
</html>
