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
    <title>Report delivery issue — {{ $order->order_number }}</title>
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

        <div>
            <a href="{{ $confirmUrl }}" class="inline-flex items-center gap-1 text-xs font-medium text-zinc-400 hover:text-zinc-600">
                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back
            </a>
            <p class="mt-3 text-xs font-semibold uppercase tracking-widest text-zinc-400">Order {{ $order->order_number }}</p>
            <h1 class="mt-1 font-serif text-2xl font-black text-zinc-900">Report a delivery issue</h1>
            <p class="mt-2 text-sm text-zinc-500">
                Tell us what's wrong — missing items, damage, or anything else. Our team will follow up within one business day.
            </p>
        </div>

        <form method="POST" action="{{ $submitUrl }}" class="space-y-4">
            @csrf

            <div>
                <label for="notes" class="block text-sm font-medium text-zinc-700">Describe the issue</label>
                <textarea
                    id="notes"
                    name="notes"
                    rows="5"
                    placeholder="e.g. Item arrived damaged, one unit missing from the delivery…"
                    class="mt-1.5 block w-full rounded-lg border border-zinc-300 px-3.5 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 shadow-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500"
                    required
                    maxlength="2000">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-amber-600 px-6 py-4 text-base font-semibold text-white shadow-sm transition hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                Submit dispute
            </button>
        </form>

    </div>

</body>
</html>
