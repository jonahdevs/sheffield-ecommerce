@props(['url'])
@php
    $branding = app(\App\Settings\BrandingSettings::class);
    $logoUrl = $branding->logo_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($branding->logo_path)
        : asset('logo.png');
    $storeName = $branding->store_name ?: config('app.name');
@endphp
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if ($logoUrl)
<img src="{{ $logoUrl }}" class="logo" alt="{{ $storeName }}" style="max-height: 48px; width: auto;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
