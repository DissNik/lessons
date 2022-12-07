<?php

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $price = $this->faker->numberBetween(10000, 1000000);
        $old_price = intdiv($price * $this->faker->numberBetween(110, 150), 100);
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'thumbnail' => $this->faker->fixturesImage('products', 'products'),
            'price' => $this->faker->numberBetween(10000, 1000000),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'on_home_page' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
            'quantity' => $this->faker->numberBetween(0, 20),
            'text' => $this->faker->text(),
            'old_price' => $this->faker->boolean() ? $old_price : 0
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
