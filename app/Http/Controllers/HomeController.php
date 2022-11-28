<?php

namespace App\Http\Controllers;

use Domain\Catalog\ViewModels\BrandViewModels;
use Domain\Catalog\ViewModels\CategoryViewModels;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): Factory|View|Application
    {
        $products = Product::query()
            ->homePage()
            ->get();

        return view('index', [
            'categories' => CategoryViewModels::make()->homePage(),
            'brands' => BrandViewModels::make()->homePage(),
            'products' => $products
        ]);
    }
}
