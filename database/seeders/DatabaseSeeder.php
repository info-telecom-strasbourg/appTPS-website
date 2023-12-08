<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Bde\Member;
use App\Models\Bde\Order;
use App\Models\Bde\Organization;
use App\Models\Bde\OrganizationMember;
use App\Models\GroupUser;
use Database\Seeders\Bde\ProductSeeder;
use Database\Seeders\Bde\ProductTypeSeeder;
use Illuminate\Database\Seeder;
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

        // Bde bdd seeder
        Member::factory(50)->create();

        $this->call([
            ProductTypeSeeder::class,
            ProductSeeder::class,
        ]);

        Order::factory(200)->create();

        Organization::factory(10)->create();

        OrganizationMember::factory(50)->create();

        // app bdd seeder

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
