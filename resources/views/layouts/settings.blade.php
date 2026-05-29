@php
    $isAdmin = auth()->user()?->hasRole(['admin', 'staff']) ?? false;
@endphp

@if ($isAdmin)
    <x-layouts::app :title="$title ?? null">
        {{ $slot }}
    </x-layouts::app>
@else
    <x-layouts::account-settings :title="$title ?? null">
        {{ $slot }}
    </x-layouts::account-settings>
@endif
