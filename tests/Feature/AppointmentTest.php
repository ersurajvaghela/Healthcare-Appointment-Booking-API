<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\HealthcareProfessional;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentTest extends TestCase {

    use RefreshDatabase;

    protected User $user;
    protected HealthcareProfessional $professional;
    protected string $token;

    protected function setUp(): void {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->professional = HealthcareProfessional::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_user_can_book_appointment() {
        $appointmentData = [
            'healthcare_professional_id' => $this->professional->id,
            'appointment_start_time' => Carbon::tomorrow()->setHour(10)->toISOString(),
            'appointment_end_time' => Carbon::tomorrow()->setHour(11)->toISOString(),
            'notes' => 'Regular checkup',
        ];

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer ' . $this->token,
                ])->postJson('/api/appointments', $appointmentData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'message',
                    'data' => [
                        'id',
                        'user_id',
                        'healthcare_professional',
                        'appointment_start_time',
                        'appointment_end_time',
                        'status',
                        'notes',
                    ]
        ]);

        $this->assertDatabaseHas('appointments', [
            'user_id' => $this->user->id,
            'healthcare_professional_id' => $this->professional->id,
            'status' => 'booked',
        ]);
    }

    public function test_user_cannot_book_conflicting_appointment() {
        // Create existing appointment
        $startTime = Carbon::tomorrow()->setHour(10);
        $endTime = Carbon::tomorrow()->setHour(11);

        Appointment::factory()->create([
            'healthcare_professional_id' => $this->professional->id,
            'appointment_start_time' => $startTime,
            'appointment_end_time' => $endTime,
            'status' => 'booked',
        ]);

        // Try to book conflicting appointment
        $appointmentData = [
            'healthcare_professional_id' => $this->professional->id,
            'appointment_start_time' => $startTime->copy()->addMinutes(30)->toISOString(),
            'appointment_end_time' => $endTime->copy()->addMinutes(30)->toISOString(),
        ];

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer ' . $this->token,
                ])->postJson('/api/appointments', $appointmentData);

        $response->assertStatus(422)
                ->assertJson([
                    'message' => 'Failed to book appointment',
                    'error' => 'The selected time slot is not available. Please choose a different time.',
        ]);
    }

    public function test_user_can_view_their_appointments() {
        $appointment = Appointment::factory()->create([
            'user_id' => $this->user->id,
            'healthcare_professional_id' => $this->professional->id,
        ]);

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer ' . $this->token,
                ])->getJson('/api/appointments');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'message',
                    'data' => [
                        '*' => [
                            'id',
                            'user_id',
                            'healthcare_professional',
                            'appointment_start_time',
                            'appointment_end_time',
                            'status',
                        ]
                    ]
        ]);
    }

    public function test_user_can_cancel_appointment() {
        $appointment = Appointment::factory()->create([
            'user_id' => $this->user->id,
            'healthcare_professional_id' => $this->professional->id,
            'appointment_start_time' => Carbon::now()->addDays(2),
            'appointment_end_time' => Carbon::now()->addDays(2)->addHour(),
            'status' => 'booked',
        ]);

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer ' . $this->token,
                ])->patchJson("/api/appointments/{$appointment->id}/cancel");

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Appointment cancelled successfully',
        ]);

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_user_cannot_cancel_appointment_within_24_hours() {
        $appointment = Appointment::factory()->create([
            'user_id' => $this->user->id,
            'healthcare_professional_id' => $this->professional->id,
            'appointment_start_time' => Carbon::now()->addHours(12),
            'appointment_end_time' => Carbon::now()->addHours(13),
            'status' => 'booked',
        ]);

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer ' . $this->token,
                ])->patchJson("/api/appointments/{$appointment->id}/cancel");

        $response->assertStatus(422)
                ->assertJson([
                    'message' => 'Failed to cancel appointment',
                    'error' => 'Appointment cannot be cancelled. It must be cancelled at least 24 hours before the scheduled time.',
        ]);
    }

    public function test_user_cannot_access_other_users_appointments() {
        $otherUser = User::factory()->create();
        $appointment = Appointment::factory()->create([
            'user_id' => $otherUser->id,
            'healthcare_professional_id' => $this->professional->id,
        ]);

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer ' . $this->token,
                ])->getJson("/api/appointments/{$appointment->id}");

        $response->assertStatus(403)
                ->assertJson(['message' => 'Unauthorized access to appointment']);
    }

}
