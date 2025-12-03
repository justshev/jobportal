@extends('layouts.main')
@section('title', 'Applicants')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-4">{{ $job->title }} - Applicants</h1>
    <p class="text-slate-600 mb-8">{{ $job->company_name }}</p>
    @if(session('success'))
        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">CV</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Applied</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($applicants as $application)
                    <tr>
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $application->user->name }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ $application->user->email }}</td>
                        <td class="px-6 py-4">
                            @if($application->user->cv_path)
                                <a href="{{ route('cv.view', $application->user->id) }}" target="_blank" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </a>
                            @else
                                <span class="text-xs text-slate-400 italic">No CV</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm">{{ $application->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusClasses = match($application->status) {
                                    'accepted' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'shortlisted' => 'bg-yellow-100 text-yellow-800',
                                    'in_review' => 'bg-blue-100 text-blue-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses }}">
                                {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('hr.applications.status', $application->id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="text-sm border-slate-300 rounded">
                                    <option value="submitted" {{ $application->status == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                    <option value="in_review" {{ $application->status == 'in_review' ? 'selected' : '' }}>In Review</option>
                                    <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                    <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Update</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">No applicants yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $applicants->links() }}</div>
</div>
@endsection
