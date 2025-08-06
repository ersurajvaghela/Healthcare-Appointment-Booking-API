<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HealthcareProfessionalFactory extends Factory {

    public function definition(): array {
        $specialties = [
            'Cardiology',
            'Dermatology',
            'Pediatrics',
            'Orthopedics',
            'Internal Medicine',
            'Neurology',
            'Oncology',
            'Psychiatry',
        ];

        return [
            'name' => 'Dr. ' . fake()->name(),
            'specialty' => fake()->randomElement($specialties),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'is_active' => true,
        ];
    }

}
