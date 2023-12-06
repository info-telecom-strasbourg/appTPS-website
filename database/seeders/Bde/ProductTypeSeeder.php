<?php

namespace Database\Seeders\Bde;

use App\Models\Bde\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductType::factory()->create([
            'type' => 'Midi',
        ]);

        ProductType::factory()->create([
            'type' => 'Soirée',
        ]);

        ProductType::factory()->create([
            'type' => 'CharcutFromage',
        ]);

        ProductType::factory()->create([
            'type' => 'Oeno',
        ]);

        ProductType::factory()->create([
            'type' => 'Shots',
        ]);

        ProductType::factory()->create([
            'type' => 'Goûter',
        ]);
    }
}
