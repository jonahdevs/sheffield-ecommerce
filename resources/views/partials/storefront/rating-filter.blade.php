{{-- Rating filter — filters products by average approved-review rating.
     Expects the host Livewire component to expose an int $minRating property
     (0 = any). Structure mirrors the legacy storefront's radio.group. --}}
<div class="{{ ($hideHeading ?? false) ? '' : 'px-5 py-4' }}">
    @unless($hideHeading ?? false)
        <div class="mb-3 text-xs font-bold uppercase tracking-widest text-ink-2">Rating</div>
    @endunless
    <flux:radio.group wire:model.live="minRating">
        @for ($rating = 4; $rating >= 1; $rating--)
            <flux:field class="flex! items-center!">
                <flux:radio value="{{ $rating }}" />
                <flux:label class="flex items-center gap-1.5">
                    @for ($i = 1; $i <= 5; $i++)
                        <flux:icon.star variant="solid"
                            class="size-4 {{ $i <= $rating ? 'text-amber-500' : 'text-zinc-300' }}" />
                    @endfor
                    <span class="ms-1 text-xs font-normal">&amp; up</span>
                </flux:label>
            </flux:field>
        @endfor
    </flux:radio.group>
</div>
