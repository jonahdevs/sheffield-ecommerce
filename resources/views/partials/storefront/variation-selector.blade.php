{{-- Variation selector for a variable product - one swatch/pill row per variation
     attribute. Price and stock for the chosen combination live in the add-to-cart
     modal, so this renders the option buttons and nothing else.

     Expects the host Livewire component to expose $this->variationAttributes,
     $this->isOptionAvailable(), selectOption() and an array $selectedOptions.

     Params:
       keyPrefix    - wire:key namespace for the attribute rows
       wrapperClass - spacing for the host context --}}
@php
    $keyPrefix = $keyPrefix ?? 'attr';
    $wrapperClass = $wrapperClass ?? 'space-y-4';
@endphp

<div class="{{ $wrapperClass }}">
    <div class="text-sm font-semibold text-ink-2">Variations available</div>

    @foreach ($this->variationAttributes as $attr)
        @php $chosen = $selectedOptions[$attr['slug']] ?? null; @endphp
        <div wire:key="{{ $keyPrefix }}-{{ $attr['slug'] }}">
            {{-- One heading covers the whole section, so a single-axis product needs
                 no per-attribute label. Multi-axis products still do, or the rows
                 of buttons would be unlabelled. --}}
            @if ($this->variationAttributes->count() > 1)
                <div class="mb-2 text-xs font-medium text-ink-3">{{ $attr['name'] }}</div>
            @endif
            <div class="flex flex-wrap gap-2">
                @foreach ($attr['values'] as $val)
                    @php
                        $isSel = $chosen === $val->slug;
                        $avail = $this->isOptionAvailable($attr['slug'], $val->slug);
                    @endphp
                    @if ($val->color_code)
                        <button type="button" wire:click="selectOption('{{ $attr['slug'] }}', '{{ $val->slug }}')"
                            @disabled(!$avail)
                            title="{{ $val->label ?: $val->value }}{{ $avail ? '' : ' - out of stock' }}"
                            @class([
                                'size-7 rounded-full border-2 transition',
                                'border-ink ring-1 ring-ink ring-offset-1' => $isSel,
                                'border-zinc-200' => !$isSel,
                                'cursor-pointer hover:border-zinc-400' => $avail,
                                'cursor-not-allowed opacity-30' => !$avail,
                            ]) style="background-color: {{ $val->color_code }}">
                            <span class="sr-only">{{ $val->label ?: $val->value }}</span>
                        </button>
                    @else
                        <button type="button" wire:click="selectOption('{{ $attr['slug'] }}', '{{ $val->slug }}')"
                            {{-- Selection reads as an outline, not a filled block. The ring
                                 thickens the edge without changing the box, so choosing an
                                 option can't nudge the row's layout. --}}
                            @disabled(!$avail) @class([
                                'min-w-9 rounded border px-2.5 py-1.5 text-xs font-medium transition',
                                'border-ink ring-1 ring-ink text-ink font-semibold cursor-pointer' => $isSel,
                                'border-zinc-200 text-ink hover:border-zinc-400 cursor-pointer' =>
                                    !$isSel && $avail,
                                'cursor-not-allowed text-ink-4 line-through opacity-50' => !$avail,
                            ])>
                            {{ $val->label ?: $val->value }}
                        </button>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach
</div>
