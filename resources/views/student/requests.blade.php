@extends('layouts.main')
@section('title', __('messages.my_requests') . ' - OstazON')
@section('content')
<style>
    .req-container { max-width: 900px; margin: 0 auto; padding: 40px 24px; }
    .req-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
    .req-header h1 { font-size: 28px; font-weight: 800; }
    .request-card { background: white; border-radius: 16px; padding: 20px 24px; box-shadow: var(--shadow); margin-bottom: 16px; border: 2px solid #E5E7EB; transition: border-color .2s; }
    .request-card:hover { border-color: var(--primary-light); }
    .request-card h3 { font-size: 16px; font-weight: 700; margin-bottom: 4px; }
    .request-card p { color: var(--text-light); font-size: 14px; }
    .request-meta { display: flex; gap: 16px; flex-wrap: wrap; font-size: 13px; color: var(--text-light); margin-bottom: 8px; }
    .status-badge { padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; display: inline-block; }
    .status-open { background: #D4EDDA; color: #155724; }
    .status-proposed { background: #FEF3C7; color: #D97706; }
    .status-fulfilled { background: #DBEAFE; color: #1E40AF; }
    .status-closed { background: #F3F4F6; color: #6B7280; }
    .proposal-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #F3F4F6; flex-wrap: wrap; gap: 8px; }
    .proposal-item:last-child { border-bottom: none; }
    .proposal-info { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .proposal-tutor { font-weight: 600; font-size: 14px; }
    .proposal-rate { background: var(--primary-light); padding: 2px 10px; border-radius: 50px; font-size: 13px; font-weight: 600; color: var(--primary); }
    .proposal-message { font-size: 13px; color: var(--text-light); }
    .proposal-status { font-size: 12px; padding: 2px 8px; border-radius: 50px; }
    .empty-state { text-align: center; padding: 64px; color: var(--text-light); }
    .empty-state p { font-size: 48px; margin-bottom: 12px; }
</style>
<div class="req-container">
    <div class="req-header">
        <h1>{{ app()->getLocale() == 'ar' ? 'طلباتي' : 'My Requests' }}</h1>
        <a href="{{ route('student.requests.create') }}" class="btn btn-primary">{{ app()->getLocale() == 'ar' ? 'طلب جديد' : 'New Request' }}</a>
    </div>
    @if(session('success'))
        <div style="background: #D4EDDA; color: #155724; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px;">{{ session('success') }}</div>
    @endif
    @php
        $requests = \App\Models\TutoringRequest::where('student_id', auth()->id())
            ->with(['subject', 'proposals.tutor'])
            ->orderBy('created_at', 'desc')
            ->get();
    @endphp
    @if($requests->count() > 0)
        @foreach($requests as $request)
            <div class="request-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 8px;">
                    <div>
                        <h3>{{ $request->title ?? ($request->subject->localized_name ?? ($request->subject->name ?? '')) }}</h3>
                        <div class="request-meta">
                            @if($request->budget_egp)
                                <span>&#128176; {{ number_format($request->budget_egp, 0) }} EGP</span>
                            @endif
                            @if($request->lesson_mode)
                                <span>&#128205; {{ $request->lesson_mode ? ($request->lesson_mode === 'online' ? (app()->getLocale() == 'ar' ? 'أونلاين' : 'Online') : (app()->getLocale() == 'ar' ? 'حضوري' : 'In Person')) : (app()->getLocale() == 'ar' ? 'غير محدد' : 'Not specified') }}</span>
                            @endif
                            @if($request->preferred_schedule)
                                <span>&#128197; {{ $request->preferred_schedule }}</span>
                            @endif
                            <span>&#128197; {{ $request->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($request->description)
                            <p>{{ $request->description }}</p>
                        @endif
                    </div>
                    <span class="status-badge status-{{ $request->status }}">
                        @if($request->status === 'open') {{ app()->getLocale() == 'ar' ? 'مفتوح' : 'Open' }}
                        @elseif($request->status === 'proposed') {{ app()->getLocale() == 'ar' ? 'عروض مقدمة' : 'Proposals' }}
                        @elseif($request->status === 'fulfilled') {{ app()->getLocale() == 'ar' ? 'تم التعيين' : 'Fulfilled' }}
                        @else {{ ucfirst($request->status) }}
                        @endif
                    </span>
                </div>
                @if($request->proposals->count() > 0 && in_array($request->status, ['open', 'proposed', 'fulfilled']))
                    <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #F3F4F6;">
                        @foreach($request->proposals as $proposal)
                            <div class="proposal-item">
                                <div class="proposal-info">
                                    <span class="proposal-tutor">&#128100; {{ $proposal->tutor->name ?? '' }}</span>
                                    @if($proposal->proposed_rate)
                                        <span class="proposal-rate">{{ number_format($proposal->proposed_rate, 0) }} EGP</span>
                                    @endif
                                    @if($proposal->message)
                                        <span class="proposal-message">{{ $proposal->message }}</span>
                                    @endif
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    @if($proposal->status === 'accepted')
                                        <span class="status-badge" style="background:#DBEAFE;color:#1E40AF;">{{ app()->getLocale() == 'ar' ? 'مقبول' : 'Accepted' }}</span>
                                    @elseif($proposal->status === 'rejected')
                                        <span class="status-badge" style="background:#F3F4F6;color:#6B7280;">{{ app()->getLocale() == 'ar' ? 'مرفوض' : 'Rejected' }}</span>
                                    @elseif(in_array($request->status, ['open', 'proposed']))
                                        <form method="POST" action="{{ route('student.proposals.accept', $proposal->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-secondary">{{ app()->getLocale() == 'ar' ? 'قبول' : 'Accept' }}</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <p>&#128221;</p>
            <p>{{ app()->getLocale() == 'ar' ? 'لا توجد طلبات بعد. اضغط "طلب جديد" لإنشاء أول طلك!' : 'No requests yet. Click "New Request" to create your first one!' }}</p>
        </div>
    @endif
</div>
@endsection
