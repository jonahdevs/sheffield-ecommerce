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
// Category mega-menu — a Reka-style navigation menu. Two stacked content layers
// let the outgoing panel slide out toward the direction of travel while the
// incoming panel slides in from the opposite edge, and the viewport morphs its
// height between them. A short close delay bridges the gap between a trigger and
// the panel so the menu doesn't flicker while traversing.
document.addEventListener('alpine:init', () => {
    window.Alpine.data('megaMenu', () => ({
        active: null,
        isOpen: false,
        loading: false,
        hasContent: false,
        height: 0,
        sensitivity: 10, // px of movement per sample below which the pointer counts as "settled"
        pollInterval: 90, // ms between hover-intent samples
        _front: 0, // which of the two layers is currently showing
        _cache: {},
        _intentTimer: null,
        _pending: null,
        _px: 0,
        _py: 0,
        _cx: 0,
        _cy: 0,
        _reqId: 0,
        _lastX: null,
        _closeTimer: null,

        // Keep the latest pointer position (bound to the nav's mousemove) so
        // hover-intent can measure the cursor's speed.
        trackPointer(event) {
            this._px = event.clientX;
            this._py = event.clientY;
        },

        // Pointer entered a trigger. Rather than a fixed dwell timer (which still
        // fires if the cursor merely slows while sweeping across), watch the
        // pointer's speed: only open once it actually settles on the trigger — so
        // passing the cursor through the bar never pops the menu open. Once the
        // menu is already open, switching between triggers stays instant.
        hover(event, id, url) {
            this.cancelClose();

            if (this.isOpen) {
                this._open(id, url, this._pointerX(event));

                return;
            }

            this._pending = { id, url, x: this._pointerX(event) };
            this._px = this._cx = event.clientX;
            this._py = this._cy = event.clientY;

            clearInterval(this._intentTimer);
            this._intentTimer = setInterval(() => this._checkIntent(), this.pollInterval);
        },

        _checkIntent() {
            if (! this._pending) {
                clearInterval(this._intentTimer);

                return;
            }

            const moved = Math.abs(this._px - this._cx) + Math.abs(this._py - this._cy);

            if (moved < this.sensitivity) {
                const { id, url, x } = this._pending;
                this.cancelOpen();
                this._open(id, url, x);
            } else {
                // Still moving — take a fresh sample and keep waiting.
                this._cx = this._px;
                this._cy = this._py;
            }
        },

        // Pointer entered a category with no sub-categories. It can't open a panel,
        // so it should dismiss the one that's showing — but the trigger grid is two
        // rows deep and the panel hangs below both, so reaching the panel from a
        // top-row trigger means sweeping straight through the cell underneath it.
        // Mirror hover-intent: only dismiss once the pointer actually settles here.
        // Passing through on the way down leaves the panel alone.
        closeIntent(event) {
            this.cancelOpen();

            if (! this.isOpen) {
                return;
            }

            this._px = this._cx = event.clientX;
            this._py = this._cy = event.clientY;

            clearInterval(this._closeTimer);
            this._closeTimer = setInterval(() => this._checkCloseIntent(), this.pollInterval);
        },

        _checkCloseIntent() {
            const moved = Math.abs(this._px - this._cx) + Math.abs(this._py - this._cy);

            if (moved < this.sensitivity) {
                this.close();
            } else {
                // Still travelling — take a fresh sample and keep waiting.
                this._cx = this._px;
                this._cy = this._py;
            }
        },

        // Left the plain link before it settled (into the panel, or back to a
        // trigger) — the menu stays as it was.
        cancelClose() {
            clearInterval(this._closeTimer);
        },

        // Keyboard focus is deliberate — open immediately, no dwell.
        focus(event, id, url) {
            this.cancelClose();
            this._open(id, url, this._pointerX(event));
        },

        _pointerX(event) {
            const rect = event.currentTarget.getBoundingClientRect();

            return rect.left + rect.width / 2;
        },

        _open(id, url, x) {
            this.cancelOpen();

            // Direction follows the pointer's actual horizontal position, not the
            // trigger's index — the trigger bar wraps onto two rows, so index order
            // wouldn't match where the mouse is really coming from.
            const direction = this._lastX === null || x >= this._lastX ? 'right' : 'left';
            this._lastX = x;

            // Re-hovering the category that's already open: keep it, don't replay.
            if (this.active === id && this.isOpen) {
                return;
            }

            this.active = id;
            this.isOpen = true;

            if (this._cache[id]) {
                this.$nextTick(() => this.swap(this._cache[id], direction));

                return;
            }

            // Fetch children on hover. The previous panel stays visible until the
            // new content is ready, so the viewport never collapses mid-swap.
            this.loading = true;
            const req = ++this._reqId;

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then((response) => response.text())
                .then((html) => {
                    this._cache[id] = html;

                    // Ignore stale responses once the pointer has moved on.
                    if (req === this._reqId && this.active === id) {
                        this.$nextTick(() => this.swap(html, direction));
                    }
                })
                .catch(() => {})
                .finally(() => {
                    if (req === this._reqId) {
                        this.loading = false;
                    }
                });
        },

        // Populate a layer and reveal it. On first open there's no directional
        // motion — the viewport's scale-in unfold is the entrance. When switching
        // between triggers, the outgoing layer slides out toward the direction of
        // travel while the incoming one slides in from the opposite edge.
        swap(html, direction) {
            this.loading = false;

            const incoming = 1 - this._front;
            const inEl = this.$refs['layer' + incoming];
            const outEl = this.$refs['layer' + this._front];

            inEl.innerHTML = html;
            this.height = inEl.offsetHeight;
            inEl.style.zIndex = '2';
            outEl.style.zIndex = '1';

            // First open: place content at rest; the scale-in unfold reveals it.
            if (! this.hasContent) {
                inEl.style.transition = 'none';
                inEl.style.transform = 'translateX(0)';
                inEl.style.opacity = '1';
                this._front = incoming;
                this.hasContent = true;

                return;
            }

            const dist = 120; // px of travel (Reka slides ~200)
            const enterFrom = direction === 'right' ? dist : -dist;
            const exitTo = direction === 'right' ? -dist : dist;

            // Park the incoming layer off-screen (no transition) on the entering side.
            inEl.style.transition = 'none';
            inEl.style.transform = `translateX(${enterFrom}px)`;
            inEl.style.opacity = '0';

            // Force a reflow so the start position is registered before animating.
            void inEl.offsetWidth;

            requestAnimationFrame(() => {
                inEl.style.transition = '';
                outEl.style.transition = '';
                inEl.style.transform = 'translateX(0)';
                inEl.style.opacity = '1';
                outEl.style.transform = `translateX(${exitTo}px)`;
                outEl.style.opacity = '0';
            });

            this._front = incoming;
        },

        // Leaving a trigger before the pointer settles abandons the pending open —
        // it never closes an already-open menu (that's the nav-level handler).
        cancelOpen() {
            clearInterval(this._intentTimer);
            this._pending = null;
        },

        // The category bar scrolls away with the page, so any scroll means the
        // visitor's focus has moved on — cancel a pending open and dismiss.
        onScroll() {
            this.cancelOpen();

            if (this.isOpen) {
                this.close();
            }
        },

        // Closing is instant — fired the moment the pointer leaves the whole menu.
        close() {
            this.cancelOpen();
            this.cancelClose();
            this.isOpen = false;
        },
    }));
});

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
