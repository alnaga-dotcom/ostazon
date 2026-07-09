@extends('layouts.main')

@section('title', __('messages.dashboard') . ' - OstazON')

@section('content')
<style>
    .dashboard-container { max-width: 1200px; margin: 0 auto; padding: 40px 24px; }
    .dashboard-header { margin-bottom: 32px; }
    .dashboard-header h1 { font-size: 28px; font-weight: 800; }
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px; }
    .stat-card { background: white; border-radius: 16px; padding: 24px; box-shadow: var(--shadow); }
    .stat-card h3 { font-size: 14px; color: var(--text-light); margin-bottom: 8px; }
    .stat-card .value { font-size: 28px; font-weight: 800; color: var(--primary); }
    .section-card { background: white; border-radius: 20px; padding: 28px; box-shadow: var(--shadow); margin-bottom: 24px; }
    .section-card h2 { font-size: 20px; font-weight: 700; margin-bottom: 20px; }
    .booking-item { display: flex; justify-content: space-between; align-items: center; padding: 16px; border-bottom: 1px solid #f3f4f6; }
    .booking-item:last-child { border-bottom: none; }
    .booking-info h4 { font-size: 15px; font-weight: 600; }
    .booking-info p { font-size: 13px; color: var(--text-light); }
    .status-badge { padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; }
    .status-scheduled { background: var(--primary-light); color: var(--primary); }
    .status-confirmed { background: #d4edda; color: #155724; }
    .status-completed { background: #e0e7ff; color: var(--primary); }
    .status-cancelled { background: #f8d7da; color: #721c24; }
    .empty-state { text-align: center; padding: 40px; color: var(--text-light); }
    .action-buttons { display: flex; gap: 12px; margin-bottom: 24px; }
</style>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>{{ app()->getLocale() == 'ar' ? 'مرحباً بعودتك، ' : 'Welcome back, ' }}{{ auth()->user()->name }}!</h1>
    </div>

    <div class="action-buttons">
        <a href="{{ route('tutors.index') }}" class="btn btn-primary">{{ app()->getLocale() == 'ar' ? 'ابحث عن معلم' : 'Find a Tutor' }}</a>
        <a href="{{ route('student.requests.create') }}" class="btn btn-outline">{{ app()->getLocale() == 'ar' ? 'قدم طلباً' : 'Post a Request' }}</a>
        <a href="{{ route('student.coins.purchase') }}" class="btn btn-secondary">{{ app()->getLocale() == 'ar' ? 'اشترِ عملات' : 'Buy Coins' }}</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>{{ app()->getLocale() == 'ar' ? 'رصيد العملات' : 'Coin Balance' }}</h3>
            <div class="value">{{ auth()->user()->studentProfile->coins_balance ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h3>{{ app()->getLocale() == 'ar' ? 'إجمالي الحصص' : 'Total Lessons' }}</h3>
            <div class="value">{{ auth()->user()->studentProfile->total_lessons ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h3>{{ app()->getLocale() == 'ar' ? 'الحجوزات النشطة' : 'Active Bookings' }}</h3>
            <div class="value">{{ $activeBookings ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h3>{{ app()->getLocale() == 'ar' ? 'إجمالي الإنفاق' : 'Total Spent' }}</h3>
            <div class="value">{{ number_format(auth()->user()->studentProfile->total_spent ?? 0, 0) }} {{ app()->getLocale() == 'ar' ? 'جنيه' : 'EGP' }}</div>
        </div>
    </div>

    <div class="section-card">
        <h2>{{ app()->getLocale() == 'ar' ? 'حجوزاتي' : 'My Bookings' }}</h2>
        @if(isset($bookings) && $bookings->count() > 0)
            @foreach($bookings as $booking)
                <div class="booking-item">
                    <div class="booking-info">
                        <h4>{{ $booking->tutor->name ?? 'Tutor' }} - {{ $booking->subject->localized_name ?? ($booking->subject->name ?? __('messages.subject')) }}</h4>
                        <p>{{ $booking->scheduled_at->format('M d, Y H:i') }} • {{ app()->getLocale() == 'ar' ? ($booking->lesson_mode == 'online' ? 'أونلاين' : 'حضوري') : $booking->lesson_mode }}</p>
                    </div>
                    <span class="status-badge status-{{ $booking->lesson_status }}">{{ $booking->lesson_status }}</span>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <p>{{ app()->getLocale() == 'ar' ? 'لا توجد حجوزات بعد. ' : 'No bookings yet. ' }}<a href="{{ route('tutors.index') }}">{{ app()->getLocale() == 'ar' ? 'ابحث عن معلم' : 'Find a tutor' }}</a>{{ app()->getLocale() == 'ar' ? ' للبدء!' : ' to get started!' }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
