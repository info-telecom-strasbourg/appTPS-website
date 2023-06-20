<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Client;
use Illuminate\Database\Seeder;
use App\Models\MediaType;
use App\Models\PostMedia;
use App\Models\Post;
use App\Models\Event;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        MediaType::factory(2)->create();
        PostMedia::factory(10)->create();
        Post::factory(10)->create();
        Event::factory(10)->create();
    }
}
