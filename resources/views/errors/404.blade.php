@php($isAdmin = auth()->check() && auth()->user()->is_staff)

@if ($isAdmin)
    <x-layouts::app title="404 — Not Found">
        <flux:main class="bg-zinc-50 dark:bg-zinc-800">
            @include('errors._error_body', [
                'code' => '404',
                'title' => 'Page not found',
                'message' => 'The page you are looking for might have been moved, renamed, or no longer exists.',
                'isAdmin' => true,
            ])
        </flux:main>
    </x-layouts::app>
@else
    <x-layouts::guest>
        @include('errors._error_body', [
            'code' => '404',
            'title' => 'Page not found',
            'message' => 'The page you are looking for might have been moved, renamed, or no longer exists.',
            'isAdmin' => false,
        ])
    </x-layouts::guest>
@endif
