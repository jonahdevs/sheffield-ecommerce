<?php

namespace App\Livewire\Concerns;

use App\Enums\ReviewStatus;
use App\Enums\StockStatus;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;

/**
 * Shared product-filter state and query logic for the storefront listing pages
 * (catalog and category). Both pages expose the same price / brand / rating /
 * availability facets and paginate the same way; each keeps only its divergent
 * bits — the category facet, its own category scope, and any extra filters
 * (catalog's free-text search, tags and new-arrivals).
 *
 * The host component must define a `products` computed property (unset here to
 * invalidate its memo) and a `brandsList` computed used by the shared Blade
 * panel at partials/storefront/filters-panel.blade.php.
 */
trait HasProductFilters
{
    public int $perPage = 24;

    public bool $showFilters = false;

    /**
     * Category facet selection. Catalog stores slugs (string); the category page
     * stores child-category ids (int) — both round-trip fine as a URL array.
     *
     * @var array<int, int|string>
     */
    #[Url(as: 'cat', history: true)]
    public array $selectedCategories = [];

    /** @var array<int, int> */
    #[Url(as: 'brand', history: true)]
    public array $selectedBrands = [];

    /** Price slider bounds in KES (whole units). DB stores cents. */
    #[Url(as: 'pmin', history: true)]
    public int $priceMin = 0;

    #[Url(history: true)]
    public int $priceMax = 6000000;

    #[Url(as: 'stock', history: true)]
    public bool $inStockOnly = false;

    /** Minimum average approved-review rating (0 = any). */
    #[Url(as: 'rating', history: true)]
    public int $minRating = 0;

    #[Url(history: true)]
    public string $sort = 'popularity';

    /** Reset paging and drop the memoised listing whenever any filter changes. */
    public function updating(string $prop): void
    {
        $this->perPage = 24;
        unset($this->products);
    }

    public function loadMore(): void
    {
        $this->perPage += 12;
        unset($this->products);
    }

    public function removeBrand(int $id): void
    {
        $this->selectedBrands = array_values(array_filter($this->selectedBrands, fn ($b) => $b !== $id));
    }

    /**
     * Apply the filters common to both listings: brand, availability, rating and
     * price. Category scope and any page-specific filters are applied by the host.
     *
     * @param  Builder<Product>  $query
     */
    protected function applySharedFilters(Builder $query): void
    {
        if ($this->selectedBrands) {
            $query->whereIn('brand_id', $this->selectedBrands);
        }

        if ($this->inStockOnly) {
            $query->where('stock_status', StockStatus::IN_STOCK->value);
        }

        if ($this->minRating > 0) {
            $query->whereIn(
                'id',
                Review::query()
                    ->select('product_id')
                    ->where('status', ReviewStatus::APPROVED->value)
                    ->groupBy('product_id')
                    ->havingRaw('AVG(rating) >= ?', [$this->minRating]),
            );
        }

        // priceMax/priceMin in KES → cents. Null prices count as "unpriced" and
        // are kept only while the lower bound is untouched.
        $query->where(function ($q) {
            $q->whereNull('price')->orWhere('price', '<=', $this->priceMax * 100);
        });

        if ($this->priceMin > 0) {
            $query->whereNotNull('price')->where('price', '>=', $this->priceMin * 100);
        }
    }

    /**
     * @param  Builder<Product>  $query
     */
    protected function applySort(Builder $query): void
    {
        match ($this->sort) {
            'price-asc' => $query->orderByRaw('price IS NULL, price ASC'),
            'price-desc' => $query->orderByRaw('price IS NULL, price DESC'),
            'name-asc' => $query->orderBy('name'),
            'newest' => $query->latest('id'),
            default => $query->orderBy('sort_order')->orderByDesc('id'), // popularity proxy
        };
    }

    /** Whether any shared (non-category-facet) filter is active. */
    protected function hasSharedActiveFilters(): bool
    {
        return ! empty($this->selectedBrands)
            || $this->inStockOnly
            || $this->minRating > 0
            || $this->priceMin > 0
            || $this->priceMax < 6000000;
    }

    /**
     * Reset the shared facets (category, brand, availability, rating, price) and
     * paging. Pages with extra filters reset those before calling this.
     */
    protected function resetSharedFilters(): void
    {
        $this->reset(['selectedCategories', 'selectedBrands', 'inStockOnly', 'minRating']);
        $this->priceMin = 0;
        $this->priceMax = 6000000;
        $this->perPage = 24;
        unset($this->products);
    }
}
