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
            'color' => '#9208D2',
            'emoji' => '⭐',
            'is_shown' => true,
            'is_for_event' => false,
        ]);

        CategoryType::create([
            'name' => 'Admis 2023',
            'color' => '#0865D2',
            'emoji' => '📘',
            'is_shown' => true,
            'is_for_event' => false,
        ]);

        CategoryType::create([
            'name' => 'Admis 2024',
            'color' => '#0865D2',
            'emoji' => '📕',
            'is_shown' => true,
            'is_for_event' => false,
        ]);

        CategoryType::create([
            'name' => 'Neurchi',
            'color' => '#D27508',
            'emoji' => '😊',
            'is_shown' => true,
            'is_for_event' => false,
        ]);

        CategoryType::create([
            'name' => 'Boite Tactique',
            'color' => '#D22C08',
            'emoji' => '🛏️',
            'is_shown' => true,
            'is_for_event' => false,
        ]);

        CategoryType::create([
            'name' => 'Objets Perdus',
            'color' => '#08D241',
            'emoji' => '🗝️',
            'is_shown' => true,
            'is_for_event' => false,
        ]);

        CategoryType::create([
            'name' => 'Clubs et Assos',
            'color' => '#D2BE08',
            'emoji' => '🏢',
            'is_shown' => true,
            'is_for_event' => true,
        ]);

        CategoryType::create([
            'name' => 'Fouailles',
            'color' => '#D20808',
            'emoji' => '🍺',
            'is_shown' => false,
            'is_for_event' => true,
        ]);

        CategoryType::create([
            'name' => 'Poly',
            'color' => '#08D2C9',
            'emoji' => '🍾',
            'is_shown' => false,
            'is_for_event' => true,
        ]);

        CategoryType::create([
            'name' => 'Activités',
            'color' => '#046b70',
            'emoji' => '⚽',
            'is_shown' => false,
            'is_for_event' => true,
        ]);

    }
}
