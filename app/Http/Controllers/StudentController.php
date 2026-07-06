<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        return view('student.dashboard');
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