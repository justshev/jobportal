<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // User submits a report
    public function store(Request $request)
    {
        $request->validate([
            'job_posting_id' => 'required|exists:job_postings,id',
            'reason' => 'required|in:spam,inappropriate,fake,misleading,other',
            'description' => 'required|string|max:1000',
        ]);

        // Check if user already reported this job
        $existingReport = Report::where('user_id', Auth::id())
            ->where('job_posting_id', $request->job_posting_id)
            ->where('status', '!=', 'rejected')
            ->first();

        if ($existingReport) {
            return back()->with('error', 'You have already reported this job posting.');
        }

        Report::create([
            'user_id' => Auth::id(),
            'job_posting_id' => $request->job_posting_id,
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Report submitted successfully. We will review it shortly.');
    }

    // User views their own reports
    public function myReports()
    {
        $reports = Report::with('jobPosting')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('reports.my-reports', compact('reports'));
    }
}

