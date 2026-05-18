@php
    $isAdmin = auth()->check() && auth()->user()->is_staff;
    $errorData = [
        'code' => '401',
        'title' => 'Authentication required',
        'message' => 'You need to be signed in to access this page. Please log in and try again.',
        'isAdmin' => $isAdmin,
    ];
@endphp

@if ($isAdmin)
    <x-layouts::app title="401 — Unauthorized">
        @include('errors._error_body', $errorData)
    </x-layouts::app>
@else
    <x-layouts::guest>
        @include('errors._error_body', $errorData)
    </x-layouts::guest>
@endif
