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
    <title>Issue reported - {{ $order->order_number }}</title>
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
        <div class="mx-auto flex size-20 items-center justify-center rounded-full bg-amber-100">
            <svg class="size-10 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
        </div>

        <div>
            <h1 class="font-serif text-2xl font-black text-zinc-900">Issue reported</h1>
            <p class="mt-2 text-sm text-zinc-500">
                We've logged your dispute for order <strong class="font-semibold text-zinc-700">{{ $order->order_number }}</strong>.
                Our team will review it and contact you within one business day.
            </p>
        </div>

        @if ($shipment->customer_notes)
            <div class="rounded-xl border border-zinc-200 bg-white px-5 py-4 text-left">
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Your message</p>
                <p class="mt-2 text-sm text-zinc-700">{{ $shipment->customer_notes }}</p>
            </div>
        @endif

        <a href="{{ route('home') }}" class="inline-block text-sm font-medium text-brand-600 hover:underline">
            Back to shop
        </a>

    </div>

</body>
</html>
