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
            // Safely grab an existing device ID, or create a new one if none exist yet
            'device_id'   => Device::inRandomOrder()->value('id') ?? Device::factory(), 
            
            'gas_value'   => $this->faker->randomFloat(2, 50.0, 850.0), // PPM range for gas detection
            'temperature' => $this->faker->randomFloat(2, 20.0, 55.0),  // Celsius
            'humidity'    => $this->faker->randomFloat(2, 30.0, 95.0),  // Percentage
            
            // 'status'      => $this->faker->randomElement(['normal', 'warning', 'critical']),
            
            'recorded_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
