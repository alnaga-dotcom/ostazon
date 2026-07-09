<?php

namespace App\Http\Controllers;

use App\Models\SubjectRequest;
use Illuminate\Http\Request;

class SubjectRequestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_name' => 'required|string|max:500',
            'message' => 'nullable|string|max:1000',
        ]);

        $names = array_map('trim', explode(',', $data['subject_name']));
        $names = array_filter($names);

        foreach ($names as $name) {
            SubjectRequest::create([
                'user_id' => auth()->id(),
                'subject_name' => $name,
                'message' => $data['message'] ?? null,
            ]);
        }

        $count = count($names);
        return back()->with('success', $count > 1
            ? $count . ' subject requests sent'
            : __('messages.request_sent'));
    }
}
