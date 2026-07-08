{{-- Shared filter sections for the catalog & category listings: price, rating,
     brand and availability. The category facet differs per page and is rendered
     immediately before this include.

     Expects the host Livewire component to expose the price/brand/rating/stock
     state (see App\Livewire\Concerns\HasProductFilters) and a $this->brandsList
     computed. Rendered inside a `divide-y` wrapper so each section is separated. --}}

<x-storefront.filter-section title="Price">
    @include('partials.storefront.price-filter', ['hideHeading' => true])
</x-storefront.filter-section>

<x-storefront.filter-section title="Rating" :open="false">
    @include('partials.storefront.rating-filter', ['hideHeading' => true])
</x-storefront.filter-section>

@if ($this->brandsList->isNotEmpty())
    <x-storefront.filter-section title="Brand" :open="false">
        @include('partials.storefront.brand-filter', ['brands' => $this->brandsList])
    </x-storefront.filter-section>
@endif

<x-storefront.filter-section title="Availability">
    @include('partials.storefront.availability-filter')
</x-storefront.filter-section>
