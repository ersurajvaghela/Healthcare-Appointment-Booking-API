<?php

namespace Database\Factories;

use App\Models\HealthcareProfessional;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory {

    public function definition(): array {
        $startTime = fake()->dateTimeBetween('+1 day', '+30 days');
        $endTime = Carbon::parse($startTime)->addHour();

        return [
            'user_id' => User::factory(),
            'healthcare_professional_id' => HealthcareProfessional::factory(),
            'appointment_start_time' => $startTime,
            'appointment_end_time' => $endTime,
            'status' => 'booked',
            'notes' => fake()->optional()->sentence(),
        ];
    }

}
