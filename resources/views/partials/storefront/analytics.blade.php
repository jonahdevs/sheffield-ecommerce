@php
    $analytics = app(\App\Settings\AnalyticsSettings::class);
    $legal = app(\App\Settings\LegalSettings::class);

    // When the consent banner is enabled, tracking requires an explicit opt-in
    // (the unencrypted `cookie_consent` cookie set by the banner). When the
    // banner is disabled, the store owner has chosen not to gate tracking.
    $consentGranted = ! $legal->cookie_consent_enabled
        || request()->cookie('cookie_consent') === 'accepted';
@endphp

@if (filled($analytics->gtm_id) || filled($analytics->ga4_id))
    {{-- Google Consent Mode v2 - must run before any GTM/GA4 script. Storage is
         denied by default and granted either server-side (returning visitor with
         a consent cookie) or client-side via window.grantCookieConsent(). --}}
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('consent', 'default', {
            ad_storage: '{{ $consentGranted ? 'granted' : 'denied' }}',
            ad_user_data: '{{ $consentGranted ? 'granted' : 'denied' }}',
            ad_personalization: '{{ $consentGranted ? 'granted' : 'denied' }}',
            analytics_storage: '{{ $consentGranted ? 'granted' : 'denied' }}',
            wait_for_update: 500
        });
    </script>
@endif

@if (filled($analytics->gtm_id))
    {{-- Google Tag Manager --}}
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '{{ $analytics->gtm_id }}');
    </script>
@endif

@if (filled($analytics->ga4_id))
    {{-- Google Analytics 4 --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $analytics->ga4_id }}"></script>
    <script>
        gtag('js', new Date());
        gtag('config', '{{ $analytics->ga4_id }}');
    </script>
@endif

@if (filled($analytics->meta_pixel_id))
    {{-- Meta (Facebook) Pixel - unlike Google tags it has no consent mode, so the
         script itself only loads once consent is granted. PageView fires on
         livewire:navigated (initial load + every wire:navigate visit) rather than
         at init, since wire:navigate swaps pages without a full reload. --}}
    <script>
        window.loadMetaPixel = function() {
            if (window.fbq) return;
            !function(f, b, e, v, n, t, s) {
                if (f.fbq) return; n = f.fbq = function() { n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments) };
                if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0'; n.queue = [];
                t = b.createElement(e); t.async = !0; t.src = v;
                s = b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t, s)
            }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $analytics->meta_pixel_id }}');
        };
        document.addEventListener('livewire:navigated', function() {
            if (window.fbq) fbq('track', 'PageView');
        });
        @if ($consentGranted)
            window.loadMetaPixel();
        @endif
    </script>
    @if ($consentGranted)
        <noscript><img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $analytics->meta_pixel_id }}&ev=PageView&noscript=1" /></noscript>
    @endif
@endif

@if (filled($analytics->gtm_id) || filled($analytics->ga4_id) || filled($analytics->meta_pixel_id))
    {{-- Called by the cookie banner when the visitor accepts (or withdraws), so
         tracking starts/stops immediately instead of waiting for a page load. --}}
    <script>
        window.grantCookieConsent = function() {
            if (typeof gtag === 'function') {
                gtag('consent', 'update', {
                    ad_storage: 'granted',
                    ad_user_data: 'granted',
                    ad_personalization: 'granted',
                    analytics_storage: 'granted'
                });
            }
            if (typeof window.loadMetaPixel === 'function') {
                window.loadMetaPixel();
                // The initial livewire:navigated event has already fired, so send
                // this page's view explicitly.
                fbq('track', 'PageView');
            }
        };

        window.revokeCookieConsent = function() {
            if (typeof gtag === 'function') {
                gtag('consent', 'update', {
                    ad_storage: 'denied',
                    ad_user_data: 'denied',
                    ad_personalization: 'denied',
                    analytics_storage: 'denied'
                });
            }
        };
    </script>
@endif
