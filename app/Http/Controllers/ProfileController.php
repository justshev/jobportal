<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Upload or update the user's CV.
     */
    public function uploadCV(Request $request): RedirectResponse
    {
        $request->validate([
            'cv' => ['required', 'file', 'mimes:pdf', 'max:5120'], // 5MB = 5120 KB
        ], [
            'cv.required' => 'Please select a CV file to upload.',
            'cv.mimes' => 'CV must be a PDF file.',
            'cv.max' => 'CV file size must not exceed 5MB.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Delete old CV if exists
        if ($user->cv_path && Storage::disk('public')->exists($user->cv_path)) {
            Storage::disk('public')->delete($user->cv_path);
        }

        // Store new CV
        $path = $request->file('cv')->store('cvs', 'public');

        $user->cv_path = $path;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'cv-uploaded');
    }

    /**
     * Delete the user's CV.
     */
    public function deleteCV(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->cv_path && Storage::disk('public')->exists($user->cv_path)) {
            Storage::disk('public')->delete($user->cv_path);
            $user->cv_path = null;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'cv-deleted');
    }

    /**
     * Upload or update the user's profile photo.
     */
    public function uploadPhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'], // 2MB
        ], [
            'profile_photo.required' => 'Please select a photo to upload.',
            'profile_photo.image' => 'File must be an image.',
            'profile_photo.mimes' => 'Photo must be a JPEG, JPG, PNG, or WEBP file.',
            'profile_photo.max' => 'Photo size must not exceed 2MB.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Delete old photo if exists
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Store new photo
        $path = $request->file('profile_photo')->store('profile-photos', 'public');

        $user->profile_photo = $path;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'photo-uploaded');
    }

    /**
     * Delete the user's profile photo.
     */
    public function deletePhoto(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->profile_photo = null;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'photo-deleted');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
