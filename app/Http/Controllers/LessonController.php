<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CoinTransaction;
use App\Services\CoinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    public function studentBookings()
    {
        $bookings = Booking::with(['tutor', 'subject'])
            ->where('student_id', Auth::id())
            ->orderBy('scheduled_at', 'desc')
            ->paginate(20);

        return view('student.bookings', compact('bookings'));
    }

    public function tutorBookings()
    {
        $bookings = Booking::with(['student', 'subject'])
            ->where('tutor_id', Auth::id())
            ->orderBy('scheduled_at', 'desc')
            ->paginate(20);

        return view('tutor.bookings', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'lesson_mode' => 'required|in:online,in_person',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:30|max:240',
            'lesson_fee' => 'required|numeric|min:0',
            'platform_guarantee' => 'required|in:yes,no',
            'student_notes' => 'nullable|string|max:500',
        ]);

        $student = Auth::user();
        $tutor = \App\Models\User::findOrFail($request->tutor_id);

        // Verify tutor exists and is verified
        if (!$tutor->isTutor() || $tutor->tutorProfile->verification_status === 'pending') {
            return back()->with('error', 'Invalid tutor selected.');
        }

        // FIX: Proper boolean casting from string 'yes'/'no' to boolean true/false
        $platformGuarantee = $request->platform_guarantee === 'yes';

        $platformFee = $request->lesson_fee * 0.05; // 5% platform fee
        $tutorEarnings = $request->lesson_fee - $platformFee;

        // If platform guarantee is enabled, verify student has enough coins and deduct
        if ($platformGuarantee) {
            $bookingCost = (int) ceil($request->lesson_fee); // 1 coin = 1 EGP for booking

            if (!CoinService::hasSufficient($student->id, $bookingCost)) {
                return back()->with('error', 'Insufficient coins! You need ' . $bookingCost . ' coins to book this lesson with platform guarantee. Please purchase more coins.');
            }

            $deducted = CoinService::debit(
                $student->id,
                $bookingCost,
                'spend',
                'Lesson booking with ' . $tutor->name . ' for ' . $request->lesson_fee . ' EGP',
                'booking',
                null
            );

            if (!$deducted) {
                return back()->with('error', 'Payment processing failed. Please try again.');
            }
        }

        $booking = Booking::create([
            'student_id' => $student->id,
            'tutor_id' => $tutor->id,
            'subject_id' => $request->subject_id,
            'booking_type' => 'direct',
            'lesson_mode' => $request->lesson_mode,
            'scheduled_at' => $request->scheduled_at,
            'duration_minutes' => $request->duration_minutes,
            'lesson_fee' => $request->lesson_fee,
            'platform_fee' => $platformFee,
            'tutor_earnings' => $tutorEarnings,
            'payment_status' => $platformGuarantee ? 'paid' : 'off_platform',
            'lesson_status' => 'scheduled',
            'platform_guarantee' => $platformGuarantee,
            'student_notes' => $request->student_notes,
            'dispute_until' => $platformGuarantee 
                ? now()->parse($request->scheduled_at)->addHours(48) 
                : null,
        ]);

        if ($platformGuarantee) {
            return redirect()->route('student.bookings')->with('success', 'Booking created and paid! Your lesson is secured with our platform guarantee.');
        } else {
            return redirect()->route('student.bookings')->with('success', 'Booking created! You and the tutor will arrange payment directly. No platform guarantee applies.');
        }
    }

    public function confirm(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->tutor_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $booking->update(['lesson_status' => 'confirmed']);

        return back()->with('success', 'Booking confirmed!');
    }

    public function complete(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Either student or tutor can mark as complete
        if ($booking->tutor_id !== Auth::id() && $booking->student_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        // FIX: Set completed_at timestamp and proper payment status flow
        $updateData = [
            'lesson_status' => 'completed',
            'completed_at' => now(),
        ];

        if ($booking->platform_guarantee) {
            // Move from paid to escrow (waiting for dispute window or review)
            $updateData['payment_status'] = 'escrow';
        } else {
            $updateData['payment_status'] = 'off_platform';
        }

        $booking->update($updateData);

        return back()->with('success', 'Lesson marked as completed!');
    }

    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->student_id !== Auth::id() && $booking->tutor_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        // Can only cancel if scheduled and not started
        if ($booking->lesson_status !== 'scheduled') {
            return back()->with('error', 'Cannot cancel this booking. Lesson has already started or completed.');
        }

        $booking->update(['lesson_status' => 'cancelled']);

        // Refund coins if payment was made through platform
        if ($booking->payment_status === 'paid' && $booking->platform_guarantee) {
            $refundAmount = (int) ceil($booking->lesson_fee);

            CoinService::credit(
                $booking->student_id,
                $refundAmount,
                'refund',
                'Refund for cancelled lesson #' . $booking->id,
                'booking',
                $booking->id
            );

            $booking->update(['payment_status' => 'refunded']);
        }

        return back()->with('success', 'Booking cancelled successfully.');
    }

    public function fileDispute(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->student_id !== Auth::id()) {
            return back()->with('error', 'Only students can file disputes.');
        }

        if ($booking->lesson_status !== 'completed') {
            return back()->with('error', 'Can only dispute completed lessons.');
        }

        if (!$booking->platform_guarantee) {
            return back()->with('error', 'No platform guarantee for this booking.');
        }

        if (now()->gt($booking->dispute_until)) {
            return back()->with('error', 'Dispute window has expired.');
        }

        $booking->update(['dispute_filed' => true]);

        return back()->with('success', 'Dispute filed. Our arbitration team will review within 72 hours.');
    }
}
