@extends('layouts.main')

@section('title', 'Browse Jobs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4 sm:mb-6 lg:mb-8">Browse Jobs</h1>

    <!-- Filters -->
    <form method="GET" class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-4 sm:p-6 mb-4 sm:mb-6 lg:mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <div>
                <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Keyword</label>
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search..." class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Location</label>
                <select name="city" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Locations</option>
                    @foreach($cities as $province => $cityGroup)
                        <optgroup label="{{ $province }}">
                            @foreach($cityGroup as $cityItem)
                                <option value="{{ $cityItem->city }}" {{ request('city') == $cityItem->city ? 'selected' : '' }}>
                                    {{ $cityItem->city }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-slate-700 mb-1">Job Type</label>
                <select name="type" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Types</option>
                    <option value="full-time" {{ request('type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                    <option value="part-time" {{ request('type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                    <option value="contract" {{ request('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                    <option value="internship" {{ request('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                    <option value="remote" {{ request('type') == 'remote' ? 'selected' : '' }}>Remote</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Search
                </button>
                @if(request()->hasAny(['keyword', 'city', 'type']))
                    <a href="{{ route('jobs.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-slate-300 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
        
        <!-- Active Filters Display -->
        @if(request()->hasAny(['keyword', 'city', 'type']))
        <div class="mt-4 flex flex-wrap gap-2 items-center">
            <span class="text-xs sm:text-sm text-slate-600 font-medium">Active filters:</span>
            @if(request('keyword'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    Keyword: "{{ request('keyword') }}"
                </span>
            @endif
            @if(request('city'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    Location: {{ request('city') }}
                </span>
            @endif
            @if(request('type'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Type: {{ ucfirst(str_replace('-', ' ', request('type'))) }}
                </span>
            @endif
        </div>
        @endif
    </form>

    <!-- Results Count -->
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-slate-600">
            Found <span class="font-semibold text-slate-900">{{ $jobs->total() }}</span> job{{ $jobs->total() != 1 ? 's' : '' }}
        </p>
    </div>

    <!-- Results -->
    <div class="space-y-3 sm:space-y-4">
        @forelse($jobs as $job)
            <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                    <!-- Job Image -->
                    @if($job->image)
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $job->image) }}" alt="{{ $job->title }}" class="w-full sm:w-32 sm:h-32 object-cover rounded-lg border border-slate-200">
                    </div>
                    @endif
                    
                    <div class="flex-1">
                        <h3 class="text-lg sm:text-xl font-semibold text-slate-900 mb-2">{{ $job->title }}</h3>
                        <p class="text-base sm:text-lg text-slate-700 mb-2 sm:mb-3">{{ $job->company_name }}</p>
                        
                        <div class="flex flex-wrap gap-2 sm:gap-3 lg:gap-4 mb-3 sm:mb-4">
                            <div class="flex items-center text-xs sm:text-sm text-slate-600">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $job->city }}, {{ $job->province }}
                            </div>
                            <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}
                            </span>
                            @if($job->salary_min || $job->salary_max)
                                <div class="flex items-center text-xs sm:text-sm text-emerald-600 font-medium">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ formatSalaryRange($job->salary_min, $job->salary_max) }}
                                </div>
                            @endif
                        </div>

                        <p class="text-sm text-slate-600 line-clamp-2">{{ Str::limit($job->description, 150) }}</p>
                    </div>

                    <div class="sm:ml-6 mt-3 sm:mt-0">
                        <a href="{{ route('jobs.show', $job->id) }}" class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-8 sm:p-12 text-center">
                <p class="text-sm sm:text-base text-slate-500">No jobs found matching your criteria.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6 sm:mt-8">
        {{ $jobs->appends(request()->query())->links() }}
    </div>
</div>
@endsection
