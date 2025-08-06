<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthcareProfessional extends Model {

    use HasFactory;

    protected $fillable = [
        'name',
        'specialty',
        'email',
        'phone',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the appointments for the healthcare professional.
     */
    public function appointments() {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Scope a query to only include active professionals.
     */
    public function scopeActive($query) {
        return $query->where('is_active', true);
    }

}
