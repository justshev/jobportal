<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HRDashboardController extends Controller
{
    public function index()
    {
        $hrId = Auth::id();

        $stats = [
            'total_postings' => JobPosting::where('posted_by', $hrId)->count(),
            'active_postings' => JobPosting::where('posted_by', $hrId)->where('status', 'active')->count(),
            'total_applicants' => Application::whereHas('job', function($q) use ($hrId) {
                $q->where('posted_by', $hrId);
            })->count(),
        ];

        $recentApplicants = Application::whereHas('job', function($q) use ($hrId) {
            $q->where('posted_by', $hrId);
        })->with(['job', 'user'])->latest()->take(5)->get();

        return view('hr.dashboard', compact('stats', 'recentApplicants'));
    }
}
