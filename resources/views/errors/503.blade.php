@php
    // Do NOT call auth()->check() here — the app may be in maintenance/broken state.
    $errorData = [
        'code' => '503',
        'title' => 'Under maintenance',
        'message' => $maintenanceMessage ?? 'We are performing scheduled maintenance to improve your experience. We will be back shortly — thank you for your patience.',
        'isAdmin' => false,
    ];
@endphp

<x-layouts::error title="503 — Maintenance">
    @include('errors._error_body', $errorData)
</x-layouts::error>
