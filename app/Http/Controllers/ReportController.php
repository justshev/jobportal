<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\JobPosting;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['job', 'user'])->latest()->paginate(20);
        return view('admin.reports.index', compact('reports'));
    }

    public function show($id)
    {
        $report = Report::with(['job', 'user'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $request->validate([
            'status' => 'required|in:new,reviewed,resolved',
        ]);

        $report->update(['status' => $request->status]);

        if ($request->has('remove_job') && $request->remove_job == '1') {
            $report->job->update(['status' => 'removed']);
        }

        return back()->with('success', 'Report updated successfully!');
    }
}
