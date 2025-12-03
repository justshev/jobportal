@extends('layouts.main')

@section('title', $job->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-4 sm:mb-6 bg-green-50 border border-green-200 text-green-700 px-3 sm:px-4 py-2 sm:py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-4 sm:mb-6 bg-red-50 border border-red-200 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-4 sm:p-6 lg:p-8 shadow-sm">
        <div class="mb-4 sm:mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">{{ $job->title }}</h1>
            <p class="text-lg sm:text-xl text-slate-700 mb-3 sm:mb-4">{{ $job->company_name }}</p>
            
            <div class="flex flex-wrap gap-2 sm:gap-3 lg:gap-4 mb-3 sm:mb-4">
                <div class="flex items-center text-xs sm:text-sm text-slate-600">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $job->location }}
                </div>
                <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    {{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}
                </span>
                @if($job->salary_range)
                    <div class="flex items-center text-xs sm:text-sm text-slate-600">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $job->salary_range }}
                    </div>
                @endif
            </div>
        </div>

        <div class="border-t border-slate-200 pt-4 sm:pt-6 mb-4 sm:mb-6">
            <h2 class="text-lg sm:text-xl font-semibold text-slate-900 mb-3 sm:mb-4">Description</h2>
            <div class="text-sm sm:text-base text-slate-700 whitespace-pre-wrap">{{ $job->description }}</div>
        </div>

        <div class="border-t border-slate-200 pt-4 sm:pt-6 mb-4 sm:mb-6">
            <h2 class="text-lg sm:text-xl font-semibold text-slate-900 mb-3 sm:mb-4">Requirements</h2>
            <div class="text-sm sm:text-base text-slate-700 whitespace-pre-wrap">{{ $job->requirements }}</div>
        </div>

        @auth
            @if(auth()->user()->role === 'user')
                <div class="border-t border-slate-200 pt-6">
                    @php
                        $hasApplied = \App\Models\Application::where('job_id', $job->id)
                            ->where('user_id', auth()->id())
                            ->exists();
                    @endphp

                    @if($hasApplied)
                        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg">
                            You have already applied for this job.
                        </div>
                    @elseif(!auth()->user()->cv_path)
                        <!-- CV Required Warning -->
                        <div class="rounded-lg p-4 sm:p-6 shadow-lg" style="background: linear-gradient(135deg, #f97316 0%, #dc2626 100%);">
                            <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4" style="color: #ffffff;">
                                <svg class="h-6 w-6 sm:h-7 sm:w-7 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div class="flex-1">
                                    <h3 class="text-base sm:text-lg font-bold">📄 CV Required to Apply</h3>
                                    <p class="mt-2 text-sm" style="color: rgba(255, 255, 255, 0.95);">You need to upload your CV before you can apply for this job.</p>
                                    <div class="mt-3 sm:mt-4">
                                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-4 sm:px-5 py-2 sm:py-2.5 bg-white hover:bg-gray-100 rounded-lg transition-all shadow-md" style="color: #f97316; font-weight: 700; font-size: 0.875rem;">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            Upload CV in Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('user.applications.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="job_id" value="{{ $job->id }}">
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Cover Letter (Optional)</label>
                                <textarea name="cover_letter" rows="6" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Tell us why you're a great fit for this role..."></textarea>
                            </div>

                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">
                                Apply Now
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        @else
            <div class="border-t border-slate-200 pt-6">
                <p class="text-slate-600 mb-4">Please log in to apply for this job.</p>
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">
                    Login to Apply
                </a>
            </div>
        @endauth
    </div>
</div>
@endsection
