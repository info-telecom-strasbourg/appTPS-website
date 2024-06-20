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
            'icon' => 'ThumbsUp',
        ]);

        ReactionType::create([
            'name' => 'dislike',
            'icon' => 'ThumbsDown',
        ]);

        ReactionType::create([
            'name' => 'love',
            'icon' => 'Heart',
        ]);

        ReactionType::create([
            'name' => 'laugh',
            'icon' => 'Laugh',
        ]);

        ReactionType::create([
            'name' => 'cry',
            'icon' => 'Frown',
        ]);
    }
}
