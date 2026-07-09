<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TutorProfile;
use App\Models\User;
use App\Notifications\TutorVerified;
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
    public function verify(Request $request, $tutor)
    {
        $tutorProfile = TutorProfile::findOrFail($tutor);

        $request->validate([
            'level' => 'required|in:verified,certified',
        ]);

        $tutorProfile->update([
            'verification_status' => $request->level,
        ]);

        // Auto-assign badge based on verification level
        BadgeService::updateBadge($tutorProfile);

        // Notify tutor
        $tutorProfile->user->notify(new TutorVerified($request->level));

        return back()->with('success', 'Tutor verified as ' . $request->level);
    }

    public function reject($tutor)
    {
        $tutorProfile = TutorProfile::findOrFail($tutor);

        $tutorProfile->update([
            'verification_status' => 'rejected',
            'badge_level' => null,
        ]);

        return back()->with('success', 'Tutor verification rejected');
    }

    public function updateBadge(Request $request, $tutor)
    {
        $tutorProfile = TutorProfile::findOrFail($tutor);

        $request->validate([
            'badge' => 'required|in:verified,certified,top,elite',
        ]);

        $tutorProfile->update([
            'badge_level' => $request->badge,
            'badge_awarded_at' => now(),
        ]);

        return back()->with('success', 'Badge updated to ' . $request->badge);
    }
    }
