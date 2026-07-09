@extends('layouts.main')
@section('title', __('messages.earnings') . ' - OstazON')
@section('content')
<style>
    .earnings-container { max-width: 900px; margin: 0 auto; padding: 40px 24px; }
    .earnings-header { margin-bottom: 32px; }
    .earnings-header h1 { font-size: 28px; font-weight: 800; }
    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px; }
    .stat-card { background: white; border-radius: 16px; padding: 24px; box-shadow: var(--shadow); }
    .stat-card h3 { font-size: 14px; color: var(--text-light); margin-bottom: 8px; }
    .stat-card .value { font-size: 28px; font-weight: 800; color: var(--primary); }
    .section-card { background: white; border-radius: 20px; padding: 28px; box-shadow: var(--shadow); }
    .section-card h2 { font-size: 20px; font-weight: 700; margin-bottom: 20px; }
</style>
<div class="earnings-container">
    <div class="earnings-header">
        <h1>{{ app()->getLocale() == 'ar' ? 'الأرباح' : 'Earnings' }}</h1>
    </div>
    <div class="stats-grid">
        <div class="stat-card">
            <h3>{{ app()->getLocale() == 'ar' ? 'الرصيد المتاح' : 'Available Balance' }}</h3>
            <div class="value">{{ number_format(auth()->user()->tutorProfile->available_balance ?? 0, 0) }} EGP</div>
        </div>
        <div class="stat-card">
            <h3>{{ app()->getLocale() == 'ar' ? 'إجمالي الأرباح' : 'Total Earnings' }}</h3>
            <div class="value">{{ number_format(auth()->user()->tutorProfile->total_earnings ?? 0, 0) }} EGP</div>
        </div>
        <div class="stat-card">
            <h3>{{ app()->getLocale() == 'ar' ? 'إجمالي الحصص' : 'Total Lessons' }}</h3>
            <div class="value">{{ auth()->user()->tutorProfile->total_lessons ?? 0 }}</div>
        </div>
    </div>
    <div class="section-card">
        <h2>{{ app()->getLocale() == 'ar' ? 'سجل الأرباح' : 'Earnings History' }}</h2>
        <p style="color: var(--text-light);">{{ app()->getLocale() == 'ar' ? 'سيتم عرض سجل الأرباح قريباً' : 'Earnings history coming soon.' }}</p>
    </div>
</div>
@endsection