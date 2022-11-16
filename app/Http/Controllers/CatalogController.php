<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function __invoke(?Category $category): Factory|View|Application
    {
        $categories = Category::query()
            ->select(['id', 'title', 'slug', 'thumbnail'])
            ->has('products')
            ->get();

        $brands = Brand::query()
            ->leftJoin(
                'products',
                'products.brand_id',
                '=',
                'brands.id'
            )
            ->select('brands.id', 'brands.title', DB::raw('count(*) as count'))
            ->groupBy('brands.id')
            ->has('products')
            ->get();

        $products = Product::query()
            ->select(['id', 'title', 'slug', 'price', 'thumbnail'])
            ->when(request('search'), function (Builder $query) {
                $query->whereFullText(['title', 'text'], request('search'));
            })
            ->when($category->exists, function (Builder $query) use ($category) {
                $query->whereRelation(
                    'categories',
                    'categories.id',
                    '=',
                    $category->id);
            })
            ->filtered()
            ->sorted()
            ->paginate(9);

        return view('catalog.index', compact(
            'categories',
            'brands',
            'products',
            'category'
        ));
    }
}
