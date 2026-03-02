<?php

namespace App\Models;

use Spatie\Tags\Tag as SpatieTag;

class Tag extends SpatieTag
{
    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }
}
