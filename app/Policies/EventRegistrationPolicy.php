<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventRegistrationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function view(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function create(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function update(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function delete(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function viewCreateModalData(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }
}
