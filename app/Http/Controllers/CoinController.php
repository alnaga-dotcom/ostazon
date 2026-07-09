<?php

namespace App\Http\Controllers;

use App\Models\CoinPurchase;
use App\Models\User;
use App\Services\CoinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CoinController extends Controller
{
    public function history()
    {
        return view('student.coins');
    }

    public function purchase()
    {
        return view('student.coins_purchase');
    }

    public function storePurchase(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|integer|in:50,100,250,500,1000',
            'payment_method' => 'required|in:vodafone_cash,instapay,bank_transfer',
            'transaction_reference' => 'nullable|string|max:255',
            'screenshot' => 'nullable|image|max:5120',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('payment-screenshots', 'public');
        }

        CoinPurchase::create([
            'user_id' => Auth::id(),
            'coins_requested' => $data['amount'],
            'amount_egp' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'transaction_reference' => $data['transaction_reference'],
            'screenshot_url' => $screenshotPath,
            'status' => 'pending',
        ]);

        return back()->with('success', __('messages.purchase_submitted'));
    }
}