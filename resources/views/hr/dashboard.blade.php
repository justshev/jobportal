@extends('layouts.main')

@section('title', 'HR Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">HR Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="text-sm font-medium text-slate-600 mb-2">Total Postings</div>
            <div class="text-3xl font-bold text-slate-900">{{ $stats['total_postings'] }}</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="text-sm font-medium text-slate-600 mb-2">Active Postings</div>
            <div class="text-3xl font-bold text-green-600">{{ $stats['active_postings'] }}</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="text-sm font-medium text-slate-600 mb-2">Total Applicants</div>
            <div class="text-3xl font-bold text-blue-600">{{ $stats['total_applicants'] }}</div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-slate-900">Recent Applicants</h2>
        <a href="{{ route('hr.jobs.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">
            Post New Job
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Applicant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Job</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($recentApplicants as $application)
                    <tr>
                        <td class="px-6 py-4 text-slate-900">{{ $application->user->name }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ $application->job->title }}</td>
                        <td class="px-6 py-4 text-slate-600 text-sm">{{ $application->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
