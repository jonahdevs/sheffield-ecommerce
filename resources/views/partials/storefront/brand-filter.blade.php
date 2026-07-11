{{-- Brand facet — scrollable checkbox list. Expects a $brands collection and a
     host Livewire component exposing an array $selectedBrands of brand slugs. --}}
<div class="scrollbar-hover flex max-h-64 flex-col gap-2 overflow-y-auto pr-1">
    @foreach ($brands as $brand)
        <flux:checkbox wire:model.live="selectedBrands" value="{{ $brand->slug }}" :label="$brand->name" />
    @endforeach
</div>
