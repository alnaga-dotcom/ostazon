<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function payments()
    {
        return view('admin.payments');
    }

    public function verifyPayment($id)
    {
        return back()->with('success', 'Payment verified');
    }

    public function rejectPayment($id)
    {
        return back()->with('success', 'Payment rejected');
    }

    public function withdrawals()
    {
        return view('admin.withdrawals');
    }

    public function processWithdrawal($id)
    {
        return back()->with('success', 'Withdrawal processed');
    }

    public function disputes()
    {
        return view('admin.disputes');
    }

    public function resolveDispute($id)
    {
        return back()->with('success', 'Dispute resolved');
    }

    public function arbitrations()
    {
        return view('admin.admin_arbitrations');
    }

    public function resolveArbitration($booking)
    {
        return back()->with('success', 'Arbitration resolved');
    }

    public function analytics()
    {
        return view('admin.analytics');
    }
}