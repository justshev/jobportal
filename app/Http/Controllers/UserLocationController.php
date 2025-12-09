<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserLocationController extends Controller
{
    public function saveLocation(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $user = User::findOrFail(Auth::id());
        
        // Save coordinates
        $user->latitude = $validated['latitude'];
        $user->longitude = $validated['longitude'];
        
        // Try to reverse geocode to get location details (optional, using simple approximation)
        $location = $this->approximateLocation($validated['latitude'], $validated['longitude']);
        
        if ($location) {
            $user->province = $location['province'];
            $user->city = $location['city'];
        }
        
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Location saved successfully',
            'location' => $location
        ]);
    }
    
    private function approximateLocation($lat, $lng)
    {
        // Simple approximation based on coordinates
        // Jakarta area
        if ($lat >= -6.4 && $lat <= -5.9 && $lng >= 106.6 && $lng <= 107.0) {
            return ['province' => 'DKI Jakarta', 'city' => 'Jakarta Selatan'];
        }
        // Bandung area
        if ($lat >= -7.0 && $lat <= -6.8 && $lng >= 107.5 && $lng <= 107.7) {
            return ['province' => 'Jawa Barat', 'city' => 'Bandung'];
        }
        // Surabaya area
        if ($lat >= -7.4 && $lat <= -7.1 && $lng >= 112.6 && $lng <= 112.8) {
            return ['province' => 'Jawa Timur', 'city' => 'Surabaya'];
        }
        // Yogyakarta area
        if ($lat >= -8.0 && $lat <= -7.7 && $lng >= 110.3 && $lng <= 110.5) {
            return ['province' => 'DI Yogyakarta', 'city' => 'Yogyakarta'];
        }
        // Semarang area
        if ($lat >= -7.1 && $lat <= -6.9 && $lng >= 110.3 && $lng <= 110.5) {
            return ['province' => 'Jawa Tengah', 'city' => 'Semarang'];
        }
        // Medan area
        if ($lat >= 3.5 && $lat <= 3.7 && $lng >= 98.6 && $lng <= 98.7) {
            return ['province' => 'Sumatera Utara', 'city' => 'Medan'];
        }
        // Bali area
        if ($lat >= -8.8 && $lat <= -8.6 && $lng >= 115.1 && $lng <= 115.3) {
            return ['province' => 'Bali', 'city' => 'Denpasar'];
        }
        
        // Default fallback - let user set manually
        return null;
    }
}
