@php($isAdmin = auth()->check() && auth()->user()->is_staff)
@php($customMessage = $exception?->getMessage())

@if ($isAdmin)
    <x-layouts::app title="403 — Access Denied">
        <flux:main class="bg-zinc-50 dark:bg-zinc-800">
            @include('errors._error_body', [
                'code' => '403',
                'title' => 'Access denied',
                'message' =>
                    $customMessage ?:
                    'You do not have permission to access this page. If you believe this is a mistake, please contact your administrator.',
                'isAdmin' => true,
            ])
        </flux:main>
    </x-layouts::app>
@else
    <x-layouts::guest>
        @include('errors._error_body', [
            'code' => '403',
            'title' => 'Access denied',
            'message' =>
                $customMessage ?:
                'You do not have permission to access this page. If you believe this is a mistake, please get in touch with our support team.',
            'isAdmin' => false,
        ])
    </x-layouts::guest>
@endif
