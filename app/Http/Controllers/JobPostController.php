<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller
{
    public function index()
    {
        $jobs = JobPosting::where('posted_by', Auth::id())
            ->withCount('applications')
            ->latest()
            ->paginate(15);

        return view('hr.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('hr.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|in:full-time,part-time,contract,internship,remote',
            'salary_range' => 'nullable|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
        ]);

        JobPosting::create([
            ...$validated,
            'posted_by' => Auth::id(),
            'status' => 'active',
        ]);

        return redirect()->route('hr.jobs.index')->with('success', 'Job posted successfully!');
    }

    public function show(string $id)
    {
        $job = JobPosting::where('posted_by', Auth::id())->findOrFail($id);
        return view('hr.jobs.show', compact('job'));
    }

    public function edit($id)
    {
        $job = JobPosting::where('posted_by', Auth::id())->findOrFail($id);
        return view('hr.jobs.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $job = JobPosting::where('posted_by', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|in:full-time,part-time,contract,internship,remote',
            'salary_range' => 'nullable|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'status' => 'required|in:active,closed',
        ]);

        $job->update($validated);

        return redirect()->route('hr.jobs.index')->with('success', 'Job updated successfully!');
    }

    public function destroy(string $id)
    {
        $job = JobPosting::where('posted_by', Auth::id())->findOrFail($id);
        $job->delete();

        return redirect()->route('hr.jobs.index')->with('success', 'Job deleted successfully!');
    }
}
