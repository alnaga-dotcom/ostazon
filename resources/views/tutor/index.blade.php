@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'المعلمون' : 'Tutors')

@section('content')
<div style="min-height: 100vh; background-color: #F7FEE7;">

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

    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px; margin-top: -24px;">
        <div style="background: #FFFFFF; border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border: 2px solid #166534;">
            <form action="{{ url('/tutors') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px;">

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ app()->getLocale() == 'ar' ? 'المادة' : 'Subject' }}
                    </label>
                    <select name="subject" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'جميع المواد' : 'All Subjects' }}</option>
                        @foreach($subjects ?? [] as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->localized_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ __('messages.service_type') }}
                    </label>
                    <select name="class_type" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'الكل' : 'All' }}</option>
                        <option value="online" {{ request('class_type') == 'online' ? 'selected' : '' }}>{{ __('messages.online') }}</option>
                        <option value="in_person" {{ request('class_type') == 'in_person' ? 'selected' : '' }}>{{ __('messages.in_person') }}</option>
                        <option value="assignment" {{ request('service_type') == 'assignment' ? 'selected' : '' }}>{{ __('messages.assignment') }}</option>
                        <option value="exam_help" {{ request('service_type') == 'exam_help' ? 'selected' : '' }}>{{ __('messages.exam_help') }}</option>
                        <option value="project_help" {{ request('service_type') == 'project_help' ? 'selected' : '' }}>{{ __('messages.project_help') }}</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ app()->getLocale() == 'ar' ? 'الدولة' : 'Country' }}
                    </label>
                    <select name="country" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                        <option value="">{{ __('messages.all_countries') }}</option>
                        @foreach($countries ?? [] as $country)
                            <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ app()->getLocale() == 'ar' ? 'الترتيب' : 'Sort By' }}
                    </label>
                    <select name="sort" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الأحدث' : 'Newest' }}</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'السعر: من الأقل' : 'Price: Low to High' }}</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'السعر: من الأعلى' : 'Price: High to Low' }}</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'التقييم' : 'Rating' }}</option>
                    </select>
                </div>

                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" style="width: 100%; padding: 14px 24px; background: #D97706; color: white; font-weight: 700; border-radius: 12px; border: none; cursor: pointer; font-size: 16px;">
                        {{ app()->getLocale() == 'ar' ? 'بحث' : 'Search' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div style="max-width: 1280px; margin: 0 auto; padding: 40px 24px;">
        @if(isset($tutors) && $tutors->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                @foreach($tutors as $tutor)
                    @php $profile = $tutor->tutorProfile; @endphp
                    <a href="{{ route('tutors.show', $tutor->id) }}" style="text-decoration: none; color: inherit; display: block; background: white; border-radius: 16px; overflow: hidden; border: 2px solid {{ $profile && $profile->is_sponsored ? '#D97706' : '#E5E7EB' }}; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.3s; position: relative;">
                        @if($profile && $profile->is_sponsored)
                            <div style="position: absolute; top: 12px; right: 12px; background: #D97706; color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; z-index: 2;">
                                {{ app()->getLocale() == 'ar' ? 'مُعلن' : 'SPONSORED' }}
                            </div>
                        @endif
                        <div style="height: 80px; background: linear-gradient(135deg, #166534, #15803D); position: relative;">
                            <div style="position: absolute; bottom: -32px; left: 50%; transform: translateX(-50%);">
                                <div style="width: 64px; height: 64px; background: white; border-radius: 50%; padding: 3px; box-shadow: 0 4px 10px rgba(0,0,0,0.15); border: 2px solid #166534;">
                                    <div style="width: 100%; height: 100%; background: #166534; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 24px;">
                                        {{ substr($tutor->name, 0, 1) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 40px 24px 24px; text-align: center;">
                            <h3 style="font-weight: 700; color: #14532D; font-size: 18px; margin: 0;">{{ $tutor->name }}</h3>
                            <p style="color: #166534; font-weight: 600; font-size: 14px; margin-top: 4px;">
                                @if($profile && $profile->subjects && $profile->subjects->count() > 0)
                                    @foreach($profile->subjects as $subject)
                                        {{ $subject->localized_name }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                @else
                                    {{ app()->getLocale() == 'ar' ? 'عام' : 'General' }}
                                @endif
                            </p>
                            @if($profile && $profile->average_rating)
                                <div style="display: flex; align-items: center; justify-content: center; gap: 4px; margin-top: 8px;">
                                    <span style="color: #F59E0B; font-size: 18px;">{{ str_repeat('★', min(5, max(1, round($profile->average_rating)))) }}{{ str_repeat('☆', max(0, 5 - round($profile->average_rating))) }}</span>
                                    <span style="font-size: 14px; color: #4b5563;">({{ $profile->average_rating }})</span>
                                </div>
                            @endif

                            <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-top: 12px;">
                                @if($profile && $profile->lesson_mode)
                                    <span style="padding: 6px 12px; background: #ECFDF0; color: #166534; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid #A7F3D0;">
                                        {{ $profile->lesson_mode == 'online' ? __('messages.online') : __('messages.in_person') }}
                                    </span>
                                @endif
                                @if($profile && $profile->service_types)
                                    @foreach($profile->service_types as $st)
                                        <span style="padding: 6px 12px; background: #F3E8FF; color: #7E22CE; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid #D8B4FE;">
                                            {{ __("messages.$st") }}
                                        </span>
                                    @endforeach
                                @endif
                                @if($profile && $profile->country)
                                    <span style="padding: 6px 12px; background: #FEF3C7; color: #D97706; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid #FCD34D;">{{ $profile->country }}</span>
                                @endif
                                @if($profile && $profile->badge_level)
                                    <span style="padding: 6px 12px; background: #DBEAFE; color: #1E40AF; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid #93C5FD;">{{ ucfirst($profile->badge_level) }}</span>
                                @endif
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px; padding-top: 16px; border-top: 2px solid #F3F4F6;">
                                <div>
                                    <span style="color: #166534; font-weight: 800; font-size: 24px;">{{ $profile->hourly_rate ?? 0 }}</span>
                                    <span style="font-size: 14px; color: #4b5563;"> / {{ app()->getLocale() == 'ar' ? 'ساعة' : 'hour' }}</span>
                                </div>
                                <span style="padding: 10px 24px; background: #D97706; color: white; border-radius: 12px; font-size: 14px; font-weight: 700; display: inline-block;">
                                    {{ app()->getLocale() == 'ar' ? 'احجز الآن' : 'Book Now' }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div style="margin-top: 32px;">
                {{ $tutors->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 64px; background: white; border-radius: 16px; border: 2px solid #E5E7EB;">
                <div style="font-size: 64px; margin-bottom: 16px;">👨‍🏫</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                    {{ app()->getLocale() == 'ar' ? 'لا يوجد معلمين' : 'No tutors found' }}
                </h3>
                <p style="color: #4b5563;">
                    {{ app()->getLocale() == 'ar' ? 'جرب مرشحات مختلفة' : 'Try different filters' }}
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
