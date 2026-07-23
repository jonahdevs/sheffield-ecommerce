<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

/**
 * Extends the Spatie Media model with accessors that keep existing templates
 * working without modification after migrating off ProductImage.
 */
class Media extends BaseMedia
{
    /** Backward-compatible $media->url accessor - returns the original file URL. */
    protected function url(): Attribute
    {
        return Attribute::get(fn () => $this->getUrl());
    }

    /** Alt text stored in custom_properties['alt']. */
    protected function alt(): Attribute
    {
        return Attribute::get(fn () => $this->getCustomProperty('alt', ''));
    }
}
