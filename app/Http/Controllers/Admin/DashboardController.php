<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Customlib;
use App\Services\RbacService;
use App\Models\{Student, Staff, StudentFees, Holiday, Content};
use Illuminate\Http\Request;

/**
 * Admin dashboard.
 *
 * Replaces CI3 controllers/admin/Dashboard.php
 */
class DashboardController extends Controller
{
    public function __construct(
        private Customlib $customlib,
        private RbacService $rbac,
    ) {}

    public function index(Request $request)
    {
        $sessionId = $this->customlib->getActiveSessionId();

        $stats = [
            'students'         => Student::count(),
            'staff'            => Staff::count(),
            'fees_collected'   => StudentFees::whereDate('date', today())->sum('amount'),
            'pending_fees'     => StudentFees::whereDate('date', '<', today())->sum('amount'),
        ];

        // Last 7 days fee chart
        $chartLabels = [];
        $chartValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartValues[] = (float) StudentFees::whereDate('date', $date)->sum('amount');
        }

        $recentStudents = Student::with(['sessions.class'])
            ->latest()
            ->limit(10)
            ->get();

        $events = Holiday::where('from_date', '>=', today())->limit(5)->get();

        return view('admin.dashboard.index', compact(
            'stats', 'chartLabels', 'chartValues', 'recentStudents', 'events'
        ));
    }
}
