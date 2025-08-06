<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler {

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e) {
        if ($request->is('api/*')) {
            return $this->handleApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Handle API exceptions and return JSON responses.
     */
    private function handleApiException($request, Throwable $e): JsonResponse {
        if ($e instanceof ValidationException) {
            return response()->json([
                        'message' => 'Validation failed',
                        'errors' => $e->errors(),
                            ], 422);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                        'message' => 'Resource not found',
                            ], 404);
        }

        // For production, don't expose internal errors
        $message = config('app.debug') ? $e->getMessage() : 'An error occurred';
        $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

        return response()->json([
                    'message' => $message,
                        ], $statusCode);
    }

}
