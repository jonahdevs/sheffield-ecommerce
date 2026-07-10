<?php

namespace App\Http\Controllers\Storefront;

use App\Enums\CategoryStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;

class CategoryMenuController extends Controller
{
    /**
     * Render a category's mega-menu flyout (promo image + children grid). Fetched
     * lazily on hover by the storefront navigation so panels aren't all rendered
     * up front. Only categories with active children act as dropdown triggers, so
     * this always returns at least one shoppable sub-category.
     */
    public function __invoke(Category $category): View
    {
        return view('partials.storefront.mega-menu-panel', [
            'category' => $category,
            'children' => $category->children()
                ->where('status', CategoryStatus::ACTIVE)
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
