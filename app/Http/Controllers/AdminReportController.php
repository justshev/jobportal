<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['user', 'jobPosting', 'reviewer']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by reason
        if ($request->has('reason') && $request->reason != '') {
            $query->where('reason', $request->reason);
        }

        $reports = $query->latest()->paginate(20);

        $stats = [
            'pending' => Report::where('status', 'pending')->count(),
            'reviewing' => Report::where('status', 'reviewing')->count(),
            'resolved' => Report::where('status', 'resolved')->count(),
            'rejected' => Report::where('status', 'rejected')->count(),
        ];

        return view('admin.reports.index', compact('reports', 'stats'));
    }

    public function show($id)
    {
        $report = Report::with(['user', 'jobPosting.user', 'reviewer'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,reviewing,resolved,rejected',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        // If resolved, optionally remove the job posting
        if ($request->status === 'resolved' && $request->has('remove_job')) {
            $report->jobPosting->update(['status' => 'closed']);
        }

        return back()->with('success', 'Report updated successfully!');
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return back()->with('success', 'Report deleted successfully!');
    }
}

