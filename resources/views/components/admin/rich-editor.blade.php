@props([
    'label'     => null,
    'placeholder' => '',
    'withTable' => false,
    'rows'      => 'md', // sm | md | lg
])

@php
    $model     = $attributes->wire('model')->value();
    $minHeight = match ($rows) {
        'sm'    => '100px',
        'lg'    => '300px',
        default => '180px',
    };
@endphp

@assets
    @vite('resources/js/rich-text.js')
@endassets

<div
    x-data="richTextEditor('{{ $model }}', '{{ addslashes($placeholder) }}', {{ $withTable ? 'true' : 'false' }})"
    x-init="$nextTick(() => setup($refs.editor))"
    wire:ignore
    wire:key="rich-editor-{{ $model }}"
    {{ $attributes->whereDoesntStartWith('wire:model') }}
>
    @if ($label)
        <flux:label class="mb-1.5 block">{{ $label }}</flux:label>
    @endif

    {{-- Outer div owns the single visible border. Quill mounts inside the inner div. --}}
    <div style="border: 1px solid #d4d4d8; border-radius: 0.5rem; overflow: hidden;">
        <div x-ref="editor" style="min-height: {{ $minHeight }}"></div>
    </div>

    @if ($model)
        <flux:error :name="$model" />
    @endif
</div>
