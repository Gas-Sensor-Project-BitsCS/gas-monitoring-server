<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Device;
class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Device::create([
            'uid' => 'ESP32-001',
            'location' => 'Kitchen Gas Monitor',
            'gas_threshold' => 500,
            'temperature_threshold' => 40,
            'humidity_threshold' => 85,
            "gas_mod_threshold"=> 300,
            "temperature_mod_threshold"=> 35,
            "humidity_mod_threshold"=> 65,
            'last_seen_at' => now(),
        ]);

        Device::create([
            'uid' => 'ESP32-002',
            'location' => 'Lab Gas Monitor',
            'gas_threshold' => 500,
            'temperature_threshold' => 40,
            'humidity_threshold' => 85,
            "gas_mod_threshold"=> 300,
            "temperature_mod_threshold"=> 35,
            "humidity_mod_threshold"=> 65,
            'last_seen_at' => now(),
        ]);
    }
}
