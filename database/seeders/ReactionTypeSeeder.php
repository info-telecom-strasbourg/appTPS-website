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
            'icon' => '👍',
        ]);

        ReactionType::create([
            'name' => 'dislike',
            'icon' => '👎',
        ]);

        ReactionType::create([
            'name' => 'love',
            'icon' => '❤️',
        ]);

        ReactionType::create([
            'name' => 'laugh',
            'icon' => '😂',
        ]);

        ReactionType::create([
            'name' => 'cry',
            'icon' => '😢',
        ]);

        ReactionType::create([
            'name' => 'angry',
            'icon' => '😡',
        ]);
    }
}
