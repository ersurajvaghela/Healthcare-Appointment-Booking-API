<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('healthcare_professional_id')->constrained()->onDelete('cascade');
            $table->datetime('appointment_start_time');
            $table->datetime('appointment_end_time');
            $table->enum('status', ['booked', 'completed', 'cancelled'])->default('booked');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(
                    ['healthcare_professional_id', 'appointment_start_time'],
                    'hcp_start_time_idx'
            );
//            $table->index(['healthcare_professional_id', 'appointment_start_time']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('appointments');
    }
};
