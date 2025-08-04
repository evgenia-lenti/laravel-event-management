<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\Events\EventQueryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Traits\Api\v1\ApiResponseTrait;
use Throwable;

class EventController extends Controller
{
    use AuthorizesRequests, ApiResponseTrait;

    public function __construct(
        protected EventQueryService $eventQueryService
    )
    {}

    /**
     * Get a list of events
     *
     * @group Events
     *
     * @queryParam search string Search term for filtering events. Example: conference
     *
     * @response {
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "Tech Conference 2025",
     *       "description": "Annual technology conference",
     *       "eventDate": "2025-09-15T09:00",
     *       "location": "Convention Center",
     *       "capacity": 500,
     *       "status": {
     *         "value": "published",
     *         "label": "Published"
     *       },
     *       "currentRegistrationsCount": 125,
     *       "can": {
     *         "update": false,
     *         "delete": false
     *       }
     *     }
     *   ],
     *   "links": {
     *     "first": "http://example.com/api/v1/events?page=1",
     *     "last": "http://example.com/api/v1/events?page=1",
     *     "prev": null,
     *     "next": null
     *   },
     *   "meta": {
     *     "current_page": 1,
     *     "from": 1,
     *     "last_page": 1,
     *     "path": "http://example.com/api/v1/events",
     *     "per_page": 15,
     *     "to": 1,
     *     "total": 1
     *   }
     * }
     *
     * @response 500 {
     *   "status": "error",
     *   "message": "An unexpected error occurred"
     * }
     */
    public function index(Request $request)
    {
        try {
            $events = $this->eventQueryService->getEvents($request->get('search'));

            return EventResource::collection($events);

        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Get a specific event by ID
     *
     * @group Events
     *
     * @urlParam event integer required The ID of the event. Example: 1
     *
     * @response {
     *   "status": "success",
     *   "data": {
     *     "event": {
     *       "id": 1,
     *       "title": "Tech Conference 2025",
     *       "description": "Annual technology conference",
     *       "eventDate": "2025-09-15T09:00",
     *       "location": "Convention Center",
     *       "capacity": 500,
     *       "status": {
     *         "value": "published",
     *         "label": "Published"
     *       },
     *       "currentRegistrationsCount": 125,
     *       "can": {
     *         "update": false,
     *         "delete": false
     *       }
     *     }
     *   }
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
     * @response 500 {
     *   "status": "error",
     *   "message": "An unexpected error occurred"
     * }
     */
    public function show(Event $event)
    {
        $this->authorize('view', $event);

        try {
            return $this->successResponse([
                'event' => new EventResource($event)
            ]);
        } catch (Throwable $e) {
            return $this->handleException($e);
        }
    }
}
