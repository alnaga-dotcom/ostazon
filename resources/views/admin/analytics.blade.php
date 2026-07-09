@extends('layouts.main')

@section('title', 'Analytics - Admin - OstazON')

@section('content')
<style>
    .a-container { max-width: 1400px; margin: 0 auto; padding: 40px 24px; }
    .a-card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .a-card h3 { font-size: 14px; color: #6b7280; margin-bottom: 8px; }
    .a-card .val { font-size: 28px; font-weight: 800; color: #166534; }
    .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px; }
    @media (max-width: 768px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .stat-grid { grid-template-columns: 1fr; } }
    .bar-chart { display: flex; align-items: end; gap: 8px; height: 120px; padding-top: 8px; }
    .bar { flex: 1; background: #166534; border-radius: 6px 6px 0 0; min-width: 28px; position: relative; transition: height 0.5s; }
    .bar-label { position: absolute; bottom: -22px; left: 50%; transform: translateX(-50%); font-size: 11px; color: #6b7280; white-space: nowrap; }
    .bar-val { position: absolute; top: -20px; left: 50%; transform: translateX(-50%); font-size: 12px; font-weight: 700; color: #166534; }
</style>

<div class="a-container">
    <h1 style="font-size: 32px; font-weight: 800; margin-bottom: 32px;">Analytics</h1>

    <div class="stat-grid">
        <div class="a-card"><h3>Total Users</h3><div class="val">{{ $totalUsers }}</div></div>
        <div class="a-card"><h3>Active Tutors</h3><div class="val">{{ $activeTutors }} <span style="font-size:14px;color:#6b7280;">/ {{ $totalTutors }}</span></div></div>
        <div class="a-card"><h3>Active Students</h3><div class="val">{{ $activeStudents }} <span style="font-size:14px;color:#6b7280;">/ {{ $totalStudents }}</span></div></div>
        <div class="a-card"><h3>Avg Rating</h3><div class="val">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</div></div>
        <div class="a-card"><h3>Total Bookings</h3><div class="val">{{ $totalBookings }}</div></div>
        <div class="a-card"><h3>Completed</h3><div class="val">{{ $completedBookings }}</div></div>
        <div class="a-card"><h3>Cancelled</h3><div class="val">{{ $cancelledBookings }}</div></div>
        <div class="a-card"><h3>Total Reviews</h3><div class="val">{{ $totalReviews }}</div></div>
        <div class="a-card"><h3>Verified Tutors</h3><div class="val">{{ $verifiedTutors }}</div></div>
        <div class="a-card"><h3>Pending Verifications</h3><div class="val">{{ $pendingVerifications }}</div></div>
        <div class="a-card"><h3>Revenue (EGP)</h3><div class="val">{{ number_format($totalRevenue, 0) }}</div></div>
        <div class="a-card"><h3>Pending Withdrawals</h3><div class="val">{{ $pendingWithdrawals }}</div></div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
        <div class="a-card">
            <h3 style="font-size:16px;font-weight:700;color:#14532D;margin-bottom:16px;">Monthly Registrations (6mo)</h3>
            <div class="bar-chart">
                @php $maxReg = max($monthlyRegistrations->max(), 1); @endphp
                @foreach($monthlyRegistrations as $month => $count)
                    <div class="bar" style="height: {{ ($count / $maxReg) * 100 }}%;">
                        <span class="bar-val">{{ $count }}</span>
                        <span class="bar-label">{{ substr($month, 5) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="a-card">
            <h3 style="font-size:16px;font-weight:700;color:#14532D;margin-bottom:16px;">Top Subjects by Tutor Count</h3>
            <div style="display:flex;flex-direction:column;gap:12px;">
                @php $maxSubj = $topSubjects->max('tutors_count') ?: 1; @endphp
                @foreach($topSubjects as $subject)
                    <div>
                        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:4px;">
                            <span>{{ $subject->name }}</span>
                            <span style="font-weight:700;">{{ $subject->tutors_count }}</span>
                        </div>
                        <div style="background:#e5e7eb;border-radius:8px;height:18px;overflow:hidden;">
                            <div style="background:#166534;height:100%;border-radius:8px;width:{{ ($subject->tutors_count / $maxSubj) * 100 }}%;transition:width 0.5s;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection