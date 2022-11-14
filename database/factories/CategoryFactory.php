<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'on_home_page' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
            'thumbnail' => $this->faker->fixturesImage('categories', 'images/categories'),
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
