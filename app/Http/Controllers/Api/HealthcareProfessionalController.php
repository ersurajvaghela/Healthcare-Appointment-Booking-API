<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HealthcareProfessionalResource;
use App\Models\HealthcareProfessional;
use Illuminate\Http\JsonResponse;

class HealthcareProfessionalController extends Controller {

    /**
     * Display a listing of active healthcare professionals.
     */
    public function index(): JsonResponse {
        $professionals = HealthcareProfessional::active()
                ->orderBy('name')
                ->get();

        return response()->json([
                    'code' => 200,
                    'message' => 'Healthcare professionals retrieved successfully',
                    'data' => HealthcareProfessionalResource::collection($professionals),
        ]);
    }

    /**
     * Display the specified healthcare professional.
     */
    public function show(HealthcareProfessional $healthcareProfessional): JsonResponse {
        return response()->json([
                    'code' => 200,
                    'message' => 'Healthcare professional retrieved successfully',
                    'data' => new HealthcareProfessionalResource($healthcareProfessional),
        ]);
    }

}
