<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobBrowseController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPosting::where('status', 'active')->with('postedBy');

        // Search by keyword
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('company_name', 'like', "%{$keyword}%");
            });
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Filter by employment type
        if ($request->filled('type')) {
            $query->where('employment_type', $request->type);
        }

        $jobs = $query->latest()->paginate(12);
        
        // Get unique cities for filter dropdown
        $cities = JobPosting::where('status', 'active')
            ->whereNotNull('city')
            ->select('city', 'province')
            ->distinct()
            ->orderBy('province')
            ->orderBy('city')
            ->get()
            ->groupBy('province');

        return view('jobs.index', compact('jobs', 'cities'));
    }

    public function show($id)
    {
        $job = JobPosting::with('postedBy')->findOrFail($id);
        
        return view('jobs.show', compact('job'));
    }
}
