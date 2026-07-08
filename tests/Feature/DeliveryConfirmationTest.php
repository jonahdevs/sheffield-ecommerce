<?php

use App\Models\Shipment;
use Illuminate\Support\Facades\URL;

function makeSignedConfirmUrl(Shipment $shipment): string
{
    return URL::signedRoute('delivery.confirm', ['shipment' => $shipment]);
}

function makeSignedDisputeUrl(Shipment $shipment): string
{
    return URL::signedRoute('delivery.dispute', ['shipment' => $shipment]);
}

// ---------------------------------------------------------------------------
// Confirm page (GET)
// ---------------------------------------------------------------------------

test('confirm page requires valid signature', function () {
    $shipment = Shipment::factory()->delivered()->create();

    $this->get(route('delivery.confirm', $shipment))->assertForbidden();
});

test('confirm page renders for a valid signed url', function () {
    $shipment = Shipment::factory()->delivered()->create();

    $this->get(makeSignedConfirmUrl($shipment))
        ->assertOk()
        ->assertSee($shipment->order->order_number)
        ->assertSee('Confirm your delivery');
});

test('confirm page shows the delivery driver when one is assigned', function () {
    $shipment = Shipment::factory()->delivered()->withDriver()->create([
        'driver_name' => 'John Kamau',
        'driver_phone' => '0712345678',
    ]);

    $this->get(makeSignedConfirmUrl($shipment))
        ->assertOk()
        ->assertSee('John Kamau')
        ->assertSee('0712345678');
});

test('confirm page shows dispute notice when already disputed', function () {
    $shipment = Shipment::factory()->delivered()->create([
        'customer_disputed_at' => now(),
        'customer_notes' => 'Missing one unit.',
    ]);

    $this->get(makeSignedConfirmUrl($shipment))
        ->assertOk()
        ->assertSee('You raised a dispute');
});

// ---------------------------------------------------------------------------
// Confirm action (POST)
// ---------------------------------------------------------------------------

test('post confirm requires valid signature', function () {
    $shipment = Shipment::factory()->delivered()->create();

    $this->post(route('delivery.confirm.submit', $shipment))->assertForbidden();
});

test('confirming sets customer_confirmed_at', function () {
    $shipment = Shipment::factory()->delivered()->create();
    $postUrl = URL::signedRoute('delivery.confirm.submit', ['shipment' => $shipment]);

    $this->post($postUrl)->assertOk()->assertSee('Receipt confirmed');

    expect($shipment->fresh()->customer_confirmed_at)->not->toBeNull();
});

test('confirming twice does not overwrite the original timestamp', function () {
    $originalTime = now()->subHour();
    $shipment = Shipment::factory()->delivered()->create(['customer_confirmed_at' => $originalTime]);
    $postUrl = URL::signedRoute('delivery.confirm.submit', ['shipment' => $shipment]);

    $this->post($postUrl)->assertOk();

    expect($shipment->fresh()->customer_confirmed_at->timestamp)->toBe($originalTime->timestamp);
});

// ---------------------------------------------------------------------------
// Dispute page (GET)
// ---------------------------------------------------------------------------

test('dispute page requires valid signature', function () {
    $shipment = Shipment::factory()->delivered()->create();

    $this->get(route('delivery.dispute', $shipment))->assertForbidden();
});

test('dispute page renders with a valid signed url', function () {
    $shipment = Shipment::factory()->delivered()->create();

    $this->get(makeSignedDisputeUrl($shipment))
        ->assertOk()
        ->assertSee('Report a delivery issue');
});

// ---------------------------------------------------------------------------
// Dispute submission (POST)
// ---------------------------------------------------------------------------

test('submitting dispute requires valid signature', function () {
    $shipment = Shipment::factory()->delivered()->create();

    $this->post(
        route('delivery.dispute.submit', $shipment),
        ['notes' => 'Item missing.']
    )->assertForbidden();
});

test('submitting dispute requires notes', function () {
    $shipment = Shipment::factory()->delivered()->create();
    $submitUrl = URL::signedRoute('delivery.dispute.submit', ['shipment' => $shipment]);

    $this->post($submitUrl, [])->assertSessionHasErrors('notes');
});

test('submitting dispute saves notes and timestamps', function () {
    $shipment = Shipment::factory()->delivered()->create();
    $submitUrl = URL::signedRoute('delivery.dispute.submit', ['shipment' => $shipment]);

    $this->post($submitUrl, ['notes' => 'Fridge arrived dented.'])
        ->assertOk()
        ->assertSee('Issue reported');

    $fresh = $shipment->fresh();
    expect($fresh->customer_disputed_at)->not->toBeNull();
    expect($fresh->customer_notes)->toBe('Fridge arrived dented.');
});

test('submitting dispute twice does not overwrite original disputed_at', function () {
    $original = now()->subHour();
    $shipment = Shipment::factory()->delivered()->create(['customer_disputed_at' => $original]);
    $submitUrl = URL::signedRoute('delivery.dispute.submit', ['shipment' => $shipment]);

    $this->post($submitUrl, ['notes' => 'Updated notes.'])->assertOk();

    expect($shipment->fresh()->customer_disputed_at->timestamp)->toBe($original->timestamp);
    expect($shipment->fresh()->customer_notes)->toBe('Updated notes.');
});
