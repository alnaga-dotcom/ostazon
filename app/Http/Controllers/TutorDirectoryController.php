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

        $classType = $request->class_type ?? $request->lesson_mode;
        if ($classType) {
            $query->whereHas('tutorProfile', function ($q) use ($classType) {
                if (in_array($classType, ['online', 'in_person', 'both'])) {
                    $q->where('lesson_mode', $classType);
                }
            });
        }

        // Filter by service type (assignment, exam_help, project_help)
        if ($request->service_type) {
            $query->whereHas('tutorProfile', function ($q) use ($request) {
                $q->whereJsonContains('service_types', $request->service_type);
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

        // Sponsored tutors first
        $query->orderBy(
            TutorProfile::select('is_sponsored')
                ->whereColumn('user_id', 'users.id')
                ->limit(1),
            'desc'
        );

        $sort = $request->sort ?? 'newest';
        match ($sort) {
            'price_asc' => $query->orderBy(
                TutorProfile::select('hourly_rate')
                    ->whereColumn('user_id', 'users.id')
                    ->limit(1),
                'asc'
            ),
            'price_desc' => $query->orderBy(
                TutorProfile::select('hourly_rate')
                    ->whereColumn('user_id', 'users.id')
                    ->limit(1),
                'desc'
            ),
            'rating' => $query->orderBy(
                TutorProfile::select('average_rating')
                    ->whereColumn('user_id', 'users.id')
                    ->limit(1),
                'desc'
            ),
            default => $query->orderBy('created_at', 'desc'),
        };

        $tutors = $query->paginate(12);
        $subjects = Subject::orderBy('name')->get();

        // Fallback country list if DB has none
        $dbCountries = TutorProfile::whereNotNull('country')->distinct()->pluck('country')->sort()->values();
        if ($dbCountries->isEmpty()) {
            $countries = collect([
                __('messages.egypt'),
                __('messages.saudi_arabia'),
                __('messages.uae'),
                __('messages.kuwait'),
                __('messages.qatar'),
                __('messages.oman'),
                __('messages.bahrain'),
                __('messages.jordan'),
                __('messages.lebanon'),
                __('messages.iraq'),
                __('messages.syria'),
                __('messages.palestine'),
                __('messages.morocco'),
                __('messages.algeria'),
                __('messages.tunisia'),
                __('messages.libya'),
                __('messages.sudan'),
                __('messages.yemen'),
            ]);
        } else {
            $countries = $dbCountries;
        }

        return view('tutor.index', compact('tutors', 'subjects', 'countries'));
    }

    public function show($id)
    {
        $tutor = User::where('role', 'tutor')
            ->where('is_active', true)
            ->whereHas('tutorProfile', function ($q) {
                $q->where('verification_status', '!=', 'pending');
            })
            ->with(['tutorProfile', 'tutorProfile.subjects'])
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

        return view('tutor.show', compact('tutor', 'reviews', 'similarTutors'));
    }
}
