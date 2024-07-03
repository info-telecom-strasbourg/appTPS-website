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
        ]);

        ReactionType::create([
            'name' => 'dislike',
        ]);

        ReactionType::create([
            'name' => 'love',
        ]);

        ReactionType::create([
            'name' => 'laugh',
        ]);

        ReactionType::create([
            'name' => 'cry',
        ]);

        ReactionType::create([
            'name' => 'angry',
        ]);
    }
}
