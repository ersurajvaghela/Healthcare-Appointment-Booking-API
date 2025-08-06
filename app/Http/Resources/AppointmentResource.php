<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource {

    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'healthcare_professional' => new HealthcareProfessionalResource($this->whenLoaded('healthcareProfessional')),
            'appointment_start_time' => $this->appointment_start_time->toISOString(),
            'appointment_end_time' => $this->appointment_end_time->toISOString(),
            'status' => $this->status,
            'notes' => $this->notes,
            'can_be_cancelled' => $this->canBeCancelled(),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }

}
