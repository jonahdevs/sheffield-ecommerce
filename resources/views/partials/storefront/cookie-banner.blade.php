{{-- Cookie consent notice - shown until accepted or declined. The choice is kept
     in an unencrypted `cookie_consent` cookie (12 months) so the server can skip
     rendering tracking scripts; see partials/storefront/analytics.blade.php.
     Reopens via a window `open-cookie-settings` event (footer "Cookie settings"). --}}
<div
    x-data="{
        show: false,
        setConsent(value) {
            document.cookie = 'cookie_consent=' + value + ';path=/;max-age=31536000;SameSite=Lax';
            this.show = false;
        },
        accept() {
            this.setConsent('accepted');
            window.grantCookieConsent?.();
        },
        decline() {
            const withdrawing = document.cookie.includes('cookie_consent=accepted');
            this.setConsent('declined');
            if (withdrawing) {
                // Trackers from the earlier accept are already running: tell
                // Google to stop, then reload so nothing is re-rendered.
                window.revokeCookieConsent?.();
                window.location.reload();
            }
        },
    }"
    x-init="
        // Migrate the choice visitors made when it lived in localStorage.
        if (! document.cookie.includes('cookie_consent=') && localStorage.getItem('cookie-consent')) {
            setConsent(localStorage.getItem('cookie-consent'));
        }
        show = ! document.cookie.includes('cookie_consent=');
    "
    x-on:open-cookie-settings.window="show = true"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-4 right-4 z-50 w-80 overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-900"
    role="dialog"
    aria-label="Cookie notice"
>
    {{-- Header --}}
    <div class="flex items-center gap-2.5 border-b border-zinc-100 bg-zinc-50 px-5 py-3.5 dark:border-zinc-800 dark:bg-zinc-800/60">
        <span class="text-xl leading-none">🍪</span>
        <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Got Cookies!</h3>
    </div>

    {{-- Description --}}
    <div class="px-5 py-4">
        <p class="text-sm leading-relaxed text-zinc-500 dark:text-zinc-400">
            We use cookies to ensure that we give you the best experience on our website. For more information, please read our
            <a href="{{ route('page.show', 'cookie-policy') }}"
               class="text-brand-500 underline underline-offset-2 hover:text-brand-600"
               wire:navigate>Cookie Policy</a>.
        </p>
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-2 border-t border-zinc-100 bg-zinc-50 px-5 py-3.5 dark:border-zinc-800 dark:bg-zinc-800/60">
        <flux:button
            size="sm"
            variant="ghost"
            class="flex-1"
            x-on:click="decline()">
            No, thank you
        </flux:button>
        <flux:button
            size="sm"
            variant="primary"
            class="flex-1"
            x-on:click="accept()">
            Sounds Good!
        </flux:button>
    </div>
</div>
