<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase; // Resets the database after each test

    public function test_user_can_register_successfully(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'John Doe',
            'email'                 => 'john@example.com',
            'password'              => 'password123',
            // 'password_confirmation' => 'password123',
        ]);

        // Assert redirect to dashboard and user exists in DB
        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
        $this->assertAuthenticated();
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_incorrect_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
