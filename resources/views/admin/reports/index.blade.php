@extends('layouts.main')
@section('title', 'Reports')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">Reports</h1>
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Reporter</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Job</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Company</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($reports as $report)
                    <tr>
                        <td class="px-6 py-4 text-slate-900">{{ $report->user->name }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ $report->job->title }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $report->job->company_name }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $report->status == 'new' ? 'bg-yellow-100 text-yellow-800' : ($report->status == 'resolved' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm">{{ $report->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.reports.show', $report->id) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $reports->links() }}</div>
</div>
@endsection
