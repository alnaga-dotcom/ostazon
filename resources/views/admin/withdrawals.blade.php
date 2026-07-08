@extends('layouts.main')
@section('title', 'Withdrawals - Admin - OstazON')
@section('content')
<style>
    .admin-container { max-width: 1400px; margin: 0 auto; padding: 40px 24px; }
    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th { text-align: left; padding: 12px 16px; font-weight: 700; color: #14532D; border-bottom: 2px solid #E5E7EB; }
    .admin-table td { padding: 12px 16px; border-bottom: 1px solid #F3F4F6; }
    .status-pending { background: #FEF3C7; color: #D97706; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; }
</style>
<div class="admin-container">
    <h1 style="font-size: 32px; font-weight: 800; margin-bottom: 32px;">💰 Withdrawals</h1>
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow-x: auto;">
        @if($withdrawals->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Tutor</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Details</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdrawals as $wd)
                        <tr>
                            <td>{{ $wd->tutor->name ?? 'N/A' }}</td>
                            <td>{{ $wd->amount }} EGP</td>
                            <td>{{ $wd->payment_method ?? 'N/A' }}</td>
                            <td>{{ $wd->payment_details ?? 'N/A' }}</td>
                            <td>{{ $wd->created_at->format('M d, Y') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.withdrawals.process', $wd->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 6px 16px;">✅ Process</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #6b7280; text-align: center; padding: 40px;">No pending withdrawals.</p>
        @endif
    </div>
</div>
@endsection