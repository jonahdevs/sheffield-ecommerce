{{-- Address suggestion box — picking a result drops the pin and prefills line1. Requires the addressMap() Alpine scope. --}}
<div class="relative" x-on:click.outside="closeSuggestions()">
    <flux:input
        type="search"
        icon="magnifying-glass"
        placeholder="Search a building, estate or landmark…"
        autocomplete="off"
        x-model="query"
        x-on:input.debounce.350ms="searchPlaces()"
        x-on:focus="if (suggestions.length) showSuggestions = true"
        x-on:keydown.enter.prevent="searchPlaces()"
        x-on:keydown.escape.stop="closeSuggestions()" />

    <div x-show="searching" x-cloak class="absolute end-3 top-1/2 -translate-y-1/2">
        <flux:icon.loading variant="mini" class="text-ink-4" />
    </div>

    {{-- Sits above Leaflet's control panes, which claim up to z-index 1000. --}}
    <div x-show="showSuggestions && suggestions.length" x-cloak
         class="absolute z-[1001] mt-1 w-full overflow-hidden rounded-md border border-zinc-200 bg-white shadow-lg">
        <template x-for="(suggestion, index) in suggestions" :key="index">
            <button type="button" x-on:click="chooseSuggestion(suggestion)"
                    class="block w-full border-b border-zinc-100 px-3 py-2 text-left text-[13px] text-ink-2 last:border-0 hover:bg-surface-sunken">
                <span x-text="suggestion.label"></span>
            </button>
        </template>
    </div>

    <div x-show="showSuggestions && ! suggestions.length && ! searching" x-cloak
         class="absolute z-[1001] mt-1 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-[12.5px] text-ink-4 shadow-lg">
        No matches. Drop the pin on the map instead.
    </div>
</div>
