<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\TutorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorDirectoryController extends Controller
{
    public function landing()
    {
        $featuredTutors = User::where('role', 'tutor')
            ->where('is_active', true)
            ->whereHas('tutorProfile', function ($q) {
                $q->where('verification_status', '!=', 'pending');
            })
            ->with(['tutorProfile', 'tutorProfile.subjects'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $subjects = Subject::orderBy('name')->get();

        $stats = [
            'tutors' => User::where('role', 'tutor')->where('is_active', true)->count(),
            'students' => User::where('role', 'student')->where('is_active', true)->count(),
            'subjects' => Subject::count(),
            'lessons' => \App\Models\Booking::where('lesson_status', 'completed')->count(),
        ];

        return view('landing', compact('featuredTutors', 'subjects', 'stats'));
    }

    public function index(Request $request)
    {
        $query = User::where('role', 'tutor')
            ->where('is_active', true)
            ->whereHas('tutorProfile', function ($q) {
                $q->where('verification_status', '!=', 'pending');
            })
            ->with(['tutorProfile', 'tutorProfile.subjects']);

        if ($request->subject) {
            $query->whereHas('tutorProfile.subjects', function ($q) use ($request) {
                $q->where('subjects.id', $request->subject);
            });
        }

        if ($request->country) {
            $query->whereHas('tutorProfile', function ($q) use ($request) {
                $q->where('country', $request->country);
            });
        }

        if ($request->lesson_mode) {
            $query->whereHas('tutorProfile', function ($q) use ($request) {
                $q->where('lesson_mode', $request->lesson_mode);
            });
        }

        if ($request->min_price) {
            $query->whereHas('tutorProfile', function ($q) use ($request) {
                $q->where('hourly_rate', '>=', $request->min_price);
            });
        }

        if ($request->max_price) {
            $query->whereHas('tutorProfile', function ($q) use ($request) {
                $q->where('hourly_rate', '<=', $request->max_price);
            });
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $tutors = $query->orderBy('created_at', 'desc')->paginate(12);
        $subjects = Subject::orderBy('name')->get();
        $countries = TutorProfile::whereNotNull('country')->distinct()->pluck('country')->sort()->values();

        return view('tutors.index', compact('tutors', 'subjects', 'countries'));
    }

    public function show($id)
    {
        $tutor = User::where('role', 'tutor')
            ->where('is_active', true)
            ->whereHas('tutorProfile', function ($q) {
                $q->where('verification_status', '!=', 'pending');
            })
            ->with(['tutorProfile', 'tutorProfile.subjects', 'reviewsAsTutor.student'])
            ->findOrFail($id);

        $reviews = $tutor->reviewsAsTutor()->with('student')->orderBy('created_at', 'desc')->take(10)->get();

        $similarTutors = User::where('role', 'tutor')
            ->where('id', '!=', $tutor->id)
            ->where('is_active', true)
            ->whereHas('tutorProfile', function ($q) {
                $q->where('verification_status', '!=', 'pending');
            })
            ->whereHas('tutorProfile.subjects', function ($q) use ($tutor) {
                $q->whereIn('subjects.id', $tutor->tutorProfile->subjects->pluck('id'));
            })
            ->with(['tutorProfile', 'tutorProfile.subjects'])
            ->take(4)
            ->get();

        return view('tutors.show', compact('tutor', 'reviews', 'similarTutors'));
    }
}