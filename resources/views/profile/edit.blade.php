@extends('layouts.main')
@section('title', 'My Profile')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <!-- Success Messages -->
    @if (session('status') === 'profile-updated')
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            Profile updated successfully!
        </div>
    @endif
    @if (session('status') === 'photo-uploaded')
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            Profile photo uploaded successfully!
        </div>
    @endif
    @if (session('status') === 'photo-deleted')
        <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            Profile photo removed successfully!
        </div>
    @endif
    @if (session('status') === 'cv-uploaded')
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            CV uploaded successfully!
        </div>
    @endif
    @if (session('status') === 'cv-deleted')
        <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            CV removed successfully!
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Sidebar - Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <!-- Profile Header -->
                <div class="h-32 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                
                <!-- Profile Photo Section -->
                <div class="relative px-6 pb-6">
                    <div class="flex justify-center -mt-16 mb-4">
                        <div class="relative">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile" class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                            @else
                                <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                                    <span class="text-4xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <button onclick="document.getElementById('photoInput').click()" class="absolute bottom-1 right-1 bg-white hover:bg-slate-50 text-slate-700 rounded-full p-2 shadow-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Upload Photo Form (Hidden) -->
                    <form id="photoForm" action="{{ route('profile.photo.upload') }}" method="POST" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="file" id="photoInput" name="profile_photo" accept="image/*" onchange="this.form.submit()">
                    </form>

                    <!-- User Info -->
                    <div class="text-center mb-4">
                        <h2 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h2>
                        <p class="text-sm text-slate-500">{{ $user->email }}</p>
                        <div class="mt-3">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                    Administrator
                                </span>
                            @elseif($user->role === 'hr')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                                    HR Manager
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                    Job Seeker
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($user->profile_photo)
                    <form action="{{ route('profile.photo.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to remove your profile photo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 text-sm text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                            Remove Photo
                        </button>
                    </form>
                    @endif

                    <!-- Quick Stats -->
                    @if($user->role === 'user')
                    <div class="mt-6 pt-6 border-t border-slate-200">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600">Applications</span>
                                <span class="font-semibold text-slate-900">{{ $user->applications()->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600">CV Status</span>
                                @if($user->cv_path)
                                    <span class="inline-flex items-center text-xs font-medium text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Uploaded
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-xs font-medium text-orange-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        Not Uploaded
                                    </span>
                                @endif
                            </div>
                            @if($user->city)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600">Location</span>
                                <span class="text-xs text-slate-700">{{ $user->city }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Content - Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Personal Information</h3>
                        <p class="text-sm text-slate-500">Update your account details</p>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="block w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="block w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Location Fields for Job Seekers -->
                    @if($user->role === 'user')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Province</label>
                            <input type="text" name="province" value="{{ old('province', $user->province) }}" placeholder="e.g., DKI Jakarta" class="block w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">City</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="e.g., Jakarta Selatan" class="block w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">District</label>
                        <input type="text" name="district" value="{{ old('district', $user->district) }}" placeholder="e.g., Kebayoran Baru" class="block w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    @endif

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- CV Upload Section (Only for Job Seekers) -->
            @if($user->role === 'user')
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Curriculum Vitae (CV)</h3>
                        <p class="text-sm text-slate-500">Upload your resume in PDF format</p>
                    </div>
                </div>

                @if($user->cv_path)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-10 h-10 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-green-900">CV Uploaded</p>
                                    <p class="text-xs text-green-700">{{ basename($user->cv_path) }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ asset('storage/' . $user->cv_path) }}" target="_blank" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition-colors">
                                    View CV
                                </a>
                                <form action="{{ route('profile.cv.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your CV?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-orange-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-orange-900">No CV uploaded yet</p>
                                <p class="text-xs text-orange-700 mt-1">Upload your CV to apply for jobs</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('profile.cv.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-indigo-400 transition-colors">
                        <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <input type="file" name="cv" accept=".pdf" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="text-xs text-slate-500 mt-2">PDF only, max 5MB</p>
                    </div>
                    @error('cv')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                            Upload CV
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <!-- Change Password -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Change Password</h3>
                        <p class="text-sm text-slate-500">Update your password to keep your account secure</p>
                    </div>
                </div>

                <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Current Password</label>
                        <input type="password" name="current_password" required class="block w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        @error('current_password', 'updatePassword')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                        <input type="password" name="password" required class="block w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        @error('password', 'updatePassword')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required class="block w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div class="bg-white rounded-2xl border border-red-200 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-red-900">Delete Account</h3>
                        <p class="text-sm text-red-600">Permanently delete your account and all data</p>
                    </div>
                </div>

                <p class="text-sm text-slate-600 mb-4">Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.</p>

                <button onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                    Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-slate-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-slate-900 mb-2">Are you sure?</h3>
        <p class="text-sm text-slate-600 mb-4">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.</p>
        
        <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required class="block w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-red-500 focus:border-transparent">
                @error('password', 'userDeletion')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    Delete Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
