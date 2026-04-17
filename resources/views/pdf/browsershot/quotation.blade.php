@extends('pdf.browsershot.layouts.main')

@section('title', 'Quotation ' . $quote->reference)

@section('content')
    @php
        $logoPath = public_path('logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }
    @endphp

    {{-- ================================================================== --}}
    {{-- HEADER                                                              --}}
    {{-- ================================================================== --}}
    <div class="px-10 py-6 flex justify-between items-start border-b border-gray-200">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 uppercase">Quotation</h1>
            <div class="flex items-center gap-2 mt-2 text-sm">
                <span class="text-gray-500">Quote No:</span>
                <span class="text-gray-900 font-semibold">#{{ $quote->reference }}</span>
            </div>
            <div class="flex items-center gap-2 mt-1 text-sm">
                <span class="text-gray-500">Date:</span>
                <span class="text-gray-900 font-semibold">{{ $quote->created_at->format('d M, Y') }}</span>
            </div>
            @if ($quote->expires_at)
                <div class="flex items-center gap-2 mt-1 text-sm">
                    <span class="text-gray-500">Valid Until:</span>
                    <span class="text-gray-900 font-semibold">{{ $quote->expires_at->format('d M, Y') }}</span>
                </div>
            @endif
        </div>

        <div class="text-right">
            @if ($logoBase64)
                <img src="{{ $logoBase64 }}" alt="Sheffield Africa" class="h-12 w-auto ml-auto">
            @else
                <div class="text-xl font-bold text-brand uppercase">SHEFFIELD</div>
            @endif
        </div>
    </div>

    {{-- ================================================================== --}}
    {{-- CUSTOMER INFO & STATUS                                             --}}
    {{-- ================================================================== --}}
    <div class="px-10 py-6 flex justify-between gap-6">
        {{-- Left: Customer Info --}}
        <div class="flex-1">
            <div class="border border-gray-300">
                <div class="px-4 py-2 bg-gray-50 border-b border-gray-300">
                    <div class="text-xs font-bold text-gray-700 uppercase">Customer Information</div>
                </div>
                <div class="p-4 space-y-2">
                    <div class="font-semibold text-sm text-gray-900">{{ $quote->customerName() }}</div>
                    @if ($quote->customerEmail())
                        <div class="text-xs text-gray-600">{{ $quote->customerEmail() }}</div>
                    @endif
                    @if ($quote->customerPhone())
                        <div class="text-xs text-gray-600">{{ $quote->customerPhone() }}</div>
                    @endif

                    @if ($quote->preferred_county || $quote->preferred_area)
                        <div class="pt-3 mt-3 border-t border-gray-200">
                            <div class="text-xs font-semibold text-gray-500 uppercase mb-1">Preferred Location</div>
                            <div class="text-xs text-gray-600">
                                {{ implode(', ', array_filter([$quote->preferred_area, $quote->preferred_county])) }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right: Quote Status & Details --}}
        <div class="flex-1">
            <div class="border border-gray-300">
                <div class="px-4 py-2 bg-gray-50 border-b border-gray-300">
                    <div class="text-xs font-bold text-gray-700 uppercase">Quote Details</div>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase">Status</div>
                        <div class="text-sm font-semibold text-gray-900 mt-0.5">
                            {{ $quote->status->label() }}
                        </div>
                    </div>
                    @if ($quote->quoted_at)
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase">Quoted On</div>
                            <div class="text-sm font-semibold text-gray-900 mt-0.5">
                                {{ $quote->quoted_at->format('d M, Y') }}
                            </div>
                        </div>
                    @endif
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase">Currency</div>
                        <div class="text-sm font-semibold text-gray-900 mt-0.5">{{ $quote->currency }}</div>
                    </div>
                    @if ($quote->expires_at)
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase">Validity</div>
                            <div class="text-sm font-semibold text-gray-900 mt-0.5">
                                {{ $quote->expires_at->diffInDays($quote->quoted_at ?? $quote->created_at) }} days
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================== --}}
    {{-- ITEMS TABLE                                                         --}}
    {{-- ================================================================== --}}
    <div class="px-10 py-6">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50">
                <tr class="border-b-2 border-gray-300">
                    <th class="py-3 ps-2 text-xs font-bold text-gray-700 uppercase text-left">#</th>
                    <th class="py-3 text-xs font-bold text-gray-700 uppercase text-left">Description</th>
                    <th class="py-3 text-xs font-bold text-gray-700 uppercase text-center">Qty</th>
                    <th class="py-3 text-xs font-bold text-gray-700 uppercase text-right">Unit Price</th>
                    @if ($quote->items->some(fn($item) => $item->hasCustomPrice()))
                        <th class="py-3 text-xs font-bold text-gray-700 uppercase text-right">Quoted Price</th>
                    @endif
                    <th class="py-3 pe-2 text-xs font-bold text-gray-700 uppercase text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quote->items as $index => $item)
                    @php
                        $name = $item->product_snapshot['name'] ?? ($item->product?->name ?? '—');
                        $sku = $item->product_snapshot['sku'] ?? '—';
                        $showQuotedPrice = $quote->items->some(fn($i) => $i->hasCustomPrice());
                    @endphp
                    <tr class="border-b border-gray-200">
                        <td class="py-3 text-xs text-gray-500">{{ $index + 1 }}</td>
                        <td class="py-3">
                            <div class="text-sm font-semibold text-gray-900">{{ $name }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $sku }}</div>
                        </td>
                        <td class="py-3 text-sm text-gray-900 text-center">{{ $item->quantity }}</td>
                        <td class="py-3 text-sm text-gray-900 text-right">
                            {{ number_format($item->original_price_cents / 100, 2) }}
                        </td>
                        @if ($showQuotedPrice)
                            <td class="py-3 text-sm font-semibold text-gray-900 text-right">
                                {{ number_format(($item->quoted_price_cents ?? $item->original_price_cents) / 100, 2) }}
                            </td>
                        @endif
                        <td class="py-3 text-sm font-semibold text-gray-900 text-right">
                            {{ number_format($item->total_cents / 100, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ================================================================== --}}
    {{-- TOTALS                                                              --}}
    {{-- ================================================================== --}}
    <div class="px-10 py-6 flex justify-end">
        <div class="w-80">
            <div class="space-y-2">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Subtotal</span>
                    <span class="font-semibold text-gray-900">{{ $quote->currency }}
                        {{ number_format($quote->subtotal_cents / 100, 2) }}</span>
                </div>
                @if ($quote->discount_cents > 0)
                    <div class="flex justify-between text-sm text-red-600">
                        <span>Discount</span>
                        <span class="font-semibold">-{{ $quote->currency }}
                            {{ number_format($quote->discount_cents / 100, 2) }}</span>
                    </div>
                @endif
                @if ($quote->shipping_cents > 0)
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Estimated Shipping</span>
                        <span class="font-semibold text-gray-900">{{ $quote->currency }}
                            {{ number_format($quote->shipping_cents / 100, 2) }}</span>
                    </div>
                @endif

                <div class="pt-3 mt-3 border-t-2 border-gray-300 flex justify-between items-center">
                    <span class="text-base font-bold text-gray-900 uppercase">Total Quote</span>
                    <span class="text-xl font-bold text-gray-900">{{ $quote->currency }}
                        {{ number_format($quote->total_cents / 100, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================== --}}
    {{-- CUSTOMER NOTES                                                      --}}
    {{-- ================================================================== --}}
    @if ($quote->customer_notes)
        <div class="px-10 py-4 border-t border-gray-200">
            <div class="text-xs font-bold text-gray-500 uppercase mb-1">Customer Notes</div>
            <div class="text-sm text-gray-600 italic">
                "{{ $quote->customer_notes }}"
            </div>
        </div>
    @endif

    {{-- ================================================================== --}}
    {{-- ADMIN NOTES                                                         --}}
    {{-- ================================================================== --}}
    @if ($quote->admin_notes)
        <div class="px-10 py-4 border-t border-gray-200">
            <div class="text-xs font-bold text-gray-500 uppercase mb-1">Terms & Conditions</div>
            <div class="text-sm text-gray-600">
                {{ $quote->admin_notes }}
            </div>
        </div>
    @endif

    {{-- ================================================================== --}}
    {{-- VALIDITY NOTICE                                                     --}}
    {{-- ================================================================== --}}
    @if ($quote->expires_at && $quote->status->value === 'sent')
        <div class="px-10 py-4 border-t border-gray-200 bg-gray-50">
            <div class="text-xs text-gray-600">
                <strong>Note:</strong> This quotation is valid until {{ $quote->expires_at->format('d M, Y') }}.
                Prices and availability are subject to change after this date.
            </div>
        </div>
    @endif
@endsection
