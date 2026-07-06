@extends('layouts.main')

@section('title', 'Tutor Dashboard - OstazON')

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
    .status-badge { padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; }
    .status-scheduled { background: var(--primary-light); color: var(--primary); }
    .status-confirmed { background: #d4edda; color: #155724; }
    .status-completed { background: #e0e7ff; color: var(--primary); }
    .empty-state { text-align: center; padding: 40px; color: var(--text-light); }
    .action-buttons { display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; }
    .verification-alert { background: var(--secondary-light); border: 2px solid var(--secondary); border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; }
    .verification-alert p { color: var(--secondary); font-weight: 600; }
</style>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Welcome, {{ auth()->user()->name }}!</h1>
    </div>

    @if(auth()->user()->tutorProfile->verification_status === 'pending')
        <div class="verification-alert">
            <p>⚠️ Your profile is pending verification. Complete your profile to start accepting students.</p>
            <a href="{{ route('tutor.verification') }}" class="btn btn-secondary">Complete Profile</a>
        </div>
    @endif

    <div class="action-buttons">
        <a href="{{ route('tutor.profile') }}" class="btn btn-primary">Edit Profile</a>
        <a href="{{ route('tutor.bookings') }}" class="btn btn-outline">My Bookings</a>
        <a href="{{ route('tutor.earnings') }}" class="btn btn-outline">Earnings</a>
        <a href="{{ route('tutor.withdrawals') }}" class="btn btn-secondary">Withdraw</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Available Balance</h3>
            <div class="value">{{ auth()->user()->tutorProfile->available_balance ?? 0 }} EGP</div>
        </div>
        <div class="stat-card">
            <h3>Total Earnings</h3>
            <div class="value">{{ auth()->user()->tutorProfile->total_earnings ?? 0 }} EGP</div>
        </div>
        <div class="stat-card">
            <h3>Total Lessons</h3>
            <div class="value">{{ auth()->user()->tutorProfile->total_lessons ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h3>Rating</h3>
            <div class="value">⭐ {{ number_format(auth()->user()->reviewsAsTutor->avg('rating') ?? 0, 1) }}</div>
        </div>
    </div>

    <div class="section-card">
        <h2>Upcoming Bookings</h2>
        @if(isset($upcomingBookings) && $upcomingBookings->count() > 0)
            @foreach($upcomingBookings as $booking)
                <div class="booking-item">
                    <div>
                        <h4>{{ $booking->student->name ?? 'Student' }} - {{ $booking->subject->name ?? 'Subject' }}</h4>
                        <p>{{ $booking->scheduled_at->format('M d, Y H:i') }}</p>
                    </div>
                    <span class="status-badge status-{{ $booking->lesson_status }}">{{ ucfirst($booking->lesson_status) }}</span>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <p>No upcoming bookings. Make sure your profile is complete and verified!</p>
            </div>
        @endif
    </div>
</div>
@endsection
