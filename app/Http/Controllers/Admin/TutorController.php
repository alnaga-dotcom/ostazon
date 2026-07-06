<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TutorProfile;
use App\Models\User;
use App\Services\BadgeService;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    /**
     * List all tutors for admin review
     */
    public function index()
    {
        $pendingTutors = TutorProfile::with('user')
            ->where('verification_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $allTutors = TutorProfile::with('user')
            ->whereIn('verification_status', ['verified', 'certified'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.tutors', compact('pendingTutors', 'allTutors'));
    }

    /**
     * Verify a tutor and assign initial badge
     */
    public function verify(Request $request, TutorProfile $tutor)
    {
        $request->validate([
            'level' => 'required|in:verified,certified',
        ]);

        $tutor->update([
            'verification_status' => $request->level,
        ]);

        // Auto-assign badge based on verification level
        BadgeService::updateBadge($tutor);

        return back()->with('success', 'Tutor verified as ' . $request->level);
    }

    /**
     * Reject a tutor verification
     */
    public function reject(TutorProfile $tutor)
    {
        $tutor->update([
            'verification_status' => 'rejected',
            'badge_level' => null,
        ]);

        return back()->with('success', 'Tutor verification rejected');
    }

    /**
     * Manually update badge (for admin override)
     */
    public function updateBadge(Request $request, TutorProfile $tutor)
    {
        $request->validate([
            'badge' => 'required|in:verified,certified,top,elite',
        ]);

        $tutor->update([
            'badge_level' => $request->badge,
            'badge_awarded_at' => now(),
        ]);

        return back()->with('success', 'Badge updated to ' . $request->badge);
    }
}
