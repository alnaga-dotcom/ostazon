<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return back()->with('success', 'Purchase request submitted');
    }

    public function revealContact(Request $request)
    {
        return back()->with('success', 'Contact revealed');
    }
}