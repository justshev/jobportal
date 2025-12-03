@extends('layouts.main')
@section('title', 'All Users')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">All Users</h1>
    <form method="GET" class="mb-6">
        <select name="role" onchange="this.form.submit()" class="rounded-lg border-slate-300">
            <option value="">All Roles</option>
            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Job Seekers</option>
            <option value="hr" {{ request('role') == 'hr' ? 'selected' : '' }}>HR</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </form>
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">CV</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @php
                                $roleClasses = match($user->role) {
                                    'admin' => 'bg-purple-100 text-purple-800',
                                    'hr' => 'bg-blue-100 text-blue-800',
                                    default => 'bg-green-100 text-green-800'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleClasses }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->cv_path && $user->role === 'user')
                                <a href="{{ route('cv.view', $user->id) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View CV
                                </a>
                            @elseif($user->role === 'user')
                                <span class="text-xs text-slate-400 italic">No CV uploaded</span>
                            @else
                                <span class="text-xs text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $users->links() }}</div>
</div>
@endsection
