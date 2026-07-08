@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'الرسائل' : 'Messages')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 40px 24px;">
    <h1 style="font-size: 28px; font-weight: 800; color: #14532D; margin-bottom: 24px;">
        {{ app()->getLocale() == 'ar' ? 'الرسائل' : 'Messages' }}
    </h1>

    @if($conversations->count() > 0)
        <div style="background: white; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden;">
            @foreach($conversations as $conv)
                <a href="{{ route('chat.conversation', $conv->user->id) }}"
                   style="display: flex; align-items: center; gap: 16px; padding: 20px 24px; text-decoration: none; color: inherit; border-bottom: 1px solid #F3F4F6; transition: background 0.2s;"
                   onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: #166534; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px; flex-shrink: 0;">
                        {{ strtoupper(substr($conv->user->name, 0, 1)) }}
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <span style="font-weight: 700; color: #14532D; font-size: 15px;">{{ $conv->user->name }}</span>
                            <span style="font-size: 12px; color: #4b5563;">{{ $conv->last_time->diffForHumans() }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 14px; color: #4b5563; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 400px;">
                                {{ \Illuminate\Support\Str::limit($conv->last_message, 60) }}
                            </span>
                            @if($conv->unread > 0)
                                <span style="background: #D97706; color: white; padding: 2px 8px; border-radius: 50px; font-size: 11px; font-weight: 700;">{{ $conv->unread }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 64px; background: white; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="font-size: 64px; margin-bottom: 16px;">💬</div>
            <h3 style="font-size: 18px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                {{ app()->getLocale() == 'ar' ? 'لا توجد رسائل' : 'No messages yet' }}
            </h3>
            <p style="color: #4b5563;">
                {{ app()->getLocale() == 'ar' ? 'ابدأ محادثة مع معلم أو طالب' : 'Start a conversation with a tutor or student' }}
            </p>
        </div>
    @endif
</div>
@endsection
