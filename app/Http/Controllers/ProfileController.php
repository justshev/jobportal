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
