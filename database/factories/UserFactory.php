<?php

namespace Database\Factories;

use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Bde\Member;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bde_id = $this->faker->unique()->numberBetween(1, Member::count()-1);

        return [
            'user_name' => $this->faker->unique()->userName(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'email_verified_at' => now(),
            'password' => Hash::make('Azertyuiop1#'),
            'sector_id' => Sector::inRandomOrder()->first()->id,
            'promotion_year' => random_int(2022, 2026),
            'bde_id' => $bde_id,
            'birth_date' => $this->faker->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d'),
        ];
    }
}
