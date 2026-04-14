<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice {{ $order->reference }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 10px;
            line-height: 1.4;
        }

        .page-break {
            page-break-before: always;
        }

        .rubber_stamp {
            font-family: 'Vollkorn', serif;
            font-size: 39px;
            line-height: 45px;
            text-transform: uppercase;
            font-weight: bold;
            color: rgb(0, 255, 136);
            border: 7px solid rgb(0, 255, 106);
            float: left;
            padding: 10px 32px;
            border-radius: 10px;

            opacity: 0.8;
            -webkit-transform: rotate(-10deg);
            -o-transform: rotate(-10deg);
            -moz-transform: rotate(-10deg);
            -ms-transform: rotate(-10deg);
            position: absolute;
            top: 32%;
        }

        .rubber_stamp::after {
            position: absolute;
            content: " ";
            width: 100%;
            height: auto;
            min-height: 100%;
            top: -10px;
            left: -10px;
            padding: 10px;
            background: url(https://raw.github.com/domenicosolazzo/css3/master/img/noise.png) repeat;
        }
    </style>
</head>

<body class="bg-white text-black">
    {{-- ═══════════════════════════════════════════════════════════════════════ --}}
    {{-- PAGE 1: INVOICE --}}
    {{-- ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="relative">
        {{-- HEADER WITH BUILDING IMAGE BACKGROUND --}}
        <div class="relative h-36 overflow-hidden rounded-t-xl">

            {{-- Background Image --}}
            <div class="absolute inset-0 bg-cover bg-center opacity-30"
                style="background-image: url('{{ asset('images/sheffield_gray_scale.jpg') }}')">
            </div>

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-linear-to-r from-white/90 via-white/70 to-white/40"></div>

            <div class="rubber_stamp absolute top-4 right-20 rotate-12 z-20">PAID</div>

            {{-- Content --}}
            <div class="relative z-10 flex justify-between items-center h-full px-8">

                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo.png') }}" alt="Sheffield Logo" class="h-12 w-auto">
                </div>

                {{-- Invoice Title --}}
                <div class="text-right">
                    <div class="text-4xl font-extrabold tracking-wider text-gray-800">
                        INVOICE
                    </div>
                </div>

            </div>
        </div>

        {{-- CUSTOMER & INVOICE INFO GRID --}}
        <div class="flex justify-between gap-6 px-8 py-6">
            {{-- Left: Customer Info --}}
            <div class="border-2 border-black flex flex-col w-full max-w-72">
                {{-- Customer Header --}}
                <div class="border-b-2 border-black px-3 py-1.5 bg-white">
                    <span class="font-bold text-xs">CUSTOMER</span>
                </div>

                {{-- Customer Name & Address --}}
                <div class="px-3 py-3 border-b border-black min-h-24">
                    <div class="font-bold text-sm mb-1">{{ strtoupper($order->customerName()) }}</div>
                    <div class="text-xs text-gray-700">
                        {{ $order->billing_address['address'] ?? 'N/A' }}<br>
                        @if ($order->billing_address['area'] ?? null)
                            {{ $order->billing_address['area'] }},
                        @endif
                        {{ $order->billing_address['county'] ?? '' }}<br>
                        <span class="font-bold">KENYA</span>
                    </div>
                </div>

                {{-- Customer Email --}}
                <div class="border-b border-black px-3 py-1.5 flex justify-between text-xs">
                    <span class="font-bold">Customer Email:</span>
                    <span>{{ $order->customerEmail() ?: 'N/A' }}</span>
                </div>

                {{-- Customer Phone --}}
                <div class="border-b border-black px-3 py-1.5 flex justify-between text-xs">
                    <span class="font-bold">Customer Phone:</span>
                    <span>{{ $order->customerPhone() ?: 'N/A' }}</span>
                </div>

                {{-- Delivery Address --}}
                <div class="px-3 py-2 grow">
                    <div class="font-bold text-xs mb-1">Delivery Address</div>
                    <div class="text-xs text-gray-700">
                        {{ strtoupper($order->shipping_address['full_name'] ?? $order->customerName()) }}<br>
                        @if ($order->shipping_address['phone_number'] ?? null)
                            {{ $order->shipping_address['phone_number'] }}<br>
                        @endif
                        {{ $order->shipping_address['address'] ?? ($order->billing_address['address'] ?? 'N/A') }}<br>
                        @if ($order->shipping_address['area'] ?? null)
                            {{ $order->shipping_address['area'] }},
                        @endif
                        {{ $order->shipping_address['county'] ?? ($order->billing_address['county'] ?? '') }}<br>
                        <span class="font-bold">KENYA</span>
                    </div>
                </div>
            </div>

            {{-- Right: Invoice Meta --}}
            <div class="border-2 border-black flex flex-col w-fit">
                <table class="w-full text-xs grow">
                    <tr class="border-b border-black">
                        <td class="px-3 py-1.5 font-bold border-r border-black bg-white w-1/2">Invoice Number:</td>
                        <td class="px-3 py-1.5 text-right w-1/2">{{ str_replace('SO-', 'SALINV', $order->reference) }}
                        </td>
                    </tr>
                    <tr class="border-b border-black">
                        <td class="px-3 py-1.5 font-bold border-r border-black bg-white">Invoice Date:</td>
                        <td class="px-3 py-1.5 text-right">{{ $order->created_at->format('d/m/y') }}</td>
                    </tr>
                    <tr class="border-b border-black">
                        <td class="px-3 py-1.5 font-bold border-r border-black bg-white">Order Reference:</td>
                        <td class="px-3 py-1.5 text-right">{{ $order->reference }}</td>
                    </tr>
                    @if ($order->sap_doc_number)
                        <tr class="border-b border-black">
                            <td class="px-3 py-1.5 font-bold border-r border-black bg-white">SAP Doc Number:</td>
                            <td class="px-3 py-1.5 text-right">{{ $order->sap_doc_number }}</td>
                        </tr>
                    @endif
                    @if ($order->wasConvertedFromQuote() && $order->quote)
                        <tr class="border-b border-black">
                            <td class="px-3 py-1.5 font-bold border-r border-black bg-white">Quote Ref Number:</td>
                            <td class="px-3 py-1.5 text-right">{{ $order->quote->reference }}</td>
                        </tr>
                    @endif
                    @if ($order->customer_notes)
                        <tr class="border-b border-black">
                            <td class="px-3 py-1.5 font-bold border-r border-black bg-white">Customer Notes:</td>
                            <td class="px-3 py-1.5 text-right text-xs">{{ Str::limit($order->customer_notes, 30) }}
                            </td>
                        </tr>
                    @endif
                    <tr class="border-b border-black">
                        <td class="px-3 py-1.5 font-bold border-r border-black bg-white">Payment Method:</td>
                        <td class="px-3 py-1.5 text-right">{{ strtoupper($order->payment?->gateway ?? 'N/A') }}</td>
                    </tr>
                    @if ($order->payment?->transaction_id)
                        <tr class="border-b border-black">
                            <td class="px-3 py-1.5 font-bold border-r border-black bg-white">Transaction ID:</td>
                            <td class="px-3 py-1.5 text-right text-xs">
                                {{ Str::limit($order->payment->transaction_id, 20) }}</td>
                        </tr>
                    @endif
                    @if ($order->payment?->paid_at)
                        <tr class="border-b border-black">
                            <td class="px-3 py-1.5 font-bold border-r border-black bg-white">Payment Date:</td>
                            <td class="px-3 py-1.5 text-right">{{ $order->payment->paid_at->format('d/m/y H:i') }}</td>
                        </tr>
                    @endif
                    @if ($order->tracking_number)
                        <tr class="border-b border-black">
                            <td class="px-3 py-1.5 font-bold border-r border-black bg-white">Tracking Number:</td>
                            <td class="px-3 py-1.5 text-right text-xs">{{ $order->tracking_number }}</td>
                        </tr>
                    @endif
                    @if ($order->courier_name)
                        <tr class="border-b border-black">
                            <td class="px-3 py-1.5 font-bold border-r border-black bg-white">Courier:</td>
                            <td class="px-3 py-1.5 text-right">{{ $order->courier_name }}</td>
                        </tr>
                    @endif
                    <tr class="border-b border-black">
                        <td class="px-3 py-1.5 font-bold border-r border-black bg-white">VAT NO:</td>
                        <td class="px-3 py-1.5 text-right font-bold">0127183D</td>
                    </tr>
                    <tr>
                        <td class="px-3 py-1.5 font-bold border-r border-black bg-white">Company PIN:</td>
                        <td class="px-3 py-1.5 text-right font-bold">P051148391Z</td>
                    </tr>
                </table>

                {{-- Currency in bottom right --}}
                <div class="text-right px-3 py-1 text-xs text-gray-500">
                    Currency: <span class="font-bold">KES</span>
                </div>
            </div>
        </div>

        {{-- ITEMS TABLE --}}
        <div class="px-8 pb-4">
            <table class="w-full border-collapse border-t-2 border-b-2 border-blue-900">
                <thead>
                    <tr class="bg-white border-b border-blue-900">
                        <th class="text-left px-2 py-2 text-xs font-bold border-r border-gray-300">#</th>
                        <th class="text-left px-2 py-2 text-xs font-bold border-r border-gray-300">Description</th>
                        <th class="text-center px-2 py-2 text-xs font-bold border-r border-gray-300">Quantity</th>
                        <th class="text-center px-2 py-2 text-xs font-bold border-r border-gray-300">Unit</th>
                        <th class="text-right px-2 py-2 text-xs font-bold border-r border-gray-300">Price</th>
                        <th class="text-right px-2 py-2 text-xs font-bold border-r border-gray-300">Tax %</th>
                        <th class="text-right px-2 py-2 text-xs font-bold">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $index => $item)
                        @php
                            $name = $item->product_snapshot['name'] ?? ($item->product?->name ?? '—');
                            $sku = $item->product_snapshot['sku'] ?? '—';
                            $brand = $item->product_snapshot['brand'] ?? null;
                            $variant = $item->product_snapshot['variant'] ?? null;
                            // Calculate tax percentage from unit_tax_cents and unit_price_cents
                            $taxPercentage =
                                $item->unit_price_cents > 0
                                    ? ($item->unit_tax_cents / $item->unit_price_cents) * 100
                                    : 16.0;
                        @endphp
                        {{-- Main item row --}}
                        <tr class="border-b border-gray-200">
                            <td class="px-2 py-2 text-xs text-gray-500 align-top">
                                {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-2 py-2 text-xs align-top">
                                <div class="font-bold">{{ strtoupper($name) }}</div>
                                <div class="text-gray-600 mt-0.5">Item Code: <span
                                        class="text-gray-700">{{ $sku }}</span></div>
                                @if ($variant && isset($variant['attributes']))
                                    <div class="text-gray-500 text-xs mt-0.5">
                                        {{ collect($variant['attributes'])->map(fn($v, $k) => "$k: $v")->join(', ') }}
                                    </div>
                                @endif
                                @if ($brand)
                                    <div class="text-gray-500 text-xs">Brand: {{ $brand }}</div>
                                @endif
                            </td>
                            <td class="px-2 py-2 text-xs text-center align-top">{{ $item->quantity }}</td>
                            <td class="px-2 py-2 text-xs text-center align-top">{{ $item->uom ?? 'PCS' }}</td>
                            <td class="px-2 py-2 text-xs text-right align-top">
                                {{ number_format($item->unit_price_cents / 100, 2) }}</td>
                            <td class="px-2 py-2 text-xs text-right align-top">{{ number_format($taxPercentage, 2) }}
                            </td>
                            <td class="px-2 py-2 text-xs text-right align-top font-bold">
                                {{ number_format($item->total_cents / 100, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- TAX DETAILS & TOTALS --}}
        <div class="px-8 pb-6">
            <div class="grid grid-cols-2 gap-6">
                {{-- Tax Details --}}
                <div>
                    <div class="bg-gray-100 border border-gray-400 px-3 py-1.5 mb-2">
                        <span class="font-bold text-xs">Tax Details</span>
                    </div>
                    <table class="w-full text-xs border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 border-b border-gray-300">
                                <th class="px-2 py-1 text-left font-bold">Tax %</th>
                                <th class="px-2 py-1 text-right font-bold">Net</th>
                                <th class="px-2 py-1 text-right font-bold">Tax</th>
                                <th class="px-2 py-1 text-right font-bold">Gross</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Use actual tax from order
                                $taxAmount = $order->tax_cents / 100;
                                $netAmount = $order->subtotal;
                                $grossAmount = $order->total;
                                // Calculate tax percentage
                                $taxPercentage = $netAmount > 0 ? ($taxAmount / $netAmount) * 100 : 16.0;
                            @endphp
                            <tr>
                                <td class="px-2 py-1">{{ number_format($taxPercentage, 2) }}</td>
                                <td class="px-2 py-1 text-right">{{ number_format($netAmount, 2) }}</td>
                                <td class="px-2 py-1 text-right">{{ number_format($taxAmount, 2) }}</td>
                                <td class="px-2 py-1 text-right">{{ number_format($grossAmount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- Additional Expenses --}}
                    <div class="mt-3">
                        <div class="bg-gray-100 border border-gray-400 px-3 py-1.5 mb-2">
                            <span class="font-bold text-xs">Additional Expenses</span>
                        </div>
                        <div class="text-xs">
                            <div class="flex justify-between py-1">
                                <span>Shipping Type:</span>
                                <span
                                    class="font-bold">{{ $order->shipping_snapshot['method_name'] ?? 'Standard' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Totals --}}
                <div>
                    @php
                        $taxAmount = $order->tax_cents / 100;
                        $netAmount = $order->subtotal;
                    @endphp
                    <table class="w-full text-xs">
                        <tr class="border-b border-gray-300">
                            <td class="px-3 py-2 text-right">Invoice Subtotal:</td>
                            <td class="px-3 py-2 text-right font-bold">KES {{ number_format($order->subtotal, 2) }}
                            </td>
                        </tr>
                        @if ($order->discount > 0)
                            <tr class="border-b border-gray-300">
                                <td class="px-3 py-2 text-right">Discount:</td>
                                <td class="px-3 py-2 text-right font-bold text-green-600">-KES
                                    {{ number_format($order->discount, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if ($order->shipping > 0)
                            <tr class="border-b border-gray-300">
                                <td class="px-3 py-2 text-right">Shipping:</td>
                                <td class="px-3 py-2 text-right font-bold">KES
                                    {{ number_format($order->shipping, 2) }}
                                </td>
                            </tr>
                        @endif
                        <tr class="border-b border-gray-300">
                            <td class="px-3 py-2 text-right">Total before Tax:</td>
                            <td class="px-3 py-2 text-right font-bold">KES {{ number_format($netAmount, 2) }}</td>
                        </tr>
                        <tr class="border-b-2 border-gray-400">
                            <td class="px-3 py-2 text-right">Total Tax Amount:</td>
                            <td class="px-3 py-2 text-right font-bold">KES {{ number_format($taxAmount, 2) }}</td>
                        </tr>
                        <tr class="bg-gray-300">
                            <td class="px-3 py-3 text-right font-bold text-base">Total Amount Paid</td>
                            <td class="px-3 py-3 text-right font-bold text-base">KES
                                {{ number_format($order->total, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- FOOTER WITH LOGOS --}}
        <div class="border-t-2 border-red-600 px-8 py-4">
            <div class="flex justify-center items-center gap-4 mb-3">
                {{-- Placeholder for certification logos --}}
                <div class="text-xs text-gray-400">[CERTIFICATION LOGOS]</div>
            </div>
            <div class="text-center text-xs text-gray-600 leading-relaxed">
                <span class="font-bold">SHEFFIELD STEEL SYSTEMS LIMITED</span> Off Old Mombasa Road, Opposite Hilton
                Garden Inn, Before Standard Gauge Railway (SGR), P.O. Box 29-00606, Nairobi, Kenya.<br>
                Tel: +254 713 444 000 / +254 713 777 111, Email: control@sheffieldafrica.com
            </div>
            <div class="text-center text-xs text-gray-400 mt-2">1</div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════ --}}
    {{-- PAGE 2: CONTROL UNIT INFO --}}
    {{-- ═══════════════════════════════════════════════════════════════════════ --}}
    @if ($order->kra_cu_number)
        <div class="page-break">
            <div class="px-8 py-8">
                {{-- BLENDERS INFO --}}
                <div class="bg-gray-100 px-4 py-2 mb-6 text-xs text-gray-700">
                    BLENDERS Based On Sales Quotations
                    {{ $order->wasConvertedFromQuote() && $order->quote ? $order->quote->id : $order->id }}, Based on
                    Sales Orders {{ $order->id }}.
                </div>

                {{-- CONTROL UNIT INFO HEADER --}}
                <div class="text-center mb-6">
                    <div class="inline-block border-t-4 border-b-4 border-black px-20 py-2">
                        <div class="font-bold text-sm tracking-wider">CONTROL UNIT INFO</div>
                    </div>
                </div>

                {{-- QR CODE --}}
                <div class="flex justify-center mb-6">
                    <div class="w-40 h-40 border-2 border-black bg-white flex items-center justify-center">
                        <span class="text-xs text-gray-400">[QR CODE]</span>
                    </div>
                </div>

                {{-- CU DETAILS --}}
                <div class="mb-8 text-xs max-w-md mx-auto">
                    <div class="flex py-2">
                        <span class="w-40 font-bold">CU Invoice No:</span>
                        <span>{{ $order->kra_cu_number }}</span>
                    </div>
                    <div class="flex py-2">
                        <span class="w-40 font-bold">CU Date & Time:</span>
                        <span>{{ $order->kra_validated_at ? $order->kra_validated_at->format('d/m/Y H:i:s') : now()->format('d/m/Y H:i:s') }}</span>
                    </div>
                    <div class="flex py-2">
                        <span class="w-40 font-bold">CU Serial No:</span>
                        <span>KRAMVR11202260539655</span>
                    </div>
                </div>

                {{-- BANK DETAILS & TERMS --}}
                <div class="grid grid-cols-2 gap-8 mb-8">
                    {{-- Bank Details --}}
                    <div>
                        <div class="font-bold text-sm mb-3">Bank Details:</div>
                        <div class="text-xs space-y-3">
                            <div>
                                <div class="font-bold">Bank of India Kenya</div>
                                <div>Industrial Area Branch, Nairobi</div>
                                <div>Swift Code: <span class="font-bold">BKIDKENAXXX</span></div>
                                <div>KES A/C: <span class="font-bold">0022522700004001</span></div>
                            </div>

                            <div>
                                <div class="font-bold">Kenya Commercial Bank</div>
                                <div>Industrial Area Branch, Nairobi</div>
                                <div>SWIFT CODE: <span class="font-bold">KCBLKENX</span></div>
                                <div>KES A/C: <span class="font-bold">1128266994</span></div>
                            </div>
                        </div>

                        <div class="font-bold text-sm mt-4 mb-2">MPESA Details:</div>
                        <div class="text-xs space-y-1">
                            <div><span class="font-bold">PAYBILL NUMBER:</span><br>522522</div>
                            <div><span class="font-bold">ACCOUNT NUMBER:</span><br>1128266994</div>
                        </div>
                    </div>

                    {{-- Terms --}}
                    <div>
                        <div class="font-bold text-sm mb-3">Terms and Conditions of Sale:</div>
                        <div class="text-xs space-y-2 leading-relaxed">
                            <p>- Sheffield does not accept cash payments. All payments must be made through approved
                                mobile money or bank channels.</p>
                            <p>- All accounts are net and payable according to the agreed on payment terms.</p>
                            <p>- Returned goods may be accepted only at our discretion and should be made within 14 days
                                from the date of invoice and delivery.</p>
                            <p>- The goods remain the property of Sheffield Steel Systems Limited until the full and
                                final payment is received.</p>
                        </div>
                    </div>
                </div>

                <div class="text-center text-sm italic text-gray-600 mb-8">
                    Serving you is our delight. Thank you for your business!
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="border-t-2 border-red-600 px-8 py-4">
                <div class="flex justify-center items-center gap-4 mb-3">
                    <div class="text-xs text-gray-400">[CERTIFICATION LOGOS]</div>
                </div>
                <div class="text-center text-xs text-gray-600 leading-relaxed">
                    <span class="font-bold">SHEFFIELD STEEL SYSTEMS LIMITED</span> Off Old Mombasa Road, Opposite
                    Hilton Garden Inn, Before Standard Gauge Railway (SGR), P.O. Box 29-00606, Nairobi, Kenya.<br>
                    Tel: +254 713 444 000 / +254 713 777 111, Email: control@sheffieldafrica.com
                </div>
                <div class="text-center text-xs text-gray-400 mt-2">2</div>
            </div>
        </div>
    @endif
</body>

</html>
