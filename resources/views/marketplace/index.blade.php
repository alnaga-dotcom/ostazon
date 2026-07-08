@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'سوق المحتوى' : 'Content Marketplace')

@section('content')
<div style="min-height: 100vh; background-color: #F7FEE7;">
    <div style="background: linear-gradient(135deg, #166534 0%, #15803D 100%); padding: 40px 0;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
            <h1 style="color: white; font-size: 32px; font-weight: 800; margin: 0;">
                {{ app()->getLocale() == 'ar' ? 'سوق المحتوى التعليمي' : 'Content Marketplace' }}
            </h1>
            <p style="color: #DCFCE7; font-size: 18px; margin-top: 8px;">
                {{ app()->getLocale() == 'ar' ? 'تصفح واشترِ المواد التعليمية من المعلمين' : 'Browse and purchase educational materials from tutors' }}
            </p>
        </div>
    </div>

    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px; margin-top: -24px;">
        <div style="background: white; border-radius: 16px; padding: 24px 32px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border: 2px solid #166534;">
            <form method="GET" action="{{ route('marketplace.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 6px;">{{ app()->getLocale() == 'ar' ? 'المادة' : 'Subject' }}</label>
                    <select name="subject" style="width: 100%; padding: 12px 14px; border: 2px solid #E5E7EB; border-radius: 10px; font-size: 14px; color: #14532D;">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'الكل' : 'All' }}</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>{{ $subject->localized_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 6px;">{{ app()->getLocale() == 'ar' ? 'النوع' : 'Type' }}</label>
                    <select name="type" style="width: 100%; padding: 12px 14px; border: 2px solid #E5E7EB; border-radius: 10px; font-size: 14px; color: #14532D;">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'الكل' : 'All' }}</option>
                        <option value="pdf" {{ request('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'فيديو' : 'Video' }}</option>
                        <option value="article" {{ request('type') == 'article' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'مقال' : 'Article' }}</option>
                        <option value="quiz" {{ request('type') == 'quiz' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'اختبار' : 'Quiz' }}</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #14532D; margin-bottom: 6px;">{{ app()->getLocale() == 'ar' ? 'الترتيب' : 'Sort' }}</label>
                    <select name="sort" style="width: 100%; padding: 12px 14px; border: 2px solid #E5E7EB; border-radius: 10px; font-size: 14px; color: #14532D;">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الأحدث' : 'Newest' }}</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الأكثر تحميلاً' : 'Most Popular' }}</option>
                        <option value="cheapest" {{ request('sort') == 'cheapest' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الأقل سعراً' : 'Cheapest' }}</option>
                    </select>
                </div>
                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" style="width: 100%; padding: 12px; background: #D97706; color: white; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        {{ app()->getLocale() == 'ar' ? 'بحث' : 'Search' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div style="max-width: 1280px; margin: 0 auto; padding: 40px 24px;">
        @if($contents->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                @foreach($contents as $item)
                    <a href="{{ route('marketplace.show', $item->id) }}" style="text-decoration: none; color: inherit;">
                        <div style="background: white; border-radius: 16px; overflow: hidden; border: 2px solid #E5E7EB; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.3s;">
                            <div style="height: 140px; background: linear-gradient(135deg, #166534, #15803D); display: flex; align-items: center; justify-content: center; font-size: 48px;">
                                @if($item->content_type == 'pdf') 📄
                                @elseif($item->content_type == 'video') 🎬
                                @elseif($item->content_type == 'article') 📝
                                @elseif($item->content_type == 'quiz') ❓
                                @else 📁
                                @endif
                            </div>
                            <div style="padding: 20px;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                    <span style="padding: 4px 10px; background: #ECFDF0; color: #166534; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase;">{{ $item->content_type }}</span>
                                    <span style="font-weight: 800; color: #D97706; font-size: 18px;">{{ $item->price_coins }} 🪙</span>
                                </div>
                                <h3 style="font-size: 16px; font-weight: 700; color: #14532D; margin: 8px 0;">{{ $item->title }}</h3>
                                <p style="font-size: 13px; color: #4b5563; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $item->description ?? 'No description' }}
                                </p>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px; padding-top: 12px; border-top: 1px solid #F3F4F6; font-size: 12px; color: #4b5563;">
                                    <span>👤 {{ $item->tutor->name }}</span>
                                    <span>⬇️ {{ $item->download_count }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div style="margin-top: 32px;">{{ $contents->links() }}</div>
        @else
            <div style="text-align: center; padding: 64px; background: white; border-radius: 16px;">
                <div style="font-size: 64px; margin-bottom: 16px;">📚</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                    {{ app()->getLocale() == 'ar' ? 'لا توجد مواد بعد' : 'No content yet' }}
                </h3>
                <p style="color: #4b5563;">
                    {{ app()->getLocale() == 'ar' ? 'المعلمون سيضيفون قريباً مواد تعليمية' : 'Tutors will add educational materials soon' }}
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
