<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\RegistrationRequest;
use App\Http\Resources\RegistrationResource;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Services\Registrations\RegistrationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Traits\Api\v1\ApiResponseTrait;
use Throwable;

class RegistrationController extends Controller
{
    use ApiResponseTrait, AuthorizesRequests;

    public function __construct(
        protected RegistrationService $registrationService
    )
    {}

    /**
     * Register the authenticated user for an event
     *
     * @group Event Registrations
     *
     * @urlParam event integer required The ID of the event to register for. Example: 1
     *
     * @authenticated
     *
     * @response {
     *   "status": "success",
     *   "message": "Successfully registered for the event.",
     *   "data": {
     *     "registration": {
     *       "id": 1,
     *       "user": {
     *         "id": 1,
     *         "name": "John Doe",
     *         "email": "user@example.com"
     *       },
     *       "event": {
     *         "id": 1,
     *         "title": "Tech Conference 2025"
     *       },
     *       "createdAt": "04/08/2025 20:16",
     *       "can": {
     *         "delete": true
     *       }
     *     }
     *   }
     * }
     *
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     *
     * @response 403 {
     *   "status": "error",
     *   "message": "This action is unauthorized."
     * }
     *
     * @response 404 {
     *   "status": "error",
     *   "message": "Resource not found."
     * }
     *
     * @response 422 {
     *   "status": "error",
     *   "message": "You are already registered for this event."
     * }
     *
     * @response 500 {
     *   "status": "error",
     *   "message": "An unexpected error occurred"
     * }
     *
     * @throws Throwable
     */
    public function register(RegistrationRequest $request, Event $event)
    {
        $this->authorize('register', $event);

        try {
            $data = [
                'event_id' => $event->id,
                'user_id' => Auth::id()
            ];

            $registration = $this->registrationService->registerUserToEvent($data);

            return $this->successResponse(
                ['registration' => new RegistrationResource($registration)],
                'Successfully registered for the event.'
            );
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Unregister the authenticated user from an event
     *
     * @group Event Registrations
     *
     * @urlParam event integer required The ID of the event to unregister from. Example: 1
     *
     * @authenticated
     *
     * @response {
     *   "status": "success",
     *   "message": "Successfully unregistered from the event.",
     *   "data": []
     * }
     *
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     *
     * @response 404 {
     *   "status": "error",
     *   "message": "Resource not found."
     * }
     *
     * @response 500 {
     *   "status": "error",
     *   "message": "An unexpected error occurred"
     * }
     */
    public function unregister(RegistrationRequest $request, Event $event)
    {
        try {
            $registration = EventRegistration::where('event_id', $event->id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $this->registrationService->unregister($registration);

            return $this->successResponse(
                [],
                'Successfully unregistered from the event.'
            );
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Get all registrations for the authenticated user
     *
     * @group Event Registrations
     *
     * @authenticated
     *
     * @response {
     *   "data": [
     *     {
     *       "id": 1,
     *       "user": {
     *         "id": 1,
     *         "name": "John Doe",
     *         "email": "user@example.com"
     *       },
     *       "event": {
     *         "id": 1,
     *         "title": "Tech Conference 2025"
     *       },
     *       "createdAt": "04/08/2025 20:16",
     *       "can": {
     *         "delete": true
     *       }
     *     }
     *   ],
     *   "links": {
     *     "first": "http://example.com/api/v1/user/registrations?page=1",
     *     "last": "http://example.com/api/v1/user/registrations?page=1",
     *     "prev": null,
     *     "next": null
     *   },
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 1,
     *     "path": "http://example.com/api/v1/user/registrations",
     *     "per_page": 15,
     *     "to": 1,
     *     "total": 1
     *   }
     * }
     *
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     *
     * @response 500 {
     *   "status": "error",
     *   "message": "An unexpected error occurred"
     * }
     */
    public function userRegistrations()
    {
        try {
            $registrations = $this->registrationService->getUserRegistrations(Auth::user());

            return RegistrationResource::collection($registrations);

        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}
