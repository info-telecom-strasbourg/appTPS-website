<?php

namespace Database\Seeders;

use App\Models\Bde\Member;
use App\Models\Bde\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $test_member = Member::create([
            'first_name' => 'first_name',
            'last_name' => 'last_name',
            'card_number' => '12345678',
            'email' => 'email@email.com',
            'phone' => '0606060606',
            'balance' => 107.5,
            'admin' => 0,
            'contributor' => 1,
            'class' => 2024,
            'birth_date' => '2000-01-01',
            'sector' => 'ir',
            'created_at' => now()
        ]);

        $test_user = User::create([
            'first_name' => 'first_name',
            'last_name' => 'last_name',
            'user_name' => 'user_name',
            'email' => 'email@email.com',
            'phone' => '0606060606',
            'password' => Hash::make(hash('sha256', 'test'.'email@email.com')),
            'bde_id' => $test_member->id,
            'promotion_year' => 2024,
            'sector_id' => 2,
            'birth_date' => '2000-01-01',
            'email_verified_at' => now()
        ]);

        $test_user->tokens()->create([
            'name' => 'auth_token',
            'token' => hash('sha256', 'test')
        ]);

        User::factory(5)->create();

        User::all()->each(function ($user) {
            $user->tokens()->create([
                'name' => 'auth_token',
                'token' => hash('sha256', 'N7fp6GTjO9CJD1QIhqv0Ty1ZZbJeS3tFIbToFJZQ'.$user->id)
            ]);
        });
    }
}
