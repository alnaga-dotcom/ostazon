@extends('layouts.main')

@section('title', $tutor->name . ' - Tutor Profile - OstazON')

@section('content')
<style>
    .profile-header { background: linear-gradient(135deg, var(--primary), #7c3aed); color: white; padding: 60px 0; }
    .profile-header .container { display: flex; align-items: center; gap: 32px; }
    .profile-avatar { width: 120px; height: 120px; border-radius: 50%; background: white; color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 48px; font-weight: 700; flex-shrink: 0; }
    .profile-info h1 { font-size: 32px; font-weight: 800; margin-bottom: 8px; }
    .profile-info p { font-size: 16px; opacity: 0.9; margin-bottom: 12px; }
    .profile-meta { display: flex; gap: 16px; }
    .profile-meta span { background: rgba(255,255,255,0.2); padding: 6px 16px; border-radius: 50px; font-size: 14px; }
    .profile-content { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; padding: 40px 0; }
    .profile-section { background: white; border-radius: 20px; padding: 28px; box-shadow: var(--shadow); margin-bottom: 24px; }
    .profile-section h2 { font-size: 20px; font-weight: 700; margin-bottom: 16px; }
    .subjects-list { display: flex; flex-wrap: wrap; gap: 8px; }
    .subject-tag { background: var(--primary-light); color: var(--primary); padding: 6px 14px; border-radius: 50px; font-size: 13px; font-weight: 600; }
    .booking-form { background: white; border-radius: 20px; padding: 28px; box-shadow: var(--shadow); }
    .booking-form h2 { font-size: 20px; font-weight: 700; margin-bottom: 20px; }
    .reviews-section { margin-top: 24px; }
    .review-card { background: white; border-radius: 16px; padding: 20px; box-shadow: var(--shadow); margin-bottom: 16px; }
    .review-header { display: flex; justify-content: space-between; margin-bottom: 8px; }
    .review-rating { color: var(--secondary); }
    .similar-tutors { margin-top: 40px; }
    .similar-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
    .similar-card { background: white; border-radius: 16px; padding: 16px; box-shadow: var(--shadow); text-align: center; }
    .similar-avatar { width: 48px; height: 48px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; margin: 0 auto 8px; }
</style>

<div class="profile-header">
    <div class="container">
        <div class="profile-avatar">{{ strtoupper(substr($tutor->name, 0, 1)) }}</div>
        <div class="profile-info">
            <h1>{{ $tutor->name }}</h1>
            <p>{{ $tutor->tutorProfile->bio ?? 'No bio available.' }}</p>
            <div class="profile-meta">
                <span>⭐ {{ number_format($tutor->reviews_as_tutor_avg_rating ?? 0, 1) }} ({{ $tutor->reviews_as_tutor_count ?? 0 }} reviews)</span>
                <span>{{ $tutor->tutorProfile->total_lessons ?? 0 }} lessons</span>
                <span>{{ ucfirst($tutor->tutorProfile->verification_status ?? 'Verified') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="profile-content">
        <div class="left-column">
            <div class="profile-section">
<h2>{{ app()->getLocale() == 'ar' ? 'المواد' : 'Subjects' }}</h2>                <div class="subjects-list">
  @foreach($tutor->tutorProfile->subjects as $subject)
    <span class="subject-tag">
        {{ app()->getLocale() == 'ar' ? __('messages.' . strtolower($subject->name)) : $subject->name }}
    </span>
@endforeach
              </div>
            </div>

            <div class="profile-section">
                <h2>About</h2>
                <p style="color: var(--text-light); line-height: 1.8;">{{ $tutor->tutorProfile->bio ?? 'This tutor has not added a bio yet.' }}</p>
            </div>

            <div class="reviews-section">
                <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 20px;">Reviews</h2>
                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                        <div class="review-card">
                            <div class="review-header">
                                <strong>{{ $review->student->name ?? 'Anonymous' }}</strong>
                                <span class="review-rating">⭐ {{ $review->rating }}/5</span>
                            </div>
                            <p style="color: var(--text-light); font-size: 14px;">{{ $review->comment ?? 'No comment' }}</p>
                        </div>
                    @endforeach
                @else
                    <p style="color: var(--text-light);">No reviews yet.</p>
                @endif
            </div>
        </div>

        <div class="right-column">
            <div class="booking-form">
                <h2>Book a Lesson</h2>
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="font-size: 32px; font-weight: 800; color: var(--primary);">{{ $tutor->tutorProfile->hourly_rate ?? 0 }} EGP</div>
                    <div style="color: var(--text-light); font-size: 14px;">per hour</div>
                </div>
                @auth
                    @if(auth()->user()->isStudent())
                        <form method="POST" action="{{ route('student.bookings.store') }}">
                            @csrf
                            <input type="hidden" name="tutor_id" value="{{ $tutor->id }}">
                            <div class="form-group">
<label>{{ app()->getLocale() == 'ar' ? 'المادة' : 'Subject' }}</label>                                <select name="subject_id" class="form-control" required>
@foreach($tutor->tutorProfile->subjects as $subject)
    <option value="{{ $subject->id }}">
        {{ app()->getLocale() == 'ar' ? __('messages.' . strtolower($subject->name)) : $subject->name }}
    </option>
@endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Lesson Mode</label>
                                <select name="lesson_mode" class="form-control" required>
                                    <option value="online">Online</option>
                                    <option value="in_person">In-Person</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date & Time</label>
                                <input type="datetime-local" name="scheduled_at" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Duration (minutes)</label>
                                <select name="duration_minutes" class="form-control">
                                    <option value="30">30 min</option>
                                    <option value="60" selected>60 min</option>
                                    <option value="90">90 min</option>
                                    <option value="120">120 min</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Lesson Fee (EGP)</label>
                                <input type="number" name="lesson_fee" class="form-control" value="{{ $tutor->tutorProfile->hourly_rate ?? 0 }}" required>
                            </div>
                            <div class="form-group">
                                <label>Platform Guarantee</label>
                                <select name="platform_guarantee" class="form-control">
                                    <option value="yes">Yes - Secure payment with dispute protection</option>
                                    <option value="no">No - Pay tutor directly</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Notes</label>
                                <textarea name="student_notes" class="form-control" rows="3" placeholder="Any specific topics or requirements..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Book Now</button>
                        </form>
                    @else
                        <p style="text-align: center; color: var(--text-light);">Only students can book lessons.</p>
                    @endif
                @else
                    <p style="text-align: center; color: var(--text-light);">Please <a href="{{ route('login') }}">login</a> to book a lesson.</p>
                @endauth
            </div>
        </div>
    </div>

    @if($similarTutors->count() > 0)
        <div class="similar-tutors">
            <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 20px;">Similar Tutors</h2>
            <div class="similar-grid">
                @foreach($similarTutors as $similar)
                    <a href="{{ route('tutors.show', $similar->id) }}" class="similar-card" style="text-decoration: none; color: inherit;">
                        <div class="similar-avatar">{{ strtoupper(substr($similar->name, 0, 1)) }}</div>
                        <h4 style="font-size: 14px; font-weight: 600;">{{ $similar->name }}</h4>
<p style="font-size: 12px; color: var(--text-light);">
    @if($similar->tutorProfile->subjects->first())
        {{ app()->getLocale() == 'ar' ? __('messages.' . strtolower($similar->tutorProfile->subjects->first()->name)) : $similar->tutorProfile->subjects->first()->name }}
    @endif
</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
