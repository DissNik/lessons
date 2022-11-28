<?php

namespace App\Providers;

use App\Filters\BrandFilter;
use App\Filters\PriceFilter;
use App\Sorting\PriceSorter;
use App\Sorting\TitleSorter;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Sorter\SorterManager;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FilterManager::class);
        $this->app->singleton(SorterManager::class);
    }

    public function boot(): void
    {
        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandFilter()
        ]);

        app(SorterManager::class)->registerSorting([
            new PriceSorter(),
            new TitleSorter()
        ]);
    }
}
