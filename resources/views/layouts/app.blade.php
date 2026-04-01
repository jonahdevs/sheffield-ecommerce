<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main class="bg-zinc-50 dark:bg-zinc-800">
        {{ $slot }}
    </flux:main>

    <x-toast-notification />

    {{-- Admin Layout - Brand Primary Progress Bar --}}
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Livewire Progress Bar - Admin (Brand Primary) */
        [x-data*="progress"]>div {
            background-color: var(--brand-primary) !important;
            box-shadow: 0 0 10px color-mix(in srgb, var(--brand-primary) 50%, transparent);
        }
    </style>
</x-layouts::app.sidebar>
