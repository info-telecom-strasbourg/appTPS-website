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
            'type' => 'afterwork',
        ]);

        ProductType::factory()->create([
            'type' => 'gouter',
        ]);

        ProductType::factory()->create([
            'type' => 'oeno',
        ]);

        ProductType::factory()->create([
            'type' => 'repas',
        ]);

        ProductType::factory()->create([
            'type' => 'shot',
        ]);

        ProductType::factory()->create([
            'type' => 'soiree',
        ]);
    }
}
