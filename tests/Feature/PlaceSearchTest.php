<?php

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Builds a Photon-shaped response body from the given features.
 *
 * @param  array<int, array{coordinates: array<int, float>, properties: array<string, mixed>}>  $features
 * @return array<string, mixed>
 */
function photonResponse(array $features): array
{
    return [
        'features' => array_map(fn (array $feature): array => [
            'geometry' => ['type' => 'Point', 'coordinates' => $feature['coordinates']],
            'properties' => $feature['properties'],
        ], $features),
    ];
}

beforeEach(function () {
    Cache::flush();
});

it('returns geocoded suggestions for a query', function () {
    Http::fake(['photon.komoot.io/*' => Http::response(photonResponse([
        [
            'coordinates' => [36.8034, -1.2673],
            'properties' => ['name' => 'ABC Place', 'street' => 'Waiyaki Way', 'district' => 'Westlands', 'city' => 'Nairobi'],
        ],
    ]))]);

    $this->getJson(route('places.search', ['q' => 'ABC Place']))
        ->assertOk()
        ->assertExactJson([[
            'label' => 'ABC Place, Waiyaki Way, Westlands, Nairobi',
            'longitude' => 36.8034,
            // GeoJSON orders [lng, lat] — a swap here would pin addresses in the wrong hemisphere.
            'latitude' => -1.2673,
        ]]);
});

it('joins the house number onto the street and drops repeated parts', function () {
    Http::fake(['photon.komoot.io/*' => Http::response(photonResponse([
        [
            'coordinates' => [36.8219, -1.2921],
            'properties' => ['housenumber' => '12', 'street' => 'Riverside Drive', 'district' => 'Nairobi', 'city' => 'Nairobi'],
        ],
    ]))]);

    $this->getJson(route('places.search', ['q' => 'Riverside']))
        ->assertOk()
        ->assertJsonPath('0.label', '12 Riverside Drive, Nairobi');
});

it('trims the administrative division suffix off the district', function () {
    Http::fake(['photon.komoot.io/*' => Http::response(photonResponse([
        [
            'coordinates' => [36.8032, -1.2618],
            'properties' => ['name' => 'Sarit Centre Roundabout', 'district' => 'Highridge division', 'city' => 'Nairobi', 'state' => 'Nairobi County'],
        ],
    ]))]);

    // The county is dropped: "Nairobi, Nairobi County" reads as a stutter.
    $this->getJson(route('places.search', ['q' => 'Sarit']))
        ->assertOk()
        ->assertJsonPath('0.label', 'Sarit Centre Roundabout, Highridge, Nairobi');
});

it('falls back to the county when a place has no town', function () {
    Http::fake(['photon.komoot.io/*' => Http::response(photonResponse([
        ['coordinates' => [36.9, -1.1], 'properties' => ['name' => 'Juja Farm', 'state' => 'Kiambu County']],
    ]))]);

    $this->getJson(route('places.search', ['q' => 'Juja Farm']))
        ->assertOk()
        ->assertJsonPath('0.label', 'Juja Farm, Kiambu County');
});

it('skips features that carry no coordinates', function () {
    Http::fake(['photon.komoot.io/*' => Http::response([
        'features' => [
            ['geometry' => [], 'properties' => ['name' => 'Nowhere']],
            ['geometry' => ['coordinates' => [36.8, -1.3]], 'properties' => ['name' => 'Somewhere']],
        ],
    ])]);

    $this->getJson(route('places.search', ['q' => 'where']))
        ->assertOk()
        ->assertJsonCount(1)
        ->assertJsonPath('0.label', 'Somewhere');
});

it('does not call the geocoder for a query below the minimum length', function () {
    Http::fake();

    $this->getJson(route('places.search', ['q' => 'ab']))
        ->assertOk()
        ->assertExactJson([]);

    Http::assertNothingSent();
});

it('returns an empty list when the geocoder errors', function () {
    Http::fake(['photon.komoot.io/*' => Http::response(null, 503)]);

    $this->getJson(route('places.search', ['q' => 'Westlands']))
        ->assertOk()
        ->assertExactJson([]);
});

it('returns an empty list when the geocoder times out', function () {
    Http::fake(fn () => throw new ConnectionException('Connection timed out'));

    $this->getJson(route('places.search', ['q' => 'Westlands']))
        ->assertOk()
        ->assertExactJson([]);
});

it('does not cache a failed lookup', function () {
    Http::fakeSequence()
        ->push(null, 503)
        ->push(photonResponse([
            ['coordinates' => [36.81, -1.26], 'properties' => ['name' => 'Westlands']],
        ]));

    $this->getJson(route('places.search', ['q' => 'Westlands']))->assertExactJson([]);

    // A blip must not blank the query out for the rest of the cache TTL.
    $this->getJson(route('places.search', ['q' => 'Westlands']))
        ->assertOk()
        ->assertJsonPath('0.label', 'Westlands');
});

it('caches results so a repeated query hits the geocoder once', function () {
    Http::fake(['photon.komoot.io/*' => Http::response(photonResponse([
        ['coordinates' => [36.8034, -1.2673], 'properties' => ['name' => 'Sarit Centre']],
    ]))]);

    // Same place, different casing and padding — all one cache entry.
    $this->getJson(route('places.search', ['q' => 'Sarit Centre']))->assertOk();
    $this->getJson(route('places.search', ['q' => '  sarit centre ']))->assertOk();

    Http::assertSentCount(1);
});
