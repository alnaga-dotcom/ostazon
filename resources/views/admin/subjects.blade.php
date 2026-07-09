@extends('layouts.main')

@section('title', 'Subjects - Admin - OstazON')

@section('content')

@if(session('success'))
    <div style="max-width: 1400px; margin: 0 auto; padding: 20px 24px 0;">
        <div style="padding: 16px 24px; background: #dcfce7; color: #166534; border-radius: 12px; font-weight: 600;">
            ✅ {{ session('success') }}
        </div>
    </div>
@endif

@if($errors->any())
    <div style="max-width: 1400px; margin: 0 auto; padding: 20px 24px 0;">
        <div style="padding: 16px 24px; background: #fee2e2; color: #dc2626; border-radius: 12px; font-weight: 600;">
            ❌ {{ $errors->first() }}
        </div>
    </div>
@endif

<style>
    .admin-container { max-width: 1200px; margin: 0 auto; padding: 40px 24px; }
    .admin-header { margin-bottom: 32px; }
    .admin-header h1 { font-size: 32px; font-weight: 800; }
    .card { background: white; border-radius: 20px; box-shadow: var(--shadow); overflow: hidden; padding: 28px; margin-bottom: 24px; }
    .card h2 { font-size: 20px; font-weight: 700; margin-bottom: 20px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 12px; align-items: end; }
    .form-grid input, .form-grid select { width: 100%; padding: 10px 14px; border: 2px solid #E5E7EB; border-radius: 10px; font-size: 14px; }
    .form-grid input:focus { border-color: var(--primary); outline: none; }
    .btn-add { background: var(--primary); color: white; padding: 10px 24px; border: none; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; white-space: nowrap; }
    .btn-add:hover { background: #14532d; }
    .table { width: 100%; border-collapse: collapse; }
    .table th { text-align: left; padding: 14px 16px; font-size: 12px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; background: #F9FAFB; border-bottom: 2px solid #E5E7EB; position: sticky; top: 0; z-index: 1; }
    .table td { padding: 14px 16px; font-size: 14px; border-bottom: 1px solid #F3F4F6; vertical-align: middle; }
    .table tbody tr:nth-child(even) td { background: #F9FAFB; }
    .table tbody tr:hover td { background: #ECFDF0; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 50px; font-size: 12px; font-weight: 600; }
    .badge-active { background: #dcfce7; color: #166534; }
    .badge-inactive { background: #fee2e2; color: #dc2626; }
    .btn-icon { padding: 6px 14px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; }
    .btn-edit { background: #FEF3C7; color: #92400E; }
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-save-sm { background: var(--primary); color: white; padding: 6px 14px; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; }
    .inline-form { display: inline; }
    .edit-row { background: #FFFBEB; }
    .edit-row input { padding: 6px 10px; border: 2px solid #D97706; border-radius: 6px; font-size: 14px; width: 160px; }
</style>

<div class="admin-container">
    <div class="admin-header">
        <h1>{{ app()->getLocale() == 'ar' ? 'إدارة المواد الدراسية' : 'Subject Management' }}</h1>
        <p style="color: var(--text-light); margin-top: 4px;">{{ count($allSubjects) }} {{ app()->getLocale() == 'ar' ? 'مادة' : 'subjects' }}</p>
    </div>

    <div class="card">
        <h2>{{ app()->getLocale() == 'ar' ? 'إضافة مادة جديدة' : 'Add New Subject' }}</h2>
        <form method="POST" action="{{ route('admin.subjects.store') }}">
            @csrf
            <div class="form-grid">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px; color: var(--text-light);">{{ app()->getLocale() == 'ar' ? 'الاسم (إنجليزي)' : 'Name (EN)' }}</label>
                    <input type="text" name="name" required placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: Philosophy' : 'e.g. Philosophy' }}">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px; color: var(--text-light);">{{ app()->getLocale() == 'ar' ? 'الاسم (عربي)' : 'Name (AR)' }}</label>
                    <input type="text" name="name_ar" placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: فلسفة' : 'e.g. فلسفة' }}">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px; color: var(--text-light);">{{ app()->getLocale() == 'ar' ? 'التصنيف' : 'Category' }}</label>
                    <input type="text" name="category" placeholder="{{ app()->getLocale() == 'ar' ? 'مثال: علوم إنسانية' : 'e.g. Humanities' }}">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px; color: var(--text-light);">{{ app()->getLocale() == 'ar' ? 'الأيقونة' : 'Icon' }}</label>
                    <input type="text" name="icon" placeholder="e.g. 📐" style="max-width: 100px;">
                </div>
                <button type="submit" class="btn-add">{{ app()->getLocale() == 'ar' ? 'إضافة' : 'Add' }}</button>
            </div>
        </form>
    </div>

    <div class="card">
        <h2>{{ app()->getLocale() == 'ar' ? 'قائمة المواد' : 'Subject List' }}</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الاسم' : 'Name' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الاسم (عربي)' : 'Name (AR)' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'التصنيف' : 'Category' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الأيقونة' : 'Icon' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'الحالة' : 'Status' }}</th>
                    <th>{{ app()->getLocale() == 'ar' ? 'إجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allSubjects as $subject)
                    <tr>
                        <td style="color: var(--text-light);">{{ $subject->id }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.subjects.update', $subject) }}" class="inline-form">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" value="{{ $subject->name }}" style="padding: 4px 8px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 14px; width: 140px;">
                        </td>
                        <td>
                                <input type="text" name="name_ar" value="{{ $subject->name_ar }}" style="padding: 4px 8px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 14px; width: 140px;" placeholder="{{ app()->getLocale() == 'ar' ? 'فلسفة' : 'فلسفة' }}">
                        <td>
                                <input type="text" name="category" value="{{ $subject->category }}" style="padding: 4px 8px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 14px; width: 120px;">
                        </td>
                        <td>
                                <input type="text" name="icon" value="{{ $subject->icon }}" style="padding: 4px 8px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 14px; width: 60px;" placeholder="📐">
                        </td>
                        <td>
                            <select name="is_active" style="padding: 4px 8px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 13px;">
                                <option value="1" {{ $subject->is_active ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'نشط' : 'Active' }}</option>
                                <option value="0" {{ !$subject->is_active ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'غير نشط' : 'Inactive' }}</option>
                            </select>
                        </td>
                        <td style="display: flex; gap: 6px;">
                                <button type="submit" class="btn-icon btn-save-sm">{{ app()->getLocale() == 'ar' ? 'حفظ' : 'Save' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.subjects.delete', $subject) }}" class="inline-form" onsubmit="return confirm('{{ app()->getLocale() == 'ar' ? 'حذف هذه المادة؟' : 'Delete this subject?' }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete">{{ app()->getLocale() == 'ar' ? 'حذف' : 'Delete' }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-light);">
                            {{ app()->getLocale() == 'ar' ? 'لا توجد مواد بعد' : 'No subjects yet' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection