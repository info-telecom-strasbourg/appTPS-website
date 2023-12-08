<?php

namespace Database\Factories\Bde;

use App\Models\Bde\Member;
use App\Models\Bde\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrganizationMember>
 */
class OrganizationMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => Organization::inRandomOrder()->first()->id,
            'member_id' => Member::inRandomOrder()->first()->id,
            'role' => fake()->randomElement(['president', 'trésorier', 'secrétaire', 'spons', 'reseaux', 'extérieur']),
        ];
    }
}
