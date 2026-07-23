<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Free-text place lookup for the address book's search box, backed by Photon -
 * the OpenStreetMap geocoder built for autocomplete. Results are biased to
 * Kenya with a bounding box and memoised for a day, since the same handful of
 * estates and landmarks get typed over and over.
 *
 * Only reached when the map provider is Leaflet. The Google provider resolves
 * suggestions client-side through the Places library it already loads.
 */
class PlaceSearch
{
    private const ENDPOINT = 'https://photon.komoot.io/api';

    /** Kenya's bounding box, as Photon wants it: minLon,minLat,maxLon,maxLat. */
    private const KENYA_BBOX = '33.9,-4.7,41.9,5.5';

    private const LIMIT = 6;

    private const CACHE_TTL = 86400;

    /**
     * Shorter queries match half of Nairobi and waste a round trip.
     */
    public const MIN_QUERY_LENGTH = 3;

    /**
     * @return array<int, array{label: string, latitude: float, longitude: float}>
     */
    public function search(string $query): array
    {
        $query = trim($query);

        if (mb_strlen($query) < self::MIN_QUERY_LENGTH) {
            return [];
        }

        $key = 'places:'.md5(mb_strtolower($query));

        if (($cached = Cache::get($key)) !== null) {
            return $cached;
        }

        $results = $this->fetch($query);

        // Only successes are cached. Caching a miss would let one blip at the
        // geocoder blank this query out for the rest of the TTL.
        if ($results !== []) {
            Cache::put($key, $results, self::CACHE_TTL);
        }

        return $results;
    }

    /**
     * Returns an empty list rather than throwing: a geocoder that is down or
     * slow should cost the customer their suggestions, not their checkout.
     *
     * @return array<int, array{label: string, latitude: float, longitude: float}>
     */
    private function fetch(string $query): array
    {
        try {
            $response = Http::timeout(5)->acceptJson()->get(self::ENDPOINT, [
                'q' => $query,
                'limit' => self::LIMIT,
                'lang' => 'en',
                'bbox' => self::KENYA_BBOX,
            ]);
        } catch (ConnectionException) {
            return [];
        }

        if (! $response->successful()) {
            return [];
        }

        return collect($response->json('features') ?? [])
            ->map(fn (array $feature): ?array => $this->toSuggestion($feature))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @param  array<string, mixed>  $feature
     * @return array{label: string, latitude: float, longitude: float}|null
     */
    private function toSuggestion(array $feature): ?array
    {
        $coordinates = $feature['geometry']['coordinates'] ?? null;

        if (! is_array($coordinates) || count($coordinates) < 2) {
            return null;
        }

        $label = $this->label($feature['properties'] ?? []);

        if ($label === '') {
            return null;
        }

        return [
            'label' => $label,
            // GeoJSON orders coordinates as [longitude, latitude].
            'longitude' => (float) $coordinates[0],
            'latitude' => (float) $coordinates[1],
        ];
    }

    /**
     * Collapses Photon's address parts into one human-readable line.
     *
     * Two quirks of the Kenyan OSM data are smoothed over here: districts come
     * back as administrative units ("Highridge division") rather than the
     * neighbourhood name people actually use, and `state` restates `city` in
     * Nairobi. So the division suffix is trimmed, and the county is only shown
     * when there is no town to show instead.
     *
     * @param  array<string, mixed>  $properties
     */
    private function label(array $properties): string
    {
        $street = trim(implode(' ', array_filter([
            $properties['housenumber'] ?? null,
            $properties['street'] ?? null,
        ])));

        $district = preg_replace('/\s+division$/i', '', (string) ($properties['district'] ?? ''));

        $parts = array_filter([
            $properties['name'] ?? null,
            $street,
            $district,
            $properties['city'] ?? $properties['state'] ?? null,
        ]);

        return implode(', ', array_unique($parts));
    }
}
