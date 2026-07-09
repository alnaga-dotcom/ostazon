@extends('layouts.main')

@section('title', app()->getLocale() == 'ar' ? 'الإشعارات' : 'Notifications')

@section('content')
<div style="min-height: 80vh; background-color: #F7FEE7; padding: 40px 24px;">
    <div style="max-width: 800px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h1 style="font-size: 24px; font-weight: 800; color: #14532D; margin: 0;">
                {{ app()->getLocale() == 'ar' ? 'الإشعارات' : 'Notifications' }}
            </h1>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <a href="{{ route('notifications.read') }}" style="padding: 10px 20px; background: #166534; color: white; border-radius: 12px; font-weight: 600; text-decoration: none; font-size: 14px;">
                    {{ app()->getLocale() == 'ar' ? 'تحديد الكل كمقروء' : 'Mark all as read' }}
                </a>
            @endif
        </div>

        @forelse($notifications as $notif)
            @php $data = $notif->data; @endphp
            <a href="{{ route('notifications.readOne', $notif->id) }}" style="display: block; background: {{ $notif->read_at ? '#FFFFFF' : '#ECFDF0' }}; border-radius: 12px; padding: 20px; margin-bottom: 12px; text-decoration: none; border: 2px solid {{ $notif->read_at ? '#E5E7EB' : '#A7F3D0' }};">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div style="font-weight: 700; color: #14532D; font-size: 16px;">{{ $data['title'] ?? '' }}</div>
                        <div style="color: #4b5563; font-size: 14px; margin-top: 4px;">{{ $data['message'] ?? '' }}</div>
                    </div>
                    <span style="font-size: 12px; color: #9CA3AF; white-space: nowrap;">{{ $notif->created_at->diffForHumans() }}</span>
                </div>
            </a>
        @empty
            <div style="text-align: center; padding: 64px; background: white; border-radius: 16px; border: 2px solid #E5E7EB;">
                <div style="font-size: 48px; margin-bottom: 16px;">🔔</div>
                <h3 style="font-size: 18px; font-weight: 700; color: #14532D; margin-bottom: 8px;">
                    {{ app()->getLocale() == 'ar' ? 'لا توجد إشعارات' : 'No notifications' }}
                </h3>
                <p style="color: #4b5563;">
                    {{ app()->getLocale() == 'ar' ? 'ستظهر هنا الإشعارات الجديدة' : 'New notifications will appear here' }}
                </p>
            </div>
        @endforelse

        <div style="margin-top: 24px;">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection
