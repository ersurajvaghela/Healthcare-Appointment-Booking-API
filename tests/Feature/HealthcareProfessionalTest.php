<?php

namespace Tests\Feature;

use App\Models\HealthcareProfessional;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthcareProfessionalTest extends TestCase {

    use RefreshDatabase;

    protected User $user;
    protected string $token;

    protected function setUp(): void {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_user_can_view_active_healthcare_professionals() {
        HealthcareProfessional::factory()->count(3)->create(['is_active' => true]);
        HealthcareProfessional::factory()->create(['is_active' => false]);

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer ' . $this->token,
                ])->getJson('/api/healthcare-professionals');

        $response->assertStatus(200)
                ->assertJsonCount(3, 'data')
                ->assertJsonStructure([
                    'message',
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'specialty',
                            'email',
                            'phone',
                            'is_active',
                        ]
                    ]
        ]);
    }

    public function test_user_can_view_specific_healthcare_professional() {
        $professional = HealthcareProfessional::factory()->create();

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer ' . $this->token,
                ])->getJson("/api/healthcare-professionals/{$professional->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'message',
                    'data' => [
                        'id',
                        'name',
                        'specialty',
                        'email',
                        'phone',
                        'is_active',
                    ]
        ]);
    }

    public function test_unauthenticated_user_cannot_access_healthcare_professionals() {
        $response = $this->getJson('/api/healthcare-professionals');

        $response->assertStatus(401);
    }

}
