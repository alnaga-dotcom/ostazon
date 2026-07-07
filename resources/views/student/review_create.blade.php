@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'تقييم المعلم' : 'Rate Your Tutor')

@section('content')
<style>
    .review-container { max-width: 600px; margin: 40px auto; padding: 0 24px; }
    .review-card { background: white; border-radius: 20px; padding: 32px; box-shadow: var(--shadow); }
    .review-card h1 { font-size: 24px; font-weight: 800; margin-bottom: 8px; color: #14532d; }
    .review-card p { color: var(--text-light); margin-bottom: 24px; }
    .tutor-info { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding: 16px; background: #f0fdf4; border-radius: 12px; }
    .tutor-avatar { width: 56px; height: 56px; border-radius: 50%; background: #166534; color: white; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 700; }
    .tutor-name { font-weight: 700; font-size: 16px; }
    .tutor-subject { font-size: 14px; color: #6b7280; }
    .star-rating { display: flex; gap: 8px; margin-bottom: 20px; justify-content: center; }
    .star-rating input { display: none; }
    .star-rating label { font-size: 40px; color: #d1d5db; cursor: pointer; transition: color 0.2s; }
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label { color: #f59e0b; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-size: 14px; font-weight: 700; color: #14532d; margin-bottom: 8px; }
    .form-group textarea { width: 100%; padding: 14px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 15px; resize: vertical; min-height: 120px; }
    .form-group textarea:focus { outline: none; border-color: #166534; }
    .submit-btn { width: 100%; padding: 14px; background: #166534; color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; }
    .submit-btn:hover { background: #14532d; }
</style>

<div class="review-container">
    <div class="review-card">
        <h1>{{ app()->getLocale() == 'ar' ? 'كيف كانت تجربتك؟' : 'How was your experience?' }}</h1>
        <p>{{ app()->getLocale() == 'ar' ? 'ساعد الطلاب الآخرين بمشاركة رأيك' : 'Help other students by sharing your feedback' }}</p>

        <div class="tutor-info">
            <div class="tutor-avatar">{{ strtoupper(substr($booking->tutor->name, 0, 1)) }}</div>
            <div>
                <div class="tutor-name">{{ $booking->tutor->name }}</div>
                <div class="tutor-subject">{{ $booking->subject->name ?? 'General' }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('student.reviews.store') }}">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
            <input type="hidden" name="tutor_id" value="{{ $booking->tutor_id }}">

            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'التقييم' : 'Your Rating' }}</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" required><label for="star5">★</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                </div>
            </div>

            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'تعليقك (اختياري)' : 'Your Comment (Optional)' }}</label>
                <textarea name="comment" placeholder="{{ app()->getLocale() == 'ar' ? 'شارك تجربتك مع هذا المعلم...' : 'Share your experience with this tutor...' }}"></textarea>
            </div>

            <button type="submit" class="submit-btn">
                {{ app()->getLocale() == 'ar' ? 'إرسال التقييم' : 'Submit Review' }}
            </button>
        </form>
    </div>
</div>
@endsection