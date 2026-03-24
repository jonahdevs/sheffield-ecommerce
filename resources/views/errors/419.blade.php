@php($isAdmin = auth()->check() && auth()->user()->is_staff)

@if ($isAdmin)
    <x-layouts::app title="419 — Session Expired">
        <flux:main class="bg-zinc-50 dark:bg-zinc-800">
            @include('errors._error_body', [
                'code' => '419',
                'title' => 'Session expired',
                'message' =>
                    'Your session timed out for security purposes. Please refresh the page to continue where you left off.',
                'isAdmin' => true,
            ])
        </flux:main>
    </x-layouts::app>
@else
    <x-layouts::guest>
        @include('errors._error_body', [
            'code' => '419',
            'title' => 'Session expired',
            'message' =>
                'Your session timed out for security purposes. Please refresh the page to continue where you left off.',
            'isAdmin' => false,
        ])
    </x-layouts::guest>
@endif
