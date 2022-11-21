<?php

use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Sorting\SortingManager;
use Support\Flash\Flash;

if (!function_exists('flash')) {
    function flash(): Flash
    {
        return (app(Flash::class));
    }
}

if (!function_exists('filters')) {
    function filters(): array
    {
        return (app(FilterManager::class)->items());
    }
}

if (!function_exists('sorting')) {
    function sorting(): array
    {
        return (app(SortingManager::class)->items());
    }
}
