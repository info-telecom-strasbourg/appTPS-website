<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ReactionType;

class ReactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReactionType::create([
            'name' => 'like',
            'icon' => 'fas fa-thumbs-up',
        ]);

        ReactionType::create([
            'name' => 'dislike',
            'icon' => 'fas fa-thumbs-down',
        ]);

        ReactionType::create([
            'name' => 'love',
            'icon' => 'fas fa-heart',
        ]);

        ReactionType::create([
            'name' => 'laugh',
            'icon' => 'fas fa-laugh',
        ]);

        ReactionType::create([
            'name' => 'cry',
            'icon' => 'fas fa-sad-tear',
        ]);
    }
}
