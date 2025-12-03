@extends('layouts.main')
@section('title', 'Edit Job')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">Edit Job (Admin)</h1>
    <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST" class="bg-white rounded-xl border border-slate-200 p-8 space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Job Title *</label>
            <input type="text" name="title" value="{{ old('title', $job->title) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Company Name *</label>
            <input type="text" name="company_name" value="{{ old('company_name', $job->company_name) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Location *</label>
                <input type="text" name="location" value="{{ old('location', $job->location) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Employment Type *</label>
                <input type="text" name="employment_type" value="{{ old('employment_type', $job->employment_type) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Salary Range</label>
            <input type="text" name="salary_range" value="{{ old('salary_range', $job->salary_range) }}" class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Description *</label>
            <textarea name="description" rows="6" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('description', $job->description) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Requirements *</label>
            <textarea name="requirements" rows="6" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('requirements', $job->requirements) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Status *</label>
            <select name="status" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                <option value="active" {{ $job->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="closed" {{ $job->status == 'closed' ? 'selected' : '' }}>Closed</option>
                <option value="removed" {{ $job->status == 'removed' ? 'selected' : '' }}>Removed</option>
            </select>
        </div>
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.jobs.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 font-semibold hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">Update Job</button>
        </div>
    </form>
</div>
@endsection
