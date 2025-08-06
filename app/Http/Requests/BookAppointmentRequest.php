<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use \App\Http\Traits\Requests\RequestTraits;

class BookAppointmentRequest extends FormRequest {

    use RequestTraits;

    /**
     * 
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * 
     * @return array
     */
    public function rules(): array {
        return [
            'healthcare_professional_id' => ['required', 'exists:healthcare_professionals,id'],
            'appointment_start_time' => ['required', 'date', 'after:now'],
            'appointment_end_time' => ['required', 'date', 'after:appointment_start_time'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * 
     * @param type $validator
     */
    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $startTime = Carbon::parse($this->appointment_start_time);
            $endTime = Carbon::parse($this->appointment_end_time);

            // Check if appointment is during business hours (9 AM - 5 PM)
            if ($startTime->hour < 9 || $endTime->hour > 17) {
                $validator->errors()->add('appointment_start_time', 'Appointments must be scheduled between 9 AM and 5 PM.');
            }

            // Check if appointment is not on weekends
            if ($startTime->isWeekend()) {
                $validator->errors()->add('appointment_start_time', 'Appointments cannot be scheduled on weekends.');
            }

         
            // Check minimum duration (30 minutes)
            if ($endTime->diffInMinutes($startTime) > 30) {
                $validator->errors()->add('appointment_end_time', 'Appointment must be at least 30 minutes long.');
            }

            // Check maximum duration (2 hours)
            if ($endTime->diffInMinutes($startTime) > 120) {
                $validator->errors()->add('appointment_end_time', 'Appointment cannot be longer than 2 hours.');
            }
        });
    }

}
