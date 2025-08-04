<?php

namespace App\Policies;

use App\Enums\EventStatus;
use App\Enums\UserRole;
use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability): ?true
    {
        if ($user->role === UserRole::Admin) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(?User $user, Event $event): bool
    {
        return $event->status === EventStatus::Published;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Event $event): bool
    {
        return false;
    }

    public function delete(User $user, Event $event): bool
    {
        return false;
    }

    public function register(User $user, Event $event): bool
    {
        return $event->status === EventStatus::Published;
    }
}
