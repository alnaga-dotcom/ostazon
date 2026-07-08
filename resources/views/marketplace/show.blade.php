@extends('layouts.main')

@section('title', $content->title . ' - ' . (app()->getLocale() == 'ar' ? 'سوق المحتوى' : 'Marketplace'))

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 40px 24px;">
    <a href="{{ route('marketplace.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #166534; font-weight: 600; font-size: 14px; text-decoration: none; margin-bottom: 24px;">
        ← {{ app()->getLocale() == 'ar' ? 'العودة للسوق' : 'Back to Marketplace' }}
    </a>

    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <div style="height: 200px; background: linear-gradient(135deg, #166534, #15803D); display: flex; align-items: center; justify-content: center; font-size: 80px;">
            @if($content->content_type == 'pdf') 📄
            @elseif($content->content_type == 'video') 🎬
            @elseif($content->content_type == 'article') 📝
            @elseif($content->content_type == 'quiz') ❓
            @else 📁
            @endif
        </div>
        <div style="padding: 32px;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                <div>
                    <span style="padding: 4px 12px; background: #ECFDF0; color: #166534; border-radius: 50px; font-size: 12px; font-weight: 700; text-transform: uppercase;">{{ $content->content_type }}</span>
                    @if($content->subject)
                        <span style="padding: 4px 12px; background: #FEF3C7; color: #D97706; border-radius: 50px; font-size: 12px; font-weight: 600; margin-left: 8px;">{{ $content->subject->localized_name }}</span>
                    @endif
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 32px; font-weight: 800; color: #D97706;">{{ $content->price_coins }} 🪙</div>
                    <div style="font-size: 13px; color: #4b5563;">⬇️ {{ $content->download_count }} {{ app()->getLocale() == 'ar' ? 'تحميل' : 'downloads' }}</div>
                </div>
            </div>

            <h1 style="font-size: 28px; font-weight: 800; color: #14532D; margin-bottom: 8px;">{{ $content->title }}</h1>

            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px; padding-bottom: 24px; border-bottom: 2px solid #F3F4F6;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #166534; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                    {{ strtoupper(substr($content->tutor->name, 0, 1)) }}
                </div>
                <div>
                    <strong style="color: #14532D;">{{ $content->tutor->name }}</strong>
                    <div style="font-size: 12px; color: #4b5563;">{{ app()->getLocale() == 'ar' ? 'مدرس' : 'Tutor' }}</div>
                </div>
            </div>

            @if($content->description)
                <div style="margin-bottom: 24px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #14532D; margin-bottom: 8px;">{{ app()->getLocale() == 'ar' ? 'الوصف' : 'Description' }}</h3>
                    <p style="color: #4b5563; line-height: 1.8; font-size: 14px;">{{ $content->description }}</p>
                </div>
            @endif

            @auth
                @if(auth()->user()->isStudent())
                    @if($hasPurchased)
                        <div style="background: #ECFDF0; border: 2px solid #A7F3D0; border-radius: 16px; padding: 24px; text-align: center;">
                            <div style="font-size: 48px; margin-bottom: 8px;">✅</div>
                            <h3 style="font-size: 18px; font-weight: 700; color: #166534; margin-bottom: 8px;">
                                {{ app()->getLocale() == 'ar' ? 'لقد اشتريت هذا المحتوى' : 'You own this content' }}
                            </h3>
                            @if($content->file_url)
                                <a href="{{ $content->file_url }}" target="_blank"
                                   style="display: inline-block; padding: 12px 32px; background: #166534; color: white; border-radius: 12px; font-weight: 700; text-decoration: none; margin-top: 12px;">
                                    📥 {{ app()->getLocale() == 'ar' ? 'تحميل' : 'Download' }}
                                </a>
                            @endif
                        </div>
                    @else
                        <form method="POST" action="{{ route('marketplace.purchase', $content->id) }}">
                            @csrf
                            <button type="submit" style="width: 100%; padding: 16px; background: #D97706; color: white; border: none; border-radius: 16px; font-size: 18px; font-weight: 800; cursor: pointer;">
                                🪙 {{ app()->getLocale() == 'ar' ? 'اشترِ الآن' : 'Buy Now' }} — {{ $content->price_coins }} {{ app()->getLocale() == 'ar' ? 'عملة' : 'coins' }}
                            </button>
                        </form>
                    @endif
                @elseif(auth()->user()->isTutor() && auth()->id() === $content->tutor_id)
                    <div style="background: #FEF3C7; border: 2px solid #FCD34D; border-radius: 16px; padding: 24px; text-align: center;">
                        <p style="font-weight: 700; color: #D97706;">
                            {{ app()->getLocale() == 'ar' ? 'هذا المحتوى خاص بك' : 'This is your content' }}
                        </p>
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}" style="display: block; text-align: center; padding: 16px; background: #D97706; color: white; border-radius: 16px; font-size: 18px; font-weight: 800; text-decoration: none;">
                    🪙 {{ app()->getLocale() == 'ar' ? 'سجل الدخول للشراء' : 'Login to Purchase' }}
                </a>
            @endauth
        </div>
    </div>

    @if($similar->count() > 0)
        <div style="margin-top: 40px;">
            <h2 style="font-size: 20px; font-weight: 800; color: #14532D; margin-bottom: 20px;">
                {{ app()->getLocale() == 'ar' ? 'مواد مشابهة' : 'Similar Content' }}
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
                @foreach($similar as $item)
                    <a href="{{ route('marketplace.show', $item->id) }}" style="text-decoration: none; color: inherit;">
                        <div style="background: white; border-radius: 12px; overflow: hidden; border: 2px solid #E5E7EB;">
                            <div style="height: 100px; background: linear-gradient(135deg, #166534, #15803D); display: flex; align-items: center; justify-content: center; font-size: 32px;">
                                @if($item->content_type == 'pdf') 📄 @elseif($item->content_type == 'video') 🎬 @else 📝 @endif
                            </div>
                            <div style="padding: 16px;">
                                <h4 style="font-size: 14px; font-weight: 700; color: #14532D; margin: 0;">{{ $item->title }}</h4>
                                <div style="font-size: 14px; font-weight: 700; color: #D97706; margin-top: 4px;">{{ $item->price_coins }} 🪙</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
