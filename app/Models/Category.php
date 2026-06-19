<?php

namespace App\Models;

use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[Fillable(['name', 'slug', 'parent_id', 'description', 'banner', 'image', 'icon', 'icon_svg', 'status', 'sort_order', 'meta_title', 'meta_description', 'canonical_url'])]
class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    /**
     * Distinct image roles, each a single-file collection:
     * - banner: wide hero stripe at the top of the category page
     * - square: square tile used in grids (home "Shop by category", menus)
     * - icon:   small glyph in the category navigation
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner')->singleFile();
        $this->addMediaCollection('square')->singleFile();
        $this->addMediaCollection('icon')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('web')
            ->performOnCollections('banner')
            ->fit(Fit::Crop, 1920, 600)
            ->nonQueued();

        $this->addMediaConversion('web-webp')
            ->performOnCollections('banner')
            ->fit(Fit::Crop, 1920, 600)
            ->format('webp')
            ->quality(85)
            ->nonQueued();

        $this->addMediaConversion('card')
            ->performOnCollections('square')
            ->fit(Fit::Crop, 600, 600)
            ->nonQueued();

        $this->addMediaConversion('card-webp')
            ->performOnCollections('square')
            ->fit(Fit::Crop, 600, 600)
            ->format('webp')
            ->quality(85)
            ->nonQueued();

        // Small square crop of the main image, shown in the admin category list.
        $this->addMediaConversion('thumb')
            ->performOnCollections('square')
            ->fit(Fit::Crop, 120, 120)
            ->nonQueued();

        // Tiny placeholder inlined as base64 for blur-up loading. JPEG at q20 keeps it under 1 KB.
        $this->addMediaConversion('lqip')
            ->performOnCollections('banner', 'square')
            ->width(64)
            ->quality(20)
            ->format('jpg')
            ->nonQueued();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'slug', 'status', 'parent_id'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('category');
    }

    protected function casts(): array
    {
        return [
            'status' => CategoryStatus::class,
        ];
    }

    // ==================================================
    // RELATIONSHIPS
    // ==================================================

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function placements(): HasMany
    {
        return $this->hasMany(CategoryPlacement::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('sort_order');
    }

    // ==================================================
    // ACCESSORS
    // ==================================================

    /**
     * Wide hero banner for the category page.
     * Falls back to image_url so categories with only a square image still
     * get a hero rather than a blank stripe.
     */
    protected function bannerUrl(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMediaUrl('banner', 'web')
            ?: ProductImage::resolveUrl($this->banner)
            ?: $this->image_url);
    }

    /** Primary square image for grid tiles and menus. Null when none is set. */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMediaUrl('square', 'card')
            ?: ProductImage::resolveUrl($this->image));
    }

    /** WebP version of the square tile; null until the conversion has been generated. */
    protected function imageWebpUrl(): Attribute
    {
        return Attribute::get(function () {
            $media = $this->getFirstMedia('square');

            return $media?->hasGeneratedConversion('card-webp')
                ? $media->getUrl('card-webp')
                : null;
        });
    }

    /** WebP version of the banner hero; null until the conversion has been generated. */
    protected function bannerWebpUrl(): Attribute
    {
        return Attribute::get(function () {
            $media = $this->getFirstMedia('banner');

            return $media?->hasGeneratedConversion('web-webp')
                ? $media->getUrl('web-webp')
                : null;
        });
    }

    /** Small square crop of the main image for the admin list; falls back to the full image/banner. */
    protected function imageThumbUrl(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMediaUrl('square', 'thumb')
            ?: $this->image_url);
    }

    /** Inline base64 LQIP for the banner; falls back to the square lqip when only an image is set. */
    protected function bannerPlaceholder(): Attribute
    {
        return Attribute::get(fn () => $this->mediaPlaceholder('banner') ?? $this->mediaPlaceholder('square'));
    }

    /** Inline base64 LQIP for the square image. Null when no square image is set. */
    protected function imagePlaceholder(): Attribute
    {
        return Attribute::get(fn () => $this->mediaPlaceholder('square'));
    }

    /** Small navigation icon image (SVG markup in icon_svg is handled separately). */
    protected function iconImageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMediaUrl('icon')
            ?: ProductImage::resolveUrl($this->icon));
    }

    /**
     * Build (and cache) a base64 data-URI from a collection's 'lqip' conversion.
     * Returns null when no media or the conversion has not been generated.
     */
    private function mediaPlaceholder(string $collection): ?string
    {
        $media = $this->getFirstMedia($collection);

        if (! $media || ! $media->hasGeneratedConversion('lqip')) {
            return null;
        }

        return cache()->rememberForever(
            "category-lqip-{$media->id}-{$media->updated_at?->timestamp}",
            function () use ($media) {
                $path = $media->getPath('lqip');

                if (! is_file($path)) {
                    return null;
                }

                return 'data:image/jpeg;base64,'.base64_encode(file_get_contents($path));
            }
        );
    }

    // Backwards-compatible alias for the previous column-based accessor.

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image_url);
    }

    protected function iconUrl(): Attribute
    {
        return Attribute::get(fn () => $this->icon_image_url);
    }
}
