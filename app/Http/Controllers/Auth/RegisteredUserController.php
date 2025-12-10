<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,hr'],
            'cv' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // Optional CV for job seekers
            'company_document' => ['required_if:role,hr', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // Required for HR
        ], [
            'cv.mimes' => 'CV must be a PDF file.',
            'cv.max' => 'CV file size must not exceed 5MB.',
            'company_document.required_if' => 'Company document is required for HR registration.',
            'company_document.mimes' => 'Company document must be a PDF, JPG, or PNG file.',
            'company_document.max' => 'Company document file size must not exceed 5MB.',
        ]);

        $cvPath = null;
        $documentPath = null;
        
        // Handle CV upload if provided
        if ($request->hasFile('cv') && $request->role === 'user') {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        // Handle company document upload for HR
        if ($request->hasFile('company_document') && $request->role === 'hr') {
            $documentPath = $request->file('company_document')->store('company-documents', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'cv_path' => $cvPath,
            'company_document' => $documentPath,
            'verification_status' => $request->role === 'hr' ? 'pending' : 'approved',
        ]);

        event(new Registered($user));

        // HR users need verification before login
        if ($user->role === 'hr' && $user->verification_status === 'pending') {
            return redirect()->route('login')->with('status', 'Your account has been created! Please wait for admin approval before you can login. You will be notified via email.');
        }

        // Job seekers can login immediately
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
