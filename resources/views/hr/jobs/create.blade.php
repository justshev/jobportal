@extends('layouts.main')
@section('title', 'Post New Job')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">Post New Job</h1>
    <form action="{{ route('hr.jobs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-8 space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Job Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Company Name *</label>
            <input type="text" name="company_name" value="{{ old('company_name') }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            @error('company_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        
        <!-- Location Fields -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Provinsi *</label>
                <select name="province" id="province" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    <option value="">Pilih Provinsi</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province }}" {{ old('province') == $province ? 'selected' : '' }}>{{ $province }}</option>
                    @endforeach
                </select>
                @error('province')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kota/Kabupaten *</label>
                <select name="city" id="city" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    <option value="">Pilih Provinsi Dulu</option>
                </select>
                @error('city')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kecamatan</label>
                <input type="text" name="district" value="{{ old('district') }}" placeholder="Contoh: Kebayoran Baru" class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                @error('district')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Lengkap *</label>
            <textarea name="full_address" rows="2" required placeholder="Contoh: Jl. Gatot Subroto No. 123" class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('full_address') }}</textarea>
            @error('full_address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        
        <!-- Geolocation Button -->
        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-indigo-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-indigo-900 mb-1">Gunakan Lokasi Saat Ini</h4>
                    <p class="text-xs text-indigo-700 mb-3">Izinkan akses lokasi untuk mengisi koordinat otomatis (opsional, tapi membantu job seeker menemukan lowongan terdekat)</p>
                    <button type="button" onclick="getLocation()" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        Deteksi Lokasi
                    </button>
                    <span id="locationStatus" class="ml-3 text-xs text-slate-600"></span>
                </div>
            </div>
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Employment Type *</label>
                <select name="employment_type" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    <option value="full-time">Full Time</option>
                    <option value="part-time">Part Time</option>
                    <option value="contract">Contract</option>
                    <option value="internship">Internship</option>
                    <option value="remote">Remote</option>
                </select>
                @error('employment_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
        
        <!-- Salary Range Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Gaji Minimum (Rp)</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                    <input type="text" name="salary_min" id="salary_min" value="{{ old('salary_min') }}" placeholder="5.000.000" class="block w-full rounded-lg border border-slate-300 pl-12 pr-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>
                @error('salary_min')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Gaji Maximum (Rp)</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                    <input type="text" name="salary_max" id="salary_max" value="{{ old('salary_max') }}" placeholder="10.000.000" class="block w-full rounded-lg border border-slate-300 pl-12 pr-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>
                @error('salary_max')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
        
        <!-- Job Poster Image Upload -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Job Poster Image</label>
            <div class="flex items-start gap-4">
                <div class="flex-1">
                    <input type="file" name="image" id="image" accept="image/jpeg,image/jpg,image/png,image/webp" class="block w-full text-sm text-slate-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100
                        cursor-pointer border border-slate-300 rounded-lg">
                    <p class="mt-2 text-xs text-slate-500">Upload job poster image (JPG, PNG, WEBP - Max 5MB)</p>
                    @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div id="imagePreview" class="hidden w-32 h-32 border-2 border-dashed border-slate-300 rounded-lg overflow-hidden">
                    <img id="previewImg" src="" alt="Preview" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Description *</label>
            <textarea name="description" rows="6" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
            @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Requirements *</label>
            <textarea name="requirements" rows="6" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('requirements') }}</textarea>
            @error('requirements')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="flex justify-end space-x-4">
            <a href="{{ route('hr.jobs.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 font-semibold hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">Post Job</button>
        </div>
    </form>
</div>

<script>
    // Province change handler - fetch cities from API
    document.getElementById('province').addEventListener('change', async function() {
        const province = this.value;
        const citySelect = document.getElementById('city');
        
        citySelect.innerHTML = '<option value="">Loading...</option>';
        citySelect.disabled = true;
        
        if (province) {
            try {
                const response = await fetch(`/api/cities/${encodeURIComponent(province)}`);
                const cities = await response.json();
                
                citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });
                citySelect.disabled = false;
            } catch (error) {
                citySelect.innerHTML = '<option value="">Error loading cities</option>';
                citySelect.disabled = false;
            }
        } else {
            citySelect.innerHTML = '<option value="">Pilih Provinsi Dulu</option>';
            citySelect.disabled = false;
        }
    });
    
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Geolocation function
    function getLocation() {
        const status = document.getElementById('locationStatus');
        
        if (!navigator.geolocation) {
            status.textContent = 'Geolocation tidak didukung browser Anda';
            status.className = 'ml-3 text-xs text-red-600';
            return;
        }
        
        status.textContent = 'Mendeteksi lokasi...';
        status.className = 'ml-3 text-xs text-indigo-600';
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('latitude').value = position.coords.latitude.toFixed(8);
                document.getElementById('longitude').value = position.coords.longitude.toFixed(8);
                status.textContent = '✓ Koordinat berhasil dideteksi!';
                status.className = 'ml-3 text-xs text-green-600 font-semibold';
            },
            function(error) {
                let errorMsg = 'Gagal mendeteksi lokasi';
                let helpText = '';
                
                if (error.code === error.PERMISSION_DENIED) {
                    errorMsg = 'Izin akses lokasi ditolak';
                    helpText = ' Pastikan Anda mengizinkan akses lokasi di browser.';
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    errorMsg = 'Lokasi tidak tersedia';
                    helpText = ' Pastikan GPS aktif dan terhubung internet. Gunakan HTTPS atau localhost.';
                } else if (error.code === error.TIMEOUT) {
                    errorMsg = 'Waktu permintaan habis';
                    helpText = ' Coba lagi dengan koneksi yang lebih baik.';
                }
                
                status.textContent = errorMsg + helpText;
                status.className = 'ml-3 text-xs text-red-600';
            },
            {
                enableHighAccuracy: false,
                timeout: 30000,
                maximumAge: 60000
            }
        );
    }
    
    // Format Rupiah
    function formatRupiah(angka) {
        const numberString = angka.replace(/[^,\d]/g, '').toString();
        const split = numberString.split(',');
        const sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        
        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }
    
    // Apply format to salary inputs
    const salaryMin = document.getElementById('salary_min');
    const salaryMax = document.getElementById('salary_max');
    
    salaryMin.addEventListener('keyup', function(e) {
        salaryMin.value = formatRupiah(this.value);
    });
    
    salaryMax.addEventListener('keyup', function(e) {
        salaryMax.value = formatRupiah(this.value);
    });
</script>
@endsection
