<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'thumbnail' => $this->faker->fixturesImage('products', 'images/products'),
            'price' => $this->faker->numberBetween(1000, 100000),
            'brand_id' => Brand::query()->first()->inRandomOrder()->value('id'),
            'on_home_page' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }

    public function homePage(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'on_home_page' => true
            ];
        });
    }
}
