<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected ?string $password = '12345678';
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make($this->password), // 👈 always hash passwords
            'role' => $this->faker->randomElement(['user', 'admin']),
            'is_active' => $this->faker->boolean(90), // 90% chance active
            'remember_token' => Str::random(10),
        ];
    }


   
}
