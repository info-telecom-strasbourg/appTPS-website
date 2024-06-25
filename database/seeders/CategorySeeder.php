<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Tout'
        ]);

        Category::create([
            'name' => 'Admis 2023'
        ]);

        Category::create([
            'name' => 'Admis 2024'
        ]);

        Category::create([
            'name' => 'Nerchi'
        ]);

        Category::create([
            'name' => 'Boite Tactique'
        ]);

        Category::create([
            'name' => 'Objets Perdus'
        ]);

        Category::create([
            'name' => 'Clubs et Assos'
        ]);
    }
}
