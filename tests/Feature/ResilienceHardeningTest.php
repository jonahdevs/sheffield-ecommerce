<?php

use App\Jobs\ProcessSapProductSync;
use App\Jobs\RecoverSapInvoiceJob;
use App\Jobs\SyncOrderToSapJob;
use App\Models\Order;
use App\Notifications\SapSyncFailedNotification;
use App\Rules\Recaptcha;
use App\Services\Paystack\PaystackClient;
use App\Settings\IntegrationSettings;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

it('keeps every queue retry_after longer than the longest job timeout', function () {
    $longestTimeout = collect([
        ProcessSapProductSync::class,
        RecoverSapInvoiceJob::class,
        SyncOrderToSapJob::class,
    ])->map(fn (string $job) => (new ReflectionClass($job))->getDefaultProperties()['timeout'] ?? 60)->max();

    $retryAfters = collect(config('queue.connections'))
        ->pluck('retry_after')
        ->filter()
        ->all();

    expect($retryAfters)->not->toBeEmpty();

    foreach ($retryAfters as $retryAfter) {
        expect($retryAfter)->toBeGreaterThan($longestTimeout);
    }
});

it('never lets a scheduled command start a second copy of itself', function () {
    $events = app(Schedule::class)->events();

    $overlapping = collect($events)
        ->reject(fn ($event) => $event->withoutOverlapping)
        ->map(fn ($event) => $event->command)
        ->all();

    expect($overlapping)->toBe([]);
});

it('retries a Paystack verify through a server error instead of reading it as failure', function () {
    Http::preventStrayRequests();

    Http::fakeSequence()
        ->push(['status' => false], 500)
        ->push(['status' => true, 'data' => ['status' => 'success']], 200);

    $result = (new PaystackClient('sk_test_fake'))->verifyTransaction('ref_123');

    expect($result['status'])->toBeTrue()
        ->and($result['data']['status'])->toBe('success');

    Http::assertSentCount(2);
});

it('does not retry a Paystack verify that returns a real not-found answer', function () {
    Http::preventStrayRequests();
    Http::fake(['api.paystack.co/*' => Http::response(['status' => false], 404)]);

    $result = (new PaystackClient('sk_test_fake'))->verifyTransaction('ref_unknown');

    expect($result['status'])->toBeFalse();

    Http::assertSentCount(1);
});

it('fails reCAPTCHA closed when Google is unreachable instead of erroring', function () {
    app(IntegrationSettings::class)->fill(['recaptcha_site_key' => 'site-key'])->save();
    config()->set('services.recaptcha.secret', 'secret-key');

    Http::preventStrayRequests();
    Http::fake(['www.google.com/*' => Http::failedConnection()]);

    $failures = [];

    (new Recaptcha)->validate('g-recaptcha-response', 'token', function (string $message) use (&$failures) {
        $failures[] = $message;
    });

    expect($failures)->toHaveCount(1);
});

it('keeps the SAP sync failure notification off the queue so it stays serializable', function () {
    // It holds a live \Throwable; queueing it fails on the closures in the trace.
    expect(new SapSyncFailedNotification(
        order: Order::factory()->make(),
        exception: new RuntimeException('boom'),
    ))->not->toBeInstanceOf(ShouldQueue::class);
});
