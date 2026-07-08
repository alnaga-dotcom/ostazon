<?php

namespace App\Http\Controllers;

use App\Models\SubjectRequest;
use Illuminate\Http\Request;

class SubjectRequestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_name' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        SubjectRequest::create([
            'user_id' => auth()->id(),
            'subject_name' => $data['subject_name'],
            'message' => $data['message'] ?? null,
        ]);

        return back()->with('success', __('messages.request_sent'));
    }
}
