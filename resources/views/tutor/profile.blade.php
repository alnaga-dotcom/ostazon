@extends('layouts.main')
@section('title', __('messages.edit_profile') . ' - OstazON')
@section('content')
<style>
    .profile-container { max-width: 800px; margin: 0 auto; padding: 40px 24px; }
    .profile-card { background: white; border-radius: 20px; padding: 32px; box-shadow: var(--shadow); }
    .profile-card h1 { font-size: 24px; font-weight: 800; margin-bottom: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: #14532D; }
    .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; }
    .form-group textarea { resize: vertical; min-height: 100px; }
    .service-types { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 8px; }
    .service-types label { display: flex; align-items: center; gap: 8px; font-weight: 400; cursor: pointer; }
    .btn-save { background: #166534; color: white; padding: 14px 32px; border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; }
</style>
<div class="profile-container">
    <div class="profile-card">
        <h1>{{ app()->getLocale() == 'ar' ? 'تعديل الملف الشخصي' : 'Edit Profile' }}</h1>
        <form method="POST" action="{{ route('tutor.profile') }}">
            @csrf
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'السيرة الذاتية' : 'Bio' }}</label>
                <textarea name="bio" rows="4">{{ auth()->user()->tutorProfile->bio ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'سعر الساعة (جنيه)' : 'Hourly Rate (EGP)' }}</label>
                <input type="number" name="hourly_rate" value="{{ auth()->user()->tutorProfile->hourly_rate ?? 0 }}">
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'الدولة' : 'Country' }}</label>
                <input type="text" name="country" value="{{ auth()->user()->tutorProfile->country ?? '' }}">
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone' }}</label>
                <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}">
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'خدماتي' : 'Service Types' }}</label>
                <div class="service-types">
                    @php $st = auth()->user()->tutorProfile->service_types ?? []; @endphp
                    <label><input type="checkbox" name="service_types[]" value="online" {{ in_array('online', $st) ? 'checked' : '' }}> {{ __('messages.online') }}</label>
                    <label><input type="checkbox" name="service_types[]" value="in_person" {{ in_array('in_person', $st) ? 'checked' : '' }}> {{ __('messages.in_person') }}</label>
                    <label><input type="checkbox" name="service_types[]" value="assignment" {{ in_array('assignment', $st) ? 'checked' : '' }}> {{ __('messages.assignment') }}</label>
                    <label><input type="checkbox" name="service_types[]" value="exam_help" {{ in_array('exam_help', $st) ? 'checked' : '' }}> {{ __('messages.exam_help') }}</label>
                    <label><input type="checkbox" name="service_types[]" value="project_help" {{ in_array('project_help', $st) ? 'checked' : '' }}> {{ __('messages.project_help') }}</label>
                </div>
            </div>
            <button type="submit" class="btn-save">{{ app()->getLocale() == 'ar' ? 'حفظ' : 'Save' }}</button>
        </form>
    </div>
</div>
@endsection