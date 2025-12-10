@extends('layouts.main')

@section('title', 'Welcome - Job Portal')

@section('content')
<div class="bg-gradient-to-br from-indigo-50 to-white">
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-slate-900 mb-6">
                Find Your Dream Job Today
            </h1>
            <p class="text-xl text-slate-600 mb-8 max-w-2xl mx-auto">
                Discover thousands of job opportunities from top companies. Start your career journey with JobPortal.
            </p>
            
            <!-- Search Bar -->
            <form action="{{ route('jobs.index') }}" method="GET" class="max-w-4xl mx-auto">
                <div class="flex flex-col sm:flex-row gap-3 bg-white rounded-xl shadow-lg p-3">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="keyword" 
                            placeholder="Job title, keyword..." 
                            class="w-full px-4 py-3 border-0 focus:ring-2 focus:ring-indigo-500 rounded-lg"
                        >
                    </div>
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="location" 
                            placeholder="Location" 
                            class="w-full px-4 py-3 border-0 focus:ring-2 focus:ring-indigo-500 rounded-lg"
                        >
                    </div>
                    <button 
                        type="submit" 
                        class="inline-flex items-center justify-center px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Search
                    </button>
                </div>
            </form>

            <div class="mt-8 flex justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                        Get Started
                    </a>
                    <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg border-2 border-indigo-600 hover:bg-indigo-50 transition">
                        Browse Jobs
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Latest Jobs Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-slate-900">Latest Job Openings</h2>
        <a href="{{ route('jobs.index') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
            View All →
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $latestJobs = \App\Models\JobPosting::where('status', 'active')
                ->latest()
                ->take(6)
                ->get();
        @endphp

        @forelse($latestJobs as $job)
            <div class="bg-white rounded-xl border border-slate-200 p-6 hover:shadow-lg transition">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold text-slate-900">{{ $job->title }}</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}
                    </span>
                </div>
                
                <p class="text-slate-600 font-medium mb-3">{{ $job->company_name }}</p>
                
                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-sm text-slate-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $job->location }}
                    </div>
                    <div class="flex items-center text-sm text-emerald-600 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ formatSalaryRange($job->salary_min, $job->salary_max) }}
                    </div>
                </div>

                <a href="{{ route('jobs.show', $job->id) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-semibold text-sm">
                    View Details
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-slate-500">No jobs available at the moment.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Features Section -->
<div class="bg-slate-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">Why Choose JobPortal?</h2>
            <p class="text-lg text-slate-600">Everything you need to find your next opportunity</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Easy Search</h3>
                <p class="text-slate-600">Find relevant jobs quickly with our powerful search and filtering system.</p>
            </div>

            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Trusted Companies</h3>
                <p class="text-slate-600">Connect with verified employers and top companies in the industry.</p>
            </div>

            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Quick Apply</h3>
                <p class="text-slate-600">Apply to multiple jobs with just a few clicks and track your applications.</p>
            </div>
        </div>
    </div>
</div>
@endsection
