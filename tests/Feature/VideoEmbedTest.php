<?php

use App\Enums\VideoProvider;
use App\Services\VideoEmbed;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

it('resolves a standard YouTube watch URL', function () {
    $resolved = app(VideoEmbed::class)->resolve('https://www.youtube.com/watch?v=dQw4w9WgXcQ');

    expect($resolved)->not->toBeNull()
        ->and($resolved['provider'])->toBe(VideoProvider::YOUTUBE)
        ->and($resolved['embed_url'])->toBe('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ')
        ->and($resolved['thumbnail_url'])->toBe('https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg');
});

it('resolves a shortened youtu.be URL', function () {
    $resolved = app(VideoEmbed::class)->resolve('https://youtu.be/dQw4w9WgXcQ');

    expect($resolved['embed_url'])->toBe('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ');
});

it('resolves a YouTube shorts URL', function () {
    $resolved = app(VideoEmbed::class)->resolve('https://www.youtube.com/shorts/dQw4w9WgXcQ');

    expect($resolved['embed_url'])->toBe('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ');
});

it('resolves a Vimeo URL via its oEmbed endpoint', function () {
    Http::fake([
        'vimeo.com/api/oembed.json*' => Http::response(['thumbnail_url' => 'https://i.vimeocdn.com/video/123.jpg']),
    ]);

    $resolved = app(VideoEmbed::class)->resolve('https://vimeo.com/76979871');

    expect($resolved['provider'])->toBe(VideoProvider::VIMEO)
        ->and($resolved['embed_url'])->toBe('https://player.vimeo.com/video/76979871')
        ->and($resolved['thumbnail_url'])->toBe('https://i.vimeocdn.com/video/123.jpg');
});

it('returns null for a Vimeo URL when the oEmbed call fails', function () {
    Http::fake(['vimeo.com/api/oembed.json*' => Http::response(null, 404)]);

    expect(app(VideoEmbed::class)->resolve('https://vimeo.com/76979871'))->toBeNull();
});

it('returns null for a Vimeo URL when the oEmbed call times out', function () {
    Http::fake(fn () => throw new ConnectionException('Connection timed out'));

    expect(app(VideoEmbed::class)->resolve('https://vimeo.com/76979871'))->toBeNull();
});

it('returns null for a URL from an unsupported provider', function () {
    expect(app(VideoEmbed::class)->resolve('https://example.com/some-video'))->toBeNull();
});

it('downloads thumbnail bytes to a local temp file', function () {
    Http::fake(['img.youtube.com/*' => Http::response('fake-jpeg-bytes')]);

    $path = app(VideoEmbed::class)->downloadThumbnail('https://img.youtube.com/vi/abc123/hqdefault.jpg');

    expect($path)->not->toBeNull()
        ->and(file_exists($path))->toBeTrue()
        ->and(file_get_contents($path))->toBe('fake-jpeg-bytes');

    unlink($path);
});

it('returns null when the thumbnail download fails', function () {
    Http::fake(['img.youtube.com/*' => Http::response(null, 404)]);

    expect(app(VideoEmbed::class)->downloadThumbnail('https://img.youtube.com/vi/abc123/hqdefault.jpg'))->toBeNull();
});

it('returns null when the thumbnail download times out', function () {
    Http::fake(fn () => throw new ConnectionException('Connection timed out'));

    expect(app(VideoEmbed::class)->downloadThumbnail('https://img.youtube.com/vi/abc123/hqdefault.jpg'))->toBeNull();
});
