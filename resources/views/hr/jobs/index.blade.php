@extends('layouts.main')
@section('title', 'Job Postings')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Job Postings</h1>
        <a href="{{ route('hr.jobs.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">Post New Job</a>
    </div>
    @if(session('success'))
        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Applicants</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Posted</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($jobs as $job)
                    <tr>
                        <td class="px-6 py-4">
                            @if($job->image)
                                <img src="{{ asset('storage/' . $job->image) }}" alt="{{ $job->title }}" class="w-16 h-16 object-cover rounded-lg border border-slate-200">
                            @else
                                <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $job->title }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $job->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-700">{{ $job->applications_count }}</td>
                        <td class="px-6 py-4 text-slate-600 text-sm">{{ $job->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('hr.jobs.applicants', $job->id) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Applicants</a>
                                <a href="{{ route('hr.jobs.edit', $job->id) }}" class="text-slate-600 hover:text-slate-700 text-sm font-medium">Edit</a>
                                <form action="{{ route('hr.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">No job postings yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $jobs->links() }}</div>
</div>
@endsection
