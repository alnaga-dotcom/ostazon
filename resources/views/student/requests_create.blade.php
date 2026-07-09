@extends('layouts.main')
@section('title', __('messages.new_request') . ' - OstazON')
@section('content')
<style>
    .req-container { max-width: 600px; margin: 0 auto; padding: 40px 24px; }
    .req-card { background: white; border-radius: 20px; padding: 32px; box-shadow: var(--shadow); }
    .req-card h1 { font-size: 24px; font-weight: 800; margin-bottom: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: #14532D; }
    .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; transition: border-color .2s; }
    .form-group input:focus, .form-group textarea:focus, .form-group select:focus { border-color: var(--primary); outline: none; }
    .form-group textarea { resize: vertical; min-height: 120px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-hint { font-size: 13px; color: var(--text-light); margin-top: 4px; }
    .req-card .btn { width: 100%; padding: 14px; font-size: 16px; }
</style>
<div class="req-container">
    <div class="req-card">
        <h1>{{ app()->getLocale() == 'ar' ? 'طلب تدريس جديد' : 'New Tutoring Request' }}</h1>
        @if(session('error'))
            <div style="background:#F8D7DA;color:#721C24;padding:12px 16px;border-radius:12px;margin-bottom:16px;">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('student.requests.store') }}">
            @csrf
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'المادة' : 'Subject' }}</label>
                <select name="subject_id" required>
                    <option value="">{{ app()->getLocale() == 'ar' ? 'اختر المادة' : 'Select a subject' }}</option>
                    @foreach(\App\Models\Subject::all() as $subject)
                        <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>{{ $subject->localized_name }}</option>
                    @endforeach
                </select>
                @error('subject_id') <div class="form-hint" style="color:#DC2626;">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'عنوان الطلب' : 'Request Title' }}</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: أحتاج مساعدة في التفاضل والتكامل' : 'e.g. Need help with Calculus' }}">
                @error('title') <div class="form-hint" style="color:#DC2626;">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'وصف تفصيلي' : 'Detailed Description' }}</label>
                <textarea name="description" placeholder="{{ app()->getLocale() == 'ar' ? 'اشرح ما تحتاج مساعدة فيه، المستوى الدراسي، المواضيع المطلوبة...' : 'Explain what you need help with, your academic level, specific topics...' }}">{{ old('description') }}</textarea>
                @error('description') <div class="form-hint" style="color:#DC2626;">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>{{ app()->getLocale() == 'ar' ? 'الميزانية (جنيه)' : 'Budget (EGP)' }}</label>
                    <input type="number" name="budget_egp" value="{{ old('budget_egp') }}" step="1" min="0" placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: 200' : 'e.g. 200' }}">
                    @error('budget_egp') <div class="form-hint" style="color:#DC2626;">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>{{ app()->getLocale() == 'ar' ? 'طريقة التدريس' : 'Lesson Mode' }}</label>
                    <select name="lesson_mode">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'أي طريقة' : 'Any' }}</option>
                        <option value="online" @selected(old('lesson_mode') == 'online')>{{ app()->getLocale() == 'ar' ? 'أونلاين' : 'Online' }}</option>
                        <option value="in_person" @selected(old('lesson_mode') == 'in_person')>{{ app()->getLocale() == 'ar' ? 'حضوري' : 'In Person' }}</option>

                    </select>
                    @error('lesson_mode') <div class="form-hint" style="color:#DC2626;">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group">
                <label>{{ app()->getLocale() == 'ar' ? 'الجدول الزمني المفضل' : 'Preferred Schedule' }}</label>
                <input type="text" name="preferred_schedule" value="{{ old('preferred_schedule') }}" placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: أيام السبت والأربعاء مساءً' : 'e.g. Saturdays and Wednesdays evenings' }}">
                @error('preferred_schedule') <div class="form-hint" style="color:#DC2626;">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ app()->getLocale() == 'ar' ? 'نشر الطلب' : 'Post Request' }}</button>
        </form>
    </div>
</div>
@endsection
