<x-mail::message>
# SAP sync failed

Order **{{ $orderNumber }}** could not be synced to SAP after all retry attempts.

<x-mail::table>
| | |
|:--|:--|
| **Customer** | {{ $customerName }} ({{ $customerEmail }}) |
| **Total** | {{ $total }} |
</x-mail::table>

<x-mail::panel>
**Error:** {{ $errorMessage }}
</x-mail::panel>

<x-mail::button :url="$url" color="error">
View order
</x-mail::button>

Please sync this order manually or contact the SAP administrator.
</x-mail::message>
