<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use App\Http\Services\AppointmentService;
use App\Http\Requests\BookAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use Illuminate\Http\Request;

class AppointmentController extends Controller {

    protected AppointmentService $appointmentService;

    public function __construct(AppointmentService $appointmentService) {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Display a listing of user's appointments.
     */
    public function index(Request $request): JsonResponse {
        $appointments = auth()->user()
                ->appointments()
                ->with('healthcareProfessional')
                ->orderBy('appointment_start_time', 'desc')
                ->paginate(10);

        return response()->json([
                    'code' => 200,
                    'message' => 'Appointments retrieved successfully',
                    'data' => AppointmentResource::collection($appointments),
                    'meta' => [
                        'current_page' => $appointments->currentPage(),
                        'total_pages' => $appointments->lastPage(),
                        'total' => $appointments->total(),
                    ],
        ]);
    }

    /**
     * Book a new appointment.
     */
    public function store(BookAppointmentRequest $request): JsonResponse {
        try {

            $appointment = $this->appointmentService->bookAppointment(
                    auth()->user(),
                    $request->validated()
            );

            return response()->json([
                        'code' => 200,
                        'message' => 'Appointment booked successfully',
                        'data' => new AppointmentResource($appointment->load('healthcareProfessional')),
                            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                        'code' => 400,
                        'message' => 'Failed to book appointment',
                        'error' => $e->getMessage(),
                            ], 422);
        }
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment): JsonResponse {
        // Ensure user can only view their own appointments
        if ($appointment->user_id !== auth()->id()) {
            return response()->json([
                        'code' => 401,
                        'message' => 'Unauthorized access to appointment',
                            ], 403);
        }

        return response()->json([
                    'code' => 200,
                    'message' => 'Appointment retrieved successfully',
                    'data' => new AppointmentResource($appointment->load('healthcareProfessional')),
        ]);
    }

    /**
     * Cancel the specified appointment.
     */
    public function cancel(Appointment $appointment): JsonResponse {
        // Ensure user can only cancel their own appointments
        if ($appointment->user_id !== auth()->id()) {
            return response()->json([
                        'code' => 401,
                        'message' => 'Unauthorized access to appointment',
                            ], 403);
        }

        try {
            $this->appointmentService->cancelAppointment($appointment);

            return response()->json([
                        'code' => 200,
                        'message' => 'Appointment cancelled successfully',
                        'data' => new AppointmentResource($appointment->fresh()->load('healthcareProfessional')),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                        'code' => 400,
                        'message' => 'Failed to cancel appointment',
                        'error' => $e->getMessage(),
                            ], 422);
        }
    }

    /**
     * Mark appointment as completed.
     */
    public function complete(Appointment $appointment): JsonResponse {
        // Ensure user can only complete their own appointments
        if ($appointment->user_id !== auth()->id()) {
            return response()->json([
                        'code' => 401,
                        'message' => 'Unauthorized access to appointment',
                            ], 403);
        }

        try {
            $this->appointmentService->completeAppointment($appointment);

            return response()->json([
                        'code' => 200,
                        'message' => 'Appointment marked as completed',
                        'data' => new AppointmentResource($appointment->fresh()->load('healthcareProfessional')),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                        'code' => 400,
                        'message' => 'Failed to complete appointment',
                        'error' => $e->getMessage(),
                            ], 422);
        }
    }

}
