@php($isAdmin = auth()->check() && auth()->user()->is_staff)

@if ($isAdmin)
    <x-layouts::app title="500 — Server Error">
        <flux:main class="bg-zinc-50 dark:bg-zinc-800">
            @include('errors._error_body', [
                'code' => '500',
                'title' => 'Something went wrong',
                'message' =>
                    'We ran into an unexpected error on our end. Our team has been notified and is working on a fix. Please try again in a few moments.',
                'isAdmin' => true,
                'badge' => 'server-error',
            ])
        </flux:main>
    </x-layouts::app>
@else
    <x-layouts::guest>
        @include('errors._error_body', [
            'code' => '500',
            'title' => 'Something went wrong',
            'message' =>
                'We ran into an unexpected error on our end. Our team has been notified and is working on a fix. Please try again in a few moments.',
            'isAdmin' => false,
            'badge' => 'server-error',
        ])
    </x-layouts::guest>
@endif
