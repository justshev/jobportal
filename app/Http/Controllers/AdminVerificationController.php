<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminVerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'hr');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('verification_status', $request->status);
        }

        $hrUsers = $query->latest()->paginate(20);

        $stats = [
            'pending' => User::where('role', 'hr')->where('verification_status', 'pending')->count(),
            'approved' => User::where('role', 'hr')->where('verification_status', 'approved')->count(),
            'rejected' => User::where('role', 'hr')->where('verification_status', 'rejected')->count(),
        ];

        return view('admin.verification.index', compact('hrUsers', 'stats'));
    }

    public function show($id)
    {
        $hrUser = User::where('role', 'hr')->findOrFail($id);
        return view('admin.verification.show', compact('hrUser'));
    }

    public function approve($id)
    {
        $hrUser = User::where('role', 'hr')->findOrFail($id);

        $hrUser->update([
            'verification_status' => 'approved',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'rejection_reason' => null,
        ]);

        return redirect()->route('admin.verification.index')->with('success', 'HR account approved successfully! User can now login.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $hrUser = User::where('role', 'hr')->findOrFail($id);

        $hrUser->update([
            'verification_status' => 'rejected',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.verification.index')->with('success', 'HR account rejected.');
    }

    public function downloadDocument($id)
    {
        $hrUser = User::where('role', 'hr')->findOrFail($id);

        if (!$hrUser->company_document || !Storage::disk('public')->exists($hrUser->company_document)) {
            abort(404, 'Document not found.');
        }

        return response()->download(storage_path('app/public/' . $hrUser->company_document));
    }
}

