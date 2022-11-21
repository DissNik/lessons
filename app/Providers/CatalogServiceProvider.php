<?php

namespace App\Providers;

use App\Filters\BrandFilter;
use App\Filters\PriceFilter;
use App\Sorting\PriceSorting;
use App\Sorting\TitleSorting;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Sorting\SortingManager;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FilterManager::class);
        $this->app->singleton(SortingManager::class);
    }

    public function boot(): void
    {
        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandFilter()
        ]);

        app(SortingManager::class)->registerSorting([
            new PriceSorting(),
            new TitleSorting()
        ]);
    }
}
