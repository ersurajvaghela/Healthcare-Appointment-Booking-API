<?php

namespace Database\Seeders;

use App\Models\HealthcareProfessional;
use Illuminate\Database\Seeder;

class HealthcareProfessionalSeeder extends Seeder {

    public function run(): void {
        $professionals = [
            [
                'name' => 'Dr. Sarah Johnson',
                'specialty' => 'Cardiology',
                'email' => 'sarah.johnson@hospital.com',
                'phone' => '+1-555-0101',
            ],
            [
                'name' => 'Dr. Michael Chen',
                'specialty' => 'Dermatology',
                'email' => 'michael.chen@hospital.com',
                'phone' => '+1-555-0102',
            ],
            [
                'name' => 'Dr. Emily Rodriguez',
                'specialty' => 'Pediatrics',
                'email' => 'emily.rodriguez@hospital.com',
                'phone' => '+1-555-0103',
            ],
            [
                'name' => 'Dr. David Kim',
                'specialty' => 'Orthopedics',
                'email' => 'david.kim@hospital.com',
                'phone' => '+1-555-0104',
            ],
            [
                'name' => 'Dr. Lisa Thompson',
                'specialty' => 'Internal Medicine',
                'email' => 'lisa.thompson@hospital.com',
                'phone' => '+1-555-0105',
            ],
        ];

        foreach ($professionals as $professional) {
            HealthcareProfessional::create($professional);
        }
    }

}
