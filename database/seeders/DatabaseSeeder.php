<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\PropertyFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Brand::factory(20)->create();

        $properties = PropertyFactory::new()->count(10)->create();

        OptionFactory::new()->count(2)->create();

        $optionValue = OptionValueFactory::new()->count(10)->create();

        Category::factory(15)
            ->has(Product::factory(rand(1, 20))
                ->hasAttached($optionValue)
                ->hasAttached($properties, function () {
                    return ['value' => ucfirst(fake()->word())];
                })
            )
            ->create();
    }
}
