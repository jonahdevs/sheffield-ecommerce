/**
 * Sheffield Steel Systems — service worker.
 *
 * Strategy (deliberately conservative for an app with an authenticated admin area):
 *   - Static assets (build output, images, fonts): stale-while-revalidate.
 *   - Page navigations: network-first, falling back to /offline.html when offline.
 *   - Authenticated / dynamic areas (admin, account, auth, livewire, checkout) are
 *     never cached — they always go straight to the network so stale or private
 *     content can't be served from cache.
 *
 * Bump CACHE_VERSION whenever this file or the precache list changes so old
 * caches are dropped on activate.
 */

const CACHE_VERSION = 'v1';
const STATIC_CACHE = `sss-static-${CACHE_VERSION}`;
const PAGE_CACHE = `sss-pages-${CACHE_VERSION}`;

const PRECACHE_URLS = [
    '/offline.html',
    '/favicon.svg',
    '/favicon-32x32.png',
    '/android-chrome-192x192.png',
    '/android-chrome-512x512.png',
    '/site.webmanifest',
];

// Never intercept/cache these — always hit the network.
const BYPASS_PREFIXES = ['/admin', '/account', '/livewire', '/login', '/register', '/checkout', '/telescope'];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then((cache) => cache.addAll(PRECACHE_URLS))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((keys) => Promise.all(
                keys.filter((key) => key !== STATIC_CACHE && key !== PAGE_CACHE)
                    .map((key) => caches.delete(key))
            ))
            .then(() => self.clients.claim())
    );
});

function isStaticAsset(url) {
    return url.pathname.startsWith('/build/')
        || url.pathname.startsWith('/fonts/')
        || /\.(?:css|js|png|jpe?g|webp|gif|svg|ico|woff2?)$/i.test(url.pathname);
}

function shouldBypass(url) {
    return BYPASS_PREFIXES.some((prefix) => url.pathname === prefix || url.pathname.startsWith(`${prefix}/`));
}

self.addEventListener('fetch', (event) => {
    const { request } = event;

    // Only handle same-origin GET requests. Everything else (POST, cross-origin
    // fonts/analytics, etc.) is left to the browser.
    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    if (url.origin !== self.location.origin || shouldBypass(url)) {
        return;
    }

    // Stale-while-revalidate for static assets.
    if (isStaticAsset(url)) {
        event.respondWith(
            caches.open(STATIC_CACHE).then((cache) => cache.match(request).then((cached) => {
                const network = fetch(request).then((response) => {
                    if (response.ok) {
                        cache.put(request, response.clone());
                    }
                    return response;
                }).catch(() => cached);

                return cached || network;
            }))
        );
        return;
    }

    // Network-first for page navigations, with an offline fallback.
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request)
                .then((response) => {
                    if (response.ok) {
                        const copy = response.clone();
                        caches.open(PAGE_CACHE).then((cache) => cache.put(request, copy));
                    }
                    return response;
                })
                .catch(() => caches.match(request).then((cached) => cached || caches.match('/offline.html')))
        );
    }
});
