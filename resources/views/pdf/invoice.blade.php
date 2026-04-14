<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice {{ $order->reference }}</title>

    {{-- Tailwind CSS CDN for PDF generation --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
        }

        /* Custom styles that complement Tailwind */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #000000;
            line-height: 1.4;
            background: #ffffff;
        }

        .page {
            padding: 0;
            position: relative;
        }

        /* ══════════════════════════════════════════════════════════════════ */
        /* HEADER WITH BUILDING IMAGE BACKGROUND */
        /* ══════════════════════════════════════════════════════════════════ */
        .header-section {
            position: relative;
            height: 140px;
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
            border-bottom: 3px solid #000000;
            overflow: hidden;
        }

        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.85);
        }

        .header-content {
            position: relative;
            z-index: 2;
            padding: 20px 40px;
        }

        .logo-section {
            float: left;
            width: 50%;
        }

        .company-logo {
            font-size: 32px;
            font-weight: bold;
            color: #000000;
            letter-spacing: -1px;
            margin-bottom: 5px;
        }

        .company-tagline {
            font-size: 11px;
            color: #666666;
            font-style: italic;
        }

        .invoice-title-section {
            float: right;
            width: 50%;
            text-align: right;
            padding-top: 10px;
        }

        .invoice-title {
            font-size: 48px;
            font-weight: bold;
            color: #000000;
            letter-spacing: 2px;
            line-height: 1;
        }

        .invoice-copy {
            font-size: 14px;
            color: #666666;
            margin-top: 5px;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        /* ══════════════════════════════════════════════════════════════════ */
        /* MAIN CONTENT AREA */
        /* ══════════════════════════════════════════════════════════════════ */
        .content-section {
            padding: 30px 40px;
        }

        /* ══════════════════════════════════════════════════════════════════ */
        /* CUSTOMER & INVOICE INFO - TWO COLUMNS */
        /* ══════════════════════════════════════════════════════════════════ */
        .info-grid {
            width: 100%;
            margin-bottom: 25px;
            border: 2px solid #000000;
        }

        .info-grid td {
            vertical-align: top;
            padding: 15px;
        }

        .info-left {
            width: 50%;
            border-right: 2px solid #000000;
        }

        .info-right {
            width: 50%;
        }

        .info-label {
            font-size: 9px;
            font-weight: bold;
            color: #000000;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 10px;
            color: #333333;
            line-height: 1.6;
        }

        .info-value strong {
            color: #000000;
        }

        .info-row {
            margin-bottom: 8px;
        }

        .invoice-meta-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-meta-table td {
            padding: 4px 0;
            font-size: 10px;
        }

        .invoice-meta-table .meta-label {
            font-weight: bold;
            width: 140px;
            color: #000000;
        }

        .invoice-meta-table .meta-value {
            color: #333333;
        }

        /* ══════════════════════════════════════════════════════════════════ */
        /* ITEMS TABLE */
        /* ══════════════════════════════════════════════════════════════════ */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 2px solid #000000;
        }

        .items-table thead {
            background: #f0f0f0;
            border-bottom: 2px solid #000000;
        }

        .items-table thead th {
            padding: 10px 8px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: left;
            color: #000000;
            border-right: 1px solid #cccccc;
        }

        .items-table thead th:last-child {
            border-right: none;
        }

        .items-table thead th.text-center {
            text-align: center;
        }

        .items-table thead th.text-right {
            text-align: right;
        }

        .items-table tbody td {
            padding: 10px 8px;
            font-size: 10px;
            border-bottom: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
            vertical-align: top;
        }

        .items-table tbody td:last-child {
            border-right: none;
        }

        .items-table tbody tr:last-child td {
            border-bottom: none;
        }

        .item-description {
            font-weight: bold;
            color: #000000;
            margin-bottom: 2px;
        }

        .item-code {
            font-size: 9px;
            color: #666666;
        }

        .serial-info {
            font-size: 9px;
            color: #666666;
            margin-top: 4px;
        }

        .warranty-info {
            font-size: 8px;
            color: #999999;
            font-style: italic;
        }

        /* ══════════════════════════════════════════════════════════════════ */
        /* TAX DETAILS & TOTALS */
        /* ══════════════════════════════════════════════════════════════════ */
        .totals-section {
            width: 100%;
            margin-bottom: 25px;
        }

        .totals-section td {
            vertical-align: top;
        }

        .tax-details-box {
            width: 48%;
            background: #fffbf0;
            border: 1px solid #e0d5a0;
            padding: 12px;
        }

        .tax-details-title {
            font-size: 9px;
            font-weight: bold;
            color: #000000;
            text-transform: uppercase;
            margin-bottom: 8px;
            border-bottom: 1px solid #e0d5a0;
            padding-bottom: 4px;
        }

        .tax-breakdown-table {
            width: 100%;
            font-size: 9px;
        }

        .tax-breakdown-table td {
            padding: 3px 0;
        }

        .tax-breakdown-table .tax-label {
            color: #666666;
        }

        .tax-breakdown-table .tax-value {
            text-align: right;
            font-weight: bold;
            color: #000000;
        }

        .invoice-subtotal-box {
            width: 48%;
            text-align: right;
        }

        .subtotal-table {
            width: 100%;
            border-collapse: collapse;
        }

        .subtotal-table td {
            padding: 6px 10px;
            font-size: 10px;
        }

        .subtotal-table .subtotal-label {
            text-align: right;
            color: #666666;
        }

        .subtotal-table .subtotal-value {
            text-align: right;
            font-weight: bold;
            color: #000000;
            width: 120px;
        }

        .subtotal-table .total-row {
            background: #000000;
            color: #ffffff;
            font-size: 12px;
            font-weight: bold;
        }

        .subtotal-table .total-row td {
            padding: 10px;
            border-top: 2px solid #000000;
        }

        /* ══════════════════════════════════════════════════════════════════ */
        /* FOOTER WITH LOGOS */
        /* ══════════════════════════════════════════════════════════════════ */
        .footer-section {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 2px solid #cc0000;
            padding: 15px 40px;
            background: #ffffff;
        }

        .footer-logos {
            text-align: center;
            margin-bottom: 10px;
        }

        .footer-text {
            text-align: center;
            font-size: 8px;
            color: #666666;
            line-height: 1.6;
        }

        .footer-text strong {
            color: #000000;
        }

        /* ══════════════════════════════════════════════════════════════════ */
        /* PAGE 2 - CONTROL UNIT INFO */
        /* ══════════════════════════════════════════════════════════════════ */
        .page-break {
            page-break-before: always;
        }

        .cu-header {
            background: #f0f0f0;
            border: 2px solid #000000;
            padding: 12px 20px;
            text-align: center;
            margin-bottom: 25px;
        }

        .cu-header-title {
            font-size: 14px;
            font-weight: bold;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .qr-section {
            text-align: center;
            margin: 30px 0;
        }

        .qr-code {
            width: 180px;
            height: 180px;
            margin: 0 auto 15px;
            border: 2px solid #000000;
        }

        .cu-info-table {
            width: 100%;
            margin-bottom: 30px;
            font-size: 10px;
        }

        .cu-info-table td {
            padding: 6px 0;
        }

        .cu-info-table .cu-label {
            font-weight: bold;
            color: #000000;
            width: 150px;
        }

        .cu-info-table .cu-value {
            color: #333333;
        }

        .bank-details-section {
            width: 48%;
            float: left;
            margin-right: 4%;
        }

        .terms-section {
            width: 48%;
            float: right;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #000000;
            text-transform: uppercase;
            margin-bottom: 10px;
            border-bottom: 2px solid #000000;
            padding-bottom: 5px;
        }

        .bank-info {
            font-size: 9px;
            line-height: 1.8;
            color: #333333;
            margin-bottom: 15px;
        }

        .bank-info strong {
            color: #000000;
        }

        .terms-list {
            font-size: 9px;
            line-height: 1.8;
            color: #333333;
        }

        .note-box {
            background: #fffbf0;
            border: 1px solid #e0d5a0;
            padding: 10px;
            margin-top: 20px;
            font-size: 9px;
            color: #666666;
            text-align: center;
        }

        .note-box strong {
            color: #000000;
        }

        /* ══════════════════════════════════════════════════════════════════ */
        /* PAID STAMP */
        /* ══════════════════════════════════════════════════════════════════ */
        .paid-stamp {
            position: absolute;
            top: 50px;
            right: 50px;
            border: 4px solid #16a34a;
            color: #16a34a;
            background: rgba(22, 163, 74, 0.1);
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            padding: 8px 20px;
            transform: rotate(-15deg);
            z-index: 10;
        }
    </style>
</head>

<body>
    {{-- ═══════════════════════════════════════════════════════════════════════ --}}
    {{-- PAGE 1: INVOICE DETAILS --}}
    {{-- ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="page">
        {{-- PAID STAMP --}}
        <div class="paid-stamp">PAID</div>

        {{-- HEADER --}}
        <div class="header-section">
            <div class="header-overlay"></div>
            <div class="header-content clearfix">
                <div class="logo-section">
                    <div class="company-logo">SHEFFIELD</div>
                    <div class="company-tagline">Driven. Trusted. Delivered.</div>
                </div>
                <div class="invoice-title-section">
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-copy">Copy</div>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="content-section">
            {{-- CUSTOMER & INVOICE INFO GRID --}}
            <table class="info-grid">
                <tr>
                    <td class="info-left">
                        <div class="info-label">Customer</div>
                        <div class="info-value">
                            <strong>{{ $order->user ? 'CLO' . str_pad($order->user->id, 4, '0', STR_PAD_LEFT) : 'GUEST' }}</strong>
                        </div>
                        <div class="info-value" style="margin-top: 8px;">
                            <strong>{{ strtoupper($order->customerName()) }}</strong>
                        </div>
                        <div class="info-value" style="margin-top: 8px;">
                            {{ $order->billing_address['address'] ?? 'N/A' }}<br>
                            @if ($order->billing_address['area'] ?? null)
                                {{ $order->billing_address['area'] }},
                            @endif
                            {{ $order->billing_address['county'] ?? '' }}<br>
                            <strong>KENYA</strong>
                        </div>

                        <div style="margin-top: 15px;">
                            <div class="info-label">Customer Email:</div>
                            <div class="info-value">{{ $order->customerEmail() ?: 'N/A' }}</div>
                        </div>

                        <div style="margin-top: 10px;">
                            <div class="info-label">Customer Phone:</div>
                            <div class="info-value">{{ $order->customerPhone() ?: 'N/A' }}</div>
                        </div>

                        <div style="margin-top: 10px;">
                            <div class="info-label">Delivery Address</div>
                            <div class="info-value">
                                {{ strtoupper($order->shipping_address['full_name'] ?? $order->customerName()) }}<br>
                                {{ $order->shipping_address['address'] ?? ($order->billing_address['address'] ?? 'N/A') }}
                                @if ($order->shipping_address['area'] ?? null)
                                    <br>{{ $order->shipping_address['area'] }},
                                    {{ $order->shipping_address['county'] ?? '' }}
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="info-right">
                        <table class="invoice-meta-table">
                            <tr>
                                <td class="meta-label">Invoice Number:</td>
                                <td class="meta-value">{{ str_replace('SO-', 'SALINV', $order->reference) }}</td>
                            </tr>
                            <tr>
                                <td class="meta-label">Invoice Date:</td>
                                <td class="meta-value">{{ $order->created_at->format('d/m/y') }}</td>
                            </tr>
                            <tr>
                                <td class="meta-label">Order Reference:</td>
                                <td class="meta-value">{{ $order->reference }}</td>
                            </tr>
                            @if ($order->wasConvertedFromQuote() && $order->quote)
                                <tr>
                                    <td class="meta-label">Quote Ref Number:</td>
                                    <td class="meta-value">{{ $order->quote->reference }}</td>
                                </tr>
                            @endif
                            @if ($order->customer_notes)
                                <tr>
                                    <td class="meta-label">Customer Notes:</td>
                                    <td class="meta-value">{{ Str::limit($order->customer_notes, 50) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="meta-label" style="padding-top: 15px; color: #16a34a;">
                                    <strong>Payment Date:</strong>
                                </td>
                                <td class="meta-value" style="padding-top: 15px; color: #16a34a;">
                                    <strong>{{ $order->payment?->paid_at?->format('d/m/y H:i') ?? $order->created_at->format('d/m/y H:i') }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="meta-label">Payment Method:</td>
                                <td class="meta-value">{{ strtoupper($order->payment?->gateway ?? 'N/A') }}</td>
                            </tr>
                            @if ($order->payment?->transaction_id)
                                <tr>
                                    <td class="meta-label">Transaction ID:</td>
                                    <td class="meta-value">{{ $order->payment->transaction_id }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="meta-label" style="padding-top: 15px;">VAT NO:</td>
                                <td class="meta-value" style="padding-top: 15px;">
                                    <strong>0127183D</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="meta-label">Company PIN:</td>
                                <td class="meta-value">
                                    <strong>P051148391Z</strong>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            {{-- ITEMS TABLE --}}
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 40%;">Description</th>
                        <th class="text-center" style="width: 10%;">Quantity</th>
                        <th style="width: 10%;">Unit</th>
                        <th class="text-right" style="width: 15%;">Price</th>
                        <th class="text-right" style="width: 10%;">Tax %</th>
                        <th class="text-right" style="width: 15%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $index => $item)
                        @php
                            $name = $item->product_snapshot['name'] ?? ($item->product?->name ?? '—');
                            $sku = $item->product_snapshot['sku'] ?? '—';
                            $brand = $item->product_snapshot['brand'] ?? null;
                        @endphp
                        <tr>
                            <td>{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="item-description">{{ $name }}</div>
                                <div class="item-code">Item Code: {{ $sku }}</div>
                                @if ($brand)
                                    <div class="item-code">Brand: {{ $brand }}</div>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td>{{ $item->uom ?? 'PCS' }}</td>
                            <td class="text-right">{{ number_format($item->unit_price_cents / 100, 2) }}</td>
                            <td class="text-right">16.00</td>
                            <td class="text-right">
                                <strong>{{ number_format($item->total_cents / 100, 2) }}</strong>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- TAX DETAILS & TOTALS --}}
            <table class="totals-section">
                <tr>
                    <td style="width: 48%;">
                        <div class="tax-details-box">
                            <div class="tax-details-title">Tax Details</div>
                            <table class="tax-breakdown-table">
                                @php
                                    $vatAmount = ($order->total * 16) / 116;
                                    $netAmount = $order->total - $vatAmount;
                                @endphp
                                <tr>
                                    <td class="tax-label">Tax %</td>
                                    <td class="tax-value">Net</td>
                                    <td class="tax-value">Tax</td>
                                    <td class="tax-value">Gross</td>
                                </tr>
                                <tr>
                                    <td class="tax-label">16.00</td>
                                    <td class="tax-value">{{ number_format($netAmount, 2) }}</td>
                                    <td class="tax-value">{{ number_format($vatAmount, 2) }}</td>
                                    <td class="tax-value">{{ number_format($order->total, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td style="width: 4%;"></td>
                    <td style="width: 48%;">
                        <div class="invoice-subtotal-box">
                            <table class="subtotal-table">
                                <tr>
                                    <td class="subtotal-label">Invoice Subtotal:</td>
                                    <td class="subtotal-value">KES {{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="subtotal-label">Total before Tax:</td>
                                    <td class="subtotal-value">KES {{ number_format($netAmount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="subtotal-label">Total Tax Amount:</td>
                                    <td class="subtotal-value">KES {{ number_format($vatAmount, 2) }}</td>
                                </tr>
                                @if ($order->shipping > 0)
                                    <tr>
                                        <td class="subtotal-label">Shipping Type:</td>
                                        <td class="subtotal-value">
                                            {{ $order->shipping_snapshot['method_name'] ?? 'Standard' }}</td>
                                    </tr>
                                @endif
                                <tr class="total-row">
                                    <td>Total Amount Paid</td>
                                    <td>KES {{ number_format($order->total, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            {{-- PAYMENT CONFIRMATION BOX --}}
            <div
                style="background: #f0fdf4; border: 2px solid #16a34a; padding: 15px; margin-bottom: 25px; text-align: center;">
                <div style="font-size: 11px; font-weight: bold; color: #16a34a; margin-bottom: 5px;">
                    ✓ PAYMENT CONFIRMED
                </div>
                <div style="font-size: 9px; color: #166534;">
                    Payment of <strong>KES {{ number_format($order->total, 2) }}</strong> received on
                    <strong>{{ $order->payment?->paid_at?->format('d M Y \a\t H:i') ?? $order->created_at->format('d M Y \a\t H:i') }}</strong>
                    via <strong>{{ strtoupper($order->payment?->gateway ?? 'N/A') }}</strong>
                    @if ($order->payment?->transaction_id)
                        <br>Transaction ID: <strong>{{ $order->payment->transaction_id }}</strong>
                    @endif
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="footer-section">
            <div class="footer-logos">
                <!-- Placeholder for certification logos -->
                <span style="font-size: 8px; color: #999999;">[CERTIFICATION LOGOS]</span>
            </div>
            <div class="footer-text">
                <strong>SHEFFIELD STEEL SYSTEMS LIMITED</strong> Off Old Mombasa Road, Opposite Hilton Garden Inn,
                Before Standard Gauge Railway (SGR), P.O. Box 29-00606, Nairobi, Kenya.<br>
                Tel: +254 713 444 000 / +254 713 777 111, Email: control@sheffieldafrica.com
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════ --}}
    {{-- PAGE 2: CONTROL UNIT INFO & PAYMENT DETAILS --}}
    {{-- ═══════════════════════════════════════════════════════════════════════ --}}
    @if ($order->kra_cu_number)
        <div class="page page-break">
            <div class="content-section" style="padding-top: 40px;">
                {{-- BLENDERS INFO --}}
                <div style="background: #f0f0f0; padding: 10px; text-align: center; margin-bottom: 25px;">
                    <span style="font-size: 9px; color: #666666;">
                        BLENDERS Based On Sales Quotations
                        {{ $order->wasConvertedFromQuote() && $order->quote ? $order->quote->id : $order->id }},
                        Based on Sales Orders {{ $order->id }}.
                    </span>
                </div>

                {{-- CONTROL UNIT INFO HEADER --}}
                <div class="cu-header">
                    <div class="cu-header-title">Control Unit Info</div>
                </div>

                {{-- QR CODE --}}
                <div class="qr-section">
                    <div class="qr-code"
                        style="background: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                        {{-- QR Code would be generated here --}}
                        <span style="font-size: 10px; color: #999999;">[QR CODE]</span>
                    </div>
                </div>

                {{-- CU DETAILS --}}
                <table class="cu-info-table">
                    <tr>
                        <td class="cu-label">CU Invoice No:</td>
                        <td class="cu-value">{{ $order->kra_cu_number }}</td>
                    </tr>
                    <tr>
                        <td class="cu-label">CU Date & Time:</td>
                        <td class="cu-value">
                            {{ $order->kra_validated_at ? $order->kra_validated_at->format('d/m/Y H:i:s') : now()->format('d/m/Y H:i:s') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="cu-label">CU Serial No:</td>
                        <td class="cu-value">KRAMVR11202260539655</td>
                    </tr>
                </table>

                {{-- BANK DETAILS & TERMS --}}
                <div class="clearfix">
                    <div class="bank-details-section">
                        <div class="section-title">Bank Details:</div>

                        <div class="bank-info">
                            <strong>Bank of India Kenya</strong><br>
                            Industrial Area Branch, Nairobi<br>
                            Swift Code: <strong>BKIDKENAXXX</strong><br>
                            KES A/C: <strong>0022522700004001</strong>
                        </div>

                        <div class="bank-info">
                            <strong>Kenya Commercial Bank</strong><br>
                            Industrial Area Branch, Nairobi<br>
                            SWIFT CODE: <strong>KCBLKENX</strong><br>
                            KES A/C: <strong>1128266994</strong>
                        </div>

                        <div class="section-title" style="margin-top: 20px;">MPESA Details:</div>
                        <div class="bank-info">
                            <strong>PAYBILL NUMBER:</strong><br>
                            522522
                        </div>
                        <div class="bank-info">
                            <strong>ACCOUNT NUMBER:</strong><br>
                            1128266994
                        </div>

                        <div class="note-box">
                            <strong>NOTE: Please email proof of payment to<br>
                                creditcontroller@sheffieldafrica.com</strong>
                        </div>
                    </div>

                    <div class="terms-section">
                        <div class="section-title">Terms and Conditions of Sale:</div>
                        <div class="terms-list">
                            - Sheffield does not accept cash payments. All payments must be made through approved mobile
                            money or bank channels.<br><br>

                            - All accounts are net and payable according to the agreed on payment terms.<br><br>

                            - Returned goods may be accepted only at our discretion and should be made within 14 days
                            from the date of invoice and delivery.<br><br>

                            - The goods remain the property of Sheffield Steel Systems Limited until the full and final
                            payment is received.
                        </div>
                    </div>
                </div>

                <div
                    style="margin-top: 40px; text-align: center; font-style: italic; font-size: 10px; color: #666666;">
                    Serving you is our delight. Thank you for your business!
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="footer-section">
                <div class="footer-logos">
                    <span style="font-size: 8px; color: #999999;">[CERTIFICATION LOGOS]</span>
                </div>
                <div class="footer-text">
                    <strong>SHEFFIELD STEEL SYSTEMS LIMITED</strong> Off Old Mombasa Road, Opposite Hilton Garden Inn,
                    Before Standard Gauge Railway (SGR), P.O. Box 29-00606, Nairobi, Kenya.<br>
                    Tel: +254 713 444 000 / +254 713 777 111, Email: control@sheffieldafrica.com
                </div>
            </div>
        </div>
    @endif
</body>

</html>
