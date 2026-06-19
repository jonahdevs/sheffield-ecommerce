<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Static URL helper used by Category, Brand, and the sync command for legacy
 * path columns. The product_images table and Eloquent model are no longer used;
 * images are now managed via Spatie Media Library on the Product model.
 */
class ProductImage
{
    public static function resolveUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
