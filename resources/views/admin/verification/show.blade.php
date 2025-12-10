@extends('layouts.main')
@section('title', 'HR Account Verification Details')
@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-slate-900">HR Account Verification Details</h1>
        <a href="{{ route('admin.verification.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-medium transition-colors">
            ← Back to List
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-md mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

    <!-- User Information Card -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">
        <div class="p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Account Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Name</label>
                <p class="text-sm text-slate-900">{{ $hrUser->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Email</label>
                <p class="text-sm text-slate-900">{{ $hrUser->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Registration Date</label>
                <p class="text-sm text-slate-900">{{ $hrUser->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Current Status</label>
                <div class="mt-1">
                    @if($hrUser->verification_status === 'pending')
                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                    @elseif($hrUser->verification_status === 'approved')
                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Approved
                        </span>
                    @else
                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">
                            Rejected
                        </span>
                    @endif
                </div>
            </div>
            </div>
        </div>

        @if($hrUser->verification_status === 'approved' && $hrUser->verified_at && $hrUser->verifiedBy)
            <div class="mt-4 pt-4 border-t border-slate-200">
                <h4 class="text-sm font-semibold text-slate-700 mb-3">Verification Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Verified By</label>
                        <p class="text-sm text-slate-900">{{ $hrUser->verifiedBy->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Verified At</label>
                        <p class="text-sm text-slate-900">{{ $hrUser->verified_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($hrUser->verification_status === 'rejected' && $hrUser->rejection_reason)
            <div class="mt-4 pt-4 border-t border-slate-200">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Rejection Reason</label>
                <div class="bg-red-50 rounded-lg p-3">
                    <p class="text-sm text-red-700">{{ $hrUser->rejection_reason }}</p>
                </div>
            </div>
        @endif
    </div>
</div>

    <!-- Company Document Card -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">
        <div class="p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Company Document</h3>
            @if($hrUser->company_document)
            <div class="flex items-center justify-between bg-slate-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-900">Company Document</p>
                        <p class="text-xs text-slate-500">{{ basename($hrUser->company_document) }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.verification.download-document', $hrUser->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                    Download
                </a>
            </div>
        @else
            <p class="text-sm text-slate-500">No document uploaded.</p>
        @endif
    </div>
</div>

    <!-- Action Buttons -->
    @if($hrUser->verification_status === 'pending')
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Verification Actions</h3>
                
                <!-- Approve Form -->
                <form method="POST" action="{{ route('admin.verification.approve', $hrUser->id) }}" class="mb-4">
                    @csrf
                    <button type="submit" onclick="return confirm('Are you sure you want to approve this HR account?')" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Approve Account
                </button>
            </form>

            <!-- Reject Form -->
            <form method="POST" action="{{ route('admin.verification.reject', $hrUser->id) }}" x-data="{ showRejectForm: false }">
                @csrf
                <button type="button" @click="showRejectForm = !showRejectForm" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Reject Account
                </button>

                <div x-show="showRejectForm" x-transition class="mt-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-slate-700 mb-2">
                        Rejection Reason <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="rejection_reason" 
                        id="rejection_reason" 
                        rows="4" 
                        class="mt-1 block w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent" 
                        placeholder="Please provide a clear reason for rejection..."
                        required
                    >{{ old('rejection_reason') }}</textarea>
                    @error('rejection_reason')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="mt-4 flex gap-3">
                        <button type="submit" onclick="return confirm('Are you sure you want to reject this HR account? This action cannot be undone.')" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                            Confirm Rejection
                        </button>
                        <button type="button" @click="showRejectForm = false" class="inline-flex items-center px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
