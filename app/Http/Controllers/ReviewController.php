<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create($booking)
    {
        return view('student.review_create', compact('booking'));
    }

    public function store(Request $request)
    {
        return redirect()->route('student.bookings')->with('success', 'Review submitted');
    }
}