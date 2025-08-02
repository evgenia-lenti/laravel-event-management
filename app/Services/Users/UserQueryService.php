<?php

namespace App\Services\Users;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\User;

class UserQueryService
{
    public function getUsers(?string $search): LengthAwarePaginator
    {
        return User::query()
            ->withCount('registeredEvents')
            ->with('registeredEvents')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'DESC')
            ->paginate()
            ->withQueryString();
    }

    public function getUsersForSelect(): array
    {
        return User::select('id', 'name', 'email')
            ->orderBy('name')
            ->get();
    }

}
