<?php

namespace Database\Factories;

use App\Models\SensorData;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SensorData>
 */
class SensorDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = SensorData::class;
    public function definition(): array
    {
        return [
            'device_id'   => Device::inRandomOrder()->first()->id, 
            'gas_value'   => $this->faker->randomFloat(2, 10, 50), // PPM range
            'temperature' => $this->faker->randomFloat(2, 15, 45),  // Celsius
            'humidity'    => $this->faker->randomFloat(2, 30, 90),  // Percentage
            // 'status'      => $this->faker->randomElement(['normal', 'warning', 'critical']),
            'recorded_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
