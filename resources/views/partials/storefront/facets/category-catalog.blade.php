{{-- Catalog category facet - a flat list of every catalog category with its
     product count. Expects $this->categoriesList and a host $selectedCategories
     array of slugs. --}}
<x-storefront.filter-section title="Category">
    <div class="scrollbar-hover flex max-h-64 flex-col gap-2 overflow-y-auto pl-0.5 pr-1">
        @foreach ($this->categoriesList as $cat)
            <flux:field variant="inline">
                <flux:checkbox wire:model.live="selectedCategories" value="{{ $cat->slug }}" />
                <flux:label>
                    {{ $cat->name }}
                    <x-slot:trailing>
                        <span class="text-xs text-ink-4 tabular-nums">{{ $cat->products_count }}</span>
                    </x-slot:trailing>
                </flux:label>
            </flux:field>
        @endforeach
    </div>
</x-storefront.filter-section>
