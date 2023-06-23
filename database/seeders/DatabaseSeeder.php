<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\MediaTypeSeeder;
use Database\Seeders\ReactionTypeSeeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\Post;
use App\Models\PostMedia;
use App\Models\PostComment;
use App\Models\Reaction;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            MediaTypeSeeder::class,
            ReactionTypeSeeder::class,
        ]);

        Event::factory(10)->create();

        Post::factory(20)->create();

        PostMedia::factory(5)->create();

        PostComment::factory(20)->create();

        Reaction::factory(50)->create();
    }
}
