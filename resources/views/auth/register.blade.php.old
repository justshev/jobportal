<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" x-data="{ role: '{{ old('role', 'user') }}', uploadNow: false, fileName: '', fileSize: '', fileError: '' }">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Register as')" />
            <select id="role" name="role" x-model="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="user">Job Seeker</option>
                <option value="hr">HR / Employer</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- CV Upload for Job Seekers -->
        <div x-show="role === 'user'" x-transition class="mt-4">
            <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-indigo-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900">Upload Your CV (Optional)</h4>
                        <p class="text-xs text-gray-600 mt-1">You can upload your CV now or later in your profile. Note: CV is required to apply for jobs.</p>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" x-model="uploadNow" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-gray-700">I want to upload my CV now</span>
                    </label>
                </div>

                <div x-show="uploadNow" x-transition class="mt-4 space-y-3">
                    <div>
                        <label for="cv-upload" class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Choose PDF File
                        </label>
                        <input 
                            id="cv-upload" 
                            name="cv" 
                            type="file" 
                            accept=".pdf"
                            class="hidden"
                            @change="
                                fileName = $event.target.files[0]?.name || '';
                                fileSize = $event.target.files[0]?.size || 0;
                                fileError = '';
                                if (fileSize > 5242880) {
                                    fileError = 'File size exceeds 5MB';
                                    $event.target.value = '';
                                    fileName = '';
                                }
                            "
                        >
                    </div>

                    <div x-show="fileName" class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                        </svg>
                        <span x-text="fileName" class="text-sm text-gray-600"></span>
                        <span x-show="fileSize && !fileError" x-text="'(' + (fileSize / 1024 / 1024).toFixed(2) + ' MB)'" class="text-xs text-gray-500"></span>
                    </div>

                    <div class="text-xs text-gray-500 space-y-1">
                        <p class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            PDF format only, max 5MB
                        </p>
                    </div>

                    <x-input-error :messages="$errors->get('cv')" class="mt-2" />
                    <div x-show="fileError" x-text="fileError" class="text-sm text-red-600"></div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
