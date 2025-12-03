<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobPosting;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_hr' => User::where('role', 'hr')->count(),
            'total_jobs' => JobPosting::count(),
            'total_reports' => Report::count(),
        ];

        $latestReports = Report::with(['job', 'user'])->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'latestReports'));
    }
}
