<?php

namespace App\Services\Events;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class EventQueryService
{
    // get events based on auth user permissions - role and search
    public function getEvents(?string $search): LengthAwarePaginator
    {
        $user = Auth::user();
        $query = Event::query();

        // if auth user is not admin can see only published events
        if (!$user->can('viewAny', Event::class)) {
            $query->where('status', 'published');
        }

        return $query
            ->when($search, function ($q) use ($search) {
                $q->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhere('capacity', 'like', "%{$search}%")
                        ->orWhere('current_registrations_count', 'like', "%{$search}%");

                    // check if search is date dd/mm/YYYY
                    if (Carbon::hasFormat($search, 'd/m/Y')) {
                        $date = Carbon::createFromFormat('d/m/Y', $search)->format('Y-m-d');
                        $subQuery->orWhereDate('event_date', $date);
                    }
                });
            })
            ->orderBy('event_date')
            ->paginate()
            ->withQueryString();
    }

    public function getEventsForSelect(): array
    {
        return Event::select('id', 'title')
            ->orderBy('title')
            ->get();
    }

}
