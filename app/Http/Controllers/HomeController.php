<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\ViewModels\CategoryViewModels;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): Factory|View|Application
    {
        $categories = CategoryViewModels::make()
            ->homePage();

        $brands = Brand::query()
            ->homePage()
            ->get();

        $products = Product::query()
            ->homePage()
            ->get();

        return view('index', compact(
            'categories',
            'brands',
            'products'
        ));
    }
}
