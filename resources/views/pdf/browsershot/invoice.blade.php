@extends('pdf.browsershot.layouts.main')

@section('title', 'Tax Invoice ' . $order->reference)

@section('content')
    @php
        $general = app(\App\Settings\GeneralSettings::class);
        $tax = app(\App\Settings\TaxSettings::class);
        $orderSettings = app(\App\Settings\OrderSettings::class);

        $logoPath = public_path('logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $stampPath = public_path('images/paid.png');
        $stampBase64 = '';
        if (file_exists($stampPath)) {
            $stampBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($stampPath));
        }

        $companyAddressLines = array_filter([
            $general->store_address,
            $general->store_address_line_2,
            trim(
                implode(', ', array_filter([$general->store_city, $general->store_state, $general->store_postal_code])),
            ),
            $general->store_country,
        ]);

        $hasTax = $order->tax_cents > 0;
        $currency = $order->currency;
        $taxRate = null;
        if ($hasTax && $order->subtotal_cents > 0) {
            $taxRate = round(($order->tax_cents / $order->subtotal_cents) * 100);
        }
    @endphp

    {{-- ================================================================== --}}
    {{-- HEADER — Company info (left) + TAX INVOICE + Date/Number (right)   --}}
    {{-- ================================================================== --}}
    <div class="px-10 pt-8 pb-3">
        <div class="flex justify-between items-start gap-6">

            {{-- LEFT: Logo stacked over contact details --}}
            <div class="flex-1">
                @if ($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="{{ $general->store_name }}" class="h-12 w-auto mb-2">
                @endif

                <div class="text-[10px] leading-snug text-gray-800">
                    @if ($general->store_tagline)
                        <div>{{ $general->store_tagline }}</div>
                    @endif
                    @foreach ($companyAddressLines as $line)
                        <div>{{ $line }}</div>
                    @endforeach
                    @if ($general->store_phone)
                        <div>Tel: {{ $general->store_phone }}</div>
                    @endif
                    @if ($general->store_email)
                        <div>Email: <span class="text-brand">{{ $general->store_email }}</span></div>
                    @endif
                </div>
            </div>

            {{-- RIGHT: TAX INVOICE + Date/Number table --}}
            <div class="text-right shrink-0">
                <div class="text-xl font-bold text-gray-900 tracking-wide mb-2">TAX INVOICE</div>
                <table class="text-xs ml-auto" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th class="border border-gray-900 px-3 py-1 font-bold text-gray-900 bg-gray-50"
                                style="text-align: center;">DATE</th>
                            <th class="border border-gray-900 px-3 py-1 font-bold text-gray-900 bg-gray-50"
                                style="text-align: center;">NUMBER</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-900 px-3 py-1 bg-white" style="text-align: center;">
                                {{ $order->created_at->format('d/m/Y') }}
                            </td>
                            <td class="border border-gray-900 px-3 py-1 bg-white" style="text-align: center;">
                                {{ $order->reference }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Thick separator --}}
    <div class="mx-10 border-t-2 border-gray-900"></div>
    <div class="mx-10 border-t border-gray-900 mt-0.5"></div>

    {{-- ================================================================== --}}
    {{-- BILLED TO + PAYMENT INFO                                           --}}
    {{-- ================================================================== --}}
    <div class="px-10 mt-5 flex gap-6 items-stretch">

        {{-- BILL TO --}}
        <div class="flex flex-col">
            <div class="text-xs font-bold text-gray-900 mb-1.5">BILLED TO:</div>
            <div class="flex-1 border border-gray-900 px-3 py-2 text-[11px] leading-snug min-w-56 max-w-xs"
                style="box-shadow: 3px 3px 0 rgba(0,0,0,0.85);">
                <div class="font-bold uppercase text-gray-900">{{ $order->customerName() }}</div>
                @if ($order->customerPhone())
                    <div>TEL: {{ $order->customerPhone() }}</div>
                @endif
                @if ($order->customerEmail())
                    <div>EMAIL: {{ $order->customerEmail() }}</div>
                @endif
                @if ($order->shipping_address)
                    <div class="uppercase mt-1">
                        {{ implode(
                            ', ',
                            array_filter([
                                $order->shipping_address['address'] ?? null,
                                $order->shipping_address['area'] ?? null,
                                $order->shipping_address['county'] ?? null,
                            ]),
                        ) }}
                    </div>
                @endif
            </div>
        </div>

        {{-- PAYMENT INFO --}}
        <div class="flex flex-col">
            <div class="text-xs font-bold text-gray-900 mb-1.5">PAYMENT INFO:</div>
            <div class="flex-1 border border-gray-900 px-3 py-2 text-[11px] leading-snug min-w-56"
                style="box-shadow: 3px 3px 0 rgba(0,0,0,0.85);">
                <div class="space-y-0.5">
                    <div>Method: {{ ucfirst($order->payment?->gateway ?? 'Online Payment') }}</div>
                    <div>Status: {{ $order->payment_status->label() }}</div>
                    @if ($order->payment?->paid_at)
                        <div>Paid: {{ $order->payment->paid_at->format('d/m/Y') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================== --}}
    {{-- ITEMS TABLE                                                         --}}
    {{-- ================================================================== --}}
    <div class="px-10 mt-5 relative">
        <table class="w-full border-collapse text-xs">
            <thead>
                <tr>
                    <th class="border border-gray-400 px-2 py-2 bg-gray-100 font-bold text-gray-900 w-12 text-left">ITEM
                    </th>
                    <th class="border border-gray-400 px-2 py-2 bg-gray-100 font-bold text-gray-900 text-center">DESCRIPTION
                    </th>
                    <th class="border border-gray-400 px-2 py-2 bg-gray-100 font-bold text-gray-900 w-20 text-right">UNIT
                        PRICE</th>
                    <th class="border border-gray-400 px-2 py-2 bg-gray-100 font-bold text-gray-900 w-12 text-center">QTY
                    </th>
                    <th class="border border-gray-400 px-2 py-2 bg-gray-100 font-bold text-gray-900 w-24 text-right">AMOUNT
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $index => $item)
                    @php
                        $name = $item->product_snapshot['name'] ?? ($item->product?->name ?? '—');
                        $sku = $item->product_snapshot['sku'] ?? null;
                        $brand = $item->product_snapshot['brand'] ?? null;
                        $variantAttrs = $item->product_snapshot['variant']['attributes'] ?? null;
                        $unitPrice = $item->unit_price_cents / 100;
                        $lineAmount = $item->total_cents / 100;
                    @endphp
                    <tr>
                        <td class="border border-gray-400 px-2 py-2 align-top text-left">{{ $index + 1 }}.</td>
                        <td class="border border-gray-400 px-2 py-2 align-top">
                            <div class="font-bold text-gray-900 underline">{{ strtoupper($name) }}</div>
                            <ul class="mt-1 ml-4 list-disc text-[11px] text-gray-800 space-y-0.5">
                                @if ($brand)
                                    <li>Brand: {{ $brand }}</li>
                                @endif
                                @if ($sku)
                                    <li>SKU: {{ $sku }}</li>
                                @endif
                                @if (is_array($variantAttrs))
                                    @foreach ($variantAttrs as $attr => $value)
                                        <li>{{ $attr }}: {{ $value }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </td>
                        <td class="border border-gray-400 px-2 py-2 align-top text-right">
                            {{ number_format($unitPrice, 2) }}
                        </td>
                        <td class="border border-gray-400 px-2 py-2 align-top text-center">{{ $item->quantity }}</td>
                        <td class="border border-gray-400 px-2 py-2 align-top text-right font-semibold">
                            {{ number_format($lineAmount, 2) }}
                        </td>
                    </tr>
                @endforeach

                {{-- Subtotal --}}
                <tr>
                    <td colspan="4" class="border border-gray-400 px-2 py-2 text-right text-gray-700">Subtotal (Excl.
                        VAT)</td>
                    <td class="border border-gray-400 px-2 py-2 text-right font-semibold">
                        {{ number_format(($order->total_cents - $order->tax_cents) / 100, 2) }}
                    </td>
                </tr>

                {{-- Tax / VAT --}}
                @if ($hasTax)
                    <tr>
                        <td colspan="4" class="border border-gray-400 px-2 py-2 text-right text-gray-700">
                            {{ $taxRate ? "{$taxRate}% " : '' }}{{ $tax->tax_name ?? 'VAT' }}
                        </td>
                        <td class="border border-gray-400 px-2 py-2 text-right">
                            {{ number_format($order->tax_cents / 100, 2) }}
                        </td>
                    </tr>
                @endif

                {{-- Shipping --}}
                @if ($order->shipping_cents > 0)
                    <tr>
                        <td colspan="4" class="border border-gray-400 px-2 py-2 text-right text-gray-700">Shipping &amp;
                            Delivery</td>
                        <td class="border border-gray-400 px-2 py-2 text-right">
                            {{ number_format($order->shipping_cents / 100, 2) }}
                        </td>
                    </tr>
                @endif

                {{-- Discount --}}
                @if ($order->discount_cents > 0)
                    <tr>
                        <td colspan="4" class="border border-gray-400 px-2 py-2 text-right text-gray-700">Discount</td>
                        <td class="border border-gray-400 px-2 py-2 text-right text-red-600">
                            -{{ number_format($order->discount_cents / 100, 2) }}
                        </td>
                    </tr>
                @endif

                {{-- Total --}}
                <tr>
                    <td colspan="4" class="border border-gray-400 px-2 py-2 text-right font-bold text-base">
                        TOTAL PAYABLE ({{ $currency }})
                    </td>
                    <td class="border border-gray-400 px-2 py-2 text-right font-bold text-base">
                        {{ number_format($order->total_cents / 100, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- VAT / PIN registration number under the table --}}
        @if ($tax->tax_registration_number ?? null)
            <div class="mt-1 text-[10px] text-gray-800 leading-snug">
                {{ strtoupper($tax->tax_name ?? 'VAT') }} REG NO. {{ $tax->tax_registration_number }}
            </div>
        @endif

        {{-- PAID stamp overlay --}}
        @if ($stampBase64 && $order->payment_status === \App\Enums\PaymentStatus::PAID)
            <img src="{{ $stampBase64 }}" alt="Paid"
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-15deg); width: 220px; opacity: 0.2; pointer-events: none;">
        @endif
    </div>

    {{-- ================================================================== --}}
    {{-- ORDER NOTES                                                         --}}
    {{-- ================================================================== --}}
    @if ($order->customer_notes)
        <div class="px-10 mt-6">
            <div class="text-[11px] text-gray-700 leading-snug whitespace-pre-line">{{ $order->customer_notes }}</div>
        </div>
    @endif

    {{-- ================================================================== --}}
    {{-- PURCHASE NOTE (invoice note)                                        --}}
    {{-- ================================================================== --}}
    @php $purchaseNote = $orderSettings->purchase_note; @endphp
    @if ($purchaseNote)
        <div class="px-10 mt-3 text-[11px] text-gray-700">
            <strong>Note:</strong> {{ $purchaseNote }}
        </div>
    @endif

    {{-- ================================================================== --}}
    {{-- SIGN-OFF                                                            --}}
    {{-- ================================================================== --}}
    <div class="px-10 mt-8 text-[11px] text-gray-700">
        <div>Best regards,</div>
        <div class="font-bold mt-0.5">Sheffield Africa</div>
    </div>

    {{-- ================================================================== --}}
    {{-- KRA QR CODE — always at the bottom, after invoice note             --}}
    {{-- ================================================================== --}}
    @if ($order->kra_cu_number)
        <div class="px-10 mt-8 flex flex-col items-center">
            <div class="w-28 h-28 bg-white p-1 border border-gray-300">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($order->kra_cu_number) }}"
                    alt="KRA QR Code" class="w-full h-full">
            </div>
            <div class="text-[10px] leading-snug text-gray-700 text-center mt-2">
                <div class="font-bold uppercase text-gray-900">KRA Compliance</div>
                <div class="font-mono font-semibold text-gray-900 mt-0.5">{{ $order->kra_cu_number }}</div>
                @if ($order->kra_validated_at)
                    <div class="text-gray-500">Validated: {{ $order->kra_validated_at->format('d M Y, H:i') }}</div>
                @endif
                <div class="text-gray-500 mt-0.5">Scan to verify with KRA</div>
            </div>
        </div>
    @endif

@endsection
