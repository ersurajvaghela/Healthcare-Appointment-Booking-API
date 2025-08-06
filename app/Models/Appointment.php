<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model {

    use HasFactory;

    const STATUS_BOOKED = 'booked';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * 
     * @var type
     */
    protected $fillable = [
        'user_id',
        'healthcare_professional_id',
        'appointment_start_time',
        'appointment_end_time',
        'status',
        'notes',
    ];

    /**
     * 
     * @var type
     */
    protected $casts = [
        'appointment_start_time' => 'datetime',
        'appointment_end_time' => 'datetime',
    ];

    /**
     * Get the user that owns the appointment.
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the healthcare professional that owns the appointment.
     */
    public function healthcareProfessional() {
        return $this->belongsTo(HealthcareProfessional::class);
    }

    /**
     * Scope a query to only include booked appointments.
     */
    public function scopeBooked($query) {
        return $query->where('status', self::STATUS_BOOKED);
    }

    /**
     * Check if appointment can be cancelled.
     */
    public function canBeCancelled(): bool {
        if ($this->status !== self::STATUS_BOOKED) {
            return false;
        }

        return $this->appointment_start_time->gt(Carbon::now()->addHours(24));
    }

    /**
     * Check if there's a conflicting appointment for the healthcare professional.
     */
    public static function hasConflict($professionalId, $startTime, $endTime, $excludeId = null) {
        $query = self::where('healthcare_professional_id', $professionalId)
                ->where('status', self::STATUS_BOOKED)
                ->where(function ($q) use ($startTime, $endTime) {
            $q->whereBetween('appointment_start_time', [$startTime, $endTime])
            ->orWhereBetween('appointment_end_time', [$startTime, $endTime])
            ->orWhere(function ($q2) use ($startTime, $endTime) {
                $q2->where('appointment_start_time', '<=', $startTime)
                ->where('appointment_end_time', '>=', $endTime);
            });
        });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

}
