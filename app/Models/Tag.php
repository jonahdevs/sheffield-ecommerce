<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Tags\Tag as SpatieTag;

class Tag extends SpatieTag
{
    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }
}
