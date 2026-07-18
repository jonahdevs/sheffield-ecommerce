{{-- Shared status-history timeline (the customer "tracking" design).

     Renders a fixed pipeline of steps as connected icon dots, marks how far the
     record has progressed, highlights the current step with a pulsing badge, and
     can inject a terminal step (cancelled / declined / expired). Used by both the
     storefront (always light) and the staff pages (dark-mode aware).

     Props:
       steps         array  — [['value','label','icon','desc'], …] in pipeline order
       histories     mixed  — the model's statusHistories collection (keyed on to_status here)
       implicitFirst mixed  — Carbon|null; synthesises the first step's record (e.g. creation time)
       aliases       array  — ['canonical_status' => 'fallback_status'] when the canonical is missing
       isTerminal    bool   — the record ended on a terminal state
       terminal      array|null — ['value','label','desc','icon','tone'=>'danger'|'muted']
       showActor     bool   — show "by {name}" attribution (staff side) --}}
@props([
    'steps' => [],
    'histories' => null,
    'implicitFirst' => null,
    'aliases' => [],
    'isTerminal' => false,
    'terminal' => null,
    'showActor' => false,
])

@php
    $map = ($histories ?? collect())->keyBy('to_status');

    // Synthesise the first step (e.g. "Order placed") from a creation timestamp.
    if ($implicitFirst && isset($steps[0]) && ! $map->has($steps[0]['value'])) {
        $map->put($steps[0]['value'], (object) [
            'created_at' => $implicitFirst,
            'note' => null,
            'changedBy' => null,
        ]);
    }

    // Fall back to an equivalent status when the canonical one was skipped.
    foreach ($aliases as $canonical => $alias) {
        if (! $map->has($canonical) && $map->has($alias)) {
            $map->put($canonical, $map->get($alias));
        }
    }

    $maxReachedIndex = 0;
    foreach ($steps as $i => $step) {
        if ($map->has($step['value'])) {
            $maxReachedIndex = $i;
        }
    }
@endphp

