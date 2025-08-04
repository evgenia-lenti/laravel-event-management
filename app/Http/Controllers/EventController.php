<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventStatusResource;
use App\Models\Event;
use App\Services\Events\EventQueryService;
use App\Services\Events\EventService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;


class EventController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected EventQueryService $eventQueryService,
        protected EventService $eventService)
    {}

    public function index(Request $request)
    {
        $events = $this->eventQueryService->getEvents($request->get('search'));

        return inertia('Events/Index', [
            'events' => EventResource::collection($events),
            'filters' => [
                'search' => $request->get('search'),
            ],
            'can' => [
                'viewAny' => auth()->user()->can('viewAny', Event::class),
                'create' => auth()->user()->can('create', Event::class),
            ]
        ]);
    }

    public function create()
    {
        $this->authorize('create', Event::class);

        return inertia('Events/Form', [
            'statuses' => EventStatusResource::collection(EventStatus::cases())
        ]);
    }

    public function store(EventRequest $request)
    {
        $this->authorize('create', Event::class);

        try {
            $this->eventService->createEvent($request->validated());

            return redirect()
                ->route('admin.events.index')
                ->with('success', 'Event created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create the event: ' . $e->getMessage());
        }
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return inertia('Events/Form', [
            'event' => EventResource::make($event),
            'statuses' => EventStatusResource::collection(EventStatus::cases())
        ]);
    }

    public function update(EventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        try {
            $this->eventService->updateEvent($event, $request->validated());

            return redirect()
                ->route('admin.events.index')
                ->with('success', 'Event updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update the event: ' . $e->getMessage());
        }
    }

    public function show(Event $event)
    {
        $this->authorize('view', $event);

        return inertia('Events/Show', [
            'event' => EventResource::make($event)
        ]);
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        try {
            $this->eventService->deleteEvent($event);

            return redirect()
                ->route('admin.events.index')
                ->with('success', 'Event deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to delete the event: ' . $e->getMessage());
        }
    }
}
