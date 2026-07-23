<x-mail::message>
# New quote request

**{{ $who }}** submitted quote request **{{ $quoteNumber }}**.

<x-mail::table>
| | |
|:--|:--|
| **Email** | {{ $email }} |
@if($phone)
| **Phone** | {{ $phone }} |
@endif
@if($company)
| **Company** | {{ $company }} |
@endif
@if($deliveryAddress)
| **Delivery** | {{ $deliveryAddress }} |
@endif
</x-mail::table>

### Items to price

<x-mail::table>
| # | Product | SKU | Qty |
|:--|:--------|:----|----:|
@foreach($items as $i => $item)
@php $snap = is_array($item->product_snapshot) ? $item->product_snapshot : json_decode($item->product_snapshot, true); @endphp
| {{ $i + 1 }} | {{ $snap['name'] ?? '-' }} | {{ $snap['sku'] ?? '-' }} | {{ $item->quantity }} |
@endforeach
</x-mail::table>

@if($notes)
<x-mail::panel>
**Notes:** {{ $notes }}
</x-mail::panel>
@endif

<x-mail::button :url="$url">
Prepare quote
</x-mail::button>
</x-mail::message>
