<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('CV / Resume') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Upload your CV to improve your job applications. Maximum file size: 5MB. Only PDF format is accepted.') }}
        </p>
    </header>

    <!-- Success Messages -->
    @if (session('status') === 'cv-uploaded')
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ __('CV uploaded successfully!') }}</span>
            </div>
        </div>
    @endif

    @if (session('status') === 'cv-deleted')
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ __('CV deleted successfully!') }}</span>
            </div>
        </div>
    @endif

    <!-- Current CV Display -->
    @if ($user->cv_path)
        <div class="mt-6 p-4 bg-slate-50 border border-slate-200 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <svg class="w-10 h-10 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Current CV</p>
                        <p class="text-sm text-gray-600">{{ basename($user->cv_path) }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            Uploaded {{ \Carbon\Carbon::parse(\Illuminate\Support\Facades\Storage::disk('public')->lastModified($user->cv_path))->diffForHumans() }}
                        </p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('cv.view', $user->id) }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View
                    </a>
                    <form method="post" action="{{ route('profile.cv.delete') }}" onsubmit="return confirm('Are you sure you want to delete your CV?');">
                        @csrf
                        @method('delete')
                        <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Upload Form -->
    <form method="post" action="{{ route('profile.cv.upload') }}" enctype="multipart/form-data" class="mt-6 space-y-6" x-data="{ fileName: '', fileSize: '', fileError: '' }">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                {{ $user->cv_path ? 'Replace CV' : 'Upload CV' }}
            </label>
            
            <!-- Custom File Input -->
            <div class="flex items-center space-x-4">
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
                <span x-show="fileName" x-text="fileName" class="text-sm text-gray-600"></span>
                <span x-show="fileSize && !fileError" x-text="'(' + (fileSize / 1024 / 1024).toFixed(2) + ' MB)'" class="text-xs text-gray-500"></span>
            </div>

            <!-- File Requirements -->
            <div class="mt-2 text-xs text-gray-500 space-y-1">
                <p class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    PDF format only
                </p>
                <p class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Maximum file size: 5MB
                </p>
            </div>

            <!-- Validation Errors -->
            <x-input-error class="mt-2" :messages="$errors->get('cv')" />
            <div x-show="fileError" x-text="fileError" class="mt-2 text-sm text-red-600"></div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                {{ $user->cv_path ? 'Replace CV' : 'Upload CV' }}
            </button>
        </div>
    </form>
</section>
