@extends('layouts.main')
@section('title', __('messages.verification') . ' - OstazON')
@section('content')
<style>
    .verif-container { max-width: 800px; margin: 0 auto; padding: 40px 24px; }
    .verif-card { background: white; border-radius: 20px; padding: 32px; box-shadow: var(--shadow); margin-bottom: 24px; }
    .verif-card h2 { font-size: 20px; font-weight: 700; margin-bottom: 16px; }
    .upload-area { border: 2px dashed #D1D5DB; border-radius: 12px; padding: 32px; text-align: center; cursor: pointer; }
    .upload-area p { color: var(--text-light); }
    .status-badge { display: inline-block; padding: 6px 16px; border-radius: 50px; font-weight: 600; font-size: 14px; }
    .status-pending { background: #FEF3C7; color: #D97706; }
    .status-verified { background: #D4EDDA; color: #155724; }
    .status-rejected { background: #F8D7DA; color: #721C24; }
</style>
<div class="verif-container">
    <div class="verif-card">
        <h2>{{ app()->getLocale() == 'ar' ? 'حالة التحقق' : 'Verification Status' }}</h2>
        @php $status = auth()->user()->tutorProfile->verification_status ?? 'pending'; @endphp
        <div>
            <span class="status-badge status-{{ $status }}">{{ ucfirst($status) }}</span>
        </div>
        @if($status === 'verified')
            <p style="color: #155724; margin-top: 12px;">{{ app()->getLocale() == 'ar' ? 'تم التحقق من حسابك بنجاح' : 'Your account has been verified successfully!' }}</p>
        @endif
    </div>

    <div class="verif-card">
        <h2>{{ app()->getLocale() == 'ar' ? 'فيديو تعريفي' : 'Introduction Video' }}</h2>
        <form method="POST" action="{{ route('tutor.verification.video') }}" enctype="multipart/form-data">
            @csrf
            <div class="upload-area">
                <p>{{ app()->getLocale() == 'ar' ? 'اختر ملف فيديو' : 'Choose a video file' }}</p>
                <input type="file" name="video" accept="video/*" style="margin-top: 12px;">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 16px;">{{ app()->getLocale() == 'ar' ? 'رفع' : 'Upload' }}</button>
        </form>
    </div>

    <div class="verif-card">
        <h2>{{ app()->getLocale() == 'ar' ? 'إثبات الهوية' : 'ID Verification' }}</h2>
        <form method="POST" action="{{ route('tutor.verification.id') }}" enctype="multipart/form-data">
            @csrf
            <div class="upload-area">
                <p>{{ app()->getLocale() == 'ar' ? 'اختر صورة الهوية' : 'Choose ID image' }}</p>
                <input type="file" name="id_file" accept="image/*" style="margin-top: 12px;">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 16px;">{{ app()->getLocale() == 'ar' ? 'رفع' : 'Upload' }}</button>
        </form>
    </div>

    <div class="verif-card">
        <h2>{{ app()->getLocale() == 'ar' ? 'الشهادات' : 'Certificates' }}</h2>
        <form method="POST" action="{{ route('tutor.verification.certificate') }}" enctype="multipart/form-data">
            @csrf
            <div class="upload-area">
                <p>{{ app()->getLocale() == 'ar' ? 'اختر ملف الشهادة' : 'Choose certificate file' }}</p>
                <input type="file" name="certificate" accept="image/*,application/pdf" style="margin-top: 12px;">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 16px;">{{ app()->getLocale() == 'ar' ? 'رفع' : 'Upload' }}</button>
        </form>
    </div>
</div>
@endsection