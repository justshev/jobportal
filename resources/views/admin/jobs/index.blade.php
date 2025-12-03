@extends('layouts.main')
@section('title', 'All Jobs')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">All Jobs</h1>
    @if(session('success'))
        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Company</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Reports</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($jobs as $job)
                    <tr>
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $job->title }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ $job->company_name }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $job->status == 'active' ? 'bg-green-100 text-green-800' : ($job->status == 'removed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-700">{{ $job->reports_count }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.jobs.edit', $job->id) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Edit</a>
                                <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Mark as removed?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">Remove</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $jobs->links() }}</div>
</div>
@endsection
