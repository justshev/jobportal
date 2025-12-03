<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::where('user_id', Auth::id())
            ->with('job')
            ->latest()
            ->paginate(15);

        return view('user.applications.index', compact('applications'));
    }

    public function store(Request $request)
    {
        // Check if user has uploaded CV
        $user = Auth::user();
        if (!$user->cv_path) {
            return back()->with('error', 'You must upload your CV before applying for jobs. Please upload your CV in your profile.');
        }

        $request->validate([
            'job_id' => 'required|exists:job_postings,id',
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        // Check if already applied
        $exists = Application::where('job_id', $request->job_id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already applied for this job.');
        }

        Application::create([
            'job_id' => $request->job_id,
            'user_id' => Auth::id(),
            'cover_letter' => $request->cover_letter,
            'status' => 'submitted',
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }

    public function show($id)
    {
        $application = Application::where('user_id', Auth::id())
            ->with('job')
            ->findOrFail($id);

        return view('user.applications.show', compact('application'));
    }
}
