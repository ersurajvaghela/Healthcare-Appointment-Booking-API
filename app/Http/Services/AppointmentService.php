<?php

namespace App\Http\Services;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class AppointmentService {

    /**
     * Book a new appointment.
     */
    public function bookAppointment(User $user, array $data): Appointment {
        $startTime = Carbon::parse($data['appointment_start_time']);
        $endTime = Carbon::parse($data['appointment_end_time']);

        // Check for conflicts
        if (Appointment::hasConflict($data['healthcare_professional_id'], $startTime, $endTime)) {
            throw new Exception('The selected time slot is not available. Please choose a different time.');
        }

        return Appointment::create([
                    'user_id' => $user->id,
                    'healthcare_professional_id' => $data['healthcare_professional_id'],
                    'appointment_start_time' => $startTime,
                    'appointment_end_time' => $endTime,
                    'notes' => $data['notes'] ?? null,
                    'status' => Appointment::STATUS_BOOKED,
        ]);
    }

    /**
     * Cancel an appointment.
     */
    public function cancelAppointment(Appointment $appointment): Appointment {
        if (!$appointment->canBeCancelled()) {
            throw new Exception('Appointment cannot be cancelled. It must be cancelled at least 24 hours before the scheduled time.');
        }

        $appointment->update(['status' => Appointment::STATUS_CANCELLED]);

        return $appointment;
    }

    /**
     * Complete an appointment.
     */
    public function completeAppointment(Appointment $appointment): Appointment {
        if ($appointment->status !== Appointment::STATUS_BOOKED) {
            throw new Exception('Only booked appointments can be marked as completed.');
        }

        if ($appointment->appointment_start_time->gt(Carbon::now())) {
            throw new Exception('Cannot complete an appointment that hasn\'t started yet.');
        }

        $appointment->update(['status' => Appointment::STATUS_COMPLETED]);

        return $appointment;
    }

}
