@extends('layouts.main')

@section('title', 'Report Details')

@section('content')
<div class="p-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Reports
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Report Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Main Info Card -->
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 mb-2">Report #{{ $report->id }}</h1>
                        <p class="text-slate-600">Submitted {{ $report->created_at->diffForHumans() }}</p>
                    </div>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'reviewing' => 'bg-blue-100 text-blue-800',
                            'resolved' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$report->status] ?? 'bg-slate-100 text-slate-800' }}">
                        {{ $report->status_label }}
                    </span>
                </div>

                <div class="border-t border-slate-200 pt-6 space-y-6">
                    <!-- Reporter Info -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-600 uppercase mb-3">Reported By</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-bold text-lg">{{ substr($report->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-slate-900">{{ $report->user->name }}</p>
                                <p class="text-sm text-slate-600">{{ $report->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Reported Job -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-600 uppercase mb-3">Reported Job Posting</h3>
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                            <h4 class="font-bold text-slate-900 mb-1">{{ $report->jobPosting->title }}</h4>
                            <p class="text-slate-700 mb-2">{{ $report->jobPosting->company_name }}</p>
                            <div class="flex gap-2">
                                <a href="{{ route('jobs.show', $report->jobPosting->id) }}" target="_blank" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                    View Job Posting
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Report Reason -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-600 uppercase mb-3">Report Reason</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-slate-100 text-slate-800">
                            {{ $report->reason_label }}
                        </span>
                    </div>

                    <!-- Description -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-600 uppercase mb-3">Description</h3>
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                            <p class="text-slate-900 whitespace-pre-wrap">{{ $report->description }}</p>
                        </div>
                    </div>

                    <!-- Admin Note (if exists) -->
                    @if($report->admin_note)
                        <div>
                            <h3 class="text-sm font-semibold text-slate-600 uppercase mb-3">Admin Note</h3>
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                <p class="text-slate-900 whitespace-pre-wrap">{{ $report->admin_note }}</p>
                                @if($report->reviewer)
                                    <p class="text-sm text-slate-600 mt-2">
                                        By {{ $report->reviewer->name }} • {{ $report->reviewed_at->format('M d, Y H:i') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Panel -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-slate-200 p-6 sticky top-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Take Action</h2>

                <form action="{{ route('admin.reports.update', $report->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Update Status</label>
                        <select name="status" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="reviewing" {{ $report->status == 'reviewing' ? 'selected' : '' }}>Under Review</option>
                            <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <!-- Admin Note -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Admin Note</label>
                        <textarea name="admin_note" rows="4" maxlength="1000" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Add notes about this report...">{{ old('admin_note', $report->admin_note) }}</textarea>
                        <p class="text-xs text-slate-500 mt-1">Max 1000 characters</p>
                    </div>

                    <!-- Remove Job Option -->
                    <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" name="remove_job" value="1" id="remove_job" class="mt-0.5 rounded border-slate-300 text-red-600 focus:ring-red-500">
                            <div class="ml-3">
                                <span class="block text-sm font-medium text-slate-900">Close Job Posting</span>
                                <span class="block text-xs text-slate-600 mt-1">This will close the reported job posting</span>
                            </div>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                        Update Report
                    </button>
                </form>

                <!-- Delete Report -->
                <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" class="mt-4" onsubmit="return confirm('Are you sure you want to delete this report?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 border border-red-300 text-red-600 font-semibold rounded-lg hover:bg-red-50 transition-colors">
                        Delete Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
