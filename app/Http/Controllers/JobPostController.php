<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Data\IndonesiaLocations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $provinces = IndonesiaLocations::getProvinces();
        return view('hr.jobs.create', compact('provinces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'full_address' => 'required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'employment_type' => 'required|string|in:full-time,part-time,contract,internship,remote',
            'salary_min' => 'nullable|string',
            'salary_max' => 'nullable|string',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        // Convert formatted Rupiah to numeric
        if ($request->salary_min) {
            $validated['salary_min'] = str_replace('.', '', $request->salary_min);
        }
        if ($request->salary_max) {
            $validated['salary_max'] = str_replace('.', '', $request->salary_max);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('job-images', 'public');
        }

        JobPosting::create([
            ...$validated,
            'image' => $imagePath,
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
        $provinces = IndonesiaLocations::getProvinces();
        $cities = $job->province ? IndonesiaLocations::getCities($job->province) : [];
        return view('hr.jobs.edit', compact('job', 'provinces', 'cities'));
    }

    public function update(Request $request, $id)
    {
        $job = JobPosting::where('posted_by', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'full_address' => 'required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'employment_type' => 'required|string|in:full-time,part-time,contract,internship,remote',
            'salary_min' => 'nullable|string',
            'salary_max' => 'nullable|string',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'status' => 'required|in:active,closed',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        // Convert formatted Rupiah to numeric
        if ($request->salary_min) {
            $validated['salary_min'] = str_replace('.', '', $request->salary_min);
        }
        if ($request->salary_max) {
            $validated['salary_max'] = str_replace('.', '', $request->salary_max);
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($job->image && Storage::disk('public')->exists($job->image)) {
                Storage::disk('public')->delete($job->image);
            }
            $validated['image'] = $request->file('image')->store('job-images', 'public');
        }

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
