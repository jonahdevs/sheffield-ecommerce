<x-mail::message>
# Low stock alert

**{{ $productName }}** has **{{ $currentQuantity }}** unit(s) remaining, at or below its low stock threshold.

<x-mail::button :url="$url">
View product
</x-mail::button>
</x-mail::message>
