<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #333; }
        .header { padding: 20px 20px 12px; border-bottom: 2px solid #e5e7eb; margin-bottom: 16px; }
        .header h1 { font-size: 18px; font-weight: 700; color: #111; }
        .header p { color: #6b7280; font-size: 10px; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #f3f4f6; }
        th { padding: 8px 10px; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #d1d5db; white-space: nowrap; }
        td { padding: 7px 10px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        tr:nth-child(even) td { background: #fafafa; }
        .sku { font-family: monospace; color: #6b7280; font-size: 9px; }
        .muted { color: #6b7280; font-size: 9px; }
        .price { font-weight: 600; text-align: right; white-space: nowrap; }
        .sale { color: #059669; font-size: 9px; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 9999px; font-size: 9px; font-weight: 500; }
        .badge-green { background: #d1fae5; color: #065f46; }
        .badge-red { background: #fee2e2; color: #991b1b; }
        .badge-yellow { background: #fef3c7; color: #92400e; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-zinc { background: #f4f4f5; color: #3f3f46; }
        .footer { margin-top: 16px; padding-top: 8px; border-top: 1px solid #e5e7eb; text-align: right; color: #9ca3af; font-size: 9px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Product Catalog</h1>
        <p>Generated {{ now()->format('d M Y, H:i') }} &bull; {{ $products->count() }} product(s)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Brand / Category</th>
                <th style="text-align:right">Price (KES)</th>
                <th>Stock</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>
                        <strong>{{ $product->name }}</strong>
                        @if ($product->sku)
                            <br><span class="sku">{{ $product->sku }}</span>
                        @endif
                    </td>
                    <td>
                        @if ($product->brand)
                            <span>{{ $product->brand->name }}</span>
                        @endif
                        @if ($product->primaryCategory)
                            <br><span class="muted">{{ $product->primaryCategory->name }}</span>
                        @endif
                    </td>
                    <td class="price">
                        @if ($product->price !== null)
                            {{ number_format($product->price / 100, 2) }}
                            @if ($product->sale_price !== null)
                                <br><span class="sale">Sale: {{ number_format($product->sale_price / 100, 2) }}</span>
                            @endif
                        @else
                            <span class="muted">—</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $stockColor = match ($product->stock_status->value) {
                                'in_stock' => 'green',
                                'out_of_stock' => 'red',
                                default => 'yellow',
                            };
                        @endphp
                        <span class="badge badge-{{ $stockColor }}">{{ $product->stock_status->label() }}</span>
                        @if ($product->stock_quantity !== null)
                            <br><span class="muted">{{ number_format($product->stock_quantity) }} units</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $product->status->badgeColor() }}">{{ $product->status->label() }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:20px; color:#9ca3af">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Exported from {{ config('app.name') }}</div>
</body>
</html>
