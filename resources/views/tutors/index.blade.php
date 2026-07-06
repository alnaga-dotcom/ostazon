@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'المعلمون' : 'Tutors')

@section('content')
<div style="min-height: 100vh; background-color: #F7FEE7;">

    <!-- Header Section -->
    <div style="background: linear-gradient(135deg, #166534 0%, #15803D 100%); padding: 40px 0;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
            <h1 style="color: #FFFFFF; font-size: 32px; font-weight: 800; margin: 0;">
                {{ app()->getLocale() == 'ar' ? 'ابحث عن معلمك المثالي' : 'Find Your Perfect Tutor' }}
            </h1>
            <p style="color: #DCFCE7; font-size: 18px; margin-top: 8px;">
                {{ app()->getLocale() == 'ar' ? 'تصفح المعلمين واختر الأنسب لك' : 'Browse tutors and choose the best for you' }}
            </p>
        </div>
    </div>

    <!-- Filters Section -->
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px; margin-top: -24px;">
        <div style="background: #FFFFFF; border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border: 2px solid #166534;">
            <form action="{{ url('/tutors') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px;">

                <!-- Subject -->
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ app()->getLocale() == 'ar' ? 'المادة' : 'Subject' }}
                    </label>
                    <select name="subject" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'جميع المواد' : 'All Subjects' }}</option>
                        @foreach($subjects ?? [] as $subject)
                            <option value="{{ $subject->name }}" {{ request('subject') == $subject->name ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Class Type -->
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ app()->getLocale() == 'ar' ? 'نوع الحصة' : 'Session Type' }}
                    </label>
                    <select name="class_type" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'جميع الأنواع' : 'All Types' }}</option>
                        <option value="online_lesson">{{ app()->getLocale() == 'ar' ? 'درس أونلاين' : 'Online Lesson' }}</option>
                        <option value="in_person_lesson">{{ app()->getLocale() == 'ar' ? 'درس حضوري' : 'In-Person Lesson' }}</option>
                        <option value="assignment_help">{{ app()->getLocale() == 'ar' ? 'مساعدة في الواجبات' : 'Assignment Help' }}</option>
                        <option value="exam_prep">{{ app()->getLocale() == 'ar' ? 'تحضير امتحانات' : 'Exam Preparation' }}</option>
                        <option value="project_help">{{ app()->getLocale() == 'ar' ? 'مساعدة في مشروع' : 'Project Help' }}</option>
                    </select>
                </div>

                <!-- Country -->
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ app()->getLocale() == 'ar' ? 'الدولة' : 'Country' }}
                    </label>
                    <select name="country" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'جميع الدول' : 'All Countries' }}</option>
                        <option value="egypt">{{ app()->getLocale() == 'ar' ? 'مصر' : 'Egypt' }}</option>
                        <option value="saudi_arabia">{{ app()->getLocale() == 'ar' ? 'السعودية' : 'Saudi Arabia' }}</option>
                        <option value="uae">{{ app()->getLocale() == 'ar' ? 'الإمارات' : 'UAE' }}</option>
                        <option value="india">{{ app()->getLocale() == 'ar' ? 'الهند' : 'India' }}</option>
                        <option value="pakistan">{{ app()->getLocale() == 'ar' ? 'باكستان' : 'Pakistan' }}</option>
                        <option value="bangladesh">{{ app()->getLocale() == 'ar' ? 'بنغلاديش' : 'Bangladesh' }}</option>
                        <option value="uk">{{ app()->getLocale() == 'ar' ? 'المملكة المتحدة' : 'UK' }}</option>
                        <option value="other">{{ app()->getLocale() == 'ar' ? 'أخرى' : 'Other' }}</option>
                    </select>
                </div>

                <!-- Search Button -->
                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" style="width: 100%; padding: 14px 24px; background: #D97706; color: white; font-weight: 700; border-radius: 12px; border: none; cursor: pointer; font-size: 16px;">
                        {{ app()->getLocale() == 'ar' ? 'بحث' : 'Search' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results -->
    <div style="max-width: 1280px; margin: 0 auto; padding: 40px 24px;">
        @if(isset($tutors) && $tutors->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                @foreach($tutors as $tutor)
                    <div style="background: white; border-radius: 16px; overflow: hidden; border: 2px solid #E5E7EB; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        <div style="height: 80px; background: linear-gradient(135deg, #166534, #15803D); position: relative;">
                            <div style="position: absolute; bottom: -32px; left: 50%; transform: translateX(-50%);">
                                <div style="width: 64px; height: 64px; background: white; border-radius: 50%; padding: 3px; box-shadow: 0 4px 10px rgba(0,0,0,0.15); border: 2px solid #166534;">
                                    <div style="width: 100%; height: 100%; background: #166534; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 24px;">
                                        {{ substr($tutor->user->name ?? 'T', 0, 1) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 40px 24px 24px; text-align: center;">
                            <h3 style="font-weight: 700; color: #14532D; font-size: 18px; margin: 0;">{{ $tutor->user->name ?? 'Tutor' }}</h3>
                            <p style="color: #166534; font-weight: 600; font-size: 14px; margin-top: 4px;">{{ $tutor->subjects ?? 'General' }}</p>

                            @if($tutor->rating)
                                <div style="display: flex; align-items: center; justify-content: center; gap: 4px; margin-top: 8px;">
                                    <span style="color: #F59E0B; font-size: 18px;">★★★★★</span>
                                    <span style="font-size: 14px; color: #6B7280;">({{ $tutor->total_reviews ?? 0 }})</span>
                                </div>
                            @endif

                            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-top: 12px;">
                                <span style="padding: 6px 12px; background: #ECFDF0; color: #166534; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid #A7F3D0;">{{ app()->getLocale() == 'ar' ? 'أونلاين' : 'Online' }}</span>
                                @if($tutor->location)
                                    <span style="padding: 6px 12px; background: #FEF3C7; color: #D97706; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid #FCD34D;">{{ $tutor->location }}</span>
                                @endif
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px; padding-top: 16px; border-top: 2px solid #F3F4F6;">
                                <div>
                                    <span style="color: #166534; font-weight: 800; font-size: 24px;">{{ $tutor->hourly_rate ?? 0 }}</span>
                                    <span style="font-size: 14px; color: #6B7280;"> / {{ app()->getLocale() == 'ar' ? 'ساعة' : 'hour' }}</span>
                                </div>
                                <a href="#" style="padding: 10px 24px; background: #D97706; color: white; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none;">
                                    {{ app()->getLocale() == 'ar' ? 'احجز الآن' : 'Book Now' }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 64px; background: white; border-radius: 16px; border: 2px solid #E5E7EB;">
                <div style="font-size: 64px; margin-bottom: 16px;">👨‍🏫</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                    {{ app()->getLocale() == 'ar' ? 'لا يوجد معلمين' : 'No tutors found' }}
                </h3>
                <p style="color: #6B7280;">
                    {{ app()->getLocale() == 'ar' ? 'جرب مرشحات مختلفة' : 'Try different filters' }}
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
