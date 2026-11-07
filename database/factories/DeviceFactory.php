<?php

namespace Database\Factories;

use App\Models\Device;
use App\Enums\DeviceType;
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
        $gasThreshold = $this->faker->numberBetween(300, 950);
        $tempThreshold = $this->faker->randomElement([45, 50, 55, 60]);
        $humidityThreshold = $this->faker->randomElement([80, 85, 90]);

        // Pull directly from your DeviceType Enum cases
        $typeEnum = $this->faker->randomElement(DeviceType::cases());
        $type = $typeEnum->value; // e.g., 'ESP32', 'ARDU', 'Device'
        
        $number = str_pad($this->faker->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT);

        return [
            'type' => $type,
            'uid' => "{$type}-{$number}",
            'name' => $this->faker->randomElement([
                "{$type} Primary Methane Monitor",
                "{$type} Environmental Node",
                "{$type} Ventilation Air Sensor",
                "{$type} Combustion Gas Detector",
                "{$type} Ambient Monitor Unit"
            ]),
            'location' => $this->faker->randomElement([
                'Mine Shaft 4 - Level 2',
                'Underground Main Tunnel East',
                'Chemical Storage Room B',
                'Factory Assembly Line 3',
                'Laboratory Fume Hood 1',
                'Boiler Room Sector C',
                'Ventilation Shaft 02'
            ]),
            'gas_threshold' => $gasThreshold,
            'temperature_threshold' => $tempThreshold,
            'humidity_threshold' => $humidityThreshold,

            // Ensure moderate < normal (fixed syntax errors from original snippet)
            'gas_mod_threshold' => $this->faker->numberBetween(150, $gasThreshold - 50),
            'temperature_mod_threshold' => $this->faker->numberBetween(25, $tempThreshold - 10),
            'humidity_mod_threshold' => $this->faker->numberBetween(50, $humidityThreshold - 10),
            
            'is_active' => $this->faker->boolean(85) // 85% chance of being active
        ];
    }
}
