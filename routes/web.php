<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobBrowseController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\HRDashboardController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminJobController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminVerificationController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserLocationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/jobs', [JobBrowseController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}', [JobBrowseController::class, 'show'])->name('jobs.show');

// API Route for location
Route::get('/api/cities/{province}', [LocationController::class, 'getCities'])->name('api.cities');

// Job Seeker Routes (role: user)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/user/applications', [ApplicationController::class, 'index'])->name('user.applications.index');
    Route::post('/user/applications', [ApplicationController::class, 'store'])->name('user.applications.store');
    Route::get('/user/applications/{id}', [ApplicationController::class, 'show'])->name('user.applications.show');
    Route::post('/user/location/save', [UserLocationController::class, 'saveLocation'])->name('user.location.save');
    
    // Report Routes for Users
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/my-reports', [ReportController::class, 'myReports'])->name('reports.my-reports');
});

// HR Routes (role: hr)
Route::prefix('hr')->middleware(['auth', 'role:hr'])->name('hr.')->group(function () {
    Route::get('/dashboard', [HRDashboardController::class, 'index'])->name('dashboard');
    Route::resource('jobs', JobPostController::class);
    Route::get('/jobs/{jobId}/applicants', [ApplicantController::class, 'index'])->name('jobs.applicants');
    Route::patch('/applications/{applicationId}/status', [ApplicantController::class, 'updateStatus'])->name('applications.status');
});

// Admin Routes (role: admin)
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{id}/edit', [AdminJobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{id}', [AdminJobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{id}', [AdminJobController::class, 'destroy'])->name('jobs.destroy');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    
    // Report Management for Admin
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{id}', [AdminReportController::class, 'show'])->name('reports.show');
    Route::patch('/reports/{id}', [AdminReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{id}', [AdminReportController::class, 'destroy'])->name('reports.destroy');
    
    // HR Verification Routes
    Route::get('/verification', [AdminVerificationController::class, 'index'])->name('verification.index');
    Route::get('/verification/{id}', [AdminVerificationController::class, 'show'])->name('verification.show');
    Route::post('/verification/{id}/approve', [AdminVerificationController::class, 'approve'])->name('verification.approve');
    Route::post('/verification/{id}/reject', [AdminVerificationController::class, 'reject'])->name('verification.reject');
    Route::get('/verification/{id}/document', [AdminVerificationController::class, 'downloadDocument'])->name('verification.download-document');
});

// Profile Routes (all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // CV Upload Routes
    Route::post('/profile/cv', [ProfileController::class, 'uploadCV'])->name('profile.cv.upload');
    Route::delete('/profile/cv', [ProfileController::class, 'deleteCV'])->name('profile.cv.delete');
    
    // Profile Photo Routes
    Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});

// CV View Route (accessible by user and admin)
Route::middleware('auth')->get('/cv/{user}', function ($userId) {
    $currentUser = \Illuminate\Support\Facades\Auth::user();
    $user = \App\Models\User::findOrFail($userId);
    
    // Only allow user to view their own CV or admin/HR to view any CV
    $canView = ($currentUser->id === $user->id) || 
               ($currentUser->role === 'admin') || 
               ($currentUser->role === 'hr');
    
    if (!$canView) {
        abort(403, 'Unauthorized to view this CV.');
    }
    
    if (!$user->cv_path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($user->cv_path)) {
        abort(404, 'CV not found.');
    }
    
    return response()->file(storage_path('app/public/' . $user->cv_path));
})->name('cv.view');

require __DIR__.'/auth.php';

