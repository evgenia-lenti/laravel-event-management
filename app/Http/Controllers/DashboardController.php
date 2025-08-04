<?php

namespace App\Http\Controllers;

use App\Services\DashboardStatisticsService;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(protected DashboardStatisticsService $dashboardStatisticsService)
    {}

    public function index()
    {
        return Inertia::render('Dashboard', [
            'statistics' => $this->dashboardStatisticsService->getAllStatistics(),
        ]);
    }
}
