<?php

namespace App\Http\Controllers;

use App\Services\CoinService;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\CoinTransaction;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::where('student_id', Auth::id())
            ->orWhere('tutor_id', Auth::id())
            ->with(['student', 'tutor', 'subject'])
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }

    /**
     * Mark booking as complete and freeze funds for 7 days
     */
    public function complete(Booking $booking)
    {
        // Verify user is tutor or student
        if (Auth::id() !== $booking->tutor_id && Auth::id() !== $booking->student_id) {
            abort(403);
        }

        $booking->update([
            'lesson_status' => 'completed',
            'completed_at' => now(),
            'frozen_until' => now()->addDays(7),
        ]);

        return back()->with('success', 'Lesson marked as complete. Funds are frozen for 7 days for arbitration window.');
    }

    /**
     * File a dispute/arbitration claim
     */
    public function fileDispute(Request $request, Booking $booking)
    {
        // Verify user is either student or tutor of this booking
        if (Auth::id() !== $booking->student_id && Auth::id() !== $booking->tutor_id) {
            abort(403, 'Unauthorized');
        }

        // Check if within dispute window
        if (!$booking->canDispute()) {
            return back()->with('error', 'Dispute window has closed. You can only file disputes within 7 days of lesson completion.');
        }

        $request->validate([
            'reason' => 'required|string|min:20|max:1000',
            'evidence' => 'nullable|string|max:5000',
        ]);

        // Calculate arbitration fee (20% of lesson fee)
        $fee = $booking->getArbitrationFee();

        // Check if user has enough coins for fee
        $user = Auth::user();
        if (!CoinService::hasSufficient($user->id, (int) ceil($fee))) {
            return back()->with('error', 'Insufficient coins for arbitration fee. Required: ' . $fee . ' coins');
        }

        // Deduct arbitration fee from user coins
        CoinService::debit($user->id, (int) ceil($fee), 'arbitration_fee', 'Arbitration fee for booking #' . $booking->id, 'booking', $booking->id);

        $booking->update([
            'arbitration_fee_paid' => true,
            'arbitration_fee_amount' => $fee,
            'claimant_type' => Auth::id() === $booking->student_id ? 'student' : 'tutor',
            'disputed_at' => now(),
            'dispute_reason' => $request->reason,
            'arbitration_evidence' => $request->evidence,
            'arbitration_status' => 'pending',
        ]);

        return back()->with('success', 'Dispute filed successfully. Our team will review within 48 hours. Arbitration fee of ' . $fee . ' coins has been deducted.');
    }

    /**
     * Show arbitration status
     */
    public function arbitrationStatus(Booking $booking)
    {
        if (Auth::id() !== $booking->student_id && Auth::id() !== $booking->tutor_id) {
            abort(403);
        }

        return view('bookings.arbitration', compact('booking'));
    }
}
