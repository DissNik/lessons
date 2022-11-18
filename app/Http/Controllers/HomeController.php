<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\ViewModels\BrandViewModels;
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

        $brands = BrandViewModels::make()
            ->homePage();

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
