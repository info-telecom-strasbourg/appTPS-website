<?php

namespace Database\Seeders\Bde;

use App\Models\Bde\Product;
use App\Models\Bde\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->create([
            'name' => 'cocktail12',
            'title' => 'cocktail12',
            'price' => 1.2,
            'product_type_id' => ProductType::where('type', 'Soirée')->first()->id,
            'color' => fake()->hexColor()
        ]);

        Product::factory()->create([
            'name' => 'cocktail16',
            'title' => 'cocktail16',
            'price' => 1.6,
            'product_type_id' => ProductType::where('type', 'Soirée')->first()->id,
            'color' => fake()->hexColor()
        ]);

        Product::factory()->create([
            'name' => 'meteor',
            'title' => 'meteor',
            'price' => 1.2,
            'product_type_id' => ProductType::where('type', 'Soirée')->first()->id,
            'color' => fake()->hexColor()
        ]);

        Product::factory()->create([
            'name' => 'pizza',
            'title' => 'pizza',
            'price' => 2.6,
            'product_type_id' => ProductType::where('type', 'Midi')->first()->id,
            'color' => fake()->hexColor()
        ]);


        Product::factory()->create([
            'name' => 'sandwich',
            'title' => 'sandwich',
            'price' => 2,
            'product_type_id' => ProductType::where('type', 'Midi')->first()->id,
            'color' => fake()->hexColor()
        ]);

        Product::factory()->create([
            'name' => 'charcuterie',
            'title' => 'charcuterie',
            'price' => 4.4,
            'product_type_id' => ProductType::where('type', 'CharcutFromage')->first()->id,
            'color' => fake()->hexColor()
        ]);

        Product::factory()->create([
            'name' => 'fromage',
            'title' => 'fromage',
            'price' => 3,
            'product_type_id' => ProductType::where('type', 'CharcutFromage')->first()->id,
            'color' => fake()->hexColor()
        ]);

        Product::factory()->create([
            'name' => 'bordeaux',
            'title' => 'bordeaux',
            'price' => 1.6,
            'product_type_id' => ProductType::where('type', 'Oeno')->first()->id,
            'color' => fake()->hexColor()
        ]);

        Product::factory()->create([
            'name' => 'cookies',
            'title' => 'cookies',
            'price' => 2.2,
            'product_type_id' => ProductType::where('type', 'Goûter')->first()->id,
            'color' => fake()->hexColor()
        ]);

        Product::factory()->create([
            'name' => 'metre',
            'title' => 'metre',
            'price' => 1.2,
            'product_type_id' => ProductType::where('type', 'Shots')->first()->id,
            'color' => fake()->hexColor()
        ]);
    }
}
