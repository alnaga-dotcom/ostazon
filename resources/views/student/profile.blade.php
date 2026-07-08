@extends('layouts.main')
@section('title', __('messages.profile') . ' - OstazON')
@section('content')
<style>
    .profile-container { max-width: 600px; margin: 0 auto; padding: 40px 24px; }
    .profile-card { background: white; border-radius: 20px; padding: 32px; box-shadow: var(--shadow); }
    .profile-card h1 { font-size: 24px; font-weight: 800; margin-bottom: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: #14532D; }
    .form-group input { width: 100%; padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; }
</style>
<div class="profile-container">
    <div class="profile-card">
        <h1>{{ app()->getLocale() == 'ar' ? 'الملف الشخصي' : 'My Profile' }}</h1>
        <form method="POST" action="{{ route('student.profile') }}">
            @csrf
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'الاسم' : 'Name' }}</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}">
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone' }}</label>
                <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">{{ app()->getLocale() == 'ar' ? 'حفظ' : 'Save' }}</button>
        </form>
    </div>
</div>
@endsection