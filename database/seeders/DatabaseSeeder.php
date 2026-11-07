<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Device;
use App\Models\SensorData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=> Hash::make('12345678'),
            'role' => 'admin',
        ]);

        User::factory(30)->create();

         // Ensure devices exist
        Device::firstOrCreate([
            'uid' => 'ESP32-001',
            'name' => 'ESP32 Gas Sensor primary',
            'type' => 'ESP32',
            'location' => 'Workshop Gas Monitor',
            'gas_threshold' => 500,
            'temperature_threshold' => 40,
            'humidity_threshold' => 85,
            "gas_mod_threshold"=> 300,
            "temperature_mod_threshold"=> 35,
            "humidity_mod_threshold"=> 65,
            'is_active' => true,
        ]);

        Device::firstOrCreate([
            'uid' => 'ESP32-002',
            'name' => 'ESP32 Gas Sensor',
            'type' => 'ESP32',
            'location' => 'Lab Gas Monitor',
            'gas_threshold' => 500,
            'temperature_threshold' => 40,
            'humidity_threshold' => 85,
            "gas_mod_threshold"=> 300,
            "temperature_mod_threshold"=> 35,
            "humidity_mod_threshold"=> 65,
            "is_active" => true,
        ]);
        // Device::factory()->count(100)->create();

        // // Seed sensor data linked to devices
        // SensorData::factory()->count(500)->create();

    }
}
