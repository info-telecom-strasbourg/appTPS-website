<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'enzo',
            'last_name' => 'bergamini',
            'user_name' => 'zozoLeZozo',
            'email' => 'bergaminienzo62@gmail.com',
            'phone' => '0606060606',
            'password' => bcrypt('azertyuiop'),
            'avatar' => 'default.png',
            'bde_id' => 1,
            'email_verified_at' => now(),
        ]);

        User::factory(10)->create();

        User::all()->each(function ($user) {
            $user->tokens()->create([
                'name' => 'auth_token',
                'token' => hash('sha256', 'N7fp6GTjO9CJD1QIhqv0Ty1ZZbJeS3tFIbToFJZQ'.$user->id)
            ]);
        });
    }
}
