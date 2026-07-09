@extends('layouts.main')

@section('title', 'User Management - Admin - OstazON')

@section('content')
<style>
    .a-container { max-width: 1400px; margin: 0 auto; padding: 40px 24px; }
    .table-wrap { overflow-x: auto; }
    .tbl { width: 100%; border-collapse: collapse; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .tbl th { background: #166534; color: white; padding: 14px 16px; text-align: left; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
    .tbl td { padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
    .tbl tr:hover td { background: #f0fdf4; }
    .badge { display: inline-block; padding: 2px 10px; border-radius: 50px; font-size: 12px; font-weight: 700; }
    .badge-active { background: #dcfce7; color: #166534; }
    .badge-suspended { background: #fef2f2; color: #dc2626; }
    .badge-admin { background: #fef3c7; color: #d97706; }
    .badge-tutor { background: #dbeafe; color: #1d4ed8; }
    .badge-student { background: #f3e8ff; color: #7c3aed; }
</style>

<div class="a-container">
    <h1 style="font-size: 32px; font-weight: 800; margin-bottom: 8px;">User Management</h1>
    <p style="color: #6b7280; margin-bottom: 24px;">Manage all platform users — suspend or reactivate accounts</p>

    @if(session('success'))
        <div style="background:#dcfce7;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:12px;margin-bottom:20px;">{{ session('success') }}</div>
    @endif

    <div class="table-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="font-weight:700;color:#6b7280;">#{{ $user->id }}</td>
                        <td style="font-weight:600;">{{ $user->name }}</td>
                        <td style="color:#6b7280;">{{ $user->email }}</td>
                        <td>
                            <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge badge-active">Active</span>
                            @else
                                <span class="badge badge-suspended">Suspended</span>
                            @endif
                        </td>
                        <td style="color:#6b7280;font-size:13px;">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span style="color:#6b7280;font-size:13px;">—</span>
                            @elseif($user->is_active)
                                <form method="POST" action="{{ route('admin.users.ban', $user) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Suspend {{ $user->name }}?')" style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;padding:6px 14px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">Suspend</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.users.unban', $user) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="background:#dcfce7;color:#166534;border:1px solid #86efac;padding:6px 14px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">Reactivate</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;padding:40px;color:#6b7280;">No users found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:24px;">
        {{ $users->links() }}
    </div>
</div>
@endsection