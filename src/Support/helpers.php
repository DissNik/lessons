<?php

use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Models\Category;
use Domain\Catalog\Sorter\SorterManager;
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

if (!function_exists('sorter')) {
    function sorter(): array
    {
        return (app(SorterManager::class)->items());
    }
}

if (!function_exists('is_catalog_view')) {
    function is_catalog_view(string $type, string $default = 'grid'): bool
    {
        $view = request()->get('view', cookie('view_products')->getValue() ?? $default);

        return $view === $type;
    }
}

if (!function_exists('filter_url')) {
    function filter_url(?Category $category, array $params = []): string
    {
        return route('catalog', [
            ...request()->only(['filters', 'sort']),
            ...$params,
            'category' => $category
        ]);
    }
}
