<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserRoleResource;
use App\Models\User;
use App\Services\Users\UserQueryService;
use App\Services\Users\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        protected UserQueryService $userQueryService,
        protected UserService $userService
    )
    {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $users = $this->userQueryService->getUsers($request->get('search'));

        return inertia('Users/Index', [
            'users' => UserResource::collection($users),
            'filters' => [
                'search' => $request->get('search')
            ],
            'can' => [
                'viewAny' => auth()->user()->can('viewAny', User::class),
                'create' => auth()->user()->can('create', User::class),
            ]
        ]);
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return inertia('Users/Form', [
            'roles' => UserRoleResource::collection(UserRole::cases()),
        ]);
    }

    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);

        try {
            $this->userService->createUser($request->validated());

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create the user: ' . $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return inertia('Users/Form', [
            'user' => UserResource::make($user->loadCount('registeredEvents')),
            'roles' => UserRoleResource::collection(UserRole::cases())
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        try {
            $this->userService->updateUser($user, $request->validated());

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update the user: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        // Load user's registrations count
        $user->loadCount('registeredEvents');

        return inertia('Users/Show', [
            'user' => UserResource::make($user)
        ]);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        try {
            $this->userService->deleteUser($user);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to delete the user: ' . $e->getMessage());
        }
    }
}
