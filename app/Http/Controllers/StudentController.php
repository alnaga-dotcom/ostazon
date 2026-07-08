<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        $bookings = Booking::where('student_id', auth()->id())
            ->with('tutor', 'subject')
            ->orderBy('created_at', 'desc')
            ->get();

        $activeBookings = Booking::where('student_id', auth()->id())
            ->whereIn('lesson_status', ['scheduled', 'confirmed'])
            ->count();

        return view('student.dashboard', compact('bookings', 'activeBookings'));
    }

    public function profile()
    {
        return view('student.profile');
    }

    public function updateProfile(Request $request)
    {
        return back()->with('success', 'Profile updated');
    }
}