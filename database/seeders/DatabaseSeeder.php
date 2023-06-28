<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\GroupUser;
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
            SectorSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            MediaTypeSeeder::class,
            ReactionTypeSeeder::class,
            GroupSeeder::class
        ]);

        Event::factory(10)->create();

        Post::factory(20)->create();

        PostMedia::factory(5)->create();

        PostComment::factory(20)->create();

        PostComment::create([
            'user_id' => 1,
            'body' => "je suis un commentaire sous le post 1",
            'post_id' => 1,
        ]);

        PostComment::create([
            'user_id' => 2,
            'body' => "je suis un commentaire sous le post 1 sous le commentaire",
            'parent_comment_id' => 21
        ]);

        PostComment::create([
            'user_id' => 3,
            'body' => "je suis un commentaire sous le post 1 sous le commentaire par un autre utilisateur",
            'parent_comment_id' => 21
        ]);

        PostComment::create([
            'user_id' => 4,
            'body' => "je suis un commentaire sous le post 1 sous le commentaire du commentaire",
            'parent_comment_id' => 22
        ]);

        Reaction::factory(200)->create();

        GroupUser::factory(10)->create();
    }
}
