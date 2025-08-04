<?php

namespace App\Services;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;

class DashboardStatisticsService
{
    public function getEventStatistics(): array
    {
        return [
            'published' => Event::where('status', EventStatus::Published)->count(),
            'cancelled' => Event::where('status', EventStatus::Cancelled)->count(),
            'draft' => Event::where('status', EventStatus::Draft)->count(),
            'total' => Event::count(),
        ];
    }

    public function getTotalUsers(): int
    {
        return User::count();
    }

    public function getTotalRegistrations(): int
    {
        return EventRegistration::count();
    }

    public function getAllStatistics(): array
    {
        return [
            'events' => $this->getEventStatistics(),
            'totalUsers' => $this->getTotalUsers(),
            'totalRegistrations' => $this->getTotalRegistrations(),
        ];
    }
}
