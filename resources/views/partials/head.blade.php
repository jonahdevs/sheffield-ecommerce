<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

{{-- SEO Meta Tags --}}
{!! SEO::generate() !!}

{{-- Fallback title if SEO not set --}}
@if (!View::hasSection('seo'))
    <title>{{ isset($title) ? $title . ' | ' : '' }}{{ config('app.name') }}</title>
@endif

{{-- <link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png"> --}}

<link rel="icon" type="image/png" href="/favicon.png">
{{-- Canonical is set per-page via SEOMeta::setCanonical() and output by SEO::generate() above --}}
<link rel="preconnect" href="https://fonts.bunny.net">

<meta name="color-scheme" content="light only">

{{-- Swiper --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js" defer></script>

@stack('head-scripts')

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
