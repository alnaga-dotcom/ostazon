@extends('layouts.main')

@section('title', $user->name . ' - ' . (app()->getLocale() == 'ar' ? 'الرسائل' : 'Messages'))

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 40px 24px;">
    <a href="{{ route('chat.inbox') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #166534; font-weight: 600; font-size: 14px; text-decoration: none; margin-bottom: 16px;">
        ← {{ app()->getLocale() == 'ar' ? 'العودة للرسائل' : 'Back to Messages' }}
    </a>

    <div style="background: white; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="padding: 20px 24px; border-bottom: 2px solid #F3F4F6; display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: #166534; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <span style="font-weight: 700; color: #14532D; font-size: 16px;">{{ $user->name }}</span>
                <div style="font-size: 12px; color: #10B981;">{{ app()->getLocale() == 'ar' ? 'متصل' : 'Online' }}</div>
            </div>
        </div>

        <div style="padding: 24px; max-height: 500px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px;" id="messages-container">
            @forelse($messages as $msg)
                @php $isMine = $msg->sender_id === auth()->id(); @endphp
                <div style="display: flex; justify-content: {{ $isMine ? 'flex-end' : 'flex-start' }};">
                    <div style="max-width: 70%; padding: 12px 18px; border-radius: 18px; background: {{ $isMine ? '#166534' : '#F3F4F6' }}; color: {{ $isMine ? 'white' : '#1F2937' }}; font-size: 14px; line-height: 1.5; {{ $isMine ? 'border-bottom-right-radius: 4px' : 'border-bottom-left-radius: 4px' }};">
                        <p style="margin: 0;">{{ $msg->body }}</p>
                        <div style="font-size: 11px; margin-top: 4px; opacity: 0.7; text-align: {{ $isMine ? 'right' : 'left' }};">
                            {{ $msg->created_at->format('H:i') }}
                            @if($isMine && $msg->read_at)
                                <span> ✓✓</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px; color: #4b5563;">
                    {{ app()->getLocale() == 'ar' ? 'لا توجد رسائل بعد. ابدأ المحادثة!' : 'No messages yet. Start the conversation!' }}
                </div>
            @endforelse
        </div>

        <form method="POST" action="{{ route('chat.send', $user->id) }}" style="padding: 16px 24px; border-top: 2px solid #F3F4F6; display: flex; gap: 12px;">
            @csrf
            <input type="text" name="body" required
                   placeholder="{{ app()->getLocale() == 'ar' ? 'اكتب رسالتك...' : 'Type your message...' }}"
                   style="flex: 1; padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 14px; outline: none;"
                   autofocus>
            <button type="submit" style="padding: 12px 24px; background: #D97706; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer;">
                {{ app()->getLocale() == 'ar' ? 'إرسال' : 'Send' }}
            </button>
        </form>
    </div>
</div>

<script>
    var container = document.getElementById('messages-container');
    if (container) container.scrollTop = container.scrollHeight;
</script>
@endsection
