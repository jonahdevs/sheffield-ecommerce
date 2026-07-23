<?php

use App\Http\Controllers\DeliveryConfirmationController;
use App\Http\Controllers\Dev\MailPreviewController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Payments\MpesaCallbackController;
use App\Http\Controllers\Payments\PaystackWebhookController;
use App\Http\Controllers\Payments\StripeWebhookController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\Storefront\CategoryMenuController;
use App\Models\Cart;
use App\Services\PlaceSearch;
use App\Support\StorefrontSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ---------------------------------------------------------------------------
// Payment provider callbacks (server-to-server, no auth, CSRF-exempt)
// ---------------------------------------------------------------------------
Route::post('/api/webhooks/mpesa', MpesaCallbackController::class)->name('payments.mpesa.callback');
Route::post('/api/webhooks/stripe', StripeWebhookController::class)->name('payments.stripe.webhook');
Route::post('/api/webhooks/paystack', PaystackWebhookController::class)->name('payments.paystack.webhook');

// ---------------------------------------------------------------------------
// Storefront (guests + logged-in browsing)
// ---------------------------------------------------------------------------
Route::livewire('/', 'pages::storefront.home')->name('home');
Route::livewire('/categories', 'pages::storefront.categories')->name('categories.index');
Route::livewire('/shop', 'pages::storefront.catalog')->name('catalog');
Route::livewire('/shop/{category:slug}', 'pages::storefront.category')->name('category.show');
Route::livewire('/cart', 'pages::storefront.cart')->name('cart');
// Signed "restore my cart" link from an abandoned-cart reminder email: rehydrate
// the saved cart into the session and bounce to the cart page.
Route::get('/cart/restore/{cart}', function (Cart $cart) {
    if ($cart->user) {
        StorefrontSession::hydrateFromUserCart($cart->user);
        $cart->markActive();
    }

    return redirect()->route('cart');
})->name('cart.restore')->middleware('signed');
Route::livewire('/wishlist', 'pages::storefront.wishlist')->name('wishlist');
Route::livewire('/compare', 'pages::storefront.compare')->name('compare');
Route::livewire('/contact', 'pages::storefront.contact')->name('contact');
Route::livewire('/request-quote', 'pages::storefront.request-quote')->name('quote.request');
Route::livewire('/quotes/{quote}/review', 'pages::storefront.quote-review')->name('quotes.guest-review')->middleware('signed');
Route::livewire('/checkout', 'pages::storefront.checkout')->name('checkout')->middleware(['auth', 'customer']);
Route::livewire('/pay/{order}', 'pages::storefront.payment')->name('payment.page')->middleware(['auth', 'customer']);
Route::livewire('/product/{product:slug}', 'pages::storefront.product')->name('product.show');

// Mega-menu flyout body - fetched on hover by the category navigation.
Route::get('/menu/{category:slug}/flyout', CategoryMenuController::class)
    ->name('menu.flyout');

// Address-book search box. Proxies the geocoder server-side so the caching and
// outbound identity stay ours. Public, because the quote form takes an address
// from guests - throttled to keep it from being used as a free geocoding API.
Route::get('/places/search', function (Request $request, PlaceSearch $places) {
    return response()->json($places->search((string) $request->query('q', '')));
})->name('places.search')->middleware('throttle:30,1');

// ---------------------------------------------------------------------------
// Newsletter - confirm & unsubscribe (public, no auth)
// ---------------------------------------------------------------------------
Route::controller(NewsletterController::class)
    ->prefix('newsletter')
    ->name('newsletter.')
    ->group(function () {
        Route::get('confirm/{token}', 'confirm')->name('confirm');
        Route::get('unsubscribe/{token}', 'unsubscribe')->name('unsubscribe');
    });

// ---------------------------------------------------------------------------
// Social auth - Google
// ---------------------------------------------------------------------------
Route::middleware('guest')
    ->controller(SocialAuthController::class)
    ->prefix('auth/google')
    ->name('auth.google.')
    ->group(function () {
        Route::get('redirect', 'redirectToGoogle')->name('redirect');
        Route::get('callback', 'handleGoogleCallback')->name('callback');
    });

// ---------------------------------------------------------------------------
// Social auth - Facebook
// ---------------------------------------------------------------------------
Route::middleware('guest')
    ->controller(SocialAuthController::class)
    ->prefix('auth/facebook')
    ->name('auth.facebook.')
    ->group(function () {
        Route::get('redirect', 'redirectToFacebook')->name('redirect');
        Route::get('callback', 'handleFacebookCallback')->name('callback');
    });

// ---------------------------------------------------------------------------
// Post-login landing - branches by role.
// Customers go to their account dashboard; admins are bounced to /admin.
// TODO: swap the hasRole check for spatie/laravel-permission once installed.
// ---------------------------------------------------------------------------
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();

    if (method_exists($user, 'roles') && $user->roles->isNotEmpty()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('account.dashboard');
})->name('dashboard');

// ---------------------------------------------------------------------------
// Delivery confirmation - public signed URLs (no auth required)
// Customers confirm receipt or raise a dispute after receiving their order.
// ---------------------------------------------------------------------------
Route::controller(DeliveryConfirmationController::class)
    ->prefix('delivery')
    ->name('delivery.')
    ->group(function () {
        Route::get('{shipment}/confirm', 'show')->name('confirm')->middleware('signed');
        Route::post('{shipment}/confirm', 'confirm')->name('confirm.submit')->middleware('signed');
        Route::get('{shipment}/dispute', 'showDispute')->name('dispute')->middleware('signed');
        Route::post('{shipment}/dispute', 'submitDispute')->name('dispute.submit')->middleware('signed');
    });

require __DIR__.'/account.php';
require __DIR__.'/admin.php';

// ---------------------------------------------------------------------------
// Local-only email template previews - render the mail Blade views with sample
// data so the real, data-filled result is visible in the browser (Maizzle's
// preview can only show un-rendered Blade). Never registered outside local.
// ---------------------------------------------------------------------------
if (app()->environment('local')) {
    Route::controller(MailPreviewController::class)
        ->prefix('dev/mail-preview')
        ->group(function () {
            Route::get('/', 'index')->name('dev.mail-preview');
            Route::get('{template}', 'show')->name('dev.mail-preview.show');
        });
}

// ---------------------------------------------------------------------------
// CMS pages - registered LAST so every explicit route above wins. Single-segment
// slugs only; the component 404s on unpublished/unknown pages.
// ---------------------------------------------------------------------------
Route::livewire('/{page:slug}', 'pages::storefront.page')->name('page.show');

// ---------------------------------------------------------------------------
// Catch-all 404 - runs inside the web middleware group so the session/auth are
// started before the error view renders. This lets admin error pages show the
// signed-in user's permitted navigation and account menu (an unmatched route
// otherwise skips session middleware, leaving auth()->user() null).
// ---------------------------------------------------------------------------
Route::fallback(fn () => abort(404));
