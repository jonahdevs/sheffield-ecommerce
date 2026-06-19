{{--
    reCAPTCHA v3 helper for Livewire forms.

    Usage:
      1. Place <x-recaptcha-livewire /> anywhere on the page (once per page).
      2. Add a `public string $recaptchaToken = ''` property to the component.
      3. Add `new \App\Rules\Recaptcha('action')` to the submit() validation rules.
      4. Replace `wire:submit="submit"` on the <form> with:
             x-data @submit.prevent="__rcSubmit('action', $wire)"

    If reCAPTCHA is not configured the helper calls $wire.submit() directly so
    the form degrades gracefully in development / staging environments.
--}}
@php
    $siteKey = app(\App\Settings\IntegrationSettings::class)->recaptcha_site_key
        ?: config('services.recaptcha.site_key');
@endphp

@if ($siteKey)
    @once('recaptcha-script')
        <script>window.__rcKey = '{{ $siteKey }}'</script>
        <script src="https://www.google.com/recaptcha/api.js?render={{ $siteKey }}" defer></script>
        <script>
            function __rcSubmit(action, wire) {
                const key = window.__rcKey;
                if (!key) { wire.submit(); return; }
                grecaptcha.ready(function () {
                    grecaptcha.execute(key, { action: action }).then(function (token) {
                        wire.recaptchaToken = token;
                        wire.submit();
                    });
                });
            }
        </script>
    @endonce
@else
    @once('recaptcha-noop')
        <script>
            function __rcSubmit(action, wire) { wire.submit(); }
        </script>
    @endonce
@endif
