<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    public function dashboard()
    {
        $upcomingBookings = Booking::where('tutor_id', auth()->id())
            ->whereIn('lesson_status', ['scheduled', 'confirmed'])
            ->with('student', 'subject')
            ->orderBy('scheduled_at')
            ->get();

        return view('tutor.dashboard', compact('upcomingBookings'));
    }

    public function profile()
    {
        return view('tutor.profile');
    }

    public function updateProfile(Request $request)
    {
        return back()->with('success', 'Profile updated');
    }

    public function updateSubjects(Request $request)
    {
        return back()->with('success', 'Subjects updated');
    }

    public function verification()
    {
        return view('tutor.verification');
    }

    public function uploadVideo(Request $request)
    {
        return back()->with('success', 'Video uploaded');
    }

    public function uploadId(Request $request)
    {
        return back()->with('success', 'ID uploaded');
    }

    public function uploadCertificate(Request $request)
    {
        return back()->with('success', 'Certificate uploaded');
    }

    public function earnings()
    {
        return view('tutor.earnings');
    }

    public function withdrawals()
    {
        return view('tutor.withdrawals');
    }

    public function storeWithdrawal(Request $request)
    {
        return back()->with('success', 'Withdrawal requested');
    }
}