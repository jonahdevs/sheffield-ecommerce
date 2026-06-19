<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Single source of truth for the readable, stable filenames used when storing
 * uploaded images. Mirrors the scheme applied to seed sources by the
 * media:rename-sources command so admin uploads and seeded data stay consistent.
 *
 *   product        {name}-{sku}.{ext}
 *   product gallery {name}-{sku}-{n}.{ext}
 *   product variant {name}-{sku}-variant-{n}.{ext}
 *   category        {slug}.{ext} | {slug}-icon.{ext} | {slug}-banner.{ext}
 *   brand           {slug}.{ext}
 */
class MediaNaming
{
    public static function product(string $name, ?string $sku, string $ext): string
    {
        return self::base($name, $sku).self::ext($ext);
    }

    public static function productGallery(string $name, ?string $sku, int $index, string $ext): string
    {
        return self::base($name, $sku).'-'.$index.self::ext($ext);
    }

    public static function productVariant(string $name, ?string $sku, int $index, string $ext): string
    {
        return self::base($name, $sku).'-variant-'.$index.self::ext($ext);
    }

    /**
     * Category filename for a given media collection (square/icon/banner).
     */
    public static function category(string $slug, string $collection, string $ext): string
    {
        $suffix = match ($collection) {
            'icon' => '-icon',
            'banner' => '-banner',
            default => '',
        };

        return (Str::slug($slug) ?: 'category').$suffix.self::ext($ext);
    }

    public static function brand(string $slug, string $ext): string
    {
        return (Str::slug($slug) ?: 'brand').self::ext($ext);
    }

    public static function avatar(string $name, int|string $id, string $ext): string
    {
        return (Str::slug($name) ?: 'user').'-'.$id.self::ext($ext);
    }

    private static function base(string $name, ?string $sku): string
    {
        return (Str::slug($name) ?: 'product').'-'.(Str::slug((string) $sku) ?: 'no-sku');
    }

    private static function ext(string $ext): string
    {
        $clean = strtolower(ltrim($ext, '.'));

        return $clean !== '' ? '.'.$clean : '.jpg';
    }
}
