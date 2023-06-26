<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
           'name' => 'Informatique et Réseaux',
           'short_name' => 'IR'
        ]);

        Group::create([
           'name' => 'Sciences et Technologies pour le Santé',
           'short_name' => 'TI'
        ]);

        Group::create([
           'name' => 'Généraliste',
           'short_name' => 'Géné'
        ]);

    }
}
