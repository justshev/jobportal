<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            
            // Check if HR user is not verified
            if ($user->role === 'hr' && !$user->isVerified()) {
                Auth::logout();
                
                $message = match($user->verification_status) {
                    'pending' => 'Your account is pending verification. Please wait for admin approval.',
                    'rejected' => 'Your account has been rejected. Reason: ' . $user->rejection_reason,
                    default => 'Your account needs verification before you can proceed.',
                };
                
                return redirect()->route('login')->with('error', $message);
            }
        }
        
        return $next($request);
    }
}

