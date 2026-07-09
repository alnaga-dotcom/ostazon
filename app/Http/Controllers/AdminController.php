<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CoinPurchase;
use App\Models\Subject;
use App\Models\Setting;
use App\Models\SubjectRequest;
use App\Models\TutorProfile;
use App\Models\TutorWithdrawal;
use App\Models\User;
use App\Services\CoinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $pendingVerifications = TutorProfile::where('verification_status', 'pending')->count();
        $pendingPayments = CoinPurchase::where('status', 'pending')->count();
        $totalRevenue = CoinPurchase::where('status', 'verified')->sum('amount_egp');
        $pendingSubjectRequests = SubjectRequest::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalUsers', 'pendingVerifications', 'pendingPayments', 'totalRevenue', 'pendingSubjectRequests'));
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
            CoinService::credit($booking->student_id, $lessonFee, 'arbitration_refund', 'Arbitration resolved in your favor for booking #' . $booking->id, 'booking', $booking->id);
            $booking->tutor->tutorProfile->decrement('total_earnings', $booking->tutor_earnings);
            $booking->update([
                'arbitration_status' => 'resolved_student',
                'payment_status' => 'refunded',
                'arbitration_evidence' => $evidence,
                'frozen_until' => null,
            ]);
        } elseif ($resolution === 'tutor') {
            $booking->tutor->tutorProfile->increment('available_balance', (int) $booking->tutor_earnings);
            $booking->update([
                'arbitration_status' => 'resolved_tutor',
                'payment_status' => 'released',
                'arbitration_evidence' => $evidence,
                'frozen_until' => null,
            ]);
        } else {
            $booking->tutor->tutorProfile->increment('available_balance', (int) $booking->tutor_earnings);
            $booking->update([
                'arbitration_status' => 'rejected',
                'payment_status' => 'released',
                'arbitration_evidence' => $evidence,
                'frozen_until' => null,
            ]);
        }

        return back()->with('success', 'Arbitration resolved: ' . $resolution);
    }

    public function subjects()
    {
        $allSubjects = Subject::orderBy('name')->get();
        return view('admin.subjects', compact('allSubjects'));
    }

    public function storeSubject(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:subjects',
            'name_ar' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        Subject::create($data);

        return redirect()->route('admin.subjects')->with('success', 'Subject "' . $data['name'] . '" added');
    }

    public function updateSubject(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'name_ar' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $subject->update($data);

        return redirect()->route('admin.subjects')->with('success', 'Subject "' . $data['name'] . '" updated');
    }

    public function deleteSubject(Subject $subject)
    {
        $name = $subject->name;
        $subject->delete();

        return redirect()->route('admin.subjects')->with('success', 'Subject "' . $name . '" deleted');
    }

    public function analytics()
    {
        $totalUsers = User::count();
        $totalTutors = User::where('role', 'tutor')->count();
        $totalStudents = User::where('role', 'student')->count();
        $activeTutors = User::where('role', 'tutor')->where('is_active', true)->count();
        $activeStudents = User::where('role', 'student')->where('is_active', true)->count();

        $pendingVerifications = TutorProfile::where('verification_status', 'pending')->count();
        $verifiedTutors = TutorProfile::where('verification_status', 'verified')->count();

        $totalBookings = Booking::count();
        $completedBookings = Booking::where('lesson_status', 'completed')->count();
        $cancelledBookings = Booking::where('lesson_status', 'cancelled')->count();
        $totalRevenue = CoinPurchase::where('status', 'verified')->sum('amount_egp');

        $pendingWithdrawals = TutorWithdrawal::where('status', 'pending')->count();
        $totalWithdrawn = TutorWithdrawal::where('status', 'processed')->sum('amount');

        $totalReviews = Review::count();
        $avgRating = Review::avg('rating');

        // Monthly registrations (last 6 months)
        $monthlyRegistrations = User::select(
            DB::raw("strftime('%Y-%m', created_at) as month"),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');

        // Top subjects
        $topSubjects = Subject::withCount('tutors')
            ->orderBy('tutors_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.analytics', compact(
            'totalUsers', 'totalTutors', 'totalStudents',
            'activeTutors', 'activeStudents',
            'pendingVerifications', 'verifiedTutors',
            'totalBookings', 'completedBookings', 'cancelledBookings',
            'totalRevenue', 'pendingWithdrawals', 'totalWithdrawn',
            'totalReviews', 'avgRating',
            'monthlyRegistrations', 'topSubjects'
        ));
    }

    public function students()
    {
        $students = User::where('role', 'student')
            ->with('studentProfile')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.students', compact('students'));
    }

    public function users()
    {
        $users = User::with(['tutorProfile', 'studentProfile'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function banUser(User $user)
    {
        $user->update(['is_active' => false]);
        return back()->with('success', 'User "' . $user->name . '" has been suspended');
    }

    public function unbanUser(User $user)
    {
        $user->update(['is_active' => true]);
        return back()->with('success', 'User "' . $user->name . '" has been reactivated');
    }

    public function subjectRequests()
    {
        $requests = SubjectRequest::with('user')->where('status', 'pending')->orderBy('created_at', 'desc')->get();
        return view('admin.subject_requests', compact('requests'));
    }

    public function approveSubjectRequest($id)
    {
        $req = SubjectRequest::findOrFail($id);

        Subject::firstOrCreate(['name' => $req->subject_name]);

        $req->update(['status' => 'approved']);

        return redirect()->route('admin.subjects')->with('success', 'Subject "' . $req->subject_name . '" added from request');
    }

    public function rejectSubjectRequest($id)
    {
        $req = SubjectRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);

        return back()->with('success', 'Subject request "' . $req->subject_name . '" rejected');
    }

    public function settings()
    {
        return view('admin.settings', [
            'settings' => Setting::pluck('value', 'key')->toArray(),
        ]);
    }

    public function updateSettings(Request $request)
    {
        $keys = ['vodafone_cash', 'instapay', 'bank_name', 'bank_account', 'paypal_email', 'platform_fee_percent'];
        foreach ($keys as $key) {
            Setting::setValue($key, $request->input($key));
        }
        return redirect()->route('admin.settings')->with('success', 'Payment settings updated');
    }

    public function grantCoins()
    {
        $students = User::where('role', 'student')->orderBy('name')->get(['id', 'name', 'email']);
        return view('admin.grant_coins', compact('students'));
    }

    public function grantCoinsStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        CoinService::credit(
            $request->user_id,
            $request->amount,
            'admin_grant',
            $request->reason,
            'admin_grant',
            auth()->id()
        );

        $student = User::find($request->user_id);
        return redirect()->route('admin.grant-coins')
            ->with('success', "{$request->amount} coins granted to {$student->name}");
    }
}
