<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Tags\Tag;

/**
 * A single (tag, product) row of the shared `taggables` pivot table, carrying the
 * sort_order that Spatie's own tags()/attachTag() never reads or writes. Scoped to
 * Product taggables only, since Tag is the only model using HasTags today.
 */
#[Fillable(['tag_id', 'taggable_id', 'taggable_type', 'sort_order'])]
class TagProduct extends Model
{
    protected $table = 'taggables';

    public $timestamps = false;

    protected static function booted(): void
    {
        static::addGlobalScope('product', fn ($query) => $query->where('taggable_type', Product::class));
        static::creating(fn (self $row) => $row->taggable_type ??= Product::class);
    }

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    // ==================================================
    // RELATIONSHIPS
    // ==================================================

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'taggable_id');
    }
}
