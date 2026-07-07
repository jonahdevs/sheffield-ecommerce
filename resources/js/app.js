/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
import './livewire-errors';
import L from 'leaflet';
window.L = L;

import Swiper from 'swiper/bundle';
window.Swiper = Swiper;

// Register the PWA service worker. Only in production builds so it doesn't
// cache Vite's dev/HMR assets during `npm run dev`.
if ('serviceWorker' in navigator && import.meta.env.PROD) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {
            // Registration failures (e.g. unsupported context) are non-fatal.
        });
    });
}

// Capture the browser's install prompt so a custom "Install app" button can
// trigger it later. `beforeinstallprompt` can fire before Alpine boots, so we
// stash the event globally and re-broadcast it for any listening component.
window.deferredInstallPrompt = null;
window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault();
    window.deferredInstallPrompt = event;
    window.dispatchEvent(new CustomEvent('pwa:installable'));
});
window.addEventListener('appinstalled', () => {
    window.deferredInstallPrompt = null;
    window.dispatchEvent(new CustomEvent('pwa:installed'));
});

// Replace wire:confirm's native browser dialog with the styled <x-confirm-dialog />
// modal. Livewire exposes an overridable el.__livewire_confirm(action) hook per
// element, and it tolerates the action being invoked asynchronously — so swapping
// the hook at click time (document capture fires before Livewire's own listener)
// lets the modal decide later whether the action runs. Falls back to the native
// dialog when the modal, Alpine, or Flux isn't on the page. wire:confirm.prompt
// (typed confirmation) is not intercepted — its attribute name doesn't match.
document.addEventListener('alpine:init', () => {
    window.Alpine.store('confirmDialog', {
        message: '',
        action: null,
        ask(message, action) {
            this.message = message;
            this.action = action;
            window.Flux.modal('confirm-dialog').show();
        },
        proceed() {
            const action = this.action;
            this.action = null;
            window.Flux.modal('confirm-dialog').close();
            if (action) action();
        },
    });
});

document.addEventListener('click', (event) => {
    const el = event.target.closest('[wire\\:confirm]');

    if (! el || ! el.__livewire_confirm || ! window.Flux || ! window.Alpine?.store('confirmDialog')) {
        return;
    }

    if (! document.querySelector('[data-confirm-dialog]')) {
        return;
    }

    el.__livewire_confirm = (action) => {
        const message = (el.getAttribute('wire:confirm') || '').replaceAll('\\n', '\n') || 'Are you sure?';
        window.Alpine.store('confirmDialog').ask(message, action);
    };
}, true);

document.dispatchEvent(new CustomEvent('app:ready'));
