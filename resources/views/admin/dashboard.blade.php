@extends('layouts.main')

@section('title', 'Admin Dashboard - OstazON')

@section('content')
<style>
    .admin-container { max-width: 1400px; margin: 0 auto; padding: 40px 24px; }
    .admin-header { margin-bottom: 32px; }
    .admin-header h1 { font-size: 32px; font-weight: 800; }
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px; }
    .stat-card { background: white; border-radius: 16px; padding: 24px; box-shadow: var(--shadow); }
    .stat-card h3 { font-size: 14px; color: var(--text-light); margin-bottom: 8px; }
    .stat-card .value { font-size: 28px; font-weight: 800; color: var(--primary); }
    .action-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
    .action-card { background: white; border-radius: 20px; padding: 28px; box-shadow: var(--shadow); text-decoration: none; color: inherit; transition: transform 0.3s; }
    .action-card:hover { transform: translateY(-4px); }
    .action-card .icon { font-size: 32px; margin-bottom: 12px; }
    .action-card h3 { font-size: 18px; font-weight: 700; margin-bottom: 8px; }
    .action-card p { color: var(--text-light); font-size: 14px; }
    .badge-count { background: var(--accent); color: white; padding: 2px 8px; border-radius: 50px; font-size: 12px; font-weight: 700; margin-left: 8px; }
</style>

<div class="admin-container">
    <div class="admin-header">
        <h1>Admin Dashboard</h1>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Users</h3>
            <div class="value">{{ $totalUsers ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h3>Pending Verifications</h3>
            <div class="value">{{ $pendingVerifications ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h3>Pending Payments</h3>
            <div class="value">{{ $pendingPayments ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h3>Total Revenue</h3>
            <div class="value">{{ $totalRevenue ?? 0 }} EGP</div>
        </div>
    </div>

    <div class="action-grid">
        <a href="{{ route('admin.payments') }}" class="action-card">
            <div class="icon">💳</div>
            <h3>Payment Verifications <span class="badge-count">{{ $pendingPayments ?? 0 }}</span></h3>
            <p>Verify coin purchases and process payments</p>
        </a>
        <a href="{{ route('admin.tutors.index') }}" class="action-card">
            <div class="icon">🎓</div>
            <h3>Tutor Verifications <span class="badge-count">{{ $pendingVerifications ?? 0 }}</span></h3>
            <p>Review and approve tutor applications</p>
        </a>
        <a href="{{ route('admin.withdrawals') }}" class="action-card">
            <div class="icon">💰</div>
            <h3>Withdrawals</h3>
            <p>Process tutor withdrawal requests</p>
        </a>
        <a href="{{ route('admin.disputes') }}" class="action-card">
            <div class="icon">⚖️</div>
            <h3>Disputes</h3>
            <p>Resolve student-tutor disputes</p>
        </a>
        <a href="{{ route('admin.arbitrations') }}" class="action-card">
            <div class="icon">⚙️</div>
            <h3>Arbitrations</h3>
            <p>Review and resolve arbitration cases</p>
        </a>
        <a href="{{ route('admin.analytics') }}" class="action-card">
            <div class="icon">📊</div>
            <h3>Analytics</h3>
            <p>View platform statistics and reports</p>
        </a>
    </div>
</div>
@endsection
