<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=> Hash::make('12345678'),
            'role' => 'admin',
        ]);
        
        //SensorData::factory()->count(100)->create();

    }
}
