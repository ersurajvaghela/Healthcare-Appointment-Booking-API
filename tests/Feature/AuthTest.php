<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase {

    use RefreshDatabase;

    public function test_user_can_register() {
        $userData = [
            'name' => 'Suraj Vaghela',
            'email' => 'er.suraj1307@gmail.com',
            'password' => 'suraj@1307',
            'password_confirmation' => 'suraj@1307',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'message',
                    'user' => ['id', 'name', 'email'],
                    'token'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Suraj Vaghela',
            'email' => 'er.suraj1307@gmail.com',
        ]);
    }

    public function test_user_cannot_register_with_invalid_data() {
        $userData = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_user_can_login() {
        $user = User::factory()->create([
            'email' => 'er.suraj1307@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $loginData = [
            'email' => 'er.suraj1307@gmail.com',
            'password' => 'suraj@1307',
        ];

        $response = $this->postJson('/api/login', $loginData);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'message',
                    'user' => ['id', 'name', 'email'],
                    'token'
        ]);
    }

    public function test_user_cannot_login_with_invalid_credentials() {
        $user = User::factory()->create([
            'email' => 'er.suraj1307@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $loginData = [
            'email' => 'er.suraj1307@gmail.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/login', $loginData);

        $response->assertStatus(401)
                ->assertJson(['message' => 'Invalid credentials']);
    }

    public function test_authenticated_user_can_logout() {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                ])->postJson('/api/logout');

        $response->assertStatus(200)
                ->assertJson(['message' => 'Logged out successfully']);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

}
