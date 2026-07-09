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
                <input type="number" name="hourly_rate" value="{{ number_format(auth()->user()->tutorProfile->hourly_rate ?? 0, 0) }}">
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'المدينة' : 'City' }}</label>
                <input type="text" name="city" value="{{ auth()->user()->tutorProfile->city ?? '' }}">
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

        <hr style="margin: 32px 0; border: none; border-top: 1px solid #E5E7EB;">

        <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">{{ app()->getLocale() == 'ar' ? 'المواد الدراسية' : 'My Subjects' }}</h2>
        <form method="POST" action="{{ route('tutor.subjects') }}">
            @csrf
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'اختر المواد (اضغط Ctrl لاختيار متعدد)' : 'Select subjects (hold Ctrl for multiple)' }}</label>
                <select name="subjects[]" multiple style="width: 100%; padding: 10px 14px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; min-height: 160px; background: white;">
                    @php $tutorSubjectIds = auth()->user()->tutorProfile->subjects->pluck('id')->toArray(); @endphp
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ in_array($subject->id, $tutorSubjectIds) ? 'selected' : '' }}>{{ $subject->localized_name ?? $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'المستوى الدراسي (اختر واحد أو أكثر)' : 'Education Level (select one or more)' }}</label>
                <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 8px;">
                    @php $tutorLevelIds = auth()->user()->tutorProfile->levels->pluck('id')->toArray(); @endphp
                    @foreach($levels as $level)
                        <label style="display: flex; align-items: center; gap: 6px; padding: 8px 14px; border: 2px solid #E5E7EB; border-radius: 10px; cursor: pointer; font-size: 14px; {{ in_array($level->id, $tutorLevelIds) ? 'background:#dcfce7;border-color:#166534;' : '' }}">
                            <input type="checkbox" name="levels[]" value="{{ $level->id }}" {{ in_array($level->id, $tutorLevelIds) ? 'checked' : '' }}>
                            {{ $level->localized_name }}
                        </label>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn-save" style="background: #6B7280;">{{ app()->getLocale() == 'ar' ? 'حفظ المواد' : 'Save Subjects' }}</button>
        </form>

        <hr style="margin: 32px 0; border: none; border-top: 1px solid #E5E7EB;">

        <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">{{ app()->getLocale() == 'ar' ? 'طلب مادة جديدة' : 'Request a New Subject' }}</h2>
        <p style="color: var(--text-light); font-size: 14px; margin-bottom: 16px;">
            {{ app()->getLocale() == 'ar' ? 'إذا كنت تدرس مادة غير موجودة في القائمة أعلاه، يمكنك طلب إضافتها' : "If you teach a subject not listed above, request it and we'll add it." }}
        </p>
        <form method="POST" action="{{ route('subject.request') }}">
            @csrf
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'اسم المادة' : 'Subject Name' }}</label>
                <input type="text" name="subject_name" required placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: فلسفة، منطق، أخلاق (افصل بفاصلة)' : 'e.g. Philosophy, Logic, Ethics (separate with comma)' }}">
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'ملاحظات (اختياري)' : 'Notes (optional)' }}</label>
                <textarea name="message" rows="2" placeholder="{{ app()->getLocale() == 'ar' ? 'أي تفاصيل إضافية' : 'Any additional details' }}"></textarea>
            </div>
            <button type="submit" class="btn-save" style="background: #D97706;">{{ app()->getLocale() == 'ar' ? 'إرسال الطلب' : 'Submit Request' }}</button>
        </form>
    </div>
</div>
@endsection