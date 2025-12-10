@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">Dashboard</h1>

    <!-- CV Warning Banner -->
    @if(!auth()->user()->cv_path)
    <div id="cvBanner" class="mb-6 sm:mb-8 rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg" style="background: linear-gradient(135deg, #f97316 0%, #dc2626 100%);">
        <div class="flex flex-col sm:flex-row items-start gap-4" style="color: #ffffff;">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 sm:h-7 sm:w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1 w-full">
                <div class="flex items-start justify-between gap-3">
                    <h3 class="text-lg sm:text-xl font-bold">
                        📄 Upload Your CV to Apply for Jobs
                    </h3>
                    <button onclick="document.getElementById('cvBanner').style.display='none'" class="flex-shrink-0 sm:hidden" style="color: rgba(255, 255, 255, 0.85);">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="mt-2 sm:mt-3">
                    <p class="mb-3 sm:mb-4 text-sm leading-relaxed" style="color: rgba(255, 255, 255, 0.95);">You haven't uploaded your CV yet. A CV is <strong>required</strong> to apply for any job position. Upload your CV now to start your job search journey!</p>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center w-full sm:w-auto px-4 sm:px-5 py-2 sm:py-2.5 bg-white hover:bg-gray-100 rounded-lg transition-all shadow-md" style="color: #f97316; font-weight: 700; font-size: 0.875rem;">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Upload CV Now
                        </a>
                        <button onclick="document.getElementById('cvBanner').style.display='none'" class="text-sm font-medium underline" style="color: rgba(255, 255, 255, 0.85);">
                            Remind me later
                        </button>
                    </div>
                </div>
            </div>
            <button @click="show = false" class="hidden sm:block flex-shrink-0 transition-opacity hover:opacity-100" style="color: rgba(255, 255, 255, 0.85); opacity: 0.85;">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <!-- Location Detection Banner -->
    @if(!auth()->user()->city || !auth()->user()->latitude)
    <div class="mb-6 sm:mb-8 rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
        <div class="flex flex-col sm:flex-row items-start gap-4" style="color: #ffffff;">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 sm:h-7 sm:w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div class="flex-1 w-full">
                <h3 class="text-lg sm:text-xl font-bold mb-2">
                    📍 Aktifkan Lokasi untuk Rekomendasi Lebih Akurat
                </h3>
                <p class="mb-4 text-sm leading-relaxed" style="color: rgba(255, 255, 255, 0.95);">
                    Izinkan akses lokasi Anda untuk mendapatkan rekomendasi pekerjaan terdekat dari lokasi Anda. Kami akan menampilkan lowongan berdasarkan jarak dan kota yang sama.
                </p>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <button onclick="enableLocation()" id="locationBtn" class="inline-flex items-center justify-center w-full sm:w-auto px-5 py-2.5 bg-white hover:bg-gray-100 rounded-lg transition-all shadow-md" style="color: #6366f1; font-weight: 700; font-size: 0.875rem;">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        <span id="btnText">Aktifkan Lokasi</span>
                    </button>
                    <a href="{{ route('profile.edit') }}" class="text-sm font-medium underline" style="color: rgba(255, 255, 255, 0.9);">
                        Atau set lokasi manual di Profile
                    </a>
                </div>
                <div id="locationStatus" class="mt-3 text-sm font-semibold"></div>
            </div>
        </div>
    </div>
    @else
    <!-- Current Location Info -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <h4 class="text-sm font-semibold text-green-900 mb-1">Lokasi Aktif</h4>
                <p class="text-xs text-green-700">
                    Rekomendasi job berdasarkan: <strong>{{ auth()->user()->city }}, {{ auth()->user()->province }}</strong>
                    <a href="{{ route('profile.edit') }}" class="ml-2 underline hover:text-green-800">Ubah lokasi</a>
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
            <div class="text-xs sm:text-sm font-medium text-slate-600 mb-1 sm:mb-2">Total Applications</div>
            <div class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $stats['total_applications'] }}</div>
        </div>
        <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
            <div class="text-xs sm:text-sm font-medium text-slate-600 mb-1 sm:mb-2">In Review</div>
            <div class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $stats['in_review'] }}</div>
        </div>
        <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
            <div class="text-xs sm:text-sm font-medium text-slate-600 mb-1 sm:mb-2">Shortlisted</div>
            <div class="text-2xl sm:text-3xl font-bold text-yellow-600">{{ $stats['shortlisted'] }}</div>
        </div>
        <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
            <div class="text-xs sm:text-sm font-medium text-slate-600 mb-1 sm:mb-2">Accepted</div>
            <div class="text-2xl sm:text-3xl font-bold text-green-600">{{ $stats['accepted'] }}</div>
        </div>
    </div>

    <!-- Recommended Jobs -->
    <div class="mb-6 sm:mb-8">
        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mb-3 sm:mb-4">Recommended Jobs</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($recommendedJobs as $job)
                <div class="bg-white rounded-lg sm:rounded-xl border border-slate-200 overflow-hidden hover:shadow-lg transition-shadow">
                    @if($job->image)
                        <img src="{{ asset('storage/' . $job->image) }}" alt="{{ $job->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-semibold text-slate-900 mb-2">{{ $job->title }}</h3>
                        <p class="text-sm sm:text-base text-slate-600 mb-2 sm:mb-3">{{ $job->company_name }}</p>
                        <p class="text-xs sm:text-sm text-slate-500 mb-3 sm:mb-4 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ $job->city }}, {{ $job->province }}
                            @if(isset($job->distance))
                                <span class="ml-2 text-indigo-600 font-semibold">({{ number_format($job->distance, 1) }} km)</span>
                            @endif
                        </p>
                        <a href="{{ route('jobs.show', $job->id) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm inline-flex items-center">
                            View Details
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function enableLocation() {
        const btn = document.getElementById('locationBtn');
        const btnText = document.getElementById('btnText');
        const status = document.getElementById('locationStatus');
        
        if (!navigator.geolocation) {
            status.textContent = '❌ Browser Anda tidak mendukung geolocation';
            status.className = 'mt-3 text-sm font-semibold text-red-100';
            return;
        }
        
        // Update button state
        btn.disabled = true;
        btnText.textContent = 'Mendeteksi lokasi...';
        status.textContent = '🔍 Sedang mengakses lokasi Anda...';
        status.className = 'mt-3 text-sm font-semibold text-white';
        
        // Check if using secure context
        const isSecure = window.location.protocol === 'https:' || 
                        window.location.hostname === 'localhost' || 
                        window.location.hostname === '127.0.0.1';
        
        if (!isSecure) {
            status.textContent = '⚠️ Gunakan https:// atau localhost untuk akses lokasi. URL saat ini: ' + window.location.href;
            status.className = 'mt-3 text-sm font-semibold text-yellow-100';
            btn.disabled = false;
            btnText.textContent = 'Coba Lagi';
            return;
        }
        
        navigator.geolocation.getCurrentPosition(
            async function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                status.textContent = '💾 Menyimpan lokasi...';
                
                try {
                    const response = await fetch('{{ route("user.location.save") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            latitude: lat,
                            longitude: lng
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        status.textContent = '✅ Lokasi berhasil disimpan! Memuat ulang...';
                        status.className = 'mt-3 text-sm font-semibold text-green-100';
                        
                        // Reload page after 1.5s to show updated recommendations
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        throw new Error(data.message || 'Gagal menyimpan lokasi');
                    }
                } catch (error) {
                    status.textContent = '❌ ' + error.message;
                    status.className = 'mt-3 text-sm font-semibold text-red-100';
                    btn.disabled = false;
                    btnText.textContent = 'Coba Lagi';
                }
            },
            function(error) {
                let errorMsg = 'Gagal mendeteksi lokasi';
                let helpText = '';
                
                console.log('Geolocation error:', error); // Debug log
                
                if (error.code === error.PERMISSION_DENIED) {
                    errorMsg = '🚫 Izin akses lokasi ditolak';
                    helpText = ' Klik icon gembok di address bar, izinkan akses lokasi, lalu refresh halaman.';
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    errorMsg = '📍 Lokasi tidak dapat dideteksi';
                    helpText = ' Cara fix: (1) System Settings → Privacy & Security → Location Services → ON, (2) Izinkan browser akses location, (3) Gunakan WiFi (lebih akurat), atau (4) Set lokasi manual di Profile.';
                } else if (error.code === error.TIMEOUT) {
                    errorMsg = '⏱️ Waktu permintaan habis';
                    helpText = ' Sinyal GPS lemah. Coba: Tunggu beberapa saat, gunakan WiFi, atau set manual di Profile.';
                } else {
                    errorMsg = '❌ Error tidak diketahui';
                    helpText = ' Error code: ' + error.code + '. Message: ' + error.message;
                }
                
                status.innerHTML = errorMsg + helpText + '<br><a href="{{ route("profile.edit") }}" class="text-yellow-200 underline font-semibold mt-2 inline-block">→ Set Lokasi Manual di Profile</a>';
                status.className = 'mt-3 text-sm font-semibold text-red-100';
                btn.disabled = false;
                btnText.textContent = 'Coba Lagi';
            },
            {
                enableHighAccuracy: false, // Ubah ke false untuk lebih cepat
                timeout: 30000, // Naikkan timeout ke 30 detik
                maximumAge: 60000 // Cache lokasi selama 1 menit
            }
        );
    }
</script>
@endsection
