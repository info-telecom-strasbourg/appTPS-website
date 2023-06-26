<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sector::create([
            'name' => 'Informatique et Réseaux',
            'short_name' => 'IR'
        ]);

        Sector::create([
            'name' => 'Sciences et Technologies pour la Santé',
            'short_name' => 'TI'
        ]);

        Sector::create([
            'name' => 'Généraliste',
            'short_name' => 'Géné'
        ]);

        Sector::create([
            'name' => 'Alternance',
            'short_name' => 'FIP'
        ]);
    }
}
