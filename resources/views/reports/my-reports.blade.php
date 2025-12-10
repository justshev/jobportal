@extends('layouts.main')

@section('title', 'My Reports')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900">My Reports</h1>
        <p class="text-slate-600 mt-1">Track your submitted job posting reports</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Reports List -->
    <div class="space-y-4">
        @forelse($reports as $report)
            <div class="bg-white rounded-xl border border-slate-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <!-- Left Section -->
                    <div class="flex-1">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-900 mb-1">{{ $report->jobPosting->title }}</h3>
                                <p class="text-slate-700 mb-2">{{ $report->jobPosting->company_name }}</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                        {{ $report->reason_label }}
                                    </span>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'reviewing' => 'bg-blue-100 text-blue-800',
                                            'resolved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$report->status] ?? 'bg-slate-100 text-slate-800' }}">
                                        {{ $report->status_label }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="bg-slate-50 rounded-lg p-3 border border-slate-200 mb-3">
                            <p class="text-sm text-slate-700 line-clamp-2">{{ $report->description }}</p>
                        </div>

                        <!-- Admin Note (if exists) -->
                        @if($report->admin_note)
                            <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                                <p class="text-xs font-semibold text-blue-900 mb-1">Admin Response:</p>
                                <p class="text-sm text-slate-700">{{ $report->admin_note }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Right Section -->
                    <div class="flex flex-col items-start md:items-end gap-2">
                        <span class="text-sm text-slate-500">{{ $report->created_at->format('M d, Y') }}</span>
                        <a href="{{ route('jobs.show', $report->jobPosting->id) }}" target="_blank" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                            View Job
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Timeline Info -->
                <div class="mt-4 pt-4 border-t border-slate-200 flex items-center gap-4 text-xs text-slate-500">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Submitted {{ $report->created_at->diffForHumans() }}
                    </div>
                    @if($report->reviewed_at)
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Reviewed {{ $report->reviewed_at->diffForHumans() }}
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-slate-900 mb-2">No Reports Yet</h3>
                <p class="text-slate-600 mb-4">You haven't submitted any job posting reports.</p>
                <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                    Browse Jobs
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($reports->hasPages())
        <div class="mt-6">
            {{ $reports->links() }}
        </div>
    @endif
</div>
@endsection
