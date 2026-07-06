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

document.dispatchEvent(new CustomEvent('app:ready'));
