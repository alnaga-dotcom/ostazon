@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'محتواي' : 'My Content')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 40px 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 style="font-size: 28px; font-weight: 800; color: #14532D; margin: 0;">
            {{ auth()->user()->isTutor() ? (app()->getLocale() == 'ar' ? 'محتواي المنشور' : 'My Published Content') : (app()->getLocale() == 'ar' ? 'مشترياني' : 'My Purchases') }}
        </h1>
        @if(auth()->user()->isTutor())
            <a href="{{ route('marketplace.create') }}" style="padding: 12px 24px; background: #D97706; color: white; border-radius: 12px; font-weight: 700; text-decoration: none;">
                + {{ app()->getLocale() == 'ar' ? 'إضافة محتوى' : 'Add Content' }}
            </a>
        @endif
    </div>

    @if($contents->count() > 0)
        <div style="display: grid; gap: 16px;">
            @foreach($contents as $item)
                <a href="{{ route('marketplace.show', $item->id) }}" style="text-decoration: none; color: inherit;">
                    <div style="background: white; border-radius: 16px; padding: 20px 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; border: 2px solid #E5E7EB;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="font-size: 32px;">
                                @if($item->content_type == 'pdf') 📄
                                @elseif($item->content_type == 'video') 🎬
                                @elseif($item->content_type == 'article') 📝
                                @else ❓
                                @endif
                            </div>
                            <div>
                                <h3 style="font-size: 16px; font-weight: 700; color: #14532D; margin: 0;">{{ $item->title }}</h3>
                                <p style="font-size: 13px; color: #4b5563; margin: 4px 0 0;">
                                    @if(auth()->user()->isTutor())
                                        {{ $item->download_count }} ⬇️ • {{ $item->price_coins }} 🪙
                                    @else
                                        👤 {{ $item->tutor->name }} • {{ $item->price_coins }} 🪙
                                    @endif
                                </p>
                            </div>
                        </div>
                        <span style="font-size: 14px; color: #4b5563;">{{ $item->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div style="margin-top: 24px;">{{ $contents->links() }}</div>
    @else
        <div style="text-align: center; padding: 64px; background: white; border-radius: 16px;">
            <div style="font-size: 64px; margin-bottom: 16px;">📚</div>
            <h3 style="font-size: 18px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                @if(auth()->user()->isTutor())
                    {{ app()->getLocale() == 'ar' ? 'لم تنشر أي محتوى بعد' : 'You haven\'t published any content yet' }}
                @else
                    {{ app()->getLocale() == 'ar' ? 'لم تشترِ أي محتوى بعد' : 'No purchases yet' }}
                @endif
            </h3>
            @if(auth()->user()->isTutor())
                <a href="{{ route('marketplace.create') }}" style="display: inline-block; padding: 12px 32px; background: #D97706; color: white; border-radius: 12px; font-weight: 700; text-decoration: none; margin-top: 12px;">
                    {{ app()->getLocale() == 'ar' ? 'انشر أول محتوى' : 'Publish Your First Content' }}
                </a>
            @else
                <a href="{{ route('marketplace.index') }}" style="display: inline-block; padding: 12px 32px; background: #D97706; color: white; border-radius: 12px; font-weight: 700; text-decoration: none; margin-top: 12px;">
                    {{ app()->getLocale() == 'ar' ? 'تصفح السوق' : 'Browse Marketplace' }}
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
