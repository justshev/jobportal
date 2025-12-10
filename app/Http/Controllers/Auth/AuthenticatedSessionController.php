<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect based on user role
        /** @var User $user */
        $user = Auth::user();
        
        // Check if HR user is verified
        if ($user->role === 'hr' && !$user->isVerified()) {
            Auth::logout();
            
            $message = match($user->verification_status) {
                'pending' => 'Your account is pending admin verification. You will be notified via email once approved.',
                'rejected' => 'Your account has been rejected. Reason: ' . $user->rejection_reason,
                default => 'Your account needs verification before you can login.',
            };
            
            return redirect()->route('login')->with('error', $message);
        }
        
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        } elseif ($user->role === 'hr') {
            return redirect()->intended(route('hr.dashboard', absolute: false));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
