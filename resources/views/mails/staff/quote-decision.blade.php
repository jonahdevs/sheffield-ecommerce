<x-mail::message>
# Quote {{ $approved ? 'approved' : 'declined' }}

**{{ $who }}** has **{{ $approved ? 'approved' : 'declined' }}** quotation **{{ $quoteNumber }}**.

{{ $approved ? 'You can now convert it to an order.' : 'You may want to follow up with the customer.' }}

<x-mail::button :url="$url" color="{{ $approved ? 'success' : 'error' }}">
Open quote
</x-mail::button>
</x-mail::message>
