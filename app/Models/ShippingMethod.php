<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ===============================================
    // RELATIONSHIPS
    // ===============================================

    public function rates(): HasMany
    {
        return $this->hasMany(ShippingRate::class);
    }

    // ===============================================
    // SCOPE
    // ===============================================

    #[Scope]
    protected function active(Builder $query)
    {
        $query->where('is_active', true);
    }
}
