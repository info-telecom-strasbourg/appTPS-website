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
            'id' => 1001,
            'first_name' => 'Fabien',
            'last_name' => 'prégaldini',
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
            'first_name' => 'Fabien',
            'last_name' => 'prégaldini',
            'user_name' => 'fab.preg',
            'description' => 'Je suis fabien et je suis le goat, ceci est ma description, je suis le directeur de TP. Il faut pas lui dire mais j\'ai pour objectif de ne pas donner le diplome d\'ingénieur à l\'élève Romain Bourdin',
            'email' => 'email@email.com',
            'phone' => '0606060606',
            'password' => Hash::make('test'),
            'bde_id' => $test_member->id,
            'admission_year' => 2024,
            'sector_id' => 2,
            'birth_date' => '2000-01-01',
            'email_verified_at' => now()
        ]);

        $test_user->tokens()->create([
            'name' => 'auth_token',
            'token' => hash('sha256', 'test')
        ]);

        User::factory(Member::count()-1)->create();

        User::all()->each(function ($user) {
            $user->tokens()->create([
                'name' => 'auth_token',
                'token' => hash('sha256', 'N7fp6GTjO9CJD1QIhqv0Ty1ZZbJeS3tFIbToFJZQ'.$user->id)
            ]);
        });
    }
}
