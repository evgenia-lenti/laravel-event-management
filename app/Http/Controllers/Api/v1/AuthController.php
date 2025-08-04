<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\Api\v1\AuthService;
use App\Http\Requests\Api\v1\AuthLoginRequest;
use Illuminate\Validation\ValidationException;
use App\Traits\Api\v1\ApiResponseTrait;
use Throwable;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected AuthService $authService
    )
    {}

    /**
     * Login a user and get an API token
     *
     * @group Authentication
     *
     * @bodyParam email string required The email of the user. Example: user@example.com
     * @bodyParam password string required The password of the user. Example: password123
     *
     * @response 200 {
     *   "status": "success",
     *   "message": "Login successful",
     *   "data": {
     *     "token": "1|laravel_sanctum_token_example",
     *     "user": {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "user@example.com"
     *     }
     *   }
     * }
     *
     * @response 401 {
     *   "status": "error",
     *   "message": "Invalid credentials"
     * }
     *
     * @response 422 {
     *   "message": "Validation errors",
     *   "errors": {
     *     "email": ["The email field is required."],
     *     "password": ["The password field is required."]
     *   }
     * }
     *
     * @response 500 {
     *   "status": "error",
     *   "message": "An unexpected error occurred"
     * }
     */
    public function login(AuthLoginRequest $request)
    {
        try {
            $result = $this->authService->login($request->validated());

            return $this->successResponse([
                'token' => $result['token'],
                'user' => $result['user'],
            ], 'Login successful');
        } catch (ValidationException $e) {

            return $this->errorResponse('Invalid credentials', 401);
        } catch (Throwable $e) {

            return $this->handleException($e);
        }
    }
}
