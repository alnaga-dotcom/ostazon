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
            $term = trim($request->subject);
            if ($term !== '') {
                $matchingIds = Subject::where('name', 'like', "%{$term}%")
                    ->orWhere('name_ar', 'like', "%{$term}%")
                    ->orWhereHas('searchTerms', fn($q) => $q->where('term', 'like', "%{$term}%"))
                    ->pluck('id');
                if ($matchingIds->isNotEmpty()) {
                    $query->whereHas('tutorProfile.subjects', fn($q) => $q->whereIn('subjects.id', $matchingIds));
                }
            }
        }

        if ($request->level) {
            $query->whereHas('tutorProfile.subjects', function ($q) use ($request) {
                $q->where('tutor_subjects.level_id', $request->level);
            });
        }

        if ($request->country) {
            $query->whereHas('tutorProfile', function ($q) use ($request) {
                $q->where('country', $request->country);
            });
        }

        if ($request->city) {
            $query->whereHas('tutorProfile', function ($q) use ($request) {
                $q->where('city', 'like', '%' . trim($request->city) . '%');
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
            $term = trim($request->search);
            if ($term !== '') {
                $matchingSubjectIds = Subject::where(function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                      ->orWhere('name_ar', 'like', "%{$term}%")
                      ->orWhereHas('searchTerms', function ($sq) use ($term) {
                          $sq->where('term', 'like', "%{$term}%");
                      });
                })->pluck('id');

                $query->where(function ($q) use ($term, $matchingSubjectIds) {
                    $q->where('users.name', 'like', "%{$term}%");
                    if ($matchingSubjectIds->isNotEmpty()) {
                        $q->orWhereHas('tutorProfile.subjects', function ($sq) use ($matchingSubjectIds) {
                            $sq->whereIn('subjects.id', $matchingSubjectIds);
                        });
                    }
                    $q->orWhereHas('tutorProfile', function ($sq) use ($term) {
                        $sq->where('bio', 'like', "%{$term}%")
                           ->orWhere('country', 'like', "%{$term}%")
                           ->orWhere('city', 'like', "%{$term}%");
                    });
                });

                $query->orderByRaw(
                    "CASE WHEN users.name LIKE ? THEN 0 ELSE 1 END",
                    ["%{$term}%"]
                );
            }
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
        $levels = \App\Models\Level::orderBy('display_order')->get();

        $suggestedSubjects = collect();
        if ($tutors->isEmpty() && $request->subject) {
            $term = trim($request->subject);
            if ($term !== '') {
                $suggestedSubjects = Subject::where('name', 'like', "%{$term}%")
                    ->orWhere('name_ar', 'like', "%{$term}%")
                    ->orWhereHas('searchTerms', fn($q) => $q->where('term', 'like', "%{$term}%"))
                    ->take(10)
                    ->get();
            }
        }

        return view('tutor.index', compact('tutors', 'levels', 'suggestedSubjects'));
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

        // Load subject-level groupings for display
        $subjectLevels = \Illuminate\Support\Facades\DB::table('tutor_subjects')
            ->where('tutor_profile_id', $tutor->tutorProfile->id)
            ->whereNotNull('level_id')
            ->join('levels', 'tutor_subjects.level_id', '=', 'levels.id')
            ->join('subjects', 'tutor_subjects.subject_id', '=', 'subjects.id')
            ->select('subjects.name as subject_name', 'subjects.name_ar as subject_name_ar', 'levels.name as level_name', 'levels.name_ar as level_name_ar')
            ->get()
            ->groupBy(function ($item) {
                $locale = app()->getLocale();
                return $locale == 'ar' && $item->subject_name_ar ? $item->subject_name_ar : $item->subject_name;
            })
            ->map(function ($items) {
                $locale = app()->getLocale();
                return $items->pluck($locale == 'ar' ? 'level_name_ar' : 'level_name');
            });

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

        return view('tutor.show', compact('tutor', 'reviews', 'similarTutors', 'subjectLevels'));
    }
}
