@extends('layouts.main')

@section('title', $tutor->name . ' - Tutor Profile - OstazON')

@section('content')
<style>
.profile-header { background: linear-gradient(135deg, #166534, #15803d); color: white; padding: 60px 0; }    .profile-header .container { display: flex; align-items: center; gap: 32px; }
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
<div class="profile-info" style="color: white;">
    <h1 style="color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.5); font-size: 32px; font-weight: 800; margin-bottom: 8px;">{{ $tutor->name }}</h1>
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
        {{ $subject->localized_name }}
    </span>
@endforeach
              </div>
            </div>

            <div class="profile-section">
                <h2>About</h2>
                <p style="color: var(--text-light); line-height: 1.8;">{{ $tutor->tutorProfile->bio ?? 'This tutor has not added a bio yet.' }}</p>
            </div>

            <div class="reviews-section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 style="font-size: 24px; font-weight: 800; margin: 0;">
                        {{ app()->getLocale() == 'ar' ? 'التقييمات' : 'Reviews' }}
                    </h2>
                    @if($tutor->tutorProfile->average_rating > 0)
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 28px; font-weight: 800; color: #f59e0b;">{{ number_format($tutor->tutorProfile->average_rating, 1) }}</span>
                            <span style="color: #f59e0b; font-size: 20px;">★★★★★</span>
                            <span style="color: #6b7280; font-size: 14px;">({{ $reviews->count() }})</span>
                        </div>
                    @endif
                </div>

                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                        <div class="review-card" style="background: white; border-radius: 16px; padding: 20px; box-shadow: var(--shadow); margin-bottom: 16px;">
                            <div class="review-header" style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #166534; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px;">
                                        {{ strtoupper(substr($review->student->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong style="font-size: 15px;">{{ $review->student->name ?? 'Anonymous' }}</strong>
                                        <div style="font-size: 12px; color: #6b7280;">{{ $review->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span style="font-size: 18px; color: {{ $i <= $review->rating ? '#f59e0b' : '#d1d5db' }};">★</span>
                                    @endfor
                                </div>
                            </div>
                            
                            @if($review->comment)
                                <p style="color: #374151; font-size: 14px; line-height: 1.6; margin-bottom: 12px;">{{ $review->comment }}</p>
                            @endif

                            <!-- Verified Booking Badge -->
                            @if($review->is_verified_booking)
                                <div style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; background: #dcfce7; color: #166534; border-radius: 50px; font-size: 12px; font-weight: 600; margin-bottom: 12px;">
                                    ✅ {{ app()->getLocale() == 'ar' ? 'حجز موثق' : 'Verified Booking' }}
                                </div>
                            @endif

                            <!-- Tutor Reply -->
                            @if($review->tutor_reply)
                                <div style="margin-top: 12px; padding: 12px; background: #f9fafb; border-radius: 10px; border-right: 3px solid #166534;">
                                    <div style="font-size: 12px; font-weight: 700; color: #166534; margin-bottom: 4px;">
                                        {{ app()->getLocale() == 'ar' ? 'رد المعلم' : 'Tutor Response' }}
                                    </div>
                                    <p style="color: #4b5563; font-size: 13px; margin: 0;">{{ $review->tutor_reply }}</p>
                                </div>
                            @endif

                            <!-- Helpful Count -->
                            <div style="margin-top: 12px; display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 12px; color: #6b7280;">
                                    {{ $review->helpful_count }} {{ app()->getLocale() == 'ar' ? 'وجدو هذا مفيداً' : 'found this helpful' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 40px; background: white; border-radius: 16px; box-shadow: var(--shadow);">
                        <div style="font-size: 48px; margin-bottom: 16px;">⭐</div>
                        <h3 style="font-size: 16px; font-weight: 700; color: #14532d; margin-bottom: 8px;">
                            {{ app()->getLocale() == 'ar' ? 'لا توجد تقييمات بعد' : 'No reviews yet' }}
                        </h3>
                        <p style="color: #6b7280; font-size: 14px;">
                            {{ app()->getLocale() == 'ar' ? 'كن أول من يقيم هذا المعلم' : 'Be the first to review this tutor' }}
                        </p>
                    </div>
                @endif
            </div>
                </div>

        <div class="right-column">
            <div style="display: flex; gap: 12px; margin-bottom: 16px;">
                @auth
                    <a href="{{ route('chat.conversation', $tutor->id) }}"
                       style="flex: 1; text-align: center; padding: 12px; background: #166534; color: white; border-radius: 12px; font-weight: 700; font-size: 14px; text-decoration: none;">
                        💬 {{ app()->getLocale() == 'ar' ? 'راسلني' : 'Message' }}
                    </a>
                    @if(auth()->user()->isStudent())
                        <button onclick="revealContact({{ $tutor->id }})"
                                style="flex: 1; text-align: center; padding: 12px; background: #D97706; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer;">
                            👁 {{ app()->getLocale() == 'ar' ? 'عرض جهة الاتصال' : 'Reveal Contact' }}
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       style="flex: 1; text-align: center; padding: 12px; background: #166534; color: white; border-radius: 12px; font-weight: 700; font-size: 14px; text-decoration: none;">
                        💬 {{ app()->getLocale() == 'ar' ? 'سجل الدخول للتواصل' : 'Login to Contact' }}
                    </a>
                @endauth
            </div>

            <div id="contact-info" style="display: none; background: #ECFDF0; border-radius: 12px; padding: 16px; margin-bottom: 16px; border: 2px solid #A7F3D0;">
                <h4 style="font-size: 14px; font-weight: 700; color: #166534; margin-bottom: 8px;">
                    {{ app()->getLocale() == 'ar' ? 'معلومات الاتصال' : 'Contact Info' }}
                </h4>
                <p style="font-size: 14px; color: #14532D; margin: 4px 0;">📧 <span id="revealed-email"></span></p>
                <p style="font-size: 14px; color: #14532D; margin: 4px 0;">📱 <span id="revealed-phone"></span></p>
            </div>

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
        {{ $subject->localized_name }}
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
        {{ $similar->tutorProfile->subjects->first()->localized_name ?? $similar->tutorProfile->subjects->first()->name }}
    @endif
</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
<script>
    function revealContact(tutorId) {
        var btn = event.target;
        btn.disabled = true;
        btn.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري الكشف...' : 'Revealing...' }}';

        fetch('{{ route("student.coins.reveal") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ tutor_id: tutorId })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                document.getElementById('revealed-email').textContent = data.email;
                document.getElementById('revealed-phone').textContent = data.phone;
                document.getElementById('contact-info').style.display = 'block';
                btn.textContent = '{{ app()->getLocale() == 'ar' ? 'تم الكشف' : 'Revealed' }} ✓';
                btn.style.background = '#10B981';
            } else {
                alert(data.message || '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}');
                btn.disabled = false;
                btn.textContent = '👁 {{ app()->getLocale() == 'ar' ? 'عرض جهة الاتصال' : 'Reveal Contact' }}';
            }
        })
        .catch(function() {
            alert('{{ app()->getLocale() == 'ar' ? 'حدث خطأ في الاتصال' : 'Network error' }}');
            btn.disabled = false;
            btn.textContent = '👁 {{ app()->getLocale() == 'ar' ? 'عرض جهة الاتصال' : 'Reveal Contact' }}';
        });
    }
</script>
@endsection
