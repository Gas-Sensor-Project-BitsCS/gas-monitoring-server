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

    protected $model = Device::class;
    public function definition(): array
    {
        // Generate the normal thresholds first
        $gasThreshold = $this->faker->numberBetween(250, 1000);
        $tempThreshold = 50;
        $humidityThreshold = 85;

        return [
            'uid' => $this->faker->unique()->bothify('ESP32-####'),
            'name' => $this->faker->randomElement([
                'ESP32 Gas Sensor',
                'Arduino Temp Monitor',
                'Raspberry Pi Humidity Sensor',
            ]),
            'location' => $this->faker->randomElement([
                'Kitchen room',
                'Lab Gas Monitor',
                'Office Gas Monitor',
            ]),
            'gas_threshold' => $gasThreshold,
            'temperature_threshold' => $tempThreshold,
            'humidity_threshold' => $humidityThreshold,

            // Ensure moderate < normal
            'gas_mod_threshold' => $this->faker->numberBetween(200, $gasThreshold - 20),
            'temperature_mod_threshold' => $this->faker->numberBetween(30, $tempThreshold - 10),
            'humidity_mod_threshold' => $this->faker->numberBetween(60, $humidityThreshold - 5),
            'is_active' => true
        ];
    }
}
