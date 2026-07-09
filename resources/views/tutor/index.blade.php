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
            <form action="{{ url('/tutors') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ app()->getLocale() == 'ar' ? 'الدولة' : 'Country' }}
                    </label>
                    <select name="country" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'جميع الدول' : 'All Countries' }}</option>
                        <option value="Egypt" {{ request('country') == 'Egypt' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'مصر' : 'Egypt' }}</option>
                        <option value="Saudi Arabia" {{ request('country') == 'Saudi Arabia' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'السعودية' : 'Saudi Arabia' }}</option>
                        <option value="UAE" {{ request('country') == 'UAE' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الإمارات' : 'UAE' }}</option>
                        <option value="Kuwait" {{ request('country') == 'Kuwait' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الكويت' : 'Kuwait' }}</option>
                        <option value="Qatar" {{ request('country') == 'Qatar' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'قطر' : 'Qatar' }}</option>
                        <option value="Bahrain" {{ request('country') == 'Bahrain' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'البحرين' : 'Bahrain' }}</option>
                        <option value="Oman" {{ request('country') == 'Oman' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'عمان' : 'Oman' }}</option>
                        <option value="Jordan" {{ request('country') == 'Jordan' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الأردن' : 'Jordan' }}</option>
                        <option value="Lebanon" {{ request('country') == 'Lebanon' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'لبنان' : 'Lebanon' }}</option>
                        <option value="Iraq" {{ request('country') == 'Iraq' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'العراق' : 'Iraq' }}</option>
                        <option value="Morocco" {{ request('country') == 'Morocco' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'المغرب' : 'Morocco' }}</option>
                        <option value="Tunisia" {{ request('country') == 'Tunisia' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'تونس' : 'Tunisia' }}</option>
                        <option value="Algeria" {{ request('country') == 'Algeria' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الجزائر' : 'Algeria' }}</option>
                        <option value="Libya" {{ request('country') == 'Libya' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'ليبيا' : 'Libya' }}</option>
                        <option value="Sudan" {{ request('country') == 'Sudan' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'السودان' : 'Sudan' }}</option>
                        <option value="Yemen" {{ request('country') == 'Yemen' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'اليمن' : 'Yemen' }}</option>
                        <option value="Palestine" {{ request('country') == 'Palestine' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'فلسطين' : 'Palestine' }}</option>
                        <option value="Syria" {{ request('country') == 'Syria' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'سوريا' : 'Syria' }}</option>
                        <option value="India" {{ request('country') == 'India' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الهند' : 'India' }}</option>
                        <option value="Pakistan" {{ request('country') == 'Pakistan' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'باكستان' : 'Pakistan' }}</option>
                        <option value="Bangladesh" {{ request('country') == 'Bangladesh' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'بنغلاديش' : 'Bangladesh' }}</option>
                        <option value="United Kingdom" {{ request('country') == 'United Kingdom' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'المملكة المتحدة' : 'United Kingdom' }}</option>
                        <option value="United States" {{ request('country') == 'United States' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الولايات المتحدة' : 'United States' }}</option>
                        <option value="Canada" {{ request('country') == 'Canada' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'كندا' : 'Canada' }}</option>
                        <option value="Australia" {{ request('country') == 'Australia' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'أستراليا' : 'Australia' }}</option>
                        <option value="Other" {{ request('country') == 'Other' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'أخرى' : 'Other' }}</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ app()->getLocale() == 'ar' ? 'المدينة' : 'City' }}
                    </label>
                    <input type="text" name="city" value="{{ request('city') }}" placeholder="{{ app()->getLocale() == 'ar' ? 'اكتب اسم المدينة...' : 'Type city...' }}" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ app()->getLocale() == 'ar' ? 'المستوى الدراسي' : 'Education Level' }}
                    </label>
                    <select name="level" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'جميع المستويات' : 'All Levels' }}</option>
                        @foreach($levels ?? [] as $level)
                            <option value="{{ $level->id }}" {{ request('level') == $level->id ? 'selected' : '' }}>
                                {{ $level->localized_name }}
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
                        {{ app()->getLocale() == 'ar' ? 'سعر الساعة (من)' : 'Min Price' }}
                    </label>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" min="0" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ app()->getLocale() == 'ar' ? 'سعر الساعة (إلى)' : 'Max Price' }}
                    </label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="999" min="0" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ app()->getLocale() == 'ar' ? 'اسم المعلم (اختياري)' : 'Tutor name (optional)' }}
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ app()->getLocale() == 'ar' ? 'اسم المعلم...' : 'Tutor name...' }}" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                        {{ app()->getLocale() == 'ar' ? 'المادة' : 'Subject' }}
                    </label>
                    <input type="text" name="subject" value="{{ request('subject') }}" placeholder="{{ app()->getLocale() == 'ar' ? 'اكتب اسم المادة...' : 'Type subject name...' }}" style="width: 100%; padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; color: #14532D; background: white; font-weight: 500;">
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

                <div style="display: flex; align-items: flex-end; gap: 8px;">
                    <button type="submit" style="flex: 1; padding: 14px 24px; background: #D97706; color: white; font-weight: 700; border-radius: 12px; border: none; cursor: pointer; font-size: 16px;">
                        {{ app()->getLocale() == 'ar' ? 'بحث' : 'Search' }}
                    </button>
                    <a href="{{ url('/tutors') }}" style="padding: 14px 18px; background: #DC2626; color: white; font-weight: 700; border-radius: 12px; text-decoration: none; font-size: 14px; white-space: nowrap;">
                        {{ app()->getLocale() == 'ar' ? 'إعادة تعيين' : 'Clear' }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div style="max-width: 1280px; margin: 0 auto; padding: 40px 24px;">
        @if(isset($tutors) && $tutors->count() > 0)
            <p style="color: #4b5563; margin-bottom: 16px; font-size: 14px;">
                {{ app()->getLocale() == 'ar' ? 'عرض ' . $tutors->firstItem() . ' - ' . $tutors->lastItem() . ' من أصل ' . $tutors->total() . ' معلم' : 'Showing ' . $tutors->firstItem() . ' - ' . $tutors->lastItem() . ' of ' . $tutors->total() . ' tutors' }}
            </p>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                @foreach($tutors as $tutor)
                    @php $profile = $tutor->tutorProfile; @endphp
                    <a href="{{ route('tutors.show', $tutor->id) }}" class="tutor-card" style="text-decoration: none; color: inherit; display: block; background: white; border-radius: 16px; overflow: hidden; border: 2px solid {{ $profile && $profile->is_sponsored ? '#D97706' : '#E5E7EB' }}; box-shadow: 0 4px 6px rgba(0,0,0,0.05); position: relative;">
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
                                    <span style="color: #166534; font-weight: 800; font-size: 24px;">{{ number_format($profile->hourly_rate ?? 0, 0) }}</span>
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
                {{ $tutors->appends(request()->query())->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 64px; background: white; border-radius: 16px; border: 2px solid #E5E7EB;">
                <div style="font-size: 64px; margin-bottom: 16px;">👨‍🏫</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                    {{ app()->getLocale() == 'ar' ? 'لا يوجد معلمين مطابقين' : 'No matching tutors found' }}
                </h3>
                <p style="color: #4b5563; margin-bottom: 16px;">
                    {{ app()->getLocale() == 'ar' ? 'حاول تغيير المرشحات' : 'Try changing your filters' }}
                </p>

                @if($suggestedSubjects && $suggestedSubjects->isNotEmpty())
                    <div style="margin-bottom: 24px;">
                        <p style="font-weight: 600; color: #14532D; font-size: 14px; margin-bottom: 8px;">
                            {{ app()->getLocale() == 'ar' ? 'مواد مشابهة:' : 'Similar subjects:' }}
                        </p>
                        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 8px;">
                            @foreach($suggestedSubjects as $s)
                                <a href="{{ url('/tutors?subject=' . urlencode($s->name)) }}" style="padding: 8px 16px; background: #ECFDF0; color: #166534; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid #A7F3D0;">
                                    {{ $s->localized_name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <p style="color: #4b5563; margin-bottom: 24px;">
                    {{ app()->getLocale() == 'ar' ? 'أو أضف طلباً وسنبحث لك عن معلم' : 'Or post a request and we\'ll find a tutor for you' }}
                </p>
                <a href="{{ url('/student/requests/create') }}" style="display: inline-block; padding: 14px 32px; background: #D97706; color: white; border-radius: 12px; font-weight: 700; text-decoration: none; font-size: 16px;">
                    {{ app()->getLocale() == 'ar' ? 'أضف طلب معلم' : 'Post a Tutor Request' }}
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
