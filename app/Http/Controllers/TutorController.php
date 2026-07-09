<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Subject;
use App\Models\TutorWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TutorController extends Controller
{
    public function dashboard()
    {
        $upcomingBookings = Booking::where('tutor_id', auth()->id())
            ->whereIn('lesson_status', ['scheduled', 'confirmed'])
            ->with('student', 'subject')
            ->orderBy('scheduled_at')
            ->get();

        return view('tutor.dashboard', compact('upcomingBookings'));
    }

    public function profile()
    {
        $subjects = Subject::where('is_active', true)->orderBy('name')->get();
        $levels = \App\Models\Level::orderBy('display_order')->get();
        return view('tutor.profile', compact('subjects', 'levels'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string|max:2000',
            'hourly_rate' => 'nullable|numeric|min:0',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'service_types' => 'nullable|array',
            'service_types.*' => 'string',
        ]);

        auth()->user()->tutorProfile()->update([
            'bio' => $request->bio,
            'hourly_rate' => $request->hourly_rate ?? 0,
            'country' => $request->country,
            'city' => $request->city,
            'service_types' => $request->service_types ?? [],
        ]);

        if ($request->filled('phone')) {
            auth()->user()->update(['phone' => $request->phone]);
        }

        return back()->with('success', 'Profile updated successfully');
    }

    public function updateSubjects(Request $request)
    {
        $request->validate([
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id',
            'levels' => 'nullable|array',
            'levels.*' => 'exists:levels,id',
        ]);

        $profile = auth()->user()->tutorProfile;
        $subjectIds = $request->subjects ?? [];
        $levelIds = $request->levels ?? [];

        // Detach all existing subject pivots
        $profile->subjects()->detach();

        // Re-attach with level combinations
        foreach ($subjectIds as $subjectId) {
            if (!empty($levelIds)) {
                foreach ($levelIds as $levelId) {
                    $profile->subjects()->attach($subjectId, ['level_id' => $levelId]);
                }
            } else {
                $profile->subjects()->attach($subjectId);
            }
        }

        return back()->with('success', 'Subjects updated successfully');
    }

    public function verification()
    {
        return view('tutor.verification');
    }

    public function uploadVideo(Request $request)
    {
        $request->validate(['video' => 'required|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:102400']);

        $path = $request->file('video')->store('tutor_verification', 'public');

        auth()->user()->tutorProfile()->update(['video_intro_url' => $path]);

        return back()->with('success', 'Video uploaded successfully');
    }

    public function uploadId(Request $request)
    {
        $request->validate(['id_file' => 'required|image|max:5120']);

        $path = $request->file('id_file')->store('tutor_verification', 'public');

        auth()->user()->tutorProfile()->update(['id_document_url' => $path]);

        return back()->with('success', 'ID uploaded successfully');
    }

    public function uploadCertificate(Request $request)
    {
        $request->validate(['certificate' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240']);

        $path = $request->file('certificate')->store('tutor_verification', 'public');

        auth()->user()->tutorProfile()->update(['certificate_url' => $path]);

        return back()->with('success', 'Certificate uploaded successfully');
    }

    public function earnings()
    {
        return view('tutor.earnings');
    }

    public function withdrawals()
    {
        return view('tutor.withdrawals');
    }

    public function storeWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500|max:' . (auth()->user()->tutorProfile->available_balance ?? 0),
            'payment_method' => 'required|string',
            'payment_details' => 'required|string|max:500',
        ], [
            'amount.min' => __('messages.withdrawal_min'),
        ]);

        TutorWithdrawal::create([
            'tutor_id' => auth()->id(),
            'amount' => $request->amount,
            'withdrawal_method' => $request->payment_method,
            'account_details' => $request->payment_details,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Withdrawal request submitted successfully');
    }
}