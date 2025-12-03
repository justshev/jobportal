<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    public function index($jobId)
    {
        $job = JobPosting::where('posted_by', Auth::id())->findOrFail($jobId);
        
        $applicants = Application::where('job_id', $jobId)
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('hr.applicants.index', compact('job', 'applicants'));
    }

    public function updateStatus(Request $request, $applicationId)
    {
        $request->validate([
            'status' => 'required|in:submitted,in_review,shortlisted,rejected,accepted',
        ]);

        $application = Application::whereHas('job', function($q) {
            $q->where('posted_by', Auth::id());
        })->findOrFail($applicationId);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application status updated successfully!');
    }
}
