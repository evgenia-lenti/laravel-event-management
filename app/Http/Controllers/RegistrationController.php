<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\EventRegistrationModalResource;
use App\Http\Resources\RegistrationResource;
use App\Http\Resources\UserRegistrationModalResource;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Services\Events\EventQueryService;
use App\Services\Registrations\RegistrationModalService;
use App\Services\Registrations\RegistrationQueryService;
use App\Services\Registrations\RegistrationService;
use App\Services\Users\UserQueryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        protected RegistrationQueryService $registrationQueryService,
        protected RegistrationService $registrationService,
        protected EventQueryService $eventQueryService,
        protected UserQueryService $userQueryService,
        protected RegistrationModalService $registrationModalService
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', EventRegistration::class);

        $registrations = $this->registrationQueryService->getRegistrations(
            $request->get('search_user'),
            $request->get('search_event')
        );

        return inertia('Registrations/Index', [
            'registrations' => RegistrationResource::collection($registrations),
            'filters' => [
                'search_user' => $request->get('search_user'),
                'search_event' => $request->get('search_event'),
            ],
            'users' => null,
            'events' => null,
            'can' => [
                'viewAny' => auth()->user()->can('viewAny', Event::class),
                'create' => auth()->user()->can('create', Event::class),
            ]
        ]);
    }

    public function store(RegistrationRequest $request)
    {
        $this->authorize('create', EventRegistration::class);

        $this->registrationService->registerUserToEvent($request->validated());

        return redirect()
            ->route('admin.registrations.index')
            ->with('success', 'Registration added successfully.');
    }

    public function destroy(EventRegistration $registration)
    {
        $this->authorize('delete', $registration);

        $this->registrationService->unregister($registration);

        return redirect()
            ->route('admin.registrations.index')
            ->with('success', 'Registration deleted successfully.');
    }

    public function modalData(RegistrationModalService $service)
    {
        return inertia('Registrations/Index', [
            'users' => UserRegistrationModalResource::collection($service->getUsers()),
            'events' => EventRegistrationModalResource::collection($service->getEvents()),
        ]);
    }
}
