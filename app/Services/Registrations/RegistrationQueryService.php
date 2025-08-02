<?php

namespace App\Services\Registrations;

use App\Models\EventRegistration;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RegistrationQueryService
{
    public function getRegistrations(?string $searchUser, ?string $searchEvent): LengthAwarePaginator
    {
        return EventRegistration::query()
            ->with(['user', 'event'])
            ->when($searchUser, function ($query, $searchUser) {
                $query->whereHas('user', function ($q) use ($searchUser) {
                    $q->where('name', 'like', "%{$searchUser}%");
                });
            })
            ->when($searchEvent, function ($query, $searchEvent) {
                $query->whereHas('event', function ($q) use ($searchEvent) {
                    $q->where('title', 'like', "%{$searchEvent}%");
                });
            })
            ->latest()
            ->paginate()
            ->withQueryString();
    }
}
