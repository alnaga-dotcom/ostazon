@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'رفع محتوى' : 'Upload Content')

@section('content')
<div style="max-width: 700px; margin: 0 auto; padding: 40px 24px;">
    <h1 style="font-size: 28px; font-weight: 800; color: #14532D; margin-bottom: 24px;">
        {{ app()->getLocale() == 'ar' ? 'رفع محتوى تعليمي' : 'Upload Educational Content' }}
    </h1>

    <div style="background: white; border-radius: 20px; padding: 32px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <form method="POST" action="{{ route('marketplace.store') }}">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 6px;">
                    {{ app()->getLocale() == 'ar' ? 'العنوان' : 'Title' }} *
                </label>
                <input type="text" name="title" required maxlength="255"
                       style="width: 100%; padding: 12px 14px; border: 2px solid #E5E7EB; border-radius: 10px; font-size: 14px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 6px;">
                    {{ app()->getLocale() == 'ar' ? 'الوصف' : 'Description' }}
                </label>
                <textarea name="description" rows="5" maxlength="5000"
                          style="width: 100%; padding: 12px 14px; border: 2px solid #E5E7EB; border-radius: 10px; font-size: 14px; outline: none; font-family: inherit;"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 6px;">
                        {{ app()->getLocale() == 'ar' ? 'المادة' : 'Subject' }}
                    </label>
                    <select name="subject_id"
                            style="width: 100%; padding: 12px 14px; border: 2px solid #E5E7EB; border-radius: 10px; font-size: 14px; color: #14532D;">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'اختر' : 'Select' }}</option>
        @foreach($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->localized_name }}</option>
        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 6px;">
                        {{ app()->getLocale() == 'ar' ? 'النوع' : 'Type' }} *
                    </label>
                    <select name="content_type" required
                            style="width: 100%; padding: 12px 14px; border: 2px solid #E5E7EB; border-radius: 10px; font-size: 14px; color: #14532D;">
                        <option value="pdf">PDF</option>
                        <option value="video">{{ app()->getLocale() == 'ar' ? 'فيديو' : 'Video' }}</option>
                        <option value="article">{{ app()->getLocale() == 'ar' ? 'مقال' : 'Article' }}</option>
                        <option value="quiz">{{ app()->getLocale() == 'ar' ? 'اختبار' : 'Quiz' }}</option>
                        <option value="other">{{ app()->getLocale() == 'ar' ? 'أخرى' : 'Other' }}</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 6px;">
                    {{ app()->getLocale() == 'ar' ? 'السعر (عملات)' : 'Price (coins)' }} *
                </label>
                <input type="number" name="price_coins" required min="0" max="10000" value="5"
                       style="width: 100%; padding: 12px 14px; border: 2px solid #E5E7EB; border-radius: 10px; font-size: 14px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 6px;">
                    {{ app()->getLocale() == 'ar' ? 'رابط الملف' : 'File URL' }}
                </label>
                <input type="url" name="file_url" maxlength="500"
                       style="width: 100%; padding: 12px 14px; border: 2px solid #E5E7EB; border-radius: 10px; font-size: 14px; outline: none;"
                       placeholder="https://example.com/my-content.pdf">
            </div>

            <button type="submit" style="width: 100%; padding: 14px; background: #166534; color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer;">
                {{ app()->getLocale() == 'ar' ? 'نشر المحتوى' : 'Publish Content' }}
            </button>
        </form>
    </div>
</div>
@endsection
