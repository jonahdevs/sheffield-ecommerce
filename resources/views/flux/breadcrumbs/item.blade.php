@blaze(fold: true, unsafe: ['icon:variant'])

@php $iconVariant ??= $attributes->pluck('icon:variant'); @endphp

@props([
    'separator' => null,
    'iconVariant' => 'mini',
    'icon' => null,
    'href' => null,
])

@php
$classes = Flux::classes()
    ->add('flex items-center')
    ->add('group/breadcrumb')
    ;

$linkClasses = Flux::classes()
    ->add('text-ink-3 dark:text-zinc-400')
    ->add('hover:text-ink dark:hover:text-white transition-colors');

$staticTextClasses = Flux::classes()
    ->add('text-ink dark:text-white')
    ;

$separatorClasses = Flux::classes()
    ->add('mx-1 size-3 text-ink-3/60 dark:text-white/40')
    ->add('group-last/breadcrumb:hidden')
    ;

$iconClasses = Flux::classes()
    ->add($iconVariant === 'outline' ? 'size-5' : '')
    ;

[ $styleAttributes, $attributes ] = Flux::splitAttributes($attributes);
@endphp

<div {{ $styleAttributes->class($classes) }} data-flux-breadcrumbs-item>
    <?php if ($href): ?>
        <a {{ $attributes->class($linkClasses) }} href="{{ $href }}">
            <?php if ($icon): ?>
                <flux:icon :$icon :variant="$iconVariant" class="{{ $iconClasses }}" />
            <?php else: ?>
                {{ $slot }}
            <?php endif; ?>
        </a>
    <?php else: ?>
        <div {{ $attributes->class($staticTextClasses) }}>
            <?php if ($icon): ?>
                <flux:icon :$icon :variant="$iconVariant" class="{{ $iconClasses }}" />
            <?php else: ?>
                {{ $slot }}
            <?php endif; ?>
        </div>
    <?php endif; ?>

    @if ($separator == null)
        <flux:icon icon="chevron-right" variant="micro" class="{{ $separatorClasses->add('rtl:hidden') }}" />
        <flux:icon icon="chevron-left" variant="micro" class="{{ $separatorClasses->add('hidden rtl:inline') }}" />
    @elseif (! is_string($separator))
        {{ $separator }}
    @elseif ($separator === 'slash')
        <flux:icon icon="slash" variant="mini" class="{{ $separatorClasses->add('rtl:-scale-x-100') }}" />
    @else
        <flux:icon :icon="$separator" variant="mini" class="{{ $separatorClasses }}" />
    @endif
</div>
