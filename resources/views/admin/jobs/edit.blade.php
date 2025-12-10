@extends('layouts.main')
@section('title', 'Edit Job')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-slate-900 mb-8">Edit Job (Admin)</h1>
    <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST" class="bg-white rounded-xl border border-slate-200 p-8 space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Job Title *</label>
            <input type="text" name="title" value="{{ old('title', $job->title) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Company Name *</label>
            <input type="text" name="company_name" value="{{ old('company_name', $job->company_name) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Location *</label>
                <input type="text" name="location" value="{{ old('location', $job->location) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Employment Type *</label>
                <input type="text" name="employment_type" value="{{ old('employment_type', $job->employment_type) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>
        
        <!-- Salary Range Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Gaji Minimum (Rp)</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                    <input type="text" name="salary_min" id="salary_min" value="{{ old('salary_min', $job->salary_min ? number_format($job->salary_min, 0, ',', '.') : '') }}" placeholder="5.000.000" class="block w-full rounded-lg border border-slate-300 pl-12 pr-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Gaji Maximum (Rp)</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                    <input type="text" name="salary_max" id="salary_max" value="{{ old('salary_max', $job->salary_max ? number_format($job->salary_max, 0, ',', '.') : '') }}" placeholder="10.000.000" class="block w-full rounded-lg border border-slate-300 pl-12 pr-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Description *</label>
            <textarea name="description" rows="6" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('description', $job->description) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Requirements *</label>
            <textarea name="requirements" rows="6" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('requirements', $job->requirements) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Status *</label>
            <select name="status" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                <option value="active" {{ $job->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="closed" {{ $job->status == 'closed' ? 'selected' : '' }}>Closed</option>
                <option value="removed" {{ $job->status == 'removed' ? 'selected' : '' }}>Removed</option>
            </select>
        </div>
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.jobs.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 font-semibold hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">Update Job</button>
        </div>
    </form>
</div>

<script>
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
    
    if (salaryMin) {
        salaryMin.addEventListener('keyup', function(e) {
            salaryMin.value = formatRupiah(this.value);
        });
    }
    
    if (salaryMax) {
        salaryMax.addEventListener('keyup', function(e) {
            salaryMax.value = formatRupiah(this.value);
        });
    }
</script>
@endsection
