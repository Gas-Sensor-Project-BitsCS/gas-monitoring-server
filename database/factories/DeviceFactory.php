<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uid' => fake()->unique()->bothify('ESP32-####'),
            'location' => fake()->randomElement([
                'Kitchen Gas Monitor',
                'Lab Gas Monitor',
                'Office Gas Monitor',
            ]),
            'gas_threshold' => fake()->numberBetween(250, 400),
            'temperature_threshold' => 50,
            'humidity_threshold' => 85,
            'last_seen_at' => now(),
        ];
    }
}
