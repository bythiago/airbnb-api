<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'home_type' => $this->faker->word(),
            'room_type' => $this->faker->word(),
            'total_occupancy' => $this->faker->randomNumber(),
            'total_bedrooms' => $this->faker->randomNumber(),
            'total_bathrooms' => $this->faker->randomNumber(),
            'summary' => $this->faker->paragraph(2),
            'address' => $this->faker->address(),
            'has_tv' => $this->faker->boolean(),
            'has_kitchen' => $this->faker->boolean(),
            'has_air_con' => $this->faker->boolean(),
            'has_heating' => $this->faker->boolean(),
            'has_internet' => $this->faker->boolean(),
            'price' => $this->faker->randomNumber(3),
            'published_at' => $this->faker->date(),
            'owner_id' => 1,
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
        ];
    }
}
