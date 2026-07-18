{{-- Category-page facet — the current category's immediate children, with a
     "show all" toggle once there are more than eight. Expects $this->childCategories
     and a host $selectedCategories array of child slugs. --}}
@if ($this->childCategories->isNotEmpty())
    <x-storefront.filter-section title="Category">
        <div x-data="{ openCats: false }">
            <div class="scrollbar-hover flex flex-col gap-2"
                x-bind:class="openCats ? 'max-h-64 overflow-y-auto pr-1' : ''">
                @foreach ($this->childCategories as $i => $child)
                    <div @if ($i >= 8) x-show="openCats" x-cloak @endif>
                        <flux:checkbox wire:model.live="selectedCategories" value="{{ $child->slug }}"
                            :label="$child->name" />
                    </div>
                @endforeach
            </div>
            @if ($this->childCategories->count() > 8)
                <button type="button" x-on:click="openCats = !openCats"
                    class="mt-2 cursor-pointer text-xs text-brand-500 hover:underline">
                    <span x-show="!openCats" class="inline-flex items-center gap-1">
                        Show all {{ $this->childCategories->count() }} categories
                        <flux:icon.arrow-right variant="micro" class="size-3.5" />
                    </span>
                    <span x-show="openCats" x-cloak>Show fewer</span>
                </button>
            @endif
        </div>
    </x-storefront.filter-section>
@endif
