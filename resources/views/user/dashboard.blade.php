@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">Dashboard</h1>

    <!-- CV Warning Banner -->
    @if(!auth()->user()->cv_path)
    <div id="cvBanner" class="mb-6 sm:mb-8 rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg" style="background: linear-gradient(135deg, #f97316 0%, #dc2626 100%);">
        <div class="flex flex-col sm:flex-row items-start gap-4" style="color: #ffffff;">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 sm:h-7 sm:w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1 w-full">
                <div class="flex items-start justify-between gap-3">
                    <h3 class="text-lg sm:text-xl font-bold">
                        📄 Upload Your CV to Apply for Jobs
                    </h3>
                    <button onclick="document.getElementById('cvBanner').style.display='none'" class="flex-shrink-0 sm:hidden" style="color: rgba(255, 255, 255, 0.85);">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="mt-2 sm:mt-3">
                    <p class="mb-3 sm:mb-4 text-sm leading-relaxed" style="color: rgba(255, 255, 255, 0.95);">You haven't uploaded your CV yet. A CV is <strong>required</strong> to apply for any job position. Upload your CV now to start your job search journey!</p>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-4 sm:px-5 py-2 sm:py-2.5 bg-white hover:bg-gray-100 rounded-lg transition-all shadow-md" style="color: #f97316; font-weight: 700; font-size: 0.875rem;">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Upload CV Now
                        </a>
                        <button onclick="document.getElementById('cvBanner').style.display='none'" class="text-sm font-medium underline" style="color: rgba(255, 255, 255, 0.85);">
                            Remind me later
                        </button>
                    </div>
                </div>
            </div>
            <button @click="show = false" class="hidden sm:block flex-shrink-0 transition-opacity hover:opacity-100" style="color: rgba(255, 255, 255, 0.85); opacity: 0.85;">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
            <div class="text-xs sm:text-sm font-medium text-slate-600 mb-1 sm:mb-2">Total Applications</div>
            <div class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $stats['total_applications'] }}</div>
        </div>
        <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
            <div class="text-xs sm:text-sm font-medium text-slate-600 mb-1 sm:mb-2">In Review</div>
            <div class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $stats['in_review'] }}</div>
        </div>
        <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
            <div class="text-xs sm:text-sm font-medium text-slate-600 mb-1 sm:mb-2">Shortlisted</div>
            <div class="text-2xl sm:text-3xl font-bold text-yellow-600">{{ $stats['shortlisted'] }}</div>
        </div>
        <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
            <div class="text-xs sm:text-sm font-medium text-slate-600 mb-1 sm:mb-2">Accepted</div>
            <div class="text-2xl sm:text-3xl font-bold text-green-600">{{ $stats['accepted'] }}</div>
        </div>
    </div>

    <!-- Recommended Jobs -->
    <div class="mb-6 sm:mb-8">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mb-3 sm:mb-4">Recommended Jobs</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($recommendedJobs as $job)
                <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-4 sm:p-6 hover:shadow-lg transition-shadow">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-900 mb-2">{{ $job->title }}</h3>
                    <p class="text-sm sm:text-base text-slate-600 mb-2 sm:mb-3">{{ $job->company_name }}</p>
                    <p class="text-xs sm:text-sm text-slate-500 mb-3 sm:mb-4">{{ $job->location }}</p>
                    <a href="{{ route('jobs.show', $job->id) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm inline-flex items-center">
                        View Details
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
