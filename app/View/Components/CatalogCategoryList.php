<?php

namespace App\View\Components;

use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class CatalogCategoryList extends Component
{
    public Collection $categories;

    public function __construct()
    {
        $this->categories = Category::query()
            ->select('title', 'slug', 'icon')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.catalog-category-list');
    }
}
