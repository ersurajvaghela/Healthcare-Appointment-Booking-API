<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    /**
     * 
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse {
        try {

            if (User::where([
                        'email' => $request->email
                    ])->count()) {
                return response()->json([
                            'code' => 400,
                            'message' => 'user already exists.'
                ]);
            } else {
                $user = User::create([
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => Hash::make($request->password),
                ]);

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                            'code' => 200,
                            'message' => 'User registered successfully',
                            'user' => $user,
                            'token' => $token,
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database-related exceptions
            return response()->json(['code' => 400, 'error' => 'Database error occurred']);
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json([
                        'code' => 400,
                        'message' => 'User registered successfully',
                        'error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    /**
     * 
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                            'code' => 400,
                            'message' => 'Invalid credentials',
                                ], 401);
            }

            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                        'code' => 200,
                        'message' => 'Login successful',
                        'user' => $user,
                        'token' => $token,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database-related exceptions
            return response()->json(['code' => 400, 'error' => 'Database error occurred']);
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json([
                        'code' => 400,
                        'message' => 'User registered successfully',
                        'error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    /**
     * Logout user.
     */
    public function logout(): JsonResponse {
        auth()->user()->tokens()->delete();

        return response()->json([
                    'code' => 200,
                    'message' => 'Logged out successfully',
        ]);
    }

}
