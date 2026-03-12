<?php

namespace App\View\Composers;

use App\Enums\CategorySection;
use App\Models\Category;
use Illuminate\View\View;

class FooterComposer
{
    public function compose(View $view): void
    {
        $view->with(
            'footerCategories',
            Category::inSection(CategorySection::FOOTER)->take(5)->get()
        );
    }
}