<div class="relative px-1">
    @foreach ($steps as $index => $step)
        @php
            $history = $map->get($step['value']);
            $reached = $index <= $maxReachedIndex;
            $isCurrent = ! $isTerminal && $index === $maxReachedIndex;
            $isLast = $index === count($steps) - 1;
            $injectTerminal = $isTerminal && $terminal && $index === $maxReachedIndex;
            $actor = $showActor && $history && isset($history->changedBy) ? $history->changedBy : null;
        @endphp

        <div class="relative flex gap-6 {{ $isLast && ! $injectTerminal ? 'pb-0' : 'pb-10' }}">

            {{-- Connector line --}}
            @if (! $isLast || $injectTerminal)
                @php $nextReached = $index + 1 <= $maxReachedIndex; @endphp
                <div @class([
                    'absolute left-4.25 top-9 bottom-0 w-0.5 z-0',
                    'bg-brand-500' => $nextReached || $injectTerminal,
                    'bg-zinc-100 dark:bg-zinc-700' => ! $nextReached && ! $injectTerminal,
                ])></div>
            @endif

            {{-- Dot --}}
            <div @class([
                'relative z-10 flex size-9 shrink-0 items-center justify-center rounded-full transition-all',
                'bg-brand-500 text-white' => $reached,
                'bg-zinc-50 border border-zinc-100 text-zinc-300 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-600' => ! $reached,
            ])>
                <flux:icon :name="$step['icon']" variant="mini" class="size-4.5" />
            </div>

            {{-- Content --}}
            <div class="flex-1 pt-0.5">
                <div class="flex flex-col justify-between gap-1 sm:flex-row sm:items-start sm:gap-4">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <p @class([
                                'text-[14px] font-bold',
                                'text-ink dark:text-white' => $reached,
                                'text-ink-4 dark:text-zinc-500' => ! $reached,
                            ])>{{ $step['label'] }}</p>

                            @if ($isCurrent)
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-sm border border-brand-500/20 bg-brand-500/10 px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-widest text-brand-500">
                                    <span class="relative flex size-1.5">
                                        <span
                                            class="absolute inline-flex size-full animate-ping rounded-full bg-brand-500 opacity-75"></span>
                                        <span class="relative inline-flex size-1.5 rounded-full bg-brand-500"></span>
                                    </span>
                                    Current
                                </span>
                            @endif
                        </div>
                        <p @class([
                            'mt-1 text-[12px] leading-relaxed',
                            'font-medium text-ink-2 dark:text-zinc-300' => $reached,
                            'text-zinc-300 dark:text-zinc-600' => ! $reached,
                        ])>{{ $reached ? $step['desc'] : 'Pending…' }}</p>

                        @if ($actor)
                            <p class="mt-1 text-[11px] font-medium text-ink-3 dark:text-zinc-400">{{ 'by '.$actor->name }}</p>
                        @endif
                        @if ($history?->note)
                            <p class="mt-1 text-[11px] italic text-ink-3 dark:text-zinc-400">{{ $history->note }}</p>
                        @endif
                    </div>

                    {{-- Date/time --}}
                    @if ($history)
                        <div class="shrink-0 sm:text-right">
                            <p class="text-[12px] font-bold text-ink dark:text-white">
                                {{ $history->created_at->format('M j, Y') }}</p>
                            <p class="mt-0.5 text-[11px] font-medium text-ink-3 dark:text-zinc-400">
                                {{ $history->created_at->format('g:i A') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Terminal step (cancelled / declined / expired) injected after the last reached step --}}
        @if ($injectTerminal)
            @php
                $terminalHistory = $map->get($terminal['value']);
                $terminalActor = $showActor && $terminalHistory && isset($terminalHistory->changedBy) ? $terminalHistory->changedBy : null;
                $danger = ($terminal['tone'] ?? 'danger') === 'danger';
            @endphp
            <div class="relative flex gap-6 pb-0">
                <div @class([
                    'relative z-10 flex size-9 shrink-0 items-center justify-center rounded-full',
                    'bg-red-50 text-red-500 dark:bg-red-500/15 dark:text-red-400' => $danger,
                    'bg-zinc-50 border border-zinc-200 text-zinc-400 dark:bg-zinc-800 dark:border-zinc-700' => ! $danger,
                ])>
                    <flux:icon :name="$terminal['icon']" variant="mini" class="size-4.5" />
                </div>
                <div class="flex-1 pt-0.5">
                    <div class="flex flex-col justify-between gap-1 sm:flex-row sm:items-start sm:gap-4">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <p @class([
                                    'text-[14px] font-bold',
                                    'text-red-500 dark:text-red-400' => $danger,
                                    'text-ink-3 dark:text-zinc-400' => ! $danger,
                                ])>{{ $terminal['label'] }}</p>

                                @if ($danger)
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-sm border border-red-500/20 bg-red-500/10 px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-widest text-red-500 dark:text-red-400">
                                        <span class="relative flex size-1.5">
                                            <span
                                                class="absolute inline-flex size-full animate-ping rounded-full bg-red-500 opacity-75"></span>
                                            <span class="relative inline-flex size-1.5 rounded-full bg-red-500"></span>
                                        </span>
                                        Current
                                    </span>
                                @endif
                            </div>
                            <p @class([
                                'mt-1 text-[12px] font-medium leading-relaxed',
                                'text-ink-2 dark:text-zinc-300' => $danger,
                                'text-ink-3 dark:text-zinc-400' => ! $danger,
                            ])>{{ $terminal['desc'] }}</p>

                            @if ($terminalActor)
                                <p class="mt-1 text-[11px] font-medium text-ink-3 dark:text-zinc-400">{{ 'by '.$terminalActor->name }}</p>
                            @endif
                            @if ($terminalHistory?->note)
                                <p class="mt-1 text-[11px] italic text-ink-3 dark:text-zinc-400">
                                    {{ $terminalHistory->note }}</p>
                            @endif
                        </div>

                        @if ($terminalHistory)
                            <div class="shrink-0 sm:text-right">
                                <p class="text-[12px] font-bold text-ink dark:text-white">
                                    {{ $terminalHistory->created_at->format('M j, Y') }}</p>
                                <p class="mt-0.5 text-[11px] font-medium text-ink-3 dark:text-zinc-400">
                                    {{ $terminalHistory->created_at->format('g:i A') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @break
        @endif
    @endforeach
</div>
