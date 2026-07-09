@extends('layouts.main')
@section('title', 'Grant Coins - OstazON')
@section('content')
<style>
    .gc-container { max-width: 500px; margin: 0 auto; padding: 40px 24px; }
    .gc-card { background: white; border-radius: 20px; padding: 32px; box-shadow: var(--shadow); }
    .gc-card h1 { font-size: 24px; font-weight: 800; margin-bottom: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: #14532D; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 16px; border: 2px solid #E5E7EB; border-radius: 12px; font-size: 15px; }
    .form-group select { background: white; }
    .form-group textarea { resize: vertical; min-height: 60px; }
    .btn-grant { width: 100%; padding: 14px; background: #D97706; color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; }
    .btn-grant:hover { background: #B45309; }
    .success-msg { background: #D4EDDA; color: #155724; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; }
</style>
<div class="gc-container">
    <div class="gc-card">
        <h1>🎁 Grant Coins to Student</h1>

        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.grant-coins.store') }}">
            @csrf
            <div class="form-group">
                <label>Student</label>
                <select name="user_id" required>
                    <option value="">Select a student...</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Coin Amount</label>
                <input type="number" name="amount" min="1" required placeholder="e.g. 40">
            </div>
            <div class="form-group">
                <label>Reason</label>
                <textarea name="reason" required placeholder="e.g. Welcome bonus, promotion, compensation..."></textarea>
            </div>
            <button type="submit" class="btn-grant">Grant Coins</button>
        </form>
    </div>
</div>
@endsection
