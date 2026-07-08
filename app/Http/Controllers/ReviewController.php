<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\TutorProfile;
use App\Services\BadgeService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create($booking)
    {
        $booking = Booking::with(['tutor', 'subject'])->findOrFail($booking);
        
        // Check if user is the student who booked this lesson
        if ($booking->student_id !== auth()->id()) {
            abort(403);
        }

        // Check if already reviewed
        $existingReview = Review::where('booking_id', $booking->id)->first();
        if ($existingReview) {
            return redirect()->route('student.bookings')->with('error', 'You already reviewed this lesson.');
        }

        return view('student.review_create', compact('booking'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'tutor_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Verify student owns this booking
        if ($booking->student_id !== auth()->id()) {
            abort(403);
        }

        // Check if lesson is completed
        if ($booking->lesson_status !== 'completed') {
            return back()->with('error', 'You can only review completed lessons.');
        }

        // Check if already reviewed
        $existingReview = Review::where('booking_id', $booking->id)->first();
        if ($existingReview) {
            return back()->with('error', 'You already reviewed this lesson.');
        }

        // Create review
        $review = Review::create([
            'booking_id' => $request->booking_id,
            'student_id' => auth()->id(),
            'tutor_id' => $request->tutor_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_public' => true,
            'is_verified_booking' => true,
        ]);

        // Update tutor's average rating
        $tutorProfile = TutorProfile::where('user_id', $request->tutor_id)->first();
        if ($tutorProfile) {
            $averageRating = Review::where('tutor_id', $request->tutor_id)
                ->where('is_public', true)
                ->avg('rating');
            
            $tutorProfile->update([
                'average_rating' => round($averageRating, 2),
                'total_lessons' => $tutorProfile->total_lessons + 1,
            ]);

            // Check for badge upgrade
            BadgeService::updateBadge($tutorProfile);
        }

        return redirect()->route('student.bookings')->with('success', 'Review submitted successfully!');
    }
}