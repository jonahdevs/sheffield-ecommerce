<x-mail::message>
# New order received

**{{ $customer }}** placed order **{{ $orderNumber }}**.

<x-mail::table>
| | |
|:--|:--|
| **Order** | {{ $orderNumber }} |
| **Total** | {{ $total }} |
| **Customer** | {{ $customer }} |
</x-mail::table>

<x-mail::button :url="$url">
Open in admin
</x-mail::button>
</x-mail::message>
