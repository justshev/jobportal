@extends('layouts.main')
@section('title', 'Post New Job')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">Post New Job</h1>
    <form action="{{ route('hr.jobs.store') }}" method="POST" class="bg-white rounded-xl border border-slate-200 p-8 space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Job Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Company Name *</label>
            <input type="text" name="company_name" value="{{ old('company_name') }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            @error('company_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Location *</label>
                <input type="text" name="location" value="{{ old('location') }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                @error('location')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Employment Type *</label>
                <select name="employment_type" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    <option value="full-time">Full Time</option>
                    <option value="part-time">Part Time</option>
                    <option value="contract">Contract</option>
                    <option value="internship">Internship</option>
                    <option value="remote">Remote</option>
                </select>
                @error('employment_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Salary Range</label>
            <input type="text" name="salary_range" value="{{ old('salary_range') }}" placeholder="e.g., $80,000 - $120,000" class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            @error('salary_range')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Description *</label>
            <textarea name="description" rows="6" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
            @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Requirements *</label>
            <textarea name="requirements" rows="6" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('requirements') }}</textarea>
            @error('requirements')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="flex justify-end space-x-4">
            <a href="{{ route('hr.jobs.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 font-semibold hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">Post Job</button>
        </div>
    </form>
</div>
@endsection
