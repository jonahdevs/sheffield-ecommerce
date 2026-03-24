@php($isAdmin = auth()->check() && auth()->user()->is_staff)

@if ($isAdmin)
    <x-layouts::app title="503 — Maintenance">
        <flux:main class="bg-zinc-50 dark:bg-zinc-800">
            @include('errors._error_body', [
                'code' => '503',
                'title' => 'Under maintenance',
                'message' =>
                    'We are performing scheduled maintenance to improve your experience. We will be back shortly — thank you for your patience.',
                'isAdmin' => true,
            ])
        </flux:main>
    </x-layouts::app>
@else
    <x-layouts::guest>
        @include('errors._error_body', [
            'code' => '503',
            'title' => 'Under maintenance',
            'message' =>
                'We are performing scheduled maintenance to improve your experience. We will be back shortly — thank you for your patience.',
            'isAdmin' => false,
        ])
    </x-layouts::guest>
@endif
