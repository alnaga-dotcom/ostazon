@extends('layouts.main')

@section('title', 'Analytics - Admin - OstazON')

@section('content')
<div class="admin-container" style="max-width: 1400px; margin: 0 auto; padding: 40px 24px;">
    <h1 style="font-size: 32px; font-weight: 800; margin-bottom: 32px;">📊 Analytics</h1>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 32px;">
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">Total Tutors</div>
            <div style="font-size: 32px; font-weight: 800; color: #166534;">{{ \App\Models\User::where('role', 'tutor')->count() }}</div>
        </div>
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">Total Students</div>
            <div style="font-size: 32px; font-weight: 800; color: #166534;">{{ \App\Models\User::where('role', 'student')->count() }}</div>
        </div>
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">Pending Verifications</div>
            <div style="font-size: 32px; font-weight: 800; color: #d97706;">{{ \App\Models\TutorProfile::where('verification_status', 'pending')->count() }}</div>
        </div>
        <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">Total Reviews</div>
            <div style="font-size: 32px; font-weight: 800; color: #166534;">{{ \App\Models\Review::count() }}</div>
        </div>
    </div>
</div>
@endsection