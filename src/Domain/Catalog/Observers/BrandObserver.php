<?php

namespace Domain\Catalog\Observers;

use Domain\Catalog\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandObserver
{
    public function created(Brand $brand): void
    {
        Cache::forget('brand_home_page');
    }

    public function updated(Brand $brand): void
    {
        Cache::forget('brand_home_page');
    }

    public function deleted(Brand $brand): void
    {
        Cache::forget('brand_home_page');
    }

    public function restored(Brand $brand): void
    {
        Cache::forget('brand_home_page');
    }
}
