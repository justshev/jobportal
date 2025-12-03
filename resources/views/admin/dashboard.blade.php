@extends('layouts.main')
@section('title', 'Admin Dashboard')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">Admin Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="text-sm font-medium text-slate-600 mb-2">Total Users</div>
            <div class="text-3xl font-bold text-slate-900">{{ $stats['total_users'] }}</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="text-sm font-medium text-slate-600 mb-2">HR Users</div>
            <div class="text-3xl font-bold text-blue-600">{{ $stats['total_hr'] }}</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="text-sm font-medium text-slate-600 mb-2">Total Jobs</div>
            <div class="text-3xl font-bold text-green-600">{{ $stats['total_jobs'] }}</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="text-sm font-medium text-slate-600 mb-2">Reports</div>
            <div class="text-3xl font-bold text-red-600">{{ $stats['total_reports'] }}</div>
        </div>
    </div>
    <h2 class="text-2xl font-bold text-slate-900 mb-4">Latest Reports</h2>
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Reporter</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Job</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($latestReports as $report)
                    <tr>
                        <td class="px-6 py-4 text-slate-900">{{ $report->user->name }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ $report->job->title }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm">{{ $report->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.reports.show', $report->id) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
