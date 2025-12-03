<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'total_applications' => Application::where('user_id', $user->id)->count(),
            'in_review' => Application::where('user_id', $user->id)->where('status', 'in_review')->count(),
            'shortlisted' => Application::where('user_id', $user->id)->where('status', 'shortlisted')->count(),
            'accepted' => Application::where('user_id', $user->id)->where('status', 'accepted')->count(),
        ];

        $recommendedJobs = JobPosting::where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        return view('user.dashboard', compact('stats', 'recommendedJobs'));
    }
}
