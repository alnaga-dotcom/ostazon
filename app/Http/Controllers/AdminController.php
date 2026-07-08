<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CoinPurchase;
use App\Models\TutorProfile;
use App\Models\TutorWithdrawal;
use App\Models\User;
use App\Services\CoinService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $pendingVerifications = TutorProfile::where('verification_status', 'pending')->count();
        $pendingPayments = CoinPurchase::where('status', 'pending')->count();
        $totalRevenue = CoinPurchase::where('status', 'verified')->sum('amount_egp');

        return view('admin.dashboard', compact('totalUsers', 'pendingVerifications', 'pendingPayments', 'totalRevenue'));
    }

    public function payments()
    {
        $pendingPayments = CoinPurchase::with('user')->where('status', 'pending')->orderBy('created_at', 'desc')->paginate(20);
        $verifiedPayments = CoinPurchase::with(['user', 'verifier'])->whereIn('status', ['verified', 'rejected'])->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.payments', compact('pendingPayments', 'verifiedPayments'));
    }

    public function verifyPayment($id)
    {
        $purchase = CoinPurchase::findOrFail($id);
        $purchase->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);
        CoinService::credit($purchase->user_id, $purchase->coins_requested, 'purchase', 'Coin purchase verified: ' . $purchase->coins_requested . ' coins', 'coin_purchase', $purchase->id);
        return back()->with('success', 'Payment verified — ' . $purchase->coins_requested . ' coins credited to user');
    }

    public function rejectPayment(Request $request, $id)
    {
        $purchase = CoinPurchase::findOrFail($id);
        $purchase->update([
            'status' => 'rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'admin_notes' => $request->input('admin_notes'),
        ]);
        return back()->with('success', 'Payment rejected');
    }

    public function withdrawals()
    {
        $withdrawals = \App\Models\TutorWithdrawal::with('tutor')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.withdrawals', compact('withdrawals'));
    }

    public function processWithdrawal(Request $request, $id)
    {
        $withdrawal = TutorWithdrawal::findOrFail($id);
        $withdrawal->update([
            'status' => 'processed',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'admin_notes' => $request->input('admin_notes'),
        ]);
        return back()->with('success', 'Withdrawal #' . $id . ' processed');
    }

    public function disputes()
    {
        return view('admin.disputes');
    }

    public function resolveDispute($id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->arbitration_status === 'pending') {
            return redirect()->route('admin.arbitrations')->with('info', 'This dispute is in the arbitration system — resolve it from the Arbitrations page');
        }
        $booking->update(['dispute_filed' => false]);
        return back()->with('success', 'Old dispute resolved');
    }

    public function arbitrations()
    {
        $arbitrations = Booking::with(['student', 'tutor', 'subject'])
            ->where('arbitration_status', 'pending')
            ->orderBy('disputed_at', 'desc')
            ->paginate(20);

        return view('admin.admin_arbitrations', compact('arbitrations'));
    }

    public function resolveArbitration(Request $request, Booking $booking)
    {
        $request->validate([
            'resolution' => 'required|in:student,tutor,reject',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $resolution = $request->resolution;
        $lessonFee = (int) ceil($booking->lesson_fee);
        $arbitrationFee = (int) ceil($booking->arbitration_fee_amount);

        $evidence = $booking->arbitration_evidence;
        if ($request->admin_notes) {
            $evidence = ($evidence ? $evidence . "\n\n" : '') . '[Admin Notes]: ' . $request->admin_notes;
        }

        if ($resolution === 'student') {
            // Refund lesson fee to student, tutor gets nothing from escrow
            CoinService::credit($booking->student_id, $lessonFee, 'arbitration_refund', 'Arbitration resolved in your favor for booking #' . $booking->id, 'booking', $booking->id);
            $booking->update([
                'arbitration_status' => 'resolved_student',
                'payment_status' => 'refunded',
                'arbitration_evidence' => $evidence,
                'frozen_until' => null,
            ]);
        } elseif ($resolution === 'tutor') {
            // Release lesson fee to tutor (minus platform fee already accounted)
            CoinService::credit($booking->tutor_id, $lessonFee, 'arbitration_release', 'Arbitration resolved in your favor for booking #' . $booking->id, 'booking', $booking->id);
            $booking->update([
                'arbitration_status' => 'resolved_tutor',
                'payment_status' => 'released',
                'arbitration_evidence' => $evidence,
                'frozen_until' => null,
            ]);
        } else {
            // Reject the claim — release funds to tutor (claimant pays fee)
            CoinService::credit($booking->tutor_id, $lessonFee, 'arbitration_release', 'Arbitration claim rejected — funds released for booking #' . $booking->id, 'booking', $booking->id);
            $booking->update([
                'arbitration_status' => 'rejected',
                'payment_status' => 'released',
                'arbitration_evidence' => $evidence,
                'frozen_until' => null,
            ]);
        }

        return back()->with('success', 'Arbitration resolved: ' . $resolution);
    }

    public function analytics()
    {
        return view('admin.analytics');
    }
}
