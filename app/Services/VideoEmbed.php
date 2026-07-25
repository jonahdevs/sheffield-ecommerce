<?php

namespace App\Services;

use App\Enums\VideoProvider;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

/**
 * Resolves a pasted YouTube/Vimeo URL into embeddable gallery metadata, and
 * downloads the provider's thumbnail so it can back a Spatie Media row like a
 * real image (Spatie's own addMediaFromUrl() downloads via a raw fopen()
 * stream rather than the Http facade, which Http::fake() can't intercept -
 * fetching through Http::get() here keeps the whole flow test-fakeable).
 */
class VideoEmbed
{
    /**
     * @return array{provider: VideoProvider, embed_url: string, thumbnail_url: ?string}|null
     */
    public function resolve(string $url): ?array
    {
        $url = trim($url);

        if ($id = $this->youtubeId($url)) {
            return [
                'provider' => VideoProvider::YOUTUBE,
                'embed_url' => "https://www.youtube-nocookie.com/embed/{$id}",
                'thumbnail_url' => "https://img.youtube.com/vi/{$id}/hqdefault.jpg",
            ];
        }

        if ($this->vimeoId($url)) {
            return $this->fetchVimeoOembed($url);
        }

        return null;
    }

    /**
     * Downloads thumbnail bytes to a local temp file; null on any failure.
     * The caller owns cleanup of the returned path.
     */
    public function downloadThumbnail(string $url): ?string
    {
        try {
            $response = Http::timeout(10)->get($url);
        } catch (ConnectionException) {
            return null;
        }

        if (! $response->successful()) {
            return null;
        }

        $path = tempnam(sys_get_temp_dir(), 'video-thumb');
        file_put_contents($path, $response->body());

        return $path;
    }

    private function youtubeId(string $url): ?string
    {
        if (preg_match('#(?:youtube\.com/(?:watch\?v=|shorts/|embed/)|youtu\.be/)([A-Za-z0-9_-]{6,})#', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    private function vimeoId(string $url): ?string
    {
        if (preg_match('#vimeo\.com/(?:video/)?(\d+)#', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * @return array{provider: VideoProvider, embed_url: string, thumbnail_url: ?string}|null
     */
    private function fetchVimeoOembed(string $originalUrl): ?array
    {
        try {
            $response = Http::timeout(5)->acceptJson()
                ->get('https://vimeo.com/api/oembed.json', ['url' => $originalUrl]);
        } catch (ConnectionException) {
            return null;
        }

        if (! $response->successful()) {
            return null;
        }

        $id = $this->vimeoId($originalUrl);

        if (! $id) {
            return null;
        }

        return [
            'provider' => VideoProvider::VIMEO,
            'embed_url' => "https://player.vimeo.com/video/{$id}",
            'thumbnail_url' => $response->json('thumbnail_url'),
        ];
    }
}
