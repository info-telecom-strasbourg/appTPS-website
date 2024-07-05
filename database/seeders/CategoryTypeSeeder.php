<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryType;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryType::create([
            'name' => 'Tout',
            'is_shown' => true,
        ]);

        CategoryType::create([
            'name' => 'Admis 2023',
            'is_shown' => true,
        ]);

        CategoryType::create([
            'name' => 'Admis 2024',
            'is_shown' => true,
        ]);

        CategoryType::create([
            'name' => 'Neurchi',
            'is_shown' => true,
        ]);

        CategoryType::create([
            'name' => 'Boite Tactique',
            'is_shown' => true,
        ]);

        CategoryType::create([
            'name' => 'Objets Perdus',
            'is_shown' => true,
        ]);

        CategoryType::create([
            'name' => 'Clubs et Assos',
            'is_shown' => true,
        ]);

        CategoryType::create([
            'name' => 'Fouailles',
            'is_shown' => false,
        ]);

        CategoryType::create([
            'name' => 'Poly',
            'is_shown' => false,
        ]);

        CategoryType::create([
            'name' => 'Activités',
            'is_shown' => false,
        ]);

    }
}
