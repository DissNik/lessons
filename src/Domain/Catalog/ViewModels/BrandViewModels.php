<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class BrandViewModels
{
    use Makeable;

    public function homePage(): Collection|array
    {
        return Cache::rememberForever('brand_home_page', function () {
            return Brand::query()
                ->select(['id', 'title', 'slug'])
                ->homePage()
                ->get();
        });
    }
}
