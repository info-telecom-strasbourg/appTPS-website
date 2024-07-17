<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Bde\Organization;
use App\Models\Event;
use App\Models\CategoryType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $fake_date = $this->faker->dateTimeBetween('-30 day', '+0 day');

        if (random_int(0, 1) == 1) {
            $organization_id = Organization::inRandomOrder()->first()->id;
        }else{
            $organization_id = null;
        }

        if (random_int(0, 1) == 1) {
            $event_id = Event::inRandomOrder()->first()->id;
        }else{
            $event_id = null;
        }

        return [
            'body' => "{\"type\":\"doc\",\"content\":[{\"type\":\"paragraph\",\"content\":[{\"type\":\"text\",\"marks\":[{\"type\":\"bold\"}],\"text\":\"Ceci\"},{\"type\":\"text\",\"text\":\" est un test de la \"},{\"type\":\"text\",\"marks\":[{\"type\":\"underline\"}],\"text\":\"mise en forme\"},{\"type\":\"text\",\"text\":\" des \"},{\"type\":\"text\",\"marks\":[{\"type\":\"italic\"}],\"text\":\"posts\"},{\"type\":\"text\",\"text\":\".\"}]}]}",
            'user_id' => User::inRandomOrder()->first()->id,
            'organization_id' => $organization_id,
            'uploaded_at' => $fake_date,
            'event_id' => $event_id,
            'created_at' => $fake_date,
        ];
    }
}
