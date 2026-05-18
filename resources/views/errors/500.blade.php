@php
    // Do NOT call auth()->check() here — the DB may be down.
    $errorData = [
        'code' => '500',
        'title' => 'Something went wrong',
        'message' => 'We ran into an unexpected error on our end. Our team has been notified and is working on a fix. Please try again in a few moments.',
        'isAdmin' => false,
    ];
@endphp

<x-layouts::error title="500 — Server Error">
    @include('errors._error_body', $errorData)
</x-layouts::error>
