<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use App\Data\IndonesiaLocations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // Location-based job recommendations
        $recommendedJobs = $this->getLocationBasedJobs($user);

        return view('user.dashboard', compact('stats', 'recommendedJobs'));
    }
    
    private function getLocationBasedJobs($user)
    {
        $query = JobPosting::where('status', 'active');
        
        // If user has location set, prioritize jobs from same location
        if ($user->city) {
            // Get jobs from same city first
            $sameCityJobs = (clone $query)
                ->where('city', $user->city)
                ->latest()
                ->take(3)
                ->get();
            
            // Get jobs from same province
            $sameProvinceJobs = (clone $query)
                ->where('province', $user->province)
                ->where('city', '!=', $user->city)
                ->latest()
                ->take(2)
                ->get();
            
            // Get other jobs
            $otherJobs = (clone $query)
                ->where('province', '!=', $user->province)
                ->latest()
                ->take(1)
                ->get();
            
            $jobs = $sameCityJobs->concat($sameProvinceJobs)->concat($otherJobs);
        } 
        // If user has lat/long, calculate distance
        else if ($user->latitude && $user->longitude) {
            $jobs = $query->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get()
                ->map(function($job) use ($user) {
                    $job->distance = IndonesiaLocations::calculateDistance(
                        $user->latitude, 
                        $user->longitude,
                        $job->latitude,
                        $job->longitude
                    );
                    return $job;
                })
                ->sortBy('distance')
                ->take(6);
        }
        // Default: latest jobs
        else {
            $jobs = $query->latest()->take(6)->get();
        }
        
        return $jobs;
    }
}
