@extends('layouts.main')
@section('title', __('messages.proposals') . ' - OstazON')
@section('content')
<style>
    .prop-container { max-width: 900px; margin: 0 auto; padding: 40px 24px; }
    .prop-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .prop-header h1 { font-size: 28px; font-weight: 800; }
    .request-card { background: white; border-radius: 16px; padding: 24px; box-shadow: var(--shadow); margin-bottom: 16px; border: 2px solid #E5E7EB; }
    .request-card h3 { font-size: 18px; font-weight: 700; margin-bottom: 8px; }
    .request-meta { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 12px; font-size: 14px; color: var(--text-light); }
    .request-meta span { display: flex; align-items: center; gap: 4px; }
    .request-card p { color: var(--text-light); margin-bottom: 16px; line-height: 1.6; }
    .propose-form { display: grid; grid-template-columns: 1fr 2fr; gap: 12px; }
    .propose-form input[type="number"] { padding: 10px 16px; border: 2px solid #E5E7EB; border-radius: 8px; font-size: 14px; }
    .propose-form input[type="text"] { padding: 10px 16px; border: 2px solid #E5E7EB; border-radius: 8px; font-size: 14px; }
    .propose-form button { padding: 10px 20px; white-space: nowrap; }
    .empty-state { text-align: center; padding: 64px; color: var(--text-light); }
</style>
<div class="prop-container">
    <div class="prop-header">
        <h1>{{ app()->getLocale() == 'ar' ? 'الطلبات المتاحة' : 'Available Requests' }}</h1>
    </div>
    @if(session('success'))
        <div style="background: #D4EDDA; color: #155724; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="background: #F8D7DA; color: #721C24; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px;">{{ session('error') }}</div>
    @endif
    @php
        $requests = \App\Models\TutoringRequest::where('status', 'open')
            ->whereDoesntHave('proposals', fn($q) => $q->where('tutor_id', auth()->id()))
            ->with(['student', 'subject'])
            ->orderBy('created_at', 'desc')
            ->get();
    @endphp
    @if($requests->count() > 0)
        @foreach($requests as $request)
            <div class="request-card">
                <h3>{{ $request->title ?? ($request->subject->localized_name ?? ($request->subject->name ?? '')) }}</h3>
                <div class="request-meta">
                    <span>&#128100; {{ $request->student->name ?? 'Student' }}</span>
                    <span>&#128218; {{ $request->subject->localized_name ?? ($request->subject->name ?? '') }}</span>
                    @if($request->budget_egp)
                        <span>&#128176; {{ number_format($request->budget_egp, 0) }} EGP</span>
                    @endif
                    @if($request->lesson_mode)
                        <span>&#128205; {{ $request->lesson_mode ? ($request->lesson_mode === 'online' ? (app()->getLocale() == 'ar' ? 'أونلاين' : 'Online') : (app()->getLocale() == 'ar' ? 'حضوري' : 'In Person')) : (app()->getLocale() == 'ar' ? 'غير محدد' : 'Not specified') }}</span>
                    @endif
                    @if($request->preferred_schedule)
                        <span>&#128197; {{ $request->preferred_schedule }}</span>
                    @endif
                </div>
                <p>{{ $request->description }}</p>
                <form method="POST" action="{{ route('tutor.proposals.store') }}" class="propose-form">
                    @csrf
                    <input type="hidden" name="request_id" value="{{ $request->id }}">
                    <input type="number" name="proposed_rate" step="1" min="0" placeholder="{{ app()->getLocale() == 'ar' ? 'السعر (جنيه)' : 'Rate (EGP)' }}" required>
                    <div style="display: flex; gap: 8px;">
                        <input type="text" name="message" placeholder="{{ app()->getLocale() == 'ar' ? 'رسالتك للطالب...' : 'Your message to the student...' }}" required style="flex:1;">
                        <button type="submit" class="btn btn-primary">{{ app()->getLocale() == 'ar' ? 'تقديم عرض' : 'Submit' }}</button>
                    </div>
                </form>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <p style="font-size: 48px; margin-bottom: 12px;">&#128269;</p>
            <p>{{ app()->getLocale() == 'ar' ? 'لا توجد طلبات متاحة حالياً. تابع صفحة الطلبات لتصلك الإشعارات.' : 'No requests available at the moment. Check back later for new requests.' }}</p>
        </div>
    @endif
</div>
@endsection
