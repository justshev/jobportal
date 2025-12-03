<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;

class AdminJobController extends Controller
{
    public function index()
    {
        $jobs = JobPosting::with('postedBy')->withCount(['applications', 'reports'])->latest()->paginate(20);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function edit($id)
    {
        $job = JobPosting::findOrFail($id);
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $job = JobPosting::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string',
            'salary_range' => 'nullable|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'status' => 'required|in:active,closed,removed',
        ]);

        $job->update($validated);

        return redirect()->route('admin.jobs.index')->with('success', 'Job updated successfully!');
    }

    public function destroy($id)
    {
        $job = JobPosting::findOrFail($id);
        $job->update(['status' => 'removed']);

        return redirect()->route('admin.jobs.index')->with('success', 'Job removed successfully!');
    }
}
