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
    <title>Delivery confirmed - {{ $order->order_number }}</title>
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

    <div class="mx-auto max-w-lg px-4 py-16 text-center space-y-5">

        {{-- Icon --}}
        <div class="mx-auto flex size-20 items-center justify-center rounded-full bg-emerald-100">
            <svg class="size-10 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <div>
            <h1 class="font-serif text-2xl font-black text-zinc-900">Receipt confirmed</h1>
            <p class="mt-2 text-sm text-zinc-500">
                Thank you! Your delivery for order <strong class="font-semibold text-zinc-700">{{ $order->order_number }}</strong>
                has been confirmed{{ $shipment->customer_confirmed_at ? ' on ' . $shipment->customer_confirmed_at->format('d M Y') : '' }}.
            </p>
        </div>

        {{-- Items --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white text-left">
            <div class="border-b border-zinc-100 px-5 py-3">
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Items received</p>
            </div>
            <ul class="divide-y divide-zinc-100">
                @foreach ($order->items as $item)
                    @php $name = $item->product_snapshot['name'] ?? $item->product_name ?? '-'; @endphp
                    <li class="flex items-center justify-between gap-4 px-5 py-3">
                        <span class="text-sm font-medium text-zinc-800">{{ $name }}</span>
                        <span class="shrink-0 text-sm text-zinc-400">× {{ $item->quantity }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Dispute link --}}
        <p class="text-xs text-zinc-400">
            Changed your mind or noticed an issue?
            <a href="{{ $disputeUrl }}" class="underline underline-offset-2 hover:text-zinc-600">Report a problem</a>.
        </p>

        <a href="{{ route('home') }}" class="inline-block text-sm font-medium text-brand-600 hover:underline">
            Back to shop
        </a>

    </div>

</body>
</html>
