@extends('layouts.main')

@section('title', 'Subject Requests - Admin - OstazON')

@section('content')

@if(session('success'))
    <div style="max-width: 1400px; margin: 0 auto; padding: 20px 24px 0;">
        <div style="padding: 16px 24px; background: #dcfce7; color: #166534; border-radius: 12px; font-weight: 600;">
            ✅ {{ session('success') }}
        </div>
    </div>
@endif

<style>
    .admin-container { max-width: 1000px; margin: 0 auto; padding: 40px 24px; }
    .admin-header { margin-bottom: 32px; }
    .admin-header h1 { font-size: 32px; font-weight: 800; }
    .card { background: white; border-radius: 20px; box-shadow: var(--shadow); overflow: hidden; padding: 28px; }
    .req-item { padding: 20px 0; border-bottom: 1px solid #F3F4F6; display: flex; justify-content: space-between; align-items: center; }
    .req-item:last-child { border-bottom: none; }
    .req-info h3 { font-size: 16px; font-weight: 700; }
    .req-info p { font-size: 13px; color: var(--text-light); }
    .req-info .meta { font-size: 12px; color: #9CA3AF; margin-top: 4px; }
    .req-actions { display: flex; gap: 8px; }
    .btn-approve { background: #166534; color: white; padding: 8px 20px; border: none; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; }
    .btn-approve:hover { background: #14532d; }
    .btn-reject { background: #fee2e2; color: #dc2626; padding: 8px 20px; border: none; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; }
    .btn-reject:hover { background: #fecaca; }
    .empty-state { text-align: center; padding: 60px; color: var(--text-light); }
</style>

<div class="admin-container">
    <div class="admin-header">
        <h1>{{ app()->getLocale() == 'ar' ? 'طلبات المواد الجديدة' : 'Subject Requests' }}</h1>
        <p style="color: var(--text-light); margin-top: 4px;">{{ count($requests) }} {{ app()->getLocale() == 'ar' ? 'طلب معلق' : 'pending requests' }}</p>
    </div>

    <div class="card">
        @forelse($requests as $req)
            <div class="req-item">
                <div class="req-info">
                    <h3>{{ $req->subject_name }}</h3>
                    <p>
                        {{ app()->getLocale() == 'ar' ? 'بواسطة' : 'by' }}
                        <strong>{{ $req->user->name }}</strong>
                        ({{ $req->user->email }})
                        — {{ $req->user->isTutor() ? 'معلّم' : 'طالب' }}
                    </p>
                    @if($req->message)
                        <p style="margin-top: 4px; color: #6B7280; font-style: italic;">"{{ $req->message }}"</p>
                    @endif
                    <div class="meta">{{ $req->created_at->diffForHumans() }}</div>
                </div>
                <div class="req-actions">
                    <form method="POST" action="{{ route('admin.subject-requests.approve', $req->id) }}">
                        @csrf
                        <button type="submit" class="btn-approve">+ {{ app()->getLocale() == 'ar' ? 'إضافة للمواد' : 'Add to Subjects' }}</button>
                    </form>
                    <form method="POST" action="{{ route('admin.subject-requests.reject', $req->id) }}">
                        @csrf
                        <button type="submit" class="btn-reject">✕ {{ app()->getLocale() == 'ar' ? 'رفض' : 'Reject' }}</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div style="font-size: 48px; margin-bottom: 16px;">📭</div>
                <h3>{{ app()->getLocale() == 'ar' ? 'لا توجد طلبات معلقة' : 'No pending requests' }}</h3>
                <p>{{ app()->getLocale() == 'ar' ? 'عندما يطلب أحد المعلمين أو الطلاب مادة جديدة، ستظهر هنا' : 'When a tutor or student requests a new subject, it will appear here.' }}</p>
            </div>
        @endforelse
    </div>
</div>
@endsection