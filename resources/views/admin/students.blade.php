@extends('layouts.main')

@section('title', 'Students - Admin - OstazON')

@section('content')

@if(session('success'))
    <div style="max-width: 1400px; margin: 0 auto; padding: 20px 24px 0;">
        <div style="padding: 16px 24px; background: #dcfce7; color: #166534; border-radius: 12px; font-weight: 600;">
            ✅ {{ session('success') }}
        </div>
    </div>
@endif

<style>
    .admin-container { max-width: 1400px; margin: 0 auto; padding: 40px 24px; }
    .admin-header { margin-bottom: 32px; }
    .admin-header h1 { font-size: 32px; font-weight: 800; }
    .card { background: white; border-radius: 20px; box-shadow: var(--shadow); overflow: hidden; }
    .table { width: 100%; border-collapse: collapse; }
    .table th { text-align: left; padding: 14px 20px; font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; background: #F9FAFB; border-bottom: 2px solid #E5E7EB; position: sticky; top: 0; z-index: 1; }
    .table td { padding: 14px 20px; font-size: 14px; border-bottom: 1px solid #F3F4F6; }
    .table tbody tr:nth-child(even) td { background: #F9FAFB; }
    .table tbody tr:hover td { background: #ECFDF0; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 50px; font-size: 12px; font-weight: 600; }
    .badge-active { background: #dcfce7; color: #166534; }
    .badge-inactive { background: #fee2e2; color: #dc2626; }
    .pagination { padding: 20px; display: flex; justify-content: center; }
    .pagination a, .pagination span { padding: 8px 14px; margin: 0 2px; border-radius: 8px; font-size: 14px; color: var(--text-dark); text-decoration: none; background: #F3F4F6; }
    .pagination .active { background: var(--primary); color: white; }
</style>

<div class="admin-container">
    <div class="admin-header">
        <h1>{{ app()->getLocale() == 'ar' ? 'الطلاب' : 'Students' }}</h1>
        <p style="color: var(--text-light); margin-top: 4px;">{{ $students->total() }} {{ app()->getLocale() == 'ar' ? 'طالب مسجل' : 'registered students' }}</p>
    </div>

    <div class="card">
        <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الاسم' : 'Name' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الهاتف' : 'Phone' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الحالة' : 'Status' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الرصيد' : 'Coins' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الحصص' : 'Lessons' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'تاريخ التسجيل' : 'Joined' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td style="color: var(--text-light);">{{ $student->id }}</td>
                        <td><strong>{{ $student->name }}</strong></td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $student->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $student->is_active ? (app()->getLocale() == 'ar' ? 'نشط' : 'Active') : (app()->getLocale() == 'ar' ? 'غير نشط' : 'Inactive') }}
                            </span>
                        </td>
                        <td>{{ $student->studentProfile->coins_balance ?? 0 }}</td>
                        <td>{{ $student->studentProfile->total_lessons ?? 0 }}</td>
                        <td style="color: var(--text-light);">{{ $student->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 60px 20px; color: var(--text-light);">
                            {{ app()->getLocale() == 'ar' ? 'لا يوجد طلاب مسجلين' : 'No students registered yet' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        @if($students->hasPages())
            <div class="pagination">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection