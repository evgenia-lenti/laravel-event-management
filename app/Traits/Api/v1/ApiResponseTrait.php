<?php

namespace App\Traits\Api\v1;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

trait ApiResponseTrait
{
    // Return a success JSON response.
    protected function successResponse(array $data, string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    // Return an error JSON response.
    protected function errorResponse(string $message, int $code, array $errors = null): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    // Handle thrown exceptions and return appropriate JSON responses.
    protected function handleException(Throwable $exception): JsonResponse
    {
        if ($exception instanceof ValidationException) {
            return $this->errorResponse(
                'Validation error',
                422,
                $exception->errors()
            );
        }

        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return $this->errorResponse(
                'Resource not found',
                404
            );
        }

        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse(
                'Unauthorized action',
                403
            );
        }

        // Log unexpected exceptions
        report($exception);

        return $this->errorResponse(
            'Server error',
            500
        );
    }
}
