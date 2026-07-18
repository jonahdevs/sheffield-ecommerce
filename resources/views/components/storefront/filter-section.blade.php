{{-- Collapsible filter-sidebar section. Shared by the catalog & category
     listing sidebars (both the mobile drawer and the desktop aside).

     Props:
       title — the uppercase heading shown on the toggle button
       open  — whether the section starts expanded (default true) --}}
@props(['title', 'open' => true])

<div class="px-5 py-4" x-data="{ open: @js($open) }">
    <button type="button" x-on:click="open = !open"
        class="flex w-full cursor-pointer items-center justify-between text-xs font-bold uppercase tracking-widest text-ink-2">
        <span>{{ $title }}</span>
        <span class="flex transition-transform duration-200" x-bind:class="open ? 'rotate-0' : '-rotate-90'">
            <flux:icon.chevron-down variant="micro" class="size-3.5 text-zinc-400" />
        </span>
    </button>
    <div x-show="open" @unless ($open) x-cloak @endunless
        class="mt-3 [&_ui-label]:text-sm [&_ui-label]:font-normal">
        {{ $slot }}
    </div>
</div>
