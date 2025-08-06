<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Models\HealthcareProfessional;
use App\Models\User;
use App\Http\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentServiceTest extends TestCase {

    use RefreshDatabase;

    protected AppointmentService $appointmentService;
    protected User $user;
    protected HealthcareProfessional $professional;

    protected function setUp(): void {
        parent::setUp();

        $this->appointmentService = new AppointmentService();
        $this->user = User::factory()->create();
        $this->professional = HealthcareProfessional::factory()->create();
    }

    public function test_can_book_appointment_successfully() {
        $appointmentData = [
            'healthcare_professional_id' => $this->professional->id,
            'appointment_start_time' => Carbon::tomorrow()->setHour(10)->toISOString(),
            'appointment_end_time' => Carbon::tomorrow()->setHour(11)->toISOString(),
            'notes' => 'Regular checkup',
        ];

        $appointment = $this->appointmentService->bookAppointment($this->user, $appointmentData);

        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertEquals($this->user->id, $appointment->user_id);
        $this->assertEquals($this->professional->id, $appointment->healthcare_professional_id);
        $this->assertEquals('booked', $appointment->status);
    }

    public function test_cannot_book_conflicting_appointment() {
        $startTime = Carbon::tomorrow()->setHour(10);
        $endTime = Carbon::tomorrow()->setHour(11);

        // Create existing appointment
        Appointment::factory()->create([
            'healthcare_professional_id' => $this->professional->id,
            'appointment_start_time' => $startTime,
            'appointment_end_time' => $endTime,
            'status' => 'booked',
        ]);

        $appointmentData = [
            'healthcare_professional_id' => $this->professional->id,
            'appointment_start_time' => $startTime->copy()->addMinutes(30)->toISOString(),
            'appointment_end_time' => $endTime->copy()->addMinutes(30)->toISOString(),
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The selected time slot is not available. Please choose a different time.');

        $this->appointmentService->bookAppointment($this->user, $appointmentData);
    }

    public function test_can_cancel_appointment_successfully() {
        $appointment = Appointment::factory()->create([
            'user_id' => $this->user->id,
            'healthcare_professional_id' => $this->professional->id,
            'appointment_start_time' => Carbon::now()->addDays(2),
            'appointment_end_time' => Carbon::now()->addDays(2)->addHour(),
            'status' => 'booked',
        ]);

        $cancelledAppointment = $this->appointmentService->cancelAppointment($appointment);

        $this->assertEquals('cancelled', $cancelledAppointment->status);
    }

    public function test_cannot_cancel_appointment_within_24_hours() {
        $appointment = Appointment::factory()->create([
            'user_id' => $this->user->id,
            'healthcare_professional_id' => $this->professional->id,
            'appointment_start_time' => Carbon::now()->addHours(12),
            'appointment_end_time' => Carbon::now()->addHours(13),
            'status' => 'booked',
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Appointment cannot be cancelled. It must be cancelled at least 24 hours before the scheduled time.');

        $this->appointmentService->cancelAppointment($appointment);
    }

    public function test_can_complete_appointment_successfully() {
        $appointment = Appointment::factory()->create([
            'user_id' => $this->user->id,
            'healthcare_professional_id' => $this->professional->id,
            'appointment_start_time' => Carbon::now()->subHour(),
            'appointment_end_time' => Carbon::now(),
            'status' => 'booked',
        ]);

        $completedAppointment = $this->appointmentService->completeAppointment($appointment);

        $this->assertEquals('completed', $completedAppointment->status);
    }

    public function test_cannot_complete_future_appointment() {
        $appointment = Appointment::factory()->create([
            'user_id' => $this->user->id,
            'healthcare_professional_id' => $this->professional->id,
            'appointment_start_time' => Carbon::now()->addHour(),
            'appointment_end_time' => Carbon::now()->addHours(2),
            'status' => 'booked',
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot complete an appointment that hasn\'t started yet.');

        $this->appointmentService->completeAppointment($appointment);
    }

}
