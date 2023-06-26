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
           'name' => 'Les foufou',
           'short_name' => 'foufou'
        ]);

        Group::create([
           'name' => 'les dingo',
           'short_name' => 'LD'
        ]);

        Group::create([
           'name' => 'Les gentils',
           'short_name' => 'LG'
        ]);

    }
}
