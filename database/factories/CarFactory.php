<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'license_plate'   => strtoupper($this->faker->bothify('??-###-??')),
            'brand'           => $this->faker->randomElement(['BMW','Audi','Mercedes','Tesla','Volkswagen','Toyota','Ford']),
            'model'           => $this->faker->word(),
            'price'           => $this->faker->numberBetween(500, 100000),
            'mileage'         => $this->faker->numberBetween(0, 250000),
            'seats'           => $this->faker->numberBetween(2, 7),
            'doors'           => $this->faker->numberBetween(2, 5),
            'production_year' => $this->faker->numberBetween(1995, 2025),
            'weight'          => $this->faker->numberBetween(800, 2500),
            'color'           => $this->faker->safeColorName(),
            'image'           => $this->faker->imageUrl(640, 480, 'car', true),
            'sold_at'         => null,
            'views'           => $this->faker->numberBetween(0, 500),
        ];
    }
}
