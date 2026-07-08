@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'حجوزاتي' : 'My Bookings')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 800; color: #14532D; margin: 0;">
                {{ app()->getLocale() == 'ar' ? 'حجوزاتي' : 'My Bookings' }}
            </h1>
            <p style="color: #4b5563; margin-top: 4px;">
                {{ app()->getLocale() == 'ar' ? 'عرض وإدارة حجوزاتك' : 'View and manage your bookings' }}
            </p>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ECFDF0; border: 2px solid #10B981; color: #14532D; padding: 16px 24px; border-radius: 12px; margin-bottom: 24px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #FEF2F2; border: 2px solid #FCA5A5; color: #991B1B; padding: 16px 24px; border-radius: 12px; margin-bottom: 24px; font-weight: 500;">
            {{ session('error') }}
        </div>
    @endif

    @if($bookings->count() > 0)
        <div style="display: grid; gap: 16px;">
            @foreach($bookings as $booking)
                <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px;">
                    <div style="flex: 2; min-width: 200px;">
                        <div style="font-weight: 700; color: #14532D; font-size: 16px;">
                            {{ $booking->tutor->name ?? 'Tutor' }} — {{ $booking->subject->localized_name ?? $booking->subject->name ?? 'N/A' }}
                        </div>
                        <div style="font-size: 13px; color: #4b5563; margin-top: 4px; display: flex; gap: 16px; flex-wrap: wrap;">
                            <span>{{ $booking->scheduled_at->format('M d, Y H:i') }}</span>
                            <span>{{ $booking->lesson_mode == 'online' ? __('messages.online') : __('messages.in_person') }}</span>
                            <span>{{ $booking->lesson_fee }} {{ app()->getLocale() == 'ar' ? 'عملة' : 'coins' }}</span>
                        </div>
                    </div>
                    <div style="flex: 1; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; 
                            {{ $booking->lesson_status == 'completed' ? 'background: #D1FAE5; color: #065F46;' : '' }}
                            {{ $booking->lesson_status == 'confirmed' ? 'background: #DBEAFE; color: #1E40AF;' : '' }}
                            {{ $booking->lesson_status == 'scheduled' ? 'background: #FEF3C7; color: #92400E;' : '' }}
                            {{ $booking->lesson_status == 'cancelled' ? 'background: #FEE2E2; color: #991B1B;' : '' }}">
                            {{ ucfirst($booking->lesson_status) }}
                        </span>
                        @if($booking->lesson_status == 'completed' && $booking->canDispute())
                            <a href="{{ route('bookings.arbitration', $booking) }}" style="padding: 6px 14px; background: #DC2626; color: white; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none;">
                                {{ app()->getLocale() == 'ar' ? 'نزاع' : 'Dispute' }}
                            </a>
                        @endif
                        @if($booking->arbitration_status && $booking->arbitration_status != 'none')
                            <a href="{{ route('bookings.arbitration', $booking) }}" style="padding: 6px 14px; background: #F59E0B; color: white; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none;">
                                {{ app()->getLocale() == 'ar' ? 'التحكيم' : 'Arbitration' }}
                            </a>
                        @endif
                        @if($booking->lesson_status == 'completed' && !$booking->review)
                            <a href="{{ route('student.reviews.create', $booking) }}" style="padding: 6px 14px; background: #166534; color: white; border-radius: 8px; font-size: 12px; font-weight: 700; text-decoration: none;">
                                {{ app()->getLocale() == 'ar' ? 'تقييم' : 'Review' }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div style="margin-top: 24px;">
            {{ $bookings->links() }}
        </div>
    @else
        <div style="background: white; border-radius: 16px; padding: 64px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="font-size: 48px; margin-bottom: 16px;">📚</div>
            <h3 style="font-size: 18px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                {{ app()->getLocale() == 'ar' ? 'لا توجد حجوزات' : 'No bookings yet' }}
            </h3>
            <p style="color: #4b5563; margin-bottom: 20px;">
                {{ app()->getLocale() == 'ar' ? 'ابحث عن معلم وابدأ رحلة التعلم' : 'Find a tutor and start your learning journey' }}
            </p>
            <a href="{{ route('tutors.index') }}" style="display: inline-block; background: #D97706; color: white; padding: 12px 28px; border-radius: 12px; font-weight: 700; text-decoration: none;">
                {{ app()->getLocale() == 'ar' ? 'ابحث عن معلم' : 'Find a Tutor' }}
            </a>
        </div>
    @endif
</div>
@endsection
