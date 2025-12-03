@extends('layouts.main')
@section('title', 'Report Details')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">Report Details</h1>
    @if(session('success'))
        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-xl border border-slate-200 p-8 mb-6">
        <div class="mb-6">
            <h3 class="text-sm font-medium text-slate-600 mb-2">Reporter</h3>
            <p class="text-lg text-slate-900">{{ $report->user->name }} ({{ $report->user->email }})</p>
        </div>
        <div class="mb-6">
            <h3 class="text-sm font-medium text-slate-600 mb-2">Reported Job</h3>
            <p class="text-lg text-slate-900">{{ $report->job->title }} at {{ $report->job->company_name }}</p>
        </div>
        <div class="mb-6">
            <h3 class="text-sm font-medium text-slate-600 mb-2">Reason</h3>
            <p class="text-slate-900 whitespace-pre-wrap">{{ $report->reason }}</p>
        </div>
        <div class="mb-6">
            <h3 class="text-sm font-medium text-slate-600 mb-2">Current Status</h3>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                {{ ucfirst($report->status) }}
            </span>
        </div>
        <div class="mb-6">
            <h3 class="text-sm font-medium text-slate-600 mb-2">Reported At</h3>
            <p class="text-slate-900">{{ $report->created_at->format('F d, Y H:i') }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-8">
        <h2 class="text-xl font-semibold text-slate-900 mb-4">Actions</h2>
        <form action="{{ route('admin.reports.update', $report->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Update Status</label>
                <select name="status" class="block w-full rounded-lg border border-slate-300 px-3 py-2">
                    <option value="new" {{ $report->status == 'new' ? 'selected' : '' }}>New</option>
                    <option value="reviewed" {{ $report->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                    <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="remove_job" value="1" id="remove_job" class="rounded border-slate-300 text-indigo-600">
                <label for="remove_job" class="ml-2 text-sm text-slate-700">Remove this job posting</label>
            </div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">Update Report</button>
        </form>
    </div>
</div>
@endsection
